<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Context\TupleContext;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class StringTerm extends LiteralTerm
{

    /**
     * @param string $string
     * @param Context\TupleContext|TupleContext $context
     * @return null|string
     */
    protected function parseString($string, TupleContext $context)
    {
        if ('null' === $string) {
            return null;
        }

        if (true === $string) {
            return self::SL_TRUE;
        }

        if (false === $string) {
            return self::SL_FALSE;
        }

        return $context->decode($string);
    }
}
