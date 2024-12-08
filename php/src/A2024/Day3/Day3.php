<?php

namespace Factor\Aoc\A2024\Day3;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day3 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = '';

        foreach (file($this->file) as $line) {
            $dataset .= trim($line);
        }

        $this->dataset = $dataset;
    }

    public function mul(mixed $x, mixed $y): int
    {
        return (int)$x * (int)$y;
    }

    public function part1(): int
    {
        $result = 0;

        $pattern = '/mul\(\d*,\d*\)/';

        preg_match_all($pattern, $this->dataset, $matches);

        $matches = $matches[0];

        for ($i = 0; $i < count($matches); $i++) {
            eval('$result += $this->' . $matches[$i] . ';');
        }

        return $result;
    }

    public function part2(): int
    {
        $DO = 'do()';
        $DONT = 'don\'t()';

        $result = 0;

        $reg_do = 'do\(\)';
        $reg_dont = 'don\'t\(\)';
        $reg_mul = 'mul\(\d*,\d*\)';

        $pattern = "/$reg_do|$reg_dont|$reg_mul/";

        preg_match_all($pattern, $this->dataset, $matches);

        $matches = $matches[0];

        $take = true;

        for ($i = 0; $i < count($matches); $i++) {
            if ($matches[$i] === $DO || $matches[$i] === $DONT) {
                $take = $matches[$i] === $DO;
                continue;
            }

            if ($take) {
                eval('$result += $this->' . $matches[$i] . ';');
            }
        }

        return $result;
    }
}

$day = new Day3(__DIR__ . '/3.txt');
$day->run();
