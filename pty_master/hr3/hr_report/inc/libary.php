<?

$head	= ($action == "edit") ? "<b>��䢢�����</b>" : "<b>�ѹ�֡����������</b>" ;
$tabcol	= "B0D5FF";
$fields	= array("hr_blood" 				=> "id,blood",
						"prename_th" 			=> "runid,prename",
						"prename_en" 			=> "runid,prename",
						"hr_religion" 				=> "id,religion",
						"hr_addmarriage" 		=> "runid,marriage"	,
						"hr_addhighgrade"		=> "runid,highgrade",
						"hr_addposition"			=> "runid,position",
						"hr_addradub_old" 		=> "runid,radub",
						"hr_addpersontype" 	=> "runid,persontype",
						"hr_addradub" 			=> "runid,radub",
						"hr_addministry"			=> "runid,ministry"	,
						"hr_addroyal"				=> "runid,royal",
						"hr_addmajor"			=> "runid,major"						
						);
$title		= array("hr_blood" 				=> "�������ʹ",
						"prename_th"				=> "�ӹ�˹�Ҫ���������",
						"prename_en"			=> "�ӹ�˹�Ҫ��������ѧ���",
						"hr_religion" 				=> "��ʹ�",
						"hr_addmarriage" 		=> "ʶҹ�Ҿ����",
						"hr_addhighgrade" 		=> "����֡���٧�ش",
						"hr_addposition"			=> "���˹��Ҫ���",
						"hr_addradub_old" 		=> "�дѺ",
						"hr_addpersontype" 	=> "����������Ҫ���",
						"hr_addradub" 			=> "�дѺ",
						"hr_addministry"			=> "��з�ǧ",
						"hr_addroyal"				=> "����ͧ�Ҫ/����­���",
						"hr_addmajor"			=> "�Ң�"
						);

function getOption($sql, $selected){

	$result	= mysql_query($sql)or die(" Query Error in inc/Libary.php line " . __LINE__ ."<hr>".mysql_error());
	while($rs = mysql_fetch_assoc($result)){
		$choose	= ($rs[value] == $selected) ? " selected " : "" ;
		$data	.= "<option value=\"".$rs[value]."\" ".$choose.">".$rs[value]."</option>";
	}
	mysql_free_result($result);
	return $data;
	
}

function getOption2($sql, $selected){

	$result	= mysql_query($sql)or die(" Query Error in inc/Libary.php line " . __LINE__ ."<hr>".mysql_error());
	while($rs = mysql_fetch_assoc($result)){
		$choose	= ($rs[id] == $selected) ? " selected " : "" ;
		$data	.= "<option value=\"".$rs[id]."\" ".$choose.">".$rs[value]."</option>";
	}
	mysql_free_result($result);
	return $data;
	
}

function yearChange($temp, $lang){
	if(empty($temp) || $temp == "0000-00-00"){
		$data	= "";	
	} else {
		$y 		= explode("-",$temp);
		$y[0]		= ($lang == 0) ? ($y[0] + 543) : ($y[0] - 543) ;
		$data	= $y[0]."-".$y[1]."-".$y[2];	
	}	
	return $data;
	
}

function getStirng($value){

	$index	= array_keys($value);
	$value	= array_values($value);
	
	for($i=0;$i<count($value);$i++){
		$h		= ($i==0) ? "?" : "&" ;
		$dt	.= $h.$index[$i]."=".$value[$i];		
	}
	
	return $dt;

}

?>