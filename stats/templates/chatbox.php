<?php
/*
 * =============================================================================
 * SourceMod Extended ChatLog v1.3.5 WebUI Example
 * Reads a chatlog database for sourcemod and prints the sauce, in ajaxxx!
 *
 * (C)2009 Nephyrin@doublezen.net
 * =============================================================================
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, version 3.0, as published by the
 * Free Software Foundation.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program.  If not, see <http://www.gnu.org/licenses/>.
 *
*/

//
// This is a SIMPLE example. Modify it as you wish. Keep in mind that it is GPL
// Licensed.
//
$START_ROWS = 100; // How many lines of chat we should display to start.

// $DB_HOST [$DB_PORT] $DB_USER $DB_PASS $DB_DATABASE
$DB_HOST = "localhost";
$DB_PORT = "3306";
$DB_USER = "root";
$DB_PASS = "dibi123";
$DB_DATABASE = "chatlogex";

// Gives a nicer back-end ID for the javascript.
function cleanId($in)
{
	return preg_replace("/[^0-9a-zA-Z]/", "_", $in);
}
function formatRow($R)
{
	$class;
	if ($R['team'] == 3)
		$class = "bluename";
	elseif ($R['team'] == 2)
		$class = "redname";
	elseif ($R['team'] == 10)
		$class = "violetname";
	else
		$class = "greyname";

	$team = "";
	$dead = "";
	$name = htmlspecialchars($R['name'], ENT_QUOTES);
	$text = htmlspecialchars($R['text'], ENT_QUOTES);

	if ($R['type'] >= 0)
	{
		if ($R['type'] & 2)
			$team = "[TEAM] ";
		if ($R['type'] & 1)
			$dead = "<span class=\"deadname\">*DEAD*</span> ";

		$name = "$dead<span class=\"$class\">$team$name: </span>";
		
		if ($R['type'] == 5)
			{
			$text = "<span class=\"grnmsg\">$text</span>";
			$team = "";
			$dead = "";
			$name = htmlspecialchars($R['name'], ENT_QUOTES);
			}
			
		if ($R['type'] == 6)
			{
				$text = "<span class=\"orgmsg\">$text</span>";
			$team = "";
			$dead = "";
			$name = htmlspecialchars($R['name'], ENT_QUOTES);
			}
			
		if ($R['type'] == 7)
			{
			$text = "<span class=\"redmsg\">$text</span>";
			$team = "";
			$dead = "";
			$name = htmlspecialchars($R['name'], ENT_QUOTES);
			}
			
		if ($R['type'] == 8)
			{
			$text = "<span class=\"grymsg\">$text</span>";
			$team = "";
			$dead = "";
			$name = htmlspecialchars($R['name'], ENT_QUOTES);
			}
			
		if ($R['type'] == 9)
			{
			$text = "<span class=\"prpmsg\">$text</span>";
			$team = "";
			$dead = "";
			$name = htmlspecialchars($R['name'], ENT_QUOTES);
			}
	}
	else
	{
		if($R['team'] == 10)
		{
			$team = "[ADMIN] ";
			$name = "<span class=\"$class\">$team$name: </span>";
		}
		else
			$text = "<span class=\"servermsg\">$text</span>";
	}

	// Hours modifier
	$hoursmod = 0;

	// http://fi2.php.net/manual/en/function.date.php
	// European timestamp
	//$date = date("j.m.y H:i:s", $R['date'] + ($hoursmod * 3600));
	//$date = date("n/j g:i:sa", $R['date'] + ($hoursmod * 3600));
	
	// http://fi2.php.net/manual/en/function.date.php
    // European timestamp
    //$date = date("j.m.y H:i:s", $R['date']);
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $date = date("d/m/Y G:i:s", $R['date']);  
	
	$id = cleanId($R['srvid']);
	return "$id\x01<span class=\"line\"><span class=\"timestamp\">$date </span>$name$text</span><br />";
}

$SQL = @mysql_connect($DB_PORT ? "$DB_HOST:$DB_PORT" : $DB_HOST, $DB_USER, $DB_PASS);
if (!$SQL) die("Failed to connect to MySQL Database");
@mysql_select_db($DB_DATABASE) or die("MySQL Failure: " . mysql_error());

// Set output encoding to UTF-8
mysql_query('SET NAMES utf8', $SQL) or die("MySQL Failure: " . mysql_error());

if (isset($_GET['mark']) && $mark = $_GET['mark'] + 0):
	if ($mark == -1)
		$Q = "SELECT name,seqid,type,srvid,team,text,UNIX_TIMESTAMP(`date`) AS `date` FROM `chatlogs` ORDER BY `seqid` DESC LIMIT $START_ROWS";
	else
		$Q = "SELECT name,seqid,type,srvid,team,text,UNIX_TIMESTAMP(`date`) AS `date` FROM `chatlogs` WHERE `seqid` > $mark ORDER BY `seqid` DESC";

	$Q = @mysql_query($Q, $SQL) or die("MySQL Failure: " . mysql_error());
	$ar = array();
	$R = mysql_fetch_array($Q);
	if (!$R)
	{
		// No new data, echo same mark back
		echo($mark);
		exit();
	}
	$newmark = $R['seqid'];
	do
	{
		array_push($ar, formatRow($R));
	} while ($R = mysql_fetch_array($Q));
	array_push($ar, $newmark); // Add mark to bottom (top once reversed)
	$ar = array_reverse($ar);// Query selects rows in reverse order, and mark is on bottom
	echo(implode("\n", $ar));
else:
	$Q = "SELECT DISTINCT `srvid` FROM `chatlogs`";
	$Q = @mysql_query($Q, $SQL) or die("MySQL Failure: " . mysql_error());
	$PB = "";
	$PS = "";
	while ($R = mysql_fetch_row($Q))
	{
		$id = cleanId($R[0]);
		$PB .= "<div class=\"dat\">
				<div class=\"dhead\">Server \"$R[0]\"</div>
				<div class=\"dbody\" id=\"dbody_$id\">
					<div class=\"dtext\" id=\"dat_$id\"></div>
					<div id=\"dscrollto_$id\"></div>
				</div>
			</div>\n";
		$PS .= "srvz.push(\"$id\");\n";
	}
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Lolyat Combi</title>
        <link type="image/x-icon" href="./favicon.ico" rel="icon"/>
		<script type="text/javascript" src="./jquery-1.3.min.js"></script>
		<script type="text/javascript">
			var srvz = new Array();
			var mark = -1;
			var loading = 1;
			<?php echo($PS); ?>
			function dead(wat)
			{
				alert("Server side error. Dying:" + wat);
			}
			function cback(data, textStatus)
			{
				if (textStatus == "success")
				{
					var lines = data.split("\n");
					mark = lines[0];
					if (mark + 0 == 0) die(3);
					var line;
					var scrollme = new Array();
					for(var i = 1; i < lines.length; i++)
					{
						line = lines[i].split("\x01");
						// 0 srvid
						// 1 string
						// Formatted serverside
						if ($("#dscrollto_" + line[0]).offset().top <= $("#dbody_" + line[0]).height() + $("#dbody_" + line[0]).offset().top)
							if (!scrollme[line[0]]) scrollme[line[0]] = true;
						if (line.length != 2) return dead("1");
						var box = $("#dat_" + line[0]);
						if (!box) return dead("2");
						for(var j = i + 1; j < lines.length; j++)
						{
							if(lines[j].split("\x01").length != 1) break;
							line[1] += "<br />" + lines[j];
							i = j;
						}
						if (loading)
						{
							box.html(line[1]);
							loading = 0;
						}
						else
						{
							box.append(line[1]);
						}
						box.children(".line:last").fadeIn(500);
					}
					for (var sid in scrollme)
					{
						// Scroll it, thanks to learningjquery.com!
						var divOffset = $("#dbody_" + sid).offset().top;
						var endOffset = $("#dscrollto_" + sid).offset().top;
						var Scroll = endOffset - divOffset;
						$("#dbody_" + sid).animate({scrollTop: '+=' + Scroll + 'px'}, 500);
					}
				}
				window.setTimeout("proc()", 2000);
			}
			function proc()
			{
				$.get("<?php echo($_SERVER["PHP_SELF"]); ?>?mark=" + mark, cback);
			}
		</script>
		<style>
			body
			{
				background-color: #333;
				font-family: verdana, arial;
				font-size: 12px;
			}
			.dat
			{
				border: 1px solid #000;
				background-color: #EEE;
				padding: 10px;
				margin: 10px;
				width: 550px;
				margin-left: auto;
				margin-right: auto;
			}
			.dbody
			{
				height: 250px;
				width: 550px;
				overflow: auto;
			}
			.dhead
			{
				font-weight: bold;
				font-size: 150%;
			}
			.dtext
			{
				padding-left: 7em;
			}
			.line
			{
				position: relative;
				margin-left: -7em;
				display: none;
			}
			.redname
			{
				color: blue;
				font-weight: bold;
			}
			.bluename
			{
				color: red;
				font-weight: bold;
			}
			.greyname
			{
				color: #cf8d25;
				font-weight: bold;
			}
			.violetname
			{
				color: #aa00b7;
				font-weight: bold;
			}
			.deadname
			{
				color: red;
				font-weight: bold;
				font-style: italic;
			}
			.servermsg
			{
				color: green;
				font-style: italic;
			}
			.grnmsg
			{
				color: green;
				font-style: italic;
			}
			.orgmsg
			{
				color: #b8751b;
				font-style: italic;
			}
			.redmsg
			{
				color: red;
				font-style: italic;
			}
			.grymsg
			{
				color: grey;
				font-style: italic;
			}
			.prpmsg
			{
				color: purple;
				font-style: italic;
			}
			.timestamp
			{
				font-size: 80%;
				font-color: black;
				font-style: italic;
			}
		</style>
	</head>
	<body onload="javascript:proc()">
	<?php echo($PB); ?>
    </body>
	</html>
<?php endif; ?>
