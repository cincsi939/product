<?php
ob_start();
session_start();
//echo $_SESSION[id];
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
$ApplicationName	= "hr";
$module_code 		= "5002.xx";
$process_id 			= "xxxxxxx";
$VERSION 				= "9.x";
#########################################################
#Developer		::	Alongkot
#DateCreate		::	17/03/2007
#LastUpdate		::	17/03/2007
#DatabaseTabel	::	general
#END
############################################################
include ("../libary/function.php");
include("../../../common/common_competency.inc.php");
include ("../../../config/phpconfig.php");
include ("timefunc.inc.php");
if($_GET[xid] != ""){
	$id = $_GET[xid];
}else{
	$id = $id;
}

$getidcard = $_SESSION[idoffice] ;
$save_to_file = 1; //@20/7/2550 ���ٻŧ���

//				echo "��й������������ ���ѧ��Ǩ�ͺ����� ������Դ�ѭ��� ��ҹ����ö�ӡ�úѹ�֡�黡��";
//				echo "<pre>";
//				print_r($_SESSION);
//				echo "<hr>";
function CheckIDCard($StrID){
    if(strlen($StrID)==13){
    $id=str_split($StrID); 
    $sum=0;    
    for($i=0; $i < 12; $i++){
         $sum += floatval($id[$i])*(13-$i); 
    }   
    if((11-$sum%11)%10!=floatval($id[12])){
         return false;
    }else{
         return true; 
    }
}else{
    return false;
}   
}


function checkID($id) {
				if(strlen($id) != 13) return false;
				for($i=0, $sum=0; $i<12;$i++)
				$sum += (int)($id{$i})*(13-$i);
				if((11-($sum%11))%10 == (int)($id{12}))
				return true;
				return false;
}


$sql_view="SELECT *,CZ_ID as id FROM view_general where CZ_ID='$id' ";
$qry=mysql_db_query($dbnamemaster,$sql_view)or die ("error");
$rsv=mysql_fetch_assoc($qry);
if($rsv[siteid] != ""){
	$db_name = "cmss_$rsv[siteid]";
	$dbname = "cmss_$rsv[siteid]";
}


$sql_general="SELECT * FROM general where id='$id' ";
$query_general=mysql_db_query($db_name,$sql_general)or die("CANNOT QUERY".mysql_error());
$arr_general=mysql_fetch_assoc($query_general);
//echo "$sql_general <hr> $db_name";
$sql_salary="SELECT * from salary where id='$arr_general[id]' order by runno DESC";
$query_salary=mysql_db_query($db_name,$sql_salary)or die("CANNOT QOERY".mysql_error());
$arr_salary=mysql_fetch_assoc($query_salary);
$sql_graduate="SELECT place,grade,finishyear,place from graduate where id='$id' order by finishyear DESC ";
//echo $sql_graduate;
$query_graduate=mysql_db_query($db_name,$sql_graduate)or die("CANNOT QOERY".mysql_error());
$arr_graduate=mysql_fetch_assoc($query_graduate);
$sql_sa1="select * from salary where id='$arr_general[id]' order by date DESC ";
$query_sa=mysql_db_query($db_name,$sql_sa1)or die("CANNOT QOERY".mysql_error());
$rs8=mysql_fetch_assoc($query_sa);



?>

<html>
<head>

<title>�����Ţ���Ҫ���</title>
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
              <td height="25" align="center" bgcolor="#F4F4F4">�Ҿ �� �.�.
                  <? if($rp[yy] >0){ echo "$rp[yy]";}else{ echo "����к�";}?>              </td>
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
                <td width="381" rowspan="2"><font color="#000000">�������Ӥѭ����� ��§ҹ�ҡ view_general master </font></td>
                <td width="420" align="right">���ʻ�Шӵ�ǻ�ЪҪ� :
                  <?=$rsv[id];?></td>
              </tr>
              <tr>
                <td align="right">������ � �ѹ���
                  <?=MakeDate($arr_salary['date']);?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" align="right" cellpadding="3" cellspacing="1">
              <tr>
                <td width="20%" align="right" valign="top"><strong>���� - ���ʡ�� :&nbsp;</strong></td>
                <td colspan="2" valign="top" width="80%"><?=" $rsv[prename_th] $rsv[name_th]   &nbsp;$rsv[surname_th]"?></td>
              </tr>
              <tr>
                <td align="right" valign="top">&nbsp;</td>
                <td colspan="2" valign="top"><? if($rsv[prename_en]!="" and $rsv[name_en]!=""){echo " $rsv[prename_en] $rsv[name_en]   &nbsp;$rsv[surname_en]";}else{}?></td>
              </tr>
			  <?
			   $sql_po="SELECT
															`salary`.`radub`,
															`salary`.`date`,
															`salary`.`runno`,
															`salary`.`dateorder`,
															`salary`.`runid`,
															`salary`.`position`,
															`salary`.`pls`
															FROM
																																`salary`
															WHERE
															`salary`.`id` = '$arr_general[id]' AND
															`salary`.`position`  =  '$arr_general[position_now]'
															ORDER BY
															`salary`.`date` ASC
															LIMIT 1
															";
									$query_po=mysql_db_query($db_name,$sql_po)or die("cannot query".mysql_error());
									$arr_po=mysql_fetch_assoc($query_po);
			  ?>
              <tr>
                <td align="right" valign="top"><strong>���˹觻Ѩ�غѹ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?="$rsv[position_now] <strong>�дѺ :&nbsp;</strong>$rsv[radub] (<strong>�Ţ�����˹� :</strong>$rsv[noposition])";?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>�Է°ҹ� :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? 
						if($rsv[vitaya] ==""){
							echo "�ѧ������Է°ҹ�";
						}else {
								$sql_vitaya="select * from vitaya_stat where id='$rsv[id]' ORDER BY date_command DESC";
								 $query_vitaya=mysql_db_query($db_name,$sql_vitaya)or die("cannot query");
								$arr_vitaya=mysql_fetch_assoc($query_vitaya);
								echo "$rsv[position_now]".$rsv[vitaya];					
								$date_start=$arr_vitaya[date_start];
								echo"(<strong>���Ѻ������ѹ��� : </strong>".MakeDate($date_start)."<strong> ���˹ѧ��� :</strong>".$rsv[remark].")";

						}
								?>
                </td>
              </tr>
              <tr>
                <? 
					$sql_getroyal = "SELECT * FROM getroyal WHERE id='$rsv[id]' ORDER BY orderid DESC LIMIT 0,1";
					$result_getroyal = mysql_db_query($dbname,$sql_getroyal);
					$rs_getroyal = mysql_fetch_assoc($result_getroyal);
			  ?>
                <td align="right" valign="top"><strong>����ͧ�Ҫ����������ó� :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? if($rs_getroyal[getroyal]=="")
				{
				echo "-";
				}
				else
				{
					echo "$rs_getroyal[getroyal]";
				}
				;?></td>
              </tr>
              <tr>
                <? 					
										$sql_school="SELECT *  from $dbnamemaster.allschool where id='$rsv[schoolid]' ";
										$query_school=mysql_db_query($dbnamemaster,$sql_school)or die (mysql_error());
										$rs_school=mysql_fetch_assoc($query_school);			
										
										
										$check_id_school = substr($rs_school[id],0,2); // ���������ç���¹����鹵鹴��� 99 
										$c_pos = strpos($rs_school[office],"����к�"); // ����Ҫ����ç���¹�դ���� ����к������������
										
										$sql_secname="SELECT secname from $dbnamemaster.eduarea where secid='$rsv[siteid]' ";
										$query_secname=mysql_db_query($dbnamemaster,$sql_secname)or die (mysql_error());
										$rs_secname=mysql_fetch_assoc($query_secname);	
										
										$sql_work="select * from $dbnamemaster.hr_work where workid='$rsv[work]' ";
										$query_work=mysql_db_query($db_name,$sql_work) or die (mysql_error());
										$rsw=mysql_fetch_assoc($query_work);
										
										if($rsv[schoolid] ==$_SESSION[secid]){
											$rs_school=$rsw[work];
											$rssecname=$rs_secname[secname];
										 }	else{
										 
											if($check_id_school == "99"){// ��Ǩ�ͺ�����ç���¹����鹵鹴��� 99
														if($c_pos === false){
															$rs_school=$rs_school[office];
														}else{
															$rs_school=str_replace("����к�","",$rs_school[office]);
														}	
																						
											}else{
													//echo "<strong>�ѧ�Ѵ :&nbsp;</strong>";
													$rs_school="�ç���¹".$rs_school[office];
													$rssecname=$rs_secname[secname];
											}
										}// end if($rsv[schoolid] ==$_SESSION[secid]){
						
					?>
                <td align="right" valign="top"><strong>˹��§ҹ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?=$rs_school;?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>�ѧ�Ѵ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?=$rssecname;?>
                    <br>
                  <?="$rsv[subminis_now] &nbsp;$rsv[minis_now] ";?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>�Թ��͹�Ѩ�غѹ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?=number_format($rsv[salary])." �ҷ"." ( ������ � �ѹ��� ".MakeDate($arr_salary['date'])." ) ";?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>�ѹ��͹���Դ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? 
									 		echo MakeDate($rsv[birthday]);?>
                    <? $diff  = dateLength($rsv[birthday]);
if ($rsv[birthday] != ""){
	echo "&nbsp; ���� &nbsp;".$diff[year]."&nbsp;��&nbsp;&nbsp;".$diff[month]."&nbsp;��͹&nbsp;&nbsp;".$diff[day]."&nbsp;�ѹ";
}else{
  	echo "-";
}
?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>�������Ѩ�غѹ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? if($rsv[contract_add]!=""){echo "$rsv[contract_add]";} else{echo "-";}?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>�ѹ�������Ժѵ��Ҫ��� :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? echo MakeDate($rsv[begindate]);?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>�ѹ��觺�è� :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? echo  MakeDate($rsv[startdate]); ?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>�ѹ�ú���³���� :&nbsp;</strong></td>
                <td colspan="2" valign="top"><?=retireDate($rsv[birthday])?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong> �����Ҫ��� � �Ѩ�غѹ :&nbsp;</strong></td>
                <td colspan="2" valign="top"><? $diff  = dateLength($rsv[begindate]);
								  ?>
                    <? if ($rsv[begindate] != ""){
	echo "".$diff[year]."&nbsp;��&nbsp;&nbsp;".$diff[month]."&nbsp;��͹&nbsp;&nbsp;".$diff[day]."&nbsp;�ѹ";
}else{
  	echo "-";
}?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>����֡���٧�ش :&nbsp; </strong></td>
                <td colspan="2" valign="top"><?="�дѺ : $rsv[education] &nbsp;&nbsp;(�Ң��Ԫ� :$rsv[grade] &nbsp;&nbsp;ʶҺѹ : $rsv[place] )";?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>��ѡ�ٵá�ý֡ͺ������ش : </strong></td>
                <td colspan="2" valign="top"><?
					$sql_seminar = "SELECT * FROM seminar WHERE id='$rsv[id]' ORDER BY runno DESC LIMIT 0,1";
					$result_seminar = mysql_db_query($dbname,$sql_seminar);
					$rs_seminar = mysql_fetch_assoc($result_seminar);
					echo "$rs_seminar[subject]";
				?>
                </td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>��������������ö����� : </strong></td>
                <td colspan="2" valign="top"><?
				$sql_specail = "SELECT * FROM special WHERE id='$rsv[id]' ";
				$result_specail = mysql_db_query($dbname,$sql_specail);
				while($rs_sp = mysql_fetch_assoc($result_specail)){
						echo " - $rs_sp[detail]<br>";
				}
					
				?>
                </td>
              </tr>
              <?
			  	$ab_yy = date("Y")+543;
				$yy_gov = ($ab_yy-1)."-10-01";
			  $sql_absent = "SELECT sum(sick) as sum_sick, sum(duty) as sum_duty, sum(vacation) as sum_vacation, sum(late) as sum_late,sum(absent) as sum_absent,  sum(education) as sum_education  FROM hr_absent where id='$rsv[id]' AND yy='$ab_yy'";
			  $result_absent = mysql_db_query($dbname,$sql_absent);
			  $rs_ab = mysql_fetch_assoc($result_absent);
			  ?>
              <tr>
                <td align="right" valign="top"><strong>�ӹǹ�ѹ����ش�Ѩ�غѹ : <br>
(������ � �ѹ��� <?=MakeDate($yy_gov);?>  �֧�Ѩ�غѹ) </strong></td>
                <td colspan="2" valign="top">�һ���
                  <?=number_format($rs_ab[sum_sick])?>
                  �ѹ&nbsp; �ҡԨ��оѡ��͹
                  <?=number_format($rs_ab[sum_duty]+$rs_ab[sum_vacation])?>
                  �ѹ &nbsp;�����
                  <?=number_format($rs_ab[sum_late])?>
                  �ѹ&nbsp; �Ҵ�Ҫ���
                  <?=number_format($rs_ab[sum_absent]);?>
                  �ѹ&nbsp; ���֡��
                  <?=number_format($rs_ab[sum_education]);?>
                  �ѹ </td>
              </tr>
              <?
			  	// ����ѵԤ�����
				$sql_goodman = "SELECT * FROM goodman WHERE id='$rsv[CZ_ID]'";
				$result_goodman = @mysql_db_query($db_name,$sql_goodman);
				$num_goodman = @mysql_num_rows($result_goodman);
				if($num_goodman > 0){ // �ó�����¡�ä�����
			  ?>
              <tr>
                <td align="right" valign="top"><strong><? echo "����ѵԤ����դ����ͺ";?></strong></td>
                <td colspan="2" valign="top"><?
				while($rs_good = mysql_fetch_assoc($result_goodman)){
						echo " - $rs_good[gaction]<br>";
				}	
				?></td>
              </tr>
              <?
			  	}//end if($num_goodman > 0){ 
			  ?>
              <tr>
                <?
			  	$sql_prohibit="select * from hr_prohibit where id='$rsv[CZ_ID]' ";
				$query_pro=mysql_db_query($db_name,$sql_prohibit)or die(mysql_error());
				$num_pro=mysql_num_rows($query_pro);
			   ?>
                <td align="right" valign="top"><?   if($num_pro!=0)
			   {
			  	echo"<strong>����ѵԡ�����Ѻ�ɷҧ�Թ�� :</strong>";
			
			    ?></td>
                <td width="61%" valign="top"><? 
				for($i=0;$i<$num_pro;$i++)
				{
				$rsp=mysql_fetch_assoc($query_pro);
				echo"$rsp[yy] &nbsp; $rsp[comment]<br>";
				}
				}//END if
				else
				{
					
				}
				?></td>
                <td width="19%" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>��û�Ժѵ��Ҫ��þ����: </strong></td>
                <td colspan="2" valign="top"><?
				$sql_hr_specialduty = "SELECT * FROM hr_specialduty WHERE id='$rsv[id]'";
				$result_hr_specialduty = mysql_db_query($dbname,$sql_hr_specialduty);
				while($rs_hsp = mysql_fetch_assoc($result_hr_specialduty)){
						echo " - $rs_hsp[comment]<br>";
				}
					
				?></td>
              </tr>
            </table></td>
          </tr>
        </table>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="39" style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#ffffff', EndColorStr='#F4F4F4'); padding:2px"><? include("../../../config/licence_inc.php");?></td>
  </tr>
</table>
</body>
</html>

