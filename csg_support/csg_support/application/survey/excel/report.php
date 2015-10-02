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
            	<th bgcolor="#FFCCFF"><?php echo iconv('TIS-620', 'UTF-8', 'ลำดับ');?></th>
              <th bgcolor="#FFCCFF"><?php echo iconv('TIS-620', 'UTF-8', 'เลขบัตรประชาชน');?></th>
              <th bgcolor="#FFCCFF"><?php echo iconv('TIS-620', 'UTF-8', 'คำนำหน้าชื่อ');?></th>
              <th bgcolor="#FFCCFF"><?php echo iconv('TIS-620', 'UTF-8', 'ชื่อหัวหน้าครอบครัว');?></th>
              <th bgcolor="#FFCCFF"><?php echo iconv('TIS-620', 'UTF-8', 'สกุลหัวหน้าครอบครัว');?></th>
              <th bgcolor="#FFCCFF"><?php echo iconv('TIS-620', 'UTF-8', 'ชื่อ-สกุลหัวหน้าครอบครัว');?></th>
              <th bgcolor="#FFCCFF"><?php echo iconv('TIS-620', 'UTF-8', 'ชุดคำถามที่สำรวจ');?></th>
              <th bgcolor="#FFCCFF"><?php echo iconv('TIS-620', 'UTF-8', 'รอบที่สำรวจ');?></th>
              <th bgcolor="#FFCCFF"><?php echo iconv('TIS-620', 'UTF-8', 'ปีที่สำรวจ');?></th>
              <th bgcolor="#FFCCFF"><?php echo iconv('TIS-620', 'UTF-8', 'บ้านเลขที่');?></th>
              <th bgcolor="#FFCCFF"><?php echo iconv('TIS-620', 'UTF-8', 'ตำบล');?></th>
              <th bgcolor="#FFCCFF"><?php echo iconv('TIS-620', 'UTF-8', 'อำเภอ');?></th>
              <th bgcolor="#FFCCFF"><?php echo iconv('TIS-620', 'UTF-8', 'จังหวัด');?></th>
              <th bgcolor="#FFCCFF">Q4</th>
              <th bgcolor="#FFCCFF">&nbsp;</th>
              <th bgcolor="#FFCCFF">Q5</th>
              <th bgcolor="#FFCCFF">Q6</th>
              <th bgcolor="#FFCCFF">Q7</th>
              <th bgcolor="#FFCCFF">Q8</th>
              <th bgcolor="#FFCCFF">Q9</th>
              <th bgcolor="#FFCCFF">Q10</th>
              <th bgcolor="#FFCCFF">&nbsp;</th>
              <th bgcolor="#FFCCFF">Q11</th>
              <th bgcolor="#FFCCFF">Q12</th>
              <th bgcolor="#FFCCFF">Q13</th>
              <th bgcolor="#FFCCFF">Q14</th>
              <th bgcolor="#FFCCFF">Q15</th>
              <th bgcolor="#FFCCFF">Q16</th>
              <th bgcolor="#FFCCFF">Q17.1</th>
              <th bgcolor="#FFCCFF">Q17.2</th>
              <th bgcolor="#FFCCFF">Q17.3</th>
              <th bgcolor="#FFCCFF">Q17.4</th>
              <th bgcolor="#FFCCFF">Q17.5</th>
              <th bgcolor="#FFCCFF">Q18</th>
              <th bgcolor="#FFCCFF">Q19</th>
              <th bgcolor="#FFCCFF">Q20</th>
              <th bgcolor="#FFCCFF">Q21</th>
              <th bgcolor="#FFCCFF">Q22</th>
              <th bgcolor="#FFCCFF">Q23</th>
              <th bgcolor="#FFCCFF">Q24.1</th>
              <th bgcolor="#FFCCFF">Q24.2</th>
              <th bgcolor="#FFCCFF">Q24.3.1</th>
              <th bgcolor="#FFCCFF">Q24.3.2</th>
              <th bgcolor="#FFCCFF">Q24.3.3</th>
              <th bgcolor="#FFCCFF">Q24.3.4</th>
              <th bgcolor="#FFCCFF">Q24.4</th>
              <th bgcolor="#FFCCFF">Q24.5</th>
              <th bgcolor="#FFCCFF">Q24.6</th>
              <th bgcolor="#FFCCFF">Q24.7</th>
              <th bgcolor="#FFCCFF">Q24.8.1</th>
              <th bgcolor="#FFCCFF">Q24.8.2</th>
              <th bgcolor="#FFCCFF"><?php echo iconv('TIS-620', 'UTF-8', 'รหัสตำบล');?></th>
              <th bgcolor="#FFCCFF"><?php echo iconv('TIS-620', 'UTF-8', 'รหัสอำเภอ');?></th>
              <th bgcolor="#FFCCFF"><?php echo iconv('TIS-620', 'UTF-8', 'รหัสจังหวัด');?></th>
               <th bgcolor="#FFCCFF"><?php echo iconv('TIS-620', 'UTF-8', 'วันที่บันทึกข้อมูล');?></th>
            </tr>
        </thead>
        <tbody>
        <?php 
			include('../lib/class.function.php');
			$con = new Cfunction();
			$sql = "select eq_prename,eq_idcard,eq_date_create,eq_year,eq_address,eq_village,eq_street,eq_parish,eq_district,eq_province,eq_code_parish,eq_code_district,eq_code_province,eq_code_career,getCountType(1,eq_idcard) as Q19,getCountType(2,eq_idcard) as Q20,getCountType(3,eq_idcard) as Q21,getCountType(4,eq_idcard) as Q22,getCountType(5,eq_idcard) as Q23 from eq_person where eq_type = 0 GROUP BY eq_idcard ";
			$con->connectDB();
			$results = $con->select($sql);
			
		foreach($results as $rt){	
			$date = new DateTime($rt['eq_date_create']);
			$sql_db = "select siteid,form_id,number_action,pin,child_userid,vid,yy,mm,value,updatetime from eq_var_data where siteid=1 AND form_id !=2 AND pin='".$rt['eq_idcard']."'";
			$results_db = $con->select($sql_db);
			$row = array();
			foreach($results_db as $rd)
			{
				$row[$rd['vid']] = $rd['value'];
			}	
			$j++;
			$i ++;
			$question_round = 1;
			$question_date = $date->format('Y-m-d');
			$question_year = $rt['eq_year'];
			$question_idcard_detail = $rt['eq_idcard'];
			$question_firstname = $row[1];
			$question_lastname = $row[2];
			
			$question_address = $rt['eq_address'];
			$question_village = $rt['eq_village'];
			$question_street = $rt['eq_street'];
			$question_parish = $rt['eq_code_parish'];
			$question_district = $rt['eq_code_district'];
			$question_province = $rt['eq_code_province'];
			
			$question_parishname = $rt['eq_parish'];
			$question_districtname = $rt['eq_district'];
			$question_provincename = $rt['eq_province'];
			
			$question_phone = $row[11];
			
			$question_sex = $row[12];
			$question_birthday = $row[377];
			$question_age = $row[14];
			
			$question_education = $row[22]; 	//9
			$question_career = $rt['eq_code_career'];				//10
			//$question_career = json_decode($question_career);
			//@$question_career = implode(',',$question_career);
			$question_land = $row[34]; 	//11
			$question_Income = $row[36]; 	//12
			$question_religion = $row[37]; 	//13
			$question_status = $row[39]; 	//14
			$question_structure = $row[41]; 	//15
			$question_defective = $row[55]; 	//16
			$question_residents_1t = $row[64]; 	//17.1
			$question_residents_2t = $row[67]; 	//17.2
			$question_residents_3t = $row[70]; 	//17.3
			$question_residents_4t = $row[73]; 	//17.4
			$question_residents_5t = $row[76]; 	//17.5
			$question_debt = $row[80]; 	//18
			
			//	/*------------------------------------------------------------------------- Q19-Q23 */
			$Q19 = $rt['Q19'];
			$Q20 = $rt['Q20'];
			$Q21 = $rt['Q21'];
			$Q22 = $rt['Q22'];
			$Q23 = $rt['Q23'];
			//$sql_tbl2 = "SELECT tbl2_type,tbl2_problem,tbl2_help";
//			$sql_tbl2 .= " FROM question_tbl2";
//			$sql_tbl2 .= " WHERE main_id=".$row['question_id'];
//			$sql_tbl2 .= " group by tbl2_type";
//			$results_tbl2 = $con->select($sql_tbl2);
//			$Q19 = '';
//			$Q20 = '';
//			$Q21 = '';
//			$Q22 = '';
//			$Q23 = '';
			
			//echo "<pre>".print_r($results_tbl2);
			//if($results_tbl2!=null)
//			{
//				foreach($results_tbl2 as $rd)
//				{
//					if(($rd['tbl2_problem']=='')or($rd['tbl2_help']==''))
//					{
//						if($rd['tbl2_type']==1)
//						{
//							$Q19 = 1;
//						}
//						elseif($rd['tbl2_type']==2)
//						{
//							$Q20 = 1;
//						}
//						elseif($rd['tbl2_type']==3)
//						{
//							$Q21 = 1;
//						}
//						elseif($rd['tbl2_type']==4)
//						{
//							$Q22 = 1;
//						}
//						elseif($rd['tbl2_type']==5)
//						{
//							$Q23 = 1;
//						}
//					}
//					else
//					{
//						if($rd['tbl2_type']==1)
//						{
//							$Q19 = 0;
//						}else{
//							$Q19 = 1;	
//						}
//						if($rd['tbl2_type']==2)
//						{
//							$Q20 = 0;
//						}else{
//							$Q20 = 1;
//						}
//						if($rd['tbl2_type']==3)
//						{
//							$Q21 = 0;
//						}else{
//							$Q21 = 1;
//						}
//						if($rd['tbl2_type']==4)
//						{
//							$Q22 = 0;
//						}else{
//							$Q22 = 1;
//						}
//						if($rd['tbl2_type']==5)
//						{
//							$Q23 = 0;
//						}else{
//							$Q23 = 1;
//						}
//					}
//				}
//			}
			
			$question_24_1 = $row[343]; 	//24.1
			$question_24_2 = $row[350]; 	//24.2
			$question_24_3_1 = $row[352]; 	//24.3.1
			$question_24_3_2 = $row[354]; 	//24.3.2
			$question_24_3_3 = $row[356]; 	//24.3.3
			$question_24_3_4 = $row[358]; 	//24.3.4
			$question_24_4 = $row[360]; 	//24.4
			$question_24_5 = $row[361]; 	//24.5
			$question_24_6 = $row[368]; 	//24.6
			$question_24_7 = $row[369]; 	//24.7
			$question_24_8_1 = $row[372]; 	//24.8.1
			$question_24_8_2 = $row[374]; 	//24.8.2
			
			$question_prename = $rt['eq_prename'];
			$question_typehome = $row[15];
			$question_stypehome = $row[18].','.$row[19].','.$row[20];
			$question_environment = $row[21];
			
			//$question_parish = $row['question_parish'];
//			$question_district = $row['question_district'];
//			$question_province = $row['question_province'];
		?>
        	<tr>
            	<td align="center" valign="top"><?php echo $i; ?></td>
           	  <td align="center" valign="top"><?php echo $question_idcard_detail; ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_prename); ?></td>
              <td align="left" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_firstname); ?></td>
              <td align="left" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_lastname); ?></td>
              <td align="left" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_prename.' '.$question_firstname.' '.$question_lastname); ?></td>
              <td align="center" valign="top">1</td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_round); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_year); ?></td>
              <td align="left" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_address); ?></td>
              <td align="left" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_parishname); ?></td>
              <td align="left" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_districtname); ?></td>
              <td align="left" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_provincename); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_sex); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_age); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_typehome); ?></td>
              <td align="left" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_stypehome); ?></td>
              <td align="left" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_environment); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_education); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_career); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8',$question_land); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_Income); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_religion); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_status); ?></td><!--14-->
            <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_structure); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_defective); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_residents_1t); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_residents_2t); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_residents_3t); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_residents_4t); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_residents_5t); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $question_debt); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $Q19); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $Q20); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $Q21); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $Q22); ?></td>
              <td align="center" valign="top"><?php echo iconv('TIS-620', 'UTF-8', $Q23); ?></td>
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
        </tbody>
</TABLE>
        
