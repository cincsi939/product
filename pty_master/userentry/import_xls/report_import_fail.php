<?php
session_start();
set_time_limit(0);
define('POPUP', true, true);
$site['header_name'] = "��§ҹ�����Դ��Ҵ��ù���Ңͧ������";
//include('root_path.php');
//include("../../../config/config_hr.inc.php");
ini_set("memory_limit","64M") ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
  <link href="common/style1.css" type="text/css" rel="stylesheet" />
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
.style8 {
	font-family: "Times New Roman", Times, serif;
	font-size: 12;
	color: #000000;
	font-weight: bold;
}
.style9 {
	font-family: "Times New Roman", Times, serif;
	font-size: 12px;
}
.style12 {
	font-size: 14px;
	color: #000000;
	font-family: "Times New Roman", Times, serif;
	font-weight: bold;
}
-->
</style>
</head>
<body >
 <?
if($action == "report_fail"){
?>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#144C85', EndColorStr='#ffffff');" height="480">
   <tr>
     <td valign="top"><br />
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td align="center"><span class="style8">��§ҹ�����Դ��Ҵ�ͧ�����Ţͧ���鹷ҧ</span></td>
         </tr>
         <tr>
           <td align="center">&nbsp;</td>
         </tr>
         <tr>
           <td align="center"><table width="80%" border="0" cellspacing="0" cellpadding="5">
             <tr>
               <td width="25%" align="right" valign="middle"><img src="../../../images_sys/arrow_130.gif" width="14" height="14" /></td>
               <td width="75%" align="left" valign="middle"><span class="style9"><? echo "��������� excel ��ù�������١��ͧ"; ?></span></td>
             </tr>
             <tr>
               <td align="right" valign="middle"><img src="images/arrow_130.gif" width="14" height="14" /></td>
               <td align="left" valign="middle"><span class="style9"><? echo "��Ŵ���������� excel ��ù���Ң������������ó�"; ?></span></td>
             </tr>
             <tr>
               <td align="right" valign="middle"><img src="images/arrow_130.gif" width="14" height="14" /></td>
               <td align="left" valign="middle"><span class="style9"><? echo "������� Record �������ó�"; ?></span></td>
             </tr>
           </table></td>
         </tr>
         <tr>
           <td align="center">&nbsp;</td>
         </tr>
         <tr>
           <td align="center">&nbsp;</td>
         </tr>
         <tr>
           <td align="center"><label>
             <input type="button" name="btBlack" value="��͹��Ѻ" onclick="location.href='import_xls/browse.php'">
           </label>
           <input type="button" name="btClose" value="�Դ˹�ҵ�ҧ" onclick="window.close();" />           </td>
         </tr>
       </table></td>
   </tr>
 </table>
 <?
 	}
 ?>
<?
	if($action == "complate"){
      $recerr= $_GET['recerr'];
      $recok= $_GET['recok']; 
      $rectotal= $_GET['rectotal']; 
	  $recmiss= $_GET['recmiss']; 
        
?>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#144C85', EndColorStr='#ffffff');" height="480">
   <tr>
     <td valign="top"><br />
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
         
         
         <tr>
           <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normal" bordercolorlight="#CCCCCC">
             <tr>
               <td><table width="100%" border="0" cellpadding="5" cellspacing="0">
                 <tr>
                   <td colspan="3" align="center" class="style12">��§ҹ��ù���Ң�����</td>
                 </tr>
                 <tr>
                   <td colspan="3" align="center" class="style9">
                   
                   <form id="form1" name="form1" method="post" action="">                     
                     <table width="78%" border="0" cellspacing="0" cellpadding="0">
                       <tr>
                         <td>��¡�÷���ջѭ��</td>
                         <td>&nbsp;</td>
                       </tr>
                       <tr>
                         <td>&nbsp;</td>
                         <td>&nbsp;</td>
                       </tr>
                       <tr>
                         <td width="24%">ʶҹ�֡��/˹��§ҹ</td>
                         <td width="76%">��������´</td>
                       </tr>
                       <tr>
                         <td>
                         <select name="select" id="select" style="width:200px;">
                         
                         </select>
                         </td>
                         <td>&nbsp;</td>
                       </tr>
                       <tr>
                         <td>&nbsp;</td>
                         <td>&nbsp;</td>
                       </tr>
                       <tr>
                         <td>&nbsp;</td>
                         <td><span class="table_button">
                           <input name="button1"  type="submit" class="bt" value="�ѹ�֡" />
                         </span></td>
                       </tr>
                     </table>
                   </form>
                   
                   
                  </td>
                 </tr>

                 <tr>
                   <td align="right">&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                 </tr>
                 <tr>
                   <td width="31%" align="right">�ӹǹ������ҷ������ҡ��� Excel </td>
                   <td width="36%"><?=$recok?></td>
                   <td width="33%">��¡��</td>
                 </tr>
				
				
                 <tr>
                   <td align="right">��§ҹ���������ʻ�Шӵ�ǫ�� &nbsp;</td>
                   <td ><?=$recmiss?></td>
                   <td>��¡��</td>
                 </tr>
                 <tr>
                   <td align="right">��§ҹ���������ʻ�Шӵ���繤����ҧ </td>
                   <td ><?=$recerr?></td>
				   <td>��¡��</td>
                 </tr>
                 <tr>
                   <td align="right">����ӹǹ��¡�÷����� </td>
                   <td><?=$rectotal?></td>
                   <td>��¡��</td>
                 </tr>
                 <tr>
                   <td align="right">&nbsp;</td>
                   <td>&nbsp;</td>
				   <td>&nbsp;</td>
                 </tr>
                 <tr>
                   <td colspan="3" align="center"><label>
                     <input type="button" name="btClose" value="�Դ˹�ҵ�ҧ" onclick="window.close();" />
                   </label></td>
                   </tr>
               </table></td>
             </tr>
           </table></td>
         </tr>
       </table></td>
   </tr>
</table>
 
 <?
}
?>

</body>
</html>