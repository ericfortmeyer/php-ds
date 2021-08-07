<?php

namespace PhpDs;

abstract class Node
{
    public function __construct(protected string|int|bool|float|null|object $value)
    {
    }

    abstract public function getValue(): string|int|float|bool|null|object;
}
