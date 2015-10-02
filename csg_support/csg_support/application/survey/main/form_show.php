<?
/**
* @comment หน้าแสดงผล profile รายคน 
* @projectCode -
* @tor  -
* @package core
* @author Jakrit Monkong
* @access 
* @created 12/09/2014
*/

/**
* @comment หน้าแสดงผล profile รายคน 
* @projectCode -
* @tor  -
* @package core
* @author tanachai Khampukhew
* @access 
* @Modifiy 27/09/2014
*/
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<? 
//header("Content-type: text/html; charset=utf-8"); 
include('../lib/class.function.php');
include('dataxml.php');
if($_GET['debug']=='on'){
	echo "<pre>";
	print_r($results);
	echo "</pre>";
}
$xml = simplexml_load_string($myxml);
function replacepin($pin){
		if($_SESSION['user_status']=='1' or $_SESSION['user_status']==''){
			return substr($pin,0,3).'XXXXXXXXXX';
		}else{
			return $pin;
		}
}
function formatDateThai($date){
$list= array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
list($d,$m,$y) =preg_split("/\//",$date);
return "$d ".$list[abs($m)]." $y";
}
?>
<style>
html,body{
height:100%;
margin:0px;
padding:0px;
}
@font-face {
    font-family: 'supermarket';
    src: url('font/supermarket.eot');
    src: url('font/supermarket.eot?#iefix') format('embedded-opentype'),
         url('font/supermarket.woff') format('woff'),
         url('font/supermarket.ttf') format('truetype'),
		 url('font/supermarket.svg#supermarketRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'ThaiSansNeue-Black';
    src: url('font/ThaiSansNeue-Black.otf');
    src: url('font/ThaiSansNeue-Black.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'ThaiSansNeue-Regular';
    src: url('font/ThaiSansNeue-Regular.otf');
    src: url('font/ThaiSansNeue-Regular.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}

.borderbox {
margin-top:25px; margin-left:15px; margin-right:15px; width:99%; margin:0 auto; height:100%; 
}
.border_info {
border : 1px solid #CCCCCC;
border-radius: 5px 5px 5px 5px;
box-shadow: 1px 1px 1px 1px  #888888;
background-color:#FFF;
padding-top:5px; 
margin-bottom:0px;
}
.borderText{
	font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular !important;
	border:1px solid #CCC;
	text-align:center;
	height:20px;
	padding-left:3px;
	padding-right:3px;
	font-size:18px;
	border-radius:3px;
	color:#333333;
	/*font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular !important;*/
}
.project_name {
	font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular !important;
	font-size:28px;
	font-weight:600;
	color:#333333;
}
.personal_name {
	font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular !important;
	font-size:30px;
	font-weight:600;
	color:#ff6926;
}
.personal_tb td,.personal_tb th {
	font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular !important;
	font-size:18px;
	color:#000000;
}
.personal_tb td strong {font-weight:600;}
.container  {
/*font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular !important;*/

background-color:#e4e4e4;
padding:5px; 
padding-bottom:15px;
}
#footer {
	font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular !important;
background-color:#f7f7f7; height:80px; border-top:2px #999999 solid;position: inherit; width:100%;bottom:0;text-align:center;
}
.infodata{
/*	font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular !important;*/
position:relative;
	background-color:#FFFFFF;
	border-radius:5px;
	border:1px #CCCCCC solid;
	box-shadow: 3px 3px 3px #888888;
	padding:7px;
}
.infodata_font { color:#f97789; text-align: left; font-size:28px; padding-left:10px;}
.infodata_tab {background-image:url(images/tab_infodata.jpg); height:40px; text-align: left;padding-top:25px;padding-left:20px;}
.infodata_tab span {
font-size:24px;
font-weight:bold;
color:#9f7417;
}
.infodata_box{
background-image:url(images/td_bg4.jpg);background-position: center bottom; background-repeat: repeat-x;
width:100%;
padding:20px;
	-webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	-moz-box-sizing: border-box;    /* Firefox, other Gecko */
	box-sizing: border-box;         /* Opera/IE 8+ */
}
.infodata_tb td {
	font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular !important;
	font-size:20px;
	color:#000000;
}

.titletable td {
height:25px;
padding:3px;
color:#856922;
background-color:#ffff68;
}

.tdtable td {
height:25px;
background-color:#FFFFFF;
background-image:url(images/td_bg.jpg);
background-repeat:repeat-x;
background-position:bottom;
padding:7px;

}
.totaltable td {
height:30px;
background-image:url(images/td_bg2.jpg);
background-repeat:repeat-x;
background-position:bottom;
padding:7px;
}
.fontGray { color:#CCCCCC; font-style: italic;}

.table_result {
 font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular !important;
 font-size:30px;
 font-weight:600;
 color:#d37277;
}
.table_data {
 font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular !important;
 font-size:20px;
 font-weight:600;
 color:#000000;
}

.infomenu {
font-family: !important;
font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular !important;
font-size: 26px;
text-align: center;
color: #FFF;
}

.infomenu_next {
font-family: !important;
font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular !important;
font-size: 22px;
text-align: center;
color: #000000;
opacity: 0.9;
filter: alpha(opacity=60);
text-decoration: none;
}

.td_question {
font-weight:bold;
}
.td_answer {
color:#999999;
}
</style>

<?php
if($_GET['debug']=='on'){
	echo "<pre>";
	print_r($xml->Position1->NodeData4);
	echo "</pre>";
}
?>
<div class="borderbox">
<? if (empty($xml->Position1->NodeData7)){ echo "<center><br><br><br><br><br>ไม่พบข้อมูลสมาชิก</center>";} else {?>
<div class="border_info">
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tbody>
<tr>
    <td width="35%" align="center" valign="bottom"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="personal_tb" style="padding-left:20px;">
 
      <tr>
        <td align="left" valign="top"><strong>ที่อยู่ปัจจุบัน : </strong></td>
      </tr>
      <tr>
        <td align="left" valign="top">
		บ้านเลขที่ <?php echo $xml->Position1->NodeData8; ?> หมู่ที่ <?php echo $xml->Position1->NodeData9; ?> ถนน <?php echo $xml->Position1->NodeData10; ?> 
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
?>


</td>
      </tr>
	       <tr>
        <td align="left" valign="top"><strong>ประเภทที่อยู่</strong> :
          <?php 
$question_typehome = $xml->Position1->NodeData19 ;
$question_typehome_detail  = $xml->Position1->NodeData20 ;
	if($question_typehome==1){echo 'บ้านตัวเอง';}elseif($question_typehome==2){echo 'บ้านเช่า จ่ายค่าเช่า'.' '.$question_typehome_detail.' บาท';}elseif($question_typehome==3){echo 'บ้านญาติ';}else{echo 'อื่นๆ'.' ระบุ '.$question_typehome_detail;} ?></td>
      </tr>
      <tr>
        <td align="left" valign="top"><strong>อาชีพ : </strong><?php echo $con->careerSelect($xml->Position1->NodeData26); ?></td>
      </tr>
      <tr>
        <td align="left" valign="top"><strong>รายได้เฉลี่ยของครอบครัว </strong>:
          <?php 
$question_Income  = str_replace(",","",$xml->Position1->NodeData30);
if($question_Income == 0 or $question_Income=='' ){
 $showmoney = 'ไม่ระบุ';
} else {
 $showmoney = str_replace('.00','',number_format($question_Income,2)).' บาท';
}
echo $showmoney;
?></td>
      </tr>
      <tr>
        <td align="left" valign="top"><hr width="100%" color="#CCCCCC" size="1" align="left" /></td>
      </tr>
      <tr>
        <td align="center" valign="top" style="padding-bottom:5px;">
<?  if ($_GET['frame'] == 'gis'){ ?>
<a href="?id=<? echo $_GET['id'];?><? if (!empty($_GET['report_type'])){ echo "&report_type=".$_GET['report_type']; }?>" title="กลับเมนูหลัก" style="color:#000000; text-decoration:none; font-weight:bold;"><strong>กลับเมนูหลัก</strong></a>
<? } else {?>
<a href="?id=<? echo $_GET['id'];?>&frame=gis<? if (!empty($_GET['report_type'])){ echo "&report_type=".$_GET['report_type']; }?>" title="GIS view"><img src="images/gis_06.png" border="0" /></a>
<? } ?>
</td>
      </tr>
    </table></td>
    <td width="30%">
    <br>
	<input id="thispic" type="hidden"  value="1"/>
<? 
$pic_default =  $xml->Position1->NodeData42->DataImage;


if ($pic_default != ""){
$pic_default = "../../img/profile/".$pic_default;
} else {
$pic_default = "images/nopicture.gif";
}

?>
        <table border="0" height="205" width="209" align="center" cellpadding="0" cellspacing="0" >
                <tbody><tr><td style="padding:5px;"><div id='prevPic'><img src="images/General_infomation_14.png"  border="0"></div></td>
                <td id="mybg" background="<? echo $pic_default;?>" style=" background-repeat:no-repeat; background-position:center;background-size: 86% auto;">
                <img src="images/General_infomation_11.png">                </td>
                <td style="padding:5px;"><div id='nexpPic'><img src="images/General_infomation_17.png"  border="0"></div></td></tr>
        </tbody></table>
		
<script type="text/javascript">

var jsBannerText=new Array();  
<?
$countpic = count($xml->Position1->NodeData9->DataImage);
$i=0;
foreach( $xml->Position1->NodeData9->DataImage as $showImg) { 
$i++;
?>
jsBannerText[<? echo $i;?>] = "<? echo $showImg;?>";
<?
}
?>

      $('#prevPic').click( function (v) {
		 if ($('#thispic').val() > 1){ $('#thispic').val(parseFloat($('#thispic').val()) - 1); } else { $('#thispic').val('<? echo $countpic;?>'); }
			  $('#mybg').css("background", "url("+jsBannerText[$('#thispic').val()]+")");
			  $('#mybg').css("background-repeat", "no-repeat");
			  $('#mybg').css("background-position", "center");
			  $('#mybg').css("background-size", "100% auto");	  
      })
      $('#nexpPic').click( function (v) {
		 if ($('#thispic').val() < <? echo $countpic;?>){$('#thispic').val(parseFloat($('#thispic').val()) + 1);} else {$('#thispic').val('1');}
			  $('#mybg').css("background", "url("+jsBannerText[$('#thispic').val()]+")");
			  $('#mybg').css("background-repeat", "no-repeat");
			  $('#mybg').css("background-position", "center");
			  $('#mybg').css("background-size", "100% auto");	  
      })
</script>
                <div align="center" style="margin:8px;"><?
$idcard = replacepin($xml->Position1->NodeData7);
$idcardshow[] = substr($idcard,0,1);
$idcardshow[] = substr($idcard,1,4);
$idcardshow[] = substr($idcard,5,5);
$idcardshow[] = substr($idcard,10,2);
$idcardshow[] = substr($idcard,12,100);
foreach ($idcardshow as $idc){
echo "<span class='borderText'>".$idc."</span> ";
}
?></div>    </td>
    <td width="35%" align="left" valign="middle">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="personal_tb">
  <tr>
    <td align="left" valign="top"><span class="personal_name" ><? echo $xml->Position1->NodeData1;?> <?php echo $value['v1'];?> <?php echo $value['v2'];?></span> </td>
    </tr>
  <tr>
    <td align="left" valign="top"><hr width="90%" color="#CCCCCC" size="1" align="left"> </td>
    </tr>
  <tr>
    <td align="left" valign="top"><strong>เพศ </strong>: <?php
if($xml->Position1->NodeData15==1){$showgender = 'หญิง';}else 
if($xml->Position1->NodeData15==2){$showgender = 'ชาย';}else
{$showgender = 'อื่นๆ'.' ระบุ '.$xml->Position1->NodeData16;}
echo $showgender;
?></td>
    </tr>
  <tr>
    <td align="left" valign="top"><strong>อายุ</strong> : <?php echo $xml->Position1->NodeData18 ;?></td>
    </tr>
  <tr>
    <td align="left" valign="top"><strong>วัน/เดือน/ปีเกิด </strong>: <? echo formatDateThai($xml->Position1->NodeData17);?></td>
    </tr>
  <tr>
    <td align="left" valign="top"><strong>เบอร์โทรศัพท์ (ที่อยู่) </strong>: <? echo $xml->Position1->NodeData14;?></td>
    </tr>
    <tr>
    <td align="left" valign="top"><strong>ระดับการศึกษา</strong> : <?php
$question_education  =  $xml->Position1->NodeData25;
	 if($question_education==1){echo 'ไม่ได้ศึกษา';}elseif($question_education==2){echo 'ต่ำกว่าประถมศึกษา';}elseif($question_education==3){echo 'ประถมศึกษา';}elseif($question_education==4){echo 'มัธยมศึกษาตอนต้น';}elseif($question_education==5){echo 'มัธยมศึกษาตอนปลาย';}elseif($question_education==6){echo 'มัธยมศึกษาตอนปลาย/ปวช';}elseif($question_education==7){echo 'อนุปริญญา/ปวส';}elseif($question_education==8){echo 'ปริญญาตรี';}elseif($question_education==9){echo 'สูงกว่าปริญญาตรี';}else{echo 'ประถมศึกษา';} ?></td>
    </tr>
	    <tr>
    <td align="left" valign="top">&nbsp;</td>
    </tr>	
</table>      </td>
</tr>
</tbody>
</table>	
<?
$menu1  = "ข้อมูลหัวหน้าครอบครัว";
$menu2  = "กลุ่มเป้าหมาย";
$menu3  = "การมีส่วนร่วมในสังคม";
$menu4  = "สรุปความคิดเห็น";
if ($_GET['frame'] == 'gis'){
include "gis.php";
} else if ($_GET['frame'] == 'form4'){
include "page4.php";
} else if ($_GET['frame'] == 'form3'){
include "page3.php";
} else if ($_GET['frame'] == 'form2'){
include "page2.php";
} else {
include "page1.php";
}
?>

</div><!-- End .border_info -->
<? } ?>
</div>