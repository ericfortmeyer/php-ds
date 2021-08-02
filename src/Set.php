<?php

declare(strict_types=1);

namespace PhpDs;

final class Set
{
    private array $internalMap = [];

    /**
     * @var array<string, string> $keyMap
     */
    private array $keyMap = [];

    public function add(string $key, object $item): void
    {
        $this->internalMap[$key] = $item;
        $this->keyMap[$key] = $key;
    }

    public function get(string $key): object
    {
        return $this->internalMap[$key];
    }

    private function keyOfMax(): string
    {
        $counts = array_map("count", $this->internalMap);
        return array_flip($counts)[max($counts)];
    }

    public function max()
    {
        return $this->internalMap[$this->keyOfMax()];
    }

    public function keys(): array
    {
        return $this->keyMap;
    }

    public function has(string $key): bool
    {
        return key_exists($key, $this->internalMap);
    }

    public function toArray(): array
    {
        $arr = [];
        foreach ($this->internalMap as $v) {
            $arr[] = $v;
        }
        return $arr;
    }
}
