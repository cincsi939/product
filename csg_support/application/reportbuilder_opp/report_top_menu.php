<?php
/**
 * @comment menu
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    21/07/2014
 * @access     public
 */
if(!isset($_SESSION['uname'])){
	echo "<script>window.location='login.php'</script>";
}
?>
<table border=0 width="100%" cellspacing=1 bgcolor="#BBBBBB">
    <tr bgcolor="#bbbbbb">
        <td align=center width="150" BGCOLOR="#EEEEEE"> <FONT COLOR="#0066FF"><b>Report&nbsp;Builder</b></FONT> </td>
        <td align=center width="100"> <a href="report_manage.php?action=new"><b><u>New</u></b></a> </td>
        <td align=center width="100"> <a href="report_manage.php"><b><u>Load</u></b></a> </td>
        <td align=center width="100"> <a href="report_group.php"><b><u>Group</u></b></a> </td>
        <?php
        if ($_SESSION['priv'] == 'A'){
        ?>
        <td align=center width="100"> <a href="report_user.php"><b><u>User</u></b></a> </td>
        <?php
        }	
        ?>
        <td align=center width="60%">&nbsp;  </td>
        <td align=center width="100"> <a href="login.php?logout"><b><u>Exit</u></b></a> </td>
    </tr>
</table>