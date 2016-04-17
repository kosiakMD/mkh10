'use strict';
 
module.exports = function(grunt) {
 
	var globalConfig = {
		images : 'public/images',
		styles : 'public/css',
		fonts : 'public/fonts',
		scripts : 'public/js',
		src : 'src',
		bower_path : 'bower_components'
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
					'<%= globalConfig.styles %>/spacelab.min.css',
					// Jasny CSS
					'<%= globalConfig.bower_path %>/jasny-bootstrap/dist/css/jasny-bootstrap.min.css',
					//My compressed CSS
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
					// Jquery UI
					'<%= globalConfig.bower_path %>/jquery-ui/dist/jquery-ui.min.js',
					// Bootstrap
					'<%= globalConfig.bower_path %>/bootstrap/dist/js/bootstrap.min.js',
					// Jasny 
					'<%= globalConfig.bower_path %>/jasny-bootstrap/dist/jasny-bootstrap.min.js',

				// Concat My JS files
					// ICD
					// '<%= globalConfig.scripts %>/icd.js'
					'<%= uglify.customize.dest %>'
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
				src: '<%= globalConfig.scripts %>/icd.js',
				dest: '<%= globalConfig.scripts %>/icd.min.js'
			}
		}
	});

	// load plugn for task(s)
	grunt.loadNpmTasks('grunt-yui-compressor');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');

	// Default task(s).
	grunt.registerTask('default', [ 'cssmin',/* 'min',*/ 'uglify', 'concat']);
};