<?php
/**
 * Title:
 * Author: Peerasak Sane(ZenTBelL)
 * Date: 6/10/2558
 * Time: 11:32
 */
include('config_host.php');
$host = HOST_DEFAULT;
$username = USER;
$password = PWD;
$DBUSERMANAGER = DB_USERMANAGER;
$DBMASTER = DB_MASTER;
$DBDATA = DB_DATA;
try{
    $dbData = new PDO("mysql:host=$host; dbname=$DBDATA;", $username, $password);
    $dbData->exec("SET CHARACTER SET tis620");
    if($_GET['debug'] == 'on'){
        if($dbData){
            echo "Connected to database ".$DBDATA;

        }else{
            echo "Not onnected to database ".$DBDATA;

        }
        echo '<br>';
    }
}catch (PDOException $e) {
    echo $e->getMessage();
}
try{
    $dbMaster = new PDO("mysql:host=$host; dbname=$DBMASTER;", $username, $password);
    $dbMaster->exec("SET CHARACTER SET tis620");
    if($_GET['debug'] == 'on'){
        if($dbMaster){
            echo "Connected to database ".$DBMASTER;
        }else{
            echo "Not connected to database ".$DBMASTER;
        }
        echo '<br>';
    }
}catch (PDOException $e) {
    echo $e->getMessage();
}
try{
    $dbUser = new PDO("mysql:host=$host; dbname=$DBUSERMANAGER;", $username, $password);
    $dbUser->exec("SET CHARACTER SET tis620");
    if($_GET['debug'] == 'on'){
        if($dbUser){
            echo "Connected to database ".$DBUSERMANAGER;
        }else{
            echo "Not connected to database ".$DBUSERMANAGER;
        }
        echo '<br>';
    }
}catch (PDOException $e) {
    echo $e->getMessage();
}