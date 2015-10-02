<?php
/**
 * @comment หน้าแต่ง CSS ปุ่ม Pagination
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    29/07/2014
 * @access     public
 */
include "db.inc.php";
// @modify Phada Woodtikarn 30/07/2014 เพิิ่มการ Update
if($_GET['action'] == 'edit' && isset($_GET['id']) && isset($_GET['uname'])){
	if(isset($_POST['action']) && $_POST['action'] == 'edit'){
		if($_POST['BGColorA'] == ''){
			$_POST['BGColorA'] = $_POST['BGColor2A'];
		}
		if($_POST['BGColor2A'] == ''){
			$_POST['BGColor2A'] = $_POST['BGColorA'];
		}
		if($_POST['BGColorO'] == ''){
			$_POST['BGColorO'] = $_POST['BGColor2O'];
		}
		if($_POST['BGColor2O'] == ''){
			$_POST['BGColor2O'] = $_POST['BGColorO'];
		}
		$getStyle = $_POST['FontColorA'].'|'.$_POST['BGColorA'].'|'.$_POST['BGColor2A'].'|'.$_POST['BorderColorA'].'|'.$_POST['FontColorO'].'|'.$_POST['BGColorO'].'|'.$_POST['BGColor2O'].'|'.$_POST['BorderColorO'].'|'.$_POST['FontColorFA'].'|'.$_POST['FontColorFD'];
		$sql = 'UPDATE reportinfo SET paginationstyle="'.$getStyle.'" WHERE rid = '.$_GET['id'].' AND uname="'.$_GET['uname'].'"';
		mysql_query($sql);
		if (mysql_errno()){
			$msg = "Cannot update report";
		}else{
			$msg = "Update Success";
			echo "<script>window.close();</script>";
		}
	}
	$sql = 'SELECT paginationstyle FROM reportinfo WHERE rid = '.$_GET['id'].' AND uname="'.$_GET['uname'].'"';
	$result = mysql_query($sql);
	$rs = mysql_fetch_array($result);
	$result = (getStylePagination($rs['paginationstyle']));
}
// @end
?>
<html>
<head>
<title>Style Pagination</title>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<link href="report.css" type="text/css" rel="stylesheet">
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/kolorpicker/jquery.kolorpicker.js" type="text/javascript"></script>
<link rel="stylesheet" href="js/kolorpicker/style/kolorpicker.css" type="text/css" />
<style>
	td {
		padding:5px;
	}
	.inputkolor{
		padding-left:30px;	
	}
	.paginate_button {
		box-sizing: border-box;
		display: inline-block;
		min-width: 1.5em;
		padding: 0.5em 1em;
		margin-left: 2px;
		text-align: center;
		text-decoration: none !important;
		cursor: pointer;
		*cursor: hand;
		border: 1px solid transparent;
		font-size: 13px;
	}
	.paginate_button.hover {
		color: <?php echo $result['FontColorO']; ?>;
		border: 1px solid <?php echo $result['BorderColorO']; ?>;
		background-color: <?php echo $result['BGColorO']; ?>; /* Old browsers */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, <?php echo $result['BGColorO']; ?>), color-stop(100%, <?php echo $result['BGColor2O']; ?>)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, <?php echo $result['BGColorO']; ?> 0%, <?php echo $result['BGColor2O']; ?> 100%); /* Chrome10+,Safari5.1+ */
		background: -moz-linear-gradient(top, <?php echo $result['BGColorO']; ?> 0%, <?php echo $result['BGColor2O']; ?> 100%); /* FF3.6+ */
		background: -ms-linear-gradient(top, <?php echo $result['BGColorO']; ?> 0%, <?php echo $result['BGColor2O']; ?> 100%); /* IE10+ */
		background: -o-linear-gradient(top, <?php echo $result['BGColorO']; ?> 0%, <?php echo $result['BGColor2O']; ?> 100%); /* Opera 11.10+ */
		background: linear-gradient(to bottom, <?php echo $result['BGColorO']; ?> 0%, <?php echo $result['BGColor2O']; ?> 100%); /* W3C */
	}
	.paginate_button.current {
		color: <?php echo $result['FontColorA']; ?>;
		border: 1px solid <?php echo $result['BorderColorA']; ?>;
		background-color: <?php echo $result['BGColorA']; ?>; /* Old browsers */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $result['BGColorA']; ?>), color-stop(100%, <?php echo $result['BGColor2A']; ?>)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, <?php echo $result['BGColorA']; ?> 0%, <?php echo $result['BGColor2A']; ?> 100%); /* Chrome10+,Safari5.1+ */
		background: -moz-linear-gradient(top, <?php echo $result['BGColorA']; ?> 0%, <?php echo $result['BGColor2A']; ?> 100%); /* FF3.6+ */
		background: -ms-linear-gradient(top, <?php echo $result['BGColorA']; ?> 0%, <?php echo $result['BGColor2A']; ?> 100%); /* IE10+ */
		background: -o-linear-gradient(top, <?php echo $result['BGColorA']; ?> 0%, <?php echo $result['BGColor2A']; ?> 100%); /* Opera 11.10+ */
		background: linear-gradient(to bottom, <?php echo $result['BGColorA']; ?> 0%, <?php echo $result['BGColor2A']; ?> 100%); /* W3C */
	}
	.paginate_button.active {
		cursor: default;
		color: <?php echo $result['FontColorFA']; ?>;
		border: 1px solid transparent;
		background: transparent;
		box-shadow: none;
	}
	.paginate_button.disabled {
		cursor: default;
		color: <?php echo $result['FontColorFD']; ?>;
		border: 1px solid transparent;
		background: transparent;
		box-shadow: none;
	}
</style>
<script>
	function ChangeStyle(type,id){
		var value;
		var value2;
		if(type == 'FontColor'){
			type = 'color';
			value = $('input[name=FontColor'+id+']').val();
		}else if(type == 'BGColor'){
			type = 'background';
			value = $('input[name=BGColor'+id+']').val();
			if($('input[name=BGColor2'+id+']').val() == ''){
				value2 = value;
			}else{
				value2 = $('input[name=BGColor2'+id+']').val();
			}
		}else if(type == 'BGColor2'){
			type = 'background';
			value2 = $('input[name=BGColor2'+id+']').val();
			if($('input[name=BGColor'+id+']').val() == ''){
				value = value2;
			}else{
				value = $('input[name=BGColor'+id+']').val();
			}
		}else if(type == 'BorderColor'){
			type = 'border';
			value = '1px solid ' + $('input[name=BorderColor'+id+']').val();
		}
		if(type == 'color' || type == 'border'){
			if(id == 'A'){
				$('#btnActive').css(type,value);
			}else if(id == 'O'){
				$('#btnOver').css(type,value);
			}else if(id == 'FA'){
				$('#btnFActive').css(type,value);
			}else if(id == 'FD'){
				$('#btnFDisable').css(type,value);
			}
		}else if(type == 'background'){
			if(id == 'A'){
				ExampleID = '#btnActive';
			}else if(id == 'O'){
				ExampleID = '#btnOver';
			}
			$(ExampleID).css(type,value); /* Old browsers */
			$(ExampleID).css(type,'-moz-linear-gradient(top,' + value + ' 0%,' + value2 + ' 100%)'); /* FF3.6+ */
			$(ExampleID).css(type,'-webkit-gradient(linear, left top, left bottom,color-stop(0%,' + value + '),color-stop(100%,' + value2 + '))'); /* Chrome,Safari4+ */
			$(ExampleID).css(type,'-webkit-linear-gradient(top,' + value + ' 0%,' + value2 + ' 100%)'); /* Chrome10+,Safari5.1+ */
			$(ExampleID).css(type,'-o-linear-gradient(top,' + value + ' 0%,' + value2 + ' 100%)'); /* Opera 11.10+ */
			$(ExampleID).css(type,'-ms-linear-gradient(top,' + value + ' 0%,' + value2 + ' 100%)'); /* IE10+ */
			$(ExampleID).css(type,'linear-gradient(to bottom,' + value + ' 0%,' + value2 + ' 100%)'); /* W3C */
		}
	};
</script>
</head>
<form action="?action=edit&id=<?php echo $_GET['id']; ?>&uname=<?php echo $_GET['uname']; ?>" method="post">
<input type="hidden" name="action" value="edit">
<center>
<table boder="0" cellspacing="0" cellpadding="0" style="width:730px;">
<thead>
	<?php if(isset($msg)){ ?>
	<tr>
    	<td colspan="5" align="center"><h3><?php echo $msg ?></h3></td>
    </tr>
    <?php } ?>
    <tr>
        <td style="width:170px;"></td>
        <td align="center" style="width:140px">Button(Active)</td>
        <td align="center" style="width:140px">Button(Mouse Over)</td>
        <td align="center" style="width:140px">Font(Active)</td>
        <td align="center" style="width:140px">Font(Disable)</td>
    </tr>
</thead>
<tbody>
    <tr>
        <td style="height:60px;" align="right"></td>
        <td align="center" style="border: solid 1px #000;border-right: none;"><a class="paginate_button current" id="btnActive">1</a></td>
        <td align="center" style="border: solid 1px #000;border-right: none;border-left: none;"><a class="paginate_button hover" id="btnOver">1</a></td>
        <td align="center" style="border: solid 1px #000;border-right: none;border-left: none;"><a class="paginate_button active" id="btnFActive">ย้อนกลับ</a></td>
        <td align="center" style="border: solid 1px #000;border-left: none;"><a class="paginate_button disabled" id="btnFDisable">ถัดไป</a></td>
    </tr>
    <tr>
        <td align="right">Font Color :</td>
        <td class="inputkolor">
        	<input type="text" name="FontColorA" size="10" class="kolorPicker" value="<?php echo $result['FontColorA']; ?>" onChange="ChangeStyle('FontColor','A');">
        </td>
        <td class="inputkolor">
        	<input type="text" name="FontColorO" size="10" class="kolorPicker" value="<?php echo $result['FontColorO']; ?>" onChange="ChangeStyle('FontColor','O');">
        </td>
        <td class="inputkolor">
        	<input type="text" name="FontColorFA" size="10" class="kolorPicker" value="<?php echo $result['FontColorFA']; ?>" onChange="ChangeStyle('FontColor','FA');">
        </td>
        <td class="inputkolor">
        	<input type="text" name="FontColorFD" size="10" class="kolorPicker" value="<?php echo $result['FontColorFD']; ?>" onChange="ChangeStyle('FontColor','FD');">
        </td>
    </tr>
    <tr>
        <td align="right">Background Color :</td>
        <td class="inputkolor">
        	<input type="text" name="BGColorA" size="10" class="kolorPicker" value="<?php echo $result['BGColorA']; ?>" onChange="ChangeStyle('BGColor','A');">
        </td>
        <td class="inputkolor">
        	<input type="text" name="BGColorO" size="10" class="kolorPicker" value="<?php echo $result['BGColorO']; ?>" onChange="ChangeStyle('BGColor','O');">
        </td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td align="right">Background Color 2 :</td>
        <td class="inputkolor">
        	<input type="text" name="BGColor2A" size="10" class="kolorPicker" value="<?php echo $result['BGColor2A']; ?>" onChange="ChangeStyle('BGColor2','A');">
        </td>
        <td class="inputkolor">
        	<input type="text" name="BGColor2O" size="10" class="kolorPicker" value="<?php echo $result['BGColor2O']; ?>" onChange="ChangeStyle('BGColor2','O');">
        </td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td align="right">Border Color :</td>
        <td class="inputkolor">
        	<input type="text" name="BorderColorA" size="10" class="kolorPicker" value="<?php echo $result['BorderColorA']; ?>" onChange="ChangeStyle('BorderColor','A');">
        </td>
        <td class="inputkolor">
        	<input type="text" name="BorderColorO" size="10" class="kolorPicker" value="<?php echo $result['BorderColorO']; ?>" onChange="ChangeStyle('BorderColor','O');">
        </td>
        <td></td>
        <td></td>
    </tr>
</tbody>
<tfoot>
	<tr>
    	<td colspan="5" align="center" style="padding-top:20px">
        	<input type="submit" name="submit" value="Save">
            <input type="button" name="cancel" value="Cancel" onClick="window.close();">
        </td>
    </tr>
</tfoot>
</table>
</center>
</form>
