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

const checkAuthentication = async () => {
    await axios.get('/sanctum/csrf-cookie');
    const checkAuth = await axios.get('/api/user');
    return checkAuth.status === 200;
};

router.beforeEach(async (to, from, next) => {
    try {
        const isAuthenticated = await checkAuthentication();

        if (to.matched.some(record => record.meta.requiresAuth) && !isAuthenticated) {
            next({ path: '/login', query: { redirect: to.fullPath } });
        } else if (to.matched.some(record => record.meta.requiresGuest) && isAuthenticated) {
            next({ path: '/' });
        } else {
            next();
        }
    } catch (error) {
        next({ path: '/login', query: { redirect: to.fullPath } });
    }
});

export default router;
