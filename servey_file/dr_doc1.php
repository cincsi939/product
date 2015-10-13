<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Wised Wisesvatcharajaren
 * @created  25/07/2558
 * @access  public
 */
 ?>
<?php
	include("../../config/config_host.php"); #อ้างหาค่า Define
	require_once('lib/nusoap.php');
	require_once("lib/class.function.php");
	include "../../common/php_class/class_calculate_kpi.php";
	$con = new Cfunction();
	$con->connectDB();
	if(isset($_GET['id']) && $_GET['id'] != '')
	{
		$sql = "select siteid,form_id,number_action,pin,child_userid,vid,yy,mm,value,reportdate,eq_id from eq_var_data where siteid=1 AND form_id=1 AND pin='".$_GET['id']."' AND eq_id='".$_GET['eq_id']."'";
		//echo $sql ;
		$results = $con->select($sql);
		foreach($results as $row)
		{
			$value[$row['vid']] = $row['value'];
		}
		$action = 'dr_doc1_edit_exc.php';
		$from = 'edit';
		/*--------------------------------------------------------------------------------------- set Database*/
	}
	else
	{
		$action = 'dr_doc1_exc.php';
		$from = 'add';
	}
	function change_date_format($value){
		$date = explode('-',$value);
		$result = $date['2']."/".$date['1']."/".($date['0']+543);
		return $result;
	}
	//print_r($_SESSION);
?>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/tab.css">
<script src="../js/jquery-1.10.1.min.js"></script>
<script src="../js/moment.js"></script>


<link rel="stylesheet" href="../package/jquery-ui/jquery-ui.css">
<script src="../package/jquery-ui/jquery-ui-thai.js"></script>
<script language="JavaScript">
	function showimagepreview(input) {
	if (input.files && input.files[0]) {
	var filerdr = new FileReader();
	filerdr.onload = function(e) {
	$('#imgprvw').attr('src', e.target.result);
	}
		filerdr.readAsDataURL(input.files[0]);
	}
}

$(function() {
    $('.tabs li').on('click', function() {
        var tabId = $(this).attr('data-tab');

        $('.tabs li').removeClass('current');
        $('.tab-pane').removeClass('current'); 

        $(this).addClass('current');
        $('#' + tabId).addClass('current');
    });
});


</script>
<script language="JavaScript">
function CreateXmlHttp(){
		//Creating object of XMLHTTP in IE
		try {
			XmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e){
			try{
				XmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			} 
			catch(oc) {
				XmlHttp = null;
			}
		}
		//Creating object of XMLHTTP in Mozilla and Safari 
		if(!XmlHttp && typeof XMLHttpRequest != "undefined") {
			XmlHttp = new XMLHttpRequest();
		}
	} // end function CreateXmlHttp
	
function chgAmphur(e, defa_v, tambon) {
		if ( e ) {
			//document.getElementById('v9').disabled = true;
			CreateXmlHttp();
			XmlHttp.open("get", "main/ajax.chgamphur.php?PvID="+e+"&DfVal="+defa_v, true);
			XmlHttp.onreadystatechange=function() {//alert("Aussy!!");
				if (XmlHttp.readyState==4) {
					
					if (XmlHttp.status==200) {
						var res = XmlHttp.responseText; //alert(res);
						document.getElementById("lblAmphur").innerHTML = res;
						chgTambon(defa_v, tambon);
					} else if (XmlHttp.status==404) {
						alert("ไม่สามารถทำการดึงข้อมูลได้");
					} else {
						alert("Error : "+XmlHttp.status);
					}
				}
			};
			XmlHttp.send(null);
			//chgTambon(e,'');
		}
	}
	
function chgTambon(e, defa_v) {
		if ( e ) {
			CreateXmlHttp();
			XmlHttp.open("get", "main/ajax.chgtambon.php?TbID="+e+"&DfVal="+defa_v, true);
			XmlHttp.onreadystatechange=function() {
				if (XmlHttp.readyState==4) {
					if (XmlHttp.status==200) {
						var res = XmlHttp.responseText; //alert(res);
						document.getElementById("lblTambon").innerHTML = res;
					} else if (XmlHttp.status==404) {
						alert("ไม่สามารถทำการดึงข้อมูลได้");
					} else {
						alert("Error : "+XmlHttp.status);
					}
				}
			};
			XmlHttp.send(null);
		}
}

function chgAmphur2(e, defa_v, tambon) {
		if ( e ) {
			//document.getElementById('v9').disabled = true;
			CreateXmlHttp();
			XmlHttp.open("get", "main/ajax.chgamphur.php?PvID="+e+"&DfVal="+defa_v+"&no=2", true);
			XmlHttp.onreadystatechange=function() {//alert("Aussy!!");
				if (XmlHttp.readyState==4) {
					
					if (XmlHttp.status==200) {
						var res = XmlHttp.responseText; //alert(res);
						document.getElementById("lblAmphur2").innerHTML = res;
						chgTambon(defa_v, tambon);
					} else if (XmlHttp.status==404) {
						alert("ไม่สามารถทำการดึงข้อมูลได้");
					} else {
						alert("Error : "+XmlHttp.status);
					}
				}
			};
			XmlHttp.send(null);
			//chgTambon(e,'');
		}
	}
	
function chgTambon2(e, defa_v) {
		if ( e ) {
			CreateXmlHttp();
			XmlHttp.open("get", "main/ajax.chgtambon.php?TbID="+e+"&DfVal="+defa_v+"&no=2", true);
			XmlHttp.onreadystatechange=function() {
				if (XmlHttp.readyState==4) {
					if (XmlHttp.status==200) {
						var res = XmlHttp.responseText; //alert(res);
						document.getElementById("lblTambon2").innerHTML = res;
					} else if (XmlHttp.status==404) {
						alert("ไม่สามารถทำการดึงข้อมูลได้");
					} else {
						alert("Error : "+XmlHttp.status);
					}
				}
			};
			XmlHttp.send(null);
		}
}

function chgPreName(e) {
	if ( e ) {
			CreateXmlHttp();
			XmlHttp.open("get", "main/ajax.chkprename.php?pre="+e, true);
			XmlHttp.onreadystatechange=function() {
				if (XmlHttp.readyState==4) {
					if (XmlHttp.status==200) {
						var res = XmlHttp.responseText; //alert(res);
						document.getElementById("lblPreName").innerHTML = res;
					} else if (XmlHttp.status==404) {
						alert("ไม่สามารถทำการดึงข้อมูลได้");
					} else {
						alert("Error : "+XmlHttp.status);
					}
				}
			};
			XmlHttp.send(null);
		}
}

$(document).ready(function(){
	choose_tab_2();
	showFatherData();
	$('#v417_4').click(function(){
		$('.father_data').show();
		$("#chk_m_status").val('4');
	});
	$('#v417_3').click(function(){
		$('.father_data').show();
		$("#chk_m_status").val('3');
	});
	$('#v417_2').click(function(){
		$('.father_data').show();
		$("#chk_m_status").val('2');
	});
	$('#v417_1').click(function(){
		$('.father_data').hide();
		$("#chk_m_status").val('1');
	});
	$('#random2').click(function(){
		$('.father_data').show();
		$('#v417_3').attr("checked","true");
	});
	
	chk_maxday();
	chk_lessmonth();
	$('#sMonth').change(function(){
		chk_maxday();
	});
	$('#sYear').change(function(){
		chk_maxday();
		chk_lessmonth()
	});
	count_month_born();
	date_born();
	month_should_born();
	$('#div-container').click(function(){
		$('#iframe-popup').fadeOut('fast',function(){
			$('#div-container').fadeOut('fast');
		});
	});
	var d = new Date();
	var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);
	$('.datepickbirth').datepicker({
   dateFormat: 'dd/mm/yy',
   isBuddhist: true,
   defaultDate: toDay,
   dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
   dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
   monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
   monthNamesShort: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
   showOtherMonths: true,
   selectOtherMonths: true,
   showButtonPanel: false,
   changeMonth: true,
   changeYear: true,
   numberOfMonths: 1,
   yearRange: '1914:2020',
   showWeek: false,
   firstDay: 1,
   beforeShow: function(){    
    $(".ui-datepicker, select").css('font-size', 14) 
   },
	maxDate:'-<?=AGE_MOTHER;?>Y',
  });

	$('.datepick').datepicker({
   dateFormat: 'dd/mm/yy',
   isBuddhist: true,
   defaultDate: toDay,
   dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
   dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
   monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
   monthNamesShort: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
   showOtherMonths: true,
   selectOtherMonths: true,
   showButtonPanel: false,
   changeMonth: true,
   changeYear: true,
   numberOfMonths: 1,
   yearRange: '1914:2020',
   showWeek: false,
   firstDay: 1,
   beforeShow: function(){    
    $(".ui-datepicker, select").css('font-size', 14) 
   }
  });
});

function popup(idcard,url){
	url = url+'&id='+idcard;
	$('#div-container').fadeIn('fast',function(){
			$('#iframe-popup').fadeIn('fast',function(){
				$('#iframe-popup').attr('src',url);
			});
		});
}
function CheckNum(){
		if (event.keyCode < 48 || event.keyCode > 57){
		      event.returnValue = false;
	    	}
	}
</script>
<script language="JavaScript">
       function chkdel(){
              if(confirm(' คุณต้องการลบตารางข้อมูลนี้ ')){
                     return true; // ถ้าตกลง OK โปรแกรมก็จะทำงานต่อไป 
              }else{
                     return false; // ถ้าตอบ Cancel ก็คือไม่ต้องทำอะไร 
              }
       }
	   function chk_dupp(){
			var dupp_idcard=$('#v3').val();
			if(dupp_idcard!=''){
					link_page = 'main/ajax.chk_dupp.php?dupp_idcard='+dupp_idcard;
					$.get(link_page, function(data){
						if(data!=''){
						$('#v416').val(data);
						$('#eq_idcard_status').val('2');
						}else{
						$('#v416').val('');	
						$('#eq_idcard_status').val('0');
						}
					});
					}else{
						$('#v416').val('');	
						$('#eq_idcard_status').val('0');
					}
		}
		function Random(min_val, max_val) {
		return Math.floor(Math.random() * (max_val - min_val + 1)) + min_val;
		}
		function monthDiff(d1, d2) {
			var months;
			months = (d2.getFullYear() - d1.getFullYear()) * 12;
			months -= d1.getMonth() + 1;
			months += d2.getMonth();
			return months;
		}
		function date_born(){
			var preg_week=$('#v901').val();
			if(preg_week=='0'){
				var reg_date = $('#sMonth').val()+'/'+$('#sDay').val()+'/'+(parseInt($('#sYear').val())-543);
				var preg_day = reg_date;
			}else{
			var reg_date = $('#sMonth').val()+'/'+$('#sDay').val()+'/'+(parseInt($('#sYear').val())-543);
			var preg_date=parseInt(preg_week)*7;
			var preg_day = moment(reg_date).subtract(preg_date, 'days').calendar();
			//console.log(preg_day);
			}
			$('#preg_day').val(preg_day);
		}
		function count_month_born(){
			var day1 = '19';
			var month1 = $('#v902').val();
			month1 = parseInt(month1) - 1;
			var year1 = $('#v903').val();
			year1 = parseInt(year1)-543;
			
			var pregDay = $('#preg_day').val();
			day_split = pregDay.split('/');
			var day2 = day_split['1'];
			var month2 = day_split['0'];
			month2 = parseInt(month2) - 1;
			var year2 = day_split['2'];
			
			monthPreg = monthDiff(
				new Date(year2, month2, day2) ,
				new Date(year1, month1, day1)
			);
			$('#monthPreg').val(monthPreg);
		}
		function month_should_born(){
			var should_born = $('#preg_day').val().split('/');
			var a = parseInt(should_born['0'])
			var b = parseInt(should_born['2'])+543;
			for(var i=1;i<=9;i++){
				 a = a+1;
				if(a==13){
					a=1;
					b = b+1;
				}else{
					a=a;
				}
				//console.log(a);
			}
			month_should = ['','มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
			$('#shouldBorn').val(month_should[a]+' พ.ศ. '+b);
		}
		function chk_maxday(){
			var chk_month=$('#sMonth').val();
			var chk_year=$('#sYear').val();
			var chk_day= maxDays(chk_month,chk_year);
			var selected_day = $('#sDay').val();
					link_page = 'main/ajax.chk_day.php?chk_day='+chk_day+'&selected_day='+selected_day;
					$.get(link_page, function(data){
						$('#sDay').html(data);
					});
					//console.log(link_page);
		}
		function chk_lessmonth(){
			var chk_year=$('#sYear').val();
			var chk_month=$('#sMonth').val();
					link_page = 'main/ajax.chk_month.php?chk_year='+chk_year+'&chk_month='+chk_month;
					$.get(link_page, function(data){
						$('#sMonth').html(data);
					});
		}
		function showFatherData(){
			if($("#chk_m_status").val()=='2'){
				$(".father_data").show();
				//alert('1');
			}else if($("#chk_m_status").val()=='3'){
				$(".father_data").show();
				//alert('2');
			}else{
				$(".father_data").hide();
				//alert('3');
			}
		}
function fncSubmit()
{
		var verify = '';
	
	
	

	
	if(document.form1.v376.value.trim() == "")
	{
		verify += '-กรุณาเลือกคำนำหน้าชื่อ\n';
		
		
	}

	if(document.form1.v1.value.trim() == "" || document.form1.v2.value.trim() == "")
	{
		
		verify += '-กรุณากรอกชื่อ หรือนามสกุล\n';
		
	}
	
	if(document.form1.v377.value == "")
	{
		
		verify += '-กรุณาระบุวัน เดือน ปีเกิด\n';
		
	}
	
	if(document.form1.v33.value == "")
	{
		
		verify += '-กรุณาระบุอาชีพ\n';
		
	}
	
	/*if($('#v3').val().length != 13)
	{
		
		verify += '-กรุณากรอกเลขประจำตัวประชาชนให้ครบ13หลัก\n';
		
	}*/
	
	if(document.form1.v810.value.trim() == "")
	{
		
		verify += '-กรุณาเลือกจังหวัดที่อยู่ปัจจุบัน\n';
		
	}
	
	if(document.form1.v809.value.trim() == "")
	{
		
		verify += '-กรุณาเลือกอำเภอที่อยู่ปัจจุบัน\n';
		
	}
	if(document.form1.v808.value.trim() == "")
	{
		
		verify += '-กรุณาเลือกตำบลที่อยู่ปัจจุบัน\n';
		
	}
	
	
	
	
	/*if(document.form1.v902.value == "")
	{
		alert('กรุณาระบุเดือนที่ครบกำหนดคลอด');
		document.form1.v902.focus();
		return false;
	}*/
	
	
	
	if($('#v414').val().trim() == "" && ($('#chk_m_status').val()=='2' || $('#chk_m_status').val()=='3'))
	{
		verify += '-กรุณากรอกบัตรประชาชนของบิดา \n';
	}
	
	if($('#v414').val().length != 13 && ($('#chk_m_status').val()=='2' || $('#chk_m_status').val()=='3'))
	{
		
		verify += '-กรุณากรอกเลขประจำตัวประชาชนของบิดาให้ครบ13หลัก\n';
		
	}
	
	if(verify != ''){
		alert(verify);	
		return false;	
	}
	
	if($('#dataApprove').is(':checked')){}else{
		alert('กรุณาเลือกยืนยันข้อมูลของท่าน');
		$('#dataApprove').focus();
		return false;
	}
	
	
	
	
	
	
	
	
	if($('#eq_idcard_status').val() == '2')
	{
		if(confirm('เลขประจำตัวประชาชนนี้มีในระบบ\nต้องการบันทึกหรือไม่?')){
		}else{
			document.form1.v3.focus();
		return false;
		}
	}
	
	
	
		if($('#v3').val().indexOf("ส") == '-1'){
	var result = $('#v3').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
	} else {
		if(confirm('เลขประจำตัวประชาชนของมารดาไม่ถูกต้อง\nต้องการบันทึกหรือไม่?')){
		$('#eq_idcard_status').val('1');
		}else{
			document.form1.v3.focus();
		return false;
		}
	}
		}else{
			$('#eq_idcard_status').val('3');
		}
		if($('#v414').val().indexOf("ส") == '-1' && $('#v414').val().trim() !=''){
	var result = $('#v414').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
	} else {
		if(confirm('เลขประจำตัวประชาชนของบิดาไม่ถูกต้อง\nต้องการบันทึกหรือไม่?')){
		}else{
			document.form1.v414.focus();
		return false;
		}
	}
		}
	
	//console.log($('#monthPreg').val());
	if($('#v907').is(':checked')){
	count_month_born();
	date_born();
	month_should_born();
	if($('#monthPreg').val() != '7' && $('#monthPreg').val() != '8' && $('#monthPreg').val() != '9'){
		if(confirm('ระบบได้คำนวนวันที่ครบกำหนดคลอดควรเป็น : '+$('#shouldBorn').val()+'\nต้องการบันทึกหรือไม่?')){
			
		}else{
		document.form1.v902.focus();
		return false;
		}
	}
	}
}

</script>
 <script>
  $(function() {
  		var d = new Date();
	var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);

    $( ".datepick1000" ).datepicker({
dateFormat: 'dd/mm/yy',
			isBuddhist: true,
			defaultDate: toDay,
			dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
			dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
			monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
			monthNamesShort: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
			showOtherMonths: true,
			selectOtherMonths: true,
			showButtonPanel: false,
			changeMonth: true,
			changeYear: true,
			numberOfMonths: 1,
			showWeek: false,
			maxDate:+0,
	beforeShow: function(){    
    $(".ui-datepicker, select").css('font-size', 14) 
   }
    });
  });

  </script>
<?php
	$ws_client = $con->configIPSoap();
	$calendar = array('file' => 'calendar');
	echo $ws_client->call('includefile', $calendar);
	/*$para = array(
		'dateFormat' => 'dd/mm/yy',
		'inputname' => 'v377',
		'showicon' => false,
		'showOtherMonths' => true,
		'showButton' => false,
		'showchangeMonth' => true,
		'numberOfMonths' => 1,
		'format' => 'tis-620',
		'value' => $value[377],
		'showWeek' => false);	
	 $result = $ws_client->call('calendar', $para);*/
?>
<style>

.style1{
	color:#F00;
}

.disable_form{
	background-color:#DDD;
}

.enable_form{
	background-color:#FFF;
}

div#div-container{
	background-color:#CCC;
	opacity:0.5;
	left:0px;
	top:0px;
	width:100%;
	height:100%;
	z-index:998;
	position:fixed;
	display:none;
}
iframe#iframe-popup{
	background-color:#FFF;
	left:10%;
	top:10%;
	width:80%;
	height:550px;
	z-index:999;
	position:fixed;
	display:none;
	box-shadow: 5px 5px 5px #888888;
	border:0px;
}
.form-code{border:1px solid #000;padding:3px 7px; width:80px;}
</style>
<?php
	$sql_consider_result="SELECT consider_result FROM eq_approve_person WHERE eq_id = '".$_GET['eq_id']."'";
//echo $sql_consider_result;
	$rs_consider_result = mysql_query($sql_consider_result);
	$result_consider_result = mysql_fetch_assoc($rs_consider_result);
//echo'<hr>';
//print_r($rs_consider_result);
//echo'<hr>';

//print_r($result_consider_result);
//echo'<hr>';

?>
<?php 
$then = $value[701];
$then = strtotime($then); 
$now = time();
$difference = $now - $then;
$days = floor(($difference / (60*60*24))-1);
?>
<div class="container">
<div class="tab-example">
  <ul class="tabs">
    <li class="tab-link current" data-tab="part_1" id="tab1">ส่วนที่ 1 ข้อมูลหญิงตั้งครรภ์/มารดา (ผู้ลงทะเบียน)</li>
	<?php if($result_consider_result['consider_result'] =='0'){ ?>
    <li class="tab-link" data-tab="part_2" id="tab2">ส่วนที่ 2 ข้อมูลเด็กแรกเกิด</li>
	<?php } ?>
  </ul>
  <div class="tab-contents">
  <div class="tab-pane current" id="part_1">
<form action="main_exc/<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form1" name="form1" onSubmit="JavaScript:return fncSubmit();">
<header>
        
        <!--<div class="clear"></div>-->
    </header>
<table width="90%" border="0">
<tbody>
	<div class="form-code" align="right" style="
    margin-left: 81%;"><span>แบบ ดร. 01</span></div>
	  <div class="write-at" align="right">
            <span class="require">เขียนที่</span>
            <input 	type="text" 
            		id=""
                    name="" 
                    value="" size="15" style="margin-right:5.2%">
        </div>
		
		
    	<td colspan="4" align="right" >ลงทะเบียน ณ วันที่ <?php
		if($results['0']['reportdate']){
			$regis_date = explode('-',$results['0']['reportdate']);
			//print_r($regis_date);
			$register_date = ($regis_date['0']+543).'-'.$regis_date['1'].'-'.$regis_date['2'];
		}else{
			$register_date = '';
		}
		echo $con->_calendarTH('sDay','sMonth','sYear',$register_date); ?>
  	  </td>
      </tr>
    <tr>
   	  <td colspan="3" align="left"><b><u>ส่วนที่ 1</u></b> <b>ข้อมูลหญิงตั้งครรภ์/มารดา (ผู้ลงทะเบียน)</b></td>
		<!--<td width="246" align="right"><div class="form-code">แบบ ดร. 01</div> </td>-->
	</tr>
    <tr>
      <td width="24" align="right">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td rowspan="8" align="center" valign="top">
		<video id="video" style="display:none"></video>
		<canvas id="canvas" style="display:none"></canvas>
		<img src="" id="photo" alt="photo" style="display:none">
      <?php
	  	if(($value['378'] =='')or($value['378']==NULL))
		{
			$valueImg = '<img src="../img/nopicture.gif" width="120" height="160" id="imgprvw" alt="uploaded image preview" name="pPicture">';
		}
		else
		{
			$valueImg = '<img src="../../../repo_csg/profile/'.$value['378'].'" width="120" height="160" id="imgprvw" alt="uploaded image preview" name="pPicture">';
		}
		echo $valueImg;
	  ?>
		<input type="button" id="startbutton" style="display:none" value="ถ่ายรูป">
		<input type="button" id="cancel_capture" style="display:none" value="ยกเลิก">
		<input type="button" id="capture_again" style="display:none" value="ถ่ายรูปใหม่">
        <input type="File" name="v378" id="v378" onChange="showimagepreview(this)" style=" margin-left: 20%; ">
		<div><span align="right"><span class="style1">*</span>ขนาดภาพที่เหมาะสมคือ 120X160 pixels</span></div>
		<!--input type="button" id="takePhoto" value="ถ่ายรูปใหม่"-->
		<input type="hidden" id="lastPhoto" name="lastPhoto"></td>
    </tr>
	<tr>
      <td height="25" align="right"></td>
      <td height="25" colspan="2">
        ชื่อผู้ลงทะเบียน&nbsp;<span class="style1">*</span>
		
          <select id="tPrename" name="v376" onChange="chgPreName(this.value)" >
          	<option value="">-คำนำหน้าชื่อ-</option>
            <?php
				$sql_Prename = 'SELECT id,prename_th,gender FROM `tbl_prename` WHERE gender = "2" AND prename_th NOT LIKE "%เด็ก%" ORDER BY priority asc;';
				$results_Prename = $con->select($sql_Prename);
				foreach($results_Prename as $rd){
						if($value[376]==$rd['id'])
						{
							echo '<option selected  value="'.$rd['id'].'">'.$rd['prename_th'].'</option>';
						}
						else
						{
							echo '<option  value="'.$rd['id'].'">'.$rd['prename_th'].'</option>';
						}
				}
			 ?>
		</select>
          
          ชื่อ    <input name="v1" type="text" value="<?php echo $value[1]; ?>" id="v1" size="15"  onkeypress='return chaonly()'/>
          นามสกุล
          <input type="text" value="<?php echo $value[2]; ?>"  name="v2" id="v2" size="15" onkeypress='return chaonly()'/>
        </td>
      </tr>
	  <tr>
      <td height="25" align="right"></td>
      <td height="25" colspan="2">วันเกิด <span class="style1">*</span> <input 	type="text" 
											class="datepickbirth" 
											name="v377" 
                                            id = "v377" 
											value="<?php if(change_date_format($value[377])=="/543/543" || change_date_format($value[377])=="//543"){	
													echo "";
											}else{
												echo (change_date_format($value[377]));
											}
											?>">  อายุ
											<span id="show_age">&nbsp;&nbsp;<?php echo $value[14]; ?>&nbsp;</span>
        <INPUT name="v14" type="hidden" id="v14" value="<?php echo $value[14]; ?>" size="4" maxlength="4" class="numberOnly" />
ปี</td>
    </tr>
    <tr>
      <td height="25" align="right"></td>
      <td height="25" colspan="2">อาชีพ <span class="style1">*</span><input  name="v33" type="text" value="<?php echo $value[33]; ?>" style="width:300px" id="tCareer"  /></td>
    </tr>
    <tr>
      <td height="25" align="right"></td>
      <td height="25" colspan="2" valign="middle">
        เลขประจำตัวประชาชน<span class="style1"> *</span>
        <INPUT name="v3" type="text" id="v3" value="<?php echo $value[3]; ?>" size="30" <?php if($value[3]==''){}else{echo 'readonly';} ?>  onblur="chk_dupp()" onkeypress='return numonly()'/>        
        <!--span  id="idClassCheck" class="bIdCard">ตรวจสอบ</span-->   <!--<span  id="random2" class="bIdCard">สุ่มเลขบัตร</span><span id="showLabel1"></span></td>-->
      </tr>
	
    <tr>
    	<td height="25" align="right"></td>
         <td height="25" colspan="2" valign="middle">
         	วันออกบัตร&nbsp;<input 	type="text" 
											class="datepick1000" 
											name="v701" 
                                            id = "v701" 
											value="<?php if(change_date_format($value[701])=="/543/543" || change_date_format($value[701])=="//543"){	
													echo "";
											}else{
												echo (change_date_format($value[701]));
											}
											?>">
			วันหมดอายุ&nbsp;<input 	type="text" 
											class="datepick1001" 
											name="v702" 
                                            id = "v702" 
											value="<?php if(change_date_format($value[702])=="/543/543" || change_date_format($value[702])=="//543"){	
													echo "";
											}else{
												echo (change_date_format($value[702]));
											}
											?>">
         </td>
    </tr>
	<tr>
      <td height="25" align="right"></td>
      <td height="25" colspan="2" valign="middle">
	  สถานะประกันสังคม 
		<select id="v419" name="v419" style="width:150px;">
			<option value="">--- ระบุ ---</option>
			<option value="1" <?php echo ($value[419]=='1'?'selected':'') ?>>เป็นผู้ประกันตน</option>
			<option value="0" <?php echo ($value[419]=='0'?'selected':'') ?>>ไม่ได้เป็นผู้ประกันตน</option>
		</select>
		
		<div id="testData1" style="display:none;"></div>
	  </td>
      </tr>  
	<tr><td>&nbsp;</td></tr>
    
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td height="25" colspan="3" valign="middle"><table width="100%" border="0" cellpadding="1" cellspacing="1">
      	 <tr>
         	<td colspan="4"><u>ที่อยู่ตามทะเบียนบ้าน</u></td>
         </tr>
        <tr>
          <td width="61" align="left">บ้านเลขที่</td>
          <td width="152"><INPUT type="text" value="<?php echo $value[5]; ?>" name="v5" style="width:100px" id="v5" onkeypress='return numonly()'/></td>
          <td width="76" align="left">หมู่ที่</td>
          <td width="151"><input type="text" value="<?php echo $value[6]; ?>"  name="v6" style="width:50px" id="v6" onkeypress='return numonly()'/></td>
          <td width="61" align="left">อาคาร/ตึก</td>
          <td width="152"><INPUT type="text" value="" name="tuk1" style="width:100px" id="tuk1" /></td>
          <td width="76" align="left">ชั้น</td>
          <td width="151"><input type="text" value=""  name="chan1" style="width:50px" id="chan1" /></td>
          
        </tr>
		<tr>
		 <td align="left" width="76">เลขที่ห้อง </td>
          <td width="151"><input type="text" value=""  name="number_home1" style="width:90%" id="number_home1" /></td>
		   <td align="left" width="76">หมู่บ้าน</td>
          <td width="151"><INPUT type="text" value="<?php echo $value[814]; ?>" name="v814" style="width:90%" id="v814" /></td>
		<td align="left" width="76">ตรอก/ซอย </td>
          <td width="151"><input type="text" value="<?php echo $value[13]; ?>"  name="v13" style="width:90%" id="v13" /></td>
          <td align="left" width="76">ถนน </td>
          <td width="151"><input type="text" value="<?php echo $value[7]; ?>" name="v7" style="width:90%" id="v7" /></td>

		</tr>
        <tr>
          <td align="left">จังหวัด </td>
          <td><!--<input type="text" value="" name="tProvince" />-->
          
          <select id="v10" name="v10" onChange = "chgAmphur(this.value);"  style="width:90%" >
		  <option value="">โปรดระบุ</option>
            <?php
				$conn1 = "";
				if($value[10] == '' ){
					$conn1 = "";
				}else{
					$conn1 = " AND ccDigi LIKE '".substr($value[10],0,2)."%' ";
				}
				$sql_Changwat = "Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = 'Changwat' ";
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					if($value[10]==$rd['ccDigi'])
					{
						echo '<option selected  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
					else
					{
						echo '<option  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
				}
			 ?>
		</select></td>
          <td align="left">อำเภอ/เขต </td>
          <td>
           <LABEL id="lblAmphur">
          	<select id="v9" name="v9" onChange = "chgTambon(this.value, '');" style="width:90%">
            <option value="">โปรดระบุ</option>
            <?php
			if($value[10]!=''){
				$sql_Changwat = "Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = 'Aumpur' ".$conn1;
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					if($value[9]==$rd['ccDigi'])
					{
						echo '<option selected value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
					else
					{
						echo '<option  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
				}
			 }
			 ?>
            </select>
            </LABEL>
          
           <!--<input type="text" value="" name="tDistrict"/>--></td>
          
          <td align="left">ตำบล/แขวง </td>
          <td><!--<input type="text" value=""  name="tParish"/>-->
          <LABEL id="lblTambon">
          <select id="v8" name="v8" style="width:90%">
          <option value="">โปรดระบุ</option>
          <?php
				if($value[9]!=''){
				$sql_Changwat = "Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = 'Tamboon' ".$conn1;
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					if($value[8]==$rd['ccDigi'])
					{
						echo '<option selected value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
					else
					{
						echo '<option  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
				}
		  }
			 ?>
          </select>
          </LABEL></td>
          <td align="left">รหัสไปรษณีย์</td>
          <td><input type="text" value="<?php echo $value[406]; ?>"  name="v406" style="width:30%" id="v406" onkeypress='return numonly()' maxlength="5"/></td>
          </tr>
		  <tr>
		  <td align="left">โทรศัพท์</td>
          <td><input type="text" value="<?php echo $value[11]; ?>"  name="v11" style="width:90%" id="v11"/></td>
		  <td align="left" style="height: 60px;width: 90px;">โทรศัพท์มือถือ</td>
          <td><input type="text" value="<?php echo $value[410]; ?>"  name="v410" style="width:90%" id="v410"/></td>
		  </tr>
      </table>
      <table width="100%" border="0" cellpadding="1" cellspacing="1">
      	 <tr>
         	<td><u>ที่อยู่ปัจจุบัน</u></td>
			<td width="161"><pp id="hide_add"><input type="checkbox" name="sl_address" id="sl_address" value="1"  onclick="CheckAddress_Now()" disabled></pp>ใช้ที่อยู่ตามทะเบียนบ้าน</td>
         </tr>
         <tr>
          <td width="61" align="left">บ้านเลขที่</td>
          <td width="152"><INPUT type="text" value="<?php echo $value[805]; ?>" name="v805" style="width:100px" id="v805" onkeypress='return numonly()'/></td>
         <td align="left" width="76">หมู่ที่</td>
          <td width="151"><input type="text" value="<?php echo $value[806]; ?>"  name="v806" style="width:50px" id="v806" onkeypress='return numonly()' /></td>
		  <td width="61" align="left">อาคาร/ตึก</td>
          <td width="152"><INPUT type="text" value="" name="tuk1" style="width:100px" id="tuk2" /></td>
          <td width="76" align="left">ชั้น</td>
          <td width="151"><input type="text" value=""  name="chan2" style="width:50px" id="chan2" /></td>
          
          </tr>
		  <td align="left" width="76">เลขที่ห้อง </td>
          <td width="151"><input type="text" value=""  name="number_home2" style="width:90%" id="number_home2" /></td>
		  <td align="left" width="76">หมู่บ้าน</td>
          <td width="151"><INPUT type="text" value="" name="village_2" style="width:90%" id="village_2" /></td>
		  <td align="left" width="76">ตรอก/ซอย </td>
          <td width="151"><input type="text" value="<?php echo $value[813]; ?>"  name="v813" style="width:90%" id="v813" /></td>
		  <td align="left">ถนน </td>
          <td><input type="text" value="<?php echo $value[807]; ?>" name="v807" style="width:90%" id="v807" /></td>
		  <tr>
		  </tr>
        <tr>
          
          
		   <td align="left">จังหวัด <span class="style1"> *</span></td>
          <td><!--<input type="text" value="" name="tProvince" />-->
          
          <select id="v810" name="v810" onChange = "chgAmphur2(this.value);"  style="width:90%" >
            <option value="">โปรดระบุ</option>
			<?php
				$conn2 = "";
				if($value[810] == '' ){
					$conn2 = "";
				}else{
					$conn2 = " AND ccDigi LIKE '".substr($value[810],0,2)."%' ";
				}
				$sql_Changwat = "Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = 'Changwat' ";
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					if($value[810] == $rd['ccDigi'])
					{
						echo '<option selected  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
					else
					{
						echo '<option  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
				}
			 ?>
		</select></td>
		
		<td align="left">อำเภอ/เขต <span class="style1"> *</span></td>
          <td>
           <LABEL id="lblAmphur2">
          	<select id="v809" name="v809" onChange = "chgTambon2(this.value, '');" style="width:100%">
            <option value="">โปรดระบุ</option>
            <?php
				if($value[810]!=''){
				$sql_Changwat = "Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = 'Aumpur' ".$conn2;
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					if($value[809]==$rd['ccDigi'])
					{
						echo '<option selected value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
					else
					{
						echo '<option  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
				}
		}
			 ?>
            </select>
            </LABEL>
          
           <!--<input type="text" value="" name="tDistrict"/>--></td>
          
          <td align="left" style="width: 85px;">ตำบล/แขวง <span class="style1"> *</span></td>
          <td><!--<input type="text" value=""  name="tParish"/>-->
          <LABEL id="lblTambon2">
          <select id="v808" name="v808" style="width:100%">
          <option value="">โปรดระบุ</option>
          <?php
				if($value[809]!=''){
				$sql_Changwat = "Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = 'Tamboon' ".$conn2;
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					if($value[808]==$rd['ccDigi'])
					{
						echo '<option selected value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
					else
					{
						echo '<option  value="'.$rd['ccDigi'].'">'.$rd['ccName'].'</option>';
					}
				}
		  }
			 ?>
          </select>
          </LABEL></td>
		  <td align="left" style="width: 85px;">รหัสไปรษณีย์</td>
          <td><input type="text" value="<?php echo $value[407]; ?>"  name="v407" style="width:30%" id="v407" onkeypress='return numonly()' maxlength="5"/></td>
        </tr>
        <tr>
         
          
          
		  <td align="left">โทรศัพท์</td>
          <td><input type="text" value="<?php echo $value[811]; ?>"  name="v811" style="width:90%" id="v811"/></td>
		  <td align="left" style="height: 60px;width: 90px;">โทรศัพท์มือถือ</td>
          <td><input type="text" value="<?php echo $value[411]; ?>"  name="v411" style="width:90%" id="v411"/></td>
          </tr>
		 
      </table>
      
      </td>
      </tr>
    <!--tr>
      <td height="25" align="right"></td>
      <td height="25" colspan="2">เพศ <span class="style1">*</span>
      <LABEL id="lblPreName">
      	<input name="v12" type="radio"  class="v12" id="female"  value="1" <?php echo 'checked'; ?> readonly/>หญิง&nbsp;
      	<input type="radio"  value="2" class="v12" name="v12"  id="male" style="display:none;"/>
		<INPUT name="chkSex" type="hidden" id="chkSex" value="1" size="30" />
	</LABEL>
</td>
      <td align="center">&nbsp;</td>
      </tr>
    
    <tr>
      <td height="25" align="right"></td>
      <td height="25" colspan="2">รายได้ต่อปี <span class="style1">*</span><input name="v36" type="text" value="<?php echo $value[36]; ?>" size="10" id="tIncome" class="numberOnly" /></td></td>
      <td align="center">&nbsp;</td>
    </tr-->
    <tr>
    	<td height="25" ><input type="hidden" name="v12" value="1"></td>
        <?php
			$check1 = ''; 
			$disable_before='';
			if( $value[907] == '1' ){
				$check1 = ' checked="checked" '; 
			}else{
				$disable_before="disabled";
				$disable_before2=" class='disable_form'";
			}
		?>
        <td align="left" width="20"><input type="radio" name="v907" id="v907" value="1" <?php echo $check1;?>/></td>
        <td align="left" colspan="2">ลงทะเบียนระหว่างตั้งครรภ์</td>
    </tr>
    <tr>
    	<td height="25" ></td>
        <td align="left" width="20"></td>
        <td align="left" colspan="2">
        	อายุครรภ์&nbsp;<!--input type="text" name="v901" id="v901" value="<?php echo $value[901];?>" style="width:30px;"/-->
			<select name="v901" id="v901" onchange="date_born();month_should_born();" <?php echo $disable_before.$disable_before2;?>>
				<?php for($i=0;$i<=42;$i++){ ?>
					<option value="<?php echo $i; ?>" <?php if($i==$value[901]){echo "selected";} ?>><?php echo $i; ?></option>
				<?php } ?>
			</select>
			&nbsp;สัปดาห์&nbsp;&nbsp;
			<?php $monthNames = array('','มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม')?>
        	กำหนดคลอดบุตร&nbsp;เดือน&nbsp;
			<select id="v902" name="v902" onchange="count_month_born()" <?php echo $disable_before.$disable_before2;?>>
				<option value="">เลือกเดือน</option>
				<?php for($i=1;$i<count($monthNames);$i++){ ?>
				<option value="<?php echo $i; ?>" <?php if($i==$value[902]){echo 'selected';}?>><?php echo $monthNames[$i];?></option>
				<?php } ?>
			</select>
			&nbsp;
            ปี&nbsp;พ.ศ.&nbsp;<!--input type="text" name="v903" id="v903" value="<?php echo $value[903];?>" style="width:50px;"/-->
			<select name="v903" id="v903" onchange="count_month_born()" <?php echo $disable_before.$disable_before2;?>>
				<?php 
					$sql_config2="SELECT value FROM tbl_dr01_config WHERE config_id in (2,3)";
					$rs2 = mysql_db_query(DB_MASTER,$sql_config2);
					$j=1;
					$year=array();
					while($result2=mysql_fetch_assoc($rs2)){
						$year[$j] = $result2['value'];
						$j++;
					}
					$startYear = $year['1'];
					$endYaer = $year['2'];
					for($i=$startYear;$i<=$endYaer;$i++){?>
						<option value="<?php echo $i;?>" <?php if($i==$value[903]){echo 'selected';} ?>><?php echo $i;?></option>
					<?php 
					}
				?>
			</select>
        </td>
    </tr>
     <tr>
    	<td height="25" ></td>
        <td align="left" width="20"></td>
        <td align="left" colspan="2">
			จำนวนบุตรในครรภ์&nbsp;<!--input type="text" name="v415" id="v415" value="<?php echo $value[415];?>" style="width:100px;"-->
			<select name="v415" id="v415" <?php echo $disable_before.$disable_before2;?>>
				<?php 
					$sql_config1="SELECT value FROM tbl_dr01_config WHERE config_id = '1'";
					$rs = mysql_db_query(DB_MASTER,$sql_config1);
					$result=mysql_fetch_assoc($rs);
					for($i=1;$i<=$result['value'];$i++){?>
						<option value="<?php echo $i;?>" <?php if($i==$value[415]){echo 'selected';} ?>><?php echo $i;?></option>
					<?php 
					}
				?>
			</select>
			&nbsp;คน&nbsp;
        	สถานที่ฝากครรภ์&nbsp;<input type="text" name="v904" id="v904" <?php echo $disable_before;?> value="<?php echo $value[904];?>" style="width:450px;"/>
        </td>
    </tr>
     <tr>
    	<td height="25" ></td>
        <?php
			$check2 = ''; 
			$disable_after="";
			if( $value[908] == '1' ){
				$check2 = ' checked="checked" '; 
			}else{
				$disable_after="disabled";
			}
		?>
        <td align="left" width="20"><input type="radio" name="v908" id="v908" value="1" <?php echo $check2;?>/></td>
        <?php
			/*$para3 = array(
				'dateFormat' => 'dd/mm/yy',
				'inputname' => 'v905',
				'showicon' => false,
				'showOtherMonths' => true,
				'showButton' => false,
				'showchangeMonth' => true,
				'numberOfMonths' => 1,
				'format' => 'tis-620',
				'value' => $value[905],
				'showWeek' => false);	
			 $result3 = $ws_client->call('calendar', $para3);//วันออกบัตร*/
		?>
        <td align="left" colspan="2">ลงทะเบียนหลังคลอด&nbsp;วัน/เดือน/ปี&nbsp;เกิดของเด็ก&nbsp;<input 	type="text" <?php echo $disable_after;?>
											class="datepick" 
											name="v905" 
                                            id = "v905" 
											value="<?php if(change_date_format($value[905])=="/543/543" || change_date_format($value[905])=="//543"){	
													echo "";
											}else{
												echo (change_date_format($value[905]));
											}
											?>"
											onChange="cal_join_date()"
											 >
											
			&nbsp;อายุ&nbsp;
			<span id="show_age2"><?php echo $value[906];?></span>
			<input type="hidden" name="v906" id="v906" <?php echo $disable_after;?> value="<?php echo $value[906];?>" style="width:30px;"/>&nbsp;เดือน</td>
    </tr>
	<tr>
		<td height="25" align="right"></td>
		<td height="25" colspan="2" valign="middle">
		<?php 
			if($value[417]=='3'){
				$m_status3 = 'checked';
			}else if($value[417]=='2'){
				$m_status2 = 'checked';
			}else{
				$m_status1 = 'checked';
			}
		?>
			<input name="v417" type="radio" class="v417" id="v417_1" value="1" <?php echo $m_status1; ?>> มารดายังมีชีวิตอยู่
			<input name="v417" type="radio" class="v417" id="v417_2" value="2" <?php echo $m_status2; ?>> มารดาเสียชีวิต
			<input name="v417" type="radio" class="v417" id="v417_3" value="3" <?php echo $m_status3; ?>> มารดาเป็นบุคคลต่างด้าว
			<input name="v417" type="radio" class="v417" id="v417_4" value="4" <?php echo $m_status3; ?>> มารดาไม่มีสถานะทางทะเบียนราษฎร์
			<input type="hidden" id="chk_m_status" value="<?php echo $value[417]; ?>">
		</td>
      </tr>
	<tr class="father_data">
   	  <td colspan="3" align="left"><mark><b>ข้อมูลบิดาของเด็ก</b> </mark>(กรณีมารดาเด็กเป็นบุคคลต่างด้าว หรือเป็นบุคคลไร้สถานะทางทะเบียนราษฎร์ หรือเสียชีวิต อนุโลมให้บิดาของเด็กตามสูติบัตรผู้มีคุณสมบัติซึ่งมีสัญชาติไทย ลงทะเบียนแทน)</td>
   	  <td width="246">
      </td>
    </tr>
	<tr class="father_data">
    	<td height="25" ></td>
        <td align="left" colspan="3">ชื่อ(นาย) <span class="style1"> *</span><input type="text" name="v412" id="v412" value="<?php echo $value[412];?>" onkeypress='return chaonly()'> นามสกุล <span class="style1"> *</span><input type="text" name="v413" id="v413" value="<?php echo $value[413];?>" onkeypress='return chaonly()'></td>
    </tr>
	<tr class="father_data">
    	<td height="25" ></td>
        <td align="left" colspan="3">เลขประจำตัวประชาชน <span class="style1"> *</span><input type="text" name="v414" id="v414" value="<?php echo $value[414];?>" onKeyPress="CheckNum()"> &nbsp;<!--span  id="idClassCheck2" class="bIdCard">ตรวจสอบ</span--> <!--<span  id="random3" class="bIdCard">สุ่มเลขบัตร</span><span id="showLabel2"></span>--></td>
    </tr>
	<tr class="father_data">
    	<td height="25" ></td>
        <td align="left" colspan="3">
			สถานะประกันสังคม 
			<select id="v420" name="v420" style="width:150px;">
				<option value="">--- ระบุ ---</option>
				<option value="1" <?php echo ($value[420]=='1'?'selected':'') ?>>เป็นผู้ประกันตน</option>
				<option value="0" <?php echo ($value[420]=='0'?'selected':'') ?>>ไม่ได้เป็นผู้ประกันตน</option>
			</select>
			<div id="testData2" style="display:none;"></div>
		</td>
    </tr>
	<tr class="father_data">
	<td height="25" ></td>
		<td align="left" colspan="3">หมายเลขโทรศัพท์ที่สามารถติดต่อได้ <input type="text" value="<?php echo $value[418]; ?>"  name="v418" id="v418"/></td>
          
		</tr>
    <tr>
   	  <td colspan="3" align="left"><b>ยื่นเอกสารหลักฐานประกอบการลงทะเบียน ดังนี้</b></td>
   	  <td width="246">
      </td>
    </tr>
	<tr>
    	<td height="25" ></td>
        <?php
			$check3 = ''; 
			if( $value[910] == '1' ){
				$check3 = ' checked="checked" '; 
			}
		?>
        <td align="left" width="20"><input type="checkbox" name="v910" id="v910" value="1" <?php echo $check3;?>/></td>
        <td align="left" colspan="2">แบบรับรองสถานะของครัวเรือน (ดร.02)</td>
    </tr>
    <tr>
    	<td height="25" ></td>
        <?php
			$check3 = ''; 
			if( $value[911] == '1' ){
				$check3 = ' checked="checked" '; 
			}
		?>
        <td align="left" width="20"><input type="checkbox" name="v911" id="v911" value="1" <?php echo $check3;?>/></td>
        <td align="left" colspan="2">สำเนาบัตรประชาชนของหญิงตั้งครรภ์/มารดา</td>
    </tr>
	<tr>
    	<td height="25" ></td>
         <?php
			$check3 = ''; 
			if( $value[914] == '1' ){
				$check3 = ' checked="checked" '; 
			}
		?>
        <td align="left" width="20"><input type="checkbox" name="v914" id="v914" value="1" <?php echo $check3;?>/></td>
        <td align="left" colspan="2">สำเนาบัตรประจำตัวประชาชนของบิดาเด็ก (กรณีลงทะเบียนแทน)</td>
    </tr>
    <tr>
    	<td height="25" ></td>
         <?php
			$check3 = ''; 
			if( $value[912] == '1' ){
				$check3 = ' checked="checked" '; 
			}
		?>
        <td align="left" width="20"><input type="checkbox" name="v912" id="v912" value="1" <?php echo $check3;?>/></td>
        <td align="left" colspan="2">สำเนาเอกสารการฝากครรภ์หรือสมุดบันทึกสุขภาพแม่และเด็กมาแสดง(เจ้าหน้าที่บันทึกสถานที่ฝากครรภ์และกำหนดคลอด)</td>
    </tr>
    <tr>
    	<td height="25" ></td>
         <?php
			$check3 = ''; 
			if( $value[913] == '1' ){
				$check3 = ' checked="checked" '; 
			}
		?>
        <td align="left" width="20"><input type="checkbox" name="v913" id="v913" value="1" <?php echo $check3;?>/></td>
        <td align="left" colspan="2">สำเนาสูติบัตรเด็ก 1 ฉบับ (ยื่นหลังจากคลอดบุตรแล้ว)</td>
    </tr>
	<tr>
    	<td height="25" ></td>
         <?php
			$check3 = ''; 
			if( $value[915] == '1' ){
				$check3 = ' checked="checked" '; 
			}
		?>
        <td align="left" width="20"><input type="checkbox" name="v915" id="v915" value="1" <?php echo $check3;?>/></td>
        <td align="left" colspan="2">สำเนาเอกสารยืนยันสถานะของมารดาเด็กแล้วแต่กรณี ที่ออกให้โดยหน่วยงานของรัฐ(กรณีมารดาเด็กเป็นบุคคลต่างด้าว<br>หรือเป็นบุคคลไร้สถานะทางทะเบียนราษฎร์ หรือเสียชีวิต อนุโลมให้บิดาของเด็กตามสูติบัตรผู้มีคุณสมบัติซึ่งมีสัญชาติไทยลงทะเบียนแทน)</td>
    </tr>
    <tr>
   	  <td colspan="3" align="left"><b>ข้าพเจ้ามีความประสงค์จะขอรับเงิน(เลือกเพียงข้อเดียว)ดังนี้</b></td>
   	  <td width="246">
      </td>
    </tr>
	<tr>
    	<td height="25" ></td>
         <?php
			$check3 = ''; 
			if( $value[917] == '1' ){
				$check3 = ' checked="checked" '; 
			}
		?>
        <td align="left" width="20"><input type="radio" name="v917" id="v917" value="1" <?php echo $check3;?>/></td>
        <td align="left" colspan="2">รับเงินด้วยตนเอง ณ กรมกิจการเด็กและเยาวชน หรือ สำนักงานพัฒนาสังคมและความมั่นคงของมนุษย์จังหวัด</td>
    </tr>
    <tr>
    	<td height="25" ></td>
		<?php
			$check3 = '';
			$disabled = 'disabled';
			if( $value[916] == '1' ){
				$check3 = ' checked="checked" ';
				$disabled = '';
			}
		?>
		<td align="left" width="20"><input type="radio" name="v916" id="v916" value="1" <?php echo $check3;?>/></td>
        <td align="left" colspan="2">รับเงินผ่านธนาคารกรุงไทย เลขที่บัญชี&nbsp;<input type="text" name="v921" id="v921" <?php echo $disabled;?> value="<?php echo $value[921];?>"/>สาขา&nbsp;<input type="text" name="v925" id="v925" <?php echo $disabled;?> value="<?php echo $value[925];?>"  style="width:200px;"/></td>
    </tr>
    <tr>
    	<td height="25" ></td>
		<td height="20" ></td>
        <td align="left" colspan="2">ชื่อบัญชี&nbsp;<input type="text" name="v922" id="v922" <?php echo $disabled;?> value="<?php echo $value[922];?>"  style="width:200px;"/>&nbsp;ประเภทบัญชี&nbsp;<input type="text" name="v923" id="v923" <?php echo $disabled;?> value="<?php echo $value[923];?>"  style="width:200px;"/></td>
    </tr>
	<?php
			$check_app = ''; 
			if( $value[0] == '1' ){
				$check_app = ' checked="checked" '; 
			}
		?>
    <tr>
    	<td height="25" ></td>
        <td align="left" width="20" valign="top"><input type="checkbox" name="dataApprove" id="dataApprove" value="1" <?php echo $check_app;?>/></td>
        <td align="left" colspan="2"><b>ข้าพเจ้าขอรับรองว่าข้อความและเอกสารที่ได้ยื่นนี้เป็นความจริงทุกประการ และเป็นผู้อยู่ในครัวเรือนยากจนและครัวเรือนที่เสี่ยงต่อความยากจนที่มีรายได้เฉลี่ยต่ำกว่า 3,000 บาท ต่อคน ต่อเดือน หรือต่ำกว่า 36,000 บาท ต่อคน ต่อปีและไม่เป็นผู้ได้รับสิทธิ์เงินสงเคราะห์บุตรจากกองทุนประกันสังคม หรือสวัสดิการข้าราชการหรือรัฐวิสาหกิจ และไม่อยู่ในความดูแลของหน่วยงานของรัฐ เช่น บ้านพักเด็กและครอบครัว หรือสถานสงเคราะห์ของรัฐ รวมทั้งข้าพเจ้าไม่เคยได้รับเงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิดรายนี้มาก่อน หากข้อความและเอกสารที่ยื่นเรื่องนี้เป็นเท็จ ข้าพเจ้ายินยอมให้ดำเนินการตามกฏหมาย ในการนี้ ข้าพเจ้ายินดีรับข้อมูลข่าวสารเพื่อส่งเสริมสุขภาพของแม่และเด็ก ผ่านช่องทางต่างๆ</b></td>
    </tr>
    
</form>
	<tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="2" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<tr>
      <td align="left" colspan="4" style="border-bottom:1px dotted #000"></td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="2" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
		<input type="hidden" name="v416" id="v416" value="<?php echo $value[416];?>">
		<input type="hidden" name="eq_id" id="eq_id" value="<?php echo $results['0']['eq_id'];?>">
		<input type="hidden" name="eq_idcard_status" id="eq_idcard_status" value="0">
		<input type="hidden" name="preg_day" id="preg_day" value="<?php echo date('m/d/Y');?>">
		<input type="hidden" name="monthPreg" id="monthPreg" value="">
		<input type="hidden" name="shouldBorn" id="shouldBorn" value="">
		<input type="hidden" name="form_status" id="form_status" value="1">
     <?php
			if( $from == 'edit' ){
		?>
    <tr height="50px;">
     <td colspan="4" align="right" valign="middle"><input type="submit" style="cursor:pointer; width:100px; height:30px;" value="บันทึก">
	  <input type="button" style="cursor:pointer; width:100px; height:30px;" onclick="javascript:location.href='<?php echo $_SESSION['session_mainfile'] ?>'" value="ยกเลิก">
      </tr>
      <?php
			}else{
	?>
    	<tr height="50px;">
		<input type="hidden" name="v416" id="v416" value="0">
          	<td colspan="4" align="right" valign="middle"><input type="submit" style="cursor:pointer; width:100px; height:30px;" value="บันทึก">
			<input type="button" style="cursor:pointer; width:100px; height:30px;" onclick="javascript:location.href='dashboard.php'" value="ยกเลิก"></td>
         </tr>
    <?php
			}
		?>
		
		
	
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="2" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="2" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td colspan="2" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
</tbody>
</table>
</div>
<div class="tab-pane" id="part_2">
<table>
  <tbody><tr>
    	<td align="left" style="margin-right: %;width: 1118px;"><b><u>ส่วนที่ 2</u> ข้อมูลเด็กแรกเกิด</b>&nbsp;</td>
    <td>
      <img src="../../images_sys/plus.gif" align="absmiddle" onclick="popup('<?php echo $_GET['id'];?>','main/dr_doc1_part2.php?from=add&eq_id=<?php echo $row['eq_id']; ?>')" style="cursor:pointer;" title="เพิ่มข้อมูลการเกิดของเด็ก">
    </td>
    </tr>
 </tbody></table>
<table align="center" style="margin-right: 50%;">
    <!--<tr>
    	<td align="left"><b><u>ส่วนที่ 2</u> สำหรับเจ้าหน้าที่เป็นผู้บันทึก</b>&nbsp;<img src="../../images_sys/plus.gif" align="absmiddle" onclick="popup('<?php echo $_GET['id'];?>','main/dr_doc1_part2.php?from=add')" style="cursor:pointer;" title="เพิ่มข้อมูลการเกิดของเด็ก"/></td>
    </tr>-->
     <tr>
	<td colspan="4">
        <table border="0" cellpadding="0" cellspacing="1" id="ppDriverTable" class="order-list" width="200%">
        <thead>
            <tr>
                <th width="28" height="24" ><strong>ลำดับ</strong></th>
                <th width="115" height="24" >เลขประจำตัวประชาชน</th>
                <th width="233" height="24" >ชื่อ-สกุล</th>
                <th width="73" height="24" >อายุ(เดือน)</th>
                <!--<th width="90" >ความสัมพันธ์</th> -->
                <th width="55" height="24" >เครื่องมือ</th>
          </tr>
        </thead>
        <tbody>
        <?php
			$i = 0;
			$sql = "select eqc_id, eq_id,eq_type,eq_idcard,eq_prename,eq_firstname,eq_lastname,eq_age,eq_education,eq_relation from ".DB_DATA.".eq_child where eq_id = '".$_GET['eq_id']."'";
			//echo $sql;
			$tbl2 = $con->select($sql);
			foreach($tbl2 as $row){
				$i++;
		?>
            <tr>
                <td height="50" align="center" valign="top"><?php echo $i; ?></td>
                <td height="50" align="center" valign="top"><?php /*?><a id="show" href="form2/show.php?id=<?php echo $row['eq_idcard']; ?>"><?php */?><?php echo $row['eq_idcard']; ?><!--</a>--></td>
                <td height="50" align="left" valign="top">
               <?php echo $row['eq_prename']; ?><?php echo $row['eq_firstname']; ?> <?php echo $row['eq_lastname']; ?></td>
                <td height="50" align="center" valign="top"><?php echo $row['eq_age']; ?></td>
               <!-- <td height="50" align="center" valign="top"><?php echo $row['eq_relation']; ?></td> -->
                <td height="50" align="center" valign="top"><a href="../rev_supp/index.php?p=dashboard_dr03&child_eq_id=<?php echo $row['eqc_id'];?>&mother_eq_id=<?php echo $row['eq_id']; ?>"><span style="cursor:pointer; text-decoration:underline;"; ><img src="../img/icon_bill.png" width="16" height="16" border="0" title="เพิ่มข้อมูลการรับเงินอุดหนุน"></span></a>&nbsp;&nbsp;<span style="cursor:pointer; text-decoration:underline;" onclick="popup('<?php echo $_GET['id'];?>','main/dr_doc1_part2.php?from=edit&eqc_id=<?php echo $row['eqc_id']; ?>&eq_id=<?php echo $_GET['eq_id'];?>' )"><img src="../img/b_edit.png" width="16" height="16" border="0" title="แก้ไขข้อมูล"></span>&nbsp;&nbsp;<a id="del" href="main_exc/dr_doc1_del_exc.php?eqc_id=<?php echo $row['eqc_id']; ?>&eq_id=<?php echo $row['eq_id']; ?>&mother_id=<?php echo $_GET['id'];?>" OnClick="return chkdel();"><img src="../img/b_drop.png" width="16" height="16" border="0" title="ลบข้อมูล"></a></td>
          </tr>
         <?php
			}
		 ?>
        </tbody>
        </table>
        
      </td>
  </tr>
     </table>
	 </div>
	 </div>
	 </div>
	 </div>
<div id="div-container">
</div>
<iframe id="iframe-popup" src="">
</iframe>
<script src="../js/CheckIdCardThai.min.js"></script>
<script src="../js/AgeCalculate.min.js"></script>
<script type="text/javascript">

function changeTambol(){

var b = $('#v8').val();
    if(b!=''){
$('#hide_add').html('<input type="checkbox" name="sl_adress" id="sl_address" value="1" onclick="CheckAddress_Now()">');
}else{
$('#hide_add').html('<input type="checkbox" name="sl_adress" id="sl_address" value="1" onclick="CheckAddress_Now()" disabled>');
}
}

function CheckAddress_Now(){
var a = $('#sl_address').is(':checked');
if(a==false){
$('#v805').val('');
$('#v806').val('');
$('#tuk2').val('');
$('#chan2').val('');
$('#number_home2').val('');
$('#village_2').val('');
$('#v813').val('');
$('#v807').val('');
$('#v407').val('');
$('#v811').val('');
$('#v411').val('');
$('#v810 option').each(function() {
    if($(this).val() == '') {
        $(this).prop("selected", true);
    }
});
$('#v809 option').each(function() {
    if($(this).val() == '') {
        $(this).prop("selected", true);
    }
});
$('#v808 option').each(function() {
    if($(this).val() == '') {
        $(this).prop("selected", true);
    }
});
}else{
var v5 = $('#v5').val();
$('#v805').val(v5);
var v6 = $('#v6').val();
$('#v806').val(v6);
var tuk1 = $('#tuk1').val();
$('#tuk2').val(tuk1);
var chan1 = $('#chan1').val();
$('#chan2').val(chan1);
var number_home1 = $('#number_home1').val();
$('#number_home2').val(number_home1);
var v814 = $('#v814').val();
$('#village_2').val(v814);
var v13 = $('#v13').val();
$('#v813').val(v13);
var v7 = $('#v7').val();
$('#v807').val(v7);
var v406 = $('#v406').val();
$('#v407').val(v406);
var v11 = $('#v11').val();
$('#v811').val(v11);
var v410 = $('#v410').val();
$('#v411').val(v410);
var v10 = $('#v10').val();
$('#v810 option').each(function() {
    if($(this).val() == v10) {
        $(this).prop("selected", true);
    }
	chgAmphur2(v10);
});
var v9 = $('#v9').val();
setTimeout(function() { $('#v809 option').each(function() {
    if($(this).val() == v9) {
        $(this).prop("selected", true);
    }
	chgTambon2(v9, undefined);
}); }, 2000);
var v8 = $('#v8').val();
setTimeout(function() { $('#v808 option').each(function() {
    if($(this).val() == v8) {
        $(this).prop("selected", true);
    }
}); }, 4000);
}
}
</script>
<script  type="text/javascript">


$(document).ready(function () {	

<?php
if(isset($_GET['id']))
{
?>
/*Start ตรวจสอบ enable*/
if($('.Sexcheck input:not(#etc_1)').is(':checked') == true){
	$("#tSex").attr('disabled','disabled');
}

/*if(document.getElementById('rTypeHome_2').checked == true){
//$("#v16").attr('disabled','disabled');
$('#v16').removeAttr('disabled');
$("#v17").attr('disabled','disabled');

	}
if(document.getElementById('rTypeHome_4').checked == true){
$('#v17').removeAttr('disabled');
$("#v16").attr('disabled','disabled');
	}*/

if($('.careertable input:not(#cCareer10)').is(':checked') == false){
	$('#tCareer').removeAttr('disabled');
}

if($("#Land_2").attr('checked')){
	$("#tLand").attr('disabled','disabled');
}

if($('.tablereligion input:not(#rReligion_4)').is(':checked') == true){
$("#tReligion_1").attr('disabled','disabled');
}

if($('.statustable input:not(#rStatus_5)').is(':checked') == true){
	$(".rStatus_detail").hide();
}

if($('.defective input:not(#rDefective_2)').is(':checked') == true){
	$('#t16_detail').hide();
}

if($('.stuctable input:not(#rStructureFamily)').is(':checked') == true){
	$("#tMemberMale_1,#tMemberFemale_1").attr('disabled','disabled');
}

if($('.stuctable input:not(#rLargeFamily)').is(':checked') == true){
$(".r15_2").hide();
	}
	if($('.stuctable input:not(#rSpecialFamily)').is(':checked') == true){	
$(".r15_3").hide();
	}
	if($('.r15_2 input:not(#rLargeFamily_21)').is(':checked') == true){	
$("#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
	}
	if($('.r15_2 input:not(#rLargeFamily_22)').is(':checked') == true){	
$("#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
	}
	
if($('#rDebt_1').is(':checked') == true){
		$('#t18_a').hide();
		$('#t18_b').hide();
		$('.t18').hide();
	}
	
 if($('#rDebt_a').is(':checked') == true){
	 $('.t18_b').hide();
	  $('.t18_a').show();
 }
 if($('#rDebt_b').is(':checked') == true){
	 $('.t18_a').hide();
	  $('.t18_b').show();
 }
 
 if($('#2_2_1').attr('checked')){
		$('#t18_2_1_1').show();
	}
	else{
		$('#t18_2_1_1').hide();
	}
	
if($('#2_2_2').attr('checked')){
		$('#t18_2_1_2').show();
	}
	else{
		$('#t18_2_1_2').hide();
	}
	
if($('#2_2_3').attr('checked')){
		$('#t18_2_1_3').show();
	}
	else{
		$('#t18_2_1_3').hide();
	}
	
if($('#2_2_4').attr('checked')){
		$('#t18_2_1_4').show();
	}
	else{
		$('#t18_2_1_4').hide();
	}

if($('#2_2_5').attr('checked')){
		$('#t18_2_1_5').show();
	}
	else{
		$('#t18_2_1_5').hide();
	}
	
if($('#2_2_6').attr('checked')){
		$('#t18_2_1_6').show();
	}
	else{
		$('#t18_2_1_6').hide();
	}

if($('#2_2_7').attr('checked')){
		$('#t18_2_1_7').show();
	}
	else{
		$('#t18_2_1_7').hide();
	}
	
if($('#2_2_8').attr('checked')){
		$('#t18_2_1_8').show();
	}
	else{
		$('#t18_2_1_8').hide();
	}
	
if($('#2_2_9').attr('checked')){
		$('#t18_2_1_9').show();
	}
	else{
		$('#t18_2_1_9').hide();
	}
	
if($('#2_2_9').attr('checked')){
		$('#t21_other').removeAttr('disabled');
	}
	else{
		$('#t21_other').attr('disabled','disabled');
	}
/*End ตรวจสอบ enable*/
<?php
	}
else
{
?>
$("#tSex").attr('disabled','disabled');	
$("#v16").attr('disabled','disabled');
$("#v17").attr('disabled','disabled');
//$("#tCareer").attr('disabled','disabled');
$("#tLand").attr('disabled','disabled');
$("#tReligion_1").attr('disabled','disabled');
/*$("#tMemberFamily_1,#tMemberMale_1,#tMemberFemale_1").attr('disabled','disabled');*/
$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
$("#tSpecialFamily_3").attr('disabled','disabled');
//ซ่อนฟอร์มการกู้เงินในระบบ
$('#t18_2_1_1').hide();
$('#t18_2_1_2').hide();
$('#t18_2_1_3').hide();
$('#t18_2_1_4').hide();
$('#t18_2_1_5').hide();
$('#t18_2_1_6').hide();
$('#t18_2_1_7').hide();
$('#t18_2_1_8').hide();
$('#t18_2_1_9').hide();

/*--------------------- 14 */
$(".rStatus_detail").hide();

/*--------------------- 15 */
$("#rLargeFamily_21,#rLargeFamily_22").attr('disabled','disabled');
$("#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").attr('disabled','disabled');
$(".r15_2").hide();
$(".r15_3").hide();

/*--------------------- 16 */
$('#t16_detail').hide();

/*--------------------- 18 */
//$('.t18').hide();
//$('#t18_a,#t18_b').hide();
//$('#t18_2_1_1,#t18_2_1_2,#t18_2_1_3,#t18_2_1_4,#t18_2_1_5,#t18_2_1_6,#t18_2_1_7,#t18_2_1_8,#t18_2_1_9').hide();

<?php
}
?>

/*----------------------------------------------------------- เชคบัตรประชาชน*/
 $('#v3').change(function() {
	var result = $('#v3').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
		if($.trim($('#v3').val()) != ''){
			$('#showLabel1').append('<img src="img/connect.gif" height="13">');
			$.ajax({
				method : "GET",
				url: "ajax.sso_check.php",
				data: { pid: $('#v3').val()}
			}).done(function( msg ) {
				$('#testData1').text(msg); /* id ที่ดึงข้อมูลมาตรวจสอบ */
			});
		}
		$('#testData1').bind("DOMSubtreeModified",function(){
		if($.trim($('#testData1').text()) != ''){
			var str = $('#testData1').text();
			var n = str.indexOf('<td align="left">เป็นผู้ประกันตน</td>');
			if(n > 0){
				$('#v419').val('1');
				$('#showLabel1').text('');
			}else{
				$('#v419').val('0');
				$('#showLabel1').text('');
			}
		}
	});
	} else {
		alert('เลขบัตรประชาชนนี้ไม่ถูกต้อง');
	}
});

$('#random2').click(function() {
	//$('#v3').RandomIdCardThai({firstNum: '0'});
	var randomcard = 'ส'+Random(0,999999999999);
	$('#v3').val(randomcard);
	$('#v419').val('0');
 });
 $('#v414').change(function() {
	var result = $('#v414').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
		if($.trim($('#v414').val()) != ''){
			$('#showLabel2').append('<img src="img/connect.gif" height="13">');
			$.ajax({
				method : "GET",
				url: "ajax.sso_check.php",
				data: { pid: $('#v414').val()}
			}).done(function( msg ) {
				$('#testData2').text(msg); /* id ที่ดึงข้อมูลมาตรวจสอบ */
			});
		}
		$('#testData2').bind("DOMSubtreeModified",function(){
		if($.trim($('#testData2').text()) != ''){
			var str = $('#testData2').text();
			var n = str.indexOf('<td align="left">เป็นผู้ประกันตน</td>');
			if(n > 0){
				$('#v420').val('1');
				$('#showLabel2').text('');
			}else{
				$('#v420').val('0');
				$('#showLabel2').text('');
			}
		}
	});
	} else {
		alert('เลขบัตรประชาชนนี้ไม่ถูกต้อง');
	}
});

$('#random3').click(function() {
	//$('#v3').RandomIdCardThai({firstNum: '0'});
	var randomcard = 'ส'+Random(0,999999999999);
	$('#v414').val(randomcard);
	$('#v420').val('0');
 });
 
 $('#v917').click(function() {
	$('#v916').attr('checked',false);
	$('#v921').attr('disabled',true);
	$('#v922').attr('disabled',true);
	$('#v923').attr('disabled',true);
	$('#v925').attr('disabled',true);
 });
 
 $('#v916').click(function() {
	$('#v917').attr('checked',false);
	$('#v921').attr('disabled',false);
	$('#v922').attr('disabled',false);
	$('#v923').attr('disabled',false);
	$('#v925').attr('disabled',false);
 });
 
 $('#v907').click(function() {
	$('#v908').attr('checked',false);
	$('#v905').attr('disabled',true);
	$('#v906').attr('disabled',true);
	
	$('#v901').attr('disabled',false);
	$('#v901').removeClass('disable_form');
	$('#v901').addClass('enable_form');
	$('#v902').attr('disabled',false);
	$('#v902').removeClass('disable_form');
	$('#v902').addClass('enable_form');
	$('#v903').attr('disabled',false); 
	$('#v903').removeClass('disable_form');
	$('#v903').addClass('enable_form');
	$('#v415').attr('disabled',false);
	$('#v415').removeClass('disable_form');
	$('#v415').addClass('enable_form');
	$('#v904').attr('disabled',false);
 });
 
 $('#v908').click(function() {
	$('#v907').attr('checked',false);
	$('#v901').attr('disabled',true);
	$('#v901').removeClass('enable_form');
	$('#v901').addClass('disable_form');
	$('#v902').attr('disabled',true);
	$('#v902').removeClass('enable_form');
	$('#v902').addClass('disable_form');
	$('#v903').attr('disabled',true); 
	$('#v903').removeClass('enable_form');
	$('#v903').addClass('disable_form');
	$('#v415').attr('disabled',true);
	$('#v415').removeClass('enable_form');
	$('#v415').addClass('disable_form');
	$('#v904').attr('disabled',true);
	
	$('#v905').attr('disabled',false);
	$('#v906').attr('disabled',false);
 });
/*----------------------------------------------------------- ตรวจสอบตัวเลข*/
$(".numberOnly").keydown(function(e){
	if (e.shiftKey) 
           e.preventDefault();
       else 
       {
           var nKeyCode = e.keyCode;
           //Ignore Backspace and Tab keys
           if (nKeyCode == 8 || nKeyCode == 9)
               return;
           if (nKeyCode < 95) 
           {
               if (nKeyCode < 48 || nKeyCode > 57)
                   e.preventDefault();
           }
           else 
           {
               if (nKeyCode < 96 || nKeyCode > 105) 
               e.preventDefault();
           }
       }

});

/*----------------------------------------------------------- คำนวนเลขในข้อ 16 */
$("#t16_detail input").keyup(function (){
	var tChild = document.getElementById('tChild').value;
	var tDisabled = document.getElementById('tDisabled').value;
	var tMindSick = document.getElementById('tMindSick').value;
	var tSick = document.getElementById('tSick').value;
	var tElderly = document.getElementById('tElderly').value;
	
	if(tChild==''){tChild = 0;}
	if(tDisabled==''){tDisabled = 0;}
	if(tMindSick==''){tMindSick = 0;}
	if(tSick==''){tSick = 0;}
	if(tElderly==''){tElderly = 0;}

	var tDefective = parseInt(tChild)+parseInt(tDisabled)+parseInt(tMindSick)+parseInt(tSick)+parseInt(tElderly);
	$("#tDefective").val(tDefective);
});

/*----------------------------------------------------------- คำนวนเลขในข้อ 15 */
$("#t15_detail_1 input").keyup(function (){
	var tMemberMale_1 = document.getElementById('tMemberMale_1').value;
	var tMemberFemale_1 = document.getElementById('tMemberFemale_1').value;
	if(tMemberMale_1==''){tMemberMale_1 = 0;}
	if(tMemberFemale_1==''){tMemberFemale_1 = 0;}
	var tMemberFamily_1 = parseInt(tMemberMale_1)+parseInt(tMemberFemale_1);
	$("#tMemberFamily_1").val(tMemberFamily_1);
});

$("#t15_detail_2_1 input").keyup(function (){
	var tMemberMale_2_1 = document.getElementById('tMemberMale_2_1').value;
	var tMemberFemale_2_1 = document.getElementById('tMemberFemale_2_1').value;
	if(tMemberMale_2_1==''){tMemberMale_2_1 = 0;}
	if(tMemberFemale_2_1==''){tMemberFemale_2_1 = 0;}
	var tMemberFamily_2_1 = parseInt(tMemberMale_2_1)+parseInt(tMemberFemale_2_1);
	$("#tMemberFamily_2_1").val(tMemberFamily_2_1);
});

$("#t15_detail_2_2 input").keyup(function (){
	var tMemberMale_2_2 = document.getElementById('tMemberMale_2_2').value;
	var tMemberFemale_2_2 = document.getElementById('tMemberFemale_2_2').value;
	if(tMemberMale_2_2 ==''){tMemberMale_2_2 = 0;}
	if(tMemberFemale_2_2 ==''){tMemberFemale_2_2 = 0;}
	var tMemberFamily_2_2 = parseInt(tMemberMale_2_2)+parseInt(tMemberFemale_2_2);
	$("#tMemberFamily_2_2").val(tMemberFamily_2_2);
});



/*----------------------------------------------------------- คำนวนวันเกิด*/
$("#v377").change(function () {
	var result = calAge(document.getElementById('v377').value);
	document.getElementById('v14').value = result[0];
	$('#show_age').html(result[0]);
});


$("#v14").keyup(function() {
 var v14 = document.getElementById('v14').value ;
 var tv14 = <?php echo $dt = date('Y') + 543; ?> - v14 ;
 var showDate = "01/01/" + tv14 ;
 document.getElementById('v377').value = showDate;
 
});

//ส่วนของการตรวจสอบเงื่อนไขการDisabled 
//ตรวจสอบเงื่อนไขกลุ่มเพศ
$('.rSex').click(function(){
	$("#tSex").attr('disabled','disabled');
	document.getElementById('chkSex').value = 1;
});

$('#etc_1').click(function(){
	$("#tSex").removeAttr('disabled');
});

//ตรวจสอบเงื่อนไขกลุ่มที่อยู่อาศัย
/*$('#rTypeHome_1').click(function(){
	$("#v17").attr('disabled','disabled');
	$("#v16").attr('disabled','disabled');
});
$('#rTypeHome_3').click(function(){
	$("#v16").attr('disabled','disabled');
	$("#v17").attr('disabled','disabled');
});

$('#rTypeHome_2').click(function(){
	$("#v16").removeAttr('disabled');
	$("#v17").attr('disabled','disabled');
});
$('#rTypeHome_4').click(function(){
	$("#v17").removeAttr('disabled');
	$("#v16").attr('disabled','disabled');
});*/

//ตรวจสอบเงื่อนไขกลุ่มอาชีพ
$('#cCareer10').click(function(){
	if($('#tCareer').attr('disabled')){
		$('#tCareer').removeAttr('disabled')
	}else{
		$('#tCareer').attr('disabled','disabled')
	}
});
$('#cCareer4').click(function(){
	 if($('#cCareer5').attr('disabled')){
		$('#cCareer5,#cCareer6,#cCareer8').removeAttr('disabled')
	}else{
		$('#cCareer5,#cCareer6,#cCareer8').attr('disabled','disabled')
		$('#cCareer5,#cCareer6,#cCareer8').removeAttr('checked')
	}
});
$('#cCareer5').click(function(){
	 if($('#cCareer4').attr('disabled')){
		$('#cCareer4,#cCareer6,#cCareer8').removeAttr('disabled')
	}else{
		$('#cCareer4,#cCareer6,#cCareer8').attr('disabled','disabled')
		$('#cCareer4,#cCareer6,#cCareer8').removeAttr('checked')
	}
});
$('#cCareer6').click(function(){
	 if($('#cCareer4').attr('disabled')){
		$('#cCareer4,#cCareer5,#cCareer8').removeAttr('disabled')
	}else{
		$('#cCareer4,#cCareer5,#cCareer8').attr('disabled','disabled')
		$('#cCareer4,#cCareer5,#cCareer8').removeAttr('checked')
	}
});
$('#cCareer8').click(function(){
	 if($('#cCareer4').attr('disabled')){
		$('#cCareer4,#cCareer6,#cCareer5').removeAttr('disabled')
	}else{
		$('#cCareer4,#cCareer6,#cCareer5').attr('disabled','disabled')
		$('#cCareer4,#cCareer6,#cCareer5').removeAttr('checked')
	}
});

$('.careertable input:not(#cCareer9)').click(function(){
	if($('.careertable input:not(#cCareer9)').is(':checked') == true){
		$('#cCareer9').attr('disabled','disabled')
		$('#cCareer9').removeAttr('checked')
	}
	if($('.careertable input:not(#cCareer9)').is(':checked') == false){
		$('#cCareer9').removeAttr('disabled')
	}
});

$('#cCareer9').click(function(){
		 if($('.careertable input:not(#cCareer9)').attr('disabled')){ //ถ้าใช่
			$('.careertable input:not(#cCareer9,#tCareer)').removeAttr('disabled')
		 }else{
			$('.careertable input:not(#cCareer9)').attr('disabled','disabled')
			$('.careertable input:not(#cCareer9)').removeAttr('checked')
		}
		

});

//ตรวจสอบเงื่อนไขกลุ่มที่ดิน
$('.rLand_1').click(function(){
	$("#tLand").attr('disabled','disabled');
});

$('#rLand').click(function(){
	$("#tLand").removeAttr('disabled');
});
//ตรวจสอบเงื่อนไขกลุ่มศาสนา
$('.rReligion').click(function(){
	$("#tReligion_1").attr('disabled','disabled');
});
$('.rReligion_1').click(function(){
	$("#tReligion_1").removeAttr('disabled');
});

//ตรวจสอบเงื่อนไขสภานภาพสมรส
$('.rStatus').click(function(){
	$(".rStatus_detail").hide();
});

$('#rStatus_5').click(function(){
	$(".rStatus_detail").show();
});

//------------------------------------------------ 16
$('#rDefective_1').click(function(){
	$('#t16_detail').hide();
});

$('#rDefective_2').click(function(){
	$('#t16_detail').show();
});

//------------------------------------------------ 17
$("#t17 input").keyup(function () {
	
	var tChildMale = document.getElementById('tChildMale').value;
	var tChildFemale = document.getElementById('tChildFemale').value;
	if(tChildMale==''){tChildMale = 0;}
	if(tChildFemale==''){tChildFemale = 0;}
	var tChildTotal = parseInt(tChildMale)+parseInt(tChildFemale);
	 document.getElementById('tChildTotal').value = tChildTotal;
	//$("#tChildTotal").val(tChildTotal);
	
	var tTeensMale = document.getElementById('tTeensMale').value;
	var tTeensFemale = document.getElementById('tTeensFemale').value;
	if(tTeensMale==''){tTeensMale = 0;}
	if(tTeensFemale==''){tTeensFemale = 0;}
	var tTeensTotal = parseInt(tTeensMale)+parseInt(tTeensFemale);
	document.getElementById('tTeensTotal').value = tTeensTotal;
	//$("#tTeensTotal").val(tTeensTotal);
	
	var tMan = document.getElementById('tMan').value;
	var tWoman = document.getElementById('tWoman').value;
	if(tMan==''){tMan = 0;}
	if(tWoman==''){tWoman = 0;}
	var tTotal = parseInt(tMan)+parseInt(tWoman);
	document.getElementById('tTotal').value = tTotal;
	//$("#tTotal").val(tTotal);
	
	var tElderMale = document.getElementById('tElderMale').value;
	var tElderFemale = document.getElementById('tElderFemale').value;
	if(tElderMale==''){tElderMale = 0;}
	if(tElderFemale==''){tElderFemale = 0;}
	var tElderTotal = parseInt(tElderMale)+parseInt(tElderFemale);
	document.getElementById('tElderTotal').value = tElderTotal;
	//$("#tElderTotal").val(tElderTotal);
	
	var tDisabledMale = document.getElementById('tDisabledMale').value;
	var tDisabledFemale = document.getElementById('tDisabledFemale').value;
	if(tDisabledMale==''){tDisabledMale = 0;}
	if(tDisabledFemale==''){tDisabledFemale = 0;}
	var tDisabledTotal = parseInt(tDisabledMale)+parseInt(tDisabledFemale);
	document.getElementById('tDisabledTotal').value = tDisabledTotal;
	//$("#tDisabledTotal").val(tDisabledTotal);

	var tMaleTotal = parseInt(tChildMale)+parseInt(tTeensMale)+parseInt(tMan)+parseInt(tElderMale)+parseInt(tDisabledMale);
	var tFemaleTotal = parseInt(tChildFemale)+parseInt(tTeensFemale)+parseInt(tWoman)+parseInt(tElderFemale)+parseInt(tDisabledFemale);
	var tSumTotal = parseInt(tMaleTotal)+parseInt(tFemaleTotal);
	
	document.getElementById('tMaleTotal').value = tMaleTotal;
	document.getElementById('tFemaleTotal').value = tFemaleTotal;
	document.getElementById('tSumTotal').value = tSumTotal;
	//$("#tMaleTotal").val(tMaleTotal);
	//$("#tFemaleTotal").val(tFemaleTotal);
	//$("#tSumTotal").val(tSumTotal);
});

//เงื่อนไขกลุ่มครอบครัว
//////////////////////////ตรวจสอบเงื่อนไขกลุ่มครอบครัวเดี่ยว
$('.rStructureFamily').click(function(){
	$(					"#rLargeFamily_21,#rLargeFamily_22,#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").attr('disabled','disabled');
});
$('.rStructureFamily').click(function(){
	$("#tMemberFamily_1,#tMemberMale_1,#tMemberFemale_1").removeAttr('disabled');
});
$('.rStructureFamily').click(function(){
	$("#rLargeFamily_21,#rLargeFamily_22").removeAttr('checked');
});
$('.rStructureFamily').click(function(){
	$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
});

$('.rStructureFamily').click(function(){
	$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
});
$('.rStructureFamily').click(function(){
	$("#tSpecialFamily_3").attr('disabled','disabled');
});
$('.rStructureFamily').click(function(){
	$("#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").removeAttr('checked');
});

/////////////////////////////ตรวจสอบเงื่อนไขกลุ่มครอบครัวขยาย
$('.rLargeFamily').click(function(){
	$("#tMemberFamily_1,#tMemberMale_1,#tMemberFemale_1,#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").attr('disabled','disabled');
});

$('.rLargeFamily').click(function(){
	$("#rLargeFamily_21,#rLargeFamily_22").removeAttr('disabled');
});

$('.rLargeFamily_23').click(function(){
	$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").removeAttr('disabled');
});
$('.rLargeFamily_24').click(function(){
	$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").removeAttr('disabled');
});
$('.rLargeFamily_24').click(function(){
	$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
});
$('.rLargeFamily_23').click(function(){
	$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
});
$('.rLargeFamily').click(function(){
	$("#tSpecialFamily_3").attr('disabled','disabled');
});
$('.rLargeFamily').click(function(){
	$("#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").removeAttr('checked');
});

///////////////////////////////////ตรวจสอบเงื่อนไขปุ่มครอบครัวพิเศษ
$('.rSpecialFamily').click(function(){
	$("#rLargeFamily_21,#rLargeFamily_22,#tMemberFamily_1,#tMemberMale_1,#tMemberFemale_1").attr('disabled','disabled');
});
$('.rSpecialFamily').click(function(){
	$("#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5,#rSpecialFamily_6").removeAttr('disabled');	
});
$('.rSpecialFamily').click(function(){
	$("#rLargeFamily_21,#rLargeFamily_22").removeAttr('checked');
});
$('.rSpecialFamily').click(function(){
	$("#tMemberFamily_2_1,#tMemberMale_2_1,#tMemberFemale_2_1").attr('disabled','disabled');
});
$('.rSpecialFamily').click(function(){
	$("#tMemberFamily_2_2,#tMemberMale_2_2,#tMemberFemale_2_2").attr('disabled','disabled');
});
$('.rSpecialFamily_6').click(function(){
	$("#tSpecialFamily_3").removeAttr('disabled');
});
$('#rSpecialFamily_1,#rSpecialFamily_2,#rSpecialFamily_3,#rSpecialFamily_4,#rSpecialFamily_5').click(function(){
	$("#tSpecialFamily_3").attr('disabled','disabled');
});

/*------------------------------------ ตรวจสอบซ่อนข้อความ r15_2 r15_3 rStructureFamily rLargeFamily rSpecialFamily*/ 
$('#rStructureFamily').click(function(){
	$(".r15_2").hide();
	$(".r15_3").hide();
});

$('#rLargeFamily').click(function(){
	$(".r15_2").show();
	$(".r15_3").hide();
});

$('#rSpecialFamily').click(function(){
	$(".r15_2").hide();
	$(".r15_3").show();
});

//------------------------------------------------ 18 rDebt_1
/*	if($('#rDebt_1').is(':checked') == true){
		$('#t18_a').hide();
		$('#t18_b').hide();
		$('.t18').hide();
	}*/

$('#rDebt_1').click(function(){
	$('.t18').hide();
})

$('#rDebt_2').click(function(){
	$('.t18').show();
	//$('#rDebt_a').arr('checked',true);
	document.getElementById('rDebt_a').checked = true;
})

$('#rDebt_a').click(function(){
	$('#t18_a').show();
	$('#t18_b').hide();
})
$('#rDebt_b').click(function(){
	$('#t18_a').hide();//prop
	$('#t18_b').show();
})
//กู้เงินในระบบและนอกระบบ
/* if($('.t18 input:not(#rDebt_a)').is(':checked') == true){
	 $('.t21').hide();
 }
 if($('.t18 input:not(#rDebt_b)').is(':checked') == true){
	 $('.t22').hide();
 }*/
//เงินกู้ธนาคาร
$('#2_2_1').click(function(){
	if($('#2_2_1').attr('checked')){
		$('#t18_2_1_1').show();
	}
	else{
		$('#t18_2_1_1').hide();
	}
})
//เงินกู้กองทุนสัจจะสะสมทรัพย์
$('#2_2_2').click(function(){
	if($('#2_2_2').attr('checked')){
		$('#t18_2_1_2').show();
	}
	else{
		$('#t18_2_1_2').hide();
	}
})
//เงินกู้กองทุนหมู่บ้าน
$('#2_2_3').click(function(){
	if($('#2_2_3').attr('checked')){
		$('#t18_2_1_3').show();
	}
	else{
		$('#t18_2_1_3').hide();
	}
})
//กองทุนพัฒนาบทบาทสตรี
$('#2_2_4').click(function(){
	if($('#2_2_4').attr('checked')){
		$('#t18_2_1_4').show();
	}
	else{
		$('#t18_2_1_4').hide();
	}
})
//กองทุนผู้สูงอายุ
$('#2_2_5').click(function(){
	if($('#2_2_5').attr('checked')){
		$('#t18_2_1_5').show();
	}
	else{
		$('#t18_2_1_5').hide();
	}
})
//กองทุนส่งเสริมพัฒนาคุณภาพชีวิตคนพิการ
$('#2_2_6').click(function(){
	if($('#2_2_6').attr('checked')){
		$('#t18_2_1_6').show();
	}
	else{
		$('#t18_2_1_6').hide();
	}
})
//กองทุนปุ๋ย
$('#2_2_7').click(function(){
	if($('#2_2_7').attr('checked')){
		$('#t18_2_1_7').show();
	}
	else{
		$('#t18_2_1_7').hide();
	}
})
//กองทุนเกษตร
$('#2_2_8').click(function(){
	if($('#2_2_8').attr('checked')){
		$('#t18_2_1_8').show();
	}
	else{
		$('#t18_2_1_8').hide();
	}
})
//อื่นๆระบุ
$('#2_2_9').click(function(){
	if($('#2_2_9').attr('checked')){
		$('#t18_2_1_9').show();
	}
	else{
		$('#t18_2_1_9').hide();
	}
})
//ระบุกองทุนกู้ยืมอื่นๆ
$('#2_2_9').click(function(){
	if($('#2_2_9').attr('checked')){
		$('#t21_other').removeAttr('disabled');
	}
	else{
		$('#t21_other').attr('disabled','disabled');
	}
})
//ถ่ายรูป
	$('#takePhoto').click(function(){
		open_video();
		$('#video').show();
		$('#startbutton').show();
		$('#cancel_capture').show();
		$('#imgprvw').hide();
		$('#v378').hide();
		$('#takePhoto').hide();
	})
	$('#cancel_capture').click(function(){
		$('#video').hide();
		$('#photo').hide();
		$('#startbutton').hide();
		$('#cancel_capture').hide();
		$('#capture_again').hide();
		$('#imgprvw').show();
		$('#v378').show();
		$('#takePhoto').show();
	})
	$('#capture_again').click(function(){
		$('#video').show();
		$('#startbutton').show();
		$('#cancel_capture').show();
		$('#photo').hide();
	})
});

function open_video() {
  var streaming = false,
      video        = document.querySelector('#video'),
      canvas       = document.querySelector('#canvas'),
      photo        = document.querySelector('#photo'),
      startbutton  = document.querySelector('#startbutton'),
      width = 320,
      height = 240;
  navigator.getMedia = ( navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia);
  navigator.getMedia(
    {
      video: true,
      audio: false
    },
    function(stream) {
      if (navigator.mozGetUserMedia) {
        video.mozSrcObject = stream;
      } else {
        var vendorURL = window.URL || window.webkitURL;
        video.src = vendorURL.createObjectURL(stream);
      }
      video.play();
    },
    function(err) {
      console.log("An error occured! " + err);
    }
  );
  video.addEventListener('canplay', function(ev){
    if (!streaming) {
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height);
      streaming = true;
    }
  }, false);
  function takepicture() {
    canvas.width = width;
    canvas.height = height;
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    var data = canvas.toDataURL('image/png');
    photo.setAttribute('src', data);
	console.log('data : '+data);
	$('#lastPhoto').val(data);
	$('#video').hide();
	$('#photo').show();
	$('#capture_again').show();
  }
  startbutton.addEventListener('click', function(ev){
      takepicture();
    ev.preventDefault();
  }, false);
  
}
function cal_join_date(){
		var jdate=$('#sDay').val()+'/'+$('#sMonth').val()+'/'+$('#sYear').val();
		var bdate = $('#v905').val();
			link_page = 'main/ajax.cal_age.php?jdate='+jdate+'&bdate='+bdate;
			$.get(link_page, function(data){
				// alert(link_page);
				$('#show_age2').html(data);
				$('#v906').val(data);
			});
			//console.log(link_page);
	} 
</script> 
<script type="text/javascript">

	$(document).ready(function() {
		var datedatadb = '<?=$value[701];?>';
if(datedatadb!=''){
$( ".datepick1001" ).datepicker({
dateFormat: 'dd/mm/yy',
			isBuddhist: true,
			dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
			dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
			monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
			monthNamesShort: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
			showOtherMonths: true,
			selectOtherMonths: true,
			showButtonPanel: false,
			changeMonth: true,
			changeYear: true,
			showWeek: false,
			minDate:-<?=$days;?>,
	beforeShow: function(){    
    $(".ui-datepicker, select").css('font-size', 14) 
   }
    });
	}

		$('.datepick1000').change(function() {

			if ( $('.datepick1000') != '' ) {

				var date = $(this).datepicker('getDate');
		        var today = new Date();
		         var dayDiff = Math.ceil(((today - date) / (1000 * 60 * 60 * 24))-2);
		         $(".datepick1001").val('');
				event.preventDefault();
			}else{
				$('#errorTitle').hide('slow');
			}
		datedata(dayDiff);
		});
		$( ".datepick1001" ).keyup(function() {
  if($(".datepick1000").val()==""){
  	alert("กรุณาเลือกวันออกบัตร");
	$(".datepick1001").val('');
  }
});
		function datedata(value){
		  $( ".datepick1001" ).datepicker({
dateFormat: 'dd/mm/yy',
			isBuddhist: true,
			dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
			dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
			monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
			monthNamesShort: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
			showOtherMonths: true,
			selectOtherMonths: true,
			showButtonPanel: false,
			changeMonth: true,
			changeYear: true,
			showWeek: false,
			minDate:-value,
	beforeShow: function(){    
    $(".ui-datepicker, select").css('font-size', 14) 
   }
    });
}

	});
	
	function numonly() {
    
   if(  event.charCode >= 48 && event.charCode <= 57 || event.charCode == 47)
   {
   	return true;    
   }else{
   return false;  
   }
}

function chaonly() {
    
   if(  event.charCode >= 48 && event.charCode <= 57|| event.charCode >= 97 && event.charCode <= 122)
   {
      return false;   
   }else{
   			return true;
   }
}
function choose_tab_2() {
    var tab = '<?php echo $_GET['tab']; ?>';
	if(tab=='2'){
		$('#tab1').removeClass('current');
		$('#part_1').removeClass('current');
		$('#tab2').addClass('current');
		$('#part_2').addClass('current');
	}
}
document.getElementById('v907').onchange = function() {
    document.getElementById('v901').disabled = !this.checked;
     document.getElementById("v901").value = "";
	     document.getElementById('v902').disabled = !this.checked;
     document.getElementById("v902").value = "";
	     document.getElementById('v903').disabled = !this.checked;
     document.getElementById("v903").value = "";
	     document.getElementById('v415').disabled = !this.checked;
     document.getElementById("v415").value = "";
	     document.getElementById('v904').disabled = !this.checked;
     document.getElementById("v904").value = "";
};

document.getElementById('v908').onchange = function() {
    document.getElementById('v905').disabled = !this.checked;
     document.getElementById("v905").value = "";
};


</script>

