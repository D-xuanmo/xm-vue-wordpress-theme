const state = {
  id: 0,
  viewCount: 0,
  articleContent: {},
  classify: [],
  tags: [],
  commentCount: 0,
  bShowLoading: true,
  authorOtherInfo: {
    github: {
      icon: '#icon-GitHub'
    },
    qq: {
      icon: '#icon-qq1'
    },
    wechatNum: {
      icon: '#icon-weixin5'
    },
    sina: {
      icon: '#icon-xinlang1'
    },
    email: {
      icon: '#icon-youxiang'
    }
  }
}

const actions = {
  getArticle ({ commit, state }, _params) {
    let oResult = {}
    new Promise((resolve, reject) => {
      // 更新文章阅读量
      window.axios.post(`/wp-json/xm-blog/v1/view-count/`, {
        params: {
          id: _params.id
        }
      }).then((res) => {
        oResult = Object.assign(oResult, {
          id: _params.id,
          viewCount: res.data
        })
        resolve()
      }).catch((err) => console.log(err))
    }).then((resolve, reject) => {
      // 获取文章数据
      window.axios.get(`/wp-json/wp/v2/posts/${_params.id}`)
        .then((res) => {
          let _res = res.data
          oResult = Object.assign(oResult, {
            articleContent: _res,
            classify: _res.articleInfor.classify,
            tags: _res.articleInfor.tags,
            commentCount: _res.articleInfor.commentCount,
            content: _res.content.rendered.replace(/\sheight="\d+"/g, ''),
            bShowLoading: false
          })
          commit('getArticle', oResult)
          // 合并作者信息数据
          for (let key in state.authorOtherInfo) {
            state.authorOtherInfo[key].url = _res.articleInfor.other[key]
          }
        }).catch((err) => console.log(err))
    })
  }
}

const mutations = {
  getArticle (state, params) {
    state = Object.assign(state, params)
  }
}

export default {
  state,
  mutations,
  actions
}
