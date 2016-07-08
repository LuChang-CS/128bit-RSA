<?php
	require_once ("rsa.php");

	$type = $_POST['type'];
	$content = $_POST['content'];
	$key = $_POST['key'];

	$length = strlen($content);
	for ($i= 0; $i < $length; ++$i)
	{
		if ($content[$i] != '0' && $content[$i] != '1')
		{
			$error = "文件中只能包含0和1！";
			echo $error;
			return;
		}
	}

	$key_length = strlen($key);
	for ($i= 0; $i < $key_length; ++$i)
	{
		if ($key[$i] != '0' && $key[$i] != '1')
		{
			$error = "密钥中只能包含0和1！";
			echo $error;
			return;
		}
	}

	if ($type == 'encrypt')
	{
		if ($length % 8 != 0)
		{
			$error = "明文长度必须是8的整数倍！";
			echo $error;
			return;
		}

		$RSAencrypt = new RSA();
		$s_time = microtime(true);
		$res = $RSAencrypt->encrypt($content, $key);
		$e_time = microtime(true);
		echo $res .'|' .sprintf("%.4f", ($e_time - $s_time));
		return;
	}
	else if ($type == 'decrypt')
	{
		if ($length % 128 != 0)
		{
			$error = "密文长度必须是128的整数倍！";
			echo $error;
			return;
		}

		$RSAdecrypt = new RSA();
		$s_time = microtime(true);
		$res = $RSAdecrypt->decrypt($content, $key);
		$e_time = microtime(true);
		if ($res == false)
		{
			$error = "非法的密文！";
			echo $error;
			return;
		}
		echo $res .'|' .sprintf("%.4f", ($e_time - $s_time));
		return;
	}
?>