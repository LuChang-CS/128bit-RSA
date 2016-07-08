<?php
	require_once ("def.php");

	class RSA_128
	{
		private $dec_n;
		private $dec_e;
		private $dec_d;

		public function get_public_key($key)
		{
			$this->dec_n = DEF::BinToDec(substr($key, 0, 128));
			$this->dec_e = DEF::BinToDec(substr($key, 128));
		}

		public function get_private_key($key)
		{
			$this->dec_n = DEF::BinToDec(substr($key, 0, 128));
			$this->dec_d = DEF::BinToDec(substr($key, 128));
		}

		public function encrypt($text)
		{
			$dec_text = DEF::BinToDec($text);
			return DEF::modular_exponentiation($dec_text, $this->dec_e, $this->dec_n);
		}

		public function decrypt($text)
		{
			$dec_text = DEF::BinToDec($text);
			return DEF::modular_exponentiation($dec_text, $this->dec_d, $this->dec_n);
		}
	}
?>