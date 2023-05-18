import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import FormAddEditPatient from '../views/FormAddEditPatient.vue'
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/patient/add',
      name: 'addPatient',
      component: FormAddEditPatient
    },
    {
      path: '/patient/edit/:id',
      name: 'editPatient',
      component: FormAddEditPatient
    }
  ]
})

export default router
