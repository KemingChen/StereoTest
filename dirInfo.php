<?
	//$_POST["path"] = "sound/Keming/Drum";

	$path = $_POST["path"];
	$preg = isset($_POST["preg"]) ? $_POST["preg"] : "/.*/"; // "/.*.wav/"
	
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

	shuffle($temp);
	shuffle($temp);
	shuffle($temp);

	$output = array();
	$i = 1;
	foreach(preg_grep($preg, $temp) as $obj){
		//print($i . "-" . $obj . "<br />");
		$output[$i] = $path . "/" . $obj;
		$i++;
	}

	print_r(json_encode($output));
?>