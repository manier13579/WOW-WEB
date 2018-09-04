<?php
require '../../vendor/autoload.php';
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;

function validateToken($token = null) 
{
  if($token=='notlogin'){
    return false; //未登录
  }
  $token = (new Parser())->parse((string) $token);//从字符串解析token
  $signer = new Sha256();
  if (!$token->verify($signer, '杨村长万岁')) {
    return false; //签名不正确
  }

  $validationData = new ValidationData();
  $validationData->setIssuer('bing');

  return $token->validate($validationData);
}


?>