
<table width="100%" border="0" cellpadding="0" cellspacing="0" height="67" style="background-image:url('images/bg_tab.png');">
  <tbody><tr>
    <td width="50" align="left">
    <br>
    &nbsp;
<? /*<img src="images/arrow_left.png" align="absmiddle" border="0">*/?>
      </td>
    <td width="25%" align="left">
    <br>
    <span class="infomenu_next"></span>
    </td>
    <td style="background-image:url('images/background_tab.png'); background-position:center; background-repeat:no-repeat;" width="448" align="center">
    <br>
   <span class="infomenu"><? echo $menu1;?></span>
    </td>
    <td width="25%" align="right">
    <br>
    <span class="infomenu_next"><a href="?id=<? echo $_GET['id'];?>&frame=form2<? if (!empty($_GET['report_type'])){ echo "&report_type=".$_GET['report_type']; }?>"  class="infomenu_next"><? echo $menu2;?></a></span>
    </td>
    <td width="50" align="right">
    <br>
  <a href="?id=<? echo $_GET['id'];?>&frame=form2<? if (!empty($_GET['report_type'])){ echo "&report_type=".$_GET['report_type']; }?>"><img src="images/arrow_right.png" align="absmiddle" border="0"></a>
        &nbsp;
    </td>
  </tr>
</tbody></table>



<div class="container">
	<div class="infodata" >
<table width="100%" height="200" border="0"  class="personal_tb">
      <tr>
        <td height="28" colspan="4" align="left" valign="top" bgcolor="#f2f2f2"><div class="infodata_font">���������˹�Ҥ�ͺ����</div></td>
      </tr>
  <tr>
    <td align="center" valign="top">
	
<table width="95%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td colspan="2" align="left" valign="top" class="td_question">�ѡɳз������</td>
            </tr>
          <tr>
            <td width="2%" align="left" valign="top" class="td_question">&nbsp;</td>
            <td width="98%" align="left" valign="top" class="td_question"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="20%" align="left" valign="top">�ѡɳТͧ��ҹ </td>
                <td width="30%" align="left" valign="top"><span class="td_answer"><?php echo $question_stypehome_1; ?></span></td>
                <td width="20%" align="left" valign="top">��Ҿ��ҹ</td>
                <td width="30%" align="left" valign="top"><span class="td_answer"><?php echo $question_stypehome_2; ?></span></td>
              </tr>
            </table>              </td>
          </tr>
          <tr>
            <td align="left" valign="top" class="td_answer">&nbsp;</td>
            <td align="left" valign="top" class="td_answer"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="20%" align="left" valign="top">��ͧ�آ�</td>
                <td width="30%" align="left" valign="top" class="td_answer"><span class="td_answer"><?php echo $question_stypehome_3; ?></span></td>
                <td width="20%" align="left" valign="top">��Ҿ�Ǵ����</td>
                <td width="30%" align="left" valign="top" class="td_answer"><span class="td_answer"><?php echo $question_environment; ?></span></td>
                </tr>
            </table></td>
          </tr>
<? /*
          <tr>
            <td colspan="2" align="left" valign="top" class="td_question">�Ҫվ��ѡ�ͧ���˹�Ҥ�ͺ����</td>
            </tr>
			          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer">
<? if(in_array(1,$question_career)){echo '�Ѻ��ҧ�����';} ?>	
<? if(in_array(2,$question_career)){echo '�ɵá�';} ?>		
<? if(in_array(3,$question_career)){echo '�����';} ?>	
<? if(in_array(4,$question_career)){echo '����Ҫ���/�١��ҧ���;�ѡ�ҹ�ͧ�Ѱ';} ?>	
<? if(in_array(5,$question_career)){echo '��ѡ�ҹ�Ѱ����ˡԨ';} ?>	
<? if(in_array(6,$question_career)){echo '���˹�ҷ��ͧ��û���ͧ��ͧ���';} ?>	
<? if(in_array(7,$question_career)){echo '��Ң��/��áԨ��ǹ���';} ?>	
<? if(in_array(8,$question_career)){echo '��ѡ�ҹ/�١��ҧ�͡��';} ?>	
<? if(in_array(9,$question_career)){echo '��ҧ�ҹ/����էҹ��';} ?>	
<? if(in_array(10,$question_career)){
echo '���� �к� '.$question_career_detail;
} ?>			</td>
            </tr>
			
         <tr>
            <td colspan="2" align="left" valign="top" class="td_question">���������¢ͧ��ͺ����</td>
            </tr>
			          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer"><?php if($question_Income ==0){
echo '����к�';
} else {
echo str_replace('.00','',number_format($question_Income,2)).' �ҷ��ͻ�';
} ?> </td>
            </tr>
			
			*/?>
          <tr>
            <td colspan="2" align="left" valign="top" style="padding:0px;">
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td width="20%" align="left" valign="top" class="td_question">��ͺ�����շ��Թ�ӡԹ</td>
    <td width="30%" align="left" valign="top"><span class="td_answer">
      <?php 
if($question_land==1){
echo ' ��';
if ($question_land_detail != "" ){ echo " �ӹǹ ".$question_land_detail;}
} else if($question_land==2){
echo "�����";
} else {
echo "-";
}
?>
    </span></td>
    <td width="20%" align="left" valign="top" class="td_question">��ҹ�Ҿ����</td>
    <td width="30%" align="left" valign="top"><span class="td_answer">
      <?php 
if($question_status==1){echo '�ʴ';} else 
if($question_status==2){echo '����';} else 
if($question_status==3){echo '������ҧ';} else 
if($question_status==4){echo '��������ͧ�ҡ����������ª��Ե';} else 
if($question_status==5){
echo '�¡�ѹ����';
if($question_status_detail==1){echo ' - �¡�ѹ������Ǥ��ǵ����͵�ŧ�����͵�ŧ�����ҧ�������';} else 
if($question_status_detail==2){echo ' - �¡�ѹ������Ǥ��ǵ����������';}  


} else { echo "-";}
?>
    </span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="td_question">��ʹ���ѡ�ͧ��ͺ����</td>
    <td align="left" valign="top"><span class="td_answer">
      <?php 
 if($question_religion==1){echo '�ط�';} else 
 if($question_religion==2){echo '���ʵ�';} else 
 if($question_religion==3){echo '������';} else 
 if($question_religion==4){
	 echo '��� � ';
	 if ($question_religion_detail != ""){ echo " �к� ".$question_religion_detail;}
 } else { echo "-";}
 ?>
    </span></td>
    <td align="left" valign="top" class="td_question">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="td_question">�ѡɳ��ç���ҧ��ͺ����</td>
    <td colspan="3" align="left" valign="top" class="td_answer">
      <?php 
if($question_structure==1){
echo '��ͺ�������� �ӹǹ��Ҫԡ '.$tMemberFamily_1.' �� ��� '.$tMemberMale_1.' ��  ˭ԧ '.$tMemberFemale_1.' �� <strong>*��ͺ���Ƿ���Сͺ���¾�� ��� ����١����ѧ������觧ҹ</strong>';
} else if ($question_structure == 2) {
	 echo "��ͺ���Ǣ��� ";
	 if($rLargeFamily==1){
		 echo "��ͺ���Ǣ��·���Сͺ�������� � �������͹���������ѹ ���Ф������͹ <u>�դ�������ѹ���͡ѹ</u>";
		 echo "<br>�ӹǹ��Ҫԡ  ".$tMemberFamily_2_1."  �� ��� ".$tMemberMale_2_1." ��  ˭ԧ ".$tMemberFemale_2_1." ��"; 
	 } else if($rLargeFamily==2){
		 echo "��ͺ���Ǣ��·���Сͺ�������� � �������͹���������ѹ ���Ф������͹ <u>�դ�������е�͡ѹ</u>㹡�ô��Թ���Ե��ͺ���Ǣͧ���ͧ";
		 echo "<br>�ӹǹ��Ҫԡ  ".$tMemberFamily_2_2."  �� ��� ".$tMemberMale_2_2." ��  ˭ԧ ".$tMemberFemale_2_2." ��"; 
	 }
} else if($question_structure==3){
	echo '��ͺ�����ѡɳо����';
	if($rSpecialFamily==1){echo " - ��ͺ���Ƿ������պص�";} else 
	if($rSpecialFamily==2){echo " - ��ͺ���Ǿ�������������§�����";} else 
	if($rSpecialFamily==3){echo " - ��ͺ���Ǻصúح����";} else 
	if($rSpecialFamily==4){echo " - ��ͺ�����ȷҧ���͡";} else 
	if($rSpecialFamily==5){echo " - ��ͺ�����ػ�����";} else 
	if($rSpecialFamily==6){echo " - ��� � ".$tSpecialFamily_3;} 

}

?></td>
    </tr>
</table>			</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_question">�ӹǹ��Ҫԡ㹤�ͺ���Ƿ�������о�觾ԧ�٧</td>
            </tr>
			          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer">
 <?php 
 if($question_defective==1){
 echo '�����';
 } else if($question_defective==2){

?>
<table class="td_answer personal_tb">
 <tr>
              <td colspan="2">�ӹǹ <?php echo $tDefective;  ?> ��</td>
            </tr>
<? if ( $tChild != "" and $tChild > 0){?>
            <tr>
              <td> - �ӹǹ����� (0-4��)</td>
              <td><?php echo $tChild;  ?> ��</td>
            </tr>
<? } ?>
<? if ( $tDisabled != "" and $tDisabled > 0){?>
            <tr>
              <td> - �ӹǹ���ԡ��</td>
              <td><?php echo $tDisabled;  ?> ��</td>
            </tr>
<? } ?>
<? if ( $tMindSick != "" and $tMindSick > 0){?>
            <tr>
              <td> - �ӹǹ�����·ҧ�Ե</td>
              <td><?php echo $tMindSick;  ?> ��</td>
            </tr>
<? } ?>
<? if ( $tSick != "" and $tSick > 0){?>
            <tr>
              <td> - �ӹǹ������������ѧ</td>
              <td><?php echo $tSick;  ?> ��</td>
            </tr>
<? } ?>
<? if ( $tElderly != "" and $tElderly > 0){?>
            <tr>
              <td> - �ӹǹ����٧����</td>
              <td><?php echo $tElderly;  ?> ��</td>
            </tr>
<? } ?>
          </table>
<?
 }
 ?>			</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_question">˹���Թ㹤�ͺ����</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer">
<?php 
if($question_debt==1){
echo '�����';
} else  if($question_debt==2){
echo '��';
	if($question_debt_a==1){ 
		echo "˹����к�";
		
$t21_pay_1 = str_replace(',','',$t21_pay_1 );  $t21_pay_1 = abs($t21_pay_1);
$t21_pay_2 = str_replace(',','',$t21_pay_2 );  $t21_pay_2 = abs($t21_pay_2);
$t21_pay_3 = str_replace(',','',$t21_pay_3 );  $t21_pay_3 = abs($t21_pay_3);
$t21_pay_4 = str_replace(',','',$t21_pay_4 );  $t21_pay_4 = abs($t21_pay_4);
$t21_pay_5 = str_replace(',','',$t21_pay_5 );  $t21_pay_5 = abs($t21_pay_5);
$t21_pay_6 = str_replace(',','',$t21_pay_6 );  $t21_pay_6 = abs($t21_pay_6);
$t21_pay_7 = str_replace(',','',$t21_pay_7 );  $t21_pay_7 = abs($t21_pay_7);
$t21_pay_8 = str_replace(',','',$t21_pay_8 );  $t21_pay_8 = abs($t21_pay_8);
$t21_pay_9 = str_replace(',','',$t21_pay_9 );  $t21_pay_9 = abs($t21_pay_9);

		
$t21_balance_1 = str_replace(',','',$t21_balance_1 );  $t21_balance_1 = abs($t21_balance_1);
$t21_balance_2 = str_replace(',','',$t21_balance_2 );  $t21_balance_2 = abs($t21_balance_2);
$t21_balance_3 = str_replace(',','',$t21_balance_3 );  $t21_balance_3 = abs($t21_balance_3);
$t21_balance_4 = str_replace(',','',$t21_balance_4 );  $t21_balance_4 = abs($t21_balance_4);
$t21_balance_5 = str_replace(',','',$t21_balance_5 );  $t21_balance_5 = abs($t21_balance_5);
$t21_balance_6 = str_replace(',','',$t21_balance_6 );  $t21_balance_6 = abs($t21_balance_6);
$t21_balance_7 = str_replace(',','',$t21_balance_7 );  $t21_balance_7 = abs($t21_balance_7);
$t21_balance_8 = str_replace(',','',$t21_balance_8 );  $t21_balance_8 = abs($t21_balance_8);
$t21_balance_9 = str_replace(',','',$t21_balance_9 );  $t21_balance_9 = abs($t21_balance_9);
?>

<table width="100%" border="0" cellpadding="1" cellspacing="1"  class="td_answer personal_tb">
<?php if(in_array(1,$chk)){?>
            <tr>
              <td width="20">-</td>
              <td>�Թ��鸹Ҥ��</td>
            </tr>
            <tr id="t18_2_1_1">
              <td>&nbsp;</td>
 <td>�ӹǹ <?php echo str_replace('.00','',number_format($t21_money_1,2)) ?> �͡���������� <?php echo $t21_interest_1; ?> ���/�� �����������Թ�ӹǹ <?php  if ($t21_pay_1 != ""){echo str_replace('.00','',number_format($t21_pay_1,2)); } else { echo "-";}?> �ҷ �ʹ������� <?php echo str_replace('.00','',number_format($t21_balance_1,2)) ?> �ҷ</td>
            </tr>
<?php } ?>
<?php if(in_array(2,$chk)){?>
            <tr>
              <td width="20">-</td>
              <td>�Թ���ͧ�ع�Ѩ��������Ѿ��</td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>�ӹǹ <?php echo str_replace('.00','',number_format($t21_money_2,2)) ?> �͡���������� <?php echo $t21_interest_2; ?> ���/�� �����������Թ�ӹǹ <?php if ($t21_pay_2 != ""){echo str_replace('.00','',number_format($t21_pay_2,2)); } else { echo "-";}?> �ҷ �ʹ������� <?php echo str_replace('.00','',number_format($t21_balance_2,2)) ?> �ҷ</td>
            </tr>
<?php } ?>
<?php if(in_array(3,$chk)){?>
            <tr>
              <td width="20">-</td>
              <td>�Թ���ͧ�ع�����ҹ</td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>�ӹǹ <?php echo str_replace('.00','',number_format($t21_money_3,2)) ?> �͡���������� <?php echo $t21_interest_3; ?> ���/�� �����������Թ�ӹǹ <?php if ($t21_pay_3 != ""){echo str_replace('.00','',number_format($t21_pay_3,2)); } else { echo "-";}?> �ҷ �ʹ������� <?php echo str_replace('.00','',number_format($t21_balance_3,2)) ?> �ҷ</td>
            </tr>
<?php } ?>  
<?php if(in_array(4,$chk)){?>
            <tr>
              <td width="20">-</td>
              <td>�ͧ�ع�Ѳ�Һ��ҷʵ��</td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>�ӹǹ <?php echo str_replace('.00','',number_format($t21_money_4,2)) ?> �͡���������� <?php echo $t21_interest_4; ?> ���/�� �����������Թ�ӹǹ <?php if ($t21_pay_4 != ""){echo str_replace('.00','',number_format($t21_pay_4,2)); } else { echo "-";}?> �ҷ �ʹ������� <?php echo str_replace('.00','',number_format($t21_balance_4,2)) ?> �ҷ</td>
            </tr>
<?php } ?>
<?php if(in_array(5,$chk)){?>
            <tr>
              <td width="20">-</td>
              <td>�ͧ�ع����٧����</td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>�ӹǹ <?php echo str_replace('.00','',number_format($t21_money_5,2)) ?> �͡���������� <?php echo $t21_interest_5; ?> ���/�� �����������Թ�ӹǹ <?php if ($t21_pay_5 != ""){echo str_replace('.00','',number_format($t21_pay_5,2)); } else { echo "-";}?> �ҷ �ʹ������� <?php echo str_replace('.00','',number_format($t21_balance_5,2)) ?> �ҷ</td>
            </tr>
<?php } ?>
<?php if(in_array(6,$chk)){?>
            <tr>
              <td width="20">-</td>
              <td>�ͧ�ع��������Ѳ�Ҥس�Ҿ���Ե���ԡ��</td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>�ӹǹ <?php echo str_replace('.00','',number_format($t21_money_6,2)) ?> �͡���������� <?php echo $t21_interest_6; ?> ���/�� �����������Թ�ӹǹ <?php if ($t21_pay_6 != ""){echo str_replace('.00','',number_format($t21_pay_6,2)); } else { echo "-";}?> �ҷ �ʹ������� <?php echo str_replace('.00','',number_format($t21_balance_6,2)) ?> �ҷ</td>
            </tr>
<?php } ?>
<?php if(in_array(7,$chk)){?>
            <tr>
              <td width="20">-</td>
              <td>�ͧ�ع����</td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>�ӹǹ <?php echo str_replace('.00','',number_format($t21_money_7,2)) ?> �͡���������� <?php echo $t21_interest_7; ?> ���/�� �����������Թ�ӹǹ <?php if ($t21_pay_7 != ""){echo str_replace('.00','',number_format($t21_pay_7,2)); } else { echo "-";}?> �ҷ �ʹ������� <?php echo str_replace('.00','',number_format($t21_balance_7,2)) ?> �ҷ</td>
            </tr>
<?php } ?>
<?php if(in_array(8,$chk)){?>
            <tr>
              <td width="20">-</td>
              <td>�ͧ�ع�ɵ�</td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>�ӹǹ <?php echo str_replace('.00','',number_format($t21_money_8,2)) ?> �͡���������� <?php echo $t21_interest_8; ?> ���/�� �����������Թ�ӹǹ <?php if ($t21_pay_8 != ""){echo str_replace('.00','',number_format($t21_pay_8,2)); } else { echo "-";}?> �ҷ �ʹ������� <?php echo str_replace('.00','',number_format($t21_balance_8,2)) ?> �ҷ</td>
            </tr>
<?php } ?>
<?php if(in_array(9,$chk)){?>
            <tr>
              <td width="20">-</td>
              <td>��� � - <?php echo $t21_other; ?></td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>�ӹǹ <?php echo str_replace('.00','',number_format($t21_money_9,2)) ?> �͡���������� <?php echo $t21_interest_9; ?> ���/�� �����������Թ�ӹǹ <?php if ($t21_pay_9 != ""){echo str_replace('.00','',number_format($t21_pay_9,2)); } else { echo "-";}?> �ҷ �ʹ������� <?php echo str_replace('.00','',number_format($t21_balance_9,2)) ?> �ҷ</td>
            </tr>
<?php } ?>
          </table>
<?
	} else if($question_debt_a==2){ 
		echo "˹��͡�к� �س��˹��͡�к��ú�ҧ �кت��� - ʡ�Ŵ���";
?>
<table width="809" border="0" cellspacing="2" cellpadding="2"  class="td_answer personal_tb">
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                <td >����-ʡ�� <?php echo $tName18_2_1; ?></td>
                <td width="104" >�ӹǹ�Թ</td>
                <td width="114"><?php echo $tMoney18_2_1; ?> �ҷ</td>
                <td width="104">�͡����������</td>
                <td width="264"><?php echo $tInterest18_2_1; ?> ����ѹ/��͹/�� </td>
              </tr>
              <tr>
                <td width="191" >&nbsp;</td>
                <td >�����������Թ </td>
                <td ><?php echo $tPay18_2_1; ?> �ҷ</td>
                <td >�ʹ�������</td>
                <td ><?php echo $tBalance18_2_1; ?> �ҷ</td>
              </tr>
              <tr>
                <td >����-ʡ�� <?php echo $tName18_2_2; ?></td>
                <td >�ӹǹ�Թ</td>
                <td ><?php echo $tMoney18_2_2; ?> �ҷ</td>
                <td >�͡����������</td>
                <td ><?php echo $tInterest18_2_2; ?> ����ѹ/��͹/�� </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td >�����������Թ</td>
                <td ><?php echo $tPay18_2_2; ?> �ҷ</td>
                <td >�ʹ�������</td>
                <td ><?php echo $tBalance18_2_2; ?> �ҷ</td>
              </tr>
              <tr>
                <td >����-ʡ�� <?php echo $tName18_2_3; ?></td>
                <td>�ӹǹ�Թ</td>
                <td ><?php echo $tMoney18_2_3; ?> �ҷ</td>
                <td>�͡����������</td>
                <td ><?php echo $tInterest18_2_3; ?> ����ѹ/��͹/�� </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td>�����������Թ</td>
                <td ><?php echo $tPay18_2_3; ?> �ҷ</td>
                <td>�ʹ�������</td>
                <td ><?php echo $tBalance18_2_3; ?> �ҷ</td>
              </tr>
              <tr>
                <td >����-ʡ�� <?php echo $tName18_2_4; ?></td>
                <td>�ӹǹ�Թ</td>
                <td ><?php echo $tMoney18_2_4; ?> �ҷ</td>
                <td>�͡����������</td>
                <td ><?php echo $tInterest18_2_4; ?> ����ѹ/��͹/�� </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td>�����������Թ</td>
                <td ><?php echo $tPay18_2_4; ?> �ҷ</td>
                <td>�ʹ�������</td>
                <td ><?php echo $tBalance18_2_4; ?> �ҷ</td>
              </tr>
              <tr>
                <td >����-ʡ�� <?php echo $tName18_2_5; ?></td>
                <td>�ӹǹ�Թ</td>
                <td ><?php echo $tMoney18_2_5; ?> �ҷ</td>
                <td>�͡����������</td>
                <td ><?php echo $tInterest18_2_5; ?> ����ѹ/��͹/�� </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td>�����������Թ</td>
                <td ><?php echo $tPay18_2_5; ?> �ҷ</td>
                <td>�ʹ�������</td>
                <td ><?php echo $tBalance18_2_5; ?> �ҷ</td>
              </tr>
              <tr>
                <td >����-ʡ�� <?php echo $tName18_2_6; ?></td>
                <td>�ӹǹ�Թ</td>
                <td ><?php echo $tMoney18_2_6; ?> �ҷ</td>
                <td>�͡����������</td>
                <td ><?php echo $tInterest18_2_6; ?> ����ѹ/��͹/�� </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td>�����������Թ</td>
                <td ><?php echo $tPay18_2_6; ?> �ҷ</td>
                <td>�ʹ�������</td>
                <td ><?php echo $tBalance18_2_6; ?> �ҷ</td>
              </tr>
            </tfoot>
          </table>
<?
		
	}
}

?>			</td>
            </tr>
        </table>
	


<table width="95%" border="0" cellpadding="5" cellspacing="0" class="personal_tb">
<tr>
<td><strong>�ӹǹ��������</strong></td>
</tr>
</table>

<table width="95%" border="1" cellpadding="1" cellspacing="0" bordercolor="#CCCCCC" class="personal_tb" style="border-collapse:collapse;">
          <thead>
            <tr>
              <th height="25"  bgcolor="#f2f2f2">������</th>
              <th width="20%"  bgcolor="#f2f2f2">���</th>
              <th width="20%"  bgcolor="#f2f2f2">˭ԧ</th>
              <th width="20%"  bgcolor="#f2f2f2">���</th>
            </tr>
          </thead>
		  <? if ($tChildTotal > 0 ){?> 
          <tr>
            <td  height="25"  align="left">&nbsp;�� (���� 0-18 ��)</td>
            <td width="20%"  align="center"><?php if(!empty($tChildMale)){ echo $tChildMale; } else { echo '0';}?></td>
            <td width="20%"  align="center"><?php if(!empty($tChildFemale)){ echo $tChildFemale; } else { echo '0';}?></td>
            <td  width="20%" align="center"><?php if(!empty($tChildTotal)){ echo $tChildTotal; } else { echo '0';}?></td>
          </tr>
		  <? } ?>
		  <? if ($tTeensTotal > 0 ){?> 
          <tr>
            <td height="25"  align="left">&nbsp;���Ǫ� (���� 19-25 ��)</td>
            <td width="20%"  align="center"><?php if(!empty($tTeensMale)){ echo $tTeensMale; } else { echo '0';}?></td>
            <td width="20%"  align="center"><?php if(!empty($tTeensFemale)){ echo $tTeensFemale; } else { echo '0';}?></td>
            <td width="20%" align="center"><?php if(!empty($tTeensTotal)){ echo $tTeensTotal; } else { echo '0';}?></td>
          </tr>
		  <? } ?>
		  <? if ($tTotal > 0 ){?> 
          <tr>
            <td height="25"  align="left">&nbsp;�������·���� (���� 26-59 ��)</td>
            <td width="20%"  align="center"><?php if(!empty($tMan)){ echo $tMan; } else { echo '0';}?></td>
            <td width="20%"  align="center"><?php if(!empty($tWoman)){ echo $tWoman; } else { echo '0';}?></td>
            <td width="20%" align="center"><?php if(!empty($tTotal)){ echo $tTotal; } else { echo '0';}?></td>
          </tr>
		  <? } ?>
		  <? if ($tElderTotal > 0 ){?> 
          <tr>
            <td  height="25"  align="left">&nbsp;����٧���� (���� 60 ��)</td>
            <td width="20%"  align="center"><?php if(!empty($tElderMale)){ echo $tElderMale; } else { echo '0';}?></td>
            <td width="20%"  align="center"><?php if(!empty($tElderFemale)){ echo $tElderFemale; } else { echo '0';}?></td>
            <td width="20%" align="center"><?php if(!empty($tElderTotal)){ echo $tElderTotal; } else { echo '0';}?></td>
          </tr>
		  <? } ?>
		  <? if ($tDisabledTotal > 0 ){?>
          <tr>
            <td height="25"  align="left">&nbsp;���ԡ��</td>
            <td width="20%"  align="center"><?php if(!empty($tDisabledMale)){ echo $tDisabledMale; } else { echo '0';}?></td>
            <td width="20%"  align="center"><?php if(!empty($tDisabledFemale)){ echo $tDisabledFemale; } else { echo '0';}?></td>
            <td width="20%"  align="center"><?php if(!empty($tDisabledTotal)){ echo $tDisabledTotal; } else { echo '0';}?></td>
          </tr>
		  <? } ?>
          <tr>
            <td  height="25"  align="center">���������</td>
            <td width="20%"  align="center"><?php if(!empty($tMaleTotal)){ echo $tMaleTotal; } else { echo '0';}?></td>
            <td width="20%"  align="center"><?php if(!empty($tFemaleTotal)){ echo $tFemaleTotal; } else { echo '0';}?></td>
            <td width="20%" align="center"><?php if(!empty($tSumTotal)){ echo $tSumTotal; } else { echo '0';}?></td>
          </tr>
        </table>
		
		
	</td>
  </tr>
</table>
<br />
<br />

	</div>

</div>
<!-- End .container  -->
