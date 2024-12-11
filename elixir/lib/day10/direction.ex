defmodule Direction do
  @moduledoc false

  def directions do
    [&n/2, &e/2, &s/2, &w/2]
  end

  def n(i, j), do: [i - 1, j]
  def e(i, j), do: [i, j + 1]
  def s(i, j), do: [i + 1, j]
  def w(i, j), do: [i, j - 1]
end
