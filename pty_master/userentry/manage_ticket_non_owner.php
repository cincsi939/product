<?
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		ระบบส่งงาน
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM

include "epm.inc.php";
include("function_assign.php");
//$type_cmss = "province"; // กำหนดกรณีเป็นระบบของ จังหวัด
$s_db = STR_PREFIX_DB;
//if($dbnamemaster == "cmss_pro_master"){ $temp_site = "1300";};

$year1 = (date("Y")+543)."-09-30";
$report_title = "มอบหมายการบันทึกข้อมูล ก.พ.7 ให้กับผู้ใช้";

	
if($action == "view"){
	$sql_staff = "SELECT * FROM keystaff WHERE staffid='$staffid'";
	$result_staff = mysql_db_query($db_name,$sql_staff);
	$rs_staff = mysql_fetch_assoc($result_staff);
	$idcard_staff = $rs_staff[card_id]; // เลขบัตรประชาชนของพนักงานคีย์ข้อมูล
	
	### ห้องคีย์งานของพนักงานคีย์ข้อมูล
	$sitekey = GetSiteName($idcard_staff);

}
	ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
	if($profile_id == ""){
	
		$sqldf = "SELECT * FROM tbl_checklist_profile WHERE status_active='1' ORDER BY profile_date DESC LIMIT 1";
		$result_profile = mysql_db_query($dbname_temp,$sqldf);
		$rsdf = mysql_fetch_assoc($result_profile);
		$profile_id = $rsdf[profile_id];
}//end if($profile_id == ""){

function devidepage($total, $kwd , $sqlencode ){
	$per_page		= 11;	
	$page_all 		= $total;
	global $page,$xmode,$xtype,$utype,$xstatus_pay,$xsapphireoffice,$xsapp;

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
			$table .= "<a href=\"?page=1&xmode=$xmode&xtype=$xtype&utype=$utype&xstatus_pay=$xstatus_pay&xsapphireoffice=$xsapphireoffice&xsapp=$xsapp&displaytype=people".$kwd."\"><u><font color=\"black\">หน้าแรก</font></u></a>&nbsp;"; 
		}
		
		for($i=$min;$i<=$max;$i++){			
			$i	= str_pad($i, 2, "0", STR_PAD_LEFT);
			if($i != $page){
				$table .= "<a href=\"?page=".$i."&xmode=$xmode&xtype=$xtype&utype=$utype&xstatus_pay=$xstatus_pay&xsapphireoffice=$xsapphireoffice&xsapp=$xsapp&displaytype=people". $kwd."\"><span class=\"pagelink\">".$i."</span></a>";
			} else {
				$table .= "<span class=\"page\">".$i."</span>";
			}	
		}
		
		if(($page + 5) <= $page_all){ 
			$table .= "&nbsp;<a href=\"?page=".$page_all."&xmode=$xmode&xtype=$xtype&utype=$utype&xstatus_pay=$xstatus_pay&xsapphireoffice=$xsapphireoffice&xsapp=$xsapp&displaytype=people". $kwd."\"><u><font color=\"black\">หน้าสุดท้าย</font></u></a>"; 
		}
		
		if($page_all > 1){
			$table .= "&nbsp;<a href=\"?page=".($page_all+1)."&xmode=$xmode&xtype=$xtype&utype=$utype&xstatus_pay=$xstatus_pay&xsapphireoffice=$xsapphireoffice&xsapp=$xsapp&displaytype=people". $kwd."\"><u><font color=\"black\">แสดงทั้งหมด</font></u></a>";
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


### function  แสดงรายชื่อคนรับรอง
	function show_staff_approve($ticketid){
	global $db_name;
			$sql_staff_appove = "SELECT keystaff.staffname, keystaff.staffsurname FROM tbl_assign_sub Inner Join keystaff ON tbl_assign_sub.staff_approve = keystaff.staffid
WHERE tbl_assign_sub.ticketid =  '$ticketid'";
			$result_staff = @mysql_db_query($db_name,$sql_staff_appove);
			$rs_staff = @mysql_fetch_assoc($result_staff);
			return "$rs_staff[staffname] $rs_staff[staffsurname]";
	}
### end function แสดงรายชื่อคนรับรอง

if($_SERVER['REQUEST_METHOD'] == "POST"){

}// end if($_SERVER['REQUEST_METHOD'] == "POST"){

?>

<html>
<head>
<title>แบบฟอร์มค้นหาใบงานเพื่อเปลี่ยนพนักงานคีย์ข้อมูล</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
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
</script>
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
	BACKGROUND: url(../../application/hr3/hr_report/images/hdr_bg.png) #6eab26 repeat-x 0px -90px; 
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
	BACKGROUND: url(../../application/hr3/hr_report/images/hdr_bg.png) #63a218 repeat-x 0px -170px; 
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

<body bgcolor="#EFEFFF">
<?
	if($action == ""){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="3" align="left" bgcolor="#CCCCCC"><strong><img src="../../images_sys/globe.gif" width="19" height="18">ค้นหาใบงานเพื่อเปลี่ยนพนักงานคีย์ข้อมูล</strong></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>ข้อมูล ณ วันที่</strong></td>
              <td align="left" bgcolor="#FFFFFF"><select name="profile_id" id="profile_id">
              <option value="">เลือกโฟล์ไฟล์</option>
              <?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($db_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
              <option value="<?=$rsp[profile_id]?>" <?=$sel?>><?=$rsp[profilename]?></option>
              <?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
              </select></td>
              <td align="left" bgcolor="#FFFFFF"><input type="submit" name="button2" id="button" value="ค้นหา">
                <input type="hidden" name="mode" value="<?=$mode?>"></td>
            </tr>
            <tr>
              <td width="17%" align="right" bgcolor="#FFFFFF"><strong>รหัสใบงาน</strong></td>
              <td width="17%" align="left" bgcolor="#FFFFFF"><input name="ticketid" type="text" id="ticketid" size="30" value="<?=$ticketid?>"></td>
              <td width="66%" align="left" bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>ชื่อพนักงานคีย์</strong></td>
              <td bgcolor="#FFFFFF"><input name="staffname" type="text" id="staffname" size="30" value="<?=$staffname?>"></td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>นามสกุลพนักงานคีย์</strong></td>
              <td bgcolor="#FFFFFF"><input name="staffsurname" type="text" id="staffsurname" size="30" value="<?=$staffsurname?>"></td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>วันที่มอบหมายงาน</strong></td>
              <td bgcolor="#FFFFFF"><INPUT name="ticket_date" onFocus="blur();" value="<?=$ticket_date?>" size="15" readOnly>
                <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.ticket_date, 'dd/mm/yyyy')"value="วัน เดือน ปี"></td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
    <?
    	if($mode == "all"){ $fcolor1 = "<font color='#000000'>"; $fcolor_n1 = "</font>"; $bg1 = "#FFFFFF";}else{  $bg1 = "#A5B2CE";} 
		if($mode == "ticket_null"){ $fcolor2 = "<font color='#000000'>"; $fcolor_n2 = "</font>"; $bg2 = "#FFFFFF";}else{ $bg2 = "#A5B2CE";} 
		if($mode == "ticket_notnull"){ $fcolor3 = "<font color='#000000'>"; $fcolor_n3 = "</font>"; $bg3 = "#FFFFFF";}else{ $bg3 = "#A5B2CE";} 
	?>
      <tr>
        <td width="7%" align="center" bgcolor="<?=$bg1?>"><strong><a href="?mode=all&profile_id=<?=$profile_id?>&ticketid=<?=$ticketid?>&staffname=<?=$staffname?>&staffsurname=<?=$staffsurname?>&ticket_date=<?=$ticket_date?>"><?=$fcolor1?>ทั้งหมด <?=$fcolor_n1?></a></strong></td>
        <td width="15%" align="center" bgcolor="<?=$bg2?>"><strong><a href="?mode=ticket_null&profile_id=<?=$profile_id?>&ticketid=<?=$ticketid?>&staffname=<?=$staffname?>&staffsurname=<?=$staffsurname?>&ticket_date=<?=$ticket_date?>"> <?=$fcolor2?>ใบงานยังไม่มีเจ้าของ<?=$fcolor_n2?></a></strong></td>
        <td width="19%" align="center" bgcolor="<?=$bg3?>" ><strong><a href="?mode=ticket_notnull&profile_id=<?=$profile_id?>&ticketid=<?=$ticketid?>&staffname=<?=$staffname?>&staffsurname=<?=$staffsurname?>&ticket_date=<?=$ticket_date?>"> <?=$fcolor2?>ใบงานมีเจ้าของแล้วแต่ยังไม่ได้คีย์ <?=$fcolor_n2?></a></strong></td>
        <td width="59%" align="center" bgcolor="#A5B2CE">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="10" align="left" bgcolor="#CCCCCC"><strong>รายชื่อใบงานที่ต้องการเปลี่ยนพนักงานคีย์ข้อมูล</strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="16%" align="center" bgcolor="#CCCCCC"><strong>รหัสใบงาน</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>วันที่สร้างใบงาน</strong></td>
        <td width="10%" align="center" bgcolor="#CCCCCC"><strong>จำนวนบุคลากร(คน)</strong></td>
        <td width="10%" align="center" bgcolor="#CCCCCC"><strong>จำนวนที่บันทึก<br>
          ข้อมูลแล้ว(คน)</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>จำนวนที่ค้าง<br>
          บันทึก(คน)</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>สถานะใบงาน</strong></td>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong>พนักงานคีย์</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>ข้อมูล ณ วันที่</strong></td>
        <td width="3%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <?

	  	$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
		$e			= (!isset($e) || $e == 0) ? 20 : $e ;
		$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 

if($mode == "ticket_null"){
		$conv1 = " AND t2.staffid IS NULL";
}else if($mode == "ticket_notnull"){
		$conv1 = " AND t2.staffid IS  NOT NULL";
		$con_having = " HAVING numkey=0";
}
	  
$xdate = Sw_DateEng($ticket_date);
####  เงื่อนไขการค้นหา
if($ticketid  != ""){
		$conw .= " AND t1.ticketid='$ticketid' ";
}
if($staffname != ""){
		$conw .= " AND t2.staffname='$staffname'";
}
if($staffsurname != ""){
		$conw .= " AND t2.staffsurname='$staffsurname'";
}
	  
if($xdate != ""){
		$conw .= " AND  assign_date ='$xdate' ";
}
	  
      	$sql_staff = "SELECT
t1.ticketid,
t1.assign_date,
t1.profile_id,
t2.prename,
t2.staffname,
t2.staffsurname,
count(t3.idcard) as numall,
sum(if(t3.status_keydata=1,1,0)) as numkey,
t2.staffid,
t1.profile_id
FROM
tbl_assign_sub as t1
Left Join keystaff as t2 ON t1.staffid = t2.staffid
Inner Join tbl_assign_key as t3 ON t1.ticketid = t3.ticketid
WHERE
t1.profile_id =  '$profile_id' $conw $conv1
group by 
t1.ticketid
$con_having
";
//echo $sql_staff;

	 	$xresult = mysql_db_query($dbnameuse,$sql_staff);
		
		$all= @mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
		
	if($all < 1){ //ถ้าไม่มีข้อมูลให้แสดงข้อมูลว่าไม่พบรายการ
		echo "<tr bgcolor=\"#FFFFFF\"><td colspan='10'><center><b> - ไม่พบรายการข้อมูล - </b></center></td></tr>";
		
	}else{
		
	if($page <= $allpage){
			$sql_staff .= " LIMIT $i, $e";
	}else if($page == $xpage){
	$i=0;
			$sql_staff .= " ";
	}else{
			$sql_staff .= " LIMIT $i, $e";
	}

		

		$result_main = mysql_query($sql_staff);
		$num_row = mysql_num_rows($result_main);
		$search_sql = $sql_staff ;
		
	
		
	 $nn= 0;
	  while($rs = mysql_fetch_assoc($result_main)){
	  $i++;
	  	if ($nn++ %  2){ 	$bg = "#F0F0F0"; 	}else{ $bg = "#FFFFFF";	}


	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[ticketid]?></td>
        <td align="left"><?=thai_date($rs[assign_date]);?></td>
        <td align="center"><? if($rs[numall] > 0){ echo "<a href='manage_ticket_non_owner.php?action=view&staffid=$rs[staffid]&ticketid=$rs[ticketid]&mode=$mode&staffname=$staffname&staffsurname=$staffsurname'>".number_format($rs[numall])."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($rs[numkey] > 0){ echo "<a href='manage_ticket_non_owner.php?action=view&staffid=$rs[staffid]&ticketid=$rs[ticketid]&mode=$mode&type_data=approve&staffname=$staffname&staffsurname=$staffsurname'>".number_format($rs[numkey])."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if(($rs[numall]-$rs[numkey]) > 0){ echo "<a href='manage_ticket_non_owner.php?action=view&staffid=$rs[staffid]&ticketid=$rs[ticketid]&mode=$mode&type_data=nonapprove&staffname=$staffname&staffsurname=$staffsurname'>".number_format($rs[numall]-$rs[numkey])."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($rs[staffid] == ""){ echo "<font color='#006600'>ว่าง</font>";}else{ echo "<font color='#FF0000'>ไม่ว่าง</font>";}?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]";?></td>
        <td align="left"><?=ShowDateProfile($rs[profile_id]);?></td>
        <td align="center"><? if($rs[numkey] == "0"){?><a href="manage_ticket_non_owner.php?action=tranfer_ticket&ticketid=<?=$rs[ticketid]?>&profile_id=<?=$rs[profile_id]?>"><img src="../../images_sys/Refreshb1.png" width="20" height="20" border="0" title="คลิ๊กเพื่อย้ายใบงาน"></a><? } ?></td>
      </tr>
      <?
	  }
	  
}// end 	if($all < 1){
	if($all > 0){
	  ?>
           <tr>
        <td colspan="10" align="center" bgcolor="#CCCCCC"><? $sqlencode = urlencode($search_sql)  ; ?>
          <?=devidepage($allpage, $keyword ,$sqlencode )?></td>
        </tr>
<?
	}//end if($all > 0){
?>
    </table></td>
  </tr>
</table>
<?
	}//end 
	if($action == "view"){
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" align="left" bgcolor="#CCCCCC"><input type="button" name="btnBB" value="ย้อนกลับ" onClick="location.href='manage_ticket_non_owner.php?action=&profile_id=<?=$profile_id?>&mode=<?=$mode?>&staffname=<?=$staffname?>&staffsurname=<?=$staffsurname?>'">
          &nbsp;<strong>รหัสจ่ายงาน
          <?=$ticketid?>
          <?=ShowDateProfile($profile_id);?>
          </strong><strong>&nbsp;ห้องคีย์งานคือ
          <?=$sitekey?>
          </strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="15%" align="center" bgcolor="#CCCCCC"><strong>รหัสประจำตัวประชาชน</strong></td>
        <td width="14%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล </strong></td>
        <td width="18%" align="center" bgcolor="#CCCCCC"><strong>โรงเรียน/หน่วยงาน</strong></td>
        <td width="16%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>อายุราชการ</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>จำนวนรูป/จำนวนแผ่น</strong></td>
        <td width="9%" align="center" bgcolor="#CCCCCC"><strong>PDF</strong></td>
      </tr>
      <?
      
$year1 = (date("Y")+543)."-09-30";

if($type_data == "approve"){
		$conw = " AND t1.status_keydata='1'";
}else if($type_data == "nonapprove"){
		$conw = " AND t1.status_keydata='0'";
}else{
		$conw = "";	
}
	$sql_view = "SELECT
t1.ticketid,
t2.CZ_ID,
t2.siteid,
t2.prename_th,
t2.name_th,
t2.surname_th,
t2.position_now,
t2.schoolid,
(TIMESTAMPDIFF(MONTH,t2.begindate,'$year1')/12) as age_gov
FROM
tbl_assign_key as t1
Inner Join $dbnamemaster.view_general as t2 ON t1.idcard = t2.CZ_ID WHERE t1.ticketid='$ticketid'  $conw";
		$result = mysql_db_query($db_name,$sql_view);
		$k=0;
		while($rs = mysql_fetch_assoc($result)){
		 if ($k++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		 
		  $filekp7 = "../../../edubkk_kp7file/$rs[siteid]/$rs[CZ_ID].pdf";
		 if(is_file($filekp7)){
				 $link_kp7 = "<a href=\"../../../edubkk_kp7file/$rs[siteid]/$rs[CZ_ID].pdf\" target=\"_blank\"><img src=\"../../images_sys/gnome-mime-application-pdf.png\" alt=\"เอกสาร ก.พ.7 ต้นฉบับ\" width=\"20\" height=\"20\" border=\"0\"></a>";
		}else{
				$arrkp7 = GetPdfOrginal($rs[CZ_ID],$path_pdf,$imgpdf,"","pdf");
				$link_kp7 = $arrkp7['linkfile'];	
		}
		
				####  นับจำนวนรูปจำนวนแผ่น
		$arrpicpage = GetNumPicPage($rs[CZ_ID],$profile_id);
		$picpage = $arrpicpage['pic']."/".$arrpicpage['page'];
	  ?>
      
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$k?></td>
        <td align="center"><?=$rs[CZ_ID]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo show_org($rs[schoolid])."/".show_area($rs[siteid]);?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="center"><? echo floor($rs[age_gov]);?></td>
        <td align="center"><?=$picpage?></td>
        <td align="center"><?=$link_kp7?></td>
      </tr>
      <?
		}//end 
	  ?>
    </table></td>
  </tr>
</table>
<?
	}//end if($action == "view"){
		
if($action == "tranfer_ticket"){		
?>
<form name="form2" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="6%"><strong>รหัสใบงาน :</strong></td>
            <td width="16%"><?=$ticketid?></td>
            <td width="13%"><strong>พนักงานที่ครองใบงานปัจุบัน :</strong></td>
            <td width="17%">&nbsp;</td>
            <td width="14%"><strong>พนักงานที่จะมอบใบงานให้ใหม่ : </strong></td>
            <td width="19%"><strong>
              <select name="staffid_save" id="staffid_save">
              <option value=""> - เลือกพนักงานคีย์ - </option>
              <?
              	$sql_staff = "SELECT staffid,prename,staffname,staffsurname FROM keystaff WHERE status_permit='YES' and status_extra='NOR' ORDER BY staffname,staffsurname ASC";
				$result_staff = mysql_db_query($dbnameuse,$sql_staff);
				while($rss = mysql_fetch_assoc($result_staff)){
					echo "<option value='$rss[staffid]'>$rss[prename]$rss[staffname]  $rss[staffsurname]</option>";
				}//end while($rss = mysql_fetch_assoc($result_staff)){
			  ?>
              </select>
            </strong></td>
            <td width="12%"><strong>
              <input type="submit" name="button3" id="button2" value="บันทึก">
            </strong></td>
            <td width="3%">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="15%" align="center" bgcolor="#CCCCCC"><strong>รหัสประจำตัวประชาชน</strong></td>
        <td width="19%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล </strong></td>
        <td width="18%" align="center" bgcolor="#CCCCCC"><strong>โรงเรียน/หน่วยงาน</strong></td>
        <td width="15%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <td width="10%" align="center" bgcolor="#CCCCCC"><strong>อายุราชการ</strong></td>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong>จำนวนรูป/จำนวนแผ่น</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>PDF</strong></td>
      </tr>
      <?
	  $year1 = (date("Y")+543)."-09-30";
      	$sql_ticket = "SELECT
t1.ticketid,
t2.CZ_ID,
t2.siteid,
t2.prename_th,
t2.name_th,
t2.surname_th,
t2.position_now,
t2.schoolid,
(TIMESTAMPDIFF(MONTH,t2.begindate,'$year1')/12) as age_gov
FROM
tbl_assign_key as t1
Inner Join $dbnamemaster.view_general as t2 ON t1.idcard = t2.CZ_ID WHERE t1.ticketid='$ticketid' ";
	$result_ticket = mysql_db_query($dbnameuse,$sql_ticket);
	$k=0;
	while($rs = mysql_fetch_assoc($result_ticket)){
				 if ($k++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		 
		  $filekp7 = "../../../edubkk_kp7file/$rs[siteid]/$rs[CZ_ID].pdf";
		 if(is_file($filekp7)){
				 $link_kp7 = "<a href=\"../../../edubkk_kp7file/$rs[siteid]/$rs[CZ_ID].pdf\" target=\"_blank\"><img src=\"../../images_sys/gnome-mime-application-pdf.png\" alt=\"เอกสาร ก.พ.7 ต้นฉบับ\" width=\"20\" height=\"20\" border=\"0\"></a>";
		}else{
				$arrkp7 = GetPdfOrginal($rs[CZ_ID],$path_pdf,$imgpdf,"","pdf");
				$link_kp7 = $arrkp7['linkfile'];	
		}
		
				####  นับจำนวนรูปจำนวนแผ่น
		$arrpicpage = GetNumPicPage($rs[CZ_ID],$profile_id);
		$picpage = $arrpicpage['pic']."/".$arrpicpage['page'];

	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$k?></td>
        <td align="center"><?=$rs[CZ_ID]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo show_org($rs[schoolid])."/".show_area($rs[siteid]);?></td>
        <td align="left"><? echo $rs[position_now]?></td>
        <td align="center"><? echo floor($rs[age_gov]);?></td>
        <td align="center"><?=$picpage?></td>
        <td align="center"><?=$link_kp7?></td>
      </tr>
      <?
	}//end 	while($rst = mysql_fetch_assoc($result_ticket)){
	  ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<?
	}//end 	if($action == "tranfer_ticket"){
?>
</BODY>
</HTML>
