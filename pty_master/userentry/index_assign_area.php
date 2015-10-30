<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
session_start();
set_time_limit(0);
$ApplicationName	= "AssignArea";
$module_code 		= "statuser"; 
$process_id			= "display";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110701.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-07-01 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110701.00
	## Modified Detail :		ระบบมอบหมายงานสำหรับเจ้าหน้าที่ประจำเขต
	## Modified Date :		2011-07-01 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			include("../../common/function_assign_ticket.php");
				$time_start = getmicrotime();
			$profile_id = $profile_area;// สำหรับเจ้าหน้าที่เขต

if($_SERVER['REQUEST_METHOD'] == "GET"){
		if($action == "process"){
				AddPersonInTicket($xsiteid);
				
		echo "<script language=\"JavaScript\"> alert('บันทึกการมอบหมายงานเรียบร้อยแล้ว') ; 
		location.href='?action=';
		</script>";	
		exit();
		}// end 	if($action == "process"){
			
}//end if($_SERVER['REQUEST_METHOD'] == "GET"){
	
#############  function count all
function GetCountCmssAll(){
		global $dbnamemaster;
		$sql = "SELECT COUNT(CZ_ID) AS num1,siteid 	FROM view_general GROUP BY siteid";
		$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
				$arr[$rs[siteid]] = $rs[num1];
		}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function GetCountCmssAll(){
	
##### นับการมอบหมายงาน
function GetNumAssign(){
	global $dbnameuse;
		$sql = "SELECT
	t1.site_area as siteid,
	t1.staffid,
	count(distinct t2.idcard) as numall,
	sum(if(t2.approve='2',1,0)) as numapprove,
	sum(if(t2.userkey_wait_approve='1' or t2.approve='2' ,1,0)) as numkey
	FROM
	tbl_assign_sub as t1
	Inner Join tbl_assign_key as t2 ON t1.ticketid = t2.ticketid AND t1.profile_id = t2.profile_id
	Inner Join  ".DB_MASTER.".view_general as t3 ON t2.idcard=t3.CZ_ID and t2.siteid=t3.siteid
	WHERE t1.mode_assign='SITE'
	GROUP BY t1.site_area,t1.staffid";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]][$rs[staffid]]['numall'] = $rs[numall];
			$arr[$rs[siteid]][$rs[staffid]]['numapprove'] = $rs[numapprove];
			$arr[$rs[siteid]][$rs[staffid]]['numkey'] = $rs[numkey];
	}
	return $arr;
}// end function GetNumAssign(){


?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
</HEAD>
<BODY >
<?
	if($action == ""){
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px" >ระบบมอบหมายงานสำหรับเจ้าหน้าที่ประจำเขตพื้นที่การศึกษา</td>
        </tr>
		   <tr>
          <td bgcolor="#000000" ><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td width="3%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
              <td width="20%" align="center" bgcolor="#A5B2CE"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
              <td width="18%" align="center" bgcolor="#A5B2CE"><strong>พนักงานงานประจำเขตพื้นที่การศึกษา</strong></td>
              <td width="14%" align="center" bgcolor="#A5B2CE"><strong>จำนวนบุคลากรทั้งหมด(คน)</strong></td>
              <td width="14%" align="center" bgcolor="#A5B2CE"><strong>จำนวนที่มอบหมายงาน(คน)</strong></td>
              <td width="13%" align="center" bgcolor="#A5B2CE"><strong>จำนวนที่คีย์ข้อมูล(คน)</strong></td>
              <td width="13%" align="center" bgcolor="#A5B2CE"><strong>จำนวนที่รับรองข้อมูลแล้ว(คน)</strong></td>
              <td width="5%" align="center" bgcolor="#A5B2CE">&nbsp;</td>
            </tr>
            <?
			$arrcmss = GetCountCmssAll();// จำนวนบุคลากรทั้งหมดใน cmss
			$arrassign =  GetNumAssign();// จำนวนที่มอบหมายงานของเด็กเขต
            	$sql = "SELECT
t2.secid as siteid,
t2.secname,
t1.staffid,
t1.prename,
t1.staffname,
t1.staffsurname,
t1.status_permit
FROM ".DB_USERENTRY.".keystaff as t1
Inner Join  ".DB_MASTER.".eduarea as t2 ON t1.site_area = t2.secid
where t1.status_permit='YES'
ORDER BY t2.secname ASC";
			$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
					if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$i?></td>
              <td align="left"><?=str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[secname])?></td>
              <td align="left"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]";?></td>
              <td align="center"><?  if($arrcmss[$rs[siteid]] > 0){ echo "<a href='?action=view&xtype=all&xsiteid=$rs[siteid]&secname=$rs[secname]'>".number_format($arrcmss[$rs[siteid]])."</a>";}else{ echo "0";}?></td>
              <td align="center"><? if($arrassign[$rs[siteid]][$rs[staffid]]['numall'] > 0){ echo "<a href='?action=view&xtype=assign_all&xsiteid=$rs[siteid]&staffid=$rs[staffid]&secname=$rs[secname]'>".number_format($arrassign[$rs[siteid]][$rs[staffid]]['numall'])."</a>";}else{ echo "0";}?></td>
              <td align="center"><? if($arrassign[$rs[siteid]][$rs[staffid]]['numkey'] > 0){ echo "<a href='?action=view&xtype=assign_key&xsiteid=$rs[siteid]&staffid=$rs[staffid]&secname=$rs[secname]'>".number_format($arrassign[$rs[siteid]][$rs[staffid]]['numkey'])."</a>";}else{ echo "0";}?></td>
              <td align="center"><? if($arrassign[$rs[siteid]][$rs[staffid]]['numapprove'] > 0){echo "<a href='?action=view&xtype=assign_approve&xsiteid=$rs[siteid]&staffid=$rs[staffid]&secname=$rs[secname]'>".number_format($arrassign[$rs[siteid]][$rs[staffid]]['numapprove'])."</a>";}else{ echo "0";}?></td>
              <td align="center"><a href="?action=process&xsiteid=<?=$rs[siteid]?>"><img src="../../images_sys/Refreshb1.png" width="24" height="24" title="คลิ๊กเพื่อมอบหมายงาน"></a></td>
            </tr>
            <?
			}//end while($rs = mysql_fetch_assoc($result)){
			?>
          </table></td>
        </tr>
		   </table>
	  </td>
  </tr>
</table>
<?
	}else //end if($action == ""){
if($action == "view"){
	
	if($xtype == "all"){
			$sql = "SELECT CZ_ID as idcard,prename_th,name_th,surname_th,position_now,siteid,schoolid,schoolname FROM view_general WHERE siteid='$xsiteid' ORDER BY schoolname ASC,name_th,surname_th ASC";
			$xtitle1= "รายงานจำนวนบุคลากรทั้งหมด ".$secname;
		
	}else if($xtype == "assign_all"){
			$sql = "SELECT t3.CZ_ID as idcard, t3.siteid, t3.prename_th, t3.name_th, t3.surname_th, t3.position_now, t3.schoolid, t3.schoolname FROM ".DB_USERENTRY.".tbl_assign_sub as t1 Inner Join ".DB_USERENTRY.".tbl_assign_key as t2  ON t1.ticketid = t2.ticketid and t1.staffid='$staffid'
Inner Join  ".DB_MASTER.".view_general as t3  ON t2.idcard = t3.CZ_ID and t2.siteid=t3.siteid where t3.siteid='$xsiteid'  and t1.mode_assign='SITE'  
order by t3.schoolname asc,t3.name_th, t3.surname_th ASC";		
		$xtitle1= "รายงานจำนวนบุคลากรที่มอบหมายงานสำหรับคีย์ข้อมูลแล้ว ".$secname;
	}else if($xtype == "assign_key"){
			$sql = "SELECT t3.CZ_ID as idcard, t3.siteid, t3.prename_th, t3.name_th, t3.surname_th, t3.position_now, t3.schoolid, t3.schoolname FROM ".DB_USERENTRY.".tbl_assign_sub as t1 Inner Join ".DB_USERENTRY.".tbl_assign_key as t2  ON t1.ticketid = t2.ticketid and t1.staffid='$staffid' AND (t2.userkey_wait_approve='1' or  t2.approve='2')
			Inner Join  ".DB_MASTER.".view_general as t3  ON t2.idcard = t3.CZ_ID and t2.siteid=t3.siteid WHERE  t3.siteid='$xsiteid'  and t1.mode_assign='SITE' 
			order by t3.schoolname asc,t3.name_th, t3.surname_th ASC";		
			$xtitle1= "รายงานจำนวนบุคลากรที่บันทึกข้อมูลไปแล้ว ".$secname;
	}else if($xtype == "assign_approve"){
			$sql = "SELECT t3.CZ_ID as idcard, t3.siteid, t3.prename_th, t3.name_th, t3.surname_th, t3.position_now, t3.schoolid, t3.schoolname FROM ".DB_USERENTRY.".tbl_assign_sub as t1 Inner Join ".DB_USERENTRY.".tbl_assign_key as t2  ON t1.ticketid = t2.ticketid and t1.staffid='$staffid' AND t2.approve='2'
			Inner Join  ".DB_MASTER.".view_general as t3  ON t2.idcard = t3.CZ_ID and t2.siteid=t3.siteid WHERE  t3.siteid='$xsiteid'  and t1.mode_assign='SITE'  
			order by t3.schoolname asc,t3.name_th, t3.surname_th ASC";		
			$xtitle1= "รายงานจำนวนบุคลากรที่รับรองข้อมูลแล้ว ".$secname;
	}//end if($xtype == "all"){
		
		//echo $sql."<br>";
		$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$numr1 = mysql_num_rows($result);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="5" align="left" bgcolor="#A5B2CE"><strong><a href="?">ย้อนกลับ</a> || <?=$xtitle1?></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="19%" align="center" bgcolor="#A5B2CE"><strong>เลขบัตรประชาชน</strong></td>
        <td width="27%" align="center" bgcolor="#A5B2CE"><strong>ชื่อนามสกุล</strong></td>
        <td width="22%" align="center" bgcolor="#A5B2CE"><strong>ตำแหน่ง</strong></td>
        <td width="28%" align="center" bgcolor="#A5B2CE"><strong>สังกัด/หน่วยงาน</strong></td>
      </tr>
      <?
      		if($numr1 > 0){
				$i=0;
				while($rs = mysql_fetch_assoc($result)){
						if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><? echo "$rs[idcard]";?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="left"><? echo "$rs[schoolname]";?></td>
      </tr>
      <?
				}//end while($rs = mysql_fetch_assoc($result)){
			}//end if($numr1 > 0){
	  ?>
    </table></td>
  </tr>
  <tr>
</table>
<?
}// end if($action == "view"){
?>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "เวลาในการประมวลผล :: $timeprocess";
?>
