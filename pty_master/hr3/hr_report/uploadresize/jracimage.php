<!DOCTYPE html>
<html>
    <head>
        <meta charset='TIS-620' />
        <title>manage Image</title>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-874">
    </head>
    <body>
<link rel="stylesheet" href="../../../../common/SMLcore/Plugin/jrac/style.jrac.css">
        <link rel="stylesheet" href="../../../../common/SMLcore/FrontEnd/html/jquery-ui-smoothness-theme.css">
        <script src="../../../../common/SMLcore/TheirParty/js/jquery-1.8.1.min.js"></script>
        <script src="../../../../common/SMLcore/FrontEnd/html/jquery-ui.min.js"></script>
        <script src="../../../../common/SMLcore/Plugin/jrac/jquery.jrac.js"></script>
        <link rel="stylesheet" href="./bootstrap.css">
        <style>
		.jrac_viewport{
			width:156px !important;
			height:208px !important;
		}
		.ui-resizable-e{
			display: none !important;
		}
		.ui-resizable-s{
			display: none !important;
		}
		.ui-resizable-se{
			display: none !important;
		}
		</style>

        <?php
        $imageurl = '';
        $imagethumbnailUrl = '';
        $imagedeleteUrl = '';
		$newname = '';
        isset($_GET['imageurl']) ? $imageurl = urldecode($_GET['imageurl']) : exit();
        isset($_GET['imagethumbnailUrl']) ? $imagethumbnailUrl = urldecode($_GET['imagethumbnailUrl']) : exit();
        isset($_GET['imagedeleteUrl']) ? $imagedeleteUrl = urldecode($_GET['imagedeleteUrl']) : exit();
		isset($_GET['newname']) ? $newname = $_GET['newname'] : exit();
        ?>

        <div id="show_result" class="pane clearfix">
            <img src="../<?php echo $imageurl; ?>" alt="Loulou form Sos Chats Geneva" />
            <div class="jrac_info">
            <form id="fileupload" action="" method="POST" >
                    <input name="Iurl" type="hidden" value="../<?php echo $imageurl; ?>" />
                    <input name="imageurl" type="hidden" value="../<?php echo $imageurl; ?>" />
                    <input name="imagethumbnailUrl" type="hidden" value="../<?php echo $imagethumbnailUrl; ?>" />
                    <input name="imagedeleteUrl" type="hidden" value="../<?php echo $imagedeleteUrl; ?>" />
                    <input name="newname" type="hidden" value="<?php echo $newname; ?>" />
                    <table class="coords" style=" display: none ">
                        <tr><td>crop x</td><td><input name="Cx" type="text" /></td></tr>
                        <tr><td>crop y</td><td><input name="Cy" type="text" /></td></tr>
                        <tr><td>crop width</td><td><input name="Cwidth" type="text" /></td></tr>
                        <tr><td>crop height</td><td><input name="Cheight" type="text" /></td></tr>
                        <tr><td>image width</td><td><input name="Iwidth" type="text" /></td></tr>
                        <tr><td>image height</td><td><input name="Iheight" type="text" /></td></tr>
                        <tr><td>lock proportion</td><td><input type="checkbox" checked="checked" /></td></tr>
                    </table>
                    <input id="resizesubmit" type="button" class="btn btn-default" value="ปรับแต่งขนาด">
                </form>
            </div>
        </div>

        <script>
            $(document).ready(function() {
				$('#cboxClose').css('display', 'none');

                $('#resizesubmit').click(function() {
                    $.ajax({
                        type: 'POST',
                        url: 'manageImage.php',
                        data: $('#fileupload').serialize(),
						
                        success: function(data) {
                            $('#show_result').html(data);
							<?php
								$no = ($_GET['no']!='')?'&no='.$_GET['no']:'';
							?>
							window.parent.location.href = '../<?=$_GET[act]?>.php?id=<?=$id?>&yy=<?=$yy.$no?>';
							//$('#uploaddone', window.parent.document).val('test'+'<?php// echo $imageurl; ?>');
							//window.parent.document.post.submit();
							$('#iframere', window.parent.document).remove();							
							//window.close();
							
                            //$('#cboxClose').click();
                        },
                        error: function(message) {
                            alert(message);
                        }
                    });
//                    $.post('plugin/manageImage.php', $('#fileupload').serialize());

                    return false;
                });

                // Apply jrac on some image.
                $('.pane img').jrac({
                    'crop_width': 120,
                    'crop_height': 160,
                    'crop_left': 0,
                    'crop_top': 0,
					'zoom_min': 120,
      				'zoom_max': 1000,
                    'image_width': 156 ,
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
					var test = $(this).parents('.pane').find('.jrac_crop');
                    inputs.css('background-color', ($viewport.observator.crop_consistent()) ? 'chartreuse' : 'salmon');
					test.css('border', ($viewport.observator.crop_consistent()) ? '1px solid yellow' : '1px solid red');
                });
            });
        </script>
    </body>
</html>