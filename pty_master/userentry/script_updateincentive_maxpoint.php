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
			include("function_incentive.php");
			$flag_process = 0;
			
			$curent_date = date("Y-m-d");
			$dbnameuse = DB_USERENTRY;
			$time_start = getmicrotime();
			$mname	= array("","�.�.", "�.�.", "��.�.", "��.�.", "�.�.", "��.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.", "�.�.");
			
			if($sdate == ""){
					$sdate = "01/".(date("m/")).(date("Y")+543);
			}
			
			if($sdatew == ""){
					$sdatew = "01/".(date("m/")).(date("Y")+543);
					$temp_date1 = date("Y-m")."-01";
					$xbasedate = strtotime("$temp_date1");
					$xdate = strtotime("6 day",$xbasedate); // ��͹��ѧ� 1 �ѹ
					$temp_date2 = date("Y-m-d",$xdate);// �ѹ�Ѵ�
					$arrd2 = explode("-",$temp_date2);
					$sdatew1 = $arrd2[2]."/".$arrd2[1]."/".($arrd2[0]+543);
		
			}

       //echo "$sdatew  :: $sdatew1" ; 

####  function �Ҥ���٧�ٴ�����ǧ���Ң�����
function GetMaxPointKey($date_s,$date_e){
	global $dbnameuse;
	$sqlmax = "SELECT MAX(numkpoint) AS maxpoint,max(numkeyin) as maxkey,staffid  FROM stat_user_keyin WHERE datekeyin BETWEEN '$date_s' AND '$date_e' GROUP BY staffid";
	$resultmax = mysql_db_query($dbnameuse,$sqlmax);
	while($rsm = mysql_fetch_assoc($resultmax)){
		$arr[$rsm[staffid]]['numkpoint'] = $rsm[maxpoint];
		$arr[$rsm[staffid]]['numkeyin'] = $rsm[maxkey];
	}//end while($rsm = mysql_fetch_assoc($resultmax)){
	return $arr;
}//end function GetMaxPointKey(){



######  end �Ҫ�ǧ���Ң�����
		if($sdate == "16/08/2553"){
				$base_point_pm = 381;
		}else if($sdate == "17/08/2553"){
				$base_point_pm = 353;
		}else if($sdate == "18/08/2553"){
				$base_point_pm = 381;
		}else{
				$base_point_pm = $base_point_pm;
		}
		
		//echo $base_point_pm;
	
			
			
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
		$ratio_point = intval(ShowQvalue($get_staffid)); // ��Ҷ�ǧ���˹ѡ��� QC �ͧ���С����
		$sqlS = "SELECT spoint,point_ratio  FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND datekey='$get_date'";
		$resultS = mysql_db_query($dbnameuse,$sqlS);
		$rsS = mysql_fetch_assoc($resultS);
		if($rsS[point_ratio] > 0){
			$rpoint = $rsS[point_ratio];	
		}else{
			$rpoint = $ratio_point;
		}
		return ($rsS[spoint]*$rpoint);
}//end function ShowSubtract(){
	
	function ShowSubtractAvg($get_date,$get_staffid){
		global $dbnameuse;
		$ratio_point = intval(ShowQvalue($get_staffid)); // ��Ҷ�ǧ���˹ѡ��� QC �ͧ���С����
		$sqlS = "SELECT spoint,point_ratio  FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND datekey='$get_date'";
		
		$resultS = mysql_db_query($dbnameuse,$sqlS);
		$rsS = mysql_fetch_assoc($resultS);
		####  
		if($rsS[point_ratio] > 0){
			$rpoint = $rsS[point_ratio];	
		}else{
			$rpoint = $ratio_point;
		}
		
		return ($rsS[spoint]*$rpoint);

}//end function ShowSubtract(){

/*	
function ShowSubtractBdate($get_staffid,$get_date){
	global $dbnameuse;
	$sql1 = "SELECT sum(spoint) AS subtarct FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND sdate <= '$get_date' AND edate >= '$get_date'";
	$result1 = mysql_db_query($dbnameuse,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	return $rs1[subtarct];
		
}//end function ShowSubtractBdate($get_staffid,$get_date){
*/	

##  �ѧ���蹵�Ǩ�ͺ��Ҥ�ṹź���㹪�ǧ�ѻ����
function CheckSubtractUpdate($get_staffid,$get_date){
	global $dbnameuse;
	$arrdate = ShowSdateEdate($get_date); // ���ѹ��������������ش�ͧ�����ѻ����
	$sql2 = "SELECT
sum(stat_incentive.subtract) as subtract_max
FROM `stat_incentive`
WHERE
stat_incentive.staffid =  '$get_staffid' AND
stat_incentive.datekeyin BETWEEN  '".$arrdate['start_date']."' AND '".$arrdate['end_date']."'";
	$result2 = mysql_db_query($dbnameuse,$sql2);
	$rs2 = mysql_fetch_assoc($result2);
	return $rs2[subtract_max];
}	
### function update ������㹪�ǧ�ѻ����óդ��ź�����դ���ҡ���Ҥ��ź��������Ҥ��ź���� update ��¡�â�����
function ShowNumkeyPoint($get_staff,$get_date){
	global $dbnameuse;
	$arrdate = ShowSdateEdate($get_date); // ���ѹ��������������ش�ͧ�����ѻ����
	$sql_k = "SELECT
stat_user_keyin.numkpoint AS kpoint,
datekeyin
FROM `stat_user_keyin`
WHERE
stat_user_keyin.datekeyin BETWEEN  '".$arrdate['start_date']."' AND '".$arrdate['end_date']."' AND
stat_user_keyin.staffid =  '$get_staff'";
	$result_k = mysql_db_query($dbnameuse,$sql_k);
	while($rs_k = mysql_fetch_assoc($result_k)){
		$arrk[$rs_k[datekeyin]] = $rs_k[kpoint];
	}//end while($rs_k = mysql_fetch_assoc($result_k)){
	return $arrk;
}//end function ShowNumkeyPoint($get_staff,$get_date){

function UpdateSubtractVal($get_staffid,$get_date,$get_val){
	global $dbnameuse,$base_point_pm,$point_w;
	$arr_kpoint = ShowNumkeyPoint($get_staffid,$get_date);
	if(count($arr_kpoint) > 0){
		foreach($arr_kpoint as $key => $val){
			$npoint = ($val-$get_val)-$base_point_pm;
			$kincentive = $npoint*$point_w;
			
			$sql_up = "UPDATE stat_incentive SET subtract='$get_val', net_point='$npoint', incentive='$kincentive' WHERE staffid='$get_staffid' and datekeyin='$key'";
			mysql_db_query($dbnameuse,$sql_up);	
		}//end foreach($arr_kpoint as $key => $val){	
	}//end if(count($arr_kpoint) > 0){	
}//end function UpdateSubtractVal(){ 
	  						//echo "<input type='hidden' name='arr_datekeyin[$rsv[staffid]]' value='$rsv[datekeyin]'>";
							//echo "<input type='hidden' name='arr_subtract[$rsv[staffid]]' value='$subtract_val'>";
							//echo "<input type='hidden' name='arr_net_point[$rsv[staffid]]' value='$net_kpoint'>";
							//echo "<input type='hidden' name='arr_incentive[$rsv[staffid]]' value='$Incentive_val'>";
							

	
if($_SERVER['REQUEST_METHOD'] == "POST" and $Aaction == "Save"){

	if(count($sel_name) > 0){
		foreach($sel_name as $key => $val){
			$sql_old = "SELECT COUNT(*) AS num1 FROM  stat_user_keyin  WHERE numkpoint_old > 0 AND  datekeyin='$datekeyin[$key]' AND staffid='$key'";
			$result_old = mysql_db_query($dbnameuse,$sql_old);
			$rsl = mysql_fetch_assoc($result_old);
			if($rsl[num1] < 1){
					$conup = ",numkpoint_old='$numkpoint[$key]' ";
			}else{
					$conup = "";	
			}// end if($rsl[num1] < 1){
				
				
			if($numkpoint_max[$key] > $numkpoint[$key]){ // ��Ҥ�ṹ�٧�ش��ͧ�ҡ���Ҥ�Ҥ�ṹ�Ѩغѹ
			$sql_update = "UPDATE stat_user_keyin SET numkeyin='$numkey_max[$key]',numkpoint='$numkpoint_max[$key]' $conup  WHERE datekeyin='$datekeyin[$key]' AND staffid='$key'";
			//echo $sql_update."<br>";
			mysql_db_query($dbnameuse,$sql_update);
			
			####  �� log �������¹������
			
						$sql_log = "INSERT INTO stat_user_keyin_all_logupdate SET datekeyin='$datekeyin[$key]' , staffid='$key' ,numkeyin='$numkeyin[$key]',numkpoint='$numkpoint[$key]',numperson='$numperson[$key]',staffupdate='".$_SESSION['session_staffid']."'";
					mysql_db_query($dbnameuse,$sql_log);
			}//end 		if($numkpoint_max[$key] > $numkpoint[$key]){ // ��Ҥ�ṹ�٧�ش��ͧ�ҡ���Ҥ�Ҥ�ṹ�Ѩغѹ
			
				
		}//end foreach($sel_name as $key => $val){
			echo "<script>alert('�ѹ�֡��¡�����º��������'); location.href='?sdate=$sdate&group_type=$group_type&sdatew=$sdatew&sdatew1=$sdatew1&action=';</script>";
		exit();
	}else{
		echo "<script>alert('�ѧ��������͡��¡�÷��зӡ�û�Ѻ��ا������'); location.href='?sdate=$sdate&group_type=$group_type&sdatew=$sdatew&sdatew1=$sdatew1&action=';</script>";
		exit();	
	}// end 	if(count($sel_name) > 0){
		
		
		
}//end if($_SERVER['REQUEST_METHOD'] == "POST" and $Aaction == "Save"){
	
###############  �ӹǳ��Ҥ�ṹ���������������ѹ  ###############################################################
?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript">

function checkAll()
{
	var checkboxes = document.getElementsByName("listname[]");
	//var checkboxes = document.getElementsByName(obj);
	var total_boxes = checkboxes.length;

	for(i=0; i < total_boxes; i++ )
	{
	current_value = checkboxes[i].checked;
	
		if(current_value == false)
		{
			checkboxes[i].checked = true;
		}else{
			checkboxes[i].checked = false;	
		}
	}
}//end function checkAll(obj_set_name)






</script>

</HEAD>
<BODY >
<? if($action == ""){?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px" ><a href="index_incentive.php">��Ѻ˹����ѡ</a> || ��§ҹ��äӹǳ��� Incentive ����ѹ(Parttime)</td>
        </tr>
		   <tr>
          <td class="headerTB"><form name="form1" method="post" action="">
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="14%" align="right"><strong>�ѹ���&nbsp;:</strong></td>
                <td width="86%" align="left"><INPUT name="sdate" onFocus="blur();" value="<?=$sdate?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.sdate, 'dd/mm/yyyy')"value="�ѹ��͹��"></td>
              </tr>
              <tr>
                <td align="right">��ǧ�ѹ��� ����٧�ش</td>
                <td align="left"><INPUT name="sdatew" onFocus="blur();" value="<?=$sdatew?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.sdatew, 'dd/mm/yyyy')"value="�ѹ��͹��">&nbsp;�֧&nbsp;
            <INPUT name="sdatew1" onFocus="blur();" value="<?=$sdatew1?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.sdatew1, 'dd/mm/yyyy')"value="�ѹ��͹��"></td>
              </tr>
              <tr>
                <td align="right">&nbsp;</td>
                <td align="left"><label>
                  <input type="submit" name="button2" id="button" value="�ʴ���§ҹ">
                  <input type="hidden" name="Aaction" value="Search">
                </label></td>
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
                           <td align="left" bgcolor="#A5B2CE"><strong>��§ҹ�����ż���§ҹ��Ҥ�ṹ �٧�ش�ҡ��ǧ���ҷ���ջѭ�ҡ�èѴ�红�����</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                         </tr>
                         <? 
						if($group_type == "B"){ 
						  	$xsub_title = "��§ҹ��úѹ�֡�����š����������ҹ���";
						}else if($group_type == "C"){ 
							$xsub_title = "��§ҹ��úѹ�֡�����š����������ҹ����";
						}else{ 
							$xsub_title = "��§ҹ��úѹ�֡�����ŷ�����(parttime)";
						}
						
							if($ptime == ""){
								$ptime = "am";
							}		
								
						if($group_type == ""){
								$group_type = 2;// Fulltime ��������
						}
		
		$date_show = DateSaveDB($sdate);	  
		$date_show_w = DateSaveDB($sdatew);	  
		$date_show_w1 = DateSaveDB($sdatew1);	 
		$arrmaxval = 	GetMaxPointKey($date_show_w,$date_show_w1);
		
		
	if($date_show != "2010-11-08" and $date_show != "2010-11-09" and $date_show != "2010-11-10"){
			
			              echo " <tr>
                           <td align=\"center\" bgcolor=\"#A5B2CE\"><strong><font color=\"#FF0000\"><center><h3>��û�Ѻ��ṹ�л�Ѻ��㹪�ǧ���Ң������ջѭ����ҹ�鹤�� �ѹ��� 8 - 10 �.�. 53</h3></center></font></td>
                         </tr>";die;
 
	}//end 	if($date_show != "2010-11-08" and $date_show != "2010-11-09" and $date_show != "2010-11-10"){

						 
						 ?>
                         <tr>
                           <td align="left" bgcolor="#A5B2CE"><a href="?sdate=<?=$sdate?>&sdatew=<?=$sdatew?>&sdatew1=<?=$sdatew1?>&ptime=am&group_type=2">FullTime(��������)</a> || <a href="?sdate=<?=$sdate?>&sdatew=<?=$sdatew?>&sdatew1=<?=$sdatew1?>&ptime=am&group_type=3">FullTime(���������)</a> || <a href="?sdate=<?=$sdate?>&sdatew=<?=$sdatew?>&sdatew1=<?=$sdatew1?>&ptime=pm&group_type=5">PartTime(��������)</a>||<a href="?sdate=<?=$sdate?>&sdatew=<?=$sdatew?>&sdatew1=<?=$sdatew1?>&ptime=pm&group_type=4">PartTime(���������)</a> </td>
                         </tr>
                         <tr>
                           <td align="left" bgcolor="#A5B2CE"><strong><? echo $xsub_title ;?></strong></td>
                         </tr>
                         <tr>
                           <td align="right" bgcolor="#A5B2CE">		                       <a href="?sdate=<?=$sdate?>&action=view&ptime=<?=$ptime?>&group_type=<?=$group_type?>" target="_blank">�ʴ���§ҹ��������ѧ��û�Ѻ��Ҥ�ṹ</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="button3" id="button2" value="�ѹ�֡">
		                         <input type="hidden" name="Aaction" value="Save">
		                         <input type="hidden" name="group_type" value="<?=$group_type?>">
		                         <input type="hidden" name="sdate" value="<?=$sdate?>"><input type="hidden" name="sdatew" value="<?=$sdatew?>"><input type="hidden" name="sdatew1" value="<?=$sdatew1?>">
</td>
                         </tr>
                       </table>
						<table width="100%" border="0" cellspacing="1" cellpadding="3">
		                 <tr onMouseOver="this.style.cursor='hand'; this.style.background='#EFEFEF';" onMouseOut="this.style.cursor='point'; this.style.background='#FFFFFF';">
		                   <td width="5%" align="center" bgcolor="#A5B2CE"  class="fillcolor_menu"><strong>�ӴѺ</strong></td>
		                   <td width="34%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>���� - ���ʡ��</strong></td>
		                   <td width="19%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>��ṹ�ѹ�֡��</strong></td>
		                   <td width="21%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>��Ҥ�ṹ�٧�ش</strong></td>
		                   <td width="21%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>���͡��Ѻ��ا��Ҥ�ṹ<br><input type="button" name="CheckAll" value="CheckAll/UncheckAll"
onClick="checkAll()">
<!--<input type="button" name="UnCheckAll" value="Uncheck All"
onClick="uncheckAll(document.form2,sel_name[])">-->

		                   </strong></td>
		                   </tr>
                       
                           <?
		
$sql_show = "SELECT
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
keystaff.staffid,
stat_user_keyin.datekeyin,
stat_user_keyin.numperson,
stat_user_keyin.numkeyin,
stat_user_keyin.numkpoint,
stat_user_keyin.numkpoint_old
FROM
keystaff
Inner Join stat_user_keyin ON keystaff.staffid = stat_user_keyin.staffid
WHERE
keystaff.period_time =  '$ptime' AND
keystaff.keyin_group =  '$group_type' AND
stat_user_keyin.datekeyin =  '$date_show'";
	$result_show = mysql_db_query($dbnameuse,$sql_show);
	while($rss = mysql_fetch_assoc($result_show)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			$numpoint = CutPoint($rss[numkpoint]);
			
			$maxpoint = CutPoint($arrmaxval[$rss[staffid]]['numkpoint']);
			$maxkey = CutPoint($arrmaxval[$rss[staffid]]['numkeyin']);
								
						   ?>
		                 <tr bgcolor="<?=$bg?>">
		                   <td align="center"><?=$i?></td>
		                   <td align="left"><? echo "$rss[prename]$rss[staffname]  $rss[staffsurname]";?>&nbsp;&nbsp;<? echo "[$rss[staffid]]";?></td>
		                   <td align="center"><?=ViewCutPoint($numpoint)?></td>
		                   <td align="center"><?=ViewCutPoint($maxpoint)?></td>
		                   <td align="center"><input type="checkbox" name="sel_name[<?=$rss[staffid]?>]" id="listname[]"></td>
		                   </tr>
                          <?
						  	echo "<input type='hidden' name='datekeyin[$rss[staffid]]' value='$rss[datekeyin]'>";
							echo "<input type='hidden' name='numperson[$rss[staffid]]' value='$rss[numperson]'>";
							echo "<input type='hidden' name='numkeyin[$rss[staffid]]' value='$rss[numkeyin]'>";
							echo "<input type='hidden' name='numkpoint[$rss[staffid]]' value='$rss[numkpoint]'>";
							echo "<input type='hidden' name='numkpoint_max[$rss[staffid]]' value='$maxpoint'>";
							echo "<input type='hidden' name='numkey_max[$rss[staffid]]' value='$maxkey'>";
							
							
							
							
								if($incentive > 0){
						   		$sum_Incentive_all += $incentive;
								}
							}//end while($rsv = mysql_fetch_assoc($result_view)){
						   ?>
	                    </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                              <tr>
                                <td width="86%" align="right">&nbsp;</td>
                                <td width="11%" align="center">&nbsp;</td>
                                <td width="3%" align="left">&nbsp;</td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="3">
		                     <tr>
		                       <td width="53%" align="center" bgcolor="#FFFFFF">&nbsp;</td>
		                       <td width="47%" align="left" bgcolor="#FFFFFF">
		                         </td>
		                       </tr>
		                     </table></td>
                          </tr>
                        </table></td>
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
<?
							}//end if($action == ""){
	if($action == "view"){
		$v_sdate = DateSaveDB($sdate);
		
?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" align="center" bgcolor="#CCCCCC"><strong>��§ҹ��û�Ѻ��ṹ��úѹ�֡������ ��Ш��ѹ��� 
          <?=thaidate($v_sdate)?>
        </strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>�ӴѺ</strong></td>
        <td width="31%" align="center" bgcolor="#CCCCCC"><strong>���� ���ʡ��</strong></td>
        <td width="34%" align="center" bgcolor="#CCCCCC"><strong>��ṹ��͹��Ѻ</strong></td>
        <td width="31%" align="center" bgcolor="#CCCCCC"><strong>��ṹ��ѧ��Ѻ</strong></td>
      </tr>
      <?
      	$sql = "SELECT
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
keystaff.staffid,
stat_user_keyin.datekeyin,
stat_user_keyin.numperson,
stat_user_keyin.numkeyin,
stat_user_keyin.numkpoint,
stat_user_keyin.numkpoint_old
FROM
keystaff
Inner Join stat_user_keyin ON keystaff.staffid = stat_user_keyin.staffid
WHERE
keystaff.period_time =  '$ptime' AND
keystaff.keyin_group =  '$group_type' AND
stat_user_keyin.datekeyin =  '$v_sdate'";
$result = mysql_db_query($dbnameuse,$sql);
$i=0;
while($rs = mysql_fetch_assoc($result)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		$numpoint = CutPoint($rs[numkpoint_old]);
		$numpoint_new =  CutPoint($rs[numkpoint]);
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]";?></td>
        <td align="center"><?=ViewCutPoint($numpoint)?></td>
        <td align="center"><?=ViewCutPoint($numpoint_new)?></td>
      </tr>
    <?
}//end while($rs = mysql_fetch_assoc($result)){
	?>
    </table></td>
  </tr>
</table>
<?
	}//end 	if($action == "view"){
?>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "����㹡�û����ż� :: $timeprocess";
?>
