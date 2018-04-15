<?php

namespace app\api\controller;

use think\Db;

class Index1 extends BaseController
{
    public function index()
    {
        return json(['code' => 0, 'message' => 'index']);
        //test
        // $data = ['name'=>'thinkphp','url'=>'thinkphp.cn'];
        // 指定json数据输出
        // return json(['data'=>$data,'code'=>1,'message'=>'操作完成']);
        // $data = ['foo' => 'bar', 'bar' => 'foo'];
        // Db::name('demo')->insert($data);
        // $data = Db::name('demo')->find();
        // print_r($data);

        // $d = Db::name('demo')
        // ->field('id,name')
        // ->limit(100)->skip(1)
        // ->order('id', 'desc')
        // ->select();
        // print_r($d);
    }

    // 首页顶部菜单的红点
    public function getRedPointNum()
    {
        //TODO 登录 session
        //红包
        $query['shop'] = '';
        $data = Db::name('red_packet_not_open_num')->where($query)->count();

        return success(['red_packet' => $data]);
    }

    // 公告
    public function getNotice($limit = 3, $skip = 0)
    {
        $query['foo'] = ['like', 'a'];
        $query['shop'] = '';
        $data = Db::name('notice')->where($query)->limit($limit)->skip($skip)->select();

        return success($data);
    }

    // 筛选条件
    public function getFilterData()
    {
        // $data = ['name' => 'YONEX/尤尼克斯',  'pic' => 'https://ss0.bdstatic.com/-0U0bnSm1A5BphGlnYG/tam-ogel/be31e7dd34766557ab26939993f4e162_121_121.jpg'];
        // Db::name('brand')->insert($data);
        // $data = ['name' => '李宁',  'pic' => 'http://img3.imgtn.bdimg.com/it/u=2826002269,1608223608&fm=27&gp=0.jpg'];
        // Db::name('brand')->insert($data);
        // $data=['name'=>'羽毛球'];
        // Db::name('type')->insert($data);
        // $data=['name'=>'球拍'];
        // Db::name('type')->insert($data);
        // $data=['name'=>'球鞋'];
        // Db::name('type')->insert($data);
        // $data=['name'=>'衣服'];
        // Db::name('type')->insert($data);
        // $data=['name'=>'护具'];
        // Db::name('type')->insert($data);

        $brand_data = Db::name('brand')->field('_id,name')->select();
        $type_data = Db::name('type')->field('_id,name')->select();
        $data = [['name' => '类别', 'data' => $type_data], ['name' => '品牌', 'data' => $brand_data]];

        return success($data);
    }

    // 产品列表
    public function getProductList()
    {
        $type = input('post.type', '');
        $brand = input('post.brand', '');
        //test
        // $data = ['name' => 'YONEX/尤尼克斯BR-45652新色李宗伟战拍', 'price' => 2388,'discount'=>6.8,'sales'=>2365,'pic'=>'http://img10.360buyimg.com/n1/jfs/t9784/92/1621868077/151866/cb7fbd64/59e42128Nd18189de.jpg'];
        // for ($i=0; $i < 10; $i++) {
        //     Db::name('product')->insert($data);
        // }
        if (24 != strlen($type) && $type) {
            return error('参数错误：错误的类别id');
        }

        if (24 != strlen($brand) && $brand) {
            return error('参数错误：错误的品牌id');
        }
        $query = [];
        if ($type) {
            $query['type'] = $type;
        }
        if ($brand) {
            $query['brand'] = $brand;
        }
        $data = Db::name('product')->where($query)->select();

        return success($data);
    }
}
