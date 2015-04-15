<?php

namespace CornyPhoenix\Fipa\Sl;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class StringTerm extends LiteralTerm
{

    /**
     * @param string $string
     * @return string|null
     */
    protected function parseString($string)
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

        if ($string[0] === '"' && $string[0] === $string[strlen($string) - 1]) {
            return substr($string, 1, strlen($string) - 2);
        }

        return strval($string);
    }
}
