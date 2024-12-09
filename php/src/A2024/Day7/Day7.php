<?php

namespace Factor\Aoc\A2024\Day7;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day7 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $dataset[] = explode(' ', trim(str_replace("\n", '', str_replace(':', '', $line))));
        }

        $this->dataset = $dataset;
    }

    public function part1(): int
    {
        $result = 0;

        foreach ($this->dataset as $data) {
            $wanted = (int)array_shift($data);

            $combinations = $this->combinations($data, ['+', '*']);

            foreach ($combinations as $combination) {
                $r = $this->calculate($combination);

                if ($r === $wanted) {
                    $result += $wanted;
                    break;
                }
            }
        }

        return $result;
    }

    public function combinations(array $t, array $ops): array
    {
        $results = [];

        $this->recursive($t, $t[0], 0, $results, $ops);

        return $results;
    }

    public function recursive($t, $ta, $index, &$results, $ops): void
    {
        $n = count($t) - 1;

        if ($index === $n) {
            $results[] = $ta;
            return;
        }

        foreach ($ops as $op) {
            $tn = $ta . $op . $t[$index + 1];
            $this->recursive($t, $tn, $index + 1, $results, $ops);
        }
    }

    public function part2(): int
    {
        $result = 0;

        foreach ($this->dataset as $data) {
            $wanted = (int)array_shift($data);

            $combinations = $this->combinations($data, ['+', '*', '.']);

            foreach ($combinations as $combination) {
                $r = $this->calculate($combination);

                if ($r === $wanted) {
                    $result += $wanted;
                    break;
                }
            }
        }

        return $result;
    }

    public function calculate($expression): int
    {
        $tokens = preg_split('/([+\-*\/.])/', $expression, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        $result = (int)trim($tokens[0]);

        for ($i = 1, $iMax = count($tokens); $i < $iMax; $i += 2) {
            $operator = trim($tokens[$i]);
            $next = (int)trim($tokens[$i + 1]);

            if ($operator === '.') {
                $result = (int)($result . $next);
            } else {
                $expr = '$result ' . $operator . '=' . $next . ';';
                eval($expr);
            }
        }

        return $result;
    }
}

$day = new Day7(__DIR__ . '/7.txt');
$day->run();
