<?php
class slider{	
	protected $Options = array(
			'width' => '600px',
			'height' => '300px',		
			'path' => '',
			'idslider' => 'slider',
			'closestyle' => false,
			'typeinput' => 'folder', //folder,array
			'typeoutput' => 'fullscreen', //fullscreen,url,value
			'arrayimages' => array(
							'imageurl' => 'SMLcore/Plugin/Slider/img/imageslide/logo.jpg',
							'imagetitle' => '#',
							'imagealt' => '#',
							'imagevalue' => 'null',
							'url' => '#'
							),
			'folderimages' => array(
							 'directory' => 'SMLcore/Plugin/Slider/img/imageslide/',
							 'typeimage' => 'jpg'
							 )
			);
	protected $SettingNivo = array(	
			'effect' => 'random',
			'slices' => 15,
			'boxCols' => 8,
			'boxRows' => 4,
			'animSpeed' => 500,
			'pauseTime' => 3000,
			'startSlide' => 0,
			'directionNav' => 'true',
			'controlNav' => 'true',
			'controlNavThumbs' => 'false',
			'pauseOnHover' => 'true',
			'manualAdvance' => 'false',
			'prevText' => 'Prev',
			'nextText' => 'Next',
			'randomStart' => 'false',
		    );
	
	protected function pathcssjs($SettingNivo)
	{ 	echo '<link rel="stylesheet" href="'.$this->Options['path'].'SMLcore/Plugin/Slider/themes/default/default.css" type="text/css" media="screen" />
    		<link rel="stylesheet" href="'.$this->Options['path'].'SMLcore/Plugin/Slider/css/nivo-slider.css" type="text/css" media="screen" />';
		if($this->Options['closestyle'] == false){
		echo '<link rel="stylesheet" href="'.$this->Options['path'].'SMLcore/Plugin/Slider/css/style.css" type="text/css" media="screen" />';
		}
		echo '<link rel="stylesheet" href="'.$this->Options['path'].'SMLcore/Plugin/Slider/css/blueimp-gallery.min.css">
			<script type="text/javascript" src="'.$this->Options['path'].'SMLcore/Plugin/Slider/js/jquery.nivo.slider.js"></script>     
			<script type="text/javascript">
				$(window).load(function() {
					$("#'.$this->Options['idslider'].'").nivoSlider({
						effect: \''.$this->SettingNivo['effect'].'\',
						slices: '.$this->SettingNivo['slices'].',
						boxCols: '.$this->SettingNivo['boxCols'].',
						boxRows: '.$this->SettingNivo['boxRows'].',
						animSpeed: '.$this->SettingNivo['animSpeed'].',
						pauseTime: '.$this->SettingNivo['pauseTime'].',
						startSlide: '.$this->SettingNivo['startSlide'].',
						directionNav: '.$this->SettingNivo['directionNav'].',
						controlNav: '.$this->SettingNivo['controlNav'].',
						controlNavThumbs: '.$this->SettingNivo['controlNavThumbs'].',
						pauseOnHover: '.$this->SettingNivo['pauseOnHover'].',
						manualAdvance: '.$this->SettingNivo['manualAdvance'].',
						prevText: \''.$this->SettingNivo['prevText'].'\',
						nextText: \''.$this->SettingNivo['nextText'].'\',
						randomStart: '.$this->SettingNivo['randomStart'].',								
						});					  
				});  
				
				function getreturnvalue(returnvalue){					
					$("#getreturnvalue").val(returnvalue);
				};
			</script>';
			   
	}

function slider($Options,$SettingNivo = null){
	echo '<div id="blueimp-gallery" class="blueimp-gallery"><div class="slides"></div><a class="close">×</a></div>';

	if ($Options) {
            $this->Options = array_merge($this->Options, $Options);
    }
	if ($SettingNivo) {
            $this->SettingNivo = array_merge($this->SettingNivo, $SettingNivo);
    	}
	
	echo "<style type=\"text/css\" media=\"screen\"> .slider-wrapper {width: ".$this->Options['width']."!important;}";
	echo ".nivoSlider img {width: ".$this->Options['width']." !important;height: ".$this->Options['height']." !important;}</style>";
	
	$drawhtml = '<div class="slider-wrapper theme-default"><div id="">';
	$drawhtml .= '<div id="'.$this->Options['idslider'].'" class="nivoSlider">';
	if($this->Options['typeinput'] == 'array'){
		foreach($this->Options['arrayimages'] as $arrayimage){
			if($this->Options['typeoutput']=='value'){
			$drawhtml .= '<a class="ClickFullScreen" href="javascript:getreturnvalue('.$arrayimage['imagevalue'].')" title="'.$arrayimage['imagetitle'].'">';
			$drawhtml .= '<img src="'.$arrayimage['imageurl'].'" data-thumb="'.$arrayimage['imageurl'].'"/></a>';				
			}else{
			$drawhtml .= '<a class="ClickFullScreen" href="'.(($this->Options['typeoutput']=='fullscreen')?$arrayimage['imageurl']:$arrayimage['url']).'" title="'.$arrayimage['imagetitle'].'">';
			$drawhtml .= '<img src="'.$arrayimage['imageurl'].'" data-thumb="'.$arrayimage['imageurl'].'"/></a>';
			}
		}
	}else{
		$folderimages = $this->Options['folderimages'];
		$images = glob($folderimages['directory']."*.".$folderimages['typeimage']."");
		foreach($images as $image) {
			$drawhtml .= '<a class="ClickFullScreen" href="'.$image.'" title="'.$image.'">';
			$drawhtml .= '<img src="'.$image.'" data-thumb="'.$image.'"/></a>';
		}
	}
	$drawhtml .= '</div></div></div>';
	echo $drawhtml;	
	if($this->Options['typeoutput'] == 'fullscreen' or $this->Options['typeinput'] == 'folder'){
		$this->SettingNivo['directionNav'] = 'false';
		echo '	<script src="'.$this->Options['path'].'SMLcore/Plugin/Slider/js/blueimp-gallery.min.js"></script>
			   	<script>
				document.getElementById(\''.$this->Options['idslider'].'\').onclick = function (event) {
					event = event || window.event;
					var target = event.target || event.srcElement,
						link = target.src ? target.parentNode : target,
						options = {index: link, event: event,},
						links = this.getElementsByClassName(\'ClickFullScreen\');
					blueimp.Gallery(links,options);
				};
				
				</script>';
		
	}
	$this->pathcssjs($SettingNivo);
}	
}
?>
