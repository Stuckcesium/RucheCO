<?php
include 'connect.php';

$rucheid = $_GET["rucheid"];
$next = $_GET['next'];
$prev = $_GET['prev'];
$echo = $_GET['echo'];

$editnote = $_GET['editnote'];
$rowid = $_GET['rowid'];
$prowid = $_POST['prowid'];

if (empty($next)){} else {
	$rucheid = $next;
	$rucheid = $rucheid + 1;
}


if (empty($prev)){} else {

	$rucheid = $prev;
	$rucheid = $rucheid - 1;
}


if ($rucheid == 0) {
	$rucheid = 1;
}

/*******************last weight *********************************/
$query = "SELECT `ID`, `weight` , `timestamp` FROM `monitoring` WHERE `RUCHEID` = $rucheid ORDER BY `ID` DESC LIMIT 1";
$result = mysql_query($query) or die ('Erreur SQL !'.$query.'<br />'.mysql_error());

while ($row = mysql_fetch_array($result)) {
	$lastweight =   ($row["weight"]);
};
/***************************** NOTE ********************************/
if (isset($_GET['textnote'])){
	
	$textnote = $_GET['textnote'];
	$textnote = nl2br ($textnote);
	$textnote = mysql_real_escape_string($textnote);
	
	$date = date_create(); $date = date_format($date,'Y-m-d H:i:s');

	echo "<center><font face='Arial, sans-serif'>";

	$addnote = "INSERT INTO $database.`note` (`id`, `rucheid`, `notelong`, `poids`, `datetime`) VALUES (NULL, '$rucheid', '$textnote', '$lastweight', '$date');";

	$resaddnote = mysql_query($addnote)	 or die ("execution de la requete impossible");

	$textnote = '';

	echo "<br /> note ajout&eacutee -- date :".$date.'poids : '.$lastweight;
}

if (isset($_GET['edit_comment'])){

	$edit_comment = $_GET['edit_comment'];
	$edit_comment = nl2br ($edit_comment);
	$edit_comment = mysql_real_escape_string($edit_comment);

	$updatenote = "UPDATE $database.`note` SET `notelong` = '$edit_comment' WHERE `note`.`id` = $rowid";

	$resupdatenote = mysql_query($updatenote)	 or die ("execution de la requete impossible");

	echo "Note correctement mise à jour ";

}


if (isset($_GET['del_comment'])){


	$delnote = "DELETE FROM $database.`note` WHERE `note`.`id` = $rowid";

	$resdelnote = mysql_query($delnote)	 or die ("execution de la requete impossible");

	echo "Note correctement supprimée ";

}

/*******************HAUSSE*********************************/

if (isset($_GET['delhausseid'])){
	$hausseid = $_GET['delhausseid'];

	$query = "UPDATE `hausse` SET `DEL` = '1' WHERE `hausse`.`HAUSSEID` = $hausseid and `hausse`.`RUCHEID` = $rucheid and `hausse`.`DEL` = 0";
	$result = mysql_query($query) or die ('Erreur SQL !'.$query.'<br />'.mysql_error());

	//echo 'suppression '.$hausseid.'';

}


if (isset($_GET['addhausseid'])){

	$hausseid = $_GET['addhausseid'];
	$date = date_create(); $date = date_format($date,'Y-m-d H:i:s');

	$query = "INSERT INTO `hausse` (`ID`, `RUCHEID`, `HAUSSEID`, `DATETIME`, `POIDSINITIAL`, `DEL`) VALUES (NULL, '$rucheid', '$hausseid', '$date', '$lastweight', '0');";
	$res = mysql_query($query) or die ('Erreur SQL !'.$query.'<br />'.mysql_error());
	//echo 'Ajout '.$hausseid.'';
}

/*******************NOTIFICATION*********************************/
	
	//POIDSFAIBLE
	$result = mysql_query("SELECT status FROM notification WHERE `notification`.`notification` = 'POIDSFAIBLE' and `notification`.`RUCHEID` = $rucheid LIMIT 1");
	$row = mysql_fetch_assoc($result);
	$statuspoidsfaible = $row['status'];
	
	//ESSAIMAGE
	$result = mysql_query("SELECT status FROM notification WHERE `notification`.`notification` = 'ESSAIMAGE' and `notification`.`RUCHEID` = $rucheid LIMIT 1");
	$row = mysql_fetch_assoc($result);
	$statusessaimage = $row['status'];
	
	//MIELLEE
	$result = mysql_query("SELECT status FROM notification WHERE `notification`.`notification` = 'MIELLEE' and `notification`.`RUCHEID` = $rucheid LIMIT 1");
	$row = mysql_fetch_assoc($result);
	$statusmiellee = $row['status'];
	
	//HAUSSEPLEINE
	$result = mysql_query("SELECT status FROM notification WHERE `notification`.`notification` = 'HAUSSEPLEINE' and `notification`.`RUCHEID` = $rucheid LIMIT 1");
	$row = mysql_fetch_assoc($result);
	$statushaussepleine = $row['status'];

if (isset($_GET['POIDSFAIBLE'])){
	
	$status = !(bool)$_GET['POIDSFAIBLE'];
	$query = "UPDATE `notification` SET `STATUS` = '$status' WHERE `notification`.`notification` = 'POIDSFAIBLE' and `notification`.`RUCHEID` = $rucheid;";
	$res = mysql_query($query) or die ('Erreur SQL !'.$query.'<br />'.mysql_error());
	$statuspoidsfaible = $status;
}


if (isset($_GET['ESSAIMAGE'])){
	
	$status = !(bool)$_GET['ESSAIMAGE'];
	$query = "UPDATE `notification` SET `STATUS` = '$status' WHERE `notification`.`notification` = 'ESSAIMAGE' and `notification`.`RUCHEID` = $rucheid;";
	$res = mysql_query($query) or die ('Erreur SQL !'.$query.'<br />'.mysql_error());
	$statusessaimage = $status;
}


if (isset($_GET['MIELLEE'])){
	
	$status = !(bool)$_GET['MIELLEE'];
	$query = "UPDATE `notification` SET `STATUS` = '$status' WHERE `notification`.`notification` = 'MIELLEE' and `notification`.`RUCHEID` = $rucheid;";
	$res = mysql_query($query) or die ('Erreur SQL !'.$query.'<br />'.mysql_error());
	$statusmiellee = $status;
}


if (isset($_GET['HAUSSEPLEINE'])){
	
	$status = !(bool)$_GET['HAUSSEPLEINE'];
	$query = "UPDATE `notification` SET `STATUS` = '$status' WHERE `notification`.`notification` = 'HAUSSEPLEINE' and `notification`.`RUCHEID` = $rucheid;";
	$res = mysql_query($query) or die ('Erreur SQL !'.$query.'<br />'.mysql_error());
	$statushaussepleine = $status;
}

/*******************couleur*********************************/
switch ($rucheid)
		{
			case 1:
			$color = 'hero-image';
			break;

			case 2:
			$color = 'hero-image_blue';
			break;

			case 3:
			$color = 'hero-image_green';
			break;

			case 4:
			$color = 'hero-image';
			break;

			case 5:
			$color = 'hero-image';
			break;

			case 5:
			$color = 'hero-image';
			break;

			default:
			$color = 'hero-image';
			break;
		}

/*******************UPLOAD PHOTO*******************************/
		
if(!empty($_FILES['image']['name'])){
    
    //call thumbnail creation function and store thumbnail name
    $upload_img = cwUpload('image','uploads/','',TRUE,'uploads/thumbs/','200','160');
    
    //full path of the thumbnail image
    $thumb_src = 'uploads/thumbs/'.$upload_img;
    
	
	$query = "INSERT INTO `photonote` (`ID`, `path`) VALUES ('$prowid', '$upload_img');";
	$res = mysql_query($query) or die ('Erreur SQL !'.$query.'<br />'.mysql_error());
	

    //set success and error messages
    $message = $upload_img?"<span style='color:#008000;'>Image thumbnail have been created successfully.</span>":"<span style='color:#F00000;'>Some error occurred, please try again.</span>";
    
}else{
    
    //if form is not submitted, below variable should be blank
    $thumb_src = '';
    $message = '';
}
		
		
/**
*
* Author: CodexWorld
* Function Name: cwUpload()
* $field_name => Input file field name.
* $target_folder => Folder path where the image will be uploaded.
* $file_name => Custom thumbnail image name. Leave blank for default image name.
* $thumb => TRUE for create thumbnail. FALSE for only upload image.
* $thumb_folder => Folder path where the thumbnail will be stored.
* $thumb_width => Thumbnail width.
* $thumb_height => Thumbnail height.
*
**/
function cwUpload($field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = ''){

    //folder path setup
    $target_path = $target_folder;
    $thumb_path = $thumb_folder;
    
    //file name setup
    $filename_err = explode(".",$_FILES[$field_name]['name']);
    $filename_err_count = count($filename_err);
    $file_ext = $filename_err[$filename_err_count-1];
    if($file_name != ''){
        $fileName = $file_name.'.'.$file_ext;
    }else{
        $fileName = $_FILES[$field_name]['name'];
    }
    
    //upload image path
    $upload_image = $target_path.basename($fileName);
    
    //upload image
    if(move_uploaded_file($_FILES[$field_name]['tmp_name'],$upload_image))
    {
        //thumbnail creation
        if($thumb == TRUE)
        {
            $thumbnail = $thumb_path.$fileName;
            list($width,$height) = getimagesize($upload_image);
            $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
            switch($file_ext){
                case 'jpg':
                    $source = imagecreatefromjpeg($upload_image);
                    break;
                case 'jpeg':
                    $source = imagecreatefromjpeg($upload_image);
                    break;

                case 'png':
                    $source = imagecreatefrompng($upload_image);
                    break;
                case 'gif':
                    $source = imagecreatefromgif($upload_image);
                    break;
                default:
                    $source = imagecreatefromjpeg($upload_image);
            }

            imagecopyresized($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
            switch($file_ext){
                case 'jpg' || 'jpeg':
                    imagejpeg($thumb_create,$thumbnail,100);
                    break;
                case 'png':
                    imagepng($thumb_create,$thumbnail,100);
                    break;

                case 'gif':
                    imagegif($thumb_create,$thumbnail,100);
                    break;
                default:
                    imagejpeg($thumb_create,$thumbnail,100);
            }

        }

        return $fileName;
    }
    else
    {
        return false;
    }
}
?>