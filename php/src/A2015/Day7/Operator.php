<?php

namespace Factor\Aoc\A2015\Day7;

enum Operator: string
{
    case ASSIGN = 'ASSIGN';
    case NOT = 'NOT';
    case AND = 'AND';
    case OR = 'OR';
    case RSHIFT = 'RSHIFT';
    case LSHIFT = 'LSHIFT';
}
