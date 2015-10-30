<?php
include("libary/config.inc.php");
include("libary/function.php");
include ("timefunc.inc.php");
//include("inc/libary.php");
?>
<html>
<head>
<title>จำแนกหน่วยงานตามที่สังกัด</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
-->
</style>
</head>

<body >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom " ><? if ($mode =='2' or 
	$mode =='1') { ?>
<table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#5E5E5E">
        <tr>
          <td height="30"><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">&nbsp;&nbsp;จำแนกตามสังกัด</font></td>
          <td height="30">&nbsp;</td>
          <td height="30" align="center">&nbsp;</td>
        </tr>
        <tr bgcolor="#CACACA">
          <td width="410">&nbsp;&nbsp;&nbsp;&nbsp;<b><a href="?mode=1">สังกัด</a></b><font color="#003366">&nbsp;&nbsp;
              <?
	//	 $res = mysql_query("select count(sex) as i from general t1 left join office_detail t2 on t1.unit = t2.id   left join hr_beunder t3 on t3.id = t2.beunder where t3.name ='สังกัดส่วนกลาง'");
		$res = mysql_query("select  t1.name from  hr_beunder t1   where t1.id = '$idsunggut' ") ;
		 $rr = mysql_fetch_array($res);
		   echo $rr[name];	  
		  ?>
          </font></td>
          <td width="255">&nbsp;</td>
          <td width="105" align="center"><a href="admin.php"></a></td>
        </tr>
      </table>
      <table width="100%" height="25" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="80%">&nbsp;</td>
          <td><a href="?action=logon"></a></td>
        </tr>
      </table>
      <table width="99%" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#A3B2CC">
        <tr> 
          <td width="39%" valign="middle">&nbsp;</td>
          <td align="center" valign="middle" colspan=2>&nbsp;</td>

          <td width="31%" rowspan="4" align="right"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="160" height="100">
              <param name=movie value="bimg/bg_mini.swf">
              <param name=quality value=high>
              <embed src="bimg/bg_mini.swf" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="160" height="100">              </embed> 
            </object></td>
        </tr>
        <tr> 
          <td width="39%" align="right" valign="middle"><strong>จำนวนโรงเรียน</strong></td>
          <td width="12%" align="center" valign="middle" bgcolor="#EFEFEF"> <b><font color="#003366"> 
            <?
//		$res = mysql_query("select count(distinct t1.unit) as i from general t1 inner join office_detail t2 on t1.unit=t2.id where t2.beunder='$idsunggut';") ;
$res = mysql_query("select count(distinct t1.unit) as i from general t1 inner join office_detail t2 on t1.unit=t2.id ;") ;
		 $rr = mysql_fetch_array($res);
		   echo $rr[i];	  
		  ?>
            </font></b></td>
          <td width="14%" valign="middle"><b>โรงเรียน</b></td>
        </tr>
        <tr>
          <td align="right" valign="middle"><b>ข้าราชการ/ลูกจ้าง/พนักงาน</b></td>
          <td align="center" valign="middle" bgcolor="#EFEFEF"><b><font color="#003366">
            <?
	//	 $res = mysql_query("select count(sex) i from general t1 left join office_detail t2 on t1.unit = t2.id left join hr_beunder t3 on t3.id = t2.beunder where t3.id='$idsunggut';");
	$res = mysql_query("select count(sex) i from general t1 left join office_detail t2 on t1.unit = t2.id left join hr_beunder t3 on t3.id = t2.beunder ;");
		 $rr = mysql_fetch_array($res);
		   echo number_format($rr[i],0);	  
		  ?>
          </font></b></td>
          <td valign="middle"><b>คน</b></td>
        </tr>
        <tr> 
          <td width="39%" valign="middle">&nbsp;</td>
          <td width="12%" align="center" valign="middle">&nbsp;</td>
          <td width="14%" valign="middle">&nbsp;</td>
        </tr>
      </table>
      <table width="99%" align=center border="0" cellspacing="1" cellpadding="3" bgcolor="#000000">
        <tr bgcolor="#A3B2CC" align="center" valign="middle"> 
          <td width="45" rowspan="2"><b>ลำดับ</b></td>
          <td width="464" rowspan="2"><b><a href = "?keycol=1&mode=2&idsunggut=<?=$idsunggut?>">หน่วยงาน</a></b></td>
          <td colspan="3" align=center><b>จำนวน (คน)</b></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center" valign="middle" bgcolor="#A3B2CC" width="70"><b><a href = "?keycol=2&mode=2&idsunggut=<?=$idsunggut?>">ชาย</a></b></td>
          <td align="center" valign="middle" bgcolor="#A3B2CC" width="70"><b><a href = "?keycol=3&mode=2&idsunggut=<?=$idsunggut?>">หญิง</a></b></td>
          <td align="center" valign="middle" bgcolor="#A3B2CC" width="70"><b><a href = "?keycol=4&mode=2&idsunggut=<?=$idsunggut?>">รวม</a></b></td>
        </tr>
        <?
			$n = 0;
			$maletotal =0;
			$femaletotal=0;
		$result = mysql_query("select  distinct  t2.th_name as th_name,t2.id as id,t2.beunder as id_sunggut  from general t1  left join office_detail  t2  on  t1.unit = t2.id   ;");
		//$result = mysql_query("select  distinct t3.name,t3.id  from general t1  left join  office_detail  t2  on  t1.unit = t2.id  left join  hr_beunder  t3 on t2.beunder = t3.id  where education ='$education' ;");
		while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)) 
		{
			$n = $n+1;
				$result1 = mysql_query("select count(*) as i from `general` t1 left join office_detail t2 on t1.unit = t2.id  where  t1.sex ='ชาย'  and  t2.id ='$rs[id]' ;");
				echo mysql_error();
		//	echo "select count(*) as i from general t1 left join office_detail t2 on t1.unit = t2.id  where  t1.sex ='ชาย'  and  t2.id ='$rs[id]' ;";
				$m1=mysql_fetch_array($result1,MYSQL_ASSOC);
				$result1 = mysql_query("select count(*) as i from `general` t1 left join office_detail t2 on t1.unit = t2.id  where  t1.sex ='หญิง'  and  t2.id ='$rs[id]';");
				$f1=mysql_fetch_array($result1,MYSQL_ASSOC);
				$maletotal = $maletotal + $m1[i];
				$femaletotal = $femaletotal + $f1[i];
			$cellvalue[$n][1] = $rs[th_name];
			$cellvalue[$n][2] = $m1[i];
			$cellvalue[$n][3] = $f1[i];
			$cellvalue[$n][4] = $m1[i]+$f1[i] ;
			$total = $m1[i]+$f1[i] ;
		  	$rowtext[$n] = "<td><a href=\"sunggut2.php?mode=3&idsunggut=$rs[id_sunggut]&unit=$rs[id]\">$rs[th_name]</a></td><td align=\"center\"> $m1[i] </td><td align=\"center\">  $f1[i] </td><td align=\"center\"> $total</td>";
	}   // end while

//sort
//	$keycol = 1;  //column ที่เรียง

	if ($keycol >= 1 && $keycol <= count($cellvalue[1])){  //อยู่ใน scope
		if (is_numeric($cellvalue[1][$keycol])){
			$number_compare = true;
		}else{
			$number_compare = false;
		}

		for ($k=1;$k<$n;$k++){
			for ($j=$k+1;$j<=$n;$j++){
				
				if ($number_compare){
					if ($cellvalue[$k][$keycol] < $cellvalue[$j][$keycol] ){
						//swap $rowtext
						$temp_array = $rowtext[$k];
						$rowtext[$k] = $rowtext[$j];
						$rowtext[$j] = $temp_array;

						//swap $cellvalue
						$temp_array = $cellvalue[$k];
						$cellvalue[$k] = $cellvalue[$j];
						$cellvalue[$j] = $temp_array;
					}
				}else{ //string compare
					if (strcmp($cellvalue[$k][$keycol],$cellvalue[$j][$keycol]) < 0){
						//swap $rowtext
						$temp_array = $rowtext[$k];
						$rowtext[$k] = $rowtext[$j];
						$rowtext[$j] = $temp_array;

						//swap $cellvalue
						$temp_array = $cellvalue[$k];
						$cellvalue[$k] = $cellvalue[$j];
						$cellvalue[$j] = $temp_array;
					}
				}

			}	//for j
		} //for k
	}

// end sort


for ($i=1;$i<=$n;$i++){
			if ($i%2 == 0)
			{	 $color = "#DDDDDD";
			}else
			{
				$color ="#EFEFEF";
			}
		echo "<tr bgcolor=\"$color\"><td align=\"center\">$i</td> ";
        echo $rowtext[$i];
		echo "</tr>";
	}
	?>
        <tr bgcolor="#FFFFFF"> 
          <td align="center" valign="middle" bgcolor="#A3B2CC" colspan="2"><b>รวม 
            &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; 
            <?=$n?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หน่วยงาน</b></td>
          <td align="center" valign="middle" bgcolor="#A3B2CC"><b>
            <?=number_format($maletotal,0)?>
            </b></td>
          <td align="center" valign="middle" bgcolor="#A3B2CC"><b>
            <?=number_format($femaletotal,0)?>
            </b></td>
          <td align="center" valign="middle" bgcolor="#A3B2CC"><b>
            <?=number_format($maletotal+$femaletotal,0)?>
            </b></td>
        </tr>
      </table>
      <p>&nbsp;</p>
<? } else { ?>
      <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#5E5E5E">
        <tr>
          <td height="30"><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">&nbsp;&nbsp;จำแนกตามสังกัด</font></td>
          <td height="30">&nbsp;</td>
          <td height="30" align="center">&nbsp;</td>
        </tr>
        <tr bgcolor="#CACACA">
          <td width="410">&nbsp;&nbsp;&nbsp;&nbsp;<b><a href="?mode=1"></a></b><font color="#003366"><strong><a href="?mode=2&idsunggut=<?=$idsunggut?>">โรงเรียน</a></strong>
                <?
	//	 $res = mysql_query("select count(sex) as i from general t1 left join office_detail t2 on t1.unit = t2.id   left join hr_beunder t3 on t3.id = t2.beunder where t3.name ='สังกัดส่วนกลาง'");
		$res = mysql_query("select  t1.th_name from  office_detail t1   where t1.id  = '$unit' ") ;
		 $rr = mysql_fetch_array($res);
		   echo $rr[th_name];	  
		  ?>
            </font></td>
          <td width="255">&nbsp;</td>
          <td width="105" align="center"><a href="admin.php"></a></td>
        </tr>
      </table>
      <table width="100%" height="25" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="80%">&nbsp;</td>
          <td><a href="?action=view_user"></a></td>
        </tr>
      </table>
      <table width="99%" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#A3B2CC">
        <tr>
          <td width="39%" valign="middle">&nbsp;</td>
          <td align="center" valign="middle" colspan=2>&nbsp;</td>
          <td width="31%" rowspan="4" align="right"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="160" height="100">
              <param name=movie value="bimg/bg_mini.swf">
              <param name=quality value=high>
              <embed src="bimg/bg_mini.swf" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="160" height="100"> </embed>
          </object></td>
        </tr>
        <tr>
          <td width="39%" align="right" valign="middle"><strong>จำนวนโรงเรียน</strong></td>
          <td width="12%" align="center" valign="middle" bgcolor="#EFEFEF"><b><font color="#003366">
            <?
	//	 $res = mysql_query("select count(sex) as i from general t1 left join office_detail t2 on t1.unit = t2.id   left join hr_beunder t3 on t3.id = t2.beunder where t3.name ='สังกัดส่วนกลาง'");
		//$res = mysql_query("select count( id) as i from office_detail t1 where t1.beunder = '$idsunggut' ") ;
		$res = mysql_query("select count(distinct t1.unit) as i from general t1 inner join office_detail t2 on t1.unit=t2.id where t2.beunder='$idsunggut';") ;
		 $rr = mysql_fetch_array($res);
		   echo $rr[i];	  
		  ?>
          </font></b></td>
          <td width="14%" valign="middle"><b>หน่วยงาน</b></td>
        </tr>
        <tr>
          <td align="right" valign="middle"><b>ข้าราชการ/ลูกจ้าง/พนักงาน</b></td>
          <td align="center" valign="middle" bgcolor="#EFEFEF"><b><font color="#003366">
            <?
		 $res = mysql_query("select count(sex) i from general t1 left join office_detail t2 on t1.unit = t2.id left join hr_beunder t3 on t3.id = t2.beunder where t2.id='$unit';");
		 $rr = mysql_fetch_array($res);
		   echo $rr[i];	  
		  ?>
          </font></b></td>
          <td valign="middle"><b>คน</b></td>
        </tr>
        <tr>
          <td width="39%" valign="middle">&nbsp;</td>
          <td width="12%" align="center" valign="middle">&nbsp;</td>
          <td width="14%" valign="middle">&nbsp;</td>
        </tr>
      </table>
      <table border=0 width="99%" cellspacing=1 cellpadding=2 bgcolor=black align=center>
        <tr bgcolor="#A3B2CC">
          <th width="9%"> ลำดับที่ </th>
          <th> ชื่อ-นามสกุล</th>
          <th>ตำแหน่ง</th>
          <th>ระดับ</th>
          <th>อายุ</th>
        </tr>
        <?
	//$result = mysql_query("select t1.id as id, t1.prename_th as prename_th , t1.name_th as name_th,t1.surname_th as surname_th,t1.position_now as position_now,t1.radub as radub,t1.birthday       from general t1 left join office_detail t2 on t1.unit = t2.id left join hr_beunder t3 on t2.beunder = t3.id  where t1.unit = '$unit'   order by cast(radub as signed) desc ,startdate;    ");
	$result = mysql_query("select t1.id as id, t1.prename_th as prename_th , t1.name_th as name_th,t1.surname_th as surname_th,t1.position_now as position_now,t1.radub as radub,t1.birthday       from general t1 left join office_detail t2 on t1.unit = t2.id left join hr_beunder t3 on t2.beunder = t3.id  where t1.unit = '$unit'   order by birthday asc;    ");
	while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		$i++;
		
			if ($i%2 == 0)
			{	 $color = "#DDDDDD";
			}else
			{
				$color ="#EFEFEF";
			}
?>
        <tr bgcolor="<?=$color?>">
          <td align=center><?=$i?>          </td>
          <td>
		<!--  <a href="index.php?page=1&id=<?=$rs[id]?>">  -->
            <?=$rs[prename_th]?>
            <?=$rs[name_th]?>
            &nbsp
            <?=$rs[surname_th]?>          </td>
          <td align=center><?=$rs[ position_now]?></td>
          <td align=center><?=$rs[radub]?></td>
          <td align=center>
		  <?
		  $diff  = dateLength($rs[birthday]);
		  If ($diff[year] > 2000)
		  {
		  	echo "ไม่ระบุวันเดือนปีเกิด";
			}else
			{
          echo $diff[year];
		  }
		  ?></td>
        </tr>
        <?
	} //while

// List Template
?>
      </table>
	  <?
	  }
	  ?>
	  <p>&nbsp;</p>
    </td></tr>
</table>
</body>
</html>
