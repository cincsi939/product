<?
/**
* @comment config ��ҵ���ðҹ������
* @projectCode PS56DSDPW04
* @tor -
* @package core
* @author Suwat.k
* @access private
* @created 16/05/2014
*/
$iphost = $_SERVER[SERVER_NAME]; # ��ҧ�֧ host
define("DB_MASTER","csg_master"); # ����ðҹ������ master
define("DB_DATA","csg_data"); # ����ðҹ������ data
define("DB_USERMANAGER","csg_usermanager"); # ����ðҹ������ usermanager

define("HOST_DEFAULT","localhost"); # ��� Default �ͧ host
define("HOST",$iphost); # ��� host ���ú connect db
define("USER",'root'); # ��� username ����Ѻ connect db
define("PWD",'SPRD525@sapphire'); # ��� pwd ����Ѻ connect db

define("HOMEPAGE_MAIN",'http://csg.dcy.go.th/'); # ��� pwd ����Ѻ connect db

## ��� define ����Ѻ folder appliction
define('APP_MASTER','csg_master');
define('APP_SUPPORT','csg_support');
define('APP_REPORTBUILDER','reportbuilder_csg');
define('APP_REPO','repo_csg');	
?>