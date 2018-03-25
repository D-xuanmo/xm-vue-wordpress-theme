const state = {
  blogInfo: {},
  navList: {},
  topNavList: {},
  bLoading: true,
  bShowNavIcon: false
}

const mutations = {
  getInfo (state) {
    new Promise((resolve, reject) => {
      // 获取网站基本信息
      window.axios.get('/wp-json/xm-blog/v1/info').then(res => {
        state.blogInfo = res.data
        state.bLoading = false
        resolve()
      }).catch(err => console.log(err))
    }).then(resolve => {
      // 获取置顶菜单
      window.axios.get('/wp-json/xm-blog/v1/top-menu').then(res => (state.topNavList = res.data)).catch(err => console.log(err.response))
    }).then(resolve => {
      // 获取主菜单
      window.axios.get('/wp-json/xm-blog/v1/menu').then(res => {
        state.navList = res.data
        res.data[Object.keys(res.data)[0]].icon === '' ? state.bShowNavIcon = false : state.bShowNavIcon = true
      }).catch(err => console.log(err.response))
    })
  }
}

export default {
  state,
  mutations
}
