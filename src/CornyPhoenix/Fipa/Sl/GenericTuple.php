<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Context\DefaultTupleContext;
use CornyPhoenix\Fipa\Sl\Context\TupleContext;
use CornyPhoenix\Fipa\Sl\Registry\DefaultTupleRegistry;
use CornyPhoenix\Fipa\Sl\Serializer\DefaultTupleSerializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
class GenericTuple extends AbstractTuple
{

    /**
     * @return string
     */
    final public function __toString()
    {
        return $this->toString(DefaultTupleContext::getInstance());
    }

    /**
     * @param string $string
     * @param TupleContext $context
     * @return $this
     */
    public function fromString($string, TupleContext $context)
    {
        $serializer = new DefaultTupleSerializer($context, new DefaultTupleRegistry());
        return $serializer->unserialize($string, $this);
    }
}
