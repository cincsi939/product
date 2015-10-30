<?
session_start();
if($_SESSION[session_staffid] == ""){
	echo "<script>alert('กรุณา login เข้าสู่ระบบอีกครั้ง'); </script>";
	header("Location:../../../userentry/login.php");
	die;
}

set_time_limit(0);
include ("../../../../config/conndb_nonsession.inc.php")  ;
include("../../../../common/common_competency.inc.php");
include('function_checkdata.inc.php') ;
include("../../../userentry/function_save_log_edit_key.php");


/*function UpdateReqData($idcard,$siteid,$ticketid,$userkey_wait_approve){
	global $dbnamemaster;
	$sqlup = "UPDATE req_temp_wrongdata SET status_key_approve='$userkey_wait_approve' WHERE req_person_id IN(SELECT
t2.req_person_id
FROM ".DB_USERENTRY.".tbl_assign_edit_log as t1
Inner Join ".DB_USERENTRY.".tbl_assign_edit_log_detail as t2 ON t1.runid = t2.log_id
WHERE
t1.idcard =  '$idcard' AND
t1.siteid =  '$siteid' AND
t1.ticketid =  '$ticketid'
GROUP BY t2.req_person_id) ";
//echo $sqlup;die;
	mysql_db_query($dbnamemaster,$sqlup) or die(mysql_error()."$sqlup<br>".__LINE__);
		
}//end function UpdateReqData(){
*/


function UpdateReqData($idcard,$siteid,$ticketid,$userkey_wait_approve){
	global $dbnamemaster,$dbnameuse;
	$sql = "SELECT
t2.req_person_id
FROM ".DB_USERENTRY.".tbl_assign_edit_log as t1
Inner Join ".DB_USERENTRY.".tbl_assign_edit_log_detail as t2 ON t1.runid = t2.log_id
WHERE
t1.idcard =  '$idcard' AND
t1.siteid =  '$siteid' AND
t1.ticketid =  '$ticketid'
GROUP BY t2.req_person_id";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$sql_up = "UPDATE req_temp_wrongdata SET status_key_approve='$userkey_wait_approve' WHERE req_person_id='$rs[req_person_id]'";
		mysql_db_query($dbnamemaster,$sql_up) or die(mysql_error()."$sql_up<br>LINE::".__LINE__);
			
	}// end while($rs = mysql_fetch_assoc($result)){
		
}//end function UpdateReqData(){


if($_SERVER['REQUEST_METHOD'] == "POST" and $_POST['action_approve'] == '1'){
   
    ##log check vitaya
	 $sql = "REPLACE INTO log_check_vitaya(idcard,time_update) VALUES('$idcard',NOW())";
	 mysql_db_query('edubkk_master',$sql)or die(mysql_error());
	 
	
	
	if($userkey_wait_approve == "4" and $commet_key_data != ""){
			$conup1 = " ,comment_req='$commet_key_data'";
	}//end if($userkey_wait_approve == "4" and $commet_key_data != ""){
	## บันทึกการตรวจสอบข้อมูลเบื้องต้นของคนคีย
	$sql_update = "UPDATE tbl_assign_edit_key SET userkey_wait_approve='$userkey_wait_approve',commet_key_data='$commet_key_data' $conup1  WHERE idcard = '$idcard' AND ticketid='$ticketid' AND siteid='$xsiteid'";
	$result_update = mysql_db_query($dbnameuse,$sql_update) or die(mysql_error()."$sql_update<br>LINE::".__LINE__);
	
	UpdateReqData($idcard,$xsiteid,$ticketid,$userkey_wait_approve);// update ผลการแก้ไขรายการจากคำร้อง
	
	if($userkey_wait_approve == "1"){
		GetLogKey("$idcard","$xsiteid","$ticketid");	
	}// end if($userkey_wait_approve == "1"){
	

	
	
	if($result_update){
			echo "
				<script language=\"javascript\">
				alert(\"บันทึกข้อมูลเรียบร้อยแล้ว\");
				window.opener.location.reload() ;
				window.close();
				</script>
				";
			exit;	

	}
		
}//end if($_SERVER['REQUEST_METHOD'] == "POST"){
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>ตรวจสอบข้อผิดพลาดการบันทึกข้อมูล</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script language="javascript">
function CheckFApp(){
	
	if(document.form1.radio1.checked == false && document.form1.radio2.checked == false && document.form1.radio3.checked == false && document.form1.radio4.checked == false){
		alert("กรุณาเลือกสถานะการแก้ไขข้อมูล ก.พ.7 ");	
		return false;
	}
	if(document.form1.radio4.checked == true){
			if(document.form1.commet_key_data.value == ""){
					alert("กรณีต้องการคำอธิบายเพิ่มเติมกรุณาระบุข้อความในช่องหมายเหตุ");
					document.form1.commet_key_data.focus();
					return false;
			}
	}	
}

</script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?
			$sql_get_profile = "SELECT
tbl_assign_edit_key.profile_id
FROM
tbl_assign_edit_key
Inner Join tbl_assign_sub ON tbl_assign_edit_key.ticketid = tbl_assign_sub.ticketid
where tbl_assign_edit_key.idcard='$idcard' and tbl_assign_sub.staffid = '".$_SESSION[session_staffid]."'";
			$result_pro = mysql_db_query($dbnameuse,$sql_get_profile);
			$rspor = mysql_fetch_assoc($result_pro);
			mysql_free_result($result_pro);

				$dbsite = STR_PREFIX_DB.$xsiteid;
				$date_profile =  DateProfile($idcard,$xsiteid,$profile_id);// วันที่จัดทำข้อมูล
				$arrdata = ProcessQCData($xsiteid,$idcard,$rspor[profile_id]);				

				
				 if(count($arrdata) < 1){
					$xmsg = "ผลการตรวจสอบความถูกต้องข้องข้อมูล ผ่าน ";	 
				}else{
					$xmsg = " เกิดความผิดพลาดในการคีย์ข้อมูล";	
				}
		$strSql = "SELECT id,idcard,prename_th,name_th,surname_th, siteid,schoolid, position_now FROM general WHERE id='$idcard'";
		$result = mysql_db_query($dbsite,$strSql);
		$rs = mysql_fetch_assoc($result);
		$pathfile = "../../../../../edubkk_kp7file/$rs[siteid]/$rs[idcard]".".pdf";
		
		
		

?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
  <tr>
    <td height="446" valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="370" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="30" class="table2">&nbsp;</td>
            </tr>
        </table>
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td width="50%" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="7%" align="center"><? echo "<a href='login_data.php?xprename_th=$rs[prename_th]&xname_th=$rs[name_th]&xsurname_th=$rs[surname_th]&xidcard=$rs[idcard]&action=login&xsiteid=$rs[siteid]' target='_blank'>";?><img src="../../../../images_sys/person.gif" width="16" height="13" border="0" alt="คลิ๊กเพื่อ login เข้าสู่ระบบ"><? echo "</a>"; ?></td>
                      <td width="93%" align="left"><strong>ผลสรุปการตรวจสอบข้อมูล</strong>&nbsp;<? if(is_file($pathfile)){?><a href="<?=$pathfile?>" target="_blank"><img src="../../../../images_sys/gnome-mime-application-pdf.png" width="20" height="21" alt="ตรวจสอบไฟล์ pdf ต้นฉบับ" border="0"></a><? } ?></td>
                    </tr>
                  </table></td>
                  </tr>
                <tr>
                  <td colspan="2" align="center" valign="top">&nbsp;</td>
                  </tr>
                <tr>
                  <td width="24%" align="center" valign="top">
                  <?
                  		$sql_showpic="select yy,imgname from general_pic where id='$idcard' and kp7_active='1' order by no  DESC ";
						$query=mysql_db_query($dbsite,$sql_showpic)or die("cannot query".mysql_error());
						$num=mysql_num_rows($query);
						
						if($num==0){
							echo "<img src=\"../../../../images_sys/noimage.jpg\">";
						}else{
							$rp=mysql_fetch_assoc($query);
							echo "<img src=\"../../../../../image_file/$rs[siteid]/$rp[imgname]\" width=120 height=160 >";
						}//end if($num==0){
                  
                  		
                  ?>
                  </td>
                  <td width="76%" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                      <td width="22%" align="right" bgcolor="#FFFFFF"><strong>รหัสบัตรประชาชน : </strong></td>
                      <td width="51%" align="left" bgcolor="#FFFFFF"><?=$idcard?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>ชื่อ - นามสกุล : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>ตำแหน่ง : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?=$rs[position_now]?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>สังกัด : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?=ShowArea($rs[siteid])."/".ShowSchool($rs[schoolid]);?></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
              <td width="50%" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="7%" align="center"><strong><img src="../../../../images_sys/useronline.gif" width="20" height="20" /></strong></td>
                      <td width="93%"><strong>รายละเอียดผู้บันทึกข้อมูล</strong></td>
                    </tr>
                  </table></td>
                  </tr>
                <tr>
                  <td colspan="2" align="center">&nbsp;</td>
                </tr>
                <?
              $sql_staff = "SELECT tbl_assign_sub.staffid, monitor_keyin.idcard, monitor_keyin.timeupdate, keystaff.prename, keystaff.staffname,
keystaff.staffsurname, keystaff.sapphireoffice, keystaff.image 
FROM tbl_assign_sub
Inner Join tbl_assign_edit_key ON tbl_assign_sub.ticketid = tbl_assign_edit_key.ticketid
Inner Join monitor_keyin ON tbl_assign_edit_key.idcard = monitor_keyin.idcard
Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid
WHERE  monitor_keyin.idcard =  '$idcard' AND tbl_assign_edit_key.nonactive =  '0' ORDER BY monitor_keyin.timeupdate DESC LIMIT 1 ";
			$result_staff = mysql_db_query($db_name,$sql_staff);
			$rs_staff = mysql_fetch_assoc($result_staff);
				?>
                <tr>
                  <td width="31%" align="center" valign="top">
                  <?
                  	if($rs_staff[image] != ""){
						echo "<img src=\"../../../userentry/images/personnel/$rs_staff[image]\" width=120 height=160>";	
					}else{
						echo "<img src=\"../../../../images_sys/noimage.jpg\">";	
					}
				  ?>
                  
                  </td>
                  <td width="69%" align="center" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                      <td width="42%" align="right" bgcolor="#FFFFFF"><strong>ชื่อ-นามสกุล : </strong></td>
                      <td width="58%" align="left" bgcolor="#FFFFFF"><? echo "$rs_staff[prename]$rs_staff[staffname]  $rs_staff[staffsurname]";?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>วันที่บันทึกข้อมูล : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?=DateThai($rs_staff[timeupdate]);?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>ประเภทพนักงาน : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?=$arrstaff[$rs_staff[sapphireoffice]];?></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="2" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tr>
                  <td colspan="2" align="left"><strong><? echo $xmsg;?></strong></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <?  if($arrdata > 0){
				  $i=0;
				foreach($arrdata as $key => $val){	
				if($val != ""){
				 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				 
				  $arr_val = explode("!wraning",$val);
					if(count($arr_val) > 1){
						$show_val = "<font color='#FF0000'>!wraning </font>".$arr_val[1];
					 }else{
						$show_val =   $val;
					}//end if(count($arr_val) > 1){

				?>
                <tr bgcolor="<?=$bg?>">
                  <td width="6%" align="center" valign="top"><?=$i?></td>
                  <td width="94%" align="left"><? echo "[Error Code : $key] $show_val";?></td>
                </tr>
                <?
				}//end if($val != ""){
				}//end foreach(){	  
			  }//end  if($arrdata > 0){

			?>
              </table></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td>
		
<?php
if($_GET['open_check_vitaya'] == '1'){
  $txt_link = "&open_check_vitaya=1";
  $bt_disable = 'disabled="disabled"';
  
?>
<br />
&nbsp;<strong>การตรวจสอบวิทยฐานะจากระบบ</strong>
<br />
<?php
include "edit_vitaya.php";
?>
<br />
<br />

<?php
}
?>		
		
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <?
        	$sql_edit = "SELECT * FROM tbl_assign_edit_key WHERE idcard='$idcard' AND  nonactive='0' AND siteid='$xsiteid' ";
			$result_edit = mysql_db_query("edubkk_userentry",$sql_edit);
			$rs_edit = mysql_fetch_assoc($result_edit);
		?>
          <tr>
            <td height="40" align="center" class="table_button"><form id="form1" name="form1" method="post" action="" onsubmit="return CheckFApp()">
              <table width="70%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                      <td colspan="2" align="left" bgcolor="#CCCCCC"><strong><img src="../../../salary_mangement/images/bell_add.png" width="16" height="16" />&nbsp;กำหนดสถานะผลการแก้ไขข้อมูล ก.พ.7</strong></td>
                      </tr>
                    <tr>
                      <td align="right" valign="top" bgcolor="#FFFFFF"><strong>สถานะการแก้ไขข้อมูล ก.พ.7 :</strong></td>
                      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                        <tr>
                          <td width="5%" align="center" valign="top"><input type="radio" name="userkey_wait_approve" id="radio1" value="1" <? if($rs_edit[userkey_wait_approve] == 1){ echo " checked='checked'"; }?>></td>
                          <td width="95%" align="left" valign="middle"><strong>แก้ไขเสร็จแล้ว</strong></td>
                        </tr>
                        <tr>
                          <td align="center" valign="top"><input type="radio" name="userkey_wait_approve" id="radio2" value="2" <?  if($rs_edit[userkey_wait_approve] == 2){ echo " checked='checked'"; }?>></td>
                          <td align="left" valign="middle"><strong>ตรวจสอบแล้วไม่พบข้อมูลผิด</strong></td>
                        </tr>
                        <tr>
                          <td align="center" valign="top"><input type="radio" name="userkey_wait_approve" id="radio3" value="3" <?  if($rs_edit[userkey_wait_approve] == 3){ echo " checked='checked'"; }?>></td>
                          <td align="left" valign="middle"><strong>ตรวจสอบแล้วเป็นข้อมูลคำร้องขยะ</strong></td>
                        </tr>
                        <tr>
                          <td align="center" valign="top"><input type="radio" name="userkey_wait_approve" id="radio4" value="4" <?  if($rs_edit[userkey_wait_approve] == 4){ echo " checked='checked'"; }?>></td>
                          <td align="left" valign="middle"><strong>ต้องการคำอธิบายเพิ่มเติม</strong></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>หมายเหตุ : </strong></td>
                      <td align="left" bgcolor="#FFFFFF">
                        <input name="commet_key_data" type="text" id="commet_key_data" size="50" value="<?=$rs_edit[commet_key_data]?>">
                      </td>
                      </tr>
                    <tr>
                      <td bgcolor="#CCCCCC">&nbsp;</td>
                      <td bgcolor="#CCCCCC"><label>
					  <input name="action_approve" type="hidden" value="1" />
                      <input type="hidden" name="idcard" value="<?=$idcard?>">
                      <input  type="hidden"  name="staffid" value="<?=$_SESSION[session_staffid]?>">
                      <input type="hidden" name="xsiteid" value="<?=$xsiteid?>">
                      <input type="hidden" name="ticketid" value="<?=$ticketid?>">
                        <input type="submit" name="button" id="button" value="บันทึกข้อมูล" <?=$bt_disable?>/>
                        <input type="button" name="btnClose" value="ปิดหน้าต่าง" onclick="window.close();">
                      </label></td>
                    </tr>
                    </table></td>
                  </tr>
                </table>
              </form></td>
          </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
