<?php

namespace app\api\controller;

use think\Db;

//收货地址
class Address extends BaseController
{
    //获取所有收货地址
    public function getAll()
    {       
        $data = [
            'name' => 'YONEX/尤尼克斯BR-45652新色李宗伟战拍', 
            'price' => 238,
            'discount'=>6.8,
            'sales'=>2365,
            'pic'=>'http://img10.360buyimg.com/n1/jfs/t9784/92/1621868077/151866/cb7fbd64/59e42128Nd18189de.jpg', 
            'pics'=>['http://img10.360buyimg.com/n1/jfs/t9784/92/1621868077/151866/cb7fbd64/59e42128Nd18189de.jpg', 
                    'http://img10.360buyimg.com/n1/jfs/t9784/92/1621868077/151866/cb7fbd64/59e42128Nd18189de.jpg',
                    'http://img10.360buyimg.com/n1/jfs/t9784/92/1621868077/151866/cb7fbd64/59e42128Nd18189de.jpg'],
            'info'=>['http://img10.360buyimg.com/n1/jfs/t9784/92/1621868077/151866/cb7fbd64/59e42128Nd18189de.jpg', 
                            'http://img10.360buyimg.com/n1/jfs/t9784/92/1621868077/151866/cb7fbd64/59e42128Nd18189de.jpg',
                            'http://img10.360buyimg.com/n1/jfs/t9784/92/1621868077/151866/cb7fbd64/59e42128Nd18189de.jpg'],
            'tag'=>'正品认证',
            'specifications'=>[[
                'title'=>'红色XL','price'=>240.00,'stock'=>1234,'unit'=>'件','retail_price'=>300.00
            ],[
                'title'=>'蓝色XXL','price'=>260.00,'stock'=>1234,'unit'=>'件','retail_price'=>360.00
            ]]
        ];
        Db::name('address')->insert($data);
        
        $id = input('post.id', '');
        if(!$id||strlen($id)!=24)
            return error('Id错误'); 
        $data = Db::name('address')->find($id);
        return success($data);
    }


}
