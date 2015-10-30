<?
session_start();
include("checklist2.inc.php");


function Thai_dateS1($temp){
				$shortmonth = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
				if($temp != "0000-00-00" and $temp != ""){
					$x = explode("-",$temp);
					return intval($x[2])." ".$shortmonth[intval($x[1])]." ".($x[0]+543);
				}else{
					return "";	
				}
				
}// function Thai_dateS1($temp){

function CountAssignArea($profile_id,$activity_id){
	global $dbname_temp;
	$sql = "SELECT
tbl_checklist_kp7.siteid,
count(tbl_checklist_assign_detail.idcard) as numid,
sum(if(status_sr_doc='2',1,0)) as docs_t,
sum(if(status_sr_doc='3',1,0)) as doc_destroy,
sum(if(status_sr_doc='1',1,0)) as docs_f
FROM
tbl_checklist_assign_detail
Inner Join tbl_checklist_assign ON tbl_checklist_assign_detail.ticketid = tbl_checklist_assign.ticketid AND
tbl_checklist_assign.activity_id =  '$activity_id' AND
tbl_checklist_assign_detail.profile_id =  '$profile_id'
Inner Join tbl_checklist_kp7 ON tbl_checklist_assign_detail.idcard = tbl_checklist_kp7.idcard
AND  tbl_checklist_kp7.profile_id='$profile_id'
GROUP BY tbl_checklist_kp7.siteid";
echo $sql;
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]]['num_assign'] = $rs[numid];	
		$arr[$rs[siteid]]['num_doct'] = $rs[docs_t];
		$arr[$rs[siteid]]['num_docf'] = $rs[docs_f];
		$arr[$rs[siteid]]['doc_destroy'] = $rs[doc_destroy];
	}
	return $arr;
}//end function CountAssignArea($profile_id,$actvity_id){

function CountAssignSchool($profile_id,$activity_id,$siteid){
	global $dbname_temp;
	$sql = "SELECT
tbl_checklist_kp7.schoolid,
count(tbl_checklist_assign_detail.idcard) as numid,
sum(if(status_sr_doc='2',1,0)) as docs_t,
sum(if(status_sr_doc='3',1,0)) as doc_destroy,
sum(if(status_sr_doc='1',1,0)) as docs_f
FROM
tbl_checklist_assign_detail
Inner Join tbl_checklist_assign ON tbl_checklist_assign_detail.ticketid = tbl_checklist_assign.ticketid AND
tbl_checklist_assign.activity_id =  '$activity_id' AND
tbl_checklist_assign_detail.profile_id =  '$profile_id'
Inner Join tbl_checklist_kp7 ON tbl_checklist_assign_detail.idcard = tbl_checklist_kp7.idcard
AND  tbl_checklist_kp7.profile_id='$profile_id'
WHERE
tbl_checklist_kp7.siteid='$siteid'
GROUP BY tbl_checklist_kp7.schoolid
";
//echo $sql;
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[schoolid]]['num_assign'] = $rs[numid];	
		$arr[$rs[schoolid]]['num_doct'] = $rs[docs_t];
		$arr[$rs[schoolid]]['num_docf'] = $rs[docs_f];
		$arr[$rs[schoolid]]['doc_destroy'] = $rs[doc_destroy];
	}//end while($rs = mysql_fetch_assoc($result)){
return $arr;
}//end function CountAssignSchool($profile_id,$activity_id,$siteid){
	
function CountCheckListArea($profile_id){
	global $dbname_temp;
	$sql = "SELECT count(idcard) as numid,siteid  FROM `tbl_checklist_kp7` where profile_id='$profile_id' group by siteid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]]	 = $rs[numid];
	}
	return $arr;
}//end function CountCheckListArea($profile_id){
	
function CountCheckListSchool($profile_id,$siteid){
	global $dbname_temp;
	$sql = "SELECT count(idcard) as numid,schoolid  FROM `tbl_checklist_kp7` where profile_id='$profile_id' and siteid='$siteid' group by schoolid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[schoolid]]	 = $rs[numid];
	}
	return $arr;
}//end function CountCheckListSchool($profile_id,$siteid){
	
	
function StatusDoc($activity_id,$profile_id,$xsiteid,$schoolid){
	global $dbname_temp;
	$sql = "SELECT
tbl_checklist_kp7.idcard,
count(tbl_checklist_assign_detail.idcard) as numid,
sum(if(status_sr_doc='2',1,0)) as docs_t,
sum(if(status_sr_doc='3',1,0)) as doc_destroy,
sum(if(status_sr_doc='1',1,0)) as docs_f
FROM
tbl_checklist_assign_detail
Inner Join tbl_checklist_assign ON tbl_checklist_assign_detail.ticketid = tbl_checklist_assign.ticketid AND
tbl_checklist_assign.activity_id =  '$activity_id' AND
tbl_checklist_assign_detail.profile_id =  '$profile_id'
Inner Join tbl_checklist_kp7 ON tbl_checklist_assign_detail.idcard = tbl_checklist_kp7.idcard AND tbl_checklist_kp7.profile_id='$profile_id'
WHERE
tbl_checklist_kp7.siteid='$xsiteid' AND schoolid='$schoolid'
GROUP BY tbl_checklist_kp7.idcard";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[idcard]]['numid'] = $rs[numid];
		$arr[$rs[idcard]]['docs_t'] = $rs[docs_t];
		$arr[$rs[idcard]]['docs_f'] = $rs[docs_f];
		$arr[$rs[idcard]]['doc_destroy'] = $rs[doc_destroy];
			
	}
	return $arr;
}//end function StatusDoc($activity_id,$profile_id,$xsiteid,$schoolid){

	if($lv == ""){
		$lv = "1"; // คือ ระดับเขต
	}

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
          <td colspan="2" align="left" bgcolor="#D2D2D2"><strong>เลือกกลุ่มรายการข้อมูล</strong></td>
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
              <option value="?profile_id=<?=$rsp[profile_id]?>&activity_id=<?=$activity_id?>&lv=<?=$lv?>&xsiteid=<?=$xsiteid?>&schoolid=<?=$schoolid?>&acname=<?=$acname?>&office=<?=$office?>&xtype=<?=$xtype?>&level=<?=$level?>" <?=$sel?>><?=$rsp[profilename]?></option>
              <?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
              </select> 
            
          </td>
          </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF"><strong>ประเภทกิจกรรม : </strong></td>
          <td bgcolor="#FFFFFF">
            <select name="activity_id" id="activity_id" onChange="gotourl(this)">
              <option value="">เลือกประเภทกิจกรรม</option>
              <?
            	$sql_act = "SELECT * FROM tbl_checklist_activity ORDER BY activity ASC";
				$result_act = mysql_db_query($dbname_temp,$sql_act);
				while($rsac = mysql_fetch_assoc($result_act)){
					if($rsac[activity_id] == $activity_id){ $sel = "selected='selected'";}else{ $sel = "";}
					echo "<option value='?profile_id=$profile_id&lv=$lv&xsiteid=$xsiteid&activity_id=$rsac[activity_id]&schoolid=$schoolid&acname=$rsac[activity]&office=$office&xtype=$xtype&level=$level' $sel>$rsac[activity]</option>";
				}//end while($rsac = mysql_fetch_assoc($result_act)){
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
    <td align="left"><?  if($lv == "2"){ echo "<a href='?lv=1&profile_id=$profile_id&xsiteid=$xsiteid&activity_id=$activity_id&schoolid=$schoolid&acname=$acname&office=$office'>หน้าหลัก</a> =>".show_area($xsiteid)."" ;}else if($lv == "3" or $lv == "4"){ echo "<a href='?lv=1&profile_id=$profile_id&xsiteid=$xsiteid&activity_id=$activity_id&schoolid=$schoolid&acname=$acname&office=$office'>หน้าหลัก</a> =><a href='?lv=2&profile_id=$profile_id&xsiteid=$xsiteid&activity_id=$activity_id&schoolid=$schoolid&acname=$acname&office=$office'>".show_area($xsiteid)."</a> => $office"  ;}?></td>
  </tr>
  <? if($lv == "1" or $lv == "2"){?>
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" align="center" bgcolor="#CCCCCC"><strong>รายงานการมอบหมายงานเอกสารทะเบียนประวัติอิเล็กทรอนิกส์ <?=ShowProfile_name($profile_id);?>&nbsp;(<?  if($acname == ""){ echo "งานสแกนเอกสาร ก.พ.7";}else{echo $acname;}?>)</strong></td>
        </tr>
      <tr>
        <td width="3%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="22%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong><? if($lv > 1){ echo "หน่วยงานสังกัด"; }else{ echo "สำนักงานเขตพื้นที่การศึกษา";}?></strong></td>
        <td width="10%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>จำนวนเอกสาร<br>
          ทั้งหมด(คน)</strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>การจ่ายงาน</strong></td>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>การคืนงาน</strong></td>
        </tr>
      <tr>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong>จ่าย(คน)</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>คงค้าง(คน)</strong></td>
        <td width="14%" align="center" bgcolor="#CCCCCC"><strong>ส่งคืน(คน)</strong></td>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong>ส่งคืนและทำลาย(คน)</strong></td>
        <td width="14%" align="center" bgcolor="#CCCCCC"><strong>ค้างคืน(คน)</strong></td>
      </tr>
      <?



if($lv == "1"){ // ระดับเขตพื้นที่การศึกษาeduarea.secname_short
		$arrassign = CountAssignArea($profile_id,$activity_id);
		$arrchecklist = CountCheckListArea($profile_id);
		$sqlmain = "SELECT eduarea.secid as idoffice,eduarea.secid as siteid, eduarea.secname_short as orgname,
		if(substring(eduarea.secid,1,1) ='0',cast(secid as SIGNED),9999) as idsite
		 FROM eduarea Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE eduarea_config.group_type =  'keydata' AND eduarea_config.profile_id =  '$profile_id' order by idsite,eduarea.secname ASC";
		$resultmain = mysql_db_query($dbnamemaster,$sqlmain);
		
}else if($lv == "2"){// ระดับโรงเรียน
		$arrassign = CountAssignSchool($profile_id,$activity_id,$xsiteid);
		$arrchecklist =  CountCheckListSchool($profile_id,$xsiteid);
		$sql_uptemp =  "UPDATE temp_order_school SET orderby='0' WHERE schoolid='$xsiteid'";
	mysql_db_query($dbname_temp,$sql_uptemp);
		$sqlmain = "SELECT if(edubkk_checklist.temp_order_school.orderby IS NULL,9999,orderby) as orderby1,
edubkk_master.allschool.id as idoffice, edubkk_master.allschool.office as orgname, edubkk_master.allschool.siteid
FROM edubkk_master.allschool  left Join edubkk_checklist.temp_order_school ON edubkk_master.allschool.id = edubkk_checklist.temp_order_school.schoolid 
WHERE edubkk_master.allschool.siteid=  '$xsiteid'  and edubkk_master.allschool.activate_status='open'
ORDER BY orderby1 ASC";
		$resultmain = mysql_db_query($dbname_temp,$sqlmain);
}//end if($lv == "1"){
//echo $sqlmain;
//echo "<pre>";	
//print_r($arrassign);

	  $i=0;
	  while($rsm = mysql_fetch_assoc($resultmain)){
		   if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		  
			$numchecklist = $arrchecklist[$rsm[idoffice]];// จำนวนทั้งหมดใน checklist
			$numsent = $arrassign[$rsm[idoffice]]['num_assign'];// จำนวนที่จ่ายงานไปทั้งหมด
			$numsent_diff = $numchecklist-$numsent; // จำนวนที่ค้างจ่ายงาน
			$numrecive_destroy = $arrassign[$rsm[idoffice]]['doc_destroy']; // ส่งคืนและทำลาย
			$numrecive = $arrassign[$rsm[idoffice]]['num_doct']; // จำนวนที่ส่งคืนเอกสาร
			$numrecive_diff = $arrassign[$rsm[idoffice]]['num_docf']; // จำนวนที่ค้างส่งคืนเอกสาร
			
			if($lv == "1"){
				 $org = str_replace("สพท.","",$rsm[orgname]);
					$link_org = "<a href='?lv=2&profile_id=$profile_id&activity_id=$activity_id&xsiteid=$rsm[siteid]&office=$org&schoolid=$rsm[idoffice]'>$org</a>";
			}else{
				
							$org = $rsm[orgname];	
					
					
					$link_org = "<a href='?lv=3&profile_id=$profile_id&activity_id=$activity_id&xsiteid=$rsm[siteid]&office=$org&schoolid=$rsm[idoffice]'>$org</a>";	
			}//end 	if($lv == "1"){
			
			
			
      ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$link_org?></td>
        <td align="center"><? if($numchecklist > 0){ echo "<a href='?lv=4&profile_id=$profile_id&activity_id=$activity_id&xsiteid=$rsm[siteid]&office=$org&schoolid=$rsm[idoffice]&xtype=checklist&level=$lv&acname=$acname'>".number_format($numchecklist)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($numsent > 0){ echo "<a href='?lv=4&profile_id=$profile_id&activity_id=$activity_id&xsiteid=$rsm[siteid]&office=$org&schoolid=$rsm[idoffice]&xtype=assign&level=$lv&acname=$acname'>".number_format($numsent)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($numsent_diff > 0){ echo "<a href='?lv=4&profile_id=$profile_id&activity_id=$activity_id&xsiteid=$rsm[siteid]&office=$org&schoolid=$rsm[idoffice]&xtype=nonassign&level=$lv&acname=$acname'>".number_format($numsent_diff)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($numrecive > 0){ echo "<a href='?lv=4&profile_id=$profile_id&activity_id=$activity_id&xsiteid=$rsm[siteid]&office=$org&schoolid=$rsm[idoffice]&xtype=recive&level=$lv&acname=$acname'>".number_format($numrecive)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($numrecive_destroy > 0){ echo "<a href='?lv=4&profile_id=$profile_id&activity_id=$activity_id&xsiteid=$rsm[siteid]&office=$org&schoolid=$rsm[idoffice]&xtype=recive_destroy&level=$lv&acname=$acname'>".number_format($numrecive_destroy)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($numrecive_diff > 0){ echo "<a href='?lv=4&profile_id=$profile_id&activity_id=$activity_id&xsiteid=$rsm[siteid]&office=$org&schoolid=$rsm[idoffice]&xtype=nonrecive&level=$lv&acname=$acname'>".number_format($numrecive_diff)."</a>";}else{ echo "0";}?></td>
      </tr>
       <?
	   $sum1 += $numchecklist;
	   $sum2 += $numsent;
	   $sum3 += $numsent_diff;
	   $sum4 += $numrecive;
	   $sum5 += $numrecive_diff;
	   $sum6 += $numrecive_destroy;
	   
	  }//end  while($rsm = mysql_fetch_assoc($resultmain)){
	  ?>
      <tr>
        <td colspan="2" align="center" bgcolor="#E1E1E1"><strong>รวม</strong></td>
        <td align="center" bgcolor="#E1E1E1"><strong>
          <?=number_format($sum1)?>
        </strong></td>
        <td align="center" bgcolor="#E1E1E1"><strong>
          <?=number_format($sum2)?>
        </strong></td>
        <td align="center" bgcolor="#E1E1E1"><strong>
          <?=number_format($sum3)?>
        </strong></td>
        <td align="center" bgcolor="#E1E1E1"><strong>
          <?=number_format($sum4)?>
        </strong></td>
        <td align="center" bgcolor="#E1E1E1"><strong><?=number_format($sum6);?></strong></td>
        <td align="center" bgcolor="#E1E1E1"><strong>
          <?=number_format($sum5)?>
        </strong></td>
      </tr>

    </table></td>
  </tr>
  <? }// end if($lv == "1" or $lv == "2"){
	if($lv == "3"){	  	
?>
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="9" align="center" bgcolor="#CCCCCC"><strong>รายละเอียกการมอบหมายงาน
          <?=ShowProfile_name($profile_id);?>
          &nbsp;(
          <?  if($acname == ""){ echo "งานสแกนเอกสาร ก.พ.7";}else{echo $acname;}?>
          )</strong></td>
        </tr>
      <tr>
        <td width="3%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="11%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>เลขบัตร</strong></td>
        <td width="17%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ชื่อนามสกุล</strong></td>
        <td width="18%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>การจ่ายงาน</strong></td>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>การคืนงาน</strong></td>
        </tr>
      <tr>
        <td width="9%" align="center" bgcolor="#CCCCCC"><strong>จ่ายงานแล้ว</strong></td>
        <td width="10%" align="center" bgcolor="#CCCCCC"><strong>ค้างจ่าย</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>ส่งคืน</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>ส่งคืนและทำลาย(คน)</strong></td>
        <td width="10%" align="center" bgcolor="#CCCCCC"><strong>ค้างส่งคืน</strong></td>
      </tr>
      <?
	 $arrdoc =  StatusDoc($activity_id,$profile_id,$xsiteid,$schoolid);
      	$sql = "SELECT idcard,prename_th,name_th,surname_th,position_now  FROM `tbl_checklist_kp7` WHERE  profile_id='$profile_id' AND siteid='$xsiteid' AND schoolid='$schoolid'";
		//echo $sql;
		$result = mysql_db_query($dbname_temp,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 if($arrdoc[$rs[idcard]]['numid'] > 0){
					$img1 = "<img src=\"../../images_sys/check_green.gif\" width=\"16\" height=\"13\" border='0' title='จ่ายงานแล้ว'>";
					$img2 = "";
			}else{
					$img1 = "";	
					$img2 = "<img src=\"../../images_sys/check_green.gif\" width=\"16\" height=\"13\" border='0' title='ค้างจ่ายงาน'>";
			}

			if($arrdoc[$rs[idcard]]['docs_t'] > 0){
				$img3 = "<img src=\"../../images_sys/check_green.gif\" width=\"16\" height=\"13\" border='0' title='ส่งคืนเอกสารแล้ว'>";	
			}else{
				$img3 = "";	
			}
			
			if($arrdoc[$rs[idcard]]['docs_f'] > 0){
					$img4 = "<img src=\"../../images_sys/check_green.gif\" width=\"16\" height=\"13\" border='0' title='ค้างส่งคืนเอกสาร'>";	
			}else{
					$img4 = "";	
			}
			
			if($arrdoc[$rs[idcard]]['doc_destroy'] > 0){
				$img5 = "<img src=\"../../images_sys/check_green.gif\" width=\"16\" height=\"13\" border='0' title='ส่งคืนและทำลายเอกสารแล้ว'>";		
			}else{
				$img5 = "";	
			}
			
	  ?>
      
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="center"><?=$img1?></td>
        <td align="center"><?=$img2?></td>
        <td align="center"><?=$img3?></td>
        <td align="center"><?=$img5?></td>
        <td align="center"><?=$img4?></td>
      </tr>
      <?
		}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
  <?
	}else if($lv == "4"){//end if($lv == "3"){	
	
		if($xtype == "checklist"){
				if($level == "1"){
						$sql = "SELECT idcard,prename_th,name_th,surname_th,schoolid,siteid FROM  tbl_checklist_kp7 WHERE siteid='$xsiteid' AND profile_id='$profile_id' ORDER BY  schoolid ASC";
				}else if($level == "2"){
					$sql = "SELECT idcard,prename_th,name_th,surname_th,schoolid,siteid FROM  tbl_checklist_kp7 WHERE siteid='$xsiteid' AND schoolid='$schoolid' AND profile_id='$profile_id' ORDER BY  schoolid ASC";
				}
		}else if($xtype == "assign"){ 
			if($level == "1"){
					$sql = "SELECT t1.idcard,t1.prename_th,t1.name_th,t1.surname_th,t1.schoolid,t1.siteid FROM tbl_checklist_kp7 as t1 INNER JOIN tbl_checklist_assign_detail AS t2 ON t1.idcard=t2.idcard INNER JOIN tbl_checklist_assign AS t3 ON t2.ticketid=t3.ticketid WHERE t1.profile_id='$profile_id' AND t1.siteid='$xsiteid' AND t2.activity_id='$activity_id'";
			}else if($level == "2"){
					$sql = "SELECT t1.idcard,t1.prename_th,t1.name_th,t1.surname_th,t1.schoolid,t1.siteid FROM tbl_checklist_kp7 as t1 INNER JOIN tbl_checklist_assign_detail AS t2 ON t1.idcard=t2.idcard INNER JOIN tbl_checklist_assign AS t3 ON t2.ticketid=t3.ticketid WHERE t1.profile_id='$profile_id' AND t1.siteid='$xsiteid' AND t1.schoolid='$schoolid'  AND t2.activity_id='$activity_id'";
			}
		
		}else if($xtype == "nonassign"){
				if($level == "1"){
						$sql_temp = "SELECT t1.idcard FROM tbl_checklist_kp7 as t1 INNER JOIN tbl_checklist_assign_detail AS t2 ON t1.idcard=t2.idcard INNER JOIN tbl_checklist_assign AS t3 ON t2.ticketid=t3.ticketid WHERE t1.profile_id='$profile_id' AND t1.siteid='$xsiteid' AND t2.activity_id='$activity_id'";
						$result_temp = mysql_db_query($dbname_temp,$sql_temp);
						while($rst = mysql_fetch_assoc($result_temp)){
								if($id_temp > "") $id_temp .= ",";
								$id_temp .= "'$rst[idcard]'";
						}
						if($id_temp != ""){ $conid = " AND idcard NOT IN($id_temp)"; }else{ $conid = "";}
						
					$sql =  "SELECT idcard,prename_th,name_th,surname_th,schoolid,siteid FROM  tbl_checklist_kp7 WHERE siteid='$xsiteid' AND profile_id='$profile_id' $conid ORDER BY  schoolid ASC";
				}else if($level == "2"){
					$sql_temp = "SELECT t1.idcard FROM tbl_checklist_kp7 as t1 INNER JOIN tbl_checklist_assign_detail AS t2 ON t1.idcard=t2.idcard INNER JOIN tbl_checklist_assign AS t3 ON t2.ticketid=t3.ticketid WHERE t1.profile_id='$profile_id' AND t1.siteid='$xsiteid' AND t1.schoolid='$schoolid'  AND t2.activity_id='$activity_id'";
					$result_temp = mysql_db_query($dbname_temp,$sql_temp);
					while($rst = mysql_fetch_assoc($result_temp)){
								if($id_temp > "") $id_temp .= ",";
								$id_temp .= "'$rst[idcard]'";
						}
						if($id_temp != ""){ $conid = " AND idcard NOT IN($id_temp)"; }else{ $conid = "";}
						
						$sql = "SELECT idcard,prename_th,name_th,surname_th,schoolid,siteid FROM  tbl_checklist_kp7 WHERE siteid='$xsiteid' AND schoolid='$schoolid' AND profile_id='$profile_id' $conid ORDER BY  schoolid ASC";
				}
		
		} else if($xtype == "recive"){ 
			if($level == "1"){
					$sql = "SELECT t1.idcard,t1.prename_th,t1.name_th,t1.surname_th,t1.schoolid,t1.siteid FROM tbl_checklist_kp7 as t1 INNER JOIN tbl_checklist_assign_detail AS t2 ON t1.idcard=t2.idcard INNER JOIN tbl_checklist_assign AS t3 ON t2.ticketid=t3.ticketid WHERE t1.profile_id='$profile_id' AND t1.siteid='$xsiteid' AND t2.activity_id='$activity_id' AND t2.status_sr_doc='2'";
			}else if($level == "2"){
					$sql = "SELECT t1.idcard,t1.prename_th,t1.name_th,t1.surname_th,t1.schoolid,t1.siteid FROM tbl_checklist_kp7 as t1 INNER JOIN tbl_checklist_assign_detail AS t2 ON t1.idcard=t2.idcard INNER JOIN tbl_checklist_assign AS t3 ON t2.ticketid=t3.ticketid WHERE t1.profile_id='$profile_id' AND t1.siteid='$xsiteid' AND t1.schoolid='$schoolid'  AND t2.activity_id='$activity_id' AND t2.status_sr_doc='2'";
			}
			
		}else if($xtype == "recive_destroy"){
			if($level == "1"){
					$sql = "SELECT t1.idcard,t1.prename_th,t1.name_th,t1.surname_th,t1.schoolid,t1.siteid FROM tbl_checklist_kp7 as t1 INNER JOIN tbl_checklist_assign_detail AS t2 ON t1.idcard=t2.idcard INNER JOIN tbl_checklist_assign AS t3 ON t2.ticketid=t3.ticketid WHERE t1.profile_id='$profile_id' AND t1.siteid='$xsiteid' AND t2.activity_id='$activity_id' AND t2.status_sr_doc='3'";
			}else if($level == "2"){
					$sql = "SELECT t1.idcard,t1.prename_th,t1.name_th,t1.surname_th,t1.schoolid,t1.siteid FROM tbl_checklist_kp7 as t1 INNER JOIN tbl_checklist_assign_detail AS t2 ON t1.idcard=t2.idcard INNER JOIN tbl_checklist_assign AS t3 ON t2.ticketid=t3.ticketid WHERE t1.profile_id='$profile_id' AND t1.siteid='$xsiteid' AND t1.schoolid='$schoolid'  AND t2.activity_id='$activity_id' AND t2.status_sr_doc='3'";
			}

				
		}else if($xtype == "nonrecive"){ 
					if($level == "1"){
					$sql = "SELECT t1.idcard,t1.prename_th,t1.name_th,t1.surname_th,t1.schoolid,t1.siteid FROM tbl_checklist_kp7 as t1 INNER JOIN tbl_checklist_assign_detail AS t2 ON t1.idcard=t2.idcard INNER JOIN tbl_checklist_assign AS t3 ON t2.ticketid=t3.ticketid WHERE t1.profile_id='$profile_id' AND t1.siteid='$xsiteid' AND t2.activity_id='$activity_id' AND t2.status_sr_doc='1'";
			}else if($level == "2"){
					$sql = "SELECT t1.idcard,t1.prename_th,t1.name_th,t1.surname_th,t1.schoolid,t1.siteid FROM tbl_checklist_kp7 as t1 INNER JOIN tbl_checklist_assign_detail AS t2 ON t1.idcard=t2.idcard INNER JOIN tbl_checklist_assign AS t3 ON t2.ticketid=t3.ticketid WHERE t1.profile_id='$profile_id' AND t1.siteid='$xsiteid' AND t1.schoolid='$schoolid'  AND t2.activity_id='$activity_id' AND t2.status_sr_doc='1'";
			}

		}
	
  ?>
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" align="center" bgcolor="#CCCCCC"><strong>
        <?
        		if($xtype == "checklist"){ echo "รายจำนวนบุคลากรทั้งหมด";}else if($xtype == "assign"){ echo "รายการจำนวนที่จ่ายงานแล้ว";}else if($xtype == "nonassign"){ echo "รายงานจำนวนที่ค้างจ่ายงาน";} else if($xtype == "recive"){ echo "รายงานจำนวนที่คืนเอกสารแล้ว";} else if($xtype == "nonrecive"){ echo "รายการจำนวนที่ค้างคืนเอกสาร";}else if($xtype == "recive_destroy"){ echo "รายการจำนวนที่รับคืนและทำลายเอกสาร";}
		?>
        <?=ShowProfile_name($profile_id);?>
&nbsp;(
<?  if($acname == ""){ echo "งานสแกนเอกสาร ก.พ.7";}else{echo $acname;}?>
)</strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>เลขบัตร</strong></td>
        <td width="16%" align="center" bgcolor="#CCCCCC"><strong>ชื่อนามสกุล</strong></td>
        <td width="17%" align="center" bgcolor="#CCCCCC"><strong>หน่วยงาน</strong></td>
        <td width="16%" align="center" bgcolor="#CCCCCC"><strong>รหัสใบงาน</strong></td>
        <td width="14%" align="center" bgcolor="#CCCCCC"><strong>ผู้รับงาน</strong></td>
        <td width="10%" align="center" bgcolor="#CCCCCC"><strong>วันจ่ายเอกสาร</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>วันคืนและทำลายเอกสาร</strong></td>
        </tr>
        
      <?

	  		$sql_detail = "SELECT t1.ticketid,t1.staffid,t1.date_assign,t1.date_recive,t2.idcard FROM tbl_checklist_assign AS t1 INNER JOIN tbl_checklist_assign_detail AS t2 ON t1.ticketid=t2.ticketid WHERE t2.siteid='$xsiteid' AND t2.profile_id='$profile_id' AND t2.activity_id='$activity_id' ";
			
			//echo $sql."<hr><br>$sql_detail<br>";
			$result_d = mysql_db_query($dbname_temp,$sql_detail);
			while($rsd = mysql_fetch_assoc($result_d)){
				$arrdetail[$rsd[idcard]]['ticketid']	= $rsd[ticketid];
				$arrdetail[$rsd[idcard]]['staffid']	= $rsd[staffid];
				$arrdetail[$rsd[idcard]]['date_assign']	= $rsd[date_assign];
				$arrdetail[$rsd[idcard]]['date_recive']	= $rsd[date_recive];
			
				
			}

	  
     		$result = mysql_db_query($dbname_temp,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
				  if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
					
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo $pres.show_school($rs[schoolid]);?></td>
        <td align="left"><? echo $arrdetail[$rs[idcard]]['ticketid']?></td>
        <td align="left"><? echo show_user($arrdetail[$rs[idcard]]['staffid']);?></td>
        <td align="center"><? echo Thai_dateS1($arrdetail[$rs[idcard]]['date_assign']);?></td>
        <td align="center"><? echo Thai_dateS1($arrdetail[$rs[idcard]]['date_recive']);?></td>
        </tr>
      <?
			}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
  <?
	}//end  if($lv == "4"){
  ?>
</table>
</body>
</html>
