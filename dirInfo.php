<?
	//$_POST["path"] = "sound/Keming/Drum";
	if(!is_dir($_POST["path"])){
		echo "error";
		exit;
	}

	$dir = dir($_POST["path"]);
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
	foreach(preg_grep("/.*.wav/", $temp) as $obj){
		//print($i . "-" . $obj . "<br />");
		$output[$i] = $obj;
		$i++;
	}

	print_r(json_encode($output));
?>