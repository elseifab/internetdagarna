<?php
namespace Deployer;
require 'vendor/autoload.php';
require 'vendor/deployer/deployer/recipe/composer.php';

// This code is hosted in Github. Out deployment needs to fetch code checked in to the repo.
set('repository', 'git@github.com:elseifab/idwp.git');

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
    ->identityFile();

/**
 * Initialize the WordPress install in our Vagrant
 * Call it with `vendor/bin/dep startup dev`
 */
task('startup', function() {
    $output = run("vendor/bin/wp core install --url=internetdagarna.app --title=Internetdagarna --admin_user=admin --admin_password=admin --admin_email=andreas@elseif.se");
    writeln($output);
    $output = run("vendor/bin/wp core language install sv_SE --activate");
    writeln($output);
    $output = run("vendor/bin/wp theme activate min");
    writeln($output);
    $output = run("vendor/bin/wp rewrite structure %postname%");
    writeln($output);
    $output = run("vendor/bin/wp rewrite flush");
    writeln($output);
});

/**
 * Fills our simple theme with WordPress test data
 */
task('testdata', function () {
    $output = run('curl -O https://raw.githubusercontent.com/manovotny/wptest/master/wptest.xml');
    writeln($output);
    $output = run('vendor/bin/wp plugin install wordpress-importer --activate');
    writeln($output);
    $output = run('vendor/bin/wp import wptest.xml --authors=create');
    writeln($output);
    $output = run('vendor/bin/wp plugin uninstall wordpress-importer --deactivate');
    writeln($output);
    $output = run('rm wptest.xml');
    writeln($output);
});

/**
 * Initialize a simple UI-test before deployment to the production environment
 */
task('tests', function () {
    $output = run('vendor/bin/phpunit tests');
    writeln($output);
})->addBefore('deploy:prepare');
