<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AdminReport";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Pairoj
#DateCreate::29/03/2007
#LastUpdate::29/03/2007
#DatabaseTable::schooll_name, login
#END
#########################################################
//session_start();
			set_time_limit(0);
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
			$dbnameuse = $db_name;
			$time_start = getmicrotime();

			
			$mname	= array("","���Ҥ�", "����Ҿѹ��", "�չҤ�", "����¹", "����Ҥ�", "�Զع�¹", "�á�Ҥ�", "�ԧ�Ҥ�", "�ѹ��¹", "���Ҥ�", "��Ȩԡ�¹", "�ѹ�Ҥ�");


	  		function compare_order_asc($a, $b)			
			{
				global $sortname;
				return strnatcmp($a["$sortname"], $b["$sortname"]);
			}
			
			 function compare_order_desc($a, $b)			
			{
				global $sortname;
				return strnatcmp($b["$sortname"], $a["$sortname"]);
			}
			
			function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = intval($x[0]);
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				return $xrs;
			}

			function thaidate1($temp){
				global $mname;
				if($temp != ""){
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = intval($x[0]+543);
				$xrs = intval($x[2])." $m1 "." $d1 " ;
				return $xrs;
				}else{
				$xrs = "<font color=red>Not Available</font>";
				return $xrs;
				}
			}
			
			function swapdate($temp){
				$kwd = strrpos($temp, "/");
				if($kwd != ""){
					$d = explode("/", $temp);
					$ndate = ($d[2]-543)."-".$d[1]."-".$d[0];
				} else { 		
					$d = explode("-", $temp);
					$ndate = $d[2]."/".$d[1]."/".$d[0];
				}
				return $ndate;
			}


	if (!isset($datereq)){
		if(!isset($dd)){
			$dd = date("d");
		}
		$mm = date("m");
		$mm = sprintf("%02d",intval($mm));
		$yy=date("Y");
		$yy += 543;
		$datereq = "$yy-$mm-$dd";
		$datereq1 = ($yy-543)."-$mm-$dd";
		//$datereq =  "2552-06-01" ;
		//$datereq1 = "2009-06-01" ;
	}

$str_std = " SELECT k_point ,tablename,price_point  FROM  table_price  ";
$result_std = mysql_db_query($dbnameuse,$str_std);
while($rs_std = mysql_fetch_assoc($result_std)){
	$tb = $rs_std[tablename]."$subfix" ;
	$k_point[$tb] =  $rs_std[k_point] ;
	$price_point[$tb] = $rs_std[price_point];
}


###�Ҩش���촷��й�令ӹǳ�ش
function CheckFieldPoint($get_tbl){
	global $dbnameuse;
	$sql_checkfield = "SELECT * FROM keyin_point WHERE keyinpoint > 0 AND tablename='$get_tbl'";
	$result_checkfield = mysql_db_query($dbnameuse,$sql_checkfield);
	while($rs_chF = mysql_fetch_assoc($result_checkfield)){
		$arr[] = $rs_chF[keyname];	
	}//end while($rs_chF = mysql_fetch_assoc($result_checkfield)){
	return $arr;
}//end function CheckFieldPoint(){


$round = "am";

$TNUM = 0 ;
	  $j =1 ;

//$datereq1 = '2010-03-11';
//$sql1 = "
//SELECT DISTINCT
//date(monitor_keyin.timestamp_key) AS update_date
//FROM monitor_keyin WHERE date(monitor_keyin.timestamp_key) >= '$datereq1'
//ORDER BY  update_date  DESC   " ;
//echo "$sql1<br>";
//$result1 = mysql_db_query($dbnameuse,$sql1);
//while($rs1 = mysql_fetch_assoc($result1)){
//
//$dayrecord[] =   $rs1[update_date] ;
//
//}
//
//$dayrecord = array_unique($dayrecord);
//rsort($dayrecord);
//reset($dayrecord);

//echo "<pre>"; print_r($dayrecord);echo"</pre>";
//die;

$j=1;
$numrows= 0;
$datereq1 = array("2010-03-12");
foreach($datereq1 AS $key=>$val){
if($val != "0000-00-00"){
$sumkeyuser = array() ;
$numkey= array() ;
$TPOINT = array();
$str = "
SELECT
keystaff.staffid,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,

monitor_keyin.idcard,
monitor_keyin.timeupdate
FROM
keystaff
Inner Join monitor_keyin ON monitor_keyin.staffid = keystaff.staffid

WHERE   ( keystaff.sapphireoffice = 0 )  AND (keystaff.status_extra = 'NOR' ) AND (timestamp_key LIKE  '$val%' or timeupdate LIKE '$val%') GROUP BY idcard   ORDER BY keystaff.staffid ASC    " ;

echo $str."<hr>";
$results = mysql_db_query($dbnameuse,$str);
$numrows = mysql_num_rows($results);
$TNUM = 0;
while($rss  = mysql_fetch_assoc($results)){


$j++;

$results3 = mysql_db_query(DB_MASTER," SELECT  siteid  FROM  view_general  WHERE  CZ_ID = '$rss[idcard]' ");
$rss3 = mysql_fetch_assoc($results3);

$dbsite = STR_PREFIX_DB.$rss3[siteid] ;
$d = explode("-", $val);
$ndate = $d[0]."-".$d[1]."-".$d[2];

//$sql2 = " SELECT  count(username) AS NUM , username , subject , logtime  FROM  log_update WHERE  username = '$rss[idcard]'  AND logtime LIKE  '$ndate%'  AND  ( action LIKE 'edit%' OR  action LIKE 'delete%' OR action LIKE 'add%' OR action LIKE 'ChangRows%' OR action LIKE 'changeRow%'  ) GROUP BY username  ORDER BY   subject  DESC ";
//$result2 = mysql_db_query($dbsite,$sql2) ;
//$rs2 = mysql_fetch_assoc($result2);
//echo $sql2." $dbsite<br>";
//$TNUM +=  $rs2[NUM] ;
//if($rs2[NUM] != 0){
//	$sumkeyuser[$rss[staffid]] +=  $rs2[NUM] ;
//	$numkey[$rss[staffid]] =  $numkey[$rss[staffid]] + 1 ;
//}
//echo "<hr>$ndate $rss[staffname] :  $rss[idcard] <hr>";

		foreach($arr_f_tbl1 AS $key1 => $val1){
			$t = explode("#",$val1);
			$c = cond_str($t[1]);
			$xa1 = explode("||",$t[1]);
			
			#### �ҿ�Ŵ���й�������͹䢡�äԴ�ӹǳ�ش
			 $arrF = CheckFieldPoint($t[0]);
			
			$sql_ff = " SHOW  COLUMNS FROM  $t[0]".$subfix." WHERE TYPE LIKE '%timestamp%' ";
			//echo "$sql_ff <br>";
			$result_ff = @mysql_db_query($dbsite,$sql_ff) ;
			$rs_ff = @mysql_fetch_assoc($result_ff);
			if($rs_ff[Field] != "" ){ $contimestamp = " AND $rs_ff[Field] LIKE '$ndate%' ";}else{ $contimestamp = "";}


			$str_listfield = "SHOW COLUMNS FROM $t[0]".$subfix." WHERE TYPE NOT LIKE '%timestamp%' AND Extra NOT LIKE '%auto_increment%' ";
			$result_listfield = mysql_db_query($dbsite,$str_listfield);
			$xi = 0;
			$list_field = "";
			while($rs_l = mysql_fetch_assoc($result_listfield)){
				if(in_array($rs_l[Field],$arrF)){
					if($list_field > "") $list_field .= ","; 
					$list_field .= " $rs_l[Field] ";
					$xi++;
				}//end if(in_array($rs_l[Field],$arrF)){
			}//end while($rs_l = mysql_fetch_assoc($result_listfield)){

	if($list_field != ""){ 
		$sql_c1 = "SELECT ".$list_field." ,min(auto_id) as auto_id, $c  FROM $t[0]".$subfix." WHERE id='$rss[idcard]'  $contimestamp  GROUP BY $c";
	}else{
		$sql_c1 = "SELECT min(auto_id) as auto_id, $c  FROM $t[0]".$subfix." WHERE id='$rss[idcard]'  $contimestamp  GROUP BY $c";	
	
	}
		
		$result_c1 = mysql_db_query($dbsite,$sql_c1);
	while($rs_c1 = mysql_fetch_assoc($result_c1)){
				$sql_c2 = "SELECT ".$list_field." ,auto_id, $c  FROM $t[0]".$subfix_befor." WHERE id='$rss[idcard]' AND auto_id='$rs_c1[auto_id]' GROUP BY $c";
				//echo $sql_c2."<br> ���ʺѵ :: $rs_c2[id]<hr>";
				$result_c2 = mysql_db_query($dbsite,$sql_c2);
				$rs_c2 = mysql_fetch_assoc($result_c2);
				$calcuatepoint=false ;
				if($rs_c2[id] > 0){
					//echo "���ʤ�����Ѩ�غѹ  :: ".$rs1[staffid]."<br>";
					/// selectr  staff ����� auto_id ���¡��Ңͧ��÷Ѵ���ǡѹ   ��͹˹������繵���ͧ������� �ҡ��������Դ��ṹ��¨ش ��	 $calcuatepoint =true	
					$conList = "";
					foreach($xa1 as $xk1 => $xv1){
						if($conList != "") $conList .= " AND "; 
						$conList .= "$xv1='".$rs_c1[$xv1]."'";
							
					}
					if($conList != ""){ $conA = " AND ";}else{ $conA = "";}
					
					$sql_check = "SELECT staffid  FROM $t[0]".$subfix_befor." WHERE id='$rss[idcard]' and auto_id < '$rs_c1[auto_id]'  $conA $conList ORDER BY  auto_id DESC LIMIT 0,1";
					//echo $sql_check."<br>";
					$result_check = mysql_db_query($dbsite,$sql_check);
					$rs_check = mysql_fetch_assoc($result_check);

					if($rs_check[staffid] != $rss[staffid]){
						$calcuatepoint = true;
					}//end if($rs_check[staffid] != $rs1[staffid]){
							if($calcuatepoint==true){
							$result1_diff = array_diff_assoc($sql_c1, $sql_c2);
							$numpoint  = count($result1_diff);
							//echo "�ӹǹ��¡�÷����� :: ".$numpoint."<br>";
								if($numpoint > 0){ // �ó��ըش��úѹ�֡����ҧ�ѹ���ӳǳ������ price_point 㹡�äٳ
									$tb1 = $t[0]."$subfix";
									//$TPOINT  +=   $numpoint*$price_point[$tb1];
									$TPOINT[$rss[staffid]] = $TPOINT[$rss[staffid]] + ( $numpoint*$price_point[$tb1]) ;

								}//end if($numpoint > 0){
							}//end if($calcuatepoint==true){
							
				}else{
					//echo $sql_c1."<br>";
						$tb1 = $t[0]."$subfix";
						$TNUM += 1;
						$sumkeyuser[$rss[staffid]] +=  1 ;
						$numkey[$rss[staffid]] =  $numkey[$rss[staffid]] + 1 ;
						$TPOINT[$rss[staffid]] = $TPOINT[$rss[staffid]] + ( 1*$k_point[$tb1]) ;
						
						
				}// end if($rs_c2[id] > 0){
				
		}//end while($rs_c1 = mysql_fetch_assoc($result_c1)){

		#######################################################				
			
			
			
			
//			$sql_c = " SELECT COUNT(*) AS num  FROM  $t[0]".$subfix." WHERE id = '$rss[idcard]' $contimestamp GROUP BY  $c " ;		
//			$result_c = @mysql_db_query($dbsite,$sql_c) ;
//			$rs_c = @mysql_fetch_assoc($result_c);
//			$rs_c[num] = @mysql_num_rows($result_c);
//			//echo "$rss[staffid]  $t[0]".$subfix." $rs_c[num]<br>";
//			
//			
//			if($rs_c[num]>0){
//				$TNUM = $TNUM + $rs_c[num] ;
//				$sumkeyuser[$rss[staffid]] +=  $rs_c[num] ;
//				$numkey[$rss[staffid]] =  $numkey[$rss[staffid]] + 1 ;
//				$tb1 = $t[0]."$subfix";
//				$TPOINT[$rss[staffid]] = $TPOINT[$rss[staffid]] + ( $rs_c[num]*$k_point[$tb1]) ;
//			}


		}
		
	$xnumrows[$rss[staffid]] = $xnumrows[$rss[staffid]]+1;


}

 echo "<pre>"; print_r($TPOINT);echo"</pre>";
  echo "<pre>"; print_r($numkey);echo"</pre>";
   echo "<pre>"; print_r($sumkeyuser);echo"</pre>";
// 
// 
// die;
//echo "<pre>";
//print_r($xnumrows);
//echo "<pre>";
//print_r($TPOINT);

foreach($sumkeyuser AS $key2=>$val2){
	$sql_ins = " REPLACE INTO  stat_user_keyin(datekeyin,staffid,val_avg,val_max,val_min,numkeyin,kval_avg,kval_max,kval_min,numkpoint,numperson)VALUES('$val','$key2','$avg','$val2','$minc','$sumkeyuser[$key2]','','$TPOINT[$key2]','$TPOINT[$key2]','$TPOINT[$key2]',$xnumrows[$key2]); ";
	echo "$sql_ins <hr>";
	//echo "$numkey[$key2] <hr>";
	mysql_db_query($dbnameuse,$sql_ins);
}
	  	rsort($sumkeyuser);
		$maxc = $sumkeyuser[0] ;
		reset($sumkeyuser);
	  	sort($sumkeyuser);
		$minc = $sumkeyuser[0] ;
		reset($sumkeyuser);
		
		rsort($TPOINT);
		$maxk = $TPOINT[0] ;
		reset($TPOINT);
	  	sort($TPOINT);
		$mink = $TPOINT[0] ;
		reset($TPOINT);
//echo "<pre>"; print_r($TPOINT);echo"</pre>";
//echo "$maxk<hr>$mink<hr>";

$sql_x = " SELECT  Avg(stat_user_keyin.val_max) AS val_avg,Avg(numkpoint) AS kval_avg   FROM stat_user_keyin  WHERE  stat_user_keyin.datekeyin LIKE   '$val%'  ";
//echo $sql_x;
$result_x = mysql_db_query($dbnameuse,$sql_x);
$rs_x = mysql_fetch_assoc($result_x);


$sql_u = " UPDATE   stat_user_keyin SET val_avg = '$rs_x[val_avg]' ,val_min = '$minc' , val_max = '$maxc' , kval_max = '$maxk' ,kval_min = '$mink' , kval_avg = '$rs_x[kval_avg]'  WHERE datekeyin LIKE '$val%' ; ";
mysql_db_query($dbnameuse,$sql_u);


$sql_r = " REPLACE INTO  std_val_ref(datekeyin,val_avg,val_max,val_min,val_kavg,val_kmax,val_kmin)VALUES('$val','$rs_x[val_avg]','$maxc','$minc','$rs_x[kval_avg]','$maxk','$mink'); ";
mysql_db_query($dbnameuse,$sql_r);


//echo "$sql_x <br> $sql_r <br> $sql_u <hr>";



} // end

} // end 


###  ��¹���������� ranking 
//$data_now = date("Y-m-d");
$date_now = "2010-03-12";
//mysql_db_query($dbnameuse," TRUNCATE  ranking");
$sql_ranking = "SELECT * FROM stat_user_keyin WHERE datekeyin LIKE '$data_now%' order by numkpoint DESC";
$result_ranking = mysql_db_query($dbnameuse,$sql_ranking);
$n=0;
while($rs_r = mysql_fetch_assoc($result_ranking)){
	$n++;
	$sql5 = " INSERT INTO  ranking(staffid,numrowdata,rank) VALUES ('$rs_r[staffid]','$rs_r[numkpoint]','$n')";
	//echo $sql5."<br>";
	mysql_db_query($dbnameuse,$sql5);	
}//end 

##  end ��¹���������� ranking 
$time_end = getmicrotime();
echo "����㹡�û����ż� :".($time_end - $time_start);echo " Sec.";




 echo "<h1>Done...................";
 ?>