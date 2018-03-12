import axios from 'axios'
const state = {
  blogInfo: {},
  navList: {},
  topNavList: {},
  bLoading: true
}

const mutations = {
  getInfo (state) {
    // 获取网站基本信息
    axios.get('/wp-json/xm-blog/v1/info').then((res) => {
      state.blogInfo = res.data
      state.bLoading = false
    }).catch((res) => (state.blogInfo = { msg: '请求出错' }))
    // 获取置顶菜单
    axios.get('/wp-json/xm-blog/v1/top-menu').then((res) => (state.topNavList = res.data)).catch((err) => console.log(err.response))
    // 获取主菜单
    axios.get('/wp-json/xm-blog/v1/menu').then((res) => (state.navList = res.data)).catch((err) => console.log(err.response))
  }
}

export default {
  state,
  mutations
}
