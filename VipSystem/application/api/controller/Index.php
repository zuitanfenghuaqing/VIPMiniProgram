<?php

namespace app\api\controller;

use think\Db;

//首页
class Index extends BaseController
{
    //首页
    public function index()
    {
        return success();
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
    public function getNotice()
    {
        $limit = 3;
        $skip = 0;
        // echo bDate(time()-86400*2);
        // $data = ['content' => '通知：尤尼克斯球拍由于供应不足，限制临时调整发货时间，具体调整如下：20：30~23：56只接单不发货尤尼克斯球拍由于供应不足，限制临时调整发货时间，具体调整如下：20：30~23：56只接单不发货', 'come_from' => '平台','time'=>time(),'is_top'=>1,'gang_id'=>'5ad177e836d91420300032e6','user_id'=>'5ad177e836d91420300032e7'];
        // Db::name('notice')->insert($data);
        // $data = ['content' => '通知：尤尼克斯球拍由于供应不足，限制临时调整发货时间，具体调整如下：20：30~23：56只接单不发货尤尼克斯球拍由于供应不足，限制临时调整发货时间，具体调整如下：20：30~23：56只接单不发货', 'come_from' => '帮主','time'=>time(),'gang_id'=>'5ad177e836d91420300032e6'];
        // Db::name('notice')->insert($data);
        // $data = ['content' => '通知：尤尼克斯球拍由于供应不足，限制临时调整发货时间，具体调整如下：20：30~23：56只接单不发货尤尼克斯球拍由于供应不足，限制临时调整发货时间，具体调整如下：20：30~23：56只接单不发货', 'come_from' => '平台','time'=>time(),'gang_id'=>'5ad177e836d91420300032e6'];
        // Db::name('notice')->insert($data);
        $query['come_from'] = ['like', 'a'];
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

    public function publishNotice(){ 
        $user_id = session('user_id');
        if(!$user_id||strlen($user_id)!=24)
            return error('请先登录'); 
        $content = input('post.content', '');
        if(!$content)
            return error('缺少内容');
        $is_top = input('post.is_top', ''); 
        $gang_id = session('gang_id');
        if(!$gang_id)
            return error('请先登录');
        $data = ['content' =>  $content, 'come_from' => '帮主','time'=>time(),'is_top'=>$is_top,'gang_id'=>$gang_id,'user_id'=>$user_id];
        Db::name('notice')->insert($data);
        return success();
    }
}
