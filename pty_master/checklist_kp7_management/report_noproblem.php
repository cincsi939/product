<?
session_start();

include("checklist2.inc.php");
include("../../common/common_competency.inc.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>�к���Ǩ�ͺ�͡��� �.�.7 �鹩�Ѻ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
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
<style>
.txthead{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtexsum{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtdate{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000; 
}
.txtdata{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #000; 
}
.txt_link a:link {
	FONT-SIZE: 12px;
	color: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:visited {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:active {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline;FONT-WEIGHT: bold;
}
.style1 {color: #006600}
.fillcolor_headgraph{	
	padding: 2pt;
	background-color:#0063C9;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#0063C9', EndColorStr='#000467');
}
.fillcolor_headgraph2{	
	padding: 2pt;
	background-color:#E6E6E6;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#E6E6E6', EndColorStr='#8E8E8E');
	font-weight:bold;
}
</style>

</head>
<body>
<?
	
	
?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
<? if($lv == ""){?>
 <tr>
    <td align="left">&nbsp;</td>
  </tr>

 <tr>
   <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
     <tr>
       <td colspan="3" align="left" bgcolor="#A8B9FF"><strong>�����Ũӹǹ�ؤ�ҡ÷���͡����ջѭ���¡���ࢵ��鹷�����֡��</strong></td>
       </tr>
     <tr>
       <td width="6%" align="center" bgcolor="#A8B9FF"><strong>�ӴѺ</strong></td>
       <td width="61%" align="center" bgcolor="#A8B9FF"><strong>ࢵ��鹷�����֡��</strong></td>
       <td width="33%" align="center" bgcolor="#A8B9FF"><strong>�ӹǹ��¡��(��)</strong></td>
     </tr>
     <?
     $sql_edu = "SELECT
eduarea.secid,
eduarea.secname
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata' 
ORDER BY  secname";
	 $result_edu = mysql_db_query($dbnamemaster,$sql_edu);
	 $i=0;
	 while($rs_e = mysql_fetch_assoc($result_edu)){
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
	 $arr1 = show_val_exsum("1",$rs_e[secid],"",$profile_id);
	 	if($xtype == "wait"){
			$val = $arr1['numN'];
		}else{
			$val = $arr1['numY1'];
		}
	 ?>
     <tr bgcolor="<?=$bg?>">
       <td align="center"><?=$i?></td>
       <td align="left"><?=$rs_e[secname]?></td>
       <td align="center"><? if($val > 0){ echo "<a href='?lv=1&sentsecid=$rs_e[secid]&xtype=$xtype&profile_id=$profile_id' target='_blank'>".number_format($val)."</a>";}else{ echo "0";}?></td>
     </tr>
    <?
		$arr1 = "";
	 }//end  while(){
	?>
   </table></td>
 </tr>
 <? } //end if($lv == ""){
	 
	if($lv == "1"){	 
	if($xtype == "wait"){ $xtitle = "��ª��ͺؤ�ҡ÷�����������ҧ��õ�Ǩ�ͺ�͡���";}else if($xtype == "complate"){ $xtitle = "��ª��ͺؤ�ҡ÷���Ǩ�͡�������ó�";}else if($xtype == "checkall"){ $xtitle = "��ª��ͺؤ�ҡ÷���Ǩ�͡������Ƿ�����";}else if($xtype == "all"){ $xtitle = "�ӹǹ�ؤ�ҡ÷�����";}else{ $xtitle = "��ª��ͺؤ�ҡ÷���Ǩ�͡�������ó�";}
	
?>
   <tr>
    <td align="left">&nbsp;</td>
  </tr>

  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" bgcolor="#A8B9FF"><strong> <?=$xtitle."".show_area($sentsecid);?></strong>
		
		<? $xsc =get_school($schoolid,$sentsecid);

		echo $xsc['schoolname']   ;
		?> <a href="report_noproblem_comment.php?lv=<?=$lv?>&sentsecid=<?=$sentsecid?>&schoolid=<?=$schoolid?>&profile_id=<?=$profile_id?>&xsiteid=<?=$sentsecid?>" target="_blank">�͡�������ó����� comment</a></td>
        </tr>
      <tr>
        <td width="2%" align="center" bgcolor="#A8B9FF"><strong>��<br>
          �Ѻ</strong></td>
        <td width="9%" align="center" bgcolor="#A8B9FF"><strong>���ʺѵ�</strong></td>
        <td width="8%" align="center" bgcolor="#A8B9FF"><strong>�ӹ�˹�Ҫ���</strong></td>
        <td width="7%" align="center" bgcolor="#A8B9FF"><strong>����</strong></td>
        <td width="11%" align="center" bgcolor="#A8B9FF"><strong>���ʡ��</strong></td>
        <td width="21%" align="center" bgcolor="#A8B9FF"><strong>���˹�</strong></td>
        <td width="28%" align="center" bgcolor="#A8B9FF"><strong>�ѧ�Ѵ</strong></td>
        <td width="14%" align="center" bgcolor="#A8B9FF"><strong>��� �.�.7</strong></td>
      </tr>
      <?
	if($schoolid != ""){
		  $conS = " AND schoolid='$schoolid'";
	}else{
		$conS = "";	
	}
	if($xtype == "wait"){
		$conW = " WHERE status_check_file='NO' AND siteid='$sentsecid'  AND status_numfile='1'";	
	}else if($xtype == "complate"){
		
		$conW = " WHERE  status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0'  AND siteid='$sentsecid' ";
	}else if($xtype == "checkall"){
		$conW = " WHERE status_check_file='YES'  AND siteid='$sentsecid'  AND status_numfile='1'";
	}else if($xtype == "all"){
		$conW = 	" WHERE siteid='$sentsecid' ";
	}else{
		$conW = 	" WHERE  status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1' or mainpage <> '0') and status_id_false='0'  AND siteid='$sentsecid' ";
	}
	
	$con1 = " AND profile_id='$profile_id'";
      $sql = "SELECT * FROM tbl_checklist_kp7  $conW $conS $con1";
	  //echo $sql;die;
	  $result = mysql_db_query($dbtemp_check,$sql);
	  $i=0;
	  while($rs = mysql_fetch_assoc($result)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
		$kp7file = "../../../".PATH_KP7_FILE."/$rs[siteid]/$rs[idcard].pdf";
		if(is_file($kp7file)){
				$kp7img = "<a href='$kp7file' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"21\" border=\"0\" title=\"�������ʹ��͡��� �.�.7 �鹩�Ѻ\"></a>";
		}else{
				
				$arrkp7 = GetPdfOrginal($rs[idcard],$path_pdf,$imgpdf,"","pdf");
				$kp7img = $arrkp7['linkfile'];	

				//$kp7img = "";	
		}
		
		
		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]";?></td>
        <td align="left"><? echo "$rs[name_th]";?></td>
        <td align="left"><? echo "$rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="left"><? echo show_school($rs[schoolid]);?></td>
        <td align="center"><?=$kp7img?></td>
      </tr>
     <?
     	}//end   while($rs = mysql_fetch_assoc($result)){
	 ?>
    </table></td>
  </tr>
 <? } //end ?>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
</body>
</html>
