<?php

namespace CornyPhoenix\Fipa\Sl\Context;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
interface TupleContext
{

    /**
     * @return string
     */
    public function getOpeningDelimiter();

    /**
     * @return string
     */
    public function getOpeningDelimiterRegEx();

    /**
     * @return string
     */
    public function getClosingDelimiter();

    /**
     * @return string
     */
    public function getClosingDelimiterRegEx();

    /**
     * @return string
     */
    public function getFrameRegEx();

    /**
     * @return string
     */
    public function getKeyDelimiter();

    /**
     * @return string
     */
    public function getTermSeparator();

    /**
     * @return string
     */
    public function getFrameSeparator();

    /**
     * @return string
     */
    public function getKeySeparator();

    /**
     * @return string
     */
    public function getStringDelimiter();

    /**
     * Encodes a string to an SL string.
     *
     * @param string $string
     * @return string
     */
    public function encode($string);

    /**
     * Decodes an SL string.
     *
     * @param string $string
     * @return string
     */
    public function decode($string);

    /**
     * @param string $string
     * @param int $offset
     * @return int
     */
    public function findEndOfString($string, $offset);
}
