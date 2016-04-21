'use strict';
 
module.exports = function(grunt) {
 
	var globalConfig = {
		images : 'public/images',
		styles : 'public/css',
		fonts : 'public/fonts',
		scripts : 'public/js',
		src : 'src',
		srcjs : 'src/js/',
		bower_path : 'bower_components',
		jqui : 'bower_components/jquery-ui/ui/minified'
	};
 
	grunt.initConfig({
		globalConfig : globalConfig,
		pkg : grunt.file.readJSON('package.json'),

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
					// Jquery UI Autocomplete Concat
						'<%= globalConfig.jqui %>/core.min.js',
						'<%= globalConfig.jqui %>/widget.min.js',
						'<%= globalConfig.jqui %>/position.min.js',
						'<%= globalConfig.jqui %>/menu.min.js',
						'<%= globalConfig.jqui %>/autocomplete.min.js',
						// '<%= globalConfig.bower_path %>/jquery-ui/jquery-ui.min.js',
					// Bootstrap
						'<%= globalConfig.bower_path %>/bootstrap/dist/js/bootstrap.min.js',
					// Jasny-Bootstrap
						'<%= globalConfig.bower_path %>/jasny-bootstrap/dist/js/jasny-bootstrap.min.js',

				// Concat My JS files
					// Commons
						'<%= globalConfig.srcjs %>commons.js',
					// $http Promise Deffer
						'<%= globalConfig.srcjs %>$http.js',
					// Debugger
						'<%= globalConfig.srcjs %>debugger.js',
					// App Cache Update
						'<%= globalConfig.srcjs %>appCacheUpdate.js',
					// Preloader XHR
						'<%= globalConfig.srcjs %>preloader.js',
					// Counter for Menu
						// '<%= globalConfig.srcjs %>counter.js'
					// ICD
						'<%= globalConfig.srcjs %>icd.js'
				],
				dest: '<%= globalConfig.scripts %>/app.min.js'
			}
		},
		// Uglify - make code UnReadable
		uglify: {
			options: {
				// preserveComments: 'some'
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
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');

	// Default task(s).
	grunt.registerTask('default', [ 
		'cssmin', 
		// 'min', 
		'concat',
		'uglify'
		]);
};