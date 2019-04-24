/*======================================
	Gulp Variables
======================================*/
const { src, dest, watch, series, parallel } = require( 'gulp' ),
      del                                    = require( 'del' ),
      pipeline                               = require( 'readable-stream' ).pipeline; // rm -rf

/*======================================
	Gulp Plugins
======================================*/
const autoprefixer = require( 'autoprefixer' ),
      babel        = require( 'gulp-babel' ),
      concat       = require( 'gulp-concat' ),
      cssnano      = require( 'cssnano' ),
      eslint       = require( 'gulp-eslint' ),
      globbing     = require( 'gulp-css-globbing' ),
      gulpIf       = require( 'gulp-if' ),
      flatten      = require( 'gulp-flatten' ),
      plumber      = require( 'gulp-plumber' ),
      postcss      = require( 'gulp-postcss' ),
      rename       = require( 'gulp-rename' ),
      sass         = require( 'gulp-sass' ),
      sourcemaps   = require( 'gulp-sourcemaps' ),
      terser       = require( 'gulp-terser' ),
      uglify       = require( 'gulp-uglify' );

/*======================================
	Files and Functions
======================================*/
const _write = {
          admin:  './admin/dist',
          public: './public/dist',
      },
      _css   = {
          admin:  {
              fileName: 'cf-admin',
              read:     './admin/css/cf-admin.scss',
              watch:    './admin/css/**/*',
          },
          public: {
              fileName: 'cf-public',
              read:     './public/css/cf-public.scss',
              watch:    './public/css/**/*',
          },
      },
      _js    = {
          admin:  {
              fileName: 'cf-admin',
              read:     './admin/js',
              watch:    './admin/js/**/*',
          },
          public: {
              fileName: 'cf-public',
              read:     './public/js',
              watch:    './public/js/**/*',
              // read:     {
              //     js: './public/js/**/*.js',
              // },
          },
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
    this.emit( 'end' );
}

/**
 * Our SASS Compiler
 * @param $read
 * @param $write
 * @returns {Function}
 */
function sassCompile ($read, $write) {
    'use strict';
    
    const plugin_opts = [
        autoprefixer( {
            browsers: [ 'cover 99.5%' ],
        } ),
        cssnano(),
    ];
    
    return function (done) {
        
        src( [ `${$read}` ] )
            .pipe( plumber( {
                errorHandler: handleError,
            } ) )
            .pipe( flatten() )
            .pipe( sourcemaps.init() )
            .pipe( globbing( {
                extensions: '.scss',
            } ) )
            .pipe( sass().on( 'error', sass.logError ) )
            .pipe( postcss( plugin_opts ) )
            .pipe( rename( {
                suffix: '.min',
            } ) )
            .pipe( sourcemaps.write( '.' ) )
            .pipe( plumber.stop() )
            .pipe( dest( $write ) );
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
    'use strict';
    return function (done) {
        src( [ `${$read}/**/*.js*` ] )
            .pipe( plumber( {
                errorHandler: handleError,
            } ) )
            .pipe( eslint( {
                fix:   true,
                quiet: true,
            } ) )
            .pipe( eslint.format() )
            .pipe( eslint.results( results => {
                // Called once for all ESLint results.
                console.log( `${$filename} Results: ${results.length}` );
                console.log( `Total Warnings: ${results.warningCount}` );
                console.log( `Total Errors: ${results.errorCount}` );
            } ) )
            .pipe( eslint.failAfterError() )
            .pipe( sourcemaps.init() )
            .pipe( babel( {
                presets: [
                    '@babel/preset-env',
                    '@babel/react',
                ],
            } ) )
            .pipe( terser() )
            .pipe( rename( {
                suffix: '.min',
            } ) )
            .pipe( concat( $filename + '.min.js' ) )
            .pipe( sourcemaps.write( './' ) )
            .pipe( plumber.stop() )
            .on( 'error', handleError )
            .pipe( gulpIf( isFixed, dest( $write ) ) );
            // .pipe( dest( $write ) );
        done();
    };
}

/**
 * Our checker to see if the file is fixed or not
 * @param file
 * @returns {boolean|*}
 */
function isFixed (file) {
    return file.eslint !== null && file.eslint.fixed;
}

/**
 * Our File Watcher
 */
function fileWatcher () {
    watch( _css.admin.watch, adminCSS );
    watch( _css.public.watch, publicCSS );
    watch( _js.admin.watch, adminJS );
    watch( _js.public.watch, publicJS );
}

//</editor-fold>

/*======================================
	Executions
======================================*/

exports.js = series( parallel( adminJS, publicJS ) );
exports.css = series( parallel( adminCSS, publicCSS ) );
exports.admin = series( parallel( adminCSS, adminJS ) );
exports.public = series( parallel( publicCSS, publicJS ) );
exports.watcher = series( fileWatcher );
exports.default = series(
    parallel( adminCSS, publicCSS ),
    parallel( adminJS, publicJS ),
	fileWatcher,
);
