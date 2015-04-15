<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Context\DefaultTupleContext;
use CornyPhoenix\Fipa\Sl\Context\TupleContext;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class StringTermTest extends \PHPUnit_Framework_TestCase
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
