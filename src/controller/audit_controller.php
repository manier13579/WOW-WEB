<?php
require 'validate_controller.php';
if(!validateToken(getallheaders()['Authorization'])){echo "sessionError";exit;}

require '../common/db.php';
$action = $_POST['action'];

switch ($action) {
//初始化查询列表
case 'init':

  //连接数据库
  $responce = new stdClass();
  $responce->code = 0;

  $con = DbOpen('main');
  $sql = 'SELECT * from user order by permission,join_date asc';
  $result = DbSelect($con, $sql);

  $i = 0;
  $res = [];
  while ($row = mysqli_fetch_array($result)) {
      $res[$i] = [
      'userid'       => $row['user_id'],
      'username'     => $row['username'],
      'permission'       => $row['permission'],
      'password'     => $row['password'],
      'email' => $row['email'],
      'phone'     => $row['phone'],
      'join_date'    => $row['join_date'],
      'last_login'         => $row['last_login_date'],
      'last_ip'         => $row['last_login_ip'],
    ];
      $i++;
  }

  $responce->data = $res;
  echo json_encode($responce);
  DbClose($con);
break;

//审核事件
case 'upgrade':
  $userid = $_POST['userid'];
  $password = $_POST['password'];
  //更新主数据库
  $sql1 = "update user set permission = '1' where user_id = '".$userid."'";
  $con = DbOpen('main');
  DbSelect($con, $sql1);
  DbClose($con);
  
  //注册魔兽世界账号
  $sql2 = "INSERT INTO account (username,sha_pass_hash, gmlevel,expansion,last_login) VALUES ('$userid',SHA1(CONCAT(UPPER('$userid'),':',UPPER('$password'))),'1','1',now())";
  $con = DbOpen('realmd');
  DbSelect($con, $sql2);
  DbClose($con);

  echo 'ok';
break;

//除权事件
case 'del':
  $userid = $_POST['userid'];  //获取userid
  
  $sql = "update user set permission = '0' where user_id = '".$userid."'";
  $con = DbOpen('main');
  DbSelect($con, $sql);
  DbClose($con);

  
  echo 'ok';

break;


}
