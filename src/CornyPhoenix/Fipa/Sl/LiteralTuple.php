<?php

namespace CornyPhoenix\Fipa\Sl;

/**
 * @package CornyPhoenix\Fipa\Sl
 * @author moellers
 */
interface LiteralTuple extends Tuple
{

    /**
     * @param bool $bool
     * @return $this
     */
    public function addBool($bool);

    /**
     * @param string $key
     * @param bool|null $default
     * @return bool|null
     */
    public function getBool($key, $default = null);

    /**
     * @param string $key
     * @param bool $bool
     * @return $this
     */
    public function setBool($key, $bool);

    /**
     * @param int $int
     * @return $this
     */
    public function addInt($int);

    /**
     * @param string $key
     * @param int|null $default
     * @return int|null
     */
    public function getInt($key, $default = null);

    /**
     * @param string $key
     * @param int $int
     * @return $this
     */
    public function setInt($key, $int);

    /**
     * @param float $float
     * @return $this
     */
    public function addFloat($float);

    /**
     * @param string $key
     * @param float|null $default
     * @return float|null
     */
    public function getFloat($key, $default = null);

    /**
     * @param string $key
     * @param float $float
     * @return $this
     */
    public function setFloat($key, $float);

    /**
     * @param string $string
     * @return $this
     */
    public function addString($string);

    /**
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
    public function getString($key, $default = null);

    /**
     * @param string $key
     * @param string $string
     * @return $this
     */
    public function setString($key, $string);

    /**
     * @return $this
     */
    public function addNull();

    /**
     * @param string $key
     * @return bool
     */
    public function isNull($key);

    /**
     * @param string $key
     * @return $this
     */
    public function setNull($key);
}
