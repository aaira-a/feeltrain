<?php
/*
================================================
LEFT 4 DEAD PLAYER RANK
Copyright (c) 2009 Mitchell Sleeper
Originally developed for WWW.F7LANS.COM
================================================
Campaign detailed stats - "campaign.php"
================================================
*/

// Include the primary PHP functions file
include("./common.php");

// Load outer template
$tpl = new Template("./templates/layout.tpl");

// Set Campaign ID as var, and quit on hack attempt
if (strstr($_GET['id'], "/")) exit;
$campaign = $_GET['id'];

$title = $campaigns[$campaign];
if ($title."" == "") {
    $tpl->set("site_name", $site_name); // Site name
    $tpl->set("title", "Invalid Campaign"); // Window title
    $tpl->set("page_heading", "Invalid Campaign"); // Page header

    $output = "You have selected an invalid campaign. Please go back, and report this error to the site administrator. Thank you.";
    $tpl->set("body", trim($output));

    // Output the top 10
    $tpl->set("top10", $top10);

    // Print out the page!
    echo $tpl->fetch("./templates/layout.tpl");

    exit;
}

$tpl->set("site_name", $site_name); // Site name
$tpl->set("title", $title . " Stats"); // Window title
$tpl->set("page_heading", $title . " Stats"); // Page header

$totalkills = 0;
$result = mysql_query("SELECT * FROM maps WHERE name LIKE '" . $campaign . "%' ORDER BY name ASC");
while ($row = mysql_fetch_array($result)) {
    $stats = & new Template('./templates/page.tpl');
    $stats->set("page_subject", $row['name']);

    $map = & new Template('./templates/maps_detailed.tpl');
    $playtime_arr = array(formatage($row['playtime_nor'] * 60),
                          formatage($row['playtime_adv'] * 60),
                          formatage($row['playtime_exp'] * 60),
                          formatage(($row['playtime_nor'] * 60) + ($row['playtime_adv'] * 60) + ($row['playtime_exp'] * 60)));

    $points_arr = array(number_format($row['points_nor']),
                        number_format($row['points_adv']),
                        number_format($row['points_exp']),
                        number_format($row['points_nor'] + $row['points_adv'] + $row['points_exp']));

    $kills_arr = array(number_format($row['kills_nor']),
                       number_format($row['kills_adv']),
                       number_format($row['kills_exp']),
                       number_format($row['kills_nor'] + $row['kills_adv'] + $row['kills_exp']));

    $restarts_arr = array(number_format($row['restarts_nor']),
                          number_format($row['restarts_adv']),
                          number_format($row['restarts_exp']),
                          number_format($row['restarts_nor'] + $row['restarts_adv'] + $row['restarts_exp']));

    $totalkills = $totalkills + ($row['kills_nor'] + $row['kills_adv'] + $row['kills_exp']);

    $map->set("playtime", $playtime_arr);
    $map->set("points", $points_arr);
    $map->set("kills", $kills_arr);
    $map->set("restarts", $restarts_arr);
    $body = $map->fetch("./templates/maps_detailed.tpl");

    $stats->set("page_body", $body);
    $output .= $stats->fetch("./templates/page.tpl");
}

$campaignpop = getpopulation($totalkills, $population_file, False);
$campaigninfo = "<p>More zombies have been killed in <b>" . $title . "</b> than the entire population of <a href=\"http://google.com/search?q=site:en.wikipedia.org+" . $campaignpop[0] . "&btnI=1\">" . $campaignpop[0] . "</a>, population <b>" . number_format($campaignpop[1]) . "</b>.<br />That is almost more than the entire population of <a href=\"http://google.com/search?q=site:en.wikipedia.org+" . $campaignpop[2] . "&btnI=1\">" . $campaignpop[2] . "</a>, population <b>" . number_format($campaignpop[3]) . "</b>!</p>\n";

$tpl->set("body", trim($campaigninfo . $output));

// Output the top 10 
$tpl->set("top10", $top10);

// Print out the page!
echo $tpl->fetch("./templates/layout.tpl");
?>
