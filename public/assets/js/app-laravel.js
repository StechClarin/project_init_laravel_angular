import Echo from "laravel-echo"

window.io = require('socket.io-client');

console.log('import du fichier app-laravel.js by sps');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});
