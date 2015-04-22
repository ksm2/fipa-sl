<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Context\TupleContext;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class IntegerTerm extends LiteralTerm
{

    /**
     * @param string $string
     * @param TupleContext $context
     * @return int|null
     */
    protected function parseString($string, TupleContext $context)
    {
        if ('null' === $string) {
            return null;
        }

        return intval($string);
    }
}
