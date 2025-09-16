<?php

namespace Factor\Aoc\A2015\Day8;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day8 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $dataset[] = trim($line);
        }

        $this->dataset = $dataset;
    }

    public function part1(): int
    {
        $data = $this->dataset;

        $numberOfChars = 0;
        $numberOfUnescapeChars = 0;

        foreach ($data as $string) {
            $numberOfChars += strlen($string);

            $transform = preg_replace_callback("(\\\\x([0-9a-f]{2}))i", static fn($a) => chr(hexdec($a[1])), $string);
            $transform = str_replace(['\"', "\\\\"], ['"', '\\'], $transform);

            $numberOfUnescapeChars += strlen($transform) - 2;
        }

        return $numberOfChars - $numberOfUnescapeChars;
    }

    public function part2(): int
    {
        $data = $this->dataset;

        $numberOfChars = 0;
        $numberOfUnescapeChars = 0;

        foreach ($data as $string) {
            $numberOfChars += strlen($string);

            $numberOfUnescapeChars += strlen(addslashes($string)) + 2;
        }

        return $numberOfUnescapeChars - $numberOfChars;
    }
}

$day = new Day8(__DIR__);
$day->run();
