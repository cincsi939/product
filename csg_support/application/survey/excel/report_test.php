<?php
###################################################################
## CLASS 
###################################################################
## Version :		20100414.001 (Created/Modified; Date.RunNumber)
## Created Date :		2010-04-28 10:09
## Created By :		Mr.KIDSANA PANYA (JENG)
## E-mail :			kidsana@sapphire.co.th
## Tel. :			
## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
		include('../lib/class.function.php');
 		$con = new Cfunction();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>HTML TO EXCEL</title>
<script src="http://61.19.255.77/html2excel_service/js/jquery.html2excel.js"></script>
<script src="http://61.19.255.77/html2excel_service/js/jquery.min.js"></script>	
<body > 
<a href="javascript:void()" onClick="html2excel('tbl_dashboard1','http://61.19.255.77/html2excel_service/html2excel.php','รายงาน','0')" >ส่งออกเป็น Excel</a>
<table width="99%" border="0" cellpadding="3" cellspacing="1" align="center" id="tbl_dashboard1">
          <tr>
               <th >ลำดับ</th>
              <th >เลขบัตรประชาชน</th>
              <th >คำนำหน้าชื่อ</th>
              <th >ชื่อหัวหน้าครอบครัว</th>
              <th >สกุลหัวหน้าครอบครัว</th>
              <th >ชื่อ-สกุลหัวหน้าครอบครัว</th>
              <th >ชุดคำถามที่สำรวจ</th>
              <th >รอบที่สำรวจ</th>
              <th >ปีที่สำรวจ</th>
              <th >บ้านเลขที่</th>
              <th >ตำบล</th>
              <th >อำเภอ</th>
              <th >จังหวัด</th>
              <th >Q4</th>
              <th >Q5</th>
              <th >Q6</th>
              <th >Q7</th>
              <th >Q8</th>
              <th >Q9</th>
              <th >Q10</th>
              <th >Q11</th>
              <th >Q12</th>
              <th >Q13</th>
              <th >Q14</th>
              <th >Q15</th>
              <th >Q16</th>
              <th >Q17.1</th>
              <th >Q17.2</th>
              <th >Q17.3</th>
              <th >Q17.4</th>
              <th >Q17.5</th>
              <th >Q18</th>
              <th >Q19</th>
              <th >Q20</th>
              <th >Q21</th>
              <th >Q22</th>
              <th >Q23</th>
              <th >Q24.1</th>
              <th >Q24.2</th>
              <th >Q24.3.1</th>
              <th >Q24.3.2</th>
              <th >Q24.3.3</th>
              <th >Q24.3.4</th>
              <th >Q24.4</th>
              <th >Q24.5</th>
              <th >Q24.6</th>
              <th >Q24.7</th>
              <th >Q24.8.1</th>
              <th >Q24.8.2</th>
              <th >รหัสตำบล</th>
              <th >รหัสอำเภอ</th>
              <th >รหัสจังหวัด</th>
               <th >วันที่บันทึกข้อมูล</th>
             
            </tr>
                    <?php

		$sql = 'SELECT RIGHT(question_date,4) as question_year,question_date,question_id,question_firstname,question_lastname,question_idcard_detail';
		$sql .= ',question_address,question_village,question_street,question_phone';
		$sql .= ',getCCAA(LEFT(question_parish,6)) as question_parishname,getCCAA(LEFT(question_district,4)) as question_districtname,getCCAA(LEFT(question_province,2)) as question_provincename';
		$sql .= ',question_parish,question_district,question_province';
		$sql .= ',question_sex,question_birthday,question_age,question_typehome,question_stypehome_1,question_stypehome_2,question_stypehome_3,question_environment,question_education,question_career,question_land';
		$sql .= ',question_Income,question_religion,question_status,question_structure,question_defective';
		$sql .= ',question_residents_1t,question_residents_2t,question_residents_3t,question_residents_4t,question_residents_5t';
		$sql .= ',question_debt,question_24_1,question_24_2,question_24_3_1,question_24_3_2,question_24_3_3,question_24_3_4';
		$sql .= ',question_24_4,question_24_5,question_24_6,question_24_7,question_24_8_1,question_24_8_2,question_round,prename_th';
		$sql .= ' FROM question_detail_1 inner join tbl_prename on tbl_prename.id = question_detail_1.question_prename';
		$con->connectDB();
		$results = $con->select($sql);
		
		$i = 0;
		$j = 1;
		foreach($results as $row){			
			$j++;
			$i ++;
			$question_round = $row['question_round'];
			$question_date = $row['question_date'];
			$question_year = $row['question_year'];
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
			
				/*------------------------------------------------------------------------- Q19-Q23 */
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
			
			$question_prename = $row['prename_th'];
			$question_typehome = $row['question_typehome'];
			$question_stypehome = $row['question_stypehome_1'].','.$row['question_stypehome_2'].','.$row['question_stypehome_3'];
			$question_environment = $row['question_environment'];
			$question_address = $row['question_address'];
			
			$question_parish = $row['question_parish'];
			$question_district = $row['question_district'];
			$question_province = $row['question_province'];
		?><tr>
               	<td align="center" valign="top"><?php echo $i; ?></td>
           	  <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_idcard_detail); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_prename); ?></td>
              <td align="left" valign="top"><?php echo iconv("utf-8","tis-620",$question_firstname); ?></td>
              <td align="left" valign="top"><?php echo iconv("utf-8","tis-620",$question_lastname); ?></td>
              <td align="left" valign="top"><?php echo iconv("utf-8","tis-620",$question_prename.' '.$question_firstname.' '.$question_lastname); ?></td>
              <td align="center" valign="top">1</td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_round); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_year); ?></td>
              <td align="left" valign="top"><?php echo iconv("utf-8","tis-620",$question_address); ?></td>
              <td align="left" valign="top"><?php echo iconv("utf-8","tis-620",$question_parishname); ?></td>
              <td align="left" valign="top"><?php echo iconv("utf-8","tis-620",$question_districtname); ?></td>
              <td align="left" valign="top"><?php echo iconv("utf-8","tis-620",$question_provincename); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_sex); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_age); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_typehome); ?></td>
              <td align="left" valign="top"><?php echo iconv("utf-8","tis-620",$question_stypehome); ?></td>
              <td align="left" valign="top"><?php echo iconv("utf-8","tis-620",$question_environment); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_education); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_career); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_land); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_Income); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_religion); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_status); ?></td>
            <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_structure); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_defective); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_residents_1t); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_residents_2t); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_residents_3t); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_residents_4t); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_residents_5t); ?></td>
              <td align="center" valign="top"><?php echo iconv("utf-8","tis-620",$question_debt); ?></td>
              <td align="center" valign="top"><?php echo $Q19; ?></td>
              <td align="center" valign="top"><?php echo $Q20; ?></td>
              <td align="center" valign="top"><?php echo $Q21; ?></td>
              <td align="center" valign="top"><?php echo $Q22; ?></td>
              <td align="center" valign="top"><?php echo $Q23; ?></td>
              <td align="center" valign="top"><?php echo $question_24_1; ?></td>
              <td align="center" valign="top"><?php echo $question_24_2; ?></td>
              <td align="center" valign="top"><?php echo $question_24_3_1; ?></td>
              <td align="center" valign="top"><?php echo $question_24_3_2; ?></td>
              <td align="center" valign="top"><?php echo $question_24_3_3; ?></td>
              <td align="center" valign="top"><?php echo $question_24_3_4; ?></td>
              <td align="center" valign="top"><?php echo $question_24_4; ?></td>
              <td align="center" valign="top"><?php echo $question_24_5; ?></td>
              <td align="center" valign="top"><?php echo $question_24_6; ?></td>
              <td align="center" valign="top"><?php echo $question_24_7; ?></td>
              <td align="center" valign="top"><?php echo $question_24_8_1; ?></td>
                <td align="center" valign="top"><?php echo $question_24_8_2; ?></td>
                <td align="center" valign="top"><?php echo $question_parish; ?></td>
                <td align="center" valign="top"><?php echo $question_district; ?></td>
                <td align="center" valign="top"><?php echo $question_province; ?></td>
                <td align="center" valign="top"><?php echo $question_date; ?></td>

           
            </tr>
            <?php
				}
			?>
      </table>
</body>
</html>
