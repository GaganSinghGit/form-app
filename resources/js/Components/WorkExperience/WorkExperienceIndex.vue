<template>
    <StepperBar
        class="max-w-md mx-auto mt-10"
        :personalInformationId="parseInt($route.params.id)"
    ></StepperBar>
    <div class="my-10 mx-24">
        <div class="flex justify-between">
            <span class="text-xl">Work Experience</span>
            <div class="flex mt-2">
                <button
                    @click="goBack"
                    class="
                        ml-auto
                        mr-2
                        bg-green-600
                        px-6
                        py-2
                        rounded-lg
                        text-white
                    "
                >
                    Back
                </button>
                <button
                    @click="goToEmailPreferences"
                    class="bg-green-600 px-6 py-2 rounded-lg text-white"
                >
                    Next
                </button>
            </div>
        </div>
        <div v-if="isAdding" class="border border-green-600 py-8 my-10">
            <div class="flex justify-between items-center max-w-md mx-auto">
                <span class="text-lg">Adding Work Experience</span>
                <button class="text-green-600 py-2" @click="isAdding = false">
                    Cancel
                </button>
            </div>
            <WorkExperienceForm
                @workExperienceCreated="handleWorkExperienceCreated"
                class="max-w-md mx-auto"
            />
        </div>
        <div v-else>
            <button class="text-green-600 py-2" @click="isAdding = true">
                Add work experience
            </button>
        </div>
        <div v-if="workExperiences" class="max-w-md mx-auto mt-12">
            <div>
                <span class="text-lg font-bold">Saved Work Experience</span>
            </div>
            <div
                class="pt-2"
                v-for="(workExperience, index) in workExperiences"
                :key="index"
            >
                <div>
                    <span>Work experience {{ index + 1 }}</span>
                    <button
                        class="text-green-600 ml-10"
                        @click="deleteWorkExperience(workExperience.id)"
                    >
                        Delete
                    </button>
                </div>
                <p>Company name: {{ workExperience.company_name }}</p>
                <p>Position: {{ workExperience.position }}</p>
                <p>Start date: {{ workExperience.start_date }}</p>
                <p v-if="!workExperience.currently_working">
                    End Date: {{ workExperience.end_date }}
                </p>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import WorkExperienceForm from "./WorkExperienceForm.vue";
import { useRoute, useRouter } from "vue-router";
import { ref } from "vue";
import StepperBar from "../ReuseableComponents/StepperBar.vue";
export default {
    components: {
        WorkExperienceForm,
        StepperBar,
    },
    setup() {
        const route = useRoute();
        const router = useRouter();
        const workExperiences = ref([]);
        const isAdding = ref(false);
        const getWorkExperiences = async function () {
            try {
                const { data: res } = await axios.get(
                    `/api/records-api/work-experience/${route.params.id}/get`
                );
                workExperiences.value = res;
                console.log(res);
            } catch (err) {
                if (err.response.status === 404) {
                    router.push({ name: "Records" });
                }
            }
        };
        const deleteWorkExperience = function (workExperienceId) {
            axios.delete(
                `/api/records-api/work-experience/${workExperienceId}/delete`
            );
            getWorkExperiences();
        };
        const handleWorkExperienceCreated = function () {
            getWorkExperiences();
            isAdding.value = false;
        };
        const goBack = function () {
            router.push({
                name: "PersonalInformation",
                params: { id: route.params.id },
            });
        };
        const goToEmailPreferences = function () {
            router.push({
                name: "EmailPreferences",
                params: { id: route.params.id },
            });
        };
        getWorkExperiences();
        return {
            workExperiences,
            isAdding,
            deleteWorkExperience,
            getWorkExperiences,
            handleWorkExperienceCreated,
            goBack,
            goToEmailPreferences,
        };
    },
};
</script>
<style>
</style>
