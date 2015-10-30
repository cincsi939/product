<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AdminReport";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Pairoj
#DateCreate::29/03/2007
#LastUpdate::29/03/2007
#DatabaseTable::schooll_name, login
#END
#########################################################
session_start();
			set_time_limit(0);
			include("../../config/conndb_nonsession.inc.php");
			
			$curent_date = date("Y-m-d");
			$dbnameuse = DB_USERENTRY;
			$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		
?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<SCRIPT SRC="sorttable.js"></SCRIPT>
<script language="javascript">

</script>
</HEAD>
<BODY >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px" >รายงานคำนวณค่า Incentive</td>
        </tr>
		   <tr>
          <td align="center" class="headerTB"><table width="50%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td colspan="2" align="center" bgcolor="#A5B2CE"><strong>หมวดเมนู ค่า Incentive</strong></td>
                  </tr>
                <tr>
                  <td width="12%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
                  <td width="88%" align="center" bgcolor="#A5B2CE"><strong>หมวดรายการ</strong></td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#FFFFFF">1</td>
                  <td align="left" bgcolor="#FFFFFF"><a href="report_incentive_per_day.php">แสดงข้อมูลรายวัน(FullTime)</a></td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#FFFFFF">2</td>
                  <td align="left" bgcolor="#FFFFFF"><a href="report_incentive_month.php">แสดงข้อมูลรายเดือน(FullTime)</a></td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#FFFFFF">3</td>
                  <td align="left" bgcolor="#FFFFFF"><a href="report_incentive_per_day_parttime.php">แสดงข้อมูลรายวัน(PartTime)</a></td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#FFFFFF">4</td>
                  <td align="left" bgcolor="#FFFFFF"><a href="report_incentive_month_parttime.php">แสดงข้อมูลรายเดือน(PartTime)</a></td>
                </tr>
                <?
                	if($_SESSION['status_report_excellent'] == "1"){
				?>
                <tr>
                  <td align="center" bgcolor="#FFFFFF">*****</td>
                  <td align="left" bgcolor="#FFFFFF"><a href="report_monitor_excellent.php" target="_blank">รายงานสำหรับค้นหา Excellent</a></td>
                </tr>
                <?
					}//end if($_SESSION['status_report_excellent'] == "1"){
				?>
                <tr>
                  <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
                  <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#FFFFFF">***</td>
                  <td align="left" bgcolor="#FFFFFF"><a href="script_updateincentive_maxpoint.php">ปรับค่าคะแนนกรณีข้อมูลมีปัญหาช่วงวันที่ 8 - 10 พ.ย. 53</a></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
		   <tr>
		     <td class="headerTB">&nbsp;</td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
</BODY></HTML>