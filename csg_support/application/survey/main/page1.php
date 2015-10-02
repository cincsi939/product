
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
        <td height="28" colspan="4" align="left" valign="top" bgcolor="#f2f2f2"><div class="infodata_font">ข้อมูลหัวหน้าครอบครัว</div></td>
      </tr>
  <tr>
    <td align="center" valign="top">
	
<table width="95%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td colspan="2" align="left" valign="top" class="td_question">ลักษณะที่อยู่</td>
            </tr>
          <tr>
            <td width="2%" align="left" valign="top" class="td_question">&nbsp;</td>
            <td width="98%" align="left" valign="top" class="td_question"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="20%" align="left" valign="top">ลักษณะของบ้าน </td>
                <td width="30%" align="left" valign="top"><span class="td_answer"><?php echo $question_stypehome_1; ?></span></td>
                <td width="20%" align="left" valign="top">สภาพบ้าน</td>
                <td width="30%" align="left" valign="top"><span class="td_answer"><?php echo $question_stypehome_2; ?></span></td>
              </tr>
            </table>              </td>
          </tr>
          <tr>
            <td align="left" valign="top" class="td_answer">&nbsp;</td>
            <td align="left" valign="top" class="td_answer"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="20%" align="left" valign="top">ห้องสุขา</td>
                <td width="30%" align="left" valign="top" class="td_answer"><span class="td_answer"><?php echo $question_stypehome_3; ?></span></td>
                <td width="20%" align="left" valign="top">สภาพแวดล้อม</td>
                <td width="30%" align="left" valign="top" class="td_answer"><span class="td_answer"><?php echo $question_environment; ?></span></td>
                </tr>
            </table></td>
          </tr>
<? /*
          <tr>
            <td colspan="2" align="left" valign="top" class="td_question">อาชีพหลักของหัวหน้าครอบครัว</td>
            </tr>
			          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer">
<? if(in_array(1,$question_career)){echo 'รับจ้างทั่วไป';} ?>	
<? if(in_array(2,$question_career)){echo 'เกษตรกร';} ?>		
<? if(in_array(3,$question_career)){echo 'ประมง';} ?>	
<? if(in_array(4,$question_career)){echo 'ข้าราชการ/ลูกจ้างหรือพนักงานของรัฐ';} ?>	
<? if(in_array(5,$question_career)){echo 'พนักงานรัฐวิสาหกิจ';} ?>	
<? if(in_array(6,$question_career)){echo 'เจ้าหน้าที่องค์กรปกครองท้องถิ่น';} ?>	
<? if(in_array(7,$question_career)){echo 'ค้าขาย/ธุรกิจส่วนตัว';} ?>	
<? if(in_array(8,$question_career)){echo 'พนักงาน/ลูกจ้างเอกชน';} ?>	
<? if(in_array(9,$question_career)){echo 'ว่างงาน/ไม่มีงานทำ';} ?>	
<? if(in_array(10,$question_career)){
echo 'อื่นๆ ระบุ '.$question_career_detail;
} ?>			</td>
            </tr>
			
         <tr>
            <td colspan="2" align="left" valign="top" class="td_question">รายได้เฉลี่ยของครอบครัว</td>
            </tr>
			          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer"><?php if($question_Income ==0){
echo 'ไม่ระบุ';
} else {
echo str_replace('.00','',number_format($question_Income,2)).' บาทต่อปี';
} ?> </td>
            </tr>
			
			*/?>
          <tr>
            <td colspan="2" align="left" valign="top" style="padding:0px;">
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td width="20%" align="left" valign="top" class="td_question">ครอบครัวมีที่ดินทำกิน</td>
    <td width="30%" align="left" valign="top"><span class="td_answer">
      <?php 
if($question_land==1){
echo ' มี';
if ($question_land_detail != "" ){ echo " จำนวน ".$question_land_detail;}
} else if($question_land==2){
echo "ไม่มี";
} else {
echo "-";
}
?>
    </span></td>
    <td width="20%" align="left" valign="top" class="td_question">สภานภาพสมรส</td>
    <td width="30%" align="left" valign="top"><span class="td_answer">
      <?php 
if($question_status==1){echo 'โสด';} else 
if($question_status==2){echo 'สมรส';} else 
if($question_status==3){echo 'หย่าร้าง';} else 
if($question_status==4){echo 'หม้ายเนื่องจากคู่สมรสเสียชีวิต';} else 
if($question_status==5){
echo 'แยกกันอยู่';
if($question_status_detail==1){echo ' - แยกกันอยู่ชั่วคราวตามข้อตกลงตามข้อตกลงระหว่างคู่สมรส';} else 
if($question_status_detail==2){echo ' - แยกกันอยู่ชั่วคราวตามคำสั่งศาล';}  


} else { echo "-";}
?>
    </span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="td_question">ศาสนาหลักของครอบครัว</td>
    <td align="left" valign="top"><span class="td_answer">
      <?php 
 if($question_religion==1){echo 'พุทธ';} else 
 if($question_religion==2){echo 'คริสต์';} else 
 if($question_religion==3){echo 'อิสลาม';} else 
 if($question_religion==4){
	 echo 'อื่น ๆ ';
	 if ($question_religion_detail != ""){ echo " ระบุ ".$question_religion_detail;}
 } else { echo "-";}
 ?>
    </span></td>
    <td align="left" valign="top" class="td_question">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="td_question">ลักษณะโครงสร้างครอบครัว</td>
    <td colspan="3" align="left" valign="top" class="td_answer">
      <?php 
if($question_structure==1){
echo 'ครอบครัวเดียว จำนวนสมาชิก '.$tMemberFamily_1.' คน ชาย '.$tMemberMale_1.' คน  หญิง '.$tMemberFemale_1.' คน <strong>*ครอบครัวที่ประกอบด้วยพ่อ แม่ และลูกที่ยังไม่ได้แต่งงาน</strong>';
} else if ($question_structure == 2) {
	 echo "ครอบครัวขยาย ";
	 if($rLargeFamily==1){
		 echo "ครอบครัวขยายที่ประกอบด้วยหลาย ๆ ครัวเรือนอยู่ร่วมกัน แต่ละครัวเรือน <u>มีความสัมพันธ์ต่อกัน</u>";
		 echo "<br>จำนวนสมาชิก  ".$tMemberFamily_2_1."  คน ชาย ".$tMemberMale_2_1." คน  หญิง ".$tMemberFemale_2_1." คน"; 
	 } else if($rLargeFamily==2){
		 echo "ครอบครัวขยายที่ประกอบด้วยหลาย ๆ ครัวเรือนอยู่ร่วมกัน แต่ละครัวเรือน <u>มีความอิสระต่อกัน</u>ในการดำเนินชีวิตครอบครัวของตนเอง";
		 echo "<br>จำนวนสมาชิก  ".$tMemberFamily_2_2."  คน ชาย ".$tMemberMale_2_2." คน  หญิง ".$tMemberFemale_2_2." คน"; 
	 }
} else if($question_structure==3){
	echo 'ครอบครัวลักษณะพิเศษ';
	if($rSpecialFamily==1){echo " - ครอบครัวที่ไม่มีบุตร";} else 
	if($rSpecialFamily==2){echo " - ครอบครัวพ่อหรือแม่เลี้ยงเดี่ยว";} else 
	if($rSpecialFamily==3){echo " - ครอบครัวบุตรบุญธรรม";} else 
	if($rSpecialFamily==4){echo " - ครอบครัวเพศทางเลือก";} else 
	if($rSpecialFamily==5){echo " - ครอบครัวอุปถัมภ์";} else 
	if($rSpecialFamily==6){echo " - อื่น ๆ ".$tSpecialFamily_3;} 

}

?></td>
    </tr>
</table>			</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_question">จำนวนสมาชิกในครอบครัวที่มีภาวะพึ่งพิงสูง</td>
            </tr>
			          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer">
 <?php 
 if($question_defective==1){
 echo 'ไม่มี';
 } else if($question_defective==2){

?>
<table class="td_answer personal_tb">
 <tr>
              <td colspan="2">จำนวน <?php echo $tDefective;  ?> คน</td>
            </tr>
<? if ( $tChild != "" and $tChild > 0){?>
            <tr>
              <td> - จำนวนเด็กเล็ก (0-4ปี)</td>
              <td><?php echo $tChild;  ?> คน</td>
            </tr>
<? } ?>
<? if ( $tDisabled != "" and $tDisabled > 0){?>
            <tr>
              <td> - จำนวนผู้พิการ</td>
              <td><?php echo $tDisabled;  ?> คน</td>
            </tr>
<? } ?>
<? if ( $tMindSick != "" and $tMindSick > 0){?>
            <tr>
              <td> - จำนวนผู้ป่วยทางจิต</td>
              <td><?php echo $tMindSick;  ?> คน</td>
            </tr>
<? } ?>
<? if ( $tSick != "" and $tSick > 0){?>
            <tr>
              <td> - จำนวนผู้ป่วยเรื้อรัง</td>
              <td><?php echo $tSick;  ?> คน</td>
            </tr>
<? } ?>
<? if ( $tElderly != "" and $tElderly > 0){?>
            <tr>
              <td> - จำนวนผู้สูงอายุ</td>
              <td><?php echo $tElderly;  ?> คน</td>
            </tr>
<? } ?>
          </table>
<?
 }
 ?>			</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_question">หนี้สินในครอบครัว</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer">
<?php 
if($question_debt==1){
echo 'ไม่มี';
} else  if($question_debt==2){
echo 'มี';
	if($question_debt_a==1){ 
		echo "หนี้ในระบบ";
		
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
              <td>เงินกู้ธนาคาร</td>
            </tr>
            <tr id="t18_2_1_1">
              <td>&nbsp;</td>
 <td>จำนวน <?php echo str_replace('.00','',number_format($t21_money_1,2)) ?> ดอกเบี้ยร้อยละ <?php echo $t21_interest_1; ?> ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน <?php  if ($t21_pay_1 != ""){echo str_replace('.00','',number_format($t21_pay_1,2)); } else { echo "-";}?> บาท ยอดคงเหลือ <?php echo str_replace('.00','',number_format($t21_balance_1,2)) ?> บาท</td>
            </tr>
<?php } ?>
<?php if(in_array(2,$chk)){?>
            <tr>
              <td width="20">-</td>
              <td>เงินกู้กองทุนสัจจะสะสมทรัพย์</td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>จำนวน <?php echo str_replace('.00','',number_format($t21_money_2,2)) ?> ดอกเบี้ยร้อยละ <?php echo $t21_interest_2; ?> ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน <?php if ($t21_pay_2 != ""){echo str_replace('.00','',number_format($t21_pay_2,2)); } else { echo "-";}?> บาท ยอดคงเหลือ <?php echo str_replace('.00','',number_format($t21_balance_2,2)) ?> บาท</td>
            </tr>
<?php } ?>
<?php if(in_array(3,$chk)){?>
            <tr>
              <td width="20">-</td>
              <td>เงินกู้กองทุนหมู่บ้าน</td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>จำนวน <?php echo str_replace('.00','',number_format($t21_money_3,2)) ?> ดอกเบี้ยร้อยละ <?php echo $t21_interest_3; ?> ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน <?php if ($t21_pay_3 != ""){echo str_replace('.00','',number_format($t21_pay_3,2)); } else { echo "-";}?> บาท ยอดคงเหลือ <?php echo str_replace('.00','',number_format($t21_balance_3,2)) ?> บาท</td>
            </tr>
<?php } ?>  
<?php if(in_array(4,$chk)){?>
            <tr>
              <td width="20">-</td>
              <td>กองทุนพัฒนาบทบาทสตรี</td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>จำนวน <?php echo str_replace('.00','',number_format($t21_money_4,2)) ?> ดอกเบี้ยร้อยละ <?php echo $t21_interest_4; ?> ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน <?php if ($t21_pay_4 != ""){echo str_replace('.00','',number_format($t21_pay_4,2)); } else { echo "-";}?> บาท ยอดคงเหลือ <?php echo str_replace('.00','',number_format($t21_balance_4,2)) ?> บาท</td>
            </tr>
<?php } ?>
<?php if(in_array(5,$chk)){?>
            <tr>
              <td width="20">-</td>
              <td>กองทุนผู้สูงอายุ</td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>จำนวน <?php echo str_replace('.00','',number_format($t21_money_5,2)) ?> ดอกเบี้ยร้อยละ <?php echo $t21_interest_5; ?> ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน <?php if ($t21_pay_5 != ""){echo str_replace('.00','',number_format($t21_pay_5,2)); } else { echo "-";}?> บาท ยอดคงเหลือ <?php echo str_replace('.00','',number_format($t21_balance_5,2)) ?> บาท</td>
            </tr>
<?php } ?>
<?php if(in_array(6,$chk)){?>
            <tr>
              <td width="20">-</td>
              <td>กองทุนส่งเสริมพัฒนาคุณภาพชีวิตคนพิการ</td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>จำนวน <?php echo str_replace('.00','',number_format($t21_money_6,2)) ?> ดอกเบี้ยร้อยละ <?php echo $t21_interest_6; ?> ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน <?php if ($t21_pay_6 != ""){echo str_replace('.00','',number_format($t21_pay_6,2)); } else { echo "-";}?> บาท ยอดคงเหลือ <?php echo str_replace('.00','',number_format($t21_balance_6,2)) ?> บาท</td>
            </tr>
<?php } ?>
<?php if(in_array(7,$chk)){?>
            <tr>
              <td width="20">-</td>
              <td>กองทุนปุ๋ย</td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>จำนวน <?php echo str_replace('.00','',number_format($t21_money_7,2)) ?> ดอกเบี้ยร้อยละ <?php echo $t21_interest_7; ?> ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน <?php if ($t21_pay_7 != ""){echo str_replace('.00','',number_format($t21_pay_7,2)); } else { echo "-";}?> บาท ยอดคงเหลือ <?php echo str_replace('.00','',number_format($t21_balance_7,2)) ?> บาท</td>
            </tr>
<?php } ?>
<?php if(in_array(8,$chk)){?>
            <tr>
              <td width="20">-</td>
              <td>กองทุนเกษตร</td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>จำนวน <?php echo str_replace('.00','',number_format($t21_money_8,2)) ?> ดอกเบี้ยร้อยละ <?php echo $t21_interest_8; ?> ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน <?php if ($t21_pay_8 != ""){echo str_replace('.00','',number_format($t21_pay_8,2)); } else { echo "-";}?> บาท ยอดคงเหลือ <?php echo str_replace('.00','',number_format($t21_balance_8,2)) ?> บาท</td>
            </tr>
<?php } ?>
<?php if(in_array(9,$chk)){?>
            <tr>
              <td width="20">-</td>
              <td>อื่น ๆ - <?php echo $t21_other; ?></td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>จำนวน <?php echo str_replace('.00','',number_format($t21_money_9,2)) ?> ดอกเบี้ยร้อยละ <?php echo $t21_interest_9; ?> ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน <?php if ($t21_pay_9 != ""){echo str_replace('.00','',number_format($t21_pay_9,2)); } else { echo "-";}?> บาท ยอดคงเหลือ <?php echo str_replace('.00','',number_format($t21_balance_9,2)) ?> บาท</td>
            </tr>
<?php } ?>
          </table>
<?
	} else if($question_debt_a==2){ 
		echo "หนี้นอกระบบ คุณเป็นหนี้นอกระบบใครบ้าง ระบุชื่อ - สกุลด้วย";
?>
<table width="809" border="0" cellspacing="2" cellpadding="2"  class="td_answer personal_tb">
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                <td >ชื่อ-สกุล <?php echo $tName18_2_1; ?></td>
                <td width="104" >จำนวนเงิน</td>
                <td width="114"><?php echo $tMoney18_2_1; ?> บาท</td>
                <td width="104">ดอกเบี้ยร้อยละ</td>
                <td width="264"><?php echo $tInterest18_2_1; ?> ต่อวัน/เดือน/ปี </td>
              </tr>
              <tr>
                <td width="191" >&nbsp;</td>
                <td >ส่งมาแล้วเป็นเงิน </td>
                <td ><?php echo $tPay18_2_1; ?> บาท</td>
                <td >ยอดคงเหลือ</td>
                <td ><?php echo $tBalance18_2_1; ?> บาท</td>
              </tr>
              <tr>
                <td >ชื่อ-สกุล <?php echo $tName18_2_2; ?></td>
                <td >จำนวนเงิน</td>
                <td ><?php echo $tMoney18_2_2; ?> บาท</td>
                <td >ดอกเบี้ยร้อยละ</td>
                <td ><?php echo $tInterest18_2_2; ?> ต่อวัน/เดือน/ปี </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td >ส่งมาแล้วเป็นเงิน</td>
                <td ><?php echo $tPay18_2_2; ?> บาท</td>
                <td >ยอดคงเหลือ</td>
                <td ><?php echo $tBalance18_2_2; ?> บาท</td>
              </tr>
              <tr>
                <td >ชื่อ-สกุล <?php echo $tName18_2_3; ?></td>
                <td>จำนวนเงิน</td>
                <td ><?php echo $tMoney18_2_3; ?> บาท</td>
                <td>ดอกเบี้ยร้อยละ</td>
                <td ><?php echo $tInterest18_2_3; ?> ต่อวัน/เดือน/ปี </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td>ส่งมาแล้วเป็นเงิน</td>
                <td ><?php echo $tPay18_2_3; ?> บาท</td>
                <td>ยอดคงเหลือ</td>
                <td ><?php echo $tBalance18_2_3; ?> บาท</td>
              </tr>
              <tr>
                <td >ชื่อ-สกุล <?php echo $tName18_2_4; ?></td>
                <td>จำนวนเงิน</td>
                <td ><?php echo $tMoney18_2_4; ?> บาท</td>
                <td>ดอกเบี้ยร้อยละ</td>
                <td ><?php echo $tInterest18_2_4; ?> ต่อวัน/เดือน/ปี </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td>ส่งมาแล้วเป็นเงิน</td>
                <td ><?php echo $tPay18_2_4; ?> บาท</td>
                <td>ยอดคงเหลือ</td>
                <td ><?php echo $tBalance18_2_4; ?> บาท</td>
              </tr>
              <tr>
                <td >ชื่อ-สกุล <?php echo $tName18_2_5; ?></td>
                <td>จำนวนเงิน</td>
                <td ><?php echo $tMoney18_2_5; ?> บาท</td>
                <td>ดอกเบี้ยร้อยละ</td>
                <td ><?php echo $tInterest18_2_5; ?> ต่อวัน/เดือน/ปี </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td>ส่งมาแล้วเป็นเงิน</td>
                <td ><?php echo $tPay18_2_5; ?> บาท</td>
                <td>ยอดคงเหลือ</td>
                <td ><?php echo $tBalance18_2_5; ?> บาท</td>
              </tr>
              <tr>
                <td >ชื่อ-สกุล <?php echo $tName18_2_6; ?></td>
                <td>จำนวนเงิน</td>
                <td ><?php echo $tMoney18_2_6; ?> บาท</td>
                <td>ดอกเบี้ยร้อยละ</td>
                <td ><?php echo $tInterest18_2_6; ?> ต่อวัน/เดือน/ปี </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td>ส่งมาแล้วเป็นเงิน</td>
                <td ><?php echo $tPay18_2_6; ?> บาท</td>
                <td>ยอดคงเหลือ</td>
                <td ><?php echo $tBalance18_2_6; ?> บาท</td>
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
<td><strong>จำนวนผู้อาศัย</strong></td>
</tr>
</table>

<table width="95%" border="1" cellpadding="1" cellspacing="0" bordercolor="#CCCCCC" class="personal_tb" style="border-collapse:collapse;">
          <thead>
            <tr>
              <th height="25"  bgcolor="#f2f2f2">ประเภท</th>
              <th width="20%"  bgcolor="#f2f2f2">ชาย</th>
              <th width="20%"  bgcolor="#f2f2f2">หญิง</th>
              <th width="20%"  bgcolor="#f2f2f2">รวม</th>
            </tr>
          </thead>
		  <? if ($tChildTotal > 0 ){?> 
          <tr>
            <td  height="25"  align="left">&nbsp;เด็ก (อายุ 0-18 ปี)</td>
            <td width="20%"  align="center"><?php if(!empty($tChildMale)){ echo $tChildMale; } else { echo '0';}?></td>
            <td width="20%"  align="center"><?php if(!empty($tChildFemale)){ echo $tChildFemale; } else { echo '0';}?></td>
            <td  width="20%" align="center"><?php if(!empty($tChildTotal)){ echo $tChildTotal; } else { echo '0';}?></td>
          </tr>
		  <? } ?>
		  <? if ($tTeensTotal > 0 ){?> 
          <tr>
            <td height="25"  align="left">&nbsp;เยาวชน (อายุ 19-25 ปี)</td>
            <td width="20%"  align="center"><?php if(!empty($tTeensMale)){ echo $tTeensMale; } else { echo '0';}?></td>
            <td width="20%"  align="center"><?php if(!empty($tTeensFemale)){ echo $tTeensFemale; } else { echo '0';}?></td>
            <td width="20%" align="center"><?php if(!empty($tTeensTotal)){ echo $tTeensTotal; } else { echo '0';}?></td>
          </tr>
		  <? } ?>
		  <? if ($tTotal > 0 ){?> 
          <tr>
            <td height="25"  align="left">&nbsp;ผู้อาศัยทั่วไป (อายุ 26-59 ปี)</td>
            <td width="20%"  align="center"><?php if(!empty($tMan)){ echo $tMan; } else { echo '0';}?></td>
            <td width="20%"  align="center"><?php if(!empty($tWoman)){ echo $tWoman; } else { echo '0';}?></td>
            <td width="20%" align="center"><?php if(!empty($tTotal)){ echo $tTotal; } else { echo '0';}?></td>
          </tr>
		  <? } ?>
		  <? if ($tElderTotal > 0 ){?> 
          <tr>
            <td  height="25"  align="left">&nbsp;ผู้สูงอายุ (อายุ 60 ปี)</td>
            <td width="20%"  align="center"><?php if(!empty($tElderMale)){ echo $tElderMale; } else { echo '0';}?></td>
            <td width="20%"  align="center"><?php if(!empty($tElderFemale)){ echo $tElderFemale; } else { echo '0';}?></td>
            <td width="20%" align="center"><?php if(!empty($tElderTotal)){ echo $tElderTotal; } else { echo '0';}?></td>
          </tr>
		  <? } ?>
		  <? if ($tDisabledTotal > 0 ){?>
          <tr>
            <td height="25"  align="left">&nbsp;คนพิการ</td>
            <td width="20%"  align="center"><?php if(!empty($tDisabledMale)){ echo $tDisabledMale; } else { echo '0';}?></td>
            <td width="20%"  align="center"><?php if(!empty($tDisabledFemale)){ echo $tDisabledFemale; } else { echo '0';}?></td>
            <td width="20%"  align="center"><?php if(!empty($tDisabledTotal)){ echo $tDisabledTotal; } else { echo '0';}?></td>
          </tr>
		  <? } ?>
          <tr>
            <td  height="25"  align="center">รวมทั้งสิ้น</td>
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
