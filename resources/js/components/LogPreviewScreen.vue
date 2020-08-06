<template>
    <div class="flex-1 relative pb-8 z-0 overflow-y-auto">
        <div class="relative z-10 flex-shrink-0 flex h-16 bg-white border-b border-gray-200 lg:border-none">
            <div class="flex-1 px-4 flex justify-between sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
                <div class="mt-5">
                    <div>
                        <nav class="sm:hidden">
                            <router-link
                                :to="{ name: `logs-${group}-list`, query: filters }"
                                class="flex items-center text-sm leading-5 font-medium text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out"
                            >
                                <svg
                                    class="flex-shrink-0 -ml-1 mr-1 h-5 w-5 text-gray-400"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Back
                            </router-link>
                        </nav>
                        <nav class="hidden sm:flex items-center text-sm leading-5 font-medium">
                            <router-link
                                :to="{ name: `logs-${group}-list`, query: filters }"
                                class="text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out"
                                >{{ title }}</router-link
                            >
                            <svg
                                class="flex-shrink-0 mx-2 h-5 w-5 text-gray-400"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <a href="#" class="text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out"
                                >Detail</a
                            >
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 py-12 sm:px-6 lg:px-8" v-if="ready">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Log details
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                            Personal details and application.
                        </p>
                    </div>
                    <div class="px-4 py-5 sm:p-0">
                        <dl>
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    Time
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ moment().utc(entry.content.timestamp, 'x').local().format('YYYY-MM-DD LTS') }}
                                </dd>
                            </div>
                            <div
                                class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
                            >
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    Log Stream Name
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ entry.content.logStreamName }}
                                </dd>
                            </div>
                            <div
                                v-if="entry.requestId"
                                class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
                            >
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    Request ID
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ entry.requestId }}
                                </dd>
                            </div>
                            <div
                                class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
                            >
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    Level Name
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ entry.content.message.level_name ? entry.content.message.level_name : 'RAW' }}
                                </dd>
                            </div>

                            <div
                                v-if="entry.content.message.level"
                                class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
                            >
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    Level
                                </dt>
                                <dd
                                    :class="`mt-1 text-sm leading-5 text-${messageLevelColor(
                                        entry.content.message.level
                                    )}-900 sm:mt-0 sm:col-span-2`"
                                >
                                    {{ entry.content.message.level }}
                                </dd>
                            </div>
                            <div
                                class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
                            >
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    Message
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{
                                        entry.content.message.message
                                            ? entry.content.message.message
                                            : entry.content.message
                                    }}
                                </dd>
                            </div>
                            <div
                                v-if="
                                    entry.content.message.context &&
                                    JSON.stringify(entry.content.message.context) !== '[]'
                                "
                                class="mt-8 sm:mt-0 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5 sm:col-span-2"
                            >
                                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div
                                        class="border border-gray-200 rounded-md bg-gray-900 text-white overflow-x-auto"
                                    >
                                        <vue-json-pretty
                                            class="m-4 3rem"
                                            :showLine="false"
                                            :deep="4"
                                            :data="entry.content.message.context"
                                        ></vue-json-pretty>
                                    </div>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="card">
                    <div
                        v-if="!ready"
                        class="d-flex align-items-center justify-content-center card-bg-secondary p-5 bottom-radius"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="icon spin mr-2">
                            <path
                                d="M12 10a2 2 0 0 1-3.41 1.41A2 2 0 0 1 10 8V0a9.97 9.97 0 0 1 10 10h-8zm7.9 1.41A10 10 0 1 1 8.59.1v2.03a8 8 0 1 0 9.29 9.29h2.02zm-4.07 0a6 6 0 1 1-7.25-7.25v2.1a3.99 3.99 0 0 0-1.4 6.57 4 4 0 0 0 6.56-1.42h2.1z"
                            ></path>
                        </svg>

                        <span>Searching for entry...</span>
                    </div>

                    <div
                        v-if="ready && !entry"
                        class="d-flex align-items-center justify-content-center card-bg-secondary p-5 bottom-radius"
                    >
                        <span>No entry found.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

import StylesMixin from './../mixins/entriesStyles';

export default {
    /**
     * The component's mixins.
     */
    mixins: [StylesMixin],

    /**
     * The component's props.
     */
    props: ['group', 'title'],

    /**
     * The component's data.
     */
    data() {
        return {
            id: null,
            entry: null,
            filters: null,
            ready: false,
            currentTab: 'context',
        };
    },

    /**
     * Prepare the component.
     */
    mounted() {
        this.id = this.$route.params.id;
        this.filters = this.$route.query;

        axios
            .get(`/vapor-ui/api/logs/${this.group}/${this.id}`, {
                params: this.filters,
            })
            .then(({ data }) => {
                this.entry = data;
                this.ready = true;
            });

        document.title = `Vapor Ui - ${this.title} - Details`;
    },
};
</script>
