<?
	define('DB_SERVER', '202.129.35.101');
	  define('DB_SERVER_USERNAME', 'sapphire');
	  define('DB_SERVER_PASSWORD', 'sprd!@#$%');
	  define('DB_DATABASE', 'faceaccess');
	$myconnect = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD) OR DIE("Unable to connect to databasex  ");
	mysql_select_db(DB_DATABASE) or die("cannot select database $dbname");
	
	
	
		
function CopyPicDiffServer($images,$pic){
		
		$url = $images;
		$filename="images_s_1/".rand(21, 1120).".jpg";
		
		#echo "URL : $url<hr>";
		
		#echo "FILENAME : $filename<hr>";
		$hd_get = fopen($url, "r");
		
		$data = NULL;
		if($hd_get) {
		while (!feof($hd_get)) {
		  $data .= fread($hd_get, 8192);
		}
		fclose($hd_get);
		if(!fopen($filename,"r")){
			$hd_put= fopen($filename, "w+");
		if($hd_put) {
			fwrite($hd_put, $data);
			fclose($hd_put);
		} else {
			//print "Save File $filename Error";
		}
		}  else {
			print "error";
		}
		
		} else {
			#print "Cannot Open $url ";
		}

			
}//end function CopyPicDiffServer($images,$pic){
	
	
	
	//$_GET['card_id'] = "1103700743936";
	
	if($_GET['type']=="new"){
		$result = mysql_query("SELECT imgName FROM faceacc_images_tmp tm , faceacc_officer of WHERE tm.officer_id=of.officer_id AND of.pin='".$_GET['card_id']."' ORDER BY imgId DESC");
		while($picture =  mysql_fetch_assoc($result)){
		$images = 'http://202.129.35.101/face_access/application/face_members/userImage/'.$picture['imgName'];
		#echo "$images<br>".$picture['imgName'];
		CopyPicDiffServer($images,$picture['imgName']);
		
		}//end 
	}else{
		while($picture = mysql_fetch_assoc(mysql_query("SELECT picture FROM faceacc_officer WHERE pin='".$_GET['card_id']."' "))){
				$images = 'http://202.129.35.101/face_access/application/face_members/userImage/'.$picture['picture'];
				#echo "<br>$images<br>".$picture['picture'];
				CopyPicDiffServer($images,$picture['picture']);
		}
		
	}
	
	//$images = "userImage/123456-2010_03_02.jpg";
	
	
	
	

	
/*	
	header('Content-type: image/jpeg'); 
	$image = imagecreatefromjpeg($images);
	imagejpeg($image, NULL, 100); 
*/
?> 
	