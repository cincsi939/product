<?php
/**
 * @comment ส่วนขยายของ executive summary
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    07/08/2014
 * @access     public
 */
if(!isset($_POST['title'])){
	$title = 'Executive Summary';
}else{
	$title = $_POST['title'];
}

$effectall = array('blind','bounce','clip','drop','explode','fade','highlight','puff','shake','size','slide');

if(!isset($_POST['effect']) || !in_array($_POST['effect'],$effectall)){
	$effect = 'fade';
}else{
	$effect = $_POST['effect'];
}
// @modify Phada Woodtikarn 12/09/2014 ถ้าเจอรูป ให้ replace ตัวแปล
$data = str_replace('src="img/','src="../img/',$_POST['data']);
// @end
// @modify Phada Woodtikarn 09/09/2014 hardcode เพื่อรายงานผลการสำรวจสภาพครอบครัว จังหวัดตราด
$data = str_replace('รายละเอียดเพิ่มเติม','',$data);
// @end
$dummyFile = ($_POST['dummyFile'])?$_POST['dummyFile']:$_GET['dummyFile'];
if(isset($_POST['dataType'])){
	$dataType = $_POST['dataType'];
}else{
	$dataType = $_GET['dataType'];
}
if(!$dataType) {
	$dataType = false;
}
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<meta name="apple-mobile-web-app-capable" content="yes"/>
<link href="font/stylesheet.css" rel="stylesheet" type="text/css" />
<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/exsum.css" rel="stylesheet" type="text/css" />
<script src="jquery.js"></script>
<script src="../js/jquery-1.10.1.min.js"></script>
<link rel="stylesheet" href="../js/jquery-ui-themes-1.10.3/themes/smoothness/jquery-ui.css" />
<script src="../js/jquery-ui-1.10.3.custom.min.js"></script>
<script>
    function runEffect(getEffect){
        var options = {};
        if(getEffect === "size"){
            options = { to: { width: 200, height: 60 } };
        }
        $('#exSummary').effect(getEffect, options, 2500,callback);
    };
    function callback() {
        if($('#exSummary').css('display') == 'none'){
            setTimeout(function() {
                $( "#exSummary" ).fadeIn();
                $('.foot_text').fadeIn(1500);
            }, 1000 );
        }else{
            setTimeout(function() {
                $('.foot_text').fadeIn(1500);
            }, 200 );
        }
    };
</script>
</head>
<body id="body" style="display:none;">
<script type="text/javascript">
	var rows = 0;
	var cols = 0;
	var el_table;
	var i,j;
	$(document).ready(function() {
		$('#body').show();
		
		el_table = $('#exSummary');
		$('#exSummary td').children().map(function (index) {
			if($(this).contents().find( "span").context.style.fontWeight == ''){
				child_fontWeight = 'normal';
			}else{
				child_fontWeight = $(this).contents().find( "span").context.style.fontWeight;
			}
			$(this).parent().css('fontWeight',child_fontWeight);
			$(this).parent().css('color',$(this).contents().find( "span").context.style.color);
			$(this).replaceWith($(this).contents());
		});
		$('#exSummary td, #exSummary tr').removeAttr('class').removeAttr('width').removeAttr('bgcolor');
		rows = $('#exSummary tr').length;
		cols = $('#exSummary > tbody > tr')[0].cells.length;
		$tp = new Array();
		/* Fix padding of td */
		switch(rows) {
			case 5: $('#exSummary td').addClass('hh65').addClass('f50'); break;
			case 6: $('#exSummary td').addClass('hh60').addClass('f26'); break;
			case 7: $('#exSummary td').addClass('hh60').addClass('f34'); break;
			case 8: $('#exSummary td').addClass('hh55').addClass('f26'); break;
			case 9: $('#exSummary td').addClass('hh55').addClass('f26'); break;
			case 10: $('#exSummary td').addClass('hh50').addClass('f26'); break;
			case 11: $('#exSummary td').addClass('hh40').addClass('f26'); break;
			case 14: $('#exSummary td').addClass('hh35').addClass('f26'); break;
			case 15: $('#exSummary td').addClass('hh35').addClass('f26'); break;
			default: $('#exSummary td').addClass('hh45').addClass('f26'); break;
		}
		/* Hide The Content */
		el_table.addClass('hidden');

		/* Show The Titel */
		$('.head_text').fadeIn(1500);
		el_table.css("display","none");
		el_table.removeClass('hidden');
		runEffect('<?php echo $effect; ?>');
		
		$("tbody td:nth-child(2)").addClass('headCol');
		var checkSub;
		$("tbody tr").each(function(idx, el) {
			checkSub = false;
			$(el).children().each(function(tdIdx, tdEl) {
				if(tdIdx == 0) {
					if($(tdEl).html() == '&nbsp;') {
						checkSub = true;
						$(tdEl).next().removeClass("headCol").addClass("subCol");
					}
				}
				if((tdIdx > 1) && (checkSub)) {
					$(tdEl).addClass("subnormalCol");
				}
			});
		});
	});
</script>
<div id="header">
	<div class="head_text" style="display: none;">
		<?php echo $title; ?>
		<div class="clear"></div>
	</div>
</div>
<div class="bgGradiant">
	<?php
	if($dataType == "file") {
		echo '<table id="'.$tableId.'" style="display: none;">';
		include($dummyFile.'.php');
		echo '</table>';
	}else {
		echo '<table id="exSummary" style="display: none;">'.$data.'</table>';
	}
	function DateThai($strDate){
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฏาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		$strMonthThai=$strMonthCut[$strMonth];
		//return "$strDay $strMonthThai $strYear เวลา $strHour:$strMinute";
		return "$strDay $strMonthThai $strYear";
	}
	//$strDate = "2008-08-14 13:42:44";
	$dateNow = date("Y-m-d H:i:s");
	?>
	<div class="clear"></div>
</div>
<div class="footer">
	<div class="foot_text" style="display: none;"><?php echo $_POST['dateOfData']!=''?$_POST['dateOfData'].'<br>':''; ?>รายงาน ณ วันที่ <?php echo DateThai($dateNow);?></div>
	<div class="clear"></div>
</div>
</body>
</html>