<?
session_start();

include "epm.inc.php";
if(!isset($session_staffid)){
echo "<script type=\"text/javascript\">
window.location=\"login.php\";
</script>";
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!-- saved from url=(0037) -->
<HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD><TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<LINK media=screen href="common/styles.css" type=text/css rel=stylesheet>
<LINK media=screen href="common/nav-h.css" type=text/css rel=stylesheet>
<LINK media=screen href="common/nav-v.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="common/jquery.min.js" type=text/javascript></SCRIPT>
<!--[if gte IE 5.5]>
<SCRIPT language=JavaScript 
src="common/jquery.ienav.js" 
type=text/javascript></SCRIPT>
<![endif]-->
<SCRIPT language=JavaScript type=text/javascript>
$(document).ready(function() {
  $('.links li code').hide();  
  $('.links li p').click(function() {
    $(this).next().slideToggle('fast');
  });
});
</SCRIPT>

</HEAD>
<body bgcolor="#999999">

<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH="100%" >

<TR HEIGHT="100" VALIGN=MIDDLE>

  <TD ALIGN=CENTER><table width="98%" border="0" cellpadding="0" cellspacing="0" bgcolor="#197FC9" style="margin-bottom:5px; margin-top:5px">

    <tr>

      <td width="1%" align="left" valign="top" background="images/user_information_08.gif" style="background-repeat: repeat-y"><IMG SRC="images/user_information_03.gif" WIDTH=6 HEIGHT=6 ALT=""></td>

      <td width="99%" background="images/user_information_04.gif" style="background-repeat:repeat-x; padding:3px">&nbsp;&nbsp;<strong class="txtwhite">ข้อมูลผู้ใช้</strong></td>

      <td width="0%" align="right" valign="top" background="images/user_information_11.gif" style="background-repeat:repeat-y; background-position:right;"><img src="images/user_information_06.gif" width="6" height="6"></td>

    </tr>

    <tr>

      <td background="images/user_information_08.gif" style="background-repeat: repeat-y">&nbsp;</td>

      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td width="1%" valign="top" class="fillcolor_loginleft"><img src="images/user_information_14.gif" width="6" height="6"></td>

          <td width="99%" height="65" align="center" class="fillcolor_loginleft" style="background-repeat:no-repeat; background-position: top right; padding-top:5px;"><span style="padding-top:5px">

            <?

$sql 		= " select * from $epm_staff where staffid = '".$_SESSION[session_staffid]."' ";

$result	= mysql_query($sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());

$rs		= mysql_fetch_assoc($result);

$image	= ($rs[image] != "") ? $rs[image] : "nopicture.gif" ;

$user=base64_encode($rs[username]);
$pwd=base64_encode($rs[password]);
mysql_free_result($result);



?>

          </span>

            <div id="img" align="center"><img src="images/personnel/<?=$image?>" width="150" border="0"></div></td>

          <td width="0%" align="center" valign="top" class="fillcolor_loginleft"><img src="images/user_information_30.gif" width="6" height="6"></td>

        </tr>

        <tr>

          <td align="left" valign="bottom" class="fillcolor_loginleft2"><img src="images/user_information_19.gif" width="6" height="6"></td>

          <td class="fillcolor_loginleft2" style="padding : 3px 0px 5px 0px;"><span class="txtwhite"><strong>&nbsp;&nbsp;ชื่อ&nbsp;:</strong> <U>

          <?=$_SESSION[session_fullname]?>

          </U></span><BR>          <span class="txtwhite"><strong>&nbsp;&nbsp;หน่วยงาน :</strong>&nbsp;<U>

          <?=$_SESSION[session_depname]?>

          </U></span><BR>          <span class="txtwhite"><strong>&nbsp;&nbsp;</strong></span><BR>          </td>

          <td align="right" valign="bottom" class="fillcolor_loginleft2"><img src="images/user_information_22.gif" width="6" height="6"></td>

        </tr>

        

      </table></td>

      <td align="right" background="images/user_information_11.gif" style="background-repeat:repeat-y; background-position:right;">&nbsp;</td>

    </tr>

    <tr>

      <td align="left" valign="bottom" background="images/user_information_08.gif" style="background-repeat: repeat-y"><img src="images/user_information_23.gif" width="6" height="6"></td>

      <td height="5" background="images/user_information_25.gif" style="background-repeat:repeat-x; background-position:bottom">&nbsp;</td>

      <td align="right" valign="bottom" background="images/user_information_11.gif" style="background-repeat:repeat-y; background-position:right;"><img src="images/user_information_26.gif" width="6" height="6"></td>

    </tr>

  </table></TD>

</TR>

</TABLE>



<?
if ($_SESSION[session_sapphire] == 1 ){
$main_url = "index_key_report.php" ;
}else if($_SESSION[session_status_extra] == "QC"){ // กรณีมีหน้าที่พิเศษที่ไม่ใช้พนักงาน sapphire
$main_url = "report_user_preview1.php";
}else{
$main_url = "report_user_preview1.php" ;
}


$menu_group = array("หน้าหลัก"=>"$main_url,mainFrame","ระบบค้นหาข้อมูล"=>"qsearch2.php,mainFrame","การจัดการข้อมูลระบบ"=>"","รายงาน"=>"","ทดสอบความเร็ว"=>"../diagnose/bandwidth/initialmeter.php,_blank","ออกจากระบบ"=>"logout.php,_top");

//diagnose/bandwidth/initialmeter.php


if ($_SESSION[session_sapphire] == 1 ){
	


$menu_array = array(

"การจัดการข้อมูลระบบ"=>array("ระบบมอบหมายงาน ก.พ.7"=>"index_assign_key.php","ตรวจสอบและรับรองการบันทึกข้อมูล"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","บริหารจัดการหมวดรายการตรวจข้อมูล"=>"../validate_management/index.php,_blank",
							 "เครื่องมือในการปลดรับรองข้อมูล"=>"unlock_approve.php,_blank","ระบบนำเข้ารูป ก.พ.7"=>"../hr3/tool_competency/pic2cmss/_index.php","รายงานจัดการผู้ใช้"=>"org_user.php","แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","ระบบร้องขอแจ้งแก้ไขข้อมูล"=>"../req_approve/admin_sapphire/index.php,_blank","ระบบ Mornitor Keyin"=>"../msg_alert/login.php?user=$user&pwd=$pwd,_blank"),

//"รายงานการรับรองข้อมูล"=>"report_audit.php",
"รายงาน"=>array("รายงานสถิติการบันทึกข้อมูล"=>"report_keyin_user.php","รายงานสรุปค่าบันทึกเอกสาร"=>"report_keyin_user_p2p.php",
"สรุปภาพรวมการบันทึกข้อมูล"=>"report_sum_area.php?action=view",
"รายงานสถิติสำหรับผู้บริหาร"=>"index_key_report.php",
"การเข้างานลูกจ้างประจำ"=>"staff_worktime.php","รายงานสถิติการตรวจข้อมูล"=>"../validate_management/report_validate.php,_blank","รายงานค่า Incentive"=>"index_incentive.php,_blank")
//"รายงานสรุปการบันทึกข้อมูล"=>"report_sum.php",
//"ประมวลผล Ranking "=>"ranking.inc.php",
);
} else if($_SESSION[session_status_extra] == "QC"){ // กรณีมีหน้าที่พิเศษที่ไม่ใช้พนักงาน sapphire
$menu_array = array(

"การจัดการข้อมูลระบบ"=>array("ระบบมอบหมายงาน ก.พ.7"=>"index_assign_key.php","ตรวจสอบและรับรองการบันทึกข้อมูล"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","ระบบสุ่มตรวจสอบข้อมูล"=>"report_alert_qc1.php,_blank","ระบบนำเข้ารูป ก.พ.7"=>"../hr3/tool_competency/pic2cmss/_index.php","รายงานจัดการผู้ใช้"=>"org_user.php","แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","ระบบร้องขอแจ้งแก้ไขข้อมูล"=>"../req_approve/admin_sapphire/index.php,_blank"),

//"รายงานการรับรองข้อมูล"=>"report_audit.php",
"รายงาน"=>array("สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","รายงาน Incentive ประจำเดือน"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")



);


}else if($_SESSION[session_status_extra] == "GRAPHIC"){
			
		$menu_array = array(
"การจัดการข้อมูลระบบ"=>array("แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","ระบบนำเข้ารูป ก.พ.7"=>"../hr3/tool_competency/pic2cmss/_index.php"),
"รายงาน"=>array("สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","รายงาน Incentive ประจำเดือน"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")

);
	
}else if($_SESSION[session_status_extra] == "CALLCENTER"){
	$menu_array = array(
"การจัดการข้อมูลระบบ"=>array("แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","ระบบร้องขอแจ้งแก้ไขข้อมูล"=>"../req_approve/admin_sapphire/index.php,_blank"),
"รายงาน"=>array("สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] "));
}else{

$menu_array = array(
"การจัดการข้อมูลระบบ"=>array("แก้ไขข้อมูลส่วนตัว"=>"user_properties.php","รับรองค่าคะแนนการบันทึกข้อมูล"=>"report_keypiont_perday_index.php"),
//"รายงานการรับรองข้อมูล"=>"report_audit.php",
"รายงาน"=>array("สถิติการบันทึกข้อมูลของตนเอง"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","รายงาน Incentive ประจำเดือน"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")

);

}

if($_SESSION[session_staffid] != 93 AND $_SESSION[session_staffid] != 9948 AND $_SESSION[session_staffid] != 95 AND $_SESSION[session_staffid] != 57 AND $_SESSION[session_staffid] != 9974){
	unset($menu_array['รายงานจัดการผู้ใช้']);
}

if($_SESSION[session_staffid] == 10691){ // กรณีเป็น userของ ก.ค.ศ. ที่เข้ามาดูหน้ารายงาน
	unset($menu_group['การจัดการข้อมูลระบบ']);
	unset($menu_group['ระบบค้นหาข้อมูล']);
/*	"รายงาน"=>array("รายงานสถิติการบันทึกข้อมูล"=>"report_keyin_user.php","รายงานสรุปค่าบันทึกเอกสาร"=>"report_keyin_user_p2p.php",
"สรุปภาพรวมการบันทึกข้อมูล"=>"report_sum_area.php?action=view",
"รายงานสถิติสำหรับผู้บริหาร"=>"index_key_report.php",
"การเข้างานลูกจ้างประจำ"=>"staff_worktime.php","รายงานสถิติการตรวจข้อมูล"=>"../validate_management/report_validate.php,_blank","รายงานค่า Incentive"=>"index_incentive.php,_blank")*/
	unset($menu_array['รายงานสถิติสำหรับผู้บริหาร']);
	unset($menu_array['การเข้างานลูกจ้างประจำ']);
	unset($menu_array['รายงานสถิติการตรวจข้อมูล']);

}

//  $c= 0;
//  foreach ($menu_group as $caption=>$url){
//  		$exdata = explode(",",$url);
//		$url = $exdata[0];
//		$target = $exdata[1];
//		// สร้างหัวข้อ
//		if($url==""){$strurl = "$caption";}else{$strurl = "<a href=\"$url\" TARGET=\"$target\">$caption</a>";}
//		echo "<p class=\"menu_head\" >$strurl</p>\n";
//			
//			foreach ($menu_array as $key=>$val){
//				if($key==$caption){
//					echo "<div class=\"menu_body\">\n";
//					
//						foreach ($val as $key1=>$url1){
//							$exdata1 = explode(",",$url1);
//							$url1 = $exdata1[0];
//							if($exdata1[1] != ""){
//							$target = $exdata1[1];
//							}else{
//							$target = 'mainFrame';
//							}
//							echo "<a href=\"$url1\" TARGET=\"$target\" style=\"padding-left:15px\">$key1</a>\n";
//						}
//					echo "</div>";
//				}
//			}
//	}



		echo "<DIV id=content>";
		echo "<UL id=navmenu-v>";
  $c= 0;
  foreach ($menu_group as $caption=>$url){
  		$exdata = explode(",",$url);
		$url = $exdata[0];
		$target = $exdata[1];
		// สร้างหัวข้อ
		if($url==""){
			$strurl = "<LI><A href=\"#\">$caption +</A>"; 
			$endLI = "</LI>";
		}else{
			$strurl = "<LI><a href=\"$url\" TARGET=\"iframe_body\">$caption</a></LI>";
			$endLI = "";
		}
		echo "$strurl";
	
			
			foreach ($menu_array as $key=>$val){
				if($key==$caption){
						echo "<UL>";
					
						foreach ($val as $key1=>$url1){
							$exdata1 = explode(",",$url1);
							$url1 = $exdata1[0];
							if($exdata1[1] != ""){
							$target = $exdata1[1];
							}else{
							$target = 'iframe_body';
							}
							echo "<LI><a href=\"$url1\" TARGET=\"$target\" >$key1</a></LI>";
						}
					echo "</UL>";
				}
			}
			echo $endLI;
	}
		echo "</UL>";
		echo "</DIV>";


?>

</BODY></HTML>