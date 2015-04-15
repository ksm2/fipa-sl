PHP FIPA SL 0.1.0
=================

PHP Library for serializing FIPA SL messages.

## Introduction

The [**Foundation for Intelligent Physical Agents** *(FIPA)*][FIPA] is a group at IEEE which proposes a lot of standards in agent oriented software engineering (AOSE). One of those standards is the [**Semantic Language** *(SL)*][SL] specification (FIPA00008). 

This library adds serialization and unserialization support for SL-encoded objects.

## Installation

Install it using Composer:

```
composer require corny-phoenix/fipa-sl 0.1.0
```

[FIPA]: http://en.wikipedia.org/wiki/FIPA
[SL]: http://www.fipa.org/specs/fipa00008/

## Basic Usage

```php
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
```
