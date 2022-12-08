import { createRouter, createWebHistory } from 'vue-router';
import test from '../Components/test.vue';

const routes = [
    {
        path:'/test',
        name:'test',
        component: test,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;