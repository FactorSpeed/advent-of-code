<?php

namespace Factor\Aoc\A2015\Day21;

class Item
{
    public const string WEAPON = 'WEAPON';
    public const string ARMOR = 'ARMOR';
    public const string RING = 'RING';

    public function __construct(
        public string $type = '',
        public string $name = '',
        public int    $cost = 0,
        public int    $damage = 0,
        public int    $armor = 0
    )
    {
    }
}
