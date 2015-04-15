<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Context\DefaultTupleContext;
use CornyPhoenix\Fipa\Sl\Context\TupleContext;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class BoolTermTest extends \PHPUnit_Framework_TestCase
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
}
