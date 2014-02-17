<?
$name = $_GET["Name"];
$path = $_GET["Path"];
$channel = $_GET["Channel"];

header('Content-disposition: attachment; filename=' . $name . '.m3u');
header('Content-type: text/plain');

$times = $channel == 8 ? 9 : 10;
$array = array();

for($i = 0; $i < $channel; $i++){
	for($j = 0; $j < $times; $j++){
		array_push($array, 45 * $i);
	}
}

//print_r($array);

shuffle($array);

for($i = 0; $i < count($array); $i++){
	echo iconv('utf-8', 'big5', $path . $array[$i] . ".wav\r\n");
}
?>