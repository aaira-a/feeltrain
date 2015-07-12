<?php
/*
================================================
LEFT 4 DEAD PLAYER RANK
Copyright (c) 2009 Mitchell Sleeper
Originally developed for WWW.F7LANS.COM
================================================
Player stats page - "player.php"
================================================
*/

// Include the primary PHP functions file
include("./common.php");

// Load outer template
$tpl = new Template("./templates/layout.tpl");

// Set Steam ID as var, and quit on hack attempt
if (strstr($_GET['num'], "/")) exit;
$id = $_GET['num'];

$tpl->set("site_name", $site_name); // Site name

$row = mysql_fetch_array(mysql_query("SELECT * FROM players WHERE num = '" . $id . "'"));
$rank = mysql_num_rows(mysql_query("SELECT num FROM players WHERE points >= '" . $row['points'] . "'"));

$arr_kills = array();
$arr_kills['Common Infected'] = $row['kill_infected'];
$arr_kills['Hunters'] = $row['kill_hunter'];
$arr_kills['Smokers'] = $row['kill_smoker'];
$arr_kills['Boomers'] = $row['kill_boomer'];

$arr_awards = array();
$arr_awards['Pills Given'] = $row['award_pills'];
$arr_awards['Medkits Given'] = $row['award_medkit'];
$arr_awards['Saved Friendlies from Hunters'] = $row['award_hunter'];
$arr_awards['Saved Friendlies from Smokers'] = $row['award_smoker'];
$arr_awards['Protected Friendlies'] = $row['award_protect'];
$arr_awards['Revived Friendlies'] = $row['award_revive'];
$arr_awards['Rescued Friendlies'] = $row['award_rescue'];
$arr_awards['Tanks Killed with Team'] = $row['award_tankkill'];
$arr_awards['Tanks Killed with No Deaths'] = $row['award_tankkillnodeaths'];
$arr_awards['Safe Houses Reached with All Survivors'] = $row['award_allinsafehouse'];
$arr_awards['Campaigns Completed'] = $row['award_campaigns'];

$arr_demerits = array();
$arr_demerits['Friendly Fire Incidents'] = $row['award_friendlyfire'];
$arr_demerits['Teammates Killed'] = $row['award_teamkill'];
$arr_demerits['Friendlies Left For Dead'] = $row['award_left4dead'];
$arr_demerits['Infected Let In Safe Room'] = $row['award_letinsafehouse'];
$arr_demerits['Witches Disturbed'] = $row['award_witchdisturb'];

if (mysql_num_rows(mysql_query("SELECT * FROM players WHERE num='" . $row['num'] . "'")) > 0)
{
    $tpl->set("title", "Viewing Player: " . htmlentities($row['name'], ENT_COMPAT, "UTF-8")); // Window title
    $tpl->set("page_heading", "Viewing Player: " . htmlentities($row['name'], ENT_COMPAT, "UTF-8")); // Page header

    $stats = & new Template('./templates/player.tpl');
    $stats->set("player_name", htmlentities($row['name'], ENT_COMPAT, "UTF-8"));
    $stats->set("player_num", $row['num']);
    if (function_exists(bcadd)) $stats->set("player_url", "<a href=\"http://steamcommunity.com/profiles/" . getfriendid($row['num']) . "\">" . htmlentities($row['name'], ENT_COMPAT, "UTF-8") . "'s Community Page</a>");
    else $stats->set("player_url", "<b>Community page URL disabled</b>");

    $stats->set("player_lastonline", date("M d, Y g:ia", $row['lastontime']) . " (" . formatage(time() - $row['lastontime']) . " ago)");
    $stats->set("player_playtime", formatage($row['playtime'] * 60) . " (" . number_format($row['playtime']) . " min)");
    $stats->set("player_rank", $rank);
    $stats->set("player_points", number_format($row['points']));
    $stats->set("player_kills", number_format($row['kills']));
    $stats->set("player_headshots", number_format($row['headshots']));

    if ($row['kills'] == 0 || $row['headshots'] == 0) $stats->set("player_ratio", "0");
    else $stats->set("player_ratio", number_format($row['headshots'] / $row['kills'], 4) * 100);

    $stats->set("player_kpm", number_format($row['kills'] / $row['playtime'], 4));
    $stats->set("player_ppm", number_format($row['points'] / $row['playtime'], 4));

    $arr_achievements = array();

    if ($row['kills'] > $population_minkills) {
        $popkills = getpopulation($row['kills'], $population_file, $population_cities);
        $arr_achievements[] = "<td><b>City Buster</b></td>
        <td>You have killed more zombies than the entire population of <a href=\"http://google.com/search?q=site:en.wikipedia.org+" . $popkills[0] . "&btnI=1\">" . $popkills[0] . "</a>, population " . number_format($popkills[1]) . ".<br />
        That is alomst more than the entire population of <a href=\"http://google.com/search?q=site:en.wikipedia.org+" . $popkills[2] . "&btnI=1\">" . $popkills[2] . "</a>, population " . number_format($popkills[3]) . ".</td>";
    }

    if (count($arr_achievements) === 0)
        $arr_achievements[] = "<td><b>N/A</b></td><td>You have not yet earned any achievements.</td>";

    arsort($arr_kills);
    arsort($arr_awards);
    arsort($arr_demerits);

    $stats->set("arr_kills", $arr_kills);
    $stats->set("arr_awards", $arr_awards);
    $stats->set("arr_demerits", $arr_demerits);
    $stats->set("arr_achievements", $arr_achievements);

    $output = $stats->fetch("./templates/player.tpl");
} else {
    $tpl->set("title", "Viewing Player: INVALID"); // Window title
    $tpl->set("page_heading", "Viewing Player: INVALID"); // Page header

    $output = "This player is no longer in our stats system. If this was a valid player before, it is likely they were removed due to inactivity.";
}

$tpl->set('body', trim($output));

// Output the top 10
$tpl->set("top10", $top10);

// Print out the page!
echo $tpl->fetch("./templates/layout.tpl");
?>
