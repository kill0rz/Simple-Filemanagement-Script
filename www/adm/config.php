<?php

/*

	killZ SFS v1.3
	(C) 2013-2014 kill0rz
	for further instructions visit http://blog.kill0rz.com/2013/11/25/download-kill0rz-simple-filemanagement-script/
	
*/

$aktuellessemester = 1;  							//Das Semester, was immer zuerst aufgerufen werden soll

$user = "Standardnutzer";							//Standardnutzer

$passwort = "Standardpasswort";						//Standard Paswort

$adminmail = "admin@example.com";					//Adresse des Administrators

$forcessl = false;									//Erzwinge eine SSL-Verbindung?

$maxlogintime = 60*15;								//Angabe in Sekunden, wie lange ein inaktiver User eingeloggt bleiben soll

$thens = array(										//Anzhal und Bezeichnung der Semester
				1,
				2,
				3,
				4
		);