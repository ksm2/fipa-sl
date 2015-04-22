<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Context\TupleContext;

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
     * @param TupleContext $context
     * @return bool|float|int|null|string
     */
    final protected function parseString($string, TupleContext $context)
    {
        return null;
    }
}
