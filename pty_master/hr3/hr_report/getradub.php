<?php   
header("Content-Type: text/plain; charset=windows-874");    
session_start();

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
//����������ǡѺ�ҹ�����ŷ����
include ("../../../config/config_hr.inc.php")  ; 
include ("../../../common/function_position.php")  ; 

$tempChk=chkDateCompair(DD_CHPOSITION,MM_CHPOSITION,YY_CHPOSITION,$xday,$xmonth,$xyear);
if($tempChk=='1'){
		if(substr($postname,0,1)!='5'  &&  substr($postname,0,1)!='6'){
				$xcond=" and hr_addradub.active_now=1";
		}
}

$sql="SELECT  distinct 
hr_addradub.radub as value,
hr_addradub.level_id  as id
FROM
position_math_radub
Inner Join hr_addposition_now ON hr_addposition_now.runid = position_math_radub.position_id
Inner Join hr_addradub ON position_math_radub.radub_id = hr_addradub.runid 
where hr_addposition_now.`pid`='$postname'  $xcond order by hr_addradub.level_id";

 $select1  = mysql_db_query($dbnamemaster,$sql);  
 //echo $sql;
 echo" <select name=\"hr_addradub\"  id='hr_addradub' onChange=\"getvitaya(this.value);\"  onblur=\"onobjChange();\"   style=\"width:154px;\">";
 echo " <option value=\"\" class=\"warn\">����к�</option> ";
 
 while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC)){ 
   if($idsel==$rselect1[value]){$sel="selected";}
  echo"<option $sel  value=\"$rselect1[id]\" >$rselect1[value]</option>";
  $sel="";
 }
 echo"</select> ";
?>