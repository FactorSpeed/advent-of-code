<?php

namespace Factor\Aoc\A2015\Day4;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day4 extends AdventOfCode
{
    public function readDataset(): void
    {
//        $this->dataset = 'abcdef';
        $this->dataset = 'bgvyzdsv';
    }

    public function find(string $match): int
    {
        $i = 0;

        while (true) {
            if (str_starts_with(md5($this->dataset . $i), $match)) {
                break;
            }
            $i++;
        }

        return $i;
    }

    public function part1(): int
    {
        return $this->find('00000');
    }

    public function part2(): int
    {
        return $this->find('000000');
    }
}

$day = new Day4(__DIR__);
$day->run();
