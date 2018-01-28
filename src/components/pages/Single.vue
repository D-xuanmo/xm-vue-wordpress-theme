<template>
  <section class="wrap main-wrap single clearfix" ref="content">
    <div class="loading" v-if="JSON.stringify(articleContent) == '{}'">
      <img src="../../../static/images/loading.svg" alt="">
    </div>
    <div class="fl content-wrap" v-else>
      <header class="content-header">
        <div class="breadcrumbs">当前位置： 首页 > 关于我 > 测试</div>
        <h2 class="title text-center">{{ articleContent.title.rendered }}</h2>
        <div class="article-info text-center">
          <a href="#">{{ articleContent.articleInfor.auther }}</a>
          <span class="text">发表于:</span>
          <time>{{ articleContent.date.replace('T', ' ') }}</time>
          <span class="text">分类:</span>
          <a href="#" v-for="(item, index) in classify" :key="item.key">{{ item.name }}{{ index == classify.length - 1 ? '' : '、'  }}</a>
          <i class="iconfont icon-message"></i>
          <span class="text">{{ articleContent.articleInfor.commentCount }}</span>
          <i class="iconfont icon-hot"></i>
          <span class="text">{{ articleContent.articleInfor.viewCount }}</span>
        </div>
      </header>
      <div class="content" v-html="articleContent.content.rendered" v-highlight></div>
      <!-- 发表意见 -->
      <ul class="opinion">
        <li class="list" v-for="(item, key) in opinion" :key="item.key" :opinion-type="key" @click.prevent="addOpinion(key)">
          <a href="#">
            <span class="block">{{ articleContent.articleInfor.xmLink[key] }}人</span>
            <img :src="item.pic" alt="">
            <span class="block">{{ item.title }}</span>
          </a>
        </li>
      </ul>
      <!-- 分享 -->
      <div class="share text-center">
        <span class="text">分享到：</span>
        <a href="#">
          <svg class="iconfont-colour" aria-hidden="true">
            <use xlink:href="#icon-QQ"></use>
          </svg>
        </a>
        <a href="#">
          <svg class="iconfont-colour" aria-hidden="true">
            <use xlink:href="#icon-Qzone"></use>
          </svg>
        </a>
        <a href="#">
          <svg class="iconfont-colour" aria-hidden="true">
            <use xlink:href="#icon-weichat"></use>
          </svg>
        </a>
        <a href="#">
          <svg class="iconfont-colour" aria-hidden="true">
            <use xlink:href="#icon-xinlang"></use>
          </svg>
        </a>
      </div>
      <!-- 标签 -->
      <div class="tag-list text-center">
        <i class="iconfont icon-tag"></i>
        <a href="#" v-for="(item, index) in tags" :key="item.key">{{ item.name }}{{ index == tags.length - 1 ? '' : '、' }}</a>
      </div>
      <!-- 作者专栏 -->
      <div class="auther-introduct">

      </div>
    </div>
    <sidebar></sidebar>
  </section>
</template>
<script>
import sidebar from '@/components/common/Sidebar'
import store from '@/vuex/store'
import axios from 'axios'
export default {
  name: 'single',
  components: {
    sidebar
  },
  store,
  data: () => ({
    articleContent: {},
    classify: [],
    tags: [],
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
    }
  }),
  methods: {
    addOpinion (key) {
      axios.post(`/wordpress-4.7.4/wp-json/xm-blog/v1/link/`, {
        params: {
          id: this.$route.params.id,
          key
        }
      }).then((res) => {
        this.articleContent.articleInfor.xmLink[key] = res.data
      }).catch((err) => console.log(err))
    }
  },
  mounted () {
    axios.get(`/wordpress-4.7.4/wp-json/wp/v2/posts/${this.$route.params.id}`)
      .then((res) => {
        this.articleContent = res.data
        this.classify = this.articleContent.articleInfor.classify
        this.tags = this.articleContent.articleInfor.tags
      }).catch((err) => console.log(err))
  }
}
</script>
<style lang="scss" scoped>
@import "../../assets/scss/_common.scss";
.main-wrap{
  .loading{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);

    img{
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
  }

  // 正文
  .content-wrap{
    box-sizing: border-box;
    width: 850px;
    padding: 15px;
    border-radius: 5px;
    background: #fff;
    word-break: break-all;
  }

  // 文章基本信息
  .article-info{
    margin: 10px 0;
    padding-bottom: 5px;
    border-bottom: border-1($colorGay1);
    color: $colorGay3;
  }

  // 发表意见
  .opinion{
    display: flex;
    justify-content: space-between;
    width: 50%;
    margin: 20px auto;

    .list{
      text-align: center;

      span{
        &:first-of-type{
          font-size: 12px;
        }
      }

      img{
        width: 50px;
      }
    }
  }

  // 标签
  .tag-list{
    margin: 20px 0;

    .icon-tag{
      font-size: 18px;
    }
  }
}
</style>
