<?php

namespace Factor\Aoc\A2024\Day12;

enum Direction: string
{
    case N = 'N';
    case E = 'E';
    case S = 'S';
    case W = 'W';

    public function neighbor(): array
    {
        return match ($this) {
            self::N => [-1, 0],
            self::E => [0, 1],
            self::S => [1, 0],
            self::W => [0, -1]
        };
    }
}
