<?
set_time_limit(1000);
include "../../inc/conndb_nonsession.inc.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Untitled Document</title>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link href="../../common/style.css" type="text/css" rel="stylesheet">

</head>

<body>
<div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab" tabindex="0">Tab 1</li>
    <li class="TabbedPanelsTab" tabindex="0">Tab 2</li>
  </ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent">
      <table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
        <tr bgcolor="#A3B2CC">
          <td width="7%" align="center" bgcolor="#4752A3" class="plink">�ӴѺ</td>
          <td width="36%" align="center" bgcolor="#4752A3" class="plink">appname</td>
          <td width="28%" align="center" bgcolor="#4752A3" class="plink">URL</td>
          <td width="13%" align="center" bgcolor="#4752A3" class="plink">&nbsp;</td>
          <td width="16%" align="center" bgcolor="#4752A3" class="plink">&nbsp;</td>
        </tr>
        <?php
		$i = 0;
		$no=0;
		$max=0;
		$result = mysql_query("select * from app_list   order by id  ;");
		while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)) 
		{		
			$i++;
			$no++;
			if ($rs[id] > $max) $max=$rs[id];
			
			if ($i % 2){
				$bg="#FFFFFF";
			}else{
				$bg="#F0F0F0";
			}
		?>
        <tr bgcolor="<?=$bg?>">
          <td width="7%" height="28" align="center"><?=$no?></td>
          <td width="36%"><a href="org_left.php?appid=<?=$rs[id]?>&amp;appname=<?=$rs[appname]?>" target="mainFrame" title="<?=$rs[caption]?>"><? echo $rs[caption];?><br />
            [
                <?=$rs[appname]?>
            ]</a></td>
          <td width="28%"><? echo $rs[app_url];?></td>
          <td width="13%" align="center">&nbsp;</td>
          <td width="16%" align="center">&nbsp;</td>
        </tr>
        <?
		} // while
		$id = $max + 1;
		?>
      </table>
    </div>
    <div class="TabbedPanelsContent">Content 2</div>
  </div>
</div>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</body>
</html>
