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
	  <h2>�к��Ǻ���</h2>
	  <?
	  If ($mode == "1")
	  { // ࢵ��鹷��
	  ?>
	  <table width="80%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
        <tr bgcolor="#ffffff">
          <td height="25" bgcolor="#000066"><font style="font-size:16px; font-weight:bold; color:#FFFFFF;"><b>˹��§ҹ ::
                <?
					$unit=$_REQUEST['unit'];
				   	$showgroup = mysql_query("select * from login  where username = '$unit';");
					
					$rsshow = mysql_fetch_array($showgroup,MYSQL_ASSOC);
					echo "$rsshow[office]";
			?>
          </b></font></td>
        </tr>
           <!--  <tr bgcolor="#ffffff">
        <td height="25">&nbsp;- <a href="list.php?unit=<?=$unit?>&groupping=<?=$unit?>&mode=2" target="_blank">��ª��ͺؤ�ҡ���ӹѡ�ҹࢵ��鹷�����֡�� </a></td>
        </tr>
        <tr bgcolor="#ffffff">
       <td height="25">&nbsp;- <a href="list.php?unit=<?=$unit?>&groupping=<?=$unit?>&mode=1" target="_blank">��ª����ç���¹����ࢵ��鹷��</a></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25">&nbsp;- <a href="../tool_competency/statistic_userreport.php" target="_blank">��§ҹʶԵԡ��������к����˹��§ҹ</a></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25">&nbsp;- <a href="../tool_competency/statistic_report_neveruse.php" target="_blank">��§ҹʶԵԼ������������ҹ�к�</a></td>
        </tr>
<tr bgcolor="#ffffff">
	<td height="25">&nbsp;- <a href="listrequest.php" target="_blank">��ª��ͺؤ�ҡ���ӹѡ�ҹࢵ��鹷�����֡�ҷ��ͻ�Ѻ��ا������ </a></td>
</tr>	-->
<tr bgcolor="#ffffff">
	<td height="25">&nbsp;- <a href="list_people_advance.php" target="_blank">������ª��ͺؤ�ҡ���ӹѡ�ҹࢵ��鹷�����֡��  Ẻ�����´</a></td>
</tr>

<tr bgcolor="#ffffff">
	<td height="25">&nbsp;- <a href="list_request_area.php" target="_blank">�ʴ���ª��ͺؤ�ҡ���ӹѡ�ҹࢵ��鹷�����֡��</a></td>
</tr>
<tr bgcolor="#ffffff">
	<td height="25">&nbsp;- <a href="list_people.php" target="_blank">������ª��ͺؤ�ҡ���ӹѡ�ҹࢵ��鹷�����֡��</a></td>
</tr>	
	</table>
	  <p>
	    <? } elseif ($mode == "2") { ?>
	  </p>
	  <table width="80%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
        <!-- <tr bgcolor="#ffffff">
          <td height="25" bgcolor="#000066"><font style="font-size:16px; font-weight:bold; color:#FFFFFF;"><b>˹��§ҹ
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
		  &nbsp;- ��ª��ͺؤ�ҡ���ç���¹ 
            <?
				   //	$showgroup = mysql_query("select * from office_detail  where id = '$unit';");
					
					//$rsshow = mysql_fetch_array($showgroup,MYSQL_ASSOC);
					echo "$rsshow[th_name]";
			?>
        </a>		</td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25"><a href="subject.php?unit=<?=$unit?>" target="_blank">&nbsp;- �ѹ�֡�����š���͹��ºؤ����ç���¹
              <?
				   	//$showgroup = mysql_query("select * from office_detail  where id = '$unit';");
					
					//$rsshow = mysql_fetch_array($showgroup,MYSQL_ASSOC);
					echo "$rsshow[th_name]";
			?>
          </a></td>
        </tr>

        <tr bgcolor="#ffffff">
          <td height="25"><a href="school_data.php?id=<?=$unit?>" target="_blank">&nbsp;- ��䢢����Ţͧ�ç���¹
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
	<td height="25">&nbsp;-&nbsp;<a href="salary_rate_citizen.php" target="_blank">�ѵ���Թ��͹�����͹</a></td>
</tr>-->
</table>
<? } ?>
</p>
     </div>


     <div class="tabbertab">
	  <h2>��§ҹ</h2>
	  <p>
	    <?
	  If ($mode == "1")
	  { // ࢵ��鹷��
	  ?>
</p>
      <table width="80%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
        <tr bgcolor="#ffffff">
          <td height="25" bgcolor="#000066"><font style="font-size:16px; font-weight:bold; color:#FFFFFF;"><b>˹��§ҹ
            <?
				   	$showgroup = mysql_query("select * from office_detail  where id = '$unit';");
					
					$rsshow = mysql_fetch_array($showgroup,MYSQL_ASSOC);
					echo "$rsshow[th_name]";
			?>
          </b></font></td>
        </tr>
         <!--
        <tr bgcolor="#ffffff">
          <td height="25">&nbsp;- <a href="liststatus.php?unit=<?=$unit?>&groupping=<?=$unit?>"  target="_blank">ʶҹС���׹�ѹ�����Ţͧ�ؤ�ҡ� </a></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25">&nbsp;- <a href="activity_log_list.php"  target="_blank">��§ҹ����͡�͡������� ��.7 </a></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td height="25">&nbsp;- <a href="activity_verify.php?unit=<?=$unit?>&groupping=<?=$unit?>"  target="_blank">��Ǩ�ͺ�����͡��� �.�.7 </a></td>
        </tr>
		
        <tr bgcolor="#ffffff">
          <td height="25">&nbsp;- <a href="list_unit.php?mode=1"  target="_blank">����Ҫ�����кؤ�ҡ�㹡�úѧ�Ѻ�ѭ�� ���˹��§ҹ</a></td>
        </tr>
		
        <tr bgcolor="#ffffff">
          <td height="25">&nbsp;- <a href="ex_sum_report.php" target="_blank">��§ҹ�Ҿ����觵����������˹觺ؤ��ҡ�</a></td>
        </tr>
<tr bgcolor="#ffffff">
<td height="25">&nbsp;- <a href="listapprove.php?unit=<?=$unit?>&groupping=<?=$unit?>&mode=1" target="_blank">
��§ҹ�ʴ��ӹǹ�ؤ�ҡ÷��Ѻ�ͧ�����ŷ�����</a></td>
</tr>
<tr bgcolor="#ffffff">
  <td height="25">&nbsp;- <a href="listapprove_j18_ampur.php?mode=1" target="_blank"> ��§ҹ�ʴ��ӹǹ�ؤ�ҡ÷���� �.18 </a></td>
</tr>
<tr bgcolor="#ffffff">
  <td height="25">&nbsp;- <a href="report_j18all.php" target="_blank"> ��§ҹ�ʴ��ӹǹ�ؤ�ҡõ���ٻẺ ��.</a></td>
</tr>
<tr bgcolor="#ffffff">
  <td height="25">&nbsp;- <a href="../plan_staff/index.php" target="_blank"> ��§ҹ�ӹǹ�ѵ�ҡ��ѧ</a></td>
</tr>
<tr bgcolor="#ffffff">
  <td height="25">&nbsp;- <a href="report_vitaya_list.php" target="_blank"> ��ª��ͺؤ�ҡ÷���դس���ѵԼ�ҹࡳ����/����͹ �Է�аҹ�</a></td>
</tr>	 -->
      </table>
      <p>
        <? } elseif ($mode == "2") { ?>
      </p>
      <table width="80%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
        <tr bgcolor="#ffffff">
          <td height="25" bgcolor="#000066"><font style="font-size:16px; font-weight:bold; color:#FFFFFF;"><b>˹��§ҹ
            <?
				   	$showgroup = mysql_query("select * from office_detail  where id = '$unit';");
					
					$rsshow = mysql_fetch_array($showgroup,MYSQL_ASSOC);
					echo "$rsshow[th_name]";
			?>
          </b></font></td>
        </tr>
         <!--
        <tr bgcolor="#ffffff">
          <td height="25">&nbsp;-<a href="liststatus.php?unit=<?=$unit?>&groupping=<?=$unit?>"  target="_blank"> ʶҹС���׹�ѹ�����Ţͧ�ؤ�ҡ� </a></td>
        </tr>
<tr bgcolor="#ffffff">
<td height="25">&nbsp;- <a href="listapprove.php?mode=2&unit=<?=$unit?>&sta=view&condition=0" target="_blank">
��§ҹ�ʴ��ӹǹ�ؤ�ҡ÷��Ѻ�ͧ�����ŷ�����</a></td>
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
    <td align="right"><a href="logout_edit.php" target="_top"><img src="../../../images_sys/logout.jpg" alt="�͡�ҡ�к�" width="75" height="25" border="0" class="fillcolor_topdown"></a></td>
  </tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>




