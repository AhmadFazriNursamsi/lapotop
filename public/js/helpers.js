
function getAllClassAndVal(nameclass, methode = 1){
	// methode 1 = get;
	// methode 2 = post;

	var dataGet = "";
	i = 1;
	var dataPost = {};
	$("."+nameclass).each(function() {
		var value_src = "";
		var name_src = $(this).attr("name");
		if($(this).val().length > global_length_src || $(this)[0].tagName == 'SELECT')
			value_src = $(this).val();
	    if(i == 1)
	    	dataGet = name_src + "=" + value_src;
	    else 
	    	dataGet = dataGet + "&" + name_src + "=" + value_src;
	    i++;

	    dataPost[name_src] = value_src;

	});

	if(methode == 1)
		return dataGet;
	return dataPost;
}

function getNowdate(format = "dmy", sparator = "/"){

	const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

	var formattedDate = new Date();
	var d = formattedDate.getDate();
	var m =  formattedDate.getMonth();
	m += 1;  // JavaScript months are 0-11
	var nm = ""+m+"";
	if(nm.length == 1) nm = "0" + nm;

	var namemont = monthNames[m];

	var y = formattedDate.getFullYear();

	if(format == "mdy")
		return nm + sparator + d + sparator + y;
	else if(format == "ymd")
		return y + sparator + nm + sparator + d;
	else if(format == "dMy")
		return d + sparator + namemont + sparator + y;
	else if(format == "d M, y")
		return d + namemont + ', ' + y;
	else
		return d + sparator + nm + sparator + y;
}


function convertEpocToDate(timestamp, format = "dmy", sparator = "/"){
	
	var date = new Date(timestamp * 1000);

	var iso = date.toISOString().match(/(\d{4}\-\d{2}\-\d{2})T(\d{2}:\d{2}:\d{2})/)

	var dateAr 	= iso[1].split('-');

	if(format == 'dmy h:i:s') 
		return dateAr[2] + sparator + dateAr[1] + sparator + dateAr[0] + ' ' + iso[2]; // format dmy h:i:s
	else 
		return dateAr[2] + sparator + dateAr[1] + sparator + dateAr[0]; // format dmy

}


function convertDateToEpoc(date){
	var datum = Date.parse(date);
   	return datum/1000;
}


function setValByName(nameclass, data_value = []){
	$("."+nameclass).each(function() {
		var name_src = $(this).attr("name");
		var data_val = data_value[name_src];
		$(this).val(data_val);
		if($(this).attr("type") == 'checkbox') {
			if(data_val == 1) $(this).attr("checked", "");
			else $(this).removeAttr("checked");
		} else {
			// change epoc to date
			if($(this).hasClass("datepicker")) data_val = convertEpocToDate(data_val);
				
			$(this).val(data_val);

		}
	});
}


function clearInput(nameclass){
	$("."+nameclass).each(function() {
		if($(this).attr("type") == 'checkbox') {
			$(this).attr("checked", "");
		} else {
			$(this).val('');
		}

		// if($(this)[0].tagName == 'SELECT'){
		// 	// 
		// } else {
		// 	$(this).val('');
		// }
	});
}