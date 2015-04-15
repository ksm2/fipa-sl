<?php

include('vendor/autoload.php');

use CornyPhoenix\Fipa\Sl\Serializer\DefaultTupleSerializer;
use CornyPhoenix\Fipa\Sl\Context\DefaultTupleContext;
use CornyPhoenix\Fipa\Sl\Registry\DefaultTupleRegistry;

$registry = new DefaultTupleRegistry();
$context = DefaultTupleContext::getInstance();
$serializer = new DefaultTupleSerializer($context, $registry);

$frame = $serializer->unserialize('(frame "foo")');
var_dump($frame->getFrame()); // string(5) "frame"
var_dump($frame->getTerms()[0]->getValue()); // string(3) "foo"
