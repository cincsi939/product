<?php
/**
 * @comment ตั้งค่า report edit
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    26/06/2014
 * @access     public
 */
/*****************************************************************************
Function		: แก้ไข Properties ของ Report
Version			: 1.0
Last Modified	: 28/7/2548
Changes		:
	28/7/2548	- เพิ่ม Field startcolumn ในตาราง reportinfo  เพื่อหาว่าเริ่มข้อมูลที่ column ใด (default = 2)


*****************************************************************************/
include "db.inc.php";
//@modify Doe 10/04/2014 login checked
//	include "login_chk.php";
//@end
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
	if ($action == "update"){
		$id = intval($_POST['id']);
		$rtype = intval($_POST['rtype']);
		$rgroup = intval($_POST['rgroup']);
		$groupid = trim($_POST['groupid']);
		$subid = trim($_POST['subid']);
		$startcolumn = intval($_POST['startcolumn']);
		$caption = addslashes(str_replace("\"","'",$_POST['caption']));
		$comment = addslashes($_POST['comment']);
		$fldname = addslashes($_POST['fldname']);
		$cond = addslashes($_POST['cond']);
		$bgcolor = addslashes($_POST['bgcolor']);
		$refno = addslashes($_POST['refno']);
		$keyincode = addslashes($_POST['keyincode']);
		$createby = addslashes($_POST['createby']);
		$pinclude = addslashes($_POST['pinclude']);
		$redirect = intval($_POST['redirect']);
		$reurl = trim($_POST['reurl']);
		// @modify Phada Woodtikarn 19/07/2014
		$ordertype = trim($_POST['ordertype']);
		$ordercolumn = trim($_POST['ordercolumn']);
		$pagination = trim($_POST['pagination']);
		$paginationrow = trim($_POST['paginationrow']);
		// @end
		// @modify Phada Woodtikarn 30/07/2014
		$fldorder = addslashes($_POST['fldorder']);
		// @end
		// @modify Phada Woodtikarn 04/11/2014
		$hinclude = addslashes($_POST['hinclude']);
		// @end
		// @modify Phada Woodtikarn 02/10/2014 เพิ่ม hidecondition
		if(isset($_POST['hideCon'])){
			$hideCon = implode('|',$_POST['hideCon']);
			$hideCon = str_replace('"','',$hideCon);
			$hideCon = str_replace("'",'',$hideCon);
			$hideCon = str_replace('$','\$',$hideCon);
		}else{
			$hideCon = '';
		}
		// @end

		if (mysql_num_rows(mysql_query("SELECT groupid,rid,subid FROM reportinfo WHERE groupid='$groupid' AND subid='$subid' AND rid <> '$id';"))){
			$msg = "Duplicated ID for this group.";
		}else if ( $caption > ""){
			$sql = "UPDATE 
						reportinfo 
					SET caption='$caption',rtype='$rtype',comment='$comment',fldname='$fldname',fldorder='$fldorder',bgcolor='$bgcolor',
						cond='$cond',rgroup=$rgroup,startcolumn=$startcolumn,refno='$refno',keyincode='$keyincode',
						createby='$createby', pinclude='$pinclude',groupid='$groupid',subid='$subid',redirect='$redirect',
						reurl='$reurl',ordertype='$ordertype',ordercolumn='$ordercolumn',pagination='$pagination',
						paginationrow='$paginationrow',hidecondition = '".$hideCon."',hinclude = '".$hinclude."'
					WHERE rid = $id AND uname='$uname';";
			mysql_query($sql);
			if (mysql_errno()){
				$msg = "Cannot update report.";
			}else{
				header("Location: ?id=$id&msg2=Properties saved.");
				exit;
			}
		}else{
			$msg = "Report caption must not blank.";
		}

	}

}else if ($action == "" && $id > 0){
	$sql = "SELECT caption,rtype,comment,fldname,fldorder,bgcolor,cond,rgroup,
					startcolumn,refno,keyincode,createby,pinclude,groupid,
					subid,redirect,reurl,ordertype,ordercolumn,pagination,paginationrow,hidecondition,hinclude
			FROM  `reportinfo` 
			WHERE rid='$id' AND uname='$uname';";
	$result = mysql_query($sql);
	if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		if(!$rs){
			$msg = "Cannot find Report.";
		}
		// @modify Phada Woodtikarn 02/10/2014 หาว่ามี CELL ไหนใช้ format hide value
		$sql = 'SELECT 
					COUNT(nformat) as hideCon
				FROM
					cellinfo
				WHERE
					rid = "'.$id.'" AND uname = "'.$uname.'" AND nformat = 6';
		$result = mysql_query($sql);
		if($result){
			$crs=mysql_fetch_array($result,MYSQL_ASSOC);
		}
		// @end
	} else {
		$msg = "Cannot find Report.";
	}
}else if ($msg == ""){
	$msg = "Cannot find Report.";
}

?>

<html>
<head>
<title>Report Management : Edit Report</title>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<link href="report.css" type="text/css" rel="stylesheet">
<script language="javascript" src="dbselect.js"></script>
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/jquery-numeric.js"></script>
<script src="js/kolorpicker/jquery.kolorpicker.js" type="text/javascript"></script>
<link rel="stylesheet" href="js/kolorpicker/style/kolorpicker.css" type="text/css" />
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
<td><img src="<?php echo $imgpath ?>tabx0.gif" border=0></td>
<td><a href="report_exec.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab1.gif" border=0></a></td>
<td><a href="report_header.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab2.gif" border=0></a></td>
<td><a href="report_info.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab3.gif" border=0></a></td>
<td><a href="report_footer.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab4.gif" border=0></a></td>
<td><a href="report_param.php?id=<?=$id?>"><img src="<?php echo $imgpath ?>tab5.gif" border=0></a></td>
<td width="50%"><img src="<?php echo $imgpath ?>/black.gif" width="100%" height="1"></td>
</tr>
</table> 

<table border=0 width="100%" cellspacing=0 CELLPADDING=0>
<tr BGCOLOR="#6F96C6"><td><FONT SIZE="-2" COLOR="WHITE">&nbsp;Edit report's properties and information.</FONT></td></tr>
<tr HEIGHT=1 BGCOLOR="#406080"><td></td></tr>
</table>
<!-- End Tab Header -->


<table border=0 width="100%" cellspacing=0 CELLPADDING=0>
<tr BGCOLOR="#AACCEE"><td>
<?php
// ERROR MESSAGE
if ($msg != ''){
	echo "<h1 align=center>$msg</h1></body></html>";
	exit;
}
?>
<BR>
<FORM ACTION="?action=update" METHOD="POST" NAME="form1">
<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
<table border=0 width="80%" align=center cellspacing=0 CELLPADDING=0>
<tr id="report1" style="display: <?php echo ($rs['redirect'] == 0)?'block':'none';?>;">
	<td colspan=2>
		<style>
	        table.tableList tr td{ white-space:nowrap;}
        </style>
		<table border=0 cellspacing=0 cellpadding=0 width="100%" class="tableList">
			<tr>
            	<td width="200px"><B>Caption:</B></td>
                <td style="text-align: left;"><INPUT TYPE="text" NAME="caption" VALUE="<?php echo $rs['caption']?>" size="60"></td>
            </tr>
			<tr><td><B>ID:</B></td><td><INPUT TYPE="text" id="subid" NAME="subid" VALUE="<?php echo $rs['subid']?>" size="10" maxlength="10"></td></tr>
			<tr>
            	<td><B>Report Group:</B></td>
                <td>
                <SELECT NAME="groupid">
                <option value=""> - No report group - </option>
                <?php
                    $gresult = mysql_query("SELECT groupid,groupname FROM groupinfo ORDER BY groupid;");
                    while ($grs=mysql_fetch_assoc($gresult)){
                        if ($rs['groupid'] == $grs['groupid']){
                            echo "<option selected value='$grs[groupid]'>$grs[groupid] : $grs[groupname]</option>";
                        }else{
                            echo "<option value='$grs[groupid]'>$grs[groupid] : $grs[groupname]</option>";
                        }
                    }
                ?>
                </SELECT>
				</td>
			</tr>
			<tr>
            	<td><B>Report Type:</B></td>
				<td><input type="radio" name="redirect" id="normalreport" value="0" <?php echo ($rs['redirect'] == 0)?'CHECKED':''?> ONCLICK="DisplayElement('report2','none');"><LABEL for="normalreport">Normal Report</LABEL>
					<INPUT TYPE="radio" NAME="redirect" id="redirectreport" value="1" <?php if ($rs['redirect'] == 1) echo "CHECKED"?> ONCLICK="DisplayElement('report2','block');"><LABEL for="redirectreport">Redirect Report</LABEL>
				</td>
			</tr>
            <tr id="report2" style="display: <?php echo ($rs['redirect'] == 1)?'block':'none';?>;">
            	<td><B>Redirect URL</B></td>
                <td><INPUT TYPE="text" NAME="reurl" VALUE="<?=$rs['reurl']?>" size="60"></td>
            </tr>
			<?php // @modify Phada Woodtikarn 19/07/2014 ?>
            <tr>
                <td><B>Pagination:</B></td>
                <td>
                    <label>
                        <input type="radio" name="pagination" class="pagination" value="0" <?php echo $rs['pagination']==0?'checked':''?>>OFF
                    </label>
                    <label>
                        <input type="radio" name="pagination" class="pagination" value="1" <?php echo $rs['pagination']==1?'checked':''?>>ON(JS)
                    </label>
                    <?php // @modify Phada Woodtikarn 29/07/2014 เพิ่มการแบ่งหน้าแบบแบ่งquery ?>
                    <label>
                        <input type="radio" name="pagination" class="pagination" value="2" <?php echo $rs['pagination']==2?'checked':''?>>ON(SQL)
                    </label>
                    <?php // @end ?>
                    <input type="text" name="paginationrow" id="paginationrow" size="5" value="<?php echo $rs['paginationrow'] ?>"> rows/page
                    <?php // @modify Phada Woodtikarn 30/07/2014 เพิ่มการตั้งค่าสีปุ่ม pagination ?>
                    <input type="button" value="Select Style" class="xbutton" onClick="SelectStylePagination(<?php echo "'$id','$uname'" ?>);">
                    <?php // @end ?>
                </td>
            </tr>
            <?php ?>
			<tr>
                <td width="200"><B>Report Style:</B></td>
                <td width="80%">
                    <SELECT NAME="rtype">
                    <?php // @modify Phada Woodtikarn 25/06/2014 เพิ่ม rtype แบบ ไม่แสดง parameter ตรงตาราง ?>
                        <option value="0" <?php echo $rs['rtype']==0?'selected':'';?>>Normal
                        <option value="1" <?php echo $rs['rtype']==1?'selected':'';?>>Comparision
                        <option value="2" <?php echo $rs['rtype']==2?'selected':'';?>>Comparision without DIFF
                        <option value="3" <?php echo $rs['rtype']==3?'selected':'';?>>No Header Parameter
                    <?php // @end ?>
                    </SELECT>
                </td>
			</tr>
			<tr>
            	<td><B>Groupping Option:</B></td>
				<td>
                    <SELECT NAME="rgroup">
						<?php
                        if ($rs['rgroup'] == 0){ // ธรรมดา
                        ?>
                        <OPTION VALUE="0" SELECTED>No Grouping</OPTION>
                        <OPTION VALUE="1" >Group for id ending with 00</OPTION>
                        <?php
                        }else{
                        ?>
                        <OPTION VALUE="0">No Grouping</OPTION>
                        <OPTION VALUE="1" SELECTED>Group for id ending with 00</OPTION>
                        <?php
                        }
                        ?>
                    </SELECT>
                </td>
          	</tr>
			<tr height='10'><td colspan=2></td></tr>
			<tr><td><B>Data begin at column:</B></td><td><INPUT TYPE="text" id="startcolumn" NAME="startcolumn" VALUE="<?=$rs['startcolumn']?>" size="5"> </td></tr>
			<?php //@modify Phada Woodtikarn 19/07/2014 เพิ่มการ Order ครั้งแรก ?>
            <tr>
                <td><B>Order column:</B></td>
                <td>
                    <input type="text" id="ordercolumn" name="ordercolumn" value="<?php echo $rs['ordercolumn'] ?>" size="5">
                    <label><input type="radio" name="ordertype" class="ordertype" value="0" <?php echo $rs['ordertype']==0?'checked':''?>>ASC</label>
                    <label><input type="radio" name="ordertype" class="ordertype" value="1" <?php echo $rs['ordertype']==1?'checked':''?>>DESC</label>
                </td>
            </tr>
            <?php //@end ?>
			<tr>
            	<td><B>Key Field:</B></td>
                <td>
                	<INPUT TYPE="text" NAME="fldname" VALUE="<?=$rs['fldname']?>" size="60">
                	<INPUT TYPE="BUTTON" VALUE=" Select Field " CLASS="xbutton" ONCLICK="SelectField(document.form1.fldname);">
                </td>
            </tr>
			<tr>
            	<td><B>Report Condition:</B><BR><FONT STYLE="font-size:8pt;" COLOR="#404040">(no SELECT and WHERE)</FONT></td>
                <td>
                    <input type="text" name="cond" size="60" value="<?=$rs['cond']?>">  
                    <INPUT TYPE="BUTTON" VALUE=" Create Condition " CLASS="xbutton" ONCLICK="SelectCondition(document.form1.cond);">
                </td>
			</tr>
            <?php // @modify Phada Woodtikarn 30/09/2014 เพิ่ม Order ?>
            <tr>
            	<td><B>Order Field:</B></td>
                <td>
                    <input type="text" name="fldorder" size="60" value="<?php echo isset($rs['fldorder'])?$rs['fldorder']:''; ?>">  
                    <INPUT TYPE="BUTTON" VALUE=" Select Field " CLASS="xbutton" ONCLICK="SelectField(document.form1.fldorder);">
                </td>
			</tr>
            <?php // @end ?>
			<tr height='10'><td colspan=2></td></tr>
			<tr>
            	<td><B>Background Color:</B></td>
                <td>
                	<input type="text" name="bgcolor" size="10" class="kolorPicker" value="<?=$rs['bgcolor']?>"> 
					<!--<INPUT TYPE="BUTTON" VALUE=" Select Color" CLASS="xbutton" ONCLICK="PickColor(document.form1.bgcolor);">-->
                </td>
            </tr>
            <?php // @modify Phada Wooditkarn 30/07/2014 เพิ่ม font ?>
            <tr>
                <td><b>Report Font Style:</b></td>
                <td>
                    <?php // @modify Phada Woodtikarn 31/07/2014 เพิ่มการตั้งค่าหน้ารายงาน ?>
                    <input type="button" value="Select Style" class="xbutton" onClick="SelectStylePreview(<?php echo "'$id','$uname'" ?>);">
                    <?php // @end ?>
                </td>
            </tr>
            <?php // @end ?>
            <?php
            // @modify Phada Woodtikarn 02/10/2014 เพื่ม Hide value Condition
			if($crs['hideCon'] > 0){
				$hideCon = explode('|',$rs['hidecondition']);
				$countCon = count($hideCon);
				if($countCon < 2){
					$hideCon[0] = '';
					$hideCon[1] = '';
					$hideCon[2] = '';
				}
			?>
            <tr>
                <td><b>Hide Value Condition:</b></td>
                <td>
                	<table>
                            <tr>
                            	<td></td>
                            	<td style="text-align:center;">variable</td>
                            	<td style="text-align:center;">condition</td>
                               <td style="text-align:center;">value</td>
                            	<td></td>
                            </tr>
                            <tr>
                            	<td>IF</td>
                            	<td><input type="text" name="hideCon[1]" value="<?php echo $hideCon[0]; ?>"></td>
                            	<td><input type="text" name="hideCon[2]" value="<?php echo $hideCon[1]; ?>" style="width:80px;"></td>
                            	<td><input type="text" name="hideCon[3]" value="<?php echo $hideCon[2]; ?>"></td>
                            	<td>Result = Not Hide</td>
                            </tr>
                     </table>
                </td>
            </tr>
            <?php
			}
            // @end
			?>
			<tr><td><B>RefNo:</B></td><td><INPUT TYPE="text" NAME="refno" VALUE="<?=$rs['refno']?>" size="60" maxlength="100"></td></tr>
			<tr><td><B>Key-in Code:</B></td><td><INPUT TYPE="text" NAME="keyincode" VALUE="<?=$rs['keyincode']?>" size="60" maxlength="100"></td></tr>
			<tr><td><B>Create By:</B></td><td><INPUT TYPE="text" NAME="createby" VALUE="<?=$rs['createby']?>" size="60" maxlength="100"></td></tr>
			<tr><td><B>Pre-execute include File:</B></td><td><input type="text" name="pinclude" size="60" value="<?=$rs['pinclude']?>"> </td></tr>
            <?php // @modify Phada Woodtikarn 04/11/2014 ?>
            <tr><td><B>Include Header:</B></td><td><input type="text" name="hinclude" value="<?php echo $rs['hinclude']?>" size="60" maxlength="255"></td></tr>
            <?php // ?>
			<tr><td><B>Description:</B></td><td><TEXTAREA NAME="comment" ROWS="6" COLS="60"><?=$rs['comment']?></TEXTAREA></td></tr>
			<tr>
            	<td>&nbsp;</td>
                <td ALIGN=LEFT>
                	<INPUT TYPE="SUBMIT" VALUE="   Update   ">
                    <INPUT TYPE="reset" VALUE="   Undo   ">
                    <INPUT TYPE="reset" VALUE="   Reset   ">
                </td>
           	</tr>
		</table>
	</td>
</tr>
<?php
if (isset($_GET['msg2'])){
	echo "<tr><td>&nbsp;</td><td><B>$_GET[msg2]</B></td></tr>";
}
?>
</table>
</FORM>
<BR><BR>
&nbsp;&nbsp;
<A HREF="report_preview.php?id=<?=$id?>" title="Preview" target="_blank"><img src="<?php echo $imgpath; ?>preview.gif" border=0> Preview Report</A>
&nbsp; <A HREF="report_export.php?id=<?=$id?>&sec=<?=$sec?>" title="Export" target="_blank"><img src="<?php echo $imgpath; ?>export.gif" border=0> Export Report</A>
<BR><BR>
</td></tr>
<tr HEIGHT=1 BGCOLOR="#000000"><td></td></tr>
</table>
<?php // @mofidy Phada Woodtikarn 21/07/2014 ?>
<script>
	$(document).ready(function(){
		$('#paginationrow').numeric();
		$('#subid').numeric();
		$('#ordercolumn').numeric();
		$('#startcolumn').numeric();
	});
</script>
<?php // @end ?>
<SCRIPT LANGUAGE="JavaScript">
<!--
var obj1 = null;
function PickColor(obj){
	obj1 = obj;
	window.open('color/color.htm','color_window','width=450, height=550, noresize,location=no,menubar=no,toolbars=no');
}
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
//-->
<?php // @modify Phada Woodtikarn 30/07/2014 เพิ่มการตั้งค่าสีปุ่ม pagination และ เลือก font ?>
function SelectStylePagination(id,uname){
	window.open('report_pagination_style.php?action=edit&id='+id+'&uname='+uname,'font_window','width=1120,height=450,location=no,menubar=no,toolbars=no');
}
<?php // @end ?>
<?php // @modify Phada Woodtikarn 31/07/2014 เพิ่มการตั้งค่าสี หน้ารายงาน?>
function SelectStylePreview(id,uname){
	window.open('report_preview_style.php?action=edit&id='+id+'&uname='+uname,'font_window','width=750,height=650,scrollbars=1,location=no,menubar=no,toolbars=no');
}
<?php // @end ?>
</SCRIPT>
</body>
</html>
