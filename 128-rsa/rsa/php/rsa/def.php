<?php
	define("TEST_M_R_COUNT", 100);
	define("TIME_OUT", 10);

	class DEF
	{
		public static function random_bin_64()
		{
			$low = decbin(mt_rand(0, (1 << 31) - 1));
			$length = strlen($low);
			for ($i = 31; $i > $length; --$i)
				$low = '0' .$low;
			$low .= '1';
			$high = decbin(mt_rand(0, (1 << 30) - 1));
			$length = strlen($high);
			for ($i = 30; $i > $length; --$i)
				$high = '0' .$high;
			return '11' .$high .$low;
		}

		public static function random_dec($length)
		{
			$res = '';
			for (; $length > 32; $length -= 32)
			{
				$current = decbin(mt_rand(1, (1 << 32) - 1));
				$current_length = strlen($current);
				for ($i = 31; $i > $current_length; --$i)
					$current = '0' .$current;
				$res .= $current;
			}
			$res .= decbin(mt_rand(1, (1 << $length) - 1));
			return DEF::BinToDec($res);
		}

		public static function extendedGCD($e, $euler_n)
		{
			$original_euler_n = $euler_n;
	        $b = '0';
			$d = '1';

			while (bccomp($e, '0', 0) != 0)
			{
				$q = bcdiv($euler_n, $e, 0);

				$temp = $euler_n;
				$euler_n = $e;
				$e = bcsub($temp, bcmul($e, $q, 0), 0);

				$temp = $b;
				$b = $d;
				$d = bcsub($temp, bcmul($b, $q, 0), 0);
	        }
	        if ($b[0] == '-')
	        {
	        	do {
	        		$b = bcadd($b, $original_euler_n);
	        	} while (bccomp($b, 0) < 0);
	        }
	        return $b;
		}

		public static function modular_exponentiation($a, $b, $n)
		{
			$decb = DEF::DecToBin($b);
			$length = strlen($decb);
			$remainder = '1';

			for ($index = $length - 1; $index >= 0; --$index)
			{
				if ($decb[$index] == '1')
					$remainder = bcmod(bcmul($a, $remainder), $n);
				$a = bcmod(bcmul($a, $a), $n);
			}
			return $remainder;
			// return bcpowmod($a, $b, $n);
		}

		public static function DecToBin($number)
		{
			$res = '';
			while ($number != 0)
			{
				$res = bcmod($number, '2') .$res;
				$number = bcdiv($number, 2);
			}
			if ($res == '')
				return '0';
			return $res;
		}

		public static function BinToDec($number)
		{
			$res = '0';
			$length = strlen($number);
			for ($index = $length - 1; $index >= 0; --$index)
			{
				if ($number[$index] == '1')
					$res = bcadd(bcpow(2, ($length - $index - 1)), $res);
			}
			return $res;
		}
	}
?>