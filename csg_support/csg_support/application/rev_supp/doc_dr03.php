<?php
/**
* @comment ˹�� dashboard ���ǹ�͡���Ѻ�Թ�ش˹ع���͡������§�����á�Դ
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
				Ẻ ��.03
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="right" colspan="2">
			<b>�Ţ����...............................................</b>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<b>Ẻ��Ӥѭ�Թ�ش˹ع���͡������§�����á�Դ</b>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<b>��Ш���͹ <?php echo $arr_mount['1'] ?>  �.�.  <?php echo $year ?></b>
		</td>
	</tr>
	<tr>
		<td  align="right" colspan="2">
			<?php echo $org_name_arr[$_SESSION['session_group']]['groupname']; ?>
		</td>
	</tr>
	<tr>
		<td  align="right" colspan="2">
			�ѹ��� ................<?php echo $date_now ;?>.....................  ��͹  ........................<?php echo $arr_month['2']; ?>.................... �.�.  ..........<?php echo $year_now; ?>.............
		</td>
	</tr>
	<tr>
		<td>
			��Ҿ��� .........................................................................................................................................................................................................................................................
		</td>
	</tr>
	<tr>
		<td>
			<div class="text_for_id">
				�Ţ��Шӵ�ǻ�ЪҪ�  
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
						�����ҹ�Ţ���
					</td>
					<td width="15%">
						
					</td>
					<td width="15%">
						��͡/���
					</td>
					<td width="15%">
						
					</td>
					<td width="15%">
						���
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
						�Ӻ�/�ǧ
					</td>
					<td width="15%">
						
					</td>
					<td width="15%">
						�����/ࢵ
					</td>
					<td width="15%">
						
					</td>
					<td width="15%">
						�ѧ��Ѵ
					</td>
					<td>
						
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			���Ѻ�Թ�ش˹ع���͹�������§�����á�Դ�ͧ 
		</td>
	</tr>
	<tr>
		<td>
			<div class="text_for_id">
				�Ţ��Шӵ�ǻ�ЪҪ��� 
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
			���Թ 400 �ҷ (������ºҷ��ǹ)  件١��ͧ����
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;
		</td>
		<td align="right">
			<center>
				(ŧ���) ........................................................................����Ѻ�Թ
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
				(ŧ���) .....................................................................�������Թ
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
				(ŧ���) ............................................................................��ҹ
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
				(ŧ���) ............................................................................��ҹ
				<br/>
				(.........................................................................) 
			</center>
		</td>
	</tr>
</table>