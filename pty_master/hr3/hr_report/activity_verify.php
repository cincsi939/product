<?php
include ("session.inc.php");
session_start();
//include ("checklogin.php");
include("../../../config/config_hr.inc.php");
include "db.inc.php";
include "class.activitylog.php";
$competency_system_db = "competency_system"; 
$edubkk_master = DB_MASTER; 

?>
<html>
<head>
<title>�����Ţ���Ҫ���</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="libary/style.css" type="text/css" rel="stylesheet">
<script language="javascript" src="chk_number.js"></script>
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style4 {
	font-size: 16px;
	color: #FFFFFF;
}
-->
</style>
</head>
<body  background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom ">
<script language="javascript">
function check_input(){
	b = document.getElementById("idcard").value;
	a = document.getElementById("barcode").value;
	if(a && b){
		if(a.length<13 || b.length<13){
			alert("��سһ�͹���� Barcode ������ʺѵû�Шӵ�ǻ�ЪҪ� ���ú 13 ��ѡ");
			return false;
		}
		return true;
	}else{
		alert("��سҡ�͡���������ú");
		return false;
	}
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<?
	function todate($din){
		$darr1 = explode(" ",$din);
		$darr = explode("-",$darr1[0]);
	 return intval($darr[2])."-".intval($darr[1])."-".(intval($darr[0])+543)." [".$darr1[1]."]";
	}
	?>
    <td valign="top"><br>
<table  width="500" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td height="40" align="left"  background="../images/hr-banner.gif" bgcolor="#4752A3" class="shadetabs style4" style="background-repeat: no-repeat; background-position:right bottom ">�к���Ǩ�ͺ�����١��ͧ�͡���</td>
			</tr>
  	  </table>
	  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="normal">�к���Ǩ�ͺ�����١��ͧ�͡��� || <a href="activity_log_list.php" target="_self">��§ҹ����͡�͡������� �.�.7</a></td>
        </tr>
      </table>
	  <?
	  if ($_SERVER[REQUEST_METHOD] != "POST" ){
	  ?>
	 <form action="?" method="post" onSubmit="return check_input();">
	  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE"> 
        <tr>
          <td colspan="2" class="normal">&nbsp;</td>
        </tr>
        <tr>
          <td width="412" align="right" class="normal">���� Barcode</td>
          <td width="566">&nbsp;<input name="barcode" type="text" class="input" id="barcode" style="width:150Px" size="13" maxlength="13"></td>
        </tr>
        <tr>
          <td align="right" class="normal">���ʺѵû�Шӵ�ǻ�ЪҪ�</td>
          <td>&nbsp;<input name="idcard" type="text" class="input" id="idcard" style="width:150Px" size="13" maxlength="13"></td>
        </tr>
	     <tr>
          <td align="right" class="normal"></td>
          <td>&nbsp;<input  name="Submit" type="submit" class="input" value="��ŧ" style="height:18"></td>
        </tr>
	     <tr>
          <td colspan="2" align="right" >&nbsp;</td>
          </tr>
      </table>
	  </form>
	  <?
	  }else{
	  
############# ========================================================> Start �� Server 
$sqll = " 
SELECT  ".DB_MASTER.".area_info.area_id,  ".DB_MASTER.".area_info.area_name, ".DB_MASTER.".area_info.IP, ".DB_MASTER.".area_info.intra_ip   FROM   ".DB_MASTER.".area_info 
" ;
$resultl = mysql_query( $sqll); 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sqll <br> ".mysql_error() ."<br>"  ;   } 
while ($rsl = mysql_fetch_assoc($resultl)){
	$xareaid  = $rsl[area_id] ;
	$arr_areaname[$xareaid] = $rsl[area_name] ;
	$arr_ip_nai[$xareaid] = $rsl[intra_ip] ; 
}	######## END while ($rsl = mysql_fetch_assoc($resultl)){
$xxusername=  $db_username  ; 
$xxpassword =  $db_password ;
############# ========================================================> END �� Server 	  
	   $decode = new activity_log;
	   $code = $decode->decode($_POST[barcode],$_POST[idcard]);
	   
	 	$sql = "SELECT
						`activity_log`.`owner_name`,
						`activity_log`.`id_card`,
						`activity_log`.`owner_sername`,
						`activity_log`.`admin_name`,
						`activity_log`.`admin_sername`,
						`server_list`.`servername`,
						`server_list`.`serveraddress`,
						`activity_list`.`activity_name`,
						`activity_log`.`date`,
						`activity_log`.`temp_file`  , expire_date 
						FROM
						$competency_system_db.`activity_log`
						Inner Join $competency_system_db.`activity_list` ON `activity_log`.`activity` = `activity_list`.`activity_id`
						Inner Join $competency_system_db.`server_list` ON `server_list`.`serverid` = `activity_log`.`server_id`
						WHERE 
				    	 $competency_system_db.`activity_log`.sampling_code='$code' 			
						and $competency_system_db.`activity_log`.id_card = '$_POST[idcard]'
						LIMIT 1 
						";		
#						$competency_system_db.`activity_log`.sampling_code='$code' 			
#						$competency_system_db.`activity_log`.temp_file like '$_POST[barcode]%'  			
						
#=================================================>  @ by char 25 �.� 2551 ������� ǹ loop 㹷ء server

					 while (list ($xareaid, $now_serverip) = each($arr_ip_nai)) {
						if ($real == 1 ){ continue ;  } 
						conn($now_serverip);
						$result = mysql_db_query($competency_system_db , $sql);
						if(mysql_num_rows($result)){
							$real =1;
							$text = "�����͡��ö١��ͧ";
						}else{
							$real = 0;
							$text = "<font color='#FF0000'>�����͡������١��ͧ</font>";
						}
					} ########  while (list ($nonm, $run_siteid) = each($arr_site)) {  $site_count 	
#=================================================>  @  END by char 25 �.� 2551 ������� ǹ loop 㹷ء server

						function idc($id){
							return substr($id,0,1)."-".substr($id,1,4)."-".substr($id,5,5)."-".substr($id,10,2)."-".substr($id,12,1);
						}
						function retval($ii){
							global $real;
							if($real){
								return $ii;
							}else{
								return "N/A";
							}
						}
						$arr = mysql_fetch_assoc($result);
	  ?>
	  	 <form action="" method="get">
	  	   <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
             <tr style="height:20">
               <td colspan="2" align="left" class="normal_black"><strong>&nbsp;
                     <?=$text;?>
               </strong></td>
               <td width="80" class="normal_blue">&nbsp;</td>
             </tr>
             <tr style="height:20">
               <td width="216" align="right" class="normal_black">��Ңͧ������</td>
               <td width="167" class="normal_blue">&nbsp;&nbsp;
                   <?=retval(($arr[owner_name]." ".$arr[owner_sername]))?></td>
               <td width="80" class="normal_blue">&nbsp;&nbsp;</td>
             </tr>
             <tr style="height:20">
               <td align="right" class="normal_black">���ʺѵû�Шӵ�ǻ�ЪҪ�</td>
               <td colspan="2" class="normal_blue">&nbsp;&nbsp;
                   <?=retval(idc($arr[id_card]))?></td>
             </tr>
             <tr style="height:20">
               <td align="right" class="normal_black">��Դ�͡�����觾����</td>
               <td colspan="2" class="normal_blue">&nbsp;&nbsp;
                   <?=retval($arr[activity_name])?></td>
             </tr>
             <tr style="height:20">
               <td align="right" class="normal_black">�ѹ�������</td>
               <td colspan="2" class="normal_blue">&nbsp;&nbsp;
                   <?=retval(todate($arr[date]))?></td>
             </tr>
             <tr style="height:20">
               <td align="right" class="normal_black">�ѹ��������͡���</td>
               <td colspan="2" class="normal_blue">&nbsp; &nbsp;
                   <?=retval(todate($arr[expire_date]))?></td>
             </tr>
             <tr style="height:20">
               <td align="right" class="normal_black">�����觾����</td>
               <td colspan="2" class="normal_blue">&nbsp;&nbsp;
                   <?=retval(($arr[admin_name]." ".$arr[admin_sername]))?></td>
             </tr>
             <tr style="height:20">
               <td align="right" class="normal_black">�͡��õ鹩�Ѻ</td>
               <?
	if($real){
		  $code = explode(".",$arr[temp_file]);
	?>
               <td colspan="2" class="normal_blue">&nbsp;&nbsp;<a href="download_pdf.php?code=<?=$code[0];?>" target="_blank"><img src="../images/dtree/page.gif" border="0"></a></td>
               <?
	}else{
	?>
               <td width="37" colspan="2" class="normal_blue">&nbsp;&nbsp;N/A</td>
               <?
	}
	?>
             </tr>
             <tr style="height:20">
               <td align="right" class="normal_black">����������������</td>
               <td colspan="2" class="normal_blue">&nbsp;&nbsp;
                   <?=retval($arr[servername]." IP ".$arr[serveraddress])?></td>
             </tr>
             <tr style="height:20">
               <td align="right" class="normal_black">&nbsp;</td>
               <td colspan="2" class="normal">&nbsp;&nbsp;
                   <input name="Submit2" type="submit" class="input" value="��Ѻ˹����ѡ" style="height:18"></td>
             </tr>
           </table>
	  	 </form>
	  <?
	  }
	  ?>    </td></tr>
</table>
</body>
</html>
