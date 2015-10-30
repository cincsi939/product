<?
set_time_limit(0);
include("../../config/conndb_nonsession.inc.php");
include("../../common/class.datedatakp7.php");

$xidcard = "3470500370274";
$xsiteid = "4702";
$x = new datekp7();
echo $x->date_data($xidcard,$xsiteid);

?>
