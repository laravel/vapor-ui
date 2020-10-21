<template>
    <search-details>
        <template slot="details" slot-scope="{ entry }">
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm leading-5 font-medium text-gray-500">Time ({{ moment().tz.guess() }})</dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    <div class="text-sm leading-5 font-medium text-gray-900">
                        {{ moment().utc(entry.content.timestamp, 'x').local().format('YYYY-MM-DD LTS') }}
                    </div>
                    <div class="text-sm leading-5 text-gray-500">
                        {{ moment().utc(entry.content.timestamp, 'x').fromNow() }}
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
                <dt class="text-sm leading-5 font-medium text-gray-500">Log Stream Name</dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ entry.content.logStreamName }}
                </dd>
            </div>
            <div
                v-if="entry.requestId"
                class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
            >
                <dt class="text-sm leading-5 font-medium text-gray-500">Request ID</dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ entry.requestId }}
                </dd>
            </div>

            <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5">
                <dt class="text-sm leading-5 font-medium text-gray-500">Type</dt>
                <dd :class="`mt-1 text-sm leading-5 text-${logColor(entry.type)}-900 sm:mt-0 sm:col-span-2`">
                    {{ entry.type }}
                </dd>
            </div>

            <div
                v-if="entry.location"
                class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
            >
                <dt class="text-sm leading-5 font-medium text-gray-500">Location</dt>
                <dd :class="`mt-1 text-sm leading-5 text-${logColor(entry.type)}-900 sm:mt-0 sm:col-span-2`">
                    {{ entry.location }}
                </dd>
            </div>

            <div
                v-if="entry.content.message.context && entry.content.message.context.command"
                class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
            >
                <dt class="text-sm leading-5 font-medium text-gray-500">Command</dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ entry.content.message.context.command }}
                </dd>
            </div>

            <div
                v-if="!entry.content.message.output"
                class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
            >
                <dt class="text-sm leading-5 font-medium text-gray-500">Message</dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ entry.content.message.message ? entry.content.message.message : entry.content.message }}
                </dd>
            </div>
            <div
                v-if="entry.content.message.context && JSON.stringify(entry.content.message.context) !== '[]'"
                class="mt-8 sm:mt-0 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5 sm:col-span-2"
            >
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    <div class="border border-gray-200 rounded-md bg-gray-900 text-white overflow-x-auto">
                        <pre v-if="entry.content.message.output" class="m-4 3rem">
                            {{ entry.content.message.output.trim() }}
                        </pre>

                        <vue-json-pretty
                            v-else
                            class="m-4 3rem"
                            :showLine="false"
                            :deep="4"
                            :data="entry.content.message.context"
                        ></vue-json-pretty>
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
};
</script>
