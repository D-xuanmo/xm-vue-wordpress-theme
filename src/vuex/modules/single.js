import axios from 'axios'
const state = {
  id: 0,
  viewCount: 0,
  articleContent: {},
  classify: [],
  tags: [],
  commentCount: 0,
  bShowLoading: true,
  showTips: {
    mark: false,
    msg: '',
    className: '',
    icon: 'icon-tips'
  },
  opinion: {
    very_good: {
      pic: require('../../assets/images/like_love.png'),
      title: 'Love'
    },
    good: {
      pic: require('../../assets/images/like_haha.png'),
      title: 'Haha'
    },
    commonly: {
      pic: require('../../assets/images/like_wow.png'),
      title: 'Wow'
    },
    bad: {
      pic: require('../../assets/images/like_sad.png'),
      title: 'Sad'
    },
    very_bad: {
      pic: require('../../assets/images/link_angry.png'),
      title: 'Angry'
    }
  },
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
      axios.post(`/wp-json/xm-blog/v1/view-count/`, {
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
      axios.get(`/wp-json/wp/v2/posts/${_params.id}`)
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
  },
  // 点赞
  addOpinion (state, key) {
    if (localStorage.getItem(`xm_link_${state.id}`)) {
      state.showTips = {
        mark: true,
        msg: '您已经发表过意见了！',
        className: 'alert-warning',
        icon: 'icon-tips'
      }
      setTimeout(() => {
        state.showTips = {
          mark: false,
          msg: '您已经发表过意见了！',
          className: 'alert-warning',
          icon: 'icon-tips'
        }
      }, 2000)
    } else {
      axios.post('/wp-json/xm-blog/v1/link/', {
        params: {
          id: state.id,
          key
        }
      }).then((res) => {
        state.articleContent.articleInfor.xmLink[key] = res.data
        // 设置点赞状态
        localStorage.setItem(`xm_link_${state.id}`, true)
      }).catch((err) => console.log(err))
    }
  }
}

export default {
  state,
  mutations,
  actions
}
