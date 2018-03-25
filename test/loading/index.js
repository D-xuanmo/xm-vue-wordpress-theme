import Vue from 'vue'
import loadingCompon from './Loading'
const VueLoading = Vue.extend(loadingCompon)
let loading = null

const Loading = {
  show (opt) {
    if (!loading) {
      loading = new VueLoading()
      loading.$mount()
      document.querySelector('body').appendChild(loading.$el)
    }
    loading.show()
  },
  close () {
    loading.hide()
  }
}
// const Loading = {
//   install (Vue, opt = {}) {
//     // 创建"子类"方便挂载
//     const VueLoading = Vue.extend(loadingCompon)
//     let loading = null
//     let loadingFn = () => {
//       // 第一次调用
//       if (!loading) {
//         loading = new VueLoading()
//         // 手动创建一个未挂载的实例
//         loading.$mount()
//         // 挂载
//         document.querySelector(opt.container || 'body').appendChild(loading.$el)
//       }
//       // 显示loading
//       loading.show()
//     }
//
//     loadingFn.end = () => loading.hide()
//
//     Vue.loading = Vue.prototype.$loading = loadingFn
//   }
// }

export default Loading
