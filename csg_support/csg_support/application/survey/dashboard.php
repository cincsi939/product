<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Tanachai Khampukhew (tanachai@sapphire.co.th)
 * @created  30/08/2014
 * @access  public
 */


session_start();

if($_SESSION['session_group'] <= 1){ # กรณีเป็นส่วนกลางบังคับให้ไปแสดงในหน้ารายงานหลักสำหรับผู้บริหาร
	 header("location: report_main.php");
	exit();
}

if($_GET['debug'] == 'on'){
	print_r($_SESSION);
}
include("../../config/config_host.php"); #อ้างหาค่า Define

$arr_month = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
$month = date('m');
$year = ($month < 10) ? date('Y')  : date('Y')+1;
$year = ($_GET['year'] == '') ? $year :  $_GET['year']-543;
$year2 = $year+543;

$startYear = ($year-1);
$dateStart = ($year-1).'-10-01';
$dateEnd = ($year).'-09-30';

$tmpExsum[$startYear] = array(
	'10' => 'ตุลาคม',
	'11' => 'พฤศจิกายน',
	'12' => 'ธันวาคม'
);

$tmpExsum[$startYear+1] = array(
	'1' => 'มกราคม',
	'2' => 'กุมภาพันธ์',
	'3' => 'มีนาคม',
	'4' => 'เมษายน',
	'5' => 'พฤษภาคม',
	'6' => 'มิถุนายน',
	'7' => 'กรกฎาคม',
	'8' => 'กรกฎาคม',
	'9' => 'กันยายน',
);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<title>ระบบฐานข้อมูลลงทะเบียนขอรับสิทธิเงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/style_menu.css">
<script src="../js/jquery-latest.min.js" type="text/javascript"></script>
<script src="../js/jquery-latest.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){			
		 var newWindowHight = $(window).height();
		 var height = newWindowHight-180;
		  //document.getElementById("ifram").style.height = height+'px';
		  
		$('#button_filter').click(function(){
			$('#filter_box').toggle();
		});  
		$('#filter_box_submit').click(function(){
			$('form[name="filter_box"]').submit();
		});
	});
</script>
<style>
 .style7 {color: #000; }
.highlight {
    background-color: #FFFF88;
}
#ppDriverTable th{
	 background:#dfdfdf; /*ปรับสีหัวตาราง แดชบอร์ด*/
 }
#ppDriverTable tbody tr:nth-child(even) {background: #fff} /*ปรับสีสลับช่องตารางแดชบอร์ด*/
#ppDriverTable tbody tr:nth-child(odd) {background: #ebebeb}
#ppDriverTable tbody tr:hover{ background:#FF9}

/* ส่วนกำหนดสำหรับ แสดง iframe  */
div#myiframe_position1{

	position:relative;
	display:block;	
	width:440px; /*ความกว้างส่วนของเนื้อหา iframe ที่ต้องการแสดง*/
	height:250px; /* ความสูงส่วนของเนื้อหา iframe ที่ต้องการแสดง */
	overflow:hidden;
}
/* ส่วนกำหนด สำหรับ iframe */
div#myiframe_position1 iframe{
	position:absolute;
	display:block;
	float:left;
	margin-top:-50px; /* ปรับค่าของ iframe ให้ขยับขึ้นบนตามตำแหน่งที่ต้องการ */
	margin-left:0px; /* ปรับค่าของ iframe ให้ขยับมาด้านซ้ายตามตำแหน่งที่ต้องการ */
}

#filter_box{
	border: 1px solid #ccc;
	height: 234px;
	position: absolute;
	width: 485px;  
	background: #fff;
	opacity: .9;
	display:none;
	padding: 10px;
}

#filter_box tr{
	  height: 30px;
}
#filter_box table{
margin: 20px 0 0 0;
}

#poster{
	height: 290px; 
	position: relative; 
	left: 156px; 
	z-index: -1;
}
</style>
</head>

<body>
<?php $box_search = 'on';  include "header.php";?>
<?php
	if(isset($_GET['column'])){$column = $_GET['column'];}else{$column = 'eq_id';}
	if(isset($_GET['order'])){$order = $_GET['order'];}else{$order = 'DESC';}
	if(isset($_GET['column1'])){$column1 = $_GET['column1'];}else{$column1 = '';}
	if(isset($_GET['order1'])){$order1 = $_GET['order1'];}else{$order = '';}
	
	require_once("lib/class.function.php");
	$con = new Cfunction();
	$strSQL = "SELECT master_id FROM question_master";
	$con->connectDB() ;
	$objQuery = mysql_query($strSQL);
	$Num_Rows = mysql_num_rows($objQuery);
	$TatalRows = $Num_Rows;
	
		#หน่วยงาน
		$sql_org = "SELECT groupname FROM org_staffgroup WHERE gid='".$_SESSION['session_group']."'";
		$con->connectDB(HOST,USER,PWD,DB_USERMANAGER) ;
		mysql_select_db(DB_USERMANAGER);
		$result_org = mysql_query($sql_org)or die(mysql_error().__LINE__);
		$rs_org = mysql_fetch_assoc($result_org);
	
	
	require_once("lib/class.function.php");
	$con = new Cfunction();
	
	


	
		
		$keyword = "";
		$where = "";
		if($_GET["keyword"] != ""){
			$keyword = $_GET["keyword"];
		}
		else{
			$keyword = "";	
		}
	 if($_POST) 
	 {

		 if($_POST['eq']){
			$filter['relation'] = 'LEFT JOIN eq_approve_person ON eq_person.eq_idcard = eq_approve_person.idcard';
			$filter_list = array('leader','decadent_house','occupant','landless','carless','other');
			$filter['condition'] = 'AND ( ';
			foreach($filter_list as $attr){
				$filter['condition'] .= ($_POST['eq'][$attr]=='on')? $attr .' = 1 OR ':'';
				$filter['attribute'] .= ',eq_approve_person.'.$attr;
			}			
			$filter['condition'] .= '0)';
		 }
		 
		 if($_POST['search_info']!='') // ตรวจสอบว่า มีค่าว่างหรือเปล่า
		 {
			$keyword = $_POST['search_info'];
			$where = " AND (
							eq_person.eq_idcard like '%".$_POST['search_info']."%' 
							OR eq_person.eq_firstname like '%".$_POST['search_info']."%' 
							OR eq_person.eq_lastname like '%".$_POST['search_info']."%' 
							OR eq_child.eq_idcard like '%".$_POST['search_info']."%' 
							OR eq_child.eq_firstname like '%".$_POST['search_info']."%' 
							OR eq_child.eq_lastname like '%".$_POST['search_info']."%'
							)";
		 }
	 }
	 else
	 {
		if($keyword != ""){
		 $where = " AND (eq_person.eq_idcard like '%".$keyword."%' OR eq_person.eq_firstname like '%".$keyword."%' 
						OR eq_person.eq_lastname like '%".$keyword."%')";
						
						
	 }else{
		 
		 if(isset($_GET['ccdigi']))
		 {
			 $where = " AND eq_person.eq_code_district = ".$_GET['ccdigi']	;
		 }else{
			$where = "";	 
		 }
	 }	
		
		 
	 }
	 
	 if($_SESSION['session_group'] != ''){
		$where .= " AND eq_person.eq_gid = '".$_SESSION['session_group']."'";	 
	 }

	
	$sql = 'SELECT eq_person.eq_id';
	$sql .= ' FROM eq_person LEFT JOIN eq_child ON eq_person.eq_idcard = eq_child.eq_mother_idcard'; 
	$sql .= " WHERE 1=1 $where AND eq_person.eq_code_relation = 0 AND eq_person.eq_register_date BETWEEN '{$dateStart}' AND '{$dateEnd}' ";
	if($_GET['debug']=='on'){
		echo "<pre>";
		echo $sql;
		echo "</pre>";
	}

	$con->connectDB() ;
	$objQuery = mysql_query($sql);
	$Num_Rows = mysql_num_rows($objQuery);
	$sumNumRows = $Num_Rows;
	$Per_Page = 50;   // ปรับจำนวนที่ต้องการให้แสดงต่อหน้า
	$Page = '';
	$j = 0;
	if(isset($_GET["Page"]))
	{
		$Page=$_GET["Page"];
		if($Page!=1)
		{
			$j = ($Page*$Per_Page)-$Per_Page;
			$j++;
		}
		else
		{
			$j = 1;
		}
	}
	else
	{
		$Page=1;
		$j = 1;
	}
	$Prev_Page = $Page-1;
	$Next_Page = $Page+1;
	$Page_Start = (($Per_Page*$Page)-$Per_Page);
	if($Num_Rows<=$Per_Page)
	{
		$Num_Pages =1;
	}
	elseif(($Num_Rows % $Per_Page)==0)
	{
		$Num_Pages =($Num_Rows/$Per_Page) ;
	}
	else
	{
		$Num_Pages =($Num_Rows/$Per_Page)+1;
		$Num_Pages = (int)$Num_Pages;
	}
 	$sql = 'SELECT
				eq_child.eq_idcard,
				eq_child.eq_firstname,
				eq_child.eq_lastname,
				eq_person.eq_id,
				eq_person.eq_idcard,
				eq_person.eq_prename,
				eq_person.eq_firstname,
				eq_person.eq_lastname,
				eq_person.eq_age,
				eq_person.eq_gender,
				eq_person.eq_register_date,
				REPLACE(eq_person.eq_district,"อำเภอ","") as eq_district,
				REPLACE(eq_person.eq_parish,"ตำบล","") as eq_parish,
				eq_person.eq_salary,
				eq_person.eq_b4preg_birthmonth,
				eq_person.eq_b4preg_birthyear,
				REPLACE(eq_person.eq_career,"อื่น ๆ,","") as eq_career,
				eq_person.eq_embryo_number as numTb2
				'.$filter['attribute'];
	$sql .= ' FROM eq_person
			LEFT JOIN eq_child ON eq_person.eq_idcard = eq_child.eq_mother_idcard
	'.$filter['relation'];
		 
	if(isset($_GET['show']))
	 {
		 $Num_Pages = 1;
		$sql .= " WHERE eq_person.eq_register_date BETWEEN '{$dateStart}' AND '{$dateEnd}' $where {$filter['condition']}";
		
		if(isset($_GET['order']))
		{
			$sql .=' GROUP BY eq_person.eq_idcard ORDER BY eq_person.'.$column.' '.$order.' '.$column1.' '.$order1;
		}
	 }
	 else
	 {
	

	$sql .= " WHERE 1=1 AND eq_person.eq_code_relation = 0 AND eq_person.eq_register_date BETWEEN '{$dateStart}' AND '{$dateEnd}' $where {$filter['condition']}";
	$sql .=' ORDER BY eq_person.'.$column.' '.$order.' '.$column1.' '.$order1;
		if(isset($_GET['ccdigi'])){
			$sql .=' LIMIT '.$Page_Start.','.$Per_Page;
			}
		else
		{
			$sql .=' LIMIT '.$Page_Start.','.$Per_Page;
		}
	 }
	$con->connectDB() ;
	$results = $con->select($sql);
	if($_GET["debug"] == "on"){
		echo $sql;
		echo "<hr>sql_org=>".$sql_org."<hr>";
	}
?>
	
<p>
<script type="text/javascript" src="../js/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
		$(document).ready(function() {		
			$('a[id^="show"]').fancybox({
				'width'				: '80%',
				'height'			: '100%',
				'autoScale'     	: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe',
				onClosed	:	function() {
				}
			});
		});
		
		
		function changeFontSize(type){
			if(type == 'small'){
				var Fsize = parseInt($('#fontsize').val())-1;
				if(Fsize <= 20){
					$('#large').attr('src','img/icon_large.png');
					$('#large').css('cursor','pointer');
				}
				
				if(Fsize < 12){
					$('#small').attr('src','img/icon_small_dis.png');
					$('#small').css('cursor','default');
				}else{
					$('#small').attr('src','img/icon_small.png');
					$('#small').css('cursor','pointer');
					$('td').css('font-size',Fsize+'px');
					$('font').css('font-size',Fsize+'px');
					$('strong').css('font-size',Fsize+'px');
					$('a').css('font-size',Fsize+'px');
					$('#fontsize').val(Fsize);
				}
			}else if(type == 'large'){
				var Fsize = parseInt($('#fontsize').val())+1;
				if(Fsize >= 12){
					$('#small').attr('src','img/icon_small.png');
					$('#small').css('cursor','pointer');
				}
				
				if(Fsize > 20){
					$('#large').attr('src','img/icon_large_dis.png');
					$('#large').css('cursor','default');
				}else{
					$('#large').attr('src','img/icon_large.png');
					$('#large').css('cursor','pointer');
					$('td').css('font-size',Fsize+'px');
					$('font').css('font-size',Fsize+'px');
					$('strong').css('font-size',Fsize+'px');
					$('a').css('font-size',Fsize+'px');
					$('#fontsize').val(Fsize);
				}
			}
		}
</script>
</p>
<?php
$sql_district_all = "SELECT
SUBSTR(t1.eq_register_date,6,2)*1 AS group_month,
SUBSTR(t1.eq_register_date,1,4) AS group_year,
Count(t1.eq_idcard) AS numperson,
Sum(t1.eq_embryo_number) AS numchild
FROM
eq_person AS t1
WHERE t1.eq_register_date != '0000-00-00' AND eq_register_date BETWEEN '{$dateStart}' AND '{$dateEnd}' AND eq_gid = '".$_SESSION['session_group']."'
GROUP BY SUBSTR(t1.eq_register_date,1,7) ";
$result_district_all  = $con->select($sql_district_all);

$sql_person_math = "SELECT
t1.eq_b4preg_birthyear,
t1.eq_b4preg_birthmonth AS birthmonth,
COUNT(t1.eq_b4preg_birthmonth) AS sum,
SUM(t1.eq_embryo_number) AS child
FROM
eq_person AS t1
WHERE t1.eq_b4preg_birthyear = '{$year2}' AND eq_gid = '".$_SESSION['session_group']."'
GROUP BY t1.eq_b4preg_birthmonth, t1.eq_b4preg_birthyear";
$result_person_math  = $con->select($sql_person_math);

foreach($result_person_math as $id => $detail){
	$arrPersonMath[$detail['eq_b4preg_birthyear']][$detail['birthmonth']] = $detail['sum'];
	$arrChild[$detail['eq_b4preg_birthyear']][$detail['birthmonth']] = $detail['child'];

	$sumMath += $detail['sum'];
	$sumChild += $detail['child'];
}

foreach($result_district_all as $id => $detail){
	$arrExsum[$detail['group_month']]['group_year'] = $detail['group_year'];
	$arrExsum[$detail['group_month']]['numperson'] = $detail['numperson'];
	$arrExsum[$detail['group_month']]['numchild'] = $detail['numchild'];
	$sumPerson += $detail['numperson'];
	
}

if($_GET['debug'] == 'on'){
	echo '<pre>';
	echo $sql_district_all;
	echo '<hr>';
	echo $sql_person_math;
	print_r($arrPersonMath);
	print_r($arrChild);
	echo $startYear;
	echo '</pre>';
}
echo "<h3><center>".$rs_org['groupname']."</center></h3>";
?>

<table width="100%" border="0" cellspacing="5" cellpadding="0">
  <tr><td colspan="6" align="right">
  <img src="../img/icon_setting.png" id="button_filter" style="cursor:pointer; display:none;">
  
  <img src="img/icon_small_dis.png" id="small" onClick="changeFontSize('small');" style="cursor:default;" title="ลดขนาดตัวอักษร">
  <img src="img/icon_large.png" id="large" onClick="changeFontSize('large');"  style="cursor:pointer;" title="เพิ่มขนาดตัวอักษร">
  <input type="hidden" id="fontsize" name="fontsize" value="12">
  </td></tr>
  <tr>
    <td rowspan="5" align="center" valign="top"><TABLE width="90%" border="0"  cellspacing="1" cellpadding="3"  bgcolor="#BBCEDD"  class="ppDriverTable" id="ppDriverTable" style="border-radius:2px;">
      <TR>
        <TD width="25%" rowspan="3" align="center"  bgcolor="#DFDFDF">เดือนปี</TD>
        <TD colspan="6" align="center" bgcolor="#DFDFDF">
        <a href="dashboard.php?year=<?php echo $year2-1?>"><<</a>   
        ปีงบประมาณ <?php echo $year2 ?>  
        <a href="dashboard.php?year=<?php echo $year2+1?>">>></a>
        </TD>
      </TR>
	  <TR>
		<TD align="center" colspan="2" bgcolor="#DFDFDF">จำนวนผู้ลงทะเบียนทั้งหมด </TD>
		<TD align="center" colspan="2" bgcolor="#DFDFDF">ครบกำหนดคลอด</TD>
        <TD width="15%" align="center" rowspan="2" bgcolor="#DFDFDF">จำนวนบุตร</TD>
		<TD width="18%" align="center" rowspan="2" bgcolor="#DFDFDF">ประมาณค่าใช้จ่ายต่อเดือน(จำนวนบุตร X 400)</TD>
	  </TR>
      <TR>
        <TD width="13%" height="30" align="center"  bgcolor="#DFDFDF">คน</TD>
        <TD width="8%" align="center" bgcolor="#DFDFDF">ร้อยละ</TD>
        <TD width="13%" height="30" align="center"  bgcolor="#DFDFDF">คน</TD>
        <TD width="8%" align="center" bgcolor="#DFDFDF">ร้อยละ</TD>
      </TR>
      <tbody>
        <?php
		$percent1 = 100;
		$percent2 = 100;
	  	foreach($tmpExsum[$startYear] as $key => $month){
			$color = '';
		   if(isset($_GET['ccdigi'])) {
				if($code[$i]==$_GET['ccdigi']){
			 		$color = 'style="background:#FF9"';
				}
		   }
		   
		   $personPer = ($arrExsum[$key][numperson] > 0) ? number_format(($arrExsum[$key][numperson] * 100) / $sumPerson,2) : 0;
		   $personPer = ($percent1 > $personPer) ? $personPer : $percent1;
		   $percent1 =  $percent1 - $personPer;
		   
		   $numMath = $arrPersonMath[$startYear+543][$key];
		   $numchild = $arrChild[$startYear+543][$key];

		   $mathPer = ($numMath > 0) ? number_format(($numMath * 100) / $sumMath,2) : 0;
		   $mathPer = ($percent2 > $mathPer) ? $mathPer : $percent2;
		   $percent2 =  $percent2 - $mathPer;
	  	?>
        <TR <?php echo $color; ?> >
          <TD  align="left" height="20"><?php echo $arr_month[$key-1].' '.($startYear+543);?></TD>
          <TD  align="right"><?php echo number_format($arrExsum[$key][numperson]); ?></TD>
          <TD  align="right"><?php echo number_format($personPer,2); ?></TD>
          <TD  align="right"><?php echo number_format($numMath); ?></TD>
		  <TD  align="right"><?php echo number_format($mathPer,2); ?></TD>
		  <TD  align="right"><?php echo number_format($numchild); ?></TD>
          <TD  align="right"><?php echo number_format($numchild*400,2); ?></TD>
          </TR>
		<?php
        $sumPercent1 += $personPer;
        $sumPercent2 += $mathPer;
        }
		
		foreach($tmpExsum[$startYear+1] as $key => $month){
			$color = '';
		   if(isset($_GET['ccdigi'])) {
				if($code[$i]==$_GET['ccdigi']){
			 		$color = 'style="background:#FF9"';
				}
		   }
		   
		   $personPer = ($arrExsum[$key][numperson] > 0) ? number_format(($arrExsum[$key][numperson] * 100) / $sumPerson,2) : 0;
		   $personPer = ($percent1 > $personPer) ? $personPer : $percent1;
		   $percent1 =  $percent1 - $personPer;
		   
		   $numMath = $arrPersonMath[$startYear+544][$key];
		   $numchild = $arrChild[$startYear+544][$key];
		   
		   $mathPer = ($numMath > 0) ? number_format(($numMath * 100) / $sumMath,2) : 0;
		   $mathPer = ($percent2 > $mathPer) ? $mathPer : $percent2;
		   $percent2 =  $percent2 - $mathPer;
	  	?>
        <TR <?php echo $color; ?> >
          <TD  align="left" height="20"><?php echo $arr_month[$key-1].' '.(($startYear+1)+543);?></TD>
          <TD  align="right"><?php echo number_format($arrExsum[$key][numperson]); ?></TD>
          <TD  align="right"><?php echo number_format($personPer,2); ?></TD>
          <TD  align="right"><?php echo number_format($numMath); ?></TD>
		  <TD  align="right"><?php echo number_format($mathPer,2); ?></TD>
		  <TD  align="right"><?php echo number_format($numchild); ?></TD>
          <TD  align="right"><?php echo number_format($numchild*400,2); ?></TD>
          </TR>
		<?php
        $sumPercent1 += $personPer;
        $sumPercent2 += $mathPer;
        }
        ?>
        </tbody>
      	<tfoot>
        <TR bgcolor="#FFFFFF" >
          <TD align="left" height="20"><strong>รวม</strong></TD>
          <TD align="right" ><strong><?php echo number_format($sumPerson); ?></strong></TD>
          <TD align="right" ><strong><?php echo number_format($sumPercent1,2); ?></strong></TD>
          <TD align="right" ><strong><?php echo number_format($sumMath); ?></strong></TD>
		  <TD align="right" ><strong><?php echo number_format($sumPercent2,2); ?></strong></TD>
          <TD align="right" ><strong><?php echo number_format($sumChild); ?></strong></TD>
          <TD  align="right"><?php echo number_format($sumChild*400,2); ?></TD>
          </TR>
        </tfoot>
    </TABLE></td>
    <td width="31%" align="left" valign="top" style="position:relative">
		<div id="filter_box">
			<form method="post" name="filter_box">
			<span><center><b>ค้นหาจากข้อมูลประกอบการพิจารณาสถานะของครัวเรือน</b></center></span>
				<table>
					<tr>
						<td>
							<input 	type="checkbox" 
									name="eq[leader]" 
									<?= $_POST['eq']['leader']=='on'?'CHECKED':''?>>
						</td>
						<td>
							มีภาระพึ่งพิง ได้แก่ ในครอบครัวมีคนพิการ หรือ ผู้สูงอายุ หรือเด็กอายุต่ำกว่า 15 ปี หรือคนว่างงานอายุ 15 - 65 ปี หรือเป็นพ่อ/แม่เลื้ยงเดียว
						</td>
					</tr>
					<tr>
						<td>
						<input 	type="checkbox" 
								name="eq[decadent_house]" 
								<?= $_POST['eq']['decadent_house']=='on'?'CHECKED':''?>>
						</td>
						<td>สภาพบ้านชำรุดทรุดโทรม บ้านทำจากวัสดุพื้นบ้าน เช่น ไม้ไผ่ ในจาก..........เป็นต้น หรือวัสดุเหลือใช้ หรืออยู่บ้านเช่า</td>
					</tr>
					<tr>
						<td>
						<input 	type="checkbox" 
								name="eq[occupant]" 
								<?= $_POST['eq']['occupant']=='on'?'CHECKED':''?>></td>
						<td>สถานภาพในครัวเรือน เช่น เป็นผู้อาศัย</td>
					</tr>
					<tr>
						<td><input 	type="checkbox" 
								name="eq[landless]" 
								<?= $_POST['eq']['landless']=='on'?'CHECKED':''?>></td>
						<td>เป็นเกษตรกรมีที่นาไม่เกิน 1 ไร่</td>
					</tr>
					<tr>
						<td><input 	type="checkbox" 
								name="eq[carless]" 
								<?= $_POST['eq']['carless']=='on'?'CHECKED':''?>></td>
						<td>ไม่มีรถยนต์ส่วนบุคคล รถปิคอัพ รถบรรทุกเล็ก รถตู้</td>
					</tr>
					<tr>
						<td><input 	type="checkbox" 
								name="eq[other]" 
								<?= $_POST['eq']['other']=='on'?'CHECKED':''?>></td>
						<td>อื่น ๆ</td>
					</tr>
				</table>
				
				<div style="  position: absolute;
							  right: 12px;
							  bottom: 8px;">
					<img src="../img/search_data.png" style="cursor: pointer;" id="filter_box_submit">
				</div>
			</form>
		</div>	
		<img id="poster" src="../img/image_24.jpg">

	</td>
  </tr>
  <tr>
   <?php 
  			$sql_lastdate = 'select eq_date_modify from eq_person order by eq_date_modify desc LIMIT 0,1'; 
  			$results_lastdate = $con->select($sql_lastdate);
			//foreach($results_lastdate as $rtt){}
			$date = new DateTime($results_lastdate['eq_date_modify']); 
			$lastdate = $date->format('j/n/Y');
			$lasttime = $date->format('H:i:s');
  ?>
  
    <td align="right" valign="bottom" height="10"><img src="../img/line.jpg">ข้อมูล ณ วันที่
      <?php $today = $con->reportDay($lastdate); echo $today[0].' '.$today[1].' '.($today[2]+543); ?> เวลา <?php echo $lasttime; ?></td>
  </tr>
  <tr>
    <td align="right" valign="bottom" height="10">รายงาน ณ วันที่
    <?php $today = $con->reportDay(date('j/n/Y')); echo $today[0].' '.$today[1].' '.($today[2]+543); ?>
    <img src="../img/line.jpg"></td>
  </tr>
  <tr>
  </tr>
  <?php
		if($_POST || $keyword != "") {
			function getMicrotime()
			{
				list( $useg , $seg ) = explode( ' ' , microtime() );
				return ( (float)$useg + (float)$seg );
			}
     ?>
  <tr>
    <td colspan="2" align="left">
    
    
      <TABLE width="100%" style="border:1px #E2EEF3 solid;">
                            <TR>
                                    <TD><FONT COLOR="#000033"><b>ค้นหาคำว่า</b></FONT> <?php echo $keyword; ?></TD>
                                    <TD align="right" valign="top">จำนวนที่ค้นพบ&nbsp;
                                            <?php 
											echo $sumNumRows;
											?>
                                            &nbsp;รายการ</TD>
                            </TR>
      </TABLE>
    
    </td>
  </tr>
  <?php } ?>

  <tr>
  </tr>
      <td align="right" colspan="2">
<!---------------------------------------------pagechange------------------------------------------------------>

<?php
	if(isset($_GET['ccdigi'])){
		 $pageccdigi = "ccdigi=".$ccdigi."";
		 }
	if($_SESSION['user'] !='')
	{
		$url_form = '?frame=error404';
	}
	else
	{
		$url_form = '?frame=dr_doc1';
		
	}
?>
  <!--<input type="submit" name="button" id="button" value="EXPORT-Excel"  onClick="location.href='excel/reporttoexcel.php'">-->
  <a href="question_form.php<?php echo $url_form; ?>" style="color:#FFF ; text-decoration:none;"><img src="../img/add_data.png" class="textmidle" hspace="5" title="เพิ่มข้อมูลผู้ลงทะเบียนขอรับสิทธิ์เงินอุดหนุน"></a>
</td>
  </tr>
  <tr>
    <td colspan="2"><TABLE width="100%" border="0" cellspacing="1" cellpadding="3" id="ppDriverTable" NAME="ppDriverTable" class="dtree" bgcolor="#BBCEDD" >
      <tr  class="style7">
        <td width="34" align="center" >ลำดับ</th>
        <td width="121" align="center" ><a href="?<?php echo $pageccdigi ?>&year=<?php echo $year2?>&column=eq_idcard&order=<?php echo $con->sortData('eq_idcard',$column,$order);?>&keyword=<?php echo $keyword ?><?php if(isset($_GET['show'])){echo '&show=all';} ?>" >เลขประจำตัวประชาชน</a></td>
        <td width="170" align="center"><a href="?<?php echo $pageccdigi ?>&year=<?php echo $year2?>&column=eq_firstname&order=<?php echo $con->sortData('eq_firstname',$column,$order); ?>&keyword=<?php echo $keyword ?><?php if(isset($_GET['show'])){echo '&show=all';} ?>">ชื่อ-นามสกุล (มารดา)</a></td>
        <td width="70" align="center" style="display:none;"><a href="?<?php echo $pageccdigi ?>&year=<?php echo $year?>&column=eq_age&order=<?php echo $con->sortData('eq_age',$column,$order); ?>&keyword=<?php echo $keyword ?><?php if(isset($_GET['show'])){echo '&show=all';} ?>">อายุ(ปี)</a></td>
        <td width="108" align="center"><a href="?<?php echo $pageccdigi ?>&year=<?php echo $year2?>&column=eq_embryo_number&order=<?php echo $con->sortData('eq_embryo_number',$column,$order); ?>&keyword=<?php echo $keyword ?><?php if(isset($_GET['show'])){echo '&show=all';} ?>">จำนวนบุตร (คน)</a></td>
        <!-- <td width="70" align="center"><a href="?<?php echo $pageccdigi ?>&column=eq_gender&order=<?php echo $con->sortData('eq_gender',$column,$order); ?>&keyword=<?php echo $keyword ?><?php if(isset($_GET['show'])){echo '&show=all';} ?>">เพศ</a></td> -->
        <td width="158" align="center"><a href="?<?php echo $pageccdigi ?>&year=<?php echo $year2?>&column=eq_register_date&order=<?php echo $con->sortData('eq_register_date',$column,$order); ?>&keyword=<?php echo $keyword ?><?php if(isset($_GET['show'])){echo '&show=all';} ?>">วันที่ลงทะเบียน</a></td>
        <td width="114" align="center"><a href="?<?php echo $pageccdigi ?>&year=<?php echo $year2?>&column=eq_b4preg_birthyear&order=<?php echo $con->sortData('eq_b4preg_birthyear',$column,$order); ?>&column1=,eq_b4preg_birthmonth&order1=<?php echo $con->sortData('eq_b4preg_birthmonth',$column1,$order1); ?>&keyword=<?php echo $keyword ?><?php if(isset($_GET['show'])){echo '&show=all';} ?>">เดือนปี (ครบกำหนดคลอด)</a></td>
        <td width="63" align="center" style="display:none;"><a href="?<?php echo $pageccdigi ?>&column=eq_district&order=<?php echo $con->sortData('eq_district',$column,$order); ?>&keyword=<?php echo $keyword ?><?php if(isset($_GET['show'])){echo '&show=all';} ?>">ที่อยู่ผู้รับสิทธิ์</a></td>
        <td align="center">จัดการ</td>
        </tr>
      <?php
		//$i = 0;
		foreach($results as $row){
		?>
      <tr class="data">
        <td align="center"><?php echo $j; ?></td>
        <td align="center"><?php echo str_replace($keyword,"<span style='background-color:#FFFF00'>".replacepin($keyword)."</span>",replacepin($row['eq_idcard'])); ?></td>
        <td align="left"><?php echo $row['eq_prename']; ?><?php echo str_replace($keyword,"<span style='background-color:#FFFF00'>".$keyword."</span>",$row['eq_firstname']); ?> <?php echo str_replace($keyword,"<span style='background-color:#FFFF00'>".$keyword."</span>",$row['eq_lastname']); ?></td>
        <td align="center" style="display:none;"><?php echo $row['eq_age']; ?></td>
        <td align="center"><?php echo $row['numTb2']; ?></td>
        <td align="left"><?php
			$arrDate = explode('-',$row['eq_register_date']);
			echo ($arrDate[2]*1).' '.$arr_month[ $arrDate[1]-1].' '.($arrDate[0]+543);
		?></td>
        <td align="left"><?php 
		echo ($row['eq_b4preg_birthmonth'] != '') ? $arr_month[$row['eq_b4preg_birthmonth']-1].' '.$row['eq_b4preg_birthyear'] : '';
		 ?></td>
        <td align="left" style="display:none;"><?php echo $row['eq_district']; ?></td>
       	<td width="40" align="center"><a href="question_form.php?frame=dr_doc1&id=<?php echo $row['eq_idcard']; ?>&eq_id=<?php echo $row['eq_id']; ?>"><img src="../img/b_edit.png" width="16" height="16" border="0"></a>&nbsp;
          <a href="main_exc/from1_del_exc.php?id=<?php echo $row['eq_idcard']; ?>&eq_id=<?php echo $row['eq_id']; ?>" onClick="return confirm('คณต้องการลบข้อมูลนี้ออกจากตาราง?')"><img src="../img/b_drop.png" width="16" height="16" border="0"></a></td>
      </tr>
      <?php
	  		$j++;
		} 
	?>
    </TABLE></td>
  </tr>
  <tr>
	<td  align="right" valign="bottom" colspan="2"> 
		ทั้งหมด <font color="#CC0000"> <?php echo $sumNumRows; ?></font> รายการ <?php if($_GET['show']){}else{echo 'แบ่งเป็น <font color="#0033CC">'.$Num_Pages.'</font> หน้า&nbsp;&nbsp;&nbsp;';} ?> <a href="dashboard.php?<?php echo $pageccdigi; ?>&year=<?php echo $year2; ?><?php if($_GET['show']){}else{echo '&show=all';} ?>"><?php if($_GET['show']){echo 'แบ่งหน้า';}else{echo 'แสดงทั้งหมด';} ?></a>
			  <?php
		if($Prev_Page)
		{
			echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&year=$year2&column=$column&order=$order&$pageccdigi'><img src=\"../img/First.gif\"></a> ";
		}
		if($Num_Pages!=1)
		{
			for($i=1; $i<=$Num_Pages ; $i++){
				if($i!=$Page)
				{			
					echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$i&year=$year2&column=$column&order=$order&$pageccdigi&keyword=$keyword'>$i</a> ";
				}else{
					echo "<b>$i</b>";
					}
				
			}
		}

		if($Page!=$Num_Pages)
		{
			echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&year=$year2&column=$column&order=$order&$pageccdigi&keyword=$keyword'><img src=\"../img/Last.gif\"></a> ";
		}
		?>
	</td>
  </tr>
</table>
<p>&nbsp;</p>

</body>
</html>