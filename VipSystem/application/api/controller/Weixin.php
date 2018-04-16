<?php

namespace app\api\controller;

use think\Db;
use \wx\WeixinService;

class Weixin extends BaseController
{
    //微信登录获取
    public function login()
    {  
        $wxs = new \wx\WeixinService();
        $a =httpGet("http://www.baidu.com");
        print_r($a);
        return Json(config('wx_appid'));
        // $surl=sprintf("https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",self::$appId,self::$secretKey,$para["code"]);
		// $result=Utility::HttpGet($surl);
		// $result=json_decode($result);
		// if($result->openid)
		// {
		// 	$miaodaoService=new D_MiaoDaoService();
		// 	$error=$miaodaoService->decryptData($result->session_key,$para["encryptedData"],$para["iv"],$userData);
		// 	if($error)
		// 		return array("ok"=>-111,"error"=>"获取用户信息失败！");
		// 	$skey="";
		// 	$user=new D_Base("miaodao.user");
		// 	$userInfo=$user->QueryRow(array("openid"=>$result->openid));
		// 	if(!$userInfo&&$userData["unionId"])
		// 	{
		// 		$userInfo=$user->QueryRow(array("unionid"=>$userData["unionId"]));
		// 	}
		// 	$lng=0;
		// 	$lat=0;
		// 	if($userInfo)
		// 	{
		// 		$user->UpdateRow(array("_id"=>new MongoId($userInfo["_id"])),array("unionid"=>$userData["unionId"],"openid"=>$result->openid,"session_key"=>$result->session_key,"expires_in"=>time()+$result->expires_in,"name"=>$userData["nickName"],"gender"=>intval($userData["gender"]),"city"=>$userData["city"],"province"=>$userData["province"],"country"=>$userData["country"],"avatar"=>$userData["avatarUrl"],"last_ip"=>Utility::GetRemoteIp (),"last_time"=>time()));
		// 		$skey=strval($userInfo["_id"]);
		// 		$lat=floatval($userInfo["coordinate"]["latitude"]);
		// 		$lng=floatval($userInfo["coordinate"]["longitude"]);
		// 	}
		// 	else
		// 	{
		// 		//$wxUserInfo=self::WxUserInfo($result->session_key);
		// 		//print_r($wxUserInfo);
		// 		$row=array("openid"=>$result->openid,"unionid"=>$userData["unionId"],"session_key"=>$result->session_key,"expires_in"=>time()+$result->expires_in,"name"=>$userData["nickName"],"gender"=>intval($userData["gender"]),"city"=>$userData["city"],"province"=>$userData["province"],"country"=>$userData["country"],"avatar"=>$userData["avatarUrl"],"last_ip"=>Utility::GetRemoteIp (),"last_time"=>time(),"ct"=>time());	
		// 		$user->InsertRow($row);
		// 		$skey=strval($row["_id"]);
		// 	}
		// 	return array("ok"=>1,"skey"=>$skey,"lat"=>$lat,"lng"=>$lng,"sub_gzh"=>$userInfo["gzh_openid"]?1:0);
    }

    //微信获取用户信息获取
    public function getUserInfo($para)
    {
        $xcxUser = $para['xcx_user'];

        if (!$xcxUser['user_id']) {
            return array('ok' => 2);
        } else {
            $user = new D_Base('user');
            $userInfo = $user->QueryRow(array('_id' => new MongoId($xcxUser['user_id'])));
            if (!$userInfo) {
                return array('ok' => 2);
            } else {
                return array('ok' => 1, 'user_info' => array('name' => $userInfo['name'], 'phone' => substr($userInfo['phone'], 0, 3).'****'.substr($userInfo['phone'], 7, 4), 'yubi' => intval($userInfo['yubi'])));
            }
        }
    }
}
