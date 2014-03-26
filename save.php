<?
    $timestamp =  microtime(true) * 1000;
    $data = json_decode($_POST["current"]);
    $filename = $_POST["id"] . "-" . $timestamp;
    $channel = $data->info->channel;
    $frequency = $data->info->frequency;
    $kinds = $data->info->kind;
    array_push($kinds, "整份文件");
    $kindCount = count($kinds);

    $content = $_POST["current"];
    //print_r($kinds);

    // Info
    $tagName = array("左邊", "右邊", "前後", "其他", "總數");
    $directInfo = array(
        0=> array('property'=> "前後", 'name'=> "前方"), 
        45=> array('property'=> "左邊", 'name'=> "左前"), 
        90=> array('property'=> "左邊", 'name'=> "左邊"), 
        135=> array('property'=> "左邊", 'name'=> "左後"), 
        180=> array('property'=> "前後", 'name'=> "後面"), 
        225=> array('property'=> "右邊", 'name'=> "右後"), 
        270=> array('property'=> "右邊", 'name'=> "右邊"), 
        315=> array('property'=> "右邊", 'name'=> "右前")
    );
    $items = array();
    $result = array();

    //Init
    foreach($data->items as $item){
        $items[$item->NO] = $item;
    }
    for($i = 0; $i < count($kinds); $i++){
        $result[$i] = array();
        for($j = 0; $j < count($tagName); $j++){
           $result[$i][$tagName[$j]] = 0; 
        }
    }

    //Calculate & output
    $iKind = 0;
    $output = $data->filename . "\r\n";
    $output .= "題號, 標準答案, 我的答案, 花費時間\r\n";
    for($i = 1; $i <= count($items); $i++){
        $output .= $i . ",";
        $output .= $directInfo[$items[$i]->SA]['name'] . ",";
        if($items[$i]->UA != $items[$i]->SA){
            $output .= $directInfo[$items[$i]->UA]['name'];

            if($directInfo[$items[$i]->UA]['property'] == $directInfo[$items[$i]->SA]['property']){
                $result[$iKind][$directInfo[$items[$i]->UA]['property']]++;
                $result[$kindCount - 1][$directInfo[$items[$i]->UA]['property']]++;
            }
            else{
                $result[$iKind]["其他"]++;
                $result[$kindCount - 1]["其他"]++;
            }
        }
        $result[$iKind]["總數"]++;
        $result[$kindCount - 1]["總數"]++;

        $output .= "," . $items[$i]->UT;
        $output .= "\r\n";

        if($channel * $frequency == $i){
            $iKind++;
        }
    }

    //echo "<br />";
    //print_r($result);
    for($i = 0; $i < $kindCount; $i++){
        $output .= "\r\n\r\n";
        $output .= $kinds[$i] . "\r\n";
        $totalError = 0;
        $total = $result[$i]["總數"];
        for($j = 0; $j < count($tagName) - 1; $j++){
            $output .= $tagName[$j] . "錯," . $result[$i][$tagName[$j]] . "\r\n";
            $totalError += $result[$i][$tagName[$j]];
        }
        //echo "error " . $totalError . "<br />";
        //echo "total " . $total . "<br />";
        $output .= "正確率," . ($total - $totalError) . "／" . $total . "," . ($total - $totalError) / $total * 100 . "％\r\n";
    }
    //file_put_contents($filename . ".csv", $output);
    file_put_contents("csv/" . $filename . ".csv", iconv('utf-8', 'big5', $output));
    file_put_contents("dir/" . $filename, $content);
    echo "csv/" . $filename . ".csv";
?>