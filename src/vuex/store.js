import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

const state = {
  blogInfo: {}
}

const mutations = {
  getInfo (state) {
    axios.get('/wordpress-4.7.4/wp-json/xm-blog/v1/info')
      .then((res) => {
        state.blogInfo = res.data
        console.log(state.blogInfo)
      }).catch((res) => (state.blogInfo = { msg: '请求出错' }))
  }
}

export default new Vuex.Store({
  state,
  mutations
})
