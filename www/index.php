<?php  

/*

	killZ SFS v1.3
	(C) 2013-2014 kill0rz
	for further instructions visit http://blog.kill0rz.com/2013/11/25/download-kill0rz-simple-filemanagement-script/
	
*/


###
$isadmin = false; //DO NOT CHANGE THIS LINE!
include("header.php");

if($forcessl){
	if(!checkIsSSL(true)){
		echo checkumlaute($lang_notusingssl);
		die();
	}
}

//Picture

$direc = "./pics";
if(is_dir($direc)) {
    if($dh = opendir($direc)){
        while(($file = readdir($dh)) !== false){
		if(!filetype($direc . $file) == "dir"){
			if($file != "." and $file != ".." and $file != "index.html" and $file != "index.php"){	
				$picarr[] = $file;
				
			}

		}

	}
        closedir($dh);
    }
}

if(count($picarr) < 1){
	$topbild = '<h1><i class="fa fa-cloud"></i>'.checkumlaute($lang_alterpic).'</h1>';
}else{
	$topbild = "<img src=\"./pics/".$picarr[rand(0,count($picarr)-1)]."\" width=163px />";
}

//

if(trim($_GET['action']) == "upload"){
	$action = "upload";
}else{
	$action = "";
}

$endausgabe = array();

if(isset($_POST['user']) and isset($_POST['pass'])){
	$thehash = md5($_POST['user']."|".$_POST['pass']);
}else{
	$thehash = "";
}
if(isset($_GET['dir']) and $_GET['dir']){
	$dir = "./files_semester{$n}/".$_GET['dir']."/";
}else{
	$dir = "./files_semester{$n}/";
}
if($thehash == md5($user."|".$passwort) or $_SESSION['login'] == true){
$_SESSION['login'] = true;
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo checkumlaute($lang_title); ?></title>
		<!--<meta http-equiv="content-type" content="text/html; charset=UTF-8" />-->
		<meta charset="UTF-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" href="css/font/style.css" />
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-panels.min.js"></script>
		<script src="js/init.js"></script>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-desktop.css" />
			<link rel="stylesheet" href="css/style-wide.css" />
		</noscript>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
		<!--[if lte IE 7]><link rel="stylesheet" href="css/ie7.css" /><![endif]-->
	</head>
	
	<body class="left-sidebar">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Content -->
					<div id="content">
						<div id="content-inner">
					
							<!-- Post -->
								<article class="is-post is-post-excerpt">
									<header>
										<h2><a href="index.php"><?php echo checkumlaute($lang_header); ?></a></h2>
										<?php
										if(count($thens) > 1){
											echo '<span class="byline">'.checkumlaute($lang_chooseasemester)." ";
												$navbar = "";
												foreach($thens as $ourvar){
													$navbar .= '<a href="?n='.$ourvar.'&action='.$action.'">'.$ourvar.'</a> | ';
												}
												$navbar = substr($navbar, 0, -3);
												echo $navbar;
											echo "</span><br>";
											echo '<span class="byline">'.checkumlaute($lang_youareinsemester).' '.$n.'!</span>';
										}
										?>
									</header>

									<p>
<?php

if($action == 'upload'){
	include("up.php");
	die();
}


if(isset($_GET['dir']) and trim($_GET['dir']) != ''){
	$endausgabe[] = "<a href='./index.php?n=".$n."'>".checkumlaute($lang_back)."</a><br><br>\n";
}

if(file_exists("{$dir}hinweis.folder")){
	$hinweis = file("{$dir}hinweis.folder");
	echo "<div class='folderhinweis'>";
	foreach($hinweis as $h){
		$h = str_replace(array("<br>","<br />"),"",$h);
		$h = str_replace("\n","<br>",$h);
		echo checkumlaute($h);
	}
	echo "</div>";
}

if(!is_dir("./files_semester{$n}/")){
	mkdir("./files_semester{$n}/", 0777);
	makeindex("./files_semester{$n}/");
	makehtaccess("./files_semester{$n}/");
}

if(!is_dir("./files_semester{$n}/_unkontrolliert/")){
	mkdir("./files_semester{$n}/_unkontrolliert/", 0777);
	makeindex("./files_semester{$n}/_unkontrolliert/");
	makehtaccess("./files_semester{$n}/_unkontrolliert/");
}

if(!file_exists("{$dir}index.php")){
	makeindex($dir);
}

if(!file_exists("{$dir}.htaccess")){
	makehtaccess($dir);
}

if(is_dir("./files_semester{$n}/")) {
    if($dh = opendir($dir)){
        while(($file = readdir($dh)) !== false){
			if(filetype($dir . $file) == "dir"){
				if($file != "." and $file != ".." and $file != "index.html" and $file != "hinweis.folder" and $file != "index.php" and $file != "linklist.folder" and $file != ".htaccess"){
					$endausgabe[count($endausgabe)] = "<tr><td><i class='fa fa-folder'></i>  <a href='index.php?dir=".$file."&n={$n}' rel='nofollow'>$file</a></td></tr>\n";
				}
			}else{
				if($file != "." and $file != ".." and $file != "index.html" and $file != "index.php" and $file != "hinweis.folder" and $file != "linklist.folder" and $file != ".htaccess"){
					$repdir = str_replace("./files_semester{$n}/","",$dir);
					$endausgabe[count($endausgabe)] = "<tr><td><i class='fa fa-download'></i> <div class='fileinfo'><a href='download.php?dir=".$repdir."&file=".$file."&n={$n}' rel='nofollow'>$file</a></td><td>".replacemonths(date("d. F Y H:i:s", filemtime($dir.$file)))."</td><td>".thisfilesize($dir.$file)."</div></td></tr>\n";
				}
			}
		}
        closedir($dh);
    }
}else{
	echo checkumlaute($lang_folderdoesnotexist);
}

natsort($endausgabe);
echo "<table>";
foreach($endausgabe as $e){
		echo checkumlaute($e);
}
echo "</table>";

//Linklist

if(file_exists("{$dir}linklist.folder")){
	$linklistgesamtarray = file("{$dir}linklist.folder");
	$linkausgabe = "<div class='linklist'>";
	$cantrunk = false;
	foreach($linklistgesamtarray as $l){
		$thislink = explode(";",$l);
		$linkausgabe .= '<a href="'.trim($thislink['1']).'" target="_blank">'.trim($thislink['0']).'</a>'."\n".' | ';
		$cantrunk = true;
	}
	if($cantrunk){
		$linkausgabe = substr($linkausgabe, 0, -3);
	}
	$linkausgabe .= "</div>";
	echo "<br>".checkumlaute($linkausgabe);
}

//
?>
									</p>
								</article>
						</div>
					</div>
					
				<!-- Sidebar -->
					<div id="sidebar">
					
						<!-- Logo -->
							<div id="logo">
								<?php
									echo $topbild;
								?>
							</div>
					
						<!-- Nav -->
							<nav id="nav">
								<ul>
									<li class="current_page_item"><a href="index.php"><i class="fa fa-home"></i> <?php echo checkumlaute($lang_startseite); ?></a></li>
									<li><a href='index.php?action=upload&n=<?php echo $n; ?>' rel='nofollow'><i class="fa fa-upload"></i> <?php echo checkumlaute($lang_upload); ?></a></li> 
									<li><a href='index.php?logout=true' rel='nofollow'><i class="inner"></i> <?php echo checkumlaute($lang_logout); ?></a></li> 
								</ul>
							</nav>
						<!-- Text -->
						<section class="is-text-style1">
							<div class="inner">
								<p>
									<?php echo checkumlaute($lang_freetext1); ?>
								</p>
							</div>
						</section>
						<!-- Impressum -->
							<section class="is-text-style1">
								<div class="inner">
									<p>
										<?php echo checkumlaute($lang_impressum); ?>
									</p>
							</section>
								</div>
					</div>
							
			</div>

<?php

//Prüfe auf Update
if($isadmin){
	$timecontrol_now = time();
	$timecontrol_old = file("./adm/timecontrol.txt");
	if($timecontrol_old['0'] + 60*60*24*2 - $timecontrol_now < 0){
		$timecontrol = true;
		file_put_contents("./adm/timecontrol.txt",time());
	}else{
		$timecontrol = false;
	}
	if($timecontrol){
		$newversion = file("http://kill0rz.com/sfs/version.txt");
		$oldversion = file("./adm/version.txt");
		if($newversion['0'] > $oldversion['0']){
			echo checkumlaute($lang_update_available);
		}
	}
}

}else{
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo checkumlaute($lang_title); ?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" href="css/font/style.css" />
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-panels.min.js"></script>
		<script src="js/init.js"></script>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-desktop.css" />
			<link rel="stylesheet" href="css/style-wide.css" />
		</noscript>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
		<!--[if lte IE 7]><link rel="stylesheet" href="css/ie7.css" /><![endif]-->
	</head>
	
	<body class="left-sidebar">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Content -->
					<div id="content">
						<div id="content-inner">
					
							<!-- Post -->
								<article class="is-post is-post-excerpt">
									<header>
										<h2><a href="index.php"><?php echo checkumlaute($lang_header); ?></a></h2>
										<span class="byline"><?php echo checkumlaute($lang_byline); ?></span><br><br><br>

<?php

//Linklist

if(file_exists("./linklist.folder")){
	$linklistgesamtarray = file("./linklist.folder");
	$flag = false;
	foreach($linklistgesamtarray as $l){
		$thislink = explode(";",$l);

		if(trim($thislink['0']) == ""){
			$linkausgabe = substr($linkausgabe, 0, -3);
		}elseif(count($thislink) > 1){
			$linkausgabe .= '<a href="'.trim($thislink['1']).'" target="_blank">'.trim($thislink['0']).'</a>'."\n".' | ';
		}else{
			if(!$flag) $linkausgabe = substr($linkausgabe, 0, -3);
			$linkausgabe .= "<br>".trim($thislink['0']).": ";
			$flag = true;
		}
	}
}

$linkausgabe = checkumlaute(substr($linkausgabe, 0, -3));
echo $linkausgabe;

//

?>

										<br><br><br>
										<b><?php echo checkumlaute($lang_internalstatisticsheadline); ?></b>
										<ul>
										<li><?php echo checkumlaute($lang_internalstatisticsdatabase); ?></li>
										<?php
										$zaehler = 0;
										$zaehler2 = 0;
										function get_size($path,$size)
										 {
										 global $zaehler;
										 global $zaehler2;
										   if(!is_dir($path))
											 {
											   $size+=filesize($path);
											   $zaehler++;
											 }
										   else
											 {
											   $dir = opendir($path);
											   while($file = readdir($dir))
												 {
												   if(is_file($path."/".$file))
													 $size+=filesize($path."/".$file);
													 $zaehler++;
												   if(is_dir($path."/".$file) && $file!="." && $file!="..")
													 $size=get_size($path."/".$file,$size);
													 $zaehler++;
													 $zaehler2++;
												 }
											 }
										   return($size);
										 }

										$size = get_size("./",0);
										$measure = "Byte";
										if ($size >= 1024)
										 {
										   $measure = "KB";
										   $size = $size / 1024;
										 }
										if ($size >= 1024)
										 {
										   $measure = "MB";
										   $size = $size / 1024;
										 }
										if ($size >= 1024)
										 {
										   $measure = "GB";
										   $size = $size / 1024;
										 }
										$size = sprintf("%01.2f", $size);
										?>
										<li><?php echo checkumlaute($lang_internalstatisticsfiles)." ".$zaehler; ?></li>
										<li><?php echo checkumlaute($lang_internalstatisticsfolders)." ".$zaehler2; ?></li>
										<li><?php echo checkumlaute($lang_internalstatisticssize)." ".$size." ".$measure; ?></li>
										</ul>
									</header>
									
								</article>
						</div>
					</div>
					
				<!-- Sidebar -->
					<div id="sidebar">
					
						<!-- Logo -->
							<div id="logo">
								<h1><i class="fa fa-cloud"></i><?php echo checkumlaute($lang_alterpic); ?></h1>
							</div>							
						<!-- Nav -->
							<nav id="nav">
								<ul>
									<li class="current_page_item"><a href="index.php"><i class="fa fa-home"></i><?php echo checkumlaute($lang_startpage); ?></a></li>
								</ul>
							</nav>
						<!-- Login -->
							<section class="is-login">
							<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
							<?php echo checkumlaute($lang_name); ?><br>
							<input type="text" name="user"><br>
							<?php echo checkumlaute($lang_password); ?><br>
							<input type="password" name="pass"><br><br>
							<input type="submit" value="Anmelden">
							</form>
							<br>
							</section>

						<!-- Impressum -->
							<section class="is-text-style1">
								<div class="inner">
									<p>
										<?php echo checkumlaute($lang_impressum); ?>
									</p>
								</div>
								<br>
							</section>
							
					</div>
							
			</div>

<?php
if($_POST['user'].$_POST['pass'] != ''){
	file_put_contents("./adm/failed_logins.data",$_POST['user']." | ".$_POST['pass']." | ".time()."\n",FILE_APPEND);
}

}
?>