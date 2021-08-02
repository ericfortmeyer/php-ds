<?php

namespace PhpDs;

abstract class Node
{
    public function __construct(protected $value)
    {
    }

    abstract public function getValue();
}
