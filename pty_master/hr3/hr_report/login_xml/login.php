<?
HEADER("content-type: text/xml; charset=TIS-620");
include '../../../../config/conndb_nonsession.inc.php';
$bd = substr($user,4,4).'-'.substr($user,2,2).'-'.substr($user,0,2);

$sql = "select t3.IP as ip,t3.intra_ip,t2.secname,t1.CZ_ID as cz_id,t1.birthday,t1.siteid,t1.prename_th,t1.name_th,t1.surname_th,t1.position_now,t1.vitaya from view_general t1 inner join eduarea t2 on t1.siteid=t2.secid inner join area_info t3 on t2.area_id=t3.area_id where t1.birthday='$bd' and t1.CZ_ID='$pwd' limit 1";
$qr = mysql_query($sql);
$ar = mysql_fetch_assoc($qr);

//print_r($ar);

if($ar[intra_ip]){
	$host = "$ar[intra_ip]"  ;
	//$username = "sapphire"  ;
	//$password = "sprd!@#$%"  ;
	$db_name ="cmss_$ar[siteid]"  ;
	mysql_select_db($db_name) or die( "Unable to select database");
	$iresult = mysql_query("SET character_set_results=tis-620");
	$iresult = mysql_query("SET NAMES TIS620");

	
	$sql2 = "select * from general_pic where id='$ar[cz_id]' order by no desc limit 1 ";
	$qr2 = mysql_query($sql2);
	$ar2 = mysql_fetch_assoc($qr2);

	$sql3 = "select t1.pivate_key,t2.office,t1.schoolid from general t1 left join ".DB_MASTER.".allschool t2 on t1.schoolid = t2.id where t1.id='$ar[cz_id]'  limit 1 ";
	$qr3 = mysql_query($sql3);
	$ar3 = mysql_fetch_assoc($qr3);

	if(strlen($ar3[schoolid])==4){
		$scname = $ar3[office];
	}else{
		$scname = "โรงเรียน".$ar3[office];
	}

	if($ar3[pivate_key] != $pkey){
		unset($ar);
		unset($ar2);
	}


	//print_r($ar2);


}

echo "<?xml version='1.0' encoding='TIS-620' ?>";
echo "<person>";
echo "<ip>$ar[ip]</ip>";
echo "<intra_ip>$ar[intra_ip]</intra_ip>";
echo "<name>$ar[prename_th] $ar[name_th] $ar[surname_th]</name>";
echo "<position>$ar[position_now]</position>";
echo "<vitaya>$ar[vitaya]</vitaya>";
echo "<pic>http://$ar[ip]/image_file/$ar[siteid]/$ar2[imgname]</pic>";
//echo "<pic>http://$ar[ip]/edubkk_master/application/hr3/hr_report/images/personal/$ar2[imgname]</pic>";
echo "<siteid>$ar[siteid]</siteid>";
echo "<czid>$ar[cz_id]</czid>";
echo "<school>$scname</school>";
echo "</person>";
?>