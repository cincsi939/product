<?
$ApplicationName	= "diagnosticv1";
$module_code 		= "diagnosticv1"; 
$process_id			= "diagnosticv1";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20100809.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2010-08-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20100809.00
	## Modified Detail :		�к���Ǩ�ͺ�Ѻ�ͧ�����١��ͧ�ͧ������
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
session_start();
if($_SESSION[session_staffid] == ""){
	echo "<script>alert('��س� login �������к��ա����'); </script>";
	header("Location:../../../userentry/login.php");
	die;
}

set_time_limit(0);
$path_pdf = "../../../../../edubkk_kp7file/";
$imgpdf = "<img src='../../../../images_sys/gnome-mime-application-pdf.png' alt='���� �.�.7 �鹩�Ѻ' width='20' height='21' border='0'>";	

include ("../../../../config/conndb_nonsession.inc.php")  ;
include("../../../../common/common_competency.inc.php");
include('function_checkdata.inc.php') ;
$time_start = getmicrotime();

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	if($Aaction == "Save"){		

		$arr_field = GetFieldComment(); // filed comment
		if(count($err_data) > 0){
				foreach($err_data as $key => $val){
					
						$pos = strpos($val,"!wraning");
						if(!($pos === false)){ //  �� wranning �ӡ�úѹ�֡�����š�Ѻ��ѧ checklist
					
						$sub_key = substr($key,0,1);
						$field_comment = $arr_field[$sub_key]; // ��Ŵ�����㹡�� update
						$value_update = trim(str_replace("!wraning","",$val));
							UpdateChecklistWarning("$field_comment","$idcard","$profile_id","$value_update");// update ��Ѻ价�� checklist
							
						//if($i == "3"){ break;}
						}// end 	if(!($pos === false)){ 
						

				}//end 	foreach($err_data as $key => $val){
				
		}//end if(count($err_data) > 0){
			
			$sql_key = "SELECT * FROM tbl_assign_key WHERE idcard='$idcard' AND siteid='$xsiteid' ";
			$result_key = mysql_db_query($dbnameuse,$sql_key) or die(mysql_error()."$sql_key<br>LINE::".__LINE__);
			$rsk = mysql_fetch_assoc($result_key);
			if($supervisor_approve == "1"){
					$con_approve = ", approve='2',supervisor_approve='1'";
			}else if($supervisor_approve == "0" and $rsk[approve] != "2"){
					$con_approve = ", approve='1',supervisor_approve='0' ";
			}else{
					$con_approve = ", approve='2',supervisor_approve='$supervisor_approve' ";
			}

			
				$sql_update = "UPDATE tbl_assign_key SET  comment_approve='".trim($comment_qc)."',staff_apporve='".$_SESSION['session_staffid']."',unlock_idcardkey='$unlock_idcardkey',supervisor_staffid='".$_SESSION['session_staffid']."' $con_approve WHERE idcard='$idcard' AND siteid='$xsiteid'";
				//echo $sql_update."<br>";die;
				$result_update = mysql_db_query($dbnameuse,$sql_update) or die(mysql_error()) ;
					if($result_update){
							echo "<script>alert('�Ѻ�ͧ�����١��ͧ�ͧ���������º��������'); location.href='process_check_qcdata.php?idcard=$idcard&xsiteid=$xsiteid&fullname=$fullname&profile_id=$profile_id';</script>";				exit();
					}
			
	}//end 	if($Aaction == "Save"){
		
}// end if($_SERVER['REQUEST_METHOD'] == "POST"){
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>��Ǩ�ͺ��ͼԴ��Ҵ��úѹ�֡������</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?
		$sql_search = "SELECT  t1.idcard, t1.keyin_name as fullname, t1.siteid,t2.userkey_wait_approve as staffapprove,
t1.staffid,t1.timeupdate,t2.unlock_idcardkey,t2.supervisor_approve,t2.supervisor_comment
FROM
monitor_keyin as t1
Inner Join tbl_assign_key as t2 ON t1.idcard = t2.idcard AND t1.siteid = t2.siteid 
 AND t2.profile_id = '$profile_id'
WHERE t1.idcard ='$idcard'
GROUP BY t1.idcard
ORDER BY fullname ASC
";
//echo $sql_search;
		$result_s = mysql_db_query($dbnameuse,$sql_search);
		$rss = mysql_fetch_assoc($result_s);
		mysql_free_result($result_s);
			$arr_staff = GetKeyGroup($rss[staffid]);
				$dbsite = STR_PREFIX_DB.$xsiteid;
				
				$date_profile =  DateProfile($idcard,$xsiteid,$profile_id);// �ѹ���Ѵ�Ӣ�����
				$arrdata = ProcessQCData($xsiteid,$idcard,$profile_id);
				$num_error = count($arrdata);
				

				 if($num_error < 1){
					$xmsg = "�š�õ�Ǩ�ͺ�����١��ͧ��ͧ������ ��ҹ ";	 
				}else{
					$xmsg = " �Դ�����Դ��Ҵ㹡�ä��������";	
				}
		$strSql = "SELECT id,idcard,prename_th,name_th,surname_th, siteid,schoolid, position_now FROM general WHERE id='$idcard'";
		$result = mysql_db_query($dbsite,$strSql);
		$rs = mysql_fetch_assoc($result);
		$pathfile = "../../../../../edubkk_kp7file/$rs[siteid]/$rs[idcard]".".pdf";
		//echo "$rs[staffid]";
		mysql_free_result($result);	
			
		

?>
<form action="" method="post" name="form1">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
  <tr>
    <td height="446" valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="370" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="30" class="table2">&nbsp;</td>
            </tr>
        </table>
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td width="50%" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="7%" align="center"><? echo "<a href='login_data.php?xname_th=$rs[name_th]&xsurname_th=$rs[surname_th]&xidcard=$rs[idcard]&action=login&xsiteid=$rs[siteid]' target='_blank'>";?><img src="../../../../images_sys/person.gif" width="16" height="13" border="0" alt="�������� login �������к�"><? echo "</a>"; ?></td>
                      <td width="93%" align="left"><strong>����ػ��õ�Ǩ�ͺ������</strong>&nbsp;<? 
					  if(is_file($pathfile)){
						 	 	echo "<a href='$pathfile' target='_blank'><img src=\"../../../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"21\" alt=\"��Ǩ�ͺ��� pdf �鹩�Ѻ\" border='0'></a>";
						 }else{
								echo ""; 
						}//end   if(is_file($pathfile)){
 ?></td>
                    </tr>
                  </table></td>
                  </tr>
                <tr>
                  <td colspan="2" align="center" valign="top">&nbsp;</td>
                  </tr>
                <tr>
                  <td width="24%" align="center" valign="top">
                  <?
                  		$sql_showpic="select yy,imgname from general_pic where id='$idcard' and kp7_active='1' order by no  DESC ";
						$query=mysql_db_query($dbsite,$sql_showpic)or die("cannot query".mysql_error());
						$num=mysql_num_rows($query);
					
						
						if($num==0){
							echo "<img src=\"../../../../images_sys/noimage.jpg\">";
						}else{
							$rp=mysql_fetch_assoc($query);
							echo "<img src=\"../../../../../image_file/$rs[siteid]/$rp[imgname]\" width=120 height=160 >";
						}//end if($num==0){
                  	mysql_free_result($query);
                  		
                  ?>
                  </td>
                  <td width="76%" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                      <td width="22%" align="right" bgcolor="#FFFFFF"><strong>���ʺѵû�ЪҪ� : </strong></td>
                      <td width="51%" align="left" bgcolor="#FFFFFF"><?=$idcard?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>���� - ���ʡ�� : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>���˹� : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?=$rs[position_now]?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>�ѧ�Ѵ : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?=ShowArea($rs[siteid])."/".ShowSchool($rs[schoolid]);?></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
              <td width="50%" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="7%" align="center"><strong><img src="../../../../images_sys/useronline.gif" width="20" height="20" /></strong></td>
                      <td width="93%"><strong>��������´���ѹ�֡������</strong></td>
                    </tr>
                  </table></td>
                  </tr>
                <tr>
                  <td colspan="2" align="center">&nbsp;</td>
                </tr>

                <tr>
                  <td width="31%" align="center" valign="top">
                  <?
                  	if($arr_staff[image] != ""){
						echo "<img src=\"../../../userentry/images/personnel/$arr_staff[image]\" width=120 height=160>";	
					}else{
						echo "<img src=\"../../../../images_sys/noimage.jpg\">";	
					}
				  ?>
                  
                  </td>
                  <td width="69%" align="center" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                      <td width="42%" align="right" bgcolor="#FFFFFF"><strong>����-���ʡ�� : </strong></td>
                      <td width="58%" align="left" bgcolor="#FFFFFF"><? echo "$arr_staff[fullname]";?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>�ѹ���ѹ�֡������ : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?=DateThai($rss[timeupdate]);?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>��������ѡ�ҹ : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?=$arrstaff[$arr_staff[sapphireoffice]];?></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="2" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tr>
                  <td colspan="2" align="left"><strong><? echo $xmsg;?></strong></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <?  if(count($arrdata)> 0){
				  $i=0;
				  ksort($arrdata);
				foreach($arrdata as $key => $val){	
					if($val != ""){
				 	if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}

				?>
                <tr bgcolor="<?=$bg?>">
                  <td width="6%" align="center" valign="top"><?=$i?></td>
                  <td width="94%" align="left"><? 
				  $arr_val = explode("!wraning",$val);
					if(count($arr_val) > 1){
						$show_val = "<font color='#FF0000'>!wraning </font>".$arr_val[1];
					 }else{
						$show_val =   $val;
					}//end if(count($arr_val) > 1){
				  
				  echo "[Error : $key]$show_val";
				  
				  
				  ?>
                  <input type="hidden" name="err_data[<?=$key?>]" value="<? echo "$val";?>">
                  </td>
                </tr>
                <?
				}//end if($val != ""){
				}//end foreach(){	  
			  }//end  if($num_error < 1){
			?>
                   <tr bgcolor="#CCCCCC">
                  <td colspan="2" align="left" valign="top" bgcolor="#F4F4F4"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                      <td colspan="2" align="left" valign="top" bgcolor="#CCCCCC">&nbsp;</td>
                      </tr>
                      <?
                      	if($rss[approve] == "2"){
								if($rss[supervisor_approve] == "1"){ $ch1= " checked='checked'";$ch2 = "";}else{ $ch1= " ";$ch2 = " checked='checked'"; }
						}else{
							$ch1= " checked='checked'";
							$ch2 = " ";	
						}
					  ?>
                    <tr>
                      <td align="right" valign="top" bgcolor="#CCCCCC">ʶҹС���Ѻ�ͧ��úѹ�֡������ �.�.7(����Ѻ Supervisor) : </td>
                      <td align="left" valign="top" bgcolor="#CCCCCC">    <input type="radio" name="supervisor_approve" id="radio_app1" value="1" <?=$ch1?>>
                        �Ѻ�ͧ��úѹ�֡������ �.�.7
                          <input type="radio" name="supervisor_approve" id="radio_app2" value="0" <?=$ch2?>>
����Ѻ�ͧ��úѹ�֡������ �.�.7</td>
                    </tr>
                    <tr>
                      <td width="25%" align="right" valign="top" bgcolor="#CCCCCC">�����˵ء���Ѻ�ͧ������ : </td>
                      <td width="75%" align="left" valign="top" bgcolor="#CCCCCC"><textarea name="comment_qc" id="comment_qc" cols="45" rows="3"></textarea></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" bgcolor="#CCCCCC">ʶҹлŴ�Ѻ�ͧ��úѹ�֡������ :</td>
                      <td align="left" valign="top" bgcolor="#CCCCCC"> 
                        <input type="radio" name="unlock_idcardkey" id="radio_lock2" value="0" <? if($rss[unlock_idcardkey] == "0"){ echo " checked='checked'"; }?>>
                        ��͡��úѹ�֡������ �.�.7<input type="radio" name="unlock_idcardkey" id="radio_lock1" value="1" <? if($rss[unlock_idcardkey] == "1"){ echo " checked='checked'"; }?>>
                        �Ŵ��͡��úѹ�֡������ �.�.7</td>
                    </tr>

                    </table></td>
                  </tr>
              </table></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="40" align="center" class="table_button">
            <input type="button" name="re_process" value="��Ǩ�ͺ�͡��������ա����" onclick="location.href='process_check_qcdata.php?idcard=<?=$idcard?>&xsiteid=<?=$xsiteid?>&fullname=<?=$fullname?>&profile_id=<?=$profile_id?>'">
            <input type="hidden" name="idcard" value="<?=$idcard?>">
            <input type="hidden" name="profile_id" value="<?=$profile_id?>">
            <input type="hidden" name="xsiteid" value="<?=$xsiteid?>">
            <input type="hidden" name="fullname" value="<?=$fullname?>">
            <input type="hidden" name="Aaction" value="Save" >
            <input type="submit" name="button" id="button" value="�ѹ�֡�Ѻ�ͧ�����١��ͧ�ͧ������" />
              <input name="button2"  type="button" class="bt" value="�Դ"  onclick="window.close();"/></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<?
 	$time_end = getmicrotime(); writetime2db($time_start,$time_end);
	mysql_close();
?>
</body>
</html>
