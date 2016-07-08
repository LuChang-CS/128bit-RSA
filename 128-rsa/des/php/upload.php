<?php
	$fileElementName = 'filetext';
	if(!empty($_FILES[$fileElementName]['error']))
	{
		switch($_FILES[$fileElementName]['error'])
		{
			case '1':
				$error = '上传的文件太大，请重新选择！';
				break;
			case '2':
				$error = '文件太大，请重新选择';
				break;
			case '3':
				$error = '文件部分上传，请稍后再试！';
				break;
			case '4':
				$error = '没有文件，请选择文件！';
				break;
			case '6':
				$error = '未找到临时文件夹！';
				break;
			case '7':
				$error = '写入磁盘失败，请稍后重试！';
				break;
			case '8':
				$error = '扩展程序阻止了文件上传，请关闭后重试！';
				break;
			default:
				$error = '未知错误！';
		}
		echo $error;
		return;
	}
	else if(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none')
	{
		$error = "上传文件为空！";
		echo $error;
		return;
	}
	else if ($_FILES[$fileElementName]["type"] != 'text/plain')
	{
		$error = "请上传 txt 格式的文件！";
		echo $error;
		return;
	}
	else
	{
		$str = trim(file_get_contents($_FILES[$fileElementName]['tmp_name']));
		$length = strlen($str);
		for ($i= 0; $i < $length; ++$i)
		{
			if ($str[$i] != '0' && $str[$i] != '1')
			{
				$error = "文件中只能包含0和1！";
				echo $error;
				return;
			}
		}
		echo $str;
	}
?>