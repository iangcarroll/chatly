# Chatly
A modular chatbot written in PHP.

## Features
* Eloquent + SQLite for persistent data
* Channel-specific commands
* Modular (extended via Composer modules)

## Setup
Chatly pipes in messages via Slack's AWS Simple Queue Service integration. This is beneficial in that Chatly will still process old messages if it goes down. Chatly replies to messages via an Incoming Webhook. You need to create both of these integrations and the AWS SQS queue to continue. Chatly will not override the Incoming Webhook's style, so customize Chatly's appearance (username, avatar, bio, etc) there.

Copy the `.env.example` file to `.env` and fill in the variables. They should be self explanatory. The file is in `key=value` format.

To start processing messages, run `php chat.php listen`.

## External Responders
Responders (commands that can be executed in Slack) can be installed via a simple `composer require user/package`. Then just add the class that extends `App\Responder\Responder` to the `$responders` array in `src/App/Responder/Kernel.php`. Composer will take care of the autoloading.
