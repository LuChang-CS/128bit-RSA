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
				$res .= DEF::DecToBin($rsa_128->encrypt($current_text));
			}

			$length = strlen($res);
			for ($i = 128; $i > $length; --$i)
				$res = '0' .$res;

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

	$RSAencrypt = new RSA();
	echo $RSAencrypt->encrypt('1000000010000000100000001000000010000000100000001000000010000000', '11000010101111001010110111101110110000110111111000010001001101100001010100100010000101011001001101000011010101101100000101111011101110110010000010010100000000101101101111011000010010001011000000000000101101100110011010100110100101111111111011100000000001');
	echo '<br />';
	$RSAencrypt1 = new RSA();
	echo $RSAencrypt1->encrypt('1000000010000000100000001000000010000000100000001000000010000000', '1100001010111100101011011110111011000011011111100001000100110110000101010010001000010101100100110100001101010110110000010111101110000000000000001');
?>