<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AdminReport";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Pairoj
#DateCreate::29/03/2007
#LastUpdate::29/03/2007
#DatabaseTable::schooll_name, login
#END
#########################################################
//session_start();
			set_time_limit(8000);
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
			$curent_date = date("Y-m-d");
			$dbnameuse = DB_USERENTRY;
			$time_start = getmicrotime();
			$mname	= array("","�.�.", "�.�.", "��.�.", "��.�.", "�.�.", "��.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.");
			$monthFull = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
			$arr_dc = explode("-",$datecal);
			
		//$datereq1 = "2010-02-24";
	 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_dc[1]), intval($arr_dc[2]), intval($arr_dc[0]))));
	 $curent_w = $xFTime["wday"];
	 $xsdate = $curent_w -1;
	 $xedate = 6-$curent_w;
	 if($xsdate > 0){ $xsdate = "-$xsdate";}
	 //echo " $datereq1  :: $xsdate  :: $xedate<br>";
				
				 $xbasedate = strtotime("$datecal");
				 $xdate = strtotime("$xsdate day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// �ѹ�Ѵ�
				 
				 $xbasedate1 = strtotime("$datecal");
				 $xdate1 = strtotime("$xedate day",$xbasedate1);
				 $xedate = date("Y-m-d",$xdate1);// �ѹ�Ѵ�
				 
				//echo "$xsdate  :: $xedate<br>";


	 
	 //echo "<pre>";
	 //print_r($xFTime);
	 
			
			if($sdate == ""){
					$sdate = date("d/m/").(date("Y")+543);
			}

			
			function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = (intval($x[0])+543);
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				return $xrs;
			}


function DateSaveDB($temp){
		if($temp != ""){
				$arr1 = explode("/",$temp);
				return ($arr1[2]-543)."-".$arr1[1]."-".$arr1[0];
		}//end 	if($temp != ""){
}// end function DateSaveDB($temp){
function DateView($temp){
	if($temp != ""){
			$arr1 = explode("-",$temp);
			return $arr1[2]."/".$arr1[1]."/".($arr1[0]+543);
	}
		
}// end function DateView($temp){


function ShowSubtract($get_date,$get_staffid){
		global $dbnameuse;
		$sqlS = "SELECT spoint FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND datekey='$get_date'";
		$resultS = mysql_db_query($dbnameuse,$sqlS);
		$rsS = mysql_fetch_assoc($resultS);
		return $rsS[spoint];
}//end function ShowSubtract(){
	
	
function ShowPerson($get_idcard){
	global $dbnameuse;
	$sql = "SELECT * FROM  tbl_assign_key where idcard='$get_idcard' AND nonactive='0'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[fullname];
}

function XShowGroupQC($get_id){
		global $dbnameuse;
		$sql = "SELECT * FROM validate_datagroup WHERE checkdata_id='$get_id'";
		$result = mysql_db_query($dbnameuse,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[dataname];
}
?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<SCRIPT SRC="sorttable.js"></SCRIPT>
<script language="javascript">

</script>
</HEAD>
<BODY >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center">
	  <td width="100%" height="42" align="left"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="30" ><strong>��§ҹ��¡�èش�Դ�ҡ��� QC</strong></td>
        </tr>
		   <tr>
          <td class="headerTB">��õ�Ǩ�ͺ�����š���� <? $xgroup = CheckGroupStaff($staffid); if($xgroup == "1"){ echo " A";}else if($xgroup == "2"){ echo "L";}else{ echo "N";}?></td>
        </tr>
		   <tr>
		     <td class="headerTB"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		       <tr>
		         <td><form name="form2" method="post" action="">
		           <table width="100%" border="0" cellspacing="0" cellpadding="0">
		             <tr>
		               <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
		                 <tr>
		                   <td colspan="8" align="left" bgcolor="#FFFFFF"><strong>��¡�èش�Դ�ͧ <?=$xstaffname?> ��͹ <? $arrm1 = explode("-",$datecal);echo $monthFull[intval($arrm1[1])]." ".($arrm1[0]+543)?></strong></td>
		                   </tr>

		                 <tr>
		                   <td width="4%" align="center" bgcolor="#FFFFFF"><strong>�ӴѺ</strong></td>
		                   <td width="23%" align="center" bgcolor="#FFFFFF"><strong>�����Ţͧ(���)</strong></td>
		                   <td width="17%" align="center" bgcolor="#FFFFFF"><strong>��¡�÷��Դ</strong></td>
		                   <!--<td width="16%" align="center" bgcolor="#A5B2CE"><strong>��ѡ�ҹ QC</strong></td>-->
		                   <td width="27%" align="center" bgcolor="#FFFFFF"><strong>��������¡�÷��Դ</strong></td>
		                   <td width="12%" align="center" bgcolor="#FFFFFF"><strong>��ṹ QC</strong></td>
		                   <td width="8%" align="center" bgcolor="#FFFFFF"><strong>Ratio</strong></td>
		                   <td width="9%" align="center" bgcolor="#FFFFFF"><strong>����������Է���</strong></td>
		                   </tr>
                            <?
	//$group_type = CheckGroupKey($staffid);
	//$ratio_point = intval(ShowQvalue($staffid)); // ��Ҷ�ǧ���˹ѡ��� QC �ͧ���С����
	//$group_type = CheckGroupStaff($staffid);

	$yymm = $datecal;
	$arrkr =  FindGroupKeyData($staffid,$yymm);	
if($yymm == "2010-03" or $yymm == "2010-02" or $yymm == "2010-01" or $yymm == "2010-04" or $yymm == "2010-05" or $yymm == "2010-06"){
	$xstatus_yy = 0;
	$conyy = " AND  validate_checkdata.datecal LIKE '$yymm%' ";
}else{
	$xstatus_yy = 1;
	$conyy = " AND  validate_checkdata.qc_date LIKE '$yymm%' ";
}


			
	### ����¡�÷���ա�äӹǳ��Ҩش�Դ�٧�ش
/*	$sql2 = "SELECT 
sum(if(validate_mistaken.mistaken_id='2',1,0.5)) as subtract_val,
 validate_checkdata.idcard
FROM validate_checkdata Inner Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id 
Inner Join validate_mistaken ON validate_datagroup.mistaken_id = validate_mistaken.mistaken_id WHERE validate_checkdata.staffid LIKE '%$staffid%' 
AND validate_checkdata.result_check = '0' $conw
group by validate_checkdata.idcard
 ORDER BY subtract_val DESC
LIMIT 1";
	$result2 = mysql_db_query($dbnameuse,$sql2);
	$rs2 = mysql_fetch_assoc($result2);
*/	

			
  $sql = "SELECT
validate_checkdata.ticketid,
validate_checkdata.qc_staffid,
validate_mistaken.mistaken,
if(validate_mistaken.mistaken_id='2',$ratio_t1*num_point,$ratio_t2*num_point) as subtract_val,
validate_checkdata.idcard,
validate_datagroup.dataname,
validate_datagroup.parent_id,
validate_checkdata.datecal,
validate_checkdata.qc_date
FROM
validate_checkdata
Inner Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id
Inner Join validate_mistaken ON validate_datagroup.mistaken_id = validate_mistaken.mistaken_id
WHERE
validate_checkdata.staffid LIKE  '%$staffid%'  AND   validate_checkdata.status_process_point = 'YES' AND 
validate_checkdata.result_check =  '0' $conyy";
//echo $sql."<br>";
## validate_checkdata.datecal =  '$datecal' AND  "$xsdate  :: $xedate<br>";
$result = mysql_db_query($dbnameuse,$sql);

$i=0;
while($rs = mysql_fetch_assoc($result)){
if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
if($xstatus_yy == "1"){
	$xdatecall = $rs[qc_date];	
}else{
	$xdatecall = $rs[datecal];		
}
		$group_type = $arrkr[$xdatecall]['kgroup'];
		$ratio_point = $arrkr[$xdatecall]['rpoint']; // �Ҥ�ṹ�ѡ�����ǧ����
		$point_subtract = CutPoint($rs[subtract_val]*$ratio_point); // ��Ҥ�ṹ�������Է��
		
						   ?>                      
		                 <tr bgcolor="<?=$bg?>">
		                   <td align="center"><?=$i?></td>
		                   <td align="left"><? echo "$rs[idcard] [".ShowPerson($rs[idcard])."]";?></td>
		                   <td align="left"><? echo "��Ǵ ".XShowGroupQC($rs[parent_id])."($rs[dataname])";?></td>
		               <!--    <td align="left"><? echo ShowStaffOffice($rs[qc_staffid]);?></td>-->
		                   <td align="left"><? echo "$rs[mistaken]";?></td>
		                   <td align="center"><? echo "$rs[subtract_val] ";?></td>
		                   <td align="center"><? echo "$ratio_point";?></td>
		                   <td align="center"><? echo $point_subtract;?></td>
		                   </tr>
                          <?
						  	$subtract_sum1 += $rs[subtract_val];
							$sum_point_subtract += $point_subtract;
						}
						
		$sql1 = "SELECT sum(num_p) AS nump FROM stat_subtract_keyin WHERE staffid='$staffid' AND datekey LIKE '$yymm%' ";
		//echo "<br>$sql1<br>";
		$result1 = mysql_db_query($dbnameuse,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
		
	/*	if($group_type == "1" or $group_type == "2"){
			if($rs1[nump] > $group_type){ // �óըش�Դ�ա�õ�Ǩ�Թ���Ҥ���ҵðҹ��ͧ�ʴ�Ẻ��������
				$pval = CutPoint($subtract_sum1/$rs1[nump]);
				//$txt_comment = "��ṹ��� $subtract_sum1 ��� �ӹǹ�ش $rs1[nump] ��ҡѺ ".$pval." �ٳ���ࡳ���ǧ���˹ѡ".$ratio_point." : ";
				$txt_comment = "(��ṹ���/�ӹǹ�ش)x���ࡳ���ǧ���˹ѡ :: ($subtract_sum1 / $rs1[nump]) x $ratio_point : ";
				$txt_cal = "(��ṹ���/�ӹǹ�ش)x���ࡳ���ǧ���˹ѡ";
				$net_totalsubtract = CutPoint($pval*$ratio_point);
			}else{
				$pval = 0;
				$txt_comment = "(��ṹ���x���ࡳ���ǧ���˹ѡ) $subtract_sum1 x ".$ratio_point." : ";
				$txt_cal = "(��ṹ���x���ࡳ���ǧ���˹ѡ)";
				$net_totalsubtract = CutPoint($subtract_sum1*$ratio_point);
			}// end  if($rs1[nump] > $group_type){ 
		}else{
				$pval = 0;
				$net_totalsubtract = $subtract_sum1;
				$txt_cal = "";
				$txt_comment = "��� : ";
		}//end if($group_type == "1" or $group_type == "2"){
*/
/*						if($group_type > 0){ // �ó��繡���� A ��� ����� B ����դ�ṹ * 3 �ش
							$net_totalsubtract = $subtract_sum1*$ratio_point;
							$txt_comment = "��ṹ��� $subtract_sum1 x ".$ratio_point." : ";
						}else{
							$net_totalsubtract = $subtract_sum1;
							$txt_comment = "��� : ";
						}
						
*/						

$txt_cal = "(��ṹ���x���ࡳ���ǧ���˹ѡ)";
?>
		                 <tr>
		                   <td colspan="4" align="right" bgcolor="#FFFFFF"><strong> ��� : </strong></td>
		                   <td align="center" bgcolor="#FFFFFF"><strong><font color="#FF0000"><?=ViewCutPoint($subtract_sum1);?></font></strong></td>
		                   <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
		                   <td align="center" bgcolor="#FFFFFF"><?=ViewCutPoint($sum_point_subtract);?></td>
		                   </tr>

	                    </table></td>
	                  </tr>
	                </table>
	             </form></td>
	           </tr>
               <? if($txt_cal != ""){?>
		       <tr>
		         <td> <table width="50%" border="0" align="right" cellpadding="0" cellspacing="0">
		           <tr>
		             <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                     
		               <tr>
		                 <td width="68%" align="right" bgcolor="#FFFFFF"><strong>�ӹǹ�ش�͡��÷���Ǩ�ҡ��� QC : </strong></td>
		                 <td width="20%" align="center" bgcolor="#FFFFFF"><strong>
		                   <?=$rs1[nump]?>
		                 </strong></td>
		                 <td width="12%" align="center" bgcolor="#FFFFFF"><strong>�ش</strong></td>
		                 </tr>
                        <tr>
		                 <td align="right" bgcolor="#FFFFFF"><strong>��ṹ��� : </strong></td>
		                 <td align="center" bgcolor="#FFFFFF"><strong>
		                   <?=ViewCutPoint($subtract_sum1);?>
		                 </strong></td>
		                 <td align="center" bgcolor="#FFFFFF"><strong>��ṹ</strong></td>
		                 </tr>
		              <!-- <tr>
		                 <td align="right" bgcolor="#FFFFFF"><strong>ࡳ���ǧ���˹ѡ : </strong></td>
		                 <td align="center" bgcolor="#FFFFFF"><strong>
		                   <?//=$ratio_point?>
		                 </strong></td>
		                 <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
		                 </tr>-->
		               <tr>
		                 <td align="right" bgcolor="#FFFFFF"><strong>����������Է��� : </strong></td>
		                 <td align="center" bgcolor="#FFFFFF"><strong>
                         <?
/*                         	$sql_sub1 = "SELECT sum(subtract) as sumsubtract  FROM `stat_incentive` where staffid='$staffid' and datekeyin LIKE '$yymm%'";
							$result_sub1 = mysql_db_query($dbnameuse,$sql_sub1);
							$rss1 = mysql_fetch_assoc($result_sub1);
*/						 ?>
		                  <font color="#FF0000"> <?=ViewCutPoint($sum_point_subtract);?></font>
		                 </strong></td>
		                 <td align="center" bgcolor="#FFFFFF"><strong>��ṹ</strong></td>
		                 </tr>
		               <tr>
		                 <td colspan="3" align="left" bgcolor="#FFFFFF"><strong>����������Է��� = (��ṹ��� x ࡳ���ǧ���˹ѡ)</strong></td>
		                 </tr>
		        
	                  </table></td>
	                </tr>
	             </table></td>
	           </tr>
		       <tr>
		         <td>&nbsp;</td>
	           </tr>
		       <tr>
		         <td>&nbsp;</td>
	           </tr>
               <? } //end  if($txt_cal != ""){?>
               
               
	         </table></td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>