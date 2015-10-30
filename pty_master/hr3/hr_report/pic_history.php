<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_image";
$module_code 		= "image"; 
$process_id			= "image";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer::
#DateCreate::17/07/2007
#LastUpdate::17/07/2007
#DatabaseTabel::
#END
#########################################################
//include ("session.inc.php");

session_start();
//if($debug){ echo "000".$_SESSION[secid];die;}
include("../libary/function.php");
//include ("checklogin.php");
//if($debug){ echo "111".$_SESSION[secid];die;}
//include ("../../../config/phpconfig.php");
//if($debug){ echo "2".$_SESSION[secid];die;}
include("../../../config/config_hr.inc.php");
//if($debug){ echo "3".$_SESSION[secid];die;}
include("../../../common/common_competency.inc.php");
//if($debug){ echo "4".$_SESSION[secid];die;}
//echo "<pre>";
//print_r($_SESSION);
$menu_id = "2";
$time_start = getmicrotime();
//$folder_img 	= "images/personal/";
$folder_img = "../../../../edubkk_image_file/$siteid/";
$folder_img_del = "../../../../edubkk_image_file/temp_deleteimg/";


#Begin ตรวจสอบว่ามีเจ้าหน้าที่เขตหรือไม่และไม่ใช่พนักบันทึกข้อมูล
$strSql_personSite = "SELECT COUNT(siteid) AS count_siteid FROM edubkk_sapphire_app.`employee_work_site` WHERE siteid='".$siteid."' ";
$query_personSite = mysql_query($strSql_personSite);
$row_personSite = mysql_fetch_assoc($query_personSite);
$nums_personSite = $row_personSite['count_siteid'];
if($_SESSION['session_sapphire']==1 || 
	$_SESSION['session_status_extra']=="QC"  || $_SESSION['session_status_extra']=="CALLCENTER" || 
	$_SESSION['session_status_extra']=="SCAN" || $_SESSION['session_status_extra']=="GRAPHIC"  ||
	$_SESSION['session_status_extra']=="site_area"
){
	//$nums_personSite = 0;//Test Keyin
	$nums_personSite = 1;
}
#End ตรวจสอบว่ามีเจ้าหน้าที่เขตหรือไม่และไม่ใช่พนักบันทึกข้อมูล
#Begin พนักบันทึกข้อมูลมีรูปอยู่หรือไม่
function personKeyIn_delete($id="",$no="",$nums_personSite=""){
	global $siteid;
	if($nums_personSite==0){
		$strSql = "SELECT imgname, flag_imgnull FROM `general_pic` WHERE id='".$id."' AND no='".$no."' ";
		$query_person = mysql_db_query(STR_PREFIX_DB.$siteid, $strSql);
		$row_person = mysql_fetch_assoc($query_person);
		if($row_person['flag_imgnull']==1){
			return true;
		}else{
			return false;
		}
	}else{
		return true;
	}
}
#End พนักบันทึกข้อมูลมีรูปอยู่หรือไม่

if($action == "ChangR"){
$nn="01";
$Repeat = "FALSE";
//---------------------------------------------
for($i=0;$i<count($runno);$i++){
	for($j=0;$j<count($runno);$j++){
		if($i != $j){
			if($runno[$i]==$runno[$j]){
				$Repeat = "TRUE";
			}
		}
	}
}



	if($Repeat=="TRUE"){
	echo "<script language=\"JavaScript\"> alert(\"ข้อมูลการจัดเรียงลำดับไม่สามารถซ้ำกันได้\");</script>";

	}else{
		for($k=0;$k<count($runno);$k++){
			if($imgname[$k] != ""){
				$conv = " AND imgname='".$imgname[$k]."'";
			}else{
				$conv = " AND flag_imgnull='".$flagimgnull[$k]."'";
			}
			$sql	= " update general_pic set no='".$runno[$k]."".$nn."' where id='$id'  $conv ";	
			//echo "sql :: ".$sql."<br>";
			$result 	= mysql_query($sql);
		}
		for($m=0;$m<count($runno);$m++){
			if($imgname[$m] != ""){
				$conv = " AND imgname='".$imgname[$m]."'";
			}else{
				$conv = " AND flag_imgnull='".$flagimgnull[$m]."'";
			}

				$xsql	= " update general_pic set no='".$runno[$m]."' where id='$id' $conv";	
				//echo "xsql :: ".$xsql."<br>";
				$xresult 	= mysql_query($xsql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
				
			}
}
		
}// จบ

if($action == "delete"){

	add_log("ข้อมูลภาพประวัติบุคลากร",$id,$action,$menu_id);	
	$sql_check = "select * from general_pic where id='$id'";
	$result_ch = mysql_query($sql_check);
	$xi=0;
	while($rs_ch = mysql_fetch_assoc($result_ch)){
		$ximgname[$xi] = $rs_ch[imgname];
		$xi++;
	}
	//echo "<pre>";
	//print_r($ximgname);die;
			$check_ximg = "N";
			for($xa=0;$xa<count($ximgname);$xa++){
			if($ximgname[0] == $ximgname[$xa+1] ){
				$check_ximg = "Y";
				break;
				}
		}
	$sql 		= " select * from `general_pic` where id='$id' and no='$no'; ";
	$result	= mysql_query($sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
	$rs		= mysql_fetch_assoc($result);
	$image 	= $folder_img.$rs[imgname];		
	$image_dest = $folder_img_del.$rs[imgname];
	if($rs[imgname] != "" && file_exists($image)){ // ห้ามลบรูปหาก พ.ศ. ต่ำกว่า 2550
	if (!file_exists($folder_img_del)) {
		mkdir($folder_img_del, 0777, true);
		}
		if($check_ximg == "Y"){// เช็คกรณีชื่อไฟล์ใน ฐานข้อมูลซ้ำกัน
			if(copy($image,$image_dest)){
				unlink($image); 
			}

		}else{
			if(copy($image,$image_dest)){
				unlink($image); 
			}
		
		}
	}
/*	else{ 
	
	echo "<script language=\"javascript\">alert(\"ไม่สามารถลบรูปได้\");</script>";	
	echo "<meta http-equiv='refresh' content='2;url=?id=$id'>";
	exit; 
	}
*/	
mysql_free_result($result);
	
	$result	= mysql_query(" delete from `general_pic` where id='$id' and no='$no'; ")or die("Query line " . __LINE__ . " error<hr>".mysql_error());
	echo "<script language=\"javascript\">alert(\"ลบภาพที่เลือกเรียบร้อยแล้ว\");</script>";	
	echo "<meta http-equiv='refresh' content='1;url=?id=$id'>";
	exit;
	
} elseif($action == "delcurrent"){
	
	add_log("ข้อมูลภาพประวัติบุคลากร",$id,$action,$menu_id);
	$image 	= get_picture($id);
	if(file_exists($image)){ unlink($image); }	
	echo "<meta http-equiv='refresh' content='1;url=?id=$id'>";
	exit;

} elseif($action == "setprimary"){

	add_log("ข้อมูลภาพประวัติบุคลากร",$id,$action,$menu_id);
	$image 	= get_picture($id);
	if(file_exists($image)){ unlink($image); }	
	
	$sql			= " select * from `general_pic` where id='$id' and no='$no'; ";
	$query 		= mysql_query($sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
	$rs			= mysql_fetch_assoc($query);
	$scource	= $folder_img.$rs[imgname];
	$target		= $folder_img.$id.".".strtolower(getFileExtension($scource));
	copy($scource, $target);
	echo "<meta http-equiv='refresh' content='1;url=?id=$id'>";
	exit;
				
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="hr.css" type="text/css" rel="stylesheet">
<title>ภาพบุคลากร</title>
<style type="text/css">
<!--
body {
	margin: 0px  0px;
	padding: 0px  0px;
	margin-top: 5px;
	margin-bottom: 5px;
}
.pic_active{
	border:2px #5595CC solid;padding:2px;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#5595CC', EndColorStr='#ffffff'); 
}
.pic_deactive{
	border:2px #CECBCE solid;padding:2px;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#CECBCE', EndColorStr='#ffffff'); 
}
.label1{
	font-size:13px;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#ffffff', EndColorStr='#F4F4F4'); 
	padding: 2px;
}
.main_table{
	background-color:#F4F4F4;
	border:1px solid #DADAE1;
}
 -->
</style>
<script src="../../../common/SMLcore/TheirParty/js/jquery-1.8.1.min.js"></script>
<script language="javascript">

function popWindow(url, w, h){

	var popup		= "Popup"; 
	if(w == "") 	w = 420;
	if(h == "") 	h = 300;
	var newwin 	= window.open(url, popup,'location=0,status=no,scrollbars=no,resizable=no,width=' + w + ',height=' + h + ',top=20');
	newwin.focus();

}
</script>
</head>
<body >
<?
if($act==""){
	if($id != ""){
	//deletedir($folder_img.'x1_'.$id.'_temp/');
	deletedir($folder_img.$id.'_temp/');
	}
?>
	<form name="form1" method="post" action="<?=$PHP_SELF?>">			
  	<input type="hidden" name="action" value="ChangRow">
  
    <table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="79%">&nbsp;</td>
        <td width="21%">&nbsp;</td>
      </tr>
    </table>
    <table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="main_table">
<?
$sql 		= " SELECT prename_th, name_th, surname_th, idcard, birthday, position_now, subminis_now FROM `general` where id='$id'; "; 
$result 	= mysql_db_query($dbname,$sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
$rs 		= mysql_fetch_assoc($result) ; 
?>
<tr align="left" bgcolor="#f8f8f8">
    <td height="20" bgcolor="#f8f8f8" class="label1">&nbsp;<strong>คลังข้อมูลภาพ&nbsp;:</strong> 
      <?=$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]?> 
      <br />
      &nbsp;<strong><?=TEXT_IDCARD?>&nbsp;: </strong>      <?=$rs[idcard]?></td>
    <td width="250" height="20" bgcolor="#f8f8f8" class="label1" >
	<? 	if($dis_menu){ echo "";}else{ ?>
	&nbsp;<strong>เครื่องมือ</strong> 
	<?  } ?>
	</td>
</tr>
<tr>
	<td align="left">
<table width="250"  border="0" cellpadding="3" cellspacing="0">
<?
$xsql="select max(no) as maxno from general_pic where id='$id'";
$xresult=mysql_db_query($dbname,$xsql);
$xrs=mysql_fetch_array($xresult);
$maxid=$xrs[maxno];

$n 		= 0;
$sql		= " select * from `general_pic` where id='$id' order by no asc";
$result	= mysql_db_query($dbname,$sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
$num_r=mysql_num_rows($result);
$yy_max=max($num_r);
if($num_r >= 1){
while($rs = mysql_fetch_assoc($result)){

	if($n == 0){ echo "<tr>"; } elseif($n % 4 == 0){ echo "</tr><tr>"; }	
	if($rs[imgname] != ""){
		$pic	= "<img src=\"".$folder_img.$rs[imgname]."\"  width=120 height=160  border=\"0\">";
	}else{
		$pic	 = "<img src=\"../../../images_sys/noimage.jpg\" width=\"120\" height=\"160\" border=\"0\" title=\"ยังไม่มีไฟล์รูปภาพ\">";
	}
	if($rs[label_yy] != ""){
		$yy = " พ.ศ.".str_replace("พ.ศ.","",$rs[label_yy]);
	}else if($rs[yy] > 0){
		$yy = " พ.ศ. $rs[yy]";
	}else{
		$yy = "";	
	}
	$n++;	
?>
  <td align="left" valign="top">
<br />
<table width="100%" border="0" cellpadding="3" cellspacing="0"  style="border:1px solid #C9C9C9;">
<tr bgcolor="#f8f8f8">
  <td width="59%" height="20" align="right" bgcolor="#f8f8f8">
    <strong>(
    <?=$rs[no]?>
  )</strong></td>

  <td width="41%" align="right" bgcolor="#f8f8f8">
  <?
if($dis_menu){
  echo "";
  }else{
	  $namefolder = basename($rs[imgname],".".pathinfo($rs[imgname], PATHINFO_EXTENSION)."");
  ?>
	  <a href="#" onClick="deltemp('<?php echo base64_encode($folder_img.'x1_'.$namefolder) ?>');popWindow('pic_history_update.php?id=<?=$id?>&no=<?=$rs[no]?>','670','660')">
		<img src="../../../images_sys/b_edit.png" alt="แก้ไขข้อมูลรูปภาพ" border="0" width="16" height="16"></a>&nbsp;&nbsp;
<?php 
		#Begin IF เปิดให้ใช้เฉพาะเจ้าหน้าที่เขตและไม่ใช่พนักบันทึกข้อมูล
		if(personKeyIn_delete($_GET['id'],$rs['no'],$nums_personSite) == true){
?>
		<a href="#" onClick=" deltemp('<?php echo base64_encode($folder_img.'x1_'.$namefolder) ?>'); if (confirm('คุณจะทำการลบภาพนี้ใช่หรือไม่!!')) location.href='?id=<?=$id?>&no=<?=$rs[no]?>&action=delete';">
		<img src="../../../images_sys/b_drop.png" alt="ลบรูปภาพ" border="0" width="16" height="16"></a>
<?
		}#End IF เปิดให้ใช้เฉพาะเจ้าหน้าที่เขตและไม่ใช่พนักบันทึกข้อมูล
	}
?>
	</td>
</tr>
<tr bgcolor="#f8f8f8">
	<td height="150" colspan="2">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr valign="top" bgcolor="#f8f8f8">
  	<td>
<?
	if($n==$maxid){
?>	
<table width="98%" border="0" align="center" cellpadding="2"  cellspacing="0" class="pic_active">
<tr align="center">
	<td><?=$pic?></td>
</tr>
<tr>
	<td height="20" align="center"><?=$yy?></td>
</tr>
</table>	
<?
}else{
?>
<table width="98%" border="0" align="center" cellpadding="2"  cellspacing="0" class="pic_deactive">
<tr align="center">
	<td><?=$pic?></td>
</tr>
<tr height="25">
	<td height="20" align="center"><?=$yy?></td>
</tr>
</table>	
<?
	}
?>	</td>
</tr>
<tr align="right">
	<td height="15" align="center">	
		<? 
		if($rs[kp7_active]=="1"){
			echo "<font color='green'><b>แสดงใน ก.พ. 7 </b></font>";
		}else{
			echo "";
		}
	?>	</td>
</tr>
</table>	</td>
</tr>
</table>
<br /></td>
<?	      
} // end while
if ($n % 3 == 1){ echo "</tr>"; }
} else {
	echo "<tr align=\"center\"><td height=\"25\">ไม่มีข้อมูล</td></tr>";
}
?>
<tr>
  <td align="center" valign="top">  </td>
</table>	</td>
    <td align="left" valign="top" style="border-left:1px solid #DADAE1; padding:10px">
	<?
		if($dis_menu){
		echo "";
		}else{
	?>
	  <table width="100%" border="0" cellspacing="3" cellpadding="2">
        <tr>
          <td><a href="#" onclick="popWindow('pic_history_add.php?id=<?=$id?>','670','660'),deltemp('<?php echo base64_encode($folder_img.$id) ?>')"><font color="#003399"><img src="images/photo_portrait.gif" width="16" height="16"  border="0" align="absmiddle" />เพิ่มข้อมูลภาพ</font></a></td>
        </tr>
        <tr>
          <td><a href="pic_history.php?act=ChangRows"><font color="#003399"><img src="images/preferences.gif" width="16" height="16"  border="0" align="absmiddle"/>กำหนดลำดับภาพในเอกสาร ก.พ. 7</font></a></td>
        </tr>
        <? if($_SESSION['session_staffid'] != "" and $num_r > 0){
				$sql_error = "SELECT type_problem,status_problem FROM pic_check_problem WHERE idcard='$id'";
				$result_error = mysql_db_query(DB_CHECKLIST,$sql_error);
				$numerror = @mysql_num_rows($result_error);
				$rs_error = mysql_fetch_assoc($result_error);
			
			?>
        <tr>
          <td>&nbsp;<a href="#" onclick="popWindow('pic_check_problem.php?id=<?=$id?>&xstaffid=<?=$_SESSION['session_staffid']?>','450','350')"> ตรวจสอบความถูกต้องของรูป</a> <? if($numerror > 0){  if($rs_error[status_problem] == 0 and $rs_error[type_problem] != 1){echo "&nbsp;<img src=\"images/web/alert.gif\" width=\"16\" height=\"17\" border=\"0\" alt='มีการบันทึกข้อผิดพลาดแล้ว'>";}else{ echo "<img src=\"../../../images_sys/approve20.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"ปัญหาถูกแก้ไขแล้ว\">";}}else{ echo "";}?></td>
        </tr>
        <?
		}//end  if($_SESSION['session_staffid'] != ""){
		?>
      </table>
	  <?
	  }
	  ?>
	  <!--<a href="general.php?id=<?=$id?>&action=edit"><font color="#003399">- ออกจากคลังรูปภาพ</font></a> pic_check_problem.php --></td>
</tr>
<tr>
  <td colspan="2" align="left" height="39" style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#ffffff', EndColorStr='#F4F4F4'); padding:2px"><? include("../../../config/licence_inc.php");?></td>
  </tr>
</table>
<?
	}
?>
</form>
<?
if($act=="ChangRows"){
?>
<form name="form1" method="post" action="?">
 
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="0"  class="main_table" >
<?
$sql 		= " SELECT prename_th, name_th, surname_th, idcard, birthday, position_now, subminis_now FROM `general` where id='$id'; "; 
$result 	= mysql_db_query($dbname,$sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
$rs 		= mysql_fetch_assoc($result) ; 
?>
<tr align="left" bgcolor="#f8f8f8">
  <td height="20" bgcolor="#f8f8f8" class="label1">&nbsp;<strong>คลังข้อมูลภาพ&nbsp;:</strong>
      <?=$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]?>
      <br />
    &nbsp;<strong><?=TEXT_IDCARD?>&nbsp;: </strong>
    <?=$rs[idcard]?></td>
  <td width="250" bgcolor="#f8f8f8" class="label1">&nbsp;</td>
</tr>
<tr >
	<td align="left">
<table width="250" border="0" cellpadding="3" cellspacing="0">
<?

$xsql="select max(no) as maxno from general_pic where id='$id'";
$xresult=mysql_query($xsql);
$xrs=mysql_fetch_array($xresult);
$maxid=$xrs[maxno];

	$n = 0;
	$i=0;
$sql		= " select * from `general_pic` where id='$id' order by no asc";
$result	= mysql_query($sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
$num_r=mysql_num_rows($result);
$yy_max=max($num_r);

		if($num_r >= 1){
				while($rs = mysql_fetch_assoc($result)){
				$i++;
					if($n == 0){ echo "<tr>"; } elseif($n % 4 == 0){ echo "</tr><tr>"; }		
					if($rs[imgname] != ""){
						$pic	= "<img src=\"".$folder_img.$rs[imgname]."\"  width=120 height=160  border=\"0\">";
					}else{
						$pic	 = "<img src=\"../../../images_sys/noimage.jpg\" width=\"120\" height=\"160\" border=\"0\" title=\"ยังไม่มีไฟล์รูปภาพ\">";	
					}
						if($rs[label_yy] != ""){
							$yy = " พ.ศ.".str_replace("พ.ศ.","",$rs[label_yy]);
						}else if($rs[yy] > 0){
							$yy = " พ.ศ. $rs[yy]";
						}else{
							$yy = "";	
						}
					
					$n++;	

?>
<td valign="top">
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="3" style="border:1px solid #C9C9C9;">
<tr bgcolor="#f8f8f8">
  <td height="20" align="left" bgcolor="#f8f8f8">
    <select name="runno[]">
  			<?
			for($e=1;$e<=$num_r;$e++){
				$selected = ($e == $i) ? " selected " : "" ;
				echo "<option value=\"".$e."\" ".$selected.">".$e."</option>";
					}
			?>	
      </select></td>
 <input type="hidden" name="no[]" value="<?=$rs[no]?>">
 <input type="hidden" name="imgname[]" value="<?=$rs[imgname]?>" >
 <input type="hidden" name="flagimgnull[]" value="<?=$rs[flag_imgnull]?>">
  </tr>
<tr bgcolor="#f8f8f8">
	<td height="150">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr valign="top" bgcolor="#f8f8f8">
  	<td>
<?
	if($n==$maxid){
?>	
<table width="98%" border="0" align="center" cellpadding="2"  cellspacing="0" class="pic_active" >
<tr align="center">
	<td><?=$pic?></td>
</tr>
<tr>
	<td height="20" align="center"><?=$yy?></td>
</tr>
</table>	
<?
}else{
?>
<table width="98%" border="0" align="center" cellpadding="2"  cellspacing="0" class="pic_deactive">
<tr align="center">
	<td><?=$pic?></td>
</tr>
<tr height="25">
	<td height="20" align="center"><?=$yy?></td>
</tr>
</table>	
<?
	}
?>	</td>
</tr>
<tr align="right">
	<td height="15" align="center">	
		<? 
		if($rs[kp7_active]=="1"){
			echo "<font color='green'><b>แสดงใน ก.พ. 7 </b></font>";
		}else{
			echo "";
		}
	?>	</td>
</tr>
</table>	</td>
</tr>
</table>
<br /></td>
<?	      
} // end while
if ($n % 3 == 1){ echo "</tr>"; }
} else {
	echo "<tr align=\"center\"><td height=\"25\">ไม่มีข้อมูล</td></tr>";
}
?>
<tr>
  <td align="center" valign="top">  </td>
</table>	</td>
    <td>&nbsp;</td>
</tr>
<tr bgcolor="#ffffff">
  <td colspan="2" align="center">
  <input type="submit" name="submit" value="บันทึกการเรียงลำดับการแสดงผลใน ก.พ. 7" />
   <input name="action" type="hidden" id="action" value="ChangR" /></td>
  </tr>
<tr bgcolor="#F4F4F4">
  <td height="39" colspan="2" style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#ffffff', EndColorStr='#F4F4F4'); padding:2px"><? include("../../../config/licence_inc.php");?></td>
</tr>
</table>
</form>
<?
}
?>
</body>

</html>





<? 
$time_end = getmicrotime(); writetime2db($time_start,$time_end); 

function get_picture($id){
	
	global $folder_img;	
	$ext_array	= array("jpg","jpeg","png","gif");
	if ($id <= "") return "";

		for ($i=0;$i<count($ext_array);$i++){
			$img_file = $folder_img . $id . "." . $ext_array[$i];
			if(file_exists($img_file)) return $img_file;
		}

	return "";
}
function deletedir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir") 
           deletedir($dir."/".$object); 
        else unlink   ($dir."/".$object);
      }
    }
    reset($objects);
    rmdir($dir);
  }
 }
?>
<script>
function deltemp(val){
	var url ='ajax_del.php?dir='+val;
$.get(url,function(data){

});
}

</script>