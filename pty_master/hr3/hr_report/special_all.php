<?php
//include ("session.inc.php");
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_special";
$module_code 		= "special"; 
$process_id			= "special";
$VERSION 				= "9.91";
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
$time_start = getmicrotime();
$sql = "select * from  general where id='$id'  ;";
		$result = mysql_query($sql);
		if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		} else {
		$msg = "Cannot find parameter information.";
		echo $msg;
		}

		?>
<html>
<head>
<title>��������ö�����</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style2 {color: #000000}
-->
</style>

<!-- send id to menu flash -->

</head>

<body bgcolor="#A3B2CC">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30"><br>
        <table width="98%"  align="center">
		<?
		if($dis_menu){// ������鹡�ûԴ����
		?>
	  <tr>
       <td height="21" colspan="2">
	<a href="kp7_special.php?id=<?=$id?>" title="��Ǩ�ͺ������ ��.7"> <img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" ><span class="style2"> ��Ǩ�ͺ�͡��â����� �.�.7 ����硷�͹ԡ�� </span></a>
		</td>
      </tr>
		<?
		}else{
		?>
          <tr>
            <td width="21%" height="21"><a href="special.php?id=<?=$rs[id]?>&action=edit&vspecial=1" title="��䢢�����"><img src="images/edit.png" width="16" height="16" align="absmiddle" border=""><span class="style2">����/ź/��� ������</span></a> </td>
                <td width="79%">&nbsp;<a href="kp7_special.php?id=<?=$id?>" title="��Ǩ�ͺ������ ��.7"> <img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" ><span class="style2"> ��Ǩ�ͺ�͡��â����� �.�.7 ����硷�͹ԡ�� </span></a></td>
              </tr>
	<?
	}// ����ش if($dis_menu)
	?>
        </table>
		</td><td width="50" height="30">&nbsp;</td>
      </tr>
    </table></td>
    <td width="50" height="30"> 

    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td valign="top"><br>
 
              <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr> 
                  <td align="left" valign="top"><b>���� / ʡ�� &nbsp;&nbsp; 
                    &nbsp;<u>
                    <?=$rs[prename_th]?>
                    <?=$rs[name_th]?>
                    <?=$rs[surname_th]?></u> </b> </td>
                </tr>
              </table>
              <br>
             &nbsp;&nbsp; <strong> </strong>&nbsp;<strong>�. ��������������ö�����</strong><br>
              <br>
              <table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
                
                <tr bgcolor="#A3B2CC" align="center"> 
         
                  <td width="61%" ><strong>��������´</strong></td>
                </tr>
                <?

	$i=0;
	$result = mysql_query("select t1.*,t2.major as majorname,t3.groupname from special t1 left join $dbnamemaster.hr_addmajor t2 on t1.major=t2.runid left join $dbnamemaster.specialgroup t3 on t1.specialgroup=t3.runid where t1.id='$id' order by t1.runno asc");
	while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		$i++;
		if ($i % 2) {
		$bg = "#EFEFEF";
		}else{
		$bg = "#DDDDDD";
		}
?>
                <tr bgcolor="<?=$bg?>"> 
               
                  <td><?=$rs[detail]?></td>
                </tr>
                <?
	} //while


?>
              </table>

	              <br></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>

<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
