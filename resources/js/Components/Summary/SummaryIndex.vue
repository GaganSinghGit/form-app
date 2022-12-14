<template>
    <StepperBar
        class="max-w-md mx-auto mt-10"
        :personalInformationId="parseInt($route.params.id)"
    ></StepperBar>
    <div v-if="!isLoading" class="max-w-md mx-auto my-10">
        <span class="font-bold text-xl">Summary</span>
        <br />
        <router-link class="text-green-600" :to="{ name: 'Records' }"
            >Back to Records</router-link
        >
        <div class="mt-10">
            <p class="font-bold pb-1">Personal Information</p>
            <p>Full Name: {{ summary.first_name }} {{ summary.last_name }}</p>
            <p>Date of Birth: {{ summary.date_of_birth }}</p>
        </div>
        <div class="pt-4">
            <p class="font-bold pb-1">Work Experience</p>
            <div
                v-for="workExperience in summary.work_experience"
                :key="workExperience.id"
                class="pb-4"
            >
                <p>Company: {{ workExperience.company_name }}</p>
                <p>Position: {{ workExperience.position }}</p>
                <p>Start Date: {{ workExperience.start_date }}</p>
            </div>
        </div>
        <div class="pt-4" v-if="summary.email_preferences">
            <p class="font-bold pb-1">Email Preferences</p>
            <table class="text-centre">
                <thead>
                    <tr>
                        <th class="pr-2">Marketing</th>
                        <th class="pr-2">Special Deals</th>
                        <th class="pr-2">NewsLetter</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-2">
                            <div
                                class="w-4 h-4 rounded-lg mx-auto"
                                :class="
                                    summary.email_preferences.marketing
                                        ? 'bg-green-600'
                                        : 'bg-red-600'
                                "
                            ></div>
                        </td>
                        <td>
                            <div
                                class="w-4 h-4 rounded-lg mx-auto"
                                :class="
                                    summary.email_preferences.special_deals
                                        ? 'bg-green-600'
                                        : 'bg-red-600'
                                "
                            ></div>
                        </td>
                        <td>
                            <div
                                class="w-4 h-4 rounded-lg mx-auto"
                                :class="
                                    summary.email_preferences.news_letter
                                        ? 'bg-green-600'
                                        : 'bg-red-600'
                                "
                            ></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { useRoute } from "vue-router";
import { ref } from "vue";
import StepperBar from "../ReuseableComponents/StepperBar.vue";
export default {
    components: {
        StepperBar,
    },
    setup() {
        const summary = ref({});
        const isLoading = ref(true);
        const route = useRoute();
        const getSummary = async function () {
            const { data: res } = await axios.get(
                `/api/records-api/summary/${route.params.id}`
            );
            summary.value = res;
            console.log(res);
            isLoading.value = false;
        };
        getSummary();
        return {
            summary,
            isLoading,
        };
    },
};
</script>
<style>
</style>