<?php
class jrac{
	protected $Options = array(
				'path' => './',
				'imageurl' => 'managetest/manageImg/snsd3.jpg',
				'imagealt' => '#',
				'formaction' => '',
				'settingstart' => array(
								'crop_width' => 250,
            					'crop_height' => 120,
					            'crop_left' => 100,
					            'crop_top' => 100,
					            'image_width' => 400,				
								),
				'savetodirfolder' => '',
				'savetofilename' => '',
				'savetofiletype' => 'jpg'
				);
	protected $imageurl = null;
	
	function returnimageurl(){
		echo $this->imageurl;
		}
	
	function jrac($Options){
		if ($Options) {
            $this->Options = array_merge($this->Options, $Options);
    	}
?>

<script src="<?=$this->Options['path'] ?>SMLcore/FrontEnd/html/jquery-ui.min.js"></script>
<script src="<?=$this->Options['path'] ?>SMLcore/Plugin/jrac/jquery.jrac.js"></script>
<link rel="stylesheet" href="<?=$this->Options['path'] ?>SMLcore/Plugin/jrac/style.jrac.css">
<link rel="stylesheet" href="<?=$this->Options['path'] ?>SMLcore/FrontEnd/html/jquery-ui-smoothness-theme.css">

<div class="pane clearfix">
    <img src="<?=$this->Options['imageurl'] ?>" alt="<?=$this->Options['imagealt'] ?>" />
    <div class="jrac_info">
        <form id="fileupload" action="<?=$this->Options['formaction'] ?>" method="POST" >
            <table class="coords">
                <input name="Iurl" type="hidden" value="<?=$this->Options['imageurl'] ?>" />
                <tr><td>crop x</td><td><input name="Cx" type="text" /></td></tr>
                <tr><td>crop y</td><td><input name="Cy" type="text" /></td></tr>
                <tr><td>crop width</td><td><input name="Cwidth" type="text" /></td></tr>
                <tr><td>crop height</td><td><input name="Cheight" type="text" /></td></tr>
                <tr><td>image width</td><td><input name="Iwidth" type="text" /></td></tr>
                <tr><td>image height</td><td><input name="Iheight" type="text" /></td></tr>
                <tr><td>lock proportion</td><td><input type="checkbox" checked="checked" /></td></tr>
            </table>
            <input type="submit" name="resizecrop" value="resize and crop">
        </form>
    </div>
</div>
 <?php $settingstart = $this->Options['settingstart']; ?>
<script>
    $(document).ready(function() {
        // Apply jrac on some image.
        $('.pane img').jrac({
            'crop_width': <?= $settingstart['crop_width'] ?>,
            'crop_height': <?= $settingstart['crop_height'] ?>,
            'crop_left': <?= $settingstart['crop_left'] ?>,
            'crop_top': <?= $settingstart['crop_top'] ?>,
            'image_width': <?= $settingstart['image_width'] ?>,
            'viewport_onload': function() {
                var $viewport = this;
                var inputs = $viewport.$container.parent('.pane').find('.coords input:text');
                var events = ['jrac_crop_x', 'jrac_crop_y', 'jrac_crop_width', 'jrac_crop_height', 'jrac_image_width', 'jrac_image_height'];
                for (var i = 0; i < events.length; i++) {
                    var event_name = events[i];
                    // Register an event with an element.
                    $viewport.observator.register(event_name, inputs.eq(i));
                    // Attach a handler to that event for the element.
                    inputs.eq(i).bind(event_name, function(event, $viewport, value) {
                        $(this).val(value);
                    })
                            // Attach a handler for the built-in jQuery change event, handler
                            // which read user input and apply it to relevent viewport object.
                            .change(event_name, function(event) {
                        var event_name = event.data;
                        $viewport.$image.scale_proportion_locked = $viewport.$container.parent('.pane').find('.coords input:checkbox').is(':checked');
                        $viewport.observator.set_property(event_name, $(this).val());
                    })
                }
            }
        })
                // React on all viewport events.
                .bind('jrac_events', function(event, $viewport) {
            var inputs = $(this).parents('.pane').find('.coords input');
            inputs.css('background-color', ($viewport.observator.crop_consistent()) ? 'chartreuse' : 'salmon');
        });
    });
</script>
<?php 
		if(isset($_POST['resizecrop'])){
			include $this->Options['path'].'SMLcore/Plugin/WideImage/WideImage.php';
			$Iurl = '';
			$Cx = '';
			$Cy = '';
			$Cwidth = '';
			$Cheight = '';
			$Iwidth = '';
			$Iheight = '';
			isset($_POST['Iurl']) ? $Iurl = $_POST['Iurl'] : exit();
			isset($_POST['Cx']) ? $Cx = $_POST['Cx'] : exit();
			isset($_POST['Cy']) ? $Cy = $_POST['Cy'] : exit();
			isset($_POST['Cwidth']) ? $Cwidth = $_POST['Cwidth'] : exit();
			isset($_POST['Cheight']) ? $Cheight = $_POST['Cheight'] : exit();
			isset($_POST['Iwidth']) ? $Iwidth = $_POST['Iwidth'] : exit();
			isset($_POST['Iheight']) ? $Iheight = $_POST['Iheight'] : exit();
	 
			// resize
			$thumb = WideImage::load($Iurl)->resize($Iwidth, $Iheight);
	 
			// crop
			$thumb = $thumb->crop($Cx, $Cy, $Cwidth, $Cheight);
			
	 		$nameimage = basename($this->Options['imageurl'], ".".pathinfo($this->Options['imageurl'], PATHINFO_EXTENSION)."");
			if($this->Options['savetofilename'] == ''){
				$namesaveimage = $this->Options['savetodirfolder'].$nameimage.'_edit.'.$this->Options['savetofiletype'];
			}else{
				$namesaveimage = $this->Options['savetodirfolder'].$this->Options['savetofilename'].'.'.$this->Options['savetofiletype'];
			}
			// save
			$thumb->saveToFile($namesaveimage);
			$this->imageurl = $namesaveimage;
			
		}; 
	}
}
?>