<?php

namespace PhpDs;

use Closure;

abstract class Tree extends Node
{
    protected NodeCollection $children;

    public function __construct($value)
    {
        $this->children = new NodeCollection();
        parent::__construct($value);
    }

    public function addChild(Node $child): void
    {
        $this->children->add($child);
    }

    public function map(Closure $func): array
    {
        return $this->children->map($func);
    }
}
