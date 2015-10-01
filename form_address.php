<?php
/**
* @comment บันทึกข้อมูลที่อยู่อาศัยของสมาชิก
* @projectCode G56WANDC02
* @tor  -
* @package core
* @author Atiphat phakam
* @access private
* @created 20/05/2014
*/

if($_POST['id'] == ''){ //add
	if($_POST['country'] == 1){
		$sql_insert = "INSERT INTO personal_address(p_id, house_number, alley, road, village_id, subdistrict_id, district_id,
																		 province_id, country_id, zip_code, phone_number, gid, record_date, last_update, staffid,addr_type_1,addr_type_2,addr_type_3,addr_type_4,home_position,home_number,home_building,homenumber,namehome) 
							VALUES ('".$_POST['p_id']."',
										'".$_POST['house_number']."',
										'".$_POST['alley']."',
										'".$_POST['road']."',
										'".$_POST['village_id']."',
										'".$_POST['subdistrict_id']."',
										'".$_POST['district_id']."',
										'".$_POST['province_id']."',
										 '210',
										'".$_POST['zip_code']."',
										'".$_POST['phone_num']."',
										'".GID."',
										 now(),
										 now(),
										'".STAFFID."',
										'".$_POST['addr_type_1']."',
										'".$_POST['addr_type_2']."',
										'".$_POST['addr_type_3']."',
										'".$_POST['addr_type_4']."',
										'".$_POST['home_position']."',
										'".$_POST['home_number']."',
										'".$_POST['home_building']."',
										'".$_POST['homenumber']."',
										'".$_POST['namehome']."'
										)"; /* 210 = Thailand */
		//echo $sql_insert;
		$query = mysql_query($sql_insert);
		
		if($query){
				echo "<script>
				alert('บันทึกข้อมูลเรียบร้อยแล้ว');
				window.location='?p=form_address&p_id=".$_POST['p_id']." &p_join_number=".$_POST['p_join_number']."';
				</script>";
				exit();	
			}else{
				echo "<script>
				alert('ไม่สามารถบันทึกข้อมูลได้');
				window.location='?p=form_address&p_id=".$_POST['p_id']."&p_join_number=".$_POST['p_join_number']."';
				</script>";
				exit();	
			}
	
	}
	
	if($_POST['country'] == 2){
		
		$sql_insert = "INSERT INTO personal_address(p_id, p_address, country_id, gid, record_date, last_update, staffid) 
							VALUES ('".$_POST['p_id']."',
										'".$_POST['p_address']."',
										'".$_POST['country_id']."',
										'".GID."',
										 now(),
										 now(),
										'".STAFFID."'
										)"; 
		//echo $sql_insert;								
		$query = mysql_query($sql_insert);
		
		if($query){
				echo "<script>
				alert('บันทึกข้อมูลเรียบร้อยแล้ว');
				window.location='?p=form_address&p_id=".$_POST['p_id']."&p_join_number=".$_POST['p_join_number']."';
				</script>";
				exit();	
			}else{
				echo "<script>
				alert('ไม่สามารถบันทึกข้อมูลได้');
				window.location='?p=form_address&p_id=".$_POST['p_id']."&p_join_number=".$_POST['p_join_number']."';
				</script>";
				exit();
			}
	}
}

if($_POST['id'] != ''){ //update
	if($_POST['country'] == 1){
	
		$sql_update = "UPDATE personal_address SET 
							p_address = '',
							house_number = '".$_POST['house_number']."',
							alley = '".$_POST['alley']."',
							road = '".$_POST['road']."',
							village_id = '".$_POST['village_id']."',
							subdistrict_id = '".$_POST['subdistrict_id']."', 
							district_id = '".$_POST['district_id']."',
							province_id = '".$_POST['province_id']."',
							country_id = '210',
							zip_code = '".$_POST['zip_code']."', 
							phone_number = '".$_POST['phone_num']."',
							gid = '".GID."', 
							last_update = now(),
							staffid = '".STAFFID."',
							home_position = '".$_POST['home_position']."',
							home_number = '".$_POST['home_number']."',
							home_building = '".$_POST['home_building']."',
							       homenumber =     '".$_POST['homenumber']."',
									namehome =	'".$_POST['namehome']."'

							WHERE id = '".$_POST['id']."'
									"; /* 210 = Thailand */
		//echo $sql_update;
		$query = mysql_query($sql_update);
		
		if($query){
				echo "<script>
				alert('บันทึกข้อมูลเรียบร้อยแล้ว');
				window.location='?p=form_address&p_id=".$_POST['p_id']."&p_join_number=".$_POST['p_join_number']."';
				</script>";
				exit();	
			}else{
				echo "<script>
				alert('ไม่สามารถบันทึกข้อมูลได้');
				window.location='?p=form_address&p_id=".$_POST['p_id']."&p_join_number=".$_POST['p_join_number']."';
				</script>";
				exit();
			}
	
	}
	
	if($_POST['country'] == 2){
		
		$sql_update = "UPDATE personal_address SET
								p_address = '".$_POST['p_address']."',
								country_id = '".$_POST['country_id']."', 
								gid = '".GID."',
								last_update = now(), 
								staffid = '".STAFFID."'
								
								WHERE id = '".$_POST['id']."'	
										"; 
		//echo $sql_update;								
		$query = mysql_query($sql_update);
		
		if($query){
				echo "<script>
				alert('บันทึกข้อมูลเรียบร้อยแล้ว');
				window.location='?p=form_address&p_id=".$_POST['p_id']."&p_join_number=".$_POST['p_join_number']."';
				</script>";
				exit();	
			}else{
				echo "<script>
				alert('ไม่สามารถบันทึกข้อมูลได้');
				window.location='?p=form_address&p_id=".$_POST['p_id']."&p_join_number=".$_POST['p_join_number']."';
				</script>";
				exit();
			}
	}

}

//delete
if($_GET['action'] == "delete"){
	$sql_delete = "DELETE FROM personal_address WHERE id = ".$_GET['del_id'];
	$query = mysql_query($sql_delete);
	
	if($query){
				echo "<script>
				alert('ลบข้อมูลเรียบร้อยแล้ว');
				window.location='?p=form_address&p_id=".$_GET['p_id']."&p_join_number=".$_GET['p_join_number']."';
				</script>";
				exit();	
			}else{
				echo "<script>
				alert('ไม่สามารถลบข้อมูลได้');
				window.location='?p=form_address&p_id=".$_GET['p_id']."&p_join_number=".$_GET['p_join_number']."';
				</script>";
				exit();
			}
}

//update type ที่อยู่
if($_GET['action'] == "addtype"){
	
	
	$sql_list = "SELECT * FROM personal_address WHERE p_id ='$_POST[p_id]'";
			$res_list = mysql_query($sql_list);
			
			$i = 1;
			while($add_list = mysql_fetch_assoc($res_list)){
				
				if($_POST['addr_type_1'] == $i){
					$add1 = 2;
				}else{
					$add1 = 1;
				}
				
				if($_POST['addr_type_2'] == $i){
					$add2 = 2;
				}else{
					$add2 = 1;
				}
				
				if($_POST['addr_type_3'] == $i){
					$add3 = 2;
				}else{
					$add3 = 1;
				}
				
				if($_POST['addr_type_4'] == $i){
					$add4 = 2;
				}else{
					$add4 = 1;
				}
				
				$sql_update = "UPDATE personal_address SET 
									addr_type_1 = '$add1',
									addr_type_2 = '$add2',
									addr_type_3 = '$add3',
									addr_type_4 = '$add4'
									WHERE
									id = '".$add_list['id']."'
									
									";
				
				//echo $sql_update."<br>";
				mysql_query($sql_update);
				$i++;
			}
	
}



//func เอาชื่อ จังหวัด อำเภอ ตำบล หมู่บ้าน ประเทศ
function get_address_name($id, $type){ 

	if($type == "country"){
		$res = mysql_query("SELECT country_name_th FROM countries WHERE id = '$id' ");
		$res_name = mysql_fetch_assoc($res);
		return $res_name['country_name_th'];
	}
	
	if($type == "village"){
		$res = mysql_query("SELECT ccName FROM ccaa_village WHERE ccDigi = '$id' ");
		$res_name = mysql_fetch_assoc($res);
		return $res_name['ccName'];
	}
	
	if($type == "thai"){
		$res = mysql_query("SELECT ccName FROM ccaa WHERE ccDigi = '$id' ");
		$res_name = mysql_fetch_assoc($res);
		return $res_name['ccName'];
	}

	return '';
}
								

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title></title>
<script src="../../common/jquery-1.8.2.min.js"></script>
<script src="js/function_person.js"></script>
<script>

$(document).ready(function(){
	
$("input[type='radio']").click(function(){
				  var previousValue = $(this).attr('previousValue');
				  var name = $(this).attr('name');
				
				  if (previousValue == 'checked')
				  {
					$(this).removeAttr('checked');
					$(this).attr('previousValue', false);
				  }
				  else
				  {
					$("input[name="+name+"]:radio").attr('previousValue', false);
					$(this).attr('previousValue', 'checked');
				  }
				});
   $("#country1").click(function(event){
   		$("#in_thai").show();
	  	$("#not_thai").hide();
		$("#country_id").attr('disabled','disabled');
   });
   
   $("#country2").click(function(event){
   		$("#in_thai").hide();
	  	$("#not_thai").show();
		$("#country_id").removeAttr('disabled');
   });
   
 });
 
 function chgAmphur(PvID){
	link_page = 'ajax.chgamphur.php?PvID='+ PvID;
	
	$.get(link_page, function(data) {
	
		$('#distric_box').html(data);
	});
}

function chgTambon(TbID){
	link_page = 'ajax.chgtambon.php?TbID='+ TbID;
	
	$.get(link_page, function(data) {
	
		$('#subDistric_box').html(data);
	});
}
 
 function chgMoo(MooID){
	link_page = 'ajax.chgmoo.php?MooID='+ MooID;
	
	$.get(link_page, function(data) {
	
		$('#village_box').html(data);
	});
}

function del_confirm(id) {
		if ( confirm("คุณต้องการลบข้อมูลจริงหรือไม่?") == true ) {
			location.href='index.php?p=form_address&p_id=<?php echo $_GET['p_id'];?>&action=delete&del_id='+id+'&p_join_number=<?php echo $_GET['p_join_number'];?>';
		}
}
 function check_specail_cha(text){
	var  special_cha = /([.*+?^=!:@${}()|\[\]\/\\])/g ;
	return special_cha.test(text);
 }
 function check_specail_cha2(text){
	var  special_cha = /([.*+?^=!:@${}()|\[\]\\])/g ;
	return special_cha.test(text);
 }
 
 function IsNumeric(input){    
	var RE = /^-?(0|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/;   
	return (RE.test(input));  
} 

 
function chkform(){
	var country = document.getElementsByName('country').item(0).checked;
	var country2 = document.getElementsByName('country').item(1).checked;
	
	if( country == false && country2 == false){
		alert('เลือกประเทศ');
		return false;
		
	}
	if(form1.country2.checked == true){
		 if(form1.country_id.value == ''){
			 alert('ระบุประเทศ');
			 form1.country_id.focus();
			 return false;
		}
         if(form1.p_address.value == ''){
			 alert('ระบุที่อยู่');
			 form1.p_address.focus();
			 return false;
		}
		if(form1.p_address.value != ''){
				if(check_specail_cha2(form1.p_address.value)){
					alert('ตรวจสอบที่อยู่');
					return false;
				}
			}
	}else{
		
			if(form1.house_number.value != ''){
				if(check_specail_cha2(form1.house_number.value)){
					alert('ตรวจสอบบ้านเลขที่');
					return false;
				}
			}
			
			if(form1.alley.value != ''){
				if(check_specail_cha(form1.alley.value)){
					alert('ตรวจสอบซอย');
					return false;
				}
			}
			
			if(form1.road.value != ''){
				if(check_specail_cha(form1.road.value)){
					alert('ตรวจสอบถนน');
					return false;
				}
			}
			
			
			
			
		if(form1.province_id.value == ''){
			 alert('ระบุจังหวัด');
			 form1.province_id.focus();
			 return false;
		}	
		
		if(form1.zip_code.value != ''){
			if(!IsNumeric(form1.zip_code.value)){
				alert('ตรวจสอบรหัสไปรษณีย์');
				return false;
			}
		}
		
		
	}
	
	
	return true;
}
function Filter_Keyboard(e) {
	  var keycode = (e.keyCode)?e.keyCode:e.charCode;
	  if( keycode >=37 && keycode <=40 ) return true;  // arrow left, up, right, down  
	  if( keycode >=48 && keycode <=57 ) return true;  // key 0-9
	  if( keycode >=96 && keycode <=105 ) return true;  // numpad 0-9
	  if( keycode ==110 || keycode ==190  ) return true;  // dot
	  if( keycode ==8  ) return true;  // backspace
	  if( keycode ==9 ) return true;  // tab
	  if( keycode ==45 ||  keycode ==46 || keycode ==35 || keycode ==36) return true;  // insert, del, end, home
	  if( keycode ==17 ||  keycode ==86 ) return true;  // ctrl+v
	  return false;
	}
</script>

</head>

<img src="index_files/Folder-icon.png" alt="" width="21" height="21" align="absmiddle" /> <span class="redlink">แบบฟอร์มบันทึกประวัติที่อยู่อาศัยของผู้ใช้บริการ</span>
<!--popup address-->
<table align="right"><td>
 <a href="index.php?p=form_address&p_id=<?php echo $_GET['p_id'];?>&p_join_number=<?php echo $_GET['p_join_number'] ?>&action=add"><img src="index_files/icon_add.png" align="absmiddle" width="25" class="img_icon" title=""><strong>&nbsp;เพิ่มข้อมูลที่อยู่อาศัย</strong></a></td></table>
</br>
<!--popup address-->


<!--////////////////////////////////////////////////////////////////////////////////////// form1 //////////////////////////////////////////////////////////-->

<?php


if($_GET['action'] == "add"){ 
	
	
	?>
<form id="form1" name="form1" method="post" action="index.php?p=form_address&p_id=<?php echo $_GET['p_id'];?>&p_join_number=<?php echo  $_GET['p_join_number'];?>" onSubmit="return chkform();">

<input type="hidden" id="id" name="id" value="<?php echo $_GET['id'];?>">
<input type="hidden" name="p_id" value="<?php echo $p_id;?>"/>
<input type="hidden" name="p_join_number" value="<?php echo $p_join_number;?>"/>

<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" id="addtable" bgcolor="#BBCEDD">
  <tbody>
    <tr bgcolor="#FFFFFF">
      <td width="27%" align="right">ประเทศ<span style="color:#F00">*</span> :</td>
      <td width="73%" align="left">
      	<input type="radio" name="country" id="country1" value="1" <?php if($_GET['action'] == "edit"){echo $country_chk;}else{echo "checked='checked'";}?> /> &nbsp;ไทย&nbsp;
        <input type="radio" name="country" id="country2" value="2" <?php if($_GET['action'] == "edit"){echo $country_chk1;}?>/>&nbsp;ประเทศอื่นๆ
        <select name="country_id" id="country_id" <?php if($_GET['action'] == "edit"){echo $country_cho;}else{echo "disabled";}?> >
          <option value="">เลือกประเทศ</option>
          <?php
		  		$res_sql = mysql_query("SELECT countries.id, countries.country_name_th FROM countries WHERE id != 210 ");
				while( $ram = mysql_fetch_array($res_sql) ) {
								if($ram['id']==$row_edit['country_id']) $sel = "SELECTED"; else $sel="";
								echo "<option value=\"".$ram['id']."\" $sel>".$ram['country_name_th']."</option>\n";
								$sel="";
						}  
		  ?>
        </select>
        </td>
    </tr>
    <tr>
      <td height="24" colspan="2" bgcolor="#FFFFFF">
      
      <div id="in_thai" <?php if($_GET['action'] == "edit"){if($live_in_thai){echo "style='display:none'";}} ?>>
      <table width="100%" border="0" cellspacing="1" cellpadding="2" id="thai_detail">
        <tbody>
          <tr>
            <td width="27%" height="24" align="right">บ้านเลขที่ :</td>
            <td width="73%"><input name="house_number" type="text" id="house_number" value="<?php echo $row_edit['house_number'];?>" onKeyUp="chkHouseNum(this.value,this);" /></td>
           
          </tr>
		            <tr>
            <td width="27%" height="24" align="right">หมู่ที่ :</td>
            <td width="73%"><input name="homenumber" type="text" id="homenumber" value="<?php echo $row_edit['homenumber'];?>" onKeyUp="chkHouseNum(this.value,this);" /></td>
           
          </tr>
		            <tr>
            <td width="27%" height="24" align="right">หมู่บ้าน :</td>
            <td width="73%"><input name="namehome" type="text" id="namehome" value="<?php echo $row_edit['namehome'];?>" onKeyUp="chkHouseNum(this.value,this);" /></td>
           
          </tr>
		   <tr>
            <td width="27%" height="24" align="right">ตึก  :</td>
            <td width="73%"><input name="home_building" type="text" id="home_building" value="<?php echo $row_edit['home_building'];?>" onKeyUp="chkHouseNum(this.value,this);" /></td>
                </tr>
              <tr>
            <td width="27%" height="24" align="right">ชั้น  :</td>
            <td width="73%"><input name="home_position" type="text" id="home_position" value="<?php echo $row_edit['home_position'];?>" onKeyUp="chkHouseNum(this.value,this);" /></td>
           
          </tr>
            <tr>
            <td width="27%" height="24" align="right">เลขที่ห้อง  :</td>
            <td width="73%"><input name="home_number" type="text" id="home_number" value="<?php echo $row_edit['home_number'];?>" onKeyUp="chkHouseNum(this.value,this);" /></td>
                </tr>
               
          <tr>
            <td width="27%" height="24" align="right">ซอย :</td>
            <td width="73%"><input name="alley" type="text" id="alley" onKeyUp="chkSoi(this.value,this)" value="<?php echo $row_edit['alley'];?>" maxlength="150" /></td>
          </tr>
       
          <tr>
            <td height="24" align="right">ถนน :</td>
            <td align=""><input name="road" type="text" id="road" value="<?php echo $row_edit['road'];?>" onKeyUp="isThaichar(this.value,this)" />
            </td>
          </tr>
          <tr>
            <td height="24" align="right" >จังหวัด<span style="color:#F00">*</span>&nbsp;:</td>
            <td><strong>
              <select name="province_id" id="province_id" onChange="chgAmphur(this.value);">
              <?php
						 echo "<OPTION value=\"\">เลือกจังหวัด</OPTION>\n";
						$prov_res = mysql_query("SELECT ccDigi,ccName,ccType FROM ccaa WHERE ccType='Changwat' ORDER BY ccName");
						while( $prov_row = mysql_fetch_array($prov_res) ) {
								if($prov_row['ccDigi']==$row_edit['province_id']) $sel = "SELECTED"; else $sel="";
								echo "<option value=\"".$prov_row['ccDigi']."\" $sel>".str_replace("จังหวัด","",$prov_row['ccName'])."</option>\n";
								$sel="";
						}
				?>
              </select>
            </strong></td>
          </tr>
          <tr>
            <td height="24" align="right">อำเภอ&nbsp;:</td>
            <td>
            <div id="distric_box"> 
							<select name="district_id" id="district_id" onChange="chgTambon(this.value);">
							<OPTION value="">เลือกอำเภอ</OPTION>
						<?php 	
							if($_GET['action'] == "edit"){
							$lock =  substr($rs['province'], 0, 2);
							$am = mysql_query("SELECT ccDigi,ccName,ccType FROM ccaa WHERE ccType='Aumpur' AND ccDigi LIKE '".substr($row_edit['province_id'],0,2)."%' ");
							while( $ram = mysql_fetch_array($am) ) {
								$slted = ( $ram['ccDigi'] == $row_edit['district_id'] ) ? "selected" : "";
								echo "<option value=\"".$ram['ccDigi']."\" $slted>".$ram['ccName']."</option>\n";
								$slted="";
							}
						} ?>
              </select>
            </div>
           </td>
          </tr>
          <tr>
            <td height="24" align="right">ตำบล&nbsp;:</td>
            <td>
             	<div id="subDistric_box"> 
                <select name="subdistrict_id" id="subdistrict_id" onChange="chgMoo(this.value);">
                <OPTION value="">เลือกตำบล</OPTION>
				 	<?php 
						if($_GET['action'] == "edit"){
							if($row_edit['district_id'] != ""){
								$am = mysql_query("SELECT ccDigi,ccName,ccType FROM ccaa WHERE ccType='Tamboon' AND ccDigi LIKE '".substr($row_edit['district_id'],0,4)."%'  ");
								while( $ram = mysql_fetch_array($am) ) {
									$slted = ( $ram['ccDigi'] == $row_edit['subdistrict_id'] ) ? "selected" : "";
									echo "<option value=\"".$ram['ccDigi']."\" $slted>".$ram['ccName']."</option>\n";
									$slted="";
								}
							}
						} ?>
                </select>
                </div>
              </td>
          </tr>
          <tr>
          </tr>
          <tr>
            <td height="24" align="right">รหัสไปรษณีย์ :</td>
            <td><input name="zip_code" type="text" id="zip_code"  value="<?php echo $row_edit['zip_code'];?>" size="10" maxlength="5" onKeyDown="return Filter_Keyboard(event);" /></td>
          </tr>
          <?php 
// @modify Panupong Kiangmana 24/6/2557 function add/edit/delete phone number by jquery		  
		  ?>
          <script type="text/javascript">
          $(function(){
		  var xx= 0;
		  var yy = '<?php echo $num_of_tel; ?>';
		  var yy =  parseInt(yy);
				   $('#add_tel2').click(function(){
					   yy= yy +1; 
						var box_tel = '<tr id="root_tr'+xx+'"><td height="24" align="right">หมายเลขโทรศัพท์ :</td> <td><strong><input class="tel" name="phone_number'+yy+'" type="text" id="phone_number'+yy+'"  maxlength="50" onKeyDown="return Filter_Keyboard(event);" /><input id="del_tel'+yy+'" class="del_tel_btn" type="button" value="ลบหมายเลข"/></strong></td></tr>';
						$('#root_tr').parent().append(box_tel).find('tr td .del_tel_btn').click(function(){
								  $(this).parent().parent().parent().remove();
								  sensitivekey2();
						}).end();
					  $('input').keyup(function(){
							sensitivekey2();
						});
				  });
				  
				  $('#add_tel').click(function(){
					   xx= xx +1;
						var box_tel = '<tr id="root_tr'+xx+'"><td height="24" align="right">หมายเลขโทรศัพท์ :</td> <td><strong><input class="tel" name="phone_numberx'+xx+'" type="text" id="phone_numberx'+xx+'"  maxlength="50" onKeyDown="return Filter_Keyboard(event);" /><input id="del_tel'+xx+'" class="del_tel_btn" type="button" value="ลบหมายเลข"/></strong></td></tr>';
						$('#root_tr').parent().append(box_tel).find('tr td .del_tel_btn').click(function(){
								  $(this).parent().parent().parent().remove();
								  sensitivekey();
						}).end();
					  $('input').keyup(function(){
							sensitivekey();
						});
				  });
		  
			  function sensitivekey(){
					text = $('#phone_numberx').val();
					for(i = 1; i<=xx; i++){
						if($('#phone_numberx'+i).val() === undefined || $('#phone_numberx'+i).val() == ""){
						}else{
							var text = text +',' + $('#phone_numberx'+i).val()
						}
					}
					$('#phone_num1').attr('value',text);
			  }
			  
			  function sensitivekey2(){
					text = $('#phone_number').val();
					for(i = 0; i<=20; i++){
						if($('#phone_number'+i).val() === undefined || $('#phone_number'+i).val() == ""){
						}else{
							var text = text +',' + $('#phone_number'+i).val()
						}
					}
					$('#phone_num').attr('value',text);
			  }
				  // mode ปกติ
				  $('input').keyup(function(){
						sensitivekey();
						sensitivekey2();
					});
					
					$('tr td .del_tel_btn').click(function(){
								  $(this).parent().parent().parent().remove();
								  sensitivekey2();
					});
		  });
		  
          </script>
          <?php if($_GET['action'] == "edit"){ ?>
          <tr id="root_tr">
            <td height="24" align="right">หมายเลขโทรศัพท์ :</td>
            <td><strong>
              <input type="hidden" id="phone_num" name="phone_num" value="<?php echo $row_edit['phone_number']; ?>"  />
              <input  class="tel" name="phone_number" type="text" id="phone_number" value="<?php echo $tele[0]?>" maxlength="50" onKeyDown="return Filter_Keyboard(event);" />
            </strong>
            <input type="button" id="add_tel2" value="เพิ่มหมายเลขโทรศัพท์"/>
            </td>
          </tr>
          
          <?php 
		  for($i=2;$i<=$num_of_tel;$i++){ ?>
			  <tr>
            <td height="24" align="right">หมายเลขโทรศัพท์ :</td>
            <td>
            <strong>
              <input  class="tel" name="phone_number<? echo $i;?>" type="text" id="phone_number<? echo $i;?>" value="<?php echo $tele[$i-1]?>" maxlength="50" onKeyDown="return Filter_Keyboard(event);" />
              <input id="del_tel<? echo $i;?>" class="del_tel_btn" type="button" value="ลบหมายเลข"/>
            </strong>
            </td>
          </tr>
		<?  }
         } else{ ?>
        <tr id="root_tr">
            <td height="24" align="right">หมายเลขโทรศัพท์ :</td>
            <td><strong>
              <input type="hidden" id="phone_num1" name="phone_num" />
              <input  class="tel" name="phone_number" type="text" id="phone_numberx"  maxlength="50" onKeyDown="return Filter_Keyboard(event);" />
            </strong>
            <input type="button" name="add_tel" id="add_tel" class="original_add" value="เพิ่มหมายเลขโทรศัพท์" />
            </td>
          </tr>
		  <?  }
		  // @end
		   ?>
          <tbody>
          </table>
          
      </div>
      <div id="not_thai" <?php if($_GET['action'] == "edit"){if(!$live_in_thai){echo "style='display:none'";}}else{echo "style='display:none'";} ?> >
        <table width="98%" border="0">
          <tr>
            <td width="27%" align="right" valign="top">ที่อยู่<span style="color:#F00">*</span> :</td>
            <td width="73%"><label for="p_address"></label>
              <textarea name="p_address" cols="50" rows="3" id="p_address" ><?php echo $row_edit['p_address'];?></textarea></td>
          </tr>
          <tr>
            <td height="24" align="right">&nbsp;</td>
           
        </table>
      </div>
	  <table align="center" style="margin-top:30px;">
          <tr>
            <td height="24" align="right">&nbsp;</td>
            <td><input type="submit"  name="btn_submit" id="btn_submit" value="บันทึก" /></td>
			<!-- ยกเลิกค่่า เมือedit -->
			<?php
			if($_GET['action'] == "edit"){
		   ?>
			<td><input type="button"  name="cancle" id="button4" value="ยกเลิก" onClick="window.location.href='?p=form_address&p_id=<?php echo $_GET['p_id'] ?>&p_join_number=<?php echo $_GET['p_join_number'] ?>'"  /></td>
		   <?php
		   }else{
			?> 
			<td><input type="button"  name="cancle" id="button4" value="ยกเลิก" onClick="window.location.href='?p=form_address&p_id=<?php echo $_GET['p_id'] ?>&p_join_number=<?php echo $_GET['p_join_number'] ?>'"  /></td>
			<td><input type="reset"  name="cancle" id="button4" value="ล้างค่า" /></td>
			
			<?php 		

		   }
			?>
              
          </tr>
		  <!-- ยกเลิกค่่า เมือedit -->
      </table>
      </td>
    </tr>
  </tbody>
</table>


</form>
<?php
}else if($_GET['action'] == "edit"){
$sql_edit = "SELECT *
					FROM
					personal_address
					WHERE
					id = '".$_GET['id']."'";	
	$res_edit = mysql_query($sql_edit);
	$row_edit = mysql_fetch_assoc($res_edit);
	
	$row_edit['phone_number'];
	$tele = explode(',' , $row_edit['phone_number']);
	$num_of_tel= count($tele);
	
	if($row_edit['p_address'] ==''){  //ตอน edit check เลือก ไทย ต่างประเทศ
		$live_in_thai = 0; //เอาไว้ show div box ให้ตรงกะ radio กรณีแก้ไข
		$country_chk = "checked='checked'";
		$country_cho = "disabled";
	}else{
		$live_in_thai = 1;
		$country_chk1 = "checked='checked'";
	}


?>
<form id="form1" name="form1" method="post" action="index.php?p=form_address&p_id=<?php echo $_GET['p_id'];?>&p_join_number=<?php echo  $_GET['p_join_number'];?>" onSubmit="return chkform();">

<input type="hidden" id="id" name="id" value="<?php echo $_GET['id'];?>">
<input type="hidden" name="p_id" value="<?php echo $p_id;?>"/>
<input type="hidden" name="p_join_number" value="<?php echo $p_join_number;?>"/>

<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" id="addtable" bgcolor="#BBCEDD">
  <tbody>
    <tr bgcolor="#FFFFFF">
      <td width="27%" align="right">ประเทศ<span style="color:#F00">*</span> :</td>
      <td width="73%" align="left">
      	<input type="radio" name="country" id="country1" value="1" <?php if($_GET['action'] == "edit"){echo $country_chk;}else{echo "checked='checked'";}?> /> &nbsp;ไทย&nbsp;
        <input type="radio" name="country" id="country2" value="2" <?php if($_GET['action'] == "edit"){echo $country_chk1;}?>/>&nbsp;ประเทศอื่นๆ
        <select name="country_id" id="country_id" <?php if($_GET['action'] == "edit"){echo $country_cho;}else{echo "disabled";}?> >
          <option value="">เลือกประเทศ</option>
          <?php
		  		$res_sql = mysql_query("SELECT countries.id, countries.country_name_th FROM countries");
				while( $ram = mysql_fetch_array($res_sql) ) {
								if($ram['id']==$row_edit['country_id']) $sel = "SELECTED"; else $sel="";
								echo "<option value=\"".$ram['id']."\" $sel>".$ram['country_name_th']."</option>\n";
								$sel="";
						}  
		  ?>
        </select>
        </td>
    </tr>
    <tr>
      <td height="24" colspan="2" bgcolor="#FFFFFF">
      
      <div id="in_thai" <?php if($_GET['action'] == "edit"){if($live_in_thai){echo "style='display:none'";}} ?>>
      <table width="100%" border="0" cellspacing="1" cellpadding="2" id="thai_detail">
        <tbody>
          <tr>
            <td width="27%" height="24" align="right">บ้านเลขที่ :</td>
            <td width="73%"><input name="house_number" type="text" id="house_number" value="<?php echo $row_edit['house_number'];?>" onKeyUp="chkHouseNum(this.value,this);" /></td>
           
          </tr>
		            <tr>
            <td width="27%" height="24" align="right">หมู่ที่ :</td>
            <td width="73%"><input name="homenumber" type="text" id="homenumber" value="<?php echo $row_edit['homenumber'];?>" onKeyUp="chkHouseNum(this.value,this);" /></td>
           
          </tr>
		            <tr>
            <td width="27%" height="24" align="right">หมู่บ้าน :</td>
            <td width="73%"><input name="namehome" type="text" id="namehome" value="<?php echo $row_edit['namehome'];?>" onKeyUp="chkHouseNum(this.value,this);" /></td>
           
          </tr>
		   <tr>
            <td width="27%" height="24" align="right">ตึก  :</td>
            <td width="73%"><input name="home_building" type="text" id="home_building" value="<?php echo $row_edit['home_building'];?>" onKeyUp="chkHouseNum(this.value,this);" /></td>
                </tr>
              <tr>
            <td width="27%" height="24" align="right">ชั้น  :</td>
            <td width="73%"><input name="home_position" type="text" id="home_position" value="<?php echo $row_edit['home_position'];?>" onKeyUp="chkHouseNum(this.value,this);" /></td>
           
          </tr>
            <tr>
            <td width="27%" height="24" align="right">เลขที่ห้อง  :</td>
            <td width="73%"><input name="home_number" type="text" id="home_number" value="<?php echo $row_edit['home_number'];?>" onKeyUp="chkHouseNum(this.value,this);" /></td>
                </tr>
               
          <tr>
            <td width="27%" height="24" align="right">ซอย :</td>
            <td width="73%"><input name="alley" type="text" id="alley" onKeyUp="chkSoi(this.value,this)" value="<?php echo $row_edit['alley'];?>" maxlength="150" /></td>
          </tr>
       
          <tr>
            <td height="24" align="right">ถนน :</td>
            <td align=""><input name="road" type="text" id="road" value="<?php echo $row_edit['road'];?>" onKeyUp="isThaichar(this.value,this)" />
            </td>
          </tr>
          <tr>
          <tr>
            <td height="24" align="right" >จังหวัด<span style="color:#F00">*</span>&nbsp;:</td>
            <td><strong>
              <select name="province_id" id="province_id" onChange="chgAmphur(this.value);">
              <?php
						 echo "<OPTION value=\"\">เลือกจังหวัด</OPTION>\n";
						$prov_res = mysql_query("SELECT ccDigi,ccName,ccType FROM ccaa WHERE ccType='Changwat' ORDER BY ccName");
						while( $prov_row = mysql_fetch_array($prov_res) ) {
								if($prov_row['ccDigi']==$row_edit['province_id']) $sel = "SELECTED"; else $sel="";
								echo "<option value=\"".$prov_row['ccDigi']."\" $sel>".str_replace("จังหวัด","",$prov_row['ccName'])."</option>\n";
								$sel="";
						}
				?>
              </select>
            </strong></td>
          </tr>
          <tr>
            <td height="24" align="right">อำเภอ&nbsp;:</td>
            <td>
            <div id="distric_box"> 
							<select name="district_id" id="district_id" onChange="chgTambon(this.value);">
							<OPTION value="">เลือกอำเภอ</OPTION>
						<?php 	
							if($_GET['action'] == "edit"){
							$lock =  substr($rs['province'], 0, 2);
							$am = mysql_query("SELECT ccDigi,ccName,ccType FROM ccaa WHERE ccType='Aumpur' AND ccDigi LIKE '".substr($row_edit['province_id'],0,2)."%' ");
							while( $ram = mysql_fetch_array($am) ) {
								$slted = ( $ram['ccDigi'] == $row_edit['district_id'] ) ? "selected" : "";
								echo "<option value=\"".$ram['ccDigi']."\" $slted>".$ram['ccName']."</option>\n";
								$slted="";
							}
						} ?>
              </select>
            </div>
           </td>
          </tr>
          <tr>
            <td height="24" align="right">ตำบล&nbsp;:</td>
            <td>
             	<div id="subDistric_box"> 
                <select name="subdistrict_id" id="subdistrict_id" onChange="chgMoo(this.value);">
                <OPTION value="">เลือกตำบล</OPTION>
				 	<?php 
						if($_GET['action'] == "edit"){
							if($row_edit['district_id'] != ""){
								$am = mysql_query("SELECT ccDigi,ccName,ccType FROM ccaa WHERE ccType='Tamboon' AND ccDigi LIKE '".substr($row_edit['district_id'],0,4)."%'  ");
								while( $ram = mysql_fetch_array($am) ) {
									$slted = ( $ram['ccDigi'] == $row_edit['subdistrict_id'] ) ? "selected" : "";
									echo "<option value=\"".$ram['ccDigi']."\" $slted>".$ram['ccName']."</option>\n";
									$slted="";
								}
							}
						} ?>
                </select>
                </div>
              </td>
          </tr>
          <tr>
          </tr>
          <tr>
            <td height="24" align="right">รหัสไปรษณีย์ :</td>
            <td><input name="zip_code" type="text" id="zip_code"  value="<?php echo $row_edit['zip_code'];?>" size="10" maxlength="5" onKeyDown="return Filter_Keyboard(event);" /></td>
          </tr>
          <?php 
// @modify Panupong Kiangmana 24/6/2557 function add/edit/delete phone number by jquery		  
		  ?>
          <script type="text/javascript">
          $(function(){
		  var xx= 0;
		  var yy = '<?php echo $num_of_tel; ?>';
		  var yy =  parseInt(yy);
				   $('#add_tel2').click(function(){
					   yy= yy +1; 
						var box_tel = '<tr id="root_tr'+xx+'"><td height="24" align="right">หมายเลขโทรศัพท์ :</td> <td><strong><input class="tel" name="phone_number'+yy+'" type="text" id="phone_number'+yy+'"  maxlength="50" onKeyDown="return Filter_Keyboard(event);" /><input id="del_tel'+yy+'" class="del_tel_btn" type="button" value="ลบหมายเลข"/></strong></td></tr>';
						$('#root_tr').parent().append(box_tel).find('tr td .del_tel_btn').click(function(){
								  $(this).parent().parent().parent().remove();
								  sensitivekey2();
						}).end();
					  $('input').keyup(function(){
							sensitivekey2();
						});
				  });
				  
				  $('#add_tel').click(function(){
					   xx= xx +1;
						var box_tel = '<tr id="root_tr'+xx+'"><td height="24" align="right">หมายเลขโทรศัพท์ :</td> <td><strong><input class="tel" name="phone_numberx'+xx+'" type="text" id="phone_numberx'+xx+'"  maxlength="50" onKeyDown="return Filter_Keyboard(event);" /><input id="del_tel'+xx+'" class="del_tel_btn" type="button" value="ลบหมายเลข"/></strong></td></tr>';
						$('#root_tr').parent().append(box_tel).find('tr td .del_tel_btn').click(function(){
								  $(this).parent().parent().parent().remove();
								  sensitivekey();
						}).end();
					  $('input').keyup(function(){
							sensitivekey();
						});
				  });
		  
			  function sensitivekey(){
					text = $('#phone_numberx').val();
					for(i = 1; i<=xx; i++){
						if($('#phone_numberx'+i).val() === undefined || $('#phone_numberx'+i).val() == ""){
						}else{
							var text = text +',' + $('#phone_numberx'+i).val()
						}
					}
					$('#phone_num1').attr('value',text);
			  }
			  
			  function sensitivekey2(){
					text = $('#phone_number').val();
					for(i = 0; i<=20; i++){
						if($('#phone_number'+i).val() === undefined || $('#phone_number'+i).val() == ""){
						}else{
							var text = text +',' + $('#phone_number'+i).val()
						}
					}
					$('#phone_num').attr('value',text);
			  }
				  // mode ปกติ
				  $('input').keyup(function(){
						sensitivekey();
						sensitivekey2();
					});
					
					$('tr td .del_tel_btn').click(function(){
								  $(this).parent().parent().parent().remove();
								  sensitivekey2();
					});
		  });
		  
          </script>
          <?php if($_GET['action'] == "edit"){ ?>
          <tr id="root_tr">
            <td height="24" align="right">หมายเลขโทรศัพท์ :</td>
            <td><strong>
              <input type="hidden" id="phone_num" name="phone_num" value="<?php echo $row_edit['phone_number']; ?>"  />
              <input  class="tel" name="phone_number" type="text" id="phone_number" value="<?php echo $tele[0]?>" maxlength="50" onKeyDown="return Filter_Keyboard(event);" />
            </strong>
            <input type="button" id="add_tel2" value="เพิ่มหมายเลขโทรศัพท์"/>
            </td>
          </tr>
          
          <?php 
		  for($i=2;$i<=$num_of_tel;$i++){ ?>
			  <tr>
            <td height="24" align="right">หมายเลขโทรศัพท์ :</td>
            <td>
            <strong>
              <input  class="tel" name="phone_number<? echo $i;?>" type="text" id="phone_number<? echo $i;?>" value="<?php echo $tele[$i-1]?>" maxlength="50" onKeyDown="return Filter_Keyboard(event);" />
              <input id="del_tel<? echo $i;?>" class="del_tel_btn" type="button" value="ลบหมายเลข"/>
            </strong>
            </td>
          </tr>
		<?  }
         } else{ ?>
        <tr id="root_tr">
            <td height="24" align="right">หมายเลขโทรศัพท์ :</td>
            <td><strong>
              <input type="hidden" id="phone_num1" name="phone_num" />
              <input  class="tel" name="phone_number" type="text" id="phone_numberx"  maxlength="50" onKeyDown="return Filter_Keyboard(event);" />
            </strong>
            <input type="button" name="add_tel" id="add_tel" class="original_add" value="เพิ่มหมายเลขโทรศัพท์" />
            </td>
          </tr>
		  <?  }
		  // @end
		   ?>
          <tbody>
          </table>
          
      </div>
      <div id="not_thai" <?php if($_GET['action'] == "edit"){if(!$live_in_thai){echo "style='display:none'";}}else{echo "style='display:none'";} ?> >
        <table width="98%" border="0">
          <tr>
            <td width="27%" align="right" valign="top">ที่อยู่<span style="color:#F00">*</span> :</td>
            <td width="73%"><label for="p_address"></label>
              <textarea name="p_address" cols="50" rows="3" id="p_address" ><?php echo $row_edit['p_address'];?></textarea></td>
          </tr>
          <tr>
            <td height="24" align="right">&nbsp;</td>
           
        </table>
      </div>
	  <table align="center" style="margin-top:30px;">
          <tr>
            <td height="24" align="right">&nbsp;</td>
            <td><input type="submit"  name="btn_submit" id="btn_submit" value="บันทึก" /></td>
			<!-- ยกเลิกค่่า เมือedit -->
			<?php
			if($_GET['action'] == "edit"){
		   ?>
			<td><input type="button"  name="cancle" id="button4" value="ยกเลิก" onClick="window.location.href='?p=form_address&p_id=<?php echo $_GET['p_id'] ?>&p_join_number=<?php echo $_GET['p_join_number'] ?>'"  /></td>
		   <?php
		   }else{
			?> 
			
			<td><input type="reset"  name="cancle" id="button4" value="ล้างค่า" /></td>
			
			<?php 		

		   }
			?>
              
          </tr>
		  <!-- ยกเลิกค่่า เมือedit -->
      </table>
      </td>
    </tr>
  </tbody>
</table>


</form>
<?php
}else{?>
<br />
<form id="form2" name="form2" method="post" action="index.php?p=form_address&p_id=<?php echo $_GET['p_id'];?>&p_join_number=<?php echo $_GET['p_join_number'];?>&action=addtype&id=<?php echo $add_list['id'];?>">
<table width="98%" border="0" align="center" id="showadd" cellpadding="3" cellspacing="1">
  <tbody>
    <tr>
      <td height="24" colspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#BBCEDD">
        <tr>
          <td width="3%" height="24" align="center"  class="bg_header"><strong>ลำดับ</strong></td>
          <td width="32%" align="center" class="bg_header"><strong>ที่อยู่</strong></td>
          <td width="9%" align="center" class="bg_header">ประเทศ</td>
          <td width="10%" align="center" class="bg_header"><strong>วันที่เพิ่มข้อมูล</strong></td>
          <td width="33%" align="center" class="bg_header"><strong>ตัวเลือก</strong></td>
          <td width="13%" align="center" class="bg_header"><strong>เครื่องมือ</strong></td>
        </tr>
        <tbody>
        <?php
		
			$DateThai2Eng = new DateFormatThai();

        	$sql_list = "SELECT * FROM personal_address WHERE p_id = ". $_GET['p_id'];
			$res_list = mysql_query($sql_list);
			
			$i = 1;
			while($add_list = mysql_fetch_assoc($res_list)){
		
				if($add_list['p_address'] != ''){
					$full_add = $add_list['p_address'];
				}else{
					$full_add = (trim($add_list['house_number']) !='') ? "บ้านเลขที่  ".$add_list['house_number'] : '';

					if($add_list['homenumber'] != ''){
						$full_add .= " หมู่ที่ ".$add_list['homenumber'];
					}
					if($add_list['namehome'] != ''){
						$full_add .= " หมู่บ้าน ".$add_list['namehome'];
					}
					if($add_list['home_building'] != ''){
						$full_add .= " ตึก ".$add_list['home_building'];
					}
					if($add_list['home_position'] != ''){
						$full_add .= " ชั้น ".$add_list['home_position'];
					}
					if($add_list['home_number'] != ''){
						$full_add .= " เลขที่ห้อง ".$add_list['home_number'];
					}
					
					if($add_list['alley'] != ''){
						$full_add .= " ซ.".$add_list['alley'];
					}
					
					if($add_list['road'] != ''){
						$full_add .= " ถ.".$add_list['road'];
					}
					
					if($add_list['village_id'] != ''){
						$res_name = get_address_name($add_list['village_id'],"village");
						$full_add .= " $res_name";
					}
					
					if($add_list['subdistrict_id'] != ''){
						$res_name = get_address_name($add_list['subdistrict_id'],"thai");
						$full_add .= "  $res_name";
					}
					
					if($add_list['district_id'] != ''){
						$res_name = get_address_name($add_list['district_id'],"thai");
						$full_add .= " $res_name";
					}
					
					if($add_list['province_id'] != ''){
						$res_name = get_address_name($add_list['province_id'],"thai");
						$full_add .= " $res_name";
					}
			
				
					$full_add .= " ".$add_list['zip_code'];
				}
		?>
		
          <tr>
            <td height="24" align="center"  bgcolor="#FFFFFF"><?php echo $i;?></td>
            <td align="left"  bgcolor="#FFFFFF"><?php echo $full_add; ?></td>
            <td align="center"  bgcolor="#FFFFFF"><?php echo get_address_name($add_list['country_id'],"country");?></td>
            <td align="center"  bgcolor="#FFFFFF"><?php echo $DateThai2Eng->date('j  M Y', $add_list['last_update']);?></td>
          <td align="center"  bgcolor="#FFFFFF"><div align="left">
              <label><input name="addr_type_1" type="radio" id="addr_now_<?php echo $i;?>" value="<?php echo $i;?>"  <?php if($add_list['addr_type_1'] == 2){echo "checked";}?>  />
              ที่อยู่ปัจจุบัน</label><br />
              <label><input name="addr_type_2" type="radio" id="addr_home_<?php echo $i;?>" value="<?php echo $i;?>"  <?php if($add_list['addr_type_2'] == 2){echo "checked";}?> />
              ที่อยู่ตามทะเบียนบ้าน</label><br />
              <label><input name="addr_type_3" type="radio" id="addr_before_<?php echo $i;?>" value="<?php echo $i;?>" <?php if($add_list['addr_type_3'] == 2){echo "checked";}?> />
              ที่อยู่ก่อนเข้าใช้บริการ</label><br />
              <label><input name="addr_type_4" type="radio" id="addr_local_<?php echo $i;?>" value="<?php echo $i;?>" <?php if($add_list['addr_type_4'] == 2){echo "checked";}?> />
              ที่อยู่ตามภูมิลำเนา</label></div></td>
            <td align="center"  bgcolor="#FFFFFF">
            	<a href="index.php?p=form_address&p_id=<?php echo $_GET['p_id'];?>&action=edit&id=<?php echo $add_list['id'];?>&p_join_number=<?php echo $_GET['p_join_number']; ?>">แก้ไข </a>| 
                <a href=# onClick="return del_confirm(<?php echo $add_list['id']?>);" >ลบ</a>
             </td>
          </tr>
          <?php
				$i++;
			}
		  ?>
		  <td colspan="6" align="right">
            	<input type="hidden" name="p_id" value="<?php echo $p_id;?>"/>
            	<input type="submit" name="btn_submit" id="btn_submit" value="บันทึก" />
              	<input type="reset" name="cancle" id="button1" value="ล้างค่า" />
            </td>
        </tbody>
        <tfoot>
        <tr>
        	
        </tr>
        </tfoot>
      </table></td>
    </tr>
    <tr> </tr>
  </tbody>
</table>
</form>
<br /> 

<?php
   }
?>

<!--////////////////////////////////////////////////////////////////////////////////////// form1 //////////////////////////////////////////////////////////-->