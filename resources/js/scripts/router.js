import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)
const routes =  [
  {
    path: '/',
    component: () => import('../components/pages/login'),
  },
  {
    path: '/home',
    name: 'home',
    component: () => import('../components/pages/home'),
  },
  {
    path: '/signup',
    name: 'signup',
    component: () => import('../components/pages/signup'),
  },
  {
    path: '*',
    name: 'notfound',
    component: () => import('../components/pages/notfound')
  }
]

export default new Router({
  mode: 'history',
  routes
})