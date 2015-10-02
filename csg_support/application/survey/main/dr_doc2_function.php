<?php 
/**
* @comment ???
* @projectCode ???
* @tor ???
* @package ???
* @author noone
* @access ???
* @created 25/25/2525
*/

function getProvince(){
	global $con;
	$sql = "Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = 'Changwat'";
	return $con->select($sql);
}

function getDistrict($prov_id, $type='option'){
	global $con;
	$sql = 'Select ccDigi,ccName,secid,group_id,areaid,ccType FROM ccaa WHERE ccType = \'Aumpur\' AND areaid like \''.substr($prov_id,0,2).'%\'';
	if($type=='option') echo '<option>กรุณาเลือกอำเภอ/เขต</option>';
	foreach($con->select($sql) as $dist){
		if($type=='option')
			echo '<option value="'.$dist[ccDigi].'">'.$dist[ccName].'</option>';
		else if($type=='array'){
			$data[$dist[ccDigi]] = $dist[ccName];
		}
	}
	if($type=='array') return $data;
}

function getSubDistrict($dist_id, $type='option'){
	global $con;
	$sql = 'Select ccDigi,ccName,secid,group_id,areaid,ccType FROM ccaa WHERE ccType = \'Tamboon\' AND areaid like \''.substr($dist_id,0,4).'%\'';
	if($type=='option') echo '<option>กรุณาเลือกตำบล/แขวง</option>';
	foreach($con->select($sql) as $dist){
		if($type=='option')
			echo '<option value="'.$dist[ccDigi].'">'.$dist[ccName].'</option>';
		else if($type=='array'){
			$data[$dist[ccDigi]] = $dist[ccName];
		}
	}
	if($type=='array') return $data;
}

function save_eq_approve_person($idcard, $data){
	$sql = 'REPLACE INTO eq_approve_person '.create_attr_string($idcard, $data[eq]);
	if(mysql_query($sql)) { $rs = true; }
	else { die("SQL Error: ".$sql."".mysql_error()); $rs = false;}
	if($rs) {
		save_eq_approve_guarantee($idcard, $data);
		echo '<script>alert("บันทึกข้อมูลเสร็จสมบูรณ์");</script>';
	}
		
}

function save_eq_approve_guarantee($idcard, $data){
	$attr_str = create_attr_string_deep_array($idcard, $data);
	for($i=0;$i<2;$i++){
		$attr_str[$i] = 'idcard = "'.$idcard.'", order_no = "'.($i+1).'", '.$attr_str[$i];
		$sql = 'REPLACE INTO eq_approve_guarantee SET '.$attr_str[$i].'create_at = NOW()';
		mysql_query($sql);
	}
	
}

function get_data_eq_approve($idcard,$eq_id){
	global $con;
	mysql_select_db(DB_DATA);
	$sql = "SELECT * FROM eq_approve_person WHERE idcard = '{$idcard}' AND eq_id = '{$eq_id}' ";
	$arr['person'] = $con->select($sql);
	$sql = "SELECT * FROM eq_approve_guarantee WHERE idcard = '{$idcard}' AND eq_id = '{$eq_id}' ";
	$arr['guarantee'] = $con->select($sql);
	$sql = "SELECT * FROM eq_person WHERE eq_idcard = '{$idcard}' AND eq_id = '{$eq_id}' LIMIT 1";
	$arr['eq_person'] = $con->select($sql);
	$arr['person'] = $arr['person'][0];
	$arr['eq_person'] = $arr['eq_person'][0];
	return $arr;
}

function create_attr_string_deep_array($idcard, $data){
	foreach($data as $index=>$value){
		if(is_array($value)){
			foreach($value as $i=>$val){
				$val = (preg_match("/[0-9]{2}\\/[0-9]{2}\\/[0-9]{4}/", $val, $matches)) ? re_date_db_fomat($val) : $val;
				$attr_str[$i] .=$index.' = "'.$val.'",'; 
			}
		}
	}
	return $attr_str;
}

function create_attr_string($idcard, $eq){
	$attr_str = 'SET idcard = "'.$idcard.'",';
	foreach($eq as $index=>$value){
		$value = ($value=='on' && strlen($value)==2) ? '1' : $value;
		$value = (preg_match("/[0-9]{2}\\/[0-9]{2}\\/[0-9]{4}/", $value, $matches)) ? re_date_db_fomat($value) : $value;
		$attr_str .= $index.' = "'.$value.'",';
	}
	$attr_str .= 'create_at = NOW()';
	return $attr_str;
}

function re_date_db_fomat($value){
	$date = explode('/',$value);
	return ($date[2]-543).'-'.$date[1].'-'.$date[0];
}

function re_date_view_fomat($value){
	if($value=='') return $value;
	$date = explode('-',$value);
	return $date[2].'/'.$date[1].'/'.($date[0]+543);
}

