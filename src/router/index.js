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
      component: Index,
      meta: { keepAlive: false }
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
