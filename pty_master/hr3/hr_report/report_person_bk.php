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
	## Modified Detail :		�к���§ҹ�����Ż���ѵԡ���Ѻ�Ҫ���
	## Modified Date :		2009-12-22 15:15
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################


include ("../libary/function.php");
include("../../../common/common_competency.inc.php");
include ("../../../config/phpconfig.php");
include ("timefunc.inc.php");
$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$shortmonth = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");
	
	
if($_SESSION['secid'] != "" and $_SESSION['secid'] != "pty_master"){
	$db_name = STR_PREFIX_DB.$_SESSION['secid'];	
}else if($_SESSION['temp_dbsite'] != ""){
	$db_name = $_SESSION['temp_dbsite'];
}else if($xsiteid != "" and $xsiteid != "pty_master"){
	$_SESSION['id'] = $_GET['id'];
	$db_name = STR_PREFIX_DB.$xsiteid;
}else{
				echo "
					<script language=\"javascript\">
							alert(\"�������ö�������Ͱҹ�������� ��سҵ�Ǩ�ͺ�ա����\");
							top.location.href=\"$mainwebsite\";
					</script>";
			exit;
}//end if($_SESSION['secid'] != "" and $_SESSION['secid'] != "pty_master"){
	
	
	
##  �����ŷ����
$sql_general = "SELECT id,idcard,siteid,prename_th,name_th,surname_th,position_now,prename_en,name_en,surname_en,birthday,contact_add,radub,level_id,begindate,schoolid,noposition,education FROM general WHERE id='$id'";
$result_general = mysql_db_query($db_name,$sql_general);
$rsv = mysql_fetch_assoc($result_general);

$sql_salary = "SELECT max(date) as maxdate FROM salary WHERE id='".$id."'";
$result_salary = mysql_db_query($db_name,$sql_salary);
$rs_salary = mysql_fetch_assoc($result_salary);

$sql_position = "SELECT position, noposition FROM `salary` WHERE `id` = '".$rsv['id']."' ORDER BY  updatetime DESC LIMIT 1 ";
$result_position = mysql_db_query($db_name,$sql_position);
$rsv_position = mysql_fetch_assoc($result_position);

	//$arr1 = array("../../../../edubkk_image_file/6502/5650600015489_2524.jpg","../../../../edubkk_image_file/6502/5650600015489_2531.jpg","../../../../edubkk_image_file/6502/5650600015489_2538.jpg");
	$sql_pic = "SELECT * FROM general_pic WHERE id='$id' ORDER BY yy DESC";
	$resust_pic = mysql_db_query($db_name,$sql_pic);
	$num_pic = mysql_num_rows($resust_pic);
	$pathfile = "../../../../edubkk_image_file/$rsv[siteid]/";
	$i=0;
	while($rs_pic = mysql_fetch_assoc($resust_pic)){
		$arr1[$i] = $pathfile.$rs_pic[imgname];	
		$arr2[$i] = "�Ҿ �վ.�.".$rs_pic[yy];
		$i++;
	}
?>
<html>
<head>

<title>����ѵԡ���Ѻ�Ҫ���</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="hr.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

<script type="text/javascript" src="showimg/fadeslideshow.js"></script>

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

<script type="text/javascript">
<? if($num_pic > 0){?>
var mygallery2=new fadeSlideShow({
	wrapperid: "fadeshow2", //ID of blank DIV on page to house Slideshow
	dimensions: [125, 180], //width/height of gallery in pixels. Should reflect dimensions of largest image
	imagearray: [
	<?
	$i=0;
	$count1 = count($arr1);
	foreach($arr1 as $key1 => $val1){
		$i++;
		if($i < $count1){
	?>
	["<?=$val1?>", "", "", "<?=$arr2[$key1]?>"],
	<?
		}else{
	?>
	["<?=$val1?>", "", "", "<?=$arr2[$key1]?>"]
	<?
		}////end if($i < $count1){
	}//end 
	?>
		],
//	imagearray: [
//		["../edubkk_image_file/6502/5650600015489_2524.jpg", "", "", "�ٻ�Ҿ �� 2524"],
//		["../edubkk_image_file/6502/5650600015489_2531.jpg", "", "", "�ٻ�Ҿ �� 2531"],
//		["../edubkk_image_file/6502/5650600015489_2538.jpg", "", "", "�ٻ�Ҿ �� 2538"] //<--no trailing comma after very last image element!
//	],
	

displaymode: {type:'manual', pause:2500, cycles:0, wraparound:false},
	persist: false, //remember last viewed slide and recall within same session?
	fadeduration: 500, //transition duration (milliseconds)
	descreveal: "always",
	togglerid: "fadeshow2toggler"
})
<? } // end if($num_pic > 0){?>
</script>


</head>
<body>

<table width="98%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4" align="center" style="border:1px solid #DADAE1;">
  <tr>
    <td ><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td align="right"><!--<a href="report_person_pdf.php?id=<?//=$id?>"class="pp" title="��Ǩ�ͺ������ ��.7"><img src="../../../images_sys/pdf.gif" width="16" height="16"align="absmiddle" border=""></a>-->&nbsp;&nbsp;&nbsp;<img src="../../../images_sys/ic_print.gif" align="absmiddle" style="cursor:pointer;" onClick="window.print();">&nbsp;&nbsp;</td>
        </tr>
      <tr>
        <td width="86%" height="515" valign="top">
          <table width="100%" border="0" cellspacing="1" cellpadding="2">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                      <td colspan="4" align="left" bgcolor="#A5B2CE" class="menuitem">����ѵ���ǹ�ؤ��</td>
                      </tr>
                    <tr>
                      <td width="21%" bgcolor="#FFFFFF"><strong>���� &ndash; ʡ�� (��)</strong></td>
                      <td colspan="2" align="left" bgcolor="#FFFFFF"><? echo "$rsv[prename_th]$rsv[name_th]  $rsv[surname_th]";?></td>
                      <td rowspan="4" align="center" bgcolor="#FFFFFF"><table width="50%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="center" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                            <tr>
                              <td width="76%" align="center" bgcolor="#FFFFFF"><? if($num_pic > 0){?><div id="fadeshow2"></div>
                                <div id="fadeshow2toggler" style="width:150px; text-align:center; margin-top:10px"> <a href="#" class="prev"><img src="../../../images_sys/arrow_left_blue.png" style="border-width:0"></a> <span class="status" style="margin:10px; font-weight:bold"></span> <a href="#" class="next"><img src="../../../images_sys/arrow_right_blue.png" style="border-width:0" /></a> </div><? }else{ echo "<img src=\"../../../images_sys/noimage.jpg\" width=\"120\" height=\"160\" border='0'>";}?>
                                </td>
                              </tr>
                            </table></td>
                          </tr>
                      </table></td>
                      </tr>
                    <tr>
                      <td bgcolor="#FFFFFF"><strong>���� &ndash; ʡ�� (�ѧ���)</strong></td>
                      <td colspan="2" align="left" bgcolor="#FFFFFF"><? echo "$rsv[prename_en]$rsv[name_en]  $rsv[surname_en]";?></td>
                      </tr>
                    <tr>
                      <td bgcolor="#FFFFFF"><strong>�ѹ-��͹-�� �Դ</strong></td>
                      <td colspan="2" align="left" bgcolor="#FFFFFF"><? echo MakeDate($rsv[birthday]);?></td>
                      </tr>
                    <tr>
                      <td bgcolor="#FFFFFF"><strong>�������Ѩ�غѹ</strong></td>
                      <td colspan="2" align="left" bgcolor="#FFFFFF"><?=$rsv[contact_add]?></td>
                      </tr>
                    <tr>
                      <td bgcolor="#FFFFFF"><strong>���˹�</strong></td>
                      <td width="36%" align="left" bgcolor="#FFFFFF"><?=$rsv_position['position']?></td>
                      <td width="17%" align="left" bgcolor="#FFFFFF"><strong>�Ţ�����˹�</strong></td>
                      <td width="26%" align="left" bgcolor="#FFFFFF"><?=$rsv_position['noposition']?></td>
                      </tr>
                    <tr>
                      <td bgcolor="#FFFFFF"><strong>�дѺ</strong></td>
                      <td align="left" bgcolor="#FFFFFF">
                        <?
                    	if($rsv[level_id] != ""){
								echo ShowRadub($rsv[level_id]);
						}else{
							echo "$rsv[radub]";	
						}
					?>
                        </td>
                      <td align="left" bgcolor="#FFFFFF">
					  <?php
						$sql_graduate = "SELECT 
						$dbname.graduate.place,
						$dbname.graduate.grade,
						$dbnamemaster.hr_addhighgrade.highgrade,
						$dbname.graduate.degree_level,
						$dbname.graduate.university_level,
						$dbname.graduate.major_level 
						FROM $dbname.graduate inner join $dbnamemaster.hr_addhighgrade on $dbname.graduate.graduate_level=$dbnamemaster.hr_addhighgrade.runid 
						WHERE $dbname.graduate.id='".$rsv['id']."' and kp7_active='1' ORDER BY  $dbname.graduate.graduate_level DESC,$dbname.graduate.finishyear DESC  LIMIT 1";
						$result_graduate = mysql_db_query($dbname,$sql_graduate);
						$rs_gradate = mysql_fetch_assoc($result_graduate);
					  ?>
					  <strong>����֡���٧�ش</strong>
					  </td>
                      <td align="left" bgcolor="#FFFFFF"><?=$rs_gradate['highgrade']?></td>
                      </tr>
                    <tr>
                      <td bgcolor="#FFFFFF"><strong>�����Ҫ��� � �Ѩ�غѹ</strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?
                    $diff  = dateLength($rsv[begindate]);
					if ($rsv[begindate] != ""){
						echo "".$diff[year]."&nbsp;��&nbsp;&nbsp;".$diff[month]."&nbsp;��͹&nbsp;&nbsp;".$diff[day]."&nbsp;�ѹ";
					}else{
						echo "-";
					}
					
					?></td>
                      <td align="left" bgcolor="#FFFFFF"><strong>�ѹ�ú���³����</strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?=retireDate($rsv[birthday]);?></td>
                      </tr>
                    <tr>
                      <td bgcolor="#FFFFFF"><strong>˹��§ҹ</strong></td>
                      <td colspan="3" align="left" bgcolor="#FFFFFF"><? 
					if($rsv[schoolid] != $rsv[siteid]){ $prearea = "�ç���¹";}else{ $prearea = "";}
					echo $prearea."".ShowSchool($rsv[schoolid])." / ".ShowArea($rsv[siteid]);?></td>
                      </tr>
                    </table></td>
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
                      <td colspan="5" bgcolor="#A5B2CE" class="menuitem">����ѵԡ���֡��</td>
                      </tr>
                    <tr>
                      <td width="31%" align="center" bgcolor="#A5B2CE"><strong>�дѺ����֡��</strong></td>
                      <td width="9%" align="center" bgcolor="#A5B2CE"><strong>�շ�������<br>
                        ����֡��</strong></td>
                      <td width="20%" align="center" bgcolor="#A5B2CE"><strong>�زԡ���֡��</strong></td>
                      <td width="20%" align="center" bgcolor="#A5B2CE"><strong>�Ң��Ԫ�</strong></td>
                      <td width="20%" align="center" bgcolor="#A5B2CE"><strong>ʶҺѹ����֡��</strong></td>
                      </tr>
                    <?
                  	$sql_edu = "SELECT * FROM graduate WHERE id='$id' AND kp7_active='1' ORDER BY graduate_level ASC";
					$result_edu = mysql_db_query($db_name,$sql_edu);
					$i=0;
					while($rs_edu = mysql_fetch_assoc($result_edu)){
						## �ز����֡��
						if($rs_edu[degree_level] != ""){
								$DegreeLevel = ShowGraduateLevel($rs_edu[degree_level]);
						}else{
								$DegreeLevel = $rs_edu[grade];
						}
						## �Ң��Ԫ��͡
						if($rs_edu[major_level] != ""){
								$MajorLevel = ShowMajor($rs_edu[major_level]);
						}else{
								$MajorLevel = "����к�";	
						}
						## ʶҹ�֡��
						if($rs_edu[university_level] != ""){
								$GraduatePlace = ShowGraduatePlace($rs_edu[university_level]);
						}else{
								$GraduatePlace = $rs_edu[place];	
						}
						if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	 	
						if($rs_edu[graduate_level] != $xgraduate_level){
						 
				  ?>
                    <tr bgcolor="<?=$bg?>">
                      <td align="left"> - <?=ShowGraduate($rs_edu[graduate_level]);?></td>
                      <td align="center"><?=$rs_edu[finishyear]?></td>
                      <td align="left"><?=$DegreeLevel;?></td>
                      <td align="left"><?=$MajorLevel?></td>
                      <td align="left"><?=$GraduatePlace?></td>
                      </tr>
                    <?
						}else{
		echo "<tr bgcolor=\"$bg\">
                    <td align=\"left\">&nbsp;</td>
                    <td align=\"center\">$rs_edu[finishyear]</td>
                    <td align=\"left\">$DegreeLevel</td>
                    <td align=\"left\">$MajorLevel</td>
                    <td align=\"left\">$GraduatePlace</td>
                  </tr>";							
						}//end if($rs_edu[graduate_level] != $xgraduate_level){
							$xgraduate_level = $rs_edu[graduate_level];
					}//end while(){
				  ?>
                    </table></td>
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
                      <td colspan="6" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                        <tr>
                          <td width="12%" align="center"><a href="report_profile_salary.php?action=all" target="_blank">�������Թ��͹������</a></td>
                          <td width="16%" align="center">
                          <a href="report_profile_salary.php?action=up_salary" target="_blank">����ѵԡ������͹����Թ��͹</a>
                          </td>
                          <td width="16%" align="center"><a href="report_profile_salary.php?action=up_position" target="_blank">�������͹���˹�����дѺ</a></td>
                          <td width="14%" align="center"><a href="report_profile_salary.php?action=vitaya" target="_blank">����ѵԡ�����Ѻ�Է°ҹ�</a></td>
                          <td width="42%" align="center">&nbsp;</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td colspan="6" align="left" bgcolor="#A5B2CE" class="menuitem"><strong>����ѵԡ���Ѻ�Ҫ���</strong></td>
                      </tr>
                    <tr>
                      <td width="14%" align="center" bgcolor="#A5B2CE"><strong>�ѹ / ��͹ / ��</strong></td>
                      <td width="26%" align="center" bgcolor="#A5B2CE"><strong>���˹�</strong></td>
                      <td width="8%" align="center" bgcolor="#A5B2CE"><strong>�Ţ���<br>
                        ���˹�</strong></td>
                      <td width="5%" align="center" bgcolor="#A5B2CE"><strong>�дѺ</strong></td>
                      <td width="23%" align="center" bgcolor="#A5B2CE"><strong>�͡�����ҧ�ԧ</strong></td>
                      <td width="24%" align="center" bgcolor="#A5B2CE"><strong>˹��§ҹ</strong></td>
                      </tr>
                    <?
                  	$sql = "SELECT * FROM salary WHERE id='$id' ORDER BY runno ASC";
					$result = mysql_db_query($db_name,$sql);
					$i=0;
					while($rs = mysql_fetch_assoc($result)){
					if(($rs[position_id] != $xposition_id) or ($rs[level_id] != $xlevel_id) or ($rs[order_type] != $xorder_type)){
						 if(CheckOrderType($rs[order_type]) > 0 ){
						   
						
						##########  label �Ţ�����˹�
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

if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
				  ?>
                    <tr bgcolor="<?=$bg?>">
                      <td align="left"><?=MakeDate($rs['date']);?></td>
                      <td align="left">
                        <? if($rs[position_id] != "" and $rs[position_id] > 0){ echo ShowPosition($rs[position_id]);}else{ echo "$rs[position]";}?>
                        </td>
                      <td align="center"><?=$show_noposition?></td>
                      <td align="center">
                        <? if($rs[level_id] != "" and $rs[level_id] > 0){ echo ShowRadub($rs[level_id]);}else{ echo "$rs[radub]";}?>
                        </td>
                      <td align="left"><?=$noo." ".$rinstruct?>&nbsp;<?=$dateorder?></td>
                      <td align="left"><? 	
					$xpos1 = strpos($rs[pls],"�.�");
					$xpos2 = strpos($rs[pls],"�.�.");
					$xpos3 = strpos($rs[pls],"�ç���¹");
					$xpos_temp = strpos($rs[pls],"�ѡ�ҡ��");
					$xpos4 = strpos($rs[pls],"��.");
					$xpos5 = strpos($rs[pls],"��");
					
					if(($xpos_temp === false)){
					
							if(!($xpos2 === false)){
								echo  "�ç���¹".CutWord($rs[pls],"�.�.");
							}else if(!($xpos1 === false)){
								echo "�ç���¹".CutWord($rs[pls],"�.�");
							}else if(!($xpos3 === false)){
								echo  "�ç���¹".CutWord($rs[pls],"�ç���¹");
							}else if(!($xpos4 === false)){
								echo "�ç���¹".CutWord($rs[pls],"��.");
							}else if(!($xpos5 === false)){
								echo "�ç���¹".CutWord($rs[pls],"��");
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
            <tr>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                      <td colspan="2" align="left" bgcolor="#A5B2CE" class="menuitem">����ѵԡ�ý֡ͺ�� / �֡�Ҵ٧ҹ</td>
                      </tr>
                    <tr>
                      <td width="41%" align="center" bgcolor="#A5B2CE"><strong>�ѹ / ��͹ / �� &nbsp;(�ҡ-�֧)</strong></td>
                      <td width="59%" align="center" bgcolor="#A5B2CE"><strong>������ѡ�ٵ�</strong></td>
                      </tr>
                    <?
                  	$sql_seminar = "SELECT * FROM seminar WHERE id='$id' and kp7_active='1' order by runno ASC";
					$result_seminar = mysql_db_query($db_name,$sql_seminar);
					$num_seminar = @mysql_num_rows($result_seminar);
					if($num_seminar < 1){
						echo "<tr bgcolor='#FFFFFF'><td align='center' colspan='2'> - ����ջ���ѵԡ�ý֡ͺ�� - </td></tr>";
					}else{
						$i=0;
						while($rs_sem = mysql_fetch_assoc($result_seminar)){
						 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
				  ?>
                    <tr bgcolor="<?=$bg?>">
                      <td align="left">
                        <?
                    	echo ShowDateThai($rs_sem[startdate],$rs_sem[enddate]);
					?>
                        </td>
                      <td align="left"><?=$rs_sem[subject]?></td>
                      </tr>
                    <?
						}//end 
					}//end if($num_seminar < 1){
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

