<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Tanachai Khampukhew (tanachai@sapphire.co.th)
 * @created  10/09/2014
 * @access  public
 */
 ?>
<?php
	require_once('lib/nusoap.php'); 
	require_once("lib/class.function.php");
	$con = new Cfunction();
	$con->connectDB();
?>
<link rel="stylesheet" href="../css/style.css">
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
<script language="JavaScript">
function CreateXmlHttp(){
		//Creating object of XMLHTTP in IE
		try {
			XmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e){
			try{
				XmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			} 
			catch(oc) {
				XmlHttp = null;
			}
		}
		//Creating object of XMLHTTP in Mozilla and Safari 
		if(!XmlHttp && typeof XMLHttpRequest != "undefined") {
			XmlHttp = new XMLHttpRequest();
		}
	} // end function CreateXmlHttp
	
function chgAmphur(e, defa_v, tambon) {
		if ( e ) {
			document.getElementById('tParish').disabled = true;
			CreateXmlHttp();
			XmlHttp.open("get", "main/ajax.chgamphur.php?PvID="+e+"&DfVal="+defa_v, true);
			XmlHttp.onreadystatechange=function() {//alert("Aussy!!");
				if (XmlHttp.readyState==4) {
					
					if (XmlHttp.status==200) {
						var res = XmlHttp.responseText; //alert(res);
						document.getElementById("lblAmphur").innerHTML = res;
						chgTambon(defa_v, tambon);
					} else if (XmlHttp.status==404) {
						alert("ไม่สามารถทำการดึงข้อมูลได้");
					} else {
						alert("Error : "+XmlHttp.status);
					}
				}
			};
			XmlHttp.send(null);
			//chgTambon(e,'');
		}
	}
	
function chgTambon(e, defa_v) {
		if ( e ) {
			CreateXmlHttp();
			XmlHttp.open("get", "main/ajax.chgtambon.php?TbID="+e+"&DfVal="+defa_v, true);
			XmlHttp.onreadystatechange=function() {
				if (XmlHttp.readyState==4) {
					if (XmlHttp.status==200) {
						var res = XmlHttp.responseText; //alert(res);
						document.getElementById("lblTambon").innerHTML = res;
					} else if (XmlHttp.status==404) {
						alert("ไม่สามารถทำการดึงข้อมูลได้");
					} else {
						alert("Error : "+XmlHttp.status);
					}
				}
			};
			XmlHttp.send(null);
		}
}

function chgPreName(e) {
	if ( e ) {
			CreateXmlHttp();
			XmlHttp.open("get", "main/ajax.chkprename.php?pre="+e, true);
			XmlHttp.onreadystatechange=function() {
				if (XmlHttp.readyState==4) {
					if (XmlHttp.status==200) {
						var res = XmlHttp.responseText; //alert(res);
						document.getElementById("lblPreName").innerHTML = res;
					} else if (XmlHttp.status==404) {
						alert("ไม่สามารถทำการดึงข้อมูลได้");
					} else {
						alert("Error : "+XmlHttp.status);
					}
				}
			};
			XmlHttp.send(null);
		}
}

</script>

<?php
	$ws_client = $con->configIPSoap();
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
<style>
.style1{
	color:#F00;
}
</style>
<form action="main_exc/form1_exc.php" method="post" enctype="multipart/form-data" id="form1" name="form1" onSubmit="JavaScript:return fncSubmit();">
<table width="850" border="0">
<tbody>
	<tr>    
    	<td colspan="4" align="right" >ข้อมูลสำรวจ 
        <INPUT name="round" type="hidden" id="round" value="<?php if($_GET['rond']){echo $_GET['rond'];}else{echo 1;} ?>" size="1"  />
        ณ วันที่ <?php echo $con->_calendarTH('sDay','sMonth','sYear'); ?>
  	  </td>
      </tr>
    <tr>
   	  <td colspan="3" align="left"><b><u>ส่วนที่ 1</u></b> <b>รายละเอียดข้อมูลของครัวเรือน</b></td>
   	  <td width="246">
      </td>
    </tr>
    <tr>
      <td width="24" align="right">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td rowspan="5" align="center"><img src="../img/nopicture.gif" width="150" height="180" id="imgprvw" alt="uploaded image preview" name="pPicture">
        <input type="File" name="filUpload" id="filUpload" onChange="showimagepreview(this)" ></td>
    </tr>
    <tr>
      <td height="25" align="right">1.</td>
      <td height="25" colspan="2" valign="middle"><input type="hidden" name="cIDCard" value="1">
        เลขบัตรประจำตัวประชาชน<span class="style1"> *</span>
        <INPUT name="tIDCard" type="text" id="tIDCard" value="" size="30"  />        
        <span  id="idClassCheck" class="bIdCard">ตรวจสอบ</span>   <span  id="random2" class="bIdCard">สุ่มเลขบัตร</span></td>
      </tr>
    <tr>
      <td height="25" align="right">2.</td>
      <td height="25" colspan="2"><table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td width="24%">ชื่อหัวหน้าครอบครัว&nbsp;<span class="style1">*</span></td>
          <td width="24%">
          
          <select id="tPrename" name="tPrename" style="width:90%" onChange="chgPreName(this.value)" >
            <?php
				$sql_Prename = 'SELECT id,prename_th,gender FROM `tbl_prename` ORDER BY priority asc;';
				$results_Prename = $con->select($sql_Prename);
				foreach($results_Prename as $rd){
						echo '<option  value="'.$rd['id'].'">'.$rd['prename_th'].'</option>';
				}
			 ?>
		</select>
          
          </td>
          <td width="21%"><input name="tFirstname" type="text" value="" id="tFirstname" size="20"  /></td>
          <td width="10%" align="center">นามสกุล</td>
          <td width="21%"><input type="text" value=""  name="tLastname" id="tLastname" size="20"/></td>
        </tr>
      </table></td>
      </tr>
    <tr>
      <td height="25" align="right">3. </td>
      <td height="25" colspan="2">ที่อยู่อาศัย</td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td height="25" colspan="2" valign="middle"><table width="471" border="0" cellpadding="1" cellspacing="1">
        <tr>
          <td width="61" align="left">บ้านเลขที่</td>
          <td width="152"><INPUT type="text" value="" name="tAddress" style="width:90%" /></td>
          <td width="76" align="left">&nbsp;</td>
          <td width="151">&nbsp;</td>
          </tr>
        <tr>
          <td align="left">หมู่ที่ </td>
          <td><input type="text" value=""  name="tVillage" style="width:90%" /></td>
          <td align="left">ถนน </td>
          <td><input type="text" value="" name="tStreet" style="width:90%" /></td>
        </tr>
        <tr>
          <td align="left">จังหวัด <span class="style1">*</span></td>
          <td><!--<input type="text" value="" name="tProvince" />-->
          
          <select id="tProvince" name="tProvince" onChange = "chgAmphur(this.value);"  style="width:90%" >
            <?php
				$sql_Changwat = 'Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = \'Changwat\' ';
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					if($rd['ccDigi']==23000000)
					{
						echo '<option selected  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
					else
					{
						echo '<option  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
				}
			 ?>
		</select></td>
          <td align="left">อำเภอ <span class="style1">*</span></td>
          <td>
           <LABEL id="lblAmphur">
          	<select id="tDistrict" name="tDistrict" onChange = "chgTambon(this.value, '');" style="width:90%">
            <option value="">โปรดระบุ</option>
            <?php
				$sql_Changwat = "Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = 'Aumpur' AND areaid like '23%' AND ccName NOT LIKE '%*%'";
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					echo '<option  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
				}
			 ?>
            </select>
            </LABEL>
          
           <!--<input type="text" value="" name="tDistrict"/>--></td>
          </tr>
        <tr>
          <td align="left">ตำบล <span class="style1">*</span></td>
          <td><!--<input type="text" value=""  name="tParish"/>-->
          <LABEL id="lblTambon">
          <select id="tParish" name="tParish" style="width:90%">
          <option value="">โปรดระบุ</option>
          <?php
				$sql_Changwat = "Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = 'Tamboon' AND areaid like '23%' AND ccName NOT LIKE '%*%'";
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					echo '<option  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
				}
			 ?>
          </select>
          </LABEL></td>
          <td align="left">โทรศัพท์</td>
          <td><input type="text" value=""  name="tPhone" style="width:90%"/></td>
          </tr>
      </table>
      
      </td>
      </tr>
    <tr>
      <td height="25" align="right">4. </td>
      <td height="25" colspan="2">เพศ <span class="style1">*</span>
      <LABEL id="lblPreName"><input name="rSex" type="radio"  class="rSex" id="female"  value="1" checked  />1. หญิง&nbsp;<input type="radio"  value="2" class="rSex" name="rSex"  id="male" />2. ชาย
		<input type="hidden"  value="" id="etc_1" name=""   />
        <INPUT name="tSex" type="hidden" id="tSex" value="" size="30" />
        <INPUT name="chkSex" type="hidden" id="tSex" value="1" size="30" />
	</LABEL>
</td>
      <td align="center">&nbsp;</td>
      </tr>
    <tr>
      <td height="25" align="right">5. </td>
      <td height="25" colspan="2">วันเกิด <span class="style1">*</span> <?php echo $result; ?>  อายุ
        <INPUT name="tAge" type="text" id="tAge" value="" size="4" maxlength="4" class="numberOnly" />
ปี</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">6. </td>
      <td height="25" colspan="2">ประเภทของที่อยู่อาศัยในปัจจุบัน
        
        &nbsp;</td>
      <td height="25">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td height="25"><input name="rTypeHome" type="radio" class="rTypeHome"  id="m2"  value="1" checked />1. บ้านตัวเอง</td>
      <td height="25" colspan="2">	<input name="rTypeHome" type="radio"  value="4" id="rTypeHome_2"   class="rTypeHome"/>
        2. บ้านเช่า จ่ายค่าเช่า
<INPUT name="tTypeHome_2" type="text" id="tTypeHome_2" value="" size="10" class="numberOnly" />
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
      <td ><input    name="rEducation" type="radio"  id="rEducation_1"  value="1" checked/>
        ไม่ได้ศึกษา</td>
      <td width="282" ><input type="radio"  value="2"  id="rEducation_2"    name="rEducation"/>
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
      <td  colspan="2">อาชีพหลักของหัวหน้าครอบครัว <strong>(ตอบได้มากว่า 1 ข้อ) <span class="style1">*</span></strong></td>
      <td >&nbsp;</td>
    </tr>

    <!--<div class="careertable">-->
    <tr class="careertable">
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="checkbox"  value="1"  id="cCareer1"    name="cCareer[]" class="cCareer"/>
        1. รับจ้างทั่วไป</td>
      <td >        <input type="checkbox"  value="2"  id="cCareer2"    name="cCareer[]" class="cCareer"/>
      2. เกษตรกร </td>
      <td >&nbsp;</td>
    </tr>
    <tr class="careertable">
      <td height="25" align="right">&nbsp;</td>
      <td >        <input type="checkbox"  value="3"  id="cCareer3"    name="cCareer[]" class="cCareer"/>
      3. ประมง</td>
      <td >        <input type="checkbox"  value="4"  id="cCareer4"    name="cCareer[]" class="cCareer"/>
      4. ข้าราชการ/ลูกจ้างหรือพนักงานของรัฐ</td>
      <td >&nbsp;</td>
    </tr>
    <tr class="careertable">
      <td height="25" align="right">&nbsp;</td>
      <td >        <input type="checkbox"  value="5"  id="cCareer5"    name="cCareer[]" class="cCareer"/>
      5. พนักงานรัฐวิสาหกิจ</td>
      <td >        <input type="checkbox"  value="6"  id="cCareer6"    name="cCareer[]" class="cCareer"/>
      6. เจ้าหน้าที่องค์กรปกครองท้องถิ่น </td>
      <td >&nbsp;</td>
    </tr>
    <tr class="careertable">
      <td height="25" align="right">&nbsp;</td>
      <td >        <input type="checkbox"  value="7"  id="cCareer7"    name="cCareer[]" class="cCareer"/>
      7. ค้าขาย/ธุรกิจส่วนตัว</td>
      <td >        <input type="checkbox"  value="8"  id="cCareer8"    name="cCareer[]" class="cCareer"/>
      8. พนักงาน/ลูกจ้างเอกชน</td>
      <td >&nbsp;</td>
    </tr>
    <tr class="careertable">
      <td height="25" align="right">&nbsp;</td>
      <td width="280" >        <input type="checkbox"  value="9"  id="cCareer9"    name="cCareer[]" class="cCareer"/>
      9. ว่างงาน/ไม่มีงานทำ</td>
      <td  colspan="2">
        
        <input type="checkbox"  value="10"  id="cCareer10"    name="cCareer[]" class="cCareer"/>
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
        <input name="tLand" type="text" id="tLand" size="10" class="numberOnly" />
        ไร่</td>
      <td ><input    name="rLand" type="radio" class="rLand_1"  id="m34"  value="2" checked/>
        ไม่มี</td>
      <td >&nbsp;</td>
    </tr>
    <tr class="careertable">
      <td height="25" align="right">12. </td>
      <td  colspan="3">รายได้เฉลี่ยของครอบครัว จำนวน
        <input name="tIncome" type="text" value="" size="10" id="tIncome" class="numberOnly" />
        บาท (ต่อปี)<strong> (รายได้คิดจากสมาชิกที่มีรายได้ร่วมกัน) <span class="style1">*</span></strong></td>
      </tr>
    <tr>
      <td height="25" align="right">13. </td>
      <td  colspan="2">ศาสนาหลักของครอบครัว</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><input name="rReligion" type="radio" class="rReligion"  id=""  value="1" checked/>
        1. พุทธ
        &nbsp;
        <input type="radio"  value="2" id="" name="rReligion"  class="rReligion"/>
        2. คริสต์
        <input type="radio"  value="3"  id="" name="rReligion"   class="rReligion"/>
        3. อิสลาม
        &nbsp;
        <input type="radio"  value="4"  name="rReligion"  class="rReligion_1" id="rReligion_2"/>
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
      <td ><input name="rStatus" type="radio"  class="rStatus"  value="1" checked />
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
    <tr id="t15_detail_1">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><input  name="rStructureFamily" type="radio" class="rStructureFamily" id="rStructureFamily"  value="1" checked/>
        1. ครอบครัวเดียว จำนวนสมาชิก
<input type="text" value="" size="4" maxlength="4" name="tMemberFamily_1" id="tMemberFamily_1" style="background:#EBEBE4" readonly/>
        คน ชาย
  <input type="text" value="" size="4" maxlength="4" name="tMemberMale_1" id="tMemberMale_1" class="numberOnly"/>
        คน หญิง
  <input type="text" value="" size="4" maxlength="4" name="tMemberFemale_1" id="tMemberFemale_1" class="numberOnly"/>
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
    <tr class="r15_2" id="t15_detail_2_1">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><dd> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จำนวนสมาชิก
        <input type="text" value="" size="4" maxlength="4" name="tMemberFamily_2_1" id="tMemberFamily_2_1" style="background:#EBEBE4" readonly/>
        คน ชาย
        <input type="text" value="" size="4" maxlength="4" name="tMemberMale_2_1" id="tMemberMale_2_1" class="numberOnly" />
        คน หญิง
        <input type="text" value="" size="4" maxlength="4" name="tMemberFemale_2_1" id="tMemberFemale_2_1" class="numberOnly" />
        &nbsp;คน </dd></td>
    </tr>
    <tr class="r15_2">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3"><dd>
        <input type="radio"  value="2" id="rLargeFamily_22" name="rLargeFamily" class="rLargeFamily_24"  />
        2.2 ครอบครัวขยายที่ประกอบด้วยหลาย ๆ ครัวเรือนอยู่ร่วมกัน แต่ละครัวเรือน <u>มีความอิสระต่อกัน</u>ในการดำเนินชีวิตครอบครัวของตนเอง </dd></td>
    </tr>
    <tr class="r15_2" id="t15_detail_2_2">
      <td height="25" align="right">&nbsp;</td>
      <td  colspan="3" valign="top"><dd> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จำนวนสมาชิก
        <input type="text" value="" size="4" maxlength="4"  name="tMemberFamily_2_2" id="tMemberFamily_2_2" style="background:#EBEBE4" readonly/>
        คน ชาย
        <input type="text" value="" size="4" maxlength="4" name="tMemberMale_2_2" id="tMemberMale_2_2" class="numberOnly" />
        คน หญิง
        <input type="text" value="" size="4" maxlength="4"  name="tMemberFemale_2_2" id="tMemberFemale_2_2" class="numberOnly"/>
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
      <td width="280" ><input name="rDefective" type="radio"  id="rDefective_1"  value="1" checked  />1. ไม่มี</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td ><input type="radio"  value="2"  id="rDefective_2"  name="rDefective"/>2. จำนวน<input type="text" value="" size="4" maxlength="4" name="tDefective" id="tDefective" style="background:#EBEBE4" readonly>คน โปรดระบุ </td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      </tr>
      
    <tr id="t16_detail">
      <td height="25" align="right">&nbsp;</td>
      <td colspan="3"><dd>
        <table>
          <tr>
            <td>จำนวนเด็กเล็ก (0-4ปี)</td>
            <td><input type="text" value="" size="4" maxlength="4" name="tChild" id="tChild" class="numberOnly" />
              คน</td>
            </tr>
          <tr>
            <td>จำนวนผู้พิการ</td>
            <td><input type="text" value="" size="4" maxlength="4"  name="tDisabled" id="tDisabled" class="numberOnly" />
              คน</td>
            </tr>
          <tr>
            <td>จำนวนผู้ป่วยทางจิต</td>
            <td><input type="text" value="" size="4" maxlength="4" name="tMindSick" id="tMindSick" class="numberOnly" />
              คน</td>
            </tr>
          <tr>
            <td>จำนวนผู้ป่วยเรื้อรัง</td>
            <td><input type="text" value="" size="4" maxlength="4"  name="tSick" id="tSick" class="numberOnly"/>
              คน</td>
            </tr>
          <tr>
            <td>จำนวนผู้สูงอายุ</td>
            <td><input type="text" value="" size="4" maxlength="4" name="tElderly" id="tElderly" class="numberOnly" />
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
      <td colspan="3"><table width="50%" border="0" cellpadding="1" cellspacing="0" id="t17">
        <thead>
          <tr>
            <th width="30%" height="25"  bgcolor="#f2f2f2">ประเภท</th>
            <th width="10%"  bgcolor="#f2f2f2">ชาย</th>
            <th width="10%"  bgcolor="#f2f2f2">หญิง</th>
            <th width="10%"  bgcolor="#f2f2f2">รวม</th>
            </tr>
          </thead>
        <tr>
          <td width="184" height="25"  align="left">&nbsp;1. เด็ก (อายุ 0-18 ปี)</td>
          <td width="202"  align="center"><input  name="tChildMale" type="text" id="tChildMale"  style=" width:80%" maxlength="4"/></td>
          <td width="202"  align="center"><input name="tChildFemale" type="text" id="tChildFemale"  style=" width:80%" maxlength="4" /></td>
          <td  align="center"><input name="tChildTotal" type="text" id="tChildTotal"  style=" width:80%; background:#CCC;" value="0" maxlength="4" readonly /></td>
          </tr>
        <tr>
          <td width="184" height="25"  align="left">&nbsp;2. เยาวชน (อายุ 19-25 ปี)</td>
          <td width="202"  align="center"><input name="tTeensMale" type="text" id="tTeensMale"  style=" width:80%" maxlength="4"  /></td>
          <td width="202"  align="center"><input name="tTeensFemale" type="text" id="tTeensFemale"  style=" width:80%" maxlength="4" /></td>
          <td  align="center"><input name="tTeensTotal" type="text" id="tTeensTotal"  style=" width:80%; background:#CCC;" value="0" maxlength="4" readonly /></td>
          </tr>
        <tr>
          <td width="184" height="25"  align="left">&nbsp;3. ผู้อาศัยทั่วไป (อายุ 26-59 ปี)</td>
          <td width="202"  align="center"><input name="tMan" type="text" id="tMan"  style=" width:80%" maxlength="4" /></td>
          <td width="202"  align="center"><input name="tWoman" type="text" id="tWoman"  style=" width:80%" maxlength="4" /></td>
          <td  align="center"><input name="tTotal" type="text" id="tTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly /></td>
          </tr>
        <tr>
          <td width="184" height="25"  align="left">&nbsp;4. ผู้สูงอายุ (อายุ 60 ปี)</td>
          <td width="202"  align="center"><input name="tElderMale" type="text" id="tElderMale"  style=" width:80%" maxlength="4" /></td>
          <td width="202"  align="center"><input name="tElderFemale" type="text" id="tElderFemale"  style=" width:80%" maxlength="4" /></td>
          <td  align="center"><input name="tElderTotal" type="text" id="tElderTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly /></td>
          </tr>
        <tr>
          <td width="184" height="25"  align="left">&nbsp;5. คนพิการ</td>
          <td width="202"  align="center"><input name="tDisabledMale" type="text" id="tDisabledMale"  style=" width:80%" maxlength="4" /></td>
          <td width="202"  align="center"><input name="tDisabledFemale" type="text" id="tDisabledFemale"  style=" width:80%" maxlength="4"  /></td>
          <td  align="center"><input name="tDisabledTotal" type="text" id="tDisabledTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly  /></td>
          </tr>
        <tr>
          <td width="184" height="25"  align="center">รวมทั้งสิ้น</td>
          <td width="202"  align="center"><input name="tMaleTotal" type="text" id="tMaleTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly  /></td>
          <td width="202"  align="center"><input name="tFemaleTotal" type="text" id="tFemaleTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly /></td>
          <td  align="center"><input name="tSumTotal" type="text" id="tSumTotal"  style=" width:80%;background:#CCC;" value="0" maxlength="4" readonly /></td>
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
      <td  valign="top"><input   name="rDebt" type="radio"  id="rDebt_1"  value="1" checked/> 1. ไม่มี</td>
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
          <td width="20"><input name="c18[]" type="checkbox" id="2_2_1" value="1"></td>
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
          <td><input name="c18[]" type="checkbox" value="2" id="2_2_2"></td>
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
          <td><input name="c18[]" type="checkbox" id="2_2_3" value="3"></td>
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
        <tr >
          <td><input name="c18[]" type="checkbox" id="2_2_4" value="4"></td>
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
          <td><input name="c18[]" type="checkbox" id="2_2_5" value="5"></td>
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
          <td><input name="c18[]" type="checkbox" id="2_2_6" value="6"></td>
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
          <td><input name="c18[]" type="checkbox" id="2_2_7" value="7"></td>
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
          <td><input name="c18[]" type="checkbox" id="2_2_8" value="8"></td>
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
          <td><input name="c18[]" type="checkbox" id="2_2_9" value="9"></td>
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
      <td colspan="3" align="right"><button> ดำเนินการต่อ </button></td>
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

<script src="../js/CheckIdCardThai.min.js"></script>
<script src="../js/AgeCalculate.min.js"></script>
<script  type="text/javascript">


function fncSubmit()
{
	
	if(document.getElementById('cCareer1').checked==false && document.getElementById('cCareer2').checked==false && document.getElementById('cCareer3').checked==false && document.getElementById('cCareer4').checked==false && document.getElementById('cCareer5').checked==false && document.getElementById('cCareer6').checked==false && document.getElementById('cCareer7').checked==false && document.getElementById('cCareer8').checked==false && document.getElementById('cCareer9').checked==false && document.getElementById('cCareer10').checked==false)
	{
		alert('กรุณาเลือกอาชีพ หรือ ระบุอาชีพไม่ถูกต้อง');
		document.form1.tCareer.focus();
		return false;
	}
	if(document.form1.chkSex.value == 0)
	{
		alert('กรุณากรอกเลือกเพศ');
		document.form1.tIDCard.focus();
		return false;
	}
	
	if(document.form1.tIDCard.value == "")
	{
		alert('กรุณากรอกบัตรประชาชน หรือ คลิกที่สุ่มบัตรประชาชน');
		document.form1.tIDCard.focus();
		return false;
	}
	
	if(document.form1.tFirstname.value == "")
	{
		alert('กรุณากรอกชื่อหัวหน้าครอบครัว');
		document.form1.tFirstname.focus();
		return false;
	}
	
	if(document.form1.tLastname.value == "")
	{
		alert('กรุณากรอกนามสกุล');
		document.form1.tLastname.focus();
		return false;
	}

	if(document.form1.tAge.value == "")
	{
		alert('กรุณากรอกจำนวนอายุ หรือ วันเกิด');
		document.form1.tAge.focus();
		return false;
	}
	
	

	var result = $('#tIDCard').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
	} else {
		alert('เลขบัตรประชาชนนี้ไม่ถูกต้อง');
		document.form1.tIDCard.focus();
		return false;
	}
}

function tbirtday(e)
{
	alert(e);
}

$(document).ready(function () {	

/*$('#tbirthday').keydown(function(e){
	var oEvent = (window.event) ? window.event : e; 
			var Obj = document.getElementById('tbirthday');
			if ( Obj.value.length == 2 || Obj.value.length == 5) {
				Obj.value = Obj.value + "/";
			}
});*/

/*----------------------------------------------------------- เชคบัตรประชาชน*/
 $('#idClassCheck').click(function() {
	var result = $('#tIDCard').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
		alert('เลขบัตรประชาชนนี้ถูกต้อง');
	} else {
		alert('เลขบัตรประชาชนนี้ไม่ถูกต้อง');
	}
});

$('#random2').click(function() {
	$('#tIDCard').RandomIdCardThai({firstNum: '0'});
 });
 
/*----------------------------------------------------------- ตรวจสอบตัวเลข*/
$(".numberOnly").keydown(function(e){
	if (e.shiftKey) 
           e.preventDefault();
       else 
       {
           var nKeyCode = e.keyCode;
           //Ignore Backspace and Tab keys
           if (nKeyCode == 8 || nKeyCode == 9)
               return;
           if (nKeyCode < 95) 
           {
               if (nKeyCode < 48 || nKeyCode > 57)
                   e.preventDefault();
           }
           else 
           {
               if (nKeyCode < 96 || nKeyCode > 105) 
               e.preventDefault();
           }
       }
});

/*----------------------------------------------------------- คำนวนเลขในข้อ 16 */
$("#t16_detail input").keyup(function (){
	var tChild = document.getElementById('tChild').value;
	var tDisabled = document.getElementById('tDisabled').value;
	var tMindSick = document.getElementById('tMindSick').value;
	var tSick = document.getElementById('tSick').value;
	var tElderly = document.getElementById('tElderly').value;
	
	if(tChild==''){tChild = 0;}
	if(tDisabled==''){tDisabled = 0;}
	if(tMindSick==''){tMindSick = 0;}
	if(tSick==''){tSick = 0;}
	if(tElderly==''){tElderly = 0;}

	var tDefective = parseInt(tChild)+parseInt(tDisabled)+parseInt(tMindSick)+parseInt(tSick)+parseInt(tElderly);
	$("#tDefective").val(tDefective);
});

/*----------------------------------------------------------- คำนวนเลขในข้อ 15 */
$("#t15_detail_1 input").keyup(function (){
	var tMemberMale_1 = document.getElementById('tMemberMale_1').value;
	var tMemberFemale_1 = document.getElementById('tMemberFemale_1').value;
	if(tMemberMale_1==''){tMemberMale_1 = 0;}
	if(tMemberFemale_1==''){tMemberFemale_1 = 0;}
	var tMemberFamily_1 = parseInt(tMemberMale_1)+parseInt(tMemberFemale_1);
	$("#tMemberFamily_1").val(tMemberFamily_1);
});

$("#t15_detail_2_1 input").keyup(function (){
	var tMemberMale_2_1 = document.getElementById('tMemberMale_2_1').value;
	var tMemberFemale_2_1 = document.getElementById('tMemberFemale_2_1').value;
	if(tMemberMale_2_1==''){tMemberMale_2_1 = 0;}
	if(tMemberFemale_2_1==''){tMemberFemale_2_1 = 0;}
	var tMemberFamily_2_1 = parseInt(tMemberMale_2_1)+parseInt(tMemberFemale_2_1);
	$("#tMemberFamily_2_1").val(tMemberFamily_2_1);
});

$("#t15_detail_2_2 input").keyup(function (){
	var tMemberMale_2_2 = document.getElementById('tMemberMale_2_2').value;
	var tMemberFemale_2_2 = document.getElementById('tMemberFemale_2_2').value;
	if(tMemberMale_2_2 ==''){tMemberMale_2_2 = 0;}
	if(tMemberFemale_2_2 ==''){tMemberFemale_2_2 = 0;}
	var tMemberFamily_2_2 = parseInt(tMemberMale_2_2)+parseInt(tMemberFemale_2_2);
	$("#tMemberFamily_2_2").val(tMemberFamily_2_2);
});

$("#tSex").attr('disabled','disabled');	
$("#tTypeHome_2").attr('disabled','disabled');
$("#tTypeHome_4").attr('disabled','disabled');
$("#tCareer").attr('disabled','disabled');
$("#tLand").attr('disabled','disabled');
$("#tReligion_1").attr('disabled','disabled');
/*$("#tMemberFamily_1,#tMemberMale_1,#tMemberFemale_1").attr('disabled','disabled');*/
$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
$("#tSpecialFamily_3").attr('disabled','disabled');
//ซ่อนฟอร์มการกู้เงินในระบบ
$('#t18_2_1_1').hide();
$('#t18_2_1_2').hide();
$('#t18_2_1_3').hide();
$('#t18_2_1_4').hide();
$('#t18_2_1_5').hide();
$('#t18_2_1_6').hide();
$('#t18_2_1_7').hide();
$('#t18_2_1_8').hide();
$('#t18_2_1_9').hide();

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

/*----------------------------------------------------------- คำนวนวันเกิด*/
$("#tbirthday").change(function () {
	var result = calAge(document.getElementById('tbirthday').value);
	document.getElementById('tAge').value = result[0];
});


$("#tAge").keyup(function() {
 var tAge = document.getElementById('tAge').value ;
 var ttAge = <?php echo $dt = date('Y') + 543;?> - tAge ;
 var showDate = "01/01/" + ttAge ;
 document.getElementById('tbirthday').value = showDate;
 
});

//ส่วนของการตรวจสอบเงื่อนไขการDisabled 
//ตรวจสอบเงื่อนไขกลุ่มเพศ
$('.rSex').click(function(){
	$("#tSex").attr('disabled','disabled');
	document.getElementById('chkSex').value = 1;
});

$('#etc_1').click(function(){
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

$('.careertable input:not(#cCareer9)').click(function(){
	if($('.careertable input:not(#cCareer9)').is(':checked') == true){
		$('#cCareer9').attr('disabled','disabled')
		$('#cCareer9').removeAttr('checked')
	}
	if($('.careertable input:not(#cCareer9)').is(':checked') == false){
		$('#cCareer9').removeAttr('disabled')
	}
});

$('#cCareer9').click(function(){
		 if($('.careertable input:not(#cCareer9)').attr('disabled')){ //ถ้าใช่
			$('.careertable input:not(#cCareer9,#tCareer)').removeAttr('disabled')
		 }else{
			$('.careertable input:not(#cCareer9)').attr('disabled','disabled')
			$('.careertable input:not(#cCareer9)').removeAttr('checked')
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
	 document.getElementById('tChildTotal').value = tChildTotal;
	//$("#tChildTotal").val(tChildTotal);
	
	var tTeensMale = document.getElementById('tTeensMale').value;
	var tTeensFemale = document.getElementById('tTeensFemale').value;
	if(tTeensMale==''){tTeensMale = 0;}
	if(tTeensFemale==''){tTeensFemale = 0;}
	var tTeensTotal = parseInt(tTeensMale)+parseInt(tTeensFemale);
	document.getElementById('tTeensTotal').value = tTeensTotal;
	//$("#tTeensTotal").val(tTeensTotal);
	
	var tMan = document.getElementById('tMan').value;
	var tWoman = document.getElementById('tWoman').value;
	if(tMan==''){tMan = 0;}
	if(tWoman==''){tWoman = 0;}
	var tTotal = parseInt(tMan)+parseInt(tWoman);
	document.getElementById('tTotal').value = tTotal;
	//$("#tTotal").val(tTotal);
	
	var tElderMale = document.getElementById('tElderMale').value;
	var tElderFemale = document.getElementById('tElderFemale').value;
	if(tElderMale==''){tElderMale = 0;}
	if(tElderFemale==''){tElderFemale = 0;}
	var tElderTotal = parseInt(tElderMale)+parseInt(tElderFemale);
	document.getElementById('tElderTotal').value = tElderTotal;
	//$("#tElderTotal").val(tElderTotal);
	
	var tDisabledMale = document.getElementById('tDisabledMale').value;
	var tDisabledFemale = document.getElementById('tDisabledFemale').value;
	if(tDisabledMale==''){tDisabledMale = 0;}
	if(tDisabledFemale==''){tDisabledFemale = 0;}
	var tDisabledTotal = parseInt(tDisabledMale)+parseInt(tDisabledFemale);
	document.getElementById('tDisabledTotal').value = tDisabledTotal;
	//$("#tDisabledTotal").val(tDisabledTotal);

	var tMaleTotal = parseInt(tChildMale)+parseInt(tTeensMale)+parseInt(tMan)+parseInt(tElderMale)+parseInt(tDisabledMale);
	var tFemaleTotal = parseInt(tChildFemale)+parseInt(tTeensFemale)+parseInt(tWoman)+parseInt(tElderFemale)+parseInt(tDisabledFemale);
	var tSumTotal = parseInt(tMaleTotal)+parseInt(tFemaleTotal);
	
	document.getElementById('tMaleTotal').value = tMaleTotal;
	document.getElementById('tFemaleTotal').value = tFemaleTotal;
	document.getElementById('tSumTotal').value = tSumTotal;
	//$("#tMaleTotal").val(tMaleTotal);
	//$("#tFemaleTotal").val(tFemaleTotal);
	//$("#tSumTotal").val(tSumTotal);
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
	if($('#rDebt_1').is(':checked') == true){
		$('#t18_a').hide();
		$('#t18_b').hide();
		$('.t18').hide();
	}

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
//กู้เงินในระบบและนอกระบบ
 if($('.t18 input:not(#rDebt_a)').is(':checked') == true){
	 $('.t21').hide();
 }
 if($('.t18 input:not(#rDebt_b)').is(':checked') == true){
	 $('.t22').hide();
 }
//เงินกู้ธนาคาร
$('#2_2_1').click(function(){
	if($('#2_2_1').attr('checked')){
		$('#t18_2_1_1').show();
	}
	else{
		$('#t18_2_1_1').hide();
	}
})
//เงินกู้กองทุนสัจจะสะสมทรัพย์
$('#2_2_2').click(function(){
	if($('#2_2_2').attr('checked')){
		$('#t18_2_1_2').show();
	}
	else{
		$('#t18_2_1_2').hide();
	}
})
//เงินกู้กองทุนหมู่บ้าน
$('#2_2_3').click(function(){
	if($('#2_2_3').attr('checked')){
		$('#t18_2_1_3').show();
	}
	else{
		$('#t18_2_1_3').hide();
	}
})
//กองทุนพัฒนาบทบาทสตรี
$('#2_2_4').click(function(){
	if($('#2_2_4').attr('checked')){
		$('#t18_2_1_4').show();
	}
	else{
		$('#t18_2_1_4').hide();
	}
})
//กองทุนผู้สูงอายุ
$('#2_2_5').click(function(){
	if($('#2_2_5').attr('checked')){
		$('#t18_2_1_5').show();
	}
	else{
		$('#t18_2_1_5').hide();
	}
})
//กองทุนส่งเสริมพัฒนาคุณภาพชีวิตคนพิการ
$('#2_2_6').click(function(){
	if($('#2_2_6').attr('checked')){
		$('#t18_2_1_6').show();
	}
	else{
		$('#t18_2_1_6').hide();
	}
})
//กองทุนปุ๋ย
$('#2_2_7').click(function(){
	if($('#2_2_7').attr('checked')){
		$('#t18_2_1_7').show();
	}
	else{
		$('#t18_2_1_7').hide();
	}
})
//กองทุนเกษตร
$('#2_2_8').click(function(){
	if($('#2_2_8').attr('checked')){
		$('#t18_2_1_8').show();
	}
	else{
		$('#t18_2_1_8').hide();
	}
})
//อื่นๆระบุ
$('#2_2_9').click(function(){
	if($('#2_2_9').attr('checked')){
		$('#t18_2_1_9').show();
	}
	else{
		$('#t18_2_1_9').hide();
	}
})
//ระบุกองทุนกู้ยืมอื่นๆ
$('#2_2_9').click(function(){
	if($('#2_2_9').attr('checked')){
		$('#t21_other').removeAttr('disabled');;
	}
	else{
		$('#t21_other').attr('disabled','disabled');
	}
})

});
    
</script> 

