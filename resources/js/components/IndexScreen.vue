<script>
    import _ from 'lodash';
    import axios from 'axios';

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
                    delete data.filters.cursor;

                    this.$router.push({query: _.assign({}, this.$route.query, data.filters)}).catch(()=>{});

                    this.entries = data.entries;
                    this.searching = false;
                    this.cursor = data.cursor;
                })
            },

            /**
             * Performs a GET request on the current resource.
             */
            request(data){
                return axios.get(`/vapor-ui/api/${this.resource}`, {
                    params: { ...this.filters, ...data }
                });
            },

            /**
             * Creates a new debouncer when a the search input changes.
             */
            search(){
                this.debouncer(() => {
                    this.$router.push({query: _.assign({}, this.$route.query, this.filters)});

                    this.loadEntries();
                });
            },


            /**
             * Using the current cursor, performs a request 
             * and attach the receive new entries. 
             */
            loadMore(){
                this.request({ cursor: this.cursor }).then(({ data }) => {
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
                    @input.change="search"
                    >
                <option selected="selected" :value="undefined">10</option>
                <option>20</option>
                <option>50</option>
                <option>100</option>
            </select>

            <input type="text" class="form-control w-25"
                   id="search-input"
                   placeholder="Search..." v-model="filters.query" @input.stop="search">
        </div>

        <div class="card-header d-flex align-items-center justify-content-between">
            <slot name="filters" :filters="filters" :search="search"></slot>
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

        <div v-if="! searching && cursor" class="d-flex flex-column align-items-center justify-content-center card-bg-secondary p-5 bottom-radius">
            <button @click="loadMore" class="btn btn-primary">Load more</button>
        </div>
    </div>
</template>
