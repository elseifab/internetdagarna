<?php
/**
 * Here we load vendor packages as global default to WordPress to use it inside our methods, plugins and themes.
 * This bootstrap is used when running WP both with WP CLI, plain web and also when testing.
 * Split this file into different kind to get a more testable and isolated web with phpunit,
 * perhaps with staged env-parameters?
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Loading Dotenv with required parameters
$dotenv = new Dotenv\Dotenv(dirname(__DIR__));
$dotenv->load();
$dotenv->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD', 'WP_HOME']);

// Mandatory parameters from .env
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('WP_HOME', getenv('WP_HOME'));

// Optional parameters from .env
$table_prefix = getenv('DB_PREFIX') ? getenv('DB_PREFIX') : 'wp_';
define('DB_HOST', getenv('DB_HOST') ? getenv('DB_HOST') : 'localhost');
define('WP_LANG', getenv('WP_LANG') ? getenv('WP_LANG') : 'sv_SE');

// Moving WP with custom path
define('WP_SITEURL', WP_HOME . '/wp');
define('WP_CONTENT_DIR', __DIR__ . '/wp-content');
define('WP_CONTENT_URL', WP_HOME . '/wp-content');

// Only updates via composer
define('AUTOMATIC_UPDATER_DISABLED', true);

// Never, ever change files via web ui
define('DISALLOW_FILE_EDIT', true);

// Set ABSPATH that is used globally in WP, themes and plugins
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/web/wp');
}
