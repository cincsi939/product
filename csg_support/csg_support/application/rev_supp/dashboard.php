<?php
/**
* @comment หน้า dashboard ในส่วนขอการรับเงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด
* @projectCode P2
* @tor
* @package core
* @autho Wised Wisesvatcharajaren
* @access private
* @created 01/10/2015
*/
include("function/function.php");

$siteDetail = getGroupStaff($_SESSION['session_group']);

?>
<style>
	div#topic{
		margin-top:10px;
	}
	div#dashboard{
		margin-top:10px;
	}
	div#detail{
		margin-top:10px;
		margin-bottom:10px;
	}
	div#location{
		font-weight:bold;
	}
	#tbl-detail tbody tr:nth-child(odd) {background: #fff} /*ปรับสีสลับช่องตารางแดชบอร์ด*/
	#tbl-detail tbody tr:nth-child(even) {background:#F2F4F4}
	#tbl-detail tbody tr:hover{ background-color:#FF9;}
</style>
<div id="topic">
    <table align="center" width="100%" id="tbl-topic">
    	<tr>
        	<td align="center" style="font-size:20px; font-weight:bold;">รายงานการรับเงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด</td>
        </tr>
        <tr>
        	<td align="center" style="font-size:20px; font-weight:bold;"><?php echo $siteDetail[$_SESSION['session_group']]['groupname'];?> ประจำปีงบประมาณ <?php echo date('Y')+543;?></td>
        </tr>
    </table>
</div>
<div id="dashboard">
	<table width="80%" align="center">
    	<tr>
        	<td align="center">
                <!-- exsum -->
                    <table align="center" width="60%" cellpadding="1" cellspacing="1" id="tbl-dashboard" bgcolor="#BBCEDD">
                    	<tr>
                        	<td align="center" style="font-weight:bold; padding:5px;" bgcolor="#DFDFDF" width="60%">รายการ</td>
                            <td align="center" style="font-weight:bold; padding:5px;" bgcolor="#DFDFDF" width="40%" colspan="2">จำนวน</td>
                        </tr>
                        <tr>
                            <td align="left" style="font-weight:bold; padding:5px;" bgcolor="#F2F4F4" width="60%">จำนวนผู้มีสิทธิ์รับเงินอุดหนุน</td>
                            <td align="right" style="font-weight:bold; padding:5px;" bgcolor="#FFFFFF" width="20%">100</td>
                            <td align="center" style="font-weight:bold; padding:5px;" bgcolor="#FFFFFF" width="20%">คน</td>
                        </tr>
                        <tr>
                            <td align="left" style="font-weight:bold; padding:5px;" bgcolor="#F2F4F4" width="60%">จำนวนบุตรของผู้มีสิทธิ์รับเงินอุดหนุน</td>
                            <td align="right" style="font-weight:bold; padding:5px;" bgcolor="#FFFFFF" width="20%">100</td>
                            <td align="center" style="font-weight:bold; padding:5px;" bgcolor="#FFFFFF" width="20%">คน</td>
                        </tr>
                        <tr>
                            <td align="left" style="font-weight:bold; padding:5px;" bgcolor="#F2F4F4" width="60%">จำนวนเงินอุดหนุนทั้งหมด</td>
                            <td align="right" style="font-weight:bold; padding:5px;" bgcolor="#FFFFFF" width="20%">40000.00</td>
                            <td align="center" style="font-weight:bold; padding:5px;" bgcolor="#FFFFFF" width="20%">บาท</td>
                        </tr>
                    </table>
                <!-- exsum -->
            </td>
        </tr>
    </table>
	
</div>
<table align="center" width="80%" cellpadding="1" cellspacing="1">
	<tr>
    	<td align="right">
        	ข้อมูล ณ วันที่ <?php $today = $con->reportDay($lastdate); echo $today[0].' '.$today[1].' '.($today[2]+543); ?> เวลา <?php echo $lasttime; ?>
        </td>
    </tr>
    <tr>
    	<td align="right">
        	รายงาน ณ วันที่ <?php $today = $con->reportDay(date('j/n/Y')); echo $today[0].' '.$today[1].' '.($today[2]+543); ?>
        </td>
    </tr>
</table>
<div id="detail">
	<table align="center" width="80%" cellpadding="1" cellspacing="1" id="tbl-detail" bgcolor="#BBCEDD">
        <thead>
            <tr bgcolor="#DFDFDF">
                <th align="center" style="font-weight:bold; padding:5px;">ประจำเดือน</th>
                <th align="center" style="font-weight:bold; padding:5px;">จำนวนผู้มีสิทธิ์รับเงินอุดหนุน</th>
                <th align="center" style="font-weight:bold; padding:5px;">จำนวนบุตรของผู้มีสิทธิ์รับเงินอุดหนุน</th>
                <th align="center" style="font-weight:bold; padding:5px;">จำนวนเงินอุดหนุน</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $arrMonth = monthInYear();
                foreach( $arrMonth as $numMonth => $monthValue ){
                    $link = '<a href="?p=doc_dr04&month='.$numMonth.'">'.$monthValue.'</a>';
                    echo '<tr bgcolor="#FFFFFF">';
                    echo '<td align="left" width="40%" style="padding:5px;">'.$link.'</td>';
                    echo '<td align="right" width="20%" style="padding:5px;">xx</td>';
                    echo '<td align="right" width="20%" style="padding:5px;">xx</td>';
                    echo '<td align="right" width="20%" style="padding:5px;">xxx.xx</td>';
                    echo '</tr>';
                }
            ?>
         </tbody>	
    </table>
</div>