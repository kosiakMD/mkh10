'use strict';
 
module.exports = function(grunt) {
 
	var globalConfig = {
		version : '1.6.0',
		src_img : 'src/img',
		img : 'public/img',
		src_db : 'src/db',
		db : 'public/db',
		styles : 'public/css',
		fonts : 'public/fonts',
		scripts : 'public/js',
		src : 'src',
		srcjs : 'src/js/',
		bower_path : 'bower_components',
		jqui : 'bower_components/jquery-ui/ui/minified',
		bsjs : 'bower_components/bootstrap/js'
	};

	var saveLicense = require('uglify-save-license');
	var mozjpeg = require('imagemin-mozjpeg');

	grunt.initConfig({
		globalConfig : globalConfig,
		pkg : grunt.file.readJSON('package.json'),

		jshint: {
			all: ['Gruntfile.js', 'src/js/**/*.js']
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
					'public/img/who.png': 'src/img/who.png',
					'public/img/who150.png': 'src/img/who150.png',
					'public/img/vk.png': 'src/img/vk.png',
					'public/img/tw.png': 'src/img/tw.png',
					'public/img/mkh.jpg': 'src/img/mkh.jpg',
					'public/img/pay_lp.png': 'src/img/pay_lp.png',
					'public/img/pay_pb.png': 'src/img/pay_pb.png',
					'public/img/pay_pp.png': 'src/img/pay_pp.png',
					'public/img/pay_wm.png': 'src/img/pay_wm.png',
					'public/img/pay_ym.png': 'src/img/pay_ym.png',
					'public/img/WMB.png': 'src/img/WMB.png',
					'public/img/WME.png': 'src/img/WME.png',
					'public/img/WMG.png': 'src/img/WMG.png',
					'public/img/WMR.png': 'src/img/WMR.png',
					'public/img/WMU.png': 'src/img/WMU.png',
					'public/img/WMX.png': 'src/img/WMX.png',
					'public/img/WMZ.png': 'src/img/WMZ.png'
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
		// Compress my CSS files
		cssmin: {
			dist: {
				src: [
					'<%= globalConfig.styles %>/style.css'
				],
				dest: '<%= globalConfig.styles %>/style.min.css'
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
			optinos: {},
			db: {
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
					// '<%= globalConfig.bower_path %>/bootstrap/dist/css/bootstrap.min.css',
				// Bootstrap CSS Style
					'<%= globalConfig.styles %>/spacelab.min.css',
				// Jasny CSS
					'<%= globalConfig.bower_path %>/jasny-bootstrap/dist/css/jasny-bootstrap.min.css',
				// My compressed CSS
					'<%= cssmin.dist.dest %>'
				],
				dest: '<%= globalConfig.styles %>/all.min.css'
			},
			// Concat JS
			js: {
				src: [
				// Concat JS Libraries
					// Jquery
						'<%= globalConfig.bower_path %>/jquery/dist/jquery.min.js',
						// '<%= globalConfig.bower_path %>/jquery/dist/jquery.slim.min.js',
					// Jquery UI
						// '<%= globalConfig.bower_path %>/jquery-ui/jquery-ui.min.js',
					// Jquery UI Autocomplete Concat
						'<%= globalConfig.jqui %>/core.min.js',
						'<%= globalConfig.jqui %>/widget.min.js',
						'<%= globalConfig.jqui %>/position.min.js',
						'<%= globalConfig.jqui %>/menu.min.js',
						'<%= globalConfig.jqui %>/autocomplete.min.js',
					// Bootstrap
						// '<%= globalConfig.bower_path %>/bootstrap/dist/js/bootstrap.min.js',
					// Bootstrap JS Concat
						'<%= globalConfig.bsjs %>/button.js',
						'<%= globalConfig.bsjs %>/tab.js',
						'<%= globalConfig.bsjs %>/modal.js',
						'<%= globalConfig.bsjs %>/tooltip.js',
						'<%= globalConfig.bsjs %>/transition.js',
						'<%= globalConfig.bsjs %>/collapse.js',
						'<%= globalConfig.bsjs %>/dropdown.js',
					// Jasny-Bootstrap
						'<%= globalConfig.bower_path %>/jasny-bootstrap/dist/js/jasny-bootstrap.min.js',
				// All My JS Files
					'<%= globalConfig.srcjs %>*.js'
				// Concat My JS files
					// Commons
						// '<%= globalConfig.srcjs %>commons.js',
					// $http Promise Deffer
						// '<%= globalConfig.srcjs %>$http.js',
					// Debugger
						// '<%= globalConfig.srcjs %>debugger.js',
					// App Cache Update
						// '<%= globalConfig.srcjs %>appCacheUpdate.js',
					// Preloader XHR
						// '<%= globalConfig.srcjs %>preloader.js',
					// Counter for Menu
						// '<%= globalConfig.srcjs %>counter.js'
					// ICD
						// '<%= globalConfig.srcjs %>icd.js'
				],
				dest: '<%= globalConfig.scripts %>/app.min.js'
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
					' * kosiakMD@yandex.ua */\n' +
					'/*! jQuery v2.2.3 | (c) jQuery Foundation | jquery.org/license */\n' +
					'/*! jQuery UI - v1.11.4 - http://jqueryui.com - Copyright jQuery Foundation and other contributors; Licensed MIT */\n' +
					'/*! Bootstrap: v3.3.6 - http://getbootstrap.com/javascript/#modals - Copyright 2011-2015 Twitter, Inc.\n' +
					' * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE) */\n'
			},
			/*core: {
				src: '<%= concat.bootstrap.dest %>',
				dest: '<%= globalConfig.scripts %>/<%= pkg.name %>.min.js'
			},*/
			customize: {
				src: '<%= concat.js.dest %>',
				dest: '<%= globalConfig.scripts %>/app.min.js'
			}
		}
	});

	// load plugn for task(s)
	// grunt.loadNpmTasks('grunt-yui-compressor');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-imagemin');

	// Default task(s).
	grunt.registerTask('default', [ 
		'cssmin'
		// ,'min' 
		,'concat'
		// ,'jshint'
		,'uglify'
		// ,'imagemin'
	]);
};
