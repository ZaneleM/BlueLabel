<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import PersonPage from "@/Components/PersonPage.vue";
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                People
            </h2>
        </template>

       <person-page></person-page>
    </BreezeAuthenticatedLayout>
</template>
