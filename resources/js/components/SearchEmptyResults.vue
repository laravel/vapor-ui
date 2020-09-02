<template>
    <div>
        <div class="flex items-center justify-center">
            <document-icon size="16" />
        </div>

        <div class="mt-4 text-center max-w-xl mx-auto">
            <slot></slot>
        </div>
    </div>
</template>

<script>
import DocumentIcon from './icons/DocumentIcon';

export default {
    components: {
        DocumentIcon,
    },
};
</script>
