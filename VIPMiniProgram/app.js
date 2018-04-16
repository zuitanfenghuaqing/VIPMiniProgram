//app.js
var http = require('utils/server.js');
App({
  onLaunch: function () {
    // 展示本地存储能力
    var logs = wx.getStorageSync('logs') || []
    logs.unshift(Date.now())
    wx.setStorageSync('logs', logs)

    // 登录
    wx.login({
      success: res => {
        // 发送 res.code 到后台换取 openId, sessionKey, unionId
      }
    })
    // 获取用户信息
    wx.getSetting({
      success: res => {
        if (res.authSetting['scope.userInfo']) {
          // 已经授权，可以直接调用 getUserInfo 获取头像昵称，不会弹框
          wx.getUserInfo({
            success: res => {
              // 可以将 res 发送给后台解码出 unionId
              this.globalData.userInfo = res.userInfo

              // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
              // 所以此处加入 callback 以防止这种情况
              if (this.userInfoReadyCallback) {
                this.userInfoReadyCallback(res)
              }
            }
          })
        }
      }
    })
  },
  getUserInfo: function (cb) {
    var that = this
    if (that.globalData.userInfo) {
      typeof cb == "function" && cb(that.globalData.userInfo)
    } else {
      //没有用户信息获取用户信息
      wx.login({
        success: function (result) {
          console.log('微信登录', result);
          if (result.code) {
            //调用登录接口 
            wx.getUserInfo({
              withCredentials: true,
              success: function (res) {
                console.log('微信获取用户信息', res);
                that.globalData.userInfo = res.userInfo
                var userInfo = res.userInfo
                //发起网络请求
                http.post({
                  url: "weixin/login", code: result.code, encryptedData: res.encryptedData, iv: res.iv
                }, function (data) {
                  // console.log('登录服务器', data);
                  if (data.ok == 1) {
                    wx.setStorageSync("token", data.token)
                    that.globalData.latitude = data.lat
                    that.globalData.longitude = data.lng
                    that.globalData.userInfo.subGzh = data.sub_gzh == 1 ? true : false
                    typeof cb == "function" && cb(that.globalData.userInfo)
                  }
                })
              },
              fail: function (err) {
                console.log('获取用户信息失败', err);
                wx.showModal({
                  content: '获取授权信息失败，请设置 点击右上角[•••]->[关于开喜]->右上角[•••]->[设置]->[用户信息]->开 允许获取用户信息',
                  showCancel: false
                })
                typeof cb == "function" && cb(null)
              }
            })
          } else {
            console.log('获取用户登录信息失败！' + res.errMsg)
          }
        },
        fail: function (e) {
          console.log('获取用户登录信息失败！' + e)
        }
      });
    }
  },
  globalData: {
    userInfo: null
  }
})