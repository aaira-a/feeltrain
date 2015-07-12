<table class="stats">
<tr><th>Player</th><th>Points</th><th width="40%">Total Playtime</th></tr>
<?php foreach ($online as $player): ?><?=$player;?><?php endforeach; ?>
</table>
<p class="lol">To get your stats tracked (<span class="red">server001</span>), type <span class="yellow">setinfo "_passkey" "</span><span class="red">yourpasskey</span><span class="yellow">"</span> with your chosen passkey in console before connecting to the server. Or put the line in your <span class="yellow">/left4dead/cfg/autoexec.cfg</span> file for automated auth.</p>
<br />