<h1>RSA 说明文档&nbsp;</h1><hr>
	<h3><b>1. 环境配置及访问说明</b></h3>
	<p>&nbsp; &nbsp; &nbsp; &nbsp; 本次提交的 RSA 算法实现采用 64位 php 进行后台编写，若要在本机运行请配置好服务器环境并将相关文件放在服务器目录下。（如需上传文件，php 需开启文件上传功能，并修改上传文件大小限制）。</p>
	<p>&nbsp; &nbsp; &nbsp; &nbsp; 建议使用最新版 chrome、firefox 浏览器，不推荐使用 IE 浏览器。</p>
	<p>&nbsp; &nbsp; &nbsp; &nbsp; 完成配置工作之后，在浏览器输入下面的地址进行访问。</p>
	<blockquote><p>localhost/rsa/rsa.html</p></blockquote><hr>
	<h3><b>2. 输入方法及格式说明</b></h3>
	<p>&nbsp; &nbsp; &nbsp; &nbsp; 1)&nbsp; &nbsp;生成公钥/私钥</p>
	<p>&nbsp; &nbsp; &nbsp; &nbsp; 在选择操作栏中单击生成 RSA 密钥获在输入密钥处单击生成密钥，即可进入 RSA 密钥生成页面。进入之后，单击“生成”按钮即可生成，若生成成功，则会显示生成的公钥和私钥，并提示生成成功和生成时间，用户可以选择导出密钥到 txt 格式的文件，若失败，则提示生成失败（判断素数和生成素数的超时限制均为10秒，判断素数采用100次 Miller-Rabin 检验法），用户可选择再次生成。</p>
	<p>&nbsp; &nbsp; &nbsp; &nbsp;其中公钥和私钥均为01字符串，前128位均为 n 的二进制表示（采用的算法保证 n 的二进制一定为128 bit），公钥的剩余部分为 e 的二进制表示，私钥的剩余部分为 d 的二进制表示，p、q 丢弃。</p>
	<img src="images/key.png" title="生成秘钥" />
	<p>&nbsp; &nbsp; &nbsp; &nbsp; 2)&nbsp; &nbsp;加密解密</p>
	<p>&nbsp; &nbsp; &nbsp; &nbsp;RSA 加密操作需输入明文和密钥，解密操作需输入密文和密钥。明文、密文和秘钥的输入支持导入 txt 格式的文件，单击“导入明文（密文）”即可开始文件上传，上传成功后会有相关提示。此外明文、密文和密钥均为01字符串，密文长度必须为128的倍数。</p><hr>
	<h3><b>3. 加密解密操作说明</b></h3>
	<p>&nbsp; &nbsp; &nbsp; &nbsp; 明文（密文）和密钥输入完成之后单击加密（解密）按钮即可进行加密（解密）的操作。单击之后可看到“正在加密（解密）”的提示，加密（解密）完成后可看到屏幕右上方提示“加密（解密）完成，用时xx秒”。</p><hr>
	<img src="images/encrypt.png" title="加密" /><br />
	<img src="images/decrypt.png" title="解密" />
	<h3><b>4. 导出文件说明</b></h3>
	<p>&nbsp; &nbsp; &nbsp; &nbsp; 加密（解密）完成后可选择导出密文（明文）。单击“导出密文（明文）”按钮即可导出 txt 格式的文件。</p>
	<h3><b>4. DES操作说明</b></h3>
	<p>&nbsp; &nbsp; &nbsp; &nbsp; 在选择操作栏中单击生成 DES 加密解密，即可进入 DES 加密解密页面，加密解密操作类似于 RSA 加密解密。</p>
