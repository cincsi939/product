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
			set_time_limit(8000);
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php");
if(!isset($session_staffid)){
echo "<script type=\"text/javascript\">
alert('��س���͡�Թ�������к�');
window.location=\"login.php\";
</script>";
}
			
			
			if($group_type == ""){
				$group_type = "all";
			}//end if($group_type == ""){
				if($keydate == ""){
					$keydate = date("d/m/").(date("Y")+543);
				}
			
			$curent_date = date("Y-m-d");
			$dbnameuse = "edubkk_userentry";
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
					$mm = sprintf("%02d",$rs_month[month1]);
			}

//echo "$yy :: $mm";
			
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
####  funnction �����żš�äӹǳ�ش�Դ��Ҵ�ͧ��ѡ�ҹ������������С����
function PorcessUserKeyPointError($get_data){
	global $dbnameuse,$length_var;
		$j=0;
		for($i=0;$i<$length_var;$i++){
			$xbasedate = strtotime("$get_data");
			$xdate = strtotime("-$i day",$xbasedate); // ��͹��ѧ�
			$xsdate = date("Y-m-d",$xdate);// �ѹ��͹��ѧ
			$arr_d1 = explode("-",$xsdate);
			$xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d1[1]), intval($arr_d1[2]), intval($arr_d1[0]))));
			if($xFTime['wday'] != "0"){  ###  ��Ǩ�ͺ�ó�������ѹ�ҷԵ��
			$j++;
			$sql = "SELECT
sum(if(validate_datagroup.mistaken_id=1,num_point,0)) as error1,
sum(if(validate_datagroup.mistaken_id=2,num_point,0)) as error2,
validate_checkdata.staffid
FROM
validate_checkdata
Inner Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id
WHERE datecal ='$xsdate'
group by staffid";
		//echo  $sql."<br>";
		$result = mysql_db_query($dbnameuse,$sql);
			while($rs = mysql_fetch_assoc($result)){
				$sql_update = "REPLACE INTO temp_report_keydata_error SET datekeyin='$xsdate',staffid='$rs[staffid]',structure_error='$rs[error2]',keydata_error='$rs[error1]'";
				mysql_db_query($dbnameuse,$sql_update);
			}// end while($rs = mysql_fetch_assoc($result)){
			$last_date = $xsdate;
			}//end if($xFTime['wday'] != "0"){
		}//end for($i=0;$i<$length_var;$i++){
			$def_day = $length_var - $j; // �Ҽŵ�ҧ�ͧ�ѹ
			if($def_day > 0){ // �ó����ѹ�ç�Ѻ�ѹ�ҷԵ���ͧ�����ѹ���ӹǳ��ա 1 �ѹ
				for($n=1;$n<=$def_day;$n++){
					
					$xbasedate = strtotime("$last_date");
					$xdate = strtotime("-$n day",$xbasedate); // ��͹��ѧ�
					$xsdate = date("Y-m-d",$xdate);// �ѹ��͹��ѧ
					$sql = "SELECT
sum(if(validate_datagroup.mistaken_id=1,num_point,0)) as error1,
sum(if(validate_datagroup.mistaken_id=2,num_point,0)) as error2,
validate_checkdata.staffid
FROM
validate_checkdata
Inner Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id
WHERE datecal ='$xsdate'
group by staffid";
					$result = mysql_db_query($dbnameuse,$sql);
					while($rs = mysql_fetch_assoc($result)){
					
					$sql_update = "REPLACE INTO temp_report_keydata_error SET datekeyin='$xsdate',staffid='$rs[staffid]',structure_error='$rs[error2]',keydata_error='$rs[error1]'";
					mysql_db_query($dbnameuse,$sql_update);
					}// end while($rs = mysql_fetch_assoc($result)){
				}//end for($n=0;$n<$def_day){	
			}//end if($def_day > 0){
		
}//end function PorcessUserKeyPointError(){


//$get_data = "2010-04-07";
//PorcessUserKeyPointError($get_data);<br>

function ShowDataKeyError($get_data){
		global $dbnameuse,$length_var,$group_type;
		$j=0;
		for($i=0;$i<$length_var;$i++){
			$xbasedate = strtotime("$get_data");
			$xdate = strtotime("-$i day",$xbasedate); // ��͹��ѧ�
			$xsdate = date("Y-m-d",$xdate);// �ѹ��͹��ѧ
			$arr_d1 = explode("-",$xsdate);
			$xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d1[1]), intval($arr_d1[2]), intval($arr_d1[0]))));
			if($xFTime['wday'] != "0"){  ###  ��Ǩ�ͺ�ó�������ѹ�ҷԵ��
			//echo $xsdate."<br>";
			$j++;
			## �ó�㹡�õ�ͧ����ʴ���ѡ�ҹ������������͡�����
			if($group_type == "all" or $group_type == ""){
			$sql = "SELECT * FROM temp_report_keydata_error WHERE  datekeyin='$xsdate'";
			}else{ // �ó����͡����� A , B , C  
			$sql = "SELECT
temp_report_keydata_error.datekeyin,
temp_report_keydata_error.staffid,
temp_report_keydata_error.structure_error,
temp_report_keydata_error.keydata_error,
temp_report_keydata_error.timeupdate,
keystaff.keyin_group
FROM
temp_report_keydata_error
Inner Join keystaff ON temp_report_keydata_error.staffid = keystaff.staffid
WHERE
temp_report_keydata_error.datekeyin =  '$xsdate' AND
keystaff.keyin_group =  '$group_type'";
			}//end if($group_type == "all" or $group_type == ""){
			//echo $sql."<br>";
			$result = mysql_db_query($dbnameuse,$sql);
				while($rs = mysql_fetch_assoc($result)){
						$arr[$xsdate][$rs[staffid]]['s_error'] = $rs[structure_error];
						$arr[$xsdate][$rs[staffid]]['k_error'] = $rs[keydata_error];
				}//end while($rs = mysql_fetch_assoc()){
				$last_date = $xsdate;
			}//end if($xFTime['wday'] != "0"){ 
		}//end for($i=0;$i<$length_var;$i++){
		### �óյç�Ѻ�ѹ�ҷԵ����еѴ�ѹ�ҷԵ���͡
		$def_day = $length_var - $j; // �Ҽŵ�ҧ�ͧ�ѹ
			if($def_day > 0){ // �ó����ѹ�ç�Ѻ�ѹ�ҷԵ���ͧ�����ѹ���ӹǳ��ա 1 �ѹ
				for($n=1;$n<=$def_day;$n++){
					//echo $last_date."<br>";
					$xbasedate = strtotime("$last_date");
					$xdate = strtotime("-$n day",$xbasedate); // ��͹��ѧ�
					$xsdate = date("Y-m-d",$xdate);// �ѹ��͹��ѧ
					//echo $xsdate."<br>";
					if($group_type == "all" or $group_type == ""){
						$sql = "SELECT * FROM temp_report_keydata_error WHERE  datekeyin='$xsdate'";
					}else{
						$sql = "SELECT
temp_report_keydata_error.datekeyin,
temp_report_keydata_error.staffid,
temp_report_keydata_error.structure_error,
temp_report_keydata_error.keydata_error,
temp_report_keydata_error.timeupdate,
keystaff.keyin_group
FROM
temp_report_keydata_error
Inner Join keystaff ON temp_report_keydata_error.staffid = keystaff.staffid
WHERE
temp_report_keydata_error.datekeyin =  '$xsdate' AND
keystaff.keyin_group =  '$group_type'";
					}
					//echo $sql."<br>";
					$result = mysql_db_query($dbnameuse,$sql);
						while($rs = mysql_fetch_assoc($result)){
							$arr[$xsdate][$rs[staffid]]['s_error'] = $rs[structure_error];
							$arr[$xsdate][$rs[staffid]]['k_error'] = $rs[keydata_error];
						}//end while($rs = mysql_fetch_assoc($result)){
				}// end for($n=0;$n<$def_day;$n++){
			}//end if($def_day > 0){
	//	echo "<pre>";
		//print_r($arr);
	return $arr;
}//end function ShowDataKeyError(){ 

function ShowNumQc($get_date){
	global $dbnameuse,$length_var,$group_type;
				$j=0;
				for($i=0;$i<$length_var;$i++){
					$xbasedate = strtotime("$get_date");
					$xdate = strtotime("-$i day",$xbasedate); // ��͹��ѧ�
						$xsdate = date("Y-m-d",$xdate);// �ѹ��
						$arr_d1 = explode("-",$xsdate);
					$xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d1[1]), intval($arr_d1[2]), intval($arr_d1[0]))));
					if($xFTime['wday'] != "0"){  ###  ��Ǩ�ͺ�ó�������ѹ�ҷԵ��
					$j++;
					$last_date = $xsdate;
					}
					
				}//end for($i=0;$i<$length_var;$i++){
						$def_day = $length_var - $j; // �Ҽŵ�ҧ�ͧ�ѹ
			if($def_day > 0){ // �ó����ѹ�ç�Ѻ�ѹ�ҷԵ���ͧ�����ѹ���ӹǳ��ա 1 �ѹ
				for($n=1;$n<=$def_day;$n++){
					//echo $last_date."<br>";
					$xbasedate = strtotime("$last_date");
					$xdate = strtotime("-$n day",$xbasedate); // ��͹��ѧ�
					$xsdate = date("Y-m-d",$xdate);// �ѹ��͹��ѧ
					$min_date = $xsdate;
				}	
				}//end if($def_day > 0){
	if($group_type == "all" or $group_type == ""){	
		$sql = "SELECT count(staffid) as numstaff,staffid 
	FROM `temp_report_keydata_error` 
	where datekeyin between '$min_date' AND '$get_date'
	group by staffid
	";
		}else{
	$sql = "SELECT count(temp_report_keydata_error.staffid) as numstaff,temp_report_keydata_error.staffid 
FROM `temp_report_keydata_error` 
Inner Join keystaff ON temp_report_keydata_error.staffid = keystaff.staffid where temp_report_keydata_error.datekeyin between '$min_date' AND '$get_date' AND keystaff.keyin_group='$group_type' group by staffid 
";
		}// end 	if($group_type == "all" or $group_type == ""){	
		//echo "$sql<br>";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$numarr[$rs[staffid]] = $rs[numstaff];
	}
	return $numarr;
}//end function ShowNumQc(){
	
function ShowBetWeenDate($get_date){
	global $length_var;
		$get_xdate = DateSaveDB($get_date);
				$j=0;
			for($i=0;$i<$length_var;$i++){
					$xbasedate = strtotime("$get_xdate");
					$xdate = strtotime("-$i day",$xbasedate); // ��͹��ѧ�
					$xsdate = date("Y-m-d",$xdate);// �ѹ��
					$arr_d1 = explode("-",$xsdate);
					$xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d1[1]), intval($arr_d1[2]), intval($arr_d1[0]))));
					if($xFTime['wday'] != "0"){  ###  ��Ǩ�ͺ�ó�������ѹ�ҷԵ��
					$j++;
					$last_date = $xsdate;
					
					}
					
			}//end for($i=0;$i<$length_var;$i++){
				$def_day = $length_var - $j; // �Ҽŵ�ҧ�ͧ�ѹ
				//echo " $length_var ::  $j :: $last_date";
			if($def_day > 0){ // �ó����ѹ�ç�Ѻ�ѹ�ҷԵ���ͧ�����ѹ���ӹǳ��ա 1 �ѹ
					for($n=1;$n<=$def_day;$n++){
					//echo $last_date."<br>";
						$xbasedate = strtotime("$last_date");
						$xdate = strtotime("-$n day",$xbasedate); // ��͹��ѧ�
						$xsdate = date("Y-m-d",$xdate);// �ѹ��͹��ѧ
						$min_date = $xsdate;
						//echo "min date :: ".$min_date."<br>";
					}	//end 	for($n=1;$n<=$def_day;$n++){
				}//end if($def_day > 0){	
	
			return thaidate($min_date)." �֧ ".thaidate($get_xdate);
}//end function ShowBetWeenDate(){
### �����ż�

function ShowKpointStaff($get_date,$get_staffid){
	global $dbnameuse,$length_var;
	
					$get_xdate = DateSaveDB($get_date);
					$xbasedate = strtotime("$get_xdate");
					$xdate = strtotime("-$length_var day",$xbasedate); // ��͹��ѧ�
					$xsdate = date("Y-m-d",$xdate);// �ѹ��
	$sql = "SELECT
avg(stat_user_keyin.numkpoint) as sump
FROM `stat_user_keyin`
WHERE
stat_user_keyin.datekeyin BETWEEN  '$xsdate' AND '$get_xdate' 
AND
stat_user_keyin.staffid =  '$get_staffid'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return number_format($rs[sump],2);	
}//end function ShowKpointStaff(){



		$xdate = DateSaveDB($keydate);
		PorcessUserKeyPointError($xdate); // �����ż����
		$arr_data = ShowDataKeyError($xdate);
		$arr_num = ShowNumQc($xdate);

	
	//echo "<pre>";
	//print_r($arr_num);
	$numline=0;
	 if(count($arr_data) > 0){
				foreach($arr_data as $k => $v){ 
				$numline++;
				}
	 }// end �Ѻ�ӹǹ column
	 
	$numline = $numline*4; // ��� 4 ��� �ӹǹ columns ����
	
	


?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<link href="../../common/gs_sortable.css" />
<script src="../../common/gs_sortable.js"></script>
<script language="javascript">

</script>
</HEAD>
<BODY >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px" >��§ҹ��ػ��ͼԴ��Ҵ�ͧ��ѡ�ҹ�ѹ�֡������</td>
        </tr>
		   <tr>
          <td class="headerTB"><form name="form1" method="post" action="">
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="14%" align="right"><strong>���͡�ѹ�������ش : </strong></td>
                <td width="86%" align="left"><INPUT name="keydate" onFocus="blur();" value="<?=$keydate?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.keydate, 'dd/mm/yyyy')"value="�ѹ��͹��">
            &nbsp;&nbsp; <label>
              <input type="submit" name="button2" id="button" value="�������ͻ����ż��ա����">
            </label>
            </td>
              </tr>
              <tr>
                <td align="right" valign="top"><strong>��͸Ժ�� : </strong></td>
                <td align="left">������͡�ѹ����ش����ͧ��ô٢����� �� ���͡�ѹ��� 7 ����¹ 2553 ��§ҹ���ʴ������ŵ�����ѹ��� 1-7 ����¹ ���Ͷ�ҵ�ͧ��û����ż������ա�������͡�������ͻ����ż��ա����<br>
                  	* �ҵðҹ 1 �ش<br> �Դ�ç���ҧ����Թ <?=$structure_key?> �ش<br>
                  �����Դ �����Թ <?=$keydata_key?> �ش <br>                  
                  <br></td>
              </tr>
            </table>
          </form></td>
        </tr>
		   <tr>
		     <td class="headerTB"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		       <tr>
		         <td>
		           <table width="100%" border="0" cellspacing="0" cellpadding="0">
		             <tr>
		               <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
		                 <tr>
		                   <td colspan="<? echo 13+$numline;?>" bgcolor="#A5B2CE"><a href="?group_type=1&keydate=<?=$keydate?>"><strong>����� A</strong></a><strong> || <a href="?group_type=2&keydate=<?=$keydate?>">����� B</a> || <a href="?group_type=3&keydate=<?=$keydate?>">����� C</a> || <a href="?group_type=4&keydate=<?=$keydate?>">parttime</a> || <a href="?group_type=all&keydate=<?=$keydate?>">������</a></strong><a href="?group_type=all&keydate=<?=$keydate?>"></a></td>
	                      </tr>
		                 <tr>
		                   <td colspan="<? echo 13+$numline;?>" bgcolor="#A5B2CE"><strong>��§ҹ��ػ��ͼԴ��Ҵ������ѹ���  <?=ShowBetWeenDate($keydate)?></strong></td>
	                      </tr>
		                 <tr>
		                   <td colspan="<? echo 13+$numline;?>" align="center" bgcolor="#A5B2CE"><table width="50%" border="0" cellspacing="0" cellpadding="0">
		                     <tr>
		                       <td align="center" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="2">
		                         <tr>
		                           <td width="42%" rowspan="2" bgcolor="#A5B2CE">&nbsp;</td>
		                           <td colspan="2" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ�ش</strong></td>
		                           </tr>
		                         <tr>
		                           <td width="28%" align="center" bgcolor="#A5B2CE"><strong>�ç���ҧ(�ش)</strong></td>
		                           <td width="30%" align="center" bgcolor="#A5B2CE"><strong>�����Դ(�ش)</strong></td>
		                           </tr>
		                         <tr>
		                           <td align="right" bgcolor="#A5B2CE"><strong>�٧����ࡳ��</strong></td>
		                           <td align="center" bgcolor="#A5B2CE"><p id=s_key></p></td>
		                           <td align="center" bgcolor="#A5B2CE"><p id=k_key></p></td>
		                           </tr>
		                         <tr>
		                           <td align="right" bgcolor="#A5B2CE"><strong>��ӡ���ࡳ��</strong></td>
		                           <td align="center" bgcolor="#A5B2CE"><p id=s_key1></p></td>
		                           <td align="center" bgcolor="#A5B2CE"><p id=k_key1></p></td>
		                           </tr>
		                         </table></td>
		                       </tr>
	                        </table></td>
	                      </tr>
		                 <tr>
		                   <td width="5%" rowspan="3" align="center" bgcolor="#A5B2CE"><strong>�ӴѺ</strong></td>
		                   <td width="20%" rowspan="3" align="center" bgcolor="#A5B2CE"><strong>���;�ѡ�ҹ<br>
	                        ���������</strong></td>
		                   <td width="5%" rowspan="3" align="center" bgcolor="#A5B2CE"><strong>�����</strong></td>
		                   <td width="6%" rowspan="3" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ�ش QC</strong></td>
                           <?
                           	 if(count($arr_data) > 0){
								  	foreach($arr_data as $k => $v){ 
						   ?>
		                   <td colspan="4" align="center" bgcolor="#A5B2CE"><strong>�ѹ��� <? echo thaidate($k);?></strong></td>
                           <?
									}//end foreach($arr_data as $k => $v){ 
							 }//end  if(count($arr_data) > 0){
						   ?>
		                   <td width="6%" rowspan="3" align="center" bgcolor="#999999"><strong>��������<br>
		                     ��ṹ<br>
		                     ��������</strong></td>
		                   <td colspan="4" align="center" bgcolor="#999999"><strong>��ػ��ͼԴ��Ҵ</strong></td>
	                      </tr>
		                 <tr>
                         <?
                         	 if(count($arr_data) > 0){
								  	foreach($arr_data as $k => $v){ 
						 ?>
		                   <td colspan="2" align="center" bgcolor="#A5B2CE"><strong>�Դ�ç���ҧ</strong></td>
		                   <td colspan="2" align="center" bgcolor="#A5B2CE"><strong>�����Դ</strong></td>
                            <?
									}//end foreach($arr_data as $k => $v){ 
							 }//end  if(count($arr_data) > 0){
						   ?>

		                   <td align="center" bgcolor="#999999"><strong>�Դ�ç���ҧ</strong></td>
		                   <td align="center" bgcolor="#999999">&nbsp;</td>
		                   <td colspan="2" align="center" bgcolor="#999999"><strong>�����Դ</strong></td>
	                      </tr>
		                 <tr>
                         <?
                          if(count($arr_data) > 0){
								  	foreach($arr_data as $k => $v){ 
						 ?>
		                   <td width="7%" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ</strong></td>
		                   <td width="7%" align="center" bgcolor="#A5B2CE"><strong>%</strong></td>
		                   <td width="7%" align="center" bgcolor="#A5B2CE"><strong>�ӹǹ</strong></td>
		                   <td width="7%" align="center" bgcolor="#A5B2CE"><strong>%</strong></td>
		                   <?
									}//end 	foreach($arr_data as $k => $v){ 
						  }//end   if(count($arr_data) > 0){
						   ?>

		                   <td width="8%" align="center" bgcolor="#999999"><strong>�ӹǹ</strong></td>
		                   <td width="7%" align="center" bgcolor="#999999"><strong>%</strong></td>
		                   <td width="8%" align="center" bgcolor="#999999"><strong>�ӹǹ</strong></td>
		                   <td width="7%" align="center" bgcolor="#999999"><strong>%</strong></td>
	                      </tr>
                          <?
						  if($group_type == "all" or $group_type == ""){
							  	$conW = " WHERE  keystaff.keyin_group > 0 ORDER BY  keystaff.keyin_group ASC,staffname ASC ";
						  }else{
							 	$conW = " WHERE  keystaff.keyin_group='$group_type'  ORDER BY staffname ASC "; 
							}
                          	$sql_show = "SELECT
keystaff.staffid,
keystaff.staffname,
keystaff.staffsurname,
keystaff.keyin_group,
keystaff.prename,
keystaff_group.groupname
FROM
keystaff
Inner Join keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id
 $conW ";
							$result_show = mysql_db_query($dbnameuse,$sql_show);
								$i=0;
								$sum_s_key = 0;
								$sum_k_key = 0;
								$sum_percen1=0;
								$numP1 = 0;
								$sum_percen2=0;
								$numP2 = 0;
							while($rss = mysql_fetch_assoc($result_show)){
								if($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
						  ?>
		                 <tr bgcolor="<?=$bg?>">
		                   <td align="center"><?=$i?></td>
		                   <td align="left" nowrap><? echo "$rss[prename]$rss[staffname]  $rss[staffsurname]";?></td>
		                   <td align="left" nowrap><? echo "$rss[groupname]";?></td>
		                   <td align="center"><? echo number_format($arr_num[$rss[staffid]]);?></td>
                               <? if(count($arr_data) > 0){
							  // echo $arr_data;
							    	 foreach($arr_data as $k => $v){ 
								
									  $percen1 = ($arr_data[$k][$rss[staffid]]['s_error']*100)/$structure_key;
									 $percen2 = ($arr_data[$k][$rss[staffid]]['k_error']*100)/$keydata_key;
									 if($percen1 >= 100){
										$bg1 = "#FF0000"; 
										$s_xsum1++;
									}else{
										$bg1 = $bg;	
										$s_xsum2++;
									}
									
									if($percen2 >= 100){
										$bg2= "#FF0000";
										$k_xsum3++;
									}else{
										$bg2 = $bg;	
										$k_xsum4++;
									}
									####  
									$sum_s_key += $arr_data[$k][$rss[staffid]]['s_error']; // �ӹǹ���Դ�ç���ҧ�����ǧ����
									$sum_k_key += $arr_data[$k][$rss[staffid]]['k_error']; // �ӹǹ�������Դ�����ǧ����
									
									
									##  �ӹǹ
									if($arr_data[$k][$rss[staffid]]['s_error'] > 0){
											$sum_percen1 += $percen1;
											$numP1++;
									}//end if($arr_data[$k][$rss[staffid]]['s_error'] > ){
									if($arr_data[$k][$rss[staffid]]['k_error'] > 0){
											$sum_percen2 += $percen2;
											$numP2++;
									}//end if($arr_data[$k][$rss[staffid]]['s_error'] > ){
							   
							   ?>
		                   <td align="center"><? echo number_format($arr_data[$k][$rss[staffid]]['s_error']);?></td>
		                   <td align="center" bgcolor="<?=$bg1?>"><? echo number_format(($arr_data[$k][$rss[staffid]]['s_error']*100)/$structure_key);?></td>
		                   <td align="center"><? echo number_format($arr_data[$k][$rss[staffid]]['k_error']);?></td>
		                   <td align="center" bgcolor="<?=$bg2?>"><? echo number_format(($arr_data[$k][$rss[staffid]]['k_error']*100)/$keydata_key);?></td>
                           <?
									 }//end foreach($arr_data as $k => $v){  
								}//end if(count($arr_data) > 0){
								
								$showpercen1 = $sum_percen1/$numP1;
							    $showpercen2 = $sum_percen2/$numP2;
								if($showpercen1 >= 100){
									$xbg1 = "#FF0000";
								}else{
									$xbg1 = $bg;	
								}
								if($showpercen2 >= 100){
									$xbg2 = "#FF0000";
								}else{
									$xbg2 = $bg;	
								}
								
								
								$avg_point = ShowKpointStaff($keydate,$rss[staffid]);// ��Ҥ�ṹ�����������
								
								if($avg_point < $base_point){
										$bgx = "#FF0000";
								}else{
										$bgx = $bg;
								}
						   ?>
                           	<td align="center" bgcolor="<?=$bgx?>"><? echo number_format($avg_point,2);?></td>
		                   <td align="center" bgcolor="#999999"><?=number_format($sum_s_key);?></td>
		                   <td align="center" bgcolor="<?=$xbg1?>"><?= number_format($showpercen1)?>%</td>
		                   <td align="center" bgcolor="#999999"><?=number_format($sum_k_key);?></td>
		                   <td align="center" bgcolor="<?=$xbg2?>"><?= number_format($showpercen2)?>%</td>
	                      </tr>
                          <?
						  $sum_kpoint = 0;
						  $sum_s_key = 0;
						  $sum_k_key = 0;
						  $showpercen1 = 0;
						  $showpercen2 = 0;
						  $sum_percen1 = 0;
						  $sum_percen2 = 0;
						  $numP1 = 0;
						  $numP2 = 0;
						  $numline1 = 0;
						  $avg_point = 0;
							}//end while($rss = mysql_fetch_assoc($result_show)){
						  ?>
	                   </table></td>
                     </tr>
                   </table>
	             </td>
	           </tr>
	         </table></td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
<script language="javascript">
document.getElementById('s_key').innerHTML = <?=number_format($s_xsum1)?>;
document.getElementById('k_key').innerHTML = <?=number_format($k_xsum3)?>;
document.getElementById('s_key1').innerHTML = <?=number_format($s_xsum2)?>;
document.getElementById('k_key1').innerHTML = <?=number_format($k_xsum4)?>;

</script>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>