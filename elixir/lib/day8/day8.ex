defmodule Day8 do
  @moduledoc """
  Advent of Code 2024 - Day 8
  """

  def read_file(path) do
    {status, content} = File.read(path)

    if status != :ok do
      :break
    end

    get_dataset(String.replace(content, ~r/\r/, ""))
  end

  def run do
    dataset_test = read_file('lib/day8/test.txt')
    dataset = read_file('lib/day8/input.txt')

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

      Enum.reduce(lines, [], fn line, n ->
        n ++ [String.graphemes(line)]
      end)
  end

  def combinations(list) do
    for x <- list, y <- list, x != y, do: [x, y]
  end

  def diff({x1, y1}, {x2, y2}) do
    {x1 - x2, y1 - y2}
  end

  def new_pos({x1, y1}, {x2, y2}) do
    {dx, dy} = diff({x1, y1}, {x2, y2})

    [
      {if x2 == dx + x1 do
         -1
       else
         dx + x1
       end,
       if y2 == dy + y1 do
         -1
       else
         dy + y1
       end},
      {if x1 == dx + x2 do
         -1
       else
         dx + x2
       end,
       if y1 == dy + y2 do
         -1
       else
         dy + y2
       end}
    ]
  end

  def process(acc_j, coord1, coord2, dataset) do
    Enum.reduce(new_pos(coord1, coord2), acc_j, fn {x, y}, acc_k ->
      if x >= 0 and x < length(dataset) and y >= 0 and y < length(Enum.at(dataset, 0)) do
        acc_k ++ [{x, y}]
      else
        acc_k
      end
    end)
  end

  def part1(dataset) do
    data =
      Enum.reduce(Enum.with_index(dataset), %{}, fn {row, i}, acc_i ->
        Enum.reduce(Enum.with_index(row), acc_i, fn {element, j}, acc_j ->
          if element != "." do
            Map.update(acc_j, element, [{i, j}], fn list -> [{i, j} | list] end)
          else
            acc_j
          end
        end)
      end)

    positions =
      Enum.reduce(data, [], fn {_key, coords}, acc_i ->
        Enum.reduce(combinations(coords), acc_i, fn [coord1, coord2], acc_j ->
          process(acc_j, coord1, coord2, dataset)
        end)
      end)

    Enum.uniq(positions) |> Enum.count()
  end

  def part2(_dataset) do
    0
  end
end

Day8.run()
