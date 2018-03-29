<template>
  <header class="header-wrap">
    <div class="hd-top wrap clearfix" :class="{ active: bFloatTopHead }">
      <div class="fl logo">
        <h1><router-link ref="floatLogoText" :to="{ name: 'index' }" v-html="blogInfo.blogName"></router-link></h1>
      </div>
      <ul class="fl other-link hide-1023px">
        <li class="list" v-for="item in topNavList" :key="item.key">
          <router-link :to="{ name: 'page', params: { id: item.object_id }}"><i :class="`iconfont ${item.attr_title}`"></i>{{ item.title }}</router-link>
        </li>
      </ul>
      <div class="fl search-wrap" :class="{ show: bShowSearch }" @click="closeSearch">
        <input type="text" name="" v-model="searchRes" placeholder="搜索..." @keyup.prevent.enter="search" @click.stop>
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
      <div class="icon-wrap clearfix">
        <i class="fl iconfont icon-search hide" @click="showSearch"></i>
        <i class="fl iconfont icon-menu hide" @click="showMenu"></i>
      </div>
    </div>

    <!-- banner -->
    <div class="banner-wrap">
      <img :src="blogInfo.setExtend.big_banner ? blogInfo.setExtend.big_banner : `${templeteUrl}/static/images/default_banner.png`" alt="banner">
    </div>

    <!-- 导航容器 -->
    <div class="nav-wrap" :class="{ active: bFloatHead, show: bNavShow }">
      <div class="wrap">
        <!-- 头像 -->
        <div class="head-portrait">
          <img v-show="!bFloatHead" :src="blogInfo.adminPic.full ? blogInfo.adminPic.full : `${templeteUrl}/static/images/default_thumbnail.png`" width="150" height="150" alt="">
          <router-link v-show="bFloatHead" class="float-title" :to="{ name: 'index' }">{{ blogInfo.blogName }}</router-link>
        </div>
        <!-- 导航 -->
        <nav class="nav-list-wrap" :style="`margin-left: ${navMarginLeft}px`" @mouseleave="closeSubMenu">
          <i class="hide block iconfont icon-close" @click="closeMenu"></i>
          <ul class="list-wrap">
            <li class="nav-list" @mouseenter="showSubMenu($event)" @touchend="closeMenu">
              <router-link :to="{ name: 'index' }"><i v-show="bShowNavIcon" class="iconfont icon-home2"></i>首页</router-link>
            </li>
            <li class="nav-list" v-for="item in navList" :key="item.key" @mouseenter="showSubMenu($event)" @touchend="showSubMenu($event)">
              <router-link
                v-if="item.type === 'page'"
                :to="{ name: 'page', params: { id: item.ID } }"
                @click.native.stop="closeMenu"
              ><i class="iconfont" :class="item.icon"></i>{{ item.title }}</router-link>
              <router-link
                v-else-if="item.children.length === 0"
                :to="{ name: 'category', params: { id: item.ID, title: item.title } }"
                @click.native.stop="closeMenu"
              ><i class="iconfont" :class="item.icon"></i>{{ item.title }}</router-link>
              <a v-else href="javascript:;"><i class="iconfont" :class="item.icon"></i>{{ item.title }}</a>
              <ul class="sub-nav-wrap" v-if="item.children.length !== 0">
                <li class="sub-nav-list" v-for="subNav in item.children" :key="subNav.key" @click.stop="closeMenu">
                  <router-link v-if="subNav.type === 'page'" :to="{ name: 'page', params: { id: subNav.ID } }"><i class="iconfont" :class="subNav.icon"></i>{{ subNav.title }}</router-link>
                  <router-link v-else :to="{ name: 'category', params: { id: subNav.ID, title: subNav.title } }"><i class="iconfont" :class="subNav.icon"></i>{{ subNav.title }}</router-link>
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
    searchRes: '',
    bFloatHead: false,
    bFloatTopHead: false,
    bShowSearch: false,
    bNavShow: false,
    navMarginLeft: 0
  }),
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
      this.bShowSearch = false
    },

    // 移动端显示菜单
    showMenu () {
      this.bNavShow = true
      document.body.style.overflow = 'hidden'
    },

    // 移动端关闭菜单
    closeMenu () {
      this.bNavShow = false
      document.body.style.overflow = 'visible'
    },

    // 显示二级菜单
    showSubMenu (event) {
      let oChildren = event.currentTarget.querySelector('ul')
      if (oChildren) oChildren.style.display = 'block'
      if (event.type === 'mouseenter') {
        window.XM.siblings(event.currentTarget).forEach(item => {
          if (item.querySelector('ul')) {
            item.querySelector('ul').style.display = 'none'
          }
        })
      }
    },

    closeSubMenu () {
      document.querySelectorAll('.sub-nav-wrap').forEach(item => (item.style.display = 'none'))
    },

    showSearch () {
      this.bShowSearch = true
    },

    closeSearch () {
      this.bShowSearch = false
    }
  },
  computed: {
    ...mapState({
      blogInfo: state => state.info.blogInfo,
      navList: state => state.info.navList,
      topNavList: state => state.info.topNavList,
      bShowNavIcon: state => state.info.bShowNavIcon,
      templeteUrl: state => state.info.blogInfo.templeteUrl
    })
  },
  mounted () {
    let that = this
    window.addEventListener('scroll', function () {
      if (this.scrollY > 500) {
        if (this.innerWidth > 767) {
          that.bFloatHead = true
          // 计算浮动菜单margin-left到logo的距离
          that.navMarginLeft = that.$refs.floatLogoText.$el.offsetWidth + 15
        } else {
          that.bFloatTopHead = true
        }
      } else {
        if (this.innerWidth > 767) {
          that.bFloatHead = false
          that.navMarginLeft = 200
        } else {
          that.bFloatTopHead = false
        }
      }
    }, false)
  }
}
</script>

<style lang="scss">
.header-wrap{
  background: #fff;

  // logo
  .logo{
    margin-right: 20px;
    line-height: 60px;

    h1{
      font-size: 24px;
      font-weight: 400;
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
  box-shadow: 0 5px 10px $box-shadow-color;
  background: #fff;
  &.active{
    position: fixed;
    top: 0;
    left: 0;
    z-index: 999;
    width: 100%;

    .head-portrait{
      top: 0;
      bottom: 0;
      margin: auto;
      line-height: 60px;
    }

    .float-title{
      font-size: 24px;
    }
  }

  .router-link-exact-active:not(.float-title){
    color: $color-blue;
  }

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

      > a{
        line-height: 60px;
      }

      .iconfont{
        margin-right: 3px;
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
      text-indent: 28px;
      line-height: 40px;
      transform: translateX(-50%);
    }
  }
}
@media screen and (max-width: 1023px) {
  .header-wrap{
    .hd-top{
      display: flex;
      justify-content: space-between;
      align-items: center;
      &:after{
        display: none;
      }

      .logo,
      .search-wrap,
      .contact-wrap{
        float: none;
      }

      .search-wrap{
        margin: 0;
      }
    }
  }
  .nav-wrap{
    .head-portrait{
      display: none;
    }

    .nav-list-wrap{
      margin-left: 0;
    }
  }
}
@media screen and (max-width: 767px) {
  .header-wrap{
    .hd-top{
      &.active{
        box-sizing: border-box;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 99;
        width: 100%;
        padding: 0 5%;
        box-shadow: 0 2px 5px 0 rgba(0,0,0,.12);
        background: #fff;
      }
      .logo{
        margin: 0;
      }
      .contact-wrap{
        display: none;
      }
      .search-wrap{
        position: fixed;
        top: 0;
        left: 0;
        z-index: 999;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.4);
        transition: .7s;
        transform: translateX(-100%);

        input{
          position: absolute;
          top: 50%;
          left: 50%;
          width: 80%;
          transition: .7s .5s;
          transform: translate(-50%, -50%);
        }

        &.show{
          transform: translateX(0px);
        }
      }
    }
    .banner-wrap{
      display: none;
    }
    .icon-menu,
    .icon-search{
      display: block;
      font-size: 24px;
    }
    .icon-menu{
      margin-left: 20px;
    }
  }
  .nav-wrap{
    overflow-y: scroll;
    -webkit-overflow-scrolling: touch;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 999;
    width: 100%;
    height: 100%;
    transition: .7s;
    transform: translateX(-100%);
    &.show{
      transform: translateX(0px);
    }
    .wrap{
      height: 100%;
    }
    .icon-close{
      display: block;
      margin-top: 15px;
      text-align: right;
    }
    .nav-list-wrap{
      width: 100%;
      height: 100%;
      // 一级菜单容器
      .list-wrap{
        display: block;
        height: 100%;
      }
      // 二级菜单容器
      .sub-nav-wrap{
        position: static;
        width: 100%;
        text-align: left;
        text-indent: 28px;
        transform: translateX(0px);
      }
    }
  }
}
</style>
