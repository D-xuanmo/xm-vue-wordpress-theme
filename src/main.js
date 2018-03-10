// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import Prism from '../static/js/prism'
import '../static/css/prism.css'

Vue.config.productionTip = false

// 注册代码高亮指令
Vue.directive('highlight', (el) => {
  let blocks = el.querySelectorAll('pre code')
  blocks.forEach((block) => {
    Prism.highlightElement(block)
  })
})

// 设置表情样式
Vue.directive('img-style', (el) => {
  el.querySelectorAll('img').forEach(item => {
    if (item.className.indexOf('wp-smiley') !== -1) item.style = 'max-width: 30px; vertical-align: baseline;'
  })
})

// 设置网页标题
Vue.directive('title', (el, binding) => {
  document.title = binding.value
})

// router切换每次滚动条到顶部
router.afterEach(() => window.scrollTo(0, 0))

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})

window.XM = {
  siblings (el) {
    let arr = []
    Array.from(el.parentNode.children).forEach(item => {
      if (item !== el) arr.push(item)
    })
    return arr
  }
}
