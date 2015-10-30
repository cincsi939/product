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

	add_log("ข้อมูลรายการอื่นๆ",$id,$action);
	if ($comment){
			 if ($_POST[action]=="edit2")
			 {
				$sql = "update  hr_other set comment='$comment',kp7_active='$kp7_active' where no ='$no' and id ='$id' ;";
				
				mysql_query($sql);
				if (mysql_errno())
				{
					$msg = "ไม่สามารถแก้ไขข้อมูลได้"  . mysql_error() ;
				}
				else
				{
					echo "
				<script language=\"javascript\">
				alert(\"ทำการปรับปรุงข้อมูลเสร็จสิ้น\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
		//			header("Location: ?id=$id&action=edit");
					exit;
				}
									
					
			}else
				{
				$sql = "INSERT INTO  hr_other (id,comment,kp7_active) VALUES ('$id','$comment','$kp7_active')";
		
					$result  = mysql_query($sql);
					if($result)
					{
							echo "
							<script language=\"javascript\">
							alert(\"ทำการบันทึกข้อมูลเสร็จสิ้น\\n \");
							location.href='?id=$id&action=edit';
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
			header("Location: ?id=$id&action=edit");
			echo "<script language=\"javascript\">
							location.href='?id=$id&action=edit';
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
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style3 {	color: #000000;
	font-weight: bold;
}
.style4 {color: #FFFFFF}
.style5 {color: #000000}
-->
</style>
<!-- send id to menu flash -->
</head>

<body bgcolor="#A3B2CC">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="left" valign="top"><br>
          <table width="98%" border="0" align="center">
		  <?
		  if($dis_menu){
		  ?>
            <tr>
              <td colspan="2"><a href="kp7_other.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7" ><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style5">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></a></td>
              </tr>
		  <?
		  }else{
		  ?>
            <tr>
              <td width="22%"><a href="other.php?id=<?=$id?>&action=edit&vother=1" target="_self" ><img src="images/edit.png" width="16" height="16" align="absmiddle" border=""><span class="style5">เพิ่ม/ลบ/แก้ไข ข้อมูล </span></a> &nbsp; </td>
               <td width="78%"><a href="kp7_other.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7" ><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style5">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></a></td>
             </tr>
			 <?
			 }
			 ?>
            </table>
		     <br>
            <form  method = POST  action = "<?  echo $PHP_SELF ; ?>" >
              <INPUT TYPE="hidden" NAME="no" VALUE="<?=$no?>">
              <INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">
              <table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
                <tr> 
                  <td align="left" valign="top" class="style4" ><b><span class="style5">ชื่อ / สกุล &nbsp;&nbsp; <u>
                    <?=$rs[prename_th]?>
                    <?=$rs[name_th]?>
                    <?=$rs[surname_th]?>
                    </u></span></b></td>
                </tr>
              </table>
              <span class="style3"><br>
              &nbsp; &nbsp;</span><span class="style4"><span class="style3"> ๗. รายการอื่นๆที่จำเป็น
              </span><br>
              </span><br>
              <table width="98%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
                
                <tr bgcolor="#999999" align="center"> 

                      <td width="681" bgcolor="#A3B2CC"><strong>รายการอื่นๆ ที่จำเป็น </strong></td>
                </tr>
                <?

				$i=0;
				$result = mysql_query("select * from hr_other where id='$id' order by runno asc");
				while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
				
					$i++;
					if ($i % 2) {
						$bg = "#FFFFFF";
					}else{
						$bg = "#F0F0F0";
					}
			?>
                <tr align="center" bgcolor="<?=$bg?>"> 

                    <td align="left"> 			  
                      <?=$rs[comment] ?>                  </td>
                </tr>
                
                <?
	} //while
// List Template
?>
              </table>
                <?

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
              <center> </center>
            </form>
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