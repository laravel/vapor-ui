<template>
    <index-screen title="Logs" resource="logs">

        <template slot="filters" slot-scope="{ filters, search }">
            // Specific filters of this tab:

            <select v-model="filters.group" 
                    class="form-control w-25"
                    @input.change="search">
                <option selected="selected" :value="undefined">http</option>
                <option>cli</option>
                <option>queue</option>
            </select>

            <input type="datetime-local"
                class="form-control w-25"
                id="start-time"
                @input.change="searchWithTimestamp('start-time', filters, 'startTime', search)">
            </input>

            <input type="datetime-local"
                class="form-control w-25"
                id="end-time"
                @input.change="searchWithTimestamp('end-time', filters, 'endTime', search)">
            </input>
        </template>

        <template slot="row" slot-scope="{ entry }">

            <td >
                {{ entry.content.message }}
            </td>

            <td >
                {{  moment().utc(entry.content.timestamp, 'x').local().format('YYYY-MM-DD LTS') }}
            </td>

            <td class="table-fit">
                <router-link :to="{name:'log-preview', params: {id: entry.id}}" class="control-action">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 16">
                        <path d="M16.56 13.66a8 8 0 0 1-11.32 0L.3 8.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95-.01.01zm-9.9-1.42a6 6 0 0 0 8.48 0L19.38 8l-4.24-4.24a6 6 0 0 0-8.48 0L2.4 8l4.25 4.24h.01zM10.9 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"></path>
                    </svg>
                </router-link>
            </td>
        </template>
    </index-screen>
</template>

<script>
    import $ from 'jquery';

    export default {
        /**
         * Prepare the component.
         */
        mounted() {   
            this.inputWithTimestamp('start-time', 'startTime');
            this.inputWithTimestamp('end-time', 'endTime');
        },

        /**
         * Watch for filters changes.
         */
        watch:{
            $route (to, from){
                this.inputWithTimestamp('start-time', 'startTime');
                this.inputWithTimestamp('end-time', 'endTime');
            }
        },

        /**
         * The component's methods.
         */
        methods: {
            /**
             * Converts the given change to timestamp and executes the given callback.
             */
            searchWithTimestamp(elementId, filters, property, callback) {
                filters[property] = new Date(
                    document.getElementById(elementId).value
                ).getTime();

                return callback();
            },


            /**
             * Converts the given change to timestamp and executes the given callback.
             */
            inputWithTimestamp(elementId, property, defaultTime) {
                const time = this.$route.query[property];
                const timeOffset = (new Date()).getTimezoneOffset() * 60 * 1000
                const $element = $('#' + elementId)[0];
                if (time) {
                    $element.valueAsNumber = parseInt(time) - timeOffset;
                } else if (defaultTime) {
                    $element.valueAsNumber = parseInt(defaultTime) - timeOffset;
                }
            },
        }
    }
</script>
