<template>
  <div class="footer-wrap">
    <div class="wrap">
      <div class="footer-top clearfix">
        <div class="fl logo">
          <div class="footer-logo">{{ blogInfo.blogName }}</div>
          <div class="introduct" v-html="blogInfo.footerText"></div>
        </div>
        <div class="fr link-logo">
          <a href="http://cn.wordpress.org">
            <img src="../../assets/images/wordpress.png" width="40" alt="" style="margin-top: 13px;">
            <span class="block">Wordpress</span>
          </a>
          <a href="https://www.aliyun.com">
            <img src="../../assets/images/aliyun-logo.png" width="50" alt="">
            <span class="block">阿里云</span>
          </a>
          <a href="https://console.upyun.com/register/?invite=BylFlCEWG">
            <img src="../../assets/images/upyun_logo4.png" width="70" alt="" style="margin-top: 13px;">
          </a>
          <a href="https://verify.nic.xin/xinDetail/xinAuthInfoDetail?domainName=xuanmo.xin">
            <img src="../../assets/images/xin.png" width="100" alt="" style="margin-top: 33px;">
          </a>
        </div>
      </div>
      <!-- 版权 -->
      <div class="copyright clearfix">
        <div class="fl" v-html="blogInfo.copyright"></div>
        <div class="fr">Theme by <a href="https://www.xuanmo.xin">Xuanmo</a></div>
      </div>
    </div>
  </div>
</template>
<script>
import store from '@/vuex/store'
import { mapState } from 'vuex'
export default {
  name: 'myFooter',
  store,
  computed: {
    ...mapState(['blogInfo'])
  }
}
</script>
<style lang="scss" scoped>
@import "../../assets/scss/_common.scss";
.footer-wrap{
  margin-top: 30px;
  padding: 15px 0;
  box-shadow: -5px 0px 10px $colorMainBoxShadow;
  background: #fff;

  .logo{
    width: 800px;
  }

  .footer-logo{
    margin-right: 20px;
    font-size: 30px;
    color: $colorGay3;
  }

  // logo链接
  .link-logo{
    a{
      float: left;
      min-width: 50px;
      margin: 0 5px;
      text-align: center;

      img{
        margin: 5px 0;
      }
    }
  }

  .copyright{
    margin-top: 30px;
    color: $colorGay3;
  }
}
</style>
