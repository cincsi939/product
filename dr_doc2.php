<?php
/**
* @comment ???
* @projectCode ???
* @tor ???
* @package ???
* @author noone
* @access ???
* @created 25/25/2525
*/
require_once('lib/nusoap.php'); 
require_once("lib/class.function.php");	
$con = new Cfunction();
$con->connectDB();
require_once("dr_doc2_function.php");	
//echo "<pre>";print_r($_POST);echo "</pre>";
if($_POST && $_POST['tab'] == 'tab1' && $_POST['checkVal'] == '') save_eq_approve_person($_GET[id], $_POST);
if($_POST && $_POST['tab'] == 'tab1' && $_POST['checkVal'] != '') update_eq_approve_person($_GET[id], $_POST);

if($_POST && $_POST['tab'] == 'tab2') update_announce($_GET[id], $_POST);
if($_POST && $_POST['tab'] == 'tab3') update_consider($_GET[id], $_POST);
$val = get_data_eq_approve($_GET[id],$_GET[eq_id]);
//echo '<pre style="text-align:left; font-size:13px;">'; print_r($val); echo '</pre>';
$prename = array('���','�ҧ','�ҧ���');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Ẻ�Ѻ�ͧʶҹТͧ�������͹ (Ẻ ��. 02)</title>
<link rel="stylesheet" href="../css/style.css">
<script src="main/dr_doc2.js"></script>
<style>
.form-code,.write-at{float:right}.info-head,.title-logo>span{font-weight:700}.form-code{border:1px solid #000;padding:3px 7px}.container{margin:0 50px 0 40px}.clear{clear:both}.title-logo,footer{text-align:center}.info-head{text-decoration:underline}.indent{text-indent:50px;line-height:25px;}section{border:1px solid #ddd;padding:10px;margin:10px 0}hr{border-style:dotted;border-color:#ddd}.require:after{content:'*';color:red}
p{
	padding:0;	
	margin:7px 0;
}
</style>
<?php 
	$ws_client = $con->configIPSoap();
	$calendar = array('file' => 'calendar');
	echo $ws_client->call('includefile', $calendar);
?>
<link rel="stylesheet" href="../package/jquery-ui/jquery-ui.css">
<link rel="stylesheet" href="../css/tab.css">
<script src="../package/jquery-ui/jquery-ui-thai.js"></script>
</head>
<body>
    <div class="container">
    <div class="tab-example">
        <ul class="tabs">
            <li class="tab-link current" id="tab_1" data-tab="part_1">��ǹ��� 1 Ẻ�Ѻ�ͧʶҹФ�ͺ����</li>
            <li class="tab-link" id="tab_2" data-tab="part_2">��ǹ��� 2 �Դ��С��</li>
            <li class="tab-link" id="tab_3" data-tab="part_3">��ǹ��� 3 �š�þԨ�ó�</li>
        </ul>
        <div class="tab-contents">
        	<div class="tab-pane current" id="part_1"><?php require_once("dr_doc2_tab1.php"); ?></div>
			<div class="tab-pane" id="part_2"><?php require_once("dr_doc2_tab2.php"); ?></div>
            <div class="tab-pane" id="part_3"><?php require_once("dr_doc2_tab3.php"); ?></div>
		</div>
	</div>
    </div>
	<script src="../js/CheckIdCardThai.min.js"></script>
	<script>
	$(function() {
		$('.tabs li').on('click', function() {
			var tabId = $(this).attr('data-tab');
	
			$('.tabs li').removeClass('current');
			$('.tab-pane').removeClass('current'); 
	
			$(this).addClass('current');
			$('#' + tabId).addClass('current');
		});
		
		valChecked('check_other','other_comment');
		valChecked2('verify_tab2-41','verify_tab2-42','verify_tab2-5','verify_tab2-6');
		
		<?php
		if($val[person][eq_id] == ''){
			echo "$('#tab_2').css('display','none');";
			echo "$('#tab_3').css('display','none');";
		}
		
		if($val[person][announce_result] == ''){
			echo "$('#tab_3').css('display','none');";
		}
		
		if($_POST['tab'] == 'tab1'){
			echo "$('.tabs li').removeClass('current');
			$('.tab-pane').removeClass('current'); 
			$('#tab_1').addClass('current');
			$('#part_1').addClass('current'); ";
		}elseif($_POST['tab'] == 'tab2'){
			echo "$('.tabs li').removeClass('current');
			$('.tab-pane').removeClass('current'); 
			$('#tab_2').addClass('current');
			$('#part_2').addClass('current'); ";
		}elseif($_POST['tab'] == 'tab3'){
			echo "$('.tabs li').removeClass('current');
			$('.tab-pane').removeClass('current'); 
			$('#tab_3').addClass('current');
			$('#part_3').addClass('current'); ";
		}
		?>
	});

	$(function() {
		$('span#idClassCheck').click(function() {
			var result = $(this).siblings('[name*="guarantee_idcard"]').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
			if (result) {
				alert('�Ţ�ѵû�ЪҪ����١��ͧ');
			} else {
				alert('�Ţ�ѵû�ЪҪ�������١��ͧ');
			}
		});
		$('span.random2').click(function() {
			var number = $(this).attr('text_ref');
			var randomcard = '�'+Random(0,999999999999);
			$('#v3'+number).val(randomcard);
		});
		$('[name*="birthday"]').change(function() {
			var $d = $(this).val().split('/'),
				dob = new Date(($d[2] - 543) + '-' + $d[1] + '-' + $d[0]),
				today = new Date(),
				age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
			$(this).closest('tbody').find('[name*="age"]').val(age);
		})
		$('[name*="guarantee_idcard"]').blur(function() {
			if ($(this).CheckIdCardThai({
				exceptStartNum0: true,
				exceptStartNum9: false
			}) == false && $(this).val() != '') {
				alert('�Ţ��Шӵ�ǻ�ЪҪ����١��ͧ!');
				$(this).val('').focus();
			}
		});
		$('[name*="address_province"]').change(function() {
			var $self = $(this),
				prov_id = $self.val();
			$.get('main/ajax.dr_doc2.php?ajax=1&req=getDistrict&prov_id=' + prov_id, function(res) {
				$self.closest('tbody').find('[name*="address_district"]').html(res);
				$self.closest('tbody').find('[name*="address_subdistrict"]').html('<option>��س����͡�Ӻ�/�ǧ</option>');
			});
		});
		$('[name*="address_district"]').change(function() {
			var $self = $(this),
				dist_id = $self.val();
			$.get('main/ajax.dr_doc2.php?ajax=1&req=getSubDistrict&dist_id=' + dist_id, function(res) {
				$self.closest('tbody').find('[name*="address_subdistrict"]').html(res);
			});
		});
		var d = new Date();
		var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);
		var ageDate = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 523);
		$('.datepick').datepicker({
			dateFormat: 'dd/mm/yy',
			isBuddhist: true,
			defaultDate: toDay,
			dayNames: ['�ҷԵ��', '�ѹ���', '�ѧ���', '�ظ', '����ʺ��', '�ء��', '�����'],
			dayNamesMin: ['��.', '�.', '�.', '�.', '��.', '�.', '�.'],
			monthNames: ['���Ҥ�', '����Ҿѹ��', '�չҤ�', '����¹', '����Ҥ�', '�Զع�¹', '�á�Ҥ�', '�ԧ�Ҥ�', '�ѹ��¹', '���Ҥ�', '��Ȩԡ�¹', '�ѹ�Ҥ�'],
			monthNamesShort: ['���Ҥ�', '����Ҿѹ��', '�չҤ�', '����¹', '����Ҥ�', '�Զع�¹', '�á�Ҥ�', '�ԧ�Ҥ�', '�ѹ��¹', '���Ҥ�', '��Ȩԡ�¹', '�ѹ�Ҥ�'],
			showOtherMonths: true,
			selectOtherMonths: true,
			showButtonPanel: false,
			changeMonth: true,
			changeYear: true,
			numberOfMonths: 1,
			yearRange: (d.getFullYear() - 70)+':'+(d.getFullYear() + 10),
			showWeek: false,
			firstDay: 1,
			beforeShow: function(){    
				$(".ui-datepicker, select").css('font-size', 14) 
			}
		});
		
		$('.datepick1').datepicker({
			dateFormat: 'dd/mm/yy',
			isBuddhist: true,
			defaultDate: ageDate,
			dayNames: ['�ҷԵ��', '�ѹ���', '�ѧ���', '�ظ', '����ʺ��', '�ء��', '�����'],
			dayNamesMin: ['��.', '�.', '�.', '�.', '��.', '�.', '�.'],
			monthNames: ['���Ҥ�', '����Ҿѹ��', '�չҤ�', '����¹', '����Ҥ�', '�Զع�¹', '�á�Ҥ�', '�ԧ�Ҥ�', '�ѹ��¹', '���Ҥ�', '��Ȩԡ�¹', '�ѹ�Ҥ�'],
			monthNamesShort: ['���Ҥ�', '����Ҿѹ��', '�չҤ�', '����¹', '����Ҥ�', '�Զع�¹', '�á�Ҥ�', '�ԧ�Ҥ�', '�ѹ��¹', '���Ҥ�', '��Ȩԡ�¹', '�ѹ�Ҥ�'],
			showOtherMonths: true,
			selectOtherMonths: true,
			showButtonPanel: false,
			changeMonth: true,
			changeYear: true,
			numberOfMonths: 1,
			yearRange: (d.getFullYear() - 70)+':'+(d.getFullYear() + 10),
			showWeek: false,
			firstDay: 1,
			beforeShow: function(){    
				$(".ui-datepicker, select").css('font-size', 14) 
			},
			maxDate:+0,
		});
	});
	
	function Random(min_val, max_val) {
		return Math.floor(Math.random() * (max_val - min_val + 1)) + min_val;
	}
	</script>
</body>
</html>