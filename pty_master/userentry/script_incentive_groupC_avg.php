<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AdminReport";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Pairoj
#DateCreate::29/03/2007
#LastUpdate::29/03/2007
#DatabaseTable::schooll_name, login
#END
#########################################################
//session_start();
			set_time_limit(8000);
			include ("../../common/common_competency.inc.php")  ;
			include("../../config/conndb_nonsession.inc.php");
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
			$curent_date = date("Y-m-d");
			$dbnameuse = "edubkk_userentry";
			$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			
			$sql = "SELECT * FROM keystaff WHERE keyin_group='3'";
			$result = mysql_db_query($dbnameuse,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
				$i++;
				echo "ลำดับที่  $i &nbsp;$rs[staffname] $rs[staffsurname] [$rs[staffid]]<hr>";
				$sql1 = "SELECT stat_subtract_keyin.staffid,
		stat_subtract_keyin.datekey,stat_subtract_keyin.spoint,stat_subtract_keyin.num_p
  FROM stat_subtract_keyin  WHERE stat_subtract_keyin.staffid='$rs[staffid]' ORDER  BY datekey ASC ";
 // echo "$sql1";
  				$result1 = mysql_db_query($dbnameuse,$sql1);
				while($rs1 = mysql_fetch_assoc($result1)){
				$sql_insert1 = "INSERT INTO stat_subtract_keyin_avg(staffid,datekey,spoint,num_p)VALUES('$rs1[staffid]','$rs1[datekey]','$rs1[spoint]','$rs1[num_p]')";	
				echo $sql_insert1."<br>";
			  //mysql_db_query($dbnameuse,$sql_insert1);
				}
  		echo "<hr>";
			}

?>

