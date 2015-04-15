<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Context\TupleContext;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
interface Term
{

    /**
     * @param TupleContext $context
     * @return string
     */
    public function toString(TupleContext $context);

    /**
     * @param string $string
     * @param TupleContext $context
     * @return $this
     */
    public function fromString($string, TupleContext $context);
}
