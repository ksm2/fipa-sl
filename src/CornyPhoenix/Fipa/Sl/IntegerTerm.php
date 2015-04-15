<?php

namespace CornyPhoenix\Fipa\Sl;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class IntegerTerm extends LiteralTerm
{

    /**
     * @param string $string
     * @return int|null
     */
    protected function parseString($string)
    {
        if ('null' === $string) {
            return null;
        }

        return intval($string);
    }
}
