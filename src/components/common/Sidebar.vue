<template>
  <div class="fr sidebar-wrap hide-1200px">
    <div class="sidebar-list" v-if="blogInfo.setExtend.sidebar_notice" :class="{ float: bFloat }">
      <h2 class="title"><i class="iconfont icon-notice1"></i>公告</h2>
      <div class="list content">{{ blogInfo.setExtend.sidebar_notice }}</div>
    </div>
    <div class="sidebar-list">
      <h2 class="title"><i class="iconfont icon-hot1"></i>最新评论</h2>
      <ul class="list-wrap new-comment">
        <li class="list clearfix" v-for="item in blogInfo.newComment" :key="item.key">
          <div class="fl" v-html="item.avatar"></div>
          <router-link :to="{ name: 'single', params: { id: item.comment_post_ID } }" :title="item.title" v-html="item.title"></router-link>
          <p class="link-text f-s-12px">{{ item.countCom }}人发表意见，{{ item.link }}人喜欢</p>
        </li>
      </ul>
    </div>
    <div class="sidebar-list" v-show="blogInfo.getSidebarCount === 'on'">
      <h2 class="title"><i class="iconfont icon-count"></i>站点统计</h2>
      <ul class="sidebar-count">
        <li class="list">标签：{{ blogInfo.getAllCountTag }}个</li>
        <li class="list">文章：{{ blogInfo.getAllCountArticle }}篇</li>
        <li class="list">页面：{{ blogInfo.getAllCountPage }}个</li>
        <li class="list">评论：{{ blogInfo.getAllCountComment }}条</li>
        <li class="list">分类：{{ blogInfo.getAllCountCat }}个</li>
        <li class="list">最后更新：{{ blogInfo.lastUpDate }}</li>
      </ul>
    </div>
    <div class="sidebar-list link">
      <h2 class="title"><i class="iconfont icon-link2"></i>友情链接</h2>
      <div class="content sidebar-count" v-html="blogInfo.link"></div>
    </div>
    <!-- <div class="sidebar-list">
      <h2 class="title">浏览排行</h2>
      <ul class="list-wrap">
        <li class="list" v-for="item in sidebarHotArticle" :key="item.key">
          <a :href="item.link" class="clearfix">
            <span class="fl ellipsis"># {{ item.title }}</span>
            <span class="fr"><i class="iconfont icon-hot"></i> {{ item.viewCount }}</span>
          </a>
        </li>
      </ul>
    </div> -->
  </div>
</template>
<script>
import store from '@/vuex/store'
import { mapState } from 'vuex'
export default {
  name: 'sidebar',
  store,
  data: () => ({
    bFloat: false,
    sidebarHotArticle: [
      {
        title: 'before伪类与阿里图标做的图标库before伪类与阿里图标做的图标库',
        link: 'https://www.xuanmo.xin',
        viewCount: 10
      },
      {
        title: 'before伪类与阿里图标做的图标库before伪类与阿里图标做的图标库',
        link: 'https://www.xuanmo.xin',
        viewCount: 10
      },
      {
        title: 'before伪类与阿里图标做的图标库before伪类与阿里图标做的图标库',
        link: 'https://www.xuanmo.xin',
        viewCount: 10
      },
      {
        title: 'before伪类与阿里图标做的图标库before伪类与阿里图标做的图标库',
        link: 'https://www.xuanmo.xin',
        viewCount: 10
      }
    ]
  }),
  computed: {
    ...mapState({
      blogInfo: state => state.info.blogInfo
    })
  },
  mounted () {
    let that = this
    window.addEventListener('scroll', function () {
      this.scrollY > 1500 ? that.bFloat = true : that.bFloat = false
    }, false)
  }
}
</script>
<style lang="scss" scoped>
@import "../../assets/scss/_common.scss";
.sidebar-wrap{
  width: 300px;

  .sidebar-list{
    box-sizing: border-box;
    margin-top: 15px;
    padding: 0 15px 15px;
    border-radius: 5px;
    background: #fff;
    color: $colorGay3;
    &:first-of-type{
      margin-top: 0;
    }

    &.float{
      position: fixed;
      top: 80px;
      width: 300px;
    }

    .list{
      margin-top: 10px;
    }

    .title{
      margin-bottom: 5px;
      border-bottom: border-1($colorGay1);
      font-size: 16px;
      line-height: 40px;

      .iconfont{
        margin-right: 3px;
        font-size: 16px;
        font-weight: lighter;
      }
    }

    .ellipsis{
      width: 80%;
    }
  }

  // 统计
  .sidebar-count{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;

    .list{
      &:nth-of-type(odd){
        width: 40%;
      }
      &:nth-of-type(even){
        width: 58%;
      }
    }
  }

  // 评论列表
  .new-comment{
    a{
      display: block;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
    .link-text{
      margin-top: 5px;
      color: $colorTextMain;
    }
  }
}
</style>
