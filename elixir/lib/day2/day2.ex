defmodule Day2 do
  @moduledoc """
  Advent of Code 2024 - Day 2
  """

  def read_file(path) do
    case File.read(path) do
      {:ok, content} -> get_dataset(String.replace(content, ~r/\r/, ""))
      _ -> :break
    end
  end

  def run do
    dataset_test = read_file('lib/day2/test.txt')
    dataset = read_file('lib/day2/input.txt')

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

    dataset = []

    dataset =
      Enum.reduce(lines, dataset, fn line, n ->
        r =
          line
          |> String.split(~r/\s+/, trim: true)
          |> Enum.map(&String.to_integer/1)

        n ++ [r]
      end)

    dataset
  end

  def is_increase(line) do
    a = Enum.sort(line)
    a === line
  end

  def is_decrease(line) do
    a = Enum.sort(line, :desc)
    a === line
  end

  def check_line(line) do
    is_increase(line) or is_decrease(line)
  end

  def is_good(line) do
    if check_line(line) do
      ok =
        Enum.reduce_while(0..(length(line) - 2), true, fn i, acc ->
          diff = abs(Enum.at(line, i) - Enum.at(line, i + 1))

          if diff < 1 or diff > 3 do
            {:halt, false}
          else
            {:cont, acc}
          end
        end)

      ok
    else
      false
    end
  end

  def part1(dataset) do
    Enum.reduce(dataset, 0, fn line, acc ->
      if is_good(line) do
        acc + 1
      else
        acc
      end
    end)
  end

  def part2(dataset) do
    Enum.reduce(dataset, 0, fn line, acc ->
      if is_good(line) do
        acc + 1
      else
        Enum.reduce_while(0..(length(line) - 1), acc, fn i, acc_inner ->
          new_line = List.delete_at(line, i)

          if is_good(new_line) do
            {:halt, acc_inner + 1}
          else
            {:cont, acc_inner}
          end
        end)
      end
    end)
  end
end

Day2.run()
