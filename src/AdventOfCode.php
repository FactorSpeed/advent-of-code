<?php

namespace Factor\Aoc;

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Output\ConsoleOutput;

class AdventOfCode
{
    public string $file;
    public array|string $dataset;

    private ?ConsoleOutput $output;

    public function __construct(?string $file = null)
    {
        $this->file = $file;
        $this->output = new ConsoleOutput();
    }

    public function run(): void
    {
        $this->readDataset();

        $this->output->writeln('<fg=#f00>Part 1 : ' . $this->part1() . '</>');
        $this->output->writeln('<fg=#f00>Part 2 : ' . $this->part2() . '</>');
    }

    public function part1(): mixed
    {
        return null;
    }

    public function part2(): mixed
    {
        return null;
    }

    public function readDataset(): void
    {
    }
}
