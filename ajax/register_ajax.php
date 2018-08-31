<?php
require '../config.php';
session_start();
$errors = ''; 


if(!empty($_POST["accountname"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && !empty($_POST["email"]) && !empty($_POST["security"])){

	$post_accountname = addslashes(trim($_POST["accountname"]));
	$post_password = addslashes($_POST["password"]);
	$post_password2 = addslashes($_POST["password2"]);
	$post_email = addslashes($_POST["email"]);
	$ip=$_SERVER['REMOTE_ADDR'];
	$expansion=$site["expansion"];
	$gmlevel=$site["gmlevel"];

    if(strlen($post_accountname) < 3) { $errors[] = "账户名称不能少于3个字符，请重新输入。"; }
    if(strlen($post_accountname) > 32) { $errors[] = "账户名称不能多于32个字符，请重新输入。"; }
    if(strlen($post_password) < 6) { $errors[] = "账户密码不能少于6个字符，请重新输入。"; }
    if(strlen($post_password) > 32) { $errors[] = "账户密码不能多于32个字符，请重新输入。"; }
    if(strlen($post_email) < 8) { $errors[] = "电子邮件不能少于8个字符，请重新输入。"; }
    if(strlen($post_email) > 64) { $errors[] = "电子邮件不能多于64个字符，请重新输入。"; }
    if(!preg_match("/^[0-9a-zA-Z%]+$/", $post_accountname)) { $errors[] = "账户名称只能用字母或者数字，请重新输入。"; }
    if(!preg_match("/^[0-9a-zA-Z%]+$/", $post_password)) { $errors[] = "账户密码只能用字母或者数字，请重新输入。"; }
    if($post_accountname == $post_password) { $errors[] = "账户密码不能与账户名称相同，请重新输入。"; }
    if($post_password != $post_password2) { $errors[] = "账户密码两次输入不同，请重新输入。"; }

    $con = DbOpen('realmd80');
    
    $check_account_query = DbSelect($con,"SELECT COUNT(*) FROM account WHERE username = '$post_accountname'");
    $check_account_results = mysqli_fetch_array($check_account_query);
    if($check_account_results[0]!=0){ $errors[] = "账户名称已被使用，请重新输入。"; }
    
    if(!is_array($errors)){
        if(DbSelect($con,"INSERT INTO account (username,realpass,sha_pass_hash, gmlevel, email,last_ip,expansion) VALUES ('$post_accountname','$post_password',SHA1(CONCAT(UPPER('$post_accountname'),':',UPPER('$post_password'))),'$gmlevel','$post_email','$ip','$expansion')")){
            $errors[] = 'ok';
        }
        else{
            $errors[] = "<font color='red'>卧槽,数据库连接失败,请联系杨村长和王村长注册！</font>";
        }
    }
    DbClose($con);

}

function error_msg(){

    global $errors;
    
    if(is_array($errors)){
    
        foreach($errors as $msg){
        
            echo $msg;
        
        }
    
    }else{
      echo '卧槽，这个报错本不应该出现...';
    }

}
error_msg();


?>