<?php

namespace CornyPhoenix\Fipa\Sl\Model;

use CornyPhoenix\Fipa\Sl\GenericTuple;

/**
 * @package CornyPhoenix\Fipa\Sl\Model
 * @author moellers
 */
class Done extends GenericTuple
{

    const FRAME = 'done';

    /**
     * Done constructor.
     */
    public function __construct()
    {
        parent::__construct(self::FRAME);
    }
}
