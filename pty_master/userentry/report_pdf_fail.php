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
include("function_assign.php");
	if($_SERVER['REQUEST_METHOD'] == "POST"){
	
		if(count($xidcard) > 0 ){
			foreach($xidcard as $k => $v){
					$sql_up = "UPDATE log_pdf SET status_file = '1' WHERE idcard='$v'";
					mysql_db_query($dbnamemaster,$sql_up);
			}
			
				if(!(mysql_error())){
				echo "<script language='javascript'>alert('ź��¡�����º��������'); location.href='?secid=$secid&secname=$secname';</script>";
				exit();
			}
		}else{
		
				echo "<script language='javascript'>location.href='?secid=$secid&secname=$secname';</script>";
				exit();
		}
			
		
	} // end if($_SERVER['REQUEST_METHOD'] == "POST"){



?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript">
function confirmDelete(delUrl) {
  if (confirm("�س��㨷���ź������ cmss ��ԧ�������")) {
    document.location = delUrl;
  }
}
</script></head>
<body bgcolor="#EFEFFF">
<form name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="6" align="center" bgcolor="#A3B2CC"><strong><?=$secname?>&nbsp;&nbsp;��§ҹ��¡�âͧ���.�. 7 �鹩�Ѻ�������ó� </strong></td>
          </tr>

        <tr>
          <td width="4%" align="center" bgcolor="#A3B2CC"><strong>�ӴѺ</strong></td>
          <td width="16%" align="center" bgcolor="#A3B2CC"><strong>���ʺѵ�</strong></td>
          <td width="20%" align="center" bgcolor="#A3B2CC"><strong>���� - ���ʡ�� </strong></td>
          <td width="22%" align="center" bgcolor="#A3B2CC"><strong>���˹�</strong></td>
          <td width="25%" align="center" bgcolor="#A3B2CC"><strong>˹��§ҹ</strong></td>
          <td width="13%" align="center" bgcolor="#A3B2CC"><strong>����¹ʶ��</strong></td>
        </tr>
		<?
	$sql = "SELECT log_pdf.idcard, view_general.prename_th, view_general.name_th, view_general.surname_th, view_general.position_now,
view_general.schoolname, log_pdf.secid FROM log_pdf Left Join view_general ON log_pdf.idcard = view_general.CZ_ID WHERE log_pdf.status_file =  '0' AND
log_pdf.secid =  '$secid' ";
	$result = mysql_db_query($dbnamemaster,$sql);
	$j=0;
	while($rs = mysql_fetch_assoc($result)){
	 if ($j++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	 
	 			$path_img = "../../../edubkk_kp7file/$rs[secid]/$rs[idcard]".".pdf";
				if(file_exists($path_img)){
					$link_img = "<a href='$path_img' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"20\" alt=\"�͡��� �.�.7 �鹩�Ѻ\" border=\"0\"></a>";
				}else{
					$link_img = "<font color='red'>�������� �.�.7 �鹩�Ѻ</a>";
				}

	 
		  ?>
        <tr bgcolor="<?=$bg?>">
          <td align="center"><?=$j?></td>
          <td align="left"><?=$rs[idcard]?><?=$link_img?></td>
          <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
          <td align="left"><? echo "$rs[position_now]";?></td>
          <td align="left"><? echo "$rs[schoolname]";?></td>
          <td align="center"><label>
            <input type="checkbox" name="xidcard[<?=$rs[idcard]?>]" value="<?=$rs[idcard]?>">
          �͡�������ó�</label></td>
        </tr>
		<?
			}
		?>
        <tr>
          <td colspan="6" align="center"><label>
		  <input type="hidden" name="secid" value="<?=$secid?>">
		  <input type="hidden" name="secname" value="<?=$secname?>">
            <input type="submit" name="Submit" value="�ѹ�֡����¹ʶҹ�">&nbsp;
			    <input type="button" name="btnB" value="��Ѻ˹����ѡ"  onClick="location.href='report.php'">
          </label></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
</BODY>
</HTML>
