<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>ตรวจสอบข้อผิดพลาดการบันทึกข้อมูล</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
    <style type="text/css">

    .mouseOut {
    background: #708090;
    color: #FFFAFA;
    }

    .mouseOver {
    background: #FFFAFA;
    color: #000000;
    }
    
	body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<script language="javascript">

function CheckF1(){
	if(document.form1.kp7file.value != "" && document.form1.comment_upload.value == "" ){
		alert("กรณีเลือกไฟล์แนบผลการ QC เอกสาร ก.พ.7 ให้ระบุหมายเหตุด้วย");
		document.form1.comment_upload.focus();
		return false;
			
	}	
	return true;
} 

	function UncheckTrue(){
		var xi = document.form1.xch.value;
		if( xi > 0){
				for(i=0;i<xi; i++){
					document.getElementById("chData"+i).checked = false;
				}
		}//end if( xi > 0){
		
	}
	
function showEle(divname){
	if(document.getElementById(divname).style.display == 'none'){
		document.getElementById(divname).style.display = 'block';
	} else {  
		document.getElementById(divname).style.display = 'none';
	}
}


function confirmDelete(delUrl) {
  if (confirm("คุณแน่ใจที่จะลบข้อมูลใช่หรือไม่?")) {
    document.location = delUrl;
  }
}

</script>


</head>
<body>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="return CheckF1();">
  <br />
  <table width="95%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td align="left">&nbsp;<b>บันทึกผลการตรวจสอบการคีย์ข้อมูลของพนักงาน ชื่อ</b> นางสาวพิมพร หันธนู   <strong>วันที่คีย์ข้อมูล : 4 เม.ย. 2555 เวลา 09:57:58น.</strong></td>
            </tr>
            <tr>
              <td align="left"><b>ข้อมูลของ :</b> สมเกียรติ  กระจ่างพันธ์&nbsp;<b>รหัสบัตรประชาชน :</b>3160200018373 
</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="4" align="center" bgcolor="#F4F4F4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                                          <td width="26%" align="right">วันที่ QC : </td>
                      <td width="39%" align="left"><INPUT name="qc_date" onFocus="blur();" value="" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.qc_date, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
                      <td width="35%" align="left">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="right">พนักงาน QC : </td>
                      <td align="left"><select name="qc_staffid" id="qc_staffid">
            <option value="">เลือกชื่อพนักงานQC</option>
            <option value='10761' >นางสาวกรรณิการ์  ยาตา</option><option value='10935' >นางสาวกาญจนา  ดวงติ๊บ</option><option value='10936' >นางสาวกาญจนา  คงนิยม</option><option value='11152' >นางสาวจารุวรรณ  งามเมือง</option><option value='11745' >นางสาวจำปี   อารยะไพฑูรย์</option><option value='10660' >นางสาวณัฎฐนันทน์  ค้าโค</option><option value='11759' >นายธีระยุทธ  สุวรรณา</option><option value='11417' >นางสาวประกายวรรณ  เงินคำจันทร์</option><option value='11283' >นางสาวปิยวรรณ  อาลี ( QC_WORD)</option><option value='11329' >นางสาวพัชรีพรรณ  เงินปุ่นนาค (Fulltime)</option><option value='11834' >นายพินิจ  สมมะโน</option><option value='11560' >นางสาวพิมพร  หันธนู</option><option value='10613' >นางสาวภานิศา  คีรีสัตยกุล</option><option value='11549' >นางสาวรัติพร  สุรินทร์</option><option value='10591' >นางสาวอรพินธ์  จั่นแก้ว</option><option value='11330' >นางสาวอัจฉราพร  รินฟอง (QC WORD)</option><option value='11037' >นางสาวอาภาพร  ชัยสุรินทร์</option><option value='11827' >นางสาวอุบล  บัวดาบติ๊บ</option><option value='10767' >นางสาวเกศศิริ  อินต๊ะวงศ์</option><option value='11503' >นางสาวเชษฐ์สุดา  ดอนปา</option><option value='10559' >นางสาวเอมิกา  บัวจันทร์</option>            </select></td>
                      <td align="left">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><strong>ประวัติพนักงานคีย์เอกสาร : </strong></td>
                      <td colspan="2" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                            <tr>
                              <td colspan="4" align="center" bgcolor="#CCCCCC"><strong>ประวัติการบันทึกเอกสาร ก.พ.7 ของพนักงานบันทึกข้อมูล</strong></td>
                              </tr>
                            <tr>
                              <td width="7%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
                              <td width="38%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล พนักงานบันทึกข้อมูล</strong></td>
                              <td width="43%" align="center" bgcolor="#CCCCCC"><strong>วันที่ทำการบันทึกข้อมูล</strong></td>
                              <td width="12%" align="center" bgcolor="#CCCCCC"><strong>เลือกหักจุดผิด</strong></td>
                            </tr>
                                                        <tr bgcolor="#FFFFFF">
                              <td align="center">1</td>
                              <td align="left">นายณัฐนพงษ์  เดชมณี</td>
                              <td align="left">3 เม.ย. 2555 เวลา 14:26:22น.</td>
                              <td align="center"><input type="radio" name="staff_subtract" id="staff_1" value="11140"  checked='checked' ></td>
                            </tr>
                                                      </table></td>
                        </tr>
                      </table></td>
                      </tr>
                     
                    <tr>
                      <td colspan="3" align="left"><em>หมายเหตุ : ค่าคะแนนความผิดพลาดของการคีย์ข้อมูลที่ท่าน QC จะเป็นของวันที่ 4 เม.ย. 2012 หากเดือนที่ท่าน QC เป็นคนละเดือนกับที่คีย์ข้อมูลกรุณาแจ้งผู้ดูแลระบบเนื่องจากจะมีผลการการคำนวณค่า Incentive</em> &nbsp; คลิ๊กเลือกเพื่อแจ้งผู้ดูแลระบบ 
                        <input type="checkbox" name="sent_admin" id="sent_admin" value="1"  ></td>
                      </tr>
                  </table></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td width="4%" align="center" bgcolor="#F4F4F4"><strong>ลำดับ</strong></td>
              <td width="49%" align="center" bgcolor="#F4F4F4"><strong>หมวดรายการ</strong></td>
              <td width="15%" align="center" bgcolor="#F4F4F4"><strong>จำนวนจุดผิด</strong></td>
              <td width="32%" align="center" bgcolor="#F4F4F4"><strong>ประเภทปัญหา</strong></td>
            </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">1</td>
              <td align="left">
                ข้อมูลทั่วไป</td>
              <td align="center">&nbsp;</td>
              <td align="left"></td>
            </tr>
            <tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData0" value='5' >&nbsp;พิมพ์คำผิด/พิมพ์ไม่ครบบรรทัด ตาม ก.พ.7</td><td align='center'><input name="num_point[5]" type="text" id="num_point0" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData1" value='6' >&nbsp;ไม่ระบุประวัติ การเปลี่ยนชื่อ-นามสกุล</td><td align='center'><input name="num_point[6]" type="text" id="num_point1" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData2" value='7' >&nbsp;การเรียงลำดับ ชื่อ-นามสกุล ไม่ถูกต้องตรงตาม ก.พ.7</td><td align='center'><input name="num_point[7]" type="text" id="num_point2" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData3" value='8' >&nbsp;ระบุรูปแบบการแสดงผลไม่ถูกต้อง</td><td align='center'><input name="num_point[8]" type="text" id="num_point3" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData4" value='44' >&nbsp;ระบุคำนำหน้าชื่อผิด</td><td align='center'><input name="num_point[44]" type="text" id="num_point4" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData5" value='53' >&nbsp;เลือกประเภทข้าราชการผิด</td><td align='center'><input name="num_point[53]" type="text" id="num_point5" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData6" value='59' >&nbsp;สถานะภาพสมรสไม่ได้ระบุ</td><td align='center'><input name="num_point[59]" type="text" id="num_point6" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData7" value='151' >&nbsp;การระบุสถานะการเป็นสมาชิก กบข.</td><td align='center'><input name="num_point[151]" type="text" id="num_point7" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData8" value='155' >&nbsp;เลือกตำแหน่ง , ระดับ การเริ่มรับราชการผิด</td><td align='center'><input name="num_point[155]" type="text" id="num_point8" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr>            <tr bgcolor="#F0F0F0">
              <td align="center">2</td>
              <td align="left">
                การบรรจุเข้ารับราชการ</td>
              <td align="center">&nbsp;</td>
              <td align="left"></td>
            </tr>
            <tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData9" value='20' >&nbsp;พิมพ์คำผิด/พิมพ์ไม่ครบบรรทัด ตาม ก.พ.7</td><td align='center'><input name="num_point[20]" type="text" id="num_point9" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData10" value='67' >&nbsp;ไม่ได้กรอก label</td><td align='center'><input name="num_point[67]" type="text" id="num_point10" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData11" value='68' >&nbsp;เลือกรูปแบบการแสดงผลผิด</td><td align='center'><input name="num_point[68]" type="text" id="num_point11" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr>            <tr bgcolor="#FFFFFF">
              <td align="center">3</td>
              <td align="left">
                ประวัติการศึกษา</td>
              <td align="center">&nbsp;</td>
              <td align="left"></td>
            </tr>
            <tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData12" value='21' >&nbsp;เลือกระดับการศึกษาผิด</td><td align='center'><input name="num_point[21]" type="text" id="num_point12" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData13" value='22' >&nbsp;พ.ศ.ช่อง label ไม่ตรงกับช่อง value</td><td align='center'><input name="num_point[22]" type="text" id="num_point13" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData14" value='50' >&nbsp;พิมพ์คำผิด</td><td align='center'><input name="num_point[50]" type="text" id="num_point14" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData15" value='52' >&nbsp;เลือกวุฒิการศึกษาผิด</td><td align='center'><input name="num_point[52]" type="text" id="num_point15" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData16" value='54' >&nbsp;กรอกจุดตัวย่อผิด</td><td align='center'><input name="num_point[54]" type="text" id="num_point16" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData17" value='58' >&nbsp;เลือกสาขาผิด</td><td align='center'><input name="num_point[58]" type="text" id="num_point17" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData18" value='61' >&nbsp;กรอกข้อมูลไม่ครบ</td><td align='center'><input name="num_point[61]" type="text" id="num_point18" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData19" value='66' >&nbsp;เลือกสถานศึกษาผิด</td><td align='center'><input name="num_point[66]" type="text" id="num_point19" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData20" value='72' >&nbsp;กรอกข้อมูลการศึกษาเกิน</td><td align='center'><input name="num_point[72]" type="text" id="num_point20" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData21" value='125' >&nbsp;ไม่ได้เรียงลำดับข้อมูล</td><td align='center'><input name="num_point[125]" type="text" id="num_point21" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr>            <tr bgcolor="#F0F0F0">
              <td align="center">4</td>
              <td align="left">
                ตำแหน่งและอัตราเงินเดือน</td>
              <td align="center">&nbsp;</td>
              <td align="left"></td>
            </tr>
            <tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData22" value='23' >&nbsp;พิมพ์คำผิด</td><td align='center'><input name="num_point[23]" type="text" id="num_point22" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData23" value='38' >&nbsp;ช่อง label ไม่ตรงกับช่อง value/ไม่ได้เคาะว่าง</td><td align='center'><input name="num_point[38]" type="text" id="num_point23" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData24" value='39' >&nbsp;เลือกตำแหน่งผิด</td><td align='center'><input name="num_point[39]" type="text" id="num_point24" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData25" value='40' >&nbsp;พิมพ์ไม่ครบบรรทัด ตาม ก.พ.7</td><td align='center'><input name="num_point[40]" type="text" id="num_point25" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData26" value='41' >&nbsp;เลือกระดับผิด</td><td align='center'><input name="num_point[41]" type="text" id="num_point26" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData27" value='42' >&nbsp;กรอกเงินเดือนผิด</td><td align='center'><input name="num_point[42]" type="text" id="num_point27" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData28" value='43' >&nbsp;กรอกจุดตัวย่อผิด</td><td align='center'><input name="num_point[43]" type="text" id="num_point28" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData29" value='47' >&nbsp;ไม่ได้กรอก # หรือ , </td><td align='center'><input name="num_point[47]" type="text" id="num_point29" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData30" value='56' >&nbsp;เลือกข้อมูลสถิติ พ.ศ. ผิด</td><td align='center'><input name="num_point[56]" type="text" id="num_point30" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData31" value='57' >&nbsp;กรอกข้อมูลเกิน</td><td align='center'><input name="num_point[57]" type="text" id="num_point31" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData32" value='60' >&nbsp;กรอกเลขที่ตำแหน่งผิด</td><td align='center'><input name="num_point[60]" type="text" id="num_point32" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData33" value='71' >&nbsp;กรอกข้อมูลสลับบรรทัด</td><td align='center'><input name="num_point[71]" type="text" id="num_point33" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'>&nbsp;&nbsp;<b>เลือกประเภทคำสั่งผิด  <a  href="#" onClick="showEle('xshow')">ซ่อน/แสดง</a></b><br><div id='xshow' style="display:block;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width='10%'>&nbsp;</td><td width='90%' bgcolor='#000000'><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr bgcolor='#FFFFFF'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData34" value='51' >&nbsp;เลือกขั้นเงินเดือนผิด/ไม่ระบุขั้นเงินเดือน</td><td><input name="num_point[51]" type="text" id="num_point34" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#F0F0F0'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData35" value='130' >&nbsp;ประเภทคำสั่งไม่ระบุ</td><td><input name="num_point[130]" type="text" id="num_point35" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData36" value='131' >&nbsp;ประเภทคำสั่งเลื่อนขั้นเงินเดือน</td><td><input name="num_point[131]" type="text" id="num_point36" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#F0F0F0'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData37" value='132' >&nbsp;ประเภทคำสั่งย้ายและแต่งตั้ง</td><td><input name="num_point[132]" type="text" id="num_point37" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData38" value='133' >&nbsp;ประเภทคำสั่งเลื่อนวิทยฐานะ</td><td><input name="num_point[133]" type="text" id="num_point38" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#F0F0F0'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData39" value='134' >&nbsp;ประเภทคำสั่งแต่งตั้งให้ดำรงตำแหน่ง</td><td><input name="num_point[134]" type="text" id="num_point39" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData40" value='135' >&nbsp;ประเภทคำสั่งบรรจุ</td><td><input name="num_point[135]" type="text" id="num_point40" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#F0F0F0'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData41" value='136' >&nbsp;ประเภทคำสั่งการแก้ไขคำสั่ง</td><td><input name="num_point[136]" type="text" id="num_point41" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData42" value='137' >&nbsp;ประเภทคำสั่งโอน</td><td><input name="num_point[137]" type="text" id="num_point42" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#F0F0F0'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData43" value='138' >&nbsp;ประเภทคำสั่งรักษาราชการในตำแหน่ง</td><td><input name="num_point[138]" type="text" id="num_point43" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData44" value='139' >&nbsp;ประเภทคำสั่งปรับ ฯ</td><td><input name="num_point[139]" type="text" id="num_point44" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#F0F0F0'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData45" value='140' >&nbsp;ประเภทคำสั่งกำหนดตำแหน่ง</td><td><input name="num_point[140]" type="text" id="num_point45" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData46" value='141' >&nbsp;ประเภทคำสั่งทดลองปฏิบัติราชการ</td><td><input name="num_point[141]" type="text" id="num_point46" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#F0F0F0'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData47" value='142' >&nbsp;ประเภทคำสั่งพ้น ฯ</td><td><input name="num_point[142]" type="text" id="num_point47" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData48" value='143' >&nbsp;ประเภทคำสั่งลาศึกษาต่อ</td><td><input name="num_point[143]" type="text" id="num_point48" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#F0F0F0'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData49" value='144' >&nbsp;ประเภทคำสั่งกลับจากลาศึกษาต่อ</td><td><input name="num_point[144]" type="text" id="num_point49" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData50" value='145' >&nbsp;ประเภทคำสั่งออกจากราชการ</td><td><input name="num_point[145]" type="text" id="num_point50" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#F0F0F0'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData51" value='146' >&nbsp;ประเภทคำสั่งเลื่อนระดับ</td><td><input name="num_point[146]" type="text" id="num_point51" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData52" value='147' >&nbsp;ประเภทคำสั่งแต่งตั้ง(ปฏิบัติราชการ)</td><td><input name="num_point[147]" type="text" id="num_point52" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#F0F0F0'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData53" value='148' >&nbsp;ประเภทคำสั่งเปลี่ยนชื่อสถานศึกษา ฯ</td><td><input name="num_point[148]" type="text" id="num_point53" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData54" value='149' >&nbsp;ประเภทคำสั่งได้รับโทษทางวินัย</td><td><input name="num_point[149]" type="text" id="num_point54" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#F0F0F0'><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chData[]" id="chData55" value='150' >&nbsp;ประเภทคำสั่งไปช่วยราชการ</td><td><input name="num_point[150]" type="text" id="num_point55" size="10" maxlength="4" value=''></td><td>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr></td></tr></table></table></div></td><td  colspan='2' align='left'></td></tr>            <tr bgcolor="#FFFFFF">
              <td align="center">5</td>
              <td align="left">
                เครื่องราชย์</td>
              <td align="center">&nbsp;</td>
              <td align="left"></td>
            </tr>
            <tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData57" value='24' >&nbsp;พิมพ์คำผิด / พิมพ์ไม่ครบบรรทัดตามเอกสาร กพ.7</td><td align='center'><input name="num_point[24]" type="text" id="num_point57" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData58" value='25' >&nbsp;ลงวันที่ label และ value ไม่ตรงกัน</td><td align='center'><input name="num_point[25]" type="text" id="num_point58" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData59" value='26' >&nbsp;พ.ศ.ช่อง label ไม่ตรงกับช่อง value</td><td align='center'><input name="num_point[26]" type="text" id="num_point59" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData60" value='27' >&nbsp;ประเภท / ชนิดเครื่องราชฯ ผิดไม่ตรงกับ กพ.7</td><td align='center'><input name="num_point[27]" type="text" id="num_point60" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData61" value='28' >&nbsp;ลำดับ เล่มที่ ตอนที่ หน้า ไม่ตรงกับเอกสาร กพ.7</td><td align='center'><input name="num_point[28]" type="text" id="num_point61" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData62" value='48' >&nbsp;กรอกจุดตัวย่อ</td><td align='center'><input name="num_point[48]" type="text" id="num_point62" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData63" value='63' >&nbsp;เลือก พ.ศ. ผิด/ไม่ได้ระบุ</td><td align='center'><input name="num_point[63]" type="text" id="num_point63" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData64" value='65' >&nbsp;ไม่ได้กรอกเครื่องราชย์/กรอกไม่ครบถ้วน</td><td align='center'><input name="num_point[65]" type="text" id="num_point64" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData65" value='70' >&nbsp;กรอกข้อมูลเครื่องราชย์เกิน</td><td align='center'><input name="num_point[70]" type="text" id="num_point65" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData66" value='124' >&nbsp;ไม่ได้เรียงลำดับข้อมูล</td><td align='center'><input name="num_point[124]" type="text" id="num_point66" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr>            <tr bgcolor="#F0F0F0">
              <td align="center">6</td>
              <td align="left">
                จำนวนวันลาหยุดราชการ ขาดราชการ มาสาย</td>
              <td align="center">&nbsp;</td>
              <td align="left"></td>
            </tr>
            <tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData67" value='29' >&nbsp;พิมพ์คำผิด / พิมพ์ไม่ครบบรรทัด ตามเอกสาร กพ.7</td><td align='center'><input name="num_point[29]" type="text" id="num_point67" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData68" value='30' >&nbsp;กรอกข้อมูลช่อง label ไม่ได้กรอกช่อง value</td><td align='center'><input name="num_point[30]" type="text" id="num_point68" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData69" value='49' >&nbsp;กรอกข้อมูลผิดช่อง</td><td align='center'><input name="num_point[49]" type="text" id="num_point69" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData70" value='55' >&nbsp;กรอกข้อมูลสถิติผิด</td><td align='center'><input name="num_point[55]" type="text" id="num_point70" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData71" value='64' >&nbsp;ไม่ได้กรอกวันลา/กรอกไม่ครบถ้วน</td><td align='center'><input name="num_point[64]" type="text" id="num_point71" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData72" value='69' >&nbsp;กรอกข้อมูลวันลาเกิน</td><td align='center'><input name="num_point[69]" type="text" id="num_point72" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr>            <tr bgcolor="#FFFFFF">
              <td align="center">7</td>
              <td align="left">
                การได้รับโทษทางวินัย</td>
              <td align="center">&nbsp;</td>
              <td align="left"></td>
            </tr>
            <tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData73" value='31' >&nbsp;พิมพ์คำผิด / พิมพ์ไม่ครบบรรทัด ตามเอกสาร กพ.7</td><td align='center'><input name="num_point[31]" type="text" id="num_point73" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData74" value='46' >&nbsp;เลือก พ.ศ. ผิด</td><td align='center'><input name="num_point[46]" type="text" id="num_point74" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr>            <tr bgcolor="#F0F0F0">
              <td align="center">8</td>
              <td align="left">
                วันที่ไม่ได้รับเงินเดือน(ปฏิบัติหน้าที่ในเขตกฎอัยการศึก)</td>
              <td align="center">&nbsp;</td>
              <td align="left"></td>
            </tr>
            <tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData75" value='32' >&nbsp;พิมพ์คำผิด / พิมพ์ไม่ครบบรรทัด ตามเอกสาร กพ.7</td><td align='center'><input name="num_point[32]" type="text" id="num_point75" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr>            <tr bgcolor="#FFFFFF">
              <td align="center">9</td>
              <td align="left">
                ความสามารถพิเศษ</td>
              <td align="center">&nbsp;</td>
              <td align="left"></td>
            </tr>
            <tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData76" value='33' >&nbsp;พิมพ์คำผิด / พิมพ์ไม่ครบบรรทัด ตามเอกสาร กพ.7</td><td align='center'><input name="num_point[33]" type="text" id="num_point76" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData77" value='153' >&nbsp;แสดงผลข้อมูลไม่ตรงตามเอกสาร</td><td align='center'><input name="num_point[153]" type="text" id="num_point77" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr>            <tr bgcolor="#F0F0F0">
              <td align="center">10</td>
              <td align="left">
                การปฏิบัติราชการพิเศษ</td>
              <td align="center">&nbsp;</td>
              <td align="left"></td>
            </tr>
            <tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData78" value='34' >&nbsp;พิมพ์คำผิด / พิมพ์ไม่ครบบรรทัด ตามเอกสาร กพ.7</td><td align='center'><input name="num_point[34]" type="text" id="num_point78" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData79" value='45' >&nbsp;เลือก พ.ศ. ผิด</td><td align='center'><input name="num_point[45]" type="text" id="num_point79" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData80" value='62' >&nbsp;ไม่ได้ระบุประเภทกฎอัยการศึก</td><td align='center'><input name="num_point[62]" type="text" id="num_point80" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData81" value='126' >&nbsp;การกำหนดการแสดงผลข้อมูลในกพ.7</td><td align='center'><input name="num_point[126]" type="text" id="num_point81" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr><tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData82" value='152' >&nbsp;แสดงผลข้อมูลไม่ตรงตามเอกสาร</td><td align='center'><input name="num_point[152]" type="text" id="num_point82" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr>            <tr bgcolor="#FFFFFF">
              <td align="center">11</td>
              <td align="left">
                รายการอื่นๆที่จำเป็น</td>
              <td align="center">&nbsp;</td>
              <td align="left"></td>
            </tr>
            <tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData83" value='35' >&nbsp;พิมพ์คำผิด / พิมพ์ไม่ครบบรรทัด ตามเอกสาร กพ.7</td><td align='center'><input name="num_point[35]" type="text" id="num_point83" size="10" maxlength="4" value=''></td><td align='left'>พิมพ์ผิด</td></tr><tr bgcolor='#F0F0F0'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData84" value='154' >&nbsp;แสดงผลข้อมูลไม่ตรงตามเอกสาร</td><td align='center'><input name="num_point[154]" type="text" id="num_point84" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr>            <tr bgcolor="#F0F0F0">
              <td align="center">12</td>
              <td align="left">
                เอกสารต้นฉบับ</td>
              <td align="center">&nbsp;</td>
              <td align="left"></td>
            </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">13</td>
              <td align="left">
                ประวัติการฝึกอบรม ศึกษา ดูงาน</td>
              <td align="center">&nbsp;</td>
              <td align="left"></td>
            </tr>
            <tr bgcolor='#FFFFFF'><td align='center'>&nbsp;</td><td align='left'><input type="checkbox" name="chData[]" id="chData85" value='128' >&nbsp;ไม่ได้กรอกประวัติการผึกอบรม ศึกษา ดูงาน</td><td align='center'><input name="num_point[128]" type="text" id="num_point85" size="10" maxlength="4" value=''></td><td align='left'>กำหนดคุณสมบัติข้อมูลผิดพลาด</td></tr>            <tr>
              <td colspan="4" align="center" bgcolor="#F4F4F4"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td colspan="3" align="left" bgcolor="#CCCCCC"><strong>แนบไฟล์แสกนผลการ QC เอกสาร ก.พ.7</strong></td>
                  </tr>
                <tr>
                  <td width="19%" align="right" valign="top"><strong>เลือกไฟล์แนบ : </strong></td>
                  <td width="32%" align="left" valign="top"> <input type="file" name="kp7file" id="kp7file"></td>
                  <td width="49%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                        <tr>
                          <td width="9%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
                          <td width="36%" align="center" bgcolor="#CCCCCC"><strong>ไฟล์ upload</strong></td>
                          <td width="43%" align="center" bgcolor="#CCCCCC"><strong>หมายเหตุ</strong></td>
                          <td width="12%" align="center" bgcolor="#CCCCCC"><strong>ลบรายการ</strong></td>
                        </tr>
                       <tr bgcolor="#FFFFFF"><td colspan='4' align='center'><b> - ไม่พบข้อมูลไฟล์แนบ -  </b></td></tr>                      </table></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td align="right" valign="top"><strong>หมายเหตุไฟล์แนบ : </strong></td>
                  <td align="left"><label for="comment_upload"></label>
                    <textarea name="comment_upload" id="comment_upload" cols="45" rows="5"></textarea></td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
            </tr>
              
            <tr>
              <td colspan="4" align="center" bgcolor="#F4F4F4"><input type="checkbox" name="status_process_point" id="status_process_point" value="1" >
                คลิ๊กในการณีไม่ต้องการนำไปคำนวณคะแนนสัมประสิทธิ์(คะแนนจุดผิด)</td>
            </tr>
            <tr>
              <td colspan="4" align="center" bgcolor="#F4F4F4">หมายเหตุ : <font color="#FF0000">ในกรณีทำการตรวจเอกสารแล้วไม่ต้องการนำไปเป็นคะแนนในการหักจุดผิดให้เลือกเช็คบล็อก " คลิ๊กในการณีไม่ต้องการนำไปคำนวณคะแนนสัมประสิทธิ์(คะแนนจุดผิด)"</font></td>
            </tr>
            <tr>
              <td colspan="4" align="center" bgcolor="#F4F4F4"><label>
                              <input type="checkbox" name="checkTrue" id="checkTrue" value="1"  onclick="return UncheckTrue();" >
                คลิ๊กกรณีผลการตรวจไม่พบข้อผิดพลาด
              </label></td>
            </tr>
                        <tr>
              <td colspan="4" align="center" bgcolor="#F4F4F4"><label>
                <input type="submit" name="button" id="button" value="บันทึก" />
                <input type="hidden" name="xch" value="86">
                <input type="hidden" name="idcard" value="3160200018373" />
                <input type="hidden" name="fullname" value="สมเกียรติ  กระจ่างพันธ์" />
                <input type="hidden" name="staffname" value="นางสาวเอมิกา  บัวจันทร์">
                <input type="hidden" name="staffid" value="11140">
                <input type="hidden" name="TicketID" value="TK-255504031422010123789">
                <input type="hidden" name="xsiteid" value="9999">
                <input type="hidden" name="flag_qc" value="412">
                <input type="hidden" name="qcupdate" value="">
                <input type="hidden" name="profile_id" value="">
                &nbsp;
                <input type="button" name="btnC" id="btnC" value="ปิดหน้าต่าง" onClick="window.close()">
              </label></td>
              </tr>
          </table></td>
        </tr>
  </table></td>
          </tr>
      </table>
  </td>
    </tr>
  </table>
</form>
</body>
</html>
