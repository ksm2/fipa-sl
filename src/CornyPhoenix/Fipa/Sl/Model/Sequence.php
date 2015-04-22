<?php

namespace CornyPhoenix\Fipa\Sl\Model;

use CornyPhoenix\Fipa\Sl\Exception\SequenceException;
use CornyPhoenix\Fipa\Sl\GenericTuple;
use CornyPhoenix\Fipa\Sl\Term;

/**
 * @package CornyPhoenix\Fipa\Sl\Model
 * @author moellers
 */
class Sequence extends GenericTuple
{

    const FRAME = 'sequence';

    /**
     * Done constructor.
     */
    public function __construct()
    {
        parent::__construct(static::FRAME);
    }

    public function setParameter($key, Term $parameter)
    {
        throw new SequenceException('Sequence may not contain keys!');
    }
}
