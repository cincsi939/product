<?
include("../checklist2.inc.php");
?>
<HTML><HEAD><TITLE>Import DATA</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<LINK href="../../../common/style.css" rel=stylesheet>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script language="javascript">

function chFrom(){
	 if(document.form1.name.value == ""){
			alert("��س���������");
			document.form1.name.focus();
			return false;
	
	}
	return true;
}
</script>

</HEAD>
<BODY bgcolor="#A5B2CE">
<? if($action == ""){?>
 <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr align="center"><td align="center">
<form action="processxlsv1.php?process=execute&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>" method="post" enctype="multipart/form-data" name="form1" onSubmit="return chFrom();">
  <fieldset >
    <legend><strong> �к�����Ң����� excel ���ͻ�Ѻ��اʶҹ�͡��á.�.7 <?=show_area($xsiteid);?></strong>  </legend>
      <table width="100%" border="0">
      <tr>
        <td align="right">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
          <td width="10%" align="right" >����������� : </td>
      <td width="86%"><?=ShowProfile_name($profile_id);?> </td>
      <td width="4%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" >���������� :</td>
      <td><input name="name" type="file" id="name"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><input type="submit" name="Submit" value=" upload "></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="16" align="right">&nbsp;</td>
      <td><font color="#FF0000">�����˵� : ��ù���Ң����š�õ�Ǩ�ͺ�͡��� �.�.7 �鹩�Ѻ���ִ�ӹǹ��е���Ţ���� excel �������<br>
�ѧ��鹵���Ţ�Ũӹǹ�ؤ�ҡ÷�������繢����ŵ�駵鹨ҡ pobec �����á������������ excel �ж١ź�͡�ҡ�к��Ѵ�Ӣ����ŵ�駵����ͷ����ִ�ӹǹ�ؤ�ҡèҡ��� excel ����ҹ����� </font> <a href="?action=view&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>">�������ʹ� log ���ź</a></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  </fieldset>
</form>
</td>
</tr>
</table>
<? 
}//end 

if($action == "view"){
		$sql = "SELECT * FROM tbl_checklist_kp7_logdelete WHERE siteid='$xsiteid' and profile_id='$profile_id' and flag_redata='0' ORDER BY schoolid ASC";
		$result = mysql_db_query($dbname_temp,$sql);
		$numR = @mysql_num_rows($result);
	?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="5" align="left" bgcolor="#A5B2CE"><a href="?action=&xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>">��͹��Ѻ</a> || <? echo ShowAreaSortName($xsiteid); echo "&nbsp;".ShowProfile_name($profile_id);?></td>
        </tr>
      <tr>
        <td width="6%" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
        <td width="18%" align="center" bgcolor="#A5B2CE"><strong>�Ţ�ѵû�ЪҪ�</strong></td>
        <td width="29%" align="center" bgcolor="#A5B2CE"><strong>���� - ���ʡ��</strong></td>
        <td width="25%" align="center" bgcolor="#A5B2CE"><strong>���˹�</strong></td>
        <td width="22%" align="center" bgcolor="#A5B2CE"><strong>�ç���¹</strong></td>
      </tr>
      <?
      if($numR > 0){
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
				if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="center"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="center"><?=$rs[position_now]?></td>
        <td align="center" ><?=show_school($rs[schoolid]);?></td>
      </tr>
      <?
		}//end while($rs = mysql_fetch_assoc($result)){
		}else{
			echo "<tr bgcolor='#FFFFFF'><td colspan='5'><center><font color='#FF0000'>-��辺���ź��ͨҡ�к���Ǩ�ͺ������ �.�.7 ��ҹ�������ù���Ң����� excel -</font></center> </td></tr>";
				
		}//end    if($numR > 0){
	  ?>
    </table></td>
  </tr>
</table>
<?
}//end  if($action == "view"){
?>
</BODY>
</HTML>