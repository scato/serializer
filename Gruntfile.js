/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // Task configuration.
    phpcs: {
      application: {
        src: ['src/**/*.php']
      },
      options: {
        bin: 'vendor/bin/phpcs',
        standard: 'PSR2'
      }
    },
    phpspec: {
        app: {
            specs: 'spec/'
        },
        options: {
            prefix: 'vendor/bin/'
        }
    },
    watch: {
      specs: {
        files: '<%= phpspec.app.specs %>',
        tasks: ['phpspec']
      },
      src: {
        files: '<%= phpcs.application.src %>',
        tasks: ['phpcs', 'phpspec']
      }
    }
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-phpcs');
  grunt.loadNpmTasks('grunt-phpspec');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task.
  grunt.registerTask('default', ['phpcs', 'phpspec']);

};
