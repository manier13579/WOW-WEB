<?php
require '../config.php';

if(!empty($_POST["regData"])){
	$reg = $_POST["regData"];
  $con = DbOpen('main');
  $sql = "insert into user (user_id,username,password,email,phone,permission,join_date,last_login_date,last_login_ip) values (".
    "'".$reg['userid']."','".$reg['username']."','".$reg['password']."','".$reg['email']."','".$reg['phone']."','0',NOW(),NOW(),'".$_SERVER['REMOTE_ADDR']."')";
    
  DbSelect($con,$sql);
  DbClose($con);
  $res['code'] = 0;
}
echo json_encode($res);



?>