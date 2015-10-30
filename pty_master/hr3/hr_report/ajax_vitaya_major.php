<?
header("Content-Type: text/plain; charset=windows-874");
session_start();
include ("../../../config/conndb_nonsession.inc.php")  ; 
$q =  $_GET["major_gid"];
if (!$q) return;

 $sql="SELECT major_reqvitaya.majorname as value,major_reqvitaya.majorcode as id,major_reqvitaya.major_group
 FROM `major_reqvitaya` where major_reqvitaya.major_group='$q'";
$result=mysql_db_query($dbnamemaster,$sql);
while($row=mysql_fetch_array($result)){
echo"$row[value]|$row[id]\n";
}


?>