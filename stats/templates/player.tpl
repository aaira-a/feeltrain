<table class="stats">
    <tr valign="top"><td align="center" width="50%">

<table class="statsbox">
<tr><th colspan="2">Player Summary</th></tr>
<tr><td>Rank:</td><td><?=$player_rank;?></td></tr>
<tr><td>Points:</td><td><?=$player_points;?></td></tr>
<tr><td>Kills:</td><td><?=$player_kills;?></td></tr>
<tr><td>Headshots:</td><td><?=$player_headshots;?></td></tr>
<tr><td>Headshot Ratio:</td><td><?=$player_ratio;?> %</td></tr>
<tr><td>Kills per Minute:</td><td><?=$player_kpm;?></td></tr>
<tr><td>Points per Minute:</td><td><?=$player_ppm;?></td></tr>
</table>

    </td><td align="center">

<table class="statsbox">
<tr><th colspan="2">Player Profile</th></tr>
<tr><td>Name:</td><td><?=$player_name;?></td></tr>
<tr><td>Steam ID:</td><td>disabled</td></tr>
<tr><td>Steam Community:</td><td>disabled</td></tr>
<tr><td>Last Online:</td><td><?=$player_lastonline;?></td></tr>
<tr><td>Total Playtime:</td><td><?=$player_playtime;?></td></tr>
</table>

    </td></tr>
    <tr valign="top"><td align="center" width="50%">

<table class="statsbox">
<tr><th>Infected Type</th><th>Kills</th></tr>
<?php foreach ($arr_kills as $type => $kills): ?>
<tr><td><?=$type;?></td><td><?=number_format($kills);?></td></tr>
<?php endforeach;?>
</table><br />

<table class="statsbox">
<tr><th colspan="2">Demerits</th></tr>
<?php foreach ($arr_demerits as $demerit => $count): ?>
<tr><td align="right"><?=$demerit;?></td><td><?=number_format($count);?></td></tr>
<?php endforeach;?>
</table>

</td>
<td align="center" colspan="2">

<table class="statsbox">
<tr><th colspan="2">Awards</th></tr>
<?php foreach ($arr_awards as $award => $count): ?>
<tr><td align="right"><?=$award;?></td><td><?=number_format($count);?></td></tr>
<?php endforeach;?>
</table>

</td></tr>

<tr><td colspan="2" align="center" width="100%">

<table class="statsbox">
<tr><th colspan="2">Achievements</th></tr>
<?php foreach ($arr_achievements as $achievement): ?>
<tr><?=$achievement;?></tr>
<?php endforeach;?>
</table>

</td></tr>
</table>

