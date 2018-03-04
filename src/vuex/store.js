import Vue from 'vue'
import Vuex from 'vuex'
import info from './modules/info'
import category from './modules/category'
import single from './modules/single'
import page from './modules/page'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    info,
    category,
    single,
    page
  }
})
