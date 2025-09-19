<?php

namespace Factor\Aoc\A2015\Day21;

class Player extends Person
{
    public array $items = [];

    public function buy(Item $item): static
    {
        if (!in_array($item, $this->items, true)) {
            $this->items[] = $item;
        }
        return $this;
    }

    public function getGolds(): int
    {
        return array_reduce($this->items, static fn ($a, Item $b) => $a + $b->cost, 0);
    }

    public function getDamages(): int
    {
        return $this->damage + array_reduce($this->items, static fn ($a, Item $b) => $a + $b->damage, 0);
    }

    public function getArmor(): int
    {
        return $this->armor + array_reduce($this->items, static fn ($a, Item $b) => $a + $b->armor, 0);
    }
}
