<?php
class uploadfile{
	protected $Options = array(
				'path' => './',
				'pathbeforesmcore' => '',
				'pathfolder' => '',
				'foldername' => 'uploadImg/',
				'rename' => null,
				'formid' => 'fileupload',
				'themecss' => 'default',
				'maxfilesize' => 5000000,
				'acceptfiletypes' => '/(\.|\/)(gif|jpe?g|png)$/i',
				'maxnumberoffiles' => null,
				'uploadresize' => null,
				'btnstart' => true,
				'btncancel' => true,
				'btndelete' => true,
				'btndeleteupload' => true, 
				'showname' => true,
				'showsize' => true,
				);
				
	protected $Optionbind = array(
									'fileuploadadd' => '',
									'fileuploadsubmit' => '',
									'fileuploadsend' => '',
									'fileuploaddone' => '',
									'fileuploadfail' => '',
									'fileuploadalways' => '',
									'fileuploadprogress' => '',
									'fileuploadprogressall' => '',
									'fileuploadstart' => '',
									'fileuploadstop' => '',
									'fileuploadchange' => '',
									'fileuploadpaste' => '',
									'fileuploaddrop' => '',
									'fileuploaddragover' => '',
									'fileuploadchunksend' => '',
									'fileuploadchunkdone' => '',
									'fileuploadchunkfail' => '',
									'fileuploadchunkalways' => '',
									'fileuploaddestroy'=> '',
									'fileuploaddestroyed'=>'',
									'fileuploadprocessfail'=> '',
									'fileuploadfailed'=> '',
								);
	
	function uploadfile($Options = null,$Optionbind = null){
		if ($Options) {
            $this->Options = array_merge($this->Options, $Options);
    	}
		if ($Optionbind){
			$this->Optionbind = array_merge($this->Optionbind, $Optionbind);
		}	
?>

<div class="container" style="padding-left:0px";> 
    <!-- The file upload form used as target for the file upload widget -->
    <?php if($this->Options['formid'] == 'fileupload'){?>
    <form id="fileupload" action="" method="POST" enctype="multipart/form-data">
    <?php } ?>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-lg-7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>เลือกรูปภาพ</span>
                    <input type="file" id="xfile" name="files">
                </span>
                <button type="submit" class="btn btn-primary start" <?php if($this->Options['btnstart'] != true)echo 'style="display:none"'; ?>>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel" <?php if($this->Options['btncancel'] != true)echo 'style="display:none"'; ?>>
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete" <?php if($this->Options['btndelete'] != true)echo 'style="display:none"'; ?>>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle" <?php if($this->Options['btndelete'] != true)echo 'style="display:none"'; ?>>
                <!-- The loading indicator is shown during file processing -->
                <span class="fileupload-loading"></span>
            </div>
            <!-- The global progress information -->
            <div class="col-lg-5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                    
                </div>
                <!-- The extended global progress information -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
 
 
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
        
   <?php 
   if($this->Options['uploadresize'] != null){
    echo "<div id=".$this->Options['uploadresize']."></div>";
   }
   if($this->Options['formid'] == null){?>
   </form>
    <?php } ?>
    
    <br>
</div>
<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" style="display:none" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">&lsaquo;</a>
    <a class="next">&rsaquo;</a>
    <a class="close">&times;</a>
    <ol class="indicator"></ol>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
				
	<tr class="template-upload fade">
	<td>
	<span class="preview"></span>
    </td>
    <td>
	<p class="name" <?php if($this->Options['showname'] != true) echo 'style="display:none"'; ?> >{%=file.name%}</p>
    {% if (file.error) { %}
    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
    {% } %}
    </td>
    <td>
    <p class="size" <?php if($this->Options['showsize'] != true) echo 'style="display:none"'; ?>>{%=o.formatFileSize(file.size)%}</p>
    {% if (!o.files.error) { %}
    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" <?php if($this->Options['showsize'] != true) echo 'style="width:120px"'; ?>><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
    {% } %}
    </td>
	<?php if($this->Options['rename'] != null){ 
				echo "{%type = file.name.split('.').pop()
				file.name =	'".$this->Options['rename']."'+'.'+type;%}";				
				}?>
    <td>
    {% if (!o.files.error && !i && !o.options.autoUpload) { %}
    <button class="btn btn-primary start" title="อัพโหลดรูปภาพ">
    <i class="glyphicon glyphicon-upload"></i>
    <span>อัพโหลดรูปภาพ</span>
    </button>
    {% } %}
    {% if (!i) { %}
    <button class="btn btn-warning cancel" title="ยกเลิก">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span>ยกเลิก</span>
    </button>
    {% } %}
    </td>
    </tr>
    {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
	
    <td>	
    <span class="preview">
    {% if (file.thumbnailUrl) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}" width="80px"></a>
    {% } %}
    </span>
    </td>
    <td>
    <p class="name" <?php if($this->Options['showname'] != true) echo 'style="display:none"'; ?>>
    {% if (file.url) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
    {% } else { %}
    <span>{%=file.name%}</span>
    {% } %}
    </p>
    {% if (file.error) { %}
    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
    {% } %}
    </td>
    <td>
    <span class="size" <?php if($this->Options['showsize'] != true) echo 'style="display:none"'; ?>>{%=o.formatFileSize(file.size)%}</span>
    </td>
    <td>
    {% if (file.deleteUrl) { %}
    <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %} <?php if($this->Options['btndeleteupload'] != true) echo 'style="display:none"'; ?> title="ลบรูปภาพ">
    <i class="glyphicon glyphicon-trash"></i>
    <span>ลบรูปภาพ</span>
    </button>
    <input type="checkbox" name="delete" value="1" class="toggle" <?php if($this->Options['btndelete'] != true or $this->Options['maxnumberoffiles'] == 1)echo 'style="display:none"'; ?>>
    {% } else { %}
    <button class="btn btn-warning cancel">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span>Cancel</span>
    </button>
    {% } %}
    </td>
    </tr>
    {% } %}
</script>

<script>
 
    $(function() {
        'use strict';
 
        // Initialize the jQuery File Upload widget:
        $('#<?=$this->Options['formid'] ?>').fileupload({
			
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: 'uploadresize/UploadNowImage.php?path=<?php echo base64_encode($this->Options['path']); ?>&foldername=<?php echo base64_encode($this->Options['foldername']); ?>&pathfolder=<?php echo base64_encode($this->Options['pathfolder']); ?>&pathbeforesmcore=<?php echo base64_encode($this->Options['pathbeforesmcore']); ?>',
			
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            maxFileSize: <?=$this->Options['maxfilesize'] ?>,
            acceptFileTypes: <?=$this->Options['acceptfiletypes'] ?>,
            <?php if($this->Options['maxnumberoffiles'] != null) echo 'maxNumberOfFiles:'.$this->Options['maxnumberoffiles'] ?>
			
			
        })
		.bind('fileuploadadd', function (e, data) {<?= $this->Optionbind['fileuploadadd'] ?>})
		.bind('fileuploadsubmit', function (e, data) {<?= $this->Optionbind['fileuploadsubmit'] ?>})
		.bind('fileuploadsend', function (e, data) {<?= $this->Optionbind['fileuploadsend'] ?>})
		.bind('fileuploaddone', function (e, data) {<?= $this->Optionbind['fileuploaddone'] ?>})
		.bind('fileuploadfail', function (e, data) {<?= $this->Optionbind['fileuploadfail'] ?>})
		.bind('fileuploadalways', function (e, data) {<?= $this->Optionbind['fileuploadalways'] ?>})
		.bind('fileuploadprogress', function (e, data) {<?= $this->Optionbind['fileuploadprogress'] ?>})
		.bind('fileuploadprogressall', function (e, data) {<?= $this->Optionbind['fileuploadprogressall'] ?>})
		.bind('fileuploadstart', function (e) {<?= $this->Optionbind['fileuploadstart'] ?>})
		.bind('fileuploadstop', function (e) {<?= $this->Optionbind['fileuploadstop'] ?>})
		.bind('fileuploadchange', function (e, data) {<?= $this->Optionbind['fileuploadchange'] ?>})
		.bind('fileuploadpaste', function (e, data) {<?= $this->Optionbind['fileuploadpaste'] ?>})
		.bind('fileuploaddrop', function (e, data) {<?= $this->Optionbind['fileuploaddrop'] ?>})
		.bind('fileuploaddragover', function (e) {<?= $this->Optionbind['fileuploaddragover'] ?>})
		.bind('fileuploadchunksend', function (e, data) {<?= $this->Optionbind['fileuploadchunksend'] ?>})
		.bind('fileuploadchunkdone', function (e, data) {<?= $this->Optionbind['fileuploadchunkdone'] ?>})
		.bind('fileuploadchunkfail', function (e, data) {<?= $this->Optionbind['fileuploadchunkfail'] ?>})
		.bind('fileuploadchunkalways', function (e, data) {<?= $this->Optionbind['fileuploadchunkalways'] ?>})
		.bind('fileuploaddestroy', function (e, data) {<?= $this->Optionbind['fileuploaddestroy'] ?>})
		.bind('fileuploaddestroyed', function (e, data) {<?= $this->Optionbind['fileuploaddestroyed'] ?>})
		.bind('fileuploadprocessfail', function (e, data) {<?= $this->Optionbind['fileuploadprocessfail'] ?>})
		.bind('fileuploadfailed', function (e, data) {<?= $this->Optionbind['fileuploadfailed'] ?>});
		
        // Load existing files:
        $('#<?=$this->Options['formid'] ?>').addClass('fileupload-processing');
		
 
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#<?=$this->Options['formid'] ?>').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#<?=$this->Options['formid'] ?>')[0]
        }).always(function() {
            $(this).removeClass('fileupload-processing');
        }).done(function(result) {
            $(this).fileupload('option', 'done')
                    .call(this, null, {result: result});
					
        });
 
    });
</script>

<script src="<?=$this->Options['path'] ?>SMLcore/Plugin/UploadFile/js/jquery.fileupload-multi-files-th.js"></script>
<link rel="stylesheet" href="<?=$this->Options['path'] ?>SMLcore/Plugin/UploadFile/css/blueimp-gallery.min.css">
<link rel="stylesheet" href="<?=$this->Options['path'] ?>SMLcore/Plugin/UploadFile/css/jquery.fileupload-ui.css">
<link rel="stylesheet" href="<?=$this->Options['path'] ?>SMLcore/Plugin/UploadFile/css/bootstrap-3.0.0/css/bootstrap.min.css">
<?php if($this->Options['themecss']!='default'){ 
		echo '<link rel="stylesheet" href="'.$this->Options['themecss'].'">';
	}
	}
}
?>