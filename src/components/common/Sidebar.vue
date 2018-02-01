<template>
  <div class="fr sidebar-wrap">
    <div class="sidebar-list" v-if="blogInfo.sidebarNoti">
      <h2 class="title">公告</h2>
      <div class="content">{{ blogInfo.sidebarNoti }}</div>
    </div>
    <div class="sidebar-list">
      <h2 class="title">浏览排行</h2>
      <ul class="list-wrap">
        <li class="list" v-for="item in sidebarHotArticle" :key="item.key">
          <a :href="item.link" class="clearfix">
            <span class="fl ellipsis"># {{ item.title }}</span>
            <span class="fr"><i class="iconfont icon-hot"></i> {{ item.viewCount }}</span>
          </a>
        </li>
      </ul>
    </div>
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
    ...mapState(['blogInfo'])
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
    }

    .ellipsis{
      width: 80%;
    }
  }
}
</style>
