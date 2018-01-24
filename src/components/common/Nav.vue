<template>
  <div class="nav-wrap">
    <div class="wrap">
      <!-- 头像 -->
      <div class="head-portrait">
        <img src="../../assets/images/thumbnail.jpg" width="150" alt="">
      </div>
      <!-- 导航 -->
      <nav class="nav-list-wrap">
        <ul class="list-wrap">
          <li class="nav-list">
            <router-link :to="{ name: 'index'}">首页</router-link>
          </li>
          <li class="nav-list">
            <router-link :to="{ name: 'index'}">笔记</router-link>
          </li>
          <li class="nav-list">
            <router-link :to="{ name: 'index'}">特效案例</router-link>
          </li>
          <li class="nav-list">
            <router-link :to="{ name: 'index'}">前端相关</router-link>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>
<script>
export default {
  name: 'commonNav'
}
</script>
<style lang="scss" scoped>
@import "../../assets/scss/_common.scss";
.nav-wrap{
  margin-bottom: 20px;
  box-shadow: 0 5px 10px #e2e2e2;
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
      height: 60px;
      @extend %navJustify;
    }

    .nav-list{
      display: inline-block;

      > a{
        line-height: 60px;
      }
    }
  }
}
</style>
