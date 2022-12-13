import { createRouter, createWebHistory } from "vue-router";
import PersonalInformationForm from "../Components/PersonalInformation/PersonalInformationForm.vue";
import WorkExperienceIndex from "../Components/WorkExperience/WorkExperienceIndex.vue";
import RecordsIndex from "../Components/Records/RecordsIndex.vue";
import SummaryIndex from "../Components/Summary/SummaryIndex.vue";
import EmailPreferences from "../Components/EmailPreferences/EmailPreferences.vue";
import FeedbackIndex from "../Components/Feedback/FeedbackIndex.vue";
const routes = [
    {
        path: "/",
        redirect: "/records",
    },
    {
        path: "/records",
        name: "Records",
        component: RecordsIndex,
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
    {
        path: "/summary/:id",
        name: "Summary",
        component: SummaryIndex,
    },
    {
        path: "/email-preferences/:id",
        name: "EmailPreferences",
        component: EmailPreferences,
    },
    {
        path: "/feedback/:id",
        name: "Feedback",
        component: FeedbackIndex,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: "active",
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return { left: 0, top: 0 };
        }
    },
});

export default router;
