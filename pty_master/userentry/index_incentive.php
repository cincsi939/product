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
			$mname	= array("","�.�.", "�.�.", "��.�.", "��.�.", "�.�.", "��.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.");
			$monthFull = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
		
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
          <td height="48" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px" >��§ҹ�ӹǳ��� Incentive</td>
        </tr>
		   <tr>
          <td align="center" class="headerTB"><table width="50%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td colspan="2" align="center" bgcolor="#A5B2CE"><strong>��Ǵ���� ��� Incentive</strong></td>
                  </tr>
                <tr>
                  <td width="12%" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
                  <td width="88%" align="center" bgcolor="#A5B2CE"><strong>��Ǵ��¡��</strong></td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#FFFFFF">1</td>
                  <td align="left" bgcolor="#FFFFFF"><a href="report_incentive_per_day.php">�ʴ�����������ѹ(FullTime)</a></td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#FFFFFF">2</td>
                  <td align="left" bgcolor="#FFFFFF"><a href="report_incentive_month.php">�ʴ������������͹(FullTime)</a></td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#FFFFFF">3</td>
                  <td align="left" bgcolor="#FFFFFF"><a href="report_incentive_per_day_parttime.php">�ʴ�����������ѹ(PartTime)</a></td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#FFFFFF">4</td>
                  <td align="left" bgcolor="#FFFFFF"><a href="report_incentive_month_parttime.php">�ʴ������������͹(PartTime)</a></td>
                </tr>
                <?
                	if($_SESSION['status_report_excellent'] == "1"){
				?>
                <tr>
                  <td align="center" bgcolor="#FFFFFF">*****</td>
                  <td align="left" bgcolor="#FFFFFF"><a href="report_monitor_excellent.php" target="_blank">��§ҹ����Ѻ���� Excellent</a></td>
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
                  <td align="left" bgcolor="#FFFFFF"><a href="script_updateincentive_maxpoint.php">��Ѻ��Ҥ�ṹ�óբ������ջѭ�Ҫ�ǧ�ѹ��� 8 - 10 �.�. 53</a></td>
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