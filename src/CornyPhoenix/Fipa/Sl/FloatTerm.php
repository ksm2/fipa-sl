<?php

namespace CornyPhoenix\Fipa\Sl;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class FloatTerm extends LiteralTerm
{

    /**
     * @param string $string
     * @return float|null
     */
    protected function parseString($string)
    {
        if ('null' === $string) {
            return null;
        }

        return floatval($string);
    }
}
