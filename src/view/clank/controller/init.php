<?php
require 'db.php';
$db = DbOpen();
$action = $_POST['action'];

switch ($action){
	case 'getCard' : //读取卡牌信息
    $sql = "select * from card";
		$result = DbSelect($db,$sql);
    $responce = '';
		$i = 0;
		while ($row = $result->fetchArray()) {
			$responce[$row['id']] = array (
        'name' => $row['name'],
        'type' => $row['type'],
        'detail' => $row['detail'],
        'remark' => $row['remark'],
        'trigger' => $row['trigger'],
        'condition' => $row['condition'],
        'event' => $row['event'],
        'acquire' => $row['acquire'],
        'arrive' => $row['arrive'],
        'special' => $row['special'],
        'cost' => $row['cost'],
        'reward_type1' => $row['reward_type1'],
        'reward_value1' => $row['reward_value1'],
        'reward_type2' => $row['reward_type2'],
        'reward_value2' => $row['reward_value2'],
        'reward_type3' => $row['reward_type3'],
        'reward_value3' => $row['reward_value3'],
        'value' => $row['value'],
        'expansion' => $row['expansion']
			);
			$i++;
		}
		echo json_encode($responce);
    
	break;

  case 'roomstat' : //读取房间信息
    $sql = "select * from room";
		$result = DbSelect($db,$sql);
    $responce = '';
		$i = 0;
		while ($row = $result->fetchArray()) {
			$responce[$row['seatid']] = array (
        'userid' => $row['userid'],
        'username' => $row['username'],
        'joindate' => $row['joindate']
			);
			$i++;
		}
		echo json_encode($responce);
    
	break;
  
  case 'seatin' : //进入座位
    $seatid = $_POST['seatid'];
    $userid = $_POST['userid'];
    $username = $_POST['username'];
    $sql1 = "update room set userid='',username='',joindate='' where userid='".$userid."'";
    $sql2 = "update room set userid = '".$userid."',username = '".$username."',joindate = '".time()."' where seatid = ".$seatid."";
    DbSelect($db,$sql1);
    DbSelect($db,$sql2);
		echo 'ok';
    
	break;
  
  case 'gamestat' : //读取游戏状态
    $sql = "select run from game_info";
		$result = DbSelect($db,$sql);
    $row = $result->fetchArray();

		echo $row['run'];
    
	break;
}
?>