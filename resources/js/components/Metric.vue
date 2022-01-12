<template>
    <div class="border-t border-gray-200 md:border-0 md:border-l">
        <div class="px-4 py-5 sm:p-6">
            <dl>
                <dt class="text-base leading-6 font-normal text-gray-900">
                    <popover v-if="description">
                        <template slot="button">
                            {{ title }}
                        </template>
                        <template slot="content">
                            {{ description }}
                        </template>
                    </popover>

                    <template v-else>
                        {{ title }}
                    </template>
                </dt>
                <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                    <div class="flex items-baseline text-2xl leading-8 font-semibold text-indigo-600">
                        <icon-loader v-if="value === undefined" />

                        <template v-else>
                            {{ formatQuantity(value) }}
                            <popover v-if="average != undefined" placement="bottom">
                                <template slot="button">
                                    <span v-if="average > 0" class="ml-2 text-sm leading-5 font-medium text-gray-500">
                                        Usually {{ formatQuantity(average) }} / hr
                                    </span>
                                </template>
                                <template slot="content">
                                    {{ 'Average based in the last 24 hours prior to the current hour.' }}
                                </template>
                            </popover>
                        </template>
                    </div>
                    <div
                        v-if="percentage() != 0.0"
                        class="inline-flex items-baseline px-2.5 py-0.5 rounded-full text-sm font-medium leading-5 md:mt-2 lg:mt-0"
                        :class="
                            percentage() > 0.0
                                ? `bg-${increaseColor}-100 text-${increaseColor}-800`
                                : `bg-${decreaseColor}-100 text-${decreaseColor}-800`
                        "
                    >
                        <icon-arrow-up
                            v-if="percentage() > 0.0"
                            class="-ml-1 mr-0.5 flex-shrink-0 self-center"
                            :class="`text-${increaseColor}-500`"
                            size="4"
                        />
                        <icon-arrow-down
                            v-else
                            class="-ml-1 mr-0.5 flex-shrink-0 self-center"
                            :class="`text-${decreaseColor}-500`"
                            size="4"
                        />
                        <span class="sr-only"> Increased/Decreased by </span>
                        {{ formatQuantity(percentage()) }}%
                    </div>
                </dd>
            </dl>
        </div>
    </div>
</template>

<script>
import InteractsWithQuantity from './../mixins/interactsWithQuantity';

export default {
    /**
     * The component's mixins.
     */
    mixins: [InteractsWithQuantity],

    /**
     * The component's name.
     */
    name: 'Metric',

    /**
     * The component's props.
     */
    props: {
        title: {
            type: [String],
            required: true,
        },
        description: {
            type: [String],
            required: false,
        },
        value: {
            type: [String, Number],
            required: false,
        },
        increaseColor: {
            type: [String],
            required: false,
            default: 'green',
        },
        decreaseColor: {
            type: [String],
            required: false,
            default: 'gray',
        },
        average: {
            type: [String, Number],
            required: false,
        },
    },

    /**
     * The component's methods.
     */
    methods: {
        /**
         * Gets the increase percentage.
         */
        percentage() {
            if (this.average === undefined || this.average <= 0.0) {
                return 0.0;
            }

            return (((this.value - this.average) / this.average) * 100).toFixed(1);
        },
    },
};
</script>
