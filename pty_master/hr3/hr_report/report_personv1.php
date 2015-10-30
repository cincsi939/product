<?php
session_start();
#START 
###### This Program is copyright Sapphire Research and Development co.,ltd ########
$ApplicationName	= "hr_report";
$module_code 		= "report_person"; 
$process_id			= "report_person";
$VERSION 				= "1";
$BypassAPP 			= true;

//$_SESSION[secid];
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20091222.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-12-22 15:15
	## Created By :		Mr.Suwat Khamtum
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20091222.001
	## Modified Detail :		ระบบรายงานข้อมูลประวัติการรับราชการ
	## Modified Date :		2009-12-22 15:15
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################


include ("../libary/function.php");
include("../../../common/common_competency.inc.php");
include ("../../../config/phpconfig.php");
include ("timefunc.inc.php");

## function  ตัดคำจากตำแหน่งที่ต้องการ
function CutWord($string1,$needle){
	  $needle_len = strlen($needle);
	  $position_num = strpos($string1,$needle) + $needle_len;
	  $result_string = substr("$string1",$position_num);
	  return "$result_string";  
}


function cut_stringschool($text){ 
 //return  array index
 #  4   สำนักงานเขตพื้นที่การศึกษา
 #  3   สำนักงานประถมศึกษาจังหวัด
 #  2   สำนักงานประถมศึกษาอำเภอ
 #  1   โรงเรียน
 #  0   ตำแหน่ง
    
    
  $arr['4']=array('สพท.','สพท','ส พ ท','สำนักงานเขตพื้นที่การศึกษา'); 
  $arr['3']=array('สปจ.','สปจ','ส ป จ','สำนักงานประถมศึกษาจังหวัด'); 
  $arr['2']=array('สปอ.','สปอ','ส ป อ','สำนักงานประถมศึกษาอำเภอ'); 
  $arr['1']=array('ร.ร.','ร.ร','ร ร','รร.','รร','โรงเรียน'); 
 
  $arrcut=array('','(');    
  foreach($arr as $index=>$value){
     $xsearch=false; 
     $pos=false;           
      foreach($value as $subindex=>$subvalue){
           $pos=strpos($text,$subvalue, 1); 
               if($pos===false){         
               }else{
                   $xindex++;                
                     $name=substr($text,($pos+strlen($subvalue)),strlen($text)); 
                     $label=substr($text,$pos,strlen($text));
                     $text=substr($text,0,$pos);
                         // ตัดตัวอักษร
                         $cutpos=false;
                         foreach($arrcut as $cutindex=>$cutstring){
                            $cutpos=strpos($label,$cutstring, 1); 
                               if($cutpos===false){
                               }else{ 
                                   $label=substr($label,0,$cutpos);
                                   $cutpos=strpos($name,$cutstring, 1); 
                                   if($cutpos===false){}else{  
                                     $name=substr($name,0,$cutpos);  
                                   } 
                                       
                               }
                         } 
                        //                       
                       $reval[$index]['name']=$name;  
                       $reval[$index]['label']=$label; 
                 break;
               }
      }
      $reval['0']['name']=$text;  
      $reval['0']['label']=$text;
                    
   }
  
   ksort($reval);  
   return  $reval;   
}


## function  ฟังก์ชั่นแสดงตำแหน่ง
function ShowPosition($get_positionid){
	global $dbnamemaster;
	$sql = "SELECT position FROM hr_addposition_now WHERE pid='$get_positionid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[position];
}//end function ShowPosition(){

##  function แสดงระดับ
function ShowRadub($get_radubid){
	global $dbnamemaster;
	$sql = "SELECT radub FROM hr_addradub WHERE level_id='$get_radubid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[radub];
}// end function ShowRadub(){
	
##  function ตรวจสอบ order_type ที่ใช้สำหรับตรวจสอบประวัติการรับราชการ
function CheckOrderType($get_order_type){
	global $dbnamemaster;
	$sql = "SELECT COUNT(id) AS numCheck FROM hr_order_type WHERE active_history ='1' AND id='$get_order_type'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[numCheck];
}
	
	
if($_SESSION['secid'] != "" and $_SESSION['secid'] != "pty_master"){
	$db_name = STR_PREFIX_DB.$_SESSION['secid'];	
}else if($_SESSION['temp_dbsite'] != ""){
	$db_name = $_SESSION['temp_dbsite'];
}else if($xsiteid != "" and $xsiteid != "pty_master"){
	$db_name = STR_PREFIX_DB.$xsiteid;
}else{
				echo "
					<script language=\"javascript\">
							alert(\"ไม่สามารถเชื่อมต่อฐานข้อมูลได้ กรุณาตรวจสอบอีกครั้ง\");
							top.location.href=\"$mainwebsite\";
					</script>";
			exit;
}//end if($_SESSION['secid'] != "" and $_SESSION['secid'] != "pty_master"){
	
	
	
##  ข้อมูลทั่วไป
$sql_general = "SELECT id,idcard,siteid,prename_th,name_th,surname_th,position_now FROM general WHERE id='$id'";
$result_general = mysql_db_query($db_name,$sql_general);
$rsv = mysql_fetch_assoc($result_general);

$sql_salary = "SELECT max(date) as maxdate FROM salary WHERE id='".$id."'";
$result_salary = mysql_db_query($db_name,$sql_salary);
$rs_salary = mysql_fetch_assoc($result_salary);



?>
<html>
<head>

<title>ประวัติการรับราชการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="hr.css" type="text/css" rel="stylesheet">

<style type="text/css">
<!--
body {
	margin: 0px  0px;
	padding: 0px  0px;
	margin-top: 5px;
	margin-bottom: 5px;
}
a.pp:link, a.pp:visited, a.pp:active { color: #444444;	
	font-weight:normal;
	text-decoration: none}
a.pp:hover {
	text-decoration: underline;
	color: #444444;
}
.sub_head_td{
border-bottom:#5595CC 1px solid; 
border-top:#5595CC 1px solid;
height:25px;
padding-left:10px;
filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#F4F4F4', EndColorStr='#F4F4F4'); 

}
.style1 {border-bottom: #5595CC 1px solid; border-top: #5595CC 1px solid; height: 25px; padding-left: 10px; font-weight: bold; }

-->
</style></head>
<body>

<table width="98%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4" align="center" style="border:1px solid #DADAE1;">
  <tr>
    <td height="35" align="left"  style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#ffffff', EndColorStr='#F4F4F4'); padding: 2px">&nbsp;</td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="2" align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
      <tr>
        <td width="14%" height="515" valign="top"><?
						$sql_showpic="select yy,imgname from general_pic where id='$id' and kp7_active='1' order by no  DESC ";
						
						$query=mysql_db_query($db_name,$sql_showpic)or die("cannot query".mysql_error());
						$num=mysql_num_rows($query);
						
						if($num==0)
						{
						//$img="<img src=\"../images/personnel/noimage.jpg\">";
						$img="<img src=\"../../../images_sys/noimage.jpg\">";
						
						?>
          <table width="123" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#000000">
            <tr>
              <td  align="center" bgcolor="#F4F4F4" style="border:1px #5595CC solid;padding:2px;"><?=$img?></td>
            </tr>
          </table>
          <? }
						else
						{
					$j=0;	
					while($rp=mysql_fetch_assoc($query))
					{
						//$img="<img src=\"images/personal/$rp[imgname]\" width=120 height=160 >";
						$img = "<img src=\"../../../../edubkk_image_file/$rsv[siteid]/$rp[imgname]\" width=120 height=160 >";
						?>
          <table width="123" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#000000">
            <tr>
              <td align="center" bgcolor="#F4F4F4" style="border:1px #5595CC solid; padding:2px;"><?=$img?></td>
            </tr>
            <tr>
              <td height="25" align="center" bgcolor="#F4F4F4">ภาพ ปี พ.ศ.
                  <? if($rp[yy] >0){ echo "$rp[yy]";}else{ echo "ไม่ระบุ";}?>              </td>
            </tr>
          </table>
          <? $j++; if($j>0){break;}
						}
						
						}
						 ?></td>
        <td width="86%" valign="top">
		<table width="100%" border="0" cellspacing="1" cellpadding="2">
          <tr>
            <td class="style1" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="377"><strong>ชื่อ-นามสกุล :</strong> <? echo "$rsv[prename_th]$rsv[name_th] $rsv[surname_th]";?> </td>
                <td width="424" align="right"><strong>รหัสประจำตัวประชาชน :</strong>
                  <?=$rsv[id];?></td>
              </tr>
              <tr>
                <td width="377"><strong>ตำแหน่งปัจจุบัน :</strong>
                    <?=$rsv[position_now]?>
                </td>
                <td align="right"><strong>ข้อมูล ณ วันที่ :</strong>
                  <?=MakeDate($rs_salary['maxdate']);?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                  <tr>
                    <td colspan="4" align="left" bgcolor="#A5B2CE" class="menuitem"><strong>ประวัติการรับราชการ</strong></td>
                    </tr>
                  <tr>
                    <td width="17%" align="center" bgcolor="#A5B2CE"><strong>วัน / เดือน / ปี</strong></td>
                    <td width="31%" align="center" bgcolor="#A5B2CE"><strong>ตำแหน่ง</strong></td>
                    <td width="16%" align="center" bgcolor="#A5B2CE"><strong>ระดับ</strong></td>
                    <td width="36%" align="center" bgcolor="#A5B2CE"><strong>หน่วยงาน</strong></td>
                  </tr>
                  <?
                  	$sql = "SELECT * FROM salary WHERE id='$id' ORDER BY runno ASC";
					$result = mysql_db_query($db_name,$sql);
					$i=0;
					while($rs = mysql_fetch_assoc($result)){
					if(($rs[position_id] != $xposition_id) or ($rs[level_id] != $xlevel_id) or ($rs[order_type] != $xorder_type)){
						 if(CheckOrderType($rs[order_type]) > 0 ){
						 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	  
				  ?>
                  <tr bgcolor="<?=$bg?>">
                    <td align="left"><?=MakeDate($rs['date']);?></td>
                    <td align="left">
					<? if($rs[position_id] != "" and $rs[position_id] > 0){ echo ShowPosition($rs[position_id]);}else{ echo "$rs[position]";}?>
                    </td>
                    <td align="center">
                    <? if($rs[level_id] != "" and $rs[level_id] > 0){ echo ShowRadub($rs[level_id]);}else{ echo "$rs[radub]";}?>
                    </td>
                    <td align="left"><? 	
					
/*					$arr1 = cut_stringschool($rs[pls]);
					echo "<pre>";
					print_r($arr1);*/
					$xpos1 = strpos($rs[pls],"ร.ร");
					$xpos2 = strpos($rs[pls],"ร.ร.");
					$xpos3 = strpos($rs[pls],"โรงเรียน");
					$xpos_temp = strpos($rs[pls],"รักษาการ");
					
					if($xpos_temp === false){
					
							if(!($xpos2 === false)){
								echo  "โรงเรียน".CutWord($rs[pls],"ร.ร.");
							}else if(!($xpos1 === false)){
								echo "โรงเรียน".CutWord($rs[pls],"ร.ร");
							}else if(!($xpos3 === false)){
								echo  "โรงเรียน".CutWord($rs[pls],"โรงเรียน");
							}else{
								echo $rs[pls];	
							}
					}else{
						echo $rs[pls];
					}
					?></td>
                  </tr>
                  <?	
						}//end   if(CheckOrderType($rs[order_type] > 0 ){
				  		$xposition_id = $rs[position_id];
						$xlevel_id = $rs[level_id];
						$xorder_type = $rs[xorder_type];
				  		}//end   if($rs[position_id] != ){
					}//end while($rs = mysql_fetch_assoc($result)){
				  ?>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>
		</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>

