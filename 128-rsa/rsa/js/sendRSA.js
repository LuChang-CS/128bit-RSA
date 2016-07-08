function send(type)
{
	var content, msg, key;
	if (content === "")
		return;
	key = document.getElementById('key').value;
	if (key === "")
	{
		Notifier.error("请输入密钥！");
		return;
	}

	if (type === 'encrypt')
	{
		content = document.getElementById('plaintext').value;
		document.getElementById('cypertext').value = "";
		msg = "正在加密...<img src='images/loading.gif'>";
	}
	else if (type === 'decrypt')
	{
		content = document.getElementById('cypertext').value;
		document.getElementById('plaintext').value = "";
		msg = "正在解密...<img src='images/loading.gif'>";
	}

	document.getElementById('msg').innerHTML = msg;

	var xmlHttp = GetXmlHttpObject();
	if (xmlHttp === null)
	{
		Notifier.error("Browser does not support HTTP Request")
		return;
	}

	var url = "php/rsa/rsa_server.php";
	xmlHttp.onreadystatechange = stateChanged;
	xmlHttp.open("POST", url, true);
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded;");
	xmlHttp.send("content=" + content + "&type=" + type + "&key=" + key);

	function stateChanged()
	{
		if ((xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") && xmlHttp.status == 200)
		{
			document.getElementById('msg').innerHTML = '';
			var text = xmlHttp.responseText;

			if (text[0] === '0' || text[0] === '1')
			{
				var res = text.split('|');
				if (type == 'encrypt')
				{
					Notifier.success("加密完成，用时" + res[1] + "秒");
					document.getElementById('cypertext').value = res[0];
				}
				else if (type == 'decrypt')
				{
					Notifier.success("解密完成，用时" + res[1] + "秒");
					document.getElementById('plaintext').value = res[0];
				}
			}
			else
				//Notifier.error(text);
				alert(text);
		}
	}
}

function exportKeyText(type)
{
	var content;
	if (type === 'public-key')
	{
		content = document.getElementById('public-key').value;
		if (content === "")
			return;
		document.getElementById('hiddenPublic-key').value = 'public_key';
		document.getElementById('hiddenPublickeyValue').value = document.getElementById("public-key").value;
		document.getElementById('exportPublic-key').submit();
	}
	else if (type === 'private-key')
	{
		content = document.getElementById('private-key').value;
		if (content === "")
			return;
		document.getElementById('hiddenPrivate-key').value = 'private_key';
		document.getElementById('hiddenPrivatekeyValue').value = document.getElementById("private-key").value;
		document.getElementById('exportPrivate-key').submit();
	}
}

function exportText(type)
{
	var content;
	if (type === 'plaintext')
	{
		content = document.getElementById('plaintext').value;
		if (content === "")
			return;
		document.getElementById('hiddenPlain').value = 'plaintext';
		document.getElementById('exportPlain').submit();
	}
	else if (type === 'ciphertext')
	{
		content = document.getElementById('cypertext').value;
		if (content === "")
			return;
		document.getElementById('hiddenCypher').value = 'cyphertext';
		document.getElementById('exportCipher').submit();
	}
}

function generate_rsa_key()
{
	var xmlHttp = GetXmlHttpObject();
	if (xmlHttp === null)
	{
		Notifier.error("Browser does not support HTTP Request")
		return;
	}
	document.getElementById('msg_rsa_key').innerHTML = "正在生成...<img src='images/loading.gif'>";

	var url = "php/rsa/key_server.php";
	xmlHttp.onreadystatechange = stateChanged;
	xmlHttp.open("POST", url, true);
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded;");
	xmlHttp.send();

	function stateChanged()
	{
		if ((xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") && xmlHttp.status == 200)
		{
			document.getElementById('msg_rsa_key').innerHTML = '';
			var text = xmlHttp.responseText;

			if (text[0] === '0' || text[0] === '1')
			{
				var res = text.split('|');
				Notifier.success("生成成功，用时" + res[2] + "秒");
				document.getElementById('public-key').value = res[0];
				document.getElementById('private-key').value = res[1];
			}
			else
				Notifier.error(text);
		}
	}
}

function GetXmlHttpObject()
{
	var xmlHttp = null;
	try
	{
		// Firefox, Opera 8.0+, Safari
		xmlHttp = new XMLHttpRequest();
	}
	catch (e)
	{
		//Internet Explorer
		try
		{
			xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}