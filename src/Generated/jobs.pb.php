<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: jobs.proto

namespace Tg\Rabbit\Generated;

use Google\Protobuf\Internal\DescriptorPool;
use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

class HelloJob extends \Google\Protobuf\Internal\Message
{
    private $some_data = '';

    public function getSomeData()
    {
        return $this->some_data;
    }

    public function setSomeData($var)
    {
        GPBUtil::checkString($var, True);
        $this->some_data = $var;
    }

}

$pool = DescriptorPool::getGeneratedPool();

$pool->internalAddGeneratedFile(hex2bin(
    "0a480a0a6a6f62732e70726f746f121354672e5261626269742e47656e65" .
    "7261746564221d0a0848656c6c6f4a6f6212110a09736f6d655f64617461" .
    "180120012809620670726f746f33"
));
