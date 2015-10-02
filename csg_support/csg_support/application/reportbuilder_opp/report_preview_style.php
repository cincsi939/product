<?php
/**
 * @comment หน้าแต่ง CSS หน้า Preview Report
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    31/07/2014
 * @access     public
 */
include "db.inc.php";
$fontname = file("font/fontlist.txt");
usort($fontname,'strcasecmp');
if($_GET['action'] == 'edit' && isset($_GET['id']) && isset($_GET['uname'])){
	if(isset($_POST['action']) && $_POST['action'] == 'edit'){
		$getStyle = $_POST['FontNameCo'].'|'.$_POST['FontColorCo'].'|'.$_POST['FontSizeCo'].'|'.$_POST['ZoomCo'].'|'.$_POST['FontColorCa'].'|'.$_POST['FontSizeCa'].'|'.$_POST['FontColorEx'].'|'.$_POST['FontSizeEx'].'|'.$_POST['VisibleEx'].'|'.$_POST['TypeEx'].'|'.$_POST['StyleEx'].'|'.$_POST['FontColorRA'].'|'.$_POST['FontSizeRA'].'|'.$_POST['VisibleRA'].'|'.$_POST['FontSizeRC'].'|'.$_POST['VisibleRC'].'|'.$_POST['FontColorL'].'|'.$_POST['TextDecorationL'].'|'.$_POST['FontColorLO'].'|'.$_POST['TextDecorationLO'].'|'.$_POST['ExportCo'].'|'.$_POST['FontColorDA'].'|'.$_POST['FontSizeDA'].'|'.$_POST['VisibleDA'].'|SQLDA|'.$_POST['WidthPU'].'|'.$_POST['HeightPU'].'|'.$_POST['TopPU'].'|'.$_POST['PDFCo'];
		$sql = 'UPDATE reportinfo SET fontstyle="'.$getStyle.'", dateOfData="'.$_POST['SQLDA'].'" WHERE rid = '.$_GET['id'].' AND uname="'.$_GET['uname'].'"';
		mysql_query($sql);
		if (mysql_errno()){
			$msg = "Cannot update report";
		}else{
			$msg = "Update Success";
			echo "<script>window.close();</script>";
		}
	}
	// @modify Phada Woodtikarn 08/09/2014 เพิ่ม dateOfData
	$sql = 'SELECT fontstyle, dateOfData FROM reportinfo WHERE rid = '.$_GET['id'].' AND uname="'.$_GET['uname'].'"';
	$result = mysql_query($sql);
	$rs = mysql_fetch_array($result);
	$result = (getStylePreview($rs['fontstyle'],$rs['dateOfData']));
	// @end
}
?>
<html>
<head>
<title>Style Preview</title>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<link href="report.css" type="text/css" rel="stylesheet">
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/kolorpicker/jquery.kolorpicker.js" type="text/javascript"></script>
<link rel="stylesheet" href="js/kolorpicker/style/kolorpicker.css" type="text/css" />
<link rel="stylesheet" href="common/font/AllFont.css" />
<style>
	td {
		padding:5px;
	}
	.inputkolor{
		padding-left:30px;	
	}
	.example{
		width:300px;
		max-width:300px;
		border:solid 1px #ADADAD;
		overflow:hidden;
	}
	.exfamily{
		font-family:<?php echo $result['FontNameCo'] ?>;
	}
	#exCo{
		color:<?php echo $result['FontColorCo'] ?>;
		font-size:<?php echo $result['FontSizeCo'] ?>;
	}
	#exCa{
		color:<?php echo $result['FontColorCa'] ?>;
		font-size:<?php echo $result['FontSizeCa'] ?>;
	}
	#exEx{
		color:<?php echo $result['FontColorEx'] ?>;
		font-size:<?php echo $result['FontSizeEx'] ?>;
		<?php echo $result['VisibleEx']=='false'?'display:none;':'' ?>
	}
	#exDA{
		color:<?php echo $result['FontColorDA'] ?>;
		font-size:<?php echo $result['FontSizeDA'] ?>;
		<?php echo $result['VisibleDA']=='false'?'display:none;':'' ?>
	}
	#exRA{
		color:<?php echo $result['FontColorRA'] ?>;
		font-size:<?php echo $result['FontSizeRA'] ?>;
		<?php echo $result['VisibleRA']=='false'?'display:none;':'' ?>
	}
	#exRC{
		color:<?php echo $result['FontColorL'] ?>;
		font-size:<?php echo $result['FontSizeRC'] ?>;
		text-decoration:<?php echo $result['TextDecorationL'] ?>;
		<?php echo $result['VisibleRC']=='false'?'display:none;':'' ?>
	}
	#exRC:hover{
		color:<?php echo $result['FontColorLO'] ?>;
		text-decoration:<?php echo $result['TextDecorationLO'] ?>;
		<?php echo $result['VisibleRC']=='false'?'display:none;':'' ?>
	}
	#exL{
		font-size:<?php echo $result['FontSizeCo'] ?>;
		color:<?php echo $result['FontColorL'] ?>;
		text-decoration:<?php echo $result['TextDecorationL'] ?>;
	}
	#exLO{
		font-size:<?php echo $result['FontSizeCo'] ?>;
		color:<?php echo $result['FontColorLO'] ?>;
		text-decoration:<?php echo $result['TextDecorationLO'] ?>;
	}
</style>
<script>
	function ChangeType(){
		if($('#TypeEx').val() == 'flash'){
			$('#ExsumStyle').css('display','none');
		}else{
			$('#ExsumStyle').removeAttr('style');
		}
	}
	function ChangeStyle(type,id){
		var value;
		if(type == 'FontName'){
			type = 'font-family';
			value = $('select[name=FontName'+id+'] option:selected').text();
		}else if(type == 'FontColor'){
			type = 'color';
			value = $('input[name=FontColor'+id+']').val();
		}else if(type == 'FontSize'){
			type = 'font-size';
			value = $('input[name=FontSize'+id+']').val();
		}else if(type == 'Visible'){
			type = 'display';
			if($('input[name=Visible'+id+']:checked').val() == 'true'){
				value = 'inherit';
			}else{
				value = 'none';
			}
		}else if(type == 'TextDecoration'){
			type = 'text-decoration';
			value = $('select[name=TextDecoration'+id+'] option:selected').text();
		}
		
		if(id == 'Co'){
			if(type=='font-family'){
				id = '.exfamily';
			}else{
				id = '#exCo';
			}
		}else if(id == 'Ca'){
			id = '#exCa';
		}else if(id == 'Ex'){
			id = '#exEx';
		}else if(id == 'DA'){
			id = '#exDA';
		}else if(id == 'RA'){
			id = '#exRA';
		}else if(id == 'RC'){
			id = '#exRC';
		}else if(id == 'L'){
			id = '#exL';
		}else if(id == 'LO'){
			id = '#exLO';
		}
		
		if(type == 'font-size' && id == '#exCo'){
			$('#exL').css(type,value);
			$('#exLO').css(type,value);
			$(id).css(type,value);
		}else if(type == 'color' || type == 'text-decoration'){
			if(id == '#exL'){
				var str = $('#exLO').css(type);
				if(type == 'text-decoration'){
					str = str.substr(0, str.indexOf(' '));
				}
				$('#exRC').css(type,value);
				$('#exRC').hover(function(){
					$('#exRC').css(type,str);
				},function(){
					$('#exRC').css(type,value);
				});
			}else if(id == '#exLO'){
				var str = $('#exL').css(type);
				if(type == 'text-decoration'){
					str = str.substr(0, str.indexOf(' '));
				}
				$('#exRC').hover(function(){
					$('#exRC').css(type,value);
				},function(){
					$('#exRC').css(type,str);
				});
			}
			$(id).css(type,value);
		}else{
			$(id).css(type,value);
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
    	<td colspan="4" align="center"><h3><?php echo $msg ?></h3></td>
    </tr>
    <?php } ?>
</thead>
<tbody>
    <tr><td class="space" colspan="4"></td></tr>
    <tr><td colspan="4" align="center" style="border: solid 1px #000;">Completely Report</td></tr>
    <tr><td class="space" colspan="4"></td></tr>
    <tr>
        <td align="right" style="width:150px;">Font Name :</td>
        <td>
            <select name="FontNameCo" onChange="ChangeStyle('FontName','Co');">
                <option value="">(Default)</option>
                <?php
                    for ($i=0;$i<count($fontname);$i++){
                        if (strtolower(trim($result['FontNameCo'])) == strtolower(trim($fontname[$i]))){
                            echo '<option value="'.trim($fontname[$i]).'" selected>'.trim($fontname[$i]).'</option>';
                        }else{
                            echo '<option value="'.trim($fontname[$i]).'">'.trim($fontname[$i]).'</option>';
                        }
                    }
                ?>
            </select>
        </td>
        <td rowspan="3" class="example" align="center" valign="middle">
        	<span class="exfamily" id="exCo">Example</span>
        </td>
    </tr>
    <tr>
    	<td align="right">Font Color :</td>
        <td>
        	<input type="text" class="kolorPicker" name="FontColorCo" size="10" value="<?php echo $result['FontColorCo'] ?>" onChange="ChangeStyle('FontColor','Co');">
        </td>
    </tr>
    <tr>
    	<td align="right">Font Size :</td>
        <td>
        	<input type="text" class="numeric" name="FontSizeCo" size="2" maxlength="2" value="<?php echo $result['FontSizeCo'] ?>" onChange="ChangeStyle('FontSize','Co');">px
        </td>
    </tr>
    <?php // @modify Phada Woodtikarn 09/08/2014 เพิ่มการเปิดปิด เครื่องมือขยายขนาด ?>
    <tr><td class="space" colspan="4"></td></tr>
    <tr>
    	<td align="right">Zoom :</td>
        <td>
            <label><input type="radio" name="ZoomCo" value="true" <?php echo $result['ZoomCo']=='true'?'checked':'' ?>>Enable</label>
            <label><input type="radio" name="ZoomCo" value="false" <?php echo $result['ZoomCo']=='false'?'checked':'' ?>>Disable</label>
        </td>
        <td></td>
        <td></td>
    </tr>
    <?php // @end ?>
    <?php // @modify Phada Woodtikarn 13/08/2014 เพิ่มการ export to excel ?>
    <tr>
    	<td align="right">Export to Excel :</td>
        <td>
            <label><input type="radio" name="ExportCo" value="true" <?php echo $result['ExportCo']=='true'?'checked':'' ?>>Enable</label>
            <label><input type="radio" name="ExportCo" value="false" <?php echo $result['ExportCo']=='false'?'checked':'' ?>>Disable</label>
        </td>
        <td></td>
        <td></td>
    </tr>
    <?php // @end ?>
    <?php // @modify Phada Woodtikarn 04/05/2015 เพิ่มการ export to PDF ?>
    <tr>
    	<td align="right">Export to PDF :</td>
        <td>
            <label><input type="radio" name="PDFCo" value="true" <?php echo $result['PDFCo']=='true'?'checked':'' ?>>Enable</label>
            <label><input type="radio" name="PDFCo" value="false" <?php echo $result['PDFCo']=='false'?'checked':'' ?>>Disable</label>
        </td>
        <td></td>
        <td></td>
    </tr>
    <?php // @end ?>
    <tr><td class="space" colspan="4"></td></tr>
    <tr><td colspan="4" align="center" style="border: solid 1px #000;">Caption</td></tr>
    <tr><td class="space" colspan="4"></td></tr>
    <tr>
    	<td align="right">Font Color :</td>
        <td>
        	<input type="text" class="kolorPicker" name="FontColorCa" size="10" value="<?php echo $result['FontColorCa'] ?>" onChange="ChangeStyle('FontColor','Ca');">
        </td>
        <td rowspan="2" class="example" align="center" valign="middle">
        	<span class="exfamily" id="exCa">Example</span>
        </td>
    </tr>
    <tr>
    	<td align="right">Font Size :</td>
        <td>
        	<input type="text" class="numeric" name="FontSizeCa" size="2" maxlength="2" value="<?php echo $result['FontSizeCa'] ?>" onChange="ChangeStyle('FontSize','Ca');">px
        </td>
    </tr>
    <tr><td class="space" colspan="4"></td></tr>
    <tr><td colspan="4" align="center" style="border: solid 1px #000;">Exective Summary</td></tr>
    <tr><td class="space" colspan="4"></td></tr>
    <tr>
    	<td align="right">Font Color :</td>
        <td>
        	<input type="text" class="kolorPicker" name="FontColorEx" size="10" value="<?php echo $result['FontColorEx'] ?>" onChange="ChangeStyle('FontColor','Ex');">
        </td>
        <td rowspan="3" class="example" align="center" valign="middle">
        	<span class="exfamily" id="exEx">Exective Summary</span>
        </td>
    </tr>
    <tr>
    	<td align="right">Font Size :</td>
        <td>
        	<input type="text" class="numeric" name="FontSizeEx" size="2" maxlength="2" value="<?php echo $result['FontSizeEx'] ?>" onChange="ChangeStyle('FontSize','Ex');">px
        </td>
    </tr>
    <tr>
    	<td align="right">Visible :</td>
        <td>
            <label><input type="radio" name="VisibleEx" value="true" onChange="ChangeStyle('Visible','Ex');" <?php echo $result['VisibleEx']=='true'?'checked':'' ?>>True</label>
            <label><input type="radio" name="VisibleEx" value="false" onChange="ChangeStyle('Visible','Ex');" <?php echo $result['VisibleEx']=='false'?'checked':'' ?>>False</label>
        </td>
    </tr>
    <?php // @modify Phada Woodtikarn 07/08/2014 ?>
    <tr><td class="space" colspan="4"></td></tr>
    <tr>
    	<td align="right">Type :</td>
        <td>
        	<select id="TypeEx" name="TypeEx" onChange="ChangeType();">
				<option value="">(Default)</option>
                <option value="normal" <?php echo $result['TypeEx']=='normal'?'selected':'' ?>>Normal</option>
                <option value="flash" <?php echo $result['TypeEx']=='flash'?'selected':'' ?>>Flash</option>
            </select>
        </td>
        <td></td>
        <td></td>
    </tr>
    <tr id="ExsumStyle" <?php echo $result['TypeEx']=='flash'?'style="display:none;"':''  ?>>
    	<td align="right">Style :</td>
        <td>
        	<select name="StyleEx">
				<option value="">(Default)</option>
                <option value="blind" <?php echo $result['StyleEx']=='blind'?'selected':'' ?>>Blind</option>
                <option value="bounce" <?php echo $result['StyleEx']=='bounce'?'selected':'' ?>>Bounce</option>
                <option value="clip" <?php echo $result['StyleEx']=='clip'?'selected':'' ?>>Clip</option>
                <option value="drop" <?php echo $result['StyleEx']=='drop'?'selected':'' ?>>Drop</option>
                <option value="explode" <?php echo $result['StyleEx']=='explode'?'selected':'' ?>>Explode</option>
                <option value="fade" <?php echo $result['StyleEx']=='fade'?'selected':'' ?>>Fade</option>
                <option value="highlight" <?php echo $result['StyleEx']=='highlight'?'selected':'' ?>>Highlight</option>
                <option value="puff" <?php echo $result['StyleEx']=='puff'?'selected':'' ?>>Puff</option>
                <option value="shake" <?php echo $result['StyleEx']=='shake'?'selected':'' ?>>Shake</option>
                <option value="size" <?php echo $result['StyleEx']=='size'?'selected':'' ?>>Size</option>
                <option value="slide" <?php echo $result['StyleEx']=='slide'?'selected':'' ?>>Slide</option>
            </select>
        </td>
        <td></td>
        <td></td>
    </tr>
    <?php // @end ?>
    <?php // @modify Phada Woodtikarn 08/09/2014 เพิ่ม ข้อมูล ณ วันที่ ?>
    <tr><td class="space" colspan="4"></td></tr>
    <tr><td colspan="4" align="center" style="border: solid 1px #000;">ข้อมูล ณ วันที่</td></tr>
    <tr><td class="space" colspan="4"></td></tr>
    <tr>
    	<td align="right">Font Color :</td>
        <td>
        	<input type="text" class="kolorPicker" name="FontColorDA" size="10" value="<?php echo $result['FontColorDA'] ?>" onChange="ChangeStyle('FontColor','DA');">
        </td>
        <td rowspan="3" class="example" align="center" valign="middle">
        	<span class="exfamily" id="exDA">ข้อมูล ณ วันที่</span>
        </td>
    </tr>
    <tr>
    	<td align="right">Font Size :</td>
        <td>
        	<input type="text" class="numeric" name="FontSizeDA" size="2" maxlength="2" value="<?php echo $result['FontSizeDA'] ?>" onChange="ChangeStyle('FontSize','DA');">px
        </td>
    </tr>
    <tr>
    	<td align="right">SQL :</td>
        <td>
        	<textarea name="SQLDA"><?php echo $result['SQLDA'] ?></textarea>
        </td>
    </tr>
    <tr>
    	<td align="right">Visible :</td>
        <td>
            <label><input type="radio" name="VisibleDA" value="true" onChange="ChangeStyle('Visible','DA');" <?php echo $result['VisibleDA']=='true'?'checked':'' ?>>True</label>
            <label><input type="radio" name="VisibleDA" value="false" onChange="ChangeStyle('Visible','DA');" <?php echo $result['VisibleDA']=='false'?'checked':'' ?>>False</label>
        </td>
    </tr>
    <?php // @end ?>
    <tr><td class="space" colspan="4"></td></tr>
    <tr><td colspan="4" align="center" style="border: solid 1px #000;">รายงาน ณ วันที่</td></tr>
    <tr><td class="space" colspan="4"></td></tr>
    <tr>
    	<td align="right">Font Color :</td>
        <td>
        	<input type="text" class="kolorPicker" name="FontColorRA" size="10" value="<?php echo $result['FontColorRA'] ?>" onChange="ChangeStyle('FontColor','RA');">
        </td>
        <td rowspan="3" class="example" align="center" valign="middle">
        	<span class="exfamily" id="exRA">รายงาน ณ วันที่</span>
        </td>
    </tr>
    <tr>
    	<td align="right">Font Size :</td>
        <td>
        	<input type="text" class="numeric" name="FontSizeRA" size="2" maxlength="2" value="<?php echo $result['FontSizeRA'] ?>" onChange="ChangeStyle('FontSize','RA');">px
        </td>
    </tr>
    <tr>
    	<td align="right">Visible :</td>
        <td>
            <label><input type="radio" name="VisibleRA" value="true" onChange="ChangeStyle('Visible','RA');" <?php echo $result['VisibleRA']=='true'?'checked':'' ?>>True</label>
            <label><input type="radio" name="VisibleRA" value="false" onChange="ChangeStyle('Visible','RA');" <?php echo $result['VisibleRA']=='false'?'checked':'' ?>>False</label>
        </td>
    </tr>
    <tr><td class="space" colspan="4"></td></tr>
    <tr><td colspan="4" align="center" style="border: solid 1px #000;">รายงานเปรียบเทียบ</td></tr>
    <tr><td class="space" colspan="4"></td></tr>
    <tr>
    	<td align="right">Font Color :</td>
        <td>
        	<input type="text" class="numeric" name="FontSizeRC" size="2" maxlength="2" value="<?php echo $result['FontSizeRC'] ?>" onChange="ChangeStyle('FontSize','RC');">px
        </td>
        <td rowspan="2" class="example" align="center" valign="middle">
        	<span class="exfamily" id="exRC">รายงานเปรียบเทียบ</span>
        </td>
    </tr>
    <tr>
    	<td align="right">Visible :</td>
        <td>
            <label><input type="radio" name="VisibleRC" value="true" onChange="ChangeStyle('Visible','RC');" <?php echo $result['VisibleRC']=='true'?'checked':'' ?>>True</label>
            <label><input type="radio" name="VisibleRC" value="false" onChange="ChangeStyle('Visible','RC');" <?php echo $result['VisibleRC']=='false'?'checked':'' ?>>False</label>
        </td>
    </tr>
    <tr><td class="space" colspan="4"></td></tr>
    <tr><td colspan="4" align="center" style="border: solid 1px #000;">Link</td></tr>
    <tr><td class="space" colspan="4"></td></tr>
    <tr>
    	<td align="right">Font Color :</td>
        <td>
        	<input type="text" class="kolorPicker" name="FontColorL" size="10" value="<?php echo $result['FontColorL'] ?>" onChange="ChangeStyle('FontColor','L');">
        </td>
        <td rowspan="2" class="example" align="center" valign="middle">
        	<span class="exfamily" id="exL">Example</span>
        </td>
    </tr>
    <tr>
    	<td align="right">Text Decoration :</td>
        <td>
        	<select name="TextDecorationL" onChange="ChangeStyle('TextDecoration','L');">
            	<option value="">(Default)</option>
            	<option value="initial" <?php echo $result['TextDecorationL']=='initial'?'selected':'' ?>>initial</option>
            	<option value="line-through" <?php echo $result['TextDecorationL']=='line-through'?'selected':'' ?>>line-through</option>
            	<option value="overline" <?php echo $result['TextDecorationL']=='overline'?'selected':'' ?>>overline</option>
            	<option value="underline" <?php echo $result['TextDecorationL']=='underline'?'selected':'' ?>>underline</option>
            </select>
        </td>
    </tr>
    <tr><td class="space" colspan="4"></td></tr>
    <tr><td colspan="4" align="center" style="border: solid 1px #000;">Link(Mouse Over)</td></tr>
    <tr><td class="space" colspan="4"></td></tr>
    <tr>
    	<td align="right">Font Color :</td>
        <td>
        	<input type="text" class="kolorPicker" name="FontColorLO" size="10" value="<?php echo $result['FontColorLO'] ?>" onChange="ChangeStyle('FontColor','LO');">
        </td>
        <td rowspan="2" class="example" align="center" valign="middle">
        	<span class="exfamily" id="exLO">Example</span>
        </td>
    </tr>
    <tr>
    	<td align="right">Text Decoration :</td>
        <td>
        	<select name="TextDecorationLO" onChange="ChangeStyle('TextDecoration','LO');">
            	<option value="">(Default)</option>
            	<option value="initial" <?php echo $result['TextDecorationLO']=='initial'?'selected':'' ?>>initial</option>
            	<option value="line-through" <?php echo $result['TextDecorationLO']=='line-through'?'selected':'' ?>>line-through</option>
            	<option value="overline" <?php echo $result['TextDecorationLO']=='overline'?'selected':'' ?>>overline</option>
            	<option value="underline" <?php echo $result['TextDecorationLO']=='underline'?'selected':'' ?>>underline</option>
            </select>
        </td>
    </tr>
    <tr><td class="space" colspan="4"></td></tr>
    <tr><td colspan="4" align="center" style="border: solid 1px #000;">Pop Up</td></tr>
    <tr><td class="space" colspan="4"></td></tr>
    <tr>
    	<td align="right">Width :</td>
        <td>
        	<input type="text" name="WidthPU" size="6" value="<?php echo $result['WidthPU'] ?>">
        </td>
        <td rowspan="2" align="center" valign="middle">
        </td>
    </tr>
    <tr>
    	<td align="right">Height :</td>
        <td>
        	<input type="text" name="HeightPU" size="6" value="<?php echo $result['HeightPU'] ?>">
        </td>
    </tr>
    <tr>
    	<td align="right">Top :</td>
        <td>
        	<input type="text" name="TopPU" size="6" value="<?php echo $result['TopPU'] ?>">
        </td>
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