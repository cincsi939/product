<link rel="stylesheet" href="../css/style.css">
<script type="text/javascript" src="../js/jquery-1.8.2.js"></script>
<script language="JavaScript">
	function showimagepreview(input) {
	if (input.files && input.files[0]) {
	var filerdr = new FileReader();
	filerdr.onload = function(e) {
	$('#imgprvw').attr('src', e.target.result);
	}
	filerdr.readAsDataURL(input.files[0]);
	}
}
</script>

<script src="../js/jquery-1.10.1.min.js"></script>
<script src="../js/AgeCalculate.min.js"></script>

<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('lib/nusoap.php'); 
	require_once("lib/class.function.php");
	$con = new Cfunction();
	$sql = 'SELECT question_id,question_date,question_firstname,question_lastname,question_idcard,question_idcard_detail,question_address,question_village,';
	$sql .= 'question_street,question_parish,question_district,question_province,question_phone,question_sex,question_sex_detail,question_birthday,question_age,';
	$sql .= 'question_typehome,question_typehome_detail,question_stypehome_1,question_stypehome_2,question_stypehome_3,question_environment,question_education,';
	$sql .= 'question_career,question_career_detail,question_land,question_land_detail,question_Income,question_religion,question_religion_detail,question_status,question_status_detail,';
	$sql .= 'question_structure,question_structure_detail,question_defective,question_defective_detail,question_residents,question_debt,question_debt_sub,question_debt_detail,question_img';
	$sql .= ' FROM question_detail_1';
	$sql .= ' WHERE question_id='.$_GET['id'];
	
	$con->connectDB();
	$results = $con->select($sql);
	foreach($results as $row){}
	
	/*--------------------------------------------------------------------------------------- set Database*/
	$tFirstname = $row['question_firstname'];
	$tLastname = $row['question_lastname'];
	$question_idcard = $row['question_idcard'];
	$question_idcard_detail = $row['question_idcard_detail'];
	
	$question_address = $row['question_address'];
	$question_village = $row['question_village'];
	$question_street = $row['question_street'];
	$question_parish = $row['question_parish'];
	$question_district = $row['question_district'];
	$question_province = $row['question_province'];
	$question_phone = $row['question_phone'];
	
	$question_sex = $row['question_sex'];
	$question_sex_detail = $row['question_sex_detail'];
	
	$question_birthday = $row['question_birthday'];
	$question_age = $row['question_age'];
	
	$question_typehome = $row['question_typehome'];
	$question_typehome_detail = $row['question_typehome_detail'];
	if($question_typehome==2)
	{
		$detail_2 = $question_typehome_detail;
		$detail_4 = '';
	}
		else
	{
		$detail_2 = '';
		$detail_4 = $question_typehome_detail;
	}
	
	$question_stypehome_1 = $row['question_stypehome_1'];
	$question_stypehome_2 = $row['question_stypehome_2'];
	$question_stypehome_3 = $row['question_stypehome_3'];
	$question_environment = $row['question_environment'];
	$question_education = $row['question_education'];
	
	/*--------------------------------------------------------------------------------------- อาชีพหลัก*/
	$question_career = $row['question_career'];
	$question_career_detail = $row['question_career_detail'];
	$question_career = json_decode($question_career);
	if(count($question_career)==0)
	{
		$question_career[] = 0;
	}
	
	$question_land = $row['question_land'];
	$question_land_detail = $row['question_land_detail'];
	
	$question_Income = $row['question_Income'];
	$question_religion = $row['question_religion'];
	$question_religion_detail = $row['question_religion_detail'];
	
	$question_status = $row['question_status'];
	$question_status_detail = $row['question_status_detail'];
	
	/*--------------------------------------------------------------------------------------- ลักษณะโครงสร้าง*/
	$question_structure = $row['question_structure'];
	$question_structure_detail = $row['question_structure_detail'];
	if($question_structure==1)
	{
		//$data = json_decode($question_structure_detail);
		$data = explode(',',$question_structure_detail);
		$tMemberFamily_1 = $data[0];
		$tMemberMale_1 = $data[1];
		$tMemberFemale_1 = $data[2];
		
		$rLargeFamily = '';
		$tMemberFamily_2_1 = '';
		$tMemberMale_2_1 = '';
		$tMemberFemale_2_1 = '';
		
		$tMemberFamily_2_2 = '';
		$tMemberMale_2_2 = '';
		$tMemberFemale_2_2 = '';
		
		$tSpecialFamily_3 = '';
		$rSpecialFamily = '';
	}
	elseif($question_structure==2)
	{
		//$data = json_decode($question_structure_detail);
		$data = explode(',',$question_structure_detail);
		$tMemberFamily_1 = '';
		$tMemberMale_1 = '';
		$tMemberFemale_1 = '';
		
		$tSpecialFamily_3 = '';
		$rSpecialFamily = '';
		$rLargeFamily = $data[0];
		if($rLargeFamily==1)
		{
			$tMemberFamily_2_1 = $data[1];
			$tMemberMale_2_1 = $data[2];
			$tMemberFemale_2_1 = $data[3];
			$tMemberFamily_2_2 = '';
			$tMemberMale_2_2 = '';
			$tMemberFemale_2_2 = '';
		}
		else
		{
			$tMemberFamily_2_1 = '';
			$tMemberMale_2_1 = '';
			$tMemberFemale_2_1 = '';
			
			$tMemberFamily_2_2 = $data[1];
			$tMemberMale_2_2 = $data[2];
			$tMemberFemale_2_2 = $data[3];
		}
	}
	else
	{
		$tMemberFamily_1 = '';
		$tMemberMale_1 = '';
		$tMemberFemale_1 = '';
		
		$rLargeFamily = '';
		
		$tMemberFamily_2_1 = '';
		$tMemberMale_2_1 = '';
		$tMemberFemale_2_1 = '';
		
		$tMemberFamily_2_2 = '';
		$tMemberMale_2_2 = '';
		$tMemberFemale_2_2 = '';
		
		//$data = json_decode($question_structure_detail);
		$data = explode(',',$question_structure_detail);
		if($data[0]==6)
		{
			$tSpecialFamily_3 = $data[1];
			$rSpecialFamily = $data[0];
		}
		else
		{
			$tSpecialFamily_3 = '';
			$rSpecialFamily = $data[0];
		}
	}
	
	/*--------------------------------------------------------------------------------------- จำนวนสมาชิก*/
	$question_defective = $row['question_defective'];
	$question_defective_detail = $row['question_defective_detail'];
	if($question_defective==2)
	{
		//$data = json_decode($question_defective_detail);
		$data = explode(',',$question_defective_detail);
		$tDefective = $data[0];
		$tChild = $data[1];
		$tDisabled = $data[2];
		$tMindSick = $data[3];
		$tSick = $data[4];
		$tElderly = $data[5];
	}
	else
	{
		$tDefective = '';
		$tChild = '';
		$tDisabled = '';
		$tMindSick = '';
		$tSick = '';
		$tElderly = '';
	}
	
	/*--------------------------------------------------------------------------------------- จำนวนผู้อาศัยแยกตามกลุ่ม*/
	$question_residents = $row['question_residents'];
	//$data = json_decode($question_residents);
	$data = explode(',',$question_residents);
	$tChildMale = $data[0];
	$tChildFemale = $data[1];
	$tChildTotal = $data[2];
	
	$tTeensMale = $data[3];
	$tTeensFemale = $data[4];
	$tTeensTotal = $data[5];
	
	$tMan = $data[6];
	$tWoman = $data[7];
	$tTotal = $data[8];
	
	$tElderMale = $data[9];
	$tElderFemale = $data[10];
	$tElderTotal = $data[11];
	
	$tDisabledMale = $data[12];
	$tDisabledFemale = $data[13];
	$tDisabledTotal = $data[14];
	
	$tMaleTotal = $tChildMale+$tTeensMale+$tMan+$tElderMale+$tDisabledMale; 
	$tFemaleTotal = $tChildFemale+$tTeensFemale+$tWoman+$tElderFemale+$tDisabledFemale; 
	$tSumTotal = $tMaleTotal+$tFemaleTotal ;
	
	/*--------------------------------------------------------------------------------------- ครอบครัวมีหนี้สิน*/
	$question_debt = $row['question_debt'];
	$question_debt_a = '';
	$question_debt_detail = '';
	$chk = array();
	
	$t21_money_1 = '';
	$t21_interest_1 = '';
	$t21_pay_1 = '';
	$t21_balance_1 = '';
	
	$t21_money_2 = '';
	$t21_interest_2 = '';
	$t21_pay_2 = '';
	$t21_balance_2 = '';
	
	$t21_money_3 = '';
	$t21_interest_3 = '';
	$t21_pay_3 = '';
	$t21_balance_3 = '';
	
	$t21_money_4 = '';
	$t21_interest_4 = '';
	$t21_pay_4 = '';
	$t21_balance_4 = '';
	
	$t21_money_5 = '';
	$t21_interest_5 = '';
	$t21_pay_5 = '';
	$t21_balance_5 = '';
	
	$t21_money_6 = '';
	$t21_interest_6 = '';
	$t21_pay_6 = '';
	$t21_balance_6 = '';
	
	$t21_money_7 = '';
	$t21_interest_7 = '';
	$t21_pay_7 = '';
	$t21_balance_7 = '';
	
	$t21_money_8 = '';
	$t21_interest_8 = '';
	$t21_pay_8 = '';
	$t21_balance_8 = '';
	
	$t21_other = '';
	$t21_money_9 = '';
	$t21_interest_9 = '';
	$t21_pay_9 = '';
	$t21_balance_9 = '';
	
	$tName18_2_1 = '';
    $tMoney18_2_1 = '';
    $tInterest18_2_1 ='' ;
    $tPay18_2_1 ='';
    $tBalance18_2_1 = '';
	
	$tName18_2_2 = '';
    $tMoney18_2_2 = '';
    $tInterest18_2_2 ='' ;
    $tPay18_2_2 ='';
    $tBalance18_2_2 = '';
	
	$tName18_2_3 = '';
    $tMoney18_2_3 = '';
    $tInterest18_2_3 ='' ;
    $tPay18_2_3 ='';
    $tBalance18_2_3 = '';
	
	$tName18_2_4 = '';
    $tMoney18_2_4 = '';
    $tInterest18_2_4 ='' ;
    $tPay18_2_4 ='';
    $tBalance18_2_4 = '';
	
	$tName18_2_5 = '';
    $tMoney18_2_5 = '';
    $tInterest18_2_5 ='' ;
    $tPay18_2_5 ='';
    $tBalance18_2_5 = '';
	
	$tName18_2_6 = '';
    $tMoney18_2_6 = '';
    $tInterest18_2_6 ='' ;
    $tPay18_2_6 ='';
    $tBalance18_2_6 = '';
	
	if($question_debt==2)
	{
		$question_debt_a = $row['question_debt_sub'];
		$question_debt_detail = $row['question_debt_detail'];
		if($question_debt_a==1)
		{
			$data = explode(',',$question_debt_detail);
			for($i=0;$i<(count($data));$i++)
			{
				$txt = explode(':',$data[$i]);
				$chk[$i] = $txt[0];
				$arraytext[$i] = $txt[1];
				$text = explode('|',$arraytext[$i]);
				
				switch ($chk[$i]) {
				case 1:
							$t21_money_1 = $text[0];
							$t21_interest_1 = $text[1];
							$t21_pay_1 = $text[2];
							$t21_balance_1 = $text[3];
				break;
				
				case 2:
							$t21_money_2 = $text[0];
							$t21_interest_2 = $text[1];
							$t21_pay_2 = $text[2];
							$t21_balance_2 = $text[3];
				break;
				
				case 3:
							$t21_money_3 = $text[0];
							$t21_interest_3 = $text[1];
							$t21_pay_3 = $text[2];
							$t21_balance_3 = $text[3];
				break;
				
				case 4:
							$t21_money_4 = $text[0];
							$t21_interest_4 = $text[1];
							$t21_pay_4 = $text[2];
							$t21_balance_4 = $text[3];
				break;
				
				case 5:
							$t21_money_5 = $text[0];
							$t21_interest_5 = $text[1];
							$t21_pay_5 = $text[2];
							$t21_balance_5 = $text[3];
				break;
				
				case 6:
							$t21_money_6 = $text[0];
							$t21_interest_6 = $text[1];
							$t21_pay_6 = $text[2];
							$t21_balance_6 = $text[3];
				break;
				
				case 7:
							$t21_money_7 = $text[0];
							$t21_interest_7 = $text[1];
							$t21_pay_7 = $text[2];
							$t21_balance_7 = $text[3];
				break;
				
				case 8:
							$t21_money_8 = $text[0];
							$t21_interest_8 = $text[1];
							$t21_pay_8 = $text[2];
							$t21_balance_8 = $text[3];
				break;
				case 9:
							$t21_other = $text[0];
							$t21_money_9 = $text[1];
							$t21_interest_9 = $text[2];
							$t21_pay_9 = $text[3];
							$t21_balance_9 = $text[4];
				break;
			}
			}
		}
		else
		{
			$txt = explode(',',$question_debt_detail);
			$tName18_2_1 = $txt[0];
			$tMoney18_2_1 = $txt[1];
			$tInterest18_2_1 = $txt[2];
			$tPay18_2_1 = $txt[3];
			$tBalance18_2_1 = $txt[4];
			
			$tName18_2_2 = $txt[5];
			$tMoney18_2_2 = $txt[6];
			$tInterest18_2_2 = $txt[7];
			$tPay18_2_2 = $txt[8];
			$tBalance18_2_2 = $txt[9];
			
			$tName18_2_3 = $txt[10];
			$tMoney18_2_3 = $txt[11];
			$tInterest18_2_3 = $txt[12];
			$tPay18_2_3 = $txt[13];
			$tBalance18_2_3 = $txt[14];
			
			$tName18_2_4 = $txt[15];
			$tMoney18_2_4 = $txt[16];
			$tInterest18_2_4 = $txt[17];
			$tPay18_2_4 = $txt[18];
			$tBalance18_2_4 = $txt[19];
			
			$tName18_2_5 = $txt[20];
			$tMoney18_2_5 = $txt[21];
			$tInterest18_2_5 = $txt[22];
			$tPay18_2_5 = $txt[23];
			$tBalance18_2_5 = $txt[24];
			
			$tName18_2_6 = $txt[25];
			$tMoney18_2_6 = $txt[26];
			$tInterest18_2_6 = $txt[27];
			$tPay18_2_6 = $txt[28];
			$tBalance18_2_6 =  $txt[29];
		}
	}
	else
	{
		$question_debt_a = '';
		$question_debt_detail = '';
	}
	
	$question_img = $row['question_img'];
	$ws_client = new nusoap_client('http://soapservices.sapphire.co.th/index.php?wsdl',true); 
	$calendar = array('file' => 'calendar');
	echo $ws_client->call('includefile', $calendar);
	$para = array(
		'dateFormat' => 'dd/mm/yy',
		'inputname' => 'tbirthday',
		'showicon' => false,
		'showOtherMonths' => true,
		'showButton' => false,
		'showchangeMonth' => true,
		'numberOfMonths' => 1,
		'format' => 'utf-8',
		'value' => $question_birthday,
		'showWeek' => false);	
	 $result = $ws_client->call('calendar', $para);
?> 
<form action="main_exc/form1_edit_exc.php" method="post" enctype="multipart/form-data">
  <table width="850" border="0">
    <tbody>
      <tr>
        <td colspan="3" align="right">ข้อมูล ณ วันที่ <?php echo $con->_calendarTH('sDay','sMonth','sYear'); ?></td>
        <td width="246"><input type="hidden" name="question_id" value="<?php echo $row['question_id']; ?>"></td>
      </tr>
      <tr>
        <td colspan="3" align="left"><b><u>ส่วนที่ 1</u></b> <b>รายละเอียดข้อมูลของครัวเรือน</b></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="24" align="right">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td rowspan="8" align="center">
        
       <?php
	  	if(($question_img =='')or($question_img==NULL))
		{
			$valueImg = '<img src="../img/nopicture.gif" width="150" height="180" id="imgprvw" alt="uploaded image preview" name="pPicture">';
		}
		else
		{
			$valueImg = '<img src="../img/profile/'.$question_img.'" width="150" height="180" id="imgprvw" alt="uploaded image preview" name="pPicture">';
		}
	  ?>
      <?php echo $valueImg; ?>
          <input type="File" name="filUpload" id="filUpload" onChange="showimagepreview(this)" ></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">1.</td>
        <td height="25" colspan="2"><input type="hidden" name="cIDCard" value="1">
          เลขบัตรประจำตัวประชาชน
          <INPUT name="tIDCard" type="text" id="tIDCard" value="<?php echo $question_idcard_detail; ?>" size="30"  /></td>
      </tr>
      <tr>
        <td height="25" align="right">2.</td>
        <td height="25" colspan="2">ชื่อหัวหน้าครอบครัว&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="tFirstname" type="text" value="<?php echo $tFirstname; ?>" size="30"  />
          นามสกุล
        <input type="text" value="<?php echo $tLastname; ?>"  name="tLastname" size="30"/></td>
      </tr>
      <tr>
        <td height="25" align="right">3. </td>
        <td height="25" colspan="2">ที่อยู่อาศัย</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td height="25" colspan="2" valign="middle"><table width="546" border="0" cellpadding="1" cellspacing="1">
          <tr>
            <td width="65" align="right">บ้านเลขที่ :</td>
            <td width="144"><INPUT type="text" value="<?php echo $question_address; ?>" name="tAddress" /></td>
            <td width="50" align="right">หมู่ที่ :</td>
            <td width="245"><INPUT type="text" value="<?php echo $question_village; ?>"  name="tVillage" /></td>
          </tr>
          <tr>
            <td align="right">ถนน :</td>
            <td><input type="text" value="<?php echo $question_street; ?>" name="tStreet" /></td>
            <td align="right">ตำบล :</td>
            <td><input type="text" value="<?php echo $question_parish; ?>"  name="tParish"/></td>
          </tr>
          <tr>
            <td align="right">อำเภอ :</td>
            <td><INPUT type="text" value="<?php echo $question_district; ?>" name="tDistrict"/></td>
            <td align="right">จังหวัด :</td>
            <td><INPUT type="text" value="<?php echo $question_province; ?>" name="tProvince" /></td>
          </tr>
          <tr>
            <td align="right">โทรศัพท์ :</td>
            <td><input type="text" value="<?php echo $question_phone; ?>"  name="tPhone"/></td>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="25" align="right">4. </td>
        <td height="25" colspan="2">เพศ
          <input type="radio"  value="1"  class="rSex" name="rSex" <?php if($question_sex==1){echo 'checked';} ?>  />
          1. หญิง&nbsp;
          <input type="radio"  value="2" class="rSex" name="rSex"  <?php if($question_sex==2){echo 'checked';} ?>  />
          2. ชาย
          <input type="radio"  value="3" id="rSex_3" name="rSex" <?php if($question_sex==3){echo 'checked';} ?>  />
          3. อื่น ๆ ระบุ
          <INPUT name="tSex" type="text" id="tSex" value="" size="30" <?php echo $question_sex_detail; ?> /></td>
      </tr>
      <tr>
        <td height="25" align="right">5. </td>
        <td height="25" colspan="2">วันเกิด<?php echo $result; ?> อายุ
          <INPUT name="tAge" type="text" id="tAge" value="<?php echo $question_age; ?>" size="4" maxlength="4" />
          ปี</td>
      </tr>
      <tr>
        <td height="25" align="right">6. </td>
        <td height="25" colspan="2">ประเภทของที่อยู่อาศัยในปัจจุบัน
          
          &nbsp;</td>
        <td height="25">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td height="25"><input name="rTypeHome" class="rTypeHome" type="radio"  value="1"  id="m2" <?php if($question_typehome==1){echo 'checked';} ?> />
          1. บ้านตัวเอง</td>
        <td height="25" colspan="2"><input name="rTypeHome" type="radio"  value="2" id="rTypeHome_2" class="rTypeHome" <?php if($question_typehome==2){echo 'checked';} ?>/>
          2. บ้านเช่า จ่ายค่าเช่า
          <INPUT name="tTypeHome_2" type="text" id="tTypeHome_2" value="<?php echo $detail_2; ?>" size="10" />
          บาท/เดือน/ปี</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td height="25"><input name="rTypeHome" type="radio"  value="3" id="f3" class="rTypeHome" <?php if($question_typehome==3){echo 'checked';} ?> />
          3. บ้านญาติ </td>
        <td height="25" colspan="2"><input name="rTypeHome" type="radio"  value="4" id="rTypeHome_4"   class="rTypeHome" <?php if($question_typehome==4){echo 'checked';} ?>/>
          4. อื่น ๆ ระบุ
          <INPUT name="tTypeHome_4" type="text" id="tTypeHome_4" value="<?php echo $detail_4; ?>" style="width:80%" /></td>
      </tr>
      <tr>
        <td height="25" align="right">7.</td>
        <td height="25" colspan="2">ลักษณะที่อยู่</td>
        <td height="25">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td height="25" colspan="2">7.1 ลักษณะของบ้าน</td>
        <td height="25">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3" align="right"><textarea name="tstypehome_1" id="textarea" style="width:100%" rows="8"><?php echo $question_stypehome_1; ?></textarea></td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td colspan="2">7.2 สภาพบ้าน</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><textarea name="tstypehome_2" id="taHomeStyle" style="width:100%" rows="8"><?php echo $question_stypehome_2; ?></textarea></td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td colspan="2">7.3 ห้องสุขา</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><textarea name="tstypehome_3" id="taHomeStyle2" style="width:100%" rows="8"><?php echo $question_stypehome_3; ?></textarea></td>
      </tr>
      <tr>
        <td height="25" align="right">8.</td>
        <td  colspan="2">สภาพแวดล้อม</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><textarea name="tEnvironment" id="tEnvironment" style="width:100%" rows="8"><?php echo $question_environment; ?></textarea></td>
      </tr>
      <tr>
        <td height="25" align="right">9.</td>
        <td  colspan="2">การศึกษา</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="1"  id="rEducation"    name="rEducation" <?php if($question_education==1){echo 'checked';} ?>/>
          ไม่ได้ศึกษา</td>
        <td width="282" ><input type="radio"  value="2"  id="rEducation"    name="rEducation" <?php if($question_education==2){echo 'checked';} ?>/>
          ต่ำกว่าประถมศึกษา</td>
        <td ><input type="radio"  value="3"  id="rEducation"    name="rEducation" <?php if($question_education==3){echo 'checked';} ?>/>
          ประถมศึกษา</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="4"  id="rEducation"    name="rEducation" <?php if($question_education==4){echo 'checked';} ?>/>
          มัธยมศึกษาตอนต้น</td>
        <td ><input type="radio"  value="5"  id="rEducation"    name="rEducation" <?php if($question_education==5){echo 'checked';} ?>/>
          มัธยมศึกษาตอนปลาย</td>
        <td ><input type="radio"  value="6"  id="rEducation2"    name="rEducation" <?php if($question_education==6){echo 'checked';} ?>/>
          มัธยมศึกษาตอนปลาย/ปวช</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="7"  id="rEducation"    name="rEducation" <?php if($question_education==7){echo 'checked';} ?>/>
          อนุปริญญา/ปวส</td>
        <td ><input type="radio"  value="8"  id="rEducation"    name="rEducation" <?php if($question_education==8){echo 'checked';} ?>/>
          ปริญญาตรี</td>
        <td ><input type="radio"  value="9"  id="rEducation3"    name="rEducation" <?php if($question_education==9){echo 'checked';} ?>/>
          สูงกว่าปริญญาตรี</td>
      </tr>
      <tr>
        <td height="25" align="right">10. </td>
        <td  colspan="2">อาชีพหลักของหัวหน้าครอบครัว <strong>(ตอบได้มากว่า 1 ข้อ)</strong></td>
        <td >&nbsp;</td>
      </tr>
      <!--<div class="careertable">-->
      <tr class="careertable">
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="checkbox"  value="1"  id="cCareer1"    name="cCareer[]" <?php if(in_array(1,$question_career)){echo 'checked';} ?>/>
          1. รับจ้างทั่วไป</td>
        <td ><input type="checkbox"  value="2"  id="cCareer2"    name="cCareer[]" <?php if(in_array(2,$question_career)){echo 'checked';} ?>/>
          2. เกษตรกร </td>
        <td >&nbsp;</td>
      </tr>
      <tr class="careertable">
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="checkbox"  value="3"  id="cCareer3"    name="cCareer[]" <?php if(in_array(3,$question_career)){echo 'checked';} ?>/>
          3. ประมง</td>
        <td ><input type="checkbox"  value="4"  id="cCareer4"    name="cCareer[]" <?php if(in_array(4,$question_career)){echo 'checked';} ?>/>
          4. ข้าราชการ/ลูกจ้างหรือพนักงานของรัฐ</td>
        <td >&nbsp;</td>
      </tr>
      <tr class="careertable">
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="checkbox"  value="5"  id="cCareer5"    name="cCareer[]" <?php if(in_array(5,$question_career)){echo 'checked';} ?>/>
          5. พนักงานรัฐวิสาหกิจ</td>
        <td ><input type="checkbox"  value="6"  id="cCareer6"    name="cCareer[]" <?php if(in_array(6,$question_career)){echo 'checked';} ?>/>
          6. เจ้าหน้าที่องค์กรปกครองท้องถิ่น </td>
        <td >&nbsp;</td>
      </tr>
      <tr class="careertable">
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="checkbox"  value="7"  id="cCareer7"    name="cCareer[]" <?php if(in_array(7,$question_career)){echo 'checked';} ?>/>
          7. ค้าขาย/ธุรกิจส่วนตัว</td>
        <td ><input type="checkbox"  value="8"  id="cCareer8"    name="cCareer[]" <?php if(in_array(8,$question_career)){echo 'checked';} ?>/>
          8. พนักงาน/ลูกจ้างเอกชน</td>
        <td >&nbsp;</td>
      </tr>
      <tr class="careertable">
        <td height="25" align="right">&nbsp;</td>
        <td width="280" ><input type="checkbox"  value="9"  id="cCareer9"    name="cCareer[]" <?php if(in_array(9,$question_career)){echo 'checked';} ?>/>
          9. ว่างงาน/ไม่มีงานทำ</td>
        <td  colspan="2"><input type="checkbox"  value="10"  id="cCareer10"    name="cCareer[]" <?php if(in_array(10,$question_career)){echo 'checked';} ?>/>
          10. อื่น ๆ ระบุ
          <input  name="tCareer" type="text" value="<?php echo $question_career_detail; ?>" style="width:80%" id="tCareer"  /></td>
      </tr>
      <!--</div>-->
      <tr>
        <td height="25" align="right">11.</td>
        <td  colspan="2">ครอบครัวมีที่ดินทำกิน </td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="1"  id="rLand"    name="rLand" <?php if($question_land==1){echo 'checked';} ?>/>
          มี จำนวน
          <input name="tLand" type="text" id="tLand" size="10" value="<?php echo $question_land_detail; ?>" />
          ไร่</td>
        <td ><input type="radio"  value="2"  id="m34"    name="rLand" class="rLand_1" <?php if($question_land==2){echo 'checked';} ?>/>
          ไม่มี</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">12. </td>
        <td  colspan="3">รายได้เฉลี่ยของครอบครัว จำนวน
          <input name="tIncome" type="text" value="<?php echo $question_Income; ?>" size="10" id="tIncome" />
          บาท (ต่อปี)<strong> (รายได้คิดจากสมาชิกที่มีรายได้ร่วมกัน)</strong></td>
      </tr>
      <tr>
        <td height="25" align="right">13. </td>
        <td  colspan="2">ศาสนาหลักของครอบครัว</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><input type="radio"  value="1"  id="rEducation" name="rReligion" class="rReligion" <?php if($question_religion==1){echo 'checked';} ?>/>
          1. พุทธ
          &nbsp;
          <input type="radio"  value="2" id="rEducation" name="rReligion"  class="rReligion" <?php if($question_religion==2){echo 'checked';} ?>/>
          2. คริสต์
          <input type="radio"  value="3"  id="rEducation" name="rReligion"   class="rReligion" <?php if($question_religion==3){echo 'checked';} ?>/>
          3. อิสลาม
          &nbsp;
          <input type="radio"  value="4" id="rEducation" name="rReligion"  class="rReligion_1" <?php if($question_religion==4){echo 'checked';} ?>/>
          4. อื่น ๆ ระบุ
          <input name="tReligion" type="text" value="<?php echo $question_religion_detail; ?>" style="width:60%" id="tReligion_1" /></td>
      </tr>
      <tr>
        <td height="25" align="right">14.</td>
        <td  colspan="2">สภานภาพสมรสของท่านในปัจจุบันเป็นอย่างไร</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="1"  class="rStatus" name="rStatus" <?php if($question_status==1){echo 'checked';} ?> />
          1. โสด</td>
        <td  colspan="2"><input type="radio"  value="2" class="rStatus" name="rStatus" <?php if($question_status==2){echo 'checked';} ?> />
          2. สมรส </td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="3"  class="rStatus"  name="rStatus" <?php if($question_status==3){echo 'checked';} ?>/>
          3. หย่าร้าง</td>
        <td  colspan="2"><input type="radio"  value="4" class="rStatus" name="rStatus" <?php if($question_status==4){echo 'checked';} ?>/>
          4. หม้ายเนื่องจากคู่สมรสเสียชีวิต</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="5"  id="rStatus_5" name="rStatus" <?php if($question_status==5){echo 'checked';} ?> />
          5. แยกกันอยู่ โปรดระบุ</td>
        <td  colspan="2">&nbsp;</td>
      </tr>
      <tr class="rStatus_detail">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><dd>
          <input type="radio"  value="1" class="rStatus_5_detail" name="rStatus_5" <?php if($question_status_detail==1){echo 'checked';} ?> />
          แยกกันอยู่ชั่วคราวตามข้อตกลงตามข้อตกลงระหว่างคู่สมรส</dd></td>
      </tr>
      <tr class="rStatus_detail">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><dd>
          <input type="radio"  value="2" class="rStatus_5_detail" name="rStatus_5" <?php if($question_status_detail==2){echo 'checked';} ?>/>
          แยกกันอยู่ชั่วคราวตามคำสั่งศาล</dd></td>
      </tr>
      <tr>
        <td height="25" align="right">15.</td>
        <td  colspan="2">ลักษณะโครงสร้างครอบครัว</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><input type="radio"  value="1" id="rStructureFamily"  name="rStructureFamily" class="rStructureFamily" <?php if($question_structure==1){echo 'checked';} ?>/>
          1. ครอบครัวเดียว จำนวนสมาชิก
          <input type="text" value="<?php echo $tMemberFamily_1; ?>" size="4" maxlength="4" name="tMemberFamily_1" id="tMemberFamily_1"/>
          คน ชาย
          <input type="text" value="<?php echo $tMemberMale_1; ?>" size="4" maxlength="4" name="tMemberMale_1" id="tMemberMale_1"/>
          คน หญิง
          <input type="text" value="<?php echo $tMemberFemale_1; ?>" size="4" maxlength="4" name="tMemberFemale_1" id="tMemberFemale_1"/>
          &nbsp;คน <strong>*ครอบครัวที่ประกอบด้วยพ่อ แม่ และลูกที่ยังไม่ได้แต่งงาน</strong></td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="2"><input type="radio"  value="2" id="rLargeFamily" name="rStructureFamily" class="rLargeFamily" <?php if($question_structure==2){echo 'checked';} ?>/>
          2. ครอบครัวขยาย โปรดระบุ</td>
        <td >&nbsp;</td>
      </tr>
      <tr class="r15_2">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><dd>
          <input type="radio"  value="1" id="rLargeFamily_21" name="rLargeFamily" class="rLargeFamily_23" <?php if($rLargeFamily==1){echo 'checked';} ?> />
          2.1 ครอบครัวขยายที่ประกอบด้วยหลาย ๆ ครัวเรือนอยู่ร่วมกัน แต่ละครัวเรือน <u>มีความสัมพันธ์ต่อกัน</u></dd></td>
      </tr>
      <tr class="r15_2">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><dd> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จำนวนสมาชิก
          <input type="text" value="<?php echo $tMemberFamily_2_1; ?>" size="4" maxlength="4" name="tMemberFamily_2_1" id="tMemberFamily_2_1"  />
          คน ชาย
          <input type="text" value="<?php echo $tMemberMale_2_1; ?>" size="4" maxlength="4" name="tMemberMale_2_1" id="tMemberMale_2_1" />
          คน หญิง
          <input type="text" value="<?php echo $tMemberFemale_2_1; ?>" size="4" maxlength="4" name="tMemberFemale_2_1" id="tMemberFemale_2_1" />
          &nbsp;คน </dd></td>
      </tr>
      <tr class="r15_2">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><dd>
          <input type="radio"  value="2" id="rLargeFamily_22" name="rLargeFamily" class="rLargeFamily_24" <?php if($rLargeFamily==2){echo 'checked';} ?> />
          2.2 ครอบครัวขยายที่ประกอบด้วยหลาย ๆ ครัวเรือนอยู่ร่วมกัน แต่ละครัวเรือน <u>มีความอิสระต่อกัน</u>ในการดำเนินชีวิตครอบครัวของตนเอง </dd></td>
      </tr>
      <tr class="r15_2">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3" valign="top"><dd> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จำนวนสมาชิก
          <input type="text" value="<?php echo $tMemberFamily_2_2; ?>" size="4" maxlength="4"  name="tMemberFamily_2_2" id="tMemberFamily_2_2"/>
          คน ชาย
          <input type="text" value="<?php echo $tMemberMale_2_2; ?>" size="4" maxlength="4" name="tMemberMale_2_2" id="tMemberMale_2_2" />
          คน หญิง
          <input type="text" value="<?php echo $tMemberFemale_2_2; ?>" size="4" maxlength="4"  name="tMemberFemale_2_2" id="tMemberFemale_2_2"/>
          &nbsp;คน </dd></td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="2"><input type="radio"  value="3" id="rSpecialFamily"  name="rStructureFamily" class="rSpecialFamily" <?php if($question_structure==3){echo 'checked';} ?>/>
          3. ครอบครัวลักษณะพิเศษ โปรดระบุ</td>
        <td >&nbsp;</td>
      </tr>
      <tr class="r15_3">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="2"><dd>
          <input type="radio"  value="1" id="rSpecialFamily_1" name="rSpecialFamily" class="rSpecialFamily_1" <?php if($rSpecialFamily==1){echo 'checked';} ?> />
          3.1 ครอบครัวที่ไม่มีบุตร</dd></td>
        <td >&nbsp;</td>
      </tr>
      <tr class="r15_3">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="2"><dd>
          <input type="radio"  value="2" id="rSpecialFamily_2" name="rSpecialFamily" class="rSpecialFamily_2" <?php if($rSpecialFamily==2){echo 'checked';} ?>/>
          3.2 ครอบครัวพ่อหรือแม่เลี้ยงเดี่ยว</dd></td>
        <td >&nbsp;</td>
      </tr>
      <tr class="r15_3">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="2"><dd>
          <input type="radio"  value="3" id="rSpecialFamily_3"  name="rSpecialFamily" class="rSpecialFamily_3" <?php if($rSpecialFamily==3){echo 'checked';} ?>/>
          3.3 ครอบครัวบุตรบุญธรรม</dd></td>
        <td >&nbsp;</td>
      </tr>
      <tr class="r15_3">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="2"><dd>
          <input type="radio"  value="4" id="rSpecialFamily_4"  name="rSpecialFamily" class="rSpecialFamily_4" <?php if($rSpecialFamily==4){echo 'checked';} ?> />
          3.4 ครอบครัวเพศทางเลือก</dd></td>
        <td >&nbsp;</td>
      </tr>
      <tr class="r15_3">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="2"><dd>
          <input type="radio"  value="5" id="rSpecialFamily_5"  name="rSpecialFamily" class="rSpecialFamily_5" <?php if($rSpecialFamily==5){echo 'checked';} ?>/>
          3.5 ครอบครัวอุปถัมภ์</dd></td>
        <td >&nbsp;</td>
      </tr>
      <tr class="r15_3">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><dd>
          <input type="radio"  value="6" id="rSpecialFamily_6"  name="rSpecialFamily" class="rSpecialFamily_6" <?php if($rSpecialFamily==6){echo 'checked';} ?>/>
          3.6 อื่น ๆ ระบุ
          <input name="tSpecialFamily_3" type="text" value="<?php echo $tSpecialFamily_3;  ?>" style="width:85%" id="tSpecialFamily_3"  />
        </dd></td>
      </tr>
      <tr>
        <td height="25" align="right">16. </td>
        <td  colspan="2">จำนวนสมาชิกในครอบครัวที่มีภาวะพึ่งพิงสูง (ไม่สามารถช่วยเหลือตนเองได้)</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td width="280" ><input type="radio" <?php if($question_defective==1){echo 'checked';} ?>  value="1"  id="rDefective_1" name="rDefective"  />
          1. ไม่มี</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="2"  id="rDefective_2"  name="rDefective" <?php if($question_defective==2){echo 'checked';} ?>/>
          2. จำนวน
          <input type="text" value="<?php echo $tDefective;  ?>" size="4" maxlength="4" name="tDefective" />
          คน โปรดระบุ </td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr id="t16_detail">
        <td height="25" align="right">&nbsp;</td>
        <td colspan="3"><dd>
          <table>
            <tr>
              <td>จำนวนเด็กเล็ก (0-4ปี)</td>
              <td><input type="text" value="<?php echo $tChild;  ?>" size="4" maxlength="4" name="tChild" />
                คน</td>
            </tr>
            <tr>
              <td>จำนวนผู้พิการ</td>
              <td><input type="text" value="<?php echo $tDisabled;  ?>" size="4" maxlength="4"  name="tDisabled" />
                คน</td>
            </tr>
            <tr>
              <td>จำนวนผู้ป่วยทางจิต</td>
              <td><input type="text" value="<?php echo $tMindSick;  ?>" size="4" maxlength="4" name="tMindSick" />
                คน</td>
            </tr>
            <tr>
              <td>จำนวนผู้ป่วยเรื้อรัง</td>
              <td><input type="text" value="<?php echo $tSick;  ?>" size="4" maxlength="4"  name="tSick"/>
                คน</td>
            </tr>
            <tr>
              <td>จำนวนผู้สูงอายุ</td>
              <td><input type="text" value="<?php echo $tElderly;  ?>" size="4" maxlength="4" name="tElderly" />
                คน</td>
            </tr>
          </table>
        </dd></td>
      </tr>
      <tr>
        <td height="25" align="right">17. </td>
        <td  colspan="3">จำนวนผู้อาศัยแยกตามกลุ่ม</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td colspan="3"><table width="100%" border="0" cellpadding="1" cellspacing="0" id="t17">
          <thead>
            <tr>
              <th width="184" height="25"  bgcolor="#f2f2f2">ประเภท</th>
              <th width="202"  bgcolor="#f2f2f2">ชาย</th>
              <th width="202"  bgcolor="#f2f2f2">หญิง</th>
              <th width="218"  bgcolor="#f2f2f2">รวม</th>
            </tr>
          </thead>
          <tr>
            <td width="184" height="25"  align="left">&nbsp;1. เด็ก (อายุ 0-18 ปี)</td>
            <td width="202"  align="center"><input  name="tChildMale" type="text" id="tChildMale"  style=" width:80%" maxlength="4" value="<?php echo $tChildMale; ?>"/></td>
            <td width="202"  align="center"><input name="tChildFemale" type="text" id="tChildFemale"  style=" width:80%" maxlength="4" value="<?php echo $tChildFemale; ?>" /></td>
            <td  align="center"><input name="tChildTotal" type="text" id="tChildTotal"  style=" width:80%; background:#CCC" value="<?php echo $tChildTotal; ?>" maxlength="4" readonly="readonly"  /></td>
          </tr>
          <tr>
            <td width="184" height="25"  align="left">&nbsp;2. เยาวชน (อายุ 19-25 ปี)</td>
            <td width="202"  align="center"><input name="tTeensMale" type="text" id="tTeensMale"  style=" width:80%" maxlength="4" value="<?php echo $tTeensMale; ?>"  /></td>
            <td width="202"  align="center"><input name="tTeensFemale" type="text" id="tTeensFemale"  style=" width:80%" maxlength="4" value="<?php echo $tTeensFemale; ?>" /></td>
            <td  align="center"><input name="tTeensTotal" type="text" id="tTeensTotal"  style=" width:80%; background:#CCC" value="<?php echo $tTeensTotal; ?>" maxlength="4" readonly="readonly" /></td>
          </tr>
          <tr>
            <td width="184" height="25"  align="left">&nbsp;3. ผู้อาศัยทั่วไป (อายุ 26-59 ปี)</td>
            <td width="202"  align="center"><input name="tMan" type="text" id="tMan"  style=" width:80%" maxlength="4" value="<?php echo $tMan; ?>" /></td>
            <td width="202"  align="center"><input name="tWoman" type="text" id="tWoman"  style=" width:80%" maxlength="4" value="<?php echo $tWoman; ?>" /></td>
            <td  align="center"><input name="tTotal" type="text" id="tTotal"  style=" width:80%; background:#CCC" value="<?php echo $tTotal; ?>" maxlength="4" readonly="readonly" /></td>
          </tr>
          <tr>
            <td width="184" height="25"  align="left">&nbsp;4. ผู้สูงอายุ (อายุ 60 ปี)</td>
            <td width="202"  align="center"><input name="tElderMale" type="text" id="tElderMale"  style=" width:80%" maxlength="4" value="<?php echo $tElderMale; ?>" /></td>
            <td width="202"  align="center"><input name="tElderFemale" type="text" id="tElderFemale"  style=" width:80%" maxlength="4" value="<?php echo $tElderFemale; ?>" /></td>
            <td  align="center"><input name="tElderTotal" type="text" id="tElderTotal"  style=" width:80%; background:#CCC" value="<?php echo $tElderTotal; ?>" maxlength="4" readonly="readonly" /></td>
          </tr>
          <tr>
            <td width="184" height="25"  align="left">&nbsp;5. คนพิการ</td>
            <td width="202"  align="center"><input name="tDisabledMale" type="text" id="tDisabledMale"  style=" width:80%" maxlength="4" value="<?php echo $tDisabledMale; ?>" /></td>
            <td width="202"  align="center"><input name="tDisabledFemale" type="text" id="tDisabledFemale"  style=" width:80%" maxlength="4" value="<?php echo $tDisabledFemale; ?>"  /></td>
            <td  align="center"><input name="tDisabledTotal" type="text" id="tDisabledTotal"  style=" width:80%; background:#CCC" value="<?php echo $tDisabledTotal; ?>" maxlength="4" readonly="readonly" /></td>
          </tr>
          <tr>
            <td width="184" height="25"  align="center">รวมทั้งสิ้น</td>
            <td width="202"  align="center"><input name="tMaleTotal" type="text" id="tMaleTotal"  style=" width:80%; background:#CCC" value="<?php echo $tMaleTotal; ?>" maxlength="4" readonly="readonly"  /></td>
            <td width="202"  align="center"><input name="tFemaleTotal" type="text" id="tFemaleTotal"  style=" width:80%; background:#CCC" value="<?php echo $tFemaleTotal; ?>" maxlength="4" readonly="readonly" /></td>
            <td  align="center"><input name="tSumTotal" type="text" id="tSumTotal"  style=" width:80%; background:#CCC" value="<?php echo $tSumTotal; ?>" maxlength="4" readonly="readonly"  /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="25" align="right">18.</td>
        <td  colspan="2">ครอบครัวมีหนี้สิน </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td  valign="top"><input type="radio"  value="1"  id="rDebt_1"  name="rDebt" <?php if($question_debt==1){echo 'checked';} ?>/>
          1. ไม่มี</td>
        <td  valign="top"><br></td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="2"  id="rDebt_2" name="rDebt" <?php if($question_debt==2){echo 'checked';} ?> />
          2. มี โปรดระบุ</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr class="t18">
        <td height="25" align="right">&nbsp;</td>
        <td >&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio"  value="1"  id="rDebt_a" name="rDebt_a" <?php if($question_debt_a==1){echo 'checked';} ?> />
          2.1 หนี้ในระบบ</td>
        <td  colspan="2">&nbsp;</td>
      </tr>
      <tr id="t18_a" class="t18">
        <td height="25" align="right">&nbsp;</td>
        <td colspan="3"><dd>
          <table width="809" border="0" cellpadding="1" cellspacing="1" class="t21">
            <tr>
              <td width="20"><input name="c18[]" type="checkbox" id="c18[]" value="1" <?php if(in_array(1,$chk)){echo 'checked';} ?>></td>
              <td>เงินกู้ธนาคาร</td>
            </tr>
            <tr id="t18_2_1_1">
              <td>&nbsp;</td>
              <td>จำนวน
                <input type="text" value="<?php echo $t21_money_1; ?>" size="10" name="t21_money_1" id="t21_money_1" />ดอกเบี้ยร้อยละ
			<input type="text" value="<?php echo $t21_interest_1; ?>" size="10" name="t21_interest_1" id="t21_interest_1"/>ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน
			<input type="text" value="<?php echo $t21_pay_1; ?>" size="10" name="t21_pay_1" id="t21_pay_1"/>บาท ยอดคงเหลือ
			<input type="text" value="<?php echo $t21_balance_1; ?>" size="10" name="t21_balance_1" id="t21_balance_1" />บาท</td>
            </tr>
            <tr>
              <td><input name="c18[]" type="checkbox" value="2" id="c18[]" <?php if(in_array(2,$chk)){echo 'checked';} ?>></td>
              <td>เงินกู้กองทุนสัจจะสะสมทรัพย์</td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>จำนวน
                <input type="text" value="<?php echo $t21_money_2; ?>" size="10" name="t21_money_2" id="t21_money_2" />ดอกเบี้ยร้อยละ
			<input type="text" value="<?php echo $t21_interest_2; ?>" size="10" name="t21_interest_2" id="t21_interest_2" />ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน
			<input type="text" value="<?php echo $t21_pay_2; ?>" size="10" name="t21_pay_2" id="t21_pay_2" />บาท ยอดคงเหลือ
			<input type="text" value="<?php echo $t21_balance_2; ?>" size="10" name="t21_balance_2" id="t21_balance_2" />บาท</td>
            </tr>
            <tr>
              <td><input name="c18[]" type="checkbox" id="c18_2_3" value="3" <?php if(in_array(3,$chk)){echo 'checked';} ?>></td>
              <td>เงินกู้กองทุนหมู่บ้าน</td>
            </tr>
            <tr id="t18_2_1_3">
              <td>&nbsp;</td>
              <td>จำนวน
                <input type="text" value="<?php echo $t21_money_3; ?>" size="10" name="t21_money_3" id="t21_money_3"/>ดอกเบี้ยร้อยละ
			<input type="text" value="<?php echo $t21_interest_3; ?>" size="10" name="t21_interest_3" id="t21_interest_3" />ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน
			<input type="text" value="<?php echo $t21_pay_3; ?>" size="10" name="t21_pay_3" id="t21_pay_3" />บาท ยอดคงเหลือ
			<input type="text" value="<?php echo $t21_balance_3; ?>" size="10" name="t21_balance_3" id="t21_balance_3" />บาท</td>
            </tr>
            <tr>
              <td><input name="c18[]" type="checkbox" id="c18_2_4" value="4" <?php if(in_array(4,$chk)){echo 'checked';} ?>></td>
              <td>กองทุนพัฒนาบทบาทสตรี</td>
            </tr>
            <tr id="t18_2_1_4">
              <td>&nbsp;</td>
              <td>จำนวน
                <input type="text" value="<?php echo $t21_money_4; ?>" size="10" name="t21_money_4" id="t21_money_4" />ดอกเบี้ยร้อยละ
			<input type="text" value="<?php echo $t21_interest_4; ?>" size="10" name="t21_interest_4" id="t21_interest_4" />ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน
			<input type="text" value="<?php echo $t21_pay_4; ?>" size="10" name="t21_pay_4" id="t21_pay_4" />บาท ยอดคงเหลือ
			<input type="text" value="<?php echo $t21_balance_4; ?>" size="10" name="t21_balance_4" id="t21_balance_4" />บาท</td>
            </tr>
            <tr>
              <td><input name="c18[]" type="checkbox" id="c18_2_5" value="5" <?php if(in_array(5,$chk)){echo 'checked';} ?>></td>
              <td>กองทุนผู้สูงอายุ</td>
            </tr>
            <tr id="t18_2_1_5">
              <td>&nbsp;</td>
              <td>จำนวน
                <input type="text" value="<?php echo $t21_money_5; ?>" size="10" name="t21_money_5" id="t21_money_5" />ดอกเบี้ยร้อยละ
			<input type="text" value="<?php echo $t21_interest_5; ?>" size="10" name="t21_interest_5" id="t21_interest_5" />ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน
			<input type="text" value="<?php echo $t21_pay_5; ?>" size="10" name="t21_pay_5" id="t21_pay_5" />บาท ยอดคงเหลือ
			<input type="text" value="<?php echo $t21_balance_5; ?>" size="10" name="t21_balance_5" id="t21_balance_5" />บาท</td>
            </tr>
            <tr>
              <td><input name="c18[]" type="checkbox" id="c18_2_6" value="6" <?php if(in_array(6,$chk)){echo 'checked';} ?>></td>
              <td>กองทุนส่งเสริมพัฒนาคุณภาพชีวิตคนพิการ</td>
            </tr>
            <tr id="t18_2_1_6">
              <td>&nbsp;</td>
              <td>จำนวน
                <input type="text" value="<?php echo $t21_money_6; ?>" size="10" name="t21_money_6" id="t21_money_6"/>ดอกเบี้ยร้อยละ
			<input type="text" value="<?php echo $t21_interest_6; ?>" size="10" name="t21_interest_6" id="t21_interest_6"/>ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน
			<input type="text" value="<?php echo $t21_pay_6; ?>" size="10" name="t21_pay_6" id="t21_pay_6"/>บาท ยอดคงเหลือ
			<input type="text" value="<?php echo $t21_balance_6; ?>" size="10" name="t21_balance_6" id="t21_balance_6"/>บาท</td>
            </tr>
            <tr>
              <td><input name="c18[]" type="checkbox" id="c18_2_7" value="7" <?php if(in_array(7,$chk)){echo 'checked';} ?>></td>
              <td>กองทุนปุ๋ย</td>
            </tr>
            <tr id="t18_2_1_7">
              <td>&nbsp;</td>
              <td>จำนวน
                <input type="text" value="<?php echo $t21_money_7; ?>" size="10" name="t21_money_7" id="t21_money_7"/>ดอกเบี้ยร้อยละ
			<input type="text" value="<?php echo $t21_interest_7; ?>" size="10" name="t21_interest_7" id="t21_interest_7" />ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน
			<input type="text" value="<?php echo $t21_pay_7; ?>" size="10" name="t21_pay_7" id="t21_pay_7" />บาท ยอดคงเหลือ
			<input type="text" value="<?php echo $t21_balance_7; ?>" size="10" name="t21_balance_7" id="t21_balance_7" />บาท</td>
            </tr>
            <tr>
              <td><input name="c18[]" type="checkbox" id="c18_2_8" value="8" <?php if(in_array(8,$chk)){echo 'checked';} ?>></td>
              <td>กองทุนเกษตร</td>
            </tr>
            <tr id="t18_2_1_8">
              <td>&nbsp;</td>
              <td>จำนวน
                <input type="text" value="<?php echo $t21_money_8; ?>" size="10" name="t21_money_8" id="t21_money_8" />ดอกเบี้ยร้อยละ
			<input type="text" value="<?php echo $t21_interest_8; ?>" size="10" name="t21_interest_8" id="t21_interest_8"/>ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน
			<input type="text" value="<?php echo $t21_pay_8; ?>" size="10" name="t21_pay_8" id="t21_pay_8"/>บาท ยอดคงเหลือ
			<input type="text" value="<?php echo $t21_balance_8; ?>" size="10" name="t21_balance_8" id="t21_balance_8"/>บาท</td>
            </tr>
            <tr>
              <td><input name="c18[]" type="checkbox" id="c18_2_9" value="9" <?php if(in_array(9,$chk)){echo 'checked';} ?>></td>
              <td>อื่น ๆ ระบุ
                <input type="text" value="<?php echo $t21_other; ?>"  style="width:84%" name="t21_other" id="t21_other" /></td>
            </tr>
            <tr id="t18_2_1_9">
              <td>&nbsp;</td>
              <td>จำนวน
                <input type="text" value="<?php echo $t21_money_9; ?>" size="10" name="t21_money_9" id="t21_money_9"/>ดอกเบี้ยร้อยละ
			<input type="text" value="<?php echo $t21_interest_9; ?>" size="10" name="t21_interest_9" id="t21_interest_9"/>ต่อ/ปี ส่งมาแล้วเป็นเงินจำนวน
			<input type="text" value="<?php echo $t21_pay_9; ?>" size="10" name="t21_pay_9" id="t21_pay_9"/>บาท ยอดคงเหลือ
			<input type="text" value="<?php echo $t21_balance_9; ?>" size="10" name="t21_balance_9" id="t21_balance_9"/>บาท</td>
            </tr>
          </table>
        </dd></td>
      </tr>
      <tr class="t18">
        <td height="25" align="right" >&nbsp;</td>
        <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio"  value="2"  id="rDebt_b" name="rDebt_a"  <?php if($question_debt_a==2){echo 'checked';} ?> />
          2.2 หนี้นอกระบบ คุณเป็นหนี้นอกระบบใครบ้าง ระบุชื่อ - สกุลด้วย</td>
      </tr>
      <tr class="t18">
        <td height="25" align="right">&nbsp;</td>
        <td colspan="3"><dd>
          <table width="809" border="0" cellspacing="2" cellpadding="2" id="t18_b" class="order-list">
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                <td >ชื่อ-สกุล
                  <input type="text" name="tName18_2_1" value="<?php echo $tName18_2_1; ?>" /></td>
                <td width="104" >จำนวนเงิน</td>
                <td width="114"><input type="text" name="tMoney18_2_1" size="10" value="<?php echo $tMoney18_2_1; ?>" />
                  บาท</td>
                <td width="104">ดอกเบี้ยร้อยละ</td>
                <td width="264"><input name="tInterest18_2_1" type="text" value="<?php echo $tInterest18_2_1; ?>" size="10" />
                  ต่อวัน/เดือน/ปี </td>
              </tr>
              <tr>
                <td width="191" >&nbsp;</td>
                <td >ส่งมาแล้วเป็นเงิน </td>
                <td ><input name="tPay18_2_1" type="text" value="<?php echo $tPay18_2_1; ?>" size="10" />
                  บาท</td>
                <td >ยอดคงเหลือ</td>
                <td ><input name="tBalance18_2_1" type="text" value="<?php echo $tBalance18_2_1; ?>" size="10" />
                  บาท</td>
              </tr>
              <tr>
                <td >ชื่อ-สกุล
                  <input type="text" name="tName18_2_2" value="<?php echo $tName18_2_2; ?>" /></td>
                <td >จำนวนเงิน</td>
                <td ><input type="text" name="tMoney18_2_2" size="10" value="<?php echo $tMoney18_2_2; ?>" />
                  บาท</td>
                <td >ดอกเบี้ยร้อยละ</td>
                <td ><input name="tInterest18_2_2" type="text" value="<?php echo $tInterest18_2_2; ?>" size="10" />
                  ต่อวัน/เดือน/ปี </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td >ส่งมาแล้วเป็นเงิน</td>
                <td ><input name="tPay18_2_2" type="text" value="<?php echo $tPay18_2_2; ?>" size="10" />
                  บาท</td>
                <td >ยอดคงเหลือ</td>
                <td ><input name="tBalance18_2_2" type="text" value="<?php echo $tBalance18_2_2; ?>" size="10" />
                  บาท</td>
              </tr>
              <tr>
                <td >ชื่อ-สกุล
                  <input type="text" name="tName18_2_3" value="<?php echo $tName18_2_3; ?>" /></td>
                <td>จำนวนเงิน</td>
                <td ><input type="text" name="tMoney18_2_3" size="10" value="<?php echo $tMoney18_2_3; ?>" />
                  บาท</td>
                <td>ดอกเบี้ยร้อยละ</td>
                <td ><input name="tInterest18_2_3" type="text" value="<?php echo $tInterest18_2_3; ?>" size="10" />
                  ต่อวัน/เดือน/ปี </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td>ส่งมาแล้วเป็นเงิน</td>
                <td ><input name="tPay18_2_3" type="text" value="<?php echo $tPay18_2_3; ?>" size="10" />
                  บาท</td>
                <td>ยอดคงเหลือ</td>
                <td ><input name="tBalance18_2_3" type="text" value="<?php echo $tBalance18_2_3; ?>" size="10" />
                  บาท</td>
              </tr>
              <tr>
                <td >ชื่อ-สกุล
                  <input type="text" name="tName18_2_4" value="<?php echo $tName18_2_4; ?>" /></td>
                <td>จำนวนเงิน</td>
                <td ><input type="text" name="tMoney18_2_4" size="10" value="<?php echo $tMoney18_2_4; ?>" />
                  บาท</td>
                <td>ดอกเบี้ยร้อยละ</td>
                <td ><input name="tInterest18_2_4" type="text" value="<?php echo $tInterest18_2_4; ?>" size="10" />
                  ต่อวัน/เดือน/ปี </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td>ส่งมาแล้วเป็นเงิน</td>
                <td ><input name="tPay18_2_4" type="text" value="<?php echo $tPay18_2_4; ?>" size="10" />
                  บาท</td>
                <td>ยอดคงเหลือ</td>
                <td ><input name="tBalance18_2_4" type="text" value="<?php echo $tBalance18_2_4; ?>" size="10" />
                  บาท</td>
              </tr>
              <tr>
                <td >ชื่อ-สกุล
                  <input type="text" name="tName18_2_5" value="<?php echo $tName18_2_5; ?>" /></td>
                <td>จำนวนเงิน</td>
                <td ><input type="text" name="tMoney18_2_5" size="10" value="<?php echo $tMoney18_2_5; ?>" />
                  บาท</td>
                <td>ดอกเบี้ยร้อยละ</td>
                <td ><input name="tInterest18_2_5" type="text" value="<?php echo $tInterest18_2_5; ?>" size="10" />
                  ต่อวัน/เดือน/ปี </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td>ส่งมาแล้วเป็นเงิน</td>
                <td ><input name="tPay18_2_5" type="text" value="<?php echo $tPay18_2_5; ?>" size="10" />
                  บาท</td>
                <td>ยอดคงเหลือ</td>
                <td ><input name="tBalance18_2_5" type="text" value="<?php echo $tBalance18_2_5; ?>" size="10" />
                  บาท</td>
              </tr>
              <tr>
                <td >ชื่อ-สกุล
                  <input type="text" name="tName18_2_6" value="<?php echo $tName18_2_6; ?>" /></td>
                <td>จำนวนเงิน</td>
                <td ><input type="text" name="tMoney18_2_6" size="10" value="<?php echo $tMoney18_2_6; ?>"/>
                  บาท</td>
                <td>ดอกเบี้ยร้อยละ</td>
                <td ><input name="tInterest18_2_6" type="text" value="<?php echo $tInterest18_2_6; ?>" size="10" />
                  ต่อวัน/เดือน/ปี </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td>ส่งมาแล้วเป็นเงิน</td>
                <td ><input name="tPay18_2_6" type="text" value="<?php echo $tPay18_2_6; ?>" size="10" />
                  บาท</td>
                <td>ยอดคงเหลือ</td>
                <td ><input name="tBalance18_2_6" type="text" value="<?php echo $tBalance18_2_6; ?>" size="10" />
                  บาท</td>
              </tr>
            </tfoot>
          </table>
        </dd></td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td colspan="3" align="right"><button> บันทึก </button></td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td colspan="2" align="right">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td colspan="2" align="right">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td colspan="2" align="right">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
</form>
<script>

<?php $current_year = date("Y")+543; ?>

$(document).ready(function () {
$("#tbirthday").change(function () {
	var result = document.getElementById('tbirthday').value;
	x =result.split("/");
        document.getElementById('tAge').value = ('<?=$current_year?>') - x[2];
});//rSex

$("#tbirthday").change(function () {
	var result = document.getElementById('tbirthday').value;
	x =result.split("/");
        document.getElementById('tAge').value = ('<?=$current_year?>') - x[2];
});
//ส่วนของการตรวจสอบเงื่อนไขการDisabled 
//ตรวจสอบเงื่อนไขกลุ่มเพศ
$('.rSex').click(function(){
	$("#tSex").attr('disabled','disabled');
});

$('#rSex_3').click(function(){
	$("#tSex").removeAttr('disabled');
});

//ตรวจสอบเงื่อนไขกลุ่มที่อยู่อาศัย
$('.rTypeHome').click(function(){
	$("#tTypeHome_4").attr('disabled','disabled');
});
$('.rTypeHome').click(function(){
	$("#tTypeHome_2").attr('disabled','disabled');
});

$('#rTypeHome_2').click(function(){
	$("#tTypeHome_2").removeAttr('disabled');
});
$('#rTypeHome_4').click(function(){
	$("#tTypeHome_4").removeAttr('disabled');
});

//ตรวจสอบเงื่อนไขกลุ่มอาชีพ
$('#cCareer10').click(function(){
	if($('#tCareer').attr('disabled')){
		$('#tCareer').removeAttr('disabled')
	}else{
		$('#tCareer').attr('disabled','disabled')
	}
});
$('#cCareer4').click(function(){
	 if($('#cCareer5').attr('disabled')){
		$('#cCareer5,#cCareer6,#cCareer8').removeAttr('disabled')
	}else{
		$('#cCareer5,#cCareer6,#cCareer8').attr('disabled','disabled')
		$('#cCareer5,#cCareer6,#cCareer8').removeAttr('checked')
	}
});
$('#cCareer5').click(function(){
	 if($('#cCareer4').attr('disabled')){
		$('#cCareer4,#cCareer6,#cCareer8').removeAttr('disabled')
	}else{
		$('#cCareer4,#cCareer6,#cCareer8').attr('disabled','disabled')
		$('#cCareer4,#cCareer6,#cCareer8').removeAttr('checked')
	}
});
$('#cCareer6').click(function(){
	 if($('#cCareer4').attr('disabled')){
		$('#cCareer4,#cCareer5,#cCareer8').removeAttr('disabled')
	}else{
		$('#cCareer4,#cCareer5,#cCareer8').attr('disabled','disabled')
		$('#cCareer4,#cCareer5,#cCareer8').removeAttr('checked')
	}
});
$('#cCareer8').click(function(){
	 if($('#cCareer4').attr('disabled')){
		$('#cCareer4,#cCareer6,#cCareer5').removeAttr('disabled')
	}else{
		$('#cCareer4,#cCareer6,#cCareer5').attr('disabled','disabled')
		$('#cCareer4,#cCareer6,#cCareer5').removeAttr('checked')
	}
});

$('.careertable input:not(#cCareer9,#cCareer10)').click(function(){
	if($('.careertable input:not(#cCareer9,#cCareer10)').is(':checked') == true){
		$('#cCareer9').attr('disabled','disabled')
		$('#cCareer9').removeAttr('checked')
	}
	if($('.careertable input:not(#cCareer9,#cCareer10)').is(':checked') == false){
		$('#cCareer9').removeAttr('disabled')
	}
})

$('#cCareer9').click(function(){
		 if($('.careertable input:not(#cCareer9,#cCareer10)').attr('disabled')){
			$('.careertable input:not(#cCareer9,#cCareer10,#tCareer)').removeAttr('disabled')
		 }else{
			$('.careertable input:not(#cCareer9,#cCareer10,#tCareer)').attr('disabled','disabled')
			$('.careertable input:not(#cCareer9,#cCareer10,#tCareer)').removeAttr('checked')
		}
});

//ตรวจสอบเงื่อนไขกลุ่มที่ดิน
$('.rLand_1').click(function(){
	$("#tLand").attr('disabled','disabled');
});

$('#rLand').click(function(){
	$("#tLand").removeAttr('disabled');
});
//ตรวจสอบเงื่อนไขกลุ่มศาสนา
$('.rReligion').click(function(){
	$("#tReligion_1").attr('disabled','disabled');
});
$('.rReligion_1').click(function(){
	$("#tReligion_1").removeAttr('disabled');
});

//ตรวจสอบเงื่อนไขสภานภาพสมรส
$('.rStatus').click(function(){
	$(".rStatus_detail").hide();
});

$('#rStatus_5').click(function(){
	$(".rStatus_detail").show();
});

//------------------------------------------------ 16
$('#rDefective_1').click(function(){
	$('#t16_detail').hide();
});

$('#rDefective_2').click(function(){
	$('#t16_detail').show();
});

//------------------------------------------------ 17
$("#t17 input").keyup(function () {
	
	var tChildMale = document.getElementById('tChildMale').value;
	var tChildFemale = document.getElementById('tChildFemale').value;
	if(tChildMale==''){tChildMale = 0;}
	if(tChildFemale==''){tChildFemale = 0;}
	var tChildTotal = parseInt(tChildMale)+parseInt(tChildFemale);
	$("#tChildTotal").val(tChildTotal);
	
	var tTeensMale = document.getElementById('tTeensMale').value;
	var tTeensFemale = document.getElementById('tTeensFemale').value;
	if(tTeensMale==''){tTeensMale = 0;}
	if(tTeensFemale==''){tTeensFemale = 0;}
	var tTeensTotal = parseInt(tTeensMale)+parseInt(tTeensFemale);
	$("#tTeensTotal").val(tTeensTotal);
	
	var tMan = document.getElementById('tMan').value;
	var tWoman = document.getElementById('tWoman').value;
	if(tMan==''){tMan = 0;}
	if(tWoman==''){tWoman = 0;}
	var tTotal = parseInt(tMan)+parseInt(tWoman);
	$("#tTotal").val(tTotal);
	
	var tElderMale = document.getElementById('tElderMale').value;
	var tElderFemale = document.getElementById('tElderFemale').value;
	if(tElderMale==''){tElderMale = 0;}
	if(tElderFemale==''){tElderFemale = 0;}
	var tElderTotal = parseInt(tElderMale)+parseInt(tElderFemale);
	$("#tElderTotal").val(tElderTotal);
	
	var tDisabledMale = document.getElementById('tDisabledMale').value;
	var tDisabledFemale = document.getElementById('tDisabledFemale').value;
	if(tDisabledMale==''){tDisabledMale = 0;}
	if(tDisabledFemale==''){tDisabledFemale = 0;}
	var tDisabledTotal = parseInt(tDisabledMale)+parseInt(tDisabledFemale);
	$("#tDisabledTotal").val(tDisabledTotal);

	var tMaleTotal = parseInt(tChildMale)+parseInt(tTeensMale)+parseInt(tMan)+parseInt(tElderMale)+parseInt(tDisabledMale);
	var tFemaleTotal = parseInt(tChildFemale)+parseInt(tTeensFemale)+parseInt(tWoman)+parseInt(tElderFemale)+parseInt(tDisabledFemale);
	var tSumTotal = parseInt(tMaleTotal)+parseInt(tFemaleTotal);
	
	$("#tMaleTotal").val(tMaleTotal);
	$("#tFemaleTotal").val(tFemaleTotal);
	$("#tSumTotal").val(tSumTotal);
});

//เงื่อนไขกลุ่มครอบครัว
//////////////////////////ตรวจสอบเงื่อนไขกลุ่มครอบครัวเดี่ยว
$('.rStructureFamily').click(function(){
	$(					"#rLargeFamily_21,#rLargeFamily_22,#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").attr('disabled','disabled');
});
$('.rStructureFamily').click(function(){
	$("#tMemberFamily_1,#tMemberMale_1,#tMemberFemale_1").removeAttr('disabled');
});
$('.rStructureFamily').click(function(){
	$("#rLargeFamily_21,#rLargeFamily_22").removeAttr('checked');
});
$('.rStructureFamily').click(function(){
	$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
});

$('.rStructureFamily').click(function(){
	$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
});
$('.rStructureFamily').click(function(){
	$("#tSpecialFamily_3").attr('disabled','disabled');
});
$('.rStructureFamily').click(function(){
	$("#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").removeAttr('checked');
});

/////////////////////////////ตรวจสอบเงื่อนไขกลุ่มครอบครัวขยาย
$('.rLargeFamily').click(function(){
	$("#tMemberFamily_1,#tMemberMale_1,#tMemberFemale_1,#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").attr('disabled','disabled');
});

$('.rLargeFamily').click(function(){
	$("#rLargeFamily_21,#rLargeFamily_22").removeAttr('disabled');
});

$('.rLargeFamily_23').click(function(){
	$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").removeAttr('disabled');
});
$('.rLargeFamily_24').click(function(){
	$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").removeAttr('disabled');
});
$('.rLargeFamily_24').click(function(){
	$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
});
$('.rLargeFamily_23').click(function(){
	$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
});
$('.rLargeFamily').click(function(){
	$("#tSpecialFamily_3").attr('disabled','disabled');
});
$('.rLargeFamily').click(function(){
	$("#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").removeAttr('checked');
});

///////////////////////////////////ตรวจสอบเงื่อนไขปุ่มครอบครัวพิเศษ
$('.rSpecialFamily').click(function(){
	$("#rLargeFamily_21,#rLargeFamily_22,#tMemberFamily_1,#tMemberMale_1,#tMemberFemale_1").attr('disabled','disabled');
});
$('.rSpecialFamily').click(function(){
	$("#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").removeAttr('disabled');	
});
$('.rSpecialFamily').click(function(){
	$("#rLargeFamily_21,#rLargeFamily_22").removeAttr('checked');
});
$('.rSpecialFamily').click(function(){
	$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
});
$('.rSpecialFamily').click(function(){
	$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
});
$('.rSpecialFamily_6').click(function(){
	$("#tSpecialFamily_3").removeAttr('disabled');
});
$('#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5').click(function(){
	$("#tSpecialFamily_3").attr('disabled','disabled');
});

/*------------------------------------ ตรวจสอบซ่อนข้อความ r15_2 r15_3 rStructureFamily rLargeFamily rSpecialFamily*/ 
$('#rStructureFamily').click(function(){
	$(".r15_2").hide();
	$(".r15_3").hide();
});

$('#rLargeFamily').click(function(){
	$(".r15_2").show();
	$(".r15_3").hide();
});

$('#rSpecialFamily').click(function(){
	$(".r15_2").hide();
	$(".r15_3").show();
});

//------------------------------------------------ 18 rDebt_1
$('#rDebt_1').click(function(){
	$('.t18').hide();
})

$('#rDebt_2').click(function(){
	$('.t18').show();
	//$('#rDebt_a').arr('checked',true);
	document.getElementById('rDebt_a').checked = true;
})

$('#rDebt_a').click(function(){
	$('#t18_a').show();
	$('#t18_b').hide();
})
$('#rDebt_b').click(function(){
	$('#t18_a').hide();//prop
	$('#t18_b').show();
})
});
    
</script>

