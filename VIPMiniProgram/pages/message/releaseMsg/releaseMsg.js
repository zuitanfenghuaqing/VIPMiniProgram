
const app = getApp()
Page({
    data: {
        height: 20,
        focus: false,
        items: [
          {name: 'TOP', value: '置顶', checked: 'true'},
        ]
      },
      bindFormSubmit: function(e) {
        console.log(e.detail.value.textarea)
        console.log(1111)
      },
})