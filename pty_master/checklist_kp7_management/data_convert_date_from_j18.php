<?
session_start();
include("checklist2.inc.php");
$month1 = array( "มกราคม"=>"01","กุมภาพันธ์"=>"02","มีนาคม"=>"03","เมษายน"=>"04","พฤษภาคม"=>"05","มิถุนายน"=>"06", "กรกฎาคม"=>"07","สิงหาคม"=>"08","กันยายน"=>"09","ตุลาคม"=>"10","พฤศจิกายน"=>"11","ธันวาคม"=>"12");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<link href="../../common/jscriptfixcolumn/cssfixtable.css" rel="stylesheet">
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
<script language="javascript">
	 function gotourl( mySelect ) { 
      myIndex = mySelect.selectedIndex; 
      myValue = mySelect.options[myIndex].value; 
      window.location.href = myValue; 
   } 

</script>


</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="5" align="center" bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="16%" align="center" bgcolor="#CCCCCC"><strong>runid</strong></td>
        <td width="39%" align="center" bgcolor="#CCCCCC"><strong>idcard</strong></td>
        <td width="20%" align="center" bgcolor="#CCCCCC"><strong>birthday</strong></td>
        <td width="20%" align="center" bgcolor="#CCCCCC"><strong>begindate</strong></td>
      </tr>
      <?
      	$sql = "SELECT * FROM a_datj18_21";
		$result = mysql_db_query($dbname_temp,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
				if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
				$arr1 = explode("  ",trim($rs[birthday]));
				$arr2 = explode("  ",trim($rs[begindate]));
				//echo "<pre>";
			//	print_r($arr2);
				if($arr1[2] != ""){
					$int_month = $month1[trim($arr1[1])];
					$bdate = trim($arr1[2])."-".trim($int_month)."-".trim(sprintf("%02d",$arr1[0]));	
				}
				
				if($arr2[2] != ""){
					$int_month2 = $month1[trim($arr2[1])];
					$fdate = trim($arr2[2])."-".trim($int_month2)."-".trim(sprintf("%02d",$arr2[0]));	
				}

		if($bdate != ""){
				$coun_up1 = " ,birthday_value='$bdate'";
		}else{
				$coun_up1 = " ,birthday_value='0000-00-00'";
		}
		if($fdate != ""){
				$coun_up2 = " ,begindate_value='$fdate'";
		}else{
				$coun_up2 = " ,begindate_value='0000-00-00'";
		}
		$sql_up = " UPDATE a_datj18_21 SET idcard='$rs[idcard]' $coun_up1 $coun_up2  WHERE runid='$rs[runid]' ";
		mysql_db_query($dbname_temp,$sql_up) or die(mysql_error()."$sql_up<br>LINE::".__LINE__);
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[runid]?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="center"><?=$bdate?></td>
        <td align="center"><?=$fdate?></td>
      </tr>
      <?
	  	$fdate = "";
		$bdate = "";
		}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
</table>
</body>
</html>
