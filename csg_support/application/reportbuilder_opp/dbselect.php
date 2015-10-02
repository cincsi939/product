<?php
/*****************************************************************************
Function		: เลือกฟีลด์ หรือ สร้าง Query จากฐานข้อมูล
Version			: 1.0
Last Modified	: 25/7/2548
Changes		:
	25/7/2548	- ตัด \ ออก (stripslashes)
					- เมื่อกด Validate ให้แสดงผลลัพธ์ด้วย

*****************************************************************************/
?>
<?php
include "db.inc.php";
$chk = array();
if(!isset($_SESSION['dbname'])){
	$_SESSION['dbname'] = "";
}
if(!isset($_SESSION['tbname'])){
	$_SESSION['tbname'] = "";
}
if ($_SERVER['REQUEST_METHOD'] == "POST"){ 
	// remove slashes from variable
	foreach ($_POST as $key => $value){
		if (!is_array($value) && !is_numeric($value)){
			$_POST[$key] = stripslashes($value);
		}
	}
	if ($_GET['action'] == "selectdb"){
		$_SESSION['dbname'] = $_POST['dbname'];
		$_SESSION['step'] = 2;
	}else if ($_GET['action'] == "selecttb"){
		$_SESSION['tbname'] = $_POST['tbname'];
		$_SESSION['step'] = 3;
	}else if ($_GET['action'] == "makecond"){
		
		$cond = "";
		$fldname = $_POST['fldname'];
		$func = $_POST['func'];
		foreach ($_POST['fields'] as $key => $value){
			if ($value){
				if ($cond == ""){
					$cond .= "(" . $_SESSION['tbname'] . "." . $fldname[$key] . " " .  $func[$key] . " '$value') ";
				}else {
					$cond .= " AND (" . $_SESSION['tbname'] . "." . $fldname[$key] . " " .  $func[$key] . " '$value') ";
				}
			}
		}

		$fldlist = "";
		$sel = $_POST['sel'];
		for ($i=0;$i<count($sel);$i++){
			if ($fldlist != "") $fldlist .= ",";
			$fldlist .= $sel[$i];

			$chk[$sel[$i]] = "CHECKED";
		}
		if ($cond > ""){
			$cond = "select " . $fldlist . " from " .  $_SESSION['tbname'] . " Where $cond";
		}else{
			$cond = "select " . $fldlist . " from " . $_SESSION['tbname'];
		}
		$_SESSION['step'] = 4;

	}else if ($_GET['action'] == "testcond"){
		if ($_POST['cond'] > ""){
			$_POST['cond'] = stripslashes($_POST['cond']); //25/7/2548
//			$sql = "select * from " . $_SESSION[dbname] . "." . $_SESSION[tbname] . " Where " . $_POST[cond];
			$vresult = @mysql_query($cond);
			if (mysql_errno() != 0){
				$msg = "Error in SQL condition <BR><b>" . $sql . "</b><BR>" . mysql_error() ;
			}else{
				$msg = "Correct!";
			}
		}

		// Find CheckBox
		$sel = $_POST['sel'];
		for ($i=0;$i<count($sel);$i++){
			$chk[$sel[$i]] = "CHECKED";
		}

	}

}else{//GET
	if ($_GET['action'] == "init")
	{
//		$_SESSION[step]=0;
		$_SESSION['type']=$_GET['type'];
		if(isset($_GET['in'])){
			$_SESSION['in'] = $_GET['in'];
		}else{
			$_SESSION['in'] = "";
		}
		if(isset($_GET['select'])){
			$_SESSION['select'] = $_GET['select'];
		}else{
			$_SESSION['select'] = "";
		}
		$_SESSION['dbserver'] = "";
		$_SESSION['dbuser']="";
		$_SESSION['dbpwd']="";

		if(isset($_GET['db']) && $_GET['db'] != ''){
			$_SESSION['dbname'] = $_GET['db'];
			$_SESSION['step'] = 2;
		}else{
			$_SESSION['step'] = 1;
//			$_SESSION[dbname]="";
		}

		if(isset($_GET['tb']) && $_GET['tb'] != ''){
			$_SESSION['tbname']=$_GET['tb'];
			$_SESSION['step'] = 3;
		}else{
//			$_SESSION[dbname]="";
		}

		if ($_GET['val'] && $_GET['type']=="cond"){
			$cond = $_GET['val'];
		}
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Database Selection Tools</title>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<link href="report.css" type="text/css" rel="stylesheet">
<script language="JavaScript"> 
<!--
function ylib_Browser()
{
	d=document;
	this.agt=navigator.userAgent.toLowerCase();
	this.major = parseInt(navigator.appVersion);
	this.dom=(d.getElementById)?1:0;
	this.ns=(d.layers);
	this.ns4up=(this.ns && this.major >=4);
	this.ns6=(this.dom&&navigator.appName=="Netscape");
	this.op=(window.opera? 1:0);
	this.ie=(d.all);
	this.ie4=(d.all&&!this.dom)?1:0;
	this.ie4up=(this.ie && this.major >= 4);
	this.ie5=(d.all&&this.dom);
	this.win=((this.agt.indexOf("win")!=-1) || (this.agt.indexOf("16bit")!=-1));
	this.mac=(this.agt.indexOf("mac")!=-1);
};

var oBw = new ylib_Browser();

function DisplayElement ( elt, displayValue ) {
	if ( typeof elt == "string" )
		elt = document.getElementById( elt );
	if ( elt == null ) return;

	if ( oBw && oBw.ns6 ) {
		// OTW table formatting will be lost:
		if ( displayValue == "block" && elt.tagName == "TR" )
			displayValue = "table-row";
		else if ( displayValue == "inline" && elt.tagName == "TR" )
			displayValue = "table-cell";
	}

	elt.style.display = displayValue;
}

function SetDB(){
	window.opener.dbname = "<?=$_SESSION['dbname']?>";
	window.opener.tbname = "<?=$_SESSION['tbname']?>";
}

function SelectField(val1){
	SetDB();
<?php
if ($_SESSION['select'] == "multi"){
?>
	if (window.opener.obj1.value == ""){
		window.opener.obj1.value = val1;
	}else{
		window.opener.obj1.value += "," + val1;
	}
<?php
}else{
?>
	window.opener.obj1.value = val1;
<?php
}
?>
	window.close();
}

function SelectCond(val1){
	SetDB();
	window.opener.obj1.value = val1;
	window.close();
}
//--> 
</script>
</head>
<body>
<FORM ACTION="?action=selectdb" METHOD=POST>
<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH="100%">
<TR BGCOLOR="#404040" HEIGHT=1></TR>
<TR BGCOLOR="#666699" HEIGHT="30" VALIGN=MIDDLE><TD>
&nbsp; <B>Select database </B>
<?php
	$result = @mysql_query("show databases;");
	echo "<SELECT NAME='dbname'>";
	while ($rs = @mysql_fetch_array($result,MYSQL_NUM)){
		if ($rs[0] == $_SESSION['dbname']){
			echo "<OPTION SELECTED VALUE='$rs[0]'>$rs[0]\n";
		}else{
			echo "<OPTION VALUE='$rs[0]'>$rs[0]\n";
		}
	}
	echo "</SELECT>";

?> 
<INPUT TYPE="submit" VALUE=" Select Database " CLASS="xbutton">
</TD>
<TD WIDTH="70" ALIGN=RIGHT>
<INPUT TYPE="button" VALUE=" Close "  CLASS="xbutton" ONCLICK="window.close();"> &nbsp;
</TD>
</TR>

</TABLE>
</FORM>

<TABLE WIDTH="100%" BORDER=0 BGCOLOR=BLACK CELLSPACING=1 CELLPADDING=5>
<TR VALIGN=TOP><TD BGCOLOR="#334488" WIDTH="200" ALIGN=CENTER>
<?php
	if(intval($_SESSION['step']) >= 2){
?>
<FORM ACTION="?action=selecttb" METHOD="POST">
<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 >
<TR><TD ALIGN=CENTER>
<FONT COLOR="WHITE">Table in <BR><U><B><?=$_SESSION['dbname']?></B></U></FONT><BR><BR>
<?php
	@mysql_select_db($_SESSION['dbname']) or die("Cannot Select Database.");

	$result = @mysql_query("Show Tables;");
	echo "<SELECT NAME='tbname' SIZE=15 STYLE='width:200;'>";
	while ($rs = @mysql_fetch_array($result,MYSQL_NUM)){
		if ($rs[0] == $_SESSION['tbname']){
			echo "<OPTION SELECTED VALUE='$rs[0]'>$rs[0]\n";
		}else{
			echo "<OPTION VALUE='$rs[0]'>$rs[0]\n";
		}
	}
	echo "</SELECT>";

?> 
<BR><INPUT TYPE="submit" VALUE=" Select Table " CLASS="xbutton">
</TD>
</TR>
</TABLE>
</FORM>

</TD><TD WIDTH="85%" BGCOLOR="#F0F0F0" id="structure" STYLE="display:block;">
<?php
	} // if (intval($_SESSION[step]) == 2){
	if (intval($_SESSION['step']) >= 3){
?>
<FORM ACTION="?action=selectfld" METHOD=POST>
<FONT SIZE="+1"><B>Structure of  <U><?=$_SESSION['tbname']?></U></B></FONT>
<INPUT TYPE="image" SRC="img/button_select.png" ALT="Create SQL Query" ONCLICK="DisplayElement('query','block'); DisplayElement('structure','none'); return(false);"> <BR><BR>
<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=5 BGCOLOR=BLACK >
<?php
	$i=0;
	$result = @mysql_query("Describe $_SESSION[tbname];");
	echo "<TR BGCOLOR='#D0D0D0'><TH>No.</TH><TH>Field Name</TH><TH>Field Type</TH><TH>&nbsp;</TH></TR>";
	while ($rs = @mysql_fetch_array($result,MYSQL_NUM)){
		$i++;
		if ($rs[3] == "PRI"){
			echo "<TR BGCOLOR=WHITE><TD ALIGN=CENTER>$i</TD><TD><U>$rs[0]</U></TD><TD>$rs[1]</TD><TD><INPUT TYPE='BUTTON' VALUE=' Select ' ONCLICK=\"SelectField('$_SESSION[dbname].$_SESSION[tbname].$rs[0]');\"></TD></TR>";
		}else	{
			echo "<TR BGCOLOR=WHITE><TD ALIGN=CENTER>$i</TD><TD>$rs[0]</TD><TD>$rs[1]</TD><TD><INPUT TYPE='BUTTON' VALUE=' Select ' ONCLICK=\"SelectField('$_SESSION[dbname].$_SESSION[tbname].$rs[0]');\"></TD></TR>";
		}
	}

?> 

</TABLE>
</FORM>

</TD><TD WIDTH="85%" BGCOLOR="#F0F0F0" id="query" STYLE="display:none;">

<SCRIPT LANGUAGE="JavaScript">
<!--
function CheckAll(val){
	var f1 = document.condForm;
    var elts      = f1.elements['sel[]'] ;
    var elts_cnt  = (typeof(elts.length) != 'undefined') ? elts.length : 0;

    if (elts_cnt) {
        for (var i = 0; i < elts_cnt; i++) {
            elts[i].checked = val;
        } // end for
    } else {
        elts.checked   = val;
    } // end if... else

    return true;
}
//-->
</SCRIPT>

<FORM ACTION="?action=makecond" METHOD=POST NAME="condForm">
<FONT SIZE="+1"><B>Query from table : <U><?=$_SESSION['dbname']?>.<?=$_SESSION['tbname']?></U></B></FONT> 
<INPUT TYPE="image" SRC="img/button_browse.png" ALT="View Structure" ONCLICK="DisplayElement('query','none'); DisplayElement('structure','block'); return(false);"> <BR><BR>
<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=5 BGCOLOR=BLACK >
<?

	$i=0;
/*	24/10/2548
	if ($_GET[action] == "selecttb"){
		$isChecked = "CHECKED";
	}else{
		$isChecked = "";
	}
	*/

	$result = @mysql_query("Describe $_SESSION[tbname];");
	echo "<TR BGCOLOR='#D0D0D0'><TH><INPUT TYPE='checkbox' NAME='chkall' $isChecked ONCLICK='CheckAll(this.checked);'></TH><TH>Field</TH><TH>Type</TH><TH>Function</TH><TH>Value</TH></TR>";
	while ($rs = @mysql_fetch_array($result,MYSQL_NUM)){
		$i++;

		if ($_GET['action'] == "makecond"){
			if (isset($chk[$rs[0]])){
				$isChecked = $chk[$rs[0]];
			}else{
				$isChecked = "";
			}
		}else if ($_GET['action'] == "testcond"){
			$isChecked = "";
		}else{
			$isChecked = "";
		}

		echo "<TR BGCOLOR=WHITE>";
		echo "<TD ALIGN=CENTER><INPUT TYPE='checkbox' NAME='sel[]' VALUE='$rs[0]' $isChecked></TD>";
		echo "<TD>$rs[0]</TD><TD>$rs[1]</TD><TD>";
		if (strtoupper(substr($rs[1],0,3)) == "CHAR" || strtoupper(substr($rs[1],0,7)) == "VARCHAR" ||
			strtoupper(substr($rs[1],0,4)) == "TEXT" || strtoupper(substr($rs[1],0,8)) == "TINYBLOB" ||
			strtoupper(substr($rs[1],0,8)) == "TINYTEXT" || strtoupper(substr($rs[1],0,4)) == "BLOB" ||
			strtoupper(substr($rs[1],0,10)) == "MEDIUMBLOB" || strtoupper(substr($rs[1],0,10)) == "MEDIUMTEXT" ||
			strtoupper(substr($rs[1],0,8)) == "LONGBLOB" || strtoupper(substr($rs[1],0,8)) == "LONGTEXT" ){

			echo "<select name='func[]'><option value='LIKE'>LIKE</option><option value='='>=</option><option value='!='>!=</option> </select>";
		} else {
			echo "<select name='func[]]'><option value='='>=</option><option value='&gt;'>&gt;</option> <option value='&gt;='>&gt;=</option><option value='&lt;'>&lt;</option><option value='&lt;='>&lt;=</option> <option value='!='>!=</option><option value='LIKE'>LIKE</option></select>";
		}
		echo "<INPUT TYPE='hidden' NAME='fldname[]' VALUE='$rs[0]'>";
		echo "</TD><TD><INPUT TYPE='text' NAME='fields[]' SIZE='40'></TD></TR>";
	}

?> 
</TABLE>
<BR>
<INPUT TYPE="SUBMIT" VALUE=" Create Query "> <INPUT TYPE="reset" VALUE=" Reset ">
</FORM>

<FORM ACTION="?action=testcond" METHOD=POST NAME="cform">
<B>Query</B> <BR>
<TEXTAREA NAME="cond" ROWS="5" COLS="80"><?=$cond?></TEXTAREA><BR>
<INPUT TYPE="SUBMIT" VALUE=" Validate "  CLASS="xbutton"> 
<INPUT TYPE="button" VALUE=" Reset " CLASS="xbutton" ONCLICK="document.cform.cond.value='';"> 
<INPUT TYPE="BUTTON" VALUE=" * Select " CLASS="xbutton" ONCLICK="SelectCond(document.cform.cond.value);">

</FORM>
<?
	if  (isset($msg) && $msg > ""){
		echo "<FONT COLOR=RED><B>* $msg</B></FONT><BR>";

		// 25/7/2548 แสดงผลลัพธ์ของการ Validate
		if ($cond > "" && $msg == "Correct!"){  
			$firstrow = true;
			while ($vrs = mysql_fetch_assoc($vresult)){
				if ($firstrow){
					$firstrow = false;
					echo "<B>Result from Query : </B>";
					echo "<table cellspacing=1 cellpadding=2 bgcolor='#404040'>";
					echo "<TR BGCOLOR='#99CCCC'>";
					foreach ($vrs as $fldname => $fldvalue){
						echo "<TD align=center><b>" . $fldname . "</b></TD>";
					}
					echo "</TR>";
				}

				echo "<tr bgcolor=white valign=top>";
				foreach ($vrs as $fldname => $fldvalue){
					echo "<td><b>" . $fldvalue . "</b></td>";
				}
				echo "</tr>";

			} // while

			if ($firstrow){
				echo "<B>Result from Query : </B> No result.<BR><BR>";
			}else{
				echo "</table><BR>";
			}

		}// if

	}

if (intval($_SESSION['step']) >= 4 || $_SESSION['type'] == "cond"){  // tested condition
?>
<Script Language="JavaScript">DisplayElement('query','block'); DisplayElement('structure','none');</Script>
<?
}
?>


<?
	} // 	if (intval($_SESSION[step]) >= 3){
?>

</TD></TR></TABLE>

</body>
</html>