import axios from 'axios'
const state = {
  articleList: [],
  currentNum: 1,
  bGlobalRequest: true,
  bMoreList: true,
  bClick: true,
  sMoreBtnText: '加载更多...',
  key: 'category'
}

const actions = {
  getList ({ commit, state }, _params) {
    let oResult = {}
    let url = _params.key === '' ? `/wp-json/wp/v2/posts?page=${_params.currentNum}&per_page=5&_embed=true` : `/wp-json/wp/v2/posts?${_params.key}=${_params.val}&page=${_params.currentNum}&per_page=5&_embed=true`
    // 获取列表文章
    axios.get(url)
      .then((res) => {
        let _res = {}
        oResult = {
          articleList: [...state.articleList, ...res.data],
          currentNum: _params.currentNum,
          key: _params.key,
          bGlobalRequest: false,
          bMoreList: false
        }
        if (res.data.length === 0 && state.articleList.length === 0) {
          _res = {
            bClick: false,
            sMoreBtnText: '我是有底线的^_^',
            articleList: '暂无数据！'
          }
          oResult = {...oResult, ..._res}
        } else if (res.data.length < 5) {
          _res = {
            bClick: false,
            sMoreBtnText: '我是有底线的^_^'
          }
          oResult = {...oResult, ..._res}
          console.log(res.data)
        }
        commit('getList', oResult)
      })
      .catch(err => {
        let _res = {}
        if (err.response.data.code === 'rest_post_invalid_page_number') {
          _res = {
            bClick: false,
            bMoreList: false,
            sMoreBtnText: '我是有底线的^_^'
          }
        }
        oResult = {...oResult, ..._res}
        commit('getList', oResult)
      })
  }
}

const mutations = {
  getList (state, params) {
    state = Object.assign(state, params)
  }
}

export default {
  state,
  mutations,
  actions
}
