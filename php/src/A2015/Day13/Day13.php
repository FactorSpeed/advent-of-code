<?php

namespace Factor\Aoc\A2015\Day13;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\A2015\Itertools;
use Factor\Aoc\AdventOfCode;

class Day13 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            preg_match('/(\w+) would (gain|lose) (\d+) happiness units by sitting next to (\w+)./', $line, $matches);
            $dataset[] = array_slice($matches, 1);
        }

        $this->dataset = $dataset;
    }

    public function getPersons(bool $withMe = false): array
    {
        $persons = array_values(
            array_unique([
                ...array_column($this->dataset, 0),
                ...array_column($this->dataset, 3)
            ])
        );

        if($withMe) {
            $persons[] = 'MySelf';
        }

        return $persons;
    }

    public function getPotentialHapiness(string $a, string $b): int
    {
        $sum = 0;

        foreach ($this->dataset as $d) {
            if (
                ($d[0] === $a && $d[3] === $b) ||
                ($d[0] === $b && $d[3] === $a)
            ) {
                $sum += $d[1] === 'lose' ? -$d[2] : $d[2];
            }
        }

        return $sum;
    }

    public function getPermutations(bool $withMe = false): array
    {
        return new Itertools()->permutations($this->getPersons($withMe));
    }
    
    public function hapiness(bool $withMe = false): array
    {
        $result = [];

        foreach ($this->getPermutations($withMe) as $permutation) {
            $happiness = 0;

            for ($i = 1, $iMax = count($permutation); $i < $iMax; $i++) {
                $happiness += $this->getPotentialHapiness($permutation[$i - 1], $permutation[$i]);
            }

            $happiness += $this->getPotentialHapiness(
                $permutation[array_key_first($permutation)],
                $permutation[array_key_last($permutation)],
            );

            $result[] = $happiness;
        }

        return $result;
    }

    public function part1(): int
    {
        return max($this->hapiness());
    }

    public function part2(): int
    {
        return max($this->hapiness(true));
    }
}

$day = new Day13(__DIR__);
$day->run();
