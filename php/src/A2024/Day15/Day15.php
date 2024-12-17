<?php

namespace Factor\Aoc\A2024\Day15;

require __DIR__ . '/../../AdventOfCode.php';

use Factor\Aoc\AdventOfCode;

class Day15 extends AdventOfCode
{
    public function readDataset(): void
    {
        $dataset = [
            'init' => [],
            'moves' => []
        ];

        foreach (file($this->file) as $line) {
            if (trim($line) === '') {
                continue;
            }

            if (str_starts_with($line, '#')) {
                $dataset['init'][] = str_split(trim($line));
            } else {
                $dataset['moves'] = array_merge($dataset['moves'], str_split(trim($line)));
            }
        }

        $this->dataset = $dataset;
        $this->dataset['grid'] = $this->dataset['init'];
        $this->dataset['grid2'] = $this->dataset['init'];
    }

    public function getVector(string $move): array
    {
        return match ($move) {
            '^' => [-1, 0],
            '>' => [0, 1],
            'v' => [1, 0],
            '<' => [0, -1]
        };
    }

    public function getRowColPart1(array $dataset): array
    {
        return [count($dataset['grid']), count($dataset['grid'][0])];
    }

    public function getRobotPart1(array $dataset): array
    {
        [$row, $col] = $this->getRowColPart1($dataset);

        for ($i = 0; $i < $row; $i++) {
            for ($j = 0; $j < $col; $j++) {
                if ($dataset['grid'][$i][$j] === '@') {
                    return [$i, $j];
                }
            }
        }

        return [null, null];
    }

    public function resultPart1(array $dataset): int
    {
        [$row, $col] = $this->getRowColPart1($dataset);

        $result = 0;

        for ($i = 0; $i < $row; $i++) {
            for ($j = 0; $j < $col; $j++) {
                if ($dataset['grid'][$i][$j] === 'O') {
                    $result += 100 * $i + $j;
                }
            }
        }

        return $result;
    }

    public function canMovePart1(array $robot, string $move, array $dataset): bool
    {
        [$nx, $ny] = $robot;
        [$vx, $vy] = $this->getVector($move);

        $can = null;

        while ($can === null) {
            [$nx, $ny] = [$nx + $vx, $ny + $vy];

            if ($dataset['grid'][$nx][$ny] === '#') {
                $can = false;
                break;
            }

            if ($dataset['grid'][$nx][$ny] === '.') {
                $can = true;
                break;
            }
        }

        return $can;
    }

    public function moveRobotPart1(array &$robot, string $move, array &$dataset): void
    {
        [$x, $y] = $robot;
        [$vx, $vy] = $this->getVector($move);

        $points = [];

        while (true) {
            $char = $dataset['grid'][$x][$y];

            if ($char === '#') {
                break;
            }

            if ($char === '@' || $char === 'O') {
                [$nx, $ny] = [$x + $vx, $y + $vy];

                $points[] = [
                    'char' => $char,
                    'x' => $x,
                    'y' => $y,
                    'nx' => $nx,
                    'ny' => $ny
                ];

                [$x, $y] = [$nx, $ny];
            }

            if ($char === '.') {
                break;
            }
        }

        foreach ($points as $key => $point) {
            if ($key === 0) {
                $dataset['grid'][$point['x']][$point['y']] = '.';
                $robot = [$point['nx'], $point['ny']];
            }

            $dataset['grid'][$point['nx']][$point['ny']] = $point['char'];
        }
    }

    public function part1(): int
    {
        $dataset = $this->dataset;

        $moves = $dataset['moves'];

        $robot = $this->getRobotPart1($dataset);

        foreach ($moves as $move) {
            if (!$this->canMovePart1($robot, $move, $dataset)) {
                continue;
            }

            $this->moveRobotPart1($robot, $move, $dataset);
        }

        return $this->resultPart1($dataset);
    }

    public function getRowColPart2(array $dataset): array
    {
        return [count($dataset['grid2']), count($dataset['grid2'][0])];
    }

    public function getRobotPart2(array $dataset): array
    {
        [$row, $col] = $this->getRowColPart2($dataset);

        for ($i = 0; $i < $row; $i++) {
            for ($j = 0; $j < $col; $j++) {
                if ($dataset['grid2'][$i][$j] === '@') {
                    return [$i, $j];
                }
            }
        }

        return [null, null];
    }

    public function resultPart2(array $dataset): int
    {
        [$row, $col] = $this->getRowColPart2($dataset);

        $result = 0;

        for ($i = 0; $i < $row; $i++) {
            for ($j = 0; $j < $col; $j++) {
                if ($dataset['grid2'][$i][$j] === '[') {
                    $result += 100 * $i + $j;
                }
            }
        }

        return $result;
    }

    public function prepareGrid2(): void
    {
        $dataset = [];

        [$row, $col] = $this->getRowColPart1($this->dataset);

        for ($i = 0; $i < $row; $i++) {
            for ($j = 0; $j < $col; $j++) {
                if ($this->dataset['init'][$i][$j] === '#') {
                    $dataset[$i][] = '#';
                    $dataset[$i][] = '#';
                    continue;
                }

                if ($this->dataset['init'][$i][$j] === 'O') {
                    $dataset[$i][] = '[';
                    $dataset[$i][] = ']';
                    continue;
                }

                if ($this->dataset['init'][$i][$j] === '.') {
                    $dataset[$i][] = '.';
                    $dataset[$i][] = '.';
                    continue;
                }

                if ($this->dataset['init'][$i][$j] === '@') {
                    $dataset[$i][] = '@';
                    $dataset[$i][] = '.';
                }
            }
        }

        $this->dataset['grid2'] = $dataset;
    }

    public function part2(): int
    {
        $this->prepareGrid2();

        $dataset = $this->dataset;

        $moves = $dataset['moves'];

        $robot = $this->getRobotPart2($dataset);

        foreach ($moves as $i => $move) {
            if (!$this->canMovePart2($robot, $move, $dataset)) {
                continue;
            }

            $this->moveRobotPart2($robot, $move, $dataset);
        }

        return $this->resultPart2($dataset);
    }

    public function canMovePart2(array $point, string $move, array $dataset): bool
    {
        $can = true;
        $this->recursiveCanMovePart2($point, $move, $dataset, $can);
        return $can;
    }

    public function recursiveCanMovePart2(array $point, string $move, array $dataset, bool &$can): void
    {
        [$x, $y] = $point;
        [$vx, $vy] = $this->getVector($move);

        $char = $dataset['grid2'][$x][$y];

        $isVertical = abs($vx) > 0;

        if ($char === '#') {
            return;
        }

        while (true) {
            [$nx, $ny] = [$x + $vx, $y + $vy];
            $char = $dataset['grid2'][$nx][$ny];

            if ($char === '#') {
                $can = false;
                break;
            }

            if ($char === '.') {
                break;
            }

            if ($isVertical) {
                if ($char === '[') {
                    $this->recursiveCanMovePart2([$nx, $ny + 1], $move, $dataset, $can);
                }

                if ($char === ']') {
                    $this->recursiveCanMovePart2([$nx, $ny - 1], $move, $dataset, $can);
                }
            }

            [$x, $y] = [$nx, $ny];
        }
    }

    private function moveRobotPart2(array &$robot, mixed $move, array &$dataset): void
    {
        [$x, $y] = $robot;
        [$vx, $vy] = $this->getVector($move);

        $points = [];

        $visited = ',';

        $this->getRecursivePointsPart2($x, $y, $vx, $vy, $dataset, $points, $visited);

        foreach ($points as $key => $point) {
            $dataset['grid2'][$point['x']][$point['y']] = '.';

            if ($key === 0) {
                $robot = [$point['nx'], $point['ny']];
            }
        }

        foreach ($points as $key => $point) {
            $dataset['grid2'][$point['nx']][$point['ny']] = $point['char'];
        }
    }

    private function getRecursivePointsPart2($x, $y, $vx, $vy, array $dataset, array &$points, string &$visited): void
    {
        $isVertical = abs($vx) > 0;

        while (true) {
            $char = $dataset['grid2'][$x][$y];

            [$nx, $ny] = [$x + $vx, $y + $vy];

            if (str_contains($visited, ',' . $x . '|' . $y . '|' . ',')) {
                break;
            }

            $visited .= $x . '|' . $y . '|' . ',';

            if ($dataset['grid2'][$x][$y] === '#' || $dataset['grid2'][$x][$y] === '.') {
                break;
            }

            if ($dataset['grid2'][$x][$y] === '@' || $dataset['grid2'][$x][$y] === '[' || $dataset['grid2'][$x][$y] === ']') {
                $points[] = [
                    'char' => $char,
                    'x' => $x,
                    'y' => $y,
                    'nx' => $nx,
                    'ny' => $ny
                ];

                if ($isVertical) {
                    if ($char === '[') {
                        $this->getRecursivePointsPart2($x, $y + 1, $vx, $vy, $dataset, $points, $visited);
                    }

                    if ($char === ']') {
                        $this->getRecursivePointsPart2($x, $y - 1, $vx, $vy, $dataset, $points, $visited);
                    }
                }
            }

            [$x, $y] = [$nx, $ny];
        }
    }
}

$day = new Day15(__DIR__);
$day->run();
