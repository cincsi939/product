<?
session_start();
include("../../common/common_competency.inc.php");
include("checklist2.inc.php");
if($profile_id == ""){
		$profile_id = 4;
}


function Thai_dateS1($temp){
				$shortmonth = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
				if($temp != "0000-00-00" and $temp != ""){
					$x = explode("-",$temp);
					return intval($x[2])." ".$shortmonth[intval($x[1])]." ".($x[0]+543);
				}else{
					return "";	
				}
				
}// function Thai_dateS1($temp){

function CountDiffAssgin($profile_id){
	global $dbname_temp;
/*	$sql = "SELECT 
 t1.siteid,
count(t1.idcard) as numall,
sum(if(t1.idcard=t2.idcard and and t1.activity_id='3',1,0)) as numassign,
sum(if(t2.idcard IS NULL,1,0)) as numdiff
 FROM edubkk_checklist.tbl_checklist_assign_detail as t1 
Left Join callcenter_entry.tbl_assign_key as t2 ON t1.idcard = t2.idcard AND t2.profile_id = '$profile_id' 
WHERE t1.activity_id =  '3' AND t1.profile_id =  '$profile_id'  group by  t1.siteid";*/
$sql = "SELECT 
 t1.siteid,
count(distinct t1.idcard) as numall,
sum(if(t1.idcard=t2.idcard and t1.activity_id='3',1,0)) as numassign,
sum(if(t1.activity_id='3' and t2.idcard IS NULL,1,0)) as numdiff
 FROM edubkk_checklist.tbl_checklist_assign_detail as t1 
Left Join callcenter_entry.tbl_assign_key as t2 ON t1.idcard = t2.idcard 
AND t2.profile_id = '$profile_id'  
where t1.profile_id =  '$profile_id'  and  t1.activity_id =  '3' 
 group by  t1.siteid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]]['numall'] = $rs[numall];	
		$arr[$rs[siteid]]['numassign'] = $rs[numassign];
		$arr[$rs[siteid]]['numdiff'] = $rs[numdiff];
	}// end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function CountDiffAssgin($profile_id){

#####################  นับจำนวนใน checklist
function NumCheckListAll($profile_id){
	global $dbname_temp;
	$sql = "SELECT 
 t.siteid,
count(t.idcard) as numall,
sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0',1,0)) as numpass
 FROM
edubkk_checklist.tbl_checklist_kp7 as t
WHERE  t.profile_id =  '$profile_id'  group by  t.siteid";	
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]]['numall'] = $rs[numall];
		$arr[$rs[siteid]]['numpass'] = $rs[numpass];
	}// end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end function NumCheckListAll($profile_id){


function xCheckFileServerPerson($xsiteid){
 $db_site = "cmss_".$xsiteid;
 $sql_pic = "SELECT
general.id,
general_pic.imgname
FROM
general
Inner Join general_pic ON general.id = general_pic.id";
//echo $sql_pic."<br>$db_site<br>";
$result_pic = mysql_db_query($db_site,$sql_pic);
	while($rsp = mysql_fetch_assoc($result_pic)){
		$xfile = "../../../image_file/$xsiteid/$rsp[imgname]";	
		if(file_exists($xfile)){
			$arr[$rsp[id]]['numfile'] = $arr[$rsp[id]]['numfile']+1;
		}//end if(file_exists($xfile)){
		
			$arr[$rsp[id]]['numdb'] = $arr[$rsp[id]]['numdb']+1;
			
	}//end while($rsp = mysql_fetch_assoc($result_pic)){	
	//echo "<pre>";
	//print_r($arr);
	return $arr;
}//end function CheckFileServer(){
?>
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
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

</head>
<script src="../../common/jquery.js"></script>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>
<body>
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="2" align="left" bgcolor="#D2D2D2"><strong>เลือกโฟลไฟล์การจัดทำข้อมูล</strong></td>
          </tr>
        <tr>
          <td width="12%" align="right" bgcolor="#FFFFFF"><strong>เลือกโฟรไฟล์ :</strong></td>
          <td bgcolor="#FFFFFF">
            <select name="profile_id" id="profile_id" onChange="gotourl(this)">
              <option value="">เลือกโฟล์ไฟล์</option>
              <?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
              <option value="?profile_id=<?=$rsp[profile_id]?>&action=<?=$action?>&xsiteid=<?=$xsiteid?>&lv=<?=$lv?>&caseT=<?=$caseT?>" <?=$sel?>><?=$rsp[profilename]?></option>
              <?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
              </select> 
            
          </td>
          </tr>
      </table>
   </td>
  </tr>
</table>
 </form>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td align="left"><? ?></td>
  </tr>
  <? if($action == ""){?>
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="center" bgcolor="#CCCCCC"><strong>รายงานการมอบหมายงานเพื่อบันทึกข้อมูล ก.พ.7 <?=ShowProfile_name($profile_id);?></strong></td>
        </tr>
      <tr>
        <td width="5%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="19%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td width="9%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>จำนวนเอกสาร<br>
          ทั้งหมด(คน)</strong></td>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>การจ่ายเอกสาร</strong></td>
        </tr>
      <tr>
        <td width="24%" align="center" bgcolor="#CCCCCC"><strong>มอบหมายงานจากทีม checklist<br>
          ให้พนักงานมอบหมายงาน(คน)</strong></td>
        <td width="26%" align="center" bgcolor="#CCCCCC"><strong>มอบหมายงานให้พนักงานคีย์ข้อมูล(คน)</strong></td>
        <td width="17%" align="center" bgcolor="#CCCCCC"><strong>คงค้างมอบหมายงานให้พนักงานคีย์(คน)</strong></td>
        </tr>
      <?
	  
	  $arra = CountDiffAssgin($profile_id); // จำนวนที่มอบหมายงาน
	  $arrch = NumCheckListAll($profile_id);// จำนวนทั้งหมดใน cheklist
	
	$sql = "SELECT
eduarea.secid,
eduarea.secname,
eduarea.secname_short,
if(substring(eduarea.secid,1,1) ='0',cast(secid as SIGNED),9999) as idsite
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata' AND
eduarea_config.profile_id =  '$profile_id'
order by idsite asc,secname asc";
	$result = mysql_db_query($dbnamemaster,$sql);
	while($rs = mysql_fetch_assoc($result)){
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	 $secname = str_replace("สพท.","",$rs[secname_short]);
	 $id_org = $rs[secid];
	 $num1 = $arrch[$id_org]['numall']; // จำนวนท้้งหมด
	 $num2 = $arrch[$id_org]['numpass'];// จำนวนที่สมบูรณ์
	 $num3 = $arra[$id_org]['numall'];// จำนวนที่มอบหมายงานทั้งหมด
	 $num4 = $arra[$id_org]['numassign'];// จำนวนที่มอบหมายงานให้กับคนคีย์
	 $num5 = $arra[$id_org]['numdiff']; // จำนวนที่ค้างมอบหมายงาน
	 $num6 = $num1-$num2; // จำนวนเอกสารที่ไม่สมบูรณ์
	 
	 if($num1 > 0){ $show1 = "<a href='?action=view&xsiteid=$id_org&caseT=1&profile_id=$profile_id'>".number_format($num1)."</a>";}else{ $show1 = number_format($num1);}
	 if($num2 > 0){ $show2 = "<a href='?action=view&xsiteid=$id_org&caseT=2&profile_id=$profile_id'>".number_format($num2)."</a>";}else{ $show2 = number_format($num2);}
	 if($num3 > 0){ $show3 = "<a href='?action=view&xsiteid=$id_org&caseT=3&profile_id=$profile_id'>".number_format($num3)."</a>";}else{ $show3 = number_format($num3);}
	 if($num4 > 0){ $show4 = "<a href='?action=view&xsiteid=$id_org&caseT=4&profile_id=$profile_id'>".number_format($num4)."</a>";}else{ $show4 = number_format($num4);}
	 if($num5 > 0){ $show5 = "<a href='?action=view&xsiteid=$id_org&caseT=5&profile_id=$profile_id'>".number_format($num5)."</a>";}else{ $show5 = number_format($num5);}
	 if($num6 > 0){ $show6 = "<a href='?action=view&xsiteid=$id_org&caseT=6&profile_id=$profile_id'>".number_format($num6)."</a>";}else{ $show6 = number_format($num6);}
	 
	 
      ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$secname?></td>
        <td align="center"><?=$show1?></td>
        <td align="center"><?=$show3?></td>
        <td align="center"><?=$show4?></td>
        <td align="center"><?=$show5?></td>
        </tr>
       <?
	   	$sumall1 += $num1;
		$sumall2 += $num2;
		$sumall3 += $num3;
		$sumall4 += $num4;
		$sumall5 += $num5;
		$sumall6 += $num6;
	}//end 	while($rs = mysql_fetch_assoc($result)){
	  ?>
      <tr>
        <td colspan="2" align="center" bgcolor="#E1E1E1"><strong>รวม</strong></td>
        <td align="center" bgcolor="#E1E1E1"><strong>
          <?=number_format($sumall1)?>
        </strong></td>
        <td align="center" bgcolor="#E1E1E1"><strong>
          <?=number_format($sumall3)?>
        </strong></td>
        <td align="center" bgcolor="#E1E1E1"><strong>
          <?=number_format($sumall4)?>
        </strong></td>
        <td align="center" bgcolor="#E1E1E1"><strong>
          <?=number_format($sumall5)?>
        </strong></td>
        </tr>

    </table></td>
  </tr>
  <?
   }// end if($action == ""){
	if($action == "view"){
		if($caseT == "1"){
			$xtitle = "รายงานจำนวนบุคลากรทั้งหมด".show_area($xsiteid);
			$sql = "SELECT idcard,prename_th,name_th,position_now,schoolid,pic_num FROM tbl_checklist_kp7 WHERE siteid='$xsiteid' and profile_id='$profile_id' ORDER BY schoolid ASC ";
		}else if($caseT == "2"){
			$xtitle = "รายงานจำนวนบุคลากรที่พร้อมมอบหมายเอกสาร".show_area($xsiteid);
			$sql = "SELECT idcard,prename_th,name_th,position_now,schoolid,pic_num FROM tbl_checklist_kp7 WHERE siteid='$xsiteid' and profile_id='$profile_id' AND status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0' ORDER BY  schoolid ASC";
			
		}else if($caseT == "3"){
			$xtitle = "รายงานจำนวนบุคลากรที่มอบหมายงานจากทีม checklist ให้พนักงานมอบหมายงาน".show_area($xsiteid);
			
			$sql = "SELECT
t.idcard,
t.prename_th,
t.name_th,
t.surname_th,
t.position_now,
t.schoolid,
t.pic_num
FROM
tbl_checklist_kp7 AS t
Inner Join tbl_checklist_assign_detail ON t.idcard = tbl_checklist_assign_detail.idcard
WHERE
t.profile_id =  '$profile_id' AND
tbl_checklist_assign_detail.profile_id =  '$profile_id' AND
tbl_checklist_assign_detail.activity_id =  '3' AND
t.siteid =  '$xsiteid' 
GROUP BY t.idcard
ORDER BY t.schoolid ASC";
			
		}else if($caseT == "4"){
			$xtitle = "รายงานจำนวนบุคลากรที่มอบหมายงานให้พนักงานคีย์ข้อมูล".show_area($xsiteid);
			$sql = "SELECT
t.idcard,
t.prename_th,
t.name_th,
t.surname_th,
t.position_now,
t.schoolid,
t.pic_num
FROM
edubkk_checklist.tbl_checklist_kp7 AS t
Inner Join callcenter_entry.tbl_assign_key ON t.idcard = callcenter_entry.tbl_assign_key.idcard
WHERE
t.profile_id =  '$profile_id' AND
t.siteid =  '$xsiteid' AND
callcenter_entry.tbl_assign_key.profile_id =  '$profile_id' 
GROUP BY t.idcard

ORDER BY t.schoolid ASC";
			
		}else if($caseT == "5"){
			$xtitle = "รายงานจำนวนบุคลากรที่คงค้างมอบหมายงานให้พนักงานคีย์".show_area($xsiteid);
			$sql = "SELECT
t.idcard,
t.prename_th,
t.name_th,
t.surname_th,
t.position_now,
t.schoolid,
t.pic_num
FROM
edubkk_checklist.tbl_checklist_kp7 AS t
inner Join edubkk_checklist.tbl_checklist_assign_detail as t1 ON t.idcard = t1.idcard AND t1.profile_id = '$profile_id' and t1.activity_id='3'
left Join callcenter_entry.tbl_assign_key as t2  ON t1.idcard = t2.idcard AND t2.profile_id = '$profile_id'
WHERE
t.profile_id =  '$profile_id' AND
t.siteid =  '$xsiteid' AND
t2.idcard IS NULL 
GROUP BY t.idcard
ORDER BY t.schoolid ASC";
			
		}else if($caseT == "6"){
			$xtitle = "รายงานจำนวนบุคลากรที่ไม่พร้อมมอบหมายเอกสาร".show_area($xsiteid);
			$sql = "SELECT idcard,prename_th,name_th,position_now,schoolid,pic_num FROM tbl_checklist_kp7 WHERE siteid='$xsiteid' and profile_id='$profile_id' AND (!(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0')) ORDER BY  schoolid ASC";
			
		}//end 	if($ceseT == "1"){

?>
<tr>
  <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="8" align="left" bgcolor="#CCCCCC"><strong><a href="?action=&profile_id=<?=$profile_id?>">ย้อนกลับ</a> || <?=$xtitle?></strong></td>
      </tr>
    <tr>
      <td width="3%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
      <td width="10%" align="center" bgcolor="#CCCCCC"><strong>เลขบัตรประชาชน</strong></td>
      <td width="16%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกลุ</strong></td>
      <td width="17%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
      <td width="19%" align="center" bgcolor="#CCCCCC"><strong>หน่วยงานสังกัด</strong></td>
      <td width="15%" align="center" bgcolor="#CCCCCC"><p><strong>จำนวนรูป  checklist นับ</strong></p></td>
      <td width="12%" align="center" bgcolor="#CCCCCC"><p><strong>จำนวนรูปจากการตัดรูป</strong></p></td>
      <td width="8%" align="center" bgcolor="#CCCCCC"><strong>สถานะไฟล์ Scan</strong></td>
    </tr>
    <? 

		$result = @mysql_db_query($dbname_temp,$sql);
		$numr = @mysql_num_rows($result);
		if($numr > 0){
		$i=0;
		$arrpic = xCheckFileServerPerson($xsiteid);
		while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			$numpicsys = $arrpic[$rs[idcard]]['numdb'];
			
			$path_file = "../../../".PATH_KP7_FILE."/$xsiteid/$rs[idcard]".".pdf";
			if(is_file($path_file)){
				$img_pdf = "<a href='$path_file' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a>";
			}else{
					$arrkp7 = GetPdfOrginal($rs[idcard],$path_pdf,$imgpdf,"","pdf");
					$img_pdf = $arrkp7['linkfile'];	
			}
			
	?>
    <tr bgcolor="<?=$bg?>">
      <td align="center"><?=$i?></td>
      <td align="center"><?=$rs[idcard]?></td>
      <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
      <td align="left"><? echo "$rs[position_now]";?></td>
      <td align="left"><?    echo show_school($rs[schoolid]);?></td>
      <td align="center"><?=number_format($rs[pic_num])?></td>
      <td align="center"><?=number_format($numpicsys)?></td>
      <td align="center"><?=$img_pdf?></td>
    </tr>
    <?
		}//end if($numr > 0){
		}//end while($rs = mysql_fetch_assoc($result)){
	?>
  </table></td></tr>
<?
	}//end if($action == "view"){
?>
</table>
</body>
</html>
