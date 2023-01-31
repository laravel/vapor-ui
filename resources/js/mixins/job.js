export default {
    methods: {
        /**
         * Returns the log color by the given display name.
         */
        jobColor(displayName) {
            return 'red';
        },

        /**
         * Returns the queue names.
         */
        queues() {
            let queues = {};

            VaporUi.queues.forEach((queue) => {
                if (typeof queue == 'object') {
                    let q = Object.keys(queue)[0] || null;

                    if (q) {
                        queues[queue] = q;
                        return;
                    }
                }

                if (typeof queue == 'string') {
                    queues[queue] = queue;
                    return;
                }
            })

            return queues;
        },
    },
};
