<?
include ("../../config/conndb_nonsession.inc.php")  ;
//include('../hr3/tool_competency/diagnosticv1/function.inc_v1.php') ;
include("epmv1.inc.php");
include ("function_startwork.php");

######  ######################################################  ปรับกลุ่มอัตราส่วนของการ QC ####################
				$sql = "SELECT
keystaff.staffid,
keystaff.card_id,
keystaff.period_time,
keystaff_group.groupname,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
keystaff_group.groupkey_id
FROM
keystaff
Inner Join keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id where status_permit='YES'";
ConHost(HOST,USERNAME_HOST,PASSWORD_HOST);
				$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
				while($rs = mysql_fetch_assoc($result)){
					if($rs[period_time] == "am"){
							$PT = "F";
					}else{
							$PT = "P";	
					}
						
						$start_work = getStartWork("$rs[card_id]","$PT");
						ConHost(HOST,USERNAME_HOST,PASSWORD_HOST);
						 if($start_work == "No Work Here !!"){
							$sql_s = "SELECT MIN(datekeyin) AS mindate FROM `stat_user_keyin` WHERE  staffid='$rs[staffid]' and datekeyin <> '0000-00-00' group by staffid "; 
							$result_s = mysql_db_query($dbnameuse,$sql_s) or die(mysql_error()."$sql_up<br>LINE::".__LINE__);
							$rss = mysql_fetch_assoc($result_s);
							$start_work = $rss[mindate];
						}//end  if($start_work == "No Work Here !!"){
					
					$datec = date("Y-m-d");			
					
					if($rs[groupkey_id] == "3" or $rs[groupkey_id] == "4"){
							
					 	$diffday = DayDiff($start_work, $datec);	
					 	//echo "$start_work :: $datec => $diffday<br>";
						if($diffday <= "7"){
									 $ratio1 = "1";
						 }else if($diffday > "7" and $diffday <= "14"){
									$ratio1 = "3";
						}else{
									$ratio1 = "3";	
						} 
							
						$conup = " ,ratio_id='$ratio1' ";	
					}//end if($rs[groupkey_id] == "3" or $rs[groupkey_id] == "4"){
					
					$sql_update = "UPDATE keystaff SET start_date='$start_work' $conup  WHERE staffid='$rs[staffid]'";
					mysql_db_query($dbnameuse,$sql_update) or die(mysql_error()."$sql_update<br>LINE::"._LINE__);
					//echo $diffday."  ::: ".$sql_update."<br>";
					$conup = "";
					$diffday = 0;
						
				}//end 	while($rs = mysql_fetch_assoc($result)){

#####################################################

ConHost(HOST,USERNAME_HOST,PASSWORD_HOST);
$dbname_temp = $db_name;
$arrgroup = array("2"=>"2","5"=>"5","3"=>"3","4"=>"4");
//echo "xxx :: $group_id :: $configdate";die;
if($group_id == ""){
	$configdate = date("Y-m");
	foreach($arrgroup as $key => $val){
		SubQCGroupL($val,$configdate,"");	
	}
}else{
 	SubQCGroupL($group_id,$configdate,"");
}
 
 if($xscript == "1"){
	echo "<script>alert('ประมวลผลการแบ่งกลุ่ม QC เรียบร้อยแล้ว');  window.opener.location.reload();window.close(); </script>";
 }else{
	echo "OK";		 
}




?>