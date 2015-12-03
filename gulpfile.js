var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less([
            'default.less',
        ],
        'public/css/default.css');
    mix.less(['calendar.less'],
            'public/css/calendar.css');
    mix.version(['css/default.css','css/calendar.css','scripts/login.js','scripts/calendar.js',
        'scripts/newgroup.js',
        'scripts/footer.js',
        'scripts/newevent.js',
        'scripts/chat.js',
        'scripts/chatUploader.js',
        'scripts/loading.js',
        'scripts/calendarDay.js',
        'scripts/notify.js'
        ]);
});