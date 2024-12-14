<?php

namespace Factor\Aoc\A2024\Day9;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day9 extends AdventOfCode
{
    public function readDataset(): void
    {
        $this->dataset = str_split(trim(str_replace("\n", "", file($this->file)[0])));
    }

    public function part1(): int
    {
        $dataset = [];

        $j = 0;

        foreach ($this->dataset as $i => $iValue) {
            $value = (int)$iValue;
            if ($i % 2 === 0) {
                for ($n = 0; $n < $value; $n++) {
                    $dataset[] = (string)$j;
                }
                $j++;
            } else {
                $dataset = [...$dataset, ...str_split(str_repeat('.', $value))];
            }
        }

        foreach ($dataset as $i => $iValue) {
            if ($iValue === '.') {
                $a = null;
                for ($j = count($dataset) - 1; $j > 0; $j--) {
                    if ($dataset[$j] !== '.') {
                        $a = $dataset[$j];
                        break;
                    }
                }

                if ($a !== null && $j > $i) {
                    $dataset[$i] = $a;
                    $dataset[$j] = '.';
                }
            }
        }

        $result = 0;

        foreach ($dataset as $key => $value) {
            $result += $key * (int)$value;
        }

        return $result;
    }

    public function part2(): int
    {
        $dataset = implode('', $this->dataset);
        $chunks = [];

        for ($i = 0, $loopsMax = strlen($dataset); $i * 2 < $loopsMax; $i++) {
            $j = $i * 2;

            [$k, $l] = [$dataset[$j], $dataset[$j + 1] ?? 0];

            if ($k) {
                $chunks[] = [$i, $k];
            }

            if ($l) {
                $chunks[] = [".", $l];
            }
        }

        for ($i = count($chunks) - 1; $i > 0; $i--) {
            $r = $chunks[$i];
            [$right_block, $right_length] = $r;

            if ($right_block === ".") {
                continue;
            }

            for ($j = 0; $j < $i; $j++) {
                $l = $chunks[$j];
                [$left_block, $left_length] = $l;

                if ($left_block !== "." || $left_length < $right_length) {
                    continue;
                }

                $chunks[$i] = $l;
                $chunks[$j] = $r;

                if ($extra_length = $left_length - $right_length) {
                    $chunks[$i] = [$left_block, $right_length];
                    $chunks = [
                        ...array_slice($chunks, 0, $j + 1),
                        [$left_block, $extra_length],
                        ...array_slice($chunks, $j + 1),
                    ];

                    $i++;
                }

                break;
            }
        }

        $result = 0;
        $i = 0;

        foreach ($chunks as $chunk) {
            [$chunk_block, $chunk_length] = $chunk;
            for ($j = 0; $j < $chunk_length; $j++, $i++) {
                $result += $i * (int)$chunk_block;
            }
        }

        return $result;
    }
}

$day = new Day9(__DIR__);
$day->run();
