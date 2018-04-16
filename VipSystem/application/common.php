<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function success($data)
{
    return json(['data' => $data, 'code' => 0, 'message' => 'success']);
}

function error($message = 'error', $code = 10000)
{
    return json(['code' => $code, 'message' => $message]);
}

 /*post数据到指定url,并返回结果*/
 function httpPost ($url, $postVars,$headers=NULL)
 {
     $ch = curl_init($url);
     curl_setopt($ch, CURLOPT_HEADER, false);
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, true);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     curl_setopt($ch, CURLOPT_TIMEOUT, 35);
     if($headers)
     {
         curl_setopt($ch, CURLOPT_HTTPHEADER, "Content-Length:".strlen($postVars));
         curl_setopt($ch, CURLOPT_HTTPHEADER, "Content-Type:application/x-www-form-urlencoded; charset=UTF-8");
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         //echo $headers;
     }
     
     curl_setopt($ch, CURLOPT_POSTFIELDS, $postVars);
     
     $r = curl_exec($ch);
     if (curl_errno($ch))
     {
         echo curl_error($ch);
         return - 1;
     }
     curl_close($ch);
     return $r;
 }
 
 /*从指定url get数据*/
 function HttpGet ($url,$userpwd=NULL,$headers=NULL)
 {
     $ch = curl_init($url);
     curl_setopt($ch, CURLOPT_HEADER, false);
     curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, true);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
     if($userpwd)
     {
         curl_setopt($ch,CURLOPT_USERPWD,$userpwd);
     }
     if($headers)
     {
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
     }
     $r = curl_exec($ch);
     if (curl_errno($ch))
     {
         return - 1;
     }
     curl_close($ch);
     return $r;
 }