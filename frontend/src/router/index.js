import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth.store.js'

const delay = (ms) => new Promise((resolve) => setTimeout(resolve, ms))

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'dashboard',
      component: () => import('../layouts/DashboardLayout.vue'),
      children: [
        {
          path: '/inicio',
          name: 'inicio',
          component: () => import('../pages/InicioPage.vue')
        },
        {
          path: '/:pathMatch(.*)*',
          name: 'not-found',
          component: () => import('../pages/NotFound.vue')
        }
      ]
    },
    {
      path: '/',
      name: 'main',
      component: () => import('../layouts/MainLayout.vue'),
      children: [
        {
          path: '/login',
          name: 'login',
          component: () => import('../pages/auth/LoginView.vue')
        },
        {
          path: '/:pathMatch(.*)*',
          name: 'not-found',
          component: () => import('../pages/NotFound.vue')
        }
      ]
    }
  ],
  async scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      await delay(10)
      return savedPosition
    } else if (to.hash) {
      await delay(10)
      return { el: to.hash, behavior: 'smooth' }
    } else {
      await delay(10)
      return { top: 0, behavior: 'smooth', left: 0 }
    }
  }
})

router.beforeEach(async (to) => {
  const publicPages = ['/login', '/']
  const authRequired = !publicPages.includes(to.path)
  const auth = useAuthStore()

  if (to.path === '/') {
    return '/inicio'
  }

  if (authRequired && !auth.user) {
    auth.returnUrl = to.fullPath
    return '/login'
  }
})

router.onError((error) => {
  console.error(error, 'errorHandler router.js')
  if (error.message.includes('Failed to fetch dinamically imported module')) {
    console.warn('Failed dynamic import, reloading...')
    window.location.reload()
  }
})

export default router
