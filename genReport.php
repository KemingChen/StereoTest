<?
	$result = array("左邊"=> 0, "右邊"=> 0, "前後"=> 0, "其他"=> 0, "total"=> 0);
	$attr 			= array(0=>"前後", 45=>"左邊", 90=>"左邊", 135=>"左邊", 180=>"前後", 225=>"右邊", 270=>"右邊", 315=>"右邊");
	$correspondName = array(0=>"前方", 45=>"左前", 90=>"左邊", 135=>"左後", 180=>"後面", 225=>"右後", 270=>"右邊", 315=>"右前");

	$filename = $_REQUEST["Filename"];
	$ans = json_decode($_REQUEST["ANS"]);
	$stdans = json_decode($_REQUEST["STDANS"]);

	header('Content-disposition: attachment; filename=' . $filename . '.csv');
	header('Content-type: text/plain');

	$output = $filename . "\r\n";
	$output .= "題號, 標準答案, 我的答案\r\n";
	for($i = 0; $i < count($ans); $i++){
		$output .= ($i + 1) . ",";
		$output .= $correspondName[$stdans[$i]] . ",";
		if($ans[$i] != $stdans[$i]){
			$output .= $correspondName[$ans[$i]];

			if($attr[$ans[$i]] == $attr[$stdans[$i]]){
				$result[$attr[$ans[$i]]]++;
			}
			else{
				$result["其他"]++;
			}
			$result["total"]++;
		}
		$output .= "\r\n";
	}

	$output .= "\r\n";
	$output .= "左錯," . $result["左邊"] . "\r\n";
	$output .= "右錯," . $result["右邊"] . "\r\n";
	$output .= "前後錯," . $result["前後"] . "\r\n";
	$output .= "其他," . $result["其他"] . "\r\n";
	$output .= "正確率," . (count($ans) - $result["total"]) . "/" . count($ans) . "," . (count($ans) - $result["total"])/count($ans) . "\r\n";
	echo $output;


	$file = fopen("dir/" . $filename . ".csv", "w");
	fputs($file, iconv('utf-8', 'big5', $output));
	fclose($file);
	//echo iconv('utf-8', 'big5', $output);
?>