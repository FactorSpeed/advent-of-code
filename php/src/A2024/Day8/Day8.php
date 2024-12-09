<?php

namespace Factor\Aoc\A2024\Day8;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day8 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        $default = '............
........0...
.....0......
.......0....
....0.......
......A.....
............
............
........A...
.........A..
............
............';

        foreach (file($this->file) as $line) {
//        foreach (explode("\n", $default) as $line) {
            $dataset[] = str_split(trim(str_replace("\n", "", $line)));
        }

        $this->dataset = $dataset;
    }

    public function combinations(array $d): array
    {
        $r = [];
        foreach ($d as $a) {
            foreach ($d as $b) {
                if ($a !== $b) {
                    $r[] = [$a, $b];
                }
            }
        }

        return $r;
    }

    public function diff($a, $b): array
    {
        [$x1, $y1] = $a;
        [$x2, $y2] = $b;

        return [$x1 - $x2, $y1 - $y2];
    }

    public function new_pos($a,$b): array
    {
        [$x1, $y1] = $a;
        [$x2, $y2] = $b;

        return [$x1 + $x2 * 2, $y1 + $y2 * 2];
    }

    public function part1(): int
    {
        $coords = [];

        $width = count($this->dataset);
        $height = count($this->dataset[0]);

        for ($i = 0; $i < $width; $i++) {
            for ($j = 0; $j < $height; $j++) {
                if ($this->dataset[$i][$j] !== '.') {
                    $coords[$this->dataset[$i][$j]][] = [$i, $j];
                }
            }
        }

        $r = array_map(fn ($coord) => $this->combinations($coord), $coords);

        $s = $this->process($r, $width, $height);

        return count(array_unique($s));
    }

    public function process(array $r, int $width, int $height): array
    {
        $s = [];

        foreach ($r as $k => $coords) {
            foreach ($coords as $coord) {
                [$a, $b] = $coord;

                $n = $this->diff($a, $b);
                [$x, $y] = $this->new_pos($b,$n);

                if ($x >= 0 && $x < $width && $y >= 0 && $y < $height && $this->dataset[$x][$y] !== $k) {
                    $s[] = $x . '|' . $y;
                }
            }
        }

        return $s;
    }

    public function process2(array $r, int $width, int $height, &$s): array
    {
        foreach ($r as $k => $coords) {
            foreach ($coords as $coord) {
                [$a, $b] = $coord;

                $n = $this->diff($a, $b);
                [$x, $y] = $this->new_pos($b,$n);

                if ($x >= 0 && $x < $width && $y >= 0 && $y < $height && $this->dataset[$x][$y] !== $k) {
                    $s[] = $x . '|' . $y;
                }
            }
        }

        return $s;
    }


    public function part2(): int
    {
        $coords = [];

        $width = count($this->dataset);
        $height = count($this->dataset[0]);

        for ($i = 0; $i < $width; $i++) {
            for ($j = 0; $j < $height; $j++) {
                if ($this->dataset[$i][$j] !== '.') {
                    $coords[$this->dataset[$i][$j]][] = [$i, $j];
                }
            }
        }

        $r = array_map(fn ($coord) => $this->combinations($coord), $coords);

        $s = [];

        $this->process2($r, $width, $height, $s);

        return count(array_unique($s));
    }
}

$day = new Day8(__DIR__ . '/8.txt');
$day->run();
