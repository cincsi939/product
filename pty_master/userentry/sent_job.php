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
	## Modified Detail :		�к��觧ҹ
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM

set_time_limit(0);
include "epm.inc.php";
define('FPDF_FONTPATH','/fpdi/font/');
require_once('fpdi/fpdf.php');

include("function_assign.php");
//$type_cmss = "province"; // ��˹��ó����к��ͧ �ѧ��Ѵ
$s_db = STR_PREFIX_DB;
//if($dbnamemaster == "cmss_pro_master"){ $temp_site = "1300";};
$report_title = "�ͺ���¡�úѹ�֡������ �.�.7 ���Ѻ�����";



if($_SERVER['REQUEST_METHOD'] == "POST"){

	$amount_pay = str_replace(",","",$amount_pay);  // �ó��� ������

	$sql_update = "UPDATE tbl_assign_sub SET recive_date='".sw_date_indb($recive_date)."', sent_date='".sw_date_indb($sent_date)."', assign_status='YES', amount_pay='$amount_pay',assign_comment='$assign_comment' WHERE ticketid='$ticketid'";
	$result  = mysql_db_query($db_name,$sql_update);
//	echo "<pre>";
//	print_r($_POST);
if(count($idcard) > 0){
	foreach($idcard as $k1 => $v1){
	// �Դ ���ǹ�ͧ��� gen pdf �����������
/*		$source_path = $_SERVER['DOCUMENT_ROOT']."/edubkk_kp7file/$xsiteid[$k1]";  
		$dest_path = $_SERVER['DOCUMENT_ROOT']."/kp7_assign";
		$password = "$ticketid";
		$origFile = "$source_path/$v1.pdf";
		$destFile ="$dest_path/".$v1."_assign.pdf";
		$in_db = $v1."_assign.pdf";
		pdfEncrypt($origFile, $password, $destFile );
*/		
###  end �Դ ���ǹ�ͧ��� gen pdf �����������
		$xestimate_pay = str_replace(",","",$estimate_pay[$k1]); // ���������»���ҳ��ͪش
		$sql_up1 = "UPDATE tbl_assign_key SET kp7file ='$in_db', estimate_pay = '$xestimate_pay' WHERE ticketid='$ticketid' and idcard='$v1'";
		@mysql_db_query($db_name,$sql_up1);

	}// end foreach(){
}// end if(count($idcard) > 0){
	
	
	if($result){
		echo "<script>alert('�ѹ�֡���������º��������');
		 location.href='sent_job.php?ticketid=$ticketid&xmode=1';</script>";
		exit;
	}

}// end if($_SERVER['REQUEST_METHOD'] == "POST"){

?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<SCRIPT language=JavaScript>
function checkFields() {
	if(document.form1.sent_date.value == ""){
		alert("��س��к��ѹ���Ҵ��Ҩд��Թ�����������");
		document.form1.sent_date.focus();
		return false;
	}
}
</script>
</head>

<body bgcolor="#EFEFFF">
<table border=0 align=center cellspacing=1 cellpadding=2 width="98%">
<tr><td width=39><img src="images/user_icon.gif"></td>
<td width="908" align="left"><B style="font-size: 12pt;"><? if($xmode == ""){ $txt_mode = "��ǹ���ѹ�֡";}else if($xmode == "1"){ $txt_mode = "��ǹ�ͧ��è��§ҹ���Ѻ����Ѻ�ҹ";}else if($xmode == "2"){ $txt_mode = "��ǹ�ͧ����͵�Ǩ�ҹ";} echo "$txt_mode";?></B></td>
</tr>

<tr valign=top height=1 bgcolor="#808080"><td colspan=2></td></tr>

<tr valign=top><td colspan=2 align="center">
<BR></td>
</tr>
</table>

<form name="form1" method="post" action="" onSubmit="return checkFields();">
<input type="hidden" name="ticketid" value="<?=$ticketid?>">
<?
		$sql = "SELECT * FROM tbl_assign_sub WHERE ticketid='$ticketid'";
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		
?>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="4" align="right" bgcolor="#EFEFFF"><input type="submit" name="Submit" value="�ѹ�֡�Ѻ�ͺ�͡���"></td>
        </tr>
        <tr>
          <td colspan="4" align="left" bgcolor="#A5B6CE"><img src="logo_sapp.jpg" width="160" height="50"></td>
          </tr>
        <tr>
          <td colspan="3" align="left"><strong>˹ѧ����Ѻ�ͺ�͡��� ��.7</strong>&nbsp;&nbsp; <? 
		  if($_SESSION[session_sapphire] == "1"){ // ��� ੾�о�ѡ�ҹ sapphire ��ҹ��
			   if($rs[assign_status] == "YES"){ echo "<a href='assign_pdf.php?ticketid=$rs[ticketid]'><img src=\"../../images_sys/pdf.gif\" alt=\"���§ҹ���º�������Ǥ������ͻ����͡��� pdf\" width=\"20\" height=\"20\" border=\"0\"></a>";}
		   }//end   if($_SESSION[session_sapphire] == "1"){
		   ?></td>
          <td width="41%" align="right"><label>&nbsp;          </label></td>
        </tr>
		<? 
		if($rs[recive_date] != "0000-00-00"){
			$arr_rd =explode("-",$rs[recive_date]);
			$recive_date = sw_date_intxtbox($rs[recive_date]);
		}else{
			$recive_date = date("d/m")."/".(date("Y")+543);
		}
		
		?>
        <tr>
          <td width="16%" align="left"><strong>�����Ţ�ҹ :</strong></td>
          <td width="22%" align="left"><?=$ticketid?></td>
          <td width="21%" align="left"><strong>�ѹ����Ѻ�͡��� : </strong></td>
          <td align="left"><INPUT name="recive_date" onFocus="blur();" value="<?=$recive_date?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.recive_date, 'dd/mm/yyyy')"value="�ѹ��͹��"></td>
        </tr>
        <tr>
          <td align="left"><strong>����- ���ʡ�� : </strong></td>
          <td align="left"><?=show_user($rs[staffid]);?></td>
          <td align="left"><strong>�ѹ���Ҵ��Ҩд��Թ���<br>
            �������� : </strong></td>
          <td align="left"><INPUT name="sent_date" onFocus="blur();" value="<?=sw_date_intxtbox($rs[sent_date])?>" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.sent_date, 'dd/mm/yyyy')"value="�ѹ��͹��"></td>
        </tr>
        <tr>
          <td align="left"><strong>�����Ţ���Ѿ�� : </strong></td>
          <td align="left">
		  <?
		  $sql_user = "SELECT *  FROM  keystaff  WHERE staffid='$rs[staffid]'";
		  $result_user = mysql_db_query($db_name,$sql_user);
		  $rs_u = mysql_fetch_assoc($result_user);
		  if($rs_u[telno] != ""){
		  echo "$rs_u[telno]";
		  }else{ echo "-";}
		  ?>		  </td>
		  <? if($_SESSION[session_sapphire] == "1"){ // ��繢�����੾�о�ѡ�ҹ sapphire ��ҹ��?>
          <td align="left"><strong>����ҳ��ä�Һѹ�֡������ : </strong></td>
          <td align="left"><label>
            <input name="amount_pay" type="hidden" id="amount_pay" value="<?=number_format(cal_amount_pay($ticketid),2);?>"><strong><? echo number_format(cal_amount_pay($ticketid),2);?>
                        �ҷ            </strong></label></td>
			<? } // end if($_SESSION[session_sapphire] == "1"){ ?>
        </tr>
        <tr>
          <td align="left"><strong>�ӹǹ (�ش/��) : </strong></td>
          <td align="left"><?=count_assign_key($rs[ticketid]);?> �ش / <?=sum_count_page($ticketid);?> ��</td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><strong>���˹�ҷ�����ѷ� : </strong></td>
          <td align="left"><?=show_user($rs[admin_id]);?></td>
          <td align="left"><strong>���������˹�ҷ�����ѷ� : </strong></td>
          <td align="left"><?
		  		  $sql_admin = "SELECT *  FROM  keystaff  WHERE staffid='$rs[admin_id]'";
		  $result_admin = mysql_db_query($db_name,$sql_admin);
		  $rs_admin = mysql_fetch_assoc($result_admin);
		  if($rs_admin[telno] != ""){
		  echo "$rs_admin[telno]";
		  }else{ echo "-";}
		  ?></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><strong>�����˵� : </strong></td>
          <td colspan="3" align="left"><label>
            <textarea name="assign_comment" cols="110" rows="3" id="assign_comment"><?=$rs[assign_comment]?></textarea>
          </label></td>
          </tr>
        <tr>
          <td colspan="4" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="4%" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
                  <td width="14%" align="center" bgcolor="#A5B2CE"><strong>�Ţ�ѵû�ЪҪ�</strong></td>
                  <td width="16%" align="center" bgcolor="#A5B2CE"><strong>����-���ʡ��</strong></td>
                  <td width="19%" align="center" bgcolor="#A5B2CE"><strong>���˹�</strong></td>
                  <td width="18%" align="center" bgcolor="#A5B2CE"><strong>�ç���¹/˹��§ҹ</strong></td>
                  <td width="8%" align="center" bgcolor="#A5B2CE"><strong>�����Ҫ���</strong></td>
                  <td width="8%" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ(��)</strong></td>
				  <? if ($_SESSION[session_sapphire] == 1 ){ ?>
                  <td width="9%" align="center" bgcolor="#A5B2CE"><strong>����ҳ���<br>
                    ����µ��˹���</strong></td>
					<? } //end   if ($_SESSION[session_sapphire] == 1 ){?>
                  <td width="4%" align="center" bgcolor="#A5B2CE"><strong>ʶҹ�</strong></td>
                </tr>
				<?
		$cyy = (date("Y")+543);
					$sql1 = "SELECT
$db_name.tbl_assign_key.ticketid,
$db_name.tbl_assign_key.estimate_pay,
$dbnamemaster.view_general.CZ_ID,
$dbnamemaster.view_general.siteid,
$dbnamemaster.view_general.prename_th,
$dbnamemaster.view_general.name_th,
$dbnamemaster.view_general.surname_th,
$dbnamemaster.view_general.position_now,
$dbnamemaster.view_general.schoolid,
TIMESTAMPDIFF(MONTH,begindate,'$cyy-09-30')/12 AS age_gov  
FROM
$db_name.tbl_assign_key
Inner Join $dbnamemaster.view_general ON $db_name.tbl_assign_key.idcard = $dbnamemaster.view_general.CZ_ID WHERE $db_name.tbl_assign_key.ticketid='$ticketid'";

				
				$result1 = mysql_db_query($db_name,$sql1);
				$k=0;
				while($rs1 = mysql_fetch_assoc($result1)){
				 if ($k++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				 echo "<input type=\"hidden\" name=\"idcard[$rs1[CZ_ID]]\" value=\"$rs1[CZ_ID]\">";
				 echo "<input type=\"hidden\" name=\"xsiteid[$rs1[CZ_ID]]\" value=\"$rs1[siteid]\">";
				 
				?>
                <tr bgcolor="<?=$bg?>">
                  <td align="center"><?=$k?></td>
                  <td align="center"><?=$rs1[CZ_ID]?></td>
                  <td align="left"><? echo "$rs1[prename_th]$rs1[name_th]  $rs1[surname_th]";?></td>
                  <td align="left"><? echo "$rs1[position_now]";?></td>
                  <td align="left"><?=show_org($rs1[schoolid])."/".show_area($rs1[siteid]);?></td>
                  <td align="center"><?=floor($rs1[age_gov])?></td>
                  <td align="center"><? $page_result = count_page($rs1[CZ_ID],$rs1[siteid]);  if($page_result <= 1){ $page_result = 3;}else{ $page_result = $page_result;}  echo $page_result;?></td>
				  <?  if ($_SESSION[session_sapphire] == 1 ){ // ��� ੾�о�ѡ�ҹ sapphire ��ҹ�� ?>
                  <td align="center"><label>
				  <?
				  	$temp_age1 = floor($rs1[age_gov]);
					if(DIS_PERCEN > 0){ ## �ó�Ŵ������
					$temp_sum = 20+(($temp_age1*1.975)*0.9);
					$temp_pay = number_format($temp_sum-(($temp_sum*DIS_PERCEN)/100),2);
					}else{
				   	$temp_pay = number_format((20+(($temp_age1*1.975)*0.9)),2); 
					}
				   echo $temp_pay;
				   ?>
					<input type="hidden" name="estimate_pay[<?=$rs1[CZ_ID]?>]" value="<?=$temp_pay?>">
                  </label></td>
				  <? } //end  if ($_SESSION[session_sapphire] == 1 ){?>
                  <td align="center"><? if($rs[assign_status] == "NO"){ echo "<font color='red'>wait</font>";}else{ echo "assign";}?></td>
                </tr>
				<?
					}
				?>
              </table></td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="4" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left">��Ҿ������Ѻ���ҷ���¹����ѵ� �.�.7 �ҡ����ѷ ᫿��� ������� �͹�� �������ͻ��繷� �ӡѴ �����¡��</td>
        </tr>
        <tr>
          <td colspan="4" align="left">��ҧ�� ��Ҿ��Ҩд����͡��÷�����Ѻ�ҷ����������ҧ���������价����ҫ�������Ҵ��¡ó�� � </td>
        </tr>
        <tr>
          <td colspan="4" align="left">������Ѻ�й����觤׹���Ѻ����ѷ� �ѹ������ʹ��Թ��úѹ�֡�����������������ͷҧ����ѷϷǧ���</td>
        </tr>
        <tr>
          <td colspan="4" align="left">�ҡ�Դ����������¡Ѻ�͡��� �͡����٭��� ��Ҿ����Թ���Ѻ�Դ�ͺ��ͤ���������·�駻ǧ����Դ��鹵�����</td>
        </tr>
        <tr>
          <td colspan="4" align="left">����ѷ� ���¡��ͧ</td>
        </tr>
        <tr>
          <td colspan="4" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td width="49%" align="center">....................................................</td>
              <td width="51%" align="center">....................................................</td>
            </tr>
            <tr>
              <td align="center">(&nbsp;&nbsp;
                <?=show_user($rs[staffid]);?>
&nbsp;&nbsp;)</td>
              <td align="center">(&nbsp;&nbsp;
                <?=show_user($rs[admin_id]);?>
&nbsp;&nbsp;)</td>
            </tr>
            <tr>
              <td align="center">����Ѻ��ҧ</td>
              <td align="center">���˹�ҷ�����ѷ�</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="4" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="center">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
</BODY>
</HTML>
