<?php

namespace app\api\controller;

use think\Db;
use think\Controller;

class BaseController extends Controller
{  
    public function _initialize()
    {
        // if (!request()->isPost()) exit("A request that only allows post");
    }
}
