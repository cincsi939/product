// JavaScript Document
function valChecked(from_id,action_id){
	if($('#'+from_id).is(':checked')){
		$('#'+action_id).removeAttr('disabled');
	}else{
		$('#'+action_id).attr('disabled','disabled');
		$('#'+action_id).val('');
	}
}

function valChecked2(radio1,radio2,id1,id2){
	if($('#'+radio2).is(':checked')){
		$('#'+id1).removeAttr('disabled');
		$('#'+id2).removeAttr('disabled');
	}else if($('#'+radio1).is(':checked')){
		$('#'+id1).attr('disabled','disabled');
		$('#'+id2).attr('disabled','disabled');
		$('#'+id1).val('');
		$('#'+id2).val('');
	}
}

function valChecked3(radio1,radio2,id1){
	if($('#'+radio2).is(':checked')){
		$('#'+id1).removeAttr('disabled');
	}else if($('#'+radio1).is(':checked')){
		$('#'+id1).attr('disabled','disabled');
		$('#'+id1).val('');
	}
}

function checkTab1(){
	var verify = '';
	var verify1 = '';
	var verify2 = '';
	
	if($.trim($('#verify_tab1-1').val()) == ''){verify += '- กรุณาระบุ เขียนที่\n';}
	
	if($.trim($('#v31').val()) == ''){
		verify1 = (verify1 == '' ) ? '\nผู้รับรองคนที่ 1\n' : verify1;
		verify1 += '- กรุณาระบุ เลขประจำตัวประชาชน\n';
	}
	
	if($.trim($('#verify_tab1-21').val()) == ''){
		verify1 = (verify1 == '' ) ? '\nผู้รับรองคนที่ 1\n' : verify1;
		verify1 += '- กรุณาระบุ ออกให้โดย\n';
	}
	
	if($.trim($('#verify_tab1-31').val()) == ''){
		verify1 = (verify1 == '' ) ? '\nผู้รับรองคนที่ 1\n' : verify1;
		verify1 += '- กรุณาระบุ วันออกบัตร\n';
	}
	
	if($.trim($('#verify_tab1-41').val()) == ''){
		verify1 = (verify1 == '' ) ? '\nผู้รับรองคนที่ 1\n' : verify1;
		verify1 += '- กรุณาระบุ วันหมดอายุ\n';
	}
	
	if($.trim($('#verify_tab1-51').val()) == '' || $.trim($('#verify_tab1-61').val()) == '' || $.trim($('#verify_tab1-71').val()) == ''){
		verify1 = (verify1 == '' ) ? '\nผู้รับรองคนที่ 1\n' : verify1;
		verify1 += '- กรุณากรอชื่อผู้รับรองให้ครบถ้วน\n';
	}
	
	if($.trim($('#verify_tab1-81').val()) == '' || parseInt($('#verify_tab1-81').val()) < 20){
		verify1 = (verify1 == '' ) ? '\nผู้รับรองคนที่ 1\n' : verify1;
		verify1 += '- อายุผู้รับรองต้องมีอายุ 20 ปีบริบูรณ์ขึ้นไป\n';
	}
	
	if($.trim($('#verify_tab1-91').val()) == ''){
		verify1 = (verify1 == '' ) ? '\nผู้รับรองคนที่ 1\n' : verify1;
		verify1 += '- กรุณาระบุ บ้านเลขที่\n';
	}
	
	if($.trim($('#verify_tab1-101').val()) == ''){
		verify1 = (verify1 == '' ) ? '\nผู้รับรองคนที่ 1\n' : verify1;
		verify1 += '- กรุณาระบุ หมู่\n';
	}
	
	if($.trim($('#verify_tab1-111').val()) == ''){
		verify1 = (verify1 == '' ) ? '\nผู้รับรองคนที่ 1\n' : verify1;
		verify1 += '- กรุณาระบุ จังหวัด\n';
	}
	
	if($.trim($('#verify_tab1-121').val()) == ''){
		verify1 = (verify1 == '' ) ? '\nผู้รับรองคนที่ 1\n' : verify1;
		verify1 += '- กรุณาระบุ อำเภอ/เขต\n';
	}
	
	if($.trim($('#verify_tab1-131').val()) == ''){
		verify1 = (verify1 == '' ) ? '\nผู้รับรองคนที่ 1\n' : verify1;
		verify1 += '- กรุณาระบุ ตำบล/แขวง\n';
	}
	
	if($.trim($('#verify_tab1-141').val()) == ''){
		verify1 = (verify1 == '' ) ? '\nผู้รับรองคนที่ 1\n' : verify1;
		verify1 += '- กรุณาระบุ รหัสไปรษณีย์\n';
	}
	
	if($.trim($('#v32').val()) == ''){
		verify2 = (verify2 == '' ) ? '\nผู้รับรองคนที่ 2\n' : verify2;
		verify2 += '- กรุณาระบุ เลขประจำตัวประชาชน\n';
	}
	
	if($.trim($('#verify_tab1-22').val()) == ''){
		verify2 = (verify2 == '' ) ? '\nผู้รับรองคนที่ 2\n' : verify2;
		verify2 += '- กรุณาระบุ ออกให้โดย\n';
	}
	
	if($.trim($('#verify_tab1-32').val()) == ''){
		verify2 = (verify2 == '' ) ? '\nผู้รับรองคนที่ 2\n' : verify2;
		verify2 += '- กรุณาระบุ วันออกบัตร\n';
	}
	
	if($.trim($('#verify_tab1-42').val()) == ''){
		verify2 = (verify2 == '' ) ? '\nผู้รับรองคนที่ 2\n' : verify2;
		verify2 += '- กรุณาระบุ วันหมดอายุ\n';
	}
	
	if($.trim($('#verify_tab1-52').val()) == '' || $.trim($('#verify_tab1-62').val()) == '' || $.trim($('#verify_tab1-72').val()) == ''){
		verify2 = (verify2 == '' ) ? '\nผู้รับรองคนที่ 2\n' : verify2;
		verify2 += '- กรุณากรอชื่อผู้รับรองให้ครบถ้วน\n';
	}
	
	if($.trim($('#verify_tab1-82').val()) == '' || parseInt($('#verify_tab1-82').val()) < 20){
		verify2 = (verify2 == '' ) ? '\nผู้รับรองคนที่ 2\n' : verify2;
		verify2 += '- อายุผู้รับรองต้องมีอายุ 20 ปีบริบูรณ์ขึ้นไป\n';
	}
	
	if($.trim($('#verify_tab1-92').val()) == ''){
		verify2 = (verify2 == '' ) ? '\nผู้รับรองคนที่ 2\n' : verify2;
		verify2 += '- กรุณาระบุ บ้านเลขที่\n';
	}
	
	if($.trim($('#verify_tab1-102').val()) == ''){
		verify2 = (verify2 == '' ) ? '\nผู้รับรองคนที่ 2\n' : verify2;
		verify2 += '- กรุณาระบุ หมู่\n';
	}
	
	if($.trim($('#verify_tab1-112').val()) == ''){
		verify2 = (verify2 == '' ) ? '\nผู้รับรองคนที่ 2\n' : verify2;
		verify2 += '- กรุณาระบุ จังหวัด\n';
	}
	
	if($.trim($('#verify_tab1-122').val()) == ''){
		verify2 = (verify2 == '' ) ? '\nผู้รับรองคนที่ 2\n' : verify2;
		verify2 += '- กรุณาระบุ อำเภอ/เขต\n';
	}
	
	if($.trim($('#verify_tab1-132').val()) == ''){
		verify2 = (verify2 == '' ) ? '\nผู้รับรองคนที่ 2\n' : verify2;
		verify2 += '- กรุณาระบุ ตำบล/แขวง\n';
	}
	
	if($.trim($('#verify_tab1-142').val()) == ''){
		verify2 = (verify2 == '' ) ? '\nผู้รับรองคนที่ 2\n' : verify2;
		verify2 += '- กรุณาระบุ รหัสไปรษณีย์\n';
	}
	
	if(verify != '' || verify1 != '' || verify2 != ''){
		alert(verify+verify1+verify2);	
		return false;	
	}
}

function checkTab2(){
	var verify = '';
	if($.trim($('#verify_tab2-1').val()) == ''){verify += '- กรุณาระบุ ได้ปิดประกาศ 15 วันแล้ว ตามประกาศ\n';}
	if($.trim($('#verify_tab2-2').val()) == ''){verify += '- กรุณาระบุ เลขที่่\n';}
	if($.trim($('#verify_tab2-3').val()) == ''){verify += '- กรุณาระบุ ลงทะเบียน\n';}
	if($('#verify_tab2-41').is(':checked') === false && $('#verify_tab2-42').is(':checked') === false){
		verify += '- กรุณาระบุ ผลการปิดประกาศ\n';
	}
	if(verify != ''){
		alert(verify);	
		return false;	
	}
}

function checkTab3(){
	var verify = '';
	if($('#verify_tab3-11').is(':checked') === false && $('#verify_tab3-12').is(':checked') === false){
		verify += '- กรุณาระบุ ผลการพิจารณา\n';
	}
	if(verify != ''){
		alert(verify);	
		return false;	
	}
}