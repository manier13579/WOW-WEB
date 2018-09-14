<?php
require '../common/db.php';
$action = $_POST['action'];
switch ($action) {
//版本信息
case 'version':
  $con = DbOpen('main');
  $sql = "select text from notice where name ='clientVersion'";
  $result = DbSelect($con,$sql) or die("查询失败." . mysqli_error());
  $row = mysqli_fetch_array($result);
  $responce = $row['text'];

  echo $responce;
  DbClose($con);
  
break;
    
case 'notice':
  
  
break;

}
?>