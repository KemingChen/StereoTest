var D2Name = {"?": "？？", 0: "前面", 45: "左前", 90: "左邊", 135: "左後", 180: "後面", 225: "右後", 270: "右邊", 315: "右前"};
var items = {};
var ans = {};
var filename;

function makeAnswer(obj){
	var idToDirect = {"D0": 0, "D1": 45, "D2": 90, "D3": 135, "D4": 180, "D5": 225, "D6": 270, "D7": 315};
	var direct = idToDirect[$(obj).attr("id")];
	var now = parseInt($("#QuestionNumber").val());

	items[now] = direct;
	$("#Q"+now).removeClass("label-default").addClass("label-success");
	$("#Q"+now).html(genQText(now, direct));

	$("#QuestionNumber").val(now + 1);
	$("#QTitle input").val((now + 1) + " - " + D2Name[ans[now + 1]]);
}

function create(){
	var who = $("#inputWho").val();
	var music = $("#inputMusic").val();
	var when = $("#inputWhen").val();
	var method = $("#inputMethod").val();
	var channel = parseInt($('input[name=inputChannel]:checked').val());
	var times = channel == 8 ? 72 : 50;
	filename = when + "-" + who + "-" + music + "-" + method + "-" + channel + "channel";


	$("#OtherContorl").hide();
	$("#QTitle input").val(filename);

	$("#QTotal").show();
	var qInfo = $("#QInfo");
	qInfo.html('');
	items = {};
	ans = generatorRandom(channel);

	for(var i = 1; i <= times; i++){
		items[i] = undefined;
		qInfo.append('<span id="Q' + i + '" class="label label-default Qlabel" onclick="change(this)">' + genQText(i, "?") + '</span>\r\n');
		if(i % 6 == 0)
			qInfo.append('<br /><br />');
	}

	$("#QuestionNumber").val(1);

	var now = 1;
	$("#QTitle input").val(now + " - " + D2Name[ans[now]]);
}

function change(obj){
	var id = $(obj).attr("id");

	var now = parseInt(id.replace("Q", ""));
	console.log(now);
	$("#QuestionNumber").val(now);
	$("#QTitle input").val(now + " - " + D2Name[ans[now]]);
}

function calculate(){
	//var isMirror = $("#mirror").get(0).checked;
	
	$.ajax({
		type: "POST",
		url: "genReport.php",
		data: { ANS: JSON.stringify(putArray(items)), STDANS: JSON.stringify(putArray(ans)), "Filename": filename}
	})
	.done(function( msg ) {
		//$("#QTotal").html(msg);
		console.log(msg);
		alert("Saved");
		//location.reload();
	});
/*
	$("input[name=ANS]").val(JSON.stringify(putArray(items)));
	$("input[name=STDANS]").val(JSON.stringify(putArray(ans)));
	$("input[name=Filename]").val(filename);
	$("form").submit();*/
}

function putArray(objs){
	var result = [];
	for(var i in objs){
		result.push(objs[i]);
	}
	return result;
}

function genQText(i, direct){
	var out = i < 10 ? "0" : "";
	out = out + i + "-" + D2Name[direct];
	return out;
}	

function generatorRandom(channel){
	var times = channel == 8 ? 9 : 10;
	var c = [], result = {};
	c[5] = [0, 45, 135, 225, 315];
	c[8] = [0, 45, 90, 135, 180, 225, 270, 315];
	var temp1 = [], temp2 = [], temp3 = [];

	temp1 = temp1.concat(c[channel],c[channel],c[channel]);
	temp2 = temp2.concat(c[channel],c[channel],c[channel]);
	temp3 = temp3.concat(c[channel],c[channel],c[channel]);

	temp1 = shuffle(shuffle(shuffle(temp1)));
	temp2 = shuffle(shuffle(shuffle(temp2)));
	temp3 = shuffle(shuffle(shuffle(temp3)));

	var i = 1;

	for(var j = 0; j < 24; j++){
		result[i] = temp1[j];
		i++;
	}
	for(var j = 0; j < 24; j++){
		result[i] = temp2[j];
		i++;
	}
	for(var j = 0; j < 24; j++){
		result[i] = temp3[j];
		i++;
	}

	return result;

	function shuffle(o){ //v1.0
	    for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
	    return o;
	}
}

function show(){
	console.log(filename + "\r\n" + "ANS: " + JSON.stringify(items) + "\r\n" + "STD: " + JSON.stringify(ans));
}

/*
$(document).bind('keydown', 'esc', function (evt) {
	if(evt.keyCode == 116 || evt.keyCode == 123)
		return true;

	var keyArray = {81:45, 87:0, 69:315, 65:90, 68:270, 90:135, 88:180, 67:225};
	console.log(evt.keyCode + ": " + keyArray[evt.keyCode]);
	return false;
});*/