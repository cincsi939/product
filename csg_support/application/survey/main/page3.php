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
        <td height="28" colspan="4" align="left" valign="top" bgcolor="#f2f2f2"><div class="infodata_font">�������ǹ������ѧ��</div></td>
      </tr>
     <tr>
        <td colspan="4" valign="top">
		
<table width="95%" border="0" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td colspan="2" align="left" valign="top" class="td_question">��ͺ������Ҫԡ㹤�ͺ����˹��͡�ҡ��ҹ : </td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer"><?php	
			if($r24_1==1){
				echo "�ըӹǹ $t24_1Num ��";
				if($c24_YearOld_1==1){echo '<br>���ص�ӡ��� 10 ��';}
				if($c24_YearOld_1==2){echo '<br>��� 10-15 ��';}
				if($c24_YearOld_1==3){echo '<br>���� 16 �բ���';}
			} else if($r24_1==2){
				echo "�����";
			}  else {
				echo "-";
			}
			
			
			?></td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top"  class="td_question" > ����٧��·������� 60 �բ��� 㹤�ͺ�������Ѻ����������ҡ��Ҫԡ㹤�ͺ���������ͧ�Ѩ��� 4 ��д�ҹ�Ե� : </td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer"><?
			
			 if($r24_2==1){		 
			 	echo "�ըӹǹ�� $t24_2Num ��"; 
			} else if($r24_2==2){
				echo "�����";
			}  else {
				echo "-";
			}
			 
			?></td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top"  class="td_question" > ��Ҫԡ㹤�ͺ�������ѡɳС�û�ԺѵԵ�͡ѹ</td>
            </tr>
          <tr>
            <td width="3%" align="left" valign="top"  class="td_question" >&nbsp; </td>
            <td width="97%" align="left" valign="top"  class="td_question" > 1.	�Ѻ��͡ѹ���������</td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_answer" >&nbsp; </td>
            <td align="left" valign="top"  class="td_answer" ><?php
			if($r24_3_1==1){
			echo '��';
			} else if($r24_3_1==2){
			echo "�����";
			if ($t24_3_1Cause != ""){ echo " ���ͧ�ҡ ".$t24_3_1Cause;}
			}  else {
			echo "-";
			}
			
			
			?></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_question" >&nbsp; </td>
            <td align="left" valign="top"  class="td_question" > 2. �ٴ��»�֡������͡ѹ</td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_answer" >&nbsp; </td>
            <td align="left" valign="top"  class="td_answer" ><?php
			if($r24_3_2==1){
				echo '��';
			} else if($r24_3_2==2){
				echo "�����";
				if ($t24_3_2Cause != ""){ echo " ���ͧ�ҡ ".$t24_3_2Cause;}
			} else {
				echo "-";
			}
			
			
			?></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_question" >&nbsp; </td>
            <td align="left" valign="top"  class="td_question" > 3. �Ѻ�ѧ�����Դ�������˵ؼŢͧ��Ҫԡ㹤�ͺ����</td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_answer" >&nbsp; </td>
            <td align="left" valign="top"  class="td_answer" ><?php
			if($r24_3_3==1){
				echo '��';
			} else if($r24_3_3==2){
				echo "�����";
				if ($t24_3_3Cause != ""){ echo " ���ͧ�ҡ ".$t24_3_3Cause;}
			} else {
				echo "-";
			}
			
			
			?></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_question" >&nbsp; </td>
            <td align="left" valign="top"  class="td_question" > 4. ��Ҫԡ㹤�ͺ�����ա�÷ӡԨ���������ѹ �� �ҹ����� ��١����� �͹��ú�ҹ</td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_answer" >&nbsp; </td>
            <td align="left" valign="top"  class="td_answer" ><?php
			if($r24_3_4==1){
				echo '��';
			} else if($r24_3_4==2){
				echo "�����";
				if ($t24_3_4Cause != ""){ echo " ���ͧ�ҡ ".$t24_3_4Cause;}
			} else {
				echo "-";
			}
			
			
			?></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="top"  class="td_question" > ��䢻ѭ��੾��˹�Ңͧ��ͺ���������ѹ</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer">
<?
 if($r24_4==1){  echo "�����������ѭ��";} else 
 if($r24_4==2){  echo "������ѭ�Һҧ����";} else 
 if($r24_4==3){  echo "������ѭ�ҷء����";} else {
 echo " - ";
 }
?>
			
			</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top"  class="td_question" > �ա�á�ͻѭ�Ҥ�����ʹ��͹������ͺ����</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer">

<?
if($r24_5==1){
	echo '�¡�ͻѭ��';
		 if($value['v362']==1){
		 echo "���������ҷ��ӹǹ ".$value['v365']."����";
		 } else if($value['v363']==1){
		 echo "�Դ���ʾ�Դ��ӹǹ ".$value['v366']."����";
		 } else if($value['v364']==1){
		 echo "�վĵԡ�������§�ҧ�Ƞ�ӹǹ ".$value['v367']."����";
		 }
} else if($r24_5==2){
echo '����¡�ͻѭ��';
} else {
echo "-";
}
?>
			
			</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top"  class="td_question" > �����Сѹ�֧��鹷غ�� ��������ҧ���/�Ե� ���;ٴ����Һ���</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer">
<?
if($r24_6==1){echo '�繻�Ш�';} else
if($r24_6==2){echo '�����';} else
{
echo '-';
}
?>
			</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top"  class="td_question" > ��Ҫԡ㹤�ͺ���� ��������Ԩ�����ҧ�ѧ����Чҹ���ླշ���Ӥѭ</td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="top" class="td_answer">
			
<?php
 if($r24_7==1){
 	echo '����ǹ����';
	if($r24_7_detail==1){echo '���¡��� 5 ����/��';} else 
	if($r24_7_detail==2){echo '���¡��� 5-10 ����/��';} else 
	if($r24_7_detail==3){echo '�ҡ���� 10 ����/��';}

 } else  if($r24_7==1){
 	echo '�����';
    if ( $r24_7_detail_2 != "" ){echo "���ͧ�ҡ ".$r24_7_detail_2;}
} else {
	echo "-";
}
  ?>

			</td>
            </tr>
          <tr>
            <td colspan="2" align="left" valign="top"  class="td_question" > ��ͺ���� ���Ѻ��ê�������ͨҡ˹��§ҹ�ͧ�Ѱ �����ͧ���仹��</td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_question" >&nbsp; </td>
            <td align="left" valign="top"  class="td_question" > 1.	������纻��� ��Ҫԡ㹤�ͺ���������ԡ�èҡ�ç��Һ����������آ�Ҿ�Ӻ������ç��Һ�� �������</td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_answer" >&nbsp; </td>
            <td align="left" valign="top"  class="td_answer" ><?php 
			
			if($r24_8_1==1){
				echo '����';
			} else 	if($r24_8_1==2){		
				echo '�������';
				if ( $r24_8_1d != "" ){echo " �к����˵� ".$r24_8_1d;}
			} else {
				echo "-";
			}	
			 ?></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_question" >&nbsp; </td>
            <td align="left" valign="top"  class="td_question" > 2.	��Ҫԡ㹤�ͺ���Ǥ�㴤�˹�������Ѻ��ԡ�ê��������㹡�û�Сͺ�Ҫվ �������</td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="td_answer" >&nbsp; </td>
            <td align="left" valign="top"  class="td_answer" ><?php 
			
			if($r24_8_2==1){
				echo '��';
				if ( $r24_8_2d != "" ){echo " �к� ".$r24_8_2d;}
			} else 	if($r24_8_2==2){		
				echo '�����';
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
