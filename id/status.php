<?php 

$handle = $_GET['id'];

$filename = $handle.'.png';

function nub()

{
	global $handle, $filename;
	$xml = simplexml_load_file('http://steamcommunity.com/id/' .$handle. '?xml=1');

	$steamid = $xml->steamID;
        $steam64 = $xml->steamID64;
	$isonline = $xml->onlineState;
	$statmsg = $xml->stateMessage;
	$ava = $xml->avatarIcon;
	$gamename = $xml->inGameInfo->gameName;
	$gameicon = $xml->inGameInfo->gameIcon;


	header("Content-type: image/png");
	$im     = imagecreatefrompng("source/base.png");
	$font5 = 'source/verdanab.ttf';
	$font6 = 'source/verdana.ttf';
	$white = imagecolorallocate($im, 255, 255, 255);
	$blue = imagecolorallocate($im, 142, 202, 254);
	$green = imagecolorallocate($im, 170, 241, 77);
	$grey = imagecolorallocate($im, 152, 157, 155);
	
	if (strlen($steamid) >= 18) {
	$idsize = 7;
	}
	
	else {	
	$idsize = 8;
	}
	
	if (strlen($gamename) >= 20) {
	$gamesize = 7;
	}
	
	else {
	$gamesize = 8;
	}
	
	if ($xml == FALSE)
	{
	$border1 = imagecreatefrompng("source/offline.png");
	imagecopymerge  ($im, $border1, 16, 16, 0, 0, 40, 40, 100);
	imagettftext($im, 8, 0, 65, 27, $grey, $font5, 'Error');
	imagettftext($im, 7, 0, 65, 40, $grey, $font5, 'Profile Unavailable');
	}

	elseif ($steam64 == "0")
	{
	$border1 = imagecreatefrompng("source/offline.png");
	imagecopymerge  ($im, $border1, 16, 16, 0, 0, 40, 40, 100);
	imagettftext($im, 8, 0, 65, 27, $grey, $font5, 'Error');
	imagettftext($im, 7, 0, 65, 40, $grey, $font5, 'Profile Unavailable');
	}
	
	elseif ($isonline == "offline")
	{
	$border1 = imagecreatefrompng("source/offline.png");
	imagecopymerge  ($im, $border1, 16, 16, 0, 0, 40, 40, 100);
	imagettftext($im, $idsize, 0, 65, 27, $grey, $font5, $steamid);
	imagettftext($im, 7, 0, 65, 40, $grey, $font6, $statmsg);
	$ava = imagecreatefromjpeg($ava);
	imagecopymerge  ($im, $ava, 20, 20, 0, 0, 32, 32, 100);
	}

	elseif ($isonline =="online")
	{
	$border1 = imagecreatefrompng("source/online.png");
	imagecopymerge  ($im, $border1, 16, 16, 0, 0, 40, 40, 100);
	imagettftext($im, $idsize, 0, 65, 27, $blue, $font5, $steamid);
	imagettftext($im, 7, 0, 65, 40, $white, $font5, 'is now online');
	$ava = imagecreatefromjpeg($ava);
	imagecopymerge  ($im, $ava, 20, 20, 0, 0, 32, 32, 100);

	}

	/*elseif (!isset($isonline))
	{
	$border1 = imagecreatefrompng("source/offline.png");
	imagecopymerge  ($im, $border1, 16, 16, 0, 0, 40, 40, 100);
	imagettftext($im, 8, 0, 65, 27, $grey, $font5, 'Error');
	imagettftext($im, 7, 0, 65, 40, $grey, $font5, 'Profile Unavailable');
	}
	*/
	
	else
	{
	$border1 = imagecreatefrompng("source/play.png");
	imagecopymerge  ($im, $border1, 16, 16, 0, 0, 40, 40, 100);
	$ico = imagecreatefromjpeg($gameicon);
	imagecopymerge  ($im, $ico, 188, 20, 0, 0, 32, 32, 100);
	$ava = imagecreatefromjpeg($ava);
	imagecopymerge  ($im, $ava, 20, 20, 0, 0, 32, 32, 100);
	imagettftext($im, $idsize, 0, 65, 27, $green, $font5, $steamid);
	imagettftext($im, 7, 0, 65, 40, $grey, $font5, 'is now playing');
	imagettftext($im, $gamesize, 0, 65, 55, $green, $font5, $gamename);
	}



	imagepng($im);
	imagepng($im, $filename);
	imagedestroy($im);
	
}



// check to see if the local file exists
if (file_exists($filename)) 
{
	// get difference in seconds between now and last modified date
	$diff = (time() - filemtime($filename));
	// if greater than 5mins (300 seconds) get new file from source
	if ($diff >= 300) 
		{
		nub();
		}
	
	else
		{
		header("Content-type: image/png");
		readfile($filename);	
		}
	 
}

else 
{
	// file doesn't exist, get data and create new file //
	nub();
}

//echo $diff;
?>
