import Vue from 'vue'
import Router from 'vue-router'
import Index from '@/components/pages/Index'
import Single from '@/components/pages/Single'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      // path: '/wordpress-4.7.4/',
      path: '/',
      name: 'index',
      component: Index
    },
    {
      path: '/single/:id',
      name: 'single',
      component: Single
    }
  ]
})
