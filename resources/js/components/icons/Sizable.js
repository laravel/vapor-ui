export default {
    props: {
        size: {
            default: '8',
        },
    },

    computed: {
        sizeClass() {
            return {
                4: 'h-4 w-4',
                5: 'h-5 w-5',
                6: 'h-6 w-6',
                8: 'h-8 w-8',
                12: 'h-12 w-12',
                16: 'h-16 w-16',
                20: 'h-20 w-20',
            }[this.size];
        },
    },
};
