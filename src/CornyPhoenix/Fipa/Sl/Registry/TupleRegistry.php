<?php

namespace CornyPhoenix\Fipa\Sl\Registry;

use CornyPhoenix\Fipa\Sl\Tuple;

/**
 * @package CornyPhoenix\Fipa\Sl\Context
 * @author moellers
 */
interface TupleRegistry
{

    /**
     * Registers a frame to the context.
     *
     * @param Tuple $prototype tuple prototype to register
     * @return void
     */
    public function registerTuple(Tuple $prototype);

    /**
     * Unregisters a frame from the context.
     *
     * @param Tuple $prototype tuple prototype to unregister
     * @return bool <code>false</code>, if not successful
     */
    public function unregisterTuple(Tuple $prototype);

    /**
     * Creates a tuple by its frame.
     *
     * @param string $frame tuple to look for
     * @return Tuple|null new tuple instance
     */
    public function createTuple($frame);

    /**
     * Returns whether a frame is known.
     *
     * @param string $frame
     * @return bool
     */
    public function knowsFrame($frame);
}
