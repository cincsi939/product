
<?php
	session_start();
	include("../../../config/config_host.php"); #��ҧ�Ҥ�� Define
	include('../../survey/lib/class.function.php');
	$con = new Cfunction();
	$con->connectDB();
	require_once('../lib/nusoap.php'); 
	require_once("../lib/class.function.php");
	/*
	$user = $_SESSION['username'];
	$pass = $_SESSION['pass'];
	
	$sql ="SELECT user_id,pass,user_status FROM user WHERE user_id='".$user."' AND pass='".$pass."'";
	$results  = mysql_query($sql);
	$rs = mysql_fetch_array($results);
	if($rs <=0) { 
	header( "location:../../usermanager/login.php");

	}*/
		
		function change_date_format($value){
		$date = explode('-',$value);
		$result = $date['2']."/".$date['1']."/".($date['0']+543);
		return $result;
	}
		
		$sql = " SELECT 
						eq_child.eq_idcard AS eq_idcard,
						eq_child.eq_code_prename AS eq_code_prename,
						eq_child.eq_prename AS eq_prename,
						eq_child.eq_firstname AS eq_firstname,
						eq_child.eq_lastname AS eq_lastname,
						eq_child.eq_bdoc_no AS eq_bdoc_no,
						eq_child.eq_bdoc_staff AS eq_bdoc_staff,
						eq_child.eq_docDate AS eq_docDate,
						eq_child.eq_birthPlace AS eq_birthPlace,
						eq_child.eq_presStatus AS eq_presStatus,
						eq_child.eq_stayPlace AS eq_stayPlace,
						eq_child.eq_comment AS eq_comment,
						eq_child.eq_address AS eq_address,
						eq_child.eq_village AS eq_village,
						eq_child.eq_subvillage AS eq_subvillage,
						eq_child.eq_alley AS eq_alley,
						eq_child.eq_street AS eq_street,
						eq_child.eq_code_parish AS eq_code_parish,
						eq_child.eq_parish AS eq_parish,
						eq_child.eq_code_district AS eq_code_district,
						eq_child.eq_district AS eq_district,
						eq_child.eq_code_province AS eq_code_province,
						eq_child.eq_province AS eq_province,
						eq_child.eq_phone AS eq_phone,
						eq_child.eq_code_gender AS eq_code_gender,
						eq_child.eq_gender AS eq_gender,
						eq_child.eq_birthday AS eq_birthday,
						eq_child.eq_postcode AS eq_postcode,
						eq_child.eq_mobilephone AS eq_mobilephone,
						eq_child.eq_mother_idcard AS eq_mother_idcard
					FROM eq_child
					WHERE eq_child.eqc_id = '".$_GET['eqc_id']."' ";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
?>
<link rel="stylesheet" href="../../css/style.css">
<script src="../../js/jquery.js" type="text/javascript"></script>
<script src="../../js/CheckIdCardThai.min.js"></script>
<script src="../../js/AgeCalculate.min.js"></script>

<link rel="stylesheet" href="../../package/jquery-ui/jquery-ui.css">
<script src="../../package/jquery-ui/jquery-ui-thai.js"></script>
<link rel="stylesheet" href="../../reportbuilder_opp/common/font/Thai_Sans_Neue_Regular.css">
<style>
 body,td,th,a,input,select,span,div,tr,button {
 <!-- font-family: Thai Sans Neue Regular; -->
  font-size: 18px;
  color: #000000;
 }
 .style1{
	color:#F00;
}
 </style>

<script>
	$(document).ready(function(){
		if($('input[name=stayPlace]:radio:checked').val()=='1'){
				$('.show_stayPlace').hide();
			}else{
				$('.show_stayPlace').show();
			}
		
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
		$('#close').click(function(){
			parent.$('#iframe-popup').fadeOut('fast',function(){
				parent.$('#div-container').fadeOut('fast');
			});
		});
		
		$('#cancel').click(function(){
			parent.$('#iframe-popup').fadeOut('fast',function(){
				parent.$('#div-container').fadeOut('fast');
			});
		});
		
		 $('#idcard').change(function() {
			var result = $('#idcard').CheckIdCardThai({exceptStartNum0: true, exceptStartNum9: false});
			if (result) {
				//alert('�Ţ�ѵû�ЪҪ����١��ͧ');
			} else {
				alert('�Ţ�ѵû�ЪҪ�������١��ͧ');
			}
		});
		
		$('#random2').click(function() {
			$('#idcard').RandomIdCardThai({firstNum: '0'});
		 });
		 
		 $(".numberonly").keydown(function(e){
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
		$('.presStatus').click(function(){
			if($('input[name=presStatus]:radio:checked').val()=='1'){
				$('#comment').attr('disabled','disabled');
				$('#rerel').attr('disabled','disabled');
				$('#comment').val("");
				$('#rerel').val("");
				
			}else{
				$('#comment').attr('disabled',false);
				$('#rerel').attr('disabled',false);
			}
		});
		$('.stayPlace').click(function(){
			if($('input[name=stayPlace]:radio:checked').val()=='1'){
				$('.show_stayPlace').hide();
			}else{
				$('.show_stayPlace').show();
			}
		});
	});
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
			XmlHttp.open("get", "ajax.chgamphur.php?PvID="+e+"&DfVal="+defa_v, true);
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
			XmlHttp.open("get", "ajax.chgtambon.php?TbID="+e+"&DfVal="+defa_v, true);
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

function chgPreName(e) {
	if ( e ) {
			CreateXmlHttp();
			XmlHttp.open("get", "ajax.chkprename.php?pre="+e, true);

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
function saveData(){
	var from = '<?php echo $_GET['from'];?>';
	var idcard_mother = '<?php echo $_GET['id'];?>';
	var idcard = $('#idcard').val();
	var prename = $('input[name=prename]:radio:checked').val();
	var firstname = $('#firstname').val();
	var surname = $('#surname').val();
	var birthDate = $('#birthDate').val();
	var bdoc_no = $('#bdoc_no').val();
	var bdoc_staff = $('#bdoc_staff').val();
	var docDate = $('#docDate').val();
	var birthPlace = $('#birthPlace').val();
	var presStatus = $('input[name=presStatus]:radio:checked').val();
	var comment = $('#comment').val();
	var stayPlace = $('input[name=stayPlace]:radio:checked').val();
	var address1 = $('#address1').val();
	var address2 = $('#address2').val();
	var address8 = $('#address8').val();
	var address9 = $('#address9').val();
	var address3 = $('#address3').val();
	var address4 = $('#address4').val();
	if( $('#address5').val() ){
		var address5 = $('#address5').val();
	}else{
		var address5 = $('#v9').val();
	}
	if( $('#address6').val() ){
		var address6 = $('#address6').val();
	}else{
		var address6 = $('#v8').val();
	}
	var address7 = $('#address7').val();
	var eq_postcode = $('#eq_postcode').val();
	var eq_mobilephone = $('#eq_mobilephone').val();
	
	if(idcard==""){
		alert('��ٳҡ�͡�Ţ��Шӵ�ǻ�ЪҪ�');
		return false;
	}
	if(firstname=="" || surname==""){
		alert('��ٳҡ�͡���� ���� ���ʡ��');
		return false;
	}
	if(birthDate==""){
		alert('��ٳҡ�͡�ѹ ��͹ ���Դ');
		return false;
	}
	if(bdoc_no==""){
		alert('��ٳҡ�͡�Ţ����ٵԺѵ�');
		return false;
	}
	if(bdoc_staff==""){
		alert('��ٳ��кؼ���͡�ٵԺѵ�');
		return false;
	}
	if(docDate==""){
		alert('��ٳҡ�͡�ѹ����͡�ٵԺѵ�');
		return false;
	}
	if(birthPlace==""){
		alert('��ٳ��к�ʶҹ����ʹ�ص�');
		return false;
	}
	if(presStatus=="2" && comment==""){
		alert('��ٳ��кت��ͼ������§�ٺص�');
		return false;
	}
	if(stayPlace=="2" && address4==""){
		alert('��ٳ��кبѧ��Ѵ��������硡ó��������Ѻ��ô�');
		return false;
	}
	if(stayPlace=="2" && address5==""){
		alert('��ٳ��к�����ͷ�������硡ó��������Ѻ��ô�');
		return false;
	}
	if(stayPlace=="2" && address6==""){
		alert('��ٳ��кصӺŷ�������硡ó��������Ѻ��ô�');
		return false;
	}
	

		var eq_id = '<?php echo $_GET['eq_id'];?>';
	
		var eqc_id = '<?=$_GET['eqc_id'];?>';


		var url = '../main_exc/dr_doc1_child_exc.php?from='+from+'&idcard_mother='+idcard_mother+'&idcard='+idcard+'&prename='+prename+'&firstname='+firstname+'&surname='+surname+'&birthDate='+birthDate+'&bdoc_no='+bdoc_no+'&bdoc_staff='+bdoc_staff+'&docDate='+docDate+'&birthPlace='+birthPlace+'&presStatus='+presStatus+'&comment='+comment+'&stayPlace='+stayPlace+'&address1='+address1+'&address2='+address2+'&address8='+address8+'&address9='+address9+'&address3='+address3+'&address4='+address4+'&address5='+address5+'&address6='+address6+'&address7='+address7+'&eq_postcode='+eq_postcode+'&eq_mobilephone='+eq_mobilephone+'&eq_id='+eq_id+'&eqc_id='+eqc_id;
		//alert(url);
	$.get(url,function(data){
		
		if( data == 'ok' ){
			alert('�ѹ�֡���������º��������');
			parent.$('#iframe-popup').fadeOut('fast',function(){
				parent.$('#div-container').fadeOut('fast',function(){
					//1    parent.window.location.reload();
					//2    parent.window.location.href = 'question_form.php?frame=dr_doc1&id=<?php echo $_GET['id'];?>&eq_id=<?php echo $_GET['eq_id'];?>';
					parent.window.location.href='question_form.php?frame=dr_doc1&id='+idcard_mother+'&eq_id=<?php echo $_GET['eq_id'];?>&tab=2';
				});
			});
		}else{
			alert('�ѹ�֡��������ͧ�ҡ :: '+data);
			return false;
		}
	});
}
</script>
<?php
$ws_client = $con->configIPSoap();
		$calendar = array('file' => 'calendar');
		echo $ws_client->call('includefile', $calendar);
?>
<style>
	tr{
		height:25px;
	}
</style>
<table width="100%">
	<tr>
    	<td align="right"><div style="margin-right:5px; font-size:16px; font-weight:bold; cursor:pointer; width:10px;" title="�Դ" id="close">X</div></td>
    </tr>
</table>
<table width="90%" align="center">
	<tr>
    	<td align="left"><b><u>��ǹ��� 2</u> ���������á�Դ</b></td>
    </tr>
    <tr>
    	<td align="left"><b><u>�����š���Դ�ͧ��</u></b>(�ѹ�֡�����ѧ��������Դ����)</td>
    </tr>
    <tr>
    	<td align="left">�Ţ��Шӵ�ǻ�ЪҪ� <span class="style1"> *</span>&nbsp;<INPUT name="idcard" type="text" id="idcard" value="<?php echo $row['eq_idcard'];?>" size="30" class="numberonly"/>        
        <!--span  id="idClassCheck" class="bIdCard">��Ǩ�ͺ</span>   <span  id="random2" class="bIdCard">�����Ţ�ѵ�</span></td-->
    </tr>
    	<?php
			$check1 = ' checked="checked" ';
			$check2 = '';
			if($row['eq_code_prename'] == '83'){
				$check1 = ' checked="checked" ';
				$check2 = '';
			}elseif($row['eq_code_prename'] == '84'){
				$check1 = '';
				$check2 = ' checked="checked"  ';
			}
		?>
     <tr>
    	<td align="left">
        	(<input type="radio" name="prename" id="prename" value="83" <?php echo $check1;?>>�.�./<input type="radio" name="prename" id="prename" value="84"  <?php echo $check2;?>>�.�.)
            &nbsp;���� <span class="style1"> *</span>&nbsp;<input type="text" id="firstname" name="firstname" value="<?php echo $row['eq_firstname'];?>" style="width:200px;" onkeypress='return chaonly()'>
        	&nbsp;���ʡ�� <span class="style1"> *</span>&nbsp;<input type="text" id="surname" name="surname" value="<?php echo $row['eq_lastname'];?>" style="width:300px;" onkeypress='return chaonly()'>
        </td>
    </tr>
    <?php
		
		/*$para = array(
			'dateFormat' => 'dd/mm/yy',
			'inputname' => 'birthDate',
			'showicon' => false,
			'showOtherMonths' => true,
			'showButton' => false,
			'showchangeMonth' => true,
			'numberOfMonths' => 1,
			'format' => 'tis-620',
			'value' => $row['eq_birthday'],
			'showWeek' => false);	
		 $result = $ws_client->call('calendar', $para);*/
	?>
    <tr>
    	<td align="left">
        	�ѹ��͹���Դ <span class="style1"> *</span>&nbsp;<input 	type="text" 
											class="datepick" 
											name="birthDate" 
                                            id = "birthDate" 
											value="<?php echo ($row['eq_birthday']==""?"":change_date_format($row['eq_birthday']));?>">
        </td>
    </tr>
    <?php
		/*$para2 = array(
			'dateFormat' => 'dd/mm/yy',
			'inputname' => 'docDate',
			'showicon' => false,
			'showOtherMonths' => true,
			'showButton' => false,
			'showchangeMonth' => true,
			'numberOfMonths' => 1,
			'format' => 'tis-620',
			'value' => $row['eq_docDate'],
			'showWeek' => false);	
		 $result2 = $ws_client->call('calendar', $para2);*/
	?>
    <tr>
    	<td align="left">
        	�����ٵԺѵ��Ţ��� <span class="style1"> *</span>&nbsp;<input type="text" id="bdoc_no" name="bdoc_no" value="<?php echo $row['eq_bdoc_no'];?>" style="width:80px;">&nbsp;
            �͡����� <span class="style1"> *</span>&nbsp;<input type="text" id="bdoc_staff" name="bdoc_staff" value="<?php echo $row['eq_bdoc_staff'];?>" style="width:200px;">&nbsp;
            ������ѹ��� <span class="style1"> *</span>&nbsp;<input 	type="text" 
											class="datepick" 
											name="docDate" 
                                            id = "docDate" 
											value="<?php echo ($row['eq_docDate']==""?"":change_date_format($row['eq_docDate']));?>">
        </td>
    </tr>
    <tr>
    	<td align="left">
        	��ʹ � <span class="style1"> *</span>&nbsp;<input type="text" id="birthPlace" name="birthPlace" value="<?php echo $row['eq_birthPlace'];?>" style="width:600px;"/>
        </td>
    </tr>
     <tr>
    	<td align="left">
        	<b><u>�������§����㹪�ǧ 0 - 1 ��</u></b>
        </td>
    </tr>
     <tr>
    	<td align="left">
        	<?php
				$check1 = ' checked="checked" ';
				$check2 = '';
				$disabled = 'disabled';
				if( $row['eq_presStatus'] == '1' ){
					$check1 = ' checked="checked" ';
					$check2 = '';
					$disabled = 'disabled';
				}elseif( $row['eq_presStatus'] == '2' ){
					$check1 = '';
					$check2 = ' checked="checked"  ';
					$disabled = '';
				}
			?>
            <input type="radio" name="presStatus" id="presStatus_1" class="presStatus" value="1" <?php echo $check1;?>>&nbsp;��ô�����§�����ͧ<br>
            <input type="radio" name="presStatus" id="presStatus_2" class="presStatus" value="2" <?php echo $check2;?>>&nbsp;������������§�� (����-ʡ�ż������§��) <span class="style1"> *</span>&nbsp;<input type="text" id="comment" name="comment" <?php echo $disabled; ?> value="<?php echo $row['eq_comment'];?>" style="width:170px;" onkeypress='return chaonly()'> ����Ǣ�ͧ��&nbsp;<input type="text" id="rerel" name="rerel" <?php echo $disabled; ?> value="<?php echo $row['eq_comment'];?>" style="width:170px;" onkeypress='return chaonly()'>
        </td>
    </tr>
     <tr>
    	<td align="left">
        	<b><u>�������ͧ��</u></b>
        </td>
    </tr>
    <tr>
    	<td align="left">
        	<?php
				$check1 = ' checked="checked" ';
				$check2 = '';
				if( $row['eq_stayPlace'] == '1' ){
					$check1 = ' checked="checked" ';
					$check2 = '';
				}elseif( $row['eq_stayPlace'] == '2' ){
					$check1 = '';
					$check2 = ' checked="checked"  ';
				}
			?>
        	<input type="radio" name="stayPlace" class="stayPlace" value="1" <?php echo $check1;?>>&nbsp;���������ǡѺ��ô�<br>
            <input type="radio" name="stayPlace" class="stayPlace" value="2" <?php echo $check2;?>>&nbsp;���������Ѻ��ô� (�кط������)
        </td>
    </tr>
    <tr class="show_stayPlace">
         	<td><u>�������Ѩ�غѹ</u></td>
         </tr>
        <tr class="show_stayPlace">
          <td align="left">��ҹ�Ţ��� <INPUT type="text" value="<?php echo $row['eq_address'];?>" name="address1" style="width:50px;" id="address1" onkeypress='return numonly()'/> ������ <input type="text" value="<?php echo $row['eq_village'];?>"  name="address2" style="width:50px" id="address2" onkeypress='return numonly()' /> �����ҹ <input type="text" value="<?php echo $row['eq_subvillage'];?>"  name="address8" style="width:100px" id="address8" /> ��͡/��� <input type="text" value="<?php echo $row['eq_alley'];?>"  name="address9" style="width:80px" id="address9" /> ��� <input type="text" value="<?php echo $row['eq_street'];?>" name="address3" style="width:100px;" id="address3" /> �ѧ��Ѵ <span class="style1"> *</span> <select id="address4" name="address4" onChange = "chgAmphur(this.value);"  style="width:100px;" ><option value="">�ô�к�</option>
            <?php
				$sql_Changwat = "Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = 'Changwat' ";
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					if($row['eq_code_province']==$rd['ccDigi'])
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
          </tr>
        <tr class="show_stayPlace">
          <td align="left">
        ����� <span class="style1"> *</span> <LABEL id="lblAmphur">
          	<select id="address5" name="address5" onChange = "chgTambon(this.value, '');" style="width:100px;">
            <option value="">�ô�к�</option>
            <?php
				$sql_Changwat = "Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = 'Aumpur' ";
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					if($row['eq_code_district']==$rd['ccDigi'])
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
            </LABEL> �Ӻ�  <span class="style1"> *</span> <LABEL id="lblTambon">
          <select id="address6" name="address6" style="width:100px;">
          <option value="">�ô�к�</option>
          <?php
				$sql_Changwat = "Select ccDigi,ccName,areaid,group_id,areaid FROM ccaa WHERE ccType = 'Tamboon' ";
				$results_Changwat = $con->select($sql_Changwat);
				foreach($results_Changwat as $rd){
					if($row['eq_code_parish']==$rd['ccDigi'])
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
		  ������ɳ��� <input type="text" value="<?php echo $row['eq_postcode'];?>"  name="eq_postcode" style="width:150px;" id="eq_postcode" onkeypress='return numonly()' maxlength="5" />
		  ���Ѿ�� <input type="text" value="<?php echo $row['eq_phone'];?>"  name="address7" style="width:150px;" id="address7"/>
		  ���Ѿ����Ͷ�� <input type="text" value="<?php echo $row['eq_mobilephone'];?>"  name="eq_mobilephone" style="width:150px;" id="eq_mobilephone"/></td>
          </tr>
          <tr>
          	<td align="center"><input type="button" id="save" name="save" value="�ѹ�֡" onclick="saveData();"/>&nbsp;&nbsp;<input type="button" id="cancel" name="cancel" value="¡��ԡ"/></td>
          </tr>
</table>

<script>
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




</script>
