<script>
    import _ from 'lodash';
    import $ from 'jquery';
    import axios from 'axios';
    import moment from 'moment';

    export default {
        /**
         * The component's props.
         */
        props: [
            'resource', 'title'
        ],

        /**
         * The component's data.
         */
        data() {
            return {
                entries: [],
                searching: true,
                cursor: null,
                filters: {}
            };
        },


        /**
         * Prepare the component.
         */
        mounted() {
            document.title =  "Laravel Vapor Ui - " + this.title;

            for (const [filter, value] of Object.entries(this.$route.query)) {
                if (this.$route.query[filter]) {
                    this.filters[filter] = this.$route.query[filter];
                }
            }

            const startTime = this.filters.startTime
                ? moment.unix(this.filters.startTime)
                : moment().subtract(1, 'h');

            startTime.subtract((new Date()).getTimezoneOffset(), 'm');

            this.filters.startTime = startTime.format('LLL');

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
            loadEntries(){
                this.searching = true;

                this.request().then(({ data }) => {
                    this.entries = data.entries;
                    this.cursor = data.cursor;
                    this.searching = false;
                })
            },

            /**
             * Performs a GET request on the current resource.
             */
            request(cursor = null){
                let params = { ...this.filters };

                if (this.filters.startTime) {
                    params.startTime = moment(this.filters.startTime).format('X');
                }

                this.$router.push({query: _.assign({}, this.$route.query, params )}).catch(() => {});

                params.cursor = cursor;

                return axios.get(`/vapor-ui/api/${this.resource}`, { params });
            },

            /**
             * Creates a new debouncer when a the search input changes.
             */
            search(){
                this.debouncer(() => {
                    this.loadEntries();
                });
            },


            /**
             * Using the current cursor, performs a request 
             * and attach the receive new entries.
             */
            loadMore(){
                this.request(this.cursor).then(({ data }) => {
                    this.entries.push(...data.entries);
                    this.cursor = data.cursor;
                });
            },


            /**
             * Focus on the search input when "/" key is hit.
             */
            focusOnSearch(){
                document.onkeyup = event => {
                    if (event.which === 191 || event.keyCode === 191) {
                        const searchInput = document.getElementById("search-input");

                        if (searchInput) {
                            searchInput.focus();
                        }
                    }
                };
            },
        }
    }
</script>

<template>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5>{{this.title}}</h5>

            <select v-model="filters.limit" class="form-control w-25"
                    v-on:change="loadEntries"
                    >
                <option selected="selected" :value="undefined">10</option>
                <option>20</option>
                <option>50</option>
                <option>100</option>
            </select>

            <input type="text"
                   class="form-control w-25"
                   id="search-input"
                   placeholder="Search..."
                   v-model="filters.query"
                   v-on:change="search"></input>
        </div>

        <div class="card-header d-flex align-items-center justify-content-between">
            <input type="text" class="form-control w-25"
                   v-model.lazy="filters.startTime"
                   v-on:change="loadEntries">
        </div>

        <div v-if="searching" class="d-flex align-items-center justify-content-center card-bg-secondary p-5 bottom-radius">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="icon spin mr-2 fill-text-color">
                <path d="M12 10a2 2 0 0 1-3.41 1.41A2 2 0 0 1 10 8V0a9.97 9.97 0 0 1 10 10h-8zm7.9 1.41A10 10 0 1 1 8.59.1v2.03a8 8 0 1 0 9.29 9.29h2.02zm-4.07 0a6 6 0 1 1-7.25-7.25v2.1a3.99 3.99 0 0 0-1.4 6.57 4 4 0 0 0 6.56-1.42h2.1z"></path>
            </svg>

            <span>Searching for entries...</span>
        </div>

        <div v-if="! searching && entries.length == 0" class="d-flex flex-column align-items-center justify-content-center card-bg-secondary p-5 bottom-radius">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" class="fill-text-color" style="width: 200px;">
                <path fill-rule="evenodd" d="M7 10h41a11 11 0 0 1 0 22h-8a3 3 0 0 0 0 6h6a6 6 0 1 1 0 12H10a4 4 0 1 1 0-8h2a2 2 0 1 0 0-4H7a5 5 0 0 1 0-10h3a3 3 0 0 0 0-6H7a6 6 0 1 1 0-12zm14 19a1 1 0 0 1-1-1 1 1 0 0 0-2 0 1 1 0 0 1-1 1 1 1 0 0 0 0 2 1 1 0 0 1 1 1 1 1 0 0 0 2 0 1 1 0 0 1 1-1 1 1 0 0 0 0-2zm-5.5-11a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm24 10a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm1 18a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm-14-3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm22-23a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM33 18a1 1 0 0 1-1-1v-1a1 1 0 0 0-2 0v1a1 1 0 0 1-1 1h-1a1 1 0 0 0 0 2h1a1 1 0 0 1 1 1v1a1 1 0 0 0 2 0v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 0-2h-1z"></path>
            </svg>

            <span>We didn't find anything - just empty space.</span>
        </div>

        <table id="indexScreen" class="table table-hover table-sm mb-0 penultimate-column-right" v-if="! searching && entries.length > 0">
            <transition-group tag="tbody" name="list">
                <tr v-for="entry in entries" :key="entry.id">
                    <slot name="row" :entry="entry"></slot>
                </tr>
 
            </transition-group>
        </table>

        <div v-if="! searching && entries.length > 0 && cursor" class="d-flex flex-column align-items-center justify-content-center card-bg-secondary p-5 bottom-radius">
            <button @click="loadMore" class="btn btn-primary">Load more</button>
        </div>
    </div>
</template>
