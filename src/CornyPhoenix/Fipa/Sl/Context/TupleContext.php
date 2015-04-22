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
}
