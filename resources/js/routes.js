export default [
    { path: '/', redirect: '/logs/http' },

    {
        path: '/logs/http',
        name: 'logs-http-list',
        component: require('./screens/logs/http/list').default,
    },

    {
        path: '/logs/http/:id',
        name: 'logs-http-preview',
        component: require('./screens/logs/http/preview').default,
    },

    {
        path: '/logs/cli',
        name: 'logs-cli-list',
        component: require('./screens/logs/cli/list').default,
    },

    {
        path: '/logs/cli/:id',
        name: 'logs-cli-preview',
        component: require('./screens/logs/cli/preview').default,
    },

    {
        path: '/logs/queue',
        name: 'logs-queue-list',
        component: require('./screens/logs/queue/list').default,
    },

    {
        path: '/logs/queue/:id',
        name: 'logs-queue-preview',
        component: require('./screens/logs/queue/preview').default,
    },
];
