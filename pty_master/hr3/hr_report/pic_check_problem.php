<?
session_start();
include ("../../../config/phpconfig.php");
include("pic_function.php");
$menu_id = "2";
$db_temp = DB_CHECKLIST;
if($_SERVER['REQUEST_METHOD'] == "POST"){
		if($action == "add"){
			add_log("�ѹ�֡�š�õ�Ǩ�ͺ�ٻ�Դ��Ҵ",$id,$action,$menu_id);	
			$sqlc = "SELECT COUNT(idcard) AS num1 FROM pic_check_problem WHERE idcard='$id' AND type_problem='$type_problem'";
			$resultc = mysql_db_query($db_temp,$sqlc);
			$rsc = mysql_fetch_assoc($resultc);
			if($rsc[num1] > 0){
				$sql = "UPDATE pic_check_problem SET comment_pic='$comment_pic',staffid='$xstaffid',siteid='".$_SESSION[secid]."',pic_yy='$pic_yy',pic_no='$pic_no',num_pic='$num_pic' , status_problem='$status_problem'  WHERE idcard='$id'  AND type_problem='$type_problem'";	
			}else{
				$sql = "INSERT INTO pic_check_problem SET comment_pic='$comment_pic',staffid='$xstaffid',siteid='".$_SESSION[secid]."',pic_yy='$pic_yy',pic_no='$pic_no',num_pic='$num_pic', idcard='$id',type_problem='$type_problem',status_problem='$status_problem' ";
			}//end if($rsc[num1] > 0){
		$result = mysql_db_query($db_temp,$sql);
		if($result){
			echo "
			<script language=\"javascript\">
			alert(\"�ѹ�֡���������º��������\");
			window.opener.location.reload();
			window.close();
			</script>
			";	
		}//end if($result){
		}//end if($Aaction == "SAVE"){
}//end if($_SERVER['REQUEST_METHOD'] == "POST"){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="hr.css" type="text/css" rel="stylesheet">
<title>�ѹ�֡�ѭ�Ҽš�õ�Ǩ�ͺ�ٻ�Ҿ</title>
<script language="javascript">
function CheckForm(){
	if(document.post.type_problem.value == ""){
			alert("��س��кػ������ѭ��");
			document.post.type_problem.focus();
			return false;
	}
	
	return true;
}//end function CheckForm(){
</script>
</head>
<body bgcolor="#f8f8f8">
<?
	$sqle = "SELECT * FROM pic_check_problem WHERE idcard = '$id'";
	$resulte = mysql_db_query($db_temp,$sqle);
	$rse = mysql_fetch_assoc($resulte);
	$nume = @mysql_num_rows($resulte);
?>
<table width="100%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
<tr bgcolor="#dddddd">
    <td height="20"><b><img src="../../../images_sys/app.gif" width="20" height="20" /> ������ѹ�֡�š�õ�Ǩ�ͺ�ٻ�������ó�</b></td>
</tr>	
<tr bgcolor="#ffffff">
    <td height="20" colspan="3">
<form name="post" action="" method="post" enctype="multipart/form-data" onsubmit="return CheckForm();">	
<table width="100%" border="0" cellspacing="1" cellpadding="3">
<tr>
	<td colspan="2" height="15"></td>
</tr>
<tr>
    <td width="26%" height="20" align="right"><strong>�š�õ�Ǩ�ͺ <font color="#FF0000">*</font>&nbsp;:&nbsp;</strong></td>
	<td width="74%"><label>
	  <select name="type_problem" id="type_problem">
      <?
      $sql_t = "SELECT * FROM pic_type_problem ORDER BY runid ASC";
	  $result_t = mysql_db_query($db_temp,$sql_t);
	  while($rs_t = mysql_fetch_assoc($result_t)){
		  	if($rse[type_problem] == $rs_t[runid]){ $sel = " selected='selected'";}else{ $sel = "";}
			echo "<option value='$rs_t[runid]' $sel>$rs_t[type_problem]</option>";		  
		}
	  ?>
	    </select>
	  </label></td>
</tr>
<?
	$cyy = date("Y")+543;
	$eyy = $cyy-62;
?>
<tr>
  <td height="20" align="right"><strong>�� �.�. �ٻ�Ҿ&nbsp;:&nbsp;</strong></td>
  <td><label>
    <select name="pic_yy" id="pic_yy">
    <option value=""> - �кػ� �.�.- </option>
	<?
    	for($i = $cyy; $i > $eyy ; $i--){
			if($i == $rse[pic_yy]){ $sel1 = " selected='selected'";}else{ $sel1 = "";}
				echo "<option value='$i' $sel1>$i</option>";
		}
	?>
    </select>
  </label></td>
</tr>
<tr>
  <td height="20" align="right"><strong>�ӴѺ�ٻ�Ҿ &nbsp;:&nbsp;</strong></td>
  <td><label>
    <select name="pic_no" id="pic_no">
    <option value="">  - �к��ӴѺ�ٻ�Ҿ - </option>
    <?
    	for($i=1 ; $i <= 20 ; $i++){
			if($i == $rse[pic_no]){ $sel2 = " selected='selected'";}else{ $sel2 = "";}
			echo "<option value='$i' $sel2>$i</option>";
		}
	?>
    </select>
  </label></td>
</tr>
<tr>
  <td height="20" align="right" valign="top"><strong>�ӹǹ�ٻ����ջѭ�� : </strong></td>
  <td><label>
    <select name="num_pic" id="num_pic">
        <option value="">  - �кبӹǹ�ٻ����ջѭ�� - </option>
    <?
    	for($i=1 ; $i <= 10 ; $i++){
			if($i == $rse[num_pic]){ $sel = " selected='selected'";}else{ $sel = "";}
			echo "<option value='$i' $sel>$i</option>";
		}
	?>

    </select>
  </label></td>
</tr>
<tr>
    <td height="20" align="right" valign="top"><strong>�����˵�&nbsp;:&nbsp; </strong></td>
	<td><label>
	  <textarea name="comment_pic" id="comment_pic" cols="50" rows="5"><?=$rse[comment_pic]?></textarea>
	  </label></td>
</tr>
<? if($nume > 0){?>
<tr>
  <td height="20" align="right" valign="top"><strong>ʶҹС����ѭ�� : </strong></td>
  <td><label>
    <input type="radio" name="status_problem" id="radio" value="0" <? if($rse[status_problem] == "0"){ echo "checked='checked'";}?>>
    �ѧ�������ѭ�� 
    <input type="radio" name="status_problem" id="radio2" value="1" <? if($rse[status_problem] == "1"){ echo "checked='checked'";}?> >
  ��ѭ�����º��������</label></td>
</tr>
<?
}//end if($nume > 0){
?>
<tr>
  <td height="20" align="right" valign="top">&nbsp;</td>
  <td><label>
  <input type="hidden" name="xstaffid" value="<?=$xstaffid?>">
  <input type="hidden" name="id" value="<?=$id?>">
  <input type="hidden" name="action" value="add">
    <input type="submit" name="button" id="button" value="�ѹ�֡">
    &nbsp;
	<input type="button" name="btnCl" value="�Դ˹�ҵ�ҧ" onclick="window.close();">
  </label></td>
</tr>
</table>
</form>
	</td>
</tr>
<tr bgcolor="#dddddd" align="center">
    <td height="20">

    </td>
</tr>
</table>
</body>
</html>