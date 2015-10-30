<?
session_start();
include("checklist2.inc.php");
if($_SESSION['session_username'] == ""){
	echo "<h3>ขาดการติดต่อกับ server นานเกินไปกรุณา login เข้าสู่ระบบใหม่</h3>";
	header("Location: login.php");
	die;
}

set_time_limit(0);
## รายการเขตที่อนุญาตให้นำเข้าข้อมูลก่อนถึงแม้ว่าจะยังไม่มีการตรวจสอบความสมบูรณ์ของเอกสารครบทุกคนก็ตาม
$arr_site = array("7102","7001","4303","4702","4802","4102","5202","1801","7101","6702","5001","5002","5003","5004","5005","5006"); 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<link href="../../common/gs_sortable.css" />
<script src="../../common/gs_sortable.js"></script>
<script language="javascript">
	function copyit(theField) {
		var selectedText = document.selection;
		if (selectedText.type == 'Text') {
			var newRange = selectedText.createRange();
			theField.focus();
			theField.value = newRange.text;
		} else {
			alert('select a text in the page and then press this button');
		}
	}
</script>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>

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

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="12%" align="right"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td width="55%">
          <select name="profile_id" id="profile_id" onchange="gotourl(this)">
          <option value="">เลือกโฟล์ไฟล์</option>
      	<?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
		<option value="?profile_id=<?=$rsp[profile_id]?>&action=<?=$action?>&lv=<?=$lv?>&xsiteid=<?=$xsiteid?>&schoolid=<?=$schoolid?>" <?=$sel?>><?=$rsp[profilename]?></option>
		<?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
        </select> 
          
          </td>
          <td width="33%">&nbsp;</td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>

<?
	
	
	$arr1 = show_val_exsum($lv,$xsiteid,$schoolid,$profile_id);
	
?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
   <td align="center">
   
   <!--<table width="500" border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
         <tr>
           <td colspan="2" align="center" bgcolor="#CAD5FF"><strong>รายงานการตรวจสอบเอการต้นฉบับ</strong></td>
           </tr>
         <tr>
           <td width="55%" align="center" bgcolor="#CAD5FF"><strong>รายการ</strong></td>
           <td width="45%" align="center" bgcolor="#CAD5FF"><strong>จำนวน(คน)</strong></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;ค้างตรวจสอบ</strong></td>
           <td align="center" bgcolor="#FFFFFF"><?=number_format($arr1['numN']);?></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;ตรวจสอบแล้วสมบูรณ์</strong></td>
           <td align="center" bgcolor="#FFFFFF"><?=number_format($arr1['numY1']);?></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>&nbsp;ตรวจสอบแล้วไม่สมบูรณ์</strong></td>
           <td align="center" bgcolor="#FFFFFF"><?  if($lv == "1"){ if($arr1['numY0'] > 0){ echo "<a href='report_problem.php?sentsecid=$xsiteid&lv=1&profile_id=$profile_id' target='_blank'>".number_format($arr1['numY0'])."</a>";}else{ echo "0";}}else{ if($arr1['numY0'] > 0){ echo "<a href='report_problem.php?sentsecid=$sentsecid&lv=&profile_id=$profile_id' target='_blank'>".number_format($arr1['numY0'])."</a>";}else{ echo "0";} }?></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#EEEEEE"><strong>&nbsp;จำนวนทั้งหมด</strong></td>
           <td align="center" bgcolor="#EEEEEE"><strong>
             <?=number_format($arr1['numall']);?>
           </strong></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#EEEEEE"><strong>&nbsp;จำนวนหน้าเอกสาร</strong></td>
           <td align="center" bgcolor="#EEEEEE"><?=number_format($arr1['numpage']);?></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#EEEEEE"><strong>&nbsp;จำนวนรูป</strong></td>
           <td align="center" bgcolor="#EEEEEE"><?=number_format($arr1['numpic']);?></td>
           </tr>
       </table></td>
     </tr>
   </table>-->

	 </td>
 </tr>
 <tr>
    <td align="left">&nbsp;<strong><? if($lv == 1){ echo "<a href='?lv=&profile_id=$profile_id'>แสดงข้อมูลภาพรวม</a> => ".show_area($xsiteid);}?></strong></td>
  </tr>
  <? if($lv == ""){ $xtitle = "สำนักงานเขตพื้นที่การศึกษา"; $xcolh = "8"; $xcolf = "2";}else{ $xtitle = "หน่วยงาน"; $xcolh = "9"; $xcolf = "3";}
  
  ?>
  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3" id="my_table">
	<thead> 
      <tr align="center">
       <td colspan="9" align="center" bgcolor="#A8B9FF"><strong>ระบบนำเข้าข้อมูลจากฐาน checklist สู่ระบบ cmss</strong></td>
        </tr>
      <tr>
        <th width="4%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>ลำดับ</strong></th>
        <th width="31%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong><?=$xtitle?></strong></th>
        <th width="9%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>จำนวน<br>
          ทั้งหมด(คน)</strong></th>
        <th width="11%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>จำนวนหน้า<br>
          เอกสาร(แผ่น)</strong></th>
        <td colspan="3" align="center" bgcolor="#A8B9FF"><strong>สถานะการตรวจสอบ</strong></td>
        <th width="9%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>จำนวน<br>
          รูป(รูป)</strong></th>
        <th width="7%" rowspan="3" align="center" bgcolor="#A8B9FF">นำเข้าสู่ฐาน<br>
cmss</th>
        </tr>
      <tr>
        <th width="9%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>ค้างตรวจ(คน)</strong></th>
        <th colspan="2" align="center" bgcolor="#A8B9FF"><strong>ตรวจสอบแล้ว(คน)</strong></th>
        </tr>
      <tr>
        <th width="11%" align="center" bgcolor="#A8B9FF"><strong>สมบูรณ์</strong></th>
        <th width="9%" align="center" bgcolor="#A8B9FF"><strong>ไม่สมบูรณ์</strong></th>
        </tr> 
	</thead>    
	<tbody>   
		<?
			$sql = "SELECT
eduarea.secid,
eduarea.secname,
if(substring(eduarea.secid,1,1) ='0',cast(secid as SIGNED),9999) as idsite
FROM eduarea Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE eduarea_config.group_type =  'keydata' AND eduarea_config.profile_id='$profile_id'
ORDER BY idsite,eduarea.secname ASC";
			$result = mysql_db_query($dbnamemaster,$sql);
			$count_y = 0;$count_yn=0;$count_n=0;$count_impP=0;
			$arrN = CountCheckListKp7V1($profile_id);
			$arrs = CheckBeforImport($profile_id);
			$arrL = CheckLockArea("",$profile_id);
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				  $temp_dis = $arrL[$rs[secid]];

				  $id_org = "$rs[secid]";
				  $numpage = $arrN[$id_org]['NumPage']; //  จำนวนแผ่น
				  $numpic = $arrN[$id_org]['NumPic']; // จำนวนรูป
				  $count_y = $arrN[$id_org]['NumPass'];// ตรวจสอบผ่าน
				  $count_yn = $arrN[$id_org]['NumNoPass'];// ตรวจสอบแล้วไม่ผ่าน
				  $count_n = $arrN[$id_org]['NumDisC'];// ค้างตรวจสอบ
				  $count_impP = $arrN[$id_org]['NumAll'];// จำนวนทั้งหมด
				  $getlink = "import2cmss.php?action=&xsiteid=$rs[secid]&secname=$rs[secname]&lv=0&profile_id=$profile_id"; // 
				  $lint_yn = "report_problem.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id";
				  if($temp_dis > 0){ // !in_array($rs[secid],$arrsite) $arr_site
					  if((($arrs[$id_org] > 0 or $count_n > 0 or $count_yn > 0) or $count_y != $count_impP) and (!in_array($rs[secid],$arr_site))  ){
						  $image_link = "<em>ข้อมูลไม่สมบูรณ์ หรือไม่มีสังกัด</em>";
					  }else{
					  	$image_link = "<a href='$getlink' target='_blank'><img src=\"../../images_sys/refresh.png\" width=\"20\" height=\"20\" border='0' alt='นำเข้าข้อมูลสู่ระบบ cmss'></a>";
					  }// end  if(CheckBeforImport($rs[secid]) > 0){
					  	$xalink = "$rs[secname]  <font color='#FF0000'><b>*</b></font>";
				  }else{
					  $image_link = "";
						$xalink = "$rs[secname]";	
				  }//end  if($temp_dis > 0){
			  
			  
			  	$sql_check_area = "SELECT COUNT(*) as num2 FROM keystaff WHERE site_area='$rs[secid]' and status_permit='YES'";
				$result_cha = mysql_db_query($dbnameuse,$sql_check_area);
				$rscha = mysql_fetch_assoc($result_cha);
				
			  	if($rscha[num2] < 1){
			  	$image_link = "<a href='$getlink' target='_blank'><img src=\"../../images_sys/refresh.png\" width=\"20\" height=\"20\" border='0' alt='นำเข้าข้อมูลสู่ระบบ cmss'></a>";
				}else{
				$image_link = "<em>เขตต่อเนื่อง</em>";	
				}
			 ### เช็คเงื่อนไขการ loc เขต
			 
			 
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$xalink?></td>
        <td align="center"><?=number_format($count_impP)?></td>
        <td align="center"><?=number_format($numpage)?></td>
        <td align="center"><?=number_format($count_n)?></td>
        <td align="center"><?=number_format($count_y);?></td>
        <td align="center"><? if($count_yn > 0){ echo "<a href='$lint_yn' target='_blank'>".number_format($count_yn)."</a>";}else{ echo "0";}?></td>
        <td align="center"><?=number_format($numpic)?></td>
        <td align="center"><?=$image_link?></td>
        </tr>
		<?
			$sum_page_all += $numpage;
			$sum_pic_all += $numpic;
			$sum_imp_all += $count_impP;
			$sum_y_all += $count_y;
			$sum_n_all += $count_n;
			$sum_yn_all += $count_yn;
			
			}//end while($rs_m = mysql_fetch_assoc($result_main)){
		?>
</tbody>
 <tfoot>
      <tr class="txthead">
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_imp_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_page_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_n_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_y_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_yn_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum_pic_all);?>
        </strong></td>
        <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
 </tfoot>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"><em>หมายเหตุ <font color="#FF0000">*</font> หมายถึงเขตที่ตรวจสอบจำนวนถูกต้องแล้ว</em></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var TSort_Data = new Array ('my_table', '', 'h','g', 'g','g','g','g','g','g','g','g','g');
var TSort_Classes = new Array ('row1', 'row2');
tsRegister();
// -->
</script> 

</body>
</html>
