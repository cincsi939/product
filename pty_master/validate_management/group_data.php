<?
$ApplicationName= "salary_management";
$module_code = "tree salary";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= false; // 
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090819.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-08-19 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090819.002
	## Modified Detail :		ระบบสร้างฝังเงินเดือน
	## Modified Date :		2009-08-19 09:49
	## Modified By :		MR.SUWAT KHAMTUM
session_start();

include("validate.inc.php");
include("function.php");


function CheckDataList($get_checkdata_id){
	global $db_name;
	$sql_list = "SELECT * FROM validate_checkdata WHERE checkdata_id= '$get_checkdata_id' LIMIT 1";
	///echo $sql_list;
	$result_list = mysql_db_query($db_name,$sql_list);
	$NUMCK = @mysql_num_rows($result_list);
	return $NUMCK;
}

function CheckGroupData($get_parent){
	global $db_name;
	$sql_group = "SELECT count(checkdata_id) as num_1 FROM validate_datagroup WHERE checkdata_id='$get_parent' and mistaken_id = '0'";
	//echo $sql_group;
	$result_group = mysql_db_query($db_name,$sql_group);
	$rs_g = mysql_fetch_assoc($result_group);
	return $rs_g[num_1];
}//end 


if ($_SERVER[REQUEST_METHOD] == "POST"){ 
//echo "<pre>";
//print_r($_POST);die;

	## บันทึกรายการ
	if($action == "ADD"){
		$sql_insert = "INSERT INTO validate_datagroup SET dataname='$dataname', mistaken_id='$mistaken_id', parent_id='$parent_id',status_active='1', level_id='$level_id'";
		$result_insert = mysql_db_query($db_name,$sql_insert);
		$last_id = mysql_insert_id();
		
			if(count($sub_group) > 0){
				foreach($sub_group as $key1 => $val1){
					$sql_update_parent = "UPDATE validate_datagroup SET parent_id='$last_id' where checkdata_id='$key1'";
					mysql_db_query($db_name,$sql_update_parent);	
				}//end foreach($sub_group as $key1 => $val1){	
			}//end if(count($sub_group) > 0){
		if($result_insert){
				echo "<script>alert('บันทึกรายการเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?action=$Aaction&parent_id=$parent_id&xtitle=$xtitle&level_id=$level_id';</script>";
		}else{
				echo "<script>alert('ไม่สามารถบันทึกรายการได้'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?action=$Aaction&parent_id=$parent_id&xtitle=$xtitle&level_id=$level_id';</script>";
		}
		
	}//end if($action == "ADD"){
	###  แก้ไขรายการ
	if($action == "EDIT"){
			$sql_edit = "UPDATE validate_datagroup SET dataname='$dataname',mistaken_id='$mistaken_id', parent_id='$parent_id'  WHERE checkdata_id='$checkdata_id'";
			//echo $sql_edit."<br>";
			$result_edit = mysql_db_query($db_name,$sql_edit);
			//$sel_chek1 = "SELECT * FROM validate_datagroup WHERE parent_id='$checkdata_id' ";
//			echo $sel_chek1;die;
			$sql_update1 = "UPDATE validate_datagroup SET parent_id='$parent_id' WHERE parent_id='$checkdata_id'";
			mysql_db_query($db_name,$sql_update1);
		
		if(count($sub_group) > 0){
				foreach($sub_group as $key1 => $val1){
					$sql_update_parent = "UPDATE validate_datagroup SET parent_id='$checkdata_id' where checkdata_id='$key1'";
					mysql_db_query($db_name,$sql_update_parent);	
				}//end foreach($sub_group as $key1 => $val1){	
			}//end if(count($sub_group) > 0){
				//echo "<br>end ".die;
			if($result_edit){
					echo "<script>alert('แก้ไขรายการเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?action=$Aaction&parent_id=$parent_id&xtitle=$xtitle&level_id=$level_id';</script>";
			}else{
					echo "<script>alert('ไม่สามารถแก้ไขรายการได้'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?action=$Aaction&parent_id=$parent_id&xtitle=$xtitle&level_id=$level_id';</script>";
			}
	}//end if($action == "EDIT"){
	
}// end if ($_SERVER[REQUEST_METHOD] == "POST"){ 
#########  กรณีลบรายการ
if($action == "DEL"){
		$sql_check_del = "SELECT COUNT(parent_id) AS num_del FROM validate_datagroup WHERE parent_id='$checkdata_id'";
		$result_check_del = mysql_db_query($db_name,$sql_check_del);
		$rs_del = mysql_fetch_assoc($result_check_del);
		if($rs_del[num_del] > 0){
			echo "<script>alert('ไม่สามารถลบรายการได้ เนื่องจากมีรายการหมวดย่อยอยู่'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?action=$Aaction&parent_id=$parent_id&xtitle=$xtitle&level_id=$level_id';</script>";
		}else{
			
			$sql_del = "DELETE FROM validate_datagroup WHERE checkdata_id='$checkdata_id'";
			$result_del = mysql_db_query($db_name,$sql_del);
			if($result_del){
				echo "<script>alert('ลบรายการเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?action=$Aaction&parent_id=$parent_id&xtitle=$xtitle&level_id=$level_id';</script>";
			}else{
				echo "<script>alert('ไม่สามารถลบรายการได้'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='?action=$Aaction&parent_id=$parent_id&xtitle=$xtitle&level_id=$level_id';</script>";
			}
		}//end 
					
}//end if($action == "DEL"){





################  

?>


<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language='javascript' src='../../common/popcalendar.js'></script>
<script language="javascript" src="ajax.js"></script>
<script language="javascript">
function confirmDelete(delUrl) {
  if (confirm("!คุณแน่ใจที่จะลบข้อมูลจริงหรือไม่")) {
    document.location = delUrl;
  }
}

function CheckForm(){
	if(document.form1.dataname.value == ""){
			alert("กรุณาระบุหมวดรายการตรวจสอบข้อมูล");
			document.form1.dataname.focus();
			return false;
	}else if(document.form1.mistaken_id.value == ""){
			alert("กรุณาระบุประเภทของปัญหา");
			document.form1.mistaken_id.focus();
			return false;
	}
	return true;
}




//function ValidateCheck(form){
	
	/*if (!document.form1.sex[0].checked && !document.form1.sex[1].checked){
	
	
	alert("Please Select Sex"); return false;}
	
	var total=""
	for(var i=0; i < document.form1.scripts.length; i++){
	if(document.form1.scripts[i].checked)
	total +=document.form1.scripts[i].value + "\n"
	}
	if(total==""){
	alert("Please select scripts")
	}
	else
	alert ("Checkboxes you have selected are: "+"\n"+total)
	
	return false;
	*/
//}
</script>



</head>
<body><br>
<table width="98%" border="0" align="right" cellpadding="0" cellspacing="0">
<?
	if($action == "view" or $action == "view_detail"){
		if($action == "view"){
			$sql_data = "SELECT * FROM validate_datagroup  WHERE parent_id='0' order by checkdata_id  ASC";
			$xtitle = "หมวดรายการหลักตรวจสอบข้อมูล";
			$parent_id = 0;
		}else if($action == "view_detail"){

			$sql_data = "SELECT * FROM validate_datagroup  WHERE parent_id='$parent_id' order by checkdata_id  ASC";
			$xtitle = "".$xtitle;
			$parent_id = $parent_id;
		}
	
?>

  <tr>
    <td bgcolor="#999999"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" class="index1 style1"><img src="images/application_side_tree.png" width="16" height="16">&nbsp;<b><?=$xtitle?></b></td>
        </tr>
      <tr>
        <td width="6%" align="center" class="index1"><span class="style1"><strong>ลำดับ</strong></span></td>
        <td width="54%" align="center" class="index1"><strong>หมวดรายการ</strong></td>
        <td width="28%" align="center" class="index1"><span class="style1"><strong>ประเภทปัญหา</strong></span></td>
        <td width="12%" align="center" class="index1"><img src="images/department_add.gif" alt="เพิ่มข้อมูล" width="20" height="20" border="0" onClick="location.href='?action=ADD&parent_id=<?=$parent_id?>&Aaction=<?=$action?>&xtitle=<?=$xtitle?>&level_id=<?=$level_id?>'" style="cursor:hand"></td>
      </tr>
	  <?
	$result_data = mysql_db_query($db_name,$sql_data);
	$i=0;
	while($rs_r = mysql_fetch_assoc($result_data)){
		if($i % 2){ $bg="#FFFFFF"; }else{ $bg = "#F0F0F0";}$i++;
		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs_r[dataname]?></td>
        <td align="left"><?=GetTypeMistaken($rs_r[mistaken_id]);?></td>
        <td align="center"><a href="?action=EDIT&checkdata_id=<?=$rs_r[checkdata_id]?>&Aaction=<?=$action?>&parent_id=<?=$parent_id?>&xtitle=<?=$xtitle?>&level_id=<?=$level_id?>"><img src="../../images_sys/b_edit.png" width="16" height="16" border="0" alt="แก้ไขข้อมูล <?=$rs_r[dataname]?>"></a>&nbsp;&nbsp;<? if(CheckDataList($rs_r[checkdata_id]) < 1){?><a href="#" onClick="confirmDelete('group_data.php?action=DEL&checkdata_id=<?=$rs_r[checkdata_id]?>&Aaction=<?=$action?>&parent_id=<?=$parent_id?>&xtitle=<?=$xtitle?>')"><img src="../../images_sys/b_drop.png" width="16" height="16" border="0" alt="ลบข้อมูล <?=$rs_r[dataname]?>"></a><? } else{ echo "";}?></td>
      </tr>
	  <?
	  	}// end while($rs_p = mysql_fetch_assoc($result_profile)){
	  ?>
    </table></td>
  </tr>
 <?
  } //end 	if($action == "view"){
  ?>

  <?
  	if($action == "ADD" or $action == "EDIT"){
		if($action == "EDIT"){
				$sql_e = "SELECT * FROM validate_datagroup where checkdata_id='$checkdata_id' ";
				$result_e = mysql_db_query($db_name,$sql_e);
				$rs_e = mysql_fetch_assoc($result_e);
				$Axtitle = "ฟอร์มแก้ไขหมวดหลักรายการตรวจสอบข้อมูล";
		}else{
				$Axtitle = "ฟอร์มบันทึกหมวดหลักรายการตรวจสอบข้อมูล";
		}
		if($level_id == 1){ $h_title = "กลุ่มปัญหาการคีย์ข้อมูล";}else{ $h_title = "หมวดรายการตรวจสอบข้อมูล";}
  ?>
  <form name="form1" method="post" action="?" onSubmit="return CheckForm();">
    <tr>
      <td height="20" bgcolor="#999999"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="2" align="left" bgcolor="#B7CBCF"><span class="index1 style1"><img src="images/application_form.png" width="16" height="16" border="0"><?=$Axtitle?></span></td>
          </tr>
 <tr>
          <td width="34%" align="right" bgcolor="#FFFFFF"><strong><?=$h_title?> : </strong></td>
          <td width="66%" align="left" bgcolor="#FFFFFF"><label>
            <input name="dataname" type="text" id="dataname" size="30" value="<?=$rs_e[dataname]?>">
          &nbsp;&nbsp;</label><!--<a href="group_data.php?checkdata_id=<?=$checkdata_id?>&action=<?=$action?>&xtitle=<?=$xtitle?>&parent_id=<?=$parent_id?>&level_id=2&Aaction=view_detail&xtype_group=T2">จัดกลุ่ม</a>--></td>
        </tr>
        <?
				//echo "<pre>";
				//print_r($_GET);

		
		if($level_id > 1 ){?>
        <tr>
          <td align="right" valign="top" bgcolor="#FFFFFF"><strong>หมวดรายการปัญหา : </strong></td>
          <td align="left" bgcolor="#FFFFFF">
		      <select name="mistaken_id" id="mistaken_id">
              <option value="">ระบุหมวดปัญหา</option>
              <?
              	$sql1 = "SELECT * FROM validate_mistaken ORDER BY mistaken_id ASC";
				$result1 = mysql_db_query($db_name,$sql1);
				while($rs1 = mysql_fetch_assoc($result1)){
						if($rs_e[mistaken_id] == $rs1[mistaken_id]){ $chk = "selected='selected'";}else{ $chk = "";}	
						echo "<option value='$rs1[mistaken_id]' $chk>$rs1[mistaken]</option>";
				}//end while($rs1 = mysql_fetch_assoc($result1)){
			  ?>
		        </select>
	      </td>
        </tr>
        <? }else{ // กรณีเลือกเป็นกลุ่มคำสั่งให้สามารถเลือกกลุ่มย่อยที่อยุ่ข้างในกลุ่มได้
	
		if($action == "ADD"){ $con_sub = " ";}else{ $con_sub = " or parent_id='$checkdata_id' ";}

				echo "<tr>
				<td align=\"right\" valign=\"top\" bgcolor=\"#FFFFFF\">เลือกรายการย่อย :</td>
				<td> <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
				$sql_sub = "SELECT * FROM validate_datagroup WHERE parent_id='$parent_id'  $con_sub order by checkdata_id ASC";
				//echo $sql_sub."<br>";
				$result_sub = mysql_db_query($db_name,$sql_sub);
				$i=0;
				while($rss1 = mysql_fetch_assoc($result_sub)){
					if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
					$sql_checksub = "SELECT COUNT(parent_id) AS numList FROM validate_datagroup WHERE parent_id='$checkdata_id' and checkdata_id='$rss1[checkdata_id]'";
					//echo $sql_checksub."<br>";
					$result_checksub = mysql_db_query($db_name,$sql_checksub);
					$rs_checksub = mysql_fetch_assoc($result_checksub);
						if($rs_checksub[numList] > 0){ $chk2 = " checked='checked'";}else{ $chk2 = "";}
						echo "<tr bgcolor='$bg'><td>";
						echo " <input type='checkbox' name='sub_group[$rss1[checkdata_id]]' $chk2> $rss1[dataname] <br>";
						echo "</td><tr>";
				}//end while($rss1 = mysql_fetch_assoc($result_sub)){
				echo "</table></td></tr>";
					
		} //end  if($level_id > 1){ ?>
        <tr>
          <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
          <td align="left" bgcolor="#FFFFFF"><label>
          <? //echo "parent :: ".$parent_id; ?>
          <input type="hidden" name="parent_id" value="<?=$parent_id?>">
          <input type="hidden" name="xtitle" value="<?=$xtitle?>">
		  <?
		  if($action == "EDIT"){
		  		echo "<input type='hidden' name='checkdata_id' value='$rs_e[checkdata_id]'>";
		  }else if($level_id > 1){
				  echo "<input type='hidden' name='checkdata_id' value='$checkdata_id'>";
			}
		  ?>
		  <input type="hidden" name="Aaction" value="<?=$Aaction?>">
           <input type="hidden" name="action" value="<?=$action?>">
           <input type="hidden" name="level_id" value="<?=$level_id?>">
            <input type="submit" name="Submit" value="บันทึก">
            <input type="reset" name="Submit2" value="ล้างค่า">
          </label></td>
        </tr>

      </table></td>
    </tr>
	</form>
<?
	} //end   	if($action == "ADD"){
?>

</table>

</BODY>
</HTML>