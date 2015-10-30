<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "CrontabCalScore";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Suwat
#DateCreate::29/03/2011
#LastUpdate::29/03/2011
#DatabaseTable:tbl_person_print
#END
#########################################################
//session_start();

			set_time_limit(0);
			require_once("../../../config/conndb_nonsession.inc.php");
			require_once("../../../common/common_competency.inc.php");
			require_once("function_print_kp7.php");
			require_once("../function_face2cmss.php");
			
			$arrsite = GetSiteKeyData();

			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			
			$sql = "SELECT * FROM keystaff_qc_groupn where numd='1' group by staffid";
			$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
			while($rs = mysql_fetch_assoc($result)){
				$sql1 = "SELECT * FROM keystaff_qc_groupn WHERE staffid='$rs[staffid]'";
				$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
				$temp_pin = "";
				while($rs1 = mysql_fetch_assoc($result1)){
					//echo $rs[staffid]." :: ".$rs1[site_id]."<br>";
				$in_pin = GetPinStaff($rs1[site_id]);
				$temp_pin .= $in_pin;
				ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
				}//end while($rs1 = mysql_fetch_assoc($result1)){
					
				if($temp_pin != ""){
					$con_pin = " AND card_id IN($temp_pin)";	
				}	
				$arr_r = explode("||",$rs[ratio_id]);
				if(count($arr_r) > 1){
						$con_r = " AND (ratio_id='1' or ratio_id='2')";
				}else if(count($arr_r) == 1){
						$con_r = " AND ratio_id='".$arr_r[0]."'";
				}else{
						$con_r = " AND (ratio_id='1' or ratio_id='2')";
				}
				
				$sql2 = "SELECT staffid FROM keystaff WHERE status_permit='YES' AND (keyin_group='3' OR keyin_group='4') AND status_extra='NOR'  $con_r $con_pin";
				//echo $sql2."<hr>";
				$result2 = mysql_db_query($dbnameuse,$sql2) or die(mysql_error()."$sql2<br>LINE__".__LINE__);
				while($rs2 = mysql_fetch_assoc($result2)){
					$sql_rep = "REPLACE INTO keystaff_qc_math_key SET staffkey='$rs2[staffid]',staffqc='$rs[staffid]'";
					//echo $sql_rep."<br>";
					mysql_db_query($dbnameuse,$sql_rep) or die(mysql_error()."$sql2<br>LINE__".__LINE__);
				}
			
				
				
			}// while($rs = mysql_fetch_assoc($result)){
				
				
				
				
				
				
				
				
				
				
				
		###################################  แบ่งข้อมูลกันในกรณี 1 ศูนย์คีย์มีพนักงาน QC มากกว่า 1 คน #######################
			$sql_del = "DELETE FROM keystaff_qc_math_key_temp ";
			mysql_db_query($dbnameuse,$sql_del) or die(mysql_error()."$sql_del<br>LINE__".__LINE__);
			$sql = "SELECT * FROM keystaff_qc_groupn where numd='2' group by staffid";
			$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
			while($rs = mysql_fetch_assoc($result)){
				$arrstaffqc[$rs[staffid]] = $rs[staffid];
				$sql1 = "SELECT * FROM keystaff_qc_groupn WHERE staffid='$rs[staffid]'";
				$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
				$temp_pin = "";
				while($rs1 = mysql_fetch_assoc($result1)){
					//echo $rs[staffid]." :: ".$rs1[site_id]."<br>";
				$in_pin = GetPinStaff($rs1[site_id]);
				$temp_pin .= $in_pin;
				ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
				}//end while($rs1 = mysql_fetch_assoc($result1)){
					
				if($temp_pin != ""){
					$con_pin = " AND card_id IN($temp_pin)";	
				}	
				$arr_r = explode("||",$rs[ratio_id]);
				if(count($arr_r) > 1){
						$con_r = " AND (ratio_id='1' or ratio_id='2')";
				}else if(count($arr_r) == 1){
						$con_r = " AND ratio_id='".$arr_r[0]."'";
				}else{
						$con_r = " AND (ratio_id='1' or ratio_id='2')";
				}
				
				$sql2 = "SELECT staffid FROM keystaff WHERE status_permit='YES' AND (keyin_group='3' OR keyin_group='4') AND status_extra='NOR'  $con_r $con_pin";
				//echo $sql2."<hr>";
				$result2 = mysql_db_query($dbnameuse,$sql2) or die(mysql_error()."$sql2<br>LINE__".__LINE__);
				
				while($rs2 = mysql_fetch_assoc($result2)){
					$arrstaffkey[$rs2[staffid]] = $rs2[staffid];
					$sql_rep = "REPLACE INTO keystaff_qc_math_key_temp SET staffid='$rs2[staffid]'";
					//echo $sql_rep."<br>";
					mysql_db_query($dbnameuse,$sql_rep) or die(mysql_error()."$sql2<br>LINE__".__LINE__);
				}
			
				
				
			}// while($rs = mysql_fetch_assoc($result)){
				
			#############  
			

		
		if(count($arrstaffqc) > 0){
			$loop = count($arrstaffqc); // จำนวน loop
				$num_int = floor(count($arrstaffkey)/count($arrstaffqc));
				$diffint = count($arrstaffkey)/$num_int;
				$numloop_n = $num_int+$diffint;
				//echo count($arrstaffkey)." /".count($arrstaffqc)." :: ".$num_int."<br>";
				$i=0;
				$a=0;
				$k=0;
				foreach($arrstaffqc as $key => $val){
					
					
					$i++;

					if($i != $loop){
						$intA = $num_int;
					}else{
						$intA = $numloop_n;
					}
						
						$intB = $intB+$intA;
			
						
							
							$sqltemp = "SELECT * FROM keystaff_qc_math_key_temp LIMIT $a,".floor($intB)." ";
							//echo $sqltemp."<br>";
							$resulttemp = mysql_db_query($dbnameuse,$sqltemp) or die(mysql_error()."$sqltemp<br>LINE__".__LINE__);
							while($rst = mysql_fetch_assoc($resulttemp)){
									$k++;
							$sql_rep = "REPLACE INTO keystaff_qc_math_key SET staffkey='$rst[staffid]',staffqc='$val'";	
							//echo "$k :: $sql_rep<br>";	
							mysql_db_query($dbnameuse,$sql_rep) or die(mysql_error()."$sql_rep<br>LINE__".__LINE__);
							}// end while($rst = mysql_fetch_assoc($resulttemp)){
					

					
					$a = $intB;
					
						
				}//end foreach($arrstaffqc as $key => $val){
		}// end if(count($arrstaffqc) > 0){
		
		
		unset($arrstaffkey);
		unset($arrstaffqc);
			
echo "Done...";

 ?>