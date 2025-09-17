<?php

namespace Factor\Aoc\A2015\Day12;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day12 extends AdventOfCode
{
    /**
     * @throws \JsonException
     */
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $dataset[] = json_decode(trim($line), true, 512, JSON_THROW_ON_ERROR);
        }

        $this->dataset = $dataset;
    }

    public function getNumbersFromPartOne(array $data): array
    {
        $numbers = [];

        foreach ($data as $d) {
            if (is_array($d)) {
                $numbers = array_merge($numbers, $this->getNumbersFromPartOne($d));
            } else if (preg_match('/-?(\d+)/', $d) !== false) {
                $numbers[] = (int)$d;
            }
        }

        return $numbers;
    }

    public function getNumbersFromPartTwo(array $data): array
    {
        $numbers = [];

        foreach ($data as $d) {
            if (is_array($d)) {
                if (
                    in_array('red', $d, true) &&
                    array_keys($d) !== range(0, count($d) - 1)
                ) {
                    continue;
                }

                $numbers = array_merge($numbers, $this->getNumbersFromPartTwo($d));
            } else if (preg_match('/-?(\d+)/', $d) !== false) {
                $numbers[] = (int)$d;
            }
        }

        return $numbers;
    }

    public function part1(): int
    {
        return array_sum($this->getNumbersFromPartOne($this->dataset));
    }

    public function part2(): int
    {
        return array_sum($this->getNumbersFromPartTwo($this->dataset));
    }
}

$day = new Day12(__DIR__);
$day->run();
