import { createRouter, createWebHistory } from 'vue-router'
import Home             from '../views/Home.vue'
import Controale        from '../views/test/Controale.vue'
import viewGridul       from '../views/test/viewGridul'
import viewAvocat       from '../views/app/viewAvocat'
import viewParteneri    from '../views/app/viewParteneri'
import viewInvoices     from '../views/app/viewInvoices'
import viewIncasari     from '../views/app/viewIncasari'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
   {     name: 'Avocat',           path: '/viewAvocat',    component: viewAvocat   },
   {     name: 'Parteneri',        path: '/viewParteneri', component: viewParteneri   },
   {     name: 'Facturez',         path: '/viewInvoices',  component: viewInvoices   },
   {     name: 'Incasari',         path: '/viewIncasari',  component: viewIncasari   },

   {     name: 'TestControale',    path: '/testControale', component: Controale   },
   {     name: 'Gridul',           path: '/viewGridul',    component: viewGridul  },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
