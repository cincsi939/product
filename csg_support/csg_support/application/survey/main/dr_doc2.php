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
$prename = array('���','�ҧ','�ҧ���');
// echo '<pre>',print_r($val);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Ẻ�Ѻ�ͧʶҹТͧ�������͹ (Ẻ ��. 02)</title>
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
				<div class="form-code">Ẻ ��. 02</div>
				<div class="title-logo clear">
					<span>Ẻ�Ѻ�ͧʶҹТͧ�������͹</span>
				</div>
				<div class="write-at">
					��¹��� 
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
							<tr><td colspan="3" class="info-head">����Ѻ�ͧ����� <?= $i+1 ?></td></tr>
							<tr>
								<td>1.</td>
								<td class="require">�Ţ��Шӵ�ǻ�ЪҪ�</td>
								<td>
									<input 	type="text" 
											name="guarantee_idcard[]" 
                                            id="v3<?= $i+1 ?>"
											maxlength="13" 
											value="<?= $val['guarantee'][$i]['guarantee_idcard'] ?>">
									<span  id="idClassCheck" class="bIdCard">��Ǩ�ͺ</span>   
									<span  id="random2<?= $i+1 ?>" class="bIdCard random2" text_ref="<?= $i+1 ?>">�����Ţ�ѵ�</span>
								</td>
							</tr>
							<tr>
								<td colspan="2"></td>
								<td> 
									<span class="require">�͡�����</span> 
									<input 	type="text" 
											name="idcard_approver_by[]" 
											value="<?= $val['guarantee'][$i]['idcard_approver_by'] ?>">
									<span class="require">�ѹ�͡�ѵ�</span> 
									<input 	type="text" 
											class="datepick" 
											name="idcard_issue_date[]" 
											value="<?= re_date_view_fomat($val['guarantee'][$i]['idcard_issue_date']) ?>">
									<span class="require">�ѹ�������</span> 
									<input 	type="text" 
											class="datepick" 
											name="idcard_expire_date[]" 
											value="<?= re_date_view_fomat($val['guarantee'][$i]['idcard_expire_date']) ?>">
								</td>
							</tr>
							<tr>
								<td>2.</td>
								<td class="require">��Ҿ���</td>
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
											placeholder="����" 
											name="guarantee_name[]" 
											value="<?= $val['guarantee'][$i]['guarantee_name'] ?>">
									<input 	type="text" 
											placeholder="���ʡ��" 
											name="guarantee_surname[]" 
											value="<?= $val['guarantee'][$i]['guarantee_surname'] ?>">
								</td>
							</tr>
							<tr>
								<td>3.</td>
								<td>���˹�</td>
								<td>
									<input 	type="text" 
											name="position[]" 
											value="<?= $val['guarantee'][$i]['position'] ?>"> 
									�ѧ�Ѵ˹��§ҹ 
									<input 	type="text" 
											name="sector[]" 
											value="<?= $val['guarantee'][$i]['sector'] ?>">
								</td>
							</tr>
							<tr>
								<td>4.</td>
								<td>�ѹ��͹���Դ</td>
								<td>
									<input 	type="text" 
											class="datepick" 
											name="birthday[]" 
											value="<?= re_date_view_fomat($val['guarantee'][$i]['birthday']) ?>"> 
									���� 
									<input 	type="text" 
											name="age[]" 
											maxlength="3" 
											value="<?= $val['guarantee'][$i]['age'] ?>">
								</td>
							</tr>
							<tr>
								<td>5.</td>
								<td>������������</td>
								<td>
									<table>
										<tr>
											<td>��ҹ�Ţ���</td>
											<td>
												<input 	type="text" 
														name="address_number[]" 
														value="<?= $val['guarantee'][$i]['address_number'] ?>">
											</td>
											<td>����</td>
											<td>
												<input 	type="text" 
														name="address_group[]" 
														value="<?= $val['guarantee'][$i]['address_group'] ?>">
											</td>
											<td>��͡/���</td>
											<td>
												<input 	type="text" 
														name="address_lane[]" 
														value="<?= $val['guarantee'][$i]['address_lane'] ?>">
											</td>
										</tr>
										<tr>
											<td>���</td>
											<td>
												<input 	type="text" 
														name="address_road[]" 
														value="<?= $val['guarantee'][$i]['address_road'] ?>">
											</td>
											<td>�ѧ��Ѵ</td>
											<td>
												<?php $province_list = getProvince(); ?>
												<select name="address_province[]">
													<option>��س����͡�ѧ��Ѵ</option>
													<?php foreach($province_list as $prov){ ?>
														<option value="<?=$prov[ccDigi]?>" 
																<?= $val['guarantee'][$i]['address_province']==$prov[ccDigi]?'SELECTED':''?>>
															<?=$prov[ccName]?>
														</option>	
													<?php } ?>
												</select>
											</td>
											<td>�����/ࢵ</td>
											<td>
												<?php $district_list = getDistrict($val['guarantee'][$i]['address_province'],'array'); ?>
												<select name="address_district[]">
													<option>��س����͡�����/ࢵ</option>
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
											<td>�Ӻ�/�ǧ</td>
											<td>
												<?php $sub_district_list = getSubDistrict($val['guarantee'][$i]['address_district'],'array'); ?>
												<select name="address_subdistrict[]">
													<option>��س����͡�Ӻ�/�ǧ</option>
													<?php foreach($sub_district_list as $ccDigi=>$ccName){ ?>
														<option value="<?=$ccDigi?>" 
																<?= $val['guarantee'][$i]['address_subdistrict']==$ccDigi?'SELECTED':''?>>
															<?=$ccName?>
														</option>	
													<?php } ?>
												</select>
											</td>
											<td>������ɳ���</td>
											<td>
												<input 	type="text" 
														name="address_postcode[]"
														maxlength="5" 
														value="<?= $val['guarantee'][$i]['address_postcode'] ?>">
											</td>
											<td>���Ѿ��</td>
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
					<p class="indent">���Ѻ�ͧ��� 							
						<select name="request_prename" disabled>
							<?php foreach($prename as $p){ ?>
							<option value="<?= $p ?>" 
									<?= $val['eq_person']['eq_prename']==$p?'SELECTED':''?>>
								<?= $p ?>
							</option>
							<?php } ?>
						</select> 
						<input 	type="text" 
								placeholder="����" 
								value="<?= $val['eq_person']['eq_firstname'] ?>"
								name="request_name" 
								readonly> 
						<input 	type="text" 
								placeholder="���ʡ��" 
								value="<?= $val['eq_person']['eq_lastname'] ?>"
								name="request_surname"
								readonly> 
						��˭ԧ��駤����������㹤������͹�ҡ��/����§��ͤ����ҡ����ԧ ��������ӡ��� 3,000 �ҷ ��ͤ� �����͹ ���� 36,000 �ҷ ��ͤ� ��ͻ� (���������ͧ��Ҫԡ������㹤������͹��ô��¨ӹǹ��Ҫԡ�������ͧ�������͹���������á�Դ����)
					</p>
				</section>
				<section>
					<table width="100%" class="tableBorder">
						<tr>
							<td width="33%" class="tdUnderBorder">����Ѻ�ͧ����� 1</td>
							<td width="33%" class="tdUnderBorder">����Ѻ�ͧ����� 2</td>
							<td width="33%" class="tdUnderBorder">������ʶҹТͧ�������͹</td>
						</tr>
						<tr>
							<td class="tdlineRight"> - ��ا෾��ҹ�� : ��иҹ������ê���� �������˹�Ҽ��¾Ѳ�Ҫ����������ʴԡ���ѧ����Ш��ӹѡ�ҹࢵ</td>
							<td class="tdlineRight"> - ��ا෾��ҹ�� : ����ӹ�¡��ࢵ���ͼ�������Ѻ�ͺ����</td>
							<td rowspan="4">
								<input 	type="checkbox" 
									name="eq[leader]" 
									<?= $val['person']['leader']==1?'CHECKED':''?>>
							�����о�觾ԧ ���� 㹤�ͺ�����դ��ԡ�� ���� ����٧���� ���������ص�ӡ��� 15 �� ���ͤ���ҧ�ҹ���� 15 - 65 �� �����繾��/�������§����<br>
								<input 	type="checkbox" 
									name="eq[decadent_house]" 
									<?= $val['person']['decadent_house']==1?'CHECKED':''?>>
							��Ҿ��ҹ���ش��ش��� ��ҹ�Өҡ��ʴؾ�鹺�ҹ �� ����� 㹨ҡ..........�繵� ������ʴ�������� ���������ҹ���<br>
								<input 	type="checkbox" 
								name="eq[carless]" 
								<?= $val['person']['carless']==1?'CHECKED':''?>>
							�����ö¹����ǹ�ؤ�� ö�Ԥ�Ѿ ö��÷ء��� ö���<br>
								<input 	type="checkbox" 
									name="eq[landless]" 
									<?= $val['person']['landless']==1?'CHECKED':''?>>
							���ɵá��շ�������Թ 1 ���<br>
								<input 	type="checkbox" 
									name="eq[other]" 
									<?= $val['person']['other']==1?'CHECKED':''?>>
							��� � (�к�) 
							<input 	type="text" 
									name="eq[other_comment]" 
									style="width:50%"
									value="<?= $val['person']['other_comment'] ?>"><br>
						<p><u>�����˵�</u> ��ͧ�բ����Ż�СͺʶҹФ������͹���ҧ���� 1 ���</p>
							</td>
						</tr>
						<tr>
							<td class="tdlineRight"> - ���ͧ�ѷ�� : ��иҹ����� ����������Ѥ��Ҹ�ó�آ���ͧ�ѷ��</td>
							<td class="tdlineRight"> - ���ͧ�ѷ�� : ��Ѵ���ͧ�ѷ�� �����ͧ��Ѵ���ͧ�ѷ�ҷ�����Ѻ�ͺ����</td>
						</tr>
						<tr>
							<td class="tdlineRight"> - �Ⱥ�� ���� ͺ�. : ������ѤþѲ���ѧ����Ф�����蹤��ͧ������ (;�.)����������Ѥ��Ҹ�ó�آ��Ш������ҹ(���.)</td>
							<td class="tdlineRight"> - �Ⱥ�� ���� ͺ�. : ��Ѵ�Ⱥ�� ���ͻ�Ѵ ͺ�. ���ͼ�����Ѵ�ͺ���� ���͡ӹѹ���ͼ���˭��ҹ</td>
						</tr>
						<tr>
							<td class="tdlineRight"> - ��ҹ�ѡ����Ф�ͺ���� ����ʶҹʧ������ͧ�Ѱ : ���˹�ҷ���ҹ�ѡ����Ф�ͺ���� �������˹�ҷ��ʶҹʧ������</td>
							<td class="tdlineRight"> - ��ҹ�ѡ����Ф�ͺ���� ����ʶҹʧ������ͧ�Ѱ : ���˹�Һ�ҹ����Ф�ͺ���� ���ͼ�黡��ͧʧ������</td>
						</tr>
					</table>
				</section>
				<section>
					<p class="info-head">��ûԴ��С��</p>
					<p>
						��Դ��С�� 15 �ѹ���� �����С�� 
						<input 	type="text" 
								name="eq[announce_subject]" 
								value="<?= $val['person']['announce_subject'] ?>"> 
						�Ţ��� 
						<input 	type="text" 
								name="eq[announce_number]" 
								value="<?= $val['person']['announce_number'] ?>"> 
						ŧ�ѹ��� 
						<input 	type="text" 
								class="datepick" 
								name="eq[announce_date]" 
								value="<?= re_date_view_fomat($val['person']['announce_date']) ?>">
					</p>
					<p>
						<input 	type="radio" 
								name="eq[announce_result]" 
								value="0" <?= $val['person']['announce_result']==0?'CHECKED':''?>>
						����ռ��Ѵ��ҹ
					</p>
					<p>
						<input 	type="radio" 
								name="eq[announce_result]" 
								value="1" <?= $val['person']['announce_result']==1?'CHECKED':''?>>
						�ռ��Ѵ��ҹ ���ͧ�ҡ 
						<input 	type="text" 
								name="eq[announce_comment]" 
								style="width:50%"
								value="<?= $val['person']['announce_comment'] ?>">
					</p>
					<p>
						�ó��ռ��Ѵ��ҹ����Թ��õ�Ǩ�ͺ����稨�ԧ���Ǿ����
						<input	type="text"
								name="eq[announce_prove]"
								style="width:50%"
								value="<?= $val['person']['announce_prove'] ?>">
					</p>
				</section>
				<section>
					<p class="info-head">�š�þԨ�ó�</p>
					<p>
						<input 	type="radio" 
								name="eq[consider_result]" 
								value="0" 
								<?= $val['person']['consider_result']==0?'CHECKED':''?>>
						���Է������Ѻ�Թ�ش˹ع���͡������§�����á�Դ
					</p>
					<p>
						<input 	type="radio" 
								name="eq[consider_result]" 
								value="1" <?= $val['person']['consider_result']==1?'CHECKED':''?>>
						������Է������Ѻ�Թ�ش˹ع���͡������§�����á�Դ ���ͧ�ҡ 
						<input 	type="text" 
								name="eq[consider_comment]" 
								style="width:50%"
								value="<?= $val['person']['consider_comment'] ?>">
					</p>
				</section>
				<!--section>
					<p class="info-head">�����Ż�Сͺ��þԨ�ó�ʶҹТͧ�������͹</p>
					<p>
						<input 	type="checkbox" 
								name="eq[leader]" 
								<?= $val['person']['leader']==1?'CHECKED':''?>>
						�����о�觾ԧ ���� 㹤�ͺ�����դ��ԡ�� ���� ����٧���� ���������ص�ӡ��� 15 �� ���ͤ���ҧ�ҹ���� 15 - 65 �� �����繾��/�������§����
					</p>
					<p>
						<input 	type="checkbox" 
								name="eq[decadent_house]" 
								<?= $val['person']['decadent_house']==1?'CHECKED':''?>>
						��Ҿ��ҹ���ش��ش��� ��ҹ�Өҡ��ʴؾ�鹺�ҹ �� ����� 㹨ҡ..........�繵� ������ʴ�������� ���������ҹ���
					</p>
					<p>
						<input 	type="checkbox" 
								name="eq[occupant]" 
								<?= $val['person']['occupant']==1?'CHECKED':''?>>
						ʶҹ�Ҿ㹤������͹ �� �繼�������
					</p>
					<p>
						<input 	type="checkbox" 
								name="eq[landless]" 
								<?= $val['person']['landless']==1?'CHECKED':''?>>
						���ɵá��շ�������Թ 1 ���
					</p>
					<p>
						<input 	type="checkbox" 
								name="eq[carless]" 
								<?= $val['person']['carless']==1?'CHECKED':''?>>
						�����ö¹����ǹ�ؤ�� ö�Ԥ�Ѿ ö��÷ء��� ö���
					</p>
					<p>
						<input 	type="checkbox" 
								name="eq[other]" 
								<?= $val['person']['other']==1?'CHECKED':''?>>
						��� � (�к�) 
						<input 	type="text" 
								name="eq[other_comment]" 
								style="width:50%"
								value="<?= $val['person']['other_comment'] ?>">
					</p>
					<p><u>�����˵�</u> ��ͧ�բ����Ż�СͺʶҹФ������͹���ҧ���� 1 ���</p>
				</section-->
			</main>
			<footer>
				<input type="submit" value="�ѹ�֡">
				<input type="button" value="��Ѻ˹����ѡ" onClick="location='question_form.php'">
			</footer>
		</form>
	</div>
	<script src="../js/CheckIdCardThai.min.js"></script>
	<script>
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
		$('form').submit(function(e) {
			$('[name*="guarantee_idcard"]').each(function() {
				if ($(this).val() == '') {
					e.preventDefault();
					alert('��سҡ�͡�Ţ��Шӵ�ǻ�ЪҪ����١��ͧ');
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