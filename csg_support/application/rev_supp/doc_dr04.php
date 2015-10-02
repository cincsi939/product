<?php
/**
* @comment Ẻ��§ҹ����Ѻ�Թ�ش˹ع���͡������§�����á�Դ (��.04)
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
            Ẻ ��.04
        </td>
    </tr>
    <tr>
    	<td align="center" class="topic" colspan="2">Ẻ��§ҹ����Ѻ�Թ�ش˹ع���͡������§�����á�Դ</td>
    </tr>
    <tr>
    	<td align="center" class="topic" colspan="2">��Ш���͹ <?php echo $month;?></td>
    </tr>
    <tr>
    	<td align="center" class="topic" colspan="2"><?php echo $siteDetail[$_SESSION['session_group']]['groupname'];?></td>
    </tr>
</table>
<table id="tbl-detail" width="99%" align="center">
	<thead>
        <tr>
            <th align="center" rowspan="2" width="6%">�ӴѺ���</th>
            <th align="center" rowspan="2" width="15%">����-ʡ�� ˭ԧ��駤����</th>
            <th align="center" rowspan="2" width="16%">�������</th>
            <th align="center" rowspan="2" width="15%">�������á�Դ<br>����Ѻ�Թ�ش˹ع�</th>
            <th align="center" rowspan="2" width="12%">�ѹ/��͹/�� �Դ</th>
            <th align="center" rowspan="2" width="12%">�ѹ���������Ѻ�Թ</th>
            <th align="center" rowspan="2" width="10%">�ӹǹ�Թ</th>
            <th colspan="2"  align="center" width="14%">��ѡ�ҹ��è����Թ</th>
        </tr>
        <tr>
            <th align="center" width="7%">�Ѻ�Թʴ</th>
            <th align="center" width="7%">�͹�Թ</th>
        </tr>
     </thead>
     <tbody>
     	<tr>
            <td align="center">1</td>
            <td>�ҧ ���ͺ �к�</td>
            <td>199/445 ��ҹ�ǹ������� �.˹ͧ���� �.�ѹ���� ��§����</td>
            <td>�硪�� ���ͺ �к�</td>
            <td align="center">1 ���Ҥ� 2558</td>
            <td align="center">1 ���Ҥ� 2558</td>
            <td align="right">400</td>
            <td align="center">&radic;</td>
            <td align="center"></td>
        </tr>
        <tr>
            <td align="center">2</td>
            <td>�ҧ ���ͺ �к�</td>
            <td>199/445 ��ҹ�ǹ������� �.˹ͧ���� �.�ѹ���� ��§����</td>
            <td>�硪�� ���ͺ �к�</td>
            <td align="center">1 ���Ҥ� 2558</td>
            <td align="center">1 ���Ҥ� 2558</td>
            <td align="right">400</td>
            <td align="center"></td>
            <td align="center">&radic;</td>
        </tr>
        <tr>
            <td align="left" colspan="6" style="font-weight:bold; padding-left:20px;">������Թ������ (����ѡ��)</td>
            <td align="center" colspan="3" style="font-weight:bold;"></td>
        </tr>
     </tbody>
</table>
<?php
	if( $_GET['pdf'] == '1' ){
?>
    <table id="tbl-comment" width="99%" align="center">
        <tr>
            <td align="left">�ѭ���ػ��ä��辺 / ����ʹ��� ........................................................................................................................................................................................................................................................................................</td>
        </tr>
        <tr>
            <td align="left">................................................................................................................................................................................................................................................................................................................................................</td>
        </tr>
    </table>
    <table id="tbl-sign" width="99%" align="center">
        <tr>
            <td width="50%"></td>
            <td>�����§ҹ...............................................................................................</td>
        </tr>
         <tr>
            <td width="50%"></td>
            <td style="padding-left:50px;">(...............................................................................................)</td>
        </tr>
        <tr>
            <td width="50%"></td>
            <td>���˹�...............................................................................................</td>
        </tr>
        <tr>
            <td width="50%"></td>
            <td align="center">�ѹ��� ��͹ �� �����§ҹ</td>
        </tr>
        <tr>
            <td width="50%"></td>
            <td align="center">......../......../..........</td>
        </tr>
    </table>
<?php
	}
?>