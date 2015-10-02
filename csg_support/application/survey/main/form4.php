<link rel="stylesheet" href="../css/style.css">
<?php
require_once('lib/nusoap.php'); 
require_once("lib/class.function.php");
$con = new Cfunction();
$con->connectDB();
//$sql = 'SELECT question_summary,question_comment FROM question_detail_1 where question_id = '.$_GET['id'];
$sql = "select siteid,form_id,number_action,pin,child_userid,vid,yy,mm,value from eq_var_data where siteid=1 AND form_id=4 AND pin='".$_GET['id']."'";
$results = $con->select($sql);
foreach($results as $row)
{
	$value[$row['vid']] = $row['value'];
}
?>
<form action="main_exc/form4_exc.php" method="post" enctype="multipart/form-data">
<table width="749" border="0">
<tr>
	<td width="82" align="right"><strong>ส่วนที่4</strong></td>
    <td width="528"><strong>การสรุปและ/ความคิดของผู้สำรวจ</strong></td>
    <td width="125"><input type="hidden" name="pin" value="<?php echo $_GET['id']; ?>"></td>
</tr>
<tr>
  <td align="right">&nbsp;</td>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td align="right">&nbsp;</td>
  <td colspan="2">การสรุปและประเมินผล</td>
</tr>
<tr>
  <td align="right">&nbsp;</td>
  <td colspan="2"><textarea name="v404" id="v404" style=" width:100% ; height:250px"><?php echo $value['404']; ?></textarea></td>
</tr>
<tr>
  <td align="right">&nbsp;</td>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td align="right">&nbsp;</td>
  <td colspan="2">ความคิดเห็น/ข้อเสนอแนะของผู้สำรวจ</td>
</tr>
<tr>
  <td align="right">&nbsp;</td>
  <td colspan="2"><textarea name="v405" id="v405" style=" width:100% ; height:250px"><?php echo $row['405']; ?></textarea></td>
</tr>
<tr>
  <td align="right">&nbsp;</td>
  <td colspan="2" align="right"><button> เสร็จสิ้น </button></td>
</tr>
<tr>
  <td align="right" valign="top">&nbsp;</td>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td align="center" valign="top"><strong>แนบไฟล์<br>
    เพิ่มเติม</strong></td>
  <td colspan="2">
  		<iframe src="../plugin/upload/uploadimg.php?id=<?php echo $_GET['id']; ?>" width="100%" height="500px;" frameborder="0"></iframe>
  
  </td>
  </tr>
<tr>
  <td align="right">&nbsp;</td>
  <td width="528" align="left">&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td align="right">&nbsp;</td>
  <td width="528" align="right"></td>
  <td>&nbsp;</td>
</tr>
</table>
</form>
