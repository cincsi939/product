<?php
######################  start Header ########################
/**
* @comment �������ż��红������͡�����ѡ�ҹ��͵���Է��
* @projectCode 56EDUBKK01
* @tor 7.2.4 
* @package core
* @author Suwat.K 
* @access private
* @created 06/08/2015
*/
ob_start();
session_start();
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
$save_to_file = 1; //@20/7/2550 ���ٻŧ���
$idcard=$_SESSION[idoffice];
$staffid=$_SESSION[session_staffid];
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
$ApplicationName	= "general";
$module_code 		= "add_data";
$process_id 			= "add_persondata";
$VERSION 				= "9.x";
#########################################################
#Developer		::	Alongkot
#DateCreate		::	17/03/2007
#LastUpdate		::	17/03/2007
#DatabaseTabel	::	general
#END
//include ("../libary/function.php");
//include ("checklogin.php");
//include ("../../../config/phpconfig.php");
//include ("timefunc.inc.php");

include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
include ("../libary/function.php");
include ("timefunc.inc.php");
include("../../../config/phpconfig.php");
include("../../../common/function_kp7_logerror.php");

$date_gpf = "2540-03-27"; // ��ѧ�ҡ�ѹ��� 27 �չҤ� 2547
//Conn2DB();
//print_r($_SESSION);

 $_GET['id']= $_SESSION[id];
 $_POST['id']= $_SESSION[id];

$menu_id = "1"; // ������Ǵ��¡��
$time_start = getmicrotime();

if(substr($_SERVER[REMOTE_ADDR],0,7)=="192.168"){
	$addr_page="add_historyaddress.php";
}else{
	$addr_page="add_historyaddress_v1.php";
}

## ��ѭ�ҷ������˵ءó��բ����Ť�������繪�ͧ��ҧ
$sql_DEL_hismarry = "DELETE FROM hr_addhistorymarry WHERE gen_id='$id' AND name_th='' AND surname_th=''";
@mysql_db_query($dbname,$sql_DEL_hismarry);

$id = (empty($_POST[id])) ? $_GET[id] : $_POST[id] ;
if ($_SERVER[REQUEST_METHOD] == "POST"){
	//echo '<pre>';print_r($_POST);die;
	$txt_birthday_label = ltrim($birthday_label);
	$txt_retire_label = ltrim($retire_label);
	$txt_startdate_label = ltrim($startdate_label);
##########  ��ǹ�ͧ����ʴ��� ���ª����ѹ��͹���Դ	
		$up_birthday_label = ", birthday_label='$txt_birthday_label'";
###########   ��ǹ�ͧ����ʴ����ѹ���³�����Ҫ���
		$up_retire_label = ", retire_label='$txt_retire_label'";
		#### ��ǹ�ͧ����ʴ��Ż��ª����ѹ��觺�è�
		$up_startdate_label = ", startdate_label='$txt_startdate_label'";

add_log("�����Ţ���Ҫ���",$id,$action,$menu_id);
	if ($_POST[refresh] == "0"){
		 if ($_POST[action]=="edit")
		 {
				  if($name_th=='')
				 {	echo "�س������кت���������";
					exit;
				 }else if($surname_th =='')
				{	echo "�س������кع��ʡ��������";
					exit;
				}
			  $startdate = $startyear.'-'.$startmonth.'-'.$startday;
			  $begindate = $beginyear.'-'.$beginmonth.'-'.$beginday;
			 	if($startdate != "--"){ // �ó��ա�����͡�ѹ��è�
						$up_startdate = ", startdate='$startdate' ";
						$start_date_manual = ", startdate_manual_status='1' ";
				} else{
						$up_startdate = "";
						$start_date_manual = "";
				}
			 
			  
			$bid=explode("/",$birthd);
			$birthday=$bid[2]."-".$bid[1]."-".$bid[0];
			//  $birthday = $byear.'-'.$bmonth.'-'.$bday;
			  $comedate = $comeyear.'-'.$comemonth.'-'.$comeday;
			  $enddate = $endyear.'-'.$endmonth.'-'.$endday;
			  $idcard = $idcard1.$idcard2.$idcard3.$idcard4.$idcard5;
			  if($schoolid != ""){
			  		$up_school = ", schoolid='$schoolid' ";
			  }else{
			  		$up_school = "";
			  }
			  if($radub_past_id != ""){
				  $sql_radub1 = "SELECT * FROM hr_addradub WHERE level_id='$radub_past_id'";
				  $result_radub1 = mysql_db_query($dbnamemaster,$sql_radub1);
				  $rsr1 = mysql_fetch_assoc($result_radub1);
				$radub_past = "$rsr1[radub]";	  
			 }
#### ���¡���ʶҹе�ҧ�	
//echo "<pre>"; print_r($_POST);echo "</pre>";
 ## �������ʹ	
 //echo $blood;	 
if($blood){
	$strSQL="select * from $dbnamemaster.hr_blood where id='$blood' ";
	$result=@mysql_query($strSQL);
	$pre_result=@mysql_fetch_assoc($result);
	$blood=$pre_result[blood];
	$blood_id=$pre_result[id];	
	//echo "<pre>"; print_r($pre_result); die;
}else{
	$blood="";
	$blood_id="";	
}		

 ## ʶҾ�Ҿ����		 
if($marry){
	$strSQL="select * from $dbnamemaster.hr_addmarriage where runid='$marry' ";
	$result=@mysql_query($strSQL);
	$pre_result=@mysql_fetch_assoc($result);
	$marry=$pre_result['marriage'];
	$marital_status_id=$pre_result['runid'];	
	//echo "<pre>"; print_r($pre_result); die;
}else{
	$marry="";
	$marital_status_id="";	
}

 ## ʶҾ�Ҿ���ʵ�� �� 7	 
if($marry_kp7){
	$strSQL="select * from $dbnamemaster.hr_addmarriage where runid='$marry_kp7' ";
	$result=@mysql_query($strSQL);
	$pre_result=@mysql_fetch_assoc($result);
	$marry_kp7=$pre_result['marriage'];
	$marital_kp7_status_id=$pre_result['runid'];	
	//echo "<pre>"; print_r($pre_result); die;
}else{
	$marry_kp7="";
	$marital_kp7_status_id="";	
}
#### END ���¡���ʶҹе�ҧ�	
//unit='$unit',

$strSQL="select pid, position from $dbnamemaster.hr_addposition_now  where pid='$pid_begin'";
$result=@mysql_query($strSQL);
$pre_result=@mysql_fetch_assoc($result);   
$position=$pre_result[position];
$pid_begin=$pre_result[pid];
#@modify suwat.k  ��Ǩ�ͺ���͹䢤���ȷ�����Ҩҡ������ѹ�֡������
if($_POST['sex'] != ""){
		$sex = $_POST['sex'];
}else{
		$sex = $_POST['sex_h'];	
}
#@end

if($gender_id == ""){
	$sql_gender = "select gender from $dbnamemaster.gender where gender='$sex'";
	$result_gender = mysql_db_query($dbnamemaster,$sql_gender);
	$rs_g = mysql_fetch_assoc($result_gender);
	$gender_id = $rs_g[gender];
}
if($prename_id == ""){
		$sql_prename_id = "SELECT  PN_CODE  FROM  prename_th  WHERE prename_th='$prename_th'";
		$result_prename_id = mysql_db_query($dbnamemaster,$sql_prename_id);
		$rs_pre_id = mysql_fetch_assoc($result_prename_id);
		$prename_id = $rs_pre_id[PN_CODE];
}
				$sql = "update general set 			
				prename_th=trim('$prename_th'),
				prename_id=trim('$prename_id'),
				name_th=trim('$name_th'),
				surname_th=trim('$surname_th'),
				prename_en=trim('$prename_en'),
				name_en=trim('$name_en'),
				surname_en=trim('$surname_en'),
				nationality='$nationality',
				citizenship='$citizenship',
				persontype='$persontype',
				royalid='$royalid',
				taxid='$taxid',
				sex='$sex',
				gender_id='$gender_id',
				blood='$blood',
				blood_id='$blood_id',
				position='$position',
				work = '".$_POST['work']."',
				radub_past='$radub_past',
				marital_status_id='$marital_status_id',
				region='$region',
				home='$home',
				begindate='$begindate',
				begindate_label='$begindate_label',
				startposition='$startposition',
				birthday='$birthday',
				contact_add='$contact_add',
				subminis='$subminis',
				minis='$minis',
				minis_now='$minis',
				subminis_now='$subminis_now_label',
				subminis_now_label='$subminis_now_label',
				endday='$enddate',
				father_occ='$father_occ',
				mother_occ='$mother_occ',
				marry_occ='$marry_occ', 
				contact_tel='$contact_tel' ,
				noteref='$noteref',
				secondname_th=trim('$secondname_th') ,
				secondname_en =trim('$secondname_en') , 
				idcard='$idcard', 
				marry_prename=trim('$marry_prename'), 
				marry_name=trim('$marry_name'), 
				marry_surname=trim('$marry_surname'),
				father_prename=trim('$father_prename'), 
				father_name=trim('$father_name'), 
				father_surname=trim('$father_surname'), 
				mother_prename=trim('$mother_prename'), 
				mother_name=trim('$mother_name'), 
				mother_surname=trim('$mother_surname'),
				marry_kp7='$marry_kp7',
				marital_kp7_status_id='$marital_kp7_status_id',
				label_persontype2now='$label_persontype2now',
				status_gpf='$status_gpf' $up_startdate $start_date_manual  $up_birthday_label $up_retire_label $up_startdate_label $up_school  where id ='$id' ;";
				
				//echo $sql; die;

######################################
# ���������Ѻ comment ����ӡ�õѴ 
# 1. marry='$marry', 
# 2. persontype2_now='$persontype2_now',   
# 3. pid_begin='$pid_begin',
# 4. radub_past_id='$radub_past_id',
# 5. work='$work',
# 6. $up_school
# 7. minis_now='$minis_now',
# 8. subminis_now='$subminis_now',
# �͡�ҡ sql   �ѹ��� 20101124
# 
######################################

//echo "<br>".$sql."<hr>";die;
		//$returnid = add_monitor_logbefore("general","  id ='$id' ");
		mysql_db_query($dbname,$sql)or die(mysql_error());
		#######  
			if($flag_editb == "1"){
				SaveLogEditBirthday($id,$siteid);	
			}
		######
		
		#$sql_up1 = "UPDATE general SET status_gpf='3' WHERE id='$id' AND begindate >= '$date_gpf'";
		
		
		
		######################
		$temp_subject_error=explode("::",$_POST['subject_error']);
		$temp_value_key_error=explode("::",$_POST['value_key_error']);
		$temp_label_key_error=explode("::",$_POST['label_key_error']);
		$temp_submenu_id=explode("::",$_POST['submenu_id']);
		$numTemp=count($temp_subject_error);
		
		for($a=1;$a<$numTemp;$a++){
			save_kp7_logerror($idcard,$temp_subject_error[$a],get_real_ip(),'UPDATE',$temp_value_key_error[$a],$temp_label_key_error[$a],$staffid,$temp_submenu_id[$a]);
		}		
		######################
		
	#	mysql_db_query($dbname,$sql_up1);
		//add_monitor_logafter("general","  id ='$id' ",$returnid);
		
				if (mysql_errno())
				{
					$msg = "�������ö�ѹ�֡��������";
				}else{
					echo"
									<script language=\"javascript\">
									alert(\"�ѹ�֡���º����\\n \");
									</script>
								<meta http-equiv='refresh' content='0;URL=?id=$id&action=edit'>";
						exit;

				}

			}
			elseif ($_POST[action]=="insert")
			{

			}

	} // if refresh
		
}

// Display Data

if ($_POST[refresh] == "1"){ // no load
	$rs = array();
	foreach ($_POST as $key=>$value){
		$rs["$key"] = $value;
	}

	$rs[idcard] = $idcard1.$idcard2.$idcard3.$idcard4.$idcard5;
	//	$msg = "��辺�����ŷ���ͧ���";
		$rs[beunder] = $_POST[groupping];



	  $startdate = $startyear.'-'.$startmonth.'-'.$startday;
	  $begindate = $beginyear.'-'.$beginmonth.'-'.$beginday;
	  $birthday = $byear.'-'.$bmonth.'-'.$bday;
	  $comedate = $comeyear.'-'.$comemonth.'-'.$comeday;
	  $enddate = $endyear.'-'.$endmonth.'-'.$endday;

	$rs[startdate] = $startdate;
	$rs[begindate] = $begindate;
	$rs[birthday] = $birthday;
	$rs[comeday] = $comedate;
	$rs[enddate] = $enddate;

	$_GET[action] = $_POST[action];

}else if ($id){
	$sql = "select t1.*  from  general t1  where t1.id='$id' ;";
	$result = mysql_db_query($dbname,$sql);
	if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
	} else {
		$msg = "��辺�����ŷ���ͧ���";
	}

}else{ // new
	$sql = "select * from  office_detail where id='$_SESSION[idoffice]';";
	$result = mysql_db_query($dbname,$sql);
	if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
	} else {
		$msg = "��辺�����ŷ���ͧ���";
	}
}

?>
<script language=JavaScript 
src="bimg/swap.js"></script>
<html>
<head>
<title>�����Ţ���Ҫ���</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<script>
var imgDir_path="../../../common/popup_calenda/images/calendar/";


</script>
<script language="javascript" src="chk_number.js"></script>

<script src="../../../common/popup_calenda/function.js" type="text/javascript"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript" src="jquery.js"></script>
<?php /*?><script language="javascript" src="jquery-1.4.1.min.js"></script><?php */?>
<script src="../../../common/check_label_values/script.js" type="text/javascript"></script>
<script type="text/javascript" src="../../../common/check_label_values/calendar_list.js"></script>
<script type="text/javascript" src="tooltip/js/jtip.js"></script>
<script language="javascript" src="../../../common/js/jquery.numeric.js"></script>
<script>var imgDir_path="../../../common/popup_calenda/images/calendar/"; var maxyear = '<?=date('Y')?>';</script>
<script src="../../../common/popup_calenda/popcalendar_callback.js" type="text/javascript"></script>
<link rel="stylesheet" href="tooltip/css/global.css" />
<script>

function ajax_showdatethai(){
	//alert("test");
	var val_date= document.getElementById('birthd').value;
	$.get("ajax_datethai.php", { datadate: val_date}, 
		function(data){
			$("#birthday_label").val(data);
			//check_values_label("birthd","birthday_label","values","date","chk_date1");
		}
	);
}
function disp_date(id,date,button,type){
	var format=1;
	var url="../register/ajax/ajax_setdateformat.php?rnd="+(Math.random()*1000)+"&date="+date+"&format="+format;
	$.get(url,'',function(data){
		$('#'+id+'_label').val(data);
	});
if($.trim(type)=='startdate'){
	var date2 = $('#birthd').val();
	//alert(date2);
	if(date2==''){
		alert('��سҡ�͡�ѹ��͹���Դ��͹!!');	
		$('#begindate').val('');
		$('#birthd').focus();
		return false;
	}
}
else if($.trim(type)=='date_in'){
	var date2 = $('#begindate').val();
	if(date2==''){
		alert('��سҡ�͡�ѹ�������Ժѵ��Ҫ��á�͹!!');	
		$('#date_in').val('');
		$('#begindate').focus();
		return false;
	}
}
	var url="../register/ajax/ajax_checkday.php?rnd="+(Math.random()*1000)+"&start="+date+"&type="+type+"&date2="+date2;
	$.get(url,'',function(data){
		
		data = data.split('|');
		if($.trim(data[0])=='no2'&&$.trim(type)=='date_in'){
			alert(data[1]);
			$('#'+id).val('');
			$('#'+button).focus();
			return false;
		}
		else if($.trim(data[0])=='no'&&$.trim(type)=='startdate'){
			alert(data[1]);
			$('#'+id).val('');
			$('#'+button).focus();
			return false;
		}
		else if($.trim(data[0])=='no'&&$.trim(type)=='birthd'){
			alert(data[1]);
			$('#'+id).val('');
			$('#'+button).focus();
			return false;
		}else if($.trim(data[0])=='no2'&&$.trim(type)=='birthd'){
			if(!confirm(data[1])){
				$('#'+id).val('');
				$('#'+button).focus();
				return false;
			}
		}else if($.trim(data[0])=='same'){
			alert(data[1]);
			$('#'+id).val('');
			$('#birthday_label').val('');
			$('#'+button).focus();
			return false;
		}else{
			ajax_showdatethai();
		}	
	});
}
function key_eng()
{
	var eng = new RegExp("^[a-zA-Z]+$");
 � �var code;
 � �if (!e) var e = window.event;
 � �if (e.keyCode)
 � �{
 � � � �code = e.keyCode;
 � � � �if ((code >= 65&&code<=90)||(code >= 97&&code<=122)||(code==127))
 � � � �{ return true;}
 � � � �else
 � � � �{ �return false;}
 � �}
}
$(document).ready(function() {
	//$('#contact_tel').numeric({decimal : " - " , negative : false});
	
	//$('#contact_tel').numeric({ decimal : "," });
	//$('#contact_tel').numeric({ decimal : "-",negative : false});
	path="../../../common/check_label_values/";
	check_true='<img src="'+path+'images/checked.gif" width="18" height="18" />';
	check_false='<img src="'+path+'images/unchecked.gif" width="18" height="18" />';
	
$('#birthd').after("<span id='msg_birthd' class='span_check'></span>").blur(function(){
		if(checkThaiDate(this,document.getElementById('div_txt_birthd'))){
		check_values_label($(this).attr('id'),'birthday_label','values','date',"chk_birthd");
		}
		}).keypress(function(){chkDateFormat(this,event)});
strcall = $('#birthd_but').attr('call'); 
if(strcall==1){
	$('#birthd_but').click(function(){popUpCalendar(document.getElementById("birthd"), document.getElementById("birthd"), "dd/mm/yyyy" ,'check_values_label("birthd","birthday_label","values","date","chk_date1");')});
	
	}else{
		$('#birthd_but').click(function(){popUpCalendar(document.getElementById("birthd"), document.getElementById("birthd"), "dd/mm/yyyy" ,'ajax_showdatethai();'); alert("check");});
	}
	
	//$('#birthday_label').after("<span id='msg_birthday_label' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'birthd','label','date',"chk_birthd");});
	
	$('#label_type_showdate').after("<span id='msg_label_type_showdate' class='span_check'></span>").focus(function(){check_values_label($(this).attr('id'),'birthd','label','date',"chk_type_showdate");});
	
	$('#label_type_showdate2').after("<span id='msg_label_type_showdate2' class='span_check'></span>").focus(function(){check_values_label($('#label_type_showdate2').attr('id'),'birthd','label','date',"chk_type_showdate2");});
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$('#startdate_label').after("<span id='msg_startdate_label' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'startdate_value','label','date',"chk_startdate");});
	
	$('#begindate_label').after("<span id='msg_begindate_label' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'begin_value','label','date',"chk_begin");});
	
	$('#retire_label').after("<span id='msg_retire_label' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'retire_value','label','date',"chk_retire");});
	
get_hisname('<?=$id?>','<?=$siteid?>');
});
function get_hisname(id,site){
var url="ajax_hisname.php?xid="+id+"&xsiteid="+site+"&rnd="+(Math.random()*1000);
$.get(url,'',function(data){
  $('#his_name_text').text(data);
});
}


function chkBirthDate(){
		
		//alert('test1');		
		check_values_label($('#birthday_label').attr('id'),'birthd','label','date',"chk_birthd"); 
		check_values_label($('#label_type_showdate').attr('id'),'birthd','label','date',"chk_type_showdate");
		check_values_label($('#label_type_showdate2').attr('id'),'birthd','label','date',"chk_type_showdate2");		
		
		//$('#msg_birthday_label_1').html(loader).delay(2000);
		//window.setInterval(1);
		//var f1=document.form1;
		/*a=$('#chk_birthd').val()+"---"+$('#chk_type_showdate').val()+"---"+$('#chk_type_showdate2').val();
		//alert(a);
		if ($('#chk_birthd').val() == 'true' && $('#chk_type_showdate').val() == 'true' && $('#chk_type_showdate2').val() == 'true'){
				//f1.chk_birthAll.value="true";
				//$('#msg_birthday_label_1').html(loader);
				$('#msg_birth_label').html(check_true);	
				$('#chk_birthAll').val('true');
		}else{
				//f1.chk_birthAll.value="false";
				//$('#msg_birthday_label_1').html(loader);
				$('#msg_birth_label').html(check_false);	
				$('#chk_birthAll').val('false');
		}*/
}
</script>
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style1 {color: #8C0000}
.textgreen { color:#009900; }
select[disabled="disabled"] { color: green;} 
-->
</style>

<!-- check ����кؤ��  -->

<script LANGUAGE="JavaScript">
<!--
  displaymonth='l';
function getorg(id){
var url="getorg.php?orgid="+id+"&Rnd="+Math.random()*1000;
	$.get(url,'',function(data){
	 $('#div_subminis_now').empty().append(data);  					  
	});
}

function chkLabelValue(){
	
		//var f1=document.post;
		var f1=document.form1;
		var chkStatus=0;
		if (f1.chk_birthd.value == 'false' || f1.chk_type_showdate.value == 'false' || f1.chk_type_showdate2.value == 'false'){
			if(confirm("�ѹ��͹���Դ���ç�Ѻ��ͧ�ʴ��� ��.7 ��ͧ��ô��Թ��õ���������")){
					chkStatus=0;
					if (f1.chk_birthd.value == 'false'){
							f1.subject_error.value=f1.subject_error.value+"::"+"�ѹ��͹���Դ���ç�Ѻ��ͧ�ʴ��� ��.7";
							f1.value_key_error.value=f1.value_key_error.value+"::"+f1.birthd.value;
							f1.label_key_error.value=f1.label_key_error.value+"::"+f1.birthday_label.value;
							f1.submenu_id.value=f1.submenu_id.value+"::"+"1";
					}
					if (f1.chk_type_showdate.value == 'false'){
							f1.subject_error.value=f1.subject_error.value+"::"+"�ѹ��͹���Դ���ç�Ѻ��ͧ�ʴ��� ��.7";
							f1.value_key_error.value=f1.value_key_error.value+"::"+f1.birthd.value;
							f1.label_key_error.value=f1.label_key_error.value+"::"+f1.label_type_showdate.value;
							f1.submenu_id.value=f1.submenu_id.value+"::"+"1";
					}
					if (f1.chk_type_showdate2.value == 'false'){
							f1.subject_error.value=f1.subject_error.value+"::"+"�ѹ��͹���Դ���ç�Ѻ��ͧ�ʴ��� ��.7";
							f1.value_key_error.value=f1.value_key_error.value+"::"+f1.birthd.value;
							f1.label_key_error.value=f1.label_key_error.value+"::"+f1.label_type_showdate2.value;
							f1.submenu_id.value=f1.submenu_id.value+"::"+"1";
					}
			}else{
					chkStatus=1;
					f1.subject_error.value="";
					f1.value_key_error.value="";
					f1.label_key_error.value="";
					f1.submenu_id.value="";
					return false;
			}
		}
		
		if (f1.chk_startdate.value == 'false'){
			if(confirm("�ѹ��觺�è����ç�Ѻ��ͧ�ʴ��� ��.7 ��ͧ��ô��Թ��õ���������")){
					chkStatus=0;
					f1.subject_error.value=f1.subject_error.value+"::"+"�ѹ��觺�è����ç�Ѻ��ͧ�ʴ��� ��.7";
					f1.value_key_error.value=f1.value_key_error.value+"::"+f1.startday.value+"/"+f1.startmonth.value+"/"+f1.startyear.value;
					f1.label_key_error.value=f1.label_key_error.value+"::"+f1.startdate_label.value;
					f1.submenu_id.value=f1.submenu_id.value+"::"+"2";
			}else{
					chkStatus=1;
					f1.subject_error.value="";
					f1.value_key_error.value="";
					f1.label_key_error.value="";
					f1.submenu_id.value="";
					return false;
			}
		}
		
		if (f1.chk_begin.value == 'false'){
			if(confirm("�ѹ�������Ժѵ��Ҫ������ç�Ѻ��ͧ�ʴ��� ��.7 ��ͧ��ô��Թ��õ���������")){
					chkStatus=0;
					f1.subject_error.value=f1.subject_error.value+"::"+"�ѹ�������Ժѵ��Ҫ������ç�Ѻ��ͧ�ʴ��� ��.7";
					f1.value_key_error.value=f1.value_key_error.value+"::"+f1.beginday.value+"/"+f1.beginmonth.value+"/"+f1.beginyear.value;
					f1.label_key_error.value=f1.label_key_error.value+"::"+f1.begindate_label.value;
					f1.submenu_id.value=f1.submenu_id.value+"::"+"3";
			}else{
					chkStatus=1;
					f1.subject_error.value="";
					f1.value_key_error.value="";
					f1.label_key_error.value="";
					f1.submenu_id.value="";
					return false;
			}
		}
		
		if (f1.chk_retire.value == 'false'){
			if(confirm("�ѹ���³�������ç�Ѻ��ͧ�ʴ��� ��.7 ��ͧ��ô��Թ��õ���������")){
					chkStatus=0;
					f1.subject_error.value=f1.subject_error.value+"::"+"�ѹ���³�������ç�Ѻ��ͧ�ʴ��� ��.7";
					f1.value_key_error.value=f1.value_key_error.value+"::"+f1.retire_valueLOG.value;
					f1.label_key_error.value=f1.label_key_error.value+"::"+f1.retire_label.value;
					f1.submenu_id.value=f1.submenu_id.value+"::"+"17";
			}else{
					chkStatus=1;
					f1.subject_error.value="";
					f1.value_key_error.value="";
					f1.label_key_error.value="";
					f1.submenu_id.value="";
					return false;
			}
		}
		
		if(chkStatus==0){
				return true;
		}else{
				return false;
		}
}

function ch(){
			var f1=document.form1;
/* **************************************************************************************/
var day=f1.startday.value;
var month=f1.startmonth.value;
var year=f1.startyear.value;
var d=parseInt(day);
var m=parseInt(month);
var y=parseInt(year);
m=m-1;
y=y-543;

var  day2=f1.beginday.value;
var  month2=f1.beginmonth.value;
var year2=f1.beginyear.value;

var d2=parseInt(day2);
var m2=parseInt(month2);
var y2=parseInt(year2);
m2=m2-1;
y2=y2-543;

var today = new Date();
var myDate = new Date();
var myDate2 = new Date();
myDate.setFullYear( y, m, d );
myDate2.setFullYear( y2, m2, d2);

/* **************************************************************************************/
	  /*	var startd = f1.startday.value;
			
			var startm= f1.startmonth.value;
		
			var starty= f1.startyear.value;	
			
			var begind= f1.beginday.value;
			
			var beginm= f1.beginmonth.value;
			var beginy= f1.beginyear.value;
			var start_date=starty+startm+startd;
			var begin_date=beginy+beginm+begind;
			if(start_date >begin_date)
				{
					alert("�ѹ�͡����觵�ͧ����ҡ�����ѹ�������Ժѵԧҹ");
					return false;
				}
*/
		//alert(f1.birthd.value);return false;
		
		/* **************************************************************************************/
	 if(myDate>today  || myDate2>today)
	{
		   if(myDate>today){ alert('�ѹ��觺�è� �������ö���͡�ѹ����͹Ҥ���');  }
		   if(myDate2>today) { alert('�ѹ�������Ժѵ��Ҫ��� �������ö���͡�ѹ����͹Ҥ���');  }
		  return false;
	}
			/* **************************************************************************************/
		
		if (f1.refresh.value == "1"){
			return true; //no checking for refreshing
		}
		
		if (f1.prename_th.selectedIndex == 0){
			alert("��س��кؤӹ�˹�Ҫ���");
			return false;
		}
		
		if (!f1.name_th.value){
			alert("��س��кت���������");
			return false;
		}
		
		if (!f1.surname_th.value){
			alert("��س��кع��ʡ��������");
			return false;
		}	
			
			
	//alert(f1.sex.value);
	//alert(f1.sex_h.value);
		if (f1.sex.value == "" && f1.sex_h.value == ""){
			alert("��سҡ�͡��������");
			return false;
		}
		// ��Ǩ�ͺ�ѹ��͹���Դ
		if(f1.birthd.value == "00/00/0000" || f1.birthd.value == "" ){
			alert("��س��к��ѹ��͹���Դ���¤�Ѻ");
			f1.birthd.focus();
			return false;
		}		
		//alert(f1.birthd.value);return false;
		if (f1.marry_kp7.value == "0"){
			alert("��سҡ�͡������ʶҹ�Ҿ���ʵ�� �.�.7 ���¤�Ѻ");
			f1.marry_kp7.focus();
			return false;
		}	
		/*if (f1.marry.value == "0"){
			alert("��سҡ�͡������ʶҹ�Ҿ���� ���¤�Ѻ");
			f1.marry.focus();
			return false;
		}	*/			
		if ((f1.marry_kp7_active.value == 1)&&((f1.marry_kp7.value == 2)||(f1.marry_kp7.value == 5))){
			alert("����к� ʶҹ�Ҿ���ʵ�� �.�.7\n�������ѹ��Ѻ�����Ť�����ʷ���ʴ���� �.�.7\n��سҡ�͡������ʶҹ�Ҿ���ʵ�� �.�.7�����Ѻ");
			f1.marry_kp7.focus();
			return false;
		}
		/*if (((f1.marry_name.value != '')||(f1.marry_surname.value != ''))&&(f1.marry.value == 2)){
			alert("����к� ʶҹ�Ҿ���� \n�������ѹ��Ѻ�����Ť������ \n��سҡ�͡������ʶҹ�Ҿ���������Ѻ");
			f1.marry.focus();			
			return false;
		}	*/
	/*	
		if (!f1.radub.value){
			alert("��س��к��дѺ��鹻Ѩ�غѹ ���¤�Ѻ");
			return false;
		}
	*/	
	
	if(f1.status_gpf.value == "0"){
			alert("��س��к�ʶҹС������Ҫԡ ���.");
			f1.status_gpf.focus();
			return false;
	}
	//   ��Ǩ�ͺ ��á�͡ label �ѹ��͹���Դ
		if(f1.birthday_label.value != ""){
					if(f1.birthday_label.value.length <= 5){
							alert("�ٻẺ��á�͡�ѹ��͹���Դ��ǹ����ʴ���� �.�.7 ���١��ͧ");
							f1.birthday_label.focus();
							return false;
					}// if(f1.birthday_label.value.length < 5){
		}// end 	if(f1.birthday_label.value != ""){	
		
		// ��Ǩ�ͺ ��á�͡�ѹ���³�����Ҫ���
			if(f1.retire_label.value != ""){
					if((f1.retire_label.value.length < 2)){
							alert("�ٻẺ��á�͡�ѹ���³�����Ҫ�����ǹ����ʴ���� �.�.7 ���١��ͧ");
							f1.retire_label.focus();
							return false;
					}// end if((f1.retire_label.value.length < 7)){
			}//end if(f1.retire_label.value != ""){
		
			
		
/*		if (f1.position.selectedIndex == 0){
			alert("��س��кص��˹� ���¤�Ѻ");
			return false;
		}
*/
		
		if (chkLabelValue()== false){
			return false;
		}
		
		/*if (compairDateLE()== false){
			alert("��س��к��ѹ��觺�è������ѹ�������Ժѵ��Ҫ������١��ͧ ���¤�Ѻ (�ѹ��觺�è�������ҡ�����ѹ�������Ժѵ��Ҫ���)");
			return false;
		}	*/	
		
		if (document.getElementById('div_txt_birthd').innerHTML != ''){
			alert("��س��к��ѹ��͹���Դ���١��ͧ ���¤�Ѻ");
			f1.birthd.focus();
			return false;
		}
		 if (document.getElementById('label_persontype2now').value == ""){
		   alert("��س��кػ���������Ҫ���");
		   $('#label_persontype2now').focus();
		   return false;
		  }
		if (f1.position_now.selectedIndex == 0){
			alert("��س��кص��˹觻Ѩ�غѹ ���¤�Ѻ");
			return false;
		}
		
//		if (f1.radub_past.selectedIndex == 0){
//			alert("��س��к��дѺ ���¤�Ѻ");
//			return false;
//		}
		if(f1.beginday.value == "00" && f1.beginmonth.value == "00" && f1.beginyear.value == "0000"){
			alert("��س��к��ѹ�������Ժѵ��Ҫ��ô��¤�Ѻ");
			f1.beginday.focus();
			return false;
				
		}
		if(f1.startyear.value!=f1.beginyear.value){
			alert("���������Ժѵ��Ҫ��� �Ѻ�շ���è����ç�ѹ");
			f1.startyear.focus();
			return false;
			}
		
		
}
	
function checkidcard(){
	alert("�ҡ��ͧ������<?=TEXT_IDCARD?> ! ��سҵԴ��� Call Center");
	return false;
}	
//-->
</script>
<!-- send id to menu flash -->
<script language=javascript>
<!--

	function checkid(){  //�Ǻ������ҧ id 
		f1 = document.form1;
		f1.id.value = f1.id1.value + f1.id2.value + f1.id3.value + f1.id4.value + f1.id5.value;
	}


var isNN = (navigator.appName.indexOf("Netscape")!=-1);

function autoTab(input,len, e) {
	var keyCode = (isNN) ? e.which : e.keyCode; 
	var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
	if(input.value.length >= len && !containsElement(filter,keyCode)) {
		input.value = input.value.slice(0, len);
		input.form[(getIndex(input)+1) % input.form.length].focus();
	}

	function containsElement(arr, ele) {
	var found = false, index = 0;
		while(!found && index < arr.length)
			if(arr[index] == ele)
				found = true;
			else
				index++;
		return found;
	}

	function getIndex(input) {
		var index = -1, i = 0, found = false;
		while (i < input.form.length && index == -1)
			if (input.form[i] == input)
				index = i;
			else 
				i++;
			return index;
	}

	// add to id
	checkid();

	return true;
}

var isMain = true;

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->

////  check number
function noNumbers(e){
var keynum
var keychar
var numcheck

if(window.event) // IE
{
keynum = e.keyCode
}
else if(e.which) // Netscape/Firefox/Opera
{
keynum = e.which
}
keychar = String.fromCharCode(keynum)
numcheck = /\d/
return !numcheck.test(keychar)
}

function checkPosition(positionGroup){
	if( positionGroup == '2' ){
		if( $('#work').val() == '0'){
			alert('��س����͡ �ҹ/����/������ҹ');
			$('#work').focus();
			return false;
		}else{
			$('#refresh').attr('value','0');
			return true;
		}
	}else{
		$('#refresh').attr('value','0');
		return true;
	}
}

</script>




</head>

<body >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom "><?
/*
if ($msg){
		echo "<h1>$msg</h1>";
		exit;
}
*/
$office_unit  = $rs[unit] ; 
?>
      <!-- main Table  -->
      <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#2C2C9E">
        <tr>
          <td height="30"><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">&nbsp;&nbsp;&nbsp;&nbsp;��䢢����źؤ��&nbsp;
                <?=$rs[prename_th]?>
                <?=$rs[name_th]?>
            &nbsp;
            <?=$rs[surname_th]?>
          </font></td>
          <td width="108" height="30" align="right" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        </tr>
        <tr bgcolor="#CACACA">
          <td width="862" bgcolor="#888888">&nbsp;</td>
          <td align="right" bgcolor="#888888"><a href="general.php"></a>&nbsp;          &nbsp;&nbsp; </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top"><form  name ="form1" method = "POST"  action = "<?  echo $PHP_SELF ; ?>" onSubmit="return ch();" >
                            <input TYPE="hidden" NAME="action" VALUE="<?=$action?>">
                            <input TYPE="hidden" NAME="refresh" id="refresh" VALUE="1">
							<input TYPE="hidden" NAME="position_now" VALUE="<?=$rs[position_now]?>">
							<input TYPE="hidden" NAME="radub" VALUE="<?=$rs[radub]?>">
                            <br>
<!--<div align="right"><a href="teaching.php?id=<?=$id?>">�Ԫҷ���͹</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div> -->					
                            <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
                              <tr>
                                <td bgcolor="#CACACA" onClick="javascript:swap('basicdata','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;</font></b><b class="gcaption"><font color="#000000"><img src="bimg/profile_expanded.gif" name="ctrlbasicdata" width="9" height="9" border="0" id="ctrlbasicdata" >&nbsp;&nbsp;&nbsp;�����ŷ����</font></b></td>
                              </tr>
                              <tr>
                                <td><div id=swapbasicdata>
                                  <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
                                    <tr>
                                      <td valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="2">
                                          <tr style="display:none;">
                                            <td align="center" colspan=2><strong>���ʺؤ��ҡ�</strong></td>
                                            <td colspan=8><strong>
                                              <input type="hidden" name="id" value="<?=$rs[id]?>"></strong></td>
                                          </tr>
                                          <tr>
                                            <td align="center" colspan=2><strong><?=TEXT_IDCARD?><br>
                                                <br>
                                                <br>
                                            </strong></td>
                                            <td colspan=8><?	
											$rs_idcard = $rs[idcard]  ; 
						// �Ѵ���ʻ�ЪҪ�
						$idcard1 = substr($rs[idcard],0,1);
						$idcard2 = substr($rs[idcard],1,4);
						$idcard3 = substr($rs[idcard],5,5);
						$idcard4 = substr($rs[idcard],10,2);
						$idcard5 = substr($rs[idcard],12,1);
/*
					  if ($action=='edit')
					  		{
							?>
                                                <b> <u>
                                                <?=$idcard1?>
                                                  -
                                                  <?=$idcard2?>
                                                  -
                                                  <?=$idcard3?>
                                                  -
                                                  <?=$idcard4?>
                                                  -
                                                  <?=$idcard5?>
                                                </u></b>
                                                <?
							}
							else
							{
							*/
							?>
                                                <input type="text" name="idcard1" size="1" value="<?=$idcard1?>" maxlength="1" onKeyUp="return autoTab(this, 1, event);" onChange="checkid();" onKeyDown="return Filter_Keyboard();" readonly onClick="return checkidcard();">
                                                <input type="text" name="idcard2" size="4" value="<?=$idcard2?>" maxlength="4" onKeyUp="return autoTab(this, 4, event);" onChange="checkid();" onKeyDown="return Filter_Keyboard();" readonly onClick="return checkidcard();">
                                                <input type="text" name="idcard3" size="5" value="<?=$idcard3?>" maxlength="5" onKeyUp="return autoTab(this, 5, event);" onChange="checkid();" onKeyDown="return Filter_Keyboard();" readonly onClick="return checkidcard();">
                                                <input type="text" name="idcard4" size="2" value="<?=$idcard4?>" maxlength="2" onKeyUp="return autoTab(this, 2, event);" onChange="checkid();" onKeyDown="return Filter_Keyboard();" readonly onClick="return checkidcard();">
                                                <input type="text" name="idcard5" size="1" value="<?=$idcard5?>" maxlength="1" onKeyUp="return autoTab(this, 1, event);" onChange="checkid();" onKeyDown="return Filter_Keyboard();" readonly onClick="return checkidcard();">
					<?
						//	}
	?>											</td>
                                          </tr>
                                          <tr>
                                            <td width="10%" align="right" valign="top">&nbsp;</td>
                                            <td width="21%" align="left" valign="top" class="textp">�ӹ�˹�Ҫ��� <font color="red">*</font></td>
                                            <td width="23%" align="left" valign="top" class="textp">���� <font color="red">*</font></td>
                                            <td width="25%" align="left" valign="top" class="textp">���ʡ�� <font color="red">*</font></td>
                                            <td width="21%" align="left" valign="top" class="textp">�����ͧ</td>
                                          </tr>
                                          <tr>
                                            <td align="right" valign="middle" class="textp">(��) </td>
                                            <td align="left" valign="top">
											  <input name="prename_th" type="text"  id="prename_th"  value="<?=$rs[prename_th]?>" size="20" readonly>
											  <input name="prename_id" type="hidden"  id="prename_id"  value="<?=$rs[prename_id]?>" size="20" readonly>                  						   </td>
                                            <td align="left" valign="top">
											<input name="name_th" type="text"  id="name_th"  value="<?=$rs[name_th]?>" size="20" readonly>											</td>
                                            <td align="left" valign="top"><input name="surname_th" type="text"   id="surname_th" value="<?=$rs[surname_th]?>" size="20" readonly>                                            </td>
                                            <td align="left" valign="top"><input name="secondname_th" type="text"   id="secondname_th" value="<?=$rs[secondname_th]?>" size="20" readonly>											</td>
                                          </tr>
                                          <tr>
                                            <td align="right" valign="middle" class="textp">(�ѧ���) </td>
                                            <td align="left" valign="top">
											<input name="prename_en" type="text"  id="prename_en"  value="<?=$rs[prename_en]?>" size="20" readonly>
										    </td>
                                            <td align="left" valign="top">
											<input name="name_en" type="text"   id="name_en" value="<?=$rs[name_en]?>" size="20" readonly>                                            </td>
                                            <td align="left" valign="top">
											<input name="surname_en" type="text"  id="surname_en"  value="<?=$rs[surname_en]?>" size="20" readonly>                                            </td>
                                            <td align="left" valign="top">
											<input name="secondname_en" type="text"  id="secondname_en"  value="<?=$rs[secondname_en]?>" size="20" readonly>                                            </td>
                                          </tr>
                                          <tr>
                                            <td align="right" valign="middle" class="textp">&nbsp;</td>
                                            <td colspan="4" align="left" valign="top" class="textp" id="his_name_text"> </td>
                                          </tr>
                                          <tr>
                                            <td colspan="5" align="center" valign="middle" class="textp">��ԡ����ͧ���ºǡ���� ����¹ ����-���ʡ�� (��Ңͧ������) 
                                            <input type="button" name="Button311" value=" + " title="����ѵԡ������¹�ŧ ����-ʡ�� (��Ңͧ������)" onClick="MM_openBrWindow('add_historyname.php','<?=$rs_idcard?>historyname','scrollbars=yes,width=700,height=550')"></td>
                                          </tr>
                                      </table></td>
                                      <td align="left" valign="top"><table border="0" cellspacing="0" cellpadding="0" align="center">
                                          <tr>
                                            <td valign="bottom" align="center"><?
//						 If ($rs[pic] =='')
//@20/7/2550
/*function get_picture($id){
	$imgpath = "images/personal/";
	$ext_array = array("jpg","jpeg","png","gif");
	if ($id <= "") return "";

	for ($i=0;$i<count($ext_array);$i++){
		$img_file = $imgpath . $id . "." . $ext_array[$i];
		if (file_exists($img_file)) return $img_file;
	}

	return "";
}


						$img_file = get_picture($id);
						 If ($img_file == "")
						 {*/
						 ?>
                                               <!-- <img src="../images/personnel/noimage.jpg" border="0" width="120" height="160">-->
                                                <?
						/* }else
						 {*/
						 ?>
                                       <!--         <img src="<?//=$img_file?>" border=0 width=150 height=180>-->
                                                <?
						// }
						 ?>
						 <?
						 $sql_showpic="select yy,imgname from general_pic where id='$id' and kp7_active='1' order by no  DESC ";
						$query=mysql_query($sql_showpic)or die("cannot query".mysql_error());
							$num_row=mysql_num_rows($query);
							$rs_pic=mysql_fetch_array($query);
							if($num_row <1){
							echo  "<img src='../../../images_sys/noimage.jpg' />";
							}else{
							echo "<img src=\"../../../../edubkk_image_file/$rs[siteid]/$rs_pic[imgname]\" width=120 height=160 >";
							}
						 
						 ?>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td valign="bottom" align="center"><div align="center">
<? /*											
<input class="xbutton" style="width: 150;" type="button" value="  ����ٻ�Ҿ  " onClick="window.open('pic.php?id=<?=$rs[id]?>','pic','location=0,status=1,scrollbars=0,menubar=0,width=500,height=250');" name="button">
*/
?>

                                            </div></td>
                                          </tr>
                                        </table>
                                          <br>
                                      </td>
                                    </tr>
                                  </table>
                                  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="0" class="textp">
                                    <tr>
                                      <td width="18%" height="25">�ѭ�ҵ�</td>
                                      <td width="43%" height="25"><input name="nationality" type="text"   value="<? if($rs[nationality]==""){ echo "��"; }else{ echo $rs[nationality]; } ?>" size="20" ></td>
                                      <td width="11%" height="25">���ͪҵ�</td>
                                      <td width="28%" height="25"><input name="citizenship" type="text"   value="<? if($rs[citizenship]==""){ echo " ��"; }else{ echo $rs[citizenship]; } ?>" size="20"></td>
                                    </tr>
                                    <tr>
                                      <td height="25">��ʹ�&nbsp; </td>
                                      <td height="25"><select name="region" style="width:125;">
                                          <option value="0"></option>
                                          <?
$r_result = mysql_query("select * from $dbnamemaster.hr_religion order by id");
while ($r_rs = mysql_fetch_assoc($r_result)){
	if ($rs[region] == $r_rs[id]){
		echo "<option value='$r_rs[id]' SELECTED>$r_rs[religion]</option>";
	}else{
		echo "<option value='$r_rs[id]'>$r_rs[religion]</option>";
	}
}
?>
                                        </select>
                                          <!--<input type="button" name="btnNewReligion" value=" + " onClick="MM_openBrWindow('addreligion.php','addreligion','scrollbars=yes,width=600,height=500')"> --></td>
                                      <td height="25">�� <font color="red">*</font></td>
                                      <td height="25">
									  <?
									  $strSQL="select prename_th.gender as id ,gender.gender from $dbnamemaster.prename_th Inner Join $dbnamemaster.gender ON prename_th.gender = gender.id where PN_CODE = '$rs[prename_id]'";
									  $gender_result = mysql_query($strSQL);
									  $rs_gm=mysql_fetch_assoc($gender_result);
									  $sex_select=($rs_gm[gender])?$rs_gm[gender]:$rs[sex];									  
									  if(intval($rs_gm[id])>0){
									  	$only_once_gender="disabled";
										$input_plus="<input name='sex_h' id='sex' type='hidden' value='$sex_select'>";
										echo "<input type='hidden' name='gender_id' value='$rs_gm[id]'>";
										echo $input_plus;
									  }											
									  ?>
									  <select name="sex" id="sex"  <?=$only_once_gender?> >
											<?
											$strSQL="select * from $dbnamemaster.gender";
											$gender_result = mysql_query($strSQL);
											while($rs_sex=mysql_fetch_assoc($gender_result)){
												if ($rs_sex[gender] == $sex_select){ $sel="selected"; }else{ $sel=""; }
													echo "<option value='$rs_sex[gender]' $sel >$rs_sex[gender]</option>";
											}
											?>
                                        </select>                                      </td>
                                    </tr>
                                    <tr><? 
									# �Դ���͹䢡�õ�Ǩ�ͺ�������ѹ��͹���Դ
										/*	if(CheckFlagEditBirthday($rs[idcard]) == "1"){
												$dateshow = "";
												$xflag_edit = 1;
											}else{
												$d=explode("-",$rs[birthday]);
												$dateshow=$d[2]."/".$d[1]."/".$d[0];
												$xflag_edit = 0;
											}*/ 
											
												$d=explode("-",$rs[birthday]);
												$dateshow=$d[2]."/".$d[1]."/".$d[0];
												$xflag_edit = 0;
									?>
                                      <td height="25">�ѹ��͹���Դ</td>
                                      <script>
                                      function getStringParam(filename){
									   			str=filename;
												str+='?';
												str+='&tempBirth='+$('#birthd').val();
												//str+='&tempName='+$('#prename_th').val()+$('#name_th').val()+"    "+$('#surname_th').val();
												str+='&tempIdcard=<?=$rs[id]?>';												
												return str;
									   }
                                      </script>
                                      <td height="25" colspan="3">
                                       <?php 
										if(empty($rs["birthday_label"])){
											$new_birthday_label=explode("-",$rs["birthday"]);
											$th_date=showthaidate("$new_birthday_label[2]")." ".month_nameth("$new_birthday_label[1]")." ".showthaidate("$new_birthday_label[0]");
											$call_ajax="onBlur=ajax_showdatethai();";
											$c_a=0;
										}else{
											$th_date=$rs["birthday_label"];
											$call_ajax=" "; $c_a=1;
										}
										#echo $rs["birthday"];
											?>
                                       <input name="birthd" id="birthd" value="<?=$dateshow ?>" maxlength="10" <?=$call_ajax?>  type="text"/>
                                       <input class="index2" style="FONT-SIZE: 11px; WIDTH: 80px" name="birthd_but" id="button2" type="button" onClick="popUpCalendar(this, form1.birthd, 'dd/mm/yyyy','disp_date(\'birthd\',form1.birthd.value,\'button2\',\'birthd\')');" value="�ѹ ��͹ ��" call="<?=$c_a?>" >
                                        <a href="tool_type_showdate.php?pic=1" class="jTip" id="1" ><input type="button" name="typedate" id="typedate" value=" �ٻẺ�ѹ�����ǹ 1 "  onClick="MM_openBrWindow(getStringParam('type_showdate.php'),'<?=$idcard;?>','scrollbars=yes,width=1000,height=600')"></a>
                                        <?
                                      $sql77="SELECT type_dateshow  from general where idcard='$_SESSION[idoffice]' ";
									 $q77=mysql_db_query($dbname,$sql77)or die (mysql_error());
									 $rs77=mysql_fetch_assoc($q77);
									 if($rs77[type_dateshow] !=341 and  $rs77[type_dateshow] !=351 and $rs77[type_dateshow] !=361 and $rs77[type_dateshow] !=371 )
									 {
									 $typeshow=341;
									 }
									 else
									 {
										$typeshow=$rs77[type_dateshow] ;
									 }
									 
									 $sql78="SELECT * FROM  type_showdate where id_type='$rs77[type_dateshow]' and type_nec='n' ";
									 $q78=mysql_db_query($dbname,$sql78)or die (mysql_error());
									 $rs78=mysql_fetch_assoc($q78);
									  ?>

                                      <input name="label_type_showdate" id="label_type_showdate" type="text"  value="<?=$rs78[type_date]?>"   size="-1" style="width:0px; border:#FFF 1px solid; color:#FFF;" >
                                      <input  type="hidden" name="chk_type_showdate"  id="chk_type_showdate" value="true"  />
                                        &nbsp;
                                       <a href="tool_type_showdate.php?pic=2" class="jTip" id="2" ><input type="button" name="typedate2" value=" �ٻẺ�ѹ�����ǹ 2 " onClick="MM_openBrWindow(getStringParam('type_showdate2.php'),'<?=$idcard;?>','scrollbars=yes,width=1000,height=600')"></a><span id='div_txt_birthd'></span>
                                      
                                      
                                      <?
                                      $sql77_1="SELECT type_dateshow2  from general where idcard='$_SESSION[idoffice]' ";
									 $q77_1=mysql_db_query($dbname,$sql77_1)or die (mysql_error());
									 $rs77_1=mysql_fetch_assoc($q77_1);
									 
									 $sql78_1="SELECT * FROM  type_showdate where id_type='$rs77_1[type_dateshow2]' and type_nec='n' ";
									 $q78_1=mysql_db_query($dbname,$sql78_1)or die (mysql_error());
									 $rs78_1=mysql_fetch_assoc($q78_1);
									  ?>
                                      <input name="label_type_showdate2" id="label_type_showdate2" type="text"  value="<?=$rs78_1[type_date]?>"  size="-1" style="width:0px; border:#FFF 1px solid; color:#FFF;"  >
                                      <input  type="hidden" name="chk_type_showdate2"  id="chk_type_showdate2" value="true"  />
                                      </td>
                                    </tr>
                                    <tr>
                                      <td height="25">&nbsp;</td>
                                      <td height="25" colspan="3"><label>
                                        <input type="text" name="birthday_label" id="birthday_label"  value="<?=$th_date?>" style="width:200px; text-align:left;">
                                        <input  type="hidden" name="chk_birthd"  id="chk_birthd" value="true"  />
                                        <span class="style1">
                                        <?php /*?><input  type="text" name="chk_birthAll"  id="chk_birthAll" value="true"  />
                                        <span id='msg_birth_label' class='span_check'></span><?php */?>
                                        <br>
                                        �ҡ�ѹ�֡㹪�ͧ����к��д֧��ʴ���ѹ��͹���Դ ��ǹ��ѧ� �.�. 7 �� �ҡ�ѹ��͹���Դ�� 22/02/2500 ���ʴ����� ����Ժ�ͧ����Ҿѹ���ͧ�ѹ�������</span></label></td>
                                    </tr>
                                    <tr>
                                      <td height="25">���������Դ 
                                        (�ѧ��Ѵ)</td>
                                      <td height="25">  
<select name="home" class="input" style="width:150px;">
	<option value="">���͡�ѧ��Ѵ</option>
<?
 $selected =""; 
$result = mysql_query("select * from $dbnamemaster.hr_province where 1  order by   province ")or die("Query line " . __LINE__ . " Error<hr>".mysql_error());
while($hrs = mysql_fetch_assoc($result)){
	if($hrs[id] == $rs[home]){ $selected = "selected"; }   else{ $selected =""; }
	echo "<option value=\"$hrs[id]\" $selected>$hrs[province]</option> \n ";
 }
mysql_free_result($result);
 ?>			         
	</select></td><td height="25" colspan="2">�������Ե&nbsp;
	<select name="blood" style="width:100;">
		<!--<option value="0"></option>-->
		<?
		$strSQL="select * from $dbnamemaster.hr_blood order by id";
		$r_result = mysql_query($strSQL);
		while ($r_rs = mysql_fetch_assoc($r_result)){
		$xblood = ($rs[blood_id])?$rs[blood_id]:"5";		
			if ($xblood == $r_rs[id]){
				echo "<option value='$r_rs[id]' SELECTED>$r_rs[blood]</option>";
			}else{
				echo "<option value='$r_rs[id]'>$r_rs[blood]</option>";
			}
		}
		?>
	</select>
                                      <!--<input type="button" name="btnNewBlood" value=" + " onClick="MM_openBrWindow('addblood.php','addblood','scrollbars=yes,width=600,height=500')">         -->                             </td>
                                    </tr>
<tr>
	<td height="25">���ͺԴ�</td>
	<td colspan="3"><p>

		<input name="father_prename" type="text" id="father_prename" value="<?=$rs[father_prename]?>" size="20" readonly>
	  ���� 
	  <input name="father_name" type="text" id="father_name"  value="<?=$rs[father_name]?>" size="30" readonly>
	  ���ʡ�� 
	  <input name="father_surname" type="text" id="father_surname" value="<?=$rs[father_surname]?>" size="30" readonly>
	  <input type="button" name="Buttonfather" value=" + " title="����ѵԡ������¹�ŧ ����-ʡ�� (�Դ�)" onClick="MM_openBrWindow('add_historyfathername.php','<?=$rs_idcard?>historyfather','scrollbars=yes,width=700,height=500')">	 
	    <br>
	    ��ԡ����ͧ���ºǡ���� ����¹ ����-���ʡ�� (�Դ�)  </p>	  </td>										 
</tr>
<tr>
	<td height="20">�Ҫվ�Դ�</td>
	<td colspan="3"><input name="father_occ" type="text"  id="father_occ"  value="<?=$rs[father_occ]?>" size="35" readonly></td>
</tr>
<tr>
	<td height="25">������ô�</td>
	<td colspan="3">
	<input name="mother_prename" type="text"  id="mother_prename"  value="<?=$rs[mother_prename]?>" size="20" readonly>
	���� <input name="mother_name" type="text"  id="mother_name"  value="<?=$rs[mother_name]?>" size="30" readonly>
	���ʡ�� <input name="mother_surname" type="text"  id="mother_surname"  value="<?=$rs[mother_surname]?>" size="30" readonly> 
	<input type="button" name="Buttonmother" value=" + " title="����ѵԡ������¹�ŧ ����-ʡ�� (��ô�)" onClick="MM_openBrWindow('add_historymothername.php','<?=$rs_idcard?>historymother','scrollbars=yes,width=700,height=500')">	 <br>
	��ԡ����ͧ���ºǡ���� ����¹ ����-���ʡ�� (��ô�) </td>										 
</tr>									
<tr>
	<td height="20">�Ҫվ��ô�</td>
	<td colspan="3"><input name="mother_occ" type="text"  id="mother_occ"  value="<?=$rs[mother_occ]?>" size="35" readonly></td>
</tr>
<tr>
	<td height="25">ʶҹ�Ҿ����</td>
	<td height="25" colspan="3">
	<?php /*?><select name="marry"  style="width:200;" >
	<!--<option value="0"></option>-->
<?
		$select1  = mysql_query("select  marriage,runid from $dbnamemaster.hr_addmarriage order by marriage;");
	
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))
		{
		$xmarrital = ($rs[marital_status_id])?$rs[marital_status_id]:"5";
		if ($rselect1[runid] == $xmarrital )
		{ 			
			echo "<option value='$rselect1[runid]' SELECTED>$rselect1[marriage]</option>";
		}else
			{
			echo "<option value='$rselect1[runid]' >$rselect1[marriage]</option>";
			}
		}//end while
?>
	</select><?php */?>
      <!--   
<input type="button" name="Button2432" value=" + " onClick="MM_openBrWindow('addmarriage.php','addmarriage','scrollbars=yes,width=600,height=500')">
-->
<?php /*?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--   
<input type="button" name="Button2432" value=" + " onClick="MM_openBrWindow('addmarriage.php','addmarriage','scrollbars=yes,width=600,height=500')">
-->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--   
<input type="button" name="Button2432" value=" + " onClick="MM_openBrWindow('addmarriage.php','addmarriage','scrollbars=yes,width=600,height=500')">
-->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--   
<input type="button" name="Button2432" value=" + " onClick="MM_openBrWindow('addmarriage.php','addmarriage','scrollbars=yes,width=600,height=500')">
-->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--   
<input type="button" name="Button2432" value=" + " onClick="MM_openBrWindow('addmarriage.php','addmarriage','scrollbars=yes,width=600,height=500')">
-->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--   
<input type="button" name="Button2432" value=" + " onClick="MM_openBrWindow('addmarriage.php','addmarriage','scrollbars=yes,width=600,height=500')">
-->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--   
<input type="button" name="Button2432" value=" + " onClick="MM_openBrWindow('addmarriage.php','addmarriage','scrollbars=yes,width=600,height=500')">
-->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--   
<input type="button" name="Button2432" value=" + " onClick="MM_openBrWindow('addmarriage.php','addmarriage','scrollbars=yes,width=600,height=500')">
-->

      <!--   
<input type="button" name="Button2432" value=" + " onClick="MM_openBrWindow('addmarriage.php','addmarriage','scrollbars=yes,width=600,height=500')">
-->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php */?>

<?
		$strSQL="SELECT count(gen_id) as kp7a FROM `hr_addhistorymarry` WHERE `gen_id` LIKE '%$rs[id]%' AND `kp7_active` LIKE '%1%' AND hr_addhistorymarry.name_th !=  '' ";
		$resultSQL_kp7_active = @mysql_query($strSQL) ;
		$rsKPactive=@mysql_fetch_assoc($resultSQL_kp7_active);
		$kp7active=$rsKPactive[kp7a];
?>	
<input type="hidden" name="marry_kp7_active" id="marry_kp7_active" value="<?=$kp7active?>">
<select name="marry_kp7"  style="width:100;" >
	    <!--<option value="0"></option>-->
	    <?
		$select1  = mysql_query("select  marriage,runid from $dbnamemaster.hr_addmarriage order by marriage;");
	
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))
		{
		$xmarrital_kp7 = ($rs[marital_kp7_status_id])?$rs[marital_kp7_status_id]:"5";
		if ($xmarrital_kp7 == $rselect1[runid])
		{ 			
			echo "<option value='$rselect1[runid]' SELECTED>$rselect1[marriage]</option>";
		}else
			{
			echo "<option value='$rselect1[runid]' >$rselect1[marriage]</option>";
			}
		}//end while
?>
	      </select>
      <!--   
<input type="button" name="Button2432" value=" + " onClick="MM_openBrWindow('addmarriage.php','addmarriage','scrollbars=yes,width=600,height=500')">
-->
<!--&nbsp;ʶҹ�Ҿ���ʵ�� �.�.7 --></td>
	</tr>
<tr>
	<td height="25">���ͤ������</td>
	<td colspan="3">
	<input type="text" name="marry_prename"  id="marry_prename" value="<?=$rs[marry_prename]?>" size="20" readonly>
	���� <input name="marry_name" type="text"  id="marry_name"  value="<?=$rs[marry_name]?>" size="30" readonly> 
	���ʡ�� <input name="marry_surname" type="text" id="marry_surname" value="<?=$rs[marry_surname]?>" size="30" readonly>
	<input type="button" name="Button31232" value=" + " title="����ѵԡ������¹�ŧ ����-ʡ�� (�������)" onClick="MM_openBrWindow('add_historymarry.php','<?=$rs_idcard?>historymarry','scrollbars=yes,width=700,height=500')">
	<br>
	��ԡ����ͧ���ºǡ���� ����¹ ����-���ʡ�� (�������)</td>										 
</tr>
<tr>
	<td height="20">�Ҫվ�������</td>
	<td colspan="3"><input name="marry_occ" type="text"  id="marry_occ" value="<?=$rs[marry_occ]?>" size="35" readonly></td>
</tr>
<tr>
  <td height="20">ʶҹС������Ҫԡ���.<font color="red">*</font></td>
  <td colspan="3">
  <?
  	$rs[status_gpf]  = 2;# �繤�� default ��������Ҫԡ ���.
  ?>
    <select name="status_gpf" id="status_gpf">
    <option value="0">- ���͡ʶҹ� -</option>
    <?
    	$sql_gpf = "SELECT * FROM tbl_status_gpf ORDER BY runid ASC";
		$result_gpf = mysql_db_query($dbnamemaster,$sql_gpf);
		while($rs_gpf = mysql_fetch_assoc($result_gpf)){
			if($rs[status_gpf] == $rs_gpf[runid]){ $sel_gpf = " selected='selected'"; $dis_op = '';}else{ $sel_gpf = ""; $dis_op = " disabled";}
			echo "<option value='$rs_gpf[runid]' $sel_gpf $dis_op>$rs_gpf[gpf_detail]</option>";
		}//end while($rs_gpf = mysql_fetch_assoc($result_gpf)){
	?>
    </select>
</td>
</tr>
                                    <tr>
                                      <td height="25" colspan="4" bgcolor="#CACACA" class="gcaption">&nbsp; &nbsp; �������Ѩ�غѹ ��� �������Ӥѭ����� </td>
                                    </tr>
                                    <tr>
                                      <td height="25">�������Ѩ�غѹ(��� �.�.7)</td>
                                      <td height="25" colspan="3"><input name="contact_add"  id="contact_add" type="text" value="<?=$rs[contact_add]?>" size="50" readonly >
                                      <input type="button" name="Button3123" value=" + " title="����ѵԡ������¹�ŧ(�������)" onClick="MM_openBrWindow('<?=$addr_page?>','<?=$rs_idcard?>historyaddress','scrollbars=yes,width=700,height=500')"> 
                                      
                                      <!--   
<input type="button" name="Button2432" value=" + " onClick="MM_openBrWindow('addmarriage.php','addmarriage','scrollbars=yes,width=600,height=500')">
-->
&nbsp;&nbsp;&nbsp;&nbsp;
<!--   
<input type="button" name="Button2432" value=" + " onClick="MM_openBrWindow('addmarriage.php','addmarriage','scrollbars=yes,width=600,height=500')">
-->���Ѿ��
                                        
                                      <input name="contact_tel" id="contact_tel" type="text"   value="<?=$rs[contact_tel]?>" size="35" >                                      </td>
                                    </tr>
                                    
                                    <tr>
                                      <td>&nbsp;</td>
                                      <td> ��ԡ����ͧ���ºǡ��������¹�ŧ (�������)</td>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                    </tr>
                                  </table>
                                  <br>
                                </div></td>
                              </tr>
                            </table>
                            <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
                              <tr>
                                <td bgcolor="#CACACA" onClick="javascript:swap('officer','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;</font></b><b><font color="#000000"><img src="bimg/profile_expanded.gif" name="ctrlofficer" width="9" height="9" border="0" id="ctrlofficer" >&nbsp;&nbsp;&nbsp;&nbsp;</font></b><b class="gcaption"><font color="#000000">���������Ѻ�Ҫ���</font></b></td>
                              </tr>
                              <tr>
                                <td><div id=swapofficer>
                                  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="0" class="textp">
                                    <tr>
                                      <td height="25">����������Ҫ���</td>
                                      <td height="25"><?php /*?><select name="persontype2_now"  style="width:280;" >
									  <? 	$select1  = mysql_query("select  persontype from $dbnamemaster.hr_addpersontype order by persontype");?>
  <option value="<? if($rs[persontype2_now]=="0"){echo"selected";}?>">����к��</option>
                                        <?
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))
		{
		if ($rs[persontype2_now] == $rselect1[persontype])
		{ 			
			echo "<option value='$rselect1[persontype]' selected>$rselect1[persontype]</option>";
		}else
			{
			echo "<option value='$rselect1[persontype]' >$rselect1[persontype]</option>";
			}
		}//end while
?>
                                      </select><?php */?>
                                      <input name="label_persontype2now" id="label_persontype2now" type="text" value="<?=$rs[label_persontype2now]?>" size="30" maxlength="255" onKeyPress="isThaichar(this.value,'label_persontype2now','')" onKeyUp="isThaichar(this.value,'label_persontype2now','')" onBlur="isThaichar(this.value,'label_persontype2now','full')"></td>
                                      <td width="10%" height="25">&nbsp;</td>
                                      <td height="25">&nbsp;</td>
                                    </tr>
                                    <?php /*?><tr>
                                      <td height="25">&nbsp;</td>
                                      <td height="25" colspan="3" align="left"><input name="label_persontype2now" type="text" value="<?=$rs[label_persontype2now]?>" size="30" maxlength="255">
&nbsp;<br>
<span class="style1">�ҡ��ҹ�ѹ�֡㹪�ͧ�ʴ��� ��.7 �к��йӢ����Ź���ʴ���� ��.7 ᷹</span></td>
                                    </tr><?php */?>
						<? $xd2=explode("-",$rs[startdate]);  ?>
                                    <tr>
                                      <td height="25">�ѹ��觺�è�</td>
                                      <td height="25">�ѹ���
                                        <select name="startday" id="startday">
                                          <?
/*for ($i=1;$i<=31;$i++){
	if (intval($xd2[2])== $i){
		echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option value=\"".sprintf("%02d",$i)."\" >" .  sprintf("%02d",$i) . "</option>";
	}
}*/
?>
                                        </select>
                                        ��͹
<select name="startmonth"  id="startmonth">
  <?
/*for ($i=1;$i<=12;$i++){
		$numbermonth = sprintf("%02d",$i);
		if ($xd2[1] == $numbermonth ){  
		echo "<option  value=$numbermonth selected>".$monthname[$i]."</option>";}
		else
		{
		echo "<option  value=$numbermonth >".$monthname[$i]."</option>";}
}*/
?>
</select>

                                        �.�.
  <select name="startyear" id="startyear">
  <?
/* $thisyear = date("Y") + 543;
$y1 = $thisyear - 80;
$y2 = $thisyear ;
					
for ($i=$y2;$i>=$y1;$i--){
	if ($xd2[0]== $i){
		echo "<option  value=\"".$i."\" SELECTED>$i</option>";
	}else{
		echo "<option  value=\"".$i."\">$i</option>";
	}
}*/

?>
</select>

 <input  type="hidden" name="startdate_value"  id="startdate_value" value=""  />
  <input  type="hidden" name="chk_startdate"  id="chk_startdate" value="true"  />
  <script>
	
	generate_calendarlist('startdate_value','startdate_label','startday','startmonth','startyear','<?=$xd2[2]?>','<?=$xd2[1]?>','<?=$xd2[0]?>');
</script>  
 										</td>
                                      <td height="25">&nbsp;</td>
                                      <td height="25">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td height="25">&nbsp;</td>
                                      <td height="25" colspan="3" align="left"><label>
                                        <input name="startdate_label" id="startdate_label" type="text" size="25" value="<?=$rs[startdate_label]?>">
                                        <br>
                                        <span class="style1">�ҡ��ҹ�ѹ�֡㹪�ͧ�ʴ��� ��.7 �к��йӢ����Ź���ʴ���� ��.7 ᷹</span></label></td>
                                    </tr>
                                    <tr>
                                      <td width="18%" height="25">�ѹ�������Ժѵ��Ҫ���
                                        <?
						   $d2=explode("-",$rs[begindate]);
						   
						   ?>                                      </td>
                                      <td width="42%" height="25">
                                        �ѹ���
                                        <select name="beginday" id="beginday" <?php /*?>onChange="check_date('beginday','beginmonth','beginyear');"<?php */?> ></select>
                                          <?
/*for ($i=1;$i<=31;$i++){
	if (intval($d2[2])== $i){
		echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option value=\"".sprintf("%02d",$i)."\" >" .  sprintf("%02d",$i) . "</option>";
	}
}*/
?>
                                        
                                        ��͹
<select name="beginmonth"  id="beginmonth" <?php /*?>onChange="check_date('beginday','beginmonth','beginyear');"<?php */?> ></select>
  <?
/*for ($i=1;$i<=12;$i++){
		$numbermonth = sprintf("%02d",$i);
		if ($d2[1] == $numbermonth ){  
		echo "<option  value=$numbermonth selected>".$monthname[$i]."</option>";}
		else
		{
		echo "<option  value=$numbermonth >".$monthname[$i]."</option>";}
}*/
?>

	<?									
  //<select name="beginmonth" >
    //<?
/*for ($i=1;$i<=12;$i++){
	if (intval($d2[1])== $i){
		echo "<option value=\"".sprintf("%02d",$i)."\"  SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option value=\"".sprintf("%02d",$i)."\" >" .  sprintf("%02d",$i) . "</option>";
	}

}
  </select>*/?>
                                        �.�.
  <select name="beginyear" id="beginyear" <?php /*?>onChange="check_date('beginday','beginmonth','beginyear');"<?php */?>></select>
  <?
/*					  $thisyear = date("Y") + 543;
$y1 = $thisyear - 80;
$y2 = $thisyear ;
					
for ($i=$y2;$i>=$y1;$i--){
	if ($d2[0]== $i){
		echo "<option  value=\"".$i."\" SELECTED>$i</option>";
	}else{
		echo "<option  value=\"".$i."\">$i</option>";
	}
}*/

	 $diff  = dateLength($rs[begindate]);

?>

  <?php /*?><input type="button" name="showbegindate" value=" + " title="���͡�ٻẺ����ʴ����ѹ��� ���ǹ �ѹ�������Ժѵԧҹ" onClick="MM_openBrWindow('type_showbegindate.php','<?=$idcard;?>','scrollbars=yes,width=1000,height=600')"><?php */?>
   <input  type="hidden" name="begin_value"  id="begin_value" value=""  />
  <input  type="hidden" name="chk_begin"  id="chk_begin" value="true"  />
   <script>
 	generate_calendarlist('begin_value','begindate_label','beginday','beginmonth','beginyear','<?=$d2[2]?>','<?=$d2[1]?>','<?=$d2[0]?>');
	<?php /*?>create_calendar('beginday','beginmonth','beginyear','<?=$d2[2]?>','<?=$d2[1]?>','<?=$d2[0]?>');<?php */?>
</script> 
  </td><td height="25">�����Ҫ���</td>
	<td width="30%" height="25">&nbsp;
<?
if ($rs[begindate] != ""){
	echo "<u>".$diff[year]."</u>&nbsp;��&nbsp;&nbsp;<u>".$diff[month]."</u>&nbsp;��͹&nbsp;&nbsp;<u>".$diff[day]."</u>&nbsp;�ѹ";
}else{
  	echo "-";
}
?>	</td>
</tr>
<tr>
                                      <td height="25">&nbsp;</td>
                                      <td height="25" colspan="3" align="left"><label>
                                        <input name="begindate_label" id="begindate_label" type="text" size="25" value="<?=$rs[begindate_label]?>">
                                        <br>
                                        <span class="style1">�ҡ��ҹ�ѹ�֡㹪�ͧ�ʴ��� ��.7 �к��йӢ����Ź���ʴ���� ��.7 ᷹</span></label></td>
                                    </tr>
<?php /*?><tr>
	<td width="18%" height="25">���˹� </td>
	<td width="42%" height="25"><? //echo "$rs[position]";?><select name="pid_begin"  style="width:280;" >
	<?  $select1  = mysql_query("select pid, position from $dbnamemaster.hr_addposition_now order by trim(position) ASC;");?>
	<option value="<?  if($rs[position]==""){echo "selected";}?>">����к�</option>
<?
	//$found = false;
	while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))
	{
		if ($rs[pid_begin] == $rselect1[pid])
		{ 			
		//	$found = true;
			echo "<option value='$rselect1[pid]' SELECTED>$rselect1[position]</option>";
		}else	{
			echo "<option value='$rselect1[pid]' >$rselect1[position]</option>";
		}
	}//end while
	//if(!$found){
		//echo "<option value='$rs[pid_begin]' selected>$rs[position_now]</option>";
	//}	
//unset($found);
?>
</select>
                                      <!--
                                        <input type="button" name="Button242222" value=" + " onClick="MM_openBrWindow('addposition.php','addposition','scrollbars=yes,width=600,height=500')">
                                        -->                                        </td>
                                      <td height="25">�дѺ</td>
                                      <td width="30%" height="25">
                                      <? 
//									  if($rs[radub_past_id] != ""){
//										  	$sql_radub1 = "SELECT * FROM hr_addradub WHERE level_id='$rs[radub_past_id]'";
//											 $result_radub1 = mysql_db_query($dbnamemaster,$sql_radub1);
//											$rsr1 = mysql_fetch_assoc($result_radub1);
//											echo  "$rsr1[radub]";	  
//										  
//										}else{
//											echo "$rs[radub_past]";	
//										}
										 ?>
                                      
                                      
                                      <select name="radub_past_id" style="width:100px;" >
									  <option value=""></option>
                                        <?
		$select1  = mysql_query("select  * from $dbnamemaster.hr_addradub order by cast(radub as unsigned);");
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC)){
				if($rs[radub_past_id] != ""){ if($rselect1[level_id] == $rs[radub_past_id]){ $sel = "selected='selected'";}else{ $sel = "";}}else{ if($rs[radub_past] == $rselect1[radub]){ $sel = "selected";}else{ $sel = "";}}

				echo "<option value='$rselect1[level_id]' $sel >$rselect1[radub]</option>";

		}//end while
?>
                                      </select>
                                        <!--
                                        <input type="button" name="Button2452" value=" + " onClick="MM_openBrWindow('addradub_old.php','addradub','scrollbars=yes,width=600,height=500')">
                                        -->                                        </td>
                                    </tr><?php */?>
<tr>
<td width="18%" height="25">�ѹ�ú���³����</td>
<td width="42%" height="25"><font color="#716F6F"><?=retireDate($rs[birthday])?>
  <input type="hidden" name="retire_value" id="retire_value" value="<?=("30/09/".substr(retireDate($rs[birthday]),strlen(retireDate($rs[birthday]))-4))?>" size="25">
  <input type="hidden" name="retire_valueLOG" id="retire_valueLOG" value="<?=retireDate($rs[birthday])?>" size="25">
  <input  type="hidden" name="chk_retire"  id="chk_retire" value="true"  />
</font></td>
<td height="25">&nbsp;</td>
<td width="30%" height="25">&nbsp;</td>
</tr>
<tr>
  <td height="25">&nbsp;</td>
  <td height="25" colspan="3" align="left">
                                        <input type="text" name="retire_label" id="retire_label" value="<?=$rs[retire_label]?>" size="25">

										<span class="style1"><br>
										�ҡ��ҹ�ѹ�֡㹪�ͧ�ʴ��� ��.7 �к��йӢ����Ź���ʴ���� ��.7 ᷹</span></td>
  </tr>
                                  </table>
                                </div></td>
                              </tr>
                            </table>
                            <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
                              <tr>
                                <td bgcolor="#CACACA" onClick="javascript:swap('now','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;</font></b><b><font color="#000000"><img src="bimg/profile_expanded.gif" name="ctrlnow" width="9" height="9" border="0" id="ctrlnow" >&nbsp;&nbsp;&nbsp;&nbsp;</font></b><b class="gcaption"><font color="#000000">����Ѻ�Ҫ��ûѨ�غѹ</font></b></td>
                              </tr>
                              <tr>
                                <td><div id=swapnow>
                                  <table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="textp">
                                    <tr>
                                      <td width="18%" height="25"><!-- ���˹觷ҧ��ú����� -->��������˹�</td>
									  
							<? 	$select1  = mysql_query("select *  from $dbnamemaster.hr_positiongroup ;");?>
                                      <td width="44%" height="25"><select name="positiongroup"   id="positiongroup"  style="width:300; color:green;"  onFocus='this.blur(); return false;' disabled>
                                   <option value="0"<? if($rs[positiongroup]=="0"){echo "selected";}?> style="color:#009900; font-weight:bold;">����к�</option>
                                        <?
	
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC)) 
		{
		if ($rs[positiongroup] == $rselect1[positiongroupid]||substr( $rs[pid],0,1) == $rselect1[positiongroupid] )
		{ 			
			echo "<option value='$rselect1[positiongroupid]' SELECTED>$rselect1[positiongroup]</option>";
		}else
			{
			echo "<option value='$rselect1[positiongroupid]' >$rselect1[positiongroup]</option>";
			}
		}//end while
?>
                                      </select></td>
                                      <td width="8%">&nbsp;</td>
                                      <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td width="18%" height="25">�ҹ/����/������ҹ <?php if($rs[positiongroup] == '2'){echo '<font color="red">*</font>';}?></td>
                                      <?php
									  	if( $rs[positiongroup] != '2' ){
											$disable = ' disabled="disabled" ';
										}else{
											$disable = '';
										}
									  ?>
                                      <td width="44%"><select name="work" id="work"  style="width:300; color:green" <?php echo $disable;?> > 
									   <option value="0"<? if($rs[work]=="0"){echo "selected";}?>>����к�</option>
									    <? $select1  = mysql_query("select *  from $dbnamemaster.hr_work ;");?>
                                        <? while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))
                                            {
                                            if ($rs[work] == $rselect1[workid])
                                            { 			
                                            echo "<option value='$rselect1[workid]'SELECTED>$rselect1[work]</option>";
                                            }else
                                            {
                                            echo "<option value='$rselect1[workid]' >$rselect1[work]</option>";
                                            }
                                            }//end while
                                        ?>
                                        </select></td>
                                      <td>&nbsp;</td>
                                      <td width="30%">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td width="18%" height="25">˹��§ҹ</td>
                                      <td width="44%" height="25">
<?
						$ngroup = 0;
						$groupid = Array();
						$gresult = mysql_query("select  *  from  $dbnamemaster.eduarea where secid='$rs[siteid]';");
						$grs=mysql_fetch_array($gresult,MYSQL_ASSOC);		
						$grs_secname = $grs[secname] ; 		
						
						######################### ��Ǩ�ͺ�ó� �ç���¹��鹶١ lock �������ա�����
						$sql_lock_school = "SELECT * FROM allschool WHERE id='$rs[schoolid]'";
						$result_lock_school = mysql_db_query($dbnamemaster,$sql_lock_school);
						$rs_lock = mysql_fetch_assoc($result_lock_school);
							if($rs_lock[lock_school] == "1"){
								if($_SESSION['session_sapphire'] != "1"){
									$dis_lock = "disabled='disabled'";
								}else{
									$dis_lock = "";
								}// end if($_SESSION['session_sapphire'] != "1"){
							}else{
								$dis_lock = "";
							}
						
						
					
					####  ��������Դ��������ª����� ��ѡ�ҹ��Ш��� ���Ѳ	
						if($_SESSION['session_sapphire'] != "1"){
							$dis_lock = "disabled='disabled'";
						}else{
							$dis_lock = "";
						}// end if($_SESSION['session_sapphire'] != "1"){
						
						
?>									  <!--width:300;-->
									
                                        <select name="schoolid" style="color:green" <?=$dis_lock?>  >       
										<option value="">  ����к�  </option>
                       <?
						if($rs[schoolid] ==""){
					//			echo "<option value='".$_SESSION[secid]."' SELECTED>$grs_secname</option>";						
					//	}	######	if($rs[schoolid] != ""){					
						//echo "<option value=''  >�ô�к�</option>";	
						}	
						$usql="SELECT * from $dbnamemaster.allschool where  siteid = '$rs[siteid]'  order by office   ";
						$uresult = mysql_query( $usql );
						while($urs=mysql_fetch_array($uresult,MYSQL_ASSOC)){
							## �����
							$sql_aumpur = "SELECT ccName  FROM `ccaa` where areaid LIKE '".substr($urs[moiareaid],0,4)."%' and ccType='Aumpur'";
							$result_aumpur = mysql_db_query($dbnamemaster,$sql_aumpur) or die(mysql_error()."$sql_aumpur<br>LINE__".__LINE__);
							$rsaum = mysql_fetch_assoc($result_aumpur);
							## �Ӻ�
							$sql_tumbon = "SELECT ccName  FROM `ccaa` where areaid LIKE '".substr($urs[moiareaid],0,6)."%' and ccType='Tamboon'";
							$result_tumbon = mysql_db_query($dbnamemaster,$sql_tumbon) or die(mysql_error()."$sql_tumbon<br>LINE__".__LINE__);
							$rstum = mysql_fetch_assoc($result_tumbon);
							
							$aumpur_tumbon = " [ ".$rsaum['ccName']."   ".$rstum['ccName']." ]";
							if($urs[id]==$rs[schoolid]){
								echo "<option value='$urs[id]' SELECTED>$urs[prefix_name]$urs[office]".$aumpur_tumbon."</option>";
							}else{
								echo "<option value='$urs[id]'>$urs[prefix_name]$urs[office]".$aumpur_tumbon."</option>";
							} ## if($urs[id]==$rs[schoolid]){ 
						} ## while($urs=mysql_fetch_array($uresult,MYSQL_ASSOC)){

												
					?>
                                      </select></td>
                                      <td height="25">&nbsp;</td>
                                      <td width="30%" height="25">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td height="25">�ѧ�Ѵ</td>
                                      <td colspan="3" height="25"><label>
                                        <?

						
						
					 ?>
                                        <input type="hidden" name="groupping" value="<?=$grs[id]?>">
                                        <input name="grouppingname" type="text"   style="width:300; color:green" value="<?=$grs_secname?>" readonly>
                                      </label></td>
                                    </tr>
                                    <tr>
                                      <td height="25">���</td>
                                      <td colspan="3" height="25">
                                      <?
									//  echo $rs[subminis_now];
									  $sel="";
                                      $sql="SELECT runid, ministry as ORG_NAME FROM $dbnamemaster.hr_addministry where OL_CODE='02' and runid like  concat(left('$id_org',2),'%') order by ORG_NAME";
									   echo"<select name=\"subminis_now\"  style=\"width:300;color:green\" disabled >";
 //$sql="SELECT runid,ORG_NAME FROM $dbnamemaster.hr_addministry_xx where OL_CODE='02' and runid like  concat(left('$id',2),'%') order by ministry";
/* $select1  = mysql_query( $sql);
 while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC)){
$sel="";
									  if($rs[subminis_now]==""){
											if(trim($rselect1[ORG_NAME])=="�ӹѡ�ҹ��С�����á���֡�Ң�鹾�鹰ҹ"){
												$sel="selected";
												$rselect1[ORG_NAME] = $mini = '�ӹѡ����֡�� ��ا෾��ҹ��';
												}  
									  }else{
										if(trim($rs[subminis_now])==trim($rselect1[ORG_NAME]))	{
											$sel="selected";
											$rselect1[ORG_NAME] = $mini = '�ӹѡ����֡�� ��ا෾��ҹ��';
										}  
									  }	 
  echo"<option value=\"$rselect1[ORG_NAME]\" $sel  >$rselect1[ORG_NAME]</option>";
 }*/
	$sel="selected";
	$rselect1[ORG_NAME] = $mini = '�ӹѡ����֡�� ��ا෾��ҹ��';
	echo"<option value=\"$rselect1[ORG_NAME]\" $sel  >$rselect1[ORG_NAME]</option>";
echo"</select> ";
									  ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td height="25"> ��з�ǧ</td>									
                                      <td colspan="3" height="25" id="div_subminis_now"><?
                                   // echo $rs[minis_now]."<br>".$rs[subminis_now];
									  ?>
                                        <select name="minis_now"  style="width:300; color:green"  onChange="getorg(this.value)"  disabled="disabled">
                                          <? 
									   $id_org="";
									  $select1  = mysql_query("select runid, ministry as ORG_NAME  from $dbnamemaster.hr_addministry where OL_CODE='04' order by ministry;");
									  
									  while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC)){
                                      $sel="";
									  			$sel="selected";
												$id_org=$rselect1[runid];
												$rselect1[ORG_NAME] = $snl = '��ا෾��ҹ��';
									 echo"<option  $sel value=\"$rselect1[ORG_NAME]\" >$rselect1[ORG_NAME]</option>";
									  }
									  			$sel="selected";
												$id_org=$rselect1[runid];
												$rselect1[ORG_NAME] = $snl = '��ا෾��ҹ��';
									 echo"<option  $sel value=\"$rselect1[ORG_NAME]\" >$rselect1[ORG_NAME]</option>";
									  ?>
                                      </select>
                                      <input type="hidden" name="subminis_now" value="<?=$mini?>">
                                      <input type="hidden" name="subminis_now_label" id="subminis_now_label"  value="<?=$mini?>">
                                      <input type="hidden" name="minis_now" id="minis_now"  value="<?=trim($snl)?>">
                                      <input type="hidden" name="minis" id="minis"  value="<?=trim($snl)?>">
                                      </td>
                                    </tr>
                                    <?php /*?><tr>
                                      <td height="25">&nbsp;</td>
                                      <td colspan="3" height="25" id="div_subminis_now2">
                                        <input type="text" name="subminis_now_label" id="subminis_now_label"  style="width:300;" value="<?=trim($rs[subminis_now_label])?>">
                                    </td>
                                    </tr>
                                    <tr>
                                      <td height="25">&nbsp;</td>
                                      <td colspan="3"  id="div_subminis_now3"><span class="style1"> �ҡ��ҹ�ѹ�֡㹪�ͧ�ʴ��� ��.7 �к��йӢ����Ź���ʴ���� ��.7 ᷹</span></td>
                                    </tr><?php */?>
                                  </table>
                                </div></td>
                              </tr>
                          </table>
                            <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
                              <tr valign="middle">
                                <td align="right" width="290" height="32">
                                <input name="submenu_id" id="submenu_id" type="hidden" size="50" value="" >
                                <input name="subject_error" id="subject_error" type="hidden" size="50" value="" >
                                <input name="value_key_error" id="value_key_error" type="hidden" size="50" value="" >
                                <input name="label_key_error" id="label_key_error" type="hidden" size="50" value="" >      
                               <input type="hidden" name="flag_editb" id="flag_editb" value="<?=$xflag_edit?>">                         &nbsp;&nbsp;</td>
                                <td align="right" width="300" height="32"><input name="send" type="submit" onClick="return checkPosition('<?php echo $rs[positiongroup];?>');" value="�ѹ�֡ "></td>
                              </tr>
                          </table>
                          </form   ></td>
                      </tr>
                  </table></td>
                </tr>
              </table>
            <script LANGUAGE="JavaScript">
<!--
var unitname = new Array(<?=$ngroup?>);
var unitid = new Array(<?=$ngroup?>);
var salarylist = new Array(<?=$nradub?>);
<?
		for($i=0;$i<$ngroup;$i++){
			$x1 = ""; $x2 = "";
			$uresult = mysql_query("select  *  from  office_detail where beunder='" . $groupid[$i] . "';");
			while ($urs=mysql_fetch_array($uresult,MYSQL_ASSOC)) {
				if ($x1 > "") $x1.=",";
				$x1 .= "'$urs[th_name]'";

				if ($x2 > "") $x2.=",";
				$x2 .= "'$urs[id]'";
			}				
			echo "unitname[" . $groupid[$i] . "]=new Array($x1);\n";
			echo "unitid[" . $groupid[$i] . "]=new Array($x2);\n";
		}

		$x3 = "";
		for($i=0;$i<$nradub;$i++){
			if ($x3 > "") $x3 .=",";
			$x3 .= "'$srunid[$i]'";
		}

?>
var radub_id = new Array(<?=$x3?>);
function ShowUnit(id){
	f1 = document.forms[0];
	
	for(var count = f1.unit.options.length - 1; count >= 0; count--){
        f1.unit.options[count] = null;
    }

	for (i=0;i<unitname[id].length;i++){
		newoption = new Option(unitname[id][i], unitid[id][i], false, false); 
		f1.unit.options[f1.unit.length] = newoption;
	}


}


function ShowSalary(id){
	
	f1 = document.forms[0];
<?
// �Թ��͹ �¡����дѺ
		echo "if (id == '') {salary=null;}\n";
		for($i=0;$i<$nradub;$i++){
			$x1 = ""; 
			$uresult = mysql_query("select  salary  from  hr_salarylist where radub='" . $radublist[$i] . "';");
			while ($urs=mysql_fetch_array($uresult,MYSQL_ASSOC)) {
				if ($x1 > "") $x1 .=",";

				$x1 .= "'$urs[salary]'";
			}			

			if ($x1){
				echo "else if (id == '$radublist[$i]') {salary=new Array($x1);}\n";
			}else{
				echo "else if (id == '$radublist[$i]') {salary=null;}\n";
			}
		}
		echo "else {salary=null;}\n";

?>
	
	for(var count = f1.salary.options.length - 1; count >= 0; count--){
        f1.salary.options[count] = null;
    }

	for (i=0;i<salary.length;i++){
		newoption = new Option(salary[i], salary[i], false, false); 
		f1.salary.options[f1.salary.length] = newoption;
	}


}
//-->
        </script></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
<script>
function compairDateLE(){
		var f1=document.form1;
		chk=0;
		
		if(f1.startyear.value<f1.beginyear.value){
			chk=1;				
		}else if(f1.startyear.value==f1.beginyear.value){
				if(f1.startmonth.value<f1.beginmonth.value){
						chk=1;						
				}else if(f1.startmonth.value==f1.beginmonth.value){
						if(f1.startday.value<=f1.beginday.value){
								chk=1;
						}
				}
		}
		
		if(chk==0){
				return false;
		}else{
				return true;
		}
}


function isThaichar(str,obj,type){  
    var orgi_text="().����֤������Ӿ���ùºţ�ˡ������ǧ�����׷�������������𮱸��ϭ��Ħ�����ȫ������. ";  
    var str_length=str.length;  
    var str_length_end=str_length-1;  
    var isThai=true;  
    var Char_At="";  
    for(i=0;i<str_length;i++){  
        Char_At=str.charAt(i);  
        if(orgi_text.indexOf(Char_At)==-1){  
            isThai=false;  
        }     
    }  
    if(str_length>=1){  
        if(isThai==false){  
			$('#'+obj).val(str.substr(0,str_length_end));
        }  
    }

	if(type=='full' && isThai==false){
		alert('�ͧ�Ѻ��á�͡�ѡ����������ҹ��');
		$('#'+obj).val('');
		$('#'+obj).focus();
	}
    return isThai; // ����� true �ʴ�����������·�����  
}
</script>
<?php
// �ѧ��蹡�

// �ѧ��蹡� �ʴ��� �ѹ ��͹ �� ��
function  showthaidate($number){
$digit=array('�ٹ��','˹��','�ͧ','���','���','���','ˡ','��','Ỵ','���','�Ժ');
$num=array('','�Ժ','����','�ѹ','����','�ʹ','��ҹ');
$number = explode(".",$number);
$c_num[0]=$len=strlen($number[0]);
$c_num[1]=$len2=strlen($number[1]);
$convert='';
if($len > 2){
	$a1 = $len - 1 ;
	$f_digit = substr($number[0],$a1,1);
}
//�Դ�ӹǹ���
for($n=0;$n< $len;$n++){
	$c_num[0]--;
	$c_digit=substr($number[0],$n,1);
	if($c_num[0]==0&& $c_digit==0)$digit[$c_digit]='';

	if($len>1 && $len <= 2){
		if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='���';
	}else if ($len>3){
		if($f_digit == 0){
			if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='˹��';
		}else{
			if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='���';
		}
	}else{
		if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='˹��';
	}

	if($c_num[0]==0&& $c_digit==2)$digit[$c_digit]='�ͧ';
	if($c_num[0]==1&& $c_digit==0)$digit[$c_digit]='';
	if($c_num[0]==1&& $c_digit==1)$digit[$c_digit]='';
	if($c_num[0]==1&& $c_digit==2)$digit[$c_digit]='���'; 

	$convert.=$digit[$c_digit];
		if($c_num[0] > 0 && $c_digit != 0 && $c_digit != ""){
			$convert.=$num[$c_num[0]]; 
		}
}
$convert .= "";
if($number[1]==''){$convert .= "";}
//�Դ�ش�ȹ���
for($n=0;$n< $len2;$n++){ 
$c_num[1]--;
$c_digit=substr($number[1],$n,1);
if($c_num[1]==0&& $c_digit==1)$digit[$c_digit]='˹��';
if($c_num[1]==0&& $c_digit==2)$digit[$c_digit]='�ͧ';
if($c_num[1]==1&& $c_digit==2)$digit[$c_digit]='�ͧ'; 
if($c_num[1]==1&& $c_digit==1)$digit[$c_digit]='';
$convert.=$digit[$c_digit];
$convert.=$num[$c_num[1]]; 
}
if($number[1]!='')$convert .= "";
return $convert;
}

function month_nameth($date_m){
#### ������͹������	
$month_nameth = array("01"=>"���Ҥ�","02"=> "����Ҿѹ��","03"=> "�չҤ�", "04"=>"����¹","05"=> "����Ҥ�", "06"=>"�Զع�¹", "07"=>"�á�Ҥ�", "08"=>"�ԧ�Ҥ�","09"=> "�ѹ��¹", "10"=>"���Ҥ�","11"=> "��ɨԡ�¹", "12"=>"�ѹ�Ҥ�");
return $month_nameth["$date_m"];
}
?>