<?
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
include ("../../common/common_competency.inc.php")  ;
include("checklist2.inc.php");
include("import_excel/function_imp.php");
$time_start = getmicrotime();
$subid = substr($xsiteid,0,1); // ʾ�ѡ�ҹ��ж����� 1 �Ѹ������ 0

if($_GET['debug'] == "on"){
	echo "<pre>";
	print_r($_SESSION);
		
}//end if($_GET['debug'] == "on"){
	
###############3
if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	
		$sql_site = "SELECT * FROM tbl_checklist_kp7_confirm_site WHERE siteid='$xsiteid' AND profile_id='$profile_id'";
		$result_site = mysql_db_query($dbname_temp,$sql_site);
		$rss = mysql_fetch_assoc($result_site);
		if($rss[siteid] != ""){
			$sql_update_flag = "UPDATE tbl_checklist_kp7_confirm_site SET flag_download_xls='$conf_site' WHERE siteid='$xsiteid' AND profile_id='$profile_id' ";	
			$result = mysql_db_query($dbname_temp,$sql_update_flag);
		}else{
			$sql_insert = "INSERT INTO tbl_checklist_kp7_confirm_site SET flag_download_xls='$conf_site',siteid='$xsiteid',profile_id='$profile_id'";
			$result = mysql_db_query($dbname_temp,$sql_insert);
		}
	
		if($conf_site == "1"){
			SaveLogConfirmSite($xsiteid,$profile_id,"1","��ǹ���Ŵ����� excel ���ͷ� checklist ","$conf_site");	
		}

		if($result){
			echo "<script> location.href='excel_class/export_excel_checklist_areanew.php?xsiteid=$xsiteid&profile_id=$profile_id&conF=$conf_site';</script>";
			exit;
		}else{
			echo "<script> alert('�������ö��Ŵ�������� ��سҵԴ��ͼ������к�'); location.href='?xsiteid=$xsiteid&profile_id=$profile_id';</script>";
			exit;
		}// end if($result){ 
		
		
}// end if($_SERVER['REQUEST_METHOD'] == "POST"){



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>����� excel</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<LINK href="css/style.css" rel=stylesheet>
<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>
<body>
<?
	if($Aaction == ""){
		
			
		$sql_site = "SELECT * FROM tbl_checklist_kp7_confirm_site WHERE siteid='$xsiteid' AND profile_id='$profile_id' AND flag_download_xls='1' ";
		$result_site = mysql_db_query($dbname_temp,$sql_site);
		$rss = mysql_fetch_assoc($result_site);
		if($rss[siteid] == ""){
				$alink_down = "?Aaction=conF&xsiteid=$xsiteid&profile_id=$profile_id";
		}else{
				$alink_down = "excel_class/export_excel_checklist_areanew.php?xsiteid=$xsiteid&profile_id=$profile_id&conF=$rss[flag_download_xls]";	
		}//end if($rss[siteid] == ""){

?>
<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="30" align="center" bgcolor="#999999"><strong>��Ǵ�����èѴ��â����ŵ�駵鹡.�.7 �� excel �����<br><?=show_area($xsiteid);?><br><?=ShowDateProfile($profile_id)?></strong></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
<!--          <tr>
            <td width="6%" align="right" bgcolor="#FFFFFF"><img src="../../images_sys/export_logo.png" width="16" height="16"></td>
            <td width="94%" align="left" bgcolor="#FFFFFF"><a href="excel_class/export_excel_checklist.php?xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>">���͡��� excel ������������͡��� ʾ�.(ࢵ���)</a></td>
            </tr>
-->          <tr>
            <td align="right" bgcolor="#FFFFFF"><img src="../../images_sys/export_logo.png" width="16" height="16"></td>
            <td align="left" bgcolor="#FFFFFF"><a href="<?=$alink_down?>">���͡��� excel �������仵�Ǩ�ͺ�͡���</a></td>
            </tr>
<!--           <tr>
            <td align="right" bgcolor="#FFFFFF"><img src="../../images_sys/export_logo.png" alt="" width="16" height="16"></td>
            <td align="left" bgcolor="#FFFFFF"><a href="excel_class/export_excel_checklist_org.php?xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>">gen ��ª����ç���¹��������ç���¹</a></td>
          </tr>
-->          <tr>
            <td align="right" bgcolor="#FFFFFF"><img src="../../images_sys/db.gif" width="14" height="15"></td>
            <td align="left" bgcolor="#FFFFFF"><a href="import_excel/index_upload.php?xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>">�������� excel</a></td>
            </tr>
          <tr>
            <td colspan="2" align="left" bgcolor="#FFFFFF"><strong>��Ǵ��¡�����ҧ��������к�</strong></td>
            </tr>
          <tr>
            <td align="center" bgcolor="#FFFFFF"><img src="../../images_sys/folderopen.gif" width="18" height="18" border="0"></td>
            <td align="left" bgcolor="#FFFFFF"><a href="genfolder.php?xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>&action=process" target="_blank">�����������ҧ��������к�</a></td>
          </tr>
          <?
          	$arrrep = CheckUploadReplace($profile_id,$xsiteid);
			if(count($arrrep) > 0){
		  ?>
          <tr>
            <td colspan="2" align="left" bgcolor="#FFFFFF"><strong>��Ǵ��¡���׹�ѹ�ӹǹ���</strong></td>
            </tr>
          <tr>
            <td align="center" bgcolor="#FFFFFF"><img src="../../images_sys/alert.gif" width="20" height="20"></td>
            <td align="left" bgcolor="#FFFFFF"><a href="import_excel/processxls_conf.php?profile_id=<?=$profile_id?>&xsiteid=<?=$xsiteid?>" target="_blank">�բ����ū�ӡ�سҤ�����������ѹ������</a>&nbsp;<img src="../../images_sys/new11.gif" width="26" height="7" border="0"></td>
          </tr>
          <?
			}	// end 	if(count($arrrep) > 0){
				
			$sql1 = "SELECT * FROM tbl_checklist_imp_excel_error WHERE siteid='$xsiteid' AND profile_id='$profile_id'";
			$result1 = mysql_db_query($dbname_temp,$sql1);
			$numr1 = mysql_num_rows($result1);
			if($numr1 > 0){
		  ?>
              <tr>
            <td align="center" bgcolor="#FFFFFF"><img src="../../images_sys/alert.gif" width="20" height="20"></td>
            <td align="left" bgcolor="#FFFFFF"><a href="?Aaction=view_error&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>" target="_blank">��¡�â��������١��ͧ����ͧ upload ��� excel ������䢢�����</a></td>
          </tr>
		<?
			}
		?>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<?
		}else if($Aaction == "conF"){
?>
<form name="form1" method="post" action="">
  <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="2" align="center" bgcolor="#999999"><strong>������׹�ѹ��ùӢ�������к� checklist 仵�Ǩ�ͺ�͡����ࢵ��鹷�����֡��<br><?=show_area($xsiteid);?><br><?=ShowDateProfile($profile_id)?></strong></td>
          </tr>
        <tr>
          <td width="21%" align="left" bgcolor="#FFFFFF"><strong>��õ�Ǩ�ͺ�͡���</strong></td>
          <td width="79%" align="left" bgcolor="#FFFFFF"><strong>
            		<input type="radio" name="conf_site" id="radio" value="1">
           			�׹�ѹ��õ�Ǩ�ͺ�˹��䫵� 
                	<input type="radio" name="conf_site" id="radio2" value="0">
               	 	�ѧ����׹�ѹ��õ�Ǩ�ͺ�͡���˹��䫵�
          </strong></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
          <td align="left" bgcolor="#FFFFFF">
          <input type="submit" name="button" id="button" value="��ŧ">
          <input type="hidden" name="xsiteid" value="<?=$xsiteid?>">
          <input type="hidden" name="profile_id" value="<?=$profile_id?>">
          <input type="button" name="btnC" value="¡��ԡ" onClick="location.href='?Aaction=&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>'">
          </td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
<?
		}// end //end if($Aaction == ""){
	if($Aaction == "view_error"){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="5%" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
        <td width="63%" align="center" bgcolor="#A5B2CE"><strong>���͹��ʡ��</strong></td>
        <td width="32%" align="center" bgcolor="#A5B2CE"><strong>��Ǵ�ѭ��</strong></td>
      </tr>
      <?
			 $arr_type = GetTypeError();
			 $sql = "SELECT * FROM tbl_checklist_imp_excel_error WHERE siteid='$xsiteid' AND profile_id='$profile_id' ORDER BY name_th ASC";
			 $result = mysql_db_query($dbname_temp,$sql);
			 $n=0;
			 while($rs = mysql_fetch_assoc($result)){
             	if ($n++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$n?></td>
        <td align="left"><? echo "$rs[idcard] $rs[prename_th]$rs[name_th] $rs[surname_th] $rs[position_now]";?></td>
        <td align="left"><?=$arr_type[type_error]?></td>
      </tr>
      <?
			 }//end while($rs = mysql_fetch_assoc($result)){
			 ?>
    </table></td>
  </tr>
</table>
<?
	}
?>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
