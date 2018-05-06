<template>
  <section class="wrap main-wrap single clearfix" ref="content">
    <loading v-if="singleRes.bShowLoading"></loading>
    <div class="fl content-wrap width-full" v-else>
      <div class="box-wrap">
        <header class="content-header">
          <!-- <div class="breadcrumbs">当前位置： 首页 > 关于我 > 测试</div> -->
          <h2 class="title text-center" v-title="singleRes.articleContent.title.rendered" v-html="singleRes.articleContent.title.rendered"></h2>
          <div class="article-info text-center">
            <a href="#">{{ articleInfor.author }}</a>
            <span class="text">发表于:</span>
            <time>{{ singleRes.articleContent.date.replace('T', ' ') }}</time>
            <span class="text">分类:</span>
            <router-link
              v-for="(item, index) in singleRes.classify"
              :key="item.key"
              :to="{ name: 'category', params: { id: item.cat_ID, title: item.cat_name } }"
              v-html="`${item.name}${index == singleRes.classify.length - 1 ? '' : '、'}`"
            ></router-link>
            <span class="text"><i class="iconfont icon-message"></i>{{ articleInfor.commentCount }}</span>
            <span class="text"><i class="iconfont icon-hot"></i>{{ singleRes.viewCount }}</span>
            <a v-if="edit" :href="`/wp-admin/post.php?post=${$route.params.id}&action=edit`" target="_blank">编辑</a>
          </div>
        </header>
        <div class="content" v-html="singleRes.content" v-highlight></div>
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
              <span class="block text"><i v-if="item.showLoading" class="iconfont icon-loading"></i>{{ articleInfor.xmLink[key] }}人</span>
              <img :src="item.pic" alt="">
              <span class="block text">{{ item.title }}</span>
            </a>
          </li>
        </ul>
        <!-- 分享 -->
        <div class="share text-center">
          <span class="text">分享到：</span>
          <a :href="`http://connect.qq.com/widget/shareqq/index.html?url=${articleHref}&title=${singleRes.articleContent.title.rendered}&summary=`" target="_blank">
            <svg class="iconfont-colour" aria-hidden="true">
              <use xlink:href="#icon-QQ"></use>
            </svg>
          </a>
          <a :href="`http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=${articleHref}&title=${singleRes.articleContent.title.rendered}`" target="_blank">
            <svg class="iconfont-colour" aria-hidden="true">
              <use xlink:href="#icon-Qzone"></use>
            </svg>
          </a>
          <a href="#">
            <svg class="iconfont-colour" aria-hidden="true">
              <use xlink:href="#icon-weichat"></use>
            </svg>
          </a>
          <a :href="`http://service.weibo.com/share/share.php?url=${articleHref}%230-tsina-1-21107-397232819ff9a47a7b7e80a40613cfe1&title=${singleRes.articleContent.title.rendered}&appkey=1343713053&searchPic=true#_loginLayer_1473259217614`" target="_blank">
            <svg class="iconfont-colour" aria-hidden="true">
              <use xlink:href="#icon-xinlang"></use>
            </svg>
          </a>
        </div>
        <!-- 标签 -->
        <div class="tag-list text-center">
          <i class="iconfont icon-tag" v-if="singleRes.tags.length"></i>
          <!-- <router-link :to="{ name: 'category', params: { id: item.term_id, title: item.name } }" v-for="(item, index) in tags" :key="item.key">{{ item.name }}{{ index == tags.length - 1 ? '' : '、' }}</router-link> -->
          <a href="#" v-for="(item, index) in singleRes.tags" :key="item.key">{{ item.name }}{{ index == singleRes.tags.length - 1 ? '' : '、' }}</a>
        </div>
        <div class="relative-link-wrap">
          <div class="prev-wrap">
            上一篇：<span v-if="articleInfor.nextLink === ''">已是最新文章！</span>
            <router-link v-else :to="{ name: 'single', params: { id: articleInfor.nextLink.ID } }">{{ articleInfor.nextLink.post_title }}</router-link>
          </div>
          <div class="next-wrap">
            下一篇：<span v-if="articleInfor.prevLink === ''">已是最后一篇！</span>
            <router-link v-else :to="{ name: 'single', params: { id: articleInfor.prevLink.ID } }">{{ articleInfor.prevLink.post_title }}</router-link>
          </div>
        </div>
      </div>
      <!-- 作者信息 -->
      <div class="author-introduct box-wrap">
        <!-- 头像 -->
        <img :src="articleInfor.other.authorPic.full" alt="" width="100">
        <div class="right">
          <!-- 昵称 -->
          <div class="header">
            <p class="inline-block name">
              作者简介：<i class="iconfont icon-about-f"></i><span class="f-s-14px">{{ articleInfor.author }}</span>
            </p>
            <p class="inline-block leave"></p>
          </div>
          <!-- 简介 -->
          <p class="author-summary">{{ articleInfor.other.authorTro }}</p>
          <!-- 社交信息 -->
          <ul class="author-link">
            <li class="list">
              <router-link :to="{ name: 'index' }">
                <svg class="iconfont-colour" aria-hidden="true">
                  <use xlink:href="#icon-icon-test"></use>
                </svg>
              </router-link>
            </li>
            <li class="list" v-for="(item, key) in singleRes.authorOtherInfo" :key="item.key" v-if="key === 'wechatNum'" @click="showWechatNum(item.url)">
              <a href="javascript:;">
                <svg class="iconfont-colour" aria-hidden="true">
                  <use :xlink:href="item.icon"></use>
                </svg>
              </a>
            </li>
            <li class="list" v-else>
              <a :href="key == 'email' ? `mailto:${item.url}` : item.url">
                <svg class="iconfont-colour" aria-hidden="true">
                  <use :xlink:href="item.icon"></use>
                </svg>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="box-wrap">
        <h2 class="comment-title" v-html="`共 ${singleRes.commentCount} 条评论关于 “${singleRes.articleContent.title.rendered}”`"></h2>
        <comments :commentCount="singleRes.commentCount"></comments>
      </div>
    </div>
    <sidebar></sidebar>
  </section>
</template>
<script>
import sidebar from '@/components/Sidebar'
import comments from '@/components/comment/Comments'
import loading from '@/components/loading/Loading'
import store from '@/vuex/store'
import { mapState } from 'vuex'
export default {
  name: 'single',
  data: () => ({
    edit: false,
    articleHref: window.location.href,
    opinion: {
      very_good: {
        pic: require('./images/like_love.png'),
        title: 'Love',
        showLoading: false
      },
      good: {
        pic: require('./images/like_haha.png'),
        title: 'Haha',
        showLoading: false
      },
      commonly: {
        pic: require('./images/like_wow.png'),
        title: 'Wow',
        showLoading: false
      },
      bad: {
        pic: require('./images/like_sad.png'),
        title: 'Sad',
        showLoading: false
      },
      very_bad: {
        pic: require('./images/link_angry.png'),
        title: 'Angry',
        showLoading: false
      }
    }
  }),
  components: {
    sidebar,
    comments,
    loading
  },
  store,
  methods: {
    // 点赞
    addOpinion (key) {
      if (localStorage.getItem(`xm_link_${this.$route.params.id}`)) {
        this.$message({
          title: '您已经发表过意见了！',
          type: 'warning'
        })
      } else {
        this.opinion[key].showLoading = true
        window.axios.post('/wp-json/xm-blog/v1/link/', {
          params: {
            id: this.$route.params.id,
            key
          }
        }).then((res) => {
          this.opinion[key].showLoading = false
          this.articleInfor.xmLink[key] = res.data
          // 设置点赞状态
          localStorage.setItem(`xm_link_${this.$route.params.id}`, true)
        }).catch((err) => console.log(err))
      }
    },

    // 显示微信号码
    showWechatNum (num) {
      this.$message({
        title: `微信号：${num}`,
        showClose: true,
        showImg: true,
        center: true,
        wrapCenter: true,
        width: 280,
        imgUrl: this.articleInfor.other.wechatPic
      })
    }
  },
  computed: {
    ...mapState({
      singleRes: state => state.single,
      articleInfor: state => state.single.articleContent.articleInfor
    })
  },
  created () {
    store.dispatch('getArticle', {
      id: this.$route.params.id
    })
    store.commit('getArticle', {
      bShowLoading: true
    })
  },
  watch: {
    $route () {
      store.dispatch('getArticle', {
        id: this.$route.params.id
      })
      store.commit('getArticle', {
        bShowLoading: true
      })
    }
  },
  mounted () {
    if (document.querySelector('#wpadminbar')) this.edit = true
  }
}
</script>
<style lang="scss" scoped>
.main-wrap{
  // 正文
  .content-wrap{
    width: 850px;
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

      a{
        display: block;
      }

      .text{
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

  .relative-link-wrap{
    div:last-of-type{
      margin-top: 10px;
    }
  }

  // 作者介绍
  .author-introduct{
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

  .author-link{
    display: flex;
    flex-wrap: wrap;
    margin-top: 10px;

    .list{
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
    background: $main-gay-color;
    font-size: 18px;
    text-align: center;
  }
}
@media screen and (max-width: 767px) {
  .main-wrap{
    .opinion{
      width: 100%;
      .list{
        img{
          width: 35px;
        }
      }
    }
    .author-link{
      .list{
        margin-bottom: 10px;
      }
    }
  }
}
@media screen and (max-width: 360px) {
  .main-wrap{
    .author-introduct{
      img{
        display: none;
      }
    }
  }
}
</style>
<style lang="scss">
.single{
  .content{
    img{
      max-width: 100%;
      margin: 10px 0;
      box-shadow: 0 0 10px #d2d2d2;
    }
  }
}
</style>
