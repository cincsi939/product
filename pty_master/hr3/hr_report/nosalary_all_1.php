<?php ######################  start Header ########################
/**
* @comment ระบบบริหารจัดการข้อมูลปฐมภูมิข้าราชการครูและบุคลากรทางการศึกษา
* @projectCode 56EDUBKK01
* @tor 7.2.4
* @package core
* @author Suwat.K
* @access public/private
* @created 10/04/2014
*/
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_nosalary";
$module_code 		= "nosalary"; 
$process_id			= "nosalary";
$VERSION 				= "9.1";
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
include("../../../config/phpconfig.php");
$time_start = getmicrotime();
if ($_SERVER[REQUEST_METHOD] == "POST"){

	add_log("ข้อมูลวันที่ไม่ได้รับเงินเดือน",$id,$action);
	if ($comment){
			  $fromdate = $from_year.'-'.$from_month.'-'.$from_day;
			  $todate = $to_year.'-'.$to_month.'-'.$to_day;

			if ($fromdate > $todate){
				$msg = "วันที่เริ่มต้น ต้องไม่น้อยกว่า วันที่สิ้นสุด";
			}else{

				 if ($_POST[action]=="edit2")
				 {
					$sql = "update  hr_nosalary set  fromdate='$fromdate', todate='$todate',comment='$comment',refdoc='$refdoc',kp7_active='$kp7_active' where no ='$no' and id ='$id' ;";
					
					mysql_query($sql);
					if (mysql_errno())
					{
						$msg = "ไม่สามารถแก้ไขข้อมูลได้"   .__LINE__.  mysql_error()  ;
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
										
						
				}else{

					$result = mysql_query("select * from hr_nosalary where (id='$id') and (fromdate='$fromdate' ) and (todate='$todate');");
					if (mysql_num_rows($result) > 0){
						$msg = "ข้อมูลซ้ำกับช่วงวันที่ที่มีอยู่แล้ว";
					}else{

						$sql = "INSERT INTO  hr_nosalary (id,fromdate,todate,comment,refdoc,kp7_active) VALUES ('$id','$fromdate','$todate','$comment','$refdoc','$kp7_active')";
			
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
						{	$msg = "ไม่สามารถบันทึกข้อมูลได้ "   .__LINE__.  mysql_error()  ;}

					}


				} // if edit2

			} // if fromdate > todate
				
	}else{ // if comment
		$msg = "กรุณาป้อนข้อมูลในช่องรายการ";
	}


}else if ($_GET[action] == 'delete')
	{
		add_log("ข้อมูลวันที่ไม่ได้รับเงินเดือน",$id,$action);
		mysql_query("delete from hr_nosalary where no = $no and id='$id';");
		if (mysql_errno())
			{
			$msg = "ไม่สามารถลบข้อมูลได้"   .__LINE__.  mysql_error()  ;
			}else
			{
			header("Location: ?id=$id&action=edit");
						echo "<script language=\"javascript\">
							location.href='?id=$id&action=edit';
							</script>";
			exit;
			}
	
}

// แสดงข้อมูล
$sql = "select * from  general where id='$id' ;";
$result = mysql_query($sql);
if ($result){
	$rs=mysql_fetch_array($result,MYSQL_ASSOC);
} else {
	$msg = "ไม่พบข้อมูลที่ระบุ";
}
	
?>



<html>
<head>
<title>วันที่ไม่ได้รับเงินเดือนหรือได้รับเงินเดือนไม่เต็ม</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
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
.style2 {color: #000000}
.style4 {color: #000000; font-weight: bold; }
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
      <td colspan="2"><a href="kp7_nosalary.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7"><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style2">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส</span>์ </a></td>
         </tr>
		  <?
		  }else{
		  ?>
            <tr>
           <td width="20%"><a href="nosalary.php?id=<?=$id?>&action=edit&vnosalary=1" target="_self"><span class="style4">&nbsp;</span><img src="images/edit.png" width="16" height="16" align="absmiddle" border=""><span class="style2">เพิ่ม/ลบ/แก้ไข ข้อมูล</span></a> &nbsp; </td>
              <td width="80%"><a href="kp7_nosalary.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7"><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style2">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส</span>์ </a></td>
            </tr>
		<?
		}
		?>
            </table>
              <br>
            <form  method = POST  action = "?id=<?=$id?>" >
              <INPUT TYPE="hidden" NAME="no" VALUE="<?=$no?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">
              <table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
                <tr> 
                  <td align="left" valign="top" ><b> <span class="style4"></span>ชื่อ / สกุล &nbsp;&nbsp; <u>
                    <?=$rs[prename_th]?>
                    <?=$rs[name_th]?>
                    <?=$rs[surname_th]?>
                    </u></b> </td>
                </tr>
              </table>
                <span class="style4"><br>
                &nbsp;&nbsp; &nbsp;๑๒.วันที่ไม่ได้รับเงินเดือนหรือได้รับเงินเดือนไม่เต็ม หรือวันที่มิได้ประจำ   ปฏิบัติหน้าที่อยู่ในเขตที่ได้มีประกาศใช้กฎอัยการศึก</span> <br>
                <br>
              <table width="98%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
                
                <tr bgcolor="#999999" align="center"> 
                  <td width="353" bgcolor="#A3B2CC"><strong>ตั้งแต่วันที่</strong><strong>-ถึงวันที่</strong></td>
				    <td width="369" bgcolor="#A3B2CC"><strong>รายการ</strong></td>
				    <td width="237" bgcolor="#A3B2CC"><strong>เอกสารอ้างอิง</strong></td>
                </tr>
                <?

				$i=0;
				$result = mysql_query("select * from hr_nosalary where id='$id' order by runno asc");
				while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
					if ($rs[kp7_active] !=1 ){ continue  ; } 
					$i++;
					if ($i % 2) {
						$bg = "#FFFFFF";
					}else{
						$bg = "#F0F0F0";
					}
			?>
                <tr align="center" bgcolor="<?=$bg?>"> 
                  
                  <td align="center"> 
                    <?=MakeDate($rs[fromdate]) ?>                   
                    -<?=MakeDate($rs[todate]) ?>                  </td>
				    <td align="left"> 
				      <?=$rs[comment] ?>                  </td>
				    <td align="left"> 
				      <?=$rs[refdoc] ?>                  </td>
                </tr>
                <?
	} //while
// List Template
?>
              </table>
                <?

If ($_GET[action]=="edit2")
{
		$sql = "select * from hr_nosalary where no='$no' and id = '$id'   ;";
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