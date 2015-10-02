<?php
	session_start();
	include('../../../config/conndb_nonsession.inc.php');
	include('function_sql.php');
	$arrDocType = getDocType();
	/*echo 'display_errors = ' . ini_get('display_errors') . "<hr>";
	echo 'register_globals = ' . ini_get('register_globals') . "<hr>";
	echo 'post_max_size = ' . ini_get('post_max_size') . "<hr>";
	echo 'post_max_size+1 = ' . (ini_get('post_max_size')+1) . "<hr>";
	echo 'post_max_size in bytes = ' . return_bytes(ini_get('post_max_size'));*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Mullti Upload File</title>
<link rel="stylesheet" href="../../../common/css/jquery-ui.css">
<link href="../../../common/css/uploadfile.min.css" rel="stylesheet">
<style>
	@font-face {
 font-family: 'thsarabun';
 src: url('/competency_master/common/font/thsarabun-webfont.eot');
 src: url('/competency_master/common/font/thsarabun-webfont.eot?#iefix') format('embedded-opentype'),
   url('/competency_master/common/font/thsarabun-webfont.woff') format('woff'),
   url('/competency_master/common/font/thsarabun-webfont.ttf') format('truetype'),
   url('/competency_master/common/font/thsarabun-webfont.svg#THSarabunPSKRegular') format('svg');
 font-weight: normal;
 font-style: normal;   
}

body,iframe,table,select,strong,input,div {
		font-family: thsarabun  !important ;
		font-size:16px;
}

</style>
<script src="../../../common/js/jquery-1.10.2.js"></script>
<script src="../../../common/js/jquery-ui.js"></script>
<script src="../../../common/js/jquery.uploadfile.min.js"></script>
<script>
	var req_id = "<?php echo $_GET['req_id']?>";
	$(function(){
		$( "#accordion" ).accordion();
		$("div[group=msg]").each(function(){
				$(this).height(185);
				$(this).css('padding','0px');
				AddUploadJquery($(this).attr('upload_area'));
				loadFileUpload(req_id,$(this).attr('upload_area'));
		});
		parent.$('.modal-dialog').css('height','665px');
		parent.$('.modal-dialog').css('margin-top','0');
	});
	
	function AddUploadJquery(doc_id){
		/*if( doc_id != '2' ){
			var max_size_upload = 1024*10000;
		}else{
			var max_size_upload = 1024*15000;
		}*/
		var max_size_upload = 1024*10000;
		var uploadObj = $("#deleteFileUpload"+doc_id).uploadFile({
		 url: "upload.php?req_id="+req_id+"&doc_id="+doc_id,
		 dragDrop: true,
		 fileName: "myfile",
		 returnType: "json",
		 allowedTypes:"pdf",
		 extErrorStr:"กรุณาแนบไฟล์เป็น : ",
		 doneStr:"เสร็จสิ้น",
		 sizeErrorStr:"เอกสารมีขนาดเกิน : ",
		 maxFileSize:max_size_upload,
		 autoSubmit:false,
		 multiple:true,
		 cancelStr:'ยกเลิก',
		 req_id:req_id,
		 doc_id:doc_id,
		 dragDropStr: "<span>สามารถลากรายการเอกสารที่ต้องการมาวางเพื่อแนบได้</span>",
		 showStatusAfterSuccess:false,
			onSuccess:function(files,data,xhr)
			{
				$('.ajax-file-upload-statusbar').css('width','400px');
				loadFileUpload(req_id,doc_id);
			},
			onError: function(files,status,errMsg)
			{
				$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Error for: "+JSON.stringify(files));
			}
		 });
		 $("#startUpload"+doc_id).click(function(){
			 var countEmptyCaption = 0;
			$('div[upload_area='+doc_id+'] .caption_input').each(function(){
				var strCheck = $(this).val();
				if(strCheck.replace(' ','')==''){
					countEmptyCaption++;	
				}
			});
			if( countEmptyCaption > 0 ){
				alert('กรุณากรอกคำอธิบายของเอกสารที่จะอัพโหลดให้ครบ');
				return false;
			}else{
				uploadObj.startUpload();
			}
		});
	}
	
	function loadFileUpload(req_id,doc_id){
		$.get("ajax_get_file_upload.php?req_id="+req_id+"&doc_id="+doc_id,function(data){
			obj = JSON.parse(data);
			var str = '';
			var objLen = obj.length;
			if( objLen > 0 ){
				for( var i=0;i<obj.length;i++){
					//alert(obj[i]['file_name']);
					str += "<div style='margin-bottom:5px;' id='file_"+req_id+"_"+obj[i]['doc_id']+"_"+obj[i]['doc_no']+"'><a href='"+obj[i]['full_path_name']+"' target='_blank' title='ดาวน์โหลด><img src='../../../images_sys/pdf.gif' align='absmiddle'/> "+(i+1)+".) "+obj[i]['caption']+"</a>&nbsp;&nbsp;<span onclick=\"editCaption('"+obj[i]['doc_id']+"','"+obj[i]['doc_no']+"')\" style='cursor:pointer;'><img src='../../../images_sys/b_edit.png' title='แก้ไขคำอธิบาย' align='absmiddle' width='16px' height='16px'/></span>&nbsp;&nbsp;<span onclick=\"deleteFile('"+obj[i]['doc_id']+"','"+obj[i]['doc_no']+"','"+obj[i]['file_name']+"','"+obj[i]['caption']+"')\" style='cursor:pointer;'><img src='../../../images_sys/p_del.gif' align='absmiddle' width='16px' height='16px' title='ลบ'/></span></div><div style='margin-bottom:5px; display:none;' id='edit_"+req_id+"_"+obj[i]['doc_id']+"_"+obj[i]['doc_no']+"'><input type='text' id='inputCaption_"+req_id+"_"+obj[i]['doc_id']+"_"+obj[i]['doc_no']+"' value='"+obj[i]['caption']+"'>&nbsp;&nbsp;<span onclick=\"saveCaption('"+obj[i]['doc_id']+"','"+obj[i]['doc_no']+"','"+obj[i]['caption']+"')\" style='cursor:pointer;'><img src='../../../images_sys/save.gif' title='บันทึกการแก้ไข' align='absmiddle' width='16px' height='16px'/></span>&nbsp;&nbsp;<span onclick=\"cancelEdit('"+obj[i]['doc_id']+"','"+obj[i]['doc_no']+"')\" style='cursor:pointer;'><img src='../../../images_sys/b_drop.png' title='ยกเลิกการแก้ไข' align='absmiddle' width='16px' height='16px'/></span></div>";
				}
			}else{
				   str = "ยังไม่มีเอกสารแนบ";
			}
			$('.file-uploaded-'+doc_id).empty().append(str+"<div class='countFileUploaded' id='countDoc"+doc_id+"' style='display:none;'>"+objLen+"</div>");
			checkFileUploadAll();
		});
	}
	
	function deleteFile(doc_id,doc_no,file_name,caption){
		if(confirm('ต้องการลบเอกสาร '+caption+' หรือไม่')===true){
			$.get("delete.php?req_id="+req_id+"&doc_id="+doc_id+"&doc_no="+doc_no+"&name="+file_name,function(data){
				loadFileUpload(req_id,doc_id);
				checkFileUploadAll();
			});
		}
	}
	
	function editCaption(doc_id,doc_no){
		$('#file_'+req_id+'_'+doc_id+'_'+doc_no).fadeOut(400);
		$('#edit_'+req_id+'_'+doc_id+'_'+doc_no).delay(400).fadeIn(400);
	}
	
	function saveCaption(doc_id,doc_no,caption){
		var newCaption = $('#inputCaption_'+req_id+'_'+doc_id+'_'+doc_no).val();
		//alert(newCaption+' || '+req_id+' || '+doc_id+' || '+doc_no);
		if(confirm('ต้องการแก้ไขคำอธิบายจาก '+caption+' ไปเป็น '+newCaption+' หรือไม่')===true){
			$.get("edit_caption.php?req_id="+req_id+"&doc_id="+doc_id+"&doc_no="+doc_no+"&newCaption="+newCaption,function(data){
				loadFileUpload(req_id,doc_id);
			});
		}
	}
	function cancelEdit(doc_id,doc_no){
		$('#edit_'+req_id+'_'+doc_id+'_'+doc_no).fadeOut(400);
		$('#file_'+req_id+'_'+doc_id+'_'+doc_no).delay(400).fadeIn(400);
	}
	
	function checkFileUploadAll(){
		var cnt1 = 0;
		var cnt2 = 0;
		var cnt3 = 0;
		$('.countFileUploaded').each(function(){
				if( $(this).attr('id') == 'countDoc1' ){
					cnt1 += parseInt($(this).html());
				}else if( $(this).attr('id') == 'countDoc2' ){
					cnt2 += parseInt($(this).html());
				}else if( $(this).attr('id') == 'countDoc3' ){
					cnt3 += parseInt($(this).html());
				}
		});
		//alert(cnt+' || '+cn);
		if( cnt1 > 0 && cnt2 > 0 && cnt3 > 0 ){
			parent.$(".menuGetEffect .attach_files .img_menu").attr('src','images/Attach.png');
		}else{
			parent.$(".menuGetEffect .attach_files .img_menu").attr('src','images/Attach_non.png');
		}
	}
</script>
</head>

<body style="margin:0">
  <div id="accordion">
    	<?php
			foreach( $arrDocType as $key => $value){
				$mark = '';
				if( $key != '4' ){
					$mark = ' <font style="font-size:16px; color:red;" ><strong>*</strong></font>';
				}
		?>
            <h3><font  style="font-size:16px; font-weight:bold;">เอกสารแนบ :: <?php echo $value['doc_type_name'];?></font>&nbsp;<?php echo $mark;?>&nbsp;</h3>
            <div group="msg" upload_area="<?php echo $key;?>">
            	<table width="100%">
                	<tr>
                    	<td valign="top" colspan="2" align="left">
                        	<?php
								/*if( $key == '2' ){
									$txtMaxSize = " ขนาดไม่เกิน 20 MB. ";
								}else{
									$txtMaxSize = " ขนาดไม่เกิน 10 MB. ";
								}*/
								$txtMaxSize = " ขนาดไม่เกิน 10 MB. ";
							?>
                        	<font style="color:#C00; font-style:italic; font-size:16px; padding:10px 10px 10px 10px;">(สามารถเลือกแนบเอกสารได้พร้อมกันหลายรายการ และ เอกสารต้องเป็นไฟล์ PDF<?php echo $txtMaxSize;?>เท่านั้น)</font>
                            </td>
                    </tr>
                	<tr>
                    	<td valign="top" width="65%"><div id="startUpload<?php echo $key;?>" class="ajax-file-upload-green" style="margin-left:10px;">เริ่มอัพโหลด</div><div id="deleteFileUpload<?php echo $key;?>" style="display: none;">แนบไฟล์</div></td>
                    	<td valign="top" align="center"><div class="file-uploaded-<?php echo $key;?>" style="padding:10px 10px 10px 10px; margin:10px 10px 10px 10px; float:right; border:1px dashed #CCC; width:98%; text-align:left;">
                                    ยังไม่มีเอกสารแนบ
                                 </div></td>
                    </tr>
                </table>
            </div>
        <?
			}
		?>
    </div>
</body>
<script>
$(document).load(function () {
 $('.ajax-upload-dragdrop').css('width','400px');
});

</script>
</html>