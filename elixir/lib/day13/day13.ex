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

      {ax, bx, px, ay, by, py}
    end)
  end

  defp part1(dataset) do
    dataset |> Enum.map(&solve/1) |> Enum.sum()
  end

  defp part2(dataset) do
    dataset |> Enum.map(&solve(&1, 10_000_000_000_000)) |> Enum.sum()
  end

  defp solve({a, b, e, c, d, f}, offset \\ 0) do
    e = e + offset
    f = f + offset

    den = a * d - b * c
    nomx = e * d - b * f
    nomy = a * f - e * c

    x = div(nomx, den)
    y = div(nomy, den)

    u = a * x + b * y
    v = c * x + d * y

    if u === e and v === f do
      x * 3 + y
    else
      0
    end
  end
end

Day13.run()
