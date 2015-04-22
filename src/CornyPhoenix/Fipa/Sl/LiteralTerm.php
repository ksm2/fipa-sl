<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Context\DefaultTupleContext;
use CornyPhoenix\Fipa\Sl\Context\TupleContext;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
abstract class LiteralTerm implements Term
{
    const SL_NULL = 'null';
    const SL_TRUE = 'true';
    const SL_FALSE = 'false';

    /**
     * @var string|int|float|bool|null
     */
    private $value;

    /**
     * LiteralTerm constructor.
     * @param string|int|float|bool|null $value
     */
    public function __construct($value = null)
    {
        $this->setValue($value);
    }

    /**
     * @return string|int|float|bool|null
     */
    final public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string|int|float|bool|null $value
     * @return $this
     */
    final public function setValue($value)
    {
        if (null === $value) {
            $this->value = null;
            return $this;
        }

        $this->value = $this->parseString($value, DefaultTupleContext::getInstance());
        return $this;
    }

    /**
     * @param TupleContext $context
     * @return string
     */
    final public function toString(TupleContext $context)
    {
        if (null === $this->value) {
            return self::SL_NULL;
        }

        if (true === $this->value) {
            return self::SL_TRUE;
        }

        if (false === $this->value) {
            return self::SL_FALSE;
        }

        if (is_string($this->value)) {
            return $context->encode($this->value);
        }

        return strval($this->value);
    }

    /**
     * @param string $string
     * @param TupleContext $context
     * @return $this
     */
    final public function fromString($string, TupleContext $context)
    {
        $this->value = $this->parseString($string, $context);
        return $this;
    }

    /**
     * @param string $string
     * @param TupleContext $context
     * @return bool|float|int|null|string
     */
    abstract protected function parseString($string, TupleContext $context);
}
