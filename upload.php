<?php error_reporting(0);
/*if(is_array($_FILES)) {
if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
$sourcePath = $_FILES['userImage']['tmp_name'];
if(!is_dir("uploadimages")){mkdir("uploadedimages");}
$targetPath = "uploadimages/".$_FILES['userImage']['name'];
if(move_uploaded_file($sourcePath,$targetPath)) {
?>
<img src="<?php echo $targetPath; ?>"  />
<?php
}
}
}*/
		if(isset($_REQUEST["userprofilepic"]))
			{
			$id = $_REQUEST["userprofilepic"];
				
			$file_upload="true";
			$file_up_size=$_FILES['file_up'][size];
			if ($_FILES[image][size]>5000000){$msg=$msg."<div class='failure-upload'>File size is too large. Please reduce the file size and then upload.</div><BR>";
			$file_upload="false";}
			$type = end(explode('.', strtolower($_FILES[image][name])));
			$allowtype = array("png","jpg","gif","jpeg");
			if (in_array($type, $allowtype))
			{
				$add = "profilepictures/$id/$id".".$type";
			}
			else
			{$msg=$msg."<div class='failure-upload'> Image Type not allowed .$type <BR>
			";$_SESSION[error] = "error"; echo"
			</div>";
			$file_upload="false";
			}
			if($file_upload=="true")
			{
				if(file_exists("profilepictures/".$id."/".$id.".png") or file_exists("profilepictures/".$id."/".$id.".jpg") or file_exists("profilepictures/".$id."/".$id.".jpeg") or file_exists("profilepictures/".$id."/".$id.".gif"))
				{
					unlink("profilepictures/".$id."/".$id.".png");  
					unlink("profilepictures/".$id."/".$id.".jpg");  
					unlink("profilepictures/".$id."/".$id.".gif");  
					unlink("profilepictures/".$id."/".$id.".jpeg");  
				
				}
				if(!is_dir("profilepictures")){  mkdir("profilepictures"); }
				if(!is_dir("profilepictures/$id")){ mkdir("profilepictures/$id"); }
				if(move_uploaded_file ($_FILES[image][tmp_name], $add))
				{
					$dh = scandir("profilepictures/".$id."");
					echo "<img src='profilepictures/$id/$dh[2]' style='width: 100px; height: 100px;' class='img-responsive'/>";
				
				}
				
			}
			else{echo $msg;}
		}	
		
			if(isset($_POST["id"]) and !isset($_REQUEST["userprofilepic"]) and !isset($_REQUEST["statusimg"]))
			{
			$id = $_POST["id"];
				
			$file_upload="true";
			$file_up_size=$_FILES['file_up'][size];
			if ($_FILES[image][size]>5000000){$msg=$msg."<div class='failure-upload'>File size is too large. Please reduce the file size and then upload.</div><BR>";
			$file_upload="false";}
			$type = end(explode('.', strtolower($_FILES[image][name])));
			$allowtype = array("png","jpg","gif","jpeg");
			if (in_array($type, $allowtype))
			{
				$add = "coverphoto/$id/$id".".$type";
			}
			else
			{$msg=$msg."<div class='failure-upload'>Image Type not allowed .$type <BR>
			
			</div>";
			$file_upload="false";
			}
			if($file_upload=="true")
			{
				if(file_exists("coverphoto/".$id."/".$id.".png") or file_exists("coverphoto/".$id."/".$id.".jpg") or file_exists("coverphoto/".$id."/".$id.".jpeg") or file_exists("coverphoto/".$id."/".$id.".gif"))
				{
					unlink("coverphoto/".$id."/".$id.".png");  
					unlink("coverphoto/".$id."/".$id.".jpg");  
					unlink("coverphoto/".$id."/".$id.".gif");  
					unlink("coverphoto/".$id."/".$id.".jpeg");  
				
				}
				if(!is_dir("coverphoto")){  mkdir("coverphoto"); }
				if(!is_dir("coverphoto/$id")){ mkdir("coverphoto/$id"); }
				if(move_uploaded_file ($_FILES[image][tmp_name], $add))
				{
					
					echo "<img src='$add' style='max-width: 100px; max-height: 100px;'/>";
					header("location: mp.php");
				}
				else{echo "<div class='failure-upload'>Failed to upload file Contact Site admin to fix the problem</div>";}
			}
			else{echo $msg;}
			
		}	
		

?>


