<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Context\DefaultTupleContext;
use CornyPhoenix\Fipa\Sl\Context\TupleContext;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class LiteralTermTest extends \PHPUnit_Framework_TestCase
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
     * Tests Null terms.
     */
    public function testNull()
    {
        $term = new NullTerm();
        $this->assertNull($term->getValue());

        $term->setValue(42);
        $this->assertNull($term->getValue());

        $term->setValue("string");
        $this->assertNull($term->getValue());

        $this->assertEquals(NullTerm::SL_NULL, $term->toString($this->context));

        $term->fromString("string", $this->context);
        $this->assertNull($term->getValue());

        $term->fromString(NullTerm::SL_FALSE, $this->context);
        $this->assertNull($term->getValue());

        $term->fromString(NullTerm::SL_TRUE, $this->context);
        $this->assertNull($term->getValue());
    }

    /**
     * Tests Bool terms.
     */
    public function testBool()
    {
        $term = new BoolTerm(true);
        $this->assertTrue($term->getValue());

        $term = new BoolTerm(false);
        $this->assertFalse($term->getValue());

        $term->setValue(42);
        $this->assertFalse($term->getValue());

        $term->setValue("string");
        $this->assertFalse($term->getValue());

        $term->fromString("string", $this->context);
        $this->assertFalse($term->getValue());

        $term->fromString(BoolTerm::SL_FALSE, $this->context);
        $this->assertFalse($term->getValue());

        $term->fromString(BoolTerm::SL_TRUE, $this->context);
        $this->assertTrue($term->getValue());
    }

    /**
     * Tests nullability of Bool terms.
     */
    public function testBoolNullability()
    {
        $term = new BoolTerm(null);
        $this->assertNull($term->getValue());

        $term->setValue(null);
        $this->assertNull($term->getValue());

        $this->assertEquals(BoolTerm::SL_NULL, $term->toString($this->context));

        $term->fromString(BoolTerm::SL_NULL, $this->context);
        $this->assertNull($term->getValue());
    }

    /**
     * Tests Integer terms.
     */
    public function testInt()
    {
        $term = new IntegerTerm(42);
        $this->assertEquals(42, $term->getValue());

        $term = new IntegerTerm(false);
        $this->assertEquals(0, $term->getValue());

        $term = new IntegerTerm(true);
        $this->assertEquals(1, $term->getValue());

        $term->setValue(1337);
        $this->assertEquals(1337, $term->getValue());

        $term->setValue("string");
        $this->assertEquals(0, $term->getValue());

        $term->setValue("23");
        $this->assertEquals(23, $term->getValue());

        $term->fromString("string", $this->context);
        $this->assertEquals(0, $term->getValue());

        $term->fromString("42", $this->context);
        $this->assertEquals(42, $term->getValue());

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

    /**
     * Tests String terms.
     */
    public function testString()
    {
        $term = new StringTerm(42.13);
        $this->assertEquals("42.13", $term->getValue());
        $term = new StringTerm("foo");
        $this->assertEquals("foo", $term->getValue());
        $this->assertEquals('"foo"', $term->toString($this->context));

        $term = new StringTerm(false);
        $this->assertEquals(StringTerm::SL_FALSE, $term->getValue());
        $this->assertEquals('"false"', $term->toString($this->context));

        $term = new StringTerm(true);
        $this->assertEquals(StringTerm::SL_TRUE, $term->getValue());
        $this->assertEquals('"true"', $term->toString($this->context));

        $term->setValue(1337.42);
        $this->assertEquals("1337.42", $term->getValue());
        $this->assertEquals('"1337.42"', $term->toString($this->context));

        $term->setValue("string");
        $this->assertEquals("string", $term->getValue());
        $this->assertEquals('"string"', $term->toString($this->context));

        $term->setValue("23.23");
        $this->assertEquals("23.23", $term->getValue());

        $term->fromString("string", $this->context);
        $this->assertEquals("string", $term->getValue());

        $term->fromString("42.1337", $this->context);
        $this->assertEquals("42.1337", $term->getValue());

        $term->fromString(StringTerm::SL_FALSE, $this->context);
        $this->assertEquals(StringTerm::SL_FALSE, $term->getValue());

        $term->fromString(StringTerm::SL_TRUE, $this->context);
        $this->assertEquals(StringTerm::SL_TRUE, $term->getValue());
    }

    /**
     * Tests nullability of String terms.
     */
    public function testStringNullability()
    {
        $term = new StringTerm();
        $this->assertNull($term->getValue());

        $term = new StringTerm(null);
        $this->assertNull($term->getValue());

        $term->setValue(null);
        $this->assertNull($term->getValue());

        $this->assertEquals(StringTerm::SL_NULL, $term->toString($this->context));

        $term->fromString(StringTerm::SL_NULL, $this->context);
        $this->assertNull($term->getValue());
    }
}
