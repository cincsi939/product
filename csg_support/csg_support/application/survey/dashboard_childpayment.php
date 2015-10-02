<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Tanachai Khampukhew (tanachai@sapphire.co.th)
 * @created  30/08/2014
 * @access  public
 */
//require_once("lib/class.function.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานการเบิกจ่ายเงินอุดหนุนเด็กแรกเกิด</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/style_menu.css">
<script src="../js/jquery-latest.min.js" type="text/javascript"></script>
</head>
<style>
table.table1, table.table2 {
    border-collapse: collapse;
}

table.table1, table.table1 th, table.table1 td{
	border: 0px solid black;
	font-size:18px;
}

table.table2, table.table2 th{
	border: 1px solid #CCC;
	font-size:13px;
	background-color:#2b5cd8;
	color:#FFF;
	height:30px;
}

table.table2 td{
	border: 1px solid #CCC;
	font-size:13px;
	color:#000;
	text-align:left;
	padding:2px;
}

table.table2 th{
	text-align:center;
}

.border1{
	border: 1px solid black;
}

div#div-container{
 background-color:#CCC;
 opacity:0.5;
 left:0px;
 top:0px;
 width:100%;
 height:100%;
 z-index:998;
 position:fixed;
 display:none;
}
#iframe-popup{
 background-color:#FFF;
 left:30%;
 top:5%;
 width:40%;
 height:580px;
 z-index:999;
 position:fixed;
 display:none;
 box-shadow: 5px 5px 5px #888888;
 border:0px;
}
</style>
<script>
$.fn.digits = function(){ 
    return this.each(function(){ 
        $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ); 
    })
}

$(document).ready(function(){
	var budjet = parseInt($('#budjet').text().replace(/,/gi, ""));
	var cost = parseInt($('#sumall').val());
	var remain = budjet - cost;
	var percent1 = (cost*100)/budjet;
	percent1 = percent1.toFixed(2);
	var percent2 = (100 - percent1);
	
	$('#cost').text($('#sumall').val()).digits();
	$('#remain').text(remain).digits();
	$('#percent1').text(percent1);
	$('#percent2').text(percent2);
	
	$('#div-container').click(function(){
		$('#iframe-popup').fadeOut('fast',function(){
		$('#div-container').fadeOut('fast');
	});
	});
	
	$('#close').click(function(){
		$('#iframe-popup').fadeOut('fast',function(){
			$('#div-container').fadeOut('fast');
		});
	});
});

function popup(){
	$('#div-container').fadeIn('fast',function(){
		$('#iframe-popup').fadeIn('fast',function(){
			
		});
	});
}
</script>
<body>
<? $box_search = 'on';  include "header.php";?>
<div id="div-container">
</div>
<div id="iframe-popup">
<div id="close" style="cursor:pointer; font-size:16px; padding:2% 2% 0 0; width:96%; height:auto; text-align:right;"><b>X</b></div>
<div style="font-size:26px; font-weight:bold; position:absolute; top:1%; left:2%;">ประเทศไทย</div>
<img src="img/Thailand map-01.png" height="550" style="margin-left:100px;" />
<img src="../../report_map/images/btn_radar_03.png" width="50" title="ตราด" style="position:absolute; top:305px; left:285px; cursor:pointer;" onclick="window.open('dashboard_childpayment_detail.php?frame=1', '_blank');" />
</div>

<div style="width:98%; height:auto; float:left; padding:1%;">
	<div style="width:100%; height:auto; float:left;">
    	<div style="width:50%; height:auto; float:left; padding-left:10%; padding-top:80px;">
        <table class="table1">
        	<tr>
            	<td width="400">จำนวนเด็กแรกเกิดที่ขึ้นทะเบียน</td>
                <td align="right" style="font-weight:bold;">132,000</td>
                <td>&nbsp;&nbsp;คน</td>
            </tr>
            <tr>
            	<td>งบประมาณทั้งหมด</td>
                <td align="right" id="budjet" style="font-weight:bold;">633,300,000</td>
                <td>&nbsp;&nbsp;บาท</td>
            </tr>
            <tr>
            	<td>เบิกจ่ายแล้ว</td>
                <td align="right" id="cost" style="font-weight:bold;">158,400,000</td>
                <td>&nbsp;&nbsp;บาท (<span id="percent1"></span>%)</td>
            </tr>
            <tr>
            	<td>คงเหลือ</td>
                <td align="right" id="remain" style="color:#0C3; font-weight:bold;">475,200,000</td>
                <td>&nbsp;&nbsp;บาท (<span id="percent2"></span>%)</td>
            </tr>
        </table>
        </div>
        
        <div style="width:39%; height:auto; float:left; text-align:center">
            <div style="width:350px; height:280px; border:1px solid #CCC; float:right;">
            <img src="img/Thailand map-01.png" height="250" onclick="popup();" style="cursor:pointer;" />
            </div>
        </div>
    </div>
    
    <div style="width:100%; height:auto; float:left; text-align:right;">
    ข้อมูล ณ วันที่ 24 กรกฏาคม 2558
    </div>
    
    <div style="width:100%; height:auto; float:left; text-align:right;">
    <table width="100%;" class="table2">
    	<thead>
        	<tr>
            	<th rowspan="2">จังหวัด</th>
                <th rowspan="2" width="8%">เด็กแรกเกิดที่ขึ้นทะเบียน (คน)</th>
                <th colspan="12">งบประมาณ 2559 (บาท)</th>
            </tr>
            <tr>
            	<th width="5.5%">ต.ค. 58</th>
                <th width="5.5%">พ.ย. 58</th>
                <th width="5.5%">ธ.ค. 58</th>
                <th width="5.5%">ม.ค. 59</th>
                <th width="5.5%">ก.พ. 59</th>
                <th width="5.5%">มี.ค. 59</th>
                <th width="5.5%">เม.ย. 59</th>
                <th width="5.5%">พ.ค. 59</th>
                <th width="5.5%">มิ.ย. 59</th>
                <th width="5.5%">ก.ค. 59</th>
                <th width="5.5%">ส.ค. 59</th>
                <th width="5.5%">ก.ย. 59</th>
            </tr>
        </thead>
        <tbody>
        <?php
		$i = 1;
		$strSQL = "SELECT
		t1.ccDigi,
		t1.column1,
		t1.column2,
		t1.column3,
		t1.column4,
		t1.column5,
		t1.column6,
		t1.column7,
		t1.column8,
		t1.column9,
		t1.column10,
		t1.column11,
		t1.column12,
		t1.column13
		FROM
		report_childpayment AS t1
		ORDER BY t1.column1 ASC ";
		$con = new Cfunction();
		$con->connectDB();
		$objQuery = mysql_query($strSQL);
		
		$strSQL2 = "SELECT sum(exsum_district_num) as sumpersonall FROM exsum_district_all";
		$objQuery2 = mysql_query($strSQL2);
		$obj2 = mysql_fetch_object($objQuery2);
		
		$sumall = $sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = $sum7 = $sum8 = $sum9 = $sum10 = $sum11 = $sum12 = $sum13 =0;
		while($obj = mysql_fetch_object($objQuery)){
			$bgColor = ($i % 2 == 1) ? '#FFF' : '#f2f2f2';
			
			$ccName = ($obj->column1 == 'ตราด') ? '<a href="dashboard_childpayment_detail.php?frame=1" target="_blank"><b>ตราด</b></a>' : $obj->column1;
			$NumPerson = ($obj->column1 == 'ตราด') ? $obj2->sumpersonall : $obj->column2;

			$sum1 += $obj->column2;
			$sum2 += $obj->column3;
			$sum3 += $obj->column4;
			$sum4 += $obj->column5;
			$sum5 += $obj->column6;
			$sum6 += $obj->column7;
			$sum7 += $obj->column8;
		?>
        <tr style="background-color:<?php echo $bgColor?>">
        	<td><?php echo $ccName?></td>
            <td style="text-align:right;"><?php echo number_format($NumPerson)?></td>
            <td style="text-align:right;"><?php echo number_format($obj->column3)?></td>
            <td style="text-align:right;"><?php echo number_format($obj->column4)?></td>
            <td style="text-align:right;"><?php echo number_format($obj->column5)?></td>
            <td style="text-align:right;"><?php echo number_format($obj->column6)?></td>
            <td style="text-align:right;"><?php echo number_format($obj->column7)?></td>
            <td style="text-align:right;"><?php echo number_format($obj->column8)?></td>
            <td style="text-align:right;">-</td>
            <td style="text-align:right;">-</td>
            <td style="text-align:right;">-</td>
            <td style="text-align:right;">-</td>
            <td style="text-align:right;">-</td>
            <td style="text-align:right;">-</td>
        </tr>
        <?php $i++;} ?>
        </tbody>
        <tfoot>
        <tr>
        	<th>รวม</th>
            <th style="text-align:right;"><?php echo number_format($sum1)?></th>
            <th style="text-align:right;"><?php echo number_format($sum2)?></th>
            <th style="text-align:right;"><?php echo number_format($sum3)?></th>
            <th style="text-align:right;"><?php echo number_format($sum4)?></th>
            <th style="text-align:right;"><?php echo number_format($sum5)?></th>
            <th style="text-align:right;"><?php echo number_format($sum6)?></th>
            <th style="text-align:right;"><?php echo number_format($sum7)?></th>
            <th style="text-align:right;"><?php echo number_format($sum8)?></th>
            <th style="text-align:right;"><?php echo number_format($sum9)?></th>
            <th style="text-align:right;"><?php echo number_format($sum10)?></th>
            <th style="text-align:right;"><?php echo number_format($sum11)?></th>
            <th style="text-align:right;"><?php echo number_format($sum12)?></th>
            <th style="text-align:right;"><?php echo number_format($sum13)?></th>
        </tr>
        </tfoot>
    </table>
    <input type="hidden" id="sumall" value="<?php echo $sum2+$sum3+$sum4+$sum5+$sum6+$sum7+$sum8?>" />
    </div>
</div>
</body>
</html>