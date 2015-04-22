<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Context\DefaultTupleContext;
use CornyPhoenix\Fipa\Sl\Context\TupleContext;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class DefaultTupleContextTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var TupleContext
     */
    private $context;

    protected function setUp()
    {
        $this->context = DefaultTupleContext::getInstance();
    }

    public function testEncode()
    {
        $this->assertEquals('', $this->context->encode(''));
        $this->assertEquals('\(\)', $this->context->encode('()'));
        $this->assertEquals('"Hello World"', $this->context->encode('Hello World'));
        $this->assertEquals('"Hello \"World"', $this->context->encode('Hello "World'));
        $this->assertEquals('\"World\"', $this->context->encode('"World"'));
        $this->assertEquals('"null"', $this->context->encode('null'));
        $this->assertEquals('"false"', $this->context->encode('false'));
        $this->assertEquals('"true"', $this->context->encode('true'));
        $this->assertEquals('"True"', $this->context->encode('True'));
    }

    public function testDecode()
    {
        $this->assertEquals('', $this->context->decode(''));
        $this->assertEquals('()', $this->context->decode('\(\)'));
        $this->assertEquals('Hello World', $this->context->decode('"Hello World"'));
        $this->assertEquals('Hello "World', $this->context->decode('"Hello \"World"'));
        $this->assertEquals('"World"', $this->context->decode('\"World\"'));
        $this->assertEquals('null', $this->context->decode('"null"'));
        $this->assertEquals('false', $this->context->decode('"false"'));
        $this->assertEquals('true', $this->context->decode('"true"'));
        $this->assertEquals('True', $this->context->decode('"True"'));
    }
}
