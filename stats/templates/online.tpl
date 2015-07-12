<table class="stats">
<tr><th>Player</th><th>Points</th><th width="40%">Total Playtime</th></tr>
<?php foreach ($online as $player): ?><?=$player;?><?php endforeach; ?>
</table>
<p class="lol">To get your stats tracked (<span class="red">L4D1/server001</span>), type <span class="yellow">setinfo "_passkey" "</span><span class="red">yourpasskey</span><span class="yellow">"</span> with your chosen passkey in console before connecting to the server. Or put the line in your <span class="yellow">/left4dead/cfg/autoexec.cfg</span> file for automated auth.</p>
<br />
<iframe src="./templates/chatbox.php" border="0" width="600" height="315"></iframe>
<iframe src="./templates/rcon.php" border=0 scrolling="no" width="600" height="40"></iframe><br />

<iframe src="./templates/chatbox2.php" border="0" width="600" height="315"></iframe>
<iframe src="./templates/rcon2.php" border=0 scrolling="no" width="600" height="40"></iframe>
<br />