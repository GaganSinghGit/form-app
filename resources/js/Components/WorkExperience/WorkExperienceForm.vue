<template>
    <div>
        <div class="flex flex-col">
            <label>Company name</label>
            <input v-model="companyName" type="text" />
        </div>
        <div class="flex flex-col mt-2">
            <label>Position</label>
            <input v-model="position" type="text" />
        </div>
        <div class="flex mt-2">
            <label>Currently Working</label>
            <input class="ml-4" type="checkbox" @change="handleCurrentlyWorking" />
        </div>
        <div class="flex flex-col w-1/3 mt-2">
            <label>Start Date</label>
            <DateInput :date="startDate" @date-updated="(date) => updateStartDate(date)" />
        </div>
        <div v-if="!currentlyWorking" class="flex flex-col w-1/3 mt-2">
            <label>End Date</label>
            <DateInput :date="endDate" @date-updated="(date) => updateEndDate(date)" />
        </div>
        <div class="flex pt-2">
            <button v-if="!isAdding" class="bg-gray-500 p-2 rounded-lg mr-2 ml-auto border border-green-600 text-white"
                @click="deleteWorkExperience">
                Delete
            </button>
            <button v-if="isAdding" class="bg-green-600 p-2 rounded-lg text-white ml-auto" @click="addWorkExperience">
                Add
            </button>
            <button v-else class="bg-green-600 p-2 rounded-lg text-white" @click="updateWorkExperience">
                Save
            </button>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { ref } from "vue";
import DateInput from "../ReuseableComponents/DateInput.vue";
export default {
    components: {
        DateInput,
    },
    props: {
        personalInformationId: {
            type: Number,
            required: true,
        },
        workExperience: {
            type: Object,
            default: null,
        },
        isAdding: {
            type: Boolean,
            default: false,
        }
    },
    emits: ['addedWorkExperience', 'deleteWorkExperience'],
    setup(props, { emit }) {
        const companyName = ref(props.isAdding ? "" : props.workExperience.company_name);
        const position = ref(props.isAdding ? "" : props.workExperience.position);
        const startDate = ref(props.isAdding ? "" : props.workExperience.start_date);
        const endDate = ref(props.isAdding ? "" : props.workExperience.end_date);
        const currentlyWorking = ref(false);
        const addWorkExperience = async function () {
            await axios.post(
                `/api/records-api/work-experience/${props.personalInformationId}/create`,
                {
                    company_name: companyName.value,
                    position: position.value,
                    start_date: startDate.value,
                    end_date: currentlyWorking.value ? null : endDate.value,
                    currently_working: currentlyWorking.value,
                }
            );
            emit('addedWorkExperience');
        };
        const updateWorkExperience = async function () {
            await axios.post(
                `/api/records-api/work-experience/${props.workExperience.id}/update`,
                {
                    company_name: companyName.value,
                    position: position.value,
                    start_date: startDate.value,
                    end_date: currentlyWorking.value ? null : endDate.value,
                    currently_working: currentlyWorking.value,
                }
            );
        };
        const deleteWorkExperience = async function () {
            emit('deleteWorkExperience', props.workExperience.id);
        };
        const updateStartDate = function (date) {
            startDate.value = date;
        };
        const updateEndDate = function (date) {
            endDate.value = date;
        };
        const handleCurrentlyWorking = function (e) {
            currentlyWorking.value = e.target.checked;
        };
        return {
            addWorkExperience,
            companyName,
            position,
            startDate,
            endDate,
            updateStartDate,
            updateEndDate,
            handleCurrentlyWorking,
            currentlyWorking,
            deleteWorkExperience,
            updateWorkExperience,
        };
    },
};
</script>
<style>

</style>
