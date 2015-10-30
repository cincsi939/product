<? if($all >= 1) { ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr valign="top" class="normal" align="right">
	<td width="46%" align="left">&nbsp;
<?
$page_all = $all / 11 ;
$page_all = ceil($page_all);
//first Eleven Page
if($page <= 11){

	$max = $page;
	if($page <= 11 ){ 	
		if($all <= 11){ $max = $all ; }else{ $max = 11 ; }
		for($i=1;$i<=$max;$i++) 
		{
			if($i != $page){ 
				echo "<a href=\"?page=$i$kwd\" style=\"text-decoration:none;\"><font class=\"normal\">$i</font></a>&nbsp;";  
			} else { 
				echo "<font class=\"blue\">$i</font>&nbsp;";  
			}
		}
		if($all > 11){ 	echo "<a href=\"?page=12$kwd\" style=\"text-decoration:none;\"><font class=\"blue\">Next ></font></a>&nbsp;"; }
	}
	
} elseif($page >= 12) {

	$min = $page - 5;		
	$max = $page + 5;
	if($max >= $all){ $max = $all; $last_page = "y";} 
	$next = $max + 1; 
	$prev = $min - 1;	

	echo "<a href=\"?page=$prev$kwd\" style=\"text-decoration:none;\"><font class=\"blue\">< Prev</font></a>&nbsp;";
	for($i=$min;$i<=$max;$i++) 
	{
		if($i != $page){ echo "<a href=\"?page=$i$kwd\" style=\"text-decoration:none;\"><font class=\"normal\">$i</font></a>&nbsp;";  }
		else { echo "<font class=\"blue\">$i</font>&nbsp;";  }
	}
	if($last_page != "y"){
	echo "&nbsp;<a href=\"?page=$next$kwd\" style=\"text-decoration:none;\"><font class=\"blue\">Next ></font></a>";
	}
}

?>                  
	
	</td>
	<td width="24%">Record found : <font class="blue"><?=$totalpage?></font> Records</td>
	<td width="30%">Number of all page is :&nbsp;<font class="blue"><?=$all?></font>&nbsp;Pages&nbsp;</td>
</tr>
</table>
<? } ?>
