var gulp = require('gulp');
var less = require('gulp-less');

gulp.task('less', function () {
  gulp.src('widgets/*/style.less')
    .pipe(less())
    .pipe(gulp.dest('widgets'));
});

gulp.task('default', ['less']);
