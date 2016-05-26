<?php

/*

	killZ SFS v1.3
	(C) 2013-2014 kill0rz
	for further instructions visit http://blog.kill0rz.com/2013/11/25/download-kill0rz-simple-filemanagement-script/
	
*/

if(!($thehash == md5($user."|".$passwort) or $_SESSION['login'] == true)) die();

?>
 <section class="is-login">
 <form action="index.php?action=upload" method="post"
 enctype="multipart/form-data">
 <label for="file"><i class="fa fa-file"></i> <?php echo checkumlaute($lang_file); ?></label>
 <input type="file" name="file" id="file"><br><br>
 <input type="hidden" name="sentform" value="true">
 <input type="hidden" name="n" value="<?php echo $n; ?>">
 <input type="submit" name="submit" value="<?php echo checkumlaute($lang_upload2); ?>">
 </form>
 </section>
 
<?php
if(isset($_POST['sentform']) and $_POST['sentform'] == true){
		
		if(file_exists("./files_semester{$n}/_unkontrolliert/" . $_FILES["file"]["name"])){
		    echo $_FILES["file"]["name"] . " " . checkumlaute($lang_upload_error_file_exists);
       	}else{
			move_uploaded_file($_FILES["file"]["tmp_name"],"files_semester{$n}/_unkontrolliert/" . $_FILES["file"]["name"]);
			@chmod("files_semester{$n}/_unkontrolliert/" . $_FILES["file"]["name"], 0644 );
			$times = time();
			$fileinfoblock  = checkumlaute($lang_mail_fileinfoblock1) . " " . $times . "<br>";
			$fileinfoblock .= checkumlaute($lang_mail_fileinfoblock2) . " " . $_FILES["file"]["name"] . "<br>";
			$fileinfoblock .= checkumlaute($lang_mail_fileinfoblock3) . " " . $_FILES["file"]["size"] . " Byte<br>";
			$fileinfoblock .= checkumlaute($lang_mail_fileinfoblock4) . " " . $_SERVER['REMOTE_ADDR'] . "<br>";
			$fileinfoblock .= checkumlaute($lang_mail_fileinfoblock5) . " " . $n;
			$fileinfoblock .= "<br><br>";
			$fileinfoblockfuermail = str_replace("<br>","\n",$fileinfoblock);
			$body = checkumlaute($lang_mail_body1)."\n".$fileinfoblockfuermail;
			if(mail($adminmail,checkumlaute($lang_mail_body2)." ".$_FILES["file"]["name"]." ".checkumlaute($lang_mail_body3),checkumlaute($body))){
				echo checkumlaute($lang_mail_body4);
				echo $fileinfoblock;
			}
			echo checkumlaute($lang_mail_body5)." <a href='index.php?dir=_unkontrolliert&n={$n}'>_unkontrolliert</a> ".checkumlaute($lang_mail_body6). " " . $_FILES["file"]["name"]."<br>";
		}

	}

?>
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
									<li><a href="./?"><i class="fa fa-home"></i> <?php echo checkumlaute($lang_startseite); ?></a></li>
									<li class="current_page_item"><a href='./?action=upload' rel='nofollow'><i class="fa fa-upload"></i> <?php echo checkumlaute($lang_upload); ?></a></li> 
									<li><a href='index.php?logout=true' rel='nofollow'><i class="inner"></i><?php echo checkumlaute($lang_logout); ?></a></li> 
								</ul>
							</nav>
							
						<!-- Text -->
							<section class="is-text-style1">
								<div class="inner">
									<p>
										<?php echo checkumlaute($lang_uploadheadline); ?></a>
									</p>
								</div>
							</section>
						<!-- Impressum -->
							<section class="is-text-style1">
								<div class="inner">
									<p>
										<?php echo checkumlaute($lang_impressum); ?>
									</p>
								</div>
							</section>
					</div>
