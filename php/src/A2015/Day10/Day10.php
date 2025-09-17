<?php

namespace Factor\Aoc\A2015\Day10;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day10 extends AdventOfCode
{
    public function readDataset(): void
    {
//        $this->dataset = '1';
        $this->dataset = '1113222113';
    }

    public function iterate(int $n): int
    {
        $data = $this->dataset;

        $res = '';

        for ($i = 0; $i < $n; $i++) {
            $res = '';
            while ($data !== '') {
                preg_match('/^(.)\1*/', $data, $matches);
                $data = ltrim($data, $matches[1]);
                $res .= strlen($matches[0]) . $matches[1];
            }

            $data = $res;
        }

        return strlen($res);
    }

    public function part1(): string
    {
        return $this->iterate(40);
    }

    public function part2(): int
    {
        return $this->iterate(50);
    }
}

$day = new Day10(__DIR__);
$day->run();
