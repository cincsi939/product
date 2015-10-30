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
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript">
function IsNumeric(input){    var RE = /^-?(0|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/;    return (RE.test(input));  }  
function checkID(id) {
if(! IsNumeric(id)) return false;
if(id.length != 13) return false;
for(i=0, sum=0; i < 12; i++)
sum += parseFloat(id.charAt(i))*(13-i);
if((11-sum%11)%10!=parseFloat(id.charAt(12))) return false;
return true;
}



/*function checkID(id) { 
	if(id.length != 13) return false; 
		for(i=0, sum=0; i < 12; i++) 
		sum += parseFloat(id.charAt(i))*(13-i); 
		if((11-sum%11)%10!=parseFloat(id.charAt(12))) return false; 
		return true; 
} 
*/	function checkFrom_idcard(){
		
				if(!checkID(document.form1.idcard.value)){
						//alert(" ! เลขบัตรประจำตัวของท่านไม่ถูกต้องตามกรมการปกครอง กรุณาระบุใหม่อีกครั้ง");
						
						document.getElementById("save_data").disabled=true;
						document.getElementById("txt_alt").innerHTML = " *เลขบัตรประจำตัวของท่านไม่ถูกต้องตามกรมการปกครอง";
					
						
				//		document.form1.idcard.focus();
//						return false;
					}else{
						document.getElementById("save_data").disabled=false;
						document.getElementById("txt_alt").innerHTML = "";
					}

		//return true;
	}//end function CheckForm(){



</script>

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

</head>
<body>
<?
	if($action == ""){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="2" bgcolor="#BBC9FF"><strong>ตรวจสอบข้อมูลซ้ำกันภายในระบบตรวจสอบข้อมูล ก.พ. 7 ต้นฉบับ</strong></td>
              </tr>
            <tr>
              <td width="16%" align="right" bgcolor="#FFFFFF"><strong>เลขบัตรประชาชน : </strong></td>
              <td width="84%" align="left" bgcolor="#FFFFFF"><label>
                <input name="idcard" type="text" id="idcard" size="25" onBlur="return checkFrom_idcard(this.value)" maxlength="13" value="<?=$idcard?>">
              </label></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
              <td align="left" bgcolor="#FFFFFF"><label>
              <input type="hidden" name="Search" value="search">
                <input type="submit" name="Submit"  id="save_data"value="ตรวจสอบ">
                <input type="button" name="btnClose" value="ปิดหน้าต่าง" onClick="window.close()">
              </label></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
              <td align="left" bgcolor="#FFFFFF"><font color="#FF0000"><div id="txt_alt"></div></font></td>
            </tr>
          </table></td>
        </tr>
      </table>
        </form>
    </td>
  </tr>
</table><br>

<?
	if($Search == "search"){
		$sql = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND  profile_id='$profile_id'";
		$result = mysql_db_query($dbname_temp,$sql);
		$num_r = @mysql_num_rows($result);
		$rs = mysql_fetch_assoc($result);
		if($num_r < 1){
			echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td bgcolor=\"#000000\"><table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\"><tr bgcolor=\"#FFFFFF\"><td align=\"center\">-ไม่พบข้อมูลซ้ำในระบบสามารถเพิ่มข้อมูลได้เลย</td></tr></table></td></tr></table>";
		
		}else{
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td colspan="2" bgcolor="#BBC9FF"><strong>ผลการตรวจเลขบัตร</strong></td>
        </tr>
      <tr>
        <td width="16%" align="right" bgcolor="#FFFFFF"><strong>รหัสบัตร&nbsp;:</strong></td>
        <td width="84%" bgcolor="#FFFFFF"><?=$rs[idcard]?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FFFFFF"><strong>ชื่อ - นามสกุล&nbsp;:</strong></td>
        <td bgcolor="#FFFFFF"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FFFFFF"><strong>เขตพื้นที่การศึกษา&nbsp;:</strong></td>
        <td bgcolor="#FFFFFF"><? echo show_area($rs[siteid]);?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FFFFFF"><strong>สังกัด/โรงเรียน&nbsp;:</strong></td>
        <td bgcolor="#FFFFFF"><?  if($rs[schoolid] != "" and $rs[schoolid] != "0" and $rs[schoolid] != NULL){ echo show_school($rs[schoolid]);}else{ echo "ไม่ระบุ";}?></td>
      </tr>
    </table></td>
  </tr>
</table>
<?
		}//end if($num_r < 1){
	}//end if($Search == "search"){
	}//end if($action == ""){
?>
</body>
</html>
