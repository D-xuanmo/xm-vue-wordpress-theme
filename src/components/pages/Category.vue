<template lang="html">
  <loading v-if="bGlobalRequest"></loading>
  <section class="wrap main-wrap clearfix" v-else>
    <!-- 左边文章区域 -->
    <div class="fl content-wrap">
      <header class="main-header">{{ $route.query.type === undefined ? `当前频道：${$route.params.title}` : `关于“${$route.query.s}”的搜索结果` }}</header>
      <article class="" v-if="typeof articleList == 'string'">{{ articleList }}</article>
      <article class="article-list clearfix" v-else v-for="item in articleList" :key="item.key">
        <router-link
          :to="{ name: 'single', params: { id: item.id } }"
          class="thumbnail"
          v-if="item.articleInfor.thumbnail"
        >
          <img :src="item.articleInfor.thumbnail" width="200" alt="">
        </router-link>
        <div class="list-con">
          <h2 class="title">
            <router-link :to="{ name: 'single', params: { id: item.id } }">
              {{ item.title.rendered }}
            </router-link>
          </h2>
          <div class="info-wrap">
            <span><i class="iconfont icon-about"></i>{{ item.articleInfor.auther }}</span>
            <span><i class="iconfont icon-time1"></i>{{ item.date.replace('T', ' ') }}</span>
            <span><i class="iconfont icon-hot"></i>{{ item.articleInfor.viewCount }}</span>
            <span><i class="iconfont icon-message"></i>{{ item.articleInfor.commentCount }}</span>
            <span><i class="iconfont icon-zan"></i>{{ item.articleInfor.xmLink.very_good }}</span>
          </div>
          <p class="summary">{{ item.articleInfor.summary }} <router-link :to="{ name: 'single', params: { id: item.id } }" class="c-blue">阅读详情&gt;&gt;</router-link></p>
        </div>
      </article>
      <div class="more-btn">
        <img v-if="bMoreList" src="../../../static/images/bars.svg" alt="" width="40">
        <span v-else @click="bClick && getMoreList()">{{ sMoreBtnText }}</span>
      </div>
    </div>
    <!-- 侧边栏 -->
    <sidebar></sidebar>
  </section>
</template>

<script>
import sidebar from '@/components/common/Sidebar'
import loading from '@/components/common/Loading'
import store from '@/vuex/store'
import { mapState } from 'vuex'
export default {
  name: 'index',
  components: {
    sidebar,
    loading
  },
  store,
  created () {
    if (this.$route.query.type === undefined) {
      store.dispatch('getList', {
        key: 'categories',
        val: this.$route.params.id,
        currentNum: 1
      })
    } else {
      store.dispatch('getList', {
        key: 'search',
        val: this.$route.query.s,
        currentNum: 1
      })
    }
    store.commit('getList', {
      articleList: [],
      bGlobalRequest: true
    })
  },
  computed: {
    ...mapState({
      articleList: state => state.category.articleList,
      bGlobalRequest: state => state.category.bGlobalRequest,
      currentNum: state => state.category.currentNum,
      bMoreList: state => state.category.bMoreList,
      bClick: state => state.category.bClick,
      sMoreBtnText: state => state.category.sMoreBtnText,
      key: state => state.category.key
    })
  },
  methods: {
    // 加载更多
    getMoreList () {
      store.dispatch('getList', {
        key: this.key,
        val: this.$route.params.id,
        currentNum: ++store.state.category.currentNum
      })
      store.commit('getList', {
        bMoreList: true
      })
    }
  },
  watch: {
    $route () {
      if (this.$route.query.type === undefined) {
        store.dispatch('getList', {
          key: 'categories',
          val: this.$route.params.id,
          currentNum: 1
        })
      } else {
        store.dispatch('getList', {
          key: 'search',
          val: this.$route.query.s,
          currentNum: 1
        })
      }
      store.commit('getList', {
        articleList: [],
        bGlobalRequest: true,
        bClick: true,
        sMoreBtnText: '加载更多...'
      })
    }
  }
}
</script>

<style lang="scss" scoped>
@import "../../assets/scss/_common.scss";
.main-wrap{
  // 标题栏
  .main-header{
    height: 40px;
    padding-left: 15px;
    border-bottom: border-1($colorGay1);
    border-radius: 5px 5px 0 0;
    background: #fff;
    line-height: 40px;
  }

  // 加载更多按钮
  .more-btn{
    margin-top: 30px;
    text-align: center;
    color: #fff;

    span{
      display: inline-block;
      padding: 10px 30px;
      border-radius: 5px;
      background: $colorBlue;
      cursor: pointer;
    }
  }

  // 文章列表
  .content-wrap{
    width: 850px;
  }

  .article-list{
    position: relative;
    margin-top: 20px;
    padding: 15px;
    border-radius: 5px;
    background: #fff;
    &:first-of-type{
      margin-top: 0;
      border-radius: 0 0 5px 5px;
    }

    .thumbnail{
      float: left;
      margin-right: 10px;
    }

    .title{
      font-size: 16px;
    }

    .summary{
      line-height: 1.8;
      word-break: break-all;
    }

    .info-wrap{
      margin: 5px 0;
      color: $colorGay1;

      span{
        margin-right: 5px;
      }

      .iconfont{
        margin-right: 3px;
      }
    }
  }
}
</style>
