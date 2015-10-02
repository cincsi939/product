<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr><td align="center"><img src="images/banner.png"></td></tr>


<script>
		function goBack() {
			window.history.back();
		}
	</script>
	
<tr><td colspan='2' align='right'> &nbsp;&nbsp;<img src="images/back-button.png" width="33" height='20' title="<?php echo  iconv('UTF-8','TIS-620',"ย้อนกลับ") ?>" onclick="goBack()"> &nbsp;&nbsp;</td><tr>

<?php if($_GET['condition_label'] != ""){ ?>
<tr><td colspan='2' align='left'> 
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td align='left'><?php echo $_GET['condition_label']; ?></td></tr></table>
</td><tr>
<?php } ?>

</table>