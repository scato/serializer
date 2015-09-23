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
    behat: {
        app: {
            cmd: 'vendor/bin/behat',
            features: 'features/'
        }
    },
    watch: {
      specs: {
        files: '<%= phpspec.app.specs %>**/*.php',
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
  grunt.loadNpmTasks('grunt-behat');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task.
  grunt.registerTask('default', ['phpcs', 'phpmd', 'phpspec', 'behat']);

  // Pre-commit task.
  grunt.registerTask('pre-commit', ['phpcs', 'phpspec']);

};
