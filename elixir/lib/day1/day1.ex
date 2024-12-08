defmodule Day1 do
  @moduledoc """
  Advent of Code 2024 - Day 1
  """

  def read_file(path) do
    {status, content} = File.read(path)

    if status != :ok do
      :break
    end

    get_dataset(String.replace(content, ~r/\r/, ""))
  end

  def run do
    dataset_test = read_file('lib/day1/test.txt')
    dataset = read_file('lib/day1/input.txt')

    {time_test1, result_test1} = :timer.tc(fn -> part1(dataset_test) end)
    {time1, result1} = :timer.tc(fn -> part1(dataset) end)
    {time_test2, result_test2} = :timer.tc(fn -> part2(dataset_test) end)
    {time2, result2} = :timer.tc(fn -> part2(dataset) end)

    IO.puts("#{IO.ANSI.light_white()}")
    IO.puts("#{IO.ANSI.red()}[DEMO] Part 1: #{time_format(time_test1)}s #{result_test1}")
    IO.puts("#{IO.ANSI.red()}[REAL] Part 1: #{time_format(time1)}s #{result1}")
    IO.puts("#{IO.ANSI.red()}[DEMO] Part 2: #{time_format(time_test2)}s #{result_test2}")
    IO.puts("#{IO.ANSI.red()}[REAL] Part 2: #{time_format(time2)}s #{result2}")
    IO.puts("#{IO.ANSI.light_white()}")
  end

  defp time_format(seconds) do
    :io_lib.format("~.6f", [seconds / 1_000_000]) |> List.to_string()
  end

  def get_dataset(content) do
    lines = String.split(content, "\n", trim: true)

    dataset =
      Enum.reduce(lines, [[], []], fn line, [n, m] ->
        [x, y] =
          line
          |> String.split(~r/\s+/, trim: true)
          |> Enum.map(&String.to_integer/1)

        [n ++ [x], m ++ [y]]
      end)

    dataset =
      Enum.map(dataset, fn line ->
        Enum.sort(line)
      end)

    dataset
  end

  def part1(dataset) do
    dataset
    |> Enum.zip()
    |> Enum.map(fn {a, b} -> abs(a - b) end)
    |> Enum.sum()
  end

  def part2(dataset) do
    Enum.reduce(dataset |> Enum.at(0), 0, fn v, acc ->
      count = Enum.count(dataset |> Enum.at(1), fn b -> b == v end)
      acc + count * v
    end)
  end
end

Day1.run()
