/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('seasons', require('./components/dashboard/Games.vue'));
Vue.component(
    'games',
    require('./components/dashboard/Games.vue')
);

Vue.component('drafts', require('./components/dashboard/Drafts.vue'));

Vue.component('room', require('./components/dashboard/Room.vue'));

const app = new Vue({
    el: '#app'
});


import EchoLibrary from "laravel-echo"

window.Echo = new EchoLibrary({
    broadcaster: 'pusher',
    key: '4cf724c42f1634a6f6a8'
});

let userId = document.getElementById('user_id').value

console.log(userId);
Echo.private('App.User.'+userId)
    .listen('UserGamesData', (e) => {
        console.log(e.games);
    })
    .listen('UserLeaguesData', (e) => {
        console.log(e.leagues);
    })
    .listen('UserTeamsData', (e) => {
        console.log(e.teams);
    });