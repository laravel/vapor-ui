<template>
    <div class="flex-1 relative pb-8 z-0 overflow-y-auto">
        <div class="relative z-10 flex-shrink-0 flex h-16 bg-white border-b border-gray-200 lg:border-none">
            <div class="flex-1 px-4 flex justify-between sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
                <div class="mt-5">
                    <div>
                        <nav class="sm:flex items-center text-sm leading-5 font-medium">
                            <router-link
                                :to="{ name: `logs-${group}-index`, query: filters }"
                                class="text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out"
                                >{{ title }}
                            </router-link>
                            <icon-chevron-right size="5" class="flex-shrink-0 mx-2 text-gray-400"></icon-chevron-right>
                            <a href="#" class="text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out"
                                >Details</a
                            >
                        </nav>
                    </div>
                </div>
                <div class="mt-3 flex">
                    <span class="order-1 ml-3 shadow-sm rounded-md sm:order-0 sm:ml-0">
                        <button
                            v-on:click="
                                copyToClipboard(
                                    $router.resolve({
                                        name: `logs-${entry.group}-show`,
                                        params: { id: entry.id, group: entry.group },
                                        query: entry.filters,
                                    }).href
                                )
                            "
                            type="button"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out"
                        >
                            Share
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
            <!-- Loader -->
            <loader v-if="!ready"></loader>

            <!-- No entry found -->
            <empty-search-results v-if="ready && !entry">
                Log not found.
            </empty-search-results>

            <div v-if="ready && entry" class="max-w-4xl mx-auto">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Log details
                        </h3>
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
                                    Event ID
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ entry.id }}
                                </dd>
                            </div>

                            <div
                                class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
                            >
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    Type
                                </dt>
                                <dd
                                    :class="`mt-1 text-sm leading-5 text-${logColor(
                                        entry.type
                                    )}-900 sm:mt-0 sm:col-span-2`"
                                >
                                    {{ entry.type }}
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
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

import ClipboardMixin from './../mixins/Clipboard';
import LogMixin from './../mixins/log';

export default {
    /**
     * The component's mixins.
     */
    mixins: [ClipboardMixin, LogMixin],

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
                validateStatus: false,
            })
            .then(({ data }) => {
                this.ready = true;
                this.entry = data;
            });

        document.title = `Vapor Ui - ${this.title} - Detail`;
    },
};
</script>
