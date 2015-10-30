<?php
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_prohibit";
$module_code 		= "prohibit"; 
$process_id			= "prohibit";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer::
#DateCreate::17/07/2007
#LastUpdate::17/07/2007
#DatabaseTabel::
#END
#########################################################
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
include("../../../config/phpconfig.php");
$time_start = getmicrotime();



//$id 		= (empty($_POST[id])) ? $_GET[id] : $_POST[id] ;
//$action 	= $_GET[action];

if($_SERVER[REQUEST_METHOD] == "POST"){
add_log("ข้อมูลการได้รับโทษทางวินัย",$id,$action);
	if ($comment){
		$yy = intval($yy);
		if ($_POST[action]=="edit2")
			 {
				$sql = "update  hr_prohibit set  yy='$yy', comment='$comment', refdoc='$refdoc', kp7_active='$kp7_active' where no ='$no' and id ='$id' ;";
				
				mysql_query($sql);
				if (mysql_errno())
				{
					$msg = "ไม่สามารถแก้ไขข้อมูลได้"."__________".LINE."_________".mysql_error;
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
				$sql = "INSERT INTO  hr_prohibit (id,yy,comment,refdoc,kp7_active) VALUES ('$id','$yy','$comment','$refdoc','$kp7_active')";
	//	echo $sql;
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
					{	$msg= "ไม่สามารถบันทึกข้อมูลได้ ";}
				}
				

	}else{ // if($comment)
		$msg = "กรุณาระบุข้อความในรายการ"."__________".LINE."_________".mysql_error;;
	}
	header("Location: ?id=$id&action=edit&msg=$msg");	
	exit;
}else if ($_GET[action] == 'delete')
	{
	add_log("ข้อมูลการได้รับโทษทางวินัย",$id,$action);
		mysql_query("delete from hr_prohibit where no = $no and id='$id';");
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
<title>การได้รับโทษทางวินัย</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
.style2 {color: #FFFFFF}
.style3 {color: #000000}
-->
</style>

<!-- send id to menu flash -->
<script language=javascript>
		
function check(){

	if(document.post.comment.value.length==0){
		alert("ระบุรายการ");
		document.post.comment.focus();
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
          <td align="left" valign="top"><br>
          <table width="98%" border="0" align="center">
		  <?
		  if($dis_menu){
		  ?>
	 <tr>
    <td colspan="2"><a href="kp7_prohibit.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7" class="style2"><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style3">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></a></td>
    </tr>

		  <?
		  }else{
		  ?>
              <tr>
                <td width="23%"><a href="prohibit.php?id=<?=$id?>&action=edit&vprohibit=1" target="_self"><img src="images/edit.png" width="16" height="16" align="absmiddle" border=""><span class="style3">เพิ่ม/ลบ/แก้ไข ข้อมูล</span></a> &nbsp; </span></td>
                <td width="77%"><a href="kp7_prohibit.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7" class="style2"><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style3">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></a></td>
              </tr>
			 <?
			 }
			 ?>
            </table>
            <br>
            <form name="post" method="post" action="<?=$PHP_SELF?>" onSubmit="return check();">
              <INPUT TYPE="hidden" NAME="no" VALUE="<?=$no?>">
              <INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">
              <table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
                <tr> 
                  <td align="left" valign="top" ><span class="style3"><b>ชื่อ / สกุล &nbsp;&nbsp; <u>
                    <?=$rs[prename_th]?>
                    <?=$rs[name_th]?>
                    <?=$rs[surname_th]?>
                    </u></b></span> </td>
                </tr>
              </table>
              <br>
              <span class="style1">&nbsp;&nbsp;&nbsp;<span class="style3">&nbsp;๑๑. การได้รับโทษทางวินัย</span></span><br>
              <br>
              <table width="98%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
                
                <tr bgcolor="#999999" align="center"> 
                  <td width="100" bgcolor="#A3B2CC"><strong>พ.ศ.</strong></td>
                  <td width="305" bgcolor="#A3B2CC"><strong>รายการ</strong></td>
				  <td width="537" bgcolor="#A3B2CC"><strong>เอกสารอ้างอิง</strong></td>
                </tr>
                <?
				$i=0;
				$result = mysql_query("select * from hr_prohibit where id='$id' order by runno asc");
				while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
					if ($rs[kp7_active] !=1 ){ continue  ; } 
					$i++;
					if ($i % 2) {
						$bg = "#FFFFFF";
					}else{
						$bg = "#F0F0F0";
					}
					
					if($rs[label_yy] !=""){
					 	$yyy= $rs[label_yy];
					 }else{
					 	$arr_yy = explode("-",$rs[yy]);
							if($rs[yy] == "0000-00-00"){
								$yyy="";
							}else{
								if($arr_yy[0] > 0 and $arr_yy[1] > 0 and $arr_yy[2] > 0){
									$yyy = intval($arr_yy[2])." ".$month[intval($arr_yy[1])]." ".$arr_yy[0];
								}else if($arr_yy[0] > 0 and $arr_yy[1] > 0 and $arr_yy[2] < 1){
									$yyy = $month[intval($arr_yy[1])]." ".$arr_yy[0];
								}else if($arr_yy[0] > 0 and $arr_yy[1] < 1 and $arr_yy[2] < 1){
									$yyy = $arr_yy[0];
								}else{
									$yyy = "";
								} // end if($arr_yy[0] > 0 and $arr_yy[1] > 0 and $arr_yy[2] > 0){
							} // end if($rs[yy] == "0000-00-00"){
					 }//end 	if($rs[label_yy] !=""){
			?>
                <tr align="center" bgcolor="<?=$bg?>"> 
                  <td> 
                    <?=$yyy?>                  </td>
                  <td align="left"> 
                    <?=$rs[comment] ?>                  </td>
				  <td align="left">
					<?=$rs[refdoc]?>				  </td>
                </tr>
                <?
	} //while
// List Template
?>
              </table>
              <?

If ($_GET[action]=="edit2")
{
		$sql = "select * from hr_prohibit where no='$no' and id = '$id'   ;";
		$result = mysql_query($sql);
		if ($result)
		{
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		}


}
?>
              <br>
            </form>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
          </td></tr>
      </table>
      
    </td>
  </tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>