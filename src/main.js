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

// router切换每次滚动条到顶部
router.afterEach(() => window.scrollTo(0, 0))

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
