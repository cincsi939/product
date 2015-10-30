<?php
ob_start();
$save_to_file = 1; //@20/7/2550 เก็บรูปลงไฟล์
session_start();
$idcard=$_SESSION[idoffice];
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
$ApplicationName	= "hr_general";
$module_code 		= "5002.xx";
$process_id 			= "xxxxxxx";
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
//Conn2DB();
$id = (empty($_POST[id])) ? $_GET[id] : $_POST[id] ;
if ($_SERVER[REQUEST_METHOD] == "POST"){

add_log("ข้อมูลข้าราชการ",$id,$action);
	if ($_POST[refresh] == "0"){

		 if ($_POST[action]=="edit")
		 {
				  if($name_th=='')
				 {	echo "คุณไม่ได้ระบุชื่อภาษาไทย";
					exit;
				 }else if($surname_th =='')
				{	echo "คุณไม่ได้ระบุนามสกุลภาษาไทย";
					exit;
				}
			  $startdate = $startyear.'-'.$startmonth.'-'.$startday;
			  $begindate = $beginyear.'-'.$beginmonth.'-'.$beginday;
			  
			$bid=explode("/",$birthd);
			$birthday=$bid[2]."-".$bid[1]."-".$bid[0];
			//  $birthday = $byear.'-'.$bmonth.'-'.$bday;
			  $comedate = $comeyear.'-'.$comemonth.'-'.$comeday;
			  $enddate = $endyear.'-'.$endmonth.'-'.$endday;
			  $idcard = $idcard1.$idcard2.$idcard3.$idcard4.$idcard5;
//unit='$unit',
				$sql = "update general set prename_th='$prename_th',name_th='$name_th',surname_th='$surname_th',prename_en='$prename_en',name_en='$name_en',surname_en='$surname_en',schoolid='$schoolid',who='$who',whom='$whom',persontype='$persontype',royaltype='$royaltype',royalid='$royalid',taxid='$taxid',radub_past='$radub_past',sex='$sex',position='$position',blood='$blood',marry='$marry',region='$region',home='$home',status='$status',movetype='$movetype',begindate='$begindate',startposition='$startposition',birthday='$birthday',contact_add='$contact_add',father='$father',mother='$mother',marryname='$marryname',allyear='$allyear',persontype2='$persontype2',subminis='$subminis',minis='$minis',persontype2_now='$persontype2_now',subminis_now='$subminis_now',minis_now='$minis_now',endday='$enddate',father_occ='$father_occ',mother_occ='$mother_occ',marry_occ='$marry_occ', contact_tel='$contact_tel' ,positiongroup ='$positiongroup' , work='$work',positionno='$positionno' , noteref='$noteref',secondname_th='$secondname_th' ,secondname_en ='$secondname_en' , idcard='$idcard', marry_prename='$marry_prename', marry_name='$marry_name', marry_surname='$marry_surname', father_prename='$father_prename', father_name='$father_name', father_surname='$father_surname', mother_prename='$mother_prename', mother_name='$mother_name', mother_surname='$mother_surname',marry_kp7='$marry_kp7',label_persontype2now='$label_persontype2now'where id ='$id' ;";
			//echo $sql."<hr>";
		mysql_query($sql)or die(mysql_error());
				if (mysql_errno())
				{
					$msg = "ไม่สามารถบันทึกข้อมูลได้";
				}else{
					header("Location: ?id=$id&action=edit");
					exit;
				}

			}
			elseif ($_POST[action]=="insert")
			{
			/*
				  if($name_th=='')
				 {	echo "กรุณาระบุชื่อภาษาไทย ด้วยครับ";
					exit;
				 }else if($surname_th =='')
				{	echo "กรุณาระบุนามสกุลภาษาไทย ด้วยครับ";
					exit;
				}else if($radub =='')
				{	echo "กรุณาระบุระดับขั้นปัจจุบัน ด้วยครับ";
					exit;
				}else if($education =='')
				{	echo "กรุณาระบุระดับการศึกษาสูงสุด ด้วยครับ";
					exit;
				}
				$startdate = $startyear.'-'.$startmonth.'-'.$startday;
				$begindate = $beginyear.'-'.$beginmonth.'-'.$beginday;
				$birthday = $byear.'-'.$bmonth.'-'.$bday;
				$comedate = $comeyear.'-'.$comemonth.'-'.$comeday;
				$enddate = $endyear.'-'.$endmonth.'-'.$endday;
				$idcard = $idcard1.$idcard2.$idcard3.$idcard4.$idcard5;
				$sqlid = mysql_query("select max(id) as id from general ");
				$rsid  = mysql_fetch_assoc($sqlid);
				If ($rsid[id] =='')
			  	{
			  		 $id = '13'."000001";
			  	}else
			  	{
					$x = substr($rsid[id],4,6);
					$newid = intval($x) + 1;
					$id = sprintf("%s%06d",'13',$newid);
				}

				$sql = "INSERT INTO  general  (id,idcard,prename_th,name_th,surname_th,prename_en,name_en,surname_en,who,whom,persontype,royaltype,royalid,taxid,radub,sex,position,blood,marry,region,home,status,movetype,startdate,begindate,startposition,birthday,home_add,contact_add,father,mother,marryname,education,unit,	persontype2,subminis,minis,position_now,persontype2_now,subminis_now,minis_now,comeday,endday, father_occ,mother_occ,marry_occ,salary,home_tel,contact_tel,positiongroup,work,positionno,noteref,radub_past,secondname_th,secondname_en,type_officer, marry_prename, marry_name, marry_surname, father_prename, father_name, father_surname, mother_prename, mother_name, mother_surname, outside)  VALUES  ('$id','$idcard','$prename_th','$name_th','$surname_th','$prename_en','$name_en','$surname_en','$who','$whom','$persontype','$royaltype','$royalid',		'$taxid','$radub','$sex','$position','$blood','$marry','$region','$home','$status','$movetype','$startdate','$begindate', '$startposition','$birthday','$home_add','$contact_add','$father','$mother','$marryname','$education','$unit',	'$persontype2','$subminis','$minis','$position_now','$persontype2_now','$subminis_now','$minis_now','$comedate','$enddate', '$father_occ','$mother_occ','$marry_occ','$salary' ,'$home_tel','$contact_tel','$positiongroup','$work','$positionno','$noteref', '$radub_past','$secondname_th','$secondname_en','$type_officer', '$marry_prename', '$marry_name', '$marry_surname', '$father_prename', '$father_name', '$father_surname', '$mother_prename', '$mother_name', '$mother_surname', '$outside')";
				$result  = mysql_query($sql);
				if($result)
				{
					header("Location: ?id=$id&action=edit");
					exit;
				}
				else
				{	
					echo "ไม่สามารถบันทึกข้อมูลได้ ";
				}
*/
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
	$sql = "select beunder from  office_detail where id='$_SESSION[idoffice]';";

	$result = mysql_query($sql);
	if ($result){
		$rsx=mysql_fetch_array($result,MYSQL_ASSOC);
		$rs[beunder] = $rsx[beunder];
	} else {
	//	$msg = "ไม่พบข้อมูลที่ต้องการ";
		$rs[beunder] = $_POST[groupping];
	}



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
	$sql = "select t1.*,t2.beunder from  general t1 left join office_detail t2 on t1.unit=t2.id where t1.id='$id' ;";
	$result = mysql_query($sql);
	if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
	} else {
		$msg = "ไม่พบข้อมูลที่ต้องการ";
	}

}else{ // new
	$sql = "select beunder from  office_detail where id='$_SESSION[idoffice]';";

	$result = mysql_query($sql);
	if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
	} else {
		$msg = "ไม่พบข้อมูลที่ต้องการ";
	}
}

?>
<SCRIPT language=JavaScript 
src="bimg/swap.js"></SCRIPT>
<html>
<head>
<title>ข้อมูลข้าราชการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<script language="javascript" src="chk_number.js"></script>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
-->
</style>
<!-- check การระบุค่า  -->
<SCRIPT LANGUAGE="JavaScript">
<!--
 

	function ch(){
			var f1=document.form1;
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
					alert("วันออกคำสั่งต้องไม่มากกว่าวันเริ่มปฏิบัติงาน");
					return false;
				}
*/
		if (f1.refresh.value == "1"){
			return true; //no checking for refreshing
		}
		
		if (f1.prename_th.selectedIndex == 0){
			alert("กรุณาระบุคำนำหน้าชื่อ ด้วยครับ");
			return false;
		}
		
		if (!f1.name_th.value){
			alert("กรุณาระบุชื่อภาษาไทย ด้วยครับ");
			return false;
		}
		
		if (!f1.surname_th.value){
			alert("กรุณาระบุนามสกุลภาษาไทย ด้วยครับ");
			return false;
		}	
			
		if (f1.sex.selectedIndex == 0){
			alert("กรุณากรอกข้อมูลเพศ ด้วยครับ");
			return false;
		}
	/*	
		if (!f1.radub.value){
			alert("กรุณาระบุระดับขั้นปัจจุบัน ด้วยครับ");
			return false;
		}
	*/	
				
		if (f1.position.selectedIndex == 0){
			alert("กรุณาระบุตำแหน่ง ด้วยครับ");
			return false;
		}

		if (f1.position_now.selectedIndex == 0){
			alert("กรุณาระบุตำแหน่งปัจจุบัน ด้วยครับ");
			return false;
		}
		
		if (f1.radub_past.selectedIndex == 0){
			alert("กรุณาระบุระดับ ด้วยครับ");
			return false;
		}
		
	}

	
function checkidcard(){
	alert("หากต้องการแก้ไขรหัสประจำตัวประชาชน ! กรุณาติดต่อ Call Center");
	return false;
}	
//-->
</SCRIPT>
<!-- send id to menu flash -->
<script language=javascript>
<!--

	function checkid(){  //รวบรวมสร้าง id 
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
          <td height="30"><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">&nbsp;&nbsp;&nbsp;&nbsp;แก้ไขข้อมูลบุคคล&nbsp;
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
                        <td align="left" valign="top"><form  name ="form1" method = POST  action = "<?  echo $PHP_SELF ; ?>" onSubmit="return ch();" >
                            <INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">
                            <INPUT TYPE="hidden" NAME="refresh" VALUE="1">
							<INPUT TYPE="hidden" NAME="position_now" VALUE="<?=$rs[position_now]?>">
							<INPUT TYPE="hidden" NAME="radub" VALUE="<?=$rs[radub]?>">
                            <br>
<div align="right"><a href="teaching.php?id=<?=$id?>">วิชาที่สอน</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>							
                            <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
                              <tr>
                                <td bgcolor="#CACACA" onClick="javascript:swap('basicdata','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;</font></b><b class="gcaption"><font color="#000000"><img src="bimg/profile_expanded.gif" name="ctrlbasicdata" width="9" height="9" border="0" id="ctrlbasicdata" >&nbsp;&nbsp;&nbsp;ข้อมูลทั่วไป</font></b></td>
                              </tr>
                              <tr>
                                <td><DIV id=swapbasicdata>
                                  <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
                                    <tr>
                                      <td valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="2">
                                          <tr>
                                            <td align="center" colspan=2><strong>รหัสบุคลลากร</strong></td>
                                            <td colspan=8><strong>
                                              <input type="hidden" name="id" value="<?=$rs[id]?>"></strong></td>
                                          </tr>
                                          <tr>
                                            <td align="center" colspan=2><strong>รหัสประจำตัวประชาชน<br>
                                                <br>
                                                <br>
                                            </strong></td>
                                            <td colspan=8><?	
											$rs_idcard = $rs[idcard]  ; 
						// ตัดรหัสประชาชน
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
                                            <td width="21%" align="left" valign="top" class="textp">คำนำหน้าชื่อ <font color="red">*</font></td>
                                            <td width="23%" align="left" valign="top" class="textp">ชื่อ <font color="red">*</font></td>
                                            <td width="25%" align="left" valign="top" class="textp">นามสกุล <font color="red">*</font></td>
                                            <td width="21%" align="left" valign="top" class="textp">ชื่อรอง</td>
                                          </tr>
                                          <tr>
                                            <td align="right" valign="middle" class="textp">(ไทย) </td>
                                            <td align="left" valign="top">
											  <input name="prename_th" type="text"  id="prename_th"  value="<?=$rs[prename_th]?>" size="20" readonly>
                  						   </td>
                                            <td align="left" valign="top">
											<input name="name_th" type="text"  id="name_th"  value="<?=$rs[name_th]?>" size="20" readonly>											</td>
                                            <td align="left" valign="top"><input name="surname_th" type="text"   id="surname_th" value="<?=$rs[surname_th]?>" size="20" readonly>                                            </td>
                                            <td align="left" valign="top"><input name="secondname_th" type="text"   id="secondname_th" value="<?=$rs[secondname_th]?>" size="20" readonly>											</td>
                                          </tr>
                                          <tr>
                                            <td align="right" valign="middle" class="textp">(อังกฤษ) </td>
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
                                            <td colspan="5" align="center" valign="middle" class="textp">คลิ๊กเครื่องหมายบวกเพื่อ เปลี่ยน ชื่อ-นามสกุล (เจ้าของข้อมูล) 
                                            <input type="button" name="Button311" value=" + " title="ประวัติการเปลี่ยนแปลง ชื่อ-สกุล (เจ้าของข้อมูล)" onClick="MM_openBrWindow('add_historyname.php','<?=$rs_idcard?>historyname','scrollbars=yes,width=700,height=550')"></td>
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
						 $sql_showpic="select yy,imgname from general_pic where id='$id' order by yy  DESC ";
						$query=mysql_query($sql_showpic)or die("cannot query".mysql_error());
							$num_row=mysql_num_rows($query);
							$rs_pic=mysql_fetch_array($query);
							if($num_row <1){
							echo  "<img src='../images/personnel/noimage.jpg' />";
							}else{
							echo "<img src=\"images/personal/$rs_pic[imgname]\" width=120 height=160 >";
							}
						 
						 ?>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td valign="bottom" align="center"><div align="center">
<? /*											
<input class="xbutton" style="width: 150;" type="button" value="  แก้ไขรูปภาพ  " onClick="window.open('pic.php?id=<?=$rs[id]?>','pic','location=0,status=1,scrollbars=0,menubar=0,width=500,height=250');" name="button">
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
                                      <td width="18%" height="25">สัญชาติ</td>
                                      <td width="43%" height="25"><input name="who" type="text"   value="<? if(isset($rs[who])){ echo "ไทย"; }else{ echo $rs[who]; } ?>" size="20" >                                      </td>
                                      <td width="11%" height="25">เชื้อชาติ</td>
                                      <td width="28%" height="25"><input name="whom" type="text"   value="<? if(isset($rs[whom])){ echo "ไทย"; }else{ echo $rs[whom]; } ?>" size="20">                                      </td>
                                    </tr>
                                    <tr>
                                      <td height="25">ศาสนา&nbsp; </td>
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
                                      <td height="25">เพศ <font color="red">*</font></td>
                                      <td height="25"><select name="sex">
<option value=""></option>
<?
$arr1 = array("ชาย","หญิง");
for ($i=0;$i<count($arr1);$i++){
	if ($rs[sex] == $arr1[$i]){
		echo "<option value='$arr1[$i]' SELECTED>$arr1[$i]</option>";
	}else{
		echo "<option value='$arr1[$i]'>$arr1[$i]</option>";
	}
}
?>
                                        </select>                                      </td>
                                    </tr>
                                    <tr><? $d=explode("-",$rs[birthday]);
												$dateshow=$d[2]."/".$d[1]."/".$d[0];
									?>
                                      <td height="25">วันเดือนปีเกิด</td>
                                      <td height="25"><INPUT onFocus="blur();" readOnly name="birthd" value="<?=$dateshow ?>"> 
           <INPUT class="index2"style="FONT-SIZE: 11px; WIDTH: 80px" onClick="popUpCalendar(this, form.birthd, 'dd/mm/yyyy')" type="button"value="วัน เดือน ปี">
           <input type="button" name="typedate" value=" + " title="วัน เดือน ปี เกิดตาม ข้อ 1(ส่วนหน้า)" onClick="MM_openBrWindow('type_showdate.php','<?=$idcard;?>','scrollbars=yes,width=1000,height=600')">
           &nbsp;
           <input type="button" name="typedate2" value=" + " title="วัน เดือน ปี เกิดตาม ข้อ 2(ส่วนหลัง)" onClick="MM_openBrWindow('type_showdate2.php','<?=$idcard;?>','scrollbars=yes,width=1000,height=600')"></td>
                                      <td height="25">&nbsp;</td>
                                      <td height="25">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td height="25">ภูมิลำเนาเกิด 
                                        (จังหวัด)</td>
                                      <td height="25">  
<select name="home" class="input" style="width:150px;">
	<option value="">เลือกจังหวัด</option>
<?
 $selected =""; 
$result = mysql_query("select * from $dbnamemaster.hr_province where 1  order by   province ")or die("Query line " . __LINE__ . " Error<hr>".mysql_error());
while($hrs = mysql_fetch_assoc($result)){
	if($hrs[id] == $rs[home]){ $selected = "selected"; }   else{ $selected =""; }
	echo "<option value=\"$hrs[id]\" $selected>$hrs[province]</option> \n ";
 }
mysql_free_result($result);
 ?>			         
	</select></td><td height="25" colspan="2">หมู่โลหิต&nbsp;<select name="blood" style="width:100;">
                                          <option value="0"></option>
                                          <?
$r_result = mysql_query("select * from $dbnamemaster.hr_blood order by id");
while ($r_rs = mysql_fetch_assoc($r_result)){
	if ($rs[blood] == $r_rs[blood]){
		echo "<option value='$r_rs[blood]' SELECTED>$r_rs[blood]</option>";
	}else{
		echo "<option value='$r_rs[blood]'>$r_rs[blood]</option>";
	}
}
?>
                                        </select>
                                      <!--<input type="button" name="btnNewBlood" value=" + " onClick="MM_openBrWindow('addblood.php','addblood','scrollbars=yes,width=600,height=500')">         -->                             </td>
                                    </tr>
<tr>
	<td height="25">ชื่อบิดา</td>
	<td colspan="3"><p>

		<input name="father_prename" type="text" id="father_prename" value="<?=$rs[father_prename]?>" size="20" readonly>
	  ชื่อ 
	  <input name="father_name" type="text" id="father_name"  value="<?=$rs[father_name]?>" size="30" readonly>
	  นามสกุล 
	  <input name="father_surname" type="text" id="father_surname" value="<?=$rs[father_surname]?>" size="30" readonly>
	  <input type="button" name="Buttonfather" value=" + " title="ประวัติการเปลี่ยนแปลง ชื่อ-สกุล (บิดา)" onClick="MM_openBrWindow('add_historyfathername.php','<?=$rs_idcard?>historyfather','scrollbars=yes,width=700,height=500')">	 
	    <br>
	    คลิ๊กเครื่องหมายบวกเพื่อ เปลี่ยน ชื่อ-นามสกุล (บิดา)  </p>	  </td>										 
</tr>
<tr>
	<td height="20">อาชีพบิดา</td>
	<td colspan="3"><input name="father_occ" type="text"  id="father_occ"  value="<?=$rs[father_occ]?>" size="35" readonly></td>
</tr>
<tr>
	<td height="25">ชื่อมารดา</td>
	<td colspan="3">
	<input name="mother_prename" type="text"  id="mother_prename"  value="<?=$rs[mother_prename]?>" size="20" readonly>
	ชื่อ <input name="mother_name" type="text"  id="mother_name"  value="<?=$rs[mother_name]?>" size="30" readonly>
	นามสกุล <input name="mother_surname" type="text"  id="mother_surname"  value="<?=$rs[mother_surname]?>" size="30" readonly> 
	<input type="button" name="Buttonmother" value=" + " title="ประวัติการเปลี่ยนแปลง ชื่อ-สกุล (มารดา)" onClick="MM_openBrWindow('add_historymothername.php','<?=$rs_idcard?>historymother','scrollbars=yes,width=700,height=500')">	 <br>
	คลิ๊กเครื่องหมายบวกเพื่อ เปลี่ยน ชื่อ-นามสกุล (มารดา) </td>										 
</tr>									
<tr>
	<td height="20">อาชีพมารดา</td>
	<td colspan="3"><input name="mother_occ" type="text"  id="mother_occ"  value="<?=$rs[mother_occ]?>" size="35" readonly></td>
</tr>
<tr>
	<td height="25">สถานภาพสมรส</td>
	<td height="25" colspan="3"><select name="marry"  style="width:200;" >
	<option value="0"></option>
<?
		$select1  = mysql_query("select  marriage from $dbnamemaster.hr_addmarriage order by marriage;");
	
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))
		{
		if ($rs[marry] == $rselect1[marriage])
		{ 			
			echo "<option value='$rselect1[marriage]' SELECTED>$rselect1[marriage]</option>";
		}else
			{
			echo "<option value='$rselect1[marriage]' >$rselect1[marriage]</option>";
			}
		}//end while
?>
	</select>
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
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<select name="marry_kp7"  style="width:100;" >
	    <option value="0"></option>
	    <?
		$select1  = mysql_query("select  marriage from $dbnamemaster.hr_addmarriage order by marriage;");
	
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))
		{
		if ($rs[marry_kp7] == $rselect1[marriage])
		{ 			
			echo "<option value='$rselect1[marriage]' SELECTED>$rselect1[marriage]</option>";
		}else
			{
			echo "<option value='$rselect1[marriage]' >$rselect1[marriage]</option>";
			}
		}//end while
?>
	      </select>
      <!--   
<input type="button" name="Button2432" value=" + " onClick="MM_openBrWindow('addmarriage.php','addmarriage','scrollbars=yes,width=600,height=500')">
-->
&nbsp;สถานภาพสมรสตาม ก.พ.7 </td>
	</tr>
<tr>
	<td height="25">ชื่อคู่สมรส</td>
	<td colspan="3">
	<input type="text" name="marry_prename"  id="marry_prename" value="<?=$rs[marry_prename]?>" size="20" readonly>
	ชื่อ <input name="marry_name" type="text"  id="marry_name"  value="<?=$rs[marry_name]?>" size="30" readonly> 
	นามสกุล <input name="marry_surname" type="text" id="marry_surname" value="<?=$rs[marry_surname]?>" size="30" readonly>
	<input type="button" name="Button31232" value=" + " title="ประวัติการเปลี่ยนแปลง ชื่อ-สกุล (คู่สมรส)" onClick="MM_openBrWindow('add_historymarry.php','<?=$rs_idcard?>historymarry','scrollbars=yes,width=700,height=500')">
	<br>
	คลิ๊กเครื่องหมายบวกเพื่อ เปลี่ยน ชื่อ-นามสกุล (คู่สมรส)</td>										 
</tr>
<tr>
	<td height="20">อาชีพคู่สมรส</td>
	<td colspan="3"><input name="marry_occ" type="text"  id="marry_occ" value="<?=$rs[marry_occ]?>" size="35" readonly></td>
</tr>
                                    <tr>
                                      <td height="25" colspan="4" bgcolor="#CACACA" class="gcaption">&nbsp; &nbsp; ที่อยู่ปัจจุบัน ตาม ข้อมูลสำคัญโดยย่อ </td>
                                    </tr>
                                    <tr>
                                      <td height="25">ที่อยู่ปัจจุบัน(ตาม ก.พ.7)</td>
                                      <td height="25" colspan="3"><input name="contact_add"  id="contact_add" type="text" value="<?=$rs[contact_add]?>" size="50" readonly>
                                      <input type="button" name="Button3123" value=" + " title="ประวัติการเปลี่ยนแปลง(ที่อยู่)" onClick="MM_openBrWindow('add_historyaddress.php','<?=$rs_idcard?>historyaddress','scrollbars=yes,width=700,height=500')"> 
                                      
                                      <!--   
<input type="button" name="Button2432" value=" + " onClick="MM_openBrWindow('addmarriage.php','addmarriage','scrollbars=yes,width=600,height=500')">
-->
&nbsp;&nbsp;&nbsp;&nbsp;
<!--   
<input type="button" name="Button2432" value=" + " onClick="MM_openBrWindow('addmarriage.php','addmarriage','scrollbars=yes,width=600,height=500')">
-->เบอร์โทร
                                        
                                      <input name="contact_tel" type="text"   value="<?=$rs[contact_tel]?>" size="35" onKeyDown="return Filter_Keyboard();">                                      </td>
                                    </tr>
                                    
                                    <tr>
                                      <td>&nbsp;</td>
                                      <td> คลิ๊กเครื่องหมายบวกเพื่อเปลี่ยนแปลง (ที่อยู่)</td>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                    </tr>
                                  </table>
                                  <br>
                                </DIV></td>
                              </tr>
                            </table>
                            <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
                              <tr>
                                <td bgcolor="#CACACA" onClick="javascript:swap('officer','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;</font></b><b><font color="#000000"><img src="bimg/profile_expanded.gif" name="ctrlofficer" width="9" height="9" border="0" id="ctrlofficer" >&nbsp;&nbsp;&nbsp;&nbsp;</font></b><b class="gcaption"><font color="#000000">การเริ่มรับราชการ</font></b></td>
                              </tr>
                              <tr>
                                <td><DIV id=swapofficer>
                                  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="0" class="textp">
                                    <tr>
                                      <td height="25">ประเภทข้าราชการ</td>
                                      <td height="25"><select name="persontype2_now"  style="width:280;" >
									  <? 	$select1  = mysql_query("select  persontype from $dbnamemaster.hr_addpersontype order by persontype");?>
  <option value="<? if($rs[persontype2_now]=="0"){echo"selected";}?>">ไม่ระบุุ</option>
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
                                      </select></td>
                                      <td width="10%" height="25">&nbsp;</td>
                                      <td height="25">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td height="25">&nbsp;</td>
                                      <td height="25" colspan="3"><input name="label_persontype2now" type="text" value="<?=$rs[label_persontype2now]?>" size="30" maxlength="255">
&nbsp;ส่วนแสดงผลประเภทข้าราชการ ใน ก.พ.7 (กรณีที่ ประเภทข้าราชการไม่ตรงตาม ก.พ.7 ) </td>
                                    </tr>
                                    <tr>
                                      <td width="18%" height="25">วันเริ่มปฎิบัติงาน
                                        <?
						   $d2=explode("-",$rs[begindate]);
						   
						   ?>                                      </td>
                                      <td width="42%" height="25">
                                        วันที่
                                        <select name="beginday" >
                                          <?
for ($i=1;$i<=31;$i++){
	if (intval($d2[2])== $i){
		echo "<option value=\"".sprintf("%02d",$i)."\" SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option value=\"".sprintf("%02d",$i)."\" >" .  sprintf("%02d",$i) . "</option>";
	}
}
?>
                                        </select>
                                        เดือน
<select name="beginmonth" >
  <?
for ($i=1;$i<=12;$i++){
		$numbermonth = sprintf("%02d",$i);
		if ($d2[1] == $numbermonth ){  
		echo "<option  value=$numbermonth selected>".$monthname[$i]."</option>";}
		else
		{
		echo "<option  value=$numbermonth >".$monthname[$i]."</option>";}
}
?>
</select>
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
                                        พ.ศ.
  <select name="beginyear" >
  <?
					  $thisyear = date("Y") + 543;
$y1 = $thisyear - 80;
$y2 = $thisyear ;
					
for ($i=$y2;$i>=$y1;$i--){
	if ($d2[0]== $i){
		echo "<option  value=\"".$i."\" SELECTED>$i</option>";
	}else{
		echo "<option  value=\"".$i."\">$i</option>";
	}
}

	 $diff  = dateLength($rs[begindate]);

?>
</select>
  <input type="button" name="showbegindate" value=" + " title="เลือกรูปแบบการแสดงผลวันที่ ในส่วน วันเริ่มปฏิบัติงาน" onClick="MM_openBrWindow('type_showbegindate.php','<?=$idcard;?>','scrollbars=yes,width=1000,height=600')"></td><td height="25">อายุราชการ</td>
	<td width="30%" height="25">&nbsp;
<?
if ($rs[begindate] != ""){
	echo "<u>".$diff[year]."</u>&nbsp;ปี&nbsp;&nbsp;<u>".$diff[month]."</u>&nbsp;เดือน&nbsp;&nbsp;<u>".$diff[day]."</u>&nbsp;วัน";
}else{
  	echo "-";
}
?>	</td>
</tr>
<tr>
	<td width="18%" height="25">ตำแหน่ง <font color="red">*</font></td>
	<td width="42%" height="25"><select name="position"  style="width:280;" >
	<? $select1  = mysql_query("select  position from $dbnamemaster.hr_addposition order by position;");?>
	<option value="<? if($rs[position]==""){echo "selected";}?>">ไม่ระบุ</option>
<?
	$found = false;
	while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))
	{
		if ($rs[position] == $rselect1[position])
		{ 			
			$found = true;
			echo "<option value='$rselect1[position]' SELECTED>$rselect1[position]</option>";
		}else	{
			echo "<option value='$rselect1[position]' >$rselect1[position]</option>";
		}
	}//end while
	if(!$found){
		echo "<option value='$rs[position_now]' SELECTED>$rs[position_now]</option>";
	}	
unset($found);
?>
</select>
                                      <!--
                                        <input type="button" name="Button242222" value=" + " onClick="MM_openBrWindow('addposition.php','addposition','scrollbars=yes,width=600,height=500')">
                                        -->                                        </td>
                                      <td height="25">ระดับ <font color="red">*</font></td>
                                      <td width="30%" height="25"><select name="radub_past" style="width:100px;" >
									  <option value=""></option>
                                        <?
		$select1  = mysql_query("select  * from $dbnamemaster.hr_addradub_old order by cast(radub as unsigned);");
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))
		{

			if ($rs[radub_past] == $rselect1[radub])
			{ 			
				echo "<option value='$rselect1[radub]' SELECTED>$rselect1[radub]</option>";
			}
			else
			{
				echo "<option value='$rselect1[radub]' >$rselect1[radub]</option>";
			}

		}//end while
?>
                                      </select>
                                        <!--
                                        <input type="button" name="Button2452" value=" + " onClick="MM_openBrWindow('addradub_old.php','addradub','scrollbars=yes,width=600,height=500')">
                                        -->                                        </td>
                                    </tr>
<tr>
<td width="18%" height="25">วันเกษียณอายุ</td>
<td width="42%" height="25"><font color="#716F6F"><?=retireDate($rs[birthday])?></font></td>
<td height="25">&nbsp;</td>
<td width="30%" height="25">&nbsp;</td>
</tr>
                                  </table>
                                </DIV></td>
                              </tr>
                            </table>
                            <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
                              <tr>
                                <td bgcolor="#CACACA" onClick="javascript:swap('now','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;</font></b><b><font color="#000000"><img src="bimg/profile_expanded.gif" name="ctrlnow" width="9" height="9" border="0" id="ctrlnow" >&nbsp;&nbsp;&nbsp;&nbsp;</font></b><b class="gcaption"><font color="#000000">การรับราชการปัจจุับัน</font></b></td>
                              </tr>
                              <tr>
                                <td><DIV id=swapnow>
                                  <table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="textp">
                                    <tr>
                                      <td width="18%" height="25"><!-- ตำแหน่งทางการบริหาร -->กลุ่มตำแหน่ง</td>
									  
							<? 	$select1  = mysql_query("select *  from $dbnamemaster.hr_positiongroup ;");?>
                                      <td width="44%" height="25"><select name="positiongroup" id="positiongroup"  style="width:300;" >
                                   <option value="<? if($rs[positiongroup]==""){echo "selected";}?>">ไม่ระบุ</option>
                                        <?
	
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))
		{
		if ($rs[positiongroup] == $rselect1[positiongroupid])
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
                                      <td width="18%" height="25">งาน/ฝ่าย/กลุ่มงาน</td>
                                      <td width="44%"><select name="work" id="work"  style="width:300;" > 
									   <option value="<? if($rs[work]==""){echo "selected";}?>">ไม่ระบุ</option>
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
                                      <td width="18%" height="25">หน่วยงาน</td>
                                      <td width="44%" height="25">
<?
						$ngroup = 0;
						$groupid = Array();
						$gresult = mysql_query("select  *  from  $dbnamemaster.eduarea where secid='$rs[siteid]';");
						$grs=mysql_fetch_array($gresult,MYSQL_ASSOC);		
						$grs_secname = $grs[secname] ; 		
?>									  
									
                                        <select name="schoolid" style="width:300;">       
                       <?
						if($rs[schoolid] == ""){
								echo "<option value='' SELECTED>$grs_secname</option>";						
						}	######	if($rs[schoolid] != ""){					
						echo "<option value=''  >$grs_secname</option>";		
						$usql="SELECT * from $dbnamemaster.allschool where  siteid = '$rs[siteid]'  order by office   ";
						$uresult = mysql_query( $usql );
						while($urs=mysql_fetch_array($uresult,MYSQL_ASSOC)){
							if($urs[id]==$rs[schoolid]){
								echo "<option value='$urs[id]' SELECTED>$urs[office]</option>";
							}else{
								echo "<option value='$urs[id]'>$urs[office]</option>";
							} ## if($urs[id]==$rs[schoolid]){ 
						} ## while($urs=mysql_fetch_array($uresult,MYSQL_ASSOC)){

												
					?>
                                      </select></td>
                                      <td height="25">&nbsp;</td>
                                      <td width="30%" height="25">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td height="25">สังกัด</td>
                                      <td colspan="3" height="25"><label>
                                        <?

						
						
					 ?>
                                        <input type="hidden" name="groupping" value="<?=$grs[id]?>">
                                        <input name="grouppingname" type="text"   style="width:300;" value="<?=$grs_secname?>" readonly>
                                      </label></td>
                                    </tr>
                                    <tr>
                                      <td height="25">กรม</td><? if($rs[subminis_now]=="" or $rs[subminis_now]="สำนักงานคณธกรรมการการศึกษาขั้นพื้นฐาน"){ $subminis_now="สำนักงานคณะกรรมการการศึกษาขั้นพื้นฐาน";}else
									  {$subminis_now=$rs[subminis_now];}?>
                                      <td colspan="3" height="25"><input name="subminis_now" type="text"  id="subminis_now" style="width: 300;" value="<?=$subminis_now?>" size="52"></td>
                                    </tr>
                                    <tr>
                                      <td height="25">กระทรวง</td>
                                      <td colspan="3" height="25"><select name="minis_now"  style="width:300;" >
									  <? $select1  = mysql_query("select  ministry from $dbnamemaster.hr_addministry;");?>
									  <? if($rs[minis_now]==""){?>
									 <option value="กระทรวงศึกษาธิการ">กระทรวงศึกษาธิการ</option>
									 <? 	while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))
									 		{
									 ?>	<? if($rselect1[ministry]!="กระืทรวงศึกษาธิการ")
									 {?>
									 		<option value='<?=$rselect1[ministry]?>' ><?=$rselect1[ministry]?></option><? }?>
									  <? } //END WHILE
									  }//END IF
									  
									  else{?>
                                        <?
		
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC))
		{
		if ($rs[minis_now] == $rselect1[ministry])
		{ 			
			echo "<option value='$rselect1[ministry]' SELECTED>$rselect1[ministry]</option>";
		}else
			{
			echo "<option value='$rselect1[ministry]' >$rselect1[ministry]</option>";
			}
		}//end while
	}
?>
                                      </select></td>
                                    </tr>
                                  </table>
                                </DIV></td>
                              </tr>
                          </table>
                            <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
                              <tr valign="middle">
                                <td align="right" width="290" height="32">&nbsp;&nbsp;</td>
                                <td align="right" width="300" height="32"><input name="send" type="submit" onClick="document.form1.refresh.value='0'; " value="บันทึก "></td>
                              </tr>
                          </table>
                          </form   ></td>
                      </tr>
                  </table></td>
                </tr>
              </table>
            <SCRIPT LANGUAGE="JavaScript">
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
// เงินเดือน แยกตามระดับ
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
        </SCRIPT></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>