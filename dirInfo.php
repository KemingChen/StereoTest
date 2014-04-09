<?
	//$_POST["path"] = "sound//Sin400";
	$_POST["preg"] = "/.*.m4a/";
	//$_POST["info"] = '{"who":"Keming","music":"Sin400","when":"20140410","method":"Real","channel":8,"frequency":2,"kind":["左耳聽","右耳聽"],"times":32,"mix":false}';

	$path = $_POST["path"];
	$preg = isset($_POST["preg"]) ? $_POST["preg"] : "/.*/"; // "/.*.wav/"
	$info = json_decode($_POST["info"]);
	$random = $_POST["random"] ? $_POST["random"] : true;

	if(!is_dir($path)){
		echo "error";
		exit;
	}

	$dir = dir($path);
	$temp = array();
	while(false !== ($entry = $dir->read())){
	   array_push($temp, $entry);
	}
	$dir->close();
	$temp = preg_grep($preg, $temp);

	if($random){
		if($info->mix){
			$kindNum = 1;
			$onceNum = $info->channel * $info->frequency * count($info->kind);
		}
		else{
			$kindNum = count($info->kind);
			$onceNum = $info->channel * $info->frequency;
		}

		$kinds = array();
		for($i = 0; $i < $kindNum; $i++){
			$kinds[$i] = array_merge(array(), $temp);
			while(count($kinds[$i]) < $onceNum){
				$kinds[$i] = array_merge($kinds[$i], $temp);
			}

			shuffle($kinds[$i]);
			shuffle($kinds[$i]);
			shuffle($kinds[$i]);
			$kinds[$i] = array_slice($kinds[$i], 0, $onceNum);
			//echo count($kinds[$i]) . " ";
		}
	}

	$output = array();
	$i = 1;
	foreach($kinds as $kind){
		foreach($kind as $obj) {
			//print($i . "-" . $obj . "<br />");
			$output[$i] = $path . "/" . $obj;
			$i++;
		}
	}

	print_r(json_encode($output));
?>