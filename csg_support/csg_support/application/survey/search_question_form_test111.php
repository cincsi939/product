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
 ?>
 <?php
error_reporting(E_ALL ^ E_NOTICE);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<title>แบบสอบถามสภาพครอบครัว</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/style_menu.css">
<!--<script src="../js/jquery-latest.min.js" type="text/javascript"></script>
<script src="../js/jquery-latest.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){			
		 var newWindowHight = $(window).height();
		 var height = newWindowHight-180;
		  //document.getElementById("ifram").style.height = height+'px';
	});
</script>-->
<!--  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="./tablesort/stupidtable.js?dev"></script>
    <script>
    $(function(){
        $("#ppDriverTable").stupidtable();
    });
  </script>-->
  <!--<script src="./tablesort/jquery-latest.js"></script>
  <script src="./tablesort/jquery.metadata.js"></script>
  <script src="./tablesort/jquery.tablesorter.js"></script>
  <script type="text/javascript">
	
	$(function() {
		$("#ppDriverTable").tablesorter({
			debug:true,
			headers: {
         7: { sorter: 'digit' } // column number, type
     }
			});
	});
	
		</script>	-->
  
<style>
 .style7 {color: #000; font-weight: bold; }
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
</style>
</head>

<body>
<!--<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="80" width="100" valign="top" background="../img/back01_07.png"><img src="../img/logo_1_02.png"></td>
    <td width="490" height="80" align="left" valign="top" background="../img/back01_07.png"><img src="../img/logo2_03.png"></td>
    <td height="80" colspan="7" align="right" background="../img/back01_07.png"><img src="../img/logo5_08.png" height="79"></td>
  </tr>
  <tr height="34" align="center" valign="middle">
    <td background="../img/background_06.png">&nbsp;</td>
    <td background="../img/background_06.png">&nbsp;</td>
    <td background="../img/background_06.png" width="228">&nbsp;</td>
    <td background="../img/background_06.png" width="39" align="right"><a href="question_form.php"><img src="../img/icon1_6.png" width="39" height="26 " title="หน้าหลัก"></a></td>
	<td background="../img/background_06.png" width="39" align="right"><a href="question_form.php"><img src="../img/icon1_2.png" width="39" height="26" title="Dashboard"></a></td>
    <td background="../img/background_06.png" width="39" align="right"><a href="http://61.19.255.77/reportbuilder/report_preview.php?id=396"><img src="../img/icon1_1.png" width="39" height="26" title="รายงานผลการสำรวจสภาพครอบครัว"></a></td>
    <td background="../img/background_06.png" width="39" align="right"><a href="search_question_form.php"><img src="../img/icon1_3.png" width="39" height="26" title="ค้นหา"></a></td>
    <td background="../img/background_06.png" width="39" align="right"><a href="question_form.php?frame=form_excel"><img src="../img/icon1_4.png" width="39" height="26" title="ส่งออก Excel"></a></td>
    <td background="../img/background_06.png" width="39" align="right"><a href="../usermanager/login.php"><img src="../img/icon1_5.png" width="39" height="26" title="ออกจากระบบ" ></a></td>
  </tr>
  <?php
	if(!isset($_GET['frame']))
	{
  ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="7" align="right"></td>
  </tr>
  <?php
	}
  ?>
</table>-->
<?php
$box_search = 'off'; 
include "header.php";


?>
<?php
if(isset($_GET['frame']))
{
	if(($_GET['frame']=='form1') or ($_GET['frame']=='form2') or ($_GET['frame']=='form3') or ($_GET['frame']=='form4') or ($_GET['frame']=='form5'))
	{
		if(isset($_GET['id']))
		{
			$id = $_GET['id'];
		}
		else
		{
			$id = '';
		}
?>


<?php }else{ 
		include('main/'.$_GET['frame'].'.php');
	}
}
else
{
	if(isset($_GET['column'])){$column = $_GET['column'];}else{$column = 'master_id';}
	if(isset($_GET['order'])){$order = $_GET['order'];}else{$order = 'DESC';}
	require_once("lib/class.function.php");
	$con = new Cfunction();
	$strSQL = "SELECT master_id FROM question_master";
	$con->connectDB() ;
	$objQuery = mysql_query($strSQL);
	$Num_Rows = mysql_num_rows($objQuery);
	$TatalRows = $Num_Rows;
	
	require_once("lib/class.function.php");
	$con = new Cfunction();
	
		
		$keyword = "";
		$where = "";
		$key_array = "id_card";
		//$sort_array = "ASC";
		$sort_array = ($_GET['sort']=='DESC' || $_GET['sort']=='')?'ASC':'DESC';
$arr_icon = array('DESC'=>'sort-desc.gif','ASC'=>'sort-asc.gif');

if($_GET['orderby']!=''){
	$sqlOrderby = "ORDER BY ".$_GET['orderby']." ".$ordertype;
}
		if($_REQUEST){
			if($key_arr != ""){
			$key_array = $key_arr;
			}
			/*if($sort != ""){
			$sort_array = $sort;
			}*/
			$keyword = $search_info;
		}
		$j = 0;
		
/*	 if($_POST) 
	 {
		 if($_POST['search_info']!='') // ตรวจสอบว่า มีค่าว่างหรือเปล่า
		 {*/
		if($keyword != "" ){
			
			if(preg_match("/^อาชีพ/",$keyword)==1){
				$search = str_replace("อาชีพ ", "",$keyword);
				$search = trim($search);
				$where = " AND  REPLACE(LEFT(REPLACE(REPLACE(REPLACE(question_detail_1.question_career,'\"',''),'[',''),']',''),2),',','') IN (SELECT career_id FROM tbl_career WHERE career_title LIKE '%".$search."%')";
				$where2 = " AND 1=0";
				$replace = "<span style='background-color:#FFFF00'>".$search."</span>";
			 }else if(preg_match("/^อำเภอ/",$keyword)==1){
				 $search = str_replace("อำเภอ ", "",$keyword);
				 $search = trim($search);
				 $where = " AND  question_district IN (SELECT ccDigi FROM `ccaa` WHERE ccName LIKE '%".$search."%' AND ccType = 'Aumpur')";
				$where2 = " AND 1=0";
				$replace = "<span style='background-color:#FFFF00'>".$search."</span>";
			 }
			 else if(preg_match("/^ตำบล/",$keyword)==1){
			 	 $search = str_replace("ตำบล ", "",$keyword);
				 $search = trim($search);
				 $where = " AND  question_parish IN (SELECT ccDigi FROM `ccaa` WHERE ccName LIKE '%".$search."%' AND ccType = 'Tamboon')";
				 $where2 = " AND 1=0";
				 $replace = "<span style='background-color:#FFFF00'>".$search."</span>";
			 }
			 else{
				 
			$search = trim($keyword);
			$search = explode(" ",$search);
			if(count($search)<=1){
				$search = trim($keyword);
				$where = " AND (master_idcard like '%".$keyword."%' OR question_firstname like '%".$keyword."%' 
						OR question_lastname like '%".$keyword."%')";
				$where2 = "AND (tbl2_name LIKE '%".$keyword."%' OR tbl2_idcard LIKE '%".$keyword."%') ";
				$replace = "<span style='background-color:#FFFF00'>".$search."</span>";
				
			}else{
				//$replace = array();		
					for($i=0;$i<count($search);$i++){		
					if($i==0){
						$where =" AND (master_idcard like '%".$search[$i]."%' OR question_firstname like '%".$search[$i]."%' 
						OR question_lastname like '%".$search[$i]."%'    ";
						$where2 = "AND (tbl2_name LIKE '%".$search[$i]."%' OR tbl2_idcard LIKE '%".$search[$i]."%' ";
					}else{
						$where .= " OR master_idcard like '%".$search[$i]."%' OR question_firstname like '%".$search[$i]."%' 
						OR question_lastname like '%".$search[$i]."%'    ";
						$where2 .= " OR tbl2_name LIKE '%".$search[$i]."%' OR tbl2_idcard LIKE '%".$search[$i]."%' ";
					}
					
					$replace[] = "<span style='background-color:#FFFF00'>".$search[$i]."</span>";
				}
				$where .=" )";
				$where2 .=" )";
				
			}
			 }
		}else{
			$where = " AND 1 = 0";	
			$where2 = " AND 1 = 0";
		}
		
			//echo $where;
			//die();	
			
			$sql ="SELECT question_id,master_id,master_idcard,master_round,master_idques,question_firstname,question_lastname,question_sex,question_age,question_Income,question_career,question_career_detail,REPLACE(getCCAA(LEFT(question_parish,6)),'ตำบล','') as question_parish,REPLACE(getCCAA(LEFT(question_district,4)),'อำเภอ','') as question_district,prename_th,getTb2(1,question_id) as numTb2
	FROM question_master INNER JOIN question_detail_1 ON question_detail_1.question_main = question_master.master_id INNER JOIN tbl_prename ON tbl_prename.id = question_prename
	WHERE 1=1 $where
	";
	//echo $sql;
	$query = mysql_query($sql);
	$arr = array();

	while($rs = mysql_fetch_assoc($query)){
	
		$arr[trim($rs["question_firstname"])." ".trim($rs["question_lastname"])]["id_card"] = $rs["master_idcard"];
		$arr[trim($rs["question_firstname"])." ".trim($rs["question_lastname"])]["name"] = $rs["prename_th"].$rs["question_firstname"]." ".$rs["question_lastname"];
		$arr[trim($rs["question_firstname"])." ".trim($rs["question_lastname"])]["age"] = $rs["question_age"];
		$arr[trim($rs["question_firstname"])." ".trim($rs["question_lastname"])]["sex"] = $rs["question_sex"];
		if($con->careerSelect($rs["question_career"]) == "อื่นๆ"){
			if($rs["question_career_detail"] == "" || $rs["question_career_detail"] == "-"){
				$arr[trim($rs["question_firstname"])." ".trim($rs["question_lastname"])]["occupation"] = "ไม่ระบุ";
			}else{
				$arr[trim($rs["question_firstname"])." ".trim($rs["question_lastname"])]["occupation"] = $rs["question_career_detail"];
			}
		}else{
			if($rs["question_career"] == "null"){
				$arr[trim($rs["question_firstname"])." ".trim($rs["question_lastname"])]["occupation"] = "ไม่ระบุ"	;
			}else{			
				$arr[trim($rs["question_firstname"])." ".trim($rs["question_lastname"])]["occupation"] = $con->careerSelect($rs["question_career"]);
			}
		}
		
		$arr[trim($rs["question_firstname"])." ".trim($rs["question_lastname"])]["salary"] = $rs["question_Income"];
		$arr[trim($rs["question_firstname"])." ".trim($rs["question_lastname"])]["district"] = $rs["question_district"];
		$arr[trim($rs["question_firstname"])." ".trim($rs["question_lastname"])]["subdistrict"] = $rs["question_parish"];
		$arr[trim($rs["question_firstname"])." ".trim($rs["question_lastname"])]["status"] = "เป็นหัวหน้าครอบครัว";
		$arr[trim($rs["question_firstname"])." ".trim($rs["question_lastname"])]["question_id"] = $rs["question_id"];
		$arr[trim($rs["question_firstname"])." ".trim($rs["question_lastname"])]["question_main"] = "";
		
	}
	//echo "<pre>";
	//print_r($arr);
	$sql_prename = "SELECT tbl_prename.prename_th,tbl_prename.id FROM `tbl_prename`";
	$query_prename = mysql_query($sql_prename);
	$prename = array();
	while($rs_prename = mysql_fetch_assoc($query_prename)){
		$prename[$rs_prename["id"]] = $rs_prename["prename_th"];
	}
	$sql_area = "SELECT
REPLACE(getCCAA(LEFT(question_parish,6)),'ตำบล','')  as subdistrict,
REPLACE(getCCAA(LEFT(question_district,4)),'อำเภอ','')  as district,
question_detail_1.question_id
FROM `question_detail_1`
";
	$query_area = mysql_query($sql_area);
	//echo $sql_area;
	$tambon = array();
	$aumphur = array(); 
	while($rs_area = mysql_fetch_assoc($query_area)){
		//echo "a";
		$tambon[$rs_area["question_id"]] = $rs_area["subdistrict"];
		$aumphur[$rs_area["question_id"]] = $rs_area["district"];
		
		//echo $tambon[$rs_area["question_id"]];
	
	}

	$sql2 ="select tbl2_idcard,tbl2_name,tbl2_age,tbl2_sex,main_id,tbl2_prename,tbl2_type from question_tbl2 WHERE 1=1 $where2 ";
	$query2 = mysql_query($sql2);
	while($rs2 = mysql_fetch_assoc($query2)){
		$arr[$rs2["tbl2_name"]]["id_card"] = $rs2["tbl2_idcard"];
		$arr[$rs2["tbl2_name"]]["name"] = $prename[$rs2["tbl2_prename"]].$rs2["tbl2_name"];
		if($rs2["tbl2_age"] != ""){
			$arr[$rs2["tbl2_name"]]["age"] = $rs2["tbl2_age"];
		}else{
			$arr[$rs2["tbl2_name"]]["age"] = "ไม่ระบุ";
		}
		$arr[$rs2["tbl2_name"]]["sex"] = $rs2["tbl2_sex"];
		$arr[$rs2["tbl2_name"]]["occupation"] = "ไม่ระบุ";
		$arr[$rs2["tbl2_name"]]["salary"] = "0";
		$arr[$rs2["tbl2_name"]]["district"] = $aumphur[$rs2["main_id"]];
		$arr[$rs2["tbl2_name"]]["subdistrict"] = $tambon[$rs2["main_id"]];
		if($rs2["tbl2_type"] == 1){
			$arr[$rs2["tbl2_name"]]["status"] = "เป็นสมาชิกกลุ่มเป้าหมายเด็ก";
		}
		else if($rs2["tbl2_type"] == 2){
			$arr[$rs2["tbl2_name"]]["status"] = "เป็นสมาชิกกลุ่มเป้าหมายเยาวชน";
		}
		else if($rs2["tbl2_type"] == 3){
			$arr[$rs2["tbl2_name"]]["status"] = "เป็นสมาชิกกลุ่มเป้าหมายวัยแรงงาน";
		}
		else if($rs2["tbl2_type"] == 4){
			$arr[$rs2["tbl2_name"]]["status"] = "เป็นสมาชิกกลุ่มเป้าหมายวัยผู้สูงอายุ";
		}else if($rs2["tbl2_type"] == 5){
			$arr[$rs2["tbl2_name"]]["status"] = "เป็นสมาชิกกลุ่มเป้าหมายคนพิการ";
		}
		
		$arr[$rs2["tbl2_name"]]["question_main"] = $rs2["main_id"];
		$arr[$rs2["tbl2_name"]]["question_id"] = "";
	}
		

function showIconOrder($column='', $orderby='', $ordertype=''){
		$strIcon = '';
		if($column == $orderby){
			if($ordertype == 'ASC'){
				$strIcon = 'sort-asc.gif';
			}else if($ordertype == 'DESC'){
				$strIcon = 'sort-desc.gif';
			}
		}else{
			$strIcon = 'sort.gif';
		}
		return $strIcon;
	}	
	if($_GET["debug"] == "on"){
		echo "<pre>";
		print_r($arr);
	}
// sort array
	if(!empty($arr)){
	foreach ($arr as $key => $row) {
    $volume[$key]  = $row[$key_array];
	}

	if($sort_array == "DESC" ){
		array_multisort($volume, SORT_DESC, $arr);
	}else{
		array_multisort($volume, SORT_ASC, $arr);
	}
	}
// end sort array


?>

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
</script>
<script>
 var size = 0;
 function ChangeFontSize(type){
  var newsize = 2;
  var zoomin = 4;
  var zoomout = -2;
  var tag = ['table.dtree td','table.dtree td a','table.dtree th.hd_report','table#search_key td','table#search_key td b'];
  var curfont = [] ;
  count = tag.length;
  if(type == 'inc' && size < zoomin){
   if(size == zoomout){
    size++; 
   }
   size++;
   if(size == (zoomin - 1)){
    $('#zoomIn').attr('src','../img/icon_large_dis.png');
    $('#zoomIn').css('cursor','default');
   }else if(size == (zoomout + 1) || size == (zoomout + 2)){
    $('#zoomOut').attr('src','../img/icon_small.png');
    $('#zoomOut').css('cursor','pointer');
   }
  }else if(type == 'dec' && size > zoomout){
   if(size == zoomin){
    size--; 
   }
   size--;
   if(size == (zoomout + 1)){
    $('#zoomOut').attr('src','../img/icon_small_dis.png');
    $('#zoomOut').css('cursor','default');
   }else if(size == (zoomin - 1) || size == (zoomin - 2)){
    $('#zoomIn').attr('src','../img/icon_large.png');
    $('#zoomIn').css('cursor','pointer');
   }
  }
  for(i=0;i<count;i++){
   curfont[i] = parseInt($(tag[i]).css('font-size'));
   if(type == 'inc' && size < zoomin){
    curfont[i] = curfont[i] + newsize;
   }else if(type == 'dec' && size > zoomout){
    curfont[i] = curfont[i] - newsize;
   }
   
   $(tag[i]).css('font-size',curfont[i]);
  }
 }
</script>
<style>
.textbox_search{

    border: 1px solid #c4c4c4; 
    height: 30px; 
    width: 300px; 
    font-size: 13px; 
    padding: 4px 4px 4px 4px; 
    border-radius: 4px; 
    -moz-border-radius: 4px; 
    -webkit-border-radius: 4px; 
    box-shadow: 0px 0px 8px #d9d9d9; 
    -moz-box-shadow: 0px 0px 8px #d9d9d9; 
    -webkit-box-shadow: 0px 0px 8px #d9d9d9; 	
}
.textbox_search:focus { 
    outline: none; 
    border: 1px solid #7bc1f7; 
    box-shadow: 0px 0px 8px #7bc1f7; 
    -moz-box-shadow: 0px 0px 8px #7bc1f7; 
    -webkit-box-shadow: 0px 0px 8px #7bc1f7; 
} 
.classname {
	-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
	-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
	box-shadow:inset 0px 1px 0px 0px #ffffff;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #dfdfdf) );
	background:-moz-linear-gradient( center top, #ededed 5%, #dfdfdf 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#dfdfdf');
	background-color:#ededed;
	-webkit-border-top-left-radius:6px;
	-moz-border-radius-topleft:6px;
	border-top-left-radius:6px;
	-webkit-border-top-right-radius:6px;
	-moz-border-radius-topright:6px;
	border-top-right-radius:6px;
	-webkit-border-bottom-right-radius:6px;
	-moz-border-radius-bottomright:6px;
	border-bottom-right-radius:6px;
	-webkit-border-bottom-left-radius:6px;
	-moz-border-radius-bottomleft:6px;
	border-bottom-left-radius:6px;
	text-indent:0;
	border:1px solid #dcdcdc;
	display:inline-block;
	color:#777777;
	font-family:Courier New;
	font-size:15px;
	font-weight:bold;
	font-style:normal;
	height:40px;
	line-height:40px;
	width:100px;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #ffffff;
}
.classname:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed) );
	background:-moz-linear-gradient( center top, #dfdfdf 5%, #ededed 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed');
	background-color:#dfdfdf;
}.classname:active {
	position:relative;
	top:1px;
}
/* This button was generated using CSSButtonGenerator.com */

</style>
<style>
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
 	body, table, td{
		font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular !important;
		font-size: 18px;
		margin:0px;
	}
 	.hd_report{
	 	font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular !important; font-size: 16px; background-color:#cccccc!important;padding: 4px;
		font-weight: bold;
	}
 </style>


<table width="100%">
	<tr>
    	<td align="right"><!--<img id="zoomOut" src="../img/icon_small.png" title="small" style="width:28px;cursor:pointer;" onClick="ChangeFontSize('dec')">
        <img id="zoomIn" src="../img/icon_large.png" title="large" style="width:28px;cursor:pointer;" onClick="ChangeFontSize('inc')">-->&nbsp;</td>
    </tr>
	<tr>
    	<td>
        <FORM method="post" action="">
      <TABLE width="100%" height="40" border="0" cellspacing="0" cellpadding="0" align="center" >
        <TR>
          
          <TD width="213" align="center">
            <INPUT type="text" class="textbox_search" id="srch_fld"  name="search_info" size="35" align="right" height="50" width="250" onblur="if (this.value == '') {
                                        this.value = 'ค้นหา (เลขบัตร,ชื่อ,นามสกุล)';
                                        document.all.srch_fld.style.color = '#C0C0C0';
                                } else {
                                        document.all.srch_fld.style.color = '#000000';
                                }" onFocus="if (this.value == 'ค้นหา (เลขบัตร,ชื่อ,นามสกุล)') {
                                        this.value = '';
                                        document.all.srch_fld.style.color = '#C0C0C0';
                                } else {
                                        document.all.srch_fld.style.color = '#000000';
                                }"  value="<?php echo ((!empty($keyword)) ? ($keyword) : ((!isset($_GET["reset_search"]) && !empty($_SESSION["search_info"]) ) ? $_SESSION["search_info"] : "ค้นหา (เลขบัตร,ชื่อ,นามสกุล)")); ?>" style="color: #C0C0C0"  onKeyPress="if (this.value == '') {
                                        document.all.srch_fld.style.color = '#C0C0C0';
                                } else {
                                        document.all.srch_fld.style.color = '#000000';
                                }" />&nbsp;&nbsp;<INPUT type="submit" class="classname" name="search" value="ค้นหา" />
          </TD>
          
        </TR>
      </TABLE>
    </FORM>
        </td>
    </tr>
</table>

<table width="100%" border="0" cellspacing="5" cellpadding="0">
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
    
    
      <TABLE width="100%" style="border:1px #E2EEF3 solid;" id="search_key">
                            <TR>
                                    <TD><FONT COLOR="#000033"><b>ค้นหาคำว่า</b></FONT> <?php echo $keyword; ?></TD>
                                    <TD align="right" valign="top">จำนวนที่ค้นพบ&nbsp;
                                            <?php 
											$sql_count_mem = "select count(tbl2_id) as count_mem from question_tbl2";
											$query_count_mem = mysql_query($sql_count_mem);
											$rs_count_mem = mysql_fetch_assoc($query_count_mem);
											$mem_all = $rs_count_mem["count_mem"];
											echo count($arr);
											//echo count($results); 
											?>
                                            &nbsp;รายการจากรายการทั้งหมด <?php echo number_format($mem_all); ?> รายการ</TD>
                            </TR>
      </TABLE>
    
    
    </td>
  </tr>
  <?php } ?>

  <tr>
  </tr>
      <td align="left">
<!---------------------------------------------pagechange------------------------------------------------------>


</td>
   
  </tr>
  <tr>
    <td colspan="2">
	<?php
	if($keyword!=""){
	?>
    <TABLE width="100%" border="0" cellpadding="1" cellspacing="1" style="background-color:#999;" id="ppDriverTable" NAME="ppDriverTable" class="dtree"  >
    <thead>
      <tr  class="style7">
        <!--<th width="34" class="hd_report" >ลำดับ</th>-->
        <th width="121" class="hd_report"  data-sort="string" >เลขประจำตัวประชาชน <a href="?key_arr=id_card&sort=<?php echo $sort_array ?>&search_info=<?php echo $keyword ?>"><img src="http://61.19.255.77/reportbuilder/img/<?php echo showIconOrder('id_card', $_GET['key_arr'], $_GET['sort']);?>"></a></th>
        <th width="170" class="hd_report" data-sort="string">ชื่อ-นามสกุล <a href="?key_arr=name&sort=<?php echo $sort_array ?>&search_info=<?php echo $keyword ?>"><img src="http://61.19.255.77/reportbuilder/img/<?php echo showIconOrder('name', $_GET['key_arr'], $_GET['sort']);?>"></a></th>
        <th width="150" class="hd_report" data-sort="string">สถานะ <a href="?key_arr=status&sort=<?php echo $sort_array ?>&search_info=<?php echo $keyword ?>"><img src="http://61.19.255.77/reportbuilder/img/<?php echo showIconOrder('status', $_GET['key_arr'], $_GET['sort']);?>"></a></th>
        <th width="70" class="hd_report" data-sort="float">อายุ(ปี) <a href="?key_arr=age&sort=<?php echo $sort_array ?>&search_info=<?php echo $keyword ?>"><img src="http://61.19.255.77/reportbuilder/img/<?php echo showIconOrder('age', $_GET['key_arr'], $_GET['sort']);?>"></a></th>
        <th width="70" class="hd_report" data-sort="string">เพศ <a href="?key_arr=sex&sort=<?php echo $sort_array ?>&search_info=<?php echo $keyword ?>"><img src="http://61.19.255.77/reportbuilder/img/<?php echo showIconOrder('sex', $_GET['key_arr'], $_GET['sort']);?>"></a></th>
        <th width="120" class="hd_report" data-sort="string">อาชีพ <a href="?key_arr=occupation&sort=<?php echo $sort_array ?>&search_info=<?php echo $keyword ?>"><img src="http://61.19.255.77/reportbuilder/img/<?php echo showIconOrder('occuaption', $_GET['key_arr'], $_GET['sort']);?>"></a></th>
        <th width="100" class="hd_report"  data-sort="string">รายได้ต่อปี (บาท) <a href="?key_arr=salary&sort=<?php echo $sort_array ?>&search_info=<?php echo $keyword ?>"><img src="http://61.19.255.77/reportbuilder/img/<?php echo showIconOrder('salary', $_GET['key_arr'], $_GET['sort']);?>"></a></th>
        <th width="63" class="hd_report" data-sort="string">อำเภอ <a href="?key_arr=district&sort=<?php echo $sort_array ?>&search_info=<?php echo $keyword ?>"><img src="http://61.19.255.77/reportbuilder/img/<?php echo showIconOrder('district', $_GET['key_arr'], $_GET['sort']);?>"></a></th>
        <th width="58" class="hd_report" data-sort="string">ตำบล <a href="?key_arr=subdistrict&sort=<?php echo $sort_array ?>&search_info=<?php echo $keyword ?>"><img src="http://61.19.255.77/reportbuilder/img/<?php echo showIconOrder('subdistrict', $_GET['key_arr'], $_GET['sort']);?>"></a></th>
       <!-- <th>จัดการ</th>-->
        </tr>
        </thead>
        <tbody>
      <?php
	 // echo count($arr);
	  if(count($arr) != 0){
	  foreach($arr as $row){
		  $id_card_link = "";
		  $question_id = "";
		  $question_main = "";
		  if($row['question_main'] != ""){
		  	$sql_id = "SELECT question_detail_1.question_id,question_detail_1.question_main,question_detail_1.question_idcard_detail FROM 	question_detail_1
WHERE 	question_detail_1.question_id='".$row['question_main']."' ";

	$query_id = mysql_query($sql_id);
	$rs_id = mysql_fetch_assoc($query_id);
	$id_card_link = $rs_id["question_idcard_detail"]."&frame=form2";	
	$question_id = $rs_id["question_id"];
	$question_main = $rs_id["question_main"];
		  }else{
	$id_card_link = $row["id_card"];	
	$question_id = $row["question_id"];
	$question_main = $row["question_main"];
		  }

		 // echo "<pre>";
		 // print_r($replace)
		 // print_r($a);
		 
		  ?>
          
          <tr class="data">
        <!--<td align="center"><?php echo ++$j; ?></td>-->
        <td align="center"><a href="main/form_show.php?id=<?php echo $id_card_link ; ?>" id="show"><?php echo str_replace($search,$replace,$row['id_card']); ?></a></td>
        <td align="left"><?php echo str_replace($search,$replace,$row['name']); ?> </td>
        <td align="center"><?php  echo $row['status']; ?></td>
        <td align="center"><?php echo $row['age']; ?></td>
        <td align="center"><?php if($row['sex']==1){echo 'หญิง';}elseif($row['sex']==2){echo 'ชาย';}else{echo 'อื่นๆ';} ?></td>
        <td align="left"><?php echo $row['occupation'];?> </td>
        <!--<td align="left"><?php echo str_replace($search,$replace,$row['occupation']);?> </td>-->
        <td align="center"><?php if($row['salary']==0){echo 'ไม่ระบุ';}else{echo @number_format($row['salary']);} ?></td>
        <td align="center"><?php echo $row['district']; ?></td>
        <td align="center"><?php echo $row['subdistrict']; ?></td>
         <!--<td align="left"><?php echo str_replace($search,$replace,$row['district']); ?></td>
        <td align="left"><?php echo str_replace($search,$replace,$row['subdistrict']); ?></td>-->
<!--        <td width="40" align="center"><a href="question_form.php?frame=form1&id=<?php echo $question_id; ?>"><img src="../img/b_edit.png" width="16" height="16" border="0"></a>&nbsp;
          <a href="main_exc/from1_del_exc.php?quid=<?php echo $question_id; ?>&main=<?php echo $question_main; ?>" onclick="return confirm('คณต้องการลบข้อมูลนี้ออกจากตาราง?')"><img src="../img/b_drop.png" width="16" height="16" border="0"></a></td>-->
      </tr>
          
          <?php
		 // $j++;
	  }
	  }
	  else{
		?>
        <tr>
        	<td colspan="10" align="center">----- ไม่มีข้อมูล -----</td>
        </tr>
        <?php  
		}
	  }else{
		?>

        <?php  
		  
	  }
		
	?>
    </tbody>
    </TABLE></td>
  </tr>
</table>
<p>&nbsp;</p>
<?php
}
?>
</body>
</html>