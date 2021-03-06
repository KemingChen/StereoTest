var data = {
	now: undefined,
	filename: "",
	state: "none",
	playTime: undefined,
	items: {},
	info: {},
	ans: {},
	playList: {},
}

function init(){
	var now = new Date();
	var date = {
		year: format(now.getFullYear()),
		month: format(now.getMonth() + 1),
		day: format(now.getDate()),
	};

	$("#inputWhen").val(date.year + date.month + date.day);

	$.post("dirInfo.php", {
		path: "dir",
		preg: "/.*-.*-.*-.*-.*-.*/",
		random: 0,
	}, onSuccess);

	function onSuccess(response){
		var paths = JSON.parse(response);
		var source = Array();
		for(var i in paths){
			source.push(paths[i].substr(4));
		}
		console.log(source);

		if(source.length > 0){
			$("#inputLoadFilename").parents("div[class=form-group]").show();
			$("#inputLoadFilename").typeahead({
				source: source,
			});
		}
	}

	function format(num){
		if(num < 10)
			return "0" + num.toString();
		return num.toString();
	}
}

function getDirectFromId(id){
	return id.replace("D", "") * 45;
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
	var times = data.info.channel * data.info.frequency;
	var alertText = "";
	if(data.now % (times) == 1){
		alertText = " ~ 現在換 " + data.info.kind[(data.now - 1) / times] + "!!!";
	}
	$("#QuestionNumber").val(data.now);
	$("#QTitle input").val((data.now) + " - " + getNameFromDirect(data.items[data.now].SA) + "(" + (data.items[data.now].SA / 45) + ")" + alertText);
}

function makeAnswer(obj){
	if(data.state == "none" || data.state == "wait"){
		alert("尚未播音樂!!!");
		return;
	}
	stop();

	var direct = getDirectFromId($(obj).attr("id"));
	data.items[data.now].UA = direct;
	if(data.items[data.now].UT == -1)
		data.items[data.now].UT = ((new Date()).getTime() - data.playTime) / 1000;
	console.log(data.items[data.now]);

	var label = $("#Q" + data.now);
	label.removeClass("label-default").addClass("label-success");
	label.html(getLabelText(data.now, direct));

	if(data.now != data.info.channel * data.info.frequency * data.info.kind.length){
		toNext();
	}
}

function checkValid(response){
	return true;
	if(data.randomFile == ""){
		if(response == "error"){
			alert("查無音樂路徑!!!");
			return false;
		}
		if(!JSON.parse(response).hasOwnProperty(data.info.times)){
			alert("音樂數目不足!!!");
			return false;
		}
	}
	for(var i in data.info){
		if(data.info[i] == "" || isNaN(data.info.channel)){
			alert("資料不完整!!!");
			return false;
		}
	}
	return true;
}

function generatorRandom(channel, frequency, kindCount){
	var channel = 8, frequency = 2, kindCount = 3;
	var channels = {
		5: [0, 45, 135, 225, 315],
		8: [0, 45, 90, 135, 180, 225, 270, 315],
	}, result = {}, temp = [];

	for(var i = 0; i < kindCount; i++){
		temp[i] = [];
		for(var j = 0; j < frequency; j++){
			temp[i] = temp[i].concat(channels[channel]);
		}
		temp[i] = shuffle(shuffle(shuffle(temp[i])));
	}

	for(var i = 0, count = 1; i < kindCount; i++){
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
	data.info.frequency = parseInt($("#inputFrequency").val());;
	data.info.kind = $("#inputKind").val().split(",");
	data.info.times = data.info.channel * data.info.frequency * data.info.kind.length;
	data.info.mix = false;
	data.randomFile = $("#inputLoadFilename").val();
	data.startTime = undefined;

	if(data.randomFile == ""){
		$.post("dirInfo.php", {
			//path: "sound/" + data.info.who + "/" + data.info.music,
			path: "sound/" + data.info.music,
			preg: "/.*.wav/",
			info: JSON.stringify(data.info),
			random: true,
		}, onSuccessForCreate);
	}
	else{
		$.get("dir/" + data.randomFile, onSuccessForCreate);
	}

	function onSuccessForCreate(response){
		if(checkValid(response)){
			data.filename = data.info.when + "-" + data.info.who + "-" + data.info.music + "-" + data.info.method + "-" + data.info.channel + "channel";
			data.now = 0;
			data.state = "wait";
			data.items = {};

			if(data.randomFile == ""){
				data.ans = generatorRandom(data.info.channel, data.info.frequency, data.info.kind.length);
				data.playList = JSON.parse(response);
			}
			else{
				var jsonObj = JSON.parse(response);
				data.ans = jsonObj.ans;
				data.playList = jsonObj.playList;
			}

			$("#OtherContorl").hide();
			$("#QTitle input").val(data.filename);

			$("#QTotal").show();
			var qInfo = $("#QInfo");
			qInfo.html('');

			for(var i = 1; i <= data.info.channel * data.info.frequency * data.info.kind.length; i++){
				data.items[i] = {
					NO: i,
					UA: -1,  //User's Answer
					UT: -1,  //Use time
					SA: data.ans[i],//Standard Answer
				};
				qInfo.append('<span id="Q' + i + '" class="label label-default Qlabel" onclick="change(this)">' + getLabelText(i, "?") + '</span>\r\n');
				if(i % 6 == 0)
					qInfo.append('<br /><br />');
			}

			toNext();
		}
	}
}

function play(){
	if(data.startTime === undefined){
		data.startTime = (new Date()).toGMTString();
	}
	$("#MusicPlayer").attr("src", data.playList[data.now]);
	console.log($("#MusicPlayer").attr("src"));
	$("#MusicPlayer")[0].play();
	data.playTime = (new Date()).getTime();
	data.state = "ready";
}

function stop(){
	$("#MusicPlayer").attr("src", "");
	data.state = "wait";
}

function change(obj){
	data.state = "ready";
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
	data.endTime = (new Date()).toGMTString();
	$.post("save.php",{
			id: data.filename,
			current: JSON.stringify(data),
		},
		function(response){
			document.location.href = response;
			//console.log(response);
	});
}