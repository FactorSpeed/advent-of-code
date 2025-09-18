<?php

namespace Factor\Aoc\A2015\Day14;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day14 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            preg_match('#(\w+) can fly (\d+) km/s for (\d+) seconds, but then must rest for (\d+) seconds.#', $line, $matches);
            $dataset[] = array_slice($matches, 1);
        }

        $this->dataset = $dataset;
    }

    public function getName(array $line)
    {
        return $line[0];
    }

    public function getSpeed(array $line)
    {
        return $line[1];
    }

    public function getSpeedDuration(array $line)
    {
        return $line[2];
    }

    public function getRestTime(array $line)
    {
        return $line[3];
    }

    public function getState(int $seconds, array $line)
    {
        $speed = $this->getSpeed($line);
        $speedDuration = $this->getSpeedDuration($line);
        $restTime = $this->getRestTime($line);

        $t = $seconds % ($speedDuration + $restTime);

        if ($t > 0 && $t <= $speedDuration) {
            return $speed;
        }

        return 0;
    }

    public function part1(): int
    {
        $data = [];

        foreach ($this->dataset as $line) {
            $data[$this->getName($line)] = 0;
        }

        for ($i = 0; $i < 2503; $i++) {
            foreach ($this->dataset as $line) {
                $data[$this->getName($line)] += $this->getState($i + 1, $line);
            }
        }

        return max($data);
    }

    public function part2(): int
    {
        $data = [];
        $acc = [];

        foreach ($this->dataset as $line) {
            $data[$this->getName($line)] = 0;
            $acc[$this->getName($line)] = 0;
        }

        for ($i = 0; $i < 2503; $i++) {
            foreach ($this->dataset as $line) {
                $data[$this->getName($line)] += $this->getState($i + 1, $line);
            }

            $max = max($data);
            foreach($this->dataset as $line) {
                if ($max === $data[$this->getName($line)]) {
                    $acc[$this->getName($line)]++;
                }
            }
        }

        return max($acc);
    }
}

$day = new Day14(__DIR__);
$day->run();
