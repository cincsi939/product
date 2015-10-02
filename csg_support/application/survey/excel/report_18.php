<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Tanachai Khampukhew (tanachai@sapphire.co.th)
 * @created  16/09/2014
 * @access  public
 */
 ?>
 <?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=report".date('Y').date('m').date('d').".xls");
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"

xmlns:x="urn:schemas-microsoft-com:office:excel"

xmlns="http://www.w3.org/TR/REC-html40">
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<body>
<TABLE  x:str BORDER="1">
<thead>
	<tr>
    	<th>ลำดับ</th>
        <th>บัตรประชาชน</th>
        <th>ชื่อ-นามสกลุ (หัวหน้าครัวเรือน)</th>
        <th>รหัสตำบล</th>
        <th>ตำบล</th>
        <th>รหัสอำเภอ</th>
        <th>อำเภอ</th>
        <th>รหัสจังหวัด</th>
        <th>จังหวัด</th>
        <th>นอกระบบ</th>
        <th>นอกระบบ(ล)</th>
        <th>เงินกู้ธนาคาร</th>
        <th>เงินกู้ธนาคาร(ล)</th>
        <th>เงินกู้กองทุนสัจจะสะสม</th>
        <th>เงินกู้กองทุนสัจจะสะสม(ล)</th>
        <th>เงินกู้กองทุนหมู่บ้าน</th>
        <th>เงินกู้กองทุนหมู่บ้าน(ล)</th>
        <th>กองทุนพัฒนาบทบาทสตรี</th>
        <th>กองทุนพัฒนาบทบาทสตรี(ล)</th>
        <th>กองทุนผู้สูงอายุ</th>
        <th>กองทุนผู้สูงอายุ(ล)</th>
        <th>กองทุนส่งเสริมพัฒนาคุณภาพชีวิตคนพิการ</th>
        <th>กองทุนส่งเสริมพัฒนาคุณภาพชีวิตคนพิการ(ล)</th>
        <th>กองทุนปุ๋ย</th>
        <th>กองทุนปุ๋ย(ล)</th>
        <th>กองทุนเกษตร</th>
        <th>กองทุนเกษตร(ล)</th>
        <th>อื่น ๆ</th>
        <th>อื่น ๆ(ล)</th>
        <th>รวม</th>
        <th>รวม(ล)</th>
        <th>ปีที่สำรวจ</th>
        <th>วันที่สำรวจ</th>
    </tr>
</thead>
<tbody>
<?php
		include('../lib/class.function.php');
		$con = new Cfunction();
		$sql = 'Select RIGHT(question_date,4) as question_year,question_date,question_id,question_firstname,question_lastname,question_idcard_detail';
		$sql .= ',getCCAA(LEFT(question_parish,6)) as question_parishname,getCCAA(LEFT(question_district,4)) as question_districtname,getCCAA(LEFT(question_province,2)) as question_provincename';
		$sql .= ',question_parish,question_district,question_province';
		$sql .= ',question_debt,question_debt_sub,question_debt_detail';
		$sql .= ',getDetail(4,question_prename) as question_prename';
		$sql .= ' FROM question_detail_1';
		$con->connectDB();
		$results = $con->select($sql);
		$i = 0;
		foreach($results as $row)
		{
			$i++;
			$question_idcard_detail = $row['question_idcard_detail'];
			$name = $row['question_prename'].$row['question_firstname'].' '.$row['question_lastname'];
			
			$code_parish = $row['question_parish'];
			$parish = $row['question_parishname'];
			$code_district = $row['question_district'];
			$district = $row['question_districtname'];
			$code_province = $row['question_province'];
			$province = $row['question_provincename'];
			$question_year = $row['question_year'];
			$question_date = $row['question_date'];
			$question_date = explode('/',$question_date);
			$date = ($question_year-543).'-'.$question_date[1].'-'.$question_date[0];
			$date = new DateTime($date);
			$last_date = $date->format('Y-m-d');
			
			/*--------------------------------------------------------------------------------------- ครอบครัวมีหนี้สิน*/
			$question_debt = $row['question_debt'];
			$question_debt_a = '';
			$question_debt_detail = '';
			$chk = array();
			
			$t21_money_1 = 0;
			$t21_interest_1 = '';
			$t21_pay_1 = '';
			$t21_balance_1 = '';
			
			$t21_money_2 = 0;
			$t21_interest_2 = '';
			$t21_pay_2 = '';
			$t21_balance_2 = '';
			
			$t21_money_3 = 0;
			$t21_interest_3 = '';
			$t21_pay_3 = '';
			$t21_balance_3 = '';
			
			$t21_money_4 = 0;
			$t21_interest_4 = '';
			$t21_pay_4 = '';
			$t21_balance_4 = '';
			
			$t21_money_5 = 0;
			$t21_interest_5 = '';
			$t21_pay_5 = '';
			$t21_balance_5 = '';
			
			$t21_money_6 = 0;
			$t21_interest_6 = '';
			$t21_pay_6 = '';
			$t21_balance_6 = '';
			
			$t21_money_7 = 0;
			$t21_interest_7 = '';
			$t21_pay_7 = '';
			$t21_balance_7 = '';
			
			$t21_money_8 = 0;
			$t21_interest_8 = '';
			$t21_pay_8 = '';
			$t21_balance_8 = '';
			
			$t21_other = '';
			$t21_money_9 = 0;
			$t21_interest_9 = '';
			$t21_pay_9 = '';
			$t21_balance_9 = '';
			
			$tName18_2_1 = '';
			$tMoney18_2_1 = 0;
			$tInterest18_2_1 ='' ;
			$tPay18_2_1 ='';
			$tBalance18_2_1 = '';
			
			$tName18_2_2 = '';
			$tMoney18_2_2 = 0;
			$tInterest18_2_2 ='' ;
			$tPay18_2_2 ='';
			$tBalance18_2_2 = '';
			
			$tName18_2_3 = '';
			$tMoney18_2_3 = 0;
			$tInterest18_2_3 ='' ;
			$tPay18_2_3 ='';
			$tBalance18_2_3 = '';
			
			$tName18_2_4 = '';
			$tMoney18_2_4 = 0;
			$tInterest18_2_4 ='' ;
			$tPay18_2_4 ='';
			$tBalance18_2_4 = '';
			
			$tName18_2_5 = '';
			$tMoney18_2_5 = 0;
			$tInterest18_2_5 ='' ;
			$tPay18_2_5 ='';
			$tBalance18_2_5 = '';
			
			$tName18_2_6 = '';
			$tMoney18_2_6 = 0;
			$tInterest18_2_6 ='' ;
			$tPay18_2_6 ='';
			$tBalance18_2_6 = '';
			
			$tMoney18 = 0;
			
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
			
			$tMoney18 = $tMoney18_2_1+$tMoney18_2_2+$tMoney18_2_3+$tMoney18_2_4+$tMoney18_2_5;
			//$tMoney18_L = substr($tMoney18/1000000,0,strpos($tMoney18/1000000,'.')+3);
			if($tMoney18<100){$tMoney18_L = 0.00;}else{$tMoney18_L =  substr($tMoney18/1000000,0,strpos($tMoney18/1000000,'.')+5);}
			if($t21_money_1<100){$t21_money_1_L = 0.00;}else{$t21_money_1_L = substr($t21_money_1/1000000,0,strpos($t21_money_1/1000000,'.')+5);}
			if($t21_money_2<100){$t21_money_2_L = 0.00;}else{$t21_money_2_L = substr($t21_money_2/1000000,0,strpos($t21_money_2/1000000,'.')+5);}
			if($t21_money_3<100){$t21_money_3_L = 0.00;}else{$t21_money_3_L = substr($t21_money_3/1000000,0,strpos($t21_money_3/1000000,'.')+5);}
			if($t21_money_4<100){$t21_money_4_L = 0.00;}else{$t21_money_4_L = substr($t21_money_4/1000000,0,strpos($t21_money_4/1000000,'.')+5);}
			if($t21_money_5<100){$t21_money_5_L = 0.00;}else{$t21_money_5_L = substr($t21_money_5/1000000,0,strpos($t21_money_5/1000000,'.')+5);}
			if($t21_money_6<100){$t21_money_6_L = 0.00;}else{$t21_money_6_L = substr($t21_money_6/1000000,0,strpos($t21_money_6/1000000,'.')+5);}
			if($t21_money_7<100){$t21_money_7_L = 0.00;}else{$t21_money_7_L = substr($t21_money_7/1000000,0,strpos($t21_money_7/1000000,'.')+5);}
			if($t21_money_8<100){$t21_money_8_L = 0.00;}else{$t21_money_8_L = substr($t21_money_8/1000000,0,strpos($t21_money_8/1000000,'.')+5);}
			if($t21_money_9<100){$t21_money_9_L = 0.00;}else{$t21_money_9_L = substr($t21_money_9/1000000,0,strpos($t21_money_9/1000000,'.')+5);}
			
			
			$t21_money_all = $tMoney18+$t21_money_1+$t21_money_2+$t21_money_3+$t21_money_4+$t21_money_5+$t21_money_6+$t21_money_7+$t21_money_8+$t21_money_9;
			$t21_money_all_L = $tMoney18_L+$t21_money_1_L+$t21_money_2_L+$t21_money_3_L+$t21_money_4_L+$t21_money_5_L+$t21_money_6_L+$t21_money_7_L+$t21_money_8_L+$t21_money_9_L;
?>		
	<tr>
    	<td><?php echo $i; ?></td>
        <td><?php echo $question_idcard_detail; ?></td>
        <td><?php echo $name; ?></td>
        <td><?php echo $code_parish; ?></td>
        <td><?php echo $parish; ?></td>
        <td><?php echo $code_district; ?></td>
        <td><?php echo $district; ?></td>
        <td><?php echo $code_province; ?></td>
        <td><?php echo $province; ?></td>
        <td><?php echo $tMoney18; ?></td>
        <td><?php echo $tMoney18_L; ?></td> 
        <td><?php echo $t21_money_1; ?></td>
        <td><?php echo $t21_money_1_L; ?></td>
        <td><?php echo $t21_money_2; ?></td>
        <td><?php echo $t21_money_2_L; ?></td>
        <td><?php echo $t21_money_3; ?></td>
        <td><?php echo $t21_money_3_L; ?></td>
        <td><?php echo $t21_money_4; ?></td>
        <td><?php echo $t21_money_4_L; ?></td>
        <td><?php echo $t21_money_5; ?></td>
        <td><?php echo $t21_money_5_L; ?></td>
        <td><?php echo $t21_money_6; ?></td>
        <td><?php echo $t21_money_6_L; ?></td>
        <td><?php echo $t21_money_7; ?></td>
        <td><?php echo $t21_money_7_L; ?></td>
        <td><?php echo $t21_money_8; ?></td>
        <td><?php echo $t21_money_8_L; ?></td>
        <td><?php echo $t21_money_9; ?></td>
        <td><?php echo $t21_money_9_L; ?></td>
        <td><?php echo $t21_money_all; ?></td>
        <td><?php echo $t21_money_all_L; ?></td>
        <td><?php echo $question_year; ?></td>
        <td><?php echo $last_date; ?></td>
    </tr>
    <?php
		}
	?>
</tbody>
</TABLE>