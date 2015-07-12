<?php
/*
================================================
LEFT 4 DEAD PLAYER RANK
Copyright (c) 2009 Mitchell Sleeper
Originally developed for WWW.F7LANS.COM
================================================
Index / Players Online page - "index.php"
================================================
*/

// Include the primary PHP functions file
include("./common.php");

// Load outer template
$tpl = new Template("./templates/layout.tpl");

$result = mysql_query("SELECT * FROM players WHERE lastontime >= '" . intval(time() - 300) . "' ORDER BY points DESC");
$playercount = number_format(mysql_num_rows($result));

$tpl->set("site_name", $site_name); // Site name
$tpl->set("title", "Players Online"); // Window title
$tpl->set("page_heading", "Registered Players Online - " . $playercount); // Page header

if (mysql_error()) {
    $output = "<p><b>MySQL Error:</b> " . mysql_error() . "</p>\n";

} else {
    $arr_online = array();
    $stats = & new Template('./templates/motd.tpl');

    $i = 1;
    while ($row = mysql_fetch_array($result)) {
        if ($row['lastontime'] > time()) $row['lastontime'] = time();

        $line = ($i & 1) ? "<tr>" : "<tr class=\"alt\">";
        $line .= "<td><a href=\"player.php?num=" . $row['num']. "\">" . htmlentities($row['name'], ENT_COMPAT, "UTF-8") . "</a></td>";
        $line .= "<td>" . number_format($row['points']) . "</td><td>" . formatage($row['playtime'] * 60) . "</td></tr>\n";

        $i++;
        $arr_online[] = $line;
    }

    if (mysql_num_rows($result) == 0) $arr_online[] = "<tr><td colspan=\"3\" align=\"center\">There are no players online</td</tr>\n";

    $stats->set("online", $arr_online);
    $output = $stats->fetch("./templates/motd.tpl");
}

$tpl->set('body', trim($output));

// Output the top 10 
$tpl->set("top10", $top10);

// Print out the page!
echo $tpl->fetch("./templates/layout.tpl");
?>
