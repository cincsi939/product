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
	## Modified Detail :		รายงานคะแนนเพิ่มการบันทึกข้อมูลของพนักงานคีย์ข้อมูล
	## Modified Date :		2011-07-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
			require_once("../../../config/conndb_nonsession.inc.php");
			include ("../../../common/common_competency.inc.php")  ;
			include("function.php");

$dbsite = STR_PREFIX_DB.$xsiteid;
$secname = GetArea($xsiteid);
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

<style>
 table.picture{background-image: url(abiword_48.png);}
 </style>
 

<BODY >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="3" align="left" bgcolor="#CCCCCC"><strong><!--<a href="index_report_detail.php?staffid=<?=$staffid?>&id_code=<?=$id_code?>&fullname=<?=$fullname?>">ย้อนกลับ</a> || -->รายการเปรียบเทียบการบันทึกข้อมูลที่ผิดปกติ ชื่อพนักงาน <? echo "$fullname &nbsp; บันทึกข้อมูลเลขบัตร $idcard จำนวนบรรทัดที่ลบ $num_delete  จำนวนคะแนนทั้งหมด ".number_format($num_point,2)." จำนวนคะแนนเฉพาะข้อมูลเงินเดือน ".number_format($num_pointsalary,2);?> สังกัด <?=$secname?>  <br>======> <a href="report_logupdate.php?idcard=<?=$idcard?>&staffid=<?=$staffid?>&xsiteid=<?=$xsiteid?>&fullname=<?=$fullname?>&secname=<?=$secname?>" target="_blank">แสดงข้อมูล log update</a></strong></td>
        </tr>
      <tr>
        <td align="center" bgcolor="#CCCCCC"><strong>ข้อมูลก่อนลบรายการ (<a href="?idcard=<?=$idcard?>&staffid=<?=$staffid?>&id_code=<?=$id_code?>&fullname=<?=$fullname?>&num_delete=<?=$num_delete?>&num_point=<?=$num_point?>&num_pointsalary=<?=$num_pointsalary?>&xsiteid=<?=$xsiteid?>&xmode=G">ไม่แสดงการแก้ไขข้อมูล</a> || <a href="?idcard=<?=$idcard?>&staffid=<?=$staffid?>&id_code=<?=$id_code?>&fullname=<?=$fullname?>&num_delete=<?=$num_delete?>&num_point=<?=$num_point?>&num_pointsalary=<?=$num_pointsalary?>&xsiteid=<?=$xsiteid?>&xmode=">แสดงการแก้ไขข้อมูล</a>)</strong></td>
        <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td align="center" bgcolor="#CCCCCC"><strong>ข้อมูลหลังลบรายการ</strong></td>
      </tr>
      <tr bgcolor="#FFFFFF" valign="top">
        <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td colspan="8" align="center" bgcolor="#CCCCCC"><strong><?
                
					if($xmode == "G"){
							echo "ไม่แสดงการแก้ไขข้อมูล";
					}else{
							echo "แสดงการแก้ไขข้อมูล";	
					}
				?></strong></td>
                </tr>
              <tr>
               <td width="6%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ<br>
                 บรรทัด</strong></td>
                <td width="9%" align="center" bgcolor="#CCCCCC"><strong>วัน เดือนปี</strong></td>
               
                <td width="16%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
                <td width="7%" align="center" bgcolor="#CCCCCC"><strong>เลขที่<br>
                  ตำแหน่ง</strong></td>
                <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ระดับ</strong></td>
                <td width="12%" align="center" bgcolor="#CCCCCC"><strong>อัตราเงินเดือน</strong></td>
                <td width="24%" align="center" bgcolor="#CCCCCC"><strong>เอกสารอ้างอิง</strong></td>
                <td width="21%" align="center" bgcolor="#CCCCCC"><strong>เวลาข้อมูล</strong></td>
              </tr>
              <?
			  
			 # echo $dbsite."<br>";
			 if($xmode == "G"){
				$xgroup = " GROUP BY  t1.runid ";	 
			}else{
				$xgroup = " ";	
			}
			 
              	$sql = "SELECT
t1.auto_id,
t1.staffid,
t1.id,
t1.runno,
t1.runid,
t1.`date`,
t1.`position`,
t1.position_id,
t1.noposition,
t1.salary,
t1.upgrade,
t1.note,
t1.radub,
t1.noorder,
t1.pls,
t1.dateorder,
t1.label_date,
t1.updatetime
FROM
salary_log_after AS t1 where t1.staffid='$staffid' and t1.id='$idcard' 
$xgroup
order by t1.updatetime ASC";
		$result = mysql_db_query($dbsite,$sql) or die(mysql_error()."$sql<hr>".__LINE__);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
				if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
				
				if($rs[label_date] != ""){
						$showd = $rs[label_date];
				}else{
						$showd =DBThai($rs[date]);
				}
			  ?>
              <tr bgcolor="<?=$bg?>">
               <td align="center"><?=$rs[runno]?></td>
                <td align="left"><?=$showd?></td>
               
                <td align="left"><?=$rs[pls]?></td>
                <td align="center"><?=$rs[noposition]?></td>
                <td align="center"><?=$rs[radub]?></td>
                <td align="right"><?=$rs[salary]?></td>
                <td align="left"><?=$rs[noorder]?></td>
                <td align="left"><?=DBThaiLongDateFull($rs[updatetime])?></td>
              </tr>
       <?
		}//end 
	   ?>
            </table></td>
          </tr>
        </table></td>
        <td width="1%">&nbsp;</td>
        <td width="49%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
              <td width="7%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ<br>
                บรรทัด</strong></td>
                <td width="9%" align="center" bgcolor="#CCCCCC"><strong>วัน เดือนปี</strong></td>
                
                <td width="16%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
                <td width="7%" align="center" bgcolor="#CCCCCC"><strong>เลขที่<br>
                  ตำแหน่ง</strong></td>
                <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ระดับ</strong></td>
                <td width="12%" align="center" bgcolor="#CCCCCC"><strong>อัตราเงินเดือน</strong></td>
                <td width="23%" align="center" bgcolor="#CCCCCC"><strong>เอกสารอ้างอิง</strong></td>
                <td width="21%" align="center" bgcolor="#CCCCCC"><strong>เวลาข้อมูล</strong></td>
              </tr>
              <?
              	$sql1 = "SELECT t1.id, t1.runno, t1.runid, t1.`date`, t1.`position`, t1.position_id, t1.noposition, t1.salary, t1.upgrade, t1.note, t1.radub, t1.noorder, t1.pls, t1.dateorder, t1.label_date, t1.updatetime FROM salary AS t1 where t1.id='$idcard' order by t1.runno ASC";
		$result1 = mysql_db_query($dbsite,$sql1) or die(mysql_error()."".__LINE__);
		$i1=0;
		while($rs1 = mysql_fetch_assoc($result1)){
				if ($i1++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
				
				if($rs1[label_date] != ""){
						$showd1 = $rs1[label_date];
				}else{
						$showd1 =DBThai($rs1[date]);
				}
			  ?>
              <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$rs1[runno]?></td>
                <td align="left"><?=$showd1?></td>
                
                <td align="left"><?=$rs1[pls]?></td>
                <td align="center"><?=$rs1[noposition]?></td>
                <td align="center"><?=$rs1[radub]?></td>
                <td align="right"><?=$rs1[salary]?></td>
                <td align="left"><?=$rs1[noorder]?></td>
                <td align="left"><?=DBThaiLongDateFull($rs1[updatetime])?></td>
              </tr>
              <?
		}//end 
	   ?>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>


