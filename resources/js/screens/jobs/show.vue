<template>
    <search-details>
        <template slot="details" slot-scope="{ entry }">
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm leading-5 font-medium text-gray-500">Time ({{ moment().tz.guess() }})</dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    <div class="text-sm leading-5 font-medium text-gray-900">
                        {{ moment().utc(entry.timestamp, 'x').local().format('YYYY-MM-DD LTS') }}
                    </div>
                    <div class="text-sm leading-5 text-gray-500">
                        {{ moment().utc(entry.timestamp, 'x').fromNow() }}
                    </div>
                </dd>
            </div>

            <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5">
                <dt class="text-sm leading-5 font-medium text-gray-500">ID</dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ entry.id }}
                </dd>
            </div>

            <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5">
                <dt class="text-sm leading-5 font-medium text-gray-500">Connection</dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ entry.content.connection }}
                </dd>
            </div>
            <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5">
                <dt class="text-sm leading-5 font-medium text-gray-500">Queue</dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ entry.content.queue }}
                </dd>
            </div>

            <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5">
                <dt class="text-sm leading-5 font-medium text-gray-500">Name</dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ entry.content.payload.displayName }}
                </dd>
            </div>

            <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5">
                <dt class="text-sm leading-5 font-medium text-gray-500">Message</dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ entry.message }}
                </dd>
            </div>
            <div class="mt-8 sm:mt-0 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5 sm:col-span-2">
                <div class="sm:block mb-2">
                    <nav class="flex">
                        <a
                            href="#"
                            v-on:click.prevent="currentTab = 'payload'"
                            :class="
                                'px-3 py-2 font-medium text-sm leading-5 rounded-md text-gray-500 hover:text-gray-700 focus:outline-none focus:text-indigo-600 focus:bg-indigo-50 ' +
                                (currentTab == 'payload' ? 'text-indigo-700 bg-indigo-100' : '')
                            "
                        >
                            Payload
                        </a>
                        <a
                            href="#"
                            v-on:click.prevent="currentTab = 'stackTrace'"
                            :class="
                                'ml-4 px-3 py-2 font-medium text-sm leading-5 rounded-md text-gray-500 hover:text-gray-700 focus:outline-none focus:text-indigo-600 focus:bg-indigo-50 ' +
                                (currentTab == 'stackTrace' ? 'text-indigo-700 bg-indigo-100' : '')
                            "
                        >
                            Stack Trace
                        </a>
                    </nav>
                </div>

                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    <div
                        v-if="currentTab == 'payload'"
                        class="border border-gray-200 rounded-md bg-gray-900 text-white overflow-x-auto"
                    >
                        <vue-json-pretty
                            class="m-4 3rem"
                            :showLine="false"
                            :deep="4"
                            :data="entry.content.payload"
                        ></vue-json-pretty>
                    </div>

                    <div v-else class="border border-gray-200 rounded-md bg-gray-900 text-white overflow-x-auto">
                        <div class="m-4 3rem">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody>
                                    <!-- Odd row -->
                                    <tr v-for="line in entry.content.exception.split('Stack trace:')[1].split(/\r?\n/)">
                                        <td class="whitespace-no-wrap text-sm leading-5 font-medium text-white">
                                            {{ line }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </dd>
            </div>
        </template>
    </search-details>
</template>

<script>
import LogMixin from './../../mixins/log';

export default {
    /**
     * The component's mixins.
     */
    mixins: [LogMixin],

    data() {
        return {
            currentTab: 'payload',
        };
    },
};
</script>
