<?
	define('DB_SERVER', '202.129.35.101');
	  define('DB_SERVER_USERNAME', 'sapphire');
	  define('DB_SERVER_PASSWORD', 'sprd!@#$%');
	  define('DB_DATABASE', 'faceaccess');
	  
	  $_GET['card_id'] = $idcard;
	 # echo $_GET['card_id']."<br>";
	$myconnect = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD) OR DIE("Unable to connect to databasex  ");
	mysql_select_db(DB_DATABASE) or die("cannot select database $dbname");
	if($_GET['type']=="new"){
		$picture = mysql_fetch_assoc(mysql_query("SELECT imgName FROM faceacc_images_tmp tm , faceacc_officer of WHERE tm.officer_id=of.officer_id AND of.pin='".$_GET['card_id']."' ORDER BY imgId DESC"));
		$images = 'http://202.129.35.101/face_access/application/face_members/userImage/'.$picture['imgName'];
	}else{
		$picture = mysql_fetch_assoc(mysql_query("SELECT picture FROM faceacc_officer WHERE pin='".$_GET['card_id']."'"));
		$images = 'http://202.129.35.101/face_access/application/face_members/userImage/'.$picture['picture'];
	}
	
	//$images = "userImage/123456-2010_03_02.jpg";
	#echo $images;
/*	header('Content-type: image/jpeg'); 
	$image = imagecreatefromjpeg($images);
	imagejpeg($image, NULL, 70); */

?> 
	