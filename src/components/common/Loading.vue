<template>
  <div class="loading">
    <img src="../../../static/images/loading.svg" alt="">
  </div>
</template>
<script>
export default {
  name: 'loading'
}
</script>
<style lang="scss" scoped>
.loading{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.8);

  img{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
}
</style>
