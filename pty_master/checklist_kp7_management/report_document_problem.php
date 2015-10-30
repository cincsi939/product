<?
session_start();
set_time_limit(0);

include("checklist2.inc.php");
//echo "ประเภทเอกสาร ::".$type_doc;


if($type_doc == ""){
		$type_doc = "1";
}

	if($xlv == ""){
			$xlv = "1";
	}
	
	//echo "xlv = $xlv  <br>ปัญหา :: ".$typeproblem."<br>type_doc :: $type_doc<br>";
	
	if($type_doc == "11"){
		$arr1 =  CountProblemArea($xsiteid,$profile_id,$schoolid,$xlv,$school_type);
		//$num_data = count($arr1); // จำนวนรายการทั้งหมด
	//	echo "<pre>";
	//	print_r($arr1);
		//$num_data = array_sum($arr1['numid']);
		if(count($arr1) > 0){
		foreach($arr1 as $key_sum => $val_sum){
			$num_data += $val_sum['numid'];
				
		}//end 	foreach($arr1 as $key_sum => $val_sum){
		}else{
			$num_data = count($arr1);	
		}
		
	}else	if(($type_doc == "1" or $type_doc == "2" or $typeproblem == "99") and $type_doc != "4" and $type_doc != "11"){
		$arr1 = CountProblem($xsiteid,$profile_id,$schoolid,$xlv,$school_type);
		$num_data = count($arr1); // จำนวนรายการทั้งหมด
	}else if($type_doc == "3" and $typeproblem != "99"){
		$xarr1 = CountProblemSort($xsiteid,$profile_id,$schoolid,$xlv,$typeproblem);
		$num_data = count($xarr1);
	}else if($type_doc == "4"){
			  if($schoolid != ""){
					 $conS1 = " AND tbl_checklist_kp7.schoolid='$schoolid'";
			}else{
					$conS1 = "";	
			}
			  
	 if($school_type == '0'){
	  		$con_pschool =  " AND (edubkk_master.allschool_math_sd.schid IS NULL OR edubkk_master.allschool_math_sd.schid = '') ";
	}elseif($school_type == '1'){
	 		 $con_pschool =  " AND (edubkk_master.allschool_math_sd.schid != '') ";
	}else{
	  		$con_pschool = "";
	}	  
		
	  	if($xlv == ""){
				$conx = "AND ((status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0') OR
 (status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0'))";
		}else if($xlv == "1"){
				$conx = "AND (
 (status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0'))";
		}else if($xlv == "2"){
				$conx = "AND ((status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0'))";
		}else if($xlv == "3"){
				$conx = " AND  (status_numfile='1' and status_check_file='YES' and status_id_false='1' and status_file='0' and (mainpage IS NULL  or mainpage='' or mainpage='1'))";	
		}else if($xlv == "4"){
				$conx = " AND (status_numfile='1' and status_check_file='YES' and status_id_false='1' and mainpage='0')";
		}
	  	
		
		if($school_type != ""){
			$sql = "SELECT * FROM tbl_checklist_kp7 LEFT JOIN edubkk_master.allschool_math_sd ON tbl_checklist_kp7.schoolid = edubkk_master.allschool_math_sd.schoolid WHERE tbl_checklist_kp7.profile_id='$profile_id' and tbl_checklist_kp7.siteid='$xsiteid' AND problem_status_id='$problem_status_id' $conx $conS1 $con_pschool";
		}else{	
      		$sql = "SELECT * FROM tbl_checklist_kp7 WHERE tbl_checklist_kp7.profile_id='$profile_id' and siteid='$xsiteid' AND problem_status_id='$problem_status_id' $conx $conS1";
		}
			//echo $sql;
			$result = mysql_db_query($dbname_temp,$sql);
			$num_data = @mysql_num_rows($result);
	}

	if($xlv == "1"){
		$htitle = "ที่ตรวจสอบแล้วไม่สมบูรณ์";	
		$htitle1 ="หมวดรายการที่ไม่สมบูรณ์ (รายการ)";
	}else if($xlv == "2"){
		$htitle = "ที่ตรวจสอบแล้วขาดเอกสารประกอบ";	
		$htitle1 ="หมวดรายการขาดเอกสารประกอบ (รายการ)";
	}else if($xlv == "3"){
		$htitle = "ที่ตรวจสอบแล้วไม่สมบูรณ์(เลขบัตรไม่สมบูรณ์)";		
		$htitle1 ="หมวดรายการไม่สมบูรณ์ (รายการ) เลขบัตรไม่สมบูรณ์";
	}else if($xlv == "4"){
		$htitle = "ที่ตรวจสอบแล้วขาดเอกสารประกอบ(เลขบัตรไม่สมบูรณ์)";		
		$htitle1 ="หมวดรายการขาดเอกสารประกอบ(รายการ) เลขบัตรไม่สมบูรณ์";
	}else{
		$htitle = "ที่ตรวจสอบแล้วไม่สมบูรณ์";	
		$htitle1 ="หมวดรายการที่ไม่สมบูรณ์ (รายการ)";
	}


	
	
	$arruser = UserChecklist($xsiteid,$profile_id,$xlv);
	
	$last_id = SaveLogLoadPage("2",$profile_id,$num_data);
	
	//echo "<pre>";
	//print_r($arr1);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<link href="../../common/tooltip_checklist/css/style.css" rel="stylesheet" type="text/css" />
<script src="../../common/tooltip_checklist/jquery_1_3_2.js"></script>
<script src="../../common/tooltip_checklist/script.js"></script>
<link href="../../common/cssfixtable.css" rel="stylesheet" type="text/css">
<SCRIPT type=text/javascript src="../../common/jscriptfixcolumn/jquery.min.js"></SCRIPT>
<SCRIPT type=text/javascript src="../../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></SCRIPT>
<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<style>
.txthead{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtexsum{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtdate{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000; 
}
.txtdata{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #000; 
}
.txt_link a:link {
	FONT-SIZE: 12px;
	color: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:visited {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:active {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline;FONT-WEIGHT: bold;
}
.style1 {color: #006600}
.fillcolor_headgraph{	
	padding: 2pt;
	background-color:#0063C9;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#0063C9', EndColorStr='#000467');
}
.fillcolor_headgraph2{	
	padding: 2pt;
	background-color:#E6E6E6;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#E6E6E6', EndColorStr='#8E8E8E');
	font-weight:bold;
}
</style>
<SCRIPT type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
			$(".tbl4").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
			$(".tbl5").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
			$(".tbl6").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
			$(".tbl7").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
			$(".tbl8").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
        });
</SCRIPT>


</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td align="center" bgcolor="#FFFFFF">รายละเอียดสำเนาเอกสารทะเบียนประวัติ กพ.7 ต้นฉบับ (
              <?=ShowProfile_name($profile_id);?>
              ) <?=$htitle?></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#FFFFFF"><?
			
			//if($type_doc == "11"){ $txtval = "หน่วยงาน";}else{ $txtval = "คน";}
			 $txtval = "คน";
			 if($schoolid != ""){ echo "หน่วยงาน&nbsp;".show_school($schoolid)."  ".show_area($xsiteid)." จำนวนรวม $num_data $txtval ";}else{ echo show_area($xsiteid)."&nbsp;".$_GET['txt_title']."&nbsp;&nbsp;"." จำนวนรวม $num_data $txtval ";}?>&nbsp;</td>
            </tr>
          <tr>
            <td align="right" bgcolor="#FFFFFF"><A href="#" onClick="window.open('select_document.php?profile_id=<?=$profile_id?>&xsiteid=<?=$xsiteid?>&xlv=<?=$xlv?>&schoolid=<?=$schoolid?>&school_type=<?=$school_type?>&txt_title=<?=$txt_title?>','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');"><img src="../validate_management/images/cog_edit.png" width="16" height="16" border="0" title="คลิ๊กกำหนดรูปแบบการแสดงผล"></A>&nbsp;รายงาน ณ วันที่
              <?=thai_date(date("Y-m-d")); ?>
              &nbsp;&nbsp;&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <? if($type_doc == "1"){?>
  <tr>
    <td align="left" bgcolor="#FFFFFF">
		<?
		if($xgen_id == ""){		  
	?>
	<a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=">แสดงทั้งหมด</a> |<a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=0&txt_title=(สังกัด สพป.)">สังกัด สพป.</a> |<a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=1&txt_title=(สังกัด สพม.)"> สังกัด สพม.</a>

	<?
			 }// end 	
	?>
	<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl3">
      <tr>
        <td width="3%" rowspan="2" align="center" bgcolor="#CCCCCC">ลำ<br>
          ดับ</td>
        <td width="10%" rowspan="2" align="center" bgcolor="#CCCCCC">ชื่อ-นาม<br>
          สกุล</td>
        <td width="8%" rowspan="2" align="center" bgcolor="#CCCCCC">ตำแหน่ง</td>
        <? if($schoolid == ""){?>
        <td width="10%" rowspan="2" align="center" bgcolor="#CCCCCC">หน่วยงาน</td>
          <? }//end if($schoolid != ""){?>
        <td colspan="16" align="center" bgcolor="#CCCCCC"><?=$htitle1?></td>
        </tr>
      <tr>
        
      
        <td width="4%" align="center" bgcolor="#CCCCCC">จำนวน<br>
          (แผ่น)</td>
        <td width="4%" align="center" bgcolor="#CCCCCC">ปก<br>
          หน้า</td>
        <td width="4%" align="center" bgcolor="#CCCCCC">ข้อมูล<br>
          ทั่วไป</td>
        <td width="4%" align="center" bgcolor="#CCCCCC">เครื่อง<br>
          ราชฯ</td>
        <td width="4%" align="center" bgcolor="#CCCCCC">ขาด<br>
          ลาฯ</td>
        <td width="4%" align="center" bgcolor="#CCCCCC">โทษ<br>
          วินัยฯ</td>
        <td width="6%" align="center" bgcolor="#CCCCCC">วันที่<br>
          ไม่ได้รับ<br>
          เงิน<br>
          เดือนฯ</td>
        <td width="5%" align="center" bgcolor="#CCCCCC">การ<br>
          ศึกษา</td>
        <td width="3%" align="center" bgcolor="#CCCCCC">อบ<br>
          รมฯ</td>
        <td width="5%" align="center" bgcolor="#CCCCCC">ตำ<br>
          แหน่ง /เงิน<br>
          เดือนฯ</td>
        <td width="5%" align="center" bgcolor="#CCCCCC">ความ<br>
          สามารถ<br>
          พิเศษฯ</td>
        <td width="6%" align="center" bgcolor="#CCCCCC">ปฏิบัติ<br>
ราชการ<br>
          พิเศษ</td>
        <td width="5%" align="center" bgcolor="#CCCCCC">ผลงาน<br>
          วิชาการ</td>
        <td width="4%" align="center" bgcolor="#CCCCCC">ความดี<br>
          ความ<br>
          ชอบ</td>
        <td width="3%" align="center" bgcolor="#CCCCCC">อื่น ๆ</td>
        <td width="3%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <? 

	  
	  	if(count($arr1) > 0){
			$i=0;
			foreach($arr1 as $key => $val){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			
			// <a class="personPopupTrigger" href="#" rel="5001,3501800010958">
	  
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left">
		
		<? echo "<a class=\"personPopupTrigger\" href=\"#\" rel=\"พนักงานตรวจสอบ $arruser[$key],ข้อมูลของ $val[fullname]\">".$val['fullname']."</a>";?></td>
        <td align="left"><?=$val['position_now']?></td>
        <? if($schoolid == ""){?>
        <td align="left"><?=$val['schoolid']?></td>
        <? }// ehd if(){?>
        <td align="center"><?=ShowDash($val['page_num'])?></td>
           <td align="center"><?=ShowDash($val['nopage'])?></td>
        <td align="center"><?  if($val['p1'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=1&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p1'])."</a>";}else{  echo ShowDash($val['p1']);}?></td>
        <td align="center"><?  if($val['p6'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=6&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p6'])."</a>";}else{  echo ShowDash($val['p6']);}?></td>
        
        <td align="center">
        <?  if($val['p9'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=9&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p9'])."</a>";}else{  echo ShowDash($val['p9']);}?>
        </td>
        <td align="center">
        
        <?  if($val['p11'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=11&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p11'])."</a>";}else{  echo ShowDash($val['p11']);}?>
        </td>
        <td align="center">
        <?  if($val['p10'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=10&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p10'])."</a>";}else{  echo ShowDash($val['p10']);}?></td>
        <td align="center">
        <?  if($val['p2'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=2&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p2'])."</a>";}else{  echo ShowDash($val['p2']);}?>
        </td>
        <td align="center">
        <?  if($val['p4'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=4&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p4'])."</a>";}else{  echo ShowDash($val['p4']);}?>
        </td>
        <td align="center">
        <?  if($val['p3'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=3&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p3'])."</a>";}else{  echo ShowDash($val['p3']);}?>
        </td>
        <td align="center">
        <?  if($val['p7'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=7&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p7'])."</a>";}else{  echo ShowDash($val['p7']);}?>
        </td>
        <td align="center">
        <?  if($val['p12'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=12&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p12'])."</a>";}else{  echo ShowDash($val['p12']);}?>
        </td>
        <td align="center">
        <?  if($val['p5'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=5&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p5'])."</a>";}else{  echo ShowDash($val['p5']);}?>
        </td>
        <td align="center">
        <?  if($val['p8'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=8&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p8'])."</a>";}else{  echo ShowDash($val['p8']);}?>
        </td>
        <td align="center">
        <?  if($val['p13'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=13&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p13'])."</a>";}else{  echo ShowDash($val['p13']);}?>
        </td>
        <td align="center"><? if($val['type_doc'] == "0"){ echo "<img src=\"../../images_sys/docold.png\" width=\"20\" height=\"20\" title=\"เอกสารรุ่นเก่า\">"; }else{  echo "<img src=\"../../images_sys/docnew.png\" width=\"22\" height=\"15\" title=\"เอกสารรุ่นใหม่\">";}?>
         </td>
      </tr>
      <?
	$sum1 += $val['page_num'];
	$sum2 += $val['nopage'];
	$sum3 += $val['p1'];
	$sum4 += $val['p6'];
	$sum5 += $val['p9'];
	$sum6 += $val['p11'];
	$sum7 += $val['p10'];
	$sum8 += $val['p2'];
	$sum9 += $val['p4'];
	$sum10 += $val['p3'];
	$sum11 += $val['p7'];
	$sum12 += $val['p12'];
	$sum13 += $val['p5'];
	$sum14 += $val['p8'];
	$sum15 += $val['p13'];
	 SaveLogLoadPageDetail($last_id);
	 	if($i == $num_data){
				UpdateLoadPage($last_id);
		}
		}//end 	foreach($arr1 as $key => $val){
	}//end  	if(count($arr1) > 0){
	  if($schoolid == ""){ $consp = "4";}else{ $consp = "3";}
	  ?>
      <tr>
        <td colspan="<?=$consp?>" align="center">รวม </td>
        <td align="center"><?=ShowDash($sum1)?></td>
        <td align="center"><?=ShowDash($sum2)?></td>
        <td align="center"><?=ShowDash($sum3)?></td>
        <td align="center"><?=ShowDash($sum4)?></td>
        <td align="center"><?=ShowDash($sum5)?></td>
        <td align="center"><?=ShowDash($sum6)?></td>
        <td align="center"><?=ShowDash($sum7)?></td>
        <td align="center"><?=ShowDash($sum8)?></td>
        <td align="center"><?=ShowDash($sum9)?></td>
        <td align="center"><?=ShowDash($sum10)?></td>
        <td align="center"><?=ShowDash($sum11)?></td>
        <td align="center"><?=ShowDash($sum12)?></td>
        <td align="center"><?=ShowDash($sum13)?></td>
        <td align="center"><?=ShowDash($sum14)?></td>
        <td align="center"><?=ShowDash($sum15)?></td>
        <td align="center">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">หมายเหตุ : </td>
  </tr>
  <tr>
    <td align="left"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="5%" align="center"><img src="../../images_sys/docold.png" width="20" height="20" title="เอกสารรุ่นเก่า"></td>
        <td width="95%" align="left">เอกสารรุ่นเก่า</td>
      </tr>
      <tr>
        <td align="center"><img src="../../images_sys/docnew.png" width="22" height="15" title="เอกสารรุ่นใหม่"></td>
        <td align="left">เอกสารรุ่นใหม่</td>
      </tr>
    </table></td>
  </tr>
  <? 
 
  
  }else if(($type_doc == "2" or $typeproblem == "99") and $type_doc != "4" and $type_doc != "11"){
	  	if($typeproblem == "99"){
				$xtitle1 = "แสดงรายละเอียดบุคคลแยกรายหมวดปัญหา";
		}else{
				$xtitle1 = "แสดงรายละเอียดรายบุคคล";
		}
	  
	  ?>
      <tr><td>	
	  	<?
		if($xgen_id == ""){		  
	?>
	  <a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=">แสดงทั้งหมด</a> |<a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=0&txt_title=(สังกัด สพป.)">สังกัด สพป.</a> |<a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=1&txt_title=(สังกัด สพม.)"> สังกัด สพม.</a>
	  <?
	  }//end 	
	?>
	  </td></tr>
  <tr>
    <td align="left" bgcolor="#E5E5E5"><table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl4">
      <tr>
        <td colspan="6" align="center" bgcolor="#CCCCCC"><strong><?=$xtitle1?></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="16%" align="center" bgcolor="#CCCCCC"><strong>เลขบัตร</strong></td>
        <td width="21%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="22%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <td width="19%" align="center" bgcolor="#CCCCCC"><strong>หน่วยงานสังกัด</strong></td>
        <td width="18%" align="center" bgcolor="#CCCCCC"><strong>จำนวนรายการ</strong></td>
      </tr>
      <?
	 if($school_type == '0'){
	  $con_pschool =  " AND (edubkk_master.allschool_math_sd.schid IS NULL OR edubkk_master.allschool_math_sd.schid = '') ";
	}elseif($school_type == '1'){
	  $con_pschool =  " AND (edubkk_master.allschool_math_sd.schid != '') ";
	}else{
	  $con_pschool = "";
	}

	  
	  
	 if($schoolid != ""){
			 $conS1 = " AND tbl_checklist_kp7.schoolid='$schoolid'";
	}else{
			$conS1 = "";	
	}
	  
	  	if($xlv == ""){
				$conx = "AND ((status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0') OR
 (status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0'))";
		}else if($xlv == "1"){
				$conx = "AND (
 (status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0'))";
		}else if($xlv == "2"){
				$conx = "AND ((status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0'))";
		}else if($xlv == "3"){
				$conx = " AND  (status_numfile='1' and status_check_file='YES' and status_id_false='1' and status_file='0' and (mainpage IS NULL  or mainpage='' or mainpage='1'))";	
		}else if($xlv == "4"){
				$conx = " AND (status_numfile='1' and status_check_file='YES' and status_id_false='1' and mainpage='0')";
		}
	  	if($school_type != ""){
			$sql = "SELECT * FROM tbl_checklist_kp7  LEFT JOIN edubkk_master.allschool_math_sd ON tbl_checklist_kp7.schoolid = edubkk_master.allschool_math_sd.schoolid WHERE tbl_checklist_kp7.profile_id='$profile_id' and tbl_checklist_kp7.siteid='$xsiteid' $conx $conS1 $con_pschool   ORDER BY tbl_checklist_kp7.schoolid ASC";
			//echo $sql;
		}else{
				$sql = "SELECT * FROM tbl_checklist_kp7 WHERE tbl_checklist_kp7.profile_id='$profile_id' and siteid='$xsiteid' $conx $conS1 ORDER BY tbl_checklist_kp7.schoolid ASC";
		}
      	
		//echo $sql;
			$result = mysql_db_query($dbname_temp,$sql);

			$ii=0;
			while($rs = mysql_fetch_assoc($result)){
				
				
				if($rs[mainpage] == "0"){
					$numpagex = 1;	
				}else{
					$numpagex = 0;	
				}
					 if ($ii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
							$pre_org = $rs[prefix_name];
				
					
				$sql_detail = "SELECT
tbl_checklist_problem_detail.idcard,
tbl_checklist_problem_detail.problem_id,
tbl_checklist_problem_detail.menu_id,
tbl_checklist_problem_detail.problem_detail,
tbl_checklist_problem_detail.status_problem,
tbl_checklist_problem_detail.profile_id,
tbl_check_menu.menu_detail,
tbl_problem.problem
FROM
tbl_checklist_problem_detail
Inner Join tbl_check_menu ON tbl_checklist_problem_detail.menu_id = tbl_check_menu.menu_id
Inner Join tbl_problem ON tbl_checklist_problem_detail.problem_id = tbl_problem.problem_id
where idcard='$rs[idcard]' and profile_id='$profile_id'
order by tbl_check_menu.orderby ASC";
//echo $sql_detail."<br>";
$result_detail = mysql_db_query($dbname_temp,$sql_detail);
$xnumr1 = @mysql_num_rows($result_detail);

	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$ii?></td>
        <td align="center"><? echo "<a class=\"personPopupTrigger\" href=\"#\" rel=\"พนักงานตรวจสอบ.".$arruser[$rs[idcard]].",ข้อมูลของ $rs[prename_th]$rs[name_th]  $rs[surname_th]\">".$rs[idcard]."</a>";?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="left"><? echo $pre_org."".show_school($rs[schoolid]);?></td>
        <td align="center"><?=number_format($xnumr1+$numpagex);?></td>
      </tr>
      <? 
	  $tempnum = $xnumr1+$numpagex;
	  if($tempnum > 0){?>
      <tr >
        <td colspan="6" align="center" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="20%">&nbsp;</td>
            <td width="80%"><table width="100%" border="0" align="right" cellpadding="3" cellspacing="1">
          <tr>
            <td width="30%" align="center" bgcolor="#EEEEEE">หมวดรายการเอกสาร ก.พ.7</td>
            <td width="45%" align="center" bgcolor="#EEEEEE">ปัญหา</td>
            </tr>
          <? 
		  if($numpagex > 0){
				echo "<tr bgcolor=\"#FFFFFF\">
            <td align=\"left\">&nbsp;</td>
            <td align=\"left\">ปกเอกสาร</td>
            <td align=\"left\">$rs[mainpage_comment]</td>
          </tr>
"; 
			}
		  
		   while($rsd = mysql_fetch_assoc($result_detail)){
			 
		  ?>
          <tr bgcolor="#FFFFFF">
            <td align="left"><? echo $rsd[menu_detail];?></td>
            <td align="left"><? echo $rsd[problem_detail];?></td>
            </tr>
          <?
          	}//end while($rsd = mysql_fetch_assoc($result_detail)){
		  ?>
          
        </table></td>
          </tr>
        </table></td>
        </tr>
       <? }//end if($xnumr1 > 0){ ?>
      <?	  
		SaveLogLoadPageDetail($last_id);
			 	if($ii == $num_data){
					UpdateLoadPage($last_id);
				}
		}//end 	while($rs = mysql_fetch_assoc($result)){
			
			
	  ?>
    </table></td>
  </tr>
  
  <? }else if($type_doc == "3" and $typeproblem != "99"){
	  
	  	if($typeproblem == "1"){
				$xtitle2 = "เอกสารไม่ชัด";
		}else if($typeproblem == "2"){
				$xtitle2 = "ข้อมูลไม่เป็นปัจจุบัน";
		}else if($typeproblem == "3"){
				$xtitle2 = "จำนวนหน้าไม่ครบ";
		}else if($typeproblem == "4"){
				$xtitle2 = "อื่นๆ";	
		}else{
				$xtitle2 = "ขาดเอกสารประกอบ";	
		}
	  ?>
       <tr><td>
	   	<?
		if($xgen_id == ""){		  
	?>
	   <a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=">แสดงทั้งหมด</a> |<a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=0&txt_title=(สังกัด สพป.)">สังกัด สพป.</a> |<a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=1&txt_title=(สังกัด สพม.)"> สังกัด สพม.</a>
	   <?
	  }//end 	
	?>
	   </td></tr>
  <tr>
    <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" bgcolor="#E5E5E5"><table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl5">
          <tr>
            <td colspan="6" align="center" bgcolor="#CCCCCC"><strong>แสดงรายงานแยกรายหมวดปัญหา(<?=$xtitle2?>)</strong></td>
            </tr>
          <tr>
            <td width="4%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
            <td width="16%" align="center" bgcolor="#CCCCCC"><strong>เลขบัตร</strong></td>
            <td width="21%" align="center" bgcolor="#CCCCCC"><strong>ชื่อนามสกุล</strong></td>
            <td width="23%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
            <td width="19%" align="center" bgcolor="#CCCCCC"><strong>หน่วยงานสังกัด</strong></td>
            <td  width="17%" align="center" bgcolor="#CCCCCC"><strong>จำนวนรายการ</strong></td>
            </tr>
            <?
			
            if($num_data > 0){
				//echo "<pre>";
				//print_r($xarr1);
				$xi = 0;
				foreach($xarr1 as $key => $val){
					
					
					 if ($xi++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
					 $sqlx = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$key' AND profile_id='$profile_id'";
					 $resultx = mysql_db_query($dbname_temp,$sqlx);
					 $rsx = mysql_fetch_assoc($resultx);


				$xsum1 =count($val);
				

					
			?>
          <tr bgcolor="<?=$bg?>">
            <td  align="center"><?=$xi?></td>
            <td align="center"><? echo "<a class=\"personPopupTrigger\" href=\"#\" rel=\"พนักงานตรวจสอบ.".$arruser[$key].",ข้อมูลของ $rsx[prename_th]$rsx[name_th]  $rsx[surname_th]\">".$key."</a>";?></td>
            <td align="left" ><? echo "$rsx[prename_th]$rsx[name_th]  $rsx[surname_th]";?></td>
            <td align="left" ><? echo "$rsx[position_now]"; ?></td>
            <td align="left" ><? echo $pre_org."".show_school($rsx[schoolid]);?></td>
            <td align="center"><?=number_format($xsum1)?></td>
          </tr>
          <tr bgcolor="<?=$bg?>">
            <td colspan="6"  align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="20%" align="center">&nbsp;</td>
                <td width="80%" align="center"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                  <tr>
                    <td width="43%" align="center" bgcolor="#EEEEEE">หมวดรายการเอกสาร ก.พ.7</td>
                    <td width="57%" align="center" bgcolor="#EEEEEE">ปัญหา</td>
                  </tr>
                  <?
				  $xi1= 0;
                  	foreach($val as $k1 => $v1){
						 if ($xi1++ %  2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}
						 if($v1['mainpage'] != ""){
							echo "<tr bgcolor=\"$bg1\">
                    <td align=\"left\" valign=\"top\">
                    ปกเอกสาร
                    </td>
                    <td align=\"left\" valign=\"top\">
                      ".$v1['mainpage']."
                    </td>
                  </tr>
";		 
						}
						
				  ?>
                  <tr bgcolor="<?=$bg1?>">
                    <td align="left" valign="top" bgcolor="#FFFFFF">
                      <?=$v1['menu_detail']?>
                    </td>
                    <td align="left" valign="top" bgcolor="#FFFFFF">
                      <?=$v1['problem_detail']?>
                    </td>
                  </tr>
                  <?
					}//
				  ?>
                </table></td>
              </tr>
            </table></td>
            </tr>
         <?
		 SaveLogLoadPageDetail($last_id);
		 	 		if($xi == $num_data){
						UpdateLoadPage($last_id);
					}
				}//end foreach($xarr1 as $key => $val){
			}//end if($num_data > 0){
		 ?> 
         
        </table></td>
      </tr>
    </table></td>
  </tr>
  <?

  }//end //end  }else if($type_doc == "1"){ 
  if($type_doc == "4"){
	  
  ?>
   <tr><td>	
   	<?
		if($xgen_id == ""){		  
	?>
   <a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=">แสดงทั้งหมด</a> |<a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=0&txt_title=(สังกัด สพป.)">สังกัด สพป.</a> |<a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=1&txt_title=(สังกัด สพม.)"> สังกัด สพม.</a>
   <?
  }//end 	
	?>
   </td></tr>
  <tr>
    <td align="left" bgcolor="#E5E5E5"><table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl6">
      <tr>
        <td colspan="6" align="center" bgcolor="#CCCCCC"><strong>แสดงรายงานแยกรายการแก้ไขเอกสาร(<?=ShowProblemStatus($problem_status_id);?>)</strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="17%" align="center" bgcolor="#CCCCCC"><strong>เลขบัตร</strong></td>
        <td width="19%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="23%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <td width="19%" align="center" bgcolor="#CCCCCC"><strong>หน่วยงานสังกัด</strong></td>
        <td width="17%" align="center" bgcolor="#CCCCCC"><strong>จำนวนรายการ</strong></td>
      </tr>
      <?
	  
	if($school_type == '0'){
	  $con_pschool =  " AND (edubkk_master.allschool_math_sd.schid IS NULL OR edubkk_master.allschool_math_sd.schid = '') ";
	}elseif($school_type == '1'){
	  $con_pschool =  " AND (edubkk_master.allschool_math_sd.schid != '') ";
	}else{
	  $con_pschool = "";
	}


    if($schoolid != ""){
			 $conS1 = " AND tbl_checklist_kp7.schoolid='$schoolid'";
	}else{
			$conS1 = "";	
	}
	  
	  	if($xlv == ""){
				$conx = "AND ((status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0') OR
 (status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0'))";
		}else if($xlv == "1"){
				$conx = "AND (
 (status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0'))";
		}else if($xlv == "2"){
				$conx = "AND ((status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0'))";
		}else if($xlv == "3"){
				$conx = " AND  (status_numfile='1' and status_check_file='YES' and status_id_false='1' and status_file='0' and (mainpage IS NULL  or mainpage='' or mainpage='1'))";	
		}else if($xlv == "4"){
				$conx = " AND (status_numfile='1' and status_check_file='YES' and status_id_false='1' and mainpage='0')";
		}
	  	
		if($school_type != ""){
				$sql = "SELECT * FROM tbl_checklist_kp7  LEFT JOIN edubkk_master.allschool_math_sd ON tbl_checklist_kp7.schoolid = edubkk_master.allschool_math_sd.schoolid  WHERE tbl_checklist_kp7.profile_id='$profile_id' and tbl_checklist_kp7.siteid='$xsiteid' AND problem_status_id='$problem_status_id' $conx $conS1 $con_pschool  ORDER BY tbl_checklist_kp7.schoolid ASC";
				
		}else{
      		$sql = "SELECT * FROM tbl_checklist_kp7 WHERE tbl_checklist_kp7.profile_id='$profile_id' and siteid='$xsiteid' AND problem_status_id='$problem_status_id' $conx $conS1  ORDER BY tbl_checklist_kp7.schoolid ASC";
		}
		//echo $sql;
			$result = mysql_db_query($dbname_temp,$sql);
			$ii=0;
			while($rs = mysql_fetch_assoc($result)){
				
				if($rs[mainpage] == "0"){
					$numpagex = 1;	
				}else{
					$numpagex = 0;	
				}
					 if ($ii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}

					
				$sql_detail = "SELECT
tbl_checklist_problem_detail.idcard,
tbl_checklist_problem_detail.problem_id,
tbl_checklist_problem_detail.menu_id,
tbl_checklist_problem_detail.problem_detail,
tbl_checklist_problem_detail.status_problem,
tbl_checklist_problem_detail.profile_id,
tbl_check_menu.menu_detail,
tbl_problem.problem
FROM
tbl_checklist_problem_detail
Inner Join tbl_check_menu ON tbl_checklist_problem_detail.menu_id = tbl_check_menu.menu_id
Inner Join tbl_problem ON tbl_checklist_problem_detail.problem_id = tbl_problem.problem_id
where idcard='$rs[idcard]' and profile_id='$profile_id'
order by tbl_check_menu.orderby ASC";
//echo $sql_detail."<br>";
$result_detail = mysql_db_query($dbname_temp,$sql_detail);
$xnumr1 = @mysql_num_rows($result_detail);

	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$ii?></td>
        <td align="center"><? echo "<a class=\"personPopupTrigger\" href=\"#\" rel=\"พนักงานตรวจสอบ.".$arruser[$rs[idcard]].",ข้อมูลของ $rs[prename_th]$rs[name_th]  $rs[surname_th]\">".$rs[idcard]."</a>";?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="left"><? echo $pre_org."".show_school($rs[schoolid]);?></td>
        <td align="center"><?=number_format($xnumr1+$numpagex);?></td>
      </tr>
      <? 
	  $tempnum = $xnumr1+$numpagex;
	  if($tempnum > 0){?>
      <tr >
        <td colspan="6" align="center" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="20%">&nbsp;</td>
            <td width="80%"><table width="100%" border="0" align="right" cellpadding="3" cellspacing="1">
          <tr>
            <td width="30%" align="center" bgcolor="#EEEEEE">หมวดรายการเอกสาร ก.พ.7</td>
            <td width="45%" align="center" bgcolor="#EEEEEE">ปัญหา</td>
            </tr>
          <? 
		  if($numpagex > 0){
				echo "<tr bgcolor=\"#FFFFFF\">
            <td align=\"left\">&nbsp;</td>
            <td align=\"left\">ปกเอกสาร</td>
            <td align=\"left\">$rs[mainpage_comment]</td>
          </tr>
"; 
			}
		  
		   while($rsd = mysql_fetch_assoc($result_detail)){
			 
		  ?>
          <tr bgcolor="#FFFFFF">
            <td align="left"><? echo $rsd[menu_detail];?></td>
            <td align="left"><? echo $rsd[problem_detail];?></td>
            </tr>
          <?
          	}//end while($rsd = mysql_fetch_assoc($result_detail)){
		  ?>
          
        </table></td>
          </tr>
        </table></td>
        </tr>
       <? }//end if($xnumr1 > 0){ ?>
      <?	  
	 	 SaveLogLoadPageDetail($last_id);
		 if($ii == $num_data){
				UpdateLoadPage($last_id);
		}
		}//end 	while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
  <?
  }//end if($type_doc == "4"){
	if($type_doc == "11"){
		if($level == ""){
  ?>
   <tr><td>
   	<?
	if($xgen_id == ""){		  
	?>
   <a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=">แสดงทั้งหมด</a> |<a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=0&txt_title=(สังกัด สพป.)">สังกัด สพป.</a> |<a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=1&txt_title=(สังกัด สพม.)"> สังกัด สพม.</a>
   <?
  }// end 	
	?>
   </td></tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">
    <table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl7">
      <tr>
        <td width="3%" rowspan="2" align="center" bgcolor="#CCCCCC">ลำ<br>
          ดับ</td>
        <td width="18%" rowspan="2" align="center" bgcolor="#CCCCCC">หน่วยงาน</td>
        <td colspan="16" align="center" bgcolor="#CCCCCC"><?=$htitle1?></td>
        </tr>
      <tr>
        <td width="6%" align="center" bgcolor="#CCCCCC">จำนวน<br>
          (แผ่น)</td>
        <td width="5%" align="center" bgcolor="#CCCCCC">ปก<br>
          หน้า</td>
        <td width="5%" align="center" bgcolor="#CCCCCC">ข้อมูล<br>
          ทั่วไป</td>
        <td width="6%" align="center" bgcolor="#CCCCCC">เครื่อง<br>
          ราชฯ</td>
        <td width="5%" align="center" bgcolor="#CCCCCC">ขาด<br>
          ลาฯ</td>
        <td width="5%" align="center" bgcolor="#CCCCCC">โทษ<br>
          วินัยฯ</td>
        <td width="5%" align="center" bgcolor="#CCCCCC">วันที่<br>
          ไม่ได้รับ<br>
          เงิน<br>
          เดือนฯ</td>
        <td width="5%" align="center" bgcolor="#CCCCCC">การ<br>
          ศึกษา</td>
        <td width="4%" align="center" bgcolor="#CCCCCC">อบ<br>
          รมฯ</td>
        <td width="5%" align="center" bgcolor="#CCCCCC">ตำ<br>
          แหน่ง /เงิน<br>
          เดือนฯ</td>
        <td width="6%" align="center" bgcolor="#CCCCCC">ความ<br>
          สามารถ<br>
          พิเศษฯ</td>
        <td width="6%" align="center" bgcolor="#CCCCCC">ปฏิบัติ<br>
ราชการ<br>
          พิเศษ</td>
        <td width="5%" align="center" bgcolor="#CCCCCC">ผลงาน<br>
          วิชาการ</td>
        <td width="4%" align="center" bgcolor="#CCCCCC">ความดี<br>
          ความ<br>
          ชอบ</td>
        <td width="4%" align="center" bgcolor="#CCCCCC">อื่น ๆ</td>
        <td width="3%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <? 

	  
	  	if(count($arr1) > 0){
			$i=0;
			foreach($arr1 as $key => $val){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			

			$temp_num1 = $val['page_num']+$val['nopage']+$val['p1']+$val['p6']+$val['p9']+$val['p11']+$val['p10']+$val['p2']+$val['p4']+$val['p3']+$val['p7']+$val['p12']+$val['p5']+$val['p8']+$val['p13'];
			 if($val['type_doc'] > 0){ 
			 	if($val['numid'] == $val['numtypedoc']){
						$docimg = "<img src=\"../../images_sys/docnew.png\" width=\"22\" height=\"15\" title=\"เอกสารรุ่นใหม่\">";
				}else{
						$docimg = "<img src=\"../../images_sys/docold.png\" width=\"20\" height=\"20\" title=\"เอกสารรุ่นเก่า\">";
				}
					
			}else{
					$docimg = "<img src=\"../../images_sys/docold.png\" width=\"20\" height=\"20\" title=\"เอกสารรุ่นเก่า\">";
			}
	  
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? if($temp_num1 > 0){ echo "<a href='?type_doc=$type_doc&profile_id=$profile_id&xsiteid=$xsiteid&xlv=$xlv&typeproblem=$typeproblem&schoolid=".$val['sid']."&problem_status_id=$problem_status_id&level=1'>".$val['schoolid']."</a>";}else{ echo $val['schoolid'];}?></td>
        <td align="center"><?=ShowDash($val['page_num'])?></td>
           <td align="center"><?=ShowDash($val['nopage'])?></td>
           
        <td align="center"><?=ShowDash($val['p1'])?></td>
        <td align="center"><?=ShowDash($val['p6'])?></td>
        <td align="center"><?=ShowDash($val['p9'])?></td>
        <td align="center"><?=ShowDash($val['p11'])?></td>
        <td align="center"><?=ShowDash($val['p10'])?></td>
        <td align="center"><?=ShowDash($val['p2'])?></td>
        <td align="center"><?=ShowDash($val['p4'])?></td>
        <td align="center"><?=ShowDash($val['p3'])?></td>
        <td align="center"><?=ShowDash($val['p7'])?></td>
        <td align="center"><?=ShowDash($val['p12'])?></td>
        <td align="center"><?=ShowDash($val['p5'])?></td>
        <td align="center"><?=ShowDash($val['p8'])?></td>
        <td align="center"><?=ShowDash($val['p13'])?></td>
        
        <td align="center"><? echo $docimg;?>
         </td>
      </tr>
      <?
	$sum1 += $val['page_num'];
	$sum2 += $val['nopage'];
	$sum3 += $val['p1'];
	$sum4 += $val['p6'];
	$sum5 += $val['p9'];
	$sum6 += $val['p11'];
	$sum7 += $val['p10'];
	$sum8 += $val['p2'];
	$sum9 += $val['p4'];
	$sum10 += $val['p3'];
	$sum11 += $val['p7'];
	$sum12 += $val['p12'];
	$sum13 += $val['p5'];
	$sum14 += $val['p8'];
	$sum15 += $val['p13'];
	 SaveLogLoadPageDetail($last_id);
	 	if($i == $num_data){
				UpdateLoadPage($last_id);
		}
		
		$temp_num1 = 0;
		}//end 	foreach($arr1 as $key => $val){
	}//end  	if(count($arr1) > 0){

	  ?>
      <tr>
        <td colspan="2" align="center"><strong>รวม </strong></td>
         <td align="center"><?=ShowDash($sum1)?></td>
        <td align="center"><?=ShowDash($sum2)?></td>
        <td align="center"><?=ShowDash($sum3)?></td>
        <td align="center"><?=ShowDash($sum4)?></td>
        <td align="center"><?=ShowDash($sum5)?></td>
        <td align="center"><?=ShowDash($sum6)?></td>
        <td align="center"><?=ShowDash($sum7)?></td>
        <td align="center"><?=ShowDash($sum8)?></td>
        <td align="center"><?=ShowDash($sum9)?></td>
        <td align="center"><?=ShowDash($sum10)?></td>
        <td align="center"><?=ShowDash($sum11)?></td>
        <td align="center"><?=ShowDash($sum12)?></td>
        <td align="center"><?=ShowDash($sum13)?></td>
        <td align="center"><?=ShowDash($sum14)?></td>
        <td align="center"><?=ShowDash($sum15)?></td>
        <td align="center">&nbsp;</td>
      </tr>
    </table></td></tr>
    <? 
	}else if($level == "1"){?>
    <tr><td align="left">
	<?
		if($xgen_id == ""){		  
	?>
	<a href="?type_doc=<?=$type_doc?>&profile_id=<?=$profile_id?>&xsiteid=<?=$xsiteid?>&xlv=<?=$xlv?>&typeproblem=<?=$typeproblem?>&schoolid=&problem_status_id=<?=$problem_status_id?>&school_type=<?=$school_type?>&txt_title=<?=$txt_title?>&level="> ย้อนกลับ</a> ||	<a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=">แสดงทั้งหมด</a> |<a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=0&txt_title=(สังกัด สพป.)">สังกัด สพป.</a> |<a href="?type_doc=<?=$type_doc?>&typeproblem=<?=$typeproblem?>&schoolid=<?=$schoolid?>&problem_status_id=<?=$problem_status_id?>&xlv=<?=$_GET['xlv']?>&xsiteid=<?=$_GET['xsiteid']?>&profile_id=<?=$_GET['profile_id']?>&school_type=1&txt_title=(สังกัด สพม.)"> สังกัด สพม.</a>
	<?
	  }//end if($xgen_id == ""){			
	?>
	</td></tr>
<tr>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl8">
        <tr>
          <td width="3%" rowspan="2" align="center" bgcolor="#CCCCCC">ลำ<br>
            ดับ</td>
          <td width="10%" rowspan="2" align="center" bgcolor="#CCCCCC">ชื่อ-นาม<br>
            สกุล</td>
          <td width="8%" rowspan="2" align="center" bgcolor="#CCCCCC">ตำแหน่ง</td>
          <? if($schoolid == ""){?>
          <td width="10%" rowspan="2" align="center" bgcolor="#CCCCCC">หน่วยงาน</td>
          <? }//end if($schoolid != ""){?>
          <td colspan="16" align="center" bgcolor="#CCCCCC"><?=$htitle1?></td>
        </tr>
        <tr>
          <td width="4%" align="center" bgcolor="#CCCCCC">จำนวน<br>
            (แผ่น)</td>
          <td width="4%" align="center" bgcolor="#CCCCCC">ปก<br>
            หน้า</td>
          <td width="4%" align="center" bgcolor="#CCCCCC">ข้อมูล<br>
            ทั่วไป</td>
          <td width="4%" align="center" bgcolor="#CCCCCC">เครื่อง<br>
            ราชฯ</td>
          <td width="4%" align="center" bgcolor="#CCCCCC">ขาด<br>
            ลาฯ</td>
          <td width="4%" align="center" bgcolor="#CCCCCC">โทษ<br>
            วินัยฯ</td>
          <td width="6%" align="center" bgcolor="#CCCCCC">วันที่<br>
            ไม่ได้รับ<br>
            เงิน<br>
            เดือนฯ</td>
          <td width="5%" align="center" bgcolor="#CCCCCC">การ<br>
            ศึกษา</td>
          <td width="3%" align="center" bgcolor="#CCCCCC">อบ<br>
            รมฯ</td>
          <td width="5%" align="center" bgcolor="#CCCCCC">ตำ<br>
            แหน่ง /เงิน<br>
            เดือนฯ</td>
          <td width="5%" align="center" bgcolor="#CCCCCC">ความ<br>
            สามารถ<br>
            พิเศษฯ</td>
          <td width="6%" align="center" bgcolor="#CCCCCC">ปฏิบัติ<br>
            ราชการ<br>
            พิเศษ</td>
          <td width="5%" align="center" bgcolor="#CCCCCC">ผลงาน<br>
            วิชาการ</td>
          <td width="4%" align="center" bgcolor="#CCCCCC">ความดี<br>
            ความ<br>
            ชอบ</td>
          <td width="3%" align="center" bgcolor="#CCCCCC">อื่น ๆ</td>
          <td width="3%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
        <? 

	
	  	if(count($arr1) > 0){
			$i=0;
			foreach($arr1 as $key => $val){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			
			// <a class="personPopupTrigger" href="#" rel="5001,3501800010958">
	  
	  ?>
        <tr bgcolor="<?=$bg?>">
          <td align="center"><?=$i?></td>
          <td align="left"><? echo "<a class=\"personPopupTrigger\" href=\"#\" rel=\"พนักงานตรวจสอบ $arruser[$key],ข้อมูลของ $val[fullname]\">".$val['fullname']."</a>";?></td>
          <td align="left"><?=$val['position_now']?></td>
          <? if($schoolid == ""){?>
          <td align="left"><?=$val['schoolid']?></td>
          <? }// ehd if(){?>
          <td align="center"><?=ShowDash($val['page_num'])?></td>
          <td align="center"><?=ShowDash($val['nopage'])?></td>
          
                   
 <td align="center"><?  if($val['p1'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=1&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p1'])."</a>";}else{  echo ShowDash($val['p1']);}?></td>
        <td align="center"><?  if($val['p6'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=6&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p6'])."</a>";}else{  echo ShowDash($val['p6']);}?></td>
        
        <td align="center">
        <?  if($val['p9'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=9&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p9'])."</a>";}else{  echo ShowDash($val['p9']);}?>
        </td>
        <td align="center">
        
        <?  if($val['p11'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=11&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p11'])."</a>";}else{  echo ShowDash($val['p11']);}?>
        </td>
        <td align="center">
        <?  if($val['p10'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=10&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p10'])."</a>";}else{  echo ShowDash($val['p10']);}?></td>
        <td align="center">
        <?  if($val['p2'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=2&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p2'])."</a>";}else{  echo ShowDash($val['p2']);}?>
        </td>
        <td align="center">
        <?  if($val['p4'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=4&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p4'])."</a>";}else{  echo ShowDash($val['p4']);}?>
        </td>
        <td align="center">
        <?  if($val['p3'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=3&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p3'])."</a>";}else{  echo ShowDash($val['p3']);}?>
        </td>
        <td align="center">
        <?  if($val['p7'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=7&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p7'])."</a>";}else{  echo ShowDash($val['p7']);}?>
        </td>
        <td align="center">
        <?  if($val['p12'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=12&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p12'])."</a>";}else{  echo ShowDash($val['p12']);}?>
        </td>
        <td align="center">
        <?  if($val['p5'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=5&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p5'])."</a>";}else{  echo ShowDash($val['p5']);}?>
        </td>
        <td align="center">
        <?  if($val['p8'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=8&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p8'])."</a>";}else{  echo ShowDash($val['p8']);}?>
        </td>
        <td align="center">
        <?  if($val['p13'] > 0){ echo "<A href=\"#\" onClick=\"window.open('popup_problem_detail.php?profile_id=$profile_id&xsiteid=$xsiteid&idcard=$key&menu_id=13&fullname=$val[fullname]&xschoolid=$val[schoolid]','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=700,height=550');\">".ShowDash($val['p13'])."</a>";}else{  echo ShowDash($val['p13']);}?>
        </td>    
          
          <td align="center"><? if($val['type_doc'] == "0"){ echo "<img src=\"../../images_sys/docold.png\" width=\"20\" height=\"20\" title=\"เอกสารรุ่นเก่า\">"; }else{  echo "<img src=\"../../images_sys/docnew.png\" width=\"22\" height=\"15\" title=\"เอกสารรุ่นใหม่\">";}?></td>
        </tr>
        <?
	$sum1 += $val['page_num'];
	$sum2 += $val['nopage'];
	$sum3 += $val['p1'];
	$sum4 += $val['p6'];
	$sum5 += $val['p9'];
	$sum6 += $val['p11'];
	$sum7 += $val['p10'];
	$sum8 += $val['p2'];
	$sum9 += $val['p4'];
	$sum10 += $val['p3'];
	$sum11 += $val['p7'];
	$sum12 += $val['p12'];
	$sum13 += $val['p5'];
	$sum14 += $val['p8'];
	$sum15 += $val['p13'];
	 SaveLogLoadPageDetail($last_id);
	 	if($i == $num_data){
				UpdateLoadPage($last_id);
		}
		}//end 	foreach($arr1 as $key => $val){
	}//end  	if(count($arr1) > 0){
	  if($schoolid == ""){ $consp = "4";}else{ $consp = "3";}
	  ?>
        <tr>
          <td colspan="<?=$consp?>" align="center">รวม </td>
          <td align="center"><?=ShowDash($sum1)?></td>
          <td align="center"><?=ShowDash($sum2)?></td>
          <td align="center"><?=ShowDash($sum3)?></td>
          <td align="center"><?=ShowDash($sum4)?></td>
          <td align="center"><?=ShowDash($sum5)?></td>
          <td align="center"><?=ShowDash($sum6)?></td>
          <td align="center"><?=ShowDash($sum7)?></td>
          <td align="center"><?=ShowDash($sum8)?></td>
          <td align="center"><?=ShowDash($sum9)?></td>
          <td align="center"><?=ShowDash($sum10)?></td>
          <td align="center"><?=ShowDash($sum11)?></td>
          <td align="center"><?=ShowDash($sum12)?></td>
          <td align="center"><?=ShowDash($sum13)?></td>
          <td align="center"><?=ShowDash($sum14)?></td>
          <td align="center"><?=ShowDash($sum15)?></td>
          <td align="center">&nbsp;</td>
        </tr>
      </table></td></tr>
    
  <?
	}//end if($level == "1"){
}//end if($type_doc == "11"){
 ?>
</table>

</body>
</html>
