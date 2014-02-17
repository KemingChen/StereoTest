<?
	$values = array(0,45,90,135,180,225,270,315);
	$titles = array("前方", "左前", "左邊", "左後", "後面", "右後", "右邊", "右前");

	$type = $_GET["channel"] == "8" ? array(0,1,2,3,4,5,6,7) : array(0,1,3,5,7);
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap-theme.min.css">
	<script type="text/javascript" src="dist/js/jquery-1.9.0.min.js"></script>
	<script type="text/javascript" src="dist/js/core-temp.js"></script>
</head>
<body>
	<div class="container" style="cursor: default;">
		<div id="Main" class="col-sm-offset-1 col-md-9" style="margin-top: 50px;">
			<div class="form-group">
				<div class=" col-sm-12 radio-inline">
				<?
					for($i = 0; $i < count($type); $i++){
						echo '<label class="col-sm-1">';
						echo '<input name="Direct" type="radio" value="' . $values[$type[$i]] . '" />' . $titles[$type[$i]];
						echo '</label>';
					}
				?>
				</div>
				<div class="col-sm-2" style="margin-top: 20px;">
					<input type="number" class="form-control" value="1" />
					<button type="submit" class="form-control btn btn-default" onclick="addItem();">Save</button>
				</div>
			</div>
		</div>
		<textarea id="Log" class="col-sm-offset-1 col-md-5" style="margin-top: 50px; height: 300px;">

		</textarea>
	</div>
</body>
</html>