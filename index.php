<?
// initial
$array = array("Tester", "Date", "Headphone", "Channel", "Path");

foreach($array as $value){
	if(!isset($_GET[$value]))
		$_GET[$value] = "?";
}

$tester = $_GET["Tester"];
$date = $_GET["Date"] == "?" ?  date("Ymd") : $_GET["Date"];
$headphone = $_GET["Headphone"];
$channel = $_GET["Channel"];
$path = $_GET["Path"];

$questionName = "$date-$tester-$headphone-$channel" . "channel";
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="dist/css/style.css">
</head>
<body>
	<div class="container" style="cursor: default;">
		<div id="Main" class="col-md-6">
			<div id="QTitle" class="col-md-12 col-md-offset-0">
				<input class="form-control" type="text" value="<?=$questionName?>" disabled />
			</div>
			<div id="QControls" class="col-md-12 col-md-offset-0">
				<div class="row">
					<button id="D0" type="button" class="btn btn-info btn-lg col-md-offset-0 active">前面</button>
				</div>
				<div class="row">
					<button id="D1" type="button" class="btn btn-info btn-lg col-md-offset-0 active">左前</button>
					<button id="D7" type="button" class="btn btn-info btn-lg col-md-offset-3 active">右前</button>
				</div>
				<div class="row">
					<button id="D2" type="button" class="btn btn-info btn-lg col-md-offset-0 active">左邊</button>
					<button id="D6" type="button" class="btn btn-info btn-lg col-md-offset-6 active">右邊</button>
				</div>
				<div class="row">
					<button id="D3" type="button" class="btn btn-info btn-lg col-md-offset-0 active">左後</button>
					<button id="D5" type="button" class="btn btn-info btn-lg col-md-offset-3 active">右後</button>
				</div>
				<div class="row">
					<button id="D4" type="button" class="btn btn-info btn-lg col-md-offset-0 active">後面</button>
				</div>
				<div id="QChoose" class="row">
					<button id="D0" type="button" class="btn btn-warning btn-lg col-md-offset-0">＜＜</button> 
					<input type="text" value="01" disabled /> 
					<button id="D1" type="button" class="btn btn-warning btn-lg col-md-offset-0">＞＞</button>
				</div>
			</div>
		</div>
		<div id="Info" class="col-md-6">
			<div id="QTotal" class="col-md-10 col-md-offset-1">
			<?
				for($i = 0; $i < 72; $i++){
					echo '<span class="label label-default">';
					if($i < 9)
						echo "0";
					echo $i+1;
					echo "</span>\r\n";
				}
			?>
			</div>
			<div id="OtherContorl" class="col-md-10 col-md-offset-1">
				<form class="form-horizontal" role="form">
				  	<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Who</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputEmail3" placeholder="Who are you?">
						</div>
				  	</div>
				  	<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Music</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputEmail3" value="music" placeholder="How to name the music?">
						</div>
				  	</div>
				  	<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">When</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputEmail3" value="<?=$date?>" placeholder="Ex: 20140214">
						</div>
				  	</div>
				  	<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Path</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputEmail3" placeholder="Where is the Folder?">
						</div>
				  	</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-7 radio-inline">
							<label class="col-sm-6">
								<input name="Channel" type="radio" checked> 8 Channel
							</label>
							<label class="col-sm-6">
								<input name="Channel" type="radio"> 5 Channel
							</label>
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-default">Create</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>



<?
$titles = array("#", "前方", "左前", "左邊", "左後", "後面", "右後", "右邊", "右前");
	
?>

<?if(false):?>
<br />
<div class="container">
	<div class="col-md-8 col-md-offset-2" style="height: 600px;overflow: auto;">
		<table id="TestTable" class="table table-striped table-bordered" style="text-align: center;">
			<thead>
				<tr>
					<td colspan="<?=$colCount?>"><?=$TestName?></td>
				</tr>	
				<tr>
				<?
					// Title
					for($i = 0; $i < $colCount; $i++){
						echo "<td>" . $titles[$i] . "</td>\n";
					}
				?>
				</tr>
			</thead>
			<tbody>
				<?
					// Question
					for($i = 1; $i <= $qTotal; $i++){
						echo "<tr>\n";
						echo "<td>$i</td>\n";
						for($j = 1; $j < $colCount; $j++){
							echo "<td><input name='Q$i' type='radio'/></td>\n";
						}
						echo "</tr>\n";
					}
				?>
			</tbody>
		</table>
	</div>
</div>
<?endif;?>