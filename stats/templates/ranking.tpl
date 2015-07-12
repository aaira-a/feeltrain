<table class="stats">
<tr><th colspan="6"><a href="<?=$page_prev;?>"><< Prev 100</a> | Page <?=$page_current;?> / <?=$page_total;?> | <a href="<?=$page_next;?>">Next 100 >></a></th></tr>
<tr><th>Rank</th><th>Player</th><th>Points/Minutes</th><th>Points</th><th>Playtime</th><th>Last Online</th></tr>
<?php foreach ($players as $player): ?><?=$player;?><?php endforeach; ?>
<tr><th colspan="6"><a href="<?=$page_prev;?>"><< Prev 100</a> | Page <?=$page_current;?> / <?=$page_total;?> | <a href="<?=$page_next;?>">Next 100 >></a></th></tr>
</table>

