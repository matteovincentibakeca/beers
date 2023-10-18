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
    try {
        await axios.get('/sanctum/csrf-cookie');
        const checkAuth = await axios.get('/api/user').catch(e => e);
        return checkAuth.status === 200;
    } catch (e) {
        throw e
    }
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
        if (error.response && error.response.status === 401) {
            // Handle 401 error specifically. For example, you might want to show a notification.
            next({ path: '/login', query: { redirect: to.fullPath } });
        } else {
            // Handle other errors.
            console.error("Error while checking authentication:", error);
            next({ path: '/error' }); // Consider redirecting to a general error page
        }
    }
});


export default router;
