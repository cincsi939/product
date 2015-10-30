<?
//echo "<pre>";
//print_r($_SERVER);
//exit;
header("Content-Type: text/html; charset=windows-874");  
session_start();
if($_SESSION[session_staffid]==""){
  echo"คุณยังไม่ได้เข้าสู่ระบบ กรุณากลับไปเข้าสู่ระบบ";
 // header("Location: ../../userentry/login.php");
 // echo'<META HTTP-EQUIV="Refresh" CONTENT="2;URL="../../userentry/login.php">'; 
  die();
}

#initial variable
//$url_and_para = getUrlAndPara();
$url_and_para = "?xsiteid=$xsiteid&xsiteid2=&openfrom=&problem_group=$problem_group";

include("../../config/conndb_nonsession.inc.php");
include ("../../common/common_competency.inc.php");
include("function.php");
$db_master=DB_MASTER;



function getUrlAndPara(){
	$url = explode("/",$_SERVER['REQUEST_URI']);
	$url_string = $url[count($url)-1];
	return $url_string;
}

function getDataDate($siteid,$db_master){
	//echo $siteid,$db_master;
	//exit;
	$sql = "SELECT MIN(req_date) AS dt FROM req_problem_person WHERE req_status IN(1,2) AND idcard != '' AND del <> 1 AND site='$siteid'";
	//echo $sql;
	//exit;

	$res = mysql_db_query($db_master,$sql);
	$row = mysql_fetch_assoc($res);
	return $row[dt];
}

function getStatusName($temp){
	$result = "";
	switch($temp){
		case "verify" : 
			$result = "ผ่านการคัดกรองจาก Call Center";
			break;
		case "assign" : 
			$result = "Assign";
			break;
		case "approvekeyin" : 
			$result = "Approve Key In";
			break;
		case "approvecallcenter" : 
			$result = "Approve Call Center";
			break;
	}
	
	return $result;
}

function getWhereStatus($temp){
	$where = "";
	if($temp == "verify"){
		$where .= " AND status_req_approve=1 AND (status_assign <> 1 AND status_key_approve = 0 AND status_admin_key_approve <> 1 )";
	}
	if($temp == "assign"){
		$where .= " AND status_assign=1 AND (status_key_approve = 0 AND status_admin_key_approve <> 1)";
	}
	if($temp == "approvekeyin"){
		$where .= " AND status_key_approve>0 AND (status_admin_key_approve <> 1)";
	}
	if($temp == "approvecallcenter"){
		$where .= " AND status_admin_key_approve=1";
	}		
	
	return $where;
}

function getWhereProblemGroup($id){
	$where="";
	if($id != ""){
		$where = " AND req_problem.problem_group='$id'";
	}
	return $where;
}

function getCountKeyApprove($where,$where_problem,$where_status,$where_keyapprove,$siteid){

global $db_master;
$sql = "SELECT 
				COUNT(req_temp_wrongdata.req_person_id) AS nnum 
			FROM req_temp_wrongdata 
				INNER JOIN req_problem_person ON req_temp_wrongdata.req_person_id = req_problem_person.req_person_id
				INNER JOIN req_problem ON req_temp_wrongdata.req_person_id = req_problem.req_person_id
				LEFT JOIN req_problem_group ON req_problem.problem_group = req_problem_group.runno
				INNER JOIN view_general ON req_problem_person.idcard = view_general.CZ_ID  
				LEFT JOIN ".DB_USERENTRY.".tbl_assign_edit_key ON tbl_assign_edit_key.idcard = req_problem_person.idcard
				INNER JOIN ".DB_USERENTRY.".tbl_assign_edit_sub ON  tbl_assign_edit_key.ticketid = tbl_assign_edit_sub.ticketid
				LEFT JOIN ".DB_USERENTRY.".keystaff ON keystaff.staffid = tbl_assign_edit_sub.staffid		
			WHERE req_temp_wrongdata.problem_type=1
				AND view_general.siteid = '$siteid'
				$where_status
				$where
				$where_problem
				$where_keyapprove
			";
//	echo $sql;
//echo $db_master;
//	exit;
	$res=mysql_db_query($db_master, $sql);
	$row = mysql_fetch_assoc($res);
	return $row[nnum];
}

//	$where_problem = getWhereProblemGroup($problem_group);
//	$sql_exsum = "	SELECT 
//					SUM(IF(status_req_approve=1,1,0)) AS verify,
//					SUM(IF(status_assign=1,1,0)) AS assign,
//					SUM(IF(status_key_approve=1,1,0)) AS approvekeyin,
//					SUM(IF(status_admin_key_approve=1,1,0)) AS approvecallcenter
//					FROM  req_problem INNER JOIN 
//					req_temp_wrongdata ON req_problem.req_person_id = req_temp_wrongdata.req_person_id
//					LEFT JOIN req_problem_group ON req_problem.problem_group = req_problem_group.runno
//					WHERE 1=1
//					AND req_temp_wrongdata.problem_type = 1
//					AND siteid = '$xsiteid'
//					$where_problem
//					";
//
//	$res_exsum = mysql_db_query($db_master,$sql_exsum);
//	$row_exsum = mysql_fetch_assoc($res_exsum);
//	$arr_exsum[verify] = $row_exsum['verify'];
//	$arr_exsum[assign] = $row_exsum['assign'];
//	$arr_exsum[approvekeyin] = $row_exsum['approvekeyin'];
//	$arr_exsum[approvecallcenter] = $row_exsum['approvecallcenter'];

	$where_problem = getWhereProblemGroup($problem_group);
	$sql_exsum = "	SELECT 
						*
					FROM  req_problem 
					INNER JOIN req_temp_wrongdata ON req_problem.req_person_id = req_temp_wrongdata.req_person_id
					INNER JOIN req_problem_person ON req_temp_wrongdata.req_person_id = req_problem_person.req_person_id					
					LEFT JOIN req_problem_group ON req_problem.problem_group = req_problem_group.runno
					INNER JOIN view_general ON req_problem_person.idcard = view_general.CZ_ID  
					LEFT JOIN ".DB_USERENTRY.".tbl_assign_edit_key ON tbl_assign_edit_key.idcard = req_problem_person.idcard
					INNER JOIN ".DB_USERENTRY.".tbl_assign_edit_sub ON  tbl_assign_edit_key.ticketid = tbl_assign_edit_sub.ticketid
					LEFT JOIN ".DB_USERENTRY.".keystaff ON keystaff.staffid = tbl_assign_edit_sub.staffid					
					WHERE 1=1
					AND req_temp_wrongdata.problem_type = 1
					AND view_general.siteid = '$xsiteid'
					$where_problem
					";			
	
	$arr_exsum['approvecallcenter'] = 0;
	$arr_exsum['approvekeyin'] = 0;
	$arr_exsum['assign'] = 0;
	$arr_exsum['verify'] = 0;
	$res_exsum = mysql_db_query($db_master,$sql_exsum);	
	while($row_exsum = mysql_fetch_assoc($res_exsum)){
		if($row_exsum[status_admin_key_approve] == 1){
			$arr_exsum['approvecallcenter'] += 1;
			continue;
		}
		if($row_exsum[status_key_approve] > 0){
			$arr_exsum['approvekeyin'] += 1;
			continue;
		}
		
		if($row_exsum[status_assign] == 1){
			$arr_exsum['assign'] += 1;
			continue;
		}
		
		if($row_exsum[status_req_approve] == 1){
			$arr_exsum['verify'] += 1;
			continue;
		}		
	}

$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

//if($del_data!=""){
// $sql_del="update  req_problem_person  set del =1  where req_person_id in ($del_data) ";
//mysql_db_query($db_master,$sql_del);
//
//}




//function checkimg($req_id){
//	global $db_master;
//	$sql="SELECT filename,req_person_id,problem_type,filepath FROM `req_problem_attach` where    req_person_id ='$req_id'  and file_from is null ";
//	$result=mysql_db_query($db_master,$sql);	
//	while($row_file=mysql_fetch_array($result)){
//		$str_file=str_replace("../../../../req_approve/Files_attach/","",$row_file[filepath]);
//		$str.="<a href='../../../../req_approve/Files_attach/$str_file' title='$row_file[filename]' target='_blank'><img src='../images/i_attach.gif' border=0></a>";
//	}
//	return " ".$str;
//}

function CountAll($xsiteid,$text_search,$xcond){
	global $db_master,$debug;
	$arr_status[1]=1;
	$arr_status[2]=2;
	$arr_status[3]=3;
	$arr_status[4]=4;
	$arr_status[5]=5;
	$arr_status[6]=6;
	$arr_status[7]=7;
	foreach ($arr_status as $index=>$values){

		$sql = "SELECT
					COUNT(req_problem_person.req_status) AS nnum
				FROM 
					req_problem_person
					INNER JOIN view_general 
						ON req_problem_person.idcard = view_general.CZ_ID  and view_general.siteid = '$xsiteid'
					INNER JOIN req_problem 
						ON  req_problem_person.req_person_id=req_problem.req_person_id 
						
				WHERE 
					(view_general.siteid = '$xsiteid' AND req_problem_person.del=0 ) 
					AND ( req_problem_person.req_triget = '$text_search'  OR
						req_problem_person.idcard LIKE '%$text_search%'  OR
						view_general.name_th LIKE '%$text_search%'  OR
						view_general.surname_th LIKE '%$text_search%'  OR
						view_general.schoolname  LIKE '%$text_search%' 	 ) 							
					AND view_general.siteid='$xsiteid' 
					AND req_problem_person.req_status='$values'  
					$xcond";
					
//	echo "<pre>".$sql;
	$result = mysql_db_query($db_master,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arr1[$values] = $rs[nnum];			
		}	
	}	
	
	if($result){ mysql_free_result($result);}
	
	return $arr1;
}
/*function CountAll($xsiteid,$text_search,$xcond){
	global $db_master,$debug;
	$arr_status[1]=1;
	$arr_status[2]=2;
	$arr_status[3]=3;
	$arr_status[4]=4;
	$arr_status[5]=5;
	$arr_status[6]=6;
	$arr_status[7]=7;
	
	
	$sql = "SELECT
	Sum(if(req_problem_person.req_status=1,1,0)) AS sum_req1,
	Sum(if(req_problem_person.req_status=2,1,0)) AS sum_req2,
	Sum(if(req_problem_person.req_status=3,1,0)) AS sum_req3,
	Sum(if(req_problem_person.req_status=4,1,0)) AS sum_req4,
	Sum(if(req_problem_person.req_status=5,1,0)) AS sum_req5,
	Sum(if(req_problem_person.req_status=6,1,0)) AS sum_req6 ,
	Sum(if(req_problem_person.req_status=7,1,0)) AS sum_req7 
	FROM req_problem_person
Inner Join view_general ON req_problem_person.idcard = view_general.CZ_ID
inner  Join req_problem ON  req_problem_person.req_person_id=req_problem.req_person_id
where (req_problem_person.site = '$xsiteid' and req_problem_person.del=0 ) 
and ( req_problem_person.req_triget = '$text_search'  or
	 req_problem_person.idcard like '%$text_search%'  or 
	 view_general.name_th like '%$text_search%'  or 
	 view_general.surname_th like '%$text_search%'  or
	 view_general.schoolname  like '%$text_search%' 	 ) 	
	and  req_problem_person.site='$xsiteid' $xcond";
	if($debug=="1"){echo $sql;}
	$result = mysql_db_query($db_master,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr1['1'] = $rs[sum_req1];
			$arr1['2'] = $rs[sum_req2];
			$arr1['3'] = $rs[sum_req3];
			$arr1['4'] = $rs[sum_req4];
			$arr1['5'] = $rs[sum_req5];
			$arr1['6'] = $rs[sum_req6];	
			$arr1['7'] = $rs[sum_req7];	
	}
	
	
	
	return $arr1;
}*/
function ShowTypeProblem($req_id){
	global $db_master,$openform;

	
	 $sql = "SELECT 
sum(if(problem_type=2,1,0)) as sumtype1,
sum(if(problem_type=1,1,0)) as sumtype2
FROM  req_problem
where req_person_id='$req_id'
group by req_person_id";
	$result = mysql_db_query($db_master,$sql);
	$rs = mysql_fetch_assoc($result);
	$arr['1'] = $rs[sumtype1];
	$arr['2'] = $rs[sumtype2];
	return $arr;	
}//end function ShowTypeProblem($req_id){
	
	
$xcolspan2="colspan='5' ";
$chk1="checked";
$chk2="checked";

$chk1="";
$chk2="";
$plink="";
	if($checkbox_1!=""){
		$chk1="checked";
	    $xcond=" and  req_problem.problem_type=1";
		$plink="1";
	}	
	if($checkbox_2!=""){
		$chk2="checked";
		if($xcond!=""){
			  $xcond="";
			  $plink="";
		 }else{
		  $xcond.=" and  req_problem.problem_type=2";
		  $plink="2";
		}
	  
	}	

if($dstart!=""){
	$arr=explode("/",$dstart);
	$d_start=($arr[2]-543)."-".($arr[1])."-".($arr[0]);
	$arr=explode("/",$dstop);
	$d_stop=($arr[2]-543)."-".($arr[1])."-".($arr[0]);
	$xcond.=" and ( left(req_problem_person.req_date,10) between '$d_start' and '$d_stop')";
}

				
 $arrall=CountAll($xsiteid,$text_search,$xcond)	;
 

 
 
// print_r($arrall);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานสรุปแจ้งแก้ไขข้อมูล</title>
<style type="text/css">
<!--
a:link {
	color: #000;
}
a:visited {
	color: #000;
}
a:hover {
	color: #000;
}
a:active {
	color: #000;
}
.head_label{font-size:12px;}
-->
</style></head>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="../../common/jquery.js"></script>
<link href="css/calendar_style.css" rel="stylesheet" type="text/css" />
<script src="popcalendar.js"></script>
<script src="../../common/gs_sortable.js"></script>
<link href="../../common/gs_sortable.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript"> 

var TSort_Data = new Array ('my_table','', 'n', 'n','s', 's', 's', 's', 's','','');
var TSort_Classes = new Array ('row1', 'row2');
$(document).ready(function(){

	tsRegister();
});

function clearsearch(){
document.form1.dstart.value="";
document.form1.dstop.value="";
document.form1.text_search.value="";
document.form1.checkbox_2.checked=0;
document.form1.checkbox_1.checked=0;
}
function checkdate(){
  var dstart=document.form1.dstart.value;
  var dstop=document.form1.dstop.value;
 if(dstart!=""||dstop!=""){ 
 
  if(dstart==""){ 
  alert("ไม่ได้กำหนดวันเริ่มต้น");
    return false;
  }
  if(dstop==""){ 
  alert("ไม่ได้กำหนดวันสิ้นสุด");
   return false;
  }
  var arr=dstart.split('/');
  var d_date1=Date(arr[2]-543,arr[1],arr[0],0,0,0,0);
  arr=dstop.split('/');
  var d_date2=Date(arr[2]-543,arr[1],arr[0],0,0,0,0);
  if(d_date1>d_date2){
	  alert("วันที่เริ่มต้นมากกว่าวันที่สิ้นสุด");
	  return false;
  }else{
	   return true;
  }
 }
}




function openwin(url){
	var x="";
	if($('#checkbox_1').attr('checked')){
	    	x="1";
	}
		if($('#checkbox_2').attr('checked')){
			x="2";		
		}
	if($('#checkbox_1').attr('checked')&&$('#checkbox_2').attr('checked')){
	    	x="";
	}	
  window.open(url+"&plink="+x,'mywindow','width=800,height=600,resizable=yes,scrollbars=yes,toolbar=yes,status=yes')
}

function clickEvent(div,idcard,req_id,action){
	var url="status.ajax.php?rnd="+(Math.random()*1000)+"&action="+action+"&idcard="+idcard+"&req_id="+req_id;
	
	$.get(url,"",function(data){		
		var arr_re=data.split("||");		
		if(arr_re[0]=='1'){
		 $('#but'+req_id).empty().append(arr_re[1]);
		 $('#status'+req_id).empty().append(arr_re[2]);
		}else{
		 $('#'+req_id).empty().append(arr_re[0]);
		}
		
	});
}

function chkall(value){
$("#my_table").find("input[@type$='checkbox']").not('#xall').each(function(){
																		  
	if(value){
		$(this).attr("checked",value);	
	}else{
		$(this).attr("checked","");					
	}
});
 
}

function del(){
	var xstr="";
$("#my_table").find("input[@type$='checkbox']").not('#xall').each(function(){
    if ( $(this).attr("checked")){
	   if(xstr!=""){xstr+=",";}
	    xstr+=$(this).val();
	}
});
  if(xstr==""){
	  alert("กรุณาเลือกรายการที่ต้องการลบ");
  }else{
   if(confirm("ต้องการลบข้อมุลตามรายการที่เลือกหรือไม่?")){}
      document.form1.del_data.value=xstr;
	   document.form1.submit();
  } 
}


</script>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#A3B2CC" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="37%" valign="top" bgcolor="#A3B2CC">&nbsp;</td>
        <td width="63%" height="62" valign="top"> <form id="form1" name="form1" method="post" action="?xsiteid=<?=$xsiteid?>&search_type_name=<?=$search_type_name?>&problem_group=<?=$problem_group?>" onSubmit=" return checkdate()">
          <table width="100%" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="86%" height="2"></td>
              <td width="7%"></td>
              <td width="7%"></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#A3B2CC" style="color:#000000;font-size:14px">*คำค้น :
                <input name="text_search" id="text_search" type="text" size="50"  value="<?=$text_search?>"/></td>
              <td align="left" style="color:#FFF;font-size:14px"><input name="button2" type="submit" class="nomal_text" id="button2" value="ค้นหา" /></td>
              <td align="left" style="color:#FFF;font-size:14px"><input type="button" name="button" onclick="clearsearch()"  class="nomal_text"id="button" value="ล้างค่า" /></td>
            </tr>
            <tr>
              <td align="right" style="color:#000;font-size:14px"><label>ตั้้งแต่วันที่ :
                <input name="dstart" type="text" id="textfield3" readonly="readonly" style="width:90px"  value="<?=$dstart?>"/>
                </label>
                  <input name="image" type="image" id="bnt" style='font-size:11px ;' onclick='popUpCalendar(form1.dstart, form1.dstart, "dd/mm/yyyy") ;return false ' value="&nbsp;&nbsp;"  src="../../images_sys/calendar-icon.png" align="bottom" />
                  <label id="xx"> ถึงวันที่ :
                    <input name="dstop" type="text" id="dstop" readonly="readonly" value="<?=$dstop?>" style="width:90px"  />
                  </label>
                  <input name="image" type="image" id="bnt" style='font-size:11px ;' onclick='popUpCalendar(xx, form1.dstop, "dd/mm/yyyy") ;return false ' value="&nbsp;&nbsp;"  src="../../images_sys/calendar-icon.png" align="bottom" /></td>
              <td align="left" style="color:#000;font-size:14px"><span style="color:#FFF;font-size:14px"><a href="javascript:openwin('index_show_detail.php?xsiteid=<?=$xsiteid?>&xsiteid2=<?=$xsiteid2?>')" >
                <!--<img src="../images/print-on.jpg" width="25" height="25" border="0" align="absbottom" />-->
                </a></span>
                  <input name="del_data" type="hidden" value="" /></td>
              <td align="left" style="color:#000;font-size:14px">&nbsp;</td>
            </tr>
          </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td bgcolor="#999999"><table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td bgcolor="#DFDFDF">
         
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="10" align="center" bgcolor="#A3B2CC"><strong>รายงานสรุปข้อมูลคำร้องขอแก้ไขข้อมูลข้าราชการครูและบุคลากรทางการศึกษาที่ <span style="color:red">พิมพ์ผิด</span><br />
ข้อมูล ณ วันที่ <?

$txt_date = getDataDate($xsiteid,$db_master);
$txt_date = shortday(substr($txt_date,0,10));
echo $txt_date;
	echo "<br>";
	$sql="SELECT eduarea.secid, eduarea.secname FROM `eduarea` where  secid='$xsiteid'";
					$result_site = mysql_db_query($db_master,$sql);
					$rs_site = mysql_fetch_array($result_site);
					echo $rs_site [secname];
				  ?></strong></td>
              </tr>
            <tr>
              <td colspan="10" align="left" bgcolor="#A3B2CC"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="12%" valign="top"><a href="req_wrong_bysite.php?xsiteid2=<?=$xsiteid2?>&openform=<?=$openform?>">ย้อนกลับ</a></td>
                  <td width="47%" align="left" valign="top" bordercolor="#FFFFFF" style="border-left:1px"></td>
                  <td width="41%" rowspan="2" align="right" valign="top">                    
                    <table width="400" border="0" cellspacing="2" cellpadding="2">
        
                      <tr>
                        <td width="365" align="right"><a href="<?=$url_and_para?>&search_type_name=verify"><strong>ผ่านการคัดกรองจาก Call Center </strong></a>&nbsp;</td>
                        <td width="43" align="center"><?=$arr_exsum[verify]?></td>
                        <td width="78">รายการ</td>
                      </tr>
                      <tr>
                        <td align="right"><a href="<?=$url_and_para?>&search_type_name=assign"><strong>Assign</strong></a>&nbsp;</td>
                        <td align="center"><?=$arr_exsum[assign]?></td>
                        <td>รายการ</td>
                      </tr>
                      <tr>
                        <td align="right"><a href="<?=$url_and_para?>&search_type_name=approvekeyin"><strong>Approved Key In </strong></a>&nbsp;</td>
                        <td align="center"><?=$arr_exsum[approvekeyin]?></td>
                        <td>รายการ</td>
                      </tr>
                      <tr>
                        <td align="right"><a href="<?=$url_and_para?>&search_type_name=approvecallcenter"><strong>Approved Call Center</strong></a>&nbsp;</td>
                        <td align="center"><?=$arr_exsum[approvecallcenter]?></td>
                        <td>รายการ</td>
                      </tr>

                  <tr>
                        <td width="365" align="right"><a href="<?=$url_and_para?>&search_type_name="><strong>รวม</strong></a>&nbsp;</td>
                        <td width="43" align="center"><?=array_sum($arr_exsum)?></td>
                        <td width="78">รายการ</td>
                      </tr>              
                    </table></td>
                  </tr>
                <tr>
                  <td colspan="2" valign="bottom"><table width="99%" border="0" cellspacing="1" cellpadding="5" style="background-color:#CCCCCC">
                    <tr>
                      <td style="background-color:#A3B2CC"><?php
					if($search_type_name != ""){
						echo "ข้อมูลสถานะ \"<strong>".getStatusName($search_type_name)."</strong>\"";
						$sql_approve_show = "SELECT * FROM req_type_keyapprove WHERE runid='$key_approve'";
						$res_approve_show = mysql_db_query($db_master,$sql_approve_show);
						$row_approve_show = mysql_fetch_assoc($res_approve_show);
						echo $row_approve_show[type_key_approve] != "" ? " และ <strong>".$row_approve_show[type_key_approve]."</strong>" : "";
					} else {
						echo "<strong>ข้อมูลทั้งหมด</strong>";
					}
					
					if($problem_group != ""){
						$gb_sql="SELECT * FROM req_problem_group where  runno='$problem_group'";
						$gb_result= mysql_db_query($db_master,$gb_sql);
						$gb_rs = mysql_fetch_array($gb_result);
						echo "<br>หมวดรายการ : <strong>".$gb_rs[problem_name]."</strong>";					
					}
										
					$label_search_result_title = "เงื่อนไขการค้นหา : ";
					$label_search_result = "";
					if($_POST[text_search] != ""){
						$label_search_result .= " คำค้นหา  = <strong>".$_POST[text_search]."</strong><br>";
					}
					
					if($_POST[dstart] != "" && $_POST[dstop] != ""){
						$label_search_result .= "วันที่  <strong>".$_POST[dstart]."</strong> ถึง  <strong>".$_POST[dstop]."</strong><br>";
					}
					if($label_search_result != ""){
						echo "<br><br>".$label_search_result_title."<br>".$label_search_result;
					}
					?></td>
                      </tr>
                  </table></td>
                  </tr>
                
              </table></td>
            </tr>            
            
<?php
if($reqstatus!=""){
	$xcond.=" and  req_problem_person.req_status='$reqstatus'";
 } 	
	
$rows_perpage=20;
$siteid = $xsiteid;
### where สถานะ
$where_status = getWhereStatus($search_type_name);
$where = "";
$where_problem_group="";
$where_keyapprove="";
if($_POST[text_search] != ""){
	$where .= " AND (problem_caption LIKE('%".$_POST[text_search]."%') OR problem_detail LIKE('%".$_POST[text_search]."%') OR fullname LIKE('%".$_POST[text_search]."%') OR prename LIKE('%".$_POST[text_search]."%') OR staffname LIKE('%".$_POST[text_search]."%') OR staffsurname LIKE('%".$_POST[text_search]."%') OR req_triget = '".$_POST[text_search]."')";
}
if($dstart != "" && $dstop != ""){
	$d1 = swapengdate($dstart);
	$d2 = swapengdate($dstop);
	$where .= " AND req_problem.req_date BETWEEN '$d1 00:00:00' AND '$d2 23:59:59'";
}
if($key_approve != ""){
	$where_keyapprove = "AND status_key_approve='$key_approve'";
}
?>			
          
            <tr>
              <td colspan="10" align="left" bgcolor="#CCCCCC">
			  <form id="form2" name="form2" method="post" action="" >
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  
                  <tr>
                    <td width="6%"><img style="display:none" src="../competency_pobec_new/images/arrow_ltr.png" width="38" height="22" hspace="10" align="texttop" /></td>
                    <td width="15%"><a href="javascript:del()" style="display:none" >ลบข้อมูล</a></td>
                    <td width="79%" align="right" >
					<?php
					
/*	$sql_keyapp = "SELECT 
					COUNT(req_temp_wrongdata.req_person_id) AS nnum 
				FROM req_temp_wrongdata 
					INNER JOIN req_problem_person ON req_temp_wrongdata.req_person_id = req_problem_person.req_person_id
					INNER JOIN req_problem ON req_temp_wrongdata.req_person_id = req_problem.req_person_id
					LEFT JOIN req_problem_group ON req_problem.problem_group = req_problem_group.runno
					INNER JOIN view_general ON req_problem_person.idcard = view_general.CZ_ID  
					LEFT JOIN ".DB_USERENTRY.".tbl_assign_edit_key ON tbl_assign_edit_key.idcard = req_problem_person.idcard
					INNER JOIN ".DB_USERENTRY.".tbl_assign_edit_sub ON  tbl_assign_edit_key.ticketid = tbl_assign_edit_sub.ticketid
					LEFT JOIN ".DB_USERENTRY.".keystaff ON keystaff.staffid = tbl_assign_edit_sub.staffid		
				WHERE req_temp_wrongdata.problem_type=1
					AND view_general.siteid = '$siteid'
					$where_status
					$where
					$where_problem
				";*/
					
						if($search_type_name == "approvekeyin"){
							$sql_approve = "SELECT * FROM req_type_keyapprove";
							$res_approve = mysql_db_query($db_master,$sql_approve);
							
							while($row_approve = mysql_fetch_assoc($res_approve)){
								### begin get count
								$where_keyapprove_temp = "AND status_key_approve='$row_approve[runid]'";
								$key_approve_count = getCountKeyApprove($where_status,$where,$where_problem,$where_keyapprove_temp,$siteid);								
								//$res_keyapp = mysql_db_query($dbsite,$sql_keyapp);
								//$row_keyapp = mysql_fetch_assoc($res_keyapp);
								###
								if($key_approve == $row_approve[runid]){
									$ahref .= " | <a href='".$url_and_para."&key_approve=".$row_approve[runid]."&search_type_name=".$search_type_name."'><strong>".$row_approve[type_key_approve]."(".$key_approve_count.")"."</strong></a>";
								} else {
									$ahref .= " | <a href='".$url_and_para."&key_approve=".$row_approve[runid]."&search_type_name=".$search_type_name."'>".$row_approve[type_key_approve]."(".$key_approve_count.")"."</a>";
								}
							}
							$ahref = substr($ahref,2);
							echo $ahref;
						}
					?></td>
                  </tr>
                </table>

  <table width="100%" border="0" cellpadding="0" cellspacing="1" id="my_table"> 
    <thead>  
                  <tr  height="20px">
                    <th width="2%" align="center" bgcolor="#A3B2CC" style="display:none" ><input type="checkbox" name="xall" id="xall" onclick="chkall(this.checked)"/></th>
              <th width="3%" align="center" bgcolor="#A3B2CC" class="head_label"><strong>ลำดับ</strong></th>
              <th width="15%" align="center" bgcolor="#A3B2CC" class="head_label"><strong>เลขที่คำร้อง</strong></th>
              <th width="11%" align="center" bgcolor="#A3B2CC" class="head_label"><strong>วันที่แจ้ง</strong></th>
              <th width="16%" align="center" bgcolor="#A3B2CC" id="detail" class="head_label" ><strong>หัวข้อปัญหา</strong></th>
              <th align="center" bgcolor="#A3B2CC"  class="head_label" id="detail">หมายเลข<br />รายการที่ผิด</th>
              <th align="center" bgcolor="#A3B2CC"  class="head_label" id="detail">รายละเอียดปัญหา</th>
              <th width="13%" align="center" bgcolor="#A3B2CC"  class="head_label" id="detail">เจ้าของคำร้อง</th>
                  <th width="15%" align="center" bgcolor="#A3B2CC"  class="head_label" id="detail">ผู้แก้ไขคำร้อง</th>
                  </tr>
               </thead>
               <tbody>
           <?	


$sql = "SELECT 
				COUNT(req_temp_wrongdata.req_person_id) AS nnum 
			FROM req_temp_wrongdata 
				INNER JOIN req_problem_person ON req_temp_wrongdata.req_person_id = req_problem_person.req_person_id
				INNER JOIN req_problem ON req_temp_wrongdata.req_person_id = req_problem.req_person_id
				LEFT JOIN req_problem_group ON req_problem.problem_group = req_problem_group.runno
				INNER JOIN view_general ON req_problem_person.idcard = view_general.CZ_ID  
				LEFT JOIN ".DB_USERENTRY.".tbl_assign_edit_key ON tbl_assign_edit_key.idcard = req_problem_person.idcard
				INNER JOIN ".DB_USERENTRY.".tbl_assign_edit_sub ON  tbl_assign_edit_key.ticketid = tbl_assign_edit_sub.ticketid
				LEFT JOIN ".DB_USERENTRY.".keystaff ON keystaff.staffid = tbl_assign_edit_sub.staffid		
			WHERE req_temp_wrongdata.problem_type=1
				AND view_general.siteid = '$siteid'
				$where_status
				$where
				$where_problem
				$where_keyapprove
			";

	$rs=mysql_db_query($db_master, $sql);
	$row=mysql_fetch_array($rs);
	$totalrow =$row[nnum]; 
	$pagesize = $rows_perpage;  // แสดงจำนวนกระทู้ในแต่ละหน้า ในที่นี้จะแสดง 2 กระทู้ เพื่อทดสอบ
	$totalpage = (int)($totalrow/$pagesize); 
	if(($totalrow%$pagesize)!=0){
	$totalpage += 1;
} 
// หา record แรกที่จะแสดงของแต่ละหน้า
if(isset($page)){
$pageno = $page;
$start = $pagesize*($pageno-1);
}else{
$pageno = 1;
$start = 0;
}


if($showAll==""){
$limit=" limit $start,$rows_perpage";
}	

$sql = "SELECT * ,
				tbl_assign_edit_key.fullname
			FROM req_temp_wrongdata 
				INNER JOIN req_problem_person ON req_temp_wrongdata.req_person_id = req_problem_person.req_person_id
				INNER JOIN req_problem ON req_temp_wrongdata.req_person_id = req_problem.req_person_id
				LEFT JOIN req_problem_group ON req_problem.problem_group = req_problem_group.runno
				LEFT  JOIN req_problem_groupno ON req_problem_groupno.runid = req_problem.problem_groupno
				INNER JOIN view_general ON req_problem_person.idcard = view_general.CZ_ID  
				LEFT JOIN ".DB_USERENTRY.".tbl_assign_edit_key ON tbl_assign_edit_key.idcard = req_problem_person.idcard
				INNER JOIN ".DB_USERENTRY.".tbl_assign_edit_sub ON  tbl_assign_edit_key.ticketid = tbl_assign_edit_sub.ticketid
				LEFT JOIN ".DB_USERENTRY.".keystaff ON keystaff.staffid = tbl_assign_edit_sub.staffid
			WHERE 
				req_temp_wrongdata.problem_type=1
				AND view_general.siteid = '$siteid'
				$where_status
				$where
				$where_problem
				$where_keyapprove
				$limit
		";
//echo "<pre>";
//echo $sql;
//exit;
if($debug=="1"){echo $sql;}
				$result = mysql_db_query($db_master,$sql);
				$i=0;
				//$totalrow=0;
				while($rs = mysql_fetch_assoc($result)){
					$TicketID = $rs[req_triget];
						
					if ($i % 2) {$bg = "#FFFFFF";}else{$bg = "#F0F0F0";}$i++;
					$req_date=substr($rs[req_date],0,10);
					$idex = ($pageno-1)*$pagesize + $i ;
			?>
            <tr bgcolor="<?=$bg?>">
              <td align="center" style="display:none" >
                <input type="checkbox" name="chkdel" id="checkbox" value="<?=$rs[req_person_id]?>" />              </td>
              <td align="center"><?=$idex?></td>
              <td align="left"><a href="req_wrong_approve.php?xidcard=<?=$rs[idcard]?>&id_req=<?=$rs[req_person_id]?>&key_approve=<?=$key_approve?>" target="_blank"><? echo "$TicketID"?></a></td>
              <td align="center" ><?=shortday($req_date)?></td>
              <td align="left" id="detail"><?=$rs[problem_caption]?></td>
              <td align="left" id="detail"><?=$rs[no_caption]?></td>
              <td align="left" id="detail"><?=$rs[problem_detail]?></td>
              <td align="left" id="detail"><?=$rs[fullname] != "" ? $rs[fullname] : "N/A"?></td>
              <td align="left" id="detail"><?=$rs[prename].$rs[staffname]." ".$rs[staffsurname]?></td>
            </tr>
            <?
				$sum_1 += $arr_req[$rs[siteid]]['1'];
				$sum_2 += $arr_req[$rs[siteid]]['2'];
				$sum_3 += $arr_req[$rs[siteid]]['3'];
				}//end 	while($rs = mysql_fetch_assoc($result)){
			?>
			<?php
				if($i == 0){
					echo "<tr><td colspan='6' align='center' style='background-color:#FFFFFF'>--- ไม่มีข้อมูลคำร้อง ---</td></tr>";
				}
			?>
            </tbody>
              </table>
</form ></td>
              </tr>
          
              <td  align="left"  colspan="9"><label>
                  <!--                <input type="submit" name="button" id="button" value="บันทึกข้อมูล" />-->
                  <?
				  $get = "&key_approve=".$key_approve."&search_type_name=".$search_type_name;
              if($pageno >1){
echo " <b class='textpage'><a href='?xsiteid2=$xsiteid2&dstart=$dstart&dstop=$dstop&openform=$openform&checkbox_1=$checkbox_1&checkbox_2=$checkbox_2&reqstatus=$reqstatus&xsiteid=$xsiteid&text_search=$text_search&".$get."&page=".($pageno-1)."'>Previous</a></b> |";
} 
for($i=1;$i<=$totalpage;$i++){
if($pageno==$i){
echo" <b class='textpage'>".$i."</b>|";
}else{
echo "<b class='textpage'> <a href='?xsiteid2=$xsiteid2&dstart=$dstart&dstop=$dstop&openform=$openform&checkbox_1=$checkbox_1&checkbox_2=$checkbox_2&reqstatus=$reqstatus&xsiteid=$xsiteid&text_search=$text_search&".$get."&page=$i'>$i</a> </b>|";
}
}
if($pageno<$totalpage){
echo "<b class='textpage'><a href='?xsiteid2=$xsiteid2&dstart=$dstart&dstop=$dstop&openform=$openform&checkbox_1=$checkbox_1&checkbox_2=$checkbox_2&reqstatus=$reqstatus&xsiteid=$xsiteid&text_search=$text_search&".$get."&page=".($pageno+1)."'>Next</a></b>";
}
echo "|<b class='textpage'><a href='?xsiteid2=$xsiteid2&dstart=$dstart&dstop=$dstop&openform=$openform&checkbox_1=$checkbox_1&checkbox_2=$checkbox_2&reqstatus=$reqstatus&xsiteid=$xsiteid&text_search=$text_search&showAll=All".$get."'>All</a></b>";
			  ?>
              </label></td>
              <td width="5%" align="right" nowrap="nowrap"><?=number_format($totalrow)." รายการ"?></td>
            </tr>
          </table>
         
          </td>
        </tr>
      </table></td>
    </tr>
  </table>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr>
    <td width="68%" align="left" style="font-size:12px"><span class="red">*<strong>คำค้น</strong> - สามารถค้นหา เลขที่คำร้อง หัวข้อปัญหา รายละเอียดปัญหา เจ้าของคำร้อง และผู้แก้ไขคำร้อง</span><br />
    <?
//    foreach($arratatus as $index=>$values){
//		
//		if($values[icon]!=""){
//			echo $values[icon]."= ".$values[caption];
//		}else{
//		  echo " ".$values[caption];
//		 }
//	
//	}
	?></td>
    <td width="32%" align="right" valign="top" style="font-size:12px">รายงาน ณ.วันที่
      <?
    $d=date('d');
	$m=$monthname[(date('m')*1)];
	$y=date('Y')+543;
	echo"$d  $m $y ";
	
//echo "<pre>";
//echo $sql;
	
	?></td>
  </tr>
</table>
</body>
</html>
