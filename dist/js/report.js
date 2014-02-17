function parseStdAns(music){
	var result = Array();
	var data = $("#StdAns").val().match(new RegExp(music + '\\d*.wav', 'g'));

	for(var i = 0; i < data.length; i++){
		result[i] = data[i].match(new RegExp(music + '(\\d*).wav'))[1];
	}
	console.log(result);
	return result;
}

function parseAns(isMirror){
	var result = Array();
	var data = $("#Ans").val().match(/\d*. \d*/g);

	for(var i = 0; i < data.length; i++){
		result[i] = data[i].match(/\d*. (\d*)/)[1];
		if(isMirror){
			result[i] = (360 - result[i]) % 360;
		}
	}
	console.log(result);
	return result;
}

function calculate(){
	var isMirror = $("#mirror").get(0).checked;
	var ans = parseAns(isMirror);
	var stdAns = parseStdAns('music');
	
	$("input[name=ANS]").val(JSON.stringify(ans));
	$("input[name=STDANS]").val(JSON.stringify(stdAns));
	$("input[name=Filename]").val("Report");
	$("form").submit();
}