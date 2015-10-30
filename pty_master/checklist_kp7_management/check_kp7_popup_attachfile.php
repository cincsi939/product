<?
session_start();
set_time_limit(0);
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "checklistkp7"; 
$process_id			= "checklistkp7_byarea";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20100809.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2010-08-09 09:49
	## Created By :		chayut
	## E-mail :			chayut@sapphire.co.th
	## Tel. :			
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20100809.00
	## Modified Detail :		
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.CHAYUT SRIYALA
###################################################################
include("../../../../common/common_competency.inc.php");
include("../../../checklist_kp7_management/checklist2.inc.php");

if($_GET['del']!=''){
	//echo "OK".$_GET['del'];
	$sql_tem ="select runid,filename from temp_change_idcard_attfile
						WHERE runid = '".$_GET['del']."'";
	$rs_tem = mysql_db_query('edubkk_checklist',$sql_tem)or die(mysql_error());
	$row_tem = mysql_fetch_assoc($rs_tem);
	 $fileDir = "../../../change_idcard_attfile/".$_GET['idcard']."/";
	 
	 if($row_tem['runid']!=''){
		if(is_file($fileDir.$row_tem[filename])){
			chmod($fileDir.$row_tem[filename], 0777);
			@unlink($fileDir.$row_tem[filename]);
			
			$sql_del = "delete from temp_change_idcard_attfile where runid ='".$row_tem['runid']."' ";
			$result = mysql_db_query('edubkk_checklist',$sql_del);
			if($result){
				echo "<script>alert('ลบไฟล์ ".$row_tem['filename']." เรียบร้อยแล้ว');</script>";
				echo "<script>window.location.reload();</script>";
			}
		}
	 }
}
?>
<html>
<head>
<title>แนบไฟล์เลขประจำตัวประชาชน</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<LINK href="css/style.css" rel=stylesheet>
<script language="javascript" src="../../common/script_event.js"></script>
<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script language="javascript">
function delFile(idcard,xsiteid,profile_id,del){
	
	 if(confirm('ต้องการลบไฟล์ หรือไม่?')){
	 	document.location= "?idcard="+idcard+"&xsiteid="+xsiteid+"&profile_id="+profile_id+"&del="+del;
	 }

}
	function CheckF(){
		if(document.form1.comment_delete.value == ""){
				alert("กรุณาใส่หมายเหตุการลบด้วย");
				document.form1.comment_delete.focus();
				return false;
		}
		if(document.form1.comment_delete.value.length < 10){
			alert("หมายเหตุที่ใส่มีข้อความน้อยเกินไป กรุณาระบุเหตุผลการลบมากกว่านี้")
			document.form1.comment_delete.focus();
			return false;	
		}
		
	return true;
}
</script>
<script type="text/javascript">
function Checkfiles()
{
		var fup = document.getElementById('fileAttach');
		var fileName = fup.value;
		var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
		
	if(document.form1.fileAttach.value==""){
			alert("กรุณา เลือกไฟล์แนบ");
			document.form1.fileAttach.focus();
			return false;
			fup.focus();
	}else if(fileName!=""){
		
		if(ext == "png" || ext == "PNG" || ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG")
		{
					return true;
		}else{
				alert("กรุณาแนบไฟล์ประเภท .png/.gif/.jpeg เท่านั้น");
				fup.value='';
				fup.focus();
					return false;
		}
	}
}
</script>
</head>
<body>
<?
	$sql = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><form action="" method="post" enctype="multipart/form-data" name="form1" onSubmit="return CheckF()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td width="3%" align="center" bgcolor="#CCCCCC"><img src="../../../../images_sys/attention.png" width="30" height="30"></td>
              <td colspan="2" align="left" valign="middle" bgcolor="#CCCCCC"><strong>ฟอร์มการแนบไฟล์เลขประจำตัวประชาชน</strong></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>เลขประจำตัวประชาชน : </strong></td>
              <td width="71%" align="left" bgcolor="#FFFFFF"><?=$rs[idcard]?></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>ชื่อ - นามสกุล : </strong></td>
              <td align="left" bgcolor="#FFFFFF"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>ตำแหน่ง : </strong></td>
              <td align="left" bgcolor="#FFFFFF"><? echo "$rs[position_now]";?></td>
              </tr>
              <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>วันเดือนปีเกิด : </strong></td>
              <td align="left" bgcolor="#FFFFFF"><? echo GetDateTh($rs[birthday]) ?></td>
              </tr>
              <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>วันเริ่มปฏิบัตราชการ : </strong></td>
              <td align="left" bgcolor="#FFFFFF"><? echo GetDateTh($rs[begindate]) ?></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>สังกัดหน่วยงาน :</strong></td>
              <td align="left" bgcolor="#FFFFFF"><? echo xShowAreaSort($rs[siteid])."/".xshow_school($rs[schoolid]);?></td>
              </tr>
              <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><strong>ไฟล์แนบ :</strong></td>
              <td align="left" bgcolor="#FFFFFF">
			  		 <?php echo getFile($_GET['idcard'])?>
              </td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF"><span class="main"><strong>*</strong></span><strong>กรุณาเลือกไฟล์ :</strong></td>
              <td align="left" bgcolor="#FFFFFF">
                <input name="fileAttach" id="fileAttach" type="file" onChange="Checkfiles()"/>
                &nbsp;&nbsp;
                
                <br />
                <font color="#FF0000"><strong> แนบได้เฉพาะไฟล์ .jpeg/.gif/.png  ขนาดไม่เกิน 10 Mb </strong></font></td>
              </tr>
            <tr>
              <td colspan="2" align="right" bgcolor="#FFFFFF">&nbsp;</td>
              <td align="left" bgcolor="#FFFFFF">
                <!--<input type="submit" name="button" id="button" value="บันทึก">-->
                <input name="btUpload" type="submit" value="  บันทึก  " onClick="Checkfiles()"/>
                <input type="button" name="btnc" id="btnc1" value=" ปิดหน้าต่าง " onClick="window.close();">
                <input type="hidden" name="idcard" value="<?=$rs[idcard]?>">
                <input type="hidden" name="profile_id" value="<?=$profile_id?>">
                <input type="hidden" name="sentsecid" value="<?=$sentsecid?>">
                <input type="hidden" name="fullname" value="<?=$fullname?>">
                <input type="hidden" name="search" value="<?=$search?>">
                <input type="hidden" name="key_name" value="<?=$key_name?>">
                <input type="hidden" name="key_surname" value="<?=$key_surname?>">
                <input type="hidden" name="key_idcard" value="<?=$key_idcard?>">
                <input type="hidden" name="schoolid" value="<?=$schoolid?>">
                <input type="hidden" name="xsiteid" value="<?=$xsiteid?>">
                <input type="hidden" name="action" value="<?=$action?>">
                <input type="hidden" name="lv" value="<?=$lv?>">
                </td>
            </tr>
          </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
	function xShowAreaSort($get_secid){
		global $dbnamemaster;
		$sql_area = "SELECT secname FROM eduarea WHERE secid='$get_secid'";
		$result_area = mysql_db_query($dbnamemaster,$sql_area);
		$rs_area = mysql_fetch_assoc($result_area);
		return str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs_area[secname]);
	}//end function ShowAreaSort($get_secid){
	
###  ฟังก์ชั่นแสดงหน่วยงาน
	function xshow_school($get_schoolid){
		global $dbnamemaster;
		$sql_school = "SELECT office FROM allschool WHERE id='$get_schoolid'";
		$result_school = mysql_db_query($dbnamemaster,$sql_school);
		$rs_school = mysql_fetch_assoc($result_school);
		return $rs_school[office];
	}//end function show_school($get_schoolid){

	
$shortmonth = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	function GetDateTh($temp){
				global $shortmonth;
				if($temp != "0000-00-00"){
					$x = explode("-",$temp);
					$m1 = $shortmonth[intval($x[1])];
					if($x[0] > 2500){
							$y1 = intval($x[0]);
					}else{
						$y1 = intval($x[0]+543);
					}//end if($x[0] > 2500){
					$xrs = intval($x[2])." $m1 "."".substr($y1,-2) ;
				}else{
					$xrs = "";	
				}
				return $xrs;
			}// end function GetDateTh($temp){

//attach
 if($_POST['btUpload'] != ''){ 
   if($_FILES['fileAttach']['name'] != ''){
	 $fileSizeMb = number_format((($_FILES["fileAttach"]["size"] / 1024)/1024),2);
	 $fileType = $_FILES["fileAttach"]["type"];  
   
	 
	 if($fileSizeMb <= 10){  	
	 
	 $fileNameOld = basename($_FILES['fileAttach']['name']);
	 $arrFileName = explode(".",$fileNameOld);
	 $fileExp = end($arrFileName);
	 $today = getdate();
	 $fileName =$_GET['idcard']."-".$today["year"].$today["mon"].$today["mday"].$today["hours"].$today["minutes"].$today["seconds"].".".$fileExp;

//check max
$check_max=getFile($_GET['idcard'],1);
if($check_max>0){
	$order_no = $check_max+1;
}else{
	$order_no = 1;
}
	 $fileDir = "../../../../../change_idcard_attfile/".$_GET['idcard']."/";
	if(!file_exists($fileDir)){
		mkdir($fileDir);
		chmod($fileDir.$fileName, 0777);
	}
	 
	 if(move_uploaded_file($_FILES['fileAttach']['tmp_name'],$fileDir.$fileName)){ 
	 		$sql="INSERT INTO temp_change_idcard_attfile SET
						old_idcard = '".$_GET['idcard']."',
						new_idcard = '',
						profile_id = '".$_GET['profile_id']."',
						filename = '".$fileName."',
						user_id = '".$_SESSION[session_username]."',
						order_no = '".$order_no."',
						timeprocess = NOW(),
						timeupdate = NOW()
				";
				
				$rs = mysql_db_query('edubkk_checklist',$sql)or die(mysql_error());
				if($rs){
				  echo "<script>alert('อัพโหลดไฟล์สมบูรณ์');</script>";
				   echo "<script>window.location='?idcard=$_GET[idcard]&xsiteid=$_GET[xsiteid]&profile_id=$_GET[profile_id]';</script>";
				}else{
					echo "<script>alert('ไม่สามารถอัพโหลดไฟล์ได้ กรุณาติดต่อผู้ดูแลระบบ');</script>";
				}

		 }else{
			echo "<script>alert('ไม่สามารถอัพโหลดไฟล์ได้ กรุณาติดต่อผู้ดูแลระบบ');</script>";
			echo "<script>window.location='?idcard=$_GET[idcard]&xsiteid=$_GET[xsiteid]&profile_id=$_GET[profile_id]';</script>";
		 }
	 
	 }else{
	   echo "<script>alert('ไม่สามารถอัพโหลดไฟล์ได้ เนื่องจากขนาดไฟล์มากกว่า 10 เมกะไบต์');</script>";   
	 }
   }
}
function getFile($idcard,$type=''){

if($type == 1){
	$sql_temp="select MAX(order_no) AS max from temp_change_idcard_attfile
						WHERE old_idcard = '".$idcard."';
						";
}else{
	$sql_temp ="select * from temp_change_idcard_attfile
						WHERE old_idcard = '".$idcard."'
						order by order_no DESC;
						";
}
	$rs_temp = mysql_db_query('edubkk_checklist',$sql_temp)or die (mysql_error());
	$check = mysql_num_rows($rs_temp);
	
	if($type==1){
			$row = mysql_fetch_assoc($rs_temp);
			return $row['max'];
	}else{
			if($check>0){
					$i=1;
					while($row = mysql_fetch_assoc($rs_temp)){
						$full_path_name = "../../../change_idcard_attfile/".$row['old_idcard']."/".$row['filename'];
						echo '<a href="'.$full_path_name.'" target="_blank"><img src="images/001_13.gif" border="0" align="absmiddle" >
							Download File : '.$row['filename'].'</a>&nbsp;<a href="#" onClick="delFile('.$idcard.','.$_GET[xsiteid].','.$_GET[profile_id].','.$row[runid].')" >[ลบ]</a>';
						if($i==1){
							echo '&nbsp;<font color="#FF0000"><-- ไฟล์ล่าสุด</font>';
						}
						echo "<br>";
						
						$i++;
					}
			}else{
				echo " <font color=\"#FF0000\">   ยังไม่มีไฟล์แนบ</font>";
			}
	}
}
?>
