<?
session_start();
$ApplicationName	= "userentry";
$module_code 		= "manage_keyin_data"; 
$process_id			= "report_staffkey_addpercen";
$VERSION 				= "9.91";
$BypassAPP 			= true;
ob_start(); 

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110709.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-07-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110709.00
	## Modified Detail :		��§ҹ��ṹ������úѹ�֡�����Ţͧ��ѡ�ҹ���������
	## Modified Date :		2011-07-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
			require_once("../../../config/conndb_nonsession.inc.php");
			include ("../../../common/common_competency.inc.php")  ;
			include("function.php");



?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
</head>


<link href="../../../common/style.css" type="text/css" rel="stylesheet">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script src="../../../common/gs_sortable.js"></script>
<script type=text/javascript src="../../../common/jscriptfixcolumn/jquery.min.js"></script>
<script type=text/javascript src="../../../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></script>
<script type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
        });
</script>
<link href="../../../common/gs_sortable.css" />
<style>
.txtcolor{
	color: #FF0000;
}

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
<style type="text/css">
<!--
A:link {
	FONT-SIZE: 12px;color: #000000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";TEXT-DECORATION: underline
}
A:visited {
	FONT-SIZE: 12px; COLOR: #000000; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:active {
	FONT-SIZE: 12px; COLOR: #014d5f; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline
}
-->
</style>

<style type=text/css>HTML * {
	FONT-FAMILY: Tahoma, "Trebuchet MS" , Verdana; FONT-SIZE: 11px
}
BODY {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
}
.baslik {
	TEXT-ALIGN: center; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #6b8e23; PADDING-LEFT: 5px; PADDING-RIGHT: 5px; COLOR: white; FONT-WEIGHT: bold; PADDING-TOP: 5px
}
.tdmetin {
	PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #dcdcdc; PADDING-LEFT: 5px; PADDING-RIGHT: 5px; COLOR: #00008b; FONT-WEIGHT: bold; PADDING-TOP: 5px
}
.code {
	BORDER-BOTTOM: #cccccc 1px solid; BORDER-LEFT: #cccccc 1px solid; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #eeeeee; PADDING-LEFT: 5px; WIDTH: 400px; PADDING-RIGHT: 5px; BORDER-TOP: #cccccc 1px solid; BORDER-RIGHT: #cccccc 1px solid; PADDING-TOP: 5px
}
.highlight {
	BACKGROUND-COLOR: highlight !important
}
.highlight2 {
	BACKGROUND-COLOR: #CCCCCC !important; COLOR: black
}
.tbl1 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
.tbl2 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
.tbl3 {
	BORDER-BOTTOM: gray 1px solid; BORDER-LEFT: gray 1px solid; BORDER-COLLAPSE: collapse; BORDER-TOP: gray 1px solid; BORDER-RIGHT: gray 1px solid
}
</style>

<BODY >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="1" cellspacing="1" cellpadding="3"  id="my_table" class="tbl3">
    <thead>  
      <tr>
        <td colspan="8" align="left" bgcolor="#CCCCCC"><strong>��§ҹ��úѹ�֡�����żԴ���Ԣͧ��ѡ�ҹ ���� 
          <?=$fullname?> ���ʾ�ѡ�ҹ <?=$id_code?>
        </strong></td>
        </tr>
      <tr>
        <th width="3%" align="center" bgcolor="#CCCCCC"><strong>�ӴѺ</strong></th>
        <th width="14%" align="center" bgcolor="#CCCCCC"><strong>�Ţ�ѵû�ЪҪ�</strong></th>
        <th width="23%" align="center" bgcolor="#CCCCCC">�ѧ�Ѵ</th>
        <th width="15%" align="center" bgcolor="#CCCCCC"><strong>�ѹ����������ѹ�֡</strong></th>
        <th width="15%" align="center" bgcolor="#CCCCCC"><strong>�ѹ��������ش�ѹ�֡</strong></th>
        <th width="10%" align="center" bgcolor="#CCCCCC"><strong>�ӹǹ��÷Ѵ<br>
���ź������(��÷Ѵ)</strong></th>
        <th width="10%" align="center" bgcolor="#CCCCCC"><strong>�Դ�繤�ṹ<br>
������(��ṹ)</strong></th>
        <th width="10%" align="center" bgcolor="#CCCCCC"><strong>��ṹ੾��<br>
��Ǵ�Թ��͹<br>
(��ṹ)</strong></th>
      </tr>
      </thead>
      <tbody>
      <?
      	$sql = "SELECT
t1.staffid,
t1.siteid,
t1.idcard,
t1.key_start,
t1.key_end,
t1.num_delete,
t1.num_point,
t1.num_pointsalary
FROM
log_case AS t1
WHERE
t1.staffid =  '$staffid' and t1.num_pointsalary > 0 and t1.flag_data='1'
order by t1.key_start ASC";
$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
$i=0;
while($rs = mysql_fetch_assoc($result)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td height="19" align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><?=GetArea($rs[siteid])?></td>
        <td align="left"><?=DBThaiLongDateFull($rs[key_start])?></td>
        <td align="left"><?=DBThaiLongDateFull($rs[key_end])?></td>
        <td align="right"><? if($rs[num_delete] > 0){ echo "<a href='index_report_detail_data.php?idcard=$rs[idcard]&staffid=$staffid&id_code=$id_code&fullname=$fullname&num_delete=$rs[num_delete]&num_point=$rs[num_point]&num_pointsalary=$rs[num_pointsalary]&xsiteid=$rs[siteid]' target='_blank'>".number_format($rs[num_delete])."</a>";}else{ echo "0";}?></td>
        <td align="right"><? echo number_format($rs[num_point],2);?></td>
        <td align="right"><? echo number_format($rs[num_pointsalary],2);?></td>
      </tr>
      <?
	  	$sum1 += $rs[num_delete];
		$sum2 += $rs[num_point];
		$sum3 += $rs[num_pointsalary];
	  
      	}//end  while($rs = mysql_fetch_assoc($result)){
	  ?>
      </tbody>
      <tfoot>
        <tr>
        <td height="19" colspan="5" align="center" bgcolor="#CCCCCC"><strong>���</strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum1)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum2)?>
        </strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong>
          <?=number_format($sum3)?>
        </strong></td>
      </tr>
</tfoot>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">
<!--
var TSort_Data = new Array ('my_table','','h','h','h','h','g','g','g');
var TSort_Classes = new Array ('row1', 'row2');
tsRegister();
// -->
</script> 
</body>
</html>


