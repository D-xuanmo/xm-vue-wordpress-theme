<template>
  <loading v-if="bLoading"></loading>
  <div v-else id="app">
    <my-header></my-header>
    <router-view/>
    <my-footer></my-footer>
  </div>
</template>

<script>
import myHeader from '@/components/common/Header'
import myFooter from '@/components/common/Footer'
import loading from '@/components/common/Loading'
import store from '@/vuex/store'
import { mapState } from 'vuex'
export default {
  name: 'App',
  components: {
    myHeader,
    myFooter,
    loading
  },
  store,
  created () {
    this.$store.commit('getInfo')
  },
  computed: {
    ...mapState({
      bLoading: state => state.info.bLoading
    })
  }
}
</script>

<style lang="scss">
@import "./assets/scss/global.scss";
</style>
