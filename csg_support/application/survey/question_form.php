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
//error_reporting(E_ALL ^ E_NOTICE);
@session_start();
if($_GET['debug'] == 'on'){
	print_r($_SESSION);
}

/*if($_SESSION['user']=='')
{
	echo '<meta http-equiv="refresh" content="0;url=../usermanager/login.php">';
}*/
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<title>ระบบฐานข้อมูลลงทะเบียนขอรับสิทธิเงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/style_menu.css">
<script src="../js/jquery.js" type="text/javascript"></script>
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
<? $box_search = 'on';  include "header.php";?>
<?php
if(isset($_GET['frame']))
{
	if(($_GET['frame']=='dr_doc1') or ($_GET['frame']=='dr_doc2') or ($_GET['frame']=='dr_doc_attach') or ($_GET['frame']=='dr_doc4') or ($_GET['frame']=='dr_doc5'))
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
<table width="100%" border="0" cellpadding="1" cellspacing="1">
  <tr>
  <td width="20%" align="left" valign="top">
  
    <?php include('menu.php')?>
  </td>
  </tr>
  <tr>
  <td width="80%" align="center" valign="top">
  <div id="ifram">
    <?php
		if(isset($_GET['frame']))
		{
			if($_GET['frame']=='dr_doc1')
			{
				include('main/'.$_GET['frame'].'.php');
			}
			else
			{
				include('main/'.$_GET['frame'].'.php');
			}
		}
		else
		{
			include('main/dr_doc1.php');
		}
?>
    
    </div>
  </td>
</tr>
</table>

<?php }else{ 
		include('main/'.$_GET['frame'].'.php');
	}
}
else
{
	if(isset($_GET['column'])){$column = $_GET['column'];}else{$column = 'eq_id';}
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
	/*$sql = 'SELECT question_id,master_id,master_idcard,master_round,master_idques,question_firstname,question_lastname,question_sex,question_age,question_Income,question_career,question_career_detail';
	$sql .= ',REPLACE(getCCAA(LEFT(question_parish,6)),\'ตำบล\',\'\') as question_parish,REPLACE(getCCAA(LEFT(question_district,4)),\'อำเภอ\',\'\') as question_district,prename_th,getTb2(question_id) as numTb2';
	$sql .= ' FROM question_master INNER JOIN question_detail_1 ON question_detail_1.question_main = question_master.master_id INNER JOIN tbl_prename ON tbl_prename.id = question_prename';*/
	
		
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
			//$sql .= " WHERE master_idcard like '%".$_POST['search_info']."%'";
			//$sql .= " OR question_firstname like '%".$_POST['search_info']."%'";
			//$sql .= " OR question_lastname like '%".$_POST['search_info']."%'";
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
	 

	
	$sql = 'SELECT eq_person.eq_id';
	$sql .= ' FROM eq_person LEFT JOIN eq_child ON eq_person.eq_idcard = eq_child.eq_mother_idcard'; 
	$sql .= " WHERE 1=1 $where AND eq_person.eq_code_relation = 0";
	if($_GET['debug']=='on'){
		echo "<pre>";
		echo $sql;
		echo "</pre>";
	}
	//die($sql);
	/*if(isset($_GET['show']))
	 {
	 }
	 else
	 {*/
	
	 //}
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
				REPLACE(eq_person.eq_district,"อำเภอ","") as eq_district,
				REPLACE(eq_person.eq_parish,"ตำบล","") as eq_parish,
				eq_person.eq_salary,
				REPLACE(eq_person.eq_career,"อื่น ๆ,","") as eq_career,
				getCountChild(eq_person.eq_idcard) as numTb2
				'.$filter['attribute'];
	$sql .= ' FROM eq_person
			LEFT JOIN eq_child ON eq_person.eq_idcard = eq_child.eq_mother_idcard
	'.$filter['relation'];
		 
	if(isset($_GET['show']))
	 {
		 //$sql .=' LIMIT '.$Page_Start.','.$Per_Page;
		 $Num_Pages = 1;
		 if(isset($_GET['ccdigi']))
		 {
			//$sql .=' LIMIT '.$Page_Start.','.$Per_Page;
			$sql .= ' WHERE 1=1 '.$where;
		}
		else
		{
			//$sql .=' LIMIT '.$Page_Start.','.$Per_Page;
		}
		
		if(isset($_GET['order']))
		{
			$sql .=' GROUP BY eq_person.eq_idcard ORDER BY eq_person.'.$column.' '.$order;
		}
	 }
	 else
	 {
	
	 //if($_POST) 
//	 {
//		 if($_POST['search_info']!='') // ตรวจสอบว่า มีค่าว่างหรือเปล่า
//		 {
//			$sql .= " WHERE master_idcard like '%".$_POST['search_info']."%'";
//			$sql .= " OR question_firstname like '%".$_POST['search_info']."%'";
//			$sql .= " OR question_lastname like '%".$_POST['search_info']."%'";
//		 }
//	 }
//	 else
//	 {
//		 if(isset($_GET['ccdigi']))
//		 {
//			 $sql .= " WHERE question_district = ".$_GET['ccdigi']	;
//			 $Num_Pages = 1;
//		 }
//		 
//	 }
	$sql .= " WHERE 1=1 AND eq_person.eq_code_relation = 0 $where {$filter['condition']}";
	$sql .=' GROUP BY eq_person.eq_idcard ORDER BY eq_person.'.$column.' '.$order;
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
	if($_GET["debug"] == "ON"){
		echo $sql;
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
$sql_district_all = 'Select exsum_district_ccdigi,REPLACE(exsum_district_title,\'อำเภอ\',\'\') as exsum_district_title,exsum_district_num,exsum_date,exsum_percent,exsum_tb2 FROM exsum_district_all';
$result_district_all  = $con->select($sql_district_all);

$k = 0;
$data = '';
foreach($result_district_all as $rd)
{
	$countNum[] = $rd['exsum_district_num'];
	$title[] = $rd['exsum_district_title'];
	$code[] = $rd['exsum_district_ccdigi'];
	$exsum_percent[] = $rd['exsum_percent'];
	$exsum_tb2[] = $rd['exsum_tb2'];
	
	//$data[$k] =  $rd['exsum_percent'];
	/*if($k!=0){$data .= ',';}
	$k++;
	$data .= $rd['exsum_percent'];*/
	
}

//$percent = implode(',',$exsum_percent);
//echo $data;
$arrData = array($exsum_percent[0],$exsum_percent[1],$exsum_percent[2],$exsum_percent[3],$exsum_percent[4],$exsum_percent[5],$exsum_percent[6]);	
@$arrDataPercent = $con->percentage($arrData);
//print_r($arrDataPercent);
?>


<table width="100%" border="0" cellspacing="5" cellpadding="0">
  <tr><td colspan="6" align="right">
  <img src="../img/icon_setting.png" id="button_filter" style="cursor:pointer;">
  
  <img src="img/icon_small_dis.png" id="small" onClick="changeFontSize('small');" style="cursor:default;" title="ลดขนาดตัวอักษร">
  <img src="img/icon_large.png" id="large" onClick="changeFontSize('large');"  style="cursor:pointer;" title="เพิ่มขนาดตัวอักษร">
  <input type="hidden" id="fontsize" name="fontsize" value="12">
  </td></tr>
  <tr>
    <td rowspan="5" align="center" valign="top"><TABLE width="90%" border="0"  cellspacing="1" cellpadding="3"  bgcolor="#BBCEDD"  class="ppDriverTable" id="ppDriverTable" style="border-radius:2px;">
      <TR>
        <TD width="183" rowspan="2" align="center"  bgcolor="#DFDFDF">อำเภอ</TD>
        <TD height="30" colspan="2" align="center" bgcolor="#DFDFDF">จำนวนผู้ลงทะเบียน</TD>
        <TD width="101" rowspan="2" align="center"  bgcolor="#DFDFDF">จำนวนบุตร (คน)</TD>
      </TR>
      <TR>
        <TD width="76" height="30" align="center"  bgcolor="#DFDFDF">จำนวน(คน)</TD>
        <TD width="73" align="center" bgcolor="#DFDFDF">ร้อยละ</TD>
        </TR>
      <tbody>
        <?php
		$sumall  = 0;
		$exsum_date = '';
		$sumtb2 = 0;
		$Percent = 0;
	  	for($i=0;$i<count($countNum);$i++)
		{
			$sumall = $countNum[$i]+$sumall;
			$sumtb2 = $exsum_tb2[$i]+$sumtb2;
			$color = '';
			$sumPercent = $arrDataPercent[$i]+$sumPercent;
		   if(isset($_GET['ccdigi']))
		   {
				if($code[$i]==$_GET['ccdigi'])
				{
			 		$color = 'style="background:#FF9"';
				}
		   }
	  ?>
        <TR <?php echo $color; ?> >
          <TD  align="left" height="20"><?php echo $title[$i];?></TD>
          <TD  align="center"><a href= "?ccdigi=<?php echo $code[$i]; ?>"><?php echo $countNum[$i]; ?></a></TD>
          <TD  align="center"><?php echo number_format($arrDataPercent[$i],2); ?></TD>
          <TD  align="center"><?php echo number_format($exsum_tb2[$i],0); ?></TD>
          </TR>
        <?php
		}
	  ?>
        </tbody>
      <tfoot>
        <TR bgcolor="#FFFFFF" >
          <TD align="left" height="20"><strong>รวม</strong></TD>
          <TD align="center" ><strong><a href="question_form.php<?php if($_GET['show']){}else{echo '?show=all';} ?>"><?php echo $sumall; ?></a></strong></TD>
          <TD align="center" ><strong><?php echo number_format($sumPercent,2); ?></strong></TD>
          <TD align="center" ><strong><?php echo number_format($sumtb2); ?></strong></TD>
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
			foreach($results_lastdate as $rtt){}
			$date = new DateTime($rtt['eq_date_modify']); 
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
											//echo count($results); 
											?>
                                            &nbsp;รายการ</TD>
                            </TR>
      </TABLE>
    
    </td>
  </tr>
  <?php } ?>
  <?php 
  			/*$sql_lastdate = 'select master_timestamp from question_master order by master_timestamp desc LIMIT 0,1'; 
  			$results_lastdate = $con->select($sql_lastdate);
			foreach($results_lastdate as $rtt){}
			$date = new DateTime($rtt['master_timestamp']); 
			$lastdate = $date->format('j/n/Y');
			$lasttime = $date->format('H:i:s');*/
  ?>
  <tr>
  </tr>
      <td align="left">
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
		//$url_form = '?frame=dr_doc1';
		$url_form = '?frame=dr_doc1_new';
		
	}
	//echo $url_form;
?>
  <!--<input type="submit" name="button" id="button" value="EXPORT-Excel"  onClick="location.href='excel/reporttoexcel.php'">-->
  <a href="question_form.php<?php echo $url_form; ?>" style="color:#FFF ; text-decoration:none;"><img src="../img/add_data.png" class="textmidle" hspace="5" title="บันทึกแบบสอบถาม"></a>
</td>
    <td align="right" valign="bottom"> ทั้งหมด <font color="#CC0000"> <?php echo $sumNumRows; ?></font> รายการ <?php if($_GET['show']){}else{echo 'แบ่งเป็น <font color="#0033CC">'.$Num_Pages.'</font> หน้า&nbsp;&nbsp;&nbsp;';} ?> <a href="question_form.php?<?php echo $pageccdigi; ?><?php if($_GET['show']){}else{echo '&show=all';} ?>"><?php if($_GET['show']){echo 'แบ่งหน้า';}else{echo 'แสดงทั้งหมด';} ?></a>
      <?php
if($Prev_Page)
{
	echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&column=$column&order=$order&$pageccdigi'><img src=\"../img/First.gif\"></a> ";
}
/*
$b=floor($Page/10);
$c = ( 1 + ( $b * 10 ) );
$d = ( $b * 10 ) ;
if ( $Page == $d ) {
$b = ( $b - 1 ) ;
$c=(1+($b*10));
}
for($i=$c; $i<$Page ; $i++){
	if($i>0)
	{			
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$i'>$i</a> ";
	}	
}
echo "<span>".$Page."</span>";
for($i=($Page+1); $i<($c+10) ; $i++){
	if($i<=$Num_Pages)
	{			
		echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i'>$i</a> ]";
	}
}*/
if($Num_Pages!=1)
{
	for($i=1; $i<=$Num_Pages ; $i++){
		if($i!=$Page)
		{			
			echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$i&column=$column&order=$order&$pageccdigi&keyword=$keyword'>$i</a> ";
		}else{
			echo "<b>$i</b>";
			}
		
	}
}

if($Page!=$Num_Pages)
{
	echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&column=$column&order=$order&$pageccdigi&keyword=$keyword'><img src=\"../img/Last.gif\"></a> ";
}
?>
   </td>
  </tr>
  <tr>
    <td colspan="2"><TABLE width="100%" border="0" cellspacing="1" cellpadding="3" id="ppDriverTable" NAME="ppDriverTable" class="dtree" bgcolor="#BBCEDD" >
      <tr  class="style7">
        <td width="34" align="center" >ลำดับ</th>
        <td width="121" align="center" ><a href="?<?php echo $pageccdigi ?>&column=eq_idcard&order=<?php echo $con->sortData('eq_idcard',$column,$order);?>&keyword=<?php echo $keyword ?><?php if(isset($_GET['show'])){echo '&show=all';} ?>" >เลขประจำตัวประชาชน</a></td>
        <td width="170" align="center"><a href="?<?php echo $pageccdigi ?>&column=eq_firstname&order=<?php echo $con->sortData('eq_firstname',$column,$order); ?>&keyword=<?php echo $keyword ?><?php if(isset($_GET['show'])){echo '&show=all';} ?>">ชื่อ-นามสกุล (มารดา)</a></td>
        <td width="70" align="center"><a href="?<?php echo $pageccdigi ?>&column=eq_age&order=<?php echo $con->sortData('eq_age',$column,$order); ?>&keyword=<?php echo $keyword ?><?php if(isset($_GET['show'])){echo '&show=all';} ?>">อายุ(ปี)</a></td>
        <!-- <td width="70" align="center"><a href="?<?php echo $pageccdigi ?>&column=eq_gender&order=<?php echo $con->sortData('eq_gender',$column,$order); ?>&keyword=<?php echo $keyword ?><?php if(isset($_GET['show'])){echo '&show=all';} ?>">เพศ</a></td> -->
        <td width="158" align="center"><a href="?<?php echo $pageccdigi ?>&column=eq_career&order=<?php echo $con->sortData('eq_career',$column,$order); ?>&keyword=<?php echo $keyword ?><?php if(isset($_GET['show'])){echo '&show=all';} ?>">อาชีพ</a></td>
        <td width="114" align="center"><a href="?<?php echo $pageccdigi ?>&column=eq_salary&order=<?php echo $con->sortData('eq_salary',$column,$order); ?>&keyword=<?php echo $keyword ?><?php if(isset($_GET['show'])){echo '&show=all';} ?>">รายได้ต่อปี (บาท)</a></td>
        <td width="108" align="center"><a href="?<?php echo $pageccdigi ?>&column=numTb2&order=<?php echo $con->sortData('numTb2',$column,$order); ?>&keyword=<?php echo $keyword ?><?php if(isset($_GET['show'])){echo '&show=all';} ?>">จำนวนบุตร (คน)</a></td>
        <td width="63" align="center"><a href="?<?php echo $pageccdigi ?>&column=eq_district&order=<?php echo $con->sortData('eq_district',$column,$order); ?>&keyword=<?php echo $keyword ?><?php if(isset($_GET['show'])){echo '&show=all';} ?>">อำเภอ</a></td>
        <td width="58" align="center"><a href="?<?php echo $pageccdigi ?>&column=eq_parish&order=<?php echo $con->sortData('eq_parish',$column,$order); ?>&keyword=<?php echo $keyword ?><?php if(isset($_GET['show'])){echo '&show=all';} ?>">ตำบล</a></td>
        <td align="center">จัดการ</td>
        </tr>
      <?php
		//$i = 0;
		foreach($results as $row){
		?>
      <tr class="data">
        <td align="center"><?php echo $j; ?></td>
        <td align="center"><a href="main/form_show.php?id=<?php echo $row['eq_idcard']; ?>" id="show"><?php echo str_replace($keyword,"<span style='background-color:#FFFF00'>".replacepin($keyword)."</span>",replacepin($row['eq_idcard'])); ?></a></td>
        <td align="left"><?php echo $row['eq_prename']; ?><?php echo str_replace($keyword,"<span style='background-color:#FFFF00'>".$keyword."</span>",$row['eq_firstname']); ?> <?php echo str_replace($keyword,"<span style='background-color:#FFFF00'>".$keyword."</span>",$row['eq_lastname']); ?></td>
        <td align="center"><?php echo $row['eq_age']; ?></td>
        <!--<td align="center"><?php echo $row['eq_gender']; ?></td>-->
        <td align="left"><?php echo $row['eq_career']; ?> </td>
        <td align="center"><?php if($row['eq_salary']==''){echo 'ไม่ระบุ';}else{echo @number_format($row['eq_salary']);} ?></td>
        <?php
			$sqlChild = " SELECT eq_idcard AS eq_idcard FROM eq_child WHERE eq_mother_idcard = '".$row['eq_idcard']."' ";
			$resultChild = mysql_query($sqlChild);
			$rowChild = mysql_fetch_array($resultChild);
		?>
        <td align="center"><a href="../../../<?php echo  APP_MASTER; ?>/application/personal_data/index.php?p=general_data&keyview=general_data&p_id=10074&p_join_number=58-013-021&gid=54&idcard=<?php echo $rowChild['eq_idcard'];?>" target="_blank"><?php echo $row['numTb2']; ?></a></td>
        <td align="left"><?php echo $row['eq_district']; ?></td>
        <td align="left"><?php echo $row['eq_parish']; ?></td>
        <!--td width="40" align="center"><a href="question_form.php?frame=dr_doc1&id=<?php echo $row['eq_idcard']; ?>&eq_id=<?php echo $row['eq_id']; ?>"><img src="../img/b_edit.png" width="16" height="16" border="0"></a>&nbsp;
          <a href="main_exc/from1_del_exc.php?id=<?php echo $row['eq_idcard']; ?>" onClick="return confirm('คณต้องการลบข้อมูลนี้ออกจากตาราง?')"><img src="../img/b_drop.png" width="16" height="16" border="0"></a></td-->
		  <td width="40" align="center"><a href="question_form.php?frame=dr_doc1_new&id=<?php echo $row['eq_idcard']; ?>&eq_id=<?php echo $row['eq_id']; ?>"><img src="../img/b_edit.png" width="16" height="16" border="0"></a>&nbsp;
          <a href="main_exc/from1_del_exc.php?id=<?php echo $row['eq_idcard']; ?>" onClick="return confirm('คณต้องการลบข้อมูลนี้ออกจากตาราง?')"><img src="../img/b_drop.png" width="16" height="16" border="0"></a></td>
      </tr>
      <?php
	  		$j++;
		} 
	?>
    </TABLE></td>
  </tr>
</table>
<p>&nbsp;</p>
<?php
}

// echo '<pre>',print_r($filter);
?>
</body>
</html>