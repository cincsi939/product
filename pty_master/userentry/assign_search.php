<?
session_start();
$ApplicationName	= "checklist_kp7_management_assign";
$module_code 		= "checklistkp7_assign"; 
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

include("../../config/conndb_nonsession.inc.php");
include("../../common/common_competency.inc.php");
include("checklist2.inc.php");
$time_start = getmicrotime();
$db_temp = $dbname_temp;
$db_name = $dbedubkk_userentry;

$report_title = "มอบหมายงาน scan เอกสารทะเบียนประวัติต้นฉบับ";

$year1 = (date("Y")+543)."-09-30";

function xdevidepage($total, $kwd , $sqlencode ){
	$per_page		= 11;	
	$page_all 		= $total;
	global $page,$xsearch,$idcard,$name_th,$surname_th,$ticketid,$xprofile_id;

	if($total >= 1){
		$table	= "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
		$table	= $table."<tr align=\"right\">";
		$table	= $table."<td width=\"80%\" align=\"left\" height=\"30\">&nbsp;";
				
		if($page_all <= $per_page){
			$min		= 1;
			$max		= $page_all;
		} elseif($page_all > $per_page && ($page - 5) >= 2 ) {			
			$min		= $page - 5;
			$max		= (($page + 5) > $page_all) ? $page_all : $page + 5;
		} else {
			$min	= 1;
			$max	= $per_page; 			
		}
	
		if($min >= 4){ 
			$table .= "<a href=\"?page=1&xsearch=$xsearch&idcard=$idcard&name_th=$name_th&surname_th=$surname_th&ticketid=$ticketid&xprofile_id=$xprofile_id&displaytype=people".$kwd."\"><u><font color=\"black\">หน้าแรก</font></u></a>&nbsp;"; 
		}
		
		for($i=$min;$i<=$max;$i++){			
			$i	= str_pad($i, 2, "0", STR_PAD_LEFT);
			if($i != $page){
				$table .= "<a href=\"?page=".$i."&xsearch=$xsearch&idcard=$idcard&name_th=$name_th&surname_th=$surname_th&ticketid=$ticketid&xprofile_id=$xprofile_id&displaytype=people". $kwd."\"><span class=\"pagelink\">".$i."</span></a>";
			} else {
				$table .= "<span class=\"page\">".$i."</span>";
			}	
		}
		
		if(($page + 5) <= $page_all){ 
			$table .= "&nbsp;<a href=\"?page=".$page_all."&xsearch=$xsearch&idcard=$idcard&name_th=$name_th&surname_th=$surname_th&ticketid=$ticketid&xprofile_id=$xprofile_id&displaytype=people". $kwd."\"><u><font color=\"black\">หน้าสุดท้าย</font></u></a>"; 
		}
		
		if($page_all > 1){
			$table .= "&nbsp;<a href=\"?page=".($page_all+1)."&xsearch=$xsearch&idcard=$idcard&name_th=$name_th&surname_th=$surname_th&ticketid=$ticketid&xprofile_id=$xprofile_id&displaytype=people". $kwd."\"><u><font color=\"black\">แสดงทั้งหมด</font></u></a>";
		}
#		$table .= "&nbsp;<a href=\"search_excel.php?page=$sqlencode\"><u><font color=\"black\">ส่งออกรูปแบบ MS Excel </font></u></a>";

		unset($max,$i,$min);
	
		$table	= $table."</td>";	
		$table	= $table."<td width=\"20%\">จำนวนทั้งหมด <b>".number_format($page_all, 0, "", ",")."</b>&nbsp;หน้า&nbsp;</td>";
		$table	= $table."</tr>";
		$table	= $table."</table>";
	}
 	return $table;
}


?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript">
function confirmDelete(delUrl) {
//  if (confirm("คุณแน่ใจที่จะลบข้อมูล cmss จริงหรือไม่")) {
//  window.open("Sample.htm",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
    //document.location = delUrl;
	//document.location =  
	window.open(delUrl,null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
 // }
}

function confirmDelete1(delUrl) {
  if (confirm("คุณแน่ใจที่จะลบข้อมูลใช่หรือไม่?")) {
  //window.open("Sample.htm",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
    document.location = delUrl;
  }
}

</script>

<SCRIPT language=JavaScript>
function checkFields() {
	missinginfo1 = "";
	missinginfo = "";
	if (document.form1.staffname.value == "")  {	missinginfo1 += "\n- ช่องชื่อ ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.staffsurname.value == "")  {	missinginfo1 += "\n- ช่องนามสกุล ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.engname.value == "")  {	missinginfo1 += "\n- ช่องชื่อ(อังกฤษ) ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.engsurname.value == "")  {	missinginfo1 += "\n- ช่องนามสกุล(อังกฤษ) ไม่สามารถเป็นค่าว่าง"; }		
	if (missinginfo1 != "") { 
		missinginfo += "ไม่สามารถเพิ่มข้อมูลได้  เนื่องจาก \n";
		missinginfo +="_____________________________\n";
		missinginfo = missinginfo + missinginfo1  ;
		missinginfo += "\n___________________________";
		missinginfo += "\nกรุณาตรวจสอบ อีกครั้ง";
		alert(missinginfo);
		return false;
		}
	}
	
	
	
	
	
	/////////////////////  ajax
	
	
var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}
    
	
function refreshproductList() {
   var sent_siteid = document.getElementById("sent_siteid").value;
    if(sent_siteid == "" ) {
        clearproductList();
        return;
    }
    var url = "ajax_school.php?sent_siteid=" + sent_siteid;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStateChange;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}
    
function handleStateChange() {
    if(xmlHttp.readyState == 4) {
        if(xmlHttp.status == 200) {
            updateproductList();
        }
    }
}

function updateproductList() {
    clearproductList();
    var schoolid = document.getElementById("schoolid");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
		
			option = document.createElement("option");
		   option.setAttribute("value",0);
           option.appendChild(document.createTextNode("ไม่ระบุ"));
           schoolid.appendChild(option);


    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");
		  	option = document.createElement("option");
		   option.setAttribute("value",x[1]);
           option.appendChild(document.createTextNode(x[0]));
           schoolid.appendChild(option);
	}
    }
}

function clearproductList() {
    var schoolid = document.getElementById("schoolid");
    while(schoolid.childNodes.length > 0) {
              schoolid.removeChild(schoolid.childNodes[0]);
    }
}

</script>
<script language="javascript">

	function checkFm(){
		var age1 = document.form_m1.age_g1.value;
		var age2 = document.form_m1.age_g2.value;
		
		
	if(age1 > 0 && age2 > 0){ // ในกรณีค้นหาช่วงอายุราชการ 
		if(age1 > age2){
			alert("อายุราชการสิ้นสุดต้องไม่น้อยกว่าอายุราชการเริ่มต้น");
			document.form_m1.age_g2.focus();
			return false;
		}
	}
return true;		
	}

	function check_number(){
		var num1 = document.form_m1.person_no.value;
	 if (isNaN(num1)) {
      alert("กรุณาระบุเฉพาะตัวเลขเท่านั่น");
      document.form_m1.person_no.focus();
      return false;
      }

		
	}
	
	
function CheckFrom(){
	if(document.form1.activity_id.value == ""){
		alert("กรุณาระบุประเภทกิจกรรม");
		document.form1.activity_id.focus();
		return false;
	}
	
	if(document.form1.sdate_recive.value != "" || document.form1.edate_recive.value != ""){
		d1 =document.form1.sdate_recive.value.split("/");
	  	sdate_r = d1[2]+""+d1[1]+""+d1[0];
		d2 = document.form1.edate_recive.value.split("/");
		edare_r = d2[2]+""+d2[1]+""+d2[0];

		if(sdate_r > edare_r){
				alert("ช่วงเวลารับเอกสารวันสินสุดต้องไม่น้อยกว่าวันเริ่ม");
				document.form1.edate_recive.focus();
				return false;
		}
	}
	
	if(document.form1.sdate_sent_true.value != "" || document.form1.edate_sent_true.value != ""){
		xd1 =document.form1.sdate_sent_true.value.split("/");
	  	sdate_s = xd1[2]+""+xd1[1]+""+xd1[0];
		xd2 = document.form1.edate_sent_true.value.split("/");
		edare_s = xd2[2]+""+xd2[1]+""+xd2[0];
		if(sdate_s > edare_s){
				alert("ช่วงเวลาส่งคืนเอกสารวันสินสุดต้องไม่น้อยกว่าวันเริ่ม");
				document.form1.edate_sent_true.focus();
				return false;
		}

	}

	return true;
}//end function CheckFrom(){	
</script>
<style type="text/css">
<!--
.style1 {
	color: #990000;
	font-style: italic;
}
-->
</style>
<style type="text/css">
.page {
	font						: 9px tahoma;
	font-weight			: bold; 	
	color					: #0280D5;	
	padding				: 1px 3px 1px 3px;
}	

.pagelink {
	font						: 9px tahoma;
	font-weight			: bold; 
	color					: #000000;
	text-decoration	: underline;
	padding				: 1px 3px 1px 3px;
}
.go {
	BORDER: #59990e 1px solid; 
	PADDING-RIGHT: 0.38em; 
	PADDING-LEFT: 0.38em; 
	FONT-WEIGHT: bold; 
	FONT-SIZE: 105%; 
	BACKGROUND: url(../application/hr3/hr_report/images/hdr_bg.png) #6eab26 repeat-x 0px -90px; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	COLOR: #fff; 
	MARGIN-RIGHT: 0.38em; 
	PADDING-TOP: 0px; 
	HEIGHT: 1.77em
}
#bf .go {
	FLOAT: none
}
.go:hover {
	BORDER: #3f8e00 1px solid; 
	BACKGROUND: url(../application/hr3/hr_report/images/hdr_bg.png) #63a218 repeat-x 0px -170px; 
}
.q {
	BORDER-RIGHT: #5595CC 1px solid; 
	PADDING-RIGHT: 0.7em; 
	BORDER-TOP: #5595CC 1px solid; 
	PADDING-LEFT: 0.7em; 
	FONT-WEIGHT: normal; FONT-SIZE: 105%; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	MARGIN: 0px 0.38em 0px 0px; 
	BORDER-LEFT: #5595CC 1px solid; 
	WIDTH: 300px; 
	PADDING-TOP: 0.29em; 
	BORDER-BOTTOM: #5595CC 1px solid; 
	HEIGHT: 1.39em

}
.tabberlive .tabbertab {
	background-color:#FFFFFF;
  height:200px;
}
</style>

</head>
<body bgcolor="#EFEFFF"><br>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form1" method="post" action="" onSubmit="return CheckFrom();">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#000000">
        <tr>
          <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="4" align="left" bgcolor="#EFEFFF"><img src="../../images_sys/globe.gif" width="19" height="18"><strong>ค้นหาเอกสารที่มอบหมายงาน</strong></td>
              </tr>
            <tr>
              <td width="14%" align="right" bgcolor="#EFEFFF"><strong>เลขบัตรประชาชน</strong></td>
              <td width="22%" align="left" bgcolor="#EFEFFF"><label>
                <input type="text" name="idcard" id="idcard" value="<?=$idcard?>">
              </label></td>
              <td width="13%" align="right" bgcolor="#EFEFFF"><strong>ข้อมูล ณ วันที่</strong></td>
              <td width="51%" align="left" bgcolor="#EFEFFF"><label>
                <select name="xprofile_id" id="xprofile_id" >
                  <option value="">เลือกโฟล์ไฟล์</option>
                  <?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($db_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $xprofile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
                  <option value="<?=$rsp[profile_id]?>" <?=$sel?>>
                    <?=$rsp[profilename]?>
                    </option>
                  <?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
                </select>
              </label></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#EFEFFF"><strong>ชื่อ</strong></td>
              <td align="left" bgcolor="#EFEFFF"><label>
                <input type="text" name="name_th" id="name_th" value="<?=$name_th?>">
              </label></td>
              <td align="right" bgcolor="#EFEFFF"><strong>ประเภทกิจกรรม</strong></td>
              <td align="left" bgcolor="#EFEFFF">
              <select name="activity_id" id="activity_id">
              <option value="">เลือกประเำภทกิจกรรม</option>
              <?
            	$sql_act = "SELECT * FROM tbl_checklist_activity ORDER BY activity ASC";
				$result_act = mysql_db_query($dbname_temp,$sql_act);
				while($rsac = mysql_fetch_assoc($result_act)){
					if($rsac[activity_id] == $activity_id){ $sel = "selected='selected'";}else{ $sel = "";}
					echo "<option value='$rsac[activity_id]' $sel>$rsac[activity]</option>";
				}//end while($rsac = mysql_fetch_assoc($result_act)){
			?>
              </select>
              </td>
            </tr>
            <tr>
              <td align="right" bgcolor="#EFEFFF"><strong>นามสกุล</strong></td>
              <td align="left" bgcolor="#EFEFFF">
                <input type="text" name="surname_th" id="surname_th" value="<?=$surname_th?>">
              </td>
              <td align="right" bgcolor="#EFEFFF"><strong>วันที่รับเอกสาร</strong></td>
              <td align="left" bgcolor="#EFEFFF"><INPUT name="date_recive" onFocus="blur();" value="<?=$date_recive?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.date_recive, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
              </tr>
            <tr>
              <td align="right" bgcolor="#EFEFFF"><strong>รหัสใบงาน</strong></td>
              <td align="left" bgcolor="#EFEFFF"><input type="text" name="ticketid" id="ticketid" value="<?=$ticketid?>"></td>
              <td align="right" bgcolor="#EFEFFF"><strong>วันที่ืส่งคืนเอกสาร</strong></td>
              <td align="left" bgcolor="#EFEFFF"><INPUT name="date_sent_true" onFocus="blur();" value="<?=$date_sent_true?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.date_sent_true, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
              </tr>
            <tr>
              <td align="right" bgcolor="#EFEFFF"><strong>ชื่อพนักงาน</strong></td>
              <td align="left" bgcolor="#EFEFFF">
                <select name="xstaffid" id="xstaffid">
                  <option value="">เลือกประเำภทกิจกรรม</option>
                  <?
              $sql_staff = "SELECT ".DB_USERENTRY.".keystaff.staffid, ".DB_USERENTRY.".keystaff.prename, ".DB_USERENTRY.".keystaff.staffname, ".DB_USERENTRY.".keystaff.staffsurname
FROM ".DB_USERENTRY.".keystaff
Inner Join  ".DB_CHECKLIST.".tbl_checklist_assign ON ".DB_USERENTRY.".keystaff.staffid =  ".DB_CHECKLIST.".tbl_checklist_assign.staffid
GROUP BY ".DB_USERENTRY.".keystaff.staffid 
ORDER BY staffname ASC";
				$result_staff = mysql_db_query($dbedubkk_userentry,$sql_staff);
				while($rst = mysql_fetch_assoc($result_staff)){
					if($rst[staffid] == $xstaffid){ $sel = "selected='selected'";}else{ $sel = "";}
					echo "<option value='$rst[staffid]' $sel>$rst[prename]$rst[staffname]  $rst[staffsurname]</option>";
				}//end while($rst = mysql_fetch_assoc($result_staff)){
				
			  ?>
                  </select>
                </td>
              <td align="right" bgcolor="#EFEFFF"><strong>สถานะยืมคืนเอกสาร</strong></td>
              <td align="left" bgcolor="#EFEFFF"><select name="status_sr_doc" id="status_sr_doc">
                <option value="">สถานะยืมคืนเอกสาร</option>
                <?
           		foreach($status_assign_doc as $key => $val){
					if($key == $status_sr_doc){ $sel = "selected='selected'";}else{ $sel = "";}
					echo "<option value='$key' $sel>$val</option>";	  	
				}//end foreach($status_assign_doc as $key => $val){
			  ?>
                </select></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#EFEFFF"><strong>ช่วงเวลารับเอกสาร </strong></td>
              <td colspan="3" align="left" bgcolor="#EFEFFF"><INPUT name="sdate_recive" onFocus="blur();" value="<?=$sdate_recive?>" size="10" readOnly>
                <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.sdate_recive, 'dd/mm/yyyy')"value="วันเดือนปี"> 
                &nbsp;<strong>ถึง</strong>
                <INPUT name="edate_recive" onFocus="blur();" value="<?=$edate_recive?>" size="10" readOnly>
                <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.edate_recive, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#EFEFFF"><strong>ช่วงเวลาส่งคืนเอกสาร </strong></td>
              <td colspan="3" align="left" bgcolor="#EFEFFF"><INPUT name="sdate_sent_true" onFocus="blur();" value="<?=$sdate_sent_true?>" size="10" readOnly>
                <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.sdate_sent_true, 'dd/mm/yyyy')"value="วันเดือนปี"> 
                &nbsp;<strong>ถึง </strong><INPUT name="edate_sent_true" onFocus="blur();" value="<?=$edate_sent_true?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.edate_sent_true, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
              </tr>
            <tr>
              <td align="right" bgcolor="#EFEFFF">&nbsp;</td>
              <td align="left" bgcolor="#EFEFFF">&nbsp;</td>
              <td colspan="2" align="left" bgcolor="#EFEFFF"><input type="submit" name="button" id="button" value="ค้นหา">
                <input type="reset" name="button2" id="button2" value="ล้างค่า">
                <input type="hidden" name="xsearch" value="search"></td>
            </tr>
            </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
      <tr>
    <td>&nbsp;</td>
  </tr>
  <?
  	if($xsearch == "search"){
		//echo "<pre>";
		//print_r($_POST);
		
		//echo sw_date_indb($date_recive);
  ?>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="11" align="left" bgcolor="#E1E1E1"><strong><img src="../../images_sys/emblem-documents.png" width="30" height="30">ข้อมูลการมอบหมายงาน</strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#E1E1E1"><strong>ลำดับ</strong></td>
        <td width="11%" align="center" bgcolor="#E1E1E1"><strong>เลขบัตรประชาชน</strong></td>
        <td width="11%" align="center" bgcolor="#E1E1E1"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="13%" align="center" bgcolor="#E1E1E1"><strong>หน่วยงาน / โรงเรียน</strong></td>
        <td width="12%" align="center" bgcolor="#E1E1E1"><strong>รหัสใบงาน</strong></td>
        <td width="11%" align="center" bgcolor="#E1E1E1"><strong>พนักงานสแกน</strong></td>
        <td width="9%" align="center" bgcolor="#E1E1E1"><strong>วันรับเอกสาร</strong></td>
        <td width="8%" align="center" bgcolor="#E1E1E1"><strong>วันกำหนด<br>
          คืนเอกสาร</strong></td>
        <td width="8%" align="center" bgcolor="#E1E1E1"><strong>วันคืนอก<br>
          สารจริง</strong></td>
        <td width="8%" align="center" bgcolor="#E1E1E1"><strong>สถานะ๊<br>
          upload<br>
          file</strong></td>
        <td width="5%" align="center" bgcolor="#E1E1E1"><strong>สถาน<br>
          คืนเอกสาร</strong></td>
      </tr>
      <?
	  
	  		$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
			$e			= (!isset($e) || $e == 0) ? 10 : $e ;
			$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 
			
			

      	if($idcard != ""){ $conv .= " AND idcard LIKE '%$idcard%'";}
		if($name_th != ""){ $conv .= " AND name_th LIKE '%$name_th%'";}
		if($surname_th != ""){ $conv .= " AND surname_th LIKE '%$surname_th%'";}
		if($ticketid != ""){ $conv .= " AND ticketid LIKE '%$ticketid%'";}
		if($xprofile_id != ""){ $conv .= " AND tbl_checklist_assign_detail.profile_id LIKE '%$xprofile_id%'";}
		if($xstaffid != ""){ $conv .= " AND tbl_checklist_assign.staffid='$xstaffid' ";}
		if($activity_id != ""){ $conv .= " AND tbl_checklist_assign.activity_id='$activity_id'";}
		if($date_recive != ""){ $conv .= " AND tbl_checklist_assign.date_recive='".sw_date_indb($date_recive)."'";}
		if($date_sent_true != ""){ $conv .= " AND tbl_checklist_assign.date_sent_true='".sw_date_indb($date_recive)."'";}
		if($sdate_recive != "" and $edate_recive != ""){ $conv .= "AND tbl_checklist_assign.date_recive BETWEEN '".sw_date_indb($sdate_recive)."' AND '".sw_date_indb($edate_recive)."' ";}
		if($sdate_sent_true != "" and $edate_sent_true != ""){ $conv .= "AND tbl_checklist_assign.date_sent_true BETWEEN '".sw_date_indb($sdate_sent_true)."' AND '".sw_date_indb($edate_sent_true)."' ";}
		if($status_sr_doc != ""){ $conv .= " AND tbl_checklist_assign_detail.status_sr_doc='$status_sr_doc'";}
  if($conv != ""){
		
		
		$sql_main = "SELECT
tbl_checklist_assign_detail.idcard,
tbl_checklist_assign_detail.siteid,
tbl_checklist_assign_detail.prename_th,
tbl_checklist_assign_detail.name_th,
tbl_checklist_assign_detail.surname_th,
tbl_checklist_assign_detail.approve,
tbl_checklist_assign_detail.status_scan,
tbl_checklist_assign.date_assign,
tbl_checklist_assign.date_sent,
tbl_checklist_assign.date_sent_true,
tbl_checklist_assign.date_recive,
tbl_checklist_assign.date_recive_true,
tbl_checklist_assign.staff_assign,
tbl_checklist_assign.staff_approve,
tbl_checklist_assign.assign_status,
tbl_checklist_assign.staffid,
tbl_checklist_assign.activity_id,
tbl_checklist_assign_detail.ticketid,
tbl_checklist_assign_detail.status_sr_doc
FROM tbl_checklist_assign_detail Inner Join tbl_checklist_assign 
ON tbl_checklist_assign_detail.ticketid = tbl_checklist_assign.ticketid
WHERE tbl_checklist_assign_detail.siteid <> '' $conv";
		
		//$sql_main = "SELECT * FROM tbl_checklist_assign_detail WHERE siteid <> '' $conv ";
	//echo $sql_main;
		$xresult = mysql_db_query($dbname_temp,$sql_main);
		$all= @mysql_num_rows($xresult);
	//	echo "จำนวนทั้งหมด :: ".$all."<br>";
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
		
		//echo "$page :: $allpage<br>";
	if($page <= $allpage){
			$sql_main .= " LIMIT $i, $e";
	}else if($page == $xpage){
		$i=0;
			$sql_main .= " ";
	}else{
			$sql_main .= " LIMIT $i, $e";
	}

//echo $sql_main;
		$result_main = mysql_db_query($dbname_temp,$sql_main);
		$num_row = mysql_num_rows($result_main);
		$search_sql = $sql_main ; 
		
		if($num_row < 1){
			
		}else{
			while($rs = mysql_fetch_assoc($result_main)){
			if($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
				 $arrp = ShowPersonDetail($rs[idcard]);
				  $alert_img = CheckAlert($rs[ticketid],$rs[date_sent]);// แจ้งเตือนการส่งคืนเอกสารล่าช้า
		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$alert_img?>&nbsp;<?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",show_area($rs[siteid]))."/".$arrp['schoolid'];?></td>
        <td align="center"><? echo "$rs[ticketid]";?></td>
        <td align="left"><?=ShowUserScan($rs[ticketid]);?></td>
        <td align="center"><?=thai_dateS($rs[date_recive]);?></td>
        <td align="center"><?=thai_dateS($rs[date_sent]);?></td>
        <td align="center"><?=thai_dateS($rs[date_sent_true]);?></td>
        <td align="center"><?=ShowIconAssign($rs[approve]);?></td>
        <td align="center"><?=StatusDocument($rs[status_sr_doc]);?></td>
      </tr>
      <?
			}//end while(){
		$sqlencode = urlencode($search_sql);
		echo "<tr bgcolor=\"#EFEFFF\">
        <td colspan=\"11\" align=\"center\">".xdevidepage($allpage, $keyword ,$sqlencode )."</td>
        </tr>";
		}//endif($numr1 < 1){
	}else{
		echo "<tr bgcolor='#F0F0F0'><td align='center' colspan='11'> - กรุณาระบเงื่อนไขในการค้นหาข้อมูล - </td></tr>";	
	}
	  ?>


    </table></td>
  </tr>
  <?
	}//end if($xsearch == "search"){
  ?>
    <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</BODY>
</HTML>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
