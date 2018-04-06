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
