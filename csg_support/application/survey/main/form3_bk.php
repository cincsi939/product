<link rel="stylesheet" href="../css/style.css">
<?php
error_reporting(E_ALL ^ E_NOTICE);

require_once("lib/class.function.php");
$con = new Cfunction();
$sql = 'SELECT question_24_1,question_24_1_detail,question_24_2,question_24_2_detail,question_24_4,question_24_5,question_24_5_detail,';
$sql .= 'question_24_3_1,question_24_3_1d,question_24_3_2,question_24_3_2d,question_24_3_3,question_24_3_3d,question_24_3_4,';
$sql .= 'question_24_6,question_24_7,question_24_7_detail,question_24_8_1,question_24_8_1d,question_24_8_2,question_24_8_2d';
$sql .= ' FROM question_detail_1';
$sql .= ' WHERE question_id='.$_GET['id'];
$con->connectDB();
$results = $con->select($sql);
foreach($results as $row){}

$r24_1 = $row['question_24_1'];
$question_24_1_detail = $row['question_24_1_detail'];
$r24_1_detail = explode(',',$question_24_1_detail);

$t24_1Num = $r24_1_detail [0];
$c24_YearOld_1 = $r24_1_detail [1];
$c24_YearOld_2 = $r24_1_detail [2];
$c24_YearOld_3 = $r24_1_detail [3];

$r24_2 = $row['question_24_2'];
$t24_2Num = $row['question_24_2_detail'];

$r24_3_1 = $row['question_24_3_1'];
$r24_3_2 = $row['question_24_3_2'];
$r24_3_3 = $row['question_24_3_3'];
$r24_3_4= $row['question_24_3_4'];
$t24_3_1Cause = $row['question_24_3_1d'];
$t24_3_2Cause = $row['question_24_3_2d'];
$t24_3_3Cause = $row['question_24_3_3d'];

$r24_4 = $row['question_24_4'];
$r24_5 = $row['question_24_5'];
$r24_5_detail = $row['question_24_5_detail'];
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

$r24_8_1 = $row['question_24_8_1'];
$r24_8_1d = $row['question_24_8_1d'];
$r24_8_2 = $row['question_24_8_2'];
$r24_8_2d = $row['question_24_8_2d'];

?>
<form action="main_exc/form3_exc.php" method="post" enctype="multipart/form-data">
<table width="765" border="0" >
  <tr>
    <td width="45" align="right" valign="middle"><b><u>��ǹ���3</u></b></td>
    <td colspan="4" valign="middle"><strong>����ѹ��Ҿ�ͧ��ͺ����
      <input type="hidden" name="question_id" value="<?php echo $_GET['id']; ?>">
    </strong></td>
    </tr>
  <tr>
    <td colspan="5" valign="middle"><br></td>
  </tr>
  <tr>
    <td align="right" valign="middle">24.1</td>
    <td colspan="4" valign="middle">��ͺ������Ҫԡ㹤�ͺ����˹��͡�ҡ��ҹ</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle">
      <input type="radio" name="v343" id="r24_1_a" value="1" <?php if($r24_1==1){echo 'checked';} ?>> �ըӹǹ
      <input type="text" name="t24_1Num" id="t24_1Num"  value="<?php echo $t24_1Num; ?>" size="3"> �� �к� </td>
  </tr>
  <tr class="c24_1">
    <td valign="middle">&nbsp;</td>
    <td width="40" valign="middle">&nbsp;</td>
    <td width="197" valign="middle"><input name="c24_YearOld_1" type="checkbox" id="c24_YearOld_1" value="1" <?php if($c24_YearOld_1==1){echo 'checked';} ?>>
      ���ص�ӡ��� 10 ��</td>
    <td colspan="2" valign="middle">&nbsp;</td>
    </tr>
  <tr class="c24_1">
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td valign="middle"><input name="c24_YearOld_2" type="checkbox" id="c24_YearOld_2" value="2" <?php if($c24_YearOld_2==2){echo 'checked';} ?>>
      ��� 10-15 ��</td>
    <td colspan="2" valign="middle">&nbsp;</td>
    </tr>
  <tr class="c24_1">
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td valign="middle"><input name="c24_YearOld_3" type="checkbox" id="c24_YearOld_3" value="3" <?php if($c24_YearOld_3==3){echo 'checked';} ?>>
      ���� 16 �բ���</td>
    <td colspan="2" valign="middle">&nbsp;</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="v343" id="r24_1_b" value="2" <?php if($r24_1==2){echo 'checked';} ?>>
      �����</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">24.2</td>
    <td colspan="4" valign="middle">����٧��·������� 60 �բ��� 㹤�ͺ�������Ѻ����������ҡ��Ҫԡ㹤�ͺ���������ͧ�Ѩ��� 4 ��д�ҹ�Ե�</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="v350" id="r24_2_a" value="1" <?php if($r24_2==1){echo 'checked';} ?>>
      �ըӹǹ��
      <input type="text" name="v351" id="v351" size="3" value="<?php echo $t24_2Num; ?>">
      ��</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="v350" id="r24_2_b" value="2" <?php if($r24_2==2){echo 'checked';} ?>>
      �����</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">24.3</td>
    <td colspan="4" valign="middle">��Ҫԡ㹤�ͺ�������ѡɳС�û�ԺѵԵ�͡ѹ</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td width="40" align="left" valign="middle">24.3.1 </td>
    <td colspan="3" align="left" valign="middle">�Ѻ��͡ѹ���������</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td colspan="3" align="left" valign="middle"><input type="radio" name="v352" id="r24_3_1_a" value="1" <?php if($r24_3_1==1){echo 'checked';} ?>>
      �� </td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td colspan="3" align="left" valign="middle"><input type="radio" name="v352" id="r24_3_1_b" value="2" <?php if($r24_3_1==2){echo 'checked';} ?>>
      �����&nbsp;���ͧ�ҡ 
      <input name="v353" type="text" id="v353"  value="<?php echo $t24_3_1Cause; ?>" style="width:80%"></td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" align="left" valign="middle">24.3.2 �ٴ��»�֡������͡ѹ</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td colspan="3" align="left" valign="middle"><input type="radio" name="v354" id="r24_3_2_a" value="1" <?php if($r24_3_2==1){echo 'checked';} ?>>
      �� </td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td colspan="3" align="left" valign="middle"><input type="radio" name="v354" id="r24_3_2_b" value="2" <?php if($r24_3_2==2){echo 'checked';} ?>>
      �����&nbsp;���ͧ�ҡ 
      <input type="text" id="v355" name="v355" value="<?php echo $t24_3_2Cause; ?>"  style="width:80%"></td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" align="left" valign="middle">24.3.3 �Ѻ�ѧ�����Դ�������˵ؼŢͧ��Ҫԡ㹤�ͺ����</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td colspan="3" align="left" valign="middle"><input type="radio" name="v356" id="r24_3_3_a" value="1" <?php if($r24_3_3==1){echo 'checked';} ?>>
      �� </td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td colspan="3" align="left" valign="middle"><input type="radio" name="v356" id="r24_3_3_b" value="2" <?php if($r24_3_3==2){echo 'checked';} ?>>
      �����&nbsp;���ͧ�ҡ 
      <input name="v357" type="text" id="v357" value="<?php echo $t24_3_3Cause; ?>"  style="width:80%"></td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" align="left" valign="middle">24.3.4 ��Ҫԡ㹤�ͺ�����ա�÷ӡԨ���������ѹ&nbsp;��&nbsp;�ҹ�����&nbsp;��١�����&nbsp;�͹��ú�ҹ</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td valign="middle"><input type="radio" name="v358" id="r24_3_" value="1" <?php if($r24_3_4==1){echo 'checked';} ?>>
�� </td>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td valign="middle"><input type="radio" name="v358" id="r24_3_7" value="2" <?php if($r24_3_4==2){echo 'checked';} ?>>
�����</td>
    <td width="110" valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">24.4</td>
    <td colspan="4" valign="middle">��䢻ѭ��੾��˹�Ңͧ��ͺ���������ѹ</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="v360" id="r24_4" value="1" <?php if($r24_4==1){echo 'checked';} ?>>
      �����������ѭ��      </td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="v360" id="r24_4" value="2" <?php if($r24_4==2){echo 'checked';} ?>>
������ѭ�Һҧ����</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="v360" id="r24_4" value="3" <?php if($r24_4==3){echo 'checked';} ?>>
      ������ѭ�ҷء����</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">24.5</td>
    <td colspan="4" valign="middle">�ա�á�ͻѭ�Ҥ�����ʹ��͹������ͺ����</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="v361" id="r24_5_a" value="1" <?php if($r24_5==1){echo 'checked';} ?>>
      �¡�ͻѭ��&nbsp;</td>
  </tr>
  <tr class="24_5cb">
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle"><input name="v362" type="checkbox" id="v362" value="1" <?php if($r24_5_detail[0]==1){echo 'checked';} ?>>
      ���������ҷ&nbsp;�ӹǹ
      <input type="text" name="v365" id="v365" size="3" value="<?php echo $r24_5_detail[1];  ?>">
      ����</td>
    </tr>
  <tr class="24_5cb">
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle">
      <input name="v363" type="checkbox" id="v363" value="1" <?php if($r24_5_detail[2]==1){echo 'checked';} ?>>
      �Դ���ʾ�Դ
      �ӹǹ
<input type="text" name="v366" id="v366"  size="3"  value="<?php echo $r24_5_detail[3];  ?>">
      ����</td>
    </tr>
  <tr class="24_5cb">
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle">      <input name="v364" type="checkbox" id="v364" value="1" <?php if($r24_5_detail[4]==1){echo 'checked';} ?>>
      �վĵԡ�������§�ҧ��&nbsp;�ӹǹ
      <input type="text" name="v367" id="v367" size="3" value="<?php echo $r24_5_detail[5];  ?>">
      ����</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="v361" id="r24_5_b" value="2" <?php if($r24_5==2){echo 'checked';} ?>>
      ����¡�ͻѭ��</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">24.6</td>
    <td colspan="4" valign="middle">�����Сѹ�֧��鹷غ��&nbsp;��������ҧ���/�Ե�&nbsp;���;ٴ����Һ���</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="2" valign="middle"><input type="radio" name="v368" id="" value="1" <?php if($r24_6==1){echo 'checked';} ?>>
      �繻�Ш�</td>
    <td colspan="2" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td colspan="2" valign="middle"><input type="radio" name="v368" id="r24_" value="2" <?php if($r24_6==2){echo 'checked';} ?>>
�����</td>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle">24.7</td>
    <td colspan="4" valign="middle">��Ҫԡ㹤�ͺ����&nbsp;��������Ԩ�����ҧ�ѧ����Чҹ���ླշ���Ӥѭ</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="r24_7" id="r24_7_a" value="1" <?php if($r24_7==1){echo 'checked';} ?>>
      ����ǹ���� </td>
  </tr>
  <tr class="24_7">
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle"><input type="radio" name="r24_7_detail" id="r24_4" value="1" <?php if($r24_7_detail==1){echo 'checked';} ?>>
      ���¡��� 5 ����/��</td>
    </tr>
  <tr class="24_7">
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle"><input type="radio" name="r24_7_detail" id="r24_5" value="2" <?php if($r24_7_detail==2){echo 'checked';} ?>>
      ���¡��� 5-10 ����/��</td>
    </tr>
  <tr class="24_7">
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle"><input type="radio" name="r24_7_detail" id="r24_3" value="3" <?php if($r24_7_detail==3){echo 'checked';} ?>>
      �ҡ���� 10 ����/��</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td colspan="4" valign="middle"><input type="radio" name="r24_7" id="r24_7_b" value="2" <?php if($r24_7==2){echo 'checked';} ?>>
      �����&nbsp;���ͧ�ҡ
  <input name="v370" type="text" id="t24_7"  style="width:85%" value="<?php echo $r24_7_detail_2; ?>"></td>
  </tr>
  <tr>
    <td align="right" valign="middle">24.8</td>
    <td colspan="4" valign="middle">��ͺ����&nbsp;���Ѻ��ê�������ͨҡ˹��§ҹ�ͧ�Ѱ&nbsp;�����ͧ���仹��</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td align="left" valign="middle">24.8.1 </td>
    <td colspan="3" align="left" valign="middle">������纻���&nbsp;��Ҫԡ㹤�ͺ���������ԡ�èҡ�ç��Һ����������آ�Ҿ�Ӻ������ç��Һ��&nbsp;�������</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle"><input type="radio" name="v371" id="r24_8_1_a" value="1" <?php if($r24_8_1==1){echo 'checked';} ?>>
      ����</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle"><input type="radio" name="v371" id="r24_8_1_b" value="2" <?php if($r24_8_1==2){echo 'checked';} ?>>
      �������&nbsp;&nbsp;&nbsp;�к����˵�
      <input name="v372" type="text" id="t24_8_1"   style="width:75%"  value="<?php echo $r24_8_1d; ?>"></td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td align="left" valign="top">24.8.2 </td>
    <td colspan="3" align="left" valign="middle">��Ҫԡ㹤�ͺ���Ǥ�㴤�˹�������Ѻ��ԡ�ê��������㹡�û�Сͺ�Ҫվ �������</td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle"><input type="radio" name="v373" id="r24_8_2_a" value="1" <?php if($r24_8_2==1){echo 'checked';} ?>>
��&nbsp;&nbsp;�к�&nbsp;
<input name="t24_8_2Detail" type="text" id="t24_8_2" style="width:83%"  value="<?php echo $r24_8_2d; ?>"></td>
    </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td colspan="3" valign="middle"><input type="radio" name="v373" id="r24_8_2_b" value="2" <?php if($r24_8_2==2){echo 'checked';} ?>>
�����</td>
    </tr>
  <tr>
    <td colspan="5" valign="middle">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="4" valign="middle">&nbsp;</td>
    <td width="351" align="right" valign="middle"><button> ���Թ��õ�� </button> </td>
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
	$('#t24_3_1Cause').attr('disabled','disabled');
	if($('#r24_3_1_a').is(':checked') == true){
		$('#t24_3_1Cause').attr('disabled','disabled');
	}
	if($('#r24_3_1_b').is(':checked') == true){
		$('#t24_3_1Cause').removeAttr('disabled');
	}
	
	$('#r24_3_1_b').click(function(){
		$('#t24_3_1Cause').removeAttr('disabled');
	});
	$('#r24_3_1_a').click(function(){
		$('#t24_3_1Cause').attr('disabled','disabled');
	});
	/*--------------------------------------------------------------------------------------------24.3.2*/
	$('#t24_3_2Cause').attr('disabled','disabled');
	$('#t24_3_2Cause').attr('disabled','disabled');
	if($('#r24_3_2_a').is(':checked') == true){
		$('#t24_3_2Cause').attr('disabled','disabled');
	}
	if($('#r24_3_2_b').is(':checked') == true){
		$('#t24_3_2Cause').removeAttr('disabled');
	}
	
	$('#r24_3_2_b').click(function(){
		$('#t24_3_2Cause').removeAttr('disabled');
	});
	$('#r24_3_2_a').click(function(){
		$('#t24_3_2Cause').attr('disabled','disabled');
	});
	
	/*--------------------------------------------------------------------------------------------24.3.3*/
	$('#t24_3_3Cause').attr('disabled','disabled');
	if($('#r24_3_3_a').is(':checked') == true){
		$('#t24_3_3Cause').attr('disabled','disabled');
		//$('#t24_3_1Cause').removeAttr('disabled');
	}
	if($('#r24_3_3_b').is(':checked') == true){
		$('#t24_3_3Cause').removeAttr('disabled');
	}
	
	$('#r24_3_3_b').click(function(){
		$('#t24_3_3Cause').removeAttr('disabled');
	});
	$('#r24_3_3_a').click(function(){
		$('#t24_3_3Cause').attr('disabled','disabled');
	});
/*----------------------------------------------------24.5----------------------------------------------*/	
	$('#t24_5Num_1').attr('disabled','disabled');
	$('#t24_5Num_2').attr('disabled','disabled');
	$('#t24_5Num_3').attr('disabled','disabled');
	$('.24_5cb').hide();
	if($('#r24_5_a').is(':checked')==true){
		$('.24_5cb').show();
	}
	if($('#c24_5Detail_1').is(':checked')==true){
		$('#t24_5Num_1').removeAttr('disabled');
	}
	if($('#c24_5Detail_2').is(':checked')==true){
		$('#t24_5Num_2').removeAttr('disabled');
	}
	if($('#c24_5Detail_3').is(':checked')==true){
		$('#t24_5Num_3').removeAttr('disabled');
	}
	$('#r24_5_b').click(function(){
	$('.24_5cb').hide();
	$('#t24_5Num_1').attr('disabled','disabled');
	$('#t24_5Num_2').attr('disabled','disabled');
	$('#t24_5Num_3').attr('disabled','disabled');
	$('#c24_5Detail_1').removeAttr('checked');
	$('#c24_5Detail_2').removeAttr('checked');
	$('#c24_5Detail_3').removeAttr('checked');
	});
	
	$('#r24_5_a').click(function(){
		$('.24_5cb').show();
	});
	
	$('#c24_5Detail_1').click(function(){
		//$('#t24_5Num_1').removeAttr('disabled');
	if($('#c24_5Detail_1').is(':checked')==true){
			$('#t24_5Num_1').removeAttr('disabled');
		}
	if($('#c24_5Detail_1').is(':checked')==false){	
			$('#t24_5Num_1').attr('disabled','disabled');
			}
	});
	
	$('#c24_5Detail_2').click(function(){
	if($('#c24_5Detail_2').is(':checked')==true){
			$('#t24_5Num_2').removeAttr('disabled');
		}
	if($('#c24_5Detail_2').is(':checked')==false){	
			$('#t24_5Num_2').attr('disabled','disabled');
			}
	});
	
	$('#c24_5Detail_3').click(function(){
	if($('#c24_5Detail_3').is(':checked')==true){
			$('#t24_5Num_3').removeAttr('disabled');
		}
	if($('#c24_5Detail_3').is(':checked')==false){	
			$('#t24_5Num_3').attr('disabled','disabled');
			}
	});
/*----------------------------------------------------24.7----------------------------------------------*/	
	$('#t24_7').attr('disabled','disabled');
	$('.24_7').hide();
	//24_7_a
	if($('#r24_7_a').is(':checked') == true){
		$('#t24_7').attr('disabled','disabled');
	}
	if($('#r24_7_b').is(':checked') == true){
		$('.24_7').hide();
		$('#t24_7').removeAttr('disabled');
		}
	if($('#r24_7_a').is(':checked')==true){
		$('.24_7').show();
		}
	$('#r24_7_a').click(function(){
		$('.24_7').show();
		$('#t24_7').attr('disabled','disabled');
		});
		//r24_7_b
	$('#r24_7_b').click(function(){
		$('.24_7').hide();
		$('#t24_7').removeAttr('disabled');
		});
/*-------------------------------------------------------------24.8-------------------------------------*/
//24.8.1
	$('#t24_8_1').attr('disabled','disabled');
	if($('#r24_8_1_b').is(':checked')==true){
			$('#t24_8_1').removeAttr('disabled');
		}
	$('#r24_8_1_b').click(function(){
			$('#t24_8_1').removeAttr('disabled');
		});
	$('#r24_8_1_a').click(function(){
			$('#t24_8_1').attr('disabled','disabled');
		});
//24.8.2
	$('#t24_8_2').attr('disabled','disabled');
	if($('#r24_8_2_a').is(':checked')==true){
			$('#t24_8_2').removeAttr('disabled');
		}
	$('#r24_8_2_a').click(function(){
			$('#t24_8_2').removeAttr('disabled');
		});
	$('#r24_8_2_b').click(function(){
			$('#t24_8_2').attr('disabled','disabled');
		});
});
</script>
 
 