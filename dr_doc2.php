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
$prename = array('นาย','นาง','นางสาว');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>แบบรับรองสถานะของครัวเรือน (แบบ ดร. 02)</title>
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
            <li class="tab-link current" id="tab_1" data-tab="part_1">ส่วนที่ 1 แบบรับรองสถานะครอบครัว</li>
            <li class="tab-link" id="tab_2" data-tab="part_2">ส่วนที่ 2 ปิดประกาศ</li>
            <li class="tab-link" id="tab_3" data-tab="part_3">ส่วนที่ 3 ผลการพิจารณา</li>
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
				alert('เลขบัตรประชาชนนี้ถูกต้อง');
			} else {
				alert('เลขบัตรประชาชนนี้ไม่ถูกต้อง');
			}
		});
		$('span.random2').click(function() {
			var number = $(this).attr('text_ref');
			var randomcard = 'ส'+Random(0,999999999999);
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
				alert('เลขประจำตัวประชาชนไม่ถูกต้อง!');
				$(this).val('').focus();
			}
		});
		$('[name*="address_province"]').change(function() {
			var $self = $(this),
				prov_id = $self.val();
			$.get('main/ajax.dr_doc2.php?ajax=1&req=getDistrict&prov_id=' + prov_id, function(res) {
				$self.closest('tbody').find('[name*="address_district"]').html(res);
				$self.closest('tbody').find('[name*="address_subdistrict"]').html('<option>กรุณาเลือกตำบล/แขวง</option>');
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
			dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
			dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
			monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
			monthNamesShort: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
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
			dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
			dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
			monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
			monthNamesShort: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
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