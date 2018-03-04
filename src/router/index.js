import Vue from 'vue'
import Router from 'vue-router'
import Index from '@/components/pages/Index'
import Category from '@/components/pages/Category'
import Single from '@/components/pages/Single'
import Page from '@/components/pages/Page'
import NotFound from '@/components/pages/404'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'index',
      component: Index
    },
    {
      path: '/cat/:id?/:title?',
      name: 'category',
      component: Category
    },
    {
      path: '/single/:id',
      name: 'single',
      component: Single
    },
    {
      path: '/page/:id',
      name: 'page',
      component: Page
    },
    {
      path: '*',
      name: 'notFound',
      component: NotFound
    }
  ]
})
