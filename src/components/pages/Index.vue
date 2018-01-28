<template lang="html">
  <section class="wrap main-wrap clearfix">
    <!-- 左边文章区域 -->
    <div class="fl content-wrap">
      <header class="main-header">最新文章</header>
      <article class="article-list clearfix" v-for="item in articleList" :key="item.key">
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
          <p class="summary">{{ item.articleInfor.summary }}</p>
        </div>
      </article>
    </div>
    <!-- 侧边栏 -->
    <sidebar></sidebar>
  </section>
</template>

<script>
import sidebar from '@/components/common/Sidebar'
import axios from 'axios'
export default {
  name: 'index',
  components: {
    sidebar
  },
  data: () => ({
    articleList: []
  }),
  mounted () {
    axios.get('/wordpress-4.7.4/wp-json/wp/v2/posts', {
      params: {
        page: 1,
        per_page: 3,
        _embed: true
      }
    }).then((res) => {
      this.articleList = res.data
    }).catch((err) => console.log(err))
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

    .summary{
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
