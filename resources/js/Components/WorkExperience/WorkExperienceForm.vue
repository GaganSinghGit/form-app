<template>
    <div>
        <form class="flex flex-col" @submit.prevent="createWorkExperience">
            <label>Company</label>
            <input type="text" v-model="workExperience.companyName" />
            <label class="mt-2">Position</label>
            <input type="text" v-model="workExperience.position" />
            <div class="flex mt-2">
                <label>Currently Working</label>
                <input
                    type="checkbox"
                    class="ml-2"
                    v-model="workExperience.currentlyWorking"
                />
            </div>
            <label class="mt-2">Start Date</label>
            <DateInput
                :date="workExperience.startDate"
                @date-updated="(date) => saveStartDate(date)"
            ></DateInput>
            <div v-if="!workExperience.currentlyWorking">
                <label class="mt-2">End Date</label>
                <DateInput
                    :date="workExperience.endDate"
                    @date-updated="(date) => saveEndDate(date)"
                ></DateInput>
            </div>
            <div class="ml-auto">
                <button
                    class="bg-green-600 px-6 py-2 rounded-lg text-white"
                    type="submit"
                >
                    Save
                </button>
            </div>
        </form>
    </div>
</template>
<script>
import { ref } from "vue";
import DateInput from "../ReuseableComponents/DateInput.vue";
import { useRoute } from "vue-router";
export default {
    components: {
        DateInput,
    },
    emits: ["workExperienceCreated"],
    setup(props, { emit }) {
        const route = useRoute();
        const workExperience = ref({
            companyName: "",
            position: "",
            currentlyWorking: false,
            startDate: "",
            endDate: "",
        });
        const saveStartDate = function (date) {
            workExperience.value.startDate = date;
        };
        const saveEndDate = function (date) {
            workExperience.value.endDate = date;
        };
        const createWorkExperience = async function () {
            await axios.post(
                `/api/records-api/work-experience/${route.params.id}/create`,
                {
                    company_name: workExperience.value.companyName,
                    position: workExperience.value.position,
                    currently_working: workExperience.value.currentlyWorking,
                    start_date: workExperience.value.startDate,
                    end_date: workExperience.value.currentlyWorking
                        ? null
                        : workExperience.value.endDate,
                }
            );
            emit("workExperienceCreated");
        };
        return {
            workExperience,
            createWorkExperience,
            saveStartDate,
            saveEndDate,
        };
    },
};
</script>
<style>
</style>