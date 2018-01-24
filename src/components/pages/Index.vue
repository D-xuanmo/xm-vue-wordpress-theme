<template lang="html">
  <div class="index">
    <my-header></my-header>
    <banner></banner>
    <my-nav></my-nav>
    <section class="wrap main-wrap clearfix">
      <!-- 左边文章区域 -->
      <div class="fl content-wrap">
        <header class="main-header">最新文章</header>
        <article class="article-list" v-for="item in articleList" :key="item.key">
          <a :href="item.link" class="thumbnail">
            <img :src="item.thumbnail" width="200" alt="">
          </a>
          <div class="list-con">
            <h2 class="title">
              <a :href="item.link">{{ item.title }}</a>
            </h2>
            <div class="info-wrap">
              <span><i class="iconfont icon-time1"></i>{{ item.time }}</span>
              <span><i class="iconfont icon-hot"></i>{{ item.viewCount }}</span>
              <span><i class="iconfont icon-message"></i>{{ item.commentCount }}</span>
              <span><i class="iconfont icon-zan"></i>{{ item.zan }}</span>
            </div>
            <p class="summary">{{ item.summary }}</p>
          </div>
        </article>
      </div>
      <!-- 侧边栏 -->
      <div class="fr sidebar"></div>
    </section>
  </div>
</template>

<script>
import myHeader from '@/components/common/Header'
import banner from '@/components/common/banner'
import myNav from '@/components/common/Nav'
export default {
  name: 'index',
  components: {
    myHeader,
    banner,
    myNav
  },
  data: () => ({
    articleList: [
      {
        title: 'meta标签整理',
        thumbnail: require('../../assets/images/img_1.jpg'),
        link: 'https://www.xuanmo.xin',
        summary: '博客上线到现在，已经差不多2年了，这款主题使用也一年多了，期间也改了不少的功能，还是有朋友使用我的主题，此处介绍一下这版主题的一些设置说明，主题不支持低版本浏览器兼容，欢迎在使用过程中把遇见的问题反馈给我，觉得用的还可以欢迎star。',
        time: '2018-09-09',
        viewCount: 99,
        commentCount: 8,
        zan: 55
      },
      {
        title: 'meta标签整理',
        thumbnail: require('../../assets/images/img_1.jpg'),
        link: 'https://www.xuanmo.xin',
        summary: '博客上线到现在，已经差不多2年了，这款主题使用也一年多了，期间也改了不少的功能，还是有朋友使用我的主题，此处介绍一下这版主题的一些设置说明，主题不支持低版本浏览器兼容，欢迎在使用过程中把遇见的问题反馈给我，觉得用的还可以欢迎star。',
        time: '2018-09-09',
        viewCount: 99,
        commentCount: 8,
        zan: 55
      },
      {
        title: 'meta标签整理',
        thumbnail: require('../../assets/images/img_1.jpg'),
        link: 'https://www.xuanmo.xin',
        summary: '博客上线到现在，已经差不多2年了，这款主题使用也一年多了，期间也改了不少的功能，还是有朋友使用我的主题，此处介绍一下这版主题的一些设置说明，主题不支持低版本浏览器兼容，欢迎在使用过程中把遇见的问题反馈给我，觉得用的还可以欢迎star。',
        time: '2018-09-09',
        viewCount: 99,
        commentCount: 8,
        zan: 55
      }
    ]
  })
}
</script>

<style lang="scss" scoped>
@import "../../assets/scss/_common.scss";
.main-wrap{
  // 标题栏
  .main-header{
    height: 40px;
    padding-left: 15px;
    border-radius: 5px;
    background: #fff;
    line-height: 40px;
  }

  // 文章列表
  .content-wrap{
    width: 800px;
    margin: 50px 0 0;
  }

  .article-list{
    position: relative;
    margin-top: 20px;
    padding: 15px;
    border-radius: 5px;
    background: #fff;

    .thumbnail{
      position: absolute;
      top: 50%;
      left: 15px;
      transform: translateY(-50%);
    }

    .list-con{
      margin-left: 210px;
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
