<template>
  <section class="wrap main-wrap single" ref="content">
    <loading v-if="singleRes.bShowLoading"></loading>
    <div class="content-wrap" v-else>
      <span class="hide" v-title="singleRes.articleContent.title.rendered"></span>
      <div class="box-wrap">
        <div class="content" v-html="singleRes.content" v-highlight></div>
      </div>
      <div class="box-wrap">
        <h2 class="comment-title" v-html="`共 ${singleRes.commentCount} 条评论关于 “${singleRes.articleContent.title.rendered}”`"></h2>
        <comments :commentCount="singleRes.commentCount"></comments>
      </div>
    </div>
  </section>
</template>
<script>
import sidebar from '@/components/common/Sidebar'
import comments from '@/components/common/Comments'
import loading from '@/components/common/Loading'
import store from '@/vuex/store'
import { mapState } from 'vuex'
export default {
  name: 'page',
  components: {
    sidebar,
    comments,
    loading
  },
  store,
  computed: {
    ...mapState({
      singleRes: state => state.page
    })
  },
  created () {
    store.dispatch('getPage', {
      id: this.$route.params.id
    })
    store.commit('getPage', {
      bShowLoading: true
    })
  },
  watch: {
    $route () {
      store.dispatch('getPage', {
        id: this.$route.params.id
      })
      store.commit('getPage', {
        bShowLoading: true
      })
    }
  }
}
</script>
<style lang="scss" scoped>
.main-wrap{
  // 正文
  .content-wrap{
    .title{
      font-size: 20px;
    }

    .content{
      line-height: 2;
    }
  }

  .box-wrap{
    box-sizing: border-box;
    margin-bottom: 20px;
    padding: 15px;
    border-radius: 5px;
    background: #fff;
    word-break: break-all;
  }

  .comment-title{
    margin-bottom: 10px;
    padding: 10px 0;
    border-radius: 5px;
    background: $main-gay-color;
    font-size: 18px;
    text-align: center;
  }
}
</style>
