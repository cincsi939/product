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
	
	if(isset($_GET['id']) && $_GET['id'] != '')
	{
		$sql = "select siteid,form_id,number_action,pin,child_userid,vid,yy,mm,value,eq_id,reportdate from eq_var_data where siteid=1 AND form_id=1  AND eq_id='".$_GET['eq_id']."'";
		//echo $sql;
		$results = $con->select($sql);
		//echo"<pre>";print_r($results);echo"</pre>";
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
	
	chk_maxday();
	chk_lessmonth();
	chk_lessday();
	$('#sMonth').change(function(){
		chk_maxday();
		chk_lessday();
	});
	$('#sYear').change(function(){
		chk_maxday();
		chk_lessmonth();
		chk_lessday();
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
	$msg_title = "แบบลงทะเบียนขอรับสิทธ์เงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด(กรณีหญิงตั้งครรภ์)<br>".$rs_org['groupname'];
}else{
	$msg_title = "แบบลงทะเบียนขอรับสิทธ์เงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด(กรณีหญิงตั้งครรภ์)<br>".$rs_org['groupname'];
}
?>
<h3><center><?php echo $msg_title;?></center></h3><!--main_exc/echo $action;-->
<form action="question_form.php?frame=dr_doc1_temp" method="post" enctype="multipart/form-data" id="form1" name="form1" onSubmit="JavaScript:return fncSubmit();">
<table width="70%" border="0" align="center">
<tbody>
    <tr>
	 <td height="25" align="right"></td>
   	  <td colspan="3" align="left">ลงทะเบียน ณ วันที่ <?php
	  
	  if($results['0']['reportdate']){
		$regis_date = explode('-',$results['0']['reportdate']);
		//print_r($regis_date);
		$register_date = ($regis_date['0']+543).'-'.$regis_date['1'].'-'.$regis_date['2'];
	  }else{
		  $register_date = '';
	  }
	  echo $con->_calendarTH('sDay','sMonth','sYear',$register_date); ?>
	  <input type="hidden" id="register_date" name="register_date">
	  </td>
   	  <!--td width="246" align="right"><div class="form-code">แบบ ดร. 01</div>
      </td-->
    </tr>
    <tr>
      <td height="25" align="right"></td>
      <td height="25" colspan="3" valign="middle">
        เลขประจำตัวประชาชน<span class="style1"> *</span><!--onKeyPress="CheckNum()"-->
        <INPUT name="v3" type="text" id="v3" value="<?php echo $value[3]; ?>" size="30" <?php if($value[3]==''){}else{echo '';} ?>   onchange="chk_dupp()"/>        
        <!--<span  id="idClassCheck" class="bIdCard">ตรวจสอบ</span>   <span  id="random2" class="bIdCard">สุ่มเลขบัตร</span><br> --></td>
      </tr>
    <tr>
      <td height="25" align="right"></td>
      <td height="25" colspan="3">
        คำนำหน้าชื่อ&nbsp;<span class="style1">*</span>
          <select id="tPrename" name="v376"  ><!--onChange="chgPreName(this.value)"-->
          	
            <?php
				$sql_Prename = 'SELECT id,prename_th,gender FROM `tbl_prename` WHERE gender = "2" AND prename_th NOT LIKE "%เด็ก%" ORDER BY id DESC;';
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
          ชื่อ<span class="style1"> *</span> <input name="v1" type="text" value="<?php echo $value[1]; ?>" id="v1" size="20"/>
          นามสกุล<span class="style1"> *</span>
          <input type="text" value="<?php echo $value[2]; ?>"  name="v2" id="v2" size="20"/>
       </td>
      </tr>
	  <tr>
      <td height="25" align="right"></td>
      <td height="25" colspan="3">
		หมายเลขโทรศัพท์ที่สามารถติดต่อได้ <input type="text" value="<?php echo $value[411]; ?>"  name="v411" id="v411"/>
        </td>
      </tr>
        
        
    <tr>
    	<td height="25" ></td>
        <td align="left" width="20"></td>
        <td align="left" colspan="2">
        	อายุครรภ์&nbsp;<!--input type="text" name="v901" id="v901" value="<?php echo $value[901];?>" style="width:30px;"/-->
			<select name="v901" id="v901" onchange="date_born();month_should_born();">
				<?php for($i=0;$i<=42;$i++){ ?>
					<option value="<?php echo $i; ?>" <?php if($i==$value[901]){echo "selected";} ?>><?php echo $i; ?></option>
				<?php } ?>
			</select>
			&nbsp;สัปดาห์&nbsp;&nbsp;
			<?php $monthNames = array('','มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม')?>
        	กำหนดคลอดบุตร&nbsp;เดือน&nbsp;<span class="style1"> *</span>
			<select id="v902" name="v902" onchange="count_month_born()">
				<option value="">เลือกเดือน</option>
				<?php for($i=1;$i<count($monthNames);$i++){ ?>
				<option value="<?php echo $i; ?>" <?php if($i==$value[902]){echo 'selected';}?>><?php echo $monthNames[$i];?></option>
				<?php } ?>
			</select>
			&nbsp;
            ปี&nbsp;พ.ศ.&nbsp;<!--input type="text" name="v903" id="v903" value="<?php echo $value[903];?>" style="width:50px;"/-->
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
			จำนวนบุตรในครรภ์&nbsp;<!--input type="text" name="v415" id="v415" value="<?php echo $value[415];?>" style="width:100px;"-->
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
			&nbsp;คน&nbsp;
        	<!--สถานที่ฝากครรภ์&nbsp;<input type="text" name="v904" id="v904" value="<?php echo $value[904];?>" style="width:450px;"/-->
        </td>
    </tr>
	<input type="hidden" name="v907" id="v907" value="1"/>
		<input type="hidden" name="eq_register_status" id="eq_register_status" value="1">
		<input type="hidden" name="type_form" id="type_form" value="a">
		<input type="hidden" name="v416" id="v416" value="<?php echo $value[416];?>">
		<input type="hidden" name="eq_id" id="eq_id" value="<?php echo $results['0']['eq_id'];?>">
		<input type="hidden" name="eq_idcard_status" id="eq_idcard_status" value="0">
		<input type="hidden" name="preg_day" id="preg_day" value="<?php echo date('m/d/Y');?>">
		<input type="hidden" name="monthPreg" id="monthPreg" value="">
		<input type="hidden" name="shouldBorn" id="shouldBorn" value="">
		<input type="hidden" name="form_status" id="form_status" value="0">
     <?php
			if( $from == 'edit' ){
		?>
    <tr height="50px;">
      <td colspan="4" align="right" valign="middle"><input type="submit" style="cursor:pointer; width:100px; height:30px;" value="บันทึก"> 
	  <input type="button" style="cursor:pointer; width:100px; height:30px;" onclick="javascript:location.href='<?php echo $_SESSION['session_mainfile']; ?>'" value="ยกเลิก"></td>
      </tr>
      <?php
			}else{
	?>
    	<tr height="50px;">
          	<td colspan="4" align="right" valign="middle"><input type="submit" style="cursor:pointer; width:100px; height:30px;" value="บันทึก"> 
			<input type="button" style="cursor:pointer; width:100px; height:30px;" onclick="javascript:location.href='<?php echo $_SESSION['session_mainfile']; ?>'" value="ยกเลิก"></td>
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
	if($('#v3').val().trim() == "")
	{
		alert('กรุณากรอกเลขประจำตัวประชาชน');
		document.form1.v3.focus();
		return false;
	}
	
	if(document.form1.v376.value.trim() == "")
	{
		alert('กรุณาเลือกคำนำหน้าชื่อ');
		document.form1.v376.focus();
		return false;
	}

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
	
	if($('#v411').val()!='' && $('#v411').val().length < 9)
	{
		alert('กรุณากรอกหมายเลขโทรศัพท์อย่างน้อย 9 หลัก');
		document.form1.v411.focus();
		return false;
	}
	if($('#v3').val().indexOf("x")=='-1'){
	if($('#v3').val().length != 13)
	{
		alert('กรุณากรอกเลขประจำตัวประชาชนให้ครบ13หลัก');
		document.form1.v3.focus();
		return false;
	}
	}
	
	/*if($('#eq_idcard_status').val() == '2')
	{
		if(confirm('เลขประจำตัวประชาชนนี้มีในระบบ\nต้องการบันทึกหรือไม่?')){
		}else{
			document.form1.v3.focus();
		return false;
		}
	}*/
	
		if($('#v3').val().indexOf("x") == '-1'){
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
	   month_arr = ['','มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
	   function chk_dupp(){
			var dupp_idcard=$('#v3').val();
			if(dupp_idcard!=''){
					link_page = 'main/ajax.chk_dupp.php?dupp_idcard='+dupp_idcard;
					$.get(link_page, function(data){
						if(data!=''){
						var arrData = data.split(",");
						console.log(arrData);
						var date_reg = arrData[13].split('-');
						
						var reg_date_year = date_reg[2]+' '+month_arr[parseInt(date_reg[1])]+' '+(parseInt(date_reg[0])+543);
			if(confirm('พบข้อมูลเลขประจำตัวประชาชนของมารดาในระบบ\n\n     '
                                        +'ชื่อ : '+arrData[2]+arrData[3]+' '+arrData[4]
                                        +'\n     หน่วยงานที่ลงทะเบียน : '+arrData[12]
                                        +'\n     วันที่ลงทะเบียน : '+reg_date_year
                                        +'\n\nท่านต้องการใช้ข้อมูลหรือไม่?')){
												$('#v416').val(arrData[0]);
												$('#eq_id').val(arrData[0]);
												$('#eq_idcard_status').val('2');
                                                $('#tPrename').val(arrData[1]);
                                                $('#v1').val(arrData[3]);
                                                $('#v2').val(arrData[4]);
                                                $('#v411').val(arrData[5]);
												$('#v901').val(arrData[8]);
												$('#v902').val(arrData[9]);
												$('#v903').val(arrData[10]);
												$('#v415').val(arrData[11]);  
                                            }else{
                                                    var newid = $('#v3').val()+'x';
                                                    $('#v3').val(newid);
                                                    $('#v416').val('');	
                                                    $('#eq_id').val('');
                                                    $('#eq_idcard_status').val('0');
                                                }
						}else{
							$('#eq_id').val('');
						$('#v416').val('');	
						$('#eq_idcard_status').val('0');
						}
					});
					}else{
						$('#eq_id').val('');
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
		function chk_lessday(){
			var chk_month=$('#sMonth').val();
			var chk_year=$('#sYear').val();
			var selected_day = $('#sDay').val();
					link_page = 'main/ajax.chk_lessday.php?chk_month='+chk_month+'&selected_day='+selected_day+'&chk_year='+chk_year;
					$.get(link_page, function(data){
                                            if(data!=''){
						$('#sDay').html(data);
                                            }
					});
		}
		
		
</script>
