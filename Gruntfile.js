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
        standard: 'phpcs.xml'
      }
    },
    phpmd: {
      application: {
        dir: 'src'
      },
      options: {
        bin: 'vendor/bin/phpmd',
        reportFormat: 'text',
        rulesets: 'codesize,controversial,design,naming,unusedcode'
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
  grunt.loadNpmTasks('grunt-phpmd');
  grunt.loadNpmTasks('grunt-phpspec');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task.
  grunt.registerTask('default', ['phpcs', 'phpmd', 'phpspec']);

};