/*======================================
	Gulp Variables
======================================*/
const gulp = require( "gulp" );
const del = require( "del" ); // rm -rf

/*======================================
	Gulp Plugins
======================================*/
const autoprefixer = require( "autoprefixer" );
const babel = require( "gulp-babel" );
const concat = require( "gulp-concat" );
const cssnano = require( "cssnano" );
const globbing = require( "gulp-css-globbing" );
const flatten = require( "gulp-flatten" );
const plumber = require( "gulp-plumber" );
const postcss = require( "gulp-postcss" );
const rename = require( "gulp-rename" );
const sass = require( "gulp-sass" );
const sourcemaps = require( "gulp-sourcemaps" );
const terser = require( "gulp-terser" );

const _write = {
	      admin:  "./admin/dist",
	      public: "./public/dist",
      },
      _css   = {
	      admin:  {
		      fileName: "cf-admin",
		      read:     "./admin/css/cf-admin.scss",
	      },
	      public: {
		      fileName: "cf-public",
		      read:     "./public/css/cf-public.scss",
	      }
      },
      _js    = {
	      admin:  {
		      fileName: "cf-admin",
		      read:     "./admin/js/cf-admin.js",
	      },
	      public: {
		      fileName: "cf-public",
		      read:     "./public/js/cf-public.js",
	      }
      };

const adminCSS = sassCompile( _css.admin.read, './admin/dist' );
const publicCSS = sassCompile( _css.public.read, _write.public );
const adminJS = jsCompile( _js.admin.fileName, _js.admin.read, './admin/dist' );
const publicJS = jsCompile( _js.public.fileName, _js.public.read, _write.public );


/*======================================
	Functions
======================================*/

//<editor-fold desc="Functions">
function clean ($path) {
	return del( [ $path ] );
}

/**
 * Our Error Handle
 * @param err
 */
function handleError (err) {
	console.log( err.toString() );
	this.emit( "end" );
}

/**
 * Our SASS Compiler
 * @param $read
 * @param $write
 * @returns {Function}
 */
function sassCompile ($read, $write) {
	"use strict";
	
	const plugin_opts = [
		autoprefixer( {
			browsers: [ "cover 99.5%" ]
		} ),
		cssnano()
	];
	
	return function (done) {
		gulp
			.src( [ `${$read}` ] )
			.pipe( plumber( {
				errorHandler: handleError
			} ) )
			.pipe( flatten() )
			.pipe( sourcemaps.init() )
			.pipe( globbing( {
				extensions: ".scss"
			} ) )
			.pipe( sass().on( "error", sass.logError ) )
			.pipe( postcss( plugin_opts ) )
			.pipe( rename( {
				suffix: ".min"
			} ) )
			.pipe( sourcemaps.write( "." ) )
			.pipe(plumber.stop())
			.pipe( gulp.dest( $write ) );
		done();
	};
}

/**
 * Our JS Compiler
 * @param $filename
 * @param $read
 * @param $write
 * @returns {Function}
 */
function jsCompile ($filename, $read, $write) {
	"use strict";
	return function (done) {
		gulp.
		    src( $read )
			.pipe( plumber( {
				errorHandler: handleError
			} ) )
			.pipe( sourcemaps.init() )
			.pipe( babel( {
				presets: [
					"@babel/preset-env",
					'@babel/react'
				]
			} ) )
			.pipe( terser() )
			.pipe( concat( $filename + ".min.js" ) )
			.pipe( sourcemaps.write( "." ) )
			.pipe(plumber.stop())
			.on( "error", handleError )
			.pipe( gulp.dest( $write ) );
		done();
	};
}

//</editor-fold>

/*======================================
	Executions
======================================*/
// Our Builder
gulp.task( "build:admin:css", adminCSS );
gulp.task( "build:public:css", publicCSS );
gulp.task( "build:admin:js", adminJS );

// Our Watcher
gulp.task( "watch:admin", () => {
	gulp.watch( _css.admin.read, adminCSS );
	gulp.watch( _js.admin.read, adminJS );
} );
gulp.task( "watch:public", () => {
	gulp.watch( _css.public.read, publicCSS );
	gulp.watch( _js.public.read, publicJS );
} );

// Compiler
gulp.task( "build", gulp.parallel( "build:admin:css", "build:public:css", "build:admin:js" ) );
gulp.task( "watch", gulp.parallel( "watch:admin", "watch:public" ) );

// Our Final Output
gulp.task( "default", gulp.parallel( "build", "watch" ) );