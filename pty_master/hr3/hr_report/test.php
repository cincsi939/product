<script src="../../../common/SMLcore/TheirParty/js/jquery-1.10.2.min.js"></script>
<?php require_once('../../../common/SMLcore/Plugin/UploadFile/UploadFile.php'); 

$folder_img2 = "../../../../edubkk_image_file/siteid/";
?> 
<table width="100%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
<tr bgcolor="#dddddd">
    <td height="20">&nbsp;&nbsp;<b>เพิ่มประวัติข้อมูลภาพบุคลากร</b></td>
</tr>	
<tr bgcolor="#ffffff" align="center">
    <td height="100">
<table width="90%" border="0" cellspacing="0" cellpadding="0">
<tr align="left">
    <td>
<ul>
	<li>รูปภาพควรสวมชุดข้าราชการขาว พื้นหลังสีน้ำเงิน หรือสีขาวเท่านั้น</li>
	<li>ขนาดรูปที่เหมาะสม กว้าง 120 pixel สูง 160 pixel (หากนำเข้ารูปขนาดอื่น การแสดงผลอาจมีการผิดเพี้ยนไม่เหมือนต้นฉบับ) </li>
	<li>ขนาด file ไม่เกิน 1 เมกาไบต์</li>
	<li>ไฟล์ต้องเป็นนามสกุล  jpg หรือ jpeg </li>
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
    <td width="26%" height="20" align="right">เลือกรูปแบบ&nbsp;<b>:</b>&nbsp;</td>
	<td width="74%">
	<input type="radio" name="flag_imgnull" id="img_upload" value="0"    />&nbsp;มีรูป&nbsp;
	|&nbsp;<input type="radio" name="flag_imgnull" id="no_img_upload"   />&nbsp;ไม่มีรูป

	</td>
</tr>
<tr>
    <td  height="20" align="right">เลือกภาพ&nbsp;<b>:</b>&nbsp;</td>
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
    <td height="20" align="right">ปี พ.ศ.&nbsp;<b>:</b>&nbsp;</td>
	<td>
	<select name="yy" style="width:80px;" onchange="showValue(this);">
	<option value="">ไม่ระบุ</option>

	</select>
	<input type="hidden" name="value_yy" id="value_yy"  style="width:150px;" /></td>
</tr>

<tr>
  <td height="20" align="right">&nbsp;</td>
  <td>
    <input type="text" name="label_yy" id="label_yy"  style="width:150px;" />
    <input  type="hidden" name="chk_yy"  id="chk_yy" value="true"  />
    <label><span class="style11"> ปี พ.ศ.ส่วนการแสดงผลในก.พ.7</span></label></td>
</tr>
<tr>
  <td height="20" align="right">&nbsp;</td>
  <td><label>
    <input name="kp7_active" type="radio" value="1" >
    แสดงใน ก.พ.7
    <input name="kp7_active" type="radio" value="0" checked="checked">
  ไม่แสดงใน ก.พ.7</label></td>
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
        
	<button style="width:60px;" onclick="addImg();">ตกลง</button>&nbsp;&nbsp;
	<button style="width:60px;" onclick="self.close();">ยกเลิก</button></td>
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