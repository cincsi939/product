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
@session_start();
if($_SESSION['user']=='')
{
	echo '<meta http-equiv="refresh" content="0;url=../usermanager/login.php">';
}
?>
<?php 
header ('Content-type: text/html; charset=utf-8'); 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>แบบสอบถามสภาพครอบครัว</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/style_menu.css">
<script src="../js/jquery-latest.min.js" type="text/javascript"></script>
<script src="../js/jquery-latest.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){			
		 var newWindowHight = $(window).height();
		 var height = newWindowHight-180;
		  //document.getElementById("ifram").style.height = height+'px';
	});
</script>
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
<?  include "header.php";?>
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
<table width="100%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td align="left" valign="top"><img src="../img/menu_icon/ascii.png" width="16" height="16" > <strong>แบบสอบถามสถาพครอบครัว</strong></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
  <td width="20%" align="left" valign="top">
    <table width="170" cellpadding="0" cellspacing="0">
    	<tr>
        	<td width="170"><button class="button <?php if($_GET['frame']=='form1'){ echo 'button-red';  }else{echo 'button-gray';} ?>" onClick="parent.location='question_form.php?frame=form1&id=<?php echo $id; ?>'">ข้อมูลทั่วไปสรุปความคิดเห็น</button></td> 
        </tr>
        <tr>
            <td><button class="button <?php if($_GET['frame']=='form2'){ echo 'button-red';  }else{echo 'button-gray';} ?>" <?php if($id!=''){ ?> onClick="parent.location='question_form.php?frame=form2&id=<?php echo $id; ?>'"<?php } ?>>ด้านกลุ่มเป้าหมาย</button> </td>
        </tr>
        <tr>
        	<td><button class="button <?php if($_GET['frame']=='form3'){ echo 'button-red';  }else{echo 'button-gray';} ?>" <?php if($id!=''){ ?> onClick="parent.location='question_form.php?frame=form3&id=<?php echo $id; ?>'"<?php } ?>>การมีส่วนร่วมในสังคม</button></td> 
        </tr>
        <tr>
        	<td><button class="button <?php if($_GET['frame']=='form4'){ echo 'button-red';  }else{echo 'button-gray';} ?>" <?php if($id!=''){ ?> onClick="parent.location='question_form.php?frame=form4&id=<?php echo $id; ?>'"<?php } ?>>สรุปความคิดเห็น</button></td>
        </tr>
    </table>
  </td>
  <td width="80%" align="left" valign="top">
  <div id="ifram">
    <?php
		if(isset($_GET['frame']))
		{
			if($_GET['frame']=='form1')
			{
				if($id!='')
				{
					include('main/form1_edit.php');
				}
				else

				{
					include('main/'.$_GET['frame'].'.php');
				}
			}
			else
			{
				include('main/'.$_GET['frame'].'.php');
			}
		}
		else
		{
			include('main/form1.php');
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
		 if($_POST['search_info']!='') // ตรวจสอบว่า มีค่าว่างหรือเปล่า
		 {
			$keyword = $_POST['search_info'];
			$where = " AND (master_idcard like '%".$_POST['search_info']."%' OR question_firstname like '%".$_POST['search_info']."%' 
						OR question_lastname like '%".$_POST['search_info']."%')";
			//$sql .= " WHERE master_idcard like '%".$_POST['search_info']."%'";
			//$sql .= " OR question_firstname like '%".$_POST['search_info']."%'";
			//$sql .= " OR question_lastname like '%".$_POST['search_info']."%'";
		 }
	 }
	 else
	 {
		if($keyword != ""){
		 $where = " AND (master_idcard like '%".$keyword."%' OR question_firstname like '%".$keyword."%' 
						OR question_lastname like '%".$keyword."%')";
						
						
	 }else{
		 
		 if(isset($_GET['ccdigi']))
		 {
			 $where = " AND question_district = ".$_GET['ccdigi']	;
		 }else{
			$where = "";	 
		 }
	 }	
		
		 
	 }
	 

	
	$sql = 'SELECT question_id';
	$sql .= ' FROM question_master INNER JOIN question_detail_1 ON question_detail_1.question_main = question_master.master_id INNER JOIN tbl_prename ON tbl_prename.id = question_prename'; 
	$sql .= " WHERE 1=1 $where";
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
 	$sql = 'SELECT question_id,master_id,master_idcard,master_round,master_idques,question_firstname,question_lastname,question_sex,question_age,question_Income,question_career,question_career_detail';
	$sql .= ',REPLACE(getCCAA(LEFT(question_parish,6)),\'ตำบล\',\'\') as question_parish,REPLACE(getCCAA(LEFT(question_district,4)),\'อำเภอ\',\'\') as question_district,prename_th,getTb2(1,question_id) as numTb2';
	$sql .= ' FROM question_master INNER JOIN question_detail_1 ON question_detail_1.question_main = question_master.master_id INNER JOIN tbl_prename ON tbl_prename.id = question_prename';
		 
	if(isset($_GET['show']))
	 {
		 $sql .=' LIMIT '.$Page_Start.','.$Per_Page;
		 //$Num_Pages = 1;
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
	$sql .= " WHERE 1=1 $where";
	$sql .=' GROUP BY master_idcard ORDER BY '.$column.' '.$order;
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
  
  <tr>
    <td rowspan="5" align="center" valign="top"><TABLE width="80%" border="0"  cellspacing="1" cellpadding="3"  bgcolor="#BBCEDD"  class="ppDriverTable" id="ppDriverTable" style="border-radius:2px;">
      <TR>
        <TD width="121" rowspan="2" align="center"  bgcolor="#DFDFDF"><strong>อำเภอ</strong></TD>
        <TD height="30" colspan="2" align="center" bgcolor="#DFDFDF"><strong>ครัวเรือนที่สำรวจ</strong></TD>
        <TD width="159" rowspan="2" align="center"  bgcolor="#DFDFDF"><strong>จำนวนสมาชิกในครัวเรือนที่อยู่<br> ในสภาวะลำบาก (คน)</strong></TD>
      </TR>
      <TR>
        <TD width="92" height="30" align="center"  bgcolor="#DFDFDF"><STRONG>(ครัวเรือน)</STRONG></TD>
        <TD width="61" align="center" bgcolor="#DFDFDF"><strong>ร้อยละ</strong></TD>
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
          <TD  align="right"><a href= "?ccdigi=<?php echo $code[$i]; ?>"><?php echo $countNum[$i]; ?></a></TD>
          <TD  align="right"><?php echo number_format($arrDataPercent[$i],2); ?></TD>
          <TD  align="right"><?php echo number_format($exsum_tb2[$i],0); ?></TD>
          </TR>
        <?php
		}
	  ?>
        </tbody>
      <tfoot>
        <TR bgcolor="#FFFFFF" >
          <TD align="left" height="20"><strong>รวม</strong></TD>
          <TD align="right" ><a href="question_form.php<?php if($_GET['show']){}else{echo '?show=all';} ?>"><?php echo $sumall; ?></a></TD>
          <TD align="right" ><?php echo number_format($sumPercent,2); ?></TD>
          <TD align="right" ><?php echo number_format($sumtb2); ?></TD>
          </TR>
        </tfoot>
    </TABLE></td>
    <td width="31%" align="left" valign="top"><img src="../img/image_23.jpg"></td>
  </tr>
  <tr>
  </tr>
  <tr>
   <?php 
  			$sql_lastdate = 'select master_timestamp from question_master order by master_timestamp desc LIMIT 0,1'; 
  			$results_lastdate = $con->select($sql_lastdate);
			foreach($results_lastdate as $rtt){}
			$date = new DateTime($rtt['master_timestamp']); 
			$lastdate = $date->format('j/n/Y');
			$lasttime = $date->format('H:i:s');
  ?>
  
    <td align="right" valign="bottom" height="10"><img src="../img/line.jpg">ข้อมูล ณ วันที่
      <?php $today = $con->reportDay($lastdate); echo $today[0].' '.$today[1].' '.($today[2]+543); ?> เวลา <?php echo $lasttime; ?></td>
  </tr>
  <tr>
    <td align="right" valign="bottom" height="10">รายงานข้อมูล ณ วันที่
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
?>
  <!--<input type="submit" name="button" id="button" value="EXPORT-Excel"  onClick="location.href='excel/reporttoexcel.php'">-->
  <a href="question_form.php?frame=form1" style="color:#FFF ; text-decoration:none;"><img src="../img/add_data.png" class="textmidle" hspace="5" title="บันทึกแบบสอบถาม"></a>
</td>
    <td align="right" valign="bottom"><b> ทั้งหมด <font color="#CC0000"> <?php echo $sumNumRows; ?></font> รายการ <?php if($_GET['show']){}else{echo 'แบ่งเป็น <font color="#0033CC">'.$Num_Pages.'</font> หน้า&nbsp;&nbsp;&nbsp;';} ?> <a href="question_form.php<?php if($_GET['show']){}else{echo '?show=all';} ?>"><?php if($_GET['show']){echo 'แบ่งหน้า';}else{echo 'แสดงทั้งหมด';} ?></a></b>
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
        <th width="34" >ลำดับ</th>
        <th width="121" ><a href="?<?php echo $pageccdigi ?>&column=master_idcard&order=<?php echo $con->sortData('master_idcard',$column,$order);?>&keyword=<?php echo $keyword ?>" >เลขประจำตัวประชาชน</a></th>
        <th width="170"><a href="?<?php echo $pageccdigi ?>&column=question_firstname&order=<?php echo $con->sortData('question_firstname',$column,$order); ?>&keyword=<?php echo $keyword ?>">ชื่อ-นามสกุล (หัวหน้าครอบครัว)</a></th>
        <th width="70"><a href="?<?php echo $pageccdigi ?>&column=question_age&order=<?php echo $con->sortData('question_age',$column,$order); ?>&keyword=<?php echo $keyword ?>">อายุ(ปี)</a></th>
        <th width="70"><a href="?<?php echo $pageccdigi ?>&column=question_sex&order=<?php echo $con->sortData('question_sex',$column,$order); ?>&keyword=<?php echo $keyword ?>">เพศ</a></th>
        <th width="120"><a href="?<?php echo $pageccdigi ?>&column=question_career&order=<?php echo $con->sortData('question_career',$column,$order); ?>&keyword=<?php echo $keyword ?>">อาชีพ</a></th>
        <th width="100"><a href="?<?php echo $pageccdigi ?>&column=question_Income&order=<?php echo $con->sortData('question_Income',$column,$order); ?>&keyword=<?php echo $keyword ?>">รายได้ต่อปี (บาท)</a></th>
        <th width="160"><a href="?<?php echo $pageccdigi ?>&column=numTb2&order=<?php echo $con->sortData('numTb2',$column,$order); ?>&keyword=<?php echo $keyword ?>"><strong>จำนวนสมาชิกในครัวเรือนที่อยู่<br> ในสภาวะลำบาก (คน)</strong></a></th>
        <th width="63"><a href="?<?php echo $pageccdigi ?>&column=question_district&order=<?php echo $con->sortData('question_district',$column,$order); ?>&keyword=<?php echo $keyword ?>">อำเภอ</a></th>
        <th width="58"><a href="?<?php echo $pageccdigi ?>&column=question_parish&order=<?php echo $con->sortData('question_parish',$column,$order); ?>&keyword=<?php echo $keyword ?>">ตำบล</a></th>
        <th>จัดการ</th>
        </tr>
      <?php
		//$i = 0;
		foreach($results as $row){
		?>
      <tr class="data">
        <td align="center"><?php echo $j; ?></td>
        <td align="center"><a href="main/form_show.php?id=<?php echo $row['master_idcard']; ?>" id="show"><?php echo str_replace($keyword,"<span style='background-color:#FFFF00'>".$keyword."</span>",$row['master_idcard']); ?></a></td>
        <td align="left"><?php echo $row['prename_th']; ?><?php echo str_replace($keyword,"<span style='background-color:#FFFF00'>".$keyword."</span>",$row['question_firstname']); ?> <?php echo str_replace($keyword,"<span style='background-color:#FFFF00'>".$keyword."</span>",$row['question_lastname']); ?></td>
        <td align="center"><?php echo $row['question_age']; ?></td>
        <td align="center"><?php if($row['question_sex']==1){echo 'หญิง';}elseif($row['question_sex']==2){echo 'ชาย';}else{echo 'อื่นๆ';} ?></td>
        <td align="left"><?php echo $con->careerSelect($row['question_career']);?> </td>
        <td align="right"><?php if($row['question_Income']==0){echo 'ไม่ระบุ';}else{echo @number_format($row['question_Income']);} ?></td>
        <td align="center"><?php echo $row['numTb2']; ?></td>
        <td align="left"><?php echo $row['question_district']; ?></td>
        <td align="left"><?php echo $row['question_parish']; ?></td>
        <td width="40" align="center"><a href="question_form.php?frame=form1&id=<?php echo $row['question_id']; ?>"><img src="../img/b_edit.png" width="16" height="16" border="0"></a>&nbsp;
          <a href="main_exc/from1_del_exc.php?quid=<?php echo $row['question_id']; ?>&main=<?php echo $row['master_id']; ?>" onClick="return confirm('คณต้องการลบข้อมูลนี้ออกจากตาราง?')"><img src="../img/b_drop.png" width="16" height="16" border="0"></a></td>
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
?>
</body>
</html>