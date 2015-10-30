<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_req_notApprove";
$module_code 		= "req_notApprove"; 
$process_id			= "req_notApprove";
$VERSION 				= "9.1";
$BypassAPP 			= true;
#########################################################
#Developer 	:: 
#DateCreate	::17/07/2007
#LastUpdate	::17/07/2007
#DatabaseTabel::
#END
#########################################################
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();

if($_SERVER['REQUEST_METHOD'] == "POST"){

//Check bday and IdCard of Personnel
	$sql 		= "select id, idcard, birthday, unit from general where idcard='$idcard' and id='$id';";
	$result 	= mysql_query($sql)or die("Line". __LINE__ .mysql_error());
if(mysql_num_rows($result) >= 1){
	while ($rs=mysql_fetch_assoc($result)){	
	
		$yy 			= substr($rs[birthday],0,4);
		$mm			= substr($rs[birthday],5,2);
		$dd 			= substr($rs[birthday],8,2);
		$birthday 	= "$dd$mm$yy";


	}
	mysql_free_result($result);
} else {

}	


}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>ระบบยืนยันข้อมูล</title>


<style type="text/css">
body,td{
	font-family:tahoma;
	font-size:13px;
}
.header_text{
	font-size:16px;

}
.fill_bg
{	vertical-align: top;
	padding: 0pt;
	background-color:#F8F8F8;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#F8F8F8', EndColorStr='#ffffff');
}
<!--
-->
</style>
<link href="../libary/style.css" rel="stylesheet" type="text/css" />
</head>
<?  /*
chki1			note_i1
chki2			note_i2
chki3			note_i3
chki4			note_i4
chki5			note_i5
chki6			note_i6
chki7			note_i7
chki8			note_i8
chki9			note_i9
chki10			note_i10
chki11			note_i11
chki12			note_i12
chki13			note_i13


*/  ?>
<SCRIPT language=JavaScript>
function checkFields() {
	missinginfo1 = "";
	missinginfo = "";
if((post.chki1.checked== false)&&(post.chki2.checked== false) &&(post.chki3.checked== false)&&(post.chki4.checked== false)&&(post.chki5.checked== false )&&(post.chki6.checked== false )&&(post.chki7.checked== false )&&(post.chki8.checked== false )&&(post.chki9.checked== false )&&(post.chki10.checked== false )&&(post.chki11.checked== false )&&(post.chki12.checked== false )&&(post.chki13.checked== false ))
{ missinginfo1 += "\n - กรุณาระบุ หมวดที่ต้องการเปลี่ยนแปลงข้อมูล";  }	
 	if((post.chki1.checked== true )&& (post.note_i1.value=="")) { missinginfo1 += "\n - กรุณาระบุหมายเหตุ ข้อมูลทั่วไป";  }	
 	if((post.chki2.checked== true )&& (post.note_i2.value=="")) { missinginfo1 += "\n - กรุณาระบุหมายเหตุ การศึกษา ";  }	
 	if((post.chki3.checked== true )&& (post.note_i3.value=="")) { missinginfo1 += "\n - กรุณาระบุหมายเหตุ การขึ้นเงินเดือน ";  }	
 	if((post.chki4.checked== true )&& (post.note_i4.value=="")) { missinginfo1 += "\n - กรุณาระบุหมายเหตุ อบรม/ดูงาน/สัมนา ";  }	
 	if((post.chki5.checked== true )&& (post.note_i5.value=="")) { missinginfo1 += "\n - กรุณาระบุหมายเหตุ ผลงานทางวิชาการ ";  }	
 	if((post.chki6.checked== true )&& (post.note_i6.value=="")) { missinginfo1 += "\n - กรุณาระบุหมายเหตุ เครื่องราช ฯ ";  }	
	if((post.chki7.checked== true )&& (post.note_i7.value=="")) { missinginfo1 += "\n - กรุณาระบุหมายเหตุ ความรู้ความสามารถพิเศษ ";  }	
 	if((post.chki8.checked== true )&& (post.note_i8.value=="")) { missinginfo1 += "\n - กรุณาระบุหมายเหตุ รายการความดีความชอบ ";  }	
 	if((post.chki9.checked== true )&& (post.note_i9.value=="")) { missinginfo1 += "\n - กรุณาระบุหมายเหตุ จำนวนวันลาหยุดราชการ ";  }		
	if((post.chki10.checked== true )&& (post.note_i10.value=="")) { missinginfo1 += "\n - กรุณาระบุหมายเหตุ วันที่ไม่ได้รับเงินเดือนหรือ ได้รับเงินเดือนไม่เต็มจำนวน   ";  }	
	if((post.chki11.checked== true )&& (post.note_i11.value=="")) { missinginfo1 += "\n - กรุณาระบุหมายเหตุ การได้รับโทษทางวินัย ";  }	
	if((post.chki12.checked== true )&& (post.note_i12.value=="")) { missinginfo1 += "\n - กรุณาระบุหมายเหตุ การปฏิบัติราชการพิเศษ ";  }	
	if((post.chki13.checked== true )&& (post.note_i13.value=="")) { missinginfo1 += "\n - กรุณาระบุหมายเหตุ  รายการอื่น ๆ ที่จำเป็น ";  }	
	
	
	if (missinginfo1 != "") { 
		missinginfo += "ไม่สามารถเพิ่มข้อมูลได้ เนื่องจาก \n";
		missinginfo +="_____________________________\n";
		missinginfo = missinginfo + missinginfo1  ;
		missinginfo += "\n_____________________________";
		missinginfo += "\nกรุณาตรวจสอบ อีกครั้ง";
		alert(missinginfo);
		return false;
		}
	}
</SCRIPT>
<body topmargin="0" leftmargin="0">
<?
if ($id == ""){ echo " <center>Not exist id value</center> "; die; } 
?>
<?
if ($Submit != ""){ 
$timestamp 	= date("Y-m-d H:i:s");
$ip				= get_real_ip();
$networkip = $_SERVER["REMOTE_ADDR"] ; 
if ($chki1 ==""){ $note_i1 =""; }  	if ($chki2 ==""){ $note_i2 =""; } 	if ($chki3 ==""){ $note_i3 =""; } 
if ($chki4 ==""){ $note_i4 =""; }  	if ($chki5 ==""){ $note_i5 =""; } 	if ($chki6 ==""){ $note_i6 =""; } 
if ($chki7 ==""){ $note_i7 =""; }  	if ($chki8 ==""){ $note_i8 =""; } 	if ($chki9 ==""){ $note_i9 =""; } 
if ($chki10 ==""){ $note_i10 =""; }  	if ($chki11 ==""){ $note_i11 =""; } 	
if ($chki12 ==""){ $note_i12 =""; } 	if ($chki13 ==""){ $note_i13 =""; }  	

# update สถานะ ของ log_req_notapprove ให้เป็น 0 ก่อน การขอแก้ไขข้อมูล 
$strSQL_update_status = "UPDATE `log_req_notapprove` SET `status`='0' WHERE general_id='$id' ";
$result_update = mysql_query($strSQL_update_status);



$sql = " INSERT INTO `log_req_notapprove`  (  " ; 
$sql .= " `general_id`,`status`,`userip`,networkip, `timestamp`,`i1_general`,`i1_general_notes`,`i2_graduate`,`i2_graduate_notes`,  " ; 
$sql .= " `i3_salary`,`i3_salary_notes`,`i4_seminar`,`i4_seminar_notes`,`i5_sheet`,`i5_sheet_notes`,  " ; 
$sql .= " `i6_getroyal`,`i6_getroyal_notes`,`i7_special`,`i7_special_notes`,`i8_goodman`,`i8_goodman_notes`,  " ; 
$sql .= " `i9_absent`,`i9_absent_notes`, `i10_nosalary`,`i10_nosalary_notes`,`i11_prohibit`,`i11_prohibit_notes`,  " ; 
$sql .= " `i12_specialduty`,`i12_specialduty_notes`,`i13_other`,`i13_other_notes`) VALUES (  " ; 
$sql .= "  '$id', 1, '$ip', '$networkip' , '$timestamp', '$chki1', '$note_i1', '$chki2', '$note_i2'  " ; 
$sql .= " , '$chki3', '$note_i3', '$chki4', '$note_i4', '$chki5', '$note_i5'  " ; 
$sql .= " , '$chki6', '$note_i6', '$chki7', '$note_i7', '$chki8', '$note_i8'  " ; 
$sql .= " , '$chki9', '$note_i9', '$chki10', '$note_i10', '$chki11', '$note_i11'  " ; 
$sql .= " , '$chki12', '$note_i12', '$chki13', '$note_i13');  " ; 

$result = mysql_query($sql) ;
echo  mysql_error() ; 
$sql = " UPDATE `general` SET `req_notapprove`='1' WHERE (`id`='$id')   " ; 
$result = mysql_query($sql) ;

//@10/8/2550
//$sql  = "update temp_listapprove  set  approve = approve - 1 , not_approve = not_approve + 1     where id ='$unit' ;";  // ถ้าเพิ่มคน ลบ คน 
	$sql  = " replace into temp_listapprove (ampid,id,th_name,approve,not_approve,outside,status_sch) select `t1`.`ampid` AS `ampid`, ";
	$sql  .= " `t1`.`id` AS `id`,`t1`.`office` AS `th_name`,sum(if((`t2`.`approve_status` = _tis620'approve'),1,0)) AS `approve`, ";
	$sql  .= " sum(if((((`t2`.`approve_status` = _tis620'') or isnull(`t2`.`approve_status`)) and (`t2`.`id` is not null)),1,0)) AS `not_approve`, ";
	$sql  .= " sum(if((`t2`.`outside` = _utf8'1'),1,0)) AS `outside`,`t1`.`status_sch` AS `status_sch` from (`login` `t1` left join ";
	$sql  .= "`general` `t2` on((`t1`.`id` = `t2`.`unit`))) where `t2`.`unit`='$unit'  group by `t1`.`ampid`,`t1`.`id`;";  // recalculate
	$result = mysql_query($sql) ;

// echo "  <script language=\"JavaScript\">  alert(\"บันทึกคำร้องเสร็จสิ้น\") ;   </script> ";	
echo "  <script language=\"JavaScript\">  alert(\"บันทึกคำร้องเสร็จสิ้น\") ;window.close();   </script> ";	
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right" bgcolor="#4752A3"><img src="../images/hr-banner.gif" width="780" height="40" /></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="10" cellspacing="0" class="fill_bg">
<tr align="center">
    <td height="200"   >
<form action="<?=$PHP_SELF?>?id=<?=$id?>" method="post" name="post"  id="post" target="_self"  onSubmit="return checkFields()"  >	
<input type="hidden" name="general_id" value="<?=$id?>" />
<?
$sql = " SELECT siteid,`general`.`prename_th`, `general`.`name_th`, `general`.`surname_th`, "; 
$sql .= " `general`.`idcard`, `general`.`birthday`,  `general`.`position_now`  , subminis_now "; 
$sql .= " FROM `general`   where id = $id "; 
$result = mysql_query($sql);
$rs = mysql_fetch_assoc($result) ; 

?>
<table width="96%" border="0" cellspacing="0" cellpadding="3" style="border: #8D99C4 1px solid">
  <tr>
    <td class="login_fill2"><table width="100%"  border="0" cellpadding="1" cellspacing="1">
      <tr>
        <td colspan="3" align="center"><span class="header_text"><b>ท่านต้องการที่จะแจ้งความจำนงการปรับปรุงข้อมูล<br />
ทะเบียนประวัติข้าราชการ</b><strong>(ก.พ.7)</strong></span></td>
        </tr>
      <tr>
        <td width="23%" rowspan="5" align="center" valign="middle"><?  

$personal_img = "../../../../image_file/$rs[siteid]/". $id .".jpg" ; 
if (is_file($personal_img)){

	echo  " <img src='".  $personal_img  ."'  width='120' height='160' />" ; 	
}else{ ?>
<img src='../../../images_sys/noimage.jpg' />
<?  }  ?>
  </td>
        <td width="19%" align="right"><strong>ชื่อ นามสกุล : </strong></td>
        <td width="58%" align="left">&nbsp;
              <?=$rs[prename_th]?>
              <?=$rs[name_th]?>
              <?=$rs[surname_th]?>        </td>
      </tr>
      <tr>
        <td align="right"><strong>ตำแหน่ง : </strong></td>
        <td align="left">&nbsp;
              <?
if ($rs[position_now]==""){ echo "-"; }else{ echo $rs[position_now] ; } 
?></td>
      </tr>
      <tr>
        <td align="right"><strong>หน่วยงาน : </strong></td>
        <td align="left">&nbsp;
              <?
if ($rs[subminis_now]==""){ echo "-"; }else{ echo $rs[subminis_now] ; } 
?></td>
      </tr>
      <tr>
        <td align="right"><strong>เลขบัตรประจำตัวประชาชน : </strong></td>
        <td align="left">&nbsp;
              <?=$rs[idcard]?></td>
      </tr>
      <tr>
        <td align="right"> <strong>วันที่ยื่นคำร้อง&nbsp;:</strong> </td>
        <td align="left">&nbsp;
              <?  
	function find_month($num_month){
			$num_month  = (int)$num_month ;
			switch ($num_month) {
				case "01":					$num_month =  1; 					break;
				case "1":						$num_month =  1; 					break;
				case "02":					$num_month =  2;					break;
				case "2":						$num_month =  2;					break;
				case "03":					$num_month =  3;					break;		
				case "3":						$num_month =  3;					break;		
				case "04":					$num_month =  4; 					break;
				case "4":						$num_month =  4; 					break;
				case "05":					$num_month =  5;					break;
				case "5":						$num_month =  5;					break;
				case "06":					$num_month =  6;					break;		
				case "6":						$num_month =  6;					break;		
				case "07":					$num_month =  7; 					break;
				case "7":						$num_month =  7; 					break;
				case "08":					$num_month =  8;					break;
				case "8":						$num_month =  8;					break;
				case "09":					$num_month =  9;					break;		
				case "9":						$num_month =  9;					break;		
				case "10":					$num_month =  10; 					break;
				case "11":					$num_month =  11;					break;
				case "12":					$num_month =  12;					break;		
				default: 
					$num_month =  0;					break;
			}	// end swish

	$arr_month =  array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	return $arr_month[$num_month] ;
}
$month_nm = date("n") ; 
$th_yy = date("Y")+543 ; 
$timenow = date("j") ." ". find_month($month_nm) ." ". $th_yy   ." (". (int)date("H")   .":". (int)date("i")   .":". (int)date("s")   .")"    ;  # 20 พ.ค. 2549 (12:30:41)
echo $timenow ; 
?>        </td>
      </tr>
    </table>
	</td>
  </tr>
</table>
<table width="96%"   align="center" cellpadding="0" cellspacing="0" style="border: #8D99C4 1px solid">
  <tr>
    <td><table width="100%" align="center" cellpadding="4" cellspacing="1">
      <tr align="left" bgcolor="#ffffff">
        <td width="36%" height="25" align="center" bgcolor="#CCCCCC"><strong>หมวดที่ต้องการเปลี่ยนแปลงข้อมูล</strong></td>
        <td bgcolor="#CCCCCC"><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; หมายเหตุ</strong></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#EAEAEA"><input name="chki1" type="checkbox" id="chki1" value="1" />
      : ข้อมูลทั่วไป</td>
        <td width="64%" align="left" bgcolor="#F5F5F5">
          <textarea name="note_i1" cols="60" rows="2" id="note_i1"></textarea>        </td>
      </tr>
      <tr>
        <td align="left" bgcolor="#EAEAEA"><input name="chki2" type="checkbox" id="chki2" value="1" />
      : การศึกษา </td>
        <td align="left" bgcolor="#F5F5F5"><textarea name="note_i2" cols="60" rows="2" id="note_i2"></textarea>        </td>
      </tr>
      <tr>
        <td align="left" bgcolor="#EAEAEA"><input name="chki3" type="checkbox" id="chki3" value="1" />
      : การขึ้นเงินเดือน </td>
        <td align="left" bgcolor="#F5F5F5"><textarea name="note_i3" cols="60" rows="2" id="note_i3"></textarea></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#EAEAEA"><input name="chki4" type="checkbox" id="chki4" value="1" />
      : อบรม/ดูงาน/สัมนา </td>
        <td align="left" bgcolor="#F5F5F5"><textarea name="note_i4" cols="60" rows="2" id="note_i4"></textarea></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#EAEAEA"><input name="chki5" type="checkbox" id="chki5" value="1" />
      : ผลงานทางวิชาการ </td>
        <td align="left" bgcolor="#F5F5F5"><textarea name="note_i5" cols="60" rows="2" id="note_i5"></textarea></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#EAEAEA"><input name="chki6" type="checkbox" id="chki6" value="1" />
      : เครื่องราช ฯ </td>
        <td align="left" bgcolor="#F5F5F5"><textarea name="note_i6" cols="60" rows="2" id="note_i6"></textarea></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#EAEAEA"><input name="chki7" type="checkbox" id="chki7" value="1" />
      : ความรู้ความสามารถพิเศษ </td>
        <td align="left" bgcolor="#F5F5F5"><textarea name="note_i7" cols="60" rows="2" id="note_i7"></textarea></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#EAEAEA"><input name="chki8" type="checkbox" id="chki8" value="1" />
      : รายการความดีความชอบ </td>
        <td align="left" bgcolor="#F5F5F5"><textarea name="note_i8" cols="60" rows="2" id="note_i8"></textarea></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#EAEAEA"><input name="chki9" type="checkbox" id="chki9" value="1" />
      : จำนวนวันลาหยุดราชการ </td>
        <td align="left" bgcolor="#F5F5F5"><textarea name="note_i9" cols="60" rows="2" id="note_i9"></textarea></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#EAEAEA"><input name="chki10" type="checkbox" id="chki10" value="1" />
      : วันที่ไม่ได้รับเงินเดือนหรือ ได้รับเงินเดือนไม่เต็มจำนวน </td>
        <td align="left" bgcolor="#F5F5F5"><textarea name="note_i10" cols="60" rows="2" id="note_i10"></textarea></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#EAEAEA"><input name="chki11" type="checkbox" id="chki11" value="1" />
      : การได้รับโทษทางวินัย </td>
        <td align="left" bgcolor="#F5F5F5"><textarea name="note_i11" cols="60" rows="2" id="note_i11"></textarea></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#EAEAEA"><input name="chki12" type="checkbox" id="chki12" value="1" />
      : การปฏิบัติราชการพิเศษ </td>
        <td align="left" bgcolor="#F5F5F5"><textarea name="note_i12" cols="60" rows="2" id="note_i12"></textarea></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#EAEAEA"><input name="chki13" type="checkbox" id="chki13" value="1" />
      : รายการอื่น ๆ ที่จำเป็น </td>
        <td align="left" bgcolor="#F5F5F5"><textarea name="note_i13" cols="60" rows="2" id="note_i13"><?=$_COOKIE["notes_".$id]?></textarea></td>
      </tr>
      <tr>
        <td colspan="2" align="center" bgcolor="#EAEAEA">
          <?
if($_COOKIE["appr_".$id] == "notapprove" ){ $dis = "block"; } else { $dis = "none"; }
?>
          <div id="msgBox" style="display:<?=$dis?>;"></div></td>
      </tr>
      <tr align="center">
        <td height="35" colspan="2" bgcolor="#EAEAEA"><input name="Submit" type="submit" value="บันทึก"  /></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>	</td>
</tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>