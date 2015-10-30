<? 
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "applist";
$module_code 		= "report"; 
$process_id			= "report";
$VERSION 				= "9.1";
$BypassAPP 			= false;
#########################################################
#Developer::
#DateCreate::17/07/2007
#LastUpdate::17/07/2007
#DatabaseTabel::
#END
#########################################################
session_start();
set_time_limit(1000);
include ("session.inc.php");
include ("phpconfig.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();
include ("timefunc.inc.php");
Conn2DB();
            
$_SESSION[siteid]
	//		include("../../../inc/conndb.inc.php");
		//	include ("../../../common/std_function.inc.php")  ;
		//	include ("../../../common/common.inc.php")  ;
	
	//$time_start = getmicrotime();

	/*
	echo "<pre>";
	print_r($_SESSION[applistname]);
	print_r($_SESSION[applistid]);
	echo "</pre>";
	//echo "<hr>$db_mainobec";
	*/
           
		?>
<HTML>
<HEAD>
<TITLE>application list</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="../../../common/style.css" rel="stylesheet" type="text/css">
<link href="example.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="tabber.js"></script>
<style type="text/css">
<!--
body {
	margin-left: 10px;
	margin-top: 5px;
	margin-right: 10px;
	margin-bottom: 5px;
}
.gp {
  color            : #9A9A9A;
  background-color : #1D5B84;  filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#9A9A9A', EndColorStr='#ffffff');
  font-weight      : bold;
  padding-left:10px;
}
-->
</style>
<script type="text/javascript">
document.write('<style type="text/css">.tabber{display:none;}<\/style>');
</script>
</HEAD>
<BODY BGCOLOR=#FFFFFF>

<div class="tabber">

     <div class="tabbertab">
	  <h2>ระบบควบคุม</h2>
	  <?
	  If ($mode == "1")
	  { // เขตพื้นที่
	  ?>
	  <table width="80%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
        <tr bgcolor="#ffffff">
          <td height="25" bgcolor="#000066"><font style="font-size:16px; font-weight:bold; color:#FFFFFF;"><b>หน่วยงาน ::
                <?
					$unit=$_REQUEST['unit'];
				   	$showgroup = mysql_query("select * from login  where username = '$unit';");
					
					$rsshow = mysql_fetch_array($showgroup,MYSQL_ASSOC);
					echo "$rsshow[office]";
			?>
          </b></font></td>
        </tr>
           <!--  <tr bgcolor="#ffffff">
        <td height="25">&nbsp;- <a href="list.php?unit=<?=$unit?>&groupping=<?=$unit?>&mode=2" target="_blank">รายชื่อบุคลากรในสำนักงานเขตพื้นที่การศึกษา </a></td>
        </tr>
        <tr bgcolor="#ffffff">
       <td height="25">&nbsp;- <a href="list.php?unit=<?=$unit?>&groupping=<?=$unit?>&mode=1" target="_blank">รายชื่อโรงเรียนภายในเขตพื้นที่</a></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25">&nbsp;- <a href="../tool_competency/statistic_userreport.php" target="_blank">รายงานสถิติการเข้าใช้ระบบรายหน่วยงาน</a></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25">&nbsp;- <a href="../tool_competency/statistic_report_neveruse.php" target="_blank">รายงานสถิติผู้ไม่เคยเข้าใช้งานระบบ</a></td>
        </tr>
<tr bgcolor="#ffffff">
	<td height="25">&nbsp;- <a href="listrequest.php" target="_blank">รายชื่อบุคลากรในสำนักงานเขตพื้นที่การศึกษาที่ขอปรับปรุงข้อมูล </a></td>
</tr>	-->
<tr bgcolor="#ffffff">
	<td height="25">&nbsp;- <a href="list_people_advance.php" target="_blank">ค้นหารายชื่อบุคลากรในสำนักงานเขตพื้นที่การศึกษา  แบบละเอียด</a></td>
</tr>

<tr bgcolor="#ffffff">
	<td height="25">&nbsp;- <a href="list_request_area.php" target="_blank">แสดงรายชื่อบุคลากรในสำนักงานเขตพื้นที่การศึกษา</a></td>
</tr>
<tr bgcolor="#ffffff">
	<td height="25">&nbsp;- <a href="list_people.php" target="_blank">ค้นหารายชื่อบุคลากรในสำนักงานเขตพื้นที่การศึกษา</a></td>
</tr>	
	</table>
	  <p>
	    <? } elseif ($mode == "2") { ?>
	  </p>
	  <table width="80%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
        <!-- <tr bgcolor="#ffffff">
          <td height="25" bgcolor="#000066"><font style="font-size:16px; font-weight:bold; color:#FFFFFF;"><b>หน่วยงาน
                <?
				   	$showgroup = mysql_query("select * from office_detail  where id = '$unit';");
					
					$rsshow = mysql_fetch_array($showgroup,MYSQL_ASSOC);
					echo "$rsshow[th_name]";
			?>
          </b></font></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25">
		  <a href="list.php?unit=<?=$unit?>&groupping=<?=$unit?>&mode=2" target="_blank">
		  &nbsp;- รายชื่อบุคลากรในโรงเรียน 
            <?
				   //	$showgroup = mysql_query("select * from office_detail  where id = '$unit';");
					
					//$rsshow = mysql_fetch_array($showgroup,MYSQL_ASSOC);
					echo "$rsshow[th_name]";
			?>
        </a>		</td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25"><a href="subject.php?unit=<?=$unit?>" target="_blank">&nbsp;- บันทึกข้อมูลการสอนรายบุคคลในโรงเรียน
              <?
				   	//$showgroup = mysql_query("select * from office_detail  where id = '$unit';");
					
					//$rsshow = mysql_fetch_array($showgroup,MYSQL_ASSOC);
					echo "$rsshow[th_name]";
			?>
          </a></td>
        </tr>

        <tr bgcolor="#ffffff">
          <td height="25"><a href="school_data.php?id=<?=$unit?>" target="_blank">&nbsp;- แก้ไขข้อมูลของโรงเรียน
          </a></td>
        </tr>

      </table>
	  <p>
<? } elseif($mode == "3"){ ?>
<table width="80%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
<tr bgcolor="#000066">
	<td height="25"><font style="font-size:16px; font-weight:bold; color:#FFFFFF;"><b>Administrator</b></font></td>
</tr>
<tr bgcolor="#ffffff">
	<td height="25">&nbsp;-&nbsp;<a href="salary_rate_citizen.php" target="_blank">อัตราเงินเดือนพลเรือน</a></td>
</tr>-->
</table>
<? } ?>
</p>
     </div>


     <div class="tabbertab">
	  <h2>รายงาน</h2>
	  <p>
	    <?
	  If ($mode == "1")
	  { // เขตพื้นที่
	  ?>
</p>
      <table width="80%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
        <tr bgcolor="#ffffff">
          <td height="25" bgcolor="#000066"><font style="font-size:16px; font-weight:bold; color:#FFFFFF;"><b>หน่วยงาน
            <?
				   	$showgroup = mysql_query("select * from office_detail  where id = '$unit';");
					
					$rsshow = mysql_fetch_array($showgroup,MYSQL_ASSOC);
					echo "$rsshow[th_name]";
			?>
          </b></font></td>
        </tr>
         <!--
        <tr bgcolor="#ffffff">
          <td height="25">&nbsp;- <a href="liststatus.php?unit=<?=$unit?>&groupping=<?=$unit?>"  target="_blank">สถานะการยืนยันข้อมูลของบุคลากร </a></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25">&nbsp;- <a href="activity_log_list.php"  target="_blank">รายงานการออกเอกสารสำเนา กพ.7 </a></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25">&nbsp;- <a href="activity_verify.php?unit=<?=$unit?>&groupping=<?=$unit?>"  target="_blank">ตรวจสอบสำเนาเอกสาร ก.พ.7 </a></td>
        </tr>
		
        <tr bgcolor="#ffffff">
          <td height="25">&nbsp;- <a href="list_unit.php?mode=1"  target="_blank">ข้าราชการและบุคลากรในการบังคับบัญชา รายหน่วยงาน</a></td>
        </tr>
		
        <tr bgcolor="#ffffff">
          <td height="25">&nbsp;- <a href="ex_sum_report.php" target="_blank">รายงานภาพรวมแบ่งตามกลุ่มตำแหน่งบุคคลากร</a></td>
        </tr>
<tr bgcolor="#ffffff">
<td height="25">&nbsp;- <a href="listapprove.php?unit=<?=$unit?>&groupping=<?=$unit?>&mode=1" target="_blank">
รายงานแสดงจำนวนบุคลากรทีรับรองข้อมูลทั้งหมด</a></td>
</tr>
<tr bgcolor="#ffffff">
  <td height="25">&nbsp;- <a href="listapprove_j18_ampur.php?mode=1" target="_blank"> รายงานแสดงจำนวนบุคลากรที่ตาม จ.18 </a></td>
</tr>
<tr bgcolor="#ffffff">
  <td height="25">&nbsp;- <a href="report_j18all.php" target="_blank"> รายงานแสดงจำนวนบุคลากรตามรูปแบบ กจ.</a></td>
</tr>
<tr bgcolor="#ffffff">
  <td height="25">&nbsp;- <a href="../plan_staff/index.php" target="_blank"> รายงานจำนวนอัตรากำลัง</a></td>
</tr>
<tr bgcolor="#ffffff">
  <td height="25">&nbsp;- <a href="report_vitaya_list.php" target="_blank"> รายชื่อบุคลากรที่มีคุณสมบัติผ่านเกณฑ์มี/เลื่อน วิทยะฐานะ</a></td>
</tr>	 -->
      </table>
      <p>
        <? } elseif ($mode == "2") { ?>
      </p>
      <table width="80%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
        <tr bgcolor="#ffffff">
          <td height="25" bgcolor="#000066"><font style="font-size:16px; font-weight:bold; color:#FFFFFF;"><b>หน่วยงาน
            <?
				   	$showgroup = mysql_query("select * from office_detail  where id = '$unit';");
					
					$rsshow = mysql_fetch_array($showgroup,MYSQL_ASSOC);
					echo "$rsshow[th_name]";
			?>
          </b></font></td>
        </tr>
         <!--
        <tr bgcolor="#ffffff">
          <td height="25">&nbsp;-<a href="liststatus.php?unit=<?=$unit?>&groupping=<?=$unit?>"  target="_blank"> สถานะการยืนยันข้อมูลของบุคลากร </a></td>
        </tr>
<tr bgcolor="#ffffff">
<td height="25">&nbsp;- <a href="listapprove.php?mode=2&unit=<?=$unit?>&sta=view&condition=0" target="_blank">
รายงานแสดงจำนวนบุคลากรทีรับรองข้อมูลทั้งหมด</a></td>
</tr>	-->		
      </table>
      <p>
        <?
} //end if
?>
      </p>
     </div>


</div>

<table width="100%" border="0">
  <tr>
    <td align="right"><a href="logout_edit.php" target="_top"><img src="../../../images_sys/logout.jpg" alt="ออกจากระบบ" width="75" height="25" border="0" class="fillcolor_topdown"></a></td>
  </tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>




