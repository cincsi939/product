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
<?
	if($action == ""){
?>
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="2" align="left" bgcolor="#CCCCCC"><strong>���͡���͹䢡���ʴ���§ҹ��úѹ�֡�����ŷ��Դ����</strong></td>
              </tr>
            <tr>
              <td width="23%" align="right" bgcolor="#FFFFFF"><strong>���͹��ʴ���§ҹ</strong></td>
              <td width="77%" bgcolor="#FFFFFF">
                <input type="radio" name="type_showstaff" id="1" value="Y">
              		�ʴ����;�ѡ�ҹ��������� 
                  <input type="radio" name="type_showstaff" id="2" value="N">
                  ����ʴ����;�ѡ�ҹ���������
                </td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF"><strong>ʶҹС�÷ӧҹ</strong></td>
              <td bgcolor="#FFFFFF">
              <input type="radio" name="status_permit" id="radio" value="ALL">
              �ʴ������ŷ�����
              <input type="radio" name="status_permit" id="radio" value="YES">
                �ѧ�ӧҹ���� 
                <input type="radio" name="status_permit" id="radio2" value="NO">
               �͡�ҹ����</td>
            </tr>
            <tr>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">
              <input type="hidden"  name="action" value="show_report">
              <input type="submit" name="button" id="button" value="�ʴ�˹����§ҹ"></td>
            </tr>
          </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
 <?
	}//end 
	if($action == "show_report"){
 ?>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="1" cellspacing="1" cellpadding="3"  id="my_table" class="tbl3">
    <thead>  
      <tr>
        <td colspan="12" align="left" bgcolor="#CCCCCC"><a href="?action=">��Ѻ˹����ѡ</a> || ��§ҹ��ª��;�ѡ�ҹ��������ŷ��ѹ�֡�����żԴ����</td>
        </tr>
      <tr>
        <th width="3%" align="center" bgcolor="#CCCCCC"><strong>�ӴѺ</strong></th>
        <th width="6%" align="center" bgcolor="#CCCCCC"><strong>���ʾ�ѡ�ҹ</strong></th>
        <th width="10%" align="center" bgcolor="#CCCCCC"><strong>���� - ���ʡ�ž�ѡ�ҹ</strong></th>
        <th width="10%" align="center" bgcolor="#CCCCCC"><strong>�ѹ��������(�����żԴ����)</strong></th>
        <th width="11%" align="center" bgcolor="#CCCCCC"><strong>�ѹ�������ش(�����żԴ����)</strong></th>
                <th width="8%" align="center" bgcolor="#CCCCCC"><strong>ʶҹС�÷ӧҹ</strong></th>
        <th width="8%" align="center" bgcolor="#CCCCCC"><strong>�ѹ���������ҹ</strong></th>
        <th width="9%" align="center" bgcolor="#CCCCCC"><strong>�ѹ����͡�ҹ</strong></th>
        <th width="9%" align="center" bgcolor="#CCCCCC"><strong>�ӹǹ�ش������<br>
          �Դ����(�ش)</strong></th>
        <th width="9%" align="center" bgcolor="#CCCCCC"><strong>�ӹǹ��÷Ѵ<br>
          ���ź������(��÷Ѵ)</strong></th>
        <th width="8%" align="center" bgcolor="#CCCCCC"><strong>�Դ�繤�ṹ<br>
          ������(��ṹ)</strong></th>
        <th width="9%" align="center" bgcolor="#CCCCCC"><strong>��ṹ੾��<br>
��Ǵ�Թ��͹<br>
(��ṹ)</strong></th>
      </tr>
      </thead>
      <tbody>   
      <?
	  	if($status_permit  !=  "ALL" and $status_permit != ""){
				$constatus = " AND t2.status_permit='$status_permit' ";
		}else{
				$constatus = "";	
		}
		

		$sql = "SELECT
t2.staffid,
t2.id_code,
concat(t2.prename,t2.staffname,' ',t2.staffsurname) AS fullname,
t2.start_date AS startdate,
t2.retire_date AS enddate,
Count(t1.idcard) AS nump,
Sum(t1.num_delete) AS numdel,
Min(t1.key_start) AS startkey,
Max(t1.key_end) AS endkey,
Sum(t1.num_point) AS numpointall,
Sum(t1.num_pointsalary) AS numpointsalary,
t2.sapphireoffice,
t2.keyin_group,
t2.status_permit
FROM
log_case AS t1
Inner Join keystaff AS t2 ON t1.staffid = t2.staffid
WHERE t2.sapphireoffice <>  '1' and t1.num_pointsalary > 0 and t1.flag_data='1'  $constatus
GROUP BY t2.staffid
having numpointall > 0";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
		if($type_showstaff == "Y"){
				$fullname = $rs[fullname];
		}else{
				$fullname = "xxxxxxxxxxxxxxxx";	
		}//endif($type_showstaff == "Y"){ 
		
		if($rs[status_permit] == "YES"){
				$bcolor = " style=\"color:#009900\" ";
				$txtw = "�ѧ�ӧҹ����";
				$endwork = "";
		}else{
				$bcolor = " style=\"color:#FF0000\"";	
				$txtw = "�͡�ҹ����";
				$endwork = DBThaiLongDateFull($rs[enddate]);
		}
		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[id_code]?></td>
        <td align="left"><?=$fullname?></td>
        <td align="left"><?=DBThaiLongDateFull($rs[startkey]);?></td>
        <td align="left"><?=DBThaiLongDateFull($rs[endkey]);?></td>
                <td align="center" <?=$bcolor?>><?=$txtw?></td>
        <td align="left"><?=DBThaiLongDateFull($rs[startdate]);?></td>
        <td align="left"><?=$endwork?></td>
        <td align="center"><? if($rs[nump] > 0){ echo "<a href='index_report_detail_v1.php?staffid=$rs[staffid]&id_code=$rs[id_code]&fullname=$fullname' target=\"_blank\">".number_format($rs[nump])."</a>";}else{ echo "0";}?></td>
        <td align="center"><?=number_format($rs[numdel])?></td>
        <td align="center"><?=number_format($rs[numpointall],2)?></td>
        <td align="center"><?=number_format($rs[numpointsalary],2)?></td>

      </tr>

      <?
	  $sum1 += $rs[nump] ;
	  $sum2 += $rs[numdel];
	  $sum3 += $rs[numpointall];
	  $sum4 += $rs[numpointsalary];
	  
	}//end 
	  ?>
      </tbody>
      <tfoot>
         <tr>
        <td colspan="8" align="center" bgcolor="#CCCCCC"><strong>���</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum1)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum2)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum3)?></strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong><?=number_format($sum4)?></strong></td>
      </tr>
      </tfoot>
    </table></td>
  </tr>
  
  <?
	}//endif($action == "show_report"){
  ?>
  
  <tr>
    <td>&nbsp;</td>
  </tr>
</table> 
<script type="text/javascript">
<!--
var TSort_Data = new Array ('my_table','','h','h', 'h','h','h','h','h','g','g','g','g');
var TSort_Classes = new Array ('row1', 'row2');
tsRegister();
// -->
</script> 

</body>
</html>


