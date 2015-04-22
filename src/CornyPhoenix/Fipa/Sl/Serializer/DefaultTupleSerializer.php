<?php

namespace CornyPhoenix\Fipa\Sl\Serializer;

use CornyPhoenix\Fipa\Sl\Context\TupleContext;
use CornyPhoenix\Fipa\Sl\Exception\ParsingException;
use CornyPhoenix\Fipa\Sl\FloatTerm;
use CornyPhoenix\Fipa\Sl\GenericTuple;
use CornyPhoenix\Fipa\Sl\IntegerTerm;
use CornyPhoenix\Fipa\Sl\LiteralTerm;
use CornyPhoenix\Fipa\Sl\Registry\TupleRegistry;
use CornyPhoenix\Fipa\Sl\StringTerm;
use CornyPhoenix\Fipa\Sl\Term;
use CornyPhoenix\Fipa\Sl\Tuple;

/**
 * @package CornyPhoenix\Fipa\Sl\Context
 * @author moellers
 */
class DefaultTupleSerializer implements TupleSerializer
{

    /**
     * @var TupleContext
     */
    private $context;

    /**
     * @var TupleRegistry
     */
    private $registry;

    /**
     * DefaultTupleSerializer constructor.
     *
     * @param TupleContext $context
     * @param TupleRegistry $registry
     */
    public function __construct(TupleContext $context, TupleRegistry $registry)
    {
        $this->context = $context;
        $this->registry = $registry;
    }

    /**
     * Serializes a tuple.
     *
     * @param Term $term
     * @return string
     */
    public function serialize(Term $term)
    {
        return $term->toString($this->context);
    }

    /**
     * Unserializes data and returns a tuple.
     *
     * @param string $string
     * @param Term|null $target
     * @return Term
     * @throws ParsingException
     */
    public function unserialize($string, Term $target = null)
    {
        $string = trim($string);

        // Parse Literal terms.
        if ($target instanceof LiteralTerm) {
            return $target->fromString($string, $this->context);
        }

        // Match frame and content of tuple.
        list(, $frame, $content) = $this->matchTupleString($string);

        // Create tuple object if not exists.
        $target = $this->createTuple($target, $frame);

        if ($target instanceof Tuple) {
            // Check frame equality.
            if ($target->getFrame() !== $frame) {
                throw new ParsingException('Invalid frame found: ' . $frame);
            }

            // Parse content if not empty.
            if (!empty($content)) {
                $this->unserializeContent($target, $content);
            }
        }

        return $target;
    }

    /**
     * @param Tuple $target
     * @param string $content
     */
    private function unserializeContent(Tuple $target, $content)
    {
        $offset = 0;
        $key = null;
        while ($offset < strlen($content)) {
            $char = $content[$offset];
            switch ($char) {
                // Skip whitespaces.
                case " ":
                case "\t":
                case "\n":
                case "\r":
                case "\0":
                case "\x0B":
                    $offset++;
                    break;

                // Found a nested tuple.
                case $this->context->getOpeningDelimiter():
                    $level = 0;
                    for ($pos = $offset; $pos < strlen($content); $pos++) {
                        if ($content[$pos] === $this->context->getOpeningDelimiter()) {
                            $level++;
                        } elseif ($content[$pos] === $this->context->getClosingDelimiter()) {
                            $level--;
                        }

                        if ($level == 0) {
                            break;
                        }
                    }
                    $this->foundNestedTuple($target, $content, $offset, $pos, $key);
                    $offset = $pos + 1;
                    $key = null;
                    break;

                // Found a key.
                case $this->context->getKeyDelimiter():
                    $offset++;
                    preg_match('/(' . $this->context->getFrameRegEx() . '+)\s+/', $content, $matches, 0, $offset);
                    list($all, $key) = $matches;
                    $offset += strlen($all);
                    break;

                // Found a number.
                case "0":
                case "1":
                case "2":
                case "3":
                case "4":
                case "5":
                case "6":
                case "7":
                case "8":
                case "9":
                case "-":
                case ".":
                    if (preg_match('/(-?(\d+(\.\d*)?|\.\d+))/', $content, $matches, 0, $offset)) {
                        list(, $number) = $matches;
                        if (strpos($number, '.') !== false) {
                            $type = new FloatTerm();
                        } else {
                            $type = new IntegerTerm();
                        }
                        $type->fromString($number, $this->context);
                        $this->addTermToTuple($target, $type, $key);
                        $offset += strlen($number);
                        break;
                    }
                    $offset++;
                    break;

                // Found a string.
                case $this->context->getStringDelimiter():
                default:
                    $pos = $this->context->findEndOfString($content, $offset);
                    $this->foundNestedTuple($target, $content, $offset, $pos, $key, new StringTerm());
                    $offset = $pos + 1;
                    $key = null;
                    break;
            }
        }
    }

    /**
     * @param Term $target
     * @param string $content
     * @param int $startsAt
     * @param int $endsAt
     * @param string|null $key
     * @param Term $nestedTarget
     * @throws ParsingException
     */
    private function foundNestedTuple(Term $target, $content, $startsAt, $endsAt, $key, Term $nestedTarget = null)
    {
        $nestedTupleString = substr($content, $startsAt, $endsAt - $startsAt + 1);
        $nestedTuple = $this->unserialize($nestedTupleString, $nestedTarget);
        if ($target instanceof Tuple) {
            $this->addTermToTuple($target, $nestedTuple, $key);
        }
    }

    /**
     * @param Tuple $target
     * @param Term $nestedTerm
     * @param string|null $key
     */
    private function addTermToTuple(Tuple $target, Term $nestedTerm, $key)
    {
        if (null !== $key) {
            $target->setParameter($key, $nestedTerm);
        } else {
            $target->addTerm($nestedTerm);
        }
    }

    /**
     * @param Term|null $target
     * @param string $frame
     * @return Term|Tuple
     */
    private function createTuple(Term $target = null, $frame)
    {
        if (null === $target) {
            $target = $this->registry->createTuple($frame);
            if (null === $target) {
                $target = new GenericTuple($frame);
                return $target;
            }
            return $target;
        }

        return $target;
    }

    /**
     * @param string $string
     * @return array
     * @throws ParsingException
     */
    private function matchTupleString($string)
    {
        // Get delimiter regex.
        $opening = $this->context->getOpeningDelimiterRegEx();
        $closing = $this->context->getClosingDelimiterRegEx();
        $frameRegEx = $this->context->getFrameRegEx();

        if (!preg_match(sprintf('/^%s\s*(%s+)\s+(.*)%s$/', $opening, $frameRegEx, $closing), $string, $matches)) {
            throw new ParsingException('Could not parse: ' . $string);
        }

        return $matches;
    }
}
