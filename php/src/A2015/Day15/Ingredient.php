<?php

namespace Factor\Aoc\A2015\Day15;

class Ingredient
{
    public function __construct(
        public string $name = '',
        public int $capacity = 0,
        public int $durability = 0,
        public int $flavor = 0,
        public int $texture = 0,
        public int $calories = 0,
    )
    {
    }
}
