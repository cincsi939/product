<?php
include "epm.inc.php";
?>
<html>
<head>
<title>application management</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<body >
<?php
	if($_GET['year'] != ''){ # ปีงบประมาณ เป็นปี พ.ศ.
		$psStart = $_GET['year'] - 1; # พ.ศ.
		$psEnd = $_GET['year'];
		$ksStart = $_GET['year'] - 544; # ค.ศ.
		$ksEnd = $_GET['year'] - 543;
		
		# เดือน (เรียงตามการแสดงผลแบบปีงบประมาณ)
		$sql = "SELECT
		t1.mm_id,
		IF(mm_id > 9,{$psStart},{$psEnd}) AS yy1
		FROM
		month_config AS t1
		ORDER BY t1.orderby ";
		$result = mysql_db_query('opp_data',$sql)or die(mysql_error());
		while($obj = mysql_fetch_object($result)){
			$monthList[$obj->mm_id] = $obj->yy1;
		}
		
		# นับจำนวนคนที่ลงทะเบียน
		$sql = "SELECT
		SUBSTR(t1.eq_register_date,1,4)+543 AS yy,
		SUBSTR(t1.eq_register_date,6,2)*1 AS mm,
		Count(t1.eq_idcard) AS num_regis,
		t3.areaid
		FROM
		opp_data.eq_person AS t1 
		LEFT JOIN opp_usermanager.org_staffgroup AS t2 ON t1.eq_gid = t2.gid
		LEFT JOIN opp_data.ccaa AS t3 ON IF(t2.tambon != '',t2.tambon,IF(t2.amphur != '',t2.amphur,t2.province))= t3.ccDigi
		WHERE t1.eq_register_date BETWEEN '{$ksStart }-10-01' AND '{$ksEnd}-09-30'
		GROUP BY t3.areaid ";
		$result = mysql_db_query('opp_data',$sql)or die(mysql_error());
		while($obj = mysql_fetch_object($result)){
			$numRegis[$obj->areaid][$obj->mm] = $obj->num_regis;
		}
		
		# นับจำนวนคนที่คลอด จำนวนบุตร และจำนวนเงินอุดหนุน
		$sql = "SELECT
		t1.eq_b4preg_birthyear AS yy,
		t1.eq_b4preg_birthmonth AS mm,
		Count(t1.eq_b4preg_birthmonth) AS sum,
		Sum(t1.eq_embryo_number) AS child,
		Sum(t1.eq_embryo_number) * 400 AS numpermonth,
		t3.areaid
		FROM
		eq_person AS t1
		INNER JOIN opp_usermanager.org_staffgroup AS t2 ON t1.eq_gid = t2.gid
		INNER JOIN opp_data.ccaa AS t3 ON IF(t2.tambon != '',t2.tambon,IF(t2.amphur != '',t2.amphur,t2.province))= t3.ccDigi
		INNER JOIN opp_data.ccaa AS tambon ON t3.areaid = tambon.areaid
		INNER JOIN opp_data.ccaa AS amphur ON CONCAT(SUBSTR(tambon.ccDigi,1,5),'000')= amphur.ccDigi
		INNER JOIN opp_data.ccaa AS provice ON CONCAT(SUBSTR(amphur.ccDigi,1,2),'000000')= provice.ccDigi
		WHERE t1.eq_b4preg_birthyear BETWEEN '{$psStart}' AND '{$psEnd}'
		GROUP BY t3.areaid,t1.eq_b4preg_birthmonth, t1.eq_b4preg_birthyear
		ORDER BY t1.eq_b4preg_birthyear,(mm*1) ";
		$result = mysql_db_query('opp_data',$sql)or die(mysql_error());
		while($obj = mysql_fetch_object($result)){
			$numChild[$obj->areaid][$obj->mm]['math'] = $obj->sum;
			$numChild[$obj->areaid][$obj->mm]['child'] = $obj->child;
			$numChild[$obj->areaid][$obj->mm]['money'] = $obj->numpermonth;
		}
		
		# ข้อมูลหน่วยงาน ในปีงบประมาณที่คนหา
		$sql = "SELECT
		tambon.areaid,
		provice.ccName AS provice,
		amphur.ccName AS amphur,
		tambon.ccName AS tambon,
		area.partid,
		area.area_part
		FROM
		opp_data.eq_person AS t1
		INNER JOIN opp_usermanager.org_staffgroup AS t2 ON t1.eq_gid = t2.gid
		LEFT JOIN opp_data.ccaa AS tambon ON IF(t2.tambon != '',t2.tambon,IF(t2.amphur != '',t2.amphur,t2.province)) = tambon.ccDigi
		LEFT JOIN opp_data.ccaa AS amphur ON CONCAT(SUBSTR(tambon.ccDigi,1,5),'000') = amphur.ccDigi
		LEFT JOIN opp_data.ccaa AS provice ON CONCAT(SUBSTR(amphur.ccDigi,1,2),'000000') = provice.ccDigi
		INNER JOIN opp_master.area_part AS area ON provice.partid = area.partid
		WHERE
		t1.eq_register_date BETWEEN '{$ksStart }-10-01' AND '{$ksEnd}-09-30' GROUP BY tambon.areaid";
		$result = mysql_db_query('opp_usermanager',$sql)or die(mysql_error());
		echo '<pre>';
		//print_r($numChild); die;
		while($obj = mysql_fetch_object($result)){
			# สร้างโครงร่างข้อมูลปีงบประมาณ แยกตาม areaid และเดือน
			foreach($monthList as $mm => $yy){
				$replace = "REPLACE INTO report_eqmain SET
				yy = '{$psEnd}',
				mm = '{$mm}',
				yy1 = '{$yy}',
				area_id = '{$obj->areaid}',
				province = '{$obj->provice}',
				ampur = '{$obj->amphur}',
				tumboon = '{$obj->tambon}',
				part_id =  '{$obj->partid}',
				part_name =  '{$obj->area_part}',
				register_num =  '0',
				childbirth_num =  '0',
				child_num =  '0',
				pay_per_month =  '0',
				timecreate = NOW(),
				timeupdate = NOW() ";	
				mysql_db_query('opp_data',$replace)or die(mysql_error());
			}
			# สร้างโครงร่างข้อมูลปีงบประมาณ แยกตาม areaid และเดือน
			
			# นับจำนวนคน แยกตามเดือนและปีงบประมาณ
			foreach($monthList as $mm => $yy){
				# นับจำนวนคนที่ลงทะเบียน
				if($numRegis[$obj->areaid][$mm] != ''){
					$update = "UPDATE report_eqmain SET register_num = '{$numRegis[$obj->areaid][$mm]}' 
					WHERE yy = '{$psEnd}' AND mm = '{$mm}' AND area_id = '{$obj->areaid}' ";
					mysql_db_query('opp_data',$update)or die(mysql_error());
				}
				
				# นับจำนวนคนที่คลอด จำนวนบุตร และจำนวนเงินอุดหนุน
				if($numChild[$obj->areaid][$mm]['math'] != ''){
					$update = "UPDATE report_eqmain SET 
					childbirth_num = '{$numChild[$obj->areaid][$mm][math]}' ,
					child_num = '{$numChild[$obj->areaid][$mm][child]}' ,
					pay_per_month = '{$numChild[$obj->areaid][$mm][money]}' 
					WHERE yy = '{$psEnd}' AND mm = '{$mm}' AND area_id = '{$obj->areaid}' ";
					mysql_db_query('opp_data',$update)or die(mysql_error());
				}
			}
			# นับจำนวนคน แยกตามเดือนและปีงบประมาณ
			//die;
		}
		echo '</pre>';
	}
?>
</body>
</html>