// ---------------------------------------------
// Gruntfile.js
// ---------------------------------------------

module.exports = function(grunt) {

	// ---------------------------------------------
	// Project configuration
	// ---------------------------------------------
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		// ---------------------------------------------
		// watch
		// ---------------------------------------------
		watch: {
			test: {
				files: ['src/**/*.php', 'tests/**/*.php'],
				tasks: ['phpunit']
			}
		},

		// ---------------------------------------------
		// phpUnit
		// ---------------------------------------------
		phpunit: {
			all: {
				dir: 'tests'
			},
			options: {
				bin: __dirname + '/vendor/bin/phpunit',
				colors: true
			}
		}
	});

	// ---------------------------------------------
	// Load plugins
	// ---------------------------------------------
	grunt.loadNpmTasks('grunt-phpunit');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-ivantage-svn-release');

	// ---------------------------------------------
	// Register tasks
	// ---------------------------------------------
	grunt.registerTask('default', ['watch']);
}
