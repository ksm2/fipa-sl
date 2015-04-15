<?php

namespace CornyPhoenix\Fipa\Sl;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class BoolTerm extends LiteralTerm
{

    /**
     * @param string $string
     * @return bool|null
     */
    protected function parseString($string)
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
