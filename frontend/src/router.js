import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
    mode: process.env.CORDOVA_PLATFORM ? 'hash' : 'history',
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/',
            name: 'configuration',
            component: () => import('./views/Configuration.vue'),
        },
        {
            path: '/register',
            name: 'register',
            props: true,
            component: () => import('./views/Register.vue'),
        },
        {
            path: '/answer',
            name: 'answer',
            component: () => import('./views/Answer.vue'),
        },
        {
            path: '/end',
            name: 'end',
            component:() => import('./views/End.vue'),
        }
    ]
})
