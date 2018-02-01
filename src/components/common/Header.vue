<template>
  <header class="header-wrap">
    <div class="wrap clearfix">
      <div class="fl logo">
        <h1><router-link :to="{ name: 'index' }">{{ blogInfo.blogName }}</router-link></h1>
      </div>
      <ul class="fl other-link">
        <li class="list">
          <a href="#"><i class="iconfont icon-about"></i>关于我</a>
        </li>
        <li class="list">
          <a href="#"><i class="iconfont icon-message"></i>留言板</a>
        </li>
        <li class="list">
          <a href="#"><i class="iconfont icon-about1"></i>邻居</a>
        </li>
        <li class="list">
          <a href="#"><i class="iconfont icon-link"></i>友链申请</a>
        </li>
      </ul>
      <div class="fl search-wrap">
        <form action="#">
          <input type="text" name="" value="" placeholder="搜索...">
        </form>
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
      <img :src="blogInfo.banner" height="300" alt="">
    </div>

    <!-- 导航容器 -->
    <div class="nav-wrap">
      <div class="wrap">
        <!-- 头像 -->
        <div class="head-portrait">
          <img :src="JSON.stringify(blogInfo) !== '{}' ? blogInfo.adminPic['full'] : ''" width="150" alt="">
        </div>
        <!-- 导航 -->
        <nav class="nav-list-wrap">
          <ul class="list-wrap">
            <li class="nav-list">
              <router-link :to="{ name: 'index' }">首页</router-link>
            </li>
            <li class="nav-list" v-for="item in navList" :key="item.key">
              <router-link :to="{ name: 'list', params: { id: item.ID } }">{{ item.title }}</router-link>
              <ul class="sub-nav-wrap" v-if="item.children.length !== 0">
                <li class="sub-nav-list" v-for="subNav in item.children" :key="subNav.key">
                  <router-link :to="{ name: 'list', params: { id: subNav.ID } }">{{ subNav.title }}</router-link>
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
import axios from 'axios'
import store from '@/vuex/store'
import { mapState, mapMutations } from 'vuex'
export default {
  name: 'myHeader',
  store,
  data: () => ({
    navList: {}
  }),
  created () {
    // 获取导航菜单
    axios.get(`/wordpress-4.7.4/wp-json/xm-blog/v1/menu`).then((res) => (this.navList = res.data)).catch((err) => console.log(err))
    this.getInfo()
  },
  computed: {
    ...mapState(['blogInfo'])
  },
  methods: {
    ...mapMutations(['getInfo'])
  }
}
</script>

<style lang="scss">
@import "../../assets/scss/_common.scss";
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
      > a{
        line-height: 60px;

        &.router-link-exact-active{
          color: $colorBlue;
        }
      }
    }

    .sub-nav-wrap{
      display: none;
    }
  }
}
</style>
