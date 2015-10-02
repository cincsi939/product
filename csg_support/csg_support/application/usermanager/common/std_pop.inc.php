<?
// =============================== Catate By char 11/21/2004 22.00
function  show_pop($areaid1,$yy1,$sex1){
include ("conndb.inc.php")  ;
		$ampid1 = $prov_id . $areaid1  ;  
		$sql00 = "select  *  from  amp_population   where   yy= $yy1   and   ampid = $ampid1  " ;
		$query_result00=mysql_db_query($dbname,$sql00);	
		$result00=mysql_fetch_array($query_result00)  ;
//echo "$sql00";
		if ($sex1 == "m"){	return  $result00[male_nm]  ;	}
		if ($sex1 == "f"){	return  $result00[fmale_nm]  ;	}
		if ($sex1 == "a"){	return  $result00[total_nm]  ;	}
}
// =============================== Catate By char 11/21/2004 22.00
function  show_timeupdate($areaid1,$yy1){
include ("conndb.inc.php")  ;
		$ampid1 = $prov_id . $areaid1  ;  
		$sql00 = "select  *  from  amp_population   where   yy= $yy1   and   ampid = $ampid1  " ;
		$query_result00=mysql_db_query($dbname,$sql00);	
		$result00=mysql_fetch_array($query_result00)  ;
//echo "$sql00";
		return   $result00[timeupdate] ;	

}


?>
