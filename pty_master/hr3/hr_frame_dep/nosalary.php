<?php
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_nosalary";
$module_code 		= "nosalary"; 
$process_id			= "nosalary";
$VERSION 				= "9.1";
$BypassAPP 			= true;
#########################################################
#Developer 	:: 
#DateCreate	::17/07/2007
#LastUpdate	::17/07/2007
#DatabaseTabel::
#END
#########################################################
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
include("../../../config/phpconfig.php");
$time_start = getmicrotime();
if ($_SERVER[REQUEST_METHOD] == "POST"){

	add_log("�������ѹ���������Ѻ�Թ��͹",$id,$action);
	if ($comment){
			  $fromdate = $from_year.'-'.$from_month.'-'.$from_day;
			  $todate = $to_year.'-'.$to_month.'-'.$to_day;

			if ($fromdate > $todate){
				$msg = "�ѹ���������� ��ͧ�����¡��� �ѹ�������ش";
			}else{

				 if ($_POST[action]=="edit2")
				 {
					$sql = "update  hr_nosalary set  fromdate='$fromdate', todate='$todate',comment='$comment',refdoc='$refdoc',kp7_active='$kp7_active' where no ='$no' and id ='$id' ;";
					
					mysql_query($sql);
					if (mysql_errno())
					{
						$msg = "�������ö��䢢�������"   .__LINE__.  mysql_error()  ;
					}
					else
					{
							echo "
				<script language=\"javascript\">
				alert(\"�ӡ�û�Ѻ��ا�������������\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
					//	header("Location: ?id=$id&action=edit");
						exit;
					}
										
						
				}else{

					$result = mysql_query("select * from hr_nosalary where (id='$id') and (fromdate='$fromdate' ) and (todate='$todate');");
					if (mysql_num_rows($result) > 0){
						$msg = "�����ū�ӡѺ��ǧ�ѹ���������������";
					}else{

						$sql = "INSERT INTO  hr_nosalary (id,fromdate,todate,comment,refdoc,kp7_active) VALUES ('$id','$fromdate','$todate','$comment','$refdoc','$kp7_active')";
			
						$result  = mysql_query($sql);
						if($result)
						{
							echo "
							<script language=\"javascript\">
							alert(\"�ӡ�úѹ�֡�������������\\n \");
							location.href='?id=$id&action=edit';
							</script>
							";
						//	header("Location: ?id=$id&action=edit");
							exit;
						}else
						{	$msg = "�������ö�ѹ�֡�������� "   .__LINE__.  mysql_error()  ;}

					}


				} // if edit2

			} // if fromdate > todate
				
	}else{ // if comment
		$msg = "��سһ�͹������㹪�ͧ��¡��";
	}


}else if ($_GET[action] == 'delete')
	{
		add_log("�������ѹ���������Ѻ�Թ��͹",$id,$action);
		mysql_query("delete from hr_nosalary where no = $no and id='$id';");
		if (mysql_errno())
			{
			$msg = "�������öź��������"   .__LINE__.  mysql_error()  ;
			}else
			{
			header("Location: ?id=$id&action=edit");
						echo "<script language=\"javascript\">
							location.href='?id=$id&action=edit';
							</script>";
			exit;
			}
	
}

// �ʴ�������
$sql = "select * from  general where id='$id' ;";
$result = mysql_query($sql);
if ($result){
	$rs=mysql_fetch_array($result,MYSQL_ASSOC);
} else {
	$msg = "��辺�����ŷ���к�";
}
	
?>



<html>
<head>
<title>�ѹ���������Ѻ�Թ��͹�������Ѻ�Թ��͹������</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<!-- send id to menu flash -->

</head>

<body bgcolor="#A3B2CC">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="30">&nbsp;</td>
    <td width="50" height="30"> 
      <div align="center"></div>
    </td>
  </tr>
</table>

<?
if ($msg){
?>
<CENTER><h2><FONT COLOR="red"><?=$msg?></FONT></h2>
<BR><BR>
<input type=button value=" ��͹��Ѻ " onClick="history.back();">
</CENTER>

<?
	exit;
}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="left" valign="top">&nbsp;<a href="kp7_nosalary.php?id=<?=$id?>" title="��Ǩ�ͺ������ ��.7"> <img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > ��Ǩ�ͺ�͡��â����� �.�.7 ����硷�͹ԡ�� </a> <br>
            <form  method = POST  action = "?id=<?=$id?>" >
              <INPUT TYPE="hidden" NAME="no" VALUE="<?=$no?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">
              <table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
                <tr> 
                  <td align="left" valign="top" ><b>���� / ʡ�� &nbsp;&nbsp; <u>
                    <?=$rs[prename_th]?>
                    <?=$rs[name_th]?>
                    <?=$rs[surname_th]?>
                    </u></b> </td>
                </tr>
              </table>
              <br>
              <?
$arr_kp7str[] = ""; 
$arr_kp7str[0] = ""; 
$arr_kp7str[1] = "  <img src='../../../images_sys/check_green.gif' width='16' height='13'>  "; 


?>
<table width="98%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
                <tr bgcolor="#999999" align="center">
                  <td colspan="6" bgcolor="#2C2C9E"><span class="style1">�ѹ���������Ѻ�Թ��͹ �����Ѻ�Թ��͹�������ӹǹ</span> </td>
                </tr>
                <tr bgcolor="#999999" align="center"> 
                  <td width="97" bgcolor="#A3B2CC"><strong>������ѹ���</strong></td>
				  <td width="96" bgcolor="#A3B2CC"><strong>�֧�ѹ���</strong></td>
                  <td width="380" bgcolor="#A3B2CC"><strong>��¡��</strong></td>
				  <td width="199" bgcolor="#A3B2CC"><strong>�͡�����ҧ�ԧ</strong></td>
                  <td width="95" bgcolor="#A3B2CC">�ʴ���� �.�. 7</td>
                  <td bgcolor="#A3B2CC">&nbsp;</td>
                </tr>
                <?

				$i=0;
				$result = mysql_query("select * from hr_nosalary where id='$id' order by fromdate desc,todate desc;");
				while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
					$i++;
					if ($i % 2) {
						$bg = "#FFFFFF";
					}else{
						$bg = "#F0F0F0";
					}
			?>
                <tr align="center" bgcolor="<?=$bg?>"> 
                  
				  <td align="center"> 
                    <?=MakeDate($rs[fromdate]) ?>                  </td>
				  <td align="center"> 
                    <?=MakeDate($rs[todate]) ?>                  </td>
                  <td align="left"> 
                    <?=$rs[comment] ?>                  </td>
				  <td align="left"> 
                    <?=$rs[refdoc] ?>                  </td>
                  <td align="center"><?=$arr_kp7str[$rs[kp7_active]] ?></td>
                  <td width="60"><a href="nosalary.php?id=<?=$rs[id]?>&no=<?=$rs[no]?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> &nbsp; <a href="#" onClick="if (confirm('�س�зӡ��ź��������ǹ�����������!!')) location.href='?action=delete&id=<?=$rs[id]?>&no=<?=$rs[no]?>';"><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a> </td>
                </tr>
                <?
	} //while
// List Template
?>
              </table>
              <?

If ($_GET[action]=="edit2")
{
		$sql = "select * from hr_nosalary where no='$no' and id = '$id'   ;";
		$result = mysql_query($sql);
		if ($result)
		{
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		}


}
?>
              <br>
              <table width="90%" border="0" cellspacing="2" cellpadding="0" align="center">
                <tr> 
                  <td align="right" valign="top" width="258"><font color="red">*</font> <B>����� �ѹ���</B></td>
                  <td align="left" valign="top" width="616"> 
                    <?dateInput($rs[fromdate],"from");?>                  </td>
                </tr>
				<tr> 
                  <td align="right" valign="top" width="258"><font color="red">*</font> <B>�֧ �ѹ���</B></td>
                  <td align="left" valign="top" width="616"> 
                    <?dateInput($rs[todate],"to");?>                  </td>
                </tr>
                <tr> 
                  <td align="right" valign="top" width="258"><B>��¡��</B></td>
                  <td align="left" valign="top" width="616"> <TEXTAREA NAME="comment" ROWS="7" COLS="60"><?=$rs[comment]?></TEXTAREA>				  </td>
                </tr>
				<tr> 
                  <td align="right" valign="top" width="258"><B>�͡�����ҧ�ԧ</B></td>
                  <td align="left" valign="top" width="616"> 
                    <input type="text" name="refdoc" size="60" value="<?=$rs[refdoc]?>">                  </td>
                </tr>
				<tr>
				  <td align="right" valign="top">&nbsp;</td>
				  <td align="left" valign="top"><label>
				    <input name="kp7_active" type="radio" value="1" checked="checked" <? if($rs[kp7_active]=="1"){ echo "checked";}?>>
				    �繢����ŷ���ʴ������ �.�. 7
				    <input name="kp7_active" type="radio" value="0" <? if($rs[kp7_active=="0"]){ echo "checked";}?>>
				  ���������ŷ������� �.�.7 </label></td>
			    </tr>
              </table>

			  <BR><BR>
              <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
                <tr valign="middle"> 
                  <td align="center" colspan=2> &nbsp;&nbsp; 
                    <input type="submit" name="send" value="  �ѹ�֡  ">
                    <input type="reset" value="  ¡��ԡ  " ONCLICK="location.href='?id=<?=$id?>';">

                  </td>
                </tr>
              </table>
            </form>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
          </td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>