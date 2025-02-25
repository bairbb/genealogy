<script setup>
import Tree from './Tree.vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';

// eslint-disable-next-line no-unused-vars
const props = defineProps({
    persons: Array,
});

const scale = ref(1);
const transitionCss = ref('');

function zoom(event) {
    scale.value += event.deltaY * -0.01;

    // Restrict scale
    scale.value = Math.min(Math.max(0.125, scale.value), 2);

    // Apply scale transform
    transitionCss.value = `scale(${scale.value})`;
}


</script>

<template>
    <Head title="Генеалогическое дерево" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl leading-tight font-semibold text-gray-800">
                Генеалогическое дерево Бооблэй Баяндай
            </h2>
        </template>

        <div
            @wheel.prevent="zoom"
            :style="{ transform: transitionCss }"
            class=" max-h-[2000px] w-full"
        >
            <Tree v-for="person in persons" :key="person.id" :person="person" />
        </div>
    </AuthenticatedLayout>
</template>
