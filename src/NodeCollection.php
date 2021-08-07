<?php

namespace PhpDs;

use Closure;
use Countable;

class NodeCollection implements Countable
{
    private array $values = [];

    public function add(Node $node): void
    {
        $this->values[] = $node;
    }

    public function map(Closure $func): array
    {
        return array_map($func, $this->values);
    }

    public function count(): int
    {
        return count($this->values, COUNT_RECURSIVE);
    }
}
