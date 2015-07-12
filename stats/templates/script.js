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
		document.CUSTOMCOMMAND.COMMAND.value = ("say " + document.COMMONCOMMANDS.NAMA.value + " \(" + document.COMMONCOMMANDS.AIPI.value + "\)\: " + document.COMMONCOMMANDS.SAY.value);
		document.CUSTOMCOMMAND.submit();
		}