import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

let state = {
  blogInfo: {}
}

axios.get('/wordpress-4.7.4/wp-json/xm-blog/v1/info')
  .then((res) => (state.blogInfo = res.data))
  .catch((res) => (state.blogInfo = { msg: '请求出错' }))

export default new Vuex.Store({
  state
})
