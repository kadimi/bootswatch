/**
 * Gulp File
 */

var gulp = require('gulp');
var del = require('del');
var merge = require('merge-stream');
var remoteSrc = require('gulp-remote-src');
var rename = require('gulp-rename');
var githubBase = 'https://raw.githubusercontent.com/';

// Run all tasks.
gulp.task('default', ['clean', 'tgmpa', 'bootstrap', 'bootswatch']);

// Delete vendor folder 
gulp.task('clean', function(cb) {
	return del('vendor/**',cb);
});

// Downloads TGMPA class.
gulp.task('tgmpa', function() {
	var tgmpaBase = githubBase + 'TGMPA/TGM-Plugin-Activation/master';
	return remoteSrc('/class-tgm-plugin-activation.php', {base: tgmpaBase}).pipe(gulp.dest('vendor/TGM-Plugin-Activation/'));
});

// Download Bootstrap JavaScript file.
gulp.task('bootstrap', function() {
	var tasks = [];
	var bsBase = githubBase + 'twbs/bootstrap/master/dist/';
	var bsFonts = ['glyphicons-halflings-regular.eot', 'glyphicons-halflings-regular.svg', 'glyphicons-halflings-regular.ttf', 'glyphicons-halflings-regular.woff', 'glyphicons-halflings-regular.woff2'];

	var css = remoteSrc('/css/bootstrap.min.css', {base: bsBase}).pipe(gulp.dest('vendor/bootstrap/'));
	var js = remoteSrc('/js/bootstrap.min.js', {base: bsBase}).pipe(gulp.dest('vendor/bootstrap/'));

	// Fonts
	for (i = 0; i < bsFonts.length; i++) {
		tasks[i] = remoteSrc('/fonts/' + bsFonts[i], {base: bsBase + '/'})
			.pipe(gulp.dest('vendor/bootstrap/'));
	}

	return merge(css, js, tasks);
});

// Download bootswatch themes and fonts.
gulp.task('bootswatch', function() {
	var tasks = [];
	var bwThemes = ['cerulean', 'cosmo', 'cyborg', 'darkly', 'flatly', 'journal', 'lumen', 'paper', 'readable', 'sandstone', 'simplex', 'slate', 'spacelab', 'superhero', 'united', 'yeti'];
	var bwFonts = ['glyphicons-halflings-regular.eot', 'glyphicons-halflings-regular.svg', 'glyphicons-halflings-regular.ttf', 'glyphicons-halflings-regular.woff', 'glyphicons-halflings-regular.woff2'];
	var bwBase = githubBase + 'thomaspark/bootswatch/gh-pages/';
	var i;

	// Themes
	for (i = 0; i < bwThemes.length; i++) {
		tasks[i] = remoteSrc('bootstrap.min.css', {base: bwBase + bwThemes[i] + '/'})
			.pipe(rename(bwThemes[i] + '.min.css'))
			.pipe(gulp.dest('vendor/bootswatch/'));
	}

	// Fonts
	for (i = 0; i < bwFonts.length; i++) {
		tasks[i] = remoteSrc('fonts/' + bwFonts[i], {base: bwBase + '/'})
			.pipe(gulp.dest('vendor/bootswatch/'));
	}

	return merge(tasks);
});
