<?php
namespace Service;

use Config;
use Service\Slack;
use Aws\Sqs\SqsClient;
use App\Model\Message;
use App\Responder\Kernel as ResponderKernel;

class Queue
{
    private $url;
    private $access;
    private $secret;
    private $region;
    private $sqs;

    public function __construct()
    {
      $this->url    = getenv("QUEUE_URL");
      $this->access = getenv("QUEUE_ACCESS_TOKEN");
      $this->secret = getenv("QUEUE_SECRET_TOKEN");
      $this->region = getenv("QUEUE_REGION");
      $this->sqs    = SqsClient::factory(array(
        'credentials' => [
            'key'     => $this->access,
            'secret'  => $this->secret,
        ],
        'region'  => $this->region,
        'version' => 'latest'
      ));
    }

    public function work()
    {
      $result = $this->sqs->receiveMessage(array(
          'QueueUrl' => $this->url,
          'WaitTimeSeconds' => 10
      ));
      $message = $result["Messages"]["0"]["Body"];
      if (! $message) {

      }

      $message = json_decode($message, True);

      if ($message["user_name"] == "slackbot") {
        return;
      }

      $entry = new Message;
      $entry->text = $message["text"];
      $entry->user = $message["user_name"];
      $entry->channel = $message["channel_name"];
      $entry->save();

      if ($this->shouldInvokeBot($entry->text)) {
        $this->command($entry);
      }

      $this->sqs->deleteMessage([
          "QueueUrl" => $this->url,
          "ReceiptHandle" => $result["Messages"][0]["ReceiptHandle"],
      ]);
    }

    private function command(Message $entry)
    {
      $signature = trim($entry->text);
      $signature = explode(" ", $entry->text);

      array_shift($signature);
      $command = trim(strtolower(trim($signature[0])), '?!.');

      $kernel = new ResponderKernel;
      if ($kernel->has($command, $entry->channel)) {
        $responder = $kernel->responderForObject($command, $entry->channel);
        $responder->run(["raw" => $signature, "channel" => $entry->channel, "user" => $entry->user]);
      }
    }

    private function shouldInvokeBot(string $message)
    {
      $message = strtolower($message);

      if (substr(trim(explode(" ", $message)[0]), -1) == ",") {
          $message = substr(trim(explode(" ", $message)[0]), 0, -1);
      }

      if (trim(explode(" ", $message)[0]) == strtolower(getenv("BOT_NAME"))) {
        return True;
      }

      return False;
    }
}
