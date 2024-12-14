<?php

namespace Factor\Aoc\A2024\Day13;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day13 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        $content = file_get_contents($this->file);

        $pattern = '/Button A: X\+(\d+), Y\+(\d+)\s+Button B: X\+(\d+), Y\+(\d+)\s+Prize: X=(\d+), Y=(\d+)/';

        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $dataset[] = [
                'ax' => (int)$match[1],
                'ay' => (int)$match[2],
                'bx' => (int)$match[3],
                'by' => (int)$match[4],
                'px' => (int)$match[5],
                'py' => (int)$match[6],
            ];
        }

        $this->dataset = $dataset;
    }

    public function solve(array $g, int $offset = 0): int
    {
        [$a, $b, $e] = [$g['ax'], $g['bx'], $g['px'] + $offset];
        [$c, $d, $f] = [$g['ay'], $g['by'], $g['py'] + $offset];

        $den = $a * $d - $b * $c;
        $nomx = $e * $d - $b * $f;
        $nomy = $a * $f - $e * $c;

        $x = $nomx / $den;
        $y = $nomy / $den;

        if (
            $a * $x + $b * $y === $e &&
            $c * $x + $d * $y === $f
        ) {
            return $x * 3 + $y;
        }

        return 0;
    }

    public function part1(): int
    {
        $dataset = $this->dataset;

        $result = 0;

        foreach ($dataset as $g) {
            $result += $this->solve($g);
        }

        return $result;
    }

    public function part2(): int
    {
        $dataset = $this->dataset;

        $result = 0;

        foreach ($dataset as $g) {
            $result += $this->solve($g, 10_000_000_000_000);
        }

        return $result;
    }
}

$day = new Day13(__DIR__);
$day->run();
