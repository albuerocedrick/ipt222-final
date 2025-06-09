
import { createRouter, createWebHistory } from 'vue-router'

// Import your components
import LandingPage from '../views/LandingPage.vue'
import LogIn from '../views/LogIn.vue'
import SignUp from '../views/SignUp.vue'
import Main from '../views/Main.vue'
import Dashboard from '../views/Main/Dashboard.vue'
import Tasks from '../views/Main/Tasks.vue'
import Projects from '../views/Main/Projects.vue'
import Calendar from '../views/Main/Calendar.vue'

const routes = [
    {
      path: '/',
      name: 'LandingPage',
      component: LandingPage,
      meta: { guestOnly: true }
    },
    {
      path: '/login',
      name: 'LogIn',
      component: LogIn,
      meta: { guestOnly: true }
    },
    {
      path: '/signup',
      name: 'SignUp',
      component: SignUp,
      meta: { guestOnly: true }
    },
    {
      path: '/main',
      name: 'Main',
      component: Main,
      meta: {requiresAuth: true},
      children: [
        {
          path: '',
          name: 'Dashboard',
          component: Dashboard
        },
        {
          path: 'tasks',
          name: 'Tasks',
          component: Tasks
        },
        {
          path: 'projects',
          name: 'Projects',
          component: Projects
        },
        // {
        //   path: 'calendar',
        //   name: 'Calendar',
        //   component: Calendar
        // },
        
      ]
    },
    {
      path: '/:pathMatch(.*)*',
      redirect: '/'
    }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// router.beforeEach((to, from, next) => {
//   const user = JSON.parse(localStorage.getItem('user'));

//   if (to.meta.requiresAuth && !user) {
//     next('/');
//   } else if (to.meta.guestOnly && user) {
//     next('/main');
//   } else {
//     next();
//   }
// });

export default router
