function edit_station(ele) {
	
	var queueName = ele.getAttribute('value');

	document.getElementById("reset-QueueLabelLabel").innerHTML = "Add Station to " + queueName;
	document.getElementById("aS_QNe").value = queueName;
}

function ASn_validateForm() {

	var aS_SNr = document.forms["add_station"]["aS_SNr"].value;
	var aS_SNe = document.forms["add_station"]["aS_SNe"].value;
	var aS_NoWs = document.forms["add_station"]["aS_NoWs"].value;
	var aS_SAn = document.forms["add_station"]["aS_SAn"].value;

	if (aS_SNr == null || aS_SNr == "" || aS_SNe == null || aS_SNe == "" || aS_NoWs == null || aS_NoWs == ""  || aS_SAn == null || aS_SAn == ""){

		alert("Please Fill All Required Field");
      	return false;
	}
}