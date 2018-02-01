<template>
  <div id="app">
    <my-header></my-header>
    <router-view/>
    <my-footer></my-footer>
  </div>
</template>

<script>
import myHeader from '@/components/common/Header'
import myFooter from '@/components/common/Footer'
export default {
  name: 'App',
  components: {
    myHeader,
    myFooter
  }
}
</script>

<style lang="scss">
@import "./assets/scss/global.scss";
</style>
