<?
$ApplicationName	= "diagnosticv1_test";
$module_code 		= "diagnosticv1_test"; 
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

set_time_limit(0);
include ("../../../../config/conndb_nonsession.inc.php")  ;
include("../../../../common/common_competency.inc.php");
include("../../../../common/class.loadpage.php");
include('function_checkdata.inc.php') ;


$time_start = getmicrotime();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>ตรวจสอบข้อผิดพลาดการบันทึกข้อมูล</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<LINK href="../../../../common/style.css" rel=stylesheet type="text/css">
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

  <br />
  <table width="98%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
        <? 
		
			$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
			$e			= (!isset($e) || $e == 0) ? 50 : $e ;
			$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 

//echo "aaaaaa";
if($xtype == "all"){
		$con1 = " AND t3.ticketid='$ticketid' AND t3.staffid='$staffid'";
		$xtitle = "รายการคีย์ข้อมูลทั้งหมดของ ".ShowStaffKey($staffid)." รหัสใบงาน ".$ticketid; 
}else if($xtype == "wait"){
		$con1 = " AND t3.ticketid='$ticketid' AND t3.staffid='$staffid' AND t2.userkey_wait_approve='1' and t2.approve<> '2'";
		$xtitle = "รายการคีย์ข้อมูลที่รอการตรวจสอบของ  ".ShowStaffKey($staffid)." รหัสใบงาน ".$ticketid; 
}else if($xtype == "key_approve"){
		$xtitle = "รายการคีย์ข้อมูลที่บันทึกข้อมูลแล้วเสร็จ  ".ShowStaffKey($staffid)." รหัสใบงาน ".$ticketid; 
		$con1 = " AND t3.ticketid='$ticketid' AND t3.staffid='$staffid' AND t2.userkey_wait_approve='1' ";
}else  if($xtype == "sys_approve"){
		$xtitle = "รายการคีย์ข้อมูลที่รับรองโดยระบบอัตโนมัติ".ShowStaffKey($staffid)." รหัสใบงาน ".$ticketid; 
		$con1 = " AND t3.ticketid='$ticketid' AND t3.staffid='$staffid' AND t2.approve='2' and (t2.staff_apporve IS NULL or t2.staff_apporve='') ";	
}else if($xtype == "sup_approve"){
		$xtitle = "รายการคีย์ข้อมูลที่ Supervisor ตรวจสอบแล้ว".ShowStaffKey($staffid)." รหัสใบงาน ".$ticketid; 
		$con1 = " AND t3.ticketid='$ticketid' AND t3.staffid='$staffid'  AND t2.userkey_wait_approve='1' and t2.approve='2' and (t2.staff_apporve IS NOT NULL and  t2.staff_apporve<>'') ";	
}else if($xtype == "all_approve"){
		$xtitle = "รายการคีย์ข้อมูลผลการตรวจสอบทั้งหมด".ShowStaffKey($staffid)." รหัสใบงาน ".$ticketid; 
		$con1 = " AND t3.ticketid='$ticketid' AND t3.staffid='$staffid'  AND t2.userkey_wait_approve='1' and t2.approve='2'  ";	
}

				
$sql_search = "SELECT  t2.idcard, t2.fullname as fullname, t2.siteid,t2.userkey_wait_approve as staffapprove,
t3.staffid,t1.timeupdate,t2.ticketid, t2.approve,t2.profile_id
FROM
tbl_assign_key as t2 
Inner Join tbl_assign_sub as t3 ON t2.ticketid=t3.ticketid
Left Join monitor_keyin as t1 ON t2.idcard = t1.idcard AND t2.siteid = t1.siteid 
WHERE t2.idcard <> '' $con1
GROUP BY t2.idcard
ORDER BY fullname ASC
";
//echo $sql_search."<br>";
//echo "<h4><center><font color='#FF0000' >กำลังตรวจเช็คการทำงานของระบบ ครับอย่างพึ่งทำการ รับรองข้อมูล</font></center></h4>";
//echo $db_name." :: <br>".$sql_search."<br>";
		$xresult = mysql_db_query($dbnameuse,$sql_search) or die(mysql_error()."$sql_search<br>".__LINE__);
		$all= mysql_num_rows($xresult);
	//	echo "<br>จำนวนรายการ :: ".$all;
		//echo $all;die;
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
	
	//echo "<br>".$sql_search;
				$result_search = mysql_db_query($dbnameuse,$sql_search) or die(mysql_error()."$sql_search<br>".__LINE__);
				$num_search = mysql_num_rows($result_search);
				$search_sql = $sql_search ; 
				//echo "จำนวนบรทัด :: ".$num_search;die;
				if($num_search < 1){
					echo "<tr><td colspan='3' align='center'><b> - ไมพบรายการที่ค้นหา - </b></td></tr>";
				}else{
		?>
        <tr>
          <td width="100%" align="center">
          
          <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return CheckFromSubmit();">
          
          
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3" >
                <tr>
                  <td colspan="10" align="left" bgcolor="#A5B2CE"><strong><?=$xtitle?></strong></td>
                  </tr>
                <tr>
                  <td width="4%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
                  <td width="9%" align="center" bgcolor="#A5B2CE"><strong>รหัสใบงาน</strong></td>
                  <td width="9%" align="center" bgcolor="#A5B2CE"><strong>รหัสบัตร</strong></td>
                  <td width="9%" align="center" bgcolor="#A5B2CE"><strong>ชื่อ - นามสกุล</strong></td>
                  <td width="11%" align="center" bgcolor="#A5B2CE"><strong>ตำแหน่ง</strong></td>
                  <td width="16%" align="center" bgcolor="#A5B2CE"><strong>สังกัด</strong></td>
                  <td width="12%" align="center" bgcolor="#A5B2CE"><strong>สถานะตรวจข้อมูล<br />
                    เบื้องต้นของคนคีย์</strong></td>
                  <td width="14%" align="center" bgcolor="#A5B2CE"><strong>ความสมบูรณ์ของ<br />
                    การบันทึกข้อมูล</strong></td>
                  <td width="10%" align="center" bgcolor="#A5B2CE"><strong>คลิ๊กเพื่อรับรองข้อมูล</strong></td>
                  <td width="6%" align="center" bgcolor="#A5B2CE">&nbsp;</td>
                </tr>
                <? 
				//$i=0;
				$j=0;
	
					while($rs = mysql_fetch_assoc($result_search)){
							$dbsite = STR_PREFIX_DB.$rs[siteid];
							$profile_id = $rs[profile_id];
							//echo "$rs[idcard] $rs[fullname]<br>";
							$arr_staff = GetKeyGroup($rs[staffid]);
							$date_profile =  DateProfile($rs[idcard],$rs[siteid],$profile_id);// วันที่จัดทำข้อมูล
							$arrdata = ProcessQCData($rs[siteid],$rs[idcard],$profile_id);
							$CheckError = count($arrdata);

							if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}

							
							$sql1 = "SELECT position_now,schoolname FROM view_general WHERE CZ_ID='$rs[idcard]'";
							//echo $sql1;
							$result1 = mysql_db_query($dbsite,$sql1);
							$rs1 = mysql_fetch_assoc($result1);
							//echo "<pre>";
							//print_r($arr);
							if($CheckError > 0){ $dis = "disabled='disabled'";$j++; $msg_err = "error";}else{ $dis = ""; $msg_err = "";}
							$pathfile = "../../../../../edubkk_kp7file/$rs[siteid]/$rs[idcard]".".pdf";
							if(is_file($pathfile)){
								$pdf_file = "<a href='$pathfile' target='_blank'><img src=\"../../../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"21\" alt=\"ตรวจสอบไฟล์ pdf ต้นฉบับ\" border='0'></a>";
							}else{
								$arrkp7 = GetPdfOrginal($rs[idcard],$path_pdf,$imgpdf,"","pdf");
								$pdf_file =  $arrkp7['linkfile'];
								$pdf_file = "";
							}//end if(is_file($pathfile)){
								
							
				?>
                <tr bgcolor="<?=$bg?>">
                  <td align="center"><?=$i?></td>
                  <td align="left"><?=$ticketid?></td>
                  <td align="left"><?=$rs[idcard]?></td>
                  <td align="left"><?=$rs[fullname]?></td>
                  <td align="left"><?=$rs1[position_now]?></td>
                  <td align="left"><? echo ShowArea($rs[siteid])."/".$rs1[schoolname];?></td>
                  <td align="center"><?
				  if($rs[staffapprove] ==  1){ echo "ยืนยัน";}else{ echo "<font color='#FF0000'>ยังไม่ยืนยัน</font>";}
				  ?></td>
                  <td align="center"><? if($CheckError  > 0){ echo "<font color='red'>INCOMPLETE</font>"; }else{ echo "<font color='green'>COMPLETE</font>";}?></td>
                  <td align="center"><? echo "<a href='process_check_qcdata.php?idcard=$rs[idcard]&xsiteid=$rs[siteid]&fullname=$rs[fullname]&profile_id=$profile_id' target='_blank'>ตรวจสอบข้อมูล</a>";?></td>
                  <td align="center">
                    <?=$pdf_file?>
                  </td>
                </tr>
                <? 
					unset($date_profile);
					unset($arr_staff);
					unset($arrdata);
					$CheckError = 0;
				} //end while(){
					mysql_free_result($result_search);
					?>
                   <tr bgcolor="<?=$bg?>">
                     <td colspan="10" align="center" bgcolor="#FFFFFF"><? $sqlencode = urlencode($search_sql)  ; ?>	
                       <?=devidepage($allpage, $keyword ,$sqlencode )?></td>
                   </tr>
                  </table></td>
            </tr>
          </table>
          
          </form>
          
          </td>
          </tr>
          
         <?
				}//end if($num_search < 1){ ?>
  </table></td>
    </tr>
      </table>
  </td>
    </tr>
  </table>
  
<?
 	$time_end = getmicrotime(); writetime2db($time_start,$time_end);
	mysql_close();
?>
</body>
</html>
