<?
header("Content-Type: text/html; charset=windows-874");  
session_start();
if($_SESSION[session_staffid]==""){
  echo"คุณยังไม่ได้เข้าสู่ระบบ กรุณากลับไปเข้าสู่ระบบ";
 // header("Location: ../../userentry/login.php");
 // echo'<META HTTP-EQUIV="Refresh" CONTENT="2;URL="../../userentry/login.php">'; 
  die();
}


include("../../config/conndb_nonsession.inc.php");
include ("../../common/common_competency.inc.php") ;
include("function.php");
$db_master="edubkk_master";

$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
function getDataDate($siteid,$db_master){
	//echo $siteid,$db_master;
	//exit;
	$sql = "SELECT MIN(req_date) AS dt FROM req_problem_person WHERE req_status IN(1,2) AND idcard != '' AND del <> 1";
	//echo $sql;
	//exit;

	$res = mysql_db_query($db_master,$sql);
	$row = mysql_fetch_assoc($res);
	return $row[dt];
}

function CountReq(){
	global $db_master,$openform;
	if($openform!=""){
		$xcond=" and  req_problem.problem_type=2";
	}	
$arr[1]	=" and 1=1 ";
$arr[2]	=" and (req_temp_wrongdata.status_admin_key_approve=1)";
//$arr[2]	=" and (req_problem_person.req_status=2 or req_problem_person.req_status=4 or req_problem_person.req_status=6)";
//$arr[3]	="and (req_problem_person.req_status=3 or req_problem_person.req_status=5 or req_problem_person.req_status=7) ";		
	foreach($arr as $index=>$values){
		  $sql = "SELECT
					COUNT(req_problem.req_person_id) AS nnum,
					view_general.siteid AS site
				FROM
					req_problem_person
					INNER JOIN req_problem ON  req_problem_person.req_person_id=req_problem.req_person_id
					INNER JOIN req_temp_wrongdata ON req_problem_person.req_person_id = req_temp_wrongdata.req_person_id 
					INNER JOIN view_general ON req_problem_person.idcard = view_general.CZ_ID  
					LEFT JOIN ".DB_USERENTRY.".tbl_assign_edit_key ON tbl_assign_edit_key.idcard = req_problem_person.idcard
					INNER JOIN ".DB_USERENTRY.".tbl_assign_edit_sub ON  tbl_assign_edit_key.ticketid = tbl_assign_edit_sub.ticketid
					LEFT JOIN ".DB_USERENTRY.".keystaff ON keystaff.staffid = tbl_assign_edit_sub.staffid					
					
				WHERE  
					req_problem_person.del=0  
					AND req_temp_wrongdata.problem_type=1 
					$values $xcond 
				GROUP BY 
					view_general.siteid";
//		echo "<pre>".$sql;
//		exit;
		$result = mysql_db_query($db_master,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arr1[$rs[site]][$index] = $rs[nnum];		
				
		}
	}	
	foreach($arr1 as $index=>$values){
		$arr1[$index]['all'] = $values[1]+$values[2]+$values[3];
	}
	return $arr1;
}
/*
function CountReq(){
	global $db_master,$openform;
	if($openform!=""){
		$xcond=" and  req_problem.problem_type=2";
	}	
$arr[1]	=" and (req_problem_person.req_status=1)";
$arr[2]	=" and (req_problem_person.req_status=2 or req_problem_person.req_status=4 or req_problem_person.req_status=6)";
$arr[3]	="and (req_problem_person.req_status=3 or req_problem_person.req_status=5 or req_problem_person.req_status=7) ";			
$sql = "SELECT
Sum(if(req_problem_person.req_status=1,1,0)) AS sum_req1,
Sum(if( req_problem_person.req_status=2 or req_problem_person.req_status=4 or req_problem_person.req_status=6,1,0)) AS sum_req2,
Sum(if(req_problem_person.req_status=3 or req_problem_person.req_status=5 or req_problem_person.req_status=7,1,0)) AS sum_req3,
req_problem_person.site
FROM
req_problem_person
inner  Join req_problem ON  req_problem_person.req_person_id=req_problem.req_person_id
where  req_problem_person.del=0 $xcond
group by site";
	$result = mysql_db_query($db_master,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr1[$rs[site]]['1'] = $rs[sum_req1];
			$arr1[$rs[site]]['2'] = $rs[sum_req2];
			$arr1[$rs[site]]['3'] = $rs[sum_req3];
			$arr1[$rs[site]]['all'] = $rs[sum_req1]+$rs[sum_req2]+$rs[sum_req3];
	}
	return $arr1;
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานตรวจสอบข้อมูล</title>
</head>
<script src="../../common/jquery.js"></script>
<script>
function export_pdf(xsiteid){
var loading="<img src=\"../../../images_sys/loading19.gif\"  hspace=\"2\" border=\"0\"  />";//loading19.gif
 var url="export_pdf.php?xsiteid="+xsiteid+"&rnd="+(Math.random()*1000);	
 $('#export_'+xsiteid).empty().append(loading);
 $.post(url,'',function(data){
	 var arr=data.split(':');	
	 if(arr[0]=="ok"){
	  
	var export_link="<a href=\"javascript:export_pdf('"+xsiteid+"')\"><img src=\"../../../images_sys/pdf.gif\"  title=\"export pdf\" hspace=\"2\" border=\"0\"  /></a>"
	var dowload_link="<a href=\"javascript:dowload_pdf('"+arr[1]+"')\"><img src=\"../../../images_sys/i_attach.gif\" hspace=\"2\" border=\"0\"  title=\"dowload pdf ที่ exportล่าสุด\"  /></a>"
	$('#export_'+xsiteid).empty().append(export_link);
	$('#download_'+xsiteid).empty().append(dowload_link);
	 dowload_pdf(arr[1]);
	 }else{
	 	alert('ไม่สามารถ export pdf ได้'); 
		$("#error").empty().append(data);
	 }
 });

}
function export_pdf2(xsiteid){
var loading="<img src=\"../../../images_sys/loading19.gif\"  hspace=\"2\" border=\"0\"  />";//loading19.gif
 var url="export_pdf2.php?xsiteid="+xsiteid+"&rnd="+(Math.random()*1000);	
 $('#export2_'+xsiteid).empty().append(loading);
 $.post(url,'',function(data){
	 var arr=data.split(':');	
	 if(arr[0]=="ok"){
	  
	var export_link="<a href=\"javascript:export_pdf2('"+xsiteid+"')\"><img src=\"../../../images_sys/pdf.gif\"  title=\"export pdf\" hspace=\"2\" border=\"0\"  /></a>"
	var dowload_link="<a href=\"javascript:dowload_pdf2('"+arr[1]+"')\"><img src=\"../../../images_sys/i_attach.gif\" hspace=\"2\" border=\"0\"  title=\"dowload pdf ที่ exportล่าสุด\"  /></a>"
	$('#export2_'+xsiteid).empty().append(export_link);
	$('#download2_'+xsiteid).empty().append(dowload_link);
	 dowload_pdf2(arr[1]);
	 }else{
	 	alert('ไม่สามารถ export pdf ได้'); 
		$("#error").empty().append(data);
	 }
 });

}


function dowload_pdf(filename){
 window.open("../../../../req_export_pdf/"+filename,"download");
}
function dowload_pdf2(filename){
 window.open("../../../../req_export_pdf/sub/"+filename,"download");
}
</script>
<link href="../../common/style.css" rel="stylesheet" type="text/css" />


<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="100" background="../req_approve/images/braner/banner.jpg" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="37%" valign="top">&nbsp;</td>
        <td width="63%" height="100" valign="top">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td bgcolor="#999999"><table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td bgcolor="#DFDFDF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="6" align="center" bgcolor="#A3B2CC"><strong>รายงานสรุปการยื่นคำร้องขอแก้ไขข้อมูลข้าราชการครูและบุคลากรทางการศึกษา<br />
              ประเภท &quot;ข้อมูลที่พิมพ์ผิด&quot;<br />
			 <?php
				$txt_date = getDataDate($xsiteid,$db_master);
				$txt_date = shortday(substr($txt_date,0,10));
				//echo $txt_date;			 
			 ?>
ข้อมูล ณ. วันที่ <?=$txt_date?></strong></td>
              </tr>
            <tr>
              <td width="3%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
              <td width="16%" align="center" bgcolor="#A3B2CC"><strong>เขตพื้นที่ทางการศึกษา</strong></td>
              <td width="11%" align="center" bgcolor="#A3B2CC"><strong>แจ้งขอแก้ไขข้อมูล(รายการ)</strong></td>
              <td width="11%" align="center" bgcolor="#A3B2CC"><strong>แก้ไขข้อมูลเรียบร้อยแล้ว</strong></td>
              <td width="4%" align="center" bgcolor="#A3B2CC"><strong>รวม</strong></td>
              <td width="8%" align="center" bgcolor="#A3B2CC">&nbsp;</td>
              </tr>
            <?
			$arr_req = CountReq();
     /*       	$sql = "SELECT
eduarea.secid as siteid,
eduarea.secname
FROM
eduarea_config
Inner Join eduarea ON eduarea_config.site = eduarea.secid
WHERE
eduarea_config.group_type =  'report' and  eduarea.secid like '%$xsiteid2%'   order by secname ASC ";
*/
$sql="SELECT
eduarea.secid as siteid,
eduarea.secname,if(eduarea.orderby=1,eduarea.secid,eduarea.secname) as xorder
FROM
eduarea_config
Inner Join eduarea ON eduarea_config.site = eduarea.secid
WHERE
eduarea_config.group_type =  'report' and  eduarea.secid like '%$xsiteid2%'  order by  xorder";
				$result = mysql_db_query($db_master,$sql);
				$i=0;
				while($rs = mysql_fetch_assoc($result)){
					if ($i % 2) {$bg = "#FFFFFF";}else{$bg = "#F0F0F0";}$i++;
			?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$i?></td>
              <td align="left"><? if($arr_req[$rs[siteid]]['all'] > 0){ echo "<a href='req_wrong_detail.php?xsiteid=$rs[siteid]&xsiteid2=$xsiteid2&openform=$openform'>".$rs[secname]."</a>";}else{ echo $rs[secname];}?></td>
              <td align="center"><?=number_format($arr_req[$rs[siteid]][1]-$arr_req[$rs[siteid]][2])?></td>
              <td align="center"><?=number_format($arr_req[$rs[siteid]][2] != "" ? $arr_req[$rs[siteid]][2] : 0 ) ?></td>
              <td align="center"><? if($arr_req[$rs[siteid]][1] > 0){ echo"<a href='req_wrong_detail.php?xsiteid=$rs[siteid]&xsiteid2=$xsiteid2&openform=$openform'>".number_format($arr_req[$rs[siteid]]['1'])."</a>";}else{echo"0";}?></td>
              <td align="center"><? if($arr_req[$rs[siteid]]['all'] > 0){ echo "<a href='req_wrong_bytype.php?xsiteid=$rs[siteid]' target='_blank'>".แยกตามหมวด."</a>";}?></td>
              </tr>
            <?
				$sum_1 += $arr_req[$rs[siteid]]['1'];
				$sum_2 += $arr_req[$rs[siteid]]['2'];
				$sum_3 += $arr_req[$rs[siteid]]['3'];
				}//end 	while($rs = mysql_fetch_assoc($result)){
			?>
               <tr bgcolor="<?=$bg?>">
              <td colspan="2" align="center"><strong>รวม </strong></td>
              <td align="center"><?=number_format($sum_1+$sum_2+$sum_3);?></td>
              <td align="center">&nbsp;</td>
              <td align="center"><?=number_format($sum_1)?></td>
              <td align="center">&nbsp;</td>
              </tr>

          </table>
          <?=number_format($sum_3)?></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="1">
    <tr>
      <td width="68%" align="left" style="font-size:12px" id="error">&nbsp;</td>
      <td width="32%" align="right" style="font-size:12px">รายงาน ณ.วันที่
        <?
    $d=date('d');
	$m=$monthname[(date('m')*1)];
	$y=date('Y')+543;
	echo"$d  $m $y ";
	
	?></td>
    </tr>
  </table>
</body>
</html>
