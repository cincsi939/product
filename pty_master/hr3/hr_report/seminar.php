<?php
session_start();
//include ("session.inc.php");
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_seminar";
$module_code 		= "seminar"; 
$process_id			= "seminar";
$VERSION 				= "9.1";
$BypassAPP 			= true;
#########################################################
#Developer::
#DateCreate::17/07/2007
#LastUpdate::17/07/2007
#DatabaseTabel::
#END
#########################################################

include("../libary/function.php");
//include("../../../config/phpconfig.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();
//include ("checklogin.php");
//include ("phpconfig.php");
//conn2DB();
$menu_id = "4";
if ($_SERVER[REQUEST_METHOD] == "POST"){

	add_log("ข้อมูลการประชุม ดูงาน สัมนา",$id,$action,$menu_id);
			// ประกอบค่าจาก select box
				//$subject 	= addslashes($subject);
				//$place 		= addslashes($place);
				//$note 		= addslashes($note);
				
			if($action == "ChangRows"){

			for($i=0;$i<count($runno);$i++){
				$sql		= " update seminar set runno='".$runno[$i]."' where id='$id' and runid='".$runid[$i]."' ";		
				
				$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
				}
				echo"<meta http-equiv='refresh' content='0;URL=seminar.php?id=$id&action=view'>";
					exit;
		}	

			 if ($action=="edit2")
				 {
					 
				if(!get_magic_quotes_gpc()){
					$subject	= addslashes($subject);
					$enddate = addslashes($enddate);
					$versions = addslashes($versions);
					$place = addslashes($place);
					$note = addslashes($note);
				 }
				$sql = "update seminar set  startdate='$startdate', enddate='$enddate' , subject = '$subject' , versions = '$versions' ,
			place='$place' ,  stype ='$stype',note = '$note' , kp7_active = '$kp7_active' where id ='$id'  and runid ='$runid' ;";
			
				$returnid = add_monitor_logbefore("seminar","  id ='$id'  and runid ='$runid'  ");
				mysql_query($sql);
				add_monitor_logafter("seminar"," id ='$id' and runid ='$runid' ",$returnid);
				if (mysql_errno())
				{
					$msg = "Cannot update parameter information.";
				}
				else
				{
					echo "
				<script language=\"javascript\">
				alert(\"ทำการปรับปรุงข้อมูลเสร็จสิ้น\\n \");
			
				</script>
				";
					if($graduate_edit == "1"){
						header("Location: ?id=$id");
						echo"<meta http-equiv='refresh' content='0;URL=graduate.php'>";
						exit;
					}else{
						echo"<meta http-equiv='refresh' content='0;URL=seminar.php?id=$id&action=view'>";
						exit;
					}
					
				}
									
					
			}
				if($action=="add"){
				if(!get_magic_quotes_gpc()){
					$subject	= addslashes($subject);
					$enddate = addslashes($enddate);
					$versions = addslashes($versions);
					$place = addslashes($place);
					$note = addslashes($note);
				 }

				
				$strID="SELECT max(runno) as runno FROM seminar WHERE id='$id'";
				$ResultID=mysql_query($strID);
				$RsID=mysql_fetch_array($ResultID);
				$IDmax=$RsID[runno]+1;
				$sql = "INSERT INTO  seminar  (id,startdate,enddate,subject,versions,place,stype,note,kp7_active,runno) 
				VALUES ('$id','$startdate','$enddate','$subject','$versions','$place','$stype','$note','$kp7_active','$IDmax')";
		
					$returnid = add_monitor_logbefore("seminar","");
					$result  = mysql_query($sql);
					$max_idx = mysql_insert_id();
					add_monitor_logafter("seminar"," id ='$id' and runid ='$max_idx' ",$returnid);
					
					if($result)
					{
						echo "
					<script language=\"javascript\">
					alert(\"ทำการบันทึกข้อมูลเสร็จสิ้น\\n \");
					</script>
				";
				echo"<meta http-equiv='refresh' content='0;URL=seminar.php?id=$id&action=view'>";
						exit;
					}else
					{	echo "ไม่สามารถบันทึกข้อมูลได้ ";}
				}
				

}else if ($_GET[action] == 'delete')
	{
	add_log("ข้อมูลการประชุม ดูงาน สัมนา",$id,$action,$menu_id);
		mysql_query("delete from seminar  where id = $id and runid='$runid';");
		if (mysql_errno())
			{
			$msg = "Cannot delete parameter.";
			}else
			{

	echo"<meta http-equiv='refresh' content='0;URL=seminar.php?id=$id&action=view'>";
			exit;
			}
	
}else
		{		
	 	$sql = "select * from  general where id='$id'  ;";
		$result = mysql_query($sql);
		if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		} else {
		$msg = "Cannot find parameter information.";
		echo $msg;
		}
}
if($action == "set_kp7_all"){
add_log("ข้อมูลการประชุม ดูงาน สัมนา",$id,$action,$menu_id);
$strSQL_setkp7 = "UPDATE seminar SET kp7_active='0' WHERE id='$id'";

	$returnid = add_monitor_logbefore("seminar","");
	$Result_setkp7 = mysql_query($strSQL_setkp7);
	add_monitor_logafter("seminar"," id ='$id' ",$returnid);

	if($Result_setkp7){
				echo "
					<script language=\"javascript\">
					alert(\"ระบบทำการกำหนดไม่ให้แสงผลใน ก.พ.7 เรียบร้อยแล้ว\\n \");
					</script>
				";
				echo"<meta http-equiv='refresh' content='0;URL=seminar.php?id=$id&action=view'>";
				exit;
	}else{
		echo "ไม่สามารถแก้ไขข้อมูลได้";
	}

}
?>
<html>
<head>
<title>อบรม / ดูงาน / สัมนา</title>
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
<script language=javascript>
function check(){
		var errMsg='';
		if (document.post.subject.value==""){  errMsg+="กรุณากรอกหลักสูตร\n";  
		    document.post.subject.focus();
		}
		else if(document.post.versions.value=="") { errMsg+="กรุณากรอกรุ่น\n";
		    document.post.versions.focus() ;
		    }

		if (errMsg!='') {
			alert(errMsg);
			return false;
		} else {
			return true;
		} 
}
</script>
</head>

<body bgcolor="#A3B2CC">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="left" valign="top"><br>            &nbsp;<a href="kp7_seminar.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7"> <img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style2">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></a> <br>
            <br>
              <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr> 
                  <td align="left" valign="top" ><b>ชื่อ / สกุล &nbsp;&nbsp; <u>
                    <?=$rs[prename_th]?>
                    <?=$rs[name_th]?>
                    <?=$rs[surname_th]?>
                    </u></b></td>
                </tr>
				 <tr> 
                  <td align="left" valign="top" >&nbsp;</td>
                </tr>
				  <tr> 
                  <td align="left" valign="top" ><b> ฝึกอบรมและดูงาน</b></td>
                </tr>
              </table>
              <?
			  if($action=="view"){
			  ?>
			        <br>
				<form name="post" method="post" action="?">
				<input type="hidden" name="action" value="ChangRows">
				<input type="hidden" name="id" value="<?=$id?>">
              <table border="0" cellspacing="2" cellpadding="2" align="center" width="98%" bgcolor="black">
                
                <tr bgcolor="#A3B2CC">
                  <td width="92" align="center"><strong>เรียงลำดับ</strong></td> 
                  <td width="92" align="center"><strong>ประเภท</strong></td>
                  <td width="117" align="center"><strong>วันที่</strong></td>
                  <td width="113" align="center"><strong>ถึงวันที่</strong></td>
                  <td width="403" align="center"><strong>ชื่อหลักสูตร</strong></td>
                  <td width="126" align="center"><strong>รุ่น</strong></td>
                  <td align="center" width="69"><input type="button" name="add" value="เพิ่มข้อมูล" onClick="location.href='seminar.php?id=<?=$id?>&action=add'"></td>
                </tr>
                <?
				//conn2DB();
				$stype = array("อบรม","ดูงาน","สัมนา");
				$i=0;
				$result = mysql_query("select  *  from seminar where id='$id' order by runno	 ASC");
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
                  <td align="center"><?=$i?>
<!--				  <select name="runno[]">
						<?
/*						for($e=1;$e<=$row;$e++){
							$selected = ($e == $i) ? " selected " : "" ;
							echo "<option value=\"".$e."\" ".$selected.">".$e."</option>";
								}
*/						?>	
			  </select>	
-->			  	<input type="hidden" name="runid[]" value="<?=$rs[runid]?>">				  </td> 
                  <td align="center"> 
                    <?=$stype[$rs[stype]]?></td>
                  <td>&nbsp;&nbsp;<?=$rs[startdate]?></td>
                  <td> 
                    &nbsp;&nbsp; <?=$rs[enddate]?></td>
                  <td align="left"> 
                    <?=$rs[subject]?></td>
                  <td align="center"> 
                    <?=$rs[versions]?></td>
                  <td> 
                    <div align="center"> <a href="seminar.php?id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> 
                      &nbsp; <a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs[id]?>&runid=<?=$rs[runid]?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>                    </div>                  </td>
                </tr>
                <?
	} //while

?>		
<tr bgcolor="<?=$bg?>"><td colspan="7" align="center">
<input type="button"  name="Button3" value="ไม่แสดงผลใน ก.พ.7 ทั้งหมด" onClick="location.href='seminar.php?action=set_kp7_all&id=<?=$id?>'">
<!--<input type="submit" value="บันทึกการเรียงลำดับการแสดงผลใน ก.พ.7">-->
  <input type="button" name="Button2" value="กลับหน้าแรก" onClick="location.href='seminar_all_1.php?'">
</td>
</tr>
              </table>
</form>			  
              <?
		}
if($action=="edit2")
{
		$sql = "select * from seminar where id='$id' and runid = '$runid'  ;";
		$result = mysql_query($sql);
		if ($result)
		{
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		}

?>
			   <form name="post" method="post" action="<?=$PHP_SELF?>"  onSubmit="return ch();">
              <INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
              <INPUT TYPE="hidden" NAME="runid" VALUE="<?=$runid?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="edit2">
              <input type="hidden" name="graduate_edit" value="<?=$graduate_edit?>">
              

              <table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">
                <tr> 
                  <td align="right" valign="top" width="262">&nbsp;</td>
                  <td align="left" valign="top" width="612"> 
                    <input name="stype" type="radio" value="0" <? if ($rs[stype] == 0) echo "checked";?>>
                    อบรม &nbsp;&nbsp; 
                    <input type="radio" name="stype" value="1" <? if ($rs[stype] == 1) echo "checked";?>>
                    ดูงาน &nbsp;&nbsp; 
                    <input type="radio" name="stype" value="2" <? if ($rs[stype] == 2) echo "checked";?>>
                  สัมมนา </td>
                </tr>
                <tr>
                  <td align="right" valign="top">สถานที่ฝึกอบรมและดูงาน</td>
                  <td align="left" valign="top"><textarea name="place" cols="50" rows="6"><?=$rs[place]?>
                </textarea></td>
                </tr>
                <tr> 
                  <td align="right" valign="top" width="262">ตั้งแต่</td>
                  <td align="left" valign="top" width="612"><input name="startdate" type="text" id="startdate" value="<?=htmlspecialchars($rs[startdate])?>" size="50" maxlength="50"></td>
                </tr>

				<tr> 
                  <td align="right" valign="top" width="262">ถึง</td>
				
                  <td align="left" valign="top" width="612"><input name="enddate" type="text" id="enddate" value="<?=htmlspecialchars($rs[enddate])?>" size="50" maxlength="50"></td>
                </tr>
                <tr> 
                  <td align="right" valign="top" width="262">ชื่อหลักสูตรฝึกอบรมและดูงาน</td>
                  <td align="left" valign="top" width="612"> 
                    <input type="text" name="subject" size="60" value="<?=htmlspecialchars($rs[subject])?>">                  </td>
                </tr>
          <tr> 
                  <td align="right" valign="top" width="262">รุ่น</td>
                  <td align="left" valign="top" width="612">
                    <input type="text" name="versions" size="10" value="<?=htmlspecialchars($rs[versions])?>">                  </td>
                </tr>
                <tr>
                  <td align="right" valign="top" width="262">ข้อมูลอื่นๆ</td>
                  <td align="left" valign="top" width="612">
                    <textarea name="note" cols="50" rows="6"><?=$rs[note]?></textarea>                  </td>
                </tr>
                <tr>
                  <td align="right" valign="middle">&nbsp;</td>
                  <td align="left" valign="middle"><input name="kp7_active" type="radio" value="1"  checked="checked"<? if ($rs[kp7_active]==1){ echo "checked";}?>>
                    แสดงผลใน ก.พ.7
                    <input name="kp7_active" type="radio" value="0"  <? if ($rs[kp7_active]=="0"){ echo "checked";}?>>
                    ไม่แสดงผลใน ก.พ.7</td>
                </tr>
				 <tr valign="middle"> 
                  <td align="center" colspan=2><input type="submit" name="send" value="  บันทึก  ">
					<input type="button" name="Button" value="ยกเลิก" onClick="location.href='?action=view'">
					<input type="button" name="Button3" value="กลับหน้าแรก" onClick="location.href='seminar_all_1.php?'">                  </td>
                </tr>
              </table>			
	        </form>
			<?
			}
			   
		  if($action=="add"){
			?>	  
			  <form name="post" method="post" action="<?=$PHP_SELF?>"  onSubmit="return ch();">
              <INPUT TYPE="hidden" NAME="action" VALUE="add">

              <table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">
                <tr> 
                  <td align="right" valign="top" width="262">&nbsp;</td>
                  <td align="left" valign="top" width="612"> 
                    <input name="stype" type="radio" value="0" <? if ($rs[stype] == 0) echo "checked";?>>
                    อบรม &nbsp;&nbsp; 
                    <input type="radio" name="stype" value="1" <? if ($rs[stype] == 1) echo "checked";?>>
                    ดูงาน &nbsp;&nbsp; 
                    <input type="radio" name="stype" value="2" <? if ($rs[stype] == 2) echo "checked";?>>
                  สัมมนา </td>
                </tr>
                <tr>
                  <td align="right" valign="top">สถานที่ฝึกอบรมและดูงาน</td>
                  <td align="left" valign="top"><textarea name="place" cols="50" rows="6"></textarea></td>
                </tr>
                <tr> 
                  <td align="right" valign="top" width="262">ตั้งแต่</td>
                  <td align="left" valign="top" width="612"><input name="startdate" type="text" id="startdate" size="50" maxlength="50"></td>
                </tr>

				<tr> 
                  <td align="right" valign="top" width="262">ถึง</td>
				
                  <td align="left" valign="top" width="612"><input name="enddate" type="text" id="enddate"  size="50" maxlength="50"></td>
                </tr>
                <tr> 
                  <td align="right" valign="top" width="262">ชื่อหลักสูตรฝึกอบรมและดูงาน</td>
                  <td align="left" valign="top" width="612"> 
                    <input type="text" name="subject" size="60" >                  </td>
                </tr>
          <tr> 
                  <td align="right" valign="top" width="262">รุ่น</td>
                  <td align="left" valign="top" width="612">
                    <input type="text" name="versions" size="10" >                  </td>
                </tr>
                <tr>
                  <td align="right" valign="top" width="262">ข้อมูลอื่นๆ</td>
                  <td align="left" valign="top" width="612">
                    <textarea name="note" cols="50" rows="6"></textarea>                  </td>
                </tr>
                <tr>
                  <td align="right" valign="middle">&nbsp;</td>
                  <td align="left" valign="middle"><input name="kp7_active" type="radio" value="1" checked="checked">
                    แสดงผลใน ก.พ.7
                    <input name="kp7_active" type="radio" value="0" >
                    ไม่แสดงผลใน ก.พ.7</td>
                </tr>
				 <tr valign="middle"> 
                  <td align="center" colspan=2><input type="submit" name="send" value="  บันทึก  ">
					  <input type="button" name="Button" value="ยกเลิก" onClick="location.href='?action=view'">
					  <input type="button" name="Button4" value="กลับหน้าแรก" onClick="location.href='seminar_all_1.php?'">                  </td>
                </tr>
              </table>			
	        </form>
	<?
	}
	?>			   
			  
			   
          </td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
<script>
function ch(){
		var f1=document.post;
		if (f1.place.value==''){
			alert("กรุณาระบุ สถานที่ฝึกอบรมและดูงาน ด้วยครับ");
			f1.place.focus;
			return false;
		}
		
		if (f1.startdate.value==''){
			alert("กรุณาระบุ ตั้งแต่ ด้วยครับ");
			f1.startdate.focus;
			return false;
		}
		
		if (f1.enddate.value==''){
			alert("กรุณาระบุ ถึง ด้วยครับ");
			f1.enddate.focus;
			return false;
		}
		
		return true;
}
</script>