<?php

if(!isset($_SESSION))
 session_start();
 ob_start();
error_reporting(0);
include("temp/database.php");

if(isset($_SESSION["email"]))
 $name = $_SESSION["name"];



if(isset($_REQUEST["msgd"]))
{
	//set_time_limit(0);
	$timeout = 13;
	$en = 0;
	while($en < $timeout)
	{
		//clearstatcache();
		$query = "SELECT * FROM mail WHERE reciever = '$_SESSION[username]' AND `status`= 'unread'";
		$resulti = mysql_query($query);
		$mailrow = mysql_num_rows($resulti);
		$mailnotread = mysql_fetch_array($resulti);
		if(!isset($_SESSION["lastmsgupd"]))
		{
			$_SESSION["lastmsgupd"] = $mailrow;
			echo $mailrow;
			break;
		}
		elseif($_SESSION["lastmsgupd"] != $mailrow)
		{
			$_SESSION["lastmsgupd"] = $mailrow;
			echo $mailrow;
			break;
		}
		elseif(isset($_REQUEST["load"]))
		{
			echo $mailrow;
			break;
		}
		else
		{
			$en++;
			usleep(8640);
		}
	}
	if($en == $timeout) echo $mailrow;
	
	exit;
}


if(isset($_REQUEST["msgcont"]))
{
			
}

if(isset($_REQUEST["not"]))
{
	$timeout = 13;
	$en = 0;
	$time = time();
	while($en < $timeout)
	{
		//clearstatcache();
		$stdid = substr($_SESSION['userid'], 0,33);
		$query = "SELECT * FROM $stdid WHERE status='pending' and email != '$_SESSION[email]'";
		$resulti = mysql_query($query);
		$notrow = mysql_num_rows($resulti);
		
		if(!isset($_SESSION["lastnotupd"]))
		{
			$_SESSION["lastnotupd"] = $notrow;
			echo $notrow;
			break;
		}
		elseif($_SESSION["lastnotupd"] != $notrow)
		{
			$_SESSION["lastnotupd"] = $notrow;
			echo $notrow;
			break;
		}
		elseif(isset($_REQUEST["load"]))
		{
			echo $notrow;
			break;
		}
		else
		{
			$en++;
			usleep(8640);
		}
	}
	
	if($en == $timeout) echo $notrow;
	
	exit;

}

if(isset($_REQUEST["notif"]))
{
	$time = time();
	$query = "SELECT * FROM notifications WHERE expiration > $time";
	$result = mysql_query($query);
	while($notifynotread = mysql_fetch_assoc($result))
	{
?>

		<li>
			<a href="#">
			  <i class="fa fa-users text-aqua"></i><?php echo $notifynotread["subject"]; ?>
			</a>
		  </li>
<?php
	}
}


if(isset($_REQUEST["mail"]))
{
	if(isset($_REQUEST["mail"]))
{
	echo "<select>";
	$query = "SELECT * FROM profile WHERE username LIKE \"$_REQUEST[mail]%\"";
	$result = mysql_query($query);
	while($row = mysql_fetch_assoc($result)){
		$m = mysql_query("SELECT * FROM personals WHERE id='$row[id]'");
		$mname = mysql_fetch_assoc($m);
	 echo "<option value='$row[username]'>$row[firstname] $mname[middlename] $row[lastname]</option>";
	}
	echo "</select>";
}
}

if(isset($_POST["compose"]))
{
	if(empty($_POST["to"]) or empty($_POST["subject"]))
	{ header("location:composemessage.php"); exit; }
	else
	{
		$query = "SELECT * FROM staffdata WHERE email = '$_SESSION[email]'";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		$to = mysql_real_escape_string(htmlentities($_POST["to"]));
		$subject = mysql_real_escape_string(htmlentities($_POST["subject"]));
		$msg = mysql_real_escape_string($_POST["text"]);
		$sender = "$row[firstname] $row[lastname]";
		$time = time();
		$id = uniqid();
		
		$query = "CREATE TABLE IF NOT EXISTS `mail` ( id VARCHAR(50), receiver VARCHAR(50), subject VARCHAR(70), sender VARCHAR(50), sendername VARCHAR(50), msg TEXT, time VARCHAR(20), status VARCHAR(10), PRIMARY KEY(id))";
		$result = mysql_query($query);
		$query = "INSERT INTO `mail` (`id`,`receiver`,`subject`,`sender`,`sendername`,`msg`,`time`,`status`) VALUES ('$id','$to','$subject','$_SESSION[email]','$sender','$msg','$time','unread')";
		$result = mysql_query($query,$conn);
		if(empty($_POST["attachment"]) and $result)
		{
			header("location:composemessage.php?success");
			exit;
		}
		if(empty($_POST["attachment"]) and !$result)
		{
			header("location:composemessage.php?succ");
			exit;
		}

	}
	$file_upload="true";

	if ($_FILES["attachment"]["size"]>5000000){$msg=$msg."<div class='failure-upload'>Your uploaded file size is more than 2500KB
	so please reduce the file size and then upload.</div><BR>";
	$file_upload="false";}
	$type = end(explode('.', strtolower($_FILES["attachment"]["name"])));
	$allowtype = array("pdf","docx","doc");
	if (in_array($type, $allowtype))
	{
		$add = "mailupload/$id/$document_name".".$type";
	}
	else
	{$msg=$msg."<div class='failure-upload'>File Not Uploaded!! - Your uploaded file must be of <b>PDF, DOCX OR DOC</b>. 
	Other file types are not allowed<BR>
	
	</div>";
	$file_upload="false";}
	if($file_upload=="true")
	{
		if(!is_dir("mailupload")){  mkdir("mailupload"); }
		if(!is_dir("mailupload/$id")){ mkdir("mailupload/$id"); }
		if(move_uploaded_file ($_FILES["attachment"]["tmp_name"], $add)){
			
			header("location:composemessage.php?success");
		}
		else{echo "<div class='failure-upload'>Failed to upload file Contact Site admin to fix the problem</div>";}
	}
	else{header("location:composemessage.php?err");}
	exit;
}

if(isset($_REQUEST["trash"]))
{
	if(isset($_POST["trash"]))
	{
		$query = "DELETE FROM mail WHERE id = '".$_POST["trash"]."'";
		$result = mysql_query($query);
		header("location: home.php?messages");
		exit;
	}
	if(isset($_POST["msgid"]))
	{
		foreach($_POST["msgid"] as $key => $value)
		{
			$query = "DELETE FROM mail WHERE id = '".$value."'";
			if($result = mysql_query($query)) header("location:home.php?messages");
		}
	}
	exit;
}

if(isset($_POST['sendthismessage']))
{
	
	if($_POST['to'] != "" and $_POST['message'] != "" and $_POST['subject'] != "" or $_POST['document_name'] != "")
	{
		//save data to database
		include("temp/database.php");
				
		//create table
						
		$sql= "	Create Table if not exists `mail` (id VARCHAR(50),
				reciever VARCHAR( 253 ),
				subject VARCHAR(250),
				sender VARCHAR(252),
				sendername VARCHAR (200),
				msg TEXT,
				time VARCHAR (200),
				status VARCHAR (200),
				PRIMARY KEY ( id )
				)";
		// Execute query
		if (!mysql_query($sql,$conn)) {
					echo "Error creating table: " . mysql_error($conn);
		}
		else
		{
		// escaping variables for security
			date_default_timezone_set('GMT');
			$id = time();
			$reciever = $_POST['to'];
			$subject = mysql_real_escape_string ($_POST['subject']);
			$message = mysql_real_escape_string ($_POST['message']);
			$type = end(explode('.', strtolower($_FILES[image][name])));
			$sender = $_SESSION["userid"];
			$status = "unread";		
		    $uid = uniqid();
			$get = mysql_query("select * from profile where id='$_SESSION[userid]'");
			$result = mysql_fetch_assoc($get);
		
			$sql = "INSERT INTO `mail` (id, reciever, subject, sender, sendername, msg, time, status) values ('$uid', '$reciever', '$subject', '$sender', '$result[firstname] $result[lastname] [$result[email]]', '$message', '$id', '$status')";
		
			$retval = mysql_query( $sql, $conn );
			if(! $retval )
			{
			  die(mysql_error($conn));
			}
			echo "<span class='data-reg'>";
				
			if(! $conn )
			{
			  die('Could not connect:' . mysql_error());
			}
		
		
		$file_upload="true";
			$file_up_size=$_FILES['file_up'][size];
			if ($_FILES[image][size]>5000000){$msg=$msg."<div class='failure-upload'>Your uploaded file size is more than 2500KB
	 		so please reduce the file size and then upload.</div><BR>";
			$file_upload="false";}
			$type = end(explode('.', strtolower($_FILES[image][name])));
			$allowtype = array("pdf","docx","doc");
			if (in_array($type, $allowtype))
			{
				$add = "mailupload/$id/$document_name".".$type";
			}
			else
			{$msg=$msg."<div class='failure-upload'>File Not Uploaded!! - Your uploaded file must be of <b>PDF, DOCX OR DOC</b>. 
			Other file types are not allowed<BR>
			
			</div>";
			$file_upload="false";}
			if($file_upload=="true")
			{
				if(!is_dir("mailupload")){  mkdir("mailupload"); }
				if(!is_dir("mailupload/$id")){ mkdir("mailupload/$id"); }
				if(move_uploaded_file ($_FILES[image][tmp_name], $add)){
					
					header("location: ?&cid=success");
				}
				else{echo "<div class='failure-upload'>Failed to upload file Contact Site admin to fix the problem</div>";}
			}
			else{header("location: home.php?composemessage&cid=noupload");}
			
		
		}
	}
	else{header("location: ?&cid=emptyform");}
}

if(isset($_REQUEST["grpn"]))
{
	
		
}



?>