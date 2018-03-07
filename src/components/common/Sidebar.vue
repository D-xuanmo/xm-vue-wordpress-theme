<template>
  <div class="fr sidebar-wrap hide-1200px">
    <div class="sidebar-list" v-show="blogInfo.setExtend.sidebar_notice">
      <h2 class="title"><i class="iconfont icon-notice1"></i> 公告</h2>
      <div class="list content">{{ blogInfo.setExtend.sidebar_notice }}</div>
    </div>
    <div class="sidebar-list" v-show="blogInfo.getSidebarCount === 'on'">
      <h2 class="title"><i class="iconfont icon-count"></i> 站点统计</h2>
      <ul class="sidebar-count">
        <li class="list">文章：{{ blogInfo.getAllCountArticle }}篇</li>
        <li class="list">页面：{{ blogInfo.getAllCountPage }}个</li>
        <li class="list">标签：{{ blogInfo.getAllCountTag }}个</li>
        <li class="list">分类：{{ blogInfo.getAllCountCat }}个</li>
      </ul>
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
  }
}
</script>
<style lang="scss" scoped>
@import "../../assets/scss/_common.scss";
.sidebar-wrap{
  width: 300px;

  .sidebar-list{
    margin-top: 15px;
    padding: 0 15px 15px;
    border-radius: 5px;
    background: #fff;
    color: $colorGay3;
    &:first-of-type{
      margin-top: 0;
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
        font-weight: lighter;
      }
    }

    .ellipsis{
      width: 80%;
    }
  }

  .sidebar-count{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;

    .list{
      width: 49%;
    }
  }
}
</style>
