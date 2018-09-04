<?php
require '../common/db.php';
//返回code含义:0(成功),1(重复),2(异常)

if(!empty($_POST["regData"])){
	$reg = $_POST["regData"];
  $con = DbOpen('main');
  
  //检测用户是否已存在
  $sql1 = "select count(*) as count from user where user_id = '".$reg['userid']."'";
  $result1 = DbSelect($con,$sql1);
  DbClose($con);
  if(is_string($result1)){
    $res['code'] = 2;
    $res['msg'] = $result1;
    return;
  }else{
    $row = mysqli_fetch_array($result1);
    if ($row['count'] != 0) {
      $res['code'] = 1;
    } else {
      //添加用户
      $con = DbOpen('main');
      $sql2 = "insert into user (user_id,username,password,email,phone,permission,join_date,last_login_date,last_login_ip) values (".
        "'".$reg['userid']."','".$reg['username']."','".$reg['password']."','".$reg['email']."','".$reg['phone']."','0',NOW(),NOW(),'".$_SERVER['REMOTE_ADDR']."')";
        
      $result2 = DbSelect($con,$sql2);
      DbClose($con);
      if(is_string($result2)){
        $res['code'] = 2;
        $res['msg'] = $result2;
        return;
      }else{
        $res['code'] = 0;
      }

    }
  }

}
echo json_encode($res);


?>