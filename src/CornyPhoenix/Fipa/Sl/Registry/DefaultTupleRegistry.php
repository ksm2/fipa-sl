<?php

namespace CornyPhoenix\Fipa\Sl\Registry;

use CornyPhoenix\Fipa\Sl\Tuple;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @package CornyPhoenix\Fipa\Sl\Context
 * @author moellers
 */
class DefaultTupleRegistry implements TupleRegistry
{

    /**
     * @var Collection
     */
    private $tupleRegistry;

    /**
     * DefaultTupleRegistry constructor.
     */
    public function __construct()
    {
        $this->tupleRegistry = new ArrayCollection();
    }

    /**
     * Registers a frame to the context.
     *
     * @param Tuple $prototype tuple prototype to register
     * @return void
     */
    public function registerTuple(Tuple $prototype)
    {
        $this->tupleRegistry->set($prototype->getFrame(), get_class($prototype));
    }

    /**
     * Unregisters a frame from the context.
     *
     * @param Tuple $prototype tuple prototype to unregister
     * @return bool <code>false</code>, if not successful
     */
    public function unregisterTuple(Tuple $prototype)
    {
        return null !== $this->tupleRegistry->remove($prototype->getFrame());
    }

    /**
     * Creates a tuple by its frame.
     *
     * @param string $frame tuple to look for
     * @return Tuple|null new tuple instance
     */
    public function createTuple($frame)
    {
        $class = $this->tupleRegistry->get($frame);

        if (null === $class) {
            return null;
        }

        return new $class;
    }

    /**
     * Returns whether a frame is known.
     *
     * @param string $frame
     * @return bool
     */
    public function knowsFrame($frame)
    {
        return $this->tupleRegistry->containsKey($frame);
    }
}
