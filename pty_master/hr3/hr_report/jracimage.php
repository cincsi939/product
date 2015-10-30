<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8' />
        <title>manage Image</title>
    </head>
    <body>
        <link rel="stylesheet" href="../../../common/SMLcore/Plugin/jrac/style.jrac.css">
        <link rel="stylesheet" href="../../../common/SMLcore/FrontEnd/html/jquery-ui-smoothness-theme.css">
        <script src="../../../common/SMLcore/TheirParty/js/jquery-1.10.1.min.js"></script>
        <script src="../../../common/SMLcore/FrontEnd/html/jquery-ui.min.js"></script>
        <script src="../../../common/SMLcore/Plugin/jrac/jquery.jrac.js"></script>

        <?php
        $imageurl = '';
        $imagethumbnailUrl = '';
        $imagedeleteUrl = '';
		$newname = '';
        isset($_GET['imageurl']) ? $imageurl = $_GET['imageurl'] : exit();
        isset($_GET['imagethumbnailUrl']) ? $imagethumbnailUrl = $_GET['imagethumbnailUrl'] : exit();
        isset($_GET['imagedeleteUrl']) ? $imagedeleteUrl = $_GET['imagedeleteUrl'] : exit();
		isset($_GET['newname']) ? $newname = $_GET['newname'] : exit();
        ?>

        <div id="show_result" class="pane clearfix">
            <img src="<?php echo $imageurl; ?>" alt="Loulou form Sos Chats Geneva" />
            <div class="jrac_info">
            <form id="fileupload" action="" method="POST" >
                    <input name="Iurl" type="hidden" value="<?php echo $imageurl; ?>" />
                    <input name="imageurl" type="hidden" value="<?php echo $imageurl; ?>" />
                    <input name="imagethumbnailUrl" type="hidden" value="<?php echo $imagethumbnailUrl; ?>" />
                    <input name="imagedeleteUrl" type="hidden" value="<?php echo $imagedeleteUrl; ?>" />
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
                    <input id="resizesubmit" type="button" value="resize and crop">
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
							window.opener.location.reload();
							window.opener.deleteimage();
							window.close();
							
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
                    'crop_width': 100,
                    'crop_height': 200,
                    'crop_left': 0,
                    'crop_top': 0,
                    'image_width': 400,
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
    </body>
</html>