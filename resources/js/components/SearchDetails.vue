<template>
    <div class="flex-1 relative pb-8 z-0 overflow-y-auto">
        <div class="relative z-10 flex-shrink-0 flex h-16 bg-white border-b border-gray-200 lg:border-none">
            <div class="flex-1 px-4 flex justify-between sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
                <div class="mt-5">
                    <div>
                        <nav class="sm:flex items-center text-sm leading-5 font-medium">
                            <router-link
                                :to="{
                                    name: `${$route.meta.resource}-index`,
                                    query: this.$route.query,
                                    params: { group: $route.params.group },
                                }"
                                class="text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out"
                            >
                                {{
                                    $router
                                        .resolve({ name: `${$route.meta.resource}-index` })
                                        .route.meta.createTitle({ group: $route.params.group })
                                }}
                            </router-link>
                            <icon-chevron-right size="5" class="flex-shrink-0 mx-2 text-gray-400"></icon-chevron-right>
                            <a href="#" class="text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out"
                                >Details</a
                            >
                        </nav>
                    </div>
                </div>
                <div class="mt-3 flex">
                    <transition name="fade">
                        <span class="text-sm leading-5 text-green-500 p-2" v-if="sharing"> Copied to clipboard </span>
                    </transition>
                    <span class="order-1 ml-3 shadow-sm rounded-md sm:order-0 sm:ml-0">
                        <button
                            v-on:click="share(entry)"
                            type="button"
                            class="
                                inline-flex
                                items-center
                                px-4
                                py-2
                                border border-gray-300
                                text-sm
                                leading-5
                                font-medium
                                rounded-md
                                text-gray-700
                                bg-white
                                hover:text-gray-500
                                focus:outline-none focus:shadow-outline-blue focus:border-blue-300
                                active:text-gray-800 active:bg-gray-50
                                transition
                                duration-150
                                ease-in-out
                            "
                        >
                            Share
                        </button>
                    </span>
                    <slot name="actions" :entry="entry"></slot>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
            <!-- Loader -->
            <loader v-if="!ready"></loader>

            <!-- No entry found -->
            <search-empty-results v-if="ready && !entry">Entry not found.</search-empty-results>

            <div v-if="ready && entry" class="max-w-4xl mx-auto">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ $route.meta.title }}
                        </h3>
                    </div>
                    <div class="px-4 py-5 sm:p-0">
                        <dl>
                            <slot name="details" :entry="entry"></slot>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

import ClipboardMixin from './../mixins/clipboard';

export default {
    /**
     * The component's mixins.
     */
    mixins: [ClipboardMixin],

    /**
     * The component's data.
     */
    data() {
        return {
            entry: null,
            ready: false,
            sharing: false,
        };
    },

    /**
     * Prepare the component.
     */
    mounted() {
        axios
            .get(
                `/${window.VaporUi.path}/api/${this.$route.meta.resource}/${this.$route.params.group}/${this.$route.params.id}`,
                {
                    params: this.$route.query,
                    validateStatus: false,
                }
            )
            .then(({ data }) => {
                this.ready = true;
                this.entry = data;
            });
    },

    /**
     * The component's methods.
     */
    methods: {
        /**
         * Copies the given entry to the clipboard.
         */
        share(entry) {
            this.copyToClipboard(
                this.$router.resolve({
                    name: `${this.$route.meta.resource}-show`,
                    params: { id: this.$route.params.id, group: this.$route.params.group },
                    query: this.$route.query,
                }).href
            );

            this.sharing = true;

            setTimeout(() => (this.sharing = false), 2000);
        },
    },
};
</script>
