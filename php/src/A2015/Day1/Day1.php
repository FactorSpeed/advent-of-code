<?php

namespace Factor\Aoc\A2015\Day1;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day1 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $dataset = str_split($line);
        }

        $this->dataset = $dataset;
    }


    public function part1(): int
    {
        $result = 0;

        foreach ($this->dataset as $letter) {
            $result += $letter === '(' ? 1 : -1;
        }

        return $result;
    }

    public function part2(): int
    {
        $result = 0;

        foreach ($this->dataset as $index => $letter) {
            $result += $letter === '(' ? 1 : -1;
            if ($result === -1) {
                $result = $index + 1;
                break;
            }
        }

        return $result;
    }
}

$day = new Day1(__DIR__);
$day->run();
