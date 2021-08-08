<?php

declare(strict_types=1);

namespace PhpDs;

use Countable;

final class Set implements Countable
{
    private array $internalMap = [];

    /**
     * @var array<string|int|float,string|int|float> $keyMap
     */
    private array $hashMap = [];

    public function add(string|int|float|bool|null|object $member): void
    {
        $hash = $this->hash($member);
        $this->internalMap[$hash] = $member;
        $this->hashMap[$hash] = $hash;
    }

    private function hash(string|int|float|bool|null|object $member): string|int
    {
        return match (true) {
            is_object($member) => spl_object_hash($member),

            is_string($member) => md5($member),

            is_null($member) => sha1("NULL"),

            is_integer($member) => $member,

            is_float($member) => number_format($member, 300),

            is_bool($member) => $member === true ? sha1("TRUE") : sha1("FALSE")
        };
    }

    /**
     * Uses the given key to get a member of the set.
     *
     * ```?
     * Time complexity: O1
     * ```
     */
    public function get(string|int|float|bool|null|object $member): string|int|float|bool|null|object
    {
        return $this->internalMap[$this->hash($member)];
    }

    public function cardinality(): int
    {
        return count($this->internalMap);
    }

    public function count(): int
    {
        return count($this->internalMap);
    }

    public function max()
    {
        return max($this->internalMap);
    }

    /**
     * Transforms the set into a standard array.
     */
    public function toArray(): array
    {
        return array_values($this->internalMap);
    }
}
