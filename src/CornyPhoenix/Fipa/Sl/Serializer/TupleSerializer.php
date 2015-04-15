<?php

namespace CornyPhoenix\Fipa\Sl\Serializer;

use CornyPhoenix\Fipa\Sl\Term;

/**
 * @package CornyPhoenix\Fipa\Sl\Context
 * @author moellers
 */
interface TupleSerializer
{

    /**
     * Serializes a tuple.
     *
     * @param Term $term
     * @return string
     */
    public function serialize(Term $term);

    /**
     * Unserializes data and returns a tuple.
     *
     * @param string $string
     * @param Term|null $target
     * @return Term
     */
    public function unserialize($string, Term $target = null);
}
