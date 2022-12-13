<template>
    <div class="max-w-lg mx-auto w-9/12 md:w-1/2 mt-10">
        <div>
            <button class="text-green-600" @click="createNewRecord">
                Add new record
            </button>
        </div>
        <table class="w-full border-collapse bg-white">
            <thead>
                <tr class="border-b">
                    <th class="w-1/5 py-2">Record Id</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th class="w-1/4"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b" v-for="record in records" :key="record.id">
                    <td class="py-2">{{ record.id }}</td>
                    <td>{{ record.first_name }}</td>
                    <td>TODO</td>
                    <td>
                        <div>
                            <button
                                class="mr-2 text-green-600"
                                @click="editRecord(record.id)"
                            >
                                Edit
                            </button>
                            <button
                                class="text-green-600"
                                @click="deleteRecord(record.id)"
                            >
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";
export default {
    setup() {
        const router = useRouter();
        const records = ref();
        const getRecords = async function () {
            const { data: res } = await axios.get(
                "/api/records-api/personal-information/get-all"
            );
            console.log(res);
            records.value = res;
        };
        const deleteRecord = async function (id) {
            await axios.delete(
                `/api/records-api/personal-information/${id}/delete`
            );
            getRecords();
        };
        const createNewRecord = async function () {
            const { data: res } = await axios.get(
                "/api/records-api/personal-information/create"
            );
            router.push({
                name: "PersonalInformation",
                params: {
                    id: res.id,
                },
            });
        };
        const editRecord = function (id) {
            router.push({
                name: "PersonalInformation",
                params: {
                    id: id,
                },
            });
        };
        getRecords();
        return {
            records,
            deleteRecord,
            createNewRecord,
            editRecord,
        };
    },
};
</script>
<style scoped>
td {
    @apply text-center;
}
</style>
