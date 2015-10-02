<?php
/**
* @comment PIC FOR GIS
* @projectCode PS56DSDPW04
* @tor  -
* @package core
* @author Jakrit Monkong
* @access private
* @created 28/07/2014
*/
header("Content-Type: text/html; charset=UTF-8");
include('../../lib/class.function.php');
include('../dataxml.php');

if ($question_img != ""){
$pic_default = "../../../img/profile/".$question_img;
} else {
$pic_default = "../images/nopicture.gif";
}
?>
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td width="80" rowspan="5" align="left" valign="top"><img src="<? echo $pic_default ;?>" width="80" height="100" align="absmiddle" border="1" /></td>
    <td colspan="2" align="left" valign="top"><span class="personal_name" ><strong><u><? echo $tFirstname;?> <? echo $tLastname;?></u></strong></span></td>
  </tr>
  <tr>
    <td width="20%" align="left" valign="top">เพศ</td>
    <td align="left" valign="top"><?php
if($question_sex==1){ echo  'หญิง';}else 
if($question_sex==2){ echo  'ชาย';}else
{ echo 'อื่นๆ'.' ระบุ '.$question_sex_detail;}

?></td>
  </tr>
  <tr>
    <td align="left" valign="top">อายุ</td>
    <td align="left" valign="top"><?php echo $question_age;?></td>
  </tr>
  <tr>
    <td align="left" valign="top">ที่อยู่</td>
    <td align="left" valign="top">บ้านเลขที่ <?php echo $question_address; ?> หมู่ที่ <?php echo $question_village; ?> ถนน <?php echo $question_street; ?> 
<?
if ($question_province != ""){
$sql_Changwat = "Select ccName FROM ccaa WHERE ccType = 'Tamboon' AND areaid like '".substr($question_province,0,2)."%'";
$results_Changwat = $con->select($sql_Changwat);
if ($results_Changwat[0]['ccName'] != ""){ echo $results_Changwat[0]['ccName']; } 
?> 
<?
$sql_Changwat = "Select ccName FROM ccaa WHERE ccType = 'Aumpur' AND areaid like '".substr($question_province,0,2)."%'";
$results_Changwat = $con->select($sql_Changwat);
if ($results_Changwat[0]['ccName'] != ""){ echo $results_Changwat[0]['ccName']; } 
?> 
<?
$sql_Changwat = 'Select ccName FROM ccaa WHERE ccDigi = "'.$question_province.'" ';
$results_Changwat = $con->select($sql_Changwat);
if ($results_Changwat[0]['ccName'] != ""){ echo $results_Changwat[0]['ccName']; } 
}
?></td>
  </tr>
  <tr>
    <td align="left" valign="top">รายได้</td>
    <td align="left" valign="top"><?php 
$question_Income  = str_replace(",","",$question_Income);
if($question_Income ==0){
 $showmoney = 'ไม่ระบุ';
} else {
 $showmoney = str_replace('.00','',number_format($question_Income,2)).' บาท';
}
echo $showmoney;
?></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td align="left"><span class="personal_name" ><strong><u>ผลการสำรวจสภาพครอบครัว (คะแนน/ร้อยละ)</u></strong></span></td>
  </tr>

</table>

<?
$sql1 = "select f3_d_t,f3_c_t,f3_d_1,f3_c_1,f3_d_2,f3_c_2,f3_d_3,f3_c_3 ,f3_status_all,f3_status_1,f3_status_2,f3_status_3 
 from reportbuilder_f3 where f3_idcard = '".$question_idcard_detail."' ";

$Query = mysql_query($sql1);
$show = mysql_fetch_array($Query);
?>
<style>
.red {
background-color:#e64249;
color:#FFFFFF;
}

.td_red {
font-weight:bold;
color:#e64249;
}
.yellow {
background-color:#ffe558;
color:#000000;
}
.td_yellow {
font-weight:bold;
color:#ffe558;
}
.green {
background-color:#4cbe5e;
color:#000000;
}
.td_green {
font-weight:bold;
color:#4cbe5e;
}
</style>
<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#000000" style="border-collapse: collapse;">
  <tr>
    <td width="25%" align="center"  class="<? echo $show['f3_status_all'];?>">รวม</td>
    <td width="25%" align="center"  class="<? echo $show['f3_status_1'];?>">มิติที่ 1 </td>
    <td width="25%" align="center"  class="<? echo $show['f3_status_2'];?>">มิติที่ 2 </td>
    <td width="25%" align="center"  class="<? echo $show['f3_status_3'];?>">มิติที่ 3 </td>
  </tr>
  <tr>
    <td align="center" class="td_<? echo $show['f3_status_all'];?>"><? echo abs($show['f3_d_t']);?>/<? echo abs($show['f3_c_t']);?></td>
    <td align="center" class="td_<? echo $show['f3_status_1'];?>"><? echo abs($show['f3_d_1']);?>/<? echo abs($show['f3_c_1']);?></td>
    <td align="center" class="td_<? echo $show['f3_status_2'];?>"><? echo abs($show['f3_d_2']);?>/<? echo abs($show['f3_c_2']);?></td>
    <td align="center" class="td_<? echo $show['f3_status_3'];?>"><? echo abs($show['f3_d_3']);?>/<? echo abs($show['f3_c_3']);?></td>
  </tr>
</table>
