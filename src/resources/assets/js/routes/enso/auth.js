export const Auth = [
	{ name: 'login', path: '/login', component: require('../../pages/enso/auth/Login.vue') },
    { path: '/password/reset', name: 'password.email', component: require('../../pages/enso/auth/password/Email.vue') }
    // { path: '/password/reset/:token', name: 'password.reset', component: require('../pages/enso/auth/password/Reset.vue') }
];