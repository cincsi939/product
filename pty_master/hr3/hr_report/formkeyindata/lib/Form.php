<?php

/**
 * RD
 *
 * Not opensource application
 *
 * @class       Form()
 * @package     Lib
 * @author      Nattapong Charoensook <nattapong@sapphire.co.th>
 * @copyright   Copyright (c) 2012-2013
 * @version     1.0
 *
 */
require_once('Sap.php');

class Form extends Sap {

    public function __construct() {
        parent::__construct();
    }

    public function getEmp($idcard=false) {
        if(!$idcard) {
            return false;
        }

        $sql = "select edu.secname, vg.* from view_general_report_lastdata as vg ";

        $sql .= "left join eduarea as edu on vg.siteid=edu.secid ";

        $sql .= "where vg.flag_assign='0' ";

        if($idcard) {
            $sql .= "and vg.CZ_ID='{$idcard}' ";
        }

        $sql .= "order by vg.siteid ASC ";

        $rs = $this->getResutl($sql);
        return $rs;
    }

    /**
     * @param string $idcard
     * @return bool|int
     */
    public function dupRecord2Temp($idcard='') {

        $sql = "insert into view_general_report_lastdata(view_general_report_lastdata.CZ_ID,
        	view_general_report_lastdata.siteid,
        	view_general_report_lastdata.pivate_key,
        	view_general_report_lastdata.public_key,
        	view_general_report_lastdata.prename_th,
        	view_general_report_lastdata.prename_id,
        	view_general_report_lastdata.name_th,
        	view_general_report_lastdata.surname_th,
        	view_general_report_lastdata.remark,
        	view_general_report_lastdata.tambonid,
        	view_general_report_lastdata.education,
        	view_general_report_lastdata.graduate_level,
        	view_general_report_lastdata.degree_level,
        	view_general_report_lastdata.radub_past_id,
        	view_general_report_lastdata.radub,
        	view_general_report_lastdata.radub_date,
        	view_general_report_lastdata.level_id,
        	view_general_report_lastdata.position_begin,
        	view_general_report_lastdata.pid_begin,
        	view_general_report_lastdata.position_now,
        	view_general_report_lastdata.pid,
        	view_general_report_lastdata.blood,
        	view_general_report_lastdata.blood_id,
        	view_general_report_lastdata.comeday,
        	view_general_report_lastdata.comeday_office,
        	view_general_report_lastdata.startdate,
        	view_general_report_lastdata.schoolid,
        	view_general_report_lastdata.view_moiareaid,
        	view_general_report_lastdata.home,
        	view_general_report_lastdata.salary,
        	view_general_report_lastdata.salary_begin,
        	view_general_report_lastdata.vitaya_type,
        	view_general_report_lastdata.vitaya,
        	view_general_report_lastdata.vitaya_id,
        	view_general_report_lastdata.vitaya_major_id,
        	view_general_report_lastdata.vitaya_major,
        	view_general_report_lastdata.vitaya_work,
        	view_general_report_lastdata.vitaya_work_type,
        	view_general_report_lastdata.vitaya_date_start,
        	view_general_report_lastdata.positiongroup,
        	view_general_report_lastdata.approve_status,
        	view_general_report_lastdata.schoolname,
        	view_general_report_lastdata.date_command,
        	view_general_report_lastdata.createtime,
        	view_general_report_lastdata.updatetime,
        	view_general_report_lastdata.update_status,
        	view_general_report_lastdata.prename_en,
        	view_general_report_lastdata.name_en,
        	view_general_report_lastdata.surname_en,
        	view_general_report_lastdata.secondname_th,
        	view_general_report_lastdata.noposition,
        	view_general_report_lastdata.date_start,
        	view_general_report_lastdata.getroyal,
        	view_general_report_lastdata.getroyal_date,
        	view_general_report_lastdata.marital_status_id,
        	view_general_report_lastdata.getroyal_id,
        	view_general_report_lastdata.work,
        	view_general_report_lastdata.subminis_now,
        	view_general_report_lastdata.subminis_now_label,
        	view_general_report_lastdata.minis_now,
        	view_general_report_lastdata.birthday,
        	view_general_report_lastdata.contract_add,
        	view_general_report_lastdata.begindate,
        	view_general_report_lastdata.grade,
        	view_general_report_lastdata.place,
        	view_general_report_lastdata.sex,
        	view_general_report_lastdata.gender_id,
        	view_general_report_lastdata.major_level,
        	view_general_report_lastdata.status_gpf,
        	view_general_report_lastdata.ustatus,
        	view_general_report_lastdata.user_approve,
        	view_general_report_lastdata.flag_assign,
        	view_general_report_lastdata.flag_kp7)
        select view_general.CZ_ID,
        	view_general.siteid,
        	view_general.pivate_key,
        	view_general.public_key,
        	view_general.prename_th,
        	view_general.prename_id,
        	view_general.name_th,
        	view_general.surname_th,
        	view_general.remark,
        	view_general.tambonid,
        	view_general.education,
        	view_general.graduate_level,
        	view_general.degree_level,
        	view_general.radub_past_id,
        	view_general.radub,
        	view_general.radub_date,
        	view_general.level_id,
        	view_general.position_begin,
        	view_general.pid_begin,
        	view_general.position_now,
        	view_general.pid,
        	view_general.blood,
        	view_general.blood_id,
        	view_general.comeday,
        	view_general.comeday_office,
        	view_general.startdate,
        	view_general.schoolid,
        	view_general.view_moiareaid,
        	view_general.home,
        	view_general.salary,
        	view_general.salary_begin,
        	view_general.vitaya_type,
        	view_general.vitaya,
        	view_general.vitaya_id,
        	view_general.vitaya_major_id,
        	view_general.vitaya_major,
        	view_general.vitaya_work,
        	view_general.vitaya_work_type,
        	view_general.vitaya_date_start,
        	view_general.positiongroup,
        	view_general.approve_status,
        	view_general.schoolname,
        	view_general.date_command,
        	view_general.createtime,
        	view_general.updatetime,
        	view_general.update_status,
        	view_general.prename_en,
        	view_general.name_en,
        	view_general.surname_en,
        	view_general.secondname_th,
        	view_general.noposition,
        	view_general.date_start,
        	view_general.getroyal,
        	view_general.getroyal_date,
        	view_general.marital_status_id,
        	view_general.getroyal_id,
        	view_general.work,
        	view_general.subminis_now,
        	view_general.subminis_now_label,
        	view_general.minis_now,
        	view_general.birthday,
        	view_general.contract_add,
        	view_general.begindate,
        	view_general.grade,
        	view_general.place,
        	view_general.sex,
        	view_general.gender_id,
        	view_general.major_level,
        	view_general.status_gpf,
        	view_general.ustatus,
        	view_general.user_approve,
        	view_general.flag_assign,
        	view_general.flag_kp7 from view_general ";

        if($idcard != '') {
            $sql .= "where CZ_ID='{$idcard}' limit 1";
        }
        else {
            return false;
        }

        return $this->setResult($sql);
    }


    public function updateDataProcess($post=false, $table_name='', $idcard='', $xsiteid='') {
        $sex_id = $post['sex_id']; //,$temp['gender_id']); // gender_id ใน view_general
        $posg_id = $post['posg_id'];//,$temp['positiongroup']); // positiongroup ใน view_general
        $pid = $post['pid'];//,$temp['pid']); // pid ใน view_general
        $position_now = $post['position_now']; // $temp['position_now'] ใน view_general
        $radub_id = $post['radub_id'];//,$temp['level_id']); // level_id ใน view_general
        $vitaya_id = $post['vitaya_id'];//,$temp['vitaya_id']); // vitaya_id ใน view_general
        $grade_id = $post['grade_id'];//,$temp['graduate_level']); // graduate_level ใน view_general
        $degree_id = $post['degree_id'];//,$temp['degree_level']); // degree_level ใน view_general
        $gmajor_id = $post['gmajor_id'];//,false); // ไม่ใช้
        $major_id = $post['major_id'];//,$temp['major_level']); // major_level ใน view_general

        $salary_begin = $post['salary_begin'];//,$temp['salary_begin']); // salary_begin ใน view_general
        $salary = $post['salary'];//,$temp['salary']); // salary ใน view_general
        $noposition = $post['noposition'];//,$temp['noposition']); // noposition ใน view_general
        $date_command = $post['date_command'];//,$temp['data_command']); // data_command ใน view_general
        $date_command = $this->ThaiDate2DBDate($date_command);


        if($sex_id == 1) {
            $sex = 'ชาย';
        }
        else {
            $sex = 'หญิง';
        }

        if($table_name == 'view_general_report_lastdata') {
            $sql = "update {$table_name} set
                {$table_name}.gender_id = '{$sex_id}',
                {$table_name}.positiongroup = '{$posg_id}',
                {$table_name}.pid = '{$pid}',
                {$table_name}.level_id = '{$radub_id}',
                {$table_name}.vitaya_id = '{$vitaya_id}',
                {$table_name}.graduate_level = '{$grade_id}',
                {$table_name}.degree_level = '{$degree_id}',
                {$table_name}.major_level = '{$major_id}',
                {$table_name}.salary_begin = '{$salary_begin}',
                {$table_name}.salary = '{$salary}',
                {$table_name}.noposition = '{$noposition}',";

            $sql .= "{$table_name}.date_command = '{$date_command}' ";

            $sql .= "where {$table_name}.CZ_ID = '{$idcard}' limit 1";

        }
        elseif($table_name == 'general') {
            $dbs = 'cmss_'.$xsiteid;
            $this->changeDB($dbs);

            $sql = "UPDATE general SET
            position_now='{$position_now}',
            pid='{$pid}',
            positiongroup='{$posg_id}',
            noposition='{$noposition}',
            level_id='{$radub_id}',
            vitaya_id='{$vitaya_id}',
            sex='{$sex}',
            gender_id='{$sex_id}',
            dateposition_now='{$date_command}',
            salary='{$salary}',
            salary_begin='{$salary_begin}' WHERE idcard='{$idcard}' ";

        }
        elseif($table_name == 'view_general') {
            $dbs = 'cmss_'.$xsiteid;
            $this->changeDB($dbs);

            $sql = "UPDATE view_general SET
            position_now='$position_now',
            pid='$pid',
            positiongroup='$posg_id',
            noposition='$noposition',
            level_id='$radub_id',
            vitaya_id='$vitaya_id',
            graduate_level='$grade_id',
            degree_level='$degree_id',
            sex='$sex',
            gender_id='$sex_id',
            dateposition_now='$date_command',
            salary='$salary',
            salary_begin='$salary_begin' WHERE CZ_ID='$idcard' ";

        }
        else {
            return false;
        }
        //echo $sql;
        return $this->setResult($sql);
        //return $sql;
    }


    public function updateLog($staff_id=false, $action='', $subject='',$add_time='') {

    }


    /**
     * @param string $el
     * @param string $var
     * @param string $type
     * @param bool $type_val
     * @param bool $filter_val
     * @param bool $first_val
     * @param bool $javascript
     * @return bool
     */
    public function genComboBoxByResult($el='', $var='', $type='method', $type_val=false, $filter_val=false, $first_val=false, $javascript=false) {

        echo "<select name='{$el}' id='{$el}' class='{validate:{required:true}}' ";

        if($javascript) {
            foreach($javascript as $j) {
                echo $j;
            }
        }

        echo " >";

        if($first_val) {
            echo "<option value=''>{$first_val}</option>";
        }

        if($type == 'method') {
            if(method_exists($this, $type_val)) {
                $rs = $this->$type_val($filter_val);

                $this->getOptionResult($var, $rs);
            }
            else {
                return false;
            }
        }
        elseif($type == 'blank') {

        }

        echo '</select>';
    }


    public function genComboBoxByResultNotValid($el='', $var='', $type='method', $type_val=false, $filter_val=false, $first_val=false, $javascript=false) {

            echo "<select name='{$el}' id='{$el}' class='' ";

            if($javascript) {
                foreach($javascript as $j) {
                    echo $j;
                }
            }

            echo " >";

            if($first_val) {
                echo "<option value=''>{$first_val}</option>";
            }

            if($type == 'method') {
                if(method_exists($this, $type_val)) {
                    $rs = $this->$type_val($filter_val);

                    $this->getOptionResult($var, $rs);
                }
                else {
                    return false;
                }
            }
            elseif($type == 'blank') {

            }

            echo '</select>';
        }

    /**
     * @param int $val
     * @param bool $rs
     * @return bool
     */
    private function getOptionResult($val=0, $rs=false) {

        $key_val = $rs['key_val'];
        $key_data = $rs['key_data'];

        if(!$rs) {
            return false;
        }

        for($i=0; $i<$rs['rows']; $i++) {
            echo "<option value='".$rs[$i][$key_val]."' ";

            if($val == $rs[$i][$key_val]) {
                echo "selected='selected'";
            }

            echo ">".$rs[$i][$key_data]."</option>";
        }
    }

    /**
     * @param int $val
     * @param string $method
     * @param bool $first_val
     * @return bool
     */
    public function getOptionResultByMethod($val=0, $method='', $first_val=false) {
        $filter_val = false;

        if(!$method) {
            return false;
        }

        if(method_exists($this, $method)) {
            $rs = $this->$method($val);
        }

        else {
            echo "Method : {$method} don't have on this object!!";
            return false;
        }

        if(!$rs) {
            return false;
        }

        $key_val = $rs['key_val'];
        $key_data = $rs['key_data'];

        if($first_val) {
            echo "<option value=''>{$first_val}</option>";
        }

        for($i=0; $i<$rs['rows']; $i++) {
            echo "<option value='".$rs[$i][$key_val]."' ";

            if($val == $rs[$i][$key_val]) {
                echo "selected='selected'";
            }

            echo ">".$rs[$i][$key_data]."</option>";
        }


        return true;
    }

    /**
     * @param bool $filter_val
     * @return array|bool|null
     */
    public function getSex($filter_val=false) {
        $sql = "select id,gender from gender ";

        if($filter_val) {
            $sql .= "where id={$filter_val}";
        }
        $rs = $this->getResutl($sql);
        $rs['key_val'] = 'id';
        $rs['key_data'] = 'gender';
        return $rs;
    }


    /**
     * @param bool $filter_val
     * @return array|bool|null
     */
    public function getPositionGroup($filter_val=false) {
        $sql = "select positiongroup, positiongroupid from hr_positiongroup ";

        if($filter_val) {
            $sql .= "where id={$filter_val}";
        }

        $rs = $this->getResutl($sql);
        $rs['key_val'] = 'positiongroupid';
        $rs['key_data'] = 'positiongroup';
        return $rs;
    }

    /**
     * @param bool $filter_val
     * @return array|bool|null
     */
    public function getPosition($filter_val=false) {
        $sql = "select pid, position from hr_addposition_now ";

        if(!$filter_val) {
            $filter_val = '-';
        }

        $sql .= "where status_active='yes' ";

        if($filter_val) {
            $sql .= "and substr(pid,1,1) = '{$filter_val}' ";
        }

        $rs = $this->getResutl($sql);
        $rs['key_val'] = 'pid';
        $rs['key_data'] = 'position';
        return $rs;
    }

    /**
     * @param bool $filter_val
     * @return array|bool|null
     */
    public function getRadub($filter_val=false) {
        $sql = "SELECT hr_addposition_now.pid,
        	position_math_radub.position_id,
        	hr_addradub.radub,
        	position_math_radub.radub_id,
        	hr_addradub.level_id
        FROM hr_addposition_now INNER JOIN position_math_radub ON hr_addposition_now.runid = position_math_radub.position_id
        	 INNER JOIN hr_addradub ON position_math_radub.radub_id = hr_addradub.runid ";

        if(!$filter_val) {
            $filter_val = '-';
        }

        if($filter_val) {
            $sql .= "WHERE hr_addposition_now.pid = '{$filter_val}' ";
        }

        $sql .= "ORDER BY hr_addradub.orderby ASC ";

        $rs = $this->getResutl($sql);
        $rs['key_val'] = 'level_id';
        $rs['key_data'] = 'radub';
        return $rs;
    }

    /**
     * @param bool $filter_val
     * @return array|bool|null
     */
    public function getVitaya($filter_val=false) {
        $sql = "SELECT hr_addradub.level_id,
        	hr_addradub.radub,
        	vitaya.runid,
        	vitaya.vitayaname
        FROM hr_addradub INNER JOIN radub_math_vitaya ON hr_addradub.level_id = radub_math_vitaya.level_id
        	 INNER JOIN vitaya ON radub_math_vitaya.vitaya_id = vitaya.runid ";

        if($filter_val) {
            $sql .= "WHERE hr_addradub.level_id = '{$filter_val}' ";
        }

        $sql .= "order by hr_addradub.level_id, vitaya.runid ASC";



        $rs = $this->getResutl($sql);
        $rs['key_val'] = 'runid';
        $rs['key_data'] = 'vitayaname';
        return $rs;
    }

    /**
     * @param bool $filter_val
     * @return array|bool|null
     */
    public function getHighGrade($filter_val=false) {
        $sql = "select * from hr_addhighgrade where hr_addhighgrade.active_status=1 ";

        if($filter_val) {
            $sql .= "and hr_addhighgrade.runid='{$filter_val}' ";
        }

        $sql .= "order by hr_addhighgrade.runid ";

        $rs = $this->getResutl($sql);
        $rs['key_val'] = 'runid';
        $rs['key_data'] = 'highgrade';
        return $rs;
    }

    /**
     * @param bool $filter_val
     * @return array|bool|null
     */
    public function getDegree($filter_val=false) {
        $sql = "select * from hr_adddegree ";

        if(!$filter_val) {
            $filter_val = '-';
        }

        if($filter_val) {
            $sql .= "WHERE substr(hr_adddegree.degree_id,1,2) = '{$filter_val}' ";
        }

        $rs = $this->getResutl($sql);
        $rs['key_val'] = 'degree_id';
        $rs['key_data'] = 'degree_fullname';
        return $rs;
    }

    /**
     * @param bool $filter_val
     * @return array|bool|null
     */
    public function getMajorGroup($filter_val=false) {
        $sql = "SELECT left(t1.major_id,1) as id, t1.major_id, t1.major FROM hr_addmajor AS t1 ";
        $sql .= "WHERE t1.major_id LIKE  '%0000%00' ORDER BY t1.major ASC ";

        if($filter_val) {
            $sql .= " ";
        }

        $rs = $this->getResutl($sql);
        $rs['key_val'] = 'id';
        $rs['key_data'] = 'major';
        return $rs;
    }


    public function getMajor($filter_val=false) {
        $sql = "select  t1.major_id, t1.major from hr_addmajor as t1  ";

        if(!$filter_val) {
            $filter_val = '-';
        }

        if($filter_val) {
            $sql .= "where t1.major_id LIKE '{$filter_val}%' AND major_id NOT LIKE '{$filter_val}%00' order by
            t1.runid";
        }

        $rs = $this->getResutl($sql);
        $rs['key_val'] = 'major_id';
        $rs['key_data'] = 'major';
        return $rs;
    }

    public function setStatus($idcard=false) {
        $this->changeDB('pty_master');
        $sql = "update view_general_report_lastdata set status_key='1' where CZ_ID='{$idcard}' limit 1";

        return $this->setResult($sql);
    }

    public function setStaffID($idcard=false, $staff_id=false) {
        $sql = "update view_general_report_lastdata set key_by_userid='{$staff_id}' where CZ_ID='{$idcard}' limit 1";
        return $this->setResult($sql);
    }

}
?>