<?php

namespace Factor\Aoc\A2015;

/**
 * Based on https://rosettacode.org/wiki/Permutations
 */
class Itertools
{
    public function permutations($xs): array
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
}
