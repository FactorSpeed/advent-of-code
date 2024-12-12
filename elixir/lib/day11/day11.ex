defmodule Day11 do
  @moduledoc """
  Advent of Code 2024 - Day 11
  """

  defp read_file(path) do
    case File.read(path) do
      {:ok, content} -> get_dataset(String.replace(content, ~r/\r/, ""))
      _ -> :break
    end
  end

  def run do
    dataset_test = read_file('lib/day11/test.txt')
    dataset = read_file('lib/day11/input.txt')

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

  defp get_dataset(content) do
    String.split(content, " ", trim: true) |> Enum.map(&elem(Integer.parse(&1), 0))
  end

  defp transform(stone) do
    case stone do
      0 ->
        [1]

      n ->
        str_n = Integer.to_string(n)
        length = String.length(str_n)

        if rem(length, 2) == 0 do
          {left, right} = String.split_at(str_n, div(length, 2))
          [String.to_integer(left), String.to_integer(right)]
        else
          [n * 2024]
        end
    end
  end

  defp process(stones, 0), do: stones

  defp process(stones, blinks) do
    Enum.reduce(stones, %{}, fn {stone, count}, acc ->
      transform(stone)
      |> Enum.reduce(acc, fn s, acc2 ->
        Map.update(acc2, s, count, &(&1 + count))
      end)
    end)
    |> process(blinks - 1)
  end

  defp part1(dataset) do
    start(dataset, 25)
  end

  defp part2(dataset) do
    start(dataset, 75)
  end

  defp start(dataset, blinks) do
    dataset |> Enum.frequencies() |> process(blinks) |> Map.values() |> Enum.sum()
  end
end

Day11.run()
