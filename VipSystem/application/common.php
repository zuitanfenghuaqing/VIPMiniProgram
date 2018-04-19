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

// 成功返回
function success($data = [])
{
    return json(['data' => $data, 'code' => 0, 'message' => 'success']);
}

//失败返回
function error($message = 'error', $code = 10000)
{
    return json(['code' => $code, 'message' => $message]);
}

 //post数据到指定url,并返回结果
 function httpPost($url, $postVars, $headers = null)
 {
     $ch = curl_init($url);
     curl_setopt($ch, CURLOPT_HEADER, false);
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, true);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     curl_setopt($ch, CURLOPT_TIMEOUT, 35);
     if ($headers) {
         curl_setopt($ch, CURLOPT_HTTPHEADER, 'Content-Length:'.strlen($postVars));
         curl_setopt($ch, CURLOPT_HTTPHEADER, 'Content-Type:application/x-www-form-urlencoded; charset=UTF-8');
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         //echo $headers;
     }

     curl_setopt($ch, CURLOPT_POSTFIELDS, $postVars);

     $r = curl_exec($ch);
     if (curl_errno($ch)) {
         echo curl_error($ch);

         return -1;
     }
     curl_close($ch);

     return $r;
 }

 //从指定url get数据
 function httpGet($url, $userpwd = null, $headers = null)
 {
     $ch = curl_init($url);
     curl_setopt($ch, CURLOPT_HEADER, false);
     curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, true);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
     if ($userpwd) {
         curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
     }
     if ($headers) {
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
     }
     $r = curl_exec($ch);
     if (curl_errno($ch)) {
         return -1;
     }
     curl_close($ch);

     return $r;
 }

 //获取远程ip地址
function getRemoteIp()
{
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    if (isset($_SERVER['REMOTE_ADDR'])) {
        return $_SERVER['REMOTE_ADDR'];
    }

    return null;
}

//将时间转化为几分几秒前
function beforeTime($sTime)
{
    $cTime = time();
    $dTime = $cTime - $sTime;
    $dDay = intval(date('Ymd', $cTime)) - intval(date('Ymd', $sTime));
    $dYear = intval(date('Y', $cTime)) - intval(date('Y', $sTime));
    if ($dTime <= 10) {
        $dTime = '刚刚';
    } elseif ($dTime < 60) {
        $dTime = $dTime.'秒前';
    } elseif ($dTime < 3600) {
        $dTime = intval($dTime / 60).'分钟前';
    } elseif ($dTime >= 3600 && 0 == $dDay) {
        $dTime = intval($dTime / 3600).'小时前';
    } elseif (1 == $dDay) {
        $dTime = '昨天'.date('H:i', $sTime);
    } elseif (2 == $dDay) {
        $dTime = '前天'.date('H:i', $sTime);
    } elseif ($dDay < 4) {
        $dTime = $dDay.'天前';
    } elseif ($dDay >= 4 && 0 == $dYear) {
        $dTime = date('m-d H:i', $sTime);
    } else {
        $dTime = date('Y-m-d H:i', $sTime);
    }

    return $dTime;
}

//获取显示长度,2英文算一个长度 $s必须为utf-8编码
function getShowLen($s)
{
    $al = mb_strlen($s);

    $el = 0;
    foreach (unpack('C*', $s) as $e) {
        if ($e <= 0x7F) { //<=0x7F的是英文字符
            ++$el;
        }
    }

    return ($al - $el) + intval($el / 2) + $el % 2;
}

//截取字符串
function subString($str, $len, $IsNotPoint = false)
{ 
    $temp = getShowLen($str);
    if ($temp == $len) {
        return $str;
    } else {
        $len = $len - 1;
    }
    $start = 0;
    $chars = $str;
    $i = 0;
    do {
        if (preg_match("/[0-9a-zA-Z ,:.;?!'\"]/", $chars[$i])) {
            ++$m;
        } else {
            ++$n;
        }
        $k = $n / 3 + $m / 2;
        $l = $n / 3 + $m;
        ++$i;
    } while ($k < $len);
    $str1 = mb_substr($str, $start, $l, 'utf-8');
    if (strlen($str) == strlen($str1)) {
        return $str;
    } elseif ($IsNotPoint) {
        return $str1;
    } else {
        return $str1.'..';
    }
}
