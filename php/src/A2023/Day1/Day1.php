<?php

namespace Factor\Aoc\A2023\Day1;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day1 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $dataset[] = str_replace("\n", '', $line);
        }

        $this->dataset = $dataset;
    }


    public function part1(): int
    {
        $result = 0;

        foreach ($this->dataset as $word) {
            preg_match_all('/\d/', $word, $matches);

            $matches = $matches[0];

            if (count($matches) > 0) {
                $concat = (int)($matches[array_key_first($matches)] . $matches[array_key_last($matches)]);
                $result += $concat;
            }
        }

        return $result;
    }

    public function part2(): int
    {
        $digits = [
            'one' => 1,
            'two' => 2,
            'three' => 3,
            'four' => 4,
            'five' => 5,
            'six' => 6,
            'seven' => 7,
            'eight' => 8,
            'nine' => 9
        ];

        $result = 0;

        $reg_digit = '\d';
        $reg_words = implode('|', array_keys($digits));

        $pattern = "/(?=($reg_digit|$reg_words))/";

        foreach ($this->dataset as $word) {
            preg_match_all($pattern, $word, $matches);

            $matches = $matches[1];

            $matches = array_map(static fn($a) => array_key_exists($a, $digits) ? $digits[$a] : $a, $matches);

            if (count($matches) > 0) {
                $concat = (int)($matches[array_key_first($matches)] . $matches[array_key_last($matches)]);
                $result += $concat;
            }
        }

        return $result;
    }
}

$day = new Day1(__DIR__);
$day->run();
