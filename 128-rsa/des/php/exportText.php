<?php
    $content = $_POST['content'];
    $filename = $_POST['type'];
    if ($filename != 'plaintext' || $filename != 'cyphertext')
    	return;
    Header("Content-type: application/octet-stream");
    Header("Accept-Ranges: bytes");
    Header("Accept-Length: " .strlen($content));
    Header("Content-Disposition: attachment; filename=" . $filename .".txt");
    echo $content;
?>
