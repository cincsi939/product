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
			set_time_limit(8000);
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			$mname	= array("","�.�.", "�.�.", "��.�.", "��.�.", "�.�.", "��.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.");
			$monthFull = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");

				$dbnameuse = $db_name;
				$time_start = getmicrotime();
				
		### �Ҥ�� monitor keyin
		function ShowPersonGov($get_staffid,$get_idcard){
			global $dbnameuse;
			$sql = "SELECT keyin_name  FROM  monitor_keyin  WHERE staffid='$get_staffid' AND idcard='$get_idcard'";
			$result = mysql_db_query($dbnameuse,$sql);
			$rs = mysql_fetch_assoc($result);
			return $rs[keyin_name];
		}//end function ShowPersonGov(){
				

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
		if($mm == ""){
		$mm = date("m");
		$mm = sprintf("%02d",intval($mm));
		}
		if($yy == ""){
		$yy=date("Y");
		$yy += 543;
		}
		
		//$datereq = "$yy-$mm-$dd";
	//	$datereq1 = ($yy-543)."-$mm-$dd";
		//$datereq =  "2552-06-01" ;
		//$datereq1 = "2009-06-01" ;
	}
	if($yy1 == ""){
		$yy1 = date("Y")+543;	
	}
	function CheckFieldPoint($get_tbl){
	global $dbnameuse;
	$sql_checkfield = "SELECT * FROM keyin_point WHERE keyinpoint > 0 AND tablename='$get_tbl'";
	$result_checkfield = mysql_db_query($dbnameuse,$sql_checkfield);
	while($rs_chF = mysql_fetch_assoc($result_checkfield)){
		$arr[] = $rs_chF[keyname];	
	}//end while($rs_chF = mysql_fetch_assoc($result_checkfield)){
	return $arr;
}//end function CheckFieldPoint(){

function CalPointPerDay($datereq1,$get_staffid){
	global $dbnameuse,$arr_f_tbl1,$arr_f_tbl3,$subfix,$subfix_befor;
	
	$str_std = " SELECT k_point ,tablename,price_point  FROM  table_price  ";
	$result_std = mysql_db_query($dbnameuse,$str_std);
	while($rs_std = mysql_fetch_assoc($result_std)){
		$tb = $rs_std[tablename]."$subfix" ;
		$k_point[$tb] =  $rs_std[k_point] ;
		$price_point[$tb] = $rs_std[price_point];
	}//end while($rs_std = mysql_fetch_assoc()){

$round = "am";
$TNUM = 0 ;
$j=1;
$numrows= 0;

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
WHERE monitor_keyin.timestamp_key  LIKE  '$datereq1%' AND keystaff.staffid='$get_staffid' 
GROUP BY idcard ORDER BY keystaff.staffid ASC " ;
//echo "$dbnameuse  :: ".$str."<hr>";timestamp_key LIKE  '$datereq1%' 
$results = mysql_db_query($dbnameuse,$str);
$numrows = mysql_num_rows($results);
$TNUM = 0;
while($rss  = mysql_fetch_assoc($results)){
		$j++;
				$results3 = mysql_db_query(DB_MASTER," SELECT  siteid  FROM  view_general  WHERE  CZ_ID = '$rss[idcard]' ");
				$rss3 = mysql_fetch_assoc($results3);
				
				$dbsite = STR_PREFIX_DB.$rss3[siteid] ;
				$d = explode("-", $datereq1);
				$ndate = $d[0]."-".$d[1]."-".$d[2];
				


			foreach($arr_f_tbl1 AS $key1 => $val1){
					$t = explode("#",$val1);
					$c = cond_str($t[1]);
					$xa1 = explode("||",$t[1]);
					
					#### �ҿ�Ŵ���й�������͹䢡�äԴ�ӹǳ�ش
					 $arrF = CheckFieldPoint($t[0]);
					
					$sql_ff = " SHOW  COLUMNS FROM  $t[0]".$subfix." WHERE TYPE LIKE '%timestamp%' ";
					//echo "$dbsite  :: $sql_ff <br>";die;
					$result_ff = @mysql_db_query($dbsite,$sql_ff) ;
					$rs_ff = @mysql_fetch_assoc($result_ff);
					if($rs_ff[Field] != "" ){ $contimestamp = " AND $rs_ff[Field] LIKE '$ndate%' ";}else{ $contimestamp = "";}
					//echo $contimestamp;die;
		
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
		//echo $sql_c1;die;
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
									$TPOINT_PERSON[$rss[staffid]][$rss[idcard]] = $TPOINT_PERSON[$rss[staffid]][$rss[idcard]] + ( $numpoint*$price_point[$tb1]) ;

								}//end if($numpoint > 0){
							}//end if($calcuatepoint==true){
							
						}else{
							$tb1 = $t[0]."$subfix";
							$TNUM += 1;
							$sumkeyuser_person[$rss[staffid]][$rss[idcard]] +=  1 ;
							$TPOINT_PERSON[$rss[staffid]][$rss[idcard]] = $TPOINT_PERSON[$rss[staffid]][$rss[idcard]] + ( 1*$k_point[$tb1]) ;
						}// end if($rs_c2[id] > 0)
					}//end while($rs_c1 = mysql_fetch_assoc($result_c1)){
				}//end 	foreach($arr_f_tbl1 AS $key1 => $val1){
			} /// end while($rss  = mysql_fetch_assoc($results)){
			//echo "<pre>";	
			//print_r($TPOINT_PERSON);
			//die;
	### �ӡ�úѹ�֡��������к�
			foreach($sumkeyuser_person as $key_person => $val_person){
			foreach($val_person as $k => $v){
			//	echo "���ʾ�ѡ�ҹ :: $key_person  �Ţ�ѵ� :: $k  ��Ҥ�ṹ ::".$TPOINT_PERSON[$key_person][$k]."<br>";
			$sql_check = "SELECT * FROM stat_user_keyperson WHERE datekeyin='$datereq1' AND staffid='$key_person' AND idcard='$k'";
			//echo $sql_check."<br>";
			$result_check = mysql_db_query($dbnameuse,$sql_check);
			$rs_check = mysql_fetch_assoc($result_check);
			if($rs_check[idcard] != ""){
				$sql_key_person = "UPDATE stat_user_keyperson SET numpoint='".$TPOINT_PERSON[$key_person][$k]."', numkeyin='$v' WHERE datekeyin='$datereq1' AND staffid='$key_person' AND idcard='$k'";
			}else{
			$sql_key_person = "INSERT INTO stat_user_keyperson(datekeyin,staffid,idcard,numkeyin,numpoint)VALUES('$datereq1','$key_person','$k','$v','".$TPOINT_PERSON[$key_person][$k]."')";	
			}
			//echo $sql_key_person."<br><hr>";
			@mysql_db_query($dbnameuse,$sql_key_person);
			}// end foreach($val_person as $k => $v){
		}//end foreach($sumkeyuser_person as $key_person => $val_person){
		
}//end function CalPointPerDay($datereq1,$get_staffid){
	
	

	
?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<link href="../hr3/tool_competency/diagnosticv1/css/style.css" rel="stylesheet" type="text/css" />
    <style type="text/css">

    .mouseOut {
    background: #708090;
    color: #FFFAFA;
    }

    .mouseOver {
    background: #FFFAFA;
    color: #000000;
    }
    
	body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<script language="javascript">
	function CheckF(){
		if(!document.form1.status_app[0].checked  && !document.form1.status_app[1].checked){
				alert("��س����͡ʶҹС���Ѻ�ͧ�����١��ͧ�ͧ������");
				return false;
		}	
	}
</script>
</HEAD>
<BODY ><br>

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
  <tr>
    <td valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td colspan="5" bgcolor="#FFFFFF"><form id="form1" name="form1" method="post" action="">
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="14%" align="right"><strong>��͹�� : </strong></td>
                <td width="86%" align="left">
                  <select name="mm" id="mm">
                  <option value="">���͡��͹</option>
                  <?
                  	for($m = 1 ; $m <= 12 ; $m++ ){
						$xmm = sprintf("%02d",$m);
						if($xmm == $mm){ $sel = "selected='selected'";}else{ $sel = "";}
						echo "<option value='$xmm' $sel>$monthFull[$m]</option>";
					}//end for($m = 1 ; $m <= 12 ; $m++ ){
				  ?>
                  </select>
                 <strong> �� </strong>
                 <select name="yy1" id="yy1">
                 <option value="">���͡��</option>
                 <?
                 	for($y = 2552 ; $y <= (date("Y")+543) ; $y++){
						if($y == $yy1){ $sel1 = "selected='selected'";}else{ $sel1 = "";}
							echo "<option value='$y' $sel1>$y</option>";
					}
				 ?>
                 </select>
                
                  <input type="submit" name="button2" id="button" value="�ʴ���§ҹ">
               </td>
              </tr>
            </table>
          </form></td>
          </tr>
          <?
          
		$xmonth1 = ($yy1-543)."-".sprintf("%02d",$mm);		
		$txt_yy = $yy1;
		$txt_mm = $mm;
		  ?>
          <tr>
            <td colspan="5" bgcolor="#FFFFFF"><strong>��§ҹ��ػ����Ѻ�ͧ��Ҥ�ṹ��Ш���͹ <?=$monthFull[intval($txt_mm)]?> <?=$txt_yy?></strong></td>
          </tr>
          <tr>
            <td width="4%" align="center" bgcolor="#FFFFFF"><strong>�ӴѺ</strong></td>
            <td width="43%" align="center" bgcolor="#FFFFFF"><strong>�ѹ���ѹ�֡������</strong></td>
            <td width="25%" align="center" bgcolor="#FFFFFF"><strong>��Ҥ�ṹ</strong></td>
            <td width="18%" align="center" bgcolor="#FFFFFF"><strong>ʶҹС���Ѻ�ͧ��ṹ</strong></td>
            <td width="10%" align="center" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
            <?
				//$sql = "SELECT sum(numpoint) as kpoint ,datekeyin,status_approve  FROM `stat_user_keyperson` where staffid='".$_SESSION[session_staffid]."' and datekeyin LIKE '$xmonth1%'   group by datekeyin";
				$curent_date = date("Y-m-d");
				
				$sql = "SELECT
Sum(numpoint) AS kpoint,
stat_user_keyperson.datekeyin,
stat_user_keyperson.status_approve,
stat_user_keyin.numkpoint,
stat_user_keyperson.idcard
FROM
stat_user_keyperson
Inner Join stat_user_keyin ON stat_user_keyperson.datekeyin = stat_user_keyin.datekeyin AND stat_user_keyperson.staffid = stat_user_keyin.staffid
where stat_user_keyperson.staffid='".$_SESSION[session_staffid]."' and stat_user_keyperson.datekeyin LIKE '$xmonth1%'
group by stat_user_keyperson.datekeyin";
//echo $sql;
				$result = mysql_db_query($db_name,$sql);
				$i=0;
				while($rs = mysql_fetch_assoc($result)){
					if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
					if($rs[numkpoint] > $rs[kpoint]){
						$kpoint_val = $rs[numkpoint];
					}else{
						$kpoint_val = $rs[kpoint];	
					}
					
					
	$sql_sel = "SELECT COUNT(staffid) AS num1 FROM stat_user_keyperson WHERE status_approve='0' AND datekeyin='$rs[datekeyin]' AND staffid='".$_SESSION[session_staffid]."' ";
	$result_sel = mysql_db_query($dbnameuse,$sql_sel);
	$rs_s = mysql_fetch_assoc($result_sel);
	if($rs_s[num1] > 0){ 
				
			if($curent_date == $rs[datekeyin]){  // �Ѻ�ͧ��������㹡óշ�����ѹ�����ҹ��
					$link_update = "<a href='report_keypiont_perday.php?datereq1=$rs[datekeyin]'><img src=\"../../images_sys/Refreshb1.png\" width=\"20\" height=\"20\" border=\"0\" title=\"���������Ѻ�ͧ������\"></a>";
					$status_approve_pic = "<img src=\"../../images_sys/unapprove.png\" width=\"16\" height=\"16\" border=\"0\" title=\"�ѧ������Ѻ�ͧ��Ҥ�ṹ\">";
			}else{  // ����Դ����ѹ����������� approve ���ѵ��ѵ�
			
			$approve_id = intval(CheckKeyApprove($rs[idcard],$_SESSION[session_staffid]));
			$sql_update = "UPDATE stat_user_keyperson SET status_approve='$approve_id'  WHERE datekeyin='$rs[datekeyin]' AND staffid='".$_SESSION[session_staffid]."' AND idcard='$rs[idcard]'";	
			mysql_db_query($db_name,$sql_update);
					$link_update = "";
					$status_approve_pic = "<img src=\"../../images_sys/approve20.png\" width=\"16\" height=\"16\" border=\"0\" title=\"�Ѻ�ͧ��Ҥ�ṹ���º��������\">";
			}// end 	if($curent_date == $rs[datekeyin]){ 
		
		$kpoint_val = $rs[kpoint];

	}else{ 
			$status_approve_pic = "<img src=\"../../images_sys/approve20.png\" width=\"16\" height=\"16\" border=\"0\" title=\"�Ѻ�ͧ��Ҥ�ṹ���º��������\">";
		$link_update = "";
		$kpoint_val = $rs[numkpoint];
	}
			?>
          <tr bgcolor="<?=$bg?>">
            <td align="center"><?=$i?></td>
            <td align="center"><?  if($kpoint_val > 0){ echo "<a href='report_keypiont_perday.php?datereq1=$rs[datekeyin]''>".DBThaiLongDate($rs[datekeyin])."</a>";}else{ echo DBThaiLongDate($rs[datekeyin]);}?></td>
            <td align="center"><? echo number_format($kpoint_val,2);?></td>
            <td align="center"><?=$status_approve_pic?></td>
            <td align="center"><?=$link_update?></td>
            </tr>
            <?
				$sumpoint += $kpoint_val;
				}//end while($rs = mysql_fetch_assoc($result)){
			?>
          <tr>
            <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>��� : </strong></td>
            <td align="center" bgcolor="#FFFFFF"><?=number_format($sumpoint,2)?></td>
            <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>