<?
session_start() ;
require_once '../../../config/conndb_nonsession.inc.php';
header("Content-Type: text/plain; charset=windows-874"); 

$arrid = explode(',',$prov_id);
$sqlamp 		= " SELECT  *  FROM ccaa  WHERE  ( `ccType` = 'Aumpur' )  AND  (  substring(ccDigi,1,2) =  substring($arrid[0],1,2) ) ORDER BY ccName";
$resultamp	= mysql_query($sqlamp)or die("line ". __LINE__  ."<hr>".mysql_error());     
?>
<select name="ampid" id="ampid"  onchange="synch_tamid(this.value); genAddr_text();" style="width:150px;">
<option value="">ไม่ระบุ</option>
<?

while($rsamp = mysql_fetch_assoc($resultamp)){
?>
<option value="<?=$rsamp[ccDigi].",".$rsamp[ccName]?>"><?=$rsamp[ccName]?></option>
<? 
}
mysql_free_result($result);
unset($rs,$sql);
 ?>
</select>
