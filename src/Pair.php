<?php

declare(strict_types=1);

namespace PhpDs;

use InvalidArgumentException;

/**
 * Represents a key-value pair.
 */
final class Pair
{
    private const EMPTY_ARRAY_MSG = "A key value pair can not be created from an empty array.";

    private const SHOULD_USE_TUPLE_MSG = "An array with 2 values can not be used with this method.  Did you mean to use " . self::class . "::fromTuple?";

    private const SHOULD_USE_ARRAY_MSG = "A single key-value array can not be used with this method.  Did you mean to use " . self::class . "::fromArray?";

    private const TOO_MANY_VALUES_MSG = "Too many values in the provided array.";

    public function __construct(private string|int|bool|float|null|object $key, private string|int|bool|float|null|object $value)
    {
    }

    /**
     * Use this method to create a pair using a single key-value.
     * 
     * ```
     * $pair = Pair::fromSingleValueAssocArray(["key" => 10e9]);
     * ```
     */
    public static function fromSingleValueAssocArray(array $pair): self
    {
        return match (count($pair)) {

            0 => throw new InvalidArgumentException(self::EMPTY_ARRAY_MSG),

            1 => new self(key($pair), current($pair)),

            2 => throw new InvalidArgumentException(self::SHOULD_USE_TUPLE_MSG),

            default => throw new InvalidArgumentException(self::TOO_MANY_VALUES_MSG)

        };
    }

    /**
     * Use this method to create a pair from a 2 value array.
     * 
     * ```
     * $pair = Pair::fromTuple(["key", "value"]);
     * ```
     */
    public static function fromTuple(array $tuple): self
    {
        return match (count($tuple)) {

            0 => throw new InvalidArgumentException(self::EMPTY_ARRAY_MSG),

            1 => throw new InvalidArgumentException(self::SHOULD_USE_ARRAY_MSG),

            2 => new self($tuple[0], $tuple[1]),

            default => new InvalidArgumentException(self::TOO_MANY_VALUES_MSG)

        };
    }

    /**
     * Returns the key for this pair.
     */
    public function getKey(): string|int|bool|float|null|object
    {
        return $this->key;
    }

    /**
     * Returns the value for this pair.
     */
    public function getValue(): string|int|bool|float|null|object
    {
        return $this->value;
    }
}
