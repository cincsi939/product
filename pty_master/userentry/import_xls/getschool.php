<?php
header ("Content-Type: text/html; charset=tis-620");  
set_time_limit(0) ;
include('root_path.php');
include ("../../../common/common.inc.php") ; 
include "../epm.inc.php"; 
if(isset($_GET['queryString'])) {$xqueryString=$_GET['queryString']; }
if(isset($_GET['siteid'])) {$sec_id=$_GET['siteid'];} 
echo "<table  border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"datatable\"> ";
echo" <tr>
    <th>ชื่อ สถานศึกษา/หน่วยงาน</th>   
  </tr> ";
 $icount=1 ;
 $sql="SELECT secid, secname FROM  ".DB_MASTER.".eduarea WHERE siteid='$sec_id'   ";
 $Result_office = mysql_db_query($dbnamemaster,$sql);  
while($rs_office = mysql_fetch_array($Result_office)){ 
 
if(($icount%2)==0){$iclass="class='altrow'";} else{$iclass="";}
    echo "<tr ". $iclass ." onClick=\"filldata('".$rs_office['secid']."','".$rs_office['secname']."')\"><td>".$rs_office['secname']."</td></tr>";
 $icount++;  
}   
$sql="SELECT id , office  FROM   ".DB_MASTER.".allschool  WHERE siteid='$sec_id' and office LIKE '%".$xqueryString."%'" ;  
$Result_office = mysql_db_query($dbnamemaster,$sql);
while($rs_office = mysql_fetch_array($Result_office)){  
 
if(($icount%2)==0){$iclass="class='altrow'";} else{$iclass="";} 
    echo "<tr ". $iclass ." onClick=\"filldata('".$rs_office['id']."','".$rs_office['office']."')\"><td>".$rs_office['office']."</td></tr>";    
$icount++;  
}

echo "</table> ";   

?>
   