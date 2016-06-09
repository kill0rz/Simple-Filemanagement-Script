<?php

/*

killZ SFS v1.3
(C) 2013-2014 kill0rz
for further instructions visit http://blog.kill0rz.com/2013/11/25/download-kill0rz-simple-filemanagement-script/

 */

//SESSION
session_start();

//INCLUDES
include "./adm/language.php";
include "./adm/config.php";

//FUNCTIONS
function checkIsSSL($redirect = false) {

	if (isset($_SERVER['HTTPS'])) {
		return true;
	} elseif ($_SERVER['HTTPS'] == 'on') {
		return true;
	} elseif ($_SERVER['SERVER_PORT'] == 443) {
		return true;
	} else {
		if ($redirect) {
			$urlredirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			header("Location: " . $urlredirect);
			exit;
		} else {
			return false;
		}
	}

}

function makeindex($pfad) {
	$datei = fopen($pfad . "index.php", "w");
	fwrite($datei, "");
	fclose($datei);
}

function makehtaccess($dir) {
	$inhalthtaccess = "<Files \"*.*\">\nDeny from all\n</Files>";
	file_put_contents($dir . ".htaccess", $inhalthtaccess);
}

function checkumlaute($string, $echo = false) {

	$ersetzen = array('ä' => '&auml;', 'ö' => '&ouml;', 'ü' => '&uuml;', 'Ä' => '&Auml;', 'Ö' => '&Ouml;', 'Ü' => '&Uuml;', 'ß' => '&szlig;');

	$string = strtr($string, $ersetzen);
	if ($echo == true) {
		echo $string;
	} else {
		return $string;
	}

}

function thisfilesize($file) {
	$size = filesize($file);
	$measure = "Byte";
	if ($size >= 1024) {
		$measure = "KB";
		$size = $size / 1024;
	}
	if ($size >= 1024) {
		$measure = "MB";
		$size = $size / 1024;
	}
	if ($size >= 1024) {
		$measure = "GB";
		$size = $size / 1024;
	}
	$size = sprintf("%01.2f", $size);
	return $size . $measure;
}

function replacemonths($incoming) {
	$ersetzen = array("January" => "Januar", "February" => "Februar", "March" => "März", "May" => "Mai", "June" => "Juni", "July" => "Juli", "October" => "Oktober", "December" => "Dezember");
	$output = strtr($incoming, $ersetzen);
	return $output;
}

//COMMON CODE
#SSL
if (!isset($_SESSION['timestamp'])) {
	$_SESSION['timestamp'] = 0;
}

#SESSION
if (($_GET['logout'] == "true" or (time() - $_SESSION['timestamp'] > $maxlogintime and $_SESSION['login'] == true)) and (trim($_GET['action'] != "register"))) {
	session_destroy();
	die(
		"<meta http-equiv='refresh' content='0,./index.php?logoutprocess=done' />"
	);
}

$_SESSION['timestamp'] = time();

#N
if (isset($_GET['n'])) {
	$n = trim($_GET['n']);
} else {
	$n = $aktuellessemester;
}

foreach ($thens as $ns) {
	if ($n == $ns) {
		$n = $ns;
		$ntrue = true;
	}
}
if (!$ntrue) {
	$n = $aktuellessemester;
}