<?php

namespace app\api\controller;

use think\Db;

//收货地址
class Address extends BaseController
{
    //获取微信共享收货地址
    public function get_address_api()
    {
        $APPID = C('APPID');
        $SCRETID = C('SCRETID');
        if (!isset($_GET['code'])) {
            $backurl = $this->get_url();
            $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$APPID.'&redirect_uri='.urlencode($backurl).'&response_type=code&scope=jsapi_address&state=123#wechat_redirect';
            // snsapi_userinfo
            header("Location: $url");
            exit;
        } else {
            $code = $_GET['code'];
            $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$APPID.'&secret='.$SCRETID.'&code='.$code.'&grant_type=authorization_code';
            $re = file_get_contents($url);
            $rearr = json_decode($re, true);
            $backurl = $this->get_url();
            $openid = $rearr['openid'];
            $unionid = $rearr['unionid'];
            $asstoken = $rearr['access_token'];
            S('jsapi_address_token'.$openid, $asstoken, 7200);
            $data['appid'] = $APPID;
            $data['url'] = $backurl;
            $data['timestamp'] = strval(time());
            $data['noncestr'] = rand(100000, 999999);
            $data['accesstoken'] = $asstoken;
            foreach ($data as $k => $v) {
                $Parameters[$k] = $v;
            }
            //签名步骤一：按字典序排序参数
            ksort($Parameters);
            $String = $this->formatBizQueryParaMap($Parameters, false);
            $data['addrsign'] = sha1($String);
            $this->assign('data', $data);
        }
        $this->siteDisplay('address_api');
    }

    // TODO 智能识别收货地址
    public function identificationAddress()
    {
    }

    //获取所有收货地址
    public function getAll()
    {
        //test
        $data = [
            'consignee' => '张三',
            'phone' => '18912345678',
            'address' => '新疆乌鲁木齐锦江区成龙路接到安静路1031栋1单元456室',
            'province' => '四川省',
            'city' => '成都市',
            'county' => '查查区',
            'street' => '查查街',
            'position' => ['lng' => 104.06456556, 'lat' => 30.671456],
        ];
        Db::name('address')->insert($data);

        $id = input('post.id', '');
        if (!$id || 24 != strlen($id)) {
            return error('Id错误');
        }
        $data = Db::name('address')->find($id);

        return success($data);
    }

    //获取所有快递
    public function getAllExpress()
    {
        //test
        $data = ['name' => '顺丰'];
        Db::name('express')->insert($data);
        $data = ['name' => '圆通'];
        Db::name('express')->insert($data);
        $data = ['name' => '申通'];
        Db::name('express')->insert($data);

        $data = Db::name('express')->select();

        return success($data);
    }
}
