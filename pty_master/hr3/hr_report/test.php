<script src="../../../common/SMLcore/TheirParty/js/jquery-1.10.2.min.js"></script>
<?php require_once('../../../common/SMLcore/Plugin/UploadFile/UploadFile.php'); 

$folder_img2 = "../../../../edubkk_image_file/siteid/";
?> 
<table width="100%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
<tr bgcolor="#dddddd">
    <td height="20">&nbsp;&nbsp;<b>��������ѵԢ������Ҿ�ؤ�ҡ�</b></td>
</tr>	
<tr bgcolor="#ffffff" align="center">
    <td height="100">
<table width="90%" border="0" cellspacing="0" cellpadding="0">
<tr align="left">
    <td>
<ul>
	<li>�ٻ�Ҿ�������ش����Ҫ��â�� �����ѧ�չ���Թ �����բ����ҹ��</li>
	<li>��Ҵ�ٻ���������� ���ҧ 120 pixel �٧ 160 pixel (�ҡ������ٻ��Ҵ��� ����ʴ����Ҩ�ա�üԴ���¹�������͹�鹩�Ѻ) </li>
	<li>��Ҵ file ����Թ 1 ����亵�</li>
	<li>����ͧ�繹��ʡ��  jpg ���� jpeg </li>
</ul>	
	</td>
</tr>
</table>

	</td>
</tr>
<tr bgcolor="#ffffff">
    <td height="20" colspan="3">
<form id='testform'name="post" action='' method="post" enctype="multipart/form-data">	
<input type="hidden" name="id" value="" />
<input type="hidden" name="action" value="upload" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td colspan="2" height="15"></td>
</tr>
<tr>
    <td width="26%" height="20" align="right">���͡�ٻẺ&nbsp;<b>:</b>&nbsp;</td>
	<td width="74%">
	<input type="radio" name="flag_imgnull" id="img_upload" value="0"    />&nbsp;���ٻ&nbsp;
	|&nbsp;<input type="radio" name="flag_imgnull" id="no_img_upload"   />&nbsp;������ٻ

	</td>
</tr>
<tr>
    <td  height="20" align="right">���͡�Ҿ&nbsp;<b>:</b>&nbsp;</td>
	<td ><input type="file" id="xfile" name="file" style="width:200px;" />
<?php
                            $options = array(
                                'path' => '../../../common/',
								'foldername' => $folder_img2,
                                'formid' => 'testform',
								'maxnumberoffiles' => 1,
								'uploadresize' => 'resizetest',
                            );
							$Optionbind = array(
							'fileuploaddone' => "$.each(data.result.files, function(index, file) {
																	$('#imageurl').val(file.url);
																	$('#imagethumbnailUrl').val(file.thumbnailUrl);
																	$('#imagedeleteUrl').val(file.deleteUrl);
																	$('#imageurl').click();
																	return false;});",
																		);


                            $testupload = new uploadfile($options,$Optionbind);
                            ?>
                            <div id='test1'></div>
    </td>
    
</tr>
<tr>
    <td height="20" align="right">�� �.�.&nbsp;<b>:</b>&nbsp;</td>
	<td>
	<select name="yy" style="width:80px;" onchange="showValue(this);">
	<option value="">����к�</option>

	</select>
	<input type="hidden" name="value_yy" id="value_yy"  style="width:150px;" /></td>
</tr>

<tr>
  <td height="20" align="right">&nbsp;</td>
  <td>
    <input type="text" name="label_yy" id="label_yy"  style="width:150px;" />
    <input  type="hidden" name="chk_yy"  id="chk_yy" value="true"  />
    <label><span class="style11"> �� �.�.��ǹ����ʴ���㹡.�.7</span></label></td>
</tr>
<tr>
  <td height="20" align="right">&nbsp;</td>
  <td><label>
    <input name="kp7_active" type="radio" value="1" >
    �ʴ�� �.�.7
    <input name="kp7_active" type="radio" value="0" checked="checked">
  ����ʴ�� �.�.7</label></td>
</tr>
<input name="submenu_id" id="submenu_id" type="hidden" size="50" value="" >
    <input name="subject_error" id="subject_error" type="hidden" size="50" value="" >
    <input name="value_key_error" id="value_key_error" type="hidden" size="50" value="" >
    <input name="label_key_error" id="label_key_error" type="hidden" size="50" value="" >
</table>
</form>
	</td>
</tr>
<tr bgcolor="#dddddd" align="center">
    <td height="20">
        
	<button style="width:60px;" onclick="addImg();">��ŧ</button>&nbsp;&nbsp;
	<button style="width:60px;" onclick="self.close();">¡��ԡ</button></td>
</tr>
</table>
<input type="hidden" id="imageurl" value="" >
<input type="hidden" id="imagethumbnailUrl" value="" >
<input type="hidden" id="imagedeleteUrl" value="" >
<input type="hidden" id="newname" value="test_edit" >
<script type="text/javascript">
	function deleteimage(){
		$(".delete").click();
		
	}
    $(document).ready(function() {		
		
        $('#imageurl').click(function() {
			
        	window.open("jracimage.php?imageurl=" + $("#imageurl").val() + '&imagethumbnailUrl=' + $("#imagethumbnailUrl").val() + '&imagedeleteUrl=' + $("#imagedeleteUrl").val() + '&newname=' + $("#newname").val());
			
             
            return false;
            $.ajax({
                type: 'GET',
                url: 'jracimage.php',
                data: "imageurl=" + $("#imageurl").val() + '&imagethumbnailUrl=' + $("#imagethumbnailUrl").val() + '&imagedeleteUrl=' + $("#imagedeleteUrl").val() + '&newname=' + $("#newname").val(),
                success: function(data) {
                    $.colorbox({
                        html: data,
                        opacity: 0.5,
                        width: "650px",
                        height: "600px",
                        overlayClose: false,
                        onClosed: function() {
                            // open the other colorBox
                           $(".delete").click();
                            location.reload();
                        }
                    });
                },
                error: function(message) {
                    alert(message);
                }
            });
            return false;
        });

    });
</script>