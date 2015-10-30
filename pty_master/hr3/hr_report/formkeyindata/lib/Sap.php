<?php

/**
 * RD
 *
 * Not opensource application
 *
 * @class       Sap()
 * @package     Lib
 * @author      Nattapong Charoensook <nattapong@sapphire.co.th>
 * @copyright   Copyright (c) 2012-2013
 * @version     1.0
 *
 */
require_once('Mysql.php');

class Sap {

    protected $__client_ip;

    /**
     * @var string  Keep table name for client object
     */
    protected $__tablename;
    protected $__pkkey;

    /**
     * @var number  Paging System
     */
    protected $__showpage;
    protected $__totalpage;

    /**
     * @var number  Mysql Record
     */
    protected $__recordcount;
    protected $__lastidinsert;
    protected $__affectedrows;

    /**
     * @var string  Keep status of Error or System message
     */
    protected $__errmsg;
    protected $__errcolor;

    /**
     * @var \Mysql|null Keep Mysql object to use in this class
     */
    private $M;

    public function __construct() {
        $this->__showpage = 15;
        $this->__pkkey = "";

        $this->__totalpage = 0;

        $this->__affectedrows = 0;
        $this->__recordcount = 0;
        $this->__lastidinsert = 0;

        $this->__errmsg = "";
        $this->__errcolor = "#ff0000";

        $this->M = new Mysql();
    }

    /**
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param string $dbs
     * @return bool
     */
    public function init($host='', $user='', $pass='', $dbs='') {
        if($host != '') {
            $this->M->setHostName($host);
        }

        if($user != '') {
            $this->M->setDbUser($user);
        }

        if($pass != '') {
            $this->M->setDbPass($pass);
        }

        if($dbs != '') {
            $this->M->setDbs($dbs);
        }

        return true;
    }

    /**
     * @param string $dbs
     */
    public function changeDB($dbs='') {
        if($dbs != '') {
            $this->M->setDbs($dbs);
        }
    }

    /**
     * @param $errmsg
     * @return void
     */
    public function setErrMsg($errmsg) {
        if($errmsg) {
            $this->__errmsg = "<font color='".$this->__errcolor."'>".$errmsg."</pre>";
        }
    }

    /**
     * @return string
     */
    public function getErrMsg() {
        return $this->__errmsg;
    }

    /**
     * @param string $name
     * @param null $ignore
     * @return null|string|int
     */
    public function valPostGet($name = "", $ignore = null) {

        if($_POST[$name]) {
            return $_POST[$name];
        }
        elseif($_GET[$name]) {
            return $_GET[$name];
        }
        elseif($_FILES[$name]) {
            return $_FILES[$name];
        }
        else {
            return $ignore;
        }

    }

    /**
     * @return string
     */
    public function getRealIpAddr()
    {
        $ip = "";

        if(!empty($_SERVER['HTTP_CLIENT_IP']))   //Check ip from share internet
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   // Check ip is pass from proxy
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * @param string $str
     * @return bool
     */
    public function isDigit($str = '')
    {
        if( ! is_string($str) OR $str == '')
        {
            return FALSE;
        }

        return ! preg_match('/[^0-9]/', $str);
    }

    /**
     * @param int $str
     * @return bool
     */
    public function isAllnum($str=0)
    {
        if( ! is_string($str) OR $str == '')
        {
            return FALSE;
        }

        return ! preg_match('/[^0-9a-z]/i', $str);
    }

    /**
     * @return string $pageURL
     */
    public function curPageURL() {
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    /**
     * @param string $pkkey
     * @return void
     */
    public function setPKkey($pkkey = "") {
        if($pkkey) {
            $this->__pkkey = $pkkey;
        }
    }

    /**
     * @return string
     */
    public function getPKkey() {
        return $this->__pkkey;
    }

    /**
     * @param string $table
     * @return void
     */
    public function setTablename($table = "") {
        if($table) {
            $this->__tablename = $table;
        }
    }

    /**
     * @return string
     */
    public function getTablename() {
        return $this->__tablename;
    }

    /**
     * @param int $numrows
     * @return void
     */
    public function setShowpage($numrows=0) {
        if($numrows) {
            $this->__showpage;
        }
    }

    /**
     * @return int|number
     */
    public function getShowpage() {
        return $this->__showpage;
    }

    /**
     * @param string $SQL
     * @param int $showpage
     * @return int
     */
    public function calTotalpage($SQL="", $showpage=0) {
        $p = 0;
        $tt = 0;
        $mod = 0;

        if(!$showpage) {
            $showpage = $this->__showpage;
        }

        $tt = (int)$this->M->getRecordcount($SQL);
        $p =  (int)($tt/$showpage);
        $mod = ($tt%$showpage);

        if($mod)
            $p++;

        return $p;
    }

    /**
     * @param int $page
     * @return int
     */
    public function getStartPageLimit($page = 0) {

        $limited = 0;
        $limited = $this->getShowpage();

        if($page > 0) {
            $page -= 1;
        }

        return $page*$limited;
    }

    /**
     * @param int $affectedrow
     * @return void
     */
    public function setAffectedrows($affectedrow=0) {
        if($affectedrow) {
            $this->__affectedrows = $affectedrow;
        }
    }

    /**
     * @return int
     */
    public function getAffectedrows() {
        return $this->__affectedrows;
    }

    /**
     * @param int $lastid
     * @return void
     */
    public function setLastinsertId($lastid = 0) {
        if($lastid) {
            $this->__lastidinsert = $lastid;
        }
    }

    /**
     * @return int
     */
    public function getLastinsertId() {
        return $this->__lastidinsert;
    }

    /**
     * @param bool $recordcount
     * @return bool
     */
    public function setRecordcount($recordcount=false) {
        if(!$recordcount) {
            return false;
        }
        $this->__recordcount = $recordcount;
    }


    /**
     * @param string $SQL
     * @return int|number
     */
    public function getRecordcount($SQL = "") {
        if(!$SQL)
            return $this->__recordcount;

        //$this->M->getData($SQL);
        return $this->M->getRecordcount($SQL);
    }

    /**
     * @param string $SQL
     * @param bool $debug
     * @return array|bool|null
     */
    public function getResutl($SQL="", $debug=false) {
        $rs = null;
        $rs = $this->M->getData($SQL,$debug);

        $this->setRecordcount($this->M->getRecordcount());
        return $rs;
    }

    /**
     * @param string $SQL
     * @param bool $debug
     * @return array|bool|null
     */
    public function getForJson($SQL = "", $debug=false) {
        $rs = null;
        $rs = $this->M->getForJson($SQL, $debug);

        $this->setRecordcount($this->M->getRecordcount());
        return $rs;
    }

    /**
     * @param string $SQL
     * @param bool $debug
     * @return bool|int
     */
    public function setResult($SQL = "", $debug = false) {

        $this->M->setData($SQL, $debug);

        if($debug)
            return $debug;

        $mod = "";
        $mod = substr($SQL,0,5);

        if($mod == "insert") {
            $this->setLastinsertId($this->M->getLastinsertId());
            return $this->getLastinsertId();
        }
        else {
            $this->setAffectedrows($this->M->getAffectedrows());
        }

        return $this->getAffectedrows();
    }

    /**
     * @param string $fields
     * @param int $page
     * @param int $start
     * @param int $limit
     * @return array|bool
     */
    public function selectAll($fields = "",$page = 0,$start = 0, $limit = 0) {
        $SQL = "select ";

        if($fields) {
            $SQL .= $fields;
        }
        else {
            $SQL .= "* ";
        }

        $SQL .= "from ".$this->getTablename()." ";

        if($page) {
            if(!$start) {
                $start = $this->getStartPageLimit($page);
            }

            if(!$limit) {
                $limit = $this->getShowpage();
            }

            $SQL .= "limit ".$start.",".$limit;
        }

        return $this->M->getData($SQL);
    }

    /**
     * @param string $fields
     * @param int $page
     * @param int $start
     * @param int $limit
     * @return bool|string
     */
    public function selectAllJson($fields = "",$page = 0,$start = 0, $limit = 0) {
        $SQL = "select ";
        $totals = 0;

        if($fields) {
            $SQL .= $fields;
        }
        else {
            $SQL .= "* ";
        }

        $SQL .= "from ".$this->getTablename()." ";

        $totals = $this->M->getRecordcount($SQL);

        if($page) {
            if(!$start) {
                $start = $this->getStartPageLimit($page);
            }

            if(!$limit) {
                $limit = $this->getShowpage();
            }

            $SQL .= "limit ".$start.",".$limit;
        }

        $rs = $this->M->getForJson($SQL);
        $rs['totals'] = $totals;

        return json_encode($rs);
    }

    /**
     * @param array|null $post
     * @param string $xmlfile
     * @return array
     */
    public function readVal(array $post=null, $xmlfile="") {

        $formname = $this->getTablename();

        $f = simplexml_load_file($xmlfile);
        $a = array();
        $aform = $f->table->$formname;

        foreach($aform->field as $ff) {
            $nn = $ff->noneed;
            if(!$nn) {
                $t = $ff["name"];
                $a["$t"] = $post["$t"];
            }
        }

        return $a;
    }

    /**
     * @param int $id
     * @param bool $debug
     * @return bool|int
     */
    public function _delete($id=0, $debug = false) {
        if(!$id) {
            return false;
        }

        $SQL = "delete from ".$this->getTablename()." where ".$this->getPKkey()."=".$id." limit 1";

        return $this->setResult($SQL, $debug);
    }


    public function ThaiDate2DBDate($d){
        if (!$d) return "";
        if ($d == "00-00-0000") return "";
        if ($d == "00/00/0000") return "";

        $d1=explode("-",$d);
        return (intval($d1[2])) . "-" . $d1[1] . "-" . $d1[0];

    }
}
?>