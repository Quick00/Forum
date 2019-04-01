import Vue from 'vue';
import VueRouter from 'vue-router';

import home from '@/js/components/home'
import login from '@/js/components/login';
import register from '@/js/components/register';
import admin from '@/js/components/admin';
import logout from '@/js/components/logout';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: home,
            component: home
        },
        {
            path: '/login',
            name: login,
            component: login
        },
        {
            path: '/register',
            name: register,
            component: register
        },
        {
            path: '/admin',
            name: admin,
            component: admin,
            meta: {
                requiresAuth: true,
                is_admin: true
            }
        },
        {
            path: '/logout',
            name: logout,
            component: logout,
            meta: {
                requiresAuth: true,
            }
        },
    ]
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (localStorage.getItem('Forum.jwt') == null) {
            next({
                path: '/login',
                params: { nextUrl: to.fullPath }
            })
        } else {
            let user = JSON.parse(localStorage.getItem('Forum.user'))
            if (to.matched.some(record => record.meta.is_admin)) {
                if (user.is_admin == 1) {
                    next()
                }
                else {
                    next({ name: 'userboard' })
                }
            }
            else if (to.matched.some(record => record.meta.is_user)) {
                if (user.is_admin == 0) {
                    next()
                }
                else {
                    next({ name: 'admin' })
                }
            }
            next()
        }
    } else {
        next()
    }
})      

export default router;