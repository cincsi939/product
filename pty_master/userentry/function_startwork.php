<?
	function getStartWork($pin,$typeAccess){ // getStartWork("1509900068819","P");
	
			$host = "202.129.35.101";
			$user = "sapphire";
			$pass = "sprd!@#$%";
			$myconnect = mysql_connect($host,$user,$pass) OR DIE("Unable to connect to database :: $host ");
			mysql_select_db("faceaccess");
			$iresult = mysql_query("SET character_set_results=tis-620");
			$iresult = mysql_query("SET NAMES TIS620");
			
			if($typeAccess=="P"){
				$sqlAnd = " AND period_group_id='3' ";
			}else{
				$sqlAnd = " AND period_group_id!='3' ";
			}
			
			$sql = mysql_query("SELECT officer_id,start_work,status_id FROM faceacc_officer WHERE pin='$pin'  $sqlAnd ") or die(mysql_error());				
			$row = mysql_fetch_assoc($sql);
			
			if($row['status_id']=='1'){
				$sta = mysql_fetch_assoc(mysql_query("SELECT time_start FROM faceacc_officer_to_status WHERE officer_id='$row[officer_id]' AND status_id='1' ORDER BY timeupdate DESC "));	
				
				if($sta['time_start']!=""){
					$startWork = $sta['time_start'];
				}else{
					$startWork = $row['start_work'];
				}
				
			}else{
					$startWork = "No Work Here !!";
			}
			
			return $startWork;
	}
	
	//echo getStartWork("1670400003450","F");
?>