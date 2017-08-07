<?php

//global $language;
global $domain;
//$language = "";

if($_SERVER['REQUEST_METHOD'] === "POST")
{
	// I18N support information here
	if (isset($_POST["german"]))
	{
		$domain = "german";
	}
	else
	{
		$domain = "english";
	}
	putenv("LANG=" . $language);
	setlocale(LC_ALL, $language);
	bindtextdomain($domain, "Locale"); 
	bind_textdomain_codeset($domain, 'UTF-8');
	textdomain($domain);	
	header('Location: ' . $_SERVER['HTTP_REFERER']); // back to the previous page (this may not be secure)
}
?>