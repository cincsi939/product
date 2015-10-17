<?php
/**
 * Title: menu page etc_tool system
 * Author: Kaisorrawat Panyo
 * Date: 14/10/2558
 * Time: 
 */
#############################################################
$ApplicationName   = 'etc_tool';
$VERSION             = "1.0";
#############################################################	
?>
<style>
.menu_list a.active{
	font-family: !important;
	font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
	 font-size:18px;
	 text-shadow:#FFF;
	 TEXT-DECORATION:none;
	 COLOR: #f3960b;
	 font-weight:bold;
}
</style>
<div class="col-md-3 col-lg-3 visible-md visible-lg" style="margin-top: -30px;">
    <br>
    <h4 style="
    font-family: ThaiSansNeue-Regular;
    font-size: 24px;
    font-weight: bold;
    color: #3170A6 ">&nbsp;&nbsp;รายการข้อมูล</h4>
	<?php
	include("config.php");
	// echo "<pre>";
// 	print_r($arr_table);
	?>
    <table width="97%" border="0" cellspacing="1" cellpadding="5" align="right" class="menu_list">
		<?php
		
		foreach($arr_table as $key => $value){
			
		?>
		<tr>
			
			<td><a href="index.php?p=dashboard&table=<?=$key?>" class="<?php echo $_GET['table'] == $key?'active':'' ?>"><span><?php  echo $value[tableName]."<br>" ?></span></a></td>
			
		</tr>
		<?php
		}	
		?>
        <tr>
            <td><a href="../../../dcy_usermanager/application/logout.php"><img src="../../images/images_donate/Apps-Dialog-Shutdown-icon.png" align="absmiddle"  width="24" border="0">&nbsp;<span >ออกจากระบบ</span></a></td>
        </tr>
    </table>
</div>