<?php
/**
 * @comment ตั้งค่า parameter
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    21/06/2014
 * @access     public
 */
/*****************************************************************************
Function		: จัดการข้อมูลส่วนของ Parameter ของ Report
Version			: 1.0
Last Modified	: 
Changes		:


*****************************************************************************/
include "db.inc.php";
$id = "";
$action = "";
if(isset($_GET['id'])){
	$id = intval($_GET['id']);
}
if(isset($_GET['action'])){
	$action = $_GET['action'];	
}
$msg = "";
$sql = "SELECT rid FROM  `reportinfo`  WHERE rid='$id' AND uname='$uname';";
$result = mysql_query($sql);
if ($result){
	$checkrs=mysql_fetch_array($result,MYSQL_ASSOC);
	if(!$checkrs){
	$msg = "Cannot find Report.";
	}
} else {
	$msg = "Cannot find Report.";
}
if ($_SERVER['REQUEST_METHOD'] == "POST"){ 
	if ($_POST['action'] == "new"){
		//$porder = intval($_POST['porder']);
		$param = addslashes($_POST['param']);
		$dfield = addslashes($_POST['dfield']);
		$comment = addslashes($_POST['comment']);
		// @modify Phada Woodtikarn 01/07/2014 เพิ่ม condition
		$cond = addslashes($_POST['cond']);
		$showparam = addslashes($_POST['showparam']);
		// @end
		if ($param > ""){
			$result = mysql_query("select max(porder) as maxno from paraminfo where rid='$id' and uname='$uname';");
			$rs2 = mysql_fetch_array($result);
			$porder = intval($rs2['maxno']) + 1;

			if (isset($step)){
				$sql="INSERT INTO 
							paraminfo(uname,rid,param,porder,dfield,cond,comment,step,active)
						VALUES('$uname','$id','$param','$porder','$dfield','$cond','$comment','$step','$showparam');";
			}else{
				$sql="INSERT INTO 
							paraminfo(uname,rid,param,porder,dfield,cond,comment,active)
						VALUES('$uname','$id','$param','$porder','$dfield','$cond','$comment','$showparam');";
			}
			mysql_query($sql);
			if (mysql_errno()){
				$msg = "Cannot add new parameter.";
			}else{
				header("Location: ?id=$id");
				exit;
			}
		}else{
			$msg = "Parameter name must not be blank.";
		}

	}else if ($_POST['action']=="edit"){
		$param = addslashes($_POST['param']);
		$dfield = addslashes($_POST['dfield']);
		$comment = addslashes($_POST['comment']);
		// @modify Phada Woodtikarn 01/07/2014 เพิ่ม condition
		$cond = addslashes($_POST['cond']);
		$porder = addslashes($_POST['porder']);
		$showparam = addslashes($_POST['showparam']);
		// @end
		if (isset($step)){
			$sql = "UPDATE paraminfo SET dfield='$dfield',cond='$cond',porder='$porder',comment='$comment',step='$step',active='$showparam' WHERE rid='$id' AND uname='$uname' AND param='$param';";
		}else{
			$sql = "UPDATE paraminfo SET dfield='$dfield',cond='$cond',porder='$porder',comment='$comment',active='$showparam' WHERE rid='$id' AND uname='$uname' AND param='$param';";
		}
		mysql_query($sql);
		if (mysql_errno()){
			$msg = "Cannot update parameter information.";
		}else{
			header("Location: ?id=$id");
			exit;
		}

	}

}else	if ($action == "delete"){
		$param = addslashes($_GET['param']);
		mysql_query("delete from paraminfo where rid='$id' and uname='$uname' and param='$param';");
		if (mysql_errno()){
			$msg = "Cannot delete parameter.";
		}else{
			header("Location: ?id=$id");
			exit;
		}

}else	if ($action == "moveup" && $id > 0){
	$porder = intval($_GET['porder']);

// เอาไว้ก่อนนะ

}else	if ($action == "edit" && $id > 0){
	$param = addslashes($_GET['param']);
	$sql = "select * from  paraminfo where rid='$id' and uname='$uname' and param='$param' ;";

	$result = mysql_query($sql);
	if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
	} else {
		$msg = "Cannot find parameter information.";
	}

}
?>

<html>
<head>
<title>Report Management : Report Parameter</title>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<link href="report.css" type="text/css" rel="stylesheet">
<script language="javascript" src="dbselect.js"></script>
</head>

<body bgcolor="#FFFFFF">

<table border=0 width="100%" cellspacing=1 bgcolor=black>
<tr><td>
<?php
// @modify Phada Woodtikarn 21/07/2014 เนื่องจาก menu ใช้หลายหน้าเลยสร้างไว้อันเดียว
include "report_top_menu.php";
// @end
?>
</td></tr>
</table>
<BR>


<!-- Tab Header -->
<table border=0 width="100%" cellspacing=0 CELLPADDING=0>
<tr valign=baseline>
<td><a href="report_edit.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab0.gif" border=0></a></td>
<td><a href="report_exec.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab1.gif" border=0></a></td>
<td><a href="report_header.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab2.gif" border=0></a></td>
<td><a href="report_info.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab3.gif" border=0></a></td>
<td><a href="report_footer.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab4.gif" border=0></a></td>
<td><img src="<?php echo $imgpath ?>tabx5.gif" border=0></td>
<td width="50%"><img src="<?php echo $imgpath ?>/black.gif" width="100%" height="1"></td>
</tr>
</table> 

<table border=0 width="100%" cellspacing=0 CELLPADDING=0>
<tr BGCOLOR="#6F96C6"><td><FONT SIZE="-2" COLOR="WHITE">&nbsp;Edit report 's parameter.</FONT></td></tr>
<tr HEIGHT=1 BGCOLOR="#406080"><td></td></tr>
</table>
<!-- End Tab Header -->


<table border=0 width="100%" cellspacing=0 CELLPADDING=0>
<tr BGCOLOR="#AACCEE"><td>

<?
// ERROR MESSAGE
if ($msg){
	echo "<h1 align=center>$msg</h1></body></html>";
	exit;
}

if ($action == "new" || $action == "edit"){
?>

<BR>
<FORM ACTION="?id=<?=$id?>" METHOD=POST>
<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
<INPUT TYPE="hidden" NAME="action" VALUE="<?=$action?>">
<table border=0 width="80%" align=center cellspacing=0 CELLPADDING=0>
<tr><td><B>Parameter Name</B></td><td>
<?
	if ($action == "edit") {
?>
	<INPUT TYPE='hidden' NAME='param' VALUE='<?=$rs['param']?>'>
	<B><?=$rs['param']?></B>
<?
	}else{
?>
<INPUT TYPE="text" NAME="param" VALUE="<?php echo $action=='edit'?$rs['param']:'' ?>" size="20" maxlength="100">
<?
}	
?>
</td></tr>

<tr><td><B>Data Field</B></td>
<td> 
<INPUT TYPE="text" NAME="dfield" VALUE="<?php echo $action=='edit'?$rs['dfield']:'' ?>" size="60">
<INPUT TYPE="BUTTON" VALUE=" Select Field " CLASS="xbutton" ONCLICK="SelectField(document.forms[0].dfield);">
</td></tr>
<?php // @modify Phada Wooditkarn 01/07/2014 เพิ่ม condition ?>
<tr>
	<td><b>Condition</b><br><FONT STYLE="font-size:8pt;" COLOR="#404040">(no SELECT and WHERE)</FONT></td>
	<td>
		<input type="text" name="cond" value="<?php echo $action=='edit'?$rs['cond']:'' ?>" size="60">
	</td>
</tr>
<?php // @end ?>
<?php // @modify Phada Wooditkarn 26/07/2014 เพิ่ม การแสดง parameter ?>
<tr>
	<td><b>Show Parameter</b></td>
	<td>
		<label>
            <input type="radio" name="showparam" value="1" <?php echo $action=='edit'?$rs['active']==1?'checked':'':'checked' ?>>ON
        </label>
        <label>
            <input type="radio" name="showparam" value="0" <?php echo $action=='edit'?$rs['active']==0?'checked':'':'' ?>>OFF
        </label>
	</td>
</tr>
<?php // @end ?>
<?
	if ($action == "edit") {
?>
<tr><td><B>Order</B></td>
<td>
<INPUT TYPE="text" NAME="porder" VALUE="<?php echo $action=='edit'?$rs['porder']:'' ?>" size="5" maxlength=2>
</td></tr>
<?
}	
?>


<?
	if (isset($rs['step'])) {
?>
<tr><td><B>Step</B></td>
<td>
<INPUT TYPE="text" NAME="step" VALUE="<?=$rs['step']?>" size="5" maxlength=2>
</td></tr>
<?
}	
?>

<tr valign=top><td><B>Description</B></td><td>
<INPUT TYPE="text" NAME="comment" VALUE="<?php echo $action=='edit'?$rs['comment']:'' ?>" size="60" maxlength="100">
</td></tr>

<tr><td>&nbsp;</td><td ALIGN=LEFT><INPUT TYPE="SUBMIT" VALUE="   Save   " CLASS="xbutton">
<INPUT TYPE="reset" VALUE="   Undo   " CLASS="xbutton">
<INPUT TYPE="button" VALUE="   Cancel   " CLASS="xbutton" ONCLICK="location.href='?id=<?=$id?>';"></td></tr>

<?
if (isset($_GET['msg2'])){
	echo "<tr><td>&nbsp;</td><td><B>$_GET[msg2]</B></td></tr>";
}
?>

</table>
</FORM>


<?
}else{
?>

<BR>
<table border=0 width="95%" cellspacing=1 CELLPADDING=2 bgcolor=black align=center>
<tr BGCOLOR="#E0E0E0">
	<th> No. </th>
    <th> Parameter Name </th>
    <th> Database Field </th>
    <?php // @modify Phada Woodtikarn 01/07/2014 เพิ่ม condition ?>
	<th> Condition </th>
	<?php // @end ?>
    <?php // @modify Phada Woodtikarn 26/07/2014 เพิ่ม Show Parameter  ?>
	<th> Show Parameter </th>
	<?php // @end ?>
    <th> Description </th>
    <th>&nbsp;  </th>
</tr>
<?php
	$i=0;
	$result2 = mysql_query("SELECT * FROM paraminfo WHERE rid='$id' AND uname='$uname' ORDER BY porder;");
	while ($rs2=mysql_fetch_array($result2,MYSQL_ASSOC)){
		$i++;
?>

<tr BGCOLOR="WHITE">
<td align=center width="30"> <?=$i?> </td>
<td align=center > <?=$rs2['param']?> </td>
<td align=center > <?=$rs2['dfield']?> </td>
<?php // @modify Phada Woodtikarn 01/07/2014 เพิ่ม condition ?>
<td align="center" > <?php echo $rs2['cond']?> </td>
<?php // @end ?>
<?php // @modify Phada Woodtikarn 26/07/2014 เพิ่ม Show Parameter  ?>
<td align="center" > <?php echo $rs2['active']==1?'ON':'OFF'?> </td>
<?php // @end ?>
<td align=center > <?=$rs2['comment']?> </td>
<td align=center width="150"> 
	<INPUT CLASS="xbutton" style="width: 70;" TYPE="button" VALUE=" Edit " ONCLICK="location.href='?action=edit&id=<?=$rs2['rid']?>&param=<?=$rs2['param']?>';"> 
	<INPUT CLASS="xbutton"  style="width: 70;"TYPE="button" VALUE=" Delete " ONCLICK="if (confirm('Are you sure to delete this parameter?')) location.href='?action=delete&id=<?=$rs2['rid']?>&param=<?=$rs2['param']?>';"> 
<!-- 
	<INPUT CLASS="xbutton" style="width: 50;" TYPE="button" VALUE=" Up " ONCLICK="location.href='?action=moveup&id=<?=$rs2['rid']?>&param=<?=$rs2['param']?>&porder=<?=$rs2['porder']?>';"> 
	<INPUT CLASS="xbutton" style="width: 50;" TYPE="button" VALUE=" Down " ONCLICK="location.href='?action=movedown&id=<?=$rs2['rid']?>&param=<?=$rs2['param']?>&porder=<?=$rs2['porder']?>';"> 
 -->
</td>
</tr>

<?
	}	
?>

</table>
<table border=0 width="95%" cellspacing=0 CELLPADDING=0 align=center>
<tr height=5><td></td></tr>

<tr><td>
<INPUT CLASS="xbutton" TYPE="button" VALUE=" New Parameter " ONCLICK="location.href='?action=new&id=<?=$id?>';"> 
</td></tr></table>

<BR><BR>

<?
}
?>

</td></tr>
<tr HEIGHT=1 BGCOLOR="#000000"><td></td></tr>
</table>

</body>
</html>
