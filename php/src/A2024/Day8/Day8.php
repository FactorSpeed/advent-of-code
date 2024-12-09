<?php

namespace Factor\Aoc\A2024\Day8;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day8 extends AdventOfCode
{
    public function readDataset(): void
    {
        $this->dataset = array_map(
            static fn($line) => str_split(trim($line)),
            file($this->file)
        );
    }

    private function extractCoordinates(): array
    {
        $coordinates = [];

        foreach ($this->dataset as $i => $row) {
            foreach ($row as $j => $cell) {
                if ($cell !== '.') {
                    $coordinates[$cell][] = [$i, $j];
                }
            }
        }
        return $coordinates;
    }

    private function generateCombinations(array $positions): array
    {
        $combinations = [];

        foreach ($positions as $pos1) {
            foreach ($positions as $pos2) {
                if ($pos1 !== $pos2) {
                    $combinations[] = [$pos1, $pos2];
                }
            }
        }

        return $combinations;
    }

    private function calculateDifference(array $a, array $b): array
    {
        return [$a[0] - $b[0], $a[1] - $b[1]];
    }

    private function calculateNewPosition(array $a, array $delta): array
    {
        return [$a[0] + $delta[0], $a[1] + $delta[1]];
    }

    public function part1(): int
    {
        $coordinates = $this->extractCoordinates();
        $combinations = array_map(fn($a) => $this->generateCombinations($a), $coordinates);

        $uniquePositions = $this->processPart1($combinations);

        return count(array_unique($uniquePositions));
    }

    private function processPart1(array $combinations): array
    {
        $positions = [];
        $width = count($this->dataset);
        $height = count($this->dataset[0]);

        foreach ($combinations as $key => $pairs) {
            foreach ($pairs as [$pos1, $pos2]) {
                $delta = $this->calculateDifference($pos1, $pos2);
                [$x, $y] = $this->calculateNewPosition($pos1, $delta);

                if ($x >= 0 && $x < $width && $y >= 0 && $y < $height && $this->dataset[$x][$y] !== $key) {
                    $positions[] = "$x|$y";
                }
            }
        }

        return $positions;
    }

    public function part2(): int
    {
        $coordinates = $this->extractCoordinates();
        $combinations = array_map([$this, 'generateCombinations'], $coordinates);

        $dataset = $this->processPart2($combinations);

        return $this->countNonEmptyCells($dataset);
    }

    private function processPart2(array $combinations): array
    {
        $dataset = $this->dataset;

        $width = count($dataset);
        $height = count($dataset[0]);

        foreach ($combinations as $pairs) {
            foreach ($pairs as [$pos1, $pos2]) {
                $delta = $this->calculateDifference($pos1, $pos2);

                [$x, $y] = $this->calculateNewPosition($pos2, $delta);
                while ($x >= 0 && $x < $width && $y >= 0 && $y < $height) {
                    if ($dataset[$x][$y] === '.') {
                        $dataset[$x][$y] = '#';
                    }
                    [$x, $y] = $this->calculateNewPosition([$x, $y], $delta);
                }
            }
        }

        return $dataset;
    }

    private function countNonEmptyCells($dataset): int
    {
        $count = 0;
        foreach ($dataset as $row) {
            foreach ($row as $cell) {
                if ($cell !== '.') {
                    $count++;
                }
            }
        }
        return $count;
    }
}

$day = new Day8(__DIR__ . '/8.txt');
$day->run();
