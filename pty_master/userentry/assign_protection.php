<?
#echo "<br><br><br><center><h3><font color=\"#FF0000\">����ͧ��͹��١�Դ�����ҹ���</font></h3></center>";die;
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "checklistkp7"; 
$process_id			= "checklistkp7_byarea";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20100809.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2010-08-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20100809.00
	## Modified Detail :		�к���Ǩ�ͺ�����ŷ���¹����ѵԵ鹩�Ѻ
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################


include("../../config/conndb_nonsession.inc.php");
include("../../common/common_competency.inc.php");
include("epm.inc.php");



if($_SERVER['REQUEST_METHOD'] == "POST"){
	
if(count($pro_id) > 0){
	foreach($pro_id as $key => $val){
		$sql_up = "UPDATE tbl_assign_protection SET status_active='$val' WHERE runid='$key'";
		mysql_db_query($db_name,$sql_up);
		$sql_log = "INSERT INTO tbl_assign_protection_log SET protect_id='$key', staffchange='".$_SESSION[session_staffid]."',action='$val',subject='����¹ʶҹС�û�ͧ�ѹ����ͺ���§ҹ'";
		mysql_db_query($db_name,$sql_log);
		
	}//end foreach($pro_id as $key => $val){
		echo "<script>alert('�ѹ�֡���������º��������');
		 location.href='?action=';
		</script>";
		exit;
	
}//end if(count($pro_id) > 0){

}// end if($_SERVER['REQUEST_METHOD'] == "POST"){




?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>

</head>

<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#A5B6CE"><img src="logo_sapp.jpg" alt="" width="160" height="50"></td>
  </tr>
<? if($action == ""){?>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" align="center" bgcolor="#A5B6CE"><strong>��¡�á�˹����͹䢡�û�ͧ�ѹ�����š�͹����ͺ���§ҹ</strong></td>
        </tr>
      <tr>
        <td width="6%" align="center" bgcolor="#A5B6CE"><strong>�ӴѺ</strong></td>
        <td width="45%" align="center" bgcolor="#A5B6CE"><strong>������¡�û�ͧ�ѹ</strong></td>
        <td width="33%" align="center" bgcolor="#A5B6CE"><strong>ʶҹС�û�ͧ�ѹ</strong></td>
        <td width="16%" align="center" bgcolor="#A5B6CE"><strong><a href="?action=edit">�Ѵ��â����ŷ�����</a></strong></td>
      </tr>
      <?
      	$sql = "SELECT * FROM tbl_assign_protection ORDER BY runid ASC";
		$result = mysql_db_query($db_name,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[protection_name]?></td>
        <td align="center"><? if($rs[status_active] == "0"){ echo "<em>����ͧ�ѹ</em>";}else{ echo "<em>��ͧ�ѹ</em>";}?></td>
        <td align="center"><a href="?action=edit&protect_id=<?=$rs[runid]?>&protection_name=<?=$rs[protection_name]?>"><img src="../../images_sys/edit.gif" width="25" height="25" border="0" title="���ʶҹС�û�ͧ�ѹ������"></a></td>
      </tr>
      <?
		}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
  <? }//end if($action == ""){
	  if($action == "edit"){
	?>
  <form name="form1" id="form1" method="post"  action="">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="2" bgcolor="#A5B6CE"><strong><a href="?action="><img src="../../images_sys/home.gif" width="20" height="20" border="0" title="��Ѻ˹����ѡ"></a> ������Ѵ������͹䢡�û�ͧ�ѹ������&nbsp;<?=$protection_name?></strong></td>
        </tr>
      <tr>
        <td width="25%" bgcolor="#A5B6CE"><strong>��¡�â�����</strong></td>
        <td width="75%" bgcolor="#A5B6CE">&nbsp;</td>
      </tr>
      <?
	  	if($protect_id != ""){ $conv .= " WHERE runid='$protect_id'";}else{ $conv = "";}
      	$sql_edit = "SELECT * FROM tbl_assign_protection  $conv ORDER BY runid ASC";
		$result_edit = mysql_db_query($db_name,$sql_edit);
		$i=0;
		while($rse = mysql_fetch_assoc($result_edit)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="left"><?=$rse[protection_name]?></td>
        <td align="left">
          <input type="radio" name="pro_id[<?=$rse[runid]?>]" id="radio" value="1" <? if($rse[status_active] == "1"){ echo "checked='checked'";}?>>
          �Դ��û�ͧ�ѹ 
          <input type="radio" name="pro_id[<?=$rse[runid]?>]" id="radio" value="0" <? if($rse[status_active] == "0"){ echo "checked='checked'";}?>>
        �Դ��û�ͧ�ѹ</td>
      </tr>
     <?
		}//end while($rse = mysql_fetch_assoc($result_edit)){
	 ?>
         <tr bgcolor="#CCCCCC">
        <td align="left" bgcolor="#CCCCCC">&nbsp;</td>
        <td align="left" bgcolor="#CCCCCC">
          <input type="submit" name="button" id="button" value="�ѹ�֡">
          <input type="button" name="btn" id="btn" value="¡��ԡ" onClick="location.href='?action='">
       </td>
      </tr>

    </table></td>
  </tr>
  </form>
  <?
	  }//end if($action == "edit"){
  ?>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</BODY>
</HTML>
