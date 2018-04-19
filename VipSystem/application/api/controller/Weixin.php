<?php

namespace app\api\controller;

use think\Db;

class Weixin extends BaseController
{
    //微信登录获取
    public function login()
    {
        //test
        $wxs = new \wx\WeixinService();
        var_dump($wxs->SendRechargeNotice('', ''));

        return 'ok';

        $code = input('post.code', '');
        $surl = sprintf('https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code', config('wx_appid'), config('wx_secretkey'), $code);
        $result = httpGet($surl);
        $result = json_decode($result);
        if ($result != -1 && $result->openid) {
            $wxs = new \wx\WeixinService();
            $encrypted_data = input('post.encrypted_data', '');
            $iv = input('post.iv', '');
            $error = $wxs->decryptData($result->session_key, $encrypted_data, $iv, $user_data);
            if ($error) {
                return error('获取用户信息失败！');
            }
            $skey = '';
            $user_info = Db::name('user')->where(['openid' => $result->openid])->find();
            if (!$user_info && $user_data['unionId']) {
                $user_info = $user->QueryRow(['unionid' => $user_data['unionId']]);
            }
            $lng = 0;
            $lat = 0;
            if ($user_info) {
                $user->UpdateRow(['id' => $user_info['id']], ['unionid' => $user_data['unionId'], 'openid' => $result->openid, 'session_key' => $result->session_key, 'expires_in' => time() + $result->expires_in, 'name' => $user_data['nickName'], 'gender' => intval($user_data['gender']), 'city' => $user_data['city'], 'province' => $user_data['province'], 'country' => $user_data['country'], 'avatar' => $user_data['avatarUrl'], 'last_ip' => getRemoteIp(), 'last_time' => time()]);
                $skey = strval($user_info['_id']);
                $lat = floatval($user_info['coordinate']['latitude']);
                $lng = floatval($user_info['coordinate']['longitude']);
            } else {
                //$wxuser_info=self::Wxuser_info($result->session_key);
                //print_r($wxuser_info);
                $row = ['openid' => $result->openid, 'unionid' => $user_data['unionId'], 'session_key' => $result->session_key, 'expires_in' => time() + $result->expires_in, 'name' => $user_data['nickName'], 'gender' => intval($user_data['gender']), 'city' => $user_data['city'], 'province' => $user_data['province'], 'country' => $user_data['country'], 'avatar' => $user_data['avatarUrl'], 'last_ip' => getRemoteIp(), 'last_time' => time(), 'ct' => time()];
                $user->InsertRow($row);
                $skey = strval($row['_id']);
            }

            return success(['skey' => $skey, 'lat' => $lat, 'lng' => $lng, 'sub_gzh' => $user_info['gzh_openid'] ? 1 : 0]);
        }
    }

    //微信获取用户信息获取
    public function getUserInfo()
    {
        $user_id = input('post.user_id', '');
        if (!$user_id) {
            return error('获取用户信息失败！');
        } else {
            $user_info = Db::name('user')->where(['id' => $user_id])->find();
            if (!$user_info) {
                return error('获取用户信息失败！');
            } else {
                return success(['ok' => 1, 'user_info' => ['name' => $user_info['name'], 'phone' => substr($user_info['phone'], 0, 3).'****'.substr($user_info['phone'], 7, 4), 'yubi' => intval($user_info['yubi'])]]);
            }
        }
    }
}
