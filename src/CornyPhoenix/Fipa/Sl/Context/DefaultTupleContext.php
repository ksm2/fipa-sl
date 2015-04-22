<?php

namespace CornyPhoenix\Fipa\Sl\Context;

/**
 * @package CornyPhoenix\Fipa\Sl\Context
 * @author moellers
 */
class DefaultTupleContext implements TupleContext
{

    const OPENING_DELIMITER = '(';
    const CLOSING_DELIMITER = ')';
    const KEY_DELIMITER = ':';
    const TERM_SEPARATOR = ' ';
    const KEY_SEPARATOR = ' ';
    const FRAME_SEPARATOR = ' ';
    const STRING_DELIMITER = '"';
    const FRAME_REG_EX = '[\w-]';

    private static $instance = null;

    private $opening;
    private $closing;

    /**
     * DefaultTupleContext constructor.
     */
    public function __construct()
    {
        $this->opening = preg_quote($this->getOpeningDelimiter());
        $this->closing = preg_quote($this->getClosingDelimiter());
    }

    /**
     * @return DefaultTupleContext
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return string
     */
    public function getOpeningDelimiter()
    {
        return self::OPENING_DELIMITER;
    }

    /**
     * @return string
     */
    public function getClosingDelimiter()
    {
        return self::CLOSING_DELIMITER;
    }

    /**
     * @return string
     */
    public function getKeyDelimiter()
    {
        return self::KEY_DELIMITER;
    }

    /**
     * @return string
     */
    public function getTermSeparator()
    {
        return self::TERM_SEPARATOR;
    }

    /**
     * @return string
     */
    public function getFrameSeparator()
    {
        return self::FRAME_SEPARATOR;
    }

    /**
     * @return string
     */
    public function getKeySeparator()
    {
        return self::KEY_SEPARATOR;
    }

    /**
     * @return string
     */
    public function getStringDelimiter()
    {
        return self::STRING_DELIMITER;
    }

    /**
     * @return string
     */
    public function getOpeningDelimiterRegEx()
    {
        return $this->opening;
    }

    /**
     * @return string
     */
    public function getClosingDelimiterRegEx()
    {
        return $this->closing;
    }

    /**
     * @return string
     */
    public function getFrameRegEx()
    {
        return self::FRAME_REG_EX;
    }
}
