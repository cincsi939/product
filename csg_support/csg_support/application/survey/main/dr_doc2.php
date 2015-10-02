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
if($_POST) save_eq_approve_person($_GET[id], $_POST);
$val = get_data_eq_approve($_GET[id],$_GET[eq_id]);
$prename = array('นาย','นาง','นางสาว');
// echo '<pre>',print_r($val);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>แบบรับรองสถานะของครัวเรือน (แบบ ดร. 02)</title>
<link rel="stylesheet" href="../css/style.css">
<style>
.form-code,.write-at{float:right}.info-head,.title-logo>span{font-weight:700}.form-code{border:1px solid #000;padding:3px 7px}.container{margin:0 50px 0 40px}.clear{clear:both}.title-logo,footer{text-align:center}.info-head{text-decoration:underline}.indent{text-indent:50px;line-height:25px;}section{border:1px solid #ddd;padding:10px;margin:10px 0}hr{border-style:dotted;border-color:#ddd}.require:after{content:'*';color:red}
</style>
<?php 
	$ws_client = $con->configIPSoap();
	$calendar = array('file' => 'calendar');
	echo $ws_client->call('includefile', $calendar);
?>
<link rel="stylesheet" href="../package/jquery-ui/jquery-ui.css">
<script src="../package/jquery-ui/jquery-ui-thai.js"></script>
</head>
<body>
	<div class="container">
		<form method="post">
        <input type="hidden" name="eq[eq_id]" value="<?php echo $_GET['eq_id']?>" >
			<header>
				<div class="form-code">แบบ ดร. 02</div>
				<div class="title-logo clear">
					<span>แบบรับรองสถานะของครัวเรือน</span>
				</div>
				<div class="write-at">
					เขียนที่ 
					<input 	type="text" 
							name="eq[write_at]" 
							value="<?= $val['person']['write_at'] ?>">
				</div>
				<div class="clear"></div>
			</header>
			<main>
				<section>
					<?php for($i=0;$i<=1;$i++){ ?>
                    <input type="hidden" name="eq_id[]" value="<?php echo $_GET['eq_id']?>" >
					<table>
						<tbody>
							<tr><td colspan="3" class="info-head">ผู้รับรองคนที่ <?= $i+1 ?></td></tr>
							<tr>
								<td>1.</td>
								<td class="require">เลขประจำตัวประชาชน</td>
								<td>
									<input 	type="text" 
											name="guarantee_idcard[]" 
                                            id="v3<?= $i+1 ?>"
											maxlength="13" 
											value="<?= $val['guarantee'][$i]['guarantee_idcard'] ?>">
									<span  id="idClassCheck" class="bIdCard">ตรวจสอบ</span>   
									<span  id="random2<?= $i+1 ?>" class="bIdCard random2" text_ref="<?= $i+1 ?>">สุ่มเลขบัตร</span>
								</td>
							</tr>
							<tr>
								<td colspan="2"></td>
								<td> 
									<span class="require">ออกให้โดย</span> 
									<input 	type="text" 
											name="idcard_approver_by[]" 
											value="<?= $val['guarantee'][$i]['idcard_approver_by'] ?>">
									<span class="require">วันออกบัตร</span> 
									<input 	type="text" 
											class="datepick" 
											name="idcard_issue_date[]" 
											value="<?= re_date_view_fomat($val['guarantee'][$i]['idcard_issue_date']) ?>">
									<span class="require">วันหมดอายุ</span> 
									<input 	type="text" 
											class="datepick" 
											name="idcard_expire_date[]" 
											value="<?= re_date_view_fomat($val['guarantee'][$i]['idcard_expire_date']) ?>">
								</td>
							</tr>
							<tr>
								<td>2.</td>
								<td class="require">ข้าพเจ้า</td>
								<td>
									<select name="guarantee_prename[]">
										<?php foreach($prename as $txt){ ?>
										<option value="<?= $txt ?>" 
												<?= $txt==$val['guarantee'][$i]['guarantee_prename']?'SELECTED':''?>>
											<?= $txt ?>
										</option>
										<?php } ?>
									</select>
									<input 	type="text" 
											placeholder="ชื่อ" 
											name="guarantee_name[]" 
											value="<?= $val['guarantee'][$i]['guarantee_name'] ?>">
									<input 	type="text" 
											placeholder="นามสกุล" 
											name="guarantee_surname[]" 
											value="<?= $val['guarantee'][$i]['guarantee_surname'] ?>">
								</td>
							</tr>
							<tr>
								<td>3.</td>
								<td>ตำแหน่ง</td>
								<td>
									<input 	type="text" 
											name="position[]" 
											value="<?= $val['guarantee'][$i]['position'] ?>"> 
									สังกัดหน่วยงาน 
									<input 	type="text" 
											name="sector[]" 
											value="<?= $val['guarantee'][$i]['sector'] ?>">
								</td>
							</tr>
							<tr>
								<td>4.</td>
								<td>วันเดือนปีเกิด</td>
								<td>
									<input 	type="text" 
											class="datepick" 
											name="birthday[]" 
											value="<?= re_date_view_fomat($val['guarantee'][$i]['birthday']) ?>"> 
									อายุ 
									<input 	type="text" 
											name="age[]" 
											maxlength="3" 
											value="<?= $val['guarantee'][$i]['age'] ?>">
								</td>
							</tr>
							<tr>
								<td>5.</td>
								<td>ที่อยู่อาศัย</td>
								<td>
									<table>
										<tr>
											<td>บ้านเลขที่</td>
											<td>
												<input 	type="text" 
														name="address_number[]" 
														value="<?= $val['guarantee'][$i]['address_number'] ?>">
											</td>
											<td>หมู่</td>
											<td>
												<input 	type="text" 
														name="address_group[]" 
														value="<?= $val['guarantee'][$i]['address_group'] ?>">
											</td>
											<td>ตรอก/ซอย</td>
											<td>
												<input 	type="text" 
														name="address_lane[]" 
														value="<?= $val['guarantee'][$i]['address_lane'] ?>">
											</td>
										</tr>
										<tr>
											<td>ถนน</td>
											<td>
												<input 	type="text" 
														name="address_road[]" 
														value="<?= $val['guarantee'][$i]['address_road'] ?>">
											</td>
											<td>จังหวัด</td>
											<td>
												<?php $province_list = getProvince(); ?>
												<select name="address_province[]">
													<option>กรุณาเลือกจังหวัด</option>
													<?php foreach($province_list as $prov){ ?>
														<option value="<?=$prov[ccDigi]?>" 
																<?= $val['guarantee'][$i]['address_province']==$prov[ccDigi]?'SELECTED':''?>>
															<?=$prov[ccName]?>
														</option>	
													<?php } ?>
												</select>
											</td>
											<td>อำเภอ/เขต</td>
											<td>
												<?php $district_list = getDistrict($val['guarantee'][$i]['address_province'],'array'); ?>
												<select name="address_district[]">
													<option>กรุณาเลือกอำเภอ/เขต</option>
													<?php foreach($district_list as $ccDigi=>$ccName){ ?>
														<option value="<?=$ccDigi?>" 
																<?= $val['guarantee'][$i]['address_district']==$ccDigi?'SELECTED':''?>>
															<?=$ccName?>
														</option>	
													<?php } ?>
												</select>
											</td>
										</tr>
										<tr>
											<td>ตำบล/แขวง</td>
											<td>
												<?php $sub_district_list = getSubDistrict($val['guarantee'][$i]['address_district'],'array'); ?>
												<select name="address_subdistrict[]">
													<option>กรุณาเลือกตำบล/แขวง</option>
													<?php foreach($sub_district_list as $ccDigi=>$ccName){ ?>
														<option value="<?=$ccDigi?>" 
																<?= $val['guarantee'][$i]['address_subdistrict']==$ccDigi?'SELECTED':''?>>
															<?=$ccName?>
														</option>	
													<?php } ?>
												</select>
											</td>
											<td>รหัสไปรษณีย์</td>
											<td>
												<input 	type="text" 
														name="address_postcode[]"
														maxlength="5" 
														value="<?= $val['guarantee'][$i]['address_postcode'] ?>">
											</td>
											<td>โทรศัพท์</td>
											<td>
												<input 	type="text" 
														name="address_telephone[]" 
														value="<?= $val['guarantee'][$i]['address_telephone'] ?>">
											</td>
										</tr>
									</table>
								</td>
							</tr>					
						</tbody>
					</table>
					<?= $i==0?'<hr>':''?>
					<?php } ?>
				</section>
				
				<section>
					<p class="indent">ขอรับรองว่า 							
						<select name="request_prename" disabled>
							<?php foreach($prename as $p){ ?>
							<option value="<?= $p ?>" 
									<?= $val['eq_person']['eq_prename']==$p?'SELECTED':''?>>
								<?= $p ?>
							</option>
							<?php } ?>
						</select> 
						<input 	type="text" 
								placeholder="ชื่อ" 
								value="<?= $val['eq_person']['eq_firstname'] ?>"
								name="request_name" 
								readonly> 
						<input 	type="text" 
								placeholder="นามสกุล" 
								value="<?= $val['eq_person']['eq_lastname'] ?>"
								name="request_surname"
								readonly> 
						เป็นหญิงตั้งครรภ์ที่อยู่ในครัวเรือนยากจน/เสี่ยงต่อความยากจนจริง มีรายได้ต่ำกว่า 3,000 บาท ต่อคน ต่อเดือน หรือ 36,000 บาท ต่อคน ต่อปี (รายได้รวมของสมาชิกทั้งหมดในครัวเรือนหารด้วยจำนวนสมาชิกทั้งหมดของครัวเรือนซึ่งรวมเด็กแรกเกิดด้วย)
					</p>
				</section>
				<section>
					<table width="100%" class="tableBorder">
						<tr>
							<td width="33%" class="tdUnderBorder">ผู้รับรองคนที่ 1</td>
							<td width="33%" class="tdUnderBorder">ผู้รับรองคนที่ 2</td>
							<td width="33%" class="tdUnderBorder">ข้อมูลสถานะของครัวเรือน</td>
						</tr>
						<tr>
							<td class="tdlineRight"> - กรุงเทพมหานคร : ประธานกรรมการชุมชน หรือหัวหน้าผ่ายพัฒนาชุมชนและสวัสดิการสังคมประจำสำนักงานเขต</td>
							<td class="tdlineRight"> - กรุงเทพมหานคร : ผู้อำนวยการเขตหรือผู้ที่ได้รับมอบหมาย</td>
							<td rowspan="4">
								<input 	type="checkbox" 
									name="eq[leader]" 
									<?= $val['person']['leader']==1?'CHECKED':''?>>
							มีภาระพึ่งพิง ได้แก่ ในครอบครัวมีคนพิการ หรือ ผู้สูงอายุ หรือเด็กอายุต่ำกว่า 15 ปี หรือคนว่างงานอายุ 15 - 65 ปี หรือเป็นพ่อ/แม่เลื้ยงเดียว<br>
								<input 	type="checkbox" 
									name="eq[decadent_house]" 
									<?= $val['person']['decadent_house']==1?'CHECKED':''?>>
							สภาพบ้านชำรุดทรุดโทรม บ้านทำจากวัสดุพื้นบ้าน เช่น ไม้ไผ่ ในจาก..........เป็นต้น หรือวัสดุเหลือใช้ หรืออยู่บ้านเช่า<br>
								<input 	type="checkbox" 
								name="eq[carless]" 
								<?= $val['person']['carless']==1?'CHECKED':''?>>
							ไม่มีรถยนต์ส่วนบุคคล รถปิคอัพ รถบรรทุกเล็ก รถตู้<br>
								<input 	type="checkbox" 
									name="eq[landless]" 
									<?= $val['person']['landless']==1?'CHECKED':''?>>
							เป็นเกษตรกรมีที่นาไม่เกิน 1 ไร่<br>
								<input 	type="checkbox" 
									name="eq[other]" 
									<?= $val['person']['other']==1?'CHECKED':''?>>
							อื่น ๆ (ระบุ) 
							<input 	type="text" 
									name="eq[other_comment]" 
									style="width:50%"
									value="<?= $val['person']['other_comment'] ?>"><br>
						<p><u>หมายเหตุ</u> ต้องมีข้อมูลประกอบสถานะครัวเรือนอย่างน้อย 1 ข้อ</p>
							</td>
						</tr>
						<tr>
							<td class="tdlineRight"> - เมืองพัทยา : ประธานชุมชน หรืออาสาสมัครสาธารณสุขเมืองพัทยา</td>
							<td class="tdlineRight"> - เมืองพัทยา : ปลัดเมืองพัทยา หรือรองปลัดเมืองพัทยาที่ได้รับมอบหมาย</td>
						</tr>
						<tr>
							<td class="tdlineRight"> - เทศบาล หรือ อบต. : อาสาสมัครพัฒนาสังคมและความมั่นคงของมนุษย์ (อพม.)หรืออาสาสมัครสาธารณสุขประจำหมู่บ้าน(อสม.)</td>
							<td class="tdlineRight"> - เทศบาล หรือ อบต. : ปลัดเทศบาล หรือปลัด อบต. หรือผู้ที่ปลัดมอบหมาย หรือกำนันหรือผู้ใหญ่บ้าน</td>
						</tr>
						<tr>
							<td class="tdlineRight"> - บ้านพักเด็กและครอบครัว หรือสถานสงเคราะห์ของรัฐ : เจ้าหน้าที่บ้านพักเด็กและครอบครัว หรือเจ้าหน้าที่สถานสงเคราะห์</td>
							<td class="tdlineRight"> - บ้านพักเด็กและครอบครัว หรือสถานสงเคราะห์ของรัฐ : หัวหน้าบ้านเด็กและครอบครัว หรือผู้ปกครองสงเคราะห์</td>
						</tr>
					</table>
				</section>
				<section>
					<p class="info-head">การปิดประกาศ</p>
					<p>
						ได้ปิดประกาศ 15 วันแล้ว ตามประกาศ 
						<input 	type="text" 
								name="eq[announce_subject]" 
								value="<?= $val['person']['announce_subject'] ?>"> 
						เลขที่ 
						<input 	type="text" 
								name="eq[announce_number]" 
								value="<?= $val['person']['announce_number'] ?>"> 
						ลงวันที่ 
						<input 	type="text" 
								class="datepick" 
								name="eq[announce_date]" 
								value="<?= re_date_view_fomat($val['person']['announce_date']) ?>">
					</p>
					<p>
						<input 	type="radio" 
								name="eq[announce_result]" 
								value="0" <?= $val['person']['announce_result']==0?'CHECKED':''?>>
						ไม่มีผู้คัดค้าน
					</p>
					<p>
						<input 	type="radio" 
								name="eq[announce_result]" 
								value="1" <?= $val['person']['announce_result']==1?'CHECKED':''?>>
						มีผู้คัดค้าน เนื่องจาก 
						<input 	type="text" 
								name="eq[announce_comment]" 
								style="width:50%"
								value="<?= $val['person']['announce_comment'] ?>">
					</p>
					<p>
						กรณีมีผู้คัดค้านได้ดำเนินการตรวจสอบข้อเท็จจริงแล้วพบว่า
						<input	type="text"
								name="eq[announce_prove]"
								style="width:50%"
								value="<?= $val['person']['announce_prove'] ?>">
					</p>
				</section>
				<section>
					<p class="info-head">ผลการพิจารณา</p>
					<p>
						<input 	type="radio" 
								name="eq[consider_result]" 
								value="0" 
								<?= $val['person']['consider_result']==0?'CHECKED':''?>>
						มีสิทธิ์ได้รับเงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด
					</p>
					<p>
						<input 	type="radio" 
								name="eq[consider_result]" 
								value="1" <?= $val['person']['consider_result']==1?'CHECKED':''?>>
						ไม่มีสิทธิ์ได้รับเงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด เนื่องจาก 
						<input 	type="text" 
								name="eq[consider_comment]" 
								style="width:50%"
								value="<?= $val['person']['consider_comment'] ?>">
					</p>
				</section>
				<!--section>
					<p class="info-head">ข้อมูลประกอบการพิจารณาสถานะของครัวเรือน</p>
					<p>
						<input 	type="checkbox" 
								name="eq[leader]" 
								<?= $val['person']['leader']==1?'CHECKED':''?>>
						มีภาระพึ่งพิง ได้แก่ ในครอบครัวมีคนพิการ หรือ ผู้สูงอายุ หรือเด็กอายุต่ำกว่า 15 ปี หรือคนว่างงานอายุ 15 - 65 ปี หรือเป็นพ่อ/แม่เลื้ยงเดียว
					</p>
					<p>
						<input 	type="checkbox" 
								name="eq[decadent_house]" 
								<?= $val['person']['decadent_house']==1?'CHECKED':''?>>
						สภาพบ้านชำรุดทรุดโทรม บ้านทำจากวัสดุพื้นบ้าน เช่น ไม้ไผ่ ในจาก..........เป็นต้น หรือวัสดุเหลือใช้ หรืออยู่บ้านเช่า
					</p>
					<p>
						<input 	type="checkbox" 
								name="eq[occupant]" 
								<?= $val['person']['occupant']==1?'CHECKED':''?>>
						สถานภาพในครัวเรือน เช่น เป็นผู้อาศัย
					</p>
					<p>
						<input 	type="checkbox" 
								name="eq[landless]" 
								<?= $val['person']['landless']==1?'CHECKED':''?>>
						เป็นเกษตรกรมีที่นาไม่เกิน 1 ไร่
					</p>
					<p>
						<input 	type="checkbox" 
								name="eq[carless]" 
								<?= $val['person']['carless']==1?'CHECKED':''?>>
						ไม่มีรถยนต์ส่วนบุคคล รถปิคอัพ รถบรรทุกเล็ก รถตู้
					</p>
					<p>
						<input 	type="checkbox" 
								name="eq[other]" 
								<?= $val['person']['other']==1?'CHECKED':''?>>
						อื่น ๆ (ระบุ) 
						<input 	type="text" 
								name="eq[other_comment]" 
								style="width:50%"
								value="<?= $val['person']['other_comment'] ?>">
					</p>
					<p><u>หมายเหตุ</u> ต้องมีข้อมูลประกอบสถานะครัวเรือนอย่างน้อย 1 ข้อ</p>
				</section-->
			</main>
			<footer>
				<input type="submit" value="บันทึก">
				<input type="button" value="กลับหน้าหลัก" onClick="location='question_form.php'">
			</footer>
		</form>
	</div>
	<script src="../js/CheckIdCardThai.min.js"></script>
	<script>
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
		$('form').submit(function(e) {
			$('[name*="guarantee_idcard"]').each(function() {
				if ($(this).val() == '') {
					e.preventDefault();
					alert('กรุณากรอกเลขประจำตัวประชาชนให้ถูกต้อง');
					$(this).focus();
					return false;
				}
			});
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
			yearRange: '1914:2020',
			showWeek: false,
			firstDay: 1,
			beforeShow: function(){    
				$(".ui-datepicker, select").css('font-size', 14) 
			}
		});
	});
	
	function Random(min_val, max_val) {
		return Math.floor(Math.random() * (max_val - min_val + 1)) + min_val;
	}
	</script>
</body>
</html>