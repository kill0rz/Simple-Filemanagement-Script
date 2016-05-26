<?php

/*

	killZ SFS v1.3
	(C) 2013-2014 kill0rz
	for further instructions visit http://blog.kill0rz.com/2013/11/25/download-kill0rz-simple-filemanagement-script/
	
*/

include("header.php");

if($thehash == md5($user."|".$passwort) or $_SESSION['login'] == true){
	$datei = trim($_GET['file']);
	$ordner = "./files_semester{$n}/".$_GET['dir'];
	$vollername = $ordner.$datei;
	if(file_exists($vollername) == true){
		$filename = sprintf("%s/%s", $ordner, $datei);
		header("Content-Type: application/octet-stream");
		$save_as_name = basename($vollername);
		header("Content-Disposition: attachment; filename=\"$save_as_name\"");
		readfile($filename);
	}else{
		echo "<meta http-equiv='refresh' content='0,URL=javascript:history.back(-1)'>";
	}
}else{
	echo "<meta http-equiv='refresh' content='0,URL=./'>";
}
