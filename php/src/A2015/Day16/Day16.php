<?php

namespace Factor\Aoc\A2015\Day16;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day16 extends AdventOfCode
{
    public static array $list = [
        'children' => 3,
        'cats' => 7,
        'samoyeds' => 2,
        'pomeranians' => 3,
        'akitas' => 0,
        'vizslas' => 0,
        'goldfish' => 5,
        'trees' => 3,
        'cars' => 2,
        'perfumes' => 1,
    ];

    public static array $listMore = ['cats', 'trees'];

    public static array $listLess = ['pomeranians', 'goldfish'];

    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            preg_match('#Sue (\d+): (\w+): (\d+), (\w+): (\d+), (\w+): (\d+)#', $line, $matches);

            $data = array_slice($matches, 1);

            $dataset[$data[0]] = [$data[1] => (int)$data[2], $data[3] => (int)$data[4], $data[5] => (int)$data[6]];
        }

        $this->dataset = $dataset;
    }

    public function match(string $key, int $value): bool
    {
        if (
            self::$list[$key] < $value &&
            in_array($key, self::$listMore, true)
        ) {
            return true;
        }

        if (
            self::$list[$key] > $value &&
            in_array($key, self::$listLess, true)
        ) {
            return true;
        }

        return false;
    }

    public function part1(): int
    {
        $potentials = [];

        foreach ($this->dataset as $aunt => $items) {
            $found = true;
            foreach ($items as $key => $value) {
                if (self::$list[$key] !== $value) {
                    $found = false;
                    break;
                }
            }

            if ($found) {
                $potentials[] = $aunt;
            }
        }

        if (count($potentials) === 1) {
            return $potentials[0];
        }

        return 0;
    }

    public function part2(): int
    {
        $guess = $this->part1();

        $potentials = [];

        foreach ($this->dataset as $aunt => $items) {
            $found = true;
            foreach ($items as $key => $value) {
                if (self::$list[$key] !== $value && !$this->match($key, $value)) {
                    $found = false;
                    break;
                }
            }

            if ($found) {
                $potentials[] = $aunt;
            }
        }

        foreach ($potentials as $aunt) {
            if ($aunt !== $guess) {
                return $aunt;
            }
        }

        return 0;
    }
}

$day = new Day16(__DIR__);
$day->run();
