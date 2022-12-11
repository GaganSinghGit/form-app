<template>
    <div v-if="!loading" class="max-w-md mx-auto mt-10">
        <form @submit.prevent="submitForm">
            <div class="flex flex-col">
                <label>First name</label>
                <input type="text" v-model="firstName" />
            </div>
            <div class="flex flex-col mt-2">
                <label>Last name</label>
                <input type="text" v-model="lastName" />
            </div>
            <div class="flex flex-col mt-2">
                <label>Date of Birth</label>
                <DateInput :date="dateOfBirth" @date-updated="(date) => saveDateOfBirth(date)" />
            </div>
            <div class="flex mt-2">
                <button class="ml-auto bg-green-600 px-6 py-2 rounded-lg text-white">
                    Next
                </button>
            </div>
        </form>
    </div>
</template>
<script>
import axios from "axios";
import { ref } from "vue";
import { useRoute } from "vue-router";
import DateInput from "./ReuseableComponents/DateInput.vue";
export default {
    components: {
        DateInput,
    },
    setup() {
        const route = useRoute();
        const loading = ref(true);
        const firstName = ref("");
        const lastName = ref("");
        const dateOfBirth = ref("");
        const saveDateOfBirth = function (date) {
            dateOfBirth.value = date;
        };
        const getPersonalInformation = async function () {
            const { data: res } = await axios.get(
                `/api/records-api/personal-information/${route.params.id}/get`
            );
            firstName.value = res.first_name;
            lastName.value = res.last_name;
            dateOfBirth.value = res.date_of_birth;
            console.log(dateOfBirth.value);
            loading.value = false;
        };
        const submitForm = async function () {
            await axios.post(
                `/api/records-api/personal-information/${route.params.id}/update`,
                {
                    first_name: firstName.value,
                    last_name: lastName.value,
                    date_of_birth: dateOfBirth.value,
                }
            );
        };
        getPersonalInformation();
        return {
            submitForm,
            firstName,
            lastName,
            dateOfBirth,
            saveDateOfBirth,
            loading,
        };
    },
};
</script>
<style>

</style>
