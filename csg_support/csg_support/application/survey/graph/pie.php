<style>

</style>
<?php
		header ('Content-type: text/html; charset=utf-8'); 
		require_once("../lib/class.function.php");
		require_once("../lib/nusoap.php");
		$con = new Cfunction();
		$con->connectDB();
		
		$sql_district_all = "Select exsum_district_ccdigi,REPLACE(exsum_district_title,'อำเภอ','') as exsum_district_title,exsum_district_num FROM exsum_district_all";
		$result_district_all  = $con->select($sql_district_all);
		
		$sql_sum_all= 'Select master_id FROM question_master';
		$result_sum_all  = $con->select($sql_sum_all);
		
		foreach($result_district_all as $rd)
		{
			$name[] = $rd['exsum_district_title'].' '.$rd['exsum_district_num'].' คน';
			$data[] = (count($result_sum_all)*$rd['exsum_district_num'])/100;
			$sliced[] = 'false';
		}
		$name = implode(',',$name);
		$data = implode(',',$data);
		$sliced = implode(',',$sliced);
		
		$ws_client = $con->configIPSoap();
		$jquery = array('file' => 'jquery');
		$highcharts = array('file' => 'highcharts');
		echo $ws_client->call('includefile', $jquery);
		echo $ws_client->call('includefile', $highcharts);
		
		$para = array(
			'type' => 'pie',
			'title' => '', // หัวข้อกราฟ
			'categories' => 'จำนวน', // กำหนดชื่อเพื่อบอกค่า %
			'name' => $name, //ชื่อเปรียบเทียบ
			'data' =>$data, //จำนวน ดาต้า รวมกันได้ 100
			'sliced' => $sliced,// แสดงค่าที่เลือกออกมาแสดงเริ่มต้น
			'width' => '440', // ความกว้างของเฟรม
			'height' => '330', // ความยาวของเฟรม
			'graphdiv' => 'graph1'
		);			  
		$result = $ws_client->call('graph', $para);
		echo $result;
?>
