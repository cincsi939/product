<?
session_start() ;
require_once '../../../config/conndb_nonsession.inc.php';
header("Content-Type: text/plain; charset=windows-874"); 
 
 $arrid = explode(',',$mp_id);
 $sqlamp 		= " SELECT  *  FROM ccaa  WHERE  ( `ccType` = 'Tamboon' )  AND  (  substring(ccDigi,1,4) =  substring($arrid[0],1,4) )  ORDER BY ccName";
$resultamp	= mysql_query($sqlamp)or die("line ". __LINE__  ."<hr>".mysql_error());
     
?>
<select name="tamid" id="tamid" style="width:150px;" onchange="genAddr_text();">
<option value="">ไม่ระบุ</option>
<?
while($rsamp = mysql_fetch_assoc($resultamp)){
?>
<option value="<?=substr($rsamp[ccDigi],0,6)?>,<?=$rsamp[ccName]?>"><?=$rsamp[ccName]?></option>
<? 
}
mysql_free_result($result);
unset($rs,$sql);
 ?>
</select>
