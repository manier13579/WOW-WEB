<?php
require 'validate_controller.php';
if(!validateToken(getallheaders()['Authorization'])){echo "sessionError";exit;}

require '../common/db.php';
//连接数据库 
$con = DbOpen('characters');
$action = $_POST['action'];


switch ($action){
	case 'show1' : //读取等级排行
    
    $sql = "select name,level,class,race from characters ORDER BY level desc limit 0,10";
		$result = DbSelect($con,$sql) or die("查询失败." . mysqli_error());
    $responce = '';
		$i = 0;
		while ($row = mysqli_fetch_array($result)) {
			$responce[$i] = array (
        'name' => $row['name'],
        'level' => $row['level'],
        'class1' => $row['class'],
        'race' => $row['race']
			);
			$i++;
		}
		echo json_encode($responce);
    DbClose($con);
    
	break;
  
	case 'show2' : //读取在线角色
    
    $sql = "select name,level,class,race from characters where online = '1' ORDER BY level desc limit 0,10";
		$result = DbSelect($con,$sql) or die("查询失败." . mysqli_error());
    $responce = '';
		$i = 0;
		while ($row = mysqli_fetch_array($result)) {
			$responce[$i] = array (
        'name' => $row['name'],
        'level' => $row['level'],
        'class1' => $row['class'],
        'race' => $row['race']
			);
			$i++;
		}
		echo json_encode($responce);
    DbClose($con);
    
	break;
  
	case 'show3' : //读取公会
    
    $sql = "select a.name as name,(select count(*) from guild_member where guildid = a.guildid) as member,c.name as owner from guild a 
            LEFT JOIN characters c on a.leaderguid = c.guid limit 0,10";
		$result = DbSelect($con,$sql) or die("查询失败." . mysqli_error());
    $responce = '';
		$i = 0;
		while ($row = mysqli_fetch_array($result)) {
			$responce[$i] = array (
        'name' => $row['name'],
        'member' => $row['member'],
        'owner' => $row['owner']
			);
			$i++;
		}
		echo json_encode($responce);
    DbClose($con);
    
	break;
  
	case 'show4' : //读取装备等级排行
    DbClose($con);
    $con = DbOpen('main');
    $sql = "select * from wow_itemlevel order by itemlevel desc limit 0,10";
		$result = DbSelect($con,$sql) or die("查询失败." . mysqli_error());
    $responce = '';
		$i = 0;
		while ($row = mysqli_fetch_array($result)) {
			$responce[$i] = array (
        'name' => $row['name'],
        'itemlevel' => $row['itemlevel'],
        'zhongZu' => $row['zhongZu'],
        'zhiYe' => $row['zhiYe'],
        'guild' => $row['guild']
			);
			$i++;
		}
		echo json_encode($responce);
    DbClose($con);
    
	break;
  
	case 'showstat' : //读取服务器状态
    DbClose($con);
    $con = DbOpen('auth');
    $sql = "select name,flag from realmlist order by id asc";
		$result = DbSelect($con,$sql) or die("查询失败." . mysqli_error());
    $responce = '';
		$i = 0;
		while ($row = mysqli_fetch_array($result)) {
			$responce[$i] = array (
        'name' => $row['name'],
        'flag' => $row['flag'],
			);
			$i++;
		}
		echo json_encode($responce);
    DbClose($con);
    
	break;
}
?>