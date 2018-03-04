<template>
  <header class="header-wrap">
    <div class="wrap clearfix">
      <div class="fl logo">
        <h1><router-link :to="{ name: 'index' }">{{ blogInfo.blogName }}</router-link></h1>
      </div>
      <ul class="fl other-link">
        <li class="list" v-for="item in topNavList" :key="item.key">
          <router-link :to="{ name: 'page', params: { id: item.object_id }}"><i :class="`iconfont ${item.attr_title}`"></i>{{ item.title }}</router-link>
        </li>
      </ul>
      <div class="fl search-wrap">
        <input type="text" name="" v-model="searchRes" placeholder="搜索..." @keyup.prevent.enter="search()">
      </div>
      <div class="fr contact-wrap">
        <div class="contact-btn"><i class="iconfont icon-github1"></i> 联系我</div>
        <!-- <a href="#"><i class="iconfont icon-search"></i></a>
        <a href="#"><i class="iconfont icon-github1"></i></a>
        <a href="#"><i class="iconfont icon-qq"></i></a>
        <a href="#"><i class="iconfont icon-wechat"></i></a>
        <a href="#"><i class="iconfont icon-sina"></i></a>
        <a href="#"><i class="iconfont icon-email2"></i></a> -->
      </div>
    </div>

    <!-- banner -->
    <div class="banner-wrap">
      <img :src="blogInfo.setExtend.big_banner" alt="banner">
    </div>

    <!-- 导航容器 -->
    <div class="nav-wrap">
      <div class="wrap">
        <!-- 头像 -->
        <div class="head-portrait">
          <img :src="blogInfo.adminPic.full" width="150" alt="">
        </div>
        <!-- 导航 -->
        <nav class="nav-list-wrap">
          <ul class="list-wrap">
            <li class="nav-list">
              <router-link :to="{ name: 'index' }">首页</router-link>
            </li>
            <li class="nav-list" v-for="item in navList" :key="item.key">
              <router-link v-if="item.type === 'page'" :to="{ name: 'page', params: { id: item.ID } }">{{ item.title }}</router-link>
              <router-link v-else :to="{ name: 'category', params: { id: item.ID, title: item.title } }">{{ item.title }}</router-link>
              <ul class="sub-nav-wrap" v-if="item.children.length !== 0">
                <li class="sub-nav-list" v-for="subNav in item.children" :key="subNav.key">
                  <router-link v-if="subNav.type === 'page'" :to="{ name: 'page', params: { id: subNav.ID } }">{{ subNav.title }}</router-link>
                  <router-link v-else :to="{ name: 'category', params: { id: subNav.ID, title: subNav.title } }">{{ subNav.title }}</router-link>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </header>
</template>

<script>
import store from '@/vuex/store'
import { mapState } from 'vuex'
export default {
  name: 'myHeader',
  store,
  data: () => ({
    searchRes: ''
  }),
  created () {
  },
  methods: {
    // 搜索
    search () {
      this.$router.push({
        name: 'category',
        query: {
          s: this.searchRes,
          type: 'search'
        }
      })
      this.searchRes = ''
    }
  },
  computed: {
    ...mapState({
      blogInfo: state => state.info.blogInfo,
      navList: state => state.info.navList,
      topNavList: state => state.info.topNavList
    })
  }
}
</script>

<style lang="scss">
@import "../../assets/scss/_common.scss";
.router-link-exact-active{
  color: $colorBlue;
}

.header-wrap{
  background: #fff;

  // logo
  .logo{
    margin-right: 20px;
    line-height: 60px;

    h1{
      font-size: 20px;
    }
  }

  // 菜单
  .other-link{
    width: 350px;
    height: 60px;

    .list{
      float: left;
      margin-left: 20px;
      &:first-of-type{
        margin-left: 0;
      }

      > a{
        line-height: 60px;
      }

      .iconfont{
        margin-right: 2px;
        vertical-align: bottom;
        font-size: 18px;
      }
    }
  }

  // 搜索框
  .search-wrap{
    margin-top: 10px;

    input[type="text"]{
      width: 300px;
      height: 40px;
      border-radius: 30px;
      background: $colorGay;
      text-align: center;
      color: $colorGay1;
    }
  }

  // 联系信息
  .contact-wrap{
    height: 60px;

    .contact-btn{
      height: 40px;
      margin-top: 10px;
      padding: 0 10px;
      border-radius: 30px;
      box-shadow: 0 2px 5px 0 rgba(0,0,0,.12);
      background: $colorGay1;
      line-height: 40px;
      color: #fff;
      cursor: pointer;
    }
  }

  // banner
  .banner-wrap{
    img{
      width: 100%;
    }
  }
}

// 导航
.nav-wrap{
  margin-bottom: 20px;
  box-shadow: 0 5px 10px $colorMainBoxShadow;
  background: #fff;

  .wrap{
    position: relative;
    height: 60px;
  }

  .head-portrait{
    position: absolute;
    bottom: -20px;
    left: 0;

    img{
      border: 5px solid #fff;
      border-radius: 50%;
    }
  }

  // 导航
  .nav-list-wrap{
    width: 700px;
    margin-left: 200px;

    .list-wrap{
      display: flex;
      justify-content: space-between;
      height: 60px;
    }

    .nav-list{
      position: relative;

      &:hover{
        .sub-nav-wrap{
          display: block;
        }
      }

      > a{
        line-height: 60px;
      }
    }

    .sub-nav-wrap{
      display: none;
      position: absolute;
      z-index: 99999;
      top: 60px;
      left: 50%;
      width: 200px;
      background: #fff;
      text-align: center;
      line-height: 40px;
      transform: translateX(-50%);
    }
  }
}
</style>
