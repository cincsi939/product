<?
include ("../../../../config/conndb_nonsession.inc.php")  ;
include('function.inc_v1.php') ;
include('function_getdate_face.php') ;
$arrsite = GetSiteKeyData();
ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 

$count_yy = date("Y")+543;
$mname	= array("","�.�.", "�.�.", "��.�.", "��.�.", "�.�.", "��.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.");
$monthFull = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$point_num = 60;	
	if($yy1 == ""){
		$yy1 = date("Y")+543;
	}
	if($mm == ""){					
		$mm = sprintf("%2d",date("m"));
	}
	//echo $yy;
	function ShowGroup($get_group){
			if($get_group == "1"){ return "A";}
			else if($get_group == "2"){ return "B";}
			else if($get_group == "3"){ return "C";}
	}

$array_day = array("1"=>"�.","2"=>"�.","3"=>"�.","4"=>"��.","5"=>"�.","6"=>"�.");
/*
echo "<pre>";
print_r($_POST);
*/

//$get_date = "2010-03-01";	
function ShowDayOfMonth($get_month){
	$arr_d1 = explode("-",$get_month);
	$xdd = "01";
	$xmm = "$arr_d1[1]";
	$xyy = "$arr_d1[0]";
	$get_date = "$xyy-$xmm-$xdd"; // �ѹ�������
	//echo $get_date."<br>";
	$xFTime1 = getdate(date(mktime(0, 0, 0, intval($xmm+1), intval($xdd-1), intval($xyy))));
	$numcount = $xFTime1['mday']; // �ѹ����ش���¢ͧ��͹
	if($numcount > 0){
		$j=1;
			for($i = 0 ; $i < $numcount ; $i++){
				$xbasedate = strtotime("$get_date");
				 $xdate = strtotime("$i day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// �ѹ�Ѵ�		
				 $arr_d2 = explode("-",$xsdate);
				 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d2[1]), intval($arr_d2[2]), intval($arr_d2[0]))));	
				 if($xFTime['wday'] == 0){
					 $j++;
						 
					}
					if($xFTime['wday'] != "0"){
						$arr_date[$j][$xFTime['wday']] = $xsdate;	
					}
				 
			}
			
	}//end if($numcount > 0){
	return $arr_date;	
}//end function ShowDayOfMonth($get_month){
//$xarr = ShowDayOfMonth("2010-04-01");
//echo "<pre>";
//print_r($xarr);


function ShowKeyPerson($get_staffid,$get_date){
		global $db_name,$point_num;
		//$sql = "SELECT numkpoint  FROM stat_user_keyin  WHERE datekeyin = '$get_date' AND staffid='$get_staffid'";
		$sql = "SELECT count(idcard) as numid FROM `monitor_keyin` where staffid='$get_staffid' and timeupdate LIKE '$get_date%' group by staffid";
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[numid];
		
}


function CheckQCPerDay($get_staff,$get_date){
global $db_name;
//$sql1 = "SELECT count(idcard) as num1 FROM `validate_checkdata` where staffid='$get_staff' and datecal LIKE '$get_date%'  group by idcard";
$sql1 = "SELECT
count(monitor_keyin.idcard) as num1
FROM
monitor_keyin
Inner Join validate_checkdata ON monitor_keyin.idcard = validate_checkdata.idcard
where monitor_keyin.staffid='$get_staff' and monitor_keyin.timeupdate LIKE '$get_date%'
and validate_checkdata.staffid ='$get_staff'
group by validate_checkdata.idcard";
$result1 = mysql_db_query($db_name,$sql1);
$numr1 = @mysql_num_rows($result1);
return $numr1;
///$rs1 = mysql_fetch_assoc($result1);
//return $rs1[num1];
	
}

### �ѹ�֡������ŧ㹵��ҧ temp 
function SaveStatQc($get_staff,$get_date){
		global $db_name;
		$numkey = ShowKeyPerson($get_staff,$get_date); // �ӹǹ�ش���������������ѹ
		$numqc = CheckQCPerDay($get_staff,$get_date); // �ӹǹ�ش��� QC
		$sql_save = "REPLACE INTO temp_check_qc(datekeyin,staffid,numkey,numqc)VALUES('$get_date','$get_staff','$numkey','$numqc')";
	//	echo $sql_save."<br>";
		 mysql_db_query($db_name,$sql_save);
		
}//end function SaveStatQc($get_staff,$get_date){
	
	
function AlertQC($get_staff,$get_yymm){
		global $db_name;
		$Rpoint = ShowRpoint($get_staff);
		$sql = "SELECT * FROM temp_check_qc WHERE staffid='$get_staff' AND datekeyin LIKE '$get_yymm%' ORDER BY datekeyin ASC";
		$result = mysql_db_query($db_name,$sql);
		$numk = 0;
		$j=0;
		while($rs = mysql_fetch_assoc($result)){
				if($j==0){ // ��˹��ѹ����������
					$date_start = $rs[datekeyin];
				}
				
				$numk += $rs[numkey];
				if($numk >= $Rpoint){   // �ó��ʹ�������Թ������ ����Ǩ�ͺ��� QC
					
					if(CheckLengthQC($get_staff,$date_start,$rs[datekeyin]) > 0){ // 5hk
						$arrDQc[$rs[datekeyin]] = "Y";
					}else{
						$arrDQc[$rs[datekeyin]] = "N";
					}//if(CheckLengthQC($get_staff,$date_start,$rs[datekeyin]) > 0){
					//$numk = 0; // ��˹������ɨҡ��� QC
					$numk = $numk-$Rpoint;
					$j=0;
				}else{ 
					$j++;
				} // e   // �ó��ʹ�������Թ������ ����Ǩ�ͺ��� QC
			
		}//end while($rs = mysql_fetch_assoc($result)){
			//echo "<pre>";
			//print_r($arrDQc);
			return $arrDQc;
}

##############  ����Ѻ����� C ���ա������͹
function AlertQC_C($get_staff,$get_yymm){
		global $db_name;
		$sql = "SELECT * FROM temp_check_qc WHERE staffid='$get_staff' AND datekeyin LIKE '$get_yymm%' ORDER BY datekeyin ASC";
		$result = mysql_db_query($db_name,$sql);
		$numk = 0;
		$j=0;
		while($rs = mysql_fetch_assoc($result)){
			if($rs[numkey] > 0){
				if($rs[numkey] != $rs[numqc]){
					$arrDQc[$rs[datekeyin]] = "N";
				}else{
					$arrDQc[$rs[datekeyin]] = "Y";
				}	
			}//end if($rs[numkey] > 0){
		}//end while($rs = mysql_fetch_assoc($result)){
		
		//echo "<pre>";
			//print_r($arrDQc);
			return $arrDQc;
}// end function AlertQC_C($get_staff,$get_yymm){
############ end ##############  ����Ѻ����� C ���ա������͹


function ShowRpoint($get_staff){
		global $db_name;
		$sql1 = "SELECT
keystaff_group.rpoint
FROM
keystaff_group
Inner Join keystaff ON keystaff_group.groupkey_id = keystaff.keyin_group
WHERE
keystaff.staffid =  '$get_staff'
";
	$result1 = mysql_db_query($db_name,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	return $rs1[rpoint];
}

function CheckLengthQC($get_staff,$date_s,$date_e){
		global $db_name;
		$sql1 = "SELECT sum(numqc) AS numqc FROM  temp_check_qc  WHERE staffid='$get_staff' AND datekeyin BETWEEN '$date_s' and '$date_e' ";
		//echo $sql1."<br>";
		$result1 = mysql_db_query($db_name,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
		return $rs1[numqc];
}

###########  
if($_SERVER['REQUEST_METHOD'] == "GET"){
		if($process == "perday"){
			 if($site_id != "999"){
				$in_pin = GetPinStaff($site_id);
				if($in_pin != ""){ $conv2 = " AND card_id IN($in_pin)";}else{ $conv2 = "";}
			 }//end  if($site_id != "999"){
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST);   

			
				  $sql = "SELECT keystaff.staffid, keystaff.prename, keystaff.staffname, keystaff.staffsurname, keystaff.sapphireoffice,
keystaff.keyin_group FROM keystaff WHERE  keyin_group='3' AND status_permit='YES' AND ratio_id='1'  $conv2  ORDER BY staffname ASC ";	//  AND staffid='10378'
//echo $sql;

			if($curent_date == ""){ // �óջ����żŻѨ�غѹ
				$curent_date = date("Y-d-m");
			}//end if($curent_date == ""){ 
			
			$result = mysql_db_query($db_name,$sql);
			$iii=0;
			while($rs = mysql_fetch_assoc($result)){

						SaveStatQc($rs[staffid],$curent_date);// �ѹ�֡��� temp	
				
			}//end while($rs = mysql_fetch_assoc($result)){
				echo "<script> location.href='?process=&yy1=$yy1&mm=$mm&site_id=$site_id';</script>";
		}// end 		if($process == "perday"){


}//end if($_SERVER['REQUEST_METHOD'] == "GET"){

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>��§ҹ��Ǩ�ͺ��� QC</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
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
</head>
<body>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><strong>��§ҹ��Ǩ�ͺ�ӹǹ��¡�÷���ͧ QC</strong></td>
        </tr>
        <tr>
          <td align="left"><form id="form1" name="form1" method="post" action="">
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
                 	for($y = 2552 ; $y <= $count_yy ; $y++){
						if($y == $yy1){ $sel1 = "selected='selected'";}else{ $sel1 = "";}
							echo "<option value='$y' $sel1>$y</option>";
					}
				 ?>
                 </select>
                  
                  <select name="site_id" id="site_id">
                 <option value="">���͡ site �ҹ</option>
                 <option value="999" <? if($site_id == "999"){ echo " selected='selected' ";}?>>���͡������</option>
                 <?
                 	if(count($arrsite) > 0){
							foreach($arrsite as $kk => $vv){
								if($kk == $site_id){ $sel = " selected='selected' ";}else{ $sel = "";}
									echo "<option value='$kk' $sel>$vv</option>";
							}
					}//end 	if(count($arrsite) > 0){
				 ?>
                 
                 </select>

                 
                  <input type="submit" name="button2" id="button" value="�ʴ���§ҹ">
<!--                 <a href="?process=y&yy1=<?=$yy1?>&mm=<?=$mm?>">���꡻����ż��ա����</a>
                ||  <a href="?process=&yy1=<?=$yy1?>&mm=<?=$mm?>">�ʴ���§ҹ�������ͧ�����ż�</a>--></td>
              </tr>
            </table>
          </form></td>
        </tr>
        <? 
		$col_w = 65; // �ѵ�Ҥ�������Ǣͧ�ѹ���
		//echo "$yy1<br>";
		if($xtype == ""){ $xtype = 3;} // �ó������кء���� ����� defult �� ����� A
		if($xtype == "1"){$bg_link1 = "#FFFFFF";$bg_link2 = "#E9E9E9";$bg_link3 = "#E9E9E9";}else{ $bg_link1 = "#E9E9E9";}
		if($xtype == "2"){$bg_link2 = "#FFFFFF";$bg_link1 = "#E9E9E9";$bg_link3 = "#E9E9E9";}else{ $bg_link2 = "#E9E9E9";}
		if($xtype == "3"){$bg_link3 = "#FFFFFF";$bg_link2 = "#E9E9E9";$bg_link1 = "#E9E9E9";}else{ $bg_link3 = "#E9E9E9";}
		$xmonth1 = ($yy1-543)."-".sprintf("%02d",$mm);
		//echo "<br>$xmonth1";
		$xarr = ShowDayOfMonth($xmonth1); // �ʴ���¡���ѹ���ͧ��͹���
//		echo "<pre>";
//		print_r($xarr);
//		die;
		$width_col = $col_w/count($xarr);
		
		
		$txt_yy = $yy1;
		$txt_mm = $mm;


			 if($site_id != "999"){
					$in_pin = GetPinStaff($site_id);
					if($in_pin != ""){ $conv2 = " AND card_id IN($in_pin)";}else{ $conv2 = "";}
			 }//end  if($site_id != "999"){
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST);   
			 
        if($xtype == "1"){
			$cong = " WHERE  keyin_group='1' AND status_permit='YES' $conv2";	
		}else if($xtype == "2"){
			$cong = " WHERE  keyin_group='2' AND status_permit='YES' $conv2";	
		}else if($xtype == "3"){
			$cong = " WHERE  keyin_group='3' AND status_permit='YES' $conv2";
		}
		
		$sql_diff = "SELECT (sum(temp_check_qc.numkey)-sum(temp_check_qc.numqc)) as numdiffqc FROM keystaff
Inner Join temp_check_qc ON keystaff.staffid = temp_check_qc.staffid
$cong  AND ratio_id='1'
and temp_check_qc.datekeyin LIKE '$xmonth1%'
group by keystaff.keyin_group";
		$result_diff = mysql_db_query($dbnameuse,$sql_diff) or die(mysql_error()."$sql_diff<br>LINE::".__LINE__);
		$rsdf = mysql_fetch_assoc($result_diff);

		//echo "<pre>";print_r($xarr);
		?>
        <tr>
          <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <!--  <tr>
              <td width="12%" align="center" bgcolor="<?=$bg_link1?>"><strong><a href="report_qc.php?xtype=1&mm=<?=$mm?>&yy1=<?=$yy1?>&process=<?=$process?>">����� A</a></strong></td>
              <td width="13%" align="center" bgcolor="<?=$bg_link2?>"><strong><a href="report_qc.php?xtype=2&mm=<?=$mm?>&yy1=<?=$yy1?>&process=<?=$process?>">����� B</a></strong></td>
              <td width="13%" align="center" bgcolor="<?=$bg_link3?>"><strong><a href="report_qc.php?xtype=3&mm=<?=$mm?>&yy1=<?=$yy1?>&process=<?=$process?>">����� C</a></strong></td>
              <td width="62%" bgcolor="#E9E9E9">&nbsp;</td>
            </tr>-->
            <tr>
              <td width="87%" align="left" bgcolor="#E9E9E9"><strong>�ʴ������š���� N 㹡�÷ӧҹ�ѻ�����á <!--����� <? //echo ShowGroup($xtype);?> -->��Ш���͹ <?=$monthFull[intval($txt_mm)]?> <?=$txt_yy?>&nbsp;&nbsp;<!--<a href="report_qc.php?mm=<?=$mm?>&yy1=<?=$yy1?>">����� N</a> || <a href="report_qc_parttime.php?mm=<?=$mm?>&yy1=<?=$yy1?>">parttime</a>--> <? if($site_id > 0){ echo " (".$arrsite[$site_id].")";}?></strong></td>
              <td width="13%" align="left" bgcolor="#E9E9E9"><? if($rsdf[numdiffqc] > 0){  echo " <img src=\"../../../../images_sys/alert.png\" width=\"16\" height=\"16\" title=\"��¡�÷���ҧ���Թ���\" border=\"0\"><b> ��ҧ���Թ��� ".number_format($rsdf[numdiffqc])." �ش</b>";}?>
               </td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="2">
            <tr>
              <td width="5%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>�ӴѺ</strong></td>
              <td width="15%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>���� - ���ʡ��</strong></td>
              <?
			  $percen_dif = 65/count($xarr); // �ӹǹ�����繷�������			  
              foreach($xarr as $k => $v){
				  $xcountv  = count($v);
			  ?>
              <td width="<?=$width_col?>%" align="center" bgcolor="#D4D4D4" colspan="6"><strong><? echo "�ѻ������ $k";?></strong></td>
              <?
			  }
			  ?>
              <td width="5%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>�ѵ����ǹ</strong></td>
              <td width="5%" rowspan="2" align="center" bgcolor="#D4D4D4"><strong>������</strong></td>
            </tr>
            <tr>
            <?
			
            	foreach($xarr as $k1 => $v1){
					$xcount = count($k1);
					$w1 = $percen_dif/6;
					$b = 0;
					$xend = 6;
					for($i = 1 ; $i <= $xend ; $i++){
						if ($b++ %  2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}
						$bg1 = "#D4D4D4";
						$val_day = intval(substr($v1[$i],-2));
						if($val_day == 0){ $bg1 = "#FFFF66"; $show_v = "N";}else{ $bg1 = $bg1; $show_v = $val_day;}
					
			?>
              <td  width="<?=$w1?>%" bgcolor="<?=$bg1?>" align="center"><strong><? if($show_v != "N"){ echo "<a href='?process=perday&yy1=$yy1&mm=$mm&curent_date=$v1[$i]&site_id=$site_id'>$show_v</a>";}else{echo $show_v;}?></strong></td>
              <?
					}//end foreach($v1 as $k2 => $v2){
			}//end foreach($xarr as $k1 => $v1){
				//die;
			  ?>
              </tr>
              <?


			  $sql = "SELECT keystaff.staffid, keystaff.prename, keystaff.staffname, keystaff.staffsurname, keystaff.sapphireoffice,
keystaff.keyin_group FROM keystaff $cong   AND ratio_id='1'   ORDER BY staffname ASC ";	//  AND staffid='10378'
//echo $sql;

			if($curent_date == ""){ // �óջ����żŻѨ�غѹ
				$curent_date = date("Y-d-m");
			}//end if($curent_date == ""){ 
			
			$result = mysql_db_query($db_name,$sql);
			$iii=0;
			while($rs = mysql_fetch_assoc($result)){
				if ($iii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#F0F0F0";}
				####  �红������ temp log ��͹�ӡ�úѹ�֡������
				//if($process == "y"){  // �óշ����꡻����ż���¡��������ҹ��
//					foreach($xarr as $sk => $sv){
//							foreach($sv as $sk1 => $sv1){		
//								SaveStatQc($rs[staffid],$sv1);// �ѹ�֡��� temp	
//							}//end foreach($sv as $sk1 => $sv1){
//					}//end foreach($xarr as $sk => $sv){
				//}else{
//					if($process == "perday"){
//						SaveStatQc($rs[staffid],$curent_date);// �ѹ�֡��� temp	
//					}
				//}//end if($process == "y"){  // �óշ����꡻����ż���¡��������ҹ��

				
//				if($process == "y"){  // �óշ����꡻����ż���¡��������ҹ��
//					foreach($xarr as $sk => $sv){
//							foreach($sv as $sk1 => $sv1){		
								
//								
//							}//end foreach($sv as $sk1 => $sv1){
//					}//end foreach($xarr as $sk => $sv){
//				}//end if($process == "y"){  // �óշ����꡻����ż���¡��������ҹ��
				
				## end  �红������ temp log ��͹�ӡ�úѹ�֡������
				if($rs[keyin_group] == "3"){ // ��͡���� c
					$arr_alert = AlertQC_C($rs[staffid],$xmonth1);	
				}else{
					$arr_alert = AlertQC($rs[staffid],$xmonth1);  /// �ʴ��ѹ������ú�ӹǹ�ش����ͧ QC
				}
				
				
			  ?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$iii?></td>
              <td align="left"><? echo "$rs[prename]$rs[staffname]   $rs[staffsurname]";?></td>
              <?
			  $qc_true = 0;
              foreach($xarr as $k3 => $v3){
				  
				  	$b1 = 0;
					
					$xend = 6;
					for($i = 1 ; $i <= $xend ; $i++){
				
					//	foreach($v3 as $k4 => $v4){
					if ($b1++ %  2){ $bg2 = "#F0F0F0";}else{$bg2 = "#FFFFFF";}	
					$xkey_val = ShowKeyPerson($rs[staffid],$v3[$i]);
					if($arr_alert[$v3[$i]] == "Y"){ $xbg2 = "#009900"; $qc_true++; $all_qc++;}else if($arr_alert[$v3[$i]] == "N" and $xkey_val > 0){ $xbg2 = "#FF3300"; $all_qc++;}else if($arr_alert[$v3[$i]] == ""){ $xbg2 = $bg2;}
						if($v3[$i] == ""){ $xkey_val = 0;}else{ $xkey_val = $xkey_val;}
					
//and $arr_alert[$v3[$i]] == "N"
				
			  ?>
             <td  bgcolor="<?=$xbg2?>" align="center"><?  if($xkey_val > 0 ){echo "<a href='report_qc_detail.php?action=view_detail&staffid=$rs[staffid]&datekey=$v3[$i]' target='_blank'>".$xkey_val."</a>";}else{ echo $xkey_val;}?></td>
                      
              <?
			  $xbg2 = "";
			 	  }//end  for($i = 1 ; $i <= $xend ; $i++){
				  
			  }//end        foreach($xarr as $k3 => $v3){
				 if($xtype != "3"){ // �ó������ ����� C
					$all_qc = count($arr_alert); // �ӹǹ�ش����������ͧ QC
				}//end if($xtype != "3"){

			  ?>
              <td align="center"><? echo $qc_true."/".$all_qc; //echo "�Դ�� ".number_format(($qc_true*100)/$all_qc,2)."%";?></td>
              <td align="center"><? if($all_qc > 0){ echo number_format(($qc_true*100)/$all_qc,2);}?></td>
            </tr>
            <?
			$qc_true = 0;
			$all_qc = 0;
			//$process = "";
			
			}//end 
			
			
			?>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
          </tr>
      </table>
  </td>
    </tr>
  </table>
</body>
</html>
