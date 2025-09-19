<?php

namespace Factor\Aoc\A2015\Day20;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day20 extends AdventOfCode
{
    public string $text = '';

    public function readDataset(): void
    {
        $this->dataset = 34000000;
    }

    public function part1(): int
    {
        $limit = $this->dataset / 20;

        $houses = array_fill(1, $limit, 0);

        for ($elf = 1; $elf <= $limit; $elf++) {
            for ($house = $elf; $house <= $limit; $house += $elf) {
                $houses[$house] += $elf * 10;
            }

            if ($houses[$elf] >= $this->dataset) {
                return $elf;
            }
        }

        return 0;
    }

    public function part2(): int
    {
        $houses = array_fill(1, $this->dataset, 0);

        for ($elf = 1; $elf <= $this->dataset; $elf++) {
            $houseMax = min($elf * 50, $this->dataset);
            for ($house = $elf; $house <= $houseMax; $house += $elf) {
                $houses[$house] += $elf * 11;
            }

            if ($houses[$elf] >= $this->dataset) {
                return $elf;
            }
        }

        return 0;
    }
}

$day = new Day20(__DIR__);
$day->run();
