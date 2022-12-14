<template>
    <StepperBar
        class="max-w-md mx-auto mt-10"
        :personalInformationId="parseInt($route.params.id)"
    ></StepperBar>
    <div class="max-w-md mx-auto my-10">
        <span>Email Preferences</span>
        <div>
            <label>Want to receive marketing emails?</label>
            <select v-model="emailPreferences.marketing">
                <option :value="false">No</option>
                <option :value="true">Yes</option>
            </select>
        </div>
        <div>
            <label>Want to be notified about special deal emails?</label>
            <select v-model="emailPreferences.specialDeals">
                <option :value="false">No</option>
                <option :value="true">Yes</option>
            </select>
        </div>
        <div>
            <label>Want signup for out newsletter?</label>
            <select v-model="emailPreferences.newsLetter">
                <option :value="false">No</option>
                <option :value="true">Yes</option>
            </select>
        </div>
        <div class="flex">
            <button
                @click="saveEmailPreferences"
                class="ml-auto bg-green-600 px-6 py-2 rounded-lg text-white"
            >
                Next
            </button>
        </div>
    </div>
</template>
<script>
import { ref } from "vue";
import axios from "axios";
import { useRoute, useRouter } from "vue-router";
import StepperBar from "../ReuseableComponents/StepperBar.vue";
export default {
    components: {
        StepperBar,
    },
    setup() {
        const route = useRoute();
        const router = useRouter();
        const emailPreferences = ref({
            marketing: false,
            specialDeals: false,
            newsLetter: false,
        });
        const saveEmailPreferences = async function () {
            await axios.post(
                `/api/records-api/email-preferences/${route.params.id}/update`,
                {
                    marketing: emailPreferences.value.marketing,
                    special_deals: emailPreferences.value.specialDeals,
                    news_letter: emailPreferences.value.newsLetter,
                }
            );
            router.push({
                name: "Feedback",
                params: {
                    id: route.params.id,
                },
            });
        };
        const getEmailPreferences = async function () {
            const { data: res } = await axios.get(
                `/api/records-api/email-preferences/${route.params.id}/get`
            );
            emailPreferences.value.marketing = res.marketing ? true : false;
            emailPreferences.value.specialDeals = res.special_deals
                ? true
                : false;
            emailPreferences.value.newsLetter = res.news_letter ? true : false;
        };
        getEmailPreferences();
        return {
            emailPreferences,
            saveEmailPreferences,
            getEmailPreferences,
        };
    },
};
</script>
<style>
</style>