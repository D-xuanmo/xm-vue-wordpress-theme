<template>
  <div class="comments-wrap">
    <ul class="comment-list-wrap">
      <li class="comment-list" v-for="item in commentList" :key="item.key">
        <img :src="item.author_avatar_urls[96]" class="list-gravatar" width="60" height="60" alt="">
        <p class="list-header">
          <a :href="item.author_url" class="name">{{ item.author_name }}</a>
          <time>{{ item.date.replace('T', ' ') }}</time>
        </p>
        <div class="list-content" v-html="item.content.rendered"></div>
        <div class="list-btn-wrap">
          <a href="#">回复</a>
        </div>
      </li>
    </ul>
  </div>
</template>
<script>
import axios from 'axios'
export default {
  name: 'comments',
  data: () => ({
    commentList: []
  }),
  created () {
    axios.get(`/wordpress-4.7.4/wp-json/wp/v2/comments/`, {
      params: {
        post: this.$route.params.id,
        page: 1
      }
    }).then((res) => (this.commentList = res.data)).catch((err) => console.log(err))
  }
}
</script>
<style lang="scss" scoped>
@import "../../assets/scss/_common.scss";
.comments-wrap{
  padding: 10px 0;

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

    .name{
      font-size: 16px;
      font-weight: bold;
    }

    .list-content{
      margin: 10px 0;
    }

    time{
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
