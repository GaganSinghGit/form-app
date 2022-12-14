<template>
    <StepperBar
        class="max-w-md mx-auto mt-10"
        :personalInformationId="parseInt($route.params.id)"
    ></StepperBar>
    <div class="max-w-md mx-auto pt-10">
        <div class="flex">
            <button
                class="ml-auto bg-green-600 px-6 py-2 rounded-lg text-white"
                @click="goToSummary"
            >
                Finish
            </button>
        </div>

        <form @submit.prevent="saveFeedback" class="flex flex-col">
            <label>Rate your experience</label>
            <input type="range" min="0" max="10" step="1" v-model="rating" />
            <label class="pt-2">Any FeedBack?</label>
            <textarea v-model="feedback"></textarea>
            <span
                class="text-xs text-red-600"
                v-if="errors.hasOwnProperty('feedback_text')"
                >{{ errors.feedback_text[0] }}</span
            >
            <button
                class="
                    ml-auto
                    mt-2
                    bg-green-600
                    px-6
                    py-2
                    rounded-lg
                    text-white
                "
                type="submit"
            >
                Save
            </button>
        </form>
    </div>
</template>
<script>
import { ref, watch } from "vue";
import { useRoute, useRouter, onBeforeRouteLeave } from "vue-router";
import StepperBar from "../ReuseableComponents/StepperBar.vue";
import axios from "axios";
export default {
    components: {
        StepperBar,
    },
    setup() {
        const route = useRoute();
        const router = useRouter();
        const rating = ref(null);
        const feedback = ref(null);
        const errors = ref([]);
        const unsavedChanges = ref(false);
        const getFeedback = async function () {
            const { data: res } = await axios.get(
                `/api/records-api/feedback/${route.params.id}/get`
            );
            rating.value = res.rating ?? null;
            feedback.value = res.feedback_text ?? null;
        };
        const saveFeedback = async function () {
            try {
                await axios.post(
                    `/api/records-api/feedback/${route.params.id}/create`,
                    {
                        rating: parseInt(rating.value),
                        feedback_text: feedback.value,
                    }
                );
                errors.value = [];
                unsavedChanges.value = false;
            } catch (err) {
                errors.value = err.response.data.errors;
            }
        };
        const goToSummary = async function () {
            router.push({
                name: "Summary",
                params: { id: route.params.id },
            });
        };
        onBeforeRouteLeave((to, from, next) => {
            if (unsavedChanges.value) {
                const answer = window.confirm(
                    "Do you really want to leave? you have unsaved changes!"
                );
                if (answer) {
                    next();
                } else {
                    next(false);
                }
                return;
            }
            next();
        });
        getFeedback();
        watch(rating, (newValue, oldValue) => {
            if (oldValue !== null) {
                unsavedChanges.value = true;
            }
        });
        watch(feedback, (newValue, oldValue) => {
            if (oldValue !== null) {
                unsavedChanges.value = true;
            }
        });
        return {
            rating,
            feedback,
            goToSummary,
            saveFeedback,
            errors,
        };
    },
};
</script>
<style>
</style>