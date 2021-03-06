<?php
	@session_start();
	require_once("lib/class.function.php");
	
	$con = new Cfunction();
	$con->connectDB();
	
	function getDocType($doc_id=""){
		$where = "";
		if( $doc_id != "" ){
			$where = " AND doc_id = '".$doc_id."' ";
		}
		$arrOutput = array();
		$sql = "SELECT doc_id AS doc_id,
								doc_prefix_name AS doc_prefix_name,
								doc_type_name AS doc_type_name,
								doc_orderby AS doc_orderby,
								doc_active AS doc_active
				   FROM eq_document_type 
				   WHERE doc_active = '1' ".$where." ORDER BY doc_orderby ";
		$result = mysql_query($sql) or die(mysql_error());
		while( $row = mysql_fetch_array($result) ){
			$arrOutput[$row['doc_id']]['doc_prefix_name'] = $row['doc_prefix_name'];
			$arrOutput[$row['doc_id']]['doc_type_name'] = $row['doc_type_name'];
			$arrOutput[$row['doc_id']]['doc_orderby'] = $row['doc_orderby'];
			$arrOutput[$row['doc_id']]['doc_active'] = $row['doc_active'];
		}
		return $arrOutput;
	}
	$arrDocType = getDocType();
	
?>
 
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/jquery-ui.css">
<link href="../css/uploadfile.min.css" rel="stylesheet">
<script src="../js/jquery-1.10.2.js"></script>
<script src="../js/jquery-ui.js"></script>
<script src="../js/jquery.uploadfile.min.js"></script>
<script>
	var req_id = "<?php echo $_GET['eq_id']; ?>";
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
		 url: "multi_upload_file/upload.php?req_id="+req_id+"&doc_id="+doc_id,
		 dragDrop: true,
		 
		 fileName: "myfile",
		 returnType: "json",
		 allowedTypes:"pdf",
		 extErrorStr:"��س�Ṻ����� : ",
		 doneStr:"�������",
		 sizeErrorStr:"�͡����բ�Ҵ�Թ : ",
		 maxFileSize:max_size_upload,
		 autoSubmit:false,
		 multiple:true,
		 cancelStr:'¡��ԡ',
		 req_id:req_id,
		 doc_id:doc_id,
		 dragDropStr: "<span>����ö�ҡ��¡���͡��÷���ͧ������ҧ����Ṻ��</span>",
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
				alert('��سҡ�͡��͸Ժ�¢ͧ�͡��÷����Ѿ��Ŵ���ú');
				return false;
			}else{
				uploadObj.startUpload();
			}
		});
	}
	
	function loadFileUpload(req_id,doc_id){
		/*$.get("ajax_get_file_upload.php?req_id="+req_id+"&doc_id="+doc_id,function(data){
			obj = JSON.parse(data);
			var str = '';
			var objLen = obj.length;
			if( objLen > 0 ){
				for( var i=0;i<obj.length;i++){
					//alert(obj[i]['file_name']);
					str += "<div style='margin-bottom:5px;' id='file_"+req_id+"_"+obj[i]['doc_id']+"_"+obj[i]['doc_no']+"'><a href='"+obj[i]['full_path_name']+"' target='_blank' title='��ǹ���Ŵ><img src='../../../images_sys/pdf.gif' align='absmiddle'/> "+(i+1)+".) "+obj[i]['caption']+"</a>&nbsp;&nbsp;<span onclick=\"editCaption('"+obj[i]['doc_id']+"','"+obj[i]['doc_no']+"')\" style='cursor:pointer;'><img src='../../../images_sys/b_edit.png' title='��䢤�͸Ժ��' align='absmiddle' width='16px' height='16px'/></span>&nbsp;&nbsp;<span onclick=\"deleteFile('"+obj[i]['doc_id']+"','"+obj[i]['doc_no']+"','"+obj[i]['file_name']+"','"+obj[i]['caption']+"')\" style='cursor:pointer;'><img src='../../../images_sys/p_del.gif' align='absmiddle' width='16px' height='16px' title='ź'/></span></div><div style='margin-bottom:5px; display:none;' id='edit_"+req_id+"_"+obj[i]['doc_id']+"_"+obj[i]['doc_no']+"'><input type='text' id='inputCaption_"+req_id+"_"+obj[i]['doc_id']+"_"+obj[i]['doc_no']+"' value='"+obj[i]['caption']+"'>&nbsp;&nbsp;<span onclick=\"saveCaption('"+obj[i]['doc_id']+"','"+obj[i]['doc_no']+"','"+obj[i]['caption']+"')\" style='cursor:pointer;'><img src='../../../images_sys/save.gif' title='�ѹ�֡������' align='absmiddle' width='16px' height='16px'/></span>&nbsp;&nbsp;<span onclick=\"cancelEdit('"+obj[i]['doc_id']+"','"+obj[i]['doc_no']+"')\" style='cursor:pointer;'><img src='../../../images_sys/b_drop.png' title='¡��ԡ������' align='absmiddle' width='16px' height='16px'/></span></div>";
				}
			}else{
				   str = "�ѧ������͡���Ṻ";
			}
			$('.file-uploaded-'+doc_id).empty().append(str+"<div class='countFileUploaded' id='countDoc"+doc_id+"' style='display:none;'>"+objLen+"</div>");
			checkFileUploadAll();
		});*/
	}
	
	function deleteFile(doc_id,doc_no,file_name,caption){
		if(confirm('��ͧ���ź�͡��� '+caption+' �������')===true){
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
		if(confirm('��ͧ�����䢤�͸Ժ�¨ҡ '+caption+' ��� '+newCaption+' �������')===true){
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
<div id="accordion" style="width:800px; margin-left:10px;" align="left">
    	<?php
			foreach( $arrDocType as $key => $value){
				$mark = '';
				if( $key != '4' ){
					//$mark = ' <font style=" color:red;" ><strong>*</strong></font>';
				}
				
		?>

			
            <h3><font style="font-weight:bold;font-family: THSarabunNew; font-size: 20pt;"><?php echo $value['doc_orderby']?>. <?php echo $value['doc_type_name'];?></font>&nbsp;<?php echo $mark;?>&nbsp;</h3>
            
			<div group="msg" upload_area="<?php echo $key;?>">
            	<table width="100%" align="center" style="font-size:12px;">
                	<tr>
                    	<td valign="top" colspan="2" align="left">
                        	<?php
								/*if( $key == '2' ){
									$txtMaxSize = " ��Ҵ����Թ 20 MB. ";
								}else{
									$txtMaxSize = " ��Ҵ����Թ 10 MB. ";
								}*/
								$txtMaxSize = " ��Ҵ����Թ 10 MB. ";
							?>
                        	<font style="color:#C00; font-style:italic;  padding:10px 10px 10px 10px;">(����ö���͡Ṻ�͡����������ѹ������¡�� ��� �͡��õ�ͧ����� PDF<?php echo $txtMaxSize;?>��ҹ��)</font>
                            </td>
                    </tr>
                	<tr>
                    	<td valign="top" width="65%" >
									
							<div id="startUpload<?php echo $key;?>" class="ajax-file-upload-green" style="margin-left:10px;">������Ѿ��Ŵ</div>
							<div id="deleteFileUpload<?php echo $key;?>" style="display: none;font-size: 10pt;" >Ṻ���</div>
						</td>
                    	<td valign="top" align="center"><div class="file-uploaded-<?php echo $key;?>" style="padding:10px 10px 10px 10px; margin:10px 10px 10px 10px; float:right; border:1px dashed #CCC; width:98%; text-align:left;">
                        <?php
				
							if($key == '1'){
								echo '<a href="main/dr_doc_attach/doc1.pdf" target="_blank">Ẻŧ����¹���͢��Ѻ�Է��� (��.01)</a>';
							}elseif($key == '2'){
								echo '<a href="main/dr_doc_attach/doc2.pdf" target="_blank">Ẻ�Ѻ�ͧʶҹТͧ�������͹ (��.02)</a>';
							}elseif($key == '3'){
								echo '<a href="main/dr_doc_attach/doc3.pdf" target="_blank">���Һѵû�ЪҪ��ͧ˭ԧ��駤����/��ô�</a>';
							}elseif($key == '4'){
								echo '<a href="main/dr_doc_attach/doc4.pdf" target="_blank">�͡��á�ýҡ�����������ش�ѹ�֡�آ�Ҿ��������</a>';
							}elseif($key == '5'){
								echo '<a href="main/dr_doc_attach/doc5.pdf" target="_blank">�����ٵԺѵ���</a>';
							}else{
								echo '<a href="main/dr_doc_attach/doc5.pdf" target="_blank">˹ѧ����ͺ�ӹҨ (��.05)</a>';
							}
						?>
                        </div></td>
                    </tr>
                </table>
            </div>
        <?
			}
		?>
    </div>
<script>
$(document).load(function () {
 $('.ajax-upload-dragdrop').css('width','400px');
});

</script>