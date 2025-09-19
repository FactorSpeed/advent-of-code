<?php

namespace Factor\Aoc\A2015\Day21;

class Person
{
    public function __construct(
        public int $hitpoints = 0,
        public int $damage = 0,
        public int $armor = 0
    )
    {
    }

    public function hit(Person $p): void
    {
        $p->hitpoints -= max(0, $this->getDamages() - $p->getArmor());
    }

    public function isDead(): bool
    {
        return $this->hitpoints <= 0;
    }

    public function getDamages(): int
    {
        return $this->damage;
    }

    public function getArmor(): int
    {
        return $this->armor;
    }
}
