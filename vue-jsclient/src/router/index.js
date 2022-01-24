import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Controale from '../views/test/Controale.vue'
import viewGridul from '../views/test/viewGridul'
import viewAvocat from '../views/app/viewAvocat'
import viewParteneri from '../views/app/viewParteneri'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
   {     name: 'Avocat',            path: '/viewAvocat',    component: viewAvocat   },
   {     name: 'Parteneri',         path: '/viewParteneri', component: viewParteneri   },
   {     name: 'TestControale',     path: '/testControale', component: Controale   },
   {     name: 'Gridul',            path: '/viewGridul',    component: viewGridul  },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
