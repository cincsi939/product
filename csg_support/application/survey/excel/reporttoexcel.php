<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2011 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2011 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.6, 2011-02-27
 */
 //ฟังชั่นปรับสีช่องตารางExcel
function cellColor($cells,$color){
        global $objPHPExcel;
        $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()
        ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => $color)
        ));
    }


/** Error reporting */
error_reporting(E_ALL);

date_default_timezone_set('Europe/London');

/** PHPExcel */
require_once '../../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

//ปรับสีช่องตารางExcel
cellColor('A1:AX1', 'EBEBE4');

// Set properties
$objPHPExcel->getProperties()->setCreator("Sapphire Research and Development co.,ltd")
							 ->setLastModifiedBy("tanachai khampukhew")
							 ->setTitle("Report to excel")
							 ->setSubject("Report to excel")
							 ->setDescription("Report to excel")
							 ->setKeywords("Report to excel")
							 ->setCategory("Report to excel");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ลำดับ')
			->setCellValue('B1', 'ประจำปี')
			->setCellValue('C1', 'รอบที่')
            ->setCellValue('D1', 'เลขบัตรประชาชน')
            ->setCellValue('E1', 'ชื่อ')
			->setCellValue('F1', 'นามสกุล')
			->setCellValue('G1', 'ที่อยู่')
			->setCellValue('H1', 'หมู่ที่')
			->setCellValue('I1', 'ถนน')
			->setCellValue('J1', 'รหัสตำบล')
			->setCellValue('K1', 'ตำบล')
			->setCellValue('L1', 'รหัสอำเภอ')
			->setCellValue('M1', 'อำเภอ')
			->setCellValue('N1', 'รหัสจังหวัด')
			->setCellValue('O1', 'จังหวัด')
			->setCellValue('P1', 'โทรศัพท์')
			->setCellValue('Q1', 'เพศ')
			->setCellValue('R1', 'วันเกิด')
			->setCellValue('S1', 'อายุ')
			->setCellValue('T1', 'Q9')
			->setCellValue('U1', 'Q10')
			->setCellValue('V1', 'Q11')
			->setCellValue('W1', 'Q12')
			->setCellValue('X1', 'Q13')
			->setCellValue('Y1', 'Q14')
			->setCellValue('Z1', 'Q15')
			->setCellValue('AA1', 'Q16')
			->setCellValue('AB1', 'Q17.1')
			->setCellValue('AC1', 'Q17.2')
			->setCellValue('AD1', 'Q17.3')
			->setCellValue('AE1', 'Q17.4')
			->setCellValue('AF1', 'Q17.5')
			->setCellValue('AG1', 'Q18')
			->setCellValue('AH1', 'Q19')
			->setCellValue('AI1', 'Q20')
			->setCellValue('AJ1', 'Q21')
			->setCellValue('AK1', 'Q22')
			->setCellValue('AL1', 'Q23')
			->setCellValue('AM1', 'Q24.1')
			->setCellValue('AN1', 'Q24.2')
			->setCellValue('AO1', 'Q24.3.1')
			->setCellValue('AP1', 'Q24.3.2')
			->setCellValue('AQ1', 'Q24.3.3')
			->setCellValue('AR1', 'Q24.3.4')
			->setCellValue('AS1', 'Q24.4')
			->setCellValue('AT1', 'Q24.5')
			->setCellValue('AU1', 'Q24.6')
			->setCellValue('AV1', 'Q24.7')
			->setCellValue('AW1', 'Q24.8.1')
			->setCellValue('AX1', 'Q24.8.2');
			

include('../lib/class.function.php');
$con = new Cfunction();
$sql = 'SELECT SUBSTR(question_date,5,4) as question_date,question_id,question_firstname,question_lastname,question_idcard_detail';
$sql .= ',question_address,question_village,question_street,question_phone';
$sql .= ',getCCAA(LEFT(question_parish,6)) as question_parishname,getCCAA(LEFT(question_district,4)) as question_districtname,getCCAA(LEFT(question_province,2)) as question_provincename';
$sql .= ',question_parish,question_district,question_province';
$sql .= ',question_sex,question_birthday,question_age,question_typehome,question_education,question_career,question_land';
$sql .= ',question_Income,question_religion,question_status,question_structure,question_defective';
$sql .= ',question_residents_1t,question_residents_2t,question_residents_3t,question_residents_4t,question_residents_5t';
$sql .= ',question_debt,question_24_1,question_24_2,question_24_3_1,question_24_3_2,question_24_3_3,question_24_3_4';
$sql .= ',question_24_4,question_24_5,question_24_6,question_24_7,question_24_8_1,question_24_8_2,question_round';
$sql .= ' FROM question_detail_1';
$con->connectDB();
$results = $con->select($sql);

$i = 0;
$j = 1;
foreach($results as $row){	
	///*------------------------------------------------------------------------- Q10 */
//	$career = $row['question_career'];
//	$career = json_decode($career);
//	@$career = $structureFamily_detail = implode(',',$career);
//	
//	/*------------------------------------------------------------------------- Q16 */
//	$defective = $row['question_defective'];
//	if($defective=='1'){$defective='ไม่มี';}else{$defective='มี';}
//	
//	/*------------------------------------------------------------------------- Q17 */
//	/*$residents = $row['question_residents'];
//	$data = explode(',',$residents);
//	$residents_1='';
//	$residents_2='';
//	$residents_3='';
//	$residents_4='';
//	$residents_5='';
//	if($data[2]!=0){$residents_1= $data[2];}
//	if($data[5]!=0){$residents_2 = $data[5];}
//	if($data[8]!=0){$residents_3= $data[8];}
//	if($data[11]!=0){$residents_4 = $data[11];}
//	if($data[14]!=0){$residents_5 = $data[14];}*/
//	$question_residents_1t = $row['question_residents_1t'];
//	$question_residents_2t = $row['question_residents_2t'];
//	$question_residents_3t = $row['question_residents_3t'];
//	$question_residents_4t = $row['question_residents_4t'];
//	$question_residents_5t = $row['question_residents_5t'];
//	
//	$residents_1='';
//	$residents_2='';
//	$residents_3='';
//	$residents_4='';
//	$residents_5='';
//	
//	if($question_residents_1t>0){$residents_1= $row['question_residents_1t'];}
//	if($question_residents_2t>0){$residents_2= $row['question_residents_2t'];}
//	if($question_residents_3t>0){$residents_3= $row['question_residents_3t'];}
//	if($question_residents_4t>0){$residents_4= $row['question_residents_4t'];}
//	if($question_residents_5t>0){$residents_5= $row['question_residents_5t'];}
//	
//	/*------------------------------------------------------------------------- Q18 */
//	$question_debt = $row['question_debt'];
//	if($question_debt==1)
//	{
//		$question_debt = 2;
//	}
//	elseif($question_debt==2)
//	{
//		$question_debt_sub = $row['question_debt_sub'];
//		if($question_debt_sub==1)
//		{
//			$question_debt = 1;
//		}
//		else
//		{
//			$question_debt = 0;
//		}
//	}
//	else
//	{
//		$question_debt = '';
//	}
//	
//	/*------------------------------------------------------------------------- Q19-Q23 */
//	$sql_tbl2 = "SELECT tbl2_type,tbl2_problem,tbl2_help";
//	$sql_tbl2 .= " FROM question_tbl2";
//	$sql_tbl2 .= " WHERE main_id=".$row['question_id'];
//	$sql_tbl2 .= " group by tbl2_type";
//	$results_tbl2 = $con->select($sql_tbl2);
//	$Q19 = '';
//	$Q20 = '';
//	$Q21 = '';
//	$Q22 = '';
//	$Q23 = '';
//	if($results_tbl2!=null)
//	{
//		foreach($results_tbl2 as $rd)
//		{
//			if(($rd['tbl2_problem']=='')or($rd['tbl2_help']==''))
//			{
//				if($rd['tbl2_type']==1)
//				{
//					$Q19 = 1;
//				}
//				elseif($rd['tbl2_type']==2)
//				{
//					$Q20 = 1;
//				}
//				elseif($rd['tbl2_type']==3)
//				{
//					$Q21 = 1;
//				}
//				elseif($rd['tbl2_type']==4)
//				{
//					$Q22 = 1;
//				}
//				elseif($rd['tbl2_type']==5)
//				{
//					$Q23 = 1;
//				}
//			}
//			else
//			{
//				if($rd['tbl2_type']==1)
//				{
//					$Q19 = 0;
//				}
//				elseif($rd['tbl2_type']==2)
//				{
//					$Q20 = 0;
//				}
//				elseif($rd['tbl2_type']==3)
//				{
//					$Q21 = 0;
//				}
//				elseif($rd['tbl2_type']==4)
//				{
//					$Q22 = 0;
//				}
//				elseif($rd['tbl2_type']==5)
//				{
//					$Q23 = 0;
//				}
//			}
//		}
//	}
//	
//	/*------------------------------------------------------------------------- Q24.1 */
//	$Q24_1 = $row['question_24_1'];
//	if($Q24_1==1){$Q24_1=0;}else{$Q24_1=1;}
//	
//	/*------------------------------------------------------------------------- Q24.2 */
//	$Q24_2 = $row['question_24_2'];
//	if($Q24_2==1){$Q24_2=1;}else{$Q24_2=0;}
//	
//	/*------------------------------------------------------------------------- Q24.3.1 */
//	$question_24_3_1 = $row['question_24_3_1'];
//	$question_24_3_2 = $row['question_24_3_2'];
//	$question_24_3_3 = $row['question_24_3_3'];
//	$question_24_3_4 = $row['question_24_3_4'];
//
//	if($question_24_3_1==1){$Q24_3_1=1;}else{$Q24_3_1=0;}
//	if($question_24_3_2==1){$Q24_3_2=1;}else{$Q24_3_2=0;}
//	if($question_24_3_3==1){$Q24_3_3=1;}else{$Q24_3_3=0;}
//	if($question_24_3_4==1){$Q24_3_4=1;}else{$Q24_3_4=0;}
//	
//	/*------------------------------------------------------------------------- Q24.4 */
//	$Q24_4 = $row['question_24_4'];
//	if($Q24_4==1){$Q24_4=2;}elseif($Q24_4==2){$Q24_4=1;}else{$Q24_4=0;}
//	
//	/*------------------------------------------------------------------------- Q24.5 */
//	$Q24_5 = $row['question_24_5'];
//	if($Q24_5==1){$Q24_5=0;}else{$Q24_5=1;}
//	
//	/*------------------------------------------------------------------------- Q24.6 */
//	$Q24_6 = $row['question_24_6'];
//	if($Q24_6==1){$Q24_6=0;}else{$Q24_6=1;}
//	
//	/*------------------------------------------------------------------------- Q24.7 */
//	$Q24_7 = $row['question_24_7'];
//	if($Q24_7==1){$Q24_7=1;}else{$Q24_7=0;}
//	
//	/*------------------------------------------------------------------------- Q24.8 */
//	$question_24_8_1 = $row['question_24_8_1'];
//	$question_24_8_2 = $row['question_24_8_2'];
//	if($question_24_8_1==1){$Q24_8_1=1;}else{$Q24_8_1=0;}
//	if($question_24_8_2==1){$Q24_8_2=1;}else{$Q24_8_2=0;}
//	
//	$i++;
//	$j++;
//	$question_idcard_detail = $row['question_idcard_detail'];
//	$question_firstname = $row['question_firstname'];
//	$question_lastname = $row['question_lastname'];
//	$question_career = $career;
//	$question_Income = $row['question_Income'];
//	$question_defective = $defective;

	
	$j++;
	$i ++;
	$question_round = $row['question_round'];
	$question_date = $row['question_date'];
	$question_idcard_detail = $row['question_idcard_detail'];
	$question_firstname = $row['question_firstname'];
	$question_lastname = $row['question_lastname'];
	
	$question_address = $row['question_address'];
	$question_village = $row['question_village'];
	$question_street = $row['question_street'];
	$question_parish = $row['question_parish'];
	$question_district = $row['question_district'];
	$question_province = $row['question_province'];
	
	$question_parishname = $row['question_parishname'];
	$question_districtname = $row['question_districtname'];
	$question_provincename = $row['question_provincename'];
	
	$question_phone = $row['question_phone'];
	
	$question_sex = $row['question_sex'];
	$question_birthday = $row['question_birthday'];
	$question_age = $row['question_age'];
	
	$question_education = $row['question_education']; 	//9
	$question_career = $row['question_career'];				//10
	$question_career = json_decode($question_career);
	@$question_career = implode(',',$question_career);
	$question_land = $row['question_land']; 	//11
	$question_Income = $row['question_Income']; 	//12
	$question_religion = $row['question_religion']; 	//13
	$question_status = $row['question_status']; 	//14
	$question_structure = $row['question_structure']; 	//15
	$question_defective = $row['question_defective']; 	//16
	$question_residents_1t = $row['question_residents_1t']; 	//17.1
	$question_residents_2t = $row['question_residents_2t']; 	//17.2
	$question_residents_3t = $row['question_residents_3t']; 	//17.3
	$question_residents_4t = $row['question_residents_4t']; 	//17.4
	$question_residents_5t = $row['question_residents_5t']; 	//17.5
	$question_debt = $row['question_debt']; 	//18
	
	//	/*------------------------------------------------------------------------- Q19-Q23 */
	$sql_tbl2 = "SELECT tbl2_type,tbl2_problem,tbl2_help";
	$sql_tbl2 .= " FROM question_tbl2";
	$sql_tbl2 .= " WHERE main_id=".$row['question_id'];
	$sql_tbl2 .= " group by tbl2_type";
	$results_tbl2 = $con->select($sql_tbl2);
	$Q19 = '';
	$Q20 = '';
	$Q21 = '';
	$Q22 = '';
	$Q23 = '';
	if($results_tbl2!=null)
	{
		foreach($results_tbl2 as $rd)
		{
			if(($rd['tbl2_problem']=='')or($rd['tbl2_help']==''))
			{
				if($rd['tbl2_type']==1)
				{
					$Q19 = 1;
				}
				elseif($rd['tbl2_type']==2)
				{
					$Q20 = 1;
				}
				elseif($rd['tbl2_type']==3)
				{
					$Q21 = 1;
				}
				elseif($rd['tbl2_type']==4)
				{
					$Q22 = 1;
				}
				elseif($rd['tbl2_type']==5)
				{
					$Q23 = 1;
				}
			}
			else
			{
				if($rd['tbl2_type']==1)
				{
					$Q19 = 0;
				}
				elseif($rd['tbl2_type']==2)
				{
					$Q20 = 0;
				}
				elseif($rd['tbl2_type']==3)
				{
					$Q21 = 0;
				}
				elseif($rd['tbl2_type']==4)
				{
					$Q22 = 0;
				}
				elseif($rd['tbl2_type']==5)
				{
					$Q23 = 0;
				}
			}
		}
	}
	
	$question_24_1 = $row['question_24_1']; 	//24.1
	$question_24_2 = $row['question_24_2']; 	//24.2
	$question_24_3_1 = $row['question_24_3_1']; 	//24.3.1
	$question_24_3_2 = $row['question_24_3_2']; 	//24.3.2
	$question_24_3_3 = $row['question_24_3_3']; 	//24.3.3
	$question_24_3_4 = $row['question_24_3_4']; 	//24.3.4
	$question_24_4 = $row['question_24_4']; 	//24.4
	$question_24_5 = $row['question_24_5']; 	//24.5
	$question_24_6 = $row['question_24_6']; 	//24.6
	$question_24_7 = $row['question_24_7']; 	//24.7
	$question_24_8_1 = $row['question_24_8_1']; 	//24.8.1
	$question_24_8_2 = $row['question_24_8_2']; 	//24.8.2

	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('A'.$j,$i);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('B'.$j,$question_date);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('C'.$j,$question_round);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('D'.$j,$question_idcard_detail);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('E'.$j,$question_firstname);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('F'.$j,$question_lastname);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('G'.$j,$question_address);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('H'.$j,$question_village);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('I'.$j,$question_street);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('J'.$j,$question_parish);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('K'.$j,$question_parishname);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('L'.$j,$question_district);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('M'.$j,$question_districtname);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('N'.$j,$question_province);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('O'.$j,$question_provincename);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('P'.$j,$question_phone);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('Q'.$j,$question_sex);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('R'.$j,$question_birthday);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('S'.$j,$question_age);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('T'.$j,$question_education);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('U'.$j,$question_career);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('V'.$j,$question_land);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('W'.$j,$question_Income);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('X'.$j,$question_religion);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('Y'.$j,$question_status);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('Z'.$j,$question_structure);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AA'.$j,$question_defective);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AB'.$j,$question_residents_1t);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AC'.$j,$question_residents_2t);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AD'.$j,$question_residents_3t);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AE'.$j,$question_residents_4t);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AF'.$j,$question_residents_5t);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AG'.$j,$question_debt);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AH'.$j,$Q19);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AI'.$j,$Q20);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AJ'.$j,$Q21);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AK'.$j,$Q22);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AL'.$j,$Q23);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AM'.$j,$question_24_1);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AN'.$j,$question_24_2);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AO'.$j,$question_24_3_1);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AP'.$j,$question_24_3_2);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AQ'.$j,$question_24_3_3);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AR'.$j,$question_24_3_4);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AS'.$j,$question_24_4);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AT'.$j,$question_24_5);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AU'.$j,$question_24_6);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AV'.$j,$question_24_7);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AW'.$j,$question_24_8_1);
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('AX'.$j,$question_24_8_2);
}
// Miscellaneous glyphs, UTF-8
/*$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('A2',2);
$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('A3',2);
$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('A4',2);*/


// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('คะแนนดิบรายคน');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="report'.date('Y').date('m').date('d').'.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
