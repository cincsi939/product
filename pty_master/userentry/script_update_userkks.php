<?php
include("../config/conndb_nonsession.inc.php");
/*include("../common/common_competency.inc.php");

$iphost = "202.129.35.124";

$username = "cmss";
$password = "cmss2010";
ConHost($iphost,$username,$password);*/
$ipsorce = HOST;
$ipdest = "202.129.35.125";
$username = "cmss";
$password = "cmss2010";

ConHost($ipsorce,$username,$password);
$sql = "SELECT * FROM login_username ORDER BY runid ASC";
$result = mysql_db_query($dbnamemaster,$sql);
while($rs = mysql_fetch_assoc($result)){
	if($rs[status_active] == "" or $rs[status_active] == "1"){
		ConHost($ipdest,$username,$password);
		$sqlup1 = "UPDATE login  SET username='$rs[usernaem]',pwd='$rs[passored]',prename_th='$rs[prename_th]',name_th='$rs[name_th]',surname_th='$rs[surname_th]',prename_en='$rs[prename_en]',name_en='$rs[name_en]',surname_en='$rs[surname_en]' WHERE runid='$rs[runid]'";
		echo " active 1 :: $sqlup1<br>";
		#mysql_db_query($dbnamemaster,$sqlup1);
						
	}else if($rs[status_active] == "2"){
			$sqlup2 = "UPDATE login  SET username='$rs[usernaem]',pwd='$rs[passored]',prename_th='$rs[prename_th]',name_th='$rs[name_th]',surname_th='$rs[surname_th]',prename_en='$rs[prename_en]',name_en='$rs[name_en]',surname_en='$rs[surname_en]' WHERE runid='$rs[runid]'";
			echo "active 2 :: $sqlup2<br>";
			//mysql_db_query($dbnamemaster,$sqlup2);
			$sql_updategroup = "UPDATE epm_groupmember SET gid='$rs[nid]'  WHERE  gid='$rs[group_id]' AND staffid='$rs[id]'";
			echo "active 2 :: $sql_updategroup<hr>";
			//mysql_db_query($dbnamemaster,$sql_updategroup);
	}else if($rs[status_active] == "3"){
		ConHost($ipdest,$username,$password);
		$sql_sel = "SELECT max(id) as maxid FROM login ";
		$result_sel = mysql_db_query($dbnamemaster,$sql_sel);
		$rss = mysql_fetch_assoc($result_sel);
		$max1 = $rss[maxid]+1;
		$sqlinsert = "INSERT INTO login SET UPDATE login  SET username='$rs[usernaem]',pwd='$rs[passored]',prename_th='$rs[prename_th]',name_th='$rs[name_th]',surname_th='$rs[surname_th]',prename_en='$rs[prename_en]',name_en='$rs[name_en]',surname_en='$rs[surname_en]',office='$rs[prename_th]$rs[name_th] $rs[surname_th]'";
		echo "active 3 : $sqlinsert<br>";
		//$result_int = mysql_db_query($dbnamemaster,$sqlinsert);
		//$lastid = mysql_insert_id();//
		$sql_in1 = "REPLACE INTO epm_groupmember SET gid='$rs[nid]',staffid='$max1'";
		echo " active 3 :: ".$sql_in1."<br>";
		//mysql_db_query($dbnamemaster,$sql_in1);
		
			
	}//end if($rs[status_active] == ""){
		
}//  end while($rs = mysql_fetch_assoc($result)){


	
?>
