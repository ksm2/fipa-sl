<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Model\Done;
use CornyPhoenix\Fipa\Sl\Registry\DefaultTupleRegistry;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class DefaultTupleRegistryTest extends \PHPUnit_Framework_TestCase
{

    public function testRegister()
    {
        $registry = new DefaultTupleRegistry();

        $this->assertFalse($registry->knowsFrame(Done::FRAME));
        $registry->registerTuple(new Done());
        $this->assertTrue($registry->knowsFrame(Done::FRAME));
        $registry->unregisterTuple(new Done());
        $this->assertFalse($registry->knowsFrame(Done::FRAME));
    }

    public function testCreateTuple()
    {
        $registry = new DefaultTupleRegistry();

        $registry->registerTuple(new Done());
        $this->assertTrue($registry->knowsFrame(Done::FRAME));

        $tuple = $registry->createTuple(Done::FRAME);
        $this->assertNotNull($tuple);
        $this->assertInstanceOf(Done::class, $tuple);

        $this->assertFalse($registry->knowsFrame('unknown'));
        $tuple = $registry->createTuple('unknown');
        $this->assertNull($tuple);
    }
}
