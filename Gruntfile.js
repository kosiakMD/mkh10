'use strict';
 
module.exports = function(grunt) {

	var dist = 'dist/';
	var publicPath = dist + 'public/';
	var globalConfig = {
		version: '1.6.0',
		bower: 'bower_components',
		src: 'src',
		public: publicPath,
		src_img: 'src/img',
		img: publicPath + 'img',
		src_db: 'src/db',
		db: publicPath + 'db',
		src_css: 'src/css',
		css: publicPath + 'css',
		fonts: publicPath + 'fonts',
		src_js: 'src/js',
		js: publicPath + 'js',
		jqui: 'bower_components/jquery-ui/ui/minified',
		bsjs: 'bower_components/bootstrap/js'
	};

	// var saveLicense = require('uglify-save-license');
	// var mozjpeg = require('imagemin-mozjpeg');

	grunt.initConfig({
		globalConfig: globalConfig,
		pkg: grunt.file.readJSON('package.json'),
		asd: 'someText',
		jshint: {
			all: ['Gruntfile.js', '<%= concat.js.dest %>' ] //'src/js/**/*.js']
		},
		imagemin: {                          // Task 
			/*static: {                          // Target 
				options: {                       // Target options 
					optimizationLevel: 3,
					svgoPlugins: [{ removeViewBox: false }],
					use: [mozjpeg()]
				},
				files: {                         // Dictionary of files 
					// 'destination': 'source' 
					public + 'img/who.png': 'src/img/who.png',
					public + 'img/who150.png': 'src/img/who150.png',
					public + 'img/vk.png': 'src/img/vk.png',
					public + 'img/tw.png': 'src/img/tw.png',
					public + 'img/mkh.jpg': 'src/img/mkh.jpg',
					public + 'img/pay_lp.png': 'src/img/pay_lp.png',
					public + 'img/pay_pb.png': 'src/img/pay_pb.png',
					public + 'img/pay_pp.png': 'src/img/pay_pp.png',
					public + 'img/pay_wm.png': 'src/img/pay_wm.png',
					public + 'img/pay_ym.png': 'src/img/pay_ym.png',
					public + 'img/WMB.png': 'src/img/WMB.png',
					public + 'img/WME.png': 'src/img/WME.png',
					public + 'img/WMG.png': 'src/img/WMG.png',
					public + 'img/WMR.png': 'src/img/WMR.png',
					public + 'img/WMU.png': 'src/img/WMU.png',
					public + 'img/WMX.png': 'src/img/WMX.png',
					public + 'img/WMZ.png': 'src/img/WMZ.png'
				}
			},*/
			dynamic: {                         // Another target 
				files: [{
					expand: true,                  // Enable dynamic expansion 
					cwd: '<%= globalConfig.src_img %>/',                   // Src matches are relative to this path 
					src: ['**/*.{png,jpg}'],   // Actual patterns to match 
					dest: '<%= globalConfig.img %>/'                  // Destination path prefix 
				}]
			}
		},
		autoprefixer: {
			dist: {
				files: {
					'<%= globalConfig.src_css %>/style.autoprefixer.css': '<%= globalConfig.src_css %>/style.css'
				}
			}
		},
		// Compress my CSS files
		cssmin: {
			dist: {
				src: [
					'<%= globalConfig.src_css %>/style.css'
				],
				dest: '<%= globalConfig.src_css %>/style.min.css'
			}
		},
		// Compress my JS files
		min: {
			dist: {
				src: [
					'<%= globalConfig.scripts %>/icd.js'
				],
				dest: '<%= globalConfig.scripts %>/icd.min.js'
			}
		},
		// Concat all my files and Libs
		concat: {
			options: {
				// separator: ";\n"
			},
			// concat JSON DataBase
			db: {
				// make array from 5 files of JSON objects
				options: {
					banner: '[',
					separator: ',',
					footer: ']'
				},
				src: [ 
					'<%= globalConfig.src_db %>/count.json ',
					'<%= globalConfig.src_db %>/classes.json ',
					'<%= globalConfig.src_db %>/blocks.json ',
					'<%= globalConfig.src_db %>/nosologies.json ',
					'<%= globalConfig.src_db %>/diagnoses.json ',
					],
				dest: '<%= globalConfig.db %>/db.json'
			},
			// Concat CSS files
			css: {
				src: [
				// Bootstrap CSS
					// '<%= globalConfig.bower %>/bootstrap/dist/css/bootstrap.min.css',
				// Bootstrap CSS Style
					'<%= globalConfig.src_css %>/spacelab.min.css',
				// Jasny CSS
					'<%= globalConfig.bower %>/jasny-bootstrap/dist/css/jasny-bootstrap.min.css',
				// My compressed CSS
					'<%= cssmin.dist.dest %>'
				// My Uncompressed CSS
					// '<%= globalConfig.src_css %>/style.css'
				],
				dest: '<%= globalConfig.css %>/all.min.css'
			},
			// Concat JS Vendors & Libraries
			// jsLibs: {
				// src: [],
				// dest: ''
			// },
			// Concat My JS
			js: {
				src: [
					// Concat JS Libraries
					// Jquery
						'<%= globalConfig.bower %>/jquery/dist/jquery.min.js',
						// '<%= globalConfig.bower %>/jquery/dist/jquery.slim.min.js',
					// Jquery UI
						// '<%= globalConfig.bower %>/jquery-ui/jquery-ui.min.js',
					// Jquery UI Autocomplete Concat
						'<%= globalConfig.jqui %>/core.min.js',
						'<%= globalConfig.jqui %>/widget.min.js',
						'<%= globalConfig.jqui %>/position.min.js',
						'<%= globalConfig.jqui %>/menu.min.js',
						'<%= globalConfig.jqui %>/autocomplete.min.js',
					// Bootstrap
						// '<%= globalConfig.bower %>/bootstrap/dist/js/bootstrap.min.js',
					// Bootstrap JS Concat
						'<%= globalConfig.bsjs %>/button.js',
						'<%= globalConfig.bsjs %>/tab.js',
						'<%= globalConfig.bsjs %>/modal.js',
						'<%= globalConfig.bsjs %>/tooltip.js',
						'<%= globalConfig.bsjs %>/transition.js',
						'<%= globalConfig.bsjs %>/collapse.js',
						'<%= globalConfig.bsjs %>/dropdown.js',
					// Jasny-Bootstrap
						'<%= globalConfig.bower %>/jasny-bootstrap/dist/js/jasny-bootstrap.min.js',
					// All My JS Files
					// '<%= globalConfig.srcjs %>*.js'
					//
					// Concat My JS files
					// Commons
						'<%= globalConfig.src_js %>/commons.js',
					// Router
						'<%= globalConfig.src_js %>/router.js', // Web
					// Preloader XHR
						'<%= globalConfig.src_js %>/preloader.js', // Web
					// $http Promise Deffer
						'<%= globalConfig.src_js %>/$http.js',
					// Debugger
						'<%= globalConfig.src_js %>/debugger.js', // ALL
					// App Cache Update
						'<%= globalConfig.src_js %>/appCacheUpdate.js',
					// Counter for Menu
						// '<%= globalConfig.srcjs %>counter.js',
					// ICD
						'<%= globalConfig.src_js %>/icd.js',
					// initRouter
						'<%= globalConfig.src_js %>/iniRouter.js', // Web
					// catalogView
						'<%= globalConfig.src_js %>/catalogViewMode.js' // Web and Desktop
				],
				dest: '<%= globalConfig.js %>/app.js'
			},
			moveJsFiles: {
				src: ['<%= globalConfig.src_js %>/sw.js'],
				dest: '<%= globalConfig.js %>/sw.js'
			}
		},
		// Uglify - make code UnReadable
		uglify: {
			options: {
				// preserveComments: saveLicense,
				// preserveComments: 'some',
				banner: '/*! <%= pkg.name %> - v<%= globalConfig.version %> -' +
					' <%= grunt.template.today("yyyy-mm-dd") %>\n' +
					' * МКХ-10 https://mkh10.com.ua\n' +
					' * Anton Kosiak\n' +
					' * kosiakMD@yandex.ua *\n' +
					' *! jQuery v2.2.3 | (c) jQuery Foundation | jquery.org/license *\n' +
					' *! jQuery UI - v1.11.4 - http://jqueryui.com - Copyright jQuery Foundation and other contributors; Licensed MIT *\n' +
					' *! Bootstrap: v3.3.6 - http://getbootstrap.com/javascript/#modals - Copyright 2011-2015 Twitter, Inc.' +
					' * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE) */\n\n'
			},
			js: {
				src: '<%= concat.js.dest %>',
				dest: '<%= globalConfig.js %>/app.min.js'
			}
			/*css: {
				src: [
					'<%= globalConfig.src_css %>/style.css'
				],
				dest: '<%= globalConfig.src_css %>/style.min.css'
			}*/
		},
		watch: {
			configFiles: {
				files: [ 'Gruntfile.js', 'config/*.js' ],
				tasks: [
					'concat:js'
					, 'uglify:js'
					, 'concat:css'
				],
				options: {
					reload: true
				}
			},
			js: {
				files: [
					'<%= globalConfig.src_js %>/*.js'
				],
				tasks: [
					'concat:js'
					, 'uglify:js'
				],
				options: {
					spawn: false,
				}
			},
			css: {
				files: [ '<%= globalConfig.src_css %>/style.css' ],
				tasks: [ 'cssmin', 'concat:css' ],
				options: {
					spawn: false,
				}
			}
		},
	});

	// load plugn for task(s)
	// grunt.loadNpmTasks('grunt-yui-compressor');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-contrib-watch');
 
	// Default task(s).
	grunt.registerTask('default', [ 
		'cssmin',
		// 'min',
		'concat',
		// 'jshint',
		'uglify',
		// 'imagemin',
		// 'autoprefixer',
		 'watch',
	]);
};
