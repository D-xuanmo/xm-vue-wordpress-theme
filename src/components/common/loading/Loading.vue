<template>
  <div class="loading">
    <div class="box">
      <img src="./images/loading.svg" width="50" height="50" alt="">
      <p class="text">{{ msg }}</p>
    </div>
  </div>
</template>
<script>
export default {
  name: 'loading',
  data () {
    return {
      msg: '加载中...'
    }
  }
}
</script>
<style lang="scss" scoped>
.loading{
  position: fixed;
  top: 0;
  left: 0;
  z-index: 99999;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.8);
  text-align: center;

  .box{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

    .text{
      margin-top: 10px;
    }
  }
}
</style>
