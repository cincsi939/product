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
	include("../../config/config_host.php"); #��ҧ�Ҥ�� Define
	require_once('lib/nusoap.php'); 
	require_once("lib/class.function.php");
	include "../../common/php_class/class_calculate_kpi.php";	
	$con = new Cfunction();
	$con->connectDB();
	if(isset($_GET['id']) && $_GET['id'] != '')
	{
		$sql = "select siteid,form_id,number_action,pin,child_userid,vid,yy,mm,value,reportdate,eq_id from eq_var_data where siteid=1 AND form_id=1 AND pin='".$_GET['id']."' AND eq_id='".$_GET['eq_id']."'";
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
	
?>
<link rel="stylesheet" href="../css/style.css">
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
						alert("�������ö�ӡ�ô֧��������");
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
						alert("�������ö�ӡ�ô֧��������");
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
						alert("�������ö�ӡ�ô֧��������");
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
						alert("�������ö�ӡ�ô֧��������");
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
						alert("�������ö�ӡ�ô֧��������");
					} else {
						alert("Error : "+XmlHttp.status);
					}
				}
			};
			XmlHttp.send(null);
		}
}

$(document).ready(function(){
	//showFatherData();
	/*$('#v417_3').click(function(){
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
	});*/
	
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
	$('.datepick').datepicker({
   dateFormat: 'dd/mm/yy',
   isBuddhist: true,
   defaultDate: toDay,
   dayNames: ['�ҷԵ��', '�ѹ���', '�ѧ���', '�ظ', '����ʺ��', '�ء��', '�����'],
   dayNamesMin: ['��.', '�.', '�.', '�.', '��.', '�.', '�.'],
   monthNames: ['���Ҥ�', '����Ҿѹ��', '�չҤ�', '����¹', '����Ҥ�', '�Զع�¹', '�á�Ҥ�', '�ԧ�Ҥ�', '�ѹ��¹', '���Ҥ�', '��Ȩԡ�¹', '�ѹ�Ҥ�'],
   monthNamesShort: ['���Ҥ�', '����Ҿѹ��', '�չҤ�', '����¹', '����Ҥ�', '�Զع�¹', '�á�Ҥ�', '�ԧ�Ҥ�', '�ѹ��¹', '���Ҥ�', '��Ȩԡ�¹', '�ѹ�Ҥ�'],
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
              if(confirm(' �س��ͧ���ź���ҧ�����Ź�� ')){
                     return true; // ��ҵ�ŧ OK �������зӧҹ���� 
              }else{
                     return false; // ��ҵͺ Cancel ��������ͧ������ 
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
			month_should = ['','���Ҥ�', '����Ҿѹ��', '�չҤ�', '����¹', '����Ҥ�', '�Զع�¹', '�á�Ҥ�', '�ԧ�Ҥ�', '�ѹ��¹', '���Ҥ�', '��Ȩԡ�¹', '�ѹ�Ҥ�'];
			$('#shouldBorn').val(month_should[a]+' �.�. '+b);
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
					console.log(link_page);
		}
		function chk_lessmonth(){
			var chk_year=$('#sYear').val();
			var chk_month=$('#sMonth').val();
					link_page = 'main/ajax.chk_month.php?chk_year='+chk_year+'&chk_month='+chk_month;
					$.get(link_page, function(data){
						$('#sMonth').html(data);
					});
		}
		/*function showFatherData(){
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
		}*/
		function fncSubmit()
{
	if($('#dataApprove').attr('checked')===false){
		alert('��س����͡�׹�ѹ�����Ţͧ��ҹ');
		$('#dataApprove').focus();
		return false;
	}
	/*
	if(document.form1.v9.value == '')
	{
		alert('��س��к������');
		document.form1.v9.focus();
		return false;
	}
	if(document.form1.v8.value == '')
	{
		alert('��س��кصӺ�');
		document.form1.v8.focus();
		return false;
	}
	
	if(document.getElementById('cCareer1').checked==false && document.getElementById('cCareer2').checked==false && document.getElementById('cCareer3').checked==false && document.getElementById('cCareer4').checked==false && document.getElementById('cCareer5').checked==false && document.getElementById('cCareer6').checked==false && document.getElementById('cCareer7').checked==false && document.getElementById('cCareer8').checked==false && document.getElementById('cCareer9').checked==false && document.getElementById('cCareer10').checked==false)
	{
		alert('��س����͡�Ҫվ ���� �к��Ҫվ���١��ͧ');
		document.form1.tCareer.focus();
		return false;
	}
	if(document.form1.chkSex.value == 0)
	{
		alert('��سҡ�͡���͡��');
		document.form1.tIDCard.focus();
		return false;
	}*/
	
	if($('#v3').val().trim() == "")
	{
		alert('��سҡ�͡�ѵû�ЪҪ� ���� ��ԡ��������ѵû�ЪҪ�');
		document.form1.v3.focus();
		return false;
	}
	
	if(document.form1.v376.value.trim() == "")
	{
		alert('��س����͡�ӹ�˹�Ҫ���');
		document.form1.v376.focus();
		return false;
	}
	/*
	if(document.form1.tLastname.value == "")
	{
		alert('��سҡ�͡���ʡ��');
		document.form1.tLastname.focus();
		return false;
	}*/

	if(document.form1.v1.value.trim() == "" || document.form1.v2.value.trim() == "")
	{
		alert('��سҡ�͡���� ���͹��ʡ��');
		document.form1.v1.focus();
		return false;
	}
	
	if(document.form1.v902.value == "")
	{
		alert('��س��к���͹���ú��˹���ʹ');
		document.form1.v902.focus();
		return false;
	}
	
	if($('#v3').val().length != 13)
	{
		alert('��سҡ�͡�Ţ��Шӵ�ǻ�ЪҪ����ú13��ѡ');
		document.form1.v3.focus();
		return false;
	}
	
	if($('#eq_idcard_status').val() == '2')
	{
		if(confirm('�Ţ��Шӵ�ǻ�ЪҪ��������к�\n��ͧ��úѹ�֡�������?')){
		}else{
			document.form1.v3.focus();
		return false;
		}
	}
	/*if($('#v412').val().trim() == "" && $('#v413').val().trim() == ""($('#chk_m_status').val()=='2' || $('#chk_m_status').val()=='3'))
	{
		alert('��ٳҡ�͡�������͹��ʡ�Ţͧ�Դ������ú��ǹ');
		document.form1.v412.focus();
		return false;
	}
	if($('#v414').val().trim() == "" && ($('#chk_m_status').val()=='2' || $('#chk_m_status').val()=='3'))
	{
		alert('��سҡ�͡�ѵû�ЪҪ� ���� ��ԡ��������ѵû�ЪҪ��ͧ�Դ�');
		document.form1.v414.focus();
		return false;
	}
	if($('#v414').val().length != 13 && ($('#chk_m_status').val()=='2' || $('#chk_m_status').val()=='3'))
	{
		alert('��سҡ�͡�Ţ��Шӵ�ǻ�ЪҪ��ͧ�Դ����ú13��ѡ');
		document.form1.v414.focus();
		return false;
	}*/
	
		if($('#v3').val().indexOf("�") == '-1'){
	var result = $('#v3').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
	} else {
		if(confirm('�Ţ��Шӵ�ǻ�ЪҪ��ͧ��ô����١��ͧ\n��ͧ��úѹ�֡�������?')){
		$('#eq_idcard_status').val('1');
		}else{
			document.form1.v3.focus();
		return false;
		}
	}
		}else{
			$('#eq_idcard_status').val('3');
		}
		/*if($('#v414').val().indexOf("�") == '-1' && $('#v414').val().trim() !=''){
	var result = $('#v414').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
	} else {
		if(confirm('�Ţ��Шӵ�ǻ�ЪҪ��ͧ�Դ����١��ͧ\n��ͧ��úѹ�֡�������?')){
		}else{
			document.form1.v414.focus();
		return false;
		}
	}
		}*/
	var birthDay = $('#v377').val();
		birthDay = birthDay.split('/');
	var	birthDate = (parseInt(birthDay[2])-543)+'-'+birthDay[1]+'-'+birthDay[0];
	$('#v377').val(birthDate);
	console.log($('#monthPreg').val());
	count_month_born();
	date_born();
	month_should_born();
	if($('#monthPreg').val() != '7' && $('#monthPreg').val() != '8' && $('#monthPreg').val() != '9'){
		if(confirm('�к���ӹǹ�ѹ���ú��˹���ʹ����� : '+$('#shouldBorn').val()+'\n��ͧ��úѹ�֡�������?')){
			
		}else{
		document.form1.v902.focus();
		return false;
		}
	}
}

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
	height:500px;
	z-index:999;
	position:fixed;
	display:none;
	box-shadow: 5px 5px 5px #888888;
	border:0px;
}
.form-code{border:1px solid #000;padding:3px 7px; width:80px;}
</style>
<form action="main_exc/<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form1" name="form1" onSubmit="JavaScript:return fncSubmit();">
<table width="80%" border="0">
<tbody>
	<tr>    
    	<td colspan="4" align="right" >ŧ����¹ � �ѹ��� <?php
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
   	  <td colspan="3" align="left"><b><u>��ǹ��� 1</u></b> <b>������˭ԧ��駤����/��ô� (���ŧ����¹)</b></td>
   	  <td width="246" align="right"><div class="form-code">Ẻ ��. 01</div>
      </td>
    </tr>
    <tr>
      <td width="24" align="right">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td rowspan="5" align="center">
		<video id="video" style="display:none"></video>
		<canvas id="canvas" style="display:none"></canvas>
		<img src="" id="photo" alt="photo" style="display:none">
      <?php
	  	if(($value['378'] =='')or($value['378']==NULL))
		{
			$valueImg = '<img src="../img/nopicture.gif" width="150" height="180" id="imgprvw" alt="uploaded image preview" name="pPicture">';
		}
		else
		{
			$valueImg = '<img src="../../../../repo_opp/profile/'.$value['378'].'" width="320" height="240" id="imgprvw" alt="uploaded image preview" name="pPicture">';
		}
		echo $valueImg;
	  ?>
		<input type="button" id="startbutton" style="display:none" value="�����ٻ">
		<input type="button" id="cancel_capture" style="display:none" value="¡��ԡ">
		<input type="button" id="capture_again" style="display:none" value="�����ٻ����">
        <input type="File" name="v378" id="v378" onChange="showimagepreview(this)" >
		<input type="button" id="takePhoto" value="�����ٻ����">
		<input type="hidden" id="lastPhoto" name="lastPhoto"></td>
    </tr>
    <tr>
      <td height="25" align="right"></td>
      <td height="25" colspan="2" valign="middle">
        �Ţ��Шӵ�ǻ�ЪҪ�<span class="style1"> *</span>
        <INPUT name="v3" type="text" id="v3" value="<?php echo $value[3]; ?>" size="30" <?php if($value[3]==''){}else{echo 'readonly';} ?>  onblur="chk_dupp()"/>        
        <span  id="idClassCheck" class="bIdCard">��Ǩ�ͺ</span>   <span  id="random2" class="bIdCard">�����Ţ�ѵ�</span></td>
      </tr>
    <tr>
    	<td height="25" align="right"></td>
         <td height="25" colspan="2" valign="middle">
         	<?php
				/*$para1 = array(
					'dateFormat' => 'dd/mm/yy',
					'inputname' => 'v701',
					'showicon' => false,
					'showOtherMonths' => true,
					'showButton' => false,
					'showchangeMonth' => true,
					'numberOfMonths' => 1,
					'changeYear' => true,
					'yearRange' => "c-100:c+100",
					'format' => 'tis-620',
					'value' => $value[701],
					'showWeek' => false);	
				 $result1 = $ws_client->call('calendar', $para1);//�ѹ�͡�ѵ�
				 $para2 = array(
					'dateFormat' => 'dd/mm/yy',
					'inputname' => 'v702',
					'showicon' => false,
					'showOtherMonths' => true,
					'showButton' => false,
					'showchangeMonth' => true,
					'numberOfMonths' => 1,
					'format' => 'tis-620',
					'value' => $value[702],
					'showWeek' => false);	
				 $result2 = $ws_client->call('calendar', $para2);//�ѹ�������*/
			?>
         	�ѹ�͡�ѵ�&nbsp;<span class="style1">*</span><input 	type="text" 
											class="datepick" 
											name="v701" 
                                            id = "v701" 
											value="<?php echo $value[701];?>">
            �ѹ�������&nbsp;<span class="style1">*</span><input 	type="text" 
											class="datepick" 
											name="v702" 
                                            id = "v702" 
											value="<?php echo $value[702];?>">
         </td>
    </tr>
    <tr>
      <td height="25" align="right"></td>
      <td height="25" colspan="2"><table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td width="10%">���ͼ��ŧ����¹&nbsp;<span class="style1">*</span></td>
          <td width="15%">
          
          <select id="tPrename" name="v376" style="width:90%" onChange="chgPreName(this.value)" >
          	<option value="">-�ӹ�˹�Ҫ���-</option>
            <?php
				$sql_Prename = 'SELECT id,prename_th,gender FROM `tbl_prename` WHERE gender = "2" AND prename_th NOT LIKE "%��%" ORDER BY priority asc;';
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
          
          </td>
          <td width="25%">����    <input name="v1" type="text" value="<?php echo $value[1]; ?>" id="v1" size="20"  /></td>
          <td width="10%" align="center">���ʡ��</td>
          <td><input type="text" value="<?php echo $value[2]; ?>"  name="v2" id="v2" size="20"/></td>
        </tr>
      </table></td>
      </tr>
    <tr>
      <td height="25" align="right">&nbsp;</td>
      <td height="25" colspan="2" valign="middle"><table width="471" border="0" cellpadding="1" cellspacing="1">
      	 <tr>
         	<td colspan="4"><u>�������������¹��ҹ</u></td>
         </tr>
        <tr>
          <td width="61" align="left">��ҹ�Ţ���</td>
          <td width="152"><INPUT type="text" value="<?php echo $value[5]; ?>" name="v5" style="width:90%" id="v5" /></td>
          <td width="76" align="left">������</td>
          <td width="151"><input type="text" value="<?php echo $value[6]; ?>"  name="v6" style="width:90%" id="v6" /></td>
          </tr>
        <tr>
          <td align="left">��͡/��� </td>
          <td><input type="text" value="<?php echo $value[13]; ?>"  name="v13" style="width:90%" id="v13" /></td>
          <td align="left">��� </td>
          <td><input type="text" value="<?php echo $value[7]; ?>" name="v7" style="width:90%" id="v7" /></td>
        </tr>
        <tr>
          <td align="left">�ѧ��Ѵ <span class="style1">*</span></td>
          <td><!--<input type="text" value="" name="tProvince" />-->
          
          <select id="v10" name="v10" onChange = "chgAmphur(this.value);"  style="width:90%" >
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
          <td align="left">����� <span class="style1">*</span></td>
          <td>
           <LABEL id="lblAmphur">
          	<select id="v9" name="v9" onChange = "chgTambon(this.value, '');" style="width:90%">
            <option value="">�ô�к�</option>
            <?php
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
			 ?>
            </select>
            </LABEL>
          
           <!--<input type="text" value="" name="tDistrict"/>--></td>
          </tr>
        <tr>
          <td align="left">�Ӻ� <span class="style1">*</span></td>
          <td><!--<input type="text" value=""  name="tParish"/>-->
          <LABEL id="lblTambon">
          <select id="v8" name="v8" style="width:90%">
          <option value="">�ô�к�</option>
          <?php
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
			 ?>
          </select>
          </LABEL></td>
          <td align="left">������ɳ���</td>
          <td><input type="text" value="<?php echo $value[406]; ?>"  name="v406" style="width:90%" id="v406"/></td>
          </tr>
		  <tr>
		  <td align="left">���Ѿ��</td>
          <td><input type="text" value="<?php echo $value[11]; ?>"  name="v11" style="width:90%" id="v11"/></td>
		  <td align="left">���Ѿ����Ͷ��</td>
          <td><input type="text" value="<?php echo $value[410]; ?>"  name="v410" style="width:90%" id="v410"/></td>
		  </tr>
      </table>
      <table width="471" border="0" cellpadding="1" cellspacing="1">
      	 <tr>
         	<td colspan="4"><u>�������Ѩ�غѹ</u></td>
         </tr>
         <tr>
          <td width="61" align="left">��ҹ�Ţ���</td>
          <td width="152"><INPUT type="text" value="<?php echo $value[805]; ?>" name="v805" style="width:90%" id="v805" /></td>
          <td width="76" align="left"></td>
          <td width="151"></td>
          </tr>
        <tr>
         <td align="left">������</td>
          <td ><input type="text" value="<?php echo $value[806]; ?>"  name="v806" style="width:90%" id="v806" /></td>
          <td align="left">�����ҹ</td>
          <td><INPUT type="text" value="<?php echo $value[814]; ?>" name="v814" style="width:90%" id="v814" /></td>
          </tr>
        <tr>
          <td align="left">��͡/��� </td>
          <td><input type="text" value="<?php echo $value[813]; ?>"  name="v813" style="width:90%" id="v813" /></td>
          <td align="left">��� </td>
          <td><input type="text" value="<?php echo $value[807]; ?>" name="v807" style="width:90%" id="v807" /></td>
        </tr>
        <tr>
          <td align="left">�ѧ��Ѵ <span class="style1">*</span></td>
          <td><!--<input type="text" value="" name="tProvince" />-->
          
          <select id="v810" name="v810" onChange = "chgAmphur2(this.value);"  style="width:90%" >
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
          <td align="left">�����/ࢵ <span class="style1">*</span></td>
          <td>
           <LABEL id="lblAmphur2">
          	<select id="v809" name="v809" onChange = "chgTambon2(this.value, '');" style="width:90%">
            <option value="">�ô�к�</option>
            <?php
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
			 ?>
            </select>
            </LABEL>
          
           <!--<input type="text" value="" name="tDistrict"/>--></td>
          </tr>
        <tr>
          <td align="left">�Ӻ�/�ǧ <span class="style1">*</span></td>
          <td><!--<input type="text" value=""  name="tParish"/>-->
          <LABEL id="lblTambon2">
          <select id="v808" name="v808" style="width:90%">
          <option value="">�ô�к�</option>
          <?php
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
			 ?>
          </select>
          </LABEL></td>
          <td align="left">������ɳ���</td>
          <td><input type="text" value="<?php echo $value[407]; ?>"  name="v407" style="width:90%" id="v407"/></td>
          </tr>
		  <tr>
		  <td align="left">���Ѿ��</td>
          <td><input type="text" value="<?php echo $value[811]; ?>"  name="v811" style="width:90%" id="v811"/></td>
		  <td align="left">���Ѿ����Ͷ��</td>
          <td><input type="text" value="<?php echo $value[411]; ?>"  name="v411" style="width:90%" id="v411"/></td>
		  </tr>
      </table>
      
      </td>
      </tr>
    <tr>
      <td height="25" align="right"></td>
      <td height="25" colspan="2">�� <span class="style1">*</span>
      <LABEL id="lblPreName">
      	<input name="v12" type="radio"  class="v12" id="female"  value="1" <?php echo 'checked'; ?> readonly/>˭ԧ&nbsp;
      	<input type="radio"  value="2" class="v12" name="v12"  id="male" style="display:none;"/>
		<INPUT name="chkSex" type="hidden" id="chkSex" value="1" size="30" />
	</LABEL>
</td>
      <td align="center">&nbsp;</td>
      </tr>
    <tr>
      <td height="25" align="right"></td>
	  <?php
	  $birthday='';
		if(isset($value[377]) && $value[377]!=''){
			$birthdate=explode('-',$value[377]);
			$birthday=$birthdate['2']."/".$birthdate['1']."/".($birthdate['0']+543);
		}
		
	  ?>
      <td height="25" colspan="2">�ѹ�Դ <span class="style1">*</span> <input 	type="text" 
											class="datepick" 
											name="v377" 
                                            id = "v377" 
											value="<?php echo $birthday;?>">  ����
        <INPUT name="v14" type="text" id="v14" value="<?php echo $value[14]; ?>" size="4" maxlength="4" class="numberOnly" />
��</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right"></td>
      <td height="25" colspan="2">�Ҫվ <span class="style1">*</span><input  name="v33" type="text" value="<?php echo $value[33]; ?>" style="width:90%" id="tCareer"  /></td></td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="right"></td>
      <td height="25" colspan="2">������ͻ� <span class="style1">*</span><input name="v36" type="text" value="<?php echo $value[36]; ?>" size="10" id="tIncome" class="numberOnly" /></td></td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
    	<td height="25" ></td>
        <?php
			$check1 = ''; 
			if( $value[907] == '1' ){
				$check1 = ' checked="checked" '; 
			}
		?>
        <td align="left" width="20"><input type="checkbox" name="v907" id="v907" value="1" <?php echo $check1;?>/></td>
        <td align="left" colspan="2">ŧ����¹�����ҧ��駤����</td>
    </tr>
    <tr>
    	<td height="25" ></td>
        <td align="left" width="20"></td>
        <td align="left" colspan="2">
        	���ؤ����&nbsp;<!--input type="text" name="v901" id="v901" value="<?php echo $value[901];?>" style="width:30px;"/-->
			<select name="v901" id="v901" onchange="date_born();month_should_born();">
				<?php for($i=0;$i<=42;$i++){ ?>
					<option value="<?php echo $i; ?>" <?php if($i==$value[901]){echo "selected";} ?>><?php echo $i; ?></option>
				<?php } ?>
			</select>
			&nbsp;�ѻ����&nbsp;&nbsp;
			<?php $monthNames = array('','���Ҥ�', '����Ҿѹ��', '�չҤ�', '����¹', '����Ҥ�', '�Զع�¹', '�á�Ҥ�', '�ԧ�Ҥ�', '�ѹ��¹', '���Ҥ�', '��Ȩԡ�¹', '�ѹ�Ҥ�')?>
        	��˹���ʹ�ص�&nbsp;��͹&nbsp;
			<select id="v902" name="v902" onchange="count_month_born()">
				<option value="">���͡��͹</option>
				<?php for($i=1;$i<count($monthNames);$i++){ ?>
				<option value="<?php echo $i; ?>" <?php if($i==$value[902]){echo 'selected';}?>><?php echo $monthNames[$i];?></option>
				<?php } ?>
			</select>
			&nbsp;
            ��&nbsp;�.�.&nbsp;<!--input type="text" name="v903" id="v903" value="<?php echo $value[903];?>" style="width:50px;"/-->
			<select name="v903" id="v903" onchange="count_month_born()">
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
			�ӹǹ�ص�㹤����&nbsp;<!--input type="text" name="v415" id="v415" value="<?php echo $value[415];?>" style="width:100px;"-->
			<select name="v415" id="v415">
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
			&nbsp;��&nbsp;
        	ʶҹ���ҡ�����&nbsp;<input type="text" name="v904" id="v904" value="<?php echo $value[904];?>" style="width:450px;"/>
        </td>
    </tr>
     <tr>
    	<td height="25" ></td>
        <?php
			$check2 = ''; 
			if( $value[908] == '1' ){
				$check2 = ' checked="checked" '; 
			}
		?>
        <td align="left" width="20"><input type="checkbox" name="v908" id="v908" value="1" <?php echo $check2;?>/></td>
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
			 $result3 = $ws_client->call('calendar', $para3);//�ѹ�͡�ѵ�*/
		?>
        <td align="left" colspan="2">ŧ����¹��ѧ��ʹ&nbsp;�ѹ/��͹/��&nbsp;�Դ�ͧ��&nbsp;<input 	type="text" 
											class="datepick" 
											name="v905" 
                                            id = "v905" 
											value="<?php echo $value[905];?>">
			&nbsp;����&nbsp;<input type="text" name="v906" id="v906" value="<?php echo $value[906];?>" style="width:30px;"/>&nbsp;��͹</td>
    </tr>
	<tr>
   	  <td colspan="3" align="left"><b>�����źԴҢͧ��</b> (�ó���ô����繺ؤ�ŵ�ҧ���� �����繺ؤ�����ʶҹзҧ����¹��ɮ�� �������ª��Ե ͹�������ԴҢͧ�硵���ٵԺѵü���դس���ѵԫ�����ѭ�ҵ��� ŧ����¹᷹)</td>
   	  <td width="246">
      </td>
    </tr>
	<tr>
    	<td height="25" ></td>
        <td align="left" colspan="3">����(���) <input type="text" name="v412" id="v412" value="<?php echo $value[412];?>"> ���ʡ�� <input type="text" name="v413" id="v413" value="<?php echo $value[413];?>"></td>
    </tr>
	<tr>
    	<td height="25" ></td>
        <td align="left" colspan="3">�Ţ��Шӵ�ǻ�ЪҪ� <input type="text" name="v414" id="v414" value="<?php echo $value[414];?>" onKeyPress="CheckNum()"> &nbsp;<span  id="idClassCheck2" class="bIdCard">��Ǩ�ͺ</span> <span  id="random3" class="bIdCard">�����Ţ�ѵ�</span></td>
    </tr>	
    <tr>
   	  <td colspan="3" align="left"><b>����͡�����ѡ�ҹ��Сͺ���ŧ����¹ �ѧ���</b></td>
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
        <td align="left" colspan="2">Ẻ�Ѻ�ͧʶҹТͧ�������͹ (��.02)</td>
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
        <td align="left" colspan="2">���Һѵû�ЪҪ��ͧ˭ԧ��駤����/��ô�</td>
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
        <td align="left" colspan="2">���Һѵû�Шӵ�ǻ�ЪҪ��ͧ�Դ��� (�ó�ŧ����¹᷹)</td>
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
        <td align="left" colspan="2">���͡��á�ýҡ�����������ش�ѹ�֡�آ�Ҿ�����������ʴ�(���˹�ҷ��ѹ�֡ʶҹ���ҡ�������С�˹���ʹ)</td>
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
        <td align="left" colspan="2">�����ٵԺѵ��� 1 ��Ѻ (�����ѧ�ҡ��ʹ�ص�����)</td>
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
        <td align="left" colspan="2">�����͡����׹�ѹʶҹТͧ��ô���������ó� ����͡�����˹��§ҹ�ͧ�Ѱ(�ó���ô����繺ؤ�ŵ�ҧ����<br>�����繺ؤ�����ʶҹзҧ����¹��ɮ�� �������ª��Ե ͹�������ԴҢͧ�硵���ٵԺѵü���դس���ѵԫ�����ѭ�ҵ���ŧ����¹᷹)</td>
    </tr>
    <tr>
   	  <td colspan="3" align="left"><b>��Ҿ����դ������ʧ��Т��Ѻ�Թ(���͡��§�������)�ѧ���</b></td>
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
        <td align="left" width="20"><input type="checkbox" name="v917" id="v917" value="1" <?php echo $check3;?>/></td>
        <td align="left" colspan="2">�Ѻ�Թ���µ��ͧ � ����Ԩ����������Ҫ� ���� �ӹѡ�ҹ�Ѳ���ѧ����Ф�����蹤��ͧ������ѧ��Ѵ</td>
    </tr>
    <tr>
    	<td height="25" ></td>
		<?php
			$check3 = ''; 
			if( $value[916] == '1' ){
				$check3 = ' checked="checked" '; 
			}
		?>
		<td align="left" width="20"><input type="checkbox" name="v916" id="v916" value="1" <?php echo $check3;?>/></td>
        <td align="left" colspan="2">�Ѻ�Թ��ҹ��Ҥ�á�ا�� �Ţ���ѭ��&nbsp;<input type="text" name="v921" id="v921" value="<?php echo $value[921];?>"/>�Ң�&nbsp;<input type="text" name="v925" id="v925" value="<?php echo $value[925];?>"  style="width:200px;"/></td>
    </tr>
    <tr>
    	<td height="25" ></td>
		<td height="20" ></td>
        <td align="left" colspan="2">���ͺѭ��&nbsp;<input type="text" name="v922" id="v922" value="<?php echo $value[922];?>"  style="width:200px;"/>&nbsp;�������ѭ��&nbsp;<input type="text" name="v923" id="v923" value="<?php echo $value[923];?>"  style="width:200px;"/></td>
    </tr>
	<?php
			$check_app = ''; 
			if( $value[0] == '1' ){
				$check_app = ' checked="checked" '; 
			}
		?>
    <tr>
    	<td height="25" ></td>
        <td align="left" width="20"><input type="checkbox" name="dataApprove" id="dataApprove" value="1" <?php echo $check_app;?>/></td>
        <td align="left" colspan="2"><b>��Ҿ��Ң��Ѻ�ͧ��Ң�ͤ�������͡��÷������蹹���繤�����ԧ�ء��С�� ����繼������㹤������͹�ҡ����Ф������͹</b></td>
    </tr>
    <tr>
        <td align="left" colspan="4"  height="25" ><b>�������§��ͤ����ҡ����������������µ�ӡ��� 3,000 �ҷ ��ͤ� �����͹ ���͵�ӡ��� 36,000 �ҷ ��ͤ� ��ͻ��������繼��</b></td>
    </tr>
    <tr>
        <td align="left" colspan="4"  height="25" ><b>���Ѻ�Է����Թʧ������صèҡ�ͧ�ع��Сѹ�ѧ�� �������ʴԡ�â���Ҫ��������Ѱ����ˡԨ ����������㹤������Ţͧ˹��§ҹ</b></td>
    </tr>
	<tr>
        <td align="left" colspan="4"  height="25" ><b>�ͧ�Ѱ �� ��ҹ�ѡ����Ф�ͺ���� ����ʶҹʧ������ͧ�Ѱ �����駢�Ҿ�����������Ѻ�Թ�ش˹ع���͡������§��</b></td>
    </tr>
	<tr>
        <td align="left" colspan="4"  height="25" ><b>���á�Դ��¹���ҡ�͹ �ҡ��ͤ�������͡��÷���������ͧ������� ��Ҿ����Թ��������Թ��õ�������� 㹡�ù�� ��Ҿ���</b></td>
    </tr>
	<tr>
        <td align="left" colspan="4"  height="25" ><b>�Թ���Ѻ�����Ţ������������������آ�Ҿ�ͧ�������� ��ҹ��ͧ�ҧ��ҧ�</b></td>
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
     <?php
			if( $from == 'edit' ){
		?>
    <tr height="50px;">
     <td colspan="4" align="right" valign="middle"><input type="submit" style="cursor:pointer; width:100px; height:30px;" value="�ѹ�֡">
	  <input type="button" style="cursor:pointer; width:100px; height:30px;" onclick="javascript:location.href='dashboard.php'" value="¡��ԡ">
      </tr>
      <?php
			}else{
	?>
    	<tr height="50px;">
		<input type="hidden" name="v416" id="v416" value="0">
          	<td colspan="4" align="right" valign="middle"><input type="submit" style="cursor:pointer; width:100px; height:30px;" value="�ѹ�֡">
			<input type="button" style="cursor:pointer; width:100px; height:30px;" onclick="javascript:location.href='dashboard.php'" value="¡��ԡ"></td>
         </tr>
    <?php
			}
		?>
	<?php
        if( $from == 'edit' ){
    ?>
    <tr>
    	<td align="left" colspan="4"><b><u>��ǹ��� 2</u> ����Ѻ���˹�ҷ���繼��ѹ�֡</b>&nbsp;<img src="../../images_sys/plus.gif" align="absmiddle" onclick="popup('<?php echo $_GET['id'];?>','main/dr_doc1_part2.php?from=add')" style="cursor:pointer;" title="���������š���Դ�ͧ��"/></td>
    </tr>
     <tr>
	<td colspan="4">
        <table border="0" cellpadding="0" cellspacing="1" id="ppDriverTable" class="order-list" width="100%">
        <thead>
            <tr>
                <th width="28" height="24" ><strong>�ӴѺ</strong></th>
                <th width="115" height="24" >�Ţ��Шӵ�ǻ�ЪҪ�</th>
                <th width="233" height="24" >����-ʡ��</th>
                <th width="73" height="24" >����(��͹)</th>
                <th width="90" >��������ѹ��</th>
                <th width="55" height="24" >����ͧ���</th>
          </tr>
        </thead>
        <tbody>
        <?php
			$i = 0;
			$sql = "select eq_id,eq_type,eq_idcard,eq_prename,eq_firstname,eq_lastname,eq_age,eq_education,eq_relation from eq_child where eq_mother_idcard = '".$_GET['id']."'";
			$tbl2 = $con->select($sql);
			foreach($tbl2 as $row){
				$i++;
		?>
            <tr>
                <td height="50" align="center" valign="top"><?php echo $i; ?></td>
                <td height="50" align="center" valign="top"><?php /*?><a id="show" href="form2/show.php?id=<?php echo $row['eq_idcard']; ?>"><?php */?><?php echo $row['eq_idcard']; ?><!--</a>--></td>
                <td height="50" align="left" valign="top">
                <a href="../../../opp_master/application/personal_data/index.php?p=general_data&keyview=general_data&p_id=10074&p_join_number=58-013-021&gid=54&idcard=<?php echo $row['eq_idcard'];?>" target="_blank"><?php echo $row['eq_prename']; ?><?php echo $row['eq_firstname']; ?> <?php echo $row['eq_lastname']; ?></a></td>
                <td height="50" align="center" valign="top"><?php echo $row['eq_age']; ?></td>
                <td height="50" align="center" valign="top"><?php echo $row['eq_relation']; ?></td>
                <td height="50" align="center" valign="top"><span style="cursor:pointer; text-decoration:underline;" onclick="popup('<?php echo $_GET['id'];?>','main/dr_doc1_part2.php?from=edit&eq_id=<?php echo $row['eq_id']; ?>')">���</span>&nbsp;/&nbsp;<a id="del" href="main_exc/dr_doc1_del_exc.php?id=<?php echo $row['eq_idcard']; ?>&mother_id=<?php echo $_GET['id']; ?>" OnClick="return chkdel();">ź</a></td>
          </tr>
         <?php
			}
		 ?>
        </tbody>
        </table>
        
      </td>
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
<div id="div-container">
</div>
<iframe id="iframe-popup" src="">
</iframe>
<script src="../js/CheckIdCardThai.min.js"></script>
<script src="../js/AgeCalculate.min.js"></script>
<script  type="text/javascript">


$(document).ready(function () {	

<?php
if(isset($_GET['id']))
{
?>
/*Start ��Ǩ�ͺ enable*/
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
/*End ��Ǩ�ͺ enable*/
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
//��͹�������á���Թ��к�
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

/*----------------------------------------------------------- ત�ѵû�ЪҪ�*/
 $('#idClassCheck').click(function() {
	var result = $('#v3').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
		alert('�Ţ�ѵû�ЪҪ����١��ͧ');
	} else {
		alert('�Ţ�ѵû�ЪҪ�������١��ͧ');
	}
});

$('#random2').click(function() {
	//$('#v3').RandomIdCardThai({firstNum: '0'});
	var randomcard = '�'+Random(0,999999999999);
	$('#v3').val(randomcard);
 });
 $('#idClassCheck2').click(function() {
	var result = $('#v414').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
		alert('�Ţ�ѵû�ЪҪ����١��ͧ');
	} else {
		alert('�Ţ�ѵû�ЪҪ�������١��ͧ');
	}
});

$('#random3').click(function() {
	//$('#v3').RandomIdCardThai({firstNum: '0'});
	var randomcard = '�'+Random(0,999999999999);
	$('#v414').val(randomcard);
 });
/*----------------------------------------------------------- ��Ǩ�ͺ����Ţ*/
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

/*----------------------------------------------------------- �ӹǹ�Ţ㹢�� 16 */
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

/*----------------------------------------------------------- �ӹǹ�Ţ㹢�� 15 */
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



/*----------------------------------------------------------- �ӹǹ�ѹ�Դ*/
$("#v377").change(function () {
	var result = calAge(document.getElementById('v377').value);
	document.getElementById('v14').value = result[0];
});


$("#v14").keyup(function() {
 var v14 = document.getElementById('v14').value ;
 var tv14 = <?php echo $dt = date('Y') + 543; ?> - v14 ;
 var showDate = "01/01/" + tv14 ;
 document.getElementById('v377').value = showDate;
 
});

//��ǹ�ͧ��õ�Ǩ�ͺ���͹䢡��Disabled 
//��Ǩ�ͺ���͹䢡������
$('.rSex').click(function(){
	$("#tSex").attr('disabled','disabled');
	document.getElementById('chkSex').value = 1;
});

$('#etc_1').click(function(){
	$("#tSex").removeAttr('disabled');
});

//��Ǩ�ͺ���͹䢡����������������
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

//��Ǩ�ͺ���͹䢡�����Ҫվ
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
		 if($('.careertable input:not(#cCareer9)').attr('disabled')){ //�����
			$('.careertable input:not(#cCareer9,#tCareer)').removeAttr('disabled')
		 }else{
			$('.careertable input:not(#cCareer9)').attr('disabled','disabled')
			$('.careertable input:not(#cCareer9)').removeAttr('checked')
		}
		

});

//��Ǩ�ͺ���͹䢡�������Թ
$('.rLand_1').click(function(){
	$("#tLand").attr('disabled','disabled');
});

$('#rLand').click(function(){
	$("#tLand").removeAttr('disabled');
});
//��Ǩ�ͺ���͹䢡������ʹ�
$('.rReligion').click(function(){
	$("#tReligion_1").attr('disabled','disabled');
});
$('.rReligion_1').click(function(){
	$("#tReligion_1").removeAttr('disabled');
});

//��Ǩ�ͺ���͹���ҹ�Ҿ����
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

//���͹䢡������ͺ����
//////////////////////////��Ǩ�ͺ���͹䢡������ͺ���������
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

/////////////////////////////��Ǩ�ͺ���͹䢡������ͺ���Ǣ���
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

///////////////////////////////////��Ǩ�ͺ���͹䢻�����ͺ���Ǿ����
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

/*------------------------------------ ��Ǩ�ͺ��͹��ͤ��� r15_2 r15_3 rStructureFamily rLargeFamily rSpecialFamily*/ 
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
//����Թ��к���й͡�к�
/* if($('.t18 input:not(#rDebt_a)').is(':checked') == true){
	 $('.t21').hide();
 }
 if($('.t18 input:not(#rDebt_b)').is(':checked') == true){
	 $('.t22').hide();
 }*/
//�Թ��鸹Ҥ��
$('#2_2_1').click(function(){
	if($('#2_2_1').attr('checked')){
		$('#t18_2_1_1').show();
	}
	else{
		$('#t18_2_1_1').hide();
	}
})
//�Թ���ͧ�ع�Ѩ��������Ѿ��
$('#2_2_2').click(function(){
	if($('#2_2_2').attr('checked')){
		$('#t18_2_1_2').show();
	}
	else{
		$('#t18_2_1_2').hide();
	}
})
//�Թ���ͧ�ع�����ҹ
$('#2_2_3').click(function(){
	if($('#2_2_3').attr('checked')){
		$('#t18_2_1_3').show();
	}
	else{
		$('#t18_2_1_3').hide();
	}
})
//�ͧ�ع�Ѳ�Һ��ҷʵ��
$('#2_2_4').click(function(){
	if($('#2_2_4').attr('checked')){
		$('#t18_2_1_4').show();
	}
	else{
		$('#t18_2_1_4').hide();
	}
})
//�ͧ�ع����٧����
$('#2_2_5').click(function(){
	if($('#2_2_5').attr('checked')){
		$('#t18_2_1_5').show();
	}
	else{
		$('#t18_2_1_5').hide();
	}
})
//�ͧ�ع��������Ѳ�Ҥس�Ҿ���Ե���ԡ��
$('#2_2_6').click(function(){
	if($('#2_2_6').attr('checked')){
		$('#t18_2_1_6').show();
	}
	else{
		$('#t18_2_1_6').hide();
	}
})
//�ͧ�ع����
$('#2_2_7').click(function(){
	if($('#2_2_7').attr('checked')){
		$('#t18_2_1_7').show();
	}
	else{
		$('#t18_2_1_7').hide();
	}
})
//�ͧ�ع�ɵ�
$('#2_2_8').click(function(){
	if($('#2_2_8').attr('checked')){
		$('#t18_2_1_8').show();
	}
	else{
		$('#t18_2_1_8').hide();
	}
})
//�����к�
$('#2_2_9').click(function(){
	if($('#2_2_9').attr('checked')){
		$('#t18_2_1_9').show();
	}
	else{
		$('#t18_2_1_9').hide();
	}
})
//�кءͧ�ع����������
$('#2_2_9').click(function(){
	if($('#2_2_9').attr('checked')){
		$('#t21_other').removeAttr('disabled');
	}
	else{
		$('#t21_other').attr('disabled','disabled');
	}
})
//�����ٻ
	$('#takePhoto').click(function(){
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

(function() {
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
  
})();  
</script> 
