var key = "48b9386188e47d9cbfa6621ee295b623";
var serverUrl = "http://111.231.190.91/api/";
var md5 = require("md5.js");
var util = require('../utils/util.js')
function getSign(para) {
  para.timestamp = new Date().getTime();
  var sdic = Object.keys(para).sort();
  var str = "";
  for (var ki in sdic) {
    if (typeof para[sdic[ki]] == "object")
      continue;
    if (para[sdic[ki]] == null)
      continue;
    str += sdic[ki] + encodeURIComponent(para[sdic[ki]]);
  }
  // console.log(str+key);
  var sign = md5.hex_md5(str + key);
  para["sign"] = sign;
  return para;
}
function wxRequest(data, cb) {
  var that = getApp()
  
  data["token"] = wx.getStorageSync('token') || "";

  //没有token 调接口 先调登录（除了登录以外）
  if (data["token"] == "" && data['url'] != "weixin/login") {
    if (that.globalData.userInfo) {
      typeof cb == "function" && cb(that.globalData.userInfo)
    } else {
      
      wx.login({
        success: function (result) {
          util.showBusy('正在登录')
          console.log('微信登录');
          if (result.code) {
            //调用登录接口 
            wx.getUserInfo({
              withCredentials: true,
              success: function (res) {
                that.globalData.userInfo = res.userInfo
                var userInfo = res.userInfo
                wx.request({
                  url: serverUrl + data['url'] ,
                  data: getSign(data),
                  method: "POST",
                  header: {
                    'content-type': 'application/json'
                  },
                  success: function (loginData) {
                    console.log('调用接口缺少token，请先登录服务器', loginData);
                    if (loginData.code == 0) { 
                      wx.setStorageSync("token", loginData.token)
                      that.globalData.latitude = loginData.lat
                      that.globalData.longitude = loginData.lng
                      typeof cb == "function" && cb(that.globalData.userInfo)
                    }
                  },
                  fail: function (err) {
                    console.log('网络请求失败', data, err)
                    cb({ code: 1, message: '网络请求失败，请重试' });
                  }
                })
              },
              fail: function (err) {
                console.log('获取用户信息失败', err);
                typeof cb == "function" && cb(null)
              }
            })
          } else {
            console.log('获取用户登录态失败！' + res.errMsg)
          }
        },
        fail: function (e) {
          console.log('获取用户登录态失败！' + e)
        }
      });
    }
  } else { 
    //调用登录
    util.showBusy('正在登录')
    wx.request({
      url: serverUrl + data['url'] ,
      data: getSign(data),
      method: "POST",
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        cb(res.data);
      },
      fail: function (err) {
        console.log('网络请求失败', data, err)
        cb({ code: 1, message: '网络请求失败，请重试' });
      }
    })
  }
}
module.exports = {
  post: wxRequest,
  getSign: getSign
}