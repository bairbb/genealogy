<template>
    <div class="">
        <div class="m-2 flex-col justify-center border border-gray-400 p-2">
<!--            <a :href="route('persons.show', person.id)">-->
            <div class="place-items-center border border-blue-200 p-4">
                <p>{{ person.name }} {{ person.lastname }}</p>
                <p>( {{ person.birth_year }} - {{ person.death_year || 'н.в.' }} )</p>
            </div>
<!--            </a>-->
        </div>
        <div v-if="person.children" class="flex">
            <PersonNode
                v-for="child in person.children"
                :key="child.id"
                :person="child"
            />
        </div>
    </div>
</template>

<script setup>
defineProps({
    person: Array,
});
</script>
