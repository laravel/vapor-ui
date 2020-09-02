export default {
    methods: {
        copyToClipboard(href) {
            const el = document.createElement('textarea');
            const base = window.location;
            el.value = base.protocol + '//' + base.host + href;
            el.setAttribute('readonly', '');
            el.style.position = 'absolute';
            el.style.left = '-9999px';
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
        },
    },
};
