<template>
    <Head title="Главная" />

    <component :is="isAuthenticated ? AuthenticatedLayout : NotLoginLayout">
        <div class="container mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <p>Здесь будет страница о главном</p>
        </div>
    </component>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NotLoginLayout from '@/Layouts/NotLoginLayout.vue';
import { Head } from '@inertiajs/vue3';

// eslint-disable-next-line no-unused-vars
const props = defineProps({
    isAuthenticated: Boolean,
});
</script>
