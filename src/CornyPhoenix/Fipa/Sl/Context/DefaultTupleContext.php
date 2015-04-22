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
    private $string;

    /**
     * DefaultTupleContext constructor.
     */
    public function __construct()
    {
        $this->opening = preg_quote($this->getOpeningDelimiter());
        $this->closing = preg_quote($this->getClosingDelimiter());
        $this->string = preg_quote($this->getStringDelimiter());
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

    /**
     * Encodes a string to an SL string.
     *
     * @param string $string
     * @return string
     */
    public function encode($string)
    {
        if (!$string) {
            return '';
        }

        $lower = strtolower($string);
        if ($lower === 'null' || $lower === 'false' || $lower === 'true') {
            return sprintf('%2$s%1$s%2$s', $string, $this->getStringDelimiter());
        }

        $containsWhitespace = boolval(preg_match('/\s/', $string));

        // Escape special chars.
        $pattern = sprintf('/[%s%s%s]/', $this->opening, $this->closing, $this->string);
        $string = preg_replace($pattern, '\\\\$0', $string);

        // Wrap with string delimiter if needed.
        if ($containsWhitespace) {
            return $this->getStringDelimiter() . $string . $this->getStringDelimiter();
        }

        return $string;
    }

    /**
     * Decodes an SL string.
     *
     * @param string $string
     * @return string
     */
    public function decode($string)
    {
        if (!$string) {
            return '';
        }

        $len = strlen($string);
        if ($string[0] === $this->getStringDelimiter() && $string[$len - 1] === $this->getStringDelimiter()) {
            $string = substr($string, 1, $len - 2);
        }

        // Unescape special chars.
        $pattern = sprintf('/\\\\([%s%s%s])/', $this->opening, $this->closing, $this->string);
        $string = preg_replace($pattern, '$1', $string);

        return $string;
    }

    /**
     * @param string $string
     * @param int $offset
     * @return int
     */
    public function findEndOfString($string, $offset)
    {
        $quoted = $string[$offset] === $this->getStringDelimiter();

        if ($quoted) {
            $offset++;
        }

        for (; $offset < strlen($string); $offset++) {
            $c = $string[$offset];

            // Skip next char if found escape char.
            if ($c === '\\') {
                $offset++;
                continue;
            }

            if ($quoted) {
                // Break on ending delimiter if quoted.
                if ($c === $this->getStringDelimiter()) {
                    return $offset + 1;
                }
            } else {
                // Break on parenthesis if not quoted.
                if (preg_match(sprintf('/[%s%s]/', $this->opening, $this->closing), $c)) {
                    break;
                }

                // Break on whitespace if not quoted.
                if (trim($c) === '') {
                    break;
                }
            }
        }

        return $offset;
    }
}
