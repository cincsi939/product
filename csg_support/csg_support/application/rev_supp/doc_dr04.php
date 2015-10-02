<?php
/**
* @comment แบบรายงานการรับเงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด (ดร.04)
* @projectCode P2
* @tor
* @package core
* @autho Wised Wisesvatcharajaren
* @access private
* @created 01/10/2015
*/

if( $_GET['pdf'] == '1' ){
	echo '<link rel="stylesheet" href="css/doc_dr04_pdf.css">';
	include('../../config/config_host.php');
	include('../survey/lib/class.function.php');
	$con = new Cfunction();
	$con->connectDB();
}else{
	echo '<link rel="stylesheet" href="css/doc_dr04_preview.css">';
}

include("function/function.php");

$siteDetail = getGroupStaff($_SESSION['session_group']);
$month = monthInYear($_GET['month']);

?>
<table id="tbl-topic" width="100%">
	<tr>
    	<td width="92%">
        	<?php
				if( $_GET['pdf'] != '1' ){
			?>
            		<a><img src="../img/pdf.gif" align="absmiddle" style="float:left"/></a>
            <?php
				}
			?>
        </td>
    	<td align="center" style="border:1px solid #000">
            แบบ ดร.04
        </td>
    </tr>
    <tr>
    	<td align="center" class="topic" colspan="2">แบบรายงานการรับเงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด</td>
    </tr>
    <tr>
    	<td align="center" class="topic" colspan="2">ประจำเดือน <?php echo $month;?></td>
    </tr>
    <tr>
    	<td align="center" class="topic" colspan="2"><?php echo $siteDetail[$_SESSION['session_group']]['groupname'];?></td>
    </tr>
</table>
<table id="tbl-detail" width="99%" align="center">
	<thead>
        <tr>
            <th align="center" rowspan="2" width="6%">ลำดับที่</th>
            <th align="center" rowspan="2" width="15%">ชื่อ-สกุล หญิงตั้งครรภ์</th>
            <th align="center" rowspan="2" width="16%">ที่อยู่</th>
            <th align="center" rowspan="2" width="15%">ชื่อเด็กแรกเกิด<br>ที่รับเงินอุดหนุนฯ</th>
            <th align="center" rowspan="2" width="12%">วัน/เดือน/ปี เกิด</th>
            <th align="center" rowspan="2" width="12%">วันที่เริ่มรับเงิน</th>
            <th align="center" rowspan="2" width="10%">จำนวนเงิน</th>
            <th colspan="2"  align="center" width="14%">หลักฐานการจ่ายเงิน</th>
        </tr>
        <tr>
            <th align="center" width="7%">รับเงินสด</th>
            <th align="center" width="7%">โอนเงิน</th>
        </tr>
     </thead>
     <tbody>
     	<tr>
            <td align="center">1</td>
            <td>นาง ทดสอบ ระบบ</td>
            <td>199/445 บ้านสวนนนทรีย์ ต.หนองจ๊อม อ.สันทราย เชียงใหม่</td>
            <td>เด็กชาย ทดสอบ ระบบ</td>
            <td align="center">1 ตุลาคม 2558</td>
            <td align="center">1 ตุลาคม 2558</td>
            <td align="right">400</td>
            <td align="center">&radic;</td>
            <td align="center"></td>
        </tr>
        <tr>
            <td align="center">2</td>
            <td>นาง ทดสอบ ระบบ</td>
            <td>199/445 บ้านสวนนนทรีย์ ต.หนองจ๊อม อ.สันทราย เชียงใหม่</td>
            <td>เด็กชาย ทดสอบ ระบบ</td>
            <td align="center">1 ตุลาคม 2558</td>
            <td align="center">1 ตุลาคม 2558</td>
            <td align="right">400</td>
            <td align="center"></td>
            <td align="center">&radic;</td>
        </tr>
        <tr>
            <td align="left" colspan="6" style="font-weight:bold; padding-left:20px;">รวมเป็นเงินทั้งสิ้น (ตัวอักษร)</td>
            <td align="center" colspan="3" style="font-weight:bold;"></td>
        </tr>
     </tbody>
</table>
<?php
	if( $_GET['pdf'] == '1' ){
?>
    <table id="tbl-comment" width="99%" align="center">
        <tr>
            <td align="left">ปัญหาอุปสรรค์ที่พบ / ข้อเสนอแนะ ........................................................................................................................................................................................................................................................................................</td>
        </tr>
        <tr>
            <td align="left">................................................................................................................................................................................................................................................................................................................................................</td>
        </tr>
    </table>
    <table id="tbl-sign" width="99%" align="center">
        <tr>
            <td width="50%"></td>
            <td>ผู้รายงาน...............................................................................................</td>
        </tr>
         <tr>
            <td width="50%"></td>
            <td style="padding-left:50px;">(...............................................................................................)</td>
        </tr>
        <tr>
            <td width="50%"></td>
            <td>ตำแหน่ง...............................................................................................</td>
        </tr>
        <tr>
            <td width="50%"></td>
            <td align="center">วันที่ เดือน ปี ที่รายงาน</td>
        </tr>
        <tr>
            <td width="50%"></td>
            <td align="center">......../......../..........</td>
        </tr>
    </table>
<?php
	}
?>