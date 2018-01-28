<template>
  <header class="header-wrap">
    <div class="wrap clearfix">
      <div class="fl logo">
        <h1><router-link :to="{ name: 'index' }">{{ $store.state.blogInfo.blogName }}</router-link></h1>
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
  </header>
</template>

<script>
import store from '@/vuex/store'
export default {
  name: 'myHeader',
  store
}
</script>

<style lang="scss">
@import "../../assets/scss/_common.scss";
.header-wrap{
  height: 60px;
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
}
</style>
