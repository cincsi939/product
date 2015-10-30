<?
session_start();
include("checklist2.inc.php");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<link href="../../common/cssfixtable.css" rel="stylesheet" type="text/css">
<SCRIPT type=text/javascript src="../../common/jscriptfixcolumn/jquery.min.js"></SCRIPT>
<SCRIPT type=text/javascript src="../../common/jscriptfixcolumn/jquery.fixedtableheader.min.js"></SCRIPT>
<SCRIPT type=text/javascript>
        $(function() {
            $(".tbl1").fixedtableheader();
            $(".tbl2").fixedtableheader({ highlightrow: true, headerrowsize: 2 });
            $(".tbl3").fixedtableheader({ highlightrow: true, highlightclass: "highlight2", headerrowsize: 2 });
        });
</SCRIPT>

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
			 $sqlx = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$xidcard' AND profile_id='$profile_id' AND mainpage='0'"; 
			 $resultx = mysql_db_query($dbname_temp,$sqlx);
			 $rsx = mysql_fetch_assoc($resultx);
			 $numx1 = @mysql_num_rows($resultx);
			 
			   $sql = "SELECT
tbl_checklist_problem_detail.idcard,
tbl_checklist_problem_detail.problem_id,
tbl_checklist_problem_detail.menu_id,
tbl_checklist_problem_detail.problem_detail,
tbl_checklist_problem_detail.status_problem,
tbl_checklist_problem_detail.profile_id,
tbl_check_menu.menu_detail,
tbl_problem.problem
FROM
tbl_checklist_problem_detail
Inner Join tbl_check_menu ON tbl_checklist_problem_detail.menu_id = tbl_check_menu.menu_id
Inner Join tbl_problem ON tbl_checklist_problem_detail.problem_id = tbl_problem.problem_id
where idcard='$xidcard' and profile_id='$profile_id'
order by tbl_check_menu.orderby ASC";
$result = mysql_db_query($dbname_temp,$sql);
$numx2 = @mysql_num_rows($result);



	$sqlname = "SELECT idcard,siteid,prename_th,name_th,surname_th,position_now,schoolid FROM tbl_checklist_kp7 WHERE idcard='$xidcard' AND profile_id='$profile_id'";
	$resultname = mysql_db_query($dbname_temp,$sqlname);
	$rsn = mysql_fetch_assoc($resultname);

			$orgn = show_school($rsn[schoolid]);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td bgcolor="#E2E2E2"><table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl3">
              <tr>
                <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>
                  <?=$rsn[idcard]?>
  &nbsp;<? echo "$rsn[prename_th]$rsn[name_th]  $rsn[surname_th]&nbsp;&nbsp;$rsn[position_now]";?>&nbsp;
  <?=$orgn?>
  &nbsp;จำนวน
  <?=number_format($numx1+$numx2);?>
                  รายการ</strong></td>
                </tr>
              <tr>
                <td width="25%" align="center" bgcolor="#CCCCCC"><strong>หมวดปัญหา</strong></td>
                <td width="32%" align="center" bgcolor="#CCCCCC"><strong>หมวดเอกสาร</strong></td>
                <td width="43%" align="center" bgcolor="#CCCCCC"><strong>ปัญหา</strong></td>
                </tr>
              <?
			 if($rsx[mainpage] == "0"){
				echo "<tr bgcolor='#F0F0F0'>
                <td align=\"left\">&nbsp;</td>
                <td align=\"left\">ปกเอกสาร</td>
                <td align=\"left\">$rsx[mainpage_comment]</td>
              </tr>
";		 
			}
			 
$i=0;
while($rs = mysql_fetch_assoc($result)){
		 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			  ?>
              <tr bgcolor="<?=$bg?>">
                <td align="left"><?=$rs[problem]?></td>
                <td align="left"><?=$rs[menu_detail]?></td>
                <td align="left"><?=$rs[problem_detail]?></td>
                </tr>
              <?
              	}//end 
			  ?>
              </table></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
