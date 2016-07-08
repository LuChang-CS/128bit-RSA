<?php
	require_once ("rsa_128.php");

	class RSA
	{
		public function encrypt($text, $key)
		{
			$rsa_128 = new RSA_128();
			$rsa_128->get_public_key($key);

			$length = strlen($text);
			$res = '';
			for ($i = 0; $i < $length; $i += 64)
			{
				$current_text = substr($text, $i, 64);
				$temp = DEF::DecToBin($rsa_128->encrypt($current_text));

				$length = strlen($temp);
				for ($j = 128; $j > $length; --$j)
					$temp = '0' .$temp;
				$res .= $temp;
			}

			return $res;
		}

		public function decrypt($text, $key)
		{
			$rsa_128 = new RSA_128();
			$rsa_128->get_private_key($key);

			$length = strlen($text);
			$res = '';
			for ($i = 0; $i < $length; $i += 128)
			{
				$current_text = substr($text, $i, 128);
				$res .= DEF::DecToBin($rsa_128->decrypt($current_text));
			}

			return $res;
		}
	}
?>