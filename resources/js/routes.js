export default [
    { path: '/', redirect: '/logs/http' },

    {
        path: '/logs/http',
        name: 'logs-http-index',
        component: require('./screens/logs/http/index').default,
    },

    {
        path: '/logs/http/:id',
        name: 'logs-http-show',
        component: require('./screens/logs/http/show').default,
    },

    {
        path: '/logs/cli',
        name: 'logs-cli-index',
        component: require('./screens/logs/cli/index').default,
    },

    {
        path: '/logs/cli/:id',
        name: 'logs-cli-show',
        component: require('./screens/logs/cli/show').default,
    },

    {
        path: '/logs/queue',
        name: 'logs-queue-index',
        component: require('./screens/logs/queue/index').default,
    },

    {
        path: '/logs/queue/:id',
        name: 'logs-queue-show',
        component: require('./screens/logs/queue/show').default,
    },
];
