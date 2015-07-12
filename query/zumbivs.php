<?php 
/* SOURCE ENGINE QUERY FUNCTION, requires the server ip:port */
function source_query($ip){
    $cut = explode(":", $ip);
    $HL2_address = $cut[0];
    $HL2_port = $cut[1];

    $HL2_command = "\377\377\377\377TSource Engine Query\0";
    
    $HL2_socket = fsockopen("udp://".$HL2_address, $HL2_port, $errno, $errstr,3);
    fwrite($HL2_socket, $HL2_command); 
    $JunkHead = fread($HL2_socket,4);
    $CheckStatus = socket_get_status($HL2_socket);

    if($CheckStatus["unread_bytes"] == 0)return 0;

    $do = 1;
    while($do){
        $str = fread($HL2_socket,1);
        $HL2_stats.= $str;
        $status = socket_get_status($HL2_socket);
        if($status["unread_bytes"] == 0){
               $do = 0;
        }
    }
    fclose($HL2_socket);

    $x = 0;
    while ($x <= strlen($HL2_stats)){
        $x++;
        $result.= substr($HL2_stats, $x, 1);    
    }
    
    // ord ( string $string );
    $result = str_split($result);
    $info['network'] = ord($result[0]);$char = 1;
    while(ord($result[$char]) != "%00"){$info['name'] .= $result[$char];$char++;}$char++;
    while(ord($result[$char]) != "%00"){$info['map'] .= $result[$char];$char++;}$char++;
    while(ord($result[$char]) != "%00"){$info['dir'] .= $result[$char];$char++;}$char++;
    while(ord($result[$char]) != "%00"){$info['description'] .= $result[$char];$char++;}$char++;
    $info['appid'] = ord($result[$char].$result[($char+1)]);$char += 2;        
    $info['players'] = ord($result[$char]);$char++;    
    $info['max'] = ord($result[$char]);$char++;    
    $info['bots'] = ord($result[$char]);$char++;    
    $info['dedicated'] = ord($result[$char]);$char++;    
    $info['os'] = chr(ord($result[$char]));$char++;    
    $info['password'] = ord($result[$char]);$char++;    
    $info['secure'] = ord($result[$char]);$char++;    
    while(ord($result[$char]) != "%00"){$info['version'] .= $result[$char];$char++;}
    
    return $info;
} 

$qip = gethostbyname('edstevens.zapto.org');

//$qip = '202.9.98.68';

$q = source_query($qip.':27015');

/*echo "network: ".$q['network']."<br/>";
echo "name: ".$q['name']."<br/>";
echo "map: ".$q['map']."<br/>";
echo "dir: ".$q['dir']."<br/>";
echo "desc: ".$q['description']."<br/>";
echo "id: ".$q['appid']."<br/>";
echo "players: ".$q['players']."<br/>";
echo "max: ".$q['max']."<br/>";
echo "bots: ".$q['bots']."<br/>";
echo "dedicated: ".$q['dedicated']."<br/>";
echo "os: ".$q['os']."<br/>";
echo "password: ".$q['password']."<br/>";
echo "secure: ".$q['secure']."<br/>";
echo "version: ".$q['version']."<br/>"; 
*/

if( !isset($q['players']) )  {
	header("Content-type: image/png");
	$im     = imagecreatefrompng('l4dkitteh001.png');
	$black = imagecolorallocate($im, 0, 0, 0);
	$white = imagecolorallocate($im, 255, 255, 255);
	imagestring($im, 3, 185, 71, 'server', $white);
	imagestring($im, 3, 182, 81, 'offline', $white);
    }

else { 
if ($q['players'] == "0") {
  $useimg = "l4d4.png";
  } elseif ($q['players'] == "1") {
  $useimg = "l4d4.png"; 
  } elseif ($q['players'] == "2") {
  $useimg = "l4d4.png"; 
  } elseif ($q['players'] == "3") {
  $useimg = "l4d4.png"; 
  } elseif ($q['players'] == "4") {
  $useimg = "l4d4.png";
  } else { 
  $useimg = "l4d4.png"; 
  }

header("Content-type: image/png");
$im     = imagecreatefrompng($useimg);
$white = imagecolorallocate($im, 255, 255, 255);
imagestring($im, 3, 10, 55, $q['name'], $white);
imagestring($im, 2, 10, 70, $q['description'], $white);
imagestring($im, 2, 10, 80, $q['map'], $white);
imagestring($im, 2, 200, 3, 'Version', $white);
imagestring($im, 2, 200, 13, $q['version'], $white);
imagestring($im, 5, 208, 45, $q['players'], $white);
imagestring($im, 5, 218, 50, '/', $white);
imagestring($im, 5, 228, 55, $q['max'], $white);
imagestring($im, 2, 203, 71, 'players', $white);
imagestring($im, 2, 203, 80, 'online', $white);
}

imagepng($im);
imagedestroy($im)

?>
