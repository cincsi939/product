<?php
session_start();
include("../../../common/common_competency.inc.php");
require_once("../../../config/conndb_nonsession.inc.php");
$title_profile = "โปรไฟล์สิทธิการเข้าใช้งานระบบบันทึกข้อมูล (userentry) ";
if($action == ""){
	$action = "all";
}
if($gid == ""){
	$gid = "all";
}

function getGroup($staffid){
	global $dbnameuse;
	$sql_group = "SELECT
							keystaff.staffid,
							keystaff_group.groupkey_id,
							keystaff_group.groupname
							FROM
							keystaff
							INNER JOIN keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id
							WHERE keystaff.staffid='".$staffid."'";
	$query_g = mysql_db_query($dbnameuse,$sql_group) or die(mysql_error()."$sql_group<br>LINE::".__LINE__);
	$rs_g = mysql_fetch_assoc($query_g);
	return $rs_g[groupname];
}
function getProfile($profile_id){
	global $dbnameuse;
	$sql = "SELECT * FROM authority_profile WHERE profile_id = '".$profile_id."'";
	$query = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."SQL : ".$sql);
	$rs = mysql_fetch_assoc($query);
	return $rs[profile_name];
}

function getStaffID($groupid){
	global $dbnameuse;
	$sql = "SELECT staffid FROM keystaff WHERE keyin_group = '".$groupid."'";
	$query = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."SQL : ".$sql);
	$arr_data = array();
	$i = 0;
	while($rs = mysql_fetch_assoc($query)){
		$arr_data[$i] = $rs[staffid]; 
		$i++;
	}
	return $arr_data;
}

if($_SERVER['REQUEST_METHOD'] == "GET"){
	####  ลบรายการ
	if($action == "all" and $mode == "Del"){
		//$check_detail = CountGroupEdit($period_master_id);
		if($data > 0){
				echo "<script>alert('ไม่สามารถลบรายการได้เนื่องจากมีข้อมูลในการกำหนดการใช้งานของผู้ใช้แล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='management_profile.php?action=all&mode=';</script>";
		}else{
			$sql_del = "DELETE FROM  authority_profile WHERE profile_id='".$profile_id."' ";	
			$query_del = mysql_db_query($dbnameuse,$sql_del) or die(mysql_error()."$sql_del<br>LINE::".__LINE__);
			if($query_del){
				echo "<script>alert('ลบรายการเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='management_profile.php?action=all&mode=';</script>";	
			}else{
				echo "<script>alert('ไม่สามารถลบรายการเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='management_profile.php?action=all&mode=';</script>";	
			}
		}
	}// end 	if($action == "all" and $mode == "Del"){
	## end ลบรายการ
}// end if($_SERVER['REQUEST_METHOD'] == "GET"){

if($_SERVER['REQUEST_METHOD'] == "POST"){
	#### แก้ไขโปรไฟล์
	if($action == "all" and $xmode == "Edit"){	
		$sql_update = "UPDATE authority_profile SET profile_name='".$profilename."',profile_active='".$profile_active."' ,timeupdate = NOW() WHERE profile_id='".$profile_id."' ";
		//echo $sql_update;
		//exit;
		$query_update = mysql_db_query($dbnameuse,$sql_update) or die(mysql_error()."$sql_update<br>LINE::".__LINE__);
		if($query_update){
			echo "<script>alert('แก้ไขรายการเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='management_profile.php?action=all&mode=';</script>";		
		}else{
			echo "<script>alert('ไม่สามารถแก้ไขรายการได้'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='management_profile.php?action=all&mode=';</script>";		
		}// end if($result_edit){
	
	}//end if($action == "all" and $mode == "Edit"){	
	#### end แก้ไขโปรไฟล์
	
	### เพิ่มโปรไฟล์
	if($action == "all" and $xmode == "Add"){	
		$sql_insert = "INSERT INTO authority_profile SET profile_name='".$profilename."', profile_active='".$profile_active."', timeupdate=NOW()";
		$query_insert = mysql_db_query($dbnameuse,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE::".__LINE__);
		if($query_insert){
			echo "<script>alert('บันทึกรายการเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='management_profile.php?action=all&mode=';</script>";		
		}else{
			echo "<script>alert('ไม่สามารถบันทึกรายการได้'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='management_profile.php?action=all&mode=';</script>";		
		}
	
	}//end if($action == "all" and $xmode == "Add"){	
	### end เพิ่มโปรไฟล์
	
	### แก้ไขกลุ่มการเข้าใช้งาน
	if($action == "all" and $xmode == "Edit_g"){
		//$xmode&profile_id=$profile_id&gid=$gid
		$msg_true = "<script>alert('บันทึกรายการเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='management_profile.php?action=all&mode=';</script>";
		$msg_false = "<script>alert('ไม่สามารถบันทึกรายการได้'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='management_profile.php?action=all&mode=';</script>";
		$countChk = count($chkGroup);
		if($gid == "all"){  // แสดงรายชื่อทั้งหมด
			if($countChk > 0){  // กรณีที่มีการเลือก check box
				$sql_del = "DELETE FROM  authority_math_profile WHERE profile_id='".$profile_id."' ";
				$query_del = mysql_db_query($dbnameuse,$sql_del) or die(mysql_error()."$sql_del<br>LINE::".__LINE__);
				for($i = 0; $i < $countChk; $i++){
					$sql_insert = "INSERT INTO authority_math_profile SET profile_id = '".$profile_id."',staffid = '".$chkGroup[$i]."', timeupdate = NOW()";
					$query_insert = mysql_db_query($dbnameuse,$sql_insert);
				}
				if($query_insert){
					echo $msg_true;		
				}// end if($query_update){
				else{
					echo $msg_false;	
				}// else
			}// end  if($countChk > 0){  // กรณีที่มีการเลือก check box
			else{// กรณีที่ไม่เลือก check box ทั้งหมด
				$sql_del = "DELETE FROM  authority_math_profile WHERE profile_id='".$profile_id."'";	
				$query_del = mysql_db_query($dbnameuse,$sql_del) or die(mysql_error()."$sql_del<br>LINE::".__LINE__);
				if($query_del){
					echo $msg_true;	
				}else{
					echo $msg_false;	
				}
			}  // end  else{// กรณีที่ไม่เลือก check box ทั้งหมด
		}// end   if($gid == "all"){
		else{  //  กรณีเลือกเฉพาะกลุ่มพนักงาน
			$arr_staffid = getStaffID($gid);
			$count_staffid = count($arr_staffid);
			if($countChk > 0){  // กรณีที่มีการเลือก check box
				for($i = 0; $i < $count_staffid; $i++){
					$sql_del = "DELETE FROM  authority_math_profile WHERE profile_id='".$profile_id."' AND staffid = '".$arr_staffid[$i]."' ";
					$query_del = mysql_db_query($dbnameuse,$sql_del) or die(mysql_error()."$sql_del<br>LINE::".__LINE__);
				}
				for($a = 0; $a < $countChk; $a++){
					$sql_insert = "INSERT INTO authority_math_profile SET profile_id = '".$profile_id."',staffid = '".$chkGroup[$a]."', timeupdate = NOW()";
					$query_insert = mysql_db_query($dbnameuse,$sql_insert);
				}
				if($query_insert){
					echo $msg_true;		
				}// end if($query_update){  
				else{
					echo $msg_false;	
				}// else
			}// end  if($countChk > 0){  // กรณีที่มีการเลือก check box
			else{// กรณีที่ไม่เลือก check box ทั้งหมด
				for($i = 0; $i < $count_staffid; $i++){
					$sql_del = "DELETE FROM  authority_math_profile WHERE profile_id='".$profile_id."' AND staffid = '".$arr_staffid[$i]."' ";	
					//echo "<br>".$sql_del."<br>";
					$query_del = mysql_db_query($dbnameuse,$sql_del) or die(mysql_error()."$sql_del<br>LINE::".__LINE__);
				}
				//exit;
				if($query_del){
					echo $msg_true;	
				}else{
					echo $msg_false;	
				}
			}  // end  else{// กรณีที่ไม่เลือก check box ทั้งหมด
		}
		
		exit;
	}  // end  if($action == "all" and $xmode == "Edit_g"){
	## end แก้ไขกลุ่มการเข้าใช้งาน
} //end  if($_SERVER['REQUEST_METHOD'] == "POST"){
?>
<html>
<head>
<title><?=$title_profile?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" type="text/javascript">
function ChF1(){
	if(document.form1.profilename.value == ""){
			alert("กรุณาระบุชื่อโปรไฟล์");
			document.form1.profilename.focus();
			return false;
	}
}
function ConfirmListDel(delUrl) {
  if (confirm("คุณแน่ใจที่จะลบข้อมูลใช่หรือไม่?")) {
    document.location = delUrl;
  }
}

function ClickCheckAll(vol){
	var i=1;
	for(i=1;i<=document.frmMain.hdnCount.value;i++){
		if(vol.checked == true){
			eval("document.frmMain.chkGroup"+i+".checked=true");
		}
		else{
			eval("document.frmMain.chkGroup"+i+".checked=false");
		}
	}
}

function refreshproductList(profileid) {
   var gid = document.getElementById("sel_group").value;
    if(gid == "" ) {
		var url = "management_profile.php?action=all&mode=Edit_g&profile_id="+profileid;				
    	document.location = url;
    }
	else{
		var url = "management_profile.php?action=all&mode=Edit_g&profile_id="+profileid+"&gid="+gid;
    	document.location = url;
	}	
}
</script>

</head>
<body bgcolor="#EFEFFF">
<?
if($action == "all"){
?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
<?
	if($mode == ""){
?>
      <tr>
        <td bgcolor="#000000"><table width="100%" cellpadding="2" cellspacing="1">
          <tr>
            <td colspan="5" align="left" bgcolor="#A5B2CE" height="28px"><strong><?=$title_profile?></strong></td>
            </tr>
          <tr>
            <td width="10%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
            <td width="26%" align="center" bgcolor="#A5B2CE"><strong>ชื่อโปรไฟล์</strong></td>
            <td width="10%" align="center" bgcolor="#A5B2CE"><strong>จำนวนพนักงาน(ราย)</strong></td>
            <td width="20%" align="center" bgcolor="#A5B2CE"><strong>สถานะการใช้งาน</strong></td>
            <td width="10%" align="center" bgcolor="#A5B2CE">
                <input type="button" name="AddP" value="เพิ่มรายการ" onClick="location.href='?action=all&mode=Add'" >
            </td>
          </tr>
    <? 
        $sql = "SELECT * FROM authority_profile ORDER BY profile_id ASC";
        $query = mysql_db_query($dbnameuse,$sql) or die(mysql_error());
        $i=0;
        while($rs = mysql_fetch_assoc($query)){
            if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
            $sql_count = "SELECT COUNT(profile_id) AS num1  FROM authority_math_profile WHERE profile_id = '".$rs[profile_id]."'  GROUP BY profile_id";
            $query_c = mysql_db_query($dbnameuse,$sql_count);
            $rs_c = mysql_fetch_assoc($query_c);
    ?>
          <tr bgcolor="<?=$bg?>">
            <td align="center"><?=$i?></td>
            <td align="left"><?=$rs[profile_name]?></td>
            <td align="center">
<? 
	if($rs_c[num1] > 0){ 
		echo "<a href=\"?action=all&mode=view_report&profile_id=$rs[profile_id]\">".$rs_c[num1]."</a>";
		$dis = "";
	}
	else{ 
		echo "0";
	}?>
    		</td>
            <td align="center">
<? 
	if($rs[profile_active] == "1"){ 
		echo '<img src="../../../images/images_sys/approve20.png" width="16" height="16" border="0" alt="ใช้งาน">';
		}
	else{ echo '<img src="../../../images/images_sys/unapprove.png" width="16" height="16" border="0" alt="ไม่ใช้งาน">';
	} 
?>
			</td>
            <td align="center">
                <a href="management_profile.php?action=all&mode=Edit&profileid=<?=$rs[profile_id]?>"><img src="../../../images_sys/b_edit.png" width="16" height="16" title="แก้ไขรายการ" border="0"></a> &nbsp;
                <a href="#" onClick="return ConfirmListDel('?action=all&mode=Del&profile_id=<?=$rs[profile_id]?>&data=<?=$rs_c[num1]?>');"><img src="../../../images_sys/b_drop.png" width="16" height="16" title="ลบรายการ" border="0"></a> &nbsp;
                <a href="management_profile.php?action=all&mode=Edit_g&profile_id=<?=$rs[profile_id]?>&gid="><img src="../../../images/images_sys/edit.gif" width="16" height="16" border="0" title="ข้อมูลพนักงาน"></a>
            </td>
          </tr>
          <?
            }// end while
          ?>
        </table></td>
      </tr>
    </table>
      <?
    }//end if($mode == ""){
	
	if($mode == 'view_report'){
/*		$sql = "SELECT * FROM authority_profile WHERE profile_id = '".$profile_id."'";
		$query = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."SQL : ".$sql);
		$rs = mysql_fetch_assoc($query)*/
	?>
		<tr>
			<td bgcolor="#000000">
				<table width="100%" cellpadding="2" cellspacing="1">
					<tr>
						<td colspan="3" align="left" bgcolor="#A5B2CE" >
                        	<a href="?action=all&mode="><img src="../../../images_sys/home.gif" width="20" height="20" border="0" title="ย้อนกลับ" ></a><strong>รายงานพนักงานในการเข้าใช้งานระบบในโปรไฟล์ <?=getProfile($profile_id)?></strong>
                       	</td>
					</tr>
					<tr height="28px">
						<td width="10%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
						<td width="26%" align="center" bgcolor="#A5B2CE"><strong>ชื่อ-นามสกุล</strong></td>
						<td width="10%" align="center" bgcolor="#A5B2CE"><strong>กลุ่มพนักงาน</strong></td>
					</tr>     
	<?php
		$sql_view = "SELECT
							authority_math_profile.profile_id,
							authority_math_profile.staffid,
							keystaff.staffname,
							keystaff.staffsurname
							FROM keystaff
							INNER JOIN authority_math_profile ON keystaff.staffid = authority_math_profile.staffid
							WHERE authority_math_profile.profile_id = '".$profile_id."'";
		$query_v = mysql_db_query($dbnameuse,$sql_view) or die(mysql_error()."SQL : ".$sql_view);
		$i = 0;
		while($rs_v = mysql_fetch_assoc($query_v)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
	?>
					<tr bgcolor="<?=$bg?>" height="28px">
						<td align="center"><?=$i?></td>
						<td align="left"><?php echo $rs_v[staffname]."  ".$rs_v[staffsurname]?></td>
						<td align="left"><?=getGroup($rs_v[staffid])?></td>
					</tr>
	<?php
			}
	?>
				</table>
			</td>
		</tr>

<?php
	}// end if( $mode == 'view_report'){
	
	
	if($mode == "Edit" or  $mode == "Add"){
		if($mode == "Add"){
				$title_from = "ฟอร์มเพิ่มรายการ";
				$ch1 = "checked='checked'";
				$ch2 = "";
		}else{
				$title_from = "ฟอร์มแก้ไขรายการ";
				$sql_edit = "SELECT * FROM authority_profile WHERE profile_id='".$profileid."'";
				$result_edit = mysql_db_query($dbnameuse,$sql_edit) or die("$sql_edit<br>LINE::".__LINE__);
				$rse = mysql_fetch_assoc($result_edit);
				if($rse[profile_active] == "1"){ $ch1 =  "checked='checked'"; }else{ $ch1 = "";}
				if($rse[profile_active] == "0"){ $ch2 =  "checked='checked'"; }else{ $ch2 = "";}
		}
	  ?>
	  <form name="form1" method="post" action="" onSubmit="return ChF1();">
	  <tr>
		<td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
		  <tr>
			<td colspan="2" align="left" bgcolor="#A5B2CE"><a href="?action=all&mode="><img src="../../../images_sys/home.gif" width="20" height="20" border="0" title="ย้อนกลับ" ></a> <strong><?=$title_from?>
			  </strong></td>
			</tr>
		  <tr>
			<td width="18%" align="right" bgcolor="#EFEFFF">ชื่อโปรไฟล์ : </td>
			<td width="82%" align="left" bgcolor="#EFEFFF">
			  <input name="profilename" type="text" id="profilename" size="50" value="<?=$rse[profile_name]?>"></td>
		  </tr>
		  <tr>
			<td align="right" bgcolor="#EFEFFF">สถานะการใช้งาน : </td>
			<td align="left" bgcolor="#EFEFFF"><input type="radio" name="profile_active" id="radio" value="1" <?=$ch1?>>
			  เปิดการใช้งาน
			 
				<input type="radio" name="profile_active" id="radio2" value="0" <?=$ch2?>>
				ปิดการใช้งาน
			  </td>
		  </tr>
		  <tr>
			<td align="right" bgcolor="#EFEFFF">&nbsp;</td>
			<td align="left" bgcolor="#EFEFFF"><input type="submit" name="button" id="button" value="บันทึก">
			<input type="hidden" name="profile_id" value="<?=$profileid?>">
			<input type="hidden" name="xmode" value="<?=$mode?>">
			<input type="reset" name="button2" id="button2" value="ล้างค่า"></td>
		  </tr>
		</table></td>
	  </tr>
	  </form>
	  <?
	}//end if($mode == "Edit" or  $mode == "Add"){
		
	if($mode == "Edit_g"){
		$title_from = "ฟอร์มจัดการกลุ่มการเข้าใช้งานของพนักงานบันทึกข้อมูล";
		$ch1 = "checked='checked'";
		$ch2 = "";
		
	  ?>
	<form name="frmMain" action="management_profile.php" method="post" >
	  <tr>
		<td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
		  <tr>
			<td colspan="3" align="left" bgcolor="#A5B2CE"><a href="?action=all&mode="><img src="../../../images_sys/home.gif" width="20" height="20" border="0" title="ย้อนกลับ" ></a> <strong><?=$title_from?>
			  </strong></td>
			</tr>
		  <tr>
			<td width="100%" align="left" bgcolor="#EFEFFF" colspan="3" height="28px"><strong>ชื่อโปรไฟล์ : <?=getProfile($profile_id)?></strong></td>
		  </tr>
		  <tr>
			<td align="center" bgcolor="#EFEFFF" width="20%"><strong>
         		<input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);">เลือกทั้งหมด/ไม่เลือกทั้งหมด</strong>
          	</td>
			<td align="center" bgcolor="#EFEFFF" width="40%">
            	<strong>ชื่อนามสกุลพนักงาน</strong>
           	</td>
            <td align="center" bgcolor="#EFEFFF" width="40%">
      			<select name="sel_group" id="sel_group" onChange="return refreshproductList(<?=$profile_id?>);">
              		<option value="">เลือกกลุ่มพนักงาน</option>
<?
	$sql = "SELECT * FROM keystaff_group ORDER BY groupkey_id ASC";
	$query = mysql_db_query($dbnameuse,$sql);
	 while($rs =mysql_fetch_assoc($query)){
		if($rs[groupkey_id] == $gid){ $sel = "selected='selected'";	}else{ $sel = "";}
		echo "<option value='".$rs[groupkey_id]."' ".$sel.">".$rs[groupname]."</option>";		
	}
              ?>
          		</select>
				<strong>กลุ่มพนักงาน</strong>
                
          	</td>
		  </tr>   
<?php

	if($gid == "all"){
		$sql_group = "SELECT
							keystaff.staffid,
							keystaff.staffname,
							keystaff.staffsurname,
							keystaff_group.groupname
							FROM
							keystaff
							INNER JOIN keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id
							ORDER BY keystaff_group.groupkey_id ASC,keystaff.staffname ASC";
	}
	else{
		$sql_group = "SELECT
							keystaff.staffid,
							keystaff.staffname,
							keystaff.staffsurname,
							keystaff_group.groupname
							FROM
							keystaff
							INNER JOIN keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id
							WHERE keystaff_group.groupkey_id = '".$gid."'
							ORDER BY keystaff_group.groupkey_id ASC, keystaff.staffname ASC";
	}
	//echo $sql_group;
	//exit;
	$query_g = mysql_db_query($dbnameuse,$sql_group) or die(mysql_error()."SQL : ".$sql_group);
	$i = 0;
	while($rs_g = mysql_fetch_assoc($query_g)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
 ?>
				<tr bgcolor="<?=$bg?>">
                    <td align="center">
                    <?php
					$sql = "SELECT * FROM authority_math_profile WHERE staffid ='".$rs_g[staffid]."'";
					$query = mysql_db_query($dbnameuse,$sql);
					//echo $query;
					$rows = mysql_num_rows($query);
					
					while($rs = mysql_fetch_assoc($query)){
						if($profile_id == $rs[profile_id]){ $chk = "checked=true";	}else{ $chk = "";}
					}
					?>
                        <input type="checkbox" name="chkGroup[]" id="chkGroup<?=$i?>" value="<?=$rs_g[staffid];?>" <?=$chk?>>
                        <?php $chk = ""; ?>
                   	</td>
                    <td><?php echo $rs_g[staffname]."   ".$rs_g[staffsurname]?></td>
                    <td><?=$rs_g[groupname];?></td>
         		</tr>
<?php
	}
?>
        		<tr>
                    <td align="center" bgcolor="#EFEFFF" colspan="3"><input type="submit" name="button" id="button" value="บันทึก">
                    <input type="hidden" name="profile_id" value="<?=$profile_id?>">
                    <input type="hidden" name="hdnCount" value="<?=$i;?>">
                    <input type="hidden" name="xmode" value="<?=$mode?>">
                    <input type="hidden" name="gid" value="<?=$gid?>">
                      <input type="reset" name="button2" id="button2" value="ยกเลิก"></td>
		  		</tr>
			</table>
		</td>
	</tr>
</form>	  
  <?
	}//end if($mode == "Edit_g"){
  ?>
</table>
<?
}//end if($action == "all"){
	?>


</body>