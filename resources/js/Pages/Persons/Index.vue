<template>
    <Head title="Генеалогическое дерево" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Генеалогическое дерево
            </h2>
        </template>

        <div class="container mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex justify-center">
                <PersonNode
                    v-for="person in persons"
                    :key="person.id"
                    :person="person"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PersonNode from './PersonNode.vue';

defineProps({
    persons: Array,
});
</script>
