<template>
    <svg fill="currentColor" viewBox="0 0 20 20" :class="sizeClass">
        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
    </svg>
</template>

<script>
import Sizable from './Sizable';

export default {
    mixins: [Sizable],
};
</script>
