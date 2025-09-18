<?php

namespace Factor\Aoc\A2015;

/**
 * Based on https://rosettacode.org/wiki/Permutations
 * Based on https://stackoverflow.com/questions/15577651/generate-all-compositions-of-an-integer-into-k-parts
 * Based on https://rosettacode.org/wiki/Combinations
 */
class Itertools
{
    public function permutations(array $xs): array
    {
        $ac = [[]];

        foreach ($xs as $x) {
            $ac_new = [];
            foreach ($ac as $ts) {
                $len = count($ts);
                for ($n = 0; $n <= $len; $n++) {
                    $new_ts = $ts;
                    array_splice($new_ts, $n, 0, $x);
                    $ac_new[] = $new_ts;
                }
            }
            $ac = $ac_new;
        }

        return $ac;
    }

    public function getFirstComposition(int $n, int $k): array|false
    {
        if ($n < $k) {
            return false;
        }
        $composition = array_fill(0, $k - 1, 1);
        $composition[$k - 1] = $n - $k + 1;
        return $composition;
    }

    public function getNextComposition(int $n, int $k, array &$composition): bool
    {
        if ($composition[0] === $n - $k + 1) {
            return false;
        }

        $last = $k - 1;
        while ($composition[$last] === 1) {
            $last--;
        }

        $z = $composition[$last];
        ++$composition[$last - 1];
        $composition[$last] = 1;
        $composition[$k - 1] = $z - 1;

        return true;
    }

    public function compositions(int $n, int $k): ?\Generator
    {
        $composition = $this->getFirstComposition($n, $k);
        if ($composition === false) {
            return;
        }

        do {
            yield $composition;
        } while ($this->getNextComposition($n, $k, $composition));
    }

    public function combinations(array $set = [], string $range = '1'): array
    {
        if (str_contains($range, '-')) {
            [$start, $end] = explode('-', $range);
            [$start, $end] = [(int)$start, (int)$end];
        } else {
            [$start, $end] = [(int)$range, (int)$range];
        }

        $result = [];

        for ($i = $start; $i <= $end; $i++) {
            $result = [...$result, ...$this->getNextCombination($set, $i)];
        }

        return $result;
    }

    private function getNextCombination(array $set = [], int $size = 0): array
    {
        if ($size === 0) {
            return [[]];
        }

        if ($set === []) {
            return [];
        }

        $prefix = [array_shift($set)];

        $result = [];

        foreach ($this->getNextCombination($set, $size-1) as $suffix) {
            $result[] = array_merge($prefix, $suffix);
        }

        foreach ($this->getNextCombination($set, $size) as $next) {
            $result[] = $next;
        }

        return $result;
    }
}
