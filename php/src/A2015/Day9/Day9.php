<?php

namespace Factor\Aoc\A2015\Day9;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\A2015\Itertools;
use Factor\Aoc\AdventOfCode;

class Day9 extends AdventOfCode
{
    public array $_routes = [];

    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            preg_match('/(\w+) to (\w+) = (\d+)/', $line, $matches);
            $dataset[] = array_slice($matches, 1);
        }

        $this->dataset = $dataset;
    }

    public function getCities(): array
    {
        return array_values(
            array_unique([
                ...array_column($this->dataset, 0),
                ...array_column($this->dataset, 1)
            ])
        );
    }

    public function getDistance(string $a, string $b): int
    {
        foreach ($this->dataset as $d) {
            if (
                ($d[0] === $a && $d[1] === $b) ||
                ($d[0] === $b && $d[1] === $a)
            ) {
                return $d[2];
            }
        }

        return 0;
    }

    public function getPermutations(): array
    {
        return new Itertools()->permutations($this->getCities());
    }

    public function getRoutes(): array
    {
        if (count($this->_routes) > 0) {
            return $this->_routes;
        }

        foreach ($this->getPermutations() as $permutation) {
            $distance = 0;

            for ($i = 1, $iMax = count($permutation); $i < $iMax; $i++) {
                $distance += $this->getDistance($permutation[$i - 1], $permutation[$i]);
            }

            $this->_routes[] = $distance;
        }

        return $this->_routes;
    }

    public function part1(): int
    {
        return min($this->getRoutes());
    }

    public function part2(): int
    {
        return max($this->getRoutes());
    }
}

$day = new Day9(__DIR__);
$day->run();
