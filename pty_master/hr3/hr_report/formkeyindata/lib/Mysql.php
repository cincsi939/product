<?php

/**
 * RD
 *
 * Not opensource application
 *
 * @class       Mysql()
 * @package     Lib
 * @author      Nattapong Charoensook <nattapong@sapphire.co.th>
 * @copyright   Copyright (c) 2012-2013
 * @version     1.0
 *
 */
class Mysql {

    protected $_host;
    protected $_user;
    protected $_password;
    protected $_dbs;
    protected $_char_set;
    protected $_connection;

    protected $_msg;
    protected $_sql;
    protected $_recordcount;
    protected $_lastinsertid;
    protected $_affectedrows;
    protected $_colordebug;
    protected $_errmsg;


    public function __construct() {
        $this->_recordcount = 0;
        $this->_lastinsertid = 0;
        $this->_affectedrows = 0;
        $this->_showpage = 20;

        $this->_errmsg = '';
        $this->_colordebug = '#ff0000';
    }

    /**
     * void setHostName(string)
     * @param string $hostname Name of database hostname
     *
     */
    public function setHostName($hostname) {
        $this->_host = $hostname;
    }

    /**
     * string getHostName(void)
     * @return string $hostname
     */
    private function getHostName() {
        return $this->_host;
    }

    /**
     * setDbUser(string)
     * @param string $dbuser
     *
     */
    public function setDbUser($dbuser="") {
        if($dbuser) {
            $this->_user = $dbuser;
        }
    }

    /**
     * string getDbUser(void)
     * @return string $dbuser
     */
    private function getDbUser() {
        return $this->_user;
    }

    /**
     * void setDbPass(string)
     * @param string $dbpass
     *
     */
    public function setDbPass($dbpass="") {
        if($dbpass) {
            $this->_password = $dbpass;
        }
    }

    /**
     * string getDbPass(void)
     * @return string $dbpass
     */
    private function getDbPass() {
        return $this->_password;
    }

    /**
     * void setDbs(string)
     * @param string $dbname
     *
     */
    public function setDbs($dbname="")
    {
        if($dbname) {
            $this->_dbs = $dbname;
        }
    }


    /**
     * string getDbs(void)
     * @return string $dbname
     */
    public function getDbs() {
        return $this->_dbs;
    }

    /**
     * void setCharset(string)
     * @param string $charset
     *
     */
    public function setCharset($charset="")
    {
        if($charset) {
            $this->_char_set = $charset;
        }
    }

    /**
     * string getCharset(void)
     * @return string $charset
     */
    public function getCharset()
    {
        return $this->_char_set;
    }

    /**
     * void setErrMsg(string)
     * @param string $errmsg
     *
     */
    public function setErrMsg($errmsg="") {
        $this->_errmsg = $errmsg;
    }

    /**
     * @param string $errmsg
     * @return void
     */
    public function setErrMsgs($errmsg="") {
        $this->_errmsg .= $errmsg;
    }

    /**
     * string getErrMsg(void)
     * @return string $errmsg
     */
    public function getErrMsg() {
        return $this->_errmsg;
    }

    /**
     * @param bool $debug
     * @return bool|resource
     */
    protected function connect($debug=false) {
        $con = @mysql_connect($this->getHostName(),$this->getDbUser(),$this->getDbPass());
        $this->_connection = $con;

        if($con) {
            $_SESSION["_mysql_host"] = $this->getHostName();
        }
        else
        {
            $this->setErrMsg(@mysql_error());
            $debug = true;
        }


        if($debug)
        {
            echo $this->getErrMsg();
            return false;
        }

        return $con;
    }

    /**
     * @param $con
     *
     * @internal param \con $Connection
     * @return bool disconnect the connection
     */
    protected function disconnect($con) {
        mysql_close($con);
        return true;
    }


    public function getData($SQL, $debug=false) {

        $rs = false;
        $this->_recordcount = 0;

        $con = $this->connect($debug); // connect to database and set $_connection on this connection

        mysql_select_db($this->_dbs, $con);
        $this->setErrMsg(mysql_error());

        if($debug) {
            $this->setErrMsg("<pre>".$SQL."</pre><pre>".$this->getErrMsg()."</pre>");
            echo $this->getErrMsg();
            return $debug;
        }


        //mysql_query("set names tis620".$this->_char_set); // set every text to UTF8 support all language
        mysql_query('set names tis620');
        $rs = mysql_query($SQL, $con);

        if($rs) {
            $this->setRecordcount(mysql_num_rows($rs));
            if($this->getRecordcount() <= 0) {
                $this->setErrMsg("Data Is Empty..");
                return false;
            }

            for($i=0; $i<$this->_recordcount; $i++) {
                $rows[$i] = mysql_fetch_assoc($rs);
            }
            $rows["rows"] = $i;
        }
        else {
            $this->setErrMsgs(@mysql_error($con));
            $this->disconnect($con);
            return false;
        }


        $this->disconnect($con);
        return $rows;
    }

    /**
     * @param bool $SQL
     * @param bool $debug
     * @return array|bool
     */
    public function getForJson($SQL=false, $debug = false) {
        $rs = array('data'=>'', 'success'=> '');
        $con = $this->connect();
        $this->setRecordcount(0);

        if($debug) {
            $this->setErrMsg("<pre>".$SQL."</pre>");
            echo $this->getErrMsg();
            return $debug;
        }

        mysql_select_db($this->getDbs(), $con);
        $this->setErrMsg(mysql_error());
        mysql_query("set names ".$this->getCharset()); // set every text to UTF8 support all language
        $rows = mysql_query($SQL, $con);

        if($rows) {
            $this->setRecordcount(mysql_num_rows($rows));
        }

        if(!$rows) {
            $this->setErrMsg('Could not get result form this statment!');
            return false;
        }

        while($row = mysql_fetch_assoc($rows)) {
            $rs['data'][] = $row;

        }
        $rs['success'] = true;

        $this->disconnect($con);
        return $rs;
    }

    /*
          * @param String SQL statement
          * @param bool debug status
          * @return Resultset
          */
    public function setData($SQL , $debug=false) {
        $this->__error = false;
        $con = $this->connect($debug);

        $this->_connection = $con;

        mysql_select_db($this->_dbs, $con);
        mysql_query("set names ".$this->_char_set); // set every text to UTF8 support all language
        $rs = mysql_query($SQL,$con);

        if($debug) {
            $this->setErrMsg("<pre>".$SQL."</pre><pre>".$this->getErrMsg()."</pre>");
            echo $this->getErrMsg();
            return $debug;
        }


        $mod = strtolower(substr($SQL,0,6));

        if(($mod == 'delete') || ($mod == 'update')) {


            $this->setAffectedrows(mysql_affected_rows($con));

            if($this->getAffectedrows() < 0)
                return false;
            else if($this->getAffectedrows() == 0)
                return 1;
            else
                return $this->getAffectedrows();
        }

        if($mod == 'insert') {

            $this->setLastinsertId(mysql_insert_id($con));
            return $this->getLastinsertId();
        }

        if(!$rs) {
            $this->setErrMsg(mysql_errno($con));
            $debug = true;
        }

        $this->disconnect($con);
        return $rs;
    }

    /*
    * setRecordcount()
    * @access public
    * @param int $recordcount
    * @return bool true
    */
    public function setRecordcount($recordcount=false) {
        if(!$recordcount) {
            return false;
        }
        $this->_recordcount = $recordcount;
        return true;
    }

    /**
     * @param string $SQL
     * @return int
     */
    public function getRecordcount($SQL = "") {
        if(!$SQL)
            return $this->_recordcount;

        $this->getData($SQL);
        return $this->_recordcount;
    }

    /**
     * @param int $affected
     * @return void
     */
    public function setAffectedrows($affected=0) {
        if($affected) {
            $this->_affectedrows = $affected;
        }
    }

    /*
          * getAffected()
          * @access public
          * @param void do not input
          * @return int affected rows of insert, update or delete
          */
    public function getAffectedrows() {
        return $this->_affectedrows;
    }

    /**
     * @param int $lastid
     * @return void
     */
    public function setLastinsertId($lastid = 0) {
        if($lastid) {
            $this->_lastinsertid = $lastid;
        }
    }

    /*
    * getLastinsertId()
    * @access public
    * @param void
    * @return int $_lastinsertid
    */
    public function getLastinsertId() {
        return $this->_lastinsertid;
    }
}
?>