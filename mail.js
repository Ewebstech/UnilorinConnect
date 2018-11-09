// JavaScript Document

/*
	WebApp-title:	Hospital management system
	Author:			Peter Umoren
	Phone number:	08076238524
	Date:			24/june/2015
*/

var xmlhttp = new XMLHttpRequest();

var load;

load = 1; setTimeout("checkd()",168); setTimeout("notify()",580); setTimeout("invites()",780);


function test(whr)
{
	form.action = "processmail.php?" + whr;
	form.submit();
}

function checkd()
{
	if(load)
	{
		load = 0;
		var serverPage = "processmail.php?msgd&load";
	}
	else var serverPage = "processmail.php?msgd"
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById("navmsg").innerHTML = xmlhttp.responseText;
			document.getElementById("msgp").innerHTML = xmlhttp.responseText;
			document.getElementById("inner").innerHTML = xmlhttp.responseText;
			setTimeout("checkd()",8640);
			setTimeout(check,576,"msgcont","msg")
		}
	}
	xmlhttp.send(null);
}

function notify()
{
	var serverPage = "processmail.php?not";
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById("not").innerHTML = xmlhttp.responseText;
			document.getElementById("value").innerHTML = xmlhttp.responseText;
			document.getElementById("reqii").innerHTML = xmlhttp.responseText;
			setTimeout("notify()",5000);
			setTimeout(check,576,"notif","notmsg")
		}
	}
	xmlhttp.send(null);
}

function invites()
{
	var serverPage = "process.php?inv";
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById("first").innerHTML = xmlhttp.responseText;
			document.getElementById("second").innerHTML = xmlhttp.responseText;
			document.getElementById("third").innerHTML = xmlhttp.responseText;
			setTimeout("invites()",5000);
			
		}
	}
	xmlhttp.send(null);
}


function check(whr,who)
{
	if(whr == "users") var serverPage = "processmail.php?" + whr + "=" + document.getElementById("to").value;
	else var serverPage = "process.php?" + whr;
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById(who).innerHTML = xmlhttp.responseText;
			if(who == "msgp") setTimeout(check,9600,whr,who);
			
		}
	}
	xmlhttp.send(null);
}


function searchfriend1(whr,who)
{
	if(whr == "srch") var serverPage = "processmail.php?" + whr + "=" + document.getElementById("search-term").value;
	else var serverPage = "processmail.php?" + whr;
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById(who).innerHTML = xmlhttp.responseText;
			//if(who == "msgp") setTimeout(check,9600,whr,who);
		}
	}
	xmlhttp.send(null);
}

function add()
{
	n = 0;
	f = document.getElementById("form");
	l = f.childNodes.length - 2;
	for(i=0;i<f.childNodes.length;i++)
	{
		if(f.childNodes.item(i).className == "form-group") n++;
	}
	//alert(l);
	if(qualen > n-1)
	{
		//document.forms[0].item().
		//alert(document.forms[0].elements[2].name);
		d = document.createElement("div");
		tra = "<div class=\"col-xs-9 pull-left no-padding\"><label for=\"inputEmail3\">Select Product "+n+"</label><select class=\"form-control\" name=\"productsold"+n+"\" onBlur=\"reg(this)\"><option value=\"\">Click or Search Product</option>"+opt.join(" ")+"</select></div><div class=\"col-xs-3 pull-right\"><label for=\"inputEmail3\">Quantity</label><input type=\"number\" class=\"form-control\" id=\"inputEmail3\" name=\"qtysold"+n+"\" size=\"10\" min=\"1\" /></div><br clear=\"all\" />";
		d.setAttribute("class","form-group");
		d.innerHTML = tra;
		f.insertBefore(d,f.childNodes.item(l));
	}
}

function reg(nam)
{
	
	for(i = 0;i < form.elements.length;i++)
	{
		if(form.elements[i].type == "select-one" && form.elements[i].name != nam.name)
		{
			
			el = form.elements[i];
			for(j = 0;j < form.elements[i].length;j++)
			{
				
				if(nam.value == el.options[j].value && el.options[j].value != "")
				{
					el.remove(j);
					opt.splice(j-1,1);
					qua.splice(j-1,1);
				}
			}
		}
	}
}

var l;

function remove()
{
	va = new Array();
	f = document.getElementById("form");
	for(i=0;i<f.childNodes.length;i++)
	{
		if(f.childNodes.item(i).className == "form-group") va.push(i);
	}
	if(va[va.length-2] != 1) f.removeChild(f.childNodes[va[va.length-2]]);
}

function up(id)
{
	document.getElementById(id).innerHTML = "<form name='form' method='post'><select onChange='subit(this,\""+id+"\")'><option>pending</option><option>received</option><option>cancelled</option></select></form>";
}

function subit(obj,id)
{
	
	//form.method = "get";
	form.action = "processmail.php?pro=" + obj.value + "&pid=" + id;
	form.submit();
}