<?
/**
* @comment หน้าแสดงผลข้อมูลสมาชิก
* @projectCode -
* @tor  -
* @package core
* @author Jakrit Monkong
* @access 
* @created 13/09/2014
*/

header("Content-type: text/html; charset=tis-620"); 
include('../lib/class.function.php');

$con = new Cfunction();
$con->connectDB();

$sql2 = "SELECT tbl2_type,tbl2_id,tbl2_name,tbl2_idcard,tbl2_birthday,tbl2_age,r_name,education,tbl2_problem ,tbl2_help,main_id ";
$sql2 .= " FROM question_tbl2";
$sql2 .= " INNER JOIN tbl_relation ON tbl_relation.id = question_tbl2.tbl2_relation";
$sql2 .= " INNER JOIN eq_member_education ON eq_member_education.educ_id = question_tbl2.tbl2_education";
$sql2 .= " WHERE tbl2_id = ".$_GET['id'];
$sql2 .= " order by tbl2_id asc";
$tbl2 = $con->select($sql2);
foreach($tbl2 as $row2){}


$sql = 'SELECT question_id,question_date,question_firstname,question_lastname,question_idcard,question_idcard_detail,question_address,question_village,';
	$sql .= 'question_street,question_parish,question_district,question_province,question_phone,question_sex,question_sex_detail,question_birthday,question_age,';
	$sql .= 'question_typehome,question_typehome_detail,question_stypehome_1,question_stypehome_2,question_stypehome_3,question_environment,question_education,';
	$sql .= 'question_career,question_career_detail,question_land,question_land_detail,question_Income,question_religion,question_religion_detail,question_status,question_status_detail,';
	$sql .= 'question_structure,question_structure_detail,question_defective,question_defective_detail,question_debt,question_debt_sub,question_debt_detail,question_img,';
	$sql .= 'question_residents_1,question_residents_2,question_residents_3,question_residents_4,question_residents_5,';
	$sql .= 'question_residents_1t,question_residents_2t,question_residents_3t,question_residents_4t,question_residents_5t,question_residents_tt,question_round,question_prename';
$sql .= ' FROM question_detail_1 INNER JOIN tbl_prename ON tbl_prename.id = question_prename';
$sql .= ' WHERE question_id='.$row2['main_id'];
$results = $con->select($sql);

foreach($results as $row){}

$myxml = "
<data>
<Position1>
<NodeData1 label='prename_th'>".$row['prename_th']."</NodeData1>
<NodeData2 label='question_id'>".$row['question_id']."</NodeData2>
<NodeData3 label='question_date'>".$row['question_date']."</NodeData3>
<NodeData4 label='question_firstname'>".$row['question_firstname']."</NodeData4>
<NodeData5 label='question_lastname'>".$row['question_lastname']."</NodeData5>
<NodeData6 label='question_idcard'>".$row['question_idcard']."</NodeData6>
<NodeData7 label='question_idcard_detail'>".$row['question_idcard_detail']."</NodeData7>
<NodeData8 label='question_address'>".$row['question_address']."</NodeData8>
<NodeData9 label='question_village'>".$row['question_village']."</NodeData9>
<NodeData10 label='question_street'>".$row['question_street']."</NodeData10>
<NodeData11 label='question_parish'>".$row['question_parish']."</NodeData11>
<NodeData12 label='question_district'>".$row['question_district']."</NodeData12>
<NodeData13 label='question_province'>".$row['question_province']."</NodeData13>
<NodeData14 label='question_phone'>".$row['question_phone']."</NodeData14>
<NodeData15 label='question_sex'>".$row['question_sex']."</NodeData15>
<NodeData16 label='question_sex_detail'>".$row['question_sex_detail']."</NodeData16>
<NodeData17 label='question_birthday'>".$row['question_birthday']."</NodeData17>
<NodeData18 label='question_age'>".$row['question_age']."</NodeData18>
<NodeData19 label='question_typehome'>".$row['question_typehome']."</NodeData19>
<NodeData20 label='question_typehome_detail'>".$row['question_typehome_detail']."</NodeData20>
<NodeData21 label='question_stypehome_1'>".$row['question_stypehome_1']."</NodeData21>
<NodeData22 label='question_stypehome_2'>".$row['question_stypehome_2']."</NodeData22>
<NodeData23 label='question_stypehome_3'>".$row['question_stypehome_3']."</NodeData23>
<NodeData24 label='question_environment'>".$row['question_environment']."</NodeData24>
<NodeData25 label='question_education'>".$row['question_education']."</NodeData25>
<NodeData26 label='question_career'>".$row['question_career']."</NodeData26>
<NodeData27 label='question_career_detail'>".$row['question_career_detail']."</NodeData27>
<NodeData28 label='question_land'>".$row['question_land']."</NodeData28>
<NodeData29 label='question_land_detail'>".$row['question_land_detail']."</NodeData29>
<NodeData30 label='question_Income'>".$row['question_Income']."</NodeData30>
<NodeData31 label='question_religion'>".$row['question_religion']."</NodeData31>
<NodeData32 label='question_religion_detail'>".$row['question_religion_detail']."</NodeData32>
<NodeData33 label='question_status'>".$row['question_status']."</NodeData33>
<NodeData34 label='question_status_detail'>".$row['question_status_detail']."</NodeData34>
<NodeData35 label='question_structure'>".$row['question_structure']."</NodeData35>
<NodeData36 label='question_structure_detail'>".$row['question_structure_detail']."</NodeData36>
<NodeData37 label='question_defective'>".$row['question_defective']."</NodeData37>
<NodeData38 label='question_defective_detail'>".$row['question_defective_detail']."</NodeData38>
<NodeData39 label='question_debt'>".$row['question_debt']."</NodeData39>
<NodeData40 label='question_debt_sub'>".$row['question_debt_sub']."</NodeData40>
<NodeData41 label='question_debt_detail'>".$row['question_debt_detail']."</NodeData41>
<NodeData42 label='question_img'>
		<DataImage>".$row['question_img']."</DataImage>
</NodeData42>
</Position1>

";


$myxml .= "</data>";
$xml = simplexml_load_string($myxml);



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
color: #FFF;
opacity: 0.6;
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
if($question_Income ==0){
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
        <td align="center" valign="top" style="padding-bottom:5px;">&nbsp;

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
$idcard = $xml->Position1->NodeData7;
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
    <td align="left" valign="top"><span class="personal_name" ><? echo $xml->Position1->NodeData1;?> <? echo $xml->Position1->NodeData4;?> <? echo $xml->Position1->NodeData5;?></span> </td>
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
	 if($question_education==1){echo 'ไม่ได้ศึกษา';}elseif($question_education==2){echo 'ต่ำกว่าประถมศึกษา';}elseif($question_education==3){echo 'ประถมศึกษา';}elseif($question_education==4){echo 'มัธยมศึกษาตอนต้น';}elseif($question_education==5){echo 'มัธยมศึกษาตอนปลาย';}elseif($question_education==6){echo 'มัธยมศึกษาตอนปลาย/ปวช';}elseif($question_education==7){echo 'อนุปริญญา/ปวส';}elseif($question_education==8){echo 'ปริญญาตรี';}else{echo 'สูงกว่าปริญญาตรี';} ?></td>
    </tr>
	    <tr>
    <td align="left" valign="top">&nbsp;</td>
    </tr>	
</table>      </td>
</tr>
</tbody>
</table>	



<div class="container">
	<div class="infodata" >
<table width="100%" height="200" border="0"  class="personal_tb">
      <tr>
        <td height="28" colspan="4" align="left" valign="top" bgcolor="#f2f2f2"><div class="infodata_font">ข้อมูลกลุ่มเป้าหมาย</div></td>
      </tr>
  <tr>
    <td align="center" valign="top">
	
<table width="95%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="20%" align="left" valign="top" class="td_question">ชื่อ/นามสกุล</td>
            <td width="30%" align="left" valign="top" class="td_answer"><span class="td_answer"><?php echo $row2['tbl2_name']; ?></span></td>
            <td width="20%" align="left" valign="top" class="td_question"><strong>อายุ</strong></td>
            <td width="30%" align="left" valign="top" class="td_answer"><span class="td_answer"><?php echo $row2['tbl2_age'] ?> ปี</span></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="td_question">รหัสประชาชน</td>
            <td align="left" valign="top" class="td_answer"><span class="td_answer"><?php echo $row2['tbl2_idcard']; ?></span></td>
            <td align="left" valign="top" class="td_question"><strong>การศึกษา</strong></td>
            <td align="left" valign="top" class="td_answer"><span class="td_answer"><?php echo $row2['education']; ?></span></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="td_question"><strong>วันเกิด</strong></td>
            <td align="left" valign="top" class="td_answer"><span class="td_answer"><?php echo formatDateThai($row2['tbl2_birthday']); ?></span></td>
            <td align="left" valign="top" class="td_question">ความสัมพันธ์</td>
            <td align="left" valign="top" class="td_answer"><span class="td_answer"><?php echo $row2['r_name']; ?></span></td>
          </tr>
          <tr>
            <td colspan="4" align="left" valign="top" class="td_question">สภาพปัญหาความเดือดร้อน</td>
            </tr>
          <tr>
            <td colspan="4" align="left" valign="top" class="td_answer"><span class="td_answer"><?php
							 $x=$row2['tbl2_problem'];
							 $i = 0;
							 if(($x!='')or($x!=NULL))
							 {
								$sql_2 = "SELECT problem_level,problem_detail FROM `question_problem` where problem_level IN(".$x.") AND problem_type = ".$row2['tbl2_type']." order by problem_level asc";
								$det_problem = $con->select($sql_2);
								foreach($det_problem as $rd){
									$i++;
									echo $i.' '.$rd['problem_detail']."</br>";
							 }
							}
						?></span></td>
            </tr>
          <tr>
            <td colspan="4" align="left" valign="top" class="td_question">ความช่วยเหลือที่ต้องการ</td>
            </tr>
          <tr>
            <td colspan="4" align="left" valign="top" class="td_answer"><span class="td_answer"><?php
								$b = $row2['tbl2_help'];
								$i = 0;
								if(($b!='')or($b!=NULL))
								{
									$sql_3 = "SELECT help_detail,help_level FROM `question_help` where help_level IN(".$b.") AND help_type = ".$row2['tbl2_type']." order by help_level asc";
									$det_help = $con->select($sql_3);
									foreach($det_help as $hd){
										$i++;
										echo $i.' '.$hd['help_detail']."</br>";
									} 
								}
							?></span>
						</td>
            </tr>

        </table>
	


    <br>
  </td>
  </tr>
</table>
<br />
<br />

	</div>

</div>








</div><!-- End .border_info -->
<? } ?>
</div>