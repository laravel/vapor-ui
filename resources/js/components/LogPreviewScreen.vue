<script>
import _ from 'lodash';
import axios from 'axios';

export default {
    /**
     * The component's props.
     */
    props: ['group', 'title'],

    /**
     * The component's data.
     */
    data() {
        return {
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
        const id = this.$route.params.id;
        this.filters = this.$route.query;

        axios
            .get(`/vapor-ui/api/logs/${this.group}/${id}`, {
                params: this.filters,
            })
            .then(({ data }) => {
                this.entry = data;
                this.ready = true;
            });

        document.title = `Vapor Ui - ${this.title}`;
    },
};
</script>

<template>
    <div>
        <router-link :to="{ name: `logs-${this.group}-list`, query: this.filters }" class="control-action">
            <button class="btn btn-primary margin-botton-10">Back</button>
        </router-link>

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5>{{ this.title }}</h5>
            </div>

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

            <div class="table-responsive">
                <table v-if="ready && entry" class="table mb-0 card-bg-secondary table-borderless">
                    <tbody>
                        <tr>
                            <td class="table-fit font-weight-bold">Time</td>
                            <td>
                                {{ moment().utc(entry.content.timestamp, 'x').local().format('YYYY-MM-DD LTS') }}
                            </td>
                        </tr>

                        <tr>
                            <td class="table-fit font-weight-bold">LogStreamName</td>
                            <td>
                                {{ entry.content.logStreamName }}
                            </td>
                        </tr>

                        <tr v-if="entry.requestId">
                            <td class="table-fit font-weight-bold">Request Id</td>
                            <td>
                                {{ entry.requestId }}
                            </td>
                        </tr>

                        <tr v-if="entry.content.message.level">
                            <td class="table-fit font-weight-bold">Level</td>
                            <td>
                                {{ entry.content.message.level }}
                            </td>
                        </tr>

                        <tr v-if="entry.content.message.level_name">
                            <td class="table-fit font-weight-bold">Level Name</td>
                            <td>
                                {{ entry.content.message.level_name }}
                            </td>
                        </tr>

                        <tr>
                            <td class="table-fit font-weight-bold">Message</td>
                            <td v-if="entry.content.message.message">
                                {{ entry.content.message.message }}
                            </td>
                            <td v-else>
                                {{ entry.content.message }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="ready && entry && entry.content.message.context" class="card mt-5">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a
                        class="nav-link"
                        :class="{ active: currentTab == 'context' }"
                        href="#"
                        v-on:click.prevent="currentTab = 'context'"
                        >Context</a
                    >
                </li>
            </ul>
            <div>
                <!-- Context -->
                <div class="code-bg p-4 mb-0 text-white" v-show="currentTab == 'context'">
                    <vue-json-pretty :data="entry.content.message.context"></vue-json-pretty>
                </div>
            </div>
        </div>
    </div>
</template>
