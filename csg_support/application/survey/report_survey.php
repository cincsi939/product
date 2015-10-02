<?php
session_start();
print_r($_SESSION);
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Kidsna Panya
 * @created  10/09/2014
 * @access  public
 */
 	header ('Content-type: text/html; charset=tis-620'); 
 	if(is_file('../lib/class.function.php')){
	 	include('../lib/class.function.php');
	}else{
			include('lib/class.function.php');
	}
 $con = new Cfunction();
 $con->connectDB();
 $report_year = ($_GET['report_year']!='')?$_GET['report_year']:(date('Y')+543); 
 $report_type = ($_GET['report_type']!='')?$_GET['report_type']:1; 
 $report_district = ($_GET['report_district']!='')?$_GET['report_district']:''; 
 
 $imgpath = "http://61.19.255.77/trat_eq/application/img/";
 $arrTitle = array(	'1'=>'เด็ก (อายุ 0-18 ปี)',
 					'2'=>'เยาวชน (อายุ 19 – 25 ปี)',
					'3'=>'วัยแรงงาน (อายุ 25 – 60 ปี)',
					'4'=>'ผู้สูงอายุ (อายุ 60 ปีขึ้นไป)',
					'5'=>'คนพิการ');
 $arrSearchIcon = array(	
 					'1'=>'search_01.png',
 					'2'=>'search_02.png',
					'3'=>'search_03.png',
					'4'=>'search_04.png',
					'5'=>'search_05.png');	
					
 $arrBGSearchIcon = array(	
 					'1'=>'bg_search_01.png',
 					'2'=>'bg_search_02.png',
					'3'=>'bg_search_03.png',
					'4'=>'bg_search_04.png',
					'5'=>'bg_search_05.png');						
								
					
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
					$arr_icon = array('DESC'=>'sort-desc.gif','ASC'=>'sort-asc.gif');	
					
					
	function date_eng2thai2($date, $add = 0, $dismonth = "L", $disyear = "L") {
		global $monthname, $shortmonth;
		$monthname = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        
        if ($date != "") {
                $date = substr($date, 0, 10);
                list($year, $month, $day) = split('[/.-]', $date);
				
                if ($dismonth == "S") {
                        $month = $shortmonth[$month * 1];
                } else {
					
                        $month = $monthname[$month * 1];
						
                }
				
                $xyear = 0;
                if ($disyear == "S") {
                        $xyear = substr(($year + $add), 2, 2);
                } else {
                        $xyear = ( $year + $add);
                }
                return ($day * 1) . " " . $month . " " . ($xyear);
        } else {
                return "";
        }
	}				
					
	function getProblem($problem_type='', $problem_id=''){
		$sql = "SELECT * FROM question_problem 
									WHERE problem_type='".$problem_type."' 
									AND problem_level='".$problem_id."' ";
		$query = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_assoc($query);
		return $row['problem_detail'];
	}				
 
 	function getHelp($help_type='', $help_id=''){
		$sql = "SELECT * FROM question_help 
									WHERE help_type='".$help_type."' 
									AND help_level='".$help_id."' ";
		$query = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_assoc($query);
		return $row['help_detail'];
	}
		
 	function getProblemHelp($report_mainid='',$problem_id=array(),$help_id=array()){
		global $report_year, $report_type;
		$sql = " SELECT 
					reportbuilder_f2_2.report_mainid, 
					question_tbl2.tbl2_problem, 
					question_tbl2.tbl2_help, 
					question_tbl2.tbl2_type,
					reportbuilder_f2_2.report_year, 
					reportbuilder_f2_2.report_type
				FROM question_tbl2 
				INNER JOIN reportbuilder_f2_2 ON question_tbl2.tbl2_idcard = reportbuilder_f2_2.report_idcard
				WHERE report_year='".$report_year."'
				AND tbl2_type='".$report_type."'
				AND reportbuilder_f2_2.report_mainid='".$report_mainid."'
				 ";
		//if($report_mainid=='3230100379314'){echo $sql."<br/>";}
		
		$query = mysql_query($sql) or die(mysql_error());	
		while($row = mysql_fetch_assoc($query)){
			if($row['tbl2_problem']!=''){
				$sql_problem_comment = "SELECT * FROM question_problem 
									WHERE problem_type='".$row['tbl2_type']."' 
									AND problem_level IN(".$row['tbl2_problem'].")";
				$query_problem_comment = mysql_query($sql_problem_comment) or die(mysql_error());
				
				//if($report_mainid=='3230100379314'){echo $sql_problem_comment."<br/>";}
				
				$intProblemC = 0;
				
				while($row_problem_comment = mysql_fetch_assoc($query_problem_comment)){
						$intProblemC++;
						$arrProblem[$row_problem_comment['problem_level']] = $row_problem_comment['problem_level'];
						if($problem_id[$row_problem_comment['problem_level']]==$row_problem_comment['problem_level']){
							$arr_problem_comment[$row_problem_comment['problem_level']] = '<span class="highlight" >'.replaceproblem($row_problem_comment['problem_id'], $row_problem_comment['problem_detail']).'</span>';
						}else{
							$arr_problem_comment[$row_problem_comment['problem_level']] = replaceproblem($row_problem_comment['problem_id'], $row_problem_comment['problem_detail']);
						}
				}
			}
			
			if($row['tbl2_help']!=''){
				$sql_help_comment = "SELECT * FROM question_help 
									WHERE help_type='".$row['tbl2_type']."' 
									AND help_level IN(".$row['tbl2_help'].")";
				$query_help_comment = mysql_query($sql_help_comment) or die(mysql_error());
				$intHelpC = 0;
				while($row_help_comment = mysql_fetch_assoc($query_help_comment)){
						$intHelpC++;
						
						$arrHelp[$row_help_comment['help_level']] = $row_help_comment['help_level'];
						if($help_id[$row_help_comment['help_level']]==$row_help_comment['help_level']){
							$arr_help_comment[$row_help_comment['help_level']] = '<span class="highlight" >'.$row_help_comment['help_detail'].'</span>';
						}else{
							$arr_help_comment[$row_help_comment['help_level']] = $row_help_comment['help_detail'];
						}
				}
			}
		}
		
		
		if($arr_problem_comment){
			$intProblemC=0;
			foreach($arr_problem_comment as $problem_com){
				$intProblemC++;
					$problem_comment .= $intProblemC.'. '.$problem_com.'<br/> ';
			}
		}
		if($arr_help_comment){
			$intHelpC=0;
			foreach($arr_help_comment as $help_com){
					$intHelpC++;
					$help_comment .= $intHelpC.'. '.$help_com.'<br/> ';
			}
		}
	
		
		$problem_num = ($problem_comment!='')?count($arrProblem):0;
		$help_num = ($help_comment!='')?count($arrHelp):0;
		
		$arrData = array(	'problem_num'=>$problem_num,
							'help_num'=>$help_num,
							'problem_comment'=>$problem_comment,
							'help_comment'=>$help_comment
						);
		return $arrData;
	}
	
	if($_GET['problem_id'] || $_GET['help_id']){
		/*echo "<pre>";
		print_r($_GET);
		echo "</pre>";*/
		$cond = $_GET['cond1'];
		
		
		if($_GET['problem_id'][9999] == '' && $_GET['help_id'][9999] == ''){
			$sqlquestion .= " AND question_tbl2.tbl2_problem!='' AND question_tbl2.tbl2_help!='' ";
		}
		
		
		if($_GET['problem_id']){
			if($_GET['problem_id'][9999] != '9999'){
				$intCond = 0;
				foreach($_GET['problem_id'] as $problem_id){
					$intCond++;
					$cond_problem .= (($intCond>1)?$cond:'')." problem_{$problem_id}='1' ";
					$problem_search .= getProblem($report_type, $problem_id).', ';
					$problem_search_check .= '<img src="images/trues.png" width="20" align="absmiddle"> '.getProblem($report_type, $problem_id).'<br/>';
				}
			}
			if($_GET['problem_id'][9999] == '9999'){
				$whereSearchNotProblem = " AND question_tbl2.tbl2_problem='' ";
				$cond_problem .= " question_tbl2.tbl2_problem='' ";
				$problem_search .= 'ไม่ระบุสภาพปัญหา';
				$problem_search_check .= '<img src="images/trues.png" width="20" align="absmiddle"> ไม่ระบุสภาพปัญหา<br/>';
			}
			
		}
		if($_GET['help_id']){
			if($_GET['help_id'][9999] != '9999'){
				$intCond = 0;
				foreach($_GET['help_id'] as $help_id){
					$intCond++;
					$cond_help .= (($intCond>1)?$cond:'')." help_{$help_id}='1' ";
					$help_search .= getHelp($report_type, $help_id).', ';
					$help_search_check .= '<img src="images/trues.png" width="20" align="absmiddle"> '.getHelp($report_type, $help_id).'<br/>';
				}
			}
			if($_GET['help_id'][9999] == '9999'){
				$whereSearchNotHelp = " AND question_tbl2.tbl2_help='' ";
				$cond_help .= " question_tbl2.tbl2_help=''";
				$help_search .= 'ไม่ระบุความช่วยเหลือ, ';
				$help_search_check .= '<img src="images/trues.png" width="20" align="absmiddle"> ไม่ระบุความช่วยเหลือ<br/>';
			}
		}
		//echo $problem;
		
		$sql = "SELECT reportbuilder_f3.f3_idcard AS idcard
				FROM question_tbl2 INNER JOIN question_tbl2_Type{$report_type} ON question_tbl2.tbl2_id = question_tbl2_Type{$report_type}.tbl2_id
				 INNER JOIN reportbuilder_f2_2 ON question_tbl2.tbl2_idcard = reportbuilder_f2_2.report_idcard
				 INNER JOIN reportbuilder_f3 ON reportbuilder_f3.f3_idcard = reportbuilder_f2_2.report_mainid
				WHERE reportbuilder_f2_2.report_year='".$report_year."'
				{$sqlquestion}
				".(($cond_problem.$cond_help!='')?" AND ( {$cond_problem} {$cond_help}) ":'')."
				GROUP BY report_idcard
				 ";
		
		if($_GET['debug']=='on'){
			echo $sql;
			echo "|".$cond_problem.$cond_help."|";
		}
		$query = mysql_query($sql) or die(mysql_error());
			
		$arrDataSearch = array();
		while($row = mysql_fetch_assoc($query)){
			$arrDataSearch[] = $row['idcard'];
		}
		if($cond_problem.$cond_help!=''){
			$inDataSearch = implode(',',$arrDataSearch);
		}else{
			$inDataSearch = '';
		}
		
		//echo $inDataSearch;	 
	}
	
	function replacepin($pin){
		if($_SESSION['user_status']=='1' or $_SESSION['user_status']==''){
			return substr($pin,0,3).'XXXXXXXXXX';
		}else{
			return $pin;
		}
	}
	
	function disabledCheck($problem_id=''){
		$arr_problem = array("12", "16", "37", "54","67","91");
		
		if($_SESSION['user_status']=='1' && in_array($problem_id, $arr_problem)){
			return 'disabled';
		}else{
			return '';
			
		}
	}
	
	function replaceproblem($problem_id='', $problem=''){
		$arr_problem = array("12", "16", "37", "54","67","91");
		
		if($_SESSION['user_status']=='1' && in_array($problem_id, $arr_problem)){
				return ' ................. ';
		}else{
				return $problem;
		}
		
	}
	
	$sqlLastData = "SELECT master_timestamp AS processing_time FROM `question_master` ORDER BY `master_timestamp` DESC LIMIT 1";
	$queryLastData = mysql_query($sqlLastData) or die(mysql_error());
	$rowLastData = mysql_fetch_assoc($queryLastData);
	
 	$sqlArea = "SELECT ccName AS areaname FROM `ccaa_aumpur` WHERE ccDigi='".$report_district."' ";
	$queryArea = mysql_query($sqlArea) or die(mysql_error());
	$rowArea = mysql_fetch_assoc($queryArea);
 
 ?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<title>แบบสอบถามสภาพครอบครัว</title>
<link rel="stylesheet" type="text/css" href="datatable/css/report.css">
<script type="text/javascript" src="datatable/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="datatable/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="fancybox/jquery.fancybox.js"></script>
<style>
	.fancybox-wrap{
		top: 20px !important
	}
</style>
<script>
	$(".fancybox").fancybox({
		width:"75%"
	});
</script>
 <script>
 
 
function show_search_display(){
	document.getElementById('div_search').style.display="none";
}
function show_search(){
	if(document.getElementById('div_search_icon').style.display=="none"){
		document.getElementById('div_search').style.display="none";
		document.getElementById('div_search_icon').style.display="";
	}else{
		document.getElementById('div_search').style.display="";
		document.getElementById('div_search_icon').style.display="none";
	}
	
}

function tab_search(myid){
	document.getElementById('a1').style.backgroundColor="#FFF";
	document.getElementById('a2').style.backgroundColor="#FFF";
	document.getElementById('tab_a1').style.display="none";
	document.getElementById('tab_a2').style.display="none";
	document.getElementById(myid).style.backgroundColor="#CCC";
	document.getElementById('tab_'+myid).style.display="";
}

function cond(myid){
	var cond1_1 = document.getElementById('cond1_1');
	var cond1_2 = document.getElementById('cond1_2');
	var cond2_1 = document.getElementById('cond2_1');
	var cond2_2 = document.getElementById('cond2_2');
	
	if(myid == 'cond1_1'){
		cond2_1.checked=true;
	}
	
	if(myid == 'cond1_2'){
		cond2_2.checked=true;
	}
	
	if(myid == 'cond2_1'){
		cond1_1.checked=true;
	}
	
	if(myid == 'cond2_2'){
		cond1_2.checked=true;
	}
	
	
}
function cond2(){
	var cond1_1 = document.getElementById('cond1_1');
	var cond1_2 = document.getElementById('cond1_2');
	var cond2_1 = document.getElementById('cond2_1');
	var cond2_2 = document.getElementById('cond2_2');
		
	if(cond2_1.checked==true){
		cond1_1.checked=true;
	}else{
		cond1_1.checked=false;
	}
	
	if(cond2_2.checked==true){
		cond1_2.checked=true;
	}else{
		cond1_2.checked=false;
	}
}
// onLoad="show_search_display();"
</script>

<script>
 var size = 0;
 function ChangeFontSize(type){
  var newsize = 2;
  var zoomin = 4;
  var zoomout = -2;
  var tag = ['table.dtree td','table.dtree td a','table.dtree th.hd_report','table#search_key td','table#search_key td b','table.tableinfo td'];
  var curfont = [] ;
  count = tag.length;
  if(type == 'inc' && size < zoomin){
   if(size == zoomout){
    size++; 
   }
   size++;
   if(size == (zoomin - 1)){
    $('#zoomIn').attr('src','<?php echo $imgpath; ?>/icon_large_dis.png');
    $('#zoomIn').css('cursor','default');
   }else if(size == (zoomout + 1) || size == (zoomout + 2)){
    $('#zoomOut').attr('src','<?php echo $imgpath; ?>/icon_small.png');
    $('#zoomOut').css('cursor','pointer');
   }
  }else if(type == 'dec' && size > zoomout){
   if(size == zoomin){
    size--; 
   }
   size--;
   if(size == (zoomout + 1)){
    $('#zoomOut').attr('src','<?php echo $imgpath; ?>/icon_small_dis.png');
    $('#zoomOut').css('cursor','default');
   }else if(size == (zoomin - 1) || size == (zoomin - 2)){
    $('#zoomIn').attr('src','<?php echo $imgpath; ?>/icon_large.png');
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
</head>
<body>
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
	.highlight{
		background-color:#FC3;
	}
 </style>
 <?php
 $sqlUpdatePerson = " SELECT reportbuilder_f2_2.report_type, 
												eq_person.eq_type, 
												reportbuilder_f2_2.report_idcard, 
												eq_person.eq_id
											FROM reportbuilder_f2_2 INNER JOIN eq_person ON reportbuilder_f2_2.report_idcard = eq_person.eq_idcard
											WHERE report_year='2557' AND reportbuilder_f2_2.report_code_district='23010000' 
											AND eq_person.eq_type=0
											GROUP BY reportbuilder_f2_2.report_idcard
											ORDER BY eq_person.eq_type ASC ";
	$queryUpdatePerson = mysql_query($sqlUpdatePerson) or die(mysql_error());	
	while($rowUpdatePerson = mysql_fetch_assoc($queryUpdatePerson)){
			$sqlU = "UPDATE eq_person SET eq_type='".$rowUpdatePerson['report_type']."' WHERE eq_id='".$rowUpdatePerson['eq_id']."' ";
			mysql_query($sqlU) or die(mysql_error());
	}										
											
 ?>
<center>
<table width="99%" border="0" align="center" class="tableinfo" >
  <tr>
    <td width="60%">
    	<table width="100%" border="0" cellpadding="1" cellspacing="1" >
          <tr>
            <td colspan="4"style="background-color:#e6e7e8; font-size: 24px; padding:3px;" align="center" >
            รายงานจำนวนกลุ่มเป้าหมาย<?php echo $arrTitle[$report_type];?> ของ<?php echo ' '.$rowArea['areaname'].' ';?>จังหวัดตราด
            </td>
          </tr>
          <tr align="center">
            <td width="25%" style="background-color:#f0f1f1; font-size: 20px; padding:3px;" >ปีที่สำรวจ</td>
            <td width="25%"><?php echo $report_year;?></td>
            <td width="25%" style="border-collapse:collapse; background-color:#f0f1f1; font-size: 20px; padding:3px;" >ข้อมูล ณ วันที่</td>
            <td width="25%"><?php echo date_eng2thai2($rowLastData['processing_time'],543)?></td>
          </tr>
        </table>
        <table width="100%"  border="0" cellpadding="1" cellspacing="1" >
          <tr align="center" style="background-color:#dfdfdf;">
            <td style="font-size: 20px; font-weight:bold;height:55px;"><?php echo ($report_district)?'ตำบล':'อำเภอ';?></td>
            <td style="font-size: 20px; font-weight:bold;height:55px;" width="20%">ครัวเรือนที่สำรวจ <br/>(ครัวเรือน)</td>
            <td style="font-size: 20px; font-weight:bold;height:55px;" width="20%">จำนวนกลุ่มเป้าหมาย <br/>(ครัวเรือน)</td>
            <td width="20%" style="font-size: 20px; font-weight:bold;height:55px;">กลุ่มเป้าหมาย(คน)</td>
          </tr>
          <?php
		  if($report_district!=''){
			  $sqlAmp = "SELECT ccaa_tamboon.ccName,
						ccaa_tamboon.ccDigi AS areaid
						FROM ccaa_tamboon
						WHERE `areaid` LIKE('".substr($report_district,0,4)."%') 
						";
		  }else{
			  $sqlAmp = "SELECT ccaa_aumpur.ccName,
						ccaa_aumpur.ccDigi AS areaid
						FROM ccaa_aumpur ";
		  }
		  
		  $rowAmp = $con->select($sqlAmp);
		  $arr_style = array(	'background-color:#f0f1f1;padding: 4px;',
		  						'background-color:#e6e7e8;padding: 4px;');
								
		  $intExs = 0;
		  $sumExH_all = 0;
		  $sum_exh = 0;
		  $sum_exp = 0;
		  if($report_district!=''){
			  $sqlExHall = "SELECT SUM(view_NM1.count_member), 
										view_NM1.district_id, 
										view_NM1.subdistrict_id, 
										COUNT(view_NM1.id) AS num
									FROM view_NM1
									WHERE view_NM1.district_id='".$report_district."'
									GROUP BY view_NM1.district_id ";
		  }else{
			  $sqlExHall = "SELECT 
						COUNT(DISTINCT reportbuilder_f2_2.report_mainid) AS num 
								FROM reportbuilder_f3 
								INNER JOIN reportbuilder_f2_2 ON reportbuilder_f3.f3_idcard = reportbuilder_f2_2.report_mainid
								WHERE report_year='".$report_year."'
								AND report_type='".$report_type."'
								AND reportbuilder_f2_2.report_code_district!='' ";
		  }
		$queryExHall = mysql_query($sqlExHall) or die(mysql_error());	
		$rowExHall = mysql_fetch_assoc($queryExHall);
				
		  foreach($rowAmp as $rd){
			  $intExs++;
			  
			  if($report_district!=''){
			  		$sqlExH_all = "
									SELECT SUM(view_NM1.count_member), 
										view_NM1.district_id, 
										view_NM1.subdistrict_id, 
										COUNT(view_NM1.id) AS num
									FROM view_NM1
									WHERE view_NM1.subdistrict_id='".$rd['areaid']."'
									AND view_NM1.district_id='".$report_district."'
									GROUP BY view_NM1.subdistrict_id
							";
			  	}else{
					$sqlExH_all = "SELECT reportbuilder_all.report_tatalfamily AS num, 
									reportbuilder_all.report_totalper, 
									SUM(view_NM1.count_member), 
									view_NM1.district_id, 
									view_NM1.subdistrict_id
								FROM reportbuilder_all LEFT OUTER JOIN view_NM1 ON reportbuilder_all.report_id = view_NM1.district_id
								WHERE view_NM1.district_id='".$rd['areaid']."'
								GROUP BY reportbuilder_all.report_id
								ORDER BY reportbuilder_all.report_id ASC
							";
				}
				$queryExH_all = mysql_query($sqlExH_all) or die(mysql_error());	
				$rowExH_all = mysql_fetch_assoc($queryExH_all);
			  //echo $sqlExH_all;
			  //echo "<br/>";
			  if($report_district!=''){
			  		$sqlExH = "SELECT 
					COUNT(DISTINCT reportbuilder_f2_2.report_mainid) AS num 
							FROM reportbuilder_f3 
							INNER JOIN reportbuilder_f2_2 ON reportbuilder_f3.f3_idcard = reportbuilder_f2_2.report_mainid
							WHERE report_year='".$report_year."'
							AND report_type='".$report_type."'
							AND report_code_district='".$report_district."'
							AND reportbuilder_f2_2.report_code_parish='".$rd['areaid']."' ";
			  	}else{
					$sqlExH = "SELECT 
					COUNT(DISTINCT reportbuilder_f2_2.report_mainid) AS num 
							FROM reportbuilder_f3 
							INNER JOIN reportbuilder_f2_2 ON reportbuilder_f3.f3_idcard = reportbuilder_f2_2.report_mainid
							WHERE report_year='".$report_year."'
							AND report_type='".$report_type."'
							AND reportbuilder_f2_2.report_code_district='".$rd['areaid']."' ";
				}
				$queryExH = mysql_query($sqlExH) or die(mysql_error());	
				$rowExH = mysql_fetch_assoc($queryExH);
				
				
				if($report_district!=''){
					  $sqlExP = "SELECT  COUNT(report_id) AS num
							FROM question_project.reportbuilder_f2_2
							WHERE report_year='".$report_year."'
							AND report_type='".$report_type."'
							AND report_code_district='".$report_district."'
							AND reportbuilder_f2_2.report_code_parish='".$rd['areaid']."'";
				}else{
					  $sqlExP = "SELECT  COUNT(report_id) AS num
							FROM question_project.reportbuilder_f2_2
							WHERE report_year='".$report_year."'
							AND report_type='".$report_type."'
							AND reportbuilder_f2_2.report_code_district='".$rd['areaid']."'
							";
				}
				$queryExP = mysql_query($sqlExP) or die(mysql_error());	
				$rowExP = mysql_fetch_assoc($queryExP);
				
          ?>
          <tr>
            <td style="<?php echo $arr_style[$intExs%2];?>"><?php echo $rd['ccName'];?></td>
            <td align="center" style="<?php echo $arr_style[$intExs%2];?>">
			<?php echo number_format($rowExH_all['num']);?>
            </td>
            <td align="center" style="<?php echo $arr_style[$intExs%2];?>">
            <?php echo number_format($rowExH['num']);?>
            </td>
            <td align="center" style="<?php echo $arr_style[$intExs%2];?>">
			<?php echo number_format($rowExP['num']);?>
            </td>
          </tr>
          <?php 
		  	$sumExH_all += $rowExH_all['num'];
		   	$sum_exh += $rowExH['num'];
		  	$sum_exp += $rowExP['num'];
		  }
		 
		   ?>
          <tr >
            <td style="<?php echo $arr_style[$intExs%2];?> font-weight:bold;height:45px;">รวม</td>
            <td align="center" style="<?php echo $arr_style[$intExs%2];?> font-weight:bold;height:45px;">
            <?php echo number_format($sumExH_all);?>
            </td>
            <td align="center" style="<?php echo $arr_style[$intExs%2];?> font-weight:bold;height:45px;">
			<?php echo number_format($sum_exh);?>
            </td>
            <td align="center" style="<?php echo $arr_style[$intExs%2];?> font-weight:bold;height:45px;">
			<?php echo number_format($sum_exp);?>
            </td>
          </tr>
        </table>
    
    </td>
    <td align="center" valign="top">
    	<div style="width:100%; text-align:right;">	
    	<img  id="zoomOut" src="<?php echo $imgpath; ?>icon_small.png" title="small" style="width:28px;cursor:pointer;" onClick="ChangeFontSize('dec')">
        <img id="zoomIn" src="<?php echo $imgpath; ?>icon_large.png" title="large" style="width:28px;cursor:pointer;" onClick="ChangeFontSize('inc')">
        </div>
        <table width="100%" border="0" align="center">
        <tr>
            <td align="center">
          <div align="right"> <img src="../../img/icon_setting.png" onClick="show_search();" align="absmiddle" style="cursor:pointer;"/></div>
            		
                    <div id="div_search_icon" >
                    	<div style="height:45px;">&nbsp;</div>
                    	
                        <?php
						if($problem_search.$help_search != ''){
						?>
							<table width="360" height="350" border="0" align="center" style="background-image:url(../../img/<?php echo $arrBGSearchIcon[$report_type];?>); background-position:center; background-repeat:no-repeat; border:1px #CCC solid;">
                             <tr>
                                <td valign="top" align="right" style="height:30px; font-size:24px;">
                                <?php
								if($problem_search_check!=''){
									echo "<strong>สภาพปัญหา/ความเดือนร้อน</strong>";
								}
                                ?>
                                <?php
								if($help_search_check!=''){
									echo "<strong>ความช่วยเหลือที่ต้องการ</strong>";
								}
                                ?>
                                </td>
                              <tr>
                                <td valign="top">
                                <div style="margin-left:20px;font-size:22px;">
                                <?php echo $problem_search_check;?>
                                <?php echo $help_search_check;?>
                                </div>
                                </td>
                              </tr>
                             
                            </table>
						
                        <?php }else{ ?>
                        <img src="../../img/<?php echo $arrSearchIcon[$report_type];?>" align="absmiddle" style="cursor:pointer;"/>
                        <?php } ?>
                	</div>
                </td>
          </tr>
          <tr>
            <td  align="center" >
            <table width="90%" height="360" border="0" align="center" id="div_search" style="background-image:url(../../img/<?php echo $arrBGSearchIcon[$report_type];?>); background-position:center; background-repeat:no-repeat; display:none;" >
              <tr>
                <td align="center">
                
                
                <table width="98%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td  width="150" onClick="tab_search('a1');">
                        <div id="a1" style="background-color:#CCC; width:150px; border:#EEE 1px solid; cursor:pointer;">สภาพปัญหา/ความเดือนร้อน</div>
                        </td>
                        <td width="150" onClick="tab_search('a2');">
                        <div id="a2" style="background-color:#FFF; width:150px; border:#EEE 1px solid; cursor:pointer;">ความช่วยเหลือที่ต้องการ</div>
                        </td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="border:1px #CCC solid;">
                    		<form action="" method="get">
                    		<table width="100%" border="0" id="tab_a1" cellpadding="1" cellspacing="0" align="center" >
                            <tr style=" padding:10px;">
                            <td colspan="2" style="margin:5px;padding:5px; height:25px;">
                            <strong>รายการสภาพปัญหา/ความเดือนร้อน</strong>
                            <table width="98%" border="0">
                              <tr>
                                <td><input type="hidden" name="report_year" value="<?php echo $report_year;?>"/>
                                                <input type="hidden" name="report_type" value="<?php echo $report_type;?>"/>
                                                <input type="image" name="b_search" src="../../img/search_data.png">
                                                </td>
                                <td><div style="text-align:right;">
                                                        <label>
                                                        <input type="radio" name="cond1" id="cond1_1" value="AND" <?php echo ($_GET['cond1']=='AND')?'checked':'';?> >&nbsp;And (และ)</label>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label >
                                                        <input type="radio" name="cond1" id="cond1_2" value="OR" <?php echo ($_GET['cond1']=='OR')?'checked':'checked';?>>&nbsp;Or (หรือ)</label>
                                                        </div></td>
                              </tr>
                            </table>
                            
                            </td>
                          </tr>
                          <tr>
                          <td>
                          	<div style="overflow:scroll; height:270px;">
                          	<table border="0">
                            <?php
                                $sqlProblem = "SELECT * FROM question_problem WHERE problem_type='".$report_type."' ";
                                $rowProblem = $con->select($sqlProblem);
                                foreach($rowProblem as $problem){ ?>
                                <tr> 
                                <td align="left">
                                <label>
                                <input type="checkbox" name="problem_id[<?php echo $problem['problem_level'];?>]" value="<?php echo $problem['problem_level'];?>" <?php echo ($_GET['problem_id'][$problem['problem_level']]==$problem['problem_level'])?'checked':'';?> <?php echo disabledCheck($problem['problem_level']);?> />
                                &nbsp;
                                <?php echo str_replace(' ระบุ','',$problem['problem_detail']);?>
                                </label>
                                </td>
                                </tr>
                             <?php } ?>
                             	<tr> 
                                <td  align="left">
                                <label><input type="checkbox" name="help_id[9999]" value="9999" <?php echo ($_GET['help_id'][$help['help_level']]=='9999')?'checked':'';?>/>
                                &nbsp; 
                                ไม่ระบุสภาพปัญหา</label>
                                </td>
                                </tr>
                             </table>
                             </div>
                             </td>
                         </tr>
                        </table>
                        </form>
                        <form action="" method="get">
                        <table width="100%" border="0" id="tab_a2" cellpadding="1" cellspacing="0" align="center" style=" display:none;">
                            <tr style=" padding:10px;">
                            <td colspan="2" style="margin:5px;padding:5px; height:25px;">
                            <strong>รายการความช่วยเหลือที่ต้องการ</strong>
                            <table width="98%" border="0">
                              <tr>
                                <td><input type="hidden" name="report_year" value="<?php echo $report_year;?>"/>
                                                <input type="hidden" name="report_type" value="<?php echo $report_type;?>"/>
                                               <input type="image" name="b_search" src="../../img/search_data.png">
                                                </td>
                                <td><div style="text-align:right;">
                                                        <label >
                                                        <input type="radio" name="cond1" id="cond1_1" value="AND" <?php echo ($_GET['cond1']=='AND')?'checked':'';?> >&nbsp;And (และ)</label>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label >
                                                        <input type="radio" name="cond1" id="cond1_2" value="OR" <?php echo ($_GET['cond1']=='OR')?'checked':'checked';?>>&nbsp;Or (หรือ)</label>
                                                        </div></td>
                              </tr>
                            </table>
                            </td>
                          </tr>
                          <tr> 
                           <td>
                          <div style="overflow:scroll; height:270px;">
                          	<table border="0">
                            <?php
                                $sqlHelp = "SELECT * FROM question_help WHERE help_type='".$report_type."' ";
                                $rowHelp = $con->select($sqlHelp);
                                foreach($rowHelp as $help){ ?>
                                <tr> 
                                <td  align="left">
                                <label><input type="checkbox" name="help_id[<?php echo $help['help_level'];?>]" value="<?php echo $help['help_level'];?>" <?php echo ($_GET['help_id'][$help['help_level']]==$help['help_level'])?'checked':'';?>/>
                                &nbsp; 
                                <?php echo str_replace(' ระบุ','',$help['help_detail']);?></label>
                                </td>
                                </tr>
                             <?php } ?>
                              
                                <tr> 
                                <td  align="left">
                                <label><input type="checkbox" name="help_id[9999]" value="9999" <?php echo ($_GET['help_id'][$help['help_level']]=='9999')?'checked':'';?>/>
                                &nbsp; 
                                ไม่ระบุความช่วยเหลือ</label>
                                </td>
                                </tr>
                             </table>
                           </div>
                            </td>
                          </tr> 
                        </table>
                        </form>
                    </td>
                  </tr>
                </table>
                
                   
                    
                </td>
              </tr>
            </table>
            
                    
            </td>
          </tr>
          
        </table>
    </td>
  </tr>
</table>
<p/>
<table width="99%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td align="right">รายงาน ณ วันที่ <?php echo date_eng2thai2(date('Y-m-d'),543);?></td>
  </tr>
</table>
<?php
if($inDataSearch!=''){
	$whereSearch = "AND reportbuilder_f3.f3_idcard IN(".$inDataSearch.")";
}
//echo "|".$cond_problem.$cond_help."|";
if($inDataSearch == '' && $cond_problem.$cond_help!=''){
	$whereLimit = " LIMIT 0 ";
}
if($report_district!=''){
	$where = "AND reportbuilder_f2_2.report_code_district='".$report_district."'";
}else{
	$where = "";
}

$ordertype = ($_GET['ordertype']=='DESC' || $_GET['ordertype']=='')?'ASC':'DESC';
$arr_icon = array('DESC'=>'sort-desc.gif','ASC'=>'sort-asc.gif');

if($_GET['orderby']!=''){
	$sqlOrderby = "ORDER BY ".$_GET['orderby']." ".$ordertype;
}

$sqlData = "SELECT reportbuilder_f3.f3_idcard AS idcard,
				reportbuilder_f2_2.report_type, 
				reportbuilder_f2_2.report_year, 
				reportbuilder_f3.f3_fullname AS fullname, 
				question_detail_1.question_age AS question_age, 
				question_detail_1.question_Income AS question_Income, 
				COUNT(reportbuilder_f2_2.report_idcard) AS question_num,
				reportbuilder_f3.f3_district AS report_district, 
				reportbuilder_f3.f3_parish AS report_parish
			FROM reportbuilder_f3 INNER JOIN reportbuilder_f2_2 ON reportbuilder_f3.f3_idcard = reportbuilder_f2_2.report_mainid
				 INNER JOIN question_detail_1 ON reportbuilder_f3.f3_idcard = question_detail_1.question_idcard_detail
			WHERE report_year='".$report_year."'
			AND report_type='".$report_type."'
			{$where}
			{$whereSearch}
			GROUP BY reportbuilder_f2_2.report_mainid
			{$sqlOrderby} 
			{$whereLimit}
			";
if($_GET['debug']=='on'){
			echo $sqlData;
}

$pathInfo = pathinfo($_SERVER['REQUEST_URI']);
//echo $pathInfo['basename'];

$order_url = $pathInfo['basename'];
	
$rowData = $con->select($sqlData);			
?>
<?php
if($problem_search.$help_search != ''){
?>
<table width="99%" border="0" align="center" style="border:#CCC 1px solid;"  class="tableinfo">
  <tr>
    <td><strong>ค้นหาคำว่า</strong> <?php echo $problem_search.$help_search;?></td>
    <td align="right">
    <?php
	if($_GET['problem_id'][9999] != '9999' && $_GET['help_id'][9999] != '9999'){
    ?>
    จำนวนที่ค้นพบ <?php echo count($rowData);?>  รายการ
    <?php } ?>
    </td>
  </tr>
</table>
<?php } ?>

<table width="99%" border="0" id="tablereportbuilder" cellpadding="1" cellspacing="1" style="background-color:#999;" class="tableinfo">
<thead>
  <tr align="center">
    <th class="hd_report" width="3%">ลำดับ</th>
    <th class="hd_report" width="13%">
    เลขประจำตัวประชาชน&nbsp;
    <a href="<?php echo $order_url;?>&orderby=f3_idcard&ordertype=<?php echo $ordertype;?>"><img src="../../img/<?php echo showIconOrder('f3_idcard', $_GET['orderby'], $_GET['ordertype']);?>" align="absmiddle" border="0"></a>
    </th>
    <th class="hd_report" width="12%">
    ชื่อ-นามสกุล <br/>(หัวหน้าครัวเรือน)&nbsp;
    <a href="<?php echo $order_url;?>&orderby=f3_fullname&ordertype=<?php echo $ordertype;?>"><img src="../../img/<?php echo showIconOrder('f3_fullname', $_GET['orderby'], $_GET['ordertype']);?>" align="absmiddle" border="0"></a>
    </th>
    <th class="hd_report" width="7%">
    อายุ (ปี)&nbsp;
    <a href="<?php echo $order_url;?>&orderby=question_age&ordertype=<?php echo $ordertype;?>"><img src="../../img/<?php echo showIconOrder('question_age', $_GET['orderby'], $_GET['ordertype']);?>" align="absmiddle" border="0"></a>
    </th>
    <th class="hd_report" width="12%">
    รายได้ต่อปี (บาท)&nbsp;
    <a href="<?php echo $order_url;?>&orderby=question_Income&ordertype=<?php echo $ordertype;?>"><img src="../../img/<?php echo showIconOrder('question_Income', $_GET['orderby'], $_GET['ordertype']);?>" align="absmiddle" border="0"></a>
    </th>
    <th class="hd_report" width="13%">
    กลุ่มเป้าหมาย (คน)&nbsp;
    <a href="<?php echo $order_url;?>&orderby=question_num&ordertype=<?php echo $ordertype;?>"><img src="../../img/<?php echo showIconOrder('question_num', $_GET['orderby'], $_GET['ordertype']);?>" align="absmiddle" border="0"></a>
    </th>
    <th class="hd_report">
    สภาพปัญหา/ความเดือนร้อน&nbsp;
    <?php /*?><a href="<?php echo $order_url;?>&orderby=problem&ordertype=<?php echo $ordertype;?>"><img src="../../img/<?php echo showIconOrder('problem', $_GET['orderby'], $_GET['ordertype']);?>" align="absmiddle" border="0"></a><?php */?>
    </th>
    <th class="hd_report">
    ความช่วยเหลือที่ต้องการ&nbsp;
    <?php /*?><a href="<?php echo $order_url;?>&orderby=f3_idcard&ordertype=<?php echo $ordertype;?>"><img src="../../img/<?php echo showIconOrder('help', $_GET['orderby'], $_GET['ordertype']);?>" align="absmiddle" border="0"></a><?php */?>
    </th>
    <th class="hd_report" width="6%">
    อำเภอ&nbsp;
    <a href="<?php echo $order_url;?>&orderby=f3_district&ordertype=<?php echo $ordertype;?>"><img src="../../img/<?php echo showIconOrder('f3_district', $_GET['orderby'], $_GET['ordertype']);?>" align="absmiddle" border="0"></a>
    </th>
    <th class="hd_report" width="6%">
    ตำบล&nbsp;
    <a href="<?php echo $order_url;?>&orderby=f3_parish&ordertype=<?php echo $ordertype;?>"><img src="../../img/<?php echo showIconOrder('f3_parish', $_GET['orderby'], $_GET['ordertype']);?>" align="absmiddle" border="0"></a>
    </th>
  
  </thead>
  <tbody>
  <?php 
  $intData = 0;
  $sum_question_Income = 0;
  $sum_question_num=0;
  $arr_bg = array('#FFF','#FFF');
  foreach($rowData as $data){ 
  
  $arrProblemHelp =  getProblemHelp($data['idcard'],$_GET['problem_id'],$_GET['help_id']);
  if(
  	(($arrProblemHelp['problem_num']==0 && $_GET['problem_id'][9999] == '9999') || $_GET['problem_id'][9999] != '9999') &&
	(($arrProblemHelp['help_num']==0 && $_GET['help_id'][9999] == '9999') || $_GET['help_id'][9999] != '9999')
  ){
  $intData++;
  ?>
  <tr style="background-color:<?php echo $arr_bg[$intData%2]?>;">
    <td align="center" valign="top"><?php echo $intData;?></td>
    <td align="center" valign="top">
    <a  class="resultinfo fancybox fancybox.iframe" href="form_show.php?id=<?php echo $data['idcard'];?>&report_type=<?php echo $report_type;?>"  style="color:#000;"><?php echo replacepin($data['idcard']);?></a>
    </td>
    <td valign="top"><?php echo $data['fullname'];?></td>
    <td align="center" valign="top"><?php echo $data['question_age'];?></td>
    <td align="center" valign="top"><?php echo ($data['question_Income']>0)?number_format($data['question_Income']):'ไม่ระบุ';?></td>
    <td align="center" valign="top"><a  class="resultinfo fancybox fancybox.iframe" href="form_show.php?id=<?php echo $data['idcard'];?>&report_type=<?php echo $report_type;?>&frame=form2" target="_blank" style="color:#000;"><?php echo number_format($data['question_num']);?></a></td>
    <td  valign="top">
	<?php
	if($arrProblemHelp['problem_comment']!=''){
		echo $arrProblemHelp['problem_comment']; 
	}else{
		if($_GET['problem_id'][9999] == '9999'){
			echo '<span class="highlight" >ไม่ระบุ</span>';
		}else{
			echo 'ไม่ระบุ';
		}
	}
	/*
	$problem_comment = substr($arrProblemHelp['problem_comment'],0,strlen($arrProblemHelp['problem_comment'])-2);
	if($arrProblemHelp['problem_num']<=1){
		echo $problem_comment;
	}else{
		$arr_problem = explode(',',$problem_comment);
		echo $arr_problem[0].'...';
		echo '<span style="cursor:pointer;color:#09F;" title="'.$arrProblemHelp['problem_comment'].'"><u>รายละเอียด</ul></span>';
	}*/
	?>
    
    </td>
  
    <td valign="top">
    <?php 
	if($arrProblemHelp['help_comment']!=''){
		echo $arrProblemHelp['help_comment'];
	}else{
		if($_GET['help_id'][9999] == '9999'){
			echo '<span class="highlight" >ไม่ระบุ</span>';
		}else{
			echo 'ไม่ระบุ';
		}
	}
	/*
	$help_comment = substr($arrProblemHelp['help_comment'],0,strlen($arrProblemHelp['help_comment'])-2);
	if($arrProblemHelp['help_num']<=1){
		echo $help_comment;
	}else{
		
		$arr_problem = explode(',',$help_comment);
		echo $arr_problem[0].'...';
		echo '<span style="cursor:pointer;color:#09F;" title="'.$help_comment.'"><u>รายละเอียด</ul></span>';
	}
	*/
	?>
	
    </td>
    <td valign="top" align="center"><?php echo $data['report_district'];?></td>
    <td valign="top" align="center"><?php echo $data['report_parish'];?></td>
  </tr>
  <?php 
  	$sum_question_Income += $data['question_Income'];
	$sum_question_num += $data['question_num'];
  	} 
  }
  ?>
  <tbody>
  <tfoot>
  <tr style="background-color:#EEE;">
    <td align="right"colspan="5">รวม</td>
    <td align="center"><?php echo number_format($sum_question_num);?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </tfoot>
</table>

</p>
</center>
</body>
</html>
