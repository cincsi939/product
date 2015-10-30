<?
					session_start();
					//	include ("../../../inc/conndb_nonsession.inc.php")  ;
						include ("../../../common/std_function.inc.php")  ;
						unset($_SESSION[checkusr]);


#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_getroyal";
$module_code 		= "getroyal"; 
$process_id			= "getroyal";
$VERSION 				= "9.1";
$BypassAPP 			= true;
#########################################################
#Developer 	:: 
#DateCreate	::17/07/2007
#LastUpdate	::17/07/2007
#DatabaseTabel::
#END
#########################################################
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
include("../../../config/phpconfig.php");
include("../../../common/function_kp7_logerror.php");
$idcard=$_SESSION[idoffice];
$staffid=$_SESSION[session_staffid];
$time_start = getmicrotime();

$strTypeRoyal="1::2::3::4";
?>
<script>
//  ตัวแปรในการกำหนดค่าประเภทเครื่องราชที่ไม่สามารถให้เลือกได้ (คุณสมบัติไม่ถึง)
var  strTypeRoyal="1::2::3::4";

//  ตัวแปรที่กำหนดว่าเป็นรหัสของ 38 ค (2)
var  strType38="5";
</script>
<?
if ($runid != ""){ $getrunid = $runid ; } 

	$result1 = mysql_query("select * from $dbnamemaster.cordon_list ");			
	while( $rs_cordon = mysql_fetch_assoc($result1) ){
		$arr_cordon[$rs_cordon[runid]]=$rs_cordon[name];
		$arr_cordon_short[$rs_cordon[runid]]=$rs_cordon[name_short];
	}

if($_SERVER[REQUEST_METHOD] == "POST"){
//echo "<pre>"; print_r($_POST);echo "</pre>";	
	
 ## รหัสเครื่องราช
if($list1_1){
	$strSQL="SELECT runid,name FROM $dbnamemaster.cordon_list WHERE runid='$list1_1'  ";
	$result=@mysql_query($strSQL);
	$pre_result=@mysql_fetch_assoc($result);
	$cordon=$pre_result['name'];
	$cordon_id=$pre_result['runid'];	
}else{
	$cordon="";
	$cordon_id="";	
}

     $sqlgen="select  *  from  general   where id='$id'";
	   $relult=mysql_query($sqlgen);
	   while($ros=mysql_fetch_array($relult)){

		   $begindate=$ros['begindate'];
	   }

add_log("ข้อมูลเครื่องราชอิสรยาภรณ์",$id,$action);

//
//	        $d=explode("/", $_POST['txtdate']);
//			$date =$d[2]."-".$d[1]."-".$d[0];

			$date=$year_in.'-'.$month_in.'-'.$day_in;

			$date2 	= $subyear.'-'.$submonth.'-'.$subday;

if($_POST[action]=="edit2"){
if($year_in==0  and $month_in==0 and $day_in==0 )
{
	if($label_date==" "){
			$temp_label_date=$label_date;
	}else{
			$temp_label_date=trim($label_date);
	}
	
	if($label_date2==" "){
			$temp_label_date2=$label_date2;
	}else{
			$temp_label_date2=trim($label_date2);
	}
	
	//echo "----".$temp_label_date."++++";
	
	$sql = " update getroyal set date='$date', getroyal='$cordon',getroyal_id='$cordon_id', date2='$date2', no='$no', bookno='$bookno', book='$book', section='$section', ";
	$sql .= " page='$page',kp7_active='$kp7_active',label_date='".$temp_label_date."',label_date2='".$temp_label_date2."',getroyal_label='$getroyal_label' where id ='$id' and  runid='$runid'; ";
	
		$returnid = add_monitor_logbefore("getroyal"," id ='$id' and  runid='$runid' ");
		mysql_query($sql);
		add_monitor_logafter("getroyal"," id ='$id' and  runid='$runid' ",$returnid);
}
else
{         if($date<=$begindate)
				   { 			$date_err=MakeDate($begindate);

					 echo "
					<script language=\"javascript\">
					alert(\"วันที่ได้รับและวันส่งคืน ต้องไม่น้อยกว่าวันที่รับราชการ\\n ขณะนี้วันเริ่มรับราชการของท่าน  บันทึกวันที่รับราชการเป็น วันที่ $date_err\\nกรุณาแก้ไขข้อมูลวันที่รับราชการในเมนูแก้ไขข้อมูลทั่วไปก่อน จึงจะสามารถบันทึกรายการได้\");
					location.href='?id=$id&action=edit';
					</script>
				     ";
				   }else {
					   
	if($label_date==" "){
			$temp_label_date=$label_date;
	}else{
			$temp_label_date=trim($label_date);
	}
	
	if($label_date2==" "){
			$temp_label_date2=$label_date2;
	}else{
			$temp_label_date2=trim($label_date2);
	}
	
	//echo "----".$temp_label_date."++++";
	
	$sql = " update getroyal set date='$date', getroyal='$cordon',getroyal_id='$cordon_id', date2='$date2', no='$no', bookno='$bookno', book='$book', section='$section', ";
	$sql .= " page='$page',kp7_active='$kp7_active',label_date='".$temp_label_date."',label_date2='".$temp_label_date2."',getroyal_label='$getroyal_label' where id ='$id' and  runid='$runid'; ";
					}

		$returnid = add_monitor_logbefore("getroyal"," id ='$id' and  runid='$runid' ");
		$result=mysql_query($sql);
		add_monitor_logafter("getroyal"," id ='$id' and  runid='$runid' ",$returnid);
 }

				
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
		
				echo "
				<script language=\"javascript\">
				alert(\"ทำการปรับปรุงข้อมูลเสร็จสิ้น\\n \");
				
				</script>
				<meta http-equiv='refresh' content='0;URL=getroyal_all_1.php?id=$id&action=edit&vgetroyal=1'>
				";
	//	header("Location: ?id=$id&action=edit");   ?id=3500500260567&action=edit&vgetroyal=0
		exit;
	
		
} 

else if($_POST[action]=="edit3") {

	foreach($_POST as $key => $val){
		$ch = substr($key,0,1);
		if($ch=="_"){
			$ep = explode("_",$key);
			mysql_query("UPDATE `getroyal` SET `orderid`='$_POST[$key]' WHERE (`id`='$ep[1]') AND (`runid`='$ep[2]')  ");
			
		}
		echo "<meta http-equiv='refresh' content='0;URL=getroyal_all_1.php?id=$id&action=edit&vgetroyal=1'>";
	}

exit;
}else{
	
	               if($date<=$begindate)
				   { 	 	$date_err=MakeDate($begindate);
					 echo "
					<script language=\"javascript\">
					alert(\"วันที่ได้รับและวันส่งคืน ต้องไม่น้อยกว่าวันที่รับราชการ\\n ขณะนี้วันเริ่มรับราชการของท่าน  บันทึกวันที่รับราชการเป็น วันที่ $date_err\\nกรุณาแก้ไขข้อมูลวันที่รับราชการในเมนูแก้ไขข้อมูลทั่วไปก่อนจึงจะสามารถบันทึกรายการได้\");
					</script>
				     ";
				   }else {
	$sql = "  SELECT  orderid  FROM `getroyal` WHERE `id` = '$id' ORDER BY `orderid` DESC LIMIT 0,1  ";				   
	$result = @mysql_query($sql) ; 
	$rs = @mysql_fetch_assoc($result) ; 
	$neworder  = 	 $rs[orderid] +1 ; 
	
	if($label_date==" "){
			$temp_label_date=$label_date;
	}else{
			$temp_label_date=trim($label_date);
	}
	
	if($label_date2==" "){
			$temp_label_date2=$label_date2;
	}else{
			$temp_label_date2=trim($label_date2);
	}

	$sql 		= "insert into getroyal set id='$id', date='$date', getroyal='$cordon',getroyal_id='$cordon_id', date2='$date2', no='$no', bookno='$bookno', ";
	$sql		.= " book='$book', section='$section',kp7_active='$kp7_active', page='$page' , orderid=$neworder ,label_date='".$temp_label_date."',label_date2='".$temp_label_date2."',getroyal_label='$getroyal_label'; ";
	
	$returnid = add_monitor_logbefore("getroyal","");
	$result  = mysql_query($sql);
	$max_idx = mysql_insert_id();
	add_monitor_logafter("getroyal"," id ='$id' and  runid='$max_idx' ",$returnid);

				   }
	if($result){
		
		######################
		$temp_subject_error=explode("::",$_POST['subject_error']);
		$temp_value_key_error=explode("::",$_POST['value_key_error']);
		$temp_label_key_error=explode("::",$_POST['label_key_error']);
		$temp_submenu_id=explode("::",$_POST['submenu_id']);
		$numTemp=count($temp_subject_error);
		
		for($a=1;$a<$numTemp;$a++){
			save_kp7_logerror($idcard,$temp_subject_error[$a],get_real_ip(),'INSERT',$temp_value_key_error[$a],$temp_label_key_error[$a],$staffid,$temp_submenu_id[$a]);
		}		
		######################

			echo "
				<script language=\"javascript\">
				alert(\"ทำการบันทึกข้อมูลเสร็จสิ้น\\n \");
				
				</script>
				";
		echo "<meta http-equiv='refresh' content='0;URL=getroyal_all_1.php?id=$id&action=edit&vgetroyal=1'>";
		exit;
	
	} else {	
		echo "ไม่สามารถบันทึกข้อมูลได้ "  .__LINE__.  mysql_error()   ;}
	}				

} else if ($_GET[action] == 'delete') {

	add_log("ข้อมูลเครื่องราชอิสรยาภรณ์",$id,$action);
	mysql_query("delete from getroyal where id = $id and runid='$runid';");
	if (mysql_errno()){
		$msg = "Cannot delete parameter."  .__LINE__.  mysql_error()   ;
	} else {
	echo "<meta http-equiv='refresh' content='0;URL=getroyal_all_1.php?action=edit&vgetroyal=1'>";
		exit;
	}
	
}else {		

	$sql 		= "select * from  general where id='$id'  ;";
	$result 	= mysql_query($sql);
	if ($result) {
		$rs23=mysql_fetch_array($result,MYSQL_ASSOC);
	} else {
		$msg = "Cannot find parameter information."  .__LINE__.  mysql_error()   ;
		echo $msg;
	}
}	

if($action == "edit2"){

		$sql 		= "select * from getroyal where id='$id' and runid= '$runid' ;";
		$result 	= mysql_query($sql);
		$rs		= mysql_fetch_assoc($result);	
		$e=explode("-", $rs[date]);
		$date=$e[2]."/".$e[1]."/".$e[0];
		//echo $date;
		$d=explode("-",$rs['date2']);
		$date2=$d[2]."/".$d[1]."/".$d[0];
}

?>
<html>
<head>
<title>การรับพระราชทางเครื่องราชอิสริยาภรณ์</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<script>
var imgDir_path="../../../common/popup_calenda/images/calendar/";
</script>
<script src="../../../common/popup_calenda/popcalendar.js" type="text/javascript"></script>
<script src="../../../common/popup_calenda/function.js" type="text/javascript"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript" src="jquery.js"></script>
<script src="../../../common/check_label_values/script.js" type="text/javascript"></script>
<script type="text/javascript" src="../../../common/check_label_values/calendar_list.js"></script>
<script>
$(document).ready(function() {
	path="../../../common/check_label_values/";
	check_true='<img src="'+path+'images/checked.gif" width="18" height="18" />';
	check_false='<img src="'+path+'images/unchecked.gif" width="18" height="18" />';
	
	$('#label_date').after("<span id='msg_label_date' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'value_date','label','date',"chk_indate");});
	$('#label_date2').after("<span id='msg_label_date2' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'value_date2','label','date',"chk_subdate");});
});

</script>
<style type="text/css">
body {  
	margin				: 0px  0px; 
	padding				: 0px  0px;
}

a:link { 
	color					: #005CA2; 
	text-decoration	: none;
}

a:visited { 
	color					: #005CA2; 
	text-decoration	: none;
}

a:active { 
	color					: #0099FF; 
	text-decoration	: underline
}

a:hover { 
	color					: #0099FF; 
	text-decoration	: underline;
}
.style4 {
	color: #000000;
	font-weight: bold;
}
.style5 {color: #000000}
.style7 {color: #990000}
.style11 {color: #8C0000}
.style10 {color: #8C0000}
</style>

<!-- send id to menu flash -->
<script language=javascript>
<!--
addnone=1;
displaymonth='l';
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->

     var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}
    
function refreshproductList(mode) {   		//  mode =  1 -> ตัดตั้งแต่จุลจอมเกล้าขึ้นไปออก    ,    mode =  '' ->   โชว์ทั้งหมด
	if(mode=='1'){
			a=strTypeRoyal.split("::");
			c=0;
			for(b=0;b<a.length;b++){
					//alert(a[b]);
					if(document.getElementById("list1").value==a[b]){
							c=1;
					}
			}
			if(c==1){
					document.getElementById("list1").value='0';
			}
	}
	$('#getroyal_label').css("background","white");
  
  var provid = document.getElementById("list1").value;
    if(provid == "" ) {
        clearproductList();		
        return;
    }
	if(provid == 0 ) {
        clearproductList();		
        return;
    }
    var url = "getroyal_ajax.php?runid=" + provid;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStateChange;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
	
}
    
function handleStateChange() {
    if(xmlHttp.readyState == 4) {
        if(xmlHttp.status == 200) {
            updateproductList();
        }
    }
}

function updateproductList() {
    clearproductList();
    var secname = document.getElementById("list1_1");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
	
    for (var i = 0; i < p.length; i++){
		if(p[i] > ""){
				x = p[i].split("::");			
			   option = document.createElement("option");
			   
			  if(x[1] == "<?=$rs[getroyal]?>"){ 
				 //option.options[i].selected = true; // works
				 option.setAttribute("selected","selected");			
				 //alert(x[1]);
			 }
			 //alert(x[2]);
			   option.setAttribute("value",x[1]);
	          option.setAttribute("name_short",x[2]);
			   option.appendChild(document.createTextNode(x[0]));
			   secname.appendChild(option);
		}
    }
	xxx('list1_1');
}
function clearproductList() {
    var secname = document.getElementById("list1_1");
    while(secname.childNodes.length > 0) {
              secname.removeChild(secname.childNodes[0]);
    }
	document.getElementById('getroyal_label').value='';
	$('#msg_'+'getroyal_label').html('');	
	$('#chk_getroyal_label').val('true');
	//alert('wefwef');
}
</script>
</head>

<body bgcolor="#A3B2CC">
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td  valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="30">
		<? if($vgetroyal == 0 and $action=="edit"){?>
				<table width="98%"  align="center">
		<?
		if($dis_menu){// ปิดเมนู
		?>
	   <tr>
          <td height="21" colspan="3"><a href="kp7_getroyal.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7"><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style5">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></span></a></td>
          </tr>

		<?
		}else{
		?>
                    <tr>
                      <td width="20%" height="21"><a href="getroyal_all_1.php?id=<?=$rs[id]?>&action=edit&vgetroyal=1" title="แก้ไขข้อมูล" ><img src="images/edit.png" width="16" height="16" align="absmiddle" border=""><span class="style5">เพิ่ม/ลบ/แก้ไข ข้อมูล</span></a> </td>
                      <td width="39%"><a href="kp7_getroyal.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7"><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style5">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></span></a></td>
                      <td width="41%">&nbsp;</td>
                    </tr>
		<?
		} // สิ้นสุด if($dis_menu){
		?>
                </table>
				<? }else{?>  <table width="98%"  align="center">
                    <tr>
                      <td height="21"><a href="kp7_getroyal.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7"><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style5">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></span></a> </td>
                    </tr>
                </table><? }?></td>
                <td width="50" height="30">&nbsp;</td>
              </tr>
            </table>
            <br>
            
              <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr> 
                  <td align="left" valign="top" ><b>&nbsp;&nbsp; ชื่อ / สกุล &nbsp;&nbsp; 
                    &nbsp;<u>
                    <?=$rs23[prename_th]?>
                    <?=$rs23[name_th]?>
                    <?=$rs23[surname_th]?></u>
                    &nbsp;&nbsp; 
                  </b></td>
                </tr>
              </table>
			  &nbsp;&nbsp; &nbsp;<br>
			  &nbsp;&nbsp; &nbsp; &nbsp;<span class="style4">๓. เครื่องราชอิสริยาภรณ์ วันที่ได้รับและวันส่งคืน รวมทั้งเอกสารอ้างอิง </span><br>
			  <? if($action=="edit")
			  {
			  		if($vgetroyal==0)
					{?><br>
              <table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
                
                <tr bgcolor="#A3B2CC" align="center"> 
				  <td width="119"><strong>วันเดือนปี ที่ได้รับ</strong></td>
                  <td width="196"><strong>เครื่องราช/เหรียญตรา</strong></td>
                  <td width="54"><strong>ลำดับที่</strong></td>
                  <td width="61"><strong>เล่มที่</strong></td>
                  <td width="52"><strong>เล่ม</strong></td>
                  <td width="48"><strong>ตอน</strong></td>
                  <td width="61"><strong>หน้า</strong></td>
                  <td width="107"><strong>ลงวันที่</strong></td>
                </tr>
                <?

				
	$result1 = mysql_query("select * from getroyal  where id='$id' order by orderid ASC");
	//$rayalrow = mysql_num_rows($result1);
	//$rayalrow = $rayalrow +1 ; 
	while ($rs1=mysql_fetch_array($result1,MYSQL_ASSOC)){
		if($rs1[label_date] !=""){
			$dateshow1=$rs1[label_date];
		}else{ 
		 		if($rs1[date] != "0-0-0"){
					if($rs1[date] != "0000-00-00"){
						$dateshow1=MakeDate2($rs1[date]);
					}else{
						$dateshow1 = "";
					}
				}else{ 
				$dateshow1 = "";
			}
		}
		if($rs1[label_date2] !=""){
			$dateshow2=$rs1[label_date2];
		}else{
			if($rs1[date2] != "0-0-0"){
				if($rs1[date2] != "0000-00-00"){
					$dateshow2=MakeDate2($rs1[date2]);
				}else{
					$dateshow2 = "";
				}
			}else{
				$dateshow2 = "";
			}
		}
		
		 
		$bg = "#EFEFEF";

		
?>
                <tr bgcolor="<?=$bg?>"> 
				<td align="center"><?=$dateshow1?></td>
                  <td align="center"><? if($rs1[getroyal_label] != ""){ echo "$rs1[getroyal_label]";}else{?><?=$rs1[getroyal]?> <?=($rs1[getroyal_id])?" (".$arr_cordon_short[$rs1[getroyal_id]].")":"";}?> </td>
                  <td align="center"><?=$rs1[no]?></td>
                  <td align="center">&nbsp;<?=$rs1[bookno]?></td>
                  <td align="center">&nbsp;<?=$rs1[book]?></td>
                  <td align="center">&nbsp;<?=$rs1[section]?></td>
                  <td align="center">&nbsp;<?=$rs1[page]?></td>
                  <td align="center">&nbsp;<?=$dateshow2?></td>
                </tr>
                <?
	} //while

// List Template
?>
              </table>
					
					
					
					
					
					<?
					}//END ($vgetroyal==0)
			 
			  else if ($vgetroyal==1)
			  {
			  ?>
              <br>
			  <form name=order_form  method = POST  action = "<?  echo $PHP_SELF ; ?>" >
			  <INPUT TYPE="hidden" name="action" value="edit3">
			  <INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
              <table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
                
                <tr bgcolor="#A3B2CC" align="center"> 
				  <td width="62"><strong>เรียงลำดับ</strong></td>
                  <td width="90"><strong>วันเดือนปี ที่ได้รับ</strong></td>
                  <td width="162"><strong>เครื่องราช/เหรียญตรา</strong></td>
                  <td width="46"><strong>ลำดับที่</strong></td>
                  <td width="41"><strong>เล่มที่</strong></td>
                  <td width="35"><strong>เล่ม</strong></td>
                  <td width="31"><strong>ตอน</strong></td>
                  <td width="46"><strong>หน้า</strong></td>
                  <td><strong>ลงวันที่</strong></td>
                  <td><input type="button" name="add" value="เพิ่มข้อมูล" onClick="location.href='getroyal_all_1.php?id=<?=$id?>'"></td>
                </tr>
                <?
	$i=0;
	$result1 = mysql_query("select * from getroyal  where id='$id' order by orderid ASC");
	$rayalrow = mysql_num_rows($result1);
	//$rayalrow = $rayalrow +1 ; 
	while ($rs1=mysql_fetch_array($result1,MYSQL_ASSOC)){

		$i++;
		if ($i % 2) {
		$bg = "#EFEFEF";
		}else{
		$bg = "#DDDDDD";
		}
		if($rs1[label_date] !=""){
			$dateshow1=$rs1[label_date];
		}else{
			if($rs1[date] != "0-0-0"){
				if($rs1[date] != "0000-00-00"){
					$dateshow1=MakeDate2($rs1[date]);
				}else{
					$dateshow1 = "";
				}
			}else{
				$dateshow1="";
			}
		}
		if($rs1[label_date2] !=""){
			$dateshow2=$rs1[label_date2];
		}else{
			if($rs1[date2] != "0-0-0"){
				if($rs1[date2] != "0000-00-00"){
					$dateshow2=MakeDate2($rs1[date2]);
				}else{
					$dateshow2 = "";
				}
			}else{
			$dateshow2 = "";
			}
		}
		$runid = $rs1[runid];
		$xrunid = $rs1[runid];		
?>
                <tr bgcolor="<?=$bg?>"> 
				<td align="center"><? //<SELECT NAME="<?=("_".$id."_".$runid);?>
				<?
				/*
				for($g=1;$g<=$rayalrow;$g++){
							$sl = "";
						if($g==$rs1[orderid]){
							$sl = "selected=selected";
						}
						echo "<option value=$g $sl>$g</option>";
					}	
		</SELECT>		*/?>
						<select name="<?=("_".$id."_".$runid);?>">
<?
for($g=1;$g<=$rayalrow;$g++){
	$selected = ($g == $i) ? " selected " : "" ;
	echo "<option value=\"".$g."\" ".$selected.">".$g."</option>";
}
?>	
	</select>				</td>
                  <td align="center"><?=$dateshow1?></td>
                  <td align="center"><? if($rs1[getroyal_label] != ""){ echo "$rs1[getroyal_label]"; }else{?><?=$rs1[getroyal]?> <?=($rs1[getroyal_id])?" (".$arr_cordon_short[$rs1[getroyal_id]].")":"";}?> </td>
                  <td align="center">&nbsp;<?=$rs1[no]?></td>
                  <td align="center">&nbsp;<?=$rs1[bookno]?></td>
                  <td align="center">&nbsp;<?=$rs1[book]?></td>
                  <td align="center">&nbsp;<?=$rs1[section]?></td>
                  <td align="center">&nbsp;<?=$rs1[page]?></td>
                  <td width="106" align="center"><?=$dateshow2?>&nbsp;</td>
                  <td width="67" align="center"> <a href="getroyal_all_1.php?id=<?=$rs1[id]?>&runid=<?=$rs1[runid]?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> 
                    &nbsp; <a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs1[id]?>&runid=<?=$rs1[runid]?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>                  </td>
                </tr>
                <?
	} //while

// List Template
?>
<tr bgcolor="#A3B2CC" align="center">
<td colspan=10 align=center><INPUT TYPE="submit" value='บันทึกการเรียงลำดับการแสดงผลใน ก.พ.7'>
  <input type=button onClick="location.href='getroyal_all_1.php?id=<?=$id?>&action=edit&vgetroyal=0' "  value="กลับหน้าแรก" name="button3" /></td>
</tr>
              </table>
			  </form>
<?
}//end vgetroyal==1
}//END  if($action=="edit")
else
{
?>
<script>
function ch(){
		var f1=document.form1;
		/*if (f1.chk_indate.value == 'false'){			
			if(confirm("วันเดือนปี ที่ได้รับไม่ตรงกับช่องแสดงผล กพ.7 ต้องการดำเนินการต่อหรือไม่")){
					if (f1.chk_subdate.value == 'false'){
						if(confirm("ลงวันที่ไม่ตรงกับช่องแสดงผล กพ.7 ต้องการดำเนินการต่อหรือไม่")){
								return true;
						}
					}else{
						return true;
					}
			}
			return false;
		}else	if (f1.chk_subdate.value == 'false'){
			if(confirm("ลงวันที่ไม่ตรงกับช่องแสดงผล กพ.7 ต้องการดำเนินการต่อหรือไม่")){
					return true;
			}
			//alert("วันสั่งบรรจุไม่ถูกต้อง คุณต้องการบันทึกหรือไม่");
			return false;
		}*/
		
		if (f1.list1.value == '0'){
			alert("กรุณาระบุ ประเภทเครื่องราช");
			return false;
		}
		
		var chkStatus=0;
		if (f1.chk_indate.value == 'false'){
			if(confirm("วันเดือนปี ที่ได้รับไม่ตรงกับช่องแสดงผล กพ.7 ต้องการดำเนินการต่อหรือไม่")){
					chkStatus=0;
					f1.subject_error.value=f1.subject_error.value+"::"+"วันเดือนปี ที่ได้รับไม่ตรงกับช่องแสดงผล กพ.7";
					f1.value_key_error.value=f1.value_key_error.value+"::"+f1.day_in.value+"/"+f1.month_in.value+"/"+f1.year_in.value;
					f1.label_key_error.value=f1.label_key_error.value+"::"+f1.label_date.value;
					f1.submenu_id.value=f1.submenu_id.value+"::"+"5";
			}else{
					chkStatus=1;
					f1.subject_error.value="";
					f1.value_key_error.value="";
					f1.label_key_error.value="";
					f1.submenu_id.value="";
					return false;
			}
		}
		
		if (f1.chk_getroyal_label.value == 'false'){
			if(confirm("ชนิดของประเภทเครื่องราชไม่ตรงกับช่องแสดงผล กพ.7 ต้องการดำเนินการต่อหรือไม่")){
					chkStatus=0;
					f1.subject_error.value=f1.subject_error.value+"::"+"ชนิดของประเภทเครื่องราชไม่ตรงกับช่องแสดงผล กพ.7";
					f1.value_key_error.value=f1.value_key_error.value+"::"+f1.getroyal_value.value;
					f1.label_key_error.value=f1.label_key_error.value+"::"+f1.getroyal_label.value;
					f1.submenu_id.value=f1.submenu_id.value+"::"+"18";
			}else{
					chkStatus=1;
					f1.subject_error.value="";
					f1.value_key_error.value="";
					f1.label_key_error.value="";
					f1.submenu_id.value="";
					return false;
			}
		}
		
		if (f1.chk_subdate.value == 'false'){
			if(confirm("ลงวันที่ไม่ตรงกับช่องแสดงผล กพ.7 ต้องการดำเนินการต่อหรือไม่")){
					chkStatus=0;
					f1.subject_error.value=f1.subject_error.value+"::"+"ลงวันที่ไม่ตรงกับช่องแสดงผล กพ.7";
					f1.value_key_error.value=f1.value_key_error.value+"::"+f1.subday.value+"/"+f1.submonth.value+"/"+f1.subyear.value;
					f1.label_key_error.value=f1.label_key_error.value+"::"+f1.label_date2.value;
					f1.submenu_id.value=f1.submenu_id.value+"::"+"6";
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
</script>
	  <form  method = POST  action = "<?  echo $PHP_SELF ; ?>"  onSubmit="return ch();" name="form1">
	  <INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
	  <INPUT TYPE="hidden" NAME="runid" VALUE="<?=$getrunid?>">
	<INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">
		<table width="100%" border="0" cellspacing="4" cellpadding="1" align="center">
		<? if ($_GET[action]=="edit2") {
		$strSQL_x="SELECT * FROM getroyal WHERE id='$id' AND runid='$runid'";
		$Result_x=mysql_query($strSQL_x);
		$Rs_x=mysql_fetch_assoc($Result_x);
		$date_x=$Rs_x[date];
		$xe=explode("-",$date_x);
		
		
		?>
              <tr> 
            <td align="right" valign="middle" width="262">วันเดือนปี ที่ได้รับ</td>
            <td align="left" valign="top" width=612>วันที่
              <select name="day_in"  id="day_in">
              </select>
              <?
/*					echo " <option   value=0 selected >ไม่ระบุ</option>";
				for ($i=1;$i<=31;$i++){
					if (intval($xe[2])== $i){
						echo "<option value='".sprintf("%02d",$i)."' SELECTED>" .  sprintf("%02d",$i) . "</option>";
					}else{
						echo "<option value='".sprintf("%02d",$i)."'>" .  sprintf("%02d",$i) . "</option>";
					}
				}*/
				?>
เดือน
<select name="month_in" id="month_in">
</select>
<?
/*					echo "<option value=0 selected>"."ไม่ระบุ". "</option>";
				for ($i=1;$i<=12;$i++){
						$numbermonth = sprintf("%02d",$i);
						if ($xe[1] == $numbermonth ){  
						echo "<option  value=$numbermonth selected>".$monthname[$i]."</option>";}
						else
						{
						echo "<option  value=$numbermonth >".$monthname[$i]."</option>";}
				}*/
				?>
ปี พ.ศ.
<select name="year_in"  id="year_in">
</select>
<?
				/*  echo " <option  value=0 selected >ไม่ระบุ </option>";
				$thisyear = date("Y") + 543;
				$y1 = $thisyear - 80;
				$y2 = $thisyear ;
									
				for ($i=$y1;$i<=$y2;$i++){
					if ($xe[0]== $i){
						echo "<option value='$i' SELECTED>$i</option>";
					}else{
						echo "<option value='$i'>$i</option>";
					}
				}*/
				?>
   <input  type="hidden" name="value_date"  id="value_date" value=""  />
  <input  type="hidden" name="chk_indate"  id="chk_indate" value="true"  />
  <script>
	
	generate_calendarlist('value_date','label_date','day_in','month_in','year_in','<?=$xe[2]?>','<?=$xe[1]?>','<?=$xe[0]?>');
</script>  
<!--			
           <INPUT onFocus="blur();" readOnly name="txtdate" value="<?//=$date?>"> 
           <INPUT class="index2"style="FONT-SIZE: 11px; WIDTH: 80px" onClick="popUpCalendar(this, form.txtdate, 'dd/mm/yyyy')" type="button"value="วัน เดือน ปี">-->
<script>
	<?php /*?>create_calendar('day_in','month_in','year_in','<?=$xe[2]?>','<?=$xe[1]?>','<?=$xe[0]?>');<?php */?>
</script><!--			
           <INPUT onFocus="blur();" readOnly name="txtdate" value="<?//=$date?>"> 
           <INPUT class="index2"style="FONT-SIZE: 11px; WIDTH: 80px" onClick="popUpCalendar(this, form.txtdate, 'dd/mm/yyyy')" type="button"value="วัน เดือน ปี">-->		   </td>
            </tr>
			<? }else{ ?>
           <tr> 
            <td align="right" valign="middle" width="262">วันเดือนปี ที่ได้รับ</td>
            <td align="left" valign="top" width="612">วันที่
              <select name="day_in"  id="day_in">
              </select>
              <?
/*						echo "<option value=0>"."ไม่ระบุ". "</option>";
					for ($i=1;$i<=31;$i++){
						if (intval($e1[2])== $i){
							echo "<option value='".sprintf("%02d",$i)."'>" .  sprintf("%02d",$i) . "</option>";
						}else{
							echo "<option value='".sprintf("%02d",$i)."'>" .  sprintf("%02d",$i) . "</option>";
						}
					}*/
					?>
เดือน
<select name="month_in" id="month_in">
</select>
<?
/*						echo "<option value=0 >"."ไม่ระบุ". "</option>";
					for ($i=1;$i<=12;$i++){
							$numbermonth = sprintf("%02d",$i);
					
							echo "<option  value=$numbermonth >".$monthname[$i]."</option>";
					}*/
					?>
ปี พ.ศ.
<select name="year_in"  id="year_in">
</select>
<?
/*						echo "<option value=0>"."ไม่ระบุ". "</option>";
					$thisyear = date("Y") + 543;
					$y1 = $thisyear - 80;
					$y2 = $thisyear ;
										
					for ($i=$y1;$i<=$y2;$i++){
						if ($e1[0]== $i){
							echo "<option value='$i'>$i</option>";
						}else{
							echo "<option value='$i'>$i</option>";
						}
					}*/

	$strSQL="select * from $dbnamemaster.cordon_config";
	$result_date=mysql_query($strSQL);
	while($rs_date=mysql_fetch_assoc($result_date)){
		if($rs_date[name]=="day"){
			$x1=$rs_date[value];
		}
		if($rs_date[name]=="month"){
			$x2=$rs_date[value];
		}		
	}
	?>					
<script>
	generate_calendarlist('value_date','label_date','day_in','month_in','year_in','<?=($e1[2])?$e1[2]:$x1?>','<?=($e1[1])?$e1[1]:$x2?>','<?=$e1[0]?>');
	<?php /*?>create_calendar('day_in','month_in','year_in','<?=($e1[2])?$e1[2]:$x1?>','<?=($e1[1])?$e1[1]:$x2?>','<?=$e1[0]?>');<?php */?>
</script><!-- <INPUT onFocus="blur();" readOnly name="txtdate"  value="<?//=$datebegin?> " > 
           <INPUT class="index2"style="FONT-SIZE: 11px; WIDTH: 80px" onClick="popUpCalendar(this, form.txtdate, 'dd/mm/yyyy')" type="button"value="วัน เดือน ปี">-->	   <input  type="hidden" name="value_date"  id="value_date" value=""  />
  <input  type="hidden" name="chk_indate"  id="chk_indate" value="true"  />   </td>
            </tr>

			  <? }?>
              <tr>
                <td colspan="2" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style7">&nbsp;*รูปแบบการแสดงผลของ วันเดือนปี ที่ได้รับ คือ 12 ม.ค. 2551 ถ้า   นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7 </span></td>
                </tr>
              <tr>
             <td align="right" valign="middle">&nbsp;</td>
             <td align="left" valign="top">
               <input name="label_date" type="text" id="label_date" value="<?=$rs[label_date]?>" size="30" maxlength="100">
               <span class="style11">หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
           </tr>
              <tr>
                <td height="25" colspan="2"><strong>&nbsp;&nbsp;&nbsp;</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="cordon_group1.php" target="_blank">เรียกดูรายละเอียดประเภทและชนิดของเครื่องราชย์/เหรียญตรา</a></td>
                </tr>
              <tr> 
<td height="25" align="right"><font color="red">*</font>ประเภทเครื่องราช&nbsp;</td>
<td><? 	

	$d=$rs[getroyal]; 
	$d_id=$rs[getroyal_id]; 
echo " <!---- $d  -----------> ";	

#$xxx = explode("(" , $d ) ;
#$d = trim($xxx[0])  ;

			$sql="SELECT * FROM  $dbnamemaster.cordon_list  WHERE runid= '".$rs[getroyal_id]."' ";
			
			$s=mysql_query($sql) or die(mysql_error());
			$ss=mysql_fetch_array($s);
			$list_name=$ss[name];
			$list_group=$ss[groupid];
			$group="select * from $dbnamemaster.cordon_group where runid='$list_group'";
			//echo "$group<hr>";
			$group_qurty=mysql_query($group)or die("cannot Query".mysql_error());
			$f_group=mysql_fetch_array($group_qurty);
			$G_name=$f_group[name];
			$G_id=$f_group[runid];
	
	//   ตัดตั้งแต่จุลจอมเกล้าขึ้นไปออก
	//$strMode="	AND  runid  NOT IN ('1','2','3','4')				";
			?>
  <select name="list1" size="1" id="list1" onChange="refreshproductList('1');">		<!--   mode =  1 -> ตัดตั้งแต่จุลจอมเกล้าขึ้นไปออก    ,    mode =  '' ->   โชว์ทั้งหมด  -->
            <option value=0>ระบุประเภทเครื่องราชย์</option> 
<?  	 	 	$query_area = mysql_query(" SELECT  runid , name  FROM  $dbnamemaster.cordon_group  where runid<>9999  $strMode order by runid ") ;
			$atemp=explode("::",$strTypeRoyal);
			while($rs_area = mysql_fetch_assoc($query_area)){
				$bAT=0;
				foreach($atemp as $keyAT => $valueAT){
						if($rs_area[runid]==$valueAT){
								$bAT=1;
						}
				}
				if($bAT==1){
						$color=" style=\"color:#999\" ";
				}else{
						$color="";
				}
				//$color=($rs_area[runid]=="1"||$rs_area[runid]=="2"||$rs_area[runid]=="3"||$rs_area[runid]=="4")?" style=\"color:#999\"":"";
				
		 	?> 
            <option    value="<? echo $rs_area[runid]?>" <? if ( $rs_area[runid] == $G_id ){ echo " selected "; } echo $color ;?> > <? echo $rs_area[name]?> </option>
            <? }

			 ?>
       	    </select> 
<?       
			//echo " $list_name";
		
			
			
			
			echo "<script language=\"javascript\">";
			//echo "refreshproductList(); \n";
			//echo "var $getr_id=$d_id;";
			echo "</script>";
	//***********เรียกใช้  	 function refreshproductList() เมื่อมีการ คลิกที่ edit2 เพื่อสั่งให้ refreshproductList() ทำงานอีกครั้งหนึ่ง*****

?> 
&nbsp;		  </td>
</tr>
<tr>
  <td height="25" align="right"><font color="red">*</font>ระบุชนิด</td>

  <td>
  <script>
  function xxx(obj_id){
	  var x=$('#'+obj_id+' :selected').attr('name_short');
	  //alert(x);
	  if(x==""){x="";}
	  tempAction='<?=$_GET['action']?>';
	  tempGetroyaLabel='<?=$rs[getroyal_label]?>';
	  //alert(tempGetroyaLabel);
	  $('#getroyal_value').val(x);
		if(tempAction=="edit2"){
				$('#getroyal_label').val(tempGetroyaLabel);
				chkGetroyal_label();
		}else{
				$('#getroyal_label').val(x);
				chkGetroyal_label();
		}
		/*if($('#getroyal_label').val(x)==''){
				$('#msg_'+'getroyal_label').html('');
				$('#chk_getroyal_label').val('true');
		}else{
				$('#msg_'+'getroyal_label').html(check_true);	
		}*/
	 
	  //alert(x);
}

function chkGetroyal_label(){
		label=$('#getroyal_label').val();
		value=$('#getroyal_value').val();
		if(label==''){
				$('#getroyal_label').css("background","white");
				$('#msg_'+'getroyal_label').html('');	
				$('#chk_getroyal_label').val('true');
		}else{
				if(label==value){
						$('#getroyal_label').css("background","white");
						$('#msg_'+'getroyal_label').html(check_true);	
						$('#chk_getroyal_label').val('true');
				}else{
						//$('#getroyal_label').st
						$('#getroyal_label').css("background","yellow");
						$('#msg_'+'getroyal_label').html(check_false);	
						$('#chk_getroyal_label').val('false');
				}
		}
}
  
  </script>
<?
$strTempGetroyal="";
?>
<select name='list1_1' id='list1_1' onChange="xxx('list1_1')">
<?
$sql_select=" select   runid , name,name_short from $dbnamemaster.cordon_list where groupid = '$G_id'  ";
    $result_get= mysql_query( $sql_select )or die(mysql_error());
     //เริ่มวนรอบแสดงข้อมูล
    while ($rowget = mysql_fetch_array($result_get))

    //แสดงค่าในฐานข้อมูล
    {
		$name =  $rowget[name] ; 
		$sname=  ($rowget[name_short])?" (".$rowget[name_short].")":"" ;   
	?>
	<option value="<?=$rowget[runid]?>" <? if ( $rowget[runid] == $d_id ){ echo " selected "; $strTempGetroyal=$rowget[name_short]; }  ?> name_short="<?=$rowget[name_short]?>" ><?=$name.$sname?></option>
	<?
	}

?>


</select>
</td>
</tr>
<tr>
  <td height="25" align="right">&nbsp;<input  type="hidden" name="getroyal_value"  id="getroyal_value" value="<?=$strTempGetroyal?>"  /></td>
  <td><input name="getroyal_label" type="text" id="getroyal_label" size="30" maxlength="30" value="<?= $rs[getroyal_label] ?>" onBlur="chkGetroyal_label();"> <span id="msg_getroyal_label"></span>
  	<input  type="hidden" name="chk_getroyal_label"  id="chk_getroyal_label" value="true"  />
    <span class="style10">หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
</tr>
<tr>
	<td height="25" align="right">ลำดับที่&nbsp;</td>
	<td><input type="text" name="no" style="width:100px;" value="<?=$rs[no]?>"></td>
</tr>
<tr>
	<td height="25" align="right">เล่มที่&nbsp;</td>
	<td><input type="text" name="bookno" style="width:100px;" value="<?=$rs[bookno]?>"></td>
</tr>
<tr>
	<td height="25" align="right">เล่ม&nbsp;</td>
	<td><input type="text" name="book" style="width:100px;" value="<?=$rs[book]?>"></td>
</tr>
<tr>
	<td height="25" align="right">ตอน&nbsp;</td>
	<td><input type="text" name="section" style="width:100px;" value="<?=$rs[section]?>"></td>
</tr>
<tr>
	<td height="25" align="right">หน้า&nbsp;</td>
	<td><input type="text" name="page" style="width:100px;" value="<?=$rs[page]?>"></td>
</tr>
<tr>
  <td height="25" align="right">&nbsp;</td>
  <td><input name="kp7_active" type="radio" value="1" checked="checked" <? if($rs[kp7_active]=="1"){echo "checked";}?>>
แสดงผลใน ก.พ.7
  <input name="kp7_active" type="radio" value="0" <? if($rs[kp7_active]=="0"){echo "checked";}?>>
ไม่แสดงผลใน ก.พ.7 </td>
</tr>
	<? if ($_GET[action]=="edit2") {
	
	  $d1=explode("-",$rs[date2]);
	?>
              <tr> 
            <td align="right" width="262">ลงวันที่</td>
            <td align="left"  width="612">วันที่
              <select name="subday"   id="subday">
              </select>
              <?
/*	echo " <option   value=0 selected >ไม่ระบุ </option>";
for ($i=1;$i<=31;$i++){
	if (intval($d1[2])== $i){
		echo "<option SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option>" .  sprintf("%02d",$i) . "</option>";
	}
}*/
?>
เดือน
<select name="submonth" id="submonth">
</select>
<?
/*  	echo "<option value=0 selected>"."ไม่ระบุ". "</option>";
for ($i=1;$i<=12;$i++){
		$numbermonth = sprintf("%02d",$i);
		if ($d1[1] == $numbermonth ){  
		echo "<option  value=$numbermonth selected>".$monthname[$i]."</option>";}
		else
		{
		echo "<option  value=$numbermonth >".$monthname[$i]."</option>";}
}*/
?>
ปี พ.ศ.
<select name="subyear" id="subyear">
</select>
<?
/*  echo " <option  value=0 selected >ไม่ระบุ </option>";
$thisyear = date("Y") + 543;
$y1 = $thisyear - 80;
$y2 = $thisyear ;
					
for ($i=$y1;$i<=$y2;$i++){
	if ($d1[0]== $i){
		echo "<option SELECTED>$i</option>";
	}else{
		echo "<option>$i</option>";
	}
}*/
?>
<input  type="hidden" name="value_date2"  id="value_date2" value=""  />
  <input  type="hidden" name="chk_subdate"  id="chk_subdate" value="true"  />
<script>
	generate_calendarlist('value_date2','label_date2','subday','submonth','subyear','<?=$d1[2]?>','<?=$d1[1]?>','<?=$d1[0]?>');
	<?php /*?>create_calendar('subday','submonth','subyear','<?=$d1[2]?>','<?=$d1[1]?>','<?=$d1[0]?>');<?php */?>
</script>

</td>
              </tr>
			<? }else{?>
            <tr> 
            <td align="right"  width="262">ลงวันที่</td>
            <td align="left"  width="612">วันที่
              <select name="subday"   id="subday">
              </select>
              <?
/*	echo "<option value=0>"."ไม่ระบุ". "</option>";
for ($i=1;$i<=31;$i++){
	if (intval($d1[2])== $i){
		echo "<option >" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option>" .  sprintf("%02d",$i) . "</option>";
	}
}*/
?>
เดือน
<select name="submonth"   id="submonth">
</select>
<?
  /*	echo "<option value=0 >"."ไม่ระบุ". "</option>";
for ($i=1;$i<=12;$i++){
		$numbermonth = sprintf("%02d",$i);

		echo "<option  value=$numbermonth >".$monthname[$i]."</option>";
}*/
?>
ปี พ.ศ.
<select name="subyear"   id="subyear">
</select>
<input  type="hidden" name="value_date2"  id="value_date2" value=""  />
  <input  type="hidden" name="chk_subdate"  id="chk_subdate" value="true"  />
<?
 /* 	echo "<option value=0>"."ไม่ระบุ". "</option>";
$thisyear = date("Y") + 543;
$y1 = $thisyear - 80;
$y2 = $thisyear ;
					
for ($i=$y1;$i<=$y2;$i++){
	if ($d1[0]== $i){
		echo "<option >$i</option>";
	}else{
		echo "<option>$i</option>";
	}
}*/
?>
<script>
	generate_calendarlist('value_date2','label_date2','subday','submonth','subyear','<?=$d1[2]?>','<?=$d1[1]?>','<?=$d1[0]?>');
	<?php /*?>create_calendar('subday','submonth','subyear','<?=$d1[2]?>','<?=$d1[1]?>','<?=$d1[0]?>');<?php */?>
</script>
<? // <INPUT onfocus="blur();" readOnly name="txtgetdate"  > 
           //<INPUT class="index2"style="FONT-SIZE: 11px; WIDTH: 80px" onClick="popUpCalendar(this, form.txtgetdate, 'dd/mm/yyyy')" type="button"value="วัน เดือน ปี"></td>
          //  </tr>
			 }?>
            <tr>
			              <td colspan="2" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style7">&nbsp;*รูปแบบการแสดงผลของ ลงวันที่  คือ 12 ม.ค. 2551 ถ้า   นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7 </span></td>
                </tr>
			            <tr>
             <td align="right" valign="middle">
             <input name="submenu_id" id="submenu_id" type="hidden" size="50" value="" >
    <input name="subject_error" id="subject_error" type="hidden" size="50" value="" >
    <input name="value_key_error" id="value_key_error" type="hidden" size="50" value="" >
    <input name="label_key_error" id="label_key_error" type="hidden" size="50" value="" >
             &nbsp;</td> <td align="left" valign="top">
    <input name="label_date2" type="text" id="label_date2" value="<?=$rs[label_date2]?>" size="30" maxlength="100">
    <span class="style11">หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
           </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr align="center"> 
	<td><input type="submit" name="send" value="  บันทึก  ">
	  <input type=button ONCLICK="location.href='getroyal_all_1.php?id=<?=$id?>&action=edit&vgetroyal=1' "  value="ยกเลิก" name="button" />
	  <input type=button onClick="location.href='getroyal_all_1.php?id=<?=$id?>&action=edit&vgetroyal=0' "  value="กลับหน้าแรก" name="button2" /></td>
</tr>
</table>
</form>
<? }//END ?>
	</td>
</tr>
</table>      
	</td>
</tr>
</table>
<? include("licence_inc.php"); ?>
</body>
</html>
			<? 
			
			$time_end = getmicrotime(); writetime2db($time_start,$time_end);
			
		 ?>
<script>
function showValue(e){
		alert(e.value);
}
</script>