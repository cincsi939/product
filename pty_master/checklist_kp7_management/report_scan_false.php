<?
set_time_limit(0);
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "checklistkp7"; 
$process_id			= "checklistkp7_byarea";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20100809.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2010-08-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20100809.00
	## Modified Detail :		ระบบตรวจสอบข้อมูลทะเบียนประวัติต้นฉบับ
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
include("../../common/common_competency.inc.php");
include("checklist2.inc.php");
$time_start = getmicrotime();



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
	

	
	if($lv == ""){ // กรณแสดงข้อมูลภาพรวมทั้งปรเทศ
		$arr1 = CountExsumScanDocFalse();// ข้อมูลภาพรวมทั้งประเทศ
		$numorg = CountAreaProfile($profile_id); // จำนวนเขตพื้นที่การศึกษาในโฟรไฟล์นั้น
		$nump_noarea = CountPerSonNoArea();
		$xbg = "#FFFFFF";
	}else if($lv == "1"){ // ข้อมูลรายเขต
		$arr1 = CountExsumScanDocFalse($xsiteid); // ข้อมูลของเขต
		$numorg = CountSchool($xsiteid);
		$nump_noarea = CountPerSonNoArea($xsiteid);
		$xbg = "#FF0000";
	}
		
	
		$exsum_all  = SumArray2D($arr1,"NumAll");
		$exsum_ql  = SumArray2D($arr1,"NumQL");
		$exsum_numtrue = SumArray2D($arr1,"NumTrue");
		$exsum_numfalse = SumArray2D($arr1,"NumFalse");
		$exsum_numfalse_upload  = SumArray2D($arr1,"NumFalseUpload");
		$exsum_numnomain  = SumArray2D($arr1,"NumNoMain");
		$exsum_numnomain_upload  = SumArray2D($arr1,"NumNoMainUpload");
		$exsum_numidfalse  = SumArray2D($arr1,"NumIdFalse");
		$exsum_numidfalse_upload  = SumArray2D($arr1,"NumIdFalseUpload");

?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
   <td align="center">
</td>
 </tr>
 <tr>
   <td align="center"><table width="600" border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
         <tr>
           <td colspan="7" align="center" bgcolor="#CAD5FF"><strong>รายงานผลการสแกนเอกสารที่สถานะเอกสารไม่สมบูรณ์ สำเนา กพ.7 ต้นฉบับ (
             <?=ShowProfile_name($profile_id);?>
             )</strong></td>
         </tr>
         <tr>
           <td width="27%" align="left" bgcolor="#FFFFFF"><strong>จำนวนอัตราจริงรวม</strong></td>
           <td width="15%" align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($exsum_all)?>
           </strong></td>
           <td width="8%" align="center" bgcolor="#FFFFFF"><strong>คน</strong></td>
           <td width="16%" align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($numorg)?>
           </strong></td>
           <td width="9%" align="center" bgcolor="#FFFFFF"><strong>
             <? echo "หน่วยงาน";?>
           </strong></td>
           <td width="15%" align="center" bgcolor="<?=$xbg?>"><? if($lv != ""){?><strong>ไม่มีสังกัด</strong><? } ?></td>
           <td width="10%" align="center" bgcolor="<?=$xbg?>"><? if($lv != ""){?><?=number_format($nump_noarea)?><? } ?></td>
           </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>จำนวนเอกสารที่ได้รับ</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($exsum_ql);?>
           </strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>คน</strong></td>
           <td colspan="4" align="center" bgcolor="#FFFFFF">&nbsp;</td>
           </tr>
         <tr>
           <td align="left" bgcolor="#FFFFFF"><strong>เอกสารสมบูรณ์</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($exsum_numtrue)?>
           </strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>คน</strong></td>
           <td colspan="4" align="center" bgcolor="#FFFFFF">&nbsp;</td>
           </tr>
         <tr>
           <td align="left" valign="middle" bgcolor="#FFFFFF"><strong>ไม่สมบูรณ์</strong></td>
           <td align="center" valign="middle" bgcolor="#FFFFFF"><strong>
             <?=number_format($exsum_numfalse)?>
           </strong></td>
           <td align="center" valign="middle" bgcolor="#FFFFFF"><strong>คน</strong></td>
           <td colspan="4" align="center" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td align="center" bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                 <tr>
                   <td width="49%" align="center" bgcolor="#A8B9FF"><strong>upload</strong></td>
                   <td width="51%" align="center" bgcolor="#A8B9FF"><strong>ค้าง</strong></td>
                 </tr>
                 <tr>
                   <td align="center" bgcolor="#FFFFFF"><strong>
                     <? echo number_format($exsum_numfalse_upload);?>
                   </strong></td>
                   <td align="center" bgcolor="#FFFFFF"><strong>
                     <?=number_format(($exsum_numfalse-$exsum_numfalse_upload))?>
                   </strong></td>
                 </tr>
               </table></td>
             </tr>
           </table></td>
           </tr>
         <tr>
           <td align="left" valign="middle" bgcolor="#FFFFFF"><strong>ขาดเอกสารประกอบ</strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>
             <?=number_format($exsum_numnomain)?>
           </strong></td>
           <td align="center" bgcolor="#FFFFFF"><strong>คน</strong></td>
           <td colspan="4" align="left" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td align="center" bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                 <tr>
                   <td width="49%" align="center" bgcolor="#A8B9FF"><strong>upload</strong></td>
                   <td width="51%" align="center" bgcolor="#A8B9FF"><strong>ค้าง</strong></td>
                 </tr>
                 <tr>
                   <td align="center" bgcolor="#FFFFFF"><strong>
                     <?=number_format($exsum_numnomain_upload)?>
                   </strong></td>
                   <td align="center" bgcolor="#FFFFFF"><strong>
                     <?=number_format(($exsum_numnomain-$exsum_numnomain_upload))?>
                   </strong></td>
                 </tr>
               </table></td>
             </tr>
           </table></td>
           </tr>
         <tr>
           <td align="left" valign="middle" bgcolor="#FFFFFF"><strong>เลขบัตรไม่สมบูรณ์</strong></td>
           <td align="center" valign="middle" bgcolor="#FFFFFF"><strong>
             <?=number_format($exsum_numidfalse);?>
           </strong></td>
           <td align="center" valign="middle" bgcolor="#FFFFFF"><strong>คน</strong></td>
           <td colspan="4" align="center" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td align="center" bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                 <tr>
                   <td width="49%" align="center" bgcolor="#A8B9FF"><strong>upload</strong></td>
                   <td width="51%" align="center" bgcolor="#A8B9FF"><strong>ค้าง</strong></td>
                 </tr>
                 <tr>
                   <td align="center" bgcolor="#FFFFFF"><strong>
                     <?=number_format($exsum_numidfalse_upload)?>
                   </strong></td>
                   <td align="center" bgcolor="#FFFFFF"><strong>
                     <?=number_format(($exsum_numidfalse-$exsum_numidfalse_upload))?>
                   </strong></td>
                 </tr>
               </table></td>
             </tr>
           </table></td>
           </tr>
       </table></td>
     </tr>
   </table></td>
 </tr>
 <tr>
    <td align="right"><strong>รายงาน ณ วันที่ 
    <?=thai_date(date("Y-m-d"));?>&nbsp;&nbsp;&nbsp;</strong></td>
  </tr>
   <tr>
    <td align="left">&nbsp;<strong><? if($lv == 1){ echo "<a href='?lv=&profile_id=$profile_id'>แสดงข้อมูลภาพรวม</a> :: ".show_area($xsiteid);}?></strong></td>
  </tr>
  <? if($lv == ""){ $xtitle = "สำนักงานเขตพื้นที่การศึกษา"; $xcolh = "10"; $xcolf = "2";}else{ $xtitle = "หน่วยงาน"; $xcolh = "11"; $xcolf = "3";}
  
  ?>
  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3" id="my_table">
	<thead> 
      <tr>
        <th width="4%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>ลำดับ</strong></th>
        <th width="20%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong><?=$xtitle?></strong></th>
        <th width="7%" rowspan="2" align="center" bgcolor="#A8B9FF">อัตราจริง</th>
        <th width="8%" rowspan="2" align="center" bgcolor="#A8B9FF">ได้รับ<br>
เอกสาร</th>
        <th width="8%" rowspan="2" align="center" bgcolor="#A8B9FF">เอกสมบูรณ์</th>
        <th colspan="3" align="center" bgcolor="#A8B9FF"><strong>ไม่สมบูรณ์</strong></th>
        <td colspan="3" align="center" bgcolor="#A8B9FF"><strong>ขาดเอกสาร<br>
          ประกอบ</strong></td>
        <td colspan="3" align="center" bgcolor="#A8B9FF"><strong>เลขบัตรไม่<br>
สมบูรณ</strong>์</td>
        </tr>
      <tr>
        <th width="5%" align="center" bgcolor="#A8B9FF">คน</th>
        <th width="6%" align="center" bgcolor="#A8B9FF">upload</th>
        <th width="6%" align="center" bgcolor="#A8B9FF">ค้าง</th>
        <th width="6%" align="center" bgcolor="#A8B9FF">คน</th>
        <th width="7%" align="center" bgcolor="#A8B9FF">upload</th>
        <th width="6%" align="center" bgcolor="#A8B9FF">ค้าง</th>
        <th width="6%" align="center" bgcolor="#A8B9FF">คน</th>
        <th width="6%" align="center" bgcolor="#A8B9FF">upload</th>
        <th width="5%" align="center" bgcolor="#A8B9FF">ค้าง</th>
        </tr> 
	</thead>    
	<tbody>   
		<?
		

		
		
		if($lv == ""){// ข้อมูลรายเขต
			//$sql = "SELECT * FROM eduarea WHERE status_area53 ='1' order by secname ASC";
			$sql = "SELECT eduarea.secid, eduarea.name_proth, eduarea.office_ref, eduarea.secname,eduarea.secname_short, eduarea.provid, eduarea.partid, eduarea.siteid,
eduarea.status,
eduarea.msg,
eduarea.area_id,
eduarea.beunderid,
eduarea.area_under,
eduarea.staff_gain,
eduarea.staff_empty,
eduarea.import_pobec,
eduarea.config_area,
eduarea.full_area,
eduarea.no_import_pobec,
eduarea.status_area53,
if(substring(eduarea.secid,1,1) ='0',cast(eduarea.secid as SIGNED),9999) as idsite
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata' AND
eduarea_config.profile_id =  '$profile_id' 
order by  idsite,eduarea.secname  ASC
";
			$result = mysql_db_query($dbnamemaster,$sql);
		}else if($lv == "1"){ // ข้อมูลรายโรง
				//$sql = "SELECT CAST(id as SIGNED) as id, siteid,office FROM allschool WHERE siteid='$xsiteid' order by id ASC, office ASC";
				//$result = mysql_db_query($dbnamemaster,$sql);
				##CAST(id as SIGNED) as id, 
	# update temp_order school ให้เขตพื้นที่การศึกษาไปอยู่ข้างบนสุด
	$sql_uptemp =  "UPDATE temp_order_school SET orderby='0' WHERE schoolid='$xsiteid'";
	mysql_db_query($dbname_temp,$sql_uptemp);
	$sql = "SELECT
if(edubkk_checklist.temp_order_school.orderby IS NULL,9999,orderby) as orderby1,
edubkk_master.allschool.id,
edubkk_master.allschool.office,
edubkk_master.allschool.siteid
FROM
edubkk_master.allschool 
left Join edubkk_checklist.temp_order_school ON edubkk_master.allschool.id = edubkk_checklist.temp_order_school.schoolid
WHERE
edubkk_master.allschool.siteid=  '$xsiteid' and edubkk_master.allschool.activate_status='open'
ORDER BY
orderby1 ASC";

//echo $sql;
$result = mysql_db_query($dbname_temp,$sql);
				
		}//end if($lv == ""){
		$count_y = 0;$count_yn=0;$count_n=0;$count_impP=0;
		
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 
			  if($lv == ""){
				  $temp_dis = CheckLockArea($rs[secid],$profile_id);
				
				  $id_org = "$rs[secid]";
				  
				  $count1 = $arr1[$id_org]['NumAll'];// จำนวนบุคลากรทั้งหมด
				  $count2 =$arr1[$id_org]['NumQL']; // จำนวนเอกสารที่ได้รับ
				  $count3 = $arr1[$id_org]['NumTrue'];// เอกสารที่สมบูรณ์
				  $count4 = $arr1[$id_org]['NumFalse'];// จำนวนเอกสารทีไม่่สมบูรณ์
				  $count5 = $arr1[$id_org]['NumFalseUpload'];// จำนวนเอกสารที่ไม่สมบูรณ์แต่ upload ไป
				  $count6 = $arr1[$id_org]['NumNoMain'];// จำนวนเอกสารที่ไม่มีปก
				  $count7 =$arr1[$id_org]['NumNoMainUpload']; // จำนวนเอกสารที่ไม่มีปกและupload ไปแล้ว
				  $count8 = $arr1[$id_org]['NumIdFalse'];// จำนวนเลขบัตรที่ไม่สมบูรณ์
				  $count9 = $arr1[$id_org]['NumIdFalseUpload'];// จำนวนเลขบัตรที่ไม่สมบูรณ์และ upload ไปแล้ว
					   
				  	$getlink = "?action=&lv=1&sentsecid=$rs[secid]&xsiteid=$rs[secid]&schoolid=&profile_id=$profile_id";				  
				  	$link1 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=all";
				   	$link2 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=ql";
				    $link3 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=numt";
					$link4 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=numf";
				  	$link5 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=numfup";
				  	$link45 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=numfdis";
				  	$link6 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=numnm";
				  	$link7 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=numnmup";
					$link67 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=nummdis";
					$link8 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=numidf";
					$link9 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=numidfup";
					$link89 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[secid]&schoolid=&profile_id=$profile_id&xtype=numidfdis";


				  if($temp_dis > 0){
					  	$xalink_sys  = "<font color='#FF0000'><b>*</b></font>";
				  }else{
					  	$xalink_sys = "";
				 }//end  if($temp_dis > 0){
					  if($count1 > 0){
							$xalink = "<a href='$getlink'>".str_replace("สพท.","",$rs[secname_short])."</a> $xalink_sys";
							
					  }else{
							$xalink = str_replace("สพท.","",$rs[secname_short]);	
					  }
				  
			  
			  }else if($lv == "1"){
				  $id_org = "$rs[id]";
				 // echo "<pre>";
				  //print_r($arrnum);
				  	### function เก็บรหัสหน่วยงานไว้เพื่อใช้ในการเรียงลำดับในการทำ index
					 SaveTempOrderSchool($rs[id],$xsiteid,$i);
					 ### end function เก็บรหัสหน่วยงานไว้เพื่อใช้ในการเรียงลำดับในการทำ index
				  
				  $count1 = $arr1[$id_org]['NumAll'];// จำนวนบุคลากรทั้งหมด
				  $count2 =$arr1[$id_org]['NumQL']; // จำนวนเอกสารที่ได้รับ
				  $count3 = $arr1[$id_org]['NumTrue'];// เอกสารที่สมบูรณ์
				  $count4 = $arr1[$id_org]['NumFalse'];// จำนวนเอกสารทีไม่่สมบูรณ์
				  $count5 = $arr1[$id_org]['NumFalseUpload'];// จำนวนเอกสารที่ไม่สมบูรณ์แต่ upload ไป
				  $count6 = $arr1[$id_org]['NumNoMain'];// จำนวนเอกสารที่ไม่มีปก
				  $count7 =$arr1[$id_org]['NumNoMainUpload']; // จำนวนเอกสารที่ไม่มีปกและupload ไปแล้ว
				  $count8 = $arr1[$id_org]['NumIdFalse'];// จำนวนเลขบัตรที่ไม่สมบูรณ์
				  $count9 = $arr1[$id_org]['NumIdFalseUpload'];// จำนวนเลขบัตรที่ไม่สมบูรณ์และ upload ไปแล้ว


				  
				  $getlink = "report_scan_false_detail.php?action=&lv=1&sentsecid=$rs[siteid]&xsiteid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id";
				  	$link1 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=all";
				   	$link2 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=ql";
				    $link3 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=numt";
					$link4 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=numf";
				  	$link5 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=numfup";
				  	$link45 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=numfdis";
				  	$link6 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=numnm";
				  	$link7 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=numnmup";
					$link67 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=nummdis";
					$link8 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=numidf";
					$link9 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=numidfup";
					$link89 = "report_scan_false_detail.php?lv=1&sentsecid=$rs[siteid]&schoolid=$rs[id]&profile_id=$profile_id&xtype=numidfdis";
				  if(CheckLockArea($rs[siteid],$profile_id) > 0){
						$xalink_sys  = "<font color='#FF0000'><b>*</b></font>";
					}else{
						$xalink_sys = "";
					}
					  if($count1 > 0){
							$xalink = "<a href='$getlink'>$rs[office]</a>$xalink_sys";
					  }else{
							$xalink = "$rs[office]";
					  }

			  }
			 ### เช็คเงื่อนไขการ loc เขต
		$count45 = $count4-$count5;
		$count67 = $count6-$count7;
		$count89 = $count8-$count9;
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$xalink?><? if($lv == "1"){ echo "(".FindOldArea($id_org).")";}?></td>
        <td align="center"><? if($count1 > 0){ echo "<a href='$link1' target='_blank'>".number_format($count1)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($count2 > 0){ echo "<a href='$link2' target='_blank'>".number_format($count2)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($count3 > 0){ echo "<a href='$link3' target='_blank'>".number_format($count3)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($count4 > 0){ echo "<a href='$link4' target='_blank'>".number_format($count4)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($count5 > 0){ echo "<a href='$link5' target='_blank'>".number_format($count5)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($count45 > 0){ echo "<a href='$link45' target='_blank'>".number_format($count45)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($count6 > 0){ echo "<a href='$link6' target='_blank'>".number_format($count6)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($count7 > 0){ echo "<a href='$link7' target='_blank'>".number_format($count7)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($count67 > 0){ echo "<a href='$link67' target='_blank'>".number_format($count67)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($count8 > 0){ echo "<a href='$link8' target='_blank'>".number_format($count8)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($count9 > 0){ echo "<a href='$link9' target='_blank'>".number_format($count9)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($count89 > 0){ echo "<a href='$link89' target='_blank'>".number_format($count89)."</a>";}else{ echo "0";}?></td>
        </tr>
		<?
			$sum_all1 += $count1;
			$sum_all2 += $count2;
			$sum_all3 += $count3;
			$sum_all4 += $count4;
			$sum_all5 += $count5;
			$sum_all45 += $count45;
			$sum_all6 += $count6;
			$sum_all7 += $count7;
			$sum_all67 += $count67;
			$sum_all8 += $count8;
			$sum_all9 += $count9;
			$sum_all89 += $count89;
			
			}//end while($rs_m = mysql_fetch_assoc($result_main)){
		?>
</tbody>
 <tfoot>
      <tr class="txthead">
        <td colspan="2" align="center" bgcolor="#CCCCCC">รวม</td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum_all1)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum_all2)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum_all3)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum_all4)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum_all5)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum_all45)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum_all6)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum_all7)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum_all67)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum_all8)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum_all9)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum_all89)?></strong></td>
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
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>