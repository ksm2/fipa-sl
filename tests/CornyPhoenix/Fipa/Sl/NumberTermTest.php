<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Context\DefaultTupleContext;
use CornyPhoenix\Fipa\Sl\Context\TupleContext;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class NumberTermTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var TupleContext
     */
    private $context;

    protected function setUp()
    {
        $this->context = new DefaultTupleContext();
    }

    /**
     * Tests Integer terms.
     */
    public function testInt()
    {
        $term = new IntegerTerm(4096);
        $this->assertEquals(4096, $term->getValue());

        $term = new IntegerTerm(false);
        $this->assertEquals(0, $term->getValue());

        $term = new IntegerTerm(true);
        $this->assertEquals(1, $term->getValue());

        $term->setValue(2048);
        $this->assertEquals(2048, $term->getValue());

        $term->setValue("string");
        $this->assertEquals(0, $term->getValue());

        $term->setValue("23");
        $this->assertEquals(23, $term->getValue());

        $term->fromString("string", $this->context);
        $this->assertEquals(0, $term->getValue());

        $term->fromString("256", $this->context);
        $this->assertEquals(256, $term->getValue());

        $term->fromString(IntegerTerm::SL_FALSE, $this->context);
        $this->assertEquals(0, $term->getValue());

        $term->fromString(IntegerTerm::SL_TRUE, $this->context);
        $this->assertEquals(0, $term->getValue());
    }

    /**
     * Tests nullability of Integer terms.
     */
    public function testIntNullability()
    {
        $term = new IntegerTerm();
        $this->assertNull($term->getValue());

        $term = new IntegerTerm(null);
        $this->assertNull($term->getValue());

        $term->setValue(null);
        $this->assertNull($term->getValue());

        $this->assertEquals(IntegerTerm::SL_NULL, $term->toString($this->context));

        $term->fromString(IntegerTerm::SL_NULL, $this->context);
        $this->assertNull($term->getValue());
    }

    /**
     * Tests Float terms.
     */
    public function testFloat()
    {
        $term = new FloatTerm(42.13);
        $this->assertEquals(42.13, $term->getValue());

        $term = new FloatTerm(false);
        $this->assertEquals(0, $term->getValue());

        $term = new FloatTerm(true);
        $this->assertEquals(1, $term->getValue());

        $term->setValue(1337.42);
        $this->assertEquals(1337.42, $term->getValue());

        $term->setValue("string");
        $this->assertEquals(0, $term->getValue());

        $term->setValue("23.23");
        $this->assertEquals(23.23, $term->getValue());

        $term->fromString("string", $this->context);
        $this->assertEquals(0, $term->getValue());

        $term->fromString("42.1337", $this->context);
        $this->assertEquals(42.1337, $term->getValue());

        $term->fromString(FloatTerm::SL_FALSE, $this->context);
        $this->assertEquals(0, $term->getValue());

        $term->fromString(FloatTerm::SL_TRUE, $this->context);
        $this->assertEquals(0, $term->getValue());
    }

    /**
     * Tests nullability of Float terms.
     */
    public function testFloatNullability()
    {
        $term = new FloatTerm();
        $this->assertNull($term->getValue());

        $term = new FloatTerm(null);
        $this->assertNull($term->getValue());

        $term->setValue(null);
        $this->assertNull($term->getValue());

        $this->assertEquals(FloatTerm::SL_NULL, $term->toString($this->context));

        $term->fromString(FloatTerm::SL_NULL, $this->context);
        $this->assertNull($term->getValue());
    }
}
