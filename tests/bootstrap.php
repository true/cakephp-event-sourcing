<?php
/**
 * Test runner bootstrap.
 *
 * Add additional configuration/setup your application needs when running
 * unit tests in this file.
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use josegonzalez\Dotenv\Loader;

require dirname(__DIR__) . '/vendor/autoload.php';

/*
 * The full path to the directory which holds "src", WITHOUT a trailing DS.
 */
define('ROOT', dirname(__FILE__) . DS . 'test_app');

/*
 * The actual directory name for the application directory. Normally
 * named 'src'.
 */
define('APP_DIR', '');

/*
 * Path to the application's directory.
 */
define('APP', ROOT . DS . APP_DIR . DS);

/*
 * The absolute path to the "cake" directory, WITHOUT a trailing DS.
 *
 * CakePHP should always be installed with composer, so look there.
 */
define('CAKE_CORE_INCLUDE_PATH', dirname(__FILE__, 2) . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp');

/*
 * Path to the cake directory.
 */
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);

Configure::write('App.namespace', 'App');

$files = [
    dirname(__DIR__, 3) . DS . 'config' . DS . 'ocs.env',
    dirname(__DIR__) . DS . 'config' . DS . 'local.env',
];

try {
    (new Loader($files))
        ->parse()
        ->skipExisting([
            'putenv',
        ])
        ->putenv();
} catch (InvalidArgumentException $exception) {
    throw new InvalidArgumentException(sprintf(
        'Environment files does not seems to be accessible: %s.',
        implode(', ', $files)
    ), $exception->getCode(), $exception);
}

$requiredEnvironmentVariables = [
    'DEBUG',
    'DATABASE_TEST_URL',
];
foreach ($requiredEnvironmentVariables as $environmentVariable) {
    if (env($environmentVariable) !== null) {
        continue;
    }

    throw new RuntimeException(sprintf('You need to define %s in your environment', $environmentVariable));
}
unset($files, $requiredEnvironmentVariables, $environmentVariable);

ConnectionManager::setConfig('test', [
    'url' => env('DATABASE_TEST_URL'),
]);
ConnectionManager::alias('test', 'default');

Cache::setConfig('_cake_core_', [
    'className' => 'Null'
]);

$_SERVER['PHP_SELF'] = '/';
