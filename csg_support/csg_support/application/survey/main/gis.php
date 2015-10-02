<?
$name = $xml->Position1->NodeData1." ".$xml->Position1->NodeData4." ".$xml->Position1->NodeData5;
$picture= $xml->Position1->NodeData42->DataImage;
$gender = $showgender;
$address = $showaddress;
$money = $showmoney;
?><div class="container">
	<div class="infodata" >
<table width="100%"  height="296" border="0" cellpadding="3" cellspacing="0" class="personal_tb">
      <tr>
        <td height="28" colspan="4" align="left" valign="top" bgcolor="#f2f2f2"><div class="infodata_font">GIS View</div></td>
      </tr>
      <tr>
        <td colspan="4" valign="top" height="500"><iframe src="show_point/gis.php?id=<? echo $_GET['id'];?>&x=14.7868442&y=100.4507775" style="border:none; height:500px; width:100%"></iframe></td>
      </tr>
    </table>

	</div>

</div>
