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
session_start();
//echo "<pre>";
//print_r($_SESSION);
			set_time_limit(8000);
			include ("../../common/common_competency.inc.php")  ;
			include("../../config/conndb_nonsession.inc.php");
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
			$curent_date = date("Y-m-d");
			$dbnameuse = DB_USERENTRY;
			$time_start = getmicrotime();
			$mname	= array("","�.�.", "�.�.", "��.�.", "��.�.", "�.�.", "��.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.");
			$monthFull = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
			
			
			if($yy == ""){
					$yy = date("Y")+543;
			}
			if($mm == ""){
					$sql_month = "SELECT month(datekeyin)  as month1  FROM `stat_user_keyin` group by datekeyin order by datekeyin desc limit 0,1";
					$result_month = mysql_db_query($dbnameuse,$sql_month);
					$rs_month = mysql_fetch_assoc($result_month);
					$mm = sprintf("%2d",$rs_month[month1]);
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

	
						   $xname = ShowStaffOffice($sent_staffid);
						   if($yy == ""){ $yy = date("Y")+543;}
						   if($mm == ""){ $mm = sprintf("%02d",date("m"));}
						  
						   //echo "�� : ".$yy."".$mm."<br>";
						   $con_date = ($yy-543)."-".sprintf("%02d",$mm);

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
	  <td width="100%" height="30" align="left"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
      <? if($staff == "keyin"){ // �óվ�ѡ�����������ͧ�����ҹ��?>
        <tr>
          <td height="30" bgcolor="#EFEFEF" class="header" >�����˵� : ��§ҹ��äӹǳ��� Incentive ��Ш���͹���ʴ�������������Ѻ����Ѻ�ͧ�����١��ͧ������ҹ��</td>
        </tr>
        <? } //end ?>
        <tr>
          <td height="30" class="header" >��§ҹ��äӹǳ��� Incentive �����͹</td>
        </tr>
		   <tr>
          <td class="headerTB"><form name="form1" method="post" action="">
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="14%" align="right"><strong>��͹�� : </strong></td>
                <td width="86%" align="left">
                  <select name="mm" id="mm">
                  <option value="">���͡��͹</option>
                  <?
                  	for($m = 1 ; $m <= 12 ; $m++ ){
						$xmm = sprintf("%02d",$m);
						if($xmm == $mm){ $sel = "selected='selected'";}else{ $sel = "";}
						echo "<option value='$xmm' $sel>$monthFull[$m]</option>";
					}//end for($m = 1 ; $m <= 12 ; $m++ ){
				  ?>
                  </select>
                 <strong> �� </strong>
                 <select name="yy" id="yy">
                 <option value="">���͡��</option>
                 <?
                 	for($y = 2552 ; $y <= (date("Y")+543) ; $y++){
						if($y == $yy){ $sel1 = "selected='selected'";}else{ $sel1 = "";}
							echo "<option value='$y' $sel1>$y</option>";
					}
				 ?>
                 </select>
               
                  <input type="submit" name="button2" id="button" value="�ʴ���§ҹ">
                  <input type="hidden" name="Aaction" value="Search">
                </td>
              </tr>
            </table>
          </form></td>
        </tr>
		   <tr>
		     <td class="headerTB"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		       <tr>
		         <td><form name="form2" method="post" action="">
		           <table width="100%" border="0" cellspacing="0" cellpadding="0">
		             <tr>
		               <td bgcolor="#000000">
                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" bgcolor="#FFFFFF"><strong>��§ҹ��� Incentive ��Ш���͹ <? echo $monthFull[intval($mm)]." ".$yy?>  �ͧ <? echo ShowStaffOffice($sent_staffid);?>   ��Ҥ�ṹ�ҵðҹ = <? if($_SESSION[sesion_sec] == "am"){ echo "$base_point";}else{ echo "$base_point_pm";}?> ��ṹ</strong></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="89%" align="left" bgcolor="#FFFFFF"><strong>�ʴ�������
          <? if($xgtype == "1"){ echo "�����  A";}else if($xgtype == "2"){ echo "����� B";}else if($xgtype == "3"){ echo "����� C"; }?>
        </strong></td>
        <td width="11%" align="center" bgcolor="#FFFFFF"><? if($staff != "keyin"){?><a href="report_incentive_per_month_print.php?sent_staffid=<?=$sent_staffid?>&mm=<?=$mm?>&yy=<?=$yy?>" target="_blank"><img src="../../images_sys/print.gif" width="21" height="20" border="0" title="���������ʴ�˹����§ҹ��ػ"></a><? } //end if($staff != "keyin"){ ?></td>
        </tr>
      <tr>
        <td align="center" bgcolor="#FFFFFF"><table width="85%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                      <td colspan="5" align="center" bgcolor="#FFFFFF"><strong>��§ҹ��� Incentive ��Ш���͹ <? echo $monthFull[intval($mm)]." ".$yy?>  <br>
�ͧ <? echo ShowStaffOffice($sent_staffid);?>   �ѹ�������Ժѵԧҹ <?=ShowStartDate($sent_staffid);?></strong></td>
                      </tr>
                      <?
                      	$sql_exsum = "SELECT ROUND(sum(kpoint_add),2) as sum_add , sum(subtract) as sum_sub FROM `stat_incentive` where staffid='$sent_staffid' AND datekeyin LIKE '$con_date%'";
						$result_exsum = mysql_db_query($dbnameuse,$sql_exsum);
						$rsx = mysql_fetch_assoc($result_exsum);
						
						
					  ?>
                    <tr>
                      <td width="38%" align="right" bgcolor="#FFFFFF"><strong>��Ҥ�ṹ�ԧ����ҳ���</strong></td>
                      <td width="22%" align="right" bgcolor="#FFFFFF"><strong>
                        <?=ViewCutPoint($rsx[sum_add]);?>
                      </strong></td>
                      <td width="20%" bgcolor="#FFFFFF"><strong>��ṹ</strong></td>
                      <td width="10%" align="right" bgcolor="#FFFFFF"><strong>
                        <?=ViewCutPoint($rsx[sum_add]*$point_w);?>
                      </strong></td>
                      <td width="10%" bgcolor="#FFFFFF"><strong>�ҷ</strong></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>����������Է����ԧ�س�Ҿ </strong></td>
                      <td align="right" bgcolor="#FFFFFF"><strong>
                        <?=ViewCutPoint($rsx[sum_sub]);?>
                      </strong></td>
                      <td bgcolor="#FFFFFF"><strong>��ṹ</strong></td>
                      <td align="right" bgcolor="#FFFFFF"><strong>
                        <?=ViewCutPoint($rsx[sum_sub]*$point_w);?>
                      </strong></td>
                      <td bgcolor="#FFFFFF"><strong>�ҷ</strong></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>�ط��</strong></td>
                      <td align="right" bgcolor="#FFFFFF"><strong>
                        <?=ViewCutPoint($rsx[sum_add]-$rsx[sum_sub])?>
                      </strong></td>
                      <td bgcolor="#FFFFFF"><strong>��ṹ</strong></td>
                      <td align="right" bgcolor="#FFFFFF">
					    <strong>
					    <?
					  $money1 = CutPoint($rsx[sum_add]*$point_w);
					  $money2 = CutPoint($rsx[sum_sub]*$point_w);
					   $summoney = ($rsx[sum_add]-$rsx[sum_sub])*0.5;
					//  echo "$money1 :: $money2<br>";
					  //echo ViewCutPoint($money1-$money2);
					  echo ViewCutPoint($summoney);
					  ?>
					    </strong></td>
                      <td bgcolor="#FFFFFF"><strong>�ҷ</strong></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
        <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
        <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
                       </table>

                       
                       <table width="100%" border="0" cellspacing="1" cellpadding="3">
		                 <tr>
		                   <td width="4%" rowspan="2" align="center" bgcolor="#F5F5F5"><strong>�ӴѺ</strong></td>
		                   <td width="17%" rowspan="2" align="center" bgcolor="#F5F5F5"><strong>�ѹ��͹��</strong></td>
		                   <td colspan="3" align="center" bgcolor="#F5F5F5"><strong>��ṹ�ԧ����ҳ (��ṹ)</strong></td>
		                   <td align="center" bgcolor="#F5F5F5"><strong>�������Է���س�Ҿ</strong></td>
                           <? if($staff != "keyin"){?>
		                   <td colspan="2" align="center" bgcolor="#F5F5F5"><strong>��� incentive ����</strong></td>
                           <? } ?>
		                   </tr>
		                 <tr onMouseOver="this.style.cursor='hand'; this.style.background='#EFEFEF';" onMouseOut="this.style.cursor='point'; this.style.background='#FFFFFF';">
		                   <td width="13%" align="center" bgcolor="#F5F5F5"><strong>�ѹ�֡��</strong></td>
		                   <td width="14%" align="center" bgcolor="#F5F5F5"><strong>�٧�����ҵðҹ</strong></td>
		                   <td width="13%" align="center" bgcolor="#F5F5F5"><strong>����</strong></td>
		                   <td width="16%" align="center" bgcolor="#F5F5F5"><strong>(��ṹ)</strong></td>
                          <? if($staff != "keyin"){?>
		                   <td width="12%" align="center" bgcolor="#F5F5F5"><strong>(��ṹ)</strong></td>
		                   <td width="11%" align="center" bgcolor="#F5F5F5"><strong>(�ҷ)</strong></td>
                           <? } ?>
		                   </tr>
                           <?

						  // echo "<br>���͹� : $con_date<br>";
						   
                           	$sql_view = "SELECT * FROM `stat_incentive` where staffid='$sent_staffid' and datekeyin LIKE '$con_date%' order by datekeyin ASC";
							$result_view = mysql_db_query($dbnameuse,$sql_view);
							$i=0;
							while($rsv = mysql_fetch_assoc($result_view)){
							if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
							if($rsv[subtract]  > 0){ $font1 = "<font color='#FF0000'>";$font2 = "</font>";}else{ $b1 = "";$b2 = "";$font1 = "";$font2 = "";}
							if(CheckQC1($sent_staffid,$rsv[datekeyin]) > 0){ $b1 = "<b>";$b2 = "</b>";}else{ $b1 = "";$b2 = "";}
							$add_stat =  SumAdd($rsv[staffid],$rsv[datekeyin]);
							
						   ?>
		                 <tr bgcolor="<?=$bg?>">
		                   <td align="center"><? echo $i;?></td>
		                   <td align="left"><? echo DBThaiLongDate($rsv[datekeyin]);?></td>
		                   <td align="center"><? echo ViewCutPoint($rsv[numkpoint]);?></td>
		                   <td align="center"><? echo ViewCutPoint($rsv[kpoint_add]);?></td>
		                   <td align="center"><? echo ViewCutPoint($add_stat);?></td>
		                   <td align="center">  <?=$b1?>
                           <? if($rsv[subtract] > 0){?><a href='report_subtract_qc.php?staffid=<?=$sent_staffid?>&datecal=<?=$rsv[datekeyin]?>&xstaffname=<? echo "$xname";?>' target="_blank"><? echo "$font1".ViewCutPoint($rsv[subtract])."$font2";?> </a><? }else{ echo "0.00";}?><?=$b2?>
                           
                           </td>
                           <? if($staff != "keyin"){?>
		                   <td align="center"><?=ViewCutPoint($rsv[net_point]);?></td>
		                   <td align="right"><?=ViewCutPoint($rsv[incentive]);?></td>
                           <? }?>
		                   </tr>
                       <?						  		
								$sum_subtract += $rsv[subtract];
								$sum_kpoint_add  += $rsv[kpoint_add];
								$sum_numkpoint += $rsv[numkpoint];
							}//end while($rsv = mysql_fetch_assoc($result_view)){
								
								$xsql = "SELECT * FROM `stat_incentive` where staffid='$sent_staffid' and datekeyin LIKE '$con_date%' order by datekeyin DESC LIMIT 1";
								$xresult = mysql_db_query($dbnameuse,$xsql);
								$xrs = mysql_fetch_assoc($xresult);
									
						   ?>
		                 <tr>
		                   <td colspan="2" align="center" bgcolor="#FFFFFF">&nbsp;</td>
		                   <td align="center" bgcolor="#FFFFFF"><strong>
		                     <?=ViewCutPoint($sum_numkpoint)?>
		                   </strong></td>
		                   <td align="center" bgcolor="#FFFFFF"><strong>
		                     <?=ViewCutPoint($sum_kpoint_add)?>
		                   </strong></td>
		                   <td align="center" bgcolor="#FFFFFF"><strong>
		                     <?=ViewCutPoint($add_stat)?>
		                   </strong></td>
		                   <td align="center" bgcolor="#FFFFFF"><strong>
		                     <?=ViewCutPoint($sum_subtract);?>
		                   </strong></td>
                           <? if($staff != "keyin"){?>
		                   <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
		                   <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
                           <? }?>
		                   </tr>
	                    </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="44%" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center">ŧ����  ....................................... ����Ѻ�Թ</td>
                </tr>
              <tr>
                <td align="center">&nbsp;</td>
                </tr>
              <tr>
                <td align="center"><? echo ShowStaffOffice($sent_staffid); ?></td>
                </tr>
              <tr>
                <td align="center">&nbsp;</td>
              </tr>
              <tr>
                <td align="center">ŧ����......................................�������Թ</td>
              </tr>
              <tr>
                <td align="center">&nbsp;</td>
              </tr>
              <tr>
                <td align="center">(.............................................)</td>
              </tr>
              </table></td>
            <td width="56%" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
       <!--           <tr>
                    <td width="54%" align="right" bgcolor="#FFFFFF"><strong>��Ҥ�ṹ���������� : </strong></td>
                    <td width="20%" align="center" bgcolor="#FFFFFF"><strong>
                      <?//=ViewCutPoint($xrs[kpoint_stat])?>
                    </strong></td>
                    <td width="26%" align="center" bgcolor="#FFFFFF"><strong>��ṹ</strong></td>
                  </tr>-->
                 <!-- <tr>
                    <td align="right" bgcolor="#FFFFFF"><strong>����������Է����ط��:</strong></td>
                    <td align="center" bgcolor="#FFFFFF"><strong>
                      <? //if($sum_subtract > 0){ echo "<a href='report_subtract_qc_all.php?staffid=$sent_staffid&datecal=$con_date&xstaffname=$xname' target='_blank'>".ViewCutPoint($sum_subtract)."</a>";}else{ echo "00";}?>
                    </strong></td>
                    <td align="center" bgcolor="#FFFFFF"><strong>��ṹ</strong></td>
                  </tr>-->
                  <tr>
                    <td align="right" bgcolor="#FFFFFF"><strong>��� Incentive �ط�� : </strong></td>
                    <td align="center" bgcolor="#FFFFFF"><strong>
                      <?=ViewCutPoint($xrs[incentive]);?>
                    </strong></td>
                    <td align="center" bgcolor="#FFFFFF"><strong>�ҷ</strong></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center" bgcolor="#FFFFFF"><strong>
                    <? if($sum_subtract > 0){ echo "<a href='report_subtract_qc_all.php?staffid=$sent_staffid&datecal=$con_date&xstaffname=$xname' target='_blank'>�š�õ�Ǩ�ͺ(QC)</a>";}else{ echo "";}?></strong>
                    </td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center" valign="top">&nbsp;</td>
          </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
                        </table>

                        </td>
	                  </tr>
	                </table>
	             </form></td>
	           </tr>
	         </table></td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>