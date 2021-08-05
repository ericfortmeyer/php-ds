<?php

namespace PhpDs;

use InvalidArgumentException;

final class Pair
{
    private string|int|bool|float|object $key;

    private string|int|bool|float|object $value;

    /**
     * Create the pair using an array with a single element
     *
     * @param array<string|int|bool|float|object,string|int|bool|float|object> $pair
     */
    public function __construct(array $pair)
    {
        if (empty($pair)) {
            throw new InvalidArgumentException("A key value pair can not be created from an empty array.");
        }
        $this->key = key($pair);
        $this->value = current($pair);
    }

    public function __invoke(array $pair): static
    {
        return new self($pair);
    }

    public static function fromArray(array $pair): static
    {
        return new self($pair);
    }

    public function key(): string|int|bool|float|object
    {
        return $this->key;
    }

    public function value(): string|int|bool|float|object
    {
        return $this->value;
    }
}
