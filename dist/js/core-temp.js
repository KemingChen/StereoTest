var items = {};
function addItem(){
	var dataInput = $("input[name=Direct]:checked");
	var numberInput = $("input[type=number]");
	if(dataInput.val()){
		items[numberInput.val()] = dataInput.val();
		numberInput.val(parseInt(numberInput.val()) + 1);	
		dataInput.removeAttr("checked");
		show();
	}
}

function show(){
	var output = "";
	for(var i in items){
		output += i + ". " + items[i] + "\r\n";
	}
	$("textarea").val(output);
}