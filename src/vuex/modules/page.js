import axios from 'axios'
const state = {
  id: 0,
  commentCount: 0,
  articleContent: {},
  bShowLoading: true
}

const actions = {
  getPage ({ commit, state }, _params) {
    let oResult = {}
    axios.get(`/wp-json/wp/v2/pages/${_params.id}`)
      .then((res) => {
        let _res = res.data
        oResult = Object.assign(oResult, {
          articleContent: _res,
          commentCount: _res.pageInfor.commentCount,
          content: _res.content.rendered.replace(/\sheight="\d+"/g, ''),
          bShowLoading: false
        })
        commit('getPage', oResult)
      }).catch((err) => console.log(err))
  }
}

const mutations = {
  getPage (state, params) {
    state = Object.assign(state, params)
  }
}

export default {
  state,
  mutations,
  actions
}
