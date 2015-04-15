<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Context\DefaultTupleContext;
use CornyPhoenix\Fipa\Sl\Context\TupleContext;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class NullTermTest extends \PHPUnit_Framework_TestCase
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
}
