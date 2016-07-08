<?php
	require_once ("def.php");

	class DES
	{
		private $subkey;
		//public $subkey;

		public function generate_subkey($key)
		{
			$key = $this->swap_IPC($key);

			$cur_C = substr($key, 0, HALF_SUBKEY);
			$cur_D = substr($key, HALF_SUBKEY);

			for ($i = 0; $i < ITERATOR_COUNT; ++$i)
			{
				$times = DEF::$LS[$i];
				$next_C = $this->shift_L($cur_C, $times);
				$next_D = $this->shift_L($cur_D, $times);

				$cur_C = $next_C;
				$cur_D = $next_D;

				$this->subkey[$i] = $this->swap_PC($next_C .$next_D);
			}
		}

		private function shift_L($key, $times)
		{
			$right = substr($key, 0, $times);
			$left = substr($key, $times);

			return $left .$right;
		}

		public function encrypt($text)
		{
			$text = $this->swap_IP($text);

			$cur_L = substr($text, 0, HALF_TEXT);
			$cur_R = substr($text, HALF_TEXT);

			for ($iterator = 0; $iterator < ITERATOR_COUNT; ++$iterator)
			{
				$next_L = $cur_R;
				$next_R = DEF::str_xor($cur_L, $this->FK($cur_R, $this->subkey[$iterator]));
				$cur_R = $next_R;
				$cur_L = $next_L;
			}

			$text = $cur_L .$cur_R;
			$text = $this->swap_InvIP($text);
			return $text;
		}

		public function decrypt($text)
		{
			$text = $this->swap_IP($text);

			$cur_L = substr($text, 0, HALF_TEXT);
			$cur_R = substr($text, HALF_TEXT);

			for ($iterator = ITERATOR_COUNT - 1; $iterator >= 0; --$iterator)
			{
				$next_R = $cur_L;
				$next_L = DEF::str_xor($cur_R, $this->FK($cur_L, $this->subkey[$iterator]));
				$cur_R = $next_R;
				$cur_L = $next_L;
			}

			$text = $cur_L .$cur_R;
			$text = $this->swap_InvIP($text);
			return $text;
		}

		private function FK($text, $key)
		{
			$text = $this->swap_E($text);
			$text = DEF::str_xor($text, $key);

			$text = $this->substitute($text);
			$text = $this->swap_P($text);
			return $text;
		}

		private function substitute($text)
		{
			$result = '';
			for ($index = 0, $i = 0; $i < 8; $index += 6, ++$i)
			{
				$temp = substr($text, $index, 6);
				$x = DEF::bin2dec(substr($temp, 1, 4));
				$y = DEF::bin2dec($temp[0] .$temp[5]);

				$result .= DEF::dec2bin(DEF::$SBox[$i][$y][$x]);
			}
			return $result;
		}

		private function swap($text, $array, $length)
		{
			$temp = '';
			for ($index = 0; $index < $length; ++$index)
			{
				$temp .= $text[$array[$index]];
			}
			return $temp;
		}

		private function swap_IPC($text)
		{
			return $this->swap($text, DEF::$IPC, IPC_LENGTH);
		}

		private function swap_PC($text)
		{
			return $this->swap($text, DEF::$PC, PC_LENGTH);
		}

		private function swap_IP($text)
		{
			return $this->swap($text, DEF::$IP, IP_LENGTH);
		}

		private function swap_InvIP($text)
		{
			return $this->swap($text, DEF::$InvIP, IP_LENGTH);
		}

		private function swap_E($text)
		{
			return $this->swap($text, DEF::$E, E_LENGTH);
		}

		private function swap_P($text)
		{
			return $this->swap($text, DEF::$P, P_LENGTH);
		}
	}
?>