<template>
  <div class="upload-img-wrap">
    <div class="sub-upload-wrap text-center">
      <h2 class="title">插入图片</h2>
      <i class="iconfont icon-close" @click.stop="hideUpload()"></i>
      <div class="progress-wrap">
        <p class="text">上传进度：</p>
        <div class="current-pro">
          <div class="current" :style="`width:${currentProgress}%`"></div>
        </div>
        <div>{{ currentProgress }}%</div>
      </div>
      <div class="select-img">
        <input type="file" name="file" value="" accept="image/png,image/gif,image/jpeg" @change.stop="uploadImg($event)">
        <p class="mask">
          <i class="iconfont icon-picture"></i>点击选择图片
        </p>
      </div>
      <div class="result-img">
        <img :src="resultImgUrl">
      </div>
      <div class="btn btn-insert" @click.stop="insertImg()">插入到文章</div>
    </div>
  </div>
</template>
<script>
import axios from 'axios'
import { mapState } from 'vuex'
export default {
  name: 'uploadImg',
  data: () => ({
    currentProgress: 0,
    resultImgUrl: ''
  }),
  props: ['showChart'],
  computed: {
    ...mapState({
      contentUrl: state => state.info.blogInfo.contentUrl,
      templeteUrl: state => state.info.blogInfo.templeteUrl
    })
  },
  methods: {
    // 上传图片
    uploadImg (event) {
      let _file = event.currentTarget
      window.XM.addClass(document.body, 'o-hide')
      // 上传实时进度
      let config = {
        onUploadProgress: progressEvent => (this.currentProgress = parseInt(progressEvent.loaded / progressEvent.total * 100))
      }
      let data = new FormData()
      if (_file.files[0].size / 1024 > 2048) {
        alert('请上传小于2M的图片！')
      } else {
        data.append('postID', this.$route.params.id)
        data.append('file', _file.files[0])
        data.append('url', this.contentUrl)
        axios.post(`/wp-content/themes/xm-vue-theme/xm_upload.php`, data, config).then(res => {
          this.resultImgUrl = res.data.path
          _file.value = ''
        }).catch(err => console.log(err))
      }
    },
    // 隐藏上传控件
    hideUpload () {
      this.$emit('showChart', false)
      this.currentProgress = 0
      this.resultImgUrl = ''
      window.XM.removeClass(document.body, 'o-hide')
    },
    // 插入到文章
    insertImg () {
      this.$emit('updateContent', ` [img]${this.resultImgUrl}[/img] `)
      this.$emit('showChart', false)
      this.currentProgress = 0
      this.resultImgUrl = ''
      window.XM.removeClass(document.body, 'o-hide')
    }
  },
  mounted () {
  }
}
</script>
<style lang="scss" scoped>
@import "../../assets/scss/_common.scss";
// 评论上传图片
.upload-img-wrap{
  position: fixed;
  top: 0;
  left: 0;
  z-index: 999;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,.7);

  .sub-upload-wrap{
    box-sizing: border-box;
    position: absolute;
    top: 50%;
    left: 50%;
    width: 70%;
    padding: 10px;
    border-radius: 5px;
    background: #fff;
    transform: translate(-50%,-50%);
  }

  .title{
    font-size: 20px;
    font-weight: lighter;
  }

  .icon-close{
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
  }

  // 进度条
  .progress-wrap{
    display: flex;
    align-items: center;
  }

  .current-pro{
    width: 80%;

    .current{
      width: 0px;
      height: 5px;
      border-radius: 5px;
      background-color: #0ae;
      background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .2) 50%, rgba(255, 255, 255, .2) 75%, transparent 75%, transparent);
    }
  }

  // 选择图片
  .select-img{
    position: relative;
    height: 50px;
    margin: 10px 0;
    border: 2px dashed $colorGay1;
    line-height: 50px;

    .mask,
    .iconfont{
      font-size: 18px;
    }

    input{
      opacity: 0;
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      cursor: pointer;
    }
  }

  .result-img{
    img{
      max-width: 300px;
      max-height: 350px;
    }
  }

  .btn-insert{
    width: 100px;
    height: 40px;
    margin: 15px auto;
    border-radius: 5px;
    background: #0ae;
    line-height: 40px;
    color: #fff;
    cursor: pointer;
  }
}
@media screen and (max-width: 767px) {
  .upload-img-wrap{
    .sub-upload-wrap{
      width: 90%;
    }
    .progress-wrap{
      flex-wrap: wrap;
      .text{
        width: 100%;
        text-align: left;
      }
      .current-pro{
        width: 90%;
      }
    }
    .result-img{
      img{
        max-width: 200px;
      }
    }
  }
}
</style>
