<?php
require '../common/db.php';

$name = $_POST['name'];
$con = DbOpen('auth');
$sql = "select flag from realmlist where name='".$name."'";
$result = DbSelect($con,$sql) or die("查询失败." . mysqli_error());
$responce = '';
$i = 0;
$row = mysqli_fetch_array($result);
$responce = $row['flag'];

echo $responce;
DbClose($con);
    
?>