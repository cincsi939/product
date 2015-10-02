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
 
error_reporting(E_ALL ^ E_NOTICE);
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
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
	$(document).ready(function(){			
		 var newWindowHight = $(window).height();
		 var height = newWindowHight-180;
		  document.getElementById("ifram").style.height = height+'px';
	});
</script>
<style>
 .style7 {color: #000; font-weight: bold; }
#ppDriverTable th{
	 background:url(../img/bg_header.jpg);
 }
 #ifram{
	 overflow: scroll;
 }
#ppDriverTable tbody tr:nth-child(even) {background: #FFF}
#ppDriverTable tbody tr:nth-child(odd) {background: #F0FFFF}
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
<table width="100%" height="136" border="0" cellpadding="0" cellspacing="0">
  <tr background="../img/back_1.png">
    <td width="10%" height="99" align="left"  cellpadding="0" cellspacing="0" ><img src="../img/pic_2.png" width="100" height="93"></td>
    <td width="58%" align="left"  cellpadding="0" cellspacing="0" ><img src="../img/pic_3.png"></td>
    <td align="right"  cellpadding="0" cellspacing="0" ><img src="../img/pic_1.png"></td>
  </tr>
  <tr>
    <td  height="36" colspan="3" align="right" valign="middle" style="background-image: url(../img/repeat_fl_4.png);" ><a href="question_form.php"><img src="../img/menu_icon/home_menu.png" title='หน้าหลัก' width="25" height="25" border="0"></a><a href="question_form.php?frame=form1"><img src="../img/menu_icon/newspaper_add.png" title='เพิ่มข้อมูล' width="25" height="25" border="0"></a><img src="../img/menu_icon/report_menu.png" title='รายงาน' width="25" height="25"><a href="excel/report.php"><img src="../img/print_member_card.png" width="25" height="25" border="0" title='พิมพ์เป็น EXCEL'></a><a href="../usermanager/login.php"><img src="../img/menu_icon/exit_menu.png" title='ออกจากระบบ' width="25" height="25" border="0"></a></td>
  </tr>
</table>
<?php
if(isset($_GET['frame']))
{
	if(($_GET['frame']!='keyinform') and ($_GET['frame']!='form_search'))
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
        	<td width="170"><button class="button <?php if($_GET['frame']=='form1'){ echo 'button-red';  }else{echo 'button-gray';} ?>" onClick="parent.location='question_form.php?frame=form1&id=<?php echo $id; ?>'">ข้อมูลทั่วไป</button></td> 
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
	$Per_Page = 20;   // ปรับจำนวนที่ต้องการให้แสดงต่อหน้า
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
	$sql .= ',REPLACE(getCCAA(LEFT(question_parish,6)),\'ตำบล\',\'\') as question_parish,REPLACE(getCCAA(LEFT(question_district,4)),\'อำเภอ\',\'\') as question_district';
	$sql .= ' FROM question_master INNER JOIN question_detail_1 ON question_detail_1.question_main = question_master.master_id';
	
	/*$sql = 'SELECT question_id,master_id,master_idcard,master_round,master_idques,question_firstname,question_lastname,question_sex,question_age,question_Income,question_career,question_career_detail';
	$sql .= ',question_parish,question_district';
	$sql .= ' FROM question_master INNER JOIN question_detail_1 ON question_detail_1.question_main = question_master.master_id';*/
	
	 if($_POST) 
	 {
		 if($_POST['search_info']!='') // ตรวจสอบว่า มีค่าว่างหรือเปล่า
		 {
			$sql .= " WHERE master_idcard like '%".$_POST['search_info']."%'";
			$sql .= " OR question_firstname like '%".$_POST['search_info']."%'";
			$sql .= " OR question_lastname like '%".$_POST['search_info']."%'";
		 }
	 }
	 else
	 {
		 if(isset($_GET['age']))
		 {
			switch($_GET['age'])
			{
				case 1:
					$sql .= " WHERE master_age < 18";
				break;
				
				case 2:
					$sql .= " WHERE master_age > 18 AND master_age < 26";
				break;
				
				case 3:
					$sql .= " WHERE master_age > 25 AND master_age < 61";
				break;
				
				case 4:
					$sql .= " WHERE master_age > 60";
				break;
			}
			
			if(isset($_GET['sex']))
			{
				$sql .= " AND master_sex = ".$_GET['sex'];
			}
		 }
	 }
	
	$sql .=' GROUP BY master_idcard ORDER BY '.$column.' '.$order;
	$sql .=' LIMIT '.$Page_Start.','.$Per_Page;
	$con->connectDB() ;
	$results = $con->select($sql);

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
$sql_district_all = 'Select exsum_district_ccdigi,exsum_district_title,exsum_district_num,exsum_date FROM exsum_district_all';
$result_district_all  = $con->select($sql_district_all);
?>

<table width="100%" border="0" cellspacing="5" cellpadding="0">
  <tr>
    <td width="50%" align="right" valign="top">
    <br>
    <TABLE width="400" border="0"  cellspacing="1" cellpadding="3"  bgcolor="#BBCEDD"  class="ppDriverTable" id="ppDriverTable">
      <TR>
        <TD width="227" height="24" align="center" bgcolor="#D0E9ED"><strong>อำเภอ</strong></TD>
        <TD width="158" align="center" bgcolor="#D0E9ED"><STRONG>จำนวนกลุ่มสำรวจ (คน)</STRONG></TD>
      </TR>
      <tbody>
        <?php
		$sumall  = 0;
		$exsum_date = '';
	  	foreach($result_district_all as $rd)
		{
			$sumall = $rd['exsum_district_num']+$sumall;
			if($exsum_date=='')
			{
				$exsum_date = $rd['exsum_date'];
			}
	  ?>
        <TR>
          <TD  align="left" ><?php echo $rd['exsum_district_title']; ?></TD>
          <TD  align="center"><?php echo $rd['exsum_district_num']; ?></TD>
        </TR>
        <?php
		}
	  ?>
      </tbody>
      <tfoot>
        <TR  bgcolor="#D0E9ED">
          <TD align="center"><strong>ทั้งหมด</strong></TD>
          <TD align="center" ><?php echo $sumall; ?></TD>
        </TR>
      </tfoot>
    </TABLE>
    
    
    </td>
    <td width="50%" align="left" valign="top">
    <div id="myiframe_position1">
	  <iframe src="graph/pie.php" width="460" height="310" frameborder="0" scrolling="no"></iframe>
     </div>
    </td>
  </tr>
  <?php
		if($_POST) {
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
                                    <TD><FONT COLOR="#000033"><b>ค้นหาคำว่า</b></FONT> <?php echo $_POST["search_info"]; ?></TD>
                                    <TD align="right" valign="top"> จำนวนที่ค้นพบ&nbsp;
                                            <?php echo count($results); ?>
                                            &nbsp;รายการ</TD>
                            </TR>
                    </TABLE>
    
    
    </td>
  </tr>
  <?php } ?>
  <?php 
  			$sql_lastdate = 'select master_timestamp from question_master order by master_timestamp desc LIMIT 0,1'; 
  			$results_lastdate = $con->select($sql_lastdate);
			foreach($results_lastdate as $rtt){}
			$date = new DateTime($rtt['master_timestamp']); 
			$lastdate = $date->format('j/n/Y');
			$lasttime = $date->format('H:i:s');
  ?>
  <tr>
    <td colspan="2" align="right">ข้อมูล ณ วันที่ <?php $today = $con->reportDay($lastdate); echo $today[0].' '.$today[1].' '.($today[2]+543); ?> เวลา <?php echo $lasttime; ?></td>
  </tr>
  <tr>
    <td align="left"><strong>รายงานสรุป</strong></td>
    <td align="right">รายงานข้อมูล ณ วันที่
    <?php $today = $con->reportDay(date('j/n/Y')); echo $today[0].' '.$today[1].' '.($today[2]+543); ?></td>
  </tr>
  <tr>
    <td align="left"><FORM action="" method="post">
      <TABLE width="380" border="0" cellspacing="0" cellpadding="0">
        <TR>
          <TD width="50%" align="right">
          
          <SPAN style="background-position:bottom;"><SPAN class="sbox_l" ALIGN="right"></SPAN> <SPAN class="sbox" ALIGN="right">
            <INPUT type="text" id="srch_fld"  name="search_info" size="35" align="right"  onblur="if (this.value == '') {
                                        this.value = 'ค้นหา (เลขบัตร,ชื่อ,นามสกุล)';
                                        document.all.srch_fld.style.color = '#C0C0C0';
                                } else {
                                        document.all.srch_fld.style.color = '#000000';
                                }" onFocus="if (this.value == 'ค้นหา (เลขบัตร,ชื่อ,นามสกุล)') {
                                        this.value = '';
                                        document.all.srch_fld.style.color = '#C0C0C0';
                                } else {
                                        document.all.srch_fld.style.color = '#000000';
                                }"  value="<?php echo ((!empty($_POST["search_info"])) ? ($_POST["search_info"]) : ((!isset($_GET["reset_search"]) && !empty($_SESSION["search_info"]) ) ? $_SESSION["search_info"] : "ค้นหา (เลขบัตร,ชื่อ,นามสกุล)")); ?>" style="color: #C0C0C0"  onKeyPress="if (this.value == '') {
                                        document.all.srch_fld.style.color = '#C0C0C0';
                                } else {
                                        document.all.srch_fld.style.color = '#000000';
                                }" />
          </SPAN><SPAN class="sbox_r" id="srch_clear"></SPAN></SPAN>
          
          </TD>
          <TD width="50%"><SPAN style="background-position:bottom;">
            <INPUT type="submit" name="search" value="ค้นหา" />
            <!--<INPUT  type="button" name="reset_search" value="ล้างค่า"  onclick="window.location = 'mb_index.php?reset_search=Reset';"/>-->
            <?php /*?><IMG src="../img/icon_info.gif" alt="ค้นหาตามหมายเลขบัตรประชาชน ชื่อนามสกุล" width="16" height="16"  onclick="alert('ค้นหาตามหมายเลขบัตรประชาชน ชื่อนามสกุล');"  onMouseOver="this.style.cursor = 'hand';" align="absmiddle" />&nbsp;</SPAN><A href="form_search.php"><SPAN style="background-position:bottom;"><nobr>ค้นหาขั้นสูง</nobr></SPAN></A><?php */?></TD>
        </TR>
      </TABLE>
    </FORM>
<!---------------------------------------------pagechange------------------------------------------------------>

  <!--<input type="submit" name="button" id="button" value="EXPORT-Excel"  onClick="location.href='excel/reporttoexcel.php'">-->
</td>
    <td align="right">ทั้งหมด <b> <font color="#CC0000"> <?php echo $sumall; ?></font></b> รายการ แบ่งเป็น <b><font color="#0033CC"> <?php echo $Num_Pages;?> </font></b> หน้า&nbsp;&nbsp;&nbsp;<a href="question_form.php"><img src="../img/Search-Add.gif" width="16" height="16" border="0"  title="แสดงทั้งหมด" /></a>
      <?php
if($Prev_Page)
{
	echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page'><img src=\"../img/First.gif\"></a> ";
}

for($i=1; $i<=$Num_Pages; $i++){
	if($i != $Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$i'>$i</a> ";
	}
	else
	{
		echo "<b> $i </b>";
	}
}
if($Page!=$Num_Pages)
{
	echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page'><img src=\"../img/Last.gif\"></a> ";
}
?>
   </td>
  </tr>
  <tr>
    <td colspan="2"><TABLE width="100%" border="0" cellspacing="1" cellpadding="3" id="ppDriverTable" NAME="ppDriverTable" class="dtree" bgcolor="#BBCEDD" >
      <tr  class="style7">
        <th width="46" >ลำดับ</th>
        <th width="127" ><a href="?column=master_idcard&order=<?php echo $con->sortData('master_idcard',$column,$order); ?>" >เลขประจำตัวประชาชน</a></th>
        <th width="133"><a href="?column=question_firstname&order=<?php echo $con->sortData('question_firstname',$column,$order); ?>">ชื่อหัวหน้าครอบครัว</a></th>
        <th width="130"><a href="?column=question_lastname&order=<?php echo $con->sortData('question_lastname',$column,$order); ?>">นามสกุล</a></th>
        <th width="82"><a href="?column=question_age&order=<?php echo $con->sortData('question_age',$column,$order); ?>">อายุ(ปี)</a></th>
        <th width="80"><a href="?column=question_sex&order=<?php echo $con->sortData('question_sex',$column,$order); ?>">เพศ</a></th>
        <th width="201"><a href="?column=question_career&order=<?php echo $con->sortData('question_career',$column,$order); ?>">อาชีพ</a></th>
        <th width="137"><a href="?column=question_Income&order=<?php echo $con->sortData('question_Income',$column,$order); ?>">รายได้ บาท (ต่อปี)</a></th>
        <th width="76"><a href="?column=question_district&order=<?php echo $con->sortData('question_district',$column,$order); ?>">อำเภอ</a></th>
        <th width="76"><a href="?column=question_parish&order=<?php echo $con->sortData('question_parish',$column,$order); ?>">ตำบล</a></th>
        <th width="59">จัดการ</th>
      </tr>
      <?php
		//$i = 0;
		foreach($results as $row){
		?>
      <tr>
        <td align="center"><?php echo $j; ?></td>
        <td align="center"><a href="main/form_show.php?id=<?php echo $row['question_id']; ?>" id="show"><?php echo $row['master_idcard']; ?></a></td>
        <td align="left"><?php echo $row['question_firstname']; ?></td>
        <td align="left"><?php echo $row['question_lastname']; ?></td>
        <td align="center"><?php echo $row['question_age']; ?></td>
        <td align="center"><?php if($row['question_sex']==1){echo 'หญิง';}elseif($row['question_sex']==2){echo 'ชาย';}else{echo 'อื่นๆ';} ?></td>
        <td align="left"><?php echo $con->careerSelect($row['question_career']);?> </td>
        <td align="left"><?php echo @number_format($row['question_Income']); ?></td>
        <td align="left"><?php echo $row['question_district']; ?></td>
        <td align="left"><?php echo $row['question_parish']; ?></td>
        <td align="center"><a href="question_form.php?frame=form1&id=<?php echo $row['question_id']; ?>"><img src="../img/b_edit.png" width="16" height="16" border="0"></a>&nbsp;
          <a href="main_exc/from1_del_exc.php?quid=<?php echo $row['question_id']; ?>&main=<?php echo $row['master_id']; ?>" onclick="return confirm('คณต้องการลบข้อมูลนี้ออกจากตาราง?')"><img src="../img/b_drop.png" width="16" height="16" border="0"></a></td>
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