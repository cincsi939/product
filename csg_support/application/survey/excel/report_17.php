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
 header ('Content-type: text/html; charset=tis-620'); 
 header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=report".date('Y').date('m').date('d').".xls");
 ?>
 <meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<table border="1">
	<tr>
	  <td align="center">&nbsp;</td>
	  <td colspan="17" align="center">ข้อ 17</td>
	  <td colspan="16"  align="center">กลุ่มเป้าหมาย</td>
  </tr>
	<tr>
    	<td rowspan="2" align="center">ลำดับ</td>
        <td rowspan="2" align="center">ชื่อหัวหน้าครอบครัว</td>
        <td colspan="3"  align="center">เด็ก</td>
        <td colspan="3"  align="center">เยาวชน</td>
        <td colspan="3"  align="center">วัยแรงงาน</td>
        <td colspan="3"  align="center">ผู้สูงอายุ</td>
        <td colspan="3"  align="center">คนพิการ</td>
        <td rowspan="2"  align="center">รวมทั้งหมด</td>
        <td colspan="3"  align="center">เด็ก</td>
        <td colspan="3"  align="center">เยาวชน</td>
        <td colspan="3"  align="center">วัยแรงงาน</td>
        <td colspan="3"  align="center">ผู้สูงอายุ</td>
        <td colspan="3"  align="center">คนพิการ</td>
        <td rowspan="2"  align="center">รวมทั้งหมด</td>
    </tr>
	<tr>
	  <td  align="center">ชาย</td>
	  <td  align="center">หญิง</td>
	  <td  align="center">รวม</td>
	  <td  align="center">ชาย</td>
	  <td  align="center">หญิง</td>
	  <td  align="center">รวม</td>
	  <td  align="center">ชาย</td>
	  <td  align="center">หญิง</td>
	  <td  align="center">รวม</td>
	  <td  align="center">ชาย</td>
	  <td  align="center">หญิง</td>
	  <td  align="center">รวม</td>
	  <td  align="center">ชาย</td>
	  <td  align="center">หญิง</td>
	  <td  align="center">รวม</td>
	  <td  align="center">ชาย</td>
	  <td  align="center">หญิง</td>
	  <td  align="center">รวม</td>
	  <td  align="center">ชาย</td>
	  <td  align="center">หญิง</td>
	  <td  align="center">รวม</td>
	  <td  align="center">ชาย</td>
	  <td  align="center">หญิง</td>
	  <td  align="center">รวม</td>
	  <td  align="center">ชาย</td>
	  <td  align="center">หญิง</td>
	  <td  align="center">รวม</td>
	  <td  align="center">ชาย</td>
	  <td  align="center">หญิง</td>
	  <td  align="center">รวม</td>
  </tr>
  <?php
  		include('../lib/class.function.php');
		$con = new Cfunction();
		$sql ='SELECT getDetail(4,question_prename) as question_prename,question_firstname,question_lastname,';
		$sql .= 'question_residents_1,question_residents_1t,question_residents_2,question_residents_2t,question_residents_3,question_residents_3t,question_residents_4,question_residents_4t,question_residents_5,question_residents_5t,question_residents_tt,';
		$sql .= 'sum(IF((tbl2_sex=2 and tbl2_type=1),1,0)) as m_1,';
		$sql .= 'sum(IF((tbl2_sex=1 and tbl2_type=1),1,0)) as f_1,';
		$sql .= 'sum(IF((tbl2_type=1),1,0)) as t_1,';
		$sql .= 'sum(IF((tbl2_sex=2 and tbl2_type=2),1,0)) as m_2,';
		$sql .= 'sum(IF((tbl2_sex=1 and tbl2_type=2),1,0)) as f_2,';
		$sql .= 'sum(IF((tbl2_type=2),1,0)) as t_2,';
		$sql .= 'sum(IF((tbl2_sex=2 and tbl2_type=3),1,0)) as m_3,';
		$sql .= 'sum(IF((tbl2_sex=1 and tbl2_type=3),1,0)) as f_3,';
		$sql .= 'sum(IF((tbl2_type=3),1,0)) as t_3,';
		$sql .= 'sum(IF((tbl2_sex=2 and tbl2_type=4),1,0)) as m_4,';
		$sql .= 'sum(IF((tbl2_sex=1 and tbl2_type=4),1,0)) as f_4,';
		$sql .= 'sum(IF((tbl2_type=4),1,0)) as t_4,';
		$sql .= 'sum(IF((tbl2_sex=2 and tbl2_type=5),1,0)) as m_5,';
		$sql .= 'sum(IF((tbl2_sex=1 and tbl2_type=5),1,0)) as f_5,';
		$sql .= 'sum(IF((tbl2_type=5),1,0)) as t_5';
		$sql .= ' FROM question_detail_1 LEFT JOIN question_tbl2 ON question_detail_1.question_id = question_tbl2.main_id GROUP BY question_id';
		//echo $sql;
		
		$sumall_1 = 0;
		$sumall_2 = 0;
		$con->connectDB();
		$results = $con->select($sql);
		$i = 0;
		foreach($results as $row)
		{
			$i++;
			$name = $row['question_prename'].$row['question_firstname'].' '.$row['question_lastname'];
			$question_residents_1 = explode(',',$row['question_residents_1']);
			$question_residents_1t = $row['question_residents_1t'];
			$question_residents_2 = explode(',',$row['question_residents_2']);
			$question_residents_2t = $row['question_residents_2t'];
			$question_residents_3 = explode(',',$row['question_residents_3']);
			$question_residents_3t = $row['question_residents_3t'];
			$question_residents_4 = explode(',',$row['question_residents_4']);
			$question_residents_4t = $row['question_residents_4t'];
			$question_residents_5 = explode(',',$row['question_residents_5']);
			$question_residents_5t = $row['question_residents_5t'];
			
			$m_1 = $row['m_1'];
			$f_1 = $row['f_1'];
			$t_1 = $row['t_1'];
			
			$m_2 = $row['m_2'];
			$f_2 = $row['f_2'];
			$t_2 = $row['t_2'];
			
			$m_3 = $row['m_3'];
			$f_3 = $row['f_3'];
			$t_3 = $row['t_3'];
			
			$m_4 = $row['m_4'];
			$f_4 = $row['f_4'];
			$t_4 = $row['t_4'];
			
			$m_5 = $row['m_5'];
			$f_5 = $row['f_5'];
			$t_5 = $row['t_5'];
			
			$color = '#FFFFFF';
			
			if($question_residents_1[0]==''){$r_1a = 0;}else{$r_1a = $question_residents_1[0];}
			if($question_residents_1[1]==''){$r_1b = 0;}else{$r_1b = $question_residents_1[1];}
			if($question_residents_2[0]==''){$r_2a = 0;}else{$r_2a = $question_residents_2[0];}
			if($question_residents_2[1]==''){$r_2b = 0;}else{$r_2b = $question_residents_2[1];}
			if($question_residents_3[0]==''){$r_3a = 0;}else{$r_3a = $question_residents_3[0];}
			if($question_residents_3[1]==''){$r_3b = 0;}else{$r_3b = $question_residents_3[1];}
			if($question_residents_4[0]==''){$r_4a = 0;}else{$r_4a = $question_residents_4[0];}
			if($question_residents_4[1]==''){$r_4b = 0;}else{$r_4b = $question_residents_4[1];}
			if($question_residents_5[0]==''){$r_5a = 0;}else{$r_5a = $question_residents_5[0];}
			if($question_residents_5[1]==''){$r_5b = 0;}else{$r_5b = $question_residents_5[1];}
			
			/*if(($r_1a!=$m_1) or ($r_1b!=$f_1))
			{
				$color = '#FFFF00';
			}
			elseif(($r_2a!=$m_2) or ($r_2b!=$f_2))
			{
				$color = '#FFFF00';
			}
			elseif(($r_3a!=$m_3) or ($r_3b!=$f_3))
			{
				$color = '#FFFF00';
			}
			elseif(($r_4a!=$m_4) or ($r_4b!=$f_4))
			{
				$color = '#FFFF00';
			}
			elseif(($r_5a!=$m_5) or ($r_5b!=$f_5))
			{
				$color = '#FFFF00';
			}*/
			
			$color_1a = '#FFFFFF';
			$color_1b = '#FFFFFF';
			$color_1t = '#FFFFFF';
			$color_2a = '#FFFFFF';
			$color_2b = '#FFFFFF';
			$color_2t = '#FFFFFF';
			$color_3a = '#FFFFFF';
			$color_3b = '#FFFFFF';
			$color_3t = '#FFFFFF';
			$color_4a = '#FFFFFF';
			$color_4b = '#FFFFFF';
			$color_4t = '#FFFFFF';
			$color_5a = '#FFFFFF';
			$color_5b = '#FFFFFF';
			$color_5t = '#FFFFFF';
			
			if($r_1a>$m_1)
			{
				$color_1a = '#FFFF00';
			}
			
			if($r_1b>$f_1)
			{
				$color_1b = '#FFFF00';
			}
			
			if($question_residents_1t>$t_1)
			{
				$color_1t = '#FFFF00';
			}
			
			if($r_2a>$m_2)
			{
				$color_2a = '#FFFF00';
			}
			
			if($r_2b>$f_2)
			{
				$color_2b = '#FFFF00';
			}
			
			if($question_residents_2t>$t_2)
			{
				$color_2t = '#FFFF00';
			}
			
			if($r_3a>$m_3)
			{
				$color_3a = '#FFFF00';
			}
			
			if($r_3b>$f_3)
			{
				$color_3b = '#FFFF00';
			}
			
			if($question_residents_4t>$t_4)
			{
				$color_4t = '#FFFF00';
			}
			
			if($r_4a>$m_4)
			{
				$color_4a = '#FFFF00';
			}
			
			if($r_4b>$f_4)
			{
				$color_4b = '#FFFF00';
			}
			
			if($question_residents_4t>$t_4)
			{
				$color_4t = '#FFFF00';
			}
			
			if($r_5a>$m_5)
			{
				$color_5a = '#FFFF00';
			}
			
			if($r_5b>$f_5)
			{
				$color_5b = '#FFFF00';
			}
			
			if($question_residents_5t>$t_5)
			{
				$color_5t = '#FFFF00';
			}
			
			$sumall_1 = $question_residents_1t+$question_residents_2t+$question_residents_3t+$question_residents_4t+$question_residents_5t;
			$sumall_2 = $t_1+$t_2+$t_3+$t_4+$t_5;
			
			$color2 = '#FFFFFF';
			if($sumall_1>$sumall_2)
			{
				$color2 = 'FF0000';
			}
  ?>
	<tr <?php /*?>bgcolor="<?php echo $color; ?>"<?php */?>>
	  <td align="center"><?php echo $i; ?></td>
	  <td align="left"><?php echo $name; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_1a; ?>"><?php echo $r_1a; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_1b; ?>"><?php echo $r_1b; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_1t; ?>"><?php echo $question_residents_1t; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_2a; ?>"><?php echo $r_2a; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_2b; ?>"><?php echo $r_2b; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_2t; ?>"><?php echo $question_residents_2t; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_3a; ?>"><?php echo $r_3a; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_3b; ?>"><?php echo $r_3b; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_3t; ?>"><?php echo $question_residents_3t; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_4a; ?>"><?php echo $r_4a; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_4b; ?>"><?php echo $r_4b; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_4t; ?>"><?php echo $question_residents_4t; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_5a; ?>"><?php echo $r_5a; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_5b; ?>"><?php echo $r_5b; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_5t; ?>"><?php echo $question_residents_5t; ?></td>
	  <td  align="center" bgcolor="<?php echo $color2; ?>"><?php echo $sumall_1; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_1a; ?>"><?php echo $m_1; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_1b; ?>"><?php echo $f_1; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_1t; ?>"><?php echo $t_1; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_2a; ?>"><?php echo $m_2; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_2b; ?>"><?php echo $f_2; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_2t; ?>"><?php echo $t_2; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_3a; ?>"><?php echo $m_3; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_3b; ?>"><?php echo $f_3; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_3t; ?>"><?php echo $t_3; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_4a; ?>"><?php echo $m_4; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_4b; ?>"><?php echo $f_4; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_4t; ?>"><?php echo $t_4; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_5a; ?>"><?php echo $m_5; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_5b; ?>"><?php echo $f_5; ?></td>
	  <td  align="center" bgcolor="<?php echo $color_5t; ?>"><?php echo $t_5; ?></td>
	  <td  align="center" bgcolor="<?php echo $color2; ?>"><?php echo $sumall_2; ?></td>
  </tr>
  <?php
		}
  ?>
</table>
