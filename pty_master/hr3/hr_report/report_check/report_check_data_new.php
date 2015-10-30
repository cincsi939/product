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
include("../../../../common/check_label_values/class_chdatenumber_vl.php");
include("../../../../common/class.salarylevel.php");
@include("../../tool_competency/diagnostic/function.inc.php");

$dot = '<font color="#009900">*</font>';
$date_profile_config = '2011-10-01 00:00:00';
$time_assign = time_assign($idcard,$siteid);

//$idcard = "3100602735681"; // รหัสบัตรทดสอบ
//$siteid = "1300";// รหัสพื้นที่ทดสอบ
$db_site = STR_PREFIX_DB."$siteid";
$kp7_active = "1"; //  สถานะในการแสดงผลใน ก.พ.7

$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$monthsname = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");

$xsql = "SELECT * FROM general WHERE idcard='$idcard'";
//echo "idCard:".$idcard;
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

$arr_general = time_stamp_general($staffid,$idcard);
if($rs_general['pivate_key'] == $arr_general[$rs_general['pivate_key']]){
	$new_dot_general = $dot;
}else{
	$new_dot_general = '';
}


if($rs_general[contact_tel] != ""){ // เบอร์โทรที่สามารถติดต่อได้
		$xcontact_tel = $rs_general[contact_tel];
}else{
		$xcontact_tel = "-";
}

####################################### end ข้อมูลส่วนตัว #########################################


#******************************************************** การเป็นสมาชิก กบข. *****************************************************************#

$sql_member=" SELECT edubkk_master.tbl_status_gpf.gpf_detail AS detail FROM edubkk_master.tbl_status_gpf,general WHERE general.status_gpf=edubkk_master.tbl_status_gpf.runid AND  id='$idcard'  ";

$result_member=mysql_db_query($db_site,$sql_member);
			
			while($rs_member = mysql_fetch_assoc($result_member))
			{
					$user_member=$rs_member['detail']." กบข.";
			}
#******************************************************** END การเป็นสมาชิก กบข. *****************************************************************#



#******************************************************** การแสดงรูปภาพ *****************************************************************#
$imgHead="../../../../images_sys/krut.jpg";
$imgUser="../../../../../edubkk_image_file/".$siteid."/";

$user_pic=array();
$user_yy=array();

$arr_general_pic = time_stamp_general_pic($staffid,$idcard);

$sql_img="SELECT imgname,yy FROM  general_pic WHERE id='$idcard'  and kp7_active=1 order by yy asc";
$result_img=mysql_db_query($db_site,$sql_img);
//$rs_img = mysql_fetch_assoc($result_img);
		while($rs_img = mysql_fetch_assoc($result_img))
			{
				if($rs_img['imgname'] == $arr_general_pic[$rs_img['imgname']]){
					$new_dot_general_pic = $dot;
				}else{
					$new_dot_general_pic = '';
				}
				//receiv  image path
			     $img=$imgUser.$rs_img['imgname'];
				array_push($user_pic, $img);
		        //receive year image
				$year=$rs_img['yy'];
				if($year==0){$year="ไม่ระบุ";	}
				array_push($user_yy, $year);
			}
#******************************************************** end การแสดงรูปภาพ ********************************************************#


#####################################  การแสดงชื่อ  #########################################
$sql_name = "SELECT * FROM hr_addhistoryname WHERE gen_id='$idcard' AND kp7_active='$kp7_active'";
$result_name = mysql_db_query($db_site,$sql_name);
$rs_name = mysql_fetch_assoc($result_name);
$num_row_name = @mysql_num_rows($result_name);
//echo "kp7_active:".$kp7_active;
$arr_addhistoryname = time_stamp_addhistoryname($staffid,$idcard);
if($rs_name['runid'] == $arr_addhistoryname[$rs_name['runid']]){
	$new_dot_addhistoryname = $dot;
}else{
	$new_dot_addhistoryname = '';
}
	if($num_row_name > 0){
		$fullname = "$rs_name[prename_th]$rs_name[name_th] $rs_name[surname_th]".$new_dot_addhistoryname;
	//	echo "name:".$fullname;
	}else{ // ในกรณีที่ไมมีการกำหนดสถานะการแสดงผลใน ก.พ.7
		$sql_nameN = "SELECT * FROM hr_addhistoryname WHERE gen_id='$idcard' ORDER BY runno DESC LIMIT 0,1";
		$result_nameN = mysql_db_query($db_site,$sql_nameN);
		$rs_nameN = mysql_fetch_assoc($result_nameN);
		$fullname = "$rs_name[prename_th]$rs_name[name_th] $rs_name[surname_th]".$new_dot_addhistoryname;
	}
	
	 
	 #*************************  การแสดงชื่อในอดีต   *************************#
	   $name_older_arr=array();
	   $sql_older_name=" SELECT prename_th,name_th,surname_th FROM hr_addhistoryname WHERE gen_id='$idcard'  AND kp7_active<>'$kp7_active' Order BY runno DESC ; " ;
	    $result_older_name = mysql_db_query($db_site,$sql_older_name);
		while ($rs_older_name = mysql_fetch_assoc($result_older_name))
		 {
			 $olderNameStr=$rs_older_name['prename_th'].$rs_older_name['name_th']."  ".$rs_older_name['surname_th'];
		      array_push($name_older_arr,$olderNameStr );
		}
   #************************* end การแสดงชื่อในอดีต   *************************#

#####################################  end การแสดงชื่อ  #########################################



##################################  ทีอยู่ปัจจุบัน ################################################
	$sql_address = "SELECT * FROM hr_addhistoryaddress WHERE gen_id='$idcard' AND kp7_active='$kp7_active'";
	$result_address = mysql_db_query($db_site,$sql_address);
	$rs_address = mysql_fetch_assoc($result_address);
	$num_row_address = @mysql_num_rows($result_address);
	$arr_address = time_stamp_address($staffid,$idcard);
	if($rs_address['runid'] == $arr_address[$rs_address['runid']]){
		$new_dot_address = $dot;
	}else{
		$new_dot_address = '';
	}
		if($num_row_address > 0){
				$address = " บ้านเลขที่ $rs_address[address] โทรศัพท์ $xcontact_tel".$new_dot_address;
		}else{
				$address = " โทรศัพท์ $xcontact_tel".$new_dot_address;
		}
	//ที่อยู่ในอดีต
	//$sql_hr_address = "SELECT * FROM hr_addhistoryaddress WHERE gen_id='$idcard' AND kp7_active='$kp7_active'";
	//$result_address = mysql_db_query($db_site,$sql_address);
	//$rs_address = mysql_fetch_assoc($result_address);
	//$num_row_address = @mysql_num_rows($result_address);
	################################## end ที่อยู่ปัจจุบัน  ############################################

 	#*************************  การแสดงที่อยู่ในอดีต   *************************#
	   $address_older_arr=array();
	   $sql_older_address=" SELECT address FROM hr_addhistoryaddress WHERE gen_id='$idcard' AND kp7_active<>'$kp7_active' Order BY runno DESC ";
	    $result_older_address = mysql_db_query($db_site,$sql_older_address);
		while ($rs_older_address = mysql_fetch_assoc($result_older_address))
		 {
			 array_push($address_older_arr,$rs_older_address['address'] );
		 }
		#************************* end การแสดงที่อยู่ในอดีต   *************************#
		
		
	function GetPositionNow(){
		global $dbnamemaster;
		$sql = "SELECT
t1.`position`,
t1.pid
FROM
hr_addposition_now AS t1
where t1.status_active='yes'";	
		$result = mysql_db_query($dbnamemaster,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arr[$rs[pid]] = $rs[position];
		}//end 
		return $arr;
	}// end function GetPositionNow(){
		
	function GetLevelNow(){
		global $dbnamemaster;
		$sql = "SELECT
t1.level_id,
t1.radub
FROM
hr_addradub AS t1
where t1.active_now='1'";	
			$result = mysql_db_query($dbnamemaster,$sql);
			while($rs = mysql_fetch_assoc($result)){
					$arr[$rs[level_id]] = $rs[radub];
			}
			return $arr;
	}//end function GetLevelNow(){




$chvl=new CheckVL(); 
$r=new salary_level();
$arr_pn = GetPositionNow(); // ข้อมูลตำแหน่งตั้งแต่ปี 47 เป็นต้นไป
$arr_lv = GetLevelNow(); // ระดับตั้งแต่ปี 47


?>

<html>
<head>

<title>ข้อมูลข้าราชการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<!--<link href="../hr.css" type="text/css" rel="stylesheet">-->
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../jquery.js"></script> 
<script>
var imgDir_path="../../../../common/popup_calenda/images/calendar/";
</script>

<script src="../../../../common/check_label_values/script.js" type="text/javascript"></script>
<script type="text/javascript" src="../../../../common/check_label_values/calendar_list.js"></script>
<script>



/*
	echo "<input name=\"salary\" type=\"hidden\" id=\"salary\" value=\"$rs[salary]\"> <span id=\"check_salary\"></span>";
			echo "<input type=\"hidden\" name=\"label_salary\" id=\"label_salary\" value=\"2555\">
           <input  type=\"hidden\" name=\"chk_salary\"  id=\"chk_salary\" value=\"true\">";


$(document).ready(function() {
	path="../../../../common/check_label_values/";
	check_true='<img src="'+path+'images/checked.gif" width="18" height="18" />';
	check_false='<img src="'+path+'images/unchecked.gif" width="18" height="18" />';
	

	
	$('#salary').after("<span id='msg_salary' class='span_check'></span>").load(function(){check_values_label($(this).attr('id'),'label_salary','values','number',"chk_salary");});
	$('#label_salary').after("<span id='msg_label_salary' class='span_check'></span>").load(function(){check_values_label($(this).attr('id'),'salary','label','number',"chk_salary");});
	
});
*/</script>
  <style>p { color:red; }</style>
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
#member
{
	font-family:"Times New Roman";
	font-size:18px;
	color:red;
} 
#edu_status
{
	font-family:"Times New Roman";
	font-size:14px;
	color:red;
} 
#special_status
{
	font-family:"Times New Roman";
	font-size:16px;
	color:red;
} 


-->
</style></head>
<body>
<table width="98%" border="0" cellpadding="0" cellspacing="0" align="center" style="border:1px solid #DADAE1;">

<tr>
	<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" align="left" >
				<tr>
					<td colspan="8" align="center" valign="middle"><h4>รายการตรวจสอบความถูกต้องการบันทึกข้อมูลทะเบียนประวัติ ก.พ.7</h4></td>
				</tr>
        		<tr>
    				 <td width="14%" align="left">&nbsp;</td>
    	 	 		<td width="14%">&nbsp;</td>
       				<td width="14%">&nbsp;</td>
    				<td width="14%"> <center><?   printf("<img src='$imgHead'  alt='$imgHead '  width='96' height='108'> "  );    ?></center></td>
     				<td width="14%">&nbsp;</td>
    				<td  colspan="2"  width="24%" align="center"><p id=member><? echo $user_member ?></p></td>
       		<!-- <td  width="14%" align="left"> <p id=member><?echo $user_member ?></p></td> ->  --> 
        		</tr>
        	</table>
	</td>
</tr>
			
<tr>
	<td>
      <table width="98%"  border="1" bordercolor="#CCCCCC"  cellspacing="0" cellpadding="3" align="center"  style="border:1px solid #DADAE1;">
 	  <tr>
    		 	<td width="14%"  height="160" align="left" ><?  if(count($user_pic) >=1)  {echo " <center><img src='$user_pic[0]'  width='120' height ='160' alt='$user_pic[0]'  /></center>  ";   } $new_dot_general_pic?></td>
    			<td  width="14%" height="160" > <?  if(count($user_pic) >=2)  {echo " <center><img src='$user_pic[1]'  width='120' height ='160' alt='$user_pic[1]'  />  </center>";   } $new_dot_general_pic?></td>
    			<td width="14%" height="160" ><?  if(count($user_pic) >=3)  {echo "<center><img src='$user_pic[2]'  width='120' height ='160'   alt='$user_pic[2]'  />  </center> ";   } $new_dot_general_pic?></td>
    			<td width="14%" height="160" ><?  if(count($user_pic) >=4)  {echo "  <center><img src='$user_pic[3]'  width='120' height ='160'  alt='$user_pic[3]'  /> </center> ";   } $new_dot_general_pic?></td>
    			<td width="14%" height="160" ><?  if(count($user_pic) >=5)  {echo "  <center><img src='$user_pic[4]'  width='120' height ='160'   alt='$user_pic[4]'  /></center>  ";   } $new_dot_general_pic?></td>
    			<td width="14%" height="160" ><?  if(count($user_pic) >=6)  {echo "  <center><img src='$user_pic[5]'  width='120' height ='160'  alt='$user_pic[5]'  /></center>   ";   } $new_dot_general_pic?></td>
    			<td width="14%" height="160"><?  if(count($user_pic) >=7)  {echo " <center><img src='$user_pic[6]'  width='120' height ='160'  alt='$user_pic[6]'  /> </center> ";   } $new_dot_general_pic?></td>
  	   	</tr>
      	<tr>
 			  <td height="49" align="center">รูปที่ ๑<p>พ.ศ.<?   if(count($user_pic) >=1)   {    echo $user_yy[0] ; }  ?></td>
    		  <td height="49" align="center">รูปที่ ๒<p>พ.ศ.<?   if(count($user_pic) >=2)   {    echo $user_yy[1] ; }    ?></td>
    	 	  <td height="49" align="center">รูปที่ ๓<p>พ.ศ.<?   if(count($user_pic) >=3)   {    echo $user_yy[2] ; }     ?></td>
    		  <td height="49" align="center">รูปที่ ๔<p>พ.ศ.<?   if(count($user_pic) >=4)   {    echo $user_yy[3] ; }    ?></td>
    		 <td height="49" align="center">รูปที่ ๕<p>พ.ศ.<? if(count($user_pic) >=5)   {    echo $user_yy[4] ; }    ?></td>
    	     <td height="49" align="center">รูปที่ ๖<p>พ.ศ.<? if(count($user_pic) >=6)   {    echo $user_yy[5] ; }    ?></td>
    	     <td height="49" align="center">รูปที่ ๗<p>พ.ศ.<? if(count($user_pic) >=7)   {    echo $user_yy[6] ; }    ?></td>
        </tr>
    </table>
    </td>
</tr>

<tr>
 <td>
 		<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
 		<tr>
   					 <td><font color="#FF0000">หมายเหตุ * สัญญลักษณ์ V[....] คือค่าที่เป็น value ที่ระบบนำไปประมวลผลค่าทางสถิติ</font></td>
  		</tr>
		</table>
	</td>
</tr>
 
  <tr>
  <td ><table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td align="left"><table width="98%" border="0" cellpadding="0" cellspacing="0" align="center" style="border:1px solid #DADAE1;">
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
                  <td align="left">ชื่อ  : <? echo "$fullname";    for($i=0;$i<count($name_older_arr);$i++) {  echo " "."(".$name_older_arr[$i].")";     }   ?> เกิดวันที่
                    <? //echo thai_date($rs_general[birthday]); 
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
                  <td align="left">ที่อยู่ปัจจุบัน <? echo "$address"; for($i=0;$i<count($address_older_arr);$i++) { echo " "."(".$address_older_arr[$i].")";  }  ?></td>
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
				$arr_getroyal = time_stamp_getroyal($staffid,$idcard);
			
		  	$sql_getroyal = "select * from getroyal where id = '$idcard' and kp7_active='$kp7_active' order by orderid,date asc";
			$result_getroyal = mysql_db_query($db_site,$sql_getroyal);
			$i=0;
			while($rs_getroyal = mysql_fetch_assoc($result_getroyal)){
				
				if($rs_getroyal['runid'] == $arr_getroyal[$rs_getroyal['runid']]){
					$new_dot_getroyal = $dot;
				
				}else{
					$new_dot_getroyal='';
				}
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
            <td align=\"left\">".$date_v2.$new_dot_getroyal."</td>
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
                  <td align="left"><?=$date2.$new_dot_getroyal?></td>
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
				
				$arr_absent = time_stamp_absent($staffid,$idcard);
				
		  		$sql_absent = "SELECT * FROM hr_absent WHERE id='$idcard' ORDER BY yy ASC";
				$result_absent = mysql_db_query($db_site,$sql_absent);
				$i=0;
				while($rs_absent = mysql_fetch_assoc($result_absent)){
					
					if($rs_absent['yy'] == $arr_absent[$rs_absent['yy']]){
						$new_dot_absent = $dot;
					}else{
						$new_dot_absent = '';
					}
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
            <td align=\"center\">".$arr_str1.$new_dot_absent."</td>
          </tr>";
			}   // end 		  ## กรณีมีการบันทึกข้อมูล label เข้าไปในระบบ

			
			
		  ?>
                <tr bgcolor="<?=$bg?>">
                  <!--            <td align="center"><?=$i?></td>
-->
                  <td align="center"><?=$str_yy?></td>
                  <td align="center"><?=$str_sick?></td>
                  <td align="center"><?=$str_duty?></td>
                  <td align="center"><?=$str_late?></td>
                  <td align="center"><?=$str_absent?></td>
                  <td align="center" ><?=$arr_str1.$new_dot_absent?></td>
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
		$arr_special = time_stamp_special($staffid,$idcard);
		
		$sql_spacail = "select t1.*,t2.major as majorname,t3.groupname from special t1 left join $dbnamemaster.hr_addmajor t2 on t1.major=t2.runid left join $dbnamemaster.specialgroup t3 on t1.specialgroup=t3.runid where t1.id='$idcard' and t1.kp7_active='$kp7_active' order by t1.runno asc";
		$result_specail = mysql_db_query($db_site,$sql_spacail);
		
		while($rs_specail = mysql_fetch_assoc($result_specail)){
			if($rs_specail['runid'] == $arr_special[$rs_specail['runid']]){
				
				$new_dot_special = $dot;
			}else{
				$new_dot_special= '';
			}
		if ($bg == "FFFFFF"){  $bg = "D1D1D1"  ; } else {$bg = "FFFFFF" ;}
		?>
                <tr bgcolor="<?=$bg?>">
                  <td align="left">&nbsp;
                    <?=$rs_specail[detail].$new_dot_special?></td>
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
				$arr_specialduty = time_stamp_specialduty($staffid,$idcard);
		// $sql_hr1 = "select * from hr_specialduty where id='$idcard' and kp7_type='$kp7_active' order by runid ASC;";
		$sql_hr1 = "select * from hr_specialduty where id='$idcard'  order by runid ASC;";
		$result_hr1 = mysql_db_query($db_site,$sql_hr1);
	   while($rs_hr1 = mysql_fetch_assoc($result_hr1)){
		   if($rs_hr1['no'] == $arr_specialduty[$rs_hr1['no']]){
				
				$new_dot_specialduty = $dot;
			}else{
				$new_dot_specialduty= '';
			}
		  #**************************การแสดงผลใน กพ.7**************************************#
		if($rs_hr1[kp7_type]==1){   $special_txt="(แสดงผลใน กพ.7)";}
		else{ $special_txt="(ไม่แสดงผลใน กพ.7)";}
		  #*************************END การแสดงผลใน กพ.7 ***************************************#
		
		if ($bg == "FFFFFF"){  $bg = "D1D1D1"  ; } else {$bg = "FFFFFF" ;}
		  ?>
                <tr bgcolor="<?=$bg?>">
                  <td align="center"><?=$rs_hr1[yy]?></td>
                  <td align="left"><?=$rs_hr1[comment].$new_dot_specialduty?>
                    <p id=special_status>
                      <?  echo $special_txt   ?>
                      </p></td>
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
					
			$arr_addhistorymarry = time_stamp_addhistorymarry($staffid,$idcard);
			if($Rs3['runid'] == $arr_addhistorymarry[$Rs3['runid']]){
				$new_dot_addhistorymarry = $dot;
			}else{
				$new_dot_addhistorymarry = '';
			}
						$marray = "$Rs3[prename_th] $Rs3[name_th] $Rs3[surname_th]".$new_dot_addhistorymarry;
					}else{
						$marray = "";
					}
				// จบการ ปิดเปิดการแสดงผลคู่สมรส
		      
			  #*************************  การแสดงชื่ออดีตคู่สมรส   *************************#
	    $m_name_older=array();
	   $sql_marry_name=" SELECT prename_th,name_th,surname_th FROM hr_addhistorymarry WHERE gen_id='$idcard'  AND kp7_active<>'$kp7_active'  Order BY runno DESC ; " ;
	  $result_marry_name = mysql_db_query($db_site,$sql_marry_name);
      while ($rs_marry_name = mysql_fetch_array($result_marry_name))
		 {
		    $m_nameStr=$rs_marry_name['prename_th'].$rs_marry_name['name_th']."  ".$rs_marry_name['surname_th'];
		   array_push($m_name_older,$m_nameStr );
		}
   #*************************END การแสดงชื่ออดีตคู่สมรส   *************************#
     		
         ?>
            <tr>
              <td  valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tr>
                  <td width="4%">&nbsp;</td>
                  <td width="33%"><strong>๑ ชื่อ</strong> <? echo "$fullname";?></td>
                  <td width="5%">&nbsp;</td>
                  <td width="26%">๔ <strong>ชื่อคู่สมรส</strong> <? echo "$marray";   for($i=0;$i<count($m_name_older); $i++){  $str= "  (".$m_name_older[$i].")" ; echo $str;
			 } ?></td>
                  <td width="5%">&nbsp;</td>
                  <td width="27%"><strong>๗ วันสั่งบรรจุ</strong>
                    <? 
					if($rs_general[startdate_label] != ""){ echo "$rs_general[startdate_label]".$new_dot_general;}else{echo intval($date_d[2])." ".$monthname[intval($date_d[1])]." ".$date_d[0].$new_dot_generale;}
					
					?></td>
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
                  <td>๒ <strong>วัน เดือน ปี เกิด</strong>
                    <?
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
		echo $b_birthday.$new_dot_general; 	
			
			//=thai_date($rs_general[birthday]);?></td>
                  <td>&nbsp;</td>
                  <?
				// เริ่มต้นปิดเปิด การแสดงผล ชื่อ บิดา
				$strSQL5=mysql_query("SELECT * FROM hr_addhistoryfathername WHERE gen_id='$idcard' AND kp7_active='$kp7_active' order by runno desc");
					$num_row_father=mysql_num_rows($strSQL5);
					if($num_row_father != ""){
						$Rs5=mysql_fetch_assoc($strSQL5);
						
						$arr_addhistoryfathername = time_stamp_addhistoryfathername($staffid,$idcard);
						if($Rs5['runid'] == $arr_addhistoryfathername[$Rs5['runid']]){
							$new_dot_addhistoryfathername = $dot;
						}else{
							$new_dot_addhistoryfathername = '';
						}
							$father = "$Rs5[father_prename] $Rs5[father_name] $Rs5[father_surname]".$new_dot_addhistoryfathername;
					}else{
							$father = "".$new_dot_addhistoryfathername;
					}
			//จบ ปิดเปิด การแสดงผล ชื่อ บิดา

			?>
                  <td>๕ <strong>ชื่อบิดา</strong>
                    <?=$father?></td>
                  <td>&nbsp;</td>
                  <td><strong>๘</strong> <strong>วันเริ่มปฏิบัติราชการ</strong>
                    <?=$showbedate.$new_dot_general?></td>
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
                  <td><strong>๓ วันครบเกษียณอายุ</strong>&nbsp;
                    <?
            if($rs_general[retire_label] != ""){
				$retire = $rs_general[retire_label];
			}
			echo $retire.$new_dot_general ;?></td>
                  <td>&nbsp;</td>
                  <?
				// เริ่มต้นปิดเปิดการแสดงผล ชื่อมารดา
				$strSQL4=mysql_query("SELECT * FROM hr_addhistorymothername WHERE gen_id='$idcard' AND kp7_active='$kp7_active' order by runno desc");
					$num_row_mother=mysql_num_rows($strSQL4);
						if($num_row_mother != ""){
								$Rs4=mysql_fetch_assoc($strSQL4);
								
						$arr_addhistorymothername = time_stamp_addhistorymothername($staffid,$idcard);
						if($Rs4['runid'] == $arr_addhistorymothername[$Rs4['runid']]){
							$new_dot_addhistorymothername = $dot;
						}else{
							$new_dot_addhistorymothername = '';
						}
						
								$mother = " $Rs4[mother_prename] $Rs4[mother_name] $Rs4[mother_surname]".$new_dot_addhistorymothername;	
						}else{
								$mother = "".$new_dot_addhistorymothername;
						}

			?>
                  <td><strong>๖ ชื่อมารดา</strong>
                    <?=$mother?></td>
                  <td>&nbsp;</td>
                  <td><strong>๙ ประเภทข้าราชการ</strong>
                    <?=$str_position.$new_dot_general?></td>
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
                  <td width="28%" align="left" bgcolor="#E4EBF3">ตั้งแต่ - ถึง </td>
                  <td width="35%" align="center" bgcolor="#E4EBF3">วุฒิที่ได้รับ</td>
                </tr>
                <?
		

		#****************************แสดงค่าบอกประเภทว่า เป็นการศึกษาหรืออบรมและดูงาน********************************#
		$arr_graduate = time_stamp_graduate($staffid,$idcard);
	    $sql_edu="   SELECT runid as run_id,runno as run_no,place as place ,startyear as s_year,finishyear as e_year,year_label as la_year,grade as grade, kp7_active
as at_kp7,type_graduate as g_type,'0' as study_type, degree_level as degree_level ,graduate_level  as g_level,major_level as m_level FROM graduate    
 	WHERE id = '$idcard' UNION
SELECT runid as run_id,runno as run_no,place as place,startdate as s_year,enddate as e_year,'',subject as grade ,kp7_active as at_kp7,'','1' as study_type ,'','',''
FROM seminar    WHERE id = '$idcard' AND kp7_active='$kp7_active'  order by  run_no ASC" ;
      $result_edu = mysql_db_query($db_site,$sql_edu);
	    	while ($rs= mysql_fetch_assoc($result_edu))
		{
			if($rs['run_id'] == $arr_graduate[$rs['run_id']]){
				$new_dot_graduate = $dot;
			}else{
				$new_dot_graduate = '';
			}
						   if ($bg == "FFFFFF"){  $bg = "D1D1D1"  ; } else {$bg = "FFFFFF" ;}
							
							if($rs[s_year] !="" and $rs[e_year] !="")
							{
									$showdate1 = "$rs[s_year] "."-"." $rs[e_year]";
							}
							else if($rs[s_year]=="")
							{
									$showdate1=$rs[e_year];
							}
							else if($rs[e_year]=="")
							{
									$showdate1=$rs[s_year];
							}else{
								$showdate1=$rs[la_year];
							}
					
								if($rs[place] !=""){$place=$rs[place];}
								else
								{
										$str1="select * from graduate inner join $dbnamemaster.hr_adduniversity on graduate.university_level=hr_adduniversity.u_id where graduate.id='$idcard' and graduate.runid='".$rs[run_id]."' and kp7_active='$kp7_active'";
										$Rs1=mysql_query($str1);
										$rs11=mysql_fetch_array($Rs1);
				 						$place=$rs11[u_name];
								}
								
										if($rs[grade] !="")
										{
												$grade=$rs[grade];
										}
										else
										{
													$str1="select * from graduate inner join $dbnamemaster.hr_adddegree on graduate.degree_level=hr_adddegree.degree_id where graduate.id='$idcard' and graduate.runid='".$rs[runid]."' and kp7_active='$kp7_active'";
													$Rs1=mysql_query($str1);
													$rs11=mysql_fetch_array($Rs1);
													$grade=$rs11[degree_fullname];
										}
								
										if($rs[degree_level] !=""){ $arr_str1 = $grade;}
										else{$arr_str1 = $grade;}
										$arr_str2 = $place;
										 
										 if($rs[la_year]!=""){$arr_str3 = $rs[la_year];}
										 else{$arr_str3 = $showdate1;}
										
										if( $rs[study_type]==0)
										{
											$study_detail="(ประวัติการศึกษา)";
										}
									    else
										{
											$study_detail="(ฝึกอบรมและดูงาน)";
										}
											##############   แสดงค่า value
										if($rs[g_level] != "" and $rs[g_level] != NULL)
										{
										$sql_grade = "SELECT * FROM hr_addhighgrade WHERE runid='$rs[g_level]'";
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
									
									if($rs[degree_level] != "" and $rs[degree_level] != NULL)
									{
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
									
									
								if($rs[m_level] != ""){
										$sql_mj = "SELECT major,major_id FROM `hr_addmajor` WHERE `major_id` LIKE '$rs[m_level]' ";
										$result_mj = mysql_db_query($dbnamemaster,$sql_mj) or die(mysql_error()."".__LINE__);
										$rsmj = mysql_fetch_assoc($result_mj);
										if($rsmj[major] != ""){
												$show_major = "V3[$rsmj[major_id] :: $rsmj[major]]";
										}else{
												$show_major = "";
										}//end if($rsmj[major] != ""){
											
											echo " <tr bgcolor=\"$bg\">
           		 						<td align=\"left\" valign=\"top\">&nbsp;</td>
            							<td align=\"left\" valign=\"top\">&nbsp;</td>
            							<td align=\"left\" valign=\"top\">$show_major</td>
          								</tr>";
								}
								
								
			
								?>
                <tr bgcolor="<?=$bg?>">
                  <td align="left" valign="top"><?=$arr_str2  ?></td>
                  <td align="left" valign="top"><?=$arr_str3  ?></td>
                  <td align="left" valign="top"><?=$arr_str1.$new_dot_graduate ?>
                    <p id='edu_status' > <? echo  "  ".$study_detail   ?></p></td>
                </tr>
                  <?
								}//end 	while($rs = mysql_fetch_assoc($result)){
		 						 #****************************END แสดงค่าบอกประเภทว่า เป็นการศึกษาหรืออบรมและดูงาน********************************#
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
			$arr_prohibit = time_stamp_prohibit($staffid,$idcard);
			
		
		 $sql = "select * from hr_prohibit where id = '$idcard' and kp7_active='$kp7_active' order by runno asc ";
		// echo $sql;
		$result = mysql_db_query($db_site,$sql);
		while($rs=mysql_fetch_array($result)){
		if ($bg == "FFFFFF"){  $bg = "D1D1D1"  ; } else {$bg = "FFFFFF" ;}
			if($rs[label_yy] !=""){ $yyy=$rs[label_yy];}else{$yyy=$rs[yy];}
			$arr_str1 = $rs[comment];
			if($arr_nosalary[$rs['no']] == $rs['no']){
				$new_dot_prohibit = $dot;
			}else{
				$new_dot_prohibit = '';
			}	

		 ?>
                <tr bgcolor="<?=$bg?>">
                  <td align="center" valign="top"><?=$yyy?></td>
                  <td align="left" valign="top"><?=$arr_str1?></td>
                  <td align="left" valign="top"><?=$rs[refdoc].$new_dot_prohibit?></td>
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
		$arr_nosalary = time_stamp_nosalary($staffid,$idcard);
		
		
		 $sql = "select * from hr_nosalary where id = '$idcard' and kp7_active='$kp7_active'; ";
		$result = mysql_db_query($db_site,$sql);
		while($rs = mysql_fetch_assoc($result)){
			if ($bg == "FFFFFF"){  $bg = "D1D1D1"  ; } else {$bg = "FFFFFF" ;}
			$date_f = explode("-",$rs[fromdate]);
			$date_t = explode("-",$rs[todate]);
			
			$arr_str1 = $rs[comment];
			
		if($arr_nosalary[$rs['no']] == $rs['no']){
				$new_dot_nnosalary = $dot;
			}else{
				$new_dot_nnosalary = '';
			}	
		 ?>
                <tr bgcolor="<?=$bg?>">
                  <td align="center" valign="top"><? echo " ".intval($date_f[2])." ".$monthsname[intval($date_f[1])]." ".intval($date_f[0])." - ".intval($date_t[2])." ".$monthsname[intval($date_t[1])]." ".intval($date_t[0]);?></td>
                  <td align="left" valign="top"><?=$arr_str1?></td>
                  <td align="left" valign="top"><?=$rs[refdoc].$new_dot_nnosalary ?></td>
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
		//$staffid = '11238';
		$arr_salary = time_stamp_salary($staffid,$idcard);
		

		
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
			if($arr_salary[$rs['runid']] == $rs['runid']){
				$new_dot = $dot;
			}else{
				$new_dot = '';
			}			
			
			echo "<tr bgcolor=\"$bg\">
            <td align=\"center\"  colspan=\"2\">$show_date1</td>
            <td align=\"left\">$show_position</td>
            <td align=\"left\">$show_noposition</td>
            <td align=\"center\">$show_radub</td>
            <td align=\"right\">$show_salary</td>
			<td align=\"right\">&nbsp;</td>
            <td align=\"left\">".$show_instruct."</td>
          </tr>";			
		}
		######################################   end  แสดงค่า value  ###########################
			## ตรวจสอบข้อมูลในกลุ่ม 38 คน
			$sub_pid = substr($rs[position_id],0,1);
			if($sub_pid == "5" or $sub_pid == "6"){
					$date_conw = "2552";
			}else{
					$date_conw = "2547";	
			}
			
			if(trim($rs[label_date]) != ""){
					$check_datevl = $chvl->CheckValueLabel($rs[date],$rs[label_date],"date");	
					if($check_datevl == "0"){
							$alert_date = "<img src=\"../../../../images_sys/alert.png\" width=\"15\" height=\"15\" border=\"0\">";
					}else{
							$alert_date = "";
					}// end if($check_datevl == "0"){
			}//end $rs[label_date]
				
				$arr_date = explode("-",$rs[date]);
				if($arr_date[0] > $date_conw){
					$date_salary = ($arr_date[0]-543)."-".$arr_date[1]."-".$arr_date[2];
					$x=$r->check("$rs[radub]","$rs[salary]","$date_salary");
					if($x == ""){
						$alert_salary = "<img src=\"../../../../images_sys/alert_icon.png\" width=\"15\" height=\"15\" border=\"0\">";	
					}else{
						$alert_salary = "";
					}
				}else{
					$alert_salary = "";	
				}
				
				if($arr_date[0] > $date_conw){
						if($arr_pn[$rs[position_id]] == ""){
							$alert_position = "<img src=\"../../../../images_sys/alert_icon.png\" width=\"15\" height=\"15\" border=\"0\">";
						}else{
							$alert_position = "";
						}
						if($arr_lv[$rs[level_id]] == ""){
							$alert_radub = "<img src=\"../../../../images_sys/alert_icon.png\" width=\"15\" height=\"15\" border=\"0\">";
						}else{
							$alert_radub = "";
						}
						
				}else{
						$alert_position = "";	
						$alert_radub = "";
				}
			
		
		  ?>
         
                <tr bgcolor="<?=$bg?>">
                  <td align="center"><?=$i?></td>
                  <td align="center"><?=$dateforshow?> &nbsp;&nbsp;<?=$alert_date?></td>
                  <td align="left"><?=trim($rs[pls])?>&nbsp;&nbsp;<?=$alert_position?></td>
                  <!--    <td align="left"><?=$rs[position]?></td>-->
                  <td align="center"><?=$rs[label_noposition]?></td>
                  <td align="center"><?=$radub?>&nbsp;&nbsp;<?=$alert_radub?></td>
                  <td align="right"><?=$salaryshow?>
                    &nbsp;&nbsp;<?=$alert_salary?></td>
                  <td align="center" ><? echo "$rs[noorder] $showdate1";?></td>
                  <td align="center"><?
            	$sql_type = "SELECT * FROM hr_order_type WHERE id='$rs[order_type]'";
				$result_type = mysql_db_query($dbnamemaster,$sql_type);
				$rs_type = mysql_fetch_assoc($result_type);
				echo "".$rs_type[order_type].$new_dot."";
			
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
              <td  valign="top">หมายเหตุ :&nbsp; <img src="../../../../images_sys/alert.png" width="16" height="16" border="0"> คือข้อมูล วันที่ label ไม่ตรงกับ value<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img src="../../../../images_sys/alert_icon.png" width="16" height="16" border="0"> คือข้อมูลเงินเดือนไม่ตรงตามผัง ตำแหน่งและระดับไม่ใช่ข้อมูลปัจจุบัน<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $dot;?>&nbsp; คือข้อมูลใหม่ที่ทำการบันทึก
</td>
              </tr>
            </table></td>
          </tr>
        </table>        <strong></strong></td>
    </tr>
  </table></td>
</tr>
</table>
</body>
</html>
<?php 
function time_assign($idcard,$siteid){
	$sql="
		select update_time from tbl_assign_key
		where idcard = '".$idcard."' and siteid = '".$siteid."';
	";
	$rs = mysql_db_query(DB_USERENTRY,$sql);
	$row = mysql_fetch_assoc($rs);
	//echo $sql;
	return $row['update_time'];
}
function get_dot($working,$time_assign){
	global $dot;
	if($working >= $time_assign){ 
		$new_ass = $dot; }
	else{ $new_ass = '';}
	
	return $new_ass;
}
function time_stamp_salary($staffid,$idcard){
	
	global $db_site;
	global $date_profile_config;
	$arr = array();
	$sql="
		SELECT
		t1.id,
		t1.runno,
		t1.runid,
		t1.`date`,
		t1.`position`,
		t1.position_id,
		t1.noposition,
		t1.updatetime,
		t2.staffid
		FROM
		salary AS t1
		Inner Join salary_log_after AS t2 ON t1.runid = t2.runid
		WHERE
		t2.staffid='".$staffid."' and t1.id='".$idcard."' AND t2.updatetime > '".$date_profile_config."'
		group by t1.id, t1.runno
	";
	$rs = mysql_db_query($db_site,$sql);
	while($row = mysql_fetch_assoc($rs)){
	
		$arr[$row['runid']] = $row['runid'];	
	}
	//echo $sql;
	return $arr;
}
function time_stamp_nosalary($staffid,$idcard){
	
	global $db_site;
	global $date_profile_config;
	$arr = array();
	$sql="
		SELECT hr_nosalary.no
		FROM hr_nosalary INNER JOIN hr_nosalary_log_after ON hr_nosalary.no = hr_nosalary_log_after.no
		
		WHERE
		hr_nosalary_log_after.staffid='".$staffid."' and hr_nosalary.id='".$idcard."' AND hr_nosalary_log_after.updatetime > '".$date_profile_config."'
		GROUP BY hr_nosalary.no
	";
	$rs = mysql_db_query($db_site,$sql);
	while($row = mysql_fetch_assoc($rs)){
	
		$arr[$row['no']] = $row['no'];	
	}
	//echo $sql;
	return $arr;
}
function time_stamp_prohibit($staffid,$idcard){
	
	global $db_site;
	global $date_profile_config;
	$arr = array();
	$sql="
		SELECT 
			hr_prohibit.no
		FROM hr_prohibit INNER JOIN hr_prohibit_log_after ON hr_prohibit.no = hr_prohibit_log_after.no
		WHERE hr_prohibit_log_after.staffid='".$staffid."' and hr_prohibit.id='".$idcard."' AND hr_prohibit_log_after.updatetime > '".$date_profile_config."'
		GROUP BY hr_nosalary.no
	";
	$rs = mysql_db_query($db_site,$sql);
	while($row = mysql_fetch_assoc($rs)){
	
		$arr[$row['no']] = $row['no'];	
	}
	//echo $sql;
	return $arr;
}
function time_stamp_addhistoryname($staffid,$idcard){
	
	global $db_site;
	global $date_profile_config;
	$arr = array();
	$sql="
		SELECT hr_addhistoryname.runid
		FROM hr_addhistoryname INNER JOIN hr_addhistoryname_log_after ON hr_addhistoryname.runid = hr_addhistoryname_log_after.runid
		WHERE hr_addhistoryname_log_after.staffid = '".$staffid."' AND hr_addhistoryname.gen_id = '".$idcard."' AND hr_addhistoryname_log_after.updatetime > '".$date_profile_config."'
		group by hr_addhistoryname.gen_id
	";
	$rs = mysql_db_query($db_site,$sql);
	while($row = mysql_fetch_assoc($rs)){
	
		$arr[$row['runid']] = $row['runid'];	
	}
	//echo $sql;
	return $arr;
}
function time_stamp_address($staffid,$idcard){
	
	global $db_site;
	global $date_profile_config;
	$arr = array();
	$sql="
		SELECT 
			hr_addhistoryaddress.runid
		FROM hr_addhistoryaddress INNER JOIN hr_addhistoryaddress_log_after ON hr_addhistoryaddress.runid = hr_addhistoryaddress_log_after.runid
		WHERE hr_addhistoryaddress_log_after.staffid = '".$staffid."' AND hr_addhistoryaddress.gen_id = '".$idcard."' AND hr_addhistoryaddress_log_after.updatetime > '".$date_profile_config."'
		group by hr_addhistoryaddress.gen_id
	";
	$rs = mysql_db_query($db_site,$sql);
	while($row = mysql_fetch_assoc($rs)){
	
		$arr[$row['runid']] = $row['runid'];	
	}
	//echo $sql;
	return $arr;
}


function time_stamp_getroyal($staffid,$idcard){
	
	global $db_site;
	global $date_profile_config;
	$arr = array();
	$sql="
		SELECT getroyal.runid
		FROM getroyal INNER JOIN getroyal_log_after ON getroyal.runid = getroyal_log_after.runid
		WHERE getroyal_log_after.staffid = '".$staffid."' AND getroyal_log_after.id = '".$idcard."' AND getroyal_log_after.updatetime > '".$date_profile_config."'
		group by getroyal_log_after.id
	";
	$rs = mysql_db_query($db_site,$sql);
	while($row = mysql_fetch_assoc($rs)){
	
		$arr[$row['runid']] = $row['runid'];	
	}
	//echo $sql;
	return $arr;
}
function time_stamp_absent($staffid,$idcard){
	
	global $db_site;
	global $date_profile_config;
	$arr = array();
	$sql="
		SELECT  
			hr_absent.id, 
			hr_absent.yy
		FROM hr_absent INNER JOIN hr_absent_log_after ON hr_absent.id = hr_absent_log_after.id AND hr_absent.yy = hr_absent_log_after.yy
		WHERE hr_absent_log_after.staffid = '".$staffid."' AND hr_absent.id = '".$idcard."' AND hr_absent_log_after.updatetime > '".$date_profile_config."'
		group by hr_absent.yy,hr_absent.id
	";
	$rs = mysql_db_query($db_site,$sql);
	while($row = mysql_fetch_assoc($rs)){
	
		$arr[$row['yy']] = $row['yy'];	
	}
	//echo $sql; group by hr_absent.id
	return $arr;
}
function time_stamp_special($staffid,$idcard){
	
	global $db_site;
	global $date_profile_config;
	$arr = array();
	$sql="
		SELECT 
			special.runid
		FROM special INNER JOIN special_log_after ON special.runid = special_log_after.runid
		WHERE special_log_after.staffid = '".$staffid."' AND special.id = '".$idcard."' AND special_log_after.updatetime > '".$date_profile_config."'
		group by special.id
	";
	$rs = mysql_db_query($db_site,$sql);
	while($row = mysql_fetch_assoc($rs)){
	
		$arr[$row['runid']] = $row['runid'];	
	}
	//echo $sql;
	return $arr;
}
function time_stamp_specialduty($staffid,$idcard){
	
	global $db_site;
	global $date_profile_config;
	$arr = array();
	$sql="
		SELECT 
			hr_specialduty.no, 
			hr_specialduty_log_after.staffid, 
			hr_specialduty.id
		FROM hr_specialduty INNER JOIN hr_specialduty_log_after ON hr_specialduty.no = hr_specialduty_log_after.no
		WHERE hr_specialduty_log_after.staffid = '".$staffid."' AND hr_specialduty.id = '".$idcard."' AND hr_specialduty_log_after.updatetime > '".$date_profile_config."'
		GROUP BY hr_specialduty.id
	";
	$rs = mysql_db_query($db_site,$sql);
	while($row = mysql_fetch_assoc($rs)){
	
		$arr[$row['no']] = $row['no'];	
	}
	//echo $sql;
	return $arr;
}
function time_stamp_addhistorymarry($staffid,$idcard){
	global $db_site;
	global $date_profile_config;
	$arr = array();
	$sql="
		SELECT 
			hr_addhistorymarry.runid
		FROM hr_addhistorymarry INNER JOIN hr_addhistorymarry_log_after ON hr_addhistorymarry.runid = hr_addhistorymarry_log_after.runid
		WHERE hr_addhistorymarry_log_after.staffid = '".$staffid."' AND hr_addhistorymarry.gen_id = '".$idcard."' AND hr_addhistorymarry_log_after.updatetime > '".$date_profile_config."'
		group by hr_addhistorymarry.gen_id
	";
	$rs = mysql_db_query($db_site,$sql);
	while($row = mysql_fetch_assoc($rs)){
	
		$arr[$row['runid']] = $row['runid'];	
	}
	return $arr;
}
function time_stamp_general($staffid,$idcard){
	global $db_site;
	global $date_profile_config;
	$arr = array();
	$sql="
		SELECT 
			general.pivate_key
		FROM general INNER JOIN general_log_after ON general.id = general_log_after.id
		WHERE general_log_after.staffid = '".$staffid."' AND general.id = '".$idcard."' AND general_log_after.updatetime > '".$date_profile_config."'
		group by general.pivate_key
	";
	$rs = mysql_db_query($db_site,$sql);
	while($row = mysql_fetch_assoc($rs)){
	
		$arr[$row['id']] = $row['id'];	
	}
	return $arr;
}
function time_stamp_addhistoryfathername($staffid,$idcard){
	global $db_site;
	global $date_profile_config;
	$arr = array();
	$sql="
		SELECT 
			hr_addhistoryfathername.runid
		FROM hr_addhistoryfathername INNER JOIN hr_addhistoryfathername_log_after ON hr_addhistoryfathername.runid = hr_addhistoryfathername_log_after.runid
		WHERE hr_addhistoryfathername_log_after.staffid = '".$staffid."' AND hr_addhistoryfathername.gen_id = '".$idcard."' AND hr_addhistoryfathername_log_after.updatetime > '".$date_profile_config."'
	";
	$rs = mysql_db_query($db_site,$sql);
	while($row = mysql_fetch_assoc($rs)){
	
		$arr[$row['runid']] = $row['runid'];	
	}
	return $arr;
}
function time_stamp_addhistorymothername($staffid,$idcard){
	global $db_site;
	global $date_profile_config;
	$arr = array();
	$sql="
		SELECT
			hr_addhistorymothername.runid
		FROM hr_addhistorymothername INNER JOIN hr_addhistorymothername_log_after ON hr_addhistorymothername.runid = hr_addhistorymothername_log_after.runid
		WHERE hr_addhistorymothername_log_after.staffid = '".$staffid."' AND hr_addhistorymothername.gen_id = '".$idcard."' AND hr_addhistorymothername_log_after.updatetime > '".$date_profile_config."'
		GROUP BY hr_addhistorymothername.gen_id
	";
	$rs = mysql_db_query($db_site,$sql);
	while($row = mysql_fetch_assoc($rs)){
	
		$arr[$row['runid']] = $row['runid'];	
	}
	return $arr;
}
function time_stamp_graduate($staffid,$idcard){
	global $db_site;
	global $date_profile_config;
	$arr = array();
	$sql="
		SELECT graduate_log_after.staffid, 
			graduate.runid, 
			graduate_log_after.id
		FROM graduate INNER JOIN graduate_log_after ON graduate.runid = graduate_log_after.runid
		WHERE graduate_log_after.staffid = '".$staffid."' AND graduate.id = '".$idcard."' AND graduate_log_after.updatetime > '".$date_profile_config."'
		GROUP BY graduate.runno
	";
	$rs = mysql_db_query($db_site,$sql);
	while($row = mysql_fetch_assoc($rs)){
	
		$arr[$row['runid']] = $row['runid'];	
	}
	return $arr;
}
function time_stamp_general_pic($staffid,$idcard){
	global $db_site;
	global $date_profile_config;
	$arr = array();
	$sql="
		SELECT 
			general_pic.imgname
		FROM general_pic INNER JOIN general_pic_log_after ON general_pic.id = general_pic_log_after.id
		WHERE general_pic_log_after.staffid = '".$staffid."' AND general_pic.id = '".$idcard."' AND general_pic_log_after.updatetime > '".$date_profile_config."'
		group by general_pic.no
	";
	$rs = mysql_db_query($db_site,$sql);
	while($row = mysql_fetch_assoc($rs)){
	
		$arr[$row['imgname']] = $row['imgname'];	
	}
	return $arr;
}
?>

