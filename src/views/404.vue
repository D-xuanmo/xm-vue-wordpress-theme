<template>
  <div id="not-found">
    <img :src="notFoundUrl" alt="">
  </div>
</template>
<script>
import { mapState } from 'vuex'
export default {
  name: 'notFound',
  computed: {
    ...mapState({
      notFoundUrl: state => state.info.blogInfo.setExtend.not_found
    })
  }
}
</script>
<style lang="scss" scoped>
#not-found{
  padding: 20px 0;
  text-align: center;
}
</style>
