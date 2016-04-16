'use strict';
 
module.exports = function(grunt) {
 
  var globalConfig = {
    images : 'public/img',
    styles : 'public/css',
    fonts : 'public/fonts',
    scripts : 'public/js',
    src : 'src',
    bower_path : 'bower_components'
  };
 
  grunt.initConfig({
    globalConfig : globalConfig,
    pkg : grunt.file.readJSON('package.json'),

    concat: {
      bootstrap: {
        src: [
          '<%= globalConfig.bower_path %>/bootstrap/js/transition.js',
          '<%= globalConfig.bower_path %>/bootstrap/js/alert.js',
          '<%= globalConfig.bower_path %>/bootstrap/js/button.js',
        ],
        dest: '<%= globalConfig.src %>/<%= pkg.name %>.js'
      }
    },
    uglify: {
      options: {
        preserveComments: 'some'
      },
      core: {
        src: '<%= concat.bootstrap.dest %>',
        dest: '<%= globalConfig.scripts %>/<%= pkg.name %>.min.js'
      },
      customize: {
        src: '<%= globalConfig.src %>/app.js',
        dest: '<%= globalConfig.scripts %>/app.min.js'
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
 
  // Default task(s).
  #grunt.registerTask('default', ['concat','uglify']);
};