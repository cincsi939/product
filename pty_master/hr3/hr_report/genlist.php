<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
			  <table width="100%" border="0" cellspacing="2" cellpadding="0">
			  <tr align="left">
				<td height="24" bgcolor="#1D5B84" class="plink"> <?=$session_thname?> (<?=$secname0?>) </td>
			  </tr>
				<?
						if($_SESSION[applistid]!=""){
						foreach ($_SESSION[applistid] as $value){

						$sql = " SELECT *  FROM  app_list  LEFT JOIN  app_group  ON app_list.gid = app_group.gid  WHERE  id = '$value'  AND  app_group.gid = '$rsx[gid]'  ORDER BY  id ;";
						$rerult = mysql_db_query($dbname,$sql);
						$rs=mysql_fetch_assoc($rerult);

						if($rs){
				?>
				<tr>
					<td class="index1">
		<a href="<?=$rs[app_url]?>" target="_blank"><img src="<?=$rs[icon]?>" alt="<?=$rs[appname]?>" width="12" height="12" border="0"></a>
			<a href="<?=$rs[app_url]?>" target="<?=$rs[targetpage]?>" class="link_back" ><?=$rs[caption]?>
					</a>	
					</td>
			    </tr>
				<? 
					} // end if
					} //  end for
					}  // end if($_SESSION[applistid]!="")
				?>
		
		  <tr>
			<td height="20" align="right" bgcolor="#1D5B84">&nbsp;
			</td>
		  </tr>
		</table>
