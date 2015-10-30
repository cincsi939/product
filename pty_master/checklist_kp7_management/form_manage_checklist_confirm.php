<?
session_start();
include("../../config/conndb_nonsession.inc.php");
include("checklist2.inc.php");

if($action == "del"){
	$sqlup = "UPDATE  tbl_checklist_kp7_false  SET status_chang_idcard='YES' WHERE idcard='$idcard' AND siteid='$xsiteid' AND profile_id='$profile_id'";
	$resultup = mysql_db_query($dbname_temp,$sqlup);
	if($resultup){
			echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว');location.href='check_kp7_area.php?action=&xsiteid=$xsiteid&sentsecid=$xsiteid&schoolid=$schoolid&profile_id=$profile_id';</script>";
			exit();
			insert_log_import($xsiteid,$idcard,"ทำการลบเลขบัตรที่ไม่ถูกต้องตามกรมการปกครองออกจากรายการ pobec","1");	
	}
	
		
}//end if($action == "del"){

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
function IsNumeric(input){    
var RE = "/^-?(0|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/";    
return (RE.test(input));  
}  

function checkID(id) { 
	if(! IsNumeric(id)) return false;
	if(id.length != 13) return false;
	for(i=0, sum=0; i < 12; i++)
	sum += parseFloat(id.charAt(i))*(13-i);
	if((11-sum%11)%10!=parseFloat(id.charAt(12))) return false;
	return true;
} 


function checkFrom_idcard(){
		if(document.form1.status_id_false.checked ==  false){
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
	}
		//return true;
}//end function CheckForm(){

function EnableSave(){
	if( document.form1.status_id_false.checked ==  true){
		document.getElementById("save_data").disabled=false;	
	}else{
			checkFrom_idcard();
	}
}


function checkFrom(){

	if(document.form1.idcard.value == "" && document.form1.status_id_false.checked ==  false ){
		alert("เลขบัตรไม่ต้องเป็นค่าว่าง");
		document.form1.idcard.focus();
		return false;
	}
	if(document.form1.prename_th.value == ""){
		alert("คำนำหน้าชื่อไม่ควรเป็นค่าว่าง");
		document.form1.prename_th.focus();
		return false;
	}
	if(document.form1.name_th.value == ""){
		alert("ชื่อไม่ควรเป็นค่าว่าง");
		document.form1.name_th.focus();
		return false;
	}
	if(document.form1.surname_th.value == ""){
		alert("นามสกุลไม่ควรเป็นค่าว่าง");
		document.form1.surname_th.focus();
		return false;
	}
	if(document.form1.birthday.value == "" || document.form1.birthday.value == "00/00/0000"){
		alert("วันเกิดไม่ควรเป็นค่าว่าง");
		document.form1.birthday.focus();
		return false;
	}
	
	if(document.form1.begindate.value == "" || document.form1.begindate.value == "00/00/0000"){
		alert("วันเริ่มปฏิบัติราชการไม่ควรเป็นค่าว่าง");
		document.form1.begindate.focus();
		return false;
	}
	if(document.form1.position_now.value == ""){
		alert("ตำแหน่งไม่ควรเป็นค่าว่าง");
		document.form1.position_now.focus();
		return false;
	}
	return true;
}

//////////////////////////////////////////////////////////////////////////
	
function Getgenidcard() {
  var xidcard = "<?=$sysid?>";
   if(document.form1.status_id_false.checked == true){
	 	document.form1.idcard.value=xidcard; 
	}else{
		document.form1.idcard.value=""; 	
	}
 
  // document.getElementById("idcard").innerHTML = "xidcard";
}

function confirmDelete(delUrl) {
  if (confirm("คุณแน่ใจที่จะลบข้อมูลใช่หรือไม่?")) {
    document.location = delUrl;
  }
}//end function confirmDelete(delUrl) {

    
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

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td width="100%" bgcolor="#BBC9FF"><img src="../../images_sys/home.gif" width="20" height="20" alt="ย้อนกลับ" onClick="location.href='check_kp7_area.php?action=&xsiteid=<?=$xsiteid?>&sentsecid=<?=$xsiteid?>&schoolid=<?=$schoolid?>&profile_id=<?=$profile_id?>'" style="cursor:hand">&nbsp;<strong>
                รายการชื่อนามสกุลที่ซ้ำกันในข้อมูลเลขบัตรไม่ถูกต้องตามกรมการปกครอง&nbsp;&nbsp;</strong> ||  <a href="form_check_replace.php?profile_id=<?=$profile_id?>" target="_blank">คลิ๊กเพื่อตรวจสอบข้อมูลก่อนเพิ่ม</a></td>
              </tr>
            <tr>
              <td align="left" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td bgcolor="#999999"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                      <td colspan="6" align="left" bgcolor="#BBC9FF"><strong>
                        <?=show_area($xsiteid)?>
                      </strong></td>
                      </tr>
                    <tr>
                      <td width="3%" align="center" bgcolor="#BBC9FF"><strong>ลำดับ</strong></td>
                      <td width="22%" align="center" bgcolor="#BBC9FF"><strong>ชื่อ นามสกุล</strong></td>
                      <td width="24%" align="center" bgcolor="#BBC9FF"><strong>ตำแหน่ง</strong></td>
                      <td width="18%" align="center" bgcolor="#BBC9FF"><strong>วันเดือนปีเกิด</strong></td>
                      <td width="29%" align="center" bgcolor="#BBC9FF"><strong>หน่วยงานสังกัด</strong></td>
                      <td width="4%" align="center" bgcolor="#BBC9FF"><strong>ลบข้อมูล</strong></td>
                    </tr>
                    <?
                    	$sql = "SELECT * FROM tbl_checklist_kp7_false WHERE name_th='$name_th' AND surname_th='$surname_th' AND profile_id='$profile_id' AND siteid='$xsiteid' AND status_IDCARD LIKE  '%IDCARD_FAIL%' AND status_chang_idcard LIKE  '%NO%'";
						$result = mysql_db_query($dbname_temp,$sql);
						$i=0;
						while($rs = mysql_fetch_assoc($result)){
							if ($i++ %  2){ 	$bg = "#F0F0F0"; 	}else{ $bg = "#FFFFFF";	}
							if($rs[schoolid] > 0){
								$orgname = show_school($rs[schoolid]);	
							}else{
									$orgname = "ไม่ระบุ";
							}
					?>
                    <tr bgcolor="<?=$bg?>">
                      <td align="center"><?=$i?></td>
                      <td align="left"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
                      <td align="left"><? echo "$rs[position_now]";?></td>
                      <td align="center"><?=thai_date($rs[birthday]);?></td>
                      <td align="left"><?=$orgname?></td>
                      <td align="center"><a href="#" onClick="return confirmDelete('form_manage_checklist_confirm.php?action=del&idcard=<?=$rs[idcard]?>&xsiteid=<?=$rs[siteid]?>&profile_id=<?=$rs[profile_id]?>&schoolid=<?=$schoolid?>')"><img src="../../images_sys/b_drop.png" width="16" height="16" border="0" title="คลิ๊กเพื่อลบรายการข้อมูลของ<? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?>"></a></td>
                    </tr>
                    <?
						}//end while($rs = mysql_fetch_assoc($result)){
					?>
                  </table></td>
                </tr>
              </table></td>
              </tr>
          </table></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
