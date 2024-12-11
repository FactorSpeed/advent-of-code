defmodule Day10 do
  @moduledoc """
  Advent of Code 2024 - Day 10
  """

  require Direction

  def read_file(path) do
    case File.read(path) do
      {:ok, content} -> get_dataset(String.replace(content, ~r/\r/, ""))
      _ -> :break
    end
  end

  def run do
    dataset_test = read_file('lib/day10/test.txt')
    dataset = read_file('lib/day10/input.txt')

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
    String.split(content, "\n", trim: true)
    |> Enum.map(fn line ->
      line
      |> String.graphemes()
      |> Enum.map(&elem(Integer.parse(&1), 0))
    end)
  end

  def cell(dataset, [i, j]) do
    if i < 0 or j < 0 or i >= length(dataset) or j >= length(Enum.at(dataset, 0, [])) do
      nil
    else
      Enum.at(Enum.at(dataset, i), j)
    end
  end

  def process1(dataset, [i, j], visited) do
    if MapSet.member?(visited, {i, j}) do
      visited
    else
      visited = MapSet.put(visited, {i, j})

      current = cell(dataset, [i, j])

      if current == 9 do
        visited
      else
        Enum.reduce(Direction.directions(), visited, fn direction_fn, acc ->
          neighbor_pos = direction_fn.(i, j)
          neighbor = cell(dataset, neighbor_pos)

          if neighbor == current + 1 do
            process1(dataset, neighbor_pos, acc)
          else
            acc
          end
        end)
      end
    end
  end

  def process2(dataset, [i, j], acc) do
    Enum.reduce(Direction.directions(), acc, fn direction_fn, acc ->
      current = cell(dataset, [i, j])
      neighbor_pos = direction_fn.(i, j)
      neighbor = cell(dataset, neighbor_pos)

      if neighbor == current + 1 do
        if neighbor == 9 do
          acc + 1
        else
          process2(dataset, neighbor_pos, acc)
        end
      else
        acc
      end
    end)
  end

  def part1(dataset) do
    Enum.reduce(Enum.with_index(dataset), 0, fn {row, i}, acc ->
      Enum.reduce(Enum.with_index(row), acc, fn {cell, j}, acc ->
        if cell == 0 do
          visited = process1(dataset, [i, j], MapSet.new())
          acc + Enum.count(visited, fn {x, y} -> cell(dataset, [x, y]) == 9 end)
        else
          acc
        end
      end)
    end)
  end

  def part2(dataset) do
    data = Enum.reduce(Enum.with_index(dataset), 0, fn {row, i}, acc ->
      Enum.reduce(Enum.with_index(row), acc, fn {cell, j}, acc ->
        if cell == 0 do
          process2(dataset, [i, j], acc)
        else
          acc
        end
      end)
    end)

    data
  end
end

Day10.run()
