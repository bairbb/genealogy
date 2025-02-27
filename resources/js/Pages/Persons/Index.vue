<script setup>
import Tree from './Tree.vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, reactive } from 'vue';

// eslint-disable-next-line no-unused-vars
const props = defineProps({
    persons: Array,
});

const element = ref(null);

const state = reactive({
    minScale: 0.1,
    maxScale: 30,
    scaleSensitivity: 50,
    transformation: {
        originX: 0,
        originY: 0,
        translateX: 0,
        translateY: 0,
        scale: 1,
    },
});

const hasPositionChanged = ({ pos, prevPos }) => pos !== prevPos;

const valueInRange = ({ minScale, maxScale, scale }) =>
    scale <= maxScale && scale >= minScale;

const getTranslate =
    ({ minScale, maxScale, scale }) =>
    ({ pos, prevPos, translate }) =>
        valueInRange({ minScale, maxScale, scale }) &&
        hasPositionChanged({ pos, prevPos })
            ? translate + (pos - prevPos * scale) * (1 - 1 / scale)
            : translate;

const getScale = ({
    scale,
    minScale,
    maxScale,
    scaleSensitivity,
    deltaScale,
}) => {
    let newScale = scale + deltaScale / (scaleSensitivity / scale);
    newScale = Math.max(minScale, Math.min(newScale, maxScale));
    return [scale, newScale];
};

const getMatrix = ({ scale, translateX, translateY }) =>
    `matrix(${scale}, 0, 0, ${scale}, ${translateX}, ${translateY})`;

function zoom(event) {
    const { left, top } = element.value.getBoundingClientRect();
    const { minScale, maxScale, scaleSensitivity } = state;
    const deltaScale = Math.sign(event.deltaY) > 0 ? -1 : 1;
    const [scale, newScale] = getScale({
        scale: state.transformation.scale,
        deltaScale,
        minScale,
        maxScale,
        scaleSensitivity,
    });
    const originX = event.pageX - left;
    const originY = event.pageY - top;
    const newOriginX = originX / scale;
    const newOriginY = originY / scale;
    const translate = getTranslate({ scale, minScale, maxScale });
    const translateX = translate({
        pos: originX,
        prevPos: state.transformation.originX,
        translate: state.transformation.translateX,
    });
    const translateY = translate({
        pos: originY,
        prevPos: state.transformation.originY,
        translate: state.transformation.translateY,
    });

    element.value.style.transformOrigin = `${newOriginX}px ${newOriginY}px`;
    element.value.style.transform = getMatrix({
        scale: newScale,
        translateX,
        translateY,
    });
    state.transformation = {
        originX: newOriginX,
        originY: newOriginY,
        translateX,
        translateY,
        scale: newScale,
    };
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

        <div @wheel.prevent="zoom" ref="element" class="max-h-[2000px] w-full">
            <Tree v-for="person in persons" :key="person.id" :person="person" />
        </div>
    </AuthenticatedLayout>
</template>
