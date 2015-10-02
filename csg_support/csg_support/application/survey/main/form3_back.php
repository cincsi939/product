<link rel="stylesheet" href="../css/style.css">
<?php
error_reporting(E_ALL ^ E_NOTICE);

require_once("lib/class.function.php");
$con = new Cfunction();
$sql = 'SELECT question_24_1,question_24_1_detail,question_24_2,question_24_2_detail,question_24_3,question_24_4,question_24_5,question_24_5_detail,';
$sql .= 'question_24_6,question_24_7,question_24_7_detail,question_24_8';
$sql .= ' FROM question_detail_1';
$sql .= ' WHERE question_id='.$_GET['id'];
$con->connectDB();
$results = $con->select($sql);
foreach($results as $row){}

$r24_1 = $row['question_24_1'];
$question_24_1_detail = $row['question_24_1_detail'];
//$r24_1_detail = json_decode($question_24_1_detail);
$r24_1_detail = explode(',',$question_24_1_detail);

$t24_1Num = $r24_1_detail [0];
$c24_YearOld_1 = $r24_1_detail [1];
$c24_YearOld_2 = $r24_1_detail [2];
$c24_YearOld_3 = $r24_1_detail [3];

$r24_2 = $row['question_24_2'];
$t24_2Num = $row['question_24_2_detail'];

$question_24_3 = $row['question_24_3'];
//$r_24_3 = json_decode($question_24_3);
$r_24_3 = explode(',',$question_24_3);

$r24_3_1 = $r_24_3[0];
$t24_3_1Cause = $r_24_3[1];
$r24_3_2 = $r_24_3[2];
$t24_3_2Cause = $r_24_3[3];
$r24_3_3 = $r_24_3[4];
$t24_3_3Cause = $r_24_3[5];
$r24_3_4 = $r_24_3[6];

$r24_4 = $row['question_24_4'];
$r24_5 = $row['question_24_5'];
$r24_5_detail = $row['question_24_5_detail'];
//$r24_5_detail  = json_decode($r24_5_detail);
$r24_5_detail = explode(',',$r24_5_detail);


$r24_6 = $row['question_24_6'];
$r24_7 = $row['question_24_7'];
$r24_7_detail = $row['question_24_7_detail'];
if($r24_7==2)
{
	$r24_7_detail_2 = $r24_7_detail;
}
else
{
	$r24_7_detail_2 = '';
}
$r24_8 = $row['question_24_8'];
//$r24_8  = json_decode($r24_8);
$r24_8 = explode(',',$r24_8);

?>
<form action="main_exc/form3_exc.php" method="post" enctype="multipart/form-data">
<table width="765" border="0" >
  <tr>
    <td width="45" align="right" valign="middle"><b><u>ส่วนที่3</u></b></td>
    <td colspan="4" valign="middle"><strong>สัมพันธภาพของครอบครัว
      <input type="hidden" name="question_id" value="<?php echo $_GET['id']; ?>">
    </strong></td>
    </tr>
  <tr>
    <td colspan="5" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">24.1</td>
    <td colspan="4" valign="middle">ในรอบปีมีสมาชิกในครอบครัวหนีออกจากบ้าน</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle">
      <input type="radio" name="r24_1" id="r24_1_a" value="1" <?php if($r24_1==1){echo 'checked';} ?>> มีจำนวน
      <input type="text" name="t24_1Num" id="t24_1Num"  value="<?php echo $t24_1Num; ?>" size="3"> คน ระบุ </td>
  </tr>
  <tr class="c24_1">
    <td valign="middle">&nbsp;</td>
    <td width="40" valign="middle">&nbsp;</td>
    <td width="197" valign="middle"><input name="c24_YearOld_1" type="checkbox" id="c24_YearOld_1" value="1" <?php if($c24_YearOld_1==1){echo 'checked';} ?>>
      อายุต่ำกว่า 10 ปี</td>
    <td colspan="2" valign="middle">&nbsp;</td>
    </tr>
  <tr class="c24_1">
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td valign="middle"><input name="c24_YearOld_2" type="checkbox" id="c24_YearOld_2" value="2" <?php if($c24_YearOld_2==2){echo 'checked';} ?>>
      อาย 10-15 ปี</td>
    <td colspan="2" valign="middle">&nbsp;</td>
    </tr>
  <tr class="c24_1">
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td valign="middle"><input name="c24_YearOld_3" type="checkbox" id="c24_YearOld_3" value="3" <?php if($c24_YearOld_3==3){echo 'checked';} ?>>
      อายุ 16 ปีขึ้นไป</td>
    <td colspan="2" valign="middle">&nbsp;</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="r24_1" id="r24_1_b" value="2" <?php if($r24_1==2){echo 'checked';} ?>>
      ไม่มี</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">24.2</td>
    <td colspan="4" valign="middle">ผู้สูงอายที่อายุุ 60 ปีขึ้นไป ในครอบครัวได้รับการเอาใจใส่จากสมาชิกในครอบครัวในเรื่องปัจจัย 4 และด้านจิตใจ</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="r24_2" id="r24_2_a" value="1" <?php if($r24_2==1){echo 'checked';} ?>>
      มีจำนวนคน
      <input type="text" name="t24_2num" id="t24_2num" size="3" value="<?php echo $t24_2Num; ?>">
      คน</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="r24_2" id="r24_2_b" value="2" <?php if($r24_2==2){echo 'checked';} ?>>
      ไม่มี</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">24.3</td>
    <td colspan="4" valign="middle">สมาชิกในครอบครัวมีลักษณะการปฏิบัติต่อกัน</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td width="40" align="left" valign="middle">24.3.1 </td>
    <td colspan="3" align="left" valign="middle">นับถือกันตามอาวุโส</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td colspan="3" align="left" valign="middle"><input type="radio" name="r24_3_1" id="r24_3_1_a" value="1" <?php if($r24_3_1==1){echo 'checked';} ?>>
      ใช่ </td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td colspan="3" align="left" valign="middle"><input type="radio" name="r24_3_1" id="r24_3_1_b" value="2" <?php if($r24_3_1==2){echo 'checked';} ?>>
      ไม่ใช่&nbsp;เนื่องจาก 
      <input name="t24_3_1Cause" type="text" id="t24_3_1Cause"  value="<?php echo $t24_3_1Cause; ?>" style="width:80%"></td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" align="left" valign="middle">24.3.2 พูดคุยปรึกษาหารือกัน</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td colspan="3" align="left" valign="middle"><input type="radio" name="r24_3_2" id="r24_3_2" value="1" <?php if($r24_3_2==1){echo 'checked';} ?>>
      ใช่ </td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td colspan="3" align="left" valign="middle"><input type="radio" name="r24_3_2" id="r24_3_9" value="2" <?php if($r24_3_2==2){echo 'checked';} ?>>
      ไม่ใช่&nbsp;เนื่องจาก 
      <input type="text" id="r24_3_4" name="t24_3_2Cause" value="<?php echo $t24_3_2Cause; ?>"  style="width:80%"></td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" align="left" valign="middle">24.3.3 รับฟังความคิดเห็นและเหตุผลของสมาชิกในครอบครัว</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td colspan="3" align="left" valign="middle"><input type="radio" name="r24_3_3" id="r24_3_6" value="1" <?php if($r24_3_3==1){echo 'checked';} ?>>
      ใช่ </td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td colspan="3" align="left" valign="middle"><input type="radio" name="r24_3_3" id="r24_3_3" value="2" <?php if($r24_3_3==2){echo 'checked';} ?>>
      ไม่ใช่&nbsp;เนื่องจาก 
      <input name="t24_3_3Cause" type="text" id="r24_3_5" value="<?php echo $t24_3_3Cause; ?>"  style="width:80%"></td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" align="left" valign="middle">24.3.4 สมาชิกในครอบครัวมีการทำกิจกรรมร่วมกัน&nbsp;เช่น&nbsp;ทานอาหาร&nbsp;ปลูกต้นไม้&nbsp;สอนการบ้าน</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td valign="middle"><input type="radio" name="r24_3_4" id="r24_3_" value="1" <?php if($r24_3_4==1){echo 'checked';} ?>>
มี </td>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td valign="middle"><input type="radio" name="r24_3_4" id="r24_3_7" value="2" <?php if($r24_3_4==2){echo 'checked';} ?>>
ไม่มี</td>
    <td width="110" valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">24.4</td>
    <td colspan="4" valign="middle">แก้ไขปัญหาเฉพาะหน้าของครอบครัวร่วมกัน</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="r24_4" id="r24_4" value="1" <?php if($r24_4==1){echo 'checked';} ?>>
      ไม่ได้ร่วมแก้ปัญหา      </td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="r24_4" id="r24_4" value="2" <?php if($r24_4==2){echo 'checked';} ?>>
ร่วมแก้ปัญหาบางครั้ง</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="r24_4" id="r24_4" value="3" <?php if($r24_4==3){echo 'checked';} ?>>
      ร่วมแก้ปัญหาทุกครั้ง</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">24.5</td>
    <td colspan="4" valign="middle">มีการก่อปัญหาความเดือดร้อนมาสู่ครอบครัว</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="r24_5" id="" value="1" <?php if($r24_5==1){echo 'checked';} ?>>
      เคยก่อปัญหา&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle"><input name="c24_5Detail_1" type="checkbox" id="c24_5Detail_1" value="1" <?php if($r24_5_detail[0]==1){echo 'checked';} ?>>
      ทะเลาะวิวาท&nbsp;จำนวน
      <input type="text" name="t24_5Num_1" id="t24_5Num_1" size="3" value="<?php echo $r24_5_detail[1];  ?>">
      ครั้ง</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle">
      <input name="c24_5Detail_2" type="checkbox" id="c24_5Detail_2" value="1" <?php if($r24_5_detail[2]==1){echo 'checked';} ?>>
      ติดยาเสพติด
      จำนวน
<input type="text" name="t24_5Num_2" id="t24_5Num_2"  size="3"  value="<?php echo $r24_5_detail[3];  ?>">
      ครั้ง</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle">      <input name="c24_5Detail_3" type="checkbox" id="c24_5Detail_3" value="1" <?php if($r24_5_detail[4]==1){echo 'checked';} ?>>
      มีพฤติกรรมเสี่ยงทางเพศ&nbsp;จำนวน
      <input type="text" name="t24_5Num_3" id="t24_5Num_3" size="3" value="<?php echo $r24_5_detail[5];  ?>">
      ครั้ง</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="r24_5" id="r24_5" value="2" <?php if($r24_5==2){echo 'checked';} ?>>
      ไม่เคยก่อปัญหา</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">24.6</td>
    <td colspan="4" valign="middle">ทะเลาะกันถึงขั้นทุบตี&nbsp;ทำร้ายร่างกาย/จิตใจ&nbsp;หรือพูดจาหยาบคาย</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="2" valign="middle"><input type="radio" name="r24_6" id="" value="1" <?php if($r24_6==1){echo 'checked';} ?>>
      เป็นประจำ</td>
    <td colspan="2" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td colspan="2" valign="middle"><input type="radio" name="r24_6" id="r24_" value="2" <?php if($r24_6==2){echo 'checked';} ?>>
ไม่เคย</td>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">24.7</td>
    <td colspan="4" valign="middle">สมาชิกในครอบครัว&nbsp;เข้าร่วมกิจกรรมทางสังคมและงานประเพณีที่สำคัญ</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="r24_7" id="" value="1" <?php if($r24_7==1){echo 'checked';} ?>>
      มีส่วนร่วม </td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle"><input type="radio" name="r24_7_detail" id="r24_4" value="1" <?php if($r24_7_detail==1){echo 'checked';} ?>>
      น้อยกว่า 5 ครั้ง/ปี</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle"><input type="radio" name="r24_7_detail" id="r24_5" value="2" <?php if($r24_7_detail==2){echo 'checked';} ?>>
      น้อยกว่า 5-10 ครั้ง/ปี</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle"><input type="radio" name="r24_7_detail" id="r24_3" value="3" <?php if($r24_7_detail==3){echo 'checked';} ?>>
      มากกว่า 10 ครั้ง/ปี</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="r24_7" id="r24_2" value="2" <?php if($r24_7==2){echo 'checked';} ?>>
      ไม่มี&nbsp;เนื่องจาก
  <input name="t24_7Detail_txt" type="text" id="r24_2"  style="width:85%" value="<?php echo $r24_7_detail_2; ?>"></td>
  </tr>
  <tr>
    <td align="right" valign="middle">24.8</td>
    <td colspan="4" valign="middle">ครอบครัว&nbsp;ได้รับการช่วยเหลือจากหน่วยงานของรัฐ&nbsp;ในเรื่องต่อไปนี้</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td align="left" valign="middle">24.8.1 </td>
    <td colspan="3" align="left" valign="middle">เมื่อเจ็บป่วย&nbsp;สมาชิกในครอบครัวได้ใช้บริการจากโรงพยาบาลส่งเสริมสุขภาพตำบลหรือโรงพยาบาล&nbsp;หรือไม่</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle"><input type="radio" name="r24_8_1" id="" value="1" <?php if($r24_8[0]==1){echo 'checked';} ?>>
      ได้ใช้</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle"><input type="radio" name="r24_8_1" id="r24_8_2" value="2" <?php if($r24_8[0]==2){echo 'checked';} ?>>
      ไม่ได้ใช้&nbsp;&nbsp;&nbsp;ระบุสาเหตุ
      <input name="t24_8_1Detail" type="text" id="r24_8_2"   style="width:75%"  value="<?php echo $r24_8[1]; ?>"></td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td align="left" valign="top">24.8.2 </td>
    <td colspan="3" align="left" valign="middle">สมาชิกในครอบครัวคนใดคนหนึ่งเคยได้รับบริการช่วยเหลือในการประกอบอาชีพ หรือไม่</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle"><input type="radio" name="r24_8_2" id="r24_8_3" value="1" <?php if($r24_8[2]==1){echo 'checked';} ?>>
เคย&nbsp;&nbsp;ระบุ&nbsp;
<input name="t24_8_2Detail" type="text" id="r24_8_3" style="width:83%"  value="<?php echo $r24_8[3]; ?>"></td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle"><input type="radio" name="r24_8_2" id="r24_8_" value="2" <?php if($r24_8[2]==2){echo 'checked';} ?>>
ไม่เคย</td>
    </tr>
  <tr>
    <td colspan="5" valign="middle">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="4" valign="middle">&nbsp;</td>
    <td width="351" align="right" valign="middle"><button> บันทึก </button> </td>
  </tr>
</table>
 </form>
<script>
$(document).ready(function () {
	
	/* ---------------------------------------------------------------------------------------- 24.1 */
	if($('#r24_1_a').is(':checked') == true){
		$('#t24_1Num').attr('disabled','disabled');
		$('#t24_1Num').removeAttr('disabled');
		$('.c24_1').show();
	}
	else
	{
		$('#t24_1Num').attr('disabled','disabled');
		$('.c24_1').hide();
	}
	
	$('#r24_1_a').click(function(){
		$('#t24_1Num').removeAttr('disabled');
		$('.c24_1').show();
	});
	
	$('#r24_1_b').click(function(){
		$('#t24_1Num').attr('disabled','disabled');
		$('.c24_1').hide();
	});
	
	/* ---------------------------------------------------------------------------------------- 24.2 */
	if($('#r24_2_a').is(':checked') == true){
		$('#t24_2num').attr('disabled','disabled');
		$('#t24_2num').removeAttr('disabled');
	}
	else
	{
		$('#t24_2num').attr('disabled','disabled');
		//$('#t24_2num').removeAttr('disabled');
	}
	
	$('#r24_2_a').click(function(){
		$('#t24_2num').removeAttr('disabled');
	});
	
	$('#r24_2_b').click(function(){
		$('#t24_2num').attr('disabled','disabled');
	});
	
	/* ---------------------------------------------------------------------------------------- 24.3.1 */
	if($('#r24_3_1_b').is(':checked') == true){
		$('#t24_3_1Cause').attr('disabled','disabled');
		$('#t24_3_1Cause').removeAttr('disabled');
	}
	else
	{
		$('#t24_3_1Cause').attr('disabled','disabled');
	}
	
	$('#r24_3_1_a').click(function(){
		
	});
});
</script>
 
 