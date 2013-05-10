// JavaScript for PHP Report Maker 3
// (C) 2007-2009 e.World Technology Ltd.

var EW_REPORT_TABLE_CLASS = "ewTable";
//var EW_REPORT_TABLE_ROW_CLASSNAME = "ewTableRow";
//var EW_REPORT_TABLE_ALT_ROW_CLASSNAME = "ewTableAltRow";

// Get Ctrl key for multiple column sort
function ewrpt_Sort(e, url) {
	var newUrl = url
	if (e.ctrlKey)
		newUrl += "&ctrl=1";
	location = newUrl;
	return true;
}

function ewrpt_SetFocus(input_object) {
	if (!input_object || !input_object.type)
		return;
	var type = input_object.type;	 			
	if (type == "radio" || type == "checkbox") {
		if (input_object[0])
			input_object[0].focus();
		else
			input_object.focus();
	}	else { 
		input_object.focus();  
	}  
	if (type == "text" || type == "password" || type == "textarea" || type == "file") {
			input_object.select();
	}
}

function ewrpt_OnError(input_object, error_message) {
	alert(error_message);
	ewrpt_SetFocus(input_object);
	return false;	
}

// Check if object has value
function ewrpt_HasValue(obj) {
	if (!obj)
		return true;
	var type = (!obj.type && obj[0]) ? obj[0].type : obj.type;
	if (type == "text" || type == "password" || type == "textarea" ||
		type == "file" || type == "hidden") {
		return (obj.value.length != 0);
	} else if (type == "select-one") {
		return (obj.selectedIndex > 0);
	} else if (type == "select-multiple") {
		return (obj.selectedIndex > -1);
	} else if (type == "checkbox") {
		if (obj[0]) {
			for (var i=0; i < obj.length; i++) {
				if (obj[i].checked)
				return true;
			}
			return false;
		}
	} else if (type == "radio") {
		if (obj[0]) {
			for (var i=0; i < obj.length; i++) {
				if (obj[i].checked)
				return true;
			}
			return false;
		} else {
			return obj.checked;
		}
	}
	return true;
}

// Date (mm/dd/yyyy)
function ewrpt_CheckUSDate(object_value) {
	if (object_value.length == 0)
		return true;
	
	isplit = object_value.indexOf(EW_REPORT_DATE_SEPARATOR);
	
	if (isplit == -1 || isplit == object_value.length)
		return false;
	
	sMonth = object_value.substring(0, isplit);
	
	if (sMonth.length == 0)
		return false;
	
	isplit = object_value.indexOf(EW_REPORT_DATE_SEPARATOR, isplit + 1);
	
	if (isplit == -1 || (isplit + 1 ) == object_value.length)
		return false;
	
	sDay = object_value.substring((sMonth.length + 1), isplit);
	
	if (sDay.length == 0)
		return false;
	
	isep = object_value.indexOf(' ', isplit + 1); 
	if (isep == -1) {
		sYear = object_value.substring(isplit + 1);
	} else {
		sYear = object_value.substring(isplit + 1, isep);
		sTime = object_value.substring(isep + 1);
		if (!ewrpt_CheckTime(sTime))
			return false; 
	}
	
	if (!ewrpt_CheckInteger(sMonth)) 
		return false;
	else if (!ewrpt_CheckRange(sMonth, 1, 12)) 
		return false;
	else if (!ewrpt_CheckInteger(sYear)) 
		return false;
	else if (!ewrpt_CheckRange(sYear, 0, 9999)) 
		return false;
	else if (!ewrpt_CheckInteger(sDay)) 
		return false;
	else if (!ewrpt_CheckDay(sYear, sMonth, sDay))
		return false;
	else
		return true;
}

// Date (yyyy/mm/dd)
function ewrpt_CheckDate(object_value) {
	if (object_value.length == 0)
		return true;
	
	isplit = object_value.indexOf(EW_REPORT_DATE_SEPARATOR);
	
	if (isplit == -1 || isplit == object_value.length)
		return false;
	
	sYear = object_value.substring(0, isplit);
	
	isplit = object_value.indexOf(EW_REPORT_DATE_SEPARATOR, isplit + 1);
	
	if (isplit == -1 || (isplit + 1 ) == object_value.length)
		return false;
	
	sMonth = object_value.substring((sYear.length + 1), isplit);
	
	if (sMonth.length == 0)
		return false;
	
	isep = object_value.indexOf(' ', isplit + 1); 
	if (isep == -1) {
		sDay = object_value.substring(isplit + 1);
	} else {
		sDay = object_value.substring(isplit + 1, isep);
		sTime = object_value.substring(isep + 1);
		if (!ewrpt_CheckTime(sTime))
			return false; 
	}
	
	if (sDay.length == 0)
		return false;
	
	if (!ewrpt_CheckInteger(sMonth)) 
		return false;
	else if (!ewrpt_CheckRange(sMonth, 1, 12)) 
		return false;
	else if (!ewrpt_CheckInteger(sYear)) 
		return false;
	else if (!ewrpt_CheckRange(sYear, 0, 9999)) 
		return false;
	else if (!ewrpt_CheckInteger(sDay)) 
		return false;
	else if (!ewrpt_CheckDay(sYear, sMonth, sDay))
		return false;
	else
		return true;
}

// Date (dd/mm/yyyy)
function ewrpt_CheckEuroDate(object_value) {
	if (object_value.length == 0)
	  return true;
	
	isplit = object_value.indexOf(EW_REPORT_DATE_SEPARATOR);
	
	if (isplit == -1 || isplit == object_value.length)
		return false;
	
	sDay = object_value.substring(0, isplit);
	
	monthSplit = isplit + 1;
	
	isplit = object_value.indexOf(EW_REPORT_DATE_SEPARATOR, monthSplit);
	
	if (isplit == -1 ||  (isplit + 1 )  == object_value.length)
		return false;
	
	sMonth = object_value.substring((sDay.length + 1), isplit);
	
	isep = object_value.indexOf(' ', isplit + 1); 
	if (isep == -1) {
		sYear = object_value.substring(isplit + 1);
	} else {
		sYear = object_value.substring(isplit + 1, isep);
		sTime = object_value.substring(isep + 1);
		if (!ewrpt_CheckTime(sTime))
			return false; 
	}
	
	if (!ewrpt_CheckInteger(sMonth)) 
		return false;
	else if (!ewrpt_CheckRange(sMonth, 1, 12)) 
		return false;
	else if (!ewrpt_CheckInteger(sYear)) 
		return false;
	else if (!ewrpt_CheckRange(sYear, 0, null)) 
		return false;
	else if (!ewrpt_CheckInteger(sDay)) 
		return false;
	else if (!ewrpt_CheckDay(sYear, sMonth, sDay)) 
		return false;
	else
		return true;
}

function ewrpt_CheckDay(checkYear, checkMonth, checkDay) {
	maxDay = 31;
	
	if (checkMonth == 4 || checkMonth == 6 || checkMonth == 9 || checkMonth == 11) {
		maxDay = 30;
	} else if (checkMonth == 2) {
		if (checkYear % 4 > 0)
			maxDay =28;
		else if (checkYear % 100 == 0 && checkYear % 400 > 0)
			maxDay = 28;
		else
			maxDay = 29;
	}
	
	return ewrpt_CheckRange(checkDay, 1, maxDay);
}

function ewrpt_CheckInteger(object_value) {
	if (object_value.length == 0)
		return true;
	
	var decimal_format = ".";
	var check_char;
	
	check_char = object_value.indexOf(decimal_format);
	if (check_char < 1)
		return ewrpt_CheckNumber(object_value);
	else
		return false;
}

function ewrpt_NumberRange(object_value, min_value, max_value) {
	if (min_value != null) {
		if (object_value < min_value)
			return false;
	}
	
	if (max_value != null) {
		if (object_value > max_value)
			return false;
	}
	
	return true;
}

function ewrpt_CheckNumber(object_value) {
	if (object_value.length == 0)
		return true;
	
	var start_format = " .+-0123456789";
	var number_format = " .0123456789";
	var check_char;
	var decimal = false;
	var trailing_blank = false;
	var digits = false;
	
	check_char = start_format.indexOf(object_value.charAt(0));
	if (check_char == 1)
		decimal = true;
	else if (check_char < 1)
		return false;
	 
	for (var i = 1; i < object_value.length; i++)	{
		check_char = number_format.indexOf(object_value.charAt(i))
		if (check_char < 0) {
			return false;
		} else if (check_char == 1)	{
			if (decimal)
				return false;
			else
				decimal = true;
		} else if (check_char == 0) {
			if (decimal || digits)	
			trailing_blank = true;
		}	else if (trailing_blank) { 
			return false;
		} else {
			digits = true;
		}
	}	
	
	return true;
}

function ewrpt_CheckRange(object_value, min_value, max_value) {
	if (object_value.length == 0)
		return true;
	
	if (!ewrpt_CheckNumber(object_value))
		return false;
	else
		return (ewrpt_NumberRange((eval(object_value)), min_value, max_value));	
	
	return true;
}

function ewrpt_CheckTime(object_value) {
	if (object_value.length == 0)
		return true;
	
	isplit = object_value.indexOf(':');
	
	if (isplit == -1 || isplit == object_value.length)
		return false;
	
	sHour = object_value.substring(0, isplit);
	iminute = object_value.indexOf(':', isplit + 1);
	
	if (iminute == -1 || iminute == object_value.length)
		sMin = object_value.substring((sHour.length + 1));
	else
		sMin = object_value.substring((sHour.length + 1), iminute);
	
	if (!ewrpt_CheckInteger(sHour))
		return false;
	else if (!ewrpt_CheckRange(sHour, 0, 23)) 
		return false;
	
	if (!ewrpt_CheckInteger(sMin))
		return false;
	else if (!ewrpt_CheckRange(sMin, 0, 59))
		return false;
	
	if (iminute != -1) {
		sSec = object_value.substring(iminute + 1);		
		if (!ewrpt_CheckInteger(sSec))
			return false;
		else if (!ewrpt_CheckRange(sSec, 0, 59))
			return false;	
	}
	
	return true;
}

function ewrpt_CheckPhone(object_value) {
	if (object_value.length == 0)
		return true;
	
	if (object_value.length != 12)
		return false;
	
	if (!ewrpt_CheckNumber(object_value.substring(0,3)))
		return false;
	else if (!ewrpt_NumberRange((eval(object_value.substring(0,3))), 100, 1000))
		return false;
	
	if (object_value.charAt(3) != "-" && object_value.charAt(3) != " ")
		return false
	
	if (!ewrpt_CheckNumber(object_value.substring(4,7)))
		return false;
	else if (!ewrpt_NumberRange((eval(object_value.substring(4,7))), 100, 1000))
		return false;
	
	if (object_value.charAt(7) != "-" && object_value.charAt(7) != " ")
		return false;
	
	if (object_value.charAt(8) == "-" || object_value.charAt(8) == "+")
		return false;
	else
		return (ewrpt_CheckInteger(object_value.substring(8,12)));
}


function ewrpt_CheckZip(object_value) {
	if (object_value.length == 0)
		return true;
	
	if (object_value.length != 5 && object_value.length != 10)
		return false;
	
	if (object_value.charAt(0) == "-" || object_value.charAt(0) == "+")
		return false;
	
	if (!ewrpt_CheckInteger(object_value.substring(0,5)))
		return false;
	
	if (object_value.length == 5)
		return true;
	
	if (object_value.charAt(5) != "-" && object_value.charAt(5) != " ")
		return false;
	
	if (object_value.charAt(6) == "-" || object_value.charAt(6) == "+")
		return false;
	
	return (ewrpt_CheckInteger(object_value.substring(6,10)));
}


function ewrpt_CheckCreditCard(object_value) {
	var white_space = " -";
	var creditcard_string = "";
	var check_char;
	
	if (object_value.length == 0)
		return true;
	
	for (var i = 0; i < object_value.length; i++) {
		check_char = white_space.indexOf(object_value.charAt(i));
		if (check_char < 0)
			creditcard_string += object_value.substring(i, (i + 1));
	}	
	
	if (creditcard_string.length == 0)
		return false;	 
	
	if (creditcard_string.charAt(0) == "+")
		return false;
	
	if (!ewrpt_CheckInteger(creditcard_string))
		return false;
	
	var doubledigit = creditcard_string.length % 2 == 1 ? false : true;
	var checkdigit = 0;
	var tempdigit;
	
	for (var i = 0; i < creditcard_string.length; i++) {
		tempdigit = eval(creditcard_string.charAt(i));		
		if (doubledigit) {
			tempdigit *= 2;
			checkdigit += (tempdigit % 10);			
			if ((tempdigit / 10) >= 1.0)
				checkdigit++;			
			doubledigit = false;
		}	else {
			checkdigit += tempdigit;
			doubledigit = true;
		}
	}
		
	return (checkdigit % 10) == 0 ? true : false;
}


function ewrpt_CheckSSC(object_value) {
	var white_space = " -+.";
	var ssc_string="";
	var check_char;
	
	if (object_value.length == 0)
		return true;
	
	if (object_value.length != 11)
		return false;
	
	if (object_value.charAt(3) != "-" && object_value.charAt(3) != " ")
		return false;
	
	if (object_value.charAt(6) != "-" && object_value.charAt(6) != " ")
		return false;
	
	for (var i = 0; i < object_value.length; i++) {
		check_char = white_space.indexOf(object_value.charAt(i));
		if (check_char < 0)
			ssc_string += object_value.substring(i, (i + 1));
	}	
	
	if (ssc_string.length != 9)
		return false;	 
	
	if (!ewrpt_CheckInteger(ssc_string))
		return false;
	
	return true;
}
	

function ewrpt_CheckEmail(object_value) {
	if (object_value.length == 0)
		return true;
	
	if (!(object_value.indexOf("@") > -1 && object_value.indexOf(".") > -1))
		return false;    
	
	return true;
}
	
// GUID {xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx}	
function ewrpt_CheckGUID(object_value)	{
	if (object_value.length == 0)
		return true;
	if (object_value.length != 38)
		return false;
	if (object_value.charAt(0)!="{")
		return false;
	if (object_value.charAt(37)!="}")
		return false;	
	
	var hex_format = "0123456789abcdefABCDEF";
	var check_char;	
	
	for (var i = 1; i < 37; i++) {		
		if ((i==9) || (i==14) || (i==19) || (i==24)) {
			if (object_value.charAt(i)!="-")
				return false;
		} else {
			check_char = hex_format.indexOf(object_value.charAt(i));
			if (check_char < 0)
				return false;
		}
	}
	return true;
}

function ewrpt_HtmlEncode(text) {
	var str = text;
	str = str.replace(/&/g, '&amp');
	str = str.replace(/\"/g, '&quot;');
	str = str.replace(/</g, '&lt;');
	str = str.replace(/>/g, '&gt;'); 
	return str;
}

// Extended basic search clear form
function ewrpt_ClearForm(objForm){
	with (objForm) {
		for (var i=0; i<elements.length; i++){
			var tmpObj = eval(elements[i]);
			if (tmpObj.type == "checkbox" || tmpObj.type == "radio"){
				tmpObj.checked = false;
			} else if (tmpObj.type == "select-one"){
				tmpObj.selectedIndex = 0;
			} else if (tmpObj.type == "select-multiple") {
				for (var j=0; j<tmpObj.options.length; j++)
					tmpObj.options[j].selected = false;
			} else if (tmpObj.type == "text"){
				tmpObj.value = "";
			}
		}
	}
}

// Handle search operator changed
function ewrpt_SrchOprChanged(id) {
	var elem = document.getElementById(id);
	if (!elem) return;
	var f = elem.form;
	var isBetween = (elem.options[elem.selectedIndex].value == "BETWEEN");
	var arEl, arChildren;
	arEl = document.getElementsByName("btw0_" + id.substr(4));
	for (var i=0; i < arEl.length; i++)
		arEl[i].style.display = (isBetween) ? "none" : "";
	arEl = document.getElementsByName("btw1_" + id.substr(4));
	for (var i=0; i < arEl.length; i++) {
		arEl[i].style.display = (isBetween) ? "" : "none";
	}
	var sv2, sc;
	sc = document.getElementsByName("sc_" + id.substr(4));
	sv2 = document.getElementById("sv2_" + id.substr(4));
	if (sc.length == 0 && sv2) sv2.disabled = !isBetween;
}

// Toggle filter panel
function ewrpt_ToggleFilterPanel() {
	if (!document.getElementById)
		return;
	var img = document.getElementById("ewrptToggleFilterImg");
	var p = document.getElementById("ewrptExtFilterPanel");
	if (!p || !img)
		return;
	if (p.style.display == "") {
		p.style.display = "none";
		if (img.tagName == "IMG")
			img.src= EW_REPORT_IMAGES_FOLDER + "/expand.gif";
	} else {
		p.style.display = "";
		if (img.tagName == "IMG")
			img.src= EW_REPORT_IMAGES_FOLDER + "/collapse.gif";
	}
}

// Setup table
function ewrpt_SetupTable(tbl) {
	if (!tbl || !tbl.rows)
		return;
	var r, cnt;
	cnt = tbl.rows.length;
	if (cnt == 0)
		return;
	for (var i=0; i < cnt; i++) {
		r = tbl.rows[i];
		r.cells[r.cells.length-1].style.borderRight = "0"; // last column
	}
	if (cnt > 0) {
		r = tbl.rows[tbl.rows.length-1]; // last row
		cnt = r.cells.length;
		for (var i=0; i < cnt; i++)
			r.cells[i].style.borderBottom = "0";
	}
}