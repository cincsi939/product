<?
session_start();
$ApplicationName	= "search_documentkp7";
$module_code 		= "search_documentkp7"; 
$process_id			= "checklistkp7_search";
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


include("../../common/common_competency.inc.php");
include("checklist2.inc.php");
include("function_search.php");
$kp7path = "../../../".PATH_KP7_FILE."/";
$kp7path_org = "../../../".PATH_KP7_REFDOC_FILE."/";
if($profile_id == ""){// �ó���������͡���� ������
	$profile_id = LastProfile();
}//end if($profile_id == ""){// �ó���������͡���� ������

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>�к��׺���͡��� �.�. 7</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<LINK href="css/style.css" rel=stylesheet>
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>

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
	$get_id = trim($_GET['get_idcard']);
	if($_POST['key_idcard'] != "" || $get_id !=""){
		$txt_dis = "style=\"display:none\"";
	}else{
		$txt_dis = "";
	}
?>

<form name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" <?=$txt_dis?>>
    <tr>
      <td bgcolor="#999999"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="4" align="center" valign="middle" bgcolor="#ABC8E2">      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="9%" align="right"><strong>���͡����� :</strong></td>
          <td width="58%">
          <select name="profile_id" id="profile_id">
          <option value="">���͡������</option>
      	<?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
		<!--<option value="?profile_id=<?//=$rsp[profile_id]?>&search=<?//=$search?>&key_surname=<?//=$key_surname?>&key_idcard=<?//=$key_idcard?>&key_name=<?//=$key_name?>&page=<?//=$page?>" <?//=$sel?>><?//=$rsp[profilename]?></option>-->
        <option value="<?=$rsp[profile_id]?>" <?=$sel?>><?=$rsp[profilename]?></option>
		<?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
        </select> 
          
          </td>
          <td width="33%">&nbsp;</td>
        </tr>
      </table></td>
          </tr>
        <tr>
          <td align="center" valign="middle" bgcolor="#ABC8E2"><strong><img src="../../images_sys/icon_search.png" border="0"></strong></td>
          <td colspan="3" align="left" valign="middle" bgcolor="#ABC8E2"><strong>���͹䢡���׺�鹢�����  <?=ShowProfile_name($profile_id);?></strong></td>
          </tr>
        <tr>
          <td width="3%" bgcolor="#FFFFFF">&nbsp;</td>
          <td width="12%" bgcolor="#FFFFFF">����</td>
          <td width="19%" bgcolor="#FFFFFF">
            <input name="key_name" type="text" id="key_name" size="25" value="<?=$key_name?>"></td>
          <td width="66%" bgcolor="#FFFFFF"><input type="submit" name="save" id="save" value="��ŧ">
            <input type="reset" name="btncancel" id="btncancel" value="¡��ԡ">
            <!--<input type="hidden" name="profile_id" value="<?//=$profile_id?>">-->
              <input type="hidden" name="search" value="search">
              <input type="hidden" name="page" value="">
            </td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">&nbsp;</td>
          <td bgcolor="#FFFFFF">���ʡ��</td>
          <td bgcolor="#FFFFFF">
            <input name="key_surname" type="text" id="key_surname" size="25" value="<?=$key_surname?>"></td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">&nbsp;</td>
          <td bgcolor="#FFFFFF">�����Ţ�ѵû�ЪҪ�</td>
          <td bgcolor="#FFFFFF">
            <input name="key_idcard" type="text" id="key_idcard" size="25" maxlength="13" value="<?=$key_idcard?>"></td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
<? if($search == "search" or $displaytype=="people" || $get_id !=""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td>&nbsp;</td></tr>
<?
if($key_name != ""){
		$conwhere  .= " AND name_th LIKE '%$key_name%'";
}
if($key_surname != ""){
		$conwhere .= " AND surname_th LIKE '%$key_surname%' ";
}

if($key_idcard != ""){
		$conwhere .= " AND idcard LIKE '%$key_idcard%'";
}
if($get_id !=""){
		$conwhere .= " AND idcard LIKE '%$get_id%'";
}

	$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
	$e			= (!isset($e) || $e == 0) ? 10 : $e ;
	$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 


	$sql = "SELECT COUNT(idcard) as numall FROM tbl_checklist_kp7 WHERE profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	
	$sql_main = "SELECT * FROM tbl_checklist_kp7 WHERE profile_id='$profile_id'  $conwhere ";
	
		$xresult = mysql_db_query($dbname_temp,$sql_main);
		$all= @mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
	if($page <= $allpage){
			$sql_main .= " LIMIT $i, $e";
	}else if($page == $xpage){
		$i=0;
			$sql_main .= " ";
	}else{
			$sql_main .= " LIMIT $i, $e";
	}
	//echo $sql_main;

		$result_main = mysql_db_query($dbname_temp,$sql_main);
		$num_row = mysql_num_rows($result_main);
		$search_sql = $sql_main ; 
		
	if($num_row < 1){
	
?>
  <tr>
    <td><table width="99%" border="0" cellpadding="0" cellspacing="2" align="center" style="border:1px solid #5595CC;">
<tr>
	<td height="20"><img src="../../images_sys/alert.gif" width="16" height="16" align="absmiddle" />&nbsp;�š�ä���:  <? if($key_name != ""){ echo "<br> - ���� : $key_name  ";} if($key_surname != ""){ echo "<br> - ���ʡ�� : $key_surname  ";} if($key_idcard != ""){ echo " <br> - �����Ţ�ѵû�ЪҪ� : $key_idcard  ";} ?>&nbsp;���ç�Ѻ�ؤ�ҡ�� �<br /><br />
	����й� :<br />
	- ������������С��ء�����ҧ�١��ͧ<br />
	- Ŵ���͹䢡�ä���ŧ<br /><br />
	</td>
</tr>
</table></td>
  </tr>
  <?
	}//end 	if($num_row < 1){
   if($num_row > 0){?>
  <tr>
    <td <?=$txt_dis?>><strong>�š���׺�� ���ӹǹ <?=number_format($all)?> �� �ҡ�ӹǹ�����ŷ����� <?=number_format($rs[numall])?> �� (<? $time_e 	= getmicrotime();
	echo  number_format($time_e - $time_start,2);?> �Թҷ�)</strong></td>
  </tr>
  <?
  while($rsm = mysql_fetch_assoc($result_main)){
	  $i++;
	  $arrkey1 = DateAssign($rsm[idcard],$rsm[profile_id]);
	  $arrqc = SearchGetQcKp7($rsm[idcard],$rsm[profile_id]);
	  $arrupfile = DateUploadFile($rsm[idcard],$rsm[profile_id]);
	  

				$orgname = show_school($rsm[schoolid])."/".ShowAreaSort($rsm[siteid]); 	 		
		$tab_txt_head =  "style=\"margin-left:50px\"";
	  
  ?>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="2%" align="center">&nbsp;</td>
        <td width="90%" align="left"><table width="99%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td colspan="2" align="left"><font color="#1375C6">&nbsp;<? echo "<b>".$i.".</b> ";?> <? echo " <b> $rsm[idcard]  $rsm[prename_th]$rsm[name_th]  $rsm[surname_th] </u> <b>$orgname</b></b> ";?> 
			<? 
			
				$filekp7 = $kp7path.$rsm[siteid]."/".$rsm[idcard].".pdf";
				$filekp7_org = $kp7path_org.$rsm['siteid']."/".$rsm[idcard]."R.pdf";
			
			
					$kp7_sys = "<a href=\"../hr3/hr_report/kp7_search.php?id=".$rsm[idcard]."&sentsecid=".$rsm[siteid]."\" target=\"_blank\"><img src=\"../hr3/hr_report/bimg/pdf.gif\" width=\"16\" height=\"16\" border=\"0\" alt='����¹����ѵ�����硷�͹ԡ��' ></a>";
					
			
					if(is_file($filekp7_org)){
					$kp7_ref = "<a href=\"$filekp7_org\" target=\"_blank\"><img src='../../images_sys/pdf_ref.png' width=\"16\" height=\"16\" border=\"0\"  title='�����͡�����ѡ�ҹ' ></a>";
					}else{
						$kp7_ref = "";	
					}
					
			 if(is_file($filekp7)){
					$kp7img="<a href='$filekp7' target='_blank'><img src='../../images_sys/gnome-mime-application-pdf.png' title='�����͡��÷���¹����ѵԵ鹩�Ѻ' width='16' height='16' border='0'></a>";
					$file_upload = 1;
			}else{
					
					$arrkp7 = GetPdfOrginal($rs[idcard],$path_pdf,$imgpdf,"","pdf");
					$kp7img = $arrkp7['linkfile'];	
					$file_upload = 0;
			}
					echo "&nbsp; $kp7_ref &nbsp; $kp7img &nbsp;  $kp7_sys";
				?></font></td>
          </tr>
          <tr>
            <td colspan="2" align="left"><strong style="margin-left:50px">ʶҹС�èѴ�Ӣ����Ż������</strong></td>
          </tr>
          <tr>
            <td colspan="2" align="left"><font color="#666666" style="margin-left:60px">�ѹ������Ѻ�͡���&nbsp;<? $arrd1 = DateReciveDoc($rsm[idcard],$rsm[profile_id],""); echo $arrd1['time']?> <? $arrd1 = DateMoreFile($rsm[idcard],$rsm[profile_id]); 
			if(count($arrd1) > 0){
				$xk=1;
				foreach($arrd1 as $key => $val){
					$xk++;
						echo " <strong>���駷�� $xk</strong> $val  &nbsp;&nbsp;";
				}	
			}
			?></font></td>
          </tr>
          		<tr>
            		<td align="left" colspan="2"></td>
          		</tr>
          			<tr>
                    		<td width="35%"><font color="#666666" style="margin-left:60px">�ѹ����Ǩ�ͺ�͡���&nbsp;<? $arrd2 = DateReciveDoc($rsm[idcard],$rsm[profile_id],"max"); echo $arrd2['time']?></font></td>
                    		<td width="64%"><font color="#666666">����Ǩ�ͺ�͡���&nbsp;<?=$arrd2['user']?></font></td>
                    </tr>
          <tr>
          	<td colspan="2"><hr width="50%" style="margin-left:30px"></td>
          </tr>
          <tr>
            <td colspan="2" align="left"><strong style="margin-left:50px">�����١��ͧ�ú��ǹ�ͧ�͡������� ��.7 �鹩�Ѻ </strong></td>
          </tr>
          <tr>
            <td colspan="2" align="left"><font color="#666666" style="margin-left:60px">�ѹ�����§ҹ���ͺѹ�֡������&nbsp;<?=$arrkey1['dateassign']?>&nbsp;</font><td width="1%">
            </tr>
            <tr>
            <td><font color="#666666" style="margin-left:60px">�ѹ�֡��������&nbsp;<?=$arrkey1['staff_key']?>&nbsp;</font></td>		<td><font color="#666666">�ѹ���ѹ�֡��������������&nbsp;<?=$arrkey1['datecomp']?></font></td>
          </tr>
          <tr>
          	<td colspan="2"><hr width="50%" style="margin-left:30px"></td>
          </tr>
          <tr>
            <td colspan="2" align="left"><strong style="margin-left:50px">�ѹ����Ǩ�ͺ�س�Ҿ��úѹ�֡������</strong>&nbsp;<?=$arrqc['dateqc']?>&nbsp;<strong>��Ǩ�ͺ��</strong>&nbsp;<?=$arrqc['fullname']?></td>
          </tr>
          <tr>
            <td colspan="2" align="left"><font color="#666666" style="margin-left:60px">ʶҹ��Ѻ�ͧ������: <font color="#006600"><?=$arrkey1['comment_approve']?></font></font></td>
          </tr>
          <tr>
            <td colspan="2" align="left"><font color="#666666" style="margin-left:60px">�ѹ����᡹�͡������ upload �������������к�&nbsp;<? if($file_upload == "1"){ echo $arrupfile['date_upload'];}else{ echo " -  ";}?>&nbsp;��&nbsp;<? if($file_upload == "1"){ echo $arrupfile['staff_upload'];}else{ echo " - ";}?></font></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  
  <?
  }//end   while($rsm = mysql_fetch_assoc($result_main)){
	  if($all > 0){
  ?>
  <tr <?=$txt_dis?>>
    <td><? $sqlencode = urlencode($search_sql)  ; ?>	
	<?=devidepage($allpage, $keyword ,$sqlencode )?></td>
  </tr>
  <?
	  }//END if($all > 0){
  }//end if($num_row > 0){
  ?>
</table>
<? }//end if($search == "search" or $displaytype=="people"){?>
</body>
</html>