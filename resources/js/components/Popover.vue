<template>
    <popper
        trigger="clickToOpen"
        :options="{
            placement: placement,
            modifiers: { offset: { offset: '0,10px' } },
        }"
    >
        <div class="popper">
            <p class="m-1 text-sm leading-5 text-gray-500">
                <slot name="content" />
            </p>
        </div>

        <div slot="reference" class="cursor-pointer">
            <slot name="button" />
        </div>
    </popper>
</template>

<script>
import Popper from 'vue-popperjs';
import 'vue-popperjs/dist/vue-popper.css';

export default {
    /**
     * Component's components.
     */
    components: {
        popper: Popper,
    },

    /**
     * The component's props.
     */
    props: {
        placement: {
            type: [String],
            required: false,
            default: 'top',
        },
    },
};
</script>
