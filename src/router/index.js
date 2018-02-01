import Vue from 'vue'
import Router from 'vue-router'
import Index from '@/components/pages/Index'
import List from '@/components/pages/List'
import Single from '@/components/pages/Single'
import NotFound from '@/components/pages/404'

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
      path: '/cat/:id',
      name: 'list',
      component: List
    },
    {
      path: '/single/:id',
      name: 'single',
      component: Single
    },
    {
      path: '*',
      name: 'notFound',
      component: NotFound
    }
  ]
})
