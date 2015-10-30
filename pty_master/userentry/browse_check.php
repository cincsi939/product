<?
$ApplicationName	= "diagnostic";
$module_code 		= "diagnostic"; 
$process_id			= "diagnostic";
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
	## Modified Detail :		ระบบตรวจสอบรับรองความถูกต้องของข้อมูล
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
$time_start = getmicrotime();
if($profile_id == ""){
		$profile_id = LastProfile();
}// end if($profile_id == ""){

	if($_SERVER['REQUEST_METHOD'] == "POST"){
			if($Aaction == "SAVE1"){ // บันทึกกรณีมีคนเดียว
				$sql_update = "UPDATE tbl_assign_key SET approve='2', comment_approve='$comment_approve1',staff_apporve='".$_SESSION['session_staffid']."' WHERE idcard='$idcard' AND siteid='$xsiteid'";
				//echo $sql_update."<br>";die;
				$result_update = mysql_db_query($db_name,$sql_update);
					if($result_update){
							echo "<script>alert('รับรองความถูกต้องของข้อมูลเรียบร้อยแล้ว'); location.href='?key_action=&action=browse_check&profile_id=$profile_id';</script>";
							exit();
					}
			}else if($Aaction == "SAVE2"){ // บันทึกกรณีมีหลายคน
				if(count($xapprove) > 0){
						foreach($xapprove as $key => $val){
							$sql_update = "UPDATE tbl_assign_key SET approve='2', comment_approve='$comment_approve[$key]',staff_apporve='".$_SESSION['session_staffid']."' WHERE idcard='$key' and siteid='$val' ";
							//echo $sql_update."<br>";
						mysql_db_query($db_name,$sql_update);
						}//end foreach($xapprove as $key => $val){
//die;
							echo "<script>alert('รับรองความถูกต้องของข้อมูลเรียบร้อยแล้ว'); location.href='?key_action=&action=browse_check&profile_id=$profile_id';</script>";
							exit();
				}//end if(count($xapprove) > 0){
			}// end if($Aaction == "SAVE1"){
			
	}//end if($_SERVER['REQUEST_METHOD'] == "POST"){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>ตรวจสอบข้อผิดพลาดการบันทึกข้อมูล</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
    <style type="text/css">

    .mouseOut {
    background: #708090;
    color: #FFFAFA;
    }

    .mouseOver {
    background: #FFFAFA;
    color: #000000;
    }
    
	body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
    <script type="text/javascript">        
        var xmlHttp;
        var completeDiv;
        var inputField;
        var nameTable;
        var nameTableBody;
		var p;
		var name=new String();

        function createXMLHttpRequest() {
            if (window.ActiveXObject) {
                xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            else if (window.XMLHttpRequest) {
                xmlHttp = new XMLHttpRequest();                
            }
        }

        function initVars() {
            inputField = document.getElementById("txtnames");            
            nameTable = document.getElementById("name_table");
            completeDiv = document.getElementById("popup");
            nameTableBody = document.getElementById("name_table_body");
        }

        function findNames() {
            initVars();
            if (inputField.value.length > 0) {
                createXMLHttpRequest();            
                var url = "CompleteData.php?names=" + inputField.value;                        
                xmlHttp.open("GET", url, true);
                xmlHttp.onreadystatechange = callback;
                xmlHttp.send(null);
            } else {
                clearNames();
            }
        }

        function callback() {
            if (xmlHttp.readyState == 4) {
                if (xmlHttp.status == 200) {
				    name =  document.getElementById("popup").innerHTML = xmlHttp.responseText;
					setNames();
                } else if (xmlHttp.status == 204){
                    clearNames();
                }
            }
        }
        
        function setNames() {         
           	p = name.split(",");  
            clearNames();
   	        var size = p.length;
            setOffsets();
            var row, cell, txtNode;
            for (var i = 0; i < size; i++) {
                var nextNode =p[i] 
                row = document.createElement("tr");
                cell = document.createElement("td");
                
                cell.onmouseout = function() {this.className='mouseOver';};
                cell.onmouseover = function() {this.className='mouseOut';};
                cell.setAttribute("bgcolor", "#FFFAFA");
                cell.setAttribute("border", "0");
                cell.onclick = function() { populateName(this); } ;                             

                txtNode = document.createTextNode(nextNode);
                cell.appendChild(txtNode);
                row.appendChild(cell);
                nameTableBody.appendChild(row);
				
            }
        }

        function setOffsets() {
            var end = inputField.offsetWidth;
            var left = calculateOffsetLeft(inputField);
            var top = calculateOffsetTop(inputField) + inputField.offsetHeight;

            nameTable.style.border = "black 1px solid";
            nameTable.style.left = left + "px";
            nameTable.style.top = top + "px";
            nameTable.style.width = end + "px";
        }
        
        function calculateOffsetLeft(field) {
          return calculateOffset(field, "offsetLeft");
        }

        function calculateOffsetTop(field) {
          return calculateOffset(field, "offsetTop");
        }

        function calculateOffset(field, attr) {
          var offset = 0;
          while(field) {
            offset += field[attr]; 
            field = field.offsetParent;
          }
          return offset;
        }

        function populateName(cell) {
            inputField.value = cell.firstChild.nodeValue;
            clearNames();
        }

        function clearNames() {
            var ind = nameTableBody.childNodes.length;
            for (var i = ind - 1; i >= 0 ; i--) {
                 nameTableBody.removeChild(nameTableBody.childNodes[i]);
            }
                 completeDiv.style.border = "none";
        }
		
		
function CheckFromSubmit(){

	var cnum = document.getElementById("num_checklist").value;	
		for(i=1;i <= cnum;i++){
				if( ((document.getElementById("xapprove"+i).checked == true) &&(document.getElementById("comment"+i).value == "")) && (document.getElementById("msgerr"+i).value != "")){
						alert("เนื่องจากผลการตรวจสอบการบันทึกข้อมูลจากระบบโดย script \nยังมีข้อมูลบางรายการที่ผิดพลาดอยู่ หากท่านต้องการยืนยันกรุณาใส่หมายเหตุการรับรองข้อมูลด้วย");
						document.getElementById("comment"+i).focus();
						return false;
				}
		}
	//alert(cnum);
	return true;
}
    </script>

</head>
<body>
<form action="" method="post"  name="form1" id="form1">
  <br />
  <table width="95%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr>
          <td colspan="3"><strong>ระบบตรวจสอบข้อมูลโดยระบบเพื่อยืนยันความถูกต้องของข้อมูล</strong></td>
          </tr>
        <tr>
          <td align="right"><b>ข้อมูล ณ วันที</b></td>
          <td align="left"><select name="profile_id" id="profile_id">
          <option value="">เลือกโฟล์ไฟล์</option>
      	<?
		$sql_profile  = "SELECT * FROM tbl_checklist_profile ORDER BY profile_date DESC ";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		while($rsp = mysql_fetch_assoc($result_profile)){
			if($rsp[profile_id] == $profile_id){ $sel = "selected='selected'";}else{ $sel = "";}
		?>
		<option value="<?=$rsp[profile_id]?>" <?=$sel?>><?=$rsp[profilename]?></option>
		<?
		}//end action=&lv=2&xsiteid=$rs[siteid]&schoolid
		?>
        </select></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="right"><strong>เขตพื้นที่การศึกษา : </strong></td>
          <td><label>
            <select name="key_siteid" id="key_siteid">
            <option value=""> เลือกเขตพื้นที่การศึกษา</option>
            <?
            	$sql_area = "SELECT
eduarea.secid,
eduarea.secname,
if(substring(eduarea.secid,1,1) ='0',cast(secid as SIGNED),9999) as idsite
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
group_type='keydata'  group by eduarea.secid ORDER BY idsite, eduarea.secname";
				$result_area = mysql_db_query($dbnamemaster,$sql_area);
				while($rs_a = mysql_fetch_assoc($result_area)){
					if($key_siteid == $rs_a[secid]){ $sel = "selected='selected'";}else{ $sel = "";}
						echo "<option value='$rs_a[secid]' $sel>$rs_a[secname]</option>";
				}
			?>
            </select>
          </label></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="33%" align="right"><strong>เลขบัตรประชาชน : </strong></td>
          <td width="34%"><label>
            <input name="key_idcard" type="text" id="key_idcard" size="25" value="<?=$key_idcard?>">
          </label></td>
          <td width="33%">&nbsp;</td>
          </tr>
        <tr>
          <td align="right"><strong>ชื่อ : </strong></td>
          <td><label>
            <input name="key_name" type="text" id="key_name" size="25" value="<?=$key_name?>">
          </label></td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td align="right"><strong>นามสกุล : </strong></td>
          <td><label>
            <input name="key_surname" type="text" id="key_surname" size="25" value="<?=$key_surname?>">
          </label></td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td align="right"><strong>วันที่คีย์ข้อมูล : </strong></td>
          <td><INPUT name="date_key" onFocus="blur();" value="<?=$date_key?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.date_key, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="right"><strong>พนักงานคีย์ข้อมูล :</strong></td>
          <td><label>
            <select name="key_staffid" id="key_staffid">
            <option value="">เลือกชื่อพนักงานบันทึกข้อมูล</option>
            <?
            	$sql_staff = "SELECT * FROM keystaff WHERE status_permit='YES' AND sapphireoffice='0' AND status_extra <> 'QC' ORDER BY staffname ASC";
				$result_staff = mysql_db_query($db_name,$sql_staff);
				while($rs_staff = mysql_fetch_assoc($result_staff)){
					if($rs_staff[staffid] == $key_staffid){ $sel = "selected='selected'";}else{ $sel = "";}
					$staffname = "$rs_staff[prename]$rs_staff[staffname]  $rs_staff[staffsurname]";
					echo "<option value='$rs_staff[staffid]' $sel>$staffname</option>";
						
				}
			?>
            </select>
          </label></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td><label>
            <input type="submit" name="button" id="button" value="ค้นหา" />
            <input type="button" name="tbnC" value="ล้างค่า" onclick="location.href='?key_action=&action=browse_check'" />
            <input type="hidden" name="key_action" value="search" />
            
          </label></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <? if($key_action == "search"){ 
		
		
	$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
	$e			= (!isset($e) || $e == 0) ? 5 : $e ;
	$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 

			
				 if($key_siteid != ""){
						 $conv .= " and  t2.siteid = '$key_siteid'";
				}
				if($key_idcard != ""){
						$conv .= " and  t2.idcard = '$key_idcard'";
				}
				
				if($key_name != ""){
						$conv .= " and  t2.fullname LIKE '%$key_name%'";
				}
				if($key_surname != ""){
						$conv .= " and  t2.fullname LIKE '%$key_surname%'";
				}
				if($date_key != ""){
					$arrd = explode("/",$date_key);
					$xdate_key = ($arrd[2]-543)."-".$arrd[1]."-".$arrd[0];
					$condate = " AND t1.timeupdate LIKE '$xdate_key%'";
						
				}
				if($key_staffid != ""){
					$con_staff = " AND t1.staffid =  '$key_staffid'";
				}
				
				
/*				$sql_search1 = "SELECT distinct tbl_assign_key.idcard FROM  tbl_assign_key WHERE  tbl_assign_key.nonactive = '0' 
  $conv ";
				$result_search1 = mysql_db_query($db_name,$sql_search1);
				while($rss1 = mysql_fetch_assoc($result_search1)){
					if($in_idcard > "") $in_idcard .= ",";
					$in_idcard .= "'$rss1[idcard]'";
				}//end while($rss1 = mysql_fetch_assoc($result_search1)){
					if($in_idcard == ""){ $in_idcard = "''";}
*/				
				/* $sql_search = "SELECT distinct tbl_assign_key.idcard, tbl_assign_key.fullname, tbl_assign_key.siteid,monitor_keyin.staffid  FROM tbl_assign_key
Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard WHERE
tbl_assign_key.nonactive =  '0' and tbl_assign_key.approve <> '2'  $conv  $condate  $con_staff  order by fullname ASC";*/
//$sql_search = "SELECT distinct monitor_keyin.idcard, monitor_keyin.keyin_name as fullname, monitor_keyin.siteid,monitor_keyin.staffid  FROM monitor_keyin
//where monitor_keyin.idcard IN($in_idcard) AND monitor_keyin.idcard <> '' $condate $con_staff  order by fullname ASC ";
//echo $sql_search;
$sql_search = "SELECT distinct t1.idcard, t1.keyin_name as fullname, t1.siteid,t2.staffid,t2.userkey_wait_approve as staffapprove
FROM
monitor_keyin as t1
Inner Join tbl_assign_key as t2 ON t1.idcard = t2.idcard AND t1.siteid = t2.siteid 
AND t2.approve <> '2' AND t2.profile_id = '$profile_id'
WHERE t1.idcard <> '' $condate $conv ORDER BY fullname ASC
";
echo $sql_search;

		$xresult = mysql_db_query($db_name,$sql_search);
		$all= @mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
		
	if($page <= $allpage){
			$sql_search .= " LIMIT $i, $e";
	}else if($page == $xpage){
		$i=0;
			$sql_search .= " ";
	}else{
			$sql_search .= " LIMIT $i, $e";
	}


				$result_search = mysql_db_query($db_name,$sql_search);
				$num_search = @mysql_num_rows($result_search);
		
				$search_sql = $sql_search ; 
				//echo $num_search;
				if($num_search < 1){
					echo "<tr><td colspan='3' align='center'><b> - ไมพบรายการที่ค้นหา - </b></td></tr>";
				}else if($num_search == "1"){
				
				
				$rs = mysql_fetch_assoc($result_search);
				$dbsite = STR_PREFIX_DB.$rs[siteid];
				
				####  ตรวจสอบความสมบูรณ์ของข้อมูล
				$dbsite = STR_PREFIX_DB.$rs[siteid];
				$date_profile =  DateProfile($rs[idcard],$rs[siteid]);// วันที่จัดทำข้อมูล
				$arrdata = ProcessQCData($rs[siteid],$rs[idcard],$profile_id);				
				$num_error = count($arrdata);
				##### end ตรวจสอบความสมบูรณ์ของข้อมูล

				$staffname = ShowStaffKey($rs[staffid]);

				 if($num_error < 1){
					$xmsg = "ผลการตรวจสอบความถูกต้องข้องข้อมูล ผ่าน ";	
					//$disx = "";
				}else{
					$xmsg = " เกิดความผิดพลาดในการคีย์ข้อมูล";	
					//$disx = " disabled='disabled'";
				}
				$xstrSql = "SELECT id,idcard,prename_th,name_th,surname_th, siteid,schoolid, position_now FROM general WHERE id='$rs[idcard]'";
				$xresult = mysql_db_query($dbsite,$xstrSql);
				$xrs = mysql_fetch_assoc($xresult);
				$pathfile = "../../../../../edubkk_kp7file/$xrs[siteid]/$xrs[idcard]".".pdf";
				
				if(CheckTrueData($rs[idcard],$rs[staffid]) > 0){
								$img_c = "<img src=\"../../../validate_management/images/award_star_silver_2.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"สถานะการผ่านการบันทึกการตรวจข้อมูล\">";
				}else{
								$img_c = "";	
				}
		
		?>
        <tr><td colspan="3" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="300" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="35" class="table2">&nbsp;</td>
            </tr>
        </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="50%" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="7%" align="center"><? echo "<a href='login_data.php?xname_th=$xrs[name_th]&xsurname_th=$xrs[surname_th]&xidcard=$xrs[idcard]&action=login&xsiteid=$xrs[siteid]' target='_blank'>";?><img src="../../../../images_sys/person.gif" width="16" height="13" border="0" alt="คลิ๊กเพื่อ login เข้าสู่ระบบ"><? echo "</a>";?></td>
                      <td width="93%" align="left"><?=$img_c?>&nbsp;<strong>ผลสรุปการตรวจสอบข้อมูล</strong> &nbsp;
					  <? $arrkp7 = GetPdfOrginal($xrs[idcard],$path_pdf,$imgpdf,"","pdf");
						echo $arrkp7['linkfile'];
						?>
                      &nbsp;<a href="../../hr_report/report_check/report_check_data.php?idcard=<?=$rs[idcard]?>&siteid=<?=$rs[siteid]?>&xtype=validate" target="_blank"><img src="../../../validate_management/images/zoom.png" width="16" height="16" / border="0" alt="หน้ารายงานเทียบ label กับ value"></a>&nbsp;<a href="validate_keydata.php?idcard=<?=$rs[idcard]?>&fullname=<?=$rs[fullname]?>&staffname=<?=$staffname?>&staffid=<?=$rs[staffid]?>&xsiteid=<?=$rs[siteid]?>" target="_blank"><img src="../../../validate_management/images/cog_edit.png" width="16" height="16" border="0" alt="คลิ๊กเพื่อบันทึกความผิดพลาดการบันทึกข้อมูล"></a> <a href="../../hr_report/kp7_qc.php?id=<?=$rs[idcard]?>&sentsecid=<?=$rs[siteid]?>" target="_blank"><img src="../../../../application/hr3/hr_report/bimg/pdf.gif" width="16" height="16" border="0" title="ปริ้นเอกสารเพื่อตรวจคำผิด" ></a></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td colspan="2" align="center" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td width="24%" align="center" valign="top"><?
                  		$sql_showpic="select yy,imgname from general_pic where id='$rs[idcard]' and kp7_active='1' order by no  DESC ";
						$query=mysql_db_query($dbsite,$sql_showpic)or die("cannot query".mysql_error());
						$num=mysql_num_rows($query);
						
						if($num==0){
							echo "<img src=\"../../../../images_sys/noimage.jpg\">";
						}else{
							$rp=mysql_fetch_assoc($query);
							echo "<img src=\"../../../../../image_file/$rs[siteid]/$rp[imgname]\" width=120 height=160 >";
						}//end if($num==0){
                  
                  		
                  ?></td>
                  <td width="76%" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                      <td width="22%" align="right" bgcolor="#FFFFFF"><strong>รหัสบัตรประชาชน : </strong></td>
                      <td width="51%" align="left" bgcolor="#FFFFFF"><?=$xrs[idcard]?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>ชื่อ - นามสกุล : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><? echo "$xrs[prename_th]$xrs[name_th]  $xrs[surname_th]";?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>ตำแหน่ง : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?=$xrs[position_now]?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>สังกัด : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?=ShowArea($xrs[siteid])."/".ShowSchool($xrs[schoolid]);?></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
              <td width="50%" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="7%" align="center"><strong><img src="../../../../images_sys/useronline.gif" width="20" height="20" /></strong></td>
                      <td width="93%"><strong>รายละเอียดผู้บันทึกข้อมูล</strong></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td colspan="2" align="center">&nbsp;</td>
                </tr>
                <?
              $sql_staff = "SELECT tbl_assign_sub.staffid, monitor_keyin.idcard, monitor_keyin.timeupdate, keystaff.prename, keystaff.staffname,
keystaff.staffsurname, keystaff.sapphireoffice, keystaff.image 
FROM tbl_assign_sub
Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid
WHERE  monitor_keyin.idcard =  '$rs[idcard]' AND tbl_assign_key.nonactive =  '0' ORDER BY monitor_keyin.timeupdate DESC LIMIT 1 ";
			$result_staff = mysql_db_query($db_name,$sql_staff);
			$rs_staff = mysql_fetch_assoc($result_staff);
				?>
                <tr>
                  <td width="31%" align="center" valign="top"><?
                  	if($rs_staff[image] != ""){
						echo "<img src=\"../../../userentry/images/personnel/$rs_staff[image]\" width=120 height=160>";	
					}else{
						echo "<img src=\"../../../../images_sys/noimage.jpg\">";	
					}
				  ?></td>
                  <td width="69%" align="center" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                      <td width="42%" align="right" bgcolor="#FFFFFF"><strong>ชื่อ-นามสกุล : </strong></td>
                      <td width="58%" align="left" bgcolor="#FFFFFF"><? echo "$rs_staff[prename]$rs_staff[staffname]  $rs_staff[staffsurname]";?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>วันที่บันทึกข้อมูล : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?=DateThai($rs_staff[timeupdate]);?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>ประเภทพนักงาน : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?=$arrstaff[$rs_staff[sapphireoffice]];?></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tr>
                  <td colspan="2" align="left"><strong><? echo $xmsg;?></strong></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <? 
				if($arrdata > 0){
					  $i=0;
					foreach($arrdata as $key => $val){	
						if($val != ""){
						 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
					?>
						<tr bgcolor="<?=$bg?>">
						  <td width="6%" align="center" valign="top"><?=$i?></td>
						  <td width="94%" align="left"><? echo "[Error Code : $key] $val";?></td>
						</tr>
						<?
						}//end if($val != ""){
					}//end foreach(){	  
			  }//end  if($arrdata > 0){
				  
			?>
              </table></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="20" align="left" valign="top">&nbsp;</td>
      </tr>
      </table></td></tr>
        <?

				} else{
		?>
        <tr>
          <td colspan="3" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td bgcolor="#999999"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="4%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
                  <td width="15%" align="center" bgcolor="#CCCCCC"><strong>รหัสบัตร</strong></td>
                  <td width="18%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล</strong></td>
                  <td width="17%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
                  <td width="20%" align="center" bgcolor="#CCCCCC"><strong>สังกัด</strong></td>
                  <td width="13%" align="center" bgcolor="#CCCCCC"><strong>ชื่อพนักงาน<br />
                    บันทึกข้อมูล</strong></td>
                  <td width="13%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
                </tr>
                <? 
				//$i=0;
				$j=0;
					while($rs = mysql_fetch_assoc($result_search)){
							 $dbsite = STR_PREFIX_DB.$rs[siteid];
							if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
							$sql1 = "SELECT position_now,schoolname FROM view_general WHERE CZ_ID='$rs[idcard]'";
							//echo $sql1;
							$result1 = mysql_db_query($dbsite,$sql1);
							$rs1 = mysql_fetch_assoc($result1);
							$pathfile = "../../../../../edubkk_kp7file/$rs[siteid]/$rs[idcard]".".pdf";
							if(is_file($pathfile)){
						$pdf_file = "<a href='$pathfile' target='_blank'><img src=\"../../../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"21\" alt=\"ตรวจสอบไฟล์ pdf ต้นฉบับ\" border='0'></a>";
							}else{
								$arrkp7 = GetPdfOrginal($rs[idcard],$path_pdf,$imgpdf,"","pdf");;
								$pdf_file =  $arrkp7['linkfile'];

								//$pdf_file = "";
							}//end if(is_file($pathfile)){
							
							$staffname = ShowStaffKey($rs[staffid]);
							## ผลการตรวจสอบข้อมูล
							if(CheckTrueData($rs[idcard],$rs[staffid]) > 0){
								$img_c = "<img src=\"../../../validate_management/images/award_star_silver_2.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"สถานะการผ่านการบันทึกการตรวจข้อมูล\">";
							}else{
								$img_c = "";	
							}
							
				?>
                <tr bgcolor="<?=$bg?>">
                  <td align="center"><?=$i?><?=$img_c?></td>
                  <td align="left"><?=$rs[idcard]?></td>
                  <td align="left"><?=$rs[fullname]?></td>
                  <td align="left"><?=$rs1[position_now]?></td>
                  <td align="left"><? echo ShowArea($rs[siteid])."/".$rs1[schoolname];?></td>
                  <td align="center"><?=$staffname;?></td>
                  <td align="center"><?=$pdf_file?>&nbsp;<a href="../../hr_report/report_check/report_check_data.php?idcard=<?=$rs[idcard]?>&siteid=<?=$rs[siteid]?>&xtype=validate" target="_blank"><img src="../../../validate_management/images/zoom.png" width="16" height="16" / border="0" alt="หน้ารายงานเทียบ label กับ value"></a>&nbsp;<a href="validate_keydata.php?idcard=<?=$rs[idcard]?>&fullname=<?=$rs[fullname]?>&staffname=<?=$staffname?>&staffid=<?=$rs[staffid]?>&xsiteid=<?=$rs[siteid]?>" target="_blank"><img src="../../../validate_management/images/cog_edit.png" width="16" height="16" border="0" alt="คลิ๊กเพื่อบันทึกความผิดพลาดการบันทึกข้อมูล"></a>&nbsp; <a href="../../hr_report/kp7_qc.php?id=<?=$rs[idcard]?>&sentsecid=<?=$rs[siteid]?>" target="_blank"><img src="../../../../application/hr3/hr_report/bimg/pdf.gif" width="16" height="16" border="0" title="ปริ้นเอกสารเพื่อตรวจคำผิด" ></a></td>
                </tr>
           <? 
				
				} //end while(){
			?>

                <tr>
                  <td colspan="7" align="center" bgcolor="#FFFFFF">
				  <? $sqlencode = urlencode($search_sql)  ; ?>	
	<?=devidepage($allpage, $keyword ,$sqlencode )?></td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
          </tr>
          
         <?
				}//end if($num_search < 1){
		 } //end if($key_action == "search"){ ?>
</table></td>
          </tr>
      </table>
  </td>
    </tr>
  </table>
</form>
<?
 	$time_end = getmicrotime(); writetime2db($time_start,$time_end);
	mysql_close();
?>

</body>
</html>
