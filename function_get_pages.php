<?php
function getPaging($strSQL, $page_all, $page, $per_page, $View='', $param_like='',$dir_img='../../'){
	global $onMobile;
					$all_row = $page_all;
					$board_row_per_page = $per_page;
					
					$page_all = ceil($all_row / $board_row_per_page);
					$total_page = ($page_all<=0)?1:$page_all;
					
					$page = ($page)?$page:1;
					$page = ($page > $total_page)?$total_page:$page;
					$page = ($page <= 0)?1:$page;
					
					$limit_start = ($page==1)?0:(($page*$board_row_per_page)-$board_row_per_page);
					$limit_end = $board_row_per_page;
					
					if($View==''){
						$strSQL .= " LIMIT ".$limit_start.", ".$limit_end;
						$num = $limit_start ;
					}
					
					$prev_page = $page - 1; $prev_page = ($prev_page <= 1)?1:$prev_page;
					$prev = "self.location='".$PHP_SELF."?".$param_like."&Sort=$Sort&page=$prev_page'";
					$next_page = $page + 1; $next_page = ($next_page >= $total_page)?$total_page:$next_page;
					$next = "self.location='".$PHP_SELF."?".$param_like."&Sort=$Sort&page=$next_page'";
					
					$prev_Tenpage=$page-$board_row_per_page;$prev_Tenpage=($prev_Tenpage<= 1)?1:$prev_Tenpage;
					$prevTen = "self.location='".$PHP_SELF."?".$param_like."&Sort=$Sort&page=$prev_Tenpage'";
					$nextTenPage=$page+$board_row_per_page;$next_TenPage=($next_TenPage >= $total_page)?$total_page:$next_TenPage;
					$nextTen = "self.location='".$PHP_SELF."?".$param_like."&Sort=$Sort&page=$nextTenPage'";
		
			 if($View==""){
					$Klink="?".$param_like."&View=All"; 
					$CSh="ข้อมูลทั้งหมด"; 
					$Klink2="?".$param_like."&View=";
				}else{
					$Klink="?".$param_like."&View=";
					$CSh="ข้อมูลรายการล่าสุด";
					$Klink2="?".$param_like."&View=All";
				}?>
			ทั้งหมด <B> <FONT color="#CC0000">
			<?php echo number_format($all_row);?>
			</FONT> </B> รายการ
			<?php if($View==""){?>
			แบ่งเป็น <B><FONT color="#0033CC">
			<?php echo number_format($total_page);?>
			</FONT></B> หน้า
			<?php }?>&nbsp;&nbsp;&nbsp;  
            	<?php if($onMobile == true){ ?>
					<IMG src="<?php echo $dir_img ?>images/Search-Add.gif" width="16" height="16" border="0" style="cursor:pointer;" align="absmiddle" />
                    <?php }else{ ?>
                    <A href="<?php echo $Klink?>"><IMG src="<?php echo $dir_img ?>images/Search-Add.gif" width="16" height="16" border="0" style="cursor:pointer;" align="absmiddle" /></A>
                    <?php } ?>
                    &nbsp;&nbsp;
					<?php  if($View==''){?>
					<?php  if($page==1){?>
				  <IMG src="<?php echo $dir_img ?>images/page_div_icon/xFirst.gif"  align="absmiddle" />
				  <?php }else{?>
				  <IMG src="<?php echo $dir_img ?>images/page_div_icon/First.gif" align="absmiddle" border="0" width="10" height="12"  onclick="<?=$prevTen;?>" onMouseOver="style.cursor='hand';"/>
				  <?php }?>
				&nbsp;
				<?php  if($page==1){?>
				<IMG src="<?php echo $dir_img ?>images/page_div_icon/xPrevious.gif" align="absmiddle" />
				<?php }else{?>
				<IMG src="<?php echo $dir_img ?>images/page_div_icon/Previous.gif" align="absmiddle" border="0" width="7" height="12"  onclick="<?php echo $prev;?>" style="cursor:pointer;"/>
				<?php }?>
				<?php
				$board_link_num = $board_row_per_page;
				$ii = 1;
				if ( $board_link_num > $total_page ){
					$loop_page = $total_page;
				
				} else {
								$bx = ceil($board_link_num / 2);
								$pp = $page - $bx;
								$pn = $page + $bx;
								$loop_page = $pn;
								$ii = $page;
								//echo $bx;
								if ( $total_page <= $loop_page ) {
									$loop_page = $total_page;
									$ii = $loop_page - ($board_link_num -1);
								}
								if ( $ii < 1 ) {
									$ii = 1;
									$loop_page = $ii + ($board_link_num -1);
								}
				}
		
				for($i=$ii;$i<=$loop_page;$i++){
					if ( $i==$page || !$page ) {
						$txt = "<b>$i</b>";
					} else {
						$txt = $i;
				
					}
				?>
						<A href="<?php echo $PHP_SELF;?>?<?php echo $param_like;?>&Sort=<?php echo $Sort;?>&amp;page=<?php echo $i;?>">
						  <?php echo $txt;?></A>
						<?php
				} # for
				?>
				<?php if($page==$loop_page){?>
				<IMG src="<?php echo $dir_img ?>images/page_div_icon/xNext.gif" align="absmiddle" />
				<?php }else{?>
				<IMG src="<?php echo $dir_img ?>images/page_div_icon/Next.gif" align="absmiddle" border="0" width="7" height="12" onClick="<?=$next;?>" style="cursor:pointer;"/>
				<?php }?>
				&nbsp;
				<?php if($page==$loop_page){?>
				<IMG src="<?php echo $dir_img ?>images/page_div_icon/xLast.gif" align="absmiddle" />
				<?php }else{ ?>
				<IMG src="<?php echo $dir_img ?>images/page_div_icon/Last.gif" align="absmiddle" border="0" width="10" height="12" onClick="<?php echo $nextTen;?>" style="cursor:pointer;" />
				<?php 
				} 
		}#End View=
	return $strSQL;
}
?>