<?php

namespace Factor\Aoc\A2024\Day1;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day1 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            [$dataset[0][], $dataset[1][]] = array_map('intval', explode('  ', $line));
        }

        sort($dataset[0]);
        sort($dataset[1]);

        $this->dataset = $dataset;
    }

    public function part1(): int
    {
        return array_sum(
            array_map(
                fn(int $a, int $b) => abs($a - $b),
                ...$this->dataset
            )
        );
    }

    public function part2(): int
    {
        return array_reduce(
            $this->dataset[0],
            fn($c, $v) => $c + count(array_filter($this->dataset[1], fn($b) => $b === $v)) * $v
        );
    }
}

$day = new Day1(__DIR__ . '/1.txt');
$day->run();