<template>
    <modal>
        {{person.name}}
    </modal>
</template>

<script setup>
import Modal from '@/Components/Modal.vue';

defineProps({
    person: Array,
});
</script>
