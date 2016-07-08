<?php

	require_once ("def.php");

	function isPrime_M_R_bin($n)
	{
		$dec_n = DEF::BinToDec($n);
		$length = strlen($n);

		$k = 0;
		$m = bcsub($dec_n, 1);
		while(bcmod($m, 2) != 0)
		{
			++$k;
			$m = bcdiv($m, 2);
		}
		$a = DEF::random_dec($length - 1);
		$b = DEF::modular_exponentiation($a, $m, $dec_n);
		if ($b == 1)
			return true;
		for ($i = 0; $i < $k; ++$i)
		{
			if (bccomp(bcsub($dec_n, 1), $b) == 0)
				return true;
			$b = bcmod(bcmul($b, $b), $dec_n);
		}
		return false;
	}

	function random_prime()
	{
		$flag = true;
		$s_time = microtime(true);
		while (1)
		{
			$p = DEF::random_bin_64();
			$i = 0;

			if (!isPrime_M_R_bin($p))
				continue;

			for (; $i < TEST_M_R_COUNT; ++$i)
			{
				if (!isPrime_M_R_bin($p))
					break;
			}

			if ($i == TEST_M_R_COUNT)
				return DEF::BinToDec($p);

			$c_time = microtime(true);
			if (($c_time - $s_time) > TIME_OUT)
				break;
		}
		return '';
	}

	function generate_rsa_key()
	{
		$s_time = microtime(true);
		while (1)
		{
			$c_time = microtime(true);
			if (($c_time - $s_time) > TIME_OUT)
				break;

			$p = random_prime();
			if ($p == '')
				continue;
			$q = random_prime();
			if ($q == '')
				continue;

			$n = bcmul($p, $q);
			$euler_n = bcmul(bcsub($p, 1), bcsub($q, 1));

			$e = 65537;
			if (bcmod($euler_n, $e) == 0)
				continue;

			$d = DEF::extendedGCD($e, $euler_n);

			$n_bin = DEF::DecToBin($n);
			$public_key = $n_bin .'10000000000000001';
			$private_key = $n_bin .DEF::DecToBin($d);

			return array("public_key" => $public_key, "private_key" => $private_key);
		}
		return false;
	}
?>