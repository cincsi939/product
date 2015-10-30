<?php
function getNumkeyPoint($date="",$point_min=0,$point_max=0){
	$dbedubkk_userentry = DB_USERENTRY;
	if($point_min>0 && $point_max==0){
		$start_rate = ($point_min>0)?" CEILING(numkpoint)<= ".$point_min:"";
		$end_rate = "";
		$point_rate = $start_rate;
	}else if($point_min>0 && $point_max>0){
		$start_rate = ($point_min>0)?" CEILING(numkpoint)> ".$point_min:"";
		$end_rate = ($point_max>0)?" CEILING(numkpoint)< ".$point_max:"";
		$point_rate = $start_rate." AND ".$end_rate;
	}else{
		$point_rate = " CEILING(numkpoint )=0";
	}
	$sql = "SELECT 
				SUM( IF(".$point_rate.",1,0) )  AS count_user
				FROM `stat_user_keyin` 
				WHERE datekeyin='".$date."' ";
	//echo "<hr/>";
	$query = mysql_db_query($dbedubkk_userentry,$sql);
	$row = mysql_fetch_assoc($query);
	return $row['count_user'];
}
?>