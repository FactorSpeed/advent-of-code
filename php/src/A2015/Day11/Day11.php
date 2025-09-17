<?php

namespace Factor\Aoc\A2015\Day11;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day11 extends AdventOfCode
{
    public function readDataset(): void
    {
//        $this->dataset = 'abcdefgh';
        $this->dataset = 'hepxcrrq';
    }

    public function hasntLetters(string $data): bool
    {
        return !preg_match("/[iol]/", $data);
    }

    public function hasThreeSuccessive(string $data): bool
    {
        $chunks = str_split($data);
        $chunksLength = count($chunks);

        for ($i = 0; $i < $chunksLength - 2; $i++) {
            if (
                ord($chunks[$i]) === ord($chunks[$i+1]) - 1 &&
                ord($chunks[$i]) === ord($chunks[$i+2]) - 2
            ) {
                return true;
            }
        }

        return false;
    }

    public function hasTwoConsecutive(string $data): bool
    {
        $chunks = str_split($data);
        $chunksLength = count($chunks);

        $overlapps = [];

        for ($i = 0; $i < $chunksLength - 1; $i++) {
            if (ord($chunks[$i]) === ord($chunks[$i+1])) {
                $overlapps[] = $chunks[$i];
            }
        }

        return count(array_values(array_unique($overlapps))) > 1;
    }

    public function isGood(string $data): bool
    {
        return $this->hasntLetters($data)
            && $this->hasThreeSuccessive($data)
            && $this->hasTwoConsecutive($data);
    }

    public function iterate(string $data): string
    {
        while (true) {
            $data = str_increment($data);

            if ($this->isGood($data)) {
                break;
            }
        }

        return $data;
    }

    public function part1(): string
    {
        return $this->iterate($this->dataset);
    }

    public function part2(): string
    {
        return $this->iterate($this->iterate($this->dataset));
    }
}

$day = new Day11(__DIR__);
$day->run();
