<template>
  <div id="app">
    <my-header></my-header>
    <banner></banner>
    <my-nav></my-nav>
    <router-view/>
    <myFooter></myFooter>
  </div>
</template>

<script>
import myHeader from '@/components/common/Header'
import banner from '@/components/common/banner'
import myNav from '@/components/common/Nav'
import myFooter from '@/components/common/Footer'
export default {
  name: 'App',
  components: {
    myHeader,
    banner,
    myNav,
    myFooter
  }
}
</script>

<style lang="scss">
@import "./assets/scss/global.scss";
</style>
