<?php

$site = array(
	//登陆器设置
	"realmlist" => "set realmlist \"wjcxxzx.cn:3724\"",
 	"expansion"=>"1", //资料片等级
	"gmlevel"=>"0" //注册账号等级
);

function DbOpen($db_name){
	$host = "127.0.0.1";
	$db_user = "root";
	$db_pass = "root";
	$timezone = "Asia/Beijing";
	$setutf8 = "SET NAMES utf8";
  
	$con = mysqli_connect($host, $db_user, $db_pass,$db_name);
	//错误处理
	if (!$con)
	  {
	  	die('Could not connect:'.mysqli_error());
	  }
	mysqli_query($con,$setutf8);
	//防止中间路径转换为乱码：client→connection→server
	//http://blog.csdn.net/wzwsj1986/article/details/1723658
	
	//如果连接数据库是使用如下语句：
	//$con = mysqli_connect($host, $db_user, $db_pass);
	//还需要使用下面语句选择数据库
	//mysqli_select_db($con,$db_name);
	
	return $con;
}

function DbSelect($con,$query)
{
	$sql=mysqli_query($con,$query);
	//错误处理
	if (!$sql) {
		printf("Error: %s\n", mysqli_error($con));
		exit();
	}
	return $sql;
}

function DbClose($con)
{
	mysqli_close($con);
}
?>