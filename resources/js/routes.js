import { createRouter, createWebHashHistory } from 'vue-router';
import axios from 'axios';
import Home from './Pages/Home.vue';
import Login from './Pages/Login.vue';

const routes = [
    {
        path: '/:page?',
        component: Home,
        meta: { requiresAuth: true }
    },
    {
        path: '/login',
        component: Login,
        meta: { requiresGuest: true }
    },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

const checkAuthentication = () => {
    return new Promise((resolve, reject) => {
        axios.get('/api/user', {
            headers: { Authorization: `Bearer ${window.localStorage.getItem('token')}` }
        }).then((response) => {
            resolve(response.status === 200)
        }).catch(() => reject(false))
    })
};

router.beforeEach(async (to, from, next) => {
    const isAuthenticated = await checkAuthentication().catch(err => err);

    if (to.meta.requiresAuth && !isAuthenticated) {
        return next({ path: '/login', query: { redirect: to.fullPath }})
    }

    next()
});


export default router;
