<template>
  <transition name="tips-show">
    <div class="tips" :class="show.className" v-if="show.mark"><i class="iconfont" :class="show.icon"></i> {{ show.msg }}</div>
  </transition>
</template>
<script>
export default {
  name: 'tips',
  data: () => ({
  }),
  props: {
    show: {
      type: Object
    }
  }
}
</script>
<style lang="scss" scoped>
.tips{
  position: fixed;
  top: 30px;
  left: 50%;
  z-index: 99999;
  width: 380px;
  height: 40px;
  margin-left: -190px;
  border: 1px solid #ebeef5;
  border-radius: 5px;
  line-height: 40px;
  text-align: center;
  transition: 1s;
  &.alert-success{
    border-color: #e1f3d8;
    background-color: #f0f9eb;
    color: #67c23a;
  }
  &.alert-content{
    background-color: #f4f4f5;
    color: #909399;
  }
  &.alert-warning{
    border-color: #faecd8;
    background-color: #fdf6ec;
    color: #e6a23c;
  }
  &.alert-error{
    border-color: #fde2e2;
    background-color: #fef0f0;
    color: #f56c6c;
  }

  .iconfont{
    font-size: 16px;
  }
}
.tips-show-enter, .tips-show-leave-to{
  opacity: 0;
  transform: translateY(-100px);
}
@media screen and (max-width:360px) {
  .tips{
    width: 240px;
    margin-left: -120px;
  }
}
</style>
