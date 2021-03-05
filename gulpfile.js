// https://semaphoreci.com/community/tutorials/getting-started-with-gulp-js
const {src, dest, watch} = require('gulp')
const sync = require('browser-sync').create()

function browserSync(cb) {
    sync.init({
        proxy: 'telem2/'
    });
    watch('./public/**/*').on('change', sync.reload);
    watch('./src/**/*').on('change', sync.reload);
    watch('./templates/**/*.php').on('change', sync.reload);
}


// exports.sassToCss = sassToCss
exports.start = browserSync;
