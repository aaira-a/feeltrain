<?php

# Source RCON by William Ruckman (http://ruckman.net)

    require_once("rcon_code.php");
 
# Set Defaults

#client IP
$cip = $_SERVER['REMOTE_ADDR'];
list($cip1, $cip2, $cip3, $cip4) = explode(".", $cip);
$cipout = $cip1. ".". $cip2;

# $cipout = $cip1. ".". $cip2. ".xxx.xxx";

# GET and SEND Post data

if ($_POST)
{ 
    $IP = gethostbyname('pakciktua.zapto.org');
    $PORT = "27015";
    $PASSWORD = "sayang123";
    $COMMAND = $_POST["COMMAND"];

    $srcds_rcon = new srcds_rcon();
    $OUTPUT = $srcds_rcon->rcon_command($IP, $PORT, $PASSWORD, $COMMAND);
}

?>

<html>
<head>
<title>Source RCON by William Ruckman (http://ruckman.net)</title>
<link rel='stylesheet' type='text/css' href='style.css'>
<SCRIPT LANGUAGE='JavaScript' SRC='script.js'></SCRIPT>
</head>
<body>
<form class='hidden' action='rconzumbi.php' method='post' name='CUSTOMCOMMAND'>
<input class='hidden' type='hidden' name='COMMAND' /><input class='hidden' type='hidden' value='Submit'>
</form>         
<form name='COMMONCOMMANDS'>
Name: <input type='text' name='NAMA' value=''>
<input type='hidden' name='AIPI' value='<?php echo($cipout) ?>'>
Message: <input type='text' name='SAY' value=''><input type='button' value='Send !' onclick='falis()'>

</form>
</body>
</html>
       

