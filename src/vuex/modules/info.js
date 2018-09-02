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
      // 获取主菜单
      window.axios.get('/wp-json/xm-blog/v1/menu').then(res => {
        let _res = res.data
        state.topNavList = _res.topMenu
        state.navList = _res.mainMenu
        _res.mainMenu[Object.keys(_res.mainMenu)[0]].icon === '' ? state.bShowNavIcon = false : state.bShowNavIcon = true
      }).catch(err => console.log(err))
    })
  }
}

export default {
  state,
  mutations
}
