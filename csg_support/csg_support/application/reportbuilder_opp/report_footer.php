<?php
/**
 * @comment ตั้งค่า report footer
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    25/06/2014
 * @access     public
 */
/*****************************************************************************
Function		: จัดการข้อมูลส่วนของ Footer
Version			: 1.0
Last Modified	: 
Changes		:
	28/12/2548 - เพิ่มการตั้งความกว้างของ Column 

*****************************************************************************/

include "db.inc.php";

// field's name & value for Table Header section
$sec = "F";
$tab ="table4";
$tsize = "tsize4";

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
	if ($action == "updatetable"){
		$id = intval($_POST['id']);
		$bsize4 = intval($_POST['bsize4']);
		$bcolor4 = addslashes($_POST['bcolor4']);
		$finclude = addslashes($_POST['finclude']);
		
		mysql_query("UPDATE reportinfo SET bsize4=$bsize4,bcolor4='$bcolor4',finclude='$finclude' WHERE rid='$id' AND uname='$uname';");
		
		if (isset($_POST['edittable']) && $_POST['edittable'] == "1"){		
			$r = intval($_POST['r']);
			$c = intval($_POST['c']);
			$newtsize = $r . "x" . $c;
			$table = "";
			for ($i=0;$i<$r;$i++){ 
				if ($i>0) $table .= "|";   // คั่น row
				for ($j=0;$j<$c;$j++){ 
					if ($j > 0) $table .= "*";  // คั่น column
					$table .= "1x1";
				}
			}
			mysql_query("UPDATE reportinfo SET $tsize='$newtsize',$tab='$table' WHERE rid='$id' AND uname='$uname';");
			if (mysql_errno()){
				$msg = "Cannot update table size.";
			}
		}
		
		if (mysql_errno()){
			$msg = "Cannot update table size.";
		}else{
			header("Location: ?id=$id");
			exit;
		}
	}else if ($action=="updatecell"){
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
		$nformat = intval($_POST['nformat']);
		$decpoint = intval($_POST['decpoint']);
		$celltype = intval($_POST['celltype']);
		$nblank = intval($_POST['nblank']);
		if ($celltype == 0) $cond = "";   // no condition for TextCell
		if ($celltype == 3) $cond = $furl;   // keep furl in cond
		// @modify Phada Woodtikarn 30/06/2014 เพิ่ม url type
		$urltype = intval($_POST['urltype']);
		// @end
		

		// set column width
		SetColumnWidth($id,$sec,$cell,$_POST['cwidth']);

		// Delete old value
		mysql_query("delete from cellinfo where rid='$id' and uname='$uname' and sec='$sec' and cellno='$cell';");

		// Insert new value
		// @modify Phada Woodtikarn 30/06/2014 เพิ่ม url type
		$sql = "insert into cellinfo(uname,rid,sec,cellno,caption,font,alignment,valign,bgcolor,url,cond,celltype,nformat,decpoint,urltype,nblank) values('$uname','$id','$sec','$cell','$caption','$font','$alignment','$valign','$bgcolor','$url','$cond',$celltype,$nformat,$decpoint,$urltype,$nblank);";
		// @end
		mysql_query($sql);

		if (mysql_errno()){
			$msg = "Cannot save cell's properties..";
		}else{
			header("Location: ?id=$id");
			exit;
		}

	}else if ($action == "mergecell"){
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

		$sql = "SELECT tsize4,table4 FROM `reportinfo` WHERE rid='$id' AND uname='$uname';";
		$result = mysql_query($sql);
		if ($result){
			$rs=mysql_fetch_array($result,MYSQL_ASSOC);
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

			//หาเซลเริ่มต้นการ merge
			$found = 0;
			for ($i=1;$i<=$r;$i++){
				for ($j=1;$j<=$c;$j++){
					if (isset($_POST["C". $i . "_" . $j]) && $_POST["C". $i . "_" . $j] == "1"){
						if (!$found){
							$found = 1;
							$rstart = $i;
							$cstart = $j;
						}
					}
				}
			}

			if ($found){  // มีการ merge
				//หาเซลสิ้นสุดการ merge
				for ($i=$rstart;$i<=$r;$i++){
					for ($j=$cstart;$j<=$c;$j++){
						if (isset($_POST["C". $i . "_" . $j]) && $_POST["C". $i . "_" . $j] == "1"){
							$rfinish = $i;
							$cfinish = $j;
						}
					}
				}
			
				if ($rstart == $rfinish && $cstart == $cfinish){ // เลือกเซลเดียว
					header("Location: ?id=$id");   // Do nothing
					exit;
				}

				//ลด index ให้ match กับ array
				$rstart --; $rfinish--;
				$cstart --; $cfinish--;

				if ($rstart == $rfinish){ // Merge หลายเซลในแถวเดียวกัน
					$x = explode("x",$tspan[$rstart][$cstart]);
					$r1 = intval($x[0]);
					$c1 = ($cfinish - $cstart) + 1;
					$tspan[$rstart][$cstart] = $r1 . "x" . $c1;

					//update  other cell that merged
					for ($i=$cstart+1;$i<=$cfinish;$i++){ 
						$tspan[$rstart][$i] = $r1 . "x0";
					}

				}else if ($cstart == $cfinish){  // Merge Row ใน column เดียวกัน
					$x = explode("x",$tspan[$rstart][$cstart]);
					$c1 = intval($x[1]);
					$r1 = ($rfinish - $rstart) + 1;
					$tspan[$rstart][$cstart] = $r1 . "x" . $c1;

					//update  other cell that merged
					for ($i=$rstart+1;$i<=$rfinish;$i++){ 
						$tspan[$i][$cstart] = "0x" . $c1;
					}

				}else{  // Merge ผิดแบบ
					header("Location: ?id=$id&msg2=Cannot merge selected cells.");   // Do nothing
					exit;
				}

				// Update field "table2"
				$table = "";
				for ($i=0;$i<$r;$i++){ 
					if ($i>0) $table .= "|";   // คั่น row
					for ($j=0;$j<$c;$j++){ 
						if ($j > 0) $table .= "*";  // คั่น column
						$table .= $tspan[$i][$j];
					}
				}

				mysql_query("UPDATE reportinfo SET $tab='$table' WHERE rid='$id' AND uname='$uname';");
				if (mysql_errno()){
					$msg = "Cannot update table size.";
				}else{
					header("Location: ?id=$id");
					exit;
				}


			} // if มีการ merge

			
		}else{
			header("Location: ?id=$id&msg2=Cannot merge selected cells.");
			exit;
		}		
		
	}

}else	if ($id > 0){
	$sql = "SELECT tsize4,table4,bsize4,bcolor4,finclude FROM `reportinfo` WHERE rid='$id' AND uname='$uname';";
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
		}else{
			$msg = "Cannot find Report.";
		}
	} else {
		$msg = "Cannot find Report.";
	}

} else if ($msg == ""){
	$msg = "Cannot find Report.";
}
?>

<html>
<head>
<title>Report Management : Footnote</title>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<link href="report.css" type="text/css" rel="stylesheet">
<script language="javascript" src="dbselect.js"></script>
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/jquery-numeric.js"></script>
<link rel="stylesheet" href="js/jquery-ui-themes-1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="js/jstable/dragtable.css" />
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="js/jstable/jquery.dragtable.js"></script>
<script src="js/kolorpicker/jquery.kolorpicker.js" type="text/javascript"></script>
<link rel="stylesheet" href="js/kolorpicker/style/kolorpicker.css" type="text/css" />
<script>
	function unmergeall(){
		$('#edittable').attr('checked',true);
		$('#r').removeAttr('disabled');
		$('#c').removeAttr('disabled');
		$('#form_foot').submit();
	}
	function chkAll(n){
		if(n==1){	
			$('input.checkfield').attr('checked', true);
		}else {
			$('input.checkfield').removeAttr('checked');			
		}	
	}
</script>
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
<td><img src="<?php echo $imgpath ?>tabx4.gif" border=0></td>
<td><a href="report_param.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab5.gif" border=0></a></td>
<td width="50%"><img src="<?php echo $imgpath ?>/black.gif" width="100%" height="1"></td>
</tr>
</table> 

<table border=0 width="100%" cellspacing=0 CELLPADDING=0>
<tr BGCOLOR="#6F96C6"><td><FONT SIZE="-2" COLOR="WHITE">&nbsp;Footnote section.</FONT></td></tr>
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
<FORM id="form_foot" ACTION="?action=updatetable" METHOD="POST">
<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
<table width="90%" border=0 align=center><tr><td><B>Table Size</B> </td>
<td>
<INPUT TYPE="text" id="r" NAME="r" VALUE="<?=$r?>" size="2" maxlength="2" disabled> Rows <FONT COLOR="RED"><B>X</B></FONT> 
<INPUT TYPE="text" id="c" NAME="c" VALUE="<?=$c?>" size="2" maxlength="2" disabled> Columns
&nbsp; <INPUT TYPE="checkbox" id="edittable" NAME="edittable" value="1" ONCLICK="document.forms[0].r.disabled = document.forms[0].c.disabled = !this.checked;"> Edit Table Size
</td></tr>

<tr valign=top><td><B>Border Size</B></td><td>
	<input type="text" id="bsize4" name="bsize4" size="2" maxlength=2 value="<?=$rs['bsize4']?>"> 
</td></tr>

<tr valign=top><td><B>Border Color</B></td><td>
	<input type="text" name="bcolor4" size="10"  class="kolorPicker"  value="<?=$rs['bcolor4']?>"> 
	<!--<INPUT TYPE="BUTTON" VALUE=" Select Color" CLASS="xbutton" ONCLICK="PickColor(document.forms[0].bcolor4);">-->
</td></tr>

<tr valign=top><td><B>Footer include File</B></td><td>
	<input type="text" name="finclude" size="60" value="<?=$rs['finclude']?>"> 
</td></tr>

<tr><td>&nbsp;</td><td>
<INPUT TYPE="SUBMIT" VALUE="   Update Table Size  ">
<INPUT TYPE="reset" VALUE="   Undo   ">
<INPUT TYPE="reset" VALUE="   Reset   ">
</td></tr>

<?php
if (isset($_GET['msg2'])){
	echo "<tr><td><B>$_GET[msg2]</B></td></tr>";
}
?>
</table>
</FORM>


<!-- Thin Line -->
<table border=0 width="100%" cellspacing=0 cellpadding=0>
<tr HEIGHT=1 BGCOLOR="#000000"><td></td></tr>
</table>
<!-- End Thin Line -->

<!-- Display Table & Merge Cell -->
<table border=0 width="100%" cellspacing=0 cellpadding=0 bgcolor="WHITE">
<tr><td>
<BR>

<form action="?action=mergecell" method=POST NAME="mergeform">
<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
<table id="tablefooter" border="0" bgcolor="black" width="90%" align="center" cellspacing="1" cellpadding="0" style="display:none;">
<?
$px = intval(100 / $c); // ความกว้างแต่ละเซล
for ($i=1;$i<=$r;$i++){
	echo "<tr bgcolor='#F0F0F0' valign=top>";
	for ($j=1;$j<=$c;$j++){
		$x = explode("x",$tspan[$i-1][$j-1]);
		$rspan = intval($x[0]);
		$cspan = intval($x[1]);
		if ($rspan > 0 && $cspan > 0){


			// 28/12/2548
			//หาว่ามีการ set ค่าความกว้างหรือไม่
			if (canSetWidth()){
				$xpx = GetColumnWidth($id,$sec,"1.$j");
				if ($xpx > ""){
					$cwidth = " width='$xpx' ";
				}else{
					$cwidth = "";  //ไม่ระบุ
				}
			}else{ // ไม่มีการกำหนดค่าความกว้าง
				$cwidth = " width='$px%' "; 
			}
			// 28/12/2548


?>
<td <?=GetCellProperty($id,$sec,$i . "." . $j)?> <?=$cwidth?> colspan='<?=$cspan?>' rowspan='<?=$rspan?>'>
	<table border=0 cellspacing=0 cellpadding=0 width='40' height="20" align="left"> 
		<tr valign=top>
			<td align=center width=25 bgcolor='#FF6633'><A HREF="?action=cell&id=<?=$id?>&cell=<?=$i?>.<?=$j?>" title="Edit Cell Properties"><FONT COLOR="BLACK"><B><U><?=$i?>.<?=$j?></U></B></FONT></A></td>
			<td width=15 align=left><input type="checkbox" class="checkfield" name="C<?=$i?>_<?=$j?>" value="1"></td>
		</tr>
	</table>

	<?=GetCellValue($id,$sec,$i . "." . $j)?>

</td>
<?
		}
	}
	echo "</tr>";
}
?>
</table>

<table border=0 width="90%" align=center cellspacing=1 cellpadding=0>
<tr>
<td align=right>
<?php // @modify Phada Woodtikarn 22/07/2014 เพิ่ม Check all และ Unccheck all ?>
<input type="button" value=" Check all " style="font-weight: bold;" onClick="chkAll(1)">
<input type="button" value=" Uncheck all " style="font-weight: bold;" onClick="chkAll(0)">
<?php // @end ?>
<input type="submit" value=" Merge Selected Cell " style="font-weight: bold;" name="Merge">
<?php // @modify Phada Woodtikarn 16/08/2014 เพิ่มปุ่ม unmerge ?>
<input type="button" value=" Unmerge All " style="font-weight: bold;" name="Unmerge" onClick="unmergeall()">
<?php // @end ?>
<input type="submit" value=" Clear Selected Cell " style="font-weight: bold;" name="delete" onClick="if (!confirm('ต้องการลบข้อมูลนี้จริงหรือไม่?')) return false;">
<input type="button" value=" Selected Cell's Property " style="font-weight: bold;" name="delete" onClick="DisplayElement ( 'cellprop', 'table');">
</td></tr>
</table>

<BR>
<?php
include "selectedcellprop.inc.php";
?>
</form>
<!-- End Display Table & Merge Cell -->

<?php
if($rs['finclude']){
?>
<table border=0 width="90%" align=center cellspacing=1 cellpadding=2 bgcolor="BLACK">
<tr bgcolor="#DDDDDD"><td>Include from "<B><?php echo $rs['finclude']?></B>"</td></tr>
<tr bgcolor="WHITE"><td>
<?php
	if(is_file($rs['finclude'])){
		include($rs['finclude']);
	}
?>
</td></tr>
</table>
<BR>
<?php
}
?>



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

?>
<FORM name="cellform" method="post" action="?action=updatecell&id=<?=$id?>">
<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
<INPUT TYPE="hidden" NAME="cell" VALUE="<?=$cell?>">
<table border=0 width="80%" align=center cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white><td align=LEFT>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr valign="middle" height="30"> 
          <td align="center" width="35" bgcolor="#FF6633"><b style="font-size: 12pt;"><?=$_GET['cell']?></b></td>
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
		              <input type="radio" name="celltype" value="0" <?php if (intval($crs['celltype'])==0) echo "CHECKED";?> ONCLICK="DisplayElement ( 'condition', 'none');DisplayElement ( 'function', 'none');"> <B>TEXT</B> 
				      <input type="radio" name="celltype" value="1" <?php if (intval($crs['celltype'])==1) echo "CHECKED";?> ONCLICK="DisplayElement ( 'condition', 'block');DisplayElement ( 'function', 'none');"> <B>DATABASE</B> 
				      <input type="radio" name="celltype" value="3" <?php if (intval($crs['celltype'])==3) echo "CHECKED";?> ONCLICK="DisplayElement ( 'condition', 'none');DisplayElement ( 'function', 'block');"> <B>FUNCTION</B> 
					</td>
                </tr>

				<tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130"> 
                    &nbsp;&nbsp;<B>Caption</B></td>
                  <td align="left" width="500">  
                    <input type="text" name="caption" size="60" value="<?=$crs['caption']?>">
                    </td>
                </tr>

				<tr valign="middle" bgcolor="#CCE8FD" id="condition" <?php if (intval($crs['celltype'])!=1) echo "style='display:none;'";?>> 
                  <td align="left" width="130"> 
                    &nbsp;&nbsp;<B>Condition</B></td>
                  <td align="left" width="500">  
                    <input type="text" name="cond" size="60" value="<?=$crs['cond']?>">  
					<INPUT TYPE="BUTTON" VALUE=" SQL Query " CLASS="xbutton" ONCLICK="SelectCondition(document.cellform.cond);">
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
					  <select name="nformat">
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

<?
//ตรวจสอบฐานข้อมูลก่อน ว่าได้เปลี่ยนโครงสร้างตาราง reportinfo ให้รองรับความกว้าง (cwidth1,cwidth2,cwidth3,cwidth4) หรือยัง
if (canSetWidth()){
?>
				<tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130">&nbsp;&nbsp;<B>Column Width</B></td>
                  <td align="left" width="500">  
                  <input type="text" name="cwidth" size="10" maxlength=10 value="<?=GetColumnWidth($id,$sec,$cell)?>">  
				  (pixel or percent with %)
                  </td>
                </tr>
<?
}	
?>
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

				<tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="130">&nbsp;&nbsp;<B>Background</B></td>
                  <td align="left" width="500">  
                    <input type="text" name="bgcolor" size="10"  class="kolorPicker"  value="<?=$crs['bgcolor']?>"> 
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
<?php // @mofidy Phada Woodtikarn 21/07/2014 ?>
<script>
	$(document).ready(function(){
		$('#tablefooter').show();
		$('#r').numeric();
		$('#c').numeric();
		$('#bsize4').numeric();
	});
</script>
<?php // @end ?>

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
</script>

</body>
</html>