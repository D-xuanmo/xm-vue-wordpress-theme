<template>
  <div class="wrap" v-html="notFound"></div>
</template>
<script>
import { mapState } from 'vuex'
export default {
  name: 'notFound',
  computed: {
    ...mapState({
      notFound: state => state.info.blogInfo.setExtend.not_found
    })
  }
}
</script>
<style lang="scss" scoped>
.wrap{
  padding: 20px 0;
}
</style>
