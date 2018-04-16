function formatTime(date) {
  var year = date.getFullYear()
  var month = date.getMonth() + 1
  var day = date.getDate()

  var hour = date.getHours()
  var minute = date.getMinutes()
  var second = date.getSeconds()


  return [year, month, day].map(formatNumber).join('/') + ' ' + [hour, minute, second].map(formatNumber).join(':')
}

function formatNumber(n) {
  n = n.toString()
  return n[1] ? n : '0' + n
}

//验证金额 2位小数
function validPrice(val) {
  var prc = /^\d+(\.\d{1,2})?$/
  return prc.test(val)
}

//扩展对象
function extendObj(obj, objE) {
  var newObj = cloneObj(obj)
  for (var k in objE)
    newObj[k] = cloneObj(objE[k])
  return newObj
}

//复制对象方法
function cloneObj(oldObj) {
  if (typeof (oldObj) != 'object')
    return oldObj
  if (oldObj == null)
    return oldObj
  var newObj = new Object()
  for (var k in oldObj)
    newObj[k] = cloneObj(oldObj[k])
  return newObj
}

module.exports = {
  formatTime: formatTime,
  validPrice: validPrice,
  extendObj: extendObj
}
