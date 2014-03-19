<?
/*
	$who = "Keming";
	$music = "Test";
	$method = "Real";*/
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="dist/css/style.css">
	<script type="text/javascript" src="dist/js/jquery-1.9.0.min.js"></script>
	<script type="text/javascript" src="dist/js/core.js"></script>
</head>
<body onload="init();">
	<audio id="MusicPlayer" src=""></audio>
	<div class="container" style="cursor: default;">
		<div id="Main" class="col-md-6">
			<div id="QTitle" class="col-md-12 col-md-offset-0">
				<input class="form-control" type="text" value="?" disabled />
			</div>
			<div id="QControls" class="col-md-12 col-md-offset-0">
				<div class="row">
					<button id="D0" type="button" class="btn btn-info btn-lg col-md-offset-0" onclick="makeAnswer(this)">前面</button>
				</div>
				<div class="row">
					<button id="D1" type="button" class="btn btn-info btn-lg col-md-offset-0" onclick="makeAnswer(this)">左前</button>
					<button id="D7" type="button" class="btn btn-info btn-lg col-md-offset-3" onclick="makeAnswer(this)">右前</button>
				</div>
				<div class="row">
					<button id="D2" type="button" class="btn btn-info btn-lg col-md-offset-0" onclick="makeAnswer(this)">左邊</button>
					<input id="QuestionNumber" value="1" class="col-md-offset-2" style="display: none;" />
					<button type="button" class="btn btn-success btn-lg col-md-offset-2" onclick="play()">Play</button>
					<button id="D6" type="button" class="btn btn-info btn-lg col-md-offset-2" onclick="makeAnswer(this)">右邊</button>
				</div>
				<div class="row">
					<button id="D3" type="button" class="btn btn-info btn-lg col-md-offset-0" onclick="makeAnswer(this)">左後</button>
					<button id="D5" type="button" class="btn btn-info btn-lg col-md-offset-3" onclick="makeAnswer(this)">右後</button>
				</div>
				<div class="row">
					<button id="D4" type="button" class="btn btn-info btn-lg col-md-offset-0" onclick="makeAnswer(this)">後面</button>
				</div>
			</div>
		</div>
		<div id="Info" class="col-md-6">
			<div id="QTotal" class="col-md-10 col-md-offset-1" style="display: none;">
				<div id="QInfo"></div>
				<div id="QSubmit">
					<form action="genReport_R_M_L.php" method="POST" style="display: none;">
						<input name="ANS" />
						<input name="STDANS" />
						<input name="Filename" />
					</form>
					<br />
					<button class="form-control" onclick="calculate()">做 答 完 畢 ! ! !</button>
				</div>
			</div>
			<div id="OtherContorl" class="col-md-10 col-md-offset-1">
				<form class="form-horizontal" role="form">
				  	<div class="form-group">
						<label for="inputWho" class="col-sm-2 control-label">Who</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputWho" value="<?=$who?>" placeholder="Who are you?" />
						</div>
				  	</div>
				  	<div class="form-group">
						<label for="inputMusic" class="col-sm-2 control-label">Music</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputMusic" value="<?=$music?>" placeholder="How to name the music?" />
						</div>
				  	</div>
				  	<div class="form-group">
						<label for="inputWhen" class="col-sm-2 control-label">When</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputWhen" value="" placeholder="Ex: 20140214" />
						</div>
				  	</div>
				  	<div class="form-group">
						<label for="inputMethod" class="col-sm-2 control-label">Method</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputMethod" value="<?=$method?>" placeholder="Real / KOSS / STAX / ..." />
						</div>
				  	</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-7 radio-inline">
							<label class="col-sm-6">
								<input name="inputChannel" type="radio" value="8" checked /> 8 Channel
							</label>
							<label class="col-sm-6">
								<input name="inputChannel" type="radio" value="5" /> 5 Channel
							</label>
						</div>
						<div class="col-sm-2">
							<button type="button" class="btn btn-default" onclick="create()">Create</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>