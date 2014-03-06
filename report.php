<?
	$values = array(0,45,90,135,180,225,270,315);
	$titles = array("前方", "左前", "左邊", "左後", "後面", "右後", "右邊", "右前");
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap-theme.min.css">
	<script type="text/javascript" src="dist/js/jquery-1.9.0.min.js"></script>
	<script type="text/javascript" src="dist/js/report.js"></script>
</head>
<body>
	<div class="container" style="cursor: default;">
		<div class="col-md-3 col-md-offset-3" style="margin-top: 50px;">
			<textarea id="Ans" class="form-control" rows="10"></textarea>
		</div>
		<div class="col-md-3 col-md-offset-0" style="margin-top: 50px;">
			<textarea id="StdAns" class="form-control" rows="10"></textarea>
		</div>
		<div class="col-md-6 col-md-offset-3" style="margin-top: 50px;">
			<input type="checkbox" id="mirror" />Mirror
			<button class="form-control" style="font-weight: bolder;" onclick="calculate();">審　查</button><br />
			<button class="form-control" style="font-weight: bolder;" onclick="$('textarea').val('');">清　除</button>
		</div>
	</div>
	<div id="Hide" style="display: none;">
		<form action="genReport_R_M_L.php" method="POST">
			<input name="ANS" />
			<input name="STDANS" />
			<input name="Filename" />
		</form>
	</div>
</body>
</html>