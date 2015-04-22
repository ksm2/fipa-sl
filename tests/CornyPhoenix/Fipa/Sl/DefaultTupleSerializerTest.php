<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Context\DefaultTupleContext;
use CornyPhoenix\Fipa\Sl\Context\TupleContext;
use CornyPhoenix\Fipa\Sl\Model\Done;
use CornyPhoenix\Fipa\Sl\Registry\DefaultTupleRegistry;
use CornyPhoenix\Fipa\Sl\Registry\TupleRegistry;
use CornyPhoenix\Fipa\Sl\Serializer\DefaultTupleSerializer;
use CornyPhoenix\Fipa\Sl\Serializer\TupleSerializer;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class DefaultTupleSerializerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var TupleContext
     */
    private $context;

    /**
     * @var TupleRegistry
     */
    private $registry;

    /**
     * @var TupleSerializer
     */
    private $serializer;

    protected function setUp()
    {
        $this->context = new DefaultTupleContext();
        $this->registry = new DefaultTupleRegistry();
        $this->serializer = new DefaultTupleSerializer($this->context, $this->registry);
    }

    /**
     * @expectedException \CornyPhoenix\Fipa\Sl\Exception\ParsingException
     */
    public function testUnequalFrameException()
    {
        $tuple = new GenericTuple('frame');
        $tuple->fromString('(lol )', $this->context);
    }

    /**
     * @expectedException \CornyPhoenix\Fipa\Sl\Exception\ParsingException
     */
    public function testUnparseableFrameException()
    {
        $tuple = new GenericTuple('frame');
        $tuple->fromString('(lol ', $this->context);
    }

    public function testSkipFooBars()
    {
        $tuple = new GenericTuple('frame');
        $tuple->fromString('(frame .)', $this->context);
    }

    /**
     * Tests tuple string deserialization.
     */
    public function testUnserialize()
    {
        $tuple = $this->serializer->unserialize('(frame )');
        $this->assertNotNull($tuple);
        $this->assertInstanceOf(GenericTuple::class, $tuple);

        $this->registry->registerTuple(new Done());

        /** @var Done $tuple */
        $tuple = $this->serializer->unserialize('(done :test-key       (frame (frame2 "bar" -.2 42) ))');
        $this->assertNotNull($tuple);
        $this->assertInstanceOf(Done::class, $tuple);

        $this->assertNotEmpty($tuple->getTerms());
        $this->assertTrue($tuple->hasParameter('test-key'));

        /** @var Tuple $frame */
        $frame = $tuple->getParameter('test-key');
        $this->assertInstanceOf(GenericTuple::class, $frame);
        $this->assertEquals('frame', $frame->getFrame());
        $this->assertNotEmpty($frame->getTerms());

        /** @var LiteralTuple $frame2 */
        $frame2 = $frame->getTerms()[0];
        $this->assertInstanceOf(GenericTuple::class, $frame2);
        $this->assertEquals('frame2', $frame2->getFrame());
        $this->assertCount(3, $frame2->getTerms());

        /** @var StringTerm $string */
        $string = $frame2->getTerms()[0];
        $this->assertInstanceOf(StringTerm::class, $string);
        $this->assertEquals('bar', $string->getValue());

        /** @var FloatTerm $float */
        $float = $frame2->getTerms()[1];
        $this->assertInstanceOf(FloatTerm::class, $float);
        $this->assertEquals(-.2, $float->getValue());

        /** @var IntegerTerm $int */
        $int = $frame2->getTerms()[2];
        $this->assertInstanceOf(IntegerTerm::class, $int);
        $this->assertEquals(42, $int->getValue());

        $tuple = $this->serializer->unserialize('(test-frame "Hallo Welt \(\"Hello World\"\)")');
        $this->assertNotEmpty($tuple->getTerms());
        $this->assertInstanceOf(StringTerm::class, $tuple->getTerms()[0]);
        $this->assertEquals('Hallo Welt ("Hello World")', $tuple->getString(0));
    }

    /**
     * Tests tuple string serialization.
     */
    public function testSerialize()
    {
        $tuple = new GenericTuple('test-frame');
        $this->assertEquals('(test-frame )', $this->serializer->serialize($tuple));
        $this->assertEquals('(test-frame )', $tuple->toString($this->context));
        $this->assertEquals('(test-frame )', $tuple->__toString());

        $tuple = new GenericTuple('frame');
        $tuple->setNull('key');
        $this->assertEquals('(frame :key null)', $tuple->toString($this->context));
        $this->assertEquals('(frame :key null)', $tuple->__toString());

        $tuple = new GenericTuple('frame');
        $tuple->setBool('key', true);
        $this->assertEquals('(frame :key true)', $tuple->toString($this->context));
        $this->assertEquals('(frame :key true)', $tuple->__toString());

        $tuple = new GenericTuple('frame');
        $tuple->setBool('key', false);
        $this->assertEquals('(frame :key false)', $tuple->toString($this->context));
        $this->assertEquals('(frame :key false)', $tuple->__toString());

        $tuple = new GenericTuple('frame');
        $tuple->setInt('key', 42);
        $this->assertEquals('(frame :key 42)', $tuple->toString($this->context));
        $this->assertEquals('(frame :key 42)', $tuple->__toString());

        $tuple = new GenericTuple('frame');
        $tuple->setFloat('key', 1337.24);
        $this->assertEquals('(frame :key 1337.24)', $tuple->toString($this->context));
        $this->assertEquals('(frame :key 1337.24)', $tuple->__toString());

        $tuple = new GenericTuple('frame');
        $tuple->setString('key', "string");
        $this->assertEquals('(frame :key string)', $tuple->toString($this->context));
        $this->assertEquals('(frame :key string)', $tuple->__toString());

        $tuple = new GenericTuple('frame1');
        $tuple->setParameter('key', new GenericTuple('frame2'));
        $this->assertEquals('(frame1 :key (frame2 ))', $tuple->toString($this->context));
        $this->assertEquals('(frame1 :key (frame2 ))', $tuple->__toString());

        $tuple = new GenericTuple('frame1');
        $tuple->addTerm(new GenericTuple('frame2'));
        $this->assertEquals('(frame1 (frame2 ))', $tuple->toString($this->context));
        $this->assertEquals('(frame1 (frame2 ))', $tuple->__toString());

        $tuple = new GenericTuple('frame1');
        $tuple->addTerm(new GenericTuple('frame2'));
        $tuple->addTerm(new GenericTuple('frame3'));
        $this->assertEquals('(frame1 (frame2 ) (frame3 ))', $tuple->toString($this->context));
        $this->assertEquals('(frame1 (frame2 ) (frame3 ))', $tuple->__toString());

        $tuple = new GenericTuple('frame1');
        $tuple->setParameter('key', new GenericTuple('frame2'));
        $tuple->setParameter('key', new GenericTuple('frame3'));
        $this->assertEquals('(frame1 :key (frame3 ))', $tuple->toString($this->context));
        $this->assertEquals('(frame1 :key (frame3 ))', $tuple->__toString());

        $tuple = new GenericTuple('test-frame');
        $tuple->addTerm(new StringTerm('Hallo Welt ("Hello World")'));
        $this->assertEquals('(test-frame "Hallo Welt \(\"Hello World\"\)")', $tuple->toString($this->context));
    }
}
