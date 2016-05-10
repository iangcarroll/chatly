<?php

namespace Service;

use App\Model\Message;
use App\Responder\Kernel as ResponderKernel;
use Aws\Sqs\SqsClient;

class Queue
{
    private $url;
    private $access;
    private $secret;
    private $region;
    private $sqs;

    public function __construct()
    {
        $this->url = getenv('QUEUE_URL');
        $this->access = getenv('QUEUE_ACCESS_TOKEN');
        $this->secret = getenv('QUEUE_SECRET_TOKEN');
        $this->region = getenv('QUEUE_REGION');
        
        $this->sqs = SqsClient::factory([
            'credentials' => [
                'key'     => $this->access,
                'secret'  => $this->secret,
            ],
            'region'  => $this->region,
            'version' => 'latest',
        ]);
    }

    public function work()
    {
        $result = $this->sqs->receiveMessage([
          'QueueUrl'        => $this->url,
          'WaitTimeSeconds' => 10,
        ]);
        
        $message = $result['Messages']['0']['Body'];
        
        if (!$message) {
            return;
        }

        $message = json_decode($message, true);

        if ($message['user_name'] == 'slackbot') {
            return;
        }
        
        $entry = Message::create([
            'text' => $message['text'],
            'user' => $message['user_name'],
            'channel' => $message['channel_name'],
        ]);

        if ($this->shouldInvokeBot($entry->text)) {
            $this->command($entry);
        }

        $this->sqs->deleteMessage([
          'QueueUrl'      => $this->url,
          'ReceiptHandle' => $result['Messages'][0]['ReceiptHandle'],
        ]);

        $this->wait();
    }

    public function wait($seconds = 10)
    {
        sleep($seconds);
    }

    private function command(Message $entry)
    {
        $signature = explode(' ', trim($entry->text));

        array_shift($signature);
        
        $command = trim(strtolower(trim($signature[0])), '?!.');

        $kernel = new ResponderKernel();
        
        if ($kernel->has($command, $entry->channel)) {
            $responder = $kernel->responderForObject($command, $entry->channel);

            $responder->run([
                'raw' => $signature,
                'channel' => $entry->channel,
                'user' => $entry->user
            ]);
        }
    }

    private function shouldInvokeBot($message)
    {
        $message = strtolower($message);

        if (substr(trim(explode(' ', $message)[0]), -1) == ',') {
            $message = substr(trim(explode(' ', $message)[0]), 0, -1);
        }

        if (trim(explode(' ', $message)[0]) == strtolower(getenv('BOT_NAME'))) {
            return true;
        }

        return false;
    }
}
