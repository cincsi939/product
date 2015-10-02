<?php
/**
 * @comment ตั้งค่า report information
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    25/06/2014
 * @access     public
 */
/*****************************************************************************
Function		: จัดการข้อมูลส่วนของ Information Port
Version			: 1.0
Last Modified	: 
Changes		:


*****************************************************************************/
include "db.inc.php";

// field's name & value for Table Header section
$sec = "I";
$tab ="table2";
$tsize = "tsize2";

$id = "";
$action = "";
if(isset($_GET['id'])){
	$id = intval($_GET['id']);
}
if(isset($_GET['action'])){
	$action = $_GET['action'];	
}
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == "POST"){ 
	// remove slashes from variable
	foreach ($_POST as $key => $value){
		if (!is_array($value) && !is_numeric($value)){
			$_POST[$key] = stripslashes($value);
		}
	}
	
	if ($action=="updatecell"){
		$id = intval($_POST['id']);
		$cell = $_POST['cell'];
		$caption = addslashes(str_replace("\"","'",$_POST['caption']));
		$font = addslashes(str_replace("\"","'",$_POST['font']));
		$alignment = addslashes(str_replace("\"","'",$_POST['alignment']));
		$valign = addslashes(str_replace("\"","'",$_POST['valign']));
		$bgcolor = addslashes(str_replace("\"","'",$_POST['bgcolor']));
		$url = addslashes(str_replace("\"","'",$_POST['url']));
		$cond = addslashes(str_replace("\"","'",$_POST['cond']));
		$furl = addslashes(str_replace("\"","'",$_POST['furl']));
		$fldname = addslashes(str_replace("\"","'",$_POST['fldname']));
		$nformat = intval($_POST['nformat']);
		$decpoint = intval($_POST['decpoint']);
		$celltype = intval($_POST['celltype']);
		$aggregate = intval($_POST['aggregate']);
		$nblank = intval($_POST['nblank']);
		if ($celltype == 0) $cond = "";   // no condition for TextCell
		if ($celltype == 2) $cond = $fldname;   // Keep Field Name in cond
		if ($celltype == 3) $cond = $furl;   // Keep function URL in cond
		// @modify Phada Woodtikarn 30/06/2014 เพิ่ม url type
		$urltype = intval($_POST['urltype']);
		// @end
		// @modify Phada Woodtikarn 18/08/2014 เพิ่ม bgcolor_type
		$bgcolor_type = intval($_POST['bgtype']);
		if($bgcolor_type != 0){
			
			function saveStyleBG($type,$bg,$start,$end){
				if($type == 0){
					if(is_array($bg)){
						$reval = $bg[0];
					}else{
						$reval = $bg;
					}
				}else{
					$reval = $type.'|'; 
					foreach($bg as $key => $value){
						if($start[$key] > $end[$key]){
							$reval .= $bg[$key].'|'.$end[$key].'|'.$start[$key].'|';
						}else{
							$reval .= $bg[$key].'|'.$start[$key].'|'.$end[$key].'|';
						}
					}
				}
				return $reval;
			}
			$bgcolor2 = $_POST['bgcolor2'];
			$startvalue = $_POST['startvalue'];
			$endvalue = $_POST['endvalue'];
			$bgcolor = saveStyleBG($bgcolor_type,$bgcolor2,$startvalue,$endvalue);
		}
		// @end
		// Delete old value
		mysql_query("delete from cellinfo where rid='$id' and uname='$uname' and sec='$sec' and cellno='$cell';");

		// Insert new value
		// @modify Phada Woodtikarn 30/06/2014 เพิ่ม url type
		$sql = "INSERT INTO cellinfo(uname,rid,sec,cellno,caption,font,alignment,valign,bgcolor,url,cond,celltype,nformat,decpoint,urltype,nblank) values('$uname','$id','$sec','$cell','$caption','$font','$alignment','$valign','$bgcolor','$url','$cond',$celltype,$nformat,$decpoint,$urltype,$nblank);";
		// @end
		mysql_query($sql);

		if (mysql_errno()){
			$msg = "Cannot save cell's properties..";
		}else{
			header("Location: ?id=$id");
			exit;
		}

	}else if ($action=="mergecell"){
		$id = intval($_POST['id']);

		$cellset = "";
		foreach ($_POST as $key=>$value){
			if (substr($key,0,1) == "C" && $value == "1"){  // selected cell
				$cellno = $key;
				$cellno = str_replace("C","",$cellno);
				$cellno = str_replace("_",".",$cellno);
				if ($cellset > "") $cellset .= ",";
				$cellset .= "'$cellno'";

				$xresult = mysql_query("select * from cellinfo where rid='$id' and uname='$uname' and sec='$sec' and cellno='$cellno';");
				if (mysql_num_rows($xresult) <= 0){ // not found
					mysql_query("insert into cellinfo(uname,rid,sec,cellno) values('$uname','$id','$sec','$cellno');"); // INSERT IT TO cellinfo
				}

			}
		}

		if (isset($_POST['delete']) && $_POST['delete'] > ""){
			// CLEAR Cell's Properties
			$sql = "delete from cellinfo where rid='$id' and uname='$uname' and sec='$sec' and cellno in ($cellset);";
			mysql_query($sql);
			header("Location: ?id=$id");
			exit;
		}else if (isset($_POST['property']) && $_POST['property'] > ""){
			$nformat = intval($_POST['nformat']);
			$decpoint = intval($_POST['decpoint']);
			$alignment = $_POST['alignment'];
			$valign = $_POST['valign'];
			$font = addslashes($_POST['font']);
			$bgcolor = $_POST['bgcolor'];
			$nblank = intval($_POST['nblank']);
			
			$xval = "";
			if (isset($_POST['xnformat']) && $_POST['xnformat'] == "1"){
				$xval = "nformat = $nformat";
			}

			if (isset($_POST['xdecpoint']) && $_POST['xdecpoint'] == "1"){
				if ($xval > "") $xval .=",";
				$xval .= "decpoint = $decpoint";
			}

			if (isset($_POST['xalignment']) && $_POST['xalignment'] == "1"){
				if ($xval > "") $xval .=",";
				$xval .= "alignment = '$alignment'";
			}

			if (isset($_POST['xvalign']) && $_POST['xvalign'] == "1"){
				if ($xval > "") $xval .=",";
				$xval .= "valign = '$valign'";
			}

			if (isset($_POST['xfont']) && $_POST['xfont'] == "1"){
				if ($xval > "") $xval .=",";
				$xval .= "font = '$font'";
			}

			if (isset($_POST['xbgcolor']) && $_POST['xbgcolor'] == "1"){
				if ($xval > "") $xval .=",";
				$xval .= "bgcolor = '$bgcolor'";
			}
			
			if (isset($_POST['xnblank']) && $_POST['xnblank'] == "1"){
				if ($xval > "") $xval .=",";
				$xval .= "nblank = '$nblank'";
			}

			if ($xval > ""){
				$sql = "update cellinfo set $xval where rid='$id' and uname='$uname' and sec='$sec' and cellno in ($cellset);";

				mysql_query($sql);
			}

			header("Location: ?id=$id");
			exit;
		}
	}

}else if ($id > 0){
	$sql = "SELECT tsize2,table2,bsize2,bcolor2,hidecondition FROM `reportinfo` WHERE rid='$id' AND uname='$uname';";
	$result = mysql_query($sql);
	if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		if($rs){
			$x = explode("x",$rs[$tsize]);
			$r = intval($x[0]);
			$c = intval($x[1]);
	
			$tspan=array();
			$tbrow = explode("|",$rs[$tab]);
			for ($i=0;$i<count($tbrow);$i++){
				$tbcol = explode("*",$tbrow[$i]);
				for ($j=0;$j<count($tbcol);$j++){
					$tspan[$i][$j] = $tbcol[$j];
				}
			}
			$hidecondition = $rs['hidecondition'];
		}else{
			$msg = "Cannot find Report.";
		}
	} else {
		$msg = "Cannot find Report.";
	}

} else if ($msg == ""){
	$msg = "Cannot find Report.";
}





$do = "";
if(isset($_REQUEST['do'])){
	$do = $_REQUEST['do'];
}
	if($do == "updatesql"){
		
		 if ($action == "updatesql"){ 
			
			$sqlname = addslashes($_POST['txtsql']);
			$query = $_POST['txtquery'];
			$desc = $_POST['txtdesc'];
	
			if($sqlname != ""){
				$sql="select * from report_sqldata where rid='$id' and uname='$uname' and sec='$sec' and sqlname='$sqlname';";
				$result = mysql_query($sql);
				$rs = mysql_fetch_array($result);
				if($rs['sqlname']==""){  
					$sql = "insert into report_sqldata(uname, rid, sec, sqlname, query, description) values('$uname', '$id', '$sec', '$sqlname', '$query', '$desc');";
					mysql_query($sql);
				}else{
					$sql = "update report_sqldata set query='$query', description='$desc' where rid='$id' and uname='$uname' and sec='$sec' and sqlname='$sqlname';";
					mysql_query($sql);
				}
			}
			
			header("Location: ?id=$id");
			exit;
			
		}else  if ($action == "deletesql"){
			$sqlname = addslashes($_POST['txtsql']);
			$sql = "delete from report_sqldata  where rid='$id' and uname='$uname' and sec='$sec' and sqlname='$sqlname';";
			mysql_query($sql);
			
			header("Location: ?id=$id");
			exit;
		}
	}
?>

<html>
<head>
<title>Report Management : Table Header</title>
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
<td><img src="<?php echo $imgpath ?>tabx3.gif" border=0></td>
<td><a href="report_footer.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab4.gif" border=0></a></td>
<td><a href="report_param.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab5.gif" border=0></a></td>
<td width="50%"><img src="<?php echo $imgpath ?>/black.gif" width="100%" height="1"></td>
</tr>
</table> 

<table border=0 width="100%" cellspacing=0 CELLPADDING=0>
<tr BGCOLOR="#6F96C6"><td><FONT SIZE="-2" COLOR="WHITE">&nbsp;Information Port section.</FONT></td></tr>
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
?>

<A HREF="report_preview.php?id=<?=$id?>&sec=<?=$sec?>" title="Preview" target="_blank"><img src="<?php echo $imgpath; ?>preview.gif" border="0" style="margin-right:5px">Preview this section</A>
&nbsp; <A HREF="report_export.php?id=<?=$id?>&sec=<?=$sec?>" title="Export" target="_blank"><img src="<?php echo $imgpath; ?>export.gif" border="0" style="margin-right:5px">Export this section</A>
<br>
<br>
<script src="js/jquery-1.10.1.min.js"></script>
<link rel="stylesheet" href="js/jquery-ui-themes-1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="js/jstable/dragtable.css" />
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="js/jquery-numeric.js"></script>
<script src="js/jstable/jquery.dragtable.js"></script>
<script src="js/kolorpicker/jquery.kolorpicker.js" type="text/javascript"></script>
<link rel="stylesheet" href="js/kolorpicker/style/kolorpicker.css" type="text/css" />
<script>
	$(document).ready(function(){
		$('#tableinfo').show();
	});
	function chkAll(n){
		if(n==1){	
			$('input.checkfield').attr('checked', true);
		}else {
			$('input.checkfield').removeAttr('checked');			
		}	
	}
</script>
<div style="" align="center">
	<INPUT TYPE="BUTTON" VALUE=" SQL-Set "  ONCLICK="SqlSetDialog();">
	<?php include  "dbset.php";?>
</div>

<BR>
<!-- Display Table but NO Merge Cell -->
<table border=0 width="100%" cellspacing=0 cellpadding=0 bgcolor="WHITE">
<tr><td>
<BR>

<form action="?action=mergecell" method=POST NAME="mergeform">
<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">

<!-- TABLE HEADER -->
<table id="tableinfo" border="0" bgcolor="black" width="90%" align="center" cellspacing="1" cellpadding="0" style="display:none;">
<?
$px = intval(100 / $c); // ความกว้างแต่ละเซล
for ($i=1;$i<=$r;$i++){
	echo "<tr bgcolor='#A3B2CC' valign=top>";
	for ($j=1;$j<=$c;$j++){
		$x = explode("x",$tspan[$i-1][$j-1]);
		$rspan = intval($x[0]);
		$cspan = intval($x[1]);
		if ($rspan > 0 && $cspan > 0){
?>
<td <?=GetCellProperty($id,"H",$i . "." . $j)?> width='<?=$px?>%' colspan='<?=$cspan?>' rowspan='<?=$rspan?>'>
	<?=GetCellValue($id,"H",$i . "." . $j)?>
</td>
<?
		}
	}
	echo "</tr>";
}
?>
<!-- END TABLE HEADER -->


<!-- INFORMATION PORT / NO SPAN / 2 ROWS-->
<?
// BGCOLOR
$bg[1] = "#FF6633";   $mbg[1] = "#DDDDDD";			// Data Row
$bg[2] = "#996600";   $mbg[2] = "#A3B2CC";			// Summarize Row


$px = intval(100 / $c); // ความกว้างแต่ละเซล
for ($i=1;$i<=2;$i++){   // 2 ROWS ONLY
	echo "<tr bgcolor='$mbg[$i]' valign=top>";
	for ($j=1;$j<=$c;$j++){
?>
<td <?=GetCellProperty($id,$sec,$i . "." . $j)?> width='<?=$px?>%' colspan='1' rowspan='1'>
	<table border=0 cellspacing=0 cellpadding=0 width='40' height="20" align="left"> 
		<tr valign=top>
			<td align=center width=25 bgcolor='<?=$bg[$i]?>'><A HREF="?action=cell&id=<?=$id?>&cell=<?=$i?>.<?=$j?>" title="Edit Cell Properties"><FONT COLOR="BLACK"><B><U><?=$i?>.<?=$j?></U></B></FONT></A></td>
			<td width=15 align=left><input type="checkbox" class="checkfield" name="C<?=$i?>_<?=$j?>" value="1"></td>
		</tr>
	</table>

	<?=GetCellValue($id,$sec,$i . "." . $j)?>

</td>
<?
	}
	echo "</tr>";
}
?>
</table>
<table border=0 width="90%" align=center cellspacing=1 cellpadding=0>
<tr><td align=right>
<?php // @modify Phada Woodtikarn 22/07/2014 เพิ่ม Check all และ Unccheck all ?>
<input type="button" value=" Check all " style="font-weight: bold;" onClick="chkAll(1)">
<input type="button" value=" Uncheck all " style="font-weight: bold;" onClick="chkAll(0)">
<?php // @end ?>
<input type="submit" value=" Clear Selected Cell " style="font-weight: bold;" name="delete" onClick="if (!confirm('ต้องการลบข้อมูลนี้จริงหรือไม่?')) return false;">
<input type="button" value=" Selected Cell's Property " style="font-weight: bold;" name="delete" onClick="DisplayElement ( 'cellprop', 'table');">
<input type="reset" value=" Undo " style="font-weight: bold;">
</td></tr>
</table>

<BR>
<table border=0 width="90%" align=center cellspacing=0 cellpadding=0 bgcolor=white><tr><td>
<table border=0 cellspacing=0 cellpadding=2>
<tr height="20">
<td><B>Note :</B> &nbsp;</td>
<td align=center width=25 bgcolor='<?=$bg[1]?>'> <B><U>1.x</U></B></A></td> <td>Data Port</td>
<td width=10>&nbsp;</td>
<td align=center width=25 bgcolor='<?=$bg[2]?>'> <B><U>2.x</U></B></A></td> <td>Summarize Port</td>
</tr>
</table>
</tr></table>
<BR>
<!-- END INFORMATION PORT -->

<BR>
<?php
include "selectedcellprop.inc.php";
?>
</form>
<!-- End Display Table & Merge Cell -->
<?php
if($action == "cell" && !isset($_GET['cell'])){
	$_GET['cell'] = "";
}
if ($action == "cell" && $_GET['cell'] > 0){
	$cell = $_GET['cell'];
	$sql = "select * from cellinfo where rid='$id' and uname='$uname' and sec='$sec' and cellno='$cell';";
	$result = mysql_query($sql);
	if ($result){
		$crs=mysql_fetch_array($result,MYSQL_ASSOC);
	}else{
		$crs = array();
	}
	
	$bg1 = $bg[substr($cell,0,1)];
?>
<FORM name="cellform" method="post" action="?action=updatecell&id=<?=$id?>">
<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
<INPUT TYPE="hidden" NAME="cell" VALUE="<?=$cell?>">
<table border=0 width="80%" align=center cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white><td align=LEFT>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr valign="middle" height="30"> 
          <td align="center" width="35" bgcolor="<?=$bg1?>"><b style="font-size: 12pt;"><?=$_GET['cell']?></b></td>
		  <td width="1" BGCOLOR=BLACK></td>
          <td align="left" width="60%" bgcolor="#999999"><b style="font-size: 12pt;">&nbsp;&nbsp;Cell Properties :</b></td>
          <td align="RIGHT" bgcolor="#999999"> 
			<INPUT TYPE="submit" VALUE=" Save " STYLE="font-weight: bold;"> 
			<INPUT TYPE="button" VALUE=" Cancel " STYLE="font-weight: bold;" ONCLICK="location.href='?id=<?=$id?>';"> &nbsp;
		  </td>
        </tr>
      </table>
</td></tr>
<tr bgcolor="#F0F0F0"><td align=LEFT>

      <br>
              <table width="90%" border="0" cellspacing="1" cellpadding="2" align="CENTER" bgcolor="#6699E0">

                <tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130"> 
                    &nbsp;&nbsp;<B>Cell Type</B></td>
                  <td align="left" width="500">  
		              <input type="radio" name="celltype" value="0" <? if (intval($crs['celltype'])==0) echo "CHECKED";?> ONCLICK="DisplayElement ( 'condition', 'none');DisplayElement ( 'field', 'none');DisplayElement ( 'function', 'none');DisplayElement ( 'sqlarr', 'none');"> <B>TEXT</B> 
				      <input type="radio" name="celltype" value="1" <? if (intval($crs['celltype'])==1) echo "CHECKED";?> ONCLICK="DisplayElement ( 'condition', 'block');DisplayElement ( 'field', 'none');DisplayElement ( 'function', 'none');DisplayElement ( 'sqlarr', 'none');DisplayElement ( 'sqlquery', 'inline');"> <B>DATABASE</B> 
				      <input type="radio" name="celltype" value="2" <? if (intval($crs['celltype'])==2) echo "CHECKED";?> ONCLICK="DisplayElement ( 'condition', 'none');DisplayElement ( 'field', 'block');DisplayElement ( 'function', 'none');DisplayElement ( 'sqlarr', 'none');"> <B>FIELD</B> 
				      <input type="radio" name="celltype" value="3" <? if (intval($crs['celltype'])==3) echo "CHECKED";?> ONCLICK="DisplayElement ( 'condition', 'none');DisplayElement ( 'field', 'none');DisplayElement ( 'function', 'block');DisplayElement ( 'sqlarr', 'none');"> <B>FUNCTION</B> 
					  <input type="radio" name="celltype" value="5" <? if (intval($crs['celltype'])==5) echo "CHECKED";?> ONCLICK="DisplayElement ( 'condition', 'block');DisplayElement ( 'field', 'none');DisplayElement ( 'function', 'none');DisplayElement ( 'sqlarr', 'inline');DisplayElement ( 'sqlquery', 'none');"> <B>SQL-SET</B> 
                    </td>
                </tr>

				<tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130"> 
                    &nbsp;&nbsp;<B>Caption</B></td>
                  <td align="left" width="500">  
                    	<input type="text" name="caption" id="caption" size="60" value="<?=$crs['caption']?>" onChange="clearAggregate(this)">
                        <?php
							$cell_type = explode(".",$cell);	
						?>
                        <span <?= $cell_type[0] == 2?  "style='display:inline-block;'" :  "style='display:none;'" ?>>
                        Aggregate(fn):
                        <SELECT NAME="aggregate" id="aggregate" onChange="setCaption(this);" >
                          <OPTION VALUE="" <?php if ($crs['caption'] == '') echo "SELECTED";?>>None
                          <OPTION VALUE="#count#" <?php if ($crs['caption'] == "#count#") echo "SELECTED";?>>Count
                          <OPTION VALUE="#sum#" <?php if ($crs['caption'] == "#sum#") echo "SELECTED";?>>Sum
                          <OPTION VALUE="#avg#" <?php if ($crs['caption'] == "#avg#") echo "SELECTED";?>>Average
					  </SELECT>
 						</span>
                       <script>
					  	function setCaption($this){
							document.getElementById("caption").value="";
							document.getElementById("caption").value = $this.value;
						}
						
						function clearAggregate($this){
							document.getElementById("aggregate").selectedIndex=0;
						}
					  </script>
                    </td>
                </tr>

				<tr valign="middle" bgcolor="#CCE8FD" id="condition" <? if (intval($crs['celltype'])!=1 && intval($crs['celltype'])!=5) echo "style='display:none;'";?>> 
                  <td align="left" width="130"> 
                    &nbsp;&nbsp;<B>Condition</B></td>
                  <td align="left" width="500">  
                    <?php /*?><input name="cond" type="text" value="<?=$crs[cond]?>"size="60"><?php */?>
                    <textarea name="cond" rows="5" cols="80" id="cond"><?=$crs['cond']?></textarea> <br/>  
                    <INPUT TYPE="BUTTON" VALUE=" SQL Query " CLASS="xbutton" ONCLICK="SelectCondition(document.cellform.cond);" id="sqlquery" <? if (intval($crs['celltype'])!=1) echo "style='display:none;'";?>>
                    <INPUT TYPE="BUTTON" VALUE=" SQL-Set "  ONCLICK="SqlSetDialog();" id="sqlarr" <? if (intval($crs['celltype'])!=5) echo "style='display:none;'";?>>
                    </td>
                </tr>

				<tr valign="middle" bgcolor="#CCE8FD" id="field" <?php if (intval($crs['celltype'])!=2) echo "style='display:none;'";?>> 
                  <td align="left" width="130"> 
                    &nbsp;&nbsp;<B>Field Name</B></td>
                  <td align="left" width="500">  
                    <input name="fldname" type="text" value="<?=$crs['cond']?>"size="60">  
					<INPUT TYPE="BUTTON" VALUE=" Select Field " CLASS="xbutton" ONCLICK="SelectField(document.cellform.fldname);">
                    </td>
                </tr>

				<tr valign="middle" bgcolor="#CCE8FD" id="function" <?php if (intval($crs['celltype'])!=3) echo "style='display:none;'";?>> 
                  <td align="left" width="130"> 
                    &nbsp;&nbsp;<B>Function URL</B></td>
                  <td align="left" width="500">  
                    <input type="text" name="furl" size="70" value="<?=$crs['cond']?>">  
                    </td>
                </tr>

				<tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130">&nbsp;&nbsp;<B>Format</B></td>
                  <td align="left" width="500">
					  <?php // @modify Phada Woodtikarn 26/06/2014 เปลี่ยนคำ?>  
					  <select id="nformat" name="nformat">
                          <option value="0" <?php echo $crs['nformat']==0?'selected':'';?>>Number Natural Value</option>
                          <option value="1" <?php echo $crs['nformat']==1?'selected':'';?>>Number Normal Value</option>
                          <option value="2" <?php echo $crs['nformat']==2?'selected':'';?>>Number Invert Value</option>
                          <?php // @modify Phada Woodtikarn 25/06/2014 เพิ่ม format แบบ ไทย ?>
                          <option value="3" <?php echo $crs['nformat']==3?'selected':'';?>>Date eng2thai(Short)</option>
                          <option value="4" <?php echo $crs['nformat']==4?'selected':'';?>>Date eng2thai(Full)</option>
                          <?php // @end ?>
                          <?php // @modify Phada Woodtikarn 28/06/2014 เพิ่ม format อายุปีเดือน ?>
                          <option value="5" <?php echo $crs['nformat']==5?'selected':'';?>>Age Year Month</option>
                          <?php // @end ?>
                          <?php // @modify Phada Woodtikarn 30/09/2014 เพิ่ม format ซ่อนข้อมูล ?>
                          <option value="6" <?php echo $crs['nformat']==6?'selected':'';?>>Hide Value</option>
                          <?php // @end ?>
					  </select>
                      <?php // @end ?>
                    </td>
                </tr>
                <?php // @modify Phada Woodtikarn 13/08/2014 เพิ่ม blank value ?>
                <tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130">&nbsp;&nbsp;<B>Blank Value</B></td>
                  <td align="left" width="500">
					  <select name="nblank">
						  <option value="0" <?php echo $crs['nblank']==0?'selected':'';?>>(Default)</option>
                          <option value="1" <?php echo $crs['nblank']==1?'selected':'';?>>N/A</option>
                          <option value="2" <?php echo $crs['nblank']==2?'selected':'';?>>-</option>
                          <option value="3" <?php echo $crs['nblank']==3?'selected':'';?>>0</option>
                          <option value="4" <?php echo $crs['nblank']==4?'selected':'';?>>NULL</option>
                          <option value="5" <?php echo $crs['nblank']==5?'selected':'';?>>None</option>
					  </select>
                    </td>
                </tr>
                <?php // @end ?>
				<tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130">&nbsp;&nbsp;<B>Decimal Point</B></td>
                  <td align="left" width="500">  
					  <SELECT NAME="decpoint">
					  <OPTION VALUE="0" <?php if ($crs['decpoint'] == 0) echo "SELECTED";?>>Natural</OPTION>
					  <OPTION VALUE="1" <?php if ($crs['decpoint'] == 1) echo "SELECTED";?>>2 decimal point (.00)</OPTION>
					  <OPTION VALUE="2" <?php if ($crs['decpoint'] == 2) echo "SELECTED";?>>3 decimal point (.000)</OPTION>
					  <OPTION VALUE="3" <?php if ($crs['decpoint'] == 3) echo "SELECTED";?>>No decimal point</OPTION>
					  </SELECT>
                    </td>
                </tr>

                <tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130">&nbsp;&nbsp;<B>Fonts</B></td>
                  <td align="left" width="500">  
                    <input type="text" name="font" size="60" value="<?=$crs['font']?>">  
					<INPUT TYPE="BUTTON" VALUE=" Select Font" CLASS="xbutton" onClick="SelectFont(document.cellform.font, document.cellform.caption.value);">
                    </td>
                </tr>

				<tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130">&nbsp;&nbsp;<B>Alignment</B></td>
                  <td align="left" width="500">  
					  <SELECT NAME="alignment" style="width:100;">
					  <OPTION VALUE="LEFT" <?php if ($crs['alignment'] == "TOP") echo "SELECTED";?>>Left</OPTION>
					  <OPTION VALUE="RIGHT" <?php if ($crs['alignment'] == "RIGHT") echo "SELECTED";?>>Right</OPTION>
					  <OPTION VALUE="CENTER" <?php if ($crs['alignment'] == "CENTER") echo "SELECTED";?>>Center</OPTION>
					  </SELECT>
                    </td>
                </tr>

                <tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130">&nbsp;&nbsp;<B>Vertical Alignment</B></td>
                  <td align="left" width="500">  
					  <SELECT NAME="valign" style="width:100;">
					  <OPTION VALUE="TOP" <?php if ($crs['valign'] == "TOP") echo "SELECTED";?>>Top</OPTION>
					  <OPTION VALUE="MIDDLE" <?php if ($crs['valign'] == "MIDDLE") echo "SELECTED";?>>Middle</OPTION>
					  <OPTION VALUE="BASELINE" <?php if ($crs['valign'] == "BASELINE") echo "SELECTED";?>>Baseline</OPTION>
					  </SELECT>
                    </td>
                </tr>
                <?php
                // @modify Phada Woodtikarn 18/08/2014 เพิ่มประเภท Background 
				$bgcolor = getStyleBG($crs['bgcolor']);
				
				/*echo $crs['bgcolor'];
				echo '<pre>';
				print_r($bgcolor);
				echo '</pre>';*/
				?>
                <tr valign="middle" bgcolor="#CCE8FD"> 
					<td align="left" width="130">&nbsp;&nbsp;<B>Background Type</B></td>
					<td align="left" width="500">
						<select id="bgcolor_type" name="bgtype" style="width:100;">
							<option value="0" <?php echo $bgcolor['type'] == 0?'selected':'' ?>>(Default)</option>
							<option value="1" <?php echo $bgcolor['type'] == 1?'selected':'' ?>>Follow Value</option>
                            <option value="2" <?php echo $bgcolor['type'] == 2?'selected':'' ?>>Fade Color</option>
                        </select>
                    </td>
                </tr>
                <?php // @end ?>
                <tr valign="middle" bgcolor="#CCE8FD"> 
                    <td align="left" width="130">&nbsp;&nbsp;<B>Background</B></td>
                    <td align="left" width="500">
                        <?php // @modify Phada Woodtikarn 18/08/2014 ประเภท Background ตามช่วงข้อมูล ?>
						<table id="bgcolor_main" style="display:<?php echo $bgcolor['type']==0?'initial':'none'; ?>;">
							<tr>
                            	<td><input type="text" name="bgcolor" size="10" class="kolorPicker" value="<?php echo $bgcolor['type']==1?$bgcolor['bg'][0]:$bgcolor['bg']; ?>"></td>
                            </tr>
                        </table>
						<table id="bgcolor_info" style="display:<?php echo $bgcolor['type']==0?'none':'initial'; ?>;">
							<tr style="height:35px;">
								<td style="width:25px;"></td>
								<td>
                                    <input type="text" name="bgcolor2[]" size="10" class="kolorPicker" value="<?php echo isset($bgcolor['bg'][0])?$bgcolor['bg'][0]:''; ?>">&nbsp;
                                    <input class="bgvalue" type="text" name="startvalue[]" size="5" value="<?php echo isset($bgcolor['start'][0])?$bgcolor['start'][0]:''; ?>"> to
                                    <input class="bgvalue" type="text" name="endvalue[]" size="5" value="<?php echo isset($bgcolor['end'][0])?$bgcolor['end'][0]:''; ?>">
								</td>
                                <td></td>
                            </tr>
                            <?php
                            if($bgcolor['type'] != 0){
								foreach($bgcolor['bg'] as $key => $value){
									if($key > 0){
							?>
                            <tr style="height:35px;">
								<td style="width:25px;"></td>
								<td>
									<input type="text" name="bgcolor2[]" size="10" class="kolorPicker" value="<?php echo $bgcolor['bg'][$key]; ?>">&nbsp;
									<input class="bgvalue" type="text" name="startvalue[]" size="5" value="<?php echo $bgcolor['start'][$key]; ?>"> to
									<input class="bgvalue" type="text" name="endvalue[]" size="5" value="<?php echo $bgcolor['end'][$key]; ?>">
								</td>
                                <td>
									<a href="javascript:void(0);" class="DelRow"><img src="img/trash_btn.png" /></a>
                                </td>
                            </tr>
                            <?php 
									}
								}
							}
							 ?>
							<tr style="height:0px">
								<td style="width:25px;">
									<img src="img/addnumber_btn.png" onClick="AddTableRow()" style="width:20px;float: left;margin-top: -33px;"/>
								</td>
								<td colspan="2"></td>
                            </tr>
                        </table>
                        <?php // @end ?>
                        <!--<INPUT TYPE="BUTTON" VALUE=" Select Color" CLASS="xbutton" ONCLICK="PickColor(document.cellform.bgcolor);">-->
                    </td>
                </tr>
                <tr valign="middle" bgcolor="#CCE8FD"> 
                    <td align="left" width="130">&nbsp;&nbsp;<B>Url</B></td>
                    <td align="left" width="500">  
                        <input type="text" name="url" size="70" value="<?=$crs['url']?>">
                        <?php // @modify Phada Woodtikarn 30/06/2014 เพิ่ม Target?>  
                        <select name="urltype">
                            <option value="0" <?php echo $crs['urltype']==0?'selected':'';?>>_self</option>
                            <option value="1" <?php echo $crs['urltype']==1?'selected':'';?>>_blank</option>
                            <option value="2" <?php echo $crs['urltype']==2?'selected':'';?>>_parent</option>
                            <option value="3" <?php echo $crs['urltype']==3?'selected':'';?>>_top</option>
                            <option value="4" <?php echo $crs['urltype']==4?'selected':'';?>>popup</option>
                        </select>
                        <?php // @end ?>
					</td>
				</tr>
              </table>


<BR>
</td></tr>
</table>

</FORM>
<BR>
<?
}
?>
</td></tr>
</table> <!-- End WHITE SPACE -->

<BR>
</td></tr>
</table> <!-- End BLUE SPACE -->

<!-- Thin Line -->
<table border=0 width="100%" cellspacing=0 cellpadding=0>
<tr HEIGHT=1 BGCOLOR="#000000"><td></td></tr>
</table>
<!-- End Thin Line -->


<script language="JavaScript"> 
<!-- 
$(document).ready(function() {
	$('#boxdefault').css('display', 'none');
	$('.bgvalue').numeric();
	$('#bgcolor_type').change(function(){
		if($(this).val() == 0){
			$('#bgcolor_info').css('display', 'none');
			$('#bgcolor_main').css('display', 'initial');
		}else{
			$('#bgcolor_info').css('display', 'initial');
			$('#bgcolor_main').css('display', 'none');
		}
	});
});
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

var obj1 = null;
function PickColor(obj){
	obj1 = obj;
	window.open('color/color.htm','color_window','width=450, height=550, noresize,location=no,menubar=no,toolbars=no');
}

function SelectFont(obj,sampletext){
	obj1 = obj;
	window.open('font/font.php?sample='+sampletext+'&style='+obj.value.replace("#","%23"),'font_window','width=550, height=250, location=no,menubar=no,toolbars=no');
}
//-->
function AddTableRow(){
	var NextRow = $('#bgcolor_info tr').length;
	$('#bgcolor_info tr').eq($('#bgcolor_info tr').length - 2).after('<tr style="height:35px;"><td style="width:25px;"></td><td><input type="text" name="bgcolor2[]" size="10" class="kolorPicker" value="">&nbsp; <input class="bgvalue" type="text" name="startvalue[]" size="5" value=""> to <input class="bgvalue" type="text" name="endvalue[]" size="5" value=""></td><td><a href="javascript:void(0);" class="DelRow"><img src="img/trash_btn.png" /></a></td></tr>');
}
$("#bgcolor_info").on('click','.DelRow',function(){
	$(this).parent().parent().remove();
}); 
</script>

</body>
</html>
