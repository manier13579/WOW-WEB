<?php
require 'db.php';
$db = DbOpen();
$action = $_POST['action'];

switch ($action){
	case 'getCard' : //读取卡牌信息
    
    $sql = "select 
      id,
      name,
      type,
      detail,
      remark,
      trigger,
      condition,
      event,
      acquire,
      arrive,
      special,
      cost,
      reward_type1,
      reward_value1,
      reward_type2,
      reward_value2,
      reward_type3,
      reward_value3,
      value,
      expansion
      from card";
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

}
?>