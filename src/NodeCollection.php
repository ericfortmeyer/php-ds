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
        $results = [];
        foreach ($this->values as $value) {
            $results[] = $func($value);
        }
        return $results;
    }

    public function count(): int
    {
        return count($this->values, COUNT_RECURSIVE);
    }
}
