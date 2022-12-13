<template>
    <div>
        <form class="flex flex-col" @submit.prevent="createWorkExperience">
            <label>Company</label>
            <input type="text" v-model="workExperience.companyName" />
            <span
                class="text-xs text-red-600"
                v-if="errors.hasOwnProperty('company_name')"
                >{{ errors.company_name[0] }}</span
            >
            <label class="mt-2">Position</label>
            <input type="text" v-model="workExperience.position" />
            <span
                class="text-xs text-red-600"
                v-if="errors.hasOwnProperty('position')"
                >{{ errors.position[0] }}</span
            >
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
            <span
                class="text-xs text-red-600"
                v-if="errors.hasOwnProperty('start_date')"
                >{{ errors.start_date[0] }}</span
            >
            <div v-if="!workExperience.currentlyWorking">
                <label class="mt-2">End Date</label>
                <DateInput
                    :date="workExperience.endDate"
                    @date-updated="(date) => saveEndDate(date)"
                ></DateInput>
                <span
                    class="text-xs text-red-600"
                    v-if="errors.hasOwnProperty('end_date')"
                    >{{ errors.end_date[0] }}</span
                >
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
        const errors = ref([]);
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
            try {
                await axios.post(
                    `/api/records-api/work-experience/${route.params.id}/create`,
                    {
                        company_name: workExperience.value.companyName,
                        position: workExperience.value.position,
                        currently_working:
                            workExperience.value.currentlyWorking,
                        start_date: workExperience.value.startDate,
                        end_date: workExperience.value.currentlyWorking
                            ? null
                            : workExperience.value.endDate,
                    }
                );
                errors.value = [];
                emit("workExperienceCreated");
            } catch (err) {
                errors.value = err.response.data.errors;
            }
        };
        return {
            workExperience,
            createWorkExperience,
            saveStartDate,
            saveEndDate,
            errors,
        };
    },
};
</script>
<style>
</style>