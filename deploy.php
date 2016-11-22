<?php
namespace Deployer;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/deployer/deployer/recipe/composer.php';

// This code is hosted in Github. Out deployment needs to fetch code checked in to the repo.
set('repository', 'git@github.com:elseifab/internetdagarna.git');
set('shared_dirs', ['public/wp-content/uploads']);
set('shared_files', ['.env']);

// Development connection
server('dev', 'internetdagarna.dev')
    ->set('deploy_path', '~/internetdagarna')
    ->stage('development')
    ->user('vagrant')
    ->identityFile();

// Production connection, in my case a VPS with Git and Composer installed in a Ubuntu server. Using Forge as manager.
server('production', 'elseif.se', 22)
    ->set('deploy_path', '~/internetdagarna.elseif.se')
    ->stage('production')
    ->user('forge')
    ->set('branch','develop')
    ->identityFile();

/**
 * Initialize the WordPress install in our Vagrant
 * Call it with `vendor/bin/dep initwp dev`
 */
task('initwp', function() {
    $output = run("vendor/bin/wp core install --url=internetdagarna.app --title=Internetdagarna --admin_user=admin --admin_password=admin --admin_email=andreas@elseif.se");
    writeln($output);
    $output = run("vendor/bin/wp core language install sv_SE --activate");
    writeln($output);
    $output = run("vendor/bin/wp theme activate twentysixteen");
    writeln($output);
    $output = run("vendor/bin/wp plugin activate ilmenite-cookie-consent");
    writeln($output);
    $output = run("vendor/bin/wp rewrite structure %postname%");
    writeln($output);
    $output = run("vendor/bin/wp rewrite flush");
    writeln($output);
});

/**
 * Install global npm packages to provide with a CasperJS engine
 */
task('startup:tests', function() {
    writeln("Setting up CasperJS to support testing...");
    $output = run("sudo npm install -g phantomjs && sudo npm install -g casperjs");
    writeln($output);
})->onlyOn('development');

after('startup', 'startup:tests');

/**
 * Fills our simple theme with WordPress test data
 */
task('testdata', function () {
    $output = run('curl -O https://wpcom-themes.svn.automattic.com/demo/theme-unit-test-data.xml');
    writeln($output);
    $output = run('vendor/bin/wp plugin install wordpress-importer --activate');
    writeln($output);
    $output = run('vendor/bin/wp import theme-unit-test-data.xml --authors=create');
    writeln($output);
    $output = run('vendor/bin/wp plugin uninstall wordpress-importer --deactivate');
    writeln($output);
    $output = run('rm theme-unit-test-data.xml');
    writeln($output);
});

/**
 * Initialize a simple UI-test locally on dev
 */
task('tests', function () {
    writeln('Vagrant Unit tests with CasperJs starting up...');
    $output = run("cd ~/internetdagarna/ && vendor/bin/phpunit");
    writeln($output);
})->onlyOn('dev');
