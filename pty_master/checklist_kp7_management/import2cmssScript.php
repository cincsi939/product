<?
session_start();
set_time_limit(0);
include("checklist.inc.php");
include("function_tranfer.php");
$dbsite = "cmss_6502";

$sql1 = "SELECT $dbsite.general.id FROM $dbsite.general Left Join $dbname_temp.tbl_check_data ON $dbsite.general.id = $dbname_temp.tbl_check_data.idcard WHERE $dbname_temp.tbl_check_data.idcard IS NULL ";
		$result1 = mysql_db_query($dbsite,$sql1);
		$numrow1 = @mysql_num_rows($result1);
		if($numrow1 > 0){
			$i=0;
			while($rs1 = mysql_fetch_assoc($result1)){
				echo $rs1[id]."<br>";
				### จัดเก็บข้อมูลในรายการที่อยู่นอกเหนือจากเขตไปเก็บไว้ใน temp_general
				//trn_temp_general("general","localhost","cmss_5001","3501500244554","id");
				//trn_temp_general("general",$ipsource,$dbsite,$rs1[id],"id");
				$i++;
			}
		}//end if($numrow1 > 0){
			
			echo "จำนวน $i  รายการ";

?>