<?php

namespace Factor\Aoc\A2015\Day19;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day19 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $a = preg_match('#(\w+) => (\w+)#', $line, $matches);
            if ($a) {
                $dataset['transform'][] = [$matches[1] => $matches[2]];
            } else {
                $dataset['text'] = trim($line);
            }
        }

        $this->dataset = $dataset;
    }

    public function part1(): int
    {
        $results = [];

        $subject = $this->dataset['text'];

        foreach ($this->dataset['transform'] as $transform) {
            foreach ($transform as $key => $value) {
                $regex = "/$key/";
                preg_match_all($regex, $subject, $matches, PREG_SET_ORDER);
                foreach ($matches as $index => $letter) {
                    $counter = 0;
                    $results[] = preg_replace_callback(
                        $regex,
                        static function ($m) use (&$counter, $index, $value) {
                            if ($counter++ === $index) {
                                return $value;
                            }

                            return $m[0];
                        },
                        $subject
                    );
                }
            }
        }

        return count(array_unique($results));
    }

    public function part2(): int
    {
        return 0;
    }
}

$day = new Day19(__DIR__);
$day->run();
