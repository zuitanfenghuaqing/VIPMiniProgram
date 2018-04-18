<?php

namespace app\api\controller;

use think\Db;

//产品
class Product extends BaseController
{
    //获取产品详情
    public function getDetail()
    {
        $data = [
            'name' => 'YONEX/尤尼克斯BR-45652新色李宗伟战拍',
            'price' => 238,
            'discount' => 6.8,
            'sales' => 2365,
            'pic' => 'http://img10.360buyimg.com/n1/jfs/t9784/92/1621868077/151866/cb7fbd64/59e42128Nd18189de.jpg',
            'pics' => ['http://img10.360buyimg.com/n1/jfs/t9784/92/1621868077/151866/cb7fbd64/59e42128Nd18189de.jpg',
                    'http://img10.360buyimg.com/n1/jfs/t9784/92/1621868077/151866/cb7fbd64/59e42128Nd18189de.jpg',
                    'http://img10.360buyimg.com/n1/jfs/t9784/92/1621868077/151866/cb7fbd64/59e42128Nd18189de.jpg', ],
            'info' => ['http://img10.360buyimg.com/n1/jfs/t9784/92/1621868077/151866/cb7fbd64/59e42128Nd18189de.jpg',
                            'http://img10.360buyimg.com/n1/jfs/t9784/92/1621868077/151866/cb7fbd64/59e42128Nd18189de.jpg',
                            'http://img10.360buyimg.com/n1/jfs/t9784/92/1621868077/151866/cb7fbd64/59e42128Nd18189de.jpg', ],
            'tag' => '正品认证',
            'specifications' => [[
                'title' => '红色XL', 'price' => 240.00, 'stock' => 1234, 'unit' => '件', 'retail_price' => 300.00,
            ], [
                'title' => '蓝色XXL', 'price' => 260.00, 'stock' => 1234, 'unit' => '件', 'retail_price' => 360.00,
            ]],
        ];
        Db::name('product')->insert($data);
        $id = input('post.id', '');
        if (!$id || 24 != strlen($id)) {
            return error('Id错误');
        }
        $data = Db::name('product')->find($id);
        $query['product_id'] = $id;
        $order = ['level' => 'desc', 'ct' => 'desc'];
        $evaluate = Db::name('product')->where($query)->order($order)->find();
        $evaluate['user_info'] = Db::name('user')->field('name,avatar')->find($evaluate['user_id']);
        $data['evaluate'] = $evaluate;
        $data['evaluate_count'] = Db::name('product')->where(['product_id' => $id])->count();

        return success($data);
    }

    //朋友圈素材
    public function getMaterial()
    {
        $id = input('post.id', '');
        if (!$id || 24 != strlen($id)) {
            return error('Id错误');
        }
        $data = Db::name('material')->where(['product_id' => $id])->select();

        return success($data);
    }

    //修改价格
    public function editPrice()
    {
        $id = input('post.id', '');
        if (!$id || 24 != strlen($id)) {
            return error('Id错误');
        }
    }

    //粉丝奖励
    public function getFansReward()
    {
        $id = input('post.id', '');
        if (!$id || 24 != strlen($id)) {
            return error('Id错误');
        }
    }

    //售后说明
    public function getAfterSaleIntro()
    {
        $id = input('post.id', '');
        if (!$id || 24 != strlen($id)) {
            return error('Id错误');
        }
    }

    //转发
    public function forward()
    {
    }
}
