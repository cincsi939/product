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
	## Modified Detail :		��§ҹ��úѹ�֡������
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
include "epm.inc.php";
include("../../common/class.getdata_master.php");

$obj = new GetDataMaster();
function GetCountData(){
	global $dbnamemaster;
	$sql = "SELECT siteid,count(idcard) as num1 FROM `view_data_uncomplete` group by siteid ";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]] = $rs[num1];
	}
	return $arr;
} // end function GetCountData(){

?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
</head>
<body bgcolor="#EFEFFF">
<? if($action == ""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>��§ҹ�����ŷ���ͧ�ӡ�úѹ�֡����������ش㹿���� excel �¡���ࢵ</strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>�ӴѺ</strong></td>
        <td width="61%" align="center" bgcolor="#CCCCCC"><strong>�ӹѡ�ҹࢵ��鹷�����֡��</strong></td>
        <td width="35%" align="center" bgcolor="#CCCCCC"><strong>�����ŷ���������(��)</strong></td>
        </tr>
      <?
      	$sql = "SELECT
t1.secid,
t1.secname,
t1.secname_short
FROM
 ".DB_MASTER.".eduarea AS t1
where t1.status='1' AND t1.secid NOT LIKE '99%'
group by t1.secid";
		$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
		$j=0;
		$arrdata = GetCountData();
		while($rs = mysql_fetch_assoc($result)){
				  if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$j?></td>
        <td align="left"><?=$rs[secname_short]?></td>
        <td align="right"><? if($arrdata[$rs[secid]] > 0){ echo "<a href='?action=view&xsiteid=$rs[secid]&mode=1' target=\"_blank\">".number_format($arrdata[$rs[secid]])."</a>";}else{ echo "0";}?></td>
        </tr>
      <?
	  $sum1 += $arrdata[$rs[secid]];
		}//end 	while($rs = mysql_fetch_assoc($result)){
	  ?>
            <tr bgcolor="<?=$bg?>">
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>���</strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong><?=number_format($sum1)?></strong></td>
        </tr>

    </table></td>
  </tr>
</table>
<?
		}//end if($action == ""){
	if($action == "view"){	
	$secname_short = $obj->GetAreaName($xsiteid,"secname_short");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="25" bgcolor="#CCCCCC"><strong>�ٻẺ������ѹ�֡������� excel ���ʹ֧����������к� 
          <?=$obj->GetAreaName($xsiteid);?>
        </strong></td>
        </tr>
      <tr>
        <td width="4%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>�Ţ���<br>
          �����</strong></td>
        <td width="3%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ŧ�ѹ���</strong></td>
        <td width="3%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>��� � �ѹ���</strong></td>
        <td width="7%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ࢵ��鹷�����֡��</strong></td>
        <td width="12%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>�ç���¹<br>
          (�ó��繤�����ç���¹)</strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>�ӹ�˹�Ҫ���</strong></td>
        <td width="2%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>����</strong></td>
        <td width="4%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>���ʡ��</strong></td>
        <td width="7%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>�Ţ���ѵû�ЪҪ�</strong></td>
        <td width="4%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>���˹�</strong></td>
        <td width="4%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>�Է°ҹ�</strong></td>
        <td width="6%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>���˹��Ţ���</strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>�ѵ���Թ��͹</strong></td>
        <td width="6%" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>����͹���<br>
          ���Ѻ���</strong></td>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>��ҵͺ᷹�Թ��͹</strong></td>
        <td colspan="7" align="center" bgcolor="#CCCCCC"><strong>��������ǹ����</strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>�ѹ�Ѻ</strong></td>
        <td width="2%" align="center" bgcolor="#CCCCCC"><strong>���</strong></td>
        <td width="8%" align="center" bgcolor="#CCCCCC"><strong>2%</strong></td>
        <td width="2%" align="center" bgcolor="#CCCCCC"><strong>4%</strong></td>
        <td width="2%" align="center" bgcolor="#CCCCCC"><strong>6%</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>����֡���٧�ش</strong></td>
        <td width="1%" align="center" bgcolor="#CCCCCC"><strong>�زԡ���֡��</strong></td>
        <td width="1%" align="center" bgcolor="#CCCCCC"><strong>�ç���¹</strong></td>
        <td width="1%" align="center" bgcolor="#CCCCCC"><strong>�ѹ��͹���Դ</strong></td>
        <td width="1%" align="center" bgcolor="#CCCCCC"><strong>�ѹ�������Ժѵ��Ҫ���</strong></td>
        <td width="1%" align="center" bgcolor="#CCCCCC"><strong>��</strong></td>
        <td width="1%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
        <?
        	$sql = "SELECT
t1.idcard,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t1.begindate,
t1.position_now,
t1.schoolid,
t2.office
FROM
view_data_uncomplete AS t1
Left Join allschool AS t2 ON t1.schoolid = t2.id
WHERE
t1.siteid =  '$xsiteid'";
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
		  if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		  
		   $filekp7 = "../../../edubkk_kp7file/$rs[siteid]/$rs[idcard].pdf";
		 if(is_file($filekp7)){
				 $link_kp7 = "<a href=\"$filekp7\" target=\"_blank\"><img src=\"../../images_sys/gnome-mime-application-pdf.png\" alt=\"�͡��� �.�.7 �鹩�Ѻ\" width=\"16\" height=\"16\" border=\"0\"></a>";
		}else{
				$link_kp7 = "";
		}
		  
		?>
        
      <tr bgcolor="<?=$bg?>">
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left"><?=$secname_short?></td>
        <td align="left">&nbsp;</td>
        <td align="left"><?=$rs[prename_th]?></td>
        <td align="left"><?=$rs[name_th]?></td>
        <td align="left"><?=$rs[surname_th]?></td>
        <td align="left"><?=$rs[idcard]?></td>
        <td align="left"><?=$rs[position_now]?></td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left"><?=$rs[office]?></td>
        <td align="left"><?=$rs[birthday]?></td>
        <td align="left"><?=$rs[begindate]?></td>
        <td align="left"><?=$obj->GetSexFormPrename($rs[prename_th]);?></td>
        <td align="center"><?=$link_kp7?></td>
        </tr>
        <?
	}//end 
		?>
    </table></td>
  </tr>
</table>
<?
	}//end 	if($action == "view"){
?>
</BODY>
</HTML>
