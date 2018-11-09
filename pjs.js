$(document).ready(function (e) {
				$("#tests").on('submit',(function(e) {
					e.preventDefault();
					$.ajax({
						url: "process.php?searchdata="  + document.getElementById("searchdata").value ,
						type: "POST",
						data:  new FormData(this),
						contentType: false,
						cache: false,
						processData:false,
						success: function(data)
						{
						$("#inputform").html(data);
						},
						error: function() 
						{
						} 	        
				   });
				}));
				});

var xmlhttp = new XMLHttpRequest();

var load;




function searchfriend(whr,who)
{
	if(whr == "srch") var serverPage = "process.php?" + whr + "=" + document.getElementById("search-term").value;
	else var serverPage = "processmail.php?" + whr + "=" + document.getElementById("to").value;
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



function addfriend()
{
	var serverPage = "process.php?myid=" + document.getElementById("mid").value + "&fid=" + document.getElementById("fid").value;
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById("rpl").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.send(null);
}
