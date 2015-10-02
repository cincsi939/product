<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Tanachai Khampukhew (tanachai@sapphire.co.th)
 * @created  10/09/2014
 * @access  public
 */
 ?>
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
<script language="JavaScript">
function CreateXmlHttp(){
		//Creating object of XMLHTTP in IE
		try {
			XmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e){
			try{
				XmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			} 
			catch(oc) {
				XmlHttp = null;
			}
		}
		//Creating object of XMLHTTP in Mozilla and Safari 
		if(!XmlHttp && typeof XMLHttpRequest != "undefined") {
			XmlHttp = new XMLHttpRequest();
		}
	} // end function CreateXmlHttp
function chgAmphur(e, defa_v, tambon) {
		if ( e ) {
			document.getElementById('tParish').disabled = true;
			CreateXmlHttp();
			XmlHttp.open("get", "main/ajax.chgamphur.php?PvID="+e+"&DfVal="+defa_v, true);
			XmlHttp.onreadystatechange=function() {//alert("Aussy!!");
				if (XmlHttp.readyState==4) {
					
					if (XmlHttp.status==200) {
						var res = XmlHttp.responseText; //alert(res);
						document.getElementById("lblAmphur").innerHTML = res;
						chgTambon(defa_v, tambon);
					} else if (XmlHttp.status==404) {
						alert("�������ö�ӡ�ô֧��������");
					} else {
						alert("Error : "+XmlHttp.status);
					}
				}
			};
			XmlHttp.send(null);
			//chgTambon(e,'');
		}
	}
	
function chgTambon(e, defa_v) {
		if ( e ) {
			CreateXmlHttp();
			XmlHttp.open("get", "main/ajax.chgtambon.php?TbID="+e+"&DfVal="+defa_v, true);
			XmlHttp.onreadystatechange=function() {
				if (XmlHttp.readyState==4) {
					if (XmlHttp.status==200) {
						var res = XmlHttp.responseText; //alert(res);
						document.getElementById("lblTambon").innerHTML = res;
					} else if (XmlHttp.status==404) {
						alert("�������ö�ӡ�ô֧��������");
					} else {
						alert("Error : "+XmlHttp.status);
					}
				}
			};
			XmlHttp.send(null);
		}
}

function chgPreName(e) {
	if ( e ) {
			CreateXmlHttp();
			XmlHttp.open("get", "main/ajax.chkprename.php?pre="+e, true);
			XmlHttp.onreadystatechange=function() {
				if (XmlHttp.readyState==4) {
					if (XmlHttp.status==200) {
						var res = XmlHttp.responseText; //alert(res);
						document.getElementById("lblPreName").innerHTML = res;
					} else if (XmlHttp.status==404) {
						alert("�������ö�ӡ�ô֧��������");
					} else {
						alert("Error : "+XmlHttp.status);
					}
				}
			};
			XmlHttp.send(null);
		}
}

</script>
<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('lib/nusoap.php'); 
	require_once("lib/class.function.php");
	$con = new Cfunction();
	$sql = 'SELECT question_id,question_date,question_firstname,question_lastname,question_idcard,question_idcard_detail,question_address,question_village,';
	$sql .= 'question_street,question_parish,question_district,question_province,question_phone,question_sex,question_sex_detail,question_birthday,question_age,';
	$sql .= 'question_typehome,question_typehome_detail,question_stypehome_1,question_stypehome_2,question_stypehome_3,question_environment,question_education,';
	$sql .= 'question_career,question_career_detail,question_land,question_land_detail,question_Income,question_religion,question_religion_detail,question_status,question_status_detail,';
	$sql .= 'question_structure,question_structure_detail,question_defective,question_defective_detail,question_debt,question_debt_sub,question_debt_detail,question_img,';
	$sql .= 'question_residents_1,question_residents_2,question_residents_3,question_residents_4,question_residents_5,';
	$sql .= 'question_residents_1t,question_residents_2t,question_residents_3t,question_residents_4t,question_residents_5t,question_residents_tt,question_round,question_prename';
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
	
	/*--------------------------------------------------------------------------------------- �Ҫվ��ѡ*/
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
	
	/*--------------------------------------------------------------------------------------- �ѡɳ��ç���ҧ*/
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
	
	/*--------------------------------------------------------------------------------------- �ӹǹ��Ҫԡ*/
	$question_defective = $row['question_defective'];
	$question_defective_detail = $row['question_defective_detail'];
	if($question_defective==2)
	{
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
	
	/*--------------------------------------------------------------------------------------- �ӹǹ���������¡��������*/
	$question_residents_1 = $row['question_residents_1'];
	$question_residents_2 = $row['question_residents_2'];
	$question_residents_3 = $row['question_residents_3'];
	$question_residents_4 = $row['question_residents_4'];
	$question_residents_5 = $row['question_residents_5'];
	
	$question_residents_1t = $row['question_residents_1t'];
	$question_residents_2t = $row['question_residents_2t'];
	$question_residents_3t = $row['question_residents_3t'];
	$question_residents_4t = $row['question_residents_4t'];
	$question_residents_5t = $row['question_residents_5t'];
	
	$data = explode(',',$question_residents_1);
	$tChildMale = $data[0];
	$tChildFemale = $data[1];
	$tChildTotal = $question_residents_1t;
	
	$data = explode(',',$question_residents_2);
	$tTeensMale = $data[0];
	$tTeensFemale = $data[1];
	$tTeensTotal = $question_residents_2t;
	
	$data = explode(',',$question_residents_3);
	$tMan = $data[0];
	$tWoman = $data[1];
	$tTotal = $question_residents_3t;
	
	$data = explode(',',$question_residents_4);
	$tElderMale = $data[0];
	$tElderFemale = $data[1];
	$tElderTotal = $question_residents_4t;
	
	$data = explode(',',$question_residents_5);
	$tDisabledMale = $data[0];
	$tDisabledFemale = $data[1];
	$tDisabledTotal = $question_residents_5t;
	
	$tMaleTotal = $tChildMale+$tTeensMale+$tMan+$tElderMale+$tDisabledMale; 
	$tFemaleTotal = $tChildFemale+$tTeensFemale+$tWoman+$tElderFemale+$tDisabledFemale; 
	$tSumTotal = $tMaleTotal+$tFemaleTotal ;
	
	/*--------------------------------------------------------------------------------------- ��ͺ������˹���Թ*/
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
	$question_date = $row['question_date'];
	$question_round = $row['question_round'];
	$question_prename = $row['question_prename'];
	$ws_client = $con->configIPSoap();
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
<style>
.style1{
	color:#F00;
}
</style>
<form action="main_exc/form1_edit_exc.php" method="post" enctype="multipart/form-data" id="form1" name="form1" onSubmit="JavaScript:return fncSubmit();">
  <table width="850" border="0">
    <tbody>
      <tr>
        <td colspan="4" align="right">���������Ǩ �ͺ���
          <INPUT name="round" type="text" id="round" value="<?php echo $question_round; ?>" size="1" readonly="readonly" style="background:#CCC;"  />
        � �ѹ���<?php echo $con->_calendarTH('sDay','sMonth','sYear',$question_date); ?>          <input type="hidden" name="question_id" value="<?php echo $row['question_id']; ?>"></td>
      </tr>
      <tr>
        <td colspan="3" align="left"><b><u>��ǹ��� 1</u></b> <b>��������´�����Ţͧ�������͹</b></td>
        <td width="246">&nbsp;</td>
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
          �Ţ�ѵû�Шӵ�ǻ�ЪҪ�
          <INPUT name="tIDCard" type="text" id="tIDCard" value="<?php echo $question_idcard_detail; ?>" size="30"   /></td>
      </tr>
      <tr>
        <td height="25" align="right">2.</td>
        <td height="25" colspan="2"><table width="100%" border="0" cellspacing="1" cellpadding="1">
          <tr>
            <td width="22%">�������˹�Ҥ�ͺ����&nbsp;<span class="style1">*</span></td>
            <td width="18%">
            
            <select id="tPrename" name="tPrename" style="width:90%" onChange="chgPreName(this.value)"  >
            <?php
				$sql_Prename = 'SELECT id,prename_th,gender FROM `tbl_prename` ORDER BY priority asc;';
				$results_Prename = $con->select($sql_Prename);
				foreach($results_Prename as $rd){
						if($question_prename==$rd['id'])
						{
							echo '<option selected  value="'.$rd['id'].'">'.$rd['prename_th'].'</option>';
						}
						else
						{
							echo '<option  value="'.$rd['id'].'">'.$rd['prename_th'].'</option>';
						}
				}
			 ?>
		</select>
            
            </td>
            <td width="25%"><input name="tFirstname" type="text" value="<?php echo $tFirstname; ?>" id="tFirstname" size="23"  /></td>
            <td width="11%" align="center">���ʡ��</td>
            <td width="24%"><input type="text" value="<?php echo $tLastname; ?>"  name="tLastname" id="tLastname" size="23"/></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="25" align="right">3. </td>
        <td height="25" colspan="2">������������</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td height="25" colspan="2" valign="middle"><table width="453" border="0" cellpadding="1" cellspacing="1">
          <tr>
            <td width="61" align="left">��ҹ�Ţ���</td>
            <td width="152"><INPUT type="text" value="<?php echo $question_address; ?>" name="tAddress" style="width:95%" /></td>
            <td width="76" align="left">&nbsp;</td>
            <td width="152">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">������ </td>
            <td><INPUT type="text" value="<?php echo $question_village; ?>"  name="tVillage" style="width:95%" /></td>
            <td align="left">��� </td>
            <td><input type="text" value="<?php echo $question_street; ?>" name="tStreet" style="width:95%" /></td>
          </tr>
          <tr>
            <td align="left">�ѧ��Ѵ <span class="style1">*</span></td>
            <td><select id="tProvince" name="tProvince" onChange = "chgAmphur(this.value);" style="width:98%" >
              <?php
				$sql_Changwat = 'Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = \'Changwat\' ';
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					if($rd['ccDigi']==$question_province)
					{
						echo '<option selected  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
					else
					{
						echo '<option  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
				}
			 ?>
              </select>
              
            </td>
            <td align="left">����� <span class="style1">*</span></td>
            <td><LABEL id="lblAmphur">
              <select id="tDistrict" name="tDistrict"  style="width:98%">
                <?php
				$sql_Changwat = "Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = 'Aumpur' AND areaid like '".substr($question_province,0,2)."%' AND ccName NOT LIKE '%*%'";
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					if($rd['ccDigi']==$question_district)
					{
						echo '<option selected  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
					else
					{
						echo '<option  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
				}
			 ?>
                </select>
              </LABEL>
              
            </td>
          </tr>
          <tr>
            <td align="left">�Ӻ� <span class="style1">*</span></td>
            <td><LABEL id="lblTambon">
              <select id="tParish" name="tParish" style="width:98%">
                <?php
				$sql_Changwat = "Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = 'Tamboon' AND areaid like '".substr($question_province,0,2)."%' AND ccName NOT LIKE '%*%'";
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					if($rd['ccDigi']==$question_parish)
					{
						echo '<option selected  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
					else
					{
						echo '<option  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
				}
			 ?>
                </select>
              </LABEL>
            </td>
            <td align="left">���Ѿ��</td>
            <td><input type="text" value="<?php echo $question_phone; ?>"  name="tPhone" style="width:95%"/></td>
          </tr>
        </table></td>
      </tr>
      <tr class="Sexcheck">
        <td height="25" align="right">4. </td>
        <td height="25" colspan="2">��
          <span class="style1">*</span>
          <LABEL id="lblPreName">
          <input type="radio"  value="1"  class="rSex" name="rSex"id="female" <?php if($question_sex==1){echo 'checked';} ?>  />
          1. ˭ԧ&nbsp;
          <input type="radio"  value="2" class="rSex" name="rSex" id="male"<?php if($question_sex==2){echo 'checked';} ?>  />
          2. ���
          	<input type="hidden"  value="" id="etc_1" name=""   />
        	<INPUT name="tSex" type="hidden" id="tSex" value="" size="30" />
        	<INPUT name="chkSex" type="hidden" id="tSex" value="1" size="30" />
          </LABEL>
          </td>
      </tr>
      <tr>
        <td height="25" align="right">5. </td>
        <td height="25" colspan="2">�ѹ�Դ <span class="style1">*</span> <?php echo $result; ?> ����
          <INPUT name="tAge" type="text" id="tAge" value="<?php echo $question_age; ?>" size="4" maxlength="4" class="numberOnly" />
          ��</td>
      </tr>
      <tr>
        <td height="25" align="right">6. </td>
        <td height="25" colspan="2">�������ͧ������������㹻Ѩ�غѹ
          
          &nbsp;</td>
        <td height="25">&nbsp;</td>
      </tr>
      <tr class="Typehome">
        <td height="25" align="right">&nbsp;</td>
        <td height="25"><input name="rTypeHome" class="rTypeHome" type="radio"  value="1"  id="m2" <?php if($question_typehome==1){echo 'checked';} ?> />
          1. ��ҹ����ͧ</td>
        <td height="25" colspan="2"><input name="rTypeHome" type="radio"  value="2" id="rTypeHome_2" class="rTypeHome" <?php if($question_typehome==2){echo 'checked';} ?>/>
          2. ��ҹ��� ���¤�����
          <INPUT name="tTypeHome_2" type="text" id="tTypeHome_2" value="<?php echo $detail_2; ?>" size="10" class="numberOnly" />
          �ҷ/��͹/��</td>
      </tr>
      <tr class="Typehome">
        <td height="25" align="right">&nbsp;</td>
        <td height="25"><input name="rTypeHome" type="radio"  value="3" id="f3" class="rTypeHome" <?php if($question_typehome==3){echo 'checked';} ?> />
          3. ��ҹ�ҵ� </td>
        <td height="25" colspan="2"><input name="rTypeHome" type="radio"  value="4" id="rTypeHome_4"   class="rTypeHome" <?php if($question_typehome==4){echo 'checked';} ?>/>
          4. ��� � �к�
          <INPUT name="tTypeHome_4" type="text" id="tTypeHome_4" value="<?php echo $detail_4; ?>" style="width:80%" /></td>
      </tr>
      <tr>
        <td height="25" align="right">7.</td>
        <td height="25" colspan="2">�ѡɳз������</td>
        <td height="25">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td height="25" colspan="2">7.1 �ѡɳТͧ��ҹ</td>
        <td height="25">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3" align="right"><textarea name="tstypehome_1" id="textarea" style="width:100%" rows="8"><?php echo $question_stypehome_1; ?></textarea></td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td colspan="2">7.2 ��Ҿ��ҹ</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><textarea name="tstypehome_2" id="taHomeStyle" style="width:100%" rows="8"><?php echo $question_stypehome_2; ?></textarea></td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td colspan="2">7.3 ��ͧ�آ�</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><textarea name="tstypehome_3" id="taHomeStyle2" style="width:100%" rows="8"><?php echo $question_stypehome_3; ?></textarea></td>
      </tr>
      <tr>
        <td height="25" align="right">8.</td>
        <td  colspan="2">��Ҿ�Ǵ����</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><textarea name="tEnvironment" id="tEnvironment" style="width:100%" rows="8"><?php echo $question_environment; ?></textarea></td>
      </tr>
      <tr>
        <td height="25" align="right">9.</td>
        <td  colspan="2">����֡��</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="1"  id="rEducation"    name="rEducation" <?php if($question_education==1){echo 'checked';} ?>/>
          ������֡��</td>
        <td width="282" ><input type="radio"  value="2"  id="rEducation"    name="rEducation" <?php if($question_education==2){echo 'checked';} ?>/>
          ��ӡ��һ�ж��֡��</td>
        <td ><input type="radio"  value="3"  id="rEducation"    name="rEducation" <?php if($question_education==3){echo 'checked';} ?>/>
          ��ж��֡��</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="4"  id="rEducation"    name="rEducation" <?php if($question_education==4){echo 'checked';} ?>/>
          �Ѹ���֡�ҵ͹��</td>
        <td ><input type="radio"  value="5"  id="rEducation"    name="rEducation" <?php if($question_education==5){echo 'checked';} ?>/>
          �Ѹ���֡�ҵ͹����</td>
        <td ><input type="radio"  value="6"  id="rEducation2"    name="rEducation" <?php if($question_education==6){echo 'checked';} ?>/>
          �Ѹ���֡�ҵ͹����/�Ǫ</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="7"  id="rEducation"    name="rEducation" <?php if($question_education==7){echo 'checked';} ?>/>
          ͹ػ�ԭ��/���</td>
        <td ><input type="radio"  value="8"  id="rEducation"    name="rEducation" <?php if($question_education==8){echo 'checked';} ?>/>
          ��ԭ�ҵ��</td>
        <td ><input type="radio"  value="9"  id="rEducation3"    name="rEducation" <?php if($question_education==9){echo 'checked';} ?>/>
          �٧���һ�ԭ�ҵ��</td>
      </tr>
      <tr>
        <td height="25" align="right">10. </td>
        <td  colspan="2">�Ҫվ��ѡ�ͧ���˹�Ҥ�ͺ���� <strong>(�ͺ���ҡ��� 1 ���) <span class="style1">*</span></strong></td>
        <td >&nbsp;</td>
      </tr>
      <!--<div class="careertable">-->
      <tr class="careertable">
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="checkbox"  value="1"  id="cCareer1"    name="cCareer[]" <?php if(in_array(1,$question_career)){echo 'checked';} ?>/>
          1. �Ѻ��ҧ�����</td>
        <td ><input type="checkbox"  value="2"  id="cCareer2"    name="cCareer[]" <?php if(in_array(2,$question_career)){echo 'checked';} ?>/>
          2. �ɵá� </td>
        <td >&nbsp;</td>
      </tr>
      <tr class="careertable">
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="checkbox"  value="3"  id="cCareer3"    name="cCareer[]" <?php if(in_array(3,$question_career)){echo 'checked';} ?>/>
          3. �����</td>
        <td ><input type="checkbox"  value="4"  id="cCareer4"    name="cCareer[]" <?php if(in_array(4,$question_career)){echo 'checked';} ?>/>
          4. ����Ҫ���/�١��ҧ���;�ѡ�ҹ�ͧ�Ѱ</td>
        <td >&nbsp;</td>
      </tr>
      <tr class="careertable">
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="checkbox"  value="5"  id="cCareer5"    name="cCareer[]" <?php if(in_array(5,$question_career)){echo 'checked';} ?>/>
          5. ��ѡ�ҹ�Ѱ����ˡԨ</td>
        <td ><input type="checkbox"  value="6"  id="cCareer6"    name="cCareer[]" <?php if(in_array(6,$question_career)){echo 'checked';} ?>/>
          6. ���˹�ҷ��ͧ��û���ͧ��ͧ��� </td>
        <td >&nbsp;</td>
      </tr>
      <tr class="careertable">
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="checkbox"  value="7"  id="cCareer7"    name="cCareer[]" <?php if(in_array(7,$question_career)){echo 'checked';} ?>/>
          7. ��Ң��/��áԨ��ǹ���</td>
        <td ><input type="checkbox"  value="8"  id="cCareer8"    name="cCareer[]" <?php if(in_array(8,$question_career)){echo 'checked';} ?>/>
          8. ��ѡ�ҹ/�١��ҧ�͡��</td>
        <td >&nbsp;</td>
      </tr>
      <tr class="careertable">
        <td height="25" align="right">&nbsp;</td>
        <td width="280" ><input type="checkbox"  value="9"  id="cCareer9"    name="cCareer[]" <?php if(in_array(9,$question_career)){echo 'checked';} ?>/>
          9. ��ҧ�ҹ/����էҹ��</td>
        <td  colspan="2"><input type="checkbox"  value="10"  id="cCareer10"    name="cCareer[]" <?php if(in_array(10,$question_career)){echo 'checked';} ?>/>
          10. ��� � �к�
          <input  name="tCareer" type="text" value="<?php echo $question_career_detail; ?>" style="width:80%" id="tCareer"  /></td>
      </tr>
      <!--</div>-->
      <tr>
        <td height="25" align="right">11.</td>
        <td  colspan="2">��ͺ�����շ��Թ�ӡԹ </td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="1"  id="rLand"    name="rLand" <?php if($question_land==1){echo 'checked';} ?>/>
          �� �ӹǹ
          <input name="tLand" type="text" id="tLand" size="10" value="<?php echo $question_land_detail; ?>" class="numberOnly" />
          ���</td>
        <td ><input type="radio"  value="2"  id="Land_2"    name="rLand" class="rLand_1" <?php if($question_land==2){echo 'checked';} ?>/>
          �����</td>
        <td >&nbsp;</td>
      </tr>
      <tr class="careertable">
        <td height="25" align="right">12. </td>
        <td  colspan="3">���������¢ͧ��ͺ���� �ӹǹ
          <input name="tIncome" type="text" value="<?php echo $question_Income; ?>" size="10" id="tIncome" class="numberOnly" />
          �ҷ (��ͻ�)<strong> (�����Դ�ҡ��Ҫԡ���������������ѹ) <span class="style1">*</span></strong></td>
      </tr>
      <tr>
        <td height="25" align="right">13. </td>
        <td  colspan="2">��ʹ���ѡ�ͧ��ͺ����</td>
        <td >&nbsp;</td>
      </tr>
      <tr class="tablereligion">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><input type="radio"  value="1"  id="rEducation" name="rReligion" class="rReligion" <?php if($question_religion==1){echo 'checked';} ?>/>
          1. �ط�
          &nbsp;
          <input type="radio"  value="2" id="rEducation" name="rReligion"  class="rReligion" <?php if($question_religion==2){echo 'checked';} ?>/>
          2. ���ʵ�
          <input type="radio"  value="3"  id="rEducation" name="rReligion"   class="rReligion" <?php if($question_religion==3){echo 'checked';} ?>/>
          3. ������
          &nbsp;
          <input type="radio"  value="4" id="rReligion_4" name="rReligion"  class="rReligion_1" <?php if($question_religion==4){echo 'checked';} ?>/>
          4. ��� � �к�
          <input name="tReligion" type="text" value="<?php echo $question_religion_detail; ?>" style="width:60%" id="tReligion_1" /></td>
      </tr>
      <tr>
        <td height="25" align="right">14.</td>
        <td  colspan="2">��ҹ�Ҿ���ʢͧ��ҹ㹻Ѩ�غѹ�����ҧ��</td>
        <td >&nbsp;</td>
      </tr>
      <tr class="statustable">
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="1"  class="rStatus" name="rStatus" <?php if($question_status==1){echo 'checked';} ?> />
          1. �ʴ</td>
        <td  colspan="2"><input type="radio"  value="2" class="rStatus" name="rStatus" <?php if($question_status==2){echo 'checked';} ?> />
          2. ���� </td>
      </tr>
      <tr class="statustable">
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="3"  class="rStatus"  name="rStatus" <?php if($question_status==3){echo 'checked';} ?>/>
          3. ������ҧ</td>
        <td  colspan="2"><input type="radio"  value="4" class="rStatus" name="rStatus" <?php if($question_status==4){echo 'checked';} ?>/>
          4. ��������ͧ�ҡ����������ª��Ե</td>
      </tr>
      <tr class="statustable">
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="5"  id="rStatus_5" name="rStatus" <?php if($question_status==5){echo 'checked';} ?> />
          5. �¡�ѹ���� �ô�к�</td>
        <td  colspan="2">&nbsp;</td>
      </tr>
      <tr class="rStatus_detail">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><dd>
          <input type="radio"  value="1" class="rStatus_5_detail" name="rStatus_5" <?php if($question_status_detail==1){echo 'checked';} ?> />
          �¡�ѹ������Ǥ��ǵ����͵�ŧ�����͵�ŧ�����ҧ�������</dd></td>
      </tr>
      <tr class="rStatus_detail">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><dd>
          <input type="radio"  value="2" class="rStatus_5_detail" name="rStatus_5" <?php if($question_status_detail==2){echo 'checked';} ?>/>
          �¡�ѹ������Ǥ��ǵ����������</dd></td>
      </tr>
      <tr>
        <td height="25" align="right">15.</td>
        <td  colspan="2">�ѡɳ��ç���ҧ��ͺ����</td>
        <td >&nbsp;</td>
      </tr>
      <tr class="stuctable" id="t15_detail_1">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><input type="radio"  value="1" id="rStructureFamily"  name="rStructureFamily" class="rStructureFamily" <?php if($question_structure==1){echo 'checked';} ?>/>
          1. ��ͺ�������� �ӹǹ��Ҫԡ
          <input type="text" value="<?php echo $tMemberFamily_1; ?>" size="4" maxlength="4" name="tMemberFamily_1" style="background:#EBEBE4" id="tMemberFamily_1" readonly/>
          �� ���
          <input type="text" value="<?php echo $tMemberMale_1; ?>" size="4" maxlength="4" name="tMemberMale_1" id="tMemberMale_1" class="numberOnly"/>
          �� ˭ԧ
          <input type="text" value="<?php echo $tMemberFemale_1; ?>" size="4" maxlength="4" name="tMemberFemale_1" id="tMemberFemale_1" class="numberOnly"/>
          &nbsp;�� <strong>*��ͺ���Ƿ���Сͺ���¾�� ��� ����١����ѧ������觧ҹ</strong></td>
      </tr>
      <tr class="stuctable">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="2"><input type="radio"  value="2" id="rLargeFamily" name="rStructureFamily" class="rLargeFamily" <?php if($question_structure==2){echo 'checked';} ?>/>
          2. ��ͺ���Ǣ��� �ô�к�</td>
        <td >&nbsp;</td>
      </tr>
      <tr class="r15_2">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><dd>
          <input type="radio"  value="1" id="rLargeFamily_21" name="rLargeFamily" class="rLargeFamily_23" <?php if($rLargeFamily==1){echo 'checked';} ?> />
          2.1 ��ͺ���Ǣ��·���Сͺ�������� � �������͹���������ѹ ���Ф������͹ <u>�դ�������ѹ���͡ѹ</u></dd></td>
      </tr>
      <tr class="r15_2" id="t15_detail_2_1">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><dd> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�ӹǹ��Ҫԡ
          <input type="text" value="<?php echo $tMemberFamily_2_1; ?>" size="4" maxlength="4" name="tMemberFamily_2_1" style="background:#EBEBE4" id="tMemberFamily_2_1"  readonly/>
          �� ���
          <input type="text" value="<?php echo $tMemberMale_2_1; ?>" size="4" maxlength="4" name="tMemberMale_2_1" id="tMemberMale_2_1" class="numberOnly" />
          �� ˭ԧ
          <input type="text" value="<?php echo $tMemberFemale_2_1; ?>" size="4" maxlength="4" name="tMemberFemale_2_1" id="tMemberFemale_2_1" class="numberOnly" />
          &nbsp;�� </dd></td>
      </tr>
      <tr class="r15_2">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><dd>
          <input type="radio"  value="2" id="rLargeFamily_22" name="rLargeFamily" class="rLargeFamily_24" <?php if($rLargeFamily==2){echo 'checked';} ?> />
          2.2 ��ͺ���Ǣ��·���Сͺ�������� � �������͹���������ѹ ���Ф������͹ <u>�դ�������е�͡ѹ</u>㹡�ô��Թ���Ե��ͺ���Ǣͧ���ͧ </dd></td>
      </tr>
      <tr class="r15_2" id="t15_detail_2_2">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3" valign="top"><dd> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�ӹǹ��Ҫԡ
          <input type="text" value="<?php echo $tMemberFamily_2_2; ?>" size="4" maxlength="4"  name="tMemberFamily_2_2" style="background:#EBEBE4" id="tMemberFamily_2_2" readonly />
          �� ���
          <input type="text" value="<?php echo $tMemberMale_2_2; ?>" size="4" maxlength="4" name="tMemberMale_2_2" id="tMemberMale_2_2" class="numberOnly" />
          �� ˭ԧ
          <input type="text" value="<?php echo $tMemberFemale_2_2; ?>" size="4" maxlength="4"  name="tMemberFemale_2_2" id="tMemberFemale_2_2" class="numberOnly"/>
          &nbsp;�� </dd></td>
      </tr>
      <tr class="stuctable">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="2"><input type="radio"  value="3" id="rSpecialFamily"  name="rStructureFamily" class="rSpecialFamily" <?php if($question_structure==3){echo 'checked';} ?>/>
          3. ��ͺ�����ѡɳо���� �ô�к�</td>
        <td >&nbsp;</td>
      </tr>
      <tr class="r15_3">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="2"><dd>
          <input type="radio"  value="1" id="rSpecialFamily_1" name="rSpecialFamily" class="rSpecialFamily_1" <?php if($rSpecialFamily==1){echo 'checked';} ?> />
          3.1 ��ͺ���Ƿ������պص�</dd></td>
        <td >&nbsp;</td>
      </tr>
      <tr class="r15_3">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="2"><dd>
          <input type="radio"  value="2" id="rSpecialFamily_2" name="rSpecialFamily" class="rSpecialFamily_2" <?php if($rSpecialFamily==2){echo 'checked';} ?>/>
          3.2 ��ͺ���Ǿ�������������§�����</dd></td>
        <td >&nbsp;</td>
      </tr>
      <tr class="r15_3">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="2"><dd>
          <input type="radio"  value="3" id="rSpecialFamily_3"  name="rSpecialFamily" class="rSpecialFamily_3" <?php if($rSpecialFamily==3){echo 'checked';} ?>/>
          3.3 ��ͺ���Ǻصúح����</dd></td>
        <td >&nbsp;</td>
      </tr>
      <tr class="r15_3">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="2"><dd>
          <input type="radio"  value="4" id="rSpecialFamily_4"  name="rSpecialFamily" class="rSpecialFamily_4" <?php if($rSpecialFamily==4){echo 'checked';} ?> />
          3.4 ��ͺ�����ȷҧ���͡</dd></td>
        <td >&nbsp;</td>
      </tr>
      <tr class="r15_3">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="2"><dd>
          <input type="radio"  value="5" id="rSpecialFamily_5"  name="rSpecialFamily" class="rSpecialFamily_5" <?php if($rSpecialFamily==5){echo 'checked';} ?>/>
          3.5 ��ͺ�����ػ�����</dd></td>
        <td >&nbsp;</td>
      </tr>
      <tr class="r15_3">
        <td height="25" align="right">&nbsp;</td>
        <td  colspan="3"><dd>
          <input type="radio"  value="6" id="rSpecialFamily_6"  name="rSpecialFamily" class="rSpecialFamily_6" <?php if($rSpecialFamily==6){echo 'checked';} ?>/>
          3.6 ��� � �к�
          <input name="tSpecialFamily_3" type="text" value="<?php echo $tSpecialFamily_3;  ?>" style="width:85%" id="tSpecialFamily_3"  />
        </dd></td>
      </tr>
      <tr>
        <td height="25" align="right">16. </td>
        <td  colspan="2">�ӹǹ��Ҫԡ㹤�ͺ���Ƿ�������о�觾ԧ�٧ (�������ö��������͵��ͧ��)</td>
        <td >&nbsp;</td>
      </tr>
      <tr class="defective">
        <td height="25" align="right">&nbsp;</td>
        <td width="280" ><input type="radio" <?php if($question_defective==1){echo 'checked';} ?>  value="1"  id="rDefective_1" name="rDefective"  />
          1. �����</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr class="defective">
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="2"  id="rDefective_2"  name="rDefective" <?php if($question_defective==2){echo 'checked';} ?>/>
          2. �ӹǹ
          <input type="text" value="<?php echo $tDefective;  ?>" size="4" maxlength="4" style="background:#EBEBE4" name="tDefective" id="tDefective" readonly/>
          �� �ô�к� </td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr id="t16_detail">
        <td height="25" align="right">&nbsp;</td>
        <td colspan="3"><dd>
          <table>
            <tr>
              <td>�ӹǹ����� (0-4��)</td>
              <td><input type="text" value="<?php echo $tChild;  ?>" size="4" maxlength="4" name="tChild" id="tChild" class="numberOnly" />
                ��</td>
            </tr>
            <tr>
              <td>�ӹǹ���ԡ��</td>
              <td><input type="text" value="<?php echo $tDisabled;  ?>" size="4" maxlength="4"  name="tDisabled" id="tDisabled" class="numberOnly" />
                ��</td>
            </tr>
            <tr>
              <td>�ӹǹ�����·ҧ�Ե</td>
              <td><input type="text" value="<?php echo $tMindSick;  ?>" size="4" maxlength="4" name="tMindSick" id="tMindSick" class="numberOnly" />
                ��</td>
            </tr>
            <tr>
              <td>�ӹǹ������������ѧ</td>
              <td><input type="text" value="<?php echo $tSick;  ?>" size="4" maxlength="4"  name="tSick" id="tSick" class="numberOnly"/>
                ��</td>
            </tr>
            <tr>
              <td>�ӹǹ����٧����</td>
              <td><input type="text" value="<?php echo $tElderly;  ?>" size="4" maxlength="4" name="tElderly" id="tElderly" class="numberOnly" />
                ��</td>
            </tr>
          </table>
        </dd></td>
      </tr>
      <tr>
        <td height="25" align="right">17. </td>
        <td  colspan="3">�ӹǹ���������¡��������</td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td colspan="3"><table width="100%" border="0" cellpadding="1" cellspacing="0" id="t17">
          <thead>
            <tr>
              <th width="184" height="25"  bgcolor="#f2f2f2">������</th>
              <th width="202"  bgcolor="#f2f2f2">���</th>
              <th width="202"  bgcolor="#f2f2f2">˭ԧ</th>
              <th width="218"  bgcolor="#f2f2f2">���</th>
            </tr>
          </thead>
          <tr>
            <td width="184" height="25"  align="left">&nbsp;1. �� (���� 0-18 ��)</td>
            <td width="202"  align="center"><input  name="tChildMale" type="text" id="tChildMale"  style=" width:80%" maxlength="4" value="<?php echo $tChildMale; ?>"/></td>
            <td width="202"  align="center"><input name="tChildFemale" type="text" id="tChildFemale"  style=" width:80%" maxlength="4" value="<?php echo $tChildFemale; ?>" /></td>
            <td  align="center"><input name="tChildTotal" type="text" id="tChildTotal"  style=" width:80%; background:#EBEBE4" value="<?php echo $tChildTotal; ?>" maxlength="4" readonly  /></td>
          </tr>
          <tr>
            <td width="184" height="25"  align="left">&nbsp;2. ���Ǫ� (���� 19-25 ��)</td>
            <td width="202"  align="center"><input name="tTeensMale" type="text" id="tTeensMale"  style=" width:80%" maxlength="4" value="<?php echo $tTeensMale; ?>"  /></td>
            <td width="202"  align="center"><input name="tTeensFemale" type="text" id="tTeensFemale"  style=" width:80%" maxlength="4" value="<?php echo $tTeensFemale; ?>" /></td>
            <td  align="center"><input name="tTeensTotal" type="text" id="tTeensTotal"  style=" width:80%; background:#EBEBE4" value="<?php echo $tTeensTotal; ?>" maxlength="4" readonly /></td>
          </tr>
          <tr>
            <td width="184" height="25"  align="left">&nbsp;3. �������·���� (���� 26-59 ��)</td>
            <td width="202"  align="center"><input name="tMan" type="text" id="tMan"  style=" width:80%" maxlength="4" value="<?php echo $tMan; ?>" /></td>
            <td width="202"  align="center"><input name="tWoman" type="text" id="tWoman"  style=" width:80%" maxlength="4" value="<?php echo $tWoman; ?>" /></td>
            <td  align="center"><input name="tTotal" type="text" id="tTotal"  style=" width:80%; background:#EBEBE4" value="<?php echo $tTotal; ?>" maxlength="4" readonly /></td>
          </tr>
          <tr>
            <td width="184" height="25"  align="left">&nbsp;4. ����٧���� (���� 60 ��)</td>
            <td width="202"  align="center"><input name="tElderMale" type="text" id="tElderMale"  style=" width:80%" maxlength="4" value="<?php echo $tElderMale; ?>" /></td>
            <td width="202"  align="center"><input name="tElderFemale" type="text" id="tElderFemale"  style=" width:80%" maxlength="4" value="<?php echo $tElderFemale; ?>" /></td>
            <td  align="center"><input name="tElderTotal" type="text" id="tElderTotal"  style=" width:80%; background:#EBEBE4" value="<?php echo $tElderTotal; ?>" maxlength="4" readonly /></td>
          </tr>
          <tr>
            <td width="184" height="25"  align="left">&nbsp;5. ���ԡ��</td>
            <td width="202"  align="center"><input name="tDisabledMale" type="text" id="tDisabledMale"  style=" width:80%" maxlength="4" value="<?php echo $tDisabledMale; ?>" /></td>
            <td width="202"  align="center"><input name="tDisabledFemale" type="text" id="tDisabledFemale"  style=" width:80%" maxlength="4" value="<?php echo $tDisabledFemale; ?>"  /></td>
            <td  align="center"><input name="tDisabledTotal" type="text" id="tDisabledTotal"  style=" width:80%; background:#EBEBE4" value="<?php echo $tDisabledTotal; ?>" maxlength="4" readonly /></td>
          </tr>
          <tr>
            <td width="184" height="25"  align="center">���������</td>
            <td width="202"  align="center"><input name="tMaleTotal" type="text" id="tMaleTotal"  style=" width:80%; background:#EBEBE4" value="<?php echo $tMaleTotal; ?>" maxlength="4" readonly  /></td>
            <td width="202"  align="center"><input name="tFemaleTotal" type="text" id="tFemaleTotal"  style=" width:80%; background:#EBEBE4" value="<?php echo $tFemaleTotal; ?>" maxlength="4" readonly /></td>
            <td  align="center"><input name="tSumTotal" type="text" id="tSumTotal"  style=" width:80%; background:#EBEBE4" value="<?php echo $tSumTotal; ?>" maxlength="4" readonly  /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="25" align="right">18.</td>
        <td  colspan="2">��ͺ������˹���Թ </td>
        <td>&nbsp;</td>
      </tr>
      <tr class="detable">
        <td height="25" align="right">&nbsp;</td>
        <td  valign="top"><input type="radio"  value="1"  id="rDebt_1"  name="rDebt" <?php if($question_debt==1){echo 'checked';} ?>/>
          1. �����</td>
        <td  valign="top"><br></td>
        <td >&nbsp;</td>
      </tr>
      <tr class="detable">
        <td height="25" align="right">&nbsp;</td>
        <td ><input type="radio"  value="2"  id="rDebt_2" name="rDebt" <?php if($question_debt==2){echo 'checked';} ?> />
          2. �� �ô�к�</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr class="t18">
        <td height="25" align="right">&nbsp;</td>
        <td class ="de_1">&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio"  value="1"  id="rDebt_a" name="rDebt_a" <?php if($question_debt_a==1){echo 'checked';} ?> />
          2.1 ˹����к�</td>
        <td  colspan="2">&nbsp;</td>
      </tr>
      <tr id="t18_a" class="t18_a">
        <td height="25" align="right">&nbsp;</td>
        <td colspan="3"><dd>
          <table width="809" border="0" cellpadding="1" cellspacing="1" class="t18">
            <tr>
              <td width="20"><input name="c18[]" type="checkbox" id="2_2_1" value="1" class="2_2_1"<?php if(in_array(1,$chk)){echo 'checked';} ?>></td>
              <td>�Թ��鸹Ҥ��</td>
            </tr>
            <tr id="t18_2_1_1">
              <td>&nbsp;</td>
              <td>�ӹǹ
                <input type="text" value="<?php echo $t21_money_1; ?>" size="10" name="t21_money_1" id="t21_money_1" />�͡����������
			<input type="text" value="<?php echo $t21_interest_1; ?>" size="10" name="t21_interest_1" id="t21_interest_1"/>���/�� �����������Թ�ӹǹ
			<input type="text" value="<?php echo $t21_pay_1; ?>" size="10" name="t21_pay_1" id="t21_pay_1"/>�ҷ �ʹ�������
			<input type="text" value="<?php echo $t21_balance_1; ?>" size="10" name="t21_balance_1" id="t21_balance_1" />�ҷ</td>
            </tr>
            <tr>
              <td><input name="c18[]" type="checkbox" value="2" id="2_2_2" <?php if(in_array(2,$chk)){echo 'checked';} ?>></td>
              <td>�Թ���ͧ�ع�Ѩ��������Ѿ��</td>
            </tr>
            <tr id="t18_2_1_2">
              <td>&nbsp;</td>
              <td>�ӹǹ
                <input type="text" value="<?php echo $t21_money_2; ?>" size="10" name="t21_money_2" id="t21_money_2" />�͡����������
			<input type="text" value="<?php echo $t21_interest_2; ?>" size="10" name="t21_interest_2" id="t21_interest_2" />���/�� �����������Թ�ӹǹ
			<input type="text" value="<?php echo $t21_pay_2; ?>" size="10" name="t21_pay_2" id="t21_pay_2" />�ҷ �ʹ�������
			<input type="text" value="<?php echo $t21_balance_2; ?>" size="10" name="t21_balance_2" id="t21_balance_2" />�ҷ</td>
            </tr>
            <tr>
              <td><input name="c18[]" type="checkbox" id="2_2_3" value="3" <?php if(in_array(3,$chk)){echo 'checked';} ?>></td>
              <td>�Թ���ͧ�ع�����ҹ</td>
            </tr>
            <tr id="t18_2_1_3">
              <td>&nbsp;</td>
              <td>�ӹǹ
                <input type="text" value="<?php echo $t21_money_3; ?>" size="10" name="t21_money_3" id="t21_money_3"/>�͡����������
			<input type="text" value="<?php echo $t21_interest_3; ?>" size="10" name="t21_interest_3" id="t21_interest_3" />���/�� �����������Թ�ӹǹ
			<input type="text" value="<?php echo $t21_pay_3; ?>" size="10" name="t21_pay_3" id="t21_pay_3" />�ҷ �ʹ�������
			<input type="text" value="<?php echo $t21_balance_3; ?>" size="10" name="t21_balance_3" id="t21_balance_3" />�ҷ</td>
            </tr>
            <tr>
              <td><input name="c18[]" type="checkbox" id="2_2_4" value="4" <?php if(in_array(4,$chk)){echo 'checked';} ?>></td>
              <td>�ͧ�ع�Ѳ�Һ��ҷʵ��</td>
            </tr>
            <tr id="t18_2_1_4">
              <td>&nbsp;</td>
              <td>�ӹǹ
                <input type="text" value="<?php echo $t21_money_4; ?>" size="10" name="t21_money_4" id="t21_money_4" />�͡����������
			<input type="text" value="<?php echo $t21_interest_4; ?>" size="10" name="t21_interest_4" id="t21_interest_4" />���/�� �����������Թ�ӹǹ
			<input type="text" value="<?php echo $t21_pay_4; ?>" size="10" name="t21_pay_4" id="t21_pay_4" />�ҷ �ʹ�������
			<input type="text" value="<?php echo $t21_balance_4; ?>" size="10" name="t21_balance_4" id="t21_balance_4" />�ҷ</td>
            </tr>
            <tr>
              <td><input name="c18[]" type="checkbox" id="2_2_5" value="5" <?php if(in_array(5,$chk)){echo 'checked';} ?>></td>
              <td>�ͧ�ع����٧����</td>
            </tr>
            <tr id="t18_2_1_5">
              <td>&nbsp;</td>
              <td>�ӹǹ
                <input type="text" value="<?php echo $t21_money_5; ?>" size="10" name="t21_money_5" id="t21_money_5" />�͡����������
			<input type="text" value="<?php echo $t21_interest_5; ?>" size="10" name="t21_interest_5" id="t21_interest_5" />���/�� �����������Թ�ӹǹ
			<input type="text" value="<?php echo $t21_pay_5; ?>" size="10" name="t21_pay_5" id="t21_pay_5" />�ҷ �ʹ�������
			<input type="text" value="<?php echo $t21_balance_5; ?>" size="10" name="t21_balance_5" id="t21_balance_5" />�ҷ</td>
            </tr>
            <tr>
              <td><input name="c18[]" type="checkbox" id="2_2_6" value="6" <?php if(in_array(6,$chk)){echo 'checked';} ?>></td>
              <td>�ͧ�ع��������Ѳ�Ҥس�Ҿ���Ե���ԡ��</td>
            </tr>
            <tr id="t18_2_1_6">
              <td>&nbsp;</td>
              <td>�ӹǹ
                <input type="text" value="<?php echo $t21_money_6; ?>" size="10" name="t21_money_6" id="t21_money_6"/>�͡����������
			<input type="text" value="<?php echo $t21_interest_6; ?>" size="10" name="t21_interest_6" id="t21_interest_6"/>���/�� �����������Թ�ӹǹ
			<input type="text" value="<?php echo $t21_pay_6; ?>" size="10" name="t21_pay_6" id="t21_pay_6"/>�ҷ �ʹ�������
			<input type="text" value="<?php echo $t21_balance_6; ?>" size="10" name="t21_balance_6" id="t21_balance_6"/>�ҷ</td>
            </tr>
            <tr>
              <td><input name="c18[]" type="checkbox" id="2_2_7" value="7" <?php if(in_array(7,$chk)){echo 'checked';} ?>></td>
              <td>�ͧ�ع����</td>
            </tr>
            <tr id="t18_2_1_7">
              <td>&nbsp;</td>
              <td>�ӹǹ
                <input type="text" value="<?php echo $t21_money_7; ?>" size="10" name="t21_money_7" id="t21_money_7"/>�͡����������
			<input type="text" value="<?php echo $t21_interest_7; ?>" size="10" name="t21_interest_7" id="t21_interest_7" />���/�� �����������Թ�ӹǹ
			<input type="text" value="<?php echo $t21_pay_7; ?>" size="10" name="t21_pay_7" id="t21_pay_7" />�ҷ �ʹ�������
			<input type="text" value="<?php echo $t21_balance_7; ?>" size="10" name="t21_balance_7" id="t21_balance_7" />�ҷ</td>
            </tr>
            <tr>
              <td><input name="c18[]" type="checkbox" id="2_2_8" value="8" <?php if(in_array(8,$chk)){echo 'checked';} ?>></td>
              <td>�ͧ�ع�ɵ�</td>
            </tr>
            <tr id="t18_2_1_8">
              <td>&nbsp;</td>
              <td>�ӹǹ
                <input type="text" value="<?php echo $t21_money_8; ?>" size="10" name="t21_money_8" id="t21_money_8" />�͡����������
			<input type="text" value="<?php echo $t21_interest_8; ?>" size="10" name="t21_interest_8" id="t21_interest_8"/>���/�� �����������Թ�ӹǹ
			<input type="text" value="<?php echo $t21_pay_8; ?>" size="10" name="t21_pay_8" id="t21_pay_8"/>�ҷ �ʹ�������
			<input type="text" value="<?php echo $t21_balance_8; ?>" size="10" name="t21_balance_8" id="t21_balance_8"/>�ҷ</td>
            </tr>
            <tr>
              <td><input name="c18[]" type="checkbox" id="2_2_9" value="9" <?php if(in_array(9,$chk)){echo 'checked';} ?>></td>
              <td>��� � �к�
                <input type="text" value="<?php echo $t21_other; ?>"  style="width:84%" name="t21_other" id="t21_other" /></td>
            </tr>
            <tr id="t18_2_1_9">
              <td>&nbsp;</td>
              <td>�ӹǹ
                <input type="text" value="<?php echo $t21_money_9; ?>" size="10" name="t21_money_9" id="t21_money_9"/>�͡����������
			<input type="text" value="<?php echo $t21_interest_9; ?>" size="10" name="t21_interest_9" id="t21_interest_9"/>���/�� �����������Թ�ӹǹ
			<input type="text" value="<?php echo $t21_pay_9; ?>" size="10" name="t21_pay_9" id="t21_pay_9"/>�ҷ �ʹ�������
			<input type="text" value="<?php echo $t21_balance_9; ?>" size="10" name="t21_balance_9" id="t21_balance_9"/>�ҷ</td>
            </tr>
          </table>
        </dd></td>
      </tr>
      <tr class="t18">
        <td height="25" align="right" >&nbsp;</td>
        <td colspan="3" class="de_1">&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio"  value="2"  id="rDebt_b" name="rDebt_a"  <?php if($question_debt_a==2){echo 'checked';} ?> />
          2.2 ˹��͡�к� �س��˹��͡�к��ú�ҧ �кت��� - ʡ�Ŵ���</td>
      </tr>
      <tr class="t18_b" id="t18_b">
        <td height="25" align="right">&nbsp;</td>
        <td colspan="3"><dd>
          <table width="809" border="0" cellspacing="2" cellpadding="2" id="t18_b" class="t18">
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                <td >����-ʡ��
                  <input type="text" name="tName18_2_1" value="<?php echo $tName18_2_1; ?>" /></td>
                <td width="104" >�ӹǹ�Թ</td>
                <td width="114"><input type="text" name="tMoney18_2_1" size="10" value="<?php echo $tMoney18_2_1; ?>" />
                  �ҷ</td>
                <td width="104">�͡����������</td>
                <td width="264"><input name="tInterest18_2_1" type="text" value="<?php echo $tInterest18_2_1; ?>" size="10" />
                  ����ѹ/��͹/�� </td>
              </tr>
              <tr>
                <td width="191" >&nbsp;</td>
                <td >�����������Թ </td>
                <td ><input name="tPay18_2_1" type="text" value="<?php echo $tPay18_2_1; ?>" size="10" />
                  �ҷ</td>
                <td >�ʹ�������</td>
                <td ><input name="tBalance18_2_1" type="text" value="<?php echo $tBalance18_2_1; ?>" size="10" />
                  �ҷ</td>
              </tr>
              <tr>
                <td >����-ʡ��
                  <input type="text" name="tName18_2_2" value="<?php echo $tName18_2_2; ?>" /></td>
                <td >�ӹǹ�Թ</td>
                <td ><input type="text" name="tMoney18_2_2" size="10" value="<?php echo $tMoney18_2_2; ?>" />
                  �ҷ</td>
                <td >�͡����������</td>
                <td ><input name="tInterest18_2_2" type="text" value="<?php echo $tInterest18_2_2; ?>" size="10" />
                  ����ѹ/��͹/�� </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td >�����������Թ</td>
                <td ><input name="tPay18_2_2" type="text" value="<?php echo $tPay18_2_2; ?>" size="10" />
                  �ҷ</td>
                <td >�ʹ�������</td>
                <td ><input name="tBalance18_2_2" type="text" value="<?php echo $tBalance18_2_2; ?>" size="10" />
                  �ҷ</td>
              </tr>
              <tr>
                <td >����-ʡ��
                  <input type="text" name="tName18_2_3" value="<?php echo $tName18_2_3; ?>" /></td>
                <td>�ӹǹ�Թ</td>
                <td ><input type="text" name="tMoney18_2_3" size="10" value="<?php echo $tMoney18_2_3; ?>" />
                  �ҷ</td>
                <td>�͡����������</td>
                <td ><input name="tInterest18_2_3" type="text" value="<?php echo $tInterest18_2_3; ?>" size="10" />
                  ����ѹ/��͹/�� </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td>�����������Թ</td>
                <td ><input name="tPay18_2_3" type="text" value="<?php echo $tPay18_2_3; ?>" size="10" />
                  �ҷ</td>
                <td>�ʹ�������</td>
                <td ><input name="tBalance18_2_3" type="text" value="<?php echo $tBalance18_2_3; ?>" size="10" />
                  �ҷ</td>
              </tr>
              <tr>
                <td >����-ʡ��
                  <input type="text" name="tName18_2_4" value="<?php echo $tName18_2_4; ?>" /></td>
                <td>�ӹǹ�Թ</td>
                <td ><input type="text" name="tMoney18_2_4" size="10" value="<?php echo $tMoney18_2_4; ?>" />
                  �ҷ</td>
                <td>�͡����������</td>
                <td ><input name="tInterest18_2_4" type="text" value="<?php echo $tInterest18_2_4; ?>" size="10" />
                  ����ѹ/��͹/�� </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td>�����������Թ</td>
                <td ><input name="tPay18_2_4" type="text" value="<?php echo $tPay18_2_4; ?>" size="10" />
                  �ҷ</td>
                <td>�ʹ�������</td>
                <td ><input name="tBalance18_2_4" type="text" value="<?php echo $tBalance18_2_4; ?>" size="10" />
                  �ҷ</td>
              </tr>
              <tr>
                <td >����-ʡ��
                  <input type="text" name="tName18_2_5" value="<?php echo $tName18_2_5; ?>" /></td>
                <td>�ӹǹ�Թ</td>
                <td ><input type="text" name="tMoney18_2_5" size="10" value="<?php echo $tMoney18_2_5; ?>" />
                  �ҷ</td>
                <td>�͡����������</td>
                <td ><input name="tInterest18_2_5" type="text" value="<?php echo $tInterest18_2_5; ?>" size="10" />
                  ����ѹ/��͹/�� </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td>�����������Թ</td>
                <td ><input name="tPay18_2_5" type="text" value="<?php echo $tPay18_2_5; ?>" size="10" />
                  �ҷ</td>
                <td>�ʹ�������</td>
                <td ><input name="tBalance18_2_5" type="text" value="<?php echo $tBalance18_2_5; ?>" size="10" />
                  �ҷ</td>
              </tr>
              <tr>
                <td >����-ʡ��
                  <input type="text" name="tName18_2_6" value="<?php echo $tName18_2_6; ?>" /></td>
                <td>�ӹǹ�Թ</td>
                <td ><input type="text" name="tMoney18_2_6" size="10" value="<?php echo $tMoney18_2_6; ?>"/>
                  �ҷ</td>
                <td>�͡����������</td>
                <td ><input name="tInterest18_2_6" type="text" value="<?php echo $tInterest18_2_6; ?>" size="10" />
                  ����ѹ/��͹/�� </td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td>�����������Թ</td>
                <td ><input name="tPay18_2_6" type="text" value="<?php echo $tPay18_2_6; ?>" size="10" />
                  �ҷ</td>
                <td>�ʹ�������</td>
                <td ><input name="tBalance18_2_6" type="text" value="<?php echo $tBalance18_2_6; ?>" size="10" />
                  �ҷ</td>
              </tr>
            </tfoot>
          </table>
        </dd></td>
      </tr>
      <tr>
        <td height="25" align="right">&nbsp;</td>
        <td colspan="3" align="right"><button> �ѹ�֡ </button></td>
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
<script src="../js/CheckIdCardThai.min.js"></script>
<script src="../js/AgeCalculate.min.js"></script>
<script>

function fncSubmit()
{
	if(document.form1.tIDCard.value == "")
	{
		alert('��سҡ�͡�ѵû�ЪҪ� ���� ��ԡ��������ѵû�ЪҪ�');
		document.form1.tIDCard.focus();
		return false;
	}
	
	if(document.form1.tFirstname.value == "")
	{
		alert('��سҡ�͡�������˹�Ҥ�ͺ����');
		document.form1.tFirstname.focus();
		return false;
	}
	
	if(document.form1.tLastname.value == "")
	{
		alert('��سҡ�͡���ʡ��');
		document.form1.tLastname.focus();
		return false;
	}

	if(document.form1.tAge.value == "")
	{
		alert('��سҡ�͡����');
		document.form1.tAge.focus();
		return false;
	}

	var result = $('#tIDCard').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
	} else {
		alert('�Ţ�ѵû�ЪҪ�������١��ͧ');
		document.form1.tIDCard.focus();
		return false;
	}
}

$(document).ready(function () {
/*$('#tbirthday').keydown(function(e){
	var oEvent = (window.event) ? window.event : e; 
			var Obj = document.getElementById('tbirthday');
			if ( Obj.value.length == 2 || Obj.value.length == 5) {
				Obj.value = Obj.value + "/";
			}
});*/
/*----------------------------------------------------------- �ӹǹ�ѹ�Դ*/
$("#tbirthday").change(function () {
	var result = calAge(document.getElementById('tbirthday').value);
	document.getElementById('tAge').value = result[0];
});

$("#tAge").keyup(function() {
 var tAge = document.getElementById('tAge').value ;
 var ttAge = <?php echo $dt = date('Y') + 543;?> - tAge ;
 var showDate = "01/01/" + ttAge ;
 document.getElementById('tbirthday').value = showDate;
 
});

/*----------------------------------------------------------- ��Ǩ�ͺ����Ţ*/
$(".numberOnly").keydown(function(e){
	if (e.shiftKey) 
           e.preventDefault();
       else 
       {
           var nKeyCode = e.keyCode;
           //Ignore Backspace and Tab keys
           if (nKeyCode == 8 || nKeyCode == 9)
               return;
           if (nKeyCode < 95) 
           {
               if (nKeyCode < 48 || nKeyCode > 57)
                   e.preventDefault();
           }
           else 
           {
               if (nKeyCode < 96 || nKeyCode > 105) 
               e.preventDefault();
           }
       }
});

/*----------------------------------------------------------- �ӹǹ�Ţ㹢�� 16 */
$("#t16_detail input").keyup(function (){
	var tChild = document.getElementById('tChild').value;
	var tDisabled = document.getElementById('tDisabled').value;
	var tMindSick = document.getElementById('tMindSick').value;
	var tSick = document.getElementById('tSick').value;
	var tElderly = document.getElementById('tElderly').value;
	
	if(tChild==''){tChild = 0;}
	if(tDisabled==''){tDisabled = 0;}
	if(tMindSick==''){tMindSick = 0;}
	if(tSick==''){tSick = 0;}
	if(tElderly==''){tElderly = 0;}

	var tDefective = parseInt(tChild)+parseInt(tDisabled)+parseInt(tMindSick)+parseInt(tSick)+parseInt(tElderly);
	$("#tDefective").val(tDefective);
});

/*----------------------------------------------------------- �ӹǹ�Ţ㹢�� 15 */
$("#t15_detail_1 input").keyup(function (){
	var tMemberMale_1 = document.getElementById('tMemberMale_1').value;
	var tMemberFemale_1 = document.getElementById('tMemberFemale_1').value;
	if(tMemberMale_1==''){tMemberMale_1 = 0;}
	if(tMemberFemale_1==''){tMemberFemale_1 = 0;}
	var tMemberFamily_1 = parseInt(tMemberMale_1)+parseInt(tMemberFemale_1);
	$("#tMemberFamily_1").val(tMemberFamily_1);
});

$("#t15_detail_2_1 input").keyup(function (){
	var tMemberMale_2_1 = document.getElementById('tMemberMale_2_1').value;
	var tMemberFemale_2_1 = document.getElementById('tMemberFemale_2_1').value;
	if(tMemberMale_2_1==''){tMemberMale_2_1 = 0;}
	if(tMemberFemale_2_1==''){tMemberFemale_2_1 = 0;}
	var tMemberFamily_2_1 = parseInt(tMemberMale_2_1)+parseInt(tMemberFemale_2_1);
	$("#tMemberFamily_2_1").val(tMemberFamily_2_1);
});

$("#t15_detail_2_2 input").keyup(function (){
	var tMemberMale_2_2 = document.getElementById('tMemberMale_2_2').value;
	var tMemberFemale_2_2 = document.getElementById('tMemberFemale_2_2').value;
	if(tMemberMale_2_2 ==''){tMemberMale_2_2 = 0;}
	if(tMemberFemale_2_2 ==''){tMemberFemale_2_2 = 0;}
	var tMemberFamily_2_2 = parseInt(tMemberMale_2_2)+parseInt(tMemberFemale_2_2);
	$("#tMemberFamily_2_2").val(tMemberFamily_2_2);
});


//��ǹ�ͧ��õ�Ǩ�ͺ���͹䢡��Disabled 
//��Ǩ�ͺ���͹䢡������
//Sexcheck
	if($('.Sexcheck input:not(#etc_1)').is(':checked') == true){
$("#tSex").attr('disabled','disabled');
	}
$('#etc_1').click(function(){
	$("#tSex").removeAttr('disabled');
});
$('.rSex').click(function(){
	$("#tSex").attr('disabled','disabled');
	document.getElementById('chkSex').value = 1;
});

//��Ǩ�ͺ���͹䢡����������������
if($('.Typehome input:not(#rTypeHome_2)').is(':checked') == true){
$("#tTypeHome_2").attr('disabled','disabled');
	}
if($('.Typehome input:not(#rTypeHome_4)').is(':checked') == true){
$("#tTypeHome_4").attr('disabled','disabled');
	}
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

//��Ǩ�ͺ���͹䢡�����Ҫվ

if($('.careertable input:not(#cCareer9)').is(':checked') == false){
	$('#cCareer1,#cCareer2,#cCareer3,#cCareer4,#cCareer5,#cCareer6,#cCareer7,#cCareer8,#cCareer10').attr('disabled','disabled')
}

if($('.careertable input:not(#cCareer10)').is(':checked') == false){
	$('#tCareer').removeAttr('disabled');
}

//$("#tCareer").attr('disabled','disabled');		
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

$('.careertable input:not(#cCareer9)').click(function(){
	if($('.careertable input:not(#cCareer9)').is(':checked') == true){
		$('#cCareer9').attr('disabled','disabled')
		$('#cCareer9').removeAttr('checked')
	}
	if($('.careertable input:not(#cCareer9)').is(':checked') == false){
		$('#cCareer9').removeAttr('disabled')
	}
});

$('#cCareer9').click(function(){
		 if($('.careertable input:not(#cCareer9)').attr('disabled')){ //�����
			$('.careertable input:not(#cCareer9,#tCareer)').removeAttr('disabled')
		 }else{
			$('.careertable input:not(#cCareer9)').attr('disabled','disabled')
			$('.careertable input:not(#cCareer9)').removeAttr('checked')
		}
});

//��Ǩ�ͺ���͹䢡�������Թ
	if($("#Land_2").attr('checked')){
$("#tLand").attr('disabled','disabled');
	}
$('.rLand_1').click(function(){
	$("#tLand").attr('disabled','disabled');
});

$('#rLand').click(function(){
	$("#tLand").removeAttr('disabled');
});
//��Ǩ�ͺ���͹䢡������ʹ�
if($('.tablereligion input:not(#rReligion_4)').is(':checked') == true){
$("#tReligion_1").attr('disabled','disabled');
}

$('.rReligion').click(function(){
	$("#tReligion_1").attr('disabled','disabled');
});
$('.rReligion_1').click(function(){
	$("#tReligion_1").removeAttr('disabled');
});

//��Ǩ�ͺ���͹���ҹ�Ҿ����
if($('.statustable input:not(#rStatus_5)').is(':checked') == true){
	$(".rStatus_detail").hide();
	}
$('.rStatus').click(function(){
	$(".rStatus_detail").hide();
});

$('#rStatus_5').click(function(){
	$(".rStatus_detail").show();
});

//------------------------------------------------ 16
//defective
	if($('.defective input:not(#rDefective_2)').is(':checked') == true){
		$('#t16_detail').hide();
		}
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
	 document.getElementById('tChildTotal').value = tChildTotal;
	//$("#tChildTotal").val(tChildTotal);
	
	var tTeensMale = document.getElementById('tTeensMale').value;
	var tTeensFemale = document.getElementById('tTeensFemale').value;
	if(tTeensMale==''){tTeensMale = 0;}
	if(tTeensFemale==''){tTeensFemale = 0;}
	var tTeensTotal = parseInt(tTeensMale)+parseInt(tTeensFemale);
	document.getElementById('tTeensTotal').value = tTeensTotal;
	//$("#tTeensTotal").val(tTeensTotal);
	
	var tMan = document.getElementById('tMan').value;
	var tWoman = document.getElementById('tWoman').value;
	if(tMan==''){tMan = 0;}
	if(tWoman==''){tWoman = 0;}
	var tTotal = parseInt(tMan)+parseInt(tWoman);
	document.getElementById('tTotal').value = tTotal;
	//$("#tTotal").val(tTotal);
	
	var tElderMale = document.getElementById('tElderMale').value;
	var tElderFemale = document.getElementById('tElderFemale').value;
	if(tElderMale==''){tElderMale = 0;}
	if(tElderFemale==''){tElderFemale = 0;}
	var tElderTotal = parseInt(tElderMale)+parseInt(tElderFemale);
	document.getElementById('tElderTotal').value = tElderTotal;
	//$("#tElderTotal").val(tElderTotal);
	
	var tDisabledMale = document.getElementById('tDisabledMale').value;
	var tDisabledFemale = document.getElementById('tDisabledFemale').value;
	if(tDisabledMale==''){tDisabledMale = 0;}
	if(tDisabledFemale==''){tDisabledFemale = 0;}
	var tDisabledTotal = parseInt(tDisabledMale)+parseInt(tDisabledFemale);
	document.getElementById('tDisabledTotal').value = tDisabledTotal;
	//$("#tDisabledTotal").val(tDisabledTotal);

	var tMaleTotal = parseInt(tChildMale)+parseInt(tTeensMale)+parseInt(tMan)+parseInt(tElderMale)+parseInt(tDisabledMale);
	var tFemaleTotal = parseInt(tChildFemale)+parseInt(tTeensFemale)+parseInt(tWoman)+parseInt(tElderFemale)+parseInt(tDisabledFemale);
	var tSumTotal = parseInt(tMaleTotal)+parseInt(tFemaleTotal);
	
	document.getElementById('tMaleTotal').value = tMaleTotal;
	document.getElementById('tFemaleTotal').value = tFemaleTotal;
	document.getElementById('tSumTotal').value = tSumTotal;
	//$("#tMaleTotal").val(tMaleTotal);
	//$("#tFemaleTotal").val(tFemaleTotal);
	//$("#tSumTotal").val(tSumTotal);
});


//���͹䢡������ͺ����
//////////////////////////��Ǩ�ͺ���͹䢡������ͺ���������
if($('.stuctable input:not(#rStructureFamily)').is(':checked') == true){
	$("#tMemberMale_1,#tMemberFemale_1").attr('disabled','disabled');
	}
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

/////////////////////////////��Ǩ�ͺ���͹䢡������ͺ���Ǣ���
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

///////////////////////////////////��Ǩ�ͺ���͹䢻�����ͺ���Ǿ����
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

/*------------------------------------ ��Ǩ�ͺ��͹��ͤ��� r15_2 r15_3 rStructureFamily rLargeFamily rSpecialFamily*/ 
/*if($('.tablereligion input:not(#rReligion_4)').is(':checked') == true){
$("#tReligion_1").attr('disabled','disabled');*/
	if($('.stuctable input:not(#rLargeFamily)').is(':checked') == true){
$(".r15_2").hide();
	}
	if($('.stuctable input:not(#rSpecialFamily)').is(':checked') == true){	
$(".r15_3").hide();
	}
	if($('.r15_2 input:not(#rLargeFamily_21)').is(':checked') == true){	
$("#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
	}
	if($('.r15_2 input:not(#rLargeFamily_22)').is(':checked') == true){	
$("#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
	}
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
//if($('.r15_2 input:not(#rLargeFamily_21)').is(':checked') == true){
	/*if($('.detable input:not(#rDebt_2)').is(':checked') == true){
$('.t18_b').hide();
	}*/
	
if($('#rDebt_1').is(':checked') == true){
		$('#t18_a').hide();
		$('#t18_b').hide();
		$('.t18').hide();
	}
$('#rDebt_1').click(function(){
	$('.t18').hide();
})
$('#rDebt_2').click(function(){
	$('.t18').show();
})

$('#rDebt_a').click(function(){
	$('#t18_a').show();
	$('#t18_b').hide();
})
$('#rDebt_b').click(function(){
	$('#t18_a').hide();//prop
	$('#t18_b').show();
})
//����Թ��к���й͡�к�
 if($('#rDebt_a').is(':checked') == true){
	 $('.t18_b').hide();
 }
 if($('#rDebt_b').is(':checked') == true){
	 $('.t18_a').hide();
 }
//�Թ��鸹Ҥ��
	if($('#2_2_1').attr('checked')){
		$('#t18_2_1_1').show();
	}
	else{
		$('#t18_2_1_1').hide();
	}
$('#2_2_1').click(function(){
	if($('#2_2_1').attr('checked')){
		$('#t18_2_1_1').show();
	}
	else{
		$('#t18_2_1_1').hide();
	}
})
//�Թ���ͧ�ع�Ѩ��������Ѿ��

if($('#2_2_2').attr('checked')){
		$('#t18_2_1_2').show();
	}
	else{
		$('#t18_2_1_2').hide();
	}
$('#2_2_2').click(function(){
	if($('#2_2_2').attr('checked')){
		$('#t18_2_1_2').show();
	}
	else{
		$('#t18_2_1_2').hide();
	}
})
//�Թ���ͧ�ع�����ҹ
if($('#2_2_3').attr('checked')){
		$('#t18_2_1_3').show();
	}
	else{
		$('#t18_2_1_3').hide();
	}
$('#2_2_3').click(function(){
	if($('#2_2_3').attr('checked')){
		$('#t18_2_1_3').show();
	}
	else{
		$('#t18_2_1_3').hide();
	}
})
//�ͧ�ع�Ѳ�Һ��ҷʵ��
if($('#2_2_4').attr('checked')){
		$('#t18_2_1_4').show();
	}
	else{
		$('#t18_2_1_4').hide();
	}
$('#2_2_4').click(function(){
	if($('#2_2_4').attr('checked')){
		$('#t18_2_1_4').show();
	}
	else{
		$('#t18_2_1_4').hide();
	}
})
//�ͧ�ع����٧����
if($('#2_2_5').attr('checked')){
		$('#t18_2_1_5').show();
	}
	else{
		$('#t18_2_1_5').hide();
	}
$('#2_2_5').click(function(){
	if($('#2_2_5').attr('checked')){
		$('#t18_2_1_5').show();
	}
	else{
		$('#t18_2_1_5').hide();
	}
})
//�ͧ�ع��������Ѳ�Ҥس�Ҿ���Ե���ԡ��
if($('#2_2_6').attr('checked')){
		$('#t18_2_1_6').show();
	}
	else{
		$('#t18_2_1_6').hide();
	}
$('#2_2_6').click(function(){
	if($('#2_2_6').attr('checked')){
		$('#t18_2_1_6').show();
	}
	else{
		$('#t18_2_1_6').hide();
	}
})
//�ͧ�ع����
if($('#2_2_7').attr('checked')){
		$('#t18_2_1_7').show();
	}
	else{
		$('#t18_2_1_7').hide();
	}
$('#2_2_7').click(function(){
	if($('#2_2_7').attr('checked')){
		$('#t18_2_1_7').show();
	}
	else{
		$('#t18_2_1_7').hide();
	}
})
//�ͧ�ع�ɵ�
if($('#2_2_8').attr('checked')){
		$('#t18_2_1_8').show();
	}
	else{
		$('#t18_2_1_8').hide();
	}
$('#2_2_8').click(function(){
	if($('#2_2_8').attr('checked')){
		$('#t18_2_1_8').show();
	}
	else{
		$('#t18_2_1_8').hide();
	}
})
//�����к�
if($('#2_2_9').attr('checked')){
		$('#t18_2_1_9').show();
	}
	else{
		$('#t18_2_1_9').hide();
	}
$('#2_2_9').click(function(){
	if($('#2_2_9').attr('checked')){
		$('#t18_2_1_9').show();
	}
	else{
		$('#t18_2_1_9').hide();
	}
})
//�кءͧ�ع����������
if($('#2_2_9').attr('checked')){
		$('#t21_other').removeAttr('disabled');
	}
	else{
		$('#t21_other').attr('disabled','disabled');
	}
$('#2_2_9').click(function(){
	if($('#2_2_9').attr('checked')){
		$('#t21_other').removeAttr('disabled');;
	}
	else{
		$('#t21_other').attr('disabled','disabled');
	}
})
});

    
</script>

