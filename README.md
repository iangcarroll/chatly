# Chatly
A modular chatbot written in PHP.

## Features
* Eloquent + SQLite for persistent data
* Channel-specific commands
* Modular (extended via Composer modules)

## Setup
Chatly pipes in messages via Slack's AWS Simple Queue Service integration. This is beneficial in that Chatly will still process old messages if it goes down. Chatly replies to messages via an Incoming Webhook. You need to create both of these integrations and the AWS SQS queue to continue. Chatly will not override the Incoming Webhook's style, so customize Chatly's appearance (username, avatar, bio, etc) there.

Copy the `.env.example` file to `.env` and fill in the variables. They should be self explanatory. The file is in `key=value` format.
