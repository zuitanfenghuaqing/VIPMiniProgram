//index.js
//获取应用实例
const app = getApp()

Page({
  data: {
    menuData: [{
      title: "类别",
      list: [{ id: "111", name: "羽毛球1" }, { id: "222", name: "羽毛球2" }, { id: "333", name: "羽毛球3" }, { id: "444", name: "羽毛球4" }]
    }, {
      title: "品牌",
      list: [{ id: "111", name: "羽毛球11" }, { id: "222", name: "羽毛球22" }, { id: "333", name: "羽毛球33" }, { id: "444", name: "羽毛球44" }]
    }],
    selectMenu: {
      current: -1,
      selectedCurrent: -1,
      selectedChild: -1,
      isShow: false,
    }
  },

  onShow: function (option) {
    var that = this;

    //用户信息
    app.getUserInfo(function (userInfo) {
      if (userInfo != null) {
        that.setData({
          userInfo: {
            headUrl: userInfo.avatarUrl,
            name: userInfo.nickName
          }
        })
      } else {
        that.setData({
          isGetedUserInfo: false,
          pageLoading: false,
          showError: '未获取到用户信息'
        })
      } 
      //产品列表
      httpServer.httpGet({ url: "index/getProductList", type: "5ad3204c36d9142128006157" }, function (data) {
        console.log('产品列表', data)
        if (data != null && data.ok == 1) {
          that.setData({
            classify: data.list
          })
        }
      }) 

    })
  },

  menuTap: function (e) {
    var selectMenu = this.data.selectMenu;
    selectMenu.isShow = !selectMenu.isShow;
    if (selectMenu.current != e.currentTarget.dataset.index)
      selectMenu.isShow = true;
    selectMenu.current = e.currentTarget.dataset.index;
    this.setData({
      selectMenu: selectMenu
    })
  },

  childMenuTap: function (e) {
    var selectMenu = this.data.selectMenu;
    selectMenu.selectedChild = e.currentTarget.dataset.index;
    selectMenu.isShow = false;
    selectMenu.selectedCurrent = e.currentTarget.dataset.pid;
    this.setData({
      selectMenu: selectMenu
    })
  },

})
