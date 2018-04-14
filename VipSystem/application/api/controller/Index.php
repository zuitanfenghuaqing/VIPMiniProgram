<?php

namespace app\api\controller;

use think\Db;

class Index
{
    public function index()
    {
        // return json(['code'=>0,'message'=>'index']);
        //test
        // $data = ['name'=>'thinkphp','url'=>'thinkphp.cn'];
        // 指定json数据输出
        // return json(['data'=>$data,'code'=>1,'message'=>'操作完成']);
        $data = ['foo' => 'bar', 'bar' => 'foo'];
        Db::name('demo')->insert($data);
        $data = Db::name('demo')->find();
        print_r($data);

        $d = Db::name('demo')
        ->field('id,name')
        ->limit(100)->skip(1)
        ->order('id', 'desc')
        ->select();
        print_r($d);
    }

    public function test()
    {
        return json(['code'=>0,'message'=>'index']);
    }
    public function bar()
    {
        echo 'bar';
    }
    public function hello()
    {
        echo 'hello';
    }
}
