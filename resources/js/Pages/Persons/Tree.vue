<script setup>
// eslint-disable-next-line no-unused-vars
const props = defineProps({
    person: Object,
});
</script>

<template>
    <div class="not-last:mr-4">
        <div class="mb-4 flex gap-2 justify-center rounded border border-gray-400 p-2">
            <div class="place-items-center rounded border border-blue-200 p-4">
                <img
                    v-if="person.image_path"
                    :src="person.image_path"
                    :alt="person.name"
                    class="h-20 rounded-full"
                />
                <p>{{ person.name }} {{ person.lastname }}</p>
                <p>
                    {{ person.birth_year }} -
                    {{ person.death_year || 'н.в.' }}
                </p>
            </div>
            <div v-for="spouse in person.spouses" class="place-items-center rounded border border-blue-200 p-4">
                <p>{{ spouse.name }} {{ spouse.lastname }}</p>
                <p>
                    ( {{ spouse.birth_year }} -
                    {{ spouse.death_year || 'н.в.' }} )
                </p>
                <p v-if="spouse.gender === 'male'">Муж</p>
                <p v-else>Жена</p>
            </div>
        </div>
        <div class="mb-4">
            <div v-if="person.children" class="flex">
                <Tree
                    v-for="child in person.children"
                    :key="child.id"
                    :person="child"
                />
            </div>
        </div>
    </div>
</template>
