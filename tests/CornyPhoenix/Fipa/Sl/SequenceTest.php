<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Model\Sequence;
use CornyPhoenix\Fipa\Sl\Model\Set;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class SequenceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \CornyPhoenix\Fipa\Sl\Exception\SequenceException
     */
    public function testSettingKeysThrowsException()
    {
        $sequence = new Sequence();
        $sequence->setNull('forbidden');
    }

    public function testSetForbidsDuplicates()
    {
        $set = new Set();
        $this->assertEmpty($set->getTerms());
        $set->addString('Hallo Welt');
        $this->assertCount(1, $set->getTerms());
        $set->addString('Hallo Welt');
        $this->assertCount(1, $set->getTerms());

        $tuple = new GenericTuple('more-complicated');
        $tuple->setString('world', 'hello');
        $set->addTerm($tuple);
        $this->assertCount(2, $set->getTerms());
        $set->addTerm($tuple);
        $this->assertCount(2, $set->getTerms());
    }
}
