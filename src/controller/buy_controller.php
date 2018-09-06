<?php
require 'validate_controller.php';
if(!validateToken(getallheaders()['Authorization'])){echo "sessionError";exit;}

require '../common/db.php';
$action = $_POST['action'];

switch ($action) {
//查询订单
case 'order':
  $userid = $_POST["userid"];
  //连接数据库
  $responce = new stdClass();
  $responce->code = 0;

  $con = DbOpen('main');
  $sql = "SELECT * from buy where user_id = '".$userid."' order by order_date asc";
  $result = DbSelect($con, $sql);

  $i = 0;
  $res = [];
  while ($row = mysqli_fetch_array($result)) {
      $res[$i] = [
      'orderid'  => $row['id'],
      'type'     => $row['good_type'],
      'name'     => $row['name'],
      'character'=> $row['character1'],
      'pay'      => $row['pay'],
      'date'     => $row['order_date'],
      'status'   => $row['status'],
      'audit'    => $row['audit']
    ];
      $i++;
  }

  $responce->data = $res;
  echo json_encode($responce);
  DbClose($con);
break;

//购买商品
case 'buy':
  $goodinfo = $_POST["goodinfo"];
  //插入订单表
  $sql1 = "insert into buy (user_id,good_type,good_id,name,pay,character1,order_date,status,audit) values ('".$goodinfo['userid']."','".$goodinfo['good']."','".$goodinfo['id']."','".$goodinfo['name']."','".$goodinfo['pay']."','".$goodinfo['character']."',now(),1,0)";
  $con = DbOpen('main');
  DbSelect($con, $sql1);
  DbClose($con);
  
  //注册魔兽世界账号
  $sql2 = "";
  switch ($goodinfo['id']) {
    case '0': 
      $sql2 = "";
      $con = DbOpen('realmd');
      //DbSelect($con, $sql2);
      DbClose($con);
    break;
    
    
  }


  echo 'ok';
break;


}
