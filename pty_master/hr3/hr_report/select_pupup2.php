<?
include ("function_tranfer.inc.php") ;
include ("../../../../config/config_transfer.inc.php")  ;

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../hr_report/images/style.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="autosuggest/autocomplete.css" media="screen" type="text/css">
<script language="javascript" type="text/javascript" src="autosuggest/autocomplete.js"></script>
<script language="javascript" src="../../hr_report/js/daily_popcalendar.js"></script>
<script language="javascript" src="../../hr_report/js/displayelement.js"></script>
<script language="javascript">
	function chFormS(){
		if(document.form_search.xarea.value == "0"){
			alert("กรุณาระบเขตพื้นที่การศึกษา");
			document.form_search.xarea.focus();
			return false;
		}else{
			return true;
		}
	}
</script>
<title></title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
.style6 {color: #000000; font-weight: bold; }
-->
</style>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style=" border-bottom:1px solid #FFFFFF">
  
  <tr>
    <td height="53" align="left" valign="top" bgcolor="#F4F4F4">


<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53%" valign="top" bgcolor="#F4F4F4">
		<form method="post" action="?sent_secid=<?=$sent_secid?>&dbname=<?=$dbname?>&comment_id=<?=$status_remove?>&old_money=<?=$old_money?>&school_destid=<?=$school_destid?>&school=<?=$school?>" name="form_search" onSubmit="return chFormS();">
		<table width="100%" border="0" cellpadding="3" cellspacing="0">
          <tr>
      <td colspan="2" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่งหรืออัตราเงินเดือนที่ใช้ในการสับเปลี่ยน</strong></td>
            </tr>
          <tr>
            <td colspan="2" align="right" bgcolor="#F4F4F4">&nbsp;</td>
            </tr>
			<?

			 if($dbname == "edubkk_master"){
			 		$dis_select = "";	
			}else{
				
					$dis_select = "disabled='disabled'";	
					echo "<input type=\"hidden\" name=\"xarea\" id=\"$xarea\" value=\"$sent_secid\">";

			}
			
			?>
          <tr>
            <td width="27%" align="right" bgcolor="#F4F4F4"><span class="style6"> สำนักงานเขตพื้นที่การศึกษา : </span></td>
            <td width="73%" bgcolor="#F4F4F4">
			<select name="xarea" id="xarea" <?=$dis_select?>>
			<option value="0"> - ระบุเขตพื้นที่การศึกษา - </option>
          <?		
		  	$sql1 = "SELECT DISTINCT `eduarea`.`secid`,`eduarea`.`area_id`,`eduarea`.`secname` FROM eduarea order  by  secname ASC";
		 	$query_area = mysql_db_query($dbnamemaster,$sql1) ;
			while($rs_area = mysql_fetch_assoc($query_area)){
					if($sent_secid != ""){ if($rs_area[secid] == $sent_secid){ $sel = "selected='selected'";}else{ $sel = "";}}else{
					if($xarea == $rs_area[secid]){ $sel = "selected='selected'";}else{ $sel = "";}
					}
         			echo "<option value=\"$rs_area[secid]\"$sel>$rs_area[secname]</option>";
   			} 
			?>
        </select>		</td>
          </tr>
          <tr>
            <td align="right" bgcolor="#F4F4F4"><strong>เลขที่ตำแหน่ง : </strong></td>
            <td bgcolor="#F4F4F4"><label>
              <input name="key_position_id" type="text" id="key_position_id" size="25" value="<?=$key_position_id?>">
            </label></td>
          </tr>
		    <tr>
            <td align="right" bgcolor="#F4F4F4"><strong>ชื่อตำแหน่ง : </strong></td>
            <td bgcolor="#F4F4F4"><label>
              <input name="key_position" type="text" id="key_position" size="25" value="<?=$key_position?>">
            </label></td>
          </tr>
          <tr>
            <td align="right" bgcolor="#F4F4F4"><span class="style6">ชื่อ  : </span></td>
            <td bgcolor="#F4F4F4"> <input type="text" name="key_name" value="<?= $key_name; ?>" size="25">    </td>
          </tr>
          <tr>
            <td align="right" bgcolor="#F4F4F4"><span class="style6">นามสกุล   :</span></td>
            <td bgcolor="#F4F4F4"><label>
              <input type="text" name="key_surname" value="<?=$key_surname;?>" size="25">
            </label></td>
          </tr>
          <tr>
            <td align="right" bgcolor="#F4F4F4"><span class="style6">รหัสบัตรประชาชน  :</span></td>
            <td bgcolor="#F4F4F4">  <label>
              <input type="text" name="key_idcard" value="<?=$key_idcard;?>" size="25">
            </label>
      	<input type="submit" name="search" value="ค้นหา">      
		<input name="key_search" type="hidden" id="key_search" value="search">
		<?php
		if($_POST){
		  $status_remove = $_POST['comment_id'];
		}
		?>		
		<input name="comment_id" type="hidden" value="<?=$status_remove?>">
		<input name="old_money" type="hidden" value="<?=$old_money?>">
		<input name="school_destid" type="hidden" value="<?=$school_destid?>">
		<input name="school" type="hidden" value="<?=$school?>">
		</td>
          </tr>
            <?
		 if($key_search == "search"){
		 	$db_site = "cmss_$xarea";
				if($key_position_id != ""){ $conv .= " AND j18_position.position_id LIKE '%$key_position_id%' ";}
				if($key_position != ""){ $conv .= " AND j18_position.position_name LIKE '%$key_position%' ";}
				if($key_name != ""){ $conv .= " AND general.name_th like '%$key_name%' ";}
				if($key_surname != ""){ $conv .= " AND general.surname_th like '%$key_surname%' ";}
				if($key_idcard != ""){ $conv .= " AND general.idcard like '%$key_idcard%' ";}
				if($comment_id == "1"){ $conv .= "AND j18_position.salary_position >= '$old_money' "; }
				if($school_destid != ""){$conv .= "AND j18_position.school_id = '$school_destid' ";}
				if($comment_id == "2"){
				  $conv .= " AND j18_position.CZ_ID != '' ";
				}/*else{
				  $conv .= " AND CZ_ID = '' ";
				}*/
				
				$sql_j18 = "SELECT general.idcard,general.prename_th,general.name_th,general.surname_th,j18_position.position_name,j18_position.position_id,j18_position.radub_name,j18_position.salary,j18_position.school_id,j18_position.salary_position FROM j18_position LEFT JOIN general ON j18_position.CZ_ID=general.id WHERE j18_position.position_id <> '' $conv ";
				
				//echo $sql_j18;
				
					//echo $sql_j18."<br>$db_site";
					//echo $sql_j18; 
					$result_j18 = mysql_db_query($db_site,$sql_j18);
					$xcheck_num = @mysql_num_rows($result_j18);
					
			?>
         <tr>
            <td colspan="2" align="left" bgcolor="#F4F4F4"><strong>ผลการค้นหา </strong></td>
		</tr>

          <tr><td colspan="2" valign="top" bgcolor="#F4F4F4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center"><table width="100%" border="0" cellspacing="1" cellpadding="3">
			  <? if($xcheck_num > 0){ // กรณีค้นหาเจอมากกว่า 1 รายการ?>
                <tr>
                  <td width="6%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
                  <td width="12%" align="center" bgcolor="#A3B2CC"><strong>เลขที่ตำแหน่ง</strong></td>
				  <td width="30%" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
                  <td width="9%" align="center" bgcolor="#A3B2CC"><strong>อันดับขั้น</strong></td>
                  <td width="15%" align="center" bgcolor="#A3B2CC"><strong>เงินเดือน</strong></td>
				  <td width="21%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ-นามสกุล </strong></td>
                  <td width="7%" align="center" bgcolor="#A3B2CC"><strong>เลือก</strong></td>
                </tr>
				<?
					$i=0;
					while($rs1 = mysql_fetch_assoc($result_j18)){
					if($i % 2){ $bg="#FFFFFF"; }else{ $bg = "#F0F0F0";}
				?>
                <tr bgcolor="<?=$bg?>">
                  <td align="center"><?=$i+1?></td>
				  <td align="left"><? echo "$rs1[position_id]";?></td>
                  <td align="left"><? echo "$rs1[position_name]";?>&nbsp;<? echo $school;?></td>
                  
                  <td align="left"><? echo "$rs1[radub_name]";?></td>
                  <td align="center"><? if(intval($rs1[salary]) < 1 ){ echo number_format($rs1[salary_position]); }else{ echo number_format($rs1[salary]);}?></td>
				  <td align="left"><? echo "$rs1[prename_th]$rs1[name_th]  $rs1[surname_th]";?></td>
                  <td align="center"><label>
                    <input name="select_id" id="select_id" type="radio" value="<?=$i?>" onClick="getCust_Data(this.value)">
                  </label></td>
                </tr>
				<?
				$i++;
						}//end 
				 }else{
						echo "<tr><td colspan='7' align='center' bgcolor='#FFFFFF'> - ไม่พบข้อมูลบุคลที่ท่านค้นหา กรุณาระบุเงื่อนไขใหม่อีกครั้ง - </td></tr>";
					}
				 ?>
				   <tr>
                  <td colspan="7" align="center" bgcolor="#FFFFFF"><label>
                    <input type="button" name="btnC" value="ปิดหน้าต่าง" onClick="window.close();">
                  </label></td>
                  </tr>

              </table></td>
            </tr>
          </table></td>
          </tr>
		  <? } //end if($key_search == "search"){?>
        </table>
        </form></td>
        </tr>
    </table></td>
</tr>
</table>
<script language="javascript">
function getCust_Data(id){

<?
	$xsql = "SELECT general.idcard,general.prename_th,general.name_th,general.surname_th,j18_position.position_name,j18_position.position_id,j18_position.radub_name,j18_position.salary,j18_position.salary_position FROM general left join j18_position ON general.id=j18_position.CZ_ID WHERE general.siteid='$xarea' $conv ";
	
	$xresult = mysql_db_query($db_site,$xsql);
	$num_check = mysql_num_rows($xresult);
	
	if($num_check == 0){
	  $xresult = mysql_db_query($db_site,$sql_j18);
	  $num_check = mysql_num_rows($xresult);
	}
	
	
	$j=0;
	while($xrs = mysql_fetch_assoc($xresult)){
			if($xrs[salary] < 1){ $salary1 = $xrs[salary_position];}else{ $salary1 = $xrs[salary];}
		$arr_person[] = $xrs[idcard]."::".$xrs[position_name]."::".$xrs[position_id]."::".$xrs[radub_name]."::".$salary1;
	$j++;
	}
?>
	data = [<?
	foreach ( $arr_person as $key => $val ) $arrData .= "'$val',";
	echo substr($arrData, 0, -1);
	?>];
	
	
	
	 p = data[id].split("::");
	 alert(p[1]);
	opener.document.form2.position_change.value=p[1]; 
	opener.document.form2.position_change_id.value=p[2]; 
	opener.document.form2.position_change_level.value=p[3]; 
	opener.document.form2.position_change_money.value=p[4]; 
	 
	//window.close();
	
}
</script>
</body>
</html>