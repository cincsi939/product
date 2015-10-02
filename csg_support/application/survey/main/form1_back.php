<link rel="stylesheet" href="../css/style.css">
<script type="text/javascript" src="../js/jquery-1.8.2.js"></script>
<script language="JavaScript">
	function showimagepreview(input) {
	if (input.files && input.files[0]) {
	var filerdr = new FileReader();
	filerdr.onload = function(e) {
	$('#imgprvw').attr('src', e.target.result);
	}
	filerdr.readAsDataURL(input.files[0]);
	}
}
</script>

<script src="../js/jquery-1.10.1.min.js"></script>
<script src="../js/AgeCalculate.min.js"></script>

<?php
	require_once('lib/nusoap.php'); 
	require_once("lib/class.function.php");
	$con = new Cfunction();
	$ws_client = new nusoap_client('http://soapservices.sapphire.co.th/index.php?wsdl',true); 
	$calendar = array('file' => 'calendar');
	echo $ws_client->call('includefile', $calendar);
	$para = array(
		'dateFormat' => 'dd/mm/yy',
		'inputname' => 'tbirthday',
		'showicon' => false,
		'showOtherMonths' => true,
		'showButton' => false,
		'showchangeMonth' => true,
		'numberOfMonths' => 1,
		'format' => 'utf-8',
		'showWeek' => false);	
	 $result = $ws_client->call('calendar', $para);
?> 
<form action="main_exc/form1_exc.php" method="post" enctype="multipart/form-data">
<table width="850" border="0">
<tbody>
	<tr>    
    	<td colspan="3" align="right">ข้อมูล ณ วันที่ <?php echo $con->_calendarTH('sDay','sMonth','sYear'); ?>
        </td>
        <td width="246">&nbsp;</td>
    </tr>
    <tr>
   	  <td colspan="3" align="left"><b><u>ส่วนที่ 1</u></b> <b>รายละเอียดข้อมูลของครัวเรือน</b></td>
   	  <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="24" align="right">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td rowspan="8" align="center"><img src="../img/nopicture.gif" width="150" height="180" id="imgprvw" alt="uploaded image preview" name="pPicture">        <input type="File" name="filUpload" id="filUpload" onChange="showimagepreview(this)" ></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      </tr>
    <tr>
      <td height="25" align="right">1.</td>
      <td height="25" colspan="2"><input type="hidden" name="cIDCard" value="1">
        เลขบัตรประจำตัวประชาชน        
        <INPUT name="tIDCard" type="text" id="tIDCard" value="" size="30"  /></td>
      </tr>
    <tr>
      <td height="25" align="right">2.</td>
      <td height="25" colspan="2">ชื่อหัวหน้าครอบครัว&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="tFirstname" type="text" value="" size="30"  />
        นามสกุล 
        <input type="text" value=""  name="tLastname" size="30"/></td>
      </tr>
    <tr>
      <td height="25" align="right">3. </td>
      <td height="25" colspan="2">ที่อยู่อาศัย</td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td height="25" colspan="2" valign="middle"><table width="546" border="0" cellpadding="1" cellspacing="1">
        <tr>
          <td width="65" align="right">บ้านเลขที่ :</td>
          <td width="144"><INPUT type="text" value="" name="tAddress" /></td>
          <td width="50" align="right">หมู่ที่ :</td>
          <td width="245"><INPUT type="text" value=""  name="tVillage" /></td>
        </tr>
        <tr>
          <td align="right">ถนน :</td>
          <td><input type="text" value="" name="tStreet" /></td>
          <td align="right">ตำบล :</td>
          <td><input type="text" value=""  name="tParish"/></td>
        </tr>
        <tr>
          <td align="right">อำเภอ :</td>
          <td><INPUT type="text" value="" name="tDistrict"/></td>
          <td align="right">จังหวัด :</td>
          <td><INPUT type="text" value="" name="tProvince" /></td>
        </tr>
        <tr>
          <td align="right">โทรศัพท์ :</td>
          <td><input type="text" value=""  name="tPhone"/></td>
          <td align="right">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
      </tr>
    <tr>
      <td height="25" align="right">4. </td>
      <td height="25" colspan="2">เพศ
        <input type="radio"  value="1"  class="rSex" name="rSex"  />
1. หญิง&nbsp;
<input type="radio"  value="2" class="rSex" name="rSex"   />
2. ชาย
<input type="radio"  value="3" id="rSex_3" name="rSex"   />
3. อื่น ๆ ระบุ
<INPUT name="tSex" type="text" id="tSex" value="" size="30" /></td>
      </tr>
    <tr>
      <td height="25" align="right">5. </td>
      <td height="25" colspan="2">วันเกิด<?php echo $result; ?> อายุ
        <INPUT name="tAge" type="text" id="tAge" value="" size="4" maxlength="4" />
ปี</td>
    </tr>
    <tr>
      <td height="25" align="right">6. </td>
      <td height="25" colspan="2">ประเภทของที่อยู่อาศัยในปัจจุบัน
        
        &nbsp;</td>
      <td height="25">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td height="25"><input name="rTypeHome" class="rTypeHome" type="radio"  value="1"  id="m2" />1. บ้านตัวเอง</td>
      <td height="25" colspan="2">	<input name="rTypeHome" type="radio"  value="4" id="rTypeHome_2"   class="rTypeHome"/>
        2. บ้านเช่า จ่ายค่าเช่า
<INPUT name="tTypeHome_2" type="text" id="tTypeHome_2" value="" size="10" />
        บาท/เดือน/ปี</td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td height="25"><input name="rTypeHome" type="radio"  value="3" id="f3" class="rTypeHome"  />
3. บ้านญาติ </td>
      <td height="25" colspan="2"><input name="rTypeHome" type="radio"  value="4" id="rTypeHome_4"   class="rTypeHome"/>
        4. อื่น ๆ ระบุ        
        <INPUT name="tTypeHome_4" type="text" id="tTypeHome_4" value="" style="width:80%" /></td>
      </tr>
    <tr>
      <td height="25" align="right">7.</td>
      <td height="25" colspan="2">ลักษณะที่อยู่</td>
      <td height="25">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td height="25" colspan="2">7.1 ลักษณะของบ้าน</td>
      <td height="25">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3" align="right"><textarea name="tstypehome_1" id="textarea" style="width:100%" rows="8"></textarea></td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="2">7.2 สภาพบ้าน</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><textarea name="tstypehome_2" id="taHomeStyle" style="width:100%" rows="8"></textarea></td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="2">7.3 ห้องสุขา</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><textarea name="tstypehome_3" id="taHomeStyle2" style="width:100%" rows="8"></textarea></td>
      </tr>
    <tr>
      <td height="25" align="right">8.</td>
      <td  colspan="2">สภาพแวดล้อม</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><textarea name="tEnvironment" id="tEnvironment" style="width:100%" rows="8"></textarea></td>
      </tr>
    <tr>
      <td height="25" align="right">9.</td>
      <td  colspan="2">การศึกษา</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="radio"  value="1"  id=""    name="rEducation"/>
        ไม่ได้ศึกษา</td>
      <td width="282" ><input type="radio"  value="2"  id=""    name="rEducation"/>
        ต่ำกว่าประถมศึกษา</td>
      <td ><input type="radio"  value="3"  id="rEducation"    name="rEducation"/>
        ประถมศึกษา</td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="radio"  value="4"  id=""    name="rEducation"/>
      มัธยมศึกษาตอนต้น</td>
      <td ><input type="radio"  value="5"  id=""    name="rEducation"/>
        มัธยมศึกษาตอนปลาย</td>
      <td ><input type="radio"  value="6"  id="rEducation2"    name="rEducation"/>
        มัธยมศึกษาตอนปลาย/ปวช</td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="radio"  value="7"  id=""    name="rEducation"/>
      อนุปริญญา/ปวส</td>
      <td ><input type="radio"  value="8"  id=""    name="rEducation"/>
        ปริญญาตรี</td>
      <td ><input type="radio"  value="9"  id="rEducation3"    name="rEducation"/>
        สูงกว่าปริญญาตรี</td>
      </tr>
    <tr>
      <td height="25" align="right">10. </td>
      <td  colspan="2">อาชีพหลักของหัวหน้าครอบครัว <strong>(ตอบได้มากว่า 1 ข้อ)</strong></td>
      <td >&nbsp;</td>
    </tr>

    <!--<div class="careertable">-->
    <tr class="careertable">
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="checkbox"  value="1"  id="cCareer1"    name="cCareer[]"/>
        1. รับจ้างทั่วไป</td>
      <td >        <input type="checkbox"  value="2"  id="cCareer2"    name="cCareer[]"/>
      2. เกษตรกร </td>
      <td >&nbsp;</td>
    </tr>
    <tr class="careertable">
      <td height="25" align="right">&nbsp;</td>
      <td >        <input type="checkbox"  value="3"  id="cCareer3"    name="cCareer[]"/>
      3. ประมง</td>
      <td >        <input type="checkbox"  value="4"  id="cCareer4"    name="cCareer[]"/>
      4. ข้าราชการ/ลูกจ้างหรือพนักงานของรัฐ</td>
      <td >&nbsp;</td>
    </tr>
    <tr class="careertable">
      <td height="25" align="right">&nbsp;</td>
      <td >        <input type="checkbox"  value="5"  id="cCareer5"    name="cCareer[]"/>
      5. พนักงานรัฐวิสาหกิจ</td>
      <td >        <input type="checkbox"  value="6"  id="cCareer6"    name="cCareer[]"/>
      6. เจ้าหน้าที่องค์กรปกครองท้องถิ่น </td>
      <td >&nbsp;</td>
    </tr>
    <tr class="careertable">
      <td height="25" align="right">&nbsp;</td>
      <td >        <input type="checkbox"  value="7"  id="cCareer7"    name="cCareer[]"/>
      7. ค้าขาย/ธุรกิจส่วนตัว</td>
      <td >        <input type="checkbox"  value="8"  id="cCareer8"    name="cCareer[]"/>
      8. พนักงาน/ลูกจ้างเอกชน</td>
      <td >&nbsp;</td>
    </tr>
    <tr class="careertable">
      <td height="25" align="right">&nbsp;</td>
      <td width="280" >        <input type="checkbox"  value="9"  id="cCareer9"    name="cCareer[]"/>
      9. ว่างงาน/ไม่มีงานทำ</td>
      <td  colspan="2">
        
        <input type="checkbox"  value="10"  id="cCareer10"    name="cCareer[]"/>
        10. อื่น ๆ ระบุ
  <input  name="tCareer" type="text" value="" style="width:80%" id="tCareer"  /></td>
      </tr>
      <!--</div>-->
    <tr>
      <td height="25" align="right">11.</td>
      <td  colspan="2">ครอบครัวมีที่ดินทำกิน      </td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="radio"  value="1"  id="rLand"    name="rLand"/>
        มี จำนวน 
        <input name="tLand" type="text" id="tLand" size="10" />
        ไร่</td>
      <td ><input type="radio"  value="2"  id="m34"    name="rLand" class="rLand_1"/>
        ไม่มี</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">12. </td>
      <td  colspan="3">รายได้เฉลี่ยของครอบครัว จำนวน
        <input name="tIncome" type="text" value="" size="10" id="tIncome" />
        บาท (ต่อปี)<strong> (รายได้คิดจากสมาชิกที่มีรายได้ร่วมกัน)</strong></td>
      </tr>
    <tr>
      <td height="25" align="right">13. </td>
      <td  colspan="2">ศาสนาหลักของครอบครัว</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><input type="radio"  value="1"  id="" name="rReligion" class="rReligion"/>
        1. พุทธ
        &nbsp;
        <input type="radio"  value="2" id="" name="rReligion"  class="rReligion"/>
        2. คริสต์
        <input type="radio"  value="3"  id="" name="rReligion"   class="rReligion"/>
        3. อิสลาม
        &nbsp;
        <input type="radio"  value="4" id="" name="rReligion"  class="rReligion_1"/>
        4. อื่น ๆ ระบุ
        <input name="tReligion" type="text" value="" style="width:60%" id="tReligion_1" /></td>
      </tr>
    <tr>
      <td height="25" align="right">14.</td>
      <td  colspan="2">สภานภาพสมรสของท่านในปัจจุบันเป็นอย่างไร</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="radio"  value="1"  class="rStatus" name="rStatus" />
        1. โสด</td>
      <td  colspan="2"><input type="radio"  value="2" class="rStatus" name="rStatus" />
        2. สมรส </td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="radio"  value="3"  class="rStatus"  name="rStatus"/>
        3. หย่าร้าง</td>
      <td  colspan="2"><input type="radio"  value="4" class="rStatus" name="rStatus"/>
        4. หม้ายเนื่องจากคู่สมรสเสียชีวิต</td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="radio"  value="5"  id="rStatus_5" name="rStatus" />
        5. แยกกันอยู่ โปรดระบุ</td>
      <td  colspan="2">&nbsp;</td>
      </tr>
      
    <tr class="rStatus_detail">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><dd><input type="radio"  value="1" class="rStatus_5_detail" name="rStatus_5" />
แยกกันอยู่ชั่วคราวตามข้อตกลงตามข้อตกลงระหว่างคู่สมรส</dd></td>
      </tr>
    <tr class="rStatus_detail">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><dd><input type="radio"  value="2" class="rStatus_5_detail" name="rStatus_5"/>แยกกันอยู่ชั่วคราวตามคำสั่งศาล</dd>
        </td>
      </tr>
      
    <tr>
      <td height="25" align="right">15.</td>
      <td  colspan="2">ลักษณะโครงสร้างครอบครัว</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><input type="radio"  value="1" id="rStructureFamily"  name="rStructureFamily" class="rStructureFamily"/>
        1. ครอบครัวเดียว จำนวนสมาชิก
        <input type="text" value="" size="4" maxlength="4" name="tMemberFamily_1" id="tMemberFamily_1"/>
        คน ชาย
  <input type="text" value="" size="4" maxlength="4" name="tMemberMale_1" id="tMemberMale_1"/>
        คน หญิง
  <input type="text" value="" size="4" maxlength="4" name="tMemberFemale_1" id="tMemberFemale_1"/>
  &nbsp;คน <strong>*ครอบครัวที่ประกอบด้วยพ่อ แม่ และลูกที่ยังไม่ได้แต่งงาน</strong></td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="2"><input type="radio"  value="2" id="rLargeFamily" name="rStructureFamily" class="rLargeFamily"/>
        2. ครอบครัวขยาย โปรดระบุ</td>
      <td >&nbsp;</td>
    </tr>
    
    <tr class="r15_2">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><dd>
        <input type="radio"  value="1" id="rLargeFamily_21" name="rLargeFamily" class="rLargeFamily_23"  />
        2.1 ครอบครัวขยายที่ประกอบด้วยหลาย ๆ ครัวเรือนอยู่ร่วมกัน แต่ละครัวเรือน <u>มีความสัมพันธ์ต่อกัน</u></dd></td>
    </tr>
    <tr class="r15_2">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><dd> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จำนวนสมาชิก
        <input type="text" value="" size="4" maxlength="4" name="tMemberFamily_2_1" id="tMemberFamily_2_1" />
        คน ชาย
        <input type="text" value="" size="4" maxlength="4" name="tMemberMale_2_1" id="tMemberMale_2_1" />
        คน หญิง
        <input type="text" value="" size="4" maxlength="4" name="tMemberFemale_2_1" id="tMemberFemale_2_1" />
        &nbsp;คน </dd></td>
    </tr>
    <tr class="r15_2">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><dd>
        <input type="radio"  value="2" id="rLargeFamily_22" name="rLargeFamily" class="rLargeFamily_24"  />
        2.2 ครอบครัวขยายที่ประกอบด้วยหลาย ๆ ครัวเรือนอยู่ร่วมกัน แต่ละครัวเรือน <u>มีความอิสระต่อกัน</u>ในการดำเนินชีวิตครอบครัวของตนเอง </dd></td>
    </tr>
    <tr class="r15_2">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3" valign="top"><dd> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จำนวนสมาชิก
        <input type="text" value="" size="4" maxlength="4"  name="tMemberFamily_2_2" id="tMemberFamily_2_2"/>
        คน ชาย
        <input type="text" value="" size="4" maxlength="4" name="tMemberMale_2_2" id="tMemberMale_2_2" />
        คน หญิง
        <input type="text" value="" size="4" maxlength="4"  name="tMemberFemale_2_2" id="tMemberFemale_2_2"/>
        &nbsp;คน </dd></td>
    </tr>
    
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="2"><input type="radio"  value="3" id="rSpecialFamily"  name="rStructureFamily" class="rSpecialFamily"/>
        3. ครอบครัวลักษณะพิเศษ โปรดระบุ</td>
      <td >&nbsp;</td>
    </tr>
    
    <tr class="r15_3">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="2"><dd>
        <input type="radio"  value="1" id="rSpecialFamily_1" name="rSpecialFamily" class="rSpecialFamily_1" />
        3.1 ครอบครัวที่ไม่มีบุตร</dd></td>
      <td >&nbsp;</td>
    </tr>
    <tr class="r15_3">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="2"><dd>
        <input type="radio"  value="2" id="rSpecialFamily_2" name="rSpecialFamily" class="rSpecialFamily_2"/>
        3.2 ครอบครัวพ่อหรือแม่เลี้ยงเดี่ยว</dd></td>
      <td >&nbsp;</td>
    </tr>
    <tr class="r15_3">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="2"><dd>
        <input type="radio"  value="3" id="rSpecialFamily_3"  name="rSpecialFamily" class="rSpecialFamily_3"/>
        3.3 ครอบครัวบุตรบุญธรรม</dd></td>
      <td >&nbsp;</td>
    </tr>
    <tr class="r15_3">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="2"><dd><input type="radio"  value="4" id="rSpecialFamily_4"  name="rSpecialFamily" class="rSpecialFamily_4" />
      
        3.4 ครอบครัวเพศทางเลือก</dd></td>
      <td >&nbsp;</td>
    </tr>
    <tr class="r15_3">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="2"><dd><input type="radio"  value="5" id="rSpecialFamily_5"  name="rSpecialFamily" class="rSpecialFamily_5"/>
      
        3.5 ครอบครัวอุปถัมภ์</dd></td>
      <td >&nbsp;</td>
    </tr>
    <tr class="r15_3">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><dd>
        <input type="radio"  value="6" id="rSpecialFamily_6"  name="rSpecialFamily" class="rSpecialFamily_6"/>
        3.6 อื่น ๆ ระบุ
        <input name="tSpecialFamily_3" type="text" value="" style="width:85%" id="tSpecialFamily_3" />
      </dd></td>
      </tr>
    <tr>
      <td height="25" align="right">16. </td>
      <td  colspan="2">จำนวนสมาชิกในครอบครัวที่มีภาวะพึ่งพิงสูง (ไม่สามารถช่วยเหลือตนเองได้)</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td width="280" ><input type="radio"  value="1"  id="rDefective_1" name="rDefective"  />1. ไม่มี</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="radio"  value="2"  id="rDefective_2"  name="rDefective"/>2. จำนวน<input type="text" value="" size="4" maxlength="4" name="tDefective"/>คน โปรดระบุ </td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      </tr>
      
    <tr id="t16_detail">
      <td height="25" align="right">&nbsp;</td>
      <td colspan="3"><dd>
        <table>
          <tr>
            <td>จำนวนเด็กเล็ก (0-4ปี)</td>
            <td><input type="text" value="" size="4" maxlength="4" name="tChild" />
              คน</td>
            </tr>
          <tr>
            <td>จำนวนผู้พิการ</td>
            <td><input type="text" value="" size="4" maxlength="4"  name="tDisabled" />
              คน</td>
            </tr>
          <tr>
            <td>จำนวนผู้ป่วยทางจิต</td>
            <td><input type="text" value="" size="4" maxlength="4" name="tMindSick" />
              คน</td>
            </tr>
          <tr>
            <td>จำนวนผู้ป่วยเรื้อรัง</td>
            <td><input type="text" value="" size="4" maxlength="4"  name="tSick"/>
              คน</td>
            </tr>
          <tr>
            <td>จำนวนผู้สูงอายุ</td>
            <td><input type="text" value="" size="4" maxlength="4" name="tElderly" />
              คน</td>
            </tr>
          </table>
        
        </dd></td>
    </tr>
    <tr>
      <td height="25" align="right">17. </td>
      <td  colspan="3">จำนวนผู้อาศัยแยกตามกลุ่ม</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="3"><table width="100%" border="0" cellpadding="1" cellspacing="0" id="t17">
        <thead>
          <tr>
            <th width="184" height="25"  bgcolor="#f2f2f2">ประเภท</th>
            <th width="202"  bgcolor="#f2f2f2">ชาย</th>
            <th width="202"  bgcolor="#f2f2f2">หญิง</th>
            <th width="218"  bgcolor="#f2f2f2">รวม</th>
            </tr>
          </thead>
        <tr>
          <td width="184" height="25"  align="left">&nbsp;1. เด็ก (อายุ 0-18 ปี)</td>
          <td width="202"  align="center"><input  name="tChildMale" type="text" id="tChildMale"  style=" width:80%" maxlength="4"/></td>
          <td width="202"  align="center"><input name="tChildFemale" type="text" id="tChildFemale"  style=" width:80%" maxlength="4" /></td>
          <td  align="center"><input name="tChildTotal" type="text" id="tChildTotal"  style=" width:80%; background:#CCC;" value="0" maxlength="4" readonly="readonly" /></td>
          </tr>
        <tr>
          <td width="184" height="25"  align="left">&nbsp;2. เยาวชน (อายุ 19-25 ปี)</td>
          <td width="202"  align="center"><input name="tTeensMale" type="text" id="tTeensMale"  style=" width:80%" maxlength="4"  /></td>
          <td width="202"  align="center"><input name="tTeensFemale" type="text" id="tTeensFemale"  style=" width:80%" maxlength="4" /></td>
          <td  align="center"><input name="tTeensTotal" type="text" id="tTeensTotal"  style=" width:80%; background:#CCC;" value="0" maxlength="4" readonly="readonly" /></td>
          </tr>
        <tr>
          <td width="184" height="25"  align="left">&nbsp;3. ผู้อาศัยทั่วไป (อายุ 26-59 ปี)</td>
          <td width="202"  align="center"><input name="tMan" type="text" id="tMan"  style=" width:80%" maxlength="4" /></td>
          <td width="202"  align="center"><input name="tWoman" type="text" id="tWoman"  style=" width:80%" maxlength="4" /></td>
          <td  align="center"><input name="tTotal" type="text" id="tTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly="readonly" /></td>
          </tr>
        <tr>
          <td width="184" height="25"  align="left">&nbsp;4. ผู้สูงอายุ (อายุ 60 ปี)</td>
          <td width="202"  align="center"><input name="tElderMale" type="text" id="tElderMale"  style=" width:80%" maxlength="4" /></td>
          <td width="202"  align="center"><input name="tElderFemale" type="text" id="tElderFemale"  style=" width:80%" maxlength="4" /></td>
          <td  align="center"><input name="tElderTotal" type="text" id="tElderTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly="readonly" /></td>
          </tr>
        <tr>
          <td width="184" height="25"  align="left">&nbsp;5. คนพิการ</td>
          <td width="202"  align="center"><input name="tDisabledMale" type="text" id="tDisabledMale"  style=" width:80%" maxlength="4" /></td>
          <td width="202"  align="center"><input name="tDisabledFemale" type="text" id="tDisabledFemale"  style=" width:80%" maxlength="4"  /></td>
          <td  align="center"><input name="tDisabledTotal" type="text" id="tDisabledTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly="readonly"  /></td>
          </tr>
        <tr>
          <td width="184" height="25"  align="center">รวมทั้งสิ้น</td>
          <td width="202"  align="center"><input name="tMaleTotal" type="text" id="tMaleTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly="readonly"  /></td>
          <td width="202"  align="center"><input name="tFemaleTotal" type="text" id="tFemaleTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly="readonly" /></td>
          <td  align="center"><input name="tSumTotal" type="text" id="tSumTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly="readonly" /></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="25" align="right">18.</td>
      <td  colspan="2">ครอบครัวมีหนี้สิน </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  valign="top"><input type="radio"  value="1"  id="rDebt_1"   name="rDebt"/> 1. ไม่มี</td>
      <td  valign="top"><br></td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="radio"  value="2"  id="rDebt_2" name="rDebt" /> 2. มี โปรดระบุ</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
    <tr class="t18">
      <td height="25" align="right">&nbsp;</td>
      <td >&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio"  value="1"  id="rDebt_a" name="rDebt_a" /> 
        2.1 หนี้ในระบบ</td>
      <td  colspan="2">&nbsp;</td>
    </tr>
    <tr id="t18_a" class="t18">
      <td height="25" align="right">&nbsp;</td>
      <td colspan="3">
      <dd>
      <table width="809" border="0" cellpadding="1" cellspacing="1" class="t21">
        <tr>
          <td width="20"><input name="c18[]" type="checkbox" id="c18[]" value="1"></td>
          <td>เงินกู้ธนาคาร</td>
          </tr>
        <tr id="t18_2_1_1">
          <td>&nbsp;</td>
          <td>จำนวน 
            <input type="text" value="" size="10" name="t21_money_1" id="t21_money_1" />
            บาท ดอกเบี้ยร้อยละ            
            <input type="text" value="" size="10" name="t21_interest_1" id="t21_interest_1"/>
            ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน 
            <input type="text" value="" size="10" name="t21_pay_1" id="t21_pay_1"/>
            บาท ยอดคงเหลือ
            <input type="text" value="" size="10" name="t21_balance_1" id="t21_balance_1" />
            บาท</td>
          </tr>
        <tr>
          <td><input name="c18[]" type="checkbox" value="2" id="c18[]"></td>
          <td>เงินกู้กองทุนสัจจะสะสมทรัพย์</td>
          </tr>
        <tr id="t18_2_1_2">
          <td>&nbsp;</td>
          <td>จำนวน
            <input type="text" value="" size="10" name="t21_money_2" id="t21_money_2" />
บาท ดอกเบี้ยร้อยละ 
<input type="text" value="" size="10" name="t21_interest_2" id="t21_interest_2" />
ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน 
            <input type="text" value="" size="10" name="t21_pay_2" id="t21_pay_2" />
            บาท ยอดคงเหลือ
            <input type="text" value="" size="10" name="t21_balance_2" id="t21_balance_2" />
            บาท</td>
          </tr>
        <tr>
          <td><input name="c18[]" type="checkbox" id="c18_2_3" value="3"></td>
          <td>เงินกู้กองทุนหมู่บ้าน</td>
          </tr>
        <tr id="t18_2_1_3">
          <td>&nbsp;</td>
          <td>จำนวน 
            <input type="text" value="" size="10" name="t21_money_3" id="t21_money_3"/>
บาท ดอกเบี้ยร้อยละ <input type="text" value="" size="10" name="t21_interest_3" id="t21_interest_3" />
ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน
<input type="text" value="" size="10" name="t21_pay_3" id="t21_pay_3" />
            บาท ยอดคงเหลือ
            <input type="text" value="" size="10" name="t21_balance_3" id="t21_balance_3" />
            บาท</td>
          </tr>
        <tr>
          <td><input name="c18[]" type="checkbox" id="c18_2_4" value="4"></td>
          <td>กองทุนพัฒนาบทบาทสตรี</td>
          </tr>
        <tr id="t18_2_1_4">
          <td>&nbsp;</td>
          <td>จำนวน 
            <input type="text" value="" size="10" name="t21_money_4" id="t21_money_4" />
            บาท ดอกเบี้ยร้อยละ 
            <input type="text" value="" size="10" name="t21_interest_4" id="t21_interest_4" />
            ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน 
            <input type="text" value="" size="10" name="t21_pay_4" id="t21_pay_4" />
            บาท ยอดคงเหลือ
            <input type="text" value="" size="10" name="t21_balance_4" id="t21_balance_4" />
            บาท</td>
          </tr>
        <tr>
          <td><input name="c18[]" type="checkbox" id="c18_2_5" value="5"></td>
          <td>กองทุนผู้สูงอายุ</td>
          </tr>
        <tr id="t18_2_1_5">
          <td>&nbsp;</td>
          <td>จำนวน 
            <input type="text" value="" size="10" name="t21_money_5" id="t21_money_5" />
            บาท ดอกเบี้ยร้อยละ 
            <input type="text" value="" size="10" name="t21_interest_5" id="t21_interest_5" />
            ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน 
            <input type="text" value="" size="10" name="t21_pay_5" id="t21_pay_5" />
            บาท ยอดคงเหลือ
            <input type="text" value="" size="10" name="t21_balance_5" id="t21_balance_5" />
            บาท</td>
          </tr>
        <tr>
          <td><input name="c18[]" type="checkbox" id="c18_2_6" value="6"></td>
          <td>กองทุนส่งเสริมพัฒนาคุณภาพชีวิตคนพิการ</td>
          </tr>
        <tr id="t18_2_1_6">
          <td>&nbsp;</td>
          <td>จำนวน 
            <input type="text" value="" size="10" name="t21_money_6" id="t21_money_6"/>
            บาท ดอกเบี้ยร้อยละ 
            <input type="text" value="" size="10" name="t21_interest_6" id="t21_interest_6"/>
            ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน 
            <input type="text" value="" size="10" name="t21_pay_6" id="t21_pay_6"/>
            บาท ยอดคงเหลือ
            <input type="text" value="" size="10" name="t21_balance_6" id="t21_balance_6"/>
            บาท</td>
          </tr>
        <tr>
          <td><input name="c18[]" type="checkbox" id="c18_2_7" value="7"></td>
          <td>กองทุนปุ๋ย</td>
          </tr>
        <tr id="t18_2_1_7">
          <td>&nbsp;</td>
          <td>จำนวน
            <input type="text" value="" size="10" name="t21_money_7" id="t21_money_7"/>
            บาท ดอกเบี้ยร้อยละ 
            <input type="text" value="" size="10" name="t21_interest_7" id="t21_interest_7" />
            ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน 
            <input type="text" value="" size="10" name="t21_pay_7" id="t21_pay_7" />
            บาท ยอดคงเหลือ
            <input type="text" value="" size="10" name="t21_balance_7" id="t21_balance_7" />
            บาท</td>
          </tr>
        <tr>
          <td><input name="c18[]" type="checkbox" id="c18_2_8" value="8"></td>
          <td>กองทุนเกษตร</td>
          </tr>
        <tr id="t18_2_1_8">
          <td>&nbsp;</td>
          <td>จำนวน
            <input type="text" value="" size="10" name="t21_money_8" id="t21_money_8" />
            บาท ดอกเบี้ยร้อยละ 
            <input type="text" value="" size="10" name="t21_interest_8" id="t21_interest_8"/>
            ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน 
            <input type="text" value="" size="10" name="t21_pay_8" id="t21_pay_8"/>
            บาท ยอดคงเหลือ
            <input type="text" value="" size="10" name="t21_balance_8" id="t21_balance_8"/>
            บาท</td>
          </tr>
        <tr>
          <td><input name="c18[]" type="checkbox" id="c18_2_9" value="9"></td>
          <td>อื่น ๆ ระบุ
            <input type="text" value=""  style="width:84%" name="t21_other" id="t21_other" /></td>
          </tr>
        <tr id="t18_2_1_9">
          <td>&nbsp;</td>
          <td>จำนวน 
            <input type="text" value="" size="10" name="t21_money_9" id="t21_money_9"/>
            บาท ดอกเบี้ยร้อยละ 
            <input type="text" value="" size="10" name="t21_interest_9" id="t21_interest_9"/>
            ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน 
            <input type="text" value="" size="10" name="t21_pay_9" id="t21_pay_9"/>
            บาท ยอดคงเหลือ
            <input type="text" value="" size="10" name="t21_balance_9" id="t21_balance_9"/>
            บาท</td>
          </tr>
      </table>
      
      </dd>
      </td>
    </tr>
    <tr class="t18">
      <td height="25" align="right" >&nbsp;</td>
      <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio"  value="2"  id="rDebt_b" name="rDebt_a" />
        2.2 หนี้นอกระบบ คุณเป็นหนี้นอกระบบใครบ้าง ระบุชื่อ - สกุลด้วย</td>
    </tr>
    <tr class="t18">
      <td height="25" align="right">&nbsp;</td>
      <td colspan="3">
      
      <dd>
      <table width="809" border="0" cellspacing="2" cellpadding="2" id="t18_b" class="order-list">
      <tbody>
        </tbody>
        <tfoot>
        <tr>
          <td >ชื่อ-สกุล 
            <input type="text" name="tName18_2_1" value="" /></td>
          <td width="104" >จำนวนเงิน</td>
          <td width="114"><input type="text" name="tMoney18_2_1" size="10" />
บาท</td>
          <td width="104">ดอกเบี้ยร้อยละ</td>
          <td width="264"><input name="tInterest18_2_1" type="text" value="" size="10" />
ต่อวัน/เดือน/ปี </td>
          </tr>
        <tr>
          <td width="191" >&nbsp;</td>
          <td >ส่งมาแล้วเป็นเงิน            </td>
          <td ><input name="tPay18_2_1" type="text" value="" size="10" />
บาท</td>
          <td >ยอดคงเหลือ</td>
          <td ><input name="tBalance18_2_1" type="text" value="" size="10" />
บาท</td>
          </tr>
        <tr>
          <td >ชื่อ-สกุล
            <input type="text" name="tName18_2_2" value="" /></td>
          <td >จำนวนเงิน</td>
          <td ><input type="text" name="tMoney18_2_2" size="10" />
บาท</td>
          <td >ดอกเบี้ยร้อยละ</td>
          <td ><input name="tInterest18_2_2" type="text" value="" size="10" />
ต่อวัน/เดือน/ปี </td>
          </tr>
        <tr>
          <td >&nbsp;</td>
          <td >ส่งมาแล้วเป็นเงิน</td>
          <td ><input name="tPay18_2_2" type="text" value="" size="10" />
บาท</td>
          <td >ยอดคงเหลือ</td>
          <td ><input name="tBalance18_2_2" type="text" value="" size="10" />
บาท</td>
        </tr>
        <tr>
          <td >ชื่อ-สกุล
            <input type="text" name="tName18_2_3" value="" /></td>
          <td>จำนวนเงิน</td>
          <td ><input type="text" name="tMoney18_2_3" size="10" />
            บาท</td>
          <td>ดอกเบี้ยร้อยละ</td>
          <td ><input name="tInterest18_2_3" type="text" value="" size="10" />
            ต่อวัน/เดือน/ปี </td>
        </tr>
        <tr>
          <td >&nbsp;</td>
          <td>ส่งมาแล้วเป็นเงิน</td>
          <td ><input name="tPay18_2_3" type="text" value="" size="10" />
            บาท</td>
          <td>ยอดคงเหลือ</td>
          <td ><input name="tBalance18_2_3" type="text" value="" size="10" />
            บาท</td>
        </tr>
        <tr>
          <td >ชื่อ-สกุล            <input type="text" name="tName18_2_4" value="" /></td>
          <td>จำนวนเงิน</td>
          <td ><input type="text" name="tMoney18_2_4" size="10" />
            บาท</td>
          <td>ดอกเบี้ยร้อยละ</td>
          <td ><input name="tInterest18_2_4" type="text" value="" size="10" />
            ต่อวัน/เดือน/ปี </td>
        </tr>
        <tr>
          <td >&nbsp;</td>
          <td>ส่งมาแล้วเป็นเงิน</td>
          <td ><input name="tPay18_2_4" type="text" value="" size="10" />
            บาท</td>
          <td>ยอดคงเหลือ</td>
          <td ><input name="tBalance18_2_4" type="text" value="" size="10" />
            บาท</td>
        </tr>
        <tr>
          <td >ชื่อ-สกุล            <input type="text" name="tName18_2_5" value="" /></td>
          <td>จำนวนเงิน</td>
          <td ><input type="text" name="tMoney18_2_5" size="10" />
            บาท</td>
          <td>ดอกเบี้ยร้อยละ</td>
          <td ><input name="tInterest18_2_5" type="text" value="" size="10" />
            ต่อวัน/เดือน/ปี </td>
        </tr>
        <tr>
          <td >&nbsp;</td>
          <td>ส่งมาแล้วเป็นเงิน</td>
          <td ><input name="tPay18_2_5" type="text" value="" size="10" />
            บาท</td>
          <td>ยอดคงเหลือ</td>
          <td ><input name="tBalance18_2_5" type="text" value="" size="10" />
            บาท</td>
        </tr>
        <tr>
          <td >ชื่อ-สกุล            <input type="text" name="tName18_2_6" value="" /></td>
          <td>จำนวนเงิน</td>
          <td ><input type="text" name="tMoney18_2_6" size="10" />
            บาท</td>
          <td>ดอกเบี้ยร้อยละ</td>
          <td ><input name="tInterest18_2_6" type="text" value="" size="10" />
            ต่อวัน/เดือน/ปี </td>
        </tr>
        <tr>
          <td >&nbsp;</td>
          <td>ส่งมาแล้วเป็นเงิน</td>
          <td ><input name="tPay18_2_6" type="text" value="" size="10" />
            บาท</td>
          <td>ยอดคงเหลือ</td>
          <td ><input name="tBalance18_2_6" type="text" value="" size="10" />
            บาท</td>
        </tr>
        </tfoot>
      </table>
      </dd>
      
      </td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="3" align="right"><button> บันทึก </button></td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="2" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="2" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="2" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
</tbody>
</table>
</form>
<script>

<?php $current_year = date("Y")+543; ?>

$(document).ready(function () {
$("#tSex").attr('disabled','disabled');
$("#tTypeHome_2").attr('disabled','disabled');
$("#tTypeHome_4").attr('disabled','disabled');
$("#tCareer").attr('disabled','disabled');
$("#tLand").attr('disabled','disabled');
$("#tReligion_1").attr('disabled','disabled');
$("#tMemberFamily_1,#tMemberMale_1,#tMemberFemale_1").attr('disabled','disabled');
$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
$("#tSpecialFamily_3").attr('disabled','disabled');


/*--------------------- 14 */
$(".rStatus_detail").hide();

/*--------------------- 15 */
$("#rLargeFamily_21,#rLargeFamily_22").attr('disabled','disabled');
$("#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").attr('disabled','disabled');
$(".r15_2").hide();
$(".r15_3").hide();

/*--------------------- 16 */
$('#t16_detail').hide();

/*--------------------- 18 */
$('.t18').hide();
$('#t18_a,#t18_b').hide();
//$('#t18_2_1_1,#t18_2_1_2,#t18_2_1_3,#t18_2_1_4,#t18_2_1_5,#t18_2_1_6,#t18_2_1_7,#t18_2_1_8,#t18_2_1_9').hide();

$("#tbirthday").change(function () {
	var result = document.getElementById('tbirthday').value;
	x =result.split("/");
        document.getElementById('tAge').value = ('<?=$current_year?>') - x[2];
});
//ส่วนของการตรวจสอบเงื่อนไขการDisabled 
//ตรวจสอบเงื่อนไขกลุ่มเพศ
$('.rSex').click(function(){
	$("#tSex").attr('disabled','disabled');
});

$('#rSex_3').click(function(){
	$("#tSex").removeAttr('disabled');
});

//ตรวจสอบเงื่อนไขกลุ่มที่อยู่อาศัย
$('.rTypeHome').click(function(){
	$("#tTypeHome_4").attr('disabled','disabled');
});
$('.rTypeHome').click(function(){
	$("#tTypeHome_2").attr('disabled','disabled');
});

$('#rTypeHome_2').click(function(){
	$("#tTypeHome_2").removeAttr('disabled');
});
$('#rTypeHome_4').click(function(){
	$("#tTypeHome_4").removeAttr('disabled');
});

//ตรวจสอบเงื่อนไขกลุ่มอาชีพ
$('#cCareer10').click(function(){
	if($('#tCareer').attr('disabled')){
		$('#tCareer').removeAttr('disabled')
	}else{
		$('#tCareer').attr('disabled','disabled')
	}
});
$('#cCareer4').click(function(){
	 if($('#cCareer5').attr('disabled')){
		$('#cCareer5,#cCareer6,#cCareer8').removeAttr('disabled')
	}else{
		$('#cCareer5,#cCareer6,#cCareer8').attr('disabled','disabled')
		$('#cCareer5,#cCareer6,#cCareer8').removeAttr('checked')
	}
});
$('#cCareer5').click(function(){
	 if($('#cCareer4').attr('disabled')){
		$('#cCareer4,#cCareer6,#cCareer8').removeAttr('disabled')
	}else{
		$('#cCareer4,#cCareer6,#cCareer8').attr('disabled','disabled')
		$('#cCareer4,#cCareer6,#cCareer8').removeAttr('checked')
	}
});
$('#cCareer6').click(function(){
	 if($('#cCareer4').attr('disabled')){
		$('#cCareer4,#cCareer5,#cCareer8').removeAttr('disabled')
	}else{
		$('#cCareer4,#cCareer5,#cCareer8').attr('disabled','disabled')
		$('#cCareer4,#cCareer5,#cCareer8').removeAttr('checked')
	}
});
$('#cCareer8').click(function(){
	 if($('#cCareer4').attr('disabled')){
		$('#cCareer4,#cCareer6,#cCareer5').removeAttr('disabled')
	}else{
		$('#cCareer4,#cCareer6,#cCareer5').attr('disabled','disabled')
		$('#cCareer4,#cCareer6,#cCareer5').removeAttr('checked')
	}
});

$('.careertable input:not(#cCareer9,#cCareer10)').click(function(){
	if($('.careertable input:not(#cCareer9,#cCareer10)').is(':checked') == true){
		$('#cCareer9').attr('disabled','disabled')
		$('#cCareer9').removeAttr('checked')
	}
	if($('.careertable input:not(#cCareer9,#cCareer10)').is(':checked') == false){
		$('#cCareer9').removeAttr('disabled')
	}
})

$('#cCareer9').click(function(){
		 if($('.careertable input:not(#cCareer9,#cCareer10)').attr('disabled')){
			$('.careertable input:not(#cCareer9,#cCareer10,#tCareer)').removeAttr('disabled')
		 }else{
			$('.careertable input:not(#cCareer9,#cCareer10,#tCareer)').attr('disabled','disabled')
			$('.careertable input:not(#cCareer9,#cCareer10,#tCareer)').removeAttr('checked')
		}
});

//ตรวจสอบเงื่อนไขกลุ่มที่ดิน
$('.rLand_1').click(function(){
	$("#tLand").attr('disabled','disabled');
});

$('#rLand').click(function(){
	$("#tLand").removeAttr('disabled');
});
//ตรวจสอบเงื่อนไขกลุ่มศาสนา
$('.rReligion').click(function(){
	$("#tReligion_1").attr('disabled','disabled');
});
$('.rReligion_1').click(function(){
	$("#tReligion_1").removeAttr('disabled');
});

//ตรวจสอบเงื่อนไขสภานภาพสมรส
$('.rStatus').click(function(){
	$(".rStatus_detail").hide();
});

$('#rStatus_5').click(function(){
	$(".rStatus_detail").show();
});

//------------------------------------------------ 16
$('#rDefective_1').click(function(){
	$('#t16_detail').hide();
});

$('#rDefective_2').click(function(){
	$('#t16_detail').show();
});

//------------------------------------------------ 17
$("#t17 input").keyup(function () {
	
	var tChildMale = document.getElementById('tChildMale').value;
	var tChildFemale = document.getElementById('tChildFemale').value;
	if(tChildMale==''){tChildMale = 0;}
	if(tChildFemale==''){tChildFemale = 0;}
	var tChildTotal = parseInt(tChildMale)+parseInt(tChildFemale);
	$("#tChildTotal").val(tChildTotal);
	
	var tTeensMale = document.getElementById('tTeensMale').value;
	var tTeensFemale = document.getElementById('tTeensFemale').value;
	if(tTeensMale==''){tTeensMale = 0;}
	if(tTeensFemale==''){tTeensFemale = 0;}
	var tTeensTotal = parseInt(tTeensMale)+parseInt(tTeensFemale);
	$("#tTeensTotal").val(tTeensTotal);
	
	var tMan = document.getElementById('tMan').value;
	var tWoman = document.getElementById('tWoman').value;
	if(tMan==''){tMan = 0;}
	if(tWoman==''){tWoman = 0;}
	var tTotal = parseInt(tMan)+parseInt(tWoman);
	$("#tTotal").val(tTotal);
	
	var tElderMale = document.getElementById('tElderMale').value;
	var tElderFemale = document.getElementById('tElderFemale').value;
	if(tElderMale==''){tElderMale = 0;}
	if(tElderFemale==''){tElderFemale = 0;}
	var tElderTotal = parseInt(tElderMale)+parseInt(tElderFemale);
	$("#tElderTotal").val(tElderTotal);
	
	var tDisabledMale = document.getElementById('tDisabledMale').value;
	var tDisabledFemale = document.getElementById('tDisabledFemale').value;
	if(tDisabledMale==''){tDisabledMale = 0;}
	if(tDisabledFemale==''){tDisabledFemale = 0;}
	var tDisabledTotal = parseInt(tDisabledMale)+parseInt(tDisabledFemale);
	$("#tDisabledTotal").val(tDisabledTotal);

	var tMaleTotal = parseInt(tChildMale)+parseInt(tTeensMale)+parseInt(tMan)+parseInt(tElderMale)+parseInt(tDisabledMale);
	var tFemaleTotal = parseInt(tChildFemale)+parseInt(tTeensFemale)+parseInt(tWoman)+parseInt(tElderFemale)+parseInt(tDisabledFemale);
	var tSumTotal = parseInt(tMaleTotal)+parseInt(tFemaleTotal);
	
	$("#tMaleTotal").val(tMaleTotal);
	$("#tFemaleTotal").val(tFemaleTotal);
	$("#tSumTotal").val(tSumTotal);
});

//เงื่อนไขกลุ่มครอบครัว
//////////////////////////ตรวจสอบเงื่อนไขกลุ่มครอบครัวเดี่ยว
$('.rStructureFamily').click(function(){
	$(					"#rLargeFamily_21,#rLargeFamily_22,#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").attr('disabled','disabled');
});
$('.rStructureFamily').click(function(){
	$("#tMemberFamily_1,#tMemberMale_1,#tMemberFemale_1").removeAttr('disabled');
});
$('.rStructureFamily').click(function(){
	$("#rLargeFamily_21,#rLargeFamily_22").removeAttr('checked');
});
$('.rStructureFamily').click(function(){
	$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
});

$('.rStructureFamily').click(function(){
	$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
});
$('.rStructureFamily').click(function(){
	$("#tSpecialFamily_3").attr('disabled','disabled');
});
$('.rStructureFamily').click(function(){
	$("#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").removeAttr('checked');
});

/////////////////////////////ตรวจสอบเงื่อนไขกลุ่มครอบครัวขยาย
$('.rLargeFamily').click(function(){
	$("#tMemberFamily_1,#tMemberMale_1,#tMemberFemale_1,#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").attr('disabled','disabled');
});

$('.rLargeFamily').click(function(){
	$("#rLargeFamily_21,#rLargeFamily_22").removeAttr('disabled');
});

$('.rLargeFamily_23').click(function(){
	$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").removeAttr('disabled');
});
$('.rLargeFamily_24').click(function(){
	$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").removeAttr('disabled');
});
$('.rLargeFamily_24').click(function(){
	$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
});
$('.rLargeFamily_23').click(function(){
	$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
});
$('.rLargeFamily').click(function(){
	$("#tSpecialFamily_3").attr('disabled','disabled');
});
$('.rLargeFamily').click(function(){
	$("#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").removeAttr('checked');
});

///////////////////////////////////ตรวจสอบเงื่อนไขปุ่มครอบครัวพิเศษ
$('.rSpecialFamily').click(function(){
	$("#rLargeFamily_21,#rLargeFamily_22,#tMemberFamily_1,#tMemberMale_1,#tMemberFemale_1").attr('disabled','disabled');
});
$('.rSpecialFamily').click(function(){
	$("#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").removeAttr('disabled');	
});
$('.rSpecialFamily').click(function(){
	$("#rLargeFamily_21,#rLargeFamily_22").removeAttr('checked');
});
$('.rSpecialFamily').click(function(){
	$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
});
$('.rSpecialFamily').click(function(){
	$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
});
$('.rSpecialFamily_6').click(function(){
	$("#tSpecialFamily_3").removeAttr('disabled');
});
$('#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5').click(function(){
	$("#tSpecialFamily_3").attr('disabled','disabled');
});

/*------------------------------------ ตรวจสอบซ่อนข้อความ r15_2 r15_3 rStructureFamily rLargeFamily rSpecialFamily*/ 
$('#rStructureFamily').click(function(){
	$(".r15_2").hide();
	$(".r15_3").hide();
});

$('#rLargeFamily').click(function(){
	$(".r15_2").show();
	$(".r15_3").hide();
});

$('#rSpecialFamily').click(function(){
	$(".r15_2").hide();
	$(".r15_3").show();
});

//------------------------------------------------ 18 rDebt_1
$('#rDebt_1').click(function(){
	$('.t18').hide();
})

$('#rDebt_2').click(function(){
	$('.t18').show();
	//$('#rDebt_a').arr('checked',true);
	document.getElementById('rDebt_a').checked = true;
})

$('#rDebt_a').click(function(){
	$('#t18_a').show();
	$('#t18_b').hide();
})
$('#rDebt_b').click(function(){
	$('#t18_a').hide();//prop
	$('#t18_b').show();
})

});
    
</script> 

