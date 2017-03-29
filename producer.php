<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Tg\Rabbit\Generated\HelloJob;

require __DIR__.'/vendor/autoload.php';

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('task_queue', false, true, false, false);

foreach (range(0, 10000) as $i) {

    $data = new HelloJob();
    $data->setSomeData('Testdaten für Job '. $i);

    $channel->basic_publish(
        new AMQPMessage(
            $data->encode(),
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        ),
    '', 'task_queue');
}


echo "produced some messages\n";

$channel->close();
$connection->close();