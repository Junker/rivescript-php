<?php

namespace Axiom\Rivescript\Support;

class Arr
{
	public static function weightedRandom(array $values, array $weights)
	{
		$total = array_sum($weights);
		$n = 0;

		$num = mt_rand(0, $total);

		foreach ($values as $i => $value)
		{
			$n += $weights[$i];

			if ($n >= $num)
			{
				return $values[$i];
			}
		}
	}
}