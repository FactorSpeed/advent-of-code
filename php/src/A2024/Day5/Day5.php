<?php

namespace Factor\Aoc\A2024\Day5;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day5 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            if (str_contains($line, '|')) {
                $dataset['rules'][] = explode('|', str_replace("\n", '', $line));
                continue;
            }

            if (str_contains($line, ',')) {
                $dataset['list'][] = explode(',', str_replace("\n", '', $line));
            }
        }

        $this->dataset = $dataset;
    }

    public function part1(): int
    {
        $result = 0;

        foreach ($this->dataset['list'] as $value) {
            $sorted = $this->sort($value, $this->dataset['rules']);

            if ($value === $sorted) {
                $result += $this->middleValue($value);
            }
        }

        return $result;
    }

    public function part2(): int
    {
        $result = 0;

        foreach ($this->dataset['list'] as $value) {
            $sorted = $this->sort($value, $this->dataset['rules']);

            if ($value !== $sorted) {
                $result += $this->middleValue($sorted);
            }
        }

        return $result;
    }

    public function middleValue(array $value): int
    {
        return (int)$value[round(count($value) / 2) - 1];
    }

    public function sort($list, $rules): array
    {
        $ok = false;

        while (!$ok) {
            $nbok = 0;

            foreach ($rules as $rule) {
                if (!$this->isBefore($list, $rule[0], $rule[1])) {
                    $list = $this->moveBefore($list, $rule[0], $rule[1]);
                } else {
                    $nbok++;
                }
            }

            if ($nbok === count($rules)) {
                $ok = true;
            }
        }

        return $list;
    }

    public function moveBefore(array $data, string $r1, string $r2): array
    {
        $a = array_search($r1, $data, true);
        $b = array_search($r2, $data, true);

        $p1 = array_splice($data, $a, 1);
        $p2 = array_splice($data, 0, $b);
        return array_merge($p2, $p1, $data);
    }

    public function isBefore(array $data, string $r1, string $r2): bool
    {
        $a = array_search($r1, $data, true);
        $b = array_search($r2, $data, true);

        $va = $data[$a] ?? null;
        $vb = $data[$b] ?? null;

        if ((int)$va !== (int)$r1 || (int)$vb !== (int)$r2) {
            return true;
        }

        return $a < $b;
    }
}

$day = new Day5(__DIR__);
$day->run();
