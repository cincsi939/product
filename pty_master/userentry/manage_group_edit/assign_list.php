<?
session_start();
$ApplicationName	= "profile_group_edit";
$module_code 		= "profile_group_edit"; 
$process_id			= "profile_group_edit";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110503.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-05-03 15:00
	## Created By :		Mr.Suwat Khamtum
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110503.001 
	## Modified Detail :		ระบบบริหารจัดการกลุ่มการแก้ไขข้อมูล
	## Modified Date :		2011-05-03 15:00
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################



include "config_mgroup.php";
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();
if($action == ""){
	$action = "all";	
}// end 
/*echo "<script>alert('บันทึกข้อมูลใบงานเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=assign_detail&TicketId=$TicketId&staffid=$staffid&profile_id=$profile_id';</script>";*/

$report_title = "มอบหมายใบงานแก้ไขข้อมูล ก.พ.7 ";

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	if($action == "SaveTicket"){
		## สร้างใบงาน
		if(count($arr_idcard) > 0){
			$ticketid = ECreateTicketid($staffid);
			foreach($arr_idcard as $key => $val){
					$sql_assign = "INSERT INTO tbl_assign_edit_key SET ticketid='$ticketid',idcard='$key',fullname='".$arr_fullname[$key]."',siteid='$val',dateassgin=NOW()";
					mysql_db_query($dbnameuse,$sql_assign) or die(mysql_error()."$sql_assign<hr>LINE::".__LINE__);
					EInsertLogAssignEdit($key,$val,$ticketid,$staffid,"มอบหมายงานแก้ไข","");// insert LOG	
			}//end 	foreach($arr_idcard as $key => $val){
				
						echo "<script>alert('สร้างใบงานเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=view_ticketid&mode=&staffid=$staffid';</script>";	
		exit();

		}else{
				echo "<script>alert('ไม่สามารถสร้างใบงานได้เนื่องจากไม่พบข้อมูลบุคลากร'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=view_ticketid&mode=&staffid=$staffid';</script>";	
		exit();	
		}//end 	if(count($arr_idcard) > 0){
	}//if($action == "SaveTicket"){	
	
	###################  เพิ่มข้อมูลบุคลากร
	if($action == "SavePerson"){
		if(count($arr_idcard) > 0){
			foreach($arr_idcard as $key => $val){
					$sql_assign = "INSERT INTO tbl_assign_edit_key SET ticketid='$ticketid',idcard='$key',fullname='".$arr_fullname[$key]."',siteid='$val',dateassgin=NOW()";
					mysql_db_query($dbnameuse,$sql_assign) or die(mysql_error()."$sql_assign<hr>LINE::".__LINE__);
					EInsertLogAssignEdit($key,$val,$ticketid,$staffid,"มอบหมายงานแก้ไข","");// insert LOG	
			}//end 	foreach($arr_idcard as $key => $val){
							echo "<script>alert('เพิ่มบุคลากรในใบงานเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=view_ticketid&mode=view_detail&staffid=$staffid&ticketid=$ticketid';</script>";	
		exit();

		}else{// end if(count($arr_idcard) > 0){
						echo "<script>alert('ไม่สามารถเพิ่มบุคลากรในใบงานได้เนื่องจากไม่พบข้อมูลบุคลากร'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=view_ticketid&mode=view_detail&staffid=$staffid&ticketid=$ticketid';</script>";	
		exit();

		}
	}//end 	if($action == "SavePerson"){
		
	##########################################################
	
	if($action == "SavePersonEdit"){
		if(count($arr_idcard_temp) > 0){
			foreach($arr_idcard_temp as $key => $val){
					if($arr_idcard[$key] == "" and $arr_idcard_key[$key] == "0"){
							$sql_del = "DELETE FROM  tbl_assign_edit_key WHERE ticketid='$ticketid' AND idcard='$key'";
							//echo "$sql_del<br>";
							mysql_db_query($dbnameuse,$sql_del) or die(mysql_error()."$sql_del<br>LINE::".__LINE__);
							SaveLogDelete($ticketid,$key,$val); // เก็บ log การลบข้อมูล
					}
					
			}// end foreach($arr_idcard_temp as $key => $val){
				echo "<script>alert('บันทึกรายการเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=view_ticketid&mode=&staffid=$staffid';</script>";	
		exit();	
		}// end if(count($arr_idcard_temp) > 0){
			
	}// end 	if($action == "SavePersonEdit"){
	
}//end if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	
#####################################  ลบใบงาน ###########################
if($_SERVER['REQUEST_METHOD'] == "GET"){
	if($action == "DelTicket"){
		if(CountTicketKey($ticketid) > 0){
			echo "<script>alert('ไม่สามารถลบใบงานได้เนื่องจากมีข้อมูลบุคลากรในใบงานแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=view_ticketid&mode=&staffid=$staffid';</script>";	
		exit();	
		}else{
				$sql_del = "DELETE FROM tbl_assign_edit_sub WHERE ticketid='$ticketid'";
				mysql_db_query($dbnameuse,$sql_del) or die(mysql_error()."$sql_del<br>LINE::".__LINE__);
				echo "<script>alert('ลบรายกรเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=view_ticketid&mode=&staffid=$staffid';</script>";	
		exit();	
		}// end if(CountTicketDetail($ticketid) > 0){
			
	}// end 	if($action == "DelTicket"){
		
	#########  ลบข้อมูลบุคลากร
	
	if($action == "DelPerson"){
		$sql_del1 = "DELETE FROM tbl_assign_edit_key WHERE idcard='$idcard' AND siteid='$siteid' AND ticketid='$ticketid'";
		$result_del1 = mysql_db_query($dbnameuse,$sql_del1) or die(mysql_error()."$sql_del1<br>LINE::".__LINE__);
		if($result_del1){
			SaveLogDelete($ticketid,$idcard,$siteid); // เก็บ log การลบข้อมูล
			echo "<script>alert('ลบรายกรเรียบร้อยแล้ว'); if (parent.leftFrame) {parent.leftFrame.location=parent.leftFrame.location;} location.href='assign_list.php?action=view_ticketid&mode=view_detail&staffid=$staffid&ticketid=$ticketid';</script>";	
		exit();	
		}
	}
		
}// end if($_SERVER['REQUEST_METHOD'] == "GET"){



?>

<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript">
function confirmDelete(delUrl) {
//  if (confirm("คุณแน่ใจที่จะลบข้อมูล cmss จริงหรือไม่")) {
//  window.open("Sample.htm",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
    //document.location = delUrl;
	//document.location =  
	window.open(delUrl,null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
 // }
}

function ConfirmListDel(delUrl) {
  if (confirm("คุณแน่ใจที่จะลบข้อมูลใช่หรือไม่?")) {
    document.location = delUrl;
  }
}

</script>

<SCRIPT language=JavaScript>
	
	
	/////////////////////  ajax
	
	
var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}
    
	
function refreshproductList() {
   var mid = document.getElementById("txt_period_master_id").value;
    if(mid == "" ) {
        clearproductList();
        return;
    }
    var url = "ajax_period.php?mid=" + mid;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStateChange;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}
    
function handleStateChange() {
    if(xmlHttp.readyState == 4) {
        if(xmlHttp.status == 200) {
            updateproductList();
        }
    }
}

function updateproductList() {
    clearproductList();
    var pid = document.getElementById("txt_period_id");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
		
		option = document.createElement("option");
		   option.setAttribute("value",0);
           option.appendChild(document.createTextNode("ไม่ระบุ"));
           pid.appendChild(option);


    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");
		  	option = document.createElement("option");
		   option.setAttribute("value",x[1]);
           option.appendChild(document.createTextNode(x[0]));
           pid.appendChild(option);
	}
    }
}

function clearproductList() {
    var pid = document.getElementById("txt_period_id");
    while(pid.childNodes.length > 0) {
              pid.removeChild(pid.childNodes[0]);
    }
}

</script>
<script language="javascript">

	function checkFm(){
		var age1 = document.form_m1.age_g1.value;
		var age2 = document.form_m1.age_g2.value;
		
		
	if(age1 > 0 && age2 > 0){ // ในกรณีค้นหาช่วงอายุราชการ 
		if(age1 > age2){
			alert("อายุราชการสิ้นสุดต้องไม่น้อยกว่าอายุราชการเริ่มต้น");
			document.form_m1.age_g2.focus();
			return false;
		}
	}
return true;		
	}

	function check_number(){
		var num1 = document.form_m1.person_no.value;
	 if (isNaN(num1)) {
      alert("กรุณาระบุเฉพาะตัวเลขเท่านั่น");
      document.form_m1.person_no.focus();
      return false;
      }

		
	}
	

// check from1
function ChF1(){
	if(document.form1.profile_edit_name.value == ""){
			alert("กรุณาระบุชื่อโฟรไฟล์การแก้ไขข้อมูล ก.พ.7");
			document.form1.profile_edit_name.focus();
			return false;
	}	
	if(document.form1.txt_period_master_id.value == ""){
		alert("กรุณาระบุชื่อกลุ่มรายการแก้ไขข้อมูล ก.พ.7");
			document.form1.txt_period_master_id.focus();
			return false;	
	}
	
		if(document.form1.txt_period_id.value == ""){
		alert("กรุณาระบุชื่อกลุ่มรายการย่อยแก้ไขข้อมูล ก.พ.7");
			document.form1.txt_period_id.focus();
			return false;	
	}

	
	
}
	
// check from 2

function CheckD1(){
		if(document.form2.edit_day.value != ""){
				document.getElementById("radio4").checked=true;
		}
	
}
function ChF2(){
		if(document.form2.periodname.value == ""){
			alert("กรุณาระบุชื่อหมวดรายการย่อย");
			document.form2.periodname.focus();
			return false;
		}
		
		
		var d1 = document.form2.start_date.value;
		var d2 = document.form2.end_date.value;
			if(d1 != "" && d2 != ""){
			 p1=d1.split("/");
			 p2=d2.split("/");
			 date1 = p1[2]+""+p1[1]+""+p1[0];
			 date2 = p2[2]+""+p2[1]+""+p2[0];
			 if(date1 > date2){
						alert("วันที่สิ้นสุดต้องไม่น้อยกว่าวันที่เริ่มต้น");
						return false;
			}
		}else if(d1 != "" && d2 == ""){
				alert("กรุณาเลือกวันที่สิ้นสุด");
						return false;
		}else if(d2 != "" && d1 == ""){
			alert("กรุณาเลือกวันที่เริ่มต้น");
						return false;
		}
		
		
		var td1 = document.form2.st1.value+""+document.form2.st2.value+""+document.form2.st3.value;
		var td2 = document.form2.et1.value+""+document.form2.et2.value+""+document.form2.et3.value;
		//alert(td1+" :: "+td2);return false;
		if(td1 != "000000" && td1 != "" && td2 != "000000" && td2 != ""){
				if(td1 > td2){
						alert("เวลาสิ้นสุดต้องไม่น้อยกว่าเวลาเริ่มต้น");
						return false;	
				}
		}else if(td1 != "000000" && td1 != "" && (td2 == "000000" || td2 == "")){
				alert("กรุณาเลือกเวลาสิ้นสุด");
						return false;
		}else if((td1 == "000000" || td1 == "") && td2 != "000000" && td2 != ""){
			alert("กรุณาเลือกเวลาเริ่มต้น");
						return false;
		}
		
		if((document.getElementById("radio3").checked == true) && (document.form2.edit_day.value != "" || d1 != "" || d2 != "" || (td1 != "000000" && td1 != "" ) || (td2 != "000000" && td2 != "" )) ){
				alert("สถานะการแก้ไขข้อมูลต้องเลือกเป็นแก้ไขข้อมูลตามช่วงเวลาที่กำหนดเท่านั้น\nเนื่องจากมีการเลือกวันทำการวันที่และเวลาไว้แล้ว");
				return false;
		}


		if((document.getElementById("radio4").checked == true) && (document.form2.edit_day.value == "" || d1 == "" || d2 == "" || (td1 == "000000" || td1 == "" ) || (td2 == "000000" || td2 == "" )) ){
				alert("สถานะการแก้ไขข้อมูลต้องเลือกเป็นแก้ไขข้อมูลตลอดเวลาเท่านั้น\nเนื่องจากไม่มีการเลือกวันทำการ วันที่หรือเวลาไว้");
				return false;
		}

		
}

function ClearCal1(){
		document.form2.start_date.value=""
}
function ClearCal2(){
		document.form2.end_date.value=""
}
	
	
function ShowTableStaff(){

            document.getElementById("tblstaff").style.display = 'block';
      
}
	
function HiddenTableStaff(){

            document.getElementById("tblstaff").style.display = 'none';
      
}

	
</script>
<style type="text/css">
<!--
.style1 {
	color: #990000;
	font-style: italic;
}
-->
</style>
</head>
<body bgcolor="#EFEFFF">
<?
if($action == "all"){
?>

<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
<?
	if($mode == ""){
?>
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="5" align="left" valign="middle" bgcolor="#A5B2CE"><strong><img src="dtree/img/group_key.png" width="16" height="16" border="0">&nbsp;รายชื่อพนักงานสำหรับแก้ไขข้อมูล ก.พ.7 (กลุ่มเฉพาะกิจ)</strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" valign="middle" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="33%" align="center" valign="middle" bgcolor="#A5B2CE"><strong>ชือพนักงาน</strong></td>
        <td width="34%" align="center" valign="middle" bgcolor="#A5B2CE"><strong>จำนวนใบงาน</strong></td>
        <td width="19%" align="center" valign="middle" bgcolor="#A5B2CE"><strong>กลุ่มการทำงานปัจุบัน</strong></td>
        <td width="10%" align="center" valign="middle" bgcolor="#A5B2CE">&nbsp;</td>
      </tr>
      <?
      	$sql = "SELECT
t3.staffid,
t3.prename,
t3.staffname,
t3.staffsurname,
t2.status_profile,
t3.keyin_group
FROM
tbl_assign_edit_staffkey as  t1
Inner Join tbl_assign_edit_profile as t2 ON t1.profile_edit_id = t2.profile_edit_id
Inner Join keystaff  as t3 ON t1.staffid = t3.staffid
WHERE
t2.status_profile =  '1'
GROUP BY 
t3.staffid
ORDER BY t3.staffname ASC,t3.staffsurname ASC
";
		$result = mysql_db_query($dbnameuse,$sql);
		$i=0;
		$arrg = GetGroupName();//กลุ่มการทำงาน
		while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
			$numticketid = CountTicketStaff($rs[staffid]);
			$fullname = "$rs[prename]$rs[staffname] $rs[staffsurname]";
			
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?  echo "$fullname";?></td>
        <td align="center"><? if($numticketid > 0 ){ echo "<a href='?action=view_ticketid&staffid=$rs[staffid]'>".number_format($numticketid)."</a>";}else{ echo "";}?></td>
        <td align="center"><?=$arrg[$rs[keyin_group]]?></td>
        <td align="center"><a href="?action=AddTicketid&staffid=<?=$rs[staffid]?>"><img src="../../../images_sys/Refreshb1.png" width="20" height="20" border="0" title="คลิ๊กเพื่อมอบหมายงานแก้ไขข้อมูล ก.พ.7"></a></td>
      </tr>
      <?
		}// end 
	  ?>
    </table></td>
  </tr>
  <?
	}//end if($mode == ""){
  ?>
    <tr>
    <td align="center" >&nbsp;</td>
  </tr>

</table>
<?
}//end if($action == "all"){
	

if($action == "view_ticketid"){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?
	if($mode == ""){
?>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" align="left" bgcolor="#A5B2CE"><a href="?action=all"><img src="../../../images_sys/home.gif" width="20" height="20" border="0" title="กลับหน้าหลัก"></a>&nbsp;<strong>รายการใบงานมอบงานแก้ไขของ <?=GetStaffName($staffid)?></strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="25%" align="center" bgcolor="#A5B2CE"><strong>รหัสมอบงาน</strong></td>
        <td width="18%" align="center" bgcolor="#A5B2CE"><strong>วันที่มอบงาน</strong></td>
        <td width="12%" align="center" bgcolor="#A5B2CE"><strong>จำนวนบุคลากรที่<br>
          แก้ไขเสร็จ(คน)</strong></td>
        <td width="16%" align="center" bgcolor="#A5B2CE"><strong>จำนวนบุคลากรที่<br>
          ยังแก้ไขไม่เสร็จ(คน)</strong></td>
        <td width="10%" align="center" bgcolor="#A5B2CE"><strong>จำนวนบุคลากร<br>
          ทั้งหมด(คน)</strong></td>
        <td width="9%" align="center" bgcolor="#A5B2CE"><strong>สถานะการดำเนินการ</strong></td>
        <td width="7%" align="center" bgcolor="#A5B2CE"><input  type="button" name="btnAdd" id="btnAdd1" value="เพิ่มใบงาน" onClick="location.href='?action=AddTicketid&staffid=<?=$staffid?>'"></td>
      </tr>
      <?
      $sql = "SELECT *  FROM  tbl_assign_edit_sub WHERE staffid='$staffid' ORDER BY ticketid DESC";
	  $result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	  $i=0;
	  while($rs = mysql_fetch_assoc($result)){
		  if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
		  $key_app = CountTicketDetail($rs[ticketid]); // จำนวนรายการที่คีย์เสร็จ
		  $key_noapp = CountTicketDetail($rs[ticketid],"N");// จำนวนรายการที่ค้างดำเนินการ
		  $key_all = $key_app+$key_noapp; // จำนวนรายการทั้งหมด
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[ticketid]?></td>
        <td align="center"><?=ShowThaiDate($rs[assign_date])?></td>
        <td align="center"><? if($key_app > 0){ echo "<a href='?action=view_ticketid&mode=view_detail&xtype=Y&ticketid=$rs[ticketid]&staffid=$staffid'>".number_format($key_app)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($key_noapp > 0){ echo "<a href='?action=view_ticketid&mode=view_detail&xtype=N&ticketid=$rs[ticketid]&staffid=$staffid'>".number_format($key_noapp)."</a>";}else{ echo "0";}?></td>
        <td align="center"><? if($key_all > 0){ echo "<a href='?action=view_ticketid&mode=view_detail&xtype=All&ticketid=$rs[ticketid]&staffid=$staffid'>".number_format($key_noapp)."</a>";}else{ echo "0";}?></td>
        <td align="center"><?
        	if($key_noapp > 0){
				 	echo $arrimg_app[0];
			}else{
					echo $arrimg_app[1];
			}
		?></td>
        <td align="center"><a href="?action=EditPerson&ticketid=<?=$rs[ticketid]?>&staffid=<?=$staffid?>"><img src="../../../images_sys/b_edit.png" width="16" height="16" border="0" title="แก้ไขรายการ"></a>&nbsp; <a href="#" onClick="return ConfirmListDel('?action=DelTicket&ticketid=<?=$rs[ticketid]?>&staffid=<?=$staffid?>');"><img src="../../../images_sys/b_drop.png" width="16" height="16" border="0" title="ลบรายการ"></a></td>
      </tr>
      <?
	  }
	  ?>
    </table></td>
  </tr>
  <?
	}//end if($mode == ""){
	if($mode == "view_detail"){
		
		if($xtype == "Y" or $xtype == "N" or $xtype == "All"){
			$flag_view = 0;
			$conspan1 = "5";
				
		}else{
			$flag_view = 1;	
			$conspan1 = "6";
		}
  ?>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="left" bgcolor="#A5B2CE"><a href="?action=view_ticketid&mode=&staffid=<?=$staffid?>"><img src="../../../images_sys/home.gif" width="20" height="20" border="0" title="ย้อนกลับ"></a>&nbsp;<strong>รายละเอียดใบงาน <?=$ticketid?> ของ<?=GetStaffName($staffid);?></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="18%" align="center" bgcolor="#A5B2CE"><strong>เลขบัตรประชาชน</strong></td>
        <td width="20%" align="center" bgcolor="#A5B2CE"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="22%" align="center" bgcolor="#A5B2CE"><strong>ตำแหน่ง</strong></td>
        <td width="29%" align="center" bgcolor="#A5B2CE"><strong>หน่วยงานสังกัด</strong></td>
        <? if($flag_view == "1"){?>
        <td width="7%" align="center" bgcolor="#A5B2CE"><input  type="button" name="btnAdd" id="btnAdd1" value="เพิ่มบุคลากร" onClick="location.href='?action=AddPerson&staffid=<?=$staffid?>&ticketid=<?=$ticketid?>'"></td>
        <?
		}//end  if($flag_view == "1"){?
		?>
      </tr>
      <?
	  	if($xtype == "Y"){
			 	 $conv1 = " AND t1.userkey_wait_approve='1'";
		}else if($xtype == "N"){
				$conv1 = " AND t1.userkey_wait_approve <>'1'";
		}else{
				$conv1 = "";	
		}
	  
      	$sqlview = "SELECT
t1.ticketid,
t1.idcard,
t1.fullname,
t1.siteid,
t1.userkey_wait_approve,
t2.schoolid,
t2.schoolname,
t2.position_now,
t3.secname
FROM ".DB_USERENTRY.".tbl_assign_edit_key t1
Left Join  ".DB_MASTER.".view_general t2 ON t1.idcard =t2.CZ_ID
Inner Join  ".DB_MASTER.".eduarea t3 ON t2.siteid = t3.secid
WHERE t1.ticketid='$ticketid' $conv1
ORDER BY t2.name_th ASC,t3.secname ASC,t2.schoolname ASC";
$result = mysql_db_query($dbnameuse,$sqlview) or die(mysql_error()."$sqlview<br>LINE::".__LINE__);
$i=0;
while($rs = mysql_fetch_assoc($result)){
	  if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
	  $orgname = str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[secname])."/".$rs[schoolname];
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[fullname]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="left"><? echo "$orgname";?></td>
         <? if($flag_view == "1"){?>
        <td align="center">&nbsp;<a href="#" onClick="return ConfirmListDel('?action=DelPerson&ticketid=<?=$ticketid?>&staffid=<?=$staffid?>&idcard=<?=$rs[idcard]?>&siteid=<?=$rs[siteid]?>');"><img src="../../../images_sys/b_drop.png" width="16" height="16" border="0" title="ลบรายการ"></a></td>
        <?
		 }//end if($flag_view == "1"){
		?>
      </tr>
      <?
}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
  <?
	}//end 
  ?>
</table>
<?
}//end if($action == "view_ticketid"){
	
##########################################################  เพิ่มใบงานมอบหมายงานแก้ไข ################################################################
if($action == "AddTicketid"){
	$xlimit = " LIMIT ".($d_numkey*$d_week);
	
	
	
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td align="left"><a href="?action=view_ticketid&mode=&staffid=<?=$staffid?>"><img src="../../../images_sys/home.gif" width="20" height="20" border="0" title="ย้อนกลับ"></a>&nbsp;<strong>ใบงานการแก้ไขข้อมูล ก.พ.7 ของ 
              <?=GetStaffName($staffid);?>
            </strong></td>
          </tr>
          <tr>
            <td align="left"><strong>จำนวนบุคลากรที่ค้างดำเนินการแก้ไขทั้งหมด  <? //$arrdif = CountReqAll(); echo array_sum($arrdif);?></strong></td>
          </tr>
          <tr>
            <td align="left"><strong>จำนวนค่าเฉลี่ยที่แก้ได้ต่อวันคือ <?=$d_numkey?> ชุด  ใบงานต่อ 1 สัปดาห์ คือ <?=$d_week?> วัน = <? echo "$d_numkey คูณ $d_week เท่ากับ ".number_format($d_numkey*$d_week);?> ชุดต่อสัปดาห์</strong></td>
          </tr>
           <form name="form4" method="post" action="">
          <tr>
            <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="9%" align="right"><strong>เลือก สพท.</strong></td>
                <td width="26%" align="left">
                  <select name="sel_siteid" id="sel_siteid">
                  <option value="">เลือกทั้งหมด</option>
                 <?
                 	$sql_site = "SELECT secid,secname, if(substring(secid,1,1) ='0',cast(secid as SIGNED),9999) as idsite FROM eduarea WHERE secid NOT LIKE '99%' ORDER  BY idsite, secname  ASC";
					$result_site = mysql_db_query($dbnamemaster,$sql_site) or die(mysql_error()."$sql_site<br>LINE__".__LINE__);
					while($rs_s = mysql_fetch_assoc($result_site)){
						if($rs_s[secid] == $sel_siteid){ $sel = " SELECTED='SELECTED'";}else{ $sel = "";}
							echo "<option value='$rs_s[secid]' $sel>".str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs_s[secname])."</option>";
					}// end while($rs_s = mysql_fetch_assoc($result_site)){
				 ?>
                  </select>
                  </td>
                <td width="65%">
                <input type="submit" name="button4" id="button4" value="ค้นหาข้อมูล">
                <input type="hidden" name="xsearch" id="btn5" value="1">
                <input type="hidden" name="staffid" value="<?=$staffid?>">
                <input type="hidden" name="action" value="AddTicketid">
                 </td>
              </tr>
            </table></td>
          </tr>
          </form>
        </table></td>
        </tr>
        <form name="form1" method="post" action="">
      <tr>
        <td width="4%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="18%" align="center" bgcolor="#A5B2CE"><strong>เลขบัตรประชาชน</strong></td>
        <td width="21%" align="center" bgcolor="#A5B2CE"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="21%" align="center" bgcolor="#A5B2CE"><strong>ตำแหน่ง</strong></td>
        <td width="23%" align="center" bgcolor="#A5B2CE"><strong>หน่วยงานสังกัด</strong></td>
        <td width="13%" align="center" bgcolor="#A5B2CE"><strong>
        <?
        		if($xsearch == "1" ){
		?>
          <input type="submit" name="button" id="button" value="บันทึกสร้างใบงาน">
          <input type="hidden" name="action" value="SaveTicket">
          <input type="hidden" name="staffid" value="<?=$staffid?>">
         <?
				}//end if($xsearch == "1"){
		 ?>
        </strong></td>
      </tr>
      <?
	if($xsearch == "1"){
	  if($sel_siteid != ""){
			 $consite = " AND t3.siteid='$sel_siteid'";	 
	}else{
			$consite = "";	
	}
	  
      	$sql = "SELECT
t1.runid,
t2.idcard,
t3.siteid,
t3.prename_th,
t3.name_th,
t3.surname_th,
t3.position_now,
t3.schoolname
FROM
req_temp_wrongdata as t1
Inner Join req_problem_person as t2 ON t1.req_person_id = t2.req_person_id
Inner Join view_general as t3 ON t2.idcard = t3.CZ_ID
Left Join ".DB_USERENTRY.".tbl_assign_edit_key as t4 ON t3.CZ_ID=t4.idcard  AND t3.siteid=t4.siteid
WHERE
t1.problem_type =  '1' 
AND t1.status_req_approve='1'
AND t4.idcard IS NULL
$consite
GROUP BY
t2.idcard $xlimit";
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE___".__LINE__);
	$numr1 = mysql_num_rows($result);
	if($numr1 > 0){
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
	  if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="center"> <? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
        <td align="center"><? echo "$rs[position_now]";?></td>
        <td align="center"><? echo GetArea($rs[siteid])."/".$rs[schoolname];?></td>
        <td align="center">
        <input type="checkbox" name="arr_idcard[<?=$rs[idcard]?>]" id="arrid<?=$i?>" value="<?=$rs[siteid]?>" checked>
        <input type="hidden" name="arr_fullname[<?=$rs[idcard]?>]" id="fullname<?=$i?>" value="<? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?>">
        
          </td>
      </tr>
      
      <?
	}//end	while(){ 
	}else{
		echo "<tr bgcolor=\"#F0F0F0\"><td colspan='6' align='center'><b> - ไม่พบข้อมูลคำร้อง -</b></td></tr>";	
	}//end if($numr1 > 0){
	}//end if($xsearch == "1"){
	  ?>
  </form>
    </table></td>
  </tr>

</table>

<?
	
}//end if($action == "AddTicketid"){

	if($action == "AddPerson"){
?>
<form name="form2" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
	<td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
	  <tr>
	    <td colspan="6" align="left" bgcolor="#A5B2CE"><a href="?action=view_detail&mode=&staffid=<?=$staffid?>&ticketid=<?=$ticketid?>"><img src="../../../images_sys/home.gif" width="20" height="20" border="0" title="ย้อนกลับ"></a>&nbsp;<strong>เพิ่มข้อมูลบุคลากรสำหรับใบงานแก้ไขข้อมูล ก.พ.7&nbsp;<?=$ticketid?> ของ  <?=GetStaffName($staffid);?> </strong></td>
	    </tr>
	  <tr>
	    <td width="6%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
	    <td width="16%" align="center" bgcolor="#A5B2CE"><strong>เลขบัตรประชาชน</strong></td>
	    <td width="20%" align="center" bgcolor="#A5B2CE"><strong>ชื่อ - นามสกุล</strong></td>
	    <td width="20%" align="center" bgcolor="#A5B2CE"><strong>ตำแหน่ง</strong></td>
	    <td width="25%" align="center" bgcolor="#A5B2CE"><strong>หน่วยงานสังกัด</strong></td>
	    <td width="13%" align="center" bgcolor="#A5B2CE"><strong>
	      <input type="submit" name="button2" id="button2" value="บันทึกเพิ่มบุคลากร">
          <input type="hidden" name="ticketid" value="<?=$ticketid?>">
          <input type="hidden" name="staffid" value="<?=$staffid?>">
          <input type="hidden" name="action" value="SavePerson">
	    </strong></td>
	    </tr>
        <?
        	$sql = "SELECT
t1.runid,
t2.idcard,
t3.siteid,
t3.prename_th,
t3.name_th,
t3.surname_th,
t3.position_now,
t3.schoolname
FROM
req_temp_wrongdata as t1
Inner Join req_problem_person as t2 ON t1.req_person_id = t2.req_person_id
Inner Join view_general as t3 ON t2.idcard = t3.CZ_ID
Left Join ".DB_USERENTRY.".tbl_assign_edit_key as t4 ON t3.CZ_ID=t4.idcard  AND t3.siteid=t4.siteid
WHERE
t1.problem_type =  '1' 
#AND t1.status_assign =  '0'
AND t1.status_req_approve='1'
#AND t1.status_permit='NO'
AND t4.idcard IS NULL
GROUP BY
t2.idcard $limit_defilt";
$result = mysql_db_query($dbnameuse,$sql);
$i=0;
while($rs = mysql_fetch_assoc($result)){
	  if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
		?>
	  <tr bgcolor="<?=$bg?>">
	    <td align="center"><?=$i?></td>
	    <td align="center"><?=$rs[idcard]?></td>
	    <td align="left"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
	    <td align="left"><? echo "$rs[position_now]";?></td>
	     <td align="center"><? echo GetArea($rs[siteid])."/".$rs[schoolname];?></td>
	    <td align="center"> <input type="checkbox" name="arr_idcard[<?=$rs[idcard]?>]" id="xarrid<?=$i?>" value="<?=$rs[siteid]?>">
	      <input type="hidden" name="arr_fullname[<?=$rs[idcard]?>]" value="<? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?>">
          
          </td>
	    </tr>
        <?
}//end while($rs = mysql_fetch_assoc($result)){
		?>
	  </table></td>
  </tr>
</table>
</form>
<?
	}//end 	if($action == "AddPerson"){
	
	if($action == "EditPerson"){
?>
<form action="" method="post" name="form3">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="6" align="left" bgcolor="#A5B2CE"><a href="?action=view_ticketid&mode=&staffid=<?=$staffid?>"><img src="../../../images_sys/home.gif" width="20" height="20" border="0" title="ย้อนกลับ"></a>&nbsp;<strong>รายการแก้ไขใบงานแก้ไขข้อมูล ก.พ.7 &nbsp;<?=$ticketid?> ของ  <?=GetStaffName($staffid);?></strong></td>
          </tr>
        <tr>
          <td width="6%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
          <td width="17%" align="center" bgcolor="#A5B2CE"><strong>เลขบัตรประชาชน</strong></td>
          <td width="19%" align="center" bgcolor="#A5B2CE"><strong>ชื่อ - นามสกุล</strong></td>
          <td width="22%" align="center" bgcolor="#A5B2CE"><strong>ตำแหน่ง</strong></td>
          <td width="24%" align="center" bgcolor="#A5B2CE"><strong>หน่วยงานสังกัด</strong></td>
          <td width="12%" align="center" bgcolor="#A5B2CE">
          <input type="submit" name="button3" id="button3" value="บันทึกแก้ไขรายการ">
          <input type="hidden" name="action" value="SavePersonEdit">
          <input type="hidden" name="staffid" value="<?=$staffid?>">
          <input type="hidden" name="ticketid" value="<?=$ticketid?>">
          </td>
        </tr>
        <?
        	$sql = "SELECT
t1.ticketid,
t1.idcard,
t1.fullname,
t1.siteid,
t1.userkey_wait_approve,
t2.schoolid,
t2.schoolname,
t2.position_now,
t3.secname
FROM ".DB_USERENTRY.".tbl_assign_edit_key t1
Left Join  ".DB_MASTER.".view_general t2 ON t1.idcard =t2.CZ_ID
Inner Join  ".DB_MASTER.".eduarea t3 ON t2.siteid = t3.secid
WHERE t1.ticketid='$ticketid' 
ORDER BY t2.name_th ASC,t3.secname ASC,t2.schoolname ASC";
$result = mysql_db_query($dbnameuse,$sql);
$i=0;
$arr_check_key = CheckEditKey($ticketid);
while($rs = mysql_fetch_assoc($result)){
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";	}
  $orgname = str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[secname])."/".$rs[schoolname];
  if($arr_check_key[$rs[idcard]] == "1"){
		 	 $ch_dis = " disabled ";
			 $txt_k = "<font color=\"#00CC00\">ดำเนินการแล้ว</font>";
			 $flag_idcard = 1;
	}else{
			$ch_dis = "";	
			$txt_k = "";
			 $flag_idcard = 0;
	}//=$ch_dis
		?>
        <tr bgcolor="<?=$bg?>">
          	<td align="center"><?=$i?></td>
        	<td align="center"><?=$rs[idcard]?></td>
       	 	<td align="left"><? echo "$rs[fullname]";?></td>
        	<td align="left"><? echo "$rs[position_now]";?></td>
        	<td align="left"><? echo "$orgname";?></td>
          <td align="center">
          <input  type="checkbox"  name="arr_idcard[<?=$rs[idcard]?>]" id="xarrid<?=$i?>" value="<?=$rs[siteid]?>"  checked  <?=$ch_dis?>><?=$txt_k?>
          <input type="hidden" name="arr_idcard_temp[<?=$rs[idcard]?>]" value="<?=$rs[siteid]?>">
          <input type="hidden" name="arr_idcard_key[<?=$rs[idcard]?>]" value="<?=$flag_idcard?>">
          <input type="hidden" name="arr_fullname[<?=$rs[idcard]?>]" value="<?=$rs[fullname]?>">
            </td>
        </tr>
        <?
	}//end while($rs = mysql_fetch_assoc($result)){
		?>
      </table></td>
    </tr>
  </table>
</form>
<?
	}//end 	if($action == "EditPerson"){
?>
</BODY>
</HTML>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
