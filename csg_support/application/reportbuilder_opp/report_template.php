<?php
/**
 * @comment 	หน้าบันทึกข้อมูลลงเป็น Template 
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    21/06/2014
 * @access     public
 */
/*****************************************************************************
Function		: บันทึกข้อมูลลงเป็น Template 
Version			: 1.0
Last Modified	: 
Changes		:


*****************************************************************************/
require_once "db.inc.php";

$id = intval($_GET['id']);
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == "POST"){ 
	if ($_GET['action'] == "new"){
		$id = intval($_POST['id']);
		$caption = addslashes($_POST['caption']);
		$comment = addslashes($_POST['comment']);
		$tdata = DB2Array("reportinfo","select * from reportinfo where rid='$id' and uname='$uname';");
		$tdata .= DB2Array("cellinfo","select * from cellinfo where rid='$id' and uname='$uname';");
		$tdata .= DB2Array("paraminfo","select * from paraminfo where rid='$id' and uname='$uname';");

		$tdata = addslashes($tdata);

		if ($caption > ""){
			mysql_query("insert into templateinfo(caption,comment,tdata) values('$caption','$comment','$tdata');");
			if (mysql_errno()){
				$msg = "Cannot add new Template.";
			}else{
				header("Location: report_manage.php");
				exit;
			}
		}else{
			$msg = "Caption cannot be blank. ";
		}
	}
}else if ($_GET['action'] == "update"){
		$id = intval($_POST[id]);
		$caption = addslashes($_POST['caption']);
		$comment = addslashes($_POST['comment']);
		if ($caption > ""){
			mysql_query("update templateinfo set caption='$caption',comment='$comment';");
			if (mysql_errno()){
				$msg = "Cannot update template.";
			}else{
				header("Location: report_manage.php");
				exit;
			}
		}else{
			$msg = "Caption cannot be blank. ";
		}

}else if ($_GET['action'] == "delete"){
		// delete from templateinfo
		mysql_query("delete from templateinfo where tid = $id;");
		if (mysql_errno()){
			$msg = "Cannot delete Template.";
		}else{
			header("Location: report_manage.php");
			exit;
		}

}else if ($_GET['action'] == "preview"){ // PREVIEW TEMPLATE
	$result = mysql_query("select * from templateinfo where tid=$id");
	if ($result){
		$rs = mysql_fetch_assoc($result);
		$tdata = stripslashes($rs['tdata']);
		eval($tdata);
		include "report.inc.php";
		exit;

	}else{
		$msg = "Cannot find template.";
	}
	
}
?>
<html>
<head>
<title>Report Management : Template</title>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<link href="report.css" type="text/css" rel="stylesheet">
</head>
<body bgcolor="#FFFFFF">
<table border=0 width="100%" cellspacing=1 bgcolor="black">
    <tr>
        <td>
        <?php
        // @modify Phada Woodtikarn 21/07/2014 เนื่องจาก menu ใช้หลายหน้าเลยสร้างไว้อันเดียว
        include "report_top_menu.php";
        // @end
        ?>
        </td>
    </tr>
</table>

<table border=0 width="100%" cellspacing=0 CELLPADDING=0>
<tr BGCOLOR="#AACCEE"><td>
<?php
// ERROR MESSAGE
if ($msg){
	echo "<h1 align=center>$msg</h1></body></html>";
	exit;
}
if ($_GET['action'] == "save"){
	$result = mysql_query("select * from reportinfo where rid=$id");
	if ($result){
		$rs = mysql_fetch_assoc($result);
	}else{
		echo "<h1 align=center><BR><BR>Cannot find report.</h1></body></html>";
		exit;
	}
?>
<BR>
&nbsp; <B style="font-size: 14pt;">Save as Template</B>


<table border=0 width="100%" cellspacing=0 CELLPADDING=0>
<tr HEIGHT=1 BGCOLOR="#000000"><td></td></tr>
</table>


<FORM ACTION="?action=new" METHOD=POST>
<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
<table border=0 width="80%" align=center cellspacing=0 CELLPADDING=0>
<tr><td><B>Report Caption</B></td><td>
<B><?=$rs['caption']?></B> [<A HREF="report_preview.php?id=<?=$id?>" target="_blank">Preview</A>]
</td></tr>

<tr valign=top><td><B>Report Description</B></td><td>
<?=$rs['comment']?><BR><BR>
</td></tr>

<tr><td><B>Template Name</B></td><td><INPUT TYPE="text" NAME="caption" VALUE="<?=$rs['caption']?>" size="60" maxlength="100"></td></tr>
<tr valign=top><td><B>Description</B></td><td><TEXTAREA NAME="comment" ROWS="6" COLS="60"><?=$rs['comment']?></TEXTAREA></td></tr>

<tr><td>&nbsp;</td><td ALIGN=LEFT><INPUT TYPE="SUBMIT" VALUE=" Save Template ">
<INPUT TYPE="reset" VALUE="   Reset   "></td></tr>

<?php
if ($_GET['msg2']){
	echo "<tr><td>&nbsp;</td><td><B>$_GET[msg2]</B></td></tr>";
}
?>

</table>
</FORM>

<?php
}else if ($_GET['action'] == "edit"){
	$result = mysql_query("select * from templateinfo where tid=$id");
	if ($result){
		$rs = mysql_fetch_assoc($result);
	}else{
		echo "<h1 align=center><BR><BR>Cannot find template.</h1></body></html>";
		exit;
	}
?>

<BR>
&nbsp; <B style="font-size: 14pt;">Edit Template</B>


<table border=0 width="100%" cellspacing=0 CELLPADDING=0>
<tr HEIGHT=1 BGCOLOR="#000000"><td></td></tr>
</table>


<FORM ACTION="?action=update" METHOD=POST>
<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
<table border=0 width="80%" align=center cellspacing=0 CELLPADDING=0>

<tr><td><B>Template Name</B></td><td><INPUT TYPE="text" NAME="caption" VALUE="<?=$rs['caption']?>" size="60" maxlength="100"></td></tr>
<tr valign=top><td><B>Description</B></td><td><TEXTAREA NAME="comment" ROWS="6" COLS="60"><?=$rs['comment']?></TEXTAREA></td></tr>

<tr><td>&nbsp;</td><td ALIGN=LEFT><INPUT TYPE="SUBMIT" VALUE=" Update Template ">
<INPUT TYPE="reset" VALUE="   Cancel   " ONCLICK="history.back();"></td></tr>
<?php
if ($_GET['msg2']){
	echo "<tr><td>&nbsp;</td><td><B>$_GET[msg2]</B></td></tr>";
}
?>
</table>
</FORM>
<?php
}	 // end if
?>

</table>
<BR><BR>

</td></tr>
<tr HEIGHT=1 BGCOLOR="#000000"><td></td></tr>
</table>


</body>
</html>
