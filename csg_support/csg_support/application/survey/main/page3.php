<?
$con = new Cfunction();
/*$sql = 'SELECT question_24_1,question_24_1_detail,question_24_2,question_24_2_detail,question_24_4,question_24_5,question_24_5_detail,';
$sql .= 'question_24_3_1,question_24_3_1d,question_24_3_2,question_24_3_2d,question_24_3_3,question_24_3_3d,question_24_3_4,';
$sql .= 'question_24_6,question_24_7,question_24_7_detail,question_24_8_1,question_24_8_1d,question_24_8_2,question_24_8_2d';
$sql .= ' FROM question_detail_1';
$sql .= ' WHERE question_id='.$row['question_id'];*/
$sql = "select siteid,form_id,number_action,pin,child_userid,vid,yy,mm,value,reportdate from eq_var_data where siteid=1 AND form_id=3 AND pin='".$xml->Position1->NodeData7."'";
$con->connectDB();
$results = $con->select($sql);
foreach($results as $row){
	$value['v'.$row['vid']] = $row['value'];	
}

$r24_1 = $value['v343'];
//$question_24_1_detail = $value['v348'];
//$r24_1_detail = explode(',',$question_24_1_detail);

$t24_1Num = $value['v348'];
$c24_YearOld_1 = $value['v345'];
$c24_YearOld_2 = $value['v346'];
$c24_YearOld_3 = $value['v347'];

$r24_2 = $value['v350'];
$t24_2Num = $value['v351'];

$r24_3_1 = $value['v352'];
$r24_3_2 = $value['v354'];
$r24_3_3 = $value['v356'];
$r24_3_4= $value['v358'];
$t24_3_1Cause = $value['v353'];
$t24_3_2Cause = $value['v355'];
$t24_3_3Cause = $value['v357'];

$r24_4 = $value['v360'];
$r24_5 = $value['v361'];
//$r24_5_detail = $value['question_24_5_detail'];
//$r24_5_detail = explode(',',$r24_5_detail);


$r24_6 = $value['v368'];
$r24_7 = $value['v369'];
$r24_7_detail = $value['v370'];
if($r24_7==2)
{
	$r24_7_detail_2 = $value['v371'];
}
else
{
	$r24_7_detail_2 = '';
}

$r24_8_1 = $value['v372'];
$r24_8_1d = $value['v373'];
$r24_8_2 = $value['v374'];
$r24_8_2d = $value['v405'];
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" height="67" style="background-image:url('images/bg_tab.png');">
  <tbody><tr>
    <td width="50" align="left">
    <br>
    &nbsp;
<a href="?id=<? echo $_GET['id'];?>&frame=form2<? if (!empty($_GET['report_type'])){ echo "&report_type=".$_GET['report_type']; }?>"><img src="images/arrow_left.png" align="absmiddle" border="0"></a>
        </td>
    <td width="25%" align="left">
    <br>
    <span class="infomenu_next"><a href="?id=<? echo $_GET['id'];?>&frame=form2<? if (!empty($_GET['report_type'])){ echo "&report_type=".$_GET['report_type']; }?>" class="infomenu_next"><? echo $menu2;?></a></span>
    </td>
    <td style="background-image:url('images/background_tab.png'); background-position:center; background-repeat:no-repeat;" width="448" align="center">
    <br>
   <span class="infomenu"><? echo $menu3;?></span>
    </td>
    <td width="25%" align="right">
    <br>
    <span class="infomenu_next"><a href="?id=<? echo $_GET['id'];?>&frame=form4<? if (!empty($_GET['report_type'])){ echo "&report_type=".$_GET['report_type']; }?>" class="infomenu_next"><? echo $menu4;?></a></span>
    </td>
    <td width="50" align="right">
    <br>
<a href="?id=<? echo $_GET['id'];?>&frame=form4<? if (!empty($_GET['report_type'])){ echo "&report_type=".$_GET['report_type']; }?>"><img src="images/arrow_right.png" align="absmiddle" border="0"></a>
        &nbsp;
    </td>
  </tr>
</tbody></table>



<div class="container">
	<div class="infodata" >
<table width="100%"  height="296" border="0" cellpadding="3" cellspacing="0" class="personal_tb">
      <tr>
        <td height="28" colspan="4" align="left" valign="top" bgcolor="#f2f2f2"><div class="infodata_font">การมีส่วนร่วมในสังคม</div></td>
      </tr>
     <tr>
        <td colspan="4" valign="top">
		
<table width="95%" border="0" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td colspan="2" align="left" valign="top" class="td_question">ในรอบปีมีสมาชิกในครอบครัวหนีออกจากบ้าน : </td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer"><?php	
			if($r24_1==1){
				echo "มีจำนวน $t24_1Num คน";
				if($c24_YearOld_1==1){echo '<br>อายุต่ำกว่า 10 ปี';}
				if($c24_YearOld_1==2){echo '<br>อาย 10-15 ปี';}
				if($c24_YearOld_1==3){echo '<br>อายุ 16 ปีขึ้นไป';}
			} else if($r24_1==2){
				echo "ไม่มี";
			}  else {
				echo "-";
			}
			
			
			?></td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top"  class="td_question" > ผู้สูงอายที่อายุุ 60 ปีขึ้นไป ในครอบครัวได้รับการเอาใจใส่จากสมาชิกในครอบครัวในเรื่องปัจจัย 4 และด้านจิตใจ : </td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer"><?
			
			 if($r24_2==1){		 
			 	echo "มีจำนวนคน $t24_2Num คน"; 
			} else if($r24_2==2){
				echo "ไม่มี";
			}  else {
				echo "-";
			}
			 
			?></td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top"  class="td_question" > สมาชิกในครอบครัวมีลักษณะการปฏิบัติต่อกัน</td>
            </tr>
          <tr>
            <td width="3%" align="left" valign="top"  class="td_question" >&nbsp; </td>
            <td width="97%" align="left" valign="top"  class="td_question" > 1.	นับถือกันตามอาวุโส</td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_answer" >&nbsp; </td>
            <td align="left" valign="top"  class="td_answer" ><?php
			if($r24_3_1==1){
			echo 'ใช่';
			} else if($r24_3_1==2){
			echo "ไม่ใช่";
			if ($t24_3_1Cause != ""){ echo " เนื่องจาก ".$t24_3_1Cause;}
			}  else {
			echo "-";
			}
			
			
			?></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_question" >&nbsp; </td>
            <td align="left" valign="top"  class="td_question" > 2. พูดคุยปรึกษาหารือกัน</td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_answer" >&nbsp; </td>
            <td align="left" valign="top"  class="td_answer" ><?php
			if($r24_3_2==1){
				echo 'ใช่';
			} else if($r24_3_2==2){
				echo "ไม่ใช่";
				if ($t24_3_2Cause != ""){ echo " เนื่องจาก ".$t24_3_2Cause;}
			} else {
				echo "-";
			}
			
			
			?></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_question" >&nbsp; </td>
            <td align="left" valign="top"  class="td_question" > 3. รับฟังความคิดเห็นและเหตุผลของสมาชิกในครอบครัว</td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_answer" >&nbsp; </td>
            <td align="left" valign="top"  class="td_answer" ><?php
			if($r24_3_3==1){
				echo 'ใช่';
			} else if($r24_3_3==2){
				echo "ไม่ใช่";
				if ($t24_3_3Cause != ""){ echo " เนื่องจาก ".$t24_3_3Cause;}
			} else {
				echo "-";
			}
			
			
			?></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_question" >&nbsp; </td>
            <td align="left" valign="top"  class="td_question" > 4. สมาชิกในครอบครัวมีการทำกิจกรรมร่วมกัน เช่น ทานอาหาร ปลูกต้นไม้ สอนการบ้าน</td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_answer" >&nbsp; </td>
            <td align="left" valign="top"  class="td_answer" ><?php
			if($r24_3_4==1){
				echo 'ใช่';
			} else if($r24_3_4==2){
				echo "ไม่ใช่";
				if ($t24_3_4Cause != ""){ echo " เนื่องจาก ".$t24_3_4Cause;}
			} else {
				echo "-";
			}
			
			
			?></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="top"  class="td_question" > แก้ไขปัญหาเฉพาะหน้าของครอบครัวร่วมกัน</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer">
<?
 if($r24_4==1){  echo "ไม่ได้ร่วมแก้ปัญหา";} else 
 if($r24_4==2){  echo "ร่วมแก้ปัญหาบางครั้ง";} else 
 if($r24_4==3){  echo "ร่วมแก้ปัญหาทุกครั้ง";} else {
 echo " - ";
 }
?>
			
			</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top"  class="td_question" > มีการก่อปัญหาความเดือดร้อนมาสู่ครอบครัว</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer">

<?
if($r24_5==1){
	echo 'เคยก่อปัญหา';
		 if($value['v362']==1){
		 echo "ทะเลาะวิวาท จำนวน ".$value['v365']."ครั้ง";
		 } else if($value['v363']==1){
		 echo "ติดยาเสพติด จำนวน ".$value['v366']."ครั้ง";
		 } else if($value['v364']==1){
		 echo "มีพฤติกรรมเสี่ยงทางเพศ จำนวน ".$value['v367']."ครั้ง";
		 }
} else if($r24_5==2){
echo 'ไม่เคยก่อปัญหา';
} else {
echo "-";
}
?>
			
			</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top"  class="td_question" > ทะเลาะกันถึงขั้นทุบตี ทำร้ายร่างกาย/จิตใจ หรือพูดจาหยาบคาย</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer">
<?
if($r24_6==1){echo 'เป็นประจำ';} else
if($r24_6==2){echo 'ไม่เคย';} else
{
echo '-';
}
?>
			</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top"  class="td_question" > สมาชิกในครอบครัว เข้าร่วมกิจกรรมทางสังคมและงานประเพณีที่สำคัญ</td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer">
			
<?php
 if($r24_7==1){
 	echo 'มีส่วนร่วม';
	if($r24_7_detail==1){echo 'น้อยกว่า 5 ครั้ง/ปี';} else 
	if($r24_7_detail==2){echo 'น้อยกว่า 5-10 ครั้ง/ปี';} else 
	if($r24_7_detail==3){echo 'มากกว่า 10 ครั้ง/ปี';}

 } else  if($r24_7==1){
 	echo 'ไม่มี';
    if ( $r24_7_detail_2 != "" ){echo "เนื่องจาก ".$r24_7_detail_2;}
} else {
	echo "-";
}
  ?>

			</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top"  class="td_question" > ครอบครัว ได้รับการช่วยเหลือจากหน่วยงานของรัฐ ในเรื่องต่อไปนี้</td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_question" >&nbsp; </td>
            <td align="left" valign="top"  class="td_question" > 1.	เมื่อเจ็บป่วย สมาชิกในครอบครัวได้ใช้บริการจากโรงพยาบาลส่งเสริมสุขภาพตำบลหรือโรงพยาบาล หรือไม่</td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_answer" >&nbsp; </td>
            <td align="left" valign="top"  class="td_answer" ><?php 
			
			if($r24_8_1==1){
				echo 'ได้ใช้';
			} else 	if($r24_8_1==2){		
				echo 'ไม่ได้ใช้';
				if ( $r24_8_1d != "" ){echo " ระบุสาเหตุ ".$r24_8_1d;}
			} else {
				echo "-";
			}	
			 ?></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_question" >&nbsp; </td>
            <td align="left" valign="top"  class="td_question" > 2.	สมาชิกในครอบครัวคนใดคนหนึ่งเคยได้รับบริการช่วยเหลือในการประกอบอาชีพ หรือไม่</td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_answer" >&nbsp; </td>
            <td align="left" valign="top"  class="td_answer" ><?php 
			
			if($r24_8_2==1){
				echo 'เคย';
				if ( $r24_8_2d != "" ){echo " ระบุ ".$r24_8_2d;}
			} else 	if($r24_8_2==2){		
				echo 'ไม่เคย';
			} else {
				echo "-";
			}	
			 ?></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="top" >&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table>

	</div>

</div>
<!-- End .container  -->
