<?php
require '../../vendor/autoload.php';
require '../common/db.php';
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
//返回code含义:0(成功),1(用户名或密码不正确、等待审核),2(异常)

function getToken($userid){
  $signer = new Sha256();
  $token = (new Builder())->setIssuer('bing')//设置签发人
                        ->setIssuedAt(time()) //设置生成token的时间
                        ->setExpiration(time() + (86400 * 30)) //设置过期时间
                        ->setId($userid, true) //设置id(jti claim)
                        ->sign($signer, '杨村长万岁')
                        ->getToken(); // Retrieves the generated token
  return (String)$token;
}


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