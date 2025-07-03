<?php

namespace Factor\Aoc\A2015\Day7;

require __DIR__ . '/../../AdventOfCode.php';
require_once __DIR__ . '/Operator.php';

use Factor\Aoc\AdventOfCode;

class Day7 extends AdventOfCode
{
    public function __construct(?string $file = null, public int $result_part_1 = 0)
    {
        parent::__construct($file);
    }

    public function readDataset(): void
    {
        $dataset = [];

        foreach (file($this->file) as $line) {
            $parameters = [];

            preg_match('/(.*) -> (\w+)/', trim($line), $instructions);

            [$left, $parameters['output']] = [$instructions[1], $instructions[2]];

            if (ctype_digit($left)) {
                $parameters['operator'] = 'ASSIGN';
                $parameters['input'] = (int)$left;
                goto end;
            }

            preg_match('/(NOT) (\w+)/', $left, $instructions);
            if (count($instructions) > 0) {
                [$parameters['operator'], $parameters['input']] = [$instructions[1], $instructions[2]];
                goto end;
            }

            preg_match('/(\w+) (AND|OR|RSHIFT|LSHIFT) (\w+)/', $left, $instructions);
            if (count($instructions) > 0) {
                [$input1, $operator, $input2] = [$instructions[1], $instructions[2], $instructions[3]];
                $parameters['operator'] = $operator;
                $parameters['input1'] = ctype_digit($input1) ? (int)$input1 : $input1;
                $parameters['input2'] = ctype_digit($input2) ? (int)$input2 : $input2;

            } else {
                $parameters['operator'] = 'ASSIGN';
                $parameters['input'] = $left;
            }
            goto end;

            end:
            $parameters['operator'] = Operator::tryFrom($parameters['operator']);
            $dataset[] = $parameters;
        }

        $this->dataset = $dataset;
    }

    public function val(array $assigns, mixed $val)
    {
        return $assigns[$val] ?? $val;
    }

    private function evaluateInstruction(array $instruction, array $assigns): ?int
    {
        switch ($instruction['operator']) {
            case Operator::NOT:
                $a = $this->val($assigns, $instruction['input']);
                return is_int($a) ? (65535 - $a) : null;

            case Operator::AND:
            case Operator::OR:
            case Operator::LSHIFT:
            case Operator::RSHIFT:
                $a = $this->val($assigns, $instruction['input1']);
                $b = $this->val($assigns, $instruction['input2']);
                if (!is_int($a) || !is_int($b)) {
                    return null;
                }
                return match ($instruction['operator']) {
                    Operator::AND => $a & $b,
                    Operator::OR => $a | $b,
                    Operator::LSHIFT => $a << $b,
                    Operator::RSHIFT => $a >> $b,
                };

            case Operator::ASSIGN:
                $a = $this->val($assigns, $instruction['input']);
                return is_int($a) ? $a : null;

            default:
                return null;
        }
    }

    public function exec(array $data, array &$assigns): void
    {
        while (count($data) > 0) {
            foreach ($data as $i => $instruction) {
                $result = $this->evaluateInstruction($instruction, $assigns);

                if ($result !== null) {
                    $assigns[$instruction['output']] = $result;
                    unset($data[$i]);
                }
            }
        }
    }

    public function part1(): int
    {
        $assigns = [];
        $data = $this->dataset;

        $this->exec($data, $assigns);

        $this->result_part_1 = $assigns['a'];
        return $assigns['a'];
    }

    public function part2(): int
    {
        $assigns = [];
        $data = $this->dataset;

        $b = array_search('b', array_column($data, 'output'), true);
        $data[$b]['input'] = $this->result_part_1;

        $this->exec($data, $assigns);

        return $assigns['a'];
    }
}

$day = new Day7(__DIR__);
$day->run();
