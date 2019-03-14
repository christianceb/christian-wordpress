var browserSync = require('browser-sync').create(),
gulp = require('gulp'),
rimraf = require('gulp-rimraf'),
rename = require('gulp-rename'),
sass = require('gulp-sass'),
uglify = require('gulp-uglify');

gulp.task('clean', ['clean:js', 'clean:css']);

gulp.task('clean:js', function() {
	return gulp.src(['js'], {
		read: false
	})
	.pipe(rimraf());
});

gulp.task('clean:css', function() {
	return gulp.src(['css'], {
		read: false
	})
	.pipe(rimraf());
});

function process_javascript(scripts, destination) {
	return gulp.src(scripts)
		.pipe(gulp.dest('./assets/js'))
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(uglify())
		.pipe(gulp.dest('./assets/js'));
}

gulp.task('javascript', ['clean:js'], function() {
	var scripts = [
		'src/js/scripts.js'
	];

	return process_javascript(scripts, 'scripts.js');
});

gulp.task('sass', ['clean:css'], function() {
	return gulp.src('src/scss/**/*.scss')
		.pipe(sass({
			outputStyle: 'nested'
		}))
		.pipe(gulp.dest('./assets/css'))
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(gulp.dest('./assets/css'))
		.pipe(browserSync.stream({
			match: '**/*.css'
		}));
});

gulp.task('default', function() {
  gulp.start('javascript');
  gulp.start('sass');
  
  gulp.watch('src/js/**/*.js', ['javascript']);
  gulp.watch('src/scss/**/*.scss', ['sass']);

  browserSync.init({
    proxy: "christian-wordpress.local"
  });
});