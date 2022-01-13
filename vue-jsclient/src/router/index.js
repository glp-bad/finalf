import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Controale from '../views/test/Controale.vue'
import viewGridul from '../views/test/viewGridul'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
   {     name: 'TestControale',   path: '/testControale',  component: Controale   },
   {     name: 'Gridul',        path: '/viewGridul',  component: viewGridul   },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
