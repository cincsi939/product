<?
session_start();
set_time_limit(0);
$ApplicationName	= "userentry";
$module_code 		= "manage_keyin_data"; 
$process_id			= "report_staffkey_addpercen";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110709.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-07-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110709.00
	## Modified Detail :		��§ҹ��ṹ������úѹ�֡�����Ţͧ��ѡ�ҹ���������
	## Modified Date :		2011-07-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
			require_once("../../../config/conndb_nonsession.inc.php");
			include ("../../../common/common_competency.inc.php")  ;
			include("../function_face2cmss.php");
			include("../function_date.php");
			include("../function_get_data.php");
			$k12 = 0.1051;
			$percenadd = 5;
			
			$count_yy = date("Y")+543;
			$mname	= array("","�.�.", "�.�.", "��.�.", "��.�.", "�.�.", "��.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.");
			$monthFull = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");

			
			$time_start = getmicrotime();
			$arrsite = GetSiteKeyData();
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			
			
			
			
			
			
	function ShowStartdate($staffid){
	global $dbnameuse;
	$sql = "SELECT start_date FROM `keystaff` where staffid='$staffid' group by staffid";	
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[start_date] != "" and $rs[start_date] != "0000-00-00"){
		return ShowDateThai($rs[start_date]);
	}else{
		return "";	
	}
}
			
			
		function ShowDateThai($get_date){
			global $monthFull;
			$arr = explode(" ",$get_date);
			if($arr > 1){
				$get_date = $arr[0];
			}
			if($get_date != "0000-00-00"){
				$arr1 = explode("-",$get_date);	
				return intval($arr1[2])." ".$monthFull[intval($arr1[1])]." ".($arr1[0]+543);
			}else{
				return "";	
			}
		}//end function ShowDateThai($get_date){

		
		
		$sql1 = "SELECT 
t2.prename,
t2.staffname,
t2.staffsurname,
t2.start_date
FROM stat_addkpoint_report as t1
Inner Join  keystaff AS t2 ON t1.staffid=t2.staffid
where t1.staffid='$staffid' and t1.datekeyin between '$date1' and '$date2'
GROUP BY t1.staffid";
$result1 = mysql_db_query($dbnameuse,$sql1) or die();
$rs1 = mysql_fetch_assoc($result1);

$arrd1 = explode("-",$date2);
$m1 = $arrd1[1];
		


?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="../../../common/jquery_1_3_2.js"></script>


<style type="text/css">
.txthead {	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txthead {	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
</style>
</HEAD>
<BODY >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="100%" align="center" bgcolor="#FFFFFF"><strong>��§ҹ��� Incentive ��Ш���͹&nbsp;<?=$monthFull[intval($m1)]?>&nbsp;<?=$arrd1[0]+543?><br>
              �ͧ&nbsp;<? echo "$rs1[prename]$rs1[staffname] $rs1[staffsurname]";?>&nbsp;�ѹ�������Ժѵԧҹ&nbsp;<?=ShowDateThai($rs1[start_date])?></strong></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="18%" align="center" bgcolor="#999999"><strong>�ѹ���</strong></td>
        <td width="9%" align="center" bgcolor="#999999"><strong>��ṹ�Ժ</strong></td>
        <td width="11%" align="center" bgcolor="#999999"><strong>�������Է�ԡ��<br>
          �����ż� Server ���</strong></td>
        <td width="9%" align="center" bgcolor="#999999"><strong>��ṹ��͹<br>
�ѡ�ش�Դ</strong></td>
        <td width="13%" align="center" bgcolor="#999999"><strong>��ṹ��ǧ���˹ѡ<br>
          �س�Ҿ(QC) (��ṹ)</strong></td>
        <td width="10%" align="center" bgcolor="#999999"><strong>��ṹ<br>
�ط������ѹ</strong></td>
        <td width="12%" align="center" bgcolor="#999999"><strong>Incentive  <br>
          ����ѹ(��ṹ)</strong></td>
        <td width="9%" align="center" bgcolor="#999999"><strong>Incentive <br>
����(��ṹ)</strong></td>
        <td width="9%" align="center" bgcolor="#999999"><strong>Incentive <br> 
          (�ҷ)
</strong></td>
      </tr>
        <?
        	$sql = "SELECT
t1.staffid,
t1.datekeyin,
t1.numkpoint,
t1.k5percen,
t1.kpoint_add5p,
t1.k_date,
t1.v_k_date,
t1.vk_serverdown,
t1.point_addserver,
t1.netkpoint,
t1.subtarct_val,
t1.kpoint_end,
t1.point_add,
t1.point_add_net,
t1.stat_pointadd,
t1.incentive
FROM stat_addkpoint_report as t1
where t1.staffid='$staffid' and t1.datekeyin between '$date1' and '$date2'
order by 
t1.datekeyin ASC";
//echo $sql;
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
		 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		 $numpoint_b = $rs['numkpoint']+$rs['k5percen']+$rs['vk_serverdown']; // ��ṹ�Ժ
		 $numpoint_server = $rs['v_k_date']; // ��ṹ�������Է�ԡ�û����ż� Server ���
		 $numpoint_befor  = $numpoint_b+$numpoint_server; // ��ṹ��͹�ѡ�ش�Դ
		 $num_sub = $rs[subtarct_val]; // ��ṹ�ش�Դ
		 $num_netpoint_day = $numpoint_befor-$num_sub; // ��ṹ����ѹ��͹�ѡ�ش�Դ
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="left" nowrap> <?=ShowDateThai($rs[datekeyin])?></td>
        <td align="center"><?=number_format($numpoint_b,2)?></td>
        <td align="center"><?=number_format($numpoint_server,2)?></td>
        <td align="center"><?=number_format($numpoint_befor,2)?></td>
        <td align="center"><?=number_format($num_sub,2)?></td>
        <td align="center"><?=number_format($num_netpoint_day,2)?></td>
        <td align="center"><?=number_format($rs[point_add],2)?></td>
        <td align="center"><?=number_format($rs[point_add_net],2)?></td>
        <td align="center"><?=number_format($rs[incentive],2)?></td>
      </tr>
      <?
	}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "����㹡�û����ż� :: $timeprocess";
?>
