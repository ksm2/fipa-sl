<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Context\TupleContext;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class FloatTerm extends LiteralTerm
{

    /**
     * @param string $string
     * @param Context\TupleContext|TupleContext $context
     * @return float|null
     */
    protected function parseString($string, TupleContext $context)
    {
        if ('null' === $string) {
            return null;
        }

        return floatval($string);
    }
}
