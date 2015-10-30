<?
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
			
			$sql = "SELECT DISTINCT
t2.CZ_ID as idcard,
t2.siteid,
t2.prename_th,
t2.name_th,
t2.surname_th,
t1.req_date
FROM
 ".DB_MASTER.".req_problem_person AS t1
Inner Join  ".DB_MASTER.".view_general as t2 ON t1.idcard =t2.CZ_ID
WHERE
t1.req_status =  '3'
group by t2.CZ_ID";
	    $result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
				$dbsite = STR_PREFIX_DB.$rs[siteid];
				######
				$sql1 = "SELECT count(t1.username) as numedit FROM log_update as t1 where  t1.username='$rs[idcard]' and t1.action NOT LIKE '%login%' and t1.updatetime > '$rs[req_date]' GROUP BY t1.username ";
				$result1 = mysql_db_query($dbsite,$sql1) or die(mysql_error()."".__LINE__);
				$rs1 = mysql_fetch_assoc($result1);
				if($rs1[numedit] > 0){
						$status_edit = "YES";
				}else{
						$status_edit = "NO";
				}
				$sql_replace = "REPLACE INTO req_problem_editkey SET idcard='$rs[idcard]',siteid='$rs[siteid]',status_edit='$status_edit',timeupdate=NOW()";
				mysql_db_query($dbnamemaster,$sql_replace) or die(mysql_error()."".__LINE__);
		}//end 	while($rs = mysql_fetch_assoc($result)){




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานการคีย์ข้อมูลของพนักงานกลุ่ม N ของเดือนมีนาคม</title>
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
<script type=text/javascript src="../../common/jscriptfixcolumn/jquery.min.js"></script>
<script type=text/javascript src="../../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></script>
<script type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 3 });
        });
</script>

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
</head>
<body>
<?
	$date_dis = (date("Y")+543)-2;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="3%" rowspan="3" align="center" bgcolor="#CCCCCC">ลำดับ</td>
        <td width="17%" rowspan="3" align="center" bgcolor="#CCCCCC">สำนักงานเขตพื้นที่การศึกษา</td>
        <td width="8%" rowspan="3" align="center" bgcolor="#CCCCCC">จำนวนคำร้อง<br />
          ทั้งหมด(คน)</td>
        <td colspan="6" align="center" bgcolor="#CCCCCC">มอบหมายงานแล้ว</td>
        <td width="10%" rowspan="3" align="center" bgcolor="#CCCCCC">ค้างมอบหมายงาน</td>
      </tr>
      <tr>
        <td colspan="2" align="center" bgcolor="#CCCCCC">พนักงานยืนยันการแก้ไขแล้ว</td>
        <td width="10%" rowspan="2" align="center" bgcolor="#CCCCCC">ตรวจสอบแล้ว<br />
          ไม่พบจุดผิด</td>
        <td width="10%" rowspan="2" align="center" bgcolor="#CCCCCC">ตรวจสอบแล้วคำร้องเป็น<br />
          ข้อมูลขยะ</td>
        <td width="10%" rowspan="2" align="center" bgcolor="#CCCCCC">ต้องการคำ<br />
          อธิบายเพิ่มเติม</td>
        <td width="10%" rowspan="2" align="center" bgcolor="#CCCCCC">อยู่ระหว่าง<br />
          ดำเนินการ</td>
        </tr>
      <tr>
        <td width="12%" align="center" bgcolor="#CCCCCC">ตรวจสอบแล้วพบจุดการแก้ไข<br />
          จากข้อมูลในระบบ</td>
        <td width="10%" align="center" bgcolor="#CCCCCC">ตรวจสอบแล้วไม่พบจุด<br />
          แก้ไขจากข้อมูลในระบบ</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
