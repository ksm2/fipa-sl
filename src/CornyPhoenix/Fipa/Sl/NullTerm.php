<?php

namespace CornyPhoenix\Fipa\Sl;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class NullTerm extends LiteralTerm
{

    /**
     * NullTerm constructor.
     */
    final public function __construct()
    {
        parent::__construct(null);
    }

    /**
     * @param string $string
     * @return string|int|float|bool|null
     */
    final protected function parseString($string)
    {
        return null;
    }
}
