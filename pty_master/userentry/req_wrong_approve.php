<?
header("Content-Type: text/html; charset=windows-874");  
session_start();
//print_r($_SESSION);
//exit;
require_once("../../config/conndb_nonsession.inc.php");
include ("../../common/common_competency.inc.php");
include("function.php");
include("../../common/function.check.success.php");
include("function_assign_edit.php");
//include("epm.inc.php");

$db_master = DB_MASTER;
if($page==""){$page="1";}
$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$xstaff_id=$_SESSION[session_staffid];
$xstaff_fullname=$_SESSION[session_fullname];
if($_POST){
if($objchange=="1"){			
	if($select_group!=$old_group){
		$sql="SELECT problem_name,runno FROM `req_problem_group` where runno='$old_group'";
		$result_1=mysql_db_query($db_master,$sql);
		$row1=mysql_fetch_array($result_1);
		$type_from=$row1[problem_name];
		$sql="SELECT problem_name,runno FROM `req_problem_group` where runno='$select_group'";
		$result_1=mysql_db_query($db_master,$sql);
		$row1=mysql_fetch_array($result_1);
		$type_to=$row1[problem_name];
		$syscaption="เปลี่ยนหมวดรายการจาก $type_from เป็น $type_to";	
	}
	if($errortype!=$old_type){
			$sql="SELECT problem_typename,runno FROM `req_problem_type` where runno='$old_type'";
		$result_1=mysql_db_query($db_master,$sql);
		$row1=mysql_fetch_array($result_1);
		$type_from=$row1[problem_typename];		
		$sql="SELECT problem_typename,runno FROM  `req_problem_type` where runno='$errortype'";
		$result_1=mysql_db_query($db_master,$sql);
		$row1=mysql_fetch_array($result_1);
		$type_to=$row1[problem_typename];
		$syscaption.=" เปลี่ยนประเภทจาก $type_from เป็น $type_to";	
	}
	if($syscaption!=""){$syscaption=$xstaff_fullname." ".$syscaption;}
}


if($radio_status==""){$radio_status=$old_status;}


	
	
	### add by sak 2011-04-27 16:55
	### log การตรวจสอบ ของ callcenter assign ให้ keyin user
	
	$req_person_id = $_POST[id_req];
	$approve_type = $_POST[radio_status];
	$approve_comment = $_POST[txtcomment];
	$staffid = $_SESSION[session_staffid];
	$problem_type = $_POST[errortype];
	$comment_key = $_POST[txtcomment];
	
	if($approve_type ==1){ # verify
		$status_modify = " status_req_approve='1',";
		$status_modify .= " status_key_approve='0',";
		$sql=" update req_problem_person set req_status='2' where req_person_id='$id_req'";	 // กรณี verify ให้ เซต สถานะเป็น >> อยู่ระหว่างดำเนินการแก้ไข
		mysql_db_query($db_master,$sql);  //update  req_problem_person		
	} 
	
	if($approve_type ==2){ # approved
		if($problem_type == ""){
			$problem_type = $h_errortype; //กรณีที่ ไม่มีค่าให้นำค่าที่ ถูก set ใน hidden มาใส่ค่าแทน
		}
		
		if($problem_type == "1"){ // ข้อมูลพิมพ์ผิด
			$req_status_modify = "3";//ดำเินินการเรียบร้อยแล้ว
		}
		
		if($problem_type == "2"){ // ข้อมูลไม่เป็นปัจจุบัน
			$req_status_modify = "6"; //เจ้าหน้าที่รับเรื่องไว้
		}
		
		$status_modify = " status_admin_key_approve='1',";
		$sql=" update req_problem_person set req_status='$req_status_modify' where req_person_id='$id_req'";	 
//		echo "<pre>".$sql;
//		exit;
		mysql_db_query($db_master,$sql);  //update  req_problem_person		
			
	} 
	
//	if($errortype != ""){
//		$problem_type_modify = "problem_type='$problem_type',";
//	}
	
	### update group
	if($objchange == "1"){
		$sql=" update req_problem set problem_group='$select_group'  , problem_groupno='$sel_load'   ,problem_type='$errortype' , update_datetime=now() where req_person_id='$id_req'";	
//		echo "<pre>".$sql;
//		exit;
		mysql_db_query($db_master,$sql);  //update  req_problem

		if($xaction=="add_replay"){
				$sql=" insert into req_reply (req_person_id,date_create,status_type,comment,staffname,staff_id,from_type,problem_type,old_problem_type,problem_group,oldproblem_group,sys_caption)";
				$sql.="values ('$id_req',NOW(),'$radio_status','$txtcomment_group','$xstaff_fullname','$xstaff_id','staff','$errortype','$old_type','$select_group','$old_group','$syscaption')";
				mysql_db_query($db_master,$sql); //insert  req_reply
			}			
	}
//	### update req_status = '6' fix value
//	$sql=" update req_problem_person set req_status='6' where req_person_id='$id_req' and req_status='1'";	
//	mysql_db_query($db_master,$sql);  //update  req_problem_person
		
	### update req_temp_wrongdata สถานะ
	if($objchange == "2"){
		$sql_key_upd = "UPDATE req_temp_wrongdata 
						SET 
							$status_modify
							$problem_type_modify
							comment_key='$comment_key'
						WHERE
							req_person_id = '$id_req'						
						";	
		//echo $sql_key_upd;
		//exit;					
		mysql_query($sql_key_upd);

		### map สถานะ ให้เหมือน สถานะของแจ้งแก้ไขข้อมูล
		if($approve_type ==2){ # approved
			$req_status = "3";
		}
		
		if($approve_type ==1){ # verify
			$req_status = "2";
		}		
		
		if($xaction=="add_replay"){
				$sql=" insert into req_reply (req_person_id,date_create,status_type,comment,staffname,staff_id,from_type,problem_type,old_problem_type,problem_group,oldproblem_group,sys_caption)";
				$sql.="values ('$id_req',NOW(),'$req_status','$txtcomment','$xstaff_fullname','$xstaff_id','staff','$errortype','$old_type','$select_group','$old_group','$syscaption')";
				mysql_db_query($db_master,$sql); //insert  req_reply
			}	
			
		### insert log
		$sql_key_log = "INSERT INTO req_temp_assignlog 
						SET 
							req_person_id='$req_person_id',
							logtime=now(),
							approve_type='$approve_type',
							approve_comment='$approve_comment',
							staffid='$staffid'
						";
						
	//	echo "<pre>".$sql_key_log;					
	//	exit;
		mysql_query($sql_key_log);
		
		### assign to keyin user
		$get_id = $_POST[temp_id];
		$xtype = $_POST[status_permit];
		EAssignEditKey("$get_id","$xtype");	
		###		
	}
	
	//if($errortype != ""){ //แก้ไข ประเภทข้อมูล  1 : พิมพ์ข้อมูลผิด 2 : ข้อมูลไม่เป็นปัจจุบัน
//		$sql_err = "UPDATE req_person 
//						SET 
//							$problem_type_modify
//							update_datetime=now()
//						WHERE
//							req_person_id = '$id_req'						
//						";	
//		//echo $sql_key_upd;
//		//exit;					
//		mysql_query($sql_err);
//	}
//	
//	if($select_group != ""){ //ปรับหมวดข้อมูล
//		$sql_group = "UPDATE req_person 
//						SET 
//							problem_group = '$select_group'
//							update_datetime=now()
//						WHERE
//							req_person_id = '$id_req'						
//						";	
//		//echo $sql_key_upd;
//		//exit;					
//		mysql_query($sql_group);
//	}	
		

}

function get_real_ip()
{
	$ip = false;
	if(!empty($_SERVER['HTTP_CLIENT_IP']))	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
		if($ip){
			array_unshift($ips, $ip);
			$ip = false;
		}
	for($i = 0; $i < count($ips); $i++){
		if(!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i])){
			if(version_compare(phpversion(), "5.0.0", ">=")){
				if(ip2long($ips[$i]) != false){
					$ip = $ips[$i];
					break;
				}
			} else {
				if(ip2long($ips[$i]) != - 1){
					$ip = $ips[$i];
					break;
				}
			}
		}
	}
}
return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

function getStaffFullName($staffid){
	$sql = "SELECT * FROM ".DB_USERENTRY.".keystaff WHERE staffid='$staffid'";
	$res = mysql_query($sql);
	$row = mysql_fetch_assoc($res);
	return $row[prename].$row[staffname]." ".$row[staffsurname];
}

function getNoCaption($problem_groupno){
	global $db_master;
	$sql = "SELECT * FROM req_problem_groupno WHERE  runid='$problem_groupno' ";
	$res = mysql_db_query($db_master,$sql);
	$row = mysql_fetch_assoc($res);
	return $row[no_caption];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title></title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	color: #000;
}
.box_req{
	background-color:#FF0;
	font-size:12px;
}
.box_acknowledge{
	background-color:#F90;
	font-size:12px;
}
.box_succeed{
	background-color:#0F0;
	font-size:12px;
}
.row1{
background-color:#F3F3F3;
font-size:12px;
}
.row2{
background-color:#F3F3F3;
font-size:12px;
}
.button{
font-size:12px;
width:auto;
height:auto;
}
.linlfile{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000;
}
.boxhead{
	background-color: #F3F3F3;
	border: 1px solid #999;
	padding: 5px;
}
-->
</style></head>
<script src="../../common/jquery.js"></script>
<script>
//$(document).ready(function(){
//	$('#mover').hide();
//});
//});

function getKp7LoadId(idcard,group_id,kp7loadid){
	CreateXmlHttp();
	var params = "idcard="+idcard+"&group_id="+group_id+"&kp7loadid="+kp7loadid;
	
	XmlHttp.open("get", "ajax.get_kp7_loadid.php?"+params ,true);
	XmlHttp.onreadystatechange=function() {
		if (XmlHttp.readyState==4) {
			if (XmlHttp.status==200) {
				var res = XmlHttp.responseText;
				var o = document.getElementById("div_load");
				if(res != ""){
					o.innerHTML = res;
				}
			} else if (XmlHttp.status==404){	
				alert("ไม่สามารถทำการดึงข้อมูลได้");
			} //else {	alert("Error : "+XmlHttp.status);	}
		}
	}
	XmlHttp.send(null);	
}

function CreateXmlHttp(){
	//Creating object of XMLHTTP in IE
	try {	XmlHttp = new ActiveXObject("Msxml2.XMLHTTP");	}
	catch(e){
		try{	XmlHttp = new ActiveXObject("Microsoft.XMLHTTP");		} 
		catch(oc) {	XmlHttp = null;		}
	}
	//Creating object of XMLHTTP in Mozilla and Safari 
	if(!XmlHttp && typeof XMLHttpRequest != "undefined") {
		XmlHttp = new XMLHttpRequest();
	}
}


function show_history(){
	$('#mover').animate({"height": "toggle"}, { duration: 500 }); 	
}
function show_keyin_history()
{
	$('#mover2').animate({"height": "toggle"}, { duration: 500 }); 	
}

function opentable(){
$("#tbl_key").show();
}

function openobj(xsel){
  var show_save = document.getElementById("show_save");
  if(xsel==1){
		$("#errortype1").attr('disabled','')	;
		$("#errortype2").attr('disabled','')	;
		$("#select_group").attr('disabled','')	;
		$("#sel_load").attr('disabled','')	;
		$("#radio_status1").attr('disabled','disabled')	;
		$("#radio_status2").attr('disabled','disabled')	;
		$("#txtcomment").attr('disabled','disabled')	;
		$("#txtcomment_group").attr('disabled','')	;
		$("#button3").attr('style','display:;vertical-align:middle; font-family:tahoma;height:25px;border-style:solid; border-color:#666666; border-width:1px');
  }else{
		$("#errortype1").attr('disabled','disabled')	;
		$("#errortype2").attr('disabled','disabled')	;
		$("#select_group").attr('disabled','disabled')	;		
		$("#sel_load").attr('disabled','disabled')	;		
		$("#radio_status1").attr('disabled','')	;
		$("#radio_status2").attr('disabled','')	;
		$("#txtcomment").attr('disabled','')	;	
		$("#txtcomment_group").attr('disabled','disabled')	;	
		if(show_save.value == "Y"){
			$("#button3").attr('style','display:;vertical-align:middle; font-family:tahoma;height:25px;border-style:solid; border-color:#666666; border-width:1px');
		} else {
			$("#button3").attr('style','display:none');
		}
   }
}
function chksubmit(){
	var chk=false;
if($('#change1').attr('checked')){
//	   if($("#txtcomment").val()==""){
//				alert("กรุณากรอกรายละเอียด");
//				return false ;
//			}
}else{
   if($("#radio_status1").attr('checked')){
	
			if($("#txtcomment").val()==""){
				alert("กรุณากรอกรายละเอียด");
				return false ;
			}
	}
	if(($("#radio_status1").attr('checked')||$("#radio_status5").attr('checked')||$("#radio_status6").attr('checked')||$("#radio_status3").attr('checked')||$("#radio_status5").attr('checked')||$("#radio_status2").attr('checked')||$("#radio_status4").attr('checked'))){
	}else{
	  alert("กรุณาเลือก สถานะ  \n 1.ต้องการคำอธิบายเพิ่มเติม\n 2.อยู่ระหว่างดำเนินการแก้ไข\n 3.ดำเนินการแก้ไขเเรียบร้อย\n 4.เจ้าของข้อมูลรับทราบผลการแก้ไข");
				return false ;
	}
}
	
return true ;	
}



</script>
<body>
<form method="post" enctype="multipart/form-data"   name="form2"  action="?xidcard=<?=$xidcard?>&id_req=<?=$id_req?>"  onsubmit="return chksubmit();"  >
  <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="88%"><?	    
    $sql="SELECT
view_general.prename_th,
view_general.name_th,
view_general.surname_th,
view_general.position_now,
view_general.vitaya,
allschool.office,
eduarea.secname,
view_general.siteid,
view_general.schoolid
FROM
view_general
Inner Join allschool ON view_general.schoolid = allschool.id
Inner Join eduarea ON view_general.siteid = eduarea.secid
where view_general.CZ_ID ='$xidcard'";
  $result_person=mysql_db_query(DB_MASTER,$sql);   
  $row_person=mysql_fetch_array($result_person);
$xsite_now=  $row_person[siteid];
  		$sql_salary = "SELECT * FROM salary WHERE id='$xidcard' order by date DESC,salary DESC,dateorder DESC LIMIT 1";
		$result_salary = mysql_db_query(STR_PREFIX_DB.$row_person[siteid],$sql_salary);
		$rs_salary = mysql_fetch_assoc($result_salary);	
   $ds= dips_icon_alert($xidcard,$row_person[siteid]);
  echo trim("<b>ชื่อ-นามสกุล : </b>  $row_person[prename_th]  $row_person[name_th]  $row_person[surname_th]  $ds <b>ตำแหน่ง : </b> $rs_salary[position]");
if(  $row_person[vitaya]!=""){echo "<b>วิทยะฐานะ : $row_person[vitaya]</b>";}
echo"<br> <b>หน่วยงาน : </b>";
  if($row_person[siteid]==$row_person[schoolid]){
	  echo $row_person[office];
  }else{
   echo "โรงเรียน ".$row_person[office]." ".$row_person[secname];
  } 
    $idtriiet=date('Ymdhns');


	
  	 $sql="SELECT
				req_problem.req_person_id,
				req_problem.problem_group,
				req_problem.number_no,
				req_problem.siteid,
				req_problem.problem_type,
				req_problem.problem_caption,
				req_problem.problem_detail,
				req_problem_person.req_status,
				req_problem_person.kp7_loadid,
				req_problem.problem_groupno,
				left(req_problem.req_date,10) as req_date,
				right(req_problem.req_date,8) as req_time,
				req_problem_person.req_triget,
				req_problem_group.problem_name,	req_problem_type.problem_typename,req_problem.tel1,req_problem.tel2,req_problem.mail1,req_problem.mail2
				FROM
				req_problem
				Inner Join req_problem_person ON req_problem.req_person_id = req_problem_person.req_person_id
				Inner Join req_problem_group ON req_problem_group.runno = req_problem.problem_group
				left Join req_problem_type ON req_problem_type.runno = req_problem.problem_type
				where  req_problem_person.req_person_id='$id_req' ";
 
  $result=mysql_db_query(DB_MASTER,$sql);   
  $row=mysql_fetch_array($result);  
 if($row[req_triget]!=""){$idtriiet=$row[req_triget];}
	?>
      <input type="hidden" name="xaction" id="hiddenField" value="add_replay" />
      <input type="hidden" name="id_req" id="hiddenField" value="<?=$id_req?>"/>
      <input type="hidden" name="trigetid" id="hiddenField" value="<?=$idtriiet?>"/>
       <input type="hidden" name="old_status" id="" value="<?=$row[req_status]?>"/>
      
      </td>
      
    </tr>
    <tr>
      <td  height="10px"></td>
    </tr>
  </table>
  <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:10px">
    <tr>
    <td bgcolor="#666666"><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td align="center" bgcolor="#E4E4E4"><table width="100%" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td colspan="2" align="left" class="boxhead"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="47%"><strong>เลขที่คำร้อง :
                    <?=$idtriiet?>
                </strong></td>
                <td width="53%" align="right"><?=$arratatus[$row[req_status]]['icon'].$arratatus[$row[req_status]]['caption']?></td>
                </tr>
            </table></td>
            </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="left">
           <?
        $fname= "../../../../edubkk_kp7file/".$xsite_now."/".$xidcard.".pdf";
		$ichk=check_success($xidcard,$row[siteid])   ;
		$openlink=false;
		 if($ichk=="-1"||$ichk=="-2"){
			  $fname= "../../../../kp7file_nonsuccess/".$xsite_now."/".$xidcard.".pdf"; 
			 if(file_exists($fname)){
				 $openlink=true;
				 $open_file=$fname;
				 }
		 }else{
			  if(file_exists($fname)){
				  $openlink=true;
				 $open_file= "../../common/open_original_pdf_nopass.php?id=$xidcard&sentsiteid=$xsite_now";
				 }
			 }
?>
<a href="../../common/open_original_pdf_nopass.php?id=<?=$xidcard?>&sentsiteid=<?=$row[siteid]?>" title="ดาวน์โหลดเอกสาร ก.พ.7 ต้นฉบับ" target="_blank"><img src="../../../images_sys/gnome-mime-application-pdf.png" width="20" height="20"  border="0" /></a>
            <a href="../hr3/hr_report/kp7.php?id=<?=$xidcard?>&sentsecid=<?=$xsite_now?>&nonpass=1" title="ดาวน์โหลดเอกสาร ก.พ.7 อิเล็กทรอนิกส์" target="_blank">
            <img src="../../images_sys/acroread.png" width="24" height="24" border="0" />            </a><a href="../req_approve/admin_sapphire/show_detail.php?xidcard=<?=$xidcard?>&xsiteid=<?=$xsite_now?>" title="ข้อมูลปัจจุบัน" target="_blank"><img src="../../images_sys/emblem-documents.png" width="24" height="24" border="0" /></a>            </td>
          </tr>
          <tr>
            <td width="30%" align="right"><strong>หมวดรายการ  :</strong></td>
            <td width="70%" align="left">
              <?=$row[problem_name]?>              </td>
          </tr>
          <tr>
            <td align="right"><strong>หมายเลขรายการที่ผิด  :</strong></td>
            <?php
				$no_caption = getNoCaption($row[problem_groupno]) ;
			?>
            <td align="left"><?=$no_caption == "" ? "-" : $no_caption?></td>
          </tr>
          <tr>
            <td align="right"><strong>รายการที่ผิด :</strong></td>
            <td align="left"><?=$row[problem_caption]?></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong>รายละเอียดที่ถูกต้อง :</strong></td>
            <td align="left" valign="top"><?=$row[problem_detail]?></td>
          </tr>
          <tr>
            <td align="right"><strong>ประเภท :</strong></td>
            <td align="left">
            <?=$row[problem_typename]?>              </td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong>ไฟล์แนบ :</strong></td>
            <td align="left" valign="top">  <?
       $sql_file="SELECT run_no,req_person_id,problem_group,problem_type,filename,filepath 
                    FROM req_problem_attach  Join req_problem_type ON req_problem_attach.problem_type = req_problem_type.runno where req_person_id='$id_req'   and file_from is null  group by run_no";
		$result_file=mysql_db_query($db_master,$sql_file);
		$i=0;
		while($row_file=mysql_fetch_array($result_file)){   
		$i++;
		if($i>1){echo"&nbsp;,&nbsp;";}
	$str=str_replace("../../../../req_approve/Files_attach/","",$row_file[filepath]);
		
		
		echo"<span class='linlfile' ><img src=\"../images/i_attach.gif\" width=\"7\" height=\"12\" />&nbsp;$row_file[filename] (<a href=\"../../../../req_approve/Files_attach/$str\" target=\"_blank\">เปิดไฟล์</a>)</span>";
                          }
	   ?>              </td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong>เบอร์โทรศัพท์ :</strong></td>
            <td align="left" valign="top">	<?
            $strtel= $row[tel1];
			if($row[tel2]!=""){
			if($strtel!=""){$strtel.=",";}
			$strtel.= $row[tel2];
			}
			echo $strtel;
			?></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong>อีเมล์  :</strong></td>
            <td align="left" valign="top"><?
            $strtel= $row[mail1];
			if($row[mail2]!=""){
			if($strtel!=""){$strtel.=",";}
			$strtel.= $row[mail2];
			}
			echo $strtel;
			?></td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td align="right" style="font-size:11px;font-style:oblique"><?
			 $arr=explode("-",$row[req_date]);			  
			echo  "วันที่ ".($arr[2]*1)." ".$monthname[($arr[1]*1)]." ".($arr[0]+543)." เวลา ".$row[req_time];			
			?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
 
  </table>
  <br />
<table align="center" width="70%" cellpadding="0" cellspacing="1" style="background-color:#CCCCCC"><tr><td>
          <table width="100%" align="center" border="0" cellspacing="5" cellpadding="0" id="tbl_key" style="background-color:#ffffff">
            <tr>
              <td align="center" style="background-color:#E4E4E4; border:0px; border-color:#999999"><table width="100%" border="0" cellspacing="1" cellpadding="0" style="background-color:#999999">
              <tr>
                <td width="94%" align="center" style="background-color:#CCCCCC; height:25px">ประวัติการแก้ไขคำร้องของพนักงาน Key In <?php
				$sql_keyin_log_count = "SELECT
										COUNT(tbl_assign_edit_log_detail.req_person_id) AS cn
										FROM ".DB_USERENTRY.".tbl_assign_edit_key
										Inner Join ".DB_USERENTRY.".tbl_assign_edit_log 
										ON ".DB_USERENTRY.".tbl_assign_edit_key.idcard = tbl_assign_edit_log.idcard AND tbl_assign_edit_key.ticketid = tbl_assign_edit_log.ticketid
										Inner Join ".DB_USERENTRY.".tbl_assign_edit_log_detail 
										ON tbl_assign_edit_log.runid = tbl_assign_edit_log_detail.log_id
										WHERE 1=1
										AND req_person_id='$id_req'
";  
//				echo "<pre>";
//				echo $sql_keyin_log_count;
//				exit;
				$res_keyin_log_count = mysql_query($sql_keyin_log_count);
				$row_keyin_log_count = mysql_fetch_assoc($res_keyin_log_count);
				echo "(".number_format($row_keyin_log_count[cn])." รายการ)";
				?> </td>
                <td width="6%" align="center" style="background-color:#CCCCCC; height:25px"><div id="slide_keyin_history" onmouseover="this.style.cursor='pointer'" onclick="show_keyin_history()"><img src='images/navigate_down2.png' align='absmiddle' width="20" title='เปิดดูประวัติการแก้ไขคำร้องของพนักงาน Key In' /></div></td>
              </tr>
            </table></td>
            </tr>
            <tr>
              <td><div id="mover2" style="display:none"><table width="100%" border="0" cellspacing="1" cellpadding="5" style="background-color:#999999">
                <tr style="background-color:#CCCCCC">
                  <th width="25%">วัน-เวลาจ่ายงาน</th>
                  <th width="24%">วัน-เวลาแก้ไขเสร็จ</th>
                  <th width="17%">สถานะ</th>
				  <th width="34%">ผู้แก้ไข</th>
                  <th width="34%">รายะเอียด</th>
                  </tr>
				<?php
					$sql_keyin_log = "SELECT tbl_assign_edit_key.*,
										tbl_assign_edit_log_detail.req_person_id,
										tbl_assign_edit_key.idcard,
										tbl_assign_edit_key.fullname,
										tbl_assign_edit_key.comment_req,
										tbl_assign_edit_key.userkey_wait_approve,
										keystaff.staffname,keystaff.staffsurname,keystaff.prename
										FROM ".DB_USERENTRY.".tbl_assign_edit_key
										Inner Join ".DB_USERENTRY.".tbl_assign_edit_log 
										ON tbl_assign_edit_key.idcard = tbl_assign_edit_log.idcard AND tbl_assign_edit_key.ticketid = tbl_assign_edit_log.ticketid
										
										Inner Join ".DB_USERENTRY.".tbl_assign_edit_log_detail 	
										ON tbl_assign_edit_log.runid = tbl_assign_edit_log_detail.log_id
										LEFT JOIN ".DB_USERENTRY.".keystaff ON keystaff.staffid = tbl_assign_edit_log.staffid
										where 1=1
										AND req_person_id='$id_req'
										ORDER BY dateassgin DESC
";  
					$res_keyin_log = mysql_query($sql_keyin_log);
					$int = 0;
					while($row_keyin_log = mysql_fetch_assoc($res_keyin_log)){
						$int++;
						
					
				?>
                <tr style="background-color:#FFFFFF">
                  
                  <td style="text-align:center"><?=shortday(substr($row_keyin_log[dateassgin],0,10))." ".substr($row_keyin_log[dateassgin],11)?></td>
                  <td style="text-align:center"><?=shortday(substr($row_keyin_log[update_time],0,10))." ".substr($row_keyin_log[update_time],11)?></td>
                  <td style="text-align:center"><?php
				  
//				  if($row_keyin_log[approve_type]==1){
//				  	echo "Verify";
//				  } 
//				  if($row_keyin_log[approve_type]==2){
//				  	echo "Approved";
//				  }
				  
					$sql_approve = "SELECT * FROM  ".DB_MASTER.".req_type_keyapprove WHERE runid = '".$row_keyin_log[userkey_wait_approve]."'";
					//echo $sql_approve;
					$res_approve = mysql_query($sql_approve);
					$row_approve = mysql_fetch_assoc($res_approve);
					echo $row_approve[type_key_approve];
					//echo $row_keyin_log[userkey_wait_approve];
				  ?></td>
				  <td><?=$row_keyin_log[prename].$row_keyin_log[staffname]." ".$row_keyin_log[staffsurname]?></td>
                  <td><?=$row_keyin_log[comment_req]?></td>
				  </tr>
				<? } ?>
              </table>
              </div></td>
            </tr>
          </table></td></tr></table>	  
		  <br />
		  <table align="center" width="70%" cellpadding="0" cellspacing="1" style="background-color:#CCCCCC"><tr><td>
          <table width="100%" align="center" border="0" cellspacing="5" cellpadding="0" id="tbl_key" style="background-color:#ffffff">
            
            <tr >
              <td width="177" height="35" align="right"><label>
              <input  type="radio" name="objchange" id="change1" value="1" onclick="openobj(1)" />
              เปลี่ยนแปลงประเภท และหมวดรายการ&nbsp; </label></td>
              <td width="65" height="35" align="left">&nbsp;<strong>ประเภท</strong></td>
              <td width="405"><?
			$chk1="";
			$chk2="";
            if($row[problem_type]=="1"){
				$chk1="checked";
			}
			if($row[problem_type]=="2"||$chk1==""){
				 $chk2="checked";
			}
			
			?>
                    
                    <input value="1" <?=$chk1?> type="radio" name="errortype"  id="errortype1" disabled="disabled" />
พิมพ์ข้อมูลผิด
<input value="2" <?=$chk2?>  type="radio" name="errortype"  id="errortype2" disabled="disabled"/>
ข้อมูลไม่เป็นปัจจุบัน<input type="hidden"  name="h_errortype" value="<?=$row[problem_type]?>"/></td>
            </tr>
            <tr >
              <td height="35" align="right">&nbsp;</td>
              <td height="35" colspan="2" align="left">&nbsp;<strong>หมวดรายการ : </strong><br /><div>
                <select name="select_group" id="select_group" style="width:400px" disabled="disabled" onchange="getKp7LoadId('<?=$xidcard?>',this.value,'<?=$row[kp7_loadid]?>');">
                  <?
                $sql_group="SELECT runno,problem_name,popup_url,status,order_by,number_text FROM `req_problem_group`  where status='1'  order by  order_by";		
		$result_group=mysql_db_query(DB_MASTER,$sql_group);
		while($row_group=mysql_fetch_array($result_group)){
			$sel=($row[problem_group]==$row_group[runno])?"selected":"";
		?>
                  <option <?=$sel?> value="<?=$row_group[runno]?>" title="<?=$row_group[problem_name]?>">
                  <?=$row_group[problem_name]." (".$row_group[number_text].")"?>
                  </option>
                  <?
		}
			  
			  ?>
                </select></div></td>
            </tr>
            <tr >
              <td height="35" align="right">&nbsp;</td>
              <td height="35" colspan="2" align="left"><div id="groupno" style="display:<?=($row[problem_groupno] != "" && $row[reg_person_id] == "") ? "" : "none"?>">&nbsp;<strong>หมายเลขรายการที่ผิด : </strong><br /><div id="div_load">
                <select name="sel_load" id="sel_load" style="width:400px" disabled="disabled">
                  <?
                $sql_load="SELECT req_problem_groupno.* FROM `req_problem_groupno`  INNER JOIN req_kp7_load ON   req_problem_groupno.kp7_loadid = req_kp7_load.kp7_loadid 
				Where req_kp7_load.idcard = '$xidcard'  AND req_kp7_load.kp7_loadid = '$row[kp7_loadid]' AND req_problem_groupno.problem_groupid='$row[problem_group]' ";	
				//echo $sql_load;		
		$result_load=mysql_db_query(DB_MASTER,$sql_load);
		while($row_load=mysql_fetch_array($result_load)){
			$sel=($row[problem_groupno]==$row_load[runid])?"selected":"";
		?>
                  <option <?=$sel?> value="<?=$row_load[runid]?>" title="<?=$row_load[no_caption]?>">
                  <?=$row_load[no_caption]?>
                  </option>
                  <?
		}
			  
			  ?>
                </select><div>
                </div></td>
            </tr>
            <tr >
              <td height="35" align="right" valign="top">รายละเอียดการเปลี่ยนแปลง<br />ประเภทและหมวดรายการ</td>
              <td height="35" colspan="2" ><textarea name="txtcomment_group" cols="70" rows="10" id="txtcomment_group" disabled="disabled"></textarea></td>
            </tr>
            <tr>
              <td align="right" style="width:175px"><input name="objchange" type="radio" id="change2" value="2" checked="checked"  onclick="openobj(2)"  />เปลี่ยนแปลงสถานะ&nbsp;&nbsp;</td>
			  <?php
			  $sql_temp = "SELECT * FROM req_temp_wrongdata WHERE req_person_id='$id_req'";
			  $res_temp = mysql_query($sql_temp);
			  $row_temp = mysql_fetch_assoc($res_temp);
			  $chk_v = "";
			  $chk_a = "";
			  if($row_temp[status_req_approve] == 1){
			  	$chk_v = "checked";
			  }
			  if($row_temp[status_admin_key_approve] == 1){
			  	$chk_a = "checked";
			  }			  
			  ?>
              <td colspan="2" ><label>
                <input type="radio" name="radio_status" id="radio_status1" value="1" <?=$chk_v?> />Verify </label>
                <label><input type="radio" name="radio_status" id="radio_status2" value="2" <?=$chk_a?> />Approve</label></td>
            </tr>
			<?php
			if($row_temp[status_key_approve] > 0 || $row_temp[status_admin_key_approve]==1){
			?>
            <tr>
              <td align="right" valign="top">รายละเอียด&nbsp;&nbsp;</td>
              <td colspan="2" align="left" valign="top"><textarea name="txtcomment" cols="70" rows="10" id="txtcomment"></textarea></td>
            </tr>
			<?php } ?>
            <tr>
              <td colspan="3" align="center">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" align="center">
			  <?php
			  	$show_save = $row_temp[status_key_approve] > 0 || $row_temp[status_admin_key_approve] ==1 ? "Y" : "";
			  ?>
                <input type="hidden"  name="show_save" id="show_save"  value="<?=$show_save?>"/>
                <input type="hidden" value="<?=$row[problem_type]?>" name="old_type" id="old_type"/>
                <input type="hidden" value="<?=$row[problem_group]?>" name="old_group" id="old_group"/>
				<input type="hidden" value="<?=$row_temp[status_permit]?>" name="status_permit" id="status_permit" />
				<input type="hidden" value="<?=$row_temp[runid]?>" name="temp_id" id="temp_id" />
				<input  name="button3" type="submit" class="button" id="button3" style="display:<?=($show_save == "Y" ? "" : "none")?>;vertical-align:middle; font-family:tahoma;height:25px;border-style:solid; border-color:#666666; border-width:1px" value="   บันทึก   "   />
                <input name="button4" type="button" class="button" id="button4" value="     ปิด     "  onclick="window.open('','_self');window.close();" style=" vertical-align:middle; font-family:tahoma;height:25px;border-style:solid; border-color:#666666; border-width:1px" />              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="2" align="left">&nbsp;</td>
            </tr>
          </table></td></tr></table></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <br />
<table align="center" width="70%" cellpadding="0" cellspacing="1" style="background-color:#CCCCCC"><tr><td>
          <table width="100%" align="center" border="0" cellspacing="5" cellpadding="0" id="tbl_key" style="background-color:#ffffff">


            
            <tr>
              <td align="center" style="background-color:#E4E4E4; border:0px; border-color:#999999"><table width="100%" border="0" cellspacing="1" cellpadding="0" style="background-color:#999999">
              <tr>
                <td width="94%" align="center" style="background-color:#CCCCCC; height:25px">ประวัติการตรวจสอบแก้ไขคำร้อง                  <?php
				$sql_apv_log_count = "SELECT count(runid) AS cn FROM req_temp_assignlog WHERE req_person_id='$id_req' ";  
				$res_apv_log_count = mysql_query($sql_apv_log_count);
				$row_apv_log_count = mysql_fetch_assoc($res_apv_log_count);
				echo "(".number_format($row_apv_log_count[cn])." รายการ)";
				?> </td>
                <td width="6%" align="center" style="background-color:#CCCCCC; height:25px"><div id="slide_history" onmouseover="this.style.cursor='pointer'" onclick="show_history()"><img src='images/navigate_down2.png' align='absmiddle' width="20" title='เปิดดูประวัติ' /></div></td>
              </tr>
            </table></td>
            </tr>
            <tr>
              <td><div id="mover" style="display:none"><table width="100%" border="0" cellspacing="1" cellpadding="5" style="background-color:#999999">
                <tr style="background-color:#CCCCCC">
                  <th width="27%">วัน-เวลาบันทึก</th>
                  <th width="18%">สถานะ</th>
                  <th>รายะเอียด</th>
                  <th width="20%">ผู้ตรวจสอบ</th>
                </tr>
				<?php
					$sql_apv_log = "SELECT * FROM req_temp_assignlog WHERE req_person_id='$id_req' ORDER BY logtime DESC";  
					$res_apv_log = mysql_query($sql_apv_log);
					$int = 0;
					while($row_apv_log = mysql_fetch_assoc($res_apv_log)){
						$int++;
						
					
				?>
                <tr style="background-color:#FFFFFF">
                  
                  <td style="text-align:center"><?=shortday(substr($row_apv_log[logtime],0,10))." ".substr($row_apv_log[logtime],11)?></td>
                  <td style="text-align:center"><?php
				  
				  if($row_apv_log[approve_type]==1){
				  	echo "Verify";
				  } 
				  if($row_apv_log[approve_type]==2){
				  	echo "Approved";
				  }
				  
				  ?></td>
                  <td><?=$row_apv_log[approve_comment]?></td>
				  <td><?=getStaffFullName($row_apv_log[staffid])?></td>
                </tr>
				<? } ?>
              </table></div></td>
            </tr>
          </table></td></tr></table>  
</form>
</body>
</html>
