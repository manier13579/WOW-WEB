<?php

$filename = "王家场世界登录器.bat";  
$encoded_filename = urlencode($filename);  
$encoded_filename = str_replace("+", "%20", $encoded_filename);  
header("Content-Type: application/octet-stream");  
if (preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT']) ) {  
    header('Content-Disposition:  attachment; filename="' . $encoded_filename . '"');  
} elseif (preg_match("/Firefox/", $_SERVER['HTTP_USER_AGENT'])) {  
    header('Content-Disposition: attachment; filename*="' .  $filename . '"');  
} else {  
    header('Content-Disposition: attachment; filename="' .  $filename . '"');  
}  
echo "echo set realmlist \"wjcxxzx.cn:3724\">Data\\zhCN\\realmlist.wtf\n";
echo "echo set realmlist \"wjcxxzx.cn:3724\">Data\\zhTW\\realmlist.wtf\n";
echo "start wow.exe\n";
echo "goto end";
?>

