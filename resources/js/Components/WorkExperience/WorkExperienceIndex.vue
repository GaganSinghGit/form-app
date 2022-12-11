<template>
    <div class="mt-10">
        <span class="text-xl mx-24">Work Experience</span>
        <div class="border border-green-600 mx-24 py-8" v-if="isAdding">
            <div class="flex justify-between items-center max-w-md mx-auto">
                <span class="text-lg">Adding Work Experience</span>
                <button class="text-green-600 py-2" @click="isAdding = false">
                    Cancel
                </button>
            </div>
            <WorkExperienceForm class="max-w-md mx-auto" :personalInformationId="parseInt($route.params.id)"
                :isAdding="true" @addedWorkExperience="handleAddedWorkExperience" />
        </div>
        <div v-else class="mx-24">
            <button class="text-green-600 py-2" @click="isAdding = true">
                Add work experience
            </button>
        </div>
        <div v-if="workExperiences" class="max-w-md mx-auto mt-12">
            <span class="text-lg font-bold">Saved Work Experience</span>
            <WorkExperienceForm v-for="workExperience in workExperiences" :key="workExperience.id"
                :personalInformationId="parseInt($route.params.id)" :workExperience="workExperience"
                @deleteWorkExperience="(id) => deleteWorkExperience(id)" />
            <div class="flex mt-2">
                <button class="ml-auto mr-2 bg-green-600 px-6 py-2 rounded-lg text-white">
                    Back
                </button>
                <button class="bg-green-600 px-6 py-2 rounded-lg text-white">
                    Next
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import WorkExperienceForm from "./WorkExperienceForm.vue";
import { useRoute } from "vue-router";
import { ref } from "vue";
export default {
    components: {
        WorkExperienceForm,
    },
    setup() {
        const route = useRoute();
        const workExperiences = ref([]);
        const isAdding = ref(false);
        const getWorkExperiences = async function () {
            const { data: res } = await axios.get(
                `/api/records-api/work-experience/${route.params.id}/get`
            );
            workExperiences.value = res;
            console.log(res);
        };
        const deleteWorkExperience = function (workExperienceId) {
            axios.delete(
                `/api/records-api/work-experience/${workExperienceId}/delete`
            );
            getWorkExperiences();
        };
        const handleAddedWorkExperience = function () {
            getWorkExperiences();
            isAdding.value = false;
        }
        getWorkExperiences();
        return {
            workExperiences,
            isAdding,
            deleteWorkExperience,
            getWorkExperiences,
            handleAddedWorkExperience,
        };
    },
};
</script>
<style>

</style>
