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
<script src="../js/jquery-latest.js" type="text/javascript"></script>
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
</style>
<body>
<? $box_search = 'on';  include "header_child.php";?>
<div style="width:98%; height:auto; float:left; padding:1%;">
	<div class="border1" style="width:100%; height:auto; float:left;">
    	<div style="width:50%; height:auto; float:left; padding-left:10%;">
        <table class="table1">
        	<tr>
            	<td width="400">จำนวนเด็กแรกเกิดที่ขึ้นทะเบียน</td>
                <td align="right">123,000</td>
                <td>&nbsp;&nbsp;คน</td>
            </tr>
            <tr>
            	<td>งบประมาณทั้งหมด</td>
                <td align="right">633,300,000</td>
                <td>&nbsp;&nbsp;บาท</td>
            </tr>
            <tr>
            	<td>เบิกจ่ายแล้ว</td>
                <td align="right">158,400,000</td>
                <td>&nbsp;&nbsp;บาท</td>
            </tr>
            <tr>
            	<td>คงเหลือ</td>
                <td align="right">475,200,000</td>
                <td>&nbsp;&nbsp;บาท</td>
            </tr>
        </table>
        </div>
        
        <div style="width:39%; height:auto; float:left;">
        <img src="img/42750.jpg" height="250" />
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
                <th colspan="12">ปีงบประมาณ 2559 (บาท)</th>
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
		REPLACE(t1.ccName,'จังหวัด','') AS changwat,
		t1.ccType
		FROM
		ccaa AS t1
		WHERE t1.ccType = 'Changwat'
		ORDER BY changwat ASC ";
		$con = new Cfunction();
		$con->connectDB();
		$objQuery = mysql_query($strSQL);
		
		$sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = $sum7 = $sum8 = $sum9 = $sum10 = $sum11 = $sum12 = $sum13 =0;
		while($obj = mysql_fetch_object($objQuery)){
			$bgColor = ($i % 2 == 1) ? '#FFF' : '#f2f2f2';
			
			if($obj->ccDigi != '23000000'){
				$sum1 += $numRand1 = rand(700,2800);
			}else{
				$sum1 += $numRand1 = 714;
			}
			$sum2 += $numRand2 = ($numRand1 - rand(300,400)) * 400;
			$sum3 += $numRand3 = ($numRand1 - rand(300,400)) * 400;
			$sum4 += $numRand4 = ($numRand1 - rand(300,400)) * 400;
			$sum5 += $numRand5 = ($numRand1 - rand(300,400)) * 400;
			$sum6 += $numRand6 = ($numRand1 - rand(300,400)) * 400;
			$sum7 += $numRand7 = ($numRand1 - rand(300,400)) * 400;
			
			$arry['ccDigi'] = $obj->ccDigi;
			$arry['name'] = $obj->changwat;
			$arry['cl1'] = $numRand1;
			$arry['cl2'] = $numRand2;
			$arry['cl3'] = $numRand3;
			$arry['cl4'] = $numRand4;
			$arry['cl5'] = $numRand5;
			$arry['cl6'] = $numRand6;
			$arry['cl7'] = $numRand7;
			$arry['cl8'] = 0;
			$arry['cl9'] = 0;
			$arry['cl10'] = 0;
			$arry['cl11'] = 0;
			$arry['cl12'] = 0;
			$arry['cl13'] = 0;
			
			$sql_insert = "REPLACE INTO report_childpayment SET
			ccDigi = '{$obj->ccDigi}',
			column1 = '{$obj->changwat}',
			column2 = '{$numRand1}',
			column3 = '{$numRand2}',
			column4 = '{$numRand3}',
			column5 = '{$numRand4}',
			column6 = '{$numRand5}',
			column7 = '{$numRand6}',
			column8 = '{$numRand7}',
			column9 = '0',
			column10 = '0',
			column11 = '0',
			column12 = '0',
			column13 = '0' ";
			$con = new Cfunction();
			$con->connectDB();
			//mysql_query($sql_insert);
			
			/*$sum8 += $numRand8 = ($numRand1 - rand(100,200)) * 400;
			$sum9 += $numRand9 = ($numRand1 - rand(100,200)) * 400;
			$sum10 += $numRand10 = ($numRand1 - rand(100,200)) * 400;
			$sum11 += $numRand11 = ($numRand1 - rand(100,200)) * 400;
			$sum12 += $numRand12 = ($numRand1 - rand(100,200)) * 400;
			$sum13 += $numRand13 = ($numRand1 - rand(100,200)) * 400;*/
		?>
        <tr style="background-color:<?php echo $bgColor?>">
        	<td><?php echo $obj->changwat?></td>
            <td style="text-align:right;"><?php echo number_format($numRand1)?></td>
            <td style="text-align:right;"><?php echo number_format($numRand2)?></td>
            <td style="text-align:right;"><?php echo number_format($numRand3)?></td>
            <td style="text-align:right;"><?php echo number_format($numRand4)?></td>
            <td style="text-align:right;"><?php echo number_format($numRand5)?></td>
            <td style="text-align:right;"><?php echo number_format($numRand6)?></td>
            <td style="text-align:right;"><?php echo number_format($numRand7)?></td>
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
    </div>
</div>
</body>
</html>