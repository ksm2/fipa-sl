<?php

namespace CornyPhoenix\Fipa\Sl\Model;

use CornyPhoenix\Fipa\Sl\Context\DefaultTupleContext;
use CornyPhoenix\Fipa\Sl\Term;

/**
 * @package CornyPhoenix\Fipa\Sl\Model
 * @author moellers
 */
class Set extends Sequence
{

    const FRAME = 'set';

    private $hashes = array();

    public function addTerm(Term $term)
    {
        $serialized = $term->toString(DefaultTupleContext::getInstance());
        if (in_array($serialized, $this->hashes)) {
            return $this;
        }

        $this->hashes[] = $serialized;
        return parent::addTerm($term);
    }
}
