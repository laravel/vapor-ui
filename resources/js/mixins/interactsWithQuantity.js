import moment from 'moment';

export default {
    /**
     * The mixin's methods.
     */
    methods: {
        /**
         * Formats the given quantity to a human readable format.
         */
        formatQuantity(quantity) {
            const replace = (num, division, unit) => {
                return (num / division).toFixed(1).replace(/\.0$/, '') + unit;
            };

            if (quantity >= 1000000) {
                return replace(quantity, 1000000, 'M');
            } else if (quantity >= 1000) {
                return replace(quantity, 1000, 'K');
            } else if (quantity <= -1000000) {
                return replace(quantity, -1000000, 'M');
            } else if (quantity <= -1000) {
                return replace(quantity, -1000, 'K');
            }

            return quantity;
        },
    },
};
