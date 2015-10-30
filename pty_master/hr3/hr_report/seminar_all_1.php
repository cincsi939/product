<?php
session_start();
//include ("session.inc.php");
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_index";
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
if ($_SERVER[REQUEST_METHOD] == "POST"){

	add_log("ข้อมูลการประชุม ดูงาน สัมนา",$id,$action);
			// ประกอบค่าจาก select box
				$subject 	= addslashes($subject);
				$place 		= addslashes($place);
				$note 		= addslashes($note);

			 if ($_POST[action]=="edit2")
			 {
				$sql = "update seminar set  startdate='$startdate', enddate='$enddate' , subject = '$subject' , versions = '$versions' ,
			place='$place' ,  stype ='$stype',note = '$note' , kp7_active = '$kp7_active' where id ='$id'  and runid ='$runid' ;";
				
				mysql_query($sql);
				if (mysql_errno())
				{
					$msg = "Cannot update parameter information.";
				}
				else
				{
					echo "
				<script language=\"javascript\">
				alert(\"ทำการปรับปรุงข้อมูลเสร็จสิ้น\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
				//	header("Location: ?id=$id&action=edit");
					exit;
				}
									
					
			}else
				{
				$sql = "INSERT INTO  seminar  (id,startdate,enddate,subject,versions,place,stype,note,kp7_active) 
				VALUES ('$id','$startdate','$enddate','$subject','$versions','$place','$stype','$note','$kp7_active')";
		
					$result  = mysql_query($sql);
					if($result)
					{
						echo "
					<script language=\"javascript\">
					alert(\"ทำการบันทึกข้อมูลเสร็จสิ้น\\n \");
					location.href='?id=$id&action=edit';
					</script>
				";
						//header("Location: ?id=$id&action=edit");
						exit;
					}else
					{	echo "ไม่สามารถบันทึกข้อมูลได้ ";}
				}
				

}else if ($_GET[action] == 'delete')
	{
	add_log("ข้อมูลการประชุม ดูงาน สัมนา",$id,$action);
		mysql_query("delete from seminar  where id = $id and runid='$runid';");
		if (mysql_errno())
			{
			$msg = "Cannot delete parameter.";
			}else
			{
			header("Location: ?id=$id&action=edit");
			echo"<meta http-equiv='refresh' content='0;URL=seminar.php'>";
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
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="left" valign="top">&nbsp;&nbsp;
		  <?
  if($dis_menu){
		  ?>
<a href="kp7_seminar.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7"> <img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style2">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></a>
		  <?
		  }else{
		  ?>
		  <a href="seminar.php?id=<?=$id?>&action=view" class="pp" title="แก้ไขข้อมูลส่วนบุคคล"><img src="images/edit.png" width="16" height="16" align="absmiddle" border=""><span class="style2">เพิ่ม/ลบ/แก้ไข ข้อมูล</span></a>&nbsp;<a href="kp7_seminar.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7"> <img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style2">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></a>
		<?
		 }
		?> 
		<br>
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
              <br>
              <table border="0" cellspacing="2" cellpadding="2" align="center" width="98%" bgcolor="black">
              
                <tr bgcolor="#A3B2CC"> 
                  <td width="82" align="center"><strong>ประเภท</strong></td>
                  <td width="126" align="center"><strong>วันที่</strong></td>
                  <td width="119" align="center"><strong>ถึงวันที่</strong></td>
                  <td width="555" align="center"><strong>ชื่อหลักสูตร</strong></td>
                  <td width="61" align="center"><strong>รุ่น</strong></td>
                  
                </tr>
                <?
				//conn2DB();
				$stype = array("อบรม","ดูงาน","สัมนา");
				$i=0;
				$result = mysql_query("select  *  from seminar where id='$id' order by runno ASC");
				while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
					$i++;
					if ($i % 2) {
						$bg = "#EFEFEF";
					}else{
						$bg = "#DDDDDD";
					}
			?>
                <tr bgcolor="<?=$bg?>"> 
                  <td align="center"> 
                    <?=$stype[$rs[stype]]?></td>
                  <td> 
                      &nbsp;&nbsp;<?=$rs[startdate]?></td>
                  <td> 
                     &nbsp;&nbsp;<?=$rs[enddate]?></td>
                  <td align="left"> 
                    <?=$rs[subject]?></td>
                  <td align="center"> 
                    <?=$rs[versions]?></td>
                
                </tr>
                <?
	} //while
// List Template
?>
              </table>
              <?

If ($_GET[action]=="edit2")
{
		$sql = "select * from seminar where id='$id' and runid = '$runid'  ;";
		$result = mysql_query($sql);
		if ($result)
		{
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		}
}
?>
              <br>
              <p>&nbsp;</p>
            <p>&nbsp;</p>
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