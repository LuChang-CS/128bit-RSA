<?php
	require_once ("des.php");

	class CBC
	{
		public function encrypt($text, $key)
		{
			$length = strlen($text);
			$section_num = floor($length / TEXT_LENGTH) + 1;
			$remain_bit_num = $length % TEXT_LENGTH;

			$text .= DEF::padding($remain_bit_num);

			$DESencrypt = new DES();
			$DESencrypt->generate_subkey($key);

			$IV = $this->generate_IV();
			$pre_encrypt = $IV;
			$res = '';

			for ($index = 0, $i = 0; $i < $section_num; $index += TEXT_LENGTH, ++$i)
			{
				$cur_to_cbc = substr($text, $index, TEXT_LENGTH);
				$cur_to_encrypt = DEF::str_xor($cur_to_cbc, $pre_encrypt);
				$cur_encrypt = $DESencrypt->encrypt($cur_to_encrypt);
				$pre_encrypt = $cur_encrypt;
				$res .= $cur_encrypt;
			}
			return $DESencrypt->encrypt($IV) .$res;
		}

		public function decrypt($text, $key)
		{
			$DESdecrypt = new DES();
			$DESdecrypt->generate_subkey($key);

			$decrypted_IV = $this->get_IV($text);
			$pre_to_decrypt = $DESdecrypt->decrypt($decrypted_IV);
			$text = substr($text, TEXT_LENGTH);
			
			$length = strlen($text);
			$section_num = $length / TEXT_LENGTH;

			$res = '';

			for ($index = 0, $i = 0; $i < $section_num; $index += TEXT_LENGTH, ++$i)
			{
				$cur_to_decrypt = substr($text, $index, TEXT_LENGTH);
				$cur_to_cbc = $DESdecrypt->decrypt($cur_to_decrypt);
				$cur_decrypt = DEF::str_xor($pre_to_decrypt, $cur_to_cbc);
				$pre_to_decrypt = $cur_to_decrypt;
				$res .= $cur_decrypt;
			}
			return DEF::depadding($res);
			//return $res;
		}

		private function generate_IV()
		{
			$left = decbin(mt_rand(0, (1 << HALF_TEXT) - 1));
			$right = decbin(mt_rand(0, (1 << HALF_TEXT) - 1));
			$length = strlen($left);
			for ($i = HALF_TEXT; $i > $length; --$i)
				$left = $left .'0';
			$length = strlen($right);
			for ($i = HALF_TEXT; $i > $length; --$i)
				$right = $right .'0';
			return $left .$right;
		}

		private function get_IV($text)
		{
			return substr($text, 0, TEXT_LENGTH);
		}
	}
?>