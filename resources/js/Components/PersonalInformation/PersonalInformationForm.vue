<template>
    <StepperBar
        class="max-w-md mx-auto mt-10"
        :personalInformationId="parseInt($route.params.id)"
    ></StepperBar>
    <div v-if="!isLoading" class="max-w-md mx-auto mt-10">
        <span class="text-xl">Personal Information</span>
        <div class="flex flex-col pt-4">
            <label>First name</label>
            <input type="text" v-model="personalInformation.firstName" />
        </div>
        <span
            v-if="errors.hasOwnProperty('first_name')"
            class="text-xs text-red-600"
            >{{ errors.first_name[0] }}</span
        >
        <div class="flex flex-col mt-2">
            <label>Last name</label>
            <input type="text" v-model="personalInformation.lastName" />
        </div>
        <span
            v-if="errors.hasOwnProperty('last_name')"
            class="text-xs text-red-600"
            >{{ errors.last_name[0] }}</span
        >
        <div class="flex flex-col mt-2">
            <label>Date of Birth</label>
            <DateInput
                :date="personalInformation.dateOfBirth ?? ''"
                @date-updated="(date) => saveDateOfBirth(date)"
            />
        </div>
        <span
            v-if="errors.hasOwnProperty('date_of_birth')"
            class="text-xs text-red-600"
            >{{ errors.date_of_birth[0] }}</span
        >
        <div class="flex mt-2">
            <button
                class="ml-auto bg-green-600 px-6 py-2 rounded-lg text-white"
                @click="submitForm"
            >
                Next
            </button>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import DateInput from "../ReuseableComponents/DateInput.vue";
import StepperBar from "../ReuseableComponents/StepperBar.vue";
export default {
    components: {
        DateInput,
        StepperBar,
    },
    setup() {
        const route = useRoute();
        const router = useRouter();
        const errors = ref([]);
        const personalInformation = ref({
            firstName: "",
            lastName: "",
            dateOfBirth: "",
        });
        const isLoading = ref(true);
        const saveDateOfBirth = function (date) {
            personalInformation.value.dateOfBirth = date;
        };
        const getPersonalInformation = async function () {
            try {
                const { data: res } = await axios.get(
                    `/api/records-api/personal-information/${route.params.id}/get`
                );
                personalInformation.value.firstName = res.first_name;
                personalInformation.value.lastName = res.last_name;
                personalInformation.value.dateOfBirth = res.date_of_birth;
                isLoading.value = false;
                errors.value = [];
            } catch (err) {
                if (err.response.status === 404) {
                    router.push({ name: "Records" });
                }
                errors.value = err.response.data.errors;
            }
        };
        const submitForm = async function () {
            try {
                await axios.post(
                    `/api/records-api/personal-information/${route.params.id}/update`,
                    {
                        first_name: personalInformation.value.firstName,
                        last_name: personalInformation.value.lastName,
                        date_of_birth: personalInformation.value.dateOfBirth,
                    }
                );
                router.push({
                    name: "WorkExperience",
                    params: { id: route.params.id },
                });
            } catch (err) {
                errors.value = err.response.data.errors;
            }
        };
        getPersonalInformation();
        return {
            submitForm,
            personalInformation,
            saveDateOfBirth,
            isLoading,
            errors,
        };
    },
};
</script>
<style>
</style>
