<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Context\TupleContext;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class BoolTerm extends LiteralTerm
{

    /**
     * @param string $string
     * @param TupleContext $context
     * @return bool|null
     */
    protected function parseString($string, TupleContext $context)
    {
        if ('null' === $string) {
            return null;
        }

        if (true === $string) {
            return true;
        }

        if (false === $string) {
            return false;
        }

        return 'true' === $string ? true : false;
    }
}
