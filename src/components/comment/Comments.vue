<template>
  <div class="comments-wrap">
    <!-- 发表评论 -->
    <form  action="#" method="post" ref="form">
      <div class="comment-from">
        <h3 class="wrap-title">发表评论</h3>
        <p class="comment-tips">电子邮件地址不会被公开。 必填项已用<i class="c-red">*</i>标注</p>
        <!-- 评论其他功能 -->
        <div class="comment-other">
          <ul class="list-wrap">
            <li class="list" @click="showChartlet()">
              <i class="iconfont icon-picture"></i>贴图
            </li>
            <li class="list" @click.stop="getExpression()">
              <i class="iconfont icon-expression"></i>表情
            </li>
          </ul>
          <upload-img v-show="showChart" @showChart="getShowChart" @updateContent="getContent" :showChart="showChart"></upload-img>
          <!-- 表情容器 -->
          <div class="expression-wrap" ref="expression">
            <a href="javascript:;" v-for="(item, key) in expression.content" :key="item.key" :title="item.title" :data-title="`/${key}`" @click.stop="editExpression($event)">
              <img :src="item.url" :alt="item.title" width="30">
            </a>
          </div>
        </div>
        <div class="comment-form-content">
          <label for="content">内容<i class="c-red">*</i></label>
          <textarea id="content" name="content" v-model="content.value" rows="8" cols="80" @keyup="contentValidate()"></textarea>
          <span v-show="content.validate" class="comment-tips">{{ content.msg }}</span>
        </div>
        <div class="box">
          <div class="comment-inp comment-from-author">
            <label for="author">昵称<i class="c-red">*</i></label>
            <input
              type="text"
              id="author"
              name="author"
              v-model="author.value"
              value=""
              autocomplete="off"
              @keyup="authorValidate()"
            >
            <span v-show="author.validate" class="comment-tips">{{ author.msg }}</span>
          </div>
          <div class="comment-inp comment-from-email">
            <label for="email">邮箱<i class="c-red">*</i></label>
            <input
              type="email"
              id="email"
              name="email"
              v-model="email.value"
              value=""
              autocomplete="off"
              @keyup="emailValidate()"
            >
            <span v-show="email.validate" class="comment-tips">{{ email.msg }}</span>
          </div>
          <div class="comment-inp comment-from-url">
            <label for="url">网址</label>
            <input
              type="url"
              id="url"
              name="url"
              autocomplete="off"
              v-model="url.value"
            >
          </div>
          <div class="comment-inp comment-from-code">
            <label for="img-code">验证码<i class="c-red">*</i></label>
            <input
              type="number"
              id="img-code"
              name="img-code"
              value=""
              v-model="imgCode.value"
              autocomplete="off"
              @keyup="codeValidate()"
            >
            <canvas width="120" height="30" class="canvas-img-code" @click="randomCode()"></canvas>
            <span v-show="imgCode.validate" class="comment-tips">{{ imgCode.msg }}</span>
          </div>
        </div>
        <div class="submit-wrap" @click.prevent="bSubmit && postComment()">
          <i v-show="!bSubmit" class="iconfont icon-loading"></i>
          <input type="submit" class="submit-btn" :value="submitText">
        </div>
      </div>
    </form>
    <!-- 评论列表 -->
    <ul class="comment-list-wrap">
      <li class="comment-list" v-for="item in commentList" :key="item.key">
        <img :src="item.author_avatar_urls[96]" class="list-gravatar" width="60" height="60" alt="">
        <div class="list-header">
          <a :href="item.author_url" target="_blank" class="author">{{ item.author_name }}</a>
          <!-- 评论者等级 -->
          <p class="inline-block">
            <span class="icon-vip icon-level" :class="[item.userAgentInfo.vipStyle.style, item.userAgentInfo.vipStyle.level]" :style="`background-image: url(${templeteUrl}/static/images/vip.png);`" :title="item.userAgentInfo.vipStyle.title"></span>
          </p>
          <!-- 浏览器logo -->
          <span class="browser-info" :class="item.userAgentInfo.userAgent.browserName.toLowerCase()">{{ item.userAgentInfo.userAgent.browserName.replace('-', ' ') }}|{{ item.userAgentInfo.userAgent.browserVersion }}</span>
          <!-- 系统logo -->
          <span class="system-info">{{ item.userAgentInfo.userAgent.system.replace(/_/g, '.') }}</span>
          <time>{{ item.date.replace('T', ' ') }}</time>
          <span v-if="item.status === 'hold'">您的评论正在审核中...</span>
        </div>
        <div class="list-content" v-html="item.content.rendered" v-replace-img v-highlight></div>
        <!-- <div class="list-btn-wrap">
          <a href="#">回复</a>
        </div> -->
      </li>
    </ul>
    <div class="more-btn" v-show="commentList.length">
      <img v-if="bMoreList" src="./images/bars.svg" alt="" width="40">
      <span v-else @click="bClick && getMoreList()">{{ sMoreBtnText }}</span>
    </div>
  </div>
</template>
<script>
import uploadImg from './UploadImg'
import { mapState } from 'vuex'
export default {
  name: 'comments',
  components: {
    uploadImg
  },
  data () {
    return {
      commentList: [],
      author: {
        value: '',
        validate: true,
        msg: ''
      },
      email: {
        value: '',
        validate: true,
        msg: ''
      },
      url: {
        value: '',
        validate: true,
        msg: ''
      },
      content: {
        value: '',
        validate: true,
        msg: ''
      },
      imgCode: {
        value: '',
        validate: true,
        msg: ''
      },
      random: {},
      expression: {
        content: {},
        state: true,
        clickState: true
      },
      currentNum: 1,
      bClick: true,
      bMoreList: false,
      bSubmit: true,
      showChart: false,
      sMoreBtnText: '下一页',
      submitText: '提交评论'
    }
  },
  directives: {
    // 替换表情的默认样式
    'replace-img': {
      inserted (el) {
        el.querySelectorAll('img').forEach(item => {
          if (item.className.indexOf('wp-smiley') !== -1) item.style = 'max-width: 30px; vertical-align: bottom;'
        })
      }
    }
  },
  props: ['commentCount'],
  created () {
    let authorInfo = JSON.parse(localStorage.getItem('authorInfo'))
    if (authorInfo !== null) {
      this.author.value = authorInfo.author
      this.email.value = authorInfo.email
      this.url.value = authorInfo.url
    }
    // 获取评论列表
    window.axios.get('/wp-json/wp/v2/comments/', {
      params: {
        post: this.$route.params.id,
        page: this.currentNum
      }
    }).then(res => {
      if (this.currentNum === +res.header['x-wp-totalpages']) {
        this.sMoreBtnText = '最后一页！'
        this.bClick = false
      }
      this.commentList = res.data
    }).catch(err => console.log(err))
  },
  computed: {
    ...mapState({
      templeteUrl: state => state.info.blogInfo.templeteUrl
    })
  },
  methods: {
    // 评论列表下一页
    getMoreList () {
      this.bMoreList = true
      this.currentNum++
      window.axios.get('/wp-json/wp/v2/comments/', {
        params: {
          post: this.$route.params.id,
          page: this.currentNum
        }
      }).then(res => {
        if (this.currentNum === +res.header['x-wp-totalpages']) {
          this.sMoreBtnText = '最后一页！'
          this.bClick = false
        }
        this.bMoreList = false
        this.commentList = [...this.commentList, ...res.data]
      }).catch(err => console.log(err))
    },
    // 提交评论
    postComment () {
      this.contentValidate()
      this.authorValidate()
      this.emailValidate()
      this.codeValidate()
      if (!this.content.validate && !this.author.validate && !this.email.validate && !this.imgCode.validate) {
        this.bSubmit = false
        this.submitText = '提交中...'
        let data = new FormData()
        // 保存评论者信息
        localStorage.setItem('authorInfo', JSON.stringify({
          author: this.author.value,
          email: this.email.value,
          url: this.url.value
        }))
        data.append('author_name', this.author.value)
        data.append('author_email', this.email.value)
        data.append('author_url', this.url.value)
        data.append('content', this.content.value)
        data.append('post', this.$route.params.id)
        data.append('author_user_agent', navigator.userAgent)
        window.axios.post('/wp-json/wp/v2/comments', data).then((res) => {
          // 允许继续点击提交按钮
          this.bSubmit = true
          this.submitText = '提交评论'
          this.commentList.unshift(res.data)
          this.content.value = ''
          this.imgCode.value = ''
          this.randomCode()
          this.$message({
            title: '提交评论成功',
            type: 'success'
          })
        }).catch((err) => {
          this.$message({
            title: err.response.data.message,
            type: 'error'
          })
          this.randomCode()
          this.submitText = '提交评论'
          // 允许继续点击提交按钮
          this.bSubmit = true
        })
      }
    },
    // 验证码
    randomCode (bool) {
      let canvas = document.querySelector('.canvas-img-code')
      let ctx = canvas.getContext('2d')
      let nRandom1 = Math.floor(Math.random() * 10 + 5)
      let nRandom2 = Math.floor(Math.random() * 5)
      let nRandomResult = Math.floor(Math.random() * 3)
      let aOperator = ['+', '-', '*']
      ctx.clearRect(0, 0, canvas.width, canvas.height)
      ctx.font = '20px Microsoft Yahei'
      ctx.fillStyle = '#333'
      ctx.fillText(`${nRandom1} ${aOperator[nRandomResult]} ${nRandom2} = ?`, 10, 23)
      this.random = {
        nRandom1,
        nRandom2,
        operator: aOperator[nRandomResult]
      }
    },
    // 验证内容
    contentValidate () {
      if (this.content.value !== '') {
        this.content.validate = false
      } else {
        this.content.validate = true
        this.content.msg = '来点内容吧！'
      }
    },
    // 验证昵称
    authorValidate () {
      if (this.author.value !== '') {
        this.author.validate = false
      } else {
        this.author.validate = true
        this.author.msg = '昵称不能为空！'
      }
    },
    // 验证邮箱
    emailValidate () {
      if (this.email.value !== '') {
        this.email.validate = false
        if (this.email.value.match(/^(\w+|\w+(\.\w+))+@(\w+\.)+\w+$/) === null) {
          this.email.validate = true
          this.email.msg = '邮箱格式错误！'
        }
      } else {
        this.email.validate = true
        if (this.email.value === '') {
          this.email.msg = '邮箱不能为空！'
        }
      }
    },
    // 验证码
    codeValidate () {
      if (this.imgCode.value === '') {
        this.imgCode.validate = true
        this.imgCode.msg = '请输入验证码！'
      } else {
        let _randomCode = this.random
        let result = 0
        switch (_randomCode.operator) {
          case '+':
            result = _randomCode.nRandom1 + _randomCode.nRandom2
            break
          case '-':
            result = _randomCode.nRandom1 - _randomCode.nRandom2
            break
          case '*':
            result = _randomCode.nRandom1 * _randomCode.nRandom2
            break
        }
        if (+this.imgCode.value !== result) {
          this.imgCode.validate = true
          this.imgCode.msg = '是不是看错了？'
        } else {
          this.imgCode.validate = false
        }
      }
    },
    // 获取表情
    getExpression () {
      if (this.expression.clickState) {
        this.$refs.expression.style.display = 'block'
        if (this.expression.state) {
          window.axios.get(`${this.templeteUrl}/expression.php`).then(res => {
            this.expression.content = res.data
            this.expression.state = false
          }).catch(err => console.log(err))
        }
      } else {
        this.$refs.expression.style.display = 'none'
      }
      this.expression.clickState = !this.expression.clickState
    },
    // 添加表情
    editExpression (event) {
      this.expression.clickState = true
      this.$refs.expression.style.display = 'none'
      this.content.value += ` ${event.currentTarget.getAttribute('data-title')} `
    },
    // 显示上传图片控件
    showChartlet () {
      window.XM.addClass(document.body, 'o-hide')
      this.showChart = true
    },
    // 获取关闭上传控件的值
    getShowChart (params) {
      this.showChart = params.close
    },
    // 获取子组件发回来的图片数据
    getContent (params) {
      this.content.value += params
    }
  },
  mounted () {
    this.randomCode()
    // 关闭表情显示
    document.body.onclick = () => {
      if (this.$refs.expression) {
        this.expression.clickState = true
        this.$refs.expression.style.display = 'none'
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.comments-wrap{
  padding: 10px 0;

  .more-btn{
    margin-top: 30px;
    text-align: center;
    color: #fff;

    span{
      display: inline-block;
      padding: 10px 30px;
      border-radius: 5px;
      background: $color-blue;
      cursor: pointer;
    }
  }

  .comment-other{
    position: relative;
    margin: 10px 0;
    ul.list-wrap{
      display: flex;
      justify-content: flex-start;

      .list{
        margin-right: 5px;
        cursor: pointer;
      }

      .iconfont{
        font-size: 16px;
      }
    }

    // 表情容器
    .expression-wrap{
      display: none;
      overflow-y: scroll;
      -webkit-overflow-scrolling: touch;
      box-sizing: border-box;
      position: absolute;
      top: 30px;
      left: 0;
      z-index: 2;
      width: 100%;
      height: 200px;
      padding: 15px;
      background: #fff;
      border-radius: 5px;
      &:after{
        content: "";
        display: inline-block;
        width: 100%;
      }

      a{
        display: inline-block;
        width: 50px;
        height: 50px;
        margin: 4px;
        border-radius: 5px;
        background: $colorGay2;
        text-align: center;
        line-height: 50px;
      }

      img{
        vertical-align: middle;
      }
    }
  }

  .comment-from{
    box-sizing: border-box;
    margin-bottom: 20px;
    padding: 10px;
    border-radius: 5px;
    background: $main-gay-color;

    .comment-tips:not(p){
      font-size: 12px;
      color: #f00;
    }

    .comment-form-content{
      box-sizing: border-box;
      margin-bottom: 20px;
      padding: 5px;
      border-radius: 5px;
      background: #fff;
    }

    textarea{
      box-sizing: border-box;
      resize: vertical;
      width: 100%;
      min-height: 150px;
      padding: 5px;
    }

    .box{
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .comment-inp{
      box-sizing: border-box;
      width: 49%;
      padding: 5px;
      border-radius: 5px;
      background: #fff;
      &:nth-of-type(1),
      &:nth-of-type(2){
        margin-bottom: 20px;
      }

      label{
        display: block;
      }

      input{
        -webkit-appearance: none;
        width: 100%;
        height: 30px;
      }
    }

    // 验证码
    .comment-from-code{
      position: relative;

      .canvas-img-code{
        position: absolute;
        bottom: 5px;
        right: 5px;
        z-index: 5;
      }
    }

    .submit-wrap{
      width: 250px;
      height: 45px;
      margin: 20px auto;
      border-radius: 30px;
      background: $color-blue;
      text-align: center;
      line-height: 45px;
      cursor: pointer;

      input{
        -webkit-appearance: none;
        color: #fff;
      }

      .iconfont{
        vertical-align: middle;
        font-size: 18px;
        color: #fff;
      }
    }
  }

  .comment-list{
    box-sizing: border-box;
    position: relative;
    width: 95%;
    margin: 0 0 20px 5%;
    padding: 10px 10px 10px 50px;
    border-radius: 5px;
    background: $main-gay-color;

    &:last-of-type{
      margin-bottom: 0;
    }

    .list-gravatar{
      position: absolute;
      top: 5px;
      left: -30px;
      border-radius: 5px;
    }

    .author{
      font-size: 18px;
      font-weight: bold;
    }

    // 浏览器信息
    .browser-info{
      display: inline-block;
      vertical-align: text-bottom;
      padding: 2px 4px;
      background: #06aaff;
      border-radius: 3px;
      color: #fff;

      &.chrome{
        background: linear-gradient(to right, #5087ec, #d95040, #f2bd42);
      }

      &.safari{
        background: linear-gradient(to right, #2670cb, #47a2c5);;
      }

      &.firefox{
        background: linear-gradient(to right, #dd3a45, #fcea67);
      }

      &.qqbrowser{
        background: linear-gradient(to right, #3072d1, #4ea8f3);
      }

      &.edge{
        background: #4378b5;
      }

      &.internet-explorer{
        background: linear-gradient(to right, #fadc4f, #8ae2fb, #57a0d4);
      }

      &.wechat{
        background: #94d258;
      }
    }

    // 系统信息
    .system-info{
      display: inline-block;
      vertical-align: text-bottom;
      padding: 2px 4px;
      background: #fc5c7d;
      background: linear-gradient(to right, #fc5c7d, #6a82fb);
      border-radius: 3px;
      color: #fff;
    }

    .list-content{
      margin: 10px 0;
    }

    // 评论者等级
    .icon-vip{
      display: inline-block;

      // 博主
      &.icon-admin{
        width: 20px;
        height: 20px;
        background-position: -172px -70px;
      }

      &.vip-style-1{
        width: 16px;
        height: 14px;
        background-position: -147px -70px;
        @for $i from 1 through 6 {
          &.vip#{$i + 1}{
            background-position-Y: -#{70 - $i * -25}px;
          }
        }
      }

      &.vip-style-2{
        width: 43px;
        height: 13px;
        background-position: -2px -3px;
        transition: .5s;
        @for $i from 1 through 6 {
          &.vip#{$i + 1}{
            background-position-X: -#{$i * 59}px;
          }
        }

        &:hover{
          background-position-Y: -23px;
        }
      }
    }

    time,
    span{
      font-size: 12px;
      color: #a8b6c0;
    }

    .list-btn-wrap{
      a{
        display: inline-block;
        padding: 5px 15px;
        border-radius: 5px;
        background: #fff;
      }
    }
  }
}
@media screen and (max-width: 767px) {
  .comments-wrap{
    .comment-from{
      .box{
        display: block;
      }

      .comment-inp{
        width: 100%;
      }

      .comment-from-url{
        margin-bottom: 20px;
      }

      .submit-btn{
        width: 100%;
      }
    }

    // 评论列表
    .comment-list{
      .list-gravatar{
        left: -15px;
      }

      time{
        display: block;
        margin-top: 5px;
      }
    }
  }
}
</style>
