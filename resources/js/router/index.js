import { createRouter, createWebHistory } from "vue-router";
import test from "../Components/test.vue";
import PersonalInformationForm from "../Components/PersonalInformationForm.vue";
import WorkExperienceIndex from "../Components/WorkExperience/WorkExperienceIndex.vue";
import Records from "../Components/Records.vue";
const routes = [
    {
        path: "/test",
        name: "test",
        component: test,
    },
    {
        path: "/records",
        name: "Records",
        component: Records,
    },
    {
        path: "/personal-information/:id",
        name: "PersonalInformation",
        component: PersonalInformationForm,
    },
    {
        path: "/work-experience/:id",
        name: "WorkExperience",
        component: WorkExperienceIndex,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return { left: 0, top: 0 };
        }
    },
});

export default router;
