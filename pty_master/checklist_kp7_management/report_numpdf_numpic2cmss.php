<?
set_time_limit(0);
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "checklistkp7_report_pobec"; 
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

	$arrword = array("Nall"=>"จำนวนบุคลากรทั้งหมด","Npass"=>"จำนวนบุคลากรที่พร้อมนำเข้าระบบ","Nimp"=>"จำนวนบุคลากรที่นำเข้าไปในระบบ cmss","Ndimp"=>"จำนวนบุคลากรที่ค้างนำเข้าระบบ cmss","Npdf","จำนวนบุคลากรที่นำเข้าไฟล์ ก.พ.7 ต้นฉบับ","Ndpdf"=>"จำนวนบุคลากรที่ค้างนำเข้าไฟล์ ก.พ. 7 ต้นฉบับ","Npic"=>"จำนวนบุคลากรที่นับจำนวนรูป ก.พ.7 ในระบบ cheklist","Npicsys"=>"จำนวนบุคลากรที่นำเข้ารูปภาพ ก.พ.7 ในระบบ cmss","Npicdiff"=>"จำนวนบุคลากรที่ค้างนำเข้ารูป ก.พ.7");		
$time_start = getmicrotime();

$dbname2=$dbname_temp=DB_CHECKLIST;

if($profile_id == ""){
	$profile_id = LastProfile();	
}//end if($profile_id == ""){
	
	
function GetmaxUpdatePDF($profile_id="",$siteid=""){
	global $dbname_temp;
	
	if($siteid == ""){
	$sql =  "SELECT
Max(log_upload_pdf.date_upload) as maxdate,
siteid
FROM `log_upload_pdf`
GROUP BY siteid";	
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arrd[$rs[siteid]] = GetDateThaiFullTime($rs[maxdate]);
	}//end while($rs = mysql_fetch_assoc($result)){
}else{
	$sql = "SELECT
max(t2.timeupdate) as maxdate,
t1.siteid,
t1.schoolid
FROM tbl_checklist_kp7 as t1 Inner join 
log_upload_pdf_detail  as t2 ON t1.idcard = t2.idcard
WHERE t1.profile_id='$profile_id' and t1.siteid='$siteid' GROUP BY t1.schoolid";		
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arrd[$rs[schoolid]] = GetDateThaiFullTime($rs[maxdate]);	// 
	}//end 	while($rs = mysql_fetch_assoc($result)){
}//end 	if($siteid == ""){
		return $arrd;
}// end function GetmaxUpdatePDF(){

function GetmaxTimedate($profile_id,$siteid=""){
	global $dbname_temp;
	if($siteid != ""){
			$conv = " AND  tbl_checklist_kp7.siteid='$siteid'";
			$groupby = " Group By schoolid";
	}else{
			$conv = "";	
			$groupby = " Group By siteid";
	}
	$sql = "SELECT
max(tbl_checklist_kp7.time_update) as maxdate1,
tbl_checklist_kp7.siteid,tbl_checklist_kp7.schoolid
FROM `tbl_checklist_kp7` where profile_id='$profile_id' $conv 
$groupby";	
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		if($siteid != ""){ $idorg = "$rs[schoolid]";}else{ $idorg = "$rs[siteid]";}
		$arrd[$idorg] = GetDateThaiFullTime($rs[maxdate1]);
	}
	return $arrd;
}//end function GetmaxTimedate($profile_id){

function GetmaxUploadPic($profile_id,$siteid=""){
	global $dbname_temp;
	if($siteid == ""){
		$sql = "SELECT max(date_approve) as maxpicdate, site as siteid  FROM `upload_general_pic` where upload_general_pic.profile_id='$profile_id' group by siteid ;";	
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arrd[$rs[siteid]] = GetDateThaiFullTime($rs[maxpicdate]);
		}
	}else{
		$sql = "SELECT
max(upload_general_pic.date_approve) as maxpicdate,
tbl_checklist_kp7.schoolid
FROM
upload_general_pic
Inner Join tbl_checklist_kp7 ON upload_general_pic.id = tbl_checklist_kp7.idcard and upload_general_pic.profile_id='$profile_id' and tbl_checklist_kp7.profile_id='$profile_id'
where tbl_checklist_kp7.siteid='$siteid' group by schoolid";	
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$arrd[$rs[schoolid]] = GetDateThaiFullTime($rs[maxpicdate]);	
		}//end while($rs = mysql_fetch_assoc($result)){
	}//end 	if($siteid == ""){
	//echo $sql;	
	return $arrd;
}//end function GetmaxUploadPic(){

function XNumPersonKey($profile_id){
	global $dbname_temp;
	$sql = "SELECT
edubkk_checklist.tbl_checklist_kp7.siteid,
count(edubkk_checklist.tbl_checklist_kp7.idcard) as numkey
FROM
edubkk_checklist.tbl_checklist_kp7
Inner Join callcenter_entry.tbl_assign_key ON edubkk_checklist.tbl_checklist_kp7.idcard = callcenter_entry.tbl_assign_key.idcard
AND edubkk_checklist.tbl_checklist_kp7.siteid = callcenter_entry.tbl_assign_key.siteid
WHERE
edubkk_checklist.tbl_checklist_kp7.profile_id =  '$profile_id' AND
callcenter_entry.tbl_assign_key.nonactive =  '0' AND
callcenter_entry.tbl_assign_key.approve =  '2'
GROUP BY
edubkk_checklist.tbl_checklist_kp7.siteid";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr1[$rs[siteid]]['numkey'] = $rs['numkey'];
	}
	return $arr1;
}//



function CountPicsysTemp($profile_id,$siteid=""){
	global $dbnamemaster;
	//echo $profile_id." :: ".$siteid."<br>";
	
	if($siteid == ""){
			$sql = "SELECT
	 eduarea.secid
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata' AND
eduarea_config.profile_id =  '$profile_id'";
	}else{
			$sql = " SELECT * FROM allschool WHERE siteid='$siteid'";
	}//end 	if($siteid != ""){
	
	//echo $dbnamemaster ." :: ".$sql;
	
$result = mysql_db_query($dbnamemaster,$sql);
while($rs = mysql_fetch_assoc($result)){
		if($siteid != ""){ 
			$idorg = $rs[id];
			$site = "$rs[siteid]";
			$arr[$idorg]['numpic'] = GetCountPicSys($site,"$idorg","","$profile_id");
		}else{
			 $idorg = $rs[secid];
			 $site = "$rs[secid]";
			 $arr[$idorg]['numpic'] = GetCountPicSys($site,"","","$profile_id");
		}// end 	if($siteid != ""){ 
}//end while($rs = mysql_fetch_assoc($result)){
	//echo "<pre>";
	//print_r($arr);
	
		return $arr;
}//end function CountPicsysTemp($profile_id){



function xCheckUnlockIcon($profile_id){
	global $dbname_temp;
	$sql = "SELECT count(siteid) as num1,siteid  FROM `tbl_status_unlock_site` WHERE profile_id='$profile_id' and status_unlock='1' group by siteid";	
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arrx[$rs[siteid]] = $rs[num1];
	}//end while($rs = mysql_fetch_assoc($result)){
return $arrx;	
}//end function CheckUnlockIcon(){





function read_file_folder(){
		$Dir_Part="../../../checklist_kp7file/fileall/";
		$Dir=opendir($Dir_Part);
		while($File_Name=readdir($Dir)){
			if(($File_Name!= ".") && ($File_Name!= "..")){
				$Name .= "$File_Name";
			}
					
		}
		closedir($Dir);
		///ปิด Directory------------------------------	
		$File_Array=explode(".pdf",$Name);
		return $File_Array;
	}// end function read_file_folder($secid){
	// edit_pic----------------------------------------------------------------------------------------
	
	## function count จำนวนคน กับไฟล์ pdf
	function CountPersonPdf($get_siteid){
		global $dbname_temp;	
		$sql = "SELECT 
		count(idcard) as NumPerson,
		sum(if(page_upload > 0,1,0)) as NumPdf,
		sum(if(page_upload > 0 and page_upload <> page_num,1,0)) as NumPageFail
		FROM tbl_checklist_kp7 WHERE siteid='$get_siteid'";
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		$arr['NumPdf'] = $rs[NumPdf];
		$arr['NumPerson'] = $rs[NumPerson];
		$arr['NumPageFail'] = $rs[NumPageFail];
		return $arr;
	}
	
	###
	function AddLogPdf($get_idcard,$get_siteid,$get_action){
		global $dbname_temp;
		$sql = "INSERT INTO tbl_log_upload_pdf SET idcard='$get_idcard',siteid='$get_siteid',action='$get_action'";
		mysql_db_query($dbname_temp,$sql);
	}
	###  สร้าง โฟล์เดอร์
	function xRmkdir($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
	mkdir($way);
	}
}
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet" />
<SCRIPT type=text/javascript src="../../common/jscriptfixcolumn/jquery.min.js"></SCRIPT>
<SCRIPT type=text/javascript src="../../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></SCRIPT>
<title>รายงานการจัดการไฟล์ ก.พ.7 ต้นฉบับ และ รูปภาพ ก.พ. 7</title>
</head>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>
<SCRIPT type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
			$(".tbl4").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
			$(".tbl5").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
        });
</SCRIPT>

<body>
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="1" cellpadding="3" style="display:<?=$sent_secid?"none":"block"?>" >
        <tr>
          <td width="12%" align="right"><strong>เลือกโปรไฟล์ :</strong></td>
          <td width="55%">
          <select name="profile_id" id="profile_id" onchange="gotourl(this)">
          <option value="">เลือกโฟล์ไฟล์</option>
      	<?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
		<option value="?profile_id=<?=$rsp[profile_id]?>&action=<?=$action?>&lv=<?=$lv?>&xsiteid=<?=$xsiteid?>&schoolid=<?=$schoolid?>&xtype=<?=$xtype?>" <?=$sel?>><?=$rsp[profilename]?></option>
		<?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
        </select> 
          
          </td>
          <td width="33%">&nbsp;</td>
        </tr>
      </table>
    </form><br />

    
<? if($action == ""){
	
		if($lv == ""){
			$arr1 = CountPersonPdfPicCmss($profile_id);
			$arrpic = CountPicsysTemp($profile_id);
			$arrpdftime =GetmaxUpdatePDF(); // วันที่มีการนำเข้าไฟล pdf ล่าสุด
			$arrpictime = GetmaxUploadPic($profile_id); // เวลาล่าสุดที่ทำาการปรับปรุงข้อมูล
			$arrdatemax = GetmaxTimedate($profile_id); // เวลาล่าสุดของเขตในการปรับปรุงข้อมูล
			$xtitle = "สำนักงานเขตพื้นที่การศึกษา";
		}else if($lv == "1"){
			$arr1 = CountPersonPdfPicCmss($profile_id,$xsiteid);
			$arrpic = CountPicsysTemp($profile_id,$xsiteid);
			$arrpdftime =GetmaxUpdatePDF($profile_id,$xsiteid); // วันที่มีการนำเข้าไฟล pdf ล่าสุด
			$arrpictime = GetmaxUploadPic($profile_id,$xsiteid); // เวลาล่าสุดที่ทำาการปรับปรุงข้อมูล
			$arrdatemax = GetmaxTimedate($profile_id,$xsiteid); // เวลาล่าสุดของเขตในการปรับปรุงข้อมูล
			$xtitle = "หน่วยงาน";
		}//end if($lv == ""){
		//echo "<pre>";
		//print_r($arrpic);

	?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><strong>รายงาน ณ วันที่ <?=GetDateThaiFull(date("Y-m-d"));?></strong>&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><? if($lv == "1"){ echo "<a href='?action=&lv=&profile_id=$profile_id'>สรุปภาพรวม</a> ::".ShowAreaSortName($xsiteid);}?></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
  <tr>
  <td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bordercolor="#000000" class="tbl3">

  <tr>
    <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
    <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong><?=$xtitle?></strong></td>
    <td height="24" colspan="4" align="center" bgcolor="#CCCCCC"><strong>จำนวนบุคลากร(คน)</strong></td>
    <td height="24" colspan="3" align="center" bgcolor="#CCCCCC"><strong>จำนวนไฟล์ ก.พ.7 ต้นฉบับ(คน)</strong></td>
    <td height="24" colspan="4" align="center" bgcolor="#CCCCCC"><strong>จำนวนรูปภาพเจ้าของทะเบียนประวัติ</strong></td>
    </tr>
  <tr>
    <td align="center" bgcolor="#CCCCCC"><strong>ทั้งหมด</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>พร้อมนำเข้าระบบ</strong></td>
    <td height="24" align="center" bgcolor="#CCCCCC"><strong>นำเข้าระบบcmss</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>ที่ค้างนำเข้า</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>จำนวน</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>จำนวนที่ค้าง</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>เวลานำเข้าล่าสุด</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>รูประบบ<br />
      (checklist)<br />
(รูป)</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>รูประบบ <br />
      cmss<br />
(รูป)</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>รูปค้าง<br />
      นำเข้า<br />
(รูป)</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>เวลานำเข้าล่าสุด</strong></td>
    </tr>
  <?
	$j = 1;
	if($lv == ""){ // กรณีเป็นภาพรวมแยกรายเขต
	$sql = "SELECT eduarea.secid, eduarea.name_proth, eduarea.office_ref, eduarea.secname, eduarea.provid, eduarea.partid, eduarea.siteid,eduarea.secname_short,
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
if(substring(eduarea.secid,1,1) ='0',cast(secid as SIGNED),9999) as idsite,
if(substring(eduarea.secid,1,1)=0,'spm','spp') as subsite
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata' AND
eduarea_config.profile_id =  '$profile_id' $conw1
order by idsite, eduarea.secname  ASC";
}else if($lv == "1"){
	$sql = "SELECT id,siteid,office,if(siteid=id,9999,0) as orderid  FROM allschool WHERE siteid='$xsiteid' ORDER BY orderid DESC,office ASC";
}//end 	if($lv == ""){ // กรณีเป็นภาพรวมแยกรายเขต

	$result = mysql_db_query(DB_MASTER,$sql) ;
	$i=0;
	while($rs = mysql_fetch_assoc($result)){	
	
	if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
	if($lv == ""){ /// กรณีแสดงเป็นเขตพื้นที่การศึกษา
	$xsiteid = $rs[secid];
	$xschoolid = "";
			$idsite = $rs[secid]; // จำนวนบุคลากรทั้งหมด	
				$xnumall = $arr1[$idsite]['numall']; // จำนวนบุคลากรทั้งหมด
				$xnumpass =  $arr1[$idsite]['numpass']; // จำนวนบุคลากรที่พร้อมนำเข้าระบบ
				$xnum_imp = $arr1[$idsite]['num_imp']; // จำนวนที่นำเข้าระบบไปแล้ว
				$diff_import = $arr1[$idsite]['diffnum_imp'];// จำนวนที่ค้างนำเข้า
				$xnumpic = $arr1[$idsite]['numpic'];// จำนวนรูปทั้งหมดในเช็คlist
				$xnumpdf = $arr1[$idsite]['numpdf'];// จำนวน PDF ทัังหมดในระบบ
				$numpicsys = $arrpic[$idsite]['numpic']; // จำนวนรูปในระบบ cmss
			
		
				$orgname1 = str_replace("สพท.","",$rs[secname_short]); // หน่วยงาน
				if($xnumall > 0){
						$link_org = "<a href='?action=&lv=1&xsiteid=$idsite&profile_id=$profile_id'>$orgname1</a>";
				}else{
						$link_org = "$orgname1";
				}//end if($xnumall > 0){
				
				$diff_pdf = $xnumpass-$xnumpdf; // จำนวน pdf ที่ค้างนำเข้าระบบ
				$diff_pic = $xnumpic-$numpicsys;// จำนวนรูปที่ค้าง			
		
		if($xnumpdf > 0){
				$datepdf = $arrpdftime[$idsite];
				if($datepdf == ""){
					$datepdf = $arrdatemax[$idsite];
				}
		}else{
				$datepdf = "";	
		}// end if($xnumpdf > 0){
	
		if($numpicsys > 0){
				$datepic = $arrpictime[$idsite];
				if($datepic == ""){
					$datepic = $arrdatemax[$idsite];	
				}
		}else{
				$datepic = "";	
		}// end if($xnumpdf > 0){
			
#######   $lv == "1"			 //กรณีเป็นโรงเรียน
	}else{// กรณ๊ login เป็นโรงเรียน
	
	//echo "<pre>";
//	print_r($arrpic);
		$xsiteid = $rs[siteid];
		$xschoolid = $rs[id];
			$idsite = $rs[id];	
				$xnumall = $arr1[$idsite]['numall']; // จำนวนบุคลากรทั้งหมด
				$xnumpass =  $arr1[$idsite]['numpass']; // จำนวนบุคลากรที่พร้อมนำเข้าระบบ
				$xnum_imp = $arr1[$idsite]['num_imp']; // จำนวนที่นำเข้าระบบไปแล้ว
				$diff_import = $arr1[$idsite]['diffnum_imp'];// จำนวนที่ค้างนำเข้า
				$xnumpic = $arr1[$idsite]['numpic'];// จำนวนรูปทั้งหมดในเช็คlist
				$xnumpdf = $arr1[$idsite]['numpdf'];// จำนวน PDF ทัังหมดในระบบ
				$numpicsys = $arrpic[$idsite]['numpic']; // จำนวนรูปในระบบ cmss
				
				#######   กำหนดชื่อหน่วยงานโรงเรียน
				if($rs[siteid] != $rs[id]){ // กรณีไม่ใชเขต
					$orgname1 = "โรงเรียน".$rs[office];
				}else{
					$orgname1 = "$rs[office]";	
				}//end if($rs[siteid] != $rs[id]){ 
				
				
				if($xnumall > 0){
						$link_org = "<a href='?action=view&lv=1&xsiteid=$rs[siteid]&xschoolid=$idsite&profile_id=$profile_id'>$orgname1</a>";
				}else{
						$link_org = "$orgname1";
				}//end if($xnumall > 0){

		
				$diff_pdf = $xnumpass-$xnumpdf; // จำนวน pdf ที่ค้างนำเข้าระบบ
				$diff_pic = $xnumpic-$numpicsys;// จำนวนรูปที่ค้าง			
		
		if($xnumpdf > 0){
				$datepdf = $arrpdftime[$idsite];
				if($datepdf == ""){
					$datepdf = $arrdatemax[$idsite];
				}
		}else{
				$datepdf = "";	
		}// end if($xnumpdf > 0){
	
		if($numpicsys > 0){
				$datepic = $arrpictime[$idsite];
				if($datepic == ""){
					$datepic = $arrdatemax[$idsite];	
				}
		}else{
				$datepic = "";	
		}// end if($xnumpdf > 0){
	}//end if($lv == ""){



	?>
  <tr bgcolor="<?=$bg?>">
    <td width="3%" height="24" align="center"><?=$i?></td>
    <td width="17%"><?=$link_org?></td>
    <td width="7%" align="center"><? if($xnumall > 0){ echo "<a href='?action=view_data&xsiteid=$xsiteid&xschoolid=$xschoolid&xtype=Nall'>".number_format($xnumall)."</a>";}else{ echo "0";}?></td>
    <td width="9%" align="center"><? if($xnumpass > 0){ echo "<a href='?action=view_data&xsiteid=$xsiteid&xschoolid=$xschoolid&xtype=Npass'>".number_format($xnumpass)."</a>";}else{ echo "0";}?></td>
    <td width="9%" align="center"><? if($xnum_imp > 0){ echo "<a href='?action=view_data&xsiteid=$xsiteid&xschoolid=$xschoolid&xtype=Nimp'>".number_format($xnum_imp)."</a>";}else{ echo "0";}?></td>
    <td width="8%" align="center"><? if($diff_import > 0){ echo "<a href='?action=view_data&xsiteid=$xsiteid&xschoolid=$xschoolid&xtype=Ndimp'>".number_format($diff_import)."</a>";}else{ echo "0";}?></td>
    <td width="7%" align="center"><? if($xnumpdf > 0){ echo "<a href='?action=view_data&xsiteid=$xsiteid&xschoolid=$xschoolid&xtype=Npdf'>".number_format($xnumpdf)."</a>";}else{ echo "0";}?></td>
    <td width="7%" align="center"><? if($diff_pdf > 0){ echo "<a href='?action=view_data&xsiteid=$xsiteid&xschoolid=$xschoolid&xtype=Ndpdf'>".number_format($diff_pdf)."</a>";}else{ echo "0";}?></td>
    <td width="8%" align="center"><?=$datepdf?></td>
    <td width="6%" align="center"><? /*if($xnumpic > 0 ){ echo "<a href='?action=view_data&xsiteid=$xsiteid&xschoolid=$xschoolid&xtype=Npic'>".number_format($xnumpic)."</a>";}else{ echo "0";}*/ echo number_format($xnumpic);?></td>
    <td width="5%" align="center"><? /*if($numpicsys > 0){ echo "<a href='?action=view_data&xsiteid=$xsiteid&xschoolid=$xschoolid&xtype=Npicsys'>".number_format($numpicsys)."</a>";}else{ echo "0";}*/ echo number_format($numpicsys);?></td>
    <td width="6%" align="center"><? /* if($diff_pic > 0){ echo "<a href='?action=view_data&xsiteid=$xsiteid&xschoolid=$xschoolid&xtype=Npicdiff'>".number_format($diff_pic)."</a>";}else{ echo "0";}*/ echo number_format($diff_pic);?></td>
    <td width="8%" align="center"><?=$datepic?></td>
    </tr>
 <? 
 $j++ ;
 	$sumxnumall += $xnumall;
 	$sumxnumpass += $xnumpass;
	$sumxnum_imp += $xnum_imp;
	$sumdiff_import += $diff_import;
	$sumxnumpdf += $xnumpdf;
	$sumdiff_pdf += $diff_pdf;
	$sumxnumpic += $xnumpic;
	$sumnumpicsys += $numpicsys;
	$sumdiff_pic += $diff_pic;
 
 }  // end while
  ?> 
  <tr bgcolor="<?=$bgcolor1?>">
    <td height="24" colspan="2" align="right" bgcolor="#FFFFFF"><strong>รวม :</strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sumxnumall)?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sumxnumpass)?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sumxnum_imp)?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sumdiff_import)?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sumxnumpdf)?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sumdiff_pdf)?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sumxnumpic)?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sumnumpicsys)?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF"><strong>
      <?=number_format($sumdiff_pic)?>
    </strong></td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
</table>
</td></tr></table>

<? } // end if($action == ""){

if($action == "view"){
	
	      	$sql_chk = "SELECT if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0',1,0) as statusfile,siteid,idcard,prename_th,name_th,surname_th,position_now,pic_num,profile_id FROM tbl_checklist_kp7 WHERE siteid='$xsiteid' and schoolid='$xschoolid' AND  `profile_id` LIKE '$profile_id' ORDER  BY statusfile desc";
		$result_chk = mysql_db_query($dbname_temp,$sql_chk);
		$i=0;

		


?>
<br />
  <tr>
    <td align="left"><? echo "<a href='?action=&lv=&profile_id=$profile_id'>สรุปภาพรวม</a> ::<a href='?action=&lv=1&xsiteid=$xsiteid&profile_id=$profile_id'>".ShowAreaSortName($xsiteid)."</a> :: ".show_school($xschoolid);?></td>
  </tr>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl4">
      <tr>
        <td colspan="9" align="center" bgcolor="#CCCCCC"><strong>รายงานการจัดทำข้อมูลก.พ.7ของทีมแสกนและทีมตัดรูป &nbsp; <?=ShowAreaSortName($xsiteid);?><?=show_school($xschoolid);?></strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>รหัสบัตร</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="17%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>สถานะเอกสาร<br />
พร้อมนำเข้าระบบ</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>ไฟล์ ก.พ.7 ต้นฉบับ</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>จำนวนรูปในระบบ <br />
          checklist(รูป)</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>จำนวนรูปในระบบ <br />
          CMSS (ข้อมูลปฐมภูมิ)(รูป)</strong></td>
        <td width="10%" align="center" bgcolor="#CCCCCC"><strong>รูปค้างนำเข้าระบบ(รูป)</strong></td>
      </tr>
      <?
		

	//echo "<pre>";
	//print_r($arrid);
	$kp7pathx = "../../../".PATH_KP7_FILE."/";
		while($rs_c = mysql_fetch_assoc($result_chk)){
			if ($bgcolor1 == "#DDDDDD"){  $bgcolor1 = "#EFEFEF"  ; } else {$bgcolor1 = "#DDDDDD" ;}
			$kp7filex = $kp7pathx."$rs_c[siteid]/".$rs_c[idcard].".pdf";
		$i++;
		$num_pics = GetCountPicSys($rs_c[siteid],"",$rs_c[idcard],$profile_id); // จำนวนรูปในระบบ
		$num_picchecklist = $rs_c[pic_num]; // จำนวนรูปที่นับจาก checklist
		$diff_pic = $num_picchecklist-$num_pics;
		
		if(is_file($kp7filex)){
				$img_pdf = "<a href='$kp7filex' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a>";
		}else{
				$img_pdf = "";			
		}
		
		if($rs_c[statusfile] == "1"){
			$imgsfile = "<img src='../../images_sys/circle5.gif' width='19' height='19' title='สถานะเอกสารพร้อมนำเข้าระบบ'>";	
		}else{
			$imgsfile = "<img src='../../images_sys/circle1.gif' width='19' height='19' title='สถานะเอกสารไม่พร้อมนำเข้าระบบ'>";	
		}
		

	  ?>
      <tr bgcolor="<?=$bgcolor1?>">
        <td align="center"><?=$i?></td>
        <td align="center"><? echo "$rs_c[idcard]";?></td>
        <td align="left"><? echo "$rs_c[prename_th]$rs_c[name_th]  $rs_c[surname_th]";?></td>
        <td align="left"><? echo $rs_c[position_now];?></td>
        <td align="center"><? echo $imgsfile;?></td>
        <td align="center"><? echo $img_pdf;?></td>
        <td align="center"><?=number_format($num_picchecklist)?></td>
        <td align="center"><?=number_format($num_pics)?></td>
        <td align="center"><?=number_format($diff_pic);?></td>
      </tr>
      <?
	  $numchall += $num_picchecklist;
	  $numpicsall += $num_pics;
	  $numdiffall += $diff_pic;
		}//end	while($rs_c = mysql_fetch_assoc($result_chk)){
	  ?>

      <tr>
        <td colspan="6" align="right" bgcolor="#CCCCCC"><strong>&#3619;&#3623;&#3617; :</strong></td>
        <td align="center" bgcolor="#CCCCCC"><?=number_format($numchall)?></td>
        <td align="center" bgcolor="#CCCCCC"><?=number_format($numpicsall)?></td>
        <td align="center" bgcolor="#CCCCCC"><?=number_format($numdiffall)?></td>
      </tr>

    </table></td>
  </tr>
</table>
<?
}//end if($action == "view"){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<? if($action == "view_data"){
		
	$arrword = array("Nall"=>"จำนวนบุคลากรทั้งหมด","Npass"=>"จำนวนบุคลากรที่พร้อมนำเข้าระบบ","Nimp"=>"จำนวนบุคลากรที่นำเข้าไปในระบบ cmss","Ndimp"=>"จำนวนบุคลากรที่ค้างนำเข้าระบบ cmss","Npdf","จำนวนบุคลากรที่นำเข้าไฟล์ ก.พ.7 ต้นฉบับ","Ndpdf"=>"จำนวนบุคลากรที่ค้างนำเข้าไฟล์ ก.พ. 7 ต้นฉบับ","Npic"=>"จำนวนบุคลากรที่นับจำนวนรูป ก.พ.7 ในระบบ cheklist","Npicsys"=>"จำนวนบุคลากรที่นำเข้ารูปภาพ ก.พ.7 ในระบบ cmss","Npicdiff"=>"จำนวนบุคลากรที่ค้างนำเข้ารูป ก.พ.7");		
	if($xtype == ""){	$xtype = "Nall";}
	### เงือ่นไขเอกสารสมบูรณ์เท่านั้น
	$conTrue = " AND status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0' ";
	
	if($xtype == "Nall"){
		
		if($xschoolid != ""){
			$conw = " AND siteid='$xsiteid' AND schoolid='$xschoolid'";	
		}else{
			$conw = " AND siteid='$xsiteid'";	
		}//end if($xschoolid != ""){
	#### SQL เอกสารทั้งหมด
	$sqlch = "SELECT if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0',1,0) as statusfile,siteid,idcard,prename_th,name_th,surname_th,position_now,pic_num,profile_id,schoolid
	 FROM tbl_checklist_kp7 WHERE  profile_id='$profile_id' $conw  ORDER  BY statusfile desc";
		
	
	}else if($xtype == "Npass"){
		if($xschoolid != ""){
			$conw = " AND siteid='$xsiteid' AND schoolid='$xschoolid' $conTrue  ";	
		}else{
			$conw = " AND siteid='$xsiteid' $conTrue";	
		}//end if($xschoolid != ""){
	#### sql เอกสารที่สมบูรณ์เท่านั้น
	$sqlch = "SELECT if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0',1,0) as statusfile,siteid,idcard,prename_th,name_th,surname_th,position_now,pic_num,profile_id,schoolid
	 FROM tbl_checklist_kp7 WHERE  profile_id='$profile_id' $conw  ORDER  BY statusfile desc";
			
	}else if($xtype == "Nimp"){
		if($xschoolid != ""){
			$conw = " AND t1.siteid='$xsiteid' AND t1.schoolid='$xschoolid'   ";	
		}else{
			$conw = " AND t1.siteid='$xsiteid' ";	
		}//end if($xschoolid != ""){
###### จำนวนที่นำเข้าระบบ cmss ไแล้ว
		$sqlch = "SELECT
if(t1.status_numfile='1' AND t1.status_file='1' AND t1.status_check_file='YES' AND (t1.mainpage Is Null OR t1.mainpage='' OR t1.mainpage='1') AND t1.status_id_false='0',1,0) AS statusfile,
t1.siteid,
t1.idcard,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t1.pic_num,
t1.profile_id,
t1.schoolid,
t2.idcard as idcard_imp
FROM
tbl_checklist_kp7 as t1
Inner Join tbl_check_data  as t2 ON t1.idcard = t2.idcard AND t2.profile_id ='$profile_id' AND t1.siteid = t2.secid and  t2.status_tranfer_data='1'  
WHERE  t1.profile_id='$profile_id'  $conw  AND t1.status_numfile='1' and t1.status_file='1' and t1.status_check_file='YES' and (t1.mainpage IS NULL  or t1.mainpage='' or t1.mainpage='1') and t1.status_id_false='0' ";
			
	}else if($xtype == "Ndimp"){
		
		if($xschoolid != ""){
			$conw = " AND t1.siteid='$xsiteid' AND t1.schoolid='$xschoolid'   ";	
		}else{
			$conw = " AND t1.siteid='$xsiteid' ";	
		}//end if($xschoolid != ""){
###### จำนวนที่นำเข้าระบบ cmss ไแล้ว
		$sqlch = "SELECT
if(t1.status_numfile='1' AND t1.status_file='1' AND t1.status_check_file='YES' AND (t1.mainpage Is Null OR t1.mainpage='' OR t1.mainpage='1') AND t1.status_id_false='0',1,0) AS statusfile,
t1.siteid,
t1.idcard,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.position_now,
t1.pic_num,
t1.profile_id,
t1.schoolid,
t2.idcard as idcard_imp
FROM
tbl_checklist_kp7 as t1
Left Join tbl_check_data  as t2 ON t1.idcard = t2.idcard AND t2.profile_id ='$profile_id' AND t1.siteid = t2.secid and  t2.status_tranfer_data='1'  
WHERE  t1.profile_id='$profile_id'  $conw  AND t1.status_numfile='1' and t1.status_file='1' and t1.status_check_file='YES' and (t1.mainpage IS NULL  or t1.mainpage='' or t1.mainpage='1') and t1.status_id_false='0' AND  t2.idcard IS NULL ";
		
	}else if($xtype == "Npdf"){
		
		if($xschoolid != ""){
			$conw = " AND siteid='$xsiteid' AND schoolid='$xschoolid' and page_upload>0  $conTrue  ";	
		}else{
			$conw = " AND siteid='$xsiteid' and page_upload>0 $conTrue";	
		}//end if($xschoolid != ""){
	#### sql เอกสารที่สมบูรณ์เท่านั้น
	$sqlch = "SELECT if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0',1,0) as statusfile,siteid,idcard,prename_th,name_th,surname_th,position_now,pic_num,profile_id,schoolid
	 FROM tbl_checklist_kp7 WHERE  profile_id='$profile_id' $conw  ORDER  BY statusfile desc";

			
	}else if($xtype == "Ndpdf"){
		
		if($xschoolid != ""){
			$conw = " AND siteid='$xsiteid' AND schoolid='$xschoolid' and (page_upload < 1 or page_upload IS NULL)  $conTrue  ";	
		}else{
			$conw = " AND siteid='$xsiteid'  and (page_upload < 1 or page_upload IS NULL) $conTrue";	
		}//end if($xschoolid != ""){
	#### sql เอกสารที่สมบูรณ์เท่านั้น
	$sqlch = "SELECT if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0',1,0) as statusfile,siteid,idcard,prename_th,name_th,surname_th,position_now,pic_num,profile_id,schoolid
	 FROM tbl_checklist_kp7 WHERE  profile_id='$profile_id' $conw  ORDER  BY statusfile desc";

			
	}else if($xtype == "Npic" or $xtype == "Npicsys" or $xtype == "Npicdiff" ){
		
		if($xschoolid != ""){
			$conw = " AND siteid='$xsiteid' AND schoolid='$xschoolid'   $conTrue  ";	
		}else{
			$conw = " AND siteid='$xsiteid'  $conTrue";	
		}//end if($xschoolid != ""){
	#### sql เอกสารที่สมบูรณ์เท่านั้น
	$sqlch = "SELECT if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0',1,0) as statusfile,siteid,idcard,prename_th,name_th,surname_th,position_now,pic_num,profile_id,schoolid
	 FROM tbl_checklist_kp7 WHERE  profile_id='$profile_id' $conw  ORDER  BY statusfile desc";

	}else{
		if($xschoolid != ""){
			$conw = " AND siteid='$xsiteid' AND schoolid='$xschoolid'";	
		}else{
			$conw = " AND siteid='$xsiteid'";	
		}//end if($xschoolid != ""){
	#### SQL เอกสารทั้งหมด
	$sqlch = "SELECT if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0',1,0) as statusfile,siteid,idcard,prename_th,name_th,surname_th,position_now,pic_num,profile_id,schoolid
	 FROM tbl_checklist_kp7 WHERE  profile_id='$profile_id' $conw  ORDER  BY statusfile desc";
	}//end if($xtype == "Nall"){
	
	?>
      <tr>
    <td><? echo "<a href='?action=&lv=&profile_id=$profile_id'>สรุปภาพรวม</a> ::".ShowAreaSortName($xsiteid);?></td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl5">
      <tr>
        <td colspan="10" align="center" bgcolor="#CCCCCC"><strong>รายงานการจัดทำข้อมูลก.พ.7ของทีมแสกนและทีมตัดรูป( <?=$arrword[$xtype]?> ) &nbsp; <?=ShowAreaSortName($xsiteid);?></strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="10%" align="center" bgcolor="#CCCCCC"><strong>รหัสบัตร</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong>หน่วยงาน</strong></td>
        <td width="10%" align="center" bgcolor="#CCCCCC"><strong>สถานะเอกสาร<br />
พร้อมนำเข้าระบบ</strong></td>
        <td width="9%" align="center" bgcolor="#CCCCCC"><strong>ไฟล์ ก.พ.7<br />
ต้นฉบับ</strong></td>
        <td width="9%" align="center" bgcolor="#CCCCCC"><strong>จำนวนรูปในระบบ <br />
          checklist(รูป)</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>จำนวนรูปในระบบ <br />
          CMSS (ข้อมูลปฐมภูมิ)(รูป)</strong></td>
        <td width="9%" align="center" bgcolor="#CCCCCC"><strong>รูปค้างนำเข้าระบบ(รูป)</strong></td>
      </tr>
      <?
	//  echo $sqlch;
		###  $xtype == "Npicsys" or $xtype == "Npicdiff"
	$result_chk = mysql_db_query($dbname_temp,$sqlch);
	$kp7pathx = "../../../".PATH_KP7_FILE."/";
	$flagch = 0;
		while($rs_c = mysql_fetch_assoc($result_chk)){
			if ($bgcolor1 == "#DDDDDD"){  $bgcolor1 = "#EFEFEF"  ; } else {$bgcolor1 = "#DDDDDD" ;}
			$kp7filex = $kp7pathx."$rs_c[siteid]/".$rs_c[idcard].".pdf";
		$i++;
		$num_pics = GetCountPicSys($rs_c[siteid],"",$rs_c[idcard],$profile_id); // จำนวนรูปในระบบ
		#### ตรวจสอบการนำเข้ารูป
		if($xtype == "Npicsys"){ // จำนวนที่ นำรูปเข้าไปในระบบ
				if($rs_c[pic_num] > 0 and $num_pics > 0){
					$flagch = 1;
				}else{
					$flagch = 0;	
				}
		}else if($xtype == "Npicdiff"){ // จำนวนที่ค้าง
				if($rs_c[pic_num] > 0 and $num_pics > 0){
					$flagch = 0;
				}else{
					$flagch = 1;	
				}

		}else{
			$flagch = 1;	
		}//end 	if($xtype == "Npicsys"){ 
##################################################  แสดงผลตามเงื่อนไขที่เป็นจริง #######################  		
	if($flagch == "1"){ // แสดงผลตามเงื่อนไขที่เป็นจริง
		
		$num_picchecklist = $rs_c[pic_num]; // จำนวนรูปที่นับจาก checklist
		$diff_pic = $num_picchecklist-$num_pics;
		
		if(is_file($kp7filex)){
				$img_pdf = "<a href='$kp7filex' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' alt='ก.พ.7 สำเนาจากต้นฉบับ' width='16' height='16' border='0'></a>";
		}else{
				$img_pdf = "";			
		}
		
		if($rs_c[statusfile] == "1"){
			$imgsfile = "<img src='../../images_sys/circle5.gif' width='19' height='19' title='สถานะเอกสารพร้อมนำเข้าระบบ'>";	
		}else{
			$imgsfile = "<img src='../../images_sys/circle1.gif' width='19' height='19' title='สถานะเอกสารไม่พร้อมนำเข้าระบบ'>";	
		}
		

	  ?>
      <tr bgcolor="<?=$bgcolor1?>">
        <td align="center"><?=$i?></td>
        <td align="center"><? echo "$rs_c[idcard]";?></td>
        <td align="left"><? echo "$rs_c[prename_th]$rs_c[name_th]  $rs_c[surname_th]";?></td>
        <td align="left"><? echo $rs_c[position_now];?></td>
        <td align="left"><?=show_school($rs_c[schoolid])?></td>
        <td align="center"><? echo $imgsfile;?></td>
        <td align="center"><? echo $img_pdf;?></td>
        <td align="center"><?=number_format($num_picchecklist)?></td>
        <td align="center"><?=number_format($num_pics)?></td>
        <td align="center"><?=number_format($diff_pic);?></td>
      </tr>
              <?
			  $numpic_chall += $num_picchecklist;
			  $numpic_sysall += $num_pics;
			  $numdiff_all += $diff_pic;
	}//end 	if($flagch == "1"){ // แสดงผลตามเงื่อนไขที่เป็นจริง
		}//end	while($rs_c = mysql_fetch_assoc($result_chk)){
	  ?>

      <tr>
        <td colspan="7" align="right" bgcolor="#CCCCCC"><strong>รวม :</strong></td>
        <td align="center" bgcolor="#CCCCCC"><?=number_format($numpic_chall)?></td>
        <td align="center" bgcolor="#CCCCCC"><?=number_format($numpic_sysall)?></td>
        <td align="center" bgcolor="#CCCCCC"><?=number_format($numdiff_all)?></td>
      </tr>

    </table></td>
  </tr>
 <?
}//end if($action == "view_data"){
 ?>
  <tr>
    <td><? if($action != ""){?>หมายเหตุ ::&nbsp;&nbsp;<img src="../../images_sys/circle5.gif" border="0" width="19" height="19"> คือ สถานเอกสารที่พร้อมดำเนินการจัดทำข้อมูลปฐมภูมิ<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../../images_sys/circle1.gif" border="0" width="19" height="19"> คือ สถานะเอกสารที่ไม่พร้อมดำเนินการจัดทำข้อมูลปฐมภูมิ<? }//end if($action == ""){?>
</td>
  </tr>
</table>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>