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
    $db->close();
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
    $db->close();
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
    
    $db->close();
		echo 'ok';
	break;
  
  case 'gamestat' : //读取游戏状态
    $sql = "select run from game_info";
		$result = DbSelect($db,$sql);
    $row = $result->fetchArray();

    $db->close();
		echo $row['run'];
    
	break;
  
  case 'begin' : //开始游戏
    //查询所有不含巨龙攻击且不是常驻的卡牌
    $sql1 = "
      select id from card where 
      type <> 1 and 
      type <> 7 and
      id <> 19 and
      id <> 20 and
      id <> 74 and
      (special <> 1 or special <> 3) ";
    $result = DbSelect($db,$sql1);
    $syscard = [];
		while ($row = $result->fetchArray()) {
      array_push($syscard,$row['id']);
		}
    shuffle($syscard);   //洗牌
    //起始地城卡牌的6张牌
    $syscardcurStr = json_encode(array_slice($syscard,0,6));
    $syscard = array_slice($syscard,6);  //地城卡牌除了巨龙攻击和起始卡牌
    
    $sql2 = "select id from card where (special = 1 or special = 3) ";  //查询含巨龙攻击的卡牌
    $result = DbSelect($db,$sql2);
		while ($row = $result->fetchArray()) {
      array_push($syscard,$row['id']);    //将巨龙攻击牌加入到地城卡牌
		}
    shuffle($syscard);  //洗牌
    //地城卡牌
    $syscardStr = json_encode($syscard);
    //地城卡牌剩余数量
    $syscardcount = count($syscard);
    //巨龙袋子
    $clankStr = json_encode([0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]);
    
    $handcard = [1,1,21,38,57,57,57,57,57,57];    //玩家起始手牌列表
    $sql3 = "select * from room where userid <> ''";
    $result = DbSelect($db,$sql3);
    $seatcount = 0;   //玩家数量
		while ($row = $result->fetchArray()) {
      $seatcount += 1;
      shuffle($handcard);  //洗牌
      $handcardcur = json_encode(array_slice($handcard,0,5));  //当前手牌
      $sql4 = "insert into game_player values(
        '".$row['userid']."',
        ".$row['seatid'].",
        10,
        0,
        0,
        0,
        '',
        0,
        0,
        '".json_encode($handcard)."',
        '".$handcardcur."',
        10,
        5
      )";
      DbSelect($db,$sql4);
		}
    //巨龙攻击等级
    $level = 1;
    if($seatcount==2){
      $level = 3;
    }else if($seatcount==3){
      $level = 2;
    }
    
    $clankcurStr = json_encode([]);
    $sql5 = "update game_info set 
      run = 1,
      card = '".$syscardStr."',
      cardcur = '".$syscardcurStr."',
      cardcount = '".$syscardcount."',
      stay1 = 8,
      stay2 = 8,
      stay3 = 8,
      clank = '".$clankStr."',
      clankcur = '".$clankcurStr."',
      level = ".$level."
    ";
    DbSelect($db,$sql5);
    
    $db->close();
    echo 1;
	break;
  
  case 'exit' : //退出游戏
    $sql1 = "update game_info set run = 0 where run = 1";
		DbSelect($db,$sql1);
    $sql2 = "delete from game_player";
    DbSelect($db,$sql2);
    $db->close();
    
		echo 1;
	break;
  
  case 'sysInit':  //更新游戏进度等状态
    $sql = "select cardcur,cardcount,stay1,stay2,stay3,clank,clankcur,level from game_info";
    $result = DbSelect($db,$sql);
    $row = $result->fetchArray();
    $responce['cardcount'] = $row['cardcount'];
    $responce['cardcur'] = $row['cardcur'];
    $responce['stay1'] = $row['stay1'];
    $responce['stay2'] = $row['stay2'];
    $responce['stay3'] = $row['stay3'];
    $responce['clank'] = $row['clank'];
    $responce['clankcur'] = $row['clankcur'];
    $responce['level'] = $row['level'];
      
    $db->close();
		echo json_encode($responce);
    
  break;
  
  case 'handInit':  //更新手牌
    $userid = $_POST['userid'];
    $sql = "select * from game_player where userid='".$userid."'";
    $result = DbSelect($db,$sql);
    $row = $result->fetchArray();
    $responce['health'] = $row['health'];
    $responce['skill'] = $row['skill'];
    $responce['move'] = $row['move'];
    $responce['attack'] = $row['attack'];
    $responce['mibao'] = $row['mibao'];
    $responce['master'] = $row['master'];
    $responce['gold'] = $row['gold'];
    $responce['card'] = $row['card'];
    $responce['cardcur'] = $row['cardcur'];
    $responce['cardnum'] = $row['cardnum'];
    $responce['cardcurnum'] = $row['cardcurnum'];
      
    $db->close();
		echo json_encode($responce);
    
  break;
}
?>








