<template>
  <div class="loading" v-if="isShow">
    <img src="./images/oval.svg" alt="">
  </div>
</template>
<script>
export default {
  name: 'loading',
  data () {
    return {
      isShow: false
    }
  },
  methods: {
    show () {
      this.isShow = true
    },
    hide () {
      this.isShow = false
    }
  }
}
</script>
<style lang="scss" scoped>
.loading{
  position: fixed;
  top: 0;
  left: 0;
  z-index: 9999;
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
