<?php
session_start();
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090721.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-21 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090721.001
	## Modified Detail :		รายงานตรวจสอบข้อมูล cmss ปทุม
	## Modified Date :		2009-07-21 09:49
	## Modified By :		MR.SUWAT KHAMTUM
############################################################
//echo "<pre>";
//print_r($_SESSION);
//print_r($_GET);die;
if($xtype == "validate"){
		$_SESSION['secid'] = $siteid;
		//echo "siteid :: $siteid<br>";
}
//echo "<pre>";
//print_r($_SESSION);die;
include ("../../libary/function.php");
include("../../../../common/common_competency.inc.php");
include ("../../../../config/phpconfig.php");
include("../../../../common/class-date-format.php");
include ("../timefunc.inc.php");
@include("../../tool_competency/diagnostic/function.inc.php");

//$idcard = "3100602735681"; // รหัสบัตรทดสอบ
//$siteid = "1300";// รหัสพื้นที่ทดสอบ
$db_site = STR_PREFIX_DB."$siteid";
$kp7_active = "1"; //  สถานะในการแสดงผลใน ก.พ.7

$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$monthsname = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");

$xsql = "SELECT * FROM general WHERE idcard='$idcard'";
$xresult = mysql_db_query($db_site,$xsql);
$xrs = mysql_fetch_assoc($xresult);

###  กรณีที่ประวัตการ ชื่อ hr_addhistoryname
$sql_check_hisname = "SELECT COUNT(*) AS num1 FROM hr_addhistoryname  WHERE gen_id='$idcard'";
$result_check_hisname = mysql_db_query($db_site,$sql_check_hisname);
$rs_c_n = mysql_fetch_assoc($result_check_hisname);
	if($rs_c_n[num1] < 1){// กรณีไม่มีข้อมูลใน history ในinsert ข้อมูลเข้าไป
			$sql_insert_n = "INSERT INTO hr_addhistoryname(gen_id,prename_th,name_th,surname_th,daterec,kp7_active,runno)VALUES('$idcard','$xrs[prename_th]','$xrs[name_th]','$xrs[surname_th]','".date("Y-m-d")."','1','1')";
			mysql_db_query($db_site,$sql_insert_n);
	}//end if($rs_c_n[num1] < 1){
##  end กรณีที่ประวัตการ ชื่อ hr_addhistoryname

## ประวัติชื่อบิดา
$sql_check_father = "SELECT COUNT(*) AS num1 FROM hr_addhistoryfathername WHERE gen_id='$idcard'";
$result_check_father = mysql_db_query($db_site,$sql_check_father);
$rs_ch_f = mysql_fetch_assoc($result_check_father);
	if($rs_ch_f[num1] < 1){ // กรณีไม่มีชื่อบิดาในประวัติการเปลี่ยนชื่อ
		$sql_insert_f = "INSERT INTO hr_addhistoryfathername(gen_id,father_prename,father_name,father_surname,father_daterec,kp7_active,runno)VALUES('$idcard','$xrs[father_prename]','$xrs[father_name]','$xrs[father_surname]','".date("Y")."','1','1')";
		mysql_db_query($db_site,$sql_insert_f);
		//echo $sql_insert_f;
	}
#### end ประวัติการเปลี่ยนชื่อบิดา
#######  ประวัติการเปลี่ยนชื่อมารดา
$sql_check_mother = "SELECT COUNT(*) AS num1 FROM hr_addhistorymothername WHERE gen_id='$idcard'";
$result_check_mother = mysql_db_query($db_site,$sql_check_mother);
$rs_ch_m = mysql_fetch_assoc($result_check_mother);
	if($rs_ch_m[num1] < 1){ // กรณีไม่มีชื่อมารดาในประวัติการเปลี่ยนชื่อ
		$sql_insert_m = "INSERT INTO hr_addhistorymothername(gen_id,mother_prename,mother_name,mother_surname,mother_daterec,kp7_active,runno)VALUES('$idcard','$xrs[mother_prename]','$xrs[mother_name]','$xrs[mother_surname]','".date("Y")."','1','1')";
		mysql_db_query($db_site,$sql_insert_m);
		//echo $sql_insert_f;
	}
#### end  ประวัติการเปลี่ยนชื่อมารดา
##########   ประวัติการเปลี่ยนคู่สมรส
$sql_check_marry = "SELECT COUNT(*) AS num1 FROM hr_addhistorymarry  WHERE gen_id='$idcard'";
$result_check_marry = mysql_db_query($db_site,$sql_check_marry);
$rs_ch_m1 = mysql_fetch_assoc($result_check_marry);
	if($rs_ch_m1[num1] < 1){ // กรณีไม่มีชื่อมารดาในประวัติการเปลี่ยนชื่อ
		$sql_insert_m1 = "INSERT INTO hr_addhistorymarry(gen_id,prename_th,name_th,surname_th,daterec,kp7_active,runno)VALUES('$idcard','$xrs[marry_prename]','$xrs[marry_name]','$xrs[marry_surname]','".date("Y")."','1','1')";
		mysql_db_query($db_site,$sql_insert_m1);
		//echo $sql_insert_f;
	}
######## end ประวัติการเปลี่ยนชื่อ คู่สมรส
#### ประวัติการเปลี่ยนที่อยู่
$sql_check_address = "SELECT COUNT(*) AS num1 FROM hr_addhistoryaddress WHERE gen_id='$idcard'";
//echo $sql_check_address;
$result_check_address = mysql_db_query($db_site,$sql_check_address);
$rs_ch_add = mysql_fetch_assoc($result_check_address);
	if($rs_ch_add[num1] < 1){ // กรณีที่ประวัติการเปลี่ยนที่อยู่ไม่
		$sql_insert_a = "INSERT INTO hr_addhistoryaddress(gen_id,address,daterec,kp7_active,runno)VALUES('$idcard','$xrs[contact_add]','".date("Y")."','1','1')";
		//echo $sql_insert_a;
		mysql_db_query($db_site,$sql_insert_a);
	}// end 	if($rs_ch_add[num1] < 1){

// ฟังชั่นก์ แสดงผล วัน เดือน ปี ไทย
function  showthaidate($number){

$digit=array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ');
$num=array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
$number = explode(".",$number);
$c_num[0]=$len=strlen($number[0]);
$c_num[1]=$len2=strlen($number[1]);
$convert='';
if($len > 2){
	$a1 = $len - 1 ;
	$f_digit = substr($number[0],$a1,1);
}
//คิดจำนวนเต็ม
for($n=0;$n< $len;$n++){
	$c_num[0]--;
	$c_digit=substr($number[0],$n,1);
	if($c_num[0]==0&& $c_digit==0)$digit[$c_digit]='';

	if($len>1 && $len <= 2){
		if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='เอ็ด';
	}else if ($len>3){
		if($f_digit == 0){
			if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='หนึ่ง';
		}else{
			if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='เอ็ด';
		}
	}else{
		if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='หนึ่ง';
	}

	if($c_num[0]==0&& $c_digit==2)$digit[$c_digit]='สอง';
	if($c_num[0]==1&& $c_digit==0)$digit[$c_digit]='';
	if($c_num[0]==1&& $c_digit==1)$digit[$c_digit]='';
	if($c_num[0]==1&& $c_digit==2)$digit[$c_digit]='ยี่'; 

	$convert.=$digit[$c_digit];
		if($c_num[0] > 0 && $c_digit != 0 && $c_digit != ""){
			$convert.=$num[$c_num[0]]; 
		}
}
$convert .= "";
if($number[1]==''){$convert .= "";}

//คิดจุดทศนิยม
for($n=0;$n< $len2;$n++){ 
$c_num[1]--;
$c_digit=substr($number[1],$n,1);
if($c_num[1]==0&& $c_digit==1)$digit[$c_digit]='หนึ่ง';
if($c_num[1]==0&& $c_digit==2)$digit[$c_digit]='สอง';
if($c_num[1]==1&& $c_digit==2)$digit[$c_digit]='สอง'; 
if($c_num[1]==1&& $c_digit==1)$digit[$c_digit]='';
$convert.=$digit[$c_digit];
$convert.=$num[$c_num[1]]; 
}
if($number[1]!='')$convert .= "";
return $convert;

} //end function showdate


//function checkID($id) {
//				if(strlen($id) != 13) return false;
//				for($i=0, $sum=0; $i<12;$i++)
//				$sum += (int)($id{$i})*(13-$i);
//				if((11-($sum%11))%10 == (int)($id{12}))
//				return true;
//				return false;
//}

function thai_date($temp_date,$xtype=""){ // function แสดงวันที่
	global $monthname,$monthsname;
	if($temp_date == "" or $temp_date == "0000-00-00"){
			$result_date = "";
	}else{
		$arr_d = explode("-",$temp_date);
		if($xtype == ""){
			$result_date=intval($arr_d[2])." เดือน ".$monthname[intval($arr_d[1])]." พ.ศ.".$arr_d[0];
		}else{
			$result_date=intval($arr_d[2])." ".$monthsname[intval($arr_d[1])]." ".$arr_d[0];
		}
		
	}
	return $result_date;
}

####################################### ข้อมูลส่วนตัว #########################################
$sql_general = "SELECT * FROM general WHERE idcard ='$idcard'";
$result_general = mysql_db_query($db_site,$sql_general);
$rs_general  = mysql_fetch_assoc($result_general);


if($rs_general[contact_tel] != ""){ // เบอร์โทรที่สามารถติดต่อได้
		$xcontact_tel = $rs_general[contact_tel];
}else{
		$xcontact_tel = "-";
}

####################################### end ข้อมูลส่วนตัว #########################################
#####################################  การแสดงชื่อ  #########################################
$sql_name = "SELECT * FROM hr_addhistoryname WHERE gen_id='$idcard' AND kp7_active='$kp7_active'";
$result_name = mysql_db_query($db_site,$sql_name);
$rs_name = mysql_fetch_assoc($result_name);
$num_row_name = @mysql_num_rows($result_name);

	if($num_row_name > 0){
		$fullname = "$rs_name[prename_th]$rs_name[name_th] $rs_name[surname_th]";
	}else{ // ในกรณีที่ไมมีการกำหนดสถานะการแสดงผลใน ก.พ.7
		$sql_nameN = "SELECT * FROM hr_addhistoryname WHERE gen_id='$idcard' ORDER BY runno DESC LIMIT 0,1";
		$result_nameN = mysql_db_query($db_site,$sql_nameN);
		$rs_nameN = mysql_fetch_assoc($result_nameN);
		$fullname = "$rs_name[prename_th]$rs_name[name_th] $rs_name[surname_th]";
	}
#####################################  end การแสดงชื่อ  #########################################
##################################  ทีอยู่ปัจจุบัน ################################################
	$sql_address = "SELECT * FROM hr_addhistoryaddress WHERE gen_id='$idcard' AND kp7_active='$kp7_active'";
	$result_address = mysql_db_query($db_site,$sql_address);
	$rs_address = mysql_fetch_assoc($result_address);
	$num_row_address = @mysql_num_rows($result_address);
		if($num_row_address > 0){
				$address = " บ้านเลขที่ $rs_address[address] โทรศัพท์ $xcontact_tel";
		}else{
				$address = " โทรศัพท์ $xcontact_tel";
		}
################################## end ที่อยู่ปัจจุบัน  ############################################



?>

<html>
<head>

<title>ข้อมูลข้าราชการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<!--<link href="../hr.css" type="text/css" rel="stylesheet">-->
<link href="style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin: 0px  0px;
	padding: 0px  0px;
	margin-top: 5px;
	margin-bottom: 5px;
}
a.pp:link, a.pp:visited, a.pp:active { color: #444444;	
	font-weight:normal;
	text-decoration: none}
a.pp:hover {
	text-decoration: underline;
	color: #444444;
}
.sub_head_td{
border-bottom:#5595CC 1px solid; 
border-top:#5595CC 1px solid;
height:25px;
padding-left:10px;
filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#F4F4F4', EndColorStr='#F4F4F4'); 

}

-->
</style></head>
<body>
<table width="98%" border="0" cellpadding="0" cellspacing="0" align="center" style="border:1px solid #DADAE1;">
<tr>
<td align="center" valign="middle"><h4>
  <br>
  รายการตรวจสอบความถูกต้องการบันทึกข้อมูลทะเบียนประวัติ ก.พ.7</h1></td>
</tr>
</table>
<br>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><font color="#FF0000">หมายเหตุ * สัญญลักษณ์ V[....] คือค่าที่เป็น value ที่ระบบนำไปประมวลผลค่าทางสถิติ</font></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="0" cellspacing="0" align="center" style="border:1px solid #DADAE1;">
  
  <tr>
    <td ><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td align="left"><strong>๑. ข้อมูลทั่วไป</strong></td>
        </tr>
        <?
        $date_bd = explode("-",$rs_general[birthday]); // วันเกิด
		$adsd2=$rs_general[type_dateshow];
		$sqlshow="select type_date,type_nec from type_showdate where id_type='$adsd2' ";
		$qshow=mysql_db_query($db_site,$sqlshow);
		$rsshow1=mysql_fetch_array($qshow);	
		if($rsshow1[type_nec]=="n" ){
		 	$b_birth=$rsshow1[type_date];
		 }else{		
			 if($adsd2 ==341 or $adsd2==351or $adsd2==361 or $adsd2==371){
				$b_day1 = new date_format;
				$year_d=($date_bd[0]-543);
				$b_birth= $b_day1->show_date($rsshow1[type_date],$year_d."-".$date_bd[1]."-".$date_bd[2]);
			 	
				 }else{
				$b_birth=intval($date_bd[2])." เดือน ".$monthname[intval($date_bd[1])]." พ.ศ.".$date_bd[0];
				}
		}	//end if($rsshow1[type_nec]=="n" ){

		
		?>
        
      <tr>
        <td width="86%"  valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td align="left">ชื่อ  : <? echo "$fullname";?>  เกิดวันที่  <? //echo thai_date($rs_general[birthday]); 
			echo $b_birth;
			?></td>
            </tr>

        </table></td>
      </tr>
      <tr>
        <td  valign="top"><strong>๒. ที่อยู่ปัจจุบัน </strong></td>
      </tr>
      <tr>
        <td  valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td align="left">ที่อยู่ปัจจุบัน <?=$address?></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td  valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td  valign="top"><strong>๓. เครื่องราชอิสริยาภรณ์ วันที่ได้รับและวันส่งคืน รวมทั้งเอกสารอ้างอิง</strong></td>
      </tr>
      <tr>
        <td  valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="5%" align="center" bgcolor="#E4EBF3"><strong>ลำดับ</strong></td>
            <td width="18%" align="center" bgcolor="#E4EBF3"><strong>วันที่ได้รับ</strong></td>
            <td width="20%" align="center" bgcolor="#E4EBF3"><strong>เครื่องราชฯ/เหรียญตรา</strong></td>
            <td width="7%" align="center" bgcolor="#E4EBF3"><strong>ลำดับที่</strong></td>
            <td width="10%" align="center" bgcolor="#E4EBF3"><strong>เล่มที่</strong></td>
            <td width="8%" align="center" bgcolor="#E4EBF3"><strong>เล่ม</strong></td>
            <td width="8%" align="center" bgcolor="#E4EBF3"><strong>ตอน</strong></td>
            <td width="6%" align="center" bgcolor="#E4EBF3"><strong>หน้า</strong></td>
            <td width="18%" align="center" bgcolor="#E4EBF3"><strong>ลงวันที่</strong></td>
          </tr>
		  <?
		  	$sql_getroyal = "select * from getroyal where id = '$idcard' and kp7_active='$kp7_active' order by orderid,date asc";
			$result_getroyal = mysql_db_query($db_site,$sql_getroyal);
			$i=0;
			while($rs_getroyal = mysql_fetch_assoc($result_getroyal)){
			if ($bg == "FFFFFF"){  $bg = "D1D1D1"  ; } else {$bg = "FFFFFF" ;}
			$i++;
			
			$date_g = explode("-",$rs_getroyal[date]); // วันที่ได้รับ
			$date_g2 = explode("-",$rs_getroyal[date2]); // ลงวันที่
		if($rs_getroyal[label_date2] !=""){
				$date2=$rs_getroyal[label_date2];
			}else{
			if($rs_getroyal[date2] != " "){
			if($date_g2[2] !=0 and $date_g2[1] !=0 and $date_g2[0] !=0 ){
				$date2 = intval($date_g2[2])." ".$monthsname[intval($date_g2[1])]. " " .$date_g2[0] ;
			}
			else if($date_g2[2]==0 and $date_g2[1]==0  and $date_g2[0]==0 )
			{
			$date2="";
			}
			
			else if($date_g2[2] ==0 and $date_g2[1]==0 )
			{
			$date2=$date_g2[0] ;
			}
			else if($date_g2[2] ==0)
			{
					$date2=$monthsname[intval($date_g2[1])]. " " .$date_g2[0] ;
			}
		}
	}
	
	
	if($rs_getroyal[label_date] !="")
		{
			$date1=trim($rs_getroyal[label_date]);
		}
	else
		{
			if($rs_getroyal[date] !="0-0-0")
			{
				if($rs_getroyal[date] != "0000-00-00"){
				$date1 = intval($date_g[2])." ".$monthsname[intval($date_g[1])]." ".$date_g[0];
				}else{
				$date1 = "";
				}
			}
			else
			{
				$date1="";
			}
		}//END 
###################    แสดงค่า value 
			  	if($rs_getroyal[date] != "" or $rs_getroyal[date2] != ""){
				if($rs_getroyal[date] != ""){  $date_v = "V[ ".thai_date($rs_getroyal[date],"s")." ]"; }else{ $date_v = ""; }
				if($rs_getroyal[date2] != "" and $rs_getroyal[date2] != "0-0-0" and $rs_getroyal[date2] != "0000-00-00"){ $date_v2 = "  V[ ".thai_date($rs_getroyal[date2],"2")." ]";}else{ $date_v2 = "";}
				
				if($rs_getroyal[getroyal_label] != ""){
						$txt_getroyal = $rs_getroyal[getroyal_label];
				}else{
						$txt_getroyal = $rs_getroyal[getroyal];	
				}
				echo "<tr bgcolor=\"$bg\">
            <td align=\"left\"  colspan=\"2\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $date_v</td>
            <td align=\"left\">$txt_getroyal</td>
            <td align=\"center\">$rs_getroyal[no]</td>
            <td align=\"center\">$rs_getroyal[bookno]</td>
            <td align=\"center\">$rs_getroyal[book]</td>
            <td align=\"center\">$rs_getroyal[section]</td>
            <td align=\"center\">$rs_getroyal[page]</td>
            <td align=\"left\"> $date_v2</td>
          </tr>
";
			}
################  end แสดงค่า value
				if($rs_getroyal[getroyal_label] != ""){
						$txt_getroyal = $rs_getroyal[getroyal_label];
				}else{
						$txt_getroyal = $rs_getroyal[getroyal];	
				}

			
			
		  ?>
          <tr bgcolor="<?=$bg?>">
         <td align="center"><?=$i?></td>
            <td align="center"><?=$date1?></td>
            <td align="left"><?=$txt_getroyal?></td>
            <td align="center"><?=$rs_getroyal[no]?></td>
            <td align="center"><?=$rs_getroyal[bookno]?></td>
            <td align="center"><?=$rs_getroyal[book]?></td>
            <td align="center"><?=$rs_getroyal[section]?></td>
            <td align="center"><?=$rs_getroyal[page]?></td>
            <td align="left"><?=$date2?></td>
          </tr>
		  <?
		  	}//end  
		  ?>
        </table></td>
      </tr>
      <tr>
        <td  valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td  valign="top"><strong>๔. จำนวนวันลาหยุดราชการ ขาดราชการ มาสาย</strong></td>
      </tr>
      <tr>
        <td  valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
<!--            <td width="5%" align="center" bgcolor="#E4EBF3">ลำดับ</td>-->
            <td width="15%" align="center" bgcolor="#E4EBF3"><strong>พ.ศ.</strong></td>
            <td width="19%" align="center" bgcolor="#E4EBF3"><strong>ลาป่วย</strong></td>
            <td width="19%" align="center" bgcolor="#E4EBF3"><strong>ลากิจและพักผ่อน</strong></td>
            <td width="13%" align="center" bgcolor="#E4EBF3"><strong>มาสาย</strong></td>
            <td width="16%" align="center" bgcolor="#E4EBF3"><strong>ขาดราชการ</strong></td>
            <td width="18%" align="center" bgcolor="#E4EBF3"><strong>ลาศึกษาต่อ</strong></td>
          </tr>
		  <?
		  		$sql_absent = "SELECT * FROM hr_absent WHERE id='$idcard' ORDER BY yy ASC";
				$result_absent = mysql_db_query($db_site,$sql_absent);
				$i=0;
				while($rs_absent = mysql_fetch_assoc($result_absent)){
					if ($bg == "FFFFFF"){  $bg = "D1D1D1"  ; } else {$bg = "FFFFFF" ;}
					$i++;
					
			if($rs_absent[label_education] !=""){
				$arr_str1 = $rs_absent[label_education];
			}else if($rs_absent[other_absent] !=""){
				$arr_str1 = $rs_absent[other_absent];
			}else if($rs_absent[label_birth] !=""){
				$arr_str1 = $rs_absent[label_birth];
			}else if($rs_absent[etc] !=0){
				$arr_str1 = "ลาพิเศษ ".$rs_absent[etc]." วัน";
			}else if($rs_absent[birth] !=0){
				$arr_str1 = "ลาคลอด ".$rs_absent[birth]." วัน";
			}else if($rs_absent[education] >363){
				$arr_str1 = "ลาศึกษาต่อ";
			}else if($rs_absent[education] <364){
				$arr_str1 = $rs_absent[education];
			}else{
				$arr_str1 = "0";
			}
		#########################
		
		if($rs_absent[label_yy] !=""){//ตรวจสอบการแสดงผลในช่อง ปี
			$str_yy=$rs_absent[label_yy];
			}else{
			$str_yy=$rs_absent[yy];
			}
			//---------------------
			if($rs_absent[label_sick] !=""){// ตรวจสอบการแสดงผลในช่อง ป่วย
			$str_sick=$rs_absent[label_sick];
			}else{
			$str_sick=$rs_absent[sick];
			}
			//---------------
			if($rs_absent[label_dv] !=""){//ตรวจสอบการแสดงผล ลาพิเศษ
			$str_duty=$rs_absent[label_dv];
			}else{
			$str_duty=$rs_absent[duty]+$rs_absent[vacation];
			}
			//----------------
			if($rs_absent[label_late] !=""){// ตรวจสอบการแสดงผล การมาสาย
			$str_late=$rs_absent[label_late];
			}else{
			$str_late=$rs_absent[late];
			}
			//-----------------
			if($rs_absent[label_absent] !=""){
			$str_absent=$rs_absent[label_absent];
			}else{
			$str_absent=$rs_absent[absent];
			}
			//------------------------------------------------------------------------------------------------------------------------------------
			// ทำการแยก สตริง 
			if($rs_absent[label_yy] !=""){
			$arr_year=explode(",",$rs_absent[label_yy]);
			$num_arr_year=count($arr_year);
			}else{
			$arr_year=explode(" ",$rs_absent[yy]);
			$num_arr_year=count($arr_year);
			}
			
			
						  ## กรณีมีการบันทึกข้อมูล label เข้าไปในระบบ
			if($rs_absent[yy] != "" or $rs_absent[sick] != "" or $rs_absent[duty] != "" or $rs_absent[late] != "" or $rs_absent[absent] != "" ) {
				if($rs_absent[yy] != "" and $rs_absent[yy] != "0000-00-00"){ $yy1 = "V[".$rs_absent[yy]."]";}else{ $yy1 = "";}
				$duty1 = $rs_absent[duty]+$rs_absent[vacation];
			
			echo "<tr bgcolor=\"$bg\">
            <td align=\"center\">$yy1</td>
            <td align=\"center\">$rs_absent[sick]</td>
            <td align=\"center\">$duty1</td>
            <td align=\"center\">$rs_absent[late]</td>
            <td align=\"center\">$rs_absent[absent]</td>
            <td align=\"center\">$arr_str1</td>
          </tr>";
			}   // end 		  ## กรณีมีการบันทึกข้อมูล label เข้าไปในระบบ

			
			
		  ?>
          <tr bgcolor="<?=$bg?>">
<!--            <td align="center"><?=$i?></td>
-->       <td align="center"><?=$str_yy?></td>
            <td align="center"><?=$str_sick?></td>
            <td align="center"><?=$str_duty?></td>
            <td align="center"><?=$str_late?></td>
            <td align="center"><?=$str_absent?></td>
            <td align="center" ><?=$arr_str1?></td>
          </tr>
		  <?
		
}// end while(){
		  ?>
        </table></td>
      </tr>
      <tr>
        <td  valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td  valign="top"><strong>๕. ความสามารถพิเศษ </strong></td>
      </tr>
      <tr>
        <td  valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
		<?
		$sql_spacail = "select t1.*,t2.major as majorname,t3.groupname from special t1 left join $dbnamemaster.hr_addmajor t2 on t1.major=t2.runid left join $dbnamemaster.specialgroup t3 on t1.specialgroup=t3.runid where t1.id='$idcard' and t1.kp7_active='$kp7_active' order by t1.runno asc";
		$result_specail = mysql_db_query($db_site,$sql_spacail);
		
		while($rs_specail = mysql_fetch_assoc($result_specail)){
		if ($bg == "FFFFFF"){  $bg = "D1D1D1"  ; } else {$bg = "FFFFFF" ;}
		?>
          <tr bgcolor="<?=$bg?>">
            <td align="left">&nbsp;<?=$rs_specail[detail]?></td>
          </tr>
		  <?
		  	}// end while(){
		  ?>
        </table></td>
      </tr>
      <tr>
        <td  valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="left"  valign="top"><strong>๖. การปฏิบัติการราชการพิเศษ </strong></td>
      </tr>
      <tr>
        <td  valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="15%" align="center" bgcolor="#E4EBF3"><strong>พ.ศ.</strong></td>
            <td width="85%" align="center" bgcolor="#E4EBF3"><strong>รายการ</strong></td>
          </tr>
		  <?
		 $sql_hr1 = "select * from hr_specialduty where id='$idcard' and kp7_type='$kp7_active' order by runid ASC;";
		$result_hr1 = mysql_db_query($db_site,$sql_hr1);
		while($rs_hr1 = mysql_fetch_assoc($result_hr1)){
		if ($bg == "FFFFFF"){  $bg = "D1D1D1"  ; } else {$bg = "FFFFFF" ;}
		  ?>
          <tr bgcolor="<?=$bg?>">
            <td align="center"><?=$rs_hr1[yy]?></td>
            <td align="left"><?=$rs_hr1[comment]?></td>
          </tr>
		  <?
		  	}//end while(){
		  ?>
        </table></td>
      </tr>
      <tr>
        <td  valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="left"  valign="top"><strong>๗.รายการอื่นๆที่จำเป็น </strong></td>
      </tr>
      <tr>
        <td  valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="7%" align="center" bgcolor="#E4EBF3"><strong>ลำดับ</strong></td>
            <td width="93%" align="center" bgcolor="#E4EBF3"><strong>รายการ</strong></td>
          </tr>
		  <?
		 $sql_hr2 = "select * from hr_other where id='$idcard' and kp7_active='$kp7_active' ORDER BY runno asc";
		$result_hr2 = mysql_db_query($db_site,$sql_hr2);
		$i=0;
		while($rs_hr2 = mysql_fetch_assoc($result_hr2)){
		if ($bg == "FFFFFF"){  $bg = "D1D1D1"  ; } else {$bg = "FFFFFF" ;}
		$i++;
		  ?>
          <tr bgcolor="<?=$bg?>">
            <td align="center"><?=$i?></td>
            <td align="left"><?=$rs_hr2[comment]?></td>
          </tr>
		 <?
		 	}// end  while(){
		 ?>
        </table></td>
      </tr>
      <tr>
        <td align="center"  valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="center"  valign="top">&nbsp;</td>
      </tr>
	  <?
	  	$sql = "select t1.*,t2.religion as religionname,t3.blood as bloodgroup from  (general t1 left join $dbnamemaster.hr_religion t2 on t1.region=t2.id) left join $dbnamemaster.hr_blood t3 on t1.blood=t3.id where t1.id='$idcard'  ;";
		//echo $sql;
		$result = mysql_db_query($db_site,$sql);
		$rs=mysql_fetch_array($result);
			$date_d = explode("-",$rs[startdate]); // วันสั่งบรรจุ
			$date_bd = explode("-",$rs[birthday]); // วันเกิด
	
			$retire = retireDate($rs[birthday]);
			
	$sql1="select type_date,type_nec from type_showdate where id_type='$rs[type_dateshow2]' ";
	//echo $sql1;
	$query1=mysql_db_query($db_site,$sql1)or die(mysql_error());
	$rs1=mysql_fetch_array($query1);
	
		if($rs1[type_nec]=="n" ){
		 	$b_birthday=$rs1[type_date];
		 }else{
			$b_showday = new date_format;
			$showbedate= $b_showday->show_date($rssdate[type_date],($date_bg[0]-543)."-".$date_bg[1]."-".$date_bg[2]);
		}
//echo "<br>".$b_showday."<br>";

			$date_bg = explode("-",$rs[begindate]); // วันเริ่มปฎิบัติงาน
			$sql_showbdate="select * from  type_showdate where id_type='$rs[type_showbegindate]' ";
			$q_showbdate=mysql_query($sql_showbdate)or die (mysql_error());
			$rssdate=mysql_fetch_assoc($q_showbdate);
			if($rssdate[type_nec]=="n")
			{
				$showbedate=$rssdate[type_date];
			}
			else
			{
		
		if($rs[begindate_label]){
				$showbedate=$rs[begindate_label];
		}else{
				$b_showday = new date_format;
				$showbedate= $b_showday->show_date($rssdate[type_date],($date_bg[0]-543)."-".$date_bg[1]."-".$date_bg[2]);
		}
			}



$retire =  retireDate($rs[birthday]);

if($rs[label_persontype2now] !=""){
	$str_position=$rs[label_persontype2now];
}else{
	$str_position=$rs[persontype2_now];
}




			// เริ่มต้น ปิดเปิดการแสดงผลคู่สมรส
			$strSQL3=mysql_query("SELECT * FROM hr_addhistorymarry WHERE gen_id='$idcard' AND kp7_active='$kp7_active' order by runno desc");
				$num_row_marry=mysql_num_rows($strSQL3);
					if($num_row_marry != ""){
					$Rs3=mysql_fetch_assoc($strSQL3);
						$marray = "$Rs3[prename_th] $Rs3[name_th] $Rs3[surname_th]";
					}else{
						$marray = "";
					}
				// จบการ ปิดเปิดการแสดงผลคู่สมรส
		



	  ?>
      <tr>
        <td  valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="4%">&nbsp;</td>
            <td width="33%"><strong>๑ ชื่อ</strong> <? echo "$fullname";?></td>
            <td width="5%">&nbsp;</td>
            <td width="26%">๔ <strong>ชื่อคู่สมรส</strong> <? echo "$marray";?> </td>
            <td width="5%">&nbsp;</td>
            <td width="27%"><strong>๗ วันสั่งบรรจุ</strong> <? if($rs_general[startdate_label] != ""){ echo "$rs_general[startdate_label]";}else{echo intval($date_d[2])." ".$monthname[intval($date_d[1])]." ".$date_d[0];}?>
</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="center"><? echo "V[".thai_date($xrs[startdate],"s")."]";?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>๒ <strong>วัน เดือน ปี เกิด</strong>   <?
	explode("-",$rs_general[birthday]);
			$sql1="select type_date,type_nec from type_showdate where id_type='$rs[type_dateshow2]' ";
$query1=mysql_query($sql1)or die(mysql_error());
$rs1=mysql_fetch_array($query1);
			if($rs1[type_nec]=="n" )
		 {
		 	$b_birthday=$rs1[type_date];
		 }
		 else
		 {
		$b_day = new date_format;
		$b_birthday= $b_day->show_date($rs1[type_date],($date_bd[0]-543)."-".$date_bd[1]."-".$date_bd[2]);
		}
		echo $b_birthday; 	
			
			//=thai_date($rs_general[birthday]);?></td>
            <td>&nbsp;</td>
			<?
				// เริ่มต้นปิดเปิด การแสดงผล ชื่อ บิดา
				$strSQL5=mysql_query("SELECT * FROM hr_addhistoryfathername WHERE gen_id='$idcard' AND kp7_active='$kp7_active' order by runno desc");
					$num_row_father=mysql_num_rows($strSQL5);
					if($num_row_father != ""){
						$Rs5=mysql_fetch_assoc($strSQL5);
							$father = "$Rs5[father_prename] $Rs5[father_name] $Rs5[father_surname]";
					}else{
							$father = "";
					}
			//จบ ปิดเปิด การแสดงผล ชื่อ บิดา

			?>
            <td>๕ <strong>ชื่อบิดา</strong>              <?=$father?></td>
            <td>&nbsp;</td>
            <td><strong>๘</strong> <strong>วันเริ่มปฏิบัติราชการ</strong>              <?=$showbedate?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right"><?  if($rs_general[birthday_label] != ""){ echo "( $rs_general[birthday_label] )";}else{echo "( ".showthaidate(intval($date_bd[2]))." ".$monthname[intval($date_bd[1])]." ".showthaidate($date_bd[0])." )";}?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="center"><? echo "V[".thai_date($xrs[begindate],"s")."]";?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><strong>๓ วันครบเกษียณอายุ</strong>&nbsp; <?
            if($rs_general[retire_label] != ""){
				$retire = $rs_general[retire_label];
			}
			echo $retire ;?></td>
            <td>&nbsp;</td>
			<?
				// เริ่มต้นปิดเปิดการแสดงผล ชื่อมารดา
				$strSQL4=mysql_query("SELECT * FROM hr_addhistorymothername WHERE gen_id='$idcard' AND kp7_active='$kp7_active' order by runno desc");
					$num_row_mother=mysql_num_rows($strSQL4);
						if($num_row_mother != ""){
								$Rs4=mysql_fetch_assoc($strSQL4);
								$mother = " $Rs4[mother_prename] $Rs4[mother_name] $Rs4[mother_surname]";	
						}else{
								$mother = "";
						}

			?>
            <td><strong>๖ ชื่อมารดา</strong>              <?=$mother?></td>
            <td>&nbsp;</td>
            <td><strong>๙ ประเภทข้าราชการ</strong>              <?=$str_position?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td  valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="center"  valign="top"><strong>๑๐. ประวัติการศึกษาฝึกอบรมและดูงาน </strong></td>
      </tr>
      <tr>
        <td  valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="32%" align="center" bgcolor="#E4EBF3">สถานที่ฝึกอบรมและดูงาน</td>
            <td width="28%" align="center" bgcolor="#E4EBF3">ตั้งแต่ - ถึง </td>
            <td width="35%" align="center" bgcolor="#E4EBF3">วุฒิที่ได้รับ</td>
          </tr>
		  <?
		$sql = "select * from graduate where id='$idcard' and kp7_active='$kp7_active' order by runno asc;";
		$result = mysql_db_query($db_site,$sql);
		while($rs = mysql_fetch_assoc($result)){
			if ($bg == "FFFFFF"){  $bg = "D1D1D1"  ; } else {$bg = "FFFFFF" ;}
			
			################3
	if($rs[startyear] !="" and $rs[finishyear] !="")
	{
		$showdate1 = "$rs[startyear] "."-"." $rs[finishyear]";
	}
	else if($rs[startyear]=="")
	{
		$showdate1=$rs[finishyear];
	}
	else if($rs[finishyear]=="")
	{
			$showdate1=$rs[startyear];
	}else{
		$showdate1=$rs[year_label];
	}
			
			
			if($rs[place] !=""){
				$place=$rs[place];
				}else{
			$str1="select * from graduate inner join $dbnamemaster.hr_adduniversity on graduate.university_level=hr_adduniversity.u_id where graduate.id='$idcard' and graduate.runid='".$rs[runid]."' and kp7_active='$kp7_active'";
				$Rs1=mysql_query($str1);
				$rs11=mysql_fetch_array($Rs1);
				 $place=$rs11[u_name];
				}
				
	if($rs[grade] !=""){
	$grade=$rs[grade];
	}else{
	$str1="select * from graduate inner join $dbnamemaster.hr_adddegree on graduate.degree_level=hr_adddegree.degree_id where graduate.id='$idcard' and graduate.runid='".$rs[runid]."' and kp7_active='$kp7_active'";
	$Rs1=mysql_query($str1);
	$rs11=mysql_fetch_array($Rs1);
	$grade=$rs11[degree_fullname];
	}
			if($rs[degree_level] !=""){
			$arr_str1 = $grade;
			}else{
			$arr_str1 = $grade;
			}
		
			$arr_str2 = $place;
	
			
			if($rs[year_label]!=""){
				$arr_str3 = $rs[year_label];
			}else{
				$arr_str3 = $showdate1;
			}

			
			#################
			
			
			##############   แสดงค่า value
			if($rs[graduate_level] != "" and $rs[graduate_level] != NULL){
				$sql_grade = "SELECT * FROM hr_addhighgrade WHERE runid='$rs[graduate_level]'";
				$result_grade = mysql_db_query($dbnamemaster,$sql_grade);
				$rs_g = mysql_fetch_assoc($result_grade);
				if($rs_g[highgrade] != ""){ $show_grade = "V[$rs_g[runid] :: $rs_g[highgrade]]"; }else{ $show_grade = "";}
				
				echo " <tr bgcolor=\"$bg\">
            <td align=\"left\" valign=\"top\">&nbsp;</td>
            <td align=\"left\" valign=\"top\">&nbsp;</td>
            <td align=\"left\" valign=\"top\">$show_grade</td>
          </tr>";
				}// end if($rs[graduate_level] != "" and $rs[graduate_level] != NULL){
				###################
				
			if($rs[degree_level] != "" and $rs[degree_level] != NULL){
				$sql_degree = "SELECT * FROM hr_adddegree WHERE degree_id='$rs[degree_level]'";
				$result_grade = mysql_db_query($dbnamemaster,$sql_degree);
				$rs_g1 = mysql_fetch_assoc($result_grade);
				if($rs_g1[degree_id] != ""){  $show_degree = "V2[$rs_g1[degree_id] :: $rs_g1[degree_fullname]]";}else{ $show_degree = "";}
				echo " <tr bgcolor=\"$bg\">
           		 <td align=\"left\" valign=\"top\">&nbsp;</td>
            <td align=\"left\" valign=\"top\">&nbsp;</td>
            <td align=\"left\" valign=\"top\">$show_degree</td>
          </tr>";
			}// end if($rs[degree_level] != "" and $rs[degree_level] != NULL){
		##########  end แสดงค่า value 
			
			
		  ?>
          <tr bgcolor="<?=$bg?>">
            <td align="left" valign="top"><?=$arr_str2?></td>
            <td align="left" valign="top"><?=$arr_str3?></td>
            <td align="left" valign="top"><?=$arr_str1?></td>
          </tr>
		 <?
				
		 	}//end 	while($rs = mysql_fetch_assoc($result)){
		 ?>
        </table></td>
      </tr>
      <tr>
        <td  valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="center"  valign="top"><strong>๑๑. การได้รับโทษทางวินัย </strong></td>
      </tr>
      <tr>
        <td  valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="12%" align="center" bgcolor="#E4EBF3">พ.ศ.</td>
            <td width="61%" align="center" bgcolor="#E4EBF3">รายการ</td>
            <td width="27%" align="center" bgcolor="#E4EBF3">เอกสารอ้างอิง</td>
          </tr>
		 <?
		 $sql = "select * from hr_prohibit where id = '$idcard' and kp7_active='$kp7_active' order by runno asc ";
		// echo $sql;
		$result = mysql_db_query($db_site,$sql);
		while($rs=mysql_fetch_array($result)){
		if ($bg == "FFFFFF"){  $bg = "D1D1D1"  ; } else {$bg = "FFFFFF" ;}
			if($rs[label_yy] !=""){ $yyy=$rs[label_yy];}else{$yyy=$rs[yy];}
			$arr_str1 = $rs[comment];

		 ?>
          <tr bgcolor="<?=$bg?>">
            <td align="center" valign="top"><?=$yyy?></td>
            <td align="left" valign="top"><?=$arr_str1?></td>
            <td align="left" valign="top"><?=$rs[refdoc]?></td>
          </tr>
		 <?
		 }//end while($rs=mysql_fetch_array($result)){
		 ?>
        </table></td>
      </tr>
      <tr>
        <td  valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="center"  valign="top"><strong>๑๒. วันที่ไม่ได้รับเงินเดือนหรือรับเงินเดือนไม่เต็ม </strong></td>
      </tr>
      <tr>
        <td  valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="17%" align="center" bgcolor="#E4EBF3">ตั้งแต่ - ถึง </td>
            <td width="56%" align="center" bgcolor="#E4EBF3">รายการ</td>
            <td width="27%" align="center" bgcolor="#E4EBF3">เอกสารอ้างอิง</td>
          </tr>
		 <?
		 $sql = "select * from hr_nosalary where id = '$idcard' and kp7_active='$kp7_active'; ";
		$result = mysql_db_query($db_site,$sql);
		while($rs = mysql_fetch_assoc($result)){
			if ($bg == "FFFFFF"){  $bg = "D1D1D1"  ; } else {$bg = "FFFFFF" ;}
			$date_f = explode("-",$rs[fromdate]);
			$date_t = explode("-",$rs[todate]);
			
			$arr_str1 = $rs[comment];


		 ?>
          <tr bgcolor="<?=$bg?>">
            <td align="center" valign="top"><? echo " ".intval($date_f[2])." ".$monthsname[intval($date_f[1])]." ".intval($date_f[0])." - ".intval($date_t[2])." ".$monthsname[intval($date_t[1])]." ".intval($date_t[0]);?></td>
            <td align="left" valign="top"><?=$arr_str1?></td>
            <td align="left" valign="top"><?=$rs[refdoc]?></td>
          </tr>
		  <?
		  	}//end while(){
		  ?>
        </table></td>
      </tr>
      <tr>
        <td  valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="center"  valign="top"><strong>๑๓. ตำแหน่งและอัตรางเงินเดือน </strong></td>
      </tr>
      <tr>
        <td  valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="3%" align="center" bgcolor="#E4EBF3">ลำดับ</td>
            <td width="13%" align="center" bgcolor="#E4EBF3">วัน เดือน ปี </td>
            <td width="24%" align="center" bgcolor="#E4EBF3">ตำแหน่ง</td>
    <!--        <td width="11%" align="center" bgcolor="#E4EBF3">ตำแหน่ง[value]</td>-->
            <td width="8%" align="center" bgcolor="#E4EBF3">เลขที่ตำแหน่ง</td>
            <td width="7%" align="center" bgcolor="#E4EBF3">ระดับ</td>
            <td width="14%" align="center" bgcolor="#E4EBF3">อัตราเงินเดือน</td>
            <td width="19%" align="center" bgcolor="#E4EBF3">เอกสารอ้าง</td>
            <td width="12%" align="center" bgcolor="#E4EBF3">อิงประเภทคำสั่ง</td>
          </tr>
		  <?
		  $sql = "select * from salary where id = '$idcard' order by runno asc; ";
		$result = mysql_db_query($db_site,$sql);
		$num_row = mysql_num_rows($result);
			$i=0;
			while($rs=mysql_fetch_array($result)){
			$i++;
			if ($bg == "FFFFFF"){  $bg = "D1D1D1"  ; } else {$bg = "FFFFFF" ;}
		if($rs[label_salary] !="")
			{
			$salaryshow=$rs[label_salary];
			}
		else
			{
			if($rs[salary]==0){
			$salaryshow="";
			}
			else
			{
			$salaryshow=number_format($rs[salary]);
			}
			}
			if($rs[label_radub] !=""){$radub=$rs[label_radub];}
			else{ $radub=$rs[radub];}

			$rs[pls] = str_replace("\r", " ", trim($rs[pls]));
			//เชคคำสั่งว่าง
			if($rs[noorder]=="#")
			{
				$rs[noorder]="";
			}
			else
			{
			$rs[noorder] = trim($rs[noorder]);
			}

			$date_s = explode("-",$rs[date]); // วันที่ วัน เดือน ปี
			
			if($rs[label_date] !="")
			{
			$dateforshow=$rs[label_date];
			}
			else
			{
				if($rs[date]=="")
				{
					$dateforshow="";
				}
				else
				{
				$dateforshow=intval($date_s[2])." ".$monthsname[intval($date_s[1])]." ".$date_s[0];
				}
			}
			
	
			if($rs[instruct]=="#"){
				$txtins = "";
			}else if($rs[instruct]!=""){
				$txtins="$rs[instruct]";
			}else{
				$txtins="ลว.";
			}

	
			//check dateorder__________
			if($rs[label_dateorder] !=""){
				$showdate1 = " $txtins " . $rs[label_dateorder] ;
			}else	{
				if ($rs[dateorder] == ""){
					$showdate1 = "";
				}else{
					$date_o	= explode("-",$rs[dateorder]); // วันที่ ลงวันที่
					$xdate_o = " ".intval($date_o[2])." ".$monthsname[intval($date_o[1])]." ".$date_o[0].'';
					if($xdate_o != ""){$showdate1 = " $txtins " . $xdate_o ; }else{$showdate1 = "";}
				}
			}

			
			 $ext="$rs[noorder]$showdate1";
			
			########################   แสดงค่า value
			if($rs[date] != "" or  $rs[radub] != "" or $rs[salary] != "" or $rs[position]){
			if($rs[date] != "" and $rs[date] != "0000-00-00"){ $show_date1 = "V[". thai_date($rs[date],"s")."]";}else{ $show_date1 = "";}
			if($rs[radub] != "" and $rs[radub] != NULL){ $show_radub = "V[$rs[radub]]";}else{ $show_radub = "";}
			if($rs[salary] != ""){  $show_salary = "V[$rs[salary]]";}else{ $show_salary = "";}
			if($rs[position] != ""){ $show_position = "V[$rs[position]]";}else{ $show_position = "";}
			if($rs[instruct] != ""){ $show_instruct = "V[$rs[instruct]]";}else{ $show_instruct = "";} 
			if($rs[noposition] != ""){ $show_noposition = "V[$rs[noposition]]";}else{ $show_noposition = "";}
			echo "<tr bgcolor=\"$bg\">
            <td align=\"center\"  colspan=\"2\">$show_date1</td>
            <td align=\"left\">$show_position</td>
            <td align=\"left\">$show_noposition</td>
            <td align=\"center\">$show_radub</td>
            <td align=\"right\">$show_salary</td>
			<td align=\"right\">&nbsp;</td>
            <td align=\"left\">$show_instruct</td>
          </tr>";			
		}
		######################################   end  แสดงค่า value 
		  ?>
          <tr bgcolor="<?=$bg?>">
            <td align="center"><?=$i?></td>
            <td align="center"><?=$dateforshow?></td>
            <td align="left"><?=trim($rs[pls])?></td>
        <!--    <td align="left"><?=$rs[position]?></td>-->
            <td align="center"><?=$rs[label_noposition]?></td>
            <td align="center"><?=$radub?></td>
            <td align="right"><?=$salaryshow?>
              &nbsp;</td>
            <td align="center" ><? echo "$rs[noorder] $showdate1";?></td>
            <td align="center"><?
            	$sql_type = "SELECT * FROM hr_order_type WHERE id='$rs[order_type]'";
				$result_type = mysql_db_query($dbnamemaster,$sql_type);
				$rs_type = mysql_fetch_assoc($result_type);
				echo "$rs_type[order_type]";
			
			?></td>
          </tr>
	<?
		}//end while(){ เงินเดือน
	?>
        </table></td>
      </tr>
      <tr>
        <td  valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td  valign="top">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>

