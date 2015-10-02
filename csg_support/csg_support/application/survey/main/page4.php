<table width="100%" border="0" cellpadding="0" cellspacing="0" height="67" style="background-image:url('images/bg_tab.png');">
  <tbody><tr>
    <td width="50" align="left">
    <br>
    &nbsp;
<a href="?id=<? echo $_GET['id'];?>&frame=form3<? if (!empty($_GET['report_type'])){ echo "&report_type=".$_GET['report_type']; }?>"><img src="images/arrow_left.png" align="absmiddle" border="0"></a>
        </td>
    <td width="25%" align="left">
    <br>
    <span ><a href="?id=<? echo $_GET['id'];?>&frame=form3<? if (!empty($_GET['report_type'])){ echo "&report_type=".$_GET['report_type']; }?>" class="infomenu_next"><? echo $menu3;?></a></span>
    </td>
    <td style="background-image:url('images/background_tab.png'); background-position:center; background-repeat:no-repeat;" width="448" align="center">
    <br>
   <span class="infomenu"><? echo $menu4;?></span>
    </td>
    <td width="25%" align="right">
    <br>
    <span class="infomenu_next"></span>
    </td>
    <td width="50" align="right">
    <br>
<? /*<img src="images/arrow_right.png" align="absmiddle" border="0">*/?>
        &nbsp;
    </td>
  </tr>
</tbody></table>
<?
/*
$con = new Cfunction();
$con->connectDB();
//$sql = 'SELECT question_summary,question_comment FROM question_detail_1 where question_id = '.$row['question_id'];
$sql = "select siteid,form_id,number_action,pin,child_userid,vid,yy,mm,value,reportdate from eq_var_data where siteid=1 AND form_id=4 AND pin='".$xml->Position1->NodeData7."'";
$results = $con->select($sql);
foreach($results as $row){
	$value['v'.$row['vid']] = $row['value'];	
}
*/
?>
<div class="container">
	<div class="infodata" >
<table width="100%"  height="296" border="0" cellpadding="3" cellspacing="0" class="personal_tb">
      <tr>
        <td height="28" colspan="4" align="left" valign="top" bgcolor="#f2f2f2"><div class="infodata_font">สรุปความคิดเห็น</div></td>
      </tr>
      <tr>
        <td colspan="4" valign="top"><table width="95%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="30%" align="right" valign="top" class="td_question">การสรุปและประเมินผล : </td>
            <td align="left" valign="top" class="td_answer"><?php if ($value['v404'] != ""){echo $value['v404']; } else { echo "-";}?></td>
          </tr>
          <tr>
            <td align="right" valign="top" class="td_question">ความคิดเห็น/ข้อเสนอแนะของผู้สำรวจ : </td>
            <td align="left" valign="top" class="td_answer"><?php if ($value['v405'] != ""){echo $value['v405']; } else { echo "-";}?></td>
          </tr>
        </table></td>
      </tr>
    </table>

	</div>

</div>
