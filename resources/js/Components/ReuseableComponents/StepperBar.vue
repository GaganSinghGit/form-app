<template>
    <div class="flex justify-between">
        <router-link
            :to="{
                name: 'PersonalInformation',
                params: { id: personalInformationId },
            }"
            >Step 1</router-link
        >
        <router-link
            :to="{
                name: 'WorkExperience',
                params: { id: personalInformationId },
            }"
            >Step 2</router-link
        >
        <router-link
            :to="{
                name: 'EmailPreferences',
                params: { id: personalInformationId },
            }"
            >Step 3</router-link
        >
        <router-link
            :to="{
                name: 'Feedback',
                params: { id: personalInformationId },
            }"
            >Step 4</router-link
        >
        <router-link
            :to="{
                name: 'Summary',
                params: { id: personalInformationId },
            }"
            >Summary</router-link
        >
    </div>
</template>
<script>
export default {
    props: {
        personalInformationId: {
            type: Number,
            required: true,
        },
    },
};
</script>
<style>
</style>