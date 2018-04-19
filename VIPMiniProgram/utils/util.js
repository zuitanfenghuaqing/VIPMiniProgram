const formatTime = date => {
  const year = date.getFullYear()
  const month = date.getMonth() + 1
  const day = date.getDate()
  const hour = date.getHours()
  const minute = date.getMinutes()
  const second = date.getSeconds()
  return [year, month, day].map(formatNumber).join('/') + ' ' + [hour, minute, second].map(formatNumber).join(':')
}


const formatNumber = n => {
  n = n.toString()
  return n[1] ? n : '0' + n
}

//验证金额 2位小数
const validPrice = val => {
  var prc = /^\d+(\.\d{1,2})?$/
  return prc.test(val)
}

//扩展对象
const extendObj = (obj, objE) => {
  var newObj = cloneObj(obj)
  for (var k in objE)
    newObj[k] = cloneObj(objE[k])
  return newObj
}

//复制对象方法
const cloneObj = oldObj => {
  if (typeof (oldObj) != 'object')
    return oldObj
  if (oldObj == null)
    return oldObj
  var newObj = new Object()
  for (var k in oldObj)
    newObj[k] = cloneObj(oldObj[k])
  return newObj
}

// 显示繁忙提示
var showBusy = text => wx.showToast({
  title: text,
  icon: 'loading',
  duration: 5000
})

// 显示成功提示
var showSuccess = text => wx.showToast({
  title: text,
  icon: 'success'
})

// 显示失败提示
var showModel = (title, content) => {
  wx.hideToast();

  wx.showModal({
    title,
    content: JSON.stringify(content),
    showCancel: false
  })
}


module.exports = {
  formatTime,
  validPrice,
  extendObj,
  formatTime, 
  showBusy, 
  showSuccess, 
  showModel
}
