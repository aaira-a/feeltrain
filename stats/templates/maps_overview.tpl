<div class="post">
	<div class="entry">
		<p>More zombies have been killed on this server than the entire population of <a href="http://google.com/search?q=site:en.wikipedia.org+<?=$totalpop[0];?>&btnI=1"><?=$totalpop[0];?></a>, population <b><?=number_format($totalpop[1]);?></b>.<br />
		That is almost more than the entire population of <a href="http://google.com/search?q=site:en.wikipedia.org+<?=$totalpop[2];?>&btnI=1"><?=$totalpop[2];?></a>, population <b><?=number_format($totalpop[3]);?></b>!</p>

		<table class="stats">
		<tr><th>Campaign Name</th><th>Total Playtime</th><th>Total Points</th><th>Total Kills</th><th>Total Restarts</th></tr>
		<?php foreach ($maps as $map): ?><?=$map;?><?php endforeach; ?>
		</table>
	</div>
</div>
