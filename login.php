<?php 
session_start();
header ('Content-type: text/html; charset=utf-8'); 
header("Cache-Control: no-cache, must-revalidate");
session_destroy();

include('../../config/config_host.php');
include('../survey/lib/class.function.php');
$con = new Cfunction();
$con->connectDB();
?>
<script type="text/javascript" src="../js/jquery-1.10.2.js"></script>
<link rel="stylesheet" href="../reportbuilder_csg/common/font/Thai_Sans_Neue_Regular.css">
<style>
	body,td,th,a,input,select {
		font-family: Thai Sans Neue Regular;
		font-size: 18px;
		color: #000000;
	}
	
    div#div-container{
        background-color:#CCC;
        opacity:0.5;
        left:0px;
        top:0px;
        width:100%;
        height:100%;
        z-index:9999999;
        position:fixed;
        display:none;
   }
   #iframe-popup{
        left:25%;
        top:20%;
        width:50%;
        height:60%;
		background-color:#FFF;
        z-index:10000000;
        position:fixed;
        display:none;
        border:0px;
   }
   
   div#div-container1{
        background-color:#CCC;
        opacity:0.5;
        left:0px;
        top:0px;
        width:100%;
        height:100%;
        z-index:9999999;
        position:fixed;
        display:none;
   }
   #iframe-popup1{
        left:25%;
        top:20%;
        width:50%;
        height:60%;
		background-color:#FFF;
        z-index:10000000;
        position:fixed;
        display:none;
        border:0px;
   }
   
   .popup td{
	   padding:4px;
	}
</style>
<body>
<div id="div-container"></div>
<div id="iframe-popup">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="popup">
    	<tr style="background-color:#FFB1F1"><td colspan="2"><strong>ข้อมูลส่วนบุคคลสำหรับเจ้าหน้าที่ผู้รับผิดชอบ บันทึกข้อมูลฯ</strong></td></tr>
        <?php 
		$sql = "SELECT
		IF(t1.prename IS NOT NULL,t1.prename,t1.prename_short) AS prename,
		IF(t1.gender_id IS NULL,0,t1.gender_id) AS gender_id
		FROM hr_prename AS t1
		WHERE IF(t1.prename IS NOT NULL,t1.prename,t1.prename_short) != ''
		ORDER BY t1.orderby ";
		$result = mysql_db_query(DB_USERMANAGER,$sql);
		?>
        <tr>
        	<td style="font-weight:bold; width:25%">ขื่อ - นามสกุล : <font color="#FF0000">*</font></td>
            <td>
            <select id="editPrename" style="width:30%;">
            	<option value="" sex="">------- ระบุ ------</option>
                <?php
				while($obj = mysql_fetch_object($result)){
					$prename = iconv('tis-620','utf8',$obj->prename);
					echo '<option value="'.$prename.'" sex="'.$obj->gender_id.'">'.$prename.'</option>';
				}
				?>
            </select>
            <input type="text" id="editName" style="width:30%; margin-left:10px;">
            <input type="text" id="editSurname" style="width:30%; margin-left:10px;">
            </td>
        </tr>
        <tr>
        	<td style="font-weight:bold;">เพศ: <font color="#FF0000">*</font></td>
            <td>
            <div style="position:absolute; width:150px; height:20px;" id="sexSelect"></div>
            <input type="radio" name="editSex" id="sex1" value="M" readonly> ชาย
            <input type="radio" name="editSex" id="sex2" value="F" readonly> หญิง
            </td>
        </tr>
        <tr>
        	<td style="font-weight:bold;">เบอร์โทร: <font color="#FF0000">*</font></td>
            <td>
            <input type="text" id="editTel" style="width:30%;">
            </td>
        </tr>
        <tr>
        	<td style="font-weight:bold;">อีเมล์: <font color="#FF0000">*</font></td>
            <td>
            <input type="email" id="editEmail" style="width:calc(60% + 10px);">
            </td>
        </tr>
        <tr style="display:none;">
        	<td style="font-weight:bold;">รหัสผ่านเดิม: <font color="#FF0000">*</font></td>
            <td>
            <input type="text" id="editOldPass" style="width:30%;">
            </td>
        </tr>
        <tr>
        	<td style="font-weight:bold;">รหัสผ่านใหม่: <font color="#FF0000">*</font></td>
            <td>
            <input type="password" id="editNewPass" style="width:30%;"> <font style="font-size:14px;">6 หลักขึ้นไป</font>
            </td>
        </tr>
        <tr>
        	<td style="font-weight:bold;">ยืนยันรหัสผ่านใหม่: <font color="#FF0000">*</font></td>
            <td>
            <input type="password" id="editConfirmPass" style="width:30%;">
            </td>
        </tr>
        <tr>
        	<td style="font-weight:bold;"></td>
            <td>
            <input type="hidden" id="editId" value="">
            <input type="button" id="editSave" value="บันทึก">
            <input type="button" id="editCancel" value="ยกเลิก">
            </td>
        </tr>
    </table>
</div>
<div id="div-container1"></div>
<div id="iframe-popup1">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="popup">
    	<tr style="background-color:#FFB1F1"><td colspan="2"><strong>ลืมรหัสผ่านเข้าระบบ</strong></td></tr>
        <tr>
        	<td style="font-weight:bold; width:25%">ชื่อผู้ใช้ : <font color="#FF0000">*</font></td>
            <td>
            <input type="text" id="resetUser" style="width:calc(60% + 10px);">
            </td>
        </tr>
        <tr>
        	<td style="font-weight:bold;">อีเมล์ : <font color="#FF0000">*</font></td>
            <td>
            <input type="text" id="resetEmail" style="width:calc(60% + 10px);">
            </td>
        </tr>
        <tr>
        	<td style="font-weight:bold;"></td>
            <td>
            <input type="button" id="resetSave" value="บันทึก">
            <input type="button" id="resetCancel" value="ยกเลิก">
            </td>
        </tr>
	</table>
</div>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" background="../img/loginback.png">
  <tr>
    <td colspan="5" align="center"><img src="../img/login2.png" width="599" height="301"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">
    <form name="form3" id="form" method="post" action="checkuser.php">
    <table width="423" height="198" border="0" cellpadding="0" cellspacing="0"background="../img/login3.png">
      <tr>
        <td colspan="4">&nbsp;</td>
        </tr>
      <tr>
        <td width="86">&nbsp;</td>
        <td width="99"><strong>ชื่อผู้ใช้</strong></td>
        <td colspan="2">
          <label for="user"></label>
          <input name="user" type="text" id="user" maxlength="120">        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><strong>รหัสผ่าน</strong></td>
        <td colspan="2">
          <label for="pass"></label>
          <input name="pass" type="password" id="pass" maxlength="12"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="230" valign="top">
          <input type="button" name="button" id="button" value="ลงชื่อเข้าใช้" onClick="checkValue();" style="float:left;">
          <div style="margin:2px 0 0 10px; float:left;">
          <a href="javascript:void(0)" onClick="lostPassword();">ลืมรหัสผ่าน</a>
          </div>
<div style="margin-top:7px; display:none;">
<a href="http://61.19.255.77/trat_eq/application/usermanager/fblogin.php?goto=http://61.19.255.77/trat_eq/application/survey/home.php" title="เข้าสู่ระบบด้วย Facebook"><img src="../img/fblogin.png" border="0" height="19"></a>	  </div>
		  </td>
        <td width="8" valign="top"></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
    </table>
    </form>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center"><img src="../img/login1.png"></td>
  </tr>
  </table>
</body>
<script>
function lostPassword(){
	$('#div-container1').show();
	$('#iframe-popup1').show();
}

function checkValue(){
	 $.ajax({
			type: "POST",
			url: "ajax.checkuser.php",
			data: {user:$('#user').val(),pass:$('#pass').val()},
			success: function(msg){
				msg = $.trim(msg);
				var array = msg.split('::');
				if($.trim(array[0]) == 'N'){
					$('#form').submit();
				}else if(array[0] != 'N' && array[1] == '013f9627f29838c7be865f3465c6740a'){
					$('#div-container').show();
					$('#iframe-popup').show();
					$('#editId').val(array[0]);
					$('#editOldPass').val($('#pass').val());
					return false;
				}else{
					$('#form').submit();
				}
			}
     });
}

function saveData(){
	if($("#sex1").is(':checked'))
		sex = 'M';
	else
		sex = 'F';
		
	$.ajax({
			type: "POST",
			url: "ajax.saveuser.php",
			data: {id:$('#editId').val(),prename:$('#editPrename').val(),sex:sex,name:$('#editName').val(),surname:$('#editSurname').val(),tel:$('#editTel').val(),email:$('#editEmail').val(),newpass:$('#editNewPass').val()},
			success: function(msg){
				msg = $.trim(msg);
				if($.trim(msg) == 'save'){
					$('#pass').val($('#editNewPass').val());
					checkValue();
				}else{
					alert('ไม่สามารถแก้ไขข้อมูล');
					window.location = 'http://csg.dcy.go.th/index.php';	
				}
			}
     });
}

function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
}

$(document).ready(function(){
	$('#editPrename').change(function(){
		if($('option:selected', this).attr('sex') == '1'){
			$('#sexSelect').css('display','block');
			$('#sex1').prop('checked',true);	
		}else if($('option:selected', this).attr('sex') == '2'){
			$('#sexSelect').css('display','block');
			$('#sex2').prop('checked',true);	
		}else{
			$('#sexSelect').css('display','none');
			$('#sex1').prop('checked', false);
			$('#sex2').prop('checked',false);	
		}
	});
	
	 $('#div-container').click(function(){
		$('#div-container').hide();
		$('#iframe-popup').hide();
	 });
	 
	 $('#div-container1').click(function(){
		$('#div-container1').hide();
		$('#iframe-popup1').hide();
	 });
	 
	 $('#editSave').click(function(){
		 var errorText = '';
		 if($.trim($('#editPrename').val()) == ''){
			 errorText += '- กรุณาระบุคำนำหน้าชื่อ\n';
		 }
		 
		 if($.trim($('#editName').val()) == ''){
			 errorText += '- กรุณาระบุชื่อ\n';
		 }
		 
		 if($.trim($('#editSurname').val()) == ''){
			 errorText += '- กรุณาระบุนามสกุล\n';
		 }
		 
		 if($.trim($('#editTel').val()) == ''){
			 errorText += '- กรุณาระบุเบอร์โทรศัพท์\n';
		 }
		 
		 if($.trim($('#editEmail').val()) == ''){
			 errorText += '- กรุณาระบุอีเมล์\n';
		 }else if(validateEmail($('#editEmail').val()) === false){
			 errorText += '- กรุณากรอกรูปแบบอีเมล์ให้ถูกต้อง\n';
		 }
		 
		 if($.trim($('#editOldPass').val()) == ''){
			 errorText += '- กรุณาระบุรหัสผ่่านเดิม\n';
		 }
		 
		 if($.trim($('#editNewPass').val()) == ''){
			 errorText += '- กรุณาระบุรหัสผ่่านใหม่\n';
		 }else if($.trim($('#editNewPass').val()).length < 6 ){
			 errorText += '- กำหนดรหัสผ่านใหม่ ยาว 6 หลักขึ้นไป\n';
		 }else if($.trim($('#editNewPass').val()) == $.trim($('#pass').val())){
			 errorText += '- กรุณาระบุรหัสผ่่านใหม่ ที่ไม่ใช่ '+$('#pass').val()+'\n';
		 }
		 
		 if($.trim($('#editConfirmPass').val()) == ''){
			 errorText += '- กรุณาระบุยืนยันรหัสผ่่านใหม่\n';
		 }else if($.trim($('#editNewPass').val()) != $.trim($('#editConfirmPass').val())){
			 errorText += '- กรุณาระบุรหัสผ่่านใหม่และยืนยันรหัสผ่านให้ตรงกัน\n';
		 }
		 
		 
		 
		 if(errorText == ''){
			 saveData();
		 }else{
			 alert(errorText);
			 return false;
		 }
	 });
	 
	 $('#editCancel').click(function(){$('#div-container').click();});
	 
	 <?php if($_POST['user'] != ''){ ?>
	 	$('#user').val('<?php echo $_POST['user']?>');
		$('#pass').val('<?php echo $_POST['pass']?>');
		$('#button').click();
	 <?php } ?>
 });
</script>