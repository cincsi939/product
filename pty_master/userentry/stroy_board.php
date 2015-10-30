
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
    <td align="center" class="fillcolor">
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td width="17%"  bgcolor="#FFFFFF" align=center style="border-right: solid 1 white;"><A HREF="assign_list.php?action=assign_key&smode=&staffid=11560&TicketId=&profile_id=8"><strong><U style="color:BLACK;">สร้างรายการโดยระบบ</U></strong></A></td>
              <td width="24%"  bgcolor="#000066" align=center style="border-right: solid 1 white;"><A HREF="assign_list.php?action=assign_key&smode=1&staffid=11560&TicketId=&profile_id=8"><strong><U style="color:white;"> สร้างใบจ่ายงานย้อนหลัง</U></strong></A></td>
              <td width="28%" bgcolor="#000066" align="center" style="border-right:solid 1 white;"><a href="assign_list.php?action=assign_key&smode=extraW&staffid=11560&TicketId=&profile_id=8"><strong><U style="color:white;"> สร้างใบงานรายสัปดาห์</U></strong></a></td>
			<!-- <td width="34%"  bgcolor="#000066" align=center style="border-right: solid 1 white;"><A HREF="assign_list.php?action=assign_key&smode=2&staffid=11560&TicketId="><strong><U style="color:white;"> ระบเงื่อนไขขั้นสูง</U></strong></A></td>-->
			 <td width="31%">&nbsp;</td>
            </tr>
      </table>	</td>
  </tr>
  
   
  
      <form name="form_m1" method="post" action="" onSubmit="return checkFm();">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td colspan="4" align="left" bgcolor="#FFFFFF"><strong>ฟอร์มบันทึกการมอบหมายงานของ
            นางสาวพิมพร หันธนู        </strong></td>
        </tr>
      <tr>
        <td width="20%" align="left" bgcolor="#FFFFFF"><strong>อายุราชการ</strong></td>
        <td width="27%" align="left" bgcolor="#FFFFFF"><strong>
          <label>
          <select name="age_g1" id="age_g1" >
		  <option value=""> - ไม่ระบุ - </option>
		  <option value='15' >15</option><option value='16' >16</option><option value='17' >17</option><option value='18' >18</option><option value='19' >19</option><option value='20' >20</option><option value='21' >21</option><option value='22' >22</option><option value='23' >23</option><option value='24' >24</option><option value='25' >25</option><option value='26' >26</option><option value='27' >27</option><option value='28' >28</option><option value='29' >29</option><option value='30' >30</option><option value='31' >31</option><option value='32' >32</option><option value='33' >33</option><option value='34' >34</option><option value='35' >35</option><option value='36' >36</option><option value='37' >37</option><option value='38' >38</option><option value='39' >39</option><option value='40' >40</option><option value='41' >41</option><option value='42' >42</option><option value='43' >43</option><option value='44' >44</option><option value='45' >45</option>          </select>
            </label>
        </strong></td>
        <td width="16%" align="left" bgcolor="#FFFFFF"><strong>ถึง</strong></td>
        <td width="37%" align="left" bgcolor="#FFFFFF"><strong>
          <label>
          <select name="age_g2" id="age_g2" >
		  <option value=""> - ไม่ระบุ -</option>
		  <option value='15' >15</option><option value='16' >16</option><option value='17' >17</option><option value='18' >18</option><option value='19' >19</option><option value='20' >20</option><option value='21' >21</option><option value='22' >22</option><option value='23' >23</option><option value='24' >24</option><option value='25' >25</option><option value='26' >26</option><option value='27' >27</option><option value='28' >28</option><option value='29' >29</option><option value='30' >30</option><option value='31' >31</option><option value='32' >32</option><option value='33' >33</option><option value='34' >34</option><option value='35' >35</option><option value='36' >36</option><option value='37' >37</option><option value='38' >38</option><option value='39' >39</option><option value='40' >40</option><option value='41' >41</option><option value='42' >42</option><option value='43' >43</option><option value='44' >44</option><option value='45' >45</option>          </select>
            </label>
        </strong></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#FFFFFF"><strong>จำนวนคน</strong></td>
        <td align="left" bgcolor="#FFFFFF"><strong>
          <label>
          <input name="person_no" type="text" id="person_no" size="15" value=""  onBlur="return check_number(this);" >
          </label>
        </strong></td>
        <td align="left" bgcolor="#FFFFFF"><strong>เขตพื้นที่การศึกษา</strong></td>
        <td align="left" bgcolor="#FFFFFF">
		
		<select name="sent_siteid" id="sent_siteid" onChange="refreshproductList();">
                        <option value=""> - เลือกเขตพื้นที่การศึกษา - </option>
            <option value='7101' >สพท.ประถมศึกษากาญจนบุรี เขต 1</option><option value='7102' >สพท.ประถมศึกษากาญจนบุรี เขต 2</option><option value='7103' >สพท.ประถมศึกษากาญจนบุรี เขต 3</option><option value='4001' >สพท.ประถมศึกษาขอนแก่น เขต 1</option><option value='4005' >สพท.ประถมศึกษาขอนแก่น เขต 5</option><option value='1801' >สพท.ประถมศึกษาชัยนาท</option><option value='8602' >สพท.ประถมศึกษาชุมพร เขต 2</option><option value='5701' >สพท.ประถมศึกษาเชียงราย เขต 1</option><option value='5704' >สพท.ประถมศึกษาเชียงราย เขต 4</option><option value='5001' >สพท.ประถมศึกษาเชียงใหม่ เขต 1</option><option value='5002' >สพท.ประถมศึกษาเชียงใหม่ เขต 2</option><option value='5003' >สพท.ประถมศึกษาเชียงใหม่ เขต 3</option><option value='5004' >สพท.ประถมศึกษาเชียงใหม่ เขต 4</option><option value='5005' >สพท.ประถมศึกษาเชียงใหม่ เขต 5</option><option value='5006' >สพท.ประถมศึกษาเชียงใหม่ เขต 6</option><option value='6301' >สพท.ประถมศึกษาตาก เขต 1</option><option value='6302' >สพท.ประถมศึกษาตาก เขต 2</option><option value='7301' >สพท.ประถมศึกษานครปฐม เขต 1</option><option value='7302' >สพท.ประถมศึกษานครปฐม เขต 2</option><option value='4802' >สพท.ประถมศึกษานครพนม เขต 2</option><option value='6002' >สพท.ประถมศึกษานครสวรรค์ เขต 2</option><option value='5501' >สพท.ประถมศึกษาน่าน เขต 1</option><option value='3801' >สพท.ประถมศึกษาบึงกาฬ</option><option value='7702' >สพท.ประถมศึกษาประจวบคีรีขันธ์ เขต 2</option><option value='5601' >สพท.ประถมศึกษาพะเยา เขต 1</option><option value='6601' >สพท.ประถมศึกษาพิจิตร เขต 1</option><option value='6502' >สพท.ประถมศึกษาพิษณุโลก เขต 2</option><option value='6701' >สพท.ประถมศึกษาเพชรบูรณ์ เขต 1</option><option value='6702' >สพท.ประถมศึกษาเพชรบูรณ์ เขต 2</option><option value='4403' >สพท.ประถมศึกษามหาสารคาม เขต 3</option><option value='2101' >สพท.ประถมศึกษาระยอง เขต 1</option><option value='5201' >สพท.ประถมศึกษาลำปาง เขต 1</option><option value='5202' >สพท.ประถมศึกษาลำปาง เขต 2</option><option value='5101' >สพท.ประถมศึกษาลำพูน เขต 1</option><option value='5102' >สพท.ประถมศึกษาลำพูน เขต 2</option><option value='3301' >สพท.ประถมศึกษาศรีสะเกษ เขต 1</option><option value='3302' >สพท.ประถมศึกษาศรีสะเกษ เขต 2</option><option value='3303' >สพท.ประถมศึกษาศรีสะเกษ เขต 3</option><option value='3304' >สพท.ประถมศึกษาศรีสะเกษ เขต 4</option><option value='6402' >สพท.ประถมศึกษาสุโขทัย เขต 2</option><option value='7203' >สพท.ประถมศึกษาสุพรรณบุรี เขต 3</option><option value='8401' >สพท.ประถมศึกษาสุราษฎร์ธานี เขต 1</option><option value='4101' >สพท.ประถมศึกษาอุดรธานี เขต 1</option><option value='4102' >สพท.ประถมศึกษาอุดรธานี เขต 2</option><option value='5301' >สพท.ประถมศึกษาอุตรดิตถ์ เขต 1</option><option value='6102' >สพท.ประถมศึกษาอุทัยธานี เขต 2</option><option value='3404' >สพท.ประถมศึกษาอุบลราชธานี เขต 4</option><option value='3405' >สพท.ประถมศึกษาอุบลราชธานี เขต 5</option>          </select>		</td>
      </tr>
      <tr>
        <td colspan="4" align="center" bgcolor="#FFFFFF"><span class="style1">หมายเหตุ* ถ้าท่านไม่เลือกช่วงอายุราชการระบบจะทำการค้นหาบุคลาการที่มีอายุราชการตั้งแต่ 15 ปีขึ้นไป </span></td>
      </tr>
      <tr>
        <td colspan="4" align="center" bgcolor="#FFFFFF"><label>
        <input type="hidden" name="profile_id" value="8">
		<input type="hidden" name="xsearch" value="search1">
          <input type="submit" name="Submit3" value="ค้นหา" >
        </label></td>
        </tr>
    </table></td>
  </tr>
  </form>
 	  
    </table>
	
	</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
      <form name="form5" method="post" action="">
  <tr><td align="center" bgcolor="#000000">
  <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr>
          <td colspan="8" align="center" bgcolor="#A3B2CC"><table width="100%" border="0" cellspacing="0" cellpadding="3">
		              <tr>
              <td width="18%" align="left"><strong>สถานที่คีย์ข้อมูล</strong></td>
              <td width="82%" align="left"><label><input name="localtion_key" type="radio" value="IN" checked='checked' >
              บันทึกข้อมูลข้างในบริษัท
                <input name="localtion_key" type="radio" value="OUT" >
                คีย์ข้อมูลข้างนอกบริษัท
                </label></td>
            </tr>
				            <tr>
              <td align="left"><strong>&nbsp;ห้องคีย์งานคือซาลาเปา</strong></td>
              <td align="left"><INPUT name="c_date" onFocus="blur();" value="23/04/2555" size="10" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form5.c_date, 'dd/mm/yyyy')"value="วันเดือนปี">			</td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td width="6%" align="center" bgcolor="#A3B2CC"><strong>เลือกรายการ</strong></td>
          <td width="12%" align="center" bgcolor="#A3B2CC"><strong>รหัสประจำตัวประชาชน</strong></td>
          <td width="12%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ - นามสกุล </strong></td>
          <td width="35%" align="center" bgcolor="#A3B2CC"><strong>หน่วยงานสังกัด</strong></td>
          <td width="15%" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
          <td width="6%" align="center" bgcolor="#A3B2CC"><strong>อายุราชการ</strong></td>
          <td width="9%" align="center" bgcolor="#A3B2CC"><strong>จำนวนรูป/จำนวนแผ่น</strong></td>
          <td width="5%" align="center" bgcolor="#A3B2CC"><strong>PDF</strong></td>
          </tr>
		         <tr bgcolor="#FFFFFF">
          <td align="center" bgcolor="#FF9900">1<input type="checkbox" name="xidcard[3100100714742]" value="3100100714742" checked="checked" > 
            <input type="hidden" name="xsiteid[3100100714742]" value="1801">
             <input type="hidden" name="xstatus_file[3100100714742]" value="1">            </td>
          <td align="center" bgcolor="#FF9900">3100100714742</td>
          <td align="left" bgcolor="#FF9900">นางจงจิตต์  ฟักนุช <input type="hidden" name="fullname[3100100714742]" value="นางจงจิตต์  ฟักนุช "></td>
          <td align="left" bgcolor="#FF9900">สพป.เชียงใหม่เขต 1/โรงเรียนท่าศาลา</td>
          <td align="left" bgcolor="#FF9900">ผู้อำนวยการสถานศึกษา</td>
          <td align="center" bgcolor="#FF9900">24</td>
          <td align="center" bgcolor="#FF9900">3/8</td>
          <td align="center" bgcolor="#FF9900"><a href="../../../edubkk_kp7file/1801/3100100714742.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center" bgcolor="#FF9900">2<input type="checkbox" name="xidcard[3100100714769]" value="3100100714769" checked="checked" > 
            <input type="hidden" name="xsiteid[3100100714769]" value="1801">
             <input type="hidden" name="xstatus_file[3100100714769]" value="1">            </td>
          <td align="center" bgcolor="#FF9900">3100100714769</td>
          <td align="left" bgcolor="#FF9900">นายสมาน  ฟักนุช <input type="hidden" name="fullname[3100100714769]" value="นายสมาน  ฟักนุช "></td>
          <td align="left" bgcolor="#FF9900">สพป.เชียงใหม่เขต 1/สพป.เชียงใหม่เขต 1</td>
          <td align="left" bgcolor="#FF9900">เจ้าหน้าที่วิเคราะห์นโยบายและแผน</td>
          <td align="center" bgcolor="#FF9900">24</td>
          <td align="center" bgcolor="#FF9900">2/7</td>
          <td align="center" bgcolor="#FF9900"><a href="../../../edubkk_kp7file/1801/3100100714769.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center" bgcolor="#FF9900">3<input type="checkbox" name="xidcard[3100200898641]" value="3100200898641" checked="checked" > 
            <input type="hidden" name="xsiteid[3100200898641]" value="1801">
             <input type="hidden" name="xstatus_file[3100200898641]" value="1">            </td>
          <td align="center" bgcolor="#FF9900">3100200898641</td>
          <td align="left" bgcolor="#FF9900">นายธวัทชัย  ฉิมกรด <input type="hidden" name="fullname[3100200898641]" value="นายธวัทชัย  ฉิมกรด "></td>
          <td align="left" bgcolor="#FF9900">สพป.เชียงใหม่เขต 1/โรงเรียนวัดหนองป่าครั่ง</td>
          <td align="left" bgcolor="#FF9900">ผู้อำนวยการสถานศึกษา</td>
          <td align="center" bgcolor="#FF9900">29</td>
          <td align="center" bgcolor="#FF9900">2/6</td>
          <td align="center" bgcolor="#FF9900"><a href="../../../edubkk_kp7file/1801/3100200898641.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center">4<input type="checkbox" name="xidcard[3100202201027]" value="3100202201027" checked="checked" > 
            <input type="hidden" name="xsiteid[3100202201027]" value="1801">
             <input type="hidden" name="xstatus_file[3100202201027]" value="1">            </td>
          <td align="center">3100202201027</td>
          <td align="left">นางกอบทิพย์  สิงห์ดำรงค์ <input type="hidden" name="fullname[3100202201027]" value="นางกอบทิพย์  สิงห์ดำรงค์ "></td>
          <td align="left">สพป.เชียงใหม่เขต 1/โรงเรียนวัดดอนจั่น</td>
          <td align="left">ครู</td>
          <td align="center">24</td>
          <td align="center">2/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100202201027.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center">5<input type="checkbox" name="xidcard[3100202694759]" value="3100202694759" checked="checked" > 
            <input type="hidden" name="xsiteid[3100202694759]" value="1801">
             <input type="hidden" name="xstatus_file[3100202694759]" value="1">            </td>
          <td align="center">3100202694759</td>
          <td align="left">นายจารึก  ขำเอี่ยม <input type="hidden" name="fullname[3100202694759]" value="นายจารึก  ขำเอี่ยม "></td>
          <td align="left">สพป.เชียงใหม่เขต 1/โรงเรียนวัดหนองป่าครั่ง</td>
          <td align="left">ครู</td>
          <td align="center">31</td>
          <td align="center">2/7</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100202694759.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center" bgcolor="#FFFFFF">6<input type="checkbox" name="xidcard[3100400867056]" value="3100400867056" checked="checked" > 
            <input type="hidden" name="xsiteid[3100400867056]" value="1801">
             <input type="hidden" name="xstatus_file[3100400867056]" value="1">            </td>
          <td align="center" bgcolor="#FFFFFF">3100400867056</td>
          <td align="left" bgcolor="#FFFFFF">นางอุไร  ประกอบกิจวิริยะ <input type="hidden" name="fullname[3100400867056]" value="นางอุไร  ประกอบกิจวิริยะ "></td>
          <td align="left" bgcolor="#FFFFFF">สพป.เชียงใหม่เขต 1/โรงเรียนวัดหนองป่าครั่ง</td>
          <td align="left" bgcolor="#FFFFFF">ครู</td>
          <td align="center" bgcolor="#FFFFFF">36</td>
          <td align="center" bgcolor="#FFFFFF">0/8</td>
          <td align="center" bgcolor="#FFFFFF"><a href="../../../edubkk_kp7file/1801/3100400867056.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center">7<input type="checkbox" name="xidcard[3100500696342]" value="3100500696342" checked="checked" > 
            <input type="hidden" name="xsiteid[3100500696342]" value="1801">
             <input type="hidden" name="xstatus_file[3100500696342]" value="1">            </td>
          <td align="center">3100500696342</td>
          <td align="left">นางสมจิตต์  สายตระกูล <input type="hidden" name="fullname[3100500696342]" value="นางสมจิตต์  สายตระกูล "></td>
          <td align="left">สพป.เชียงใหม่เขต 1/โรงเรียนวัดหนองป่าครั่ง</td>
          <td align="left">ครู</td>
          <td align="center">28</td>
          <td align="center">2/7</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100500696342.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center">8<input type="checkbox" name="xidcard[3100502913693]" value="3100502913693" checked="checked" > 
            <input type="hidden" name="xsiteid[3100502913693]" value="1801">
             <input type="hidden" name="xstatus_file[3100502913693]" value="1">            </td>
          <td align="center">3100502913693</td>
          <td align="left">นายบุญส่ง  ทิพย์สิงห์ <input type="hidden" name="fullname[3100502913693]" value="นายบุญส่ง  ทิพย์สิงห์ "></td>
          <td align="left" bgcolor="#FFFFFF">สพป.เชียงใหม่เขต 1/โรงเรียนชุมชนบ้านบวกครกน้อย</td>
          <td align="left">ครู</td>
          <td align="center">34</td>
          <td align="center">1/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100502913693.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center">9<input type="checkbox" name="xidcard[3100600746473]" value="3100600746473" checked="checked" > 
            <input type="hidden" name="xsiteid[3100600746473]" value="1801">
             <input type="hidden" name="xstatus_file[3100600746473]" value="1">            </td>
          <td align="center">3100600746473</td>
          <td align="left">นายศิรินทร์  ธนบริบูรณ์พงศ์ <input type="hidden" name="fullname[3100600746473]" value="นายศิรินทร์  ธนบริบูรณ์พงศ์ "></td>
          <td align="left">สพป.เชียงใหม่เขต 1/โรงเรียนชุมชนบ้านบวกครกน้อย</td>
          <td align="left">ครู</td>
          <td align="center">28</td>
          <td align="center">2/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100600746473.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center">10<input type="checkbox" name="xidcard[3100600821971]" value="3100600821971" checked="checked" > 
            <input type="hidden" name="xsiteid[3100600821971]" value="1801">
             <input type="hidden" name="xstatus_file[3100600821971]" value="1">            </td>
          <td align="center">3100600821971</td>
          <td align="left">นางธัญวรัตน์  พุฒแย้ม <input type="hidden" name="fullname[3100600821971]" value="นางธัญวรัตน์  พุฒแย้ม "></td>
          <td align="left">สพป.เชียงใหม่เขต 1/โรงเรียนชุมชนบ้านบวกครกน้อย</td>
          <td align="left">ครู</td>
          <td align="center">19</td>
          <td align="center">2/7</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100600821971.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center">11<input type="checkbox" name="xidcard[3100601689252]" value="3100601689252" checked="checked" > 
            <input type="hidden" name="xsiteid[3100601689252]" value="1801">
             <input type="hidden" name="xstatus_file[3100601689252]" value="1">            </td>
          <td align="center">3100601689252</td>
          <td align="left">นางสาวรัชนีวรรณ  สุมาลี <input type="hidden" name="fullname[3100601689252]" value="นางสาวรัชนีวรรณ  สุมาลี "></td>
          <td align="left">สพป.เชียงใหม่เขต 1/โรงเรียนชุมชนบ้านบวกครกน้อย</td>
          <td align="left">ครู</td>
          <td align="center">27</td>
          <td align="center">3/7</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100601689252.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center">12<input type="checkbox" name="xidcard[3100601697999]" value="3100601697999" checked="checked" > 
            <input type="hidden" name="xsiteid[3100601697999]" value="1801">
             <input type="hidden" name="xstatus_file[3100601697999]" value="1">            </td>
          <td align="center">3100601697999</td>
          <td align="left">นางรัตนา  พิมพ์แก้ว <input type="hidden" name="fullname[3100601697999]" value="นางรัตนา  พิมพ์แก้ว "></td>
          <td align="left" bgcolor="#FFFFFF">สพป.เชียงใหม่เขต 1/โรงเรียนชุมชนบ้านบวกครกน้อย</td>
          <td align="left">ครู</td>
          <td align="center">25</td>
          <td align="center">2/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100601697999.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center">13<input type="checkbox" name="xidcard[3100602259472]" value="3100602259472" checked="checked" > 
            <input type="hidden" name="xsiteid[3100602259472]" value="1801">
             <input type="hidden" name="xstatus_file[3100602259472]" value="1">            </td>
          <td align="center">3100602259472</td>
          <td align="left">นางชนิตา  อินทร์เรือง <input type="hidden" name="fullname[3100602259472]" value="นางชนิตา  อินทร์เรือง "></td>
          <td align="left">สพป.เชียงใหม่เขต 1/โรงเรียนวัดเสาหิน</td>
          <td align="left">ครู</td>
          <td align="center">29</td>
          <td align="center">6/7</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100602259472.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center">14<input type="checkbox" name="xidcard[3100603210612]" value="3100603210612" checked="checked" > 
            <input type="hidden" name="xsiteid[3100603210612]" value="1801">
             <input type="hidden" name="xstatus_file[3100603210612]" value="1">            </td>
          <td align="center">3100603210612</td>
          <td align="left">นางสอิ้ง  โพธิ์ชัย <input type="hidden" name="fullname[3100603210612]" value="นางสอิ้ง  โพธิ์ชัย "></td>
          <td align="left">สพป.เชียงใหม่เขต 1/โรงเรียนวัดเสาหิน</td>
          <td align="left">ครู</td>
          <td align="center">33</td>
          <td align="center">2/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100603210612.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center">15<input type="checkbox" name="xidcard[3100903523772]" value="3100903523772" checked="checked" > 
            <input type="hidden" name="xsiteid[3100903523772]" value="1801">
             <input type="hidden" name="xstatus_file[3100903523772]" value="1">            </td>
          <td align="center">3100903523772</td>
          <td align="left">นายปานเทพ  ปานนิล <input type="hidden" name="fullname[3100903523772]" value="นายปานเทพ  ปานนิล "></td>
          <td align="left">สพป.เชียงใหม่เขต 1/โรงเรียนวัดเสาหิน</td>
          <td align="left">ครู</td>
          <td align="center">19</td>
          <td align="center">1/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3100903523772.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center">16<input type="checkbox" name="xidcard[3101400457576]" value="3101400457576" checked="checked" > 
            <input type="hidden" name="xsiteid[3101400457576]" value="1801">
             <input type="hidden" name="xstatus_file[3101400457576]" value="1">            </td>
          <td align="center">3101400457576</td>
          <td align="left">นางสาวประพิมภา  ปลายนา <input type="hidden" name="fullname[3101400457576]" value="นางสาวประพิมภา  ปลายนา "></td>
          <td align="left">สพป.เชียงใหม่เขต 1/โรงเรียนวัดเสาหิน</td>
          <td align="left">ครู</td>
          <td align="center">26</td>
          <td align="center">3/6</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3101400457576.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center">17<input type="checkbox" name="xidcard[3101400508588]" value="3101400508588" checked="checked" > 
            <input type="hidden" name="xsiteid[3101400508588]" value="1801">
             <input type="hidden" name="xstatus_file[3101400508588]" value="1">            </td>
          <td align="center">3101400508588</td>
          <td align="left">นายไพรัตน์  จิระวงศ์ <input type="hidden" name="fullname[3101400508588]" value="นายไพรัตน์  จิระวงศ์ "></td>
          <td align="left">สพป.เชียงใหม่เขต 1/โรงเรียนวัดเมืองสาตร</td>
          <td align="left">ครู</td>
          <td align="center">27</td>
          <td align="center">2/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3101400508588.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center">18<input type="checkbox" name="xidcard[3101400944051]" value="3101400944051" checked="checked" > 
            <input type="hidden" name="xsiteid[3101400944051]" value="1801">
             <input type="hidden" name="xstatus_file[3101400944051]" value="1">            </td>
          <td align="center">3101400944051</td>
          <td align="left">นางสาวนฤมล  เลี้ยงตระกูล <input type="hidden" name="fullname[3101400944051]" value="นางสาวนฤมล  เลี้ยงตระกูล "></td>
          <td align="left">สพป.เชียงใหม่เขต 1/โรงเรียนวัดเมืองสาตร</td>
          <td align="left">ครู</td>
          <td align="center">29</td>
          <td align="center">2/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3101400944051.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#FFFFFF">
          <td align="center">19<input type="checkbox" name="xidcard[3101501762757]" value="3101501762757" checked="checked" > 
            <input type="hidden" name="xsiteid[3101501762757]" value="1801">
             <input type="hidden" name="xstatus_file[3101501762757]" value="1">            </td>
          <td align="center">3101501762757</td>
          <td align="left">นางพรอุมา  ตาดโท้ <input type="hidden" name="fullname[3101501762757]" value="นางพรอุมา  ตาดโท้ "></td>
          <td align="left">สพป.เชียงใหม่เขต 1/โรงเรียนวัดเมืองสาตร</td>
          <td align="left">ครู</td>
          <td align="center">30</td>
          <td align="center">3/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3101501762757.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr bgcolor="#F0F0F0">
          <td align="center">20<input type="checkbox" name="xidcard[3101601029377]" value="3101601029377" checked="checked" > 
            <input type="hidden" name="xsiteid[3101601029377]" value="1801">
             <input type="hidden" name="xstatus_file[3101601029377]" value="1">            </td>
          <td align="center">3101601029377</td>
          <td align="left">นายเสน่ห์  สังข์งาม <input type="hidden" name="fullname[3101601029377]" value="นายเสน่ห์  สังข์งาม "></td>
          <td align="left">สพป.เชียงใหม่เขต 1/โรงเรียนวัดเมืองสาตร</td>
          <td align="left">ครู</td>
          <td align="center">33</td>
          <td align="center">1/8</td>
          <td align="center"><a href="../../../edubkk_kp7file/1801/3101601029377.pdf" target="_blank"><img src="../../images_sys/gnome-mime-application-pdf.png" alt="เอกสาร ก.พ.7 ต้นฉบับ" width="20" height="20" border="0"></a></td>
        </tr>
		          <tr>
          <td colspan="8" align="center" bgcolor="#FFFFFF"><label>
          <input type="hidden" name="profile_id" value="8">
		  <input type="hidden" name="Aaction" value="SAVE">
		   <input type="hidden" name="staffid" value="11560">
		   <input type="hidden" name="TicketId" value="">
		                <input type="submit" name="Submit2" value="บันทึก" >
			<input type="button" name="btnB" value="ย้อนกลับ" onClick="location.href='assign_list.php?action=assign_key&xsearch=&staffid=11560'">
          </label></td>
          </tr>
		          <tr>
		            <td colspan="8" align="left" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
		              <tr>
		                <td colspan="3" align="left"><em><strong>หมายเหตุ </strong></em></td>
	                  </tr>
		              <tr>
		                <td width="3%">&nbsp;</td>
		                <td width="3%" bgcolor="#FF9900">&nbsp;</td>
		                <td width="97%"><em>สัญลักษณ์ข้าราชการครูและบุคลากรทางการศึกษาที่เป็นกลุ่มเป้าหมายในการตรวจสอบความถูกต้องของข้อมูล(QC)</em></td>
	                  </tr>
		              <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
	                  </tr>
		              <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
	                  </tr>
		              <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
	                  </tr>
		              <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
	                  </tr>
		              <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
	                  </tr>
		              <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
	                  </tr>
		              <tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
	                  </tr>
	                </table></td>
        </tr>
      </table>
  
  </td></tr>
  </form>
  </table>

</BODY>
</HTML>

