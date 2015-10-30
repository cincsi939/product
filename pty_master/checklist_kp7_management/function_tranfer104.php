<?
		$disable_query = "on"; // ตัวแปรในการกำหนดการปิดเปิด query  on คือ เปิด  off คือ ปิด
		$delete_sorce = "on";
		$fixipaddress = "localhost"; //  กำหนดให้เขียนที่ master เครื่อง 104
		$Cpathfile = "../../../image_file/";
			// id
			$arr_tbl1 = array("general_pic","getroyal","goodman","graduate","hr_absent","hr_nosalary","hr_other","hr_prohibit",
	"hr_specialduty","hr_teaching","req_print_kp7","salary","seminar","seminar_form","special","general","sheet","vitaya_stat");
			
			// general_id
			$arr_tbl2 = array( "log_approve","log_req_notapprove" );			
			
			// gen_id
			$arr_tbl3 = array( "hr_addhistoryaddress","hr_addhistoryfathername" , "hr_addhistorymarry" , "hr_addhistorymothername" , "hr_addhistoryname" );			
			
			//CZ_ID
			$arr_tbl4 = array( "view_general" );					

			//username , target_idcard
			$arr_tbl5 = array( "log_update" );					

			/// idcard
			$arr_tbl6 = array( "logupdate_user_dd","logupdate_user_hh" , "logupdate_user_mm" );			

			$arr_tbl_general = array("general","temp_dateremove");

//function Query1($sql){
//	$result  = mysql_query($sql);
//	echo mysql_error();
//	$rs = mysql_fetch_array($result);
//	return $rs[0];
//}

function conn($host){
				$username="sapphire";
				$password="sprd!@#$%";
			//	global $username,$password ;
				$myconnect =mysql_connect($host,$username,$password)or die (mysql_error()) ; //OR DIE("Unable to connect to database :: $host ");
				$iresult = mysql_query("SET character_set_results=tis-620");
				$iresult = mysql_query("SET NAMES TIS620");
}


function chk_field($tblname,$ipsource,$ipdest,$dbsource,$dbtarget){
	conn($ipsource);
	//echo "chkid :    $ipsource<hr>";
	$sql1 = " SHOW FIELDS FROM  $tblname ";
	$result1 = mysql_db_query($dbsource,$sql1);
	while($rs1 = mysql_fetch_assoc($result1) ){
			if(trim(strip_tags($rsfield1)) > ""){ $rsfield1 .= ",";}
			$rsfield1 .= "$rs1[Field]" ; 
	}
	conn($ipdest);
	//echo"CKECK : $ipdest<hr>";
	$sql2 = " SHOW FIELDS FROM  $tblname ";
	$result2 = mysql_db_query($dbtarget,$sql2);
	while($rs2 = mysql_fetch_assoc($result2) ){
			if(trim(strip_tags($rsfield2)) > ""){ $rsfield2 .= ",";}
			$rsfield2 .= "$rs2[Field]" ; 
	}
	$arrfield1 =  explode(",",$rsfield1);
	$arrfield2 =  explode(",",$rsfield2);
	$result_diff = array_diff($arrfield1,$arrfield2);
	return  $result_diff ;

}

function chk_id($id,$tblname,$ipsource,$ipdest,$dbsource,$dbtarget)
{
	//echo "chkid :    $ipsource<hr>";
	conn($ipsource);
	
		$sql1= " SELECT id  FROM  $tblname where id='$id' ";
		$result1 =mysql_db_query($dbsource,$sql1);
		$rs1=mysql_fetch_assoc($result1);

		$sql2="select id,idcard,name_th,surname_th ,birthday  from general where id='$id' ";
		$result2=mysql_db_query($dbsource,$sql2);
		$rs2=mysql_fetch_assoc($result2);
		
	conn($ipdest);
		$sql3= "SELECT id  FROM  $tblname where id='$id' ";
		$result3 =mysql_db_query($dbtarget,$sql3);
		$rs3=mysql_fetch_assoc($result3);
		
		$sql4="select id, idcard,siteid,name_th,surname_th ,birthday from general where id='$id' ";
		$result4=mysql_db_query($dbtarget,$sql4);
		$rs4=mysql_fetch_assoc($result4);
	

			if($rs1[id]==$rs3[id] and $rs1[id] !="")	
			{
				if($rs2[idcard]==$rs4[idcard] ){
				$sql_del=" delete from $tblname where id='$rs1[id]' ";
				mysql_db_query($dbtarget,$sql_del);
			//	echo $sql_del."<br>";
				trn_tbl($tblname,$ipsource,$ipdest,$dbsource,$dbtarget,$id);
				}else{
					
					//trn_tbl($tblname,$ipsource,$ipdest,$dbsource,$dbtarget,$id);
					//echo "<br>";
				}
			}
			else {
				trn_tbl($tblname,$ipsource,$ipdest,$dbsource,$dbtarget,$id);
			}
			//echo "( $rs1[id]==$rs3[id] )  $tblname<hr>";
}

function getfieldsource($tblname,$ipsource,$dbsource){
	conn($ipsource);
	$orderby="";
	$sql = " SHOW FIELDS FROM  $tblname ";
//echo ":: $sql.<hr>$dbsource";
	$result = mysql_db_query($dbsource,$sql)or die(mysql_error() . ", line $str" . __LINE__);  
	while($rs = mysql_fetch_assoc($result) ){
		if($rs[Extra]!="auto_increment"){  // ไม่เอา auto_increment
			if(trim(strip_tags($rsfield)) > ""){ $rsfield .= ",";}
			$rsfield .= "`$rs[Field]`" ; 
		} else {
			$orderby="ORDER BY $rs[Field] ASC";
		}
	}
	return $rsfield;
}


function getfieldsource_all($tblname,$ipsource,$dbsource){
	conn($ipsource);
	$orderby="";
	$sql = " SHOW FIELDS FROM  $tblname ";
//	echo ":: $sql.<hr>$dbsource";
	$result = mysql_db_query($dbsource,$sql);
	while($rs = mysql_fetch_assoc($result) ){
			if(trim(strip_tags($rsfield)) > ""){ $rsfield .= ",";}
			$rsfield .= "`$rs[Field]`" ; 
	}
	return $rsfield;
}


function trn_tbl($tblname,$ipsource,$ipdest,$dbsource,$dbtarget,$id,$cond_f){
	conn($ipsource);
	$dest_field = getfieldsource($tblname,$ipsource,$dbsource);
	$arrfield = explode(",",$dest_field);

	if($id!=""){
		$wherecond = " WHERE $cond_f = '$id' ";
	}else{
		$wherecond = "";
	}
	
	conn($ipsource);
	$sql1 = " SELECT $dest_field  FROM  $tblname    $wherecond   ";
	//echo "$sql1<br>";
	$result1=mysql_db_query($dbsource,$sql1);
	while($rs1 = mysql_fetch_assoc($result1)){
		$rsdata1 = "";

		foreach($arrfield AS $value){
			if(trim(strip_tags($rsdata1)) > ""){ $rsdata1 .= ",";}
			$value = str_replace("`","",$value);
			$rs1[$value] = addslashes($rs1[$value]);
			$rsdata1 .= "'$rs1[$value]'" ; 
		
		}
		// copy pic
		if($tblname=="general_pic")
		{

		$fp_movepic = @fopen("http://$ipdest/competency_master/application/hr3/tool_competency/tranferuser/movepic.php?sip=$ipsource&oldfilename=$rs1[imgname]&newfilename=$rs1[imgname]","r");
	//	else{}
		}
		$msg_movepic = trim(@fread($fp_movepic,1024));
		if($msg_movepic == "error") {
		 ### When Error Filename 
		 	print "Error ไฟล์ภาพ  $rs[imgname]  นี้ มีอยู่แล้ว<br>";
		}

		conn($ipdest);
		$str = "REPLACE INTO $tblname ($dest_field)VALUES($rsdata1)" ;	
		mysql_db_query($dbtarget,$str) or die(mysql_error() . ", line $str" . __LINE__);  
		### กรณีเป็นข้อมูลในตาราง general ให้เปลี่ยนรหัส หลังการทำการย้ายข้อมูลเลย
		if($tblname == "general"){
			$target_site = substr($dbtarget,-4);
			$sql_updategeneral = "UPDATE general SET siteid='$target_site',unit='$target_site' $wherecond";
			mysql_db_query($dbtarget,$sql_updategeneral);
		}//end 
	//echo "<hr>===>>$str <hr><br>";
		
//check data 2 way_______

		if(!mysql_error())
		{
			//	conn($ipsource);
			//$sql_deletedata="DELETE from $tblname where id='$userid' ";
			//mysql_db_query($dbtarget,$sql_deletedata)or die (mysql_error());
			//echo "จัดการโอนย้ายข้อมูลเรียบร้อยแล้ว<br>";
		}
		if(mysql_error()){
			echo mysql_error()." <br>$str <br>";
		}
		
	}

	/*////echo"<hr><hr>";
//#	conn($ipsource);		
	$sql44 = " SELECT count($cond_f) AS a FROM  $tblname   $wherecond    ";
//echo "$sql44<hr>";
	$result1=mysql_db_query($dbsource,$sql44) or die (mysql_error());
	$rs44 = mysql_fetch_assoc($result1);
	$num44 = $rs44[a] ;
	//return $num ;
	//
	conn($ipdest);
	$sql45 = " SELECT count($cond_f) AS b FROM  $tblname   $wherecond    ";
//echo "$sql45<hr>";
	$result45=mysql_db_query($dbtarget,$sql45) or die (mysql_error());
	$rs45= mysql_fetch_assoc($result45);
	$num45 = $rs45[b] ;

			conn($ipsource);
			$sql_deletedata="DELETE from $tblname  $wherecond ";
			mysql_db_query($dbsource,$sql_deletedata)or die (mysql_error());
			
			//echo "จัดการโอนย้ายข้อมูลเรียบร้อยแล้ว<br>";

			conn($ipdest);
			$sql_deletedata="DELETE from $tblname  $wherecond ";
			//mysql_db_query($dbtarget,$sql_deletedata)or die (mysql_error());	
			//echo "ย้ายข้อมูลไม่ได้";
	echo $num45.">>>>DESt=========================<hr>";	
	echo $num44.">>SOURCE=========================<hr>";	*/
}

function DEL_SOURCE($tblname,$ipsource,$ipdest,$dbsource,$dbtarget,$id,$cond_f)
{
global $delete_sorce;
				conn($ipsource);
			//	$dest_field = getfieldsource($tblname,$ipsource,$dbsource);
			//	$arrfield = explode(",",$dest_field);
			
				if($id!=""){
					$wherecond = " WHERE $cond_f = '$id' ";
				}else{
					$wherecond = "";
				}
		
			conn($ipsource);
			$sqls = " SELECT count($cond_f) AS S FROM  $tblname $wherecond   ";
			$resultdel=mysql_db_query($dbsource,$sqls)or die (mysql_error());
			$rnum=mysql_fetch_assoc($resultdel);
			$nums=$rnum[S];
			//
			conn($ipdest);
			$sqld = " SELECT count($cond_f) AS D FROM  $tblname $wherecond   ";
			$resultdel1=mysql_db_query($dbtarget,$sqld)or die (mysql_error());
			$rnumd=mysql_fetch_assoc($resultdel1);
			$numd=$rnumd[D];
			//echo"NUMSOURCE_____________________>>$nums<hr>";
			//echo"NUMDEST________________________>>$numd<hr>";
if($nums==$numd)
	{
			conn($ipsource);
			$SQL_DEL="DELETE FROM $tblname $wherecond ";
				//echo $SQL_DEL."<hr>";
				#######  กรณี ลบข้อมูล $disable_query == on 
				if($delete_sorce == "on"){ // เงื่อนไขการปิดเปิด query
				mysql_db_query($dbsource,$SQL_DEL)or die(mysql_error()."--LINE : --".__LINE__);
				}//end 	if($disable_query == "on"){
	}
else
	{
		//conn($ipdest);
		//$SQL_DEL="DELETE FROM $tblname $wherecond ";
		//echo $SQL_DEL."<hr>";			
		//mysql_db_query($dbtarget,$SQL_DEL)or die(mysql_error()."----------------------------ตั๊ดนี่");
	}
}


###############function เก็บ log ข้อมูลการย้าย ###################################################################################

function save_data_log($tblname,$ipsource,$ipdest,$dbsource,$dbtarget,$id,$cond_f,$id_refer){
	conn($ipsource);
	$dest_field = getfieldsource_all($tblname,$ipsource,$dbsource);
	$arrfield = explode(",",$dest_field);

// start insert  log_transfer_table
$strSQL_log_soruce = "INSERT INTO log_transfer_table(id_refer,idcard,table_name,status_comp)VALUES('$id_refer','$id','$tblname','OUT')";
mysql_db_query($dbsource,$strSQL_log_soruce)or die(mysql_error()."--LINE :  function  log--".__LINE__);
$xid_table = mysql_insert_id();// last id table log_transfer_table

conn($ipdest);
$strSQL_log_dest = "INSERT INTO log_transfer_table(id_table,id_refer,idcard,table_name,status_comp)VALUES('$xid_table','$id_refer','$id','$tblname','IN')";
mysql_db_query($dbtarget,$strSQL_log_dest)or die(mysql_error()."--LINE :fucntion  log --".__LINE__);

// end insert log_transfer_table
	if($id!=""){
		$wherecond = " WHERE $cond_f = '$id' ";
	}else{
		$wherecond = "";
	}
	
			conn($ipsource);
			$sqls = " SELECT count($cond_f) AS S FROM  $tblname $wherecond   ";
			$resultdel=mysql_db_query($dbsource,$sqls)or die (mysql_error());
			$rnum=mysql_fetch_assoc($resultdel);
			$nums=$rnum[S];
			//
			conn($ipdest);
			$sqld = " SELECT count($cond_f) AS D FROM  $tblname $wherecond   ";
			$resultdel1=mysql_db_query($dbtarget,$sqld)or die (mysql_error());
			$rnumd=mysql_fetch_assoc($resultdel1);
			$numd=$rnumd[D];

	
	conn($ipsource);
	$strSQL_key = "SHOW FIELDS FROM  $tblname";
	$Result_key = mysql_db_query($dbsource,$strSQL_key)or die(mysql_error()."_____LINE____:".__LINE__);
	while($Rs_key = mysql_fetch_assoc($Result_key)){
		if($Rs_key[Key] == "PRI"){
			$txt_field[$Rs_key[Field]]= $Rs_key[Field];
		}
	}

	$sql1 = " SELECT *  FROM  $tblname    $wherecond   ";
	$result1=mysql_db_query($dbsource,$sql1);
	while($rs1 = mysql_fetch_assoc($result1)){
		$rsdata1 = "";
		$primary_code = "";
		
		foreach($arrfield AS $value){
			if(trim(strip_tags($rsdata1)) > ""){ $rsdata1 .= ",";}
			$value = str_replace("`","",$value);
			$rs1[$value] = addslashes($rs1[$value]);
			$rsdata1 .= "'$rs1[$value]'" ; 
			
			if($value == $txt_field[$value]){	// เก็บ key หลัก
			if(trim(strip_tags($primary_code)) > ""){ $primary_code .= " AND ";}
			$rs1[$value] = addslashes($rs1[$value]);
			$primary_code .= $value."='".$rs1[$value]."'";
			}
		
		}// end 	foreach($arrfield AS $value){



// บันทึก log_transfer_table_detail


	conn($ipsource);
		$str = "REPLACE INTO $tblname ($dest_field)VALUES($rsdata1)" ;	
		$index_code = addslashes($primary_code);
		$sql_code = addslashes($str);
		$strSQL_tem = "INSERT INTO log_transfer_table_detail(id_table,primary_code,sql_code,status_transfer)VALUES('$xid_table','$index_code','$sql_code','OK')";
		//echo $strSQL_tem."<br>".$primary_code;die;
		mysql_db_query($dbsource,$strSQL_tem)or die(mysql_error()."_____LINE____:".__LINE__);

if($nums == $numd){ // กรณีจำนวนนับเท่ากัน
	conn($ipdest);
		$strSQL_tem = "INSERT INTO log_transfer_table_detail(id_table,primary_code,sql_code,status_transfer)VALUES('$xid_table','$index_code','$sql_code','OK')";
		mysql_db_query($dbtarget,$strSQL_tem)or die(mysql_error()."_____LINE____:".__LINE__);
}else{ // กรณีข้อมูลฝั่งปลายทางไม่ตรงกัน
	conn($ipdest);
	$strSQL_key = "SHOW FIELDS FROM  $tblname";
	$Result_key = mysql_db_query($dbtarget,$strSQL_key)or die(mysql_error()."_____LINE____:".__LINE__);
	while($Rs_key = mysql_fetch_assoc($Result_key)){
		if($Rs_key[Key] == "PRI"){
			$txt_field[$Rs_key[Field]]= $Rs_key[Field];
		}
	}

	$sql1 = " SELECT *  FROM  $tblname    $wherecond   ";
	$result1=mysql_db_query($dbtarget,$sql1);
	while($rs1 = mysql_fetch_assoc($result1)){
		$xrsdata1 = "";
		$xprimary_code = "";
		
		foreach($arrfield AS $value){
			if(trim(strip_tags($xrsdata1)) > ""){ $xrsdata1 .= ",";}
			$value = str_replace("`","",$value);
			$rs1[$value] = addslashes($rs1[$value]);
			$xrsdata1 .= "'$rs1[$value]'" ; 
			
			if($value == $txt_field[$value]){	// เก็บ key หลัก
			if(trim(strip_tags($xprimary_code)) > ""){ $xprimary_code .= " AND ";}
			$rs1[$value] = addslashes($rs1[$value]);
			$xprimary_code .= $value."='".$rs1[$value]."'";
			}
		
		}// end 	foreach($arrfield AS $value){
		conn($ipdest);
		$str1 = "REPLACE INTO $tblname ($dest_field)VALUES($rsdata1)" ;	
		$index_code = addslashes($primary_code);
		$sql_code =  addslashes($str1);
		if($primary_code == $xprimary_code){
			$save_status = "OK";
		}else{
			$save_status = "FAIL";
		}
		$strSQL_tem = "INSERT INTO log_transfer_table_detail(id_table,primary_code,sql_code,status_transfer)VALUES('$xid_table','$index_code','$sql_code','$save_status')";
		mysql_db_query($dbtarget,$strSQL_tem)or die(mysql_error()."_____LINE____:".__LINE__);

	}// end 	while($rs1 = mysql_fetch_assoc($result1)){
}// end if($nums == $numd){ 
// บันทึก log_transfer_table_detail

	}
}



function count_record($tblname,$id,$db){
	$sql1 = " SELECT count(id) AS a FROM  $tblname  where  id = '$id'   ";
	//echo "$sql1<hr>";
	$result1=mysql_db_query($db,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	$num = $rs1[a] ;
	return $num ;
}


function trn_temp_general($tblname,$ipsource,$dbsource,$id,$cond_f){
	global $fixipaddress;
	$ipdest = $fixipaddress;// กำหนด ip ที่จะเขียน
	$dbtarget = DB_MASTER;
	conn($ipsource);
	$source_field = getfieldsource($tblname,$ipsource,$dbsource);
	$arrfield_s = explode(",",$source_field);
		foreach($arrfield_s as $k1 => $v1){
				$arr_field[$v1] = $v1;
		}
	
	
	$dest_field = getfieldsource("temp_general",$ipsource,$dbtarget);
	$arrfield_d = explode(",",$dest_field);
		if($id!=""){
			$wherecond = " WHERE $cond_f = '$id' ";
		}else{
			$wherecond = "";
		}
	conn($ipsource);
	$sql1 = " SELECT $source_field  FROM  $tblname    $wherecond   ";
	$result1=mysql_db_query($dbsource,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	//echo "<pre>";
	//print_r($rs1);
		foreach($arrfield_d as $k => $v){
			//echo "$v :: $rs1[id]<br>";
				if($v == $arr_field[$v]){
					$v = str_replace("`","",$v);
					$rs1[$v] = addslashes($rs1[$v]);
					$rsdata1 = "$rs1[$v]" ; 
					if($strsql > "") $strsql .= ",";
					$strsql .= " $v='".$rsdata1."' ";
				}
		}//end foreach($arrfield_d as $v => $k){
			
		$sql_temp = "REPLACE INTO temp_general SET $strsql, yy='".(date("Y")+543)."',status_data='1'";
		//echo $sql_temp."<br>$dbtarget :: $dbsource <br>";
		$result_temp = mysql_db_query($dbtarget,$sql_temp);
		if($result_temp){
			$sql_del = "DELETE FROM general WHERE id='$id'";
			mysql_db_query($dbsource,$sql_del);
		}
		//echo $sql_temp;
}
###################################  function ย้ายข้อมูลของข้าราชการครู นอกเหนือจากเชียงใหม่เขต 1 - 5

#######################  ย้ายจาก temp_general 	กลับมายัง site
function trn_temp_general2cmss($tblname,$ipsource,$dbsource,$id,$cond_f,$get_dbsite=""){
	global $fixipaddress, $dbsite;
	$ipdest = $fixipaddress;// กำหนด ip ที่จะเขียน
	if($get_dbsite == ""){
			$dbtarget = $dbsite;
	}else{
			$dbtarget = $get_dbsite;
	}
	
	conn($ipsource);
	$source_field = getfieldsource($tblname,$ipsource,$dbsource);
	$arrfield_s = explode(",",$source_field);
		foreach($arrfield_s as $k1 => $v1){
				$arr_field[$v1] = $v1;
		}
	
	
	$dest_field = getfieldsource("general",$ipsource,$dbtarget);
	$arrfield_d = explode(",",$dest_field);
		if($id!=""){
			$wherecond = " WHERE $cond_f = '$id' ";
		}else{
			$wherecond = "";
		}
	conn($ipsource);
	$sql1 = " SELECT $source_field  FROM  $tblname    $wherecond   ";
	$result1=mysql_db_query($dbsource,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	//echo "<pre>";
	//print_r($rs1);
		foreach($arrfield_d as $k => $v){
			//echo "$v :: $rs1[id]<br>";
				if($v == $arr_field[$v]){
					$v = str_replace("`","",$v);
					$rs1[$v] = addslashes($rs1[$v]);
					$rsdata1 = "$rs1[$v]" ; 
					if($strsql > "") $strsql .= ",";
					$strsql .= " $v='".$rsdata1."' ";
				}
		}//end foreach($arrfield_d as $v => $k){
			
		$sql_temp = "REPLACE INTO general SET $strsql ";
		//echo $dbtarget."<HR>$sql_temp";die;
		mysql_db_query($dbtarget,$sql_temp);
		//echo $sql_temp;
} // end function trn_temp_general2cmss($tblname,$ipsource,$dbsource,$id,$cond_f){
###################################################3333

function trn_tbl_general($tblname,$ipsource,$dbsource,$id,$cond_f){
global $fixipaddress;
//$ipdest = "192.168.2.12";// กำหนด ip ที่จะเขียน
$ipdest = $fixipaddress;// กำหนด ip ที่จะเขียน
$dbtarget = DB_MASTER;
	conn($ipsource);
	$dest_field = getfieldsource($tblname,$ipsource,$dbsource);
	$arrfield = explode(",",$dest_field);

	if($id!=""){
		$wherecond = " WHERE $cond_f = '$id' ";
	}else{
		$wherecond = "";
	}
	
	conn($ipsource);
	$sql1 = " SELECT $dest_field  FROM  $tblname    $wherecond   ";
	//echo "$sql1<br>";
	$result1=mysql_db_query($dbsource,$sql1);
	while($rs1 = mysql_fetch_assoc($result1)){
		$rsdata1 = "";

		foreach($arrfield AS $value){
			if(trim(strip_tags($rsdata1)) > ""){ $rsdata1 .= ",";}
			$value = str_replace("`","",$value);
			$rs1[$value] = addslashes($rs1[$value]);
			$rsdata1 .= "'$rs1[$value]'" ; 
		}

		conn($ipdest);
		$str = "REPLACE INTO temp_general ($dest_field)VALUES($rsdata1)" ;	
		mysql_db_query($dbtarget,$str) or die(mysql_error() . ", line $str" . __LINE__);  

		if(mysql_error()){
			echo mysql_error()." <br>$str <br>";
		}
		
	}
	conn($ipsource);
	$strSQL_del = "DELETE  FROM  $tblname  $wherecond   ";
	mysql_db_query($dbsource,$strSQL_del) or die(mysql_error() . ", line $str" . __LINE__);  

}// end ###################################  function ย้ายข้อมูลของข้าราชการครู นอกเหนือจากเชียงใหม่เขต 1 - 5
##########################################################################################################################3

function trn_tbl_dataremove($tblname,$ipsource,$dbsource,$id,$cond_f){ // move ตาราง temp_dataremove 
global $fixipaddress;
//$ipdest = "192.168.2.12";// กำหนด ip ที่จะเขียน
$ipdest = $fixipaddress;// กำหนด ip ที่จะเขียน
$dbtarget = DB_MASTER;
	conn($ipsource);
	$dest_field = getfieldsource($tblname,$ipsource,$dbsource);
	$arrfield = explode(",",$dest_field);

	if($id!=""){
		$wherecond = " WHERE $cond_f = '$id' ";
	}else{
		$wherecond = "";
	}
	
	conn($ipsource);
	$sql1 = " SELECT $dest_field  FROM  $tblname    $wherecond   ";
	//echo "$sql1<br>";
	$result1=mysql_db_query($dbsource,$sql1)or die(mysql_error() . ", line $str" . __LINE__);  
	while($rs1 = mysql_fetch_assoc($result1)){
		$rsdata1 = "";

		foreach($arrfield AS $value){
			if(trim(strip_tags($rsdata1)) > ""){ $rsdata1 .= ",";}
			$value = str_replace("`","",$value);
			$rs1[$value] = addslashes($rs1[$value]);
			$rsdata1 .= "'$rs1[$value]'" ; 
		}

		conn($ipdest);
		$str = "INSERT INTO $tblname($dest_field)VALUES($rsdata1)" ;	
		mysql_db_query($dbtarget,$str) or die(mysql_error() . ", line $str" . __LINE__);  
		$dataremove_max_id = mysql_insert_id();
		$strSQL_up = "UPDATE $tblname SET create_by='1'  WHERE id_remove='$dataremove_max_id'"; // ระบุว่าไม่ใช่ ก.ค.ศ. เป็นคนสร้าง
		mysql_db_query($dbtarget,$strSQL_up)or die(mysql_error() . ", line $str" . __LINE__);  

		if(mysql_error()){
			echo mysql_error()." <br>$str <br>";
		}
	}

}// end ###################################  function  ตาราง temp_dataremove ย้ายข้อมูลของข้าราชการครู นอกเหนือจากเชียงใหม่เขต 1 - 5




function check_area_ch1_5($site_source,$site_dest,$check_position){ // ฟังก์ชั่นเช็คการย้ายข้าราชการครู
global $dbnamemaster;
$sql_config = "SELECT secid FROM eduarea WHERE config_area='1'";
$result_config = mysql_db_query($dbnamemaster,$sql_config);
while($rs_con = mysql_fetch_assoc($result_config)){
		$arr_check[$rs_con[secid]] = $rs_con[secid];
}// end while($rs_con = mysql_fetch_assoc($result_config)){
############   เก็บรหัสเขตพื้นที่การศึกษาเขตนำร่องที่สามารถย้ายไปได้เลย
//$arr_check = array("5001","5002","5003","5004","5005","5006");

$ch_source = in_array($site_source,$arr_check);
$ch_dest = in_array($site_dest,$arr_check);

	if(($ch_source == true) and ($ch_dest == true)){
	
		$re_check = true;
		
	}else{
	//echo $check_position;
		$ch_pos1 = strpos($check_position,"ครู");
		$ch_pos2 = strpos($check_position,"อาจารย์");
		$ch_pos3 = strpos($check_position,"อาจารย์ใหญ่");
		$ch_pos4 = strpos($check_position,"ครูใหญ่");
		if(  (trim($check_position == "ครู")) or (trim($check_position == "ครูผู้ช่วย")) or (trim($check_position == "อาจารย์"))  ){ // เช็คกรณีเป็นตำแหน่งครูเท่านั้นที่เก็บข้อมูลไว้ในถึงกลาง
					$re_check = false;
		}else{
				if( ((!($ch_pos1 === false)) or (!($ch_pos2 === false))) and (($ch_pos3 === false)or($ch_pos4 === false)) ){ // เช็คกรณีหลุดเงื่อนไขแรกเช่น ครู2 , อาจายร์ 3 เป็นต้น
					$re_check = false;
				}else{
					$re_check = true;
				}
		}
		
	}
	
return $re_check;
}


######################################################################  function ย้ายข้อมูลจาก temp_general กลับไปยัง geneal ใน site #######33

function trn_tbl_temp_general($tblname,$ipdest,$dbtarget,$id,$cond_f){
global $fixipaddress;
//$ipsource = "192.168.2.12";// กำหนด ip ที่จะเขียน
$ipsource = $fixipaddress;// กำหนด ip ที่จะเขียน
$dbsource = DB_MASTER;
	conn($ipsource);
	$dest_field = getfieldsource($tblname,$ipsource,$dbsource);
	$arrfield = explode(",",$dest_field);

	if($id!=""){
		$wherecond = " WHERE $cond_f = '$id' ";
	}else{
		$wherecond = "";
	}
	
	conn($ipsource);
	$sql1 = " SELECT $dest_field  FROM  $tblname    $wherecond   ";
	//echo "$sql1<br>";
	$result1=mysql_db_query($dbsource,$sql1);
	while($rs1 = mysql_fetch_assoc($result1)){
		$rsdata1 = "";

		foreach($arrfield AS $value){
			if(trim(strip_tags($rsdata1)) > ""){ $rsdata1 .= ",";}
			$value = str_replace("`","",$value);
			$rs1[$value] = addslashes($rs1[$value]);
			$rsdata1 .= "'$rs1[$value]'" ; 
		}

		conn($ipdest);
		$str = "REPLACE INTO general($dest_field)VALUES($rsdata1)" ;	
		mysql_db_query($dbtarget,$str) or die(mysql_error() . ", line $str" . __LINE__);  
		if(mysql_error()){
			echo mysql_error()." <br>$str <br>";
		}
		
	}
	conn($ipsource);
	$strSQL_del = "DELETE  FROM  $tblname  $wherecond   ";
	mysql_db_query($dbsource,$strSQL_del) or die(mysql_error() . ", line $str" . __LINE__);  
}


###################  ฟังก์ชั่นการตรวจสอบ การกำหนดสถานะการย้าย
	function check_status_remove($siteid,$idcard){
		global $dbnamemaster;
		$sql_1 = "SELECT COUNT(idcard) AS num1 FROM tbl_set_status_remove WHERE site_source='$siteid' AND idcard='$idcard';";
		$result_1 = mysql_db_query($dbnamemaster,$sql_1);
		$rs_1 = mysql_fetch_assoc($result_1);
		return $rs_1[num1];
	}

############ end การตรวจสอบ การกำหนดสถานะการย้าย

######  function ย้ายไฟล์  pdf ต้นฉบับ
	function copy_pdf_original($idcard,$site_sorece,$site_dest){
	global $dbnamemaster;
		$source_file = "../../../../../".PATH_KP7_FILE."/$site_sorece/$idcard".".pdf";
		$dest_file = "../../../../../".PATH_KP7_FILE."/$site_dest/$idcard".".pdf";
			if(file_exists($source_file)){  // กรณีมีไฟล์ต้นฉบับเท่านั้น
				if(copy($source_file,$dest_file)){
					//	@unlink($source_file); // ลบไฟล์กรณีไฟล์สำเร็จ
						####### update ข้อมูล log pdf
						$sql_log_pdf = "UPDATE log_pdf SET secid='$site_dest' WHERE idcard='$idcard'";
						@mysql_db_query($dbnamemaster,$sql_log_pdf);
						#########  update ข้อมูลการมอบหมายงาน
						$sql_up_assign = "UPDATE tbl_assign_key SET siteid='$site_dest'  WHERE idcard='$idcard'";
						@mysql_db_query(DB_USERENTRY,$sql_up_assign);
						
				} // end if(copy($source_file,$dest_file)){
			} // end 	if(file_exists($source_file)){ 
	}// end function copy_pdf_original($idcard,$site_sorece,$site_dest){
########  end function   ย้ายไฟล์  pdf ต้นฉบับ

#############  ฟังก์ชั่นในการ trigger ข้อมูลการศึกษา
function trigger_euation($secid,$idcard){
	$db_site = "cmss_$secid";
	$sql_graduate = "SELECT * FROM graduate WHERE id='$idcard' ORDER BY graduate_level DESC LIMIT 0,1";
	$result_graduate = @mysql_db_query($db_site,$sql_graduate);
	$rs_g = @mysql_fetch_assoc($result_graduate);
	$arr_t = explode(" ",$rs_g[updatetime]);
	$arr_t1 = explode(":",$arr_t[1]);
	$smunit = $arr_t1[2]+1;
	$xtime = $arr_t[0]." ".$arr_t1[0].":".$arr_t1[1].":".$smunit; // บวกเวลาเข้าไปอีก 1 วินาที
	$sql_update = "UPDATE graduate SET updatetime='$xtime' WHERE id='$idcard' AND runid='$rs_g[runid]'";
	$result_update = @mysql_db_query($db_site,$sql_update);
} // end function trigger_euation($secid,$idcard){


###  function ลบข้อมูลต้นทางที่ไม่ใช้ 46 เขต
function DeleteDataNotIn($get_siteid,$get_idcard){
	if($get_siteid!=""){ // P'noi
			$db_site = "cmss_$get_siteid";
			$sql = "DELETE FROM general WHERE id='$get_idcard'";
			mysql_db_query($db_site,$sql)or die(mysql_error() . ", line $sql" . __LINE__);
	}

}//end function DeleteDataNotIn($get_idcard){
###  function ลบข้อมูลต้นทางที่ไม่ใช้ 46 เขต

function DeleteDataNew($get_siteid,$get_idcard){
	global $arr_tbl1,$arr_tbl2,$arr_tbl3,$arr_tbl5,$arr_tbl6;
	$db_site = "cmss_$get_siteid";
	  	 foreach($arr_tbl1 as  $tbl1){		
		 	if($tbl1 != "general"){ /// ลบรายการในตารางยกเว้นตาราง general
			   $sql = "DELETE FROM $tbl1 WHERE id='$get_idcard'";
			   mysql_db_query($db_site,$sql)or die(mysql_error() . ", line $sql" . __LINE__);
			}// end if($tbl != "general"){
		  }
		  foreach($arr_tbl2 as  $tbl2){			
		   	   $sql = "DELETE FROM $tbl2 WHERE general_id='$get_idcard'";
			   mysql_db_query($db_site,$sql)or die(mysql_error() . ", line $sql" . __LINE__);
		  }
		  foreach($arr_tbl3 as  $tbl3){	
		   		$sql = "DELETE FROM $tbl3 WHERE gen_id='$get_idcard'";
			    mysql_db_query($db_site,$sql)or die(mysql_error() . ", line $sql" . __LINE__);
		  }
		  foreach($arr_tbl5 as  $tbl5){	
		  		$sql = "DELETE FROM $tbl5 WHERE username='$get_idcard'";
			  	mysql_db_query($db_site,$sql)or die(mysql_error() . ", line $sql" . __LINE__);
		  }
		  foreach($arr_tbl6 as  $tbl6){			
		  		$sql = "DELETE FROM $tbl6 WHERE idcard='$get_idcard'";
			  	mysql_db_query($db_site,$sql)or die(mysql_error() . ", line $sql" . __LINE__); 
		  }		
}//end function DeleteDataNew($get_siteid,$get_idcard){
	function xRmkdir1($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
		mkdir($way);
	}
}//end function xRmkdir($path,$mode = 0777){

####  คัดลอกรูป
function CopyPicCmss($get_idcard,$s_siteid,$d_siteid){
	global $Cpathfile;
	$db_site = "cmss_".$s_siteid;
	$sql = "SELECT
general_pic.imgname
FROM
general
Inner Join general_pic ON general.idcard = general_pic.id
WHERE
general.idcard =  '$get_idcard'";
$result = mysql_db_query($db_site,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$file_s = "$Cpathfile".$s_siteid."/".$rs[imgname];
		$file_d = "$Cpathfile".$d_siteid."/".$rs[imgname];
		$path_n = $Cpathfile.$d_siteid."/";
		if(!is_dir($path_n)){
			xRmkdir1($path_n);
		}
		@copy($file_s,$file_d);
		@chmod("$file_d",0777);	
	}
		
}//end 
			
?>