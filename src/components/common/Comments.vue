<template>
  <div class="comments-wrap">
    <!-- 发表评论 -->
    <form  action="#" method="post">
      <div class="comment-from">
        <h3 class="wrap-title">发表评论</h3>
        <p class="comment-tips">电子邮件地址不会被公开。 必填项已用<i class="c-red">*</i>标注</p>
        <div class="comment-form-content">
          <label for="content">内容<i class="c-red">*</i></label>
          <textarea id="content" name="content" v-model="content" rows="8" cols="80"></textarea>
        </div>
        <div class="box">
          <div class="comment-inp comment-from-author">
            <label for="author">昵称<i class="c-red">*</i></label>
            <input
              type="text"
              id="author"
              name="author"
              v-model="author"
              value=""
              autocomplete="off"
              v-validate="'required|min:3'"
            >
            <span v-show="errors.has('author')" class="comment-tips">{{ errors.first('author') }}</span>
          </div>
          <div class="comment-inp comment-from-email">
            <label for="email">邮箱<i class="c-red">*</i></label>
            <input
              type="email"
              id="email"
              name="email"
              v-model="email"
              value=""
              autocomplete="off"
              v-validate
              data-vv-rules="email"
              data-vv-zh="email"
            >
            <span v-show="errors.has('email')" class="comment-tips">{{ errors.first('email') }}</span>
          </div>
          <div class="comment-inp comment-from-url">
            <label for="url">网址</label>
            <input
              type="url"
              id="url"
              name="url"
              v-model="url"
              value=""
              autocomplete="off"
              v-validate="'required|min:3'"
            >
            <span v-show="errors.has('url')" class="comment-tips">{{ errors.first('url') }}</span>
          </div>
          <div class="comment-inp comment-from-code">
            <label for="img-code">验证码<i class="c-red">*</i></label>
            <input type="number" id="img-code" name="img-code" value="" autocomplete="off">
            <canvas width="120" height="30" class="canvas-img-code" @click="imgCode"></canvas>
          </div>
        </div>
        <input type="submit" class="submit-btn" @click.prevent="postComment()" value="提交评论">
      </div>
    </form>
    <!-- 评论列表 -->
    <ul class="comment-list-wrap">
      <li class="comment-list" v-for="item in commentList" :key="item.key">
        <img :src="item.author_avatar_urls[96]" class="list-gravatar" width="60" height="60" alt="">
        <p class="list-header">
          <a :href="item.author_url" class="author">{{ item.author_name }}</a>
          <time>{{ item.date.replace('T', ' ') }}</time>
          <span v-if="item.status === 'hold'">您的评论正在审核中...</span>
        </p>
        <div class="list-content" v-html="item.content.rendered"></div>
        <!-- <div class="list-btn-wrap">
          <a href="#">回复</a>
        </div> -->
      </li>
    </ul>
    <div class="more-btn" v-show="commentList.length">
      <img v-if="bMoreList" src="../../../static/images/bars.svg" alt="" width="40">
      <span v-else @click="bClick && getMoreList()">{{ sMoreBtnText }}</span>
    </div>
  </div>
</template>
<script>
import axios from 'axios'
export default {
  name: 'comments',
  data: () => ({
    commentList: [],
    author: '',
    email: '',
    url: '',
    content: '',
    currentNum: 1,
    bClick: true,
    bMoreList: false,
    sMoreBtnText: '下一页'
  }),
  props: ['commentCount'],
  created () {
    let authorInfo = JSON.parse(localStorage.getItem('authorInfo'))
    if (authorInfo !== null) {
      this.author = authorInfo.author
      this.email = authorInfo.email
      this.url = authorInfo.url
    }
    // 获取评论列表
    axios.get('/wp-json/wp/v2/comments/', {
      params: {
        post: this.$route.params.id,
        page: this.currentNum
      }
    }).then((res) => {
      this.commentList = res.data
      if (this.currentNum >= this.commentCount / 10) {
        this.sMoreBtnText = '最后一页！'
        this.bClick = false
      }
    }).catch((err) => console.log(err))
  },
  methods: {
    // 提交评论
    postComment () {
      let data = new URLSearchParams()
      // 保存评论者信息
      localStorage.setItem('authorInfo', JSON.stringify({
        author: this.author,
        email: this.email,
        url: this.url
      }))
      data.append('author_name', this.author)
      data.append('author_email', this.email)
      data.append('author_url', this.url)
      data.append('content', this.content)
      data.append('post', this.$route.params.id)
      data.append('author_user_agent', navigator.userAgent)
      axios.post(`/wp-json/wp/v2/comments`, data).then((res) => {
        this.commentList.unshift(res.data)
      }).catch((err) => console.log(1, err))
    },
    // 验证码
    imgCode () {
      let canvas = document.querySelector('.canvas-img-code')
      let ctx = canvas.getContext('2d')
      let nRandom1 = Math.floor(Math.random() * 10 + 5)
      let nRandom2 = Math.floor(Math.random() * 5)
      let nRandomResult = Math.floor(Math.random() * 3)
      let aOperator = ['+', '-', '*']
      ctx.clearRect(0, 0, canvas.width, canvas.height)
      ctx.font = '20px Microsoft Yahei'
      ctx.fillStyle = '#333'
      ctx.fillText(nRandom1 + ' ' + aOperator[nRandomResult] + ' ' + nRandom2 + ' = ?', 10, 23)
      return {
        nRandom1,
        nRandom2
      }
    },
    // 评论列表下一页
    getMoreList () {
      this.bMoreList = true
      this.currentNum++
      axios.get('/wp-json/wp/v2/comments/', {
        params: {
          post: this.$route.params.id,
          page: this.currentNum
        }
      }).then((res) => {
        this.bMoreList = false
        this.commentList = [...this.commentList, ...res.data]
        if (this.currentNum >= this.commentCount / 10) {
          this.sMoreBtnText = '最后一页！'
          this.bClick = false
        }
      }).catch((err) => console.log(err))
    }
  },
  mounted () {
    this.imgCode()
  }
}
</script>

<style lang="scss" scoped>
@import "../../assets/scss/_common.scss";
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
      background: $colorBlue;
      cursor: pointer;
    }
  }

  .comment-from{
    box-sizing: border-box;
    margin-bottom: 20px;
    padding: 10px;
    border-radius: 5px;
    background: $colorMainGay;

    .comment-form-content{
      box-sizing: border-box;
      margin: 20px 0;
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
        width: 100%;
        height: 30px;
      }

      .comment-tips{
        font-size: 12px;
        color: #f00;
      }
    }

    // 验证码
    .comment-from-code{
      position: relative;

      .canvas-img-code{
        position: absolute;
        bottom: 5px;
        right: 5px;
      }
    }

    .submit-btn{
      display: block;
      width: 250px;
      margin: 20px auto;
      padding: 15px 0;
      border-radius: 30px;
      background: $colorBlue;
      text-align: center;
      color: #fff;
      cursor: pointer;
    }
  }

  .comment-list{
    box-sizing: border-box;
    position: relative;
    width: 95%;
    margin: 0 0 20px 5%;
    padding: 10px 10px 10px 50px;
    border-radius: 5px;
    background: $colorMainGay;
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

    .list-content{
      margin: 10px 0;
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
</style>
