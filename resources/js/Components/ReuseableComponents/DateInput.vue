<template>
    <div class="flex">
        <input class="w-12" type="number" placeholder="DD" min="1" max="31" @change="handleChange" v-model="day" />
        <input class="w-12 ml-4" type="number" placeholder="MM" min="1" max="12" @change="handleChange"
            v-model="month" />
        <input class="w-16 ml-4" type="number" placeholder="YYYY" min="1900" @change="handleChange" v-model="year" />
    </div>
</template>
<script>
import { ref } from "vue";
export default {
    props: {
        date: {
            typeof: String,
            required: true,
        },
    },
    emits: ["dateUpdated"],
    setup(props, { emit }) {
        const day = ref(1);
        const month = ref(1);
        const year = ref(1900);
        if (props.date != "") {
            const date = new Date(props.date);
            day.value = date.getDate();
            month.value = date.getMonth() + 1;
            year.value = date.getFullYear();
        }
        const formatDate = function (day, month, year) {
            let dateOfBirth = "";
            dateOfBirth += year.toString() + "-";
            if (month < 9) {
                dateOfBirth += "0";
            }
            dateOfBirth += month.toString() + "-";
            if (day < 9) {
                dateOfBirth += "0";
            }
            dateOfBirth += day.toString();
            return dateOfBirth;
        };
        const handleChange = function () {
            emit("dateUpdated", formatDate(day.value, month.value, year.value));
        };
        return {
            day,
            month,
            year,
            handleChange,
        };
    },
};
</script>
<style>

</style>
