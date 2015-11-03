<?php
class bar_menu{

	public function Navigation(){
		echo '<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">SERVER DATABASE</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                
                <!-- /.dropdown -->
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
		';
	}	 
	public function menulist(){
		echo '<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
						<li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Main</a>
                        </li>
                        
                        <li>
                            <a href="index.php"><i class="fa fa-upload fa-fw"></i> Select Database</a>
							
                        </li>
                        
                        <li>
                            <a href="Manager.php"><i class="fa fa-wrench fa-fw"></i> Table Database</a>
                           
                            <!-- /.nav-second-level -->
                        </li>
                       
                        <li>
                            <a href="login.php"><i class="fa fa-files-o fa-fw"></i> Log out</a>
                           
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>';
		 
	}
}
$objclass_bar_menu = new bar_menu;

function showtable($dbt,$conn){
	mysql_select_db($dbt,$conn) or die(mysql_error());
$dbz = mysql_query("SHOW TABLES");
$i=1;
$name_table = 'Tables_in_'.$dbt;
echo '<table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Table</th>
          <th>Primary Key</th>
		  <th align="center">Action</th>
        </tr>
      </thead>
      <tbody>';  
    $i;    
while($lis = mysql_fetch_array($dbz)){
echo '<tr>
          <th scope="row">'.$i.'</th>
          <td>'.$lis[$name_table].'</td>
          <td>';
		  echo check_PK($lis[$name_table]);
		  echo'</td>
		  <td><button type="button" class="btn btn-primary" title="ปรับให้เป็น InnoDB">InnoDB</button>&nbsp;<button type="button" class="btn btn-info" title="ปรับ Database ให้เป็น UTF-8">UTF-8</button></td>
        </tr>';
				$i++;
				
}
echo '</tbody>
    </table>';
}

function check_PK($table){

$pri_name = mysql_query("SHOW KEYS FROM $table where Key_name = 'PRIMARY'");
$num=1;
$a='0';
while($pk_key=mysql_fetch_assoc($pri_name)){
	if($num!=1){
		echo ',';
	}
if($pk_key['Key_name']=='PRIMARY'){
echo $pk_key['Column_name'];
$a='1';
}
$num++;
}
if($a!='1'){
echo '<span style="color:red;">ตารางนี้ไม่มี Primary Key</span>';
}
}
?>