<?php

namespace Factor\Aoc\A2015\Day17;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\A2015\Itertools;
use Factor\Aoc\AdventOfCode;

class Day17 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $dataset[] = trim((int)$line);
        }

        $this->dataset = $dataset;
    }

    public function combinations(): array
    {
        return array_filter(
            new Itertools()->combinations($this->dataset, '1-' . count($this->dataset)),
            static fn($a) => array_sum($a) === 150
        );
    }
    
    public function part1(): int
    {
        return count($this->combinations());
    }

    public function part2(): int
    {
        $combinations = $this->combinations();
        usort($combinations, static fn($a, $b) => count($a) <=> count($b));

        $min = count($combinations[0]);
        $withLessContainers = [];
        foreach ($combinations as $combination) {
            if(count($combination) === $min) {
                $withLessContainers[] = $combination;
            }
        }

        return count($withLessContainers);
    }
}

$day = new Day17(__DIR__);
$day->run();
