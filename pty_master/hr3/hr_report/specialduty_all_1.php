<?php
//include ("session.inc.php");
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_specialduty";
$module_code 		= "specialduty"; 
$process_id			= "specialduty";
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
//include ("checklogin.php");
//include ("phpconfig.php");
//conn2DB();
if ($_SERVER[REQUEST_METHOD] == "POST"){
add_log("ข้อมูลการปฏิบัติราชการพิเศษ",$id,$action);
	if ($comment){
		$yy = intval($yy);

			 if ($_POST[action]=="edit2")
			 {

if ($doubletime == "double"){ 

	$start_date = $double_start_year ."-". "$double_start_month"  ."-". "$double_start_day" ; 
	$end_date = $double_end_year ."-". "$double_end_month"  ."-". "$double_end_day" ; 

$sql = "update  hr_specialduty set  
  yy='$yy', comment='$comment' ,kp7_type='$kp7_type' ,kp7_active='$kp7_type'  ,double_start='$start_date' , double_end='$end_date' ,
   double_sick='$double_sick' ,   double_duty='$double_duty' , double_getyy='$double_getyy' ,
   double_getmm ='$double_getmm' ,double_getdd ='$double_getdd'  
 where no ='$no' and id ='$id' ;";
}else{ ###### END if ($doubletime == "double"){  
$sql = "update  hr_specialduty set  yy='$yy', comment='$comment' ,kp7_type='$kp7_type'  ,kp7_active='$kp7_type' where no ='$no' and id ='$id' ;";	
} ###### END if ($doubletime == "double"){  
			 
				
				
				mysql_query($sql);
				if (mysql_errno())
				{
					$msg = "ไม่สามารถแก้ไขข้อมูลได้" . mysql_error() ;
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
/*				
doubletime :::: double 
double_type :::: Martial_Law 
double_start_day :::: 23 
double_start_month :::: 02 
double_start_year :::: 2550 
double_end_day :::: 02 
double_end_month :::: 05 
double_end_year :::: 2550 
double_sick :::: 1 
double_duty :::: 2 
double_getyy :::: 
double_getmm :::: 
*/



if ($doubletime == "double"){ 

	$start_date = $double_start_year ."-". "$double_start_month"  ."-". "$double_start_day" ; 
	$end_date = $double_end_year ."-". "$double_end_month"  ."-". "$double_end_day" ; 
	
	$sql = "
	INSERT INTO  hr_specialduty 
	(id,yy,comment,kp7_type  ,kp7_active ,double_type,double_start,double_end,
	double_sick,double_duty,double_getyy,double_getmm,double_getdd) 
	VALUES 
	('$id','$yy','$comment','$kp7_type','$kp7_type' , '$double_type' , '$start_date' , '$end_date' , 
	'$double_sick' ,'$double_duty' ,'$double_getyy' , '$double_getmm' , '$double_getdd' 	)	
	";
}else{ ###### END if ($doubletime == "double"){  
	$sql = "INSERT INTO  hr_specialduty (id,yy,comment,kp7_type,kp7_active) VALUES ('$id','$yy','$comment','$kp7_type' ,'$kp7_type')";
} ###### END if ($doubletime == "double"){  

						$result  = mysql_query($sql);
						if($result)
						{
							echo "
							<script language=\"javascript\">
							alert(\"ทำการบันทึกข้อมูลเสร็จสิ้น\\n \");
							location.href='?id=$id&action=edit';
							</script>
							";
					//		header("Location: ?id=$id&action=edit");
							exit;
						}else
						{	$msg = "ไม่สามารถบันทึกข้อมูลได้ " . mysql_error() ;}

			}

	}else{ // if($comment)
		$msg = "กรุณาระบุข้อความในรายการ";
	}

}else if ($_GET[action] == 'delete')
	{
	add_log("ข้อมูลการปฏิบัติราชการพิเศษ",$id,$action);
		mysql_query("delete from hr_specialduty where no = $no and id='$id';");
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
	

// แสดงข้อมูล

$sql = "select * from  general where id='$id'  ;";
$result = mysql_query($sql);
if ($result){
$rs=mysql_fetch_array($result,MYSQL_ASSOC);
} else {
	$msg = "ไม่พบข้อมูลที่ระบุ";
}
		
		
?>



<html>
<head>
<title>การปฏิบัติราชการพิเศษ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style3 {color: #000000}
-->
</style>
<!-- send id to menu flash -->
<script language="javascript">
function onSelect(val, divid){
	if(val == 0){
 		document.getElementById(divid).style.display	= 'none';  
	} else {
		document.getElementById(divid).style.display	= 'block';  
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
              <td colspan="2"><a href="kp7_specialduty.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7" ><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style3">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></a></td>
           </tr>
		  <?
		  }else{
		  ?>
            <tr>
              <td width="20%"><a href="specialduty.php?id=<?=$id?>&action=edit" target="_self"><img src="images/edit.png" width="16" height="16" align="absmiddle" border=""><span class="style3">เพิ่ม/ลบ/แก้ไข ข้อมูล </span></a> &nbsp; </td>
                <td width="80%"><a href="kp7_specialduty.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7" ><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style3">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></a></td>
              </tr>
			<?
			}
			?>  
            </table>
            <form  method = POST  action = "?id=<?=$id?>" >
              <INPUT TYPE="hidden" NAME="no" VALUE="<?=$no?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">
              <table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
                <tr> 
                  <td align="left" valign="top" ><b>ชื่อ / สกุล &nbsp;&nbsp; <u>
                    <?=$rs[prename_th]?>
                    <?=$rs[name_th]?>
                    <?=$rs[surname_th]?>
                    </u></b> </td>
                </tr>
              </table>
                <br>
  <?
$arr_kp7str[] = ""; 
$arr_kp7str[0] = ""; 
$arr_kp7str[1] = "  <img src='../../../images_sys/check_green.gif' width='16' height='13'>  "; 


?>						  
              <table width="98%" border="0" align="center">
                <tr>
                  <td><strong>๖. การปฏิบัติราชการพิเศษ</strong></td>
                </tr>
              </table>
                <br>
                <table width="98%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
                  
                  <tr bgcolor="#999999" align="center"> 
                    <td width="100" bgcolor="#A3B2CC"><strong>พ.ศ.</strong></td>
                    <td bgcolor="#A3B2CC"><strong>รายการ</strong></td>
                  </tr>
                  <?

				$i=0;
				$result = mysql_query("select * from hr_specialduty where id='$id' order by yy desc;");
				while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
					if ($rs[kp7_type] !=1 ){ continue  ; } 
					 
					$i++;
					if ($i % 2) {
						$bg = "#FFFFFF";
					}else{
						$bg = "#F0F0F0";
					}
			?>
                  <tr align="center" bgcolor="<?=$bg?>"> 
                    <td> 
                      <?=$rs[yy]?>                  </td>
                    <td align="left"> 
                      <?=$rs[comment] ?>            </td>
                  </tr>
                  <?
	} //while
// List Template
?>
              </table>
            </form>
  <? /* 
ALTER TABLE `hr_specialduty` ADD `double_type` VARCHAR( 50 ) NOT NULL ,
ADD `double_start` DATE NOT NULL ,
ADD `double_end` DATE NOT NULL ,
ADD `double_sick` INT NOT NULL ,
ADD `double_duty` INT NOT NULL ,
ADD `double_getyy` INT NOT NULL ,
ADD `double_getmm` INT NOT NULL ,
ADD `double_getdd` INT NOT NULL ;			
*/  
?>
</td></tr>
      </table>
      
    </td>
  </tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>