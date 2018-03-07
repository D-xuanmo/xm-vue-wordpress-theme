// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import Prism from '../static/js/prism'
import VeeValidate, { Validator } from 'vee-validate'
import zh from 'vee-validate/dist/locale/zh_CN'

import '../static/css/prism.css'

Validator.localize('zh_CN', zh)
Vue.use(VeeValidate)

Vue.config.productionTip = false

// 注册代码高亮指令
Vue.directive('highlight', (el) => {
  let blocks = el.querySelectorAll('pre code')
  blocks.forEach((block) => {
    Prism.highlightElement(block)
  })
})

// 设置img的style
Vue.directive('img-style', (el) => {
  el.querySelectorAll('img').forEach(val => {
    val.style = 'max-width: 30px; vertical-align: baseline;'
  })
})

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
  hasClass (el, name = '') {
    return el.className.match(new RegExp(name))
  },
  addClass (el, name) {
    if (!this.hasClass(el, name)) {
      el.className = el.className === '' ? name : el.className + ' ' + name
    }
  },
  removeClass (el, name) {
    if (this.hasClass(el, name)) {
      el.className = el.className.replace(new RegExp(`\\s*${name}\\s*`), '')
    }
  },
  siblings (el) {
    let arr = []
    Array.from(el.parentNode.children).forEach(item => {
      if (item !== el) arr.push(item)
    })
    return arr
  }
}
