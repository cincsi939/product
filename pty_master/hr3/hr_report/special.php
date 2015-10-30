<?php
//include ("session.inc.php");
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_special";
$module_code 		= "special"; 
$process_id			= "special";
$VERSION 				= "9.91";
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
$tbname="special";
	if($action=="changeRow"){
		for($i=0;$i<count($runno);$i++){
			$sql		= " update $tbname set runno='".$runno[$i]."' where id='$id' and runid='".$runid[$i]."' ";		
			$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
		}
//		header("Location: ?id=$id");
		echo"<meta http-equiv='refresh' content='0;URL=special.php?action=edit'>";
		exit;
	}
	
	if($action=="add"){
	
		$detail = trim($detail);
	 if(!get_magic_quotes_gpc()){
		$detail			= addslashes($detail);
	 }
	
	$strSQL="SELECT max(runno) as runno FROM $tbname WHERE id='$id'";
	$Result=mysql_query($strSQL);
	$Rs=mysql_fetch_assoc($Result);
	 $runno_new=$Rs[runno]+1;
	 
	 
	 	$strINSERT="INSERT INTO $tbname(id,runno,detail,kp7_active)VALUES('$id','$runno_new','$detail','$kp7_active')";
			
		$returnid = add_monitor_logbefore("special","");
		@mysql_query($strINSERT);
		$max_idx = mysql_insert_id();
		add_monitor_logafter("special"," id ='$id' and runno='$runno_new' and  runid='$max_idx' ",$returnid);

		
		echo"<meta http-equiv='refresh' content='0;URL=special.php?action=edit'>";
		exit;
		
	}
	
	if($action=="update"){
		$detail = trim($detail);
		 if(!get_magic_quotes_gpc()){
			$detail			= addslashes($detail);
		 }

		$strUPDATE="UPDATE $tbname SET detail='$detail', kp7_active='$kp7_active' WHERE id='$id' AND runid='$runid'";
		
		$returnid = add_monitor_logbefore("special"," id ='$id' and  runid='$runid' ");
		mysql_query($strUPDATE);
		add_monitor_logafter("special"," id ='$id' and  runid='$runid' ",$returnid);
		
		echo"<meta http-equiv='refresh' content='0;URL=special.php?action=edit'>";
		exit;
	}		
	if($action=="del_a"){
	$sql_del="delete from $tbname where id='$id' and runid='$runid' and runno='$runno'";
	@mysql_query($sql_del);
	echo"<meta http-equiv='refresh' content='0;URL=special.php?action=edit'>";
		exit;
	}

/// เลือกข้อมูลจากตารางมาแสดง
		 $sql = "select * from  general where id='$id'";
		$result = mysql_query($sql);
		if ($result){$rs=mysql_fetch_array($result,MYSQL_ASSOC);} else {$msg = "Cannot find parameter information.";echo $msg;}
	//------------------------------------------------		
	//echo"	<meta http-equiv='refresh' content='0;URL=special.php?action=edit'>";
	?>
<html>
<head>
<title>ความสามารถพิเศษ</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style2 {color: #000000}
-->
</style>

<!-- send id to menu flash -->

</head>
<script language=javascript>
	
function check(){

	if(document.form1.detail.value==""){
		alert("ระบุความสามารถพิเศษ");
		document.form1.detail.focus();
		return false;
	} else {
		return true;
	}
	
}	
</script>
<body bgcolor="#A3B2CC">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30"><br>
        <table width="98%"  align="center">
          <tr>
            <td width="40%" height="21"><a href="kp7_special.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7"> <img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style2">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></a></td>
                <td width="60%">&nbsp;</td>
              </tr>
        </table></td><td width="50" height="30">&nbsp;</td>
      </tr>
    </table></td>
    <td width="50" height="30"> 

    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td valign="top">
            <br>
              <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr> 
                  <td align="left" valign="top"><strong>&nbsp;&nbsp;ชื่อ / สกุล &nbsp;&nbsp; 
                  &nbsp;<u>
                  <?=$rs[prename_th]?>
                  <?=$rs[name_th]?>
                  <?=$rs[surname_th]?>
                    </u> </b> </strong></td>
                </tr>
              </table>
              <br>
              &nbsp;&nbsp; <strong> </strong>&nbsp;&nbsp;<strong>๕. ความรู้ความสามารถพิเศษ</strong><br>
			  <?
			  	if($action=="edit"){
			  ?>
			 <form name="changR" method="post" action="">			
				<input type="hidden" name="action" value="changeRow">
				<input type="hidden" NAME="id" VALUE="<?=$id?>">
			    <table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
                  
                  <tr bgcolor="#A3B2CC" align="center">
                    <td width="100"><strong>เรียงลำดับ</strong></td>

                    <td width="760" ><strong>รายละเอียด</strong></td>
                    <td width="78"><input type="button" name="add" value="เพิ่มข้อมูล" onClick="location.href='special.php?id=<?=$id?>&action=add_new'"></td>
                  </tr>
                  <?

	$i=0;
	$result = mysql_query("select t1.*,t2.major as majorname,t3.groupname from special t1 left join $dbnamemaster.hr_addmajor t2 on t1.major=t2.runid left join $dbnamemaster.specialgroup t3 on t1.specialgroup=t3.runid where t1.id='$id' order by t1.runno asc");
	$row=mysql_num_rows($result);
	while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		$i++;
		if ($i % 2) {
		$bg = "#EFEFEF";
		}else{
		$bg = "#DDDDDD";
		}
?>
                  <tr bgcolor="<?=$bg?>">
                    <td align="center"><label>
                      <select name="runno[]">
                        <?
					for($e=1;$e<=$row;$e++){
						$selected = ($e == $i) ? " selected " : "" ;
						echo "<option value=\"".$e."\" ".$selected.">".$e."</option>";
							}
					?>
                      </select>
                    </label>
				  <input type="hidden" name="runid[]" value="<?=$rs[runid]?>">				  </td>
                    <td><?=$rs[detail]?>    </td>
                    <td><div align="center"> <a href="special.php?id=<?=$rs[id]?>&runid=<?=$rs[runid]?>"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> &nbsp; <a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&runno=<?=$rs[runno]?>&action=del_a'" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a> </div></td>
                  </tr>
                  <?
	} //while

// List Template
?>
                  <tr>
                    <td colspan="4" align="center" bgcolor="#F7F7F7"><input name="submit" type="submit" value="บันทึกการเรียงลำดับการแสดงผลใน ก.พ.7">
                      <input type="button" name="back2" value="กลับหน้าแรก" onClick="location.href='special_all.php?id=<?=$id?>&action=edit&vspecial=0'"></td>
				  </tr>
               </table>
			   
			 </form>
<?
}else if($action=="add_new"){
?>
				<form name="form1" method ="post"  action = "" onSubmit="return check();">
              <INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
              <INPUT TYPE="hidden" NAME="runid" VALUE="<?=$runid?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="add">


              <table width="90%" border="0" cellspacing="2" cellpadding="0" align="center">
                <tr> 
                  <td align="right" valign="top" width="258">รายละเอียด</td>
                  <td align="left" valign="top" width="616"> 
				  <textarea name="detail" cols="55" rows="5" ><?=$rs[detail]?></textarea>				  </td>
                </tr>
                <tr>
                  <td height="37" align="right" valign="top">&nbsp;</td>
                  <td align="left" valign="top">
				  <input type="radio" name="kp7_active" value="1" checked="checked" <? if($rs[kp7_active]=="1"){ echo "checked"; }?>>
                  แสดงผลใน ก.พ. 7&nbsp;
                  <input type="radio" name="kp7_active" value="0" <? if($rs[kp7_active]=="0"){ echo "checked"; }?>>
                  ไม่แสดงผลใน ก.พ.7</td>
                </tr>
              </table>
              <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
                <tr valign="middle"> 
                  <td align="center"><input type="submit" name="send" value="  บันทึก  ">
				  <input type="button" ONCLICK="location.href='special.php?id=<?=$id?>&action=edit'"  value="ยกเลิก" name="button" />
				  <input type="button" name="back22" value="กลับหน้าแรก" onClick="location.href='special_all.php?id=<?=$id?>&action=edit&vspecial=0'"></td>
                </tr>
              </table>
            </form>   
			<?
			}else{
			?>
			<form name="form1" method ="post"  action = ""  onSubmit="return check();">
              <INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
              <INPUT TYPE="hidden" NAME="runid" VALUE="<?=$runid?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="update">


              <table width="90%" border="0" cellspacing="2" cellpadding="0" align="center">
			  <?
			  $strSelect="select * from special where id='$id' and runid='$runid'";
			  $Rs1=mysql_query($strSelect);
			  $rs1=mysql_fetch_array($Rs1);
			  		
			  ?>
               
                <tr> 
                  <td align="right" valign="top" width="258">รายละเอียด</td>
                  <td align="left" valign="top" width="616"> 
				  <textarea name="detail" cols="55" rows="5" ><?=$rs1[detail]?></textarea>				  </td>
                </tr>
                <tr>
                  <td height="37" align="right" valign="top">&nbsp;</td>
                  <td align="left" valign="top">
				  <input type="radio" name="kp7_active" value="1" checked="checked" <? if($rs1[kp7_active]=="1"){ echo "checked"; }?>>
                  แสดงผลใน ก.พ. 7&nbsp;
                  <input type="radio" name="kp7_active" value="0" <? if($rs1[kp7_active]=="0"){ echo "checked"; }?>>
                  ไม่
                  แสดงผลใน ก.พ. 7</td>
                </tr>
              </table>
              <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
                <tr valign="middle"> 
                  <td align="center"><input type="submit" name="send" value="  บันทึก  ">
					<input type=button ONCLICK="location.href='special.php?id=<?=$id?>&action=edit'"  value="ยกเลิก" name="button" />
					<input type="button" name="back23" value="กลับหน้าแรก" onClick="location.href='special_all.php?id=<?=$id?>&action=edit&vspecial=0'">				  </td>
                </tr>
              </table>
            </form>
			<?
				}
			?>
		  </td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>

<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
