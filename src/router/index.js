import Vue from 'vue'
import Router from 'vue-router'
import Index from '@/views/Index'
import Category from '@/views/Category'
import Single from '@/views/single/Single'
import Page from '@/views/Page'
import NotFound from '@/views/404'

Vue.use(Router)

export default new Router({
  // mode: 'history',
  routes: [
    {
      path: '/',
      name: 'index',
      component: Index,
      meta: { keepAlive: true }
    },
    {
      path: '/cat/:id?/:title?',
      name: 'category',
      component: Category,
      meta: { keepAlive: false }
    },
    {
      path: '/single/:id',
      name: 'single',
      component: Single,
      meta: { keepAlive: false }
    },
    {
      path: '/page/:id',
      name: 'page',
      component: Page,
      meta: { keepAlive: false }
    },
    {
      path: '*',
      name: 'notFound',
      component: NotFound,
      meta: { keepAlive: false }
    }
  ]
})
