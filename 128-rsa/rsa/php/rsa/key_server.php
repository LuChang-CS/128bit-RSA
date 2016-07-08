<?php
	require_once ("rsa_key.php");

	$s_time = microtime(true);
	$key = generate_rsa_key();
	$e_time = microtime(true);
	if ($key == false)
	{
		echo "error";
		return;
	}
	echo $key["public_key"] .'|' .$key["private_key"] .'|' .sprintf("%.4f", ($e_time - $s_time));
	return;
?>