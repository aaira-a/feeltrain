function falis() 
		{
		document.COMMONCOMMANDS.NAMA.value = (document.COMMONCOMMANDS.NAMA.value).replace(/^\s*|\s*$/g,'');
   			if ((document.COMMONCOMMANDS.NAMA.value.length==0) || (document.COMMONCOMMANDS.NAMA.value=='') || (document.COMMONCOMMANDS.NAMA.value==null)) {
				alert(":(");
   				}
			else { say(); }
		}	
function say()
		{
		setCookie();
		document.CUSTOMCOMMAND.COMMAND.value = ("say " + document.COMMONCOMMANDS.NAMA.value + " \(" + document.COMMONCOMMANDS.AIPI.value + "\)\: " + document.COMMONCOMMANDS.SAY.value);
		document.CUSTOMCOMMAND.submit();
		}


function setCookie() {
var exp = new Date();     //set new date object
exp.setTime(exp.getTime() + (1000 * 60 * 60 * 24 * 30));

document.cookie = "combiName=" + escape(document.COMMONCOMMANDS.NAMA.value) + "; path=/" + ((exp == null) ? "" : "; expires=" + exp.toGMTString());
}

function getCookie () {
	var cname = "combiName=";               
	var dc = document.cookie;

    if (dc.length > 0) {              
		begin = dc.indexOf(cname);       
			if (begin != -1) {           
			begin += cname.length;       
			end = dc.indexOf(";", begin);
				if (end == -1) end = dc.length;
				document.COMMONCOMMANDS.NAMA.value = unescape(dc.substring(begin, end));
			} 
		}
	return null;
}