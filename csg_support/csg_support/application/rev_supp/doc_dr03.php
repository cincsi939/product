<?php
/**
* @comment หน้า dashboard ในส่วนขอการรับเงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด
* @projectCode P2
* @tor
* @package core
* @author Eakkasit Kamwong
* @access private
* @created 01/10/2015
*/
require_once('../../config/config_host.php');
require_once('../survey/lib/class.function.php');
include('./function/function.php');

$org_name_arr = getGroupStaff($_SESSION['session_group']);
?>
<style>
	.doc_head{
	    border-style: solid;
		width: 100px;
		padding: 5px;
		text-align: center;
		border-width: thin;	
	}
	.tbl_dr03{
		padding: 30px 100px 0px 100px;	
	}
	.text_for_id{
		float:left;
	}
	.text_id{
		border-style: solid;
		border-width: thin;
		padding: 0px 12px 0px 12px;
		width:10px;
		float:left;
		margin: 0px 0px 0px 10px;
	}
	.text_id_no_left{
		border-style: solid;
		border-width: thin;
		padding: 0px 12px 0px 12px;
		border-left-style: none;
		float:left;
		width:10px;
	}
</style>
<table width="98%" align="center" class="tbl_dr03">
	<tr>
		<td align="right" colspan="2">
			<table class="doc_head">
				<tr>
					<td>
				แบบ ดร.03
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="right" colspan="2">
			<b>เลขทีี่...............................................</b>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<b>แบบใบสำคัญเงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด</b>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<b>ประจำเดือน <?php echo $arr_mount['1'] ?>  พ.ศ.  <?php echo $year ?></b>
		</td>
	</tr>
	<tr>
		<td  align="right" colspan="2">
			<?php echo $org_name_arr[$_SESSION['session_group']]['groupname']; ?>
		</td>
	</tr>
	<tr>
		<td  align="right" colspan="2">
			วันที่ ................<?php echo $date_now ;?>.....................  เดือน  ........................<?php echo $arr_month['2']; ?>.................... พ.ศ.  ..........<?php echo $year_now; ?>.............
		</td>
	</tr>
	<tr>
		<td>
			ข้าพเจ้า .........................................................................................................................................................................................................................................................
		</td>
	</tr>
	<tr>
		<td>
			<div class="text_for_id">
				เลขประจำตัวประชาชน  
			</div>
			&nbsp;&nbsp;&nbsp; 
			<div class="text_id">&nbsp;</div>
			&nbsp;&nbsp;
			<div class="text_id">&nbsp;</div>
			<div class="text_id_no_left">&nbsp;</div>
			<div class="text_id_no_left">&nbsp;</div>
			<div class="text_id_no_left">&nbsp;</div>
			&nbsp;&nbsp;
			<div class="text_id">&nbsp;</div>
			<div class="text_id_no_left">&nbsp;</div>
			&nbsp;&nbsp;
			<div class="text_id">&nbsp;</div>
			<div class="text_id_no_left">&nbsp;</div>
			<div class="text_id_no_left">&nbsp;</div>
			&nbsp;&nbsp;
			<div class="text_id">&nbsp;</div>
			<div class="text_id_no_left">&nbsp;</div>
			&nbsp;&nbsp;
			<div class="text_id">&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%">
				<tr>
					<td width="15%">
						อยู่บ้านเลขที่
					</td>
					<td width="15%">
						
					</td>
					<td width="15%">
						ตรอก/ซอย
					</td>
					<td width="15%">
						
					</td>
					<td width="15%">
						ถนน
					</td>
					<td>
						
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%" >
				<tr>
					<td width="15%">
						ตำบล/แขวง
					</td>
					<td width="15%">
						
					</td>
					<td width="15%">
						อำเภอ/เขต
					</td>
					<td width="15%">
						
					</td>
					<td width="15%">
						จังหวัด
					</td>
					<td>
						
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			ได้รับเงินอุดหนุนเพื่อนการเลี้ยงดูเด็กแรกเกิดของ 
		</td>
	</tr>
	<tr>
		<td>
			<div class="text_for_id">
				เลขประจำตัวประชาชนเด็ก 
			</div>
			&nbsp;&nbsp;&nbsp; 
			<div class="text_id">1</div>
			&nbsp;&nbsp;
			<div class="text_id">1</div>
			<div class="text_id_no_left">5</div>
			<div class="text_id_no_left">0</div>
			<div class="text_id_no_left">9</div>
			&nbsp;&nbsp;
			<div class="text_id">9</div>
			<div class="text_id_no_left">3</div>
			&nbsp;&nbsp;
			<div class="text_id">8</div>
			<div class="text_id_no_left">2</div>
			<div class="text_id_no_left">4</div>
			&nbsp;&nbsp;
			<div class="text_id">5</div>
			<div class="text_id_no_left">6</div>
			&nbsp;&nbsp;
			<div class="text_id">1</div>
		</td>
	</tr>
	<tr>
		<td>
			เป็นเงิน 400 บาท (สี่ร้อยบาทถ้วน)  ไปถูกต้องแล้ว
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;
		</td>
		<td align="right">
			<center>
				(ลงนาม) ........................................................................ผู้รับเงิน
				<br/>
				(.........................................................................)
			</center>
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;
		</td>
		<td align="right">
			<center>
				(ลงนาม) .....................................................................ผู้จ่ายเงิน
				<br/>
				(.........................................................................)
			</center>			
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;
		</td>
		<td align="right">
			<center>
				(ลงนาม) ............................................................................พยาน
				<br/>
				(.........................................................................)
			</center>
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;
		</td>
		<td align="right">
			<center>
				(ลงนาม) ............................................................................พยาน
				<br/>
				(.........................................................................) 
			</center>
		</td>
	</tr>
</table>