
<html>
<head>
<title>มอบหมายการบันทึกข้อมูล ก.พ.7 ให้กับผู้ใช้</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
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

function confirmDelete1(delUrl) {
  if (confirm("คุณแน่ใจที่จะลบข้อมูลใช่หรือไม่?")) {
  //window.open("Sample.htm",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
    document.location = delUrl;
  }
}

</script>

<SCRIPT language=JavaScript>
function checkFields() {
	missinginfo1 = "";
	missinginfo = "";
	if (document.form1.staffname.value == "")  {	missinginfo1 += "\n- ช่องชื่อ ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.staffsurname.value == "")  {	missinginfo1 += "\n- ช่องนามสกุล ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.engname.value == "")  {	missinginfo1 += "\n- ช่องชื่อ(อังกฤษ) ไม่สามารถเป็นค่าว่าง"; }		
	if (document.form1.engsurname.value == "")  {	missinginfo1 += "\n- ช่องนามสกุล(อังกฤษ) ไม่สามารถเป็นค่าว่าง"; }		
	if (missinginfo1 != "") { 
		missinginfo += "ไม่สามารถเพิ่มข้อมูลได้  เนื่องจาก \n";
		missinginfo +="_____________________________\n";
		missinginfo = missinginfo + missinginfo1  ;
		missinginfo += "\n___________________________";
		missinginfo += "\nกรุณาตรวจสอบ อีกครั้ง";
		alert(missinginfo);
		return false;
		}
	}
	
	
	
	
	
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
   var sent_siteid = document.getElementById("sent_siteid").value;
    if(sent_siteid == "" ) {
        clearproductList();
        return;
    }
    var url = "ajax_school.php?sent_siteid=" + sent_siteid;
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
    var schoolid = document.getElementById("schoolid");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
		
			option = document.createElement("option");
		   option.setAttribute("value",0);
           option.appendChild(document.createTextNode("ไม่ระบุ"));
           schoolid.appendChild(option);


    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");
		  	option = document.createElement("option");
		   option.setAttribute("value",x[1]);
           option.appendChild(document.createTextNode(x[0]));
           schoolid.appendChild(option);
	}
    }
}

function clearproductList() {
    var schoolid = document.getElementById("schoolid");
    while(schoolid.childNodes.length > 0) {
              schoolid.removeChild(schoolid.childNodes[0]);
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

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" align="left" bgcolor="#A5B2CE"><b>นางสาวพิมพร หันธนู วันที่ 9 เมษายน  2555  รหัสงาน TK-255504091027310245679&nbsp;ข้อมูลเอกสารส่วนเพิ่ม 
          <strong>ห้องคีย์งานคือ
          เจ้าหน้าที่ตรวจสอบคุณภาพข้อมูล          </strong></b><a href="assign_print.php?ticketid=TK-255504091027310245679" target="_blank"><img src="../../images_sys/print.gif" width="21" height="20" title="คลิ๊กเพื่อปร้ินใบงานมอบหมายงาน ก.พ.7" border="0"></a></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="12%" align="center" bgcolor="#A5B2CE"><strong>รหัสประจำตัวประชาชน</strong></td>
        <td width="13%" align="center" bgcolor="#A5B2CE"><strong>ชื่อ -นามสกุล </strong></td>
        <td width="20%" align="center" bgcolor="#A5B2CE"><strong>โรงเรียน/หน่วยงาน</strong></td>
        <td width="27%" align="center" bgcolor="#A5B2CE"><strong>ตำแหน่ง</strong></td>
        <td width="7%" align="center" bgcolor="#A5B2CE"><strong>อายุราชการ</strong></td>
        <td width="11%" align="center" bgcolor="#A5B2CE"><strong>จำนวนรูป/จำนวนแผ่น</strong></td>
        <td width="7%" align="center" bgcolor="#A5B2CE"><input type="button" name="btnA" value="เพิ่มรายการ" onClick="location.href='assign_list.php?action=assign_key&staffid=11560&TicketId=TK-255504091027310245679&profile_id=9'"></td>
      </tr>
	        <tr bgcolor="#FFFFFF">
        <td align="center">1</td>
        <td align="left">3810100665613</td>
        <td align="left">นายอาทร รอดขวัญ</td>
        <td align="left">วิทยาลัยการอาชีพห้วยยอด/สำนักงานคณะกรรมการการอาชีวศึกษา</td>
        <td align="left">ครู</td>
        <td align="center">3</td>
        <td align="center">1/3</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3810100665613.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ลบรายการ" onClick="return confirmDelete('pupup_delete.php?idcard=3810100665613&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3810100665613')" style="cursor:hand"></td>
      </tr>
	        <tr bgcolor="#F0F0F0">
        <td align="center">2</td>
        <td align="left">3840800007830</td>
        <td align="left">นางกรองกาญจน์ สร้างชู</td>
        <td align="left">วิทยาลัยการอาชีพห้วยยอด/สำนักงานคณะกรรมการการอาชีวศึกษา</td>
        <td align="left">ครู</td>
        <td align="center">4</td>
        <td align="center">1/3</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3840800007830.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ลบรายการ" onClick="return confirmDelete('pupup_delete.php?idcard=3840800007830&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3840800007830')" style="cursor:hand"></td>
      </tr>
	        <tr bgcolor="#FFFFFF">
        <td align="center">3</td>
        <td align="left">3920300121055</td>
        <td align="left">นายวีระชัย ชัยพงศ์วัฒนา</td>
        <td align="left">วิทยาลัยการอาชีพห้วยยอด/สำนักงานคณะกรรมการการอาชีวศึกษา</td>
        <td align="left">ครู</td>
        <td align="center">9</td>
        <td align="center">1/3</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3920300121055.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ลบรายการ" onClick="return confirmDelete('pupup_delete.php?idcard=3920300121055&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3920300121055')" style="cursor:hand"></td>
      </tr>
	        <tr bgcolor="#F0F0F0">
        <td align="center">4</td>
        <td align="left">3920600091810</td>
        <td align="left">นางสาวอภิญญา จันทร์แดง</td>
        <td align="left">วิทยาลัยการอาชีพห้วยยอด/สำนักงานคณะกรรมการการอาชีวศึกษา</td>
        <td align="left">ครู</td>
        <td align="center">16</td>
        <td align="center">3/3</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3920600091810.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ลบรายการ" onClick="return confirmDelete('pupup_delete.php?idcard=3920600091810&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3920600091810')" style="cursor:hand"></td>
      </tr>
	        <tr bgcolor="#FFFFFF">
        <td align="center">5</td>
        <td align="left">3920600441012</td>
        <td align="left">นายสุเทพ ขาวปลอด</td>
        <td align="left">วิทยาลัยการอาชีพห้วยยอด/สำนักงานคณะกรรมการการอาชีวศึกษา</td>
        <td align="left">รองผู้อำนวยการวิทยาลัย</td>
        <td align="center">36</td>
        <td align="center">1/5</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3920600441012.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ลบรายการ" onClick="return confirmDelete('pupup_delete.php?idcard=3920600441012&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3920600441012')" style="cursor:hand"></td>
      </tr>
	        <tr bgcolor="#F0F0F0">
        <td align="center">6</td>
        <td align="left">3920600824124</td>
        <td align="left">นายวิชัย ถิ่นชาญ</td>
        <td align="left">วิทยาลัยการอาชีพห้วยยอด/สำนักงานคณะกรรมการการอาชีวศึกษา</td>
        <td align="left">ครู</td>
        <td align="center">18</td>
        <td align="center">1/4</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3920600824124.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ลบรายการ" onClick="return confirmDelete('pupup_delete.php?idcard=3920600824124&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3920600824124')" style="cursor:hand"></td>
      </tr>
	        <tr bgcolor="#FFFFFF">
        <td align="center">7</td>
        <td align="left">3939900190153</td>
        <td align="left">นายนันทชัย เหลียวพัฒนพงศ์</td>
        <td align="left">วิทยาลัยการอาชีพห้วยยอด/สำนักงานคณะกรรมการการอาชีวศึกษา</td>
        <td align="left">รองผู้อำนวยการวิทยาลัย</td>
        <td align="center">33</td>
        <td align="center">1/5</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3939900190153.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ลบรายการ" onClick="return confirmDelete('pupup_delete.php?idcard=3939900190153&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3939900190153')" style="cursor:hand"></td>
      </tr>
	        <tr bgcolor="#F0F0F0">
        <td align="center">8</td>
        <td align="left">3941000313332</td>
        <td align="left">นางมาเรียม เจะมะ</td>
        <td align="left">วิทยาลัยการอาชีพห้วยยอด/สำนักงานคณะกรรมการการอาชีวศึกษา</td>
        <td align="left">ครู</td>
        <td align="center">3</td>
        <td align="center">1/3</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3941000313332.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ลบรายการ" onClick="return confirmDelete('pupup_delete.php?idcard=3941000313332&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3941000313332')" style="cursor:hand"></td>
      </tr>
	        <tr bgcolor="#FFFFFF">
        <td align="center">9</td>
        <td align="left">3969900126706</td>
        <td align="left">นางสุภาพร หลงละเลิง</td>
        <td align="left">วิทยาลัยการอาชีพห้วยยอด/สำนักงานคณะกรรมการการอาชีวศึกษา</td>
        <td align="left">ครู</td>
        <td align="center">4</td>
        <td align="center">1/3</td>
        <td align="center"><a href="../../../edubkk_kp7file/9999/3969900126706.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a>&nbsp; <img src="images/b_drop.png" border="0" alt="ลบรายการ" onClick="return confirmDelete('pupup_delete.php?idcard=3969900126706&ticketid=TK-255504091027310245679&staffid=11560&idcard_assign=3969900126706')" style="cursor:hand"></td>
      </tr>
	      </table></td>
  </tr>
</table>
<script>
	  function alertTxt(id){
	    alert('ถูกเลือกไปแล้ว');
		document.getElementById(id).checked = false;
      }
</script>

</BODY>
</HTML>

