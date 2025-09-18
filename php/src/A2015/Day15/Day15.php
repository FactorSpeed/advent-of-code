<?php

namespace Factor\Aoc\A2015\Day15;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\A2015\Itertools;
use Factor\Aoc\AdventOfCode;

class Day15 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            preg_match('#(\w+): capacity (-?\d+), durability (-?\d+), flavor (-?\d+), texture (-?\d+), calories (-?\d+)#', $line, $matches);
            $dataset[] = new Ingredient(...array_slice($matches, 1));
        }

        $this->dataset = $dataset;
    }

    public function getScore(array $c): array
    {
        $score = ['capacity' => 0, 'durability' => 0, 'flavor' => 0, 'texture' => 0, 'calories' => 0];

        $len = count($c);

        for ($i = 0; $i < $len; $i++) {
            $score['capacity'] += $c[$i] * $this->dataset[$i]->capacity;
            $score['durability'] += $c[$i] * $this->dataset[$i]->durability;
            $score['flavor'] += $c[$i] * $this->dataset[$i]->flavor;
            $score['texture'] += $c[$i] * $this->dataset[$i]->texture;
            $score['calories'] += $c[$i] * $this->dataset[$i]->calories;
        }

        $score['capacity'] = max($score['capacity'], 0);
        $score['durability'] = max($score['durability'], 0);
        $score['flavor'] = max($score['flavor'], 0);
        $score['texture'] = max($score['texture'], 0);
        $score['calories'] = max($score['calories'], 0);

        return $score;
    }

    public function calculScore(array $score)
    {
        $last = array_pop($score);

        return array_reduce($score, static fn($a, $b) => $a * $b, $last);
    }

    public function part1(): int
    {
        $scores = [];

        /** @var \Factor\Aoc\A2015\Day15\Ingredient $d */
        foreach (new Itertools()->compositions(100, count($this->dataset)) as $c) {
            $score = $this->getScore($c);

            array_pop($score);

            $scores[] = $this->calculScore($score);
        }

        return max($scores);
    }

    public function part2(): int
    {
        $scores = [];

        /** @var \Factor\Aoc\A2015\Day15\Ingredient $d */
        foreach (new Itertools()->compositions(100, count($this->dataset)) as $c) {
            $score = $this->getScore($c);

            $calories = array_pop($score);

            if ($calories !== 500) {
                continue;
            }

            $scores[] = $this->calculScore($score);
        }

        return max($scores);
    }
}

$day = new Day15(__DIR__);
$day->run();
