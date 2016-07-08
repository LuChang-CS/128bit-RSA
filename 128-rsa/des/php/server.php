<?php
	require_once ("cbc.php");

	$type = $_POST['type'];
	$content = $_POST['content'];
	$key = $_POST['key'];

	if (strlen($key) != TEXT_LENGTH)
	{
		$error = "密钥长度必须为" .TEXT_LENGTH ."位！";
		echo $error;
		return;
	}

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

	for ($i= 0; $i < TEXT_LENGTH; ++$i)
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

		$CBCencrypt = new CBC();
		$s_time = microtime(true);
		$res = $CBCencrypt->encrypt($content, $key);
		$e_time = microtime(true);
		echo $res .'|' .sprintf("%.4f", ($e_time - $s_time));
		return;
	}
	else if ($type == 'decrypt')
	{
		if ($length % TEXT_LENGTH != 0)
		{
			$error = "密文长度必须是" .TEXT_LENGTH ."的整数倍！";
			echo $error;
			return;
		}

		$CBCdecrypt = new CBC();
		$s_time = microtime(true);
		$res = $CBCdecrypt->decrypt($content, $key);
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