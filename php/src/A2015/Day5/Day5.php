<?php

namespace Factor\Aoc\A2015\Day5;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day5 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $dataset[] = trim($line);
        }

        $this->dataset = $dataset;
    }

    public function hasVowels(string $string): bool
    {
        preg_match_all('/[aeiou]/', $string, $matches);
        return count($matches[0]) > 2;
    }

    public function hasConsecutive(string $string): bool
    {
        return preg_match('/(.)\1/', $string);
    }

    public const array CONSTRAINTS = ['ab', 'cd', 'pq', 'xy'];

    public function hasNotConstraints(string $string): bool
    {
        return array_all(self::CONSTRAINTS, static fn($constraint) => !str_contains($string, $constraint));
    }

    public function part1(): int
    {
        $result = 0;

        foreach ($this->dataset as $string) {
            if (
                $this->hasVowels($string)
                && $this->hasConsecutive($string)
                && $this->hasNotConstraints($string)
            ) {
                $result++;
            }
        }

        return $result;
    }

    public function part2(): int
    {
        return 0;
    }
}

$day = new Day5(__DIR__);
$day->run();
