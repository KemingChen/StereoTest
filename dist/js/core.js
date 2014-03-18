var data = {
	now: undefined,
	filename: "",
	state: "none",
	items: {},
	ans: {},
	info: {},
}

function init(){
	var now = new Date();
	var date = {
		year: format(now.getFullYear()),
		month: format(now.getMonth() + 1),
		day: format(now.getDate()),
	};

	$("#inputWhen").val(date.year + date.month + date.day);

	function format(num){
		if(num < 10)
			return "0" + num.toString();
		return num.toString();
	}
}

function getDirectFromId(id){
	var idToDirect = {
		"D0": 0, 
		"D1": 45, 
		"D2": 90, 
		"D3": 135, 
		"D4": 180, 
		"D5": 225, 
		"D6": 270, 
		"D7": 315
	};
	return idToDirect[id];
}

function getNameFromDirect(direct){
	var D2Name = {
		"?": "？？", 
		0: "前面", 
		45: "左前", 
		90: "左邊", 
		135: "左後", 
		180: "後面", 
		225: "右後", 
		270: "右邊", 
		315: "右前"
	};
	return D2Name[direct];
}

function getLabelText(i, direct){
	var out = i < 10 ? "0" : "";
	out = out + i + "-" + getNameFromDirect(direct);
	return out;
}	

function toNext(){
	data.now++;
	$("#QuestionNumber").val(data.now);
	$("#QTitle input").val((data.now) + " - " + getNameFromDirect(data.ans[data.now]));
}

function makeAnswer(obj){
	if(data.state == "none" || data.state == "wait"){
		alert("尚未播音樂!!!");
		return;
	}
	stop();

	var direct = getDirectFromId($(obj).attr("id"));
	data.items[data.now] = direct;

	var label = $("#Q" + data.now);
	label.removeClass("label-default").addClass("label-success");
	label.html(getLabelText(data.now, direct));

	toNext();
}

function checkValid(){
	for(var i in data.info){
		if(data.info[i] == "" || isNaN(data.info.channel)){
			alert("資料不完整!!!");
			return false;
		}
	}
	return true;
}

function generatorRandom(channel, frequency, kind){
	var channel = 8, frequency = 2, kind = 3;
	var channels = {
		5: [0, 45, 135, 225, 315],
		8: [0, 45, 90, 135, 180, 225, 270, 315],
	}, result = {}, temp = [];

	for(var i = 0; i < kind; i++){
		temp[i] = [];
		for(var j = 0; j < frequency; j++){
			temp[i] = temp[i].concat(channels[channel]);
		}
		temp[i] = shuffle(shuffle(shuffle(temp[i])));
	}

	for(var i = 0, count = 1; i < kind; i++){
		for(var j = 0; j < channel * frequency; j++){
			result[count] = temp[i][j];
			count++;
		}
	}

	return result;

	function shuffle(o){ //v1.0
	    for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
	    return o;
	}
}

function create(){
	data.info.who = $("#inputWho").val();
	data.info.music = $("#inputMusic").val();
	data.info.when = $("#inputWhen").val();
	data.info.method = $("#inputMethod").val();
	data.info.channel = parseInt($('input[name=inputChannel]:checked').val());
	data.info.frequency = 2;
	data.info.kind = 2;

	if(checkValid()){
		data.filename = data.info.when + "-" + data.info.who + "-" + data.info.music + "-" + data.info.method + "-" + data.info.channel + "channel";
		data.now = 0;
		data.state = "wait";
		data.items = {};
		data.ans = generatorRandom(data.info.channel, data.info.frequency, data.info.kind);
	
		$("#OtherContorl").hide();
		$("#QTitle input").val(data.filename);

		$("#QTotal").show();
		var qInfo = $("#QInfo");
		qInfo.html('');

		for(var i = 1; i <= data.info.channel * data.info.frequency * data.info.kind; i++){
			data.items[i] = undefined;
			qInfo.append('<span id="Q' + i + '" class="label label-default Qlabel" onclick="change(this)">' + getLabelText(i, "?") + '</span>\r\n');
			if(i % 6 == 0)
				qInfo.append('<br /><br />');
		}

		toNext();
	}
}

function play(){
	$("#MusicPlayer").attr("src", "sound/" + data.info.who + "/(" + data.now + ").wav");
	$("#MusicPlayer")[0].play();
	data.state = "ready";
}

function stop(){
	$("#MusicPlayer").attr("src", "");
	data.state = "wait";
}

function change(obj){
	data.now = parseInt($(obj).attr("id").replace("Q", "")) - 1;

	toNext();
	console.log(data.now);
}

function putArray(objs){
	var result = [];
	for(var i in objs){
		result.push(objs[i]);
	}
	return result;
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


function show(){
	console.log(filename + "\r\n" + "ANS: " + JSON.stringify(items) + "\r\n" + "STD: " + JSON.stringify(ans));
}