<?php
require 'validate_controller.php';
if(!validateToken(getallheaders()['Authorization'])){echo "sessionError";exit;}

require '../common/db.php';
$action = $_POST['action'];

switch ($action) {
//注册审核
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

//注册审核事件
case 'upgrade':
  $userid = $_POST['userid'];
  $password = $_POST['password'];
  //更新主数据库
  $sql1 = "update user set permission = '1' where user_id = '".$userid."'";
  $con = DbOpen('main');
  DbSelect($con, $sql1);
  DbClose($con);
  
  //注册魔兽世界账号
  $sql2 = "INSERT INTO account (username,sha_pass_hash,expansion,last_login) VALUES ('$userid',SHA1(CONCAT(UPPER('$userid'),':',UPPER('$password'))),'1',now())";
  $con = DbOpen('auth');
  DbSelect($con, $sql2);
  DbClose($con);

  echo 'ok';
break;

//注册除权事件
case 'del':
  $userid = $_POST['userid'];  //获取userid
  
  $sql = "update user set permission = '0' where user_id = '".$userid."'";
  $con = DbOpen('main');
  DbSelect($con, $sql);
  DbClose($con);

  
  echo 'ok';

break;


//充值审核
case 'buy':

  //连接数据库
  $responce = new stdClass();
  $responce->code = 0;

  $con = DbOpen('main');
  $sql = 'SELECT a.*,b.username from buy a 
    LEFT JOIN user b on a.user_id = b.user_id
    where a.audit = 0
    order by a.audit,a.order_date asc';
  $result = DbSelect($con, $sql);

  $i = 0;
  $res = [];
  while ($row = mysqli_fetch_array($result)) {
      $res[$i] = [
      'id'       => $row['id'],
      'userid'     => $row['user_id'],
      'username'     => $row['username'],
      'good_type'       => $row['good_type'],
      'good_id'     => $row['good_id'],
      'good_name' => $row['name'],
      'pay'     => $row['pay'],
      'character'    => $row['character1'],
      'order_date'         => $row['order_date'],
      'status'         => $row['status'],
      'audit'         => $row['audit'],
    ];
      $i++;
  }

  $responce->data = $res;
  echo json_encode($responce);
  DbClose($con);
break;


//充值审核事件
case 'buyAudit':
  $orderid = $_POST['orderid'];
  //更新主数据库
  $sql1 = "update buy set audit = '1' where id = '".$orderid."'";
  $con = DbOpen('main');
  DbSelect($con, $sql1);
  DbClose($con);

  echo 'ok';
break;


}
