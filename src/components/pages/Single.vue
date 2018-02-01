<template>
  <section class="wrap main-wrap single clearfix" ref="content">
    <loading v-if="JSON.stringify(articleContent) == '{}'"></loading>
    <div class="fl content-wrap" v-else>
      <div class="box-wrap">
        <header class="content-header">
          <!-- <div class="breadcrumbs">当前位置： 首页 > 关于我 > 测试</div> -->
          <h2 class="title text-center">{{ articleContent.title.rendered }}</h2>
          <div class="article-info text-center">
            <a href="#">{{ articleContent.articleInfor.auther }}</a>
            <span class="text">发表于:</span>
            <time>{{ articleContent.date.replace('T', ' ') }}</time>
            <span class="text">分类:</span>
            <router-link
              v-for="(item, index) in classify"
              :key="item.key"
              :to="{ name: 'category', params: { id: item.cat_ID } }"
            >
              {{ item.name }}{{ index == classify.length - 1 ? '' : '、'  }}
            </router-link>
            <i class="iconfont icon-message"></i>
            <span class="text">{{ articleContent.articleInfor.commentCount }}</span>
            <i class="iconfont icon-hot"></i>
            <span class="text">{{ viewCount }}</span>
          </div>
        </header>
        <div class="content" v-html="articleContent.content.rendered" v-highlight></div>
      </div>
      <div class="box-wrap">
        <!-- 发表意见 -->
        <ul class="opinion">
          <li
            class="list"
            v-for="(item, key) in opinion"
            :key="item.key"
            :opinion-type="key"
            @click.prevent="addOpinion(key)"
          >
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
          <i class="iconfont icon-tag" v-if="tags.length"></i>
          <a href="#" v-for="(item, index) in tags" :key="item.key">{{ item.name }}{{ index == tags.length - 1 ? '' : '、' }}</a>
        </div>
      </div>
      <!-- 作者信息 -->
      <div class="auther-introduct box-wrap">
        <!-- 头像 -->
        <img :src="articleContent.articleInfor.other.autherPic.full" alt="" width="100">
        <div class="right">
          <!-- 昵称 -->
          <div class="header">
            <p class="inline-block name">
              作者简介：<i class="iconfont icon-about2"></i> {{ articleContent.articleInfor.auther }}
            </p>
            <p class="inline-block leave"></p>
          </div>
          <!-- 简介 -->
          <p class="auther-summary">{{ articleContent.articleInfor.other.autherTro }}</p>
          <!-- 社交信息 -->
          <div class="auther-link">
            <router-link :to="{ name: 'index' }">
              <svg class="iconfont-colour" aria-hidden="true">
                <use xlink:href="#icon-icon-test"></use>
              </svg>
            </router-link>
            <a :href="key == 'email' ? 'mailto:' + item.url : item.url" v-for="(item, key) in autherOtherInfo" :key="item.key">
              <svg class="iconfont-colour" aria-hidden="true">
                <use :xlink:href="item.icon"></use>
              </svg>
            </a>
          </div>
        </div>
      </div>
      <div class="box-wrap">
        <h2 class="comment-title">共 {{ articleContent.articleInfor.commentCount }} 条评论关于 “{{ articleContent.title.rendered }}”</h2>
        <comments></comments>
      </div>
    </div>
    <sidebar></sidebar>
  </section>
</template>
<script>
import sidebar from '@/components/common/Sidebar'
import comments from '@/components/common/Comments'
import loading from '@/components/common/Loading'
import store from '@/vuex/store'
import axios from 'axios'
export default {
  name: 'single',
  components: {
    sidebar,
    comments,
    loading
  },
  store,
  data: () => ({
    id: 0,
    viewCount: 0,
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
    },
    autherOtherInfo: {
      github: {
        icon: '#icon-GitHub'
      },
      qq: {
        icon: '#icon-qq1'
      },
      wechatNum: {
        icon: '#icon-weixin5'
      },
      sina: {
        icon: '#icon-xinlang1'
      },
      email: {
        icon: '#icon-youxiang'
      }
    }
  }),
  methods: {
    // 点赞提交
    addOpinion (key) {
      if (localStorage.getItem(`xm_link_${this.id}`)) {
        alert('您已经发表意见了！')
      } else {
        axios.post(`/wordpress-4.7.4/wp-json/xm-blog/v1/link/`, {
          params: {
            id: this.id,
            key
          }
        }).then((res) => {
          this.articleContent.articleInfor.xmLink[key] = res.data
          // 设置点赞状态
          localStorage.setItem(`xm_link_${this.id}`, true)
        }).catch((err) => console.log(err))
      }
    }
  },
  created () {
    this.id = this.$route.params.id
    // 更新文章阅读量
    axios.post(`/wordpress-4.7.4/wp-json/xm-blog/v1/view-count/`, {
      params: {
        id: this.id
      }
    }).then((res) => (this.viewCount = res.data)).catch((err) => console.log(err))

    // 获取文章数据
    axios.get(`/wordpress-4.7.4/wp-json/wp/v2/posts/${this.id}`)
      .then((res) => {
        this.articleContent = res.data
        this.classify = this.articleContent.articleInfor.classify
        this.tags = this.articleContent.articleInfor.tags
        // 合并作者信息数据
        for (let key in this.autherOtherInfo) {
          this.autherOtherInfo[key].url = this.articleContent.articleInfor.other[key]
        }
      }).catch((err) => console.log(err))
  }
}
</script>
<style lang="scss" scoped>
@import "../../assets/scss/_common.scss";
.main-wrap{
  // 正文
  .content-wrap{
    width: 850px;
    .title{
      font-size: 20px;
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

  // 作者介绍
  .auther-introduct{
    display: flex;
    justify-content: space-between;
    align-items: center;

    .right{
      width: 700px;
    }

    .header{
      margin-bottom: 5px;
      padding-bottom: 5px;
      border-bottom: border-1(#eee);
    }

    .name{
      font-size: 18px;
    }

    img{
      margin-right: 10px;
      border-radius: 5px;
    }
  }

  .auther-link{
    margin-top: 10px;
    a{
      display: inline-block;
      box-sizing: border-box;
      margin-right: 10px;
      padding: 2px 10px;
      border-radius: 3px;
      background: #f5f5f5;
      font-size: 12px;
    }
    .iconfont-colour{
      width: 20px;
      vertical-align: middle;
    }
  }

  .comment-title{
    margin-bottom: 10px;
    padding: 10px 0;
    border-radius: 5px;
    background: $colorMainGay;
    font-size: 18px;
    text-align: center;
  }
}
</style>
