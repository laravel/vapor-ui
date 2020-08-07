<template>
    <div class="flex-1 relative pb-8 z-0 overflow-y-auto">
        <div class="relative z-10 flex-shrink-0 flex h-16 bg-white border-b border-gray-200 lg:border-none">
            <div class="flex-1 px-4 flex justify-between sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
                <div class="flex-1 flex">
                    <div class="w-full flex md:ml-0">
                        <label for="search-input" class="sr-only">Search</label>
                        <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                <icon-search size="5" />
                            </div>
                            <input
                                id="search-input"
                                v-model="filters.query"
                                @input.stop="search"
                                class="block w-full h-full pl-8 pr-3 py-2 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 sm:text-sm"
                                placeholder="Search"
                                type="search"
                            />
                        </div>
                    </div>
                </div>
                <div class="ml-4 flex items-center md:ml-6">
                    <button
                        class="p-1 text-gray-400 rounded-full hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:shadow-outline focus:text-gray-500"
                        aria-label="Refresh"
                        v-on:click="loadEntries"
                    >
                        <icon-refresh size="6" />
                    </button>
                </div>
            </div>
        </div>

        <div class="flex-1 relative pb-8 z-0 overflow-y-auto">
            <div class="bg-white shadow">
                <div class="px-4 sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
                    <div class="py-6 md:flex md:items-center md:justify-between lg:border-t lg:border-cool-gray-200">
                        <div class="flex-1 min-w-0">
                            <div>
                                <label for="start-time-input" class="block text-sm font-medium leading-5 text-gray-700"
                                    >Starting from</label
                                >
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <icon-calendar class="text-gray-400" size="5" />
                                    </div>
                                    <input
                                        v-model.lazy="filters.startTime"
                                        v-on:change="loadEntries"
                                        id="start-time-input"
                                        class="form-input block w-full pl-10 sm:text-sm sm:leading-5"
                                        placeholder="0.00"
                                    />
                                    <div class="absolute inset-y-0 right-0 flex items-center">
                                        <select
                                            v-model="minutesAgo"
                                            v-on:change="onTimeAgoChange()"
                                            aria-label="Currency"
                                            class="form-select h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm sm:leading-5"
                                        >
                                            <option
                                                v-for="[option, label] in getMinutesAgoOptions()"
                                                :key="`minutes-ago-${option}`"
                                                :value="option"
                                            >
                                                {{ label }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <p if="errors.length" v-for="error in errors" class="mt-2 text-sm text-red-600">
                                    {{ error }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-6 flex space-x-3 md:mt-0 md:ml-4">
                            <div class="flex items-start pt-5">
                                <div class="flex items-center h-5">
                                    <input
                                        v-model="filters.raw"
                                        v-on:change="loadEntries"
                                        :true-value="1"
                                        :false-value="null"
                                        id="raw"
                                        type="checkbox"
                                        class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
                                    />
                                </div>
                                <div class="ml-3 text-sm leading-5">
                                    <p class="text-gray-500">Display raw logs from AWS.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col mt-2">
                <div class="align-middle min-w-full overflow-x-auto shadow overflow-hidden sm:rounded-lg">
                    <!-- Loader -->
                    <loader v-if="searching || (loadingMore && entries.length == 0)">
                        <template v-if="loadingMore && entries.length === 0">
                            No logs have being found yet, still searching...
                        </template>
                    </loader>

                    <!-- No Search Results -->
                    <empty-search-results v-if="!searching && !loadingMore && entries.length == 0">
                        No logs were found for the given search criteria.
                    </empty-search-results>

                    <table class="min-w-full divide-y divide-gray-200" v-if="!searching && entries.length > 0">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    {{ this.title }}
                                </th>

                                <th
                                    v-for="n in 3"
                                    class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                ></th>
                            </tr>
                        </thead>
                        <transition-group tag="tbody" name="list" class="bg-white divide-y divide-gray-200">
                            <tr v-for="entry in entries" :key="entry.id">
                                <td
                                    class="max-w-0 w-full px-6 py-4 whitespace-no-wrap text-sm leading-5 text-cool-gray-900"
                                >
                                    <div class="ml-4">
                                        <div class="text-sm leading-5 font-medium text-gray-900 truncate">
                                            <p class="truncate">
                                                {{
                                                    entry.content.message.message
                                                        ? entry.content.message.message
                                                        : entry.content.message
                                                }}
                                            </p>
                                        </div>
                                        <div
                                            v-if="
                                                entry.content.message.context &&
                                                entry.content.message.context.exception &&
                                                entry.content.message.context.exception.class
                                            "
                                            class="text-sm leading-5 text-gray-500"
                                        >
                                            {{ entry.content.message.context.exception.class }}
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <span
                                        :class="`px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-${messageLevelColor(
                                            entry.content.message.level
                                        )}-100 text-${messageLevelColor(entry.content.message.level)}-800`"
                                        class=""
                                    >
                                        {{
                                            entry.content.message.level_name ? entry.content.message.level_name : 'RAW'
                                        }}
                                    </span>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500"
                                >
                                    {{ moment().utc(entry.content.timestamp, 'x').local().format('YYYY-MM-DD LTS') }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium"
                                >
                                    <div class="relative flex justify-end items-center">
                                        <router-link
                                            :to="{
                                                name: `logs-${group}-preview`,
                                                params: { id: entry.id, group: entry.group },
                                                query: entry.filters,
                                            }"
                                            tag="button"
                                            href="#"
                                            class="w-8 h-8 inline-flex items-center justify-center text-gray-400 rounded-full bg-transparent hover:text-gray-500 focus:outline-none focus:text-gray-500 focus:bg-gray-100 transition ease-in-out duration-150"
                                        >
                                            <icon-eye
                                                size="5"
                                                class="mr-3 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500"
                                            />
                                        </router-link>
                                    </div>
                                </td>
                            </tr>
                        </transition-group>
                    </table>
                    <!-- Pagination -->
                    <nav
                        v-if="(!searching && loadingMore) || (!searching && !loadingMore && cursor)"
                        class="bg-white px-4 py-3 flex items-center justify-between border-t border-cool-gray-200 sm:px-6"
                    >
                        <div class="hidden sm:block" v-if="!searching && loadingMore">
                            <p class="text-sm ml-4 leading-5 text-cool-gray-700">
                                Searching for newer entries..
                            </p>
                        </div>
                        <div class="flex-1 flex justify-between sm:justify-end">
                            <a
                                v-if="!searching && !loadingMore && cursor"
                                href="#"
                                v-on:click="loadMore"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-cool-gray-300 text-sm leading-5 font-medium rounded-md text-cool-gray-700 bg-white hover:text-cool-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-cool-gray-100 active:text-cool-gray-700 transition ease-in-out duration-150"
                            >
                                Load more
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _ from 'lodash';
import axios from 'axios';
import moment from 'moment';

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
            entries: [],
            errors: [],
            loadingMore: false,
            minutesAgo: null,
            searching: true,
            cursor: null,
            filters: {},
        };
    },

    /**
     * Prepare the component.
     */
    mounted() {
        document.title = 'Vapor Ui - ' + this.title;

        for (const [filter, value] of Object.entries(this.$route.query)) {
            if (this.$route.query[filter]) {
                this.filters[filter] = this.$route.query[filter];
            }
        }

        const startTime = this.filters.startTime
            ? moment.unix(this.filters.startTime)
            : moment().subtract(10, 'minutes');

        this.filters.startTime = startTime.local().format('YYYY-MM-DD LTS');
        this.loadEntries();
        this.focusOnSearch();
    },

    /**
     * Clean after the component is destroyed.
     */
    destroyed() {
        document.onkeyup = null;
    },

    /**
     * The component's methods.
     */
    methods: {
        loadEntries() {
            /**
             * First, we validate the filters inputs.
             */
            if (!this.validate()) {
                return;
            }

            /**
             * Next, we update some state like the minutes ago selector, and
             * the `searching` that will display the loader.
             */
            const startTime = moment(this.filters.startTime, 'YYYY-MM-DD LTS').add(new Date().getTimezoneOffset(), 'm');
            this.minutesAgo = parseInt(moment.duration(moment().diff(startTime)).asMinutes());
            this.searching = true;

            /**
             * Finally, we perform the request.
             */
            this.request().then(({ data }) => {
                this.entries = data.entries;
                this.cursor = data.cursor;
                this.searching = false;
                if (this.entries.length < 50 && this.cursor) {
                    this.loadMore();
                }
            });
        },

        /**
         * Performs a GET request on the current group.
         */
        request(cursor = null) {
            const filters = { ...this.filters };

            let params = { ...this.filters };

            if (this.filters.startTime) {
                params.startTime = moment(this.filters.startTime, 'YYYY-MM-DD LTS')
                    .add(new Date().getTimezoneOffset(), 'm')
                    .format('X');
            }

            this.$router.push({ query: Object.assign({}, this.$route.query, params) }).catch(() => {});

            params.cursor = cursor;

            return axios.get(`/vapor-ui/api/logs/${this.group}`, { params }).then((data) => {
                if (JSON.stringify(filters) !== JSON.stringify(this.filters)) {
                    throw 'The filters have been changed.';
                }

                return data;
            });
        },

        /**
         * Creates a new debouncer when a the search input changes.
         */
        search() {
            this.debouncer(() => {
                this.loadEntries();
            });
        },

        /**
         * Using the current cursor, performs a request
         * and attach the receive new entries.
         */
        loadMore() {
            this.loadingMore = true;

            this.request(this.cursor).then(({ data }) => {
                this.entries.push(...data.entries);
                this.cursor = data.cursor;

                this.loadingMore = false;

                if (this.entries.length < 100 && this.cursor) {
                    this.loadMore();
                }
            });
        },

        /**
         * Validates the current filters.
         */
        validate() {
            this.errors = [];

            if (!moment(this.filters.startTime, 'YYYY-MM-DD LTS').isValid()) {
                this.errors.push("Input any valid date. Ex: '2020-05-09 2:32:43 PM'");
            }

            return !this.errors.length;
        },

        /**
         * Updates the start time, and re-load entries.
         */
        onTimeAgoChange() {
            this.filters.startTime = moment().subtract(this.minutesAgo, 'minutes').local().format('YYYY-MM-DD LTS');

            this.loadEntries();
        },

        /**
         * [updateMinutesAgoInput description]
         */
        updateMinutesAgoInput() {
            const startTime = moment(this.filters.startTime, 'YYYY-MM-DD LTS').add(new Date().getTimezoneOffset(), 'm');

            const duration = moment.duration(moment().diff(startTime));
            const minutes = parseInt(duration.asMinutes());
            this.minutesAgo = minutes;
        },

        /**
         * Gets the minutes ago options.
         */
        getMinutesAgoOptions() {
            const minutes = Array.from(new Set([1, 5, 10, 30, this.minutesAgo].sort((a, b) => a - b)));
            const options = [];

            minutes.forEach((value) => {
                options.push([value, moment().subtract(value, 'minutes').fromNow()]);
            });

            return options;
        },

        /**
         * Focus on the search input when "/" key is hit.
         */
        focusOnSearch() {
            document.onkeyup = (event) => {
                if (event.which === 191 || event.keyCode === 191) {
                    const searchInput = document.getElementById('search-input');

                    if (searchInput) {
                        searchInput.focus();
                    }
                }
            };
        },
    },
};
</script>
