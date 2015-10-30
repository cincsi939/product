<?
session_start();
include("checklist2.inc.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>

<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>
<body>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
   <td align="center"><form name="form1" method="post" action="">
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
           <tr>
             <td colspan="4" align="left" bgcolor="#CAD5FF"><strong>ค้นหาเพื่อตรวจสอบชื่อโรงเรียนในระบบ</strong></td>
             </tr>
           <tr>
             <td width="17%" align="left" bgcolor="#FFFFFF"><strong>ชื่่อโรงเรียน</strong></td>
             <td width="20%" align="left" bgcolor="#FFFFFF"><label>
               <input name="office" type="text" id="office" value="<?=$office?>">
             </label></td>
             <td width="12%" align="left" bgcolor="#FFFFFF"><strong>สพท.</strong></td>
             <td width="51%" align="left" bgcolor="#FFFFFF">
               <select name="sentsecid" id="sentsecid">
               <option value="">- เลือกเขตพื้นที่การศึกษา -</option>
               <?
               	$sql_site ="SELECT secid,secname FROM eduarea WHERE secid NOT LIKE '99%' ORDER BY secname ASC";
				$result_site = mysql_db_query($dbnamemaster,$sql_site);
				while($rss = mysql_fetch_assoc($result_site)){
					if($rss[secid] == $sentsecid){ $sel = "selected='selected'";}else{ $sel = "";} 
					echo "<option value='$rss[secid]' $sel>$rss[secname]</option>";
				}//end while($rss = mysql_fetch_assoc($result_site)){
			   ?>
               </select>
</td>
           </tr>
           <tr>
             <td colspan="4" align="center" bgcolor="#FFFFFF">
               <input type="hidden" name="search" value="search">
               <input type="submit" name="Submit" value="ค้นหา">
               <input type="button" name="BtnC" value="ล้างข้อมูล" onClick="location.href='?search='">
              </td>
           </tr>
         </table></td>
       </tr>
     </table>
      </form>
   </td>
 </tr>
 <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <? 

if($search == "search"){
	$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
	$e			= (!isset($e) || $e == 0) ? 20 : $e ;
	$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 

if($office != ""){
		$conw .= " AND office LIKE '%$office%'";
}else{
		$conw .= " AND office = '   '";	
}
if($sentsecid != ""){
	$conw .= " AND siteid='$sentsecid'";	
}
	
		$sql_main = "SELECT * FROM allschool WHERE siteid NOT LIKE '99%' $conw";
//echo $dbnamemaster." ".$sql_main;
		$xresult = mysql_db_query($dbnamemaster,$sql_main);
		$all= @mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
		
	if($page <= $allpage){
			$sql_main .= " LIMIT $i, $e";
	}else if($page == $xpage){
		$i=0;
			$sql_main .= " ";
	}else{
			$sql_main .= " LIMIT $i, $e";
	}

//echo $sql_search;	
		$search_sql = $sql_main ; 
	$result_search = mysql_db_query($dbnamemaster,$sql_main);
	$numr = @mysql_num_rows($result_search);
	
	

  
  ?>
  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      
      <tr>
        <td width="3%" align="center" bgcolor="#CAD5FF"><strong>ลำดับ</strong></td>
        <td width="45%" align="center" bgcolor="#CAD5FF"><strong>ชื่อโรงเรียน</strong></td>
        <td width="21%" align="center" bgcolor="#CAD5FF"><strong>&#3619;&#3627;&#3633;&#3626;&#3650;&#3619;&#3591;&#3648;&#3619;&#3637;&#3618;&#3609;</strong></td>
        <td width="31%" align="center" bgcolor="#CAD5FF"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        </tr>
	  <?
	  	if($numr < 1){
			echo "<tr bgcolor='#F0F0F0'><td colspan='3'> - ไม่พบรายการที่ค้นหา -</td></tr>";
		}else{
		$i=0;
		while($rs = mysql_fetch_assoc($result_search)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}

		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs[office]";?></td>
        <td align="left"><? echo "$rs[id]";?></td>
        <td align="left"><? 
		$sqlsec = "SELECT  secname FROM eduarea where secid='$rs[siteid]'";
		$resultsec = mysql_db_query($dbnamemaster,$sqlsec);
		$rssc = mysql_fetch_assoc($resultsec);
		echo $rssc[secname];
		?></td>
        </tr>
      	  <?
	  	}//end while(){
	  	}//end if($numr < 1){
	  ?>
      <tr>
        <td colspan="4" align="right" bgcolor="#FFFFFF"><? $sqlencode = urlencode($search_sql)  ; ?>	
	<?=devidepage($allpage, $keyword ,$sqlencode )?></td>
        </tr>

    </table></td>
  </tr>
  <?
  	}//end   if($search == "search"){
  ?>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
</body>
</html>
