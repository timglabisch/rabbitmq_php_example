<?php

require_once __DIR__ . '/vendor/autoload.php';
use Google\Protobuf\Internal\InputStream;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Tg\Rabbit\Generated\HelloJob;



$message_count = 50;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('task_queue', false, true, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";


$channel->basic_qos(null, 1, null);
$channel->basic_consume('task_queue', '', false, false, false, false, function(AMQPMessage $msg) {

    $jobdata = new HelloJob();
    if (!$jobdata->parseFromStream(new InputStream($msg->body))) {
        throw new \RuntimeException('Could not parse Job');
    }

    if (rand(0, 100) === 100) {
        echo "oh no....";
        die(0);
    }

    echo " [x] Received ", $jobdata->getSomeData(), "\n";
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
});

while(count($channel->callbacks)) {


    if (!$message_count--) {
        echo "Handelt enought messages ...";
        break;
    }

    $channel->wait();
}

$channel->close();
$connection->close();