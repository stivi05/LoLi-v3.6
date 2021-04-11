<?php if(!defined('BLOCK_FILE')){Header("Location: ../");exit;}
$blocktitle = ".:: Релизы Last 20 ::.";  
$content .= "<table cellspacing='0' cellpadding='5' width='100%'>";   
$res = sql_query("SELECT torrents.id, torrents.name, (torrents.leechers + torrents.remote_leechers) AS leechers, 
(torrents.seeders + torrents.remote_seeders) AS seeders FROM torrents ORDER BY added DESC LIMIT 20") or sqlerr(__FILE__, __LINE__);
while($release = mysql_fetch_array($res)){$nazvanie = $release["name"];
$content .= "<tr><td><center><a href='details.php?id=".$release['id']."' alt='$nazvanie' title='$nazvanie'><b>$nazvanie</b></a>
&nbsp;&nbsp;(seeders=>".$release['seeders']." / leechers=>".$release['leechers'].")</center></td></tr>";}
$content .= "</table>";?>