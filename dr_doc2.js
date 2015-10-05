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
	
	if($.trim($('#verify_tab1-1').val()) == ''){verify += '- ��س��к� ��¹���\n';}
	
	if($.trim($('#v31').val()) == ''){
		verify1 = (verify1 == '' ) ? '\n����Ѻ�ͧ����� 1\n' : verify1;
		verify1 += '- ��س��к� �Ţ��Шӵ�ǻ�ЪҪ�\n';
	}
	
	if($.trim($('#verify_tab1-21').val()) == ''){
		verify1 = (verify1 == '' ) ? '\n����Ѻ�ͧ����� 1\n' : verify1;
		verify1 += '- ��س��к� �͡�����\n';
	}
	
	if($.trim($('#verify_tab1-31').val()) == ''){
		verify1 = (verify1 == '' ) ? '\n����Ѻ�ͧ����� 1\n' : verify1;
		verify1 += '- ��س��к� �ѹ�͡�ѵ�\n';
	}
	
	if($.trim($('#verify_tab1-41').val()) == ''){
		verify1 = (verify1 == '' ) ? '\n����Ѻ�ͧ����� 1\n' : verify1;
		verify1 += '- ��س��к� �ѹ�������\n';
	}
	
	if($.trim($('#verify_tab1-51').val()) == '' || $.trim($('#verify_tab1-61').val()) == '' || $.trim($('#verify_tab1-71').val()) == ''){
		verify1 = (verify1 == '' ) ? '\n����Ѻ�ͧ����� 1\n' : verify1;
		verify1 += '- ��سҡ�ͪ��ͼ���Ѻ�ͧ���ú��ǹ\n';
	}
	
	if($.trim($('#verify_tab1-81').val()) == '' || parseInt($('#verify_tab1-81').val()) < 20){
		verify1 = (verify1 == '' ) ? '\n����Ѻ�ͧ����� 1\n' : verify1;
		verify1 += '- ���ؼ���Ѻ�ͧ��ͧ������ 20 �պ�Ժ�ó����\n';
	}
	
	if($.trim($('#verify_tab1-91').val()) == ''){
		verify1 = (verify1 == '' ) ? '\n����Ѻ�ͧ����� 1\n' : verify1;
		verify1 += '- ��س��к� ��ҹ�Ţ���\n';
	}
	
	if($.trim($('#verify_tab1-101').val()) == ''){
		verify1 = (verify1 == '' ) ? '\n����Ѻ�ͧ����� 1\n' : verify1;
		verify1 += '- ��س��к� ����\n';
	}
	
	if($.trim($('#verify_tab1-111').val()) == ''){
		verify1 = (verify1 == '' ) ? '\n����Ѻ�ͧ����� 1\n' : verify1;
		verify1 += '- ��س��к� �ѧ��Ѵ\n';
	}
	
	if($.trim($('#verify_tab1-121').val()) == ''){
		verify1 = (verify1 == '' ) ? '\n����Ѻ�ͧ����� 1\n' : verify1;
		verify1 += '- ��س��к� �����/ࢵ\n';
	}
	
	if($.trim($('#verify_tab1-131').val()) == ''){
		verify1 = (verify1 == '' ) ? '\n����Ѻ�ͧ����� 1\n' : verify1;
		verify1 += '- ��س��к� �Ӻ�/�ǧ\n';
	}
	
	if($.trim($('#verify_tab1-141').val()) == ''){
		verify1 = (verify1 == '' ) ? '\n����Ѻ�ͧ����� 1\n' : verify1;
		verify1 += '- ��س��к� ������ɳ���\n';
	}
	
	if($.trim($('#v32').val()) == ''){
		verify2 = (verify2 == '' ) ? '\n����Ѻ�ͧ����� 2\n' : verify2;
		verify2 += '- ��س��к� �Ţ��Шӵ�ǻ�ЪҪ�\n';
	}
	
	if($.trim($('#verify_tab1-22').val()) == ''){
		verify2 = (verify2 == '' ) ? '\n����Ѻ�ͧ����� 2\n' : verify2;
		verify2 += '- ��س��к� �͡�����\n';
	}
	
	if($.trim($('#verify_tab1-32').val()) == ''){
		verify2 = (verify2 == '' ) ? '\n����Ѻ�ͧ����� 2\n' : verify2;
		verify2 += '- ��س��к� �ѹ�͡�ѵ�\n';
	}
	
	if($.trim($('#verify_tab1-42').val()) == ''){
		verify2 = (verify2 == '' ) ? '\n����Ѻ�ͧ����� 2\n' : verify2;
		verify2 += '- ��س��к� �ѹ�������\n';
	}
	
	if($.trim($('#verify_tab1-52').val()) == '' || $.trim($('#verify_tab1-62').val()) == '' || $.trim($('#verify_tab1-72').val()) == ''){
		verify2 = (verify2 == '' ) ? '\n����Ѻ�ͧ����� 2\n' : verify2;
		verify2 += '- ��سҡ�ͪ��ͼ���Ѻ�ͧ���ú��ǹ\n';
	}
	
	if($.trim($('#verify_tab1-82').val()) == '' || parseInt($('#verify_tab1-82').val()) < 20){
		verify2 = (verify2 == '' ) ? '\n����Ѻ�ͧ����� 2\n' : verify2;
		verify2 += '- ���ؼ���Ѻ�ͧ��ͧ������ 20 �պ�Ժ�ó����\n';
	}
	
	if($.trim($('#verify_tab1-92').val()) == ''){
		verify2 = (verify2 == '' ) ? '\n����Ѻ�ͧ����� 2\n' : verify2;
		verify2 += '- ��س��к� ��ҹ�Ţ���\n';
	}
	
	if($.trim($('#verify_tab1-102').val()) == ''){
		verify2 = (verify2 == '' ) ? '\n����Ѻ�ͧ����� 2\n' : verify2;
		verify2 += '- ��س��к� ����\n';
	}
	
	if($.trim($('#verify_tab1-112').val()) == ''){
		verify2 = (verify2 == '' ) ? '\n����Ѻ�ͧ����� 2\n' : verify2;
		verify2 += '- ��س��к� �ѧ��Ѵ\n';
	}
	
	if($.trim($('#verify_tab1-122').val()) == ''){
		verify2 = (verify2 == '' ) ? '\n����Ѻ�ͧ����� 2\n' : verify2;
		verify2 += '- ��س��к� �����/ࢵ\n';
	}
	
	if($.trim($('#verify_tab1-132').val()) == ''){
		verify2 = (verify2 == '' ) ? '\n����Ѻ�ͧ����� 2\n' : verify2;
		verify2 += '- ��س��к� �Ӻ�/�ǧ\n';
	}
	
	if($.trim($('#verify_tab1-142').val()) == ''){
		verify2 = (verify2 == '' ) ? '\n����Ѻ�ͧ����� 2\n' : verify2;
		verify2 += '- ��س��к� ������ɳ���\n';
	}
	
	if(verify != '' || verify1 != '' || verify2 != ''){
		alert(verify+verify1+verify2);	
		return false;	
	}
}

function checkTab2(){
	var verify = '';
	if($.trim($('#verify_tab2-1').val()) == ''){verify += '- ��س��к� ��Դ��С�� 15 �ѹ���� �����С��\n';}
	if($.trim($('#verify_tab2-2').val()) == ''){verify += '- ��س��к� �Ţ����\n';}
	if($.trim($('#verify_tab2-3').val()) == ''){verify += '- ��س��к� ŧ����¹\n';}
	if($('#verify_tab2-41').is(':checked') === false && $('#verify_tab2-42').is(':checked') === false){
		verify += '- ��س��к� �š�ûԴ��С��\n';
	}
	if(verify != ''){
		alert(verify);	
		return false;	
	}
}

function checkTab3(){
	var verify = '';
	if($('#verify_tab3-11').is(':checked') === false && $('#verify_tab3-12').is(':checked') === false){
		verify += '- ��س��к� �š�þԨ�ó�\n';
	}
	if(verify != ''){
		alert(verify);	
		return false;	
	}
}