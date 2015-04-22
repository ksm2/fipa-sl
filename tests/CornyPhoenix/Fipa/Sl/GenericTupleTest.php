<?php

namespace CornyPhoenix\Fipa\Sl;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class GenericTupleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests setting the frame.
     */
    public function testFrame()
    {
        $tuple = new GenericTuple('frame');
        $this->assertEquals('frame', $tuple->getFrame());

        $tuple = new GenericTuple(42);
        $this->assertEquals('42', $tuple->getFrame());

        $tuple = new GenericTuple(true);
        $this->assertEquals('1', $tuple->getFrame());
    }

    /**
     * @expectedException \CornyPhoenix\Fipa\Sl\Exception\FrameMustNotBeEmptyException
     */
    public function testFalseFrameThrowsException()
    {
        new GenericTuple(false);
    }

    /**
     * @expectedException \CornyPhoenix\Fipa\Sl\Exception\FrameMustNotBeEmptyException
     */
    public function testNullFrameThrowsException()
    {
        new GenericTuple(null);
    }

    /**
     * @expectedException \CornyPhoenix\Fipa\Sl\Exception\FrameMustNotBeEmptyException
     */
    public function testEmptyFrameThrowsException()
    {
        new GenericTuple('');
    }

    /**
     * Test adding of terms.
     */
    public function testAddTerm()
    {
        $term = new NullTerm();
        $tuple = new GenericTuple('frame');

        $this->assertFalse($tuple->containsTerm($term));
        $this->assertCount(0, $tuple->getTerms());

        $tuple->addTerm($term);
        $this->assertTrue($tuple->containsTerm($term));
        $this->assertCount(1, $tuple->getTerms());

        $tuple->removeTerm($term);
        $this->assertFalse($tuple->containsTerm($term));
        $this->assertCount(0, $tuple->getTerms());

        $tuple->addString('Foo');
        $this->assertCount(1, $tuple->getTerms());

        $tuple->addInt(42);
        $this->assertCount(2, $tuple->getTerms());

        $tuple->addFloat(1337.66);
        $this->assertCount(3, $tuple->getTerms());

        $tuple->addBool(true);
        $this->assertCount(4, $tuple->getTerms());

        $tuple->addNull();
        $this->assertCount(5, $tuple->getTerms());
    }

    /**
     * Test setting of parameters.
     */
    public function testSetParameter()
    {
        $term = new NullTerm();
        $tuple = new GenericTuple('frame');
        $key = 'key';

        $this->assertNull($tuple->getParameter($key));
        $this->assertEquals($term, $tuple->getParameter($key, $term));

        $this->assertFalse($tuple->containsTerm($term));
        $this->assertFalse($tuple->hasParameter($key));

        $tuple->setParameter($key, $term);
        $this->assertTrue($tuple->containsTerm($term));
        $this->assertTrue($tuple->hasParameter($key));

        $this->assertEquals($term, $tuple->getParameter($key));

        $tuple->removeParameter($key);
        $this->assertFalse($tuple->containsTerm($term));
        $this->assertFalse($tuple->hasParameter($key));
        $this->assertNull($tuple->getParameter($key));
    }

    /**
     * Test setting of literals.
     */
    public function testSetLiterals()
    {
        $tuple = new GenericTuple('frame');
        $key = 'key';

        $this->assertNull($tuple->getBool($key));
        $this->assertNull($tuple->getInt($key));
        $this->assertNull($tuple->getFloat($key));
        $this->assertNull($tuple->getString($key));
        $this->assertFalse($tuple->isNull($key));

        $tuple->setBool($key, true);
        $this->assertTrue($tuple->hasParameter($key));
        $this->assertTrue($tuple->getBool($key));

        $tuple->setBool($key, false);
        $this->assertTrue($tuple->hasParameter($key));
        $this->assertFalse($tuple->getBool($key));

        $tuple->setInt($key, 42);
        $this->assertTrue($tuple->hasParameter($key));
        $this->assertEquals(42, $tuple->getInt($key));

        $tuple->setFloat($key, 1337.23);
        $this->assertTrue($tuple->hasParameter($key));
        $this->assertEquals(1337.23, $tuple->getFloat($key));

        $tuple->setString($key, "string");
        $this->assertTrue($tuple->hasParameter($key));
        $this->assertEquals("string", $tuple->getString($key));

        $tuple->setNull($key);
        $this->assertTrue($tuple->isNull($key));

        $tuple->setParameter($key, new GenericTuple('nested'));
        $this->assertFalse($tuple->isNull($key));
    }
}
