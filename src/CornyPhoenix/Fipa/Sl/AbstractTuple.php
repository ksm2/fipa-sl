<?php

namespace CornyPhoenix\Fipa\Sl;

use CornyPhoenix\Fipa\Sl\Context\DefaultTupleContext;
use CornyPhoenix\Fipa\Sl\Context\TupleContext;
use CornyPhoenix\Fipa\Sl\Exception\FrameMustNotBeEmptyException;
use CornyPhoenix\Fipa\Sl\Exception\ParsingException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
abstract class AbstractTuple implements LiteralTuple
{

    /**
     * @var string
     */
    private $frame;

    /**
     * @var Collection
     */
    private $collection;

    /**
     * @param string $frame
     * @param Term[] $terms
     */
    public function __construct($frame, array $terms = array())
    {
        $this->collection = new ArrayCollection($terms);
        $this->setFrame($frame);
    }

    /**
     * @param Term $term
     * @return $this
     */
    public function addTerm(Term $term)
    {
        $this->collection->add($term);
        return $this;
    }

    /**
     * @param Term $term
     * @return $this
     */
    public function removeTerm(Term $term)
    {
        $this->collection->removeElement($term);
        return $this;
    }

    /**
     * @return Term[]
     */
    public function getTerms()
    {
        return $this->collection->toArray();
    }

    /**
     * @param string $key
     * @param null|Term $default
     * @return null|Term
     */
    public function getParameter($key, Term $default = null)
    {
        if (!$this->hasParameter($key)) {
            return $default;
        }

        return $this->collection->get($key);
    }

    /**
     * @param string $key
     * @param Term $parameter
     * @return $this
     */
    public function setParameter($key, Term $parameter)
    {
        $this->collection->set($key, $parameter);
        return $this;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function removeParameter($key)
    {
        $this->collection->remove($key);
        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasParameter($key)
    {
        return $this->collection->containsKey($key);
    }

    /**
     * @param Term $term
     * @return bool
     */
    public function containsTerm(Term $term)
    {
        return $this->collection->contains($term);
    }

    /**
     * @param TupleContext $context
     * @return string
     */
    public function toString(TupleContext $context)
    {
        return sprintf(
            $this->createTupleFormat($context),
            $this->getFrame(),
            $this->toContentString($context)
        );
    }

    /**
     * @return string
     */
    final public function getFrame()
    {
        return $this->frame;
    }

    /**
     * @param string $frame
     * @return $this
     * @throws FrameMustNotBeEmptyException
     */
    final protected function setFrame($frame)
    {
        $this->frame = strval($frame);

        if (empty($this->frame)) {
            throw new FrameMustNotBeEmptyException('Frame cannot be empty');
        }

        return $this;
    }

    /**
     * @param string $key
     * @param bool|null $default
     * @return bool|null
     */
    public function getBool($key, $default = null)
    {
        $term = $this->getParameter($key);

        if ($term instanceof BoolTerm) {
            return $term->getValue();
        }

        return $default;
    }

    /**
     * @param string $key
     * @param bool $bool
     * @return $this
     */
    public function setBool($key, $bool)
    {
        return $this->setParameter($key, new BoolTerm($bool));
    }

    /**
     * @param string $key
     * @param int|null $default
     * @return int|null
     */
    public function getInt($key, $default = null)
    {
        $term = $this->getParameter($key);

        if ($term instanceof IntegerTerm) {
            return $term->getValue();
        }

        return $default;
    }

    /**
     * @param string $key
     * @param int $int
     * @return $this
     */
    public function setInt($key, $int)
    {
        return $this->setParameter($key, new IntegerTerm($int));
    }

    /**
     * @param string $key
     * @param float|null $default
     * @return float|null
     */
    public function getFloat($key, $default = null)
    {
        $term = $this->getParameter($key);

        if ($term instanceof FloatTerm) {
            return $term->getValue();
        }

        return $default;
    }

    /**
     * @param string $key
     * @param float $float
     * @return $this
     */
    public function setFloat($key, $float)
    {
        return $this->setParameter($key, new FloatTerm($float));
    }

    /**
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
    public function getString($key, $default = null)
    {
        $term = $this->getParameter($key);

        if ($term instanceof StringTerm) {
            return $term->getValue();
        }

        return $default;
    }

    /**
     * @param string $key
     * @param string $string
     * @return $this
     */
    public function setString($key, $string)
    {
        return $this->setParameter($key, new StringTerm($string));
    }

    /**
     * @param string $key
     * @return bool
     */
    public function isNull($key)
    {
        if (!$this->hasParameter($key)) {
            return false;
        }

        $term = $this->collection->get($key);

        if (!$term instanceof LiteralTerm) {
            return false;
        }

        return null === $term->getValue();
    }

    /**
     * @param string $key
     * @return $this
     */
    public function setNull($key)
    {
        $this->setParameter($key, new NullTerm());
    }

    /**
     * @param TupleContext $context
     * @return string
     */
    protected function toContentString(TupleContext $context)
    {
        $terms = array_map(function ($key, Term $term) use ($context) {
            if (is_string($key)) {
                return $context->getKeyDelimiter() . $key . $context->getKeySeparator() . $term->toString($context);
            }

            return $term->toString($context);
        }, $this->collection->getKeys(), $this->collection->getValues());

        return implode($context->getTermSeparator(), $terms);
    }

    /**
     * @param TupleContext $context
     * @return string
     */
    private function createTupleFormat(TupleContext $context)
    {
        return
            $context->getOpeningDelimiter() .
            '%s' .
            $context->getFrameSeparator() .
            '%s' .
            $context->getClosingDelimiter();
    }
}
