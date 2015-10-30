<?
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


	if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์
		$profile_id = LastProfile();
	}//end if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์

	
//echo "p : ".$profile_id;

function xRmkdir($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
	mkdir($way);
	}
}
if($xaction=="setuser"){
	unset($_SESSION['def_staff']);
	$arr=explode(",",$setuser);
	if(is_array($arr) ){
	foreach($arr as $index=>$values){
	 $_SESSION['def_staff'][$values]='ok';
		}
	}
 
}

if(is_array($_SESSION['def_staff']) ){
	foreach($_SESSION['def_staff'] as $index=>$values){	
	 if($xstr_arr!=""){$xstr_arr.=",";}
	  $xstr_arr.="'".$index."'";
	 
	}
}
//echo $xstr_arr;





function assign_devidepage($total, $kwd , $sqlencode ){
	$per_page		= 11;	
	$page_all 		= $total;
	global $page,$xsearch,$profile_id,$action,$lv,$xsiteid,$xmode,$schoolid,$staffid,$activity_id,$s_siteid,$xname,$xsurname;

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
			$table .= "<a href=\"?page=1&xsearch=$xsearch&profile_id=$profile_id&action=$action&lv=$lv&xsiteid=$xsiteid&xmode=$xmode&schoolid=$schoolid&staffid=$staffid&activity_id=$activity_id&s_siteid=$s_siteid&xname=$xname&xsurname=$xsurname&displaytype=people".$kwd."\"><u><font color=\"black\">หน้าแรก</font></u></a>&nbsp;"; 
		}
		
		for($i=$min;$i<=$max;$i++){			
			$i	= str_pad($i, 2, "0", STR_PAD_LEFT);
			if($i != $page){
				$table .= "<a href=\"?page=".$i."&xsearch=$xsearch&profile_id=$profile_id&action=$action&lv=$lv&xsiteid=$xsiteid&xmode=$xmode&schoolid=$schoolid&staffid=$staffid&activity_id=$activity_id&s_siteid=$s_siteid&xname=$xname&xsurname=$xsurname&displaytype=people". $kwd."\"><span class=\"pagelink\">".$i."</span></a>";
			} else {
				$table .= "<span class=\"page\">".$i."</span>";
			}	
		}
		
		if(($page + 5) <= $page_all){ 
			$table .= "&nbsp;<a href=\"?page=".$page_all."&xsearch=$xsearch&profile_id=$profile_id&action=$action&lv=$lv&xsiteid=$xsiteid&xmode=$xmode&schoolid=$schoolid&staffid=$staffid&activity_id=$activity_id&s_siteid=$s_siteid&xname=$xname&xsurname=$xsurname&displaytype=people". $kwd."\"><u><font color=\"black\">หน้าสุดท้าย</font></u></a>"; 
		}
		
		if($page_all > 1){
			$table .= "&nbsp;<a href=\"?page=".($page_all+1)."&xsearch=$xsearch&profile_id=$profile_id&action=$action&lv=$lv&xsiteid=$xsiteid&xmode=$xmode&schoolid=$schoolid&staffid=$staffid&activity_id=$activity_id&s_siteid=$s_siteid&xname=$xname&xsurname=$xsurname&displaytype=people". $kwd."\"><u><font color=\"black\">แสดงทั้งหมด</font></u></a>";
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
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<LINK href="css/style.css" rel=stylesheet>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
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

<script src="../../common/jquery.js"></script>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>

</head>
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
              <option value="?profile_id=<?=$rsp[profile_id]?>&action=<?=$action?>&lv=<?=$lv?>&xsiteid=<?=$xsiteid?>&schoolid=<?=$schoolid?>&staffid=<?=$staffid?>&xmode=<?=$xmode?>" <?=$sel?>><?=$rsp[profilename]?></option>
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
					echo "<option value='?profile_id=$profile_id&action=$action&lv=$lv&xsiteid=$xsiteid&xmode=$xmode&schoolid=$schoolid&staffid=$staffid&activity_id=$rsac[activity_id]' $sel>$rsac[activity]</option>";
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
    <td align="center"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td align="center"><strong>ประเภทกิจการ :: <?=ShowActivity($activity_id);?></strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr class="fillcolor">
              <td width="14%" align=center style="border-right: solid 1 white;" bgcolor="<? if($xmode == ""){ $bgcolor = "BLACK";echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066"; }?>"><A HREF="assign_management.php?xmode=&profile_id=<?=$profile_id?>&activity_id=<?=$activity_id?>&xname=<?=$xname?>&xsurname<?=$xsurname?>"><strong><U style="color:<?=$bgcolor?>;">จัดการข้อมูลผู้ใช้</U></strong></A></td>
              <td width="19%" align=center style="border-right: solid 1 white;" bgcolor="<? if($xmode == "1"){ $bgcolor = "BLACK"; echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066";}?>"><A HREF="assign_management.php?xmode=1&profile_id=<?=$profile_id?>&activity_id=<?=$activity_id?>&xname=<?=$xname?>&xsurname<?=$xsurname?>"><strong><U style="color:<?=$bgcolor?>;"> ส่วนจ่ายงานให้กับผู้รับงาน</U></strong></A></td>
			   <td width="19%" align=center style="border-right: solid 1 white;" bgcolor="<? if($xmode == "2"){ $bgcolor = "BLACK"; echo "#FFFFFF";}else{ $bgcolor = "white"; echo "#000066";}?>"><A HREF="assign_management.php?xmode=2&profile_id=<?=$profile_id?>&activity_id=<?=$activity_id?>&xname=<?=$xname?>&xsurname<?=$xsurname?>"><strong><U style="color:<?=$bgcolor?>;"> ส่วนของการรอตรวจงาน</U></strong></A></td>

              <td width="48%"><a href="assign_search.php" target="_blank"><img src="../validate_management/images/world_go.png" width="16" height="16" border="0" title="คลิ๊กเพื่อค้นหาการมอบหมายงาน"></a></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><form name="form2" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td height="17" colspan="3" align="left" bgcolor="#D2D2D2"><img src="../../images_sys/globe.gif" width="19" height="18"><strong>ฟอร์มค้นหาพนักงานพนักงานสแกนเอกสาร</strong></td>
              </tr>
            <tr>
              <td width="10%" align="right" bgcolor="#FFFFFF"><strong>ชื่อพนักงาน</strong></td>
              <td width="23%" align="left" bgcolor="#FFFFFF">
                <input name="xname" type="text" id="xname" size="25" value="<?=$xname?>">
              </td>
              <td width="67%" align="left" bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>นามสกุล</strong></td>
              <td align="left" bgcolor="#FFFFFF"><input name="xsurname" type="text" id="xsurname" size="25" value="<?=$xsurname?>"></td>
              <td align="left" bgcolor="#FFFFFF">
                <input type="submit" name="button" id="button" value="ค้นหา">
                <input type="hidden" name="profile_id" value="<?=$profile_id?>">
                <input type="hidden" name="xmode" value="<?=$xmode?>">
                <input type="hidden" name="action" value="<?=$action?>">
                <input type="hidden" name="activity_id" value="<?=$activity_id?>">
              </td>
            </tr>
          </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <? if($xmode == ""){?>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="left" bgcolor="#D2D2D2"><strong>รายชื่อพนักงานที่แกนเอกสารทะเบียนประวัติ (ก.พ.7)</strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#D2D2D2"><strong>ลำดับ</strong></td>
        <td width="27%" align="center" bgcolor="#D2D2D2"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="18%" align="center" bgcolor="#D2D2D2"><strong>จำนวนใบงาน</strong></td>
        <td width="25%" align="center" bgcolor="#D2D2D2"><strong>เบอร์โทร</strong></td>
        <td width="19%" align="center" bgcolor="#D2D2D2"><strong>อีเมลล์</strong></td>
        <td width="6%" align="center" bgcolor="#D2D2D2">&nbsp;</td>
      </tr>
      <?
	  	if($xname != ""){
				$conv .= " AND staffname LIKE '%$xname%'";
		}
		if($xsurname != ""){
				$conv .= " AND staffsurname LIKE '%$xsurname%'";
		}
		if($activity_id == "1"){
				$conW = " AND status_extra='SCAN'";
		}//end if($activity_id == "1"){
		
	  	$arrnum = CountAssignScan();// นับจำนวนเอกสารที่มอบหมายงาน
		if($activity_id == "3"){
			$sql = "SELECT * FROM  keystaff WHERE flag_assgin='assgin_key' ORDER BY staffname ASC";	
		}else{
     		$sql = "SELECT * FROM  keystaff WHERE status_permit='YES' AND sapphireoffice='0' AND status_extra <> 'QC' $conv $conW ORDER BY staffname ASC";
		}
		//echo $sql;
		$result = mysql_db_query($dbcallcenter_entry,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		
	 ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]";?></td>
        <td align="center"><? 
		if($arrnum[$rs[staffid]] > 0){
				echo "<a href='assign_management_detail.php?action=&staffid=$rs[staffid]&profile_id=$profile_id&activity_id=$activity_id'>".$arrnum[$rs[staffid]]."</a>";
		}else{
				echo "0";	
		}//end if($arrnum[$rs[staffid]] > 0){
		?></td>
        <td align="left"><?=$rs[telno]?></td>
        <td align="left"><?=$rs[email]?></td>
        <td align="center"><a href="assign_main.php?staffid=<?=$rs[staffid]?>&profile_id=<?=$profile_id?>&activity_id=<?=$activity_id?>" target="_blank"><img src="../salary_mangement/images/folder_user.png" width="16" height="16" title="คลิกเพื่อมอบหมายงาน" border="0" ></a></td>
      </tr>
      <?
		}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
  <? }//end if($xmode == ""){
	if($xmode == "1"){	  
?>
    <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="left" bgcolor="#D2D2D2"><strong>รายส่วนของการมอบหมายงาน  :: <a href="assign_management.php?xmode=<?=$xmode?>&extra1=all&profile_id=<?=$profile_id?>&action=<?=$action?>&lv=<?=$lv?>&xsiteid=<?=$xsiteid?>&schoolid=<?=$schoolid?>&staffid=<?=$staffid?>&activity_id=<?=$activity_id?>">รอมอบหมายงานทั้งหมด</a> || <a href="assign_management.php?xmode=<?=$xmode?>&extra1=key&profile_id=<?=$profile_id?>&action=<?=$action?>&lv=<?=$lv?>&xsiteid=<?=$xsiteid?>&schoolid=<?=$schoolid?>&staffid=<?=$staffid?>&activity_id=<?=$activity_id?>">รอมอบหมายงานจากระบบมอบหมายงานจากทีมคีย์ข้อมูล</a></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#D2D2D2"><strong>ลำดับ</strong></td>
        <td width="22%" align="center" bgcolor="#D2D2D2"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="23%" align="center" bgcolor="#D2D2D2"><strong>รหัสใบงาน</strong></td>
        <td width="18%" align="center" bgcolor="#D2D2D2"><strong>จำนวนที่มอบหมายงาน</strong></td>
        <td width="25%" align="center" bgcolor="#D2D2D2"><strong>วันสร้างใบงาน</strong></td>
        <td width="8%" align="center" bgcolor="#D2D2D2">&nbsp;</td>
      </tr>
      <?
	  
	  //echo "xx";
	  if($extra1 == "key"){
		  $conext = " and flag_assign='1'";
		}else{
			$conext = "";	
		}// end   if($extra1 == "key"){
	  
	   	  if($xname != ""){
				$conv .= " AND callcenter_entry.keystaff.staffname LIKE '%$xname%'";
		}
		if($xsurname != ""){
				$conv .= " AND callcenter_entry.keystaff.staffsurname LIKE '%$xsurname%'";
		}
      		$sql = "SELECT
callcenter_entry.keystaff.staffid,
callcenter_entry.keystaff.prename,
callcenter_entry.keystaff.staffname,
callcenter_entry.keystaff.staffsurname,
edubkk_checklist.tbl_checklist_assign.staffid,
edubkk_checklist.tbl_checklist_assign.ticketid,
edubkk_checklist.tbl_checklist_assign.date_assign,
edubkk_checklist.tbl_checklist_assign.date_sent,
edubkk_checklist.tbl_checklist_assign.date_recive,
edubkk_checklist.tbl_checklist_assign.profile_id
FROM
callcenter_entry.keystaff
Inner Join edubkk_checklist.tbl_checklist_assign ON callcenter_entry.keystaff.staffid = edubkk_checklist.tbl_checklist_assign.staffid
AND  edubkk_checklist.tbl_checklist_assign.activity_id='$activity_id'
WHERE
edubkk_checklist.tbl_checklist_assign.profile_id =  '$profile_id' AND assign_status='N'  $conv $conext   ORDER BY callcenter_entry.keystaff.staffid ASC";
//echo $sql;
		$result = mysql_db_query($dbname_temp,$sql);
		$numr1 = @mysql_num_rows($result);
	if($numr1 == ""){
			 echo "<tr bgcolor='#F0F0F0'>
        				<td align=\"center\" colspan=\"6\"><strong> - ไม่พบรายการ - </strong></td>
      					</tr>
				";
	}else{

		$k=0;
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			
			 if($rs[staffid] != $temp_staffid){
				 $i=0;
				 $k++;
				 echo "<tr bgcolor='#F0F0F0'>
        				<td align=\"center\"><strong>$k</strong></td>
        				<td align=\"left\" colspan=\"5\"><strong>$rs[prename]$rs[staffname]  $rs[staffsurname]</strong></td>
      					</tr>
				";
				$arrassgin = $arrnum = CountScanDetail($rs[staffid]);// นับจำนวนเอกสารที่มอบหมายงาน
				 
				 $temp_staffid = $rs[staffid];		 
			}// end  if($rs[staffid] != $temp_staffid){<br>
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="left" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=thai_date($rs[date_assign]);?></td>
        <td align="center"><?=$rs[ticketid]?></td>
        <td align="center"><? if($arrassgin[$rs[ticketid]] > 0){ echo "<a href='assign_management_detail.php?xmode=$xmode&ticketid=$rs[ticketid]&staffid=$rs[staffid]&profile_id=$profile_id&action=detail&activity_id=$activity_id'>".$arrassgin[$rs[ticketid]]."</a>";}else{ echo "0";}?></td>
        <td align="center"><?=thai_date($rs[date_assign]);?></td>
        <td align="center"><a href="assign_sentjob.php?ticketid=<?=$rs[ticketid]?>&profile_id=<?=$profile_id?>&activity_id=<?=$activity_id?>" target="_blank"><img src="../../images_sys/Refreshb1.png" width="20" height="20" border="0" title="คลิ๊กเพื่อส่งมอบงาน"></a></td>
      </tr>
      <?
		}//end 
		}//end if($numr1 == ""){
	  ?>
    </table></td>
  </tr>
  <?
	}//end if($xmode == "1"){	
	if($xmode == "2"){
	
  ?>
    <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="9" align="left" bgcolor="#D2D2D2"><form name="form3" method="post" action="">
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td width="16%" align="right"><strong>ค้นหาใบงานตาม สพท.</strong></td>
              <td width="84%" align="left"> <select name="s_siteid" id="s_siteid" onChange="gotourl(this)">
              <option value="">เลือก สพท.</option>
              <?
		$sql_s  = "SELECT eduarea.secid, eduarea.secname,eduarea_config.pdf_org,
eduarea_config.pdf_sys FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE eduarea_config.group_type =  'keydata' AND eduarea_config.profile_id='$profile_id'  order by eduarea.secname ASC ";
		$result_s = mysql_db_query($dbnamemaster,$sql_s);
		while($rss = mysql_fetch_assoc($result_s)){
			if($rss[secid] == $s_siteid){ $sel = "selected='selected'";}else{ $sel = "";}
			echo "<option value='?profile_id=$profile_id&action=$action&lv=$lv&xsiteid=$xsiteid&xmode=$xmode&schoolid=$schoolid&staffid=$staffid&activity_id=$activity_id&s_siteid=$rss[secid]' $sel>".str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rss[secname])."</option>";

		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
              </select> </td>
            </tr>
          </table>
        </form></td>
      </tr>
      <tr>
        <td colspan="9" align="left" bgcolor="#D2D2D2"><strong>รายงานตรวจรับงาน</strong></td>
      </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#D2D2D2"><strong>ลำดับ</strong></td>
        <td width="11%" align="center" bgcolor="#D2D2D2"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="16%" align="center" bgcolor="#D2D2D2"><strong>รหัสใบงาน</strong></td>
        <td width="12%" align="center" bgcolor="#D2D2D2"><strong>จำนวนที่มอบ<br>
          หมายงาน</strong></td>
        <td width="12%" align="center" bgcolor="#D2D2D2"><strong>วันที่จ่ายงาน</strong></td>
        <td width="17%" align="center" bgcolor="#D2D2D2"><strong>กำหนดวันส่งงาน</strong></td>
        <td width="12%" align="center" bgcolor="#D2D2D2"><strong>สถานะไฟล</strong>์</td>
        <td width="10%" align="center" bgcolor="#D2D2D2"><strong>สถานะคืนเอกสาร</strong></td>
        <td width="6%" align="center" bgcolor="#D2D2D2">&nbsp;</td>
      </tr>
      <?
	  	  	$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
			$e			= (!isset($e) || $e == 0) ? 50 : $e ;
			$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 

	  
	  
	  	 if($xname != ""){
				$conv .= " AND callcenter_entry.keystaff.staffname LIKE '%$xname%'";
		}
		if($xsurname != ""){
				$conv .= " AND callcenter_entry.keystaff.staffsurname LIKE '%$xsurname%'";
		}
		
		if($s_siteid != ""){
				$consite = " AND edubkk_checklist.tbl_checklist_assign.siteid='$s_siteid'";
		}

      	$sql_main = "SELECT
callcenter_entry.keystaff.staffid,
callcenter_entry.keystaff.prename,
callcenter_entry.keystaff.staffname,
callcenter_entry.keystaff.staffsurname,
edubkk_checklist.tbl_checklist_assign.staffid,
edubkk_checklist.tbl_checklist_assign.ticketid,
edubkk_checklist.tbl_checklist_assign.date_assign,
edubkk_checklist.tbl_checklist_assign.date_sent,
edubkk_checklist.tbl_checklist_assign.date_recive,
edubkk_checklist.tbl_checklist_assign.profile_id,
edubkk_checklist.tbl_checklist_assign.approve
FROM
callcenter_entry.keystaff
Inner Join edubkk_checklist.tbl_checklist_assign ON callcenter_entry.keystaff.staffid = edubkk_checklist.tbl_checklist_assign.staffid
AND edubkk_checklist.tbl_checklist_assign.activity_id='$activity_id'
WHERE
edubkk_checklist.tbl_checklist_assign.profile_id =  '$profile_id' AND assign_status='Y' $conv  $consite  ORDER BY callcenter_entry.keystaff.staffid ASC,edubkk_checklist.tbl_checklist_assign.timeupdate_scan ASC";

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

		$result_main = mysql_db_query($dbname_temp,$sql_main);
		$num_row = mysql_num_rows($result_main);
		$search_sql = $sql_main ; 

		$k=0;
		$i=0;
if($num_row == ""){
			 echo "<tr bgcolor='#F0F0F0'>
        				<td align=\"center\" colspan=\"9\"><strong> - ยังไม่มีการส่งมอบงาน - </strong></td>
      					</tr>
				";
	}else{
	while($rs = mysql_fetch_assoc($result_main)){
	
			 if($rs[staffid] != $temp_staffid){
				 $i=0;
				 $k++;
				 echo "<tr bgcolor='#F0F0F0'>
        				<td align=\"center\"><strong>$k</strong></td>
        				<td align=\"left\" colspan=\"8\"><strong>$rs[prename]$rs[staffname]  $rs[staffsurname]</strong></td>
      					</tr>
				";
				$arrassgin = $arrnum = CountScanDetail($rs[staffid]);// นับจำนวนเอกสารที่มอบหมายงาน
				 
				 $temp_staffid = $rs[staffid];		 
			}// end  if($rs[staffid] != $temp_staffid){<br>
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	 
	 $alert_img = CheckAlert($rs[ticketid],$rs[date_sent]);// แจ้งเตือนการส่งคืนเอกสารล่าช้า

	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="left" colspan="2"><?=$alert_img?>&nbsp;<?=thai_date($rs[date_assign]);?></td>
        <td align="center"><?=$rs[ticketid]?></td>
        <td align="center"><? if($arrassgin[$rs[ticketid]] > 0){ echo "<a href='assign_management_detail.php?xmode=$xmode&ticketid=$rs[ticketid]&staffid=$rs[staffid]&profile_id=$profile_id&action=detail&activity_id=$activity_id' target='_blank'>".$arrassgin[$rs[ticketid]]."</a>";}else{ echo "0";}?></td>
        <td align="center"><?=thai_date($rs[date_assign]);?></td>
        <td align="center"><?=thai_date($rs[date_sent]);?></td>
        <td align="center"><?=ShowIconAssign($rs[approve]);?></td>
        <td align="center"><?=StatusDocument($rs[status_sr_doc]);?></td>
        <td align="center"><a href="assign_recivejob.php?ticketid=<?=$rs[ticketid]?>&profile_id=<?=$profile_id?>&activity_id=<?=$activity_id?>" target="_blank"><img src="../../images_sys/Refreshb1.png" width="20" height="20" title="คลิ๊กเพื่อตรวจรับงาน" border="0"></a></td>
      </tr>
      <?
	}//end 	while($rs = mysql_fetch_assoc($result)){
}//end if($numr < 1){  assign_devidepage
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td colspan="9" align="left" bgcolor="#FFFFFF"><?
        $sqlencode = urlencode($search_sql);
		echo assign_devidepage($allpage, $keyword ,$sqlencode );
		
		?></td>
        </tr>
    </table></td>
  </tr>
  <?
	}//end if($xmode == "2"){
  ?>
</table>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
