defmodule Day13 do
  @moduledoc """
  Advent of Code 2024 - Day 13
  """

  defp read_file(path) do
    case File.read(path) do
      {:ok, content} -> get_dataset(String.replace(content, ~r/\r/, ""))
      _ -> :break
    end
  end

  def run do
    dataset_test = read_file('lib/day13/test.txt')
    dataset = read_file('lib/day13/input.txt')

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
    content
    |> String.split(~r/\n\n/)
    |> Enum.map(fn a ->
      [
        "Button A: X" <> a,
        "Button B: X" <> b,
        "Prize: X=" <> prize
      ] = String.split(a, ~r/\n/)

      {ax, ", Y" <> a} = Integer.parse(a)
      {ay, _} = Integer.parse(a)

      {bx, ", Y" <> b} = Integer.parse(b)
      {by, _} = Integer.parse(b)

      {px, ", Y=" <> prize} = Integer.parse(prize)
      {py, _} = Integer.parse(prize)

      {ax, ay, bx, by, px, py}
    end)
  end

  defp part1(dataset) do
    dataset
    |> Enum.map(&insert_tokens/1)
    |> Enum.sum()
    |> round()
  end

  defp part2(dataset) do
    dataset
    |> Enum.map(&insert_tokens(&1, 10_000_000_000_000))
    |> Enum.sum()
  end

  defp insert_tokens({ax, ay, bx, by, px, py}, offset \\ 0) do
    px = px + offset
    py = py + offset

    a_tokens = (bx * py - by * px) / (ay * bx - ax * by)
    b_tokens = (px - a_tokens * ax) / bx
    tokens = 3 * a_tokens + b_tokens

    if tokens > 0 and
         rem(bx * py - by * px, ay * bx - ax * by) == 0 and
         rem(round(px - a_tokens * ax), bx) == 0 do
      round(tokens)
    else
      0
    end
  end
end

Day13.run()
