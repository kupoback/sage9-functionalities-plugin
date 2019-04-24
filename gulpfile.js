// Gulp Variables
const {
	src,
	dest,
	watch,
	series,
	parallel,
} = require( "gulp" );

// Gulp Plugins
const autoprefixer = require( "autoprefixer" );
const babel = require( "gulp-babel" );
const concat = require( "gulp-concat" );
const cssnano = require( "cssnano" );
const eslint = require( "gulp-eslint" );
const globbing = require( "gulp-css-globbing" );
const gulpIf = require( "gulp-if" );
const flatten = require( "gulp-flatten" );
const plumber = require( "gulp-plumber" );
const postcss = require( "gulp-postcss" );
const rename = require( "gulp-rename" );
const sass = require( "gulp-sass" );
const sourcemaps = require( "gulp-sourcemaps" );
const terser = require( "gulp-terser" );
const uglify = require( "gulp-uglify" );

// Files and Functions
const writeDec = {
	admin: "./admin/dist",
	public: "./public/dist",
};
const cssDec = {
	admin: {
		fileName: "cf-admin",
		read: "./admin/css/cf-admin.scss",
		watch: "./admin/css/**/*",
	},
	public: {
		fileName: "cf-public",
		read: "./public/css/cf-public.scss",
		watch: "./public/css/**/*",
	},
};
const jsDec = {
	admin: {
		fileName: "cf-admin",
		read: "./admin/js",
		watch: "./admin/js/**/*",
	},
	public: {
		fileName: "cf-public",
		read: "./public/js",
		watch: "./public/js/**/*",
	},
};

//  Functions

//  <editor-fold desc="Functions">
/**
 * Our Error Handle
 * @param {string} err Returns the error of the function
 */
function handleError( err ) {
	console.log( err.toString() );
	this.emit( "end" );
}

/**
 * Description: Our checker to see if the file is fixed or not
 * @param {string} file The file that we're to pass into the checker
 * @returns {boolean|*} Checks if the file is correct
 */
function isFixed( file ) {
	return file.eslint !== null && file.eslint.fixed;
}

/**
 * Our SASS Compiler
 * @param {string} $read The file we're looking at
 * @param {string} $write The location of the output
 * @returns {Function} The function that executes our compiler
 */
function sassCompile( $read, $write ) {
	const pluginOpts = [
		autoprefixer( {
			browsers: [ "cover 99.5%" ],
		} ),
		cssnano(),
	];
	return function sassCompiler( done ) {
		src( [ `${ $read }` ] )
			.pipe( plumber( {
				errorHandler: handleError,
			} ) )
			.pipe( flatten() )
			.pipe( sourcemaps.init() )
			.pipe( globbing( {
				extensions: ".scss",
			} ) )
			.pipe( sass().on( "error", sass.logError ) )
			.pipe( postcss( pluginOpts ) )
			.pipe( rename( {
				suffix: ".min",
			} ) )
			.pipe( sourcemaps.write( "." ) )
			.pipe( plumber.stop() )
			.pipe( dest( $write ) );
		done();
	};
}

/**
 * Our JS Compiler
 * @param {string} $filename The filename we're watching
 * @param {string} $read The location of our watcher
 * @param {string} $write The output of our compiled file
 * @returns {Function} The function that executes our compiler
 */
function jsCompile( $filename, $read, $write ) {
	return function jsCompiler( done ) {
		src( [ `${ $read }/**/*.js*` ] )
			.pipe( plumber( {
				errorHandler: handleError,
			} ) )
			.pipe( eslint( {
				fix: true,
				quiet: true,
			} ) )
			.pipe( eslint.format() )
			.pipe( eslint.results( ( results ) => {
				// Called once for all ESLint results.
				console.log( `${ $filename } Results: ${ results.length }` );
				console.log( `Total Warnings: ${ results.warningCount }` );
				console.log( `Total Errors: ${ results.errorCount }` );
			} ) )
			.pipe( eslint.failAfterError() )
			.pipe( sourcemaps.init() )
			.pipe( babel( {
				presets: [
					"@babel/preset-env",
					"@babel/react",
				],
			} ) )
			.pipe( terser() )
			.pipe( rename( {
				suffix: ".min",
			} ) )
			.pipe( concat( `${ $filename }.min.js` ) )
			.pipe( uglify() )
			.pipe( sourcemaps.write( "./" ) )
			.pipe( plumber.stop() )
			.on( "error", handleError )
			.pipe( gulpIf( isFixed, dest( $write ) ) );
		done();
	};
}

// Function Variables
const adminCSS = sassCompile( cssDec.admin.read, "./admin/dist" );
const publicCSS = sassCompile( cssDec.public.read, writeDec.public );
const adminJS = jsCompile(
	jsDec.admin.fileName, jsDec.admin.read, "./admin/dist"
);
const publicJS = jsCompile(
	jsDec.public.fileName, jsDec.public.read, writeDec.public
);

/**
 * Our File Watcher
 */
function fileWatcher() {
	watch( cssDec.admin.watch, adminCSS );
	watch( cssDec.public.watch, publicCSS );
	watch( jsDec.admin.watch, adminJS );
	watch( jsDec.public.watch, publicJS );
}

//  </editor-fold>

//  Executions
exports.js = series( parallel( adminJS, publicJS ) );
exports.css = series( parallel( adminCSS, publicCSS ) );
exports.admin = series( parallel( adminCSS, adminJS ) );
exports.public = series( parallel( publicCSS, publicJS ) );
exports.watcher = series( fileWatcher );
exports.default = series(
	parallel( adminCSS, publicCSS ),
	parallel( adminJS, publicJS ),
	fileWatcher
);
