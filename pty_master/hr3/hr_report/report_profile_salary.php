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
$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$shortmonth = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	
	
if($_SESSION['secid'] != "" and $_SESSION['secid'] != "edubkk_master"){
	$db_name = STR_PREFIX_DB.$_SESSION['secid'];	
}else if($_SESSION['temp_dbsite'] != ""){
	$db_name = $_SESSION['temp_dbsite'];
}else if($xsiteid != "" and $xsiteid != "edubkk_master"){
	$db_name = STR_PREFIX_DB.$xsiteid;
}else{
				echo "
					<script language=\"javascript\">
							alert(\"ไม่สามารถเชื่อมต่อฐานข้อมูลได้ กรุณาตรวจสอบอีกครั้ง\");
							top.location.href=\"$mainwebsite\";
					</script>";
			exit;
}//end if($_SESSION['secid'] != "" and $_SESSION['secid'] != "edubkk_master"){
	
	
	
##  ข้อมูลทั่วไป
$sql_general = "SELECT id,idcard,siteid,prename_th,name_th,surname_th,position_now,prename_en,name_en,surname_en,birthday,contact_add,radub,level_id,begindate,schoolid,noposition,education FROM general WHERE id='$id'";
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
</style>
</head>
<body>

<table width="98%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4" align="center" style="border:1px solid #DADAE1;">
  <tr>
    <td ><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="86%" height="400" valign="top">
        <? if($action == "all"){?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td colspan="7" align="left" bgcolor="#A3B2CC"><strong>ประวัติข้อมูลเงินเดือนทั้งหมด</strong></td>
                </tr>
              <tr>
                <td width="13%" align="center" bgcolor="#A3B2CC"><strong>วัน เดือน ปี</strong></td>
                <td width="28%" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
                <td width="10%" align="center" bgcolor="#A3B2CC"><strong>เลขที่<br>
ตำแหน่ง</strong></td>
                <td width="8%" align="center" bgcolor="#A3B2CC"><strong>ระดับ</strong></td>
                <td width="9%" align="center" bgcolor="#A3B2CC"><strong>อัตรา<br>
เงินเดือน</strong></td>
                <td width="19%" align="center" bgcolor="#A3B2CC"><strong>เอกสารอ้างอิง</strong></td>
                <td width="13%" align="center" bgcolor="#A3B2CC"><strong>ประภทคำสั่ง</strong></td>
              </tr>
              <?
              $sql = "SELECT * FROM salary WHERE id='$id' ORDER BY runno ASC";
			  $result = mysql_db_query($db_name,$sql);
			  $i=0;
			  while($rs = mysql_fetch_assoc($result)){
				if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	 
	if($rs[instruct]=="#")
{
	$rinstruct="";
}
else
{
$rinstruct=$rs[instruct];
}
if($rs[label_salary] !="")
{
	$salary = (is_numeric($rs['label_salary']))?number_format($rs['label_salary']):$rs['label_salary'];
}
else
{
	if($rs[salary]==0)
	{
	$salary="";
	}
	else
	{
	$salary=number_format($rs[salary]);
	}
}
if($rs[noorder]=="#")
{
	$noo="";
}
else
{
	$noo=$rs[noorder];
}
if($rs[label_date] !="")
{	
	$dateshow= $rs[label_date];
}
else
{
	
	$dateshowX=MakeDate2($rs[date]);
	$DX=explode(" ",$dateshowX);
	//echo "$DX[0]";
	if($DX[0]==0){$dxt="";}else{$dxt=$DX[0];}
	$dateshow=$dxt.$DX[1].$DX[2];
}
if($rs[label_dateorder] !="")
{
	$dateorder=$rs[label_dateorder];
}
else
{
	$dateorderX=MakeDate2($rs[dateorder]);
	$DO=explode(" ",$dateorderX);
	//echo "$DX[0]";
	if($DO[0]==0){$dot="";}else{$dot=$DO[0];}
	$dateorder=$dot.$DO[1].$DO[2];
	//$dateorder=MakeDate2($rs[dateorder]);
}

//__________________________________________
if($rs[label_radub] !=""){$radub=$rs[label_radub]; }
else{$radub=$rs[radub];}
$sys_type=$rs[system_type];
$title="";
if($sys_type!=""){
	$bg="#66FF00";
	if($sys_type=="SYSTEM_TRANSFER"){
		$title="บันทึกผ่านระบบแต่งตั้งโยกย้าย";		
		}else{
	     $title="บันทึกผ่านระบบเลื่อนขั้นเงินเดือน";		
}	
}

##########  label เลขที่ตำแหน่ง
	if($rs[label_noposition] != "" and $rs[label_noposition] != NULL){
			$show_noposition = $rs[label_noposition];
	}else{
			$show_noposition = $rs[noposition];
	}

			  ?>
              <tr bgcolor="<?=$bg?>">
                <td align="center"><?=$dateshow?></td>
                <td align="left"><?=$rs[pls]?></td>
                <td align="center"><?=$show_noposition?></td>
                <td align="center"><?=$radub?></td>
                <td align="left"><?=$salary?></td>
                <td align="left"><?=$noo." ".$rinstruct?>&nbsp;<?=$dateorder?></td>
                <td align="left"><?
					$sql1 = "SELECT
					id,
					order_type,
					orderby
					FROM hr_order_type where id='$rs[order_type]'";
					$resultx = mysql_db_query($dbnamemaster,$sql1);
					$rsx=mysql_fetch_array($resultx);
					echo  substr( $rsx[order_type],0,50);
				?></td>
              </tr>
              <?
				}// end   while($rs = mysql_fetch_assoc($result)){
			 ?>
            </table></td>
          </tr>
        </table>
        <?
		}//end if($action == "all"){
		if($action == "up_salary"){
				
				$sql = "SELECT * FROM salary WHERE id='$id' ORDER BY runno ASC";
				$result = mysql_db_query($db_name,$sql);
				while($rs = mysql_fetch_assoc($result)){
					$arr_runid[] = $rs[runid];
					$arr_runno[] = $rs[runno];
					$arr_salary[] = $rs[salary];
					$arr_date[] = $rs['date'];
					$arr_position[] = $rs[position];
					$arr_noposition[] = $rs[noposition];
					$arr_radub[] = $rs[radub];
					$arr_label_radub[] = $rs[label_radub];
					$arr_noorder[] = $rs[noorder];
					$arr_pls[] = $rs[pls];
					$arr_order_type[] = $rs[order_type];
					$arr_label_date[] = $rs[label_date];
					$arr_label_noposition[] =$rs[label_noposition];
				
				}//end while($rs = mysql_fetch_assoc($result)){
			
		?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td colspan="6" align="left" bgcolor="#A3B2CC"><strong>ประวัติการเลื่อนขั้นเงินเดือน</strong></td>
                </tr>
              <tr>
                <td width="13%" align="center" bgcolor="#A3B2CC"><strong>วัน เืดือน ปี</strong></td>
                <td width="28%" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
                <td width="10%" align="center" bgcolor="#A3B2CC"><strong>เลขที่<br>
ตำแหน่ง</strong></td>
                <td width="9%" align="center" bgcolor="#A3B2CC"><strong>ระดับ</strong></td>
                <td width="14%" align="center" bgcolor="#A3B2CC"><strong>เงินเดือน</strong></td>
                <td width="13%" align="center" bgcolor="#A3B2CC"><strong>จำนวนเงินที่เลื่อน</strong></td>
              </tr>
              <?
				$i=0;
				foreach($arr_runid as $k => $v){
				if($arr_order_type[$k] == "4"){
					$k_up = $k-1;
					$salary_up = $arr_salary[$k]-$arr_salary[$k_up];
					
				if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}			
				if($arr_label_date[$k] !=""){	
					$dateshow= $arr_label_date[$k];
				}else{
					$dateshowX=MakeDate2($arr_date[$k]);
					$DX=explode(" ",$dateshowX);
					if($DX[0]==0){$dxt="";}else{$dxt=$DX[0];}
					$dateshow=$dxt.$DX[1].$DX[2];
				}
	
	
	##########  label เลขที่ตำแหน่ง
	if($arr_label_noposition[$k] != "" and $arr_label_noposition[$k] != NULL){
			$show_noposition = $arr_label_noposition[$k];
	}else{
			$show_noposition = $arr_noposition[$k];
	}
###  ระดับ
if($arr_label_radub[$k] !=""){$radub=$arr_label_radub[$k]; }
else{$radub=$arr_radub[$k];}
			  ?>
              <tr bgcolor="<?=$bg?>">
                <td align="center"><?=$dateshow?></td>
                <td align="left"><?=$arr_pls[$k]?></td>
                <td align="center"><?=$show_noposition?></td>
                <td align="center"><?=$radub?></td>
                <td align="center"><?=number_format($arr_salary[$k])?></td>
                <td align="center"><?=number_format($salary_up)?></td>
              </tr>
              <?
					}//edn if($arr_order_type[$k] == "4"){
				}// end foreach(){
			  ?>
            </table></td>
          </tr>
        </table>
		<?
		}//end 	if($action == "up_salary"){
		if($action == "up_position"){
		?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td colspan="6" align="left" bgcolor="#A3B2CC"><strong>การเลื่อนตำแหน่งและระดับ</strong></td>
                </tr>
              <tr>
                <td width="13%" align="center" bgcolor="#A3B2CC"><strong>วัน เืดือน ปี</strong></td>
                <td width="28%" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
                <td width="10%" align="center" bgcolor="#A3B2CC"><strong>เลขที่<br>
ตำแหน่ง</strong></td>
                <td width="9%" align="center" bgcolor="#A3B2CC"><strong>ระดับ</strong></td>
                <td width="18%" align="center" bgcolor="#A3B2CC"><strong>เอกสารอ้างอิง</strong></td>
                <td width="22%" align="center" bgcolor="#A3B2CC"><strong>หน่วยงาน</strong></td>
              </tr>
                                  <?
                  	$sql = "SELECT * FROM salary WHERE id='$id' ORDER BY runno ASC";
					$result = mysql_db_query($db_name,$sql);
					$i=0;
					while($rs = mysql_fetch_assoc($result)){
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


				  ?>

              <tr bgcolor="<?=$bg?>">
                <td align="center"><?=MakeDate($rs['date']);?></td>
                <td align="left"> <? if($rs[position_id] != "" and $rs[position_id] > 0){ echo ShowPosition($rs[position_id]);}else{ echo "$rs[position]";}?></td>
                <td align="center"><?=$show_noposition?></td>
                <td align="center"><? if($rs[level_id] != "" and $rs[level_id] > 0){ echo ShowRadub($rs[level_id]);}else{ echo "$rs[radub]";}?></td>
                <td align="left"><?=$noo." ".$rinstruct?>&nbsp;<?=$dateorder?></td>
                <td align="left"><? 	
					$xpos1 = strpos($rs[pls],"ร.ร");
					$xpos2 = strpos($rs[pls],"ร.ร.");
					$xpos3 = strpos($rs[pls],"โรงเรียน");
					$xpos_temp = strpos($rs[pls],"รักษาการ");
					$xpos4 = strpos($rs[pls],"รร.");
					$xpos5 = strpos($rs[pls],"รร");
					
					if(($xpos_temp === false)){
					
							if(!($xpos2 === false)){
								echo  "โรงเรียน".CutWord($rs[pls],"ร.ร.");
							}else if(!($xpos1 === false)){
								echo "โรงเรียน".CutWord($rs[pls],"ร.ร");
							}else if(!($xpos3 === false)){
								echo  "โรงเรียน".CutWord($rs[pls],"โรงเรียน");
							}else if(!($xpos4 === false)){
								echo "โรงเรียน".CutWord($rs[pls],"รร.");
							}else if(!($xpos5 === false)){
								echo "โรงเรียน".CutWord($rs[pls],"รร");
							}else{
								echo $rs[pls];	
							}
					}else{
						echo $rs[pls];
					}
					?></td>
              </tr>
              <?
						 }// end if(CheckOrderType($rs[order_type]) > 0 ){
						 }// end 	if(($rs[position_id] != $xposition_id) or ($rs[level_id] != $xlevel_id) or ($rs[order_type] != $xorder_type)){
				}//end while($rs = mysql_fetch_assoc($result)){
			  ?>
            </table></td>
          </tr>
        </table>
		<?
			}///end 	if($action == "up_position"){
			if($action == "vitaya"){
		?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td colspan="6" align="left" bgcolor="#A3B2CC"><strong>ประวัติการไดัรับวิทยฐานะ</strong></td>
                </tr>
              <tr>
                <td width="13%" align="center" bgcolor="#A3B2CC"><strong>วัน เืดือน ปี</strong></td>
                <td width="28%" align="center" bgcolor="#A3B2CC"><strong>ตำแหน่ง</strong></td>
                <td width="10%" align="center" bgcolor="#A3B2CC"><strong>เลขที่<br>
ตำแหน่ง</strong></td>
                <td width="9%" align="center" bgcolor="#A3B2CC"><strong>ระดับ</strong></td>
                <td width="18%" align="center" bgcolor="#A3B2CC"><strong>เอกสารอ้างอิง</strong></td>
                <td width="22%" align="center" bgcolor="#A3B2CC"><strong>ได้รับวิทยฐานะ</strong></td>
              </tr>
             <?
             	$sql = "SELECT * FROM salary WHERE id='$id' AND order_type='3' order by runno ASC";
				$result = mysql_db_query($db_name,$sql);
				$i=0;
				while($rs = mysql_fetch_assoc($result)){
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
			 ?>
              <tr bgcolor="<?=$bg?>">
                <td align="center"><?=MakeDate($rs['date']);?></td>
                <td align="left"> <? if($rs[position_id] != "" and $rs[position_id] > 0){ echo ShowPosition($rs[position_id]);}else{ echo "$rs[position]";}?></td>
                <td align="center"><?=$show_noposition?></td>
                <td align="center"><? if($rs[level_id] != "" and $rs[level_id] > 0){ echo ShowRadub($rs[level_id]);}else{ echo "$rs[radub]";}?></td>
                <td align="left"><?=$noo." ".$rinstruct?>&nbsp;<?=$dateorder?></td>
                <td align="left">
				<? if($rs[position_id] != "" and $rs[position_id] > 0){ echo ShowPosition($rs[position_id]);}else{ echo "$rs[position]";}?>
                <?
                	$sql_vitaya = "SELECT * FROM vitaya_stat WHERE id='$rs[id]' AND salary_id='$rs[runid]'";
					$result_vitaya = mysql_db_query($db_name,$sql_vitaya);
					$rs_v = mysql_fetch_assoc($result_vitaya);
					echo "$rs_v[name]";
				?>
                </td>
              </tr>
              <?
				}//end while($rs = mysql_fetch_assoc($result)){
			  ?>
            </table></td>
          </tr>
        </table>
		<?
			}//end if($action == "vitaya"){
		?>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>

