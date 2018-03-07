<template>
  <section class="wrap main-wrap single clearfix" ref="content">
    <loading v-if="singleRes.bShowLoading"></loading>
    <div class="fl content-wrap width-full" v-else>
      <div class="box-wrap">
        <header class="content-header">
          <!-- <div class="breadcrumbs">当前位置： 首页 > 关于我 > 测试</div> -->
          <h2 class="title text-center" v-title="singleRes.articleContent.title.rendered">{{ singleRes.articleContent.title.rendered }}</h2>
          <div class="article-info text-center">
            <a href="#">{{ articleInfor.auther }}</a>
            <span class="text">发表于:</span>
            <time>{{ singleRes.articleContent.date.replace('T', ' ') }}</time>
            <span class="text">分类:</span>
            <router-link
              v-for="(item, index) in singleRes.classify"
              :key="item.key"
              :to="{ name: 'category', params: { id: item.cat_ID, title: item.cat_name } }"
            >
              {{ item.name }}{{ index == singleRes.classify.length - 1 ? '' : '、'  }}
            </router-link>
            <i class="iconfont icon-message"></i>
            <span class="text">{{ articleInfor.commentCount }}</span>
            <i class="iconfont icon-hot"></i>
            <span class="text">{{ singleRes.viewCount }}</span>
          </div>
        </header>
        <div class="content" v-html="singleRes.content" v-highlight></div>
      </div>
      <div class="box-wrap">
        <!-- 发表意见 -->
        <ul class="opinion">
          <li
            class="list"
            v-for="(item, key) in singleRes.opinion"
            :key="item.key"
            :opinion-type="key"
            @click.prevent="addOpinion(key)"
          >
            <a href="#">
              <span class="block">{{ articleInfor.xmLink[key] }}人</span>
              <img :src="item.pic" alt="">
              <span class="block">{{ item.title }}</span>
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
            上一篇：<span v-if="articleInfor.prevLink === ''">已是最新文章！</span>
            <router-link v-else :to="{ name: 'single', params: { id: articleInfor.prevLink.ID } }">{{ articleInfor.prevLink.post_title }}</router-link>
          </div>
          <div class="next-wrap">
            下一篇：<span v-if="articleInfor.nextLink === ''">已是最后一篇！</span>
            <router-link v-else :to="{ name: 'single', params: { id: articleInfor.nextLink.ID } }">{{ articleInfor.nextLink.post_title }}</router-link>
          </div>
        </div>
      </div>
      <!-- 作者信息 -->
      <div class="auther-introduct box-wrap">
        <!-- 头像 -->
        <img :src="articleInfor.other.autherPic.full" alt="" width="100">
        <div class="right">
          <!-- 昵称 -->
          <div class="header">
            <p class="inline-block name">
              作者简介：<i class="iconfont icon-about2"></i><span class="f-s-14px">{{ articleInfor.auther }}</span>
            </p>
            <p class="inline-block leave"></p>
          </div>
          <!-- 简介 -->
          <p class="auther-summary">{{ articleInfor.other.autherTro }}</p>
          <!-- 社交信息 -->
          <div class="auther-link">
            <router-link :to="{ name: 'index' }">
              <svg class="iconfont-colour" aria-hidden="true">
                <use xlink:href="#icon-icon-test"></use>
              </svg>
            </router-link>
            <a :href="key == 'email' ? 'mailto:' + item.url : item.url" v-for="(item, key) in singleRes.autherOtherInfo" :key="item.key">
              <svg class="iconfont-colour" aria-hidden="true">
                <use :xlink:href="item.icon"></use>
              </svg>
            </a>
          </div>
        </div>
      </div>
      <div class="box-wrap">
        <h2 class="comment-title">共 {{ singleRes.commentCount }} 条评论关于 “{{ singleRes.articleContent.title.rendered }}”</h2>
        <comments :commentCount="singleRes.commentCount"></comments>
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
import { mapState, mapMutations } from 'vuex'
export default {
  name: 'single',
  data: () => ({
    articleHref: window.location.href
  }),
  components: {
    sidebar,
    comments,
    loading
  },
  store,
  methods: {
    ...mapMutations(['addOpinion'])
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

  .relative-link-wrap{
    div:last-of-type{
      margin-top: 10px;
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
@media screen and (max-width: 767px) {
  .main-wrap{
    .opinion{
      width: 100%;
    }
    .auther-link{
      a{
        margin-bottom: 10px;
      }
    }
  }
}
</style>
