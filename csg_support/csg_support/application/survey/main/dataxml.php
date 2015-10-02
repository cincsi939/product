<?
/**
* @comment หน้าแสดง XML รายคน
* @projectCode -
* @tor  -
* @package core
* @author Jakrit Monkong
* @access 
* @created 12/09/2014
*/

//header("Content-type: text/html; charset=utf-8"); 
$con = new Cfunction();
$con->connectDB();
error_reporting(E_ALL ^ E_NOTICE);
/*$sql = 'SELECT question_id,question_date,question_firstname,question_lastname,question_idcard,question_idcard_detail,question_address,question_village,';
$sql .= 'question_street,question_parish,question_district,question_province,question_phone,question_sex,question_sex_detail,question_birthday,question_age,';
$sql .= 'question_typehome,question_typehome_detail,question_stypehome_1,question_stypehome_2,question_stypehome_3,question_environment,question_education,';
$sql .= 'question_career,question_career_detail,question_land,question_land_detail,question_Income,question_religion,question_religion_detail,question_status,question_status_detail,';
$sql .= 'question_structure,question_structure_detail,question_defective,question_defective_detail,question_debt,question_debt_sub,question_debt_detail,question_img,';
$sql .= 'question_residents_1,question_residents_2,question_residents_3,question_residents_4,question_residents_5,';
$sql .= 'question_residents_1t,question_residents_2t,question_residents_3t,question_residents_4t,question_residents_5t,question_residents_tt,question_round,question_prename';
$sql .= ' FROM question_detail_1 INNER JOIN tbl_prename ON tbl_prename.id = question_prename';
$sql .= ' WHERE question_idcard_detail='.$_GET['id'];*/

$sql = "select siteid,form_id,number_action,pin,child_userid,vid,yy,mm,value,reportdate from eq_var_data where siteid=1 AND pin='".$_GET['id']."'";
$results = $con->select($sql);

foreach($results as $row){
	$value['v'.$row['vid']] = $row['value'];	
	$date = $row['reportdate'];
}
if($value['v23']){$career[] = $value['v23'];$career_detail[] = 'รับจ้างทั่วไป';}
if($value['v24']){$career[] = $value['v24'];$career_detail[] = 'เกษตรกร';}
if($value['v25']){$career[] = $value['v25'];$career_detail[] = 'ประมง';}
if($value['v26']){$career[] = $value['v26'];$career_detail[] = 'ข้าราชการ/ลูกจ้างหรือพนักงานของรัฐ';}
if($value['v27']){$career[] = $value['v27'];$career_detail[] = 'พนักงานรัฐวิสาหกิจ';}
if($value['v28']){$career[] = $value['v28'];$career_detail[] = 'เจ้าหน้าที่องค์กรปกครองท้องถิ่น ';}
if($value['v29']){$career[] = $value['v29'];$career_detail[] = 'ค้าขาย/ธุรกิจส่วนตัว';}
if($value['v30']){$career[] = $value['v30'];$career_detail[] = 'พนักงาน/ลูกจ้างเอกชน';}
if($value['v31']){$career[] = $value['v31'];$career_detail[] = 'ว่างงาน/ไม่มีงานทำ';}
if($value['v32']){$career[] = $value['v32'];$career_detail[] = 'อื่น ๆ';}
if($value['v33']!=''){$career_detail = iconv("utf-8","TIS-620//IGNORE",$value['v33']);}
$career_code = json_encode($career);

//$career_code = implode(',',$career);
//$career_title = implode(',',$career_detail);
//echo "<pre>";
//print_r($row);

$myxml = "
<data>
<Position1>
<NodeData1 label='prename_th'>".iconv("utf-8","TIS-620//IGNORE",$value['376'])."</NodeData1>
<NodeData2 label='question_id'>".iconv("utf-8","TIS-620//IGNORE",$value['v3'])."</NodeData2>
<NodeData3 label='question_date'>".iconv("utf-8","TIS-620//IGNORE",$date)."</NodeData3>
<NodeData4 label='question_firstname'>".iconv("utf-8","TIS-620//IGNORE",$value['v1'])."</NodeData4>
<NodeData5 label='question_lastname'>".iconv("utf-8","TIS-620//IGNORE",$value['v2'])."</NodeData5>
<NodeData6 label='question_idcard'>1</NodeData6>
<NodeData7 label='question_idcard_detail'>".iconv("utf-8","TIS-620//IGNORE",$value['v3'])."</NodeData7>
<NodeData8 label='question_address'>".iconv("utf-8","TIS-620//IGNORE",$value['v5'])."</NodeData8>
<NodeData9 label='question_village'>".iconv("utf-8","TIS-620//IGNORE",$value['v6'])."</NodeData9>
<NodeData10 label='question_street'>".iconv("utf-8","TIS-620//IGNORE",$value['v7'])."</NodeData10>
<NodeData11 label='question_parish'>".iconv("utf-8","TIS-620//IGNORE",$value['v8'])."</NodeData11>
<NodeData12 label='question_district'>".iconv("utf-8","TIS-620//IGNORE",$value['v9'])."</NodeData12>
<NodeData13 label='question_province'>".iconv("utf-8","TIS-620//IGNORE",$value['v10'])."</NodeData13>
<NodeData14 label='question_phone'>".iconv("utf-8","TIS-620//IGNORE",$value['v11'])."</NodeData14>
<NodeData15 label='question_sex'>".iconv("utf-8","TIS-620//IGNORE",$value['v12'])."</NodeData15>
<NodeData16 label='question_sex_detail'> </NodeData16>
<NodeData17 label='question_birthday'>".iconv("utf-8","TIS-620//IGNORE",$value['v377'])."</NodeData17>
<NodeData18 label='question_age'>".iconv("utf-8","TIS-620//IGNORE",$value['v14'])."</NodeData18>
<NodeData19 label='question_typehome'>".iconv("utf-8","TIS-620//IGNORE",$row['v15'])."</NodeData19>
<NodeData20 label='question_typehome_detail'>".iconv("utf-8","TIS-620//IGNORE",$value['v16'])."</NodeData20>
<NodeData21 label='question_stypehome_1'>".iconv("utf-8","TIS-620//IGNORE",$value['v18'])."</NodeData21>
<NodeData22 label='question_stypehome_2'>".iconv("utf-8","TIS-620//IGNORE",$value['v19'])."</NodeData22>
<NodeData23 label='question_stypehome_3'>".iconv("utf-8","TIS-620//IGNORE",$value['v20'])."</NodeData23>
<NodeData24 label='question_environment'>".iconv("utf-8","TIS-620//IGNORE",$value['v21'])."</NodeData24>
<NodeData25 label='question_education'>".iconv("utf-8","TIS-620//IGNORE",$value['v22'])."</NodeData25>
<NodeData26 label='question_career'>".iconv("utf-8","TIS-620//IGNORE",$career_code)."</NodeData26>
<NodeData27 label='question_career_detail'>".$career_detail."</NodeData27>
<NodeData28 label='question_land'>".iconv("utf-8","TIS-620//IGNORE",$value['v34'])."</NodeData28>
<NodeData29 label='question_land_detail'>".iconv("utf-8","TIS-620//IGNORE",$value['v35'])."</NodeData29>
<NodeData30 label='question_Income'>".iconv("utf-8","TIS-620//IGNORE",$value['v36'])."</NodeData30>
<NodeData31 label='question_religion'>".iconv("utf-8","TIS-620//IGNORE",$value['37'])."</NodeData31>
<NodeData32 label='question_religion_detail'>".iconv("utf-8","TIS-620//IGNORE",$value['v38'])."</NodeData32>
<NodeData33 label='question_status'>".iconv("utf-8","TIS-620//IGNORE",$value['v39'])."</NodeData33>
<NodeData34 label='question_status_detail'>".iconv("utf-8","TIS-620//IGNORE",$value['v40'])."</NodeData34>
<NodeData35 label='question_structure'>".iconv("utf-8","TIS-620//IGNORE",$value['v41'])."</NodeData35>
<NodeData36 label='question_structure_detail'>' '</NodeData36>
<NodeData37 label='question_defective'>".iconv("utf-8","TIS-620//IGNORE",$value['v79'])."</NodeData37>
<NodeData38 label='question_defective_detail'>".iconv("utf-8","TIS-620//IGNORE",$value['v79'])."</NodeData38>
<NodeData39 label='question_debt'>".iconv("utf-8","TIS-620//IGNORE",$value['v80'])."</NodeData39>
<NodeData40 label='question_debt_sub'>".iconv("utf-8","TIS-620//IGNORE",$value['v379'])."</NodeData40>
<NodeData41 label='question_debt_detail'>' '</NodeData41>
<NodeData42 label='question_img'>
		<DataImage>".$value['v378']."</DataImage>
</NodeData42>
</Position1>

";


$myxml .= "</data>";




	/*--------------------------------------------------------------------------------------- set Database*/
$question_stypehome_1 = $value['v18'];
$question_stypehome_2 =  $value['v19'];
$question_stypehome_3 =  $value['v20'];
$question_environment = $value['v21'];

$question_land =  $value['v34'];
$question_land_detail = $value['v35'];

$question_status = $value['v39'];
$question_status_detail =  $value['v40'];

$question_religion =  $value['v37'];
$question_religion_detail = $value['v38'];

$question_structure =  $value['v41'];
$tMemberFamily_1 =  $value['v42'];
$tMemberMale_1 =  $value['v43'];
$tMemberFemale_1 =  $value['v44'];

$tMemberFamily_2_1 =  $value['v46'];
$tMemberMale_2_1 =  $value['v47'];
$tMemberFemale_2_1 =  $value['v48'];

$tMemberFamily_2_2 =  $value['v50'];
$tMemberMale_2_2 =  $value['v51'];
$tMemberFemale_2_2 =  $value['v52'];

$rSpecialFamily =  $value['v53'];
$tSpecialFamily_3 =  $value['v54'];

$question_defective =  $value['v55'];
$tDefective =  $value['v56'];
$tChild =  $value['v57'];
$tDisabled =  $value['v58'];
$tMindSick =  $value['v59'];
$tSick =  $value['v60'];
$tElderly =  $value['v61'];

$tChildMale =  $value['v62'];
$tChildFemale =  $value['v63'];
$tChildTotal =  $value['v64'];

$tTeensMale =  $value['v65'];
$tTeensFemale =  $value['v66'];
$tTeensTotal =  $value['v66'];

$tMan =  $value['v67'];
$tWoman =  $value['v68'];
$tTotal =  $value['v69'];

$tElderMale =  $value['v70'];
$tElderFemale =  $value['v71'];
$tElderTotal =  $value['v72'];

$tDisabledMale =  $value['v73'];
$tDisabledFemale =  $value['v74'];
$tDisabledTotal =  $value['v75'];

$tMaleTotal =  $value['v76'];
$tFemaleTotal =  $value['v77'];
$tSumTotal =  $value['v78'];

//$tFirstname = $row['question_firstname'];
//	$tLastname = $row['question_lastname'];
//	$question_idcard = $row['question_idcard'];
//	$question_idcard_detail = $row['question_idcard_detail'];
//	
//	$question_address = $row['question_address'];
//	$question_village = $row['question_village'];
//	$question_street = $row['question_street'];
//	$question_parish = $row['question_parish'];
//	$question_district = $row['question_district'];
//	$question_province = $row['question_province'];
//	$question_phone = $row['question_phone'];
//	
//	$question_sex = $row['question_sex'];
//	$question_sex_detail = $row['question_sex_detail'];
//	
//	$question_birthday = $row['question_birthday'];
//	$question_age = $row['question_age'];
//	
//	$question_typehome = $row['question_typehome'];
//	$question_typehome_detail = $row['question_typehome_detail'];
//	if($question_typehome==2)
//	{
//		$detail_2 = $question_typehome_detail;
//		$detail_4 = '';
//	}
//		else
//	{
//		$detail_2 = '';
//		$detail_4 = $question_typehome_detail;
//	}
//	
//	$question_stypehome_1 = $row['question_stypehome_1'];
//	$question_stypehome_2 = $row['question_stypehome_2'];
//	$question_stypehome_3 = $row['question_stypehome_3'];
//	$question_environment = $row['question_environment'];
//	$question_education = $row['question_education'];
//	
//	/*--------------------------------------------------------------------------------------- อาชีพหลัก*/
//	$question_career = $row['question_career'];
//	$question_career_detail = $row['question_career_detail'];
//	$question_career = json_decode($question_career);
//	if(count($question_career)==0)
//	{
//		$question_career[] = 0;
//	}
//	
//	$question_land = $row['question_land'];
//	$question_land_detail = $row['question_land_detail'];
//	
//	$question_Income = $row['question_Income'];
//	$question_religion = $row['question_religion'];
//	$question_religion_detail = $row['question_religion_detail'];
//	
//	$question_status = $row['question_status'];
//	$question_status_detail = $row['question_status_detail'];
//	
//	/*--------------------------------------------------------------------------------------- ลักษณะโครงสร้าง*/
//	$question_structure = $row['question_structure'];
//	$question_structure_detail = $row['question_structure_detail'];
//	if($question_structure==1)
//	{
//		//$data = json_decode($question_structure_detail);
//		$data = explode(',',$question_structure_detail);
//		$tMemberFamily_1 = $data[0];
//		$tMemberMale_1 = $data[1];
//		$tMemberFemale_1 = $data[2];
//		
//		$rLargeFamily = '';
//		$tMemberFamily_2_1 = '';
//		$tMemberMale_2_1 = '';
//		$tMemberFemale_2_1 = '';
//		
//		$tMemberFamily_2_2 = '';
//		$tMemberMale_2_2 = '';
//		$tMemberFemale_2_2 = '';
//		
//		$tSpecialFamily_3 = '';
//		$rSpecialFamily = '';
//	}
//	elseif($question_structure==2)
//	{
//		//$data = json_decode($question_structure_detail);
//		$data = explode(',',$question_structure_detail);
//		$tMemberFamily_1 = '';
//		$tMemberMale_1 = '';
//		$tMemberFemale_1 = '';
//		
//		$tSpecialFamily_3 = '';
//		$rSpecialFamily = '';
//		$rLargeFamily = $data[0];
//		if($rLargeFamily==1)
//		{
//			$tMemberFamily_2_1 = $data[1];
//			$tMemberMale_2_1 = $data[2];
//			$tMemberFemale_2_1 = $data[3];
//			$tMemberFamily_2_2 = '';
//			$tMemberMale_2_2 = '';
//			$tMemberFemale_2_2 = '';
//		}
//		else
//		{
//			$tMemberFamily_2_1 = '';
//			$tMemberMale_2_1 = '';
//			$tMemberFemale_2_1 = '';
//			
//			$tMemberFamily_2_2 = $data[1];
//			$tMemberMale_2_2 = $data[2];
//			$tMemberFemale_2_2 = $data[3];
//		}
//	}
//	else
//	{
//		$tMemberFamily_1 = '';
//		$tMemberMale_1 = '';
//		$tMemberFemale_1 = '';
//		
//		$rLargeFamily = '';
//		
//		$tMemberFamily_2_1 = '';
//		$tMemberMale_2_1 = '';
//		$tMemberFemale_2_1 = '';
//		
//		$tMemberFamily_2_2 = '';
//		$tMemberMale_2_2 = '';
//		$tMemberFemale_2_2 = '';
//		
//		//$data = json_decode($question_structure_detail);
//		$data = explode(',',$question_structure_detail);
//		if($data[0]==6)
//		{
//			$tSpecialFamily_3 = $data[1];
//			$rSpecialFamily = $data[0];
//		}
//		else
//		{
//			$tSpecialFamily_3 = '';
//			$rSpecialFamily = $data[0];
//		}
//	}
//	
//	/*--------------------------------------------------------------------------------------- จำนวนสมาชิก*/
//	$question_defective = $row['question_defective'];
//	$question_defective_detail = $row['question_defective_detail'];
//	if($question_defective==2)
//	{
//		$data = explode(',',$question_defective_detail);
//		$tDefective = $data[0];
//		$tChild = $data[1];
//		$tDisabled = $data[2];
//		$tMindSick = $data[3];
//		$tSick = $data[4];
//		$tElderly = $data[5];
//	}
//	else
//	{
//		$tDefective = '';
//		$tChild = '';
//		$tDisabled = '';
//		$tMindSick = '';
//		$tSick = '';
//		$tElderly = '';
//	}
//	
//	/*--------------------------------------------------------------------------------------- จำนวนผู้อาศัยแยกตามกลุ่ม*/
//	$question_residents_1 = $row['question_residents_1'];
//	$question_residents_2 = $row['question_residents_2'];
//	$question_residents_3 = $row['question_residents_3'];
//	$question_residents_4 = $row['question_residents_4'];
//	$question_residents_5 = $row['question_residents_5'];
//	
//	$question_residents_1t = $row['question_residents_1t'];
//	$question_residents_2t = $row['question_residents_2t'];
//	$question_residents_3t = $row['question_residents_3t'];
//	$question_residents_4t = $row['question_residents_4t'];
//	$question_residents_5t = $row['question_residents_5t'];
//	
//	$data = explode(',',$question_residents_1);
//	$tChildMale = $data[0];
//	$tChildFemale = $data[1];
//	$tChildTotal = $question_residents_1t;
//	
//	$data = explode(',',$question_residents_2);
//	$tTeensMale = $data[0];
//	$tTeensFemale = $data[1];
//	$tTeensTotal = $question_residents_2t;
//	
//	$data = explode(',',$question_residents_3);
//	$tMan = $data[0];
//	$tWoman = $data[1];
//	$tTotal = $question_residents_3t;
//	
//	$data = explode(',',$question_residents_4);
//	$tElderMale = $data[0];
//	$tElderFemale = $data[1];
//	$tElderTotal = $question_residents_4t;
//	
//	$data = explode(',',$question_residents_5);
//	$tDisabledMale = $data[0];
//	$tDisabledFemale = $data[1];
//	$tDisabledTotal = $question_residents_5t;
//	
//	$tMaleTotal = $tChildMale+$tTeensMale+$tMan+$tElderMale+$tDisabledMale; 
//	$tFemaleTotal = $tChildFemale+$tTeensFemale+$tWoman+$tElderFemale+$tDisabledFemale; 
//	$tSumTotal = $tMaleTotal+$tFemaleTotal ;
//	
//	/*--------------------------------------------------------------------------------------- ครอบครัวมีหนี้สิน*/
//	$question_debt = $row['question_debt'];
//	$question_debt_a = '';
//	$question_debt_detail = '';
//	$chk = array();
//	
//	$t21_money_1 = '';
//	$t21_interest_1 = '';
//	$t21_pay_1 = '';
//	$t21_balance_1 = '';
//	
//	$t21_money_2 = '';
//	$t21_interest_2 = '';
//	$t21_pay_2 = '';
//	$t21_balance_2 = '';
//	
//	$t21_money_3 = '';
//	$t21_interest_3 = '';
//	$t21_pay_3 = '';
//	$t21_balance_3 = '';
//	
//	$t21_money_4 = '';
//	$t21_interest_4 = '';
//	$t21_pay_4 = '';
//	$t21_balance_4 = '';
//	
//	$t21_money_5 = '';
//	$t21_interest_5 = '';
//	$t21_pay_5 = '';
//	$t21_balance_5 = '';
//	
//	$t21_money_6 = '';
//	$t21_interest_6 = '';
//	$t21_pay_6 = '';
//	$t21_balance_6 = '';
//	
//	$t21_money_7 = '';
//	$t21_interest_7 = '';
//	$t21_pay_7 = '';
//	$t21_balance_7 = '';
//	
//	$t21_money_8 = '';
//	$t21_interest_8 = '';
//	$t21_pay_8 = '';
//	$t21_balance_8 = '';
//	
//	$t21_other = '';
//	$t21_money_9 = '';
//	$t21_interest_9 = '';
//	$t21_pay_9 = '';
//	$t21_balance_9 = '';
//	
//	$tName18_2_1 = '';
//    $tMoney18_2_1 = '';
//    $tInterest18_2_1 ='' ;
//    $tPay18_2_1 ='';
//    $tBalance18_2_1 = '';
//	
//	$tName18_2_2 = '';
//    $tMoney18_2_2 = '';
//    $tInterest18_2_2 ='' ;
//    $tPay18_2_2 ='';
//    $tBalance18_2_2 = '';
//	
//	$tName18_2_3 = '';
//    $tMoney18_2_3 = '';
//    $tInterest18_2_3 ='' ;
//    $tPay18_2_3 ='';
//    $tBalance18_2_3 = '';
//	
//	$tName18_2_4 = '';
//    $tMoney18_2_4 = '';
//    $tInterest18_2_4 ='' ;
//    $tPay18_2_4 ='';
//    $tBalance18_2_4 = '';
//	
//	$tName18_2_5 = '';
//    $tMoney18_2_5 = '';
//    $tInterest18_2_5 ='' ;
//    $tPay18_2_5 ='';
//    $tBalance18_2_5 = '';
//	
//	$tName18_2_6 = '';
//    $tMoney18_2_6 = '';
//    $tInterest18_2_6 ='' ;
//    $tPay18_2_6 ='';
//    $tBalance18_2_6 = '';
//	
//	if($question_debt==2)
//	{
//		$question_debt_a = $row['question_debt_sub'];
//		$question_debt_detail = $row['question_debt_detail'];
//		if($question_debt_a==1)
//		{
//			$data = explode(',',$question_debt_detail);
//			for($i=0;$i<(count($data));$i++)
//			{
//				$txt = explode(':',$data[$i]);
//				$chk[$i] = $txt[0];
//				$arraytext[$i] = $txt[1];
//				$text = explode('|',$arraytext[$i]);
//				
//				switch ($chk[$i]) {
//				case 1:
//							$t21_money_1 = $text[0];
//							$t21_interest_1 = $text[1];
//							$t21_pay_1 = $text[2];
//							$t21_balance_1 = $text[3];
//				break;
//				
//				case 2:
//							$t21_money_2 = $text[0];
//							$t21_interest_2 = $text[1];
//							$t21_pay_2 = $text[2];
//							$t21_balance_2 = $text[3];
//				break;
//				
//				case 3:
//							$t21_money_3 = $text[0];
//							$t21_interest_3 = $text[1];
//							$t21_pay_3 = $text[2];
//							$t21_balance_3 = $text[3];
//				break;
//				
//				case 4:
//							$t21_money_4 = $text[0];
//							$t21_interest_4 = $text[1];
//							$t21_pay_4 = $text[2];
//							$t21_balance_4 = $text[3];
//				break;
//				
//				case 5:
//							$t21_money_5 = $text[0];
//							$t21_interest_5 = $text[1];
//							$t21_pay_5 = $text[2];
//							$t21_balance_5 = $text[3];
//				break;
//				
//				case 6:
//							$t21_money_6 = $text[0];
//							$t21_interest_6 = $text[1];
//							$t21_pay_6 = $text[2];
//							$t21_balance_6 = $text[3];
//				break;
//				
//				case 7:
//							$t21_money_7 = $text[0];
//							$t21_interest_7 = $text[1];
//							$t21_pay_7 = $text[2];
//							$t21_balance_7 = $text[3];
//				break;
//				
//				case 8:
//							$t21_money_8 = $text[0];
//							$t21_interest_8 = $text[1];
//							$t21_pay_8 = $text[2];
//							$t21_balance_8 = $text[3];
//				break;
//				case 9:
//							$t21_other = $text[0];
//							$t21_money_9 = $text[1];
//							$t21_interest_9 = $text[2];
//							$t21_pay_9 = $text[3];
//							$t21_balance_9 = $text[4];
//				break;
//			}
//			}
//		}
//		else
//		{
//			$txt = explode(',',$question_debt_detail);
//			$tName18_2_1 = $txt[0];
//			$tMoney18_2_1 = $txt[1];
//			$tInterest18_2_1 = $txt[2];
//			$tPay18_2_1 = $txt[3];
//			$tBalance18_2_1 = $txt[4];
//			
//			$tName18_2_2 = $txt[5];
//			$tMoney18_2_2 = $txt[6];
//			$tInterest18_2_2 = $txt[7];
//			$tPay18_2_2 = $txt[8];
//			$tBalance18_2_2 = $txt[9];
//			
//			$tName18_2_3 = $txt[10];
//			$tMoney18_2_3 = $txt[11];
//			$tInterest18_2_3 = $txt[12];
//			$tPay18_2_3 = $txt[13];
//			$tBalance18_2_3 = $txt[14];
//			
//			$tName18_2_4 = $txt[15];
//			$tMoney18_2_4 = $txt[16];
//			$tInterest18_2_4 = $txt[17];
//			$tPay18_2_4 = $txt[18];
//			$tBalance18_2_4 = $txt[19];
//			
//			$tName18_2_5 = $txt[20];
//			$tMoney18_2_5 = $txt[21];
//			$tInterest18_2_5 = $txt[22];
//			$tPay18_2_5 = $txt[23];
//			$tBalance18_2_5 = $txt[24];
//			
//			$tName18_2_6 = $txt[25];
//			$tMoney18_2_6 = $txt[26];
//			$tInterest18_2_6 = $txt[27];
//			$tPay18_2_6 = $txt[28];
//			$tBalance18_2_6 =  $txt[29];
//		}
//	}
//	else
//	{
//		$question_debt_a = '';
//		$question_debt_detail = '';
//	}
//	
//	$question_img = $row['question_img'];
//	$question_date = $row['question_date'];
//	$question_round = $row['question_round'];
//	$question_prename = $row['question_prename'];
?>