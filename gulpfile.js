/* globals require */

var i;
var del = require( 'del' );
var gulp = require( 'gulp' );
var jscs = require( 'gulp-jscs' );
var merge = require( 'merge-stream' );
var remoteSrc = require( 'gulp-remote-src' );
var rename = require( 'gulp-rename' );
var unzip = require( 'gulp-unzip' );

var github = 'https://github.com/';
var githubUC = 'https://raw.githubusercontent.com/';

// Run all tasks.
gulp.task( 'default', ['clean'], function() {
	gulp.start( 'bootstrap.get', 'bootswatch.get', 'less.php', 'tgmpa.get' );
});

// Delete vendor folder
gulp.task( 'clean', function( cb ) {
	return del( 'vendor/**', cb );
});

// Downloads TGMPA class.
gulp.task( 'tgmpa.get', function() {
	var tgmpaBase = githubUC + 'TGMPA/TGM-Plugin-Activation/master/';
	return remoteSrc( 'class-tgm-plugin-activation.php', { base: tgmpaBase })
		.pipe( gulp.dest( 'vendor/TGM-Plugin-Activation' ) )
	;
});

// Download Bootstrap JavaScript file.
gulp.task( 'bootstrap.get', function() {
	var tasks = [];
	var bsBase = githubUC + 'twbs/bootstrap/master/';
	var bsFonts = ['glyphicons-halflings-regular.eot', 'glyphicons-halflings-regular.svg', 'glyphicons-halflings-regular.ttf', 'glyphicons-halflings-regular.woff', 'glyphicons-halflings-regular.woff2'];

	var css = remoteSrc( 'css/bootstrap.min.css', { base: bsBase + 'dist/' })
		.pipe( gulp.dest( 'vendor/bootstrap' ) )
	;
	var js = remoteSrc( 'js/bootstrap.min.js', { base: bsBase + 'dist/' })
		.pipe( gulp.dest( 'vendor/bootstrap' ) )
	;
	var variables = remoteSrc( 'less/variables.less', { base: bsBase })
		.pipe( gulp.dest( 'vendor/bootstrap' ) )
	;

	// Fonts
	for ( i = 0; i < bsFonts.length; i++ ) {
		tasks[i] = remoteSrc( '/fonts/' + bsFonts[i], { base: bsBase + '/' })
			.pipe( gulp.dest( 'vendor/bootstrap' ) )
		;
	}

	return merge( css, js, variables, tasks );
});

// Download bootswatch themes, variables and fonts.
gulp.task( 'bootswatch.get', function() {
	var tasks = [];
	var bwThemes = ['cerulean', 'cosmo', 'cyborg', 'darkly', 'flatly', 'journal', 'lumen', 'paper', 'readable', 'sandstone', 'simplex', 'slate', 'spacelab', 'superhero', 'united', 'yeti'];
	var bwFonts = ['glyphicons-halflings-regular.eot', 'glyphicons-halflings-regular.svg', 'glyphicons-halflings-regular.ttf', 'glyphicons-halflings-regular.woff', 'glyphicons-halflings-regular.woff2'];
	var bwBase = githubUC + 'thomaspark/bootswatch/gh-pages/';
	var i;

	// Themes
	for ( i = 0; i < bwThemes.length; i++ ) {
		tasks[i] = remoteSrc( 'bootstrap.min.css', { base: bwBase + bwThemes[i] + '/' })
			.pipe( rename( 'theme.min.css' ) )
			.pipe( gulp.dest( 'vendor/bootswatch/' + bwThemes[i] ) )
		;
	}

	// Variables
	for ( i = 0; i < bwThemes.length; i++ ) {
		tasks[i] = remoteSrc( 'variables.less', { base: bwBase + bwThemes[i] + '/' })
			.pipe( rename( 'vars.less' ) )
			.pipe( gulp.dest( 'vendor/bootswatch/' + bwThemes[i] ) )
		;
	}

	// Fonts
	for ( i = 0; i < bwFonts.length; i++ ) {
		tasks[i] = remoteSrc( 'fonts/' + bwFonts[i], { base: bwBase + '/' })
			.pipe( gulp.dest( 'vendor/bootswatch/' ) )
		;
	}

	return merge( tasks );
});

// Download oyejorge/less.php from github
gulp.task( 'less.php.get', function() {
	return remoteSrc( 'master.zip', { base: github + 'oyejorge/less.php/archive/' })
		.pipe( unzip() )
		.pipe( gulp.dest( 'vendor' ) )
	;
});
gulp.task( 'less.php.rename', ['less.php.get'], function() {
	return gulp
		.src( 'vendor/less.php-master/**/*', { dot: true })
		.pipe( gulp.dest( 'vendor/less.php' ) )
	;
});
gulp.task( 'less.php.clean', ['less.php.rename'], function() {
	return del( 'vendor/less.php-master' );
});
gulp.task( 'less.php', ['less.php.clean'] );

// JavaScript
gulp.task( 'jscs', function() {
	return gulp.src(['*.js', '!vendor/*.js'])
		.pipe( jscs() )
		.pipe( jscs.reporter() )
	;
});
