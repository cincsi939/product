<?php
session_start();
header("content-type:text/xml;charset=UTF-8;");
echo '<?xml version="1.0" encoding="UTF-8" ?>';
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
include("../../../common/justify.inc.php");

include ("../../../config/phpconfig.php");
include ("timefunc.inc.php");
$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$shortmonth = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	
		
$arrdate = array();
$arrdate['01'] =  "มกราคม";
$arrdate['02'] =  "กุมภาพันธ์";
$arrdate['03'] =  "มีนาคม";
$arrdate['04'] =  "เมษายน";
$arrdate['05'] =  "พฤษภาคม";
$arrdate['06'] =  "มิถุนายน";
$arrdate['07'] =  "กรกฎาคม";
$arrdate['08'] =  "สิงหาคม";
$arrdate['09'] =  "กันยายน";
$arrdate['10'] =  "ตุลาคม";
$arrdate['11'] =  "พฤศจิกายน";
$arrdate['12'] =  "ธันวาคม";
if($_SESSION['secid'] != "" and $_SESSION['secid'] != DB_MASTER){
	$db_name = STR_PREFIX_DB.$_SESSION['secid'];	
}else if($_SESSION['temp_dbsite'] != ""){
	$db_name = $_SESSION['temp_dbsite'];
}else if($_GET['xsiteid'] != "" and $xsiteid != DB_MASTER){
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
$sql_general = "SELECT id,idcard,siteid,prename_th,name_th,surname_th,position_now,prename_en,name_en,surname_en,birthday,contact_add,radub,level_id,begindate,schoolid,noposition,education FROM general WHERE id='$id'";
$result_general = mysql_db_query($db_name,$sql_general);
$rsv = mysql_fetch_assoc($result_general);

$sql_salary = "SELECT max(date) as maxdate FROM salary WHERE id='".$id."'";
$result_salary = mysql_db_query($db_name,$sql_salary);
$rs_salary = mysql_fetch_assoc($result_salary);

 function subspace($str){
 
	$str = implode('',explode("  ",$str));

		$strspace = str_replace("\r\n"," ",$str);
		$strspace = str_replace("\n\r"," ",$strspace);
		$strspace = str_replace("\r"," ",$strspace);
		$strspace = str_replace("\n"," ",$strspace);
		$strspace = str_replace("( ","(",$strspace);
		$strspace = str_replace(" )",")",$strspace);
		//$strspace = subspace($strspace);
		return $strspace;
	
}

function showyear($yy){
	$a = explode('-',$yy);
	return intval($a[0]);
}
	
function utf($str){
	return iconv('TIS-620','UTF-8',$str);	
}
	
?>

<?
echo "<dataset>";

$sql = "SELECT * FROM salary WHERE id='$id' ORDER BY date DESC";
$result = mysql_db_query($db_name,$sql);
$nms = mysql_num_rows($result );

$i=0;
$ii=0;
while($rs = mysql_fetch_assoc($result)){
$ii++;
if(($rs[position_id] != $xposition_id) or ($rs[level_id] != $xlevel_id) or ($rs[order_type] != $xorder_type)){
	 if(CheckOrderType($rs[order_type]) > 0 ){
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	  
	
	##########  label เลขที่ตำแหน่ง
	if($rs[label_noposition] != "" and $rs[label_noposition] != NULL){
			$show_noposition = $rs[label_noposition];
	}else{
			$show_noposition = $rs[noposition];
	}

if($rs[noorder]=="#"){
	$noo="";
}else{	
	$noo=$rs[noorder];
}


if($rs[label_dateorder] !=""){
	$dateorder=$rs[label_dateorder];
}else{
	$dateorderX=MakeDate2($rs[dateorder]);
	$DO=explode(" ",$dateorderX);
	if($DO[0]==0){$dot="";}else{$dot=$DO[0];}
	$dateorder=$dot.$DO[1].$DO[2];
}


if($rs[instruct]=="#"){
	$rinstruct="";
}else	{
	$rinstruct=$rs[instruct];
}

if(showyear($rs['date'])<>$oyear){
	if($i>1){
		echo 	"</data>";
	}
		
$oyear = showyear($rs['date']);
echo "<data title='".showyear($rs['date'])."'>";
}

?>
<positions>
  <date><? $dsx = explode("-",$rs['date']); echo intval($dsx[2]).' '.$arrdate[$dsx[1]].' '.$dsx[0].''; ?></date>
  <position>
    <? if($rs[position_id] != "" and $rs[position_id] > 0){ echo utf(ShowPosition($rs[position_id]));}else{ echo utf($rs[position]);}?>
    </position>
  <posnumber><?=utf($show_noposition)?></posnumber>
  <radab>
    <? if($rs[level_id] != "" and $rs[level_id] > 0){ echo utf(ShowRadub($rs[level_id]));}else{ echo utf($rs[radub]);}?>
    </radab>
  <refer><?=utf($noo)." ".utf($rinstruct);?> <?=utf($dateorder);?></refer>
  <place>
<? 	
$plsx = subspace($rs['pls']);


$xpos1 = strpos($plsx,"ร.ร");
$xpos2 = strpos($plsx,"ร.ร.");
$xpos3 = strpos($plsx,"โรงเรียน");
$xpos_temp = strpos(plsx,"รักษาการ");
$xpos4 = strpos($plsx,"รร.");
$xpos5 = strpos($plsx,"รร");

if(($xpos_temp === false)){

        if(!($xpos2 === false)){
            echo  "โรงเรียน".CutWord($plsx,"ร.ร.");
        }else if(!($xpos1 === false)){
            echo "โรงเรียน".CutWord($plsx,"ร.ร");
        }else if(!($xpos3 === false)){
            echo  "โรงเรียน".CutWord($plsx,"โรงเรียน");
        }else if(!($xpos4 === false)){
            echo "โรงเรียน".CutWord($plsx,"รร.");
        }else if(!($xpos5 === false)){
            echo "โรงเรียน".CutWord($plsx,"รร");
        }else{
            echo utf($plsx);	
        }
}else{
    echo utf($plsx);
}
?></place>

</positions>
<?	
//echo $ii;
if($ii==($nms-2)){
//echo "</data>";
}


    }//end   if(CheckOrderType($rs[order_type] > 0 ){
    $xposition_id = $rs[position_id];
    $xlevel_id = $rs[level_id];
    $xorder_type = $rs[xorder_type];
    }//end   if($rs[position_id] != ){
}//end while($rs = mysql_fetch_assoc($result)){
    
    if($i>0){

	echo "</data>";
	}else{
	echo "<data/>";
	}

echo "</dataset>";
?>
                 

