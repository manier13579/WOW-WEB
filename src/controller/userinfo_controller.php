<?php
require '../common/db.php';

if(!empty($_POST["regData"])){
	$reg = $_POST["regData"];
  $con = DbOpen('main');
  
  //检测用户名密码是否正确
  $sql1 = "select count(*) as count from user where user_id = '".$reg['userid']."' and password = '".$reg['password']."'";
  $result1 = DbSelect($con,$sql1);
  DbClose($con);
  if(is_string($result1)){
    $res['code'] = 2;
    $res['msg'] = $result1;
    return;
  }else{
    $row = mysqli_fetch_array($result1);
    if ($row['count'] == 0) {
      $res['code'] = 1;
      $res['msg'] = "用户名或密码不正确";
    } else {
      //返回用户数据
      $con = DbOpen('main');
      $sql2 = "select * from user where user_id = '".$reg['userid']."' and password = '".$reg['password']."'";
      $result2 = DbSelect($con,$sql2);
      $row = mysqli_fetch_array($result2);
      DbClose($con);
      if($row['permission'] == 0){
        $res['code'] = 1;
        $res['msg'] = "账号正在等待审核，请联系杨村长";
      }else{
        $res['code'] = 0;
        $access_token = getToken($reg['userid']);
        $res['msg'] = [
          'access_token'=> $access_token,
          'userid'      => $row['user_id'],
          'username'    => $row['username'],
          'permission'  => $row['permission']
        ];
      }

    }
  }

}
echo json_encode($res);


?>