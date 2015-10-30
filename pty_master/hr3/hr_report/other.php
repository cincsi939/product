<?php
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_other";
$module_code 		= "other"; 
$process_id			= "other";
$VERSION 				= "9.1";
$BypassAPP 			= true;
#########################################################
#Developer 	:: 
#DateCreate	::17/07/2007
#LastUpdate	::17/07/2007
#DatabaseTabel::
#END
#########################################################
//include ("session.inc.php");
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();
//include ("checklogin.php");
//include ("phpconfig.php");
//conn2DB();
if ($_SERVER[REQUEST_METHOD] == "POST"){

			if($action == "ChangRows"){

			for($i=0;$i<count($runno);$i++){
				$sql		= " update hr_other set runno='".$runno[$i]."' where id='$id' and no='".$no[$i]."' ";		
				$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
				}
				echo"<meta http-equiv='refresh' content='0;URL=other.php?id=$id&action=edit&vother=1'>";
					exit;
		}	


	add_log("ข้อมูลรายการอื่นๆ",$id,$action);
	if ($comment){
			 if ($_POST[action]=="edit2")
			 {
				  if(!get_magic_quotes_gpc()){
						$comment	= addslashes($comment);
					}
				 
				$sql = "update  hr_other set comment='$comment',kp7_active='$kp7_active' where no ='$no' and id ='$id' ;";
				
				$returnid = add_monitor_logbefore("hr_other","no ='$no' and id ='$id'");
				mysql_query($sql);
				add_monitor_logafter("hr_other","no ='$no' and id ='$id'",$returnid);
				
				if (mysql_errno())
				{
					$msg = "ไม่สามารถแก้ไขข้อมูลได้"  . mysql_error() ;
				}
				else
				{
					echo "
				<script language=\"javascript\">
				alert(\"ทำการปรับปรุงข้อมูลเสร็จสิ้น\\n \");
				location.href='other.php?id=$id&action=edit&vother=1';
				</script>
				";
		//			header("Location: ?id=$id&action=edit");
					exit;
				}
									
					
			}else
				{
				$strID="SELECT max(runno) as runno FROM hr_other WHERE id='$id'";
				$ResultID=mysql_query($strID);
				$RsID=mysql_fetch_array($ResultID);
				$IDmax=$RsID[runno]+1;
				if(!get_magic_quotes_gpc()){
						$comment	= addslashes($comment);
				}
				$sql = "INSERT INTO  hr_other (id,comment,kp7_active,runno) VALUES ('$id','$comment','$kp7_active','$IDmax')";
		
				$returnid = add_monitor_logbefore("hr_other","");
				$result  = mysql_query($sql);
				$max_idx = mysql_insert_id();
				add_monitor_logafter("hr_other","no ='$max_idx' and id ='$id'",$returnid);

					
					if($result)
					{
							echo "
							<script language=\"javascript\">
							alert(\"ทำการบันทึกข้อมูลเสร็จสิ้น\\n \");
							location.href='other.php?id=$id&action=edit&vother=1';
							</script>
							";
					//	header("Location: ?id=$id&action=edit");
						exit;
					}else
					{	$msg= "ไม่สามารถบันทึกข้อมูลได้ ". mysql_error() ;}
				}
	
	}else {//comment
		$msg = "กรุณาป้อนข้อมูลในช่องรายการ";
	}

}else if ($_GET[action] == 'delete')
	{
	add_log("ข้อมูลรายการอื่นๆ",$id,$action);
		mysql_query("delete from hr_other where no = $no and id='$id';");
		if (mysql_errno())
			{
			$msg = "Cannot delete parameter.";
			}else
			{
			//header("Location: ?id=$id&action=edit");
			echo "<script language=\"javascript\">
							location.href='other.php?id=$id&action=edit&vother=1';
							</script>";
			exit;
			}
	
}

//แสดงข้อมูล
$sql = "select * from  general where id='$id'  ;";
$result = mysql_query($sql);
if ($result){
	$rs=mysql_fetch_array($result,MYSQL_ASSOC);
} else {
	$msg = "Cannot find parameter information.";
}
	
?>



<html>
<head>
<title>รายการอื่นๆที่จำเป็น</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="../../../common/jquery/1.4/jquery.min.js"></script>
<script>
function isNotchar(str,obj,type){  
    var orgi_text="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789/\\=_-.&,\"' ๅภถุึคตจขชๆไำพะัีรนยบลฃฟหกดเ้่าสวงผปแอิืทมใฝ๑๒๓๔ู฿๕๖๗๘๙๐ฎฑธํ๊ณฯญฐฅฤฆฏโฌ็๋ษศซฉฮฺ์ฒฬฦ0123456789";  
    var str_length=str.length;  
    var str_length_end=str_length-1;  
    var isEng=true;  
    var Char_At="";  
    for(i=0;i<str_length;i++){  
        Char_At=str.charAt(i);  
        if(orgi_text.indexOf(Char_At)==-1){  
            isEng=false;  
        }     
    }  
    if(str_length>=1){  
        if(isEng==false){  
			$('#'+obj).val(str.substr(0,str_length_end));
        }  
    }

	if(type=='full' && isEng==false){
		alert('รองรับการกรอกอักษรภาษาอังกฤษเท่านั้น');
		$('#'+obj).val('');
		$('#'+obj).focus();
	}
    return isEng; // ถ้าเป็น true แสดงว่าเป็นภาษาไทยทั้งหมด  
}
</script>
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style2 {font-size: 12}
.style3 {color: #FFFFFF}
.style4 {color: #000000}
-->
</style>
<!-- send id to menu flash -->

</head>

<body bgcolor="#A3B2CC">
 
<?
if ($msg){
?>
<CENTER><h2><FONT COLOR="red"><?=$msg?></FONT></h2>
<BR><BR>
<input type=button value=" ย้อนกลับ " onClick="history.back();">
</CENTER>

<?
	exit;
}
?>
 

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="left" valign="top"><br>
          <table width="98%" border="0" align="center">
              <tr>
                <td width="49%">&nbsp;<a href="kp7_other.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7" ><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style4">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></a><span class="style4"></span></span></td>
                <td width="47%"><a href="?action=edit2s" class="style2"></a></td>
                <td width="4%">&nbsp;</td>
              </tr>
            </table>
            <br>
              <table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
                <tr> 
                  <td align="left" valign="top" class="style3" ><b> <span class="style4">&nbsp;ชื่อ / สกุล &nbsp;&nbsp; <u>
                    <?=$rs[prename_th]?>
                    <?=$rs[name_th]?>
                    <?=$rs[surname_th]?>
                    </u></span></b></td>
                </tr>
              </table>
              <br>
              <span class="style3">&nbsp;&nbsp;&nbsp;&nbsp;<strong><b>&nbsp;</b>&nbsp;<span class="style4">๗. รายการอื่นๆที่จำเป็น</span></strong></span><br>
              <br>
<? if($vother==1)

{
?>
				<form name="post" method="post" action="?">
				<input type="hidden" name="action" value="ChangRows">
				<input type="hidden" name="id" value="<?=$id?>">
              <table width="98%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
                
                <tr bgcolor="#999999" align="center"> 
                  <td width="83" bgcolor="#A3B2CC"><strong>เรียงลำดับ</strong></td>
                    <td width="751" bgcolor="#A3B2CC"><strong>รายการอื่นๆ ที่จำเป็น </strong></td>
                
                    <td bgcolor="#A3B2CC">
                    <input type="button" name="add" value="เพิ่มข้อมูล" onClick="location.href='other.php?id=<?=$id?>&action=edit2s' ">
                  </a></td>
                </tr>
                <?

				$i=0;
				$result = mysql_query("select * from hr_other where id='$id' order by runno asc");
				$row=mysql_num_rows($result);
				while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
					$i++;
					if ($i % 2) {
						$bg = "#FFFFFF";
					}else{
						$bg = "#F0F0F0";
					}
			?>
                <tr align="center" bgcolor="<?=$bg?>"> 
                  <td align=center>
				  <select name="runno[]">
						<?
						for($e=1;$e<=$row;$e++){
							$selected = ($e == $i) ? " selected " : "" ;
							echo "<option value=\"".$e."\" ".$selected.">".$e."</option>";
								}
						?>	
			  </select>	
			  	<input type="hidden" name="no[]" value="<?=$rs[no]?>">				  </td>
                  
                  <td align="left"> 
<?
$arr_kp7str[] = ""; 
$arr_kp7str[0] = ""; 
$arr_kp7str[1] = "  <img src='../../../images_sys/check_green.gif' width='16' height='13'>  "; 


?>				  
                    <?=$rs[comment] ?>                  </td>
                  <td width="108"><a href="other.php?id=<?=$rs[id]?>&no=<?=$rs[no]?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> &nbsp; <a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs[id]?>&no=<?=$rs[no]?>';"><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a> </td>
                </tr>

                <?
	} //while
// List Template
?>                <tr align="center" bgcolor="<?=$bg?>">
                  <td align=center>&nbsp;</td>
                  <td align="center"><input type="submit" value="บันทึกการเรียงลำดับการแสดงผลใน ก.พ.7">
				  &nbsp;
				  <input type="button" name="back" value="กลับหน้าแรก" onClick="location.href='other_all_1.php?id=<?=$id?>'"></td>
                  <td>&nbsp;</td>
                </tr>
              </table>
</form>  
              <?
			  }
			  else
			  {

# if ($_GET[action]  == "edit") { die; } 
If ($_GET[action]=="edit2")
{
		$sql = "select * from hr_other where no='$no' and id = '$id'   ;";
		$result = mysql_query($sql);
		if ($result)
		{
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		}


}
?>
              <br>
			  			     <form  method = POST  action = "<?  echo $PHP_SELF ; ?>" onSubmit="if($('#comment').val().trim()==''){alert('กรุณากรอกข้อมูลในช่องรายการ'); return false;}">
              <INPUT TYPE="hidden" NAME="no" VALUE="<?=$no?>">
              <INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">
              <table width="90%" border="0" cellspacing="2" cellpadding="0" align="center">
                
                <tr> 
                  <td align="right" valign="top" width="190"><font color="red">*</font> <B>รายการ</B></td>
                  <td align="left" valign="top" width="684"><textarea name="comment" id="comment"  rows="10" cols="100"><?=trim($rs[comment])?></textarea></td>
                  <!--onKeyPress="isNotchar(this.value,'comment','')" onKeyUp="isNotchar(this.value,'comment','')" onBlur="isNotchar(this.value,'comment','full')"-->
                </tr>
              </table>
			  <center>
			  <input name="kp7_active" type="radio" value="1"  checked="checked"<? if ($rs[kp7_active]==1){ echo "checked";}?>>
แสดงผลใน ก.พ. 7
<input name="kp7_active" type="radio" value="0"  <? if ($rs[kp7_active]=="0"){ echo "checked";}?>>
ไม่แสดงผล ใน ก.พ. 7
</center>
              <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
                <tr valign="middle"> 
                  <td align="center" colspan=2> &nbsp;&nbsp;
                    <input type="submit" name="send" value="  บันทึก  ">
                  <input type="reset" value="  ยกเลิก  " ONCLICK="location.href='other.php?id=<?=$id?>&action=edit&vother=1'">
                  <input type="button" name="viewdata" value="กลับหน้าแรก" onClick="location.href='other_all_1.php?action=edit' "></td>
                </tr>
              </table>
            </form><? }?>
            <p>&nbsp;</p>
          <p>&nbsp;</p>          </td></tr>
        <tr>
          <td align="left" valign="top">&nbsp;</td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>