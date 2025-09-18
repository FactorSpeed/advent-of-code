<?php

namespace Factor\Aoc\A2015\Day18;

enum Direction: string
{
    case N = 'N';
    case NE = 'NE';
    case E = 'E';
    case SE = 'SE';
    case S = 'S';
    case SW = 'SW';
    case W = 'W';
    case NW = 'NW';

    public function vector(): array
    {
        return match ($this) {
            self::N => [0, -1],
            self::NE => [1, -1],
            self::E => [1, 0],
            self::SE => [1, 1],
            self::S => [0, 1],
            self::SW => [-1, 1],
            self::W => [-1, 0],
            self::NW => [-1, -1],
        };
    }
}
