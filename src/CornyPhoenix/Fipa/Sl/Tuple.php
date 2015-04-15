<?php

namespace CornyPhoenix\Fipa\Sl;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
interface Tuple extends Term
{

    /**
     * Returns the frame of the tuple.
     *
     * @return string
     */
    public function getFrame();

    /**
     * @param Term $term
     * @return $this
     */
    public function addTerm(Term $term);

    /**
     * @param Term $term
     * @return $this
     */
    public function removeTerm(Term $term);

    /**
     * @return Term[]
     */
    public function getTerms();

    /**
     * @param string $key
     * @param null|Term $default
     * @return null|Term
     */
    public function getParameter($key, Term $default = null);

    /**
     * @param string $key
     * @param Term $parameter
     * @return $this
     */
    public function setParameter($key, Term $parameter);

    /**
     * @param string $key
     * @return $this
     */
    public function removeParameter($key);

    /**
     * @param string $key
     * @return bool
     */
    public function hasParameter($key);

    /**
     * @param Term $term
     * @return bool
     */
    public function containsTerm(Term $term);
}
