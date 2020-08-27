<template>
    <div>
        <div class="flex items-center mt-4" style="height: 150px">
            <svg
                :class="`mx-auto block text-${color}-500`"
                :style="{ width: `${width}px` }"
                viewBox="0 0 120 30"
                xmlns="http://www.w3.org/2000/svg"
                :fill="fillColor"
            >
                <circle cx="15" cy="15" r="15">
                    <animate
                        attributeName="r"
                        from="15"
                        to="15"
                        begin="0s"
                        dur="0.8s"
                        values="15;9;15"
                        calcMode="linear"
                        repeatCount="indefinite"
                    />
                    <animate
                        attributeName="fill-opacity"
                        from="1"
                        to="1"
                        begin="0s"
                        dur="0.8s"
                        values="1;.5;1"
                        calcMode="linear"
                        repeatCount="indefinite"
                    />
                </circle>
                <circle cx="60" cy="15" r="9" fill-opacity="0.3">
                    <animate
                        attributeName="r"
                        from="9"
                        to="9"
                        begin="0s"
                        dur="0.8s"
                        values="9;15;9"
                        calcMode="linear"
                        repeatCount="indefinite"
                    />
                    <animate
                        attributeName="fill-opacity"
                        from="0.5"
                        to="0.5"
                        begin="0s"
                        dur="0.8s"
                        values=".5;1;.5"
                        calcMode="linear"
                        repeatCount="indefinite"
                    />
                </circle>
                <circle cx="105" cy="15" r="15">
                    <animate
                        attributeName="r"
                        from="15"
                        to="15"
                        begin="0s"
                        dur="0.8s"
                        values="15;9;15"
                        calcMode="linear"
                        repeatCount="indefinite"
                    />
                    <animate
                        attributeName="fill-opacity"
                        from="1"
                        to="1"
                        begin="0s"
                        dur="0.8s"
                        values="1;.5;1"
                        calcMode="linear"
                        repeatCount="indefinite"
                    />
                </circle>
            </svg>
        </div>

        <div class="mt-4 text-center max-w-xl mx-auto">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Loader',
    props: {
        color: {
            type: [String],
            required: false,
            default: 'gray',
        },
        width: {
            type: [Number, String],
            required: false,
            default: 50,
        },
        fillColor: {
            type: String,
            required: false,
            default: 'currentColor',
        },
    },
};
</script>
