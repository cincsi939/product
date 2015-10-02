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
	//print_r($_SESSION);
	include("../../config/config_host.php"); #อ้างหาค่า Define
	require_once('lib/nusoap.php'); 
	require_once("lib/class.function.php");
	include "../../common/php_class/class_calculate_kpi.php";	
	$con = new Cfunction();
	$con->connectDB();
	if(isset($_POST['eq_id']) && $_POST['eq_id'] != '')
	{
		$action = 'dr_doc1_edit_exc.php';
		$from = 'edit';
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
	showFatherData();
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
	/*$('.datepick').datepicker({
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
		yearRange: '1914:2050',
		showWeek: false,
		firstDay: 1
	});*/
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

<?php
	$ws_client = $con->configIPSoap();
	$calendar = array('file' => 'calendar');
	echo $ws_client->call('includefile', $calendar);
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
.form-code{border:1px solid #000;padding:3px 7px; width:60px;}
</style>
<?php 
$sql_org = "SELECT groupname FROM org_staffgroup WHERE gid='".$_SESSION['session_group']."'";
		$result_org = mysql_db_query(DB_USERMANAGER,$sql_org);
		$rs_org = mysql_fetch_assoc($result_org);
if($_GET['eq_id'] != ""){ # กรณีเป็นการแก้ไขข้อมูล
	$msg_title = "แบบยืนยันแก้ไขข้อมูลลงทะเบียนขอรับสิทธ์เงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด<br>".$rs_org['groupname'];
}else{
	$msg_title = "แบบยืนยันเพิ่มข้อมูลลงทะเบียนขอรับสิทธ์เงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด<br>".$rs_org['groupname'];
}
?>
<h3><center><?php echo $msg_title;?></center></h3>
<form action="main_exc/<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form1" name="form1">
<table width="70%" border="0" align="center">
<tbody>
	<tr>    
    	<td colspan="4" align="right" >
  	  </td>
      </tr>
    <tr>
	<?php $monthNames = array('','มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม')?>
	 <td height="25" align="right"></td>
   	  <td colspan="3" align="left"><b>ลงทะเบียน ณ วันที่</b> <?php
	  echo $_POST['sDay'].' '.$monthNames[$_POST['sMonth']].' '.$_POST['sYear'];
	  ?>
	  <input type="hidden" id="register_date" name="register_date">
	  </td>
   	  <td width="246" align="right"><!--div class="form-code">แบบ ดร. 01</div-->
      </td>
    </tr>
    <tr>
      <td height="25" align="right"></td>
      <td height="25" colspan="3" valign="middle">
        <b>เลขประจำตัวประชาชน</b> : <?php echo $_POST['v3'];?>
        </td>
      </tr>
	  <tr>
		<td height="25" align="right"></td>
		<td height="25" colspan="3" valign="middle">
		<?php 
			if($_POST['v417']=='3'){
				$m_status = 'มารดาเป็นบุคคลต่างด้าว';
			}else if($_POST['v417']=='2'){
				$m_status = 'มารดาเสียชีวิต';
			}else{
				$m_status = 'มารดายังมีชีวิตอยู่';
			}
			echo "<b>สถานะของมารดา</b> : ".$m_status;
		?>
			
		</td>
      </tr>
    <tr>
      <td height="25" align="right"></td>
	  <?php 
	  $prename = array();
	  $prename['65']='นางสาว';
	  $prename['74']='นาง';
	  ?>
      <td height="25" colspan="3"><b>ชื่อ - นามสกุลมารดา</b> : <?php echo $prename[$_POST['v376']].$_POST['v1'].' '.$_POST['v2']; ?></td>
	  </tr>
	  <tr>
      <td height="25" align="right"></td>
	  <td height="25" colspan="3"><b>หมายเลขโทรศัพท์ที่สามารถติดต่อได้</b> : <?php echo $_POST['v411']; ?></td>
      </tr>
    
    <tr>
    	<td height="25" ></td>
        <?php
			$check1 = ''; 
			if( $value[907] == '1' ){
				$check1 = ' checked="checked" '; 
			}
		?>
        <td align="left" width="20" colspan="3"><input type="hidden" name="v907" id="v907" value="1" <?php //echo $check1;?>/><b>ลงทะเบียนระหว่างตั้งครรภ์</b></td>
    </tr>
     <tr>
    	<td height="25" ></td>
        <td align="left" width="20"></td>
        <td align="left" colspan="2">
        	<b>อายุครรภ์</b>&nbsp;<!--input type="text" name="v901" id="v901" value="<?php echo $value[901];?>" style="width:30px;"/-->
			<?php echo $_POST['v901'];?>
			&nbsp;<b>สัปดาห์</b>&nbsp;&nbsp;
			
        	<b>กำหนดคลอดบุตร&nbsp;เดือน</b>&nbsp;
			<?php echo $monthNames[$_POST['v902']]; ?>
			&nbsp;
            <b>ปี&nbsp;พ.ศ.</b>&nbsp;<!--input type="text" name="v903" id="v903" value="<?php echo $value[903];?>" style="width:50px;"/-->
			<?php echo $_POST['v903'];?>
        </td>
    </tr>
     <tr>
    	<td height="25" ></td>
        <td align="left" width="20"></td>
        <td align="left" colspan="2">
			<b>จำนวนบุตรในครรภ์</b>&nbsp;<!--input type="text" name="v415" id="v415" value="<?php echo $value[415];?>" style="width:100px;"-->
			<?php echo $_POST['v415']; ?>
			&nbsp;<b>คน</b>&nbsp;
        	<!--สถานที่ฝากครรภ์&nbsp;<input type="text" name="v904" id="v904" value="<?php echo $value[904];?>" style="width:450px;"/-->
        </td>
    </tr>
	<?php if($_POST['v417']==2 || $_POST['v417']==3){?>
	<tr>
	<td height="25" ></td>
   	  <td colspan="3" align="left"><b>ข้อมูลบิดาของเด็ก</b> (กรณีมารดาเด็กเป็นบุคคลต่างด้าว หรือเป็นบุคคลไร้สถานะทางทะเบียนราษฎร์ หรือเสียชีวิต อนุโลมให้บิดาของเด็กตามสูติบัตรผู้มีคุณสมบัติซึ่งมีสัญชาติไทย ลงทะเบียนแทน)</td>
   	  <td width="246">
      </td>
    </tr>
	<tr>
    	<td height="25" ></td>
        <td align="left" colspan="3"><b>ชื่อ - นามสกุลบิดา</b> : นาย<?php echo $_POST['v412'].' '.$_POST['v413'];?></td>
    </tr>
	<tr>
    	<td height="25" ></td>
        <td align="left" colspan="3"><b>เลขประจำตัวประชาชน</b> : <?php echo $_POST['v414'];?></td>
		
    </tr>
	<tr>
	<td height="25" ></td>
		<td align="left" colspan="3"><b>หมายเลขโทรศัพท์ที่สามารถติดต่อได้</b> : <?php echo $_POST['v418']; ?></td>
		</tr>
	<?php } ?>
		<input type="hidden" name="sDay" id="sDay" value="<?php echo $_POST['sDay'];?>">
		<input type="hidden" name="sMonth" id="sMonth" value="<?php echo $_POST['sMonth'];?>">
		<input type="hidden" name="sYear" id="sYear" value="<?php echo $_POST['sYear'];?>">
		<input type="hidden" name="v3" id="v3" value="<?php echo $_POST['v3'];?>">
		<input type="hidden" name="v417" id="v417" value="<?php echo $_POST['v417'];?>">
		<input type="hidden" name="v376" id="v376" value="<?php echo $_POST['v376'];?>">
		<input type="hidden" name="v1" id="v1" value="<?php echo $_POST['v1'];?>">
		<input type="hidden" name="v2" id="v2" value="<?php echo $_POST['v2'];?>">
		<input type="hidden" name="v411" id="v411" value="<?php echo $_POST['v411'];?>">
		<input type="hidden" name="v907" id="v907" value="<?php echo $_POST['v907'];?>">
		<input type="hidden" name="v901" id="v901" value="<?php echo $_POST['v901'];?>">
		<input type="hidden" name="v902" id="v902" value="<?php echo $_POST['v902'];?>">
		<input type="hidden" name="v903" id="v903" value="<?php echo $_POST['v903'];?>">
		<input type="hidden" name="v415" id="v415" value="<?php echo $_POST['v415'];?>">
		<input type="hidden" name="v412" id="v412" value="<?php echo $_POST['v412'];?>">
		<input type="hidden" name="v413" id="v413" value="<?php echo $_POST['v413'];?>">
		<input type="hidden" name="v414" id="v414" value="<?php echo $_POST['v414'];?>">
		<input type="hidden" name="v418" id="v418" value="<?php echo $_POST['v418'];?>">
		<input type="hidden" name="eq_id" id="eq_id" value="<?php echo $_POST['eq_id'];?>">
		<input type="hidden" name="eq_idcard_status" id="eq_idcard_status" value="<?php echo $_POST['eq_idcard_status'];?>">
		<input type="hidden" name="preg_day" id="preg_day" value="<?php echo $_POST['preg_day'];?>">
		<input type="hidden" name="monthPreg" id="monthPreg" value="<?php echo $_POST['monthPreg'];?>">
		<input type="hidden" name="shouldBorn" id="shouldBorn" value="<?php echo $_POST['shouldBorn'];?>">
     <?php
			if( $from == 'edit' ){
		?>
    <tr height="50px;">
      <td colspan="4" align="right" valign="middle"><button style="cursor:pointer; width:100px; height:30px;"> บันทึก </button>
	  <button style="cursor:pointer; width:100px; height:30px;" onclick="history.go(-1);"> ยกเลิก </button></td>
      </tr>
      <?php
			}else{
	?>
    	<tr height="50px;">
          	<td colspan="4" align="right" valign="middle"><button style="cursor:pointer; width:100px; height:30px;"> บันทึก </button>
			<button style="cursor:pointer; width:100px; height:30px;" onclick="history.go(-1);"> ยกเลิก </button></td>
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


function fncSubmit()
{
	/*if($('#dataApprove').attr('checked')===false){
		alert('กรุณาเลือกยืนยันข้อมูลของท่าน');
		$('#dataApprove').focus();
		return false;
	}
	
	if(document.form1.v9.value == '')
	{
		alert('กรุณาระบุอำเภอ');
		document.form1.v9.focus();
		return false;
	}
	if(document.form1.v8.value == '')
	{
		alert('กรุณาระบุตำบล');
		document.form1.v8.focus();
		return false;
	}
	
	if(document.getElementById('cCareer1').checked==false && document.getElementById('cCareer2').checked==false && document.getElementById('cCareer3').checked==false && document.getElementById('cCareer4').checked==false && document.getElementById('cCareer5').checked==false && document.getElementById('cCareer6').checked==false && document.getElementById('cCareer7').checked==false && document.getElementById('cCareer8').checked==false && document.getElementById('cCareer9').checked==false && document.getElementById('cCareer10').checked==false)
	{
		alert('กรุณาเลือกอาชีพ หรือ ระบุอาชีพไม่ถูกต้อง');
		document.form1.tCareer.focus();
		return false;
	}
	if(document.form1.chkSex.value == 0)
	{
		alert('กรุณากรอกเลือกเพศ');
		document.form1.tIDCard.focus();
		return false;
	}*/
	
	if($('#v3').val().trim() == "")
	{
		alert('กรุณากรอกบัตรประชาชน หรือ คลิกที่สุ่มบัตรประชาชน');
		document.form1.v3.focus();
		return false;
	}
	
	if(document.form1.v376.value.trim() == "")
	{
		alert('กรุณาเลือกคำนำหน้าชื่อ');
		document.form1.v376.focus();
		return false;
	}
	/*
	if(document.form1.tLastname.value == "")
	{
		alert('กรุณากรอกนามสกุล');
		document.form1.tLastname.focus();
		return false;
	}*/

	if(document.form1.v1.value.trim() == "" || document.form1.v2.value.trim() == "")
	{
		alert('กรุณากรอกชื่อ หรือนามสกุล');
		document.form1.v1.focus();
		return false;
	}
	
	if(document.form1.v902.value == "")
	{
		alert('กรุณาระบุเดือนที่ครบกำหนดคลอด');
		document.form1.v902.focus();
		return false;
	}
	
	if($('#v3').val().length != 13)
	{
		alert('กรุณากรอกเลขประจำตัวประชาชนให้ครบ13หลัก');
		document.form1.v3.focus();
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
	if(document.form1.v412.value.trim() == "" || document.form1.v413.value.trim() == "" && ($('#v417_2').attr("checked") || $('#v417_3').attr("checked")))
	{
		alert('กรูณากรอกชื่อหรือนามสกุลของบิดาเด็กให้ครบถ้วน');
		document.form1.v412.focus();
		return false;
	}
	if($('#v414').val().trim() == "" && ($('#v417_2').attr("checked") || $('#v417_3').attr("checked")))
	{
		alert('กรุณากรอกบัตรประชาชน หรือ คลิกที่สุ่มบัตรประชาชนของบิดา');
		document.form1.v414.focus();
		return false;
	}
	if($('#v414').val().length != 13 && ($('#v417_2').attr("checked") || $('#v417_3').attr("checked")))
	{
		alert('กรุณากรอกเลขประจำตัวประชาชนของบิดาให้ครบ13หลัก');
		document.form1.v414.focus();
		return false;
	}
	
		if($('#v3').val().indexOf("ส") == '-1'){
	var result = $('#v3').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
	} else {
		if(confirm('เลขประจำตัวประชาชนนี้ไม่ถูกต้อง\nต้องการบันทึกหรือไม่?')){
		$('#eq_idcard_status').val('1');
		}else{
			document.form1.v3.focus();
		return false;
		}
	}
		}else{
			$('#eq_idcard_status').val('3');
		}
		if($('#v414').val().indexOf("ส") == '-1'){
	var result = $('#v414').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
	} else {
		if(confirm('เลขประจำตัวประชาชนนี้ไม่ถูกต้อง\nต้องการบันทึกหรือไม่?')){
		}else{
			document.form1.v414.focus();
		return false;
		}
	}
		}
	//var birthDay = $('#v377').val();
		//birthDay = birthDay.split('/');
	//var	birthDate = (parseInt(birthDay[2])-543)+'-'+birthDay[1]+'-'+birthDay[0];
	//$('#v377').val(birthDate);
	//console.log($('#monthPreg').val());
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
 $('#idClassCheck').click(function() {
	var result = $('#v3').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
		alert('เลขบัตรประชาชนนี้ถูกต้อง');
	} else {
		alert('เลขบัตรประชาชนนี้ไม่ถูกต้อง');
	}
});

$('#random2').click(function() {
	//$('#v3').RandomIdCardThai({firstNum: '0'});
	var randomcard = 'ส'+Random(0,999999999999);
	$('#v3').val(randomcard);
 });
 
 $('#idClassCheck2').click(function() {
	var result = $('#v414').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
	if (result) {
		alert('เลขบัตรประชาชนนี้ถูกต้อง');
	} else {
		alert('เลขบัตรประชาชนนี้ไม่ถูกต้อง');
	}
});

$('#random3').click(function() {
	//$('#v3').RandomIdCardThai({firstNum: '0'});
	var randomcard = 'ส'+Random(0,999999999999);
	$('#v414').val(randomcard);
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
});
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
		
</script>
