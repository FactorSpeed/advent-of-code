<?php

namespace Factor\Aoc\A2015\Day19;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day19 extends AdventOfCode
{
    public string $text = '';

    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $a = preg_match('#(\w+) => (\w+)#', $line, $matches);
            if ($a) {
                $dataset[] = [$matches[1] => $matches[2]];
            } else {
                $this->text = trim($line);
            }
        }

        $this->dataset = $dataset;
    }

    public function part1(): int
    {
        $results = [];

        foreach ($this->dataset as $transform) {
            [$key, $value] = [array_keys($transform)[0], array_values($transform)[0]];
            $pos = 0;
            while (($pos = strpos($this->text, $key, $pos)) !== false) {
                $results[] = substr_replace($this->text, $value, $pos, strlen($key));
                ++$pos;
            }
        }

        return count(array_unique($results));
    }

    public function solvePart2(): int
    {
        $text = $this->text;
        $steps = 0;
        $dataset = $this->dataset;
        $same = 0;

        while ($text !== 'e') {
            foreach ($dataset as $transform) {
                [$key, $value] = [array_values($transform)[0], array_keys($transform)[0]];
                $pos = strpos($text, $key);

                if (false === $pos) {
                    ++$same;
                    continue;
                }

                $text = substr_replace($text, $value, $pos, strlen($key));
                ++$steps;
            }

            if ($same === count($this->dataset)) {
                $text = $this->text;
                $steps = 0;
                shuffle($dataset);
            }

            $same = 0;
        }

        return $steps;
    }

    public function part2(): int
    {
        # Weird solution with bruteforce
        # True explanation here https://www.reddit.com/r/adventofcode/comments/3xflz8/comment/cy4etju/
        return $this->solvePart2();
    }
}

$day = new Day19(__DIR__);
$day->run();
