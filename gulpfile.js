var gulp = require('gulp'),
    watch = require('gulp-watch'),
    batch = require('gulp-batch'),
    exec = require('child_process').exec;

gulp.task('watch-test', function() {
    return watch('**/*.*', batch(function(events, done) {
        console.log('Statring command: \`make test\`');
        exec('make test', function (err, stdout, stderr) {
            console.log(stdout);
            console.log(stderr);
            console.log('Ending command: \`make test\`');
            done(err);
        });
    }));
});
