<?php

namespace app\api\controller;

use think\Db;

class Weixin extends BaseController
{
    //微信登录获取
    public function login()
    {  
        return Json(config('wx_appid'));
        // $surl = sprintf('https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code', self::$appId, self::$secretKey, $para['code']);
        // $result = Utility::HttpGet($surl);
        // $result = json_decode($result);
        // if ($result->openid) {
        //     $skey = '';
        //     $xcx = new D_Base('xcx.user');
        //     $xcxUser = $xcx->QueryRow(array('openid' => $result->openid));
        //     $lng = 0;
        //     $lat = 0;
        //     if ($xcxUser) {
        //         $xcx->UpdateRow(array('_id' => new MongoId($xcxUser['_id'])), array('session_key' => $result->session_key, 'expires_in' => time() + $result->expires_in));
        //         $skey = strval($xcxUser['_id']);
        //         $lat = $xcxUser['coordinate']['latitude'];
        //         $lng = $xcxUser['coordinate']['longitude'];
        //     } else {
        //         $row = array('openid' => $result->openid, 'session_key' => $result->session_key, 'expires_in' => time() + $result->expires_in);
        //         $xcx->InsertRow($row);
        //         $skey = strval($row['_id']);
        //     }

        //     return array('ok' => 1, 'skey' => $skey, 'lat' => $lat, 'lng' => $lng);
        // } else {
        //     return array('ok' => -110, 'error' => '获取授权信息失败！');
        // }
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
