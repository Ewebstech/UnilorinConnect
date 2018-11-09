<?php

include("temp/database.php");
session_start();
ob_start();
error_reporting(0);
 // Profile table name

//...............................................login script.......................

if(isset($_POST["login"]))
{ 
	$email = strtolower($_POST['email']);
	$pass = $_POST['password'];
	
	$query = "SELECT * FROM `profile` WHERE `email` = '$email'";
	$result = mysql_query($query);

	while($row = mysql_fetch_assoc($result))
		{
		
			if($row["email"] == $email)
			{ 
					
					if($row['password'] != $pass)
					{ 
						header("location: ./?cid=0026"); exit;
					}
					
					else
					{	
						$query = "UPDATE profile SET loginstatus='online' WHERE email = '$email'";
						$do = mysql_query($query);
						$_SESSION["email"] = $email;
						$_SESSION["username"] = $row["username"];
						$_SESSION["userid"] = $row["id"]; 
						header("location: home.php");
					
						exit;
						
					}
			}
			header("location: ./?err=0039"); exit;
		}
	header("location: ./?cid=0041");
}

if(isset($_REQUEST["cid"]) && $_REQUEST["cid"] == "logout46")
{

	if(isset($_SESSION["userid"])){
	$uid=$_SESSION["userid"];
	$query = "UPDATE profile SET loginstatus='offline' WHERE id = '$uid'";
	$do = mysql_query($query);
	}
	
	session_destroy();
	header("location: ./");

}


		


//...............................................login script ends ................

if(isset($_POST["signup"]))
{
	if(empty($_POST["email"]) or empty($_POST["firstname"]) or empty($_POST["phonenumber"]) or empty($_POST["password"]) or empty($_POST["lastname"]) or empty($_POST["cpassword"]) or empty($_POST["username"]))
	{ header("location:./?signup=emp"); }
	elseif($_POST["password"] != $_POST["cpassword"])
	{ header("location: ./?signup=matcherr"); }
	elseif(strlen($_POST["password"]) < 6)
	{ header("location: ./?signup=char"); }
	else
	{
		$username = strtolower(mysql_real_escape_string($_POST["username"]));	
		$checkusername = mysql_query("select * from profile");
		while($while = mysql_fetch_assoc($checkusername))
		{
			if($while["username"] == $username)
			{ header("location: ./?signup=equsername&value=$username"); exit; }
			
		}
		$email = mysql_real_escape_string($_POST["email"]);
		$firstname = ucwords(strtolower(mysql_real_escape_string($_POST["firstname"])));
		$lastname = ucwords(strtolower(mysql_real_escape_string($_POST["lastname"])));
		$password = mysql_real_escape_string($_POST["password"]);
		$phonenumber = mysql_real_escape_string($_POST["phonenumber"]);
		$gender = mysql_real_escape_string($_POST["gender"]);
		
		$id = rand().time().session_id().uniqid();
		$time = time();
		
		$query = "CREATE TABLE IF NOT EXISTS `profile` (id VARCHAR(200), firstname VARCHAR(50), lastname VARCHAR(50), password VARCHAR(50), phonenumber VARCHAR(50), username VARCHAR(50), email VARCHAR(50), loginstatus VARCHAR(30), time VARCHAR(20), lastvisit timestamp, PRIMARY KEY(email))";
		
		$table = mysql_query($query);
		if(!$table)
		{
			die(mysql_error());
		}
		
		$query = "INSERT INTO `profile` (id, firstname, lastname, password, phonenumber, username, email, loginstatus, time, lastvisit) VALUES ('$id', '$firstname', '$lastname', '$password', '$phonenumber', '$username', '$email', 'online', '$time', ' ')";
		$select = mysql_query($query);
		if(!$select)
		{
			die(mysql_error());
		}
		else{
		$_SESSION["userid"] = $id;
		$_SESSION["email"] = $email;
		
		//friends 
		/*$sid = substr($_SESSION["userid"], 0,33);
		$query = "CREATE TABLE IF NOT EXISTS `$id` (id VARCHAR(100), status VARCHAR(50), time VARCHAR(50), PRIMARY KEY(id))";
		
		$table = mysql_query($query);
		if(!$table)
		{
			die(mysql_error());
		}
		
		$query = "INSERT INTO `$id` (id, status,time) VALUES ('$id', 'friends', '$time')";
		$insert = mysql_query($query);
		if(!$insert)
		{
			die(mysql_error());
		}
		*/
		header("location: comp_profile.php?reg=$id");
		}
	}
}


if(isset($_POST["request"]))
{
	if(!isset($_SESSION['rand']))
		{
		$rand = rand();
		$_SESSION['rand'] = $rand;
		}
		
	if(empty($_POST["test"]) or empty($_POST["department"]) or empty($_POST["type"]) or empty($_POST["amount"]))
	{ header("location: ./?reqtest"); }
	else
	{
		
		$test = mysql_real_escape_string($_POST["test"]);
		$sender = $_SESSION["name"];
		$patientid = mysql_real_escape_string($_POST["patientid"]);
		$department = mysql_real_escape_string($_POST["department"]);
		$type = mysql_real_escape_string($_POST["type"]);
		$amount = mysql_real_escape_string($_POST["amount"]);
		$pay = mysql_real_escape_string($_POST["payment"]);
		$id = uniqid();
		$time = time();
		
		$do = mysql_query("SELECT * FROM patients where `id`='$patientid'");
		$answer = mysql_fetch_assoc($do);
		
		
		$query = "CREATE TABLE IF NOT EXISTS `pendingtests` (id VARCHAR(50), patientname VARCHAR(50), gender VARCHAR(50), testname VARCHAR(50), department VARCHAR(50), testtype VARCHAR(50), price VARCHAR(10), sender VARCHAR(20), status VARCHAR(20), payment VARCHAR(20), time VARCHAR(20), extraid VARCHAR(30), PRIMARY KEY(time))";
		
		$table = mysql_query($query);
		if(!$table)
		{
			die(mysql_error());
		}
		
		$query = "INSERT INTO `pendingtests` (id, patientname, gender, testname, department, testtype, price, sender, status, payment, time, extraid) VALUES 
		('$patientid', '$answer[firstname] $answer[lastname]', '$answer[gender]', '$test', '$department', '$type', '$amount', '$sender', 'pending', '$pay', '$time', '$_SESSION[rand]')";
		$select = mysql_query($query);
		if(!$select)
		{
			die(mysql_error());
		}
		else{ 
		header("location:successpage.php?modarequest=".$patientid."");
		}
		
	}
}


if(isset($_POST["result"]))
{
	if(empty($_POST["testname"]) or empty($_POST["pid"]) or empty($_POST["testresult"]) or 
	empty($_POST["typetest"]))
	{ 
	$from = $_SERVER['HTTP_REFERER'];
	header("location: ".$from.""); 
	}
	else
	{

		$testname = mysql_real_escape_string($_POST["testname"]);	
		$id = mysql_real_escape_string($_POST["pid"]);
		
		$patientid = substr($id, 0,13);
		$sep_time = substr($id, 13);
		
		$typeoftest = mysql_real_escape_string($_POST["typetest"]);
		$testresult = mysql_real_escape_string($_POST["testresult"]);
		$remark = mysql_real_escape_string($_POST["remark"]);
		
		$do = mysql_query("SELECT * FROM patients where `id`='$patientid'");
		$answer = mysql_fetch_assoc($do);
		
		$pt = mysql_query("SELECT * FROM pendingtests where `id`='$patientid' and `time`='$sep_time'");
		$price = mysql_fetch_assoc($pt);
		
		$query = "CREATE TABLE IF NOT EXISTS `testresults` (id VARCHAR(50), patientname VARCHAR(50), gender VARCHAR(50), testname VARCHAR(50), testtype VARCHAR(50), testresult TEXT, performedby VARCHAR(20), remark TEXT, price VARCHAR(20), uniq VARCHAR(40),  time VARCHAR(20), PRIMARY KEY(time))";
		
		$table = mysql_query($query);
		if(!$table)
		{
			die(mysql_error());
		}
		
		$query = "INSERT INTO `testresults` (id, patientname, gender, testname, testtype, testresult, performedby, remark, price, uniq, time) VALUES ('$patientid', '$answer[firstname] $answer[lastname]', '$answer[gender]', '$testname', '$typeoftest', '$testresult', '$_SESSION[name]', '$remark', '$price[price]', '$price[extraid]', '$sep_time')";
		$select = mysql_query($query);
		if(!$select)
		{
			die(mysql_error());
		}
		else{
		
		$update = mysql_query("UPDATE `pendingtests` SET `status`='completed' where `id`='$patientid' and `time`='$sep_time'");
			if($update)
			{
				$query = "SELECT * FROM `pendingtests` where `id`='$patientid' and `status`='pending'";
				$result = mysql_query($query);
				$doresult = mysql_fetch_assoc($result);
				
				if($doresult){ 
				header("location: testaction.php?rec=$patientid"); 
				}
				else{
				header("location:successpage.php?finishrequest");
				}
			}
		
		}
	}
}




if(isset($_POST["compose"]))
{

	if(empty($_POST["to"]) or empty($_POST["subject"]))
	{ header("location:./?compose"); }
	else
	{
		/*$to = $_POST["to"];
		$subject = $_POST["subject"];
		$msg = $_POST["text"];
		$id = uniqid();
		$query = "CREATE TABLE IF NOT EXISTS `mail` ( id VARCHAR(50), receiver VARCHAR(50), username VARCHAR(50), sendername VARCHAR(50), msg TEXT, time VARCHAR(20), status VARCHAR(10), PRIMARY KEY(id))";
		$result = mysql_query($query);
		$query = "INSERT INTO `mail` (id,receiver,username,sendername,msg,time,status) VALUES ($id,$to,$_SESSION[username],$sender,$msg,$time,'unread')";
		$result = mysql_query($query);*/
		header("location:./?compose&success");
	}
}

if(isset($_POST["contactupdate"]))
{
	$newfieldvalue = mysql_real_escape_string($_POST["newfield"]);
	$id = mysql_real_escape_string($_POST["myid"]);
	$column = mysql_real_escape_string($_POST["column"]);
	$time = time();
	$update = mysql_query("UPDATE `contactinfo` SET $column='$newfieldvalue' ,time='$time'  where id='$id'");
	if($update)
	{
		header("location: mp.php?&about");	
	}
		
}

if(isset($_POST["eduupdate"]))
{
	$newfieldvalue = mysql_real_escape_string($_POST["newfield"]);
	$id = mysql_real_escape_string($_POST["myid"]);
	$column = mysql_real_escape_string($_POST["column"]);
	$time = time();
	$update = mysql_query("UPDATE `eduinfo` SET $column='$newfieldvalue' ,time='$time'  where id='$id'");
	if($update)
	{
		header("location: mp.php?&about");	
	}
		
}

if(isset($_POST["pupdate"]))
{
	$newfieldvalue = mysql_real_escape_string($_POST["newfield"]);
	$id = mysql_real_escape_string($_POST["myid"]);
	$column = mysql_real_escape_string($_POST["column"]);
	$time = time();
	$update = mysql_query("UPDATE `personals` SET $column='$newfieldvalue' ,time='$time' where id='$id'");
	if($update)
	{
		header("location: mp.php?&about");	
	}
		
}

if(isset($_POST["thisid"]))
			{
			if(!isset($_FILES[image][name]) and !isset($_POST["status"])){
				header("location: mp.php?emptyfield");
			}
			
			if(!isset($_SESSION["path"])){
			$id = $_POST["thisid"];
			$realpost = $_POST["status"];
			$imgid = uniqid().rand();
			
			$file_upload="true";
			$file_up_size=$_FILES['file_up'][size];
			if ($_FILES[image][size]>5000000){$msg=$msg."<div class='failure-upload'>File size is too large. Please reduce the file size and then upload.</div><BR>";
			$file_upload="false";}
			$type = end(explode('.', strtolower($_FILES[image][name])));
			$allowtype = array("png","jpg","gif","jpeg");
			if (in_array($type, $allowtype))
			{
				$add = "statusimages/$id/$imgid".".$type";
			}
			else
			{$msg=$msg."<div class='failure-upload'>Image Type not allowed .$type <BR>
			
			</div>";
			$file_upload="false";
			}
			if($file_upload=="true")
			{
				
				if(!is_dir("statusimages")){  mkdir("statusimages"); }
				if(!is_dir("statusimages/$id")){ mkdir("statusimages/$id"); }
				if(move_uploaded_file ($_FILES[image][tmp_name], $add))
				{
					$_SESSION["imgid"] = $imgid;
					$_SESSION["path"] = $add;
					//echo "<img src='$add' style='width: 100px; height: 100px;' class='img-responsive'/>";
					header("location: mp.php?&profile=$id&imgid=$_SESSION[imgid]&img=$_SESSION[path]&post=$realpost");
				}
				else{
					header("location: mp.php");	
				}
				
			}
			else{echo $msg;}
		}



if(isset($_POST["poststatus"])) {	
			if(empty($_POST["status"]) and empty($_FILES[image][name])){
				header("location: ".$_SERVER["HTTP_REFERER"]."?&emptyfield");
			}
			else{
		$id = $_POST["thisid"];		
		$post = mysql_real_escape_string($_POST["status"]);
		$uid = session_id().rand();
		$time = time();
		
		$do = mysql_query("SELECT * FROM profile where `id`='$id'");
		$answer = mysql_fetch_assoc($do);
		
		if(!isset($_SESSION["imgid"])){ $_SESSION["imgid"] = uniqid().rand(); } 
		
		$query = "CREATE TABLE IF NOT EXISTS `statusposts` (id VARCHAR(50), post TEXT, postername VARCHAR(50), posterid VARCHAR(200), postid VARCHAR(200), imgpath VARCHAR(150), time VARCHAR(50), PRIMARY KEY(id))";
		
		$table = mysql_query($query);
		if(!$table)
		{
			die(mysql_error());
		}
		
		$query = "INSERT INTO `statusposts` (id, post, postername, posterid, postid, imgpath, time) VALUES ('$uid', '$post', '$answer[firstname] $answer[lastname]', '$id', '$_SESSION[imgid]', '$_SESSION[path]', '$time')";
		$select = mysql_query($query);
		if(!$select)
		{
			die(mysql_error());
		}
		else{ 
		unset($_SESSION["path"]);
		unset($_SESSION["imgid"]);
		header("location: mp.php?&$post_id=$id&poster=$answer[firstname]$answer[lastname]");
		}
	  }
 	}
}	


if(isset($_POST["thisidhome"]))
			{
			
			if(!isset($_SESSION["path"])){
			$id = $_POST["thisidhome"];
			$realpost = $_POST["status"];
			$imgid = uniqid().rand();
			
			$file_upload="true";
			$file_up_size=$_FILES['file_up'][size];
			if ($_FILES[image][size]>1000000){$msg=$msg."<div class='failure-upload'>File size is too large. Please reduce the file size and then upload.</div><BR>";
			$file_upload="false";}
			$type = end(explode('.', strtolower($_FILES[image][name])));
			$allowtype = array("png","jpg","gif","jpeg");
			if (in_array($type, $allowtype))
			{
				$add = "statusimages/$id/$imgid".".$type";
			}
			
			else
			{$msg=$msg."<div class='failure-upload'>Image Type not allowed .$type <BR>
			
			</div>";
			$file_upload="false";
			}
			if($file_upload=="true")
			{
				
				if(!is_dir("statusimages")){  mkdir("statusimages"); }
				if(!is_dir("statusimages/$id")){ mkdir("statusimages/$id"); }
				if(move_uploaded_file ($_FILES[image][tmp_name], $add))
				{
					$_SESSION["imgid"] = $imgid;
					$_SESSION["path"] = $add;
					//echo "<img src='$add' style='width: 100px; height: 100px;' class='img-responsive'/>";
					header("location: home.php?&profile=$id&imgid=$_SESSION[imgid]&img=$_SESSION[path]&post=$realpost");
				}
				else{
					header("location: home.php");	
				}
				
			}
			else{echo $msg;}
		}



if(isset($_POST["posthomestatus"])) {	
			if(empty($_POST["status"]) and empty($_FILES[image][name])){
				header("location: ".$_SERVER["HTTP_REFERER"]."?&emptyfield");
			}
			else{
		$id = $_POST["thisidhome"];		
		$post = mysql_real_escape_string($_POST["status"]);
		$uid = session_id().rand();
		$time = time();
		
		$do = mysql_query("SELECT * FROM profile where `id`='$id'");
		$answer = mysql_fetch_assoc($do);
		
		if(!isset($_SESSION["imgid"])){ $_SESSION["imgid"] = uniqid().rand(); } 
		
		$query = "CREATE TABLE IF NOT EXISTS `statusposts` (id VARCHAR(50), post TEXT, postername VARCHAR(50), posterid VARCHAR(200), postid VARCHAR(200), imgpath VARCHAR(150), time VARCHAR(50), PRIMARY KEY(id))";
		
		$table = mysql_query($query);
		if(!$table)
		{
			die(mysql_error());
		}
		
		$query = "INSERT INTO `statusposts` (id, post, postername, posterid, postid, imgpath, time) VALUES ('$uid', '$post', '$answer[firstname] $answer[lastname]', '$id', '$_SESSION[imgid]', '$_SESSION[path]', '$time')";
		$select = mysql_query($query);
		if(!$select)
		{
			die(mysql_error());
		}
		else{ 
		unset($_SESSION["path"]);
		unset($_SESSION["imgid"]);
		header("location: home.php?post_id=$id&poster=$answer[firstname]$answer[lastname]");
		
		}
		}
 	}
}

if(isset($_REQUEST["comment"]))
{
		$comment = $_REQUEST["comment"];		
		$postid = $_REQUEST["postid"];
		$commenter = $_REQUEST["commenter"];
		$id = uniqid();
		$time = time();
		
		$do = mysql_query("SELECT * FROM profile where `id`='$commenter'");
		$answer = mysql_fetch_assoc($do);
		
		
		$query = "CREATE TABLE IF NOT EXISTS `comments` (id VARCHAR(50), comment TEXT, commentername VARCHAR(50), commenterid VARCHAR(200), postid VARCHAR(200), time VARCHAR(50), PRIMARY KEY(id))";
		
		$table = mysql_query($query);
		if(!$table)
		{
			die(mysql_error());
		}
		
		$query = "INSERT INTO `comments` (id, comment, commentername, commenterid, postid, time) VALUES ('$id', '$comment', '$answer[firstname] $answer[lastname]', '$commenter', '$postid', '$time')";
		$select = mysql_query($query);
		if(!$select)
		{
			die(mysql_error());
		}
		else{ 
			echo"<span class='badge'>Comment Posted Successfully</span><p class='panel-body'><b>You said</b> &nbsp; <i class='fa fa-play'></i> &nbsp; $comment</p>";
		}
 }
?>
<?php if(isset($_POST["uid"])) {
			if(empty($_POST["statusupdate"])){ header("location: ".$_SERVER["HTTP_REFERER"].""); }
			else{
		$status = $_POST["statusupdate"];		
		
		$time = time();
		
		$query = "CREATE TABLE IF NOT EXISTS `statustable` (id VARCHAR(100), status TEXT, time VARCHAR (50), PRIMARY KEY(time))";
		
		$table = mysql_query($query);
		if(!$table)
		{
			die(mysql_error());
		}
			$query = "INSERT INTO `statustable` (id, status, time) VALUES ('$_SESSION[userid]', '$status', '$time')";
			$select = mysql_query($query);
		if(!$select)
		{
			die(mysql_error());
		}
		else{ 
			header("location: home.php?updatestatus=$_SESSION[userid]&t=$time&statusverified");
		}
	}
}



if(isset($_REQUEST["srch"]))
{
	echo "<select>";
	$query = "SELECT * FROM profile WHERE firstname LIKE \"$_REQUEST[srch]%\"";
	$result = mysql_query($query);
	while($row = mysql_fetch_assoc($result)){
		$m = mysql_query("SELECT * FROM personals WHERE id='$row[id]'");
		$mname = mysql_fetch_assoc($m);
	 echo "<option value='$row[firstname]'>$row[firstname] $mname[middlename] $row[lastname]</option>";
	}
	echo "</select>";
}

if(isset($_REQUEST["myid"]))
{
	$mid = $_REQUEST["myid"];
	$fid = $_REQUEST["fid"];
	$msg = $_REQUEST["msg"];
	$submid = substr($mid, 0,33);
	$subfid = substr($fid, 0,33);
	$time = time();
	
	$query = "CREATE TABLE IF NOT EXISTS `$submid` (id VARCHAR(100), status VARCHAR(50), email VARCHAR(30), message VARCHAR(230), time VARCHAR(50), PRIMARY KEY(id))";
		
		$table = mysql_query($query);
		if(!$table)
		{
			echo"";
		}
	
	$query = "INSERT INTO `$submid` (id, status, email, message, time) VALUES ('$fid', 'pending', '$_SESSION[email]', '$msg', '$time')";
	$insert = mysql_query($query);
		if(!$insert)
		{
			echo"";
		}
	else{
		
		$query = "CREATE TABLE IF NOT EXISTS `$subfid` (id VARCHAR(100), status VARCHAR(50), email VARCHAR(30), message VARCHAR(230), time VARCHAR(50), PRIMARY KEY(id))";
		
		$table = mysql_query($query);
		if(!$table)
		{
			echo"";
		}
		$query = "INSERT INTO `$subfid` (id, status, email, message, time) VALUES ('$mid', 'pending', '$_SESSION[email]', '$msg', '$time')";
	$insert = mysql_query($query);
		if(!$insert)
		{
			echo"";
		}
	else{
			
		echo"<button class='btn btn-success btn-xs form-control'>Request Sent</button>";
	}	
		
	}
		
	
}

if(isset($_REQUEST["creategroup"]))
{
		$group_name = ucwords(strtolower($_REQUEST["creategroup"]));		
		$creator = $_REQUEST["creator"];
		$id = uniqid();
		$time = time();
		
		$do = mysql_query("SELECT * FROM profile where `id`='$creator'");
		$answer = mysql_fetch_assoc($do);
		
		
		$query = "CREATE TABLE IF NOT EXISTS `groups` (id VARCHAR(50), groupname VARCHAR(200), creator VARCHAR(100), creatorname VARCHAR(200), time VARCHAR(50), PRIMARY KEY(id))";
		
		$table = mysql_query($query);
		if(!$table)
		{
			die(mysql_error());
		}
		
		$query = "INSERT INTO `groups` (id, groupname, creator, creatorname, time) VALUES ('$id', '$group_name', '$creator',
		'$answer[firstname] $answer[lastname]', '$time')";
		$select = mysql_query($query);
		if(!$select)
		{
			die(mysql_error());
		}
		else{ 
		//Create group name
		$query = "CREATE TABLE IF NOT EXISTS `$group_name` (id VARCHAR(50), memberid VARCHAR(200), creator VARCHAR(100), memberstatus VARCHAR(100), time VARCHAR(50), PRIMARY KEY(id))";
		
		$table = mysql_query($query);
		if(!$table)
		{
			die(mysql_error());
		}
		
		$query = "INSERT INTO `$group_name` (id, memberid, creator, memberstatus, time) VALUES ('$id', '$creator', '$creator', 'member', '$time')";
		$select = mysql_query($query);
		if(!$select)
		{
			die(mysql_error());
		}
		else{
			echo"<span class='label label-success form-control' style='text-align: center;'>Group Created &nbsp; <i class='fa fa-play'></i> $group_name</span><p class='panel-body'></p>";
		?>
        <button class="btn btn-primary form-control">Invite all your Friends to <?php echo"$group_name"; ?></button>
          <div class="panel-body">
									   <?php 
									  
									  $myfriends = substr($_SESSION['userid'], 0,33);
									  $ffquery = mysql_query("select * from `$myfriends` where status='friends'");
									  $frow = mysql_num_rows($ffquery);			  
									  ?> 	  
								<div class="row">
								<?php while($friendinfo = mysql_fetch_assoc($ffquery)) { ?>
								<?php if (!empty($friendinfo)) { ?>
								<div class="col-sm-2 tooltip tooltip-effect-5" style="border: 1px solid rgba(0,0,0,0.2); border-radius: 4px; margin: 5px; padding: 5px; text-align: center;">
								<?php
									
										$q = mysql_query("select * from profile where id='$friendinfo[id]'");
										$qname = mysql_fetch_assoc($q); 
													if(is_dir("profilepictures/".$friendinfo["id"].""))
													{
														$dh = scandir("profilepictures/".$friendinfo["id"]."");
																																					
														echo "<a href='mp.php?&profile=$friendinfo[id]&$qname[firstname]$qname[lastname]'><img src='profilepictures/$friendinfo[id]/$dh[2]' width='50' height='50' style='display: inline-block;' class='img-responsive img-user tooltip-item' /></a>";
														
													}
													else{
														echo "<a href='mp.php?&profile=$friendinfo[id]&$qname[firstname]$qname[lastname]'><img src='images/find_user.png'  width='50' height='50' style='display: inline-block;' class='img-responsive img-user' /></a>";
													}
								echo"<span class='tooltip-content tooltip-text' style='width: 100px; margin-left: -50px;'>$qname[firstname] $qname[lastname]</span>";
								//$namequery = mysql_query("select * from `profile` where id='$friendinfo[id]'");				
								//$nameinfo = mysql_fetch_assoc($namequery);
								?>
								</div>
								<?php } } ?>
								</div>
		<a href="process.php?groupinviteall&grpname=<?php echo"$group_name";?>"  class="btn btn-primary btn-xs pull-left">Invite All</a>							
		 </div>
        
        
        <?php
		}
		}
 }

if(isset($_REQUEST["groupinviteall"]))
{
  $myfriends = substr($_SESSION['userid'], 0,33);
  $ffquery = mysql_query("select * from `$myfriends` where status='friends'");
  $frow = mysql_num_rows($ffquery);		
	
	while($friendinfo = mysql_fetch_assoc($ffquery)) {
		if (!empty($friendinfo)) {
		$groupname = $_REQUEST["grpname"];
		$id = uniqid();
		$q = mysql_query("select * from profile where id='$friendinfo[id]'");
		$qname = mysql_fetch_assoc($q); 
		$time = time();
		//Create invitation table
		$query = "CREATE TABLE IF NOT EXISTS `groupinvite` (id VARCHAR(50), inviter VARCHAR(200), invitee VARCHAR(200), groupname VARCHAR(50), time VARCHAR(50), PRIMARY KEY(id))";
		
		$table = mysql_query($query);
		if(!$table)
		{
			die(mysql_error());
		}
		
$query = "INSERT INTO `groupinvite` (id, inviter, invitee, groupname, time) VALUES ('$id', '$_SESSION[userid]', '$friendinfo[id]', '$groupname', '$time')";
		$select = mysql_query($query);
		if(!$select)
		{
			die(mysql_error());
		}
		else{
			
			header("location: groups.php?&invitesent&grpid=$id&grpname=$groupname");
		}
		
			
			
		}
	}
}

if(isset($_POST["thisidgroup"]))
			{
			
			if(!isset($_SESSION["path"])){
			$id = $_POST["thisidgroup"];
			$realpost = $_POST["status"];
			$imgid = uniqid().rand();
			
			$file_upload="true";
			$file_up_size=$_FILES['file_up'][size];
			if ($_FILES[image][size]>50000000){$msg=$msg."<div class='failure-upload'>File size is too large. Please reduce the file size and then upload.</div><BR>";
			$file_upload="false";}
			$type = end(explode('.', strtolower($_FILES[image][name])));
			$allowtype = array("png","jpg","gif","jpeg");
			if (in_array($type, $allowtype))
			{
				$add = "groupstatusimages/$id/$imgid".".$type";
			}
			else
			{$msg=$msg."<div class='failure-upload'>Image Type not allowed .$type <BR>
			
			</div>";
			$file_upload="false";
			}
			if($file_upload=="true")
			{
				
				if(!is_dir("groupstatusimages")){ mkdir("groupstatusimages"); }
				if(!is_dir("groupstatusimages/$id")){ mkdir("groupstatusimages/$id"); }
				if(move_uploaded_file ($_FILES[image][tmp_name], $add))
				{
					$_SESSION["imgid"] = $imgid;
					$_SESSION["path"] = $add;
					
					//echo "<img src='$add' style='width: 100px; height: 100px;' class='img-responsive'/>";
					header("location: groups.php?&profile=$id&imgid=$_SESSION[imgid]&img=$_SESSION[path]&post=$realpost&grpname=$_SESSION[grpname]");
				}
				else{
					header("location: groups.php");	
				}
				
			}
			else{echo $msg;}
		}



if(isset($_POST["groupost"])) {	
			if(empty($_POST["status"]) and empty($_FILES[image][name])){
				header("location: ".$_SERVER["HTTP_REFERER"]."?&emptyfield");
			}
			else{
		$id = $_POST["thisidgroup"];		
		$post = mysql_real_escape_string($_POST["status"]);
		$uid = session_id().rand();
		$time = time();
		$groupname = mysql_real_escape_string($_POST["gname"]);
		
		$do = mysql_query("SELECT * FROM profile where `id`='$id'");
		$answer = mysql_fetch_assoc($do);
		
		if(!isset($_SESSION["imgid"])){ $_SESSION["imgid"] = uniqid().rand(); } 
		
		$query = "CREATE TABLE IF NOT EXISTS `grouposts` (id VARCHAR(50), post TEXT, groupname VARCHAR (200), postername VARCHAR(50), posterid VARCHAR(200), postid VARCHAR(200), imgpath VARCHAR(150), time VARCHAR(50), PRIMARY KEY(id))";
		
		$table = mysql_query($query);
		if(!$table)
		{
			die(mysql_error());
		}
		
		$query = "INSERT INTO `grouposts` (id, post, groupname, postername, posterid, postid, imgpath, time) VALUES ('$uid', '$post', '$groupname', '$answer[firstname] $answer[lastname]', '$id', '$_SESSION[imgid]', '$_SESSION[path]', '$time')";
		$select = mysql_query($query);
		if(!$select)
		{
			die(mysql_error());
		}
		else{ 
		unset($_SESSION["path"]);
		unset($_SESSION["imgid"]);
		header("location: groups.php?$profile=$id&grpname=$_SESSION[grpname]&post_id=$id&poster=$answer[firstname]$answer[lastname]");
		
		}
		}
 	}
}

if(isset($_REQUEST["inv"]))
{
	$timeout = 13;
	$en = 0;
	$time = time();
	while($en < $timeout)
	{
		//clearstatcache();
		$stdid = substr($_SESSION['userid'], 0,33);
		$query = "SELECT * FROM groupinvite where invitee='$_SESSION[userid]'";
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
if(isset($_REQUEST["joingroup"]))
{
		$group_name = $_REQUEST["grpn"];
		$id = uniqid();
		$time = time();
		
		//Create group name
		
		$query = "CREATE TABLE IF NOT EXISTS `$group_name` (id VARCHAR(50), memberid VARCHAR(200), creator VARCHAR(50), memberstatus VARCHAR(100), time VARCHAR(50), PRIMARY KEY(id))";
		
		$table = mysql_query($query);
		if(!$table)
		{
			die(mysql_error());
		}
		
		$tr = mysql_query("select * from $group_name");
		$trow = mysql_fetch_assoc($tr);
		
		$query = "INSERT INTO `$group_name` (id, memberid, creator, memberstatus, time) VALUES ('$id', '$_SESSION[userid]', ' ', 'member', '$time')";
		$select = mysql_query($query);
		if(!$select)
		{
			die(mysql_error());
		}
		else{
			$deleteinvite = mysql_query("DELETE FROM `groupinvite` where `invitee`='$_SESSION[userid]'");
			header("location: groups.php?&grpname=$group_name&profile=$_SESSION[userid]&justjoined=??");	
		}
	
}

