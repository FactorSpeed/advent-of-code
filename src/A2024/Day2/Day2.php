<?php

namespace Factor\Aoc\A2024\Day2;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day2 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $dataset[] = array_map(fn($a) => (int)$a, explode(' ', str_replace("\n", '', $line)));
        }

        $this->dataset = $dataset;
    }

    public function isGood(array $line): bool
    {
        if (!$this->isIncrease($line) && !$this->isDecrease($line)) {
            return false;
        }

        $ok = true;
        for ($i = 0; $i < count($line) - 1; $i++) {
            $diff = abs($line[$i] - $line[$i + 1]);
            if ($diff < 1 || $diff > 3) {
                $ok = false;
                break;
            }
        }

        return $ok;
    }

    public function isIncrease(array $line): bool
    {
        $a = $line;
        sort($a);
        return $a === $line;
    }

    public function isDecrease(array $line): bool
    {
        $a = $line;
        rsort($a);
        return $a === $line;
    }

    public function part1(): int
    {
        $result = 0;

        foreach ($this->dataset as $line) {
            if ($this->isGood($line)) {
                $result++;
            }
        }

        return $result;
    }

    public function part2(): int
    {
        $result = 0;

        foreach ($this->dataset as $line) {
            if ($this->isGood($line)) {
                $result++;
                continue;
            }

            for ($i = 0; $i < count($line); $i++) {
                $t = array_merge(
                    array_slice($line, 0, $i),
                    array_slice($line, $i + 1)
                );
                if ($this->isGood($t)) {
                    $result++;
                    break;
                }
            }
        }

        return $result;
    }
}

$day = new Day2(__DIR__ . '/2.txt');
$day->run();
