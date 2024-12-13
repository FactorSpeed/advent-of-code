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

        foreach ($matches as $iValue) {
            eval('$result += $this->' . $iValue . ';');
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

        foreach ($matches as $iValue) {
            if ($iValue === $DO || $iValue === $DONT) {
                $take = $iValue === $DO;
                continue;
            }

            if ($take) {
                eval('$result += $this->' . $iValue . ';');
            }
        }

        return $result;
    }
}

$day = new Day3(__DIR__);
$day->run();
